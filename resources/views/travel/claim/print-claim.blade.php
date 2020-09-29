<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Travel Claim Form</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" type="image/png" href="{{asset('public/admin_assets/static_assets/xeam-favicon.png')}}">
  <!-- Bootstrap 3.3.7 -->
  <link href="{{asset('public/admin_assets/bower_components/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="{{asset('public/admin_assets/bower_components/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
  <!--my main css-->
  <link href="{!! asset('public/admin_assets/plugins/jquery-toast/jquery.toast.min.css') !!}" rel="stylesheet">
  <!-- <link href="{ !! asset('public/admin_assets/dist/css/cost_estimation_sheet.css') !!}" rel="stylesheet"> -->
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('public/admin_assets/dist/css/AdminLTE.css')}}">
  <!-- <link rel="stylesheet" href="css/mystyle.css"> -->
  <!--google fonts link-->
  <link href="https://fonts.googleapis.com/css?family=Be+Vietnam&display=swap" rel="stylesheet">
  <!--jquery script-->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="{{asset('public/admin_assets/bower_components/moment/min/moment.min.js')}}"></script>
  <!-- Bootstrap 3.3.7 -->
  <script src="{{asset('public/admin_assets/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>

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
</head>
<body>
<!--Main outer container starts here-->
<div class="wrapper">
  <!-- <h1>Cost Estimation Sheet</h1> -->
  @include('admins.validation_errors')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper1">
    <!-- Content Header (Page header) -->
    <section class="content-header1">
      <h1>Travel Claim Details:</h1>
    </section>
    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            @include('admins.validation_errors')
            <h2 class="travel-expense-title2">
              <legend>Claim Code -: {{ $claims->claim_code }}</legend>
            </h2>
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
                            <td class="text-right {{ $tAmountClass }}">
                              {{moneyFormat($cd->amount)}}
                            </td>
                          </tr>
                        @endforeach
                        <tr>
                          <td colspan="7" class="text-bold">Total</td>
                          <td class="text-right text-bold">{{moneyFormat($amountTotal)}}</td>
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
                            </tr>
                          @endforeach
                          <tr>
                            <td colspan="4" class="text-bold">Total</td>
                            <td class="text-right text-bold" >{{moneyFormat($ratePerNightTotal)}}</td>
                            <td class="text-right text-bold" >{{moneyFormat($daTotal)}}</td>
                            <td class="text-right text-bold" >{{moneyFormat($totalStay)}}</td>
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
                          </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </fieldset>
              </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>
      <!-- /.row -->
      <!-- Main row -->
    </section>
  </div>

</div>
<!--Main outer container ends here-->
<!-- /.content -->
<!-- /.content-wrapper -->
<script src="{{ asset('public/admin_assets/plugins/jquery-toast/jquery.toast.min.js') }}"></script>
<script src="{!! asset('public/admin_assets/plugins/sweetalert/sweetalert.min.js') !!}"></script>
<script src="{!! asset('public/admin_assets/plugins/validations/jquery.validate.js') !!}"></script>
<script src="{!! asset('public/admin_assets/plugins/validations/additional-methods.js') !!}"></script>
<script>
  $(document).ready(function() {
    setTimeout(function () {
      window.print();
    }, 500);
  });
</script>
</body>
</html>