@extends('admins.layouts.app')
@section('content')

<link href="{{asset('public/admin_assets/plugins/dataTables/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{asset('public/admin_assets/plugins/jquery-toast/jquery.toast.min.css')}}" rel="stylesheet">

<style>
.til_status_box .panel-heading, .til_status_box .panel-body { padding: 5px; font-size: 11px;}
.til_status_box .columns {padding: 2px;}
.til_status_box h3 { font-size: 14px !important; text-decoration: underline; font-weight: 600;}
.til_status_box .box-header {padding: 5px 5px 10px;}
.til_status_box { border: 1px solid #d2d2d2; border-radius: 4px; padding: 0 7px; }
</style>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1><i class="fa fa-list"></i> TIL List</h1>
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
          @include('admins.validation_errors')
          <!-- /.box-header -->
          <div class="box-body">

            <!-- Instruction row starts here -->
            <div class="row m-b">
              <div class="col-sm-12">
                <div class="box text-center til_status_box">
                  <div class="box-header with-border">
                    <h3 class="box-title">TIL Status:</h3>

                    <div class="box-tools pull-right">
                      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                      </button>
                    </div>
                    <!-- /.box-tools -->
                  </div>
                  <!-- /.box-header -->
                  <div class="box-body">
                    <div class="row">
                      <div class="col-md-2 columns">
                        <div class="panel panel-default m-b-none">
                          <div class="panel-heading">
                            <span class="label label-info">New</span>
                          </div>
                          <div class="panel-body">
                            New TIL created
                          </div>
                        </div>
                      </div>
                      <div class="col-md-2 columns">
                        <div class="panel panel-default m-b-none">
                          <div class="panel-heading">
                            <span class="label label-info">Open</span>
                          </div>
                          <div class="panel-body">
                            Work started on new TIL
                          </div>
                        </div>
                      </div>
                      <div class="col-md-2 columns">
                        <div class="panel panel-default m-b-none">
                          <div class="panel-heading">
                            <span class="label label-info">TIL For Recommendation</span>
                          </div>
                          <div class="panel-body">
                            TIL sent to HOD
                          </div>
                        </div>
                      </div>
                      <div class="col-md-2 columns">
                        <div class="panel panel-default m-b-none">
                          <div class="panel-heading">
                            <span class="label label-info">TIL For Approval</span>
                          </div>
                          <div class="panel-body">
                            TIL sent to approving authority
                          </div>
                        </div>
                      </div>
                      <div class="col-md-2 columns">
                        <div class="panel panel-default m-b-none">
                          <div class="panel-heading">
                            <span class="label label-info">Completed TIL</span>
                          </div>
                          <div class="panel-body">
                            Won/Lost Tenders
                          </div>
                        </div>
                      </div>
                      <div class="col-md-2 columns">
                        <div class="panel panel-default m-b-none">
                          <div class="panel-heading">
                            <span class="label label-info">Abandoned TIL</span>
                          </div>
                          <div class="panel-body">
                            Tenders Rejected by authority
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
              <div class="col-md-12">
                <!-- <form id="tils-table" action="{ { route('leads-management.mark-editable') }}" method="POST">
                  @ csrf()
                  <div class="col-md-2">
                    <div class="form-group">
                      <label for="assign_to" class="control-label">Mask as editable</label>
                      <div class="clearfix">
                        <div class="btn-div">
                          <button class="btn btn-primary pull-left frm_submit_btn" type="submit">Submit</button>
                          <a href="javascript:void(0);" class="btn btn-danger pull-right reset_btn">
                            Reset
                          </a>
                        </div>                            
                      </div>
                      <input type="hidden" name="til_ids" value="">
                    </div>
                  </div>
                  <div class="col-md-2 pull-right text-right">
                    <h3 class="box-title"> &nbsp; </h3>
                  </div>
                </form> -->

                <form id="til_list_form" method="GET">
                  @php 
                    /*'' => '-Select-', 'all' => 'All', 1 => 'New', 2 => 'Open', 3 => 'Complete', 4 => 'Sent for Remarks', 5 => 'Sent For Approval', 6 => 'Rejected by Hod', 7 => 'Abandoned', 8 => 'Closed'*/

                    $tilStatusArr = [
                      '' => '-Select-', 'all' => 'All', 1 => 'New', 2 => 'Open', 3 => 'TIL for Recommendation', 5 => 'Sent For Approval', 6 => 'Rejected by Hod', 8 => 'Closed'
                    ];
                  @endphp
                  <div class="col-md-3 form-group">
                    <label>TIL Status</label>
                    <select name="til_status" id="til_status" class="form-control input-sm basic-detail-input-style">
                      @foreach($tilStatusArr as $tky => $status)
                        @php 
                          $selectStatus = '';
                          if(!empty($tilStatus) && $tilStatus == $tky) {
                            $selectStatus = 'selected';
                          }
                        @endphp
                        <option value="{{$tky}}" {{$selectStatus}}>{{$status}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col-md-1">
                    <div class="form-group">
                      <button type="submit" class="btn searchbtn-attendance">Search <i class="fa fa-search"></i></button>
                      <div class="clearfix">&nbsp;</div>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="clearfix">&nbsp;</div>
                    <div class="form-group m-t-xs">
                      <a href="{{url('leads-management/get-list-til?til_status=5')}}" class="btn btn-primary btn-sm" title="View TIL for Approval">
                        View TIL for Approval
                      </a>
                    </div>
                  </div>
                </form>
              </div>
            </div>
            
            <hr>

            <div class="row">
              <div class="table-responsive col-md-12">
                <table id="til-table" class="table table-bordered table-striped table-condensed table-responsive">
                  <thead class="table-heading-style">
                    <tr>
                      <th class="no-sort">
                        <!-- <label for="tilidall">
                           <input type="checkbox" class="tilidall" name="tilidall" id="tilidall" value="1"> --> S.No.
                        <!-- </label>  -->
                      </th>
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
                        1 => 'New', 2 => 'Open', 3 => 'TIL for Recommendation',
                        4 => 'Sent for Remarks', 5 => 'Sent For Approval',
                        6 => 'Rejected by Hod',  7 => 'Abandoned', 
                        8 => 'Closed'
                      ];
                    @endphp
                    @if(!empty($listTil) && count($listTil) > 0)
                      @foreach($listTil as $key => $list)
                        <tr class="@if(in_array($list->status, [6, 7])) tr-danger @endif">
                          <td>
                            <!-- <label for="tilid[{ !! $list->id !!}]" class="font-normal">
                              <input type="checkbox" class="tilid" name="tilid[{ !! $list->id !!}]" id="tilid[{ !! $list->id !!}]" value="{ !! $list->id !!}">  -->
                              {!! $loop->iteration !!}
                            <!-- </label> -->
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
                          <td>{!! trim($list->tender_owner) !!}</td>                        

                          <td>{!! $statusArr[$list->status] ?? '--' !!}</td>
                          <td>{!! date('Y-m-d', strtotime($list->updated_at)) !!}</td>
                          <td>
                            <a href="{!! route('leads-management.show-til', $list->id) !!}" class="btn btn-primary btn-xs" title="View">
                              <i class="fa fa-eye"></i>
                            </a>

                            @if(!in_array($list->status, [6, 7]) && $list->is_editable == 0)
                              <a href="javascript:void(0);" class="btn btn-success btn-xs markaseditable" title="Mark As Editable" data-til_id="{!! $list->id !!}">
                                <i class="fa fa-unlock"></i>
                              </a>
                            @endif
                          </td>
                        </tr>
                      @endforeach
                    @endif
                  </tbody>
                  <tfoot class="table-heading-style">
                    <tr>
                      <th class="no-sort"> 
                        <!-- <label for="tilidall">
                          <input type="checkbox" class="tilidall" name="tilidall" id="tilidall" value="1">  -->S.No.
                        <!-- </label>  -->
                      </th>
                      <th>ULN</th>
                      <th>Tender locaion</th>
                      <th>Department name</th>
                      <th>Due date</th>
                      <th>Assignee</th>
                      <th>Status</th>
                      <th>Updated at</th>
                      <th class="text-center"> Actions </th>
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

  $(document).on('click', '.tilidall', function (event) {
    if($(this).is(':checked')) {
      $('.tilidall').prop('checked', true);
      $('.tilid').prop('checked', true);
    } else {
      $('.tilidall').prop('checked', false);
      $('.tilid').prop('checked', false);
    }

    var val_str = '';
    $('.tilid').each(function(k, v) {
      if($(v).is(':checked')) {
        val_str += (val_str != '')? ',' + $(v).val() : $(v).val();
      }
    });
    $('input[name="til_ids"]').val(val_str);
  });

  $(document).on('click', '.tilid', function (event) {
    if(!$(this).is(':checked')) {
      $('.tilidall').prop('checked', false);
      // var check = $('#gvPerformanceResult').find('input[type=checkbox]:checked').length;
    }
    var val_str = '';
    $('.tilid').each(function(k, v) {
      if($(v).is(':checked')) {
        val_str += (val_str != '')? ',' + $(v).val() : $(v).val();
      }
    });
    $('input[name="til_ids"]').val(val_str);
  });

  $(document).on('click', '.markaseditable', function(event) {
    event.preventDefault(); event.stopPropagation();
    markTilEditable($(this));
  });

  /*$(document).on('click', '#tils-table button[type="submit"]', function(event) {
    event.preventDefault(); event.stopPropagation();

    var til_ids = $('input[name="til_ids"]').val();
    if(til_ids == '') {
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
    if($('#tils-table').valid()) {
      $('#tils-table').submit();
    }
  });

  $(document).on('click', '#tils-table .reset_btn', function(event) {
    event.preventDefault(); event.stopPropagation();
    $('#tils-table').trigger('reset');

    $('.tilid, .tilidall').each(function(k, v) {
      if($(v).is(':checked')) {
        $(v).prop('checked', false);
      }
    });
  });*/
});

function markTilEditable(obj) {

  swal({
    title: "Are you sure?",
    text: "You want to make this TIL Editable!",
    icon: "warning",
    buttons: [
      'No, cancel it!',
      'Yes, I am sure!'
    ],
    dangerMode: true,
  }).then(function(isConfirm) {
    if (isConfirm) {
      var til_id  = $(obj).data('til_id');
      var _token  = '{!! csrf_token() !!}';
      var objdata = {'_token': _token, 'til_ids': til_id};

      $.ajax({
        url: "{!! route('leads-management.mark-editable') !!}",
        type: "POST",
        data: objdata,
         beforeSend: function() {
          // setting a timeout
          $('div.loading').removeClass('hide');
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

            $(obj).addClass('hide');
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
  });
}
</script>
@endsection