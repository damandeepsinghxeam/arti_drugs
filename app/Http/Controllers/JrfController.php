<?php

namespace App\Http\Controllers;
use App\Project;
use App\AdRequisitionForm;
use App\ArfApproval;
use App\City;
use App\Department;
use App\Designation;
use App\Employee;
use App\EmployeeProfile;
use App\Http\Controllers\Controller;
use App\Jrf;
use App\JrfApprovals;
use App\MgmtDtApprovals;
use App\JrfCity;
use App\JrfHierarchy;
use App\JrfInterviewerDetail;
use App\JrfLevelOneScreening;
use App\JrfLevelTwoScreening;
use App\FinalAppointmentApproval;
use App\JrfLevelOneScreeningLanguage;
use App\JrfLevelOneScreeningQualification;
use App\JrfLevelOneScreeningSkill;
use App\JrfQualification;
use App\JrfRecruitmentTasks;
use App\JrfSkill;
use App\Language;
use App\LeaveAuthority;
use App\Mail\GeneralMail;
use App\Mail\JrfGeneralMail;
use App\Qualification;
use App\Skill;
use App\Closour;
use App\BenifitPerks;
use App\JobPosts;
use App\CandidateApprovals;
use App\ManagementApprovals;
use App\UserManager;
use App\User;
use Auth;
use DateTime;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;
use Validator;
use View;
use App\Helper;

class JrfController extends Controller
{

    public function create()
    {

        if (Auth::guest()) {
            return redirect('/');
        }

        $user = User::where(['id' => Auth::id()])->first();  
        $data['user_dept']      = EmployeeProfile:: where(['user_id' => $user->id])->first();

        $data['dept_usr'] = DB::table('employees as emp')
                ->join('users as u','emp.user_id','=','u.id')
                ->join('employee_profiles as empp','empp.user_id','=','u.id')
                ->where(['empp.department_id'=>$user->employeeProfile->department_id,'emp.isactive'=>1])
                ->select('u.*','emp.*')
                ->get();

        $data['departments']    = Department::where(['isactive' => 1])->orderBy('name')->get();

        $data['roles']          = Role::select('id', 'name')->orderBy('name')->get();
        $data['cities']         = City::where(['isactive' => 1])->orderBy('name')->get();
        $data['skills']         = Skill::where(['isactive' => 1])->orderBy('name')->select('id', 'name')->get();
        $data['qualifications'] = Qualification::where(['isactive' => 1])->select('id', 'name')->orderBy('name')->get();

        $data['designation']    = Designation::where(['isactive' => 1])->orderBy('name')->select('id', 'name')->get();
        $data['project']        = Project::where(['isactive' => 1])->orderBy('name')->select('id', 'name')->get();
        $data['benifit_perk']   = BenifitPerks::where(['isactive' => 1])->orderBy('name')->select('id', 'name')->get();  

        return view('jrf.create_jrf')->with(['data' => $data]);
    }

    public function saveJrf(Request $request)
    {   

        $count = Jrf::count();
        $count++;
        $date = date('Ymd');
        $string = substr($date,2);
        $stringA = substr($string, 0, -2);
        $number = str_pad($count, 4, '0', STR_PAD_LEFT);
        $fnl_cnt = $stringA.$number;

        if (Auth::guest()) {
            return redirect('/');
        }

        $validator = Validator::make($request->all(), [
            'department_id'             => 'required',
            'role_id'                   => 'required',
            'number_of_positions'       => 'required',
            'gender'                    => 'required',
            'city_id'                   => 'bail|required',
            'job_description'           => 'required',
            'qualification_id'          => 'bail|required',
            'industry_type'             => 'required',
            'skill_id'                  => 'bail|required',
            'job_posting_other_website' => 'bail|required',
            'type'                      => 'bail|required',
            'designation_id'            => 'bail|required',
            'project_id'                => 'bail|required',
            'closure_timeline'          => 'required',

        ]);

        if ($validator->fails()) {
            return redirect("jrf/create")
                ->withErrors($validator, 'basic')
                ->withInput();
        }

        $user = User::where(['id' => Auth::id()])
            ->with('employee')
            ->first();

        $job_role = DB::table('roles')
                ->where(['id' => $request->role_id])
                ->select('name')
                ->first();


        $department = DB::table('departments')
                ->where(['id' => $request->department_id])
                ->select('name')
                ->first();


        if (empty($user)) {
            $manager_error = "You do not have a reporting manager.";
            return redirect('jrf/create')->with('jrfError', $manager_error);
        }

        $data = [
            'department_id'             => $request->department_id,
            'user_id'                   => $request->user_id,
            'role_id'                   => $request->role_id,
            'designation_id'            => $request->designation_id,
            'number_of_positions'       => $request->number_of_positions,
            'gender'                    => $request->gender,
            'description'               => $request->job_description,
            'industry_type'             => $request->industry_type,
            'shift_timing_from'         => $request->shift_timing_from,
            'shift_timing_to'           => $request->shift_timing_to,
            'type'                      => $request->type,
            'job_posting_other_website' => $request->job_posting_other_website,
            'final_status'              => '0',
            'jrf_no'                    => $fnl_cnt,
            'project_id'                => $request->project_id,
            'interviewr_id'             => $request->approver_id,
            'jrf_closure_timeline'      => $request->closure_timeline
        
        ];


       /* $uploadJrfDocument = \Config::get('constants.uploadPaths.uploadJrfDocument');

        if ($request->hasFile('uploade_type')) {
            $imageA = time() . '.' . $request->file('uploade_type')->getClientOriginalExtension();

            $request->file('uploade_type')->move($uploadJrfDocument, $imageA);
            $data['document'] = $imageA;
        } */


        if ($request->hasFile('uploade_type')) {
            $imageA = time() . '.' . $request->file('uploade_type')->getClientOriginalExtension();
            $request->file('uploade_type')->move(config('constants.uploadPaths.uploadJrfDocument'), $imageA);
            $data['document'] = $imageA;

        }

        if (!empty($request->age_group_from)) {
            $data['age_group'] = $request->age_group_from . "-" . $request->age_group_to;
        }

        if (!empty($request->additional_requirement)) {
            $data['additional_requirement'] = $request->additional_requirement;
        } else {
            $data['additional_requirement'] = "";
        }

        if (!empty($request->salary_range_from)) {
            $data['salary_range'] = $request->salary_range_from . "-" . $request->salary_range_to;
        }

        // New JRF Changes //
        
        if (!empty($request->certification)) {
            $data['certification'] = $request->certification;
        } else {
            $data['certification'] = "";
        }

     /*   if (!empty($request->benefits_perks)) {
            $data['benefits_perks'] = $request->benefits_perks;
        } else {
            $data['benefits_perks'] = "";
        }  */

        if (!empty($request->temp_or_perm)) {
            $data['temp_or_perm'] = $request->temp_or_perm;
        } else {
            $data['temp_or_perm'] = "";
        }

        if (!empty($request->service_charges_fee)) {
            $data['service_charges_fee'] = $request->service_charges_fee;
        } else {
            $data['service_charges_fee'] = "";
        }
        // end jrf changes //

        if (!empty($request->year_experience_from) || $request->year_experience_from == 0 || $request->year_experience_to == 0) {
            $data['experience'] = $request->year_experience_from . "-" . $request->year_experience_to;
        }

        $user      = User::where(['id' => Auth::id()])->with('employee')->first();

        $saved_jrf = $user->jrf()->create($data);     


       /* if (!empty($request->benefits_perks)) {
         dd(  $saved_jrf->jrfBnifitPerks()->sync($request->benefits_perks) );
        }  */


        // Add Multiple benifits & perks.

        $perksId = $request->benefits_perks;
        
        if (!empty($perksId)) {
                
            $ben_perk = [
                
                'benifits_perks_id'      => $request->benefits_perks,
                'jrf_id'                 => $saved_jrf->id              
            ];

            foreach ($perksId as $key => $value) {
                $ben_perk['benifits_perks_id'] = $value;
                DB::table('jrf_benifts_perks')->insert($ben_perk);
            }
        }

        if (!empty($request->skill_id)) {
            $saved_jrf->jrfskills()->sync($request->skill_id);
        }

        if (!empty($request->qualification_id)) {
            $saved_jrf->jrfqualifications()->sync($request->qualification_id);
        }

        if (!empty($request->city_id)) {
            $saved_jrf->jrfcity()->sync($request->city_id);
        }

        $jrf_approval = [
            'user_id'       => $request->user_id,
            'jrf_id'        => $saved_jrf->id,
            'supervisor_id' => 13,
            'priority'      => '2', // Assigned to HOD
            'jrf_status'    => '0', //inprogress
        ];

        //dd($jrf_approval);
        
        $saved_jrf = $user->jrfapprovals()->create($jrf_approval);

        //////////////////////////Notify///////////////////////////

        $notification_data = [
            'sender_id'   => $request->user_id,
            'receiver_id' => 13, //HOD  id
            'label'       => 'JRF Approval',
            'read_status' => '0',
        ];

        $notification_data['message'] = $user->employee->fullname . " sent request for JRF approval";
        $saved_jrf->notifications()->create($notification_data);


        $get_mobile_user_data = User::where(['id' => 13])
        ->with('employee')
        ->first();

        $notificationMessage = $user->employee->fullname." Sent Request For JRF Approval For The Position of ".$job_role->name." From ".$department->name. " Department";

        //////////////////////////Mail///////////////////////////

        $reporting_manager = Employee::where(['user_id' => 13])
            ->with('user')->first();
        $mail_data['to_email'] = $reporting_manager->user->email;
        $mail_data['subject']  = "JRF Approval Request";
        $mail_data['message']  = $user->employee->fullname . " sent request for JRF approval. Please take an action. Here is the link for website <a href='" . url('/') . "'>Click here</a>";
        $mail_data['fullname'] = '';
        //$this->sendJrfGeneralMail($mail_data); //working

        sms($get_mobile_user_data->employee->mobile_number,$notificationMessage);

        if ($data['job_posting_other_website'] == "Yes") {
            $this->adRequisitionForm($saved_jrf->jrf_id);
           return redirect('jrf/ad-requisition-form/' . $saved_jrf->jrf_id);
        } else {
            return redirect()->back()->with('success', "JRF created successfully.");
        }

        return redirect()->back()->with('success', "JRF created successfully.");
    }

    public function adRequisitionForm($jrf_id)
    {

        $data = DB::table('jrfs as jrf')
            ->join('designations as des', 'jrf.designation_id', 'des.id')
            ->join('projects as prj','jrf.project_id','=','prj.id')
            ->join('departments as depart', 'jrf.department_id', 'depart.id')
            ->leftjoin('jrf_ad_requisition_forms as arf', 'jrf.id', 'arf.jrf_id')
            ->join('roles as r', 'jrf.role_id', 'r.id')
            ->where('jrf.id', $jrf_id)
            ->select('jrf.*', 'des.name as designation', 'r.name as role', 'depart.name as department', 'arf.*', 'arf.id as arf_id','prj.name as prj_name')
            ->first();

         
        $jobs = JobPosts::where(['isactive' => 1])->select('id', 'name')->get();

        $job_post  = DB::table('arf_job_posts')->where('jrf_id', $jrf_id)->pluck('job_posts_id')->toArray();    

        $jobsA['saved_jobpost'] = $job_post;

        return view('jrf.ad_requisition_form')->with(['data' => $data, 'jrf_id' => $jrf_id, 'jobs' => $jobs, 'jobsA' => $jobsA]);
    }

    public function saveAdRequisitionForm(Request $request)
    {

        // $auth_id = Auth::id();
        
        $data = [

            'jrf_id'       => $request->jrf_id,
            'request_date' => $request->date_of_request,
            'post_amount'  => $request->post_amount,
            'post_count'   => $request->post_count,
            'isactive'     => "1",
            'post_content' => $request->post_content,
        ];

        $jobId = $request->job_posts;
        
        if (!empty($jobId)) {
                
            $ben_perk = [
                
                'job_posts_id'      => $request->job_posts,
                'jrf_id'            => $request->jrf_id

            ];

            foreach ($jobId as $key => $value) {
                $ben_perk['job_posts_id'] = $value;
                DB::table('arf_job_posts')->insert($ben_perk);
            }
        }
   

        if (!empty($request->arf_id)) {
            $result = AdRequisitionForm::find($request->arf_id);
            if (!empty($result)) {
                $result->update($data);
            }
        }else {
            AdRequisitionForm::create($data);
            return redirect('jrf/list-jrf');
        }
        return redirect()->back()->with('success', "Detail saved successfully.");
    }

    public function listJrf(Request $request)
    {

        if (Auth::guest()) {
            return redirect('/');
        }
        
        $condition = array();
        $user = User::where(['id' => Auth::id()])->first();

        $condition[] = array('jrf.user_id', '=', $user->id);

        if(!empty($request->project_id)){
            $condition[] = array('jrf.project_id', '=', $request->project_id);
        }

        if(!empty($request->designation_id)){
            $condition[] = array('jrf.designation_id', '=', $request->designation_id);
        }

        $jrfs = DB::table('jrfs as jrf')
            ->join('designations as des', 'jrf.designation_id', 'des.id')
            ->join('departments as dep','jrf.department_id','=','dep.id')
            ->join('roles as r', 'jrf.role_id', 'r.id')
            ->join('projects as prj','jrf.project_id','prj.id')
            ->where($condition)            
            ->select('jrf.*', 'des.name as designation', 'r.name as role','prj.name','dep.name as department')
            ->orderBy('jrf.id', 'DESC')
            ->get();


        $detail['recruitment_detail'] = DB::table('jrf_recruitment_tasks as jrt')
                                        ->join('jrfs as jrf','jrt.jrf_id','=','jrf.id')
                                        ->where('jrt.user_id',$user->id)    
                                        ->select('jrt.last_date','jrt.jrf_id')    
                                        ->get();

        $projects = Project::where(['isactive'=>1])->get();
        $designations = Designation::where(['isactive'=>1])->select('id','name')->get();

        if (!$jrfs->isEmpty()) {
            foreach ($jrfs as $key => $value) {


                $jrf_approval_status = DB::table('jrf_approvals as ja')
                    ->leftjoin('jrf_recruitment_tasks as jrt','ja.jrf_id','=','jrt.jrf_id')    
                    ->where(['ja.jrf_id' => $value->id])->get();
                
                $can_cancel_jrf = 0;
                if (count($jrf_approval_status) == 1 && $jrf_approval_status[0]->jrf_status == 0) {
                    $can_cancel_jrf = 1;
                }
                $value->jrf_approval_status = $jrf_approval_status;
                $value->can_cancel_jrf   = $can_cancel_jrf;
                if ($value->final_status == '0') {
                    $check_rejected = DB::table('jrf_approvals as ja')
                        ->where(['ja.jrf_id' => $value->id, 'ja.jrf_status' => '2'])
                        ->first();
                    if (!empty($check_rejected)) {
                        $value->secondary_final_status = 'Rejected';
                    } else {
                        $value->secondary_final_status = 'In-Progress';
                    }
                } else {
                        $value->secondary_final_status = 'Closed';
                }

            }
        }
        return view('jrf.list_jrf')->with(['jrfs' => $jrfs,'designations'=>$designations,'projects'=>$projects,'req'=>$request]);

    }

    public function viewJrfs($id)
    {

        if (Auth::guest()) {
            return redirect('/');
        }
        $user    = User::where(['id' => Auth::id()])->first();
        $detail['basic'] = DB::table('jrfs')
            ->join('employees as emp', 'jrfs.user_id', '=', 'emp.user_id')
            ->leftjoin('jrf_approvals as ja', 'jrfs.id', 'ja.jrf_id')
            ->leftjoin('employees as emp2', 'jrfs.close_jrf_user_id', '=', 'emp2.user_id')
            ->leftjoin('employees as emp3', 'ja.supervisor_id', '=', 'emp3.user_id')
            ->join('users as u', 'emp.user_id', '=', 'u.id')
            ->join('roles as r', 'jrfs.role_id', 'r.id')
            ->join('designations as des', 'jrfs.designation_id', 'des.id')
            ->join('departments as dept', 'jrfs.department_id', '=', 'dept.id')
            ->join('projects as prj', 'jrfs.project_id', '=', 'prj.id')
            ->where('jrfs.id', $id)
            ->select('jrfs.*', 'emp.user_id', 'emp.fullname', 'emp.mobile_number', 'dept.name', 'u.email', 'emp2.fullname as 	close_jrf_user_name', 'jrfs.close_jrf_date', 'des.name as designation', 'r.name as role', 'ja.*', 'emp3.fullname as approver_name','prj.name as project_name')
            ->first();


        $skills = DB::table("jrf_skill as js")
            ->join('skills as s', 'js.skill_id', '=', 's.id')
            ->where('js.jrf_id', $id)
            ->pluck('s.name')->toArray();
        $detail['skills'] = implode(' , ', $skills);

        $qualification = DB::table("jrf_qualification as jq")
            ->join('qualifications as q', 'jq.qualification_id', '=', 'q.id')
            ->where('jq.jrf_id', $id)
            ->pluck('q.name')->toArray();
        $detail['qualification'] = implode(' , ', $qualification);

        $location = DB::table("city_jrf as cj")
            ->join('cities as c', 'cj.city_id', '=', 'c.id')
            ->where('cj.jrf_id', $id)
            ->pluck('c.name')->toArray();
        $detail['location'] = implode(' , ', $location);

        $job_location = DB::table("arf_job_posts as aj")
            ->join('job_post as jp', 'aj.job_posts_id', '=', 'jp.id')
            ->where('aj.jrf_id', $id)
            ->pluck('jp.name')->toArray();
            
        $detail['job_name'] = $job_location;

        $benifit_perks = DB::table("jrf_benifts_perks as jbp")
            ->join('benifits_perks as bp', 'jbp.benifits_perks_id', '=', 'bp.id')
            ->where('jbp.jrf_id', $id)
            ->pluck('bp.name')->toArray();
            
        $detail['benifit_perk'] = $benifit_perks;

        $detail['interview_detail'] = DB::table('jrf_interviewer_details as jnd')
            ->join('jrf_level_one_screenings as jlos', 'jnd.jrf_id', 'jlos.jrf_id')
            ->leftjoin('jrf_level_two_screenings as jlts','jlos.id','jlts.jrf_level_one_screening_id')
            ->join('employees as emp', 'jnd.assigned_by', 'emp.user_id')
            ->where('jnd.jrf_id', $id)
            ->select('jlos.jrf_id', 'jlos.id as jrf_level_one_screening_id', 'jlos.name', 'jlos.interview_date', 'jlos.interview_time', 'jlos.current_designation', 'jlos.reason_for_job_change', 'emp.fullname','jlos.joining_date','jlts.final_result','jlos.candidate_status')
            ->groupBy('jlos.id')
            ->get();    
          // dd($detail['interview_detail']); 

        $detail['recruitment_detail'] = DB::table('jrf_recruitment_tasks as jrt')
            ->join('jrfs', 'jrt.jrf_id', '=', 'jrfs.id')
            ->join('departments as dept', 'jrt.department_id', '=', 'dept.id')
            ->join('employees as emp', 'jrt.user_id', '=', 'emp.user_id')
            ->leftjoin('employees as emp2', 'jrt.assigned_by', '=', 'emp2.user_id')
            ->where('jrt.jrf_id', $id)
            ->select('jrt.*', 'jrfs.id', 'dept.name', 'emp.fullname', 'emp2.fullname as assigned_by')
            ->get();
         //   dd($detail['recruitment_detail']);

        $detail['arf'] = DB::table('jrf_ad_requisition_forms as arf')
            ->join('jrfs as jrf', 'arf.jrf_id', 'jrf.id')
            ->join('employees as emp', 'arf.user_id', '=', 'emp.user_id')
            ->where('arf.jrf_id', $id)
            ->where('arf.isactive', '1')
            ->select('jrf.id', 'arf.*', 'emp.fullname')
            ->first();

        $detail['arf_approvals'] = DB::table('arf_approvals as aas')
            ->join('jrfs as jrf', 'aas.jrf_id', 'jrf.id')
            ->join('employees as emp', 'aas.supervisor_id', '=', 'emp.user_id')
            ->where('aas.jrf_id', $id)
            ->select('aas.*', 'emp.fullname')
            ->first();

         // Jrf Approvals   
            
        $detail['jrf_approvalsA'] = DB::table('jrf_approvals as jas')
            ->join('jrfs as jrf', 'jas.jrf_id', 'jrf.id')
            ->join('employees as emp', 'jas.supervisor_id', '=', 'emp.user_id')
            ->where('jas.jrf_id', $id)
            ->select('jas.*', 'emp.fullname')
            ->get();

        // Before Appointment Candidate Approvals
            
        $detail['cand_lvl_approvals'] = DB::table('jrf_interviewer_details as jnd')
            ->join('jrf_level_one_screenings as jlos', 'jnd.jrf_id', 'jlos.jrf_id')
            ->leftjoin('jrf_level_two_screenings as jlts','jlos.id','jlts.jrf_level_one_screening_id')
             ->join('jrf_management_approvals as jma','jnd.jrf_level_one_screening_id','=','jma.jrf_level_one_screening_id')
            ->join('employees as emp', 'jnd.assigned_by', 'emp.user_id')
            ->where('jnd.jrf_id', $id)
            ->select('jlos.jrf_id', 'jlos.id as jrf_level_one_screening_id', 'jlos.name', 'jlos.interview_date', 'jlos.interview_time', 'jlos.current_designation', 'jlos.reason_for_job_change', 'emp.fullname','jlos.joining_date','jlos.candidate_status','jlos.total_experience','jlos.current_ctc','jlos.current_cih','jlts.final_result','jlts.level','jma.jrf_status')
            ->groupBy('jlos.id')
            ->get();

       // dd($detail['cand_lvl_approvals']);    

        // After Appointment Candidate Approvals    
            
        $detail['jrf_cand_approvals'] = DB::table('jrf_appointed_approvals as jas')
            ->join('jrf_level_one_screenings as jlos','jas.jrf_level_one_screening_id','=','jlos.id')
            ->join('jrfs as jrf', 'jas.jrf_id', 'jrf.id')
            ->join('employees as emp', 'jas.supervisor_id', '=', 'emp.user_id')
            ->where('jas.jrf_id', $id)
            ->select('jas.*', 'emp.fullname','jlos.name as cand_name')
            ->get();

        // Candidate Feedback

        $detail['jrf_cand_feedback'] = DB::table('closer as clos')
            ->join('jrf_level_one_screenings as jlos','clos.jrf_level_one_screening_id','=','jlos.id')
            ->join('jrfs as jrf', 'clos.jrf_id', 'jrf.id')
            ->join('employees as emp', 'clos.user_id', '=', 'emp.user_id')
            ->join('employees as emp2', 'clos.superwisor_id', '=', 'emp2.user_id')
            ->where('clos.jrf_id', $id)
            ->select('clos.*', 'emp.fullname','jlos.name as cand_name', 'emp2.fullname')
            ->get();

        $detail['jrf_closure_date_approvals'] = DB::table('mgmt_date_approvals as jas')
            ->join('jrfs as jrf', 'jas.jrf_id', 'jrf.id')
            ->join('employees as emp', 'jas.supervisor_id', '=', 'emp.user_id')
            ->where('jas.jrf_id', $id)
            ->select('jas.*', 'emp.fullname')
            ->get();
                

        $detail['dep_head'] = DB::table('employee_profiles as emp_prof')
            ->join('employees as emp','emp_prof.user_id','emp.user_id')
            ->join('departments as dep','emp_prof.department_id','dep.id')
            ->where('emp_prof.user_id',$detail['basic']->appointment_assign)
            ->select('dep.name as dep_name','emp.fullname as employee_name')
            ->first();
            //dd($dep_head);


           $data = $this->jrf_status_approve($id);
           $detail['jrf_can_app']  = $data['jrf_can_app'];
           $detail['reporting_manager']  = $data['reporting_manager'];
           $department    = Department::where(['isactive' => 1])->orderBy('name')->get();

           return view('jrf.view_jrf')->with(['detail' => $detail,'user' => $user,'department'=>$department]);
    }


