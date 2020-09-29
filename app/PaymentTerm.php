<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentTerm extends Model
{
    /**
     * The database table used by the model.
     * @var string
 	*/
    // protected $table = 'payment_types';

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
		'payment_type_id',
		'name',
		'description',
		'isactive',
    	'created_at',
    	'updated_at'
    ];

    /**
     * @return mixed
     */
    public function getListPaymentTerm($filter = [])
    {
        $result = $this->when($filter, function ($query, $filter) {
                    return $query->where($filter);
                })->pluck('name', 'id')->toArray();
        return ['' => '-Select-'] + $result;
    }
}