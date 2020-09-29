<?php

use App\Attendance;
use App\Holiday;
use App\AppliedLeave;
use App\AttendanceRemark;
use App\AttendancePunch;
use App\TravelApproval;
use App\TbltTimesheet;
use Carbon\Carbon;
use App\CompensatoryLeave;
use App\User;
use App\ShiftException;
use App\Shift;
use App\Band;

/*
    Revoke accessToken if device id is null 
*/
function checkDeviceId($user)
{
    if($user->device_id == null){
        $user->token()->revoke();
    }
    return true;
}

/*
    Check whether user has a specific permission
*/
function userHasPermissions($user, $check_permissions){
    $permissions = $user->permissions()->pluck('name')->toArray();

    foreach($check_permissions as $permission){
        if(!in_array($permission, $permissions)){
            $flag = false;
            break;
        }else{
            $flag = true;
        }
    }

    return $flag;
}

function pushNotification($user_id, $title, $body)
{
    $user = User::find($user_id);
    try{
        if(!empty($user->device_id)){
            $url = "https://fcm.googleapis.com/fcm/send";
            $device_ids = array();
            array_push($device_ids, $user->device_id);

            $serverKey = env('FCM_KEY'); //your server token of FCM project
            
            $notification = array(
                'title' =>$title , 
                'body' => $body, 
                'sound' => 'default', 
                'badge' => '1',
            );
            $arrayToSend = array(
                'registration_ids' => $device_ids, 
                'notification' => $notification,
                'priority'=>'high',
            );

            $json = json_encode($arrayToSend);
            $headers = array();
            $headers[] = 'Content-Type: application/json';
            $headers[] = 'Authorization: key='. $serverKey;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
            curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
            //Send the request
            $response = curl_exec($ch);
            //Close request
            // if ($response === FALSE) {
            //     die('FCM Send Error: ' . curl_error($ch));
            // }
            curl_close($ch);
        }
    }catch(\Exception $e){
        return $e->getMessage();
    }
}

function sms($phone, $message, $type='FYI') {

    /*try {
        $ch = curl_init();
        $url='http://180.151.98.11/Api.aspx?usr=xeam&pwd=welcome123&smstype=TextSMS&to='.$phone.'&msg='.urlencode($message).'&rout=Transactional&from=XEAMHR';
        //$url='http://180.151.98.11/SecureApi.aspx?usr=xeam&key=7B55BE6D-540D-478C-91E7-A72378823ADA&smstype=TextSMS&to='.$phone.'&msg='.$message.'&rout=Transactional&from=XEAMHR'
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        curl_close ($ch);
        return $server_output;
    }catch(\Exception $e) {
        return false;
    }*/

    $message = $type . ': ' .$message;
    // FYI Just to inform user.
    // IMP User's attention required.
    // ACT Some action needs to be performed by the user.
    try {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://eu153.chat-api.com/instance146819/sendMessage?token=0w9n8tgcbnht265e');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "{\n    \"phone\":  \"91"."$phone\", \"body\": \"$message\" }");

        $headers = array();
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Accept: application/json';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $server_output = curl_exec($ch);
        curl_close($ch);

        return $server_output;

    } catch(\Exception $e) {
        return false;
    }
}

