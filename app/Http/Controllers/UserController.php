<?php

namespace App\Http\Controllers;
use App\SalaryHead;
use Illuminate\Http\Request;
use App\Mail\ForgotPassword;
use Mail;
use Hash;
use Auth;
use DB;
use Validator;
use Carbon\Carbon;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\User;
use App\Employee;
use App\EmployeeAccount;
use App\EmployeeProfile;
use App\EmployeeAddress;
use App\EmployeeSecurity;
use App\EmployeeReference;
use App\EmploymentHistory;
use App\Country;
use App\State;
use App\City;
use App\Band;
use App\Skill;
use App\Language;
use App\Department;
use App\Location;
use App\Shift;
use App\Bank;
use App\Project;
use App\ProbationPeriod;
use App\Perk;
use App\Qualification;
use App\Document;
use App\Company;
use App\SalaryStructure;
use App\SalaryCycle;
use App\LeaveAuthority;
use App\Message;
use App\Notification;
use App\Designation;
use App\Log;
use App\PtRegistration;
use App\EsiRegistration;
use App\Mail\GeneralMail;
use App\PrintDocument;
use App\UserManager;
use App\Holiday;
use App\Task;
use App\TaskUser;
use App\ShiftException;
use App\Kra;
use App\KraTemplate;
use App\TaskPoint;
use App\EmployeeKra;
use Illuminate\Database\Eloquent\Builder;

class UserController extends Controller

{
    /*
        Get the data to show on replace authority form
    */
    function replaceAuthority()
    {
        $all_users = Employee::whereNotIn('user_id',[1])
            ->with('user:id,employee_code')
            ->get();

        $active_users = Employee::where(['isactive'=>1,'approval_status'=>'1'])
            ->whereNotIn('user_id',[1])
            ->with('user:id,employee_code')
            ->get();

        return view('employees.replace_authority_form')->with(['all_users'=>$all_users,'active_users'=>$active_users]);
    }

    /*
        Replace the previous authority with the new authority in database
    */
    function saveReplaceAuthority(Request $request)
    {
        $request->validate([
            'previous_user' => 'required',
            'authority' => 'required',
            'new_user' => 'required|different:previous_user',
        ]);

        $log = Log::where(['name'=>'User-Updated'])->first();
        $flag = 0;

        if(in_array($request->authority, ['SO1','SO2','SO3'])){
            if($request->authority === 'SO1'){
                $query = UserManager::where('manager_id',$request->previous_user);

                $updated_users = $query->pluck('user_id')
                    ->toArray();

                if(!empty($updated_users)){
                    $update = $query->update(['manager_id'=>$request->new_user]);
                    $log_data = [
                        'log_id' => $log->id,
                        'data' => 'replaced manager_id of users '.implode(',',$updated_users).' from '.$request->previous_user.' to '.$request->new_user
                    ];
                    $flag = 1;
                }
            }elseif ($request->authority === 'SO2') {
                $query = LeaveAuthority::where(['manager_id'=>$request->previous_user,'priority'=>'2']);

                $updated_users = $query->pluck('user_id')
                    ->toArray();

                if(!empty($updated_users)){
                    $update = $query->update(['manager_id'=>$request->new_user]);
                    $log_data = [
                        'log_id' => $log->id,
                        'data' => 'replaced priority level 2 manager_id of users '.implode(',',$updated_users).' from '.$request->previous_user.' to '.$request->new_user
                    ];
                    $flag = 1;
                }
            }elseif ($request->authority === 'SO3') {
                $query = LeaveAuthority::where(['manager_id'=>$request->previous_user,'priority'=>'3']);

                $updated_users = $query->pluck('user_id')
                    ->toArray();

                if(!empty($updated_users)){
                    $update = $query->update(['manager_id'=>$request->new_user]);
                    $log_data = [
                        'log_id' => $log->id,
                        'data' => 'replaced priority level 3 manager_id of users '.implode(',',$updated_users).' from '.$request->previous_user.' to '.$request->new_user
                    ];
                    $flag = 1;
                }
            }
        }


        if($flag){
            $updated_by = Auth::user();
            $username = $updated_by->employee->fullname;
            $log_data['message'] = $log->name. " by ".$username."(".$updated_by->id.").";
            $updated_by->logDetails()->create($log_data);

            return redirect()->back()->with('success', 'User replaced successfully.');
        }else{
            return redirect()->back()->with('success', 'There is nothing to replace.');
        }
    }

    /*
        Assign a specific permission to a specific user
    */
    function givePermission()
    {
        $user = User::find(33);
        $user->givePermissionTo(['dms-approved']);
        echo "Permission given";
    }

    /*
        Revoke a specific permission from a specific user
    */
    function revokePermission()
    {
        $user = User::find(1);
        $user->revokePermissionTo('view-attendance');
        echo "Permission revoked";
    }


    /*
        Create new permission and assign it to super-admin
    */
    function createPermission()
    {

        $data = [
            'name' => 'dms-approved',
            'guard_name' => 'web',
        ];

        Permission::firstOrCreate($data);
        $user = User::find(33);
        $user->givePermissionTo(['dms-approved']);

        echo "Permission created";

    }


    /*
        Send forgot-password email to the user
    */
    function forgotPassword(Request $request)

    {

        $request->validate([

            'email' => 'required|email'

        ]);



        $user = User::where(['email'=>$request->email])->with('employee')->first();



        if(empty($user)){

            return redirect()->back()->with('error_attempt',"Email is incorrect!");



        }else{



            $new_forgot_token = str_random(20);



            if(!$user->employee->isactive){

                return redirect()->back()->with('error_attempt',"Your account has been disabled. Please contact administrator.");



            }elseif($user->employee->approval_status == '0'){

                return redirect()->back()->with('error_attempt',"Your account has not been approved yet. Please contact administrator.");



            }else{



                $forgot_data = ['forgot_password_token' => $new_forgot_token];

                $user->update($forgot_data);



                $new_forgot_token = encrypt($new_forgot_token);



                $user->url = url('/forgot-password')."/".$new_forgot_token;



                Mail::to($user->email)->send(new ForgotPassword($user));



                return redirect('/')->with('error_attempt',"Your forgot password email has been sent successfully.");



            }

        }

    }// end of function


    /*
        Show the reset-password form to the user
    */
    function forgotPasswordForm($encrypted_token)
    {

        $token = decrypt($encrypted_token);



        $user = User::where(['forgot_password_token'=>$token])->first();



        if(!empty($user)){



            $data['token'] = $encrypted_token;

            $data['expire_status'] = "no";

            $data['url'] = "";



        }else{



            $expire_token = "NA";

            $data['token'] = encrypt($expire_token);

            $data['expire_status'] = "yes";

            $data['url'] = url("/forgot-password");



        }

        return view('reset_password_form')->with(['data'=>$data]);

    }//end of function


    /*
        Save the new password from the reset password form
    */
    function resetPassword(Request $request)

    {

        $request->validate([

            'new_password'  => 'bail|required|max:20|min:6',
            'confirm_password'  => 'bail|required|max:20|min:6|same:new_password'

        ]);



        $token = decrypt($request->forgot_token);



        $user = User::where(['forgot_password_token'=>$token])->first();



        if(!empty($user)){

            $new_password = Hash::make($request->new_password);

            $user->password = $new_password;

            $user->forgot_password_token = "";

            $user->save();



            return redirect('/')->with('error_attempt',"Your password has been changed successfully.");



        }else{



            return redirect()->back()->with(['password_error'=>"Your reset password link has expired. Please send the email again."]);



        }



    }//end of function


    /*
        Authenticate a user with employee code & password & then redirect to dashboard
    */
    function login(Request $request)

    {

        $request->validate([

            'employee_code' => 'required',

            'password' => 'bail|required|min:6|max:20'

        ]);

        if($request->has('remember_me')){
            $remember = true;
        }else{
            $remember = false;
        }

        if(Auth::attempt(['employee_code'=>$request->employee_code,'password'=>$request->password], $remember)){

            $user = Auth::user();

            $employee = $user->employee->first();



            if($employee->isactive && $employee->approval_status == '1'){

                //      $employeeMixedData = $this->employeeModel->mixedEmployeeData($employeeId);

                //      $probationData =  $this->commonModel->probationCalculations($employeeId);



                //      if(!empty($probationData->probationEndDate)){

                //     if($probationData->probationEndOrNot == '0' && $empProfile->probation_status == '0'){

                //       $this->commonModel->notifyProbationApprovers($probationData,$employeeMixedData);

                //     }

                // }



                return redirect('employees/dashboard');



            }elseif($employee->approval_status == '0'){

                Auth::logout();

                return redirect('/')->with('error_attempt',"Your account has not been approved yet. Please contact administrator.");



            }elseif(!$employee->isactive){

                Auth::logout();

                return redirect('/')->with('error_attempt',"Your account has been disabled. Please contact administrator.");



            }



        }else{

            return redirect('/')->with('error_attempt',"Employee Code or Password is incorrect!");

        }

    }//end of function


    /*
        Show the dashboard page with necessary data
    */

    function dashboard(Request $request)
    {
        $user_info = User::where(['id'=>Auth::id()])->first();
        $data['user'] = User::where(['id'=>Auth::id()])
            ->with(['employee', 'employeeProfile', 'roles:id,name'])
            ->first();

        $data['tasks'] =  TaskUser::where('user_id', Auth::id())
            ->with('task')
            ->where('status', 'Inprogress')
            ->paginate(4);

        $data['holidays'] = Holiday::orderBy('holiday_from', 'asc')
            ->take(4)
            ->where('isactive', '1')
            ->whereDate('holiday_from', '>', Carbon::now())
            ->get();

        $data['birthdays'] = Employee::whereRaw('DAYOFYEAR(curdate()) <= DAYOFYEAR(birth_date) AND DAYOFYEAR(curdate()) + 30 >=  dayofyear(birth_date)' )
            ->orderByRaw('DATE_FORMAT(birth_date, "%m-%d")', 'asc')
            ->where('isactive', '1')
            ->get();

        $data['independence_day'] = Holiday::whereRaw('YEAR(curdate()) = YEAR(holiday_from) AND DAY(holiday_from)=15' )->first();

        $data['probation_data'] = probationCalculations($user_info);
        $data['attendances_info'] = DB::table("employees")->select('id', 'user_id', 'fullname', 'mobile_number')->whereNotIn('user_id',function($query) {
            $query->select('user_id')->where('on_date', date("Y-m-d"))->from('attendances');
        })
            ->where('isactive', 1)
            ->get();

        $data['missed_punch_count'] =   count($data['attendances_info']);

        return view('admins.dashboard', $data);//->with(['user'=>$user, 'holidays'=>$holidays]);


    }//end of function


    /*
        End user session & redirect to the landing page
    */
    function logout()

    {

        session(['last_inserted_employee' => 0,'last_inserted_project' => 0,'last_tabname' => ""]);

        Auth::logout();

        return redirect('/');

    }

    /*
        List the employees as per roles & other filters like department & project
    */
    function list(Request $request)

    {

        $user = Auth::user();

        if(empty($request->project_id)){
            $req['project_id'] = 1;
        }else{
            $req['project_id'] = $request->project_id;
        }

        if(empty($request->department_id)){
            $req['department_id'] = "";
        }else{
            $req['department_id'] = $request->department_id;
        }

        if($user->hasRole('MD') || $user->hasRole('AGM') || $user->id == 1){

            if($req['project_id'] == 'All'){
                $query = DB::table('employees as emp')
                    ->join('users as u','emp.user_id','=','u.id');
            }else{
                $query = DB::table('employees as emp')
                    ->join('users as u','emp.user_id','=','u.id')
                    ->join('project_user as pu','emp.user_id','=','pu.user_id');

                if(!empty($request->department_id)){
                    $query = $query->join('employee_profiles as empp','empp.user_id','=','u.id')
                        ->where(['empp.department_id'=>$request->department_id]);
                }

                $query = $query->where('pu.project_id',$req['project_id']);
            }
            $data = $query->select('u.*','emp.*')
                ->orderBy('emp.created_at','DESC')
                ->get();

        }else{



            $data = DB::table('employees as emp')

                ->join('users as u','emp.user_id','=','u.id')

                ->join('employee_profiles as empp','empp.user_id','=','u.id')

                ->where(['empp.department_id'=>$user->employeeProfile->department_id,'emp.isactive'=>1])

                ->select('u.*','emp.*')

                ->orderBy('emp.created_at','DESC')

                ->get();

        }



        $projects = Project::where(['isactive'=>1,'approval_status'=>'1'])->get();
        $departments = Department::where(['isactive'=>1])->select('id','name')->get();

        return view('employees.list')->with(['data'=>$data,'departments'=>$departments,'projects'=>$projects,'req'=>$req]);



    }//end of function


    /*
        Activate or Deactivate an employee with relieve/rejoin data
    */
    function changeEmployeeStatus(Request $request)

