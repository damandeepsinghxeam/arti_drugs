@extends('admins.layouts.app')

@section('content')

<link rel="stylesheet" href="{{asset('public/admin_assets/plugins/dataTables/jquery.dataTables.min.css')}}">
<link rel="stylesheet" href="{{asset('public/admin_assets/plugins/jquery-toast/jquery.toast.min.css')}}">

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1> Unassigned TIL's </h1>
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
                    <form id="tils-table-form" action="{{ route('leads-management.assign-til') }}" method="POST">
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
                          <input type="hidden" name="til_ids" value="">
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
                        <h3 class="box-title"> &nbsp; </h3>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="table-responsive col-md-12">
                    <table id="tils-table" class="table table-bordered table-striped table-condensed table-responsive">
                      <thead class="table-heading-style">
                        <tr>
                          <th class="no-sort">
                            <label for="tilstatusall">
                              <input type="checkbox" class="tilstatusall" name="tilstatusall" id="tilstatusall" value="1"> S.No.
                            </label> 
                          </th>
                          <th>ULN</th>
                          <th>Tender location</th>
                          <th>Department name</th>
                          <th>Due date</th>
                          <th>Assignee</th>
                          <th>Status</th>
                          <th>Updated at</th>
                        </tr>
                      </thead>
                      <tbody>
                        @php
                          $statusArr = [
                            1 => 'New', 2 => 'Open', 
                            3 => 'Complete', 4 => 'Rejected by Hod', 
                            5 => 'Closed', 6 => 'Abandoned'
                          ];
                        @endphp
                        @if(!empty($tilDraftList) && count($tilDraftList) > 0)
                          @foreach($tilDraftList as $key => $list)
                          
                            <tr class="@if(in_array($list->status, [4, 6])) tr-danger @endif">
                              <td>
                                <label for="tilstatus[{!! $list->id !!}]" class="font-normal">
                                  <input type="checkbox" class="tilstatus" name="tilstatus[{!! $list->id !!}]" id="tilstatus[{!! $list->id !!}]" value="{!! $list->id !!}"> 
                                  {!! $loop->iteration !!}
                                </label>
                              </td>
                              <td>{!! $list->til_code ?? '--' !!}</td>
                              <td>
                                <div title="{!! $list->tender_location ?? '--' !!}">
                                  @if($list->tender_location)
                                    @php
                                      echo (strlen($list->tender_location) > 20)? substr($list->tender_location, 0, 20).'.....' : $list->tender_location;
                                    @endphp
                                  @else
                                    --
                                  @endif
                                </div>
                              </td>
                              <td>
                                <div title="{!! $list->department ?? '--' !!}">
                                  @if($list->department)
                                    @php
                                      echo (strlen($list->department) > 20)? substr($list->department, 0, 20).'.....' : $list->department;
                                    @endphp
                                  @else
                                    --
                                  @endif
                                </div>
                              </td>
                              <td>{!! date('Y-m-d H:i', strtotime($list->due_date)) !!}</td>
                              <td>{!! trim($list->tender_owner ?? '--') !!}</td>

                              <td>{!! $statusArr[$list->status] ?? '--' !!}</td>
                              <td>{!! date('Y-m-d', strtotime($list->updated_at)) !!}</td>
                            </tr>
                          @endforeach
                        @endif
                      </tbody>
                      <tfoot class="table-heading-style">
                        <tr>
                          <th>
                            <label for="tilstatusalls">
                              <input type="checkbox" class="tilstatusall" name="tilstatusall" id="tilstatusalls" value="1"> S.No.
                            </label>
                          </th>
                          <th>ULN</th>
                          <th>Tender location</th>
                          <th>Department name</th>
                          <th>Due date</th>
                          <th>Assignee</th>
                          <th>Status</th>
                          <th>Updated at</th>
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

  $('#tils-table').DataTable({
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

  $(document).on('click', '.tilstatusall', function (event) {
    if($(this).is(':checked')) {
      $('.tilstatusall').prop('checked', true);
      $('.tilstatus').prop('checked', true);
    } else {
      $('.tilstatusall').prop('checked', false);
      $('.tilstatus').prop('checked', false);
    }

    var val_str = '';
    $('.tilstatus').each(function(k, v) {
      if($(v).is(':checked')) {
        val_str += (val_str != '')? ',' + $(v).val() : $(v).val();
      }
    });
    $('input[name="til_ids"]').val(val_str);
  });

  $(document).on('click', '.tilstatus', function (event) {
    if(!$(this).is(':checked')) {
      $('.tilstatusall').prop('checked', false);
      // var check = $('#gvPerformanceResult').find('input[type=checkbox]:checked').length;
    }
    var val_str = '';
    $('.tilstatus').each(function(k, v) {
      if($(v).is(':checked')) {
        val_str += (val_str != '')? ',' + $(v).val() : $(v).val();
      }
    });
    $('input[name="til_ids"]').val(val_str);
  });

  $(document).on('click', '#tils-table-form button[type="submit"]', function(event) {
    event.preventDefault(); event.stopPropagation();

    var lead_ids = $('input[name="til_ids"]').val();
    if(lead_ids == '') {
      $.toast({
        heading: 'Error',
        text: 'Please select some til\'s to perform a action.',
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
    if($('#tils-table-form').valid()) {
      $('#tils-table-form').submit();
    }
  });

  $(document).on('click', '#tils-table-form .reset_btn', function(event) {
    event.preventDefault(); event.stopPropagation();
    $('#tils-table-form').trigger('reset');

    $('.tilstatusall, .tilstatus').each(function(k, v) {
      if($(v).is(':checked')) {
        $(v).prop('checked', false);
      }
    });
  });
});
</script>
@endsection