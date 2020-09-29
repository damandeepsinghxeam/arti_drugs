@extends('admins.layouts.app')

@section('content')
  <link href="{!! asset('public/admin_assets/plugins/jquery-toast/jquery.toast.min.css') !!}" rel="stylesheet">

<style>
.viewTilTable tr td:first-child {
    font-weight: 600;
}
</style>
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

            <!-- Check this php code where it should placed  -->
            @php 
              $businessTypeArr = [
                1 => 'Govt. Business', 2 => 'Corporate Business', 3 => 'International Business'
              ];
            @endphp
            <!-- Check this php code where it should placed  -->
            
            <div class="row">
              <div class="col-md-6">
                <table class="table table-bordered table-striped viewTilTable">
                  <thead class="table-heading-style">
                    <tr>
                      <th style="width: 30%;">Form</th>
                      <th style="width: 70%;">Value</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>Tender Owner:</td>
                      <td>
                        {!! (!empty($tilDraft->tender_owner))? $tilDraft->tender_owner : '--' !!}
                      </td>
                    </tr>
                    <tr>
                      <td>Location:</td>
                      <td>
                        {!! (!empty($tilDraft->tender_location))? $tilDraft->tender_location : '--' !!}
                      </td>
                    </tr>
                    <tr>
                      <td>Contact Person detail:</td>
                      <td>
                        <a href="#" data-toggle="modal" data-target="#add_contact_details">
                          View Details
                        </a>
                      </td>
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
                      <td>
                        {!! ucfirst($tilDraft->bid_system) !!}
                      </td>
                    </tr>
                    <tr>
                      <td>Bid System Clause:</td>
                      <td>
                        {!! (!empty($tilDraft->bid_system_clause))? nl2br($tilDraft->bid_system_clause) : '--' !!}
                      </td>
                    </tr>
                    <tr>
                      <td>Tenure: <small>(In Months)</small></td>
                      <td>
                        @if(!empty($tilDraft->tenure_one))
                          {!! $tilDraft->tenure_one !!} Months
                        @else 
                          --
                        @endif
                      </td>
                    </tr>
                    <tr>
                      <td>Tenure Extension: <small>(If applicable)</small></td>
                      <td>
                        @if(!empty($tilDraft->tenure_two))
                          {!! $tilDraft->tenure_two !!} Months
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
                        $paymentTermArr = [1 => 'Pay & Collect', 2 => 'Collect & Pay'];
                        // pay_and_collect, collect_and_pay, payAndCollectOptions, collectAndPayOptions
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
                        @if(!$tilDraft->tilDraftPenalties->isEmpty())
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
                      <td>Value of work: <small>(In Lakhs)</small></td>
                      <td>
                        {!! (!empty($tilDraft->value_of_work))? moneyFormat($tilDraft->value_of_work) : '--' !!}
                      </td>
                    </tr>
                    <tr>
                      <td>Volume:</td>
                      <td>
                        {!! (!empty($tilDraft->volume))? moneyFormat($tilDraft->volume) : '--' !!}
                      </td>
                    </tr>
                    <tr>
                      <td>Scope of work:</td>
                      <td>
                        {!! (!empty($tilDraft->scope_of_work))? nl2br($tilDraft->scope_of_work) : '--' !!}
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="col-md-6">
                <table class="table table-bordered table-striped viewTilTable">
                  <thead class="table-heading-style">
                    <tr>
                      <th style="width: 30%;">Form</th>
                      <th style="width: 70%;">Value</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>Special Eligibility Clause:</td>
                      <td>
                        @if(!empty($tilDraft->tilSpecialEligibility)) 
                        @foreach($tilDraft->tilSpecialEligibility as $eKey => $eligibility)
                        <span>{!! $eligibility->special_eligibility !!}</span>
                        @endforeach
                        @else 
                        --
                        @endif
                      </td>
                    </tr>
                    <tr>
                      <td>Technical Qualification:</td>
                      <td>
                        @if(!$tilDraft->tilTechnicalQualification->isEmpty())
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
                        @else 
                        --
                        @endif

                        @if(!$tilDraft->tilObligation->isEmpty() && !empty($tilDraft->obligation_id))
                        @foreach($tilDraft->tilObligation as $oKey => $obligation)
                        <p>{!! $obligation->obligation !!}</p>
                        @endforeach
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
              $statusArr = [
                1 => 'New', 2 => 'Open', 3 => 'Complete',
                4 => 'Sent for Remarks', 5 => 'Sent For Approval',
                6 => 'Rejected by Hod',  7 => 'Abandoned', 
                8 => 'Closed'
              ];
            @endphp
            @if(in_array($tilDraft->status, [5, 6]))
              <form id="view-til-form" class="form-vertical" action="{{ route('leads-management.til-approval') }}" method="POST">
                @csrf()
                  <div class="row"><div class="col-md-12"><hr/></div></div>
                      
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="form-group col-md-12">
                        <div class="col-md-12">
                          <input type="hidden" name="til_id" value="{!! $tilDraft->id !!}">
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

                          <div class="">
                            <textarea name="comments" id="comments" cols="30" rows="4" class="form-control" required></textarea>
                            <input type="hidden" name="status" value="{!! $tilDraft->status !!}">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- /.box-body -->
                  <div class="box-footer text-center">
                    <div class="col-md-12">
                      <button type="submit" class="btn btn-danger reject-btn">Reject</button>
                      <button type="submit" class="btn btn-warning m-l-10 sendback-btn">Send Back</button>
                      <button type="submit" class="btn btn-primary m-l-10 approve-btn">Approve</button>
                    </div>
                  </div>
              </form>
              @else
                <div class="row"><div class="col-md-12"><hr/></div></div>

                <div class="row">
                  <div class="col-sm-12">
                    <div class="form-group col-md-12">
                      <div class="col-md-12">
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
                <!-- /.box-body -->
                <div class="box-footer">
                  <div class="col-md-12">
                    <a href="{!! route('leads-management.get-list-til') !!}" class="btn btn-default m-l-10">Back</a>
                  </div>
                </div>
            @endif
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
@endsection

