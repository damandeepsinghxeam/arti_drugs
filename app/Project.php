<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $guarded = [];

    function creator()
    {
    	return $this->belongsTo('App\User','creator_id');
    }

    function salaryStructure()
    {
        return $this->belongsTo('App\SalaryStructure');
    }

    function salaryCycle()
    {
        return $this->hasOne('App\SalaryCycle');
    }

    function company()
    {
    	return $this->belongsTo('App\Company');
    }

    function logDetails()
    {
        return $this->morphMany('App\LogDetail', 'log_detailable');
    }

    function approval()
    {
        return $this->morphOne('App\Approval','approvalable');
    }

    function notifications()
    {
        return $this->morphMany('App\Notification', 'notificationable');
    }

    function states()
    {
        return $this->belongsToMany('App\State')->withTimestamps();
    }

    function locations()
    {
        return $this->belongsToMany('App\Location')->withTimestamps();
    }

    function documents()
    {
        return $this->belongsToMany('App\Document')->withTimestamps()->withPivot('name');
    }

    function projectResponsiblePersons()
    {
    	return $this->hasMany('App\ProjectResponsiblePerson');
    }

    function projectContacts()
    {
    	return $this->hasMany('App\ProjectContact');
    }

    function users()
    {
        return $this->belongsToMany('App\User')->withTimestamps();
    }

    function salaryStructures()
    {
        return $this->hasMany('App\SalaryStructure');
    }

}//end of class
