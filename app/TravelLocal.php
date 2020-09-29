<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TravelLocal extends Model
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
        'approval_duration',
        'city_id',
        'conveyance_id',
        'travel_amount',
        'created_at',
        'updated_at',
    ];

    public function city() {
        return $this->belongsTo('App\City');
    }

    public function conveyance() {
        /*return $this->belongsTo('App\Conveyance')->where('islocal', 1);*/
        return $this->belongsTo('App\Conveyance');
    }

    public function travel() {
        return $this->belongsTo('App\Travel');
    }
}