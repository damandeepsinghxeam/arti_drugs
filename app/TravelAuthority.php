<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TravelAuthority extends Model
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