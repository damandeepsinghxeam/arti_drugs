<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use View;
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
use stdClass;
use Validator;
use App\Kra;
use App\TaskPoint;
use App\KraTemplate;
use App\UserManager;
use App\Approval;
use App\BgApproval;
use App\InsuranceApproval;
use App\EmployeeProfile;
use App\ProjectDraft;
use App\ItRequirement;
use Mail;
use App\EmailContent;
use App\Mail\GeneralMail;

class MastertableController extends Controller
{
 
    function itRequirement($action, $project_id = null){
        $user = Auth::user();
        
        if($action == 'edit'){
            $it_req_values = ProjectDraft::where(['id'=>$project_id])->first();
            if($it_req_values){              
                $data['it_req_values'] = unserialize($it_req_values->it_req_data);
            }else{
                $data['it_req_values'] = "";
            }
        }else{
            $data[]="";
        }
        
        return view('mastertables.it_requirement')->with(['data'=>$data]);

    }
    
    function insuranceForm($action, $project_id = null){
        
        $user = Auth::user();
        
        if($action == 'edit'){
            $insurance_values = ProjectDraft::where(['id'=>$project_id])->first();
            if($insurance_values){              
                $data['insurance_values'] = unserialize($insurance_values->insurance_data);
            }else{
                $data['insurance_values'] = "";
            }
        }else{
            $data[]="";
        }
        
        return view('mastertables.insurance_form')->with(['data'=>$data]);
    }
    function bgForm($action, $project_id = null){
        
        $user = Auth::user();
        
        if($action == 'edit'){

            $bg_values = ProjectDraft::where(['id'=>$project_id])->first();

            if($bg_values){             
                $data['bg_values'] = unserialize($bg_values->bg_data);
            }else{
                $data['bg_values'] = "";
            }
            
        }else{
            $data[]="";
        }
        
        return view('mastertables.bg_form')->with(['data'=>$data]);
    }

    //code for projects listing of approval with status 1 in project draft table
    function listApprovalProjects(){
        

        $user = Auth::user();

       $canapprove = auth()->user()->can('approve-project'); 

       $projectsdraft_sent = ProjectDraft::where(['status'=>'1'])
                        ->orderBy('created_at','DESC')
                        ->get(); 

        if($projectsdraft_sent AND !$projectsdraft_sent->isEmpty() AND $canapprove==1){   
            foreach($projectsdraft_sent as $projectsdraft){         
                $project_approval_data_array = unserialize($projectsdraft->project_approval);
                $project_approval_data_array['status'] = $projectsdraft->status;
                $project_approval_data_array['id'] = $projectsdraft->id;
                $project_approval_data_array['creator_id'] = $projectsdraft->creator_id;
                $data[] = $project_approval_data_array;
            }
        }else{
            $data=[];
        }   
     

        return view('mastertables.list_projects')->with(['projects'=>$data, 'approval'=>'1']);

    }


    //code starts for listing of projects that has been approved with status 2 in project draft table and status 1 in project table
    
    function listApprovedProjects()
    {
        $user = Auth::user();

      $projects = Project::where(['approval_status'=>'1'])
                        ->orderBy('created_at','DESC')
                        ->get(); 
     

        return view('mastertables.list_approved_projects')->with(['projects'=>$projects]);

    }//end of function


    //start of code for projects listing for creating drafts
    
    function listProjects(Request $request)
    {          

       
        //$canapprove = auth()->user()->can('approve-project');
        
        $user = Auth::user();

        $query = ProjectDraft::where('creator_id', $user->id);

        if($request->has('project_status') && $request->project_status != 'all'){
            
            if($request->project_status == 3){

                $project_status = '0';
                $query = $query->where(['status'=>$project_status, 'sent_back'=>1]);

            }elseif($request->project_status == 0){

                $project_status = '0';
                $query = $query->where(['status'=>"'".$project_status."'", 'sent_back'=>0]);

            }else{

                $project_status = $request->project_status;
                $query = $query->where('status',$project_status);

            }
           
        }

       $projectsdrafts = $query->orderBy('created_at','DESC')
                        ->get();            
        
        //$projectsdrafts = ProjectDraft::where(['creator_id'=>$user->id,'status'=>'0'])->get();
        //$projectsdraft_sent = ProjectDraft::where(['status'=>'1'])->orWhere(['status'=>'2'])->get();
        
        if($projectsdrafts){
            foreach($projectsdrafts as $projectsdraft){
                $project_approval_data_array = unserialize($projectsdraft->project_approval);
                $project_approval_data_array['status'] = $projectsdraft->status;
                $project_approval_data_array['id'] = $projectsdraft->id;
                $project_approval_data_array['creator_id'] = $projectsdraft->creator_id;
                $data[] = $project_approval_data_array;
            }                                   
            
        }
            
            
        
        if(!isset($data)){
            $data =[];
            //$data=array();
        }

        return view('mastertables.list_projects')->with(['projects'=>$data]);

    }//end of function


