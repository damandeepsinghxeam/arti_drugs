<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BenifitPerks extends Model
{
    protected $guarded = [];

    protected $table = 'benifits_perks';

     function users()
    {
        return $this->belongsToMany('App\User')->withTimestamps();
    }
}