    {

        $employee = Employee::where(['user_id'=>$request->user_id])->first();



        if($request->action == "activate"){



            $data = [

                'isactive' => 1,

                'rejoin_date' => date("Y-m-d",strtotime($request->action_date)),

                'rejoin_description' => $request->description

            ];



        }elseif($request->action == "deactivate"){



            $data = [

                'isactive' => 0,

                'relieve_date' => date("Y-m-d",strtotime($request->action_date)),

                'relieve_description' => $request->description

            ];



        }



        $employee->update($data);



        return redirect('employees/list');



    }//end of function

    function bandCity(Request $request){

        $city=City::where('id', $request->city)

            ->with(['city_class', 'city_class.bands'])

            ->first();



        return Band::where('id', $request->band)

            ->with(['city_class' => function($query) use ($request, $city){

                $query->where('city_class_id',$city->city_class_id);

            }])

            ->first();



    }


    /*
        Get the information required to show on create employee form
    */
    function create($tabname = null)

    {
    
        $data = array();



        if(empty($tabname)){

            $data['tabname'] = "basicDetailsTab";

        }else{

            $data['tabname'] = $tabname;

        }



        $data['roles'] = Role::select('id','name')->get();

        $data['permissions'] = Permission::select('id','name')->get();

        $data['countries'] = Country::where(['isactive'=>1])->get();



        $data['states'] = State::where(['isactive'=>1])->get();

        //$data['cities'] = City::where(['isactive'=>1])->get();

        $data['skills'] = Skill::where(['isactive'=>1])->select('id','name')->get();



        $data['languages'] = Language::where(['isactive'=>1])->select('id','name')->get();

        $data['departments'] = Department::where(['isactive'=>1])->select('id','name')->get();

        $data['locations'] = Location::where(['isactive'=>1])->select('id','name')->get();



        $data['shifts'] = Shift::where(['isactive'=>1])->select('id','name')->get();

        $data['projects'] = Project::where(['isactive'=>1,'approval_status'=>'1'])->get();


        $data['financial_institutions'] = Bank::where(['isactive'=>1])->select('id','name')->get();



        $data['probation_periods'] = ProbationPeriod::where(['isactive'=>1])->get();

        $data['perks'] = Perk::where(['isactive'=>1])->select('id','name')->get();

        $data['qualifications'] = Qualification::where(['isactive'=>1])->select('id','name')->get();



        $data['designations'] = Designation::where(['isactive'=>1])->select('id','name')->get();



        $data['next_available_uid'] = User::max('id') + 1;

        $data['salary_cycles'] = SalaryCycle::where(['isactive'=>1])->get();

        $data['salary_structures'] = SalaryStructure::where(['isactive'=>1])->get();

        $last_inserted_employee = session('last_inserted_employee');


        if(empty($last_inserted_employee)){

            $last_inserted_employee = 0;

            $data['employment_histories'] = collect();

            $data['qualification_documents'] = collect();

            $data['kra_details'] = Kra::get();

        }else{

            $data['kra_details'] = Kra::whereIn('dep_id', function($query ) use ($last_inserted_employee){
                $query->select('department_id')
                    ->from('employee_profiles')
                    ->where('user_id', $last_inserted_employee);
            })->get();

            $data['employment_histories'] = EmploymentHistory::where(['user_id'=>$last_inserted_employee,'isactive'=>1])->get();

            $data['qualification_documents'] = DB::table('qualification_user as qu')

                ->join('qualifications as q','q.id','=','qu.qualification_id')

                ->where(['qu.user_id'=>$last_inserted_employee,'qu.isactive'=>1])

                ->select('qu.id','qu.qualification_id','qu.filename','q.name')

                ->get();

        }



        $data['documents'] = Document::where(['document_category_id'=>1,'isactive'=>1])

            ->get();

        foreach ($data['documents'] as $key => $value) {

            $value->filenames = DB::table('document_user')

                ->where(['document_id'=>$value->id,'user_id'=>$last_inserted_employee])

                ->pluck('name')->toArray();

        }

        $data['tasks'] = Task::where('isactive', '1')->get();

        $earningSalaryHeads = SalaryHead::where('type','earning')->get();
        $deductionSalaryHeads = SalaryHead::where('type','deduction')->get();
        return view('employees.create')->with(['data'=>$data,'earningSalaryHeads' => $earningSalaryHeads, 'deductionSalaryHeads' => $deductionSalaryHeads]);
    }//end of function


    /*
        Get the information required to show on edit employee form
    */
    function edit($user_id,$tabname = null)
    {

        $data = array();

        if(empty($tabname)){
            $data['tabname'] = "basicDetailsTab";
        }else{
            $data['tabname'] = $tabname;
        }

        $data['roles'] = Role::select('id','name')->get();

        $data['permissions'] = Permission::select('id','name')->get();

        $data['countries'] = Country::where(['isactive'=>1])->get();



        $data['states'] = State::where(['isactive'=>1])->get();

        $data['skills'] = Skill::where(['isactive'=>1])->select('id','name')->get();



        $data['languages'] = Language::where(['isactive'=>1])->select('id','name')->get();

        $data['departments'] = Department::where(['isactive'=>1])->select('id','name')->get();

        $data['locations'] = Location::where(['isactive'=>1])->select('id','name')->get();

        $data['shifts'] = Shift::where(['isactive'=>1])->select('id','name')->get();

        $data['projects'] = Project::where(['isactive'=>1,'approval_status'=>'1'])->get();

        $data['financial_institutions'] = Bank::where(['isactive'=>1])->select('id','name')->get();



        $data['probation_periods'] = ProbationPeriod::where(['isactive'=>1])->get();

        $data['perks'] = Perk::where(['isactive'=>1])->select('id','name')->get();

        $data['qualifications'] = Qualification::where(['isactive'=>1])->select('id','name')->get();



        $data['designations'] = Designation::where(['isactive'=>1])->select('id','name')->get();



        //$data['next_available_uid'] = User::max('id') + 1;

        $data['salary_cycles'] = SalaryCycle::where(['isactive'=>1])->get();

        $data['salary_structures'] = SalaryStructure::where(['isactive'=>1])->get();



        $data['employment_histories'] = EmploymentHistory::where(['user_id'=>$user_id,'isactive'=>1])->get();

        $data['qualification_documents'] = DB::table('qualification_user as qu')

            ->join('qualifications as q','q.id','=','qu.qualification_id')

            ->where(['qu.user_id'=>$user_id,'qu.isactive'=>1])

            ->select('qu.id','qu.qualification_id','qu.filename','q.name')

            ->get();



        $data['documents'] = Document::where(['document_category_id'=>1,'isactive'=>1])

            ->get();



        foreach ($data['documents'] as $key => $value) {

            $value->filenames = DB::table('document_user')

                ->where(['document_id'=>$value->id,'user_id'=>$user_id])

                ->pluck('name')->toArray();

        }



        $data['user'] = User::where(['id'=>$user_id])

            ->with('employee')

            ->with('employeeProfile')

            ->with('approval.approver.employee:id,user_id,fullname')

            ->with('roles:id,name')

            ->with('languages')

            ->with('locations')

            ->with('skills')

            ->with('qualifications')

            ->with('permissions:id,name')

            ->with('perks')

            ->with('projects')

            ->with('userManager.manager.employee:id,user_id,fullname')

            ->with('employeeAddresses')

            ->with('employeeAccount')

            ->with('employeeReferences')

            ->with('employeeSecurity')

            ->first();

        $dep_id = $data['user']->employeeProfile->department_id;

        $data['all_kra_temp'] = Kra::where('dep_id', $dep_id)->get();

        if($data['user']->employee->approval_status == '0'){

            $data['approve_url'] = url("employees/approve");

            $data['approver_name'] = "";

        }else{

            $data['approve_url'] = "";

            $data['approver_name'] = $data['user']->approval->approver->employee->fullname;

        }



        $data['language_check_boxes'] = $data['user']->languages()

            ->select('language_id','read_language','write_language','speak_language')

            ->get()->toArray();



        $leave_authorities = $data['user']->leaveAuthorities()

            ->where('isactive',1)

            ->orderBy('priority')

            ->pluck('manager_id')

            ->toArray();



        if(@$data['user']->userManager->manager->employee->user_id){

            array_unshift($leave_authorities,$data['user']->userManager->manager->employee->user_id);

        }



        if(!empty($leave_authorities)){

            $distinct_leave_authorities = array_unique($leave_authorities);

            $so_departments = EmployeeProfile::whereIn('user_id',$distinct_leave_authorities)

                ->pluck('department_id')

                ->toArray();



            $distinct_so_departments = array_unique($so_departments);

            $data['leave_authorities'] = $leave_authorities;

            $data['so_departments'] = $distinct_so_departments;

        }else{

            $data['leave_authorities'] = [];

            $data['so_departments'] = [];

        }

        $data['shift_exception_details'] = ShiftException::where(['user_id'=>$user_id])

            ->with('Shift')
            ->get();


        $data['employee_kra_details'] = EmployeeKra::where(['user_id'=>$user_id])
            ->with('kra')
            ->get();



        $data['emp_temp'] =   Kra::whereHas('employeekra', function (Builder $query) use($user_id) {
            $query->where(['user_id'=>$user_id]);
        })->first();
        $data['emp_id'] = $user_id;

        if($data['emp_temp']){
            $data['all_kra_indicators']=  KraTemplate::where(['kra_id'=>$data['emp_temp']->id])
                ->get();
        }

         $data['earning_heads'] = DB::table('employee_salary_structures')->where(['user_id'=>$user_id])->where('calculation_type', 'earning')->get();

         $data['deduction_heads'] = DB::table('employee_salary_structures')->where(['user_id'=>$user_id])->where('calculation_type', 'deduction')->get();

        $employeeSalaryStructure = DB::table('employee_salary_structures')->where(['user_id'=>$user_id])->first();
        if(isset($employeeSalaryStructure)){
            $data['restrict_pf'] = $employeeSalaryStructure->restrict_pf;
            $data['pt_rate_applied'] = $employeeSalaryStructure->pt_rate_applied;
            $data['lwf_applied'] = $employeeSalaryStructure->lwf_applied;
            $data['salary_cycle_id'] = $employeeSalaryStructure->salary_cycle_id;
            $data['salary_cycle_name'] = SalaryCycle::where('id', $data['salary_cycle_id'])->first()->name;
        }else{
            $data['restrict_pf'] = '';
            $data['lwf_applied'] = '';
            $data['salary_cycle_id'] = '';
            $data['salary_cycle_name'] = '';
            $data['pt_rate_applied'] = '';
        }

        return view('employees.edit')->with(['data'=>$data]);



    }//end of function


    /*
        Approve a specific employee after creating the employee
    */
    function approveEmployee(Request $request)

    {

        $user = User::find($request->user_id);

        $employee = $user->employee;



        $approver = Auth::user();



        if($employee->approval_status == '0'){

            $employee->approval_status = '1';

            $employee->save();



            $user->approval()->create(['approver_id'=>$approver->id]);

        }



        $result['approver_name'] = $approver->employee->fullname;

        $result['approved'] = 1;

        return $result;



    }//end of function



    /*
        Save the details of basic details tab of create employee form
    */
    function createBasicDetails(Request $request)

