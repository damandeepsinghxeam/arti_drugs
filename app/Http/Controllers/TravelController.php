<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use View;
use Mail;
use App\Company;
use App\Location;
use App\State;
use App\EsiRegistration;
use App\PtRegistration;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\User;
use App\Employee;
use App\Log;
use App\Project;
use App\ProjectContact;
use App\Country;
use App\City;
use App\SalaryStructure;
use App\SalaryCycle;
use App\DocumentCategory;
use App\Department;
use App\LeaveAuthority;
use App\Conveyance;
use App\Band;

//Leads Module Models
use App\Lead;
use App\Til;

//Travel Module Models
use App\TravelCategories;
use App\Travel;
use App\TravelLocal;
use App\TravelNational;
use App\TravelImprest;
use App\TravelApproval;
use App\TravelOtherApproval;
use App\TravelStay;
use App\TravelClaim;
use App\TravelClaimDetail;
use App\TravelClaimStay;
use App\TravelClaimAttachment;
//Travel Authority Module Models
use App\TravelAuthority;
use App\TravelClimber;
//Travel Logs Models
use App\TravelLogs;

//comments Models
use App\Comments;

use App\Mail\GeneralMail;
use stdClass;
use Validator;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\Eloquent\Builder;

class TravelController extends Controller
{
    public function dashboard(Request $request)
    {
        if($request->isMethod('post') && $request->btn_submit && $request->id)
        {
            try {
                \DB::beginTransaction();

                $id = decrypt($request->id);

                if($request->mark == 'discussion') {
                    $status  = 'discussion';
                    $message = 'Travel Approval marked for discussion.';
                }
                elseif($request->mark == 'hold') {
                    $status  = 'hold';
                    $message = 'Travel Approval marked on hold.';
                }
                elseif($request->mark == 'discarded') {
                    $status  = 'discarded';
                    $message = 'Travel Approval marked as discarded.';
                }
                elseif($request->mark == 'approved') {
                    $status  = 'approved';
                    $message = 'Travel Approval marked as approved.';
                }
                else {
                    exit;
                }

                if(!$request->id) {
                    exit;
                }

                $id     = decrypt($request->id); // TravelApproval
                $user   = \Auth::user(); // Auth::id()
                $travel = Travel::find($id);

                if(!empty($travel)) {
                    $filter = ['user_id' => $travel->user_id, 'manager_id' => $user->id, 'authority_type' => 'pre_approval', 'isactive' => 1
                    ];

                    $authority = TravelAuthority::where($filter)->first();

                    if($authority) {
                        $climber = TravelClimber::where(['travel_id' => $travel->id, 'climber_user_id' => $user->id])->whereNull('deleted_at')->first();

                        // discussion, discarded
                        if($climber) {
                            $climber->status  = $status;
                            $climber->remarks = $request->remarks;
                            $climber->save();

                            if($status == 'discarded') {
                                $travel->status      = $status;
                                $travel->approved_by = $user->id;
                                $travel->remarks     = $request->remarks;
                                $travel->save();

                                $priorityText = $authority->user_role;
                                $remarks = $priorityText . ' has marked travel request as rejected with travel Code "'.$travel->travel_code.'"';

                                $travelLogsInputs = new TravelLogs;
                                $travelLogsInputs->user_id = $authority->manager_id;
                                $travelLogsInputs->remarks = $remarks;
                                $travelLogs = $travel->logs()->save($travelLogsInputs);

                                /***************Push Notification Code**************************/
                                $employee = Employee::where(['user_id' => $authority->manager_id])->first();

                                $notificationData['message'] = str_replace('  ', ' ', $employee->fullname)." has rejected your travel request - '".$travel->travel_code."'.";
                                $title = 'Travel Request has rejected.';
                                $body  = $notificationData['message'];
                                pushNotification($travel->user_id, $title, $body);
                                sms($travel->user->employee->mobile_number, $body);
                                /***************Push Notification Code**************************/
                            } else if($status == 'discussion') {
                                $priorityText = $authority->user_role;
                                $remarks = $priorityText . " has marked travel request as to be discussed with travel Code '".$travel->travel_code."'.";

                                $travelLogsInputs = new TravelLogs;
                                $travelLogsInputs->user_id = $authority->manager_id;
                                $travelLogsInputs->remarks = $remarks;
                                $travelLogs = $travel->logs()->save($travelLogsInputs);

                                /***************Push Notification Code**************************/
                                $employee = Employee::where(['user_id' => $authority->manager_id])->first();
                                $notificationData['message'] = str_replace('  ', ' ', $employee->fullname)." has asked to discuss your travel request - '".$travel->travel_code."'.";

                                $title = 'Travel Request asked to discuss.';
                                $body  = $notificationData['message'];
                                pushNotification($travel->user_id, $title, $body);
                                sms($travel->user->employee->mobile_number, $body, 'IMP');
                                /***************Push Notification Code**************************/
                            }
                        }

                        if(!in_array($status, ['discussion', 'discarded'])) {
                            $priority  = $authority->priority;

                            $travelAuthority = TravelAuthority::where(['user_id' => $travel->user_id, 'authority_type' => 'pre_approval', 'isactive' => 1
                            ])->where('priority', '>', $priority)->first();

                            if($travelAuthority) {
                                $travelClimber = TravelClimber::where(['travel_id' => $travel->id, 'climber_user_id' => $travelAuthority->manager_id, 'status' => 'new'])
                                ->whereNull('deleted_at')->first();

                                if (!$travelClimber) {

                                    $priorityText = $authority->user_role;
                                    $remarks = $priorityText . " has marked travel request as ".$status." with travel Code '".$travel->travel_code."'.";

                                    $travelLogsInputs = new TravelLogs;
                                    $travelLogsInputs->user_id = $authority->manager_id;
                                    $travelLogsInputs->remarks = $remarks;
                                    $travelLogs = $travel->logs()->save($travelLogsInputs);

                                    $climberInputs = new TravelClimber;
                                    $climberInputs->climber_user_id  = $travelAuthority->manager_id;
                                    $climberInputs->status           = 'new';
                                    $climberInputs->remarks          = null;
                                    $travelClimber = $travel->travelClimber()->save($climberInputs);

                                    /***************Push Notification Code**************************/
                                    $employee = Employee::where(['user_id' => $authority->manager_id])->first();

                                    $notificationData['message'] = str_replace('  ', ' ', $employee->fullname)." has ". $status ." your travel request - '".$travel->travel_code."'.";

                                    $title = 'Travel Request marked as ' . $status;
                                    $body  = $notificationData['message'];
                                    pushNotification($travel->user_id, $title, $body);
                                    sms($travel->user->employee->mobile_number, $body);
                                    /***************Push Notification Code**************************/
                                    /***************Push Notification Code**************************/
                                    pushNotification($travelAuthority->manager_id, $title, $body);
                                    sms($travelAuthority->manager->employee->mobile_number, $body, 'ACT');
                                    /***************Push Notification Code**************************/
                                    /***************Send Mail Code**************************/
                                    /*if(!empty($message)) {
                                        $mail_data['to_email'] = $employee->user->email;
                                        $mail_data['fullname'] = $employee->fullname;
                                        $mail_data['subject'] = $title;
                                        $mail_data['message'] = $body;
                                        $this->sendGeneralMail($mail_data);
                                    }*/
                                    /***************Send Mail Code**************************/
                                }
                            } else {
                                $travel->status      = $status;
                                $travel->approved_by = $user->id;
                                $travel->remarks     = $request->remarks;
                                $travel->save();

                                $priorityText = $authority->user_role;
                                $remarks = $priorityText . ' has '.$status.' a travel request with Travel Code "'.$travel->travel_code.'"';

                                $travelLogsInputs = new TravelLogs;
                                $travelLogsInputs->user_id = $authority->manager_id;
                                $travelLogsInputs->remarks = $remarks;
                                $travelLogs = $travel->logs()->save($travelLogsInputs);

                                /***************Push Notification Code**************************/
                                $employee = Employee::where(['user_id' => $authority->manager_id])->first();
                                $notificationData['message'] = str_replace('  ', ' ', $employee->fullname)." has ". $status ." your travel request - '".$travel->travel_code."'.";

                                $title = 'New Travel Request Added';
                                $body  = $notificationData['message'];
                                pushNotification($travel->user_id, $title, $body);
                                sms($travel->user->employee, $body);
                                /***************Push Notification Code**************************/
                            }
                        }
                    }
                    /*else {
                        if($status != 'discussion') {
                            $travel->status      = $status;
                            $travel->approved_by = $user->id;
                            $travel->remarks     = $request->remarks;
                            $travel->save();
                        }

                        $climber = TravelClimber::where(['travel_id' => $travel->id, 'climber_user_id' => $user->id])->whereNull('deleted_at')->first();

                        if($climber) {
                            $climber->status  = $status;
                            $climber->remarks = $request->remarks;
                            $climber->save();
                        }
                    }*/
                }
                \DB::commit();

                return redirect()->back()->with('success', $message);
            } catch (\PDOException $e) {
                \DB::rollBack();
                return redirect()->back()->withError('Database Error: Travel could not be saved.')->withInput($request->all());
            } catch (\Exception $e) {
                \DB::rollBack();
                // $e->getMessage()
                $message = 'Error code 500: internal server error.';
                return redirect()->back()->withError($message)->withInput($request->all());
            }
        } else {
           return redirect(url('travel/approval-requests'))->withError('Invalid Request Error.');
        }
    }

