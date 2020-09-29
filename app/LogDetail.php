<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogDetail extends Model
{
    protected $guarded = [];

    function log()
    {
    	return $this->belongsTo('App\Log');
    }

    public function log_detailable()
    {
        return $this->morphTo();
    }
}
