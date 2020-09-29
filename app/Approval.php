<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Approval extends Model
{
    protected $guarded = [];
    
    function approver()
    {
    	return $this->belongsTo('App\User','approver_id');
    }

    function approvalable()
    {
        return $this->morphTo();
    }

}//end of class
