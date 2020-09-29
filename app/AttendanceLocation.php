<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AttendanceLocation extends Model
{
    protected $guarded = [];

    function user()
    {
        $this->belongsTo('App\User');
    }
}
