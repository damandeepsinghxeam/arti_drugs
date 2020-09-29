<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $guarded = [];

    function user()
    {
    	return $this->belongsTo('App\User');
    }

    function creator()
    {
        return $this->belongsTo('App\User','creator_id');
    }

    function logDetails()
    {
        return $this->morphMany('App\LogDetail', 'log_detailable');
    }

    function documents()
    {
        return $this->belongsToMany('App\DmsDocument');
    }

}//end of class
