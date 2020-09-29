<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BdTeam extends Model
{
    /**
     * The database table used by the model.
     * @var string
    */
    // protected $table = 'bd_teams';

    /**
     * The attributes that are mass assignable.
     * @var array
    */
    protected $fillable = [
        'department_id', 
        'name', 
        'team_type', 
        'isactive', 
        'created_by', 
        'created_at', 
        'updated_at', 
    ];

    function department()
    {
        return $this->belongsTo('App\Department');
    }

    function user()
    {
        return $this->belongsTo('App\User', 'created_by');
    }

    function bdTeamMembers()
    {
        return $this->hasMany('App\BdTeamMember')->orderBy('team_role_id', 'DESC');
    }

    /**
     * Scope a query to only include active B.D Team .
     *
     * @return \Illuminate\Database\Eloquent\Builder
    */
    public function scopeActiveTeams($query)
    {
        return $query->where(['bd_teams.isactive' => 1]);
    }

    /**
     * @param array $inputs
     * @param int $id
     *
     * @return \Illuminate\Validation\Validator
     */
    public function validateTeams($inputs, $id = null)
    {
        $inputs = array_filter($inputs);

        $rules  = [
        	'name'      => 'required',
        	'user.id.*'   => 'required',
        	'user.role.*' => 'required',
        ];
        return \Validator::make($inputs, $rules);
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
            $this->find($id)->update($inputs);
            return $id;
        } else {
            return $this->create($inputs)->id;
        }
    }
}
