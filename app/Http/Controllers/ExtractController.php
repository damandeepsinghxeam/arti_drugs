<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Mail\ForgotPassword;
use Mail;
use Hash;
use Auth;
use DB;
use Validator;
use Carbon\Carbon;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\User;
use App\Employee;
use App\EmployeeAccount;
use App\EmployeeProfile;
use App\EmployeeAddress;
use App\EmployeeSecurity;
use App\EmployeeReference;
use App\EmploymentHistory;
use App\Country;
use App\State;
use App\City;
use App\Band;
use App\Skill;
use App\Language;
use App\Department;
use App\Location;
use App\Shift;
use App\Bank;
use App\Project;
use App\ProbationPeriod;
use App\Perk;
use App\Qualification;
use App\Document;
use App\Company;
use App\SalaryStructure;
use App\SalaryCycle;
use App\LeaveAuthority;
use App\Message;
use App\Notification;
use App\Designation;
use App\Log;
use App\PtRegistration;
use App\EsiRegistration;

class ExtractController extends Controller
{
    function extractCompany()
    {
        ///////////Create Company////////////
        $companies = DB::connection('erp')->table('register_companies')->get();
        $user = Auth::user();
        
        foreach ($companies as $key => $value) {
            $company_data = [   
                'name' => $value->company_name,
                'address' => $value->company_address,
                'phone' => $value->company_phone,
                'email' => $value->company_email,
                'website' => $value->company_website,
                'creator_id' => $user->id,   
                'tan_number' => $value->company_tan_no,
                'pf_account_number' => $value->comp_pf_acc_number,
                'responsible_person' => $value->responsible_person,
                'phone_extension' => $value->phone_extn,
                'dbf_file_code' => $value->dbf_file_code,
                'extension' => $value->extn,
                'approval_status' => '0',
            ];
            $company = Company::create($company_data);
            $company->approval()->create(['approver_id'=>$user->id]);
            $company->update(['approval_status'=>'1']);

            ///////////////ESI/////////////////////
            $esis = DB::connection('erp')->table('esi_registrations')
                                        ->where('company_id',$company->id)
                                        ->get();

            foreach ($esis as $key2 => $value2) {
                $esi_data = [
                    'company_id' => $value2->company_id,
                    'location_id' => 1, //Mohali
                    'local_office' => $value2->esi_local_office,
                    'esi_number' => $value2->esi_number,
                    'address' => $value2->esi_address
                ];

                $esi = EsiRegistration::create($esi_data);
            } 
            //////////////PT////////////////////    
            $pts = DB::connection('erp')->table('pt_registrations as pt')
                    ->join('states as s','pt.state_id','=','s.s_id')
                    ->where('company_id',$company->id)
                    ->select('pt.*','s.s_name')
                    ->get(); 
                                        
            foreach ($pts as $key3 => $value3) {
                $pt_data =  [
                    'company_id' => $value3->company_id,
                    'certificate_number' => $value3->certificate_no,
                    'address' => $value3->address,
                    'pto_circle_number' => $value3->pto_circle_number,
                    'return_period' => $value3->return_period 
                ];
                $state = State::where(['name'=>$value3->s_name])->first();
                $pt_data['state_id'] = $state->id;
                $pt = PtRegistration::create($pt_data);
            }                            
        }
        echo "companies created";
    }//end of function