function leaveRelatedCalculations($probation_data,$applied_leave)
{
    $current_year = date("Y");
    $current_month = date("n");
    $applied_leave_segregations = $applied_leave->appliedLeaveSegregations()->get();

    foreach ($applied_leave_segregations as $key => $seg_data) { //foreach 1
        $applied_leave_month = date("n",strtotime($seg_data->from_date));
        $applied_leave_year = date("Y",strtotime($seg_data->from_date));

        if($current_month != $applied_leave_month){
            $current_month = $applied_leave_month;
        }

        if($current_year != $applied_leave_year){
            $current_year = $applied_leave_year;
        }

        $current_month_paid_leaves = DB::table('applied_leaves as al')
            ->join('applied_leave_segregations as als','als.applied_leave_id','=','al.id')
            ->where(['al.isactive'=>1,'al.final_status'=>'1','al.user_id'=>$applied_leave->user_id])
            ->whereYear('als.from_date',$current_year)  //works with to_date as well
            ->whereMonth('als.from_date',$current_month)  //works with to_date as well
            ->select(DB::raw("SUM(als.paid_count) as paid_count,SUM(als.compensatory_count) as compensatory_count"))
            ->first();

        if($current_month_paid_leaves->paid_count == ""){
            $current_month_paid_leaves->paid_count = 0;
        }

        if($current_month_paid_leaves->compensatory_count == ""){
            $current_month_paid_leaves->compensatory_count = 0;
        }

        $current_month_total_leaves = $current_month_paid_leaves->paid_count + $current_month_paid_leaves->compensatory_count;
        $compensatory_leaves_array = [];

        if($applied_leave->leave_type_id == '4'){  //check for maternity leave
            $return_data['paid_count'] = $seg_data->number_of_days;
            $return_data['unpaid_count'] = 0;
            $return_data['compensatory_count'] = 0;

        }elseif($applied_leave->leave_type_id == '3'){ //check for unpaid leave
            $return_data['paid_count'] = 0;
            $return_data['unpaid_count'] = $seg_data->number_of_days;
            $return_data['compensatory_count'] = 0;

        }else{
            if($applied_leave->secondary_leave_type != 'Full'){
                $return_data['compensatory_count'] = 0;
                if($probation_data->leaves_left >= $seg_data->number_of_days){

                    if($current_month_total_leaves >= 3){
                        $return_data['paid_count'] = 0;
                        $return_data['unpaid_count'] = $seg_data->number_of_days;

                    }elseif($current_month_total_leaves < 3){
                        $monthly_leaves_remaining = 3 - $current_month_total_leaves;

                        if($monthly_leaves_remaining >= $seg_data->number_of_days){
                            $return_data['paid_count'] = $seg_data->number_of_days;
                            $return_data['unpaid_count'] = 0;

                        }else{
                            $return_data['paid_count'] = $monthly_leaves_remaining;
                            $return_data['unpaid_count'] = $seg_data->number_of_days - $monthly_leaves_remaining;
                        }
                    }
                }else{
                    $return_data['paid_count'] = $probation_data->leaves_left;
                    $return_data['unpaid_count'] = $seg_data->number_of_days - $return_data['paid_count'];
                }
            }else{ //Full Day Leaves
                if($current_month_total_leaves >= 3){
                    $return_data['paid_count'] = 0;
                    $return_data['unpaid_count'] = $seg_data->number_of_days;
                    $return_data['compensatory_count'] = 0;

                }else{
                    $monthly_leaves_remaining = 3 - $current_month_total_leaves;
                    if($monthly_leaves_remaining > 1){
                        $original_applied_leave_days = $seg_data->number_of_days;

                        if($probation_data->compensatory_leaves_count >= 1){
                            $integer_monthly_remaining_leaves = (int)$monthly_leaves_remaining;
                            $flag = 1;

                            foreach ($probation_data->compensatory_leaves as $key => $value) {
                                if($flag <= $integer_monthly_remaining_leaves && $original_applied_leave_days > 0){
                                    $compensatory_leaves_array[] = $value->id;
                                }else{
                                    break;
                                }

                                $original_applied_leave_days--;
                                $flag++;
                            }

                            if($original_applied_leave_days == 0){
                                $return_data['compensatory_count'] = count($compensatory_leaves_array);
                                $return_data['paid_count'] = 0;
                                $return_data['unpaid_count'] = 0;

                            }else{  //if($original_applied_leave_days != 0)
                                $return_data['compensatory_count'] = count($compensatory_leaves_array);
                                $monthly_remaining_leaves_left = $monthly_leaves_remaining - $return_data['compensatory_count'];

                                if($monthly_remaining_leaves_left > 0){
                                    if($probation_data->leaves_left >= $monthly_remaining_leaves_left){

                                        if($original_applied_leave_days >= $monthly_remaining_leaves_left){
                                            $return_data['paid_count'] = $monthly_remaining_leaves_left;
                                            $return_data['unpaid_count'] = $original_applied_leave_days -$monthly_remaining_leaves_left;

                                        }else{
                                            $return_data['paid_count'] = $original_applied_leave_days;
                                            $return_data['unpaid_count'] = 0;

                                        }
                                    }else{
                                        $return_data['paid_count'] = $probation_data->leaves_left;
                                        $return_data['unpaid_count'] = $original_applied_leave_days - $probation_data->leaves_left;
                                    }
                                }else{
                                    $return_data['paid_count'] = 0;
                                    $return_data['unpaid_count'] = $original_applied_leave_days;

                                }
                            }
                        }else{   //if($probation_data->compensatory_leaves_count == 0)
                            $return_data['compensatory_count'] = 0;
                            $monthly_remaining_leaves_left = $monthly_leaves_remaining;

                            if($monthly_remaining_leaves_left > 0){
                                if($probation_data->leaves_left >= $monthly_remaining_leaves_left){
                                    if($original_applied_leave_days >= $monthly_remaining_leaves_left){
                                        $return_data['paid_count'] = $monthly_remaining_leaves_left;
                                        $return_data['unpaid_count'] = $original_applied_leave_days -$monthly_remaining_leaves_left;

                                    }else{
                                        $return_data['paid_count'] = $original_applied_leave_days;
                                        $return_data['unpaid_count'] = 0;

                                    }
                                }else{
                                    if($probation_data->leaves_left >=  $original_applied_leave_days){
                                        $return_data['paid_count'] = $original_applied_leave_days;
                                        $return_data['unpaid_count'] = 0;
                                    }else{
                                        $return_data['paid_count'] = $probation_data->leaves_left;
                                        $return_data['unpaid_count'] = $original_applied_leave_days - $probation_data->leaves_left;
                                    }
                                }
                            }else{
                                $return_data['paid_count'] = 0;
                                $return_data['unpaid_count'] = $original_applied_leave_days;
                            }
                        }
                    }else{  //if($monthly_leaves_remaining < 1)
                        $original_applied_leave_days = $seg_data->number_of_days;

                        $return_data['compensatory_count'] = 0;
                        $monthly_remaining_leaves_left = $monthly_leaves_remaining;

                        if($monthly_remaining_leaves_left > 0){
                            if($probation_data->leaves_left >= $monthly_remaining_leaves_left){
                                if($original_applied_leave_days >= $monthly_remaining_leaves_left){
                                    $return_data['paid_count'] = $monthly_remaining_leaves_left;
                                    $return_data['unpaid_count'] = $original_applied_leave_days -$monthly_remaining_leaves_left;

                                }else{
                                    $return_data['paid_count'] = $original_applied_leave_days;
                                    $return_data['unpaid_count'] = 0;

                                }
                            }else{
                                $return_data['paid_count'] = $probation_data->leaves_left;
                                $return_data['unpaid_count'] = $original_applied_leave_days - $probation_data->leaves_left;
                            }
                        }else{
                            $return_data['paid_count'] = 0;
                            $return_data['unpaid_count'] = $original_applied_leave_days;
                        }
                    }
                } //end of Full day leaves less than 3 else
            } //end of Full day leaves else
        }//end of leave type id not equal to 3 or 4

        $seg_data->update($return_data);

        if(!empty($compensatory_leaves_array)){
            $compensatory_leaves_array_data['applied_leave_id'] = $seg_data->applied_leave_id;

            foreach ($compensatory_leaves_array as $key => $value) {
                CompensatoryLeave::where(['id'=>$value])->update($compensatory_leaves_array_data);
            }
        }
    }//end foreach 1
    return true;
}//end of function

