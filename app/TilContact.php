<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TilContact extends Model
{
    /**
     * The database table used by the model.
     * @var string
 	*/
    // protected $table = 'til_contacts';

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
    	'til_id',
		'name',
		'designation',
		'phone',
		'email',
        'description',
    	'created_at',
    	'updated_at'
    ];

    /**
     * Get the owning til model.
    */
    function til()
    {
        return $this->belongsTo('App\Til');
    }
}