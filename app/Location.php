<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $guarded = [];

    function state()
    {
    	return $this->belongsTo('App\State');
    }

    function projects()
    {
        return $this->belongsToMany('App\Project')->withTimestamps();
    }

    function users()
    {
        return $this->belongsToMany('App\User')->withTimestamps();
    }
}
