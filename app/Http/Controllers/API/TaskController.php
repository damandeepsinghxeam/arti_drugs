<?php

namespace App\Http\Controllers\API;

use App\TaskDateExtension;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use View;
use DB;
use Mail;
use Auth;
use Validator;
use Carbon\Carbon;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\User;
use App\Employee;
use App\Department;
use App\Project;
use App\Task;
use App\TaskProject;
use App\TaskUser;
use App\TaskPoint;
use App\EmailContent;
use App\Mail\GeneralMail;
use Illuminate\Database\Eloquent\Builder;

class TaskController extends Controller
{
    /*
        Get the listing of tasks assigned to a user with filtering
    */
    function myTasks(Request $request)
    {
        checkDeviceId($request->user());
        $validator = Validator::make($request->all(), [
            'task_type' => 'required',
            'task_status' => 'required',
            'my_status' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['validation_error' => $validator->errors()], 400);
        }

        $user = $request->user();
        $query = Task::whereHas('taskUser', function(Builder $query)use($user){
            $query->where('user_id',$user->id);
        });

        $task_status = 'All';

        if($request->has('task_status') && strtolower($request->task_status) != 'all'){
            $task_status = $request->task_status;
            $query = $query->where('status',$request->task_status);
        }

        if($request->has('task_type')){
            if($request->task_type == 'today'){
                $query = $query->where('due_date','=',date("Y-m-d"));

            }elseif($request->task_type == 'delayed'){
                $query = $query->where('due_date','<',date("Y-m-d"))
                    ->whereHas('taskUser', function(Builder $query){
                        $query->where('is_delayed',1)
                            ->orWhere('status','!=','Done');
                    });

            }elseif($request->task_type == 'upcoming'){
                $query = $query->where('due_date','>=',date("Y-m-d"));

            }elseif($request->task_type == 'this-week'){
                $current_week = date("W");
                $query = $query->where(\DB::raw("WEEKOFYEAR(due_date)"),$current_week);

            }elseif($request->task_type == 'this-month'){
                $current_month = date("n");
                $current_year = date("Y");
                $query = $query->whereMonth('due_date',$current_month)
                    ->whereYear('due_date',$current_year);

            }

            $task_type = $request->task_type;
        }else{
            $task_type = "upcoming";
            $query = $query->where('due_date','>=',date("Y-m-d")); //Upcoming
        }

        if($request->has('my_status')){
            $my_status = $request->my_status;
        }else{
            $my_status = 'Not-Started';
        }

        if(strtolower($my_status) != 'all'){

            $query = $query->whereHas('taskUser', function(Builder $query)use($my_status){
                $query->where(['status'=>$my_status]);
            });
        }

        $current_date = date("Y-m-d");
        $tasks = $query->with('taskProject:id,name')
            ->with('taskUser')
            ->with('user.employee:id,user_id,fullname')
            ->withCount(['taskUpdates'=>function(Builder $query)use($current_date){
                $query->where('on_date',$current_date);
            }])
            ->orderBy('created_at','DESC')
            ->get();

        $success['tasks'] = $tasks;

        if($tasks->isEmpty()){
            $status = 204;
        }else{
            $status = 200;
        }

        return response()->json(['success' => $success], $status);
    }

