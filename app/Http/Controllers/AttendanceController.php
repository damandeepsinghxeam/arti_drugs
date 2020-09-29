<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Employee;
use App\Attendance;
use App\AttendancePunch;
use App\AttendanceRemark;
use App\AttendanceChange;
use App\AttendanceChangeApproval;
use App\AttendanceChangeDate;
use App\AttendanceVerification;
use App\AttendanceResult;
use App\Company;
use App\Holiday;
use App\Project;
use App\Department;
use App\TravelApproval;
use App\TbltTimesheet;
use Auth;
use DB;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Exports\ConsolidatedAttendanceExport;
use App\Exports\AttendancePunchExport;
use App\Exports\SaralAttendanceExport;
use Maatwebsite\Excel\Facades\Excel;
use View;
use App\LeaveType;
use App\AppliedLeave;
use App\CompensatoryLeave;
use App\ShiftException;
use App\Shift;
use Session;
class AttendanceController extends Controller
{
    /*
        Get all the punches of a user marked from app of a given date
    */
    function viewMap(Request $request){
        if(!$request->has('id')){
            $user = Auth::user();
        }else{
            $user = User::find($request->id);
        }

        if(!$request->has('date')){
            $date = date("Y-m-d");
        }else{
            $date = date("Y-m-d",strtotime($request->date));
        }

        $username = $user->employee->fullname;

        $attendance = $user->attendances()
                           ->where(['on_date' => $date])
                           ->with(['attendancePunches'=>function($query){
                                $query->where('type','!=','NA');
                            }])
                           ->first(); 

        $attendance_locations = $user->attendanceLocations()
                                    ->whereDate('created_at',$date)
                                    ->get();  
        
        return view('attendances.view_map')->with(['attendance'=>$attendance,'attendance_locations'=>$attendance_locations,'date' => $date,'username'=>$username]);
    }

    /*
        Custom function used once to deduct leaves
    */
    function setToFeb()
    {
        $date = date("Y-m-d",strtotime('2019-12-27'));
        $applied_leaves = AppliedLeave::where('from_date',$date)
                                        ->where('to_date',$date)
                                        ->whereDate('created_at',$date)
                                        ->where(['final_status'=>'1','isactive'=>1])
                                        ->whereHas('appliedLeaveSegregations', function(Builder $query)use($date){
                                            $query->where('from_date',$date)
                                                  ->where('to_date',$date)
                                                  ->whereDate('created_at',$date)
                                                  ->where('unpaid_count','0');
                                        })->with('appliedLeaveSegregations')
                                          ->with('appliedLeaveApprovals')
                                          ->get();

        dd($applied_leaves);
          
        $newdate = date("Y-m-d",strtotime('2019-02-28'));
        $newdatetime = date("Y-m-d H:i:s",strtotime('2019-02-28'));
        foreach ($applied_leaves as $applied_leave) {
            $applied_leave->from_date = $newdate;
            $applied_leave->to_date = $newdate;
            $applied_leave->created_at = $newdatetime;
            $applied_leave->updated_at = $newdatetime;
            $applied_leave->save();

            $applied_leave->appliedLeaveSegregations[0]->to_date = $newdate;
            $applied_leave->appliedLeaveSegregations[0]->created_at = $newdatetime;
            $applied_leave->appliedLeaveSegregations[0]->updated_at = $newdatetime;
            $applied_leave->appliedLeaveSegregations[0]->from_date = $newdate; 
            $applied_leave->appliedLeaveSegregations[0]->save();

            $applied_leave->appliedLeaveApprovals[0]->created_at = $newdatetime;
            $applied_leave->appliedLeaveApprovals[0]->updated_at = $newdatetime;
            $applied_leave->appliedLeaveApprovals[0]->save();
        }
        echo "done";
    }
    
    function saveAttendancePunch(Request $request)  //Biometric
    {
    	$user = User::where(['employee_code'=>$request->employee_code])->first();
    	$on_date = date("Y-m-d",strtotime($request->on_date));

    	$attendance = $user->attendances()->where(['on_date'=>$on_date])->first();

    	if(empty($attendance)){
    		$data = [
    					'on_date' => $on_date,
    					'status' => 'Present'
    				];

    		$attendance = $user->attendances()->create($data);		
    	}

    	$on_time = date("H:i:s",strtotime($request->on_time));
    	$punch = $attendance->attendancePunches()->create(['on_time'=>$on_time]);

    }//end of function

    /* 
     * Show the user calendar display of his/her own attendance
    */
    function myAttendance(Request $request)
    {
        $user = User::where(['id'=>Auth::id()])
    				->with('employee')
    				->first();	

        $req['year'] = 0;
        $req['month'] = 0;    

        if($request->month){
            $req['month'] = $request->month;
        }

        if($request->year){
            $req['year'] = $request->year;
        }        

    	return view('attendances.my_attendance')->with(['user'=>$user,'req'=>$req]);

    }//end of function

    /* 
     * Show the user with permission of view-attendance, calendar display of other's attendance
    */
    function viewEmployeeAttendance(Request $request)
    {
        $user = User::where(['id'=>$request->id])
                    ->with('employee')
                    ->with(['leaveAuthorities'=>function($query){
                        $query->where('priority','2');
                    }])
                    ->first();  

        $req['year'] = 0;
        $req['month'] = 0;    

        if($request->month){
            $req['month'] = $request->month;
        }

        if($request->year){
            $req['year'] = $request->year;
        }

        $verify['isverified'] = 0; //not verified
        $verify['verifier'] = 0;

        $on_date = $req['year'].'-'.$req['month'].'-'.'1';
        $on_date = date('Y-m-d',strtotime($on_date));

        $verification = $user->attendanceVerifications()
                            ->where(['on_date'=>$on_date])
                            ->first();                    

        if(!empty($verification) && $verification->isverified == 1){
            $verify['isverified'] = 1;  //verified
        }

        if(!$user->leaveAuthorities->isEmpty()){
            if($user->leaveAuthorities[0]->manager_id == Auth::id()){
                $verify['verifier'] = $user->leaveAuthorities[0]->manager_id;
            }
        }                

        return view('attendances.view_attendance')->with(['user'=>$user,'req'=>$req,'verify'=>$verify]);

    }//end of function

    /* 
     * For changing or creating the attendance status of a user of a day.
     * Used by employee having the view-attendance permission.
    */
    function changeAttendanceStatus(Request $request)
    {
        $date = date("Y-m-d",strtotime($request->on_date));
        $attendance = Attendance::where(['user_id'=>$request->user_id,'on_date'=>$date])->first();

        if(!empty($attendance)){
            //$attendance->update(['status'=>$request->attendanceStatus]);

        }else{
            //$attendance = Attendance::create(['user_id'=>$request->user_id,'on_date'=>$date,'status'=>$request->attendanceStatus]);
        }
        
        if(!empty($request->on_time)){
            $time = $date.' '.$request->on_time;
            $time = date("H:i:s",strtotime($time));
            $punch = $attendance->attendancePunches()->where(['on_time'=>$time])->first();

            if(empty($punch)){
                //$attendance->attendancePunches()->create(['on_time'=>$time,'punched_by'=>Auth::id()]);
            }
        }

        return redirect($request->url);

    }//end of function

    /* 
     * Cron functionality for taking data from tblt timesheet table to
     * the attendance and attendance punches table. And also insert the
     * other status like Leave and Travel as well in attendance table.
    */
    function addBiometricToPunchesCron()
    {
        TbltTimesheet::where('ispunched',0)->chunk(50, function($biometrics){
            foreach ($biometrics as $biometric) {
                
                $user = User::whereHas('employee',function(Builder $query)use($biometric){
                            $query->where('employee_id',$biometric->punchingcode)
                                  ->where('isactive',1);  
                        })->first();        

                if(!empty($user)){
                    $attendance = $user->attendances()->where(['on_date'=>$biometric->date])->first();
                    
                    $datetimeString = $biometric->date.' '.$biometric->time;
                    $datetime = date("H:i:s",strtotime($datetimeString));

                    if(!empty($attendance)){
                        
                        $attendance_punch = $attendance->attendancePunches()->create(['on_time'=>$datetime]);
                        $biometric->ispunched = 1;
                        $biometric->save();

                        if($attendance->status == 'Absent'){
                            $attendance->status = 'Present';
                            $attendance->save();
                        }
                    }else {
                        $holiday = Holiday::where('holiday_from','<=',$biometric->date)
                                ->where('holiday_to','>=',$biometric->date)
                                ->where('isactive',1)
                                ->first();

                        if(!empty($holiday) && strtotime(date("Y-m-d H:i:s")) > strtotime($datetimeString)){
                            $attendance = $user->attendances()->create(['on_date'=>$biometric->date,'status'=>'Holiday']);
                        }else{
                            $leave = AppliedLeave::where('from_date','<=',$biometric->date)
                                                ->where('to_date','>=',$biometric->date)
                                                ->where(['final_status'=>'1','user_id'=>$user->id])
                                                ->first();
                
                            if(!empty($leave) && strtotime(date("Y-m-d H:i:s")) > strtotime($datetimeString)){
                                $attendance = $user->attendances()->create(['on_date'=>$biometric->date,'status'=>'Leave']);
                            }else{
                                $travel = TravelApproval::where(['isactive'=>1,'status'=>'approved','user_id'=>$user->id])
                                                    ->where('date_from','<=',$biometric->date)
                                                    ->where('date_to','>=',$biometric->date)
                                                    ->first();
                
                                if(!empty($travel) && strtotime(date("Y-m-d H:i:s")) > strtotime($datetimeString)){
                                    $attendance = $user->attendances()->create(['on_date'=>$biometric->date,'status'=>'Travel']);
                                }elseif(strtotime(date("Y-m-d H:i:s")) >= strtotime($datetimeString)){
                                    $attendance = $user->attendances()->create(['on_date'=>$biometric->date,'status'=>'Present']);
                                }
                            }       
                        }   
                        
                        if(!empty($attendance)){
                            $attendance_punch = $attendance->attendancePunches()
                                                        ->create(['on_time'=>$datetime]);
                            $biometric->ispunched = 1;
                            $biometric->save();
                        }
                    }
                }
            }
        });
        
        echo "cron ran successfully!";
        
    }//end of cron function