    {

        $validator = Validator::make($request->all(), [

            'email' => 'bail|required|unique:users,email',

            'mobile' => 'bail|required|unique:employees,mobile_number',

            'password' => 'bail|required',

            'birthDate' => 'bail|required',

            'joiningDate' => 'bail|required',

            'employeeName' => 'bail|required',

            'employeeLastName' => 'bail|required',

            'employeeXeamCode' => 'bail|required|unique:users,employee_code',

            'oldXeamCode' => 'bail|required',

            'languageIds' => 'bail|required',

            'skillIds' => 'bail|required',
            'attendanceType' => 'bail|required'

        ]);



        if($validator->fails()) {

            return redirect("employees/create")

                ->withErrors($validator,'basic')

                ->withInput();

        }



        $user_data = [

            'email' => $request->email,

            'employee_code'  => $request->employeeXeamCode,

            'password' => Hash::make($request->password),

        ];



        $user = User::create($user_data);



        if(empty($request->employeeMiddleName)){

            $employee_middle_name = "";

        }else{

            $employee_middle_name = $request->employeeMiddleName;

        }



        $fullname = $request->employeeName." ".$employee_middle_name." ".$request->employeeLastName;



        if($request->expYrs == 0){

            $experience = "0-0";

            $experience_status = '0';

        }else{

            $experience = $request->expYrs."-".$request->expMns;

            $experience_status = '1';

        }



        $employee_data = [

            'user_id' => $user->id,

            'creator_id' => Auth::id(),

            'employee_id' => $request->oldXeamCode,

            'salutation' => $request->salutation,

            'fullname' => $fullname,

            'first_name' => $request->employeeName,

            'middle_name' => $employee_middle_name,

            'last_name' => $request->employeeLastName,

            'personal_email' => $request->personalEmail,

            'attendance_type' => $request->attendanceType,

            'mobile_number' => $request->mobile,

            'country_id' => $request->mobileStdId,

            'alternative_mobile_number' => $request->altMobile,

            'alt_country_id' => $request->altMobileStdId,

            'experience_year_month' => $experience,

            'experience_status' => $experience_status,

            'marital_status' => $request->maritalStatus,

            'gender' => $request->gender,

            'approval_status' => '0',

            'father_name' => $request->fatherName,

            'mother_name' => $request->motherName,

            'spouse_name' => "",

            'birth_date'  => date("Y-m-d",strtotime($request->birthDate)),

            'joining_date' => date("Y-m-d",strtotime($request->joiningDate)),

            'nominee_name'  => $request->nominee,

            'relation'  => $request->relation,

            'nominee_type' => $request->nomineeType,

            'registration_fees'=> $request->registrationFees,

            'application_number' => $request->applicationNumber,

            'spouse_working_status' => 'No',

            'spouse_company_name' => '',

            'spouse_designation' => '0',

            'spouse_contact_number' => '',

        ];



        if(empty($request->referralCode)){

            $employee_data['referral_code'] = strtoupper(str_random(8));

        }else{

            $employee_data['referral_code'] = $request->referralCode;

        }



        if($request->nomineeType == 'Insurance'){

            $employee_data['insurance_company_name'] = $request->insuranceCompanyName;

            $employee_data['cover_amount'] = $request->coverAmount;

            $employee_data['type_of_insurance'] = $request->typeOfInsurance;

            $employee_data['insurance_expiry_date'] = date("Y-m-d",strtotime($request->insuranceExpiryDate));

        }



        if($request->maritalStatus == "Married" || $request->maritalStatus == "Widowed"){

            $employee_data['spouse_name'] = $request->spouseName;

            $employee_data['marriage_date'] = date("Y-m-d",strtotime($request->marriageDate));



            if($request->maritalStatus == "Married" && !empty($request->spouseWorkingStatus) && $request->spouseWorkingStatus == "Yes"){

                $employee_data['spouse_working_status'] = "Yes";

                $employee_data['spouse_company_name'] = $request->spouseCompanyName;

                $employee_data['spouse_designation'] = $request->spouseDesignation;

                $employee_data['spouse_contact_number'] = $request->spouseContactNumber;

            }

        }



        if($request->hasFile('profilePic')) {

            $profile_pic = time().'.'.$request->file('profilePic')->getClientOriginalExtension();

            $request->file('profilePic')->move(config('constants.uploadPaths.uploadPic'), $profile_pic);



            $employee_data['profile_picture'] = $profile_pic;

        }



        $employee = Employee::create($employee_data);



        $referrer = Employee::where('referral_code',$request->referralCode)->first();



        if(!empty($request->referralCode) && !empty($referrer)){

            $referral_data = [

                'referrer_id' => $referrer->user_id

            ];



            $user->employeeReferral()->create($referral_data);

        }



        if(!empty($request->skillIds)){

            $user->skills()->sync($request->skillIds);

        }



        if(!empty($request->qualificationIds)){

            $user->qualifications()->sync($request->qualificationIds);

        }



        if(!empty($request->languageIds)){

            $user->languages()->sync($request->languageIds);

        }



        $post_array = $request->all();

        $language_check_boxes = [];



        foreach ($request->languageIds as $key => $value) {

            $key2 = 'lang'.$value;



            if(!empty($post_array[$key2])){

                $language_check_boxes[$value] = $post_array[$key2];

            }else{

                $language_check_boxes[$value] = array();

            }



            if(in_array('1',$language_check_boxes[$value])){

                $check_box_data['read_language'] = true;

            }else{

                $check_box_data['read_language'] = false;

            }



            if(in_array('2',$language_check_boxes[$value])){

                $check_box_data['write_language'] = true;

            }else{

                $check_box_data['write_language'] = false;

            }



            if(in_array('3',$language_check_boxes[$value])){

                $check_box_data['speak_language'] = true;

            }else{

                $check_box_data['speak_language'] = false;

            }



            $find_language = DB::table('language_user')

                ->where(['user_id'=>$user->id,'language_id'=>$value])

                ->update($check_box_data);





        }



        session(['last_inserted_employee' => $user->id]);



        if($request->formSubmitButton == 'sc'){

            return redirect("employees/create/projectDetailsTab")->with('profileSuccess',"Details saved successfully.");

        }else{

            return redirect("employees/dashboard");

        }

    }//end of function


    /*
        Save the details of basic details tab of edit employee form
    */
    function editBasicDetails(Request $request)

    {

        $validator = Validator::make($request->all(), [

            'birthDate' => 'bail|required',

            'joiningDate' => 'bail|required',

            'employeeName' => 'bail|required',

            'employeeLastName' => 'bail|required',

            'languageIds' => 'bail|required',

            'skillIds' => 'bail|required',

            'attendanceType' => 'bail|required'

        ]);



        if($validator->fails()) {

            return redirect("/employees/edit/$request->employeeId")

                ->withErrors($validator,'basic')

                ->withInput();

        }



        $user_data = Employee::where(['user_id'=>$request->employeeId])

            ->with('user')

            ->with('user.languages')

            ->with('user.skills')

            ->with('user.qualifications')

            ->first();



        $log = Log::where(['name'=>'User-Updated'])->first();

        $log_data = [

            'log_id' => $log->id,

            'data' => $user_data->toJson()

        ];



        $updated_by = Auth::user();

        $username = $updated_by->employee->fullname;

        $log_data['message'] = $log->name. " by ".$username."(".$updated_by->id.").";

        $user_data->logDetails()->create($log_data);



        $user = User::find($request->employeeId);



        if(empty($request->employeeMiddleName)){

            $employee_middle_name = "";

        }else{

            $employee_middle_name = $request->employeeMiddleName;

        }



        $fullname = $request->employeeName." ".$employee_middle_name." ".$request->employeeLastName;



        if($request->expYrs == 0){

            $experience = "0-0";

            $experience_status = '0';

        }else{

            $experience = $request->expYrs."-".$request->expMns;

            $experience_status = '1';

        }



        $employee_data = [

            'salutation' => $request->salutation,

            'fullname' => $fullname,

            'first_name' => $request->employeeName,

            'middle_name' => $employee_middle_name,

            'last_name' => $request->employeeLastName,

            'personal_email' => $request->personalEmail,

            'attendance_type' => $request->attendanceType,

            'alternative_mobile_number' => $request->altMobile,

            'alt_country_id' => $request->altMobileStdId,

            'experience_year_month' => $experience,

            'experience_status' => $experience_status,

            'marital_status' => $request->maritalStatus,

            'gender' => $request->gender,

            'father_name' => $request->fatherName,

            'mother_name' => $request->motherName,

            'spouse_name' => "",

            'birth_date'  => date("Y-m-d",strtotime($request->birthDate)),

            'joining_date' => date("Y-m-d",strtotime($request->joiningDate)),

            'nominee_name'  => $request->nominee,

            'relation'  => $request->relation,

            'nominee_type' => $request->nomineeType,

            'registration_fees'=> $request->registrationFees,

            'application_number' => $request->applicationNumber,

            'spouse_working_status' => 'No',

            'spouse_company_name' => '',

            'spouse_designation' => '0',

            'spouse_contact_number' => '',

        ];



        if($request->nomineeType == 'Insurance'){

            $employee_data['insurance_company_name'] = $request->insuranceCompanyName;

            $employee_data['cover_amount'] = $request->coverAmount;

            $employee_data['type_of_insurance'] = $request->typeOfInsurance;

            $employee_data['insurance_expiry_date'] = date("Y-m-d",strtotime($request->insuranceExpiryDate));

        }



        if($request->maritalStatus == "Married" || $request->maritalStatus == "Widowed"){

            $employee_data['spouse_name'] = $request->spouseName;

            $employee_data['marriage_date'] = date("Y-m-d",strtotime($request->marriageDate));



            if($request->maritalStatus == "Married" && !empty($request->spouseWorkingStatus) &&             $request->spouseWorkingStatus == "Yes"){

                $employee_data['spouse_working_status'] = "Yes";

                $employee_data['spouse_company_name'] = $request->spouseCompanyName;

                $employee_data['spouse_designation'] = $request->spouseDesignation;

                $employee_data['spouse_contact_number'] = $request->spouseContactNumber;

            }

        }



        if($request->hasFile('profilePic')) {

            $profile_pic = time().'.'.$request->file('profilePic')->getClientOriginalExtension();

            $request->file('profilePic')->move(config('constants.uploadPaths.uploadPic'), $profile_pic);



            $employee_data['profile_picture'] = $profile_pic;

        }



        $employee = Employee::where(['user_id'=>$user->id])->update($employee_data);



        if(!empty($request->skillIds)){

            $user->skills()->sync($request->skillIds);

        }



        if(!empty($request->qualificationIds)){

            $user->qualifications()->sync($request->qualificationIds);

        }



        if(!empty($request->languageIds)){

            $user->languages()->sync($request->languageIds);

        }



        $post_array = $request->all();

        $language_check_boxes = [];



        foreach ($request->languageIds as $key => $value) {

            $key2 = 'lang'.$value;



            if(!empty($post_array[$key2])){

                $language_check_boxes[$value] = $post_array[$key2];

            }else{

                $language_check_boxes[$value] = array();

            }



            if(in_array('1',$language_check_boxes[$value])){

                $check_box_data['read_language'] = true;

            }else{

                $check_box_data['read_language'] = false;

            }



            if(in_array('2',$language_check_boxes[$value])){

                $check_box_data['write_language'] = true;

            }else{

                $check_box_data['write_language'] = false;

            }



            if(in_array('3',$language_check_boxes[$value])){

                $check_box_data['speak_language'] = true;

            }else{

                $check_box_data['speak_language'] = false;

            }



            $find_language = DB::table('language_user')

                ->where(['user_id'=>$user->id,'language_id'=>$value])

                ->update($check_box_data);

        }



        if($request->formSubmitButton == 'sc'){

            return redirect("/employees/edit/$request->employeeId/projectDetailsTab")->with('profileSuccess',"Details updated successfully.");

        }else{

            return redirect("/employees/dashboard");

        }



    }//end of function


    /*
        Save the details of profile details tab of create employee form
    */
    function createProfileDetails(Request $request)

    {

        $validator = Validator::make($request->all(), [

            'projectId' => 'bail|required',

            'locationId' => 'bail|required',

            'shiftTimingId' => 'bail|required',

            'probationPeriodId' => 'bail|required',

            'permissionIds' => 'bail|required',

            'employeeIds' => 'bail|required',

            'roleId' => 'bail|required',

            //'designation' => 'bail|required'

        ]);



        if($validator->fails()) {

            return redirect('/employees/create/projectDetailsTab')

                ->withErrors($validator,'profile')

                ->withInput();

        }



        $employee_profile_data =   [

            'shift_id'  => $request->shiftTimingId,

            'department_id' => $request->departmentId,

            "probation_period_id" => $request->probationPeriodId,

            'state_id' => $request->stateId,

            'probation_approval_status' => '0',

            'probation_hod_approval' => '0',

            'probation_hr_approval' => '0'

        ];



        $last_inserted_employee = session('last_inserted_employee');

        $check_unique = EmployeeProfile::where(['user_id'=>$last_inserted_employee])->first();



        if(!empty($check_unique->user_id)){

            return redirect('employees/create')->with('profileError',"Details of this employee have already been saved. Please create a new employee.");



        }else{



            $user = User::find($last_inserted_employee);

            $role = Role::find($request->roleId);

            $user->assignRole($role->name);

            $user->syncPermissions($request->permissionIds);



            $employee = $user->employee()->first();

            $probation = ProbationPeriod::find($request->probationPeriodId);



            $employee_profile_data['probation_end_date'] = Carbon::parse($employee->joining_date)->addDays($probation->no_of_days)->toDateString();



            $user->employeeProfile()->create($employee_profile_data);

            if(is_array($request->exceptionshiftTimingId) && is_array($request->exceptionshiftday)){
                for($i=0;$i<count($request->exceptionshiftTimingId); $i++){
                    $ShiftExcept = new ShiftException;
                    $ShiftExcept->user_id       = $last_inserted_employee;
                    $ShiftExcept->shift_id      = $request->exceptionshiftTimingId[$i];
                    $ShiftExcept->week_day = $request->exceptionshiftday[$i];;
                    $ShiftExcept->save();

                }
            }

            $user->userManager()->create(['manager_id'=>$request->employeeIds]);


            $manager = User::find($request->employeeIds);

            if(!$manager->hasPermissionTo('approve-leave')){

                $manager->givePermissionTo(['approve-leave']);

            }



            if(!empty($request->hodId)){

                $user->leaveAuthorities()->create(['manager_id'=>$request->hodId,'priority'=>'2']);

                $manager = User::find($request->hodId);

                if(!$manager->hasPermissionTo('approve-leave')){

                    $manager->givePermissionTo(['approve-leave']);

                }

            }



            if(!empty($request->hrId)){

                $user->leaveAuthorities()->create(['manager_id'=>$request->hrId,'priority'=>'3']);

                $manager = User::find($request->hrId);

                if(!$manager->hasPermissionTo('approve-leave')){

                    $manager->givePermissionTo(['approve-leave']);

                }

            }



            if(!empty($request->mdId)){

                $user->leaveAuthorities()->create(['manager_id'=>$request->mdId,'priority'=>'4']);

                $manager = User::find($request->mdId);

                if(!$manager->hasPermissionTo('approve-leave')){

                    $manager->givePermissionTo(['approve-leave']);

                }

            }



            if(!empty($request->perkIds)){

                $user->perks()->sync($request->perkIds);

            }



            if(!empty($request->locationId)){

                $locations = [];

                array_push($locations,$request->locationId);

                $user->locations()->sync($locations);

            }



            $projects = [];

            array_push($projects,$request->projectId);



            if(!empty($request->projectId)){

                $user->projects()->sync($projects);

            }



            if(!empty($request->designation)){

                $designations = [];

                array_push($designations,$request->designation);

                $user->designation()->sync($designations);

            }



            if($request->formSubmitButton == 'sc'){

                return redirect("employees/create/documentDetailsTab")->with('documentSuccess',"Details saved successfully.");

            }else{

                return redirect("employees/dashboard");

            }



        }



    }//end of function


