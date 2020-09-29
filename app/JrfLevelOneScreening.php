<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JrfLevelOneScreening extends Model
{

    protected $guarded 		= [];
    protected $table	 	= 'jrf_level_one_screenings';



    function levelOneScreeningSkill()
    {
        return $this->belongsToMany('App\Skill')->where('jrf_level_one_screening_skill.isactive', 1)->withTimestamps();
    }

    function levelOneScreeningQualification()
    {
        return $this->belongsToMany('App\Qualification')->where('jrf_level_one_screening_qualification.isactive', 1)->withTimestamps()->withPivot('filename');
    }

    function levelOneScreeninglanguages()
    {
        return $this->belongsToMany('App\Language')->where('jrf_level_one_screening_language.isactive', 1)->withTimestamps()->withPivot('read_language','write_language','speak_language');
    }

    function JrfInterviewerDetail(){

        return $this->hasMany('App\JrfInterviewerDetail');
    }


    function jrfLevelTwoScreening(){

        return $this->hasOne('App\JrfLevelTwoScreening');
    }

    function notifications()
    {
        return $this->morphMany('App\Notification', 'notificationable');
    }

    function jrfLevelOneScreening(){

        return $this->hasOne('App\JrfLevelOneScreening');
    }


    function finalAppointmentApproval(){

        return $this->hasOne('App\FinalAppointmentApproval');
    }



}