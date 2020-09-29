<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $guarded = [];

    function user()
    {
        return $this->belongsTo('App\User');
    }

    function taskProject()
    {
        return $this->belongsTo('App\TaskProject');
    }

    function taskFiles()
    {
        return $this->hasMany('App\TaskFile');
    }

    function taskUser()
    {
        return $this->hasOne('App\TaskUser');
    }

    function notifications()
    {
        return $this->morphMany('App\Notification', 'notificationable');
    }

    function messages()
    {
        return $this->morphMany('App\Message','messageable');
    }

    function taskUpdates()
    {
        return $this->hasMany("App\TaskUpdate");
    }
}
