@extends('admins.layouts.app')

@section('content')

<!-- Content Wrapper Starts here -->
<div class="content-wrapper">

  <!-- Content Header Starts here -->
  <section class="content-header">
    <h1>Additional Details</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Dashboard</li>
    </ol>
  </section>
  <!-- Content Header Ends here -->
  
  <!-- Main content Starts here -->
  <section class="content">
    <div class="row">
      <div class="col-sm-12">
        <div class="box box-primary">
       @php  
		@$project_name = $projects['project_approval']->projectName;
		@$gst_no = $projects['project_approval']->gst_number;
		@$tan = $projects['project_approval']->tan_number;
		@$h_o_loc = $projects['project_approval']->h_o_location;
		@$h_o_add = $projects['project_approval']->h_o_address;
		@$dep_name =  $projects['project_approval']->department->name;
		@$proj_owner = $projects['project_approval']->project_owner;
		@$cont_name = $projects['project_approval']->contact_person_name;
		@$off_add = $projects['project_approval']->official_address;

		if(@$projects['project_approval']->agreement_signed ==0){
			$agreemnt_sign = "No";
		}else{
			$agreemnt_sign = "Yes";
		}

		@$agreemnt_validity = $projects['project_approval']->agreement_validity;
		@$agreemnt_remark = $projects['project_approval']->agreement_remark;

		@$proj_start_date = $projects['project_approval']->project_start_date;
		@$tenure_years = $projects['project_approval']->tenure_years;
		@$tenure_months = $projects['project_approval']->tenure_months;

		if(@$projects['project_approval']->extendable ==0){
			$extendable = "No";
		}else{
			$extendable = "Yes";
		}

		@$scope = $projects['project_approval']->scope;
		@$tds_deduct = $projects['project_approval']->tds_deduct;

		if(@$projects['project_approval']->security_required ==0){
			$security_required = "No";
		}else{
			$security_required = "Yes";
		}

		@$security_type = $projects['project_approval']->security_type;
		@$security_amount = $projects['project_approval']->security_amount;

		@$security_status = $projects['project_approval']->security_status;
		@$security_valadity = $projects['project_approval']->security_valadity;
		//$project_location_state = $projects['project_approval']->project_location_state;
		//$project_location_city = $projects['project_approval']->project_location_city;
		@$resource_category = $projects['project_approval']->resource_category;
		@$billing_cycle_from = $projects['project_approval']->billing_cycle_from;
		@$billing_cycle_to = $projects['project_approval']->billing_cycle_to;
		@$salary_date = $projects['project_approval']->salary_date;
		@$salary_mode = $projects['project_approval']->salary_mode;

		if(@$projects['project_approval']->esi_apply ==0){
			$esi_apply = "No";
		}else{
			$esi_apply = "Yes";
		}

		if(@$projects['project_approval']->epf_apply ==0){
			$epf_apply = "No";
		}else{
			$epf_apply = "Yes";
		}

		if(@$projects['project_approval']->gpa_apply ==0){
			$gpa_apply = "No";
		}else{
			$gpa_apply = "Yes";
		}

		if(@$projects['project_approval']->wc_apply ==0){
			$wc_apply = "No";
		}else{
			$wc_apply = "Yes";
		}		

		@$margin = $projects['project_approval']->margin;

		if(@$projects['project_approval']->security_charges ==0){
			$security_charges = "No";
		}else{
			$security_charges = "Yes";
		}

		if(@$projects['project_approval']->document_charges ==0){
			$document_charges = "No";
		}else{
			$document_charges = "Yes";
		}

		if(@$projects['project_approval']->online_app_charges ==0){
			$online_app_charges = "No";
		}else{
			$online_app_charges = "Yes";
		}

		if(@$projects['project_approval']->id_card ==0){
			$id_card = "No";
		}else{
			$id_card = "Yes";
		}

		if(@$projects['project_approval']->uniform ==0){
			$uniform = "No";
		}else{
			$uniform = "Yes";
		}

		if(@$projects['project_approval']->offer_letter ==0){
			$offer_letter = "No";
		}else{
			$offer_letter = "Yes";
		}

		if(@$projects['project_approval']->insurance ==0){
			$insurance = "No";
		}else{
			$insurance = "Yes";
		}
		
		@$additional_obligations = $projects['project_approval']->additional_obligations;



		//bg form

		@$tender_name = $projects['bg_data']->tender_name;
		@$form = $projects['bg_data']->form;
		@$amount = $projects['bg_data']->amount;
		@$in_favour = $projects['bg_data']->in_favour;
		@$date_required = $projects['bg_data']->date_required;
		@$bg_valadity_date = $projects['bg_data']->bg_valadity_date;
		@$margin_percentage = $projects['bg_data']->margin_percentage;
		@$bg_charges_percentage = $projects['bg_data']->bg_charges_percentage;
		@$gst_percentage = $projects['bg_data']->gst_percentage;
		@$margin = $projects['bg_data']->margin;
		@$bg_charges = $projects['bg_data']->bg_charges;
		@$gst = $projects['bg_data']->gst;
		@$total = $projects['bg_data']->total;
		
		
		//it form 
		@$sms = $projects['it_data']->sms;
		@$sms_no = $projects['it_data']->sms_no;
		@$email = $projects['it_data']->email;
		@$email_no = $projects['it_data']->email_no;
		@$jrf = $projects['it_data']->jrf;
		@$takeover = $projects['it_data']->takeover;

		if(@$projects['it_data']->naukri_check==1){
			$naukri_check = "Yes";
		}else{
			$naukri_check = "No";
		}
		
		@$naukri_quantity = $projects['it_data']->naukri_quantity;
		@$naukri_cost = $projects['it_data']->naukri_cost;

		if(@$projects['it_data']->xeam_job_check==1){
			$xeam_job_check = "Yes";
		}else{
			$xeam_job_check = "No";
		}
		
		@$xeam_job_quantity = $projects['it_data']->xeam_job_quantity;
		@$xeam_job_cost = $projects['it_data']->xeam_job_cost;

		if(@$projects['it_data']->monster_check==1){
			$monster_check = "Yes";
		}else{
			$monster_check = "No";
		}
		
		@$monster_quantity = $projects['it_data']->monster_quantity;
		@$monster_cost = $projects['it_data']->monster_cost;
		@$content = $projects['it_data']->content;
		


		//insurance data
		@$tender_name = $projects['ins_data']->tender_name;
		@$insurance_type = $projects['ins_data']->insurance_type;
		@$insurance_text = $projects['ins_data']->insurance_text;
		@$insurance_plan = $projects['ins_data']->insurance_plan;
		@$premium_amount = $projects['ins_data']->premium_amount;
		@$in_favor = $projects['ins_data']->in_favor;
		@$date_required = $projects['ins_data']->date_required;
		@$peers_no = $projects['ins_data']->peers_no;
		@$peers_note = $projects['ins_data']->peers_note;
		@$expense_borne_by = $projects['ins_data']->expense_borne_by;
		@$project_margin_percentage = $projects['ins_data']->project_margin_percentage;
		@$project_margin_amount = $projects['ins_data']->project_margin_amount;
		@$tenure_years = $projects['ins_data']->tenure_years;
		@$tenure_months = $projects['ins_data']->tenure_months;
		@$invoice_no = $projects['ins_data']->invoice_no;
		@$person = $projects['ins_data']->person;
		@$amount = $projects['ins_data']->amount;
		@$remark = $projects['ins_data']->remark;
		
		
		
		@endphp 
			<div class="box-body">
				<!-- Tabs Content Starts here -->
				<div class="nav-tabs-custom">
					<ul class="nav nav-tabs edit-nav-styling">
					  <li class="active"><a href="#projectHandover" data-toggle="tab">Project Handover</a></li>
					  <li><a href="#jrf" data-toggle="tab">JRF</a></li>
					  <li><a href="#itRequirement" data-toggle="tab">IT Requirement</a></li>
					  <li><a href="#salaryStructure" data-toggle="tab">Salary Structure</a></li>
					  <li><a href="#bg" data-toggle="tab">BG</a></li>
					  <li><a href="#insurance" data-toggle="tab">Insurance</a></li>
					  <li><a href="#advertisement" data-toggle="tab">Advertisement</a></li>
					</ul>
					<div class="tab-content">
						
					<!-- Project Handover Tab Starts here -->
					<div class="active tab-pane" id="projectHandover">
						<!-- Row starts here -->
						<div class="row">
							<!-- Left column starts here -->
							<div class="col-md-6">
								<div class="form-group">
									<div class="row">
										<div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
											<label>Name of Project</label>
										</div>
										<div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
											<span>{{$project_name}}</span>
										</div>
									</div>
								</div>

								<div class="form-group">
									<div class="row">
										<div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
											<label>GST Registration No.</label>
										</div>
										<div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
											<span>{{$gst_no}}</span>
										</div>
									</div>
								</div>

								<div class="form-group">
									<div class="row"> 
										<div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470"> 
											<label>TAN No.</label>
										</div>
										<div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470" id="tan_expand">
											<span>{{$tan}}</span>
										</div>
									</div>
								</div>

								<div class="form-group">
									<div class="row">
										<div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
											<label>Head Office Location</label>
										</div>
										<div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
											<span>{{$h_o_loc}}</span>
										</div>
									</div>
								</div>

								<div class="form-group">
									<div class="row">
										<div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
											<label>Head Office Address</label>
										</div>
										<div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
											<span>{{$h_o_add}}</span>
										</div>
									</div>
								</div>

								<div class="form-group">
									<div class="row">
										<div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
											<label>Project Owner</label>
										</div>
										<div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
											<span>Department: {{$dep_name}}</span>&nbsp;
											<span>Person: {{$proj_owner}}</span>
										</div>
									</div>
								</div>

								<div class="form-group">
									<div class="row">
										<div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
										<label>Name of Contact Person</label>
										</div>
										<div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
											<span>{{$cont_name}}</span>
										</div>
									</div>
								</div>

								<div class="form-group">
									<div class="row">
										<div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
											<label>Official Address for Correspondence</label>
										</div>
										<div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
											<span>{{$off_add}}</span>
										</div>
									</div>
								</div>

								<div class="form-group">
									<div class="row">
										<div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
											<label>Agreement Signed</label>
										</div>
										<div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
											<span>{{$agreemnt_sign}}</span>
										</div>
									</div>
								</div>

								<div class="form-group agreementValidity">
									<div class="row">
										<div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
										<label>Agreement Validity</label>
										</div>
										<div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
											<span>@if($agreemnt_validity){{$agreemnt_validity}} @else N/A @endif</span>
										</div>
									</div>
								</div>

								<div class="form-group agreementRemarks">
									<div class="row">
										<div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
											<label>Agreement Remarks</label>
										</div>
										<div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
											<span>@if($agreemnt_remark){{$agreemnt_remark}} @else N/A @endif</span>
										</div>
									</div>
								</div>

								<div class="form-group">
									<div class="row">
										<div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
											<label>Date of Start of Project</label>
										</div>
										<div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
										<span>{{$proj_start_date}}</span>
										</div>
									</div>
								</div>

								<div class="form-group">
									<div class="row">
										<div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
											<label>Period of Contract</label>
										</div>
										<div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
											<span>Years: {{$tenure_years}}</span>&nbsp;
											<span>Month: {{$tenure_months}}</span>
										</div>
									</div>
								</div>

								<div class="form-group">
									<div class="row">
										<div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
											<label>Extendable</label>
										</div>
										<div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
											<span>{{$extendable}}</span>
										</div>
									</div>
								</div>

								<div class="form-group">
									<div class="row">
										<div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
											<label>Scope</label>
										</div>
										<div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
											<span>{{$scope}}</span>
										</div>
									</div>
								</div>

								<div class="form-group">
									<div class="row">
										<div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
											<label>TDS % to be Deducted</label>
										</div>
										<div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
											<span>{{$tds_deduct}}</span>
										</div>
									</div>
								</div>

								<div class="form-group">
									<div class="row">
										<div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
										<label>BG or Security Required</label>
										</div>
										<div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
											<span>{{$security_required}}</span>
										</div>
									</div>
								</div>

								<div class="form-group bgsHide">
									<div class="row">
										<div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
											<label>BG or Security to Client<br>(Amount & Shape)</label>
										</div>
										<div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
											<span>Type: {{$security_type}}</span>&nbsp;
											<span>Amount: {{$security_amount}}</span>&nbsp;
											<span>Status: {{$security_status}}</span>
										</div>
									</div>
								</div>
									
								<div class="form-group bgsHide">
									<div class="row">
										<div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
											<label>BG or Security to Client<br>(Validity)</label>
										</div>
										<div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
											<span>@if($security_valadity) {{$security_valadity}} @else N/A @endif</span>
										</div>
									</div>
								</div>

								<div class="form-group">
									<div class="row">
										<div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
											<label>Project Location</label>
										</div>
										<div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
											<span>State: State here</span>&nbsp; <br/>
											<span>City: (City here)</span>
										</div>
									</div>
								</div>

								<div class="form-group">
									<div class="row"> 
										<div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470"> 
											<label>Category of Resources</label>
										</div>
										<div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470" id="resource_expand">
											<span>{{$resource_category}}</span>
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
											<label>Billing Cycle</label>
										</div>
										<div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
											<span>From - {{$billing_cycle_from}}</span>&nbsp;
											<span>To - {{$billing_cycle_to}}</span>&nbsp;
											<span>of every Month</span>
										</div>
									</div>
								</div>

								<div class="form-group">
									<div class="row">
										<div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
											<label>Salary Payment Date</label>
										</div>
										<div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
											<span>{{$salary_date}}</span>&nbsp;
											<span>of every Month</span>
										</div>
									</div>
								</div>

								<div class="form-group">
									<div class="row">
										<div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
											<label>Salary Mode</label>
										</div>
										<div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
											<span>{{$salary_mode}}</span>
										</div>
									</div>
								</div>

							<div class="form-group">
								<div class="row">
									<div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
										<label>ESI Applicable</label>
									</div>
									<div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
										<span>{{$esi_apply}}</span>
									</div>
								</div>
							</div>

							<div class="form-group">
								<div class="row">
									<div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
										<label>EPF Applicable</label>
									</div>
									<div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
										<span>{{$epf_apply}}</span>
									</div>
								</div>
							</div>

							<div class="form-group">
								<div class="row">
									<div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
										<label>GPA Applicable</label>
									</div>
									<div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
										<span>{{$gpa_apply}}</span>
									</div>
								</div>
							</div>

							<div class="form-group">
								<div class="row">
									<div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
										<label>WC Applicable</label>
									</div>
									<div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
										<span>{{$wc_apply}}</span>
									</div>
								</div>
							</div>

							<div class="form-group">
								<div class="row">
									<div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
									<label>Margin (%)</label>
									</div>
									<div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
										<span>{{$margin}}</span>
									</div>
								</div>
							</div>

							<div class="form-group">
								<div class="row">
									<div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
										<label>Security Charges</label>
									</div>
									<div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
										<span>{{$security_charges}}</span>
									</div>
								</div>
							</div>

							<div class="form-group">
								<div class="row">
									<div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
										<label>Document Charges</label>
									</div>
									<div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
										<span>{{$document_charges}}</span>
									</div>
								</div>
							</div>

							<div class="form-group">
								<div class="row">
									<div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
										<label>Online Application Charges</label>
									</div>
									<div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
										<span>{{$online_app_charges}}</span>
									</div>
								</div>
							</div>

							<div class="form-group">
								<div class="row">
									<div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
										<label>ID card</label>
									</div>
									<div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
										<span>{{$id_card}}</span>
									</div>
								</div>
							</div>

							<div class="form-group">
								<div class="row">
									<div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
										<label>Uniform</label>
									</div>
									<div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
										<span>{{$uniform}}</span>
									</div>
								</div>
							</div>

							<div class="form-group">
								<div class="row">
									<div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
										<label>Offer Letter</label>
									</div>
									<div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
										<span>{{$offer_letter}}</span>
									</div>
								</div>
							</div>

							<div class="form-group">
								<div class="row">
									<div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
										<label>TIC/Medical Insurance</label>
									</div>
									<div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
										<span>{{$insurance}}</span>
									</div>
								</div>
							</div>

							<div class="form-group">
								<div class="row">
									<div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
										<label>Additional obligations</label>
									</div>
									<div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
										<span>{{$additional_obligations}}</span>
									</div>
								</div>
							</div>

							<h4 class="text-center" style="text-decoration: underline;"><b>Enclosure</b></h4>

							<div class="form-group">
								<div class="row">
									<div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
										<label>Agreement with Customer</label>
									</div>
									<div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
										<span>File name here</span>
									</div>
								</div>
							</div>

							<div class="form-group">
								<div class="row">
									<div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
										<label>Proposed Agreement with Employee</label>
									</div>
									<div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
										<span>File name here</span>
									</div>
								</div>
							</div>

							<div class="form-group">
								<div class="row">
									<div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
										<label>Format of Offer Letter</label>
									</div>
									<div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
										<span>File name here</span>
									</div>
								</div>
							</div>


							</div>
							<!-- Right column Ends here -->
						</div>
						<!-- Row Ends here -->


					</div>
					<!-- Project Handover Tab Ends here -->

					<!-- JRF Tab Starts here -->
					<div class="tab-pane" id="jrf">
						JRF Contents
					</div>
					<!-- JRF Tab Ends here -->

					<!-- IT Requirement Tab Starts here -->
					<div class="tab-pane" id="itRequirement">
						<div class="row">
							<h4 class="text-center" style="text-decoration: underline;"><b>IT Requirement</b></h4>
							<div class="col-md-3">
								<div class="form-group">
									<div class="row">
										<div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
										<label>SMS</label>
										</div>
										<div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
											<span>{{$sms}}</span>
										</div>
									</div>
								</div>

								<div class="form-group smsNumber">
									<div class="row">
										<div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
										<label>Number of SMS</label>
										</div>
										<div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
											<span>@if($sms_no) {{$sms_no}} @else N/A @endif</span>
										</div>
									</div>
								</div>
							</div>

							<div class="col-md-3">
								<div class="form-group">
									<div class="row">
										<div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
										<label>Email</label>
										</div>
										<div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
											<span>{{$email}}</span>
										</div>
									</div>
								</div>

								<div class="form-group emailNumber">
									<div class="row">
										<div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
											<label>Number of Email</label>
										</div>
										<div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
											<span>@if($email_no) {{$email_no}} @else N/A @endif</span>
										</div>
									</div>
								</div>
							</div>

							<div class="col-md-3">
								<div class="form-group">
									<div class="row">
										<div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
										<label>JRF</label>
										</div>
										<div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
											<span>{{$jrf}}</span>
										</div>
									</div>
								</div>
							</div>

							<div class="col-md-3">
							<div class="form-group">
								<div class="row">
									<div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
									<label>Takeover</label>
									</div>
									<div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
										<span>{{$takeover}}</span>
									</div>
								</div>
							</div>
							</div>
						</div>
						<!-- Row Ends Here -->

						<div class="row">
							<div class="col-md-6">
								<h4 class="text-center" style="text-decoration: underline;"><b>Advertisement</b></h4>
								<table class="table table-bordered table-striped">
									<tr>
										<th>Through</th>
										<th>Quantity</th>
										<th>Costs</th>
									</tr>
									<tr>
										<td>Naukri</td>
										<td>@if($naukri_quantity) {{$naukri_quantity}} @else N/A @endif</td>
										<td>@if($naukri_cost) {{$naukri_cost}} @else N/A @endif</td>
									</tr>
									<tr>
										<td>Xeam Job</td>
										<td>@if($xeam_job_quantity) {{$xeam_job_quantity}} @else N/A @endif</td>
										<td>@if($xeam_job_cost) {{$xeam_job_cost}} @else N/A @endif</td>
										</tr>
									<tr>
										<td>Monster</td>
										<td>@if($monster_quantity) {{$monster_quantity}} @else N/A @endif</td>
										<td>@if($monster_cost) {{$monster_cost}} @else N/A @endif</td>
									</tr>
								</table>
							</div>

							<div class="col-md-6">
								<h4 class="text-center" style="text-decoration: underline;"><b>Content</b></h4>
								<div class="form-group" id="content_expand">
									<div class="row main-row"> 
										<div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470"> 
											<label for="" class="apply-leave-label">Content 1</label>
										</div>
										<div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
											{{$content}}
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- IT Requirement Tab Ends here -->

					<!-- Salary Structure Tab Starts here -->
					<div class="tab-pane" id="salaryStructure">
					  	Salary Structure content here
					</div>
					<!-- Salary Structure Tab Ends here -->

					<!-- BG Tab Starts here -->
					<div class="tab-pane" id="bg">
						<!-- Row starts here -->
						<div class="row">
							<!-- Left column starts here -->
							<div class="col-md-6">
							<div class="form-group">
								<div class="row">
									<div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
									<label>Tender Name</label>
									</div>
									<div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
										<span>{{$tender_name}}</span>
									</div>
								</div>
							</div>

							<div class="form-group">
								<div class="row">
									<div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
									<label>Form</label>
									</div>
									<div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
										<span>{{$form}}</span>
									</div>
								</div>
							</div>

							<div class="form-group">
								<div class="row">
									<div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
									<label>Amount</label>
									</div>
									<div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
										<span>{{$amount}}</span>
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
										<label>In favor of</label>
										</div>
										<div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
											<span>{{$in_favour}}</span>
										</div>
									</div>
								</div>

								<div class="form-group">
									<div class="row">
										<div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
										<label>Date when required</label>
										</div>
										<div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
											<span>{{$date_required}}</span>
										</div>
									</div>
								</div>

								<div class="form-group">
									<div class="row">
										<div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
										<label>Validity Date of BG</label>
										</div>
										<div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
											{{$bg_valadity_date}}
										</div>
									</div>
								</div>
							
							</div>
							<!-- Right column Ends here -->
						</div>
						<!-- Row Ends here -->
						<hr>

						<h4 class="text-center" style="text-decoration: underline;">For Accounts Department</h4>
						<div class="row">
							<div class="col-md-8 col-md-offset-2">
								<table class="table table-bordered table-striped">
									<tr>
										<td>
											<span>Margin (%): {{$margin_percentage}}</span>
										</td>
										<th>Margin</th>
										<td>
											<span>{{$margin}}</span>
										</td>
									</tr>
									<tr>
										<td>
											<span>Bg Charges (%): {{$bg_charges_percentage}}</span>
										</td>
										<th>Bg Charges</th>
										<td>
											<span>{{$bg_charges}}</span>
										</td>
									</tr>
									<tr>
										<td>
											<span>GST (%): {{$gst_percentage}}</span>
										</td>
										<th>GST</th>
										<td>
											<span>{{$gst }}</span>
										</td>
									</tr>
									<tr>
										<td>-</td>
										<th>Total Charges</th>
										<td>
											<span>{{$total}}</span>
										</td>
									</tr>
								</table>
							</div>
						</div>

						<hr>
					</div>
					<!-- BG Tab Ends here -->

					<!-- Insurance Tab Starts here -->
					<div class="tab-pane" id="insurance">
						<!-- Row starts here -->
						<div class="row">
							<!-- Left column starts here -->
							<div class="col-md-6">
								<div class="form-group">
									<div class="row">
										<div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
											<label>Tender Name</label>
										</div>
										<div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
											<span>{{$tender_name}}</span>
										</div>
									</div>
								</div>

								<div class="form-group">
									<div class="row">
										<div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
											<label>Insurance Type</label>
										</div>
										<div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
											<span>Type: {{$insurance_type}}</span>&nbsp;
											<span>Text: {{$insurance_text}}</span>
										</div>
									</div>
								</div>

								<div class="form-group">
									<div class="row">
										<div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
											<label>Insurance Plan</label>
										</div>
										<div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
											<span>{{$insurance_plan}}</span>
										</div>
									</div>
								</div>

								<div class="form-group">
									<div class="row">
										<div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
											<label>Total Premium Amount</label>
										</div>
										<div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
											<span>{{$premium_amount}}</span>
										</div>
									</div>
								</div>

								<div class="form-group">
									<div class="row">
										<div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
											<label>In favor of</label>
										</div>
										<div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
											<span>{{$in_favor}}</span>
										</div>
									</div>
								</div>

								<div class="form-group">
									<div class="row">
										<div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
											<label>Date when required</label>
										</div>
										<div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
											<span>{{$date_required}}</span>
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
											<label>No. of Peers/Lives</label>
										</div>
										<div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
											<span>{{$peers_no}}</span>&nbsp;
											<span>{{$peers_note}}</span>
										</div>
									</div>
								</div>

								<div class="form-group">
									<div class="row">
										<div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
											<label>Expense to be Borne By</label>
										</div>
										<div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
											<span>{{$expense_borne_by}}</span>
										</div>
									</div>
								</div>

								<div class="form-group">
									<div class="row">
										<div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
											<label>Project Margin (%age)</label>
										</div>
										<div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
											<span>{{$project_margin_percentage}}</span>
										</div>
									</div>
								</div>

								<div class="form-group">
									<div class="row">
										<div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
											<label>Project Margin Amount</label>
										</div>
										<div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
											<span>{{$project_margin_amount}}</span>
										</div>
									</div>
								</div>

								<div class="form-group">
									<div class="row">
										<div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
											<label>Project Tenure</label>
										</div>
										<div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
											<span>{{$tenure_years}}</span>&nbsp;
											<span>{{$tenure_months}}</span>
										</div>
									</div>
								</div>

								<div class="form-group">
									<div class="row">
										<div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
											<label>Invoice no.<br>(if borne by Client)</label>
										</div>
										<div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
											<span>{{$invoice_no}}</span>
										</div>
									</div>
								</div>
							</div>
							<!-- Right column Ends here -->
						</div>
						<!-- Row Ends here -->
						<hr>

						<div class="row">
							<div class="col-md-8 col-md-offset-2">
							<table class="table table-bordered table-striped">
								<tr>
								<th></th>
								<th>Person Name</th>
								<th>Amount</th>
								<th>Remarks</th>
								</tr>
								<tr>
								<th>Quote 1</th>
								<td>
									{{$person}}
								</td>
								<td>
									{{$amount}}
								</td>
								<td>
									{{$remark}}
								</td>
								</tr>
								<tr>
								<th>Quote 2</th>
								<td>
									Entered Person Name
								</td>
								<td>
									Entered Amount here
								</td>
								<td>
									Entered Remarks here
								</td>
								</tr>
								<tr>
								<th>Quote 3</th>
								<td>
									Entered Person Name
								</td>
								<td>
									Entered Amount here
								</td>
								<td>
									Entered Remarks here
								</td>
								</tr>
							</table>
							</div>
						</div>

					</div>
					<!-- Insurance Tab Starts here -->

					<!-- Advertisement Tab Starts here -->					  	
					<div class="tab-pane" id="advertisement">
						Advertisement Content
					</div>
					<!-- Advertisement Tab Ends here -->

					</div>
					<!-- /.tab-content -->
				</div>
				<!-- Tabs Content ends here -->
			</div>
        </div>
      </div>
    </div>
  </section>
  <!-- Main content Ends Here-->

</div>
<!-- Content Wrapper Ends here -->
  @endsection
  
  
