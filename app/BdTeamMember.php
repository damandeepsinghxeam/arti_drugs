<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BdTeamMember extends Model
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
        'bd_team_id',
        'user_id',
        'team_role_id',
        'isactive',
        'created_at',
        'updated_at',
    ];

    function bdTeam()
    {
        return $this->belongsTo('App\BdTeam');
    }

    function user()
    {
        return $this->belongsTo('App\User');
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