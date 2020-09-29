<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CostFactorMaster extends Model
{
   	/**
     * The database table used by the model.
     * @var string
     */
    // protected $table = 'cost_factor_masters';

    /**
     * The attributes that are mass assignable.
     * @var array
    */
    protected $fillable = [
        'name',
        'isactive',
        'created_at',
        'updated_at',
    ];

    /**
     * Scope a query to only include active Lead Industry.
     *
     * @return \Illuminate\Database\Eloquent\Builder
 	*/
    public function scopeActive($query)
    {
        return $query->where(['cost_factor_masters.isactive' => 1]);
    }

    /**
     * @return mixed
     */
    public function getListCostFactors($withSelectOption = true)
    {
        $result = $this->active()->pluck('name', 'id')->toArray();

        if($withSelectOption) {
        	return ['' => '-Select Cost Factors-'] + $result;
        } else {
        	return $result;
        }
    }
}