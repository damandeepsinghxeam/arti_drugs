<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TravelNational extends Model
{
    /**
     * The database table used by the model.
     * @var string
     */
    // protected $table = 'leads';

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'travel_id',
        'travel_date',
        'from_city_id',
        'to_city_id',
        'conveyance_id',
        'distance_in_km',
        'travel_amount',
        'created_at',
        'updated_at',
    ];

    public function fromCity() {
        return $this->belongsTo('App\City', 'from_city_id', 'id');
    }

    public function toCity() {
        return $this->belongsTo('App\City', 'to_city_id', 'id');
    }

    public function conveyance() {
        return $this->belongsTo('App\Conveyance', 'conveyance_id', 'id'); // ->where('islocal', 0)
    }
    
    public function travel() {
        return $this->belongsTo('App\Travel');
    }
}