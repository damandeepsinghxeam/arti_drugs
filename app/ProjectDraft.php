<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class ProjectDraft extends Model
{
    use SoftDeletes;
	protected $guarded = [];
	
	 protected $fillable = [
    	'project_approval',
		'creator_id',
		'status',
    	'bg_data',
		'insurance_data',
		'it_req_data',
		'salary_structure',
		'bg_counter',
		'insurance_counter',
		'it_counter', 
		'sent_back',  	
    	'created_at',
    	'updated_at'
    ];
}