    /*
        Send basic email with a generic template    
    */
     function sendGeneralMail($mail_data)
    {   //mail_data Keys => to_email, subject, fullname, message

        if(!empty($mail_data['to_email'])){
            Mail::to($mail_data['to_email'])->send(new GeneralMail($mail_data));
        }

        return true;

    }//end of function

    
    function projectAction(Request $request, $action, $project_id = null)
    {
        if(!empty($project_id)){
            $project = Project::find($project_id);
        }

        
        $user = Auth::user();

        if($action == 'add') {
            
                       
            $data['action'] = $action;
            $data['companies'] = Company::where(['isactive'=>1,'approval_status'=>'1'])->get();
            $data['locations'] = Location::where(['isactive'=>1])->get();
            $data['states'] = State::where(['isactive'=>1])->get();
            $data['employees'] = Employee::where(['isactive'=>1,'approval_status'=>'1'])->get();
            //$data['salary_structures'] = SalaryStructure::where(['isactive'=>1])->get();
            //$data['salary_cycles'] = SalaryCycle::where(['isactive'=>1])->get();
            $data['departments'] = Department::where(['isactive'=>1])->select('id','name')->get();

            $data['proj_documents'] = [];


            return view('mastertables.project_form')->with(['data'=>$data, 'link'=>'add']);
        
        }elseif($action == 'edit'){
            $data['locations'] = Location::where(['isactive'=>1])->get();
            $data['departments'] = Department::where(['isactive'=>1])->select('id','name')->get();
             $project_drafts = ProjectDraft::where(['id'=>$project_id])->first();
            
            if($project_drafts){                
                $data['project_draft_values'] = unserialize($project_drafts->project_approval);
               /* $owner_name = $data['project_draft_values']['project_owner_name'];
                $data['project_draft_values'] = Emloyee::where(['isactive'=>1])->get();
                */
            }else{
                $data['project_draft_values'] = "";
            }
            $data['action'] = $action;
            $data['companies'] = Company::where(['isactive'=>1,'approval_status'=>'1'])->get();
            
            $data['states'] = State::where(['isactive'=>1])->get();
            $data['employees'] = Employee::where(['isactive'=>1,'approval_status'=>'1'])->get();
           //$data['salary_structures'] = SalaryStructure::where(['isactive'=>1])->get();
            //$data['salary_cycles'] = SalaryCycle::where(['isactive'=>1])->get();
            
            $state_val = [];
            $location_val = [];
            foreach($data['states'] as $state){
                
                array_push($state_val,$state->id);
            }
            $data['state_val'] = $state_val;
            
            foreach($data['locations'] as $location){
                
                array_push($location_val,$location->id);
            }
            $data['location_val'] = $location_val;

            $data['counter_bg'] = $project_drafts->bg_counter;
            $data['counter_it'] = $project_drafts->it_counter;
            $data['counter_ins'] = $project_drafts->insurance_counter;
            $data['project_id'] = $project_id;
            $data['status'] = $project_drafts->status;
             
           // print_r(compact($data));exit;

        
            return view('mastertables.project_form')->with(['data'=>$data, 'link'=>'edit']);

        }elseif($action == 'approve'){
            
            //$project->Approval->create(['approver_id'=>$user->id]);
            
            $project_data = [                   
                                'status' => '2'                             
                            ];
            $status_update = ProjectDraft::updateOrCreate(['id' => $project_id, 'status' => '1'], $project_data);
            
            if($status_update){

                $project_drafts = ProjectDraft::where(['id'=>$project_id,'status'=>'2'])->first();

                $project_draft_creator = $project_drafts->creator_id;               

                
                if($project_drafts->project_approval){
                    
                    $project_approval_values = unserialize($project_drafts->project_approval);
                    
                    $tan_no = implode(",",$project_approval_values['tan_number']);
                    $resources_category = implode(",",$project_approval_values['resources_category']);
                    
                        if(!isset($project_approval_values['projectName'])){
                            $project_approval_values['projectName'] ="";
                        }
                        if(!isset($project_approval_values['gst_registration_number'])){
                            $project_approval_values['gst_registration_number'] ="";
                        }
                        if(!isset($project_approval_values['head_office_location']) ){
                            $project_approval_values['head_office_location'] ="";
                        }
                        if(!isset($project_approval_values['head_office_address']) ){
                            $project_approval_values['head_office_address'] ="";
                        }
                        if(!isset($project_approval_values['project_owner_name']) ){
                            $project_approval_values['project_owner_name'] ="";
                        }
                        if(!isset($project_approval_values['contact_person']) ){
                            $project_approval_values['contact_person'] ="";
                        }
                        if(!isset($project_approval_values['corres_office_address'])){
                            $project_approval_values['corres_office_address'] ="";
                        }
                        if(!isset($project_approval_values['agreement_signed'])){
                            $project_approval_values['agreement_signed'] ="";
                        }
                        if(!isset($project_approval_values['agreement_validity']) ){
                            $project_approval_values['agreement_validity'] ="";
                        }
                        if(!isset($project_approval_values['agreement_remarks']) ){
                            $project_approval_values['agreement_remarks'] ="";
                        }
                        if(!isset($project_approval_values['starting_of_project_date']) ){
                            $project_approval_values['starting_of_project_date'] ="";
                        }
                        if(!isset($project_approval_values['contract_period_year'])){
                            $project_approval_values['contract_period_year'] ="";
                        }
                        if(!isset($project_approval_values['contract_period_month']) ){
                            $project_approval_values['contract_period_month'] ="";
                        }
                        if(!isset($project_approval_values['extendable'])){
                            $project_approval_values['extendable'] ="";
                        }
                        if(!isset($project_approval_values['scope']) ){
                            $project_approval_values['scope'] ="";
                        }
                        if(!isset($project_approval_values['tds_deduction'])){
                            $project_approval_values['tds_deduction'] ="";
                        }
                        if(!isset($project_approval_values['bg_security'])){
                            $project_approval_values['bg_security'] ="";
                        }
                        if(!isset($project_approval_values['bg_or_security'])){
                            $project_approval_values['bg_or_security'] ="";
                        }
                        if(!isset($project_approval_values['bg_or_security_amount'])){
                            $project_approval_values['bg_or_security_amount'] ="";
                        }
                        if(!isset($project_approval_values['bg_or_security_submission'])){
                            $project_approval_values['bg_or_security_submission'] ="";
                        }
                        if(!isset($project_approval_values['bg_or_security_to_client'])){
                            $project_approval_values['bg_or_security_to_client'] ="";
                        }
                        if(!isset($project_approval_values['location_state'])){
                            $location_state ="";
                        }else{                            
                             $location_state = implode(",",$project_approval_values['location_state']);
                        }
                        if(!isset($project_approval_values['location_city'])){
                            $location_city ="";
                        }else{
                             $location_city = implode(",",$project_approval_values['location_city']);
                        }
                        if(!isset($project_approval_values['billing_cycle_from'])){
                            $project_approval_values['billing_cycle_from'] ="";
                        }
                        if(!isset($project_approval_values['billing_cycle_to'])){
                            $project_approval_values['billing_cycle_to'] ="";
                        }
                        if(!isset($project_approval_values['salary_payment_date'])){
                            $project_approval_values['salary_payment_date'] ="";
                        }
                        if(!isset($project_approval_values['salary_mode'])){
                            $project_approval_values['salary_mode'] ="";
                        }
                        if(!isset($project_approval_values['esi_applicable'])){
                            $project_approval_values['esi_applicable'] ="";
                        }
                        if(!isset($project_approval_values['epf_applicable'])){
                            $project_approval_values['epf_applicable'] ="";
                        }
                        if(!isset($project_approval_values['gpa_applicable'])){
                            $project_approval_values['gpa_applicable'] ="";
                        }
                        if(!isset($project_approval_values['wc_applicable'])){
                            $project_approval_values['wc_applicable'] ="";
                        }
                        if(!isset($project_approval_values['margin'])){
                            $project_approval_values['margin'] ="";
                        }
                        if(!isset($project_approval_values['security_charges'])){
                            $project_approval_values['security_charges'] ="";
                        }
                        if(!isset($project_approval_values['document_charges'])){
                            $project_approval_values['document_charges'] ="";
                        }
                        if(!isset($project_approval_values['online_application_charges'])){
                            $project_approval_values['online_application_charges'] ="";
                        }
                        if(!isset($project_approval_values['id_card']) ){
                            $project_approval_values['id_card'] ="";
                        }
                        if(!isset($project_approval_values['uniform']) ){
                            $project_approval_values['uniform'] ="";
                        }
                        if(!isset($project_approval_values['offer_letter']) ){
                            $project_approval_values['offer_letter'] ="";
                        }
                        if(!isset($project_approval_values['tic_or_Medical_insurance'])){
                            $project_approval_values['tic_or_Medical_insurance'] ="";
                        }
                        if(!isset($project_approval_values['additional_obligations']) ){
                            $project_approval_values['additional_obligations'] ="";
                        }
                        if(!isset($project_approval_values['approval_status']) ){
                            $project_approval_values['approval_status'] ="1";
                        }
                         if(!isset($project_approval_values['xeam_client']) ){
                            $project_approval_values['xeam_client'] ="";
                        }
                        
                    
                    $project_approval_data =  [
                                            'creator_id' => $project_draft_creator,
                                            'name' => $project_approval_values['projectName'],
                                            'gst_number' => $project_approval_values['gst_registration_number'],
                                            'tan_number' => $tan_no,
                                            'h_o_location' => $project_approval_values['head_office_location'],
                                            'h_o_address' => $project_approval_values['head_office_address'],                       
                                            'project_owner_dep_id' => 1,
                                            'project_owner' => $project_approval_values['project_owner_name'],
                                            'contact_person_name' => $project_approval_values['contact_person'],
                                            'official_address' => $project_approval_values['corres_office_address'],
                                            'agreement_signed' => $project_approval_values['agreement_signed'],
                                            'agreement_validity' => $project_approval_values['agreement_validity'],
                                            'agreement_remark' => $project_approval_values['agreement_remarks'],
                                            'project_start_date' => $project_approval_values['starting_of_project_date'],
                                            'tenure_years' => $project_approval_values['contract_period_year'],
                                            'tenure_months' => $project_approval_values['contract_period_month'],
                                            'extendable' => $project_approval_values['extendable'],
                                            'scope' => $project_approval_values['scope'],
                                            'tds_deduct' => $project_approval_values['tds_deduction'],
                                            'security_required' => $project_approval_values['bg_security'],
                                            'security_type' => $project_approval_values['bg_or_security'],
                                            'security_amount' => $project_approval_values['bg_or_security_amount'],
                                            'security_status' => $project_approval_values['bg_or_security_submission'],
                                            'security_valadity' => $project_approval_values['bg_or_security_to_client'],
                                            'project_location_state' => $location_state,
                                            'project_location_city' => $location_city,
                                            'resource_category' => $resources_category,
                                            'billing_cycle_from' => $project_approval_values['billing_cycle_from'],
                                            'billing_cycle_to' => $project_approval_values['billing_cycle_to'],
                                            'salary_date' => $project_approval_values['salary_payment_date'],
                                            'salary_mode' => $project_approval_values['salary_mode'],
                                            'esi_apply' => $project_approval_values['esi_applicable'],
                                            'epf_apply' => $project_approval_values['epf_applicable'],
                                            'gpa_apply' => $project_approval_values['gpa_applicable'],
                                            'wc_apply' => $project_approval_values['wc_applicable'],
                                            'margin' => $project_approval_values['margin'],                     
                                            'security_charges' => $project_approval_values['security_charges'],
                                            'document_charges' => $project_approval_values['document_charges'],
                                            'online_app_charges' => $project_approval_values['online_application_charges'],
                                            'id_card' => $project_approval_values['id_card'],
                                            'uniform' => $project_approval_values['uniform'],
                                            'offer_letter' => $project_approval_values['offer_letter'],
                                            'insurance' => $project_approval_values['tic_or_Medical_insurance'],
                                            'additional_obligations' => $project_approval_values['additional_obligations'],
                                            'approval_status' => $project_approval_values['approval_status'],
                                            'xeam_client' => $project_approval_values['xeam_client'],           
                                        ];

                            $project_approval = Project::create($project_approval_data); 
                }
                
                if($project_approval){                          
                    
                     $id = $project_approval->id;
                    
                    $document_category = DocumentCategory::where(['name'=>'Project'])->first();
                    $documents = $document_category->documents()->orderBy('id')->get();
                    
                    if(isset($project_approval_values['agreement_with_customer'])) {                
                        $name = $project_approval_values['agreement_with_customer'];
                    }else{
                        $name = "";
                    }
                    $agreement_file_entry = DB::table('document_project')->insert(
                                                ['project_id' => $id, 'document_id' => $documents[0]->id, 'name'=> $name]
                                            ); 
                    
                    if(isset($project_approval_values['offer_letter_format'])) {                
                        $name = $project_approval_values['offer_letter_format'];
                    }else{
                        $name = "";
                    }
                    $offer_letter_format_entry = DB::table('document_project')->insert(
                                                    ['project_id' => $id, 'document_id' => $documents[1]->id, 'name'=> $name]
                                                ); 
                                                
                    if(isset($project_approval_values['proposed_agreement'])) {                
                        $name = $project_approval_values['proposed_agreement'];
                    }else{
                        $name = "";
                    }
                    $proposed_agreement_entry = DB::table('document_project')->insert(
                                                    ['project_id' => $id, 'document_id' => $documents[2]->id, 'name'=> $name]
                                                );                      
                        
                    if($project_drafts->bg_data){
                        
                        $bg_values = unserialize($project_drafts->bg_data);
                        
                        $bg_approval_data = [
                                                'project_id' => $id,
                                                'tender_name' => $bg_values['tender_name'],
                                                'form' => $bg_values['form_type'],
                                                'amount' => $bg_values['amount'],
                                                'in_favour' => $bg_values['in_favour_of'],
                                                'date_required' => $bg_values['required_date'],                     
                                                'bg_valadity_date' => $bg_values['validity_date'],
                                                'margin_percentage' => $bg_values['margin_value'],
                                                'bg_charges_percentage' => $bg_values['bg_charges_value'],
                                                'gst_percentage' => $bg_values['gst_value'],
                                                'margin' => $bg_values['margin'],
                                                'bg_charges' => $bg_values['bg_charges'],
                                                'gst' => $bg_values['gst'],                     
                                                'total' => $bg_values['total_charges']
                                            ];
                        $bg_approval = BgApproval::create($bg_approval_data); 
                    }
                    
                    
                    
                    if($project_drafts->insurance_data){
                        
                        $insurance_values = unserialize($project_drafts->insurance_data);
                        
                        $person = implode(",",$insurance_values['person']);
                        $amount = implode(",",$insurance_values['amount']);
                        $remark = implode(",",$insurance_values['remark']);
                        $insurance_approval_data = [
                                                'project_id' => $id,
                                                'tender_name' => $insurance_values['tender_name'],
                                                'insurance_type' => $insurance_values['insurance_type'],
                                                'insurance_text' => $insurance_values['insurance_text'],
                                                'insurance_plan' => $insurance_values['insurance_plan'],
                                                'premium_amount' => $insurance_values['total_premium_amount'],
                                                'in_favor' => $insurance_values['in_favour_of'],                        
                                                'date_required' => $insurance_values['required_date'],
                                                'peers_no' => $insurance_values['number_of_peers_or_lives'],
                                                'peers_note' => $insurance_values['extra_note'],
                                                'expense_borne_by' => $insurance_values['expense_borne'],
                                                'project_margin_percentage' => $insurance_values['project_margin_percentage'],
                                                'project_margin_amount' => $insurance_values['project_margin_amount'],
                                                'tenure_years' => $insurance_values['project_tenure_year'],                     
                                                'tenure_months' => $insurance_values['project_tenure_month'],
                                                'invoice_no' => $insurance_values['invoice_number'],
                                                'person' => $person,                        
                                                'amount' => $amount,
                                                'remark' => $remark                                                 
                                            ];
                        $insurance_approval = InsuranceApproval::create($insurance_approval_data); 
                    }


                    if($project_drafts->it_req_data){
                        
                        $it_req_values = unserialize($project_drafts->it_req_data);
                        
                        
                        $content = implode(",",$it_req_values['content']);

                        if(isset($it_req_values['naukri_quantity']) AND ($it_req_values['naukri_quantity']!="")){
                            $naukri_quantiy = $it_req_values['naukri_quantity'];
                        }else{
                            $naukri_quantiy = "";
                        }

                        if(isset($it_req_values['naukri_cost']) AND ($it_req_values['naukri_cost']!="")){
                            $naukri_cost = $it_req_values['naukri_cost'];
                        }else{
                            $naukri_cost = "";
                        }

                        if(isset($it_req_values['xeam_job_quantity']) AND ($it_req_values['xeam_job_quantity']!="")){
                            $xeam_job_quantity = $it_req_values['xeam_job_quantity'];
                        }else{
                            $xeam_job_quantity = "";
                        }

                        if(isset($it_req_values['xeam_job_cost']) AND ($it_req_values['xeam_job_cost']!="")){
                            $xeam_job_cost = $it_req_values['xeam_job_cost'];
                        }else{
                            $xeam_job_cost = "";
                        }

                        if(isset($it_req_values['monster_quantity']) AND ($it_req_values['monster_quantity']!="")){
                            $monster_quantity = $it_req_values['monster_quantity'];
                        }else{
                            $monster_quantity = "";
                        }

                        if(isset($it_req_values['monster_cost']) AND ($it_req_values['monster_cost']!="")){
                            $monster_cost = $it_req_values['monster_cost'];
                        }else{
                            $monster_cost = "";
                        }

                        if(isset($it_req_values['naukri_check']) AND ($it_req_values['naukri_check']!="")){
                            $naukri_check = $it_req_values['naukri_check'];
                        }else{
                            $naukri_check = "";
                        }

                        if(isset($it_req_values['xeam_job_check']) AND ($it_req_values['xeam_job_check']!="")){
                            $xeam_job_check = $it_req_values['xeam_job_check'];
                        }else{
                            $xeam_job_check = "";
                        }

                        if(isset($it_req_values['monster_check']) AND ($it_req_values['monster_check']!="")){
                            $monster_check = $it_req_values['monster_check'];
                        }else{
                            $monster_check = "";
                        }
                        
                       
                        $it_req_data = [
                                                'project_id' => $id,
                                                'sms' => $it_req_values['sms'],
                                                'sms_no' => $it_req_values['number_of_sms'],
                                                'email' => $it_req_values['email'],
                                                'email_no' => $it_req_values['number_of_email'],
                                                'jrf' => $it_req_values['jrf'],
                                                'takeover' => $it_req_values['takeover'],                        
                                                'naukri_check' => $naukri_check,
                                                'naukri_quantity' => $naukri_quantiy,
                                                'naukri_cost' => $naukri_cost,
                                                'xeam_job_check' => $xeam_job_check,
                                                'xeam_job_quantity' => $xeam_job_quantity,
                                                'xeam_job_cost' => $xeam_job_cost,
                                                'monster_check' => $monster_check,                     
                                                'monster_quantity' => $monster_quantity,
                                                'monster_cost' => $monster_cost,
                                                'content' => $content,                        
                                                                                              
                                            ];
                        $it_req = ItRequirement::create($it_req_data); 
                    }
                }

                ///////////////////notify/////////////////////////

                $notification_data = [
                                 'sender_id' => $user->id,
                                 'receiver_id' => $project_draft_creator,
                                 'label' => 'Project Approved',
                                 'read_status' => '0'
                             ]; 
                $notification_data['message'] = $project_approval_values['projectName']." has been approved."; 
                
                pushNotification($notification_data['receiver_id'], $notification_data['label'], $notification_data['message']);

                $mail_data = array();
                $project_creator = Employee::where(['user_id'=>$project_draft_creator])
                                ->with('user')->first();
                $mail_data['to_email'] = $project_creator->user->email;
                $mail_data['subject'] = "Project Approved";
                $mail_data['message'] = $project_approval_values['projectName']." has been approved."; 
                $mail_data['fullname'] = $project_creator->fullname;
                //$this->sendGeneralMail($mail_data);
                
            }
            
           return redirect("mastertables/approval-projects"); 

        }elseif($action == 'reject'){
            

        
            $project_drafts = ProjectDraft::where(['id'=>$project_id,'status'=>'1'])->first();

            $project_draft_creator = $project_drafts->creator_id;

            $project_approval_values = unserialize($project_drafts->project_approval);
            

            if(isset($project_approval_values['send_back_reason'])  AND is_array($project_approval_values['send_back_reason'])){

                array_push($project_approval_values['send_back_reason'], $request->reason);

            }else{

                $project_approval_values['send_back_reason'] = array($request->reason);
            }  
            
            //$project->Approval->create(['approver_id'=>$user->id]);
            
            $project_data = [   
                                'project_approval' => serialize($project_approval_values),          
                                'status' => '0',
                                'sent_back' => 1                            
                            ];
            ProjectDraft::updateOrCreate(['id' => $project_id, 'status' => '1'], $project_data);


            ///////////////////notify/////////////////////////

            $notification_data = [
                             'sender_id' => $user->id,
                             'receiver_id' => $project_draft_creator,
                             'label' => 'Project sent back',
                             'read_status' => '0'
                         ]; 
            $notification_data['message'] = $project_approval_values['projectName']." has not been approved. It is sent back"; 
            
            pushNotification($notification_data['receiver_id'], $notification_data['label'], $notification_data['message']);

            $mail_data = array();
            $project_creator = Employee::where(['user_id'=>$project_draft_creator])
                            ->with('user')->first();
            $mail_data['to_email'] = $project_creator->user->email;
            $mail_data['subject'] = "Project not Approved";
            $mail_data['message'] = $project_approval_values['projectName']." has not been approved. It is sent back. Please correct it."; 
            $mail_data['fullname'] = $project_creator->fullname;
            //$this->sendGeneralMail($mail_data);

            return redirect("mastertables/approval-projects"); 

        }elseif($action == 'activate'){

            $project->isactive = 1;
            
            $project->save();

            //return redirect("mastertables/approval-projects");      

            return redirect()->back();

        }elseif($action == 'show'){
            
            $data['project_approval'] = Project::where(['id'=>$project_id, 'approval_status'=>'1'])
                                                ->first(); 
            $dep_id = $data['project_approval']->project_owner_dep_id;
            $state_id = $data['project_approval']->project_location_state;
            $city_id = $data['project_approval']->project_location_city;

            $data['project_approval']->state = State::where(['id'=>$state_id])->select('id','name')->get();
            $data['project_approval']->city = Location::where(['id'=>$city_id])->get();
            $data['project_approval']->department = Department::where(['id'=>$dep_id])->select('id','name')->first();
             
                                                
            $data['bg_data']= BgApproval::where(['project_id'=>$project_id])
                                                ->first(); 
            $data['it_data']= ItRequirement::where(['project_id'=>$project_id])                                               
                                                ->first(); 
            $data['ins_data']= insuranceApproval::where(['project_id'=>$project_id])
                                                ->first(); 
            $data['files']= DB::table('document_project')->where('project_id', $project_id)->get();                                   

            //return $data['it_data'];

            return view('mastertables.show_project_detail')->with(['projects'=>$data]);

        }elseif($action == 'show_projectDraft'){
            
            $data['locations'] = Location::where(['isactive'=>1])->get();
            
            $canapprove = auth()->user()->can('approve-project');

            if($canapprove==1){

                 $project_drafts = ProjectDraft::where(['id'=>$project_id, 'status'=>'1'])->first();

            }else{

                 $project_drafts = ProjectDraft::where(['id'=>$project_id, 'status'=>'0'])->first();

            }
            
            
            
            if($project_drafts){                
                $data['project_approval'] = unserialize($project_drafts->project_approval);

                $dep_id = $data['project_approval']['project_owner_department'];
                $data['project_approval']['departments'] = Department::where(['id'=>$dep_id])->select('id','name')->first();

                $project_location_state = $data['project_approval']['location_state'];
                $project_location_city = $data['project_approval']['location_city'];
                $data['project_approval']['states'] = State::whereIn('id', $project_location_state)->select('id','name')->get();
                $data['project_approval']['cities'] = Location::whereIn('id', $project_location_city)->select('id','name')->get();

                $data['bg_data'] = unserialize($project_drafts->bg_data);
                $data['it_data'] = unserialize($project_drafts->it_req_data);
                $data['ins_data'] = unserialize($project_drafts->insurance_data);


               /* $owner_name = $data['project_draft_values']['project_owner_name'];
                $data['project_draft_values'] = Emloyee::where(['isactive'=>1])->get();
                */
            }else{
                $data['project_draft_values'] = "";
            }            
//return $data;
            return view('mastertables.show_project_draft_detail')->with(['projects'=>$data]);

        }elseif($action == 'deactivate'){
            $project->isactive = 0;
            $project->save();

            return redirect()->back();
            
        }
    }//end of function