    function extractProject()
    {
        $projects = DB::connection('erp')->table('projects')
                                        ->where('approval_status','1')
                                        ->get();
        $user = Auth::user();
        foreach ($projects as $key => $oproject) {
            $project_data = [   
                'company_id' => $oproject->company_id,
                'name' => $oproject->project_name,
                'address' => $oproject->project_address,
                'salary_structure_id' => $oproject->salary_structure_id,
                'salary_cycle_id' => $oproject->salary_cycle_id,
                'number_of_resources' => $oproject->no_of_resources,
                'type' => $oproject->project_type,
                'tenure_years' => $oproject->tenure_years,
                'tenure_months' => $oproject->tenure_months,
                'creator_id' => $user->id,    
                'approval_status' => '0' 
            ];

            $project = Project::create($project_data);
            $project->approval()->create(['approver_id'=>$user->id]);
            $project->approval_status = '1';
            $project->save();

            $location_ids = [1]; //Mohali
            $project->locations()->sync($location_ids);

            $state_ids = PtRegistration::where('company_id',$oproject->company_id)
                                        ->pluck('state_id')->toArray(); 
            $project->states()->sync($state_ids);

            $employeeIds = [1];
            foreach($employeeIds as $key => $value) {
                $project->projectResponsiblePersons()->create(['user_id'=>$value]);
            }

            if($oproject->project_id == 1){
                $ocontact = DB::connection('erp')->table('project_contacts')
                                    ->first();
                $data = [
                    'name'  => $ocontact->name,
                    'mobile_number' => $ocontact->mobile_number,
                    'role' => $ocontact->role,
                    'email' => $ocontact->email
                ];

                $contact = $project->projectContacts()->create($data);
            }
        }                                
        echo "projects created";
    }//end of function

