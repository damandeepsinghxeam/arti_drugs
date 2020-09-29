@extends('admins.layouts.app')

@section('content')

<style>
.viewTilTable tr td:first-child { font-weight: 600; }	
</style>

  <link href="{!! asset('public/admin_assets/plugins/jquery-toast/jquery.toast.min.css') !!}" rel="stylesheet">
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>TIL: {{$tilDraft->til_code}}</h1>
    <ol class="breadcrumb">
      <li>
        <a href="{{ url('employees/dashboard') }}">
          <i class="fa fa-dashboard"></i> Home
        </a>
      </li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-sm-12">
        <div class="box box-primary">
          <!-- form start -->
          @include('admins.validation_errors')
          <div class="box-body">
            <!-- Row Starts here -->
			
			<!-- Check this php code where it should placed-->
			@php 
              $businessTypeArr = [
                1 => 'Govt. Business', 2 => 'Corporate Business', 3 => 'International Business'
              ];
            @endphp
            <!-- Check this php code where it should placed-->


			<div class="row">
				<div class="col-md-6">
					<table class="table table-striped table-bordered viewTilTable">
						<thead class="table-heading-style">
							<tr>
								<th style="width: 30%;">Field</th>
								<th style="width: 70%;">Value</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>Tender Owner:</td>
								<td>{!! (!empty($tilDraft->tender_owner))? $tilDraft->tender_owner : '--' !!}</td>
							</tr>
							<tr>
								<td>Location:</td>
								<td>{!! (!empty($tilDraft->tender_location))? $tilDraft->tender_location : '--' !!}</td>
							</tr>
							<tr>
								<td>Contact Person detail:</td>
								<td><a href="#" data-toggle="modal" data-target="#add_contact_details">View Details</a></td>
							</tr>
							<tr>
								<td>Vertical:</td>
								<td>
									@if(!empty($tilDraft->vertical_id))
				                        {!! $verticalOptions[$tilDraft->vertical_id] !!}
				                    @else 
				                       --
				                    @endif
								</td>
							</tr>
							<tr>
								<td>Vertical Others:</td>
								<td>
									@if(!empty($tilDraft->other_vertical))
				                        {!! nl2br($tilDraft->other_vertical) !!}
				                    @else 
				                        --
				                    @endif
								</td>
							</tr>
							<tr>
								<td>Bid System:</td>
								<td>{!! ucfirst($tilDraft->bid_system) !!}</td>
							</tr>
							<tr>
								<td>Bid System Clause:</td>
								<td>{!! (!empty($tilDraft->bid_system_clause))? nl2br($tilDraft->bid_system_clause) : '--' !!}</td>
							</tr>
							<tr>
								<td>Tenure <small>(In Months)</small>:</td>
								<td>
									@if(!empty($tilDraft->tenure_one))
										{!! $tilDraft->tenure_one !!} Months
									@else 
										--
									@endif
								</td>
							</tr>
							<tr>
								<td>Tenure Extension <small>(If applicable)</small>:</td>
								<td>
									@if(!empty($tilDraft->tenure_two))
										{!! $tilDraft->tenure_two !!}  Months
									@else 
										--
									@endif
								</td>
							</tr>
							<tr>
								<td>EMD Date:</td>
								<td>
									@if(!empty($tilDraft->emd_date) && $tilDraft->emd_date != '0000-00-00 00:00:00')
										{!! date('m/d/Y', strtotime($tilDraft->emd_date)) !!}
									@else 
										--
									@endif
								</td>
							</tr>
							<tr>
								<td>Tender Fee:</td>
								<td>
									@php 
										if(array_key_exists('', $tenderFeeOptions)) {
											unset($tenderFeeOptions['']);
										}
									@endphp
									@if(!empty($tilDraft->tender_fee))
									@php 
									$draftTenderFee = explode(',', $tilDraft->tender_fee);
									@endphp

									@foreach($draftTenderFee as $tfKey => $tfVal)
										<span class="label label-primary">{!! $tenderFeeOptions[$tfVal] !!}</span>
									@endforeach
									@else 
										--
									@endif
								</td>
							</tr>
							<tr>
								<td>Tender Fee Exempted:</td>
								<td>
									@if(!empty($tilDraft->tender_fee_exempted))
										{!! nl2br($tilDraft->tender_fee_exempted) !!}
									@else
										--
									@endif
								</td>
							</tr>
							<tr>
								<td>Tender Fee Amount:</td>
								<td>
									@if(!empty($tilDraft->tender_fee_amount))
										{!! moneyFormat($tilDraft->tender_fee_amount) !!}
									@else
										--
									@endif
								</td>
							</tr>
							<tr>
								<td>Performance Guaranty & Security:</td>
								<td>
									@php
										$performanceTypeArr = [1 => 'Fixed', 2 => 'Percent'];
									@endphp
									<span class="label label-primary">{!! $performanceTypeArr[$tilDraft->performance_guarantee_type] !!}</span>

									@if(!empty($tilDraft->performance_guarantee))
									<span class="label label-success">
									@php 
									$performanceGuarantee = $tilDraft->performance_guarantee;
									if($tilDraft->performance_guarantee_type == 1) {
									$performanceGuarantee = numberFormat($tilDraft->performance_guarantee);
									}
									@endphp
									{!! $performanceGuarantee !!}
									@if($tilDraft->performance_guarantee_type == 2)
									%
									@endif
									</span>
									@endif
								</td>
							</tr>
							<tr>
								<td>Performance Guaranty & Security Clause:</td>
								<td>
									@if(!empty($tilDraft->performance_guarantee_clause))
										{!! nl2br($tilDraft->performance_guarantee_clause) !!}
									@else
										--
									@endif
								</td>
							</tr>
							<tr>
								<td>Payment Terms:</td>
								<td>
									@php
			                        $paymentTermArr = [1 => 'Pay & Collect', 2 => 'Collect & Pay']; // pay_and_collect, collect_and_pay // payAndCollectOptions, collectAndPayOptions
			                        if(array_key_exists('', $payAndCollectOptions)) {
			                          unset($payAndCollectOptions['']);
			                        }
			                        
			                        if(array_key_exists('', $collectAndPayOptions)) {
			                          unset($collectAndPayOptions['']);
			                        }
			                      @endphp
			                      <span class="label label-primary">{!! $paymentTermArr[$tilDraft->payment_terms] !!}</span>
			                      @if(!empty($tilDraft->payment_terms))

			                        @if($tilDraft->payment_terms == 1)
			                          @if(isset($payAndCollectOptions[$tilDraft->pay_and_collect]))
			                            <span class="label label-success">
			                              {!! $payAndCollectOptions[$tilDraft->pay_and_collect] !!}
			                            </span>
			                          @endif
			                        @elseif($tilDraft->payment_terms == 2)

			                          @if(isset($collectAndPayOptions[$tilDraft->collect_and_pay]))
			                            <span class="label label-success">
			                              {!! $collectAndPayOptions[$tilDraft->collect_and_pay] !!}
			                            </span>
			                          @endif
			                        @endif
			                      @endif
								</td>
							</tr>
							<tr>
								<td>Penalties:</td>
								<td>
									@if(!empty($tilDraft->tilDraftPenalties)) 
										@foreach($tilDraft->tilDraftPenalties as $eKey => $tilPenalty)
											<p>{!! $tilPenalty->penalty !!}</p>
										@endforeach
									@else 
										--
									@endif
								</td>
							</tr>
							<tr>
								<td>Assigned to (SD Group):</td>
								<td>
									@if(!empty($tilDraft->assigned_to_group))
										{!! $tilDraft->assigned_to_group !!}
									@else
										--
									@endif
								</td>
							</tr>
							<tr>
								<td>Name of Department:</td>
								<td>
									{!! (!empty($tilDraft->department))? $tilDraft->department : '--' !!}
								</td>
							</tr>
							<tr>
								<td>Due Date:</td>
								<td>
									@if(!empty($tilDraft->due_date) && $tilDraft->due_date != '0000-00-00 00:00:00')
										{!! date('m/d/Y H:i A', strtotime($tilDraft->due_date)) !!}
									@else
										--
									@endif
								</td>
							</tr>
							<tr>
								<td>Value of work: <small>(In Lakhs)</small>:</td>
								<td>{!! (!empty($tilDraft->value_of_work))? moneyFormat($tilDraft->value_of_work) : '--' !!}</td>
							</tr>
							<tr>
								<td>Volume:</td>
								<td>{!! (!empty($tilDraft->volume))? moneyFormat($tilDraft->volume) : '--' !!}</td>
							</tr>
							<tr>
								<td>Scope of work:</td>
								<td>{!! (!empty($tilDraft->scope_of_work))? nl2br($tilDraft->scope_of_work) : '--' !!}</td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="col-md-6">
					<table class="table table-striped table-bordered viewTilTable">
						<thead class="table-heading-style">
							<tr>
								<th style="width: 30%;">Field</th>
								<th style="width: 70%;">Value</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>Special Eligibility Clause:</td>
								<td>
									@if(!empty($tilDraft->tilSpecialEligibility)) 
										@foreach($tilDraft->tilSpecialEligibility as $eKey => $eligibility)
											<span>{!! $eligibility->special_eligibility !!}</span></br>
										@endforeach
									@else 
										--
									@endif
								</td>
							</tr>
							<tr>
								<td>Technical Qualification:</td>
								<td>
									@if(!empty($tilDraft->tilTechnicalQualification)) 
										@foreach($tilDraft->tilTechnicalQualification as $eKey => $tilQualification)
											<p>{!! $tilQualification->technical_qualification !!}</p>
										@endforeach
									@else 
										--
									@endif
								</td>
							</tr>
							<tr>
								<td>EMD:</td>
								<td>
									@php 
										if(array_key_exists('', $emdOptions)) {
										unset($emdOptions['']);
										}
									@endphp
									@if(!empty($tilDraft->emd))
									@php 
									$draftEmd = explode(',', $tilDraft->emd);
									@endphp

									@foreach($draftEmd as $emdKey => $emdVal)
										<span class="label label-primary">{!! $emdOptions[$emdVal] !!}</span>
									@endforeach
									@else                       
										--
                      				@endif
								</td>
							</tr>
							<tr>
								<td>EMD Amount:</td>
								<td>
									@if(!empty($tilDraft->emd_amount))
										{!! moneyFormat($tilDraft->emd_amount) !!}
									@else
										--
									@endif
								</td>
							</tr>
							<tr>
								<td>EMD Exempted:</td>
								<td>
									@if(!empty($tilDraft->emd_exempted))
										{!! nl2br($tilDraft->emd_exempted) !!}
									@else
										--
									@endif
								</td>
							</tr>
							<tr>
								<td>EMD Special Clause:</td>
								<td>
									@if(!empty($tilDraft->emd_special_clause))
										{!! nl2br($tilDraft->emd_special_clause) !!}
									@else 
										--
									@endif
								</td>
							</tr>
							<tr>
								<td>Investment:</td>
								<td>
									@php 
										$investmentArr = [
										'' => '--', 'monthly_billing' => 'Monthly Billing',
										'security_in_cash' => 'Security in Cash', 'pbg' => 'PBG',
										'deduction' => 'Deduction', 'tds' => 'TDS', 'others' => 'Others'
										];
										$investment = '--';
										if(isset($investmentArr[$tilDraft->investment])) {
										$investment = $investmentArr[$tilDraft->investment];
										}
									@endphp
									{!! $investment !!}
								</td>
							</tr>
							<tr>
								<td>Payment Terms Complete Clause:</td>
								<td>
									@if(!empty($tilDraft->complete_clause))
										{!! nl2br($tilDraft->complete_clause) !!}
									@else
										--
									@endif
								</td>
							</tr>
							<tr>
								<td>Payment Terms Clause:</td>
								<td>
									@if(!empty($tilDraft->payment_terms_clause))
										{!! nl2br($tilDraft->payment_terms_clause) !!}
									@else
										--
									@endif
								</td>
							</tr>
							<tr>
								<td>Processing Fee:</td>
								<td>
									@php 
									if(array_key_exists('', $processingFeeOptions)) {
									unset($processingFeeOptions['']);
									}
									@endphp
									@if(!empty($tilDraft->processing_fee))
									@php 
									$draftProcessingFee = explode(',', $tilDraft->processing_fee);
									@endphp

									@foreach($draftProcessingFee as $pKey => $pVal)
									<span class="label label-primary">{!! $processingFeeOptions[$pVal] !!}</span>
									@endforeach
									@else 
									--
									@endif
								</td>
							</tr>
							<tr>
								<td>Processing Fee Amount:</td>
								<td>
									@if(!empty($tilDraft->processing_fee_amount))
										{!! moneyFormat($tilDraft->processing_fee_amount) !!}
									@else
										--
									@endif
								</td>
							</tr>
							<tr>
								<td>Processing Fee Exempted:</td>
								<td>
									@if(!empty($tilDraft->processing_fee_exempted))
										{!! nl2br($tilDraft->processing_fee_exempted) !!}
									@else
										--
									@endif
								</td>
							</tr>
							<tr>
								<td>Pre Bid Meeting:</td>
								<td>
									@if(!empty($tilDraft->pre_bid_meeting) && $tilDraft->pre_bid_meeting != '0000-00-00 00:00:00')
										{!! date('m/d/Y H:i A', strtotime($tilDraft->pre_bid_meeting)) !!}
									@else 
										--
									@endif
								</td>
							</tr>
							<tr>
								<td>Pre Bid Clause:</td>
								<td>
									@if(!empty($tilDraft->pre_bid_clause))
										{!! nl2br($tilDraft->pre_bid_clause) !!}
									@else 
										--
									@endif
								</td>
							</tr>
							<tr>
								<td>Financial Bid Type:</td>
								<td>
									@if(!empty($tilDraft->financial_bid_type))
										{!! nl2br($tilDraft->financial_bid_type) !!}
									@else 
										--
									@endif
								</td>
							</tr>
							<tr>
								<td>Obligations:</td>
								<td>
									@php
									if(array_key_exists('', $obligationOptions)) {
									unset($obligationOptions['']);
									}
									@endphp

									@if(!empty($tilDraft->obligation_id) && isset($obligationOptions[$tilDraft->obligation_id]))
									<p>{!! $obligationOptions[$tilDraft->obligation_id] !!}</p>
									@endif

									@if(!empty($tilDraft->tilObligation)) 
									@foreach($tilDraft->tilObligation as $oKey => $obligation)
									<p>{!! $obligation->obligation !!}</p>
									@endforeach
									@else 
									--
									@endif
								</td>
							</tr>
							<tr>
								<td>Technical Opening Date:</td>
								<td>
									@if(!empty($tilDraft->technical_opening_date) && $tilDraft->technical_opening_date != '0000-00-00 00:00:00')
									{!! date('m/d/Y H:i A', strtotime($tilDraft->technical_opening_date)) !!}
									@else 
									--
									@endif
								</td>
							</tr>
							<tr>
								<td>Financial Opening Date:</td>
								<td>
									@if(!empty($tilDraft->financial_opening_date) && $tilDraft->financial_opening_date != '0000-00-00 00:00:00')
									{!! date('m/d/Y H:i A', strtotime($tilDraft->financial_opening_date)) !!}
									@else 
										--
									@endif
								</td>
							</tr>
							<tr>
								<td>Technical Criteria:</td>
								<td>
									@if(!empty($tilDraft->technical_criteria))
										{!! $tilDraft->technical_criteria !!}
									@else 
										--
									@endif
								</td>
							</tr>
							<tr>
								<td>Financial Criteria:</td>
								<td>
									@if(!empty($tilDraft->financial_criteria))
										{!! $tilDraft->financial_criteria !!}
									@else 
										--
									@endif
								</td>
							</tr>
							<tr>
								<td>Award Criteria:</td>
								<td>
									@if(!empty($tilDraft->award_criteria))
										{!! $tilDraft->award_criteria !!}
									@else 
										--
									@endif
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			
			<hr>

            <div class="row">
              <div class="col-md-12">
                <!--@ if(auth()->user()->can('leads-management.view-cost-estimation'))
                  <div class="form-group col-md-3">
                    <label class="control-label col-md-12">Total Investments:</label>
                    <div class="col-md-12">
                      @ if(!empty($tilDraft->total_investments))
                          { !! numberFormat($tilDraft->total_investments) !!}
                        @ else 
                          --
                      @ endif
                    </div>
                    @ if(!empty($tilDraft->costEstimationDraft))
                      <div class="col-md-12">
                        @ php
                          $costEstimationUrl = 'leads-management.view-cost-estimation';
                        @ endphp

                        <a href="{ !! route($costEstimationUrl, $tilDraft->id) !!}" id="cost-estimation" class="pull-left" target="_blank"> Cost Estimation Sheet </a>
                      </div>
                    @ endif
                  </div>
                @ endif-->                
              </div>
            </div>

            <div class="row">
            	<div class="col-md-5">
            		<h4 class="text-center" style="text-decoration: underline;">Financial Information:</h4>
            		<table class="table table-bordered text-center">
            			<thead class="table-heading-style">
            				<tr>
            					<th colspan="2">Gross Turnover</th>
            				</tr>
            			</thead>
            			<tbody>
            				<tr>
            					<td>
            						<b>{!! moneyFormat($tilDraft->gross_turnover_monthly) !!}/Monthly</b>
            					</td>
            					<td>
            						<b>{!! moneyFormat($tilDraft->gross_turnover_yearly) !!}/Yearly</b>
            					</td>
            				</tr>
            			</tbody>
            		</table>
            	</div>
            	<div class="col-md-7">
            		<h4 class="text-center" style="text-decoration: underline;">Cost of Tendering</h4>
            		<table class="table table-bordered text-center">
            			<thead class="table-heading-style">
            				<tr>
            					<th>EMD amount</th>
            					<th>Tender fee amount</th>
            				</tr>
            			</thead>
            			<tbody>
            				<tr>
            					<td>
            						<b>{!! moneyFormat($tilDraft->emd_amount_c) !!}</b>
            						</td>
            					<td>
            						<b>{!! moneyFormat($tilDraft->tender_fee_amount_c) !!}</b>
            					</td>
            				</tr>
            			</tbody>
            		</table>
            	</div>
            </div>


            @php
              /*1 => New, 2 => Open, 3 => Complete, 4 => Sent for Remarks, 5 => Sent For Approval, 6 => Rejected by Hod, 7 => Abandoned, 8 => Closed*/
              $statusArr = [
                1 => 'New', 2 => 'Open', 3 => 'Complete',
                4 => 'Sent for Remarks', 5 => 'Closed',
                6 => 'Rejected by Hod', 7 => 'Abandoned',
                8 => 'Closed'
              ];
              $userId = $authUser->id;
            @endphp
            <!-- $authUser --> 
            @if((auth()->user()->can('leads-management.til-approval') && !empty($hodId) && $hodId == $userId && in_array($tilDraft->status, [3, 4])))
              <form id="view-til-form" class="form-vertical" action="{{ route('leads-management.til-approval') }}" method="POST">
                @csrf()
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="col-sm-12">
                        <input type="hidden" name="til_id" value="{!! $tilDraft->id !!}">
                        <input type="hidden" name="status" value="0">
                        <!--                         
                        Input Form field set
                        <fieldset>
                          <legend>Input Form:</legend>
                          <div class="col-md-12 table-responsive no-padding">
                            <table id="input-form-table" class="table table-bordered table-striped travel-table-inner" style="height:150px;">
                              <thead class="table-heading-style dim-gray">
                                <tr>
                                  <th>Department</th>
                                  <th>Users</th>
                                  <th>HOD Remarks</th>
                                  <th>User Remarks</th>
                                  <th>Add/Rem</th>
                                </tr>
                              </thead>
                              <tbody id="input-form-table-body">
                                @ php
                                  $isRemarksPending = 0;
                                @ endphp
                                @ if(!$tilDraft->tilDraftInputs->isEmpty())
                                  @ php
                                    $draftInputs = $tilDraft->tilDraftInputs;
                                  @ endphp
                                  @ foreach($draftInputs as $iKey => $input)
                                    @ php
                                      $departmentName = $input->department->name;
                                      $userName       = trim($input->user->employee->fullname);
                                      $hodRemarks     = nl2br($input->hod_remarks);
                                      $userRemarks    = nl2br($input->user_remarks);
                                      $isRemarksPending = !empty($input->user_remarks)? $isRemarksPending + 1 : 0;
                                    @ endphp
                                    <tr>
                                      <td>
                                        <div class="col-md-12">
                                          <span>{! ! !empty($departmentName)? $departmentName : '--' !!}</span>
                                        </div>
                                      </td>
                                      <td>
                                        <div class="col-md-12">
                                          <span>{! ! !empty($userName)? $userName : '--' !!}</span>
                                        </div>
                                      </td>
                                      <td>
                                        <div class="col-md-12">
                                          <span>{! ! !empty($hodRemarks)? $hodRemarks : '--' !!}</span>
                                        </div>
                                      </td>
                                      <td>
                                        <div class="col-md-12">
                                          <span>{! ! !empty($userRemarks)? $userRemarks : '--' !!}</span>
                                        </div>
                                      </td>
                                      <td>
                                        <div class="col-md-12">
                                          <span>--</span>
                                        </div>
                                      </td>
                                    </tr>
                                  @ endforeach
                                @ endif

                                @ if(!empty($isRemarksPending))
                                  <tr>
                                    <td>
                                      <div class="col-md-12">
                                        <select name="department_id[]" class="form-control department_id" required>
                                          <option value="">-Select-</option>
                                          @ if(!$departments->isEmpty())
                                            @ foreach($departments as $key => $department)  
                                              <option value="{ {$department->id}}">{ {$department->name}}</option>
                                            @ endforeach
                                          @ endif
                                        </select>
                                      </div>
                                    </td>
                                    <td>
                                      <div class="col-md-12">
                                        <select name="user_id[]" class="form-control user_id" required>
                                          <option value="">-Select-</option>
                                        </select>
                                      </div>
                                    </td>
                                    <td>
                                      <div class="col-md-12">
                                        <textarea name="hod_remarks[]" class="form-control hod_remarks" cols="20" rows="3" style="resize: none;" required></textarea>
                                      </div>
                                    </td>
                                    <td>
                                      <div class="col-md-12">
                                        --
                                      </div>
                                    </td>  
                                    <td class="text-center">
                                      <div class="col-md-12">
                                        <a href="javascript:void(0);" class="add-more-btn">
                                          <i class="fa fa-plus addtravel-row"></i>
                                        </a>
                                      </div>
                                    </td>
                                  </tr>
                                @ endif
                                @ endif                                
                              </tbody>
                            </table>
                          </div>
                        </fieldset> -->
                        
                        <div class="row"><hr/></div>

                        <!-- @ if($tilDraft->status == 4)  && empty($isRemarksPending) -->
                          <div class="form-group">
                            <label class="control-label"> Comments: </label>
                    
                            <div class="three-icon-box display-inline-block">
                            	@if(!$tilDraft->comments->isEmpty() && $tilDraft->comments->count() > 0)
                              		<div class="info-tooltip cursor-pointer get-comments" data-til_id="{!! $tilDraft->id !!}">
		                                <a href="javascript:void(0)">
		                                  <small>
		                                    View ({{ $tilDraft->comments->count() }}) Comments
		                                  </small>
		                                </a>
		                                <span class="info-tooltiptext">Click here to see previous comments.</span>
	                              </div>
                              	@else
	                              <small>No Previous Comments Found.</small>
	                            @endif
                            </div>
                    
                            <div class="">
                              <textarea name="comments" id="comments" cols="30" rows="4" class="form-control" required></textarea>
                    
                              @if(!empty($hodId) && $tilDraft->status == 3)
                                <input type="hidden" name="hod_id" value="{!! $hodId !!}">
                              @endif
                            </div>
                          </div>
                        <!-- @ endif -->
                      </div>
                    </div>
                  </div>
                  <!-- /.box-body -->
                  <div class="box-footer text-center">
                    <div class="col-md-12">
                     <!-- @ if($tilDraft->status == 4)  && empty($isRemarksPending) -->
                        <button type="submit" class="btn btn-danger reject-btn">Reject</button>
                        <button type="submit" class="btn btn-primary m-l-10 approve-btn">Approve</button>
                      <!-- @ else
                        <button type="submit" class="btn btn-primary save-btn">Save</button>
                      @ endif -->
                      <a href="{!! route('leads-management.list-til') !!}" class="btn btn-default m-l-10">Back</a>
                    </div>
                  </div>
              </form>
            @else
              <div class="row1 m-t-sm">
                <div class="col-sm-12">
                  <!-- @ if(!$tilDraft->tilDraftInputs->isEmpty())
                    <fieldset>
                      <legend>Input Form:</legend>
                      <div class="col-md-12 table-responsive no-padding">
                        <table id="input-form-table" class="table table-bordered table-striped travel-table-inner" style="height:150px;">
                          <thead class="table-heading-style dim-gray">
                            <tr>
                              <th>Department Name</th>
                              <th>User Name</th>
                              <th>HOD Remarks</th>
                              <th>User Remarks</th>
                            </tr>
                          </thead>
                          <tbody id="input-form-table-body">
                            @ php
                              $draftInputs = $tilDraft->tilDraftInputs;
                            @ endphp
                            @ foreach($draftInputs as $iKey => $input)
                              @ php
                                $departmentName = $input->department->name;
                                $userName       = trim($input->user->employee->fullname);
                                $hodRemarks     = nl2br($input->hod_remarks);
                                $userRemarks    = nl2br($input->user_remarks);
                              @ endphp
                              <tr>
                                <td>
                                  <div class="col-md-12">
                                    <span>{ !! !empty($departmentName)? $departmentName : '--' !!}</span>
                                  </div>
                                </td>
                                <td>
                                  <div class="col-md-12">
                                    <span>{ !! !empty($userName)? $userName : '--' !!}</span>
                                  </div>
                                </td>
                                <td>
                                  <div class="col-md-12">
                                    <span>{ !! !empty($hodRemarks)? $hodRemarks : '--' !!}</span>
                                  </div>
                                </td>
                                <td>
                                  <div class="col-md-12">
                                    <span>{ !! !empty($userRemarks)? $userRemarks : '--' !!}</span>
                                  </div>
                                </td>
                              </tr>
                            @ endforeach
                          </tbody>
                        </table>
                      </div>
                    </fieldset>
                  @ endif -->

                  <div class="row"><hr/></div>

                  <div class="form-group">
                    <div class="">
                      <label class="control-label">Comments:</label>

                      <div class="three-icon-box display-inline-block">
                      	@if(!$tilDraft->comments->isEmpty() && $tilDraft->comments->count() > 0)
	                        <div class="info-tooltip cursor-pointer get-comments" data-til_id="{!! $tilDraft->id !!}">
	                          <a href="javascript:void(0)">
                                <small>
                                  View ({{ $tilDraft->comments->count() }}) Comments
                                </small>
                              </a>
	                          <span class="info-tooltiptext">Click here to see previous comments.</span>
	                        </div>
                        @else
                            <small>No Previous Comments Found.</small>
                      	@endif
                      </div>
                    </div>                                            
                  </div>
                </div>
              </div>
            @endif
          </div>
          <!-- /.box-body -->
          @if(!auth()->user()->can('leads-management.til-approval') || (empty($hodId) || $hodId != $userId || !in_array($tilDraft->status, [3, 4])))
            <div class="box-footer text-center">
              <div class="col-md-12">
                @if($tilDraft->user_id == $userId && in_array($tilDraft->status, [1, 2])  && $tilDraft->is_editable == 1)
                  <a href="{!! route('leads-management.edit-til', $tilDraft->id) !!}" class="btn btn-success">Edit</a>
                @endif
                  <a href="{!! route('leads-management.list-til') !!}" class="btn btn-default m-l-10">Back</a>
              </div>
            </div>
          @endif
          <!-- Main row -->
        </div>
      </div>
    </div>
  </section>
