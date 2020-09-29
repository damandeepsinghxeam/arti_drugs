@extends('admins.layouts.app')

@section('content')
<style>
.radio { margin: 6px 0 0 0; }
.radio label input { position: relative; top: -2px; }
.important-links a {  }
.reason_chat{	
	background-color: #34B7F1;
	padding: 6px;
	border-radius: 10px;

	color: white;
	}
 .reason_chat span{
 	
}
</style>

<!-- Content Wrapper. Contains page content -->

 <div class="content-wrapper">

  <!-- Content Header Starts here -->
  <section class="content-header">
    <h1>Project Approval and Handover (BD2SD V 1.2)</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Dashboard</li>
    </ol>
  </section>
  <!-- Content Header Ends here -->
  
  <?php 
          $last_inserted_project = session('last_inserted_project');

          if(empty($last_inserted_project)){
            $last_inserted_project = 0;
          }

          $last_tabname = session('last_tabname');

          if(empty($last_tabname)){
            $last_tabname = "projectDetailsTab";
          }
     ?>
  
  <!-- Main content Starts here -->
  <section class="content">
    <div class="row">
      <div class="col-sm-12">
        <div class="box box-primary">
        	@include('admins.validation_errors')

          <!-- Form Starts here -->
         
		@php
		
			if(isset($data['project_draft_values']) AND ($data['project_draft_values']!="")){
				
				if(isset($data['project_draft_values']['projectName']) AND ($data['project_draft_values']['projectName']!="")){
					$project_name = $data['project_draft_values']['projectName'];
				}else{
					$project_name ="";
				}
				
				if(isset($data['project_draft_values']['gst_registration_number']) AND ($data['project_draft_values']['gst_registration_number']!="")){
					$gst_reg_num = $data['project_draft_values']['gst_registration_number'];
				}else{
					$gst_reg_num ="";
				}
				
				if(isset($data['project_draft_values']['tan_number']) AND ($data['project_draft_values']['tan_number']!="")){
					$tan_num = $data['project_draft_values']['tan_number'];
				}else{
					$tan_num ="";
				}
				
				if(isset($data['project_draft_values']['head_office_location']) AND ($data['project_draft_values']['head_office_location']!="")){
					$head_office_loc = $data['project_draft_values']['head_office_location'];
				}else{
					$head_office_loc ="";
				}
				
				if(isset($data['project_draft_values']['head_office_address']) AND ($data['project_draft_values']['head_office_address']!="")){
					$head_off_add = $data['project_draft_values']['head_office_address'];
				}else{
					$head_off_add ="";
				}
								
				if(isset($data['project_draft_values']['project_owner_department']) AND ($data['project_draft_values']['project_owner_department']!="")){
					$project_owner_dep = $data['project_draft_values']['project_owner_department'];
				}else{
					$project_owner_dep ="";
				}
				
				if(isset($data['project_draft_values']['project_owner_name']) AND ($data['project_draft_values']['project_owner_name']!="")){
					$project_owner_name = $data['project_draft_values']['project_owner_name'];
				}else{
					$project_owner_name ="";
				}
				
				if(isset($data['project_draft_values']['contact_person']) AND ($data['project_draft_values']['contact_person']!="")){
					$contact_person = $data['project_draft_values']['contact_person'];
				}else{
					$contact_person ="";
				}
				
				if(isset($data['project_draft_values']['corres_office_address']) AND ($data['project_draft_values']['corres_office_address']!="")){
					$corres_office_add = $data['project_draft_values']['corres_office_address'];
				}else{
					$corres_office_add ="";
				}
				
				if(isset($data['project_draft_values']['agreement_signed']) AND ($data['project_draft_values']['agreement_signed']!="")){
					$agreement_signed = $data['project_draft_values']['agreement_signed'];
				}else{
					$agreement_signed ="";
				}
				
				if(isset($data['project_draft_values']['agreement_validity']) AND ($data['project_draft_values']['agreement_validity']!="")){
					$agreement_validity = $data['project_draft_values']['agreement_validity'];
				}else{
					$agreement_validity ="";
				}
				
				if(isset($data['project_draft_values']['agreement_remarks']) AND ($data['project_draft_values']['agreement_remarks']!="")){
					$agreement_remarks = $data['project_draft_values']['agreement_remarks'];
				}else{
					$agreement_remarks ="";
				}
				
				if(isset($data['project_draft_values']['starting_of_project_date']) AND ($data['project_draft_values']['starting_of_project_date']!="")){
					$start_project_date = $data['project_draft_values']['starting_of_project_date'];
				}else{
					$start_project_date ="";
				}
				
				if(isset($data['project_draft_values']['contract_period_year']) AND ($data['project_draft_values']['contract_period_year']!="")){
					$contract_period_year = $data['project_draft_values']['contract_period_year'];
				}else{
					$contract_period_year ="";
				}
				
				if(isset($data['project_draft_values']['contract_period_month']) AND ($data['project_draft_values']['contract_period_month']!="")){
					$contract_period_month = $data['project_draft_values']['contract_period_month'];
				}else{
					$contract_period_month ="";
				}
				
				if(isset($data['project_draft_values']['extendable']) AND ($data['project_draft_values']['extendable']!="")){
					$extendable = $data['project_draft_values']['extendable'];
				}else{
					$extendable ="";
				}
				
				if(isset($data['project_draft_values']['scope']) AND ($data['project_draft_values']['scope']!="")){
					$scope = $data['project_draft_values']['scope'];
				}else{
					$scope ="";
				}
				
				if(isset($data['project_draft_values']['tds_deduction']) AND ($data['project_draft_values']['tds_deduction']!="")){
					$tds_deduction = $data['project_draft_values']['tds_deduction'];
				}else{
					$tds_deduction ="";
				}
				
				if(isset($data['project_draft_values']['bg_security']) AND ($data['project_draft_values']['bg_security']!="")){
					$bg_security = $data['project_draft_values']['bg_security'];
				}else{
					$bg_security ="";
				}
				
				if(isset($data['project_draft_values']['bg_or_security']) AND ($data['project_draft_values']['bg_or_security']!="")){
					$bg_or_security = $data['project_draft_values']['bg_or_security'];
				}else{
					$bg_or_security ="";
				}
				if(isset($data['project_draft_values']['bg_or_security_amount']) AND ($data['project_draft_values']['bg_or_security_amount']!="")){
					$bg_or_security_amount = $data['project_draft_values']['bg_or_security_amount'];
				}else{
					$bg_or_security_amount ="";
				}
				
				if(isset($data['project_draft_values']['bg_or_security_submission']) AND ($data['project_draft_values']['bg_or_security_submission']!="")){
					$bg_or_security_submission = $data['project_draft_values']['bg_or_security_submission'];
				}else{
					$bg_or_security_submission ="";
				}
				
				if(isset($data['project_draft_values']['bg_or_security_to_client']) AND ($data['project_draft_values']['bg_or_security_to_client']!="")){
					$bg_or_security_to_client = $data['project_draft_values']['bg_or_security_to_client'];
				}else{
					$bg_or_security_to_client ="";
				}
				
				if(isset($data['project_draft_values']['location_state']) AND ($data['project_draft_values']['location_state']!="")){
					$location_state = $data['project_draft_values']['location_state'];
				}else{
					$location_state ="";
				}
				if(isset($data['project_draft_values']['location_city']) AND ($data['project_draft_values']['location_city']!="")){
					$location_city = $data['project_draft_values']['location_city'];
				}else{
					$location_city ="";
				}
				
				if(isset($data['project_draft_values']['resources_category']) AND ($data['project_draft_values']['resources_category']!="")){
					$resources_category = $data['project_draft_values']['resources_category'];
				}else{
					$resources_category ="";
				}
				
				if(isset($data['project_draft_values']['billing_cycle_from']) AND ($data['project_draft_values']['billing_cycle_from']!="")){
					$billing_cycle_from = $data['project_draft_values']['billing_cycle_from'];
				}else{
					$billing_cycle_from ="";
				}
				
				if(isset($data['project_draft_values']['billing_cycle_to']) AND ($data['project_draft_values']['billing_cycle_to']!="")){
					$billing_cycle_to = $data['project_draft_values']['billing_cycle_to'];
				}else{
					$billing_cycle_to ="";
				}
				
				if(isset($data['project_draft_values']['salary_payment_date']) AND ($data['project_draft_values']['salary_payment_date']!="")){
					$salary_payment_date = $data['project_draft_values']['salary_payment_date'];
				}else{
					$salary_payment_date ="";
				}
				
				if(isset($data['project_draft_values']['salary_mode']) AND ($data['project_draft_values']['salary_mode']!="")){
					$salary_mode = $data['project_draft_values']['salary_mode'];
				}else{
					$salary_mode ="";
				}
				
				if(isset($data['project_draft_values']['esi_applicable']) AND ($data['project_draft_values']['esi_applicable']!="")){
					$esi_applicable = $data['project_draft_values']['esi_applicable'];
				}else{
					$esi_applicable ="";
				}
				
				if(isset($data['project_draft_values']['epf_applicable']) AND ($data['project_draft_values']['epf_applicable']!="")){
					$epf_applicable = $data['project_draft_values']['epf_applicable'];
				}else{
					$epf_applicable ="";
				}
				
				if(isset($data['project_draft_values']['gpa_applicable']) AND ($data['project_draft_values']['gpa_applicable']!="")){
					$gpa_applicable = $data['project_draft_values']['gpa_applicable'];
				}else{
					$gpa_applicable ="";
				}
				
				if(isset($data['project_draft_values']['wc_applicable']) AND ($data['project_draft_values']['wc_applicable']!="")){
					$wc_applicable = $data['project_draft_values']['wc_applicable'];
				}else{
					$wc_applicable ="";
				}
				
				if(isset($data['project_draft_values']['margin']) AND ($data['project_draft_values']['margin']!="")){
					$margin = $data['project_draft_values']['margin'];
				}else{
					$margin ="";
				}
				
				if(isset($data['project_draft_values']['security_charges']) AND ($data['project_draft_values']['security_charges']!="")){
					$security_charges = $data['project_draft_values']['security_charges'];
				}else{
					$security_charges ="";
				}
				
				if(isset($data['project_draft_values']['document_charges']) AND ($data['project_draft_values']['document_charges']!="")){
					$document_charges = $data['project_draft_values']['document_charges'];
				}else{
					$document_charges ="";
				}
				
				if(isset($data['project_draft_values']['online_application_charges']) AND ($data['project_draft_values']['online_application_charges']!="")){
					$online_application_charges = $data['project_draft_values']['online_application_charges'];
				}else{
					$online_application_charges ="";
				}
				
				if(isset($data['project_draft_values']['id_card']) AND ($data['project_draft_values']['id_card']!="")){
					$id_card = $data['project_draft_values']['id_card'];
				}else{
					$id_card ="";
				}
				
				if(isset($data['project_draft_values']['uniform']) AND ($data['project_draft_values']['uniform']!="")){
					$uniform = $data['project_draft_values']['uniform'];
				}else{
					$uniform ="";
				}
				
				if(isset($data['project_draft_values']['offer_letter']) AND ($data['project_draft_values']['offer_letter']!="")){
					$offer_letter = $data['project_draft_values']['offer_letter'];
				}else{
					$offer_letter ="";
				}
				
				if(isset($data['project_draft_values']['tic_or_Medical_insurance']) AND ($data['project_draft_values']['tic_or_Medical_insurance']!="")){
					$tic_or_Medical_insurance = $data['project_draft_values']['tic_or_Medical_insurance'];
				}else{
					$tic_or_Medical_insurance ="";
				}
				
				if(isset($data['project_draft_values']['additional_obligations']) AND ($data['project_draft_values']['additional_obligations']!="")){
					$additional_obligations = $data['project_draft_values']['additional_obligations'];
				}else{
					$additional_obligations ="";
				}

				if(isset($data['project_draft_values']['xeam_client']) AND ($data['project_draft_values']['xeam_client']!="")){
					$xeam_client = $data['project_draft_values']['xeam_client'];
				}else{
					$xeam_client ="";
				}
				
	
				
			}else{
				$project_name = "";
				$gst_reg_num = "";				
				$tan_num = "";				
				$head_office_loc = "";				
				$head_off_add = "";				
				$project_owner_dep = "";				
				$project_owner_name = "";				
				$contact_person = "";				
				$corres_office_add = "";				
				$agreement_signed = "";				
				$agreement_validity = "";				
				$agreement_remarks = "";				
				$start_project_date = "";				
				$contract_period_year = "";				
				$contract_period_month = "";				
				$extendable = "";				
				$scope = "";
				$tds_deduction = "";				
				$bg_security = "";				
				$bg_or_security = "";
				$bg_or_security_amount = "";
				$bg_or_security_submission = "";				
				$bg_or_security_to_client = "";				
				$location_state = "";
				$location_city = "";				
				$resources_category = "";				
				$billing_cycle_from = "";
				$billing_cycle_to = "";				
				$salary_payment_date = "";
				$salary_mode = "";
				$esi_applicable = "";				
				$epf_applicable = "";				
				$gpa_applicable = "";				
				$wc_applicable = "";				
				$margin = "";				
				$security_charges = "";				
				$document_charges = "";				
				$online_application_charges = "";
				
				$id_card = "";
				$uniform = "";
				$offer_letter = "";
				$tic_or_Medical_insurance = "";
				$additional_obligations = "";
				$xeam_client = "";
				
			}
			
			//print_r($data['project_draft_values']);
			
		@endphp
		 
		<form id="project_approval_handover" class="project_approval_handover" action="{{ url('mastertables/save-project') }}" method="POST" enctype="multipart/form-data">		  
		   {{ csrf_field() }}
            <div class="box-body jrf-form-body">
              <!-- Row starts here -->
              <div class="row">
                <!-- Left column starts here -->
                <div class="col-md-6">

                	<div class="form-group">
                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
                          <label for="project_name" class="apply-leave-label">Xeam Client</label>
                        </div>

                        <div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
            				<div class="radio">
								<label>
									<input type="radio" name="xeam_client" class="xeam_client" id="" value="1" @if(@$xeam_client == "1"){{'checked'}} @endif>Yes
								</label>&nbsp;&nbsp;
								<label>
									<input type="radio" name="xeam_client" class="xeam_client" id="" value="0" @if(@$xeam_client == "0"){{'checked'}} @endif>No
								</label>
							</div>
            								
                        </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
                          <label for="project_name" class="apply-leave-label">Name of Project</label>
                        </div>

                        <div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
            				<input type="text" name="projectName" id="projectName" class="form-control input-sm basic-detail-input-style" value="{{$project_name}}">
            								
                        </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
                          <label for="gst_registration_number" class="apply-leave-label">GST Registration No.</label>
                        </div>
                        <div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
                          	<input type="text" class="form-control input-sm basic-detail-input-style" name="gst_registration_number" id="gst_registration_number" placeholder="Enter GST Number" value="{{$gst_reg_num}}">
                        </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="row"> 
                        <div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470"> 
                          <label for="" class="apply-leave-label">TAN No.</label>
                        </div>
                        <div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470" id="tan_expand">
                        	<div class="row">
	                          <div class="col-xs-10 input-l">
							@if(isset($tan_num) AND (is_array($tan_num)))
								@foreach($tan_num as $tan_no)
								<input type="text" class="form-control input-sm basic-detail-input-style" name="tan_number[]" id="" placeholder="Enter TAN Number" value="{{$tan_no}}">
							  @endforeach
							@else
							  <input type="text" class="form-control input-sm basic-detail-input-style" name="tan_number[]" id="" placeholder="Enter TAN Number" value="">
							@endif
	                            
	                          </div>
	                          <div class="col-xs-2 input-r">
	                            <a href="javascript:void(0)" id="add_new_tan_number">
			                      <i class="fa fa-plus a_r_style a_r_style_green"></i>
			                    </a>
	                          </div>
	                        </div>
                        </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
                          <label for="head_office_location" class="apply-leave-label">Head Office Location</label>
                        </div>
                        @php
                        	//echo $head_office_loc;
                        @endphp
                        <div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
            							<select name="head_office_location" id="head_office_location" class="form-control input-sm basic-detail-input-style">
            								<option value="" selected disabled>Select Location</option>
											@foreach($data['locations'] as $location)
            								<option value="{{$location->name}}" @if($head_office_loc == $location->name){{'selected'}} @endif>{{$location->name}}</option>
            								
											@endforeach
            								
            							</select>
                        </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
                          <label for="head_office_address">Head Office Address</label>
                        </div>
                        <div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
							 <textarea name="head_office_address" id="head_office_address" rows="2" style="width: 100%;" >{{$head_off_add}}
							 </textarea>
                        </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
                        <label for="" class="apply-leave-label">Project Owner</label>
                      </div>
                      <div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
                        <div class="row">
                          <div class="col-xs-6 input-l">
                            <select name="project_owner_department" id="" class="form-control input-sm basic-detail-input-style project_owner_department">
                              <option value="" selected disabled>Department</option>
							  @foreach($data['departments'] as $department)
                              <option value="{{$department->id}}"  @if($project_owner_dep == $department->id){{'selected'}} @endif>{{$department->name}}</option>
                              @endforeach
                            </select>
                          </div>

                          <div class="col-xs-6 input-r">
                            <select name="project_owner_name" id="" class="form-control input-sm basic-detail-input-style project_owner_name">
                              <option value="" selected disabled>Select Person</option>
                              @if($project_owner_name)
                              <option value="{{$project_owner_name}}" @if($project_owner_name == $project_owner_name){{'selected'}} @endif>{{$project_owner_name}}</option>
                              @endif
                              
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
                          <label for="contact_person" class="apply-leave-label">Name of Contact Person</label>
                        </div>
                        <div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
                          	<input type="text" class="form-control input-sm basic-detail-input-style" name="contact_person" id="contact_person" placeholder="Enter Contact Person Name" value="{{$contact_person}}">
                        </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
                          <label for="corres_office_address">Official Address for Correspondence</label>
                        </div>
                        <div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
							    <textarea name="corres_office_address" id="corres_office_address" rows="2" style="width: 100%;">{{$corres_office_add}}</textarea>
                        </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
                          <label for="agreement_signed" class="apply-leave-label">Agreement Signed</label>
                        </div>
                        <div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
            							<div class="radio">
            								<label>
            									<input type="radio" name="agreement_signed" class="agreementSign" id="" value="1" @if($agreement_signed == "1"){{'checked'}} @endif>Yes
            								</label>&nbsp;&nbsp;
            								<label>
            									<input type="radio" name="agreement_signed" class="agreementSign" id="" value="0" @if($agreement_signed == "0"){{'checked'}} @endif>No
            								</label>
            							</div>
                        </div>
                    </div>
                  </div>

                  <div class="form-group agreementValidity">
                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
                          <label for="agreement_signed" class="apply-leave-label">Agreement Validity</label>
                        </div>
                        <div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
							            <input type="text" class="form-control input-sm basic-detail-input-style datepicker" name="agreement_validity" id="agreement_validity" placeholder="06/05/2020" value="{{$agreement_validity}}">
                        </div>
                    </div>
                  </div>

                  <div class="form-group agreementRemarks">
                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
                          <label for="agreement_remarks" class="apply-leave-label">Agreement Remarks</label>
                        </div>
                        <div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
							            <input type="text" class="form-control input-sm basic-detail-input-style" name="agreement_remarks" id="agreement_validity" placeholder="Remarks" value="{{$agreement_remarks}}">
                        </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
                          <label for="starting_of_project_date" class="apply-leave-label">Date of Start of Project</label>
                        </div>
                        <div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
                          	<input type="text" class="form-control input-sm basic-detail-input-style datepicker" name="starting_of_project_date" id="starting_of_project_date" placeholder="06/05/2020" value="{{$start_project_date}}">
                        </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
                        <label for="" class="apply-leave-label">Period of Contract<span style="color: red">*</span></label>
                      </div>
                      <div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
                        <div class="row">
                          <div class="col-xs-6 input-l">
                            <select name="contract_period_year" id="" class="form-control input-sm basic-detail-input-style">
								<option value="" selected disabled>Year</option>
								@for($i=0;$i<=10;$i++)
								<option value="{{$i}}" @if($contract_period_year == $i){{'selected'}} @endif>{{$i}}</option>
								@endfor
                              
                            </select>
                          </div>
                          <div class="col-xs-6 input-r">
                            <select name="contract_period_month" id="" class="form-control input-sm basic-detail-input-style">
                              <option value="" selected disabled>Month</option>
							  @for($i=0;$i<=12;$i++)
								<option value={{$i}} @if($contract_period_month == $i){{'selected'}} @endif>{{$i}}</option>
							@endfor
                             
                              
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
                          <label for="extendable" class="apply-leave-label">Extendable</label>
                        </div>
                        <div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
            							<div class="radio">
            								<label>
            									<input type="radio" name="extendable" id="" value="1" @if($extendable == "1"){{'checked'}} @endif>Yes
            								</label>&nbsp;&nbsp;
            								<label>
            									<input type="radio" name="extendable" id="" value="0" @if($extendable == "0"){{'checked'}} @endif>No
            								</label>
            							</div>
                        </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
                          <label for="scope" class="apply-leave-label">Scope</label>
                        </div>
                        <div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
							<select name="scope" id="scope" class="form-control input-sm basic-detail-input-style">
								<option value="" selected disabled>Select Scope</option>
								<option value="scope1" @if($scope == "scope1"){{'selected'}} @endif>scope 1</option>
								
							</select>
                        </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
                          <label for="tds_deduction" class="apply-leave-label">TDS % to be Deducted</label>
                        </div>
                        <div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
                          <input type="number" name="tds_deduction" id="tds_deduction" class="form-control input-sm basic-detail-input-style" placeholder="ENter TDS Deduction" value="{{$tds_deduction}}">
                        </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
                          <label for="bg_security" class="apply-leave-label">BG or Security Required</label>
                        </div>
                        <div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
            							<div class="radio">
            								<label>
            									<input type="radio" name="bg_security" class="bg_security" value="1" @if($bg_security == "1"){{'checked'}} @endif >Yes
            								</label>&nbsp;&nbsp;
            								<label>
            									<input type="radio" name="bg_security" class="bg_security" value="0" @if($bg_security == "0"){{'checked'}} @endif>No
            								</label>
            							</div>
                        </div>
                    </div>
                  </div>

                  <div class="form-group bgsHide">
                    <div class="row">
                      <div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
                        <label for="">BG or Security to Client<br>(Amount & Shape)<span style="color: red">*</span></label>
                      </div>
                      <div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
                        <div class="row">
                          <div class="col-xs-4 input-l">
                            <select name="bg_or_security" id="" class="form-control input-sm basic-detail-input-style">
                              <option value="BG"  @if($bg_or_security == "BG"){{'selected'}} @endif>BG</option>
                              <option value="Security" @if($bg_or_security == "Security"){{'selected'}} @endif>Security</option>
                            </select>
                          </div>
                          <div class="col-xs-4 input-c">
                            <input type="number" name="bg_or_security_amount" id="" class="form-control input-sm basic-detail-input-style" placeholder="Enter amount" value="{{$bg_or_security_amount}}">
                          </div>
                          <div class="col-xs-4 input-r">
                            <select name="bg_or_security_submission" id="" class="form-control input-sm basic-detail-input-style">
                              <option value="Submitted" @if($bg_or_security_submission == "Submitted"){{'selected'}} @endif>Submitted</option>
                              <option value="Not Submitted" @if($bg_or_security_submission == "Not Submitted"){{'selected'}} @endif>Not Submitted</option>
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
					
				          <div class="form-group bgsHide">
                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
                          <label for="bg_or_security_to_client">BG or Security to Client<br>(Validity)</label>
                        </div>
                        <div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
                          	<input type="text" class="form-control input-sm basic-detail-input-style datepicker" name="bg_or_security_to_client" id="bg_or_security_to_client" placeholder="06/05/2020" value="{{$bg_or_security_to_client}}">
                        </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
                        <label for="" class="apply-leave-label">Project Location</label>
                      </div>
                      <div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
                        <div class="row">
                          <div class="col-xs-6 input-l">

                         
                            <select name="location_state[]" id="location_state" class="form-control allState input-sm basic-detail-input-style select2" multiple="multiple" data-placeholder="Select State">
						
						

							
						 @if(!$data['states']->isEmpty()) 

							@for($i=0;$i<$data['states']->count(); $i++)

								<option value="{{$data['states'][$i]->id}}" @if(isset($location_state) AND is_array($location_state) AND ($location_state!="")) @if(in_array($data['states'][$i]->id,@$location_state)){{"selected"}} @else{{""}}@endif @endif>{{@$data['states'][$i]->name}}</option>

							@endfor

                         @endif  
                            </select>
                          </div>
                          <div class="col-xs-6 input-r">
                            <select name="location_city[]" id="location_city" class="form-control input-sm basic-detail-input-style location_city select2" multiple="multiple" data-placeholder="Select City">
							
                              
							  
							@if(!$data['locations']->isEmpty())  

								@for($i=0;$i<$data['locations']->count(); $i++)

								<option value="{{$data['locations'][$i]->id}}" @if(isset($location_city) AND is_array($location_city) AND ($location_city!="")) @if(in_array($data['locations'][$i]->id,@$location_city)){{"selected"}} @else{{""}} @endif @endif>
									{{@$data['locations'][$i]->name}}
								</option>

								@endfor
								
							@endif							  
							 							  
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="row"> 
                        <div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470"> 
                          <label for="" class="apply-leave-label">Category of Resources</label>
                        </div>
                        <div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470" id="resource_expand">
                        	<div class="row">
	                          <div class="col-xs-10 input-l">
							  @if(isset($resources_category) AND (is_array($resources_category)))
								@foreach($resources_category as $res_category)
	                            <input type="text" class="form-control input-sm basic-detail-input-style" name="resources_category[]" id="" placeholder="Enter Resource Category or Description" value="{{$res_category}}">
								@endforeach
							@else
								<input type="text" class="form-control input-sm basic-detail-input-style" name="resources_category[]" id="" placeholder="Enter Resource Category or Description" value="">
							@endif
	                          </div>
	                          <div class="col-xs-2 input-r">
	                            <a href="javascript:void(0)" id="add_resource_category">
			                      <i class="fa fa-plus a_r_style a_r_style_green"></i>
			                    </a>
	                          </div>
	                        </div>
                        </div>
                    </div>
                  </div>

                </div>
                <!-- Left column Ends here -->

                <!-- Right column Starts here -->
                <div class="col-md-6">
				          <div class="form-group">
                    <div class="row">
                      <div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
                        <label for="" class="apply-leave-label">Billing Cycle</label>
                      </div>
                      <div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
                        <div class="row">
                        	<div class="col-xs-3 input-l">
                        		<select name="billing_cycle_from" id="billing_cycle_from" class="form-control input-sm basic-detail-input-style">
	                              <option value="" selected disabled>From</option>
								  @for($i=1;$i<=30;$i++)
									  <option value="{{$i}}" @if($billing_cycle_from == $i){{'selected'}} @endif>{{$i}}</option>
								@endfor
	                             
	                              
	                            </select>
                        	</div>
                        	<div class="col-xs-3 input-c">
                        		<select name="billing_cycle_to" id="billing_cycle_to" class="form-control input-sm basic-detail-input-style	">
                        		  <option value="" selected disabled>To</option>
	                             @for($i=1;$i<=30;$i++)
									  <option value="{{$i}}" @if($billing_cycle_to == $i){{'selected'}} @endif>{{$i}}</option>
								@endfor
	                             
	                            </select>
                        	</div>
                        	<div class="col-xs-6 input-r">
                        		<span style="position: relative; top: 6px; ">of Every Month</span>
                        	</div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
                        <label for="salary_payment_date" class="apply-leave-label">Salary Payment Date</label>
                      </div>
                      <div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
                        <div class="row">
                        	<div class="col-xs-6 input-l">
                        		<select name="salary_payment_date" id="salary_payment_date" class="form-control input-sm basic-detail-input-style">
	                              <option value="" selected disabled>Select Date</option>
	                              @for($i=1;$i<=30;$i++)
									  <option value="{{$i}}" @if($salary_payment_date == $i){{'selected'}} @endif>{{$i}}</option>
								@endfor
	                             
	                             
	                            </select>
                        	</div>
                        	<div class="col-xs-6 input-r">
                        		<span style="position: relative; top: 6px; ">of Every Month</span>
                        	</div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
                          <label for="salary_mode" class="apply-leave-label">Salary Mode</label>
                        </div>
                        <div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
            							<select name="salary_mode" id="salary_mode" class="form-control input-sm basic-detail-input-style">
            								<option value="Pay & Collect" @if($salary_mode == "Pay & Collect"){{'selected'}} @endif>Pay & Collect</option>
            								<option value="Collect & Pay" @if($salary_mode == "Collect & Pay"){{'selected'}} @endif>Collect & Pay</option>
            							</select>
                        </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
                          <label for="esi_applicable" class="apply-leave-label">ESI Applicable</label>
                        </div>
                        <div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
            							<div class="radio">
            								<label>
            									<input type="radio" name="esi_applicable" id="" value="1" @if($esi_applicable == "1"){{'checked'}} @endif>Yes
            								</label>&nbsp;&nbsp;
            								<label>
            									<input type="radio" name="esi_applicable" id="" value="0" @if($esi_applicable == "0"){{'checked'}} @endif>No
            								</label>
            							</div>
                        </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
                          <label for="epf_applicable" class="apply-leave-label">EPF Applicable</label>
                        </div>
                        <div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
            							<div class="radio">
            								<label>
            									<input type="radio" name="epf_applicable" id="" value="1" @if($epf_applicable == "1"){{'checked'}} @endif>Yes
            								</label>&nbsp;&nbsp;
            								<label>
            									<input type="radio" name="epf_applicable" id="" value="0" @if($epf_applicable == "0"){{'checked'}} @endif>No
            								</label>
            							</div>
                        </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
                          <label for="gpa_applicable" class="apply-leave-label">GPA Applicable</label>
                        </div>
                        <div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
            							<div class="radio">
            								<label>
            									<input type="radio" name="gpa_applicable" id="" value="1" @if($gpa_applicable == "1"){{'checked'}} @endif>Yes
            								</label>&nbsp;&nbsp;
            								<label>
            									<input type="radio" name="gpa_applicable" id="" value="0" @if($gpa_applicable == "0"){{'checked'}} @endif>No
            								</label>
            							</div>
                        </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
                          <label for="wc_applicable" class="apply-leave-label">WC Applicable</label>
                        </div>
                        <div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
            							<div class="radio">
            								<label>
            									<input type="radio" name="wc_applicable" id="" value="1" @if($wc_applicable == "1"){{'checked'}} @endif>Yes
            								</label>&nbsp;&nbsp;
            								<label>
            									<input type="radio" name="wc_applicable" id="" value="0" @if($wc_applicable == "0"){{'checked'}} @endif>No
            								</label>
            							</div>
                        </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
                          <label for="margin" class="apply-leave-label">Margin (%)</label>
                        </div>
                        <div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
                          <input type="number" name="margin" id="margin" class="form-control input-sm basic-detail-input-style" placeholder="Enter Margin" value="{{$margin}}">
                        </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
                          <label for="security_charges" class="apply-leave-label">Security Charges</label>
                        </div>
                        <div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
            							<div class="radio">
            								<label>
            									<input type="radio" name="security_charges" id="" value="1" @if($security_charges == "1"){{'checked'}} @endif>Yes
            								</label>&nbsp;&nbsp;
            								<label>
            									<input type="radio" name="security_charges" id="" value="0" @if($security_charges == "0"){{'checked'}} @endif>No
            								</label>
            							</div>
                        </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
                          <label for="document_charges" class="apply-leave-label">Document Charges</label>
                        </div>
                        <div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
            							<div class="radio">
            								<label>
            									<input type="radio" name="document_charges" id="" value="1" @if($document_charges == "1"){{'checked'}} @endif>Yes
            								</label>&nbsp;&nbsp;
            								<label>
            									<input type="radio" name="document_charges" id="" value="0" @if($document_charges == "0"){{'checked'}} @endif>No
            								</label>
            							</div>
                        </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
                          <label for="online_application_charges" class="apply-leave-label">Online Application Charges</label>
                        </div>
                        <div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
            							<div class="radio">
            								<label>
            									<input type="radio" name="online_application_charges" id="" value="1" @if($online_application_charges == "1"){{'checked'}} @endif>Yes
            								</label>&nbsp;&nbsp;
            								<label>
            									<input type="radio" name="online_application_charges" id="" value="0" @if($online_application_charges == "0"){{'checked'}} @endif>No
            								</label>
            							</div>
                        </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
                          <label for="id_card" class="apply-leave-label">ID card</label>
                        </div>
                        <div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
            							<div class="radio">
            								<label>
            									<input type="radio" name="id_card" id="" value="1" @if($id_card == "1"){{'checked'}} @endif>Yes
            								</label>&nbsp;&nbsp;
            								<label>
            									<input type="radio" name="id_card" id="" value="0" @if($id_card == "0"){{'checked'}} @endif>No
            								</label>
            							</div>
                        </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
                          <label for="uniform" class="apply-leave-label">Uniform</label>
                        </div>
                        <div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
            							<div class="radio">
            								<label>
            									<input type="radio" name="uniform" id="" value="1" @if($uniform == "1"){{'checked'}} @endif>Yes
            								</label>&nbsp;&nbsp;
            								<label>
            									<input type="radio" name="uniform" id="" value="0" @if($uniform == "0"){{'checked'}} @endif>No
            								</label>
            							</div>
                        </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
                          <label for="offer_letter" class="apply-leave-label">Offer Letter</label>
                        </div>
                        <div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
            							<div class="radio">
            								<label>
            									<input type="radio" name="offer_letter" id="" value="1" @if($offer_letter == "1"){{'checked'}} @endif>Yes
            								</label>&nbsp;&nbsp;
            								<label>
            									<input type="radio" name="offer_letter" id="" value="0" @if($offer_letter == "0"){{'checked'}} @endif>No
            								</label>
            							</div>
                        </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
                          <label for="tic_or_Medical_insurance" class="apply-leave-label">TIC/Medical Insurance</label>
                        </div>
                        <div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
            							<div class="radio">
            								<label>
            									<input type="radio" name="tic_or_Medical_insurance" id="" value="1" @if($tic_or_Medical_insurance == "1"){{'checked'}} @endif>Yes
            								</label>&nbsp;&nbsp;
            								<label>
            									<input type="radio" name="tic_or_Medical_insurance" id="" value="0" @if($tic_or_Medical_insurance == "0"){{'checked'}} @endif>No
            								</label>
            							</div>
                        </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
                          <label for="additional_obligations" class="apply-leave-label">Additional obligations</label>
                        </div>
                        <div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
                          	<input type="text" class="form-control input-sm basic-detail-input-style" name="additional_obligations" id="additional_obligations" placeholder="Enter if any" value="{{$additional_obligations}}"> 
                        </div>
                    </div>
                  </div>

                  <h4 class="text-center" style="text-decoration: underline;"><b>Enclosure</b></h4>

                  <div class="form-group">
                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
                          <label for="agreement_with_customer" class="apply-leave-label">Agreement with Customer</label>
                        </div>
						
                        <div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
                          	<input type="file" name="agreement_with_customer" id=""><span class="viewFileSpan label label-default">@if(!empty(@$data['project_draft_values']['agreement_with_customer']))<a target="_blank" class="" href="{{config('constants.uploadPaths.projectDocument')}}{{@$data['project_draft_values']['agreement_with_customer']}}">view</a>@endif</span>
                        </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
                          <label for="proposed_agreement" class="apply-leave-label">Proposed Agreement with Employee</label>
                        </div>
                        <div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
                          	<input type="file" name="proposed_agreement" id=""><span class="viewFileSpan label label-default">@if(!empty(@$data['project_draft_values']['proposed_agreement']))<a target="_blank" class="" href="{{config('constants.uploadPaths.projectDocument')}}{{@$data['project_draft_values']['proposed_agreement']}}">view</a>@endif</span>
                        </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
                          <label for="offer_letter_format" class="apply-leave-label">Format of Offer Letter</label>
                        </div>
                        <div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
                          	<input type="file" name="offer_letter_format" id=""><span class="viewFileSpan label label-default">@if(!empty(@$data['project_draft_values']['offer_letter_format']))<a target="_blank" class="" href="{{config('constants.uploadPaths.projectDocument')}}{{@$data['project_draft_values']['offer_letter_format']}}">view</a>@endif</span>
                        </div>

                    </div>
                  </div>


                </div>
                <!-- Right column Ends here -->
              </div>
              <!-- Row Ends here -->
            </div>

            @php

	            if($link=='edit'){
	            	$project_id = @request('project_id');
	        	}else{
	            	$project_id = "";
	        	}	           
	           
	           if(@$data['counter_bg']==1){
	           		$class_bg="btn-success";
	           		$check_bg = "fa-check";
	       		}else{
	       			$class_bg="btn-default";
	       			$check_bg = "fa-circle-thin";
	       		}

	       		if(@$data['counter_it']==1){
	           		$class_it = "btn-success";
	           		$check_it = "fa-check";
	       		}else{
	       			$class_it = "btn-default";
	       			$check_it = "fa-circle-thin";
	       		}

	       		if(@$data['counter_ins']==1){
	           		$class_ins ="btn-success";
	           		$check_ins = "fa-check";
	       		}else{
	       			$class_ins = "btn-default";
	       			$check_ins = "fa-circle-thin";
	       		}
            @endphp
            <input type="hidden" name="project_id" value="{{@$project_id}}">
           @if(@request('project_id'))
            <div class="box-footer create-footer text-center">
      			<!-- 	<a href="{{ url('mastertables/project-jrf/'.$link.'/'.$project_id) }}">
      					<button type="button" class="btn btn-default btn-xs"><i class="fa fa-check"></i>JRF</button>
      				</a> -->
      				<a href="{{ url('mastertables/project-it-requirement/'.$link.'/'.$project_id) }}">
      					<button type="button" class="btn btn-xs {{$class_it}}"><i class="fa {{$check_it}}"></i>IT Requirement</button>
      				</a>
      				<a href="{{ url('mastertables/project-salary-structure/'.$link.'/'.$project_id) }}">
      					<button type="button" class="btn btn-default btn-xs"><i class="fa fa-circle-thin"></i>Salary Structure</button>
      				</a>
      				<a href="{{ url('mastertables/project-bg-form/'.$link.'/'.$project_id) }}">
      					<button type="button" class="btn btn-xs {{$class_bg}}"><i class="fa {{$check_bg}}"></i> BG</button>
      				</a>
      				<a href="{{ url('mastertables/project-insurance/'.$link.'/'.$project_id) }}">
      					<button type="button" class="btn {{$class_ins}} btn-xs"><i class="fa {{$check_ins}}"></i> Insurance</button>
      				</a>
      				<a href="{{ url('mastertables/project-advertisements/'.$link.'/'.$project_id) }}">
      					<button type="button" class="btn btn-default btn-xs"><i class="fa fa-circle-thin"></i> advertisements</button>
      				</a>
            </div>
            @endif
            <br>

             <div class="box-footer create-footer text-center">
			
              <input type="submit" class="btn btn-danger" id="save_as_draft" value="Save As Draft" name="save_as_draft_project_approval">
              @if(@request('project_id') AND @$data['counter_bg']==1 AND @$data['counter_it']==1 AND @$data['counter_ins']==1 AND !auth()->user()->can('approve-project'))
              <input type="submit" class="btn btn-success" id="save" value="Save and send for Approval" name="save">
              @endif
            </div>
             

          </form>

           <!-- Form Ends here -->
 <div class="box-footer create-footer text-center">

          @if(auth()->user()->can('approve-project') && isset($data['project_id']))
				@if($data['status'] == '1')
				<a class="btn bg-blue approveBtn" href='{{ url("mastertables/projects/approve/")."/".$data['project_id']}}' title="approve"><i class="fa fa-check" aria-hidden="true"></i>&nbsp; Save and Approve</a>
				<a class="btn bg-red rejectBtn" href='#' title="Send Back" data-toggle="modal" data-target="#project_InfoModal"><i class="fa fa-reply" aria-hidden="true"></i>&nbsp; Send Back</a>&nbsp;
				@endif
			@endif
