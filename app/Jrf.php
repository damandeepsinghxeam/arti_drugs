<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jrf extends Model
{
    protected $guarded = [];
    protected $table = 'jrfs';

	function user()
    {
    	return $this->belongsTo('App\User');
    }

    function jrf(){

        return $this->hasOne('App\Jrf');
    }

    function jrfRecruitmentTasks(){

        return $this->hasMany('App\JrfRecruitmentTasks');
    }

    // function JrfInterviewerDetail(){
    
    //     return $this->hasMany('App\JrfInterviewerDetail');
    // }

    function jrfapprovals(){

        return $this->hasMany('App\JrfApprovals');
    }

    function JrfHierarchy(){

        return $this->hasMany('App\JrfHierarchy');
    }

    function employee()
    {
    	return $this->hasOne('App\Employee');
    }

    function department()
    {
    	return $this->hasOne('App\Department');
    }

    function userManager()
    {
        return $this->hasOne('App\UserManager');
    }

    function notifications()
    {
        return $this->morphMany('App\Notification', 'notificationable');
    }

    function jrfCity()
    {
        return $this->belongsToMany('App\City')->withTimestamps();
    }

    function jrfQualifications()
    {
        return $this->belongsToMany('App\Qualification')->withTimestamps();
    }

    function jrfSkills()
    {
        return $this->belongsToMany('App\Skill')->withTimestamps();
    }

    function arfapproval(){

        return $this->hasMany('App\ArfApproval');
    }

    function jrfBnifitPerks()
    {
        return $this->belongsToMany('App\BenifitPerks');
    }

    function MgmtDtApprovals(){

        return $this->hasMany('App\MgmtDtApprovals');
    }


}