</div>

<div class="modal fade bs-example-modal-sm" id="add_contact_details" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        <h4 class="modal-title" id="mySmallModalLabel">View Details:</h4>
      </div>
      <div class="modal-body">          
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive" id="til_contact_form">
              <table class="table table-bordered table-striped table-hover til_contacts_table">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Designation</th>
                    <th>Mobile Number</th>
                    <th>Email</th>
                    <th>Description</th>
                  </tr>
                </thead>
                <tbody class="til_contacts">
                  @if(!empty($tilDraft->tilContact) && count($tilDraft->tilContact) > 0)
                    @foreach($tilDraft->tilContact as $cKey => $contact)
                      <tr>
                        <td>{!! (!empty($contact->name))? $contact->name : '--' !!}</td>
                        <td>{!! (!empty($contact->designation))? $contact->designation : '--' !!}</td>
                        <td>{!! (!empty($contact->phone))? $contact->phone : '--' !!}</td>
                        <td>{!! (!empty($contact->email))? $contact->email : '--' !!}</td>
                        <td>{!! (!empty($contact->description))? nl2br($contact->description) : '--' !!}</td>
                      </tr>                      
                    @endforeach                  
                  @else
                    <tr class="til_contacts">
                      <td class="text-center" colspan="5"> No Record Found! </td>
                    </tr>
                  @endif
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <div class="col-md-12">
          <button type="button" class="btn btn-success" data-dismiss="modal" aria-label="Close">Ok</button>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="input-form-hidden-div hide">
  <table id="table-to-be-cloned">
    <tr>
      <td>
        <div class="col-md-12">
          <select name="department_id[]" class="form-control department_id" required>
            <option value="">-Select-</option>
            @if(!$departments->isEmpty())
              @foreach($departments as $key => $department)  
                <option value="{{$department->id}}">{{$department->name}}</option>
              @endforeach
            @endif
          </select>          
        </div>
      </td>

      <td>
        <div class="col-md-12">
          <select name="user_id[]" class="form-control user_id" required>
            <option value="">-Select-</option>
          </select>
        </div>
      </td>

      <td>
        <div class="col-md-12">
          <textarea name="hod_remarks[]" class="form-control hod_remarks" cols="20" rows="3" style="resize: none;" required></textarea>
        </div>
      </td>

      <td>
        <div class="col-md-12">
          <span>--</span>
        </div>
      </td>

      <td class="text-center">
        <div class="col-md-12">
          <a href="javascript:void(0);" class="add-more-btn">
            <i class="fa fa-plus addtravel-row"></i>
          </a>

          <a href="javascript:void(0);" onclick="removeTr($(this))" class="remetravel">
            <i class="fa fa-minus remtravel-row"></i>
          </a>
        </div>
      </td>
    </tr>
  </table>