</div>
         
			@if(isset($data['project_draft_values']['send_back_reason']) )
			<div class="form-group">
				<div class="row">
					<div class="col-md-2 col-sm-2 col-xs-2 leave-label-box label-470">
						<label for="agreement_signed" class="apply-leave-label">Sent back reasons: </label>
					</div>
					<div class="col-md- col-sm-8 col-xs-8 leave-input-box input-470">

						@foreach(@$data['project_draft_values']['send_back_reason'] as $reason)
							@if($reason!="")
						      <div class="reason_chat"><span >{{$reason}}</span>  </div><br/>
						     @endif
						@endforeach 
						         
					</div>
				</div>
			</div>
			@endif 

        </div>
        
      </div>
    </div>
  </section>
  <!-- Main content Ends Here-->


    <div class="modal fade" id="project_InfoModal">

      <div class="modal-dialog">

        <div class="modal-content">

          <div class="modal-header">

            <button type="button" class="close" data-dismiss="modal" aria-label="Close">

              <span aria-hidden="true">&times;</span></button>

            <h4 class="modal-title">Additional Information</h4>

          </div>

          <div class="modal-body projectInfoModalBody">
            <form action="{{ url('mastertables/projects/reject/')."/".@$data['project_id'] }}" type="post" name="send_back">
              {{ csrf_field() }}
              <div class="row">
                <div class="col-sm-12">
                  <label>Detailed Reason:</label><br>
                  <textarea rows="5" style="width: 100%;" name="reason"></textarea>
                </div>
              </div>
              <hr>
              <div class="create-footer text-center">
                <input type="submit" class="btn btn-primary" id="reson_id" value="Send" name="reaon_submit">
              </div>
            </form>
          </div>

        </div>
        <!-- /.modal-content -->
      </div>

    <!-- /.modal-dialog -->

    </div>

