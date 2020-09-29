<?php
use Illuminate\Http\Request;

Route::get('local-claim-form', function () {
    return view('travel.local_claim_form');
});

/**************JRF****************/
Route::group(['prefix' => 'payroll'], function () {
    Route::any('/salary-head/{id?}', 'PayrollController@salary_head');
    Route::any('/salary-cycle/{id?}', 'PayrollController@salary_cycle');
});

Route::get('add-leave', 'UserController@addLeave');

/**************JRF****************/
Route::group(['prefix' => 'jrf', 'middleware' => 'App\Http\Middleware\RestrictEmployee'], function () {
    //  Route::group(['middleware' => ['permission:create-jrf']], function () {
    Route::get('create', 'JrfController@create');
    Route::post('save-jrf', 'JrfController@saveJrf');
    Route::get('list-jrf', 'JrfController@listJrf');
    Route::get('view-jrf/{id}', 'JrfController@viewJrfs');
    Route::get('edit-jrf/{id}', 'JrfController@editJrfs');
    Route::post('update-jrf', 'JrfController@updateJrfs');
    Route::get('cancel-jrf/{jrf_id}', 'JrfController@cancelCreatedJrf');
    Route::post('save-jrf-approval', 'JrfController@saveJrfApproval');
    Route::post('save-arf-approval', 'JrfController@saveArfApproval');
    Route::get('ad-requisition-form/{jrf_id}', 'JrfController@adRequisitionForm');
    Route::post('save-ad-requisition-form', 'JrfController@saveAdRequisitionForm');
    Route::get('recruitment-tasks-assigned-jrf-list', 'JrfController@assignedJrfList');

    Route::get('view-and-print-offer-letter/{id}', 'JrfController@viewOfferLetter');

    Route::post('project-wise-designation', 'JrfController@ProjectWiseDesignation');

    Route::post('save-sendback-approval', 'JrfController@savesendBackApproval');
    Route::post('save-discussion-approval', 'JrfController@saveDiscussionApproval');

    //  });

    //Route::group(['middleware'=>['permission:create-recruitment-task']], function () {
    Route::post('save-recruitment-tasks','JrfController@saveRecruitmentTasks');
    //});

    Route::get('level-two-screening/{candidate_id}','JrfController@levelTwoScreening');
    Route::get('candidate-level-one-screening-detail/{level_one_id}', 'JrfController@candidateLevelOneScreeningDetail');
    Route::post('save-level-two-screening-detail','JrfController@saveCandidateLevelTwoScreeningDetail');

    /*  Routes For Final Approval Appointment By Hitesh */

    Route::get('final-appointment-approval/{jrf_id}','JrfController@finalAppointmentApproval');
    Route::post('save-final-appointment-approval','JrfController@saveFinalAppointmentApproval');
    Route::get('list-appointment-approval','JrfController@listAppointmentApproval');
    Route::get('view-appointment-approval/{id}','JrfController@viewAppointmentApproval');
    Route::get('edit-appointment-approval/{id}', 'JrfController@editAppointmentApproval');
    Route::post('update-appointment-approval', 'JrfController@updateAppointmentApproval');
    Route::get('appointment-approval','JrfController@AppointmentApproval');
    Route::post('change-status', 'JrfController@changeAppointStatus');
    Route::post('change-joining-status', 'JrfController@changeJoiningStatus');

    Route::post('closoed-jrf-status', 'JrfController@changeClosedJrfStatus');
    Route::post('mgmt-assigned-status', 'JrfController@MgmtassignStatus');

    /* Appointed Candidate Approvals By Hod & Management */

    Route::get('approve-appointed-candidate/{jrf_status?}', 'JrfController@approveAppointedCandidate');
    Route::post('save-appointed-candidate-approval', 'JrfController@saveAppointedCandidate');
    /* End Routes For Final Approval Appointment By Hitesh */

    /*  Closure form By Hitesh */

    Route::get('create-closure','JrfController@createClosure');
    Route::get('final-closure/{jrf_id}','JrfController@finalClosure');
    Route::post('save-closure','JrfController@saveClosour');
    Route::get('list-selected-candidate','JrfController@listSelectedCandidate');

    Route::get('management-closure','JrfController@listClosureCandidate');

    Route::get('final-jrf-closed/{jrf_id}','JrfController@finalJrfClosed');

    Route::get('mgmt-assign-date','JrfController@MgmtAssignDate');

    //  Management Approved Candidate

    Route::get('approval-mgmt/{jrf_status?}', 'JrfController@approveMgmt');

    Route::post('save-mgmt-approval', 'JrfController@saveMgmtApproval');

    // Jrf Closure Extended Date

    Route::post('mgmt-requuest-date', 'JrfController@saveReqDate');
    Route::get('recruitment-tasks-extend-date/{jrf_status?}', 'JrfController@assignedExtendDate');

    Route::post('save-ext-date-approval', 'JrfController@saveDateExtApproval');

    Route::get('edit-jrf/unassigned/{id}', 'JrfController@unassignedRecruiter');

        Route::get('edit-jrf/unassigned/{id}', 'JrfController@unassignedRecruiter');


    //Route::get('/create-closure','JrfController@search');

    /* End Closure form By Hitesh */


    //Route::group(['middleware'=>['permission:create-interviewer-detail']], function () {

    Route::get('level-one-screening/{jrf_id}','JrfController@levelOneScreening');
    Route::get('edit-candidate-level-one-screening-detail/{level_one_id}', 'JrfController@editCandidateLevelOneScreeningDetail');
    Route::post('save-level-one-screening-detail','JrfController@saveLevelOneScreeningDetail');
    Route::post('update-level-one-screening-detail','JrfController@updateLevelOneScreeningDetail');
    //Route::post('save-interviewer-details', 'JrfController@saveInterviewerDetails');
    Route::post('update-interview-status','JrfController@updateInterviewStatusDetail');
    Route::post('interview-status-info','JrfController@interviewStatusInfo');
    // });

    Route::get('interview-list', 'JrfController@interviewList');
    Route::get('level-first-interview-list', 'JrfController@LevelfirstList');
    Route::get('level-second-interview-list', 'JrfController@LevelsecondList');
    Route::get('level-third-candidate-list', 'JrfController@LevelThirdList');
    Route::get('approve-jrf/{jrf_status?}', 'JrfController@approveJrf');
    Route::get('approve-arf/{jrf_status?}', 'JrfController@approveArf');
    Route::post('close-jrf-permanently', 'JrfController@closeJrfPermanently');
    Route::get('sendback-jrf/{jrf_status?}', 'JrfController@sendbackJrf');
    Route::get('discussion-jrf-date/{jrf_status?}', 'JrfController@DiscussionJrf');


});
/************* END *****************/

