<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectResponsiblePerson extends Model
{
    protected $guarded = [];
    protected $table = "project_responsible_persons";

    function project()
    {
    	return $this->belongsTo('App\Project');
    }

    function user()
    {
    	return $this->belongsTo('App\User');
    }
}