    /*
        Get the listing of tasks created by a user with filtering
    */
    function viewTasks(Request $request)
    {
        checkDeviceId($request->user());
        $validator = Validator::make($request->all(),[
            'task_type' => 'required',
            'task_status' => 'required',
            'user_status' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['validation_error' => $validator->errors()], 400);
        }

        $user = $request->user();
        if(!userHasPermissions($user,['create-task'])){
            return response()->json(['error' => 'You do not have permission to access this module!'], 403);
        }

        $query = Task::where(['user_id'=>$user->id]);

        $user_status = 'all';
        if($request->has('user_status') && $request->user_status != 'all'){
            $user_status = $request->user_status;
            $query =    $query->whereHas('taskUser', function(Builder $query)use($user_status){
                $query->where('status',$user_status);
            });
        }

        if($request->has('task_type')){
            if($request->task_type == 'today'){
                $query = $query->where('due_date','=',date("Y-m-d"));

            }elseif($request->task_type == 'delayed'){
                $query = $query->where('due_date','<',date("Y-m-d"))
                    ->whereHas('taskUser', function(Builder $query){
                        $query->where('is_delayed',1)
                            ->orWhere('status','!=','Done');
                    });

            }elseif($request->task_type == 'upcoming'){
                $query = $query->where('due_date','>=',date("Y-m-d"));

            }elseif($request->task_type == 'this-week'){
                $current_week = date("W");
                $query = $query->where(\DB::raw("WEEKOFYEAR(due_date)"),$current_week);

            }elseif($request->task_type == 'this-month'){
                $current_month = date("n");
                $current_year = date("Y");
                $query = $query->whereMonth('due_date',$current_month)
                    ->whereYear('due_date',$current_year);

            }
            $task_type = $request->task_type;
        }else{
            $task_type = "upcoming";
            $query = $query->where('due_date','>=',date("Y-m-d")); //Upcoming
        }

        if($request->has('task_status')){
            $task_status = $request->task_status;
        }else{
            $task_status = 'Open';
        }

        if($task_status != 'all'){
            $query = $query->where('status',$task_status);
        }

        $current_date = date("Y-m-d");
        $tasks = $query->with('taskProject:id,name')
            ->with('taskUser.user.employee:id,user_id,fullname')
            ->withCount(['taskUpdates'=>function(Builder $query)use($current_date){
                $query->where('on_date',$current_date);
            }])
            ->orderBy('created_at','DESC')
            ->get();

        if(empty($tasks)){
            $status = 204;
        }else{
            $status = 200;
        }
        $success['tasks'] = $tasks;
        return response()->json(['success' => $success], $status);
    }
    /*
       Get additional task details of a task to show in a modal
   */
    function additionalTaskInfo(Request $request)
    {
        checkDeviceId($request->user());
        $validator = Validator::make($request->all(),[
            'task_id' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['validation_error' => $validator->errors()], 400);
        }

        $task = Task::select('id','points','points_obtained','title','task_project_id')
            ->with('taskProject:id,name')
            ->with('taskUser:id,task_id,status,is_delayed,updated_at')
            ->find($request->task_id);

        $task->latest_history = $task->messages()
            ->where('label','like','%Task marked%')
            ->orderBy('id','DESC')
            ->select('id','message','sender_id','created_at')
            ->with('sender.employee:id,user_id,fullname')
            ->first();

        $task->latest_chat = $task->messages()
            ->where('label','like','%Task Chats%')
            ->orderBy('id','DESC')
            ->select('id','message','sender_id','created_at')
            ->with('sender.employee:id,user_id,fullname')
            ->first();

        $task->latest_update = $task->taskUpdates()
            ->orderBy('id','DESC')
            ->select('id','task_id','comment','created_at')
            ->first();

        $success['task'] = $task;
        return response()->json(['success' => $success], 200);
    }

    /*
        Get the details of a specific task
    */
    function taskDetail(Request $request)
    {
        checkDeviceId($request->user());
        $validator = Validator::make($request->all(),[
            'task_id' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['validation_error' => $validator->errors()], 400);
        }

        $task = Task::with('taskProject:id,name')
            ->with('taskFiles')
            ->with(['taskUpdates' => function($query){
                $query->select('id','task_id','comment','created_at')
                    ->orderBy('id','DESC');
            }])
            ->with('taskUser')
            ->with('taskUser.user:id,employee_code')
            ->with('taskUser.user.employee:id,user_id,fullname')
            ->find($request->task_id);

        $task->taskHistory = $task->messages()
            ->where('label','like','%Task marked%')
            ->orderBy('id','DESC')
            ->select('id','label','message','sender_id','created_at')
            ->with('sender.employee:id,user_id,fullname,profile_picture')
            ->get();

        $task->taskChats = $task->messages()
            ->where('label','like','%Task Chats%')
            ->with('messageAttachments')
            ->select('id','label','message','sender_id','created_at')
            ->with('sender.employee:id,user_id,fullname,profile_picture')
            ->get();

        $success['task'] = $task;
        $success['urls'] = [
            'static_pic' => config('constants.static.profilePic'),
            'uploaded_pic' => config('constants.uploadPaths.profilePic'),
            'task_file' => config('constants.uploadPaths.taskDocument'),
            'chat_file' => config('constants.uploadPaths.messageAttachment'),
        ];
        return response()->json(['success' => $success], 200);
    }

