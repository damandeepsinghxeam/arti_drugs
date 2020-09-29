<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Holiday;
use App\LeaveType;
use App\CompensatoryLeave;
use App\Department;
use App\Project;
use App\Country;
use App\State;
use App\User;
use App\Employee;
use App\EmployeeProfile;
use App\AppliedLeave;
use App\AppliedLeaveApproval;
use Carbon\Carbon;
use Auth;
use View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Mail;
use App\Mail\GeneralMail;
use App\AppliedLeaveDocument;

ini_set('max_execution_time', 180); //3 minutes

class LeaveController extends Controller
{
    /*
        Get current year's holidays list
    */
    function listHolidays()
    {
    	$year = date("Y");
    	$holidays = Holiday::where(['isactive'=>1])
    						->whereYear('holiday_from',$year)
    						->orderBy('holiday_from')	
    						->get();

    	return view('leaves.list_holidays')->with(['holidays'=>$holidays]);
    }//end of function

    /*
        Get data to be shown on apply leave form
    */
    function applyLeave()
    {
    	$user = User::where(['id'=>Auth::id()])->first();
    	$data['leave_types'] = LeaveType::where(['isactive'=>1])->get();
    	$data['departments'] = Department::where(['isactive'=>1])->get();
    	$data['countries'] = Country::where(['isactive'=>1])->get();
    	$data['states'] = State::where(['isactive'=>1])->get();
        $data['user'] = $user;
        $data['gender'] = $user->employee->gender;
    	$data['probation_data'] = probationCalculations($user);
    	$data['unpaid_leave'] = LeaveType::where(['name'=>'Unpaid Leave'])->first();

        if(empty($data['probation_data'])){
            return redirect()->back()->with('error','Your profile is incomplete. Please contact the HR officer.');
        }

    	return view('leaves.apply_leave_form')->with(['data'=>$data]); 

    }//end of function

    /*
        Ajax request to get the leave replacements available between given dates
    */
    function leaveReplacementAvailability(Request $request)
    {
        $user = Auth::user();

        $from_date = date("Y-m-d",strtotime($request->from_date));
        $to_date = date("Y-m-d",strtotime($request->to_date));

        $profile_pic_path = config('constants.uploadPaths.profilePic');
        $static_pic_path = config('constants.static.profilePic');

        $employees = EmployeeProfile::where(['department_id'=>$request->department,'isactive'=>1])
            ->where('user_id','!=',$user->id)
            ->whereHas('user.employee',function(Builder $query){
                $query->where('isactive',1);   
            })
            ->where('user_id','!=',1)
            ->pluck('user_id')->toArray();

        $took_leaves = AppliedLeave::where('isactive',1)
                                ->where('from_date','>=',$from_date)    
                                ->where('to_date','<=',$to_date)
                                ->whereIn('user_id',$employees)
                                ->whereHas('appliedLeaveApprovals',function(Builder $query){
                                    $query->where('leave_status','!=','2');   
                                })
                                ->pluck('user_id')->toArray();    

        $exclusions = DB::table('employees as emp')
                    ->join('users as u','u.id','=','emp.user_id')
                    ->whereIn('emp.user_id',$employees)
                    ->whereNotIn('emp.user_id',$took_leaves)
                    ->select("emp.user_id","u.employee_code","emp.fullname",DB::raw("CASE WHEN emp.profile_picture = '' OR emp.profile_picture IS NULL THEN '".$static_pic_path."' ELSE CONCAT('".$profile_pic_path."',emp.profile_picture) END AS profile_picture"))
                    ->get();

        return $exclusions;            

    }//end of function

    /*
        Ajax request to get the official holidays between given dates to be used on apply 
        leave page
    */
    function betweenLeaveHolidays(Request $request)
    {
        $result = [];
        
        if(!empty($request->all_dates_array)){
            foreach ($request->all_dates_array as $key => $value) {
                $date = date("l",strtotime($value));
                
                if($date != 'Sunday'){
                    $holiday = Holiday::where(['isactive'=>1])
                                    ->where('holiday_from','<=',$value)
                                    ->where('holiday_to','>=',$value)
                                    ->first();
                    
                    if(!empty($holiday)){
                        $result[] = $value;    
                    }                            
                }
                
            }
        }

        return $result;

    }//end of function 

