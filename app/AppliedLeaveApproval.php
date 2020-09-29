<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppliedLeaveApproval extends Model
{
    protected $guarded = [];

    function user()
    {
    	return $this->belongsTo('App\User');
    }

    function supervisor()
    {
    	return $this->belongsTo('App\User','supervisor_id');
    }

    function appliedLeave()
    {
    	return $this->belongsTo('App\AppliedLeave');
    }
}
