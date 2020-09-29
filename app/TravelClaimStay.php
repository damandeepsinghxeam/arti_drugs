<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TravelClaimStay extends Model
{
    public function state()
    {
        return $this->belongsTo('App\State', 'state_id');
    }

    public function city()
    {
        return $this->belongsTo('App\City', 'city_id');
    }
    
    public function TravelClaim()
    {
        return $this->belongsTo('App\TravelClaim');
    }
}