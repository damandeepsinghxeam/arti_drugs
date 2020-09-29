<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompensatoryLeave extends Model
{
    protected $guarded = [];

    function user()
    {
    	return $this->belongsTo('App\User');
    }

    function leaveType()
    {
    	return $this->belongsTo('App\LeaveType');
    }
}
