<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeadSource extends Model
{
	use SoftDeletes;
    /**
     * The database table used by the model.
     * @var string
 	*/
    // protected $table = 'lead_sources';

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
    	'source_name',
    	'source_description',
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
    public function scopeActiveLeadSource($query)
    {
        return $query->where(['lead_sources.isactive' => 1]);
    }

    /**
     * @return mixed
     */
    public function getListLeadSource()
    {
        $result = $this->activeLeadSource()->pluck('source_name', 'id')->toArray();
        return ['' => '-Select source-'] + $result;
    }
}