    /*
        Select multiple tasks & change the status of assigned tasks
    */
    function changeMyTaskStatus(Request $request)
    {
        checkDeviceId($request->user());
        $validator = Validator::make($request->all(),[
            'task_ids' => 'required',
            'selected_status' => 'required',
            'comment' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['validation_error' => $validator->errors()], 400);
        }

        $task_ids = explode(",",$request->task_ids);
        foreach ($task_ids as $task_id) {
            $task = Task::where(['id'=>$task_id])->with('taskUser')->first();
            $task_user = $task->taskUser;

            if(($request->selected_status == 'Done' && $task_user->status != 'Inprogress') || $task_user->status == $request->selected_status || $task_user->status == 'Done' || $task_user->status == 'Unassigned'){
                continue;
            }

            $task_user->status = $request->selected_status;

            if(strtotime(date("Y-m-d")) > strtotime($task->due_date)){
                $task_user->is_delayed = 1;
            }

            $task_user->save();

            $message = $request->comment;
            $message_data = [
                'sender_id' => $task_user->user_id,
                'receiver_id' => $task->user_id,
                'label' => 'Task marked as '.$request->selected_status,
                'read_status' => '0',
                'message' => $message
            ];
            $task->messages()->create($message_data);

            $message_body = "You created a task titled: '".$task->title."'. It has been marked as ".$request->selected_status." by '".$task_user->user->employee->fullname."'.'";

            pushNotification($message_data['receiver_id'], $message_data['label'], $message_body);

            if($request->selected_status == 'Inprogress'){
                $message_data2 = [
                    'sender_id' => $task->user_id,
                    'receiver_id' => $task_user->user_id,
                    'label' => 'Task marked as '.$request->selected_status,
                    'read_status' => '0',
                    'message' => 'The task status has been changed by system.'
                ];
                $task->status = "Inprogress";
                $task->save();
                $task->messages()->create($message_data2);
            }

            if($request->selected_status == 'Done'){
                $email_message = $message_body." Please check and mark it as completed, reopened or unassigned.";
                $mail_data = [
                    'to_email' => $task->user->email,
                    'subject' => $message_data['label'],
                    'fullname' => $task->user->employee->fullname,
                    'message' => $email_message
                ];
                $this->sendGeneralMail($mail_data);
                sms($task->user->employee->mobile_number, $email_message);
            }
        }

        $success['message'] = 'Tasks status updated successfully.';
        return response()->json(['success' => $success], 200);
    }

    /*
        Select multiple tasks & change the status of created tasks
    */
    function changeTaskStatus(Request $request)
    {
        checkDeviceId($request->user());
        $validator = Validator::make($request->all(),[
            'task_ids' => 'required',
            'selected_status' => 'required',
            'comment' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['validation_error' => $validator->errors()], 200);
        }

        $task_ids = explode(',',$request->task_ids);
        foreach ($task_ids as $task_id) {
            $task = Task::find($task_id);

            if(($request->selected_status == 'Completed' && $task->taskUser->status != 'Done') || $task->status == $request->selected_status || $task->status == 'Completed' || $task->status == 'Unassigned' || ($request->selected_status == 'Unassigned' && $task->taskUser->status == 'Done')){
                continue;
            }

            $task->status = $request->selected_status;
            $task->save();

            $message = $request->comment;
            $message_data = [
                'sender_id' => $task->user_id,
                'receiver_id' => $task->taskUser->user_id,
                'label' => 'Task marked as '.$request->selected_status,
                'read_status' => '0',
                'message' => $message
            ];

            $task->messages()->create($message_data);

            $task_user = $task->taskUser;

            if($request->selected_status == 'Completed' && $task_user->status == 'Done'){
                $task_point = TaskPoint::find($task->task_point_id);
                if($task_user->is_delayed == 0){
                    $task->points_obtained = $task->points;
                }else{
                    //Danger Zones
                    $datediff = strtotime($task_user->updated_at) - strtotime($task->due_date);
                    $datediff = round($datediff / (60*60*24)); //days

                    if ($datediff <= $task_point->danger_zone1_days) {
                        $task->points_obtained = ($task_point->danger_zone1_points*$task->points)/100.0;

                    }elseif ($datediff <= $task_point->danger_zone2_days) {
                        $task->points_obtained = ($task_point->danger_zone2_points*$task->points)/100.0;

                    }elseif ($datediff > $task_point->danger_zone2_days) {
                        $task->points_obtained = ($task_point->danger_zone3_points*$task->points)/100.0;
                    }
                }
                $task->save();
            }

            $message_data = [
                'sender_id' => $task_user->user_id,
                'receiver_id' => $task->user_id,
                'label' => 'Task marked as '.$request->selected_status,
                'read_status' => '0',
                'message' => 'The task status has been changed by system.'
            ];
            $flag = 0;
            if($request->selected_status == "Unassigned"){
                $task_user->status = "Unassigned";
                $flag = 1;
                $task->points = 0;
            }elseif($request->selected_status == "Reopened"){
                $task_user->status = "Inprogress";
                $flag = 1;
            }

            if($flag){
                $task->points_obtained = 0;
                $task->save();
                $task_user->save();
                if($request->selected_status == "Reopened"){
                    $message_data['label'] = 'Task marked as Inprogress';
                }
                $task->messages()->create($message_data);
            }

            $email_message = "Task assigned to you titled: '".$task->title."', has been marked as '".$request->selected_status."' by '".$task->user->employee->fullname."'. Please check it.";
            $mail_data = [
                'to_email' => $task_user->user->email,
                'subject' => 'Task marked as '.$request->selected_status,
                'fullname' => $task_user->user->employee->fullname,
                'message' => $email_message
            ];
            $this->sendGeneralMail($mail_data);
            sms($task_user->user->employee->mobile_number, $email_message);

            pushNotification($task_user->user_id, $mail_data['subject'], $email_message);
        }

        $success['message'] = 'Tasks status updated successfully.';

        return response()->json(['success' => $success], 200);
    }