    function saveProject(Request $request)
    {
    
        $user = Auth::user();
        
        $user_id = $user->id;
        $counter =0;
        
        if($request->save_as_draft_project_approval){

       //$inputs = $request->all();    
           /* echo"<PRE>";
             print_r($inputs);
             exit;*/

            $request->validate([
                'projectName' => 'required',
                'gst_registration_number' => 'required',
               'tan_number' => 'required',
                'head_office_location' => 'required',
                'head_office_address' => 'required',
                'project_owner_department' => 'required',
                'project_owner_name' => 'required',
                'contact_person' => 'required',
                'corres_office_address' => 'required',
                'agreement_signed' => 'required',
                'starting_of_project_date' => 'required',
                'contract_period_year' => 'required',
                'contract_period_month' => 'required',
                'extendable' => 'required',
                'scope' => 'required',
                'tds_deduction' => 'required',
                'bg_security' => 'required',
                //'bg_or_security' => 'required',
                //'bg_or_security_amount' => 'required',
                //'bg_or_security_submission' => 'required',
                //'bg_or_security_to_client' => 'required',
               
               'location_state' => 'required',
                'location_city' => 'required',
                
                'resources_category' => 'required',
                'billing_cycle_from' => 'required',
                'billing_cycle_to' => 'required',
                'salary_payment_date' => 'required',
                'salary_mode' => 'required',
                'esi_applicable' => 'required',
                'epf_applicable' => 'required',
                'gpa_applicable' => 'required',
                'wc_applicable' => 'required',
                'margin' => 'required',
                'security_charges' => 'required',
                'document_charges' => 'required',
                'online_application_charges' => 'required',
                'id_card' => 'required',
                'uniform' => 'required',
                'offer_letter' => 'required',
                'tic_or_Medical_insurance' => 'required',

                'additional_obligations' => 'required'                

            ]);
            
            
            if($request->agreement_with_customer OR $request->proposed_agreement OR $request->offer_letter_format){

                $inputs = $request->except(['agreement_with_customer', 'proposed_agreement', 'offer_letter_format']);
            }else{

                 $inputs = $request->all();
            }

             
             

            if($request->hasFile('agreement_with_customer')) {
                $file = 'agreement_with_customer'.time().'.'.$request->file('agreement_with_customer')->getClientOriginalExtension();
                $request->file('agreement_with_customer')->move(config('constants.uploadPaths.uploadProjectDocument'), $file);
            
                $document_data['name1'] = $file;
                $inputs['agreement_with_customer'] = $document_data['name1'];
            }else{
                $document_data['name1'] = "";
            }

            
            
            if($request->hasFile('proposed_agreement')) {
                $file = 'proposed_agreement'.time().'.'.$request->file('proposed_agreement')->getClientOriginalExtension();
                $request->file('proposed_agreement')->move(config('constants.uploadPaths.uploadProjectDocument'), $file);
            
                $document_data['name2'] = $file;
                $inputs['proposed_agreement'] = $document_data['name2'];
            }else{
                $document_data['name2'] = "";
            } 
            
            
            if($request->hasFile('offer_letter_format')) {
                $file = 'offer_letter_format'.time().'.'.$request->file('offer_letter_format')->getClientOriginalExtension();
                $request->file('offer_letter_format')->move(config('constants.uploadPaths.uploadProjectDocument'), $file);
            
                $document_data['name3'] = $file;
                $inputs['offer_letter_format'] = $document_data['name3'];
            }else{
                $document_data['name3'] = "";
            } 
            
        
            $arr = serialize($inputs);          
            $project_data = [ 
                    
                    'project_approval' => $arr, 
                    'creator_id' => $user_id,
                    'status' => '0'
                    
                ];
                if($request->project_id){

                    $project_id = $request->project_id;
                    $projectDrafts = ProjectDraft::where('id', $project_id)
                                ->update([
                                            'project_approval' => $arr
                                        ]);
                  
                   return redirect('mastertables/projects/edit/'.$project_id)->with('success','Project draft has been updated successfully.');
                }else{

                    //$project_id = "";
                    $projectDrafts = ProjectDraft::create($project_data);
                    //$projectDrafts = ProjectDraft::updateOrCreate(['creator_id' => $user_id, 'status' => '0'], $project_data);
                    
                    return redirect('mastertables/projects/edit/'.$projectDrafts->id)->with('success','Project has been saved as draft successfully.');
                }
                
            

            //$projectDrafts = ProjectDraft::updateOrCreate(['id' => $project_id, 'creator_id' => $user_id, 'status' => '0'], $project_data);
            //return redirect("mastertables/projects");
            
            
        }
        
        if($request->save_as_draft_bg){

            $request->validate([
                'tender_name' => 'required',
                'form_type' => 'required',
                'amount' => 'required',
                'in_favour_of' => 'required',
                'required_date' => 'required',
                'validity_date' => 'required',
                'margin_value' => 'required',
                'margin' => 'required',
                'bg_charges_value' => 'required',
                'bg_charges' => 'required',
                'gst_value' => 'required',
                'gst' => 'required',
                'total_charges' => 'required'                

            ]);

            $arr = serialize($request->all());

             if($request->project_id){

                    $project_id = $request->project_id;
                    $counter++;

                    $projectDrafts = ProjectDraft::where('id', $project_id)
                                ->update([
                                            'bg_data' => $arr,
                                            'bg_counter' => $counter
                                        ]);
                  return redirect("mastertables/projects/edit/$project_id");              
                    
                }else{



                    //$project_id = "";
                    //$projectDrafts = ProjectDraft::updateOrCreate([ 'creator_id' => $user_id, 'status' => '0'], ['bg_data' => $arr, 'bg_counter'=>$counter]);
                }
            

            return redirect("mastertables/projects/edit/$projectDrafts->id");
        }
        
        if($request->save_as_draft_insurance){
            
             $request->validate([
                'tender_name' => 'bail|required|unique:projects,name',
                'insurance_type' => 'required',
                'insurance_text' => 'required',
                'insurance_plan' => 'required',
                'total_premium_amount' => 'required',
                'in_favour_of' => 'required',
                'required_date' => 'required',
                'number_of_peers_or_lives' => 'required',
                'extra_note' => 'required',
                'expense_borne' => 'required',
                'project_margin_percentage' => 'required',
                'project_margin_amount' => 'required',
                'project_tenure_year' => 'required' ,   
                'project_tenure_month' => 'required',
                'invoice_number' => 'required',
                'person' => 'required',
                'amount' => 'required',
                'remark' => 'required'                            

            ]);

            $arr = serialize($request->all());

             if($request->project_id){

                    $project_id = $request->project_id;
                    $counter++;
                    $projectDrafts = ProjectDraft::where('id', $project_id)
                                ->update([
                                            'insurance_data' => $arr,
                                            'insurance_counter' => $counter
                                        ]);

                    return redirect("mastertables/projects/edit/$project_id");             
                }else{

                    $project_id = "";
                    //$projectDrafts = ProjectDraft::updateOrCreate(['creator_id' => $user_id, 'status' => '0'], ['insurance_data' => $arr, 'insurance_counter'=>$counter]);
                }        
            
               // return redirect("mastertables/projects/edit/$projectDrafts->id");
            
        }

        if($request->save_as_draft_it_req){

            $request->validate([
                'sms' => 'required',
                //'number_of_sms' => 'required',
                'email' => 'required',
                //'number_of_email' => 'required',
                'jrf' => 'required',
                'takeover' => 'required',
                /*'naukri_check' => 'required',
                'naukri_quantity' => 'required',
                'naukri_cost' => 'required',
                'xeam_job_check' => 'required',
                'xeam_job_quantity' => 'required',
                'xeam_job_cost' => 'required',
                'monster_check' => 'required' ,   
                'monster_quantity' => 'required',
                'monster_cost' => 'required',*/
                'content' => 'required'
            ]);
           
            $arr = serialize($request->all());

             if($request->project_id){

                    $project_id = $request->project_id;                    
                    $counter++;
                    $projectDrafts = ProjectDraft::where('id', $project_id)
                                ->update([
                                            'it_req_data' => $arr,
                                            'it_counter' => $counter
                                        ]);
                    return redirect("mastertables/projects/edit/$project_id");                                        
                   
                }else{

                    //$project_id = "";
                    //$projectDrafts = ProjectDraft::updateOrCreate(['creator_id' => $user_id, 'status' => '0'], ['it_req_data' => $arr, 'it_counter'=>$counter]);

                    //return redirect("mastertables/projects/edit/$projectDrafts->id");
                }

        
          
            
        }
        
        if($request->save){
            
            $user = Auth::user();

              if($request->project_id){

                     $project_id = $request->project_id;                   
                   
                }else{

                    $project_id = "";
                }

            /*$project_data = [                   
                                'status' => '1'                             
                            ];
            $projectDrafts = ProjectDraft::updateOrCreate(['id' => $project_id, 'status' => '0'], $project_data);*/

             $projectDrafts = ProjectDraft::where('id', $project_id)
                                ->update([
                                           
                                            'status' => '1'
                                        ]);

             ///////////////////notify/////////////////////////

              /*  $notification_data = [
                                 'sender_id' => $user->id,
                                 'receiver_id' => 13,
                                 'label' => 'Project Approval',
                                 'read_status' => '0'
                             ]; 
                $notification_data['message'] = $project_approval_values['projectName']." has been sent for approval."; 
                
                pushNotification($notification_data['receiver_id'], $notification_data['label'], $notification_data['message']);

                $mail_data = array();
                $project_approver = Employee::where(['user_id'=>13])
                                ->with('user')->first();
                $mail_data['to_email'] = $project_approver->user->email;
                $mail_data['subject'] = "Project Approval";
                $mail_data['message'] = $project_approval_values['projectName']." has been sent for approval."; 
                $mail_data['fullname'] = $project_approver->fullname;*/
                //$this->sendGeneralMail($mail_data);
            
            return redirect("mastertables/projects");
        }
        return redirect("mastertables/projects/edit/$request->projectId");   
              

    }//end of function 
    
    
    function departmentsWisePersons(Request $request)
    {
        $department_id = $request->DepartmentId;

       $result['persons'] =  DB::table('employees as e')

                ->join('employee_profiles as ep','e.user_id','=','ep.user_id')

                ->join('users as u','e.user_id','=','u.id')

                ->where('ep.department_id',$department_id)

                ->where(['e.approval_status'=>'1','e.isactive'=>1,'ep.isactive'=>1])

                ->select('e.user_id','e.fullname','u.employee_code')

                ->get(); 

        return $result;

    }//end of function


