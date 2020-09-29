<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalaryCycle extends Model
{

    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $guarded = [];

    public function project()
    {
        return $this->belongsTo('App\Project', 'project_id');
    }

    function salaryStructure()
    {
        return $this->hasOne('App\SalaryStructure');
    }
}
