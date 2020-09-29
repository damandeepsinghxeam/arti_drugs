@extends('admins.layouts.app')

@section('content')

<style>
.viewTilTable tr td:first-child { font-weight: 600; }
</style>

<!-- Content Wrapper Starts here -->
<div class="content-wrapper">

  <!-- Content Header Starts here -->
  <section class="content-header">
    <h1>Various Form List</h1>
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
		@$project_name = $projects['project_approval']->name;
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
		$project_location_state =  $projects['project_approval']->state;
		$project_location_city = $projects['project_approval']->city;
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

		@$margin_project = $projects['project_approval']->margin;

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
		@$person_string = $projects['ins_data']->person;
		@$quote_amount_string = $projects['ins_data']->amount;
		@$remark_string = $projects['ins_data']->remark;
		@$person = explode(",",$person_string);
		@$quote_amount = explode(",",$quote_amount_string);
		@$remark = explode(",",$remark_string);
		
		
		
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
							<div class="col-md-6">
								<table class="table table-bordered table-striped viewTilTable">
									<thead class="table-heading-style">
										<tr>
											<th style="width: 30%">Field</th>
											<th style="width: 70%">Value</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>Name of Project</td>
											<td>{{$project_name}}</td>
										</tr>
										<tr>
											<td>GST Registration No.</td>
											<td>{{$gst_no}}</td>
										</tr>
										<tr>
											<td>TAN No.</td>
											<td>
												{{$tan}}												
											</td>
										</tr>
										<tr>
											<td>Head Office Location</td>
											<td>{{$h_o_loc}}</td>
										</tr>
										<tr>
											<td>Head Office Address</td>
											<td>{{$h_o_add}}</td>
										</tr>
										<tr>
											<td>Project Owner</td>
											<td>
												<span>Department: {{$dep_name}}</span>&nbsp;
												<span>Person: {{$proj_owner}}</span>
											</td>
										</tr>
										<tr>
											<td>Name of Contact Person</td>
											<td>{{$cont_name}}</td>
										</tr>
										<tr>
											<td>Official Address for Correspondence</td>
											<td>{{$off_add}}</td>
										</tr>
										<tr>
											<td>Agreement Signed</td>
											<td>{{$agreemnt_sign}}</td>
										</tr>
										<tr>
											<td>Agreement Validity</td>
											<td>@if($agreemnt_validity){{$agreemnt_validity}} @else N/A @endif</td>
										</tr>
										<tr>
											<td>Agreement Remarks</td>
											<td>@if($agreemnt_remark){{$agreemnt_remark}} @else N/A @endif</td>
										</tr>
										<tr>
											<td>Date of Start of Project</td>
											<td>{{$proj_start_date}}</td>
										</tr>
										<tr>
											<td>Period of Contract</td>
											<td>
												<span>Years: {{$tenure_years}}</span>&nbsp;
												<span>Month: {{$tenure_months}}</span></td>
										</tr>
										<tr>
											<td>Extendable</td>
											<td>{{$extendable}}</td>
										</tr>
										<tr>
											<td>Scope</td>
											<td>{{$scope}}</td>
										</tr>
										<tr>
											<td>TDS % to be Deducted</td>
											<td>{{$tds_deduct}}</td>
										</tr>
										<tr>
											<td>BG or Security Required</td>
											<td>{{$security_required}}</td>
										</tr>
										<tr>
											<td>BG or Security to Client(Amount & Shape)</td>
											<td>
												<span>Type: {{$security_type}}</span>&nbsp;
												<span>Amount: {{$security_amount}}</span>&nbsp;
												<span>Status: {{$security_status}}</span>
											</td>
										</tr>
										<tr>
											<td>BG or Security to Client (Validity)</td>
											<td>@if($security_valadity) {{$security_valadity}} @else N/A @endif</td>
										</tr>
										<tr>
											<td>Project Location</td>
											<td>
												<span>State:</span>
												@foreach($project_location_state as $state)
												<span>{{$state->name}}</span>,
												@endforeach
											
												<span>City:</span>
												@foreach($project_location_city as $city)
												<span>{{$city->name}}</span>,
												@endforeach
											</td>
										</tr>
										<tr>
											<td>Category of Resources</td>
											<td>{{$resource_category}}</td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="col-md-6">
								<table class="table table-bordered table-striped viewTilTable">
									<thead class="table-heading-style">
										<tr>
											<th style="width: 30%">Field</th>
											<th style="width: 70%">Value</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>Billing Cycle</td>
											<td>
												<span>From - {{$billing_cycle_from}}</span>&nbsp;
												<span>To - {{$billing_cycle_to}}</span>&nbsp;
												<span>of every Month</span>
											</td>
										</tr>
										<tr>
											<td>Salary Payment Date</td>
											<td>
												<span>{{$salary_date}}</span>&nbsp;
												<span>of every Month</span>
											</td>
										</tr>
										<tr>
											<td>Salary Mode</td>
											<td>{{$salary_mode}}</td>
										</tr>
										<tr>
											<td>ESI Applicable</td>
											<td>{{$esi_apply}}</td>
										</tr>
										<tr>
											<td>EPF Applicable</td>
											<td>{{$epf_apply}}</td>
										</tr>
										<tr>
											<td>GPA Applicable</td>
											<td>{{$gpa_apply}}</td>
										</tr>
										<tr>
											<td>WC Applicable</td>
											<td>{{$wc_apply}}</td>
										</tr>
										<tr>
											<td>Margin (%)</td>
											<td>{{$margin_project}}</td>
										</tr>
										<tr>
											<td>Security Charges</td>
											<td>{{$security_charges}}</td>
										</tr>
										<tr>
											<td>Document Charges</td>
											<td>{{$document_charges}}</td>
										</tr>
										<tr>
											<td>Online Application Charges</td>
											<td>{{$online_app_charges}}</td>
										</tr>
										<tr>
											<td>ID card</td>
											<td>{{$id_card}}</td>
										</tr>
										<tr>
											<td>Uniform</td>
											<td>{{$uniform}}</td>
										</tr>
										<tr>
											<td>Offer Letter</td>
											<td>{{$offer_letter}}</td>
										</tr>
										<tr>
											<td>TIC/Medical Insurance</td>
											<td>{{$insurance}}</td>
										</tr>
										<tr>
											<td>Additional obligations</td>
											<td>{{$additional_obligations}}</td>
										</tr>
									</tbody>
								</table>

								<h4 style="text-decoration: underline;"><b>Enclosure</b></h4>

								<table class="table table-bordered table-striped viewTilTable">
									<thead class="table-heading-style">
										<tr>
											<th style="width: 30%">Field</th>
											<th style="width: 70%">Value</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>Agreement with Customer</td>
											<td><span class="viewFileSpan label label-default">@if(!empty(@$projects['files'][0]))<a target="_blank" class="" href="{{config('constants.uploadPaths.projectDocument')}}{{@$projects['files'][0]->name}}">view</a>@endif</span></td>
										</tr>
										<tr>
											<td>Proposed Agreement with Employee</td>
											<td><span class="viewFileSpan label label-default">@if(!empty(@$projects['files'][1]))<a target="_blank" class="" href="{{config('constants.uploadPaths.projectDocument')}}{{@$projects['files'][1]->name}}">view</a>@endif</span></td>
										</tr>
										<tr>
											<td>Format of Offer Letter</td>
											<td><span class="viewFileSpan label label-default">@if(!empty(@$projects['files'][2]))<a target="_blank" class="" href="{{config('constants.uploadPaths.projectDocument')}}{{@$$projects['files'][2]->name}}">view</a>@endif</span></td>
										</tr>
									</tbody>
								</table>

							</div>
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
							<div class="col-md-6">
								<h4 style="text-decoration: underline;"><b>IT Requirement</b></h4>

								<table class="table table-bordered table-striped viewTilTable">
									<thead class="table-heading-style">
										<tr>
											<th style="width: 30%">Field</th>
											<th style="width: 70%">Value</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>SMS</td>
											<td>{{$sms}}</td>
										</tr>
										<tr>
											<td>Number of SMS</td>
											<td>@if($sms_no) {{$sms_no}} @else N/A @endif</td>
										</tr>
										<tr>
											<td>Email</td>
											<td>{{$email}}</td>
										</tr>
										<tr>
											<td>Number of Email</td>
											<td>@if($email_no) {{$email_no}} @else N/A @endif</td>
										</tr>
										<tr>
											<td>JRF</td>
											<td>{{$jrf}}</td>
										</tr>
										<tr>
											<td>Takeover</td>
											<td>{{$takeover}}</td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="col-md-6">
								<h4 style="text-decoration: underline;"><b>Advertisement</b></h4>

								<table class="table table-bordered table-striped viewTilTable">
									<thead class="table-heading-style">
										<tr>
											<th>Through</th>
											<th>Quantity</th>
											<th>Costs</th>
										</tr>
									</thead>
									<tbody>
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
									</tbody>
								</table>

								<h4 style="text-decoration: underline;"><b>Content</b></h4>
								
								<table class="table table-bordered table-striped viewTilTable">
									<thead class="table-heading-style">
										<tr>
											<th style="width: 30%">Field</th>
											<th style="width: 70%">Value</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>Content </td>
											<td>{{$content}}</td>
										</tr>
										
									</tbody>
								</table>

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

						<div class="row">
							<div class="col-md-5">
								<h4 style="text-decoration: underline;"><b>Basic Details</b></h4>

								<table class="table table-striped table-bordered viewTilTable">
									<thead class="table-heading-style">
										<tr>
											<th style="width: 30%">Field</th>
											<th style="width: 70%">Value</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>Tender Name</td>
											<td>{{$tender_name}}</td>
										</tr>
										<tr>
											<td>Form</td>
											<td>{{$form}}</td>
										</tr>
										<tr>
											<td>Amount</td>
											<td>{{$amount}}</td>
										</tr>
										<tr>
											<td>In favor of</td>
											<td>{{$in_favour}}</td>
										</tr>
										<tr>
											<td>Date when required</td>
											<td>{{$date_required}}</td>
										</tr>
										<tr>
											<td>Validity Date of BG</td>
											<td>{{$bg_valadity_date}}</td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="col-md-7">
								<h4 style="text-decoration: underline;"><b>For Accounts Department</b></h4>

								<table class="table table-bordered table-striped viewTilTable">
									<tr>
										<td>
											<span>{{$margin_percentage}} (%)</span>
										</td>
										<th>Margin</th>
										<td>
											<span>{{$margin}}</span>
										</td>
									</tr>
									<tr>
										<td>
											<span>{{$bg_charges_percentage}} (%)</span>
										</td>

										<th>Bg Charges</th>

										<td>
											<span>{{$bg_charges}}</span>
										</td>
									</tr>
									<tr>
										<td>
											<span>{{$gst_percentage}} (%)</span>
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

					</div>
					<!-- BG Tab Ends here -->

					<!-- Insurance Tab Starts here -->
					<div class="tab-pane" id="insurance">

						<div class="row">
							<div class="col-md-6">
								<table class="table table-striped table-bordered viewTilTable">
									<thead class="table-heading-style">
										<tr>
											<th style="width: 30%">Field</th>
											<th style="width: 70%">Value</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>Tender Name</td>
											<td>{{$tender_name}}</td>
										</tr>
										<tr>
											<td>Insurance Type</td>
											<td>
												<span>Type: {{$insurance_type}}</span>&nbsp;
												<span>Text: {{$insurance_text}}</span>
											</td>
										</tr>
										<tr>
											<td>Insurance Plan</td>
											<td><span>{{$insurance_plan}}</span></td>
										</tr>
										<tr>
											<td>Total Premium Amount</td>
											<td>{{$premium_amount}}</td>
										</tr>
										<tr>
											<td>In favor of</td>
											<td>{{$in_favor}}</td>
										</tr>
										<tr>
											<td>Validity Date of BG</td>
											<td>{{$date_required}}</td>
										</tr>
										<tr>
											<td>No. of Peers/Lives</td>
											<td>
												<span>{{$peers_no}}</span>&nbsp;
												<span>{{$peers_note}}</span>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="col-md-6">
								<table class="table table-bordered table-striped viewTilTable">
									<thead class="table-heading-style">
										<tr>
											<th style="width: 30%">Field</th>
											<th style="width: 70%">Value</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>Expense to be Borne By</td>
											<td>{{$expense_borne_by}}</td>
										</tr>
										<tr>
											<td>Project Margin (%age)</td>
											<td>{{$project_margin_percentage}}</td>
										</tr>
										<tr>
											<td>Project Margin Amount</td>
											<td>{{$project_margin_amount}}</td>
										</tr>
										<tr>
											<td>Project Tenure</td>
											<td>
												<span>{{$tenure_years}}</span>&nbsp;
											<span>{{$tenure_months}}</span>
											</td>
										</tr>
										<tr>
											<td>Invoice no. (if borne by Client)</td>
											<td>{{$invoice_no}}</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>

						<div class="row">
							<div class="col-md-8 col-md-offset-2">
							<table class="table table-bordered table-striped">
								<thead class="table-heading-style">
									<tr>
										<th></th>
										<th>Quote 1</th>
										<th>Quote 2</th>
										<th>Quote 3</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<th>Person Name</th>
										@foreach($person as $persn)						
											
											<td>
												{{$persn}}
											</td>											
										
										@endforeach
									</tr>
									<tr>
										<th>Amount</th>
										@foreach($quote_amount as $amt)												
											
											<td>
												{{$amount}}
											</td>
											
										
										@endforeach
									</tr>
									<tr>
										<th>Remarks</th>
										@foreach($remark as $remrk)												
											
											<td>
												{{$remrk}}
											</td>
											
										
										@endforeach
									</tr>
								</tbody>
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
  
