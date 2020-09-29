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

class UpdateTaskUserCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'updateTaskUser:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To mark a task doer as delayed & send task overdue reminder to task doer';

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
                        $message = "Your task titled: '".$task->title."', is overdue (Due-Date: ".date("d/m/Y", strtotime($task->due_date))."). Please ask for extension or complete it & mark it as done, as soon as possible.";
                        $overdue_notification = [
                            'sender_id' => $task->user_id,
                            'receiver_id' => $task_user->user_id,
                            'label' => 'Task Overdue Reminder',
                            'read_status' => '0',
                            'redirect_url' => 'tasks/info/'.$task->id,
                            'message' => $message
                        ];
                        $task->notifications()->create($overdue_notification);
                        $this->sms($task_user->user->employee->mobile_number, $message);
                        $message_array[] = $message;
                    }
                }//endforeach
                //Pass data to the view to be displayed as list
                //Commenting emails as no longer required 20-Jul-2020
                // if(count($message_array)){
                //     $view = View::make('emails.tasks_overdue',['messages'=>$message_array]);
                //     $content = $view->render();
                //     //Save the email content in database table
                //     EmailContent::updateOrCreate(
                //         ['user_id'=>$user->id,'content_type'=>'Task-Overdue'],
                //         ['message'=>$content,'sent_status'=>0]
                //     );
                // }
            }//endforeach    
        });
    }

    function sms($phone, $message){

        try{
            return sms($phone, $message);
    
        }catch(\Exception $e){
            return false;
        }    
    }
}