    /*
        Save the details of profile details tab of edit employee form
    */
    function editProfileDetails(Request $request)

    {

        $validator = Validator::make($request->all(), [

            'projectId' => 'bail|required',

            'locationId' => 'bail|required',

            'shiftTimingId' => 'bail|required',

            //'probationPeriodId' => 'bail|required',

            'permissionIds' => 'bail|required',

            'employeeIds' => 'bail|required',

            'roleId' => 'bail|required',

            //'designation' => 'bail|required'

        ]);

        if($request->dep_id!="")
        {

            $dep_kra = Kra::where(['dep_id' => $request->dep_id])
                ->get();

            return( json_encode($dep_kra));

        }

        if($request->kra_id!="")
        {

            $kraData = Kra::where(['id' => $request->kra_id])
                ->with('kraTemplates')
                ->get();

            return( json_encode($kraData));

        }

        if($request->delete_id!="")
        {
            $message = '';
            $del_id=$request->delete_id;
            $del_info=ShiftException::where('id',$del_id)->delete();

            if($del_info) {
                return response()->json(['status'=>'1', 'msg'=>'Shift deleted successfully']);

            } else {
                return response()->json(['status'=>'0', 'msg'=>'Shift deletion failed']);
            }

        }

        if($request->delete_indicator_id!="")
        {
            $message = '';

            $del_id=$request->delete_indicator_id;

            $del_info=EmployeeKra::where('id',$del_id)->delete();

            if($del_info) {
                return response()->json(['status'=>'1', 'msg'=>'KRA entry deleted successfully']);

            } else {
                return response()->json(['status'=>'0', 'msg'=>'KRA entry deletion failed']);
            }

        }


        if($validator->fails()) {

            return redirect("/employees/edit/$request->employeeId/projectDetailsTab")

                ->withErrors($validator,'profile')

                ->withInput();

        }



        $user_data = User::where(['id'=>$request->employeeId])

            ->with('roles:id,name')

            ->with('locations')

            ->with('permissions:id,name')

            ->with('perks')

            ->with('projects')

            ->with('userManager')

            ->with('leaveAuthorities')

            ->with('designation')

            ->first();



        if(!empty($user_data)){

            $employeeProfile = $user_data->employeeProfile()->first();



            $log = Log::where(['name'=>'User-Updated'])->first();

            $log_data = [

                'log_id' => $log->id,

                'data' => $user_data->toJson()

            ];



            $updated_by = Auth::user();

            $username = $updated_by->employee->fullname;

            $log_data['message'] = $log->name. " by ".$username."(".$updated_by->id.").";

            if(!empty($employeeProfile)){
                $employeeProfile->logDetails()->create($log_data);
            }


        }



        $employee_profile_data = [

            'shift_id'  => $request->shiftTimingId,

            'department_id' => $request->departmentId,

            'state_id' => $request->stateId

        ];



        $user = User::find($request->employeeId);

        $role = Role::find($request->roleId);

        $roles = [];

        $roles[0] = $role->name;

        $user->syncRoles($roles);

        $user->syncPermissions($request->permissionIds);

        $employee = $user->employee()->first();



        $check_unique = EmployeeProfile::where(['user_id'=>$request->employeeId])->first();



        if(empty($check_unique)){

            $employee_profile_data['probation_period_id'] = $request->probationPeriodId;

            $employee_profile_data['probation_approval_status'] = '0';

            $employee_profile_data['probation_hod_approval'] = '0';

            $employee_profile_data['probation_hr_approval'] = '0';



            $probation = ProbationPeriod::find($request->probationPeriodId);

            $employee_profile_data['probation_end_date'] = Carbon::parse($employee->joining_date)->addDays($probation->no_of_days)->toDateString();



            $user->employeeProfile()->create($employee_profile_data);

            $user->userManager()->create(['manager_id'=>$request->employeeIds]);



        }else{

            $user->employeeProfile()->update($employee_profile_data);

            if(is_array($request->exceptionshiftTimingId) && is_array($request->exceptionshiftday)){

                for($i=0;$i<count($request->shiftexcept); $i++){
                    ShiftException::where('id', $request->shiftexcept[$i])
                        ->update([
                            'user_id'=> $request->employeeId,
                            'shift_id'=>$request->exceptionshiftTimingId[$i],
                            'week_day'=> $request->exceptionshiftday[$i]
                        ]);
                }

            }

            if(!empty($request->exceptionshiftTimingId_new) && !empty($request->exceptionshiftday_new)){
                for($j=0;$j<count($request->exceptionshiftTimingId_new); $j++){
                    $Shift_Except = new ShiftException;
                    $Shift_Except->user_id       = $request->employeeId;
                    $Shift_Except->shift_id      = $request->exceptionshiftTimingId_new[$j];
                    $Shift_Except->week_day = $request->exceptionshiftday_new[$j];
                    $Shift_Except->save();

                }
            }

            $user->userManager()->update(['manager_id'=>$request->employeeIds]);

        }



        $manager = User::find($request->employeeIds);

        if(!$manager->hasPermissionTo('approve-leave')){

            $manager->givePermissionTo(['approve-leave']);

        }



        if(!empty($request->hodId)){

            LeaveAuthority::updateOrCreate(['user_id'=>$user->id,'priority'=>'2'],['manager_id'=>$request->hodId]);

            $manager = User::find($request->hodId);

            if(!$manager->hasPermissionTo('approve-leave')){

                $manager->givePermissionTo(['approve-leave']);

            }

        }



        if(!empty($request->hrId)){

            LeaveAuthority::updateOrCreate(['user_id'=>$user->id,'priority'=>'3'],['manager_id'=>$request->hrId]);

            $manager = User::find($request->hrId);

            if(!$manager->hasPermissionTo('approve-leave')){

                $manager->givePermissionTo(['approve-leave']);

            }

        }



        if(!empty($request->mdId)){

            LeaveAuthority::updateOrCreate(['user_id'=>$user->id,'priority'=>'4'],['manager_id'=>$request->mdId]);

            $manager = User::find($request->mdId);

            if(!$manager->hasPermissionTo('approve-leave')){

                $manager->givePermissionTo(['approve-leave']);

            }

        }



        if(!empty($request->perkIds)){

            $user->perks()->sync($request->perkIds);

        }



        if(!empty($request->locationId)){

            $locations = [];

            array_push($locations,$request->locationId);

            $user->locations()->sync($locations);

        }



        $projects = [];

        array_push($projects,$request->projectId);



        if(!empty($request->projectId)){

            $user->projects()->sync($projects);

        }



        if(!empty($request->designation)){

            $designations = [];

            array_push($designations,$request->designation);

            $user->designation()->sync($designations);

        }



        if($request->formSubmitButton == 'sc'){

            return redirect("/employees/edit/$request->employeeId/documentDetailsTab")->with('documentSuccess',"Details updated successfully.");

        }else{

            return redirect("/employees/dashboard");

        }

    }//end of function


    /*
        Save the details of document details tab of create employee form
    */
    function storeDocumentDetails(Request $request)

    {

        $validator = Validator::make($request->all(), [

            'docTypeId' => 'required',

            'docs2' => 'required'

        ]);



        if($validator->fails()) {

            return redirect('/employees/create/documentDetailsTab')

                ->withErrors($validator,'document')

                ->withInput();

        }



        $last_inserted_employee = session('last_inserted_employee');

        $user = User::find($last_inserted_employee);



        if(!empty($request->docs2) && !empty($user)){

            $documents = $request->docs2;

            $document_info = Document::find($request->docTypeId);



            foreach ($documents as $doc) {

                $document = round(microtime(true)).str_random(5).'.'.$doc->getClientOriginalExtension();

                $doc->move(config('constants.uploadPaths.uploadDocument'), $document);



                $document_data['name'] = $document;

                $user->documents()->attach($document_info,$document_data);

            }

        }



        return redirect('employees/create/documentDetailsTab')->with('documentSuccess',"Documents saved successfully.");



    }//end of function


    /*
        Save the details of document details tab of edit employee form
    */
    function editDocumentDetails(Request $request)

    {

        $validator = Validator::make($request->all(), [

            'docTypeId' => 'required',

            'docs2' => 'required'

        ]);



        if ($validator->fails()) {

            return redirect("/employees/edit/$request->employeeId/documentDetailsTab")

                ->withErrors($validator,'document')

                ->withInput();

        }



        $user = User::find($request->employeeId);



        if(!empty($request->docs2) && !empty($user)){

            $documents = $request->docs2;

            $document_info = Document::find($request->docTypeId);



            foreach ($documents as $doc) {

                $document = round(microtime(true)).str_random(5).'.'.$doc->getClientOriginalExtension();

                $doc->move(config('constants.uploadPaths.uploadDocument'), $document);



                $document_data['name'] = $document;

                $user->documents()->attach($document_info,$document_data);

            }

        }



        return redirect("/employees/edit/$request->employeeId/documentDetailsTab")->with('documentSuccess',"Documents saved successfully.");



    }//end of function


    /*
        Save the details of qualification document of create employee form
    */
    function storeQualificationDocumentDetails(Request $request)

    {

        $validator = Validator::make($request->all(), [

            'empQualificationId' => 'required',

            'qualificationDocs' => 'required'

        ]);



        if($validator->fails()) {

            return redirect("/employees/create/documentDetailsTab")

                ->withErrors($validator,'document')

                ->withInput();

        }



        if(!empty($request->qualificationDocs)){

            $where = ["id" => $request->empQualificationId];



            $documents = $request->qualificationDocs;



            foreach ($documents as $doc) {

                $document = round(microtime(true)).str_random(5).'.'.$doc->getClientOriginalExtension();

                $doc->move(config('constants.uploadPaths.uploadQualificationDocument'), $document);



                $document_data['filename'] = $document;



                DB::table('qualification_user')

                    ->where($where)

                    ->update($document_data);

            }

        }



        return redirect("employees/create/documentDetailsTab")->with('documentSuccess',"Documents saved successfully.");



    }//end of function


    /*
        Save the details of qualification document of edit employee form
    */
    function editQualificationDocumentDetails(Request $request)

    {

        $validator = Validator::make($request->all(), [

            'empQualificationId' => 'required',

            'qualificationDocs' => 'required'

        ]);



        if ($validator->fails()) {

            return redirect("/employees/edit/$request->employeeId/documentDetailsTab")

                ->withErrors($validator,'document')

                ->withInput();

        }



        if(!empty($request->qualificationDocs)){

            $where = ["id" => $request->empQualificationId];



            $documents = $request->qualificationDocs;



            foreach ($documents as $doc) {

                $document = round(microtime(true)).str_random(5).'.'.$doc->getClientOriginalExtension();

                $doc->move(config('constants.uploadPaths.uploadQualificationDocument'), $document);



                $document_data['filename'] = $document;



                DB::table('qualification_user')

                    ->where($where)

                    ->update($document_data);

            }

        }



        return redirect("/employees/edit/$request->employeeId/documentDetailsTab")->with('documentSuccess',"Documents saved successfully.");



    }//end of function


    /*
        Save the details of account details tab of create employee form
    */
    function createAccountDetails(Request $request)

    {

        $validator = Validator::make($request->all(), [

            'bankAccNo' => 'required',

            'adhaar' => 'required',

            'panNo' => 'required',

            'accHolderName' => 'required',

            'ifsc' => 'required'

        ]);



        if($validator->fails()) {

            return redirect('/employees/create/accountDetailsTab')

                ->withErrors($validator,'account')

                ->withInput();

        }



        $last_inserted_employee = session('last_inserted_employee');

        $user = User::find($last_inserted_employee);



        $check_unique = $user->employeeAccount()->first();



        if(!empty($check_unique)){

            return redirect('employees/create')->with('profileError',"Details of this employee have already been saved. Please create a new employee.");

        }else{



            $data = [

                'adhaar'  => $request->adhaar,

                'pan_number'        => $request->panNo,

                'uan_number'   => $request->uanNo,

                'account_holder_name'   => $request->accHolderName,

                'bank_account_number'   => $request->bankAccNo,

                'ifsc_code'   => $request->ifsc,

                'pf_number_department'   => $request->pfNoDepartment,

                'bank_id'   => $request->financialInstitutionId,

                'esi_number' => $request->empEsiNo,

                'dispensary' => $request->empDispensary,

                'remarks' => $request->remarks,

                'contract_signed' => $request->contractSigned

            ];

            if(!$request->has('contractSigned')){
                $data['contract_signed'] = '0';
            }

            if($request->contractSigned == '1' && !empty($request->contractSignedDate)){

                $data['contract_signed_date'] = date("Y-m-d",strtotime($request->contractSignedDate));

            }



            if(!empty($request->employmentVerification)){

                $data['employment_verification'] = '1';

            }else{

                $data['employment_verification'] = '0';

            }



            if(!empty($request->addressVerification)){

                $data['address_verification'] = '1';

            }else{

                $data['address_verification'] = '0';

            }



            if(!empty($request->policeVerification)){

                $data['police_verification'] = '1';

            }else{

                $data['police_verification'] = '0';

            }



            $user->employeeAccount()->create($data);



            if($request->formSubmitButton == 'sc'){

                return redirect("employees/create/addressDetailsTab")->with('addressSuccess',"Details saved successfully.");

            }else{

                return redirect("employees/dashboard");

            }



        }

    }//end of function