Route::group(['prefix' => 'tasks', 'middleware' => 'App\Http\Middleware\RestrictEmployee'], function () {
    Route::group(['middleware' => ['permission:create-task']], function () {
        Route::get('create', 'TaskController@create');
        Route::post('/', 'TaskController@store');
        Route::post('save-task-project', 'TaskController@saveTaskProject');
        Route::get('view-tasks', 'TaskController@viewTasks');
        Route::post('change-task-status', 'TaskController@changeTaskStatus');
        Route::post('update-task', 'TaskController@updateTask');
        Route::post('check-tasks-limit','TaskController@checkTasksLimit');
    });

    Route::get('request-change-date','TaskController@requestchangeTaskDate');
    Route::get('requested-change-date/{final_status?}','TaskController@requestedChangeTaskDate');
    Route::post('check-assigned-date', 'TaskController@checkAssignedDate');
    Route::post('save-task-date-change-request', 'TaskController@saveTaskDateChange');
    Route::post('list-task-change-comments', 'TaskController@listTaskChangeComments');
    Route::get('change-task-date-approvals/{approval_status?}', 'TaskController@changeTaskDateApprovals');
    Route::post('change-task-date', 'TaskController@changeTaskDate');
    Route::get('cancel-requested-change/{change_id}', 'TaskController@cancelRequestedChange');


    Route::get('task-points','TaskController@taskPoints');
    Route::post('task-info', 'TaskController@taskInfo');
    Route::get('my-tasks', 'TaskController@myTasks');
    Route::post('change-my-task-status', 'TaskController@changeMyTaskStatus');
    Route::get('info/{task_id}', 'TaskController@taskDetail');
    Route::post('save-chat', 'TaskController@saveChat');
    Route::post('save-task-update', 'TaskController@saveTaskUpdate');

    Route::group(['middleware'=>['permission:task-report']], function(){
        Route::get('report','TaskController@reportForm');
        Route::get('additional-task-report-info','TaskController@additionalTaskReportInfo');
        Route::post('create-task-report','TaskController@createTaskReport');
    });
});

// Route::get('travel-module-output', function () {
//     return view('travel.travel_module_output');
// });

// Route::get('travel-module-form', function () {
//     return view('travel.travel_module');
// });

Route::get('upload-attendance-sheets', function () {
    return view('attendances.attendance_sheets_form');
});

/////////////////////////////////////////////////////////////////////////////

Route::get('/', function () {
    return view('login_page');
});

Route::get('forgot-password', function () {
    return view('forgot_password');
});

Route::post('forgot-password', 'UserController@forgotPassword');
Route::get('forgot-password/{encrypted_token}', 'UserController@forgotPasswordForm');
Route::post('reset-password', 'UserController@resetPassword');

Route::group(['prefix' => 'dms', 'middleware' => 'App\Http\Middleware\RestrictEmployee'], function () {
    Route::get('dms-home', function () {
        return view('dms.data_management_system');
    });
    Route::get('dms-list', function () {
        return view('dms.list_dms');
    });
    Route::get('create-dms', function () {
        return view('dms.create_dms');
    });
    Route::get('dms-list-approval', function () {
        return view('dms.list_dms_approval');
    });
}); //end of data management system

Route::group(['prefix' => 'sds', 'middleware' => 'App\Http\Middleware\RestrictEmployee'], function () {
    Route::get('service-details', function () {
        return view('sds.service_detail_form');
    });
    Route::get('invoice-setting', function () {
        return view('sds.invoice_setting');
    });
    Route::get('create-invoice', function () {
        return view('sds.create_invoice');
    });
}); //end of service delevery

