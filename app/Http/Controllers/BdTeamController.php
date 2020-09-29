<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;

use App\BdTeam;
use App\BdTeamMember;
use App\User;

class BdTeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $authUser  = \Auth::user();
        $userId    = $authUser['id'];

        $teamList = BdTeam::with(['bdTeamMembers', 'department']);
        if($userId != 13) {
            $teamList->where(['created_by' => $userId]);
        }
        $teamList = $teamList->orderBy('id', 'desc')->get();
        $teamList = $teamList->all();

        return view('bd_team.index', compact('teamList', 'authUser'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function create()
    {
        $authUser    = \Auth::user();
        $userDetails = $authUser->employeeProfile()->first();

        $bdUser = User::with('employee')->whereHas('employeeProfile', function (Builder $query) use($userDetails) {
            $departmentId = $userDetails->department_id; // B.D department id
            $query->where(['department_id' => $departmentId]);
        })->first();

        $teamHodId = $bdUser->leaveAuthorities()->where(['leave_authorities.priority' => '2'])->pluck('manager_id')->first();
        
        $existingUsers = BdTeamMember::where('isactive', 1)->pluck('user_id')->all();
        $existingUsers[] = $teamHodId;

        $users = User::whereHas('employee', function (Builder $q) {
            $q->where('isactive', 1);
        })->whereHas('employeeProfile', function (Builder $query) use($existingUsers, $userDetails) {
            $departmentId = $userDetails->department_id; // B.D department id

            $query->where(['department_id' => $departmentId, 'isactive' => 1])->whereNotIn('user_id', $existingUsers);
        })->get()->all();

        return view('bd_team.create', compact('users', 'userDetails'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        if($request->isMethod('post')) {
            $inputs = $request->except('_token');

            $validator = (new BdTeam)->validateTeams($inputs);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->messages())->withInput($inputs);
            }

            $userId = \Auth::id();
            $user   = User::find($userId);

            $inputs['department_id'] = $user->employeeProfile->department_id;

            try {
                \DB::beginTransaction();

                $teamInputs = [
                    'department_id' => $inputs['department_id'],
                    'name'          => $inputs['name'],
                    'team_type'     => $inputs['team_type'],
                    'isactive'      => 1,
                    'created_by'    => $userId,
                ];

                $team = BdTeam::create($teamInputs);

                if(!empty($team) && !empty($inputs['user']['id'])) {

                    $users   = $inputs['user'];
                    $userIds = $users['id'];

                    foreach ($userIds as $key => $id) { 
                        $teamMembers = [];

                        $teamMembers['bd_team_id']   = $team->id;

                        $teamMembers['user_id'] = $id;

                        if(isset($users['role'][$id])) {
                            $teamMembers['team_role_id'] = $users['role'][$id];
                        }

                        $teamMembers['isactive'] = 1;

                        $teamMembersId = (new BdTeamMember)->store($teamMembers);
                    }
                }

                \DB::commit();
                $message = 'Team Created Successfully.';
                return redirect()->route('bd-team.index')->withSuccess($message);
            } catch (\PDOException $e) {
                \DB::rollBack();

                return redirect()->back()->withError('Database Error: The team could not be saved.')->withInput($inputs);
            } catch (\Exception $e) {
                \DB::rollBack();

                /// $e->getMessage()
                return redirect()->back()->withError('Error code 500: internal server error.')->withInput($inputs);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
    */
    public function show($id = null)
    {
        if(!$id) {
            $message = 'Invalid Team id provided.';
            return redirect()->back()->withError($message);
        }

        $authUser    = \Auth::user();

        $team = BdTeam::with(['bdTeamMembers', 'bdTeamMembers.user.employee', 'department'])->where(['created_by' => $authUser['id']])->find($id);

        if(!$team) {
            $message = 'Error: Team data not found.';
            return redirect()->back()->withError($message);
        }
        return view('bd_team.view', compact('team'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id = null)
    {
        if(!$id) {
            $message = 'Invalid Team id provided.';
            return redirect()->back()->withError($message);
        }
        $authUser    = \Auth::user();
        
        $team = BdTeam::with(['bdTeamMembers', 'bdTeamMembers.user.employee', 'department'])->where(['created_by' => $authUser['id']])->find($id);
        if(!$team) {
            $message = 'Error: Team data not found.';
            return redirect()->back()->withError($message);
        }

        $userDetails = $authUser->employeeProfile()->first();

        $bdUser = User::with('employee')->whereHas('employeeProfile', function (Builder $query) use($userDetails) {
            $departmentId = $userDetails->department_id; // B.D department id
            $query->where(['department_id' => $departmentId, 'isactive' => 1]);
        })->first();

        $teamHodId = $bdUser->leaveAuthorities()->where(['leave_authorities.priority' => '2'])->pluck('manager_id')->first();

        $existingUsers = BdTeamMember::where('isactive', 1)
                        ->where('bd_team_id', '<>', $id)
                        ->pluck('user_id')->all();
        
        $existingUsers[] = $teamHodId;

        $users = User::whereHas('employee', function (Builder $q) {
            $q->where('isactive', 1);
        })->whereHas('employeeProfile', function (Builder $query) use($userDetails, $existingUsers) {
            $departmentId = $userDetails->department_id; // B.D department id

            $query->where(['department_id' => $departmentId])->whereNotIn('user_id', $existingUsers);
        })->get()->all();

        return view('bd_team.edit', compact('team', 'users', 'userDetails'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
    */
    public function update(Request $request, $id = null)
    {
        if(!$id) {
            $message = 'Invalid Team id provided.';
            return redirect()->back()->withError($message);
        }

        $team = BdTeam::with(['bdTeamMembers'])->find($id);
        
        if(!$team) {
            $message = 'Error: Team data not found.';
            return redirect()->back()->withError($message);
        }

        if($request->isMethod('patch')) {
            $inputs = $request->except('_token', '_method');

            $validator = (new BdTeam)->validateTeams($inputs);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->messages())->withInput($inputs);
            }

            try {
                \DB::beginTransaction();

                $teamInputs = [
                    'name'      => $inputs['name'],
                    'team_type' => $inputs['team_type'],
                ];
                
                $team->update($teamInputs);
                if(!empty($team) && !empty($inputs['user']['id'])) {

                    $users   = $inputs['user'];
                    $userIds = $users['id'];

                    foreach ($userIds as $key => $id) {

                        if(isset($users['team_member_id'][$key])) {

                            $teamMemberId = $users['team_member_id'][$key];
                            $teamMembers  = BdTeamMember::find($teamMemberId);
                            
                        } else {
                            $teamMembers = new BdTeamMember;
                        }

                        $teamMembers->bd_team_id = $team->id;
                        $teamMembers->user_id    = $id;

                        if(isset($users['role'][$id])) {
                            $teamMembers->team_role_id = $users['role'][$id];
                        }

                        $teamMembers->isactive = 1;
                        $teamMemberData = $team->bdTeamMembers()->save($teamMembers);
                    }
                }

                \DB::commit();
                $message = 'Team Updated Successfully.';
                return redirect()->route('bd-team.index')->withSuccess($message);
            } catch (\PDOException $e) {
                \DB::rollBack();

                return redirect()->back()->withError('Database Error: The team could not be saved.')->withInput($inputs);
            } catch (\Exception $e) {
                \DB::rollBack();

                // $e->getMessage()
                return redirect()->back()->withError('Error code 500: internal server error.')->withInput($inputs);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
    */
    public function destroy($id = null)
    {
        $message = 'Invalid request: Method not allowed.';
        return redirect()->back()->withError($message);
    }

    public function changeStatus($id = null)
    {
        if(!$id) {
            $message = 'Invalid Team id provided.';
            return redirect()->back()->withError($message);
        }

        $team = BdTeam::find($id);

        if(!$team) {
            $message = 'Invalid Team id provided.';
            return redirect()->back()->withError($message);
        }

        $teamMembers = BdTeamMember::where(['bd_team_id' => $id])->get()->all();

        if(empty($teamMembers) && count($teamMembers) < 1) {
            $message = 'Invalid Team data.';
            return redirect()->back()->withError($message);
        }

        $teamInputs = ['isactive' => 1];
        if($team->isactive == 1) {
            $teamInputs = ['isactive' => 0];
        }

        if($team->update($teamInputs)) {
            foreach ($teamMembers as $key => $approval) {
                $approval->update($teamInputs);
            }

            return redirect()->back()->withSuccess('Team status changed Successfully.');
        } else {
            return redirect()->back()->withError('Error occurs please try again.');
        }
    }//end of function

    public function removeMember(Request $request)
    {
        if($request->isMethod('post')) {
            $inputs = $request->except('_token');

            try {
                \DB::beginTransaction();

                $res = false;

                $filter = [
                    'id'         => $inputs['team_member_id'],
                    'bd_team_id' => $inputs['team_id'],
                    'user_id'    => $inputs['user_id']
                ];

                $teamMember = BdTeamMember::where($filter)->first();

                if(!empty($teamMember)) {
                    $res = $teamMember->delete();
                }

                \DB::commit();

                $message = 'Error in removing user, please try again later.';
                $result = ['status' => 0, 'msg' => $message];
                if($res) {
                    $message = 'User removed successfully.';
                    $result = ['status' => 1, 'msg' => $message];
                }
                return response()->json($result);
            } catch (\PDOException $e) {
                \DB::rollBack();

                $message = 'Database Error: Removing record, please try again later.';
                $result = ['status' => 0, 'msg' => $message];
                return response()->json($result);
            } catch (\Exception $e) {
                \DB::rollBack();

                $result = ['status' => 0, 'msg' => $e->getMessage()];
                return response()->json($result);
            }
        }
    }
}