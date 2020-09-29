<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Til extends Model
{
    /**
     * The database table used by the model.
     * @var string
    */
    // protected $table = 'tils';

    /**
     * The attributes that are mass assignable.
     * @var array
    */
    protected $fillable = [
        'lead_id', 
        'user_id', 
        'til_code', 
        'tender_owner', 
        'tender_location', 
        'department', 
        'due_date', 
        'vertical_id', 
        'other_vertical', 
        'value_of_work', 
        'bid_system', 
        'bid_system_clause', 
        'volume', 
        'scope_of_work', 
        'tenure_one', 
        'tenure_two', 
        'emd_date',
        'emd', 
        'emd_amount',
        'emd_amount_c',
        'emd_exempted',
        'emd_special_clause',
        'tender_fee', 
        'tender_fee_amount',
        'tender_fee_amount_c',
        'tender_fee_exempted',
        'processing_fee', 
        'processing_fee_amount',
        'processing_fee_exempted',
        'performance_guarantee_type', 
        'performance_guarantee', 
        'performance_guarantee_clause', 
        'pre_bid_meeting', 
        'pre_bid_clause', 
        'payment_terms', 
        'payment_terms_clause', 
        'pay_and_collect', 
        'collect_and_pay', 
        'complete_clause', 
        'obligation_id',
        'total_investments', 
        'financial_opening_date', 
        'technical_opening_date', 
        'assigned_to_group',
        'gross_turnover_monthly',
        'gross_turnover_yearly',
        'investment',
        'technical_criteria',
        'financial_criteria',
        'financial_bid_type',
        'award_criteria',        
        'til_filed_date',        
        'isactive', 
        'is_editable', 
        'status', 
    ];

    /**
     * Get the owning User model.
    */
    function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the owning Lead model.
    */
    function lead()
    {
        return $this->belongsTo('App\Lead');
    }

    /**
     * Get the owning TilContact model.
    */
    function tilContacts()
    {
        return $this->hasMany('App\TilContact');
    }

    /**
     * Get the owning TilObligations model.
    */
    function tilObligations()
    {
        return $this->hasMany('App\TilObligations');
    }
    /**
     * Get the owning TilSpecialEligibility model.
    */
    function tilSpecialEligibility()
    {
        return $this->hasMany('App\TilSpecialEligibility');
    }

    /**
     * Get the owning CostEstimation model.
    */
    function costEstimation()
    {
        return $this->hasOne('App\CostEstimation')->where(['isactive' => 1]);
    }

    /**
     * Get all of the comments.
    */
    function comments()
    {
        return $this->morphMany('App\Comments', 'commentable');
    }

    /**
     * Get all of the AssignedUsers.
    */
    function assignedUsers()
    {
        return $this->morphMany('App\AssignedUsers', 'assignable');
    }

    /**
     * Get the owning employee model.
    */
    function userEmployee()
    {
        return $this->belongsTo('App\Employee', 'user_id');
    }

    /**
     * Get all of the comments.
    */
    function tilInputs()
    {
        return $this->hasMany('App\TilInputs', 'til_id')->where(['isactive' => 1]);
    }

    function notifications()
    {
        return $this->morphMany('App\Notification', 'notificationable');
    }

    /**
     * Get the owning TilTechnicalQualification model.
    */
    function tilTechnicalQualification()
    {
        return $this->hasMany('App\TilTechnicalQualification');
    }

    /**
     * Get the owning TilPenalties model.
    */
    function tilPenalties()
    {
        return $this->hasMany('App\TilPenalties');
    }

    /**
     * Scope a query to only include active TIL.
     *
     * @return \Illuminate\Database\Eloquent\Builder
    */
    function scopeActiveTil($query)
    {
        return $query->where(['tils.isactive' => 1]);
    }
}