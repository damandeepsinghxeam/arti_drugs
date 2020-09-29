<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    /**
     * The attributes that are mass assignable.
     * @var array
    */
    protected $fillable = [
        'commentable_id',
		'commentable_type',
		'user_id',
        'comments',
        'attachment',
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