    /* 
     * Cron functionality for looping over the last month all dates and mark 
     * the status Absent in attendance table. Also create an entry for month's
     * first date in the attendance verification table.
    */
    function checkAbsentCron()
    {
        $current_date = date('Y-m-d');
        $current_month_second_date = config('constants.restriction.checkAbsentCron');
        $last_month_start_date = date('Y-m-01', strtotime('-1 months', strtotime($current_date))); 
        $last_month_end_date = date('Y-m-t', strtotime($last_month_start_date));

        if(strtotime(date("Y-m-d")) == strtotime($current_month_second_date)){ 
            $period = CarbonPeriod::create($last_month_start_date, $last_month_end_date);
            
            $dates = [];
            // Iterate over the period
            foreach ($period as $date) {
                $dates[] = $date->format('Y-m-d');
            }

            User::whereHas('employee',function(Builder $query){
                $query->where('isactive',1);
            })->chunk(50, function($users)use($dates){
                foreach ($users as $key => $user) {
                    foreach ($dates as $key => $date) {
                            $attendance = $user->attendances()->where(['on_date'=>$date])->first();

                            if(!empty($attendance)){
                                if($attendance->status == 'Present' || $attendance->status == 'Absent'){
                                    $leave = AppliedLeave::where('from_date','<=',$date)
                                                        ->where('to_date','>=',$date)
                                                        ->where(['final_status'=>'1','user_id'=>$user->id])
                                                        ->first();

                                    if(!empty($leave) && ($leave->leave_type_id != 6) && strtotime(date("Y-m-d H:i:s")) > strtotime($date)){
                                        $attendance->status = 'Leave';
                                        $attendance->save();
                                    }else{
                                        $travel = TravelApproval::where(['isactive'=>1,'status'=>'approved','user_id'=>$user->id])
                                                            ->where('date_from','<=',$date)
                                                            ->where('date_to','>=',$date)
                                                            ->first();
                        
                                        if(!empty($travel) && strtotime(date("Y-m-d H:i:s")) > strtotime($date)){
                                            $attendance->status = 'Travel';
                                            $attendance->save();
                                        }
                                    }                    
                                }
                            }else{
                                $holiday = Holiday::where('holiday_from','<=',$date)
                                                ->where('holiday_to','>=',$date)
                                                ->where('isactive',1)
                                                ->first();
            
                                if(!empty($holiday) && strtotime(date("Y-m-d H:i:s")) > strtotime($date)){
                                    $attendance = $user->attendances()->create(['on_date'=>$date,'status'=>'Holiday']);
                                }else{
                                    $leave = AppliedLeave::where('from_date','<=',$date)
                                                        ->where('to_date','>=',$date)
                                                        ->where(['final_status'=>'1','user_id'=>$user->id])
                                                        ->first();
                        
                                    if(!empty($leave) && strtotime(date("Y-m-d H:i:s")) > strtotime($date)){
                                        $attendance = $user->attendances()->create(['on_date'=>$date,'status'=>'Leave']);
                                    }else{
                                        $travel = TravelApproval::where(['isactive'=>1,'status'=>'approved','user_id'=>$user->id])
                                                            ->where('date_from','<=',$date)
                                                            ->where('date_to','>=',$date)
                                                            ->first();
                        
                                        if(!empty($travel) && strtotime(date("Y-m-d H:i:s")) > strtotime($date)){
                                            $attendance = $user->attendances()->create(['on_date'=>$date,'status'=>'Travel']);
                                        }elseif(strtotime(date("Y-m-d H:i:s")) > strtotime($date)){
                                            if(date("l",strtotime($date)) == 'Sunday'){
                                                $day_status = 'Week-Off';
                                            }else{
                                                $day_status = 'Absent';
                                            }
                                            $attendance = $user->attendances()->create(['on_date'=>$date,'status'=>$day_status]);
                                        }
                                    }       
                                }
                            }                              

                        $start_of_month = date("Y-m-01",strtotime($date));

                        if(!$user->leaveAuthorities->isEmpty()){
                            $hod_id = $user->leaveAuthorities[0]->manager_id;   
                        }else{
                            $hod_id = 1;
                        }

                        $verification = $user->attendanceVerifications()
                                                ->where(['on_date'=>$start_of_month])
                                                ->first();

                        if(empty($verification) && strtotime(date("Y-m-d h:i:s")) > strtotime($start_of_month)){
                            $verification = $user->attendanceVerifications()->create(['manager_id'=>$hod_id,'on_date'=>$start_of_month]);
                        }
                    }   
                }
            });
            echo "Cron ran";
        }else{
            echo "Cron did not ran";
        }
        
    }//end of function

    /* 
     * Ajax request for showing multiple attendance punches of a user.
    */
    function multiplePunches(Request $request)
    {
        $date = date("Y-m-d",strtotime($request->date));
        $attendance = Attendance::where(['on_date'=>$date,'user_id'=>$request->user_id])->first(); 

        $punches = $attendance->attendancePunches()->orderBy('on_time')->get();

        if(!$punches->isEmpty()){
            foreach ($punches as $key => $value) {
                $value->on_time = date("h:i A",strtotime($value->on_time));
            }
        }

        return $punches;

    }//end of function

    /* 
     * For saving the remarks added by user on a given date.
    */
    function saveRemarks(Request $request)
    {
        $url = $request->url;
        $date = date("Y-m-d",strtotime($request->on_date));

        $remark = AttendanceRemark::where(['user_id'=>$request->user_id,'on_date'=>$date])->first();

        if(!empty($remark)){
            $remark->remarks = $request->remarks;
            $remark->save();
        }else{
            AttendanceRemark::create(['user_id'=>$request->user_id,'on_date'=>$date,'remarks'=>$request->remarks]);
        }

        return redirect($url);

    }//end of function