    public function getClaimDefaultValues($id)
    {
        // TravelApproval
        // 'city_from', 'city_from.state', 'city_to', 'city_to.state',
        $data['approval'] = Travel::where('id', $id)
                        ->with([
                            'project', 'tils', 'approved_by_user.employee',
                            'user.designation.band', 'user.employeeAccount',
                            'travelStay', 'travelLocal', 'travelNational',
                            'travelNational.conveyance', 'imprest',
                            'otherApproval', 'user.employee'
                        ])->first();

        $data['states'] = State::where(['isactive'=>1])->get();
        $data['cities'] = City::where('isactive', 1)->with('city_class')->orderBy('name', 'ASC')->get();

        $userId = (!empty($data['approval']))? $data['approval']->user_id : Auth::id();
        $data['user']   = User::where(['id'=> $userId])->first();

        $data['conveyances_local']=Conveyance::where(['isactive'=> 1, 'islocal'=> 1])->orderBy('name', 'asc')->pluck('name')->toArray();

        $data['conveyance_national'] = @$data['user']->designation[0]->band->travel_conveyances->pluck('name')->toArray();

        $claimed_amount = $eligible_amount_stay = $stay_sum = 0;
        $localConveyance = $nationalConveyance = null;

        if($data['approval']->travel_type == 2) {

            if($data['approval']->travelStay->count()) {
                foreach ($data['approval']->travelStay as $stay) {
                    $days_between_dates = claculateNightsTwoDates($stay->from_date, $stay->to_date);
                    $stay_sum += ($stay->rate_per_night * $days_between_dates) + $stay->da;

                    $band_class = getBandCityClassDetails($data['approval']->user->designation[0]->band_id, $stay->city->city_class_id);
                    //echo '('.$band_class->price.'+'.$data['approval']->user->designation[0]->band->food_allowance.')*'.$days_between_dates.'<br>';
                    $eligible_amount_stay+=($band_class->price+$data['approval']->user->designation[0]->band->food_allowance)*$days_between_dates;
                }
            }
        }

        // $local_conveyances=implode(",",$data['approval']->conveyance_local->pluck('name')->toArray());
        /*$local_conveyances = implode(", ", $data['conveyances_local']);*/
        $travel_conveyance = implode(", ", $data['conveyance_national']);

        $data['conveyances'] = Conveyance::where('isactive', 1)->orderBy('islocal', 'ASC')->orderBy('name', 'ASC')->get();
        // trim($travel_conveyance . ', '. $local_conveyances, ', ');
        $data['eligible_conveyance']  = trim($travel_conveyance, ', ');
        $data['eligible_amount_stay'] = $eligible_amount_stay;
        $data['stay_sum']             = $stay_sum;

        /****************************** Things Might not be needed ****************************/
        $data['amount_approved']      = ($data['approval']->expected_amount + $data['approval']->expected_amount_local + $data['stay_sum']);

        if($data['approval']->other_approval) {
            $data['amount_approved'] += $data['approval']->other_approval->amount;
        }
        /****************************** Things Might not be needed ****************************/
        return $data;
    }

    //Display travel approval forma and save
    public function approvalRequests(Request $request)
    {
        $data['user'] = User::where(['id'=>Auth::id()])->first();
        $data['filter_status'] = 'new';
        $data['list_type']     = '';

        if($request->filter_status) {
            $data['filter_status'] = $request->filter_status;
        }
        if($request->list_type) {
            $data['list_type'] = $request->list_type;
        }

        //TravelApproval
        /*$travelObj = Travel::where('status', 'new'); // $data['filter_status']*/
        $travelObj = Travel::with([
                        'project', 'tils', 'user.designation.band',
                        'travelStay', 'travelLocal', 'travelNational',
                        'imprest', 'otherApproval', 'user.employee', 'travelClimberUser'
                    ]);

        if (!$data['user']->can('approve-travel')) {
            $travelObj->with('claims')->where('status', $data['filter_status'])->where('user_id', Auth::id());
        } else {

            if($data['list_type'] == 'created') {
                $travelObj->with('claims')->where('status', $data['filter_status'])->where('user_id', Auth::id());
            } else {
                $userId = $data['user']->id;

                $travelObj->with(['claims.climber' => function ($qry) use($userId) {
                    $qry->where(['climber_user_id' => $userId]);
                }])->whereHas('travelClimber', function (Builder $query) use($userId, $data) {
                    $query->where(['climber_user_id' => $userId, 'status' => $data['filter_status']]);
                });
            }
        }

        $data['approvals'] = $travelObj->orderBy('created_at', 'desc')->get();
        return view('travel.approval-requests')->with(['data'=>$data]);
    }

    public function approvalRequestsDetails(Request $request)
    {
        if(!$request->id) {
            exit;
        }

        $id           = decrypt($request->id);
        $data         = $this->getClaimDefaultValues($id);
        $data['user'] = User::where(['id' => Auth::id()])->first();
        $userId       = $data['user']->id;
        // DB::enableQueryLog();
        //TravelApproval
        $travelObj = Travel::where('id', $id);
        $preApproval = $travelObj->first();

        if ((!$data['user']->can('approve-travel') && !auth()->user()->can('verify-travel-claim') && !auth()->user()->can('pay-travel-claim')) || $preApproval->user_id == $userId) {
            $travelObj->where('user_id', $userId);
        } else {
            if(!auth()->user()->can('verify-travel-claim') && !auth()->user()->can('pay-travel-claim')) {

                $travelObj->whereHas('travelClimber', function (Builder $query) use($userId) {
                    $query->where(['climber_user_id' => $userId]);
                });
            }
        }

        //TravelApproval
        // 'city_from', 'city_from.state', 'city_to', 'city_to.state',
        $data['approval'] = $travelObj->with([
                                'project', 'tils', 'user.designation.band',
                                'travelLocal', 'travelNational', 'travelStay',
                                'imprest', 'otherApproval', 'user.employee',
                                'travelClimberUser'
                                /*'travelClimber' => function ($query) use($userId) {
                                    $query->where(['climber_user_id' => $userId]);
                                }*/
                            ])->orderBy('created_at', 'desc')
                            ->first();

        return view('travel.approval-requests-details', $data);
    }