Route::group(['prefix' => 'employees'], function () {
    //Route::get('set-to-feb','AttendanceController@setToFeb');
    ///////////////CRON////////////////
    Route::get('add-biometric-cron', 'AttendanceController@addBiometricToPunchesCron');
    Route::get('check-absent-cron', 'AttendanceController@checkAbsentCron');
    Route::get('update-taskuser-cron', 'TaskController@updateTaskUserCron');
    Route::get('task-reminder-cron', 'TaskController@taskReminderCron');
    Route::get('weekly-taskoverdue-cron', 'TaskController@weeklyTaskOverdueCron');
    ///////////////////////////////////

    Route::post('login', 'UserController@login');

    Route::group(['middleware' => 'App\Http\Middleware\RestrictEmployee'], function () {
        /////////////////////Extract/////////////////////////
        Route::get('extract-company', 'ExtractController@extractCompany');
        Route::get('extract-project', 'ExtractController@extractProject');
        Route::get('extract-user', 'ExtractController@extractUser');
        Route::get('extract-manager', 'ExtractController@extractManager');
        Route::get('extract-leave', 'ExtractController@extractLeave');
        /////////////////////////////////////////////////////

        Route::group(['middleware' => ['permission:replace-authority']], function(){
            Route::get('replace-authority','UserController@replaceAuthority');
            Route::post('replace-authority','UserController@saveReplaceAuthority');
        });

        Route::get('create-permission', 'UserController@createPermission');
        Route::get('give-permission', 'UserController@givePermission');
        Route::get('revoke-permission', 'UserController@revokePermission');

        Route::get('dashboard', 'UserController@dashboard');
        Route::get('logout', 'UserController@logout');
        Route::get('list', 'UserController@list');
        Route::get('my-profile', 'UserController@myProfile');

        Route::get('messages', 'UserController@allMessages');
        Route::get('notifications', 'UserController@allNotifications');
        Route::post('unread-messages', 'UserController@unreadMessages');
        Route::post('unread-notifications', 'UserController@unreadNotifications');

        Route::post('departments-wise-employees', 'UserController@departmentsWiseEmployees');

        Route::post('check-unique-employee', 'UserController@checkUniqueEmployee');
        Route::post('project-information', 'UserController@projectInformation');
        Route::post('states-wise-cities', 'UserController@statesWiseCities');
        Route::post('band-city', 'UserController@bandCity');

        Route::post('profile-picture', 'UserController@saveProfilePicture');
        Route::get('change-password', 'UserController@changePassword');
        Route::post('change-password', 'UserController@saveNewPassword');

        Route::get('get_missed_punch_today', 'UserController@getMissedPunchToday');
        Route::get('get_missed_punch_data', 'UserController@getMissedPunchData');

        

        Route::group(['middleware' => ['permission:create-employee']], function () {
            Route::get('create/{tab_name?}', 'UserController@create');
            Route::post('create-basic-details', 'UserController@createBasicDetails');
            Route::post('create-profile-details', 'UserController@createProfileDetails');
            Route::post('store-document-details', 'UserController@storeDocumentDetails');

            Route::post('store-qualification-document-details', 'UserController@storeQualificationDocumentDetails');
            Route::post('create-account-details', 'UserController@createAccountDetails');
            Route::post('create-address-details', 'UserController@createAddressDetails');
            Route::post('store-history-details', 'UserController@storeHistoryDetails');

            Route::post('create-reference-details', 'UserController@createReferenceDetails');
            Route::post('create-security-details', 'UserController@createSecurityDetails');
            Route::post('create-emp-kra-details', 'UserController@createEmployeeKraDetails');

            Route::post('create-salary-structure', 'UserController@createSalaryStructure');
            Route::post('update-salary-structure', 'UserController@updateSalaryStructure');


        });
        Route::post('edit-emp-kra-details/{user_id?}', 'UserController@editEmployeeKraDetails');
        Route::group(['middleware' => ['permission:edit-employee']], function () {
            Route::get('edit/{user_id}/{tab_name?}', 'UserController@edit');
            Route::get('profile/{user_id}', 'UserController@otherUserProfile');
            Route::post('change-status', 'UserController@changeEmployeeStatus');
            Route::post('edit-basic-details', 'UserController@editBasicDetails');



            // new print offer letter //
            Route::post('print-offer-letter-document', 'UserController@printOfferLetter');
            Route::get('view-and-print-offer-letter', 'UserController@viewOfferLetter');
            // end of offer letter  //

            Route::post('edit-profile-details', 'UserController@editProfileDetails');
            Route::post('edit-account-details', 'UserController@editAccountDetails');
            Route::post('edit-address-details', 'UserController@editAddressDetails');
            Route::post('edit-reference-details', 'UserController@editReferenceDetails');

            Route::post('edit-security-details', 'UserController@editSecurityDetails');
            Route::post('edit-history-details', 'UserController@editHistoryDetails');
            Route::post('edit-document-details', 'UserController@editDocumentDetails');
            Route::post('edit-qualification-document-details', 'UserController@editQualificationDocumentDetails');
        });

        Route::group(['middleware' => ['permission:approve-employee']], function () {
            Route::post('approve', 'UserController@approveEmployee');
        });

        Route::group(['middleware' => ['permission:approve-probation']], function () {
            Route::get('probation-approvals', 'UserController@probationApprovals');
            Route::get('probation-approval/{action}/{user_id}/{priority}', 'UserController@probationApproval');
            Route::post('change-probation-period', 'UserController@changeProbationPeriod')->name('employees.updateEmployeeProbation');
        });
    }); //end of Restricted Employee group
}); //end of Employees group

