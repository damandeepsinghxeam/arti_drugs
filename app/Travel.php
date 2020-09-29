<?php

namespace App;
use DB;
use Auth;
use View;

use Illuminate\Database\Eloquent\Model;

class Travel extends Model
{
    /**
     * The database table used by the model.
     * @var string
    */
    protected $table = 'travels';

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'user_id',
        'category_id',
        'travel_for',
        'project_id',
        'til_id', // lead_id
        'others',
        'travel_purpose',
        'total_amount',
        'travel_type',
        'status',
        'isactive',
        'created_at',
        'updated_at',
    ];

    public function user() 
    {
        return $this->belongsTo('App\User');
    }

    public function approved_by_user() 
    {
        return $this->belongsTo('App\User', 'approved_by', 'id');
    }

    public function project()
    {
        return $this->belongsTo('App\Project');
    }

    public function tils()
    {
        return $this->belongsTo('App\Til', 'til_id', 'id')->where(['isactive' => 1, 'status' => 8]);// Lead
    }

    public function travel_category()
    {
        return $this->belongsTo('App\TravelCategories', 'category_id')->where(['isactive' => 1]);
    }

    public function travelLocal()
    {
        return $this->hasOne('App\TravelLocal');
    }

    public function travelNational()
    {
        return $this->hasMany('App\TravelNational', 'travel_id');
    }

    public function travelStay()
    {
        return $this->hasMany('App\TravelStay');
    }

    public function imprest()
    {
        return $this->hasOne('App\TravelImprest');
    }

    public function otherApproval()
    {
        return $this->hasOne('App\TravelOtherApproval');
    }

    public function travelClimber()
    {
        return $this->hasMany('App\TravelClimber')->whereNull('deleted_at');
    }

    public function travelClimberUser()
    {
        return $this->hasOne('App\TravelClimber')->where('climber_user_id', Auth::id())->whereNull('deleted_at');
    }

    public function claims()
    {
        return $this->hasOne('App\TravelClaim', 'travel_id')->where('isactive', 1);
    }

    public function logs()
    {
        return $this->hasMany('App\TravelLogs');
    }
}