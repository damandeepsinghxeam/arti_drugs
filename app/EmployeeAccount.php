<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeAccount extends Model
{
    protected $guarded = [];

    function user()
    {
    	return $this->belongsTo('App\User');
    }

    function bank()
    {
    	return $this->belongsTo('App\Bank');
    }

    function logDetails()
    {
        return $this->morphMany('App\LogDetail', 'log_detailable');
    }
}
