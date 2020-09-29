<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TravelApproval extends Model
{
    
    public function project()
    {
        return $this->morphedByMany('App\Project', 'travel_approvalable');
    }
    public function approved_by_user(){
        return $this->belongsTo('App\User', 'approved_by', 'id');
    }
    public function city_from(){
        return $this->belongsTo('App\City', 'city_id_from', 'id');
    }
    public function user(){
        return $this->belongsTo('App\User');
    }
    public function city_to(){
        return $this->belongsTo('App\City', 'city_id_to', 'id');
    }
    public function stay(){
        return $this->hasMany('App\TravelStay');
    }
    public function claims(){
        return $this->hasOne('App\TravelClaim');
    }
    public function imprest(){
        return $this->hasOne('App\TravelImprest');
    }
    public function other_approval(){
        return $this->hasOne('App\TravelOtherApproval');
    }
    public function conveyance_all(){
        return $this->belongsToMany('App\Conveyance');
    }
    public function conveyance_travel(){
        return $this->belongsToMany('App\Conveyance')->where('islocal', 0);
    }
    public function conveyance_local(){
        return $this->belongsToMany('App\Conveyance')->where('islocal', 1);
    }
}
