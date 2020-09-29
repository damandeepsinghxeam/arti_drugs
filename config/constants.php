<?php

return [

    'uploadPaths' => [
        'uploadPic' => public_path()."/uploads/profile-pics/",
        'uploadDocument' => public_path()."/uploads/documents/",
        'uploadProjectDocument' => public_path()."/uploads/project-documents/",
        'uploadQualificationDocument' => public_path()."/uploads/qualification-documents/",
        'uploadAppliedLeaveDocument' => public_path()."/uploads/applied-leave-documents/",
        'uploadTaskDocument' => public_path()."/uploads/task-documents/",
        'uploadMessageAttachment' => public_path()."/uploads/message-attachments/",
        'uploadAttendancePic' => public_path()."/uploads/attendance-locations/",
        'profilePic' => env('APP_URL')."/uploads/profile-pics/",
        'document' => env('APP_URL')."/uploads/documents/",
        'projectDocument' => env('APP_URL')."/uploads/project-documents/",
        'qualificationDocument' => env('APP_URL')."/uploads/qualification-documents/",
        'appliedLeaveDocument' => env('APP_URL')."/uploads/applied-leave-documents/",
        'taskDocument' => env('APP_URL')."/uploads/task-documents/",
        'messageAttachment' => env('APP_URL')."/uploads/message-attachments/",
        'attendancePic' => env('APP_URL')."/uploads/attendance-locations/",

        'leadDocuments' => public_path() . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'lead_documents' . DIRECTORY_SEPARATOR,
        'leadDocumentPath' => '/uploads/lead_documents/',

        'leadComments' => public_path() . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'lead_comments' . DIRECTORY_SEPARATOR,
        'leadCommentPath' => '/uploads/lead_comments/',

        'tilDocument' => public_path() . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'til_document' . DIRECTORY_SEPARATOR,
        'tilDocumentPath' => '/uploads/til_document/',
        'uploadCandidateImage' => public_path()."/uploads/level_one_candidate_profile/",
        'uploadCandidateResume' => public_path()."/uploads/level_one_candidate_profile/Resume/",
        'uploadJrfDocument' => public_path()."/uploads/jrf/",
        
        'claimDocument' => public_path() . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'claim_document' . DIRECTORY_SEPARATOR,
        'claimDocumentPath' => '/uploads/claim_document/',
        'uploadJoiningDocument' => public_path()."/uploads/jrf_joining_letter/",
    ],

    'static' => [
        'profilePic' => env('APP_URL')."/admin_assets/static_assets/userPic.png",
        'loginBg' => env('APP_URL')."/admin_assets/static_assets/loginBg.jpg",
        'xeamLogo' => env('APP_URL')."/admin_assets/static_assets/xeamlogo.png",
    ],

    'restriction' => [
        'applyLeave' => date("Y-m-06"), //No Apply leave/attendance of previous month after this date  send change req
        'approveLeave' => date("Y-m-06"), //No Approve leave/attendance of previous month after this date  
        'checkAbsentCron' => date("Y-m-06"), //Hit cron on this date  
        'verifyAttendanceButton' => "Y-m-06" //Show verify attendance button  
    ],
];