    /*
        Save the updated values in database, when updating task from task details page
    */
    function updateTask(Request $request)
    {
        checkDeviceId($request->user());
        $validator = Validator::make($request->all(),[
            'title'  => 'required',
            'priority'  => 'required',
            'due_date'  => 'required',
            'description'  => 'required',
            'task_id' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['validation_error' =>$validator->errors()], 400);
        }

        $task = Task::where('id',$request->task_id)
            ->with('taskUser')
            ->first();

        if($task->taskUser->status != 'Not-Started'){
            return response()->json(['error'=>'User has started the task, you cannot edit it now.'], 405);
        }

        if($task->title != $request->title){
            $message_data = [
                'sender_id' => $task->user_id,
                'receiver_id' => $task->taskUser->user_id,
                'label' => 'Task marked as Updated',
                'read_status' => '0',
                'message' => 'The task title has been changed from: '.$task->title.' to: '.$request->title.'.'
            ];
            $task->messages()->create($message_data);
            $task->title = $request->title;
            $task->save();
        }

        if($task->description != $request->description){
            $message_data = [
                'sender_id' => $task->user_id,
                'receiver_id' => $task->taskUser->user_id,
                'label' => 'Task marked as Updated',
                'read_status' => '0',
                'message' => 'The task description has been changed from: '.strip_tags($task->description).' to: '.strip_tags($request->description).'.'
            ];
            $task->messages()->create($message_data);
            $task->description = $request->description;
            $task->save();
        }

        if($task->priority != $request->priority){
            $task_point = TaskPoint::where('priority', $request->priority)->orderBy('id', 'DESC')->first();
            $message_data = [
                'sender_id' => $task->user_id,
                'receiver_id' => $task->taskUser->user_id,
                'label' => 'Task marked as Updated',
                'read_status' => '0',
                'message' => 'The task priority has been changed from: '.$task->priority." to: ".$request->priority."."
            ];
            $task->messages()->create($message_data);
            $task->priority = $request->priority;
            $task->points = $task_point->weight;
            $task->task_point_id = $task_point->id;
            $task->save();
        }

        if($task->due_date != date("Y-m-d",strtotime($request->due_date))){
            $message_data = [
                'sender_id' => $task->user_id,
                'receiver_id' => $task->taskUser->user_id,
                'label' => 'Task marked as Updated',
                'read_status' => '0',
                'message' => 'The task due date has been changed from: '.date("d/m/Y",strtotime($task->due_date))." to: ".date("d/m/Y",strtotime($request->due_date))."."
            ];
            $task->messages()->create($message_data);
            $task->due_date = date("Y-m-d",strtotime($request->due_date));
            $task->save();
        }

        if(!empty($message_data)){
            $email_message = "Task assigned to you titled: '".$task->title."', has been updated. ".$message_data['message']." Please check the task history.";
            $mail_data = [
                'to_email' => $task->taskUser->user->email,
                'subject' => $message_data['label'],
                'fullname' => $task->taskUser->user->employee->fullname,
                'message' => $email_message
            ];
            $this->sendGeneralMail($mail_data);

            pushNotification($task->taskUser->user_id, $mail_data['subject'], $email_message);
        }

        $success['task'] = $task;
        return response()->json(['success' => $success], 200);
    }

