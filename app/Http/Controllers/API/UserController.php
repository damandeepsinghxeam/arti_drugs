<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Mail\ForgotPassword;
use Mail;
use Hash;
use Auth;
use DB;
use Validator;
use Carbon\Carbon;
use DateTime;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\User;
use App\Employee;
use App\EmployeeProfile;
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
use App\EmploymentHistory;
use App\Document;
use App\Company;
use App\SalaryStructure;
use App\SalaryCycle;
use App\LeaveAuthority;
use App\Message;
use App\Notification;
use App\Designation;
use App\AppVersion;

class UserController extends Controller
{
    /*
        Check app version & if old tell them to update the app
    */
    function checkAppVersion(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'version' => 'required',
            'device_type' => 'required', //Android, Ios
        ]);

        if($validator->fails()){
            return response()->json(['validation_error'=>$validator->errors()], 400);
        }

        $current_version = AppVersion::where(['version'=>$request->version,'device_type'=>$request->device_type])->first();

        if(!empty($current_version)){
            $latest_version = AppVersion::where(['device_type'=>$request->device_type])
                ->orderBy('id','DESC')
                ->first();

            if($current_version->version !== $latest_version->version){
                $message = "Please update your app.";
                return response()->json(['error'=>$message], 426);
            }else{
                $message = "Your app is uptodate.";
                return response()->json(['success'=>$message], 200);
            }
        }else{
            $message = "Please update your app.";
            return response()->json(['error'=>$message], 426);
        }
    }

    /*
        Generate secret token for a user everytime they login
    */
    function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'employee_code' => 'required',
            'password' => 'required',
            'device_id' => 'required',
            'device_type' => 'required', //Android, Ios
        ]);

        if($validator->fails()){
            return response()->json(['validation_error'=>$validator->errors()], 400);
        }

         $credentials = $request->only(['employee_code','password']);
        if(Auth::attempt($credentials)){
            $user = Auth::user();

            if($user->employee->approval_status == '0'){
                Auth::logout();
                return response()->json(['error'=>'Your account has not been approved yet. Please contact administrator!'], 401);

            }elseif(!$user->employee->isactive){
                Auth::logout();
                return response()->json(['error'=>'Your account has been disabled. Please contact administrator!'], 401);

            }elseif($user->login_allowed==0){
                Auth::logout();
                return response()->json(['error'=>'You are not allowed to login. Please contact administrator.'], 401);

            }else{
                $other_users = User::where('device_id',$request->device_id)
                    ->where('id','!=',$user->id)
                    ->update(['device_id'=>null,'device_type'=>null]);

                $user->device_id = $request->device_id;
                $user->device_type = $request->device_type;
                $user->save();

                $user_data = User::where('id',$user->id)
                    ->with('employee:id,user_id,fullname,profile_picture,isactive,approval_status,joining_date')
                    ->first();
                $user_data->permissions = $user->permissions()->pluck('name')->toArray();

                if(empty($user_data->employee->profile_picture)){
                    $user_data->employee->profile_picture = config('constants.static.profilePic');
                }else{
                    $user_data->employee->profile_picture = config('constants.uploadPaths.profilePic').$user_data->employee->profile_picture;
                }

                $success['secret_token'] =  $user->createToken('MyApp')->accessToken;
                $success['user'] = $user_data;
                return response()->json(['success' => $success], 200);
            }
        }else{
            return response()->json(['error'=>'Credentials do not match!'], 401);
        }
    }

    /*
        Revoke the secret-token if user logout
    */
    function logout(Request $request)
    {
        $user = $request->user();
        $user->token()->revoke();

        $user->device_id = null;
        $user->device_type = null;
        $user->save();
        return response()->json(['success' => 'Successfully logged out.']);
    }

    /*
        Get the employees of the selected departments
    */
    function departmentsWiseEmployees(Request $request)
    {
        checkDeviceId($request->user());
        $validator = Validator::make($request->all(), [
            'department_ids' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['validation_error'=>$validator->errors()], 400);
        }

        $department_ids = explode(',',$request->department_ids);
        $employees = DB::table('employees as e')
            ->join('employee_profiles as ep','e.user_id','=','ep.user_id')
            ->join('users as u','e.user_id','=','u.id')
            ->whereIn('ep.department_id',$department_ids)
            ->where(['e.approval_status'=>'1','e.isactive'=>1,'ep.isactive'=>1])
            ->where('e.user_id','!=',1)
            ->select('e.user_id','e.fullname','u.employee_code')
            ->get();

        $success['employees'] = $employees;
        if($employees->isEmpty()){
            $status_code = 204;
        }else{
            $status_code = 200;
        }
        return response()->json(['success' => $success], $status_code);
    }

      /*
        Get states wise cities
    */
    function statesWiseCities(Request $request)
    {
        checkDeviceId($request->user());
        $validator = Validator::make($request->all(), [
            'state_ids' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['valdiation_error' => $validator->errors()], 400);
        }

        $state_ids = explode(',',$request->state_ids);
        $cities = City::where(['isactive' => 1])
                    ->whereIn('state_id',$state_ids)
                    ->select('id','name','state_id')
                    ->orderBy('name')
                    ->get();

        $success['cities'] = $cities;
        return response()->json(['success' => $success], 200);
    }

    public function menu(Request $request){
        $userPermissions = Auth::user()->permissions()->pluck('name')->toArray();
        $allPermissions  = DB::table('model_has_permissions')->where('model_type','App\User')->groupby('permission_id')->distinct()->get()->toArray();

//        $employeeManagementPermissions = [['permission' => 'create-employee', 'val' => 'New Registration', 'type' => 'NewRegistration' ],['permission' => '', 'val' => 'Employees List', 'type' => 'EmployeesList'],
//            ['permission' => 'replace-authority', 'val' => 'Replace Authority', 'type' => 'ReplaceAuthority']];
//        $userEmployeeManagementPermissions = $this->getUserPermission($employeeManagementPermissions, $userPermissions);
//        $employeeManagement = ["isExpanded" => "false", "category_name" =>  "Employee Management", "image" => "" , "subcategory" => $userEmployeeManagementPermissions];
//        if(count($employeeManagement['subcategory']) > 0) {
//            $menu[] = $employeeManagement;
//        }
//
//         $companiesManagementPermissions = [['permission' => ['create-company', 'edit-company', 'approve-company'], 'val' => 'Company Management', 'type' => 'CompanyManagement']];
//         $userCompaniesManagementPermissions = $this->getUserPermission($companiesManagementPermissions, $userPermissions);
//        $companiesManagement = ["isExpanded" => "false", "category_name" =>  "Company Management", "image" => "" , "subcategory" => $userCompaniesManagementPermissions];
//        if(count($companiesManagement['subcategory']) > 0) {
//            $menu[] = $companiesManagement;
//        }
//
//        $projectsManagementPermissions = [['permission' => ['create-project'], 'val' => ['Add Projects', 'My Projects'], 'type' => ['AddProjects', 'MyProjects']], ['permission' => ['approve-project'], 'val' => ['Projects For Approval'], 'type' => ['ProjectsForApproval']], ['permission' => '', 'val' => ['All Projects'], 'type' => ['AllProjects']] ];
//        $userProjectsManagementPermissions = $this->getUserPermission($projectsManagementPermissions, $userPermissions);
//        $projectManagement = ["isExpanded" => "false", "category_name" =>  "Project Management", "image" => "" , "subcategory" => $userProjectsManagementPermissions];
//        if(count($projectManagement['subcategory']) > 0) {
//             $menu[] = $projectManagement;
//        }
//
//        $mastersManagementPermissions = [['permission' => '', 'val' => ['Manage Designation', 'Manage Role'], 'type' => ['ManageDesignation', 'ManageRole']]];
//        $userMastersManagementPermissions = $this->getUserPermission($mastersManagementPermissions, $userPermissions);
//        $masterManagement = ["isExpanded" => "false", "category_name" =>  "Master Management", "image" => "" , "subcategory" => $userMastersManagementPermissions];
//        if(count($masterManagement['subcategory']) > 0) {
//            $menu[] = $masterManagement;
//        }
//
//        $probationManagementPermissions = [['permission' => 'approve-probation', 'val' => 'Probation Management', 'type' => 'ProbationManagement']];
//        $userProbationManagementPermissions = $this->getUserPermission($probationManagementPermissions, $userPermissions);
//        $probationManagement = ["isExpanded" => "false", "category_name" =>  "Probation Management", "image" => "" , "subcategory" => $userProbationManagementPermissions];
//        if(count($probationManagement['subcategory']) > 0) {
//            $menu[] = $probationManagement;
//        }

//        $attendanceManagementPermissions = [['permission' => '', 'val' => 'My Attendance', 'type' => 'MyAttendance'], ['permission' => '', 'val' => 'Request Change', 'type' => 'RequestChange'],
//            ['permission' => '', 'val' => 'Requested Changes', 'type' => 'RequestedChanges'], ['permission' => 'view-attendance', 'val' => ['Attendance Sheet', 'Verify Attendance'], 'type' => ['AttendanceSheet', 'VerifyAttendance']], ['permission' => ['change-attendance', 'it-attendance-approver'], 'val' => 'Change Approvals', 'type' => 'ChangeAprrovals']];
        $attendanceManagementPermissions = [['permission' => '', 'val' => 'My Attendance', 'type' => 'MyAttendance'],
             ['permission' => 'view-attendance', 'val' => ['Attendance Sheet', 'Employee Attendance'], 'type' => ['AttendanceSheet', 'VerifyAttendance']]];
        $userAttendanceManagementPermissions = $this->getUserPermission($attendanceManagementPermissions, $userPermissions);
        $attendanceManagement = ["isExpanded" => "false", "category_name" =>  "Attendance Management", "image" => "<i class=\"fa fa-calendar\"></i>" , "subcategory" => $userAttendanceManagementPermissions];
        if(count($attendanceManagement['subcategory']) > 0) {
            $menu[] = $attendanceManagement;
        }

//        $leavesManagementPermissions = [['permission' => '', 'val' => 'Apply For Leave', 'type' => 'ApplyForLeave'],['permission' => '', 'val' => 'Applied Leaves', 'type' => 'AppliedLeaves'],
//            ['permission' => 'approve-leave', 'val' => ['Approve Leaves', 'Leave Report'], 'type' => ['ApprovesLeaves', 'LeaveReport']], ['permission' => '', 'val' => 'Holidays List', 'type' => 'HolidayList']];

        $leavesManagementPermissions = [['permission' => '', 'val' => 'Apply For Leave', 'type' => 'ApplyForLeave'],['permission' => '', 'val' => 'Applied Leaves', 'type' => 'AppliedLeaves'],
            ['permission' => 'approve-leave', 'val' => ['Approve Leaves'], 'type' => ['ApprovesLeaves']]];

        $userLeavesManagementPermissions = $this->getUserPermission($leavesManagementPermissions, $userPermissions);
        $leavesManagement = ["isExpanded" => "false", "category_name" => "Leaves Management", "image" => "<i class=\"fa fa-plane fa-lg\"></i>" , "subcategory" => $userLeavesManagementPermissions];
        if(count($leavesManagement['subcategory']) > 0) {
            $menu[] = $leavesManagement;
        }

//        $taskManagementPermissions = [['permission' => 'create-task', 'val' => ['Add Task', 'Created Tasks', 'Approve Date Extensions'], 'type' => ['AddTask', 'CreatedTasks', 'ApproveDateExtensions'] ],['permission' => '', 'val' => ['Request Date Extension', 'Requested Date Extensions', 'My Task', 'Points System'], 'type' => ['RequestDateExtension', 'RequestDateExtension', 'MyTask', 'PointsSystem']],
//             ['permission' => 'task-report', 'val' => 'Task Report', 'type' => 'TaskReport']];
//        $userTaskManagementPermissions = $this->getUserPermission($taskManagementPermissions, $userPermissions);
//        $taskManagement = ["isExpanded" => "false", "category_name" =>  "Task Management", "image" => "<i class=\"fa fa-clock-o\"></i>" , "subcategory" => $userTaskManagementPermissions];
//        if(count($taskManagement['subcategory']) > 0) {
//            $menu[] = $taskManagement;
//
//        }

//        $leadManagementPermissions = [['permission' => '', 'val' => 'Create Lead', 'type' => 'CreateLead' ],['permission' => '', 'val' => 'List Leads', 'type' => 'ListLeads'],['permission' => '', 'val' => 'Approve Lead', 'type' => 'ApproveLead'], ['permission' => ['leads-management.view-til', 'leads-management.til-remarks-list'], 'val' => 'List TIL', 'type' => 'ListTIL']];
//        $userLeadManagementPermissions = $this->getUserPermission($leadManagementPermissions, $userPermissions);
//        $leadManagement = ["isExpanded" => "false", "category_name" =>  "Lead Management", "image" => "" , "subcategory" => $userLeadManagementPermissions];
//        if(count($leadManagement['subcategory']) > 0) {
//            $menu[] = $leadManagement;
//        }
//
//        $jrfManagementPermissions = [['permission' => 'create-jrf', 'val' => ['Create JRF', 'Approve JRF'], 'type' => ['MyTask', 'PointsSystem']],['permission' => '', 'val' => ['JRF Listing', 'Interview List'], 'type' => ['JRFListing', 'InterviewList']]];
//        $userJrfManagementPermissions = $this->getUserPermission($jrfManagementPermissions, $userPermissions);
//        $jrfManagement = ["isExpanded" => "false", "category_name" =>  "JRF Management", "image" => "" , "subcategory" => $userJrfManagementPermissions];
//        if(count($jrfManagement['subcategory']) > 0) {
//            $menu[] = $jrfManagement;
//        }
//
//        $dmsKeywordPermissions = [['permission' => 'create-dms-keyword', 'val' => 'Dms Keyword', 'type' => 'DmsKeyword']];
//        $userDmsKeywordManagementPermissions = $this->getUserPermission($dmsKeywordPermissions, $userPermissions);
//        $dmsKeyword = ["isExpanded" => "false", "category_name" =>  "Dms Keyword Management", "image" => "" , "subcategory" => $userDmsKeywordManagementPermissions];
//        if(count($dmsKeyword['subcategory']) > 0) {
//            $menu[] = $dmsKeyword;
//        }
//
//        $dmsCategoryPermissions = [['permission' => 'create-dms-category', 'val' => 'Dms Category', 'type' => 'DmsKeyword' ]];
//        $userDmsCategoryManagementPermissions = $this->getUserPermission($dmsCategoryPermissions, $userPermissions);
//        $dmsCategory = ["isExpanded" => "false", "category_name" =>  "Dms Category Management", "image" => "" , "subcategory" => $userDmsCategoryManagementPermissions];
//        if(count($dmsCategory['subcategory']) > 0) {
//            $menu[] = $dmsCategory;
//
//        }
//
//        $dmsDocumentPermissions = [['permission' => 'index-dms-document', 'val' => 'All Dms Document', 'type' => 'AllDmsDocument' ], ['permission' => 'create-dms-document', 'val' => 'Create Dms Document', 'type' => 'CreateDmsDocument']];
//        $userDmsDocumentManagementPermissions = $this->getUserPermission($dmsDocumentPermissions, $userPermissions);
//        $dmsDocument = ["isExpanded" => "false", "category_name" =>  "Dms Document Management", "image" => "" , "subcategory" => $userDmsDocumentManagementPermissions];
//        if(count($dmsDocument['subcategory']) > 0) {
//            $menu[] = $dmsDocument;
//        }
//
//        $payrollItems = [];
//        $salaryHeadPermissions = [['permission' => 'index-salary-head', 'val' => 'All Salary Heads', 'type' => 'AllSalaryHeads' ]];
//        $userSalaryHeadManagementPermissions = $this->getUserPermission($salaryHeadPermissions, $userPermissions);
//        $salaryHead = ["isExpanded" => "false", "category_name" =>  "All Salary Heads", "image" => "" , "subcategory" => $userSalaryHeadManagementPermissions];
//        if(count($salaryHead['subcategory']) > 0){
//            $payrollItems[] = $salaryHead;
//        }
//
//        $salaryCyclePermissions = [['permission' => 'index-salary-cycle', 'val' => 'All Salary Cycles', 'All Salary Cycles' ]];
//        $userSalaryCycleManagementPermissions = $this->getUserPermission($salaryCyclePermissions, $userPermissions);
//        $salaryCycle = ["isExpanded" => "false", "category_name" =>  "All Salary Cycle's", "image" => "" , "subcategory" => $userSalaryCycleManagementPermissions];
//        if(count($salaryCycle['subcategory']) > 0){
//            $payrollItems[] = $salaryCycle;
//        }
//
//        $ptRatePermissions = [['permission' => 'index-pt-rates', 'val' => 'All PT Rates', 'type' => 'All PT Rates' ], ['permission' => 'create-pt-rates', 'val' => 'Create PT Rates', 'type' => 'CreatePTRates']];
//        $userPtRatePermissions = $this->getUserPermission($ptRatePermissions, $userPermissions);
//        $ptRate = ["isExpanded" => "false", "category_name" =>  "PT Rate Management", "image" => "" , "subcategory" => $userPtRatePermissions];
//        if(count($ptRate['subcategory']) > 0){
//            $payrollItems[] = $ptRate;
//        }
//
//        $pfPermissions = [['permission' => 'index-pf', 'val' => 'All PF', 'type' => 'AllPF' ], ['permission' => 'create-pf', 'val' => 'Create PF', 'type' => 'CreatePF' ]];
//        $userPfPermissions = $this->getUserPermission($pfPermissions, $userPermissions);
//        $pf = ["isExpanded" => "false", "category_name" =>  "PT Management", "image" => "" , "subcategory" => $userPfPermissions];
//        if(count($pf['subcategory']) > 0){
//            $payrollItems[] = $pf;
//        }
//
//        $esiPermissions = [['permission' => 'index-esi', 'val' => 'All ESI', 'type' => 'AllESI' ], ['permission' => 'create-esi', 'val' => 'Create Esi', 'type' => 'CreateESI']];
//        $userEsiPermissions = $this->getUserPermission($esiPermissions, $userPermissions);
//        $esi = ["isExpanded" => "false", "category_name" =>  "ESI Management", "image" => "" , "subcategory" => $userEsiPermissions];
//        if(count($esi['subcategory']) > 0){
//            $payrollItems[] = $esi;
//        }
//
//        $payroll = ["isExpanded" => "false", "category_name" =>  "Payroll Management", "image" => "" , "subcategory" => $payrollItems];
//        if(count($payroll['subcategory']) > 0) {
//            $menu[] = $payroll;
//        }

//        $menu = ["employee_management" => $employeeManagement, "company_management" => $companiesManagement, "project_management" => $projectManagement, "probation_management" => $probationManagement,
//            "leaves_management" => $leavesManagement, "attendance_management" => $attendanceManagement, "task_management" => $taskManagement, "lead_management" => $leadManagement,
//            "jrf_management" => $jrfManagement, "dms_keyword" => $dmsKeyword, "dms_category" => $dmsCategory, "dms_document" => $dmsDocument, "payroll_management" => $payroll];
        return response()->json(['status' =>'success', 'data' => $menu], 200);
    }

    public function getUserPermission($categoryPermissions, $userPermissions){
        foreach ($categoryPermissions as $categoryPermission){
            if(is_array($categoryPermission['permission'])){
                foreach ($categoryPermission['permission'] as $permission) {
                    if (in_array($permission, $userPermissions)) {
                        $permissions[] = $permission;
                    }else{
                        $permissions = [];
                    }
                }
                if(is_array($categoryPermission['val'])) {
//                    foreach ($categoryPermission['val'] as $val) {
                        for($i=0; $i< count($categoryPermission['val']); $i++) {
                            $userCategoryPermissions[] = ['permission' => $permissions, 'val' => $categoryPermission['val'][$i], 'type' => $categoryPermission['type'][$i]];
                    }
                }else{
                    $userCategoryPermissions[] = ['permission' => $permissions, 'val' => $categoryPermission['val'], 'type' => $categoryPermission['type']];
                }
            }
            elseif(in_array($categoryPermission['permission'], $userPermissions)) {
//                 $userCategoryPermissions[] = $categoryPermission;
                if(is_array($categoryPermission['val'])) {
                    for($i=0; $i< count($categoryPermission['val']); $i++) {
                        $userCategoryPermissions[] = ['permission' => $categoryPermission['permission'], 'val' => $categoryPermission['val'][$i], 'type' => $categoryPermission['type'][$i]];
                    }
                }else{
                    $userCategoryPermissions[] = ['permission' => $categoryPermission['permission'], 'val' => $categoryPermission['val'], 'type' => $categoryPermission['type']];
                }
            }elseif ($categoryPermission['permission'] == ''){
//                  $userCategoryPermissions[] = $categoryPermission;
                if(is_array($categoryPermission['val'])) {
                    for($i=0; $i< count($categoryPermission['val']); $i++) {
                        $userCategoryPermissions[] = ['permission' => $categoryPermission['permission'], 'val' => $categoryPermission['val'][$i], 'type' => $categoryPermission['type'][$i]];
                    }
                }else{
                    $userCategoryPermissions[] = ['permission' => $categoryPermission['permission'], 'val' => $categoryPermission['val'], 'type' => $categoryPermission['type']];
                }
            }
        }
        if(!isset($userCategoryPermissions)){
            $userCategoryPermissions = [];
        }

        return $userCategoryPermissions;
    }

}//end of class
