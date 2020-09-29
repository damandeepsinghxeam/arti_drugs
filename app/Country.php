<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $guarded = [];

    function states()
    {
    	return $this->hasMany('App\State');
    }
}
