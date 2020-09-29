<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AttendancePunch extends Model
{
    protected $guarded = [];

    function attendance()
    {
    	return $this->belongsTo('App\Attendance');
    }
}
