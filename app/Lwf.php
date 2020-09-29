<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lwf extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $guarded = [];

    public function state()
    {
        return $this->belongsTo('App\State');
    }
}
