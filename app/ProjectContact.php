<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectContact extends Model
{
    protected $guarded = [];

    function project()
    {
    	return $this->belongsTo('App\Project');
    }
}
