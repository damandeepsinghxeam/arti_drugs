<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyGroup extends Model
{
    function companies()
    {
        return $this->hasMany('App\Company');
    }
}
