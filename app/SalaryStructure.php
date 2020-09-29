<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalaryStructure extends Model{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $guarded = [];

    function salaryCycle()
    {
        return $this->belongsTo('App\SalaryCycle', 'salary_cycle_id');
    }

    function project()
    {
        return $this->belongsTo('App\Project', 'project_id');
    }

    function salaryHeads()
    {
        return $this->belongsToMany('App\SalaryHead');
    }
}
