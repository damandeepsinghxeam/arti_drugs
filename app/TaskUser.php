<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskUser extends Model
{
    protected $guarded = [];

    function user()
    {
        return $this->belongsTo('App\User');
    }

    function task()
    {
        return $this->belongsTo('App\Task');
    }
}
