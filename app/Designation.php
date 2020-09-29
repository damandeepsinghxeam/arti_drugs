<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    
    protected $guarded = [];

    function band()
    {
        return $this->belongsTo('App\Band');
    }

    function user()
    {
        return $this->belongsToMany('App\User');
    }
}
