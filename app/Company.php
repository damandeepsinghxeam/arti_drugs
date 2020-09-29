<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $guarded = [];

    function creator()
    {
    	return $this->belongsTo('App\User','creator_id');
    }
    function company_group()
    {
        return $this->belongsTo('App\CompanyGroup');
    }

    function projects()
    {
        return $this->hasMany('App\Project');
    }

    function esiRegistrations()
    {
    	return $this->hasMany('App\EsiRegistration');
    }

    function ptRegistrations()
    {
    	return $this->hasMany('App\PtRegistration');
    }

    function logDetails()
    {
        return $this->morphMany('App\LogDetail', 'log_detailable');
    }

    function notifications()
    {
        return $this->morphMany('App\Notification', 'notificationable');
    }

    function approval()
    {
        return $this->morphOne('App\Approval','approvalable');
    }
    
}//end of class
