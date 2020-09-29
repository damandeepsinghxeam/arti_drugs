<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskUpdate extends Model
{
    protected $guarded = [];

    function task()
    {
        return $this->belongsTo("App\Task");
    }

    function user()
    {
        return $this->belongsTo("App\User");
    }
}