Route::group(['prefix'=>'attendances', 'middleware'=>'App\Http\Middleware\RestrictEmployee'], function () {
    Route::get('my-attendance', 'AttendanceController@myAttendance');
    Route::get('request-change', 'AttendanceController@requestChange');
    Route::post('multiple-punches', 'AttendanceController@multiplePunches');

    Route::post('save-remarks', 'AttendanceController@saveRemarks');
    Route::post('check-date-status', 'AttendanceController@checkDateStatus');
    Route::post('save-change-request', 'AttendanceController@saveChangeRequest');

    Route::get('requested-changes/{final_status?}', 'AttendanceController@requestedChanges');
    Route::get('cancel-requested-change/{attendance_change_id}', 'AttendanceController@cancelRequestedChange');
    Route::post('list-comments', 'AttendanceController@listComments');
    Route::get('store_attendance_punch/{employee_code}/{type}', 'AttendanceController@storeAttendancePunch'); // for store attendance - checkin checkout

    Route::group(['middleware' => ['permission:change-attendance|it-attendance-approver']], function () {
        Route::get('change-approvals/{approval_status?}', 'AttendanceController@changeApprovals');
        Route::post('change-attendance', 'AttendanceController@changeAttendance');
        Route::get('approve-attendance-bulk', 'AttendanceController@toExecuteBulkApprovals');
    });

    Route::group(['middleware' => ['permission:view-attendance']], function () {
        Route::get('consolidated-attendance-sheets', 'AttendanceController@consolidatedAttendanceSheets');
        Route::get('view', 'AttendanceController@viewEmployeeAttendance');
        Route::post('verify-month-attendance', 'AttendanceController@verifyMonthAttendance');

        Route::get('export-punches', 'AttendanceController@exportPunches');
        Route::get('verify-attendance-list', 'AttendanceController@verifyAttendanceList');
    }); //end of view-attendance group

    Route::get('view-map','AttendanceController@viewMap');
    
}); //end of attendances group

Route::group(['prefix'=>'travel', 'middleware'=>'App\Http\Middleware\RestrictEmployee'], function () {
    Route::any('/', 'TravelController@dashboard');
    Route::any('approval-form', 'TravelController@approvalForm');
    Route::get('approval-requests', 'TravelController@approvalRequests');
    Route::any('change-request', 'TravelController@changeRequests');
    Route::any('approval-request-change/{id}', 'TravelController@approvalRequestsChange');
    Route::any('approval-request-details/{id}', 'TravelController@approvalRequestsDetails');
    Route::any('claim-form/{id}', 'TravelController@claimForm');
    Route::any('claim-view/{id}', 'TravelController@claimView');
    Route::any('print-claim/{id}', 'TravelController@printClaim');
    Route::any('claim-form-edit/{id}', 'TravelController@claimFormEdit');
    Route::any('delete/claim', 'TravelController@deleteClaim');
    Route::any('delete/approval-details', 'TravelController@deleteApprovalDetails');
    //travel claim
    Route::get('claim-requests', 'TravelController@claimRequests');

    // travel-claim.get-comments
    Route::get('travel-claim/get-comments/', ['as' => 'travel-claim.get-comments', 'uses' => 'TravelController@getComments']);
}); //end of travel group

Route::group(['prefix' => 'leaves', 'middleware' => 'App\Http\Middleware\RestrictEmployee'], function () {
    Route::get('holidays', 'LeaveController@listHolidays');
    Route::get('apply-leave', 'LeaveController@applyLeave');
    Route::get('applied-leaves', 'LeaveController@appliedLeaves');

    Route::get('cancel-applied-leave/{applied_leave_id}', 'LeaveController@cancelAppliedLeave');
    Route::post('applied-leave-info', 'LeaveController@appliedLeaveInfo');
    Route::get('applied-leave/doc/{id}', 'LeaveController@appliedLeaveDocument');

    Route::post('messages', 'LeaveController@messages');
    Route::post('create-leave-application', 'LeaveController@createLeaveApplication');
    Route::post('leave-replacement-availability', 'LeaveController@leaveReplacementAvailability');
    Route::post('between-leave-holidays', 'LeaveController@betweenLeaveHolidays');

    Route::group(['middleware' => ['permission:approve-leave']], function () {
        Route::get('approve-leaves/{leave_status?}', 'LeaveController@approveLeaves');
        Route::post('save-leave-approval', 'LeaveController@saveLeaveApproval');

        Route::get('leave-report-form', 'LeaveController@leaveReportForm');
        Route::post('create-leave-report', 'LeaveController@createLeaveReport');
        Route::get('additional-leave-report-info', 'LeaveController@additionalLeaveReportInfo');
    }); //end of approve-leave group
}); //end of leaves group

