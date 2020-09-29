<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeKra extends Model
{
    protected $guarded = [];

    public function kra()
    {
        return $this->belongsTo('App\Kra');
    }
    

}