    /* 
     * For filtering and displaying the monthly attendance of those employees only for
     * which Auth User is responsible.
    */
    function verifyAttendanceList(Request $request)
    {
        if($request->month){
            $req['month'] = $request->month;
        }else{
            $req['month'] = date("n");
        }

        if($request->year){
            $req['year'] = $request->year;
        }else{
            $req['year'] = date("Y");
        }

        if($request->employee_status != ""){
            $req['employee_status'] = $request->employee_status;
        }else{
            $req['employee_status'] = 1;
        }

        $month_last_date = date("Y-m-t",strtotime($req['year'].'-'.$req['month'].'-01'));

        $employees = DB::table('projects as p')
            ->join('project_user as pu','p.id','=','pu.project_id')
            ->join('employee_profiles as ep','ep.user_id','=','pu.user_id')
            ->join('employees as e','ep.user_id','=','e.user_id')
            ->join('users as u','ep.user_id','=','u.id')
            ->join('departments as d','d.id','=','ep.department_id')
            //->join('attendance_verifications as av','av.user_id','=','ep.user_id')
            ->join('leave_authorities as la','la.user_id','=','ep.user_id')
            ->where('e.user_id','!=',1)
            //->where(['av.manager_id'=>Auth::id()])
            ->where(['la.isactive'=>1,'la.priority'=>'2','la.manager_id'=>Auth::id()])
            //->whereYear('av.on_date',$req['year'])
            //->whereMonth('av.on_date',$req['month'])
            ->whereDate('e.joining_date','<=',$month_last_date)
            ->where(['pu.isactive'=>1,'p.isactive'=>1,'p.approval_status'=>'1','e.approval_status'=>'1','e.isactive'=>(int)$req['employee_status']])
            ->select('ep.user_id','d.name as department_name','e.fullname','u.employee_code','e.joining_date')
            ->get();
        
        if(!empty($req['year'])){
            $year = $req['year'];
            $month = $req['month'];
            $date = $year.'-'.$month.'-'.'01';
            $total_days = (int)date("t",strtotime($date));
            $holiday_counter = 0;
            $sunday_counter = 0;
            $holiday_array = [];
            $sunday_array = [];
            
            for ($i=1; $i <= $total_days ; $i++) {
                if($i >= 10){
                    $date = $year.'-'.$month.'-'.$i;
                }else{
                    $date = $year.'-'.$month.'-'.'0'.$i;
                } 
                $holiday = Holiday::where('holiday_from','<=',$date)
                            ->where('holiday_to','>=',$date)
                            ->where('isactive',1)
                            ->first();

                if(!empty($holiday) && date("l",strtotime($date)) != "Sunday"){
                    $holiday_counter += 1;
                    $holiday_array[] = $date;
                }elseif (date("l",strtotime($date)) == "Sunday") {
                    $sunday_counter += 1;
                    $sunday_array[] = $date;
                }
            }
            
            $data['holidays'] = $holiday_counter;
            $data['sundays'] = $sunday_counter;
            $data['workdays'] = $total_days - ($sunday_counter + $holiday_counter);
        }
        
        if(!$employees->isEmpty()){
            foreach ($employees as $key => $value) {
                $attendance_result = AttendanceResult::where(['user_id'=>$value->user_id,'on_date'=>date("Y-m-d",strtotime($req['year'].'-'.$req['month'].'-'.'01'))])->first();

                if(empty($attendance_result)){
                    $value->on_date = date("d/m/Y",strtotime($req['year'].'-'.$req['month'].'-'.'01'));
                    $value->holidays = effectiveHolidays($value->joining_date,$holiday_array);
                    $value->sundays = effectiveHolidays($value->joining_date,$sunday_array);
                    $value->workdays = $data['workdays'];

                    $value->late = $this->calculateLateAttendance($value->user_id,$req['year'],$req['month']);

                    $value->absent_days = $this->calculateAbsentAttendance($value->user_id,$req['year'],$req['month']); //- ($value->holidays);

                    $value->absent_days = ($value->workdays < $value->absent_days) ? $value->workdays : $value->absent_days;

                    $value->absent_days = ($value->absent_days < 0) ? 0 : $value->absent_days;

                    $travels = TravelApproval::where(['isactive'=>1,'status'=>'approved','user_id'=>$value->user_id])
                                ->where(function($query)use($req,$value){
                                    $query->orWhere(function($query)use($req,$value){
                                                $query->whereYear('date_from',$req['year'])
                                                    ->whereMonth('date_from',$req['month']);  
                                            })
                                            ->orWhere(function($query)use($req,$value){
                                                $query->whereYear('date_from',$req['year'])
                                                    ->whereMonth('date_to',$req['month']);  
                                            })  
                                            ->orWhere(function($query)use($req,$value){
                                                $query->whereYear('date_from',$req['year'])
                                                    ->whereMonth('date_from','<',$req['month'])
                                                    ->whereMonth('date_to','>',$req['month']);  
                                            });  
                                        })
                                ->get();                 
                    
                    if(!$travels->isEmpty()){
                        $value->travel_days = $this->calculateTotalTravelDuration($travels, $req);
                    }else{
                        $value->travel_days = 0;
                    }

                    $value->paid_leaves = DB::table('applied_leave_segregations as als')
                            ->join('applied_leaves as al','al.id','=','als.applied_leave_id')
                            ->where(['al.final_status'=>'1','al.user_id'=>$value->user_id])
                            ->where(function($query)use($req){
                                $query->whereYear('als.to_date',$req['year'])
                                    ->whereMonth('als.to_date',$req['month']);  
                            })
                            ->sum('als.paid_count');

                    $value->unpaid_leaves = DB::table('applied_leave_segregations as als')
                            ->join('applied_leaves as al','al.id','=','als.applied_leave_id')
                            ->where(['al.final_status'=>'1','al.user_id'=>$value->user_id])
                            ->where(function($query)use($req){
                                $query->whereYear('als.to_date',$req['year'])
                                    ->whereMonth('als.to_date',$req['month']);  
                            })
                            ->sum('als.unpaid_count');   

                    $value->total = ($value->workdays+$value->holidays+$value->sundays) - ($value->absent_days + $value->unpaid_leaves);
                }else{
                    
                    $value->on_date = date("d/m/Y",strtotime($attendance_result->on_date));
                    $value->holidays = $attendance_result->holidays;
                    $value->sundays = $attendance_result->week_offs;
                    $value->workdays = $attendance_result->workdays;
                    $value->late = $attendance_result->late;
                    $value->absent_days = $attendance_result->absent_days;
                    $value->travel_days = $attendance_result->travel_days;
                    $value->paid_leaves = $attendance_result->paid_leaves;
                    $value->unpaid_leaves = $attendance_result->unpaid_leaves;
                    $value->total = $attendance_result->total_present_days;
                }
                
                $verification = AttendanceVerification::where(['on_date'=>date("Y-m-d",strtotime($req['year'].'-'.$req['month'].'-'.'01')),'user_id'=>$value->user_id])->first();

                if(empty($verification) || $verification->isverified == 0){
                    //$data['isverified'] = 0;
                    $value->isverified = 0;
                }else{
                    $value->isverified = 1;
                }
            }
        }

        return view('attendances.list_verify_attendance')->with(['data'=>$data,'employees'=>$employees,'req'=>$req]);

    }//end of function

