<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TravelClaim extends Model
{
    public function claim_attachments()
    {
    	return $this->hasMany('App\TravelClaimAttachment');
    }

    public function claim_details()
    {
    	return $this->hasMany('App\TravelClaimDetail');
    }

    public function claim_stay()
    {
    	return $this->hasMany('App\TravelClaimStay');
    }

    public function travel()
    {
        return $this->belongsTo('App\Travel', 'travel_id');
    }

    public function authorities()
    {
        return $this->hasMany('App\TravelAuthority', 'user_id', 'user_id')->where('authority_type', 'claim_approval');
    }

    public function climber()
    {
        return $this->hasMany('App\TravelClimber');
    }

    public function logs()
    {
        return $this->hasMany('App\TravelLogs');
    }

    public function climberUser()
    {
        return $this->hasOne('App\TravelClimber')->where('climber_user_id', \Auth::id())->latest();
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get all of the comments.
    */
    function comments()
    {
        return $this->morphMany('App\Comments', 'commentable');
    }

	/**
     * @param array $inputs
     * @param int $id
     *
     * @return \Illuminate\Validation\Validator
     */
    public function validateTravelExpense($inputs, $id = null)
    {
        $inputs = array_filter($inputs);

        $rules  = [
            'travel_expense.date.*'          => 'required',
            'travel_expense.from_location.*' => 'required',
            'travel_expense.to_location.*'   => 'required',
            'travel_expense.expense_type.*'  => 'required',
            'travel_expense.description.*'   => 'required',
            'travel_expense.amount.*'        => 'required',
            'stay.date_from.*'               => 'required',
            'stay.date_to.*'                 => 'required',
            'stay.state_id.*'                => 'required',
            'stay.city_id.*'                 => 'required',
            'stay.rate_per_night.*'          => 'required',
            'stay.da.*'                      => 'required',
            'attachment.attachment_type.*'   => 'required',
            'attachment.name.*'              => 'required',
        ];
        //application/pdf
        if(!$id) {
            $rules['attachment.attachment.*'] = 'required|mimes:jpeg,png,jpg,doc,docx,pdf,application/msword,application/vnd.ms-office,application/vnd.openxmlformats-officedocument.wordprocessingml.document|max:5120';
        } else {
            $rules['attachment.attachment.*'] = 'mimes:jpeg,png,jpg,doc,docx,pdf,application/msword,application/vnd.ms-office,application/vnd.openxmlformats-officedocument.wordprocessingml.document|max:5120';
        }

        return \Validator::make($inputs, $rules);
    }

    /**
     * @param array $inputs
     * @param int $id
     *
     * @return \Illuminate\Validation\Validator
    */
    public function validateUtrNumber($inputs, $id = null)
    {
        $inputs = array_filter($inputs);

        $rules['status'] = 'required';
        if($id) {
            $rules['utr_number'] = 'required|alpha_numeric|size:16|unique:expenses,utr_number,'.$id.',id,isactive,1';
        } else {
            $rules['utr_number'] = 'required|alpha_numeric|size:16|unique:expenses,utr_number,NULL,id,isactive,1';
        }

        $message = [
            'utr_number.unique' => 'UTR number has already been taken.',
            'utr_number.size'   => 'UTR number must be 16 characters.'
        ];
        return \Validator::make($inputs, $rules, $message);
    }
}