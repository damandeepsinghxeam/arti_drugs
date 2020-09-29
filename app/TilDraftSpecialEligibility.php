<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TilDraftSpecialEligibility extends Model
{
    /**
     * The database table used by the model.
     * @var string
 	*/
    // protected $table = 'til_draft_special_eligibilities';

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
    	'til_draft_id',
		'special_eligibility',
    	'created_at',
    	'updated_at'
    ];

    /**
     * Get the owning til draft model.
    */
    function tilDraft()
    {
        return $this->belongsTo('App\TilDraft');
    }
}