    /* 
     * For filtering, exporting and displaying the monthly attendance report of employees.
    */
    function consolidatedAttendanceSheets(Request $request)
    {
        $data['companies'] = Company::where(['isactive'=>1,'approval_status'=>'1'])->select('id','name')->get();
        $data['projects'] = Project::where(['isactive'=>1,'approval_status'=>'1'])->select('id','name')->get();
        $data['departments'] = Department::where(['isactive'=>1])->select('id','name')->get();
        $user = Auth::user();
        $data['user_department'] = $user->employeeProfile->department_id;
                                    
        $req['company'] = 0;
        $req['company_sign'] = '!=';
        $req['project'] = 0;
        $req['project_sign'] = '!=';
        $req['department'] = 0;
        $req['department_sign'] = '!=';
        $req['year'] = 0;
        $req['year_sign'] = '!=';
        $req['month'] = 0;
        $req['month_sign'] = '!=';
        $req['submit'] = "";
        $req['employee_status'] = $request->employee_status;
        $req['attendance_type'] = 'All';

        if($request->attendance_type){
            $req['attendance_type'] = $request->attendance_type;
        }

        if($request->submit){
            $req['submit'] = $request->submit;
        }

        if($request->company){
            $req['company'] = $request->company;
            $req['company_sign'] = '=';
        }

        if($request->project){
            $req['project'] = $request->project;
            $req['project_sign'] = '=';
        }

        $department_name = 'All';
        if($request->department){
            $req['department'] = $request->department;
            $req['department_sign'] = '=';
            $department_name = Department::where('id',$request->department)->value('name');
        }

        if($request->month){
            $req['month'] = $request->month;
            $req['month_sign'] = '=';
        }

        if($request->year){
            $req['year'] = $request->year;
            $req['year_sign'] = '=';
        }

        if(!empty($request->all())){
            $month_last_date = date("Y-m-t",strtotime($req['year'].'-'.$req['month'].'-01'));
            $employees = DB::table('projects as p')
                ->join('project_user as pu','p.id','=','pu.project_id')
                ->join('companies as c','c.id','p.company_id')
                ->join('employee_profiles as ep','ep.user_id','=','pu.user_id')
                ->join('employees as e','ep.user_id','=','e.user_id')
                ->join('users as u','ep.user_id','=','u.id')
                ->join('departments as d','d.id','=','ep.department_id')
                ->where('p.id',$req['project_sign'],$req['project'])
                ->where('p.company_id',$req['company_sign'],$req['company'])
                ->where('d.id',$req['department_sign'],$req['department'])
                ->where('e.user_id','!=',1)
                ->whereDate('e.joining_date','<=',$month_last_date)
                ->where(['pu.isactive'=>1,'p.isactive'=>1,'p.approval_status'=>'1','c.isactive'=>1,'c.approval_status'=>'1','e.approval_status'=>'1','e.isactive'=>(int)$req['employee_status']]);
            
            if($req['attendance_type'] != 'All'){
                $employees = $employees->where('e.attendance_type',$req['attendance_type']);
            }    
            $employees = $employees->select('ep.user_id','d.name as department_name','e.fullname','u.employee_code','e.joining_date')->get();
        }else{
            $employees = collect();
        }

        if(!empty($req['year'])){
            $year = $req['year'];
            $month = $req['month'];
            $date = $year.'-'.$month.'-'.'01';
            $total_days = (int)date("t",strtotime($date));
            $holiday_counter = 0;
            $sunday_counter = 0;
            $holiday_array = [];
            $sunday_array = [];
            
            for ($i=1; $i <= $total_days ; $i++) {
                if($i >= 10){
                    $date = $year.'-'.$month.'-'.$i;
                }else{
                    $date = $year.'-'.$month.'-'.'0'.$i;
                } 
                $holiday = Holiday::where('holiday_from','<=',$date)
                            ->where('holiday_to','>=',$date)
                            ->where('isactive',1)
                            ->first();

                if(!empty($holiday) && date("l",strtotime($date)) != "Sunday"){
                    $holiday_counter += 1;
                    $holiday_array[] = $date;
                }elseif (date("l",strtotime($date)) == "Sunday") {
                    $sunday_counter += 1;
                    $sunday_array[] = $date;
                }
            }
            
            $data['holidays'] = $holiday_counter;
            $data['sundays'] = $sunday_counter;
            $data['workdays'] = $total_days - ($sunday_counter + $holiday_counter);
            $data['department_name'] = $department_name; 
        }

        $data['isverified'] = 1;

        if(!$employees->isEmpty()){
            foreach ($employees as $key => $value) {
                $attendance_result = AttendanceResult::where(['user_id'=>$value->user_id,'on_date'=>date("Y-m-d",strtotime($req['year'].'-'.$req['month'].'-'.'01'))])->first();

                if(empty($attendance_result)){
                    $value->on_date = date("d/m/Y",strtotime($req['year'].'-'.$req['month'].'-'.'01'));
                    $value->holidays = effectiveHolidays($value->joining_date,$holiday_array);
                    $value->sundays = effectiveSundays($value->joining_date,$sunday_array);
                    $value->workdays = $data['workdays'];

                    $value->late = $this->calculateLateAttendance($value->user_id,$req['year'],$req['month']);

                    $value->absent_days = $this->calculateAbsentAttendance($value->user_id,$req['year'],$req['month']); // - ($value->holidays);

                    $value->absent_days = ($value->workdays < $value->absent_days) ? $value->workdays : $value->absent_days;

                    $value->absent_days = ($value->absent_days < 0) ? 0 : $value->absent_days;

                    $travels = TravelApproval::where(['isactive'=>1,'status'=>'approved','user_id'=>$value->user_id])
                                ->where(function($query)use($req,$value){
                                    $query->orWhere(function($query)use($req,$value){
                                                $query->whereYear('date_from',$req['year'])
                                                    ->whereMonth('date_from',$req['month']);  
                                            })
                                            ->orWhere(function($query)use($req,$value){
                                                $query->whereYear('date_from',$req['year'])
                                                    ->whereMonth('date_to',$req['month']);  
                                            })  
                                            ->orWhere(function($query)use($req,$value){
                                                $query->whereYear('date_from',$req['year'])
                                                    ->whereMonth('date_from','<',$req['month'])
                                                    ->whereMonth('date_to','>',$req['month']);  
                                            });  
                                        })
                                ->get();                 
                    
                    if(!$travels->isEmpty()){
                        $value->travel_days = $this->calculateTotalTravelDuration($travels, $req);
                    }else{
                        $value->travel_days = 0;
                    }

                    $value->paid_leaves = DB::table('applied_leave_segregations as als')
                            ->join('applied_leaves as al','al.id','=','als.applied_leave_id')
                            ->where(['al.final_status'=>'1','al.user_id'=>$value->user_id])
                            ->where(function($query)use($req){
                                $query->whereYear('als.to_date',$req['year'])
                                    ->whereMonth('als.to_date',$req['month']);  
                            })
                            ->sum('als.paid_count');

                    $value->unpaid_leaves = DB::table('applied_leave_segregations as als')
                            ->join('applied_leaves as al','al.id','=','als.applied_leave_id')
                            ->where(['al.final_status'=>'1','al.user_id'=>$value->user_id])
                            ->where(function($query)use($req){
                                $query->whereYear('als.to_date',$req['year'])
                                    ->whereMonth('als.to_date',$req['month']);  
                            })
                            ->sum('als.unpaid_count');   

                    $value->total = ($value->workdays+$value->holidays+$value->sundays) - ($value->absent_days + $value->unpaid_leaves);
                }else{
                    $value->on_date = date("d/m/Y",strtotime($attendance_result->on_date));
                    $value->holidays = $attendance_result->holidays;
                    $value->sundays = $attendance_result->week_offs;
                    $value->workdays = $attendance_result->workdays;
                    $value->late = $attendance_result->late;
                    $value->absent_days = $attendance_result->absent_days;
                    $value->travel_days = $attendance_result->travel_days;
                    $value->paid_leaves = $attendance_result->paid_leaves;
                    $value->unpaid_leaves = $attendance_result->unpaid_leaves;
                    $value->total = $attendance_result->total_present_days;
                }
                
                $verification = AttendanceVerification::where(['on_date'=>date("Y-m-d",strtotime($req['year'].'-'.$req['month'].'-'.'01')),'user_id'=>$value->user_id])->first();

                if(empty($verification) || $verification->isverified == 0){
                    //$data['isverified'] = 0;
                    $value->isverified = 0;
                }else{
                    $value->isverified = 1;
                }
            }
        }        
        
        if($request->submit == 'export excel sheet'){
            $employee_collection = $employees;
            $set_index_collection = $employee_collection->map(function($item, $key){
                $item->user_id = $key+1;
                //$item->absent_days = ($item->absent_days < 0) ? 0 : $item->absent_days;  
                $item->isverified = "";
                //$item->on_date = date("F Y",strtotime($item->on_date));
                unset($item->joining_date);
                return $item;
            });
            $set_index_collection->all();
            $export = new ConsolidatedAttendanceExport($set_index_collection);
            return Excel::download($export, 'consolidated-attendance.xlsx');
        }

        if($request->submit == 'saral excel sheet'){
            $employee_collection = $employees;
            $set_index_collection = $employee_collection->map(function($item, $key){
                $item->user_id = $key+1;
                $item->unpaid_leaves = $item->unpaid_leaves + $item->absent_days;
                unset($item->department_name);
                unset($item->on_date);
                unset($item->holidays);
                unset($item->sundays);
                unset($item->workdays);
                unset($item->late);
                unset($item->absent_days);
                unset($item->travel_days);
                unset($item->total);
                unset($item->joining_date);
                unset($item->isverified);
                return $item;
            });
            $set_index_collection->all();
            $export = new SaralAttendanceExport($set_index_collection);
            return Excel::download($export, 'saral-consolidated-attendance.xlsx');
        }
        
        return view('attendances.consolidated_attendance_sheets')->with(['data'=>$data,'employees'=>$employees,'req'=>$req]);

    }//end of function

    /* 
     * For exporting attendance punches of an employee of a given month.
    */
    function exportPunches(Request $request)
    {   
        $users = [];
        array_push($users,$request->id);
        $punches = Attendance::whereIn('user_id',$users)
                            ->whereYear('on_date',$request->year)
                            ->whereMonth('on_date',$request->month)
                            ->has('attendancePunches')
                            ->with('user')
                            ->with('user.employee')
                            ->with('user.designation')
                            ->orderBy('on_date','ASC')
                            ->get();

        $user = User::find($request->id);    
        $data = [];                

        if(!$punches->isEmpty()){
            foreach ($punches as $key => $value) {
                $value->attendance_punches = $value->attendancePunches()->orderBy('on_time','ASC')
                                                                        ->get();

                $data[$key]['#'] = $key+1;
                $data[$key]['employee_code'] = $value->user->employee_code;
                $data[$key]['designation'] = "";

                if(!$value->user->designation->isEmpty()){
                    $data[$key]['designation'] = $value->user->designation[0]->name;
                }
                
                $data[$key]['fullname'] = $value->user->employee->fullname;
                $data[$key]['date'] = date("d/m/Y",strtotime($value->on_date));
                
                $count = $value->attendance_punches->count();
                $data[$key]['punch_count'] = $count;

                $data[$key]['first'] = $value->attendance_punches[0]->on_time;
                
                $data[$key]['second'] = "";
                if(!empty($value->attendance_punches[1])){
                    $data[$key]['second'] = $value->attendance_punches[1]->on_time;
                }

                $data[$key]['third'] = "";
                if(!empty($value->attendance_punches[2])){
                    $data[$key]['third'] = $value->attendance_punches[2]->on_time;
                }

                $data[$key]['fourth'] = "";
                if(!empty($value->attendance_punches[3])){
                    $data[$key]['fourth'] = $value->attendance_punches[3]->on_time;
                }

                $data[$key]['fifth'] = "";
                if(!empty($value->attendance_punches[4])){
                    $data[$key]['fifth'] = $value->attendance_punches[4]->on_time;
                }

                $data[$key]['sixth'] = "";
                if(!empty($value->attendance_punches[5])){
                    $data[$key]['sixth'] = $value->attendance_punches[5]->on_time;
                }

                $data[$key]['seventh'] = "";
                if(!empty($value->attendance_punches[6])){
                    $data[$key]['seventh'] = $value->attendance_punches[6]->on_time;
                }

                $data[$key]['last'] = $value->attendance_punches[$count-1]->on_time;
            }
            $data = collect($data);
            $export = new AttendancePunchExport($data);
            return Excel::download($export, 'attendance-punch.xlsx');
        }   

    }//end of function

