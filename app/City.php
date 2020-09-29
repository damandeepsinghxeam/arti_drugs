<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $guarded = [];

    function state()
    {
    	return $this->belongsTo('App\State');
    }
    function city_class()
    {
    	return $this->belongsTo('App\CityClass');
    }

}