    /*
        Save the details of account details tab of edit employee form
    */
    function editAccountDetails(Request $request)

    {

        $validator = Validator::make($request->all(), [

            'bankAccNo' => 'required',

            'adhaar' => 'required',

            'panNo' => 'required',

            'accHolderName' => 'required',

            'ifsc' => 'required'

        ]);



        if($validator->fails()) {

            return redirect("/employees/edit/$request->employeeId/accountDetailsTab")

                ->withErrors($validator,'account')

                ->withInput();

        }



        $user_data = EmployeeAccount::where(['user_id'=>$request->employeeId])

            ->with('user')

            ->first();



        if(!empty($user_data)){

            $log = Log::where(['name'=>'User-Updated'])->first();

            $log_data = [

                'log_id' => $log->id,

                'data' => $user_data->toJson()

            ];



            $updated_by = Auth::user();

            $username = $updated_by->employee->fullname;

            $log_data['message'] = $log->name. " by ".$username."(".$updated_by->id.").";

            $user_data->logDetails()->create($log_data);

        }



        $user = User::find($request->employeeId);

        $data = [

            'adhaar'  => $request->adhaar,

            'pan_number'        => $request->panNo,

            'uan_number'   => $request->uanNo,

            'account_holder_name'   => $request->accHolderName,

            'bank_account_number'   => $request->bankAccNo,

            'ifsc_code'   => $request->ifsc,

            'pf_number_department'   => $request->pfNoDepartment,

            'bank_id'   => $request->financialInstitutionId,

            'esi_number' => $request->empEsiNo,

            'dispensary' => $request->empDispensary,

            'remarks' => $request->remarks,

            'contract_signed' => $request->contractSigned

        ];

        if(!$request->has('contractSigned')){
            $data['contract_signed'] = '0';
        }

        if($request->contractSigned == '1' && !empty($request->contractSignedDate)){

            $data['contract_signed_date'] = date("Y-m-d",strtotime($request->contractSignedDate));

        }



        if(!empty($request->employmentVerification)){

            $data['employment_verification'] = '1';

        }else{

            $data['employment_verification'] = '0';

        }



        if(!empty($request->addressVerification)){

            $data['address_verification'] = '1';

        }else{

            $data['address_verification'] = '0';

        }



        if(!empty($request->policeVerification)){

            $data['police_verification'] = '1';

        }else{

            $data['police_verification'] = '0';

        }



        EmployeeAccount::updateOrCreate(['user_id'=>$user->id],$data);



        if($request->formSubmitButton == 'sc'){

            return redirect("/employees/edit/$request->employeeId/addressDetailsTab")->with('addressSuccess',"Details updated successfully.");

        }else{

            return redirect("/employees/dashboard");

        }



    }//end of function


    /*
        Save the details of address details tab of create employee form
    */
    function createAddressDetails(Request $request)

    {

        $validator = Validator::make($request->all(), [

            'perHouseNo' => 'required',

            'perRoadStreet' => 'required',

            'perLocalityArea' => 'required',

            'perPinCode' => 'required',

            'preHouseNo' => 'required',

            'preRoadStreet' => 'required',

            'preLocalityArea' => 'required',

            'prePinCode' => 'required',

            'perCountryId' => 'required',

            'perStateId' => 'required',

            'perCityId' => 'required',

            'preCountryId' => 'required',

            'preStateId' => 'required',

            'preCityId' => 'required'

        ]);



        if($validator->fails()) {

            return redirect('employees/create/addressDetailsTab')

                ->withErrors($validator,'address')

                ->withInput();

        }



        $last_inserted_employee = session('last_inserted_employee');



        $user = User::find($last_inserted_employee);

        $check_unique = $user->employeeAddresses()->first();



        if(!empty($check_unique)){

            return redirect('employees/create')->with('profileError',"Details of this employee have already been saved. Please create a new employee.");

        }else{

            $permanent_data =  [

                'type'  => '2',

                'house_number' => $request->perHouseNo,

                'road_street'   => $request->perRoadStreet,

                'locality_area'   => $request->perLocalityArea,

                'emergency_number'   => $request->perEmergencyNumber,

                'emergency_number_country_id'   => $request->perEmergencyNumberStdId,

                'pincode'   => $request->perPinCode,

                'country_id'   => $request->perCountryId,

                'state_id'   => $request->perStateId,

                'city_id'   => $request->perCityId

            ];



            $present_data =  [

                'type'  => '1',

                'house_number' => $request->preHouseNo,

                'road_street'   => $request->preRoadStreet,

                'locality_area'   => $request->preLocalityArea,

                'emergency_number'   => $request->preEmergencyNumber,

                'emergency_number_country_id'   => $request->preEmergencyNumberStdId,

                'pincode'   => $request->prePinCode,

                'country_id'   => $request->preCountryId,

                'state_id'   => $request->preStateId,

                'city_id'   => $request->preCityId

            ];



            $user->employeeAddresses()->create($present_data);

            $user->employeeAddresses()->create($permanent_data);



            if($request->formSubmitButton == 'sc'){

                return redirect("employees/create/historyDetailsTab")->with('historySuccess',"Details saved successfully.");

            }else{

                return redirect("employees/dashboard");

            }

        }



    }//end of function


    /*
        Save the details of address details tab of edit employee form
    */
    function editAddressDetails(Request $request)

    {

        $validator = Validator::make($request->all(), [

            'perHouseNo' => 'required',

            'perRoadStreet' => 'required',

            'perLocalityArea' => 'required',

            'perPinCode' => 'required',

            'preHouseNo' => 'required',

            'preRoadStreet' => 'required',

            'preLocalityArea' => 'required',

            'prePinCode' => 'required',

            'perCountryId' => 'required',

            'perStateId' => 'required',

            'perCityId' => 'required',

            'preCountryId' => 'required',

            'preStateId' => 'required',

            'preCityId' => 'required'

        ]);



        if($validator->fails()) {

            return redirect("/employees/edit/$request->employeeId/addressDetailsTab")

                ->withErrors($validator,'address')

                ->withInput();

        }



        $user_data = EmployeeAddress::where(['user_id'=>$request->employeeId])

            ->with('user')

            ->get();



        if(!$user_data->isEmpty()){

            $log = Log::where(['name'=>'User-Updated'])->first();

            $log_data = [

                'log_id' => $log->id,

                'data' => $user_data->toJson()

            ];



            $updated_by = Auth::user();

            $username = $updated_by->employee->fullname;

            $log_data['message'] = $log->name. " by ".$username."(".$updated_by->id.").";

            $user_data[0]->logDetails()->create($log_data);

        }



        $user = User::find($request->employeeId);

        $permanent_data =   [

            'type'  => '2',

            'house_number' => $request->perHouseNo,

            'road_street'   => $request->perRoadStreet,

            'locality_area'   => $request->perLocalityArea,

            'emergency_number'   => $request->perEmergencyNumber,

            'emergency_number_country_id'   => $request->perEmergencyNumberStdId,

            'pincode'   => $request->perPinCode,

            'country_id'   => $request->perCountryId,

            'state_id'   => $request->perStateId,

            'city_id'   => $request->perCityId

        ];



        $present_data = [

            'type'  => '1',

            'house_number' => $request->preHouseNo,

            'road_street'   => $request->preRoadStreet,

            'locality_area'   => $request->preLocalityArea,

            'emergency_number'   => $request->preEmergencyNumber,

            'emergency_number_country_id'   => $request->preEmergencyNumberStdId,

            'pincode'   => $request->prePinCode,

            'country_id'   => $request->preCountryId,

            'state_id'   => $request->preStateId,

            'city_id'   => $request->preCityId

        ];



        EmployeeAddress::updateOrCreate(['user_id'=>$user->id,'type'=>'1'],$present_data);

        EmployeeAddress::updateOrCreate(['user_id'=>$user->id,'type'=>'2'],$permanent_data);



        if($request->formSubmitButton == 'sc'){

            return redirect("/employees/edit/$request->employeeId/historyDetailsTab")->with('historySuccess',"Details updated successfully.");

        }else{

            return redirect("/employees/dashboard");

        }



    }//end of function


    /*
        Save the details of history details tab of create employee form
    */
    function storeHistoryDetails(Request $request)

    {

        $validator = Validator::make($request->all(), [

            'orgName' => 'required',

            'orgEmail' => 'required',

            'fromDate' => 'required',

            'toDate' => 'required',

            'reportTo' => 'required',

            'salaryPerMonth' => 'required',

            'responsibilities' => 'required'

        ]);



        if($validator->fails()){

            return redirect('employees/create/historyDetailsTab')

                ->withErrors($validator,'history')

                ->withInput();

        }



        $last_inserted_employee = session('last_inserted_employee');

        $user = User::find($last_inserted_employee);



        $data = [

            'employment_from'  => date("Y-m-d",strtotime($request->fromDate)),

            'employment_to'  => date("Y-m-d",strtotime($request->toDate)),

            'organization_name' => $request->orgName,

            'organization_email' => $request->orgEmail,

            'organization_phone' => $request->orgPhone,

            'country_id' => $request->orgPhoneStdId,

            'organization_phone_stdcode' => $request->orgPhoneStdCode,

            'organization_website' => $request->orgWebsite,

            'responsibilities' => $request->responsibilities,

            'report_to_position' => $request->reportTo,

            'salary_per_month' => $request->salaryPerMonth,

            'perks' => $request->perks,

            'reason_for_leaving' => $request->leavingReason,

        ];



        $user->employmentHistories()->create($data);



        if($request->formSubmitButton == 's'){

            return redirect("employees/create/historyDetailsTab")->with('historySuccess',"Details saved successfully.");

        }else{

            return redirect("employees/dashboard");

        }



    }//end of function


    /*
        Save the details of history details tab of edit employee form
    */
    function editHistoryDetails(Request $request)

    {

        $validator = Validator::make($request->all(), [

            'orgName' => 'required',

            'orgEmail' => 'required',

            'fromDate' => 'required',

            'toDate' => 'required',

            'reportTo' => 'required',

            'salaryPerMonth' => 'required',

            'responsibilities' => 'required'

        ]);



        if($validator->fails()) {

            return redirect("/employees/edit/$request->employeeId/historyDetailsTab")

                ->withErrors($validator,'history')

                ->withInput();

        }



        $user = User::find($request->employeeId);



        $data = [

            'employment_from'  => date("Y-m-d",strtotime($request->fromDate)),

            'employment_to'  => date("Y-m-d",strtotime($request->toDate)),

            'organization_name' => $request->orgName,

            'organization_email' => $request->orgEmail,

            'organization_phone' => $request->orgPhone,

            'country_id' => $request->orgPhoneStdId,

            'organization_phone_stdcode' => $request->orgPhoneStdCode,

            'organization_website' => $request->orgWebsite,

            'responsibilities' => $request->responsibilities,

            'report_to_position' => $request->reportTo,

            'salary_per_month' => $request->salaryPerMonth,

            'perks' => $request->perks,

            'reason_for_leaving' => $request->leavingReason,

        ];



        $user->employmentHistories()->create($data);



        if($request->formSubmitButton == 's'){

            return redirect("/employees/edit/$request->employeeId/historyDetailsTab")->with('historySuccess',"Details updated successfully.");

        }else{

            return redirect("/employees/dashboard");

        }



    }//end of function


    /*
        Save the details of reference details tab of create employee form
    */
    function createReferenceDetails(Request $request)

