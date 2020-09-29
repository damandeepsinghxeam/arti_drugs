<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppliedJrf extends Model
{
    protected $guarded = [];

    function user()
    {
    	return $this->belongsTo('App\User');
    }

    function jrf(){

        return $this->hasOne('App\Jrf');
    }

    function jrfApprovals()
    {
    	return $this->hasMany('App\JrfApprovals');
    }

    function notifications()
    {
        return $this->morphMany('App\Notification', 'notificationable');
    }

    function messages()
    {
        return $this->morphMany('App\Message', 'messageable');
    }

    function MgmtDtApprovals()
    {
        return $this->hasMany('App\MgmtDtApprovals');
    }

}