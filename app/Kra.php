<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kra extends Model
{
	protected $guarded = [];

	function kraTemplates()
	{
		return $this->hasMany('App\KraTemplate');
	}
	function employeekra()
	{
		return $this->hasMany('App\EmployeeKra');
	}
	public function department()
    {       
		return $this->belongsTo('App\Department', 'dep_id');
		
    }

     
}