    /*
        Store leave application's data in the database & send notification to the replacement
        & first leave officer
    */
    function createLeaveApplication(Request $request)
    {
    	$request->validate([
            'toDate' => "required_if:secondaryLeaveType,==,Full",
            'fromDate' => 'required',
            'reasonLeave' => 'required',
            'replacement' => 'required',
            'tasks' => "required_if:secondaryLeaveType,==,Full"
        ]);

        //////////////////////////Checks///////////////////////////
        $current_date = date('Y-m-d');    
        $restriction_date = config('constants.restriction.applyLeave');    
        $current_month_start_date = date("Y-m-01");

        if(strtotime($current_date) > strtotime($restriction_date)){
            if(strtotime(date("Y-m-d",strtotime($request->fromDate))) < strtotime($current_month_start_date)){
                $restriction_error = "You cannot apply leave for a previous month's date now.";
                return redirect('leaves/apply-leave')->with('leaveError',$restriction_error);
            }
        }

        if($request->noDays == 0){
            $days_error = "The number of days should not be zero.";
            return redirect('leaves/apply-leave')->with('leaveError',$days_error);
        }

        $user = User::where(['id'=>Auth::id()])
                    ->whereHas('userManager', function(Builder $query){
                        $query->where(['isactive'=>1]);
                    })
                    ->with('employee')
                    ->with('userManager')
                    ->first();

        if(empty($user)){
            $manager_error = "You do not have a reporting manager.";
            return redirect('leaves/apply-leave')->with('leaveError',$manager_error);
        }   

        $pending_leave = AppliedLeaveApproval::where(['user_id'=>$user->id,'leave_status'=>'0'])
                                          ->whereHas('appliedLeave',function(Builder $query){
                                            $query->where('isactive',1);
                                          })
                                          ->first();

        if(!empty($pending_leave)){
            $pending_error = "The approval status of your previously applied leave is pending with one or more authorities. Please contact the concerned person and clear it first.";

            return redirect('leaves/apply-leave')->with('leaveError',$pending_error);
        }    

        $last_applied_leave = $user->appliedLeaves()
                                    ->where(['isactive'=>1])
                                    ->orderBy('id','DESC')
                                    ->first();  

        if(!empty($last_applied_leave)){
            $created_at = new Carbon($last_applied_leave->created_at);
            $now = Carbon::now();
            $apply_difference = $created_at->diffInHours($now,false);

            if($apply_difference < 2){
                $leave_time_difference = true;
            }else{
                $leave_time_difference = false;
            }

            if($leave_time_difference){
                $wait_error = "You have to wait for some time before you can apply for leave again.";
                //return redirect('leaves/apply-leave')->with('leaveError',$wait_error); 
            }
        }                                                             

        $from_date = date("Y-m-d",strtotime($request->fromDate));
        
        if($request->secondaryLeaveType != "Full"){
            $to_date = $from_date;
        }else{
            $to_date = date("Y-m-d",strtotime($request->toDate));
        }
        

        $check_dates =  [
                            'from_date' => $from_date,
                            'to_date' => $to_date, 
                            'isactive' => 1
                        ];    

        if($request->secondaryLeaveType == "Short"){
            $check_dates['from_time'] = $request->fromTime;
            $check_dates['to_time'] = $request->toTime;
        
        }elseif($request->secondaryLeaveType == "Half"){
            $check_dates['leave_half'] = $request->selectHalf;

        }   

        $already_applied_leave = $user->appliedLeaves()->where($check_dates)->first();

        if(!empty($already_applied_leave)){
            $unique_error = "You have already applied for leave on the given dates.";
            return redirect('leaves/apply-leave')->with('leaveError',$unique_error);
        }

        if($request->leaveTypeId == '4'){  //check for maternity leave
            if($request->noDays > 90){
                $maternity_error = "You cannot take maternity leave for more than 90 days.";

            }else{
                $already_applied_leave = $user->appliedLeaves()
                                              ->where(['final_status'=>'1','leave_type_id'=>4,'isactive'=>1])
                                              ->whereYear('updated_at',date("Y"))
                                              ->first();  

                if(!empty($already_applied_leave)){
                    $maternity_error = "You have already applied for a maternity leave this year.";

                }else{
                    $maternity_error = "";
                }
            }

            if(!empty($maternity_error)){
                return redirect('leaves/apply-leave')->with('leaveError',$maternity_error);
            }
        }

        /////////////////////////Create Leave///////////////////////

        $leave_data = [  
                        'leave_type_id' => $request->leaveTypeId,
                        'country_id' => $request->countryId,
                        'state_id' => $request->stateId,
                        'city_id' => $request->cityId,
                        'reason' => $request->reasonLeave,
                        'number_of_days' => $request->noDays, 
                        'from_time' => $request->fromTime,
                        'to_time' => $request->toTime,
                        'mobile_country_id' => $request->mobileStdId,
                        'mobile_number' => $request->mobileNumber,
                        "secondary_leave_type" => $request->secondaryLeaveType,
                        'from_date' => $from_date, 
                        'to_date' => $to_date,
                        'excluded_dates' => $request->excludedDates, 
                        'tasks' => $request->tasks,
                        'leave_half' => '',
                        'final_status' => '0'
                    ];

        if($request->secondaryLeaveType == "Half"){
            $leave_data['leave_half'] = $request->selectHalf;
        }   

        $applied_leave = $user->appliedLeaves()->create($leave_data);
        $replacement = $applied_leave->leaveReplacement()->create(['user_id'=>$request->replacement]);

        if(!empty($request->fileNames)){
            $documents = $request->fileNames;

            foreach($documents as $doc) {
                $document = round(microtime(true)).str_random(5).'.'.$doc->getClientOriginalExtension();
                $doc->move(config('constants.uploadPaths.uploadAppliedLeaveDocument'), $document);

                $document_data['name'] = $document;
                $applied_leave->appliedLeaveDocuments()->create($document_data);
            }
        }         

        //////////////////////////Segregation///////////////////////////

        if(!empty($request->newAllDatesArray)){   //for multi-month leave calculations in full day leaves
            $new_all_dates_array = explode(",",$request->newAllDatesArray);
        
            $month_wise_array = [];
            $counter = 0;
            $key2 = 0;
            $days_counter = 0;
            foreach($new_all_dates_array as $key => $value) {
                
                if($counter == 0){
                    $month_wise_array[$key2]['from_date'] = $value;
                    $month_wise_array[$key2]['no_days'] = ++$days_counter;
                    $prev_month_year = date("m-Y",strtotime($value));
                    $prev_date = $value;

                    if(count($new_all_dates_array) == 1){
                        $month_wise_array[$key2]['to_date'] = $value;
                    }
                }else{
                    $month_year = date("m-Y",strtotime($value));
                    
                    if($month_year == $prev_month_year){
                        $prev_month_year = date("m-Y",strtotime($value));
                        $prev_date = $value;
                        $month_wise_array[$key2]['to_date'] = $value;
                        $month_wise_array[$key2]['no_days'] = ++$days_counter;
                        
                    }else{
                        $month_wise_array[$key2]['to_date'] = $prev_date;
                        
                        $key2++;
                        $days_counter = 0;
                        $month_wise_array[$key2]['from_date'] = $value;
                        $month_wise_array[$key2]['no_days'] = ++$days_counter;
                        $prev_month_year = date("m-Y",strtotime($value));
                        $prev_date = $value;
                        
                        if((count($new_all_dates_array)-1) == $counter){
                            $month_wise_array[$key2]['to_date'] = $value;
                        }
                    }
                }
                $counter++;
                
            }//end of foreach

            foreach ($month_wise_array as $key => $value) {
                $segregation_data = [
                                        'from_date' => date("Y-m-d",strtotime($value['from_date'])),
                                        'to_date' => date("Y-m-d",strtotime($value['to_date'])),
                                        'number_of_days' => $value['no_days'],
                                        'paid_count' => '0',
                                        'unpaid_count' => '0',
                                        'compensatory_count' => '0'
                                    ];
                $applied_leave->appliedLeaveSegregations()->create($segregation_data);                   
            }
        }else{  //For Short and Half Day leave

            $segregation_data =  [
                                    'from_date' => date("Y-m-d",strtotime($request->fromDate)),
                                    'to_date' => date("Y-m-d",strtotime($to_date)),
                                    'number_of_days' => $request->noDays,
                                    'paid_count' => '0',
                                    'unpaid_count' => '0',
                                    'compensatory_count' => '0'
                                ];
            $applied_leave->appliedLeaveSegregations()->create($segregation_data);
        }

        //////////////////////////Approval///////////////////////////

        $approval_data = [
                            'user_id' => $user->id,
                            'supervisor_id' => $user->userManager->manager_id,
                            'priority' => '1',
                            'leave_status' => '0'
                         ];
        $applied_leave->appliedLeaveApprovals()->create($approval_data);   

        //////////////////////////Notify///////////////////////////              

        $notification_data = [
                                 'sender_id' => $user->id,
                                 'receiver_id' => $user->userManager->manager_id,
                                 'label' => 'Leave Application',
                                 'read_status' => '0'
                             ]; 

        $message = $user->employee->fullname." has applied for a leave, from ".date('d/m/Y',strtotime($applied_leave->from_date)).' to '.date('d/m/Y',strtotime($applied_leave->to_date)).'.';

        $notification_data['message'] = $message; 
        $applied_leave->notifications()->create($notification_data);

        pushNotification($notification_data['receiver_id'], $notification_data['label'], $notification_data['message']);

        $notification_data['receiver_id'] = $request->replacement;
        $notification_data['message'] = $message." And selected you as replacement."; 
        $applied_leave->notifications()->create($notification_data);
        
        pushNotification($notification_data['receiver_id'], $notification_data['label'], $notification_data['message']);

        $replacement = Employee::where(['user_id'=>$request->replacement])
                                ->with('user')->first();
        $message = $user->employee->fullname." has selected you as replacement during their ".$request->secondaryLeaveType." day leave and has handed over the duties and responsibilities to you for the given time period of ".date('d/m/Y',strtotime($request->fromDate))." to ".date('d/m/Y',strtotime($to_date))."." ;

        $mail_data = array();
        $mail_data['to_email'] = $replacement->user->email;
        $mail_data['subject'] = "Replacement during my absence";
        $mail_data['message'] = $message;
        $mail_data['fullname'] = $replacement->fullname;

        $this->sendGeneralMail($mail_data);

        $reporting_manager = Employee::where(['user_id'=>$user->userManager->manager_id])
                                ->with('user')->first();
        $mail_data['to_email'] = $reporting_manager->user->email;
        $mail_data['subject'] = "Leave Application";
        $mail_data['message'] = $user->employee->fullname." has applied for a leave. Please take an action. Here is the link for website <a href='".url('/')."'>Click here</a>";
        $mail_data['fullname'] = $reporting_manager->fullname;

        $this->sendGeneralMail($mail_data);

        return redirect('leaves/applied-leaves');

    }//end of function