    /*
    * Calculate the total absents of an employee for a month.
    */
    function calculateAbsentAttendance($user_id,$year,$month)
    {
        $first_date = date("Y-m-d",strtotime($year.'-'.$month.'-'.'01'));
        $month_end_date = date('Y-m-t', strtotime($first_date));

        $period = CarbonPeriod::create($first_date, $month_end_date);
        $absent_count = 0;
        // Iterate over the period
        foreach ($period as $date) {
            $current_date = $date->format('Y-m-d');

            $attendance =  Attendance::where(['user_id'=>$user_id])
                            ->where('on_date',$current_date)    
                            ->first();

            if(empty($attendance)){
                if(date("l",strtotime($current_date)) != 'Sunday'){
                    $holiday = Holiday::where('holiday_from','<=',$current_date)
                           ->where('holiday_to','>=',$current_date)
                           ->where('isactive',1)
                           ->first();

                    if(empty($holiday)){
                        $leave = DB::table('applied_leaves as al')
                                ->where('al.from_date','<=',$current_date)
                                ->where('al.to_date','>=',$current_date)
                                ->where(['al.final_status'=>'1','al.user_id'=>$user_id])
                                ->first();
                        
                        if(empty($leave)){
                            $absent_count += 1;
                        }        
                    }       
                }
            }elseif($attendance->status == 'Absent') {
                
                $absent_count += 1;
            }                 
        }
        
        return $absent_count;
    }//end of function

    /*
    * Calculate the total late comings of an employee for a month.
    */
    function calculateLateAttendance($user_id,$year,$month)
    {
        $user = User::find($user_id);
        $shift_from_time = date("Y-m-d")." ".$user->employeeProfile->shift->from_time;
        $attendances = Attendance::where(['user_id'=>$user_id])
                                ->where('status','!=','Absent')
                                ->whereYear('on_date',$year)    
                                ->whereMonth('on_date',$month)    
                                ->get();
        $late_count = 0;
        
        if(!$attendances->isEmpty()){
            foreach ($attendances as $attendance) {
                $att_date = $attendance->on_date;

                $att_day = date('w', strtotime($att_date));

                $exception_shift_info = ShiftException::where(['user_id'=>$user_id, 'week_day'=>$att_day])
                ->first();

                if($exception_shift_info){

                    $shift_id = $exception_shift_info['shift_id'];

                    $shift_details = Shift::where(['id'=>$shift_id])
                                    ->first(); 

                    $shift_from_time = date("Y-m-d")." ".$shift_details['from_time'];     

                }else{                 

                    $shift_from_time = date("Y-m-d")." ".$user->employeeProfile->shift->from_time;

                }
                $punch = $attendance->attendancePunches()->orderBy('on_time','asc')->first();
                
                if(!empty($punch)){
                    if($attendance->status == 'Leave'){
                        $leave = AppliedLeave::where('from_date','<=',$attendance->on_date)
                                ->where('to_date','>=',$attendance->on_date)
                                ->where(['final_status'=>'1','user_id'=>$user_id])
                                ->first();

                        if(empty($leave)){
                            $attendance->status = 'Present';
                            $attendance->save();
                        }        
                    }

                    $holiday = Holiday::where('holiday_from','<=',$attendance->on_date)
                           ->where('holiday_to','>=',$attendance->on_date)
                           ->where('isactive',1)
                           ->first();

                    if(strtotime(date("Y-m-d H:i",strtotime($punch->on_time))) > strtotime(date('Y-m-d H:i',strtotime($shift_from_time)))){
                        if($attendance->status == 'Leave' && $leave->secondary_leave_type == 'Half' && $leave->leave_half == 'First'){
                            continue;
                        }elseif($attendance->status == 'Leave' && $leave->secondary_leave_type == 'Short' && $leave->from_time == date('g:i A',strtotime($shift_from_time))){
                            continue;
                        }elseif($attendance->status == 'Leave' && $leave->secondary_leave_type == 'Full'){
                            continue;
                        }elseif(date("l",strtotime($attendance->on_date)) == 'Sunday' || !empty($holiday)){
                            continue;
                        }else{
                            $late_count += 1;
                        }
                    }
                }
            }
        }
        
        return $late_count;

    }//end of function

    /*
    * Calculate the total travel duration of an employee for a month.
    */
    function calculateTotalTravelDuration($travels, $req)
    {
        $difference = 0;
        
        foreach ($travels as $key => $travel) {
            $from_date = Carbon::create($travel->date_from);
            $to_date = Carbon::create($travel->date_to);

            if(date("Ym",strtotime($travel->date_to)) == date("Ym",strtotime($travel->date_from))){
                $difference += $from_date->diffInDays($to_date) + 1;
            }else{
                
                //if from_month is less than requested month and to_month is greater than requested month
                //it means full month travel
                if(date("m",strtotime($travel->date_from)) < $req['month'] && date("m",strtotime($travel->date_to)) > $req['month']){
                    $difference += cal_days_in_month(CAL_GREGORIAN, $req['month'], $req['year']); 
                }

                //if from month is less than requested month and to month is equals to requested month
                //it means travel started in previous months, ending in current month
                if(date("m",strtotime($travel->date_from)) < $req['month'] && date("m",strtotime($travel->date_to)) == $req['month']){
                    $start_of_month = date('Y-m-01', strtotime($travel->date_to));
                    $start_of_month = Carbon::create($start_of_month);
                    $difference += $to_date->diffInDays($start_of_month) + 1; 
                }

                //if from month is equals to requested month and to month is greater than requested month
                //it means travel started in current months, ending in future months
                if(date("m",strtotime($travel->date_from)) == $req['month'] && date("m",strtotime($travel->date_to)) > $req['month']){
                    $end_of_month = date('Y-m-t',strtotime($travel->date_from));
                    $end_of_month = Carbon::create($end_of_month);
                    $difference += $from_date->diffInDays($end_of_month) + 1;
                }    
            }
        }

        return $difference;

    }//end of function

    /*
    * Get the data to store the attendance result of an employee of a particular month.
    */
    function getAttendanceResult($user,$on_date)
    {
        $total_days = (int)date("t",strtotime($on_date));
        $split_date = explode("-",$on_date);
        $year = $split_date[0];
        $month = $split_date[1];
        $holiday_counter = 0;
        $sunday_counter = 0;
        $holiday_array = [];
        $sunday_array = [];
        $data = [];

        for ($i=1; $i <= $total_days ; $i++) {
            if($i >= 10){
                $date = $year.'-'.$month.'-'.$i;
            }else{
                $date = $year.'-'.$month.'-'.'0'.$i;
            } 
            $holiday = Holiday::where('holiday_from','<=',$date)
                        ->where('holiday_to','>=',$date)
                        ->where('isactive',1)
                        ->first();

            if(!empty($holiday) && date("l",strtotime($date)) != "Sunday"){
                $holiday_counter += 1;
                $holiday_array[] = $date;
            }elseif (date("l",strtotime($date)) == "Sunday") {
                $sunday_counter += 1;
                $sunday_array[] = $date;
            }
        }

        $data['user_id'] = $user->id;
        $data['department'] = $user->employeeProfile->department->name;
        $data['employee_name'] = $user->employee->fullname;
        $data['employee_code'] = $user->employee_code;
        $data['on_date'] = $on_date;
        $data['workdays'] = $total_days - ($sunday_counter + $holiday_counter);
        $data['holidays'] = effectiveHolidays($user->employee->joining_date,$holiday_array);
        $data['week_offs'] = effectiveSundays($user->employee->joining_date,$sunday_array);
        $data['late'] = $this->calculateLateAttendance($user->id,$year,$month); 
        $data['absent_days'] = $this->calculateAbsentAttendance($user->id,$year,$month); // - ($holiday_counter); 
        $data['absent_days'] = ($data['workdays'] < $data['absent_days']) ? $data['workdays'] : $data['absent_days'];
        $data['absent_days'] = ($data['absent_days'] < 0) ? 0 : $data['absent_days'];

        $travels = TravelApproval::where(['isactive'=>1,'status'=>'approved','user_id'=>$user->id])
                        ->where(function($query)use($year,$month){
                            $query->orWhere(function($query)use($year,$month){
                                        $query->whereYear('date_from',$year)
                                            ->whereMonth('date_from',$month);  
                                    })
                                    ->orWhere(function($query)use($year,$month){
                                        $query->whereYear('date_from',$year)
                                            ->whereMonth('date_to',$month);  
                                    })  
                                    ->orWhere(function($query)use($year,$month){
                                        $query->whereYear('date_from',$year)
                                            ->whereMonth('date_from','<',$month)
                                            ->whereMonth('date_to','>',$month);  
                                    });  
                                })
                        ->get();                 
            
        $req['month'] = $month;
        $req['year'] = $year;                
        if(!$travels->isEmpty()){
            $data['travel_days'] = $this->calculateTotalTravelDuration($travels, $req);
        }else{
            $data['travel_days'] = '0';
        }

        $data['paid_leaves'] = DB::table('applied_leave_segregations as als')
                    ->join('applied_leaves as al','al.id','=','als.applied_leave_id')
                    ->where(['al.final_status'=>'1','al.user_id'=>$user->id])
                    ->where(function($query)use($req){
                        $query->whereYear('als.to_date',$req['year'])
                                ->whereMonth('als.to_date',$req['month']);  
                    })
                    ->sum('als.paid_count');

        $data['unpaid_leaves'] = DB::table('applied_leave_segregations as als')
                    ->join('applied_leaves as al','al.id','=','als.applied_leave_id')
                    ->where(['al.final_status'=>'1','al.user_id'=>$user->id])
                    ->where(function($query)use($req){
                        $query->whereYear('als.to_date',$req['year'])
                                ->whereMonth('als.to_date',$req['month']);  
                    })
                    ->sum('als.unpaid_count');   

        $data['total_present_days'] = ($data['workdays']+$data['holidays']+$data['week_offs']) - ($data['absent_days'] + $data['unpaid_leaves']);
        //$data['absent_days'] = ($data['absent_days'] < 0) ? 0 : $data['absent_days'];            
        return $data;
    }//end of function

