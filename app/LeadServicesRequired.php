<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LeadServicesRequired extends Model
{
 	/**
     * The database table used by the model.
     * @var string
 	*/
    protected $table = 'lead_services_required';

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
    	'lead_id', 
    	'service_id', 
    	'already_outsourced', 
    	'current_vendor', 
    	'current_service_charge', 
    	'current_strength', 
    	'attachment_name', 
    	'attachment_path', 
    	'created_at', 
    	'updated_at'
    ];
}
