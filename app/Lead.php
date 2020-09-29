<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    /**
     * The database table used by the model.
     * @var string
     */
    // protected $table = 'leads';

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'user_id',
        'lead_code',
        'business_type',
        'source_id',
        'other_sources',
        'file_name',
        'name_of_prospect',
        'address_location',
        'industry_id',
        'other_industry',
        'service_required',
        'service_description',
        'contact_person_name',
        'contact_person_no',
        'alternate_contact_no',
        'email',
        'is_completed',
        'executive_id',
        'due_date',
        'priority',
        'status',
        'isactive',
        'created_at',
        'updated_at',
    ];

    function source()
    {
        return $this->belongsTo('App\LeadSource');
    }

    function industry()
    {
        return $this->belongsTo('App\LeadIndustry');
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
     * Get the owning employee model.
    */
    function leadExecutives()
    {
        return $this->belongsTo('App\Employee', 'executive_id', 'user_id');
    }

    /**
     * Get the owning til draft model.
    */
    function tilDraft()
    {
        return $this->hasOne('App\TilDraft')->where(['til_drafts.isactive' => 1]);
    }

    /**
     * Get the owning til model.
    */
    function til()
    {
        return $this->hasOne('App\Til')->where(['til.isactive' => 1]);
    }

    function notifications()
    {
        return $this->morphMany('App\Notification', 'notificationable');
    }

    /**
     * Scope a query to only include active Leads.
     *
     * @return \Illuminate\Database\Eloquent\Builder
    */
    function scopeActiveLeads($query)
    {
        return $query->where(['leads.isactive' => 1]);
    }

    /**
     * @param array $inputs
     * @param int $id
     *
     * @return \Illuminate\Validation\Validator
     */
    public function validateLeads($inputs, $id = null)
    {
        $inputs = array_filter($inputs);
        $rules  = [];
        if($id) {
            $rules  = [
                'business_type' => 'required',
                'sources'       => 'required',
                'other_sources' => 'required_if:sources,4',
                'contact_person_email' => 'required_without:file_name|email',
                'contact_person_mobile' => 'required_without:file_name|numeric',
                'contact_person_alternate' => 'required_without:file_name|numeric',
                'service_required' => 'required',
                'service_description' => 'required',
            ];

            if(!isset($inputs['skip_file_name'])) {
                $rules  += [
                    'file_name' => 'required_without_all:name_of_prospect,address_location,industry,unit_type,contact_person_name,contact_person_email,contact_person_mobile,contact_person_alternate|mimetypes:image/*,.doc,.docx,application/pdf,application/vnd.ms-excel,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document|max:5120',
                ];
            }

            if(empty($inputs['file_name'])) {
                $rules  += [
                    'name_of_prospect' => 'required_without:file_name',
                    'address_location' => 'required_without:file_name',
                    'industry_id' => 'required_without:file_name',
                    'contact_person_name' => 'required_without:file_name',
                ];
            }
        } else {

            $rules  = [
                'file_name' => 'mimetypes:image/*,.doc,.docx,application/pdf,application/vnd.ms-excel,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document|max:5120',
                'sources' => 'required',
                'other_sources' => 'required_if:sources,4',
                'contact_person_email'  => 'email',
                'contact_person_mobile' => 'numeric',
                'contact_person_alternate' => 'numeric',
                'service_description'   => 'required',
            ];
        }

        $messages = [
            'file_name.required_without_all' => 'The file name field is required when none of name of prospect, address location, industry, unit type, contact person name, contact person email, contact person mobile number, contact person alternate number are present.',
            'contact_person_mobile.required_without' => 'The contact person mobile number field is required when file name is not present',
            'contact_person_alternate.required_without' => 'The contact person alternate number field is required when file name is not present.',
            'service_required.required' => 'The services field is required.',
            'service_description.required' => 'The services description field is required.'
        ];

        return \Validator::make($inputs, $rules, $messages);
    }

    /**
     * @param array $inputs
     * @param int $id
     *
     * @return mixed
     */
    public function store($inputs, $id = null)
    {
        if ($id) {
            return $this->find($id)->update($inputs);
        } else {
            return $this->create($inputs);
        }
    }
}