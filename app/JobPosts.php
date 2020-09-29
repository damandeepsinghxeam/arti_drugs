<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobPosts extends Model
{
    protected $guarded = [];

    protected $table = 'job_post';

     function users()
    {
        return $this->belongsToMany('App\User')->withTimestamps();
    }
}
