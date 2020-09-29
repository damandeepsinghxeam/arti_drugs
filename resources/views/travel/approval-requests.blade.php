@extends('admins.layouts.app')

@section('content')
<link href="{{asset('public/admin_assets/plugins/dataTables/jquery.dataTables.min.css')}}" rel="stylesheet">

<style>
.til_status_box .panel-heading, .til_status_box .panel-body { padding: 5px; font-size: 11px;}
.til_status_box .columns {padding: 2px;}
.til_status_box h3 { font-size: 14px !important; text-decoration: underline; font-weight: 600;}
.til_status_box .box-header {padding: 5px 5px 10px;}
.til_status_box { border: 1px solid #d2d2d2; border-radius: 4px; padding: 0 7px; }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Travel Approval Requests
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ url('employees/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
    </ol>
  </section>
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      @include('admins.validation_errors')
      <div class="box">
        <div class="box-header"></div>
        <!-- /.box-header -->
        <div class="box-body">

          <!-- Instruction row starts here -->
          <div class="row m-b">
            <div class="col-sm-12">
              <div class="box text-center til_status_box">
                <div class="box-header with-border">
                  <h3 class="box-title">Travel Pre Approval Status:</h3>

                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                  </div>
                  <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <div class="row">
                    <div class="col-md-3 columns">
                      <div class="panel panel-default m-b-none">
                        <div class="panel-heading">
                          <span class="label label-info">New</span>
                        </div>
                        <div class="panel-body">
                          New pre approval created
                        </div>
                      </div>
                    </div>
                    <div class="col-md-3 columns">
                      <div class="panel panel-default m-b-none">
                        <div class="panel-heading">
                          <span class="label label-info">Discussion / To be discussed</span>
                        </div>
                        <div class="panel-body">
                          Discussion required on pre approval
                        </div>
                      </div>
                    </div>
                    <div class="col-md-3 columns">
                      <div class="panel panel-default m-b-none">
                        <div class="panel-heading">
                          <span class="label label-info">Discarded / Rejected</span>
                        </div>
                        <div class="panel-body">
                          Pre approval rejected by the authority
                        </div>
                      </div>
                    </div>
                    <div class="col-md-3 columns">
                      <div class="panel panel-default m-b-none">
                        <div class="panel-heading">
                          <span class="label label-info">Approved</span>
                        </div>
                        <div class="panel-body">
                          Pre approval approved by the authority
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->
            </div>
          </div>
          <!-- Instruction row Ends here -->

          <div class="row">
            <div class="col-md-3">
              <!--  onchange="window.location.href='{ {url('/travel/approval-requests?filter_status=')}}'+this.value" -->
              <select name="filter_status" id="filter_status" class="form-control">
                <option @if($data['filter_status']=='new') selected @endif value="new">New</option>
                <option @if($data['filter_status']=='discussion') selected @endif value="discussion">To be discussed</option>
                <option @if($data['filter_status']=='discarded') selected @endif value="discarded">Rejected</option>
                <option @if($data['filter_status']=='approved') selected @endif value="approved">Approved</option>
              </select>
            </div>

            @if(auth()->user()->can('approve-travel'))
              <div class="col-md-3">
                <select name="list_type" id="list_type" class="form-control">
                  <option value="">Select List Type</option>
                  <option @if($data['list_type']=='created') selected @endif value="created">Created</option>
                  <option @if($data['list_type']=='all') selected @endif value="all">All</option>
                </select>
              </div>
            @endif
          </div>
          <div class="row"><div class="col-md-12">&nbsp;</div></div>
          <div class="row">
            <div class="col-md-12">
              <table id="" class="table table-bordered table-striped">
                <thead class="table-heading-style">
                <tr>
                  <th>S.No.</th>
                  <th>Travel Code</th>
                  <th>Name</th>
                  <th>Purpose</th>
                  <th>Status</th>
                  <th>View</th>
                </tr>
                </thead>
                <tbody>
                  @php $travelTypeArr = ['' => '--', 1 => 'Local', 2 => 'National']; @endphp
                  @if($data['approvals']->count())
                    @foreach($data['approvals'] as $k => $approval)

                      <tr>
                        <td>{{$loop->iteration}}.</td>
                        <td>{{$approval->travel_code}}</td>
                        <td>
                          {{$approval->user->employee->salutation}}
                          {{$approval->user->employee->fullname}}
                        </td>
                        <td>
                          <div title="{{$approval->travel_purpose ?? '--'}}">
                            @if($approval->travel_purpose)
                              @php
                                echo (strlen($approval->travel_purpose) > 25)? substr($approval->travel_purpose, 0, 25).'.....' : $approval->travel_purpose;
                              @endphp
                            @else
                              --
                            @endif
                          </div>
                        </td>
                        <td>
                          @if(auth()->user()->can('approve-travel') && @$data['list_type'] != 'created')
                            {{ ucwords($approval->travelClimberUser->status) }}
                          @else
                            {{ucwords($approval->status)}}
                          @endif
                        </td>
                        <td>
                          <a href="{{url('travel/approval-request-details/'.encrypt($approval->id))}}" class="btn btn-xs btn-success" >View Request</a>
                           <!-- . pending check for (!$data['user']->can('approve-travel')). -->
                          @if($approval->status == 'approved')
                            @if($approval->claims && isset($approval->claims->status) && $approval->claims->status != 'back')

                              @if(auth()->user()->can('approve-travel') && !$approval->claims->climber->isEmpty())
                                <a href="{{url('travel/claim-view/'.encrypt($approval->claims->id))}}" class="btn btn-xs btn-info" >View Claim</a>
                              @endif

                              @if(!auth()->user()->can('approve-travel'))
                                <a href="{{url('travel/claim-view/'.encrypt($approval->claims->id))}}" class="btn btn-xs btn-info" >View Claim</a>
                              @endif

                            @else
                              @if($approval->user_id == auth()->user()->id)
                                @php
                                  $claimBtnUrl = url('travel/claim-form/'.encrypt($approval->id));
                                  $claimBtnText = 'Claim Form';
                                  $claimBtnClass = 'btn-info';
                                  if(!empty($approval->claims) || !empty($approval->claims) && $approval->claims->status == 'back')
                                  {
                                    $claimBtnUrl = url('travel/claim-form-edit/'.encrypt($approval->claims->id));
                                    $claimBtnText = 'Update Claim Form';
                                    $claimBtnClass = 'btn-danger';
                                  }
                                @endphp
                                <a href="{{$claimBtnUrl}}" class="btn btn-xs {{$claimBtnClass}}">{{$claimBtnText}}</a>
                              @endif
                            @endif
                          @endif

                          @if(empty($approval->claims) && $approval->travelClimber->isEmpty() && $approval->user_id == auth()->user()->id)

                            <a href="{{url('travel/approval-request-change/'.encrypt($approval->id))}}" class="btn btn-xs btn-primary">Edit Request</a>

                          @elseif(empty($approval->claims) && $approval->user_id == auth()->user()->id)
                            <a href="javascript:void(0)" class="btn btn-xs btn-primary change-request" data-id="{{$approval->id}}" data-encyriptedid="{{encrypt($approval->id)}}">Request Change</a>
                          @endif
                        </td>
                      </tr>
                    @endforeach
                  @else
                    <tr>
                      <td colspan="6" class="text-center">No record found</td>
                    </tr>
                  @endif
                </tbody>
                <tfoot class="table-heading-style">
                <tr>
                  <th>S.No.</th>
                  <th>Travel Code</th>
                  <th>Name</th>
                  <th>Purpose</th>
                  <th>Status</th>
                  <th>View</th>
                </tr>
                </tfoot>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<script src="{{asset('public/admin_assets/plugins/dataTables/jquery.dataTables.min.js')}}"></script>
<script src="{!! asset('public/admin_assets/plugins/sweetalert/sweetalert.min.js') !!}"></script>
<script type="text/javascript">
  $(document).ready(function() {

    $(document).on('click', 'a.change-request', function () {
      changeRequest($(this));
    });

    $(document).on('change', 'select#list_type', function () {
      var list_type = this.value;
      if(list_type != '') {
        var filter_status = $('select#filter_status').val();

        var _url = '?filter_status='+filter_status+'&list_type='+list_type;
        window.location.href='{{url('/travel/approval-requests')}}'+_url;
      }
    });

    $(document).on('change', 'select#filter_status', function () {
      var filter_status = this.value;
      var list_type = '';

      @if(auth()->user()->can('approve-travel'))
        var list_type_val = $('select#list_type').val();

        if(list_type_val != '') {
          list_type = '&list_type='+list_type_val;
        }
      @endif

      var _url = '?filter_status='+filter_status+list_type;
      window.location.href='{{url('/travel/approval-requests')}}'+_url;
    });

    $(".approveBtn").on('click',function(){
      if (!confirm("Are you sure you want to approve this company?")) {
        return false;
      }
    });

    $(".additionalCompanyInfo").on('click',function(){
      var companyId = $(this).data('companyid');

      $.ajax({
        type: "POST",
        url: "{{ url('mastertables/additional-company-info') }}",
        data: {company_id: companyId},
        success: function (result){
          $(".companyInfoModalBody").html(result);
          $('#companyInfoModal').modal('show');
        }
      });
    });

    $('#listRegisterCompanies').DataTable({
      scrollX: true,
      responsive: true
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