    /*
        Save the approval status assigned by leave officer (approved or rejected) & if approved send for approval to next officer until the last one. Then perform leave calculations if everyone has approved
    */
    function saveLeaveApproval(Request $request)
    {
        $request->validate([
            'remark' => 'required',
        ]);

        $leave_approval = AppliedLeaveApproval::find($request->alaId);
        $applied_leave = $leave_approval->appliedLeave;

        /////////////////Checks////////////////////////
        $current_date = date('Y-m-d');    
        $restriction_date = config('constants.restriction.approveLeave');    
        $current_month_start_date = date("Y-m-01");

       /* if(strtotime($current_date) > strtotime($restriction_date)){
            if(strtotime($applied_leave->from_date) < strtotime($current_month_start_date)){
                $restriction_error = "You cannot approve leave for a previous month's date now.";
                return redirect()->back()->with('error',$restriction_error);
            }
        }*/

        $approver = User::where(['id'=>Auth::id()])->first();

        
        $leave_approval->leave_status = $request->leaveStatus;
        $leave_approval->save();

        $applier = $leave_approval->user;

        $message_data = [
                            'sender_id' => $approver->id,
                            'receiver_id' => $leave_approval->user_id,
                            'label' => 'Leave Remarks',
                            'message' => $request->remark,
                            'read_status' => '0'
                        ]; 
        $applied_leave->messages()->create($message_data);

        $where = [
                    'priority' => (string)($leave_approval->priority + 1),
                    'isactive' => 1
                 ];

        $next_approver = $applier->leaveAuthorities()->where($where)->first(); 
        $next_approver_applied_leave = 0; 
        
        

        //If the next_approver has applied for a leave OR the next reporting manager is same as current reporting manager
        while(!empty($next_approver) && (($leave_approval->user_id == $next_approver->manager_id) || ($leave_approval->supervisor_id == $next_approver->manager_id))){
            
            if($leave_approval->user_id == $next_approver->manager_id){
                $next_approver_applied_leave = 1;
            }else{
                $next_approver_applied_leave = 0;
            }

            $where['priority'] = (string)($where['priority'] + 1);
            $next_approver = $applier->leaveAuthorities()->where($where)->first();
        } 

        if(empty($next_approver)){
            $manager_id = 0;
        }else{
            $manager_id = $next_approver->manager_id;
        }

        $next_approver_present = AppliedLeaveApproval::where(['applied_leave_id'=>$leave_approval->applied_leave_id,'supervisor_id'=>$manager_id])->first();

        //dd($next_approver_present);

        if(!empty($next_approver) && $request->leaveStatus == '1' && empty($next_approver_present)){  //Approved on previous level

            $next_approval_data =   [
                                        'user_id' => $leave_approval->user_id,
                                        'supervisor_id' => $next_approver->manager_id,
                                        'priority' => $next_approver->priority,
                                        'leave_status' => '0'
                                    ];
            
            $message = $applier->employee->fullname." has applied for a leave, from ".date('d/m/Y',strtotime($applied_leave->from_date)).' to '.date('d/m/Y',strtotime($applied_leave->to_date)).'.';                        
            $notification_data = [
                                    'sender_id' => $leave_approval->supervisor_id,
                                    'receiver_id' => $next_approver->manager_id,
                                    'label' => 'Leave Application',
                                    'message' => $message,
                                    'read_status' => '0'
                                ]; 

            if($next_approver->priority == '4'){  // MD
                if(($applied_leave->number_of_days > 2 && $next_approver_applied_leave == 0) || $next_approver_applied_leave == 1){

                    $leave_approval_insert_id = $applied_leave->appliedLeaveApprovals()->create($next_approval_data);
                    $applied_leave->notifications()->create($notification_data);

                    pushNotification($notification_data['receiver_id'], $notification_data['label'], $notification_data['message']);
                }else{  // Finally approve the leave
                    $applied_leave = $this->checkLeaveApprovalOnAllLevels($applied_leave);

                }
            }else{
                $leave_approval_insert_id = $applied_leave->appliedLeaveApprovals()->create($next_approval_data);
                $applied_leave->notifications()->create($notification_data);

                pushNotification($notification_data['receiver_id'], $notification_data['label'], $notification_data['message']);
            }

            //Send Mail && SMS to the next approver
            if(!empty($leave_approval_insert_id)){
                $mail_data['subject'] = 'Leave Application';
                $mail_data['to_email'] = $next_approver->manager->email;
                $mail_data['message'] = $applier->employee->fullname." has applied for a leave. Please take an action. Here is the link for website <a href='".url('/')."'Click here</a>";
                $mail_data['fullname'] = $next_approver->manager->employee->fullname;
                
                $this->sendGeneralMail($mail_data);

            }                                                            
        }elseif(empty($next_approver) && $request->leaveStatus == '1'){  //Approved on last level
            $applied_leave = $this->checkLeaveApprovalOnAllLevels($applied_leave);

        }elseif($request->leaveStatus != '1'){  //Leave Rejected
            $applied_leave->final_status = '0';
            $applied_leave->save();

        }elseif(!empty($next_approver) && $request->leaveStatus == '1' && !empty($next_approver_present)){
            //when approving again
            $applied_leave = $this->checkLeaveApprovalOnAllLevels($applied_leave);

        }

        $mail_data['to_email'] = $applier->email;
        $mail_data['fullname'] = $applier->employee->fullname;

        if($applied_leave->final_status == '1'){
            $probation_data = probationCalculations($applier);
            leaveRelatedCalculations($probation_data,$applied_leave);

            $message = "Your applied leave, from ".date('d/m/Y',strtotime($applied_leave->from_date)).' to '.date('d/m/Y',strtotime($applied_leave->to_date)).' has been approved.';

            $mail_data['subject'] = "Leave Approved";
            $mail_data['message'] = $message;
            $this->sendGeneralMail($mail_data);

            pushNotification($applier->id, $mail_data['subject'], $mail_data['message']);
        }else{  
            $update_leave_data = [
                                    'paid_count' => '0',
                                    'unpaid_count' => '0',
                                    'compensatory_count' => '0'
                                 ];

            $applied_leave->appliedLeaveSegregations()->update($update_leave_data); 

            CompensatoryLeave::where(['applied_leave_id'=>$applied_leave->id])
                                ->update(['applied_leave_id'=>0]); 

            if($leave_approval->leave_status == '2'){
                $message = "Your applied leave, from ".date('d/m/Y',strtotime($applied_leave->from_date)).' to '.date('d/m/Y',strtotime($applied_leave->to_date)).' has been rejected.';

                $mail_data['subject'] = "Leave Rejected";
                $mail_data['message'] = $message;
                $this->sendGeneralMail($mail_data);

                pushNotification($applier->id, $mail_data['subject'], $mail_data['message']);
            }                    
        }   

          
        return redirect("leaves/approve-leaves");

    }//end of function

