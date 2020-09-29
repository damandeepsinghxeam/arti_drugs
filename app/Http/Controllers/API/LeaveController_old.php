<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
use Carbon\CarbonPeriod;
use Auth;
use View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Mail;
use App\Mail\GeneralMail;
use App\AppliedLeaveDocument;
use Validator;
use Illuminate\Validation\Rule;

class LeaveControllerOld extends Controller
{
    /*
        Get the leave balance of an user
    */
    function leaveBalance(Request $request){
        checkDeviceId($request->user());

        $leave_data = probationCalculations($request->user());
        $success['leave_data'] = $leave_data;

        if(empty($leave_data)){
            return response()->json(['success' => $success], 204);    
        }else{
            return response()->json(['success' => $success], 200);
        }
    }

    /* 
        Get the list of leaves applied by an user
    */
    function appliedLeaves(Request $request){
        checkDeviceId($request->user());

        $validator = Validator::make($request->all(), [
            'from_date' => 'required',
            'to_date' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['validation_error' => $validator->errors()], 400);
        }

        $between = [$request->from_date,$request->to_date]; 
        $leaves = AppliedLeave::where(['user_id'=>$request->user()->id])
                                ->whereBetween('from_date',$between)
                                ->whereBetween('to_date',$between)
                                ->select('id','user_id','leave_type_id','from_date','to_date','from_time','to_time','number_of_days','reason','final_status','secondary_leave_type','leave_half','isactive','created_at')
                                ->with(['messages' => function($query){
                                    $query->where(['label'=>'Leave Remarks'])
                                        ->select('id','messageable_id','sender_id','message','label','created_at')
                                        ->with('sender.employee:id,user_id,fullname')
                                        ->orderBy('created_at','DESC');
                                }])
                                ->with('leaveType:id,name')
                                //->with('leaveReplacement.user.employee:id,user_id,fullname')
                                ->orderBy('from_date','DESC')    
                                ->get();                      

        if(!$leaves->isEmpty()){
            foreach ($leaves as $leave) {
                $leave_approvals = $leave->appliedLeaveApprovals()
                                            ->select('priority','leave_status')
                                            ->orderBy('priority')
                                            ->get();

                $can_cancel_leave = 0;
                if($leave->isactive == 1 && count($leave_approvals) == 1 && $leave_approvals[0]->leave_status == 0){
                    $can_cancel_leave = 1;
                }
                $leave->can_cancel_leave = $can_cancel_leave;

                if($leave->isactive == 0){
                    $leave->secondary_final_status = 'Cancelled';
                }else{
                    if($leave->final_status == '1'){
                        $leave->secondary_final_status = 'Approved';
                    }else{
                        $rejected = $leave->appliedLeaveApprovals()
                                          ->where('leave_status','2')
                                          ->first();
    
                        if(empty($rejected)){
                            $leave->secondary_final_status = 'Inprogress';
                        }else{
                            $leave->secondary_final_status = 'Rejected';
                        }                  
                    }
                }
            }
            $status_code = 200;   
        }else{
            $status_code = 204;
        }
        $success['leaves'] = $leaves;
        return response()->json(['success' => $success], $status_code);                        
    }