    /*
        Check whether the max task limit set in the database is exceeded when creating new tasks
    */
    function checkTasksLimit(Request $request)
    {
        checkDeviceId($request->user());
        $validator = Validator::make($request->all(),[
            'user_ids' => 'required',
            'priority' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['validation_error'=>$validator->errors()], 400);
        }

        $user_ids = $request->user_ids;
        $priority = $request->priority;

        $restrict_errors = [];

        foreach ($user_ids as $assigned_to) {
            $fullname = Employee::where(['user_id'=>$assigned_to])->value('fullname');
            $tasks = TaskUser::where(['user_id'=>$assigned_to])
                ->whereNotIn('status',['Done','Unassigned'])
                ->whereHas('task', function(Builder $query)use($priority){
                    $query->where('priority',$priority);
                })
                ->get();

            $task_point = TaskPoint::where('priority',$priority)
                ->orderBy('id', 'DESC')
                ->first();

            if(count($tasks) >= $task_point->max_limit){
                $restrict_errors[] = $fullname.' already has '.count($tasks).' '.$priority.' priority tasks.';
            }
        }

        if(!empty($restrict_errors)){
            $error = $restrict_errors;
            return response()->json(['error' => $error], 405);
        }else{
            $success['message'] = 'Please continue adding the task.';
            return response()->json(['success' => $success], 200);
        }
    }

    /*
        Show the create task form page with required data
    */
    function createTask(Request $request)
    {
        checkDeviceId($request->user());
        $auth_user = $request->user();
        if(!userHasPermissions($auth_user,['create-task'])){
            return response()->json(['error' => 'You do not have permission to access this module!'], 403);
        }

        $success['task_projects'] = TaskProject::where(['isactive'=>1])
            ->select('id','name','description')
            ->get();

        $success['departments'] = Department::where(['isactive'=>1])
            ->select('id','name')
            ->get();

        return response()->json(['success' => $success], 200);
    }

