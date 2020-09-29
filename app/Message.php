<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $guarded = [];

    function messageable()
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

    function messageAttachments()
    {
        return $this->hasMany('App\MessageAttachment');
    }
}//end of class
