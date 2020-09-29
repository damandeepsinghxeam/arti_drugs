<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use View;
use Mail;
use Auth;
use Validator;
use Carbon\Carbon;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\User;
use App\Employee;
use App\Department;
use App\Task;
use App\TaskProject;
use App\TaskUser;
use App\EmailContent;
use App\Mail\GeneralMail;
use Illuminate\Database\Eloquent\Builder;

class TaskReminderCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'taskReminder:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Before due-date reminder to task creator & task user';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //before due-date reminder to task creator & task user
        Task::where(['isactive'=>1,'reminder_status'=>1])
            ->whereIn('status',['Open','Inprogress','Reopened'])
            ->whereHas('user.employee', function(Builder $query){
                $query->where(['approval_status'=>'1','isactive'=>1]);
            })
            ->with('taskUser')
            ->chunk(10, function($tasks){
                $current_date = date("Y-m-d");
                $start_time = $current_date." 10:00:00 AM";
                $end_time = $current_date." 05:00:00 PM";
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

                            if($datediff % $task->reminder_days == 0 && (strtotime(date("Y-m-d H:i:s")) > strtotime($start_time)) && (strtotime(date("Y-m-d H:i:s")) < strtotime($end_time))){
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
                        if($datediff > 0 && $datediff % 4 == 0 && $reminder_count < 2 && (strtotime(date("Y-m-d H:i:s")) > strtotime($start_time)) && (strtotime(date("Y-m-d H:i:s")) < strtotime($end_time))){ //every four hours
                            $reminder_flag = 1;
                        }
                    }    

                    if($reminder_flag && (strtotime($current_date) <= strtotime($task->due_date))){
                        if($task->taskUser->status == 'Done'){
                            $message = $task->taskUser->user->employee->fullname . " has marked the task titled '".$task->title."' (Due-Date: ".date("d/m/Y", strtotime($task->due_date))."), as done. Please mark it as completed or reopened.";
                            //$message = "You have a task titled: '".$task->title."' (Due-Date: ".date("d/m/Y", strtotime($task->due_date))."), to be marked as completed, reopened or unassigned.";
                            $creator_notification = [
                                'sender_id' => $task->taskUser->user_id,
                                'receiver_id' => $task->user_id,
                                'label' => 'Task Reminder',
                                'read_status' => '0',
                                'redirect_url' => 'tasks/info/'.$task->id,
                                'message' => $message
                            ];
                            $task->notifications()->create($creator_notification);
                            $this->sms($task->user->employee->mobile_number, $message);
                            
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
                            $this->sms($task->taskUser->user->employee->mobile_number, $message);

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

        //\Log::info("Task Reminder Cron is working fine!");
    }

    function sms($phone, $message){

        try{
            return sms($phone, $message);
    
        }catch(\Exception $e){
            return false;
        }    
    }

    function sendGeneralMail($mail_data)
    {   //mail_data Keys => to_email, subject, fullname, message
        return true;
        if(!empty($mail_data['to_email'])){
            Mail::to($mail_data['to_email'])->send(new GeneralMail($mail_data));
        }

        return true;

    }//end of function

}