    public function approvalForm(Request $request)
    {
        $data['countries'] = Country::where(['isactive'=>1])->get();
        $data['states']    = State::where(['isactive'=>1])->get();
        $data['user']      = User::with(['designation',
                                'designation.band.local_conveyances',
                                'designation.band.travel_conveyances'
                            ])->where([ 'id' => Auth::id() ])->first();

        $data['projects']    = Project::where('isactive', 1)->orderBy('name', 'asc')->get();
        $data['conveyances'] = Conveyance::where('isactive', 1)->where('islocal', 0)->orderBy('name', 'asc')->get();

        $data['conveyances_local'] = Conveyance::where('isactive', 1)->where('islocal', 1)->orderBy('name', 'asc')->get();

        $data['new_projects'] = Til::where(['isactive' => 1, 'status' => 8])->where('user_id', '<>', 0)->get();

        $data['cities'] = City::where('isactive', 1)->with('city_class')->get();

        $data['categories'] = TravelCategories::where('isactive', 1)->orderBy('name', 'ASC')->get();

        $travel_date_from = $travel_date_to = null;
        if($request->isMethod('post') && $request->btn_submit) {
            //return $request->all();
            try {
                \DB::beginTransaction();

                $travelCount  = Travel::count() + 1;
                $serialNumber = generateSerialNumber($travelCount);

                $travel                           = new Travel;
                $travel->user_id                  = $data['user']->id;
                $travel->travel_for               = null;

                if (isset($request->isclient) && !empty($request->isclient)) {
                    $travel->travel_for           = $request->isclient;
                }

                $travel->category_id              = $request->category_id;
                $travel->project_id               = $request->existing_customer;
                $travel->til_id                   = $request->future_customer;
                $travel->others                   = $request->local_others;
                $travel->travel_code              = $serialNumber;
                $travel->travel_purpose           = $request->purpose_pre;
                $travel->total_amount             = $request->total_travel_amount;
                $travel->travel_type              = $request->travel_type;
                $travel->cover_under_policy       = $request->cover_under_policy;
                $travel->stay                     = $request->stay;
                $travel->other_financial_approval = $request->other_financial_approval;
                $travel->imprest_request          = $request->imprest_request;

                $travel->status                   = 'new';
                $travel->isactive                 = 1;
                $travel->save();

                if(!empty($travel) && $request->travel_type == 1) {
                    $travelLocalInputs = new TravelLocal;
                    $travelLocalInputs->approval_duration = $request->approval_duration;
                    $travelLocalInputs->city_id           = $request->city_id_to_local;
                    $travelLocalInputs->conveyance_id     = $request->local_conveyance;
                    $travelLocalInputs->travel_amount     = $request->local_travel_amount;
                    $travelLocal = $travel->travelLocal()->save($travelLocalInputs);

                } else {
                    if(isset($request->travel_date) && count($request->travel_date) > 0) {
                        $travelDates = $request->travel_date;
                        foreach ($travelDates as $key => $date) {

                            if(!empty($date)) {

                                $travelInputs = new TravelNational;
                                $travelInputs->travel_date = date('Y-m-d', strtotime($date));

                                $travelInputs->from_city_id = null;
                                if (isset($request->city_id_from_pre[$key]) && !empty($request->city_id_from_pre[$key])) {
                                    $travelInputs->from_city_id = $request->city_id_from_pre[$key];
                                }

                                $travelInputs->to_city_id = null;
                                if (isset($request->city_id_to_pre[$key]) && !empty($request->city_id_to_pre[$key])) {
                                    $travelInputs->to_city_id = $request->city_id_to_pre[$key];
                                }

                                $travelInputs->conveyance_id = null;
                                if (isset($request->conveyance_id[$key]) && !empty($request->conveyance_id[$key])) {
                                    $travelInputs->conveyance_id = $request->conveyance_id[$key];
                                }

                                $travelInputs->distance_in_km = 0;
                                if (isset($request->distance_in_km[$key]) && !empty($request->distance_in_km[$key])) {
                                    $travelInputs->distance_in_km = $request->distance_in_km[$key];
                                }

                                $travelInputs->travel_amount = 0;
                                if (isset($request->amount[$key]) && !empty($request->amount[$key])) {
                                    $travelInputs->travel_amount = $request->amount[$key];
                                }

                                $travelNational = $travel->travelNational()->save($travelInputs);
                            }
                        }
                    }

                    if(!empty($request->stay)) {
                        $stayDateRange = $request->stay_date_range;
                        if(!empty($stayDateRange) && count($stayDateRange) > 0) {
                            foreach ($stayDateRange as $dRKy => $dateRange) {

                                if(!empty($dateRange)) {

                                    $stayDateRangeArr = explode("-", $dateRange);
                                    $stayDateFrom = date("Y-m-d", strtotime(trim($stayDateRangeArr[0])));
                                    $stayDateTo   = date("Y-m-d", strtotime(trim($stayDateRangeArr[1])));

                                    $stayInputs = new TravelStay;

                                    $stayInputs->from_date      = $stayDateFrom;
                                    $stayInputs->to_date        = $stayDateTo;

                                    $stayInputs->city_id = null;
                                    if (isset($request->city_id_stay[$dRKy]) && !empty($request->city_id_stay[$dRKy])) {
                                        $stayInputs->city_id = $request->city_id_stay[$dRKy];
                                    }

                                    $stayInputs->rate_per_night = 0;
                                    if (isset($request->rate_per_night[$dRKy]) && !empty($request->rate_per_night[$dRKy])) {
                                        $stayInputs->rate_per_night = $request->rate_per_night[$dRKy];
                                    }

                                    $stayInputs->da = 0;
                                    if (isset($request->da[$dRKy]) && !empty($request->da[$dRKy])) {
                                        $stayInputs->da = $request->da[$dRKy];
                                    }

                                    $travelStay = $travel->travelStay()->save($stayInputs);
                                }
                            }
                        }
                    }

                    if($request->other_financial_approval) {
                        // $obj->travel_approval_id=$tavel_approval_id;
                        $otherApprovalInputs = new TravelOtherApproval;

                        $otherApprovalInputs->country_id = $request->country_id_other;
                        $otherApprovalInputs->state_id   = $request->state_id_other;
                        $otherApprovalInputs->city_id    = $request->city_id_other;
                        $otherApprovalInputs->purpose    = $request->purpose_other;
                        $otherApprovalInputs->amount     = $request->amount_other;

                        $travelOtherApproval = $travel->otherApproval()->save($otherApprovalInputs);

                        DB::table('travel_other_approvalables')->insert([
                            'travel_other_approvalable_type' => 'App\Project',
                            'travel_other_approvalable_id' => $request->project_id_other,
                            'travel_other_approval_id' => $travelOtherApproval->id,
                            'created_at' => date('Y-m-d H:i:s')
                        ]);
                    }

                    if($request->imprest_request) {
                        $imprestInputs = new TravelImprest;

                        $imprestInputs->remarks_by_applicant = $request->remarks;
                        $imprestInputs->amount               = $request->amount_imprest;
                        $travelImprest = $travel->imprest()->save($imprestInputs);

                        DB::table('travel_imprestables')->insert([
                            'travel_imprestable_type' => 'App\Project',
                            'travel_imprestable_id' => $request->project_id_imprest,
                            'travel_imprest_id' => $travelImprest->id,
                            'created_at' => date('Y-m-d H:i:s')
                        ]);
                    }
                }

                if(!empty($travel)) {

                    $remarks = str_replace('  ', ' ', $travel->user->employee->fullname) . ' has raised a new travel request with travel code "'.$travel->travel_code.'"';

                    $travelLogsInputs = new TravelLogs;
                    $travelLogsInputs->user_id = $travel->user_id;
                    $travelLogsInputs->remarks = $remarks;
                    $travelLogs = $travel->logs()->save($travelLogsInputs);

                    $authorityFilter = ['priority' => 1, 'authority_type' => 'pre_approval',
                        'isactive' => 1, 'user_id' => $travel->user_id
                    ];

                    $travelAuthority = TravelAuthority::where($authorityFilter)->first();

                    if($travelAuthority) {
                        $travelClimber = TravelClimber::where(['travel_id' => $travel->id, 'climber_user_id' => $travelAuthority->manager_id, 'status' => 'new'])
                        ->whereNull('deleted_at')->first();

                        if (!$travelClimber) {
                            $climberInputs = new TravelClimber;
                            $climberInputs->climber_user_id  = $travelAuthority->manager_id;
                            $climberInputs->status           = 'new';
                            $climberInputs->remarks          = null;
                            $travelClimber = $travel->travelClimber()->save($climberInputs);

                            /***************Push Notification Code**************************/
                            $employee = Employee::where(['user_id' => $travel->user_id])->first();
                            $notificationData['message'] = str_replace('  ', ' ', $employee->fullname) . " has raised a new travel request - '".$travel->travel_code."'.";

                            $title = 'New Travel Request Added';
                            $body  = $notificationData['message'];
                            pushNotification($travelAuthority->manager_id, $title, $body);
                            sms($employee->mobile_number, $body, 'ACT');
                            /***************Push Notification Code**************************/
                            /***************Send Mail Code**************************/
                            /*if(!empty($message)){
                                $mail_data['to_email'] = $employee->user->email;
                                $mail_data['fullname'] = $employee->fullname;
                                $mail_data['subject'] = $title;
                                $mail_data['message'] = $body;
                                $this->sendGeneralMail($mail_data);
                            }*/
                            /***************Send Mail Code**************************/
                        }
                    }
                }

                \DB::commit();

                return redirect()->back()->with('success', 'Travel Approval saved successfully.');

            } catch (\PDOException $e) {
                \DB::rollBack();

                return redirect()->back()->withError('Database Error: Travel could not be saved.')->withInput($request->all());
            } catch (\Exception $e) {
                \DB::rollBack();

                $message = 'Error code 500: internal server error.';
                return redirect()->back()->withError($message)->withInput($request->all());
            }
        }
        return view('travel.approval_form')->with(['data' => $data]);
    }