</div>

  <!-- /.content-wrapper -->

  <script src="{{asset('public/admin_assets/plugins/validations/jquery.validate.js')}}"></script>
  <script src="{{asset('public/admin_assets/plugins/validations/additional-methods.js')}}"></script>

  
  <script>
  
   //Datepicker Starts here
  $(function () {
    //Date picker
    $('.datepicker').datepicker({
      autoclose: true,
      orientation: "bottom",
      format: 'dd/mm/yyyy'
    });
  }); 
  //Datepicker Ends here

  //Validation Starts here
  $("#project_approval_handover").validate({
    rules: {
      "projectName" : {
        required: true
      },
      "gst_registration_number" : {
        required: true
      },
      "tan_number[]" : {
        required: true
      },
      "head_office_location" : {
        required: true
      },
      "head_office_address" : {
        required: true
      },
      "project_owner_department" : {
        required: true
      },
      "project_owner_name" : {
        required: true
      },
      "contact_person" : {
        required: true
      },
      "corres_office_address" : {
        required: true
      },
      "agreement_signed" : {
        required: true
      },

      "starting_of_project_date" : {
        required: true
      },
      "extendable" : {
        required: true
      },

      "scope" : {
        required: true
      },
      "tds_deduction" : {
        required: true
      },
      "bg_security" : {
        required: true
      },
    
      "location_state" : {
        required: true
      },
      "location_city" : {
        required: true
      },
      "resources_category[]" : {
        required: true
      },
      "billing_cycle_from" : {
        required: true
      },
      "billing_cycle_to" : {
        required: true
      },
      "salary_payment_date" : {
        required: true
      },
      "salary_mode" : {
        required: true
      },
      "esi_applicable" : {
        required: true
      },
      "epf_applicable" : {
        required: true
      },
      "gpa_applicable" : {
        required: true
      },
      "wc_applicable" : {
        required: true
      },
      "margin" : {
        required: true
      },
       "security_charges" : {
        required: true
      },
      "document_charges" : {
        required: true
      },
      "online_application_charges" : {
        required: true
      },
      "id_card" : {
        required: true
      },
      "uniform" : {
        required: true
      },
      "offer_letter" : {
        required: true
      },
      "tic_or_Medical_insurance" : {
        required: true
      },
       "additional_obligations" : {
        required: true
      }
    },
    errorPlacement: function(error, element) {
    if (element.hasClass('select2')) {
     error.insertAfter(element.next('span.select2'));
    }
    if ( element.is(":radio") ) {
        error.appendTo( element.parents('.radio') );
        error.css({
          'display' : 'block','padding-left' : '0px', 'font-weight':'bold'
          });
    }
     else {
     error.insertAfter(element);
    }
   },
    messages: {
      "projectName" : {
        required: 'Select project name'
      },
      "gst_registration_number" : {
        required: 'Enter GST number'
      },
      "tan_number[]" : {
        required: 'Enter TAN number'
      },
      "head_office_location" : {
        required: 'Select any option'
      },
      "head_office_address" : {
        required: 'Enter head office address'
      },
      "project_owner_department" : {
        required: 'Select department'
      },
      "project_owner_name" : {
        required: 'Select person'
      },
      "contact_person" : {
        required: 'Enter contact person name'
      },
      "corres_office_address" : {
        required: 'Enter address'
      },
      "agreement_signed" : {
        required: 'Select any option'
      },
      "starting_of_project_date" : {
        required: 'Select Date'
      },
      "extendable" : {
        required: 'Select scope'
      },
      "scope" : {
        required: 'Select scope'
      },
      "tds_deduction" : {
        required: 'Enter TDS deduction'
      },
      "bg_security" : {
        required: 'Select any option'
      },
    
      "location_state" : {
        required: 'Select State/States'
      },
      "location_city" : {
        required: 'Select City/Cities'
      },
      "resources_category[]" : {
        required: 'Please select Enter'
      },
      "billing_cycle_from" : {
        required: 'From'
      },
      "billing_cycle_to" : {
        required: 'To'
      },
      "salary_payment_date" : {
        required: 'Select any value' 
      },
       "salary_mode" : {
        required: 'Select salary mode'
      },
    "esi_applicable" : {
        required: 'Select esi applicable'
      },
      "epf_applicable" : {
        required: 'Select epf applicable'
      },
      "gpa_applicable" : {
        required: 'Select gpa applicable'
      },
      "wc_applicable" : {
        required: 'Select wc applicable'
      },
       "margin" : {
        required: 'Enter Margin'
      },
      "security_charges" : {
        required: 'Select security charges'
      },
      "document_charges" : {
        required: 'Select document charges'
      },
      "online_application_charges" : {
        required: 'Select online_application_charges'
      },
      "id_card" : {
        required: 'Select id card'
      },
      "uniform" : {
        required: 'Select uniform'
      },
      "offer_letter" : {
        required: 'Select offer letter'
      },
      "tic_or_Medical_insurance" : {
        required: 'Select tic/Medical insurance'
      },
      "additional_obligations" : {
        required: 'Select additional_obligations'
      }
    }
  });
  //Validation Ends here

  //Agreement Signed Condition Starts here
  $('.agreementValidity').hide();
  $('.agreementRemarks').hide();
  $(".agreementSign").on('click', function(){
  	var agreementSigned = $(this).val();
  	if (agreementSigned == 1) {
  		$('.agreementValidity').show();
  		$('.agreementRemarks input').val('');
  	} else {
  		$('.agreementValidity').hide();
  		$('.agreementRemarks').show();
  		$('.agreementValidity input').val('');
  	}
  });
  //Agreement Signed Condition Ends here

  //  bg or security starts here
  $('.bgsHide').hide();
  $('.bg_security').on('click', function(){
  	var bgOrSecurity = $(this).val();
  	if (bgOrSecurity == 1) {
  		$('.bgsHide').show();
  	} else {
  		$('.bgsHide').hide();
  		$('.bgsHide :input , .bgsHide select').val('');
  	}
  });
  //  bg or security ends here

  $(document).ready(function(){
	
  var i=0; 
  $('#add_new_tan_number').click(function(){ 

  $(".datepicker").datepicker("destroy");  
  i++;  
  
  $('form #tan_expand').append('<div class="row tan_row_id'+i+'" style="margin-top: 10px;"><div class="col-xs-10 input-l"><input type="text" class="form-control input-sm basic-detail-input-style" name="tan_number[]" id="" placeholder="Enter TAN Number" value=""></div><div class="col-xs-2 input-r"><a href="javascript:void(0)" id="'+i+'" class="remove_tan_row_id"><i class="fa fa-minus a_r_style a_r_style_red"></i></a></div></div>');
   

  $(".datepicker").datepicker({autoclose: true, orientation: "bottom", format: 'yyyy-mm-dd' });
  });   
  });
  
	$(document).on('click', '.remove_tan_row_id', function(){    

		var remove_id = $(this).attr("id"); 
		$('.tan_row_id'+remove_id+'').detach();   

	});
	
	$(document).ready(function(){

	  var i=0; 
	  $('#add_resource_category').click(function(){ 

	  $(".datepicker").datepicker("destroy");  
	  i++;  
	 
	  $('form #resource_expand').append('<div class="row resource_row_id'+i+'" style="margin-top: 10px;"><div class="col-xs-10 input-l"><input type="text" class="form-control input-sm basic-detail-input-style" name="resources_category['+i+']" id="" placeholder="Enter Resource Category or Description" value="" required></div><div class="col-xs-2 input-r"><a href="javascript:void(0)" id="'+i+'" class="remove_resource_row_id"><i class="fa fa-minus a_r_style a_r_style_red"></i></a></div></div>');
	    

	  $(".datepicker").datepicker({autoclose: true, orientation: "bottom", format: 'yyyy-mm-dd' });
	  });   
	});
	
	$(document).on('click', '.remove_resource_row_id', function(){    

		var remove_id = $(this).attr("id"); 
		$('.resource_row_id'+remove_id+'').detach();   

	});
	
	 /*if(action == 'add'){
        $('.location_city').empty();
      }     */

      $('.allState').on('change',function(){
        var allStateIds = $(this).val();
        //var companyId = $('#companyId').val();
		

        //$(".esiLocation").val('').change();
        $('.location_city').empty();
        
        if(allStateIds.length != 0){
          $.ajax({
            type: 'POST',
            url: "{{ url('mastertables/states-wise-locations') }}",
            data: {state_ids: allStateIds},
            success: function (result) {
              console.log('On change allState', result);

              if(result.locations.length != 0){
                  var displayString = '';
                  $.each(result.locations, function(key, value){
                    displayString += '<option value="'+value.id+'">'+value.name+'</option>';
                  });

                  $('.location_city').append(displayString);
              }

            }

          });
        }
      });
	
	
	$('.project_owner_department').on('change',function(){
		
        var allDepId = $(this).val();
        //var companyId = $('#companyId').val();
		

        //$(".esiLocation").val('').change();
        $('.location_city').empty();
        
        if(allDepId.length != 0){
          $.ajax({
            type: 'POST',
            url: "{{ url('mastertables/department-wise-person') }}",
            data: {DepartmentId: allDepId},
            success: function (result) {
              console.log('On change alldep', result);

              if(result.persons.length != 0){
                  var displayString = '';
                  $.each(result.persons, function(key, value){
                    displayString += '<option value="'+value.fullname+'">'+value.fullname+'</option>';
                  });

                  $('.project_owner_name').html(displayString);
              }

            }

          });
        }
      });
	
	
	
	
	
	
	
	
	
	
	
	
	
	

    $("#noProject").hide();

    var projectType = "{{@$data['project']->type}}";
    var tenureYears = "{{@$data['project']->tenure_years}}";
    var tenureMonths = "{{@$data['project']->tenure_months}}";

    if(projectType){
      $("#projectType").val(projectType);
    }

    if(tenureYears){
      $("#tenureYears").val(tenureYears);
    }

    if(tenureMonths){
      $("#tenureMonths").val(tenureMonths);
    }

    $("#projectForm").validate({

      rules :{

          "projectName" : {

              required : true,

              lettersonly : true

          },

          "projectAddress" : {

              required : true,

          },

          "employeeIds[]" : {

              required : true,

          },

          "companyId" : {

              required : true

          },

          "salaryStructureId" : {

              required : true

          },

          "salaryCycleId" : {

              required : true

          },

          "noOfResources" : {

              required : true,

              digits : true

          },

          "projectAgreement" : {

              extension: "jpeg|jpg|pdf",

              filesize: 1048576   //1 MB

          },

          "offerLetterFile" : {

              extension: "jpeg|jpg|pdf",

              filesize: 1048576   //1 MB

          },

          "stateId[]" : {

              required : true,

          },

          "locationId[]" : {

              //required : true,

          }

      },

      errorPlacement: function(error, element) {
        if (element.hasClass('select2')) {
          error.insertAfter(element.next('span.select2'));
        } else {
          error.insertAfter(element);
        }
      },

      messages :{

          "projectName" : {

              required : 'Please enter project name.',

          },

          "projectAddress" : {

              required : 'Please enter project address.'

          },

          "employeeIds[]" : {

              required : 'Please select a responsible person.'

          },

          "companyId" : {

              required : 'Please select a company.'

          },

          "salaryStructureId" : {

              required : 'Please select a salary structure.'

          },

          "salaryCycleId" : {

              required : 'Please select a salary cycle.'

          },

          "noOfResources" : {

              required : 'Please enter the number of resources.'

          },

          "projectAgreement" : {

              extension : 'Please select a file in jpg, jpeg or pdf format only.',

              filesize: 'Filesize should be less than 1 MB.'  

          },

          "offerLetterFile" : {

              extension : 'Please select a file in jpg, jpeg or pdf format only.',

              filesize: 'Filesize should be less than 1 MB.'  

          },

          "stateId[]" : {

              required : 'Please select PT state.',

          },

          "locationId[]" : {

              //required : 'Please select ESI location.',

          }

      }

    });



    $("#contactDetailsForm").validate({

      rules :{

          "name" : {

              required : true

          },

          "mobileNo" : {

              required : true,

              digits : true

          },

          "email" : {

              required : true,

              email : true

          },

          "role" : {

            required : true

          }

      },

      messages :{

          "name" : {

              required : 'Please enter name.',

          },

          "mobileNo" : {

              required : 'Please enter mobile number.'

          },

          "email" : {

              required : 'Please enter email.'

          },

          "role" :{

              required : 'Please enter role.'

          }

      }

    });



    $("#editContactForm").validate({

      rules :{

          "name" : {

              required : true

          },

          "mobileNo" : {

              required : true,

              digits : true

          },

          "email" : {

              required : true,

              email : true

          },

          "role" : {

            required : true

          }

      },

      messages :{

          "name" : {

              required : 'Please enter name.',

          },

          "mobileNo" : {

              required : 'Please enter mobile number.'

          },

          "email" : {

              required : 'Please enter email.'

          },

          "role" :{

              required : 'Please enter role.'

          }

      }

    });

    $.validator.addMethod("lettersonly", function(value, element) {
      return this.optional(element) || /^[a-z," "]+$/i.test(value);
    }, "Please enter only alphabets and spaces.");

    $.validator.addMethod('filesize', function(value, element, param) {
      return this.optional(element) || (element.files[0].size <= param) 
    });

  </script>



  <script type="text/javascript">

    var allowContactSubmit = {mobile: 1, email: 1};
    var allowEditContactSubmit = {mobile: 1, email: 1};
    var allowProjectSubmit = {loi: 1, employeeContract: 1, offerLetter: 1, pt: 1, esi: 1};

    $(document).ready(function(){

      var tabName = "{{$last_tabname}}";

      $('.nav-tabs a[href="#tab_'+tabName+'"]').tab('show');

      var defaultCompanyId = $('#companyId').val();
      var action = "{{$data['action']}}";

    



    

     

 

      $('.esiLocation').on('change',function(){
        var esiLocationIds = $(this).val();
        var companyId = $('#companyId').val();

        if(esiLocationIds.length != 0){
          $.ajax({
            type: 'POST',
            url: "{{ url('mastertables/company-esi-no') }}",
            data: {company_id: companyId,location_ids: esiLocationIds},
            success: function (result) {
              console.log('On load esi', result);

              $("#esiNoBox").html("");
              var displayString = "";

              $.each(result, function(key, value){
                  displayString += '<label for="esiNo">'+value.location.name+' ESI Number</label>';

                  if(value.location.has_esi == 0){
                    displayString += '<input type="text" class="form-control esiNo" name="esiNo" value="No ESI in this location." readonly><br>';

                  }else if(value.esi_data){                
                    displayString += '<input type="text" class="form-control esiNo" name="esiNo" value="'+value.esi_data.esi_number+'" readonly><br>';

                  }else{                    
                    displayString += '<input type="text" class="form-control esiNo error" name="esiNo" style="color:#f00;" value="Has ESI but not added for selected company. Please add it first." readonly><br>';
                  }
                
              });

              $('#esiNoBox').prepend(displayString);

              if($(".esiNo").hasClass("error")){
                allowProjectSubmit.esi = 0;
              }else{
                allowProjectSubmit.esi = 1;
              }
            }
          });

        }else{

          $("#esiNoBox").html("");

        }

      }).change();

    });

  </script>



  <script type="text/javascript">

    var action = "{{@$data['action']}}";
    
    $("#projectFormSubmit").on('click',function(){

      if(action == "add"){
          var agreementFile = document.getElementById('agreementFile');
          var loiFile = document.getElementById('loiFile');
          var offerLetterFile = document.getElementById('offerLetterFile');

          var employeeContract1File = document.getElementById('employeeContract1File');
          var employeeContract2File = document.getElementById('employeeContract2File');
          var employeeContract3File = document.getElementById('employeeContract3File');

          if((agreementFile.files.length + loiFile.files.length) == 0){
            allowProjectSubmit.loi = 0;
            $(".loiErrors").text("Please upload either one of agreement file or loi file.").css("color","#f00");
            return false;
          }else{
            allowProjectSubmit.loi = 1;
            $(".loiErrors").text("");
          }

          if((offerLetterFile.files.length) == 0){
            allowProjectSubmit.offerLetter = 0;
            $(".offerLetterErrors").text("Please upload a offer letter file.").css("color","#f00");
            return false;
          }else{
            allowProjectSubmit.offerLetter = 1;
            $(".offerLetterErrors").text("");
          }

          if((employeeContract1File.files.length + employeeContract2File.files.length + employeeContract3File.files.length) == 0){
            allowProjectSubmit.employeeContract = 0;
            $(".employeeContractErrors").text("Please upload either one of employee contract file.").css("color","#f00");
            return false;
          }else{
            allowProjectSubmit.employeeContract = 1;
            $(".employeeContractErrors").text("");
          }

          if(allowProjectSubmit.offerLetter == 0 || allowProjectSubmit.loi == 0 || allowProjectSubmit.employeeContract == 0 || allowProjectSubmit.pt == 0 || allowProjectSubmit.esi == 0){
            return false;
          
          }else if(allowProjectSubmit.offerLetter == 1 && allowProjectSubmit.loi == 1 && allowProjectSubmit.employeeContract == 1 || allowProjectSubmit.pt == 1 || allowProjectSubmit.esi == 1){
            $("#projectForm").submit();
          }
      }else{ //edit
        $("#projectForm").submit();
      }
      
    });

    $("#contactDetailsFormSubmit").on('click',function(){
      var action = "{{$data['action']}}";

      if(action == 'add'){
        var currentProject = "{{@$last_inserted_project}}";
      }else{
        var currentProject = $("#projectId").val();
      }

      if(currentProject == "0"){
        $("#noProject").show();
        $("#noProject").fadeOut(6000);

        return false;

      }else{

        if(allowContactSubmit.email == 1 && allowContactSubmit.mobile == 1){
          $("#noProject").hide();
          $("#contactDetailsForm").submit();

        }else{
          return false;

        }

      }

    });

    $("#editContactFormSubmit").on('click',function(){
        if(allowEditContactSubmit.email == 1 && allowEditContactSubmit.mobile == 1){
          $("#editContactForm").submit();
        }else{
          return false;
        }

    });

    $(".editContact").on('click',function(){
        var name = $(this).data('name');
        var email = $(this).data('email');
        var role = $(this).data('role');
        var mobile = $(this).data('mobile');
        var contactId = $(this).data('contactid');
        var projectId = $("#projectId").val();

        $("#nameModal").val(name);
        $("#roleModal").val(role);
        $("#emailModal").val(email);
        $("#mobileNoModal").val(mobile);
        $("#projectIdModal").val(projectId);
        $("#contactIdModal").val(contactId);
        $("#editContactModal").modal('show');

    });

  </script>

  @endsection
  
  
  
  
  
  
  