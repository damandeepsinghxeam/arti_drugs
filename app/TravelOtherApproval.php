<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TravelOtherApproval extends Model
{
    public function project()
    {
        return $this->morphedByMany('App\Project', 'travel_other_approvalable');
    }
    
    public function country() {
        return $this->belongsTo('App\Country', 'country_id');
    }

    public function state() {
        return $this->belongsTo('App\State', 'state_id');
    }

    public function city() {
        return $this->belongsTo('App\City');
    }

    public function travel()
    {
        return $this->belongsTo('App\Travel');
    }
}