</div>
@endsection

@section('script')
<script src="{!! asset('public/admin_assets/plugins/sweetalert/sweetalert.min.js') !!}"></script>
<script src="{{asset('public/admin_assets/plugins/validations/jquery.validate.js')}}"></script>
<script src="{{asset('public/admin_assets/plugins/validations/additional-methods.js')}}"></script>
<script src="{!! asset('public/admin_assets/plugins/jquery-toast/jquery.toast.min.js') !!}"></script>
<script type="text/javascript">
$(document).ready(function() {

  $.validator.prototype.checkForm = function() {
    //overriden in a specific page
    this.prepareForm();
    for (var i = 0, elements = (this.currentElements = this.elements()); elements[i]; i++) {
      if (this.findByName(elements[i].name).length !== undefined && this.findByName(elements[i].name).length > 1) {
        for (var cnt = 0; cnt < this.findByName(elements[i].name).length; cnt++) {
          this.check(this.findByName(elements[i].name)[cnt]);
        }
      } else {
        this.check(elements[i]);
      }
    }
    return this.valid();
  };

  var userId = "{!! $tilDraft->user_id !!}";

  $(document).on('change', '.department_id', function() {
    var thisVal = $(this).val();
    var $this = $(this);

    var userOtions = '<option value="">-Select-</option>';

    if(thisVal != '') {
      var displayString = "";
      var departments = [];
      departments.push(thisVal);

      $.ajax({
        type: "POST",
        url: "{{url('leads-management/get-employees')}}",
        data: {department_ids: departments},
        beforeSend: function() {
          // setting a timeout
          $('div.loading').removeClass('hide');          
        },
        success: function(result) {   
          
          if(result.length > 0) {
            $(result).each(function(k, user) {
              var employee = user.employee;
              
              if(employee.user_id != userId && employee.user_id != 1) {
                userOtions += '<option value="'+employee.user_id+'">' + employee.fullname + '</option>';
              }
            });
          }
          $($this).parents().eq(2).find('select.user_id').html(userOtions);
          $('div.loading').addClass('hide');
        },
        error: function (xhr, ajaxOptions, thrownError) {
          $('div.loading').addClass('hide');
        }
      });
    }
  });

  $(document).on('click', ".add-more-btn", function(event) {
    event.preventDefault();  event.stopPropagation();

    $("form").validate().settings.ignore = ":hidden";

    if($('#view-til-form #input-form-table-body select, #view-til-form #input-form-table-body textarea').valid()) {

      if($("#input-form-table-body tr").length < 10) {
        
        $("#table-to-be-cloned tr").clone().insertAfter($(this).parents().eq(2));
      } else {
        $.toast({
          heading: 'Error',
          text: 'You have reached the maximum length allowed.',
          showHideTransition: 'plain',
          icon: 'error',
          hideAfter: 3000,
          position: 'top-right',
          stack: 3,
          loader: true,
          loaderBg: '#b50505',
        });
        return false;
      }
    }
  });

  $(document).on('click', '.get-comments', function(event) {
    event.preventDefault();  event.stopPropagation();
    getComments($(this));
  });

  $(document).on('click', '.reject-btn', function(event) {
    event.preventDefault();  event.stopPropagation();
    /*$(this).parents().eq(2).find('input,select,textarea').prop('required', false);*/
    $("form").validate().settings.ignore = ".department_id, .user_id, .hod_remarks";

    if($('#view-til-form').valid()) {
      swal({
        closeOnClickOutside: false,
        closeOnEsc: false,
        title: "Are you sure?",
        text: "You want to reject this lead. You will not be able to edit this.",
        icon: "warning",
        buttons: {
          'cancel': {
            text: "Cancel",
            value: null,
            visible: true,
            className: "btn btn-danger",
            closeModal: true,
          },
          'confirm': {
            text: "Confirm",
            value: true,
            visible: true,
            className: "btn btn-success",
            closeModal: true
          }
        },
      }).then(function(isConfirm) {
        if (isConfirm) {
          $('input[name="status"]').val(6);
          $('#view-til-form').submit();
        }
      });
    }
  });

  $(document).on('click', '.save-btn', function(event) {
    event.preventDefault();  event.stopPropagation();
    $("form").validate().settings.ignore = ":hidden";

    if($('#view-til-form').valid()) {
      $('input[name="status"]').val(4);
      $('#view-til-form').submit();
    }
  });

  $(document).on('click', '.approve-btn', function(event) {
    event.preventDefault();  event.stopPropagation();

    $("form").validate().settings.ignore = ":hidden";

    if($('#view-til-form').valid()) {
      $('input[name="status"]').val(5);
      $('#view-til-form').submit();
    }
  });

  $('#view-til-form').validate({
    ignore: ':hidden, input[type=hidden], .select2-search__field', //[type="search"]
    errorElement: 'span',
    // debug: true,
    // the errorPlacement has to take the table layout into account
    errorPlacement: function(error, element) {
      error.appendTo(element.parent()); // element.parent().next()
    },
    rules: {
      comments: { required: true, },
    },
  });  
});

