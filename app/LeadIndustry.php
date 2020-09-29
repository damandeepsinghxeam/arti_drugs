<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeadIndustry extends Model
{
	use SoftDeletes;
    /**
     * The database table used by the model.
     * @var string
 	*/
    // protected $table = 'lead_industries';

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
    	'industry_name',
    	'industry_description',
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
     * Scope a query to only include active Lead Industry.
     *
     * @return \Illuminate\Database\Eloquent\Builder
 	*/
    public function scopeActiveLeadIndustry($query)
    {
        return $query->where(['lead_industries.isactive' => 1]);
    }

    /**
     * @return mixed
     */
    public function getListLeadIndustry()
    {
        $result = $this->activeLeadIndustry()->pluck('industry_name', 'id')->toArray();
        return ['' => '-Select industry-'] + $result;
    }
}
