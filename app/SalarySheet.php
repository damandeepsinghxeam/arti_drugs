<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalarySheet extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function salaryBreakdowns()
    {
        return $this->hasMany('App\SalarySheetBreakdown');
    }
}
