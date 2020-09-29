<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PtRegistration extends Model
{
    protected $guarded = [];

    function company()
    {
    	return $this->belongsTo('App\Company');
    }

    function state()
    {
    	return $this->belongsTo('App\State');
    }
    
}//end of class