function probationCalculations($user)
{
    $probation_data = DB::table('employee_profiles as emp')
            ->join('employees as e','e.user_id','=','emp.user_id')
            ->leftJoin("probation_periods as pp",'emp.probation_period_id','=','pp.id')
            ->where(['emp.user_id'=>$user->id])
            ->select('e.joining_date','pp.no_of_days')
            ->first();

    $current_year = date("Y");
    $current_month = date("n");

    $sum_data = DB::table('applied_leaves as al')
            ->join('applied_leave_segregations as als','als.applied_leave_id','=','al.id')
            ->where(['al.isactive'=>1,'al.final_status'=>'1','al.user_id'=>$user->id])
            ->whereYear('als.from_date',$current_year)
            ->select(DB::raw("SUM(als.paid_count) as paid_count,SUM(als.unpaid_count) as unpaid_count"))
            ->first();

    $compensatory_leaves = CompensatoryLeave::where(['hr_verification'=>'1','hod_verification'=>'1','isactive'=>1,'user_id'=>$user->id,'applied_leave_id'=>0])
                            ->orderBy('from_date','ASC')
                            ->get();

    if($current_month == '1'){
        $total_leaves = 15;

    }elseif($current_month == '12'){
        $total_leaves = 1.25;

    }else{
        $remaining_months = 12 - $current_month;
        $total_leaves = 1.25 * $remaining_months;

    }

    if(!empty($probation_data)){
        if($sum_data->paid_count == ""){
            $probation_data->paid_count = 0;
        }else{
            $probation_data->paid_count = $sum_data->paid_count;
        }
        if($sum_data->unpaid_count == ""){
            $probation_data->unpaid_count = 0;
        }else{
            $probation_data->unpaid_count = $sum_data->unpaid_count;
        }

        if($probation_data->no_of_days !== '' || $probation_data->no_of_days !== null){
            $end_date = Carbon::parse($probation_data->joining_date)->addDays($probation_data->no_of_days)->toDateString();
            $probation_data->probation_end_date = $end_date;

            $probation_end_year = date("Y",strtotime($end_date));
            $probation_end_month = date("n",strtotime($end_date));

            if(strtotime(date("Y-m-d")) > strtotime($end_date)){
                $probation_data->probation_end_or_not = '1';
                $remaining_months = 12 - ($probation_end_month - 1);
                $total_leaves = 1.25 * $remaining_months;
                $probation_data->total_leaves = $total_leaves;

                if($current_year > $probation_end_year){
                    $probation_data->total_leaves = 15;
                }
            }else{
                $probation_data->probation_end_or_not = '0';
                $probation_data->total_leaves = 0;

            }
        }else{
            $probation_data->probation_end_date = 'NA';
            $probation_data->probation_end_or_not = 'NA';  //Not Applicable
            $probation_data->total_leaves = 0;
        }

        $leaves_left = $probation_data->total_leaves - $probation_data->paid_count;

        if($leaves_left <= 0){
            $leaves_left = 0;
        }

        $probation_data->leaves_left = $leaves_left;
        $probation_data->compensatory_leaves_count = $compensatory_leaves->count();
        $probation_data->compensatory_leaves = $compensatory_leaves;
    }//end probation if
    return $probation_data;
}//end of function

