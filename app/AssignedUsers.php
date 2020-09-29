<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssignedUsers extends Model
{
    /**
     * The database table used by the model.
     * @var string
     */
    // protected $table = 'assigned_users';

    /**
     * The attributes that are mass assignable.
     * @var array
    */
    protected $fillable = [
    	'assignable_type',
    	'assignable_id',
    	'user_id',
    	'type',
    	'wef',
    	'wet',
    	'is_active',
    	'created_at',
    	'updated_at',
    ];

    /**
     * Get the owning commentable model.
    */
    public function commentable()
    {
        return $this->morphTo();
    }

    /**
     * Get the owning employee model.
    */
    public function userEmployee()
    {
        return $this->belongsTo('App\Employee', 'user_id');
    }
}