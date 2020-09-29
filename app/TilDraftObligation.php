<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TilDraftObligation extends Model
{
    /**
     * The database table used by the model.
     * @var string
 	*/
    // protected $table = 'til_draft_obligations';

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
    	'til_draft_id',
		'obligation',
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
