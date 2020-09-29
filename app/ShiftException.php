<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShiftException extends Model
{
	protected $guarded = [];

    function Shift()
    {

        return $this->belongsTo('App\Shift');
    }
    //
}