    /*
    * Verify the attendance of an employee of a particular month, create late coming leaves.
    * Also create an entry in the attendance results table.
    */
    function verifyMonthAttendance(Request $request)
    {
        $on_date = date('Y-m-d',strtotime($request->on_date));
        $user = User::where('id',$request->user_id)
                    ->with('employee')
                    ->with('userManager')
                    ->with('employeeProfile.department')
                    ->with('employeeProfile.shift')
                    ->first();

        $dayofweek = date('w', strtotime($on_date)); 
        $user_id = $request->user_id;

        $exception_shift_info = ShiftException::where(['user_id'=>$user_id, 'week_day'=>$dayofweek])
        ->first();

        if($exception_shift_info){

        $shift_id = $exception_shift_info['shift_id'];

        $shift_details = Shift::where(['id'=>$shift_id])
                        ->first(); 
        $shift_from_time = date("Y-m-d")." ".$shift_details['from_time']; 

        }else{
            
        $shift_from_time = date("Y-m-d")." ".$user->employeeProfile->shift->from_time;

        }            
        
        $verification = $user->attendanceVerifications()
                            ->where(['on_date'=>$on_date])
                            ->first();
        
        $end_of_month = date('Y-m-t',strtotime($on_date));                  
        //$next_month_second_date = date('Y-m-03', strtotime('+1 months', strtotime($on_date)));
        $next_month_second_date = date(config('constants.restriction.verifyAttendanceButton'), strtotime('+1 months', strtotime($on_date)));
        
        if(!empty($verification) && strtotime(date("Y-m-d")) >= strtotime($next_month_second_date)){
               
            $last_month_start_date = date('Y-m-01', strtotime($on_date));  
            $last_month_end_date = date('Y-m-t', strtotime($last_month_start_date));

            $period = CarbonPeriod::create($last_month_start_date, $last_month_end_date);
            $sum = 0;
            $late_dates = [];
            $late_count = 0;
            // Iterate over the period and calculate late comings
            foreach ($period as $date) {
                $date = $date->format('Y-m-d');
                $attendance = $user->attendances()
                                    ->where(['on_date'=>$date])
                                    ->has('attendancePunches')
                                    ->with('attendancePunches')
                                    ->first();
                
                $secondary_leave_type = "";
                $leave_half = "";
                $late = 0;

                $holiday = Holiday::where('holiday_from','<=',$date)
                           ->where('holiday_to','>=',$date)
                           ->where('isactive',1)
                           ->first();
                
                if(!empty($attendance) && empty($holiday) && date("l",strtotime($date)) != 'Sunday'){
                    if($attendance->status == "Leave"){
                        $leave = AppliedLeave::where('from_date','<=',$date)
                                    ->where('to_date','>=',$date)
                                    ->where(['final_status'=>'1','user_id'=>$user->id])
                                    ->first();
                        $secondary_leave_type = $leave->secondary_leave_type;            
                        $leave_half = $leave->leave_half;            
                    }
                    $first_punch = $attendance->attendancePunches()->orderBy('on_time','ASC')->value('on_time');
                    $modified_punch = strtotime(date("Y-m-d H:i",strtotime($first_punch)));

                    if($modified_punch > strtotime(date('Y-m-d H:i',strtotime($shift_from_time)))){
                        $late_count += 1;

                        if($attendance->status == 'Leave' && $secondary_leave_type == 'Half' && $leave_half == 'First'){
                            $late = 0;
                            $late_count -= ($late_count > 0) ? 1 : 0;

                        }elseif($attendance->status == 'Leave' && $secondary_leave_type == 'Short' && $leave->from_time == date('g:i A',strtotime($shift_from_time))){
                            $late = 0;
                            $late_count -= ($late_count > 0) ? 1 : 0;

                        }elseif($attendance->status == 'Leave' && $secondary_leave_type == 'Full'){
                            $late = 0;
                            $late_count -= ($late_count > 0) ? 1 : 0;

                        }elseif($modified_punch <= strtotime(date('Y-m-d H:i',strtotime('+2 hour +0 minutes',strtotime($shift_from_time)))) && $late_count > 3){
                            $late = 1;
                            $sum += 0.25;
                            $late_dates[] = date("d/m/Y",strtotime($date));

                        }elseif($modified_punch <= strtotime(date('Y-m-d H:i',strtotime('+4 hour +0 minutes',strtotime($shift_from_time)))) && $late_count > 3){
                            $late = 1;
                            $sum += 0.5;
                            $late_dates[] = date("d/m/Y",strtotime($date));

                        }elseif($modified_punch <= strtotime(date('Y-m-d H:i',strtotime('+6 hour +0 minutes',strtotime($shift_from_time)))) && $late_count > 3){
                            $late = 1;
                            $sum += 0.75;
                            $late_dates[] = date("d/m/Y",strtotime($date));

                        }elseif($late_count > 3 && ($modified_punch <= strtotime(date('Y-m-d H:i',strtotime('+8 hour +0 minutes',strtotime($shift_from_time)))) || $modified_punch > strtotime(date('Y-m-d H:i',strtotime('+8 hour +0 minutes',strtotime($shift_from_time)))))){
                            $late = 1;
                            $sum += 1;
                            $late_dates[] = date("d/m/Y",strtotime($date));
                        }
                    }
                }                    
            }//end foreach
            
            if($sum > 0){
                $leave_type = LeaveType::where('name', 'like', '%Late%')->first();
                $check_leave = $user->appliedLeaves()->where('leave_type_id',$leave_type->id)
                                                    ->where('from_date',$last_month_end_date)
                                                    ->first();

                if(empty($check_leave)){
                    //////////////////////////Apply for leave///////////////////////
                    $applied_leave = $this->applyLeave($user,$leave_type,$sum,$late_dates,$last_month_end_date);
                    $probation_data = probationCalculations($applied_leave->user);
                    leaveRelatedCalculations($probation_data,$applied_leave);
                }                                      
            }

            $verification->isverified = 1;
            $verification->save();   
            $result['error'] = "";     

            ////////////////////Attendance Result/////////////////
            $check_result = $user->attendanceResults()->where('on_date',$on_date)->first();
            if(empty($check_result)){
                $result = $this->getAttendanceResult($user,$on_date);
                $user->attendanceResults()->create($result);
            }else{
                $result = $this->getAttendanceResult($user,$on_date);
                $check_result->update($result);
            }
            
        }else{
            $result['error'] = "You can verify current month's attendance only in next month.";
        }

        return $result;    

    }//end of function

    /*
    * Apply the system generated late coming leave.
    */
    function applyLeave($user,$leave_type,$number_of_days,$late_dates,$last_month_end_date)
    {
        $leave_data = [  
            'leave_type_id' => $leave_type->id,
            'country_id' => 1,
            'state_id' => 28,  //Punjab
            'city_id' => 1110, //Mohali
            'reason' => 'Deducted by system due to late comings on '.implode(", ",$late_dates),
            'number_of_days' => $number_of_days, 
            'from_time' => "",
            'to_time' => "",
            'mobile_country_id' => 1,
            'mobile_number' => $user->employee->mobile_number,
            'from_date' => $last_month_end_date, 
            'to_date' => $last_month_end_date,
            'excluded_dates' => "", 
            'tasks' => "",
            'leave_half' => '',
            'final_status' => '1'
        ];

        if($number_of_days == 0.25){
            $leave_data['secondary_leave_type'] = 'Short';
        }elseif($number_of_days == 0.5){
            $leave_data['secondary_leave_type'] = 'Half';
        }else{
            $leave_data['secondary_leave_type'] = 'Full';
        }

        $applied_leave = $user->appliedLeaves()->create($leave_data);

        $segregation_data = [
            'from_date' => $leave_data['from_date'],
            'to_date' => $leave_data['to_date'],
            'number_of_days' => $number_of_days,
            'paid_count' => '0',
            'unpaid_count' => '0',
            'compensatory_count' => '0'
        ];
        $applied_leave->appliedLeaveSegregations()->create($segregation_data);

        $approval_data = [
            'user_id' => $user->id,
            'supervisor_id' => $user->userManager->manager_id,
            'priority' => '1',
            'leave_status' => '1'
        ];
        $applied_leave->appliedLeaveApprovals()->create($approval_data);

        $notification_data = [
            'sender_id' => 1,
            'receiver_id' => $user->id,
            'label' => 'Leave Deduction',
            'read_status' => '0'
        ]; 
        $notification_data['message'] = "Your leaves have been deducted due to late comings. Please check your applied leaves section for more details."; 
        $applied_leave->notifications()->create($notification_data);

        return $applied_leave;

    }//end of function

