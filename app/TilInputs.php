<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TilInputs extends Model
{
    /**
     * The database table used by the model.
     * @var string
    */
    // protected $table = 'til_inputs';

    /**
     * The attributes that are mass assignable.
     * @var array
    */
    protected $fillable = [
    	'til_id',
		'department_id',
		'user_id',
		'hod_remarks',
		'user_remarks',
        'isactive',        
    ];

    /**
	 *
     * Get the owning User model.
    */
    function user()
    {
        return $this->belongsTo('App\User');
    }

    function department()
    {
    	return $this->belongsTo('App\Department', 'department_id');
    }

    /**
     * Get the owning TilDraft model.
    */
    function til()
    {
        return $this->belongsTo('App\Til', 'til_id');
    }
}