Route::group(['prefix'=>'mastertables', 'middleware'=>'App\Http\Middleware\RestrictEmployee'], function () {
    Route::post('check-unique-company', 'MastertableController@checkUniqueCompany');
    Route::post('check-unique-esi-registration', 'MastertableController@checkUniqueEsiRegistration');
    Route::post('check-unique-pt-registration', 'MastertableController@checkUniquePtRegistration');
    Route::post('check-unique-leave-authority', 'MastertableController@checkUniqueLeaveAuthority');

    Route::post('additional-company-info', 'MastertableController@additionalCompanyInfo');
    Route::post('company-tan-pf', 'MastertableController@companyTanPf');
    Route::post('company-pt-certificate-no', 'MastertableController@companyPtCertificateNo');

    Route::post('company-esi-no', 'MastertableController@companyEsiNo');
    Route::post('check-unique-project-contact', 'MastertableController@checkUniqueProjectContact');
    Route::post('check-unique-edit-project-contact', 'MastertableController@checkUniqueEditProjectContact');

    Route::post('states-wise-locations', 'MastertableController@statesWiseLocations');
    Route::post('department-wise-person','MastertableController@departmentsWisePersons');


    Route::any('states/{id?}', 'MastertableController@states')->name('employees.states');
    Route::any('cities/{id?}/', 'MastertableController@cities')->name('employees.cities');
    Route::any('locations/{id?}/', 'MastertableController@locations')->name('employees.locations');
    // Route::get('leave-authorities/{department_id?}','MastertableController@listLeaveAuthorities');
    // Route::get('leave-authorities/{action}/{leave_authority_id}','MastertableController@leaveAuthorityAction');


    //Route::group(['middleware' => ['permission:edit-employee']], function () {
    Route::get('kra', 'MastertableController@listKra');
    Route::get('kra/{action}/{id?}', 'MastertableController@kraAction');
    Route::post('create-kra', 'MastertableController@createKra');
    Route::post('edit-kra-details', 'MastertableController@editKraDetails');
    Route::post('edit-kra', 'MastertableController@editKra');
    Route::get('kra_indicators/{kra_id}', 'MastertableController@listKra');
    //});

    Route::group(['middleware' => ['permission:create-company|edit-company|approve-company']], function () {
        Route::get('companies', 'MastertableController@listCompanies');
        Route::get('companies/{action}/{company_id?}', 'MastertableController@companyAction');
        Route::post('create-company', 'MastertableController@createCompany');
        Route::post('edit-company', 'MastertableController@editCompany');

        Route::get('company-esi-registrations/{company_id}', 'MastertableController@listEsiRegistrations');
        Route::get('add-esi-registration/{company_id}', 'MastertableController@addEsiRegistration');
        Route::get('esi-registrations/{action}/{esi_registration_id}', 'MastertableController@esiRegistrationAction');
        Route::post('save-esi-registration', 'MastertableController@saveEsiRegistration');

        Route::get('company-pt-registrations/{company_id}', 'MastertableController@listPtRegistrations');
        Route::get('add-pt-registration/{company_id}', 'MastertableController@addPtRegistration');
        Route::get('pt-registrations/{action}/{pt_registration_id}', 'MastertableController@ptRegistrationAction');
        Route::post('save-pt-registration', 'MastertableController@savePtRegistration');
    }); //end of Companies group

    Route::group(['middleware' => ['permission:create-project|edit-project|approve-project']], function() {
        Route::get('projects', 'MastertableController@listProjects');
        Route::get('projects/{action}/{project_id?}', 'MastertableController@projectAction');
        Route::post('save-project', 'MastertableController@saveProject');

        Route::get('approved-projects','MastertableController@listApprovedProjects');
        Route::get('approval-projects','MastertableController@listApprovalProjects');
        Route::get('project-jrf/{action}','MastertableController@jrf');
        Route::get('project-it-requirement/{action}/{project_id?}','MastertableController@itRequirement');
        Route::get('project-salary-structure/{action}/{project_id?}','MastertableController@salaryStructure');
        Route::get('project-bg-form/{action}/{project_id?}','MastertableController@bgForm');
        Route::get('project-insurance/{action}/{project_id?}','MastertableController@insuranceForm');
        Route::get('project-advertisements/{action}/{project_id?}','MastertableController@advertisements');


        Route::post('create-project-contact', 'MastertableController@createProjectContact');
        Route::post('edit-project-contact', 'MastertableController@editProjectContact');
        Route::post('additional-project-info', 'MastertableController@additionalProjectInfo');
    }); //end of Projects group
}); //end of Mastertables group


