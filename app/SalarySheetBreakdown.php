<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalarySheetBreakdown extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $guarded = [];

    public function SalarySheet()
    {
        return $this->belongsTo('App\SalarySheet');
    }
}
