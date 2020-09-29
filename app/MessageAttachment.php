<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MessageAttachment extends Model
{
    protected $guarded = [];

    function message()
    {
        return $this->belongsTo('App\Message');
    }
}
