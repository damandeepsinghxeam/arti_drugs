<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $guarded = [];

    function user()
    {
    	return $this->belongsTo('App\User');
    }

    function attendancePunches()
    {
    	return $this->hasMany('App\AttendancePunch');
    }
}