    /*
        Check whether the leave has been approved by all concerned officers
    */
    function checkLeaveApprovalOnAllLevels($applied_leave)
    {
        $all_supervisors = $applied_leave->appliedLeaveApprovals()->count();
        $all_approved_supervisors = $applied_leave->appliedLeaveApprovals()->where(['leave_status'=>'1'])->count();

        if($all_supervisors == $all_approved_supervisors){
            $applied_leave->final_status = '1';
            $applied_leave->save();
        }

        return $applied_leave;

    }//end of function

    /*
        Get the list of all leave requests a leave officer has to take action on or already has
    */
    function approveLeaves($leave_status = null)
    {
        $user = User::where(['id'=>Auth::id()])->first();

        if(empty($leave_status) || $leave_status == 'pending'){
            $status = '0';
            $leave_status = 'pending';
        }elseif ($leave_status == 'approved') {
            $status = '1';
            $leave_status = 'Approved';
        }elseif ($leave_status == 'rejected') {
            $status = '2';
            $leave_status = 'Rejected';
        }

        $data = DB::table('applied_leave_approvals as ala')
                ->join('applied_leaves as al','al.id','=','ala.applied_leave_id')
                ->leftjoin('leave_replacements as lr','al.id','=','lr.applied_leave_id')
                ->join('employees as emp','emp.user_id','=','ala.user_id')
                ->leftjoin('employees as emp2','emp2.user_id','=','lr.user_id')
                ->join('leave_types as lt','al.leave_type_id','=','lt.id')
                ->where(['ala.supervisor_id' => $user->id,'ala.leave_status'=>$status,'al.isactive'=>1])
                ->select('ala.*','emp.fullname as applier_name','al.number_of_days','al.final_status','lt.name as leave_type_name','al.from_date','al.to_date','emp2.fullname as replacement_name','al.created_at')
                ->orderBy('ala.applied_leave_id','DESC')
                ->get();
                
        if(!$data->isEmpty()){
            foreach ($data as $key => $value) {
                if($value->final_status == '0'){
                    $check_rejected = DB::table('applied_leave_approvals as ala')
                                ->where(['ala.applied_leave_id' => $value->applied_leave_id,'ala.leave_status'=>'2'])
                                ->first();

                    if(!empty($check_rejected)){
                        $value->secondary_final_status = 'Rejected'; 
                    }else{
                        $value->secondary_final_status = 'In-Progress'; 
                    }
                }else{
                    $value->secondary_final_status = 'Approved';
                }
            }
        }        

        return view('leaves.list_applied_leave_approvals')->with(['data'=>$data,'selected_status'=>$leave_status]);

    }//end of function

