<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CostEstimationDraft extends Model
{
    /**
     * The database table used by the model.
     * @var string
     */
    // protected $table = 'cost_estimation_draft';

    /**
     * The attributes that are mass assignable.
     * @var array
    */
    protected $fillable = [
        'tender_processing_id',
        'til_draft_id',
        'department_id',
        'assigned_user_id',
        'estimation_data',
        'is_complete',
        'isactive',
        'is_editable',
        'status',
        'created_at',
        'updated_at',
    ];

    /**
     * Scope a query to only include active Cost Estimation Draft.
     *
     * @return \Illuminate\Database\Eloquent\Builder
 	*/
    public function scopeActive($query)
    {
        return $query->where(['cost_estimation_draft.isactive' => 1]);
    }

    /**
     * Get the owning TilDraft model.
    */
    function tilDraft()
    {
        return $this->belongsTo('App\TilDraft');
    }

    /**
     * Get the CostEstimation from tenderProcessing table.
    */
    public function tenderProcessingDraft()
    {
        return $this->belongsTo(
            'App\TilDraftTenderProcessing',
            'tender_processing_id'
        )->where('functionality_type', '=', 'cost_estimation');
    }

    /**
     * Get all of the comments.
    */
    function comments()
    {
        return $this->morphMany('App\Comments', 'commentable');
    }
}