<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use View;
use Mail;
use Auth;
use DB;
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
use App\TaskDateExtension;

class TaskController extends Controller
{
    /*
        Show the task report form with necessary details
    */
    function reportForm()
    {
        $user = Auth::user();

        if($user->hasRole('MD') || $user->id == 1){
            $data['departments'] = Department::where(['isactive'=>1])->get();
            $data['projects'] = Project::where(['isactive'=>1,'approval_status'=>'1'])->get();
        }else{
            $data['departments'] = Department::where(['isactive'=>1])
                                            ->where('id', $user->employeeProfile->department_id)
                                            ->get();

            $data['projects'] = Project::where(['isactive'=>1,'approval_status'=>'1'])
                                            ->whereIn('id',[$user->projects->pluck('id')])
                                            ->get();
        }

        return view('tasks.report_form')->with(['data' => $data]);
    }

    /*
        Create task report with filters
    */
    function createTaskReport(Request $request)
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

        return view('tasks.list_task_report')->with(['data'=>$data, 'report_data'=> $report_data]);
    }

    /*
        Get the task report of an employee with filters
    */
    function additionalTaskReportInfo(Request $request)
    {
        $report_data =  [
            'from_date' => $request->from_date,
            'to_date' => $request->to_date,
            'user_id' => $request->id
        ];

        $from_date = date("Y-m-d",strtotime($report_data['from_date']));
        $to_date = date("Y-m-d",strtotime($report_data['to_date']));
        $employee_data = User::with('employee')->find($request->id);
        $tasks = Task::whereBetween('due_date', [$from_date, $to_date])
                    ->with('taskProject')
                    ->whereHas('taskUser', function(Builder $query)use($employee_data){
                        $query->where(['user_id'=>$employee_data->id]);
                    })
                    ->with('user.employee:id,user_id,fullname,profile_picture')
                    ->orderBy('created_at','DESC')
                    ->get();

        return view('tasks.additional_task_report_info')->with(['report_data'=>$report_data,'tasks'=>$tasks,'employee_data'=>$employee_data]);
    }//end of function

    /*
        Get the latest task points system data to show on a table
    */
    function taskPoints()
    {
        $data = TaskPoint::orderBy('id','DESC')
                        ->get()
                        ->unique('priority');

        return view('tasks.task_points')->with(['data'=>$data]);
    }//end of function

    /*
        Show the create task form page with required data
    */
    function create()
    {
        $data['task_projects'] = TaskProject::where(['isactive'=>1])->get();
        $data['departments'] = Department::where(['isactive'=>1])->get();
        return view('tasks.add_task_form')->with(['data'=>$data]);
    }//end of function

    /*
        Send basic email with a generic template
    */
    function sendGeneralMail($mail_data)
    {   //mail_data Keys => to_email, subject, fullname, message

        if(!empty($mail_data['to_email'])){
            Mail::to($mail_data['to_email'])->send(new GeneralMail($mail_data));
        }

        return true;

    }//end of function

    /*
        Check whether the max task limit set in the database is exceeded when creating new tasks
    */
    function checkTasksLimit(Request $request){
        $user_ids = $request->user_ids;
        $priority = $request->priority;

        $restrict_users = [];
        $restrict_message = "<ul>";
        foreach ($user_ids as $assigned_to) {
            $fullname = Employee::where(['user_id'=>$assigned_to])->value('fullname');
            $tasks = TaskUser::where(['user_id'=>$assigned_to])
                        ->whereNotIn('status',['Done','Unassigned'])
                        ->whereHas('task', function(Builder $query)use($priority){
                            $query->where('priority',$priority);
                        })
                        ->get();

            $task_point = TaskPoint::where('priority',$priority)->orderBy('id', 'DESC')->first();

            if(count($tasks) >= $task_point->max_limit){
                $restrict_users[] = $fullname;
                $restrict_message .= '<li>'.$fullname.' already has '.count($tasks).' '.$priority.' priority tasks.</li>' ;
            }
        }

        if(!empty($restrict_users)){
            $restrict_message .= "</ul>";
        }else{
            $restrict_message = '';
        }

        return $restrict_message;
    }

    /*
        Save the task in database, send an email & sms notification to the assigned user
    */
    function store(Request $request)
    {
        $request->validate([
            'task_project'  => 'required',
            'department'  => 'required',
            'assigned_to'  => 'required',
            'title'  => 'required|min:10',
            'priority'  => 'required',
            'due_date'  => 'required',
            'description'  => 'required|min:10'
        ]);

        $user = Auth::user();

        $task_point = TaskPoint::where('priority', $request->priority)->orderBy('id', 'DESC')->first();

        foreach ($request->assigned_to as $assigned_to) {
            $task_data = [
                'task_project_id'  => $request->task_project,
                'title'  => $request->title,
                'description'  => $request->description,
                'priority'  => $request->priority,
                'points' => $task_point->weight,
                'task_point_id' => $task_point->id,
                'due_date'  => date("Y-m-d",strtotime($request->due_date))
            ];

            if($request->has('reminder') && $request->reminder == 'on'){
                $task_data['reminder_status'] = 1;
            }

            if($request->has('time_period')){
                $task_data['reminder_days'] = $request->time_period;
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
                'message' => $message
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

        return redirect()->back()->with('success',"Task created successfully.");
    }//end of function

    /*
        Get the listing of tasks assigned to a user with filtering
    */
    function myTasks(Request $request)
    {
        $user = Auth::user();
        $query = Task::whereHas('taskUser', function(Builder $query)use($user){
            $query->where(['user_id'=>$user->id]);
        });

        $task_status = 'None';
        if($request->has('task_status') && $request->task_status != 'None'){
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

        if($my_status != 'None'){
            $query = $query->whereHas('taskUser', function(Builder $query)use($my_status){
                $query->where(['status'=>$my_status]);
            });
        }

        $current_date = date("Y-m-d");
        $tasks = $query->with('taskProject')
                      ->with('taskUser')
                      ->with('user.employee:id,user_id,fullname,profile_picture')
                      ->withCount(['taskUpdates'=>function(Builder $query)use($current_date){
                           $query->where('on_date',$current_date);
                      }])
                      ->orderBy('created_at','DESC')
                      ->get();

        return view('tasks.my_tasks')->with(['tasks'=>$tasks,'task_type'=>$task_type,'my_status'=>$my_status,'task_status'=>$task_status]);
    }//end of function

    /*
        Get the listing of tasks created by a user with filtering
    */
    function viewTasks(Request $request)
    {
        $user = Auth::user();

        $query = Task::where(['user_id'=>$user->id]);

        $user_status = 'None';
        if($request->has('user_status') && $request->user_status != 'None'){
            $user_status = $request->user_status;
            $query = $query->whereHas('taskUser', function(Builder $query)use($user_status){
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

        if($task_status != 'None'){
            $query = $query->where('status',$task_status);
        }

        $current_date = date("Y-m-d");
        $tasks = $query->with('taskProject')
                      ->with('taskUser.user.employee:id,user_id,fullname,profile_picture')
                      ->withCount(['taskUpdates'=>function(Builder $query)use($current_date){
                            $query->where('on_date',$current_date);
                      }])
                      ->orderBy('created_at','DESC')
                      ->get();

        return view('tasks.view_tasks')->with(['tasks'=>$tasks,'task_type'=>$task_type,'task_status'=>$task_status,'user_status'=>$user_status]);
    }//end of function

    /*
        Save the task project to the database
    */
    function saveTaskProject(Request $request)
    {
        $request->validate([
            'name'  => 'required|max:300|min:2|unique:task_projects,name',
            'description'  => 'required|max:300|min:10',
        ]);

        $user = Auth::user();
        $data = [
            'name' => $request->name,
            'description' => $request->description
        ];
        $user->taskProjects()->create($data);

        return redirect()->back()->with('success','Task Project created successfully.');
    }//end of function

    /*
        Ajax request to get task details
    */
    function taskInfo(Request $request)
    {
        $task = Task::where(['id'=>$request->task_id])->first();
        $task->due_date = date("m/d/Y",strtotime($task->due_date));
        $result['task'] = $task;

        return $result;
    }//end of function

    /*
        Select multiple tasks & change the status of assigned tasks
    */
    function changeMyTaskStatus(Request $request)
    {
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
            $message_body = $task_user->user->employee->fullname . " has marked the task titled '".$task->title."' (Due-Date: ".date("d/m/Y", strtotime($task->due_date))."), as done.";
            //$message_body = "You created a task titled: '".$task->title."'. It has been marked as ".$request->selected_status." by '".$task_user->user->employee->fullname."'.'";

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
                $email_message = $message_body." Please mark it as completed, reopened or unassigned.";
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

        return redirect()->back();
    }//end of function

    /*
        Select multiple tasks & change the status of created tasks
    */
    function changeTaskStatus(Request $request)
    {
        $task_ids = explode(",",$request->task_ids);

        foreach ($task_ids as $task_id) {
            $task = Task::find($task_id);

           /* if(($request->selected_status == 'Completed' && $task->taskUser->status != 'Done') || $task->status == $request->selected_status || $task->status == 'Completed' || $task->status == 'Unassigned' || ($request->selected_status == 'Unassigned' && $task->taskUser->status == 'Done')){
                continue;
            }*/

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
            /////////////////////////////////////////
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

        return redirect()->back();
    }//end of function

    /*
        Get information to show on task detail page
    */
    function taskDetail($task_id)
    {
        $task = Task::where(['id'=>$task_id])
                    ->with('taskProject')
                    ->with('taskFiles')
                    //->with('taskUpdates')
                    ->with('taskUser.user.employee:id,user_id,fullname')
                    ->first();

        $task_updates = $task->taskUpdates()->orderBy('id','desc')->get();

        $task_history = $task->messages()
                        ->where('label','like','%Task marked%')
                        ->with('sender.employee:id,user_id,fullname')
                        ->get();

        $latest_chats = $task->messages()
                            ->where('label','like','%Task Chats%')
                            ->with('messageAttachments')
                            ->with('sender.employee:id,user_id,fullname,profile_picture')
                            ->orderBy('id','DESC')
                            ->limit(3)
                            ->get();

        $excluded = [];
        if(!$latest_chats->isEmpty()){
            $latest_chats = $latest_chats->sortBy('id');
            $latest_chats->values()->all();

            $excluded = $latest_chats->pluck('id');
            $excluded->all();
        }

        $more_chats = $task->messages()
                    ->whereNotIn('id',$excluded)
                    ->where('label','like','%Task Chats%')
                    ->with('messageAttachments')
                    ->with('sender.employee:id,user_id,fullname,profile_picture')
                    ->orderBy('id')
                    ->get();

        $user = User::where(['id'=>Auth::id()])->with('employee')->first();

        return view('tasks.task_detail')->with(['task'=>$task,'task_history'=>$task_history,'more_chats'=>$more_chats,'latest_chats'=>$latest_chats,'user'=>$user,'task_updates'=>$task_updates]);
    }//end of function

    /*
        Save the updated values in database, when updating task from task details page
    */
    function updateTask(Request $request)
    {
        $request->validate([
            'title'  => 'required|min:10',
            'priority'  => 'required',
            'due_date'  => 'required',
            'description'  => 'required|min:10'
        ]);

        $task = Task::where('id',$request->task_id)
                    ->with('taskUser')
                    ->first();

        /*if($task->taskUser->status != 'Not-Started'){
            return redirect()->back()->with('error', 'User has started the task, you cannot edit it now.');
        }*/

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

        return redirect()->back();
    }//end of function

    /*
        Save the chat(comment) messages in database, from task details page
    */
    function saveChat(Request $request)
    {
        $task = Task::find($request->task_id);
        $task_user = $task->taskUser;

        if(Auth::id() == $task->user_id){
            $receiver_id = $task_user->user_id;
        }else{
            $receiver_id = $task->user_id;
        }

        $message_data = [
            'sender_id' => Auth::id(),
            'receiver_id' => $receiver_id,
            'label' => 'Task Chats',
            'read_status' => '0',
            'message' => $request->comment_text
        ];
        $message = $task->messages()->create($message_data);

        if($request->hasFile('comment_file')) {
            $file = time().'.'.$request->file('comment_file')->getClientOriginalExtension();
            $request->file('comment_file')->move(config('constants.uploadPaths.uploadMessageAttachment'), $file);

            $file_data['filename'] = $file;
            $message->messageAttachments()->create($file_data);
        }

        return redirect()->back();

    }//end of function

    /*
        Save the daily task updates of tasks marked as inprogress in database from my tasks list page
    */
    function saveTaskUpdate(Request $request)
    {
        $request->validate([
            'task_comment'  => 'required|min:10',
            'on_date'  => 'required'
        ]);

        $user = Auth::user();

        $data = [
            'task_id' => $request->task_id,
            'on_date' => $request->on_date,
            'comment' => $request->task_comment
        ];

        $user->taskUpdates()->create($data);

        return redirect()->back()->with('success','Task updates added successfully.');

    }//end of function

    /*
        This functionality has been moved to the task scheduler in app\Console\Commands
        Send task reminder to task creator & task doer
    */
    function taskReminderCron()
    {   //before due-date reminder to task creator & task user
        Task::where(['isactive'=>1,'reminder_status'=>1])
            ->whereIn('status',['Open','Inprogress','Reopened'])
            ->whereHas('user.employee', function(Builder $query){
                $query->where(['approval_status'=>'1','isactive'=>1]);
            })
            ->with('taskUser')
            ->chunk(10, function($tasks){
                $current_date = date("Y-m-d");
                foreach ($tasks as $task) {
                    $reminder_flag = 0;
                    $task_created_at = date("Y-m-d",strtotime($task->created_at));

                    $check_prev_reminder = $task->notifications()
                                                ->where(['label'=>'Task Reminder'])
                                                ->whereDate('created_at',$current_date)
                                                ->first();

                    if($task->reminder_days >= 1 && $current_date != $task_created_at){
                        if(empty($check_prev_reminder)){
                            $datediff = strtotime($current_date) - strtotime($task_created_at);
                            $datediff = round($datediff / (60*60*24)); //days

                            if($datediff % $task->reminder_days == 0){
                                $reminder_flag = 1;
                            }
                        }
                    }elseif($task->reminder_days == 0.5){
                        if(empty($check_prev_reminder)){
                            $datediff = strtotime(date("Y-m-d H:i:s")) - strtotime($task->created_at);
                        }else{
                            $datediff = strtotime(date("Y-m-d H:i:s")) - strtotime($check_prev_reminder->created_at);
                        }
                        $datediff = round($datediff / (60*60)); //hours
                        $reminder_count = $task->notifications()
                                               ->where(['label'=>'Task Reminder'])
                                               ->whereDate('created_at',$current_date)
                                               ->count();
                        if($datediff > 0 && $datediff % 4 == 0 && $reminder_count < 2){ //every four hours
                            $reminder_flag = 1;
                        }
                    }

                    if($reminder_flag && (strtotime($current_date) <= strtotime($task->due_date))){
                        if($task->taskUser->status == 'Done'){
                            //$message = "You have a task titled: '".$task->title."' (Due-Date: ".date("d/m/Y", strtotime($task->due_date))."), to be marked as completed, reopened or unassigned.";
                            $message = $task->taskUser->user->employee->fullname . " has marked the task titled '".$task->title."' (Due-Date: ".date("d/m/Y", strtotime($task->due_date))."), as completed. Please mark it as done or reopened.";
                            $creator_notification = [
                                'sender_id' => $task->taskUser->user_id,
                                'receiver_id' => $task->user_id,
                                'label' => 'Task Reminder',
                                'read_status' => '0',
                                'redirect_url' => 'tasks/info/'.$task->id,
                                'message' => $message
                            ];
                            $task->notifications()->create($creator_notification);
                            sms($task->user->employee->mobile_number, $message);

                            $mail_data = [
                                'to_email' => $task->user->email,
                                'subject' => 'Task Reminder',
                                'fullname' => $task->user->employee->fullname,
                                'message' => $message
                            ];
                            $this->sendGeneralMail($mail_data);

                        }elseif($task->taskUser->status == 'Not-Started' || $task->taskUser->status == 'Inprogress'){
                            $message = "You have a task titled: '".$task->title."' (Due-Date: ".date("d/m/Y", strtotime($task->due_date))."), to be marked as inprogress or done.";
                            $user_notification = [
                                'sender_id' => $task->user_id,
                                'receiver_id' => $task->taskUser->user_id,
                                'label' => 'Task Reminder',
                                'read_status' => '0',
                                'redirect_url' => 'tasks/info/'.$task->id,
                                'message' => $message
                            ];
                            $task->notifications()->create($user_notification);
                            sms($task->taskUser->user->employee->mobile_number, $message);

                            $mail_data = [
                                'to_email' => $task->taskUser->user->email,
                                'subject' => 'Task Reminder',
                                'fullname' => $task->taskUser->user->employee->fullname,
                                'message' => $message
                            ];
                            $this->sendGeneralMail($mail_data);
                        }
                    }
                }
        });
    }

    /*
        This functionality has been moved to the task scheduler in app\Console\Commands
        Send overdue task notification to task doer & mark a task as delayed
    */
    function updateTaskUserCron()
    {
        User::whereHas('taskUsers', function(Builder $query){
                $query->whereNotIn('status',['Done','Unassigned']);
            })
            ->whereHas('employee', function(Builder $query){
                $query->where(['approval_status'=>'1','isactive'=>1]);
            })
            //->with('taskUsers')
            ->chunk(10, function($users){
                foreach ($users as $user) {
                    $task_users = $user->taskUsers()->whereNotIn('status',['Done','Unassigned'])->get();
                    $message_array = [];
                    foreach ($task_users as $task_user) {
                        $task = $task_user->task;
                        if(strtotime(date("Y-m-d")) > strtotime($task->due_date)){
                            if($task_user->is_delayed == 0){
                                $task_user->is_delayed = 1;
                                $task_user->save();
                            }
                            //after due-date reminder to task doer
                            $message = "You have a task titled: '".$task->title."', that is overdue (Due-Date: ".date("d/m/Y", strtotime($task->due_date))."). Please complete it & mark it as done, as soon as possible.";
                            $overdue_notification = [
                                'sender_id' => $task->user_id,
                                'receiver_id' => $task_user->user_id,
                                'label' => 'Task Overdue Reminder',
                                'read_status' => '0',
                                'redirect_url' => 'tasks/info/'.$task->id,
                                'message' => $message
                            ];
                            $task->notifications()->create($overdue_notification);
                            sms($task_user->user->employee->mobile_number, $message);
                            $message_array[] = $message;
                        }
                    }//endforeach
                    //Pass data to the view to be displayed as list
                    if(count($message_array)){
                        $view = View::make('emails.tasks_overdue',['messages'=>$message_array]);
                        $content = $view->render();
                        //Save the email content in database table
                        EmailContent::updateOrCreate(
                            ['user_id'=>$user->id,'content_type'=>'Task-Overdue'],
                            ['message'=>$content,'sent_status'=>0]
                        );
                    }
                }//endforeach
            });
    }

    /*
        This functionality has been moved to the task scheduler in app\Console\Commands
        Send weekly overdue task email to task doer
    */
    function weeklyTaskOverdueCron()
    {
        $current_week = date('W');
        EmailContent::whereHas('user.employee', function(Builder $query){
                        $query->where(['approval_status'=>'1','isactive'=>1]);
                    })
                    ->where(['content_type'=>'Task-Overdue','sent_status'=>0])
                    ->where(\DB::raw("WEEKOFYEAR(updated_at)"),$current_week)
                    ->with('user.employee:id,user_id,fullname')
                    ->chunk(10, function($contents){
                        foreach ($contents as $content) {
                            $mail_data = [
                                'to_email' => $content->user->email,
                                'subject' => 'Task Overdue Reminder',
                                'fullname' => $content->user->employee->fullname,
                                'message' => $content->message
                            ];
                            $this->sendGeneralMail($mail_data);
                            $content->sent_status = 1;
                            $content->save();
                        }
                    });
    }
    /***************************functions for change request for task due date**********/
    function requestchangeTaskDate()
    {

        $user = Auth::user();
       $data['mytask'] = Task::whereHas('taskUser', function(Builder $query)use($user){
            $query->where(['user_id'=>$user->id ])
            ->where(function(Builder $query)use($user){
                $query->where(['status'=>'Not-Started'])
                ->orWhere(['status'=>'Inprogress']);
            });


        })->get();

        $data['assignee_id'] = $user->id;

        return view('tasks.request_change_form')->with(['data'=>$data]);
    }

    function checkAssignedDate(Request $request){

        $result['mytask'] = Task::where(['id'=>$request->task_id])->first();
        return $result;
    }

    function saveTaskDateChange(Request $request){
        /*echo"<PRE>";
        print_r($request->all());
        exit;*/

        $request->validate([
            'task_title'  => 'required',
            'assigned_date'  => 'required',
            'required_date'  => 'required|min:10',
            'creator_id'  => 'required',
            'remarks'  => 'required|min:10'
        ]);
        $user = User::find($request->assignee_id);
        $task = Task::where('id', $request->task_title)->first();
        $change_date_data = [
                    'task_id' => $request->task_title,
                    'assignee_id' => $request->assignee_id,
                    'assignor_id' => $request->creator_id,
                    'assigned_date' => $request->assigned_date,
                    'required_date' => $request->required_date,
                    'remarks' => $request->remarks,
                    'isactive' => 1
                ];
        TaskDateExtension::create($change_date_data);

        $message = $user->employee->fullname." has sent you a request for extend task date.";
        $notification_data = [
            'sender_id' => $request->assignee_id,
            'receiver_id' => $request->creator_id,
            'label' => 'Change task date Application',
            'read_status' => '0',
            'redirect_url' => 'tasks/info/requested-change-date',
            'message' => $message
        ];
        $notification_data['message'] = $user->employee->fullname." has requested for a date extension in Task '".$task->title."'.";

        $title = 'Task date extension request';
        $body = $notification_data['message'];
        pushNotification($request->creator_id, $title, $body);



        $task_user = User::find($request->creator_id);

        sms($task_user->employee->mobile_number, $notification_data['message']);

        return redirect('tasks/requested-change-date')->with('success','Change task Date request sent successfully.');

    }


     /*
    * Get the list of all the task date change requests made by assignee.
    */
    function requestedChangeTaskDate($final_status = "approved")
    {
        if($final_status == "not-approved"){
            $status = "0";
        }elseif ($final_status == "approved") {
            $status = "1";
        }elseif ($final_status == "rejected") {
            $status = '2';
        }

        $user = Auth::user();

        $changes = TaskDateExtension::where(['status'=>$status, 'assignee_id'=>$user->id])
                                    ->orderBy('created_at','DESC')
                                    ->get();


        if(!$changes->isEmpty()){
            foreach ($changes as $key => $change) {
                //$rejected = TaskDateExtension::where('status','2')->first();
                if($change->status=='2'){

                    $change->is_rejected = true;
                }elseif($change->status=='1'){

                   $get_task_info = Task::where(['id'=>$change->task_id])
                                    ->orderBy('created_at','DESC')
                                    ->first();
                    $change->alloted = $get_task_info->due_date;
                    $change->is_rejected = false;
                }else{
                    $change->is_rejected = false;
                }
            }
        }
        //return $changes;


        return view('tasks.requested_change_date_list')->with(['changes'=>$changes,'status'=>$final_status]);

    }//end of function

    function changeTaskDateApprovals($approval_status = "pending"){

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
        return view('tasks.list_change_task_date_approvals')->with(['approvals'=>$approvals,'selected_status'=>$approval_status]);

    }

    function changeTaskDate(Request $request){

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
            return redirect()->back()->with('success', 'Task date extension request has been Approved.');
        }else{
            return redirect()->back()->with('cannot_cancel_error', 'Task date extension request has been rejected.');
        }
    }

    function listTaskChangeComments(Request $request)
    {
        $task_date_change = TaskDateExtension::find($request->id);
        $messages = $task_date_change->messages()
                    ->where('label','Change Task Date Comment')
                    ->orderBy('created_at','DESC')
                    ->with('sender.employee:id,user_id,fullname')
                    ->with('receiver.employee:id,user_id,fullname')
                    ->get();

        $view = View::make('tasks.list_messages',['data' => $messages]);
        $contents = $view->render();

        return $contents;
    }

    function cancelRequestedChange($change_id)
    {
        $user = Auth::user();

        $change = TaskDateExtension::find($change_id);

        if(empty($change)){
            return redirect()->back()->with('cannot_cancel_error','You cannot cancel somebodies else request');
        }else{
            if($change->status != "0"){
                return redirect()->back()->with('cannot_cancel_error','Concerned authority has taken an action, you cannot cancel it now.');
            }else{
                $change->status = 0;
                $change->isactive = 0;
                $change->save();

                return redirect()->back();
            }
        }
    }//end of function


 /***************************end functions for change request for task due date**********/

}//end of class

