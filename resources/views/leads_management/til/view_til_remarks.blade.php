@extends('admins.layouts.app')

@section('content')
<link rel="stylesheet" href="{!! asset('public/admin_assets/plugins/jquery-toast/jquery.toast.min.css') !!}">
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
            <div class="row">
              <div class="col-md-12">
                @php 
                  $businessTypeArr = [
                    1 => 'Govt. Business', 2 => 'Corporate Business', 3 => 'International Business'
                  ];
                @endphp
                
                <div class="col-md-3 form-group">
                  <label class="col-md-12 businessType1">Tender Owner:</label>
                  <div class="col-md-12">
                    {!! (!empty($tilDraft->tender_owner))? $tilDraft->tender_owner : '--' !!}
                  </div>
                </div>

                <div class="form-group col-md-3">
                  <label class="control-label col-md-12">Name of Department:</label>
                  <div class="col-md-12">
                    {!! (!empty($tilDraft->department))? $tilDraft->department : '--' !!}
                  </div>
                </div>

                <div class="form-group col-md-3">
                  <label class="control-label col-md-12">Location:</label>
                  <div class="col-md-12">
                    {!! (!empty($tilDraft->tender_location))? $tilDraft->tender_location : '--' !!}
                  </div>
                </div>

                <div class="form-group col-md-3">
                  <label class="control-label col-md-12">Due Date:</label>
                  <div class="col-md-12">
                    @if(!empty($tilDraft->due_date) && $tilDraft->due_date != '0000-00-00 00:00:00')
                        {!! date('m/d/Y H:i A', strtotime($tilDraft->due_date)) !!}
                      @else 
                        --
                    @endif
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                <div class="form-group col-md-3">
                  <label class="control-label col-md-12">Contact Person detail:</label>
                </div>

                <div class="form-group col-md-3">
                  <div class="col-md-12">
                    <a href="#" data-toggle="modal" data-target="#add_contact_details">
                      View Details
                    </a>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                <div class="form-group col-md-3">
                  <label class="control-label col-md-12">Vertical:</label>
                  <div class="col-md-12">
                    @if(!empty($tilDraft->vertical_id))
                        {!! $verticalOptions[$tilDraft->vertical_id] !!}
                      @else 
                        --
                    @endif
                  </div>
                </div>

                <div class="col-md-3 form-group">
                  <label class="control-label col-md-12">Vertical Others:</label>
                  <div class="col-md-12">
                    @if(!empty($tilDraft->other_vertical))
                        {!! $tilDraft->other_vertical !!}
                      @else 
                        --
                    @endif
                  </div>
                </div>

                <div class="form-group col-md-3">
                  <label class="control-label col-md-12">Value of work: <small>(In Lakhs)</small></label>
                  <div class="col-md-12">
                    {!! (!empty($tilDraft->value_of_work))? numberFormat($tilDraft->value_of_work) : '--' !!}
                  </div>
                </div>
                
                <div class="col-md-3 form-group">
                  <label class="contorl-label col-md-12">Bid System:</label>
                  <div class="col-md-12">
                    {!! ucfirst($tilDraft->bid_system) !!}
                  </div>
                </div>
              </div>
            </div>
            
            <div class="row">
              <div class="col-md-12">
                <div class="col-md-3 form-group">
                  <label class="control-label col-md-12">Volume:</label>
                  <div class="col-md-12">
                    {!! (!empty($tilDraft->volume))? numberFormat($tilDraft->volume) : '--' !!}
                  </div>
                </div>

                <div class="col-md-3 form-group">
                  <label class="control-label col-md-12">
                    Tenure: <small>(In Months)</small>
                  </label>
                  <div class="col-md-12">
                    @if(!empty($tilDraft->tenure_one))
                        {!! $tilDraft->tenure_one !!} Months
                      @else 
                        --
                    @endif
                  </div>
                </div>

                <div class="col-md-3 form-group">
                  <label class="control-label col-md-12">
                    Tenure Extension: <small>(If applicable)</small>
                  </label>
                  <div class="col-md-12">
                    @if(!empty($tilDraft->tenure_two))
                        {!! $tilDraft->tenure_two !!}  Months
                      @else 
                        --
                    @endif
                  </div>
                </div>

                <div class="col-md-3 form-group">
                  <label class="control-label col-md-12">Special Eligibility Clause:</label>
                  <div class="col-md-12">
                    @if(!empty($tilDraft->tilSpecialEligibility)) 
                      @foreach($tilDraft->tilSpecialEligibility as $eKey => $eligibility)
                        <span class="label label-primary">{!! $eligibility->special_eligibility !!}</span>
                      @endforeach
                      @else 
                      --
                    @endif
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                <div class="col-md-3 form-group">
                  <label class="control-label col-md-12">EMD Date:</label>
                  <div class="col-md-12">
                    @if(!empty($tilDraft->emd_date) && $tilDraft->emd_date != '0000-00-00 00:00:00')
                        {!! date('m/d/Y', strtotime($tilDraft->emd_date)) !!}
                      @else 
                      --
                    @endif
                  </div>
                </div>

                <div class="col-md-3 form-group">
                  <label class="control-label col-md-12">EMD:</label>
                  <div class="col-md-12">
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
                  </div>
                </div>

                <div class="col-md-3 form-group">
                  <label class="control-label col-md-12">EMD Amount:</label>
                  <div class="col-md-12">
                    @if(!empty($tilDraft->emd_amount))
                      <span class="fa fa-inr">{!! numberFormat($tilDraft->emd_amount) !!}</span>
                    @else
                      --
                    @endif
                  </div>
                </div>

                <div class="col-md-3 form-group">
                  <label class="control-label col-md-12">EMD Exempted:</label>
                  <div class="col-md-12">
                    @if(!empty($tilDraft->emd_exempted))
                      {!! nl2br($tilDraft->emd_exempted) !!}
                    @else
                    --
                    @endif
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                <div class="col-md-3 form-group">
                  <label class="control-label col-md-12">Tender Fee:</label>
                  <div class="col-md-12">
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
                  </div>
                </div>

                <div class="col-md-3 form-group">
                  <label class="control-label col-md-12">Tender Fee Amount:</label>
                  <div class="col-md-12">
                    @if(!empty($tilDraft->tender_fee_amount))
                      <span class="fa fa-inr">{!! $tilDraft->tender_fee_amount !!}</span>
                    @else
                      --
                    @endif
                  </div>
                </div>

                <div class="col-md-3 form-group">
                  <label class="control-label col-md-12">Tender Fee Exempted:</label>
                  <div class="col-md-12">
                    @if(!empty($tilDraft->tender_fee_exempted))
                      {!! nl2br($tilDraft->tender_fee_exempted) !!}
                    @else
                      --
                    @endif
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                <div class="col-md-3 form-group">
                  <label class="control-label col-md-12">Processing Fee:</label>
                  <div class="col-md-12">
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
                  </div>
                </div>

                <div class="col-md-3 form-group">
                  <label class="control-label col-md-12">Processing Fee Amount:</label>
                  <div class="col-md-12">
                    @if(!empty($tilDraft->processing_fee_amount))
                      <span class="fa fa-inr">{!! $tilDraft->processing_fee_amount !!}</span>
                    @else
                      --
                    @endif
                  </div>
                </div>

                <div class="col-md-3 form-group">
                  <label class="control-label col-md-12">Processing Fee Exempted:</label>
                  <div class="col-md-12">
                    @if(!empty($tilDraft->processing_fee_exempted))
                      {!! nl2br($tilDraft->processing_fee_exempted) !!}
                    @else
                      --
                    @endif
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                <div class="col-md-3 form-group">
                  <label class="control-label col-md-12">Performance Guaranty & Security:</label>
                  <div class="col-md-12">
                    <!-- performance_guarantee_typ, performance_guarantee--->
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
                  </div>
                </div>

                <div class="col-md-3 form-group performance_guarantee_clause_div">
                  <label for="performance_guarantee_clause" class="control-label col-md-12">Performance Guaranty & Security Clause:</label>
                  <div class="col-md-12">
                    @if(!empty($tilDraft->performance_guarantee_clause))
                      {!! nl2br($tilDraft->performance_guarantee_clause) !!}
                    @else
                    --
                    @endif
                  </div>
                </div>

                <div class="col-md-3 form-group">
                  <label class="control-label col-md-12">Pre Bid Meeting:</label>
                  <div class="col-md-12">
                    @if(!empty($tilDraft->pre_bid_meeting) && $tilDraft->pre_bid_meeting != '0000-00-00 00:00:00')
                        {!! date('m/d/Y H:i A', strtotime($tilDraft->pre_bid_meeting)) !!}
                      @else 
                      --
                    @endif
                  </div>
                </div>            
                
                <div class="col-md-3 form-group">
                  <label class="control-label col-md-12">Payment Terms:</label>
                  <div class="col-md-12">
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
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                <div class="form-group col-md-3">
                  <label class="control-label col-md-12">Obligations:</label>
                  <div class="col-md-12">
                    @php
                      if(array_key_exists('', $obligationOptions)) {
                        unset($obligationOptions['']);
                      }
                    @endphp

                    @if(!empty($tilDraft->obligation_id) && isset($obligationOptions[$tilDraft->obligation_id]))
                      <span class="label label-primary">{!! $obligationOptions[$tilDraft->obligation_id] !!}</span>
                    @endif

                    @if(!empty($tilDraft->tilObligation)) 
                      @foreach($tilDraft->tilObligation as $oKey => $obligation)
                        <span class="label label-primary">{!! $obligation->obligation !!}</span>
                      @endforeach
                    @else 
                      --
                    @endif

                  </div>
                </div>

                @if(auth()->user()->can('leads-management.view-cost-estimation'))
                  <div class="form-group col-md-3">
                    <label class="control-label col-md-12">Total Investments:</label>
                    <div class="col-md-12">
                      @if(!empty($tilDraft->total_investments))
                          {!! numberFormat($tilDraft->total_investments) !!}
                        @else 
                          --
                      @endif
                    </div>
                    @if(!empty($tilDraft->costEstimationDraft))
                      <div class="col-md-12">
                        @php
                          $costEstimationUrl = 'leads-management.view-cost-estimation';
                        @endphp

                        <a href="{!! route($costEstimationUrl, $tilDraft->id) !!}" id="cost-estimation" class="pull-left" target="_blank"> Cost Estimation Sheet </a>
                      </div>
                    @endif
                  </div>
                @endif

                <div class="form-group col-md-3">
                  <label class="control-label col-md-12">Penalties:</label>
                  <div class="col-md-12">
                    @if(!empty($tilDraft->penalties))
                        {!! numberFormat($tilDraft->penalties) !!}
                      @else 
                        --
                    @endif
                  </div>
                </div>

                <div class="form-group col-md-3">
                  <label class="control-label col-md-12">Financial Opening Date:</label>
                  <div class="col-md-12">
                    @if(!empty($tilDraft->financial_opening_date) && $tilDraft->financial_opening_date != '0000-00-00 00:00:00')
                        {!! date('m/d/Y H:i A', strtotime($tilDraft->financial_opening_date)) !!}
                      @else 
                      --
                    @endif
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-sm-12">
                <div class="form-group col-md-3">
                  <label class="control-label col-md-12">Assigned to (SD Group):</label>
                  <div class="col-md-12">
                    @if(!empty($tilDraft->assigned_to_group))
                        {!! $tilDraft->assigned_to_group !!}
                      @else 
                        --
                    @endif
                  </div>
                </div>

                <div class="form-group col-md-3">
                  <label class="control-label col-md-12">Technical Opening Date:</label>
                  <div class="col-md-12">
                    @if(!empty($tilDraft->technical_opening_date) && $tilDraft->technical_opening_date != '0000-00-00 00:00:00')
                        {!! date('m/d/Y H:i A', strtotime($tilDraft->technical_opening_date)) !!}
                      @else 
                      --
                    @endif
                  </div>
                </div>

                <div class="form-group col-md-3">
                  <label class="control-label col-md-12">Technical Criteria:</label>
                  <div class="col-md-12">
                    @if(!empty($tilDraft->technical_criteria))
                        {!! $tilDraft->technical_criteria !!}
                      @else 
                      --
                    @endif
                  </div>
                </div>

                <div class="form-group col-md-3">
                  <label class="control-label col-md-12">Financial Criteria:</label>
                  <div class="col-md-12">
                    @if(!empty($tilDraft->financial_criteria))
                        {!! $tilDraft->financial_criteria !!}
                      @else 
                      --
                    @endif
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-sm-12">
                <div class="form-group col-md-3">
                  <label class="control-label col-md-12">Award Criteria:</label>
                  <div class="col-md-12">
                    @if(!empty($tilDraft->award_criteria))
                        {!! $tilDraft->award_criteria !!}
                      @else 
                      --
                    @endif
                  </div>
                </div>
              </div>
            </div>
            @php
              $statusArr = [
                1 => 'New', 2 => 'Open', 3 => 'Complete',
                4 => 'Sent for Remarks', 5 => 'Sent For Approval',
                6 => 'Rejected by Hod',  7 => 'Abandoned',
                8 => 'Closed'
              ];
              $userId = $authUser->id;
            @endphp
            <form id="view-til-form" class="form-vertical" action="{{ route('leads-management.save-til-remarks', $tilDraft->id) }}" method="POST">
              @csrf()
              <div class="row">
                <div class="col-sm-12">
                  <div class="col-sm-12">
                    <!-- itinerary field set -->
                    <fieldset>
                      <legend>Input Form:</legend>
                      <div class="col-md-12 table-responsive no-padding">
                        <table id="input-form-table" class="table table-bordered table-striped travel-table-inner" style="height:150px;">
                          <thead class="table-heading-style dim-gray">
                            <tr>
                              <th>Department</th>
                              <th>Users</th>
                              <th>Hod Remarks</th>
                              <th>User Remarks</th>
                            </tr>
                          </thead>
                          <tbody id="input-form-table-body">
                            @php
                              $isRemarksPending = 0;
                            @endphp
                            @if(!empty($tilDraftInputs))
                              @foreach($tilDraftInputs as $dkey => $input)
                                @php
                                  $userRemarks    = nl2br($input->user_remarks);
                                  $isRemarksPending = empty($userRemarks)? $isRemarksPending + 1 : 0;
                                @endphp
                                <tr>
                                  <td>
                                    <div class="col-md-12">
                                      <span>{!! $input->department->name ?? '--' !!}</span>
                                    </div>
                                  </td>
                                  <td>
                                    <div class="col-md-12">
                                      <span>{!! trim($input->user->employee->fullname ?? '--') !!}</span>
                                    </div>
                                  </td>
                                  <td>
                                    <div class="col-md-12">
                                      <span>{!! nl2br($input->hod_remarks ?? '--') !!}</span>
                                    </div>
                                  </td>
                                  <td>
                                    <div class="col-md-12">
                                      @if(empty($input->user_remarks))
                                        <textarea name="user_remarks[{{$input->id}}]" class="form-control user_remarks" cols="20" rows="3" style="resize: none;" required></textarea>

                                        <input type="hidden" name="draft_input_id[]" value="{!! $input->id !!}">
                                      @else
                                        <span>{!! nl2br($input->user_remarks ?? '--') !!}</span>
                                      @endif
                                    </div>
                                  </td>
                                </tr>
                              @endforeach
                            @endif
                          </tbody>
                        </table>
                      </div>
                    </fieldset>
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <div class="col-md-12">
                  @if(!empty($isRemarksPending))
                    <button type="submit" class="btn btn-primary">Save</button>
                  @endif
                  <a href="{!! route('leads-management.til-remarks-list') !!}" class="btn btn-default m-l-10">Back</a>
                </div>
              </div>
            </form>
          </div>
          <!-- /.box-body -->
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
                    <th> Name </th>
                    <th> Designation </th>
                    <th> Mobile Number </th>
                    <th> Email </th>
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
                      </tr>                      
                    @endforeach
                  
                  @else
                    <tr class="til_contacts">
                      <td class="text-center" colspan="4"> No Record Found! </td>
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
        url: "{{url('employees/departments-wise-employees')}}",
        data: {department_ids: departments},
        beforeSend: function() {
          // setting a timeout
          $('div.loading').removeClass('hide');          
        },
        success: function(result) {          
          if(result.length > 0) {
            result.forEach(function(employee) {
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

  $('#view-til-form').validate({
    ignore: ':hidden, input[type=hidden], .select2-search__field', //  [type="search"]
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
                                    '<div class="timeline-body">'+ v.comments + '</div>'+
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