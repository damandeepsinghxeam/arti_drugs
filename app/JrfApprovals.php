<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JrfApprovals extends Model
{
    protected $guarded = [];

    function user()
    {
    	return $this->belongsTo('App\User');
    }

    function jrf(){

        return $this->hasOne('App\Jrf');
    }

    function notifications()
    {
        return $this->morphMany('App\Notification', 'notificationable');
    }

    function appliedJrf()
    {
        return $this->belongsTo('App\AppliedJrf');
    }

    function messages()
    {
        return $this->morphMany('App\Message', 'messageable');
    }

    function JrfApprovals(){

        return $this->hasMany('App\JrfApprovals');
    }

}