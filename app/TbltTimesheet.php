<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TbltTimesheet extends Model
{
    protected $guarded = [];
    protected $table = 'tblt_timesheet';
    protected $primaryKey = 'timesheetid';
}
