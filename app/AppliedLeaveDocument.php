<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppliedLeaveDocument extends Model
{
    protected $guarded = [];

    function appliedLeave()
    {
    	return $this->belongsTo('App\AppliedLeave');
    }
}
