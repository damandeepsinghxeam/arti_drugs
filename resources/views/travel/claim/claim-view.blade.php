@extends('admins.layouts.app')

@section('content')

<style type="text/css">
  /*Css changes on 12 August, 2019*/
  .travel-input2 {
    width: 105px;    
  }
  .travel-input3 {
    width: 300px;
  }
  .travel-input4 {
    width: 45px;
  }
  .travel-input5 {
    width: 60px;
  }
  .travel-input6 {
    width: 115px;
  }
  h2.travel-expense-title2 {
    font-size: 20px;
    padding: 0 10px;
  }
  .travel-box-border {
    border: 1px solid lightgrey;
    margin: 10px;
    padding: 10px 0;
    border-radius: 8px;
  }
  h3.travel-expense-title3 {
    font-size: 15px;
    font-weight: 600;
    margin: 0px 0 5px 0;
    text-align: center;
    color: white;
    background-color: #00728e;
    padding: 5px 0;
  }
  .remove-travel-left6 {
    padding-left: 0px;
  }
  .travel-table-input-style {
    border-radius: 4px;
    box-shadow: 0px 1px 2px lightgrey;
  }
  .travel-only-inputss {
    font-size: 12px;
    padding: 5px 5px !important;
    height: 30px;
  }
  .travel-table-inner>tbody>tr>td {
    padding: 5px !important;
  }
  i.fa.fa-plus.addtravel-row {
    background-color: #00728e;
    color: white;
    padding: 7px 9px;
    border-radius: 50%;
  }
  i.fa.fa-minus.remtravel-row {
    background-color: #00728e;
    color: white;
    padding: 7px 9px;
    border-radius: 50%;
  }
  .add-remark-textarea {
    width: 100%;
    min-height: 100px;
    padding: 5px;
  }
  input.chooseAttachment-travel {
    position: relative;
    top: 4px;
  }
  .footer-travel {
    margin-left: 0px;
  }
  input.travel-check1 {
    position: relative;
    top: 5px;
  }
  .attendance-tds {
    height: 110px;
  }
  .travel-bottom-btns {
    display: flex;
    justify-content: center;
    margin: 20px 0;
  }
  a.travel-btn-style {
    padding: 10px 10px;
    margin: 0 5px;
    border-radius: 7px;
    border: 1px solid #00728e;
    color: #00728e;
    transition: all ease 0.2s;
  }
  a.travel-btn-style:hover {
    background-color: #00728e;
    color: white;
  }
  .utr-outerbox {
    padding: 20px;
    border: 1px solid lightgrey;
    border-top: 3px solid #00728e;
  }
  input.utrNumber {
    width: 100%;
  }
  label.utr-label {
    margin-bottom: 0px;
  }
</style>

