<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TravelStay extends Model
{
    public function city(){
        return $this->belongsTo('App\City');
    }
    
    public function travel()
    {
        return $this->belongsTo('App\Travel');
    }
}