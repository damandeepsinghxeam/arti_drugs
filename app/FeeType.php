<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FeeType extends Model
{
   /**
     * The database table used by the model.
     * @var string
    */
    // protected $table = 'fee_types';

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'name',
        'is_emd',
        'is_processing_fee',
        'is_tender_fee',
        'isactive',
        'created_at',
        'updated_at'
    ];

    /**
     * @return mixed
     */
    public function getListFeeTypes($filter = [], $forMultiPleSelect = false)
    {
        $result = $this->when($filter, function ($query, $filter) {
                    return $query->where($filter);
                })->pluck('name', 'id')->toArray();

        if($forMultiPleSelect == true) {
            return $result;
        } else {
            return ['' => '-Select-'] + $result;
        }
    }
}