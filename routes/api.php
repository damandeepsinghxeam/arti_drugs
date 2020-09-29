<?php



use Illuminate\Http\Request;



/*

|--------------------------------------------------------------------------

| API Routes

|--------------------------------------------------------------------------

|

| Here is where you can register API routes for your application. These

| routes are loaded by the RouteServiceProvider within a group which

| is assigned the "api" middleware group. Enjoy building your API!

|

*/



Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});




Route::group(['prefix'=>'v1'], function(){
	Route::post('login','API\UserController@login');
	Route::post('app-version','API\UserController@checkAppVersion');

	Route::group(['middleware' => 'auth:api'], function(){
		Route::get('logout','API\UserController@logout');
		Route::post('departments-wise-employees','API\UserController@departmentsWiseEmployees');

		Route::post('states-wise-cities','API\UserController@statesWiseCities');

		Route::post('attendance-detail','API\AttendanceController@attendanceDetail');
		Route::post('attendance-punches','API\AttendanceController@attendancePunches');

		Route::post('user-attendance-detail','API\AttendanceController@userAttendanceDetail');
		Route::post('monthly-attendance-report','API\AttendanceController@monthlyAttendanceReport');

		Route::post('attendance-location','API\AttendanceController@storeAttendanceLocation');
		Route::get('departments','API\MasterController@departments');

		Route::get('leave-balance','API\LeaveController@leaveBalance');
		Route::post('applied-leaves','API\LeaveController@appliedLeaves');

        Route::get('side-menu','API\UserController@menu');

        Route::post('approve-leaves','API\LeaveController@approveLeaves');
		Route::post('leave-detail','API\LeaveController@leaveDetail');

		Route::post('cancel-leave','API\LeaveController@cancelLeave');
		Route::post('leave-approval','API\LeaveController@leaveApproval');

		Route::get('apply-leave','API\LeaveController@applyLeave');
		Route::post('between-leave-holidays','API\LeaveController@betweenLeaveHolidays');

		Route::post('leave-replacement-availability','API\LeaveController@leaveReplacementAvailability');
		Route::post('apply-leave','API\LeaveController@storeAppliedLeave');

		Route::get('emp-three-days-attendance','API\AttendanceController@EmpThreeDaysAttendance');



		/* Task module API's */
		Route::post('my-tasks','API\TaskController@myTasks');
		Route::post('view-tasks','API\TaskController@viewTasks');

		Route::post('additional-task-info','API\TaskController@additionalTaskInfo');
		Route::post('task-detail','API\TaskController@taskDetail');

		Route::post('change-my-task-status','API\TaskController@changeMyTaskStatus');
		Route::post('change-task-status','API\TaskController@changeTaskStatus');

		Route::post('update-task','API\TaskController@updateTask');
		Route::get('create-task','API\TaskController@createTask');

		Route::post('save-task-project','API\TaskController@saveTaskProject');
		Route::post('save-task','API\TaskController@saveTask');
		Route::post('check-tasks-limit','API\TaskController@checkTasksLimit');
		Route::post('save-chat','API\TaskController@saveChat');


        Route::post('request-task-date-extension','API\TaskController@saveTaskDateExtension');
        Route::post('approve-reject-task-date-extension','API\TaskController@approveRejectTaskDateExtension');
        Route::get('request-task-date-extension/{approval_status}', 'API\TaskController@allTaskDateExtensionRequests');
        Route::get('request-task-date-extension/{user}/{approval_status}', 'API\TaskController@userTaskDateExtensionRequests');
        Route::post('task-date-extension-report','API\TaskController@createTaskReport');




        /* lead module API's */
       Route::get('create-lead','API\LeadsManagementController@create');
       Route::post('store-lead','API\LeadsManagementController@store');
       Route::post('list-lead','API\LeadsManagementController@index');
       Route::get('edit-lead/{id?}','API\LeadsManagementController@edit');
       Route::post('update-lead/{id?}','API\LeadsManagementController@update');


       /*
       * Arti Drug Sale Target
       */
        Route::get('arti-drugs/employees','API\ArtiDrugSaleTargetController@allEmployees');
        Route::post('arti-drugs/add-targets','API\ArtiDrugSaleTargetController@saveTargets');
        Route::post('arti-drugs/achieved-targets','API\ArtiDrugSaleTargetController@achieveTargets');
        Route::post('arti-drugs/filter','API\ArtiDrugSaleTargetController@filter');
        Route::post('arti-drugs/employee/targets','API\ArtiDrugSaleTargetController@employeeTarget');
    });
});

