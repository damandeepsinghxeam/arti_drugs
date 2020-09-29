@extends('admins.layouts.app')

@section('content')

<!-- Content Wrapper. Contains page content -->
<!-- Bootstrap time Picker -->
<!-- <link rel="stylesheet" href="{ {asset('public/admin_assets/plugins/timepicker/bootstrap-timepicker.min.css')}}"> -->
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">
<link rel="stylesheet" href="{{asset('public/admin_assets/plugins/jquery-toast/jquery.toast.min.css')}}">
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1> Tender Information Log (TIL) </h1>
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
    <div class="row">
      <div class="box box-primary">
        @include('admins.validation_errors')
        <!-- /.box-header -->
        <form id="create_til_form" action="{!! route('leads-management.save-til', $lead->id) !!}" method="POST" class="form-horizontal">
          <!-- enctype="multipart/form-data" -->
          {!! csrf_field() !!}

          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                
                <div class="col-md-6">
                  <div class="form-group row">
                    <label for="tender_owner" class="control-label col-sm-4">
                      Tender Owner: <small class="text-danger">*</small>
                    </label>
                    <div class="col-sm-8">
                      <input type="text" name="tender_owner" id="tender_owner" class="tender_owner form-control" placeholder="Please enter tender owner name." value="{!! $authUser->fullname !!}" required readonly>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="tender_location" class="control-label col-sm-4">
                      Location: <small class="text-danger">*</small>
                    </label>
                    <div class="col-sm-8">
                      <input type="text" name="tender_location" id="tender_location" class="tender_location form-control" placeholder="Please enter TIL location." required>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="tilContactName" class="control-label col-md-4">Contact Person detail:</label>
                    <div class="col-md-8 text-center">
                      <a href="#" id="tilContactName" data-toggle="modal" data-target="#add_contact_details">
                        Add Details
                      </a>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="vertical" class="control-label col-sm-4">Vertical:</label>
                    <div class="col-md-8">
                      <select class="form-control vertical" name="vertical" id="vertical">
                        @if(!empty($verticalOptions) && count($verticalOptions) > 0)
                          @foreach($verticalOptions as $verticalKey => $verticalOption)
                            <option value="{!! $verticalKey !!}">{!! $verticalOption !!}</option>
                          @endforeach
                        @endif
                      </select>
                    </div>
                  </div>

                  <div class="form-group hide other_vertical_div">
                    <label for="other_vertical" class="control-label col-sm-4">&nbsp;</label>
                    <div class="col-md-8">
                      <textarea name="other_vertical" class="form-control other_vertical" rows="2" cols="50" placeholder="Copy & Paste Complete Clause"></textarea>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="bid_system" class="control-label col-sm-4">Bid System:</label>
                    <div class="col-md-8">
                      <select name="bid_system" id="bid_system" class="form-control bid_system">
                        <option value="">-Select-</option>
                        <option value="online">Online</option>
                        <option value="manual">Manual</option>
                        <option value="both">Both</option>
                      </select>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="bid_system_clause" class="control-label col-sm-4">Bid System Clause: <small class="text-danger">*</small></label>
                    <div class="col-md-8">
                      <textarea name="bid_system_clause" class="form-control resize-none bid_system_clause" rows="2" cols="50" required placeholder="Bid system clause"></textarea>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="tenure_one" class="control-label col-sm-4">Tenure:</label>
                    <div class="col-md-8">
                      <input type="number" name="tenure_one" id="tenure_one" class="form-control tenure_one" placeholder="In months" value="">

                      <small id="passwordHelpBlock" class="form-text text-muted">In Months</small>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="tenure_two" class="control-label col-sm-4">
                      Tenure Extension: <small>(If applicable)</small>
                    </label>
                    <div class="col-md-8">
                      <input type="number" name="tenure_two" id="tenure_two" class="form-control tenure_two" placeholder="In months" value="">

                      <small id="passwordHelpBlock" class="form-text text-muted">In Months</small>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="emd_date" class="control-label col-sm-4">EMD Date:</label>
                    <div class="col-md-8">
                      <input type="text" name="emd_date" id="emd_date" class="form-control emd_date future_date" placeholder="Please select EMD date.">
                    </div>
                  </div>
                  
                  <div class="form-group row">
                    <label for="tender_fee" class="control-label col-sm-4">Tender Fee:</label>
                    <div class="col-md-8">
                      <select class="form-control tender_fee select2" name="tender_fee[]" id="tender_fee" multiple>
                        <!-- <option value="">Please Select Tender Fee Type.</option> -->
                        @if(!empty($tenderFeeOptions) && count($tenderFeeOptions) > 0)
                          @foreach($tenderFeeOptions as $tenderFeeKey => $tenderFeeOption)
                            <option value="{!! $tenderFeeKey !!}">{!! $tenderFeeOption !!}</option>
                          @endforeach
                        @endif
                      </select>
                    </div>
                  </div>

                  <div class="form-group row hide tender_fee_amount_div">
                    <label for="tender_fee_amount" class="control-label col-sm-4">Tender Fee Amount:</label>
                    <div class="col-md-8">
                      <input type="number" name="tender_fee_amount" id="tender_fee_amount" class="form-control tender_fee_amount" value="0">
                    </div>
                  </div>

                  <div class="form-group row hide tender_fee_exempted_div">
                    <label for="tender_fee_exempted" class="control-label col-sm-4">Tender Fee Exempted:</label>
                    <div class="col-md-8">
                      <textarea name="tender_fee_exempted" class="form-control tender_fee_exempted" rows="2" cols="50" placeholder="Please enter exempted clause"></textarea>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="fixed_radio" class="control-label no-padding col-sm-4">Performace Guaranty & Security:</label>
                    <div class="col-md-8">
                      <label for="fixed_radio" class="no-padding col-md-6">
                        <input type="Radio" name="performance_guarantee_type" id="fixed_radio" value="1" checked="checked">
                        Fixed
                      </label>
                      <label for="percent_radio" class="no-padding col-md-6 text-right">
                        <input type="Radio" name="performance_guarantee_type" id="percent_radio" value="2">
                        Percent
                      </label>

                      <div class="">
                        <input type="text" name="performance_guarantee" class="form-control performance_guarantee" id="performance_guarantee" placeholder="Please enter performance guarantee & security">
                      </div>
                    </div>
                  </div>

                  <div class="form-group performance_guarantee_clause_div">
                    <label for="performance_guarantee_clause" class="control-label col-sm-4">Performance Guaranty & Security Clause:</label>
                    <div class="col-md-8">
                      <textarea name="performance_guarantee_clause" class="form-control performance_guarantee_clause resize-none" rows="2" cols="50" placeholder="Copy & Paste Complete Clause"></textarea>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="pay_and_collect_radio" class="control-label no-padding col-sm-4">Payment Terms:</label>
                    <div class="col-md-8">

                      <label for="pay_and_collect_radio" class="no-padding col-md-6">
                        <input type="Radio" name="payment_terms" id="pay_and_collect_radio" value="1" checked="checked">
                        Pay & Collect
                      </label>
                      <label for="collect_and_pay_radio" class="no-padding col-md-6 text-right">
                        <input type="Radio" name="payment_terms" id="collect_and_pay_radio" value="2">
                        Collect & Pay
                      </label>

                      <div class="form-group pay_and_collect_div">
                        <div class="col-md-12"> <!-- payAndCollectOne -->
                          <select name="pay_and_collect" id="pay_and_collect" class="form-control pay_and_collect">
                            @if(!empty($payAndCollectOptions) && count($payAndCollectOptions) > 0)
                              @foreach($payAndCollectOptions as $pKey => $pOption)
                                <option value="{!! $pKey !!}">{!! $pOption !!}</option>
                              @endforeach
                            @endif
                          </select>
                        </div>
                      </div>

                      <div class="form-group hide collect_and_pay_div">
                        <div class="col-md-12"> <!-- collectAndPayTwo -->
                          <select name="collect_and_pay" id="collect_and_pay" class="form-control collect_and_pay">
                            @if(!empty($collectAndPayOptions) && count($collectAndPayOptions) > 0)
                              @foreach($collectAndPayOptions as $cKey => $cOption)
                                <option value="{!! $cKey !!}">{!! $cOption !!}</option>
                              @endforeach
                            @endif
                          </select>
                        </div>
                      </div>

                      <div class="form-group hide copy_complete_clause_div">
                        <div class="col-md-12">
                          <textarea name="complete_clause" class="form-control complete_clause" rows="2" cols="50" placeholder="Copy & Paste Complete Clause"></textarea>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="payment_terms_clause" class="control-label col-md-4">Payment Terms Clause: <small class="text-danger">*</small></label>
                    <div class="col-md-8">
                      <textarea name="payment_terms_clause" class="form-control payment_terms_clause resize-none" rows="2" cols="50" required placeholder="Please enter payment terms clause"></textarea>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="penalties" class="control-label col-md-4">Penalties: <small class="text-danger">*</small></label>
                    <div class="col-md-8">
                      <div class="input-group">
                        <input type="text" name="penalties[]" id="penalties" class="form-control penalties" required placeholder="Please enter penalties.">

                        <div id="add_penalties" class="input-group-addon btn" onclick="add_penalties();">
                          <a href="javascript:void(0);" class="a-font-inherit">
                            <i class="fa fa-plus"></i>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div id="add_penalties_div" class="add_penalties_div m-t-sm">

                  </div>

                  <div class="form-group row">
                    <label for="assigned_to_group" class="control-label no-padding col-sm-4">Assigned to (SD Group):</label>
                    <div class="col-md-8">
                      <input type="text" name="assigned_to_group" class="form-control assigned_to_group" id="assigned_to_group" placeholder="Please Assigned to (SD Group)">
                    </div>
                  </div>
                  <!--  ----------------------------------------------------   -->
                  <fieldset>
                    <legend>Financial Information:</legend>
                    <div class="form-group row">
                      <label for="monthly" class="control-label no-padding col-sm-4">Gross Turnover: <small class="text-danger">*</small></label>
                      <div class="col-md-4">
                        <input type="number" name="gross_turnover_monthly" id="gross_turnover_monthly" class="form-control monthly" required placeholder="Monthly">
                      </div>
                      <div class="col-md-4">
                        <input type="number" name="gross_turnover_yearly" id="gross_turnover_yearly" class="form-control yearly" required placeholder="Yearly">
                      </div>
                    </div>
                  </fieldset>

                  <fieldset>
                    <legend>Cost of Tendering:</legend>
                    <div class="form-group row">
                      <label for="emd_amount_c" class="control-label no-padding col-sm-4">EMD amount: <small class="text-danger">*</small></label>
                      <div class="col-md-8">
                        <input type="number" name="emd_amount_c" id="emd_amount_c" class="form-control emd_amount_c" required placeholder="EMD amount">
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="tender_fee_amount_c" class="control-label no-padding col-sm-4">Tender fee amount: <small class="text-danger">*</small></label>
                      <div class="col-md-8">
                        <input type="number" name="tender_fee_amount_c" id="tender_fee_amount_c" class="form-control tender_fee_amount_c" required placeholder="Tender fee amount">
                      </div>
                    </div>
                  </fieldset>

                  <fieldset>
                    <legend>&nbsp;</legend>
                    <div class="form-group row">
                      <label for="monthly" class="control-label no-padding col-sm-4">Investment: <small class="text-danger">*</small></label>
                      <div class="col-md-8">
                        <select name="investment" id="investment" class="form-control investment" required>
                          <option value="">Please Select Investment.</option>
                          <option value="monthly_billing">Monthly Billing</option>
                          <option value="security_in_cash">Security in Cash</option>
                          <option value="pbg">PBG</option>
                          <option value="deduction">Deduction</option>
                          <option value="tds">TDS</option>
                          <option value="others">Others</option>
                        </select>
                      </div>
                    </div>
                  </fieldset>

                </div>

                <div class="col-md-6">
                  <div class="form-group row">
                    <label for="department" class="control-label col-sm-4">
                      Name of Department: <small class="text-danger">*</small>
                    </label>
                    <div class="col-sm-8">
                      <input type="text" name="department" id="department" class="department form-control" placeholder="Please enter name of department" required>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="due_date" class="control-label col-sm-4">
                      Due Date: <small class="text-danger">*</small>
                    </label>
                    <div class="col-sm-8">
                      <input type="text" name="due_date" id="due_date" class="due_date form-control future_date_time" placeholder="Please select due date">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="value_of_work" class="control-label col-md-4">
                      Value of work: <small>(In Lakhs)</small></label>
                    <div class="col-md-8">
                      <div class="input-group">
                        <span class="input-group-addon">
                          <i class="fa fa-inr"></i>
                        </span>

                        <input type="number" name="value_of_work" id="value_of_work" class="form-control value_of_work" placeholder="Please enter value of work">
                      </div>                      
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="volume" class="control-label col-md-4">Volume:</label>
                    <div class="col-md-8">
                      <input type="text" name="volume" id="volume" class="form-control volume" placeholder="Please Enter Volume.">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="scope_of_work" class="control-label col-md-4">Scope of work: <small class="text-danger">*</small></label>
                    <div class="col-md-8">
                      <textarea name="scope_of_work" class="form-control scope_of_work resize-none" rows="2" cols="50" required placeholder="Please enter scope of work"></textarea>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="special_eligibility_clause" class="control-label col-md-4">Special Eligibility Clause:</label>
                    <div class="col-md-8">
                      <div class="input-group">
                        <input type="text" name="special_eligibility_clause[]" id="special_eligibility_clause" class="form-control special_eligibility_clause" placeholder="Please enter special eligibility clause.">

                        <div id="add_special_eligibility" class="input-group-addon btn" onclick="add_eligibility_fields();">
                          <a href="javascript:void(0);" class="a-font-inherit">
                            <i class="fa fa-plus"></i>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div id="special_eligibility_div" class="special_eligibility_div m-t-sm">

                  </div>

                  <div class="form-group row">
                    <label for="technical_qualification" class="control-label col-md-4">Technical Qualification: <small class="text-danger">*</small></label>
                    <div class="col-md-8">
                      <div class="input-group">
                        <input type="text" name="technical_qualification[]" id="technical_qualification" class="form-control technical_qualification" required placeholder="Please enter technical qualification.">

                        <div id="add_technical_qualification" class="input-group-addon btn" onclick="add_technical_qualification_fields();">
                          <a href="javascript:void(0);" class="a-font-inherit">
                            <i class="fa fa-plus"></i>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div id="technical_qualification_div" class="technical_qualification_div m-t-sm">

                  </div>
                                    
                  <div class="form-group row">
                    <label for="emd" class="control-label col-md-4">EMD:</label>
                    <div class="col-md-8">
                      <select class="form-control emd select2" name="emd[]" id="emd" multiple>
                        <!-- <option value="">Please Select EMD.</option> -->
                        @if(!empty($emdOptions) && count($emdOptions) > 0)
                          @foreach($emdOptions as $emdKey => $emdOption)
                            <option value="{!! $emdKey !!}">{!! $emdOption !!}</option>
                          @endforeach
                        @endif
                      </select>
                    </div>
                  </div>

                  <div class="form-group row hide emd_amount_div">
                    <label for="emd_amount" class="control-label col-sm-4">EMD Amount:</label>
                    <div class="col-md-8">
                      <input type="number" name="emd_amount" id="emd_amount" class="form-control emd_amount" value="0">
                    </div>
                  </div>

                  <div class="form-group row hide emd_exempted_div">
                    <label for="emd_exempted" class="control-label col-sm-4">EMD Exempted:</label>
                    <div class="col-md-8">
                      <textarea name="emd_exempted" class="form-control emd_exempted" rows="2" cols="50" placeholder="Please enter exempted clause"></textarea>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="emd_special_clause" class="control-label col-md-4">EMD Special Clause: <small class="text-danger">*</small></label>
                    <div class="col-md-8">
                      <textarea name="emd_special_clause" class="form-control emd_special_clause resize-none" rows="2" cols="50" required placeholder="Please enter emd special clause"></textarea>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="processing_fee" class="control-label col-md-4">Processing Fee:</label>
                    <div class="col-md-8">
                      <select class="form-control processing_fee select2" name="processing_fee[]" id="processing_fee" multiple>
                        <!-- <option value="">Please Select Tender Processing Fee Type.</option> -->
                        @if(!empty($processingFeeOptions) && count($processingFeeOptions) > 0)
                          @foreach($processingFeeOptions as $processingFeeKey => $processingFeeOption)
                            <option value="{!! $processingFeeKey !!}">{!! $processingFeeOption !!}</option>
                          @endforeach
                        @endif
                      </select>
                    </div>
                  </div>

                  <div class="form-group row hide processing_fee_amount_div">
                    <label for="processing_fee_amount" class="control-label col-sm-4">
                      Processing Fee Amount:
                    </label>
                    <div class="col-md-8">
                      <input type="number" name="processing_fee_amount" id="processing_fee_amount" class="form-control processing_fee_amount" value="0">
                    </div>
                  </div>

                  <div class="form-group row hide processing_fee_exempted_div">
                    <label for="processing_fee_exempted" class="control-label col-sm-4">
                      Processing Fee Exempted:
                    </label>
                    <div class="col-md-8">
                      <textarea name="processing_fee_exempted" class="form-control processing_fee_exempted" rows="2" cols="50" placeholder="Please enter exempted clause"></textarea>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="pre_bid_meeting" class="control-label col-md-4">Pre Bid Meeting:</label>
                    <div class="col-md-8">
                      <input type="text" name="pre_bid_meeting" id="pre_bid_meeting" class="form-control pre_bid_meeting future_date_time" placeholder="Please Enter Pre Bid Meeting.">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="pre_bid_clause" class="control-label col-md-4">Pre Bid Clause: <small class="text-danger">*</small></label>
                    <div class="col-md-8">
                      <textarea name="pre_bid_clause" class="form-control pre_bid_clause resize-none" rows="2" cols="50" required placeholder="Please enter pre bid clause"></textarea>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="financial_bid_type" class="control-label col-md-4">Financial Bid Type: <small class="text-danger">*</small></label>
                    <div class="col-md-8">
                      <textarea name="financial_bid_type" class="form-control financial_bid_type resize-none" rows="2" cols="50" required placeholder="Please enter financial bid type"></textarea>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="obligations" class="control-label col-md-4">Obligations:</label>
                    <div class="col-md-8">
                      <select id="obligations" class="form-control obligations" name="obligations">
                        <!-- <option value="">Please select Obligation Type</option> -->
                        @if(!empty($obligationOptions) && count($obligationOptions) > 0)
                          @foreach($obligationOptions as $obligationKey => $obligationOption)
                            <option value="{!! $obligationKey !!}">{!! $obligationOption !!}</option>
                          @endforeach
                        @endif
                      </select>

                      <div id="obligation_field" class="obligation_field hide m-t-sm">
                        
                        <div class="form-group">
                          <div class="col-md-12">
                            <div class="input-group">
                              <input type="text" id="obligation_text" name="obligation_text[]" class="form-control obligation_text" placeholder="Please enter obligation text.">
                              <div id="add_other_field" class="input-group-addon btn" onclick="add_fields();">
                                <a href="javascript:void(0);" class="a-font-inherit">
                                  <i class="fa fa-plus"></i>
                                </a>
                              </div>
                            </div>
                          </div>
                        </div>

                      </div>
                    </div>
                  </div>

                  <div class="form-group row hide">
                    <label for="total_investments" class="control-label col-md-4">Total Investments:</label>
                    <div class="col-md-8">
                      <input type="number" name="total_investments" id="total_investments" class="form-control total_investments" placeholder="Enter total investments." value="0" readonly>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="technical_opening_date" class="control-label no-padding col-sm-4 p-t-sm">Technical Opening Date:</label>
                    <div class="col-md-8">
                      <input type="text" name="technical_opening_date" class="form-control technical_opening_date future_date_time" id="technical_opening_date" placeholder="Please Select Technical Opening Date">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="financial_opening_date" class="control-label col-md-4">Financial Opening Date:</label>
                    <div class="col-md-8">
                      <input type="text" name="financial_opening_date" id="financial_opening_date" class="form-control financial_opening_date future_date_time" placeholder="Please Select Financial Opening Date.">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="technical_criteria" class="control-label col-md-4">Technical Criteria:</label>
                    <div class="col-md-8">
                      <input type="text" name="technical_criteria" id="technical_criteria" class="form-control technical_criteria" placeholder="Please Enter Technical Criteria.">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="financial_criteria" class="control-label col-md-4">Financial Criteria:</label>
                    <div class="col-md-8">
                      <input type="text" name="financial_criteria" id="financial_criteria" class="form-control financial_criteria" placeholder="Please Enter Financial Criteria.">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="award_criteria" class="control-label col-md-4">Award Criteria:</label>
                    <div class="col-md-8">
                      <input type="text" name="award_criteria" id="award_criteria" class="form-control award_criteria" placeholder="Please Enter Award Criteria.">
                    </div>
                  </div>

                  <!--  ----------------------------------------------------   -->  
                </div>
              </div>
            </div>
          </div>
          <!-- /.box-body -->
          <div class="box-footer form-sidechange apply-leave-btn">
            <div class="col-md-12">
              <input type="hidden" name="submit_type" id="submit_type" value="save_as_draft">

              <button type="submit" class="btn btn-warning form-draft-btn" id="save_as_draft">Save & Draft</button>
              <!-- <button type="submit" class="btn btn-success form-save-btn" id="save">Final Submit</button> -->
              <a href="{!! route('leads-management.list-til') !!}" class="btn btn-default">Cancel</a>
            </div>
          </div>

          <div class="modal fade bs-example-modal-sm" id="add_contact_details" tabindex="-1">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                  <h4 class="modal-title" id="mySmallModalLabel">Add contact Person Details</h4>
                </div>
                <div class="modal-body">          
                  <div class="row">
                    <div class="col-md-12">
                      <div class="table-responsive" id="til_contact_form">
                        <table class="table table-bordered table-striped table-hover til_contacts_table">
                          <thead>
                            <tr>
                              <th>Name <small class="text-danger">*</small></th>
                              <th>Designation <small class="text-danger">*</small></th>
                              <th>Mobile Number <small class="text-danger">*</small></th>
                              <th>Email <small class="text-danger">*</small></th>
                              <th>Description <small class="text-danger">*</small></th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody class="til_contacts">
                            <tr>
                              <td>
                                <input type="text" name="til_contact[name][]" id="contact_name[]" class="form-control contact_name" placeholder="Contact Name" value="" required/>
                              </td>
                              <td>
                                <input type="text" name="til_contact[designation][]" id="contact_designation[]" class="form-control contact_designation" placeholder="Designation" value="" required/>
                              </td>
                              <td>
                                <input type="text" name="til_contact[phone][]" id="contact_phone[]" class="form-control contact_phone" placeholder="Mobile Number" value=""/>
                              </td>
                              <td>
                                <input type="text" name="til_contact[email][]" id="contact_email[]" class="form-control contact_email" placeholder="Email" value=""/>
                              </td>
                              <td>
                                <textarea name="til_contact[description][]" id="contact_description[]" class="form-control contact_description resize-none" rows="2" cols="30" required placeholder="Enter description"></textarea>
                              </td>
                              <td>
                                <a href="javascript:void(0);" class="btn btn-primary btn-xs til_contact_add_more">
                                  <i class="fa fa-plus"></i>
                                </a>
                              </td>
                            </tr>
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
        </form>
      </div>
      <!-- /.box -->
    </div>
    <!-- /.row -->
    <!-- Main row -->
  </section>
  <!-- add contact person details modal -->
