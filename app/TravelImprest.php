<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TravelImprest extends Model
{
    public function project()
    {
        return $this->morphedByMany('App\Project', 'travel_imprestable');
    }

    public function travel()
    {
        return $this->belongsTo('App\Travel');
    }
}