Route::group(['middleware' => 'App\Http\Middleware\RestrictEmployee'],function() {

    Route::resource('bd-team', 'BdTeamController')->only([
        'index', 'create', 'store', 'edit', 'update', 'show'
    ])->names([
        'index'  => 'bd-team.index',
        'create' => 'bd-team.create',
        'store'  => 'bd-team.store',
        'edit'   => 'bd-team.edit',
        'update' => 'bd-team.update',
        'show'   => 'bd-team.show',
    ]);

    Route::any('bd-team/change-status/{id?}', ['as' => 'bd-team.change-status', 'uses' => 'BdTeamController@changeStatus']);

    Route::any('bd-team/remove-member', ['as' => 'bd-team.remove-member', 'uses' => 'BdTeamController@removeMember']);
    // Route::any('bd-team/view/{id?}', ['as' => 'bd-team.view', 'uses' => 'BdTeamController@show']);
    Route::any('leads-management/', ['as' => 'leads-management.index', 'uses' => 'LeadsManagementController@index']);

    Route::any('leads-management/get-leads/', ['as' => 'leads-management.get-leads', 'uses' => 'LeadsManagementController@getLeads']);

    Route::resource('leads-management', 'LeadsManagementController')->only([
        /*'index',*/'create', 'store', 'edit', 'update'
    ])->names([
        /*'index'  => 'leads-management.index',*/
        'create' => 'leads-management.create',
        'store'  => 'leads-management.store',
        'edit'   => 'leads-management.edit',
    ])->except(['index']);

    Route::any('leads-management/view-leads/{id?}', ['as' => 'leads-management.view-leads', 'uses' => 'LeadsManagementController@viewLeads']);

    Route::any('leads-management/view/{id?}', ['as' => 'leads-management.view', 'uses' => 'LeadsManagementController@view']);

    Route::any('leads-management/reject-lead/{id?}', ['as' => 'leads-management.reject-lead', 'uses' => 'LeadsManagementController@rejectLead']);

    Route::any('leads-management/change-lead-status/{id?}', ['as' => 'leads-management.change-lead-status', 'uses' => 'LeadsManagementController@changeLeadStatus']);

    Route::any('leads-management/list-action', ['as' => 'leads-management.list-action', 'uses' => 'LeadsManagementController@listAction']);

    Route::any('leads-management/lead-approval', ['as' => 'leads-management.lead-approval', 'uses' => 'LeadsManagementController@leadApproval']);

    Route::any('leads-management/approve-lead', ['as' => 'leads-management.approve-lead', 'uses' => 'LeadsManagementController@approveLead']);

    Route::any('leads-management/list-til/{id?}', ['as' => 'leads-management.list-til', 'uses' => 'LeadsManagementController@listTil']);

    Route::any('leads-management/get-list-til/{id?}', ['as' => 'leads-management.get-list-til', 'uses' => 'LeadsManagementController@getListTil']);

    Route::any('leads-management/list-closed-tils', ['as' => 'leads-management.list-closed-tils', 'uses' => 'LeadsManagementController@listClosedTils']);

    Route::any('leads-management/mark-filed', ['as' => 'leads-management.mark-filed', 'uses' => 'LeadsManagementController@markTilFiled']);
    /*====================================================================================================*/
    Route::any('leads-management/til-remarks-list/{id?}', ['as' => 'leads-management.til-remarks-list', 'uses' => 'LeadsManagementController@tilRemarksList']);

    Route::any('leads-management/view-til-remarks/{id?}', ['as' => 'leads-management.view-til-remarks', 'uses' => 'LeadsManagementController@viewTilRemarks']);

    Route::any('leads-management/save-til-remarks/{id?}', ['as' => 'leads-management.save-til-remarks', 'uses' => 'LeadsManagementController@saveTilRemarks']);

    Route::any('leads-management/get-employees/', ['as' => 'leads-management.get-employees', 'uses' => 'LeadsManagementController@getDepartmentWiseEmployees']);
    /*====================================================================================================*/
    Route::any('leads-management/view-til/{id?}', ['as' => 'leads-management.view-til', 'uses' => 'LeadsManagementController@viewTil']);

    Route::any('leads-management/til/show/{id?}', ['as' => 'leads-management.show-til', 'uses' => 'LeadsManagementController@showTil']);

    Route::any('leads-management/create-til/{id?}', ['as' => 'leads-management.create-til', 'uses' => 'LeadsManagementController@createTil']);

    Route::any('leads-management/save-til/{id?}', ['as' => 'leads-management.save-til', 'uses' => 'LeadsManagementController@saveTil']);

    Route::any('leads-management/edit-til/{id?}', ['as' => 'leads-management.edit-til', 'uses' => 'LeadsManagementController@editTil']);

    Route::any('leads-management/update-til/{id?}', ['as' => 'leads-management.update-til', 'uses' => 'LeadsManagementController@updateTil']);

    Route::any('leads-management/til-approval', ['as' => 'leads-management.til-approval', 'uses' => 'LeadsManagementController@tilApproval']);

    Route::any('leads-management/assign-til', ['as' => 'leads-management.assign-til', 'uses' => 'LeadsManagementController@assignTil']);

    Route::any('leads-management/mark-editable', ['as' => 'leads-management.mark-editable', 'uses' => 'LeadsManagementController@markTilEditable']);

    Route::any('leads-management/delete-contact/{id?}', ['as' => 'leads-management.delete-contact', 'uses' => 'LeadsManagementController@deleteContact']);

    Route::any('leads-management/delete-eligibility/{id?}', ['as' => 'leads-management.delete-eligibility', 'uses' => 'LeadsManagementController@deleteEligibility']);

    Route::any('leads-management/delete-technical-qualification/{id?}', ['as' => 'leads-management.delete-technical-qualification', 'uses' => 'LeadsManagementController@deleteTechnicalQualification']);

    Route::any('leads-management/delete-til-penalties/{id?}', ['as' => 'leads-management.delete-til-penalties', 'uses' => 'LeadsManagementController@deleteTilPenalties']);

    Route::any('leads-management/delete-obligation/{id?}', ['as' => 'leads-management.delete-obligation', 'uses' => 'LeadsManagementController@deleteObligation']);

    Route::any('leads-management/opportunity-progress-status', ['as' => 'leads-management.opportunity-progress-status', 'uses' => 'LeadsManagementController@opportunityProgressStatus']);

    Route::any('leads-management/unassign-user/{id?}', ['as' => 'leads-management.unassign-user', 'uses' => 'LeadsManagementController@unassignUser']);

    Route::any('leads-management/unassined-leads/', ['as' => 'leads-management.unassined-leads', 'uses' => 'LeadsManagementController@unassinedLeads']);

    Route::any('leads-management/unassign-user-til/{id?}', ['as' => 'leads-management.unassign-user-til', 'uses' => 'LeadsManagementController@unassignUserTil']);

    Route::any('leads-management/unassined-tils/', ['as' => 'leads-management.unassined-tils', 'uses' => 'LeadsManagementController@unassinedTils']);

    Route::get('leads-management/get-comments/', ['as' => 'leads-management.get-comments', 'uses' => 'LeadsManagementController@getComments']);

    Route::any('leads-management/follow-up', ['as' => 'leads-management.follow-up', 'uses' => 'LeadsManagementController@followUp']);
    /*====================29-07-2020====================================================*/
    Route::any('leads-management/tender-processing', ['as' => 'leads-management.tender-processing', 'uses' => 'LeadsManagementController@tenderProcessing']);

    Route::any('leads-management/til-documents/{id?}', ['as' => 'leads-management.til-documents', 'uses' => 'LeadsManagementController@tilDocuments']);

    Route::any('leads-management/assign-til-document/{til_id?}', ['as' => 'leads-management.assign-til-document', 'uses' => 'LeadsManagementController@assignTilDocument']);

    Route::any('leads-management/assigned-costestimation/{til_id?}', ['as' => 'leads-management.assigned-costestimation', 'uses' => 'LeadsManagementController@assignedCostestimation']);

    Route::any('leads-management/costestimation-approval', ['as' => 'leads-management.costestimation-approval', 'uses' => 'LeadsManagementController@costestimationApproval']);
    /************************************************************************************/
    Route::get('leads-management/estimation/{til_draft_id?}', ['as' => 'leads-management.estimation', 'uses' => function(Request $request, $tilDraftId = null) {

        $tilDraftId = (empty($tilDraftId))? $request->til_draft_id : $tilDraftId;

        if(!is_numeric($request->no_of_posts) || $request->no_of_posts < 1 || empty($tilDraftId))
        {
            abort(404, 'Error: in the key, try again.');
        }
        return redirect('leads-management/cost-estimation/'.$tilDraftId.'?key=' . encrypt($request->no_of_posts));
    }]);

    Route::any('leads-management/cost-estimation/{til_draft_id?}', ['as' => 'leads-management.cost-estimation', 'uses' => 'LeadsManagementController@costEstimation']);

    Route::any('leads-management/save-cost-estimation', ['as' => 'leads-management.save-cost-estimation', 'uses' => 'LeadsManagementController@saveCostEstimation']);

    Route::any('leads-management/view-cost-estimation/{til_draft_id?}', ['as' => 'leads-management.view-cost-estimation', 'uses' => 'LeadsManagementController@viewCostEstimation']);

    Route::any('leads-management/get-estimation/{til_draft_id?}', ['as' => 'leads-management.get-estimation', 'uses' => 'LeadsManagementController@getCostEstimation']);
    /************************************************************************************/
    /*====================29-07-2020====================================================*/

    Route::get('leads-management/create-pre-bid', 'LeadsManagementController@createPreBid');
    Route::post('leads-management/store-pre-bid', 'LeadsManagementController@storePreBid');
});//end of Lead Management routes
/*Route::group(['prefix' => 'leads', 'middleware' => 'App\Http\Middleware\RestrictEmployee'], function () {
    Route::get('create-lead', function () {
        return view('leads.create_lead_form');
    });
    Route::get('leads', function () {
        return view('leads.list_leads');
    });
    Route::get('approve-lead', function () {
        return view('leads.list_lead_approvals');
    });
    Route::get('create-til', function () {
        return view('leads.til_form');
    });
    Route::get('opportunity-progress-status', function () {
        return view('leads.opportunity_progress_status');
    });
    Route::get('follow-up', function () {
        return view('leads.follow_up');
    });
}); //end of business development group*/