@section('script')
<script src="{!! asset('public/admin_assets/plugins/sweetalert/sweetalert.min.js') !!}"></script>
<script src="{{asset('public/admin_assets/plugins/validations/jquery.validate.js')}}"></script>
<script src="{{asset('public/admin_assets/plugins/validations/additional-methods.js')}}"></script>
<script src="{!! asset('public/admin_assets/plugins/jquery-toast/jquery.toast.min.js') !!}"></script>

<script type="text/javascript">
$(document).ready(function() {

  $(document).on('click', '.get-comments', function(event) {
    event.preventDefault();  event.stopPropagation();
    getComments($(this));
  });

  $(document).on('click', '.reject-btn', function(event) {
    event.preventDefault();  event.stopPropagation();

    if($('#view-til-form').valid()) {
      swal({
        closeOnClickOutside: false,
        closeOnEsc: false,
        title: "Are you sure?",
        text: "You want to reject this til. You will not be able to edit this.",
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
          $('input[name="status"]').val(7);
          $('#view-til-form').submit();
        }
      });
    }
  });

    $(document).on('click', '.sendback-btn', function(event) {
    event.preventDefault();  event.stopPropagation();

    if($('#view-til-form').valid()) {
      swal({
        closeOnClickOutside: false,
        closeOnEsc: false,
        title: "Are you sure?",
        text: "You want to send back this til. You will not be able to edit this.",
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
          $('input[name="status"]').val(3);
          $('#view-til-form').submit();
        }
      });
    }
  });

  $(document).on('click', '.approve-btn', function(event) {
    event.preventDefault();  event.stopPropagation();
    var statusVal = $('input[name="status"]').val();

    statusVal = (statusVal == 5)? 8 : 2;

    if($('#view-til-form').valid()) {
      $('input[name="status"]').val(statusVal);
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
</script>
@endsection