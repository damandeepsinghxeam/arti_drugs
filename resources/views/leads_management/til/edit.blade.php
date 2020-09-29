@extends('admins.layouts.app')
@section('content')

<!-- Content Wrapper. Contains page content -->
<!-- Bootstrap time Picker -->
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
        <form id="create_til_form" action="{!! route('leads-management.update-til', $tilDraft->id) !!}" method="POST" class="form-horizontal">
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
                      <input type="text" name="tender_owner" id="tender_owner" class="tender_owner form-control" placeholder="Please enter tender owner name." value="{!! $tilDraft->tender_owner !!}" required readonly>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="tender_location" class="control-label col-sm-4">
                      Location: <small class="text-danger">*</small>
                    </label>
                    <div class="col-sm-8">
                      <input type="text" name="tender_location" id="tender_location" class="tender_location form-control" placeholder="Please enter TIL location." value="{!! $tilDraft->tender_location !!}" required>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="tilContactName" class="col-md-4">Contact Person detail:</label>
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
                        <!-- <option value="">Please Select Vertical.</option> -->
                        @if(!empty($verticalOptions) && count($verticalOptions) > 0)
                          @foreach($verticalOptions as $verticalKey => $verticalOption)
                            @php
                              $selectedVertical = ($tilDraft->vertical_id == $verticalKey)? 'selected' : null;
                            @endphp
                            <option value="{!! $verticalKey !!}" {!! $selectedVertical !!}>{!! $verticalOption !!}</option>
                          @endforeach
                        @endif
                      </select>
                    </div>
                  </div>
                  @php
                    $otherVerticalHide = ($tilDraft->vertical_id == 11)? null : 'hide';
                  @endphp
                  <div class="form-group {!! $otherVerticalHide !!} other_vertical_div">
                    <label for="other_vertical" class="control-label col-sm-4">&nbsp;</label>
                    <div class="col-md-8">
                      <textarea name="other_vertical" class="form-control other_vertical" rows="2" cols="50" placeholder="Copy & Paste Complete Clause">{!! $tilDraft->other_vertical !!}</textarea>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="bid_system" class="control-label col-sm-4">Bid System:</label>
                    <div class="col-md-8">
                      <select class="form-control bid_system" name="bid_system" id="bid_system">
                        <option value="">-Select-</option>
                        <option value="online" @if($tilDraft->bid_system == 'online') selected @endif>Online</option>
                        <option value="manual" @if($tilDraft->bid_system == 'manual') selected @endif>Manual</option>
                        <option value="both" @if($tilDraft->bid_system == 'both') selected @endif>Both</option>
                      </select>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="bid_system_clause" class="control-label col-sm-4">Bid System Clause: <small class="text-danger">*</small></label>
                    <div class="col-md-8">
                      <textarea name="bid_system_clause" class="form-control resize-none bid_system_clause" rows="2" cols="50" required placeholder="Bid system clause">{!! $tilDraft->bid_system_clause !!}</textarea>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="tenure_one" class="control-label col-sm-4">Tenure:</label>
                    <div class="col-md-8">
                      <input type="number" name="tenure_one" id="tenure_one" class="form-control tenure_one" value="{!! $tilDraft->tenure_one !!}" placeholder="In Months" min="0">

                      <small id="passwordHelpBlock" class="form-text text-muted">In Months</small>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="tenure_two" class="control-label col-sm-4">
                      Tenure Extension: <small>(If applicable)</small>
                    </label>
                    <div class="col-md-8">
                      <input type="number" name="tenure_two" id="tenure_two" class="form-control tenure_two" placeholder="In Months" value="{!! $tilDraft->tenure_two !!}">

                      <small id="passwordHelpBlock" class="form-text text-muted">In Months</small>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="emd_date" class="control-label col-sm-4">EMD Date:</label>
                    <div class="col-md-8">
                      @php
                        $emdDate = null;
                        if(!empty($tilDraft->emd_date)) {
                          $emdDate = date('m/d/Y', strtotime($tilDraft->emd_date));
                        }
                      @endphp
                      <input type="text" name="emd_date" id="emd_date" class="form-control emd_date future_date" placeholder="Please select EMD date." value="{!! $emdDate !!}">
                    </div>
                  </div>
                  
                  <div class="form-group row">
                    <label for="tender_fee" class="control-label col-sm-4">Tender Fee:</label>
                    <div class="col-md-8">
                      <select class="form-control tender_fee select2" name="tender_fee[]" id="tender_fee" multiple>
                        @if(!empty($tenderFeeOptions) && count($tenderFeeOptions) > 0)
                          @php
                            $tilTenderFee = explode(',', $tilDraft->tender_fee);
                          @endphp
                          @foreach($tenderFeeOptions as $tenderFeeKey => $tenderFeeOption)
                            @php
                              $selectedTenderFee = null;
                              if(!empty($tilTenderFee) && in_array($tenderFeeKey, $tilTenderFee)) {
                                $selectedTenderFee = 'selected';
                              }
                            @endphp
                            <option value="{!! $tenderFeeKey !!}" {!! $selectedTenderFee !!}>{!! $tenderFeeOption !!}</option>
                          @endforeach
                        @endif
                      </select>
                    </div>
                  </div>
                  @php
                    $tenderFeeAmountHide = 'hide';
                    if(!empty($tilDraft->tender_fee_amount) && !in_array(8, explode(',', $tilDraft->tender_fee)) && !in_array(9, explode(',', $tilDraft->tender_fee))) {
                      $tenderFeeAmountHide = null;
                    }
                  @endphp
                  <div class="form-group row {{$tenderFeeAmountHide}} tender_fee_amount_div">
                    <label for="tender_fee_amount" class="control-label col-sm-4">Tender Fee Amount:</label>
                    <div class="col-md-8">
                      @php
                        $tenderFeeAmount = (!empty($tilDraft->tender_fee_amount))? $tilDraft->tender_fee_amount : 0;
                      @endphp
                      <input type="number" name="tender_fee_amount" id="tender_fee_amount" class="form-control tender_fee_amount" value="{!! $tenderFeeAmount !!}">
                    </div>
                  </div>
                  @php
                    $tenderFeeExemptedHide = 'hide';
                    if(!empty($tilDraft->tender_fee_exempted) && in_array(8, explode(',', $tilDraft->tender_fee))) {
                      $tenderFeeExemptedHide = null;
                    }
                  @endphp
                  <div class="form-group row {{$tenderFeeExemptedHide}} tender_fee_exempted_div">
                    <label for="tender_fee_exempted" class="control-label col-sm-4">Tender Fee Exempted:</label>
                    <div class="col-md-8">
                      @php
                        $tenderFeeExempted = (!empty($tilDraft->tender_fee_exempted))? $tilDraft->tender_fee_exempted : null;
                      @endphp
                      <textarea name="tender_fee_exempted" class="form-control tender_fee_exempted" rows="2" cols="50" placeholder="Please enter exempted clause">{{$tenderFeeExempted}}</textarea>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="fixed_radio" class="control-label no-padding col-sm-4">Performace Guaranty & Security:</label>
                    <div class="col-md-8">
                      @php
                        $performanceType = $tilDraft->performance_guarantee_type;
                      @endphp
                      <label for="fixed_radio" class="no-padding col-md-6">
                        <input type="Radio" name="performance_guarantee_type" id="fixed_radio" value="1" @if($performanceType == 1) checked @endif>
                        Fixed
                      </label>
                      <label for="percent_radio" class="no-padding col-md-6 text-right">
                        <input type="Radio" name="performance_guarantee_type" id="percent_radio" value="2"  @if($performanceType == 2) checked @endif>
                        Percent
                      </label>

                      <div class="">
                        @php 
                          $performanceGuarantee = $tilDraft->performance_guarantee;
                          if($performanceType == 1) {
                            $performanceGuarantee = numberFormat($tilDraft->performance_guarantee);
                          }
                        @endphp
                        <input type="text" name="performance_guarantee" class="form-control performance_guarantee" id="performance_guarantee" placeholder="Please enter performance guarantee & security" value="{!! $performanceGuarantee !!}">
                      </div>
                    </div>
                  </div>

                  <div class="form-group performance_guarantee_clause_div">
                    <label for="performance_guarantee_clause" class="control-label col-sm-4">Performance Guaranty & Security Clause:</label>
                    <div class="col-md-8">
                      @php
                        $performanceGuaranteeClause = (!empty($tilDraft->performance_guarantee_clause))? $tilDraft->performance_guarantee_clause : 0;
                      @endphp
                      <textarea name="performance_guarantee_clause" class="form-control performance_guarantee_clause resize-none" rows="2" cols="50" placeholder="Copy & Paste Complete Clause">{!! $performanceGuaranteeClause !!}</textarea>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="pay_and_collect_radio" class="control-label no-padding col-sm-4">Payment Terms:</label>
                    <div class="col-md-8">
                      @php
                        $paymentTerm = $tilDraft->payment_terms;
                      @endphp

                      <label for="pay_and_collect_radio" class="no-padding col-md-6">
                        <input type="Radio" name="payment_terms" id="pay_and_collect_radio" value="1" @if($paymentTerm == 1) checked @endif>
                        Pay & Collect
                      </label>
                      <label for="collect_and_pay_radio" class="no-padding col-md-6 text-right">
                        <input type="Radio" name="payment_terms" id="collect_and_pay_radio" value="2" @if($paymentTerm == 2) checked @endif>
                        Collect & Pay
                      </label>

                      <div class="form-group pay_and_collect_div @if($paymentTerm == 2) hide @endif">
                        <div class="col-md-12"> <!-- payAndCollectOne -->
                          <select name="pay_and_collect" id="pay_and_collect" class="form-control pay_and_collect">
                            @if(!empty($payAndCollectOptions) && count($payAndCollectOptions) > 0)
                              @foreach($payAndCollectOptions as $pKey => $pOption)
                                @php
                                  $selectedPayAndCollect = ($tilDraft->pay_and_collect == $pKey)? 'selected' : null;
                                @endphp
                                <option value="{!! $pKey !!}" {!! $selectedPayAndCollect !!}>{!! $pOption !!}</option>
                              @endforeach
                            @endif
                          </select>
                        </div>
                      </div>

                      <div class="form-group @if($paymentTerm == 1) hide @endif collect_and_pay_div">
                        <div class="col-md-12"> <!-- collectAndPayTwo -->
                          <select name="collect_and_pay" id="collect_and_pay" class="form-control collect_and_pay">
                            <!-- <option value="">Please select colleact & pay option.</option> -->
                            @if(!empty($collectAndPayOptions) && count($collectAndPayOptions) > 0)
                              @foreach($collectAndPayOptions as $cKey => $cOption)
                                @php
                                  $selectedCollectAndPay = ($tilDraft->collect_and_pay == $cKey)? 'selected' : null;
                                @endphp
                                <option value="{!! $cKey !!}" {!! $selectedCollectAndPay !!}>{!! $cOption !!}</option>
                              @endforeach
                            @endif
                          </select>
                        </div>
                      </div>

                      <div class="form-group @if($paymentTerm == 2 || ($paymentTerm == 1 && $tilDraft->pay_and_collect != 5)) hide @endif copy_complete_clause_div">
                        <div class="col-md-12">
                          <textarea name="complete_clause" class="form-control complete_clause" rows="2" cols="50" placeholder="Copy & Paste Complete Clause">{!! nl2br($tilDraft->complete_clause) !!}</textarea>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="payment_terms_clause" class="control-label col-md-4">Payment Terms Clause: <small class="text-danger">*</small></label>
                    <div class="col-md-8">
                      <textarea name="payment_terms_clause" class="form-control payment_terms_clause resize-none" rows="2" cols="50" required placeholder="Please enter payment terms clause">{!! $tilDraft->payment_terms_clause !!}</textarea>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="penalties" class="control-label col-md-4">Penalties: <small class="text-danger">*</small></label>
                    @php
                      $penaltiesText = null; $penaltiesId = null;
                      $penaltiesTextArr = [];
                      if(!empty($tilDraft->tilDraftPenalties)) {
                        foreach ($tilDraft->tilDraftPenalties as $elKey => $tilPenalty) {
                          if($elKey == 0) {
                            $penaltiesId = $tilPenalty->id;
                            $penaltiesText   = $tilPenalty->penalty;
                            
                          } else if($elKey > 0) {
                            $penaltiesTextArr[$tilPenalty->id] = $tilPenalty->penalty;
                          }
                        }
                      }
                    @endphp
                    <div class="col-md-8">
                      <div class="input-group">
                        <input type="hidden" name="penalties[id][]" class="penalties_id" value="{!! $penaltiesId !!}">

                        <input type="text" name="penalties[name][]" class="form-control penalties" value="{!! $penaltiesText !!}" required placeholder="Please enter penalties.">

                        <div id="add_penalties" class="input-group-addon btn" onclick="add_penalties();">
                          <a href="javascript:void(0);" class="a-font-inherit">
                            <i class="fa fa-plus"></i>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div id="add_penalties_div" class="add_penalties_div m-t-sm">
                    @if(!empty($penaltiesTextArr) && count($penaltiesTextArr) > 0) 

                      @foreach($penaltiesTextArr as $eKey => $penalties)
                        <div class="form-group">
                          <label class="control-label col-md-4"><small class="text-danger">*</small></label>
                          <div class="col-md-8">
                            <div class="input-group">
                              <input type="hidden" name="penalties[id][]" class="penalties_id" value="{!! $eKey !!}">

                              <input type="text" name="penalties[name][]" class="form-control penalties" required value="{!! $penalties !!}" placeholder="Please enter penalties.">

                              <div id="penalties_action_div" class="input-group-addon btn remove_penalties">
                                <a href="javascript:void(0);" class="a-font-inherit">
                                  <i class="fa fa-minus"></i>
                                </a>
                              </div>
                            </div>
                          </div>
                        </div>
                      @endforeach
                    @endif
                  </div>

                  <div class="form-group row">
                    <label for="assigned_to_group" class="control-label no-padding col-sm-4">Assigned to (SD Group):</label>
                    <div class="col-md-8">
                      <input type="text" name="assigned_to_group" class="form-control assigned_to_group" id="assigned_to_group" placeholder="Please Assigned to (SD Group)" value="{!! $tilDraft->assigned_to_group !!}">
                    </div>
                  </div>
                  <!--  ---------------------------------------------------- -->
                  <fieldset>
                    <legend>Financial Information:</legend>
                    <div class="form-group row">
                      <label for="monthly" class="control-label no-padding col-sm-4">Gross Turnover: <small class="text-danger">*</small></label>
                      <div class="col-md-4">
                        <input type="number" name="gross_turnover_monthly" id="gross_turnover_monthly" class="form-control monthly" value="{!! $tilDraft->gross_turnover_monthly !!}" required placeholder="Monthly">
                      </div>
                      <div class="col-md-4">
                        <input type="number" name="gross_turnover_yearly" id="gross_turnover_yearly" class="form-control yearly" value="{!! $tilDraft->gross_turnover_yearly !!}" required placeholder="Yearly">
                      </div>
                    </div>
                  </fieldset>

                  <fieldset>
                    <legend>Cost of Tendering:</legend>
                    <div class="form-group row">
                      <label for="emd_amount_c" class="control-label no-padding col-sm-4">EMD amount: <small class="text-danger">*</small></label>
                      <div class="col-md-8">
                        <input type="number" name="emd_amount_c" id="emd_amount_c" class="form-control emd_amount_c" value="{!! $tilDraft->emd_amount_c !!}" required placeholder="Yearly" required placeholder="EMD amount">
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="tender_fee_amount_c" class="control-label no-padding col-sm-4">Tender fee amount: <small class="text-danger">*</small></label>
                      <div class="col-md-8">
                        <input type="number" name="tender_fee_amount_c" id="tender_fee_amount_c" class="form-control tender_fee_amount_c" value="{!! $tilDraft->tender_fee_amount_c !!}" required placeholder="Tender fee amount">
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
                          <option value="monthly_billing" @if($tilDraft->investment == 'monthly_billing') selected @endif>Monthly Billing</option>
                          <option value="security_in_cash" @if($tilDraft->investment == 'security_in_cash') selected @endif>Security in Cash</option>
                          <option value="pbg" @if($tilDraft->investment == 'pbg') selected @endif>PBG</option>
                          <option value="deduction" @if($tilDraft->investment == 'deduction') selected @endif>Deduction</option>
                          <option value="tds" @if($tilDraft->investment == 'tds') selected @endif>TDS</option>
                          <option value="others" @if($tilDraft->investment == 'others') selected @endif>Others</option>
                        </select>
                      </div>
                    </div>
                  </fieldset>
                  <!--  ---------------------------------------------------- -->
                  <div class="row">
                    <div class="col-md-12">
                      <div class="col-md-12">
                        <div class="form-group">
                          <div class="col-md-12">
                            <label for="comments" class="control-label">Comments:</label>

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

                            <div class="comments_div">
                              @php 
                                $comments = old('comments'); 
                              @endphp
                              <textarea name="comments" id="comments" cols="30" rows="3" class="form-control">{{$comments}}</textarea>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!--  ---------------------------------------------------- -->
                </div>

                <div class="col-md-6">
                  <div class="form-group row">
                    <label for="department" class="control-label col-sm-4">
                      Name of Department: <small class="text-danger">*</small>
                    </label>
                    <div class="col-sm-8">
                      <input type="text" name="department" id="department" class="department form-control" placeholder="Please enter name of department" required value="{!! $tilDraft->department !!}">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="due_date" class="control-label col-sm-4">
                      Due Date: <small class="text-danger">*</small>
                    </label>
                    <div class="col-sm-8">
                      @php
                        $dueDate = !empty($tilDraft->due_date)? date('m/d/Y H:i', strtotime($tilDraft->due_date)) : null;
                      @endphp
                      <input type="text" name="due_date" id="due_date" class="due_date form-control future_date_time" placeholder="Please select due date" value="{!! $dueDate !!}">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="value_of_work" class="control-label col-md-4">Value of work: <small>(In Lakhs)</small></label>
                    <div class="col-md-8">

                      <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-inr"></i></span>
                        <input type="number" name="value_of_work" id="value_of_work" class="form-control value_of_work" placeholder="Please enter value of work" value="{!! numberFormat($tilDraft->value_of_work) !!}" min="0">
                      </div>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="volume" class="control-label col-md-4">Volume:</label>
                    <div class="col-md-8">
                      <input type="number" name="volume" id="volume" class="form-control volume" placeholder="Please Enter Volume." value="{!! numberFormat($tilDraft->volume) !!}" min="0">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="scope_of_work" class="control-label col-md-4">Scope of work:</label>
                    <div class="col-md-8">
                      <textarea name="scope_of_work" class="form-control scope_of_work resize-none" rows="2" cols="50" placeholder="Please enter scope of work">{!! $tilDraft->scope_of_work !!}</textarea>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="special_eligibility_clause" class="control-label col-md-4">Special Eligibility Clause:</label>
                    @php
                      $eligibilityText = null; $eligibilityTextId = null;
                      $eligibilityTextArr = [];
                      if(!empty($tilDraft->tilSpecialEligibility)) {
                        foreach ($tilDraft->tilSpecialEligibility as $elKey => $tilEligibility) {
                          if($elKey == 0) {
                            $eligibilityTextId = $tilEligibility->id;
                            $eligibilityText   = $tilEligibility->special_eligibility;
                            
                          } else if($elKey > 0) {
                            $eligibilityTextArr[$tilEligibility->id] = $tilEligibility->special_eligibility;
                          }
                        }
                      }
                    @endphp
                    <div class="col-md-8">
                      <div class="input-group">
                        <input type="hidden" name="special_eligibility_clause[id][]" class="special_eligibility_id" value="{!! $eligibilityTextId !!}">

                        <input type="text" name="special_eligibility_clause[name][]" class="form-control special_eligibility_clause" placeholder="Please enter special eligibility clause." value="{!! $eligibilityText !!}">

                        <div id="add_special_eligibility" class="input-group-addon btn" onclick="add_eligibility_fields();">
                          <a href="javascript:void(0);" class="a-font-inherit">
                            <i class="fa fa-plus"></i>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div id="special_eligibility_div" class="special_eligibility_div m-t-sm">
                    @if(!empty($eligibilityTextArr) && count($eligibilityTextArr) > 0) 

                      @foreach($eligibilityTextArr as $eKey => $eligibility)
                        <div class="form-group">
                          <label class="control-label col-md-4">&nbsp;</label>
                          <div class="col-md-8">
                            <div class="input-group">
                              <input type="hidden" name="special_eligibility_clause[id][]" class="special_eligibility_id" value="{!! $eKey !!}">

                              <input type="text" name="special_eligibility_clause[name][]" class="form-control special_eligibility_clause" value="{!! $eligibility !!}">
                              <!-- onclick="remove_fields($(this));" -->
                              <div id="eligibility_action_div" class="input-group-addon btn remove_special_eligibility">
                                <a href="javascript:void(0);" class="a-font-inherit">
                                  <i class="fa fa-minus"></i>
                                </a>
                              </div>
                            </div>
                          </div>
                        </div>
                      @endforeach
                    @endif
                  </div>

                  <div class="form-group row">
                    <label for="technical_qualification" class="control-label col-md-4">Technical Qualification: <small class="text-danger">*</small></label>
                    @php
                      $qualificationText = null; $qualificationId = null;
                      $qualificationTextArr = [];
                      if(!empty($tilDraft->tilTechnicalQualification)) {
                        foreach ($tilDraft->tilTechnicalQualification as $elKey => $tilQualification) {
                          if($elKey == 0) {
                            $qualificationId = $tilQualification->id;
                            $qualificationText   = $tilQualification->technical_qualification;
                            
                          } else if($elKey > 0) {
                            $qualificationTextArr[$tilQualification->id] = $tilQualification->technical_qualification;
                          }
                        }
                      }
                    @endphp
                    <div class="col-md-8">
                      <div class="input-group">
                        <input type="hidden" name="technical_qualification[id][]" class="technical_qualification_id" value="{!! $qualificationId !!}">

                        <input type="text" name="technical_qualification[name][]" class="form-control technical_qualification" value="{!! $qualificationText !!}" required placeholder="Please enter technical qualification.">

                        <div id="add_technical_qualification" class="input-group-addon btn" onclick="add_technical_qualification_fields();">
                          <a href="javascript:void(0);" class="a-font-inherit">
                            <i class="fa fa-plus"></i>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div id="technical_qualification_div" class="technical_qualification_div m-t-sm">
                    @if(!empty($qualificationTextArr) && count($qualificationTextArr) > 0) 

                      @foreach($qualificationTextArr as $eKey => $qualification)
                        <div class="form-group">
                          <label class="control-label col-md-4"><small class="text-danger">*</small></label>
                          <div class="col-md-8">
                            <div class="input-group">
                              <input type="hidden" name="technical_qualification[id][]" class="technical_qualification_id" value="{!! $eKey !!}">

                              <input type="text" name="technical_qualification[name][]" class="form-control technical_qualification" value="{!! $qualification !!}" required placeholder="Please enter technical qualification.">

                              <div id="qualification_action_div" class="input-group-addon btn remove_technical_qualification">
                                <a href="javascript:void(0);" class="a-font-inherit">
                                  <i class="fa fa-minus"></i>
                                </a>
                              </div>
                            </div>
                          </div>
                        </div>
                      @endforeach
                    @endif
                  </div>
                                    
                  <div class="form-group row">
                    <label for="emd" class="control-label col-md-4">EMD:</label>
                    <div class="col-md-8">
                      <select class="form-control emd select2" name="emd[]" id="emd" multiple>
                        @if(!empty($emdOptions) && count($emdOptions) > 0)
                          @php
                            $tilEmd = explode(',', $tilDraft->emd);
                          @endphp
                          @foreach($emdOptions as $emdKey => $emdOption)
                            @php
                              $selectedEmd = null;
                              if(!empty($tilEmd) && in_array($emdKey, $tilEmd)) {
                                $selectedEmd = 'selected';
                              }
                            @endphp
                            <option value="{!! $emdKey !!}" {!! $selectedEmd !!}>{!! $emdOption !!}</option>
                          @endforeach
                        @endif
                      </select>
                    </div>
                  </div>
                  @php
                    $emdAmountHide = 'hide';
                    if(!empty($tilDraft->emd_amount) && !in_array(8, explode(',', $tilDraft->emd)) && !in_array(9, explode(',', $tilDraft->emd))) {
                      $emdAmountHide = null;
                    }
                  @endphp
                  <div class="form-group row {{$emdAmountHide}} emd_amount_div">
                    <label for="emd_amount" class="control-label col-sm-4">EMD Amount:</label>
                    <div class="col-md-8">
                      @php
                        $emdAmount = (!empty($tilDraft->emd_amount))? $tilDraft->emd_amount : 0;
                      @endphp
                      <input type="number" name="emd_amount" id="emd_amount" class="form-control emd_amount" value="{!! $emdAmount !!}">
                    </div>
                  </div>
                  @php
                    $emdExemptedHide = 'hide';
                    if(!empty($tilDraft->emd_exempted) && in_array(8, explode(',', $tilDraft->emd))) {
                      $emdExemptedHide = null;
                    }
                  @endphp
                  <div class="form-group row {{$emdExemptedHide}} emd_exempted_div">
                    <label for="emd_exempted" class="control-label col-sm-4">EMD Exempted:</label>
                    <div class="col-md-8">
                      @php
                        $emdExempted = (!empty($tilDraft->emd_exempted))? $tilDraft->emd_exempted : null;
                      @endphp
                      <textarea name="emd_exempted" class="form-control emd_exempted" rows="2" cols="50" placeholder="Please enter exempted clause">{!! $emdExempted !!}</textarea>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="emd_special_clause" class="control-label col-md-4">EMD Special Clause: <small class="text-danger">*</small></label>
                    <div class="col-md-8">
                      <textarea name="emd_special_clause" class="form-control emd_special_clause resize-none" rows="2" cols="50" required placeholder="Please enter emd special clause">{!! $tilDraft->emd_special_clause !!}</textarea>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="processing_fee" class="control-label col-md-4">Processing Fee:</label>
                    <div class="col-md-8">
                      <select class="form-control processing_fee select2" name="processing_fee[]" id="processing_fee" multiple>
                        @if(!empty($processingFeeOptions) && count($processingFeeOptions) > 0)
                          @php
                            $tilProcessingFee = explode(',', $tilDraft->processing_fee);
                          @endphp
                          @foreach($processingFeeOptions as $processingFeeKey => $processingFeeOption)
                            @php
                              $selectedProcessingFee = null;
                              if(!empty($tilProcessingFee) && in_array($processingFeeKey, $tilProcessingFee)) {
                                $selectedProcessingFee = 'selected';
                              }
                            @endphp
                            <option value="{!! $processingFeeKey !!}" {!! $selectedProcessingFee !!}>{!! $processingFeeOption !!}</option>
                          @endforeach
                        @endif
                      </select>
                    </div>
                  </div>
                  @php
                    $processingFeeAmountHide = 'hide';
                    if(!empty($tilDraft->processing_fee_amount) && !in_array(8, explode(',', $tilDraft->processing_fee)) && !in_array(9, explode(',', $tilDraft->processing_fee))) {
                      $processingFeeAmountHide = null;
                    }
                  @endphp
                  <div class="form-group row {{$processingFeeAmountHide}} processing_fee_amount_div">
                    <label for="processing_fee_amount" class="control-label col-sm-4">Processing Fee Amount:</label>
                    <div class="col-md-8">
                      @php
                        $processingFeeAmount = (!empty($tilDraft->processing_fee_amount))? $tilDraft->processing_fee_amount : 0;
                      @endphp
                      <input type="number" name="processing_fee_amount" id="processing_fee_amount" class="form-control processing_fee_amount" value="{!! $processingFeeAmount !!}">
                    </div>
                  </div>
                  @php
                    $processingFeeExemptedHide = 'hide';
                    if(!empty($tilDraft->processing_fee_exempted) && in_array(8, explode(',', $tilDraft->processing_fee))) {
                      $processingFeeExemptedHide = null;
                    }
                  @endphp
                  <div class="form-group row {{$processingFeeExemptedHide}} processing_fee_exempted_div">
                    <label for="processing_fee_exempted" class="control-label col-sm-4">Processing Fee Exempted:</label>
                    <div class="col-md-8">
                      @php
                        $processingFeeExempted = (!empty($tilDraft->processing_fee_exempted))? $tilDraft->processing_fee_exempted : null;
                      @endphp
                      <textarea name="processing_fee_exempted" class="form-control processing_fee_exempted" rows="2" cols="50" placeholder="Please enter exempted clause">{!! $processingFeeExempted !!}</textarea>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="pre_bid_meeting" class="control-label col-md-4">Pre Bid Meeting:</label>
                    <div class="col-md-8">
                      <input type="text" name="pre_bid_meeting" id="pre_bid_meeting" class="form-control pre_bid_meeting future_date_time" placeholder="Please Enter Pre Bid Meeting." value="{!! date('m/d/Y H:i', strtotime($tilDraft->pre_bid_meeting)) !!}">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="pre_bid_clause" class="control-label col-md-4">Pre Bid Clause: <small class="text-danger">*</small></label>
                    <div class="col-md-8">
                      <textarea name="pre_bid_clause" class="form-control pre_bid_clause resize-none" rows="2" cols="50" required placeholder="Please enter pre bid clause">{!! $tilDraft->pre_bid_clause !!}</textarea>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="financial_bid_type" class="control-label col-md-4">Financial Bid Type: <small class="text-danger">*</small></label>
                    <div class="col-md-8">
                      <textarea name="financial_bid_type" class="form-control financial_bid_type resize-none" rows="2" cols="50" required placeholder="Please enter financial bid type">{!! $tilDraft->financial_bid_type !!}</textarea>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="obligations" class="control-label col-md-4">Obligations:</label>
                    <div class="col-md-8">
                      <select id="obligations" class="form-control obligations" name="obligations">
                        <!-- <option value="">Please select Obligation Type</option> -->
                        @if(!empty($obligationOptions) && count($obligationOptions) > 0)
                          @foreach($obligationOptions as $obligationKey => $obligationOption)
                            @php
                              $selectedObligation = ($tilDraft->obligation_id == $obligationKey)? 'selected' : null;
                            @endphp
                            <option value="{!! $obligationKey !!}" {!! $selectedObligation !!}>{!! $obligationOption !!}</option>
                          @endforeach
                        @endif
                      </select>

                      <div id="obligation_field" class="obligation_field @if(empty($tilDraft->obligation_id)) hide @endif m-t-sm">
                        @php
                          $obligationText = null; $obligationTextId= null;
                          $obligationTextArr = [];
                          if(!empty($tilDraft->tilObligation)) {
                            foreach ($tilDraft->tilObligation as $obKey => $tilObligation) {
                              if($obKey == 0) {
                                $obligationText   = $tilObligation->obligation;
                                $obligationTextId = $tilObligation->id;
                                
                                $obligationTextId = $tilObligation->id;
                              } else if($obKey > 0) {
                                $obligationTextArr[$tilObligation->id] = $tilObligation->obligation;
                              }
                            }
                          }
                        @endphp

                        <div class="form-group">
                          <div class="col-md-12">
                            <div class="input-group">
                              <input type="hidden" name="obligation_text[id][]" class="obligation_id" value="{!! $obligationTextId !!}">
                              <input type="text" id="obligation_text" name="obligation_text[name][]" class="form-control obligation_text" value="{!! $obligationText !!}" data-obligation_id="{!! $obligationTextId !!}">

                              <div id="add_other_field" class="input-group-addon btn" onclick="add_fields();">
                                <a href="javascript:void(0);" class="a-font-inherit">
                                  <i class="fa fa-plus"></i>
                                </a>
                              </div>                            
                            </div>
                          </div>
                        </div>

                        @if(!empty($obligationTextArr) && count($obligationTextArr) > 0) 
                          @foreach($obligationTextArr as $oKey => $obligation)
                            <div class="form-group">
                              <div class="col-md-12">
                                <div class="input-group">
                                  <input type="hidden" name="obligation_text[id][]" class="obligation_id" value="{!! $oKey !!}">
                                  <input type="text" id="obligation_text" name="obligation_text[name][]" class="form-control obligation_text" value="{!! $obligation !!}">
                                  <!--  onclick="remove_fields($(this));" -->
                                  <div id="obligation_action_div" class="input-group-addon btn remove_obligation_field" data-obligation_id="{!! $oKey !!}">
                                    <a href="javascript:void(0);" class="a-font-inherit">
                                      <i class="fa fa-minus"></i>
                                    </a>
                                  </div>
                                </div>
                              </div>
                            </div>
                          @endforeach
                        @endif
                      </div>
                    </div>
                  </div>

                  <!--@ if(auth()->user()->can('leads-management.view-cost-estimation')) -->
                    <div class="form-group row hide">
                      <label for="total_investments" class="control-label col-md-4">Total Investments:</label>
                      <div class="col-md-8">
                        <input type="number" name="total_investments" id="total_investments" class="form-control total_investments" value="{!! numberFormat($tilDraft->total_investments) !!}" min="0" readonly>
                      </div>
                    </div>
                    
                  <!-- <div class="form-group row">
                      <label for="total_investments" class="control-label col-md-4">&nbsp;</label>
                      <div class="col-md-8">
                        @ if(!empty($tilDraft->costEstimationDraft))
                          @ php 
                            $getJsonData = json_decode($tilDraft->costEstimationDraft->estimation_data);
                              $noOfPost  = count($getJsonData->project_scope->resource_name);

                            $costEstimationUrl = 'leads-management/cost-estimation/'.$tilDraft->id.'?key='.encrypt($noOfPost);
                            
                            if($tilDraft->costEstimationDraft->is_complete == 1) {
                              $costEstimationUrl = 'leads-management/view-cost-estimation/'.$tilDraft->id;
                            }

                          @ endphp

                          <a href="{ !! url($costEstimationUrl) !!}" id="cost-estimation" class="pull-left" target="_blank"> Cost Estimation Sheet </a>
                        @ else
                          <a href="#" id="cost-estimation" class="pull-left" data-toggle="modal" data-target="#cost-estimation-modal"> Cost Estimation Sheet </a>
                        @ endif

                        <a href="javascript:void(0)" id="get-cost-estimation" class="btn btn-success btn-xs pull-right">
                          <i class="fa fa-refresh"></i>
                        </a>
                      </div>
                    </div>
                  @ endif-->

                  <div class="form-group row">
                    <label for="technical_opening_date" class="control-label no-padding col-sm-4 p-t-sm">Technical Opening Date:</label>
                    <div class="col-md-8">
                      @php
                        $technicalDate = null;
                        if(!empty($tilDraft->technical_opening_date)) {
                          $technicalDate = date('m/d/Y H:i', strtotime($tilDraft->technical_opening_date));
                        }
                      @endphp
                      <input type="text" name="technical_opening_date" id="technical_opening_date" class="form-control technical_opening_date future_date_time" placeholder="Please Select Technical Opening Date" value="{!! $technicalDate !!}">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="financial_opening_date" class="control-label col-md-4">Financial Opening Date:</label>
                    <div class="col-md-8">
                      @php
                        $financialDate = null;
                        if(!empty($tilDraft->financial_opening_date)) {
                          $financialDate = date('m/d/Y H:i', strtotime($tilDraft->financial_opening_date));
                        }                        
                      @endphp
                      <input type="text" name="financial_opening_date" id="financial_opening_date" class="form-control financial_opening_date future_date_time" placeholder="Please Select Financial Opening Date." value="{!! $financialDate !!}">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="technical_criteria" class="control-label col-md-4">Technical Criteria:</label>
                    <div class="col-md-8">
                      @php
                        $technicalCriteria = null;
                        if(!empty($tilDraft->technical_criteria)) {
                          $technicalCriteria = $tilDraft->technical_criteria;
                        }                        
                      @endphp

                      <input type="text" name="technical_criteria" id="technical_criteria" class="form-control technical_criteria" value="{!! $technicalCriteria !!}" placeholder="Please Enter Technical Criteria.">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="financial_criteria" class="control-label col-md-4">Financial Criteria:</label>
                    <div class="col-md-8">
                      @php
                        $financialCriteria = null;
                        if(!empty($tilDraft->financial_criteria)) {
                          $financialCriteria = $tilDraft->financial_criteria;
                        }                        
                      @endphp

                      <input type="text" name="financial_criteria" id="financial_criteria" class="form-control financial_criteria" value="{!! $financialCriteria !!}" placeholder="Please Enter Financial Criteria.">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="award_criteria" class="control-label col-md-4">Award Criteria:</label>
                    <div class="col-md-8">
                      @php
                        $awardCriteria = null;
                        if(!empty($tilDraft->award_criteria)) {
                          $awardCriteria = $tilDraft->award_criteria;
                        }                        
                      @endphp

                      <input type="text" name="award_criteria" id="award_criteria" class="form-control award_criteria" value="{!! $awardCriteria !!}" placeholder="Please Enter Award Criteria.">
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

              <button type="submit" class="btn btn-warning form-draft-btn" id="save_as_draft">Save As Draft</button>
              <button type="submit" class="btn btn-success form-save-btn" id="save">Final Submit</button>
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
                            @if(!empty($tilDraft->tilContact) && count($tilDraft->tilContact) > 0)
                              @foreach($tilDraft->tilContact as $cKey => $contact)
                                <tr>
                                  <td>
                                    <input type="text" name="til_contact[name][]" class="form-control contact_name" placeholder="Contact Name" value="{!! $contact->name !!}" required/>
                                    <input type="hidden" name="til_contact[id][]" value="{!! $contact->id !!}"/>
                                  </td>
                                  <td>
                                    <input type="text" name="til_contact[designation][]" class="form-control contact_designation" placeholder="Designation" value="{!! $contact->designation !!}" required/>
                                  </td>
                                  <td>
                                    <input type="text" name="til_contact[phone][]" class="form-control contact_phone" placeholder="Mobile Number" value="{!! $contact->phone !!}"/>
                                  </td>
                                  <td>
                                    <input type="text" name="til_contact[email][]" class="form-control contact_email" placeholder="Email" value="{!! $contact->email !!}"/>
                                  </td>
                                  <td>
                                    <textarea name="til_contact[description][]" id="contact_description[]" class="form-control contact_description resize-none" rows="2" cols="30" required placeholder="Enter description">{!! $contact->description !!}</textarea>
                                  </td>
                                  <td>
                                    @if($cKey == 0)
                                      <a href="javascript:void(0);" class="btn btn-primary btn-xs til_contact_add_more">
                                        <i class="fa fa-plus"></i>
                                      </a>
                                    @else 
                                      <!--  onclick="remove_fields($(this));" -->
                                      <a href="javascript:void(0);" class="btn btn-danger btn-xs til_contacts_remove" data-contact_id="{!! $contact->id !!}" data-til_draft_id="{!! $contact->til_draft_id !!}">
                                       <i class="fa fa-times"></i>
                                      </a>
                                    @endif
                                  </td>
                                </tr>                      
                              @endforeach
                              @else
                                <tr>
                                  <td>
                                    <input type="text" name="til_contact[name][]" class="form-control contact_name" placeholder="Contact Name" value="" required/>
                                  </td>
                                  <td>
                                    <input type="text" name="til_contact[designation][]" class="form-control contact_designation" placeholder="Designation" value="" required/>
                                  </td>
                                  <td>
                                    <input type="text" name="til_contact[phone][]" class="form-control contact_phone" placeholder="Mobile Number" value=""/>
                                  </td>
                                  <td>
                                    <input type="text" name="til_contact[email][]" class="form-control contact_email" placeholder="Email" value=""/>
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
<div class="modal fade bs-example-modal-sm" id="cost-estimation-modal" tabindex="-1">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        <h4 class="modal-title" id="mySmallModalLabel">Cost Estimation Details</h4>
      </div>
      <div class="modal-body">
        <form id="estimation_form" action="{!! route('leads-management.estimation', $tilDraft->id) !!}" method="GET" target="_blank" enctype="application/x-www-form-urlencoded" class="form-vertical">
          <div class="col-md-12">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="no_of_posts" class="control-label col-md-4">No of Posts.</label>
                  <div class="col-md-8">
                    <input type="number" name="no_of_posts" id="no_of_posts" class="form-control no_of_posts" placeholder="Number of Posts" value="1" min="1" required/>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="clearfix"></div>
        </form>        
      </div>
      <div class="modal-footer">
        <div class="col-md-12">
          <button type="button" class="btn btn-success estimation_form_btn" aria-label="Close">Ok</button>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- bootstrap time picker -->