<link href="{{asset('public/admin_assets/plugins/dataTables/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{asset('public/admin_assets/plugins/jquery-toast/jquery.toast.min.css')}}" rel="stylesheet">
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>View Travel Claim</h1>
    <ol class="breadcrumb">
      <li><a href="{{ url('employees/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="callout callout-danger apply-lv-alert">
      <strong>Note: </strong> 
      <em>Physical/Original copies must be submitted to accounts within two weeks.</em>
    </div>
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary">
          @include('admins.validation_errors')
          <h2 class="travel-expense-title2">
            <legend>Claim Details -: {{ $claims->claim_code }}</legend>
          </h2>
          <h4 class="p-w-xs">
            <small>
              <a href="{{url('travel/approval-request-details/'.encrypt($approval->id))}}" class="btn btn-success btn-xs">View Approval Details</a>
            </small>

            @if($claims->user_id == auth()->user()->id && $claims->status == 'back')
              <small>
                <a href="{{url('travel/claim-form-edit/'.encrypt($claims->id))}}" class="btn btn-xs btn-danger">
                  Update Claim Form
                </a>
              </small>
            @endif

            <small>
              <a href="{{url('travel/print-claim/'.encrypt($claims->id))}}" class="btn btn-xs btn-primary" target="_blank">
                Print Claim
              </a>
            </small>
          </h4>

          <div class="row travel-box-border">
            <div class="col-md-8">
              <h3 class="travel-expense-title3">Basic Details</h3>
              <div class="col-md-6 remove-travel-left6">
                
                <div class="row">
                  <div class="col-md-5 col-sm-5 col-xs-5">
                    <label for="">Name</label>
                  </div>
                  <div class="col-md-7 col-sm-7 col-xs-7">
                    <label>{{$approval->user->employee->salutation}}{{$approval->user->employee->fullname}}</label>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-5 col-sm-5 col-xs-5">
                    <label for="">Employee Code</label>
                  </div>
                  <div class="col-md-7 col-sm-7 col-xs-7">
                    <label>{{$approval->user->employee_code}}</label>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-5 col-sm-5 col-xs-5">
                    <label for="">Designation</label>
                  </div>
                  <div class="col-md-7 col-sm-7 col-xs-7">
                    <label>{{$approval->user->designation[0]->name}}</label>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-5 col-sm-5 col-xs-5">
                    <label for="">Bank Name</label>
                  </div>
                  <div class="col-md-7 col-sm-7 col-xs-7">
                    <label>{{$approval->user->employeeAccount->bank->name}}</label>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-5 col-sm-5 col-xs-5">
                    <label for="">Account No</label>
                  </div>
                  <div class="col-md-7 col-sm-7 col-xs-7">
                    <label>{{$approval->user->employeeAccount->bank_account_number}}</label>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-5 col-sm-5 col-xs-5">
                    <label for="">IFSC CODE</label>
                  </div>
                  <div class="col-md-7 col-sm-7 col-xs-7">
                    <label>{{$approval->user->employeeAccount->ifsc_code}}</label>
                  </div>
                </div>
              </div>

              <div class="col-md-6 remove-travel-left6">
                <div class="row">
                  <div class="col-md-5 col-sm-5 col-xs-5">
                    <label for="">Travel Category</label>
                  </div>
                  <div class="col-md-7 col-sm-7 col-xs-7">
                    <label>{{ $approval->travel_category->name }}</label>
                  </div>
                </div>

                @if(in_array($approval->travel_category->name, ['BD', 'SD']))
                  <div class="row">
                    <div class="col-md-5 col-sm-5 col-xs-5">
                      @php 
                        $projectTextArr = [1 => 'Existing Client', 2 => 'Prospect', 3 => 'Others']; 
                        $projectText = '--';
                        if(isset($projectTextArr[$approval->travel_for])) {
                          $projectText = $projectTextArr[$approval->travel_for];
                        }                      
                      @endphp
                      <label for="">For {{ $projectText }}</label>
                    </div>
                    <div class="col-md-7 col-sm-7 col-xs-7">
                      @if($approval->travel_for == 1)
                        <label>{{$approval->project->name}}</label>
                      @elseif($approval->travel_for == 2)
                        <label>{{$approval->tils->til_code}}</label>
                      @else 
                        <label>{{$approval->others}}</label>
                      @endif
                    </div>
                  </div>
                @endif
                
                @if($approval->approved_by_user)
                  <div class="row">
                    <div class="col-md-5 col-sm-5 col-xs-5">
                      <label for="">Approved By</label>
                    </div>
                    <div class="col-md-7 col-sm-7 col-xs-7">
                      <label>{{$approval->approved_by_user->employee->salutation}}{{$approval->approved_by_user->employee->fullname}}</label>
                    </div>
                  </div>
                @endif

                @if(isset($claims->id))
                  <div class="row">
                    <div class="col-md-5 col-sm-5 col-xs-5">
                      <label for="">Payment Status</label>
                    </div>
                    <div class="col-md-7 col-sm-7 col-xs-7">
                      <label>
                        {{ucfirst($claims->status)}}
                      </label>
                    </div>
                  </div>
                @endif

                @if(isset($claims->id))
                  <div class="row">
                    <div class="col-md-5 col-sm-5 col-xs-5">
                      <label for="">UTR No.</label>
                    </div>
                    <div class="col-md-7 col-sm-7 col-xs-7">
                      <label>{{$claims->utr??'--'}}</label>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-5 col-sm-5 col-xs-5">
                      <label for="">Payment Date</label>
                    </div>
                    <div class="col-md-7 col-sm-7 col-xs-7">
                      @php
                        $paymentDate = !empty($claims->payment_date)? date('d/m/Y', strtotime($claims->payment_date)) : null;
                      @endphp
                      <label>{{$paymentDate??'--'}}</label>
                    </div>
                  </div>
                @endif
              </div>
            </div>
            
            <div class="col-md-4">
              <h3 class="travel-expense-title3">Amount Details</h3>
              <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-6">
                  <label for="">Travel Amount</label>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6 text-right">
                  @php $travelAmount = '00.0'; @endphp
                  @if($approval->travel_type == 1)
                    @php $travelAmount = $approval->travelLocal->travel_amount; @endphp
                  @else
                    @php $travelAmount = 0; @endphp
                    @foreach($approval->travelNational as $nk => $national)
                      @php $travelAmount += $national->travel_amount; @endphp
                    @endforeach
                  @endif
                  <label>{{moneyFormat($travelAmount)}}</label>
                </div>
              </div>
              
              @if($approval->travel_type == 2)
                <div class="row">
                  <div class="col-md-8 col-sm-8 col-xs-8">
                    <label for="">
                      Travel Stay Amount
                    </label>
                  </div>
                  <div class="col-md-4 col-sm-4 col-xs-4 text-right">
                    <label>
                      @if(isset($approval->travelStay) && !empty($approval->travelStay))
                        @php $travelStayAmount = 0; @endphp
                        @foreach($approval->travelStay as $sk => $stay)
                          @php 
                            $daysBetweenDates = claculateNightsTwoDates($stay->from_date, $stay->to_date);

                            $daysBetweenDates = ($daysBetweenDates > 1)? ($daysBetweenDates - 1) : $daysBetweenDates;

                            $travelStayAmount += (($stay->rate_per_night *$daysBetweenDates) + $stay->da); 
                          @endphp
                        @endforeach

                        {{moneyFormat($travelStayAmount)}}
                      @else
                       00.0
                      @endif
                    </label>
                  </div>
                </div>

                <!-- <div class="row">
                  <div class="col-md-8 col-sm-8 col-xs-8">
                    <label for="">
                      Other financial approvals
                    </label>
                  </div>
                  <div class="col-md-4 col-sm-4 col-xs-4 text-right">
                    <label>
                      @ if(isset($approval->otherApproval) && !empty($approval->otherApproval))
                        { {moneyFormat($approval->otherApproval->amount)}}
                      @ else
                       00.0
                      @ endif
                    </label>
                  </div>
                </div> -->

                <div class="row">
                  <div class="col-md-5 col-sm-5 col-xs-5">
                    <label for="">Imprest taken</label>
                  </div>
                  <div class="col-md-7 col-sm-7 col-xs-7 text-right">
                    <label>
                      @if(isset($approval->imprest))
                        {{moneyFormat($approval->imprest->amount)}}
                      @else 
                        -- 
                      @endif
                    </label>
                  </div>
                </div>
              @endif
            </div>
          </div>

          <!-- <div class="box-header">
          </div> -->
          <!-- /.box-header -->
          <form action="" method="post" id="claim_form" class="form-horizontal">
            <div class="box-body">
              <fieldset>
                <legend>Travel :</legend>
                <div class="col-md-12 table-responsive no-padding">
                  <table class="table table-bordered table-striped travel-table-inner">
                    <thead class="table-heading-style">
                      <th>Allowed Conveyances</th>
                    </thead>
                    <tbody id="travelExpenseTable">
                      <tr>
                        <td><label>{{$eligible_conveyance}}</label></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div class="col-md-12 table-responsive no-padding">
                  <table id="travelExpenseTable" class="table table-bordered table-striped travel-table-inner">
                    <thead class="table-heading-style">
                      <tr>
                        <th>S No.</th>
                        <th>Date</th>
                        <th>From</th>
                        <th>To</th>
                        <th>Expense Type</th>
                        <th class="text-right">Distance (in k.m)</th>
                        <th>Description</th>
                        <th class="text-right">Amount</th>
                        @if(in_array($claims->status, ['new', 'back']) && (auth()->user()->can('verify-travel-claim') || auth()->user()->can('approve-travel-claim') || auth()->user()->can('pay-travel-claim')) && (empty($claims->climberUser) || in_array($claims->climberUser->status, ['new'])) && $claims->user_id != $userId)
                          <th class=""> <!-- text-center -->
                            <label for="claim_details_all">
                              <input type="checkbox" class="claim_details_all" name="claim_details_all" id="claim_details_all" value="1">
                              Send Back 
                            </label>
                          </th>
                        @endif
                      </tr>
                    </thead>
                    <tbody>
                      @php $amountTotal = 0; @endphp
                      @foreach($claims->claim_details as $ky => $cd)
                        @php
                          $claimStatusCheck = false; $claimTrClass = null;
                          if(in_array($cd->status, ['back'])) {
                            $claimStatusCheck = true; $claimTrClass = 'tr-danger';
                          }

                          $tAmountClass = '';
                          if(auth()->user()->can('verify-travel-claim') && isset($approval->travelNational[$ky]->travel_amount) && $cd->amount > $approval->travelNational[$ky]->travel_amount) {
                            $tAmountClass = 'bg-danger';
                          }

                          $amountTotal += $cd->amount;
                        @endphp                        

                        <tr class="{!! $claimTrClass !!}">
                          <td>{{$loop->iteration}}.</td>
                          <td>{{formatDate($cd->expense_date)}}</td>
                          <td>{{$cd->fromCity->name}}</td>
                          <td>{{$cd->toCity->name}}</td>
                          <td>
                            @if($cd->expense_types)
                              {{$cd->expense_types->name}}

                              @if($cd->expense_types->price_per_km > 0)
                                [{{ moneyFormat($cd->expense_types->price_per_km) }}/k.m]
                              @endif
                            @endif
                          </td>
                          <td class="text-right">{{ numberFormat($cd->distance_in_km) }}</td>
                          <td>{{$cd->description}}</td>
                          <td class="text-right {{$tAmountClass}}">{{moneyFormat($cd->amount)}}</td>

                          @if(in_array($claims->status, ['new', 'back']) && (auth()->user()->can('verify-travel-claim') || auth()->user()->can('approve-travel-claim') || auth()->user()->can('pay-travel-claim')) && (empty($claims->climberUser) || in_array($claims->climberUser->status, ['new'])) && $claims->user_id != $userId)
                          <td class=""> <!-- text-center -->
                            @if($cd->status == 'new')
                              <label for="claim_details[{!! $cd->id !!}]" class="font-normal">
                                <input type="checkbox" name="claim_details[]" class="claim_details claim_check" value="{{$cd->id}}" @if($claimStatusCheck == true) checked="checked" @endif>
                              </label>
                            @else
                              NA
                            @endif
                          </td>
                          @endif
                        </tr>
                      @endforeach
                      <tr>
                        <td colspan="7" class="text-bold">Total</td>
                        <td class="text-right text-bold">{{moneyFormat($amountTotal)}}</td>
                        @if(in_array($claims->status, ['new', 'back']) && (auth()->user()->can('verify-travel-claim') || auth()->user()->can('approve-travel-claim') || auth()->user()->can('pay-travel-claim')) && (empty($claims->climberUser) || in_array($claims->climberUser->status, ['new'])) && $claims->user_id != $userId)
                          <td class="">&nbsp;</td>
                        @endif
                      </tr>
                    </tbody>
                  </table>
                </div>
              </fieldset>

              <br>

              @if(!empty($claims->claim_stay) && count($claims->claim_stay) > 0)
                <fieldset>
                  <legend>Stay:</legend>
                  <div class="col-md-12 table-responsive no-padding">
                    <table class="table table-bordered table-striped">
                      <thead class="table-heading-style">
                        <tr>
                          <th>From Date</th>
                          <th>To Date</th>
                          <th>State</th>
                          <th>City</th>
                          <th>Rate stay/night <br/> (incl taxes)</th>
                          <th>Food Expense (DA)</th>
                          <th class="text-right">Total</th>

                          @if(in_array($claims->status, ['new', 'back']) && (auth()->user()->can('verify-travel-claim') || auth()->user()->can('approve-travel-claim') || auth()->user()->can('pay-travel-claim')) && (empty($claims->climberUser) || in_array($claims->climberUser->status, ['new'])) && $claims->user_id != $userId)
                            <th class=""> <!-- text-center -->
                              <label for="claim_stays_all">
                                <input type="checkbox" class="claim_stays_all" name="claim_stays_all" id="claim_stays_all" value="1"> Send Back
                              </label>
                            </th>
                          @endif
                        </tr>
                      </thead>
                      <tbody id="tbody">
                        @php 
                          $ratePerNightTotal = 0;
                          $daTotal = 0; $totalStay = 0;
                        @endphp
                        @foreach($claims->claim_stay as $stay)
                          @php
                            $statyStatusCheck = false; $stayTrClass = null;
                            if(in_array($stay->status, ['back'])) {
                              $statyStatusCheck = true; $stayTrClass = 'tr-danger';
                            }

                            $sAmountClass = '';
                            if(auth()->user()->can('verify-travel-claim') && isset($approval->travelStay[$ky]->rate_per_night) && $stay->rate_per_night > $approval->travelStay[$ky]->rate_per_night) {
                              $sAmountClass = 'bg-danger';
                            }

                            $daAmountClass = '';
                            if(auth()->user()->can('verify-travel-claim') && isset($approval->travelStay[$ky]->da) && $stay->da > $approval->travelStay[$ky]->da) {
                              $daAmountClass = 'bg-danger';
                            }

                            $calDays = claculateNightsTwoDates($stay->from_date, $stay->to_date);
                            $calDays = ($calDays > 1)? ($calDays - 1) : $calDays;

                            $totalStay+=$subTotal=($stay->rate_per_night*$calDays)+$stay->da;

                            $ratePerNightTotal += $stay->rate_per_night;
                            $daTotal += $stay->da;
                          @endphp

                          <tr class="city_tr {{ $stayTrClass }}">
                            <td>{{formatDate($stay->from_date)}}</td>
                            <td>{{formatDate($stay->to_date)}}</td>
                            <td>{{$stay->state->name}}</td>
                            <td>{{$stay->city->name}}</td>
                            <td class="text-right {{$sAmountClass}}">
                              {{moneyFormat($stay->rate_per_night)}}
                            </td>
                            <td class="text-right {{$daAmountClass}}">{{moneyFormat($stay->da)}}</td>
                            
                            <td class="text-right">{{moneyFormat($subTotal)}}</td>

                            @if(in_array($claims->status, ['new', 'back']) && (auth()->user()->can('verify-travel-claim') || auth()->user()->can('approve-travel-claim') || auth()->user()->can('pay-travel-claim')) && (empty($claims->climberUser) || in_array($claims->climberUser->status, ['new'])) && $claims->user_id != $userId)
                              <td class=""> <!-- text-center -->
                                @if($cd->status == 'new')
                                  <label for="claim_stays[{!! $stay->id !!}]" class="font-normal">
                                    <input type="checkbox" name="claim_stays[]" class="claim_stays claim_check" value="{{$stay->id}}" @if($statyStatusCheck == true)checked="checked" @endif>
                                  </label>
                                @else
                                  NA
                                @endif
                              </td>
                            @endif
                          </tr>
                        @endforeach
                        <tr>
                          <td colspan="4" class="text-bold">Total</td>
                          <td class="text-right text-bold" >{{moneyFormat($ratePerNightTotal)}}</td>
                          <td class="text-right text-bold" >{{moneyFormat($daTotal)}}</td>
                          <td class="text-right text-bold" >{{moneyFormat($totalStay)}}</td>
                          @if(in_array($claims->status, ['new', 'back']) && (auth()->user()->can('verify-travel-claim') || auth()->user()->can('approve-travel-claim') || auth()->user()->can('pay-travel-claim')) && (empty($claims->climberUser) || in_array($claims->climberUser->status, ['new'])) && $claims->user_id != $userId)
                            <td class="">&nbsp;</td>
                          @endif
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </fieldset>
              @endif

              <fieldset>
                <legend>Supporting Documents:</legend>
                <div class="col-md-12 table-responsive no-padding">
                  <table id="travelAttachmentTable" class="table table-bordered table-striped travel-table-inner" style="height:150px;">
                    <thead class="table-heading-style">
                      <tr>
                        <th>S No.</th>
                        <th>Type of Attachment</th>
                        <th>Name</th>
                        <th>Link</th>

                        @if(in_array($claims->status, ['new', 'back']) && (auth()->user()->can('verify-travel-claim') || auth()->user()->can('approve-travel-claim') || auth()->user()->can('pay-travel-claim')) && (empty($claims->climberUser) || in_array($claims->climberUser->status, ['new'])) && $claims->user_id != $userId)
                          <th class=""> <!-- text-center -->
                            <label for="claim_attachments_all">
                              <input type="checkbox" class="claim_attachments_all" name="claim_attachments_all" id="claim_attachments_all" value="1"> Send Back
                            </label>
                          </th>
                        @endif
                      </tr>
                    </thead>
                    <tbody>
                      @php
                        $fileAbsolutePath = \Config::get('constants.uploadPaths.claimDocument');
                        $filePath = asset('public') . \Config::get('constants.uploadPaths.claimDocumentPath');
                      @endphp
                      @foreach($claims->claim_attachments as $cd)
                        @php
                          $attachmentCheck = false; $attachmentTrClass = null;
                          if(in_array($cd->status, ['back'])) {
                            $attachmentCheck = true; $attachmentTrClass = 'tr-danger';
                          }
                        @endphp
                          
                        <tr class="{{ $attachmentTrClass }}">
                          <td>{{$loop->iteration}}.</td>
                          <td>@if($cd->attachment_types){{$cd->attachment_types->name}}@endif</td>
                          <td>{{$cd->name}}</td>
                          <td>
                            @if(!empty($cd->attachment) && file_exists($fileAbsolutePath . $cd->attachment))
                              <a href="{!! $filePath . $cd->attachment !!}" target="_blank" class="btn btn-xs btn-success pull-right">
                                Attachment
                              </a>
                            @endif
                          </td>

                          @if(in_array($claims->status, ['new', 'back']) && (auth()->user()->can('verify-travel-claim') || auth()->user()->can('approve-travel-claim') || auth()->user()->can('pay-travel-claim')) && (empty($claims->climberUser) || in_array($claims->climberUser->status, ['new'])) && $claims->user_id != $userId)
                            <td class=""> <!-- text-center -->
                              @if($cd->status=='new')
                                <label for="claim_attachments[{!! $cd->id !!}]" class="font-normal">
                                  <input type="checkbox" name="claim_attachments[]" class="claim_attachments claim_check" value="{{$cd->id}}" @if($attachmentCheck == true)checked="checked" @endif>
                                </label>
                              @else
                              NA
                              @endif
                            </td>
                          @endif
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </fieldset>

              @if(in_array($claims->status, ['new', 'back']) && (auth()->user()->can('verify-travel-claim') || auth()->user()->can('approve-travel-claim') || auth()->user()->can('pay-travel-claim')) && (empty($claims->climberUser) || $claims->climberUser->status == 'new') && $claims->user_id != $userId)
                <fieldset>
                  <legend>&nbsp;</legend>
                  <div class="form-group col-md-12">
                    <label for="comments" class="control-label">Comments:</label>
                    <div class="">
                      <textarea name="comments" id="comments" cols="30" rows="4" class="form-control"></textarea>
                    </div>
                  </div>
                </fieldset>

                <hr/>

                <div class="row">
                  <div class="col-md-12 text-center">
                    @if(auth()->user()->can('verify-travel-claim') && $climberCount <= 1)
                      <input type="submit" name="send_it_back" value="Send Back" class="btn btn-danger send_back"/>
                    @endif

                    @if(!auth()->user()->can('verify-travel-claim') && !auth()->user()->can('pay-travel-claim'))
                      <input type="submit" name="reject" value="Reject" class="btn btn-warning reject"/>
                    @endif
                    <!-- auth()->user()->can('approve-travel-claim') && -->
                    @if($climberCount <= 1)
                      <input type="submit" name="approve" value="Approve" class="btn btn-success approve"/>
                    @endif

                    @if(auth()->user()->can('pay-travel-claim') && $climberCount > 1)
                      <a href="javascript:void(0)" class="btn btn-success" id="approveAndPay">Approve & Pay</a>
                    @endif

                    <input type="hidden" name="action_type" value="">
                  </div>
                </div>

                <fieldset>
                  <legend>&nbsp;</legend>
                  <div class="row">
                    <div class="col-md-4 col-md-offset-4">
                      <div class="utr-outerbox" style="display: none;">
                        <div class="row form-group">
                          <div class="col-md-4 utr-left-col">
                            <label class="utr-label" for="utrNumber">UTR No:</label>
                          </div>
                          <div class="col-md-8 utr-right-col">
                            <input type="text" name="utr" id="utr" class="utrNumber form-control travel-input2 travel-table-input-style travel-only-inputss">
                          </div>
                        </div>
                        <div class="row form-group">
                          <div class="col-md-4 utr-left-col">
                            <label class="utr-label" for="utrNumber">Payment Date:</label>
                          </div>
                          <div class="col-md-8 utr-right-col">
                            <input type="text" name="utr_date" id="utr_date" class="utrNumber form-control selectDate travel-table-input-style travel-only-inputss travel-input2 utr_date" placeholder="MM/DD/YYYY" onkeypress="return false;" autocomplete="off" required>
                          </div>
                        </div>
                        <div class="utr-submit-box">
                          <button type="submit" name="pay_approve" class="btn btn-success" value="Pay">Submit</button>
                        </div>
                        {{ csrf_field() }}
                      </div>
                    </div>
                  </div>
                </fieldset>
              <!-- @ elseif($claims->status == 'paid') -->
              @endif

              <hr/>

              <fieldset>
                <legend>Current Status:</legend>
                <div class="form-group col-md-12">
                  <!-- /.box-header -->
                  <div class="box-body p-w-xs">
                    <ul class="timeline timeline-inverse">
                      @foreach($claims->authorities as $k => $authority)
                        <li>
                          <i class="fa fa-envelope bg-blue"></i>
                          <div class="timeline-item">
                            <table class="table table-bordered timeline-header" style="min-height: 50px;">
                              <tbody>
                                <th class="leaveMessageList" style="width: 15%;">
                                  <strong class="text-success">Level:</strong> 
                                  {{$authority->user_role}}
                                </th>

                                @if(!$claims->climber->isEmpty())
                                  @foreach($claims->climber as $ckey => $climber)
                                    @if($authority->manager_id == $climber->climber_user_id && $authority->priority == $climber->priority && in_array($climber->status, ['approved', 'paid']))

                                      <td class="leaveMessageList" style="width: 40%;">
                                        <i class="fa fa-check-circle font-15 text-success"></i>
                                        {{ucfirst($climber->status)}}
                                      </td>

                                      <td class="leaveMessageList text-right" style="width: 30%;">
                                        <strong class="text-success">Created at:</strong>
                                        {{date('d/m/Y h:i a', strtotime($climber->created_at))}}
                                      </td>
                                    @endif
                                  @endforeach
                                @endif
                              </tbody>
                            </table>
                          </div>
                        </li>
                      @endforeach
                      <li>
                        <i class="fa fa-clock-o bg-gray"></i>
                      </li>
                    </ul>
                  </div>
                </div>
              </fieldset>

              <hr/>

              <fieldset>
                <legend>Comments:</legend>
                <div class="form-group col-md-12">
                  <!-- /.box-header -->
                  <div class="box-body p-w-xs">
                    <ul class="products-list product-list-in-box">
                      @foreach($claims->comments as $comKey => $comments)
                        <li class="item">
                          <div class="product-img">
                            @php
                              $profilePic = config('constants.static.profilePic');
                              if(!empty($comments->userEmployee->profile_picture)) {
                                $profilePic = config('constants.uploadPaths.profilePic').$comments->userEmployee->profile_picture;
                              }
                            @endphp
                            <img src="{{$profilePic}}" class="img-circle p-image" alt="User Image">
                          </div>
                          <div class="product-info">
                              <div class="pull-right">
                                <span>{{date('d/m/Y h:i a', strtotime($comments->created_at))}}</span>
                              </div>
                              <p class="m-n">
                                <span class="f_b">
                                  <b>{{str_replace('  ', ' ', $comments->userEmployee->fullname)}}</b>
                                </span>&nbsp;
                              </p>
                              <span class="product-description">{{$comments->comments}}</span>
                          </div>
                        </li>
                      @endforeach
                    </ul>
                  </div>
                </div>
              </fieldset>

              <hr/>

              <fieldset>
                <legend>Travel Logs:</legend>
                <div class="form-group col-md-12">
                  <!-- /.box-header -->
                  <div class="box-body p-w-xs">
                    <ul class="products-list product-list-in-box">
                      @foreach($claims->logs as $lKey => $log)
                        <li class="item">
                          <div class="product-info{{$lKey}}">
                            <div class="pull-right">
                              <span>{{date('d/m/Y h:i a', strtotime($log->created_at))}}</span>
                            </div>
                            <p class="m-n">
                              <span class="f_b">
                                <b>{{str_replace('  ', ' ', $log->employee->fullname)}}</b>
                              </span>
                              <!-- <span class="label label-success f_b"><b>Approved</b></span> -->
                            </p>
                            <span class="product-description">
                              {{$log->remarks}}
                            </span>
                          </div>
                        </li>
                      @endforeach
                    </ul>
                  </div>
                </div>
              </fieldset>
              <hr/>
            </div>
          </form>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
    </div>
    <!-- /.row -->
    <!-- Main row -->
  </section>