     function kraAction($action,$id = null)
    {

         if($action == "add"){

            $data['action'] = $action;
            
            $data['departments'] = Department::where(['isactive'=>1])->select('id','name')->get();
            
            $data['tasks'] = TaskPoint::get();
            return view('mastertables.add_kra_form')->with(['data'=>$data]);
         }
         if($action == "delete"){
             
              $del_kra = Kra::where('id',$id)->delete();
              $del_kra_indicator = KraTemplate::where('kra_id',$id)->delete();
            
            if($del_kra) {
                return redirect('mastertables/kra'); 
                
            }        
             
         }

    }
    
    function createKra(Request $request)
    {
       
        $user = Auth::user();
        $kra_type_data_exist = Kra::where(['dep_id' => $request->department, 'name' => $request->kra_name])->get();
        
        $kra_type_data = [
                            'dep_id' => $request->department,
                            'name' => $request->kra_name
                         ];
        
        if(!$kra_type_data_exist->isEmpty()){
            $kra_type = "";
            return redirect("mastertables/kra")->with('kraexists',"KRA already exists.");
        }else{
             $kra_type = Kra::create($kra_type_data); 
        }
                

        if(is_array($request->Full_name) && is_array($request->frequency))
        {
            for($i=0;$i<count($request->Full_name); $i++){

            $kra_data = [   
                            'name' => $request->Full_name[$i],
                            'kra_id' => $kra_type->id,
                            'frequency' => $request->frequency[$i],
                            'activation_date' => $request->activation_date[$i],
                            'deadline_date' => $request->deadline[$i],
                            'priority' => $request->priority[$i],
                            
                        ];
            $kra = KraTemplate::create($kra_data); 
            
            }
        }
        
        return redirect('mastertables/kra');  
               
    }//end of function

