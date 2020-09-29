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

class WeeklyTaskOverdueCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'weeklyTaskOverdue:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send weekly overdue tasks list to task doer in email';

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
        $current_week = date('W');
        EmailContent::whereHas('user.employee', function(Builder $query){
                        $query->where(['approval_status'=>'1','isactive'=>1]);
                    })
                    ->where(['content_type'=>'Task-Overdue','sent_status'=>0])
                    ->where(\DB::raw("WEEKOFYEAR(updated_at)"),$current_week-1)
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

    function sendGeneralMail($mail_data)
    {   //mail_data Keys => to_email, subject, fullname, message

        if(!empty($mail_data['to_email'])){
            //emaisls commented on 20-Jul-2020 as no longer required
            //Mail::to($mail_data['to_email'])->send(new GeneralMail($mail_data));
        }

        return true;

    }//end of function
}
