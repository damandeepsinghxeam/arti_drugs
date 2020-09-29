<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KraTemplate extends Model
{
    
     protected $guarded = [];
     /*public function Kra() {
      return $this->belongsToMany('App\Kra');

    }*/
    public function kra()
    {
        return $this->belongsTo('App\kra');
    }

   
     
}