    function editKraDetails(Request $request)
    {
        if($request->delete_indicator_id!="")
        {           
            $message = '';

            $del_id=$request->delete_indicator_id;

            $del_info=KraTemplate::where('id',$del_id)->delete();
            
            if($del_info) {
                return response()->json(['status'=>'1', 'msg'=>'KRA entry deleted successfully']);
                
            } else {
                 return response()->json(['status'=>'0', 'msg'=>'KRA entry deletion failed']);
            }           

        }
        
        if($request->kra_id!="")
        {                     
            Kra::where('id', $request->kra_id[0])
                ->update([  
                        'dep_id'=>$request->department,
                        'name'=>$request->kra_name[0]                   
                        ]);             
        
            $i = 0;
            
            if(isset($request->indicator_id) && is_array($request->indicator_id)){
                for($i=0;$i<count($request->indicator_id); $i++)
                {  
                    KraTemplate::where('id', $request->indicator_id[$i])
                        ->update([                      
                                'name'=>$request->kra_indicator_name[$i],
                                'kra_id'=>$request->kra_id[0],
                                'frequency'=>$request->kra_frequency[$i],
                                'activation_date'=>$request->kra_activation_date[$i],
                                'deadline_date'=>$request->kra_deadline_date[$i],
                                'priority'=>$request->kra_priority[$i]                      
                                ]);    
                }
            }
            
            if(!empty($request->added_name) && !empty($request->added_frequency) && !empty($request->added_activation_date) && !empty($request->added_deadline) && !empty($request->added_priority)){           

                for($j=0;$j<count($request->added_name); $j++)
                {               
                    $kra_Template = new KraTemplate;
                    $kra_Template->name = $request->added_name[$j];
                    $kra_Template->kra_id = $request->kra_id[0];
                    $kra_Template->frequency = $request->added_frequency[$j];
                    $kra_Template->activation_date = $request->added_activation_date[$j];
                    $kra_Template->deadline_date = $request->added_deadline[$j];
                    $kra_Template->priority = $request->added_priority[$j];
                    $kra_Template->save();

                }
            }
            
            
            
            return redirect("mastertables/kra")->with('kraedited',"Details saved successfully."); 

        }
    }

    function listKra(Request $request){ 


        if($request->kra_id){

            $template_id = $request->kra_id;
            $get_kra_indicators = Kra::where(['id' => $template_id])
                                    ->with('kraTemplates')
                                    ->get();
            $departments = Department::where(['isactive'=>1])->select('id','name')->get();

            return view('mastertables.list_kra_indicators')->with(['kra_indicators'=>$get_kra_indicators, 'departments'=>$departments]);
           
        }  
              
         if(empty($request->department_id)){
            $req['department_id'] = "";
        }else{
            $req['department_id'] = $request->department_id;
        }
        if(!empty($request->department_id)){
            $kra_templates = Kra::with('kraTemplates')
                            ->where(['dep_id' => $request->department_id])
                            ->get();
        }else{
             $kra_templates = Kra::with('kraTemplates')
                            ->with('Department')
                            ->get();
        }
//$kra_templates = array();
             
        $departments = Department::where(['isactive'=>1])->select('id','name')->get();
        return view('mastertables.list_kra')->with(['kra_templates'=>$kra_templates, 'departments'=>$departments, 'req'=>$req]);

    }



    /*
        Get the list of companies from the database & show it on a page
    */
    function listCompanies()
    {   
		$companies = Company::with('creator.employee:id,user_id,fullname')
        					->with('approval.approver.employee:id,user_id,fullname')
        					->orderBy('created_at','DESC')
        					->get();	 
				       
        return view('mastertables.list_companies')->with(['companies'=>$companies]);

    }//end of function

