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
    width: 100px;
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
  i.fa.fa-minus.remtravel-row.red{
    background-color: #dd4b39;
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
<link href="{{asset('public/admin_assets/plugins/jquery-toast/jquery.toast.min.css')}}" rel="stylesheet">
<link href="{{asset('public/admin_assets/plugins/dataTables/jquery.dataTables.min.css')}}" rel="stylesheet">

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>Claim Form</h1>
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
        @include('admins.validation_errors')
        <form id="claim-form" accept="" action="" method="post" enctype="multipart/form-data">
          {{ csrf_field() }}
          <div class="box box-primary">
            <h2 class="travel-expense-title2">
              <legend>Claim Details -: {{ $claims->claim_code }}</legend>
            </h2>
            <h4 class="p-w-xs">
              <small>
                <a href="{{url('travel/approval-request-details/'.encrypt($approval->id))}}" class="btn btn-success btn-xs">View Approval Details</a>
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
                      <label>
                        {{$approval->user->employee->salutation}}
                        {{$approval->user->employee->fullname}}
                      </label>
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

                <input type="hidden" name="total_travel_amount" class="total_travel_amount" value="{{ $approval->total_amount }}">

                <input type="hidden" name="total_claim_amount" class="total_claim_amount" value="0">
              </div>
            </div>
            <!-- <div class="box-header">
            </div> -->
            <!-- /.box-header -->
            <div class="box-body">
              <fieldset>
                <legend>Travel:</legend> <!-- Expense -->
                <div class="col-md-12 table-responsive no-padding">
                  <table class="table table-bordered table-striped travel-table-inner">
                    <thead class="table-heading-style">
                      <th>Allowed Conveyances</th>
                    </thead>
                    <tbody>
                      <tr>
                        <td><label>{{$eligible_conveyance}}</label></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div class="col-md-12 table-responsive no-padding">
                  <table class="table table-bordered table-striped travel-table-inner" style="height:150px;">
                    <thead class="table-heading-style">
                      <tr>
                        <th>Date<small class="text-red">*</small></th>
                        <th>From</th>
                        <th>To</th>
                        <th>Expense Type</th>
                        <th>Distance (in k.m)<small class="text-red">*</small></th>
                        <th>Description</th>
                        <th>Amount<small class="text-red">*</small></th>
                        <th>Add/Rem</th>
                      </tr>
                    </thead>
                    <tbody id="travelExpenseTable">
                      @foreach($claims->claim_details as $cd)
                        @php
                          $expenseCheck = false; $expenseTrClass = null;
                          if(in_array($cd->status, ['back'])) {
                            $expenseCheck = true; $expenseTrClass = 'tr-danger';
                          }
                        @endphp

                        <tr class="{!! $expenseTrClass !!}">
                          <td>
                            <input type="hidden" name="travel_expense[id][]" value="{!! $cd->id !!}">

                            <input type="text" name="travel_expense[date][]" class="form-control selectDate travel-table-input-style travel-only-inputss travel-input2 travelDate" value="{{date('m/d/Y', strtotime($cd->expense_date))}}" required onkeypress="return false;" placeholder="MM/DD/YYYY" autocomplete="off">
                          </td>
                          <td>
                            <select name="travel_expense[from_location][]" class="form-control travel-input6 travel-table-input-style travel-only-inputss from_location" required>
                              <option value="">Select</option>
                              @foreach($cities as $cK => $city)
                                @php $selectCity = null @endphp
                                @if($city->id == $cd->from_location)
                                  @php $selectCity = 'selected="selected"'; @endphp
                                @endif
                                <option value="{{$city->id}}" {{ $selectCity }}>{{$city->name}}</option>
                              @endforeach
                            </select>
                          </td>
                          <td>
                            <select name="travel_expense[to_location][]" class="form-control travel-input6 travel-table-input-style travel-only-inputss to_location" required>
                              <option value="">Select</option>
                              @foreach($cities as $tK => $city)
                                @php $selectToCity = null @endphp
                                @if($city->id == $cd->to_location)
                                  @php $selectToCity = 'selected="selected"'; @endphp
                                @endif
                                <option value="{{$city->id}}" {{ $selectToCity }}>{{$city->name}}</option>
                              @endforeach
                            </select>
                          </td>
                          <td>
                            @php $readonlyAmount = null; @endphp
                            <select name="travel_expense[expense_type][]" class="form-control travel-input6 travel-table-input-style travel-only-inputss expense_type" required>
                              <option value="">Select</option>
                              @foreach($conveyances as $conveyance)
                                @php $selectCoveyance = null; @endphp
                                @if($conveyance->id == $cd->expense_type)
                                  @php 
                                    $selectCoveyance = 'selected="selected"';
                                    $readonlyAmount = 'readonly';
                                  @endphp
                                @endif
                                <option value="{{$conveyance->id}}" data-islocal="{{$conveyance->islocal}}" data-price_per_km="{{$conveyance->price_per_km}}" {{ $selectCoveyance }}>
                                  {{$conveyance->name}}
                                  @if($conveyance->price_per_km > 0)
                                    [{{ moneyFormat($conveyance->price_per_km) }}/k.m]
                                  @endif
                                </option>
                              @endforeach
                            </select>
                          </td>
                          <td>
                            <!-- distance_in_km -->
                            <input type="number" name="travel_expense[distance_in_km][]" class="form-control input-sm basic-detail-input-style distance_in_km" value="{{$cd->distance_in_km}}" min="0" required @if(empty($readonlyAmount)) readonly @endif autocomplete placeholder="Distance(k.m)">
                          </td>
                          <td>
                            <input type="text" name="travel_expense[description][]" class="form-control travel-input3 travel-table-input-style travel-only-inputss" value="{{ $cd->description }}" required>
                          </td>
                          <td>
                            <input type="number" name="travel_expense[amount][]" class="form-control travel-input5 travel-table-input-style travel-only-inputss amount_to_be cal_value" value="{{ $cd->amount }}" required {{$readonlyAmount}} max="20000" min="1" placeholder="330">
                          </td>
                          <td class="text-center">
                            @if($loop->iteration == 1)
                              <a href="javascript:void(0);" class="addtravel" data-type="expense" data-claimid="{!! $claims->id !!}" data-id="{!! $cd->id !!}">
                                <i class="fa fa-plus addtravel-row @if($expenseCheck == true) red @endif"></i>
                              </a>
                            @else
                              <a href="javascript:void(0);" onclick="removeTr($(this))" class="remtravel" data-type="expense" data-claimid="{!! $claims->id !!}" data-id="{!! $cd->id !!}">
                                <i class="fa fa-minus remtravel-row @if($expenseCheck == true) red @endif"></i>
                              </a>
                            @endif
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </fieldset>

              <br>
              @php
                $bandId = @$user->designation[0]->band->id;
              @endphp
              @if($approval->travel_type == 2 && !$approval->travelStay->isEmpty())
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
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody id="tbody">
                        @foreach($claims->claim_stay as $stay)
                          @php
                            $stayCheck = false; $stayTrClass = null;
                            if(in_array($stay->status, ['back'])) {
                              $stayCheck = true; $stayTrClass = 'tr-danger';
                            }
                          @endphp

                          <tr class="city_tr {!! $stayTrClass !!}">
                            <td>
                              <input type="hidden" name="stay[id][]" value="{!! $stay->id !!}">

                              <input type="text" name="stay[date_from][]" class="form-control selectDate stay_date_from" value="{{ date('m/d/Y', strtotime($stay->from_date)) }}" readonly required placeholder="MM/DD/YYYY" autocomplete="off" style="width: 200px;">
                            </td>
                            <td>
                              <input type="text" name="stay[date_to][]" class="form-control selectDate stay_date_to" value="{{ date('m/d/Y', strtotime($stay->to_date)) }}" readonly required placeholder="MM/DD/YYYY" autocomplete="off" style="width: 200px;">
                            </td>
                            <td>
                              <select name="stay[state_id][]" class="form-control state_id_stay state" onchange="displayCity($(this), 3);" required style="width: 120px">
                                <option value="">Select state</option>
                                @if(!$states->isEmpty())
                                  @foreach($states as $state)
                                    @php $selectStayState = null @endphp
                                    @if($state->id == $stay->state_id)
                                      @php $selectStayState = 'selected="selected"'; @endphp
                                    @endif
                                    <option value="{{$state->id}}" {{ $selectStayState }}>{{$state->name}}</option>
                                  @endforeach
                                @endif
                              </select>
                            </td>
                            <td>
                              <select name="stay[city_id][]" class="form-control city_select city_id_stay" onchange="GetCityDetails($(this))" required style="width: 120px">
                                <option value="">Select City</option>
                                @foreach($cities as $ck => $city)
                                  @php $selectStayCity = null @endphp
                                  @if($city->id == $stay->city_id)
                                    @php $selectStayCity = 'selected="selected"'; @endphp
                                  @endif
                                  <option value="{{$city->id}}" {{ $selectStayCity }}>{{$city->name}}</option>
                                @endforeach
                              </select>
                            </td>
                            <td>
                              <input type="number" name="stay[rate_per_night][]" class="form-control stayda amount_to_be cal_value rate_per_night" min="0" value="{{$stay->rate_per_night}}" placeholder="Rate per night" required>
                            </td>
                            <td>
                              <input type="number" name="stay[da][]" class="form-control amount_to_be stayda cal_value da_class da" min="0" value="{{$stay->da}}" placeholder="DA" required autocomplete="off">
                            </td>
                            <td>
                              @if($loop->iteration == 1)
                                <a href="javascript:void(0);" data-type="stay" data-claimid="{!! $claims->id !!}" data-id="{!! $stay->id !!}" onclick="addMoreStay()">
                                  <i class="fa fa-plus addtravel-row @if($stayCheck == true) red @endif"></i>
                                </a>
                              @else
                                <a href="javascript:void(0);" onclick="removeTr($(this))" class="remtravel" data-type="stay" data-claimid="{!! $claims->id !!}" data-id="{!! $stay->id !!}">
                                  <i class="fa fa-minus remtravel-row @if($stayCheck == true) red @endif"></i>
                                </a>
                              @endif
                            </td>
                          </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </fieldset>
              @endif

              <br>

              @php
                $fileAbsolutePath = \Config::get('constants.uploadPaths.claimDocument');
                $filePath = asset('public') . \Config::get('constants.uploadPaths.claimDocumentPath');
              @endphp
              <fieldset>
                <legend>Upload Supporting Documents:</legend>
                <div class="col-md-12 table-responsive no-padding">
                  <table id="travelAttachmentTable" class="table table-bordered table-striped travel-table-inner" style="height:150px;">
                    <thead class="table-heading-style">
                      <tr>
                        <th>Type of Attachment</th>
                        <th>Name</th>
                        <th>Choose Attachment</th>
                        <th>Add/Remove</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($claims->claim_attachments as $ca)
                        @php
                          $attachmentCheck = false; $attachmentTrClass = null;
                          if(in_array($ca->status, ['back'])) {
                            $attachmentCheck = true; $attachmentTrClass = 'tr-danger';
                          }
                        @endphp

                        <tr class="{!! $attachmentTrClass !!}">
                          <td>
                            <input type="hidden" name="attachment[id][]" value="{!! $ca->id !!}">

                            <select name="attachment[attachment_type][]" class="form-control travel-table-input-style travel-only-inputss" required>
                              <option value="">Select</option>
                              @foreach($conveyances as $conveyance)
                                @php $selectCoveyanceAttachment = null @endphp
                                @if($conveyance->id == $ca->attachment_types->id)
                                  @php $selectCoveyanceAttachment = 'selected="selected"'; @endphp
                                @endif

                                <option value="{{$conveyance->id}}" {{ $selectCoveyanceAttachment }}>{{$conveyance->name}}</option>
                              @endforeach
                            </select>
                          </td>
                          <td>
                            <input type="text" name="attachment[name][]" class="form-control travel-table-input-style travel-only-inputss" value="{{$ca->name}}" required>
                          </td>
                          <td>
                            <input type="file" name="attachment[attachment][]" class="chooseAttachment-travel @if(!empty($ca->attachment)) pull-left @endif" accept="image/*,.doc,.docx,application/pdf,application/vnd.ms-excel,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document" @if(empty($ca->attachment)) required @endif>

                            @if(!empty($ca->attachment) && file_exists($fileAbsolutePath . $ca->attachment))
                              <a href="{!! $filePath . $ca->attachment !!}" target="_blank" class="btn btn-xs btn-success pull-right">
                                Attachment
                              </a>
                            @endif
                          </td>
                          <td class="text-center">
                            @if($loop->iteration == 1)
                              <a href="javascript:void(0);" class="add-attachment" data-type="attachment" data-claimid="{!! $claims->id !!}" data-id="{!! $ca->id !!}">
                                <i class="fa fa-plus addtravel-row @if($attachmentCheck == true) red @endif"></i>
                              </a>
                            @else
                              <a href="javascript:void(0);" onclick="removeTr($(this))" class="remove-attachment" data-type="attachment" data-claimid="{!! $claims->id !!}" data-id="{!! $ca->id !!}">
                                <i class="fa fa-minus remtravel-row @if($attachmentCheck == true) red @endif"></i>
                              </a>
                            @endif
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </fieldset>

              <fieldset>
                <legend>&nbsp;</legend>
                <div class="form-group">
                  <label for="comments" class="control-label">Comments:</label>
                  <div class="three-icon-box display-inline-block">
                    @if(!$claims->comments->isEmpty() && $claims->comments->count() > 0)
                      <div class="info-tooltip cursor-pointer get-comments" data-id="{!! $claims->id !!}">
                        <a href="javascript:void(0)">
                          <small>
                            View ({{ $claims->comments->count() }}) Comments
                          </small>
                        </a>
                        <span class="info-tooltiptext">Click here to see previous comments.</span>
                      </div>
                    @else
                      <small>No Previous Comments Found.</small>
                    @endif
                  </div>
                  <div class="">
                    <textarea name="comments" id="comments" cols="30" rows="4" class="form-control"></textarea>
                  </div>
                </div>
              </fieldset>

              <hr/>

              <div class="row">
                <div class="col-md-12 text-center">
                  <input type="submit" name="update_btn" class="btn btn-success btn-submit" value="Update">
                </div>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
        </form>
        <!-- /.box -->
      </div>
    </div>
    <!-- /.row -->
    <!-- Main row -->
  </section>
  <!-- /.content -->
</div>
<div class="hide" id="cloneit">
  <table id="tobecloned">
    <tr class="">
      <td>
        <input type="text" name="travel_expense[date][]" class="form-control selectDate travel-table-input-style travel-only-inputss travel-input2 travelDate" placeholder="MM/DD/YYYY" onkeypress="return false;" autocomplete="off" required>
      </td>
      <td>
        <select name="travel_expense[from_location][]" class="form-control travel-input6 travel-table-input-style travel-only-inputss from_location" required>
          <option value="">Select</option>
          @foreach($cities as $cK => $city)
          <option value="{{$city->id}}">{{$city->name}}</option>
          @endforeach
        </select>
      </td>
      <td>
        <select name="travel_expense[to_location][]" class="form-control travel-input6 travel-table-input-style travel-only-inputss to_location" required>
          <option value="">Select</option>
          @foreach($cities as $tK => $city)
            <option value="{{$city->id}}">{{$city->name}}</option>
          @endforeach
        </select>
      </td>
      <td>
        <select name="travel_expense[expense_type][]" class="form-control travel-input6 travel-table-input-style travel-only-inputss expense_type" required>
          <option>Select</option>
          @foreach($conveyances as $conveyance)
            <option value="{{$conveyance->id}}" data-islocal="{{$conveyance->islocal}}" data-price_per_km="{{$conveyance->price_per_km}}">
              {{$conveyance->name}}
              @if($conveyance->price_per_km > 0)
                [{{ moneyFormat($conveyance->price_per_km) }}/k.m]
              @endif
            </option>
          @endforeach
        </select>
      </td>
      <td>
        <!-- distance_in_km -->
        <input type="number" name="travel_expense[distance_in_km][]" class="form-control input-sm basic-detail-input-style distance_in_km" value="0" min="0" required readonly autocomplete placeholder="Distance(k.m)">
      </td>
      <td>
        <input type="text" name="travel_expense[description][]" class="form-control travel-input3 travel-table-input-style travel-only-inputss" required>
      </td>
      <td>
        <input type="number" name="travel_expense[amount][]" class="form-control travel-input5 travel-table-input-style travel-only-inputss amount_to_be cal_value" value="0" max="20000" min="1" required placeholder="330">
      </td>
      <td class="text-center">
        <a href="javascript:void(0);" onclick="removeTr($(this))" class="remtravel">
          <i class="fa fa-minus remtravel-row"></i>
        </a>
      </td>
    </tr>
  </table>

  <!-- Appended rows for Stay starts here-->
  <table>
    <tr id="city_tr" class="removetr city_tr">
      <td>
        <input type="text" name="stay[date_from][]" class="form-control selectDate stay_date_from" value="" readonly required placeholder="MM/DD/YYYY" autocomplete="off" style="width: 200px;">
      </td>
      <td>
        <input type="text" name="stay[date_to][]" class="form-control selectDate stay_date_to" value="" readonly required placeholder="MM/DD/YYYY" autocomplete="off" style="width: 200px;">
      </td>
      <td>
        <select name="stay[state_id][]" class="form-control state_id_stay state" onchange="displayCity($(this), 3);" required style="width: 120px">
          <option value="">Select state</option>
          @if(!$states->isEmpty())
            @foreach($states as $state)
              <option value="{{$state->id}}">{{$state->name}}</option>
            @endforeach
          @endif
        </select>
      </td>
      <td>
        <select name="stay[city_id][]" id="cityId3" class="form-control city_select city_id_stay" onchange="GetCityDetails($(this))" required style="width: 120px">
          <option value="">Select City</option>
        </select>
      </td>
      <td>
        <input type="number" name="stay[rate_per_night][]" class="form-control stayda amount_to_be cal_value rate_per_night" min="0" value="0" placeholder="Rate per night" required>
      </td>
      <td>
        <input type="number" name="stay[da][]" class="form-control amount_to_be cal_value stayda da_class da" min="0" value="0" placeholder="DA" required autocomplete="off">
      </td>
      <td>
        <a href="javascript:void(0);" onclick="removeTr($(this))">
          <i class="fa fa-minus remtravel-row"></i>
        </a>
      </td>
    </tr>
  </table>

  <!-- Appended rows for national ends here -->
  <table id="attachment_table">
    <tr>
      <td>
        <select name="attachment[attachment_type][]" class="form-control travel-table-input-style travel-only-inputss" required>
          <option>Select</option>
          @foreach($conveyances as $conveyance)
            <option value="{{$conveyance->id}}">{{$conveyance->name}}</option>
          @endforeach
        </select>
      </td>
      <td>
        <input type="text" name="attachment[name][]" class="form-control travel-table-input-style travel-only-inputss" required>
      </td>
      <td>
        <input type="file" name="attachment[attachment][]" class="chooseAttachment-travel" accept="image/*,.doc,.docx,application/pdf,application/vnd.ms-excel,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document" required>
      </td>
      <td class="text-center">
        <a href="javascript:void(0);" onclick="removeTr($(this))" class="remove-attachment">
          <i class="fa fa-minus remtravel-row"></i>
        </a>
      </td>
    </tr>
  </table>
</div>

<script src="{{asset('public/admin_assets/plugins/timepicker/bootstrap-timepicker.min.js')}}"></script>
<script src="{{asset('public/admin_assets/plugins/sweetalert/sweetalert.min.js')}}"></script>
<script src="{{asset('public/admin_assets/plugins/validations/jquery.validate.js')}}"></script>
<script src="{{asset('public/admin_assets/plugins/validations/additional-methods.js')}}"></script>
<script src="{{asset('public/admin_assets/plugins/jquery-toast/jquery.toast.min.js')}}"></script>

<script type="text/javascript">

$('body').on('focus',".selectDate", function(){
  $(this).datepicker({
    //startDate: minimumDate,
    /*endDate: '< ?php echo date('m/d/Y'); ?>',*/
    autoclose: true,
    orientation: "bottom"
  });
});

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

  $(document).on('click', '.addtravel', function() {
    var travel_expense_length = $("#travelExpenseTable tr").length;
    if(travel_expense_length <= 15) {
      if($('#travelExpenseTable input, #travelExpenseTable select').valid()) {
        date_id=$(".selectDate").length+1;
        $("#travelExpenseTable").append($("#tobecloned tr").clone());
        initDaterangepickers();
      }
    } else {
      $.toast({
        heading: 'Error',
        text: 'You have reached the maximum length allowed.',
        showHideTransition: 'plain',
        icon: 'error',
        hideAfter: 3000,
        position: 'top-right',
        stack: 2,
        loader: true,
        loaderBg: '#b50505',
      });
      return false;
    }
  });

  $(document).on('click', '.add-attachment', function() {
    var travel_attachment_length = $("#travelAttachmentTable tr").length;
    if(travel_attachment_length <= 20) {
      if($('#travelAttachmentTable input, #travelAttachmentTable select').valid()) {
        $("#travelAttachmentTable").append($("#attachment_table tr").clone());
      }
    } else {
      $.toast({
        heading: 'Error',
        text: 'You have reached the maximum length allowed.',
        showHideTransition: 'plain',
        icon: 'error',
        hideAfter: 3000,
        position: 'top-right',
        stack: 2,
        loader: true,
        loaderBg: '#b50505',
      });
      return false;
    }
  });

  initDaterangepickers();

  $("#claim-form").validate({
    ignore: ':hidden,input[type=hidden],.select2-search__field', //  [type="search"]
    errorElement: 'span',
    errorPlacement: function(error, element) {
      if (element.attr("name") == "isclient") {
        error.appendTo(".travel-input-box-client");
      }
      else if (element.hasClass('select2')) {
        error.insertAfter(element.next('span.select2'));
      }
      else if (element.is(":radio")) {
        error.insertAfter(element.parent().next());
      }
      else {
        error.appendTo(element.parent()); // error.insertAfter(element);
      }
    },
    rules :{
      "travel_expense[date][]" : {
        required : true,
      },
      "travel_expense[from_location][]" : {
        required : true,
      },
      "travel_expense[to_location][]" : {
        required : true,
      },
      "travel_expense[expense_type][]" : {
        required : true,
      },
      "travel_expense[description][]" : {
        required : true,
      },
      "travel_expense[amount][]" : {
        required : true,
      },
      "stay[state_id][]" : {
        required : true,
      },
      "stay[city_id][]" : {
        required : true,
      },
      "stay[rate_per_night][]" : {
        required : true,
      },
      "stay[da][]" : {
        required : true,
      },
      "attachment[attachment_type][]" : {
        required : true,
      },
      "attachment[name][]" : {
        required : true,
      },
      /*"attachment[attachment][]" : {
        required : true,
      },*/
    },
    messages :{
      "travel_expense[date][]" : {
        required : "Please select date.",
      },
      "travel_expense[from_location][]" : {
        required : "Please select from city.",
      },
      "travel_expense[to_location][]" : {
        required : "Please select to city.",
      },
      "travel_expense[expense_type][]" : {
        required : "Please select expense type.",
      },
      "travel_expense[description][]" : {
        required : "Please enter description.",
      },
      "travel_expense[amount][]" : {
        required : "Please enter amount.",
      },
      "stay[date_from][]" : {
        required : "Please select from date.",
      },
      "stay[date_to][]" : {
        required : "Please select to date.",
      },
      "stay[state_id][]" : {
        required : "Please select state.",
      },
      "stay[city_id][]" : {
        required : "Please select city.",
      },
      "stay[rate_per_night][]" : {
        required : "Please enter rate per night.",
      },
      "stay[da][]" : {
        required : "Please enter da amount.",
      },
      "attachment[attachment_type][]" : {
        required : "Please select attachment type.",
      },
      "attachment[name][]" : {
        required : "Please enter attachment name.",
      },
      /*"attachment[attachment][]" : {
        required : "Please select attachment.",
      },*/
    }
  });

/*================== Date Validation Starts Here ==================================*/
                  /*stay_date_from, stay_date_to*/
  $('#claim-form input.stay_date_from').each(function(k, v) {
    $(v).rules('add', {
      required: true,
      date: true,
    });
  });

  $('#claim-form input.stay_date_to').each(function(k, v) {
    $(v).rules('add', {
      required: true,
      date: true,
    });
  });

  $(document).on('change', '#claim-form input.stay_date_from', function() {
    let trObj = $(this).parents('tr');

    let fromDate = trObj.find('input[name="stay[date_from][]"]').val();
    let toDate = trObj.find('input[name="stay[date_to][]"]').val();

    if (toDate === "") {
      return true;
    }

    if(new Date(fromDate) > new Date(toDate)) {
      $(this).val('');

      $.toast({
        heading: 'Error',
        text: 'Must be greater than or equals to "To date.',
        showHideTransition: 'plain',
        icon: 'error',
        hideAfter: 3000,
        position: 'top-right', 
        stack: 2, 
        loader: true,
        loaderBg: '#b50505',
      });
      return false;
    }
  });

  $(document).on('change', '#claim-form input.stay_date_to', function() {
    let trObj = $(this).parents('tr');

    let fromDate = trObj.find('input[name="stay[date_from][]"]').val();
    let toDate = trObj.find('input[name="stay[date_to][]"]').val();

    if (fromDate === "") {
      return true;
    }

    if(new Date(fromDate) > new Date(toDate)) {
      $(this).val('');

      $.toast({
        heading: 'Error',
        text: 'Must be greater than or equals to "From date.',
        showHideTransition: 'plain',
        icon: 'error',
        hideAfter: 3000,
        position: 'top-right', 
        stack: 2, 
        loader: true,
        loaderBg: '#b50505',
      });
      return false;
    }
  });
/*================== Date Validation Ends Here ====================================*/

  $(document).on('change', '.expense_type', function() {
    var _val         = $(this).val();
    var _option      = $(this).find('option:selected');
    var islocal      = _option.data('islocal');
    var price_per_km = parseFloat(_option.data('price_per_km'));

    $(this).parents('tr').find('input.distance_in_km').val(0);
    $(this).parents('tr').find('input.amount_to_be').val(0);
    if(islocal == 1 && price_per_km > 0) {
      $(this).parents('tr').find('input.distance_in_km').removeAttr('readonly');
      $(this).parents('tr').find('input.amount_to_be').attr('readonly', true);
    } else {
      $(this).parents('tr').find('input.distance_in_km').attr('readonly', true);
      $(this).parents('tr').find('input.amount_to_be').removeAttr('readonly');
    }
  });

  $(document).on('change', '.distance_in_km', function() {
    var _val       = $(this).val();
    var conveyance = $(this).parents('tr').find('select.expense_type').find('option:selected');
    var price_per_km = parseFloat(conveyance.data('price_per_km'));
    var new_val    = parseFloat(_val * price_per_km);
    $(this).parents('tr').find('input.amount_to_be').val(new_val);
    
    calculateTotalAmount();
  });

  $(document).on('change', '.amount_to_be', function() {
    var val = 0;
    $('.amount_to_be').each(function() {
      if($(this).hasClass('cal_value') && parseFloat($(this).val()) == $(this).val()) {
        val += parseFloat($(this).val());
      }
    });
    $('input.total_claim_amount').val(val.toFixed(2));
  });

  $(document).on('click', "#claim-form .btn-submit", function (evnt) {
    evnt.preventDefault(); evnt.stopPropagation();

    if($("#claim-form").valid()) {
      var total_travel_amount = parseFloat($('input.total_travel_amount').val());
      var total_claim_amount  = parseFloat($('input.total_claim_amount').val());
      if(total_claim_amount > total_travel_amount) {
        $.toast({
          heading: 'Error: Claim amount exceeds.',
          text: 'Total Claim amount should not be greater then the pre approval amount.',
          showHideTransition: 'plain',
          icon: 'error',
          hideAfter: 3000,
          position: 'top-right',
          stack: 2,
          loader: true,
          loaderBg: '#b50505',
        });
        return false;
      } else {
        $("#claim-form").submit();
      }
    }
  });

  $(document).on('click', '.get-comments', function(event) {
    event.preventDefault();  event.stopPropagation();
    getComments($(this));
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

  function calculateTotalAmount()
  {
    var val = 0;
    $('.amount_to_be').each(function(k, v) {
      if($(v).hasClass('cal_value') && parseFloat($(v).val()) >= 0) {
        val += parseFloat($(v).val());
      }
    });
    $('input.total_claim_amount').val(val.toFixed(2));
  }

  function addMoreStay() {
    var tbody_length = $("#tbody tr").length;

    if(tbody_length <= 15) {
      if($('#tbody input, #tbody select').valid()) {
        $("#cloneit table .removetr").clone().appendTo('#tbody');
        initDaterangepickers();
      }
    } else {
      $.toast({
        heading: 'Error',
        text: 'You have reached the maximum length allowed.',
        showHideTransition: 'plain',
        icon: 'error',
        hideAfter: 3000,
        position: 'top-right',
        stack: 2,
        loader: true,
        loaderBg: '#b50505',
      });
      return false;
    }
  }

  function initDaterangepickers() {
    var minimumDate = '{{ date('m/d/Y', strtotime('previous month')) }}';
    var maximumDate = '{{ date('m/d/Y') }}';

    //Date picker
    $(".travelDate").datepicker({
      /*format: "MM/DD/YYYY",*/
      // startDate: '-1m',
      // minDate: minimumDate,
      // endDate: maximumDate, /*'< ? php echo date('m/d/Y'); ?>'*/
      autoclose: true,
      orientation: "bottom"
    });

    $('.selectDateRange').daterangepicker({
      //startDate: 'date("m/d/Y", strtotime($date_from))}}',
      //endDate  : 'date("m/d/Y", strtotime($date_to))}}',
      autoUpdateInput: false,
      locale: {
        cancelLabel: 'Clear'
      }
    }, function (start, end) {}).on('apply.daterangepicker', function(ev, picker) {
      $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
    }).on('cancel.daterangepicker', function(ev, picker) {
      $(this).val('');
    });
  }

  function GetCityDetails(obj)
  {
    var cityId  = obj.val();
    var _bandId = '{{ $bandId }}';

    if(cityId != '') {
      $.ajax({
        type: 'POST',
        url: "{{ url('employees/band-city') }} ",
        data: {city: obj.val(), band: _bandId},
        success: function(result){
          //$("#rate_per_night").attr('max',result.city_class[0].pivot.price);
          //$("#da").attr('max',result.food_allowance);
          obj.parents('.city_tr').find('.rate_per_night').attr({'max':result.city_class[0].pivot.price, 'placeholder':"Rate/might max "+result.city_class[0].pivot.price});
          obj.parents('.city_tr').find('.da_class').attr({'placeholder':" DA max "+result.food_allowance, "max": result.food_allowance});
        }
      });
    }
  }

  function displayCity(obj, no)
  {
    var stateId = obj.val();
    var displayString = '<option value="">Select city</option>';

    if(stateId != '') {
      var stateIds = [];
      stateIds.push(stateId);
      obj.parents('.form-group, .city_tr').children().find(".city_select").empty();

      $.ajax({
        type: 'POST',
        url: "{{ url('employees/states-wise-cities') }} ",
        data: {stateIds: stateIds},
        success: function(result){
          if(result.length != 0){
            result.forEach(function(city){
              displayString += '<option value="'+city.id+'">'+city.name+'</option>';
            });
          }else{
            displayString += '<option value="" selected disabled>None</option>';
          }
          //$('#cityId'+no).append(displayString);
          obj.parents('.form-group, .city_tr').children().find(".city_select").html(displayString);
        }
      });
    } else {
      obj.parents('.form-group, .city_tr').children()
      .find(".city_select").html(displayString);
    }
  }

  function removeTr(obj) {

    if(typeof $(obj).data('type') != 'undefined')
    {
      var type     = $(obj).data('type'); // expense, stay, attachment
      var claimid  = $(obj).data('claimid');
      var data_id  = $(obj).data('id');
      var _token   = '{!! csrf_token() !!}';

      var objdata = {
        '_token': _token, 'type': type, 'claimid': claimid, 'data_id': data_id,
      };

      swal({
        title: "Are you sure?",
        text: "You want to delete this, You will not be able to recover this record!",
        icon: "warning",
        buttons: [
          'No, cancel it!',
          'Yes, I am sure!'
        ],
        dangerMode: true,
      }).then(function(isConfirm) {

        if (isConfirm) {

          $.ajax({
            url: "{!! url('travel/delete/claim') !!}",
            type: "POST",
            data: objdata,
            dataType: 'json',
            success: function (res) {

              if(res.status == 1) {
                swal("Done!", res.msg, "success");

                obj.parent().parent().remove();

                calculateDsaAmount();
              } else {
                swal("Error:", res.msg, "error");
              }
            },
            error: function (xhr, ajaxOptions, thrownError) {
              var xhrRes = xhr.responseJSON;

              if(xhrRes.status == 401) {
                swal("Error Code: " + xhrRes.status, xhrRes.msg, "error");
              } else {
                swal("Error deleting!", "Please try again", "error");
              }
            }
          });
        }
      });
    } else {
      obj.parent().parent().remove();
    }
  }
</script>
@endsection