<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocumentCategory extends Model
{
    protected $guarded = [];

    function documents()
    {
    	return $this->hasMany('App\Document');
    }
}