    /*
        Perform the respective action if user performs add/edit/approve/activate/deactivate a company
    */
    function companyAction($action,$company_id = null)
    {
    	$user = Auth::user();

    	if(!empty($company_id)){
    		$company = Company::find($company_id);
    	}

        if($action == "add"){

            $data['action'] = $action;

            return view('mastertables.add_company_form')->with(['data'=>$data]);

        }elseif($action == "edit"){

            $data['company'] = $company;
            $data['action'] = $action;

            return view('mastertables.edit_company_form')->with(['data'=>$data]);

        }elseif($action == "approve"){

            $company->approval()->create(['approver_id'=>$user->id]);
            $company->update(['approval_status'=>'1']);

            return redirect("mastertables/companies");

        }elseif($action == "activate") {
           
            $company->update(['isactive'=>1]);
            
            return redirect("mastertables/companies");

        }elseif($action == "deactivate") {

			$company->update(['isactive'=>0]);
            
            return redirect("mastertables/companies");

        }

    }//end of function 

    /*
        Ajax request to check whether the given company parameters are unique while adding/editing
        the company
    */
    function checkUniqueCompany(Request $request)
    {
    	$result = 	[
                    	'company_name' => 1,
                    	'company_phone' => 1,
                    	'company_pf_acc' => 1,
                    	'tan_no' => 1,
                    	'company_email' => 1
                    ];

        if(!empty($request->company_name)){
            $company = Company::where(['name' => $request->company_name])->first();

            if(!empty($company)){
                $result['company_name'] = 0;
            }

        }else{
            $result['company_name'] = 2;

        }

        if(!empty($request->company_phone)){
            $company = Company::where(['phone' => $request->company_phone])->first();

            if(!empty($company)){
                $result['company_phone'] = 0;
            }

        }else{
            $result['company_phone'] = 2;

        }

        if(!empty($request->company_pf_acc)){
        	$company = Company::where(['pf_account_number' => $request->company_pf_acc])->first();
          
            if(!empty($company)){
                $result['company_pf_acc'] = 0;
            }

        }else{
            $result['company_pf_acc'] = 2;

        }

        if(!empty($request->company_email)){
        	$company = Company::where(['email' => $request->company_email])->first();

            if(!empty($company)){
                $result['company_email'] = 0;
            }

        }else{
            $result['company_email'] = 2;

        }

        if(!empty($request->tan_no)){
        	$company = Company::where(['tan_number' => $request->tan_no])->first();
            
            if(!empty($company)){
                $result['tan_no'] = 0;
            }

        }else{
            $result['tan_no'] = 2;

        }

        return $result;
        
    }//end of function

    /*
        Ajax request to check whether the given ESI number is unique 
    */
    function checkUniqueEsiRegistration(Request $request)
    {
    	$result = ['esi_number' => 1];

        if(!empty($request->esi_number)){
            $esi = EsiRegistration::where(['esi_number' => $request->esi_number])->first();

            if(!empty($esi)){
                $result['esi_number'] = 0;
            }

        }else{
            $result['esi_number'] = 2;

        }

        return $result;

    }//end of function

    /*
        Ajax request to check whether the given PT Registration certificate number/PTO circle number are unique 
    */
    function checkUniquePtRegistration(Request $request)
    {
    	$result = ['certificate_number' => 1, 'pto_circle_number' => 1];

        if(!empty($request->certificate_number)){
            $pt = PtRegistration::where(['certificate_number' => $request->certificate_number])->first();

            if(!empty($pt)){
                $result['certificate_number'] = 0;
            }
        }

        if(!empty($request->pto_circle_number)){
			$pt = PtRegistration::where(['pto_circle_number' => $request->pto_circle_number])->first();

            if(!empty($pt)){
                $result['pto_circle_number'] = 0;
            }
        }

        return $result;

    }//end of function

    /*
        Save new company details to the database 
    */
    function createCompany(Request $request)
    {
    	$request->validate([
            'company_name' => 'bail|required|max:40',
            'company_address' => 'required',
            'company_phone_number' => 'bail|required|min:10',
            'company_email' => 'bail|required|email',
            'pf_account_number' => 'required',
            'tan_number' => 'required'
        ]);

        $user = Auth::user();

        $company_data = [   
		                    'name' => $request->company_name,
		                    'address' => $request->company_address,
		                    'phone' => $request->company_phone_number,
		                    'email' => $request->company_email,
		                    'website' => $request->company_website,
		                    'creator_id' => $user->id,   
		                    'tan_number' => $request->tan_number,
		                    'pf_account_number' => $request->pf_account_number,
		                    'responsible_person' => $request->responsible_person,
		                    'phone_extension' => $request->company_phone_extension,
		                    'dbf_file_code' => $request->dbf_file_code,
		                    'extension' => $request->extension,
		                    'approval_status' => '0',
		                ];

        $company = Company::create($company_data);             

        $approver = User::where('id','!=',1)
        				->permission('approve-company')
        				->first();

        if(!empty($approver)){
        	$notification_data = [
        							 'sender_id' => $user->id,
        							 'receiver_id' => $approver->id,
        							 'label' => 'Company Created',
        							 'read_status' => '0'
        						 ]; 

        	$notification_data['message'] = 'Please verify and approve the details of '.$company->name.' company.';	

        	$company->notifications()->create($notification_data);		 
        }

        return redirect('mastertables/companies');	
               
    }//end of function

    /*
        Update company details in the database & keep a log as well
    */
    function editCompany(Request $request)
    {
        $request->validate([
            'company_name' => 'bail|required|max:40',
            'company_address' => 'required',
            'company_phone_number' => 'bail|required|min:10',
            'company_email' => 'bail|required|email',
            'pf_account_number' => 'required',
            'tan_number' => 'required'
        ]);

        $user = Auth::user();
        $company = Company::find($request->company_id);
        
        $log = Log::where(['name'=>'Company-Updated'])->first();
        $log_data = [
                        'log_id' => $log->id,
                        'data' => $company->toJson()
                    ];

        $username = $user->employee->fullname;          
        $log_data['message'] = $log->name. " by ".$username."(".$user->id.").";         
        $company->logDetails()->create($log_data);

        $company_data = [   
                            'name' => $request->company_name,
                            'address' => $request->company_address,
                            'phone' => $request->company_phone_number,
                            'email' => $request->company_email,
                            'website' => $request->company_website,
                            'creator_id' => $user->id,   
                            'tan_number' => $request->tan_number,
                            'pf_account_number' => $request->pf_account_number,
                            'responsible_person' => $request->responsible_person,
                            'phone_extension' => $request->company_phone_extension,
                            'dbf_file_code' => $request->dbf_file_code,
                            'extension' => $request->extension
                        ];

        $company->update($company_data);

        return redirect('mastertables/companies');

    }//end of function

    /*
        Ajax request to get company details & show them in a modal on companies list page
    */
    function additionalCompanyInfo(Request $request)
    {
    	$company = Company::find($request->company_id);
        $view = View::make('mastertables.additional_company_info', ['data' => $company]);

        $contents = $view->render();
        return $contents;

    }//end of function

    /*
        Ajax request to get company details & show them in a modal on companies list page
    */
    function listEsiRegistrations($company_id)
    {
    	$company = Company::find($company_id);
    	$esi_registrations = $company->esiRegistrations()
    								 ->with('location:id,name')
                                     ->orderBy('created_at','DESC')
    								 ->get();

        return view('mastertables.list_esi_registrations')->with(['esi_registrations'=>$esi_registrations,'company'=>$company]);

    }//end of function

    /*
        Edit/Activate/Deactivate an ESI registration in the database
    */
    function esiRegistrationAction($action,$esi_registration_id)
    {
        $user = Auth::user();

        if(!empty($esi_registration_id)){
            $esi_registration = EsiRegistration::where(['id'=>$esi_registration_id])
                                                ->with(['company:id,name'])
                                                ->with('location.state:id,name')
                                                ->first();
        }

        if($action == "edit"){

            $data['companies'] = Company::where(['isactive'=>1])->get();
            $data['action'] = $action;
            $data['states'] = State::where(['isactive'=>1])->get();
            $data['company_id'] = $esi_registration->company->id;
            $data['esi_registration'] = $esi_registration;

            return view('mastertables.esi_registration_form')->with(['data'=>$data]);

        }elseif($action == "activate") {
           
            $esi_registration->update(['isactive'=>1]);
            
            return redirect("mastertables/company-esi-registrations/$esi_registration->company_id");

        }elseif($action == "deactivate") {

            $esi_registration->update(['isactive'=>0]);
            
            return redirect("mastertables/company-esi-registrations/$esi_registration->company_id");

        }

    }//end of function

    /*
        Show the add ESI registration form with required details 
    */
    function addEsiRegistration($company_id)
    {
        $data['companies'] = Company::where(['isactive'=>1])->get();
        //$data['locations'] = Location::where(['isactive'=>1,'has_esi'=>1])->get();
        $data['states'] = State::where(['isactive'=>1])->get();
        $data['action'] = "add";
        $data['company_id'] = $company_id;

        return view('mastertables.esi_registration_form')->with(['data'=>$data]);
    
    }//end of function