    /*
        Get the list of all leave requests a user has applied for
    */
    function appliedLeaves()
    {
        $user = User::where(['id'=>Auth::id()])->first();
        $data = DB::table('applied_leaves as al')
                ->leftjoin('leave_replacements as lr','al.id','=','lr.applied_leave_id')
                ->leftjoin('employees as emp','emp.user_id','=','lr.user_id')
                ->join('leave_types as lt','al.leave_type_id','=','lt.id')
                ->where(['al.user_id' => $user->id])
                ->select('al.id','al.number_of_days','al.isactive','lt.name as leave_type_name','al.from_date','al.to_date','emp.fullname as replacement','al.final_status','al.created_at')
                ->orderBy('al.id','desc')
                ->get();        

        if(!$data->isEmpty()){
            foreach ($data as $key => $value) {
                $priority_wise_status = DB::table('applied_leave_approvals as ala')
                                  ->where(['ala.applied_leave_id' => $value->id])
                                  ->select('ala.priority','ala.leave_status')
                                  ->orderBy('ala.priority')
                                  ->get();

                $can_cancel_leave = 0;
                if(count($priority_wise_status) == 1 && $priority_wise_status[0]->leave_status == 0){
                    $can_cancel_leave = 1;
                }                      

                $value->priority_wise_status = $priority_wise_status;  
                $value->can_cancel_leave = $can_cancel_leave;  
                
                if($value->final_status == '0'){
                    $check_rejected = DB::table('applied_leave_approvals as ala')
                                ->where(['ala.applied_leave_id' => $value->id,'ala.leave_status'=>'2'])
                                ->first();

                    if(!empty($check_rejected)){
                        $value->secondary_final_status = 'Rejected'; 
                    }else{
                        $value->secondary_final_status = 'In-Progress'; 
                    }
                }else{
                    $value->secondary_final_status = 'Approved';
                }
            }
        }    

        return view('leaves.list_applied_leaves')->with(['data'=>$data]);
            
    }//end of function

