<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DmsDocEmpWise extends Model
{

	protected $table = 'dms_document_employee';

    function DmsDocempwise()
    {
        return $this->belongsTo('App\DmsDocument');
    }
}
