<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $guarded = [];

    function notificationable()
    {
        return $this->morphTo();
    }

    function sender()
    {
    	return $this->belongsTo('App\User','sender_id');
    }

    function receiver()
    {
    	return $this->belongsTo('App\User','receiver_id');
    }
}//end of class
