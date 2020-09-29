<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeadService extends Model
{
	use SoftDeletes;
	/**
     * The database table used by the model.
     * @var string
 	*/
    // protected $table = 'lead_services';

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
    	'service_name',
    	'service_description',
    	'isactive',
    	'is_deleted',
    	'created_at',
    	'updated_at'
    ];

    function leads()
    {
    	return $this->hasMany('App\Lead');
    }

    /**
     * Scope a query to only include active Lead Services.
     *
     * @return \Illuminate\Database\Eloquent\Builder
 	*/
    public function scopeActiveLeadServices($query)
    {
        return $query->where(['lead_services.isactive' => 1]);
    }

    /**
     * @return mixed
     */
    public function getListLeadServices($isSelectBox = false)
    {
        $result = $this->activeLeadServices()->pluck('service_name', 'id')->toArray();
        if($isSelectBox) {
        	return ['' => '-Select services-'] + $result;
        } else {
        	return $result;
        }
    }
}
