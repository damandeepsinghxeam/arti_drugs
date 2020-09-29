<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class DmsDocument extends Model
{

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $guarded = [];

    function category()
    {
        return $this->belongsTo('App\DmsCategory', 'dms_category_id');
    }

    public function keywords()
    {
        return $this->belongsToMany('App\DmsKeyword');
    }

    public function employees()
    {
        return $this->belongsToMany('App\Employee');
    }

    public function departments()
    {
        return $this->belongsToMany('App\Department');
    }

    public function dmsRequest()
    {
        return $this->hasMany('App\DmsRequests');
    }

    public function dmsRequestUser()
    {
        return $this->hasOne('App\DmsRequests', 'dms_document_id')->where(['user_id'=> Auth::id()])->orderBy('id','DESC');
    }

    public function dmsemployee()
    {
        return $this->hasMany('App\DmsDocEmpWise');
    }

     public function dmsAuthEmployee()
    {
        return $this->hasOne('App\DmsDocEmpWise', 'dms_document_id')->where(['employee_id'=> Auth::id()]);
    }

    /*public function dmsemployee()
    {
        return $this->hasMany('App\DmsDocEmpWise');
    }

    public function dmsempWise()
    {
        return $this->hasOne('App\DmsDocEmpWise', 'dms_document_id');

    }*/

}
