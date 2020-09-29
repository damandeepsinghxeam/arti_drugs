<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Obligation extends Model
{
    /**
     * The database table used by the model.
     * @var string
 	*/
    // protected $table = 'obligations';

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
    	'name',
    	'description',
    	'isactive',
    	'created_at',
    	'updated_at'
    ];

    /**
     * @return mixed
     */
    public function getListObligationTypes($filter = [])
    {
        $result = $this->when($filter, function ($query, $filter) {
                    return $query->where($filter);
                })->pluck('name', 'id')->toArray();
        return ['' => '-Select-'] + $result;
    }
}