    function extractUser(){
        $oemployees = DB::connection('erp')->table('employees')
                    ->where('id','!=',1)
                    ->orderBy('id','ASC')
                    ->get();

            //print_r(count($oemployees));die;            
        
            foreach ($oemployees as $key => $oemployee) {
                $oemp_profile = DB::connection('erp')->table('emp_profiles')
                                    ->where(['employee_id'=>$oemployee->id])
                                    ->first();
                $user_data = [
                    'email' => $oemployee->email,
                    'employee_code'  => $oemp_profile->emp_xeam_code,
                    'password' => $oemployee->password
                ];

                $check = User::where('employee_code',$oemp_profile->emp_xeam_code)
                        ->first();

                if(empty($check)){
                    $user = User::create($user_data);

                    $employee_data = [
                        'user_id' => $user->id,
                        'creator_id' => Auth::id(),
                        'employee_id' => $oemp_profile->old_xeam_code,
                        'salutation' => $oemp_profile->salutation,
                        'fullname' => $oemp_profile->full_name,
                        'first_name' => $oemp_profile->first_name,
                        'middle_name' => $oemp_profile->middle_name,
                        'last_name' => $oemp_profile->last_name,
                        'personal_email' => $oemp_profile->personal_email,
                        'mobile_number' => $oemployee->mobile,
                        'country_id' => 1,
                        'alternative_mobile_number' => $oemployee->alt_mobile,
                        'alt_country_id' => 1,
                        'experience_year_month' => $oemp_profile->experience_ym,
                        'experience_status' => $oemp_profile->exp_freshers,
                        'marital_status' => $oemp_profile->marital_status,
                        'gender' => $oemp_profile->gender,
                        'approval_status' => '1',
                        'father_name' => $oemp_profile->father_name,  
                        'mother_name' => $oemp_profile->mother_name,
                        'spouse_name' => $oemp_profile->spouse_name,
                        'birth_date'  => $oemp_profile->birth_date,
                        'joining_date' => $oemp_profile->joining_date,
                        'nominee_name'  => $oemp_profile->nominee_name,
                        'relation'  => $oemp_profile->relation,
                        'nominee_type' => $oemp_profile->nominee_type,
                        'registration_fees'=> $oemp_profile->registration_fees,
                        'application_number' => $oemp_profile->application_number,                      
                        'spouse_working_status' => $oemp_profile->spouse_working_status,                 
                        'spouse_company_name' => $oemp_profile->spouse_company_name,                     
                        'spouse_designation' => $oemp_profile->spouse_designation,                       
                        'spouse_contact_number' => $oemp_profile->spouse_contact_number       
                    ];
                    $employee_data['referral_code'] = $oemployee->referral_code;
                    $employee_data['insurance_company_name'] = $oemp_profile->insurance_company_name;
                    $employee_data['cover_amount'] = $oemp_profile->cover_amount;
                    $employee_data['type_of_insurance'] = $oemp_profile->type_of_insurance;
                    $employee_data['insurance_expiry_date'] = $oemp_profile->insurance_expiry_date;
                    
                    if($oemp_profile->marriage_date != '0000-00-00'){
                        $employee_data['marriage_date'] = $oemp_profile->marriage_date;
                    }
                    
                    $employee_data['profile_picture'] = $oemp_profile->profile_pic;

                    $employee = Employee::create($employee_data);
                    $user->approval()->create(['approver_id'=>Auth::id()]);

                    $skillIds = DB::connection('erp')->table('emp_skills')
                                            ->where(['employee_id'=>$oemployee->id,'status_id'=>'1'])
                                            ->pluck('skill_id')->toArray();
                    if(!empty($skillIds)){
                        $user->skills()->sync($skillIds);
                    }  
                    
                    $oqualificationIds = DB::connection('erp')->table('emp_qualifications as eq')
                                            ->join('qualifications as q','q.q_id','=','eq.qualification_id')
                                            ->where(['eq.employee_id'=>$oemployee->id,'eq.status_id'=>'1'])
                                            ->pluck('q.qualification_name')->toArray();

                    $qualificationIds = Qualification::whereIn('name',$oqualificationIds) 
                                        ->pluck('id')->toArray();

                    if(!empty($qualificationIds)){
                        $user->qualifications()->sync($qualificationIds);
                    }
                    
                    $languageIds = DB::connection('erp')->table('emp_languages')
                                        ->where(['employee_id'=>$oemployee->id,'status_id'=>'1'])
                                        ->pluck('language_id')->toArray();
                    if(!empty($languageIds)){
                        $user->languages()->sync($languageIds);
                        
                        $olanguages = DB::connection('erp')->table('emp_languages')
                                        ->where(['employee_id'=>$oemployee->id,'status_id'=>'1'])
                                        ->get();

                        foreach ($olanguages as $key => $olanguage) {
                            $lang = DB::table('language_user')
                                    ->where(['user_id'=>$user->id,'language_id'=>$olanguage->language_id])
                                    ->first();

                            if(!empty($lang)){
                                DB::table('language_user')->where('id',$lang->id)
                                            ->update([
                                                'read_language' => $olanguage->read_language,        
                                                'write_language' => $olanguage->write_language,       
                                                'speak_language' => $olanguage->speak_language
                                            ]);
                            }               
                        }                
                    }
                    /////////////Profile//////////////////
                    $odepartment = DB::connection('erp')->table('departments')
                                    ->where(['department_id'=>$oemp_profile->department_id,'status_id'=>'1'])
                                    ->first();

                    $department = Department::where('name',$odepartment->department_name)->first();                
                    $employee_profile_data = [
                        'shift_id'  => $oemp_profile->shift_timing_id,
                        'department_id' => $department->id,
                        "probation_period_id" => $oemp_profile->probation_period_id,
                        'state_id' => 28, //Punjab 
                        'probation_approval_status' => $oemp_profile->probation_status,
                        'probation_hod_approval' => $oemp_profile->probation_hod_approval,
                        'probation_hr_approval' => $oemp_profile->probation_hr_approval,
                        'probation_end_date' => $oemp_profile->probation_end_date
                    ];

                    $orole = DB::connection('erp')->table('model_has_roles')
                            ->where(['model_id'=>$oemployee->id])
                            ->value('role_id');

                    $role = Role::find($orole);   
                    $user->assignRole($role->name);
                    
                    $opermissions = DB::connection('erp')->table('model_has_permissions as mp')
                                    ->join('permissions as p','p.id','=','mp.permission_id')
                                    ->where(['mp.model_id'=>$oemployee->id])
                                    ->pluck('p.name')->toArray();

                    $permissionIds = Permission::whereIn('name',$opermissions)
                                                ->pluck('id')->toArray();
                    $user->syncPermissions($permissionIds);
                    $user->employeeProfile()->create($employee_profile_data);

                    //$user->userManager()->create(['manager_id'=>1]);
                    //$user->leaveAuthorities()->create(['manager_id'=>1,'priority'=>'2']);
                    //$user->leaveAuthorities()->create(['manager_id'=>1,'priority'=>'3']);
                    //$user->leaveAuthorities()->create(['manager_id'=>1,'priority'=>'4']);

                    $perkIds = DB::connection('erp')->table('employee_perks')
                                ->where(['employee_id'=>$oemployee->id])
                                ->pluck('perk_id')->toArray();

                    if(!empty($perkIds)){
                        $user->perks()->sync($perkIds);
                    }

                    $locationIds = [1]; //Mohali
                    if(!empty($locationIds)){
                        $user->locations()->sync($locationIds);
                    }

                    $projects = [];
                    array_push($projects,$oemp_profile->project_id); 

                    if(!empty($projects)){
                        $user->projects()->sync($projects);
                    }
                } //end if       

            }//end foreach
           
        echo "users created";                         
    }//end of function