    /*
        Ajax request to get details of a specific leave to show in modal
    */
    function appliedLeaveInfo(Request $request)
    {
        $data = DB::table('applied_leaves as al')
                ->join('states as s','s.id','=','al.state_id')
                ->join('cities as ci','ci.id','=','al.city_id')
                ->join('countries as c','c.id','=','al.country_id')
                ->join('countries as co','c.id','=','al.mobile_country_id')
                ->where(['al.id' => $request->applied_leave_id])
                ->select('al.*','s.name as state_name','ci.name as city_name','c.name as country_name','co.phone_code')
                ->first();

        $applied_leave = AppliedLeave::find($request->applied_leave_id);        

        $documents = $applied_leave->appliedLeaveDocuments()->get();        

        $view = View::make('leaves.applied_leave_info',['data'=>$data,'documents'=>$documents]);
        $contents = $view->render();
        return $contents;

    }//end of function 

    /*
        Download the document attached with an applied leave
    */
    function appliedLeaveDocument($id)
    {
        $document = AppliedLeaveDocument::find($id);
        $path_to_file = config('constants.uploadPaths.uploadAppliedLeaveDocument').$document->name;
        return response()->download($path_to_file);
    }//end of function

    /*
        Ajax request to get details of applied leave approvals to show in modal
    */
    function messages(Request $request)
    {
        $applied_leave = AppliedLeave::find($request->applied_leave_id);
        $messages = $applied_leave->messages()
                                ->where('label','Leave Remarks')
                                ->orderBy('created_at','DESC')
                                ->with('sender.employee:id,user_id,fullname')
                                ->with('receiver.employee:id,user_id,fullname')
                                ->get();

        $view = View::make('leaves.list_messages',['data' => $messages]);
        $contents = $view->render(); 

        return $contents;                       
    }//end of function

