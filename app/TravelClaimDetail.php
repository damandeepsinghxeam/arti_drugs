<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TravelClaimDetail extends Model
{
    public function expense_types() 
    {
        return $this->belongsTo('App\Conveyance', 'expense_type', 'id');
    }

    public function fromCity() {
        return $this->belongsTo('App\City', 'from_location', 'id');
    }

    public function toCity() {
        return $this->belongsTo('App\City', 'to_location', 'id');
    }
}