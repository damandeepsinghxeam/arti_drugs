@extends('admins.layouts.app')
@section('content')

<link rel="stylesheet" href="{{asset('public/admin_assets/plugins/dataTables/jquery.dataTables.min.css')}}">
<link rel="stylesheet" href="{{asset('public/admin_assets/plugins/jquery-toast/jquery.toast.min.css')}}">

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1> Unassigned leads </h1>
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
          <div class="box">
            @include('admins.validation_errors')
            <!-- /.box-header -->
            <div class="box-body">
              <div class="box-title">
                <div class="row">
                  <div class="col-md-12">
                    <form id="leads-table-form" action="{{ route('leads-management.list-action') }}" method="POST">
                      @csrf()
                      <div class="col-md-2">
                        <div class="form-group">
                          <label for="assign_to" class="control-label">Assign To</label>
                          <select id="assign_to" class="form-control" name="assign_to" required="true">
                            <option value="">- Select Asignee -</option>
                            @foreach($bdEmployees as $key => $employee)
                              <option value="{!! $employee->user_id !!}">{!! $employee->fullname !!}</option>
                            @endforeach
                          </select>
                          <input type="hidden" name="lead_ids" value="">
                        </div>
                      </div>
                      <div class="col-md-2">
                        <div class="form-group">
                          <label class="control-label">&nbsp;</label>
                          <div class="btn-div">
                            <button class="btn btn-primary pull-left frm_submit_btn" type="submit">Submit</button>
                            <a href="javascript:void(0);" class="btn btn-danger pull-right reset_btn">
                              Reset
                            </a>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-2 pull-right text-right">
                        <h3 class="box-title">
                          <a class="btn btn-info" href="{!! route('leads-management.create') !!}">Add Lead</a>
                        </h3>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="table-responsive col-md-12">
                    <table id="leads-table" class="table table-bordered table-striped table-condensed table-responsive">
                      <thead class="table-heading-style">
                        <tr>
                          <th class="no-sort">
                            <label for="leadstatusall">
                              <input type="checkbox" class="leadstatusall" name="leadstatusall" id="leadstatusall" value="1"> S.No.
                            </label> 
                          </th>
                          <th>ULN</th>
                          <th>Name of prospect</th>
                          <th>Business Type</th>
                          <th>Assignee</th>
                          <!-- <th>Source</th>
                          <th>Contact name</th>
                          <th>Contact Email</th> -->
                          <th>Status</th>
                          <th>Priority</th>
                        </tr>
                      </thead>
                      <tbody>
                        @if(!empty($leadList) && count($leadList) > 0)
                            
                          @php
                            $fileAbsolutePath = \Config::get('constants.uploadPaths.leadDocuments');
                            $filePath = asset('public') . \Config::get('constants.uploadPaths.leadDocumentPath');
                            $businessTypeArr = [1 => 'Govt. Business', 2 => 'Corporate Business', 3 => 'International Business'];

                            $statusArr = [
                              1 => 'New',      2 => 'Open', 
                              3 => 'Complete', 4 => 'Rejected by Hod', 
                              5 => 'Closed', 6 => 'Abandoned'
                            ];

                            $priorityArr = [0=> 'Low', 1=> 'Normal', 2=> 'Critical'];
                          @endphp

                          @foreach($leadList as $key => $lead)

                            <tr class="@if(in_array($lead->status, [4, 6])) tr-danger @endif">
                              <td>
                                <label for="leadstatus[{!! $lead->id !!}]" class="font-normal">
                                  <input type="checkbox" class="leadstatus" name="leadstatus[{!! $lead->id !!}]" id="leadstatus[{!! $lead->id !!}]" value="{!! $lead->id !!}"> 
                                  {!! $loop->iteration !!}
                                </label>
                              </td>
                              <td>{!! $lead->lead_code !!}</td>
                              <td>
                                <div title="{!! $lead->name_of_prospect ?? '--' !!}">
                                  @if($lead->name_of_prospect)
                                    @php
                                      echo (strlen($lead->name_of_prospect) > 25)? substr($lead->name_of_prospect, 0, 25).'.....' : $lead->name_of_prospect ;
                                    @endphp
                                  @else
                                    --
                                  @endif
                                </div>
                              </td>
                              <td>{!! $businessTypeArr[$lead->business_type] ?? '--' !!}</td>
                              <td>
                                @if(isset($lead->leadExecutives->fullname))
                                  {!! trim($lead->leadExecutives->fullname) !!}
                                @else
                                  --
                                @endif
                              </td>                              
                              <!-- <td>{ !! $lead->source->source_name ?? '--' !!} </td>
                              <td>{ !! $lead->contact_person_name ?? '--' !!} </td>
                              <td>{ !! $lead->email ?? '--' !!} </td> -->
                              <td>{!! $statusArr[$lead->status] ?? '--' !!}</td>
                              <td>
                                @php
                                  $priority = $priorityArr[$lead->priority];
                                @endphp

                                @if($lead->priority == 2)
                                  <span class="label label-danger">{!! $priority !!}</span>
                                @elseif($lead->priority == 1)
                                  <span class="label label-warning">{!! $priority !!}</span>
                                @else
                                  <span class="label label-info">{!! $priority !!}</span>
                                @endif
                              </td>
                            </tr>
                          @endforeach
                        @endif
                      </tbody>
                      <tfoot class="table-heading-style">
                        <tr>
                          <th>
                            <label for="leadstatusalls">
                              <input type="checkbox" class="leadstatusall" name="leadstatusall" id="leadstatusalls" value="1"> S.No.
                            </label>
                          </th>
                          <th>ULN</th>
                          <th>Name of prospect</th>
                          <th>Business Type</th>
                          <th>Assignee</th>
                          <!-- <th>Source</th>
                          <th>Contact name</th>
                          <th>Contact Email</th> -->
                          <th>Status</th>
                          <th>Priority</th>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
      </div>
      <!-- /.row -->
      <!-- /.modal -->
      <!-- /.row (main row) -->
    </section>
    <!-- /.content-wrapper -->
  </div>