//Route::middleware('App\Http\Middleware\RestrictEmployee')->group(function () {
//    Route::resource('dms-categories', 'DmsCategoryController', ['names' => 'dms.category']);
//    Route::resource('dms-keywords', 'DmsKeywordController', ['names' => 'dms.keyword']);
//
//    Route::get('dms-documents/my-documents', 'DmsDocumentController@myDocuments')->name('dms.document.my.documents');
//    Route::resource('dms-documents', 'DmsDocumentController', ['names' => 'dms.document']);
//    Route::get('dms-documents/{document}/download', 'DmsDocumentController@download')->name('dms.document.download');
//    Route::post('dms-documents/department/employee', 'DmsDocumentController@departmentEmployee')->name('dms.document.department.employee');
//    Route::post('dms-documents/department/filter', 'DmsDocumentController@filter')->name('dms.document.filter');
//    Route::get('dms-documents/{dmsDocument}/{document}/remove', 'DmsDocumentController@removeDocument')->name('dms.document.remove');
//
//    Route::resource('payroll/salary-heads', 'SalaryHeadController', ['names' => 'payroll.salary.head']);
//    Route::resource('payroll/salary-cycles', 'SalaryCycleController', ['names' => 'payroll.salary.cycle']);
//    Route::resource('payroll/pt-rates', 'PtRateController', ['names' => 'payroll.pt.rate']);
//
//    Route::get('payroll/pfs/calculate-pf', 'PfController@calculatePfForm')->name('payroll.pf.calculate.form');
//    Route::post('payroll/pfs/calculate-pf', 'PfController@calculatePf')->name('payroll.pf.calculate');
//    Route::resource('payroll/pfs', 'PfController', ['names' => 'payroll.pf']);
//    Route::post('payroll/pfs/make-active', 'PfController@makeActive')->name('payroll.pf.make.active');
//
//    Route::get('payroll/esi/calculate-esi', 'EsiController@calculateEsiForm')->name('payroll.esi.calculate.form');
//    Route::post('payroll/esi/calculate-esi', 'EsiController@calculateEsi')->name('payroll.esi.calculate');
//    Route::resource('payroll/esi', 'EsiController', ['names' => 'payroll.esi']);
//    Route::post('payroll/esi/make-active', 'EsiController@makeActive')->name('payroll.esi.make.active');
//
//    Route::post('payroll/salary-structures/salary-heads', 'SalaryStructureController@salaryHeads')->name('payroll.salary.structure.salary.heads');
//
//    Route::get('payroll/salary-structures/save', 'SalaryStructureController@save')->name('payroll.salary.structure.save');
//    Route::resource('payroll/salary-structures', 'SalaryStructureController', ['names' => 'payroll.salary.structure']);
//    Route::post('payroll/salary-structures/project-cycles', 'SalaryStructureController@projectSalaryCycle')->name('payroll.salary.structure.salary.cycles');
//
//});