if(!function_exists('getEmployeeProfile'))
{
	function getEmployeeProfileData($user_id)
	{
		$data = DB::table('employees')
                ->where('user_id',$user_id)
                ->first();

        return $data;
	}
}

if(!function_exists('getMyLimitedMessages'))
{
	function getMyLimitedMessages($staticPic,$profilePicPath,$employeeId,$limit = false)
	{
		$messages = DB::table('messages as m')
                    ->join("employees as emp",'m.sender_id','=','emp.user_id')
                    ->where(['m.receiver_id'=>$employeeId,'m.isactive'=>1])
                    ->select('m.id','m.read_status',"emp.fullname",'m.label','m.message','m.created_at',DB::raw('CASE WHEN emp.profile_picture = "" OR emp.profile_picture IS NULL THEN "'.$staticPic.'" ELSE CONCAT("'.$profilePicPath.'",emp.profile_picture) END AS profile_pic'));

        if(empty($limit)) {
        	$data = $messages->orderBy('m.created_at','desc')->get();
        }else{
        	$data = $messages->orderBy('m.created_at','desc')->limit($limit)->get();
        }
        return $data;
	}
}

if(!function_exists('getMyLimitedNotifications'))
{
	function getMyLimitedNotifications($staticPic,$profilePicPath,$employeeId,$limit = false)
	{
		$notifications = DB::table('notifications as m')
                    ->join("employees as emp",'m.sender_id','=','emp.user_id')
                    ->where(['m.receiver_id'=>$employeeId,'m.isactive'=>1])
                    ->select('m.id','m.read_status',"emp.fullname",'m.label','m.message','m.created_at',DB::raw('CASE WHEN emp.profile_picture = "" OR emp.profile_picture IS NULL THEN "'.$staticPic.'" ELSE CONCAT("'.$profilePicPath.'",emp.profile_picture) END AS profile_pic'));

        if(empty($limit)) {
        	$data = $notifications->orderBy('m.created_at','desc')->get();
        }else {
        	$data = $notifications->orderBy('m.created_at','desc')->limit($limit)->get();
        }
        return $data;
	}
}

function claculateNightsTwoDates($d1, $d2)
{
    $date1 = new DateTime($d1);
    $date2 = new DateTime($d2);
    $numberOfNights= $date2->diff($date1)->format("%a");
    return $numberOfNights+1;
}

function moneyFormat($val,$symbol='Rs. ',$r=2)
{
    return $symbol . number_format($val,$r);
}

function formatDate($date)
{
    return date("d-m-Y", strtotime($date));
}

function numberToWords($number = null) 
{
    $value = new \NumberFormatter("en", NumberFormatter::SPELLOUT);
    return  $value->format($number);
}