@endsection
@section('script')
<script src="{!! asset('public/admin_assets/plugins/sweetalert/sweetalert.min.js') !!}"></script>
<script src="{{asset('public/admin_assets/plugins/dataTables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('public/admin_assets/plugins/validations/jquery.validate.js')}}"></script>
<script src="{{asset('public/admin_assets/plugins/validations/additional-methods.js')}}"></script>
<script src="{{asset('public/admin_assets/plugins/jquery-toast/jquery.toast.min.js')}}"></script>

<script type="text/javascript"> 
$(document).ready(function () {

  $('#leads-table').DataTable({
    processing: true,
    lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
    pageLength: -1,
    columnDefs: [
      {
        targets: 'no-sort',
        orderable: false,
      }
    ],
    aaSorting: []
  });

  $(document).on('click', '.leadstatusall', function (event) {
    if($(this).is(':checked')) {
      $('.leadstatusall').prop('checked', true);
      $('.leadstatus').prop('checked', true);
    } else {
      $('.leadstatusall').prop('checked', false);
      $('.leadstatus').prop('checked', false);
    }

    var val_str = '';
    $('.leadstatus').each(function(k, v) {
      if($(v).is(':checked')) {
        val_str += (val_str != '')? ',' + $(v).val() : $(v).val();
      }
    });
    $('input[name="lead_ids"]').val(val_str);
  });

  $(document).on('click', '.leadstatus', function (event) {
    if(!$(this).is(':checked')) {
      $('.leadstatusall').prop('checked', false);
      // var check = $('#gvPerformanceResult').find('input[type=checkbox]:checked').length;
    }
    var val_str = '';
    $('.leadstatus').each(function(k, v) {

        if($(v).is(':checked')) {
          val_str += (val_str != '')? ',' + $(v).val() : $(v).val();
        }
    });      
    $('input[name="lead_ids"]').val(val_str);
  });

  $(document).on('click', '#leads-table-form button[type="submit"]', function(event) {
    event.preventDefault(); event.stopPropagation();

    var lead_ids = $('input[name="lead_ids"]').val();
    if(lead_ids == '') {
      $.toast({
          heading: 'Error',
          text: 'Please select some leads to perform a action.',
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
    if($('#leads-table-form').valid()) {
      $('#leads-table-form').submit();
    }
  });

  $(document).on('click', '#leads-table-form .reset_btn', function(event) {
    event.preventDefault(); event.stopPropagation();
    $('#leads-table-form').trigger('reset');

    $('.leadstatusall, .leadstatus').each(function(k, v) {
      if($(v).is(':checked')) {
        $(v).prop('checked', false);
      }
    });
  });
});
</script>
@endsection