function nl2br(str, is_xhtml) {
  var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br/>' : '<br>';    
  return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1'+ breakTag +'$2');
}

function getComments(obj) {

  var til_id  = $(obj).data('til_id');
  var _token  = '{!! csrf_token() !!}';
  var objdata = {'_token': _token, 'til_id': til_id};

  $.ajax({
    url: "{!! route('leads-management.get-comments') !!}",
    type: "GET",
    data: objdata,
    dataType: 'json',
    success: function (res) {
      if(res.status == 1) {
        // swal("Done!", res.msg, "success");
        if(typeof res != 'undefined' && res != '') {
          var commentsHtml = '';
          
          if(typeof res.data != 'undefined' && res.data != '') {
              $(res.data).each(function(k, v) {
                commentsHtml += '<li>'+
                                  '<i class="fa fa-envelope bg-blue"></i>'+
                                  '<div class="timeline-item">'+
                                    '<h5 class="timeline-header">'+
                                      '<span class="leaveMessageList">'+
                                        '<strong class="text-success">Send by:</strong> '+ v.user_employee.fullname +
                                      '</span>'+
                                       '<span class="leaveMessageList pull-right">'+
                                        '<strong class="text-success">Date/Time:</strong> '+ moment(v.created_at).format('D/M/Y h:mm a') +
                                      '</span>'+
                                    '</h5>'+
                                    '<div class="timeline-body">'+ nl2br(v.comments) + '</div>'+
                                  '</div>'+
                                '</li>';
              });
              commentsHtml += '<li>'+
                                '<i class="fa fa-clock-o bg-gray"></i>'+
                              '</li>';

              $('.commentshtml').html(commentsHtml);
              setTimeout(function() {
                $('.comments-modal').modal('show');
              }, 300);
          } else {
            $.toast({
              heading: 'Error',
              text: 'No prevoius comments were found.',
              showHideTransition: 'plain',
              icon: 'error',
              hideAfter: 3000,
              position: 'top-right', 
              stack: 3, 
              loader: true,
              loaderBg: '#b50505',
            });
            return false;
          }
        }
      } else {
        $.toast({
          heading: 'Error',
          text: res.msg,
          showHideTransition: 'plain',
          icon: 'error',
          hideAfter: 3000,
          position: 'top-right', 
          stack: 3, 
          loader: true,
          loaderBg: '#b50505',
        });
        return false;
      }
    },
    error: function (xhr, ajaxOptions, thrownError) {
      swal("Error Code:", 'Internal server error.', "error");
    }
  });
}

function removeTr(obj) {
  // obj.parent().parent().parent().remove();
  obj.parents().eq(2).remove();
}
</script>
@endsection