</div>
<!-- /.content-wrapper -->
<!-- bootstrap time picker -->
<!-- <script src="{ {asset('public/admin_assets/plugins/timepicker/bootstrap-timepicker.min.js')}}"></script> -->
<script src="{{asset('public/admin_assets/plugins/validations/jquery.validate.js')}}"></script>
<script src="{{asset('public/admin_assets/plugins/validations/additional-methods.js')}}"></script>
<script src="{{asset('public/admin_assets/plugins/jquery-toast/jquery.toast.min.js')}}"></script>
<script src="{!! asset('public/admin_assets/plugins/jquery-toast/jquery.toast.min.js') !!}"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>

<script type="text/javascript">
/*$.validator.addMethod("alphabetsnspace", function(value, element) {
  return this.optional(element) || /^[a-zA-Z ]*$/.test(value);
});*/
$(function () {
  
  $.validator.addMethod("dateGreaterThan", function(value, element, params) {
    if ($(params).val() === "") {
      return true;
    }
    if (!/Invalid|NaN/.test(new Date(value))) {
      return new Date(value) > new Date($(params).val());
    }
    return isNaN(value) && isNaN($(params).val()) || (Number(value) > Number($(params).val()));
  }, 'Must be greater than {0}.');

  $.validator.addMethod("dateLessThan", function(value, element, params) {
    if ($(params).val() === "") {
      return true;
    }
    if (!/Invalid|NaN/.test(new Date(value))) {
      return new Date(value) < new Date($(params).val());
    }
    return isNaN(value) && isNaN($(params).val()) || (Number(value) < Number($(params).val()));
  }, 'Must be less than {0}.');

  var validator = $('#create_til_form').validate({
    ignore: ':hidden,input[type=hidden],.select2-search__field', //  [type="search"]
    errorElement: 'span',
    // debug: true,
    errorPlacement: function(error, element) { // the errorPlacement has to take the table layout into account
      // $(element).attr('name')
      if (element.parent().attr('class') == 'input-group') {
        error.appendTo(element.parent().parent());
      }
      else {
        error.appendTo(element.parent()); // element.parent().next()
      }
    },
    rules: {
      tender_owner: "required",
      department: "required",
      tender_location: "required",
      due_date: { date: true },
      value_of_work: { number: true },
      emd_date: { date: true },
      performance_guarantee: { required: true, number: true},
      pre_bid_meeting: { date: true },
      pay_and_collect: "required",
      collect_and_pay: "required",
      complete_clause: {
        required: function(element) {
          return (!$('#pay_and_collect').is(':empty'));
        }
      },
      tenure_year_one: { digits: true },
      tenure_year_two: { digits: true },
      total_investments: { number: true },
      technical_opening_date: { date: true, dateLessThan : '#financial_opening_date' },
      financial_opening_date: { date: true, dateGreaterThan: '#technical_opening_date' },
      volume: { number: true },
      gross_turnover_monthly: { number: true },
      gross_turnover_yearly: { number: true },
      emd_amount_c: { number: true },
      tender_fee_amount_c: { number: true },
    }
  });
  
  $('input.contact_email').each(function(k, v) {
    $(this).rules('add', {
      required: true,
      email: true
    });
  });

  $('input.contact_phone').each(function(k, v) {
    $(this).rules('add', {
      required: true,
      digits: true,
      minlength:10, 
      maxlength:10
    });
  });

  // vertical
  $(document).on('change', '#vertical', function(event) {
    var value = $(this).val();

    if(value == 11) {
      $('.other_vertical_div').removeClass('hide');
    } else {
      $('.other_vertical_div').addClass('hide');
      $('.other_vertical').val('');
    }
  });

  $(document).on('change', '#tender_fee', function(event) {
    var value = $(this).val();

    if(value.length > 0) {
      // $('option', this).not(':eq(0), :selected').attr('disabled', true).select2();
      var tender_fee_val = parseInt(value[0]);

      switch(tender_fee_val) {
        case 8: // case of exempted
          $('option', this).not(':selected').attr('disabled', true);
          $('.tender_fee_exempted_div').removeClass('hide');
          reInitSelect2(event);

          break;
        case 9: // case of not applicable
          $('option', this).not(':selected').attr('disabled', true);
          reInitSelect2(event);

          break;
        default:
          $('.tender_fee_amount_div').removeClass('hide');
          $('.tender_fee_amount').val('');

          $('option[value="8"], option[value="9"]', this).attr('disabled', true);
          reInitSelect2(event);
          $('.tender_fee_exempted_div').addClass('hide');
          $('.tender_fee_exempted').val('');
      }
    } else {
      $('.tender_fee_amount_div').addClass('hide');
      $('.tender_fee_amount').val('');

      $('.tender_fee_exempted_div').addClass('hide');
      $('.tender_fee_exempted').val('');
      $('#tender_fee option').removeAttr('disabled');
      reInitSelect2(event);
    }
  });

  $(document).on('change', '#emd', function(event) {
    var value = $(this).val();

    if(value.length > 0) {
      // $('option', this).not(':eq(0), :selected').attr('disabled', true).select2();
      var emd_val = parseInt(value[0]);

      switch(emd_val) {
        case 8: // case of exempted
          $('option', this).not(':selected').attr('disabled', true);
          $('.emd_exempted_div').removeClass('hide');
          reInitSelect2(event);

          break;
        case 9: // case of not applicable
          $('option', this).not(':selected').attr('disabled', true);
          reInitSelect2(event);

          break;
        default:
          $('.emd_amount_div').removeClass('hide');
          $('.emd_amount').val('');

          $('option[value="8"], option[value="9"]', this).attr('disabled', true);
          reInitSelect2(event);
          $('.emd_exempted_div').addClass('hide');
          $('.emd_exempted').val('');
      }
    } else {
      $('.emd_amount_div').addClass('hide');
      $('.emd_amount').val('');

      $('.emd_exempted_div').addClass('hide');
      $('.emd_exempted').val('');
      $('#emd option').removeAttr('disabled');
      reInitSelect2(event);
    }
  });

  $(document).on('change', '#processing_fee', function(event) {
    var value = $(this).val();

    if(value.length > 0) {
      var processing_fee_val = parseInt(value[0]);
      // $('option', this).not(':eq(0), :selected').attr('disabled', true).select2();
      switch(processing_fee_val) {
        case 8: // case of exempted
          $('option', this).not(':selected').attr('disabled', true);
          $('.processing_fee_exempted_div').removeClass('hide');
          reInitSelect2(event);

          break;
        case 9: // case of not applicable
          $('option', this).not(':selected').attr('disabled', true);
          reInitSelect2(event);

          break;
        default:
          $('.processing_fee_amount_div').removeClass('hide');
          $('.processing_fee_amount').val('');

          $('option[value="8"], option[value="9"]', this).attr('disabled', true);
          reInitSelect2(event);
          $('.processing_fee_exempted_div').addClass('hide');
          $('.processing_fee_exempted').val('');
      }
    } else {
      $('.processing_fee_amount_div').addClass('hide');
      $('.processing_fee_amount').val('');

      $('.processing_fee_exempted_div').addClass('hide');
      $('.processing_fee_exempted').val('');
      $('#processing_fee option').removeAttr('disabled');
      reInitSelect2(event);
    }
  });

  /*save_as_draft, save*/
  /*$(document).on('click', '.form-save-btn', function(event) {
    $('#submit_type').val('save');
  });*/

  $(document).on('click', 'input[name="performance_guarantee_type"]', function() {
    var _value =  $(this).val();

    if(_value == 2) {
      $('input#performance_guarantee').attr('max', 100);
    } else {
      $('input#performance_guarantee').removeAttr('max');
    }
  });

  $(document).on('click', '.form-draft-btn', function(event) {
    $('#submit_type').val('save_as_draft');
  });

  $(document).on('click', '.til_contact_add_more', function(event) {

    if($('#create_til_form #til_contact_form input[required], #create_til_form #til_contact_form textarea.contact_description').valid()) {

      var tbody_html = '<tr>'+
                        '<td>'+
                          '<input type="text" name="til_contact[name][]" id="contact_name" class="form-control contact_name" placeholder="Contact Name" value="" required/>'+
                        '</td>'+
                        '<td>'+
                          '<input type="text" name="til_contact[designation][]" id="contact_designation" class="form-control contact_designation" placeholder="Designation" value="" required/>'+
                        '</td>'+
                        '<td>'+
                          '<input type="text" name="til_contact[phone][]" id="contact_phone" class="form-control contact_phone" placeholder="Mobile Number" value=""/>'+
                        '</td>'+
                        '<td>'+
                          '<input type="text" name="til_contact[email][]" id="contact_email" class="form-control contact_email" placeholder="Email" value=""/>'+
                        '</td>'+
                        '<td>'+
                          '<textarea name="til_contact[description][]" id="contact_description[]" class="form-control contact_description resize-none" rows="2" cols="30" required placeholder="Enter description"></textarea>'+
                        '</td>'+
                        '<td>'+
                          '<a href="javascript:void(0);" class="btn btn-danger btn-xs til_contacts_remove" onclick="remove_fields($(this));">'+
                            '<i class="fa fa-times"></i>'+
                          '</a>'+
                        '</td>'+
                      '</tr>';

      $('.til_contacts_table tbody.til_contacts').append(tbody_html);
    }
  });

  $('#add_contact_details').on('show.bs.modal', function (event) {});

  $(document).on('change', 'input[name="payment_terms"]', function() {
    var  payment_term_val = $(this).val();

    $('#pay_and_collect').val('');
    $('.complete_clause').val('');
    $('#collect_and_pay').val('');

    if(payment_term_val == 1) {
      $('.pay_and_collect_div').removeClass('hide');
      $('.collect_and_pay_div').addClass('hide');
    } else if(payment_term_val == 2) {
      $('.collect_and_pay_div').removeClass('hide');
      $('.pay_and_collect_div').addClass('hide');
      $('.copy_complete_clause_div').addClass('hide');
    }
  });

  $(document).on('change', '#pay_and_collect', function() {
    var  pay_and_collect_val = $(this).val();

    if(pay_and_collect_val != '' && pay_and_collect_val == 5) {
      $('.copy_complete_clause_div').removeClass('hide');
    } else {
      $('.copy_complete_clause_div').addClass('hide');
    }
  });

  $(document).on('change', '#obligations', function() {
    var obligation_val = $(this).val();

    if(obligation_val != '') { /*(obligation_val == 'Financial')*/
      $('#obligation_field').removeClass('hide');
    } else {
      $('#obligation_field').addClass('hide');
    } 
  });

  $(".future_date_time").datetimepicker({
    minDate : new Date(),
    format: 'MM/DD/Y hh:mm',
  });

  $(".future_date").datepicker({
    format:'m/d/yyyy',
    todayHighlight:true,
    todayBtn:'linked',
    startDate: new Date(),
    autoclose: true
  });

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
});

