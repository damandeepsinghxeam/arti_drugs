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

            <form id="til_list_form" method="GET">
              @php
                /*'' => '-Select-', 'all' => 'All', 1 => 'New', 2 => 'Open', 3 => 'Complete', 4 => 'Sent for Remarks', 5 => 'Sent For Approval', 6 => 'Rejected by Hod', 7 => 'Abandoned', 8 => 'Closed'*/

                $tilStatusArr = [
                  '' => '-Select-', 'all' => 'All', 1 => 'New', 2 => 'Open', 3 => 'TIL For Recommendation', 5 => 'Sent For Approval', 6 => 'Rejected by Hod'
                ];// 4 => 'Sent for Remarks',
              @endphp
              <div class="row">
                <div class="col-md-3 attendance-column1">
                  <label for="til_status">TIL Status</label>
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
                <div class="col-md-2 attendance-column2">
                    <button type="submit" class="btn searchbtn-attendance">Search <i class="fa fa-search"></i></button>
                    <div class="clearfix">&nbsp;</div>
                </div>
                <div class="col-md-4 pull-right text-right p-r-none">
                  @if(auth()->user()->can('leads-management.unassined-tils') || auth()->user()->can('leads-management.list-closed-tils'))
                    @if((!empty($bdMember) && $bdMember->team_role_id == 2 || !empty($hodId)))
                      <h3 class="box-title m-t-md m-b-none">
                        @if(auth()->user()->can('leads-management.list-closed-tils'))
                          <a href="{!! route('leads-management.list-closed-tils') !!}" class="btn btn-success">
                            Closed TILS
                          </a>
                        @endif

                        @if(auth()->user()->can('leads-management.unassined-tils'))
                          <a href="{!! route('leads-management.unassined-tils') !!}" class="btn btn-warning">
                            Unassigned TILS
                          </a>
                        @endif
                      </h3>
                    @else
                      <h3 class="box-title m-t-md m-b-none">&nbsp;</h3>
                    @endif
                  @endif
                </div>
              </div>
            </form>

            <hr>

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
                      <th class="no-sort text-center">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php
                      $statusArr = [
                        1 => 'New', 2 => 'Open', 3 => 'TIL for Recommendation',
                        //4 => 'Sent for Remarks', 
                        5 => 'Sent For Approval',
                        6 => 'Rejected by Hod',  7 => 'Abandoned', 
                        8 => 'Closed'
                      ];
                    @endphp
                    @if(!empty($tilDraftList) && count($tilDraftList) > 0)

                      @foreach($tilDraftList as $key => $list)
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
                          <td class="td_prospect">{!! trim($list->tender_owner ?? '--') !!}</td>

                          <td>{!! $statusArr[$list->status] ?? '--' !!}</td>
                          <td>{!! date('Y-m-d', strtotime($list->updated_at)) !!}</td>
                          <td>
                            <a href="{{ route('leads-management.view-til', $list->id)}}" class="btn btn-primary btn-xs" title="View">
                              <i class="fa fa-eye"></i>
                            </a>

                            @if(!empty($bdMember) && $bdMember->user_id == $list->user_id && in_array($list->status, [1 ,2]) && $list->is_editable == 1)
                              <a href="{!! route('leads-management.edit-til', $list->id) !!}" class="btn btn-success btn-xs" title="Edit">
                                <i class="fa fa-edit"></i>
                              </a>
                            @endif

                            @if(auth()->user()->can('leads-management.unassign-user'))
                              @if((!empty($bdMember) && $bdMember->team_role_id == 2 && !empty($list->user_id) && $list->user_id != $bdMember->user_id) || !empty($hodId) && !empty($list->user_id) && !in_array($list->status, [5, 6, 7]))
                                <a href="javascript:void(0);" class="btn btn-warning btn-xs unasign-user" title="Unsign Executive" data-til_id="{!! $list->id !!}" data-user_id="{!! $list->user_id !!}">
                                  <i class="fa fa-chain-broken"></i>
                                </a>
                              @endif
                            @endif
                          </td>
                        </tr>
                      @endforeach
                    @endif
                  </tbody>
                  <tfoot class="table-heading-style">
                    <tr>
                      <th class="no-sort"> S.No. </th>
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

  $(document).on('click', '.unasign-user', function(event) {
    event.preventDefault();  event.stopPropagation();
    unAssignUser($(this));
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
});

function unAssignUser(obj) {
  if(typeof $(obj).data('til_id') != 'undefined' && typeof $(obj).data('user_id') != 'undefined') {

    var til_id  = $(obj).data('til_id');
    var user_id = $(obj).data('user_id');
    var _token  = '{!! csrf_token() !!}';

    var objdata = {
      '_token': _token, 'til_id': til_id, 'user_id': user_id,
    };

    swal({
      title: "Are you sure?",
      text: "You want to unassign the user from this TIL!",
      icon: "warning",
      buttons: [
        'No, cancel it!',
        'Yes, I am sure!'
      ],
      dangerMode: true,
    }).then(function(isConfirm) {
      if (isConfirm) {
        $.ajax({
          url: "{!! route('leads-management.unassign-user-til') !!}",
          type: "POST",
          data: objdata,
          dataType: 'json',
          success: function (res) {
            if(res.status == 1) {
              swal("Done!", res.msg, "success");

              $(obj).addClass('hide');
              $('.td_prospect').text('--');
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
}
</script>
@endsection