    function extractManager()
    {
        $oemployees = DB::connection('erp')->table('emp_report_managers as erm')
                    ->join('emp_profiles as ep','ep.employee_id','=','erm.employee_id')
                    ->join('emp_profiles as ep2','ep2.employee_id','=','erm.report_manager_id')
                    //->join('departments as d','ep.department_id','=','d.department_id')
                    ->select('erm.*','ep.emp_xeam_code','ep2.emp_xeam_code as report_xeam_code','ep.department_id')
                    ->get();

        foreach ($oemployees as $key => $oemployee) {
            $user = User::where('employee_code', $oemployee->emp_xeam_code)->first();
            $manager = User::where('employee_code', $oemployee->report_xeam_code)->first();
            $check_manager = $user->userManager;
            
            if(!empty($user) && !empty($manager) && empty($check_manager)){
                $user->userManager()->create(['manager_id'=>$manager->id]);

                $ohod = DB::connection("erp")->table('department_reporting_hods as drh')
                    ->join('emp_profiles as ep','ep.employee_id','=','drh.employee_id')
                    ->where('drh.department_id',$oemployee->department_id)
                    ->where(['drh.priority'=>'2','drh.sub_level'=>'1'])
                    ->select('drh.*','ep.emp_xeam_code')
                    ->first();

                if(!empty($ohod)){
                    $hod = User::where('employee_code', $ohod->emp_xeam_code)->first();
                    $user->leaveAuthorities()->create(['manager_id'=>$hod->id,'priority'=>'2']);
                }    

                $ohr = DB::connection("erp")->table('department_reporting_hods as drh')
                    ->join('emp_profiles as ep','ep.employee_id','=','drh.employee_id')
                    ->where('drh.department_id',$oemployee->department_id)
                    ->where(['drh.priority'=>'3','drh.sub_level'=>'1'])
                    ->select('drh.*','ep.emp_xeam_code')
                    ->first();

                if(!empty($ohr)){
                    $hr = User::where('employee_code', $ohr->emp_xeam_code)->first();
                    $user->leaveAuthorities()->create(['manager_id'=>$hr->id,'priority'=>'3']);
                }

                $omd = DB::connection("erp")->table('department_reporting_hods as drh')
                    ->join('emp_profiles as ep','ep.employee_id','=','drh.employee_id')
                    ->where('drh.department_id',$oemployee->department_id)
                    ->where(['drh.priority'=>'4','drh.sub_level'=>'1'])
                    ->select('drh.*','ep.emp_xeam_code')
                    ->first();

                if(!empty($omd)){
                    $md = User::where('employee_code', $omd->emp_xeam_code)->first();
                    $user->leaveAuthorities()->create(['manager_id'=>$md->id,'priority'=>'4']);
                }   
            }
        }            

        echo "managers created";            
    }//end of function

