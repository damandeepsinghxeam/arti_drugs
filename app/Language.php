<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $guarded = [];

    function users()
    {
        return $this->belongsToMany('App\Language')->withTimestamps()->withPivot('read_language','write_language','speak_language');
    }
}
