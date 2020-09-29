<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeProfile extends Model
{
    protected $guarded = [];

    function user()
    {
    	return $this->belongsTo('App\User');
    }

    function state()
    {
    	return $this->belongsTo('App\State');
    }

    function department()
    {
    	return $this->belongsTo('App\Department');
    }

    function shift()
    {
    	return $this->belongsTo('App\Shift');
    }

    function probationPeriod()
    {
    	return $this->belongsTo('App\ProbationPeriod');
    }

    function logDetails()
    {
        return $this->morphMany('App\LogDetail', 'log_detailable');
    }
}
