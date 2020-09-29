<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JrfHierarchy extends Model
{

    function user()
    {
    	return $this->belongsTo('App\User');
    }

}