    /*
    * Get the attendance change request form.
    */
    function requestChange()
    {
        return view('attendances.request_change_form');
        
    }//end of function

    /*
    * Ajax request to check for a valid date status from attendance change request form.
    */
    function checkDateStatus(Request $request)
    {
        $user = Auth::user();
        $result = ['error'=>""];

        $hod = $user->leaveAuthorities()->where(['priority'=>'2','isactive'=>1])->first();
        if(empty($hod)){
            $result['error'] .= "You do not have a HOD. Please contact the HR.<br>";
        }
        
        if(!empty($request->dates)){
            foreach ($request->dates as $key => $date) {
                $date = date("Y-m-d",strtotime($date));
                $holiday = Holiday::where('holiday_from','<=',$date)
                           ->where('holiday_to','>=',$date)
                           ->where('isactive',1)
                           ->first();

                if(!empty($holiday)){
                    $result['error'] .= date("d/m/Y",strtotime($date))." is marked as a holiday.<br>";
                }else{
                    $leave = AppliedLeave::where('from_date','<=',$date)
                        ->where('to_date','>=',$date)
                        ->where(['final_status'=>'1','user_id'=>$user->id])
                        ->first();

                    if(!empty($leave) && $leave->secondary_leave_type == 'Full'){
                        $result['error'] .= date("d/m/Y",strtotime($date))." is marked as a leave day.<br>";
                    }else{
                        $travel = TravelApproval::where(['isactive'=>1,'status'=>'approved','user_id'=>$user->id])
                                    ->where('date_from','<=',$date)
                                    ->where('date_to','>=',$date)
                                    ->first();

                        if(!empty($travel)){
                            $result['error'] .= date("d/m/Y",strtotime($date))." is marked as a travel day.<br>";
                        }else{
                            $attendance = Attendance::where(['user_id'=>$user->id,'on_date'=>$date,'status'=>'Present'])->first();

                            if(!empty($attendance)){
                                //$result['error'] .= date("d/m/Y",strtotime($date))." is marked as a Present.<br>";
                            }else{
                                $change_date = AttendanceChangeDate::where(['user_id'=>$user->id,'on_date'=>$date])->whereHas('attendanceChange',function(Builder $query){
                                    $query->where('isactive',1);
                                })->first();

                                if(!empty($change_date)){
                                    $check_approval = AttendanceChangeApproval::where(['attendance_change_id'=>$change_date->attendance_change_id,'status'=>'2'])->first();

                                    /*if(empty($check_approval)){
                                        $result['error'] .= date("d/m/Y",strtotime($date))." is already marked as a change request.<br>";
                                    }*/
                                }
                            }
                        }            
                    }    
                }           
            }
        }

        return $result;

    }//end of function

    /*
    * Save the attendance change request of a user in database. Send for approval to the HOD.
    */
    function saveChangeRequest(Request $request)
    {
        $request->validate([
            'remarks' => 'required',
            'dates' => 'required',
            'select_option' => 'required'
        ]);

        $dates = explode(",",$request->dates);
        //////////////Checks///////////////////
        $current_date = date('Y-m-d');    
        $restriction_date = config('constants.restriction.applyLeave');    
        $current_month_start_date = date("Y-m-01");

        $request_date = date('Y-m-d', strtotime($request->dates));
        $prev_two_days_date = date('Y-m-d', strtotime($current_date. ' - 2 days'));
        
        /* if((strtotime($request_date) > strtotime($current_date)) || (strtotime($request_date)<strtotime($prev_two_days_date))){
            
                $error = "You cannot request for an attendance change of dates before 2 days. ";
                return redirect()->back()->with('error',$error);
            
        }*/

        if(strtotime($current_date) > strtotime($restriction_date)){
            if(strtotime(date("Y-m-d",strtotime($dates[0]))) < strtotime($current_month_start_date)){
                $restriction_error = "You cannot request for an attendance change for a previous month's date now.";
                return redirect()->back()->with('error',$restriction_error);
            }
        }

        $user = Auth::user();
        $hod = $user->leaveAuthorities()->where(['priority'=>'2','isactive'=>1])->first();
        $next_user = User::permission('it-attendance-approver')
                                    ->whereHas('employeeProfile',function(Builder $query){
                                        $query->where('department_id',2); //IT
                                    })    
                                    ->first();

        if(empty($hod)){
            $error = 'You do not have a HOD. Please contact the HR.';
            return redirect()->back()->with('error',$error);
        }elseif (empty($next_user)) {
            $error = 'No one in the IT department has the permission to change attendance. Please contact the HR';
            return redirect()->back()->with('error',$error);
        }else{
            $change_data = ['remarks'=> $request->remarks];
            $attendance_change = $user->attendanceChanges()->create($change_data);

            $change_date_data = [
                'user_id' => $user->id
            ];

            
            foreach ($dates as $key => $value) {
                $change_date_data['on_date'] = date("Y-m-d",strtotime($value));

                if($request->intime){
                    $change_date_data['on_time'] = date("H:i:s",strtotime($request->intime));
                }

                if($request->outtime){
                    $change_date_data['out_time'] = date("H:i:s",strtotime($request->outtime));
                }
                $attendance_change->attendanceChangeDates()->create($change_date_data);
            }

            $change_approval_data = [
                'user_id' => $user->id,
                'manager_id' => $hod->manager_id,
                'status' => '0',
                'priority' => '1'
            ];

            $attendance_change->attendanceChangeApprovals()->create($change_approval_data);
            $notification_data = [
                'sender_id' => $user->id,
                'receiver_id' => $hod->manager_id,
                'label' => 'Change Attendance Application',
                'read_status' => '0'
            ]; 
            $notification_data['message'] = $user->employee->fullname." has requested for a change in attendance."; 
            $attendance_change->notifications()->create($notification_data);

            $title = 'Change Attendance Application';
            $body = $notification_data['message'];
            pushNotification($hod->manager_id, $title, $body);

            return redirect('attendances/requested-changes')->with('success','Change request sent successfully.');
        }

    }//end of function

    /*
    * Get the list of all the attendance change requests made by a person.
    */
    function requestedChanges($final_status = "approved")
    {
        if($final_status == "not-approved"){
            $status = 0;
        }elseif ($final_status == "approved") {
            $status = 1;
        }

        $user = Auth::user();

        $changes = $user->attendanceChanges()->where(['final_status'=>$status])
                        ->with('attendanceChangeDates')
                        ->with('attendanceChangeApprovals')
                        ->orderBy('created_at','DESC')
                        ->get();    
                        
        if(!$changes->isEmpty()){
            foreach ($changes as $key => $change) {
                $rejected = $change->attendanceChangeApprovals()->where('status','2')->first();
                if(!empty($rejected)){
                    $change->is_rejected = true;
                }else{
                    $change->is_rejected = false;
                }
            }
        }                

        return view('attendances.list_requested_changes')->with(['changes'=>$changes,'final_status'=>$final_status]);

    }//end of function

    /*
    * Cancel the attendance change request before any action is taken by the HOD.
    */
    function cancelRequestedChange($attendance_change_id)
    {
        $user = Auth::user();
        $change = $user->attendanceChanges()->where('id',$attendance_change_id)->first();

        if(empty($change)){
            return redirect()->back()->with('cannot_cancel_error','You cannot cancel somebodies else request');
        }else{
            if($change->attendanceChangeApprovals[0]->status != "0"){
                return redirect()->back()->with('cannot_cancel_error','Concerned authority has taken an action, you cannot cancel it now.');
            }else{
                $change->final_status = 0;
                $change->isactive = 0;
                $change->save();

                return redirect()->back();
            }
        }
    }//end of function