    /*
        List the leaves that a user has approved, rejected or is pending from their end
    */
    function approveLeaves(Request $request)
    {
        checkDeviceId($request->user());
        $validator = Validator::make($request->all(), [
            'leave_status' => [
                'required', 
                Rule::in(['0','1','2']),
            ],
            'month' => 'required',
            'year' => 'required',
        ]);
        
        if($validator->fails()){
            return response()->json(['validation_error' => $validator->errors()], 400);
        }

        $auth_user = $request->user();
        if(!userHasPermissions($auth_user,['approve-leave'])){
            return response()->json(['error' => 'You do not have permission to access this module!'], 403);
        }

        $year = $request->year;
        $month = $request->month;

        $leave_approvals = AppliedLeaveApproval::where(['supervisor_id'=>$auth_user->id, 'leave_status'=>$request->leave_status])
                            ->whereHas('appliedLeave', function(Builder $query)use($month,$year){
                                $query->where('isactive',1)
                                    ->whereMonth('from_date',$month)
                                    ->whereYear('from_date',$year);

                            })->with(['appliedLeave' => function($query)use($month,$year){
                                $query->where('isactive',1)
                                      ->whereMonth('from_date',$month)
                                      ->whereYear('from_date',$year)  
                                      ->select('id','user_id','leave_type_id','from_date','to_date','from_time','to_time','number_of_days','reason','final_status','secondary_leave_type','leave_half','isactive','created_at')
                                      ->with(['messages' => function($query){
                                          $query->where(['label'=>'Leave Remarks'])
                                                ->select('id','messageable_id','sender_id','label','message','created_at')
                                                ->orderBy('created_at','DESC')
                                                ->with('sender.employee:id,user_id,fullname');
                                      }]);
                                      //->with('leaveReplacement.user.employee:id,user_id,fullname');
                            }])
                            ->with('user.employee:id,user_id,fullname')
                            ->with('user:id,employee_code')
                            ->orderBy('created_at', 'DESC')
                            ->get();

        if(!$leave_approvals->isEmpty()){
            foreach ($leave_approvals as $approval) {
                if($approval->appliedLeave->final_status == '1'){
                    $approval->appliedLeave->secondary_final_status = 'Approved';
                }else{
                    $rejected = $approval->appliedLeave->appliedLeaveApprovals()
                                      ->where('leave_status','2')
                                      ->first();

                    if(empty($rejected)){
                        $approval->appliedLeave->secondary_final_status = 'Inprogress';
                    }else{
                        $approval->appliedLeave->secondary_final_status = 'Rejected';
                    }                  
                }
            }
            $status_code = 200;
        }else{
            $status_code = 204;
        }

        $success['leave_approvals'] = $leave_approvals;
        return response()->json(['success' => $success], $status_code);
    }

    /*
        Get the details of a specific leave
    */
    function leaveDetail(Request $request)
    {
        checkDeviceId($request->user());

        $validator = Validator::make($request->all(), [
            'applied_leave_id' => 'required',
            'leave_approval_id' => 'required', //send 0 if viewed from applier-side 
        ]);

        if($validator->fails()){
            return response()->json(['validation_error' => $validator->errors()], 400);
        }

        $applied_leave = AppliedLeave::where('id',$request->applied_leave_id)
                                        ->with('leaveType:id,name')
                                        ->with('country:id,name')
                                        ->with('state:id,name')
                                        ->with('city:id,name')
                                        ->with('leaveReplacement.user.employee:id,user_id,fullname')
                                        ->with(['appliedLeaveApprovals' => function($query){
                                            $query->orderBy('priority');
                                        }])
                                        ->with('user.employee:id,user_id,fullname')
                                        ->with('user:id,employee_code')
                                        ->first();
        
        if(!empty($applied_leave->from_time)){
            $date = date("Y-m-d");
            $applied_leave->from_time = date('h:i A',strtotime($date.' '.$applied_leave->from_time));
        }
        
        if(!empty($applied_leave->to_time)){
            $date = date("Y-m-d");
            $applied_leave->to_time = date('h:i A',strtotime($date.' '.$applied_leave->to_time));
        }

        if(!$request->leave_approval_id){ //leave-details on applier-side
            if($applied_leave->appliedLeaveApprovals[0]->leave_status == '0'){
                $applied_leave->can_cancel_leave = 1;
            }else{
                $applied_leave->can_cancel_leave = 0;
            }                                        
        }else{ //leave-details on approver-side
            $applied_leave->leave_approval = AppliedLeaveApproval::find($request->leave_approval_id);
        }

        unset($applied_leave->appliedLeaveApprovals);
        
        $success['leave_detail'] = $applied_leave;
        return response()->json(['success' => $success], 200);
    }