    /*
        Add a new ESI Registration or update an existing one in the database 
    */
    function saveEsiRegistration(Request $request)
    {
        if($request->action == "add"){
            $request->validate([
                'company_id' => 'required',
                'esi_number' => 'required|unique:esi_registrations,esi_number',
                'esi_address' => 'required',
                'location_id' => 'required'
            ]);

            $check_unique = EsiRegistration::where(['company_id'=>$request->company_id,'location_id'=>$request->location_id])->first();

            if(!empty($check_unique)){
                return redirect()->back()->with('save_error',"ESI registration already exists at the given location.");
            }

            $esi_data = [
                            'company_id' => $request->company_id,
                            'location_id' => $request->location_id,
                            'local_office' => $request->esi_local_office,
                            'esi_number' => $request->esi_number,
                            'address' => $request->esi_address
                        ];

            $esi = EsiRegistration::create($esi_data);            

        }else{
            $request->validate([
                'company_id' => 'required',
                'esi_number' => 'required',
                'esi_address' => 'required',
                'location_id' => 'required'
            ]);

            $esi = EsiRegistration::find($request->esi_registration_id);

            $esi_data = [
                            'company_id' => $request->company_id,
                            'location_id' => $request->location_id,
                            'local_office' => $request->esi_local_office,
                            'esi_number' => $request->esi_number,
                            'address' => $request->esi_address
                        ];

            $esi->update($esi_data);            
        }

        return redirect("mastertables/company-esi-registrations/$esi->company_id");
        
    }//end of function

    /*
        Get PT Registrations from the database & show them in a list 
    */
    function listPtRegistrations($company_id)
    {
        $company = Company::find($company_id);
        $pt_registrations = $company->ptRegistrations()
                                     ->with('state:id,name')
                                     ->orderBy('created_at','DESC')
                                     ->get();

        return view('mastertables.list_pt_registrations')->with(['pt_registrations'=>$pt_registrations,'company'=>$company]);

    }//end of function

    /*
        Perform specific action for edit/activate/deactivate a PT registration 
    */
    function ptRegistrationAction($action,$pt_registration_id)
    {
        $user = Auth::user();

        if(!empty($pt_registration_id)){
            $pt_registration = PtRegistration::where(['id'=>$pt_registration_id])
                                                ->with(['company:id,name'])
                                                ->first();
        }

        if($action == "edit"){

            $data['companies'] = Company::where(['isactive'=>1])->get();
            $data['states'] = State::where(['isactive'=>1,'has_pt'=>1])->get();
            $data['action'] = $action;
            $data['company_id'] = $pt_registration->company->id;
            $data['pt_registration'] = $pt_registration;

            return view('mastertables.pt_registration_form')->with(['data'=>$data]);

        }elseif($action == "activate") {
           
            $pt_registration->update(['isactive'=>1]);
            
            return redirect("mastertables/company-pt-registrations/$pt_registration->company_id");

        }elseif($action == "deactivate") {

            $pt_registration->update(['isactive'=>0]);
            
            return redirect("mastertables/company-pt-registrations/$pt_registration->company_id");

        }

    }//end of function

    /*
        Show create PT Registration form with necessary details  
    */
    function addPtRegistration($company_id)
    {
        $data['companies'] = Company::where(['isactive'=>1])->get();
        $data['states'] = State::where(['isactive'=>1,'has_pt'=>1])->get();
        $data['action'] = "add";
        $data['company_id'] = $company_id;

        return view('mastertables.pt_registration_form')->with(['data'=>$data]);
    
    }//end of function

    /*
        Add a new PT Registration to the database or update an existing one  
    */
    function savePtRegistration(Request $request)
    {
        if($request->action == "add"){
            $request->validate([
                'company_id' => 'required',
                'certificate_number' => 'required|unique:pt_registrations,certificate_number',
                'address' => 'required',
                'state_id' => 'required'
            ]);

            $check_unique = PtRegistration::where(['company_id'=>$request->company_id,'state_id'=>$request->state_id])->first();

            if(!empty($check_unique)){
                return redirect()->back()->with('save_error',"PT registration already exists at the given state.");
            }

            $pt_data =  [
                            'company_id' => $request->company_id,
                            'state_id' => $request->state_id,
                            'certificate_number' => $request->certificate_number,
                            'address' => $request->address,
                            'pto_circle_number' => $request->pto_circle_number,
                            'return_period' => $request->return_period 
                        ];

            $pt = PtRegistration::create($pt_data);            

        }else{
            $request->validate([
                'company_id' => 'required',
                'certificate_number' => 'required',
                'address' => 'required',
                'state_id' => 'required'
            ]);

            $pt = PtRegistration::find($request->pt_registration_id);

            $pt_data =  [
                            'company_id' => $request->company_id,
                            'state_id' => $request->state_id,
                            'certificate_number' => $request->certificate_number,
                            'address' => $request->address,
                            'pto_circle_number' => $request->pto_circle_number,
                            'return_period' => $request->return_period 
                        ];

            $pt->update($pt_data);            
        }

        return redirect("mastertables/company-pt-registrations/$pt->company_id");
        
    }//end of function

    /*
        Ajax request to get a company's TAN No. & PF No.  
    */
    function companyTanPf(Request $request)
    {
        $company = Company::find($request->company_id);
        
        if(!empty($company)){
            $result['pf_no'] = $company->pf_account_number;
            $result['tan_no'] = $company->tan_number;
        }else{
            $result['pf_no'] = "";
            $result['tan_no'] = "";
        }

        return $result;
        
    }//end of function

    /*
        Ajax request to get a company's PT Registration data  
    */
    function companyPtCertificateNo(Request $request)
    {
        $state_ids = $request->state_ids;
        $company_id = $request->company_id;

        $result = [];

        foreach ($state_ids as $key => $value) {
            $data['state'] = State::find($value); 
            $data['locations'] = $data['state']->locations()->where(['isactive'=>1])->get();
            $data['pt_data'] = PtRegistration::where(['company_id'=>$company_id,'state_id'=>$value])
                                            ->first();

            $result[] = $data;           
        }            

        return $result;
    }//end of function

    /*
        Ajax request to get a company's ESI Registration data  
    */
    function companyEsiNo(Request $request)
    {
        $location_ids = $request->location_ids;
        $company_id = $request->company_id;

        $result = [];

        foreach ($location_ids as $key => $value) {
            $data['location'] = Location::find($value); 
            $data['esi_data'] = EsiRegistration::where(['company_id'=>$company_id,'location_id'=>$value])->first();

            $result[] = $data;           
        }            

        return $result;
    }//end of function

  
  

    /*
        Ajax request to check whether mobile number & email are unique while adding project contact in the table  
    */
    function checkUniqueProjectContact(Request $request)
    {
        $result = [
                    'mobile_number' => 1,
                    'email' => 1
                  ];

        if(!empty($request->mobile_number)){
            $contact = ProjectContact::where(['mobile_number' => $request->mobile_number,'project_id' => $request->project_id])->first();

            if(!empty($contact)){
                $result['mobile_number'] = 0;
            }
        }else{
            $result['mobile_number'] = 2;
        } 

        if(!empty($request->email)){
            $contact = ProjectContact::where(['email' => $request->email,'project_id' => $request->project_id])->first();

            if(!empty($contact)){
                $result['email'] = 0;
            }
        }else{
            $result['email'] = 2;
        }   

        return $result; 

    }//end of function

    /*
        Ajax request to check whether mobile number & email are unique while editing project contact 
    */
    function checkUniqueEditProjectContact()
    {
        $result = [
                    'mobile_number' => 1,
                    'email' => 1
                  ];

        if(!empty($request->mobile_number)){
            $contact = ProjectContact::where(['mobile_number' => $request->mobile_number,'project_id' => $request->project_id])->first();

            if(!empty($contact) && ($contact->id != $request->contact_id)){
                $result['mobile_number'] = 0;
            }
        }else{
            $result['mobile_number'] = 2;
        } 

        if(!empty($request->email)){
            $contact = ProjectContact::where(['email' => $request->email,'project_id' => $request->project_id])->first();

            if(!empty($contact) && ($contact->id != $request->contact_id)){
                $result['email'] = 0;
            }
        }else{
            $result['email'] = 2;
        }   

        return $result; 

    }//end of function

