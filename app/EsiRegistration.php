<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EsiRegistration extends Model
{
    protected $guarded = [];

    function company()
    {
    	return $this->belongsTo('App\Company');
    }

    function location()
    {
    	return $this->belongsTo('App\Location');
    }
}//end of class