function add_fields() 
{
  if($('input.obligation_text').length) {

    $('input.obligation_text').each(function(k, v) {
      $(this).rules('add', {
        required: true,
      });
    });
  } else {
    $('input.obligation_text').rules('add', {
      required: false,
    });
  }

  var html_to_append = '<div class="form-group">'+
                        '<div class="col-md-12">'+
                          '<div class="input-group">'+
                            '<input type="text" id="obligation_text" name="obligation_text[]" class="form-control obligation_text" placeholder="Please enter obligation text.">'+
                            '<div id="remove_other_field" class="input-group-addon btn" onclick="remove_fields($(this));">'+
                              '<a href="javascript:void(0);" class="a-font-inherit">'+
                                '<i class="fa fa-minus"></i>'+
                              '</a>'+
                            '</div>'+
                          '</div>'+
                        '</div>'+
                      '</div>';

  $('#obligation_field').append(html_to_append);
  // document.getElementById('obligation_field').innerHTML += html_to_append;
}

function remove_fields(_this) 
{
  if($(_this).parent().parent().is('tr')) {
    $(_this).parent().parent().remove();
  } else {
    $(_this).parent().parent().parent().remove();
  }
}

function add_eligibility_fields() 
{
  if($('input.special_eligibility_clause').length > 1) {

    $('input.special_eligibility_clause').each(function(k, v) {
      $(this).rules('add', {
        required: true,
      });
    });
  } else {
    $('input.special_eligibility_clause').rules('add', {
      required: false,
    });
  }

  var html_to_append= '<div class="form-group">'+
                        '<label class="control-label col-md-4">&nbsp;</label>'+
                        '<div class="col-md-8">'+
                          '<div class="input-group">'+
                            '<input type="text" name="special_eligibility_clause[]" id="special_eligibility_clause" class="form-control special_eligibility_clause" placeholder="Please enter special eligibility clause.">'+
                            '<div id="remove_special_eligibility" class="input-group-addon btn" onclick="remove_fields($(this));">'+
                              '<a href="javascript:void(0);" class="a-font-inherit">'+
                                '<i class="fa fa-minus"></i>'+
                              '</a>'+
                            '</div>'+
                          '</div>'+
                        '</div>'+
                      '</div>';
  
  $('#special_eligibility_div').append(html_to_append);
  $('.special_eligibility_div').removeClass('hide');
  // document.getElementById('special_eligibility_div').innerHTML += html_to_append;
}