    {

        $validator = Validator::make($request->all(), [

            'ref1Name' => 'required',

            'ref1Phone' => 'required',

            'ref1Email' => 'required',

            'ref1Address' => 'required',

            'ref2Name' => 'required',

            'ref2Phone' => 'required',

            'ref2Email' => 'required',

            'ref2Address' => 'required'

        ]);



        if($validator->fails()){

            return redirect('/employees/create/referenceDetailsTab')

                ->withErrors($validator,'reference')

                ->withInput();

        }



        $last_inserted_employee = session('last_inserted_employee');

        $user = User::find($last_inserted_employee);

        $check_unique = $user->employeeReferences()->first();



        if(!empty($check_unique)){

            return redirect('employees/create')->with('profileError',"Details of this employee have already been saved. Please create a new employee.");

        }else{



            $data1 = [

                'type' => '1',

                'name'  => $request->ref1Name,

                'phone'  => $request->ref1Phone,

                'country_id'  => $request->ref1PhoneStdId,

                'email' => $request->ref1Email,

                'address' => $request->ref1Address,

            ];



            $data2 = [

                'type' => '2',

                'name'  => $request->ref2Name,

                'phone'  => $request->ref2Phone,

                'country_id'  => $request->ref2PhoneStdId,

                'email' => $request->ref2Email,

                'address' => $request->ref2Address,

            ];



            $user->employeeReferences()->create($data1);

            $user->employeeReferences()->create($data2);



            if($request->formSubmitButton == 'sc'){

                return redirect("employees/create/securityDetailsTab")->with('securitySuccess',"Details saved successfully.");

            }else{

                return redirect("employees/dashboard");

            }

        }

    }//end of function


    /*
        Save the details of reference details tab of edit employee form
    */
    function editReferenceDetails(Request $request)

    {

        $validator = Validator::make($request->all(), [

            'ref1Name' => 'required',

            'ref1Phone' => 'required',

            'ref1Email' => 'required',

            'ref1Address' => 'required',

            'ref2Name' => 'required',

            'ref2Phone' => 'required',

            'ref2Email' => 'required',

            'ref2Address' => 'required'

        ]);



        if ($validator->fails()) {

            return redirect("/employees/edit/$request->employeeId/referenceDetailsTab")

                ->withErrors($validator,'reference')

                ->withInput();

        }



        $user_data = EmployeeReference::where(['user_id'=>$request->employeeId])

            ->with('user')

            ->get();



        if(!$user_data->isEmpty()){

            $log = Log::where(['name'=>'User-Updated'])->first();

            $log_data = [

                'log_id' => $log->id,

                'data' => $user_data->toJson()

            ];



            $updated_by = Auth::user();

            $username = $updated_by->employee->fullname;

            $log_data['message'] = $log->name. " by ".$username."(".$updated_by->id.").";

            $user_data[0]->logDetails()->create($log_data);

        }



        $user = User::find($request->employeeId);

        $data1 = [

            'type' => '1',

            'name'  => $request->ref1Name,

            'phone'  => $request->ref1Phone,

            'country_id'  => $request->ref1PhoneStdId,

            'email' => $request->ref1Email,

            'address' => $request->ref1Address,

        ];



        $data2 = [

            'type' => '2',

            'name'  => $request->ref2Name,

            'phone'  => $request->ref2Phone,

            'country_id'  => $request->ref2PhoneStdId,

            'email' => $request->ref2Email,

            'address' => $request->ref2Address,

        ];



        EmployeeReference::updateOrCreate(['user_id'=>$user->id,'type'=>'1'],$data1);

        EmployeeReference::updateOrCreate(['user_id'=>$user->id,'type'=>'2'],$data2);



        if($request->formSubmitButton == 'sc'){

            return redirect("/employees/edit/$request->employeeId/securityDetailsTab")->with('securitySuccess',"Details updated successfully.");

        }else{

            return redirect("/employees/dashboard");

        }



    }//end of function


    /*
        Save the details of security details tab of create employee form
    */
    function createSecurityDetails(Request $request)

    {

        $validator = Validator::make($request->all(), [

            'bankName' => 'bail|required',

            'ddNo' => 'bail|required',

            'accNo' => 'bail|required',

            'receiptNo' => 'bail|required',

            'amount' => 'bail|required'

        ]);



        if($validator->fails()) {

            return redirect('/employees/create/securityDetailsTab')

                ->withErrors($validator,'security')

                ->withInput();

        }



        $last_inserted_employee = session('last_inserted_employee');

        $user = User::find($last_inserted_employee);

        $check_unique = $user->employeeSecurity()->first();



        if(!empty($check_unique)){

            return redirect('employees/create')->with('profileError',"Details of this employee have already been saved. Please create a new employee.");

        }else{

            $data = [

                'dd_number' => $request->ddNo,

                'account_number'  => $request->accNo,

                'bank_name'  => $request->bankName,

                'receipt_number' => $request->receiptNo,

                'dd_date' => date("Y-m-d",strtotime($request->ddDate)),

                'amount' => $request->amount,

            ];



            $user->employeeSecurity()->create($data);



            return redirect('employees/create/securityDetailsTab')->with('securitySuccess',"Details saved successfully.");

        }

    }//end of function


    /*
        Save the details of security details tab of edit employee form
    */
    function editSecurityDetails(Request $request)

    {

        $validator = Validator::make($request->all(), [

            'bankName' => 'bail|required',

            'ddNo' => 'bail|required',

            'accNo' => 'bail|required',

            'receiptNo' => 'bail|required',

            'amount' => 'bail|required'

        ]);



        if($validator->fails()) {

            return redirect("/employees/edit/$request->employeeId/securityDetailsTab")

                ->withErrors($validator,'security')

                ->withInput();

        }



        $user_data = EmployeeSecurity::where(['user_id'=>$request->employeeId])

            ->with('user')

            ->first();



        if(!empty($user_data)){

            $log = Log::where(['name'=>'User-Updated'])->first();

            $log_data = [

                'log_id' => $log->id,

                'data' => $user_data->toJson()

            ];



            $updated_by = Auth::user();

            $username = $updated_by->employee->fullname;

            $log_data['message'] = $log->name. " by ".$username."(".$updated_by->id.").";

            $user_data->logDetails()->create($log_data);

        }



        $user = User::find($request->employeeId);

        $data = [

            'dd_number' => $request->ddNo,

            'account_number'  => $request->accNo,

            'bank_name'  => $request->bankName,

            'receipt_number' => $request->receiptNo,

            'dd_date' => date("Y-m-d",strtotime($request->ddDate)),

            'amount' => $request->amount,

        ];



        EmployeeSecurity::updateOrCreate(['user_id'=>$user->id],$data);



        return redirect("/employees/edit/$request->employeeId/securityDetailsTab")->with('securitySuccess',"Details updated successfully.");



    }//end of function

    function createSalaryStructure(Request $request){

        $last_inserted_employee = session('last_inserted_employee');

        $user = User::find($last_inserted_employee);

        $check_unique = $user->employeeSecurity()->first();



        if(!empty($check_unique)){
            return redirect('employees/create')->with('profileError',"Details of this employee have already been saved. Please create a new employee.");
        }else {
            $earningHeads = $request->earning_heads;
            $earningHeadValues = $request->earning_heads_val;

            $deductionHeads = $request->deduction_heads;
            $deductionHeadValues = $request->deduction_heads_val;


            if($request->restrict_employee_share != ''){
                $restrictEmployeeShare = $request->restrict_employee_share;
            }else{
                $restrictEmployeeShare = 0;
            }

            if($request->restrict_employer_share != ''){
                $restrictEmployerShare = $request->restrict_employer_share;
            }else{
                $restrictEmployerShare = 0;
            }

            for($i=0; $i < count($earningHeads); $i++) {
                if(isset($earningHeadValues[$i])){
                    $value = $earningHeadValues[$i];
                }
                else{
                    $value = 0;
                }
                DB::table('employee_salary_structures')->insert([
                    'user_id' => $user->id,
                    'salary_cycle_id' => $request->salary_cycle,
                    'salary_head_id' => $earningHeads[$i],
                    'value' => $value,
                    'calculation_type' => 'earning',
                    'restrict_employee_share' => $request->restrict_employee_share,
                    'restrict_employer_share' => $request->restrict_employer_share
                ]);
            }


            for($i=0; $i < count($deductionHeads); $i++) {
                if(isset($deductionHeadValues[$i])){
                    $value = $deductionHeadValues[$i];
                }
                else{
                    $value = 0;
                }
                DB::table('employee_salary_structures')->insert([
                    'user_id' => $user->id,
                    'salary_cycle_id' => $request->salary_cycle,
                    'salary_head_id' => $deductionHeads[$i],
                    'value' => $value,
                    'calculation_type' => 'deduction',
                    'restrict_employee_share' => $request->restrict_employee_share,
                    'restrict_employer_share' => $request->restrict_employer_share,
                    'lwf_applied' => $request->lwf_applied
                ]);
            }
            return redirect('employees/create/salaryStructureTab')->with('success',"Salary Structure Saved successfully.");
        }
    }


    function updateSalaryStructure(Request $request){
        $user = User::find($request->employeeId);
//        $heads = $request->heads;
//        $headValues = $request->heads_val;

//        for($i=0; $i < count($heads); $i++) {
//            DB::table('employee_salary_structures')->where('user_id', $user->id)->where('salary_head_id', $heads[$i])->update([
//                'value' => $headValues[$i],
//                'restrict_employee_share' => $request->restrict_employee_share,
//                'restrict_employer_share' => $request->restrict_employer_share,
//                'lwf_applied' => $request->lwf_applied
//            ]);
//        }

         $earningHeads = $request->earning_heads;
          $earningHeadValues = $request->earning_heads_val;

        $deductionHeads = $request->deduction_heads;
        $deductionHeadValues = $request->deduction_heads_val;

        for($i=0; $i < count($earningHeads); $i++) {
            if(isset($earningHeadValues[$i])){
                $value = $earningHeadValues[$i];
            }
            else{
                $value = 0;
            }
            if(DB::table('employee_salary_structures')->select('id')->where('user_id', $user->id)->where('salary_head_id', $earningHeads[$i])->exists()){

                DB::table('employee_salary_structures')->where('user_id', $user->id)->where('salary_head_id', $earningHeads[$i])->update([
                    'value' => $value,
                    'restrict_pf' => $request->restrict_pf,
                    'pt_rate_applied' => $request->pt_rate_applied,
                    'lwf_applied' => $request->lwf_applied
                ]);
            }else{
                DB::table('employee_salary_structures')->insert([
                    'user_id' => $user->id,
                    'salary_cycle_id' => $request->salary_cycle,
                    'salary_head_id' => $earningHeads[$i],
                    'value' => $value,
                    'calculation_type' => 'earning',
                    'restrict_pf' => $request->restrict_pf,
                    'pt_rate_applied' => $request->pt_rate_applied,
                    'lwf_applied' => $request->lwf_applied
                ]);
            }
        }


        for($i=0; $i < count($deductionHeads); $i++) {
            if(isset($deductionHeadValues[$i])){
                $value = $deductionHeadValues[$i];
            }
            else{
                $value = 0;
            }
            if(DB::table('employee_salary_structures')->where('user_id', $user->id)->where('salary_head_id', $deductionHeads[$i])->exists()) {
                DB::table('employee_salary_structures')->where('user_id', $user->id)->where('salary_head_id', $deductionHeads[$i])->update([
                    'value' => $value,
                    'restrict_pf' => $request->restrict_pf,
                    'pt_rate_applied' => $request->pt_rate_applied,
                    'lwf_applied' => $request->lwf_applied
                ]);
            }else{
                DB::table('employee_salary_structures')->insert([
                    'user_id' => $user->id,
                    'salary_cycle_id' => $request->salary_cycle,
                    'salary_head_id' => $deductionHeads[$i],
                    'value' => $value,
                    'calculation_type' => 'deduction',
                    'restrict_pf' => $request->restrict_pf,
                    'pt_rate_applied' => $request->pt_rate_applied,
                    'lwf_applied' => $request->lwf_applied
                ]);
            }
        }

        return redirect("/employees/edit/$request->employeeId/salaryStructureTab")->with('success',"Salary Structure Saved successfully.");

    }


    /*
        Ajax request to get departments wise employees
    */
    function departmentsWiseEmployees(Request $request)
    {
        $department_ids = $request->department_ids;

        $data = DB::table('employees as e')

            ->join('employee_profiles as ep','e.user_id','=','ep.user_id')

            ->join('users as u','e.user_id','=','u.id')

            ->whereIn('ep.department_id',$department_ids)

            ->where(['e.approval_status'=>'1','e.isactive'=>1,'ep.isactive'=>1])

            ->select('e.user_id','e.fullname','u.employee_code')

            ->get();



        return $data;



    }//end of function


    /*
        Ajax request to get states wise cities
    */
    function statesWiseCities(Request $request)

    {

        $state_ids = $request->stateIds;



        $cities = City::where(['isactive'=>1])

            ->whereIn('state_id',$state_ids)

            ->select('id','name')

            ->get();



        return $cities;



    }//end of function


    /*
        Ajax request to get a specific project's information
    */
    function projectInformation(Request $request)
    {

        $data['project'] = Project::where(['id'=>$request->project_id,'isactive'=>1,'approval_status'=>'1'])->with('salaryStructure:id,name')

            ->with('salaryCycle:id,name')

            ->with('company:id,name,pf_account_number,tan_number')

            ->first();



        $state_ids = $data['project']->states()->pluck('state_id')->toArray();

        $states = State::whereIn('id',$state_ids)->pluck('name')->toArray();

        $data['states'] = implode(",",$states);



        $location_ids = $data['project']->locations()->pluck('location_id')->toArray();

        $locations = Location::whereIn('id',$location_ids)->pluck('name')->toArray();

        $data['locations'] = implode(",",$locations);



        return $data;

    }//end of function


