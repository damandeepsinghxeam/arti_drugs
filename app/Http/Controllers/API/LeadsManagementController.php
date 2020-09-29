<?php

namespace App\Http\Controllers\API;


use App\User;
use App\Employee;
use App\LeadSource;
use App\LeadIndustry;
use App\LeadApproval;
use App\LeadAuthority;
use App\Lead;
use App\AssignedUsers;
use App\BdTeam;
use App\BdTeamMember;
use App\Comments;
use App\LeaveAuthority;
use App\FeeType;
use App\Obligation;
use App\Vertical;
use App\PaymentTerm;

use App\Til;
use App\TilContact;
use App\TilObligations;
use App\TilSpecialEligibility;
use App\TilTechnicalQualification;
use App\TilPenalties;
use App\TilInputs;

use App\TilDraft;
use App\TilDraftContact;
use App\TilDraftObligation;
use App\TilDraftSpecialEligibility;
use App\TilDraftTechnicalQualification;
use App\TilDraftPenalties;
use App\TilDraftInputs;

use App\CostFactorMaster;
use App\CostFactorTypes;
use App\CostEstimation;
use App\CostEstimationDraft;

use App\Department;

use App\BdPrebidMember;
use App\BdPrebidClause;
use Validator;
use DB;
use stdClass;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LeadsManagementController extends Controller
{
    
    public function create()
    {
        $success['leadSourceOptions']   = (new LeadSource)->getListLeadSource();
        $success['leadIndustryOptions'] = (new LeadIndustry)->getListLeadIndustry();
        
        return response()->json(['success' => $success], 200);
    }//end of function

    public function store(Request $request)
    {
        checkDeviceId($request->user());
        $auth_user = $request->user();
        
        //$authUser = \Auth::user();
        $userId = $auth_user->id;

        if($request->isMethod('post')) {
            

            $data = $request->all();
            $inputs = $request->except('file_name');
            
            $validator = (new Lead)->validateLeads($data);
            /*if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->messages())->withInput($inputs);
            }*/
             if($validator->fails()){
                return response()->json(['validation_error'=>$validator->errors()], 400);

            }


            $fileNameArr  = [];
            /*$exstingCount = Lead::max('lead_code');
              $exstingCount = (empty($exstingCount))? Lead::count() + 1 : $exstingCount + 1;
            */
            $leadCount = Lead::count() + 1;
            $serialNumber = generateSerialNumber($leadCount);

 
            $teamTypeArr = [1 => 'govt', 2 => 'corp'];
            try {
                \DB::beginTransaction();
                unset($inputs['_token']);


                if(!empty($inputs['due_date']) && $inputs['due_date'] != '0000-00-00 00:00:00') {
                   $inputs['due_date'] = date('Y-m-d H:i:s', strtotime($inputs['due_date']));
                }

                
                $inputs['user_id']   = $userId;
                $inputs['lead_code']   = $serialNumber;
                $inputs['source_id'] = $inputs['sources'];


                if ($request->hasFile('file_name')) {
                    
                    $fileOzName      = str_replace(' ', '', $request->file('file_name')->getClientOriginalName());
                    $fileOzExtension = $request->file('file_name')->getClientOriginalExtension();

                    $fileName = time() . '_' . pathinfo(strtolower($fileOzName), PATHINFO_FILENAME) . '.' . $fileOzExtension;


                    $leadServiceDir = \Config::get('constants.uploadPaths.leadDocuments');

                    if(!is_dir($leadServiceDir)) {
                        mkdir($leadServiceDir, 0775);
                    }

                    $request->file('file_name')->move($leadServiceDir, $fileName);

                    $fileNameArr['file'] = $leadServiceDir.DIRECTORY_SEPARATOR.$fileName;
                    $inputs['file_name'] = $fileName;
                }

                if(isset($inputs['contact_person_mobile'])) {
                    $inputs['contact_person_no'] = $inputs['contact_person_mobile'];
                }

                if(isset($inputs['contact_person_alternate'])) {
                    $inputs['alternate_contact_no'] = $inputs['contact_person_alternate'];
                }

                if(isset($inputs['contact_person_email'])) {
                    $inputs['email'] = $inputs['contact_person_email'];
                }               

                
                $inputs['isactive'] = 1;
                $inputs['status']   = 1;

                if(isset($inputs['business_type']) AND ($inputs['business_type']!="")){
                    $teamType    = $teamTypeArr[$inputs['business_type']];
                }else{
                   $teamType = 1; 
                }
                

                $bdExecutive = BdTeam::where(['bd_teams.isactive' => 1, 'team_type' => $teamType])
                            ->leftjoin('bd_team_members', function ($join) {
                            $join->on('bd_teams.id', '=', 'bd_team_members.bd_team_id')
                            ->where(['team_role_id' => 1, 'bd_team_members.isactive' => 1]);
                            })->select('bd_team_members.*')->orderBy('leads_counter', 'ASC')->first();
              
                if(empty($bdExecutive)) {
                    throw new \Exception("B.d team or executive not found. Please create a B.d team to continue.", 151);
                }

                $inputs['executive_id'] = $bdExecutive->user_id;

                //$lead = (new Lead)->store($inputs);
                $lead = Lead::create($inputs);
                $success['lead'] = $lead;


                if(!empty($lead)) {
                    $executiveInputs = new AssignedUsers;
                    $executiveInputs->user_id = $inputs['executive_id'];
                    $executiveInputs->type    = 1;
                    $executiveInputs->wef     = date('Y-m-d H:i');
                    $executiveInputs->is_active = 1;
                    $executiveUser = $lead->assignedUsers()->save($executiveInputs);


                    $executive = BdTeamMember::find($bdExecutive->id);
                    $executive->leads_counter = ($executive->leads_counter + 1);
                    $success['executiveUpdate'] = $executive->update();

                    $notificationMessage = $auth_user->employee->fullname . " has assigned you a new lead with lead number".$serialNumber.".";

                    $notificationData = [
                        'sender_id' => $lead->user_id,
                        'receiver_id' => $inputs['executive_id'],
                        'label' => 'Lead Assigned',
                        'read_status' => '0',
                        'redirect_url' => 'leads-management/view-leads/'.$lead->id,
                        'message' => $notificationMessage
                    ];
                    $lead->notifications()->create($notificationData);
                    //sms($lead->leadExecutives->mobile_number, $notificationMessage);

                } else {
                    throw new \Exception("Error occurs please try again.", 151);
                }

                \DB::commit();

                $route = 'leads-management.index';
                if($userId == 13) {
                  $route = 'leads-management.get-leads';
                }

                $success['message'] = 'Lead Created Successfully.';
                //return redirect()->route($route)->withSuccess($message);
                

            } catch (\PDOException $e) {
                \DB::rollBack();

                if(isset($fileNameArr['file'])) {
                    unlink($fileNameArr['file']);
                }

                $success['message'] = 'Database Error: The lead could not be saved.';

                //return redirect()->back()->withError('Database Error: The lead could not be saved.')->withInput($inputs);

            } catch (\Exception $e) {
                \DB::rollBack();

                if(isset($fileNameArr['file'])) {
                    unlink($fileNameArr['file']);
                }

                $message = 'Error code 500: internal server error.';
                if($e->getCode() == 151) {
                    $message = $e->getMessage();
                }
                // $e->getMessage()
                //return redirect()->back()->withError($message)->withInput($inputs);
                 $success['message'] = $message;
                 $success['lead_'] = $lead;

            }
        }
         return response()->json(['success' => $success], 200);
    }//end of function


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function index(Request $request)
    {
        $authUser  = $request->user();
       
        $userId    = $authUser['id'];
       
        $success['userId']= $userId;

        if(in_array($userId, [1, 13])) {
          $message = 'Request not allowed.';
                
           return response()->json(['error' => $message], 403);

            
          //return redirect()->route('leads-management.get-leads')->withError($message);
        }
        
        $hodId = $teamRoleId = null; 
        $filter = $teamUsers = [];
        $leadType = 'all'; $statusArr = [3]; $leadStatus = 3;
        if($request->isMethod('get') && !empty($request->all())) {
            $inputs = $request->all();

            if(isset($inputs['lead_type']) && $inputs['lead_type'] == 'created') {
                $leadType = 'created';
            } else if(isset($inputs['lead_type']) && $inputs['lead_type'] == 'assigned') {
                $leadType = 'assigned';
            } else {
                $leadType = 'all';
            }

            if(isset($inputs['lead_status']) && !empty($inputs['lead_status'])) {
                if($inputs['lead_status'] == 'all') {
                    $statusArr = [1, 2, 3, 4]; 
                    $leadStatus = 'all';
                } else {
                    $statusArr = [$inputs['lead_status']]; 
                    $leadStatus = $inputs['lead_status'];
                }
            }
        }

          $userDetails = $authUser->employeeProfile()->first();
          $bdMember = BdTeamMember::Where('user_id', $userId)->first();
       $success['bdMember']= $bdMember;
 
        $bdUser = User::with('employee')->whereHas('employeeProfile', function (Builder $query) use($userDetails) {
            $departmentId = $userDetails->department_id; // B.D department id
            $query->where(['department_id' => $departmentId]);
        })->first();
        


        $teamHodId = $bdUser->leaveAuthorities()->where(['leave_authorities.priority' => '2'])->pluck('manager_id')->first();

        $existingUsers=BdTeamMember::where('isactive',1)->pluck('team_role_id','user_id')->all();

        if(!empty($existingUsers) && isset($existingUsers[$userId]) && $existingUsers[$userId]) {
            $teamRoleId = $existingUsers[$userId]; // 1->executive, 2 -> manager

            if($teamRoleId == 1) {
                $filter['executive_id'] = $userId;
            }
            $teamUsers = array_keys($existingUsers);
        } else if(!empty($teamHodId) && $teamHodId == $userId) {
            $hodId = $teamHodId;
            $teamUsers = array_keys($existingUsers);
        } else {
            $filter['user_id'] = $userId;
        }

        $leadList = Lead::with(['source', 'industry', 'leadExecutives'])->where('isactive', 1);
        // $leadType == 1 created Leads, 2 assigned Leads
        if(!empty($filter) && isset($filter['executive_id']) || !empty($teamUsers)) {
            
            if($leadType == 'created') {
                $leadList->where('user_id', $userId);
            } else if($leadType == 'assigned') {

                if(!empty($filter['executive_id'])) {
                    $leadList->where('executive_id', $filter['executive_id']);
                } else {
                    $leadList->where('executive_id', $userId);
                }
            }/* else {
                $leadList->whereIn('executive_id', $teamUsers);
            }*/
        } else {
            $leadList->where($filter);
        }

        $leadList->whereIn('status', $statusArr); //1, 2, 3, 4 //5, 6;
        $leadList = $leadList->orderBy('id', 'desc')->get();
        $leadList = $leadList->all();
        $success['leadList'] = $leadList;
        $success['teamRoleId'] = $teamRoleId;
        $success['hodId'] = $hodId;
        $success['leadType'] = $leadType;
        $success['leadStatus'] = $leadStatus;

       /* return view('leads_management.index', compact('leadList', 'bdMember', 'userId', 'teamRoleId', 'hodId', 'leadType', 'leadStatus'));*/
        return response()->json(['success' => $success], 200);
    }//end of function


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
    */
    public function edit($id)
    {
       if(!$id) {
            $message = 'Invalid id provided';
            //return redirect()->back()->withError($message);
            return response()->json(['error' => $message], 403);
        }

        $authUser = \Auth::user();
        $userId   = $authUser['id'];
         //$userId =170;


        if($userId == 13) {
          $message = 'Request not allowed.';
          return response()->json(['error' => $message], 403);
          //return redirect()->route('leads-management.get-leads')->withError($message);
        }

        $lead = Lead::where(['executive_id' => $userId])->find($id);
        $success['lead'] = $lead;
        if(!$lead) {
            $message = 'No data found.';
            return response()->json(['error' => $message], 403);
            //return redirect()->back()->withError($message);
        }
        if($lead->is_completed == 1) {
            $message = 'You don\'t have permission to edit this.';
            return response()->json(['error' => $message], 403);
            //return redirect()->back()->withError($message);
        }

        $success['leadSourceOptions']   = (new LeadSource)->getListLeadSource();
        $success['leadIndustryOptions'] = (new LeadIndustry)->getListLeadIndustry();

        return response()->json(['success' => $success], 200);

        //return view('leads_management.edit', compact('lead', 'leadSourceOptions', 'leadIndustryOptions'));
    }//end of function



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
            $message = 'Invalid Lead id provided.';
            //return redirect()->back()->withError($message);
            return response()->json(['error' => $message], 403);
        }

        $lead = Lead::findOrFail($id); // leadApproval
        if(!$lead) {
            $message = 'Error: Lead data not found.';
            return response()->json(['error' => $message], 403);
            //return redirect()->back()->withError($message);
        }

        if($request->isMethod('patch')) {
            
            $data = $request->except('_method', '_token');
            $data['file_name'] = $lead->file_name;

           $inputs = $request->except('file_name', '_method', '_token');
        
            
            if(isset($inputs['is_completed']) && $inputs['is_completed'] == 1) {
                $validator = (new Lead)->validateLeads($data, $id);
                if ($validator->fails()) {
                    return response()->json(['validation_error'=>$validator->errors()], 400);
                }
            }

            $teamTypeArr = [1 => 'govt', 2 => 'corp'];
            $fileNameArr = [];
            
            try {
                \DB::beginTransaction();

                $userId = \Auth::id();
                /*$inputs['user_id'] = \Auth::id();*/
                $inputs['source_id'] =  $inputs['sources'];                

                if ($request->hasFile('file_name')) {
                    $leadServiceDir = \Config::get('constants.uploadPaths.leadDocuments');

                    if(!empty($lead->file_name) && file_exists($leadServiceDir . $lead->file_name)) {
                        unlink($leadServiceDir . $lead->file_name);
                    }

                    $fileOzName      = str_replace(' ', '', $request->file('file_name')->getClientOriginalName());
                    $fileOzExtension = $request->file('file_name')->getClientOriginalExtension();

                    $fileName=time().'_'.pathinfo(strtolower($fileOzName), PATHINFO_FILENAME).'.'.$fileOzExtension;

                    $request->file('file_name')->move($leadServiceDir, $fileName);

                    $fileNameArr['file'][] = $leadServiceDir . DIRECTORY_SEPARATOR . $fileName;
                    $inputs['file_name'] = $fileName;
                }

                if(!empty($inputs['due_date'])) {
                   $inputs['due_date'] = date('Y-m-d H:i:s', strtotime($inputs['due_date']));
                }
                if(isset($inputs['contact_person_mobile'])) {
                    $inputs['contact_person_no'] = $inputs['contact_person_mobile'];
                }

                if(isset($inputs['contact_person_alternate'])) {
                    $inputs['alternate_contact_no'] = $inputs['contact_person_alternate'];
                }

                if(isset($inputs['contact_person_email'])) {
                    $inputs['email'] = $inputs['contact_person_email'];
                }
                
                $inputs['isactive'] = 1;
                if(isset($inputs['is_completed']) && $inputs['is_completed'] == 1) {
                    $inputs['status'] = 3;
                } else {
                    $inputs['status'] = 2;
                }

                $success['lead_update'] = $lead->update($inputs);


                if($success['lead_update']) {
                    if(isset($inputs['comments']) && !empty($inputs['comments'])) {
                        $commentsInputs = new Comments;
                        $commentsInputs->user_id  = $userId;
                        $commentsInputs->comments = $inputs['comments'];

                        if($request->hasFile('attachment')) {
                            $leadCommentsDir = \Config::get('constants.uploadPaths.leadComments');

                            $fileOzName = $request->file('attachment')->getClientOriginalName();
                            $fileOzName = str_replace(' ', '', $fileOzName);

                            $fileOzExtension = $request->file('attachment')
                                               ->getClientOriginalExtension();

                            $fileName = time().'_'.pathinfo(strtolower($fileOzName), PATHINFO_FILENAME).'.'.$fileOzExtension;

                            if(!is_dir($leadCommentsDir)) {
                                mkdir($leadCommentsDir, 0775);
                            }

                            $request->file('attachment')->move($leadCommentsDir, $fileName);

                            $fileNameArr['file'][] = $leadCommentsDir . DIRECTORY_SEPARATOR . $fileName;
                            $commentsInputs->attachment = $fileName;
                        }
                        $success['comments'] = $lead->comments()->save($commentsInputs);
                    }
                } else {
                    throw new \Exception("Error occurs please try again.", 151);
                }

                \DB::commit();

                $route   = 'leads-management.index';
                $success['message'] = 'Lead Updated Successfully.';
                return response()->json(['success' => $success], 200);
                //return redirect()->route($route)->withSuccess($message);
            } catch (\PDOException $e) {
                \DB::rollBack();

                if(isset($fileNameArr['file']) && !empty($fileNameArr['file']) && count($fileNameArr['file']) > 0) {
                    $this->removeFiles($fileNameArr['file']);
                }
                $message = "Database Error: The lead could not be saved.";
                return response()->json(['error' => $message], 403);
                //return redirect()->back()->withError('Database Error: The lead could not be saved.')
                //->withInput($inputs);
            } catch (\Exception $e) {
                \DB::rollBack();

                if(isset($fileNameArr['file']) && !empty($fileNameArr['file']) && count($fileNameArr['file']) > 0) {
                    $this->removeFiles($fileNameArr['file']);
                }
                // $e->getMessage() 'Error code 500: internal server error.'
                $message = $e->getMessage();
                return response()->json(['error' => $message], 403);
                //return redirect()->back()->withError($e->getMessage())->withInput($inputs);
            }
        }
    }//end of function

     /**
     * Rejecting the specified resource from storage.
     *    
    */
    public function rejectLead(Request $request, $id = null)
    {
        $authUser = \Auth::user();
        $userId   = $authUser['id'];

        if(!$id) {
            $message = 'Invalid id provided';
            return response()->json(['error' => $message], 403);
           
        }

        $lead = Lead::find($id);
        if(!$lead) {
            $message = 'Error: Lead data not found.';
            $result['status'] = 0;
            $result['msg'] = $message;
            
            return response()->json(['error' => $result], 403);
   //         return response()->json($result);
        }
        

        if($request->isMethod('POST')) {

            try {
                \DB::beginTransaction();

                $inputs = ['status' =>  6];
                $res = $lead->update($inputs);

                \DB::commit();

                $message = 'Error in rejecting lead, please try again later.';
                $result = ['status' => 0, 'msg' => $message];
                if($res) {
                    $message = 'Lead Rejected Successfully.';
                    $result  = ['status' => 1, 'msg' => $message];
                    return response()->json(['success' => $result], 200);
                }else{
                    return response()->json(['error' => $result], 403);
                }
                
               
            } catch (\PDOException $e) {
                \DB::rollBack();

                $message = 'Database Error: The lead could not be rejected.';
                $result  = ['status' => 0, 'msg' => $message];
                return response()->json(['error' => $result], 403);
               
            } catch (\Exception $e) {
                \DB::rollBack();

                $message = 'Error code 500: internal server error.';
                $result  = ['status' => 0, 'msg' => $message];
                return response()->json(['error' => $result], 403);
                
            }
        }
    }//end of function 


    /**
     * listing the approved specified resource from storage.     
    */
    public function leadApproval(Request $request)
    {
        if($request->isMethod('post')) {
             $userId = \Auth::user()->id;
            
           $inputs = $request->except('_token');
           

            if(!$inputs['lead_id']) {
                $message = 'Lead id not found.';                
                return response()->json(['error' => $message], 403);
            }

            $lead = Lead::find($inputs['lead_id']);

            if(!$lead) {
                $message = 'Invalid Lead id provided.';
                return response()->json(['error' => $message], 403);
            }

            try {
                \DB::beginTransaction();

                //status== 1 New, 2 Open, 3 Complete, 4 Rejected by Hod, 5 Closed, 6 Abandoned
                $leadInputs  = ['status' => $inputs['status']];

                $leadInputs['is_completed'] = 0;
                if(in_array($inputs['status'], [3, 5])) {
                    $leadInputs['is_completed'] = 1;
                }

                if($lead->update($leadInputs)) {
                    $commentsInputs = new Comments;
                    $commentsInputs->user_id  = $userId;
                    $commentsInputs->comments = $inputs['comments'];
                    $comments = $lead->comments()->save($commentsInputs);
                } else {
                    $messageText = 'Error occurs please try again.';
                    return response()->json(['error' => $messageText], 403);
                    //return redirect()->back()->withError('Error occurs please try again.');
                }

                \DB::commit();

                $messageText = 'Lead successfully approved.';
                if($inputs['status'] == 4) {
                    $messageText = 'Lead successfully rejected.';
                }
                return response()->json(['success' => $messageText], 200);
                
            } catch (\PDOException $e) {
                \DB::rollBack();

                $messageText = 'approved.';
                if($inputs['status'] == 4) {
                    $messageText = 'rejected.';
                }
                return response()->json(['error' => $messageText], 403);
        //return redirect()->back()->withError('Database Error: The lead could not be '.$messageText.'.')->withInput($inputs);
            } catch (\Exception $e) {
                \DB::rollBack();
                $messageText = 'Error code 500: internal server error.';
                return response()->json(['error' => $messageText], 403);
               // return redirect()->back()->withError('Error code 500: internal server error.')->withInput($inputs);
            }
        }
    }//end of function


    /**
     * listing the approved specified resource from storage.     
    */
    public function approveLead(Request $request)
    {
        $authUser = \Auth::user();
        $userId   = $authUser['id']; 


        $hodId = $rawQry = $teamRoleId = null; $teamUsers = [];

        $leadType = 'all';
        if($request->isMethod('get') && !empty($request->all())) {
            $inputs = $request->all();

            if($userId == 13) {
                if(isset($inputs['lead_type']) && $inputs['lead_type'] == 'created') {
                    $leadType = 'created';
                } else {
                    $leadType = 'all';
                }
            } else {
                if(isset($inputs['lead_type']) && $inputs['lead_type'] == 'created') {
                    $leadType = 'created';
                } else if(isset($inputs['lead_type']) && $inputs['lead_type'] == 'assigned') {
                    $leadType = 'assigned';
                } else {
                    $leadType = 'all';
                }
            }
        }

        $filter = [];

        $userDetails = $authUser->employeeProfile()->first();
        $bdMember = BdTeamMember::Where('user_id', $userId)->first();

        $bdUser = User::with('employee')->whereHas('employeeProfile', function (Builder $query) use($userDetails) {
            $departmentId = $userDetails->department_id; // B.D department id
            $query->where(['department_id' => $departmentId]);
        })->first();

        $teamHodId = $bdUser->leaveAuthorities()->where(['leave_authorities.priority' => '2'])->pluck('manager_id')->first();

        $existingUsers = BdTeamMember::where('isactive', 1)->pluck('team_role_id', 'user_id')->all();

       if(!empty($existingUsers) && isset($existingUsers[$userId]) && $existingUsers[$userId]) {
            $teamRoleId = $existingUsers[$userId]; // 1->executive, 2 -> manager

            if($teamRoleId == 1) {
                $filter['executive_id'] = $userId;
            } else if($teamRoleId == 2) {
                $teamUsers = array_keys($existingUsers);
            }
        } else if(!empty($teamHodId) && $teamHodId == $userId) {
            $hodId = $teamHodId;
            $teamUsers = array_keys($existingUsers);
        } else {
            if($userId != 13) {
                $filter['user_id'] = $userId;
            }
        }
        // status == 1 New, 2 Open, 3 Complete, 4 Rejected by Hod, 5 Closed, 6 Abandoned,
        $leadList = Lead::with(['userEmployee', 'source', 'industry', 'tilDraft']);
        
        if(!empty($filter) && isset($filter['executive_id']) || !empty($teamUsers)) {
            
            if($leadType == 'created') {
                $leadList->where('user_id', $userId);
            } else if($leadType == 'assigned') {
                
                if(!empty($filter['executive_id'])) {
                    $leadList->where('executive_id', $filter['executive_id']);
                } else {
                    $leadList->where('executive_id', $userId);
                }

            }/* else {
                $leadList->whereIn('executive_id', $teamUsers);
            }*/
        } else {

            if($userId == 13 && $leadType == 'created') {
                $leadList->where('user_id', $userId);
            } else {
                $leadList->where($filter);
            }
        }

        $leadList->where(['isactive' => 1, 'is_completed' => 1, 'status' => 5]);
        
        $leadList = $leadList->orderBy('id', 'desc')->get();
        $leadList = $leadList->all();
        $success['leadList'] = $leadList;
        $success['userId'] = $userId;
        $success['bdMember'] = $bdMember;
        $success['leadType'] = $leadType;
        
        //return view('leads_management.list_lead_approvals', compact('leadList', 'userId', 'userId', 'bdMember', 'leadType'));
      return response()->json(['success' => $success], 200);
    }//end of function

    /**
     * Show the form for editing the specified resource.
    */
    public function viewLead($id = null)
    {
        if(!$id) {
            $message = 'Invalid id provided';            
            return response()->json(['error' => $message], 403);
        }

        $authUser = \Auth::user();
        $userId   = $authUser['id'];

        if(in_array($userId, [1, 13])) {
          $message = 'Request not allowed.';
          //return redirect()->route('leads-management.get-leads')->withError($message);
          return response()->json(['error' => $message], 403);
        }

        $rawQry = $teamRoleId = $teamUsers = $hodId = null;
        $filter = "id = ". $id;

        $userDetails = $authUser->employeeProfile()->first();
        $bdMember = BdTeamMember::Where('user_id', $userId)->first();//1->executive, 2->manager
        
        $bdUser = User::with('employee')->whereHas('employeeProfile', function (Builder $query) use($userDetails) {
            $departmentId = $userDetails->department_id; // B.D department id
            $query->where(['department_id' => $departmentId]);
        })->first();

        $teamHodId = $bdUser->leaveAuthorities()->where(['leave_authorities.priority' => '2'])->pluck('manager_id')->first();

        $existingUsers=BdTeamMember::where('isactive',1)->pluck('team_role_id','user_id')->all();

        if(!empty($existingUsers) && isset($existingUsers[$userId]) && $existingUsers[$userId]) {
            $teamRoleId = $existingUsers[$userId]; // 1->executive, 2 -> manager

            /*if($teamRoleId == 1) {
                $filter .= " AND (user_id = ". $userId ." OR executive_id = ". $userId ." )";
            }*/
        } else if(!empty($teamHodId) && $teamHodId == $userId) {
            $hodId   = $teamHodId;
           /* $teamUsers = array_keys($existingUsers);
            $filter .= " AND (executive_id IN(". implode(',', $teamUsers) ."))";*/
        } else {
            $hodId = null;
            $filter .= " AND (user_id = ". $userId .")";
        }

        $filter .= ' AND status IN (1,2,3,4,5)'; // 6
        $lead = Lead::whereRaw($filter)->first();

        if(!$lead) {
            $message = 'No data found.';
            
            return response()->json(['error' => $message], 403);
        }

        $leadSourceOptions   = (new LeadSource)->getListLeadSource();
        $leadIndustryOptions = (new LeadIndustry)->getListLeadIndustry();

        $success['lead'] = $lead;
        $success['leadSourceOptions'] = $leadSourceOptions;
        $success['leadIndustryOptions'] = $leadIndustryOptions;
        $success['bdMember'] = $bdMember;
        $success['hodId'] = $hodId;
        $success['authUser'] = $authUser;

        return response()->json(['success' => $success], 200);
       
    }//end of function


}
