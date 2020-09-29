<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LeaveType extends Model
{
    protected $guarded = [];

    function appliedLeaves()
    {
        return $this->hasMany('App\AppliedLeave');
    }
}
