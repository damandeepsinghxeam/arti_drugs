<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TilDraftTenderProcessing extends Model
{
	/**
     * The database table used by the model.
     * @var string
    */
    // protected $table = 'til_draft_tender_processings';

    /**
     * The attributes that are mass assignable.
     * @var array
    */
    protected $fillable = [
        'til_draft_id',
        'department_id',
        'assigned_user_id',
        'functionality_type',
        'type',
    ];

    /**
     * Get the owning TilDraft model.
    */
    function tils()
    {
        return $this->belongsTo('App\TilDraft', 'til_draft_id');
    }

    /**
     * Get the tenderProcessing.
    */
    public function getCostEstimation()
    {
    	return $this->hasOne(
            'App\CostEstimationDraft',
            'tender_processing_id' // Foreign key on cost_estimation_drafts table...
        )->where(['isactive' => 1]);
    }
}