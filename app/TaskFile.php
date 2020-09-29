<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskFile extends Model
{
    protected $guarded = [];

    function task()
    {
        return $this->belongsTo('App\Task');
    }
}
