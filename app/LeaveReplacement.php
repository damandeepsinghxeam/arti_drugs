<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LeaveReplacement extends Model
{
    protected $guarded = [];

    function user()
    {
    	return $this->belongsTo('App\User');
    }

    function appliedLeave()
    {
    	return $this->belongsTo('App\AppliedLeave');
    }
}