    /*
        Cancel a leave request before any leave officer has taken an action
    */
    function cancelAppliedLeave($applied_leave_id)
    {
        $applied_leave = AppliedLeave::find($applied_leave_id);
        $user_id = Auth::id();
        $approval = $applied_leave->appliedLeaveApprovals()  
                                  ->where('leave_status','!=','0')
                                  ->first();

        if(!empty($approval)){
            return redirect()->back()->with('cannot_cancel_error','Reporting manager has taken a decision. You cannot cancel the leave now.');
        
        }elseif(($applied_leave->user_id == $user_id) && empty($approval)){
            $applied_leave->isactive = 0;
            $applied_leave->save();

            CompensatoryLeave::where('applied_leave_id',$applied_leave_id)
                               ->update(['applied_leave_id'=>0]); 
        }                          

        return redirect('leaves/applied-leaves');

    }//end of function

    /*
        Send an email with a very basic formatting
    */
    function sendGeneralMail($mail_data)
    {   //mail_data Keys => to_email, subject, fullname, message

        if(!empty($mail_data['to_email'])){
            Mail::to($mail_data['to_email'])->send(new GeneralMail($mail_data));
        }

        return true;

    }//end of function

    /*
        Get information from database to show it on leave report form page
    */
    function leaveReportForm()
    {
        $data['departments'] = Department::where(['isactive'=>1])->get();
        $data['projects'] = Project::where(['isactive'=>1,'approval_status'=>'1'])->get();

        return view('leaves.leave_report_form')->with(['data'=>$data]);

    }//end of function

