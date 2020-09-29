<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $guarded = [];

    function country()
    {
    	return $this->belongsTo('App\Country');
    }

    function cities()
    {
    	return $this->hasMany('App\City');
    }

    function locations()
    {
    	return $this->hasMany('App\Location');
    }

    function ptRegistrations()
    {
        return $this->hasMany('App\PtRegistration');
    }

    function projects()
    {
        return $this->belongsToMany('App\Project')->withTimestamps();
    }

    function ptRates()
    {
        return $this->hasMany('App\PtRate');
    }
}