    function extractLeave()
    {
        $oleaves = DB::connection('erp')->table('apply_leaves as al')
                    ->join('emp_profiles as ep','ep.employee_id','=','al.employee_id')
                    ->leftjoin('emp_profiles as ep2','ep2.employee_id','=','al.replacement')
                    //->join('departments as d','ep.department_id','=','d.department_id')
                    ->select('al.*','ep.emp_xeam_code','ep.department_id','ep2.emp_xeam_code as replacement_xeam_code')
                    ->get();

        foreach ($oleaves as $key => $oleave) {
            $user = User::where('employee_code', $oleave->emp_xeam_code)->first();

            $leave_data = [  
                'leave_type_id' => $oleave->leave_type_id,
                'country_id' => 1,
                'state_id' => 28, //Punjab
                'city_id' => 1110, //Mohali
                'reason' => $oleave->reason_for_leave,
                'number_of_days' => $oleave->no_of_days, 
                'from_time' => $oleave->from_time,
                'to_time' => $oleave->to_time,
                'mobile_country_id' => 1,
                'mobile_number' => $oleave->mobile_number,
                "secondary_leave_type" => $oleave->secondary_leave_type,
                'from_date' => $oleave->from_date, 
                'to_date' => $oleave->to_date,
                //'excluded_dates' => $oleave->excludedDates, 
                'tasks' => $oleave->tasks,
                'leave_half' => $oleave->leave_half,
                'final_status' => $oleave->final_status
            ];

            if($oleave->status_id == '0'){
                $leave_data['isactive'] = 0;
            }

            $applied_leave = $user->appliedLeaves()->create($leave_data);

            if(!empty($oleave->file_name)){
                $document_data['name'] = $oleave->file_name;
                $applied_leave->appliedLeaveDocuments()->create($document_data);
            }

            if(!empty($oleave->replacement)){
                $replacement = User::where('employee_code', $oleave->replacement_xeam_code)->first();
                $applied_leave->leaveReplacement()->create(['user_id'=>$replacement->id]);
            }

            $osegregations = DB::connection('erp')->table('apply_leave_segregations')
                                ->where('apply_leave_id',$oleave->apply_leave_id)
                                ->get();

            foreach ($osegregations as $key => $value) {
                $segregation_data =  [
                    'from_date' => $value->from_date,
                    'to_date' => $value->to_date,
                    'number_of_days' => $value->no_of_days,
                    'paid_count' => $value->paid_leaves_count,
                    'unpaid_count' => $value->unpaid_leaves_count,
                    'compensatory_count' => $value->compensatory_leaves_count
                ];
                $applied_leave->appliedLeaveSegregations()->create($segregation_data);
            }         
            
            $oapprovals = DB::connection('erp')->table('leave_approval_status as las')
                    ->join('emp_profiles as ep','ep.employee_id','=','las.report_manager_id')
                    ->where('apply_leave_id',$oleave->apply_leave_id)
                    ->select('las.*','ep.emp_xeam_code','ep.department_id')
                    ->get();

            foreach ($oapprovals as $key => $value) {
                $supervisor = User::where('employee_code', $value->emp_xeam_code)->first();
                $approval_data = [
                    'user_id' => $user->id,
                    'supervisor_id' => $supervisor->id,
                    'priority' => $value->priority,
                    'leave_status' => (string)$value->leave_status_id
                ];
                $applied_leave->appliedLeaveApprovals()->create($approval_data);
            }   
            
            $onotifications = DB::connection('erp')->table('messages as m')
                    ->join('emp_profiles as ep','ep.employee_id','=','m.sender_id')
                    ->join('emp_profiles as ep2','ep2.employee_id','=','m.receiver_id')
                    ->where('m.table_entity_id',$oleave->apply_leave_id)
                    ->select('m.*','ep.emp_xeam_code','ep2.emp_xeam_code as receiver_xeam_code')
                    ->get();

            foreach ($onotifications as $key => $value) {
                $sender = User::where('employee_code', $value->emp_xeam_code)->first();
                $receiver = User::where('employee_code', $value->receiver_xeam_code)->first();

                if($value->label == 'Leave Application'){
                    $notification_data = [
                        'sender_id' => $sender->id,
                        'receiver_id' => $receiver->id,
                        'label' => 'Leave Application',
                        'read_status' => $value->read_status,
                        'message' => $value->message,
                        'created_at' => $value->created_at,
                        'updated_at' => $value->updated_at
                    ];  
                    $applied_leave->notifications()->create($notification_data);

                }elseif($value->label == 'Leave Comments'){
                    $message_data = [
                        'sender_id' => $sender->id,
                        'receiver_id' => $receiver->id,
                        'label' => 'Leave Remarks',
                        'read_status' => $value->read_status,
                        'message' => $value->message,
                        'created_at' => $value->created_at,
                        'updated_at' => $value->updated_at
                    ]; 
                    $applied_leave->messages()->create($message_data);
                }
            }            
        }   
        
        echo "leaves created";
    }//end of function
}