    /*
        Filter & generate leave report as per selected parameters & show them in a list
    */
    function createLeaveReport(Request $request)
    {
        $report_data =  [
                            'from_date' => $request->fromDate,
                            'to_date' => $request->toDate,
                            'no_days' => $request->noDays,
                            'weekends' => $request->weekends,
                            'holidays' => $request->holidays
                        ];

        if($request->department == '0'){
            $report_data['department_id'] = "";
            $report_data['department_sign'] = "!=";
        }else{
            $report_data['department_id'] = $request->department;
            $report_data['department_sign'] = "=";
        }

        if($request->project == '0'){
            $report_data['project_id'] = "";
            $report_data['project_sign'] = "!=";
        }else{
            $report_data['project_id'] = $request->project;
            $report_data['project_sign'] = "=";
        }

        $from_date = date("Y-m-d",strtotime($report_data['from_date']));
        $to_date = date("Y-m-d",strtotime($report_data['to_date']));

        $profile_pic_path = config('constants.uploadPaths.profilePic');
        $static_pic = config('constants.static.profilePic');

        //print_r($report_data);die;

        $data = DB::table('applied_leaves as al')
                ->join('applied_leave_segregations as als','al.id','=','als.applied_leave_id')
                ->join('employee_profiles as emp','emp.user_id','=','al.user_id')
                ->join('users as u','al.user_id','=','u.id')
                ->join('employees as e','al.user_id','=','e.user_id')
                ->join('project_user as pu','pu.user_id','=','al.user_id')
                ->where(['al.final_status'=>'1'])
                ->where('als.from_date','>=',$from_date)    
                ->where('als.to_date','<=',$to_date)
                ->where('pu.project_id',$report_data['project_sign'],$report_data['project_id'])
                //->where('emp.location_id',$report_data['locationSign'],$report_data['locationId'])
                ->where('emp.department_id',$report_data['department_sign'],$report_data['department_id'])
                ->select("al.user_id","u.employee_code","e.fullname",DB::raw("SUM(als.paid_count) as paid_count,SUM(als.compensatory_count) as compensatory_count,SUM(als.unpaid_count) as unpaid_count, CASE WHEN e.profile_picture = '' OR e.profile_picture IS NULL THEN '".$static_pic."' ELSE CONCAT('".$profile_pic_path."',e.profile_picture) END AS profile_picture"))
                ->groupBy("al.user_id")
                ->orderBy("e.fullname")    
                ->get();        

        return view('leaves.list_leave_report')->with(['report_data'=>$report_data,'data'=>$data]);
                        
    }//end of function

    /*
        Show the details of a specific person when selected from a leave report list
    */
    function additionalLeaveReportInfo(Request $request)
    {
        $report_data =  [
                            'from_date' => $request->from_date,
                            'to_date' => $request->to_date,
                            'user_id' => $request->id
                        ];                

        $from_date = date("Y-m-d",strtotime($report_data['from_date']));
        $to_date = date("Y-m-d",strtotime($report_data['to_date']));  

        $data = DB::table('applied_leaves as al')
                ->join('applied_leave_segregations as als','al.id','=','als.applied_leave_id')
                ->where(['al.final_status'=>'1','al.user_id'=>$report_data['user_id']])
                ->where('als.from_date','>=',$from_date)    
                ->where('als.to_date','<=',$to_date)
                ->select("al.*","als.*")
                ->orderBy("al.created_at","desc")    
                ->get();       

        $employee_data = User::where(['id'=>$request->id])
                            ->with('employee')
                            ->first();

        return view('leaves.additional_leave_report_info')->with(['report_data'=>$report_data,'data'=>$data,'employee_data'=>$employee_data]);
                              
    }//end of function

}//end of class 