    public function claimView(Request $request)
    {
        if(!$request->id) {
            $message = 'Request Id not found.';
            return redirect()->back()->withError($message);
        }

        $id           = decrypt($request->id);
        $data['user'] = User::where(['id'=>Auth::id()])->first();
        $userId       = $data['user']->id;

        $claims = TravelClaim::where('id', $id)->where('isactive', 1);// where('travel_id', $id)
        $claimForm = $claims->first();

        if ($claimForm->user_id == $userId || (!$data['user']->can('approve-travel-claim') && !$data['user']->can('verify-travel-claim') && !$data['user']->can('pay-travel-claim'))) {
            $claims->where('user_id', $userId);
        } else {
            $claims->whereHas('climber', function (Builder $query) use($userId) {
                $query->where(['climber_user_id' => $userId]);
            });
        }

        $claims = $claims->with([
                    'claim_details', 'claim_stay', 'claim_attachments', 'climberUser',
                    'claim_details.expense_types', 'claim_attachments.attachment_types',
                    'authorities', 'logs'
                ])->first();

        if(!$claims) {
            return redirect()->back()->with('error', 'Claim not found.');
        }

        $travelId = $claims->travel_id;
        $data     = $this->getClaimDefaultValues($travelId);
        $data['claims'] = $claims;
        $data['userId'] = $userId;

        $data['climberCount'] = 0;
        if(!empty($claims->climberUser)) {
            $climberUser          = $claims->climberUser;
            $data['climberCount'] = $climberUser->where(['travel_claim_id' => $climberUser->travel_claim_id, 'climber_user_id' => $climberUser->climber_user_id])->count();
        }

        if($request->isMethod('post')) { // pay_approve

            $claimInputs = $claimDetailInputs = $claimAttachmentInputs = [];
            $message = null; $status = null; $messageType = null;

            if($request->action_type == 'pay_approve') {
                if(TravelClaim::where('id', '!=', $claims->id)->where('utr', $request->utr)->count()) {
                    return redirect()->back()->with('danger', 'UTR already exists.');
                }
            }

            $travelClaim = TravelClaim::find($claims->id);

            $travelClaimDetail = TravelClaimDetail::where('travel_claim_id', $travelClaim->id);
            $travelClaimStay   = TravelClaimStay::where('travel_claim_id', $travelClaim->id);
            $travelAttachment  = TravelClaimAttachment::where('travel_claim_id', $travelClaim->id);

            try {
                \DB::beginTransaction();

                if($request->action_type == 'send_it_back') {
                    $travelClaim->status = 'back';
                    $travelClaim->ispaid = 0;
                    $travelClaim->update();

                    $status = 'back';
                    $messageType = 'success';
                    $message = 'Claim sent back successfully.';

                    if(!empty($request->claim_details) && count($request->claim_details) > 0) {
                        $travelClaimDetail = TravelClaimDetail::whereIn('id', $request->claim_details)
                                        ->update(['status' => 'back']);
                    }

                    if(!empty($request->claim_stays) && count($request->claim_stays) > 0) {
                        $travelClaimStay = TravelClaimStay::whereIn('id', $request->claim_stays)
                                    ->update(['status' => 'back']);
                    }

                    if(!empty($request->claim_attachments) && count($request->claim_attachments) > 0) {
                       $travelAttachment = TravelClaimAttachment::where('id', $request->claim_attachments)
                                            ->update(['status' => 'back']);
                    }
                } else {

                    if($request->action_type == 'approve') {
                        /*$travelClaim->ispaid = 0;
                        $travelClaim->utr    = null;
                        $travelClaim->status = 'approved';*/
                        /*$travelClaimDetail->update(['status' => 'approved']);
                        $travelClaimStay->update(['status' => 'approved']);
                        $travelAttachment->update(['status' => 'approved']);*/

                        $status = 'approved';
                        $messageType = 'success';
                        $message = 'Claim approved successfully.';
                    }
                    else if($request->action_type == 'reject') {
                        $travelClaim->ispaid = 0;
                        $travelClaim->utr    = null;
                        $travelClaim->status = 'rejected';
                        $travelClaim->update();
                        $travelClaimDetail->update(['status' => 'rejected']);
                        $travelClaimStay->update(['status' => 'rejected']);
                        $travelAttachment->update(['status' => 'rejected']);

                        $status = 'rejected';
                        $messageType = 'success';
                        $message = 'Claim rejected successfully.';
                    }
                    else if($request->action_type == 'pay_approve') {
                        $travelClaim->ispaid = 1;
                        $travelClaim->utr    = $request->utr;
                        $travelClaim->status = 'paid';
                        $travelClaim->payment_date = date('Y-m-d');
                        $travelClaim->update();

                        $travelClaimDetail->update(['status' => 'paid']);
                        $travelClaimStay->update(['status' => 'paid']);
                        $travelAttachment->update(['status' => 'paid']);

                        $status = 'paid';

                        $messageType = 'success';
                        $message = 'Claim approved and paid successfully.';
                    }
                }

                if(isset($request->comments) && !empty($request->comments)) {
                    $commentsInputs = new Comments;
                    $commentsInputs->user_id  = $userId;
                    $commentsInputs->comments = $request->comments;
                    $comments = $travelClaim->comments()->save($commentsInputs);
                }

                $filter = ['user_id' => $claims->user_id, 'manager_id' => $userId, 'authority_type' => 'claim_approval', 'isactive' => 1
                ];

                if($request->action_type == 'pay_approve') {
                    $filter += ['priority' => $claims->climberUser->priority];
                }

                $authority = TravelAuthority::where($filter)->first();

                if($authority) {
                    $climber = TravelClimber::where(['travel_claim_id' => $claims->id, 'climber_user_id' => $userId])->whereNull('deleted_at')->latest()->first();

                    if($climber) {
                        $climber->status  = $status;
                        $climber->remarks = null;
                        $climber->save();
                    }

                    if(in_array($status, ['back', 'rejected'])) {
                        $actType = ($status == 'back')? 'send back' : $status;

                        $remarks = $authority->user_role . ' has marked travel claim request as '.$actType.' with travel Code "'.$travelClaim->claim_code.'"';

                        $travelLogsInputs = new TravelLogs;
                        $travelLogsInputs->user_id = $authority->manager_id;
                        $travelLogsInputs->remarks = $remarks;
                        $travelLogs = $travelClaim->logs()->save($travelLogsInputs);

                        /***************Push Notification Code**************************/
                        $employee = Employee::where(['user_id' => $authority->manager_id])->first();
                        $notificationData['message'] = str_replace('  ', ' ', $employee->fullname)." has ".$actType." your claim request - '".$travelClaim->claim_code."'.";
                        $title = 'Travel Request marked as '.$actType;
                        $body  = $notificationData['message'];
                        pushNotification($travelClaim->user_id, $title, $body);
                        sms($travelClaim->user->employee->mobile_number, $body, 'IMP');
                        /***************Push Notification Code**************************/
                        /***************Send Mail Code**************************/
                        /*$travelUser = Employee::where(['user_id' => $travelClaim->user_id])->first();
                        if(!empty($message)) {
                            $mail_data['to_email'] = $travelUser->user->email;
                            $mail_data['fullname'] = $travelUser->fullname;
                            $mail_data['subject'] = $title;
                            $mail_data['message'] = $body;
                            $this->sendGeneralMail($mail_data);
                        }*/
                        /***************Send Mail Code**************************/
                    }
                    elseif(in_array($status, ['approved', 'paid'])) { // $status != 'back'
                        $priority  = $authority->priority;

                        $actType = ($status == 'approved')? 'approved' : $status;

                        $travelAuthority = TravelAuthority::where(['user_id' => $claims->user_id, 'authority_type' => 'claim_approval', 'isactive' => 1
                        ])->where('priority', '>', $priority)->first();

                        if($travelAuthority) {
                            $travelClimber = TravelClimber::where([
                                                'travel_claim_id' => $claims->id,
                                                'climber_user_id' => $travelAuthority->manager_id,
                                                'priority'        => $travelAuthority->priority,
                                                'status'          => 'new'
                                            ])->whereNull('deleted_at')->first();

                            if (!$travelClimber) {
                                $climberInputs = new TravelClimber;
                                $climberInputs->climber_user_id  = $travelAuthority->manager_id;
                                $climberInputs->remarks  = null;
                                $climberInputs->priority = $travelAuthority->priority;
                                $climberInputs->status   = 'new';
                                $travelClimber = $claims->climber()->save($climberInputs);

                                $remarks = $authority->user_role . ' has marked travel claim request as '.$actType.' with travel Code "'.$travelClaim->claim_code.'"';

                                $travelLogsInputs = new TravelLogs;
                                $travelLogsInputs->user_id = $authority->manager_id;
                                $travelLogsInputs->remarks = $remarks;
                                $travelLogs = $travelClaim->logs()->save($travelLogsInputs);

                                /***************Push Notification Code**************************/
                                $employee = Employee::where(['user_id' => $authority->manager_id])->first();
                                $notificationData['message'] = str_replace('  ', ' ', $employee->fullname)." has ".$actType." your claim request - '".$travelClaim->claim_code."'.";

                                $title = 'Travel Claim Request marked as '.$actType;
                                $body  = $notificationData['message'];
                                pushNotification($travelClaim->user_id, $title, $body);
                                sms($travelClaim->user->employee->mobile_number, $body);
                                /***************Push Notification Code**************************/
                                /***************Push Notification Code**************************/
                                pushNotification($travelAuthority->manager_id, $title, $body);
                                sms($travelAuthority->manager->employee->mobile_number, $body, 'ACT');
                                /***************Push Notification Code**************************/
                                /***************Send Mail Code**************************/
                                /*if(!empty($message)) {
                                    $mail_data['to_email'] = $employee->user->email;
                                    $mail_data['fullname'] = $employee->fullname;
                                    $mail_data['subject'] = $title;
                                    $mail_data['message'] = $body;
                                    $this->sendGeneralMail($mail_data);
                                }*/
                                /***************Send Mail Code**************************/
                            }
                        }
                    }
                }
                \DB::commit();
                return redirect(url('travel/claim-requests/'))->with($messageType, $message);
            } catch (\PDOException $e) {
                \DB::rollBack();

                $message = 'Database Error: Travel Claim status could not be saved.';
                return redirect()->back()->withError($message)->withInput($request->all());
            } catch (\Exception $e) {
                \DB::rollBack();

                $message = 'Error code 500: internal server error.';
                return redirect()->back()->withError($message)->withInput($request->all());
            }
        }
        //return $data;
        return view('travel.claim.claim-view', $data);
    }

    public function claimForm(Request $request)
    {
        if(!$request->id)
        {
            return redirect()->back()->withError('Database Error: Travel could not be saved.')->withInput($request->all());
        }

        $id           = decrypt($request->id);
        $data         = $this->getClaimDefaultValues($id);
        $data['user'] = User::where(['id' => Auth::id()])->first();

        if(empty($data['approval']->user->employeeAccount)) {
            $message = "Bank details are missing. Please ask HR to enter the bank details on ERP Portal.";
            return redirect()->back()->withError($message);
        }

        if($request->isMethod('post')) {

            $inputs    = $request->all();
            $bankName  = $data['user']->employeeAccount->bank->name ?? null;
            $accountNo = $data['user']->employeeAccount->bank_account_number ?? null;
            $ifscCode  = $data['user']->employeeAccount->ifsc_code ?? null;

            $validator = (new TravelClaim)->validateTravelExpense($inputs);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->messages())->withInput($inputs);
            }

            $fileNameArr  = [];