</div>
<!-- /.content -->
<!-- /.content-wrapper -->
<script src="{{ asset('public/admin_assets/plugins/jquery-toast/jquery.toast.min.js') }}"></script>
<script src="{{asset('public/admin_assets/plugins/dataTables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('public/admin_assets/plugins/validations/jquery.validate.js')}}"></script>
<script src="{{asset('public/admin_assets/plugins/validations/additional-methods.js')}}"></script>
<script src="{!! asset('public/admin_assets/plugins/sweetalert/sweetalert.min.js') !!}"></script>

<script type="text/javascript">
  $(document).ready(function () {

    $('#claim_form').validate({
      ignore: ':hidden, input[type=hidden], .select2-search__field', //  [type="search"]
      errorElement: 'span',
      // debug: true,
      // the errorPlacement has to take the table layout into account
      errorPlacement: function(error, element) {
        // $(element).attr('name')
        error.appendTo(element.parent()); // element.parent().next()
      },
    });

    $(document).on('click', '.claim_details_all', function (event) {
      if(!$(this).is(':checked')) {
        $('.claim_details_all').prop('checked', false);
        $('.claim_details').prop('checked', false);
        $('.claim_details').parent().parent().parent().closest('tr').removeClass('tr-danger');
      } else {
        $('.claim_details_all').prop('checked', true);
        $('.claim_details').prop('checked', true);
        $('.claim_details').parent().parent().parent().closest('tr').addClass('tr-danger');
      }
    });

    $(document).on('click', '.claim_details', function (event) {
      if(!$(this).is(':checked')) {
        $('.claim_details_all').prop('checked', false);
        $(this).parent().parent().parent().closest('tr').removeClass('tr-danger');
      } else {
        $(this).parent().parent().parent().closest('tr').addClass('tr-danger');
      }
    });

    $(document).on('click', '.claim_stays_all', function (event) {
      if(!$(this).is(':checked')) {
        $('.claim_stays_all').prop('checked', false);
        $('.claim_stays').prop('checked', false);
        $('.claim_stays').parent().parent().parent().closest('tr').removeClass('tr-danger');
      } else {
        $('.claim_stays_all').prop('checked', true);
        $('.claim_stays').prop('checked', true);
        $('.claim_stays').parent().parent().parent().closest('tr').addClass('tr-danger');
      }
    });

    $(document).on('click', '.claim_stays', function (event) {
      if(!$(this).is(':checked')) {
        $('.claim_stays_all').prop('checked', false);
        $(this).parent().parent().parent().closest('tr').removeClass('tr-danger');
      } else {
        $(this).parent().parent().parent().closest('tr').addClass('tr-danger');
      }
    });
    
    $(document).on('click', '.claim_attachments_all', function (event) {
      if(!$(this).is(':checked')) {
        $('.claim_attachments_all').prop('checked', false);
        $('.claim_attachments').prop('checked', false);
        $('.claim_attachments').parent().parent().parent().closest('tr').removeClass('tr-danger');
      } else {
        $('.claim_attachments_all').prop('checked', true);
        $('.claim_attachments').prop('checked', true);
        $('.claim_attachments').parent().parent().parent().closest('tr').addClass('tr-danger');
      }
    });

    $(document).on('click', '.claim_attachments', function (event) {
      if(!$(this).is(':checked')) {
        $('.claim_attachments_all').prop('checked', false);
        $(this).parent().parent().parent().closest('tr').removeClass('tr-danger');
      } else {
        $(this).parent().parent().parent().closest('tr').addClass('tr-danger');
      }
    });

    $(document).on('click', '#approveAndPay', function() {
      
      $('input[name="action_type"]').val('pay_approve');

      $(".utr-outerbox").show();
      $("#utr").prop('required', true);
    });

    $(document).on('click', '.approve', function() {
      $('input[name="action_type"]').val('approve');      
    });

    $(document).on('click', '#claim_form .send_back', function(event) {
      event.preventDefault(); event.stopPropagation();

      var claim_details_check = $('input.claim_details:checkbox').filter(':checked').length;
      var claim_stays_check   = $('input.claim_stays:checkbox').filter(':checked').length;
      var claim_attachments_check = $('input.claim_attachments:checkbox').filter(':checked').length;

      if(claim_details_check > 0 || claim_stays_check > 0 || claim_attachments_check > 0) {

        $('input[name="action_type"]').val('send_it_back');
        $('#claim_form').submit();
      } else {
        // Please check any claims or attachments before sending it back.
        $.toast({
          heading: 'Error',
          text: 'Please select at least one Travel, Stay or Supporting Documents to perform a action. Please check it before sending back.',
          showHideTransition: 'plain',
          icon: 'error',
          hideAfter: 15000,
          position: 'top-right', 
          stack: 2, 
          loader: true,
          loaderBg: '#b50505',
        });

        $("#utr").prop('required', false);

        return false;
      }
    });

    $(document).on('click', '#claim_form .reject', function(event) {
      event.preventDefault(); event.stopPropagation();

      swal({
        title: "Are you sure?",
        text: "You want to reject this Travel claim request!",
        icon: "warning",
        buttons: [
          'No, cancel it!',
          'Yes, I am sure!'
        ],
        dangerMode: true,
      }).then(function(isConfirm) {

        if (isConfirm) {

          $("#utr").prop('required', false);
          $('input[name="action_type"]').val('reject');
          $('#claim_form').submit();
        }
      });
    });

    $(document).on('click', '.get-comments', function(event) {
      event.preventDefault();  event.stopPropagation();
      getComments($(this));
    });

    //Date picker
    $(".utr_date").datepicker({
      /*format: "MM/DD/YYYY",*/
      endDate: '<?php echo date('m/d/Y'); ?>',
      autoclose: true,
      orientation: "bottom"
    });

  });

  function nl2br(str, is_xhtml) {
    var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br/>' : '<br>';
    return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1'+ breakTag +'$2');
  }

  function getComments(obj)
  {
    var travel_claim_id = $(obj).data('id');
    var _token  = '{!! csrf_token() !!}';
    var objdata = {'_token': _token, 'id': travel_claim_id};

    $.ajax({
      url: "{!! route('travel-claim.get-comments') !!}",
      type: "GET",
      data: objdata,
      dataType: 'json',
      success: function (res) {
        if(res.status == 1) {
          // swal("Done!", res.msg, "success");
          if(typeof res != 'undefined' && res != '') {
            var commentsHtml = '';
            var leadCommentDir = res.dir_path;

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
                                        '<strong class="text-success">Created at:</strong> '+ moment(v.created_at).format('D/M/Y h:mm a') +
                                      '</span>'+
                                    '</h5>'+
                                    '<div class="timeline-body">'+
                                      '<div class="row">'+
                                        '<div class="col-md-10">'+
                                          '<p>'+ nl2br(v.comments) +'</p>'+
                                        '</div>'+
                                        '<div class="col-md-2">';
                                          if(v.attachment) {
                commentsHtml +=             '<a href="'+ leadCommentDir + v.attachment +'" target="_blank" class="btn btn-success btn-xs">'+
                                              '<i class="fa fa-paperclip"></i>'+
                                            '</a>';
                                          } else {
                commentsHtml +=             '--';
                                          }
                commentsHtml +=          '</div>'+
                                      '</div>'+
                                    '</div>'+
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
                hideAfter: 10000,
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
            hideAfter: 10000,
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
</script>
@endsection