@extends('admins.layouts.app')
@section('content')

<link href="{{asset('public/admin_assets/plugins/dataTables/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{asset('public/admin_assets/plugins/jquery-toast/jquery.toast.min.css')}}" rel="stylesheet">
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>View Travel Approval Requests</h1>
    <ol class="breadcrumb">
      <li><a href="{{ url('employees/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="{{ url('travel/approval-requests') }}"><i class="fa fa-sitemap"></i> Travel Approval Requests</a></li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary">
          @include('admins.validation_errors')
          <h2 class="travel-expense-title2">
            <legend>
              {{$approval->user->employee->salutation}}
              {{$approval->user->employee->fullname}}
            </legend>
          </h2>
          <h2 class="travel-expense-title2">
            <legend>Travel Details -: {{ $approval->travel_code }}</legend>
          </h2>
          <h4 class="p-w-xs">
            @if(empty($approval->claims) && $approval->travelClimber->isEmpty() && $approval->user_id == auth()->user()->id)
              <small>
                <a href="{{url('travel/approval-request-change/'.encrypt($approval->id))}}" class="btn btn-xs btn-primary">Edit Request</a>
              </small>
            @elseif(empty($approval->claims) && $approval->user_id == auth()->user()->id)
              <small>
                <a href="javascript:void(0)" class="btn btn-xs btn-primary change-request" data-id="{{$approval->id}}" data-encyriptedid="{{encrypt($approval->id)}}">Request Change</a>
              </small>
            @endif
          </h4>
          <div class="row">
            <div class="box-body">
              <div class="col-md-12">
                <table class="table table-bordered table-striped">
                  <tr>
                    <td>Travel Category: {{ $approval->travel_category->name }}</td>
                    <td>&nbsp;</td>
                  </tr>
                  <!-- travel_for [1 => Existing Client, 2 => Prospect, 3 => Others] -->
                  @if(in_array($approval->travel_category->name, ['BD', 'SD']))
                    @php
                      $projectTextArr = [1 => 'Existing Client', 2 => 'Prospect', 3 => 'Others'];

                      $projectText = '--';
                      if(isset($projectTextArr[$approval->travel_for])) {
                        $projectText = $projectTextArr[$approval->travel_for];
                      }

                      $project = $approval->others;
                    @endphp
                    @if($approval->travel_for == 1)
                      @php $project = $approval->project->name; @endphp
                    @elseif($approval->travel_for == 2)
                      @php $project = $approval->tils->til_code; @endphp
                    @endif
                    <tr>
                      <td>For {{ $projectText }}: {{$project}}</td>
                      <td>&nbsp;</td>
                    </tr>
                  @endif

                  <tr>
                    <td colspan="2">Purpose: {{$approval->travel_purpose}}</td>
                  </tr>

                  @php $grand_total = 0 @endphp
                  @if($approval->travel_type == 1 && $approval->travelLocal->count())
                  @php
                    $grand_total = $approval->travelLocal->travel_amount;
                  @endphp
                  <tr>
                    <td>Local conveyance: {{$approval->travelLocal->conveyance->name}}</td>
                    <td>Local conveyance amount: {{moneyFormat($approval->travelLocal->travel_amount)}}</td>
                  </tr>
                  @endif

                  <tr>
                    <td colspan="2">Under Policy: @if($approval->cover_under_policy) Yes @else No @endif</td>
                  </tr>

                  @php $nationalTotal = 0; @endphp
                  @if($approval->travel_type == 2 && $approval->travelNational->count())
                    <tr>
                      <td colspan="2">
                        <legend>Itinerary</legend>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="2">
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
                        <table class="table table-bordered table-striped">
                          <thead>
                            <tr>
                              <th>S.No</th>
                              <th>Date</th>
                              <th>City (from)</th>
                              <th>City (to)</th>
                              <th>Conveyance</th>
                              <th class="text-right">Distance (in k.m)</th>
                              <th class="text-right">Expected Cost (pre approval)</th>
                              <th class="text-right">Total</th>
                            </tr>
                          </thead>
                          <tbody id="travel_national_tbody">
                            @foreach($approval->travelNational as $nKey => $national)
                              @php
                                $nationalTotal += $national->travel_amount;
                              @endphp
                              <tr>
                                <td>{{$loop->iteration}}.</td>
                                <td>{{formatDate($national->travel_date)}}</td>
                                <td>{{ $national->fromCity->name }}</td>
                                <td>{{ $national->toCity->name }}</td>
                                <td>
                                  {{ $national->conveyance->name }}
                                  @if($national->conveyance->price_per_km > 0)
                                    [{{ moneyFormat($national->conveyance->price_per_km) }}/k.m]
                                  @endif
                                </td>
                                <td class="text-right">{{ numberFormat($national->distance_in_km) }}</td>
                                <td class="text-right">{{ moneyFormat($national->travel_amount) }}</td>
                                <td class="text-right">{{ moneyFormat($national->travel_amount) }}</td>
                              </tr>
                            @endforeach
                            <tr>
                              <td colspan="7" class="text-bold">Total</td>
                              <td class="text-right text-bold" >{{moneyFormat($nationalTotal)}}</td>
                            </tr>
                            @php $grand_total += $nationalTotal; @endphp
                          </tbody>
                        </table>
                      </td>
                    </tr>
                  @endif

                  @php $total=0; @endphp
                  @if($approval->travelStay->count())
                    <tr>
                      <td colspan="2">
                        <legend>Stay Details</legend>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="2">
                        <table class="table table-bordered table-striped">
                          <thead>
                            <tr>
                              <th>S.No</th>
                              <th>Dates</th>
                              <th>City [Class] State</th>
                              <th class="text-right">
                                Rate/night - Max rate/night allowed<br/> (incl taxes)
                              </th>
                              <th class="text-right">
                                Food Expense (DA) -
                                Max Food Expense (DA) <br/>allowed
                                [ {{$approval->user->designation[0]->band->name}} ]
                              </th>
                              <th class="text-right">Total</th>
                            </tr>
                          </thead>
                          <tbody id="">
                          @foreach($approval->travelStay as $stay)
                            @php
                              $calDays = claculateNightsTwoDates($stay->from_date, $stay->to_date);
                              $calDays = ($calDays > 1)? ($calDays - 1) : $calDays;

                              $total+=$subtotal=($stay->rate_per_night*$calDays)+$stay->da;
                            @endphp
                            <tr>
                              <td>{{$loop->iteration}}.</td>
                              <td>
                                {{formatDate($stay->from_date)}} to {{formatDate($stay->to_date)}}
                              </td>
                              <td>
                                {{$stay->city->name}} [ {{$stay->city->city_class->name}} ] ({{$stay->city->state->name}})
                              </td>
                              @php
                                $band_city_class=getBandCityClassDetails($approval->user->designation[0]->band->id, $stay->city->city_class->id);
                              @endphp
                              <td class="text-right">
                                {{moneyFormat($stay->rate_per_night)}} /
                                {{moneyFormat($band_city_class->price)}}
                              </td>
                              <td class="text-right">
                                {{moneyFormat($stay->da)}} /
                                {{moneyFormat($approval->user->designation[0]->band->food_allowance)}}
                              </td>
                              <td class="text-right">{{moneyFormat($subtotal)}}</td>
                            </tr>
                            @endforeach
                            <tr>
                              <td colspan="5" class="text-bold">Total</td>
                              <td class="text-right text-bold" >{{moneyFormat($total)}}</td>
                            </tr>
                            @php $grand_total+=$total; @endphp
                          </tbody>
                        </table>
                      </td>
                    </tr>
                  @endif

                  <!-- @ if($approval->other_financial_approval && !empty($approval->otherApproval))
                    @ php $otherApproval = $approval->otherApproval; @ endphp
                    <tr>
                      <td colspan="2">
                        <legend>Other financial approvals</legend>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        For Project: { {implode(",", $otherApproval->project->pluck('name')->toArray())}}
                      </td>
                      <td>
                        City: { {$otherApproval->city->name}} ({ {$otherApproval->state->name}}, { {$otherApproval->country->name}})
                      </td>
                    </tr>
                    <tr>
                      <td colspan="2">
                        Purpose: { {$otherApproval->purpose}}
                      </td>
                    </tr>
                    <tr>
                      <td>Amount</td>
                      <td class="text-right">
                        { {moneyFormat($otherApproval->amount)}}
                        @ php $grand_total += $otherApproval->amount; @ endphp
                      </td>
                    </tr>
                  @ endif -->

                  <tr>
                    <td class="text-bold text-danger">
                      TOTAL AMOUNT FOR APPROVAL
                    </td>
                    <td class="text-right text-bold text-danger">
                      {{moneyFormat($grand_total)}}
                    </td>
                  </tr>

                  @if($approval->imprest_request && !empty($approval->imprest))
                    <tr>
                      <td colspan="2"><legend>Imprest</legend></td>
                    </tr>
                    <tr>
                      <td>For project: {{implode(",", $approval->imprest->project->pluck('name')->toArray())}}</td>
                      <td class="text-right">Imprest amount: {{moneyFormat($approval->imprest->amount)}}</td>
                    </tr>
                    <tr>
                      <td colspan="2">Remarks: {{$approval->imprest->remarks_by_applicant}}</td>
                    </tr>
                  @endif

                  @if(!in_array($approval->status, ['approved', 'discarded']) && auth()->user()->can('approve-travel') && (empty($approval->travelClimberUser) || in_array(@$approval->travelClimberUser->status, ['new', 'discussion'])) && $approval->user_id != $user->id)
                    <tr>
                      <td colspan="2">
                        <form accept="" action="{{ url('travel/') }}" method="post">
                            <table class="table table-bordered">
                              <tr>
                                <td colspan="4"><legend>Action</legend></td>
                              </tr>
                              <tr>
                                <td>
                                  <input type="text" class="form-control" name="remarks" placeholder="Please enter remarks here" required>
                                </td>
                                <td>
                                  <select class="form-control" name="mark" required>
                                    <option value="">Select Status</option>
                                    <option value="discussion">To be discussed</option>
                                    <option value="discarded">Reject</option>
                                    <option value="approved">Approve</option>
                                  </select>
                                </td>
                                <td>
                                  <input class="btn btn-success" type="submit" name="btn_submit" value="Submit">
                                  {{ csrf_field() }}
                                  <input type="hidden" name="id" value="{{encrypt($approval->id)}}">
                                </td>
                              </tr>
                            </table>
                        </form>
                      </td>
                    </tr>
                  @endif

                  @php
                    $statusArr = ['' => '--', 'new' => 'New', 'hold' => 'Hold', 'discussion' => 'To be discussed', 'discarded' => 'Rejected', 'approved' => 'Approved'];
                    $statusArrClass = ['' => 'info', 'new' => 'info', 'hold' => 'danger', 'discussion' => 'danger', 'discarded' => 'danger', 'approved' => 'success'];
                  @endphp
                  <tr>
                    <td>
                      Status:
                      @if(auth()->user()->can('approve-travel') && $approval->user_id != $user->id)

                       <label class="label label-{{ $statusArrClass[@$approval->travelClimberUser->status] }}">{{ $statusArr[@$approval->travelClimberUser->status] }}</label>
                      @else
                        <label class="label label-{{ $statusArrClass[$approval->status] }}">{{ $statusArr[$approval->status] }}</label>
                      @endif
                    </td>
                    <td>
                      Remarks:
                      @if(auth()->user()->can('approve-travel') && $approval->user_id != $user->id)
                        {{@$approval->travelClimberUser->remarks ?? '--'}}
                      @else
                        {{$approval->remarks ?? '--'}}
                      @endif
                    </td>
                  </tr>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Small boxes (Stat box) -->
  </section>
