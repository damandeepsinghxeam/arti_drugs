<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CityClass extends Model
{
    public function cities()
    {
        return $this->hasMany('App\City');
    }
    public function bands()
    {
        return $this->belongsToMany('App\Band');
    }
}