    /*
    * Get the list of all the attendance change requests send to a person for approval.
    */
    function changeApprovals($approval_status = "pending")
    {
        if($approval_status == "pending"){
            $status = '0';
        }elseif ($approval_status == "approved") {
            $status = '1';
        }elseif ($approval_status == "rejected") {
            $status = '2';
        }

        $user = Auth::user();
        $approvals = AttendanceChangeApproval::where(['manager_id'=>$user->id,'status'=>$status])
                                ->whereHas('attendanceChange', function(Builder $query){
                                    $query->where(['isactive'=>1]);        
                                })
                                ->with('attendanceChange.attendanceChangeDates')
                                ->with('user.employee')
                                ->orderBy('created_at','DESC')
                                ->get();   

        if(!$approvals->isEmpty()){
            foreach ($approvals as $key => $approval) {
                $user_id = $approval->user_id;
                foreach ($approval->attendanceChange->attendanceChangeDates as $key2 => $value) {
                    $attendance = Attendance::where(['on_date'=>$value->on_date,'user_id'=>$user_id])
                                ->first();

                    if(!empty($attendance) && !$attendance->attendancePunches->isEmpty()){
                        $value->first_punch = $attendance->attendancePunches()
                                        ->orderBy('on_time','asc')
                                        ->value('on_time');

                        $value->last_punch = $attendance->attendancePunches()
                                        ->orderBy('on_time','desc')
                                        ->value('on_time');    
                        
                        $value->first_punch = date("h:i A",strtotime($value->first_punch));                     
                        $value->last_punch = date("h:i A",strtotime($value->last_punch));                                    

                        if($value->last_punch == $value->first_punch){
                            $value->last_punch = "";
                        }
                    }else{
                        $value->first_punch = "";
                        $value->last_punch = "";
                    }            
                

                
                }
            }
        }      

        return view('attendances.list_change_approvals')->with(['approvals'=>$approvals,'selected_status'=>$approval_status]);

    }//end of function

    /*
    * Save the concerned authorities action taken on any attendance change request. Then finally add
    * the punch to database if approved on all levels or send it for further approval.
    */
    function toExecuteBulkApprovals(){
        $raw_query = DB::select(DB::raw('SELECT * FROM `attendance_change_approvals` where  attendance_change_id in (SELECT id FROM `attendance_changes` where final_status=0 and date(created_at)>"2020-07-09") and priority=2 and status="0"'));
        
        $id_array = [];
        
        foreach($raw_query as $rq){
            $id_array[]=$rq->id;
        } 
        
        
        
        $Allattendance_change_approval = AttendanceChangeApproval::whereIn('id',$id_array)
                                                                ->with('attendanceChange')    
                                                                ->with('user')    
                                                                ->with('manager')    
                                                                ->get();
        foreach($Allattendance_change_approval as $atn){
            $attendance_change_approval = AttendanceChangeApproval::where('id',$atn->id)
                                                                    ->with('attendanceChange')    
                                                                    ->with('user')    
                                                                    ->with('manager')    
                                                                    ->first();
            
            $user = $attendance_change_approval->user;
            $attendance_change = $attendance_change_approval->attendanceChange;
            $attendance_dates = $attendance_change->attendanceChangeDates;
    
            //////////////Checks///////////////////
            $current_date = date('Y-m-d');    
            $restriction_date = config('constants.restriction.approveLeave');    
            $current_month_start_date = date("Y-m-01");
    
            
            $hod_approval = $attendance_change->attendanceChangeApprovals()->where(['priority'=>'1'])->first();
            foreach ($attendance_dates as $key => $value) {
                $attendance = $user->attendances()->where(['on_date'=>$value->on_date])->first();
                if(empty($attendance)){
                    $data = [
                        'on_date' => $value->on_date,
                        'status' => 'Present'
                    ];
                    $attendance = $user->attendances()->create($data);
                }else{
                    $attendance->status = 'Present';
                    $attendance->save();
                }

                if($value->on_time){
                    $attendance->attendancePunches()->create(['on_time'=>$value->on_time,'punched_by'=>$hod_approval->manager_id]);
                }
                
                if($value->out_time){
                    $attendance->attendancePunches()->create(['on_time'=>$value->out_time,'punched_by'=>$hod_approval->manager_id]);
                }
            }
            
            $attendance_change->final_status = 1;
            $attendance_change->save();

        }
        
    }
    function changeAttendance(Request $request)
    {
        $request->validate([
            'comment' => 'required'
        ]);
        
        
        
        
        $attendance_change_approval = AttendanceChangeApproval::where('id',$request->acaId)
                                                                ->with('attendanceChange')    
                                                                ->with('user')    
                                                                ->with('manager')    
                                                                ->first();
        
        $user = $attendance_change_approval->user;
        $attendance_change = $attendance_change_approval->attendanceChange;
        $attendance_dates = $attendance_change->attendanceChangeDates;

        //////////////Checks///////////////////
        $current_date = date('Y-m-d');    
        $restriction_date = config('constants.restriction.approveLeave');    
        $current_month_start_date = date("Y-m-01");

        if(strtotime($current_date) > strtotime($restriction_date)){
            if(strtotime($attendance_dates[0]->on_date) < strtotime($current_month_start_date)){
                $restriction_error = "You cannot approve an attendance change request for a previous month's date now.";
                return redirect()->back()->with('error',$restriction_error);
            }
        }

        if($attendance_change_approval->priority == '1'){  //HOD
            if($request->status == '1'){
                $next_user = User::permission('it-attendance-approver')
                                ->whereHas('employeeProfile',function(Builder $query){
                                    $query->where('department_id',2); //IT
                                })    
                                ->first();

                if(!empty($next_user)){
                    $change_approval_data = [
                        'user_id' => $user->id,
                        'manager_id' => $next_user->id,
                        'status' => '0',
                        'priority' => '2'
                    ];
                    $attendance_change->attendanceChangeApprovals()->create($change_approval_data);
                    $notification_data = [
                        'sender_id' => $user->id,
                        'receiver_id' => $next_user->id,
                        'label' => 'Change Attendance Application',
                        'read_status' => '0'
                    ]; 
                    $notification_data['message'] = $user->employee->fullname." has requested for a change in attendance."; 
                    $attendance_change->notifications()->create($notification_data);
                }                
                
            }else{
                $title = 'Attendance Change Rejected';
                $body = 'Your attendance change request for '.date('d/m/Y',strtotime($attendance_dates[0]->on_date)).' has been rejected.';
                pushNotification($user->id, $title, $body);
            }
        }else{ //IT user
            
            if($request->status == '1'){
                $hod_approval = $attendance_change->attendanceChangeApprovals()->where(['priority'=>'1'])->first();
                foreach ($attendance_dates as $key => $value) {
                    $attendance = $user->attendances()->where(['on_date'=>$value->on_date])->first();
                    if(empty($attendance)){
                        $data = [
                            'on_date' => $value->on_date,
                            'status' => 'Present'
                        ];
                        $attendance = $user->attendances()->create($data);
                    }else{
                        $attendance->status = 'Present';
                        $attendance->save();
                    }

                    if($value->on_time){
                        $attendance->attendancePunches()->create(['on_time'=>$value->on_time,'punched_by'=>$hod_approval->manager_id]);
                    }
                    
                    if($value->out_time){
                        $attendance->attendancePunches()->create(['on_time'=>$value->out_time,'punched_by'=>$hod_approval->manager_id]);
                    }
                }
                
                $attendance_change->final_status = 1;
                $attendance_change->save();

                $title = 'Attandance Change Approved';
                $body = 'Your attendance change request for '.date('d/m/Y',strtotime($attendance_dates[0]->on_date)).' has been approved.';
                pushNotification($attendance_change_approval->user_id, $title, $body);
            }else{
                $title = 'Attendance Change Rejected';
                $body = 'Your attendance change request for '.date('d/m/Y',strtotime($attendance_dates[0]->on_date)).' has been rejected.';
                pushNotification($user->id, $title, $body);
            }
        }

        $message_data = [
            'sender_id' => $attendance_change_approval->manager_id,
            'receiver_id' => $attendance_change_approval->user_id,
            'label' => 'Change Attendance Comment',
            'message' => $request->comment,
            'read_status' => '0'
        ]; 
        $attendance_change->messages()->create($message_data);

        $attendance_change_approval->status = $request->status;                                             
        $attendance_change_approval->save();

        return redirect()->back();

    }//end of function

    /*
    * Ajax request to get the list of all approval history messages to show in a modal.
    */
    function listComments(Request $request)
    {
        $attendance_change = AttendanceChange::find($request->attendance_change_id);
        $messages = $attendance_change->messages()
                                ->where('label','Change Attendance Comment')
                                ->orderBy('created_at','DESC')
                                ->with('sender.employee:id,user_id,fullname')
                                ->with('receiver.employee:id,user_id,fullname')
                                ->get();

        $view = View::make('attendances.list_messages',['data' => $messages]);
        $contents = $view->render(); 

        return $contents;

    }//end of function

    function storeAttendancePunch(Request $request)  // for check in check out save
    {
        // echo "ok";die;
        // dd($request->employee_code);die;
        $user = User::where(['employee_code'=>$request->employee_code])->first();

    	$on_date = date("Y-m-d");
    	

    	$attendance = $user->attendances()->where(['on_date'=>$on_date])->first();

    	if(empty($attendance)){
    		$data = [
    					'on_date' => $on_date,
    					'status' => 'Present'
    				];

    		$attendance = $user->attendances()->create($data);		
    	}

    	$on_time = date("H:i:s");
        $punch = $attendance->attendancePunches()->create(['on_time'=>$on_time, 'punched_by' =>  $user->id, 'type' => $request->type]);
        Session::flash('message', 'Attendance has been saved!');
        Session::flash('alert-class', 'alert-success');
        return redirect()->back();
    }//end of function

}//end of class
