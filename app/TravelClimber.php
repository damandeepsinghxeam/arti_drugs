<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TravelClimber extends Model
{
    use SoftDeletes;
    /**
     * The database table used by the model.
     * @var string
     */
    // protected $table = 'travel_climbers';

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
    	'travel_id',
		'climber_user_id',
		'remarks',
        'priority',
		'status',
        'deleted_at',
        'created_at',
        'updated_at',
    ];

    public function travel() {
        return $this->belongsTo('App\Travel');
    }

    public function travelClaim() {
        return $this->belongsTo('App\TravelClaim');
    }
}