    /*
        Cancel a leave application before any approver has taken any action
    */
    function cancelLeave(Request $request){
        checkDeviceId($request->user());
        $validator = Validator::make($request->all(),[
            'applied_leave_id' => 'required',
        ]);

        $applied_leave = AppliedLeave::with(['appliedLeaveApprovals' => function($query){
                                            $query->orderBy('priority');
                                        }])->find($request->applied_leave_id);

        if($applied_leave->appliedLeaveApprovals[0]->leave_status !== '0'){
            return response()->json(['error' => 'Sanction Officer 1 has taken a decision. You cannot cancel the leave now.'], 405);
        }else{
            $applied_leave->isactive = 0;
            $applied_leave->save();

            CompensatoryLeave::where('applied_leave_id',$applied_leave->id)
                               ->update(['applied_leave_id'=>0]);
        }
        
        $success['message'] = 'Your leave has been cancelled.';
        return response()->json(['success'=>$success], 200);
    }

    /*
        Approve or Reject an applied leave with remarks
    */
    function leaveApproval(Request $request)
    {
        checkDeviceId($request->user());
        $validator = Validator::make($request->all(),[
            'remark' => 'required',
            'leave_approval_id' => 'required',
            'leave_status' => [
                'required',  
                Rule::in(['1', '2']),
            ]    
        ]);

        if($validator->fails()){
            return response()->json(['validation_error' => $validator->errors()], 400);
        }

        $leave_approval = AppliedLeaveApproval::find($request->leave_approval_id);
        $applied_leave = $leave_approval->appliedLeave;

        /////////////////Checks////////////////////////
        $current_date = date('Y-m-d');    
        $restriction_date = config('constants.restriction.approveLeave');    
        $current_month_start_date = date("Y-m-01");

        if(strtotime($current_date) > strtotime($restriction_date)){
            if(strtotime($applied_leave->from_date) < strtotime($current_month_start_date)){
                $restriction_error = "You cannot approve leave for a previous month's date now.";
                return response()->json(['error'=>$restriction_error], 405);
            }
        }

        $approver = User::where(['id'=>Auth::id()])->first();

        $leave_approval->leave_status = $request->leave_status;
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

        if(!empty($next_approver) && $request->leave_status == '1' && empty($next_approver_present)){  //Approved on previous level
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
        }elseif(empty($next_approver) && $request->leave_status == '1'){  //Approved on last level
            $applied_leave = $this->checkLeaveApprovalOnAllLevels($applied_leave);

        }elseif($request->leave_status != '1'){  //Leave Rejected
            $applied_leave->final_status = '0';
            $applied_leave->save();

        }elseif(!empty($next_approver) && $request->leave_status == '1' && !empty($next_approver_present)){
            //when approving again
            $applied_leave = $this->checkLeaveApprovalOnAllLevels($applied_leave);

        }

        $mail_data['to_email'] = $applier->email;
        $mail_data['fullname'] = $applier->employee->fullname;

        if($applied_leave->final_status == '1'){
            $probation_data = probationCalculations($applier);
            leaveRelatedCalculations($probation_data,$applied_leave);

            $mail_data['subject'] = "Leave Approved";
            $mail_data['message'] = "Your leave has been approved. Check status on the <a href='".url('/')."'>website</a>.";
            $this->sendGeneralMail($mail_data);

            $message = "Your applied leave, from ".date('d/m/Y',strtotime($applied_leave->from_date)).' to '.date('d/m/Y',strtotime($applied_leave->to_date)).' has been approved.';

            pushNotification($applier->id, $mail_data['subject'], $message);
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
                $mail_data['subject'] = "Leave Rejected";
                $mail_data['message'] = "Your leave has been rejected. Check status on the <a href='".url('/')."'>website</a>.";
                $this->sendGeneralMail($mail_data);

                $message = "Your applied leave, from ".date('d/m/Y',strtotime($applied_leave->from_date)).' to '.date('d/m/Y',strtotime($applied_leave->to_date)).' has been rejected.';

                pushNotification($applier->id, $mail_data['subject'], $message);
            }                    
        }

