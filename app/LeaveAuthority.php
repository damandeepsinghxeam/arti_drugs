<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LeaveAuthority extends Model
{
    protected $guarded = [];

    function user()
    {
    	return $this->belongsTo('App\User');
    }

    function manager()
    {
    	return $this->belongsTo('App\User','manager_id');
    }
}