    /*
        Save the task project to the database
    */
    function saveTaskProject(Request $request)
    {
        checkDeviceId($request->user());
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'description' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['validation_error' => $validator->errors()], 400);
        }

        $auth_user = $request->user();
        if(!userHasPermissions($auth_user,['create-task'])){
            return response()->json(['error' => 'You do not have permission to access this module!'], 403);
        }

        $data = [
            'name' => $request->name,
            'description' => $request->description,
        ];

        $success['task_project'] = $auth_user->taskProjects()->create($data);
        return response()->json(['success' => $success], 200);
    }

    /*
        Save the task in database, send an email & sms notification to the assigned user
    */
    function saveTask(Request $request)
    {
        checkDeviceId($request->user());
        $validator = Validator::make($request->all(),[
            'task_project_id'  => 'required',
            'department_ids'  => 'required',
            'assigned_to'  => 'required',
            'title'  => 'required',
            'priority'  => 'required',
            'due_date'  => 'required',
            'description'  => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['validation_error' => $validator->errors()], 400);
        }

        $user = $request->user();
        if(!userHasPermissions($user,['create-task'])){
            return response()->json(['error' => 'You do not have permission to access this module!'], 403);
        }

        $task_point = TaskPoint::where('priority', $request->priority)->orderBy('id', 'DESC')->first();

        foreach ($request->assigned_to as $assigned_to) {
            $task_data = [
                'task_project_id'  => $request->task_project_id,
                'title'  => $request->title,
                'description'  => $request->description,
                'priority'  => $request->priority,
                'points' => $task_point->weight,
                'task_point_id' => $task_point->id,
                'due_date'  => date("Y-m-d",strtotime($request->due_date)),
            ];

            if($request->has('reminder') && $request->reminder == 'on'){
                $task_data['reminder_status'] = 1;
            }

            if($request->has('reminder_days')){
                $task_data['reminder_days'] = $request->reminder_days;
            }

            if($request->has('reminder_notification') && $request->reminder_notification == 'on'){
                $task_data['reminder_notification'] = 1;
            }

            if($request->has('reminder_mail') && $request->reminder_mail == 'on'){
                $task_data['reminder_email'] = 1;
            }

            $task = $user->tasks()->create($task_data);
            $task_user_data = [
                'user_id' => $assigned_to
            ];

            $task->taskUser()->create($task_user_data);
            if(!empty($request->task_files)){
                foreach ($request->task_files as $doc) {
                    $document = round(microtime(true)).str_random(5).'.'.$doc->getClientOriginalExtension();
                    $doc->move(config('constants.uploadPaths.uploadTaskDocument'), $document);
                    $task->taskFiles()->create(['filename'=>$document]);
                }
            }

            $message = $user->employee->fullname." has assigned you a new task titled: ".$task->title.".";
            $notification_data = [
                'sender_id' => $user->id,
                'receiver_id' => $assigned_to,
                'label' => 'Task Assigned',
                'read_status' => '0',
                'redirect_url' => 'tasks/info/'.$task->id,
                'message' => $message,
            ];
            $task->notifications()->create($notification_data);

            $task_user = User::find($assigned_to);
            $mail_data = [
                'to_email' => $task_user->email,
                'subject' => 'Task Assigned',
                'fullname' => $task_user->employee->fullname,
                'message' => $message."<br><strong>Description: </strong><br>".$task->description
            ];
            $this->sendGeneralMail($mail_data);
            sms($task_user->employee->mobile_number, $notification_data['message']);
            pushNotification($assigned_to, $notification_data['label'], $notification_data['message']);
        }//end for each

        $success['message'] = "Task added successfully";
        return response()->json(['success' => $success], 200);
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
     * Task Date Extension
     */
    function saveTaskDateExtension(Request $request){
        $validation =  Validator::make($request->all(),[
            'task_id'  => 'required',
            'assignee_id'  => 'required',
            'assigned_date'  => 'required|min:10',
            'required_date'  => 'required',
            'remarks'  => 'required|min:10'
        ]);


        if ($validation->fails()) {
            return response()->json(['validation_error' => $validation->errors()], 400);
        }

        $change_date_data = [
            'task_id' => $request->task_id,
            'assignee_id' => $request->assignee_id,
            'assignor_id' => $request->creator_id,
            'assigned_date' => $request->assigned_date,
            'required_date' => $request->required_date,
            'remarks' => $request->remarks,
            'isactive' => 1
        ];
        TaskDateExtension::create($change_date_data);
        $task = Task::where('id', $request->task_id)->first();

        $message =  Auth::user()->employee->fullname." has sent you a request for extend task date.";
        $notification_data = [
            'sender_id' => $request->assignee_id,
            'receiver_id' => $request->creator_id,
            'label' => 'Change task date Application',
            'read_status' => '0',
            'redirect_url' => 'tasks/info/requested-change-date',
            'message' => $message
        ];
        $notification_data['message'] = Auth::user()->employee->fullname." has requested for a date extension in Task '".$task->title."'.";

        $title = 'Task date extension request';
        $body = $notification_data['message'];
        pushNotification($request->creator_id, $title, $body);



        $task_user = User::find($request->creator_id);

        sms($task_user->employee->mobile_number, $notification_data['message'], 'ACT');

        return response()->json(['status' => 'success', 'message' => 'Task Extension Request Successfully Submitted'], 200);

    }


    /*
     * List all task date extension requests
     */
    function allTaskDateExtensionRequests($approval_status = "pending"){

        if($approval_status == "pending"){
            $status = '0';
        }elseif ($approval_status == "approved") {
            $status = '1';
        }elseif ($approval_status == "rejected") {
            $status = '2';
        }

        $user = Auth::user();
        $approvals = TaskDateExtension::where(['status'=>$status, 'assignor_id'=>$user->id, 'isactive' => 1])
            ->orderBy('created_at','DESC')
            ->get();

        foreach($approvals as $approval){
            $task_details = Task::find($approval->task_id);
            $approval->task_name = $task_details->title;
        }

        if(!$approvals->isEmpty()){
            foreach ($approvals as $key => $value) {

                $assignee_id = $value->assignee_id;

                $user_info = Employee::where(['user_id'=>$assignee_id])
                    ->first();

                if(!empty($user_info)){
                    $value->name = $user_info->fullname;
                }

            }
        }

        return response()->json(['status' => 'success', 'data' => $approvals], 200);
    }

    /*
     * List User task date extension request
     */
    function userTaskDateExtensionRequests($user, $approval_status = "pending"){
        if($approval_status == "pending"){
            $status = '0';
        }elseif ($approval_status == "approved") {
            $status = '1';
        }elseif ($approval_status == "rejected") {
            $status = '2';
        }

        $user = Auth::user();
        $approvals = TaskDateExtension::where(['status' => $status, 'assignee_id' => $user->id, 'isactive' => 1])
            ->orderBy('created_at','DESC')
            ->get();

        foreach($approvals as $approval){
            $task_details = Task::find($approval->task_id);
            $approval->task_name = $task_details->title;
        }

        if(!$approvals->isEmpty()){
            foreach ($approvals as $key => $value) {

                $assignee_id = $value->assignee_id;

                $user_info = Employee::where(['user_id'=>$assignee_id])
                    ->first();

                if(!empty($user_info)){
                    $value->name = $user_info->fullname;
                }

            }
        }

        return response()->json(['status' => 'success', 'data' => $approvals], 200);
    }



    /*
        * Change Task Date If approved And change status of task Approved/Rejected
    */

    function approveRejectTaskDateExtension(Request $request){

        if($request->status==1){
            $status = "1";
            $task_update = Task::where('id', $request->task_id)
                ->update(['due_date' => $request->allot_date]);


            $task_user_update = TaskUser::where('task_id', $request->task_id)
                ->update(['is_delayed' => 0]);

        }elseif($request->status==2){
            $status = "2";
        }


        TaskDateExtension::where('id', $request->id)
            ->update(['status' => $status, 'comments'=>$request->comment]);

        $date_change = TaskDateExtension::find($request->id);

        $message_data = [
            'sender_id' => $date_change->assignor_id,
            'receiver_id' => $date_change->assignee_id,
            'label' => 'Change Task Date Comment',
            'message' => $request->comment,
            'read_status' => '0'
        ];

        $date_change->messages()->create($message_data);


        if($status =="1"){
            return response()->json(['status' => 'success', 'message' => 'Task date extension request has been Approved.'], 200);
        }else{
            return response()->json(['status' => 'success', 'message' => 'Task date extension request has been rejected'], 200);
        }
    }

    function createTaskReport(Request $request)
    {
        $validation =  Validator::make($request->all(),[
            'from_date'  => 'required',
            'to_date'  => 'required',
            'no_days'  => 'required',
            'weekends'  => 'required',
            'holidays'  => 'required'
        ]);


        if ($validation->fails()) {
            return response()->json(['validation_error' => $validation->errors()], 400);
        }

        $report_data =  [
            'from_date' => $request->from_date,
            'to_date' => $request->to_date,
            'no_days' => $request->no_days,
            'weekends' => $request->weekends,
            'holidays' => $request->holidays
        ];

        if($request->department == ''){
            $report_data['department_id'] = "";
            $report_data['department_sign'] = "!=";
        }else{
            $report_data['department_id'] = $request->department;
            $report_data['department_sign'] = "=";
        }

        if($request->project == ''){
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

        $data = DB::table('tasks as t')
            ->join('task_users as tu','t.id','=','tu.task_id')
            ->join('employee_profiles as emp','emp.user_id','=','tu.user_id')
            ->join('users as u','tu.user_id','=','u.id')
            ->join('employees as e','tu.user_id','=','e.user_id')
            ->join('project_user as pu','pu.user_id','=','tu.user_id')
            ->whereBetween('t.due_date',[$from_date, $to_date])
            ->where('pu.project_id',$report_data['project_sign'],$report_data['project_id'])
            ->where('emp.department_id',$report_data['department_sign'],$report_data['department_id'])
            ->select("tu.user_id","u.employee_code","e.fullname",DB::raw("SUM(t.points) as task_points,SUM(t.points_obtained) as points_obtained, COUNT(t.id) as task_count,CASE WHEN e.profile_picture = '' OR e.profile_picture IS NULL THEN '".$static_pic."' ELSE CONCAT('".$profile_pic_path."',e.profile_picture) END AS profile_picture, (SUM(t.points_obtained)*100/SUM(t.points)) as efficiency"))
            ->groupBy("tu.user_id")
            ->orderBy("e.fullname")
            ->get();

        return response()->json(['status' => 'Success', 'data'=>$data, 'report_data'=> $report_data]);
    }



}//end of class
