@extends('admins.layouts.app')

@section('content')
<link href="{{asset('public/admin_assets/plugins/dataTables/jquery.dataTables.min.css')}}" rel="stylesheet">
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Travel Claim Requests
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ url('employees/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
    </ol>
  </section>
  <section class="content">
    <!-- Small boxes (Stat box) -->
    @include('admins.validation_errors')
    <div class="row">
      <div class="box">
        <div class="box-header"></div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-3">
              <!--  onchange="window.location.href='{ {url('/travel/claim-requests?filter_status=')}}'+this.value" -->
              <select name="filter_status" id="filter_status"  class="form-control">
                <option @if($data['filter_status']=='new') selected @endif value="new">Only New Requests</option>
                <option @if($data['filter_status']=='back') selected @endif value="back">Only Back Requests</option>
                <option @if($data['filter_status']=='approved') selected @endif value="approved">Only Approved Requests</option>
                <option @if($data['filter_status']=='paid') selected @endif value="paid">Only Paid Requests</option>
              </select>
            </div>

            @if(@$data['user']->can('approve-travel-claim'))
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
                  <th>Claim Code</th>
                  <th>Name</th>
                  <th>Purpose</th>
                  <th>Status</th>
                  <th>View</th>
                </tr>
                </thead>
                <tbody>
                @php $travelTypeArr = ['' => '--', 1 => 'Local', 2 => 'National']; @endphp
                @if(isset($data['claims']) && $data['claims']->count())
                  @foreach($data['claims'] as $k => $claim)
                    <tr>
                      <td>{{$loop->iteration}}.</td>
                      <td>{{$claim->travel->travel_code}}</td>
                      <td>{{$claim->claim_code}}</td>
                      <td>
                        {{$claim->user->employee->salutation}}
                        {{$claim->user->employee->fullname}}
                      </td>
                      <td>
                        <div title="{{$claim->travel->travel_purpose ?? '--'}}">
                          @if($claim->travel->travel_purpose)
                            @php
                              echo (strlen($claim->travel->travel_purpose) > 25)? substr($claim->travel->travel_purpose, 0, 25).'.....' : $claim->travel->travel_purpose;
                            @endphp
                          @else
                            --
                          @endif
                        </div>
                      </td>
                      <td>
                        @if(@$data['list_type'] != 'created' && ($data['user']->can('approve-travel-claim') || $data['user']->can('verify-travel-claim')))
                          {{ ucwords(@$claim->climberUser->status) }}
                        @else
                          {{ucwords($claim->status)}}
                        @endif
                      </td>
                      <td>
                        <a href="{{url('travel/claim-view/'.encrypt($claim->id))}}" class="btn btn-xs btn-success">View Claim</a>

                        @if($claim->user_id == auth()->user()->id && $claim->status == 'back')
                          <a href="{{url('travel/claim-form-edit/'.encrypt($claim->id))}}" class="btn btn-xs @if($claim->status=='back') btn-danger @else btn-info @endif">@if($claim->status == 'back') Update @endif Claim Form</a>
                        @endif
                      </td>
                    </tr>
                  @endforeach
                @else
                  <tr>
                    <td colspan="8" class="text-center">No record found</td>
                  </tr>
                @endif
                </tbody>
                <tfoot class="table-heading-style">
                <tr>
                  <th>S.No.</th>
                  <th>Travel Code</th>
                  <th>Claim Code</th>
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
<script type="text/javascript">
  $(document).ready(function() {

    $(document).on('change', 'select#list_type', function () {
      var list_type = this.value;
      if(list_type != '') {
        var filter_status = $('select#filter_status').val();

        var _url = '?filter_status='+filter_status+'&list_type='+list_type;
        window.location.href='{{url('/travel/claim-requests')}}'+_url;
      }
    });

    $(document).on('change', 'select#filter_status', function () {
      var filter_status = this.value;
      var list_type = '';

      @if(@$data['user']->can('approve-travel-claim'))
        var list_type_val = $('select#list_type').val();

        if(list_type_val != '') {
          list_type = '&list_type='+list_type_val;
        }
      @endif

      var _url = '?filter_status='+filter_status+list_type;
      window.location.href='{{url('/travel/claim-requests')}}'+_url;
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
</script>
@endsection