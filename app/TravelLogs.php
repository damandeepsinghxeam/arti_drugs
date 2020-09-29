<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TravelLogs extends Model
{
    /**
     * The database table used by the model.
     * @var string
     */
    // protected $table = 'travel_logs';

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
    	'travel_id',
        'travel_claim_id',
		'user_id',
		'remarks',
        'created_at',
        'updated_at',
    ];

    public function travel() {
        return $this->belongsTo('App\Travel');
    }

    public function travelClaim() {
        return $this->belongsTo('App\TravelClaim');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the owning employee model.
    */
    public function employee()
    {
        return $this->belongsTo('App\Employee', 'user_id');
    }
}