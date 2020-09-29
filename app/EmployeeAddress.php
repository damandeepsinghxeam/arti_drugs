<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeAddress extends Model
{
    protected $guarded = [];

    function user()
    {
    	return $this->belongsTo('App\User');
    }

    function country()
    {
    	return $this->belongsTo('App\Country');
    }

    function state()
    {
    	return $this->belongsTo('App\State');
    }

    function city()
    {
    	return $this->belongsTo('App\City');
    }

    function logDetails()
    {
        return $this->morphMany('App\LogDetail', 'log_detailable');
    }
}
