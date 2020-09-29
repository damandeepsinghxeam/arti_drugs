<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmploymentHistory extends Model
{
    protected $guarded = [];

    function user()
    {
    	return $this->belongsTo('App\User');
    }

    function logDetails()
    {
        return $this->morphMany('App\LogDetail', 'log_detailable');
    }

}
