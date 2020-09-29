<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppliedLeave extends Model
{
    protected $guarded = [];

    function user()
    {
    	return $this->belongsTo('App\User');
    }

    function appliedLeaveApprovals()
    {
    	return $this->hasMany('App\AppliedLeaveApproval');
    }

    function appliedLeaveDocuments()
    {
    	return $this->hasMany('App\AppliedLeaveDocument');
    }

    function appliedLeaveSegregations()
    {
    	return $this->hasMany('App\AppliedLeaveSegregation');
    }

    function leaveReplacement()
    {
    	return $this->hasOne('App\LeaveReplacement');
    }

    function notifications()
    {
        return $this->morphMany('App\Notification', 'notificationable');
    }

    function messages()
    {
        return $this->morphMany('App\Message', 'messageable');
    }

    function leaveType()
    {
        return $this->belongsTo('App\LeaveType');
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
}