</div>
<script src="{{asset('public/admin_assets/plugins/dataTables/jquery.dataTables.min.js')}}"></script>
<script src="{!! asset('public/admin_assets/plugins/sweetalert/sweetalert.min.js') !!}"></script>
<script type="text/javascript">
  $(document).ready(function() {

    $(document).on('click', 'a.change-request', function () {
      changeRequest($(this));
    });

  });

  function changeRequest(_obj) {
    var _id = $(_obj).data('id');
    var encyriptedid = $(_obj).data('encyriptedid');
    var _token   = '{!! csrf_token() !!}';

    var objdata = {
      '_token': _token, 'id': _id
    };

    swal({
      title: "Are you sure?",
      text: "You want to change this Travel approval request!",
      icon: "warning",
      buttons: [
        'No, cancel it!',
        'Yes, I am sure!'
      ],
      dangerMode: true,
    }).then(function(isConfirm) {

      if (isConfirm) {

        $.ajax({
          url: "{!! url('travel/change-request') !!}",
          type: "POST",
          data: objdata,
          dataType: 'json',
          success: function (res) {

            if(res.status == 1) {
              swal({
                title: "Done!",
                text: res.msg,
                icon: "success",
              }).then(function(isConfirm) {
                if (isConfirm) {
                  window.location.href="{{url('travel/approval-request-change')}}"+ '/' + encyriptedid;
                }
              });

              _obj.remove(); // "Done!", res.msg, "success"
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
  }
</script>
@endsection