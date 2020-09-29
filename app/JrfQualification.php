<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JrfQualification extends Model
{
     	
     	protected $guarded 		= [];
    	protected $table	 	= 'jrf_qualification';

	    // function users()
	    // {
	    //     return $this->belongsToMany('App\User')->withTimestamps();
	    // }
	    
	    // function jrf(){

	    //     return $this->hasOne('App\Jrf')->withTimestamps();
	    // }
}
