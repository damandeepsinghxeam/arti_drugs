<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CostEstimation extends Model
{
    /**
     * The database table used by the model.
     * @var string
     */
    // protected $table = 'cost_estimation';

    /**
     * The attributes that are mass assignable.
     * @var array
    */
    protected $fillable = [
        'til_id',
        'estimation_data',
        'is_complete',
        'is_editable',
        'isactive',
        'created_at',
        'updated_at',
    ];

    /**
     * Scope a query to only include active Cost Estimation.
     *
     * @return \Illuminate\Database\Eloquent\Builder
 	*/
    public function scopeActive($query)
    {
        return $query->where(['cost_estimation.isactive' => 1]);
    }

    /**
     * Get the owning TilDraft model.
    */
    function til()
    {
        return $this->belongsTo('App\Til');
    }
}
