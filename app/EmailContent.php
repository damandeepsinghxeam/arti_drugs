<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmailContent extends Model
{
    protected $guarded = [];

    function user()
    {
        return $this->belongsTo('App\User');
    }
}
