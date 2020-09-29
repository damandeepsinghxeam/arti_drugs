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
use App\UserManager;
use App\Employee;
use App\Department;
use App\Task;
use App\TaskProject;
use App\TaskUser;
use App\TaskPoint;
use App\EmailContent;
use App\Mail\GeneralMail;
use App\EmployeeKra;
use Illuminate\Database\Eloquent\Builder;

class EmployeekrataskEntry extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'EmployeekrataskEntry:crone';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Every month before due-date reminder to task user';

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
		$current_date = date("Y-m-d");
		$current_day =  date('d');
		$current_year =  date('Y');
		$current_month = date('m');
		
	echo	$employee_kras = EmployeeKra::get();
	
        $i=0;
        $flag=0;
        $due_date=0;
		
		foreach ($employee_kras as $employee_kra) {
		$activation_date = date("Y-m-d",strtotime($employee_kra->activation_date));
		if($activation_date<=current_date){
			if($employee_kra->frequency=="Weekly"){
				if($current_day%7==0 OR $current_day==01){
					$due_day = date('d', strtotime($employee_kra->deadline_date));
					$due_date = $current_year.'-'.$current_month.'-'.$due_day;
					$flag = 1;
				}
			}elseif($employee_kra->frequency=="Daily"){
				$due_day = date('d', strtotime($employee_kra->deadline_date));
				echo $due_date = $current_year.'-'.$current_month.'-'.$due_day;
				$flag = 1;
			}elseif($employee_kra->frequency=="Quarterly"){
				if($current_month%3==0 AND $current_day==01){
					$due_day = date('d', strtotime($employee_kra->deadline_date));
					$due_date = $current_year.'-'.$current_month.'-'.$due_day;
					$flag = 1; 
				}
			}elseif($employee_kra->frequency=="Fortnight"){
				if($current_day==15 OR $current_day==01){
					$due_day = date('d', strtotime($employee_kra->deadline_date));
					$due_date = $current_year.'-'.$current_month.'-'.$due_day;
					$flag = 1; 
				}
			}elseif($employee_kra->frequency=="Annually"){
				$activation_month_day = date("m-d",strtotime($employee_kra->activation_date));
				$current_month_day = date("m-d");
				if($current_month_day==$activation_month_day){
					$due_day = date('d', strtotime($employee_kra->deadline_date));
					$due_date = $current_year.'-'.$current_month.'-'.$due_day;
					$flag = 1; 
				}
			}elseif($employee_kra->frequency=="Biannually"){
				if($current_month_day=="04-01" OR $current_month_day=="10-01"){
					$due_day = date('d', strtotime($employee_kra->deadline_date));
					$due_date = $current_year.'-'.$current_month.'-'.$due_day;
					$flag = 1; 
				}
			}elseif($employee_kra->frequency=="Monthly"){
				$activation_day = date("d",strtotime($employee_kra->activation_date));
				if($activation_day==$current_day){
					$due_day = date('d', strtotime($employee_kra->deadline_date));
					$due_date = $current_year.'-'.$current_month.'-'.$due_day;
					$flag = 1; 
				}
			}
		}
		$due_date_to_time = strtotime($due_date);        
		$get_manager = UserManager::where(['user_id' => $employee_kra->user_id])
							  ->first();
		if($get_manager && $flag == 1 && $due_date_to_time!=""){
			$employee_kra->user_id;
			$manager_id = $get_manager->manager_id;

			$task_data = [
					'user_id' => $manager_id,
					'task_project_id'  => 83,
					'title'  => $employee_kra->name,
					'description'  => "test description",
					'priority'  => $employee_kra->priority,
					'task_point_id' => $task_point->id,
					'due_date' => $due_date,
					'reminder_status'  => $employee_kra->reminder_status,
					'reminder_days' => $employee_kra->reminder_days,
					'reminder_notification' => $employee_kra->reminder_notification,
					'reminder_email' => $employee_kra->reminder_email,
					'overdue_notification' => 1,
					'status' => "Open",
					'points' => $task_point->weight,
					'points_obtained' => 0,
					'isactive' => 1
					];
			$task = task::create($task_data);
			if($task){
				//echo $task->id;
				$task_user_data = [
								'task_id' => $task->id,
								'user_id'  => $employee_kra->user_id,           
								'status' => "Not-Started",
								'is_delayed' => 0          
								];
				$task_user = taskUser::create($task_user_data);
				if($task_user){
					echo "task user id: ".$task_user->id;
				}
			}
		}
		} 
		}
	}