        $success['leave_approval'] = $leave_approval;
        return response()->json(['success' => $success], 200);
    }

    /*
        Save the approval status assigned by leave officer & if approved send the approval 
        to next officer
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
    }

    function sendGeneralMail($mail_data)
    {   //mail_data Keys => to_email, subject, fullname, message
        if(!empty($mail_data['to_email'])){
            try{
                Mail::to($mail_data['to_email'])->send(new GeneralMail($mail_data));
            
            }catch(\Exception $e){
                return $e->getMessage();
            }
        }

        return true;
    }

    /*
        Data to be shown on the apply leave form
    */
    function applyLeave(Request $request)
    {
        checkDeviceId($request->user());
        
        $user = User::where('id',$request->user()->id)
                    ->with('employee:id,user_id,gender')
                    ->first();
        
        $data['leave_types'] = LeaveType::where(['isactive'=>1])->select('id','name')->get();
    	$data['departments'] = Department::where(['isactive'=>1])->select('id','name')->get();
    	$data['countries'] = Country::where(['isactive'=>1])->select('id','name','phone_code')->get();
    	$data['states'] = State::where(['isactive'=>1])->select('id','country_id','name')->get();
        $data['gender'] = $user->employee->gender;
    	$data['probation_data'] = probationCalculations($user);
        
        if(empty($data['probation_data'])){
            return response()->json(['error' => 'Your profile is incomplete. Please contact the HR officer.'], 405);
        }else{
            $success['leave_data'] = $data;
            return response()->json(['success' => $success], 200);
        }
    }

    /*
        Check the holidays between leave's from date & to date
    */
    function betweenLeaveHolidays(Request $request)
    {
        checkDeviceId($request->user());
        $validator = Validator::make($request->all(), [
            'from_date' => 'required',
            'to_date' => 'required',
            'secondary_leave_type' => 'required',
        ]);
        
        if($validator->fails()){
            return response()->json(['validation_error' => $validator->errors()], 400);
        }
        
        $period = CarbonPeriod::create($request->from_date, $request->to_date);
        $excluded_dates = [];
        $included_dates = [];
        
        if(!empty($period)){
            foreach ($period as $day) {
                $value = $day->format('Y-m-d');
                $date = date("l",strtotime($value));
                $type = '';
                if($date !== 'Sunday'){
                    $holiday = Holiday::where(['isactive'=>1])
                                    ->where('holiday_from','<=',$value)
                                    ->where('holiday_to','>=',$value)
                                    ->first();
                    
                    if(!empty($holiday)){
                        $type = 'Holiday';
                        $excluded_dates[] = $value;    
                    }                            
                }else{
                    $type = 'Sunday';
                    $excluded_dates[] = $value;
                }

                if(!$type){
                    $included_dates[] = $value; 
                }
            }
        }
        
        $success['excluded_dates'] = implode(',',$excluded_dates);
        $success['included_dates'] = implode(',',$included_dates);
        $success['number_of_days'] = count($period) - count($excluded_dates);

        if($success['number_of_days']){
            if($request->secondary_leave_type === 'Short'){
                $success['number_of_days'] = 0.25;
            }elseif($request->secondary_leave_type === 'Half'){
                $success['number_of_days'] = 0.5;
            }
        }
        return response()->json(['success' => $success], 200);
    }

    /*
        Check the employees of a department that are available between leave's from date & to date
    */
    function leaveReplacementAvailability(Request $request)
    {
        checkDeviceId($request->user());
        $validator = Validator::make($request->all(),[
            'from_date' => 'required',
            'to_date' => 'required',
            'department_id' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['validation_error' => $validator->errors()], 400);
        }

        $user = User::find($request->user()->id);

        $from_date = date("Y-m-d",strtotime($request->from_date));
        $to_date = date("Y-m-d",strtotime($request->to_date));

        $employees = EmployeeProfile::where(['department_id'=>$request->department_id,'isactive'=>1])
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

        $exclusions = Employee::whereIn('user_id',$employees)
                            ->whereNotIn('user_id',$took_leaves)
                            ->select('user_id','fullname')
                            ->with('user:id,employee_code')
                            ->get();          
                        
        $success['employees'] = $exclusions;
        return response()->json(['success' => $success], 200);
    }

    /*
        Save the applied leave details in database & send notifications to Sanction Officer & Leave Replacement
    */
    function storeAppliedLeave(Request $request)
    {
        checkDeviceId($request->user());
        $validator = Validator::make($request->all(), [
            'from_date' => 'required',
            'to_date' => 'required',
            'reason' => 'required',
            'replacement_id' => 'required',
            'number_of_days' => 'required',
            'leave_type_id' => 'required',
            'country_id' => 'required',
            'state_id' => 'required',
            'city_id' => 'required',
            'mobile_country_id' => 'required',
            'mobile_number' => 'required',
            'secondary_leave_type' => 'required', // Full, Half, Short
        ]);

        if($validator->fails()){
            return response()->json(['validation_error' => $validator->errors()], 400);
        }

        /* Checks */
        $current_date = date('Y-m-d');
        $restriction_date = config('constants.restriction.applyLeave');
        $current_month_start_date = date('Y-m-01');

        if(strtotime($current_date) > strtotime($restriction_date)){
            if(strtotime(date("Y-m-d",strtotime($request->from_date))) < strtotime($current_month_start_date)){
                $error = "You cannot apply leave for a previous month's date now.";
                return response()->json(['error' => $error], 405);
            }
        }

        if($request->number_of_days == 0){
            $error = "The number of days should not be zero.";
            return response()->json(['error' => $error], 405);
        }

        $user = User::where(['id' => $request->user()->id])
                    ->whereHas('userManager', function(Builder $query){
                        $query->where('isactive', 1);
                    })
                    ->with('employee')
                    ->with('userManager')
                    ->first();

        if(empty($user)){
            $error = "You do not have a Sanction Officer. Please contact the HR administrator.";
            return response()->json(['error' => $error], 405);
        } 
        
        $pending_leave = AppliedLeaveApproval::where(['user_id' => $user->id,'leave_status' => '0'])
                                            ->whereHas('appliedLeave', function(Builder $query){
                                                $query->where('isactive',1);
                                            })
                                            ->first();

        if(!empty($pending_leave)){
            $error = "The approval status of your previously applied leave is pending with one or more authorities. Please contact the concerned person and clear it first.";
            return response()->json(['error' => $error], 405);
        }
        
        $last_applied_leave = $user->appliedLeaves()
                                   ->where('isactive', 1)
                                   ->orderBy('id','DESC')
                                   ->first();
                                   
        if(empty($last_applied_leave)){
            $created_at = new Carbon($last_applied_leave->created_at);
            $now = Carbon::now();
            $apply_difference = $created_at->diffInHours($now,false);

            if($apply_difference < 2){
                $leave_time_difference = true;
            }else{
                $leave_time_difference = false;
            }

            if($leave_time_difference){
                $error = "You have to wait for some time before you can apply for leave again.";
                //return response()->json(['error' => $error], 405); 
            }
        }
        
        $check_dates =  [
            'from_date' => $request->from_date,
            'to_date' => $request->to_date, 
            'isactive' => 1
        ];    

        if($request->secondary_leave_type == "Short"){
            $check_dates['from_time'] = $request->from_time;
            $check_dates['to_time'] = $request->to_time;

        }elseif($request->secondary_leave_type == "Half"){
            $check_dates['leave_half'] = $request->leave_half;
        }   

        $already_applied_leave = $user->appliedLeaves()->where($check_dates)->first();

        if(!empty($already_applied_leave)){
            $error = "You have already applied for a leave on the given dates.";
            return response()->json(['error' => $error], 405);
        }

        if($request->leave_type_id == '4'){  //check for maternity leave
            if($request->number_of_days > 90){
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
                return response()->json(['error' => $maternity_error], 405);
            }
        }
        //end of checks

        //Create leave 
        $leave_data = [  
            'leave_type_id' => $request->leave_type_id,
            'country_id' => $request->country_id,
            'state_id' => $request->state_id,
            'city_id' => $request->city_id,
            'reason' => $request->reason,
            'number_of_days' => $request->number_of_days, 
            'from_time' => $request->from_time,
            'to_time' => $request->to_time,
            'mobile_country_id' => $request->mobile_country_id,
            'mobile_number' => $request->mobile_number,
            "secondary_leave_type" => $request->secondary_leave_type,
            'from_date' => $request->from_date, 
            'to_date' => $request->to_date,
            'excluded_dates' => $request->excluded_dates, 
            'tasks' => $request->tasks,
            'leave_half' => $request->leave_half,
            'final_status' => '0'
        ];

        if($request->secondary_leave_type == "Half"){
            $leave_data['leave_half'] = $request->leave_half;
        }

        $applied_leave = $user->appliedLeaves()->create($leave_data);
        $replacement = $applied_leave->leaveReplacement()->create(['user_id'=>$request->replacement_id]);

        if(!empty($request->leave_documents)){
            $documents = $request->leave_documents;

            foreach($documents as $doc) {
                $document = round(microtime(true)).str_random(5).'.'.$doc->getClientOriginalExtension();
                $doc->move(config('constants.uploadPaths.uploadAppliedLeaveDocument'), $document);

                $document_data['name'] = $document;
                $applied_leave->appliedLeaveDocuments()->create($document_data);
            }
        }

        /* Segregate leave, month wise */
        if($request->secondary_leave_type != "Full"){
            $segregation_data =  [
                'from_date' => date("Y-m-d",strtotime($request->from_date)),
                'to_date' => date("Y-m-d",strtotime($request->to_date)),
                'number_of_days' => $request->number_of_days,
                'paid_count' => '0',
                'unpaid_count' => '0',
                'compensatory_count' => '0',
            ];
            $applied_leave->appliedLeaveSegregations()->create($segregation_data);

        }elseif ($request->included_dates && $request->secondary_leave_type == "Full") {
            $included_dates = explode(",",$request->included_dates);
        
            $month_wise_array = [];
            $counter = 0;
            $key2 = 0;
            $days_counter = 0;
            foreach($included_dates as $key => $value) {
                
                if($counter == 0){
                    $month_wise_array[$key2]['from_date'] = $value;
                    $month_wise_array[$key2]['no_days'] = ++$days_counter;
                    $prev_month_year = date("m-Y",strtotime($value));
                    $prev_date = $value;

                    if(count($included_dates) == 1){
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
                        
                        if((count($included_dates)-1) == $counter){
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
        }
        //end leave segregation

        /* Leave Approval */
        $approval_data = [
            'user_id' => $user->id,
            'supervisor_id' => $user->userManager->manager_id,
            'priority' => '1',
            'leave_status' => '0'
        ];
        $applied_leave->appliedLeaveApprovals()->create($approval_data);

        /* Notify */
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

        $notification_data['receiver_id'] = $request->replacement_id;
        $notification_data['message'] = $message." And selected you as replacement."; 
        $applied_leave->notifications()->create($notification_data);

        pushNotification($notification_data['receiver_id'], $notification_data['label'], $notification_data['message']);

        $replacement = Employee::where(['user_id'=>$request->replacement_id])
                                ->with('user')
                                ->first();

        $message = $user->employee->fullname." has selected you as replacement during their ".$request->secondary_leave_type." leave and has handed over the duties and responsibilities to you for the given time period of ".date('d/m/Y',strtotime($request->from_date))." to ".date('d/m/Y',strtotime($request->to_date)).".";

        $mail_data = array();
        $mail_data['to_email'] = $replacement->user->email;
        $mail_data['subject'] = "Replacement during my absence";
        $mail_data['message'] = $message;
        $mail_data['fullname'] = $replacement->fullname;

        $this->sendGeneralMail($mail_data);

        $reporting_manager = Employee::where(['user_id'=>$user->userManager->manager_id])
                                    ->with('user')
                                    ->first();

        $mail_data['to_email'] = $reporting_manager->user->email;
        $mail_data['subject'] = "Leave Application";
        $mail_data['message'] = $user->employee->fullname." has applied for a leave. Please take an action. Here is the link for website <a href='".url('/')."'>Click here</a>";
        $mail_data['fullname'] = $reporting_manager->fullname;

        $this->sendGeneralMail($mail_data);

        $success['leave_detail'] = $applied_leave;
        return response()->json(['success' => $success], 200); 
    }

}//end of class
