<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AttendanceChangeDate extends Model
{
    protected $guarded = [];

    function user()
    {
        return $this->belongsTo('App\User');
    }

    function attendanceChange()
    {
        return $this->belongsTo('App\AttendanceChange');
    }
}