    private function jrf_status_approve($id){

        $data = array();

        $data['jrf_can_app'] = DB::table('jrf_approvals as ja')
                ->join('jrfs as jrf', 'ja.jrf_id', '=', 'jrf.id')
                ->join('projects as prj','jrf.project_id','=','prj.id')
                ->join('employees as emp', 'emp.user_id', '=', 'jrf.user_id')
                ->join('roles as r', 'jrf.role_id', 'r.id')
                ->join('departments as dep', 'jrf.department_id', 'dep.id')
                ->join('designations as des', 'jrf.designation_id', 'des.id')
                ->leftjoin('jrf_hierarchies as jh', 'ja.supervisor_id', 'jh.user_id')
                ->where('ja.jrf_id', $id)
                ->select('ja.*', 'emp.fullname as jrf_creater_name', 'ja.jrf_status as jrf_approval_status', 'jrf.final_status', 'jrf.created_at', 'jrf.number_of_positions', 'jrf.salary_range', 'jrf.experience', 'jrf.gender', 'jrf.type', 'jrf.job_posting_other_website', 'des.name as designation', 'r.name as role', 'jh.user_id as hierarchy_user_id', 'jrf.jrf_no','prj.name as prj_name','jrf.jrf_closure_timeline','dep.name as department_name')
                ->orderBy('ja.jrf_id', 'DESC')
                ->first();  

            $get_recruitment   = LeaveAuthority::where('priority','2')->groupBy('manager_id')->pluck('manager_id')->toArray();

            $data['reporting_manager'] = Employee::whereIn('user_id', $get_recruitment)->select('user_id','fullname')->get();

            return $data; 

    }

    public function editJrfs($id)
    {

        if (Auth::guest()) {
            return redirect('/');
        }
        $user                   = User::where(['id' => Auth::id()])->first();

        $dep_id_user_wise = DB::table('employee_profiles')->where('user_id', $user->id)->select('department_id')->first();

        $data['tt']    = DB::table('departments')->where(['isactive' => 1,'id' => $dep_id_user_wise->department_id])->select('id','name')->first();

        $data['departments']    = Department::where(['isactive' => 1])->orderBy('name')->get();

        $data['roles']          = Role::select('id', 'name')->orderBy('name')->get();
        $data['cities']         = City::where(['isactive' => 1])->orderBy('name')->get();
        $data['skills']         = Skill::where(['isactive' => 1])->orderBy('name')->select('id', 'name')->get();
        $data['qualifications'] = Qualification::where(['isactive' => 1])->orderBy('name')->select('id', 'name')->get();
        $data['designation']    = Designation::where(['isactive' => 1])->orderBy('name')->select('id', 'name')->get();

        $data['benifit_perk']   = BenifitPerks::where(['isactive' => 1])->orderBy('name')->select('id', 'name')->get(); 

        $data['project'] = Project::where(['isactive' => 1])->orderBy('name')->select('id', 'name')->get();

        $project               = Jrf::where('id', $id)->pluck('project_id')->toArray();
        $data['saved_project'] = $project;

        $roles              = Jrf::where('id', $id)->pluck('role_id')->toArray();
        $data['saved_role'] = $roles;

        $designation               = Jrf::where('id', $id)->pluck('designation_id')->toArray();

        $data['saved_designation'] = $designation;

        $skills               = JrfSkill::where('jrf_id', $id)->pluck('skill_id')->toArray();
        $data['saved_skills'] = $skills;

        $benifit_perk = DB::table('jrf_benifts_perks')->where('jrf_id', $id)->pluck('benifits_perks_id')->toArray();
        
        $data['saved_benifit_perk'] = $benifit_perk;

        $qualification               = JrfQualification::where('jrf_id', $id)->pluck('qualification_id')->toArray();
        $data['saved_qualification'] = $qualification;

        $location               = JrfCity::where('jrf_id', $id)->pluck('city_id')->toArray();
        $data['saved_location'] = $location;

        $data['detail']              = Jrf::where('id', $id)->first();
        $dep_user = DB::table('employee_profiles')->where('department_id', $data['detail']->department_id)->get();
       //dd($dep_user);

        $data['get_static_interviewr_name'] = DB::table('employees')->where('user_id', $data['detail']->interviewr_id)->select('employees.fullname')->first();

        $data['recruitment_task_id'] = JrfRecruitmentTasks::where('jrf_id', $id)->value('id');
        $data['recruiters']          = Jrf::where(['id' => $id])->with('JrfRecruitmentTasks')->get();
        $data['recruitment_task']    = DB::table('jrf_recruitment_tasks as jrt')
            ->leftjoin('employees as emp', 'jrt.user_id', '=', 'emp.user_id')
            ->leftjoin('departments as dept', 'jrt.department_id', '=', 'dept.id')
            ->where('jrt.jrf_id', $id)
            ->select('jrt.*', 'emp.fullname', 'dept.name')
            ->get();
         //dd($data['recruitment_task']);   
        $data['last_date_recruitment'] = JrfRecruitmentTasks::where('jrf_id', $id)->where('user_id', $user->id)->orderBy('id', 'DESC')->value('last_date');
        if (!empty($data['last_date_recruitment'])) {
            $find_date = DateTime::createFromFormat('Y-m-d', $data['last_date_recruitment']);
            if (!empty($data['last_date'])) {
                $data['last_date'] = $find_date->format('d/m/Y');
            }
        }
        $data['approval_status'] = JrfApprovals::where('jrf_id', $id)->where('supervisor_id', $user->id)->orderBy('id', 'DESC')->first();

        $data['app'] = JrfApprovals:: where(['jrf_id' => $id])->get();
        //dd($data['app'][1]->supervisor_id);

        $data['arf']             = AdRequisitionForm::where('jrf_id', $id)->first();
        return view('jrf.edit_jrf')->with(['data' => $data,'user' => $user]);
    }

    public function levelOneScreening($jrf_id)
    {

        $user                   = User::where(['id' => Auth::id()])->first();

        $data['cities']         = City::where(['isactive' => 1])->orderBy('name')->get();
        $data['skills']         = Skill::where(['isactive' => 1])->orderBy('name')->select('id', 'name')->get();
        $data['qualifications'] = Qualification::where(['isactive' => 1])->orderBy('name')->select('id', 'name')->get();
        $data['languages']      = Language::where(['isactive' => 1])->orderBy('name')->select('id', 'name')->get();
        $data['departments']    = Department::where(['isactive' => 1])->orderBy('name')->get();
        $data['basic']          = DB::table('jrfs')
            ->join('employees as emp', 'jrfs.user_id', '=', 'emp.user_id')
            ->leftjoin('employees as emp2', 'jrfs.close_jrf_user_id', '=', 'emp2.user_id')
            ->join('roles as r', 'jrfs.role_id', 'r.id')
            ->join('designations as des', 'jrfs.designation_id', 'des.id')
            ->join('departments as dept', 'jrfs.department_id', '=', 'dept.id')
            ->where('jrfs.id', $jrf_id)
            ->select('jrfs.id', 'emp.user_id', 'emp.fullname', 'dept.name', 'des.name as designation', 'r.name as role')
            ->first();

        $data['basic_recruiter'] = DB::table('employees as emp')
            ->join('jrf_recruitment_tasks as jrt','emp.user_id','=','jrt.user_id')
            ->where('jrt.jrf_id',$jrf_id)
            ->select('jrt.user_id','emp.fullname')
            ->first();

        $dep_id_user_wise = DB::table('employee_profiles')->where('user_id', $user->id)->select('department_id')->first();

//        $data['tt']    = DB::table('departments')->where(['isactive' => 1,'id' => $dep_id_user_wise->department_id])->select('id','name')->first();

        $location = DB::table("city_jrf as cj")
            ->join('cities as c', 'cj.city_id', '=', 'c.id')
            ->where('cj.jrf_id', $jrf_id)
            ->pluck('c.name')->toArray();
        $data['location'] = implode(' , ', $location);

        $data['interviewer_details'] = DB::table('jrf_interviewer_details as jnd')
            ->join('jrf_level_one_screenings as jlos', 'jnd.jrf_level_one_screening_id', 'jlos.id')
            ->join('employees as emp', 'jnd.user_id', 'emp.user_id')
            ->where('jnd.jrf_id', $jrf_id)
            ->select('jlos.name', 'jlos.id', 'jlos.interview_date', 'jlos.interview_time', 'jlos.current_designation', 'jlos.reason_for_job_change', 'emp.fullname','jlos.candidate_status')
            ->groupBy('jlos.id')
            ->get();

        $data['recruitment_task_id'] = JrfRecruitmentTasks::where('jrf_id', $jrf_id)->where('user_id', Auth::id())->value('id');

        $data['last_date_recruitment'] = Jrf::where('id', $jrf_id)->orderBy('id', 'DESC')->value('jrf_closure_timeline');


        if (!empty($data['last_date_recruitment'])) {
            $find_date = DateTime::createFromFormat('Y-m-d', $data['last_date_recruitment']);
           
            if (!empty($find_date)) {
                $data['last_date'] = $find_date->format('d/m/Y');
                    
            }
        }

        return view('jrf.level_one_screening')->with(['data' => $data,'user' => $user]);
    }

    public function updateJrfs(Request $request)
    {


        if (Auth::guest()) {
            return redirect('/');
        }

        $validator = Validator::make($request->all(), [
            'number_of_positions'       => 'required',
            'gender'                    => 'required',
            'city_id'                   => 'bail|required',
            'job_description'           => 'required',
            'qualification_id'          => 'bail|required',
            'industry_type'             => 'required',
            'salary_range_from'         => 'required',
            'salary_range_to'           => 'required',
            'skill_id'                  => 'bail|required',
            'designation_id'            => 'bail|required',
        ]);

        if ($validator->fails()) {
            return redirect("jrf/edit-jrf/" . $request->jrf_id)
                ->withErrors($validator, 'basic')
                ->withInput();
        }
        $data = [
            'number_of_positions'       => $request->number_of_positions,
            'gender'                    => $request->gender,
            'description'               => $request->job_description,
            'industry_type'             => $request->industry_type,
            'shift_timing_from'         => $request->shift_timing_from,
            'shift_timing_to'           => $request->shift_timing_to,
            'designation_id'            => $request->designation_id,
            'final_status'              => '0',
        ];


        if (!empty($request->age_group_from)) {
            $data['age_group'] = $request->age_group_from . "-" . $request->age_group_to;
        }

        if (!empty($request->additional_requirement)) {
            $data['additional_requirement'] = $request->additional_requirement;
        } else {
            $data['additional_requirement'] = "";
        }

        if (!empty($request->salary_range_from)) {
            $data['salary_range'] = $request->salary_range_from . "-" . $request->salary_range_to;
        }

        if (!empty($request->year_experience_from)) {
            $data['experience'] = $request->year_experience_from . "-" . $request->year_experience_to;
        }

        // new JRF changes //
        if (!empty($request->type) && $request->type == 'Project') {
            if (!empty($request->certification)) {
                $data['certification'] = $request->certification;
            } else {
                $data['certification'] = "";
            }

            if (!empty($request->benefits_perks)) {
                $data['benefits_perks'] = $request->benefits_perks;
            } else {
                $data['benefits_perks'] = "";
            }

            if (!empty($request->temp_or_perm)) {
                $data['temp_or_perm'] = $request->temp_or_perm;
            } else {
                $data['temp_or_perm'] = "";
            }

            if (!empty($request->service_charges_fee)) {
                $data['service_charges_fee'] = $request->service_charges_fee;
            
            } else {
                $data['service_charges_fee'] = "";
            }
        } else {
            $data['certification']       = "";
            $data['benefits_perks']      = "";
            $data['temp_or_perm']        = "";
            $data['service_charges_fee'] = "";
        }

        // end jrf changes //

        $update_jrf = Jrf::updateOrCreate(['id' => $request->jrf_id], $data);

        if (!empty($request->skill_id)) {
            $update_jrf->jrfskills()->sync($request->skill_id);
        }

        if (!empty($request->qualification_id)) {
            $update_jrf->jrfqualifications()->sync($request->qualification_id);
        }

        if (!empty($request->city_id)) {
            $update_jrf->jrfcity()->sync($request->city_id);
        }

       /* if ($data['job_posting_other_website'] == "Yes") {
            $this->adRequisitionForm($update_jrf->id);
            return redirect('jrf/ad-requisition-form/' . $update_jrf->id);
        } else {
            $this->deactiveAdRequisitionForm($update_jrf->id);
            return redirect()->back()->with('success', "JRF updated successfully.");
        }*/
        
        return redirect()->back()->with('success',"JRF updated successfully.");
    }

    public function deactiveAdRequisitionForm($jrf_id)
    {

        $data = [
            'isactive' => "0",
        ];
        $result = AdRequisitionForm::updateOrCreate(['jrf_id' => $jrf_id], $data);
        return $result;
    }

