@extends('admins.layouts.app')

@section('content')
<link rel="stylesheet" href="{!! asset('public/admin_assets/plugins/dataTables/jquery.dataTables.min.css') !!}">
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>Recommended Leads</h1>
    <ol class="breadcrumb">
      <li><a href="{{ url('employees/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="box">
        <!-- <div class="box-header"></div> -->
        <!-- /.box-header -->
        @include('admins.validation_errors')
        <div class="box-body">
          <div class="box-title">
            <div class="row">
              <div class="col-md-12">
                @php
                  $inputs = Request::all();
                @endphp
                <form id="lead_list_form" method="GET">
                  @if(!empty($bdMember) || !empty($hodId) || $userId == 13)
                    
                    <div class="col-md-3 form-group row">
                      <label>Lead Type</label>
                      <select class="form-control input-sm basic-detail-input-style" name="lead_type" id="lead_type">
                        @if($userId == 13)
                          <option value="all" @if($leadType == 'all') selected @endif>All Leads</option>
                          <option value="created" @if($leadType == 'created') selected @endif>Created Leads</option>
                        @else
                          <option value="all" @if($leadType == 'all') selected @endif>All Leads</option>
                          <option value="created" @if($leadType == 'created') selected @endif>Created Leads</option>
                          <option value="assigned" @if($leadType == 'assigned') selected @endif>Assigned Leads</option>
                        @endif
                      </select>
                    </div>

                    <div class="col-md-2">
                      <div class="form-group">
                        <button type="submit" class="btn searchbtn-attendance">Search <i class="fa fa-search"></i></button>
                        <div class="clearfix">&nbsp;</div>
                      </div>
                    </div>
                  @endif
                    <div class="col-md-3 pull-right text-right row">
                      <h3 class="box-title">
                        <a class="btn btn-info" href="{!! route('leads-management.create') !!}">
                          Add Lead
                        </a>
                        @if(auth()->user()->can('leads-management.unassined-leads'))
                          @if((!empty($bdMember) && $bdMember->team_role_id == 2) || !empty($hodId))
                            <a class="btn btn-warning" href="{!! route('leads-management.unassined-leads') !!}">
                              Unassigned Leads
                            </a>
                          @endif
                        @endif
                      </h3>
                    </div>
                </form>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="table-responsive col-md-12">
              <table id="leads-table" class="table table-bordered table-striped" style="height:150px;">
                <thead class="table-heading-style">
                  <tr>
                    <th class="no-sort">S.No.</th>
                    <th>ULN</th>
                    <th>Name of prospect</th>
                    <th>Business Type</th>
                    <th>Assignee</th>
                    <th>Submited By</th>
                    <th>View Lead</th>
                    <th>Til</th>
                    @if(auth()->user()->can('leads-management.reject-lead'))
                      <th class="no-sort text-center">Action</th>
                    @endif
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
                    @endphp

                    @foreach($leadList as $key => $lead)
                      <tr class="lead-row @if(in_array($lead->status, [4, 6])) tr-danger @endif">
                        <td>{!! $loop->iteration !!}</td>
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
                        <td>{!! $lead->userEmployee->fullname ?? '--' !!} </td>
                        <td>
                          @php
                            $url = route('leads-management.view-leads', $lead->id);
                            if(!empty($userId) && $userId == 13) {
                              $url = route('leads-management.view', $lead->id);
                            }
                          @endphp
                          <a href="{!! $url !!}" class="btn btn-primary btn-xs" title="View">
                            <i class="fa fa-eye"></i>
                          </a>
                        </td>

                        <td> 
                          @if(auth()->user()->can('leads-management.view-til') && $lead->business_type == 1 && empty($lead->tilDraft) && $userId == $lead->executive_id)
                            <a href="{!! route('leads-management.create-til', $lead->id) !!}" class="btn btn-success btn-xs" title="Create Til Form">
                              <i class="fa fa-file-text-o"></i>
                            </a>
                          @endif

                          @if(auth()->user()->can('leads-management.view-til') && $lead->business_type == 1 && !empty($lead->tilDraft))
                            @php
                              $tilRoute = route('leads-management.view-til', $lead->tilDraft->id);
                              if(!empty($userId) && $userId == 13) {
                                $tilRoute = route('leads-management.show-til', $lead->tilDraft->id);
                              }
                            @endphp
                            <a href="{!! $tilRoute !!}" class="btn btn-success btn-xs" title="View Til">
                              <i class="fa fa-eye"></i>
                            </a>
                          @endif
                          
                          @if(auth()->user()->can('leads-management.view-til') && $lead->business_type == 1 && empty($lead->tilDraft) && $userId != $lead->executive_id)
                            <span class="label label-warning">Til Not Created</span>
                          @endif
                        </td>

                        @if(auth()->user()->can('leads-management.reject-lead'))
                          <td>
                            @if(!empty($lead->status) && $lead->status != 6)
                              <a href="javascript:void(0)" class="btn btn-danger btn-xs reject-lead" title="Reject Lead" data-url="{!! route('leads-management.reject-lead', $lead->id) !!}">
                                <i class="fa fa-trash"></i>
                              </a>
                            @endif
                          </td>
                        @endif
                      </tr>
                    @endforeach
                  @endif
                </tbody>
                <tfoot class="table-heading-style">
                <tr>
                  <th>S.No.</th>
                  <th>ULN</th>
                  <th>Name of prospect</th>
                  <th>Business Type</th>
                  <th>Assignee</th>
                  <th>Submited By</th>
                  <th>View Lead</th>
                  <th>Til</th>
                  @if(auth()->user()->can('leads-management.reject-lead'))
                    <th class="text-center">Action</th>
                  @endif
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
    <!-- Main row -->
  </section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
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
    columnDefs: [{
      targets: 'no-sort',
      orderable: false,
    }],
    aaSorting: []
  });

  $(document).on('click', '.reject-lead', function(event) {
    event.preventDefault(); event.stopPropagation();
    rejectLead($(this));
  });
});

function rejectLead(obj) {

  if(typeof $(obj).data('url') != 'undefined') {
    var data_url  = $(obj).data('url');

    swal({
      title: "Are you sure?",
      text: "You want to reject this Lead!",
      icon: "warning",
      buttons: [
        'No, cancel it!',
        'Yes, I am sure!'
      ],
      dangerMode: true,
    }).then(function(isConfirm) {
      if (isConfirm) {
        $.ajax({
          url: data_url,
          type: "POST",
          success: function (res) {
            if(res.status == 1) {
              swal("Done!", res.msg, "success");

              $(obj).addClass('hide');
              $(obj).parents('.lead-row').addClass('tr-danger');
              
              setTimeout(function() {
                window.location.reload();
              }, 1000);
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