    /*
        Ajax request to check whether the sent parameters are unique for an employee
    */
    function checkUniqueEmployee(Request $request)

    {

        $result = [

            'referralMatch' => "no",

            'emailUnique'   => "yes",

            'mobileUnique'  => "yes",

            'employeeXeamCodeUnique' => "yes",

            'oldXeamCodeUnique' => "yes"

        ];



        if(!empty($request->referralCode)){

            $employee = Employee::where(['referral_code' => $request->referralCode])->first();



            if(!empty($employee)){

                $result['referralMatch'] = "yes";

            }

        }else{

            $result['referralMatch'] = "blank";

        }



        if(!empty($request->email)){

            $employee = User::where(['email' => $request->email])->first();



            if(!empty($employee)){

                $result['emailUnique'] = "no";

            }

        }else{

            $result['emailUnique'] = "blank";

        }



        if(!empty($request->employeeXeamCode)){

            $employee = User::where(['employee_code' => $request->employeeXeamCode])->first();



            if(!empty($employee)){

                $result['employeeXeamCodeUnique'] = "no";

            }

        }else{

            $result['employeeXeamCodeUnique'] = "blank";

        }



        if(!empty($request->oldXeamCode)){

            $employee = Employee::where(['employee_id' => $request->oldXeamCode])->first();



            if(!empty($employee)){

                $result['oldXeamCodeUnique'] = "no";

            }

        }else{

            $result['oldXeamCodeUnique'] = "blank";

        }



        if(!empty($request->mobile)){

            $employee = Employee::where(['mobile_number' => $request->mobile])->first();



            if(!empty($employee)){

                $result['mobileUnique'] = "no";

            }

        }else{

            $result['mobileUnique'] = "blank";

        }



        return $result;



    }//end of function


    /*
        Get relevant information to show on my profile page
    */
    function myProfile()

    {

        $user = User::where(['id'=>Auth::id()])

            ->with('employee')

            ->with('employeeProfile')

            ->with('roles:id,name')

            ->with('languages')

            ->with('skills')

            ->with('qualifications')

            ->with('permissions:id,name')

            ->with('perks')

            ->with('projects')

            ->with('userManager.manager.employee:id,user_id,fullname')

            ->with('employeeAddresses')

            ->with('employeeAccount')

            ->with('employeeReferences')

            ->first();



        if(!$user->EmployeeKra->isEmpty()){

            $kra_template_id = $user->EmployeeKra[0]->kra_id;

            $kra_template = Kra::where(['id'=>$kra_template_id])
                ->first();
        }else{
            $kra_template="";
        }


        $leave_authorities = $user->leaveAuthorities()

            ->where(['isactive'=>1])

            ->with('manager.employee:id,user_id,fullname')

            ->orderBy('priority')

            ->get();



        $documents = DB::table('documents as d')

            ->where(['d.document_category_id'=>1,'d.isactive'=>1])

            ->select('d.id','d.name as document_name')

            ->get();



        foreach ($documents as $key => $value) {

            $value->name = DB::table('document_user')

                ->where(['document_id'=>$value->id,'user_id'=>$user->id])

                ->value('name');

        }






        return view('employees.my_profile')->with(['user'=>$user,'leave_authorities'=>$leave_authorities,'documents'=>$documents, 'emp_kra_template'=>$kra_template]);




    }//end of function


    /*
        Get relevant information to show on other user's profile page
    */
    function otherUserProfile($user_id){

        $user = User::where(['id'=>$user_id])
            ->with('employee')
            ->with('employeeProfile')
            ->with('roles:id,name')
            ->with('languages')
            ->with('skills')
            ->with('qualifications')
            ->with('permissions:id,name')
            ->with('perks')
            ->with('projects')
            ->with('userManager.manager.employee:id,user_id,fullname')
            ->with('employeeAddresses')
            ->with('employeeAccount')
            ->with('employeeReferences')
            ->with('printDocument')
            ->first();



        if(!$user->EmployeeKra->isEmpty()){

            $kra_template_id = $user->EmployeeKra[0]->kra_id;

            $kra_template = Kra::where(['id'=>$kra_template_id])
                ->first();
        }else{
            $kra_template="";
        }


        $leave_authorities = $user->leaveAuthorities()
            ->where(['isactive'=>1])
            ->with('manager.employee:id,user_id,fullname')
            ->orderBy('priority')
            ->get();

        $documents = DB::table('documents as d')
            ->where(['d.document_category_id'=>1,'d.isactive'=>1])
            ->select('d.id','d.name as document_name')
            ->get();

        foreach($documents as $key => $value) {
            $value->name = DB::table('document_user')
                ->where(['document_id'=>$value->id,'user_id'=>$user->id])
                ->value('name');
        }

        session()->put('employeeId',$user_id);
        return view('employees.other_user_profile')->with(['user'=>$user,'leave_authorities'=>$leave_authorities,'documents'=>$documents, 'emp_kra_template'=>$kra_template]);

    }//end of function


    /*
        Upload your profile picture
    */
    function saveProfilePicture(Request $request)

    {

        if ($request->hasFile('profilePic')) {

            $profile_pic = time().'.'.$request->file('profilePic')->getClientOriginalExtension();

            $request->file('profilePic')->move(config('constants.uploadPaths.uploadPic'), $profile_pic);



            $user = Auth::user();

            $user->employee()->update(['profile_picture'=>$profile_pic]);



        }



        return redirect("employees/my-profile");



    }//end of function


    /*
        Get the change password form after login
    */
    function changePassword()

    {

        return view('employees.change_password_form');

    }//end of function


    /*
        Change your password after login
    */
    function saveNewPassword(Request $request)

    {

        $request->validate([

            'oldPassword' => 'bail|required|max:20|min:6',

            'newPassword'  => 'bail|required|max:20|min:6',

            'confirmPassword'  => 'bail|required|max:20|min:6|same:newPassword'

        ]);



        $user = Auth::user();

        $old_password = $user->password;



        if(Hash::check("$request->oldPassword", $old_password)) {

            $user->password = Hash::make($request->newPassword);

            $user->save();



            return redirect()->back()->with(['password_success'=>"Your password has been changed successfully."]);

        }else{

            return redirect()->back()->with(['password_error'=>"Please enter your old password correctly."]);

        }



    }//end of function


    /*
        List of employees whose probation has been approved or is pending from HR/HOD
    */
    function probationApprovals()

    {

        $probation_periods = ProbationPeriod::where(['isactive'=>1])->get();

        $user = User::where(['id'=>Auth::id()])

            ->whereHas('employeeProfile')

            ->with('employeeProfile')

            ->first();



        if(!empty($user)){

            $user_id = $user->id;

        }else{

            $user_id = 0;

        }



        $leave_authorities = LeaveAuthority::where(['manager_id'=>$user_id])

            ->whereIn('priority',['2','3'])

            ->select('user_id','manager_id','priority')

            ->get();



        if(!$leave_authorities->isEmpty()){



            foreach ($leave_authorities as $key => $value) {

                $value->list = EmployeeProfile::where(['probation_approval_status'=>'0'])

                    ->where('user_id',$value->user_id)

                    ->with('probationPeriod')

                    ->with('user.employee')

                    ->get();



                if(!$value->list->isEmpty()){

                    foreach ($value->list as $key2 => $value2) {

                        $end_date = Carbon::parse($value2->user->employee->joining_date)->addDays($value2->probationPeriod->no_of_days)->toDateString();



                        if(strtotime(date("Y-m-d")) >= strtotime($end_date)){

                            $update_data =  [

                                'probation_hod_approval' => '1',

                                'probation_hr_approval' => '1',

                                'probation_approval_status' => '1',

                                'probation_end_date' => date("Y-m-d",strtotime($end_date))

                            ];



                            $value2->update($update_data);

                            unset($value->list[$key2]);

                        }



                    }

                }

            }

        }



        return view('employees.list_probation_approvals')->with(['probation_periods'=>$probation_periods,'leave_authorities'=>$leave_authorities]);



    }//end of function


    /*
        Approve/Disapprove the probation of a specific employee
    */
    function probationApproval($action,$user_id,$priority)

    {

        if($action == 'approve'){

            if($priority == '2'){

                $data['probation_hod_approval'] = '1';

            }else{

                $data['probation_hr_approval'] = '1';

            }

        }elseif($action == 'disapprove') {
            if($priority == '2'){
                $data['probation_hod_approval'] = '0';
            }else{
                $data['probation_hr_approval'] = '0';
            }
        }
        $user = User::find($user_id);
        $user->employeeProfile()->update($data);
        $profile = $user->employeeProfile;
        if($profile->probation_hod_approval == '1' && $profile->probation_hr_approval == '1'){
            $profile->update(['probation_approval_status'=>'1']);
        }else{
            $profile->update(['probation_approval_status'=>'0']);
        }
        return redirect("employees/probation-approvals");
    }//end of function


    /*
        Change the probation period of a specific employee
    */
    function changeProbationPeriod(Request $request){

        $user = User::find($request->userId);
        $probation_period = ProbationPeriod::find($request->probationPeriodId);
        $end_date = Carbon::parse($user->employee->joining_date)->addDays($probation_period->no_of_days)->toDateString();
        $prev_probation_end_date_time = strtotime($user->employeeProfile->probation_end_date);
        $end_date_time = strtotime($end_date);
        $profile_data['probation_period_id'] = $request->probationPeriodId;
        if($end_date_time > $prev_probation_end_date_time){
            $profile_data['probation_extended_date'] = $end_date;
            $profile_data['probation_reduced_date'] = null;
            $message = "Your probation period has been extended till ".date("d/m/Y",strtotime($end_date));

        }elseif($end_date_time < $prev_probation_end_date_time){
            $profile_data['probation_reduced_date'] = $end_date;
            $profile_data['probation_extended_date'] = null;
            $message = "Your probation period has been reduced till ".date("d/m/Y",strtotime($end_date));
        }else{
            $profile_data['probation_reduced_date'] = null;
            $profile_data['probation_extended_date'] = null;
            $message = "";
        }

        $user->employeeProfile()->update($profile_data);
        if(!empty($message)){
            $mail_data['to_email'] = $user->email;
            $mail_data['fullname'] = $user->employee->fullname;
            $mail_data['subject'] = "Probation Period Changed";
            $mail_data['message'] = $message;
            $this->sendGeneralMail($mail_data);
        }
        return redirect("employees/probation-approvals");
    }//end of function


    function sendGeneralMail($mail_data)
    {   //mail_data Keys => to_email, subject, fullname, message

        if(!empty($mail_data['to_email'])){
            Mail::to($mail_data['to_email'])->send(new GeneralMail($mail_data));
        }
        return true;
    }//end of function

    /*
        Get all messages received by an employee
    */
    function allMessages(){

        $user_id = Auth::id();
        $messages = Message::where(['isactive'=>1,'receiver_id'=>$user_id])
            ->with(['sender.employee:id,user_id,fullname'])
            ->orderBy('created_at','DESC')
            ->paginate(15);
        return view('employees.all_messages')->with(['messages'=>$messages]);

    }//end of function


    /*
        Get all notifications received by an employee
    */
    function allNotifications(){

        $user_id = Auth::id();
        $notifications = Notification::where(['isactive'=>1,'receiver_id'=>$user_id])
            ->with(['sender.employee:id,user_id,fullname'])
            ->orderBy('created_at','DESC')
            ->paginate(15);
        return view('employees.all_notifications')->with(['notifications'=>$notifications]);

    }//end of function

    /*
        Ajax request to mark the messages as read
    */
    function unreadMessages(Request $request){

        $message_ids = $request->message_ids;
        Message::whereIn('id',$message_ids)->update(['read_status'=>'1']);
        $result['status'] = true;
        return $result;

    }//end of function

    /*
        Ajax request to mark the notifications as read
    */
    function unreadNotifications(Request $request){

        $notification_ids = $request->notification_ids;
        Notification::whereIn('id',$notification_ids)->update(['read_status'=>'1']);
        $result['status'] = true;
        return $result;

    }//end of function


    // new print-offer-letter
    function printOfferLetter(Request $request){

        $data = [
            'offer_letter'  => $request->count+1,
            'user_id'       => $request->employeeId,
        ];
        PrintDocument::updateOrCreate(['user_id'=>$request->employeeId],$data);
    }


    function viewOfferLetter(){

        $employeeId = session('employeeId');
        $user = User::where(['id'=>$employeeId])
            ->with('employee')
            ->with('employeeProfile')
            ->with('employeeAddresses')
            ->with('roles:id,name')
            ->with('printDocument')
            ->first();
        return view('employees.offer_letter')->with(['user'=>$user]);
    }