    public function saveRecruitmentTasks(Request $request)
    {

        $recuitment_already_exists = JrfRecruitmentTasks::where(['jrf_id' => $request->jrf_hidden_id,'user_id' => $request->recruitment_interviewer_employee])->first();

        if(!empty($recuitment_already_exists)){
           
            return redirect()->back()->with('jrfError', "Recruiter already exists.");
           // dd("Exists....");
        }else{
            //dd("Not Exists....");
        $jrfA = Jrf::where('id',$request->jrf_hidden_id)->first();

        $data['designation']   =  Designation::where(['id' => $jrfA->designation_id])->select('id', 'name')->get();
        $data['department']    =  Department::where(['id' => $jrfA->department_id])->select('id', 'name')->get();
        $data['role']          =  Role::where(['id' => $jrfA->role_id])->select('id', 'name')->get();

        $job_role = DB::table('roles')
                ->where(['id' => $jrfA->role_id])
                ->select('name')
                ->first();

        $department = DB::table('departments')
                ->where(['id' => $jrfA->department_id])
                ->select('name')
                ->first();


        if (Auth::guest()) {
            return redirect('/');
        }

        $validator = Validator::make($request->all(), [
            'assigned_by' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect("jrf/edit-jrf/" . $request->jrf_hidden_id)
                ->withErrors($validator, 'basic')
                ->withInput();
        }

        $data = [
            'user_id'       => $request->recruitment_interviewer_employee, //is user id
            'department_id' => $request->recruitment_department,
            'jrf_id'        => $request->jrf_hidden_id,
            'assigned_by'   => $request->assigned_by,
            'isactive'      => "1",
        ];

        $user = User::where(['id' => Auth::id()])->with('employee')->first();
        $jrf = Jrf::where('id', $data['jrf_id'])->first();
        $approver    =  User::where(['id' => $jrf->user_id])->with('employee')->first();
        $jrf_assigned_to = User::where(['id' => $request->recruitment_interviewer_employee])->with('employee')->first();



        //dd($jrf_assigned_to->employee->fullname);

        $saved_recruitment_tasks = $jrf->jrfRecruitmentTasks()->create($data);

            // for next approval and jrf asssigned to person name
            $get_jrf_approvded_status = JrfApprovals::where('jrf_id', $request->jrf_hidden_id)->where('supervisor_id', $request->assigned_by)->first();

            $update_approval_status = ['jrf_status' => '1'];

            $result = JrfApprovals::updateOrCreate(['supervisor_id' => $request->assigned_by, 'jrf_id' => $request->jrf_hidden_id], $update_approval_status);


            if (!empty($result)) {
                //When JRF Approved By MD sir Send Notification to Creator of JRF //

                $notification_data = [
                    'sender_id'   => Auth::id(),
                    'receiver_id' => $jrf->user_id,
                    'label'       => 'JRF Approved',
                    'read_status' => '0',
                ];

                $notification_data['message'] = "JRF Approved by " . $user->employee->fullname;
                $jrf->notifications()->create($notification_data);

                $notificationMessage = $user->employee->fullname." Sent Request For JRF Screenig Start For The Position of ".$job_role->name." From ".$department->name. " Department";

                //////////////////////////Mail///////////////////////////
                $reporting_manager     = Employee::where(['user_id' => $notification_data['sender_id']])->with('user')->first();
                $mail_data['to_email'] = $reporting_manager->user->email;
                $mail_data['subject']  = "JRF Approved";
                $mail_data['message']  = "JRF Approved By " . $user->employee->fullname . " Please Check the detail of JRF. Here is the link for website <a href='" . url('/') . "'>Click here</a>";
                $mail_data['fullname'] = $reporting_manager->fullname;
                
                sms($jrf_assigned_to->employee->mobile_number,$notificationMessage);

                //$this->sendGeneralMail($mail_data);
            }

            //////////////////////////Notify///////////////////////////
            $notification_data = [
                'sender_id'   => $jrf->user_id,
                'receiver_id' => $request->recruitment_interviewer_employee,
                'label'       => 'JRF Assigned',
                'read_status' => '0',
            ];

            $notification_data['message'] = "JRF assigned by " . $user->employee->fullname;
            $jrf->notifications()->create($notification_data);

            //////////////////////////Mail///////////////////////////
            $reporting_manager     = Employee::where(['user_id' => $request->recruitment_interviewer_employee])->with('user')->first();
            $mail_data['to_email'] = $reporting_manager->user->email;
            $mail_data['subject']  = "JRF Assigned";
            $mail_data['message']  = $user->employee->fullname . " assigned JRF. Please take an action. Here is the link for website <a href='" . url('/') . "'>Click here</a>";
            $mail_data['fullname'] = $reporting_manager->fullname;
            //$this->sendGeneralMail($mail_data);
            return redirect()->back()->with('success', "Recruiter assigned successfully.");
        }
    }

    public function sendGeneralMail($mail_data)
    {
        //mail_data Keys => to_email, subject, fullname, message

        if (!empty($mail_data['to_email'])) {
            Mail::to($mail_data['to_email'])->send(new GeneralMail($mail_data));
        }
        return true;
    } //end of function

    
    public function saveLevelOneScreeningDetail(Request $request)
    {
        /*
            if($request->final_status == 'Recommended-Level-2-interview'){

                Jrf:: where('id',$request->jrf_id)-> increment('lvl_one_screen');

            } 
        */   
    
       

        if (Auth::guest()) {
            return redirect('/');
        }

        $validator = Validator::make($request->all(), [
            'name'                    => 'required',
            'contact'                 => 'required',
            'total_experience'        => 'required',
            'current_ctc'             => 'required',
            'notice_period'           => 'required',
            'interview_date'          => 'bail|required',
            'final_status'            => 'bail|required'
        ]);

        
        if ($validator->fails()) {
            return redirect("jrf/edit-candidate-level-one-screening-detail/" . $request->jrf_level_one_screening_id)
                ->withErrors($validator, 'basic')
                ->withInput();
        }

        if (empty($request->interview_date)) {
            $date           = DateTime::createFromFormat('d/m/Y', $request->interview_date);
            $interview_date = $date->format('Y-m-d');
        } else {
            $interview_date = $request->interview_date;
        }

        $data = [
            'user_id'                 => $request->user_id, //is user id
            'name'                    => $request->name,
            'jrf_id'                  => $request->jrf_id,
            'contact'                 => $request->contact,
            'recruitment_task_id'     => $request->recruitment_task_id,
            'age'                     => $request->age,
            'city_id'                 => $request->city_id,
            'native_place'            => $request->native_place,
            'total_experience'        => $request->total_experience,
            'relevant_experience'     => $request->relevant_experience,
            'current_designation'     => $request->current_designation,
            'current_cih'             => $request->current_cih,
            'current_ctc'             => $request->current_ctc,
            'exp_ctc'                 => $request->exp_ctc,
            'reason_for_job_change'   => $request->reason_for_job_change,
            'current_company_profile' => $request->current_company_profile,
            'travel'                  => $request->travel,
            'contract'                => $request->contract,
            'notice_period'           => $request->notice_period,
            'interview_date'          => $interview_date,
            'interview_time'          => $request->interview_time,
            'interview_type'          => $request->interview_type,
            'personal_laptop'         => $request->personal_laptop,
            'candidate_status'        => $request->final_status,
        ];

        if ($request->hasFile('image')) {
            $image = time() . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(config('constants.uploadPaths.uploadCandidateImage'), $image);
            $data['image'] = $image;
        }

        if ($request->hasFile('image_resume')) {
            $imageA = time() . '.' . $request->file('image_resume')->getClientOriginalExtension();
            $request->file('image_resume')->move(config('constants.uploadPaths.uploadCandidateResume'), $imageA);
            $data['resume'] = $imageA;

        }
        
        if (!empty($request->notice_period_duration)) {
            $data['notice_period_duration'] = $request->notice_period_duration;
        } else {
            $data['notice_period_duration'] = "";
        }

        if (!empty($request->joining_date)) {
            $data['joining_date'] = $request->joining_date;
        } else {
            $data['joining_date'] = "";
        }

        ////////////////////////////////////////////////

        if (!empty($data['candidate_status']) && $data['candidate_status'] == "Backoff" || $data['candidate_status'] == "Rejected") {
            if (!empty($request->backoff_reason)) {
                $data['other_backoff_reason'] = $request->backoff_reason;
            } else {
                $data['other_backoff_reason'] = "";
            }

            if (!empty($request->rejected_reason)) {
                $data['other_rejected_reason'] = $request->rejected_reason;
            } else {
                $data['other_rejected_reason'] = "";
            }
        } else {
            $data['other_rejected_reason'] = "";
            $data['other_backoff_reason']  = "";
        }

        ///////////////////////////////////////////////

        $jrf  = Jrf::where('id', $data['jrf_id'])->first();
        $user = User::where(['id' => Auth::id()])->with('employee')->first();
        $get_mobile_user_data = User::where(['id' => $request->interviewer_employee])->with('employee')->first();

        $job_role = DB::table('roles')
                ->where(['id' => $jrf->role_id])
                ->select('name')
                ->first();

        $department = DB::table('departments')
                ->where(['id' => $jrf->department_id])
                ->select('name')
                ->first();

        if (!empty($request->jrf_level_one_screening_id)) {
            $saved_level_one_detail = JrfLevelOneScreening::updateOrCreate(['id' => $request->jrf_level_one_screening_id], $data);
        } else {
            $saved_level_one_detail = $user->jrfLevelOneScreening()->create($data);
        }

        if (!empty($request->skill_id)) {
            $saved_level_one_detail->levelOneScreeningSkill()->sync($request->skill_id);
        }

        if (!empty($request->qualification_id)) {
            $saved_level_one_detail->levelOneScreeningQualification()->sync($request->qualification_id);
        }

        if (!empty($request->languageIds)) {
            $saved_level_one_detail->levelOneScreeninglanguages()->sync($request->languageIds);
        }

        $post_array           = $request->all();
        $language_check_boxes = [];

        foreach ($request->languageIds as $key => $value) {

            $key2 = 'lang' . $value;
            if (!empty($post_array[$key2])) {
                $language_check_boxes[$value] = $post_array[$key2];
            } else {
                $language_check_boxes[$value] = array();
            }

            if (in_array('1', $language_check_boxes[$value])) {
                $check_box_data['read_language'] = true;
            } else {
                $check_box_data['read_language'] = false;
            }

            if (in_array('2', $language_check_boxes[$value])) {
                $check_box_data['write_language'] = true;
            } else {
                $check_box_data['write_language'] = false;
            }

            if (in_array('3', $language_check_boxes[$value])) {
                $check_box_data['speak_language'] = true;
            } else {
                $check_box_data['speak_language'] = false;
            }

            $find_language = DB::table('jrf_level_one_screening_language')
                ->where(['language_id' => $value])
                ->update($check_box_data);
        }


        //Save Interviwer Detail //
        $interviewerArray = [
            'user_id'             => $request->interviewer_employee,
            'department_id'       => $request->interviewer_department,
            'jrf_id'              => $request->jrf_id,
            'recruitment_task_id' => $request->recruitment_task_id,
            'assigned_by'         => $request->user_id, //loged in user Id
        ];

        if( empty($request->jrf_level_one_screening_id) ){

            $saved_level_one_detail->jrfinterviewerdetail()->create($interviewerArray);
        }
        //////////////////////////Notify///////////////////////////

        if (empty($request->jrf_level_one_screening_id) || $request->candidate_status == "Shortlisted" || $request->candidate_status == "Recommended-Level-2-interview" || $request->candidate_status == "On-hold") {

            $notification_data = [
                'sender_id'   => $request->user_id,
                'receiver_id' => $request->interviewer_employee,
                'label'       => 'Interview Scheduled',
                'read_status' => '0',
            ]; //Working

            $notification_data['message'] = $user->employee->fullname . " scheduled the Interview of  " . $data['name'] . " ";
            $saved_level_one_detail       = $jrf->notifications()->create($notification_data);

            $notificationMessage = $user->employee->fullname." Scheduled Interview For The Position of ".$job_role->name." From ".$department->name. " Department, Candidate Name Is ".$request->name;

            //////////////////////////Mail///////////////////////////
            $reporting_manager = Employee::where(['user_id' => $request->interviewer_employee])
                ->with('user')->first();
            $mail_data['to_email'] = $reporting_manager->user->email;
            $mail_data['subject']  = "JRF Interview Scheduled";
            $mail_data['message']  = $user->employee->fullname . " scheduled the Interview of " . $data['name'] . ". Please check detail of interview. Here is the link for website <a href='" . url('/') . "'>Click here</a>";
            $mail_data['fullname'] = $reporting_manager->fullname;


            ////$this->sendJrfGeneralMail($mail_data); //working
            //////////////////////////End///////////////////////////
        }
        //End of InterViewer Detail //
        if (!empty($request->jrf_level_one_screening_id)) {
            return redirect("jrf/edit-candidate-level-one-screening-detail/" . $request->jrf_level_one_screening_id)->with('success', 'Level One screening detail has been updated successfully');
        } else {
                
            sms($get_mobile_user_data->employee->mobile_number,$notificationMessage);    

            
            return redirect()->back()->with('success', 'Level One screening detail has been saved successfully');
           // return redirect('jrf/recruitment-tasks-assigned-jrf-list')->with('success','Level One screening detail has been saved successfully');
        }

    }

    public function approveJrf($jrf_status = null)
    {

        if (Auth::guest()) {
            return redirect('/');
        }
        $user = User::where(['id' => Auth::id()])->first();

        if (empty($jrf_status) || $jrf_status == 'pending') {
            $status     = '0';
            $jrf_status = 'pending'; //pending as a inprogress //
        } elseif ($jrf_status == 'assigned') {
            $status     = '1';
            $jrf_status = 'Approved';
        } elseif ($jrf_status == 'rejected') {
            $status     = '2';
            $jrf_status = 'Rejected';
        } elseif ($jrf_status == 'closed') {
            $status     = '3'; // created custom status //
            $jrf_status = 'Send Back';
        }

        $data = DB::table('jrf_approvals as ja')
            ->join('jrfs as jrf', 'ja.jrf_id', '=', 'jrf.id')
            ->join('projects as prj','jrf.project_id','=','prj.id')
            ->join('employees as emp', 'emp.user_id', '=', 'jrf.user_id')
            ->join('roles as r', 'jrf.role_id', 'r.id')
            ->join('departments as dep', 'jrf.department_id', 'dep.id')
            ->join('designations as des', 'jrf.designation_id', 'des.id')
            ->leftjoin('jrf_hierarchies as jh', 'ja.supervisor_id', 'jh.user_id')
            ->where(['ja.supervisor_id' => $user->id, 'ja.jrf_status' => $status, 'jrf.isactive' => 1])
            ->select('ja.*', 'emp.fullname as jrf_creater_name', 'ja.jrf_status as jrf_approval_status', 'jrf.final_status', 'jrf.created_at', 'jrf.number_of_positions', 'jrf.salary_range', 'jrf.experience', 'jrf.gender', 'jrf.type', 'jrf.job_posting_other_website', 'des.name as designation', 'r.name as role', 'jh.user_id as hierarchy_user_id', 'jrf.jrf_no','prj.name as prj_name','jrf.jrf_closure_timeline','dep.name as department_name')
            ->orderBy('ja.jrf_id', 'DESC')
            ->get();

        if (!$data->isEmpty()) {
            foreach ($data as $key => $value) {
                
                $priority_wise_status = DB::table('jrf_approvals as ala')
                                  ->where(['ala.jrf_id' => $value->jrf_id])
                                  ->select('ala.priority','ala.jrf_status')
                                  ->orderBy('ala.priority')
                                  ->get();

                $value->priority_wise_status = $priority_wise_status;

                if ($value->jrf_status == '0') {
                    $value->secondary_final_status = 'In-Progress';
                } elseif ($value->jrf_status == '3' && $value->final_status == 1) {
                    $value->secondary_final_status = 'closed';
                } elseif ($value->jrf_status == '2') {
                    $value->secondary_final_status = 'Rejected';
                } elseif ($value->jrf_status == '1' && $value->final_status == 0) {
                    $value->secondary_final_status = 'assigned';
                }
            }
        }

        $get_recruitment   = LeaveAuthority::where('priority','2')->groupBy('manager_id')->pluck('manager_id')->toArray();

        $reporting_manager = Employee::whereIn('user_id', $get_recruitment)->select('user_id','fullname')->get();

        $department    = Department::where(['isactive' => 1])->orderBy('name')->get();

        return view('jrf.list_jrf_approvals')->with(['data' => $data, 'selected_status' => $jrf_status,'reporting_manager' => $reporting_manager,'department' => $department]);
    }

    public function cancelCreatedJrf($jrf_id)
    {

        if (Auth::guest()) {
            return redirect('/');
        }
        $created_jrf = Jrf::find($jrf_id);
        $user_id     = Auth::id();

        $approval = $created_jrf->jrfapprovals()
            ->where('jrf_status', '!=', '0')
            ->first();
        if (!empty($approval)) {
            return redirect()->back()->with('cannot_cancel_error', 'Reporting manager has taken a decision. You cannot cancel the JRF now.');
        } elseif (($created_jrf->user_id == $user_id) && empty($approval)) {
            $created_jrf->final_status = "0";
            $created_jrf->isactive     = "0";
            $created_jrf->save();
        }
        return redirect('jrf/list-jrf')->with('success', 'Cancelled JRF successfully');
    }

    public function updateInterviewStatusDetail(Request $request)
    {

        if (Auth::guest()) {
            return redirect('/');
        }
        $data = [
            'interview_status' => $request->interview_status, //is user id
            'updated_at'       => date('Y-m-d H:i:s'),
        ];

        if (!empty($request->interview_status) && $request->interview_status == "Backoff") {
            if ($request->backoff_reason == 'other_backout_reason') {
                $data['other_backoff_reason']  = $request->other_backoff_reason;
                $data['final_status']          = $request->backoff_reason;
                $data['other_rejected_reason'] = "";
            } else {
                $data['final_status']         = $request->backoff_reason;
                $data['other_backoff_reason'] = "";
            }
        }

        if (!empty($request->interview_status) && $request->interview_status == "Rejected") {
            if ($request->rejected_reason == 'other_rejection_reason') {
                $data['other_rejected_reason'] = $request->other_rejected_reason;
                $data['final_status']          = $request->rejected_reason;
                $data['other_backoff_reason']  = "";
            } else {
                $data['final_status']          = $request->rejected_reason;
                $data['other_rejected_reason'] = "";
            }
        }

        if ($request->interview_status == "Selected") {
            $data['final_status']          = "";
            $data['other_rejected_reason'] = "";
            $data['other_backoff_reason']  = "";
        }

        DB::table('jrf_interviewer_details')->where('id', $request->interview_detail_id)->update($data);
        return redirect()->back()->with('success', 'Current Status of interview  saved successfully');
    }

    public function interviewStatusInfo(Request $request)
    {

        if (Auth::guest()) {
            return redirect('/');
        }
        $data = DB::table('jrf_interviewer_details as jid')
            ->leftjoin('jrfs as jrf', 'jid.jrf_id', '=', 'jrf.id')
            ->leftjoin('departments as dept', 'jid.department_id', '=', 'dept.id')
            ->where('jid.id', $request->id)
            ->select('jid.*', 'dept.name as department_name', 'jid.interview_date')
            ->first();

        $view     = View::make('jrf.recruitment_info', ['data' => $data]);
        $contents = $view->render();
        return $contents;
    }

    public function closeJrfPermanently(Request $request)
    {

        if (Auth::guest()) {
            return redirect('/');
        }
        $data = [
            'id'                => $request->id, // JRF ID
            'close_jrf_user_id' => $request->employeeId,
            'final_status'      => '1',
            'close_jrf_date'    => date('Y-m-d H:i:s'),
        ];

        $user      = User::where(['id' => Auth::id()])->with('employee')->first();
        $close_jrf = jrf::where('id', $data['id'])->update($data);
        $jrf       = Jrf::where('id', $data['id'])->first();

        // update status jrf_status = 3(close) of jrf_approvals
        $update_approval = [
            'jrf_status' => '3',
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        $close_jrf = $jrf->jrfapprovals()->where('jrf_id', $data['id'])->update($update_approval);
        // end

        $approval_user_id       = JrfApprovals::where('jrf_id', $request->id)->where('user_id', '!=', $user->id)->pluck('user_id')->toArray();
        $approval_supervisor_id = JrfApprovals::where('jrf_id', $request->id)->where('supervisor_id', '!=', $user->id)->pluck('supervisor_id')->toArray();
        $user_ids               = array_unique(array_merge($approval_user_id, $approval_supervisor_id));

        //dd($user_ids);die;

        //////////////////////////Notify///////////////////////////
        $jrf_hierarchy = JrfHierarchy::where('isactive', 1)->where('type', 'approval')->orderBy('id', 'DESC')->first();

        foreach ($user_ids as $key => $value) {

            $notification_data = [
                'sender_id'   => $request->employeeId,
                'receiver_id' => $value,
                'label'       => 'JRF Closed',
                'read_status' => '0',
            ];
        }

        $notification_data['message'] = "JRF Closed By " . $user->employee->fullname;
        $close_jrf                    = $jrf->notifications()->create($notification_data); // inprogress

        //////////////////////////Mail///////////////////////////
        $reporting_manager = Employee::where(['user_id' => $jrf_hierarchy->user_id])
            ->with('user')->first();
        $mail_data['to_email'] = $reporting_manager->user->email;
        $mail_data['subject']  = "JRF Closed";
        $mail_data['message']  = "JRF closed By " . $user->employee->fullname . " Here is the link for website <a href='" . url('/') . "'>Click here</a>";
        $mail_data['fullname'] = 'Sir';
        //$mail_data['fullname'] = $reporting_manager->fullname;
        ////$this->sendJrfGeneralMail($mail_data);
    }

    public function sendJrfGeneralMail($mail_data)
    {
        //mail_data Keys => to_email, subject, fullname, message
        if (!empty($mail_data['to_email'])) {
            Mail::to($mail_data['to_email'])->send(new JrfGeneralMail($mail_data));
        }
        return true;
    } //end of function

    public function saveJrfApproval(Request $request)
    {

        if (Auth::guest()) {
            return redirect('/');
        }

        $request->validate([
            'remark' => 'required',
        ]);



        $applied_jrf =  JrfApprovals::where('jrf_id', $request->jrf_id)->first();
        $jrf         =  Jrf::where('id', $request->jrf_id)->first();
        $approver    =  User::where(['id' => $jrf->user_id])->with('employee')->first();

        $applied_jrf->jrf_status = $request->final_status;
       
        if( $request->final_status == '1' ){

          $applied_jrf->save();   
        }

       
        $applier = $applied_jrf->user;

        $job_role = DB::table('roles')
                ->where(['id' => $jrf->role_id])
                ->select('name')
                ->first();


        $department = DB::table('departments')
                ->where(['id' => $jrf->department_id])
                ->select('name')
                ->first();

        if($request->final_status == '1'){

            $get_mobile_user_data = User::where(['id' => $request->rec_head])
                ->with('employee')
                ->first();
        }else{

            $get_mobile_user_data = User::where(['id' => $request->u_id])
                ->with('employee')
                ->first();
          
        }        

        

        // Send message to JRF Creator when JRF Request approved by HOD Level One//

        $message_data = [
            'sender_id'   => $request->userId, //$jrf->user_id
            'receiver_id' => $applier->id,
            'label'       => 'JRF Remarks',
            'message'     => $request->remark,
            'read_status' => '0',
        ];


        $applied_jrf->messages()->create($message_data);
    

            if( $request->jrf_id && $request->final_status == '3' ){

                // Send Back to Jrf Creater

                $user_detail = User::where(['id' => Auth::id()])
                ->with('employee') // get Recruiters HOD detail for approval
                ->first();

                $notification_data = [
                    'sender_id'   => $request->userId, //$jrf->user_id
                    'receiver_id' => $request->u_id,
                    'label'       => 'Jrf Send Back Request Raise MD sir',
                    'message'     => $user_detail->employee->fullname . " Jrf Send Back Request Raise MD sir Pls chk Jrf edit to view Send Back Remark.",
                    'read_status' => '0',
                ];
               
                $update_status = ['jrf_status' => '3'];
                
                $result = JrfApprovals::updateOrCreate(['supervisor_id' => $request->userId, 'jrf_id' => $request->jrf_id,'user_id' => $request->u_id],$update_status);

                $jrf_clm_updt = Jrf::where(['id' => $request->jrf_id])->update(['send_back_remark' => $request->remark]);

                $jrf->notifications()->create($notification_data);

                $user_data  = User::where('id', $request->u_id)->first();

                $notificationMessage = $user_detail->employee->fullname." has sent back the JRF for the position ".$job_role->name;                

                //Send Mail && SMS to the next approver
                if (!empty($result)) {
                    $mail_data['subject']  = 'Jrf Send Back Request';
                    $mail_data['to_email'] = $user_data->email;
                    $mail_data['message']  = $user_detail->employee->fullname . " Jrf Send Back Request Raise MD sir Pls chk Jrf edit to view Send Back Remark. Please take an action. Here is the link for website <a href='" . url('/') . "'Click here</a>";
                    $mail_data['fullname'] = "Sir";
                    
                    sms($get_mobile_user_data->employee->mobile_number,$notificationMessage);    
                    //$this->sendJrfGeneralMail($mail_data);
                }
            
            }else{

            $user_detail = User::where(['id' => Auth::id()])
                ->with('employee') // get Recruiters HOD detail for approval
                ->first();

            $next_approver = JrfApprovals::where(['jrf_id' => $applied_jrf->jrf_id, 'supervisor_id' => $request->userId])->first();

            $user_data  = User::where('id', $request->rec_head)->first(); 
              
            // When Jrf Approved by Hod then  Entering in this Condition
 
            if (!empty($next_approver) && $request->final_status == '1') {

                    //Approved on previous level

                $next_approval_data = [
                    'user_id'       => $applied_jrf->user_id,
                    'supervisor_id' => $request->rec_head,
                    'priority'      => 3,
                    'jrf_status'    => '0',
                ];

                //Send Notification to next  level


                $notification_data = [
                    'sender_id'   => $request->userId, //$jrf->user_id
                    'receiver_id' => $request->rec_head,
                    'label'       => 'JRF Approval',
                    'message'     => $user_detail->employee->fullname . " sent request for JRF approval.",
                    'read_status' => '0',
                ];


                if ($next_approval_data['priority'] == '3') {
                   
                    // Approved By MD then creates a row in jrf_approvals table with supervisor_id 
                   
                    $jrf_approval_insert_id = $jrf->jrfapprovals()->create($next_approval_data);

                    $update_jrf_appointment = DB::table('jrfs')->where('id',$request->jrf_id)->update(['appointment_assign' => $request->interviewer_employee]);

                    $jrf->notifications()->create($notification_data);
                }

                $notificationMessage = $user_detail->employee->fullname . " Assigned JRF For the position of ".$job_role->name;

                //Send Mail && SMS to the next approver
                if (!empty($jrf_approval_insert_id)) {
                    $mail_data['subject']  = 'JRF Approval';
                    $mail_data['to_email'] = $user_data->email;
                    $mail_data['message']  = $user_detail->employee->fullname . " sent request for JRF approval. Please take an action. Here is the link for website <a href='" . url('/') . "'Click here</a>";
                    $mail_data['fullname'] = "Sir";

                    sms($get_mobile_user_data->employee->mobile_number,$notificationMessage);

                    ////$this->sendJrfGeneralMail($mail_data);
                }

                return redirect()->back()->with('success','JRF Approved successfully');

            } elseif ($request->final_status != '1') {

                    $get_jrf_approvded_status = JrfApprovals::where(['jrf_id'=> $request->jrf_id,'supervisor_id'=> $request->userId])->first();


                    $update_approval_status = ['jrf_status' => '2'];

                    $result = JrfApprovals::updateOrCreate(['supervisor_id' => $request->userId, 'jrf_id' => $request->jrf_id], $update_approval_status);


                    $notificationMessage = $user_detail->employee->fullname . " Reject the JRF  For the position of ".$job_role->name;

                    if (!empty($result)) {
                        //When JRF Rejected By MD sir Send Notification to Creator of JRF //
                        $notification_data = [
                            'sender_id'   => $get_jrf_approvded_status->supervisor_id,
                            'receiver_id' => $get_jrf_approvded_status->user_id,
                            'label'       => 'JRF Rejected',
                            'read_status' => '0',
                        ];

                        $notification_data['message'] = "JRF Rejected by " . $user_detail->employee->fullname;
                        $jrf->notifications()->create($notification_data);

                        sms($get_mobile_user_data->employee->mobile_number,$notificationMessage);

                        return redirect()->back()->with('success','JRF Rejected successfully');
                    }


            } elseif (!empty($next_approver) && $request->final_status == '1' && !empty($next_approver_present)) {

                //No this is working when JRf approved by MA Sir...then no next level of approval
                //when approving again

                $applied_jrf = $this->updateJrfApprovalStatus($applied_jrf, $user_detail);
                if (!empty($applied_jrf) && $applied_jrf->supervisor_id == 13) {
                    
                    //return redirect("jrf/edit-jrf/" . $applied_jrf->jrf_id);

                    return redirect()->back()->with('success','JRF Approved successfully');

                } else {

                    //return redirect("jrf/approve-jrf/");

                    return redirect()->back()->with('success','JRF Approved successfully');
                }
            }

        }

            $mail_data['to_email'] = $applier->email;
            $mail_data['fullname'] = $applier->employee->fullname;
            if ($applied_jrf->final_status == '1') {

                $mail_data['subject'] = "JRF Approved";
                $mail_data['message'] = "Your JRF has been approved. Check status on the <a href='" . url('/') . "'>website</a>.";
                $this->sendGeneralMail($mail_data);

            } elseif ($applied_jrf->leave_status == '2') {
                $mail_data['subject'] = "JRF Rejected";
                $mail_data['message'] = "Your JRF has been rejected. Check status on the <a href='" . url('/') . "'>website</a>.";
                $this->sendGeneralMail($mail_data);
            }
            return redirect("jrf/approve-jrf");
    }

    public function interviewList()
    {

        $user = User::where(['id' => Auth::id()])->first();

        $data = DB::table('jrf_interviewer_details as jnd')
            ->join('jrf_level_one_screenings as jlos', 'jnd.jrf_level_one_screening_id','=', 'jlos.id')
            ->join('employees as emp', 'jnd.assigned_by','=','emp.user_id')
            ->join('jrfs as jrf','jnd.jrf_id','=','jrf.id')
            ->where('jnd.user_id', $user->id)
            ->where('jlos.candidate_status','Recommended-Level-2-interview')
            ->select('jlos.name','jlos.id as jrf_level_one_screening_id','jlos.interview_date','jlos.interview_time','jlos.current_designation','jlos.reason_for_job_change', 'emp.fullname','jnd.jrf_id','jlos.lvl_sec_id','jrf.jrf_no','jrf.closure_type')
            ->groupBy('jlos.id')
            ->orderBy('jlos.id','DESC')
            ->get();

        return view('jrf.candidate_interview_list')->with(['datas' => $data]);
    }

    public function checkJrfApprovalOnAllLevels($applied_jrf)
    {

        $all_supervisors          = $applied_jrf->appliedJrf()->count();
        $all_approved_supervisors = $applied_jrf->appliedJrf()->where(['jrf_status' => '1'])->count();
        if ($all_supervisors == $all_approved_supervisors) {
            $applied_jrf->jrf_status = '1';
            $applied_jrf->save();
        }
        return $applied_jrf;
    }

    public function updateJrfApprovalStatus($applied_jrf, $user)
    {

        $auth_id       = Auth::id();
        $next_approver = JrfApprovals::where('supervisor_id', $auth_id)->first();
        $jrf           = Jrf::where('id', $applied_jrf->jrf_id)->first();

        $next_approval_data = [
            'jrf_status' => '1',
        ];

        $notification_data = [
            'sender_id'   => $applied_jrf->supervisor_id,
            'receiver_id' => $applied_jrf->user_id,
            'label'       => 'JRF Application',
            'message'     => $user->employee->fullname . " Approved JRF.",
            'read_status' => '0',
        ];

        if ($next_approver->priority == '4' && $next_approver->jrf_status == '0') {
            $next_approver->jrf_status == '0'; //Approvale pending from MD sir END //
            $jrf_approval_insert_id = $jrf->jrfapprovals()->where('id', $next_approver->id)->update($next_approval_data);
            $jrf->notifications()->create($notification_data);
        }

        return $next_approver;
    }

    public function assignedJrfList()
    {

        $auth_id = Auth::id();
       
        $data   = DB::table('jrf_recruitment_tasks as jrt')
            ->join('jrfs as jrf', 'jrt.jrf_id', 'jrf.id')
            ->join('projects as proj','jrf.project_id','proj.id')
            ->join('jrf_approvals as ja', 'jrf.id', 'ja.jrf_id')
            ->join('designations as des', 'jrf.designation_id', 'des.id')
            ->join('departments as depart', 'jrf.department_id', 'depart.id')
            ->join('employees as emp', 'jrt.assigned_by', '=', 'emp.user_id')
            ->join('roles as r', 'jrf.role_id', 'r.id')
            ->where('jrt.user_id', $auth_id)
            ->where('ja.supervisor_id', 13)
            ->where('ja.jrf_status', '1')
            ->select('jrf.id', 'jrf.user_id as jrf_creater', 'ja.jrf_status', 'des.name as designation','r.name as role','depart.name as department', 'jrt.*', 'emp.fullname as assigned_by','jrf.final_status', 'jrt.created_at as recruitment_assigned_date','jrt.final_appointment_assigned_status','jrf.number_of_positions as npos','jrf.lvl_one_screen as lvl_one_screen','proj.name as proj_name','jrf.jrf_no','jrf.closure_type','jrt.assigned_by as assigned_to_id','jrf.jrf_closure_timeline','jrf.extended_date_status','jrf.extended_date_rejected','jrt.is_assigned')
            ->groupBy('jrt.id')
            ->orderBy('jrt.id', 'DESC')
            ->get();   
            //dd($data);
        //$data['date_befor_three_days'] = date('Y-m-d', strtotime('-3 days', strtotime($data['basic'][0]->jrf_closure_timeline)));


        if (!$data->isEmpty()) {
            foreach ($data as $key => $value) {
                if ($value->jrf_status == '0') {
                    $value->secondary_final_status = 'In-Progress';
                } elseif ($value->jrf_status == '3' && $value->final_status == 1) {
                    $value->secondary_final_status = 'Closed';
                } elseif ($value->jrf_status == '2') {
                    $value->secondary_final_status = 'Rejected';
                } elseif ($value->jrf_status == '1' && $value->final_status == 0) {
                    $value->secondary_final_status = 'Approved';
                }
            }
        }

        return view('jrf.recruitment_assigned_jrf')->with(['data' => $data]);
    }

    public function approveArf($arf_status = null)
    {

        if (Auth::guest()) {
            return redirect('/');
        }
        $user = User::where(['id' => Auth::id()])->first();
        //dd($user);
        if (empty($arf_status) || $arf_status == 'pending') {
            $status     = '0';
            $arf_status = 'pending'; //pending as a inprogress //
        } elseif ($arf_status == 'approved') {
            $status     = '1';
            $arf_status = 'approved';
        } elseif ($arf_status == 'rejected') {
            $status     = '2';
            $arf_status = 'rejected';
        }


        $data = DB::table('arf_approvals as arf')
            ->join('jrfs as jrf', 'arf.jrf_id', '=', 'jrf.id')
            ->join('projects as prj','jrf.project_id','=','prj.id')
            ->join('employees as emp', 'emp.user_id', '=', 'jrf.user_id')
            ->join('roles as r', 'jrf.role_id', 'r.id')
            ->join('designations as des', 'jrf.designation_id', 'des.id')
            ->leftjoin('jrf_hierarchies as jh', 'arf.supervisor_id', 'jh.user_id')
            ->where(['arf.supervisor_id' => $user->id, 'arf.arf_status' => $status, 'jrf.isactive' => 1, 'arf.priority' => 3])
            ->select('arf.*', 'emp.fullname as jrf_creater_name', 'arf.arf_status as arf_approval_status', 'jrf.final_status', 'jrf.created_at', 'jrf.number_of_positions', 'jrf.salary_range', 'jrf.experience', 'jrf.gender', 'jrf.type', 'jrf.job_posting_other_website', 'des.name as designation', 'r.name as role', 'jh.user_id as hierarchy_user_id', 'jrf.jrf_no','prj.name as prj_name')
            ->orderBy('arf.jrf_id', 'DESC')
            ->get();

        if (!$data->isEmpty()) {
            foreach ($data as $key => $value) {

                if ($value->arf_status == "0") {
                    $value->secondary_final_status = 'Pending';
                } elseif ($value->arf_status == "1" && $value->final_status == "1") {

                    $value->secondary_final_status = 'Closed';
                } elseif ($value->arf_status == "2") {

                    $value->secondary_final_status = 'Rejected';
                } elseif ($value->arf_status == "1" && $value->final_status == "0") {
                    $value->secondary_final_status = 'Approved';
                }
            }
        }
        return view('jrf.list_arf_approvals')->with(['data' => $data, 'selected_status' => $arf_status]);
    }

    public function saveArfApproval(Request $request)
    {


        if (Auth::guest()) {
            return redirect('/');
        }
        $request->validate([
            'remark' => 'required',
        ]);

        $arf_approval = ArfApproval::where('arf_id', $request->arf_id)->first();
        $jrf          = Jrf::where('id', $request->jrf_id)->first();

        // Get HOD detail for approval
        $approver = User::where(['id' => Auth::id()])->with('employee')->first();
        $arf_approval->arf_status = $request->final_status;
        
        if( $request->final_status == '1' ){
            $arf_approval->save();
        }
        
        $applier = $arf_approval->user;

        // Send message to JRF Creator when JRF Request approved by HOD Level One//

        $message_data = [
            'sender_id'   => $request->userId, //$jrf->user_id,
            'receiver_id' => $applier->id,
            'label'       => 'ARF Remarks',
            'message'     => $request->remark,
            'read_status' => '0',
        ];

        $arf_approval->messages()->create($message_data);
        
        //check if arf_status is approved then update the status of isactive from recruitment Table //

        $update_approval_status = ['isactive' => '1'];
        $get_recruitment        = JrfRecruitmentTasks::where('jrf_id', $request->jrf_id)->first();
      
        if (!empty($get_recruitment)) {
            $result = JrfRecruitmentTasks::find($get_recruitment->id);
           // dd($result);    

            if (!empty($result)) {
                $result->update($update_approval_status);
            }

            if (!empty($result)) {
                //////////////////////////Notify///////////////////////////
                $notification_data = [
                    'sender_id'   => $request->userId,
                    'receiver_id' => $jrf->user_id,
                    'label'       => 'ARF Approved',
                    'read_status' => '0',
                ];

                $notification_data['message'] = "ARF Approved " . $approver->employee->fullname;
                $arf_approval->notifications()->create($notification_data);

                //////////////////////////Mail///////////////////////////
                $reporting_manager     = Employee::where(['user_id' => $jrf->user_id])->with('user')->first();
                $mail_data['to_email'] = $reporting_manager->user->email;
                $mail_data['subject']  = "ARF Approved";
                $mail_data['message']  = $approver->employee->fullname . " ARF Approved. Please take an action. Here is the link for website <a href='" . url('/') . "'>Click here</a>";
                $mail_data['fullname'] = $reporting_manager->fullname;
               // $this->sendGeneralMail($mail_data);
            }

            ////////////////////////////END///////////////////////////////

        } // end of recruitment Table

        // Get Next level Approver id (2 levels of approval  first is HOD Level and second is MD Sir)

        $next_approver = JrfHierarchy::where('isactive', 1)->where('type', 'approval')->orderBy('id', 'ASC')->first();   

        if (empty($next_approver)) {
            $manager_id = 0;
        } else {
           // $manager_id = $next_approver->user_id; //
            $manager_id = 13;
            $user_data  = User::where('id', $manager_id)->first();
        }

        $next_approver_present = JrfApprovals::where(['jrf_id' => $arf_approval->jrf_id, 'supervisor_id' => $manager_id])->first();

        if (!empty($next_approver) && $request->final_status == '1' && empty($next_approver_present)) {
            //Approved on previous level

            $next_approval_data = [
                'user_id'       => $arf_approval->user_id,
                'supervisor_id' => $manager_id,
                'priority'      => 4,
                'jrf_status'    => '0',
            ];

            $notification_data = [
                'sender_id'   => $arf_approval->user_id,
                'receiver_id' => $manager_id,
                'label'       => 'JRF Application',
                'message'     => $approver->employee->fullname . " sent request for JRF approval.",
                'read_status' => '0',
            ];

            if ($next_approval_data['priority'] == '4') {
                // MD
                $jrf_approval_insert_id = $jrf->jrfapprovals()->create($next_approval_data);
                $jrf->notifications()->create($notification_data);
            }

            //Send Mail && SMS to the next approver
            if (!empty($jrf_approval_insert_id)) {
                $mail_data['subject']  = 'JRF Application';
                $mail_data['to_email'] = $approver->email;
                $mail_data['message']  = $approver->employee->fullname . "sent request for JRF approval. Please take an action. Here is the link for website <a href='" . url('/') . "'Click here</a>";
                //$mail_data['fullname'] = $next_approver->manager->employee->fullname;
                $mail_data['fullname'] = "Sir";
                //$this->sendJrfGeneralMail($mail_data);
            }

        } elseif ($request->final_status != '1') {

                $user_detail = User::where(['id' => Auth::id()])
                ->with('employee') // get Recruiters HOD detail for approval
                ->first();

                $get_jrf_approvded_status = ArfApproval::where(['jrf_id' => $request->jrf_id,'supervisor_id' => $request->userId,])->first();

                $update_approval_status = ['arf_status' => '2'];

                $result = ArfApproval::updateOrCreate(['supervisor_id' => $request->userId, 'jrf_id' => $request->jrf_id], $update_approval_status);

                $update_status = ['jrf_status' => '0'];
                
                $result = JrfApprovals::updateOrCreate(['supervisor_id' => 13,'jrf_id' => $request->jrf_id,'user_id' => $request->u_id,'priority' => 4,],$update_status);

                if (!empty($result)) {
                    //When JRF Rejected By MD sir Send Notification to Creator of JRF //
                    $notification_data = [
                        'sender_id'   => $get_jrf_approvded_status->supervisor_id,
                        'receiver_id' => $get_jrf_approvded_status->user_id,
                        'label'       => 'ARF Rejected',
                        'read_status' => '0',
                    ];

                    $notification_data['message'] = "ARF Rejected by " . $user_detail->employee->fullname;
                    $jrf->notifications()->create($notification_data);

                    return redirect()->back()->with('success', 'ARF Rejected successfully');


                }


        }

        $mail_data['to_email'] = $applier->email;
        $mail_data['fullname'] = $applier->employee->fullname;
        if ($arf_approval->final_status == '1') {

            $mail_data['subject'] = "JRF Approved";
            $mail_data['message'] = "Your JRF has been approved. Check status on the <a href='" . url('/') . "'>website</a>.";
            $this->sendGeneralMail($mail_data);

        } elseif ($arf_approval->leave_status == '2') {
            $mail_data['subject'] = "JRF Rejected";
            $mail_data['message'] = "Your JRF has been rejected. Check status on the <a href='" . url('/') . "'>website</a>.";
            $this->sendGeneralMail($mail_data);
        }
        return redirect("jrf/approve-arf");
    }

    public function candidateLevelOneScreeningDetail($level_one_id)
    {

        $detail['basic'] = DB::table('jrf_level_one_screenings as jlos')
            ->leftjoin('final_appointment_approvals as faa','jlos.id','=','faa.jrf_level_one_screening_id')
            ->leftjoin('jrfs as jrf', 'jlos.jrf_id', 'jrf.id')
            ->leftjoin('jrf_interviewer_details as jid', 'jlos.id', 'jid.jrf_level_one_screening_id')
            ->leftjoin('jrf_level_two_screenings as jlts','jlos.id','jlts.jrf_level_one_screening_id')
            ->leftjoin('employees as emp', 'jid.assigned_by', 'emp.user_id')
            ->leftjoin('employees as emp2', 'jid.user_id', 'emp2.user_id')
            ->join('cities as city', 'jlos.city_id', 'city.id')
            ->where('jlos.id', $level_one_id)
            ->select('jlos.*', 'emp.fullname as assigned_by', 'emp2.fullname', 'city.name as city_name','jlts.*','faa.*')
            ->first();


        $skills = DB::table("jrf_level_one_screening_skill as jloss")
            ->join('skills as s', 'jloss.skill_id', '=', 's.id')
            ->where('jloss.jrf_level_one_screening_id', $level_one_id)
            ->pluck('s.name')->toArray();
        $detail['skills'] = implode(' , ', $skills);

        $qualification = DB::table("jrf_level_one_screening_qualification as jlosq")
            ->join('qualifications as q', 'jlosq.qualification_id', '=', 'q.id')
            ->where('jlosq.jrf_level_one_screening_id', $level_one_id)
            ->pluck('q.name')->toArray();
        $detail['qualification'] = implode(' , ', $qualification);

        $language_detail = DB::table('jrf_level_one_screening_language as jlosl')
            ->join('languages as lan', 'jlosl.language_id', '=', 'lan.id')
            ->where('jlosl.jrf_level_one_screening_id', $level_one_id)
            ->select('jlosl.language_id', 'lan.name', 'jlosl.read_language', 'jlosl.write_language', 'jlosl.speak_language')->get();
        $detail['languages'] = $language_detail;

        // Candidate Appointment Details

        /* $detail['basic'] = DB::table('final_appointment_approvals as faa')
            ->join('jrf_level_one_screenings as jlos','jlos.id','faa.jrf_level_one_screening_id')
            ->join('employees as emp', 'jid.assigned_by', 'emp.user_id')
            ->where('faa.jrf_level_one_screening_id', $level_one_id)
            ->select('faa.*', 'emp.fullname as assigned_by','jlos.name as emp_name')
            ->first();  */


        return view("jrf.candidate_level_one_detail")->with(['detail' => $detail]);
    }

    public function editCandidateLevelOneScreeningDetail($level_one_id)
    {

        $data['cities']         = City::where(['isactive' => 1])->orderBy('name')->get();
        $data['skills']         = Skill::where(['isactive' => 1])->orderBy('name')->select('id', 'name')->get();
        $data['qualifications'] = Qualification::where(['isactive' => 1])->orderBy('name')->select('id', 'name')->get();
        $data['languages']      = Language::where(['isactive' => 1])->orderBy('name')->select('id', 'name')->get();
        $data['departments']    = Department::where(['isactive' => 1])->orderBy('name')->get();
        $data['basic']          = DB::table('jrf_level_one_screenings as jlos')
            ->leftjoin('jrfs as jrf', 'jlos.jrf_id', 'jrf.id')
            ->leftjoin('jrf_interviewer_details as jid', 'jlos.id', 'jid.jrf_level_one_screening_id')
            ->leftjoin('employees as emp', 'jid.assigned_by', 'emp.user_id')
            ->leftjoin('employees as emp2', 'jid.user_id', 'emp2.user_id')
            ->join('cities as city', 'jlos.city_id', 'city.id')
            ->where('jlos.id', $level_one_id)
            ->select('jlos.*', 'emp.fullname as assigned_by', 'emp2.fullname', 'city.name as city_name', 'jid.department_id', 'jid.user_id as interviewer_id')
            ->first();

        $skills               = JrfLevelOneScreeningSkill::where('jrf_level_one_screening_id', $level_one_id)->pluck('skill_id')->toArray();
        $data['saved_skills'] = $skills;

        $qualification               = JrfLevelOneScreeningQualification::where('jrf_level_one_screening_id', $level_one_id)->pluck('qualification_id')->toArray();
        $data['saved_qualification'] = $qualification;

        $language               = JrfLevelOneScreeningLanguage::where('jrf_level_one_screening_id', $level_one_id)->pluck('language_id')->toArray();
        $data['saved_location'] = $language;

        $selectedLanguageCheckboxes = DB::table('jrf_level_one_screening_language as jlosl')
            ->where('jlosl.jrf_level_one_screening_id', $level_one_id)
            ->select('language_id', 'read_language', 'write_language', 'speak_language')
            ->get()->toArray();
        $data['languageCheckboxes'] = $selectedLanguageCheckboxes;

        $data['last_date_recruitment'] = JrfRecruitmentTasks::where('jrf_id', $data['basic']->jrf_id)->where('user_id', Auth::id())->orderBy('id', 'DESC')->value('last_date');

        if (!empty($data['last_date_recruitment'])) {
            $find_date = DateTime::createFromFormat('Y-m-d', $data['last_date_recruitment']);
            if (!empty($find_date)) {
                $data['last_date'] = $find_date->format('d/m/Y');
            }
        }
        return view("jrf.edit_level_one_screening")->with(['data' => $data]);
    }

    // Level Two Screenig Detail

    public function levelTwoScreening($candidate_id)
    {

        $detail['basic'] = DB::table('jrf_level_one_screenings as jlos')
                ->leftjoin('jrfs as jrf','jlos.jrf_id','jrf.id')
                ->leftjoin('jrf_interviewer_details as jid', 'jlos.id', 'jid.jrf_level_one_screening_id')
                ->where('jlos.id',$candidate_id)
                ->select('jlos.id as jrf_level_one_screening_id','jlos.interview_date','jlos.name','jlos.current_cih','jlos.current_ctc','jlos.exp_ctc','jrf.id as jrf_id','jlos.user_id')
                ->first();

        //dd($detail['basic']);        

        $detail['hod']  = User::where(['id'=>Auth::id()])
                        ->with('employee')
                        ->with('employeeProfile')
                        ->with('roles:id,name')
                        ->with('employeeAddresses')
                        ->first();

        $detail['level_two'] = JrfLevelTwoScreening::where('jrf_level_one_screening_id',$candidate_id)->first();
        return view("jrf.level_two_screening")->with(['detail'=>$detail]);
    }


    // Candidate Level Two Screening

    public function saveCandidateLevelTwoScreeningDetail(Request $request){

            if (Auth::guest()) {
                return redirect('/');
            }


            $jrf  = Jrf::where('id', $request->jrf_id)->first();
            $user = User::where(['id'=>Auth::id()])->with('employee')->first();
            $appointment_assign = User::where(['id'=>Auth::id()])->with('employee')->first();
            if($request->qualify == 'Yes'){
                $get_mobile_user_data = User::where(['id' => 13])
                    ->with('employee')
                    ->first();
            }else{
                $get_mobile_user_data = User::where(['id' => $jrf->appointment_assign])
                    ->with('employee')
                    ->first();
            }


            $job_role = DB::table('roles')
                ->where(['id' => $jrf->role_id])
                ->select('name')
                ->first();

            $department = DB::table('departments')
                ->where(['id' => $jrf->department_id])
                ->select('name')
                ->first();

            $validator = Validator::make($request->all(), [
                'video_recording_seen'    => 'bail|required',
                'rating'                  => 'bail|required',
                'interview_remarks'       => 'bail|required',
                'qualify'                 => 'bail|required',
                'final_result'            => 'bail|required'
            ]);

            if($validator->fails()) {
                return redirect("jrf/level-two-screening/".$request->jrf_level_one_screening_id)
                    ->withErrors($validator, 'basic')
                    ->withInput();
            }

            $data = [
                'jrf_id'                      => $request->jrf_id,
                'user_id'                     => $request->user_id,
                'jrf_level_one_screening_id'  => $request->jrf_level_one_screening_id,
                'department_id'               => $request->department_id,
                'designation_id'              => $request->designation_id,
                'video_recording_seen'        => $request->video_recording_seen, //is user id
                'rating'                      => $request->rating,
                'interview_remarks'           => $request->interview_remarks,
                'final_result'                => $request->final_result
            ];


            if(!empty($request->qualify) && $request->qualify == "Yes") {
                $data['qualify'] = $request->qualify;
                $data['interaction_date'] = $request->interaction_date;
                $data['level'] = $request->level;
            } else {
                $data['qualify'] = $request->qualify;
                $data['interaction_date'] = "";
                $data['level'] = "";
            }

            if(!empty($request->rating)){
                $data['rating'] = $request->rating;
            }else{
                $data['rating'] = $request->rating;
            }
            
            $level_two  = JrfLevelOneScreening::where('id',$request->jrf_level_one_screening_id)->first();


            if(!empty($request->level_two_id)) {
                $saved_level_one_detail = jrfLevelTwoScreening::updateOrCreate(['id' =>$request->level_two_id], $data);
            }else{
                
                if(!empty($request->qualify) && $request->qualify == "Yes" ) {

                    ManagementApprovals::updateOrCreate(['jrf_level_two_screening_id' =>$request->level_two_id,'jrf_id' =>$request->jrf_id,'user_id' =>$request->u_id,'jrf_level_one_screening_id' =>$request->jrf_level_one_screening_id,'supervisor_id' =>13,]);

                   JrfLevelOneScreening::where(['id' => $request->jrf_level_one_screening_id])->update(['mgmt_status_id' => '0']);


                    $notification_data = [
                        'sender_id'   => $request->user_id,
                        'receiver_id' => 13,
                        'label'       => 'Candidate Approval',
                        'read_status' => '0',
                    ]; //Working

                    $notification_data['message'] = $user->employee->fullname . " sends Candidate Approvals";

                   $saved_level_two_detail  = $level_two->notifications()->create($notification_data);

                   $notificationMessage = $user->employee->fullname." Sent Request For Candidate Interview With Management For The Position of ".$job_role->name." From ".$department->name. " Department";


                    //////////////////////////Mail///////////////////////////
                    $reporting_manager = Employee::where(['user_id'=>$level_two->user_id])->with('user')->first();
                    $mail_data['to_email'] = $reporting_manager->user->email;
                    $mail_data['subject']  = "Interview Remarks";
                    $mail_data['message']  = $user->employee->fullname . " Sends the Candidate Approval. Here is the link for website <a href='" . url('/') . "'>Click here</a>";
                    
                    $mail_data['fullname'] = $reporting_manager->fullname;

                    sms($get_mobile_user_data->employee->mobile_number,$notificationMessage);
                    
                    //$this->sendJrfGeneralMail($mail_data); //working

                }

                $saved_level_two_detail = $level_two->jrfLevelTwoScreening()->create($data);           
            }

          /*  $reporting_manager = JrfLevelOneScreening::where(['id' => $request->jrf_level_one_screening_id])->update(['lvl_sec_id' => '1']);  

            if($request->final_result == 'Selected'){

                Jrf:: where('id',$request->jrf_id)-> increment('lvl_one_screen');

            } */

            //////////////////////////Notify///////////////////////////

            if(empty($request->level_two_id)){

                $notification_data = [
                    'sender_id'   => $user->id,
                    'receiver_id' => $level_two->user_id,
                    'label'       => 'Interview Remarks',
                    'read_status' => '0',
                ]; //Working

                $notification_data['message'] = $user->employee->fullname . "interview remark has been added";

                $saved_level_two_detail  = $level_two->notifications()->create($notification_data);

                $notificationMessage = $user->employee->fullname." Sent Request For Start Candidate Appointment For The Position of ".$job_role->name." From ".$department->name. " Department and Candidate Name Is ".$request->name;

                //////////////////////////Mail///////////////////////////
                $reporting_manager = Employee::where(['user_id'=>$level_two->user_id])->with('user')->first();
                $mail_data['to_email'] = $reporting_manager->user->email;
                $mail_data['subject']  = "Interview Remarks";
                $mail_data['message']  = $user->employee->fullname . " interview remark has been added. Please check interview status. Here is the link for website <a href='" . url('/') . "'>Click here</a>";
                $mail_data['fullname'] = $reporting_manager->fullname;
                sms($get_mobile_user_data->employee->mobile_number,$notificationMessage);

                //$this->sendJrfGeneralMail($mail_data); //working
            }
             //////////////////////////End///////////////////////////

             ////////////Notify Recruitment /////////////////

            //dd($request->jrf_id);die;
            $jrf = Jrf::where('id', $data['jrf_id'])->first();

            $recuitment_tasks = JrfRecruitmentTasks::where('jrf_id',$request->jrf_id)->first();

            $recuitment_update = [
               'final_appointment_assigned_status' => '1'
            ];

            $update_recuitment_tasks = DB::table('jrf_recruitment_tasks')->where('id',$request->jrf_id)->update($recuitment_update);

            //if(empty($request->level_two_id)){

                $notification_data = [
                    'sender_id'   => $jrf->user_id,
                    'receiver_id' => $recuitment_tasks->user_id,
                    'label'       => 'Final Appointment Approval',
                    'read_status' => '0',
                ]; //Working

                $notification_data['message'] = $user->employee->fullname . " send JRF Final Appointment Approval Request";
                $saved_level_two_detail  = $level_two->notifications()->create($notification_data);

                //////////////////////////Mail///////////////////////////
                $reporting_manager = Employee::where(['user_id'=>$recuitment_tasks->user_id])->with('user')->first();
                $mail_data['to_email'] = $reporting_manager->user->email;
                $mail_data['subject']  = "Final Appointment Approval";
                $mail_data['message']  = $user->employee->fullname . " send JRF Final Appointment Approval Request. Here is the link for website <a href='" . url('/') . "'>Click here</a>";
                $mail_data['fullname'] = $reporting_manager->fullname;
                //$this->sendJrfGeneralMail($mail_data); //working
            
            //}
            
            /////////////////////////End///////////////////////////

            if (!empty($request->level_two_id)) {
            return redirect("jrf/level-two-screening/".$request->jrf_level_one_screening_id)->with('success', 'Level Two screening detail has been updated successfully');
            } else {

                //return redirect("jrf/interview-list");

               return redirect()->back()->with('success', 'Level Two screening detail has been saved successfully');
            }
    }

        public function finalAppointmentApproval($jrf_id){

            $data['basic'] = DB::table('jrfs as jrf')
                ->join('jrf_level_one_screenings as jlos','jrf.id','jlos.jrf_id')
                ->join('jrf_level_two_screenings as jlts','jrf.id','jlts.jrf_id')
                ->where('jlos.id',$jrf_id)
                ->select('jrf.id','jlos.current_ctc','jlos.current_cih','jlos.joining_date','jlos.name as c_name','jlos.current_designation as c_designation','jlos.id as jlosid','jlos.appoint_id as appoint_id','jlts.user_id as uid')
                ->first();

            $data['probation_period']  = DB::table('probation_periods')->where(['isactive' => 1])->select('id', 'no_of_days')->get();

           // dd($data['basic']);   

            $data['recruiter']  = User::where(['id'=>Auth::id()])
                ->with('employee')
                ->with('employeeProfile')
                ->with('roles:id,name')
                ->with('employeeAddresses')
                ->first();

            return view('jrf.final_appointment_approval')->with(['data'=>$data]);
        }

        public function saveFinalAppointmentApproval(Request $request){

            if (Auth::guest()) {
                return redirect('/');
            }

            $validator = Validator::make($request->all(), [
                'user_id'                       => 'bail|required',
                'jrf_id'                        => 'bail|required',
                'incentives'                    => 'required',
                'offer_letter'                  => 'required',
                'id_card'                       => 'required',
                'esi_gpa_ghi'                   => 'required',
                'epf'                           => 'bail|required',
                'erp_login'                     => 'required',
                'addition_in_company_group'     => 'bail|required',
                'security'                      => 'required',
                'security_cheque_number'        => 'required',
                'leave_module'                  => 'required',
                'sim_card'                      => 'required',
                'laptop_or_pc'                  => 'bail|required',
                'mail_id'                       => 'bail|required',
                'visiting_card'                 => 'bail|required',
                'uniform'                       => 'bail|required',
                'ctc'                           => 'required',
                'cih'                           => 'required'

            ]);

            $data = [
                'user_id'                   => $request->user_id,
                'jrf_id'                    => $request->jrf_id,
                'incentives'                => $request->incentives,
                'offer_letter'              => $request->offer_letter,
                'id_card'                   => $request->id_card,
                'esi_gpa_ghi'               => $request->esi_gpa_ghi,
                'epf'                       => $request->epf,
                'erp_login'                 => $request->erp_login,
                'addition_in_company_group' => $request->addition_in_company_group,
                'training_period'           => $request->training_period,
                'security'                  => $request->security,
                'security_cheque_number'    => $request->security_cheque_number,
                'leave_module'              => $request->leave_module,
                'sim_card'                  => $request->sim_card, 
                'laptop_or_pc'              => $request->laptop_or_pc, 
                'mail_id'                   => $request->mail_id, 
                'designation_id'            => $request->designation_id, 
                'department_id'             => $request->department_id,
                'visiting_card'             => $request->visiting_card, 
                'uniform'                   => $request->uniform,
                'appointed_status'          => $request->appointed_status,
                'jrf_level_one_screening_id' => $request->jrf_level_one_screening_id,
                'ctc'                       => $request->ctc,
                'cih'                       => $request->cih
            ];

            if(!empty($request->security_amount)){
                $data['security_amount'] = $request->security_amount;
            }else{
                $data['security_amount'] = "";
            }
            
            if(!empty($request->security_cheque)){
                $data['security_cheque'] = $request->security_cheque;
            }else{
                $data['security_cheque'] = "";
            }
            
            if(!empty($request->probation_period)){
                $data['probation_period'] = $request->probation_period;
            }else{
                $data['probation_period'] = "";
            } 

            if(!empty($request->training_period)){
                $data['training_period'] = $request->training_period;
            }else{
                $data['training_period'] = "";
            }

            $user   = User::where(['id' => Auth::id()])->with('employee')->first();
            $jrf    = Jrf::where('id', $data['jrf_id'])->first();

            $final_appointment_approval  = JrfLevelOneScreening::where('id',$request->jrf_level_one_screening_id)->first();

            $final_appointment_approvalA  = JrfLevelTwoScreening::where('user_id',$request->uid)->first();

            $saved_level_two_detail = $final_appointment_approval->finalAppointmentApproval()->create($data);
            
            $reporting_manager = JrfLevelOneScreening::where(['id' => $request->jrf_level_one_screening_id])->update(['appoint_id' => '1']);

            //////////////////////////Notify///////////////////////////

                $notification_data = [
                    'sender_id'   => $final_appointment_approval->user_id,
                    'receiver_id' => $jrf->user_id,
                    'label'       => 'Final Appointment Approval',
                    'read_status' => '0',
                ];

                $notification_data['message'] = $user->employee->fullname . " send JRF Final Appointment Approval Request";
                $saved_level_two_detail  = $final_appointment_approval->notifications()->create($notification_data);

                ////////////////////////// Mail ///////////////////////////

                $reporting_manager = Employee::where(['user_id'=>$final_appointment_approval->user_id])->with('user')->first();
                $mail_data['to_email'] = $reporting_manager->user->email;
                $mail_data['subject']  = "Final Appointment Approval";
                $mail_data['message']  = $user->employee->fullname . " send JRF Final Appointment Approval Request. Here is the link for website <a href='" . url('/') . "'>Click here</a>";
                $mail_data['fullname'] = $reporting_manager->fullname;
                //$this->sendJrfGeneralMail($mail_data); //working  
            
             $result = CandidateApprovals::updateOrCreate(['supervisor_id' => $request->uid, 'jrf_id' => $request->jrf_id,'user_id' => $request->user_id,'jrf_level_one_screening_id' => $request->jrf_level_one_screening_id,]);

            //////////////////////////Notify///////////////////////////

                $notification_data = [
                    'sender_id'   => $final_appointment_approval->user_id,
                    'receiver_id' => $request->uid,
                    'label'       => 'Candidate Appointment Approval',
                    'read_status' => '0',
                ];

                $notification_data['message'] = $user->employee->fullname . " send Candidate Appointment Approval Request";
                $saved_level_two_detail  = $final_appointment_approval->notifications()->create($notification_data);

                ////////////////////////// Mail ///////////////////////////

                $reporting_manager = Employee::where(['user_id'=>$final_appointment_approvalA->user_id])->with('user')->first();

                $mail_data['to_email'] = $reporting_manager->user->email;
                $mail_data['subject']  = "Candidate Appointment Approval";
                $mail_data['message']  = $user->employee->fullname . " send Candidate  Appointment Approval Request. Here is the link for website <a href='" . url('/') . "'>Click here</a>";
                $mail_data['fullname'] = $reporting_manager->fullname;
                //$this->sendJrfGeneralMail($mail_data); //working

            /////////////////////////End///////////////////////////
            
            return redirect("jrf/appointment-approval")->with('success', 'Final Appointment Approval detail has been added successfully.');

           // return redirect()->back()->with('success', "Final Appointment Approval detail has been added successfully.");
        }

    /*  List For Final Approval Appointment  */

    public function listAppointmentApproval()
    {

        if (Auth::guest()) {
            return redirect('/');
        }

        $user = User::where(['id' => Auth::id()])->first();

        $jrfs_approval = DB::table('final_appointment_approvals as fnl_app')
            ->join('jrf_recruitment_tasks as jrt','fnl_app.jrf_id','jrt.jrf_id')
            ->join('jrf_level_one_screenings as jrf_lvl','fnl_app.jrf_level_one_screening_id','=','jrf_lvl.id')
            ->join('jrfs as jrf','jrf_lvl.jrf_id','=','jrf.id')
            ->join('departments as dep','jrf.department_id','=','dep.id')
            ->join('designations as des','jrf.designation_id','=','des.id')
            ->where('fnl_app.user_id', $user->id)
            ->select('fnl_app.*', 'dep.name as department','jrf_lvl.name as cand_name','jrf_lvl.current_ctc as current_ctc','jrt.final_appointment_assigned_status as final_ap_sts','jrf.jrf_no','des.name as designation')
            ->orderBy('fnl_app.id', 'DESC')
            ->get();    

        return view('jrf.list_appointment_approval')->with(['jrfs_approval' => $jrfs_approval]);     
    }

    // View Appointment Approval

    public function viewAppointmentApproval($id)
    {

        if (Auth::guest()) {
            return redirect('/');
        }

        $user    = User::where(['id' => Auth::id()])->first();

        $detail['basic'] = DB::table('final_appointment_approvals as fnl_app')
            ->join('departments as dep','fnl_app.department_id','=','dep.id')
            ->join('designations as des','fnl_app.designation_id','=','des.id')
            ->where('fnl_app.id', $id)
            ->select('fnl_app.*', 'dep.name as department','des.name as designation')
            ->first(); 
                                                     
        $detail['recruiter']  = User::where(['id'=>Auth::id()])
                ->with('employee')
                ->first();
        return view('jrf.view_appointment_approval')->with(['detail' => $detail]);
    } 

    // Edit Listing Appointment Form

    public function editAppointmentApproval($id)
    {

        if (Auth::guest()) {
            return redirect('/');
        }

        $user                   = User::where(['id' => Auth::id()])->first();
        $data['departments']    = Department::where(['isactive' => 1])->get();
        $designation            = Jrf::where('id', $id)->pluck('designation_id')->toArray();
        $data['saved_designation'] = $designation;
        $data['detail']            = FinalAppointmentApproval::where('id', $id)->first();

         $data['probation_period']  = DB::table('probation_periods')->where(['isactive' => 1])->select('id', 'no_of_days')->get();

        $probation_period               = FinalAppointmentApproval::where('id', $id)->pluck('probation_period')->toArray();
        $data['save_probation_period'] = $probation_period;

        $data['basic'] = DB::table('final_appointment_approvals as jrf')
            ->join('jrf_level_one_screenings as jlos','jrf.jrf_level_one_screening_id','=','jlos.id')
            ->where('jrf.id',$id)
            ->select('jrf.jrf_level_one_screening_id','jlos.current_ctc','jlos.current_cih','jlos.joining_date','jlos.name','jlos.current_designation')
            ->first();

        $data['recruiter']  = User::where(['id'=>Auth::id()])
            ->with('employee')
            ->with('employeeProfile')
            ->with('roles:id,name')
            ->with('employeeAddresses')
            ->first();
                   
        return view('jrf.edit_appointment_approval')->with(['data' => $data]);
    }


    // Update Appointment Form

    public function updateAppointmentApproval(Request $request)
    {

        if (Auth::guest()) {
            return redirect('/');
        }
            $validator = Validator::make($request->all(), [
                'user_id'                       => 'bail|required',
                'jrf_id'                        => 'bail|required',
                'incentives'                    => 'required',
                'offer_letter'                  => 'required',
                'id_card'                       => 'required',
                'esi_gpa_ghi'                   => 'required',
                'epf'                           => 'bail|required',
                'erp_login'                     => 'required',
                'addition_in_company_group'     => 'bail|required',
                'security'                      => 'required',
                'security_cheque_number'        => 'required',
                'leave_module'                  => 'required',
                'sim_card'                      => 'required',
                'laptop_or_pc'                  => 'bail|required',
                'mail_id'                       => 'bail|required',
                'visiting_card'                 => 'bail|required',
                'uniform'                       => 'bail|required',
                'ctc'                           => 'required',
                'cih'                           => 'required'

            ]);

            $data = [
                'user_id'                   => $request->user_id,
                'jrf_id'                    => $request->jrf_id,
                'incentives'                => $request->incentives,
                'offer_letter'              => $request->offer_letter,
                'id_card'                   => $request->id_card,
                'esi_gpa_ghi'               => $request->esi_gpa_ghi,
                'epf'                       => $request->epf,
                'erp_login'                 => $request->erp_login,
                'addition_in_company_group' => $request->addition_in_company_group,
                'training_period'           => $request->training_period,
                'security'                  => $request->security,
                'security_cheque_number'    => $request->security_cheque_number,
                'leave_module'              => $request->leave_module,
                'sim_card'                  => $request->sim_card, 
                'laptop_or_pc'              => $request->laptop_or_pc, 
                'mail_id'                   => $request->mail_id, 
                'designation_id'            => $request->designation_id_new, 
                'department_id'             => $request->department_id_new,
                'visiting_card'             => $request->visiting_card, 
                'uniform'                   => $request->uniform,
                'jrf_level_one_screening_id' => $request->jrf_level_one_screening_id,
                'ctc'                       => $request->ctc,
                'cih'                       => $request->cih,
                'probation_period'          => $request->probation_period
            ];

            if($request->security == 'No'){
                $data['security_amount'] = ""; 
            }

            if($request->security_cheque == 'No'){
                $data['security_cheque_number'] = ""; 
                $data['bank_name'] = "";
            }

            if(!empty($request->training_period)){
                $data['training_period'] = $request->training_period;
            }else{
                $data['training_period'] = "";
            }
        
            $update_jrf = FinalAppointmentApproval::where('id', $request->h_id)->update($data);
        
            return redirect()->back()->with('success', "Final Appointment Approval detail has been Updated Successfully.");

    }

    /* Closure listing   */

    public function createClosure(Request $request)
    {

        if (Auth::guest()) {
            return redirect('/');
        }

        $condition = array();
        $user = User::where(['id' => Auth::id()])->first();

        if(!empty($request->project_id)){
            $condition[] = array('jols.project_id', '=', $request->project_id);
        }

        if(!empty($request->designation_id)){
            $condition[] = array('jols.designation_id', '=', $request->designation_id);
        }


        $jrfs_approval = DB::table('final_appointment_approvals as fnl_app')
            ->join('jrf_level_one_screenings as jlvl','fnl_app.jrf_level_one_screening_id','=','jlvl.id')
            ->join('jrfs as jols','fnl_app.jrf_id','=','jols.id' )
            ->join('employees as emp', 'fnl_app.user_id', '=', 'emp.user_id')
            ->join('designations as des', 'jols.designation_id', '=','des.id')
            ->join('departments as dep','jols.department_id','=','dep.id')
            ->join('projects as proj','jols.project_id','=','proj.id')
            ->where($condition)
            ->where('fnl_app.user_id', $user->id)
            ->where('fnl_app.joining_status','1')
            ->select('fnl_app.*','des.name as designation','dep.name as department','emp.fullname','jlvl.closed_id','jols.number_of_positions','jols.jrf_no','proj.name as proj_name','jlvl.name','jols.closure_type')
            ->orderBy('fnl_app.jrf_level_one_screening_id', 'DESC')
            ->groupBy('jrf_level_one_screening_id')
            ->get();

            
            $projects = Project::where(['isactive'=>1])->get();
            $designations = Designation::where(['isactive'=>1])->select('id','name')->get();
    
         return view('jrf.list_closure')->with(['jrfs_approval' => $jrfs_approval,'designations'=>$designations,'projects'=>$projects,'req'=>$request]);
        
    }

    /*   Closure Form     */

    public function finalClosure($jrf_id){

        $data['basic'] = DB::table('jrf_level_one_screenings as fnl_app')
            ->join('final_appointment_approvals as jlt','fnl_app.id','=','jlt.jrf_level_one_screening_id')
            ->join('jrfs as jols','fnl_app.jrf_id','=','jols.id' )
            ->join('employees as emp', 'jols.user_id', '=', 'emp.user_id')
            ->join('designations as des', 'jols.designation_id', '=','des.id')
            ->join('departments as dep','jols.department_id','=','dep.id')
            ->join('city_jrf as city','jols.id','=','city.jrf_id')
            ->join('cities as loc','city.jrf_id','=','loc.id')
            ->where('fnl_app.id',$jrf_id)
            ->select('fnl_app.*','des.name as designation','dep.name as department','emp.fullname','jols.jrf_no','jols.closed_jrf','jols.number_of_positions as nops','jlt.joining_date','city.city_id','loc.name as city_name')
            ->first();
       // dd($data['basic']);  

        $data['recruiter']  = User::where(['id'=>Auth::id()])
            ->with('employee')
            ->first();

        $data['departments']    = Department::where(['isactive' => 1])->get();
        $data['cities']         = City::where(['isactive' => 1])->get();
        $data['designation']    = Designation::where(['isactive' => 1])->select('id', 'name')->get();

        return view('jrf.final_closure')->with(['data'=>$data]);
    }

    // Save Closure

    public function saveClosour(Request $request){

        if (Auth::guest()) {
            return redirect('/');
        }

        $validator = Validator::make($request->all(), [
            'user_id'                   => 'bail|required',
            'jrf_id'                    => 'bail|required',
            'closour_date'              => 'bail|required',
            'quick_learner'             => 'bail|required',
            'confid_lvl'                => 'bail|required',
            'attitude'                  => 'bail|required',
            'team_work'                 => 'bail|required',
            'exec_skill'                => 'bail|required',
            'result_orient'             => 'bail|required',
            'attendence'                => 'bail|required',

        ]);

        //$closour_date_ch = date('Y-m-d', strtotime($request->closour_date)); 

        $data = [
            'user_id'                   => $request->user_Id,
            'superwisor_id'             => $request->superwisor_id,
            'jrf_level_one_screening_id' => $request->level1_screen_id,  
            'jrf_id'                    => $request->jrf_id,
            'designation_id'            => $request->designation_id,
            'department_id'             => $request->department_id,
            'location_id'               => $request->city_id,
            'report_id'                 => $request->approver_id,        
            'quick_learner'             => $request->quick_learner,
            'confid_lvl'                => $request->confid_lvl,
            'attitude'                  => $request->attitude,
            'team_work'                 => $request->team_work,
            'exec_skill'                => $request->exec_skill,
            'result_orient'             => $request->result_orient,

        ];

        if ($request->hasFile('joining_letter')) {
            $imageA = time() . '.' . $request->file('joining_letter')->getClientOriginalExtension();
            $request->file('joining_letter')->move(config('constants.uploadPaths.uploadJoiningDocument'), $imageA);
            $joining_letter = $imageA;

        }

        $saved_level_one_detail = Closour::updateOrCreate($data); 

        $reporting_manager = JrfLevelOneScreening::where(['id' => $request->level1_screen_id])->update(['closed_id' => '1','joining_letter' =>$joining_letter]);

        $hired_candidate = Jrf:: where('id',$request->jrf_id)->increment('hired_candidate');

       // if($request->closed_jrf == $request->nops){

           // $jrf_closed = Jrf::where(['id' => $request->jrf_id])->update(['closure_type' => 'closed','closure_date' => $closour_date_ch]);

            // Notification Sent to Assigned Jrf By Md Sir 

            $jrf  = Jrf::where('id', $request['jrf_id'])->first();

            $user = User::where(['id' => Auth::id()])->with('employee')->first();

            $notification_data = [
                'sender_id'   => $request->superwisor_id,
                'receiver_id' => $request->user_Id,
                'label'       => 'FEDDBACK FORM',
                'read_status' => '0',
            ]; //Working

            $notification_data['message'] = $user->employee->fullname . " Sends  The Feedback of  " . $request['cand_name'] . " ";

            
            $saved_level_one_detail       = $jrf->notifications()->create($notification_data);

            //////////////////////////Mail///////////////////////////
            $reporting_manager = Employee::where(['user_id' => $request->user_Id])
                ->with('user')->first();

            $mail_data['to_email'] = $reporting_manager->user->email;
            $mail_data['subject']  = "Candidate Feedback";
            $mail_data['message']  = $user->employee->fullname . "Submitted Feedback " . $request['cand_name'] . ".<a href='" . url('/') . "'>Click here</a>";
            $mail_data['fullname'] = $reporting_manager->fullname;
            //$this->sendJrfGeneralMail($mail_data); 

            // Notification Sent to Md Sir 

            $notification_data = [
                'sender_id'   => $request->superwisor_id,
                'receiver_id' => 13,
                'label'       => 'FEDDBACK FORM',
                'read_status' => '0',
            ];

            $notification_data['message'] = $user->employee->fullname . "Submitted Feedback";
            $jrf->notifications()->create($notification_data);

            //////////////////////////Mail///////////////////////////
          //  $reporting_manager     = Employee::where(['user_id' => $request->recruitment_interviewer_employee])->with('user')->first();

            $mail_data['to_email'] = "hiteshsinghal1992@gmail.com";
            $mail_data['subject']  = "Candidate Feedback";
            $mail_data['message']  = $user->employee->fullname . "Submitted  the Feedback " . $request['cand_name'] . ".<a href='" . url('/') . "'>Click here</a>";
            $mail_data['fullname'] = "Hitesh";
            $this->sendGeneralMail($mail_data);

      //  }

        return redirect("jrf/create-closure")->with('success', 'Candidate Feedback added successfully.');
        
    }


    //Appointment Approval 

    public function AppointmentApproval()
    {

      
        if (Auth::guest()) {
            return redirect('/');
        }

        $user = User::where(['id' => Auth::id()])->first(); 
        $jrfs_approval = DB::table('jrf_level_one_screenings as jrf_lvl')
                ->join('jrfs as jrf','jrf_lvl.jrf_id','=','jrf.id')
                ->join('jrf_level_two_screenings as jrf_lvl2','jrf_lvl.id','=','jrf_lvl2.jrf_level_one_screening_id')
                ->join('employees as emp','jrf_lvl2.user_id','=','emp.user_id')
                ->where(['jrf.appointment_assign' => $user->id,'final_result' => 'Selected','mgmt_status_id' => '1'])
                ->select('jrf_lvl.*','jrf.closure_type','jrf_lvl2.jrf_level_one_screening_id','jrf_lvl2.status','emp.fullname','jrf.jrf_no')
                ->orderBy('jrf_lvl.id','DESC')
                ->get();
      //  dd($jrfs_approval);        
       
       /* $jrfs_approval = DB::table('jrf_level_one_screenings as jrf_lvl')
                ->join('jrfs as jrf','jrf_lvl.jrf_id','=','jrf.id')
                ->join('jrf_level_two_screenings as jrf_lvl2','jrf_lvl.id','=','jrf_lvl2.jrf_level_one_screening_id')
                ->join('employees as emp','jrf_lvl2.user_id','=','emp.user_id')
                ->where(['jrf_lvl2.user_id' => $user->id,'final_result' => 'Selected','mgmt_status_id' => '1'])
                ->orderBy('jrf_lvl.id','DESC')
                ->get();
        */
      
        return view('jrf.appointment_approval')->with(['jrfs_approval' => $jrfs_approval]); 
    }


    function changeAppointStatus(Request $request){

        if($request->action == "deactivate"){
           $reporting_manager = JrfLevelTwoScreening::where(['jrf_level_one_screening_id' => $request->level_one_id,'jrf_id'=>$request->jrf_id ])->update(['status' => '1','reject_reason' => $request->description ]);

           // Alternate 
            
            JrfLevelOneScreening::where(['id' => $request->level_one_id,'jrf_id'=>$request->jrf_id ])->update(['status_before_appoint' => '1']);

         }

        return redirect('jrf/appointment-approval');
    }




    // Selected Candidate Listing after the qualify Second Levels
  
    public function listSelectedCandidate(Request $request)
    {


        if (Auth::guest()) {
            return redirect('/');
        }

        $condition = array();
        $user = User::where(['id' => Auth::id()])->first();

        // Filtering Data By Jrf_no, project name, designation and status   

        if(!empty($request->jrf_no)){
            $condition[] = array('jrf.jrf_no', '=', $request->jrf_no);
        }

        if(!empty($request->project_id)){
            $condition[] = array('jrf.project_id', '=', $request->project_id);
        }

        if(!empty($request->designation_id)){
            $condition[] = array('jrf.designation_id', '=', $request->designation_id);
        }


        $jrfs_approval = DB::table('jrf_appointed_approvals as fnl_app')
            ->join('jrf_level_one_screenings as jrf_lvl','fnl_app.jrf_level_one_screening_id','=','jrf_lvl.id')
            ->join('final_appointment_approvals as faap','jrf_lvl.id','=','faap.jrf_level_one_screening_id')
            ->join('jrfs as jrf','jrf_lvl.jrf_id','=','jrf.id')
            ->join('projects as proj','jrf.project_id','=','proj.id')
            ->join('employees as emp','fnl_app.user_id','=','emp.user_id')
            ->join('departments as dep','jrf.department_id','=','dep.id')
            ->join('designations as des','jrf.designation_id','=','des.id')
            ->where($condition)
            ->where('fnl_app.user_id', $user->id)
            ->where('fnl_app.supervisor_id', 13)
            ->where('fnl_app.jrf_status', '1')

            ->select('fnl_app.*', 'dep.name as department','jrf_lvl.name as cand_name','jrf.jrf_no','proj.name as proj_name','jrf_lvl.joining_date','emp.fullname','des.name as designation','faap.ctc','faap.cih','faap.joining_status','jrf.closure_type')
            ->groupBy('fnl_app.jrf_level_one_screening_id')
            ->orderBy('fnl_app.jrf_level_one_screening_id', 'DESC')
            ->get();

            $projects = Project::where(['isactive'=>1])->get();
            $designations = Designation::where(['isactive'=>1])->select('id','name')->get();
            $jrfs = Jrf::where(['isactive'=>1])->select('id','jrf_no')->get();
    
        return view('jrf.list_selected_candidate')->with(['jrfs_approval' => $jrfs_approval,'designations'=>$designations,'projects'=>$projects,'jrfs'=>$jrfs,'req'=>$request]);

    }



    // Project Wise Designation In Create Jrf

    function ProjectWiseDesignation(Request $request){

        $project_ids = $request->project_ids;
        $data = DB::table('designations as desg')
            ->whereIn('desg.project_id',$project_ids)
            ->where(['desg.isactive'=>1])
            ->select('desg.id','desg.name')
            ->get();
        
        return $data;        

    }

    // Level Ist Listing

    public function LevelfirstList(Request $request)
    {

        $condition = array();
        $user = User::where(['id' => Auth::id()])->first();
       // $condition[] = array('jrf.user_id', '=', $user->id);
        $condition[] = array('jnd.assigned_by', '=', $user->id);

        /*if( !empty( $request->date_from && $request->date_to ) ){
            $condition[] = array('jlos.created_at', '=', [$request->date_from, $request->date_to]);
        }*/

        // Filtering Data By Jrf_no, project name, designation and status

        if(!empty($request->jrf_no)){
            $condition[] = array('jrf.jrf_no', '=', $request->jrf_no);
        }

        if(!empty($request->project_id)){
            $condition[] = array('jrf.project_id', '=', $request->project_id);
        }

        if(!empty($request->designation_id)){
            $condition[] = array('jrf.designation_id', '=', $request->designation_id);
        }

        if(!empty($request->status)){
            $condition[] = array('jlos.candidate_status', '=', $request->status);
        }    

        $data = DB::table('jrf_interviewer_details as jnd')
            ->join('jrf_level_one_screenings as jlos', 'jnd.jrf_level_one_screening_id','=', 'jlos.id')
            ->join('employees as emp', 'jnd.user_id','=','emp.user_id')
            ->join('jrfs as jrf','jnd.jrf_id','=','jrf.id')
            ->join('projects  as prj','jrf.project_id','=','prj.id')
            ->where($condition)
            ->select('jlos.name','jlos.id as jrf_level_one_screening_id','jlos.interview_date','jlos.interview_time','jlos.current_designation','jlos.reason_for_job_change', 'emp.fullname','jnd.jrf_id','jlos.lvl_sec_id','jrf.jrf_no','jlos.candidate_status','jlos.created_at','prj.name as prj_name')
            ->groupBy('jlos.id')
            ->orderBy('jlos.id','DESC')
            ->get();

            $jrfs = Jrf::where(['isactive'=>1])->select('id','jrf_no')->get();
            $projects = Project::where(['isactive'=>1])->get();
            //$status = JrfLevelOneScreening::select('id','candidate_status')->get();

            return view('jrf.levelfirst_interview_list')->with(['datas' => $data,'projects'=>$projects,'jrfs'=>$jrfs,'req'=>$request]);

    }

    // Second Level Listing

    public function LevelsecondList(Request $request)
    {

        $condition = array();
        $user = User::where(['id' => Auth::id()])->first();
       // $condition[] = array('jnd.user_id', '=', $user->id);

        /*if( !empty( $request->date_from && $request->date_to ) ){
            $condition[] = array('jlos.created_at', '=', [$request->date_from, $request->date_to]);
        }*/

        if(!empty($request->jrf_no)){
            $condition[] = array('jrf.jrf_no', '=', $request->jrf_no);
        }

        if(!empty($request->project_id)){
            $condition[] = array('jrf.project_id', '=', $request->project_id);
        }

        if(!empty($request->designation_id)){
            $condition[] = array('jrf.designation_id', '=', $request->designation_id);
        }

        if(!empty($request->status)){
            $condition[] = array('jnd.final_result', '=', $request->status);
        }    

        $data = DB::table('jrf_level_two_screenings as jnd')
            ->join('jrf_level_one_screenings as jlos', 'jnd.jrf_level_one_screening_id','=', 'jlos.id')
            ->join('employees as emp', 'jnd.user_id','=','emp.user_id')
            ->join('jrfs as jrf','jnd.jrf_id','=','jrf.id')
            ->join('projects  as prj','jrf.project_id','=','prj.id')
            ->where($condition)
            ->select('jlos.name','jlos.id as jrf_level_one_screening_id', 'emp.fullname','jnd.jrf_id','jlos.lvl_sec_id','jrf.jrf_no','jnd.final_result','jlos.created_at','prj.name as prj_name')
            ->orderBy('jnd.id','DESC')
            ->get();
        
            $jrfs = Jrf::where(['isactive'=>1])->select('id','jrf_no')->get();
            $projects = Project::where(['isactive'=>1])->get();
            //$status = JrfLevelOneScreening::select('id','candidate_status')->get();

            return view('jrf.levelsecond_interview_list')->with(['datas' => $data,'projects'=>$projects,'jrfs'=>$jrfs,'req'=>$request]);

    }


    // Level Third Candidate List Approval By -- MD SIR --

        public function LevelThirdList(Request $request)
    {

        $condition = array();
        $user = User::where(['id' => Auth::id()])->first();
    
        $data = DB::table('jrf_level_two_screenings as jnd')
            ->join('jrf_level_one_screenings as jlos', 'jnd.jrf_level_one_screening_id','=', 'jlos.id')
            ->join('employees as emp', 'jnd.user_id','=','emp.user_id')
            ->join('jrfs as jrf','jnd.jrf_id','=','jrf.id')
            ->join('projects  as prj','jrf.project_id','=','prj.id')
            ->where('jnd.status','0')
            ->select('jlos.name','jlos.id as jrf_level_one_screening_id', 'emp.fullname','jnd.jrf_id','jlos.lvl_sec_id','jrf.jrf_no','jnd.final_result','jlos.created_at','prj.name as prj_name')
            ->orderBy('jnd.id','DESC')
            ->get();
            
            dd($data);
            
            return view('jrf.levelThird_candidate_list')->with(['datas' => $data]);

    }

    /*   List Appointed Candidate Approvals   */


    public function approveAppointedCandidate($jrf_status = null)
    {

        if (Auth::guest()) {
            return redirect('/');
        }

        $user = User::where(['id' => Auth::id()])->first();
            
        if (empty($jrf_status) || $jrf_status == 'pending') {
            $status     = '0';
            $jrf_status = 'pending';
        } elseif ($jrf_status == 'assigned') {
            $status     = '1';
            $jrf_status = 'Approved';
        } elseif ($jrf_status == 'rejected') {
            $status     = '2';
            $jrf_status = 'Rejected';
        } elseif ($jrf_status == 'closed') {
            $status     = '3';
            $jrf_status = 'closed';
        }

        $data = DB::table('jrf_appointed_approvals as jaa')
        ->join('jrfs as jrf', 'jaa.jrf_id', '=', 'jrf.id')
        ->join('jrf_level_one_screenings as jlto', 'jaa.jrf_level_one_screening_id', '=', 'jlto.id')
        ->join('final_appointment_approvals as faa', 'jaa.jrf_level_one_screening_id', '=', 'faa.jrf_level_one_screening_id')
        ->join('projects as prj','jrf.project_id','=','prj.id')
        ->join('employees as emp', 'emp.user_id', '=', 'jrf.user_id')
        ->join('designations as des', 'jrf.designation_id', 'des.id')
        ->where(['jaa.supervisor_id' => $user->id, 'jaa.jrf_status' => $status])
        ->select('jaa.*', 'emp.fullname as jrf_creater_name', 'jaa.jrf_status as jrf_approval_status', 'jrf.final_status', 'jrf.created_at', 'jlto.name as candidate_name', 'jlto.total_experience', 'jrf.type', 'des.name as designation', 'jrf.jrf_no','prj.name as prj_name','faa.ctc','faa.cih','jlto.total_experience','jrf.closure_type')
        ->orderBy('jaa.jrf_id', 'DESC')
        ->get();

     // dd($data);

        if (!$data->isEmpty()) {
            foreach ($data as $key => $value) {
                if ($value->jrf_status == '0') {
                    $value->secondary_final_status = 'In-Progress';
                } elseif ($value->jrf_status == '3' && $value->final_status == 1) {
                    $value->secondary_final_status = 'closed';
                } elseif ($value->jrf_status == '2') {
                    $value->secondary_final_status = 'Rejected';
                } elseif ($value->jrf_status == '1' && $value->final_status == 0) {
                    $value->secondary_final_status = 'assigned';
                }
            }
        }
        
        return view('jrf.list_appointed_candidate_approvals')->with(['data' => $data, 'selected_status' => $jrf_status]);
    }


     public function saveAppointedCandidate(Request $request)
    {

        if (Auth::guest()) {
            return redirect('/');
        }

        $request->validate([
            'remark' => 'required',
        ]);

        $applied_jrf =  CandidateApprovals::where(['jrf_level_one_screening_id'=> $request->level_id,'supervisor_id' => $request->userId ])->first();

        $jrf         =  Jrf::where('id', $request->jrf_id)->first();
        $approver    =  User::where(['id' => $jrf->user_id])->with('employee')->first();
        $applied_jrf->jrf_status = $request->final_status;
        
        if($request->final_status == '1'){
           $applied_jrf->save();
        }
        $applier = $applied_jrf->user;

        // Send message to JRF Creator when JRF Request approved by HOD Level One//

        $message_data = [
            'sender_id'   => $request->userId, //$jrf->user_id
            'receiver_id' => $applier->id,
            'label'       => 'Approved Apointed Candidate ',
            'message'     => $request->remark,
            'read_status' => '0',
        ];

        $applied_jrf->messages()->create($message_data);

        /* $user_detail = User::where(['id' => Auth::id()])
                ->with('employee') // get Recruiters HOD detail for approval
                ->first();

         $notification_data = [
                    'sender_id'   => $request->userId, //$jrf->user_id
                    'receiver_id' => 13,
                    'label'       => 'Candidate Approval',
                    'message'     => $user_detail->employee->fullname . " sent Candidate  approval.",
                    'read_status' => '0',
                ];

          $jrf->notifications()->create($notification_data);*/


        if( $request->userId == '13' && $request->jrf_id && $request->final_status != '2'){

            $next_approver = JrfHierarchy::where('isactive', 1)->where('type', 'approval')->orderBy('id', 'DESC')->first();

            if (empty($next_approver)) {
                $manager_id = 0;
            } else {
                $manager_id = $next_approver->user_id; //
                
                $user_data  = User::where('id', $manager_id)->first();                

            }

            $user_detail = User::where(['id' => Auth::id()])
                ->with('employee') // get Recruiters HOD detail for approval
                ->first();
               

            $next_approver_present = JrfApprovals::where(['jrf_id' => $applied_jrf->jrf_id, 'supervisor_id' => $manager_id])->first();

            if ( !empty($next_approver) ) {

                //Approved on previous level

                $next_approval_data = [
                    'user_id'       => $applied_jrf->user_id,
                    'supervisor_id' => $manager_id,
                    'priority'      => 4,
                    'jrf_status'    => '0',
                ];


                $notification_data = [
                    'sender_id'   => $applied_jrf->user_id, //$jrf->user_id
                    'receiver_id' => $manager_id,
                    'label'       => 'JRF Approval',
                    'message'     => $user_detail->employee->fullname . " sent request for JRF approval.",
                    'read_status' => '0',
                ];

               /* if ($next_approval_data['priority'] == '4') {
                   
                    // Approved By MD then creates a row in jrf_approvals table with supervisor_id = 13 and staus will be '0' the MD Approves This Jrf Then Status will be Updated '1'
                
                $update_status = ['jrf_status' => '1'];
                
                $result = JrfApprovals::updateOrCreate(['supervisor_id' => $request->userId, 'jrf_id' => $request->jrf_id],$update_status);


                    $jrf->notifications()->create($notification_data);
                } */

                //Send Mail && SMS to the next approver
                if (!empty($result)) {
                    $mail_data['subject']  = 'JRF Approval';
                    $mail_data['to_email'] = $user_data->email;
                    $mail_data['message']  = $user_detail->employee->fullname . " sent request for JRF approval. Please take an action. Here is the link for website <a href='" . url('/') . "'Click here</a>";
                    $mail_data['fullname'] = "Sir";
                    //$this->sendJrfGeneralMail($mail_data);
                    return redirect()->back()->with('success','Candidate Approved successfully');
                }
            }


            }else{

            // End of Assignment //Get Next level Approver detail MD Sir (Final Approver))

            $next_approver = JrfHierarchy::where('isactive', 1)->where('type', 'approval')->orderBy('id', 'DESC')->first();     

            if (empty($next_approver)) {
                $manager_id = 0;
            } else {
                $manager_id = $next_approver->user_id; //
                $user_data  = User::where('id', $manager_id)->first();

            }

            $user_detail = User::where(['id' => Auth::id()])
                ->with('employee') // get Recruiters HOD detail for approval
                ->first();

            $next_approver_present = JrfApprovals::where(['jrf_id' => $applied_jrf->jrf_id, 'supervisor_id' => $manager_id])->first();

            // When Jrf Approved by Hod then  Entering in this Condition
 
            if (!empty($next_approver) && $request->final_status == '1' && !empty($next_approver_present)) {

                //Approved on previous level

                $next_approval_data = [
                    'user_id'       => $applied_jrf->user_id,
                    'supervisor_id' => $manager_id,
                    'priority'      => 4,
                    'jrf_status'    => '0',
                ];

                $notification_data = [
                    'sender_id'   => $request->userId, //$jrf->user_id
                    'receiver_id' => 13,
                    'label'       => 'Candidate Approval',
                    'message'     => $user_detail->employee->fullname . " sent Candidate  approval.",
                    'read_status' => '0',
                ];

                if ($next_approval_data['priority'] == '4') {
                   
                    // Approved By MD then creates a row in jrf_approvals table with supervisor_id = 13 and staus will be '0' the MD Approves This Jrf Then Status will be Updated '1'

                   $result = CandidateApprovals::Create(['supervisor_id' => 13, 'jrf_id' => $request->jrf_id,'jrf_level_one_screening_id' => $request->level_id,'user_id' => $request->u_id]);

                    $jrf->notifications()->create($notification_data);
                }

                //Send Mail && SMS to the next approver
                if (!empty($jrf_approval_insert_id)) {
                    $mail_data['subject']  = 'JRF Approval';
                    $mail_data['to_email'] = $user_data->email;
                    $mail_data['message']  = $user_detail->employee->fullname . " sent request for JRF approval. Please take an action. Here is the link for website <a href='" . url('/') . "'Click here</a>";
                    $mail_data['fullname'] = "Sir";
                    //$this->sendJrfGeneralMail($mail_data);
                }

                return redirect()->back()->with('success','Candidate Approved successfully');

            } elseif ($request->final_status != '1') {

                    $get_jrf_approvded_status = CandidateApprovals::where(['jrf_id' => $request->jrf_id,'supervisor_id' => $request->userId])->first();

                    $update_approval_status = ['jrf_status' => '2'];

                    CandidateApprovals::where(['jrf_level_one_screening_id' => $request->level_id,'jrf_id'=>$request->jrf_id,'supervisor_id' => $request->userId])->update(['jrf_status' => '2']);

                    if (!empty($result)) {
                        //When JRF Rejected By MD sir Send Notification to Creator of JRF //
                        $notification_data = [
                            'sender_id'   => $get_jrf_approvded_status->supervisor_id,
                            'receiver_id' => $get_jrf_approvded_status->user_id,
                            'label'       => 'Candidate Rejected',
                            'read_status' => '0',
                        ];

                        $notification_data['message'] = "Candidate Rejected by " . $user_detail->employee->fullname;
                        $jrf->notifications()->create($notification_data);
                        
                        return redirect()->back()->with('success','Candidate Rejected successfully');
                    }
 

            } elseif (!empty($next_approver) && $request->final_status == '1' && !empty($next_approver_present)) {

                //No this is working when JRf approved by MA Sir...then no next level of approval
                //when approving again

                $applied_jrf = $this->updateJrfApprovalStatus($applied_jrf, $user_detail);
                if (!empty($applied_jrf) && $applied_jrf->supervisor_id == 13) {
                    
                    //return redirect("jrf/edit-jrf/" . $applied_jrf->jrf_id);

                    return redirect()->back()->with('success','Candidate Approved successfully');

                } else {

                    //return redirect("jrf/approve-jrf/");

                    return redirect()->back()->with('success','Candidate Approved successfully');
                }
            }

        }

            $mail_data['to_email'] = $applier->email;
            $mail_data['fullname'] = $applier->employee->fullname;
            if ($applied_jrf->final_status == '1') {

                $mail_data['subject'] = "JRF Approved";
                $mail_data['message'] = "Your JRF has been approved. Check status on the <a href='" . url('/') . "'>website</a>.";
                $this->sendGeneralMail($mail_data);

            } elseif ($applied_jrf->leave_status == '2') {
                $mail_data['subject'] = "JRF Rejected";
                $mail_data['message'] = "Your JRF has been rejected. Check status on the <a href='" . url('/') . "'>website</a>.";
                $this->sendGeneralMail($mail_data);
            }
            return redirect("jrf/approve-appointed-candidate");
    }


    // Change Joining Status

    function changeJoiningStatus(Request $request){

        FinalAppointmentApproval::where(['jrf_level_one_screening_id' => $request->level_id,'jrf_id'=>$request->jrf_id])->update(['joining_status' => '1','joining_date' =>$request->joining_date]);

         return redirect('jrf/list-selected-candidate')->with('success','Candidate Joined Successfully');
    }


    // Management Closure

    public function listClosureCandidate(Request $request)
    {


        if (Auth::guest()) {
            return redirect('/');
        }

        $condition = array();
        $user = User::where(['id' => Auth::id()])->first();

        // Filtering Data By Jrf_no, project name, designation and status   

        if(!empty($request->jrf_no)){
            $condition[] = array('jrf.jrf_no', '=', $request->jrf_no);
        }

        if(!empty($request->project_id)){
            $condition[] = array('jrf.project_id', '=', $request->project_id);
        }

        if(!empty($request->designation_id)){
            $condition[] = array('jrf.designation_id', '=', $request->designation_id);
        }

        /*

        $jrfs_approval = DB::table('closer as clos')
            ->join('jrf_level_one_screenings as jrf_lvl','clos.jrf_level_one_screening_id','=','jrf_lvl.id')
            ->join('final_appointment_approvals as faap','jrf_lvl.id','=','faap.jrf_level_one_screening_id')
            ->join('jrfs as jrf','jrf_lvl.jrf_id','=','jrf.id')
            ->join('projects as proj','jrf.project_id','=','proj.id')
            ->join('employees as emp','faap.user_id','=','emp.user_id')
            ->join('departments as dep','jrf.department_id','=','dep.id')
            ->join('designations as des','jrf.designation_id','=','des.id')
            ->where($condition)
            ->select('clos.*', 'dep.name as department','jrf_lvl.name as cand_name','jrf.jrf_no','proj.name as proj_name','jrf_lvl.joining_date','emp.fullname','des.name as designation','faap.ctc','faap.cih','faap.joining_status')
            ->orderBy('clos.jrf_level_one_screening_id', 'DESC')
            ->get();

        */

        $jrfs_approval = DB::table('jrfs as jrf')
            ->join('designations as des', 'jrf.designation_id', 'des.id')
            ->join('departments as dep','jrf.department_id','=','dep.id')
            ->join('employees as emp','jrf.user_id','=','emp.user_id')
            ->join('roles as r', 'jrf.role_id', 'r.id')
            ->join('projects as prj','jrf.project_id','prj.id')
            ->where($condition)            
            ->select('jrf.*', 'des.name as designation', 'r.name as role','prj.name as proj_name','dep.name as department','emp.fullname','jrf.jrf_closure_timeline')
            ->orderBy('jrf.id', 'DESC')
            ->get();

            $projects = Project::where(['isactive'=>1])->get();
            $designations = Designation::where(['isactive'=>1])->select('id','name')->get();
            $jrfs = Jrf::where(['isactive'=>1])->select('id','jrf_no')->get();
        

        return view('jrf.list_management_closure_candidate')->with(['jrfs_approval' => $jrfs_approval,'designations'=>$designations,'projects'=>$projects,'jrfs'=>$jrfs,'req'=>$request]);

    }


    // Closed Jrf and Shows Candidate Jrf wise

        public function finalJrfClosed($jrf_id)
    {

        if (Auth::guest()) {
            return redirect('/');
        }

        $user = User::where(['id' => Auth::id()])->first();

        $jrfs_approval = DB::table('closer as clos')
            ->join('jrf_level_one_screenings as jrf_lvl','clos.jrf_level_one_screening_id','=','jrf_lvl.id')
            ->join('final_appointment_approvals as faap','jrf_lvl.id','=','faap.jrf_level_one_screening_id')
            ->join('jrfs as jrf','faap.jrf_id','=','jrf.id')
            ->join('employees as emp','faap.user_id','=','emp.user_id')
            ->where('clos.jrf_id',$jrf_id)
            ->select('clos.*','jrf_lvl.name as cand_name','emp.fullname','faap.ctc','faap.cih','faap.joining_status','jrf_lvl.total_experience','jrf.jrf_no','jrf_lvl.joining_letter')
            ->orderBy('clos.jrf_level_one_screening_id', 'DESC')
            ->get();    
    
        return view('jrf.list_jrf_wise_candidate')->with(['jrfs_approval' => $jrfs_approval]);

    }


    // Jrf Closed Permanent


    function changeClosedJrfStatus(Request $request){

        if($request->status == '0'){

            Jrf::where(['id'=>$request->jrf_id])->update(['closure_jrf_status' => '1','closure_type' => 'hold','closure_date' =>$request->closure_dt,'final_status' => '1']);

        }elseif($request->status == '1'){

            Jrf::where(['id'=>$request->jrf_id])->update(['closure_jrf_status' => '1','closure_type' => 'closed','closure_date' =>$request->closure_dt,'final_status' => '1']);    
        }else{

            Jrf::where(['id'=>$request->jrf_id])->update(['closure_jrf_status' => '1','closure_type' => 'open','closure_date' =>$request->closure_dt,'final_status' => '1']);    
        }

        return redirect('jrf/management-closure')->with('success','Status Updated Successfully');
    }


    // Management Date Assigned

    public function MgmtAssignDate()
    {

        if (Auth::guest()) {
            return redirect('/');
        }

        $user = User::where(['id' => Auth::id()])->first();

        $jrfs_approval = DB::table('jrf_level_two_screenings as jlts')
            ->join('jrf_level_one_screenings as jrf_lvl','jlts.jrf_level_one_screening_id','=','jrf_lvl.id')
            ->join('jrfs as jrf','jrf_lvl.jrf_id','=','jrf.id')
            ->join('jrf_recruitment_tasks as jrt', 'jrf.id', 'jrt.jrf_id')
            ->join('employees as emp','jrt.user_id','=','emp.user_id')
            ->where('jlts.qualify','Yes')
            ->select('jlts.*','jrf_lvl.name as cand_name','emp.fullname','jrf_lvl.total_experience','jrf.jrf_no','jrf_lvl.current_ctc','jrf_lvl.current_cih','jrf.jrf_no')
            ->orderBy('jlts.jrf_level_one_screening_id', 'DESC')
            ->get();

           //dd($jrfs_approval);
    
        return view('jrf.list_mgmt_assign_date')->with(['jrfs_approval' => $jrfs_approval]);

    }  


    // Assigned Date Candidate To Management Approval.

    function MgmtassignStatus(Request $request){

            //dd($request);

            JrfLevelTwoScreening::where(['jrf_id'=>$request->jrf_id,'jrf_level_one_screening_id'=>$request->lvl_id])->update(['mgmt_status' => '1','mgmt_date' =>$request->mgmt_dt]);

                $jrf         =  Jrf::where('id', $request->jrf_id)->first();

                $user_detail = User::where(['id' => Auth::id()])
                    ->with('employee') // get Recruiters HOD detail for approval
                    ->first();

               /* $next_approver = JrfHierarchy::where('isactive', 1)->where('type', 'approval')->orderBy('id', 'ASC')->first();   

                if (empty($next_approver)) {
                    $manager_id = 0;
                } else {
                   $manager_id = $next_approver->user_id; //

                   dd($manager_id);
                  
                    $user_data  = User::where('id', $manager_id)->first();
                } */
                
                $user_data  = User::where('id', 13)->first();

                $notification_data = [
                    'sender_id'   => 20, //$request->userId
                    'receiver_id' => 13,
                    'label'       => 'Candidate Approval',
                    'message'     => $user_detail->employee->fullname . " sent Candidate  approval for Management.",
                    'read_status' => '0',
                ];

                $jrf->notifications()->create($notification_data);
            

                //Send Mail && SMS to the next approver
                if (!empty($notification_data)) {
                    $mail_data['subject']  = 'Candidate Approval';
                    $mail_data['to_email'] = $user_data->email;
                    $mail_data['message']  = $user_detail->employee->fullname . " sent Candidate  approval for Management. Please take an action. Here is the link for website <a href='" . url('/') . "'Click here</a>";
                    $mail_data['fullname'] = "Sir";
                    //$this->sendJrfGeneralMail($mail_data);
                }

                return redirect('jrf/mgmt-assign-date')->with('success', "Date assigned successfully.");
    }


    // Approved Management Candidates 


        public function approveMgmt($jrf_status = null)
    {

        if (Auth::guest()) {
            return redirect('/');
        }
        $user = User::where(['id' => Auth::id()])->first();

        if (empty($jrf_status) || $jrf_status == 'pending') {
            $status     = '0';
            $jrf_status = 'pending'; //pending as a inprogress //
        } elseif ($jrf_status == 'assigned') {
            $status     = '1';
            $jrf_status = 'assigned';
        } elseif ($jrf_status == 'rejected') {
            $status     = '2';
            $jrf_status = 'Rejected';
        }

        $data = DB::table('jrf_management_approvals as jma')
        ->join('jrfs as jrf', 'jma.jrf_id', '=', 'jrf.id')
        ->join('jrf_level_one_screenings as jlto', 'jma.jrf_level_one_screening_id', '=', 'jlto.id')
 
        ->join('projects as prj','jrf.project_id','=','prj.id')
        ->join('employees as emp', 'emp.user_id', '=', 'jrf.user_id')
        ->join('designations as des', 'jrf.designation_id', 'des.id')
        ->where(['jma.jrf_status' => $status,'jma.supervisor_id' => 13])
        ->select('jma.*', 'emp.fullname as jrf_creater_name', 'jma.jrf_status as jrf_approval_status', 'jrf.final_status', 'jrf.created_at', 'jlto.name as candidate_name', 'jlto.total_experience', 'jrf.type', 'des.name as designation', 'jrf.jrf_no','prj.name as prj_name','jlto.total_experience')
        ->orderBy('jma.jrf_id', 'DESC')
        ->get();

      //  dd($data);

        if (!$data->isEmpty()) {
            foreach ($data as $key => $value) {
                if ($value->final_status == '0') {
                    $value->secondary_final_status = 'In-Progress';
                } elseif ($value->final_status == '3' && $value->final_status == 1) {
                    $value->secondary_final_status = 'closed';
                } elseif ($value->final_status == '2') {
                    $value->secondary_final_status = 'Rejected';
                } elseif ($value->final_status == '1' && $value->final_status == 0) {
                    $value->secondary_final_status = 'assigned';
                }
            }
        }
        return view('jrf.list_mgmt_cand_approvals')->with(['data' => $data, 'selected_status' => $jrf_status]);
    }


     public function saveMgmtApproval(Request $request)
    {

        if (Auth::guest()) {
            return redirect('/');
        }

        $request->validate([
            'remark' => 'required',
        ]);


        $applied_jrf =  ManagementApprovals::where(['jrf_level_one_screening_id'=> $request->level_id,'supervisor_id' => $request->userId ])->first();

        $jrf         =  Jrf::where('id', $request->jrf_id)->first();
        $approver    =  User::where(['id' => $jrf->user_id])->with('employee')->first();
        $applied_jrf->jrf_status = $request->final_status;
        
        if($request->final_status == '1'){
            $applied_jrf->save();
        }
        $applier = $applied_jrf->user;

        // Send message to JRF Creator when JRF Request approved by HOD Level One//

        $message_data = [
            'sender_id'   => $request->userId, //$jrf->user_id
            'receiver_id' => $applier->id,
            'label'       => 'Approved  Candidate ',
            'message'     => $request->remark,
            'read_status' => '0',
        ];

        $applied_jrf->messages()->create($message_data);

            $user_detail = User::where(['id' => Auth::id()])
                ->with('employee') // get Recruiters HOD detail for approval
                ->first();

            // When Jrf Approved by Hod then  Entering in this Condition
 
            if ( $request->final_status == '1') {

                $notification_data = [
                    'sender_id'   => $request->userId, //$jrf->user_id
                    'receiver_id' => $request->u_id,
                    'label'       => 'Candidate Approval',
                    'message'     => $user_detail->employee->fullname . " sent Candidate  approval.",
                    'read_status' => '0',
                ];


                if (!empty( $notification_data )) {

                   JrfLevelOneScreening::where(['id' => $request->level_id])->update(['mgmt_status_id' => '1']);
     
                    $jrf->notifications()->create($notification_data);
                }

                $user_data  = User::where('id', 13)->first();


                //Send Mail && SMS to the next approver
                if (!empty($next_approval_data)) {
                    $mail_data['subject']  = 'Candidate Approval';
                    $mail_data['to_email'] = $user_data->email;
                    $mail_data['message']  = $user_detail->employee->fullname . " sent request for JRF approval. Please take an action. Here is the link for website <a href='" . url('/') . "'Click here</a>";
                    $mail_data['fullname'] = "Sir";
                    //$this->sendJrfGeneralMail($mail_data);
                }

                return redirect()->back()->with('success','Candidate Approved successfully');

            } elseif ($request->final_status != '1') {

                   JrfLevelOneScreening::where(['id' => $request->level_id])->update(['mgmt_status_id' => '2']);

                   $result =  ManagementApprovals:: where(['jrf_level_one_screening_id' => $request->level_id])->update(['jrf_status' => '2']);

                    if (!empty($result)) {
                        //When JRF Rejected By MD sir Send Notification to Creator of JRF //
                        $notification_data = [
                            'sender_id'   => $request->userId,
                            'receiver_id' => $request->u_id,
                            'label'       => 'Candidate Rejected',
                            'read_status' => '0',
                        ];


                        $notification_data['message'] = "Candidate Rejected by " . $user_detail->employee->fullname;
                        $jrf->notifications()->create($notification_data);
                        
                        return redirect()->back()->with('success','Candidate Rejected successfully');
                    }
 

            }

    }

    // Print Offer Letter

    function viewOfferLetter($id){

        $offer_letter = DB::table('jrf_level_one_screenings as jrf_lvl')
            ->join('jrfs as jrf','jrf_lvl.jrf_id','=','jrf.id')
            ->join('final_appointment_approvals as fnl_app','jrf_lvl.id','=','fnl_app.jrf_level_one_screening_id')
            ->select('jrf_lvl.name as cand_name','jrf_lvl.current_designation','fnl_app.joining_date')
            ->where('jrf_lvl.id',$id)
            ->first();

        return view('jrf.offer_letter')->with(['offer_letter'=>$offer_letter]);
    }




     public function saveReqDate(Request $request)
    {


        if (Auth::guest()) {
            return redirect('/');
        }


        $jrf   =  Jrf::where('id', $request->jrf_id)->first();

        $get_mobile_user_data = User::where(['id' => $request->jrf_creater])
        ->with('employee')
        ->first();

        $job_role = DB::table('roles')
                ->where(['id' => $jrf->role_id])
                ->select('name')
                ->first();

        $department = DB::table('departments')
                ->where(['id' => $jrf->department_id])
                ->select('name')
                ->first();

        $request->validate([
            'mgmt_remark' => 'required',
        ]);

        $user_manager = UserManager::where('isactive', 1)->where('user_id',$request->user_id)->first();

        if (empty($user_manager)) {
            $manager_id = 0;
        } else {
            $manager_id = $user_manager->manager_id;

        }

        $rr = Jrf:: where(['id' => $request->jrf_id])->update(['date_remark' => $request->mgmt_remark,'extended_date' => $request->ext_dt,'extended_date_status' =>'1']);

        if( $request->jrf_creater ==  $request->user_id ){

            $result = DB::table('mgmt_date_approvals')->insert(['user_id' =>$request->user_id,'supervisor_id' =>$manager_id, 'jrf_id' => $request->jrf_id, 'priority' => 2]);
        
        }else{

            $result = DB::table('mgmt_date_approvals')->insert(['user_id' =>$request->user_id,'supervisor_id' =>$request->jrf_creater, 'jrf_id' => $request->jrf_id, 'priority' => 2]);

        }

        $user_detail = User::where(['id' => Auth::id()])
            ->with('employee') // get Recruiters HOD detail for approval
            ->first();

        if (!empty($user_detail)) {
            //When JRF Rejected By MD sir Send Notification to Creator of JRF //
            $notification_data = [
                'sender_id'   => $request->user_id,
                'receiver_id' => $request->assigned_id,
                'label'       => 'JRF CLOSURE Date Extend',
                'read_status' => '0',
            ];

            $notification_data['message'] = "JRF CLOSURE Date Extended Request Sent By " . $user_detail->employee->fullname;

            $jrf->notifications()->create($notification_data);
            
            $user_data  = User::where('id', $request->assigned_id)->first();

            $notificationMessage = $user_detail->employee->fullname." Sent Request For JRF Date Extension For The Position of ".$job_role->name." From ".$department->name. " Department";

            //Send Mail && SMS to the next approver
                
                $mail_data['subject']  = 'JRF CLOSURE Date Extended Request';
                $mail_data['to_email'] = $user_data->email;
                $mail_data['message']  = $user_detail->employee->fullname . " sent JRF CLOSURE Date Extended. Please take an action. Here is the link for website <a href='" . url('/') . "'Click here</a>";
                $mail_data['fullname'] = "Sir";

                sms($get_mobile_user_data->employee->mobile_number,$notificationMessage);

                //$this->sendJrfGeneralMail($mail_data);

            return redirect()->back()->with('success','Date Extension Sent Successfully');

        }
    }

        public function assignedExtendDate($jrf_status = null)
    {

        $user = User::where(['id' => Auth::id()])->first();

        if (empty($jrf_status) || $jrf_status == 'pending') {
            $status     = '0';
            $jrf_status = 'pending'; //pending as a inprogress //
        } elseif ($jrf_status == 'assigned') {
            $status     = '1';
            $jrf_status = 'approved';
        } elseif ($jrf_status == 'rejected') {
            $status     = '2';
            $jrf_status = 'Rejected';
        } elseif ($jrf_status == 'discussion') {
            $status     = '3';
            $jrf_status = 'Discussion';
        }

        $data   = DB::table('mgmt_date_approvals as dt_app')
                ->join('jrf_recruitment_tasks as jrt','dt_app.jrf_id','=','jrt.jrf_id')
                ->join('jrfs as jrf', 'dt_app.jrf_id', 'jrf.id')
                ->join('projects as proj','jrf.project_id','proj.id')
                ->join('designations as des', 'jrf.designation_id', 'des.id')
                ->join('departments as depart', 'jrf.department_id', 'depart.id')
                ->where(['dt_app.supervisor_id' => $user->id, 'dt_app.jrf_status' => $status])
                ->select('jrf.id', 'jrf.user_id as j_u_id', 'des.name as designation','depart.name as department', 'dt_app.*','jrf.final_status', 'jrt.created_at as recruitment_assigned_date','jrf.number_of_positions as npos','jrf.lvl_one_screen as lvl_one_screen','proj.name as proj_name','jrf.jrf_no','jrf.closure_type','jrf.jrf_closure_timeline','jrf.extended_date','jrf.extended_date_status','jrf.date_remark')
                ->orderBy('dt_app.jrf_id','DESC')
                ->groupBy('jrt.jrf_id')
                ->get();

        if (!$data->isEmpty()) {
            foreach ($data as $key => $value) {
                
                $priority_wise_status = DB::table('mgmt_date_approvals as ala')
                                  ->where(['ala.jrf_id' => $value->jrf_id])
                                  ->select('ala.priority','ala.jrf_status')
                                  ->orderBy('ala.priority')
                                  ->get();

                $value->priority_wise_status = $priority_wise_status;

                if ($value->jrf_status == '0') {
                    $value->secondary_final_status = 'In-Progress';
                } elseif ($value->jrf_status == '3' ) {
                    $value->secondary_final_status = 'Discussion';
                } elseif ($value->jrf_status == '2') {
                    $value->secondary_final_status = 'Rejected';
                } elseif ($value->jrf_status == '1' && $value->final_status == 0) {
                    $value->secondary_final_status = 'assigned';
                }
            }
        }

        return view('jrf.recruitment_extend_closure')->with(['data' => $data, 'selected_status' => $jrf_status]);
    }


    // Approval for Date Extension


     public function saveDateExtApproval(Request $request)
    {


        if (Auth::guest()) {
            return redirect('/');
        }


        $request->validate([
            'remarks' => 'required',
        ]);



        $applied_jrf =  MgmtDtApprovals::where('jrf_id', $request->jrf_id)->orderBy('id','DESC')->first();

        $jrf         =  Jrf::where('id', $request->jrf_id)->first();
        $approver    =  User::where(['id' => $jrf->user_id])->with('employee')->first();
        $applied_jrf->jrf_status = $request->final_status;

        if($request->final_status == '1'){
         
            $applied_jrf->save();
        
        }

        $applier = $applied_jrf->user;

        $user_detail = User::where(['id' => Auth::id()])
                ->with('employee') // get Recruiters HOD detail for approval
                ->first();
        $extend_dt_raiser = User::where(['id' => $request->u_id])
                ->with('employee') // get Recruiters HOD detail for approval
                ->first();        

        $job_role = DB::table('roles')
                ->where(['id' => $jrf->role_id])
                ->select('name')
                ->first();


        $department = DB::table('departments')
                ->where(['id' => $jrf->department_id])
                ->select('name')
                ->first();

        $get_mobile_user_data = User::where(['id' => $request->supervisor_id])
        ->with('employee')
        ->first();        
        
        // For Discussion Only send whats app message     

        if( $request->supervisor_id == '13' && $request->jrf_id && $request->final_status == '3'){

            $next_approver_present = MgmtDtApprovals::where(['jrf_id' => $applied_jrf->jrf_id, 'supervisor_id' => $request->assigned_to_id])->first();

            $user_data  = User::where('id', $request->assigned_to_id)->first();
                
            $update_status = ['jrf_status' => '3'];
                
            $result = MgmtDtApprovals::updateOrCreate(['supervisor_id' => $request->supervisor_id, 'jrf_id' => $request->jrf_id],$update_status);

            Jrf::where('id', $applied_jrf->jrf_id)->update(['discussion_remarks'=>$request->remarks]);

            $notificationMessage = $user_detail->employee->fullname." Sent request for JRF Extended Date Discussion For The Position of ".$job_role->name." From ".$department->name. " Department";

                if(!empty($next_approver_present)){
                    $mail_data['subject']  = 'Extended Date Discussion';
                    $mail_data['to_email'] = $user_data->email;
                    $mail_data['message']  = $user_detail->employee->fullname . " sent request for JRF Extended Date Discussion Please Check On Your whatsApp";
                    $mail_data['fullname'] = "Sir";

                    sms($get_mobile_user_data->employee->mobile_number,$notificationMessage);

                    ////$this->sendJrfGeneralMail($mail_data);

                   
                }

                return redirect()->back()->with('success','Date Discussion Raised Successfully');
            
                exit();
        }    

        //dd("d");    
        
        if( $request->supervisor_id == '13' && $request->jrf_id && $request->final_status == '1'){

          // dd('MD Sir Approval');

            $next_approver = JrfHierarchy::where('isactive', 1)->where('type', 'approval')->orderBy('id', 'DESC')->first();

            if (empty($next_approver)) {
                $manager_id = 0;
            } else {
                $manager_id = $next_approver->user_id; //
                
                $user_data  = User::where('id', $manager_id)->first();                

            }

            $user_detail = User::where(['id' => Auth::id()])
                ->with('employee') // get Recruiters HOD detail for approval
                ->first();
               
            $next_approver_present = MgmtDtApprovals::where(['jrf_id' => $applied_jrf->jrf_id, 'supervisor_id' => $manager_id])->first();


            if ( !empty($next_approver) ) {

                //Approved on previous level

                $next_approval_data = [
                    'user_id'       => $applied_jrf->user_id,
                    'supervisor_id' => $manager_id,
                    'priority'      => 4,
                    'jrf_status'    => '0',
                ];


                $notification_data = [
                    'sender_id'   => $applied_jrf->user_id, //$jrf->user_id
                    'receiver_id' => $manager_id,
                    'label'       => 'JRF Approval',
                    'message'     => $user_detail->employee->fullname . " sent request for JRF approval.",
                    'read_status' => '0',
                ];


                if ($next_approval_data['priority'] == '4') {
                
                    $update_status = ['jrf_status' => '1'];
                
                    $result = MgmtDtApprovals::updateOrCreate(['supervisor_id' => $request->supervisor_id, 'jrf_id' => $request->jrf_id],$update_status);

                    $rr = Jrf:: where(['id' => $request->jrf_id])->update(['extended_date_status' =>'4','jrf_closure_timeline' => $request->extended_date]);

                    $jrf->notifications()->create($notification_data);
                }

                //Send Mail && SMS to the next approver
                if (!empty($result)) {
                    $mail_data['subject']  = 'JRF Approval';
                    $mail_data['to_email'] = $user_data->email;
                    $mail_data['message']  = $user_detail->employee->fullname . " sent request for JRF approval. Please take an action. Here is the link for website <a href='" . url('/') . "'Click here</a>";
                    $mail_data['fullname'] = "Sir";
                    //$this->sendJrfGeneralMail($mail_data);
                }

                return redirect()->back()->with('success','Approved successfully');

            }

        }elseif ($request->final_status == '2') {

            $get_jrf_approvded_status = MgmtDtApprovals::where(['jrf_id'=> $request->jrf_id,'supervisor_id'=> $request->supervisor_id])->first();

            $update_approval_status = ['jrf_status' => '2'];

            $result = MgmtDtApprovals::updateOrCreate(['supervisor_id' => $request->supervisor_id, 'jrf_id' => $request->jrf_id], $update_approval_status);

            Jrf:: where(['id' => $request->jrf_id])->update(['extended_date_rejected' => 2]);

            if (!empty($result)) {
                //When JRF Rejected By MD sir Send Notification to Creator of JRF //
                $notification_data = [
                    'sender_id'   => $get_jrf_approvded_status->supervisor_id,
                    'receiver_id' => $get_jrf_approvded_status->user_id,
                    'label'       => 'JRF Extended',
                    'read_status' => '0',
                ];

                $notification_data['message'] = "JRF Extended Date Reject by " . $user_detail->employee->fullname;
                $jrf->notifications()->create($notification_data);

                $notificationMessage = $user_detail->employee->fullname." JRF Extended Date Rejected For The Position of ".$job_role->name." From ".$department->name. " Department";

                sms($extend_dt_raiser->employee->mobile_number,$notificationMessage);    

                return redirect()->back()->with('success','JRF Extended Date Request Rejected successfully');
            }


        }else{

            $next_approver = UserManager::where('isactive', 1)->where('user_id',$request->assigned_to_id)->first();

            if (empty($next_approver)) {
                $manager_id = 0;
            } else {
                $manager_id = $next_approver->manager_id; //
                $user_data  = User::where('id', $manager_id)->first();

            }

            $user_detail = User::where(['id' => Auth::id()])
                ->with('employee') // get Recruiters HOD detail for approval
                ->first();

            $get_mobile_user_data = User::where(['id' => $user_data->id])
                ->with('employee')
                ->first();                    

            $next_approver_present = MgmtDtApprovals::where(['jrf_id' => $applied_jrf->jrf_id, 'supervisor_id' => $manager_id])->first();
            

            // When Jrf Approved by Hod then  Entering in this Condition
 
           // if (!empty($next_approver) && empty($next_approver_present)) {
            if (!empty($next_approver) ) {
                //dd("s");
                $next_approval_data = [
                    'user_id'       => $applied_jrf->user_id,
                    'supervisor_id' => $manager_id,
                    'priority'      => 3,
                    'jrf_status'    => '0',
                ];


                $notification_data = [
                    'sender_id'   => $applied_jrf->user_id, //$jrf->user_id
                    'receiver_id' => $manager_id,
                    'label'       => 'JRF Extended Date',
                    'message'     => $user_detail->employee->fullname . " sent request for JRF Extended Date Approvals.",
                    'read_status' => '0',
                ];

               // dd($next_approval_data);    

                if ($next_approval_data['priority'] == '3') {
                   
                    $jrf_approval_insert_id = $jrf->MgmtDtApprovals()->create($next_approval_data);
                    $jrf->notifications()->create($notification_data);

                    $notificationMessage = $user_detail->employee->fullname." Sent Request For JRF Date Extension Approval For The Position of ".$job_role->name." From ".$department->name. " Department";

                }

                //Send Mail && SMS to the next approver
               
                if (!empty($jrf_approval_insert_id)) {
                    $mail_data['subject']  = 'JRF Extende Date';
                    $mail_data['to_email'] = $user_data->email;
                    $mail_data['message']  = $user_detail->employee->fullname . " sent request for JRF approval. Please take an action. Here is the link for website <a href='" . url('/') . "'Click here</a>";
                    $mail_data['fullname'] = "Sir";
                    sms($get_mobile_user_data->employee->mobile_number,$notificationMessage);
                    //$this->sendJrfGeneralMail($mail_data);
                }

                return redirect()->back()->with('success','Approved successfully');

            }

        } 


    }

    // Jrf Send Back

    public function sendbackJrf($jrf_status = null)
    {

        if (Auth::guest()) {
            return redirect('/');
        }
        $user = User::where(['id' => Auth::id()])->first();

        if (empty($jrf_status) || $jrf_status == 'sendback') {
            $status     = '3';
            $jrf_status = 'sendback'; //pending as a inprogress //
        }


        $data = DB::table('jrf_approvals as ja')
            ->join('jrfs as jrf', 'ja.jrf_id', '=', 'jrf.id')
            ->leftjoin('jrf_hierarchies as jh', 'ja.supervisor_id', 'jh.user_id')
            ->where(['ja.jrf_status' => $status, 'jrf.isactive' => 1])
            ->select('ja.*','ja.jrf_status as jrf_approval_status', 'jh.user_id as hierarchy_user_id', 'jrf.jrf_no','jrf.send_back_remark')
            ->orderBy('ja.jrf_id', 'DESC')
            ->get();

        if (!$data->isEmpty()) {
            foreach ($data as $key => $value) {

                if ($value->jrf_status == '3') {
                    $value->secondary_final_status = 'sendback';
                } elseif ($value->jrf_status == '3' && $value->final_status == 1) {
                    $value->secondary_final_status = 'closed';
                } elseif ($value->jrf_status == '2') {
                    $value->secondary_final_status = 'Rejected';
                } elseif ($value->jrf_status == '1' && $value->final_status == 0) {
                    $value->secondary_final_status = 'assigned';
                }
            }
        }


        return view('jrf.list_sendback_approvals')->with(['data' => $data, 'selected_status' => $jrf_status]);
    }


    // Save Send Back JRF Approvals


     public function savesendBackApproval(Request $request)
    {

        if (Auth::guest()) {
            return redirect('/');
        }

        $request->validate([
            'remark' => 'required',
        ]);

            $jrf   =  Jrf::where('id', $request->jrf_id)->first();

            $user_detail = User::where(['id' => Auth::id()])
                ->with('employee') // get Recruiters HOD detail for approval
                ->first();

            // When Jrf Approved by Hod then  Entering in this Condition
 
            if ( $request->final_status == '1') {

                $notification_data = [
                    'sender_id'   => $request->u_id, //$jrf->user_id
                    'receiver_id' => $request->userId,
                    'label'       => 'JRF Coloumn Updates in Send back Jrf',
                    'message'     => $user_detail->employee->fullname . "JRF Coloumn Updates.",
                    'read_status' => '0',
                ];

                if (!empty( $notification_data )) {

                   JrfApprovals::where(['jrf_id' => $request->jrf_id,'supervisor_id' =>$request->userId,'user_id' => $request->u_id])->update(['jrf_status' => '0']);
     
                    $jrf->notifications()->create($notification_data);
                }

                $user_data  = User::where('id', 13)->first();


                //Send Mail && SMS to the next approver
                if (!empty($user_data)) {
                    $mail_data['subject']  = 'JRF Coloumn Updates';
                    $mail_data['to_email'] = $user_data->email;
                    $mail_data['message']  = $user_detail->employee->fullname . " sent request for  JRF Coloumn Updates. Please take an action. Here is the link for website <a href='" . url('/') . "'Click here</a>";
                    $mail_data['fullname'] = "Sir";
                    //$this->sendJrfGeneralMail($mail_data);
                }

                return redirect()->back()->with('success','Candidate Approved successfully');

            } 
    }



    // Discussion Date Extension

    public function DiscussionJrf($jrf_status = null)
    {

        if (Auth::guest()) {
            return redirect('/');
        }
        $user = User::where(['id' => Auth::id()])->first();

        if (empty($jrf_status) || $jrf_status == 'sendback') {
            $status     = '3';
            $jrf_status = 'discussion'; //pending as a inprogress //
        }


        $data = DB::table('mgmt_date_approvals as ja')
            ->join('jrfs as jrf', 'ja.jrf_id', '=', 'jrf.id')
            ->leftjoin('jrf_hierarchies as jh', 'ja.supervisor_id', 'jh.user_id')
            ->where(['ja.jrf_status' => $status, 'jrf.isactive' => 1])
            ->select('ja.*','ja.jrf_status as jrf_approval_status', 'jh.user_id as hierarchy_user_id', 'jrf.jrf_no','jrf.discussion_remarks','jrf.extended_date')
            ->orderBy('ja.jrf_id', 'DESC')
            ->get();

        if (!$data->isEmpty()) {
            foreach ($data as $key => $value) {

                if ($value->jrf_status == '3') {
                    $value->secondary_final_status = 'discussion';
                } elseif ($value->jrf_status == '3' && $value->final_status == 1) {
                    $value->secondary_final_status = 'closed';
                } elseif ($value->jrf_status == '2') {
                    $value->secondary_final_status = 'Rejected';
                } elseif ($value->jrf_status == '1' && $value->final_status == 0) {
                    $value->secondary_final_status = 'assigned';
                }
            }
        }


        return view('jrf.list_discussion_approvals')->with(['data' => $data, 'selected_status' => $jrf_status]);
    }

     // Save Discussion Date Extension


     public function saveDiscussionApproval(Request $request)
    {

        if (Auth::guest()) {
            return redirect('/');
        }

        $request->validate([
            'remark' => 'required',
        ]);

            $jrf   =  Jrf::where('id', $request->jrf_id)->first();

            $user_detail = User::where(['id' => Auth::id()])
                ->with('employee') // get Recruiters HOD detail for approval
                ->first();

            // When Jrf Approved by Hod then  Entering in this Condition
 
            if ( $request->final_status == '1') {

                $notification_data = [
                    'sender_id'   => $request->u_id, //$jrf->user_id
                    'receiver_id' => $request->userId,
                    'label'       => 'JRF Discussion Extension Date Approved',
                    'message'     => $user_detail->employee->fullname . "JRF Discussion Extension Date Approved.",
                    'read_status' => '0',
                ];

                if (!empty( $notification_data )) {

                   MgmtDtApprovals::where(['jrf_id' => $request->jrf_id,'supervisor_id' =>$request->userId,'user_id' => $request->u_id])->update(['jrf_status' => '0']);

                   Jrf:: where(['id' => $request->jrf_id])->update(['extended_date' => $request->extended_date]);
     
                    $jrf->notifications()->create($notification_data);
                }

                $user_data  = User::where('id', 13)->first();

                //Send Mail && SMS to the next approver
                if (!empty($user_data)) {
                    $mail_data['subject']  = 'JRF Discussion Extension Date Approved';
                    $mail_data['to_email'] = $user_data->email;
                    $mail_data['message']  = $user_detail->employee->fullname . " sent request for  JRF Discussion Extension Date Approved. Please take an action. Here is the link for website <a href='" . url('/') . "'Click here</a>";
                    $mail_data['fullname'] = "Sir";
                    //$this->sendJrfGeneralMail($mail_data);
                }

                return redirect()->back()->with('success','JRF Discussion Extension Date Approved successfully');

            } 
    }


    // Unassigned Recruiter

    function unassignedRecruiter($id){

        $get_jrf_id  = JrfRecruitmentTasks::where('id', $id)->select('jrf_id')->first();

        $rr = JrfRecruitmentTasks:: where(['id'=>$id])->update(['is_assigned' => '1']);
        return redirect('jrf/edit-jrf/'.$get_jrf_id->jrf_id)->with('success','Recruiter Unassigned Successfully');
    }




}