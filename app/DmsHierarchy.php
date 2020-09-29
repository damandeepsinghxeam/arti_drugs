<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DmsHierarchy extends Model
{

    function user()
    {
    	return $this->belongsTo('App\User');
    }

}