function amountInWords(float $number)
{
    $decimal = round($number - ($no = floor($number)), 2) * 100;
    $hundred = null;
    $digits_length = strlen($no);
    $i = 0;
    $str = array();
    $words = array(0 => '', 1 => 'one', 2 => 'two',
    3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',
    7 => 'seven', 8 => 'eight', 9 => 'nine',
    10 => 'ten', 11 => 'eleven', 12 => 'twelve',
    13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen',
    16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
    19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',
    40 => 'forty', 50 => 'fifty', 60 => 'sixty',
    70 => 'seventy', 80 => 'eighty', 90 => 'ninety');
    $digits = array('', 'hundred','thousand','lakh', 'crore');

    while( $i < $digits_length ) {
        $divider = ($i == 2) ? 10 : 100;
        $number = floor($no % $divider);
        $no = floor($no / $divider);
        $i += $divider == 10 ? 1 : 2;

        if ($number) {
            $plural = (($counter = count($str)) && $number > 9) ? 's' : null;

            $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;

            $str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;

        } else $str[] = null;

    }

    $Rupees = implode('', array_reverse($str));
    $paise = ($decimal) ? "." . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paise' : '';
    return ($Rupees ? $Rupees . 'Rupees ' : '') . $paise;
}

function getAttendanceInfo($date,$user_id)
{
     $user = User::where(['id'=>$user_id])->with('employee')
                                        ->with('employeeProfile')
                                        ->first();
        
                                        
    $dayofweek = date('w', strtotime($date)); 

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

    $date = date("Y-m-d",strtotime($date));
    $attendance = Attendance::where(['on_date'=>$date,'user_id'=>$user_id])
                    ->first();

    $data['late'] = 0;
    $data['status'] = "";
    $data['first_punch'] = "";
    $data['last_punch'] = "";
    $data['first_punch_type'] = 'NA';
    $data['last_punch_type'] = 'NA';
    $data['secondary_leave_type'] = "";
    $data['description'] = ""; 
    $data['remarks'] = AttendanceRemark::where(['on_date'=>$date,'user_id'=>$user_id])
                                        ->value('remarks');           

    if(!empty($attendance)){
        $data['status'] = $attendance->status;

        if($attendance->status == 'Holiday'){
            $holiday = Holiday::where('holiday_from','<=',$date)
                           ->where('holiday_to','>=',$date)
                           ->where('isactive',1)
                           ->first();

            $data['description'] = $holiday->name;   

        }elseif($attendance->status == 'Leave'){
            $leave = DB::table('applied_leaves as al') 
                   ->where('al.from_date','<=',$date)
                   ->where('al.to_date','>=',$date)
                   ->where(['al.final_status'=>'1','al.user_id'=>$user_id])
                   ->select('al.*',DB::raw("SUM(al.number_of_days) as total_days"))
                   ->first();

            if(!empty($leave->total_days)){
                $data['secondary_leave_type'] = ($leave->secondary_leave_type == 'Full') ? 1 : $leave->total_days;
                
                $data['description'] = $leave->reason;
            }else{
                $attendance_punch = $attendance->attendancePunches()->first();
                if(!empty($attendance_punch)){
                    $attendance->status = 'Present';
                    $attendance->save();
                    $data['status'] = 'Present';
                }
            }       

        }elseif($attendance->status == 'Travel') {
            $travel = TravelApproval::where(['isactive'=>1,'status'=>'approved','user_id'=>$user_id])
                                    ->where('date_from','<=',$date)
                                    ->where('date_to','>=',$date)
                                    ->first();

            $data['description'] = $travel->purpose;                        
        }

        if($data['status'] != 'Absent'){
            if(!$attendance->attendancePunches->isEmpty()){
                $first_punch = $attendance->attendancePunches()
                                        ->orderBy('on_time','asc')->first();

                $last_punch = $attendance->attendancePunches()
                                        ->orderBy('on_time','desc')
                                        ->first();

                $data['first_punch'] = $first_punch->on_time;
                $data['last_punch'] = $last_punch->on_time;
                $data['first_punch_type'] = $first_punch->type;
                $data['last_punch_type'] = $last_punch->type;

                $holiday = Holiday::where('holiday_from','<=',$date)
                           ->where('holiday_to','>=',$date)
                           ->where('isactive',1)
                           ->first();

                if(strtotime(date("Y-m-d H:i",strtotime($data['first_punch']))) > strtotime(date('Y-m-d H:i',strtotime($shift_from_time)))){
                    if($attendance->status == 'Leave' && $leave->secondary_leave_type == 'Half' && $leave->leave_half == 'First'){
                        $data['late'] = 0;
                    }elseif($attendance->status == 'Leave' && $leave->secondary_leave_type == 'Short' && $leave->from_time == date('g:i A',strtotime($shift_from_time))){
                        $data['late'] = 0;
                        
                    }elseif($attendance->status == 'Leave' && $leave->secondary_leave_type == 'Full'){
                        $data['late'] = 0;
                    }elseif(date("l",strtotime($attendance->on_date)) == 'Sunday' || !empty($holiday)){
                        $data['late'] = 0;
                    }else{
                        $data['late'] = 1;
                    }
                    
                }                                   

                $data['first_punch'] = date("h:i A",strtotime($data['first_punch']));                                    
                $data['last_punch'] = date("h:i A",strtotime($data['last_punch']));                                    

                if($data['last_punch'] == $data['first_punch']){
                    $data['last_punch'] = "";
                }
            }                                    
        }          
                 
    }else{

        $holiday = Holiday::where('holiday_from','<=',$date)
                           ->where('holiday_to','>=',$date)
                           ->where('isactive',1)
                           ->first();

        if(!empty($holiday)){
            $data['status'] = 'Holiday';
            $data['description'] = $holiday->name;
        }else{

            $leave = DB::table('applied_leaves as al')
                   ->where('al.from_date','<=',$date)
                   ->where('al.to_date','>=',$date)
                   ->where(['al.final_status'=>'1','al.user_id'=>$user_id])
                   ->select('al.*',DB::raw("SUM(al.number_of_days) as total_days"))
                   ->first();

            if(!empty($leave->total_days)){
                $data['status'] = 'Leave';
                $data['description'] = $leave->reason;

                $data['secondary_leave_type'] = ($leave->secondary_leave_type == 'Full') ? 1 : $leave->total_days;
            }else{
                $travel = TravelApproval::where(['isactive'=>1,'status'=>'approved','user_id'=>$user_id])
                                    ->where('date_from','<=',$date)
                                    ->where('date_to','>=',$date)
                                    ->first();

                if(!empty($travel)){
                    $data['status'] = 'Travel';
                    $data['description'] = $travel->purpose;
                }
            }       
        }           

    }        

    if(strtotime($user->employee->joining_date) > strtotime($date)){
        $data['status'] = "N/A";
    }


    return $data;   
           
}//end of function

