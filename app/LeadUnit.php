<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeadUnit extends Model
{
	use SoftDeletes;
	/**
     * The database table used by the model.
     * @var string
 	*/
    // protected $table = 'lead_units';

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
    	'unit_name',
    	'unit_description',
    	'isactive',
    	'is_deleted',
    	'created_at',
    	'updated_at'
    ];

    function leads()
    {
    	return $this->belongsToMany('App\Leads');
    }

    /**
     * Scope a query to only include active Lead Units.
     *
     * @return \Illuminate\Database\Eloquent\Builder
 	*/
    public function scopeActiveLeadUnits($query)
    {
        return $query->where(['lead_units.isactive' => 1]);
    }

    /**
     * @return mixed
     */
    public function getListLeadUnits()
    {
        $result = $this->activeLeadUnits()->pluck('unit_name', 'id')->toArray();
        return ['' => '-Select unit type-'] + $result;
    }
}