<!-- <script src="{ {asset('public/admin_assets/plugins/timepicker/bootstrap-timepicker.min.js')}}"></script> -->
<script src="{!! asset('public/admin_assets/plugins/validations/jquery.validate.js') !!}"></script>
<script src="{!! asset('public/admin_assets/plugins/validations/additional-methods.js') !!}"></script>
<script src="{!! asset('public/admin_assets/plugins/jquery-toast/jquery.toast.min.js') !!}"></script>
<script src="{!! asset('public/admin_assets/plugins/sweetalert/sweetalert.min.js') !!}"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript">

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
        technical_opening_date: { date: true, dateLessThan: '#financial_opening_date' },
        financial_opening_date: { date: true, dateGreaterThan: '#technical_opening_date' },
        volume: { number: true },
        gross_turnover_monthly: { number: true },
        gross_turnover_yearly: { number: true },
        emd_amount_c: { number: true },
        tender_fee_amount_c: { number: true },
      }
    });

    $('#estimation_form').validate({
      ignore: ':hidden,input[type=hidden],.select2-search__field',
      errorElement: 'span',
      errorPlacement: function(error, element) {
        error.appendTo(element.parent());
      },
      rules: {
        no_of_posts: { required: true, digits: true},      
      }
    });

    $(document).on('click', '.get-comments', function(event) {
      event.preventDefault();  event.stopPropagation();
      getComments($(this));
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

    $(document).on('click', 'input[name="performance_guarantee_type"]', function() {
      var _value =  $(this).val();

      if(_value == 2) {
        $('input#performance_guarantee').attr('max', 100);
      } else {
        $('input#performance_guarantee').removeAttr('max');
      }
    });

    /*save_as_draft, save*/
    $(document).on('click', '.form-save-btn', function(event) {
      event.preventDefault(); event.stopPropagation();
      
      $('#comments').attr('required', true);

      if($('#create_til_form').valid()) {
        saveTilForm();
      } else {
        validator.focusInvalid();
      }
    });

    $(document).on('click', '.form-draft-btn', function(event) {

      $('#comments').removeAttr('required');
      $('#submit_type').val('save_as_draft');
    });

    $(document).on('click', '.til_contact_add_more', function(event) {
      
      if($('#create_til_form #til_contact_form input[required], #create_til_form #til_contact_form textarea.contact_description').valid()) {

        var tbody_html = '<tr>'+
                          '<td>'+
                            '<input type="text" name="til_contact[name][]" class="form-control contact_name" placeholder="Contact Name" value="" required/>'+
                          '</td>'+
                          '<td>'+
                            '<input type="text" name="til_contact[designation][]" class="form-control contact_designation" placeholder="Designation" value="" required/>'+
                          '</td>'+
                          '<td>'+
                            '<input type="text" name="til_contact[phone][]" class="form-control contact_phone" placeholder="Mobile Number" value=""/>'+
                          '</td>'+
                          '<td>'+
                            '<input type="text" name="til_contact[email][]" class="form-control contact_email" placeholder="Email" value=""/>'+
                          '</td>'+
                          '<td>'+
                            '<textarea name="til_contact[description][]" id="contact_description[]" class="form-control contact_description resize-none" rows="2" cols="30" required placeholder="Enter description"></textarea>'+
                          '</td>'+
                          '<td>'+
                            // <!--  onclick="remove_fields($(this));" -->
                            '<a href="javascript:void(0);" class="btn btn-danger btn-xs til_contacts_remove">'+
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

    var tilCreateDate = '{!! $tilDraft->created_at->format('m/d/Y') !!}';
    $(".future_date_time").datetimepicker({
      minDate : new Date(tilCreateDate),
      format: 'MM/DD/Y hh:mm',
    });

    $(".future_date").datepicker({
      format:'m/d/yyyy',
      todayHighlight:true,
      todayBtn:'linked',
      startDate: new Date(tilCreateDate),
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

    $(document).on('click', '.til_contacts_remove', function(event) {
      deleteContact($(this));
    });

    $(document).on('click', '.remove_special_eligibility', function(event) {
      deleteSpecialEligibility($(this));
    });

    $(document).on('click', '.remove_technical_qualification', function(event) {
      deleteTechnicalQualification($(this));
    });

    $(document).on('click', '.remove_penalties', function(event) {
      deleteTilPenalties($(this));
    });

    $(document).on('click', '.remove_obligation_field', function(event) {
      deleteObligation($(this));
    });

    $(document).on('click', '.estimation_form_btn', function(event) {
      if($('#estimation_form input').valid()) {
        $('#estimation_form').submit();
        $('#cost-estimation-modal').modal('hide');
      }
    });

    $(document).on('click', '#get-cost-estimation', function(event) {

      $.ajax({
        url: '{!! route('leads-management.get-estimation', $tilDraft->id) !!}',
        type: "POST",
        beforeSend: function() {
          // setting a timeout
          $('div.loading').removeClass('hide');          
        },
        success: function (res) {
          var totalInvestment = 0;

          if(res.status == 1) {
            var data        = JSON.parse(res.data.estimation_data);
            // totalInvestment = Number(data.total_capital_expense) + Number(data.total_operational_expense);
            totalInvestment = Number(data.total_expense).toFixed(2);
            
          } else {
            swal("Error:", res.msg, "error");
          }

          $('input#total_investments').val(totalInvestment);
          $('div.loading').addClass('hide');
        },
        error: function (xhr, ajaxOptions, thrownError) {
          var xhrRes = xhr.responseJSON;

          if(xhrRes.status == 401) {
            swal("Error Code: " + xhrRes.status, xhrRes.msg, "error");
          } else {
            swal("Error updating expense!", "Please try again", "error");
          }

          $('div.loading').addClass('hide');
        }
      });  
    });

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
                              '<input type="text" id="obligation_text" name="obligation_text[name][]" class="form-control obligation_text" placeholder="Please enter obligation text.">'+
                              '<div id="obligation_action_div" class="input-group-addon btn remove_obligation_field">'+
                                '<a href="javascript:void(0);" class="a-font-inherit">'+
                                  '<i class="fa fa-minus"></i>'+
                                '</a>'+
                              '</div>'+
                            '</div>'+
                          '</div>'+
                        '</div>';

    $('#obligation_field').append(html_to_append);
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
                              '<input type="text" name="special_eligibility_clause[name][]" class="form-control special_eligibility_clause" placeholder="Please enter special eligibility clause.">'+
                              '<div id="eligibility_action_div" class="input-group-addon btn remove_special_eligibility">'+
                                '<a href="javascript:void(0);" class="a-font-inherit">'+
                                  '<i class="fa fa-minus"></i>'+
                                '</a>'+
                              '</div>'+
                            '</div>'+
                          '</div>'+
                        '</div>';
    
    $('#special_eligibility_div').append(html_to_append);
    $('.special_eligibility_div').removeClass('hide');
  }

  function deleteContact(obj) 
  {
    if(typeof $(obj).data('contact_id') != 'undefined' && typeof $(obj).data('til_draft_id') != 'undefined') 
    {
      var contact_id   = $(obj).data('contact_id');
      var til_draft_id = $(obj).data('til_draft_id');
      var _token       = '{!! csrf_token() !!}';

      var objdata = { '_token': _token, 'contact_id': contact_id, 'til_draft_id': til_draft_id };

      swal({
        title: "Are you sure?",
        text: "You want to delete this contact, you will not be able to recover this record!",
        icon: "warning",
        buttons: [
          'No, cancel it!',
          'Yes, I am sure!'
        ],
        dangerMode: true,
      }).then(function(isConfirm) {
        if (isConfirm) {
          $.ajax({
            url: "{!! route('leads-management.delete-contact') !!}",
            type: "POST",
            data: objdata,
            dataType: 'json',
            success: function (res) {

              if(res.status == 1) {
                swal("Done!", res.msg, "success");

                remove_fields(obj);
              } else {
                swal("Error:", res.msg, "error");
              } 
            },
            error: function (xhr, ajaxOptions, thrownError) {
              var xhrRes = xhr.responseJSON;

              if(typeof xhrRes != 'undefined' && xhrRes.status == 401) {
                swal("Error Code: " + xhrRes.status, xhrRes.msg, "error");
              } else {
                swal("Error deleting!", "Please try again", "error");
              }
            }
          });
        }
      });
    } else {
      remove_fields(obj);
    }
  }

  function deleteSpecialEligibility(obj) 
  {
    var eligibilityId = $(obj).parent().find('.special_eligibility_id').val();
    
    if(typeof eligibilityId != 'undefined') 
    {
      var _token  = '{!! csrf_token() !!}';
      var objdata = { '_token': _token, 'eligibility_id': eligibilityId };

      swal({
        title: "Are you sure?",
        text: "You want to delete this special eligibility, you will not be able to recover this record!",
        icon: "warning",
        buttons: [
          'No, cancel it!',
          'Yes, I am sure!'
        ],
        dangerMode: true,
      }).then(function(isConfirm) {
        if (isConfirm) {
          $.ajax({
            url: "{!! route('leads-management.delete-eligibility') !!}",
            type: "POST",
            data: objdata,
            dataType: 'json',
            success: function (res) {

              if(res.status == 1) {
                swal("Done!", res.msg, "success");

                remove_fields(obj);
              } else {
                swal("Error:", res.msg, "error");
              } 
            },
            error: function (xhr, ajaxOptions, thrownError) {
              var xhrRes = xhr.responseJSON;

              if(typeof xhrRes != 'undefined' && xhrRes.status == 401) {
                swal("Error Code: " + xhrRes.status, xhrRes.msg, "error");
              } else {
                swal("Error deleting!", "Please try again", "error");
              }
            }
          });
        }
      });
    } else {
      remove_fields(obj);
    }
  }

  function deleteTechnicalQualification(obj) 
  {
    var technical_qualification_id = $(obj).parent().find('.technical_qualification_id').val();
    
    if(typeof technical_qualification_id != 'undefined') 
    {
      var _token  = '{!! csrf_token() !!}';
      var objdata = { '_token': _token, 'technical_qualification_id': technical_qualification_id };

      swal({
        title: "Are you sure?",
        text: "You want to delete this technical qualification, you will not be able to recover this record!",
        icon: "warning",
        buttons: [
          'No, cancel it!',
          'Yes, I am sure!'
        ],
        dangerMode: true,
      }).then(function(isConfirm) {
        if (isConfirm) {
          $.ajax({
            url: "{!! route('leads-management.delete-technical-qualification') !!}",
            type: "POST",
            data: objdata,
            dataType: 'json',
            success: function (res) {

              if(res.status == 1) {
                swal("Done!", res.msg, "success");

                remove_fields(obj);
              } else {
                swal("Error:", res.msg, "error");
              } 
            },
            error: function (xhr, ajaxOptions, thrownError) {
              var xhrRes = xhr.responseJSON;

              if(typeof xhrRes != 'undefined' && xhrRes.status == 401) {
                swal("Error Code: " + xhrRes.status, xhrRes.msg, "error");
              } else {
                swal("Error deleting!", "Please try again", "error");
              }
            }
          });
        }
      });
    } else {
      remove_fields(obj);
    }
  }


  function deleteTilPenalties(obj) 
  {
    var penalties_id = $(obj).parent().find('.penalties_id').val();
    
    if(typeof penalties_id != 'undefined') 
    {
      var _token  = '{!! csrf_token() !!}';
      var objdata = { '_token': _token, 'penalties_id': penalties_id };

      swal({
        title: "Are you sure?",
        text: "You want to delete this penalties, you will not be able to recover this record!",
        icon: "warning",
        buttons: [
          'No, cancel it!',
          'Yes, I am sure!'
        ],
        dangerMode: true,
      }).then(function(isConfirm) {
        if (isConfirm) {
          $.ajax({
            url: "{!! route('leads-management.delete-til-penalties') !!}",
            type: "POST",
            data: objdata,
            dataType: 'json',
            success: function (res) {

              if(res.status == 1) {
                swal("Done!", res.msg, "success");

                remove_fields(obj);
              } else {
                swal("Error:", res.msg, "error");
              } 
            },
            error: function (xhr, ajaxOptions, thrownError) {
              var xhrRes = xhr.responseJSON;

              if(typeof xhrRes != 'undefined' && xhrRes.status == 401) {
                swal("Error Code: " + xhrRes.status, xhrRes.msg, "error");
              } else {
                swal("Error deleting!", "Please try again", "error");
              }
            }
          });
        }
      });
    } else {
      remove_fields(obj);
    }
  }

  function deleteObligation(obj) 
  {
    var obligationId = $(obj).parent().find('.obligation_id').val();
    
    if(typeof obligationId != 'undefined') 
    {
      var _token  = '{!! csrf_token() !!}';
      var objdata = { '_token': _token, 'obligation_id': obligationId };

      swal({
        title: "Are you sure?",
        text: "You want to delete this obligation, you will not be able to recover this record!",
        icon: "warning",
        buttons: [
          'No, cancel it!',
          'Yes, I am sure!'
        ],
        dangerMode: true,
      }).then(function(isConfirm) {
        if (isConfirm) {
          $.ajax({
            url: "{!! route('leads-management.delete-obligation') !!}",
            type: "POST",
            data: objdata,
            dataType: 'json',
            success: function (res) {

              if(res.status == 1) {
                swal("Done!", res.msg, "success");

                remove_fields(obj);
              } else {
                swal("Error:", res.msg, "error");
              } 
            },
            error: function (xhr, ajaxOptions, thrownError) {
              var xhrRes = xhr.responseJSON;

              if(typeof xhrRes != 'undefined' && xhrRes.status == 401) {
                swal("Error Code: " + xhrRes.status, xhrRes.msg, "error");
              } else {
                swal("Error deleting!", "Please try again", "error");
              }
            }
          });
        }
      });
    } else {
      remove_fields(obj);
    }
  }

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

  function saveTilForm() 
  {
    swal({
      title: "Are you sure?",
      text: "You want to save this record, you will not be able to edit this.",
      icon: "info",
      buttons: {
        cancel: {
          text: "Cancel",
          value: null,
          visible: true,
          className: "btn btn-default",
          closeModal: true,
        },
        confirm: {
          text: "Yes",
          value: true,
          visible: true,
          className: "btn btn-success",
          closeModal: true
        }
      },
    }).then(function(isConfirm) {
      if (isConfirm) {
        $('#submit_type').val('save');
        $('#create_til_form').submit();
      } else {
        $('#submit_type').val('');
      }
    });
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
                              '<input type="text" name="penalties[name][]" id="penalties" class="form-control penalties" placeholder="Please enter penalties.">'+
                              '<div id="penalties_action_div" class="input-group-addon btn remove_penalties">'+
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
                              '<input type="text" name="technical_qualification[name][]" id="technical_qualification" class="form-control technical_qualification" placeholder="Please enter technical qualification.">'+
                              '<div id="qualification_action_div" class="input-group-addon btn remove_technical_qualification">'+
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