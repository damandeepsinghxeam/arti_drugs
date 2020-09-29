<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskDateExtension extends Model
{
    protected $guarded = [];
    
    function messages()
    {
        return $this->morphMany('App\Message', 'messageable');
    }
}
