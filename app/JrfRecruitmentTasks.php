<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JrfRecruitmentTasks extends Model
{
    protected $guarded = [];
    protected $table = 'jrf_recruitment_tasks';

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