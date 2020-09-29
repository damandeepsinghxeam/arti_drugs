<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JrfInterviewerDetail extends Model
{
    
    protected $guarded = [];
    protected $table = 'jrf_interviewer_details';


    function user()
    {
    	return $this->belongsTo('App\User');
    }

    function jrf(){

        return $this->hasOne('App\Jrf');
    }

}