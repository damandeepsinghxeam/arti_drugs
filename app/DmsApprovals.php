<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DmsApprovals extends Model
{
    protected $guarded = [];
    
    function user()
    {
    	return $this->belongsTo('App\User');
    }

    function DmsDocument(){

        return $this->hasOne('App\DmsDocument');
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