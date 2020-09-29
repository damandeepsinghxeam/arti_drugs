<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $guarded = [];

    function logDetails()
    {
    	return $this->hasMany('App\LogDetail');
    }
}