function getBandCityClassDetails($band_id, $city_class_id){

    $data = DB::table('band_city_class')
            ->where('band_id', $band_id)
            ->where('city_class_id', $city_class_id)
            ->where('isactive',1)
            ->first();

    return $data;
}//end of function

function effectiveHolidays($joining_date,$holiday_array){
    $count = 0;
    if(count($holiday_array)){
        foreach ($holiday_array as $key => $value) {
            if(strtotime($joining_date) <= strtotime($value)){
                $count += 1;
            }
        }
    }
    return $count;
}//end of function

function effectiveSundays($joining_date,$sunday_array){
    $count = 0;
    if(count($sunday_array)){
        foreach ($sunday_array as $key => $value) {
            if(strtotime($joining_date) <= strtotime($value)){
                $count += 1;
            }
        }
    }
    return $count;
}//end of function

function numberFormat($val = 0, $decimals = 2, $decimalPoint = '.', $separator = '') 
{
    return number_format($val, $decimals, $decimalPoint, $separator);
}

function bytesToSize($bytes = 0, $precision = 2) {
    $units = array('Bytes', 'KB', 'MB', 'GB', 'TB');
    $bytes = max($bytes, 0);
    $pow   = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow   = min($pow, count($units) - 1);
    return round($bytes, $precision) . ' ' . $units[$pow];
}

/**
 * @param $oldSerialNo
 * @return mixed
 */
function generateSerialNumber($exstingCount) 
{
    $year   = date('y');
    $month  = date('m');
    $number = str_pad($exstingCount, 5, '0', STR_PAD_LEFT);
    return $year . $month . $number;
}
function timeleft($to){       

    // $fdate = \Carbon\Carbon::createFromFormat('Y-m-d', $from);
     $current = Carbon::now();
   // exit;
     //$fdate = Carbon::parse($from);
    $tdate = Carbon::parse($to);
    // $tdate = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $to);
   // return $diff_in_hours_mins = $current->diff($tdate, false)->format('%H hours  %I Mins');
    return $diff_in_hours_mins = $tdate->diffForHumans($current);
}

function getBandCity($bandId = null, $clityClassId = null) 
{
    return Band::where('id', $bandId)
            ->with(['city_class' => function($query) use ($clityClassId) {
                $query->where('city_class_id', $clityClassId);
            }])->first();
}

?>