            try {
                \DB::beginTransaction();

                $travelClaimCount = TravelClaim::count() + 1;
                $serialNumber = generateSerialNumber($travelClaimCount);

                $travelClaim                = new TravelClaim;
                $travelClaim->travel_id     = $id;
                $travelClaim->user_id       = $data['user']->id;
                $travelClaim->claim_code    = $serialNumber;

                if(isset($data['approval']->imprest->amount)) {
                    $travelClaim->imprest_taken = $data['approval']->imprest->amount;
                }

                $travelClaim->designation = $data['user']->designation[0]->name ?? null;
                $travelClaim->bank        = $bankName;
                $travelClaim->account_no  = $accountNo;
                $travelClaim->ifsc        = $ifscCode;
                $travelClaim->status      = 'new';
                $travelClaim->isactive    = 1;
                $travelClaim->save();


                if(isset($request->comments) && !empty($request->comments)) {
                    $commentsInputs = new Comments;
                    $commentsInputs->user_id  = $data['user']->id;
                    $commentsInputs->comments = $request->comments;
                    $comments = $travelClaim->comments()->save($commentsInputs);
                }

                if(isset($request->travel_expense) && count($request->travel_expense) > 0) {
                    $expense     = $inputs['travel_expense'];
                    $expenseDate = $inputs['travel_expense']['date'];

                    foreach ($expenseDate as $key => $date) {

                        if(!empty($date)) {
                            $claimDetails = new TravelClaimDetail;
                            $claimDetails->expense_date = date('Y-m-d', strtotime($date));

                            $claimDetails->from_location = null;
                            if (isset($expense['from_location'][$key]) && !empty($expense['from_location'][$key])) {
                                $claimDetails->from_location = $expense['from_location'][$key];
                            }

                            $claimDetails->to_location = null;
                            if (isset($expense['to_location'][$key]) && !empty($expense['to_location'][$key])) {
                                $claimDetails->to_location = $expense['to_location'][$key];
                            }

                            $claimDetails->expense_type = null;
                            if (isset($expense['expense_type'][$key]) && !empty($expense['expense_type'][$key])) {
                                $claimDetails->expense_type = $expense['expense_type'][$key];
                            }

                            $claimDetails->description = null;
                            if (isset($expense['description'][$key]) && !empty($expense['description'][$key])) {
                                $claimDetails->description = $expense['description'][$key];
                            }

                            $claimDetails->distance_in_km = 0;
                            if (isset($expense['distance_in_km'][$key]) && !empty($expense['distance_in_km'][$key])) {
                                $claimDetails->distance_in_km = $expense['distance_in_km'][$key];
                            }

                            $claimDetails->amount = 0;
                            if (isset($expense['amount'][$key]) && !empty($expense['amount'][$key])) {
                                $claimDetails->amount = $expense['amount'][$key];
                            }

                            $travelClaimDetail = $travelClaim->claim_details()->save($claimDetails);
                        }
                    }
                }

                if(isset($request->stay) && count($request->stay) > 0) {
                    $stay = $inputs['stay'];
                    $dateFrom = $stay['date_from'];

                    foreach ($dateFrom as $dk => $date) {

                        if(!empty($date)) {
                            $stayDetails = new TravelClaimStay;
                            $stayDetails->from_date = date('Y-m-d', strtotime($date));

                            $stayDetails->to_date = null;
                            if (isset($stay['date_to'][$dk]) && !empty($stay['date_to'][$dk])) {
                                $stayDetails->to_date = date('Y-m-d', strtotime($stay['date_to'][$dk]));
                            }

                            $stayDetails->state_id = null;
                            if (isset($stay['state_id'][$dk]) && !empty($stay['state_id'][$dk])) {
                                $stayDetails->state_id = $stay['state_id'][$dk];
                            }

                            $stayDetails->city_id = null;
                            if (isset($stay['city_id'][$dk]) && !empty($stay['city_id'][$dk])) {
                                $stayDetails->city_id = $stay['city_id'][$dk];
                            }

                            $stayDetails->rate_per_night = 0;
                            if (isset($stay['rate_per_night'][$dk]) && !empty($stay['rate_per_night'][$dk])) {
                                $stayDetails->rate_per_night = $stay['rate_per_night'][$dk];
                            }

                            $stayDetails->da = 0;
                            if (isset($stay['da'][$dk]) && !empty($stay['da'][$dk])) {
                                $stayDetails->da = $stay['da'][$dk];
                            }

                            $travelStayDetail = $travelClaim->claim_stay()->save($stayDetails);
                        }
                    }
                }

                if(isset($request->attachment) && count($request->attachment) > 0) {
                    $attachment = $inputs['attachment'];
                    $attachmentType = $attachment['attachment_type'];

                    foreach ($attachmentType as $k => $type) {

                        if(!empty($type)) {
                            $typeDetails = new TravelClaimAttachment;
                            $typeDetails->attachment_type = $type;

                            $typeDetails->name = null;
                            if (isset($attachment['name'][$k]) && !empty($attachment['name'][$k])) {
                                $typeDetails->name = $attachment['name'][$k];
                            }

                            $typeDetails->attachment = null;
                            if (isset($attachment['attachment'][$k]) && !empty($attachment['attachment'][$k])) {

                                $file = $attachment['attachment'][$k];

                                $fileOzName      = str_replace(' ', '', $file->getClientOriginalName());
                                $fileOzExtension = $file->getClientOriginalExtension();
                                $fileName        = time() . '_' . pathinfo(strtolower($fileOzName), PATHINFO_FILENAME) . '.' . $fileOzExtension;

                                $claimDocumentDir = \Config::get('constants.uploadPaths.claimDocument');

                                if (!is_dir($claimDocumentDir)) {
                                    mkdir($claimDocumentDir, 0775);
                                }

                                $file->move($claimDocumentDir, $fileName);

                                $fileNameArr['file'][] = $claimDocumentDir . $fileName;
                                $typeDetails->attachment = $fileName;
                            }
                            $attachmentsDetail = $travelClaim->claim_attachments()->save($typeDetails);
                        }
                    }
                }

                if(!empty($travelClaim)) {

                    $remarks = str_replace('  ', ' ', $travelClaim->user->employee->fullname) . ' has created a travel claim request with claim code "'.$travelClaim->claim_code.'"';

                    $travelLogsInputs = new TravelLogs;
                    $travelLogsInputs->user_id = $travelClaim->user_id;
                    $travelLogsInputs->remarks = $remarks;
                    $travelLogs = $travelClaim->logs()->save($travelLogsInputs);

                    $authorityFilter = ['priority' => 1, 'authority_type' => 'claim_approval',
                        'isactive' => 1, 'user_id' => $travelClaim->user_id
                    ];

                    $travelAuthority = TravelAuthority::where($authorityFilter)->first();

                    if($travelAuthority) {
                        $travelClimber = TravelClimber::where(['travel_claim_id' => $travelClaim->id, 'climber_user_id' => $travelAuthority->manager_id, 'status' => 'new'])->whereNull('deleted_at')->first();

                        if (!$travelClimber) {
                            $climberInputs = new TravelClimber;
                            $climberInputs->climber_user_id  = $travelAuthority->manager_id;
                            $climberInputs->remarks          = null;
                            $climberInputs->priority         = $travelAuthority->priority;
                            $climberInputs->status           = 'new';
                            $travelClimber = $travelClaim->climber()->save($climberInputs);

                            /***************Push Notification Code**************************/
                            $employee = Employee::where(['user_id' => $travelClaim->user_id])->first();
                            $notificationData['message'] = str_replace('  ', ' ', $employee->fullname) . " has raised a new claim request - '".$travelClaim->claim_code."'.";

                            $title = 'New Travel Claim Request Added.';
                            $body  = $notificationData['message'];
                            pushNotification($travelAuthority->manager_id, $title, $body);
                            sms($employee->mobile_number, $body, 'ACT');
                            /***************Push Notification Code**************************/
                            /***************Send Mail Code**************************/
                            /*if(!empty($message)) { commenting email code as discussed
                                $mail_data['to_email'] = $employee->user->email;
                                $mail_data['fullname'] = $employee->fullname;
                                $mail_data['subject']  = $title;
                                $mail_data['message']  = $body;
                                $this->sendGeneralMail($mail_data);
                            }*/
                            /***************Send Mail Code**************************/
                        }
                    }
                }

                \DB::commit();
                 return redirect(url('travel/claim-view/'.encrypt($travelClaim->id)))->with('success', 'Claim saved successfully.');
            } catch (\PDOException $e) {
                \DB::rollBack();

                if (isset($fileNameArr['file']) && !empty($fileNameArr['file']) && count($fileNameArr['file']) > 0) {
                    $this->removeFiles($fileNameArr['file']);
                }

                $message = 'Database Error: Travel Claim could not be saved.';
                return redirect()->back()->withError($message)->withInput($request->all());
            } catch (\Exception $e) {
                \DB::rollBack();

                if (isset($fileNameArr['file']) && !empty($fileNameArr['file']) && count($fileNameArr['file']) > 0) {
                    $this->removeFiles($fileNameArr['file']);
                }

                $message = 'Error code 500: internal server error.';
                return redirect()->back()->withError($message)->withInput($request->all());
            }
        }

        return view('travel.claim.claim-form', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
    */
    public function claimFormEdit(Request $request)
    {
        if(!$request->id) {
            $message = 'Database Error: Travel Claim could not be found.';
            return redirect()->back()->withError($message)->withInput($request->all());
        }

        $id     = decrypt($request->id);

        $claims = TravelClaim::where('id', $id)
                ->where('isactive', 1)
                ->with([
                    'claim_details', 'claim_stay', 'claim_attachments',
                    'claim_details.expense_types', 'claim_attachments.attachment_types'
                ])->first();

        if(!$claims) {
            return redirect()->back()->with('error', 'Claim not found.');
        }

        $travelId = $claims->travel_id;
        $data   = $this->getClaimDefaultValues($travelId);
        $user   = User::with('employee')->where(['id' => Auth::id()])->first();
        $data['user']   = $user;
        $data['claims'] = $claims;

        if($request->isMethod('post')) { //  && ($request->submit_btn || $request->update_btn)
            $inputs     = $request->all();

            $validator = (new TravelClaim)->validateTravelExpense($inputs, $id);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->messages())->withInput($inputs);
            }

            $fileNameArr  = [];

            try {
                \DB::beginTransaction();

                $travelClaim         = TravelClaim::find($id);
                $travelClaim->status = 'new';
                $travelClaim->update();

                if(isset($request->travel_expense) && count($request->travel_expense) > 0) {
                    $expense     = $inputs['travel_expense'];
                    $expenseDate = $inputs['travel_expense']['date'];

                    foreach ($expenseDate as $key => $date) {

                        if(!empty($date)) {

                            if (isset($expense['id'][$key])) {
                                $expenseId = $expense['id'][$key];
                                $claimDetails = TravelClaimDetail::find($expenseId);
                            } else {
                                $claimDetails = new TravelClaimDetail;
                            }

                            $claimDetails->expense_date = date('Y-m-d', strtotime($date));
                            $claimDetails->status = 'new';

                            $claimDetails->from_location = null;
                            if (isset($expense['from_location'][$key]) && !empty($expense['from_location'][$key])) {
                                $claimDetails->from_location = $expense['from_location'][$key];
                            }

                            $claimDetails->to_location = null;
                            if (isset($expense['to_location'][$key]) && !empty($expense['to_location'][$key])) {
                                $claimDetails->to_location = $expense['to_location'][$key];
                            }

                            $claimDetails->expense_type = null;
                            if (isset($expense['expense_type'][$key]) && !empty($expense['expense_type'][$key])) {
                                $claimDetails->expense_type = $expense['expense_type'][$key];
                            }

                            $claimDetails->description = null;
                            if (isset($expense['description'][$key]) && !empty($expense['description'][$key])) {
                                $claimDetails->description = $expense['description'][$key];
                            }

                            $claimDetails->distance_in_km = 0;
                            if (isset($expense['distance_in_km'][$key]) && !empty($expense['distance_in_km'][$key])) {
                                $claimDetails->distance_in_km = $expense['distance_in_km'][$key];
                            }

                            $claimDetails->amount = 0;
                            if (isset($expense['amount'][$key]) && !empty($expense['amount'][$key])) {
                                $claimDetails->amount = $expense['amount'][$key];
                            }

                            $travelClaimDetail = $travelClaim->claim_details()->save($claimDetails);
                        }
                    }
                }

                if(isset($request->stay) && count($request->stay) > 0) {
                    $stay = $inputs['stay'];
                    $dateFrom = $stay['date_from'];

                    foreach ($dateFrom as $dk => $date) {

                        if(!empty($date)) {

                            if (isset($stay['id'][$dk])) {
                                $stayId = $stay['id'][$dk];
                                $stayDetails = TravelClaimStay::find($stayId);
                            } else {
                                $stayDetails = new TravelClaimStay;
                            }

                            $stayDetails->from_date = date('Y-m-d', strtotime($date));
                            $stayDetails->status    = 'new';

                            $stayDetails->to_date = null;
                            if (isset($stay['date_to'][$dk]) && !empty($stay['date_to'][$dk])) {
                                $stayDetails->to_date = date('Y-m-d', strtotime($stay['date_to'][$dk]));
                            }

                            $stayDetails->state_id = null;
                            if (isset($stay['state_id'][$dk]) && !empty($stay['state_id'][$dk])) {
                                $stayDetails->state_id = $stay['state_id'][$dk];
                            }

                            $stayDetails->city_id = null;
                            if (isset($stay['city_id'][$dk]) && !empty($stay['city_id'][$dk])) {
                                $stayDetails->city_id = $stay['city_id'][$dk];
                            }

                            $stayDetails->rate_per_night = 0;
                            if (isset($stay['rate_per_night'][$dk]) && !empty($stay['rate_per_night'][$dk])) {
                                $stayDetails->rate_per_night = $stay['rate_per_night'][$dk];
                            }

                            $stayDetails->da = 0;
                            if (isset($stay['da'][$dk]) && !empty($stay['da'][$dk])) {
                                $stayDetails->da = $stay['da'][$dk];
                            }

                            $travelStayDetail = $travelClaim->claim_stay()->save($stayDetails);
                        }
                    }
                }

                if(isset($request->attachment) && count($request->attachment) > 0) {
                    $attachment = $inputs['attachment'];
                    $attachmentType = $attachment['attachment_type'];

                    foreach ($attachmentType as $k => $type) {

                        if(!empty($type)) {

                            if (isset($attachment['id'][$k])) {
                                $attachmentId = $attachment['id'][$k];
                                $typeDetails = TravelClaimAttachment::find($attachmentId);
                            } else {
                                $typeDetails = new TravelClaimAttachment;

                                $typeDetails->attachment = null;
                            }

                            $typeDetails->attachment_type = $type;
                            $typeDetails->status = 'new';

                            $typeDetails->name = null;
                            if (isset($attachment['name'][$k]) && !empty($attachment['name'][$k])) {
                                $typeDetails->name = $attachment['name'][$k];
                            }

                            if (isset($attachment['attachment'][$k]) && !empty($attachment['attachment'][$k])) {

                                $file = $attachment['attachment'][$k];

                                $fileOzName      = str_replace(' ', '', $file->getClientOriginalName());
                                $fileOzExtension = $file->getClientOriginalExtension();
                                $fileName        = time() . '_' . pathinfo(strtolower($fileOzName), PATHINFO_FILENAME) . '.' . $fileOzExtension;

                                $claimDocumentDir = \Config::get('constants.uploadPaths.claimDocument');

                                if (!is_dir($claimDocumentDir)) {
                                    mkdir($claimDocumentDir, 0775);
                                }

                                $file->move($claimDocumentDir, $fileName);

                                $fileNameArr['file'][] = $claimDocumentDir . $fileName;
                                $typeDetails->attachment = $fileName;
                            }
                            $attachmentsDetail = $travelClaim->claim_attachments()->save($typeDetails);
                        }
                    }
                }

                if(isset($request->comments) && !empty($request->comments)) {
                    $commentsInputs = new Comments;
                    $commentsInputs->user_id  = $user->id;
                    $commentsInputs->comments = $request->comments;
                    $comments = $travelClaim->comments()->save($commentsInputs);
                }


                $remarks = str_replace('  ', ' ', $travelClaim->user->employee->fullname) . ' has updated a travel claim request with claim code "'.$travelClaim->claim_code.'"';

                $travelLogsInputs = new TravelLogs;
                $travelLogsInputs->user_id = $travelClaim->user_id;
                $travelLogsInputs->remarks = $remarks;
                $travelLogs = $travelClaim->logs()->save($travelLogsInputs);

                $climber = TravelClimber::where(['travel_claim_id' => $travelClaim->id, 'status' => 'back'])->first();
                if(!empty($climber)) {
                    $climber->status = 'new';
                    $climber->update();

                    /***************Push Notification Code**************************/
                    $notificationData['message'] = str_replace('  ', ' ', $user->employee->fullname)." made changes in a claim request - '".$travelClaim->claim_code."'.";

                    $title = 'Changes in Travel Claim Request.';
                    $body  = $notificationData['message'];

                    $employee = Employee::where(['user_id' => $climber->climber_user_id])->first();

                    pushNotification($employee->user_id, $title, $body);
                    sms($employee->mobile_number, $body, 'ACT');
                    /***************Push Notification Code**************************/
                }

                \DB::commit();
                return redirect(url('travel/claim-view/'.encrypt($id)))->with('success', 'Claim updated successfully.');
            } catch (\PDOException $e) {
                \DB::rollBack();

                if (isset($fileNameArr['file']) && !empty($fileNameArr['file']) && count($fileNameArr['file']) > 0) {
                    $this->removeFiles($fileNameArr['file']);
                }

                $message = 'Database Error: Travel could not be saved.';
                return redirect()->back()->withError($message)->withInput($request->all());
            } catch (\Exception $e) {
                \DB::rollBack();

                if (isset($fileNameArr['file']) && !empty($fileNameArr['file']) && count($fileNameArr['file']) > 0) {
                    $this->removeFiles($fileNameArr['file']);
                }

                $message = 'Error code 500: internal server error.';
                return redirect()->back()->withError($message)->withInput($request->all());
            }
        }
        return view('travel.claim.claim-form-edit', $data);
    }

    /**
     * Remove upload files etc.
     *
     * @param  array fileArray []
     * unlink file from server
    */
    public function removeFiles($fileArr = [])
    {
        foreach ($fileArr as $key => $file) {
            if (file_exists($file)) {
                unlink($file);
            }
        }
    }

    /**
     * delete a previously created expense claim entry from db.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
    */
    public function deleteClaim(Request $request)
    {
        if ($request->isMethod('post')) {
            $inputs = $request->except('_token');

            try {
                \DB::beginTransaction();

                $res = false;

                $claimDocumentDir = \Config::get('constants.uploadPaths.claimDocument');

                if (isset($inputs['type']) && $inputs['type'] == 'expense') {
                    $filter = [
                        'id' => $inputs['data_id'],
                        'travel_claim_id' => $inputs['claimid'], // claimid
                    ];

                    $claimDetails = TravelClaimDetail::where($filter)->first();
                    $res = $claimDetails->delete();
                }

                if (isset($inputs['type']) && $inputs['type'] == 'stay') {
                    $filter = [
                        'id' => $inputs['data_id'],
                        'travel_claim_id' => $inputs['claimid'], // claimid
                    ];

                    $stayDetails = TravelClaimStay::where($filter)->first();
                    $res = $stayDetails->delete();
                }

                if (isset($inputs['type']) && $inputs['type'] == 'attachment') {
                    $filter = [
                        'id' => $inputs['data_id'],
                        'travel_claim_id' => $inputs['claimid'], // claimid
                    ];

                    $claimAttachment = TravelClaimAttachment::where($filter)->first();

                    if (!empty($claimAttachment->attachment) && file_exists($claimDocumentDir . $claimAttachment->attachment)) {
                        unlink($claimDocumentDir . $claimAttachment->attachment);
                    }

                    $res = $claimAttachment->delete();
                }

                \DB::commit();

                $message = 'Error in deleting record, please try again later.';
                $result = ['status' => 0, 'msg' => $message];
                if ($res) {
                    $message = 'Record deleted successfully.';
                    $result = ['status' => 1, 'msg' => $message];
                }
                return response()->json($result);
            } catch (\PDOException $e) {
                \DB::rollBack();
                $message = 'Database Error: Deleting record, please try again later.';
                $result = ['status' => 0, 'msg' => $message];
                return response()->json($result);
            } catch (\Exception $e) {
                \DB::rollBack();
                $result = ['status' => 0, 'msg' => $e->getMessage()];
                return response()->json($result);
            }
        }
    }

    public function claimRequests(Request $request)
    {
        $data['user'] = User::where(['id'=>Auth::id()])->first();
        $userId       = $data['user']->id;

        $data['filter_status'] = 'new'; $data['list_type'] = '';
        if($request->filter_status) {
            $data['filter_status'] = $request->filter_status;
        }
        if($request->list_type) {
            $data['list_type'] = $request->list_type;
        }

        $claims = TravelClaim::where('isactive', 1);

        if (!$data['user']->can('approve-travel-claim') && !$data['user']->can('verify-travel-claim') && !$data['user']->can('pay-travel-claim')) {
            $claims->where(['user_id' => $userId, 'status' => $data['filter_status']]);
        } else {

            if($data['list_type'] == 'created') {
                $claims->where(['user_id' => $userId, 'status' => $data['filter_status']]);
            } else {

                $claims->whereHas('climber', function (Builder $query) use($userId, $data) {
                    $query->where(['climber_user_id' => $userId, 'status' => $data['filter_status']]);
                });
            }
        }

        $claims = $claims->with([
            'claim_details', 'claim_stay', 'claim_attachments', 'climberUser',
            'claim_details.expense_types', 'claim_attachments.attachment_types',
            'user.employee'
        ]);

        $data['claims'] = $claims->orderBy('created_at', 'desc')->get();
        return view('travel.claim.claim-requests')->with(['data' => $data]);
    }

    function sendGeneralMail($mail_data)
    {   //mail_data Keys => to_email, subject, fullname, message
        if(!empty($mail_data['to_email'])){
            Mail::to($mail_data['to_email'])->send(new GeneralMail($mail_data));
        }
        return true;
    }//end of function

    public function changeRequests (Request $request)
    {
        if ($request->isMethod('post')) {
            $inputs = $request->except('_token');

            $id = $inputs['id'];

            try {
                \DB::beginTransaction();

                $travel  = Travel::find($id);

                if(!$travel->travelClimber->isEmpty()) {
                    $climber = $travel->travelClimber->each->delete();
                }

                $travel->update(['status' => 'new']);

                \DB::commit();

                $message = 'Error in change request, please try again later.';
                $result = ['status' => 0, 'msg' => $message];
                if ($travel) {
                    $message = 'Record generated successfully.';
                    $result = ['status' => 1, 'msg' => $message];
                }
                return response()->json($result);

            } catch (\PDOException $e) {
                \DB::rollBack();
                $message = 'Database Error: please try again later.';
                $result = ['status' => 0, 'msg' => $message];
                return response()->json($result);
            } catch (\Exception $e) {
                \DB::rollBack();
                $result = ['status' => 0, 'msg' => $e->getMessage()];
                return response()->json($result);
            }
        }
    }

    public function approvalRequestsChange (Request $request)
    {
        if(!$request->id) {
            exit;
        }

        $id        = decrypt($request->id);
        $travelObj = Travel::with([
            'project', 'tils', 'user.designation.band',
            'travelLocal', 'travelNational', 'travelStay',
            'imprest', 'otherApproval', 'user.employee',
            'travelClimberUser'
        ])->find($id);

        $data['countries'] = Country::where(['isactive'=>1])->get();
        $data['states']    = State::where(['isactive'=>1])->get();
        $data['user']      = User::with(['designation',
                                'designation.band.local_conveyances',
                                'designation.band.travel_conveyances'
                            ])->where(['id'=>Auth::id()])->first();

        $data['projects']    = Project::where('isactive', 1)->orderBy('name', 'asc')->get();
        $data['conveyances'] = Conveyance::where('isactive', 1)->where('islocal', 0)->orderBy('name', 'asc')->get();

        $data['conveyances_local'] = Conveyance::where('isactive', 1)->where('islocal', 1)->orderBy('name', 'asc')->get();
        $data['new_projects'] = Til::where(['isactive' => 1, 'status' => 8])->where('user_id', '<>', 0)->get();

        $data['cities'] = City::where('isactive', 1)->with('city_class')->get();
        $data['categories'] = TravelCategories::where('isactive', 1)->orderBy('name', 'ASC')->get();

        if($request->isMethod('post')) {

            try {
                \DB::beginTransaction();

                $travel         = Travel::find($id);

                $travel->travel_for               = null;
                if (isset($request->isclient) && !empty($request->isclient)) {
                    $travel->travel_for           = $request->isclient;
                }

                $travel->category_id              = $request->category_id;
                    $travel->project_id               = $request->existing_customer;
                    $travel->til_id                   = $request->future_customer;
                    $travel->others                   = $request->local_others;
                    $travel->travel_purpose           = $request->purpose_pre;
                    $travel->total_amount             = $request->total_travel_amount;
                    $travel->travel_type              = $request->travel_type;
                    $travel->cover_under_policy       = $request->cover_under_policy;
                    $travel->stay                     = $request->stay;
                    $travel->other_financial_approval = $request->other_financial_approval;
                    $travel->imprest_request          = $request->imprest_request;

                    $travel->status                   = 'new';
                    $travel->isactive                 = 1;
                $travel->update();

                if(!empty($travel) && $request->travel_type == 1) {

                    if (isset($request->travel_local_id)) {
                        $localId = $request->travel_local_id;
                        $travelLocalInputs = TravelLocal::find($localId);
                    } else {
                        $travelLocalInputs = new TravelLocal;
                    }

                    $travelLocalInputs->approval_duration = $request->approval_duration;
                    $travelLocalInputs->city_id           = $request->city_id_to_local;
                    $travelLocalInputs->conveyance_id     = $request->local_conveyance;
                    $travelLocalInputs->travel_amount     = $request->local_travel_amount;
                    $travelLocal = $travel->travelLocal()->save($travelLocalInputs);

                } else {

                    if(isset($request->travel_date) && count($request->travel_date) > 0) {
                        $travelDates = $request->travel_date;
                        foreach ($travelDates as $key => $date) {

                            if(!empty($date)) {
                                if (isset($request->travel_national['id'][$key])) {
                                    $nationalId = $request->travel_national['id'][$key];
                                    $travelInputs = TravelNational::find($nationalId);
                                } else {
                                    $travelInputs = new TravelNational;
                                }

                                $travelInputs->travel_date = date('Y-m-d', strtotime($date));

                                $travelInputs->from_city_id = null;
                                if (isset($request->city_id_from_pre[$key]) && !empty($request->city_id_from_pre[$key])) {
                                    $travelInputs->from_city_id = $request->city_id_from_pre[$key];
                                }

                                $travelInputs->to_city_id = null;
                                if (isset($request->city_id_to_pre[$key]) && !empty($request->city_id_to_pre[$key])) {
                                    $travelInputs->to_city_id = $request->city_id_to_pre[$key];
                                }

                                $travelInputs->conveyance_id = null;
                                if (isset($request->conveyance_id[$key]) && !empty($request->conveyance_id[$key])) {
                                    $travelInputs->conveyance_id = $request->conveyance_id[$key];
                                }

                                $travelInputs->distance_in_km = 0;
                                if (isset($request->distance_in_km[$key]) && !empty($request->distance_in_km[$key])) {
                                    $travelInputs->distance_in_km = $request->distance_in_km[$key];
                                }

                                $travelInputs->travel_amount = 0;
                                if (isset($request->amount[$key]) && !empty($request->amount[$key])) {
                                    $travelInputs->travel_amount = $request->amount[$key];
                                }

                                $travelNational = $travel->travelNational()->save($travelInputs);
                            }
                        }
                    }

                    if(!empty($request->stay)) {
                        $stayDateRange = $request->stay_date_range;
                        if(!empty($stayDateRange) && count($stayDateRange) > 0) {
                            foreach ($stayDateRange as $dRKy => $dateRange) {

                                if(!empty($dateRange)) {

                                    $stayDateRangeArr = explode("-", $dateRange);
                                    $stayDateFrom = date("Y-m-d", strtotime(trim($stayDateRangeArr[0])));
                                    $stayDateTo   = date("Y-m-d", strtotime(trim($stayDateRangeArr[1])));

                                    if (isset($request->travel_stay['id'][$dRKy])) {
                                        $stayId = $request->travel_stay['id'][$dRKy];
                                        $stayInputs = TravelStay::find($stayId);
                                    } else {
                                        $stayInputs = new TravelStay;
                                    }

                                    $stayInputs->from_date      = $stayDateFrom;
                                    $stayInputs->to_date        = $stayDateTo;

                                    $stayInputs->city_id = null;
                                    if (isset($request->city_id_stay[$dRKy]) && !empty($request->city_id_stay[$dRKy])) {
                                        $stayInputs->city_id = $request->city_id_stay[$dRKy];
                                    }

                                    $stayInputs->rate_per_night = 0;
                                    if (isset($request->rate_per_night[$dRKy]) && !empty($request->rate_per_night[$dRKy])) {
                                        $stayInputs->rate_per_night = $request->rate_per_night[$dRKy];
                                    }

                                    $stayInputs->da = 0;
                                    if (isset($request->da[$dRKy]) && !empty($request->da[$dRKy])) {
                                        $stayInputs->da = $request->da[$dRKy];
                                    }

                                    $travelStay = $travel->travelStay()->save($stayInputs);
                                }
                            }
                        }
                    }

                    if($request->other_financial_approval) {
                        // $obj->travel_approval_id=$tavel_approval_id;
                        if (isset($request->other_approval_id)) {
                            $otherApprovalId = $request->other_approval_id;
                            $otherApprovalInputs = TravelOtherApproval::find($otherApprovalId);
                        } else {
                            $otherApprovalInputs = new TravelOtherApproval;
                        }

                        $otherApprovalInputs->country_id = $request->country_id_other;
                        $otherApprovalInputs->state_id   = $request->state_id_other;
                        $otherApprovalInputs->city_id    = $request->city_id_other;
                        $otherApprovalInputs->purpose    = $request->purpose_other;
                        $otherApprovalInputs->amount     = $request->amount_other;

                        $travelOtherApproval = $travel->otherApproval()->save($otherApprovalInputs);

                        if(DB::table('travel_other_approvalables')->where(['travel_other_approval_id' => $travelOtherApproval->id])->first()) {

                            DB::table('travel_other_approvalables')->where(['travel_other_approval_id' => $travelOtherApproval->id])->update([
                                'travel_other_approvalable_type' => 'App\Project',
                                'travel_other_approvalable_id' => $request->project_id_other,
                                'created_at' => date('Y-m-d H:i:s')
                            ]);
                        } else {
                            DB::table('travel_other_approvalables')->insert([
                                'travel_other_approvalable_type' => 'App\Project',
                                'travel_other_approvalable_id' => $request->project_id_other,
                                'travel_other_approval_id' => $travelOtherApproval->id,
                                'created_at' => date('Y-m-d H:i:s')
                            ]);
                        }
                    } else {
                        if(isset($travel->otherApproval->id) && !empty($travel->otherApproval->id)) {
                            DB::table('travel_other_approvalables')->where([
                                'travel_other_approvalable_type' => 'App\Project',
                                'travel_other_approval_id' => $travel->otherApproval->id
                            ])->delete();

                            $travel->otherApproval->delete();
                        }
                    }

                    if($request->imprest_request) {

                        if (isset($request->imperest_id)) {
                            $imperestId = $request->imperest_id;
                            $imprestInputs = TravelImprest::find($imperestId);
                        } else {
                            $imprestInputs = new TravelImprest;
                        }

                        $imprestInputs->remarks_by_applicant = $request->remarks;
                        $imprestInputs->amount               = $request->amount_imprest;
                        $travelImprest = $travel->imprest()->save($imprestInputs);

                        if(DB::table('travel_imprestables')->where(['travel_imprest_id' => $travelImprest->id])->first()) {

                            DB::table('travel_imprestables')->where(['travel_imprest_id' => $travelImprest->id])->update([
                                'travel_imprestable_type' => 'App\Project',
                                'travel_imprestable_id' => $request->project_id_imprest,
                            ]);
                        } else {
                            DB::table('travel_imprestables')->insert([
                                'travel_imprestable_type' => 'App\Project',
                                'travel_imprestable_id' => $request->project_id_imprest,
                                'travel_imprest_id' => $travelImprest->id,
                                'created_at' => date('Y-m-d H:i:s')
                            ]);
                        }
                    } else {
                        if(isset($travel->imprest->id) && !empty($travel->imprest->id)) {
                            DB::table('travel_imprestables')->where([
                                'travel_imprestable_type' => 'App\Project',
                                'travel_imprest_id' => $travel->imprest->id
                            ])->delete();

                            $travel->imprest->delete();
                        }
                    }
                }

                if(!empty($travel)) {

                    $remarks = 'User has updated a travel pre approval with Travel Code "'.$travel->travel_code.'"';

                    $travelLogsInputs = new TravelLogs;
                    $travelLogsInputs->user_id = $travel->user_id;
                    $travelLogsInputs->remarks = $remarks;
                    $travelLogs = $travel->logs()->save($travelLogsInputs);

                    $authorityFilter = ['priority' => 1, 'authority_type' => 'pre_approval',
                        'isactive' => 1, 'user_id' => $travel->user_id
                    ];

                    $travelAuthority = TravelAuthority::where($authorityFilter)->first();

                    if($travelAuthority) {
                        $travelClimber = TravelClimber::where(['travel_id' => $travel->id, 'climber_user_id' => $travelAuthority->manager_id, 'status' => 'new'])
                        ->whereNull('deleted_at')->first();

                        if (!$travelClimber) {
                            $climberInputs = new TravelClimber;
                            $climberInputs->climber_user_id  = $travelAuthority->manager_id;
                            $climberInputs->status           = 'new';
                            $climberInputs->remarks          = null;
                            $travelClimber = $travel->travelClimber()->save($climberInputs);

                            /***************Push Notification Code**************************/
                            $employee = Employee::where(['user_id' => $travel->user_id])->first();
                            $notificationData['message'] = $employee->fullname." has raised a new travel request - '".$travel->travel_code."'.";

                            $title = 'New Travel Request Added';
                            $body  = $notificationData['message'];
                            pushNotification($travelAuthority->manager_id, $title, $body);
                            sms($employee->mobile_number, $body, 'ACT');
                            /***************Push Notification Code**************************/
                            /***************Send Mail Code**************************/
                            /*if(!empty($message)){
                                $mail_data['to_email'] = $employee->user->email;
                                $mail_data['fullname'] = $employee->fullname;
                                $mail_data['subject'] = $title;
                                $mail_data['message'] = $body;
                                $this->sendGeneralMail($mail_data);
                            }*/
                            /***************Send Mail Code**************************/
                        }
                    }
                }

                \DB::commit();

                return redirect(url('travel/approval-requests'))->with('success', 'Travel Approval saved successfully.');

            } catch (\PDOException $e) {
                \DB::rollBack();

                return redirect()->back()->withError('Database Error: Travel could not be saved.')->withInput($request->all());
            } catch (\Exception $e) {
                \DB::rollBack();

                // dd($e->getMessage());
                $message = 'Error code 500: internal server error.';
                return redirect()->back()->withError($message)->withInput($request->all());
            }
        }

        return view('travel.edit_approval_form')->with(['data' => $data, 'travel' => $travelObj]);
    }

    public function deleteApprovalDetails (Request $request)
    {
        if ($request->isMethod('post')) {
            $inputs = $request->except('_token');

            try {

                \DB::beginTransaction();

                $res = false;

                $travel = Travel::find($inputs['travel_id']);


                $claimDocumentDir = \Config::get('constants.uploadPaths.claimDocument');

                if (isset($inputs['type']) && $inputs['type'] == 'national') {
                    $filter = [
                        'id' => $inputs['data_id'],
                        'travel_id' => $inputs['travel_id'],
                    ];

                    $natioanlDetails = TravelNational::where($filter)->first();
                    $res = $natioanlDetails->delete();
                }

                if (isset($inputs['type']) && $inputs['type'] == 'stay') {
                    $filter = [
                        'id' => $inputs['data_id'],
                        'travel_id' => $inputs['travel_id'],
                    ];

                    $stayDetails = TravelStay::where($filter)->first();
                    $res = $stayDetails->delete();
                }

                $travel = Travel::find($inputs['travel_id']);

                $totalAmount = 0;
                if(!$travel->travelNational->isEmpty()) {
                    foreach ($travel->travelNational as $key => $value) {
                        $totalAmount += $value->travel_amount;
                    }
                }
                if(!$travel->travelStay->isEmpty()) {
                    foreach ($travel->travelStay as $k => $val) {
                        $totalAmount += $val->rate_per_night;
                        $totalAmount += $val->da;
                    }
                }

                $travel->update(['total_amount' => $totalAmount]);

                \DB::commit();

                $message = 'Error in deleting record, please try again later.';
                $result = ['status' => 0, 'msg' => $message];
                if ($res) {
                    $message = 'Record deleted successfully.';
                    $result = ['status' => 1, 'msg' => $message];
                }
                return response()->json($result);
            } catch (\PDOException $e) {
                \DB::rollBack();
                $message = 'Database Error: Deleting record, please try again later.';
                $result = ['status' => 0, 'msg' => $message];
                return response()->json($result);
            } catch (\Exception $e) {
                \DB::rollBack();
                $result = ['status' => 0, 'msg' => $e->getMessage()];
                return response()->json($result);
            }
        }
    }

    public function printClaim (Request $request)
    {
        if(!$request->id) {
            $message = 'Request Id not found.';
            return redirect()->back()->withError($message);
        }
        
        $id           = decrypt($request->id);
        $data['user'] = User::where(['id'=>Auth::id()])->first();
        $userId       = $data['user']->id;
        
        $claims = TravelClaim::where('id', $id)->where('isactive', 1);
        $claimForm = $claims->first();

        if ($claimForm->user_id == $userId || (!$data['user']->can('approve-travel-claim') && !$data['user']->can('verify-travel-claim') && !$data['user']->can('pay-travel-claim'))) {
            $claims->where('user_id', $userId);
        } else {
            $claims->whereHas('climber', function (Builder $query) use($userId) {
                $query->where(['climber_user_id' => $userId]);
            });
        }

        $claims = $claims->with([
                    'claim_details', 'claim_stay', 'claim_attachments', 'climberUser',
                    'claim_details.expense_types', 'claim_attachments.attachment_types'
                ])->first();

        if(!$claims) {
            return redirect()->back()->with('error', 'Claim not found.');
        }
        
        $travelId = $claims->travel_id;
        $data     = $this->getClaimDefaultValues($travelId);
        $data['claims'] = $claims;

        $data['climberCount'] = 0;
        if(!empty($claims->climberUser)) {
            $climberUser          = $claims->climberUser;
            $data['climberCount'] = $climberUser->where(['travel_claim_id' => $climberUser->travel_claim_id, 'climber_user_id' => $climberUser->climber_user_id])->count();
        }

        //return $data;
        return view('travel.claim.print-claim', $data);
    }

    public function getComments(Request $request)
    {
        if($request->isMethod('GET')) {
            $commentsDir = null;

            $inputs = $request->except('_token');

            $travelClaim   = TravelClaim::find($inputs['id']);
            if(!$travelClaim) {
                $message = 'Travel Claim data not found.';
                $result = ['status' => 0, 'msg' => $message, 'data' => null, 'dir_path' => null];
                return response()->json($result);
            }
            $comments = $travelClaim->comments()->with('userEmployee')->get()->all();

            if(empty($comments)) {
                $message = 'No prevoius comments were found.';
                $result  = ['status' => 0, 'msg' => $message, 'data' => null, 'dir_path' => null];
            } else {
                $message = null;
                $result  = ['status' => 1, 'msg' => $message, 'data' => $comments, 'dir_path' => $commentsDir];
            }
            return response()->json($result);
        }
    }//end of function
}