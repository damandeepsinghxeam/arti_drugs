@extends('admins.layouts.app')

@section('content')
<link rel="stylesheet" href="{{asset('public/admin_assets/plugins/dataTables/jquery.dataTables.min.css')}}">
<link rel="stylesheet" href="{{asset('public/admin_assets/plugins/jquery-toast/jquery.toast.min.css')}}">
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1> List Closed TIL'S </h1>
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
              <div class="">&nbsp;</div>
            </div>
          </div>
          <div class="row">
            <div class="table-responsive col-md-12">
              <table id="til-table" class="table table-bordered table-striped table-condensed table-responsive">
                <thead class="table-heading-style">
                  <tr>
                    <th class="no-sort">S.No.</th>
                    <th>ULN</th>
                    <th>Tender location</th>
                    <th>Department name</th>
                    <th>Due date</th>
                    <th>Assignee</th>
                    <th>Status</th>
                    <th>Updated at</th>
                    <th class="no-sort text-center"> Actions </th>
                  </tr>
                </thead>
                <tbody>
                  @php
                    $statusArr = [
                      1 => 'New', 2 => 'Open', 3 => 'Complete',
                      4 => 'Sent for Remarks', 5 => 'Sent For Approval',
                      6 => 'Rejected by Hod',  7 => 'Abandoned', 
                      8 => 'Closed'
                    ];
                  @endphp
                  @if(!empty($listTil) && count($listTil) > 0)
                    @foreach($listTil as $key => $list)
                      <tr class="@if(in_array($list->status, [6, 7])) tr-danger @endif">
                        <td>{!! $loop->iteration !!}</td>
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
                        <td>{!! trim($list->tender_owner) !!}</td>
                        
                        <td>{!! $statusArr[$list->status] ?? '--' !!}</td>
                        <td>{!! date('Y-m-d', strtotime($list->updated_at)) !!}</td>
                        <td>
                          <a href="{!! route('leads-management.view-til', $list->id) !!}" class="btn btn-primary btn-xs" title="View">
                            <i class="fa fa-eye"></i>
                          </a>
                          <a href="#" class="btn btn-success btn-xs markasfiledbtn" title="Mark As Filed" data-til_id="{!! $list->id !!}"><!-- markasfiled -->
                            <i class="fa fa-files-o"></i>
                          </a>
                        </td>
                      </tr>
                    @endforeach
                  @endif
                </tbody>
                <tfoot class="table-heading-style">
                  <tr>
                    <th class="no-sort">S.No.</th>
                    <th>ULN</th>
                    <th>Tender locaion</th>
                    <th>Department name</th>
                    <th>Due date</th>
                    <th>Assignee</th>
                    <th>Status</th>
                    <th>Updated at</th>
                    <th class="no-sort text-center"> Actions </th>
                  </tr>
                </tfoot>
              </table>
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

<div class="modal fade bs-example-modal-sm" id="til_filed_modal" tabindex="-1">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close close-til-modal"><span aria-hidden="true">×</span></button>
        <h4 class="modal-title" id="mySmallModalLabel">Mark TIL Filed:</h4>
      </div>
      <div class="modal-body">          
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive" id="til_contact_form">
              <form id="tils-table" action="{{ route('leads-management.mark-filed') }}" method="POST" class="form-horizontal">
                  @csrf()
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="assign_to" class="control-label col-md-3">TIL Filed Date:</label>
                      <div class="col-md-5">
                        <input type="text" name="til_filed_date" id="til_filed_date" class="til_filed_date form-control" placeholder="Please select TIL filed date" value="" required>                            
                      </div>
                      <input type="hidden" name="til_id" value="">
                    </div>
                  </div>
                  <div class="col-md-2 pull-right text-right">
                    <h3 class="box-title"> &nbsp; </h3>
                  </div>
                </form>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <div class="col-md-12">
          <button type="button" class="btn btn-default close-til-modal">Cancel</button>
          <button type="button" class="btn btn-success savebtn">Save</button>
        </div>
      </div>
    </div>
  </div>
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

  $('.til_filed_date').datepicker({
    format:'m/d/yyyy',
    todayHighlight:true,
    todayBtn:'linked',
    endDate: new Date(),
    autoclose: true
  });
/*data-toggle="modal" data-target="#til_filed_modal"*/
  $(document).on('click', '.markasfiledbtn', function (event) {
    var button = $(this) // Button that triggered the modal
    var til_id = button.data('til_id') // Extract info from data-* attributes
    var modal = $('#til_filed_modal');
    modal.find('.modal-body input[name="til_id"]').val(til_id);

    $('#til_filed_modal').modal('show');
  });

  $(document).on('click', '.close-til-modal', function (event) {
    $('#til_filed_modal').modal('hide');
    $('input[name="til_id"]').val('');
    $('#tils-table').trigger('reset');
  });

  $('#til-table').DataTable({
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

  $(document).on('click', '.savebtn', function(event) {
    event.preventDefault(); event.stopPropagation();
    if($('#tils-table').valid()) {
      markTilFiled($(this));
    }
  });
});

function markTilFiled(obj) {
  var objdata = $('#tils-table').serialize();

  $.ajax({
    url: "{!! route('leads-management.mark-filed') !!}",
    type: "POST",
    data: objdata,
    dataType: 'json',
    encode: true,
    beforeSend: function() {
      // setting a timeout
      $('div.loading').removeClass('hide');
      $('#til_filed_modal').modal('hide');
    },
    success: function (res) {
      if(res.status == 1) {
        $.toast({
          heading: 'Success',
          text: res.msg,
          showHideTransition: 'plain',
          icon: 'success',
          hideAfter: 3000,
          position: 'top-right',
          stack: 3,
          loader: true,
          loaderBg: '#9EC600',
        });
        $('div.loading').addClass('hide');
        setTimeout(function() {
          window.location.reload();
        }, 1000);
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
      }
      console.log(res);
      $('div.loading').addClass('hide');
    },
    error: function (xhr, ajaxOptions, thrownError) {
      var xhrRes = xhr.responseJSON;
        
      if(typeof xhrRes != 'undefined' && xhrRes.status == 401) {
        swal("Error Code: " + xhrRes.status, xhrRes.msg, "error");
      } else {
        swal("Error Code:", 'Internal server error.', "error");
      }
      $('div.loading').addClass('hide');
    }
  });
}
</script>
@endsection