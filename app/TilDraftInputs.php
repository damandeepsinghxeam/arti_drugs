<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TilDraftInputs extends Model
{
    /**
     * The database table used by the model.
     * @var string
    */
    // protected $table = 'til_draft_inputs';

    /**
     * The attributes that are mass assignable.
     * @var array
    */
    protected $fillable = [
    	'til_draft_id',
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
    function tilDraft()
    {
        return $this->belongsTo('App\TilDraft', 'til_draft_id');
    }
}