function add_penalties() 
{
  $('input.penalties').each(function(k, v) {
    $(this).rules('add', {
      required: true,
    });
  });

  var html_to_append= '<div class="form-group">'+
                        '<label class="control-label col-md-4"><small class="text-danger">*</small></label>'+
                        '<div class="col-md-8">'+
                          '<div class="input-group">'+
                            '<input type="text" name="penalties[]" id="penalties" class="form-control penalties" required placeholder="Please enter penalties.">'+
                            '<div id="remove_penalties" class="input-group-addon btn" onclick="remove_fields($(this));">'+
                              '<a href="javascript:void(0);" class="a-font-inherit">'+
                                '<i class="fa fa-minus"></i>'+
                              '</a>'+
                            '</div>'+
                          '</div>'+
                        '</div>'+
                      '</div>';
  
  $('#add_penalties_div').append(html_to_append);
  $('.add_penalties_div').removeClass('hide');
}

function add_technical_qualification_fields() 
{
  $('input.technical_qualification').each(function(k, v) {
    $(this).rules('add', {
      required: true,
    });
  });

  var html_to_append= '<div class="form-group">'+
                        '<label class="control-label col-md-4"><small class="text-danger">*</small></label>'+
                        '<div class="col-md-8">'+
                          '<div class="input-group">'+
                            '<input type="text" name="technical_qualification[]" id="technical_qualification" class="form-control technical_qualification" required placeholder="Please enter technical qualification.">'+
                            '<div id="remove_technical_qualification" class="input-group-addon btn" onclick="remove_fields($(this));">'+
                              '<a href="javascript:void(0);" class="a-font-inherit">'+
                                '<i class="fa fa-minus"></i>'+
                              '</a>'+
                            '</div>'+
                          '</div>'+
                        '</div>'+
                      '</div>';
  
  $('#technical_qualification_div').append(html_to_append);
  $('.technical_qualification_div').removeClass('hide');
}

function reInitSelect2(event) {
  setTimeout(function () {
    $(event.target).select2("destroy").select2();
  }, 100);
}
</script>
@endsection