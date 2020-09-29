<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AttendanceChange extends Model
{
    protected $guarded = [];

    function user()
    {
        return $this->belongsTo('App\User');
    }

    function attendanceChangeDates()
    {
        return $this->hasMany('App\AttendanceChangeDate');
    }

    function attendanceChangeApprovals()
    {
        return $this->hasMany('App\AttendanceChangeApproval');
    }

    function notifications()
    {
        return $this->morphMany('App\Notification', 'notificationable');
    }

    function messages()
    {
        return $this->morphMany('App\Message', 'messageable');
    }
}