    /*
        Add new project contact in the database 
    */
    function createProjectContact(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'bail|required',
            'mobileNo' => 'bail|required',
            'role' => 'bail|required',
            'email' => 'bail|required'
        ]);

        if($validator->fails()) {
            return redirect()->back()
                    ->withErrors($validator,'contact')
                    ->withInput();

        }else{

            if(empty($request->projectId) || $request->projectId == 0){
                return redirect()->back()->with('projectError','Please fill the project details form and then fill the contacts form.');
            }else{

                $project = Project::find($request->projectId);

                $data = [
                            'name'  => $request->name,
                            'mobile_number' => $request->mobileNo,
                            'role' => $request->role,
                            'email' => $request->email
                        ];

                $contact = $project->projectContacts()->create($data);

                if($request->action == 'add'){
                    session(['last_inserted_project' => $request->projectId,'last_tabname' => 'contactDetailsTab']);

                    return redirect("mastertables/projects/add");
                }else{
                    session(['last_inserted_project' => 0,'last_tabname' => 'contactDetailsTab']);

                    return redirect("mastertables/projects/edit/$request->projectId");
                }
            }
        }

    }//end of function

    /*
        Update existing project contact in the database 
    */
    function editProjectContact(Request $request)
    {
        $data = [
                    'name'  => $request->name,
                    'mobile_number' => $request->mobileNo,
                    'role' => $request->role,
                    'email' => $request->email
                ];

        $contact = ProjectContact::find($request->contactId);
        $contact->update($data);
        session(['last_inserted_project' => 0,'last_tabname' => 'contactDetailsTab']);

        return redirect("mastertables/projects/edit/$request->projectId");    

    }//end of function


    /*
        Ajax request to show project information in a modal  
    */
    function additionalProjectInfo(Request $request)
    {
        $project = Project::where(['id'=>$request->project_id])
                            ->with('salaryStructure:id,name')
                            ->with('salaryCycle:id,name')
                            ->with('company:id,name,pf_account_number')
                            ->with('projectResponsiblePersons.user.employee:id,user_id,fullname')
                            ->with('projectContacts')
                            ->first();                                        

        $data['project'] = $project;
        $data['documents'] = $project->documents()->orderBy('document_id')->get();

        ////////////////////////////////////////////////////////////////

        $state_ids = $project->states()->pluck('state_id')->toArray();
        $company_id = $project->company_id;

        $states = [];

        foreach ($state_ids as $key => $value) {
            $data2['state'] = State::find($value); 

            $data2['pt_data'] = PtRegistration::where(['company_id'=>$company_id,'state_id'=>$value])
                                            ->first();

            $states[] = $data2;           
        }

        $data['states'] = $states;

        /////////////////////////////////////////////////////////////////

        $location_ids = $project->locations()->pluck('location_id')->toArray();
        $locations = [];

        foreach ($location_ids as $key => $value) {
            $data3['location'] = Location::find($value); 

            $data3['esi_data'] = EsiRegistration::where(['company_id'=>$company_id,'location_id'=>$value])->first();

            $locations[] = $data3;           
        }

        $data['locations'] = $locations;

        $view = View::make('mastertables.additional_project_info', ['data' => $data]);
        $contents = $view->render();

        return $contents;
    }//end of function

    /*
        List all the states in database, add & edit them  
    */    
    function states(Request $request)
    {
        $data['action']='';
        $data['error']=[];
        $data['id']=0;
        if($request->btn_submit){
            if($request->btn_submit=='Add'){
                $validatedData = $request->validate([
                    'name' => 'required|max:255',
                ]);
                if(State::where('name', $request->name)->get()->count()==0){
                    $stObj=new State;
                    $stObj->name=$request->name;
                    $stObj->has_pt=$request->has_pt;
                    $stObj->save();
                    if($stObj->id){
                        $data['save_success'] = "State added successfully.";
                    }
                }
            }
            elseif($request->btn_submit=='Update'){

                $validatedData = $request->validate([
                    'name' => 'required|max:255',
                ]);
                if(State::where('name', $request->name)->where('id', '!=', $request->id)->get()->count()==0){
                    State::where('id', $request->id)
                        ->update([
                            'name'=>$request->name,
                            'has_pt'=>$request->has_pt
                        ]);

                    $data['save_success'] = "State updated successfully.";    
                }
            }
        }
        if($request->id){
            $data['state']=State::where('id', $request->id)->first();
            $data['id']=$request->id;
        }
        $data['countries']=Country::orderBy('name', 'asc')->get();
        $data['states']=State::where('country_id', 1)->orderBy('name', 'asc')->get();
        return view('mastertables.states')->with(['data'=>$data]);
    }//end of function

    /*
        List all the cities in database, add & edit them  
    */
    function cities(Request $request)
    {
        $data['action']='';
        $data['error']=[];
        $data['id']=$data['state_id']=0;
        if($request->btn_submit){
            if($request->btn_submit=='Add'){
                $validatedData = $request->validate([
                    'name' => 'required|max:255',
                ]);
                if(City::where('name', $request->name)->where('state_id', $request->state_id)->get()->count()==0){
                    $stObj=new City;
                    $stObj->name=$request->name;
                    $stObj->state_id=$request->state_id;
                    $stObj->save();
                    if($stObj->id){
                        $data['save_success'] = "City added successfully.";
                    }
                }
            }
            elseif($request->btn_submit=='Update'){

                $validatedData = $request->validate([
                    'name' => 'required|max:255',
                ]);
                if(City::where('name', $request->name)->where('state_id', $request->state_id)->where('id', '!=', $request->id)->get()->count()==0){
                    City::where('id', $request->id)
                        ->update([
                            'name'=>$request->name,
                            'state_id'=>$request->state_id
                        ]);

                    $data['save_success'] = "City updated successfully.";    
                }
            }
        }
        
        $data['countries']=Country::orderBy('name', 'asc')->get();
        $data['states']=State::where('country_id', 1)->orderBy('name', 'asc')->get();
        if($request->state_id){
            $data['state_id']=$request->state_id;
            $data['state']=State::where('id', $request->state_id)->first();
            $data['cities']=City::where('state_id', $request->state_id)->orderBy('name', 'asc')->get();
            if($request->id){
                $data['city']=City::where('id', $request->id)->first();
            }
        }
        
        return view('mastertables.cities')->with(['data'=>$data]);
    }//end of function

    /*
        List all the locations in database, add & edit them  
    */
    function locations(Request $request)
    {
        $data['action']='';
        $data['error']=[];
        $data['id']=$data['state_id']=0;
        if($request->btn_submit){
            if($request->btn_submit=='Add'){
                $validatedData = $request->validate([
                    'name' => 'required|max:255',
                ]);
                if(Location::where('name', $request->name)->where('state_id', $request->state_id)->get()->count()==0){
                    $stObj=new Location;
                    $stObj->name=$request->name;
                    $stObj->state_id=$request->state_id;
                    $stObj->save();
                    if($stObj->id){
                        $data['save_success'] = "Location added successfully.";
                    }
                }
            }
            elseif($request->btn_submit=='Update'){

                $validatedData = $request->validate([
                    'name' => 'required|max:255',
                ]);
                if(Location::where('name', $request->name)->where('state_id', $request->state_id)->where('id', '!=', $request->id)->get()->count()==0){
                    Location::where('id', $request->id)
                        ->update([
                            'name'=>$request->name,
                            'state_id'=>$request->state_id
                        ]);

                    $data['save_success'] = "Location updated successfully.";    
                }
            }
        }
        
        $data['countries']=Country::orderBy('name', 'asc')->get();
        $data['states']=State::where('country_id', 1)->orderBy('name', 'asc')->get();
        if($request->state_id){
            $data['state_id']=$request->state_id;
            $data['state']=State::where('id', $request->state_id)->first();
            if($request->id){
                $data['location']=Location::where('id', $request->id)->first();
            }
            $data['locations']=Location::where('isactive', 1)->where('state_id', $request->state_id)->get();
        }
        
        return view('mastertables.locations')->with(['data'=>$data]);
    }//end of function

    /*
        Ajax request to get states wise locations  
    */
    function statesWiseLocations(Request $request)
    {
        $state_ids = $request->state_ids;

        $result['locations'] = Location::whereIn('state_id',$state_ids)
                                        ->where('isactive',1)    
                                        ->get();

        return $result;

    }//end of function

    // function listLeaveAuthorities($department_id = 0)
    // {
    //     $departments = Department::where(['isactive'=>1])->select('id','name')->get();
    //     $department = Department::find($department_id);

    //     $leave_authorities = LeaveAuthority::where(['department_id'=>$department_id])
    //                           ->with(['department:id,name'])
    //                           ->with(['project:id,name'])  
    //                           ->with(['user.employee:id,user_id,fullname'])
    //                           ->get();                        

    //     return view('mastertables.list_leave_authorities')->with(['data'=>$leave_authorities,'departments'=>$departments,'department'=>$department]);
                
    // }//end of function

    // function leaveAuthorityAction($action, $leave_authority_id)
    // {
    //     if(!empty($leave_authority_id)){
    //         $leave_authority = LeaveAuthority::where(['id'=>$leave_authority_id])
    //                           ->with(['department:id,name'])
    //                           ->with(['project:id,name'])  
    //                           ->with(['user.employee:id,user_id,fullname'])
    //                           ->first();
    //     }

    //     if($action == 'add'){
    //         $data['action'] = $action;
    //         $data['departments'] = Department::where(['isactive'=>1])->select('id','name')->get();
    //         $data['projects'] = Project::where(['isactive'=>1,'approval_status'=>'1'])->select('id','name')->get();
    //         $data['employees'] = Employee::where(['isactive'=>1,'approval_status'=>'1'])->select('user_id','fullname')->get();

    //         return view('mastertables.add_leave_authorities_form')->with(['data'=>$data]);

    //     }elseif($action == 'edit'){
    //         $data['action'] = $action;

    //     }

    // }//end of function

    function checkUniqueLeaveAuthority(Request $request)
    {
        $check_data = [
                        'department_id' => 0,
                        'project_id' => 0,
                        'priority' => '0',
                        'sub_level' => '1',
                        'isactive' => 1
                     ];

        if(!empty($request->departmentId)){
            $check_data['department_id'] = $request->departmentId;
        }

        if(!empty($request->projectId)){
            $check_data['project_id'] = $request->projectId;
        }    

        if(!empty($request->priority)){
            $check_data['priority'] = $request->priority;
        }    

        $main_authority = LeaveAuthority::where($check_data)->first();
        $check_data['sub_level'] = '2';
        $sub_authority = LeaveAuthority::where($check_data)->first();

        if(!empty($main_authority) && empty($sub_authority)){
            $result['allow_submit'] = "no";
            $result['message'] = '1';    //only main authority exists

        }elseif(!empty($main_authority) && !empty($sub_authority)){
            $result['allow_submit'] = "no";
            $result['message'] = '2';  //both main & sub authority exists

        }elseif(empty($main_authority)){
            $result['allow_submit'] = "yes";

        }

        return $result;   

    }//end of function

}//end of class
