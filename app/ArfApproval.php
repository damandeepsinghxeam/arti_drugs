<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArfApproval extends Model
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

    function messages()
    {
        return $this->morphMany('App\Message', 'messageable');
    }

}