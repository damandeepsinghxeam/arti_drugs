<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TilDraft extends Model
{
	/**
     * The database table used by the model.
     * @var string
    */
    // protected $table = 'til_drafts';

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
     * Get the owning TilDraftContact model.
    */
    function tilContact()
    {
        return $this->hasMany('App\TilDraftContact');
    }

    /**
     * Get the owning TilDraftObligation model.
    */
    function tilObligation()
    {
        return $this->hasMany('App\TilDraftObligation');
    }

    /**
     * Get the owning TilDraftSpecialEligibility model.
    */
    function tilSpecialEligibility()
    {
        return $this->hasMany('App\TilDraftSpecialEligibility');
    }

    /**
     * Get the owning CostEstimationDraft model.
    */
    function costEstimationDraft()
    {
        return $this->hasOne('App\CostEstimationDraft')->where(['isactive' => 1]);
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
    function tilDraftInputs()
    {
        return $this->hasMany('App\TilDraftInputs', 'til_draft_id')->where(['isactive' => 1]);
    }

    function notifications()
    {
        return $this->morphMany('App\Notification', 'notificationable');
    }

    /**
     * Get the owning TilDraftTechnicalQualification model.
    */
    function tilTechnicalQualification()
    {
        return $this->hasMany('App\TilDraftTechnicalQualification');
    }

    /**
     * Get the owning TilDraftPenalties model.
    */
    function tilDraftPenalties()
    {
        return $this->hasMany('App\TilDraftPenalties');
    }

    /**
     * Get the tenderPrebid from tenderProcessing table.
    */
    public function tenderPrebid()
    {
        return $this->hasOne(
            'App\TilDraftTenderProcessing'
        )->where(['functionality_type' => 'pre_bid', 'type' => 'prepare']);
    }


    /**
     * Get the tenderPrebidAttend from tenderProcessing table.
    */
    public function tenderPrebidAttend()
    {
        return $this->hasOne(
            'App\TilDraftTenderProcessing'
        )->where(['functionality_type' => 'pre_bid', 'type' => 'attend']);
    }

    /**
     * Get the tenderFieldStudy from tenderProcessing table.
    */
    public function tenderFieldStudy()
    {
        return $this->hasOne(
            'App\TilDraftTenderProcessing'
        )->where(['functionality_type' => 'field_study', 'type' => 'prepare']);
    }

    /**
     * Get the tenderFieldStudyAttend from tenderProcessing table.
    */
    public function tenderFieldStudyAttend()
    {
        return $this->hasOne(
            'App\TilDraftTenderProcessing'
        )->where(['functionality_type' => 'field_study', 'type' => 'attend']);
    }

    /**
     * Get the tenderCostEstimation from tenderProcessing table.
    */
    public function tenderCostEstimation()
    {
        return $this->hasOne(
            'App\TilDraftTenderProcessing'
        )->where('functionality_type', '=', 'cost_estimation');
    }

    /**
     * Get the tenderDocumentChecklist from tenderProcessing table.
    */
    public function tenderDocumentChecklist()
    {
        return $this->hasOne(
            'App\TilDraftTenderProcessing'
        )->where('functionality_type', '=', 'document_checklist');
    }

    /**
     * Get the CostEstimation from tenderProcessing table.
    */
    public function getCostEstimation()
    {
        return $this->hasOneThrough(
            'App\CostEstimationDraft',
            'App\TilDraftTenderProcessing',
            'til_draft_id', // Foreign key on til_draft_tender_processings table...
            'tender_processing_id', // Foreign key on cost_estimation_drafts table...
            'id', // Local key on til_draft_tender_processings table...
            'id' // Local key on cost_estimation_drafts table...
        )->where('functionality_type', '=', 'cost_estimation');
    }

    /**
     * Scope a query to only include active TIL.
     *
     * @return \Illuminate\Database\Eloquent\Builder
    */
    function scopeActiveTil($query)
    {
        return $query->where(['til_drafts.isactive' => 1]);
    }

    /**
     * @param array $inputs
     * @param int $id
     *
     * @return \Illuminate\Validation\Validator
    */
    public function validateTil($inputs, $id = null)
    {
        $inputs = array_filter($inputs);

        $rules  = [
            'tender_owner'    => 'required',
            'tender_location' => 'required',
            'performance_guarantee_type' => 'required',
            'performance_guarantee' => 'required',
            'payment_terms'   => 'required',
            'pay_and_collect' => 'required_if:payment_terms,1',
            'complete_clause' => 'required_if:pay_and_collect,5',
            'collect_and_pay' => 'required_if:payment_terms,2',
            'department'      => 'required',
            'due_date'        => 'date',
        ];
        return \Validator::make($inputs, $rules);
    }
}