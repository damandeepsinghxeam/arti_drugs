<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DmsRequests extends Model
{
	    protected $guarded = [];

    function Docrequests()
    {
        return $this->belongsTo('App\DmsDocument');
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
