<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $guarded = [];

    function documentCategory()
    {
    	return $this->belongsTo('App\DocumentCategory');
    }

    function projects()
    {
        return $this->belongsToMany('App\Project')->withTimestamps()->withPivot('name');
    }

    function users()
    {
        return $this->belongsToMany('App\User')->withTimestamps()->withPivot('name');
    }
}
