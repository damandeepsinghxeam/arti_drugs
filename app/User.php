<?php

namespace App;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, HasRoles;
    
    protected $hidden = [
        'password', 'remember_token',
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    function employee()
    {
    	return $this->hasOne('App\Employee');
    }

    function documents()
    {
        return $this->belongsToMany('App\Document')->withTimestamps()->withPivot('name');
    }

    function perks()
    {
        return $this->belongsToMany('App\Perk')->where('perk_user.isactive', 1)->withTimestamps();
    }

    function locations()
    {
        return $this->belongsToMany('App\Location')->where('location_user.isactive', 1)->withTimestamps();
    }

    function qualifications()
    {
        return $this->belongsToMany('App\Qualification')->where('qualification_user.isactive', 1)->withTimestamps()->withPivot('filename');
    }

    function skills()
    {
        return $this->belongsToMany('App\Skill')->where('skill_user.isactive', 1)->withTimestamps();
    }

    function projects()
    {
        return $this->belongsToMany('App\Project')->where('project_user.isactive', 1)->withTimestamps();
    }

    function languages()
    {
        return $this->belongsToMany('App\Language')->where('language_user.isactive', 1)->withTimestamps()->withPivot('read_language','write_language','speak_language');
    }

    function employeeProfile()
    {
        return $this->hasOne('App\EmployeeProfile');
    }

    function employeeAccount()
    {
        return $this->hasOne('App\EmployeeAccount');
    }

    function employmentHistories()
    {
        return $this->hasMany('App\EmploymentHistory');
    }

    function employeeSecurity()
    {
        return $this->hasOne('App\EmployeeSecurity');
    }

    function employeeReferences()
    {
        return $this->hasMany('App\EmployeeReference');
    }

    function employeeReferral()
    {
        return $this->hasOne('App\EmployeeReferral');
    }

    function employeeAddresses()
    {
        return $this->hasMany('App\EmployeeAddress');
    }

    function userManager()
    {
        return $this->hasOne('App\UserManager');
    }

    function leaveAuthorities()
    {
        return $this->hasMany('App\LeaveAuthority');
    }

    function appliedLeaves()
    {
        return $this->hasMany('App\AppliedLeave');
    }

    function appliedLeaveApprovals()
    {
        return $this->hasMany('App\AppliedLeaveApproval');
    }

    function compensatoryLeaves()
    {
        return $this->hasMany('App\CompensatoryLeave');
    }

    function attendances()
    {
        return $this->hasMany('App\Attendance');
    }

    function attendanceRemarks()
    {
        return $this->hasMany('App\AttendanceRemark');
    }

    function attendanceResults()
    {
        return $this->hasMany('App\AttendanceResult');
    }

    function attendanceVerifications()
    {
        return $this->hasMany('App\AttendanceVerification');
    }

    function designation()
    {
        return $this->belongsToMany('App\Designation')->where('designation_user.isactive', 1);
    }

    function approval()
    {
        return $this->morphOne('App\Approval','approvalable');
    } 

    function logDetails()
    {
        return $this->morphMany('App\LogDetail', 'log_detailable');
    }

    function attendanceChanges()
    {
        return $this->hasMany('App\AttendanceChange');
    }
    
    function attendanceChangeDates()
    {
        return $this->hasMany('App\AttendanceChangeDate');
    }

    function taskProjects()
    {
        return $this->hasMany('App\TaskProject');
    }

    function tasks()
    {
        return $this->hasMany('App\Task');
    }

    function taskUpdates()
    {
        return $this->hasMany("App\TaskUpdate");
    }

    function attendanceLocations()
    {
        return $this->hasMany('App\AttendanceLocation');
    }

    function taskUsers()
    {
        return $this->hasMany('App\TaskUser');
    }

    function emailContents()
    {
        return $this->hasMany('App\EmailContent');
    }

    function printDocument(){

        return $this->hasOne('App\PrintDocument');
    }

    //kra
    function employeeKra()
    {
        return $this->hasMany('App\EmployeeKra');
    }


    // JRF //
   
    
    function jrf(){

        return $this->hasOne('App\Jrf');
    }

    function jrfapprovals()
    {
        return $this->hasMany('App\JrfApprovals');
    }

    function jrfRecruitmentTasks()
    {
        return $this->hasMany('App\JrfRecruitmentTasks','assigned_by');
    }

    function jrfInterviewerDetail(){

        return $this->hasMany('App\JrfInterviewerDetail');
    }

    function jrfLevelOneScreening(){

        return $this->hasOne('App\JrfLevelOneScreening');
    }
    
    // END JRF //
    
}//end of class
