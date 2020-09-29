<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $guarded = [];

    function documents()
    {
        return $this->belongsToMany('App\DmsDocument');
    }
}
