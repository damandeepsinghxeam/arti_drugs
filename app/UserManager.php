<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserManager extends Model
{
    protected $guarded = [];

    function manager()
    {
    	return $this->belongsTo('App\User','manager_id');
    }

    function user()
    {
    	return $this->belongsTo('App\User');
    } 
}