    function getMissedPunchToday(Request $request){

        $todays_date = date("Y-m-d");
        $data['attendances_info'] = DB::table("employees")->select('id', 'user_id', 'fullname', 'mobile_number')->whereNotIn('user_id',function($query)  {
            $query->select('user_id')->where('on_date', date("Y-m-d"))->from('attendances');

        })
            ->where('isactive', 1)
            ->get();
        $employee_arr=[];

        foreach($data['attendances_info'] as $attendance_info){

            $dep = EmployeeProfile::where(['user_id' => $attendance_info->user_id])
                ->with('department')
                ->first();

            $designation = User::where(['id' => $attendance_info->user_id])
                ->with('designation')
                ->first();

            $employee_arr[]=[

                "attendance_info"=>$attendance_info,
                "dep"=>$dep,
                "designation" =>$designation
            ];

        }

        return view('employees.missed_punch')->with(['data'=>$employee_arr, 'punch_date'=>$todays_date]);

    }

    function getMissedPunchData(Request $request){

        $punch_date = $request->miss_punch_date;

        $data['attendances_info'] = DB::table("employees")->select('id', 'user_id', 'fullname', 'mobile_number')->whereNotIn('user_id',function($query) use($punch_date) {
            $query->select('user_id')->where('on_date', $punch_date)->from('attendances');
        })

            ->where('isactive', 1)
            ->get();

        $employee_arr=[];
        foreach($data['attendances_info'] as $attendance_info){

            $dep = EmployeeProfile::where(['user_id' => $attendance_info->user_id])
                ->with('department')
                ->first();

            $designation = User::where(['id' => $attendance_info->user_id])
                ->with('designation')
                ->first();

            $employee_arr[]=[

                "attendance_info"=>$attendance_info,
                "dep"=>$dep,
                "designation" =>$designation
            ];

        }

        return view('employees.missed_punch')->with(['data'=>$employee_arr, 'punch_date'=>$punch_date]);

    }

    function createEmployeeKraDetails(Request $request){

        $validator = Validator::make($request->all(), [
            'kra_name' => 'bail|required',

        ]);

        if($validator->fails()) {
            return redirect('/employees/create/kraTab')
                ->withErrors($validator,'kradetails')
                ->withInput();
        }

        $last_inserted_employee = session('last_inserted_employee');
        if($last_inserted_employee==""){
            return redirect("employees/create/kraDetailsTab")->with('kraSaved',"cant create employee KRA, create basic details first");
        }
        if($request->kra_name_id!=""){

            foreach($request->kra_name_id as $id){
                //$rem_data_array = $request->rem_data[$id];
                if(isset($request->rem_data[$id]) AND ($request->rem_data[$id]!="")){
                    $reminder_status = $request->rem_data[$id]['reminder'][0];
                    if($reminder_status == "on"){
                        $reminder_status = 1;
                        $time_period = $request->rem_data[$id]['time_period'][0];
                        if(isset($request->rem_data[$id]['reminder_notification']) AND ($request->rem_data[$id]['reminder_notification']!="")){

                            $reminder_notification = $request->rem_data[$id]['reminder_notification'][0];
                            if($reminder_notification=="on"){
                                $reminder_notification = 1;
                            }

                        }else{

                            $reminder_notification = 0;
                        }

                        if(isset($request->rem_data[$id]['reminder_mail']) AND ($request->rem_data[$id]['reminder_mail']!="")){

                            $reminder_mail = $request->rem_data[$id]['reminder_mail'][0];
                            $reminder_mail = 1;

                        }else{

                            $reminder_mail = 0;
                        }

                    }else{

                        $time_period = 0;
                        $reminder_notification = 0;
                        $reminder_mail =0;
                    }
                }else{
                    $reminder_status =0;
                    $time_period = 0;
                    $reminder_notification = 0;
                    $reminder_mail =0;
                }
                $get_kra_from_id = Kratemplate::where(['id' => $id])->first();
                $kra_data = [
                    'user_id' => $last_inserted_employee,
                    'name' => $get_kra_from_id->name,
                    'kra_id' => $get_kra_from_id->kra_id,
                    'frequency' => $get_kra_from_id->frequency,
                    'activation_date' => $get_kra_from_id->activation_date,
                    'deadline_date' => $get_kra_from_id->deadline_date,
                    'priority' => $get_kra_from_id->priority,
                    'reminder_status' => $reminder_status,
                    'reminder_days' => $time_period,
                    'reminder_notification' => $reminder_notification,
                    'reminder_email' => $reminder_mail
                ];
                $kra_info = EmployeeKra::create($kra_data);
            }

        }
        if(!empty($request->added_name) && !empty($request->added_frequency) && !empty($request->added_activation_date) && !empty($request->added_deadline) && !empty($request->added_priority)){

            for($j=0;$j<count($request->added_name); $j++)
            {
                if($request->reminder_check[$j]==""){
                    $reminder_check = 0;
                }else{
                    $reminder_check = $request->reminder_check[$j];
                    if($reminder_check=="on"){
                        $reminder_check=1;
                    }
                }
                if($request->reminderTime[$j]==""){
                    $reminderTime = 0;
                }else{
                    $reminderTime = $request->reminderTime[$j];
                    if($reminderTime=="on"){
                        $reminderTime=1;
                    }
                }
                if($request->reminderNotification[$j]==""){
                    $reminderNotification = 0;
                }else{
                    $reminderNotification = $request->reminderNotification[$j];
                    if($reminderNotification=="on"){
                        $reminderNotification=1;
                    }
                }
                if($request->reminderMail[$j]==""){
                    $reminderMail = 0;
                }else{
                    $reminderMail = $request->reminderMail[$j];
                    if($reminderMail=="on"){
                        $reminderMail=1;
                    }
                }

                $emp_kra = new EmployeeKra;
                $emp_kra->user_id   = $last_inserted_employee;
                $emp_kra->name  = $request->added_name[$j];
                $emp_kra->kra_id = $request->kra_name;
                $emp_kra->frequency = $request->added_frequency[$j];
                $emp_kra->activation_date = $request->added_activation_date[$j];
                $emp_kra->deadline_date = $request->added_deadline[$j];
                $emp_kra->priority = $request->added_priority[$j];
                $emp_kra->reminder_status = $reminder_check;
                $emp_kra->reminder_days = $reminderTime;
                $emp_kra->reminder_notification = $reminderNotification;
                $emp_kra->reminder_email = $reminderMail;
                $emp_kra->save();

            }
        }



        return redirect("employees/create/projectDetailsTab")->with('kraSaved',"Details saved successfully.");


    }

    function editEmployeeKraDetails(Request $request, $user_id = null){

        if($request->kra_name_id!="")
        {
            foreach($request->kra_name_id as $id)
            {
                if(isset($request->rem_data[$id]) AND ($request->rem_data[$id]!="")){
                    $reminder_status = $request->rem_data[$id]['reminder'][0];
                    if($reminder_status == "on"){
                        $reminder_status = 1;
                        if(isset($request->rem_data[$id]['time_period']) AND ($request->rem_data[$id]['time_period']!="")){
                            $time_period = $request->rem_data[$id]['time_period'][0];
                        }else{
                            $time_period ="";
                        }

                        if(isset($request->rem_data[$id]['reminder_notification']) AND ($request->rem_data[$id]['reminder_notification']!="")){

                            $reminder_notification = $request->rem_data[$id]['reminder_notification'][0];
                            if($reminder_notification=="on"){
                                $reminder_notification = 1;
                            }

                        }else{

                            $reminder_notification = 0;
                        }

                        if(isset($request->rem_data[$id]['reminder_mail']) AND ($request->rem_data[$id]['reminder_mail']!="")){

                            $reminder_mail = $request->rem_data[$id]['reminder_mail'][0];
                            $reminder_mail = 1;

                        }else{

                            $reminder_mail = 0;
                        }

                    }else{

                        $time_period = 0;
                        $reminder_notification = 0;
                        $reminder_mail =0;
                    }
                }else{

                    $reminder_status =0;
                    $time_period = 0;
                    $reminder_notification = 0;
                    $reminder_mail =0;
                }
                $get_kra_from_id = Kratemplate::where(['id' => $id])->first();
                $kra_data = [
                    'user_id' => $user_id,
                    'name' => $get_kra_from_id->name,
                    'kra_id' => $get_kra_from_id->kra_id,
                    'frequency' => $get_kra_from_id->frequency,
                    'activation_date' => $get_kra_from_id->activation_date,
                    'deadline_date' => $get_kra_from_id->deadline_date,
                    'priority' => $get_kra_from_id->priority,
                    'reminder_status' => $reminder_status,
                    'reminder_days' => $time_period,
                    'reminder_notification' => $reminder_notification,
                    'reminder_email' => $reminder_mail
                ];
                $kra_info = EmployeeKra::create($kra_data);
            }

        }

        if(is_array($request->emp_kra_id) && is_array($request->name))
        {
            for($i=0;$i<count($request->emp_kra_id); $i++)
            {
                $id = $request->emp_kra_id[$i];
                if(isset($request->rem_data[$id]) AND ($request->rem_data[$id]!="")){
                    $reminder_status = $request->rem_data[$id]['reminder'][0];
                    if($reminder_status == "on"){
                        $reminder_status = 1;
                        if(isset($request->rem_data[$id]['time_period']) AND ($request->rem_data[$id]['time_period']!="")){
                            $time_period = $request->rem_data[$id]['time_period'][0];
                        }else{
                            $time_period ="";
                        }
                        $time_period = $request->rem_data[$id]['time_period'][0];
                        if(isset($request->rem_data[$id]['reminder_notification']) AND ($request->rem_data[$id]['reminder_notification']!="")){

                            $reminder_notification = $request->rem_data[$id]['reminder_notification'][0];
                            if($reminder_notification=="on"){
                                $reminder_notification = 1;
                            }

                        }else{

                            $reminder_notification = 0;
                        }

                        if(isset($request->rem_data[$id]['reminder_mail']) AND ($request->rem_data[$id]['reminder_mail']!="")){

                            $reminder_mail = $request->rem_data[$id]['reminder_mail'][0];
                            $reminder_mail = 1;

                        }else{

                            $reminder_mail = 0;
                        }

                    }else{

                        $time_period = 0;
                        $reminder_notification = 0;
                        $reminder_mail =0;
                    }
                }else{

                    $reminder_status =0;
                    $time_period = 0;
                    $reminder_notification = 0;
                    $reminder_mail =0;
                }
                EmployeeKra::where('id', $request->emp_kra_id[$i])
                    ->update([
                        'user_id'=> $request->user_id[$i],
                        'name'=>$request->name[$i],
                        'kra_id'=> $request->kra_name,
                        'frequency'=> $request->frequency[$i],
                        'activation_date'=> $request->activation_date[$i],
                        'deadline_date'=> $request->deadline_date[$i],
                        'priority'=> $request->priority[$i],
                        'reminder_status' => $reminder_status,
                        'reminder_days' => $time_period,
                        'reminder_notification' => $reminder_notification,
                        'reminder_email' => $reminder_mail

                    ]);
            }

        }

        if(!empty($request->added_name) && !empty($request->added_frequency) && !empty($request->added_activation_date) && !empty($request->added_deadline) && !empty($request->added_priority)){

            for($j=0;$j<count($request->added_name); $j++){

                if($request->reminder_check[$j]==""){
                    $reminder_check = 0;
                }else{
                    $reminder_check = $request->reminder_check[$j];
                    if($reminder_check=="on"){
                        $reminder_check=1;
                    }
                }
                if($request->reminderTime[$j]==""){
                    $reminderTime = 0;
                }else{
                    $reminderTime = $request->reminderTime[$j];
                    if($reminderTime=="on"){
                        $reminderTime=1;
                    }
                }
                if($request->reminderNotification[$j]==""){
                    $reminderNotification = 0;
                }else{
                    $reminderNotification = $request->reminderNotification[$j];
                    if($reminderNotification=="on"){
                        $reminderNotification=1;
                    }
                }
                if($request->reminderMail[$j]==""){
                    $reminderMail = 0;
                }else{
                    $reminderMail = $request->reminderMail[$j];
                    if($reminderMail=="on"){
                        $reminderMail=1;
                    }
                }
                $emp_kra = new EmployeeKra;
                $emp_kra->user_id       = $user_id;
                $emp_kra->name      = $request->added_name[$j];
                $emp_kra->kra_id = $request->kra_name;
                $emp_kra->frequency = $request->added_frequency[$j];
                $emp_kra->activation_date = $request->added_activation_date[$j];
                $emp_kra->deadline_date = $request->added_deadline[$j];
                $emp_kra->priority = $request->added_priority[$j];
                $emp_kra->reminder_status = $reminder_check;
                $emp_kra->reminder_days = $reminderTime;
                $emp_kra->reminder_notification = $reminderNotification;
                $emp_kra->reminder_email = $reminderMail;
                $emp_kra->save();

            }

        }

        $hod = LeaveAuthority::where(['priority'=>'2','isactive'=>1,'user_id' => $user_id])
            ->first();

        $get_manager = Employee::where(['user_id' => $hod->manager_id])
            ->first();
        $notification_data['message'] = $get_manager->fullname." has assigned KRA.";

        $title = 'New KRA Added';

        $body = $notification_data['message'];

        pushNotification($user_id, $title, $body);

        return redirect("employees/edit/$user_id")->with('kraSaved',"Details saved successfully.");

    }



}//end of class

