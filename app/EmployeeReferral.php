<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeReferral extends Model
{
    protected $guarded = [];

    function user()
    {
    	return $this->belongsTo('App\User');
    }

    function referrer()
    {
    	return $this->belongsTo('App\User','referrer_id');
    }
}