Route::middleware('App\Http\Middleware\RestrictEmployee')->group(function () {

    Route::resource('dms-categories', 'DmsCategoryController', ['names' => 'dms.category']);
    Route::resource('dms-keywords', 'DmsKeywordController', ['names' => 'dms.keyword']);
    Route::get('dms-documents/my-documents', 'DmsDocumentController@myDocuments')->name('dms.document.my.documents');
    Route::resource('dms-documents', 'DmsDocumentController', ['names' => 'dms.document']);
    Route::get('dms-documents/{document}/download', 'DmsDocumentController@download')->name('dms.document.download');

    Route::get('dms-documents/{document}/view', 'DmsDocumentController@viewDoc')->name('dms.document.view');

   // Route::get('dms-documents/{document}/mm', 'DmsDocumentController@viewTestDoc')->name('dms.document.mm');


    Route::post('dms-documents/department/employee', 'DmsDocumentController@departmentEmployee')->name('dms.document.department.employee');
    Route::post('dms-documents/department/filter', 'DmsDocumentController@filter')->name('dms.document.filter');
    Route::get('dms-documents/{dmsDocument}/{document}/remove', 'DmsDocumentController@removeDocument')->name('dms.document.remove');

    Route::get('approve-dms/{dms_status?}', 'DmsDocumentController@approveDms');
    Route::post('save-approve-dms-approval', 'DmsDocumentController@saveDmsApproval');
    Route::post('save-dms-request', 'DmsDocumentController@saveDmsRequest');
    Route::get('document-requests/{dms_status?}', 'DmsDocumentController@DmsRequest');
    Route::post('save-dms-request-approval', 'DmsDocumentController@saveDmsRequestApproval');
    Route::get('requested-documents', 'DmsDocumentController@RequestedDocuments');
    Route::get('document-cancel/{document_id}', 'DmsDocumentController@cancelDocument');
    Route::get('my-documents-received', 'DmsDocumentController@MyDocumentsReceived');
    Route::get('revoke-requested-documents', 'DmsDocumentController@RevokeDocuments');
    Route::get('document-revoke/{document_id}/{user_id}', 'DmsDocumentController@RevokeDocumentsCancel');

    Route::resource('payroll/salary-heads', 'SalaryHeadController', ['names' => 'payroll.salary.head']);
    Route::resource('payroll/salary-cycles', 'SalaryCycleController', ['names' => 'payroll.salary.cycle']);
    Route::resource('payroll/pt-rates', 'PtRateController', ['names' => 'payroll.pt.rate']);

    Route::get('payroll/pfs/calculate-pf', 'PfController@calculatePfForm')->name('payroll.pf.calculate.form');
    Route::post('payroll/pfs/calculate-pf', 'PfController@calculatePf')->name('payroll.pf.calculate');
    Route::resource('payroll/pfs', 'PfController', ['names' => 'payroll.pf']);
    Route::post('payroll/pfs/make-active', 'PfController@makeActive')->name('payroll.pf.make.active');

    Route::get('payroll/esi/calculate-esi', 'EsiController@calculateEsiForm')->name('payroll.esi.calculate.form');
    Route::post('payroll/esi/calculate-esi', 'EsiController@calculateEsi')->name('payroll.esi.calculate');
    Route::resource('payroll/esi', 'EsiController', ['names' => 'payroll.esi']);
    Route::post('payroll/esi/make-active', 'EsiController@makeActive')->name('payroll.esi.make.active');

    Route::post('payroll/salary-structures/salary-heads', 'SalaryStructureController@salaryHeads')->name('payroll.salary.structure.salary.heads');
    Route::get('payroll/salary-structures/save', 'SalaryStructureController@save')->name('payroll.salary.structure.save');
    Route::resource('payroll/salary-structures', 'SalaryStructureController', ['names' => 'payroll.salary.structure']);
    Route::post('payroll/salary-structures/project-cycles', 'SalaryStructureController@projectSalaryCycle')->name('payroll.salary.structure.salary.cycles');

//    Route::resource('payroll/salary-sheets', 'SalarySheetController', ['names' => 'payroll.salary.sheet']);

    Route::get('payroll/salary-sheets', 'SalarySheetController@index')->name('payroll.salary.sheet.index');
    Route::get('payroll/salary-sheets/reports', 'SalarySheetController@report')->name('payroll.salary.sheet.report');

    Route::get('payroll/salary-sheets/create', 'SalarySheetController@create')->name('payroll.salary.sheet.create');
    Route::post('payroll/salary-sheets/store', 'SalarySheetController@store')->name('payroll.salary.sheet.store');
    Route::post('payroll/salary-sheets/{id}/destroy', 'SalarySheetController@destroy')->name('payroll.salary.sheet.destroy');
    Route::post('payroll/salary-sheets/filter', 'SalarySheetController@filter')->name('payroll.salary.sheet.filter');
    Route::post('payroll/salary-sheets/export', 'SalarySheetController@export')->name('payroll.salary.sheet.export');
    Route::post('payroll/salary-sheets/pay', 'SalarySheetController@pay')->name('payroll.salary.sheet.pay');
    Route::post('payroll/salary-sheets/extra-income', 'SalarySheetController@extraIncomeDeduction')->name('payroll.salary.sheet.extra.income');
    Route::get('payroll/salary-sheets/{year}/{month}/{project}/{department?}', 'SalarySheetController@salarySheets')->name('payroll.salary.sheets');

    Route::resource('payroll/lwfs', 'LwfController', ['names' => 'payroll.lwf']);

    Route::resource('conveyances', 'ConveyanceController', ['names' => 'conveyance']);
    Route::post('conveyances/make-active', 'ConveyanceController@makeActive')->name('conveyance.make.active');
});
