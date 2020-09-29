@extends('admins.layouts.app')
@section('content')

<link href="{{asset('public/admin_assets/plugins/dataTables/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{asset('public/admin_assets/plugins/jquery-toast/jquery.toast.min.css')}}" rel="stylesheet">

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1><i class="fa fa-list"></i> Cost Estimation</h1>
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
            <hr>
            <div class="row">
              <div class="table-responsive col-md-12">
                <table id="til-table" class="table table-bordered table-striped table-condensed table-responsive">
                  <thead class="table-heading-style">
                    <tr>
                      <th class="no-sort">S.No.</th>
                      <th>ULN</th>
                      <th>Tender location</th>
                      <th>Assignee</th>
                      <th>Updated at</th>
                      <th class="no-sort text-center">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    @if(!empty($tenderProcessing) && count($tenderProcessing) > 0)

                      @foreach($tenderProcessing as $key => $list)
                        <tr class="@if(in_array($list->tils->status, [6, 7])) tr-danger @endif">
                          <td>{!! $loop->iteration !!}</td>
                          <td>{!! $list->tils->til_code ?? '--' !!}</td>
                          <td>
                            <div title="{!! $list->tils->tender_location ?? '--' !!}">
                              @if($list->tils->tender_location)
                                @php
                                  echo (strlen($list->tils->tender_location) > 20)? substr($list->tils->tender_location, 0, 20).'.....' : $list->tils->tender_location;
                                @endphp
                              @else
                                --
                              @endif
                            </div>
                          </td>
                          <td class="td_prospect">{!! trim($list->tils->tender_owner ?? '--') !!}</td>
                          <td>{!! date('Y-m-d', strtotime($list->tils->updated_at)) !!}</td>
                          <td>
                            @if(!empty($list->getCostEstimation))
                              @php
                                $getJsonData = json_decode($list->getCostEstimation->estimation_data);
                                  $noOfPost  = count($getJsonData->project_scope->resource_name);

                                $costEstimationUrl = 'leads-management/cost-estimation/'.$list->til_draft_id.'?key='.encrypt($noOfPost);
                              @endphp

                              <a href="{{ url('leads-management/view-cost-estimation/'.$list->til_draft_id) }}" class="btn btn-primary btn-xs" target="_blank" title="View Cost Estimation">
                                <i class="fa fa-eye"></i>
                              </a>

                              @if($list->getCostEstimation->is_complete != 1 && $list->getCostEstimation->is_editable == 1)
                                <a href="{{url($costEstimationUrl)}}" class="btn btn-success btn-xs" title="Edit Cost Estimation" target="_blank">
                                  <i class="fa fa-pencil-square-o"></i>
                                </a>
                              @endif

                            @else
                              <a href="javascript:void(0)" class="btn btn-success btn-xs cost-btn" data-til_draft_id="{{$list->til_draft_id}}">
                                <i class="fa fa-plus-circle"></i>
                              </a>
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
                      <th>Assignee</th>
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

<div class="modal fade bs-example-modal-sm" id="cost-estimation-modal" tabindex="-1">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        <h4 class="modal-title" id="mySmallModalLabel">Cost Estimation Details</h4>
      </div>
      <div class="modal-body">
        <form id="estimation_form" action="{!! route('leads-management.estimation') !!}" method="GET" target="_blank" enctype="application/x-www-form-urlencoded" class="form-vertical">
          <div class="col-md-12">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="no_of_posts" class="control-label col-md-4">No of Posts.</label>
                  <div class="col-md-8">
                    <input type="hidden" name="til_draft_id" value="0"/>
                    <input type="number" name="no_of_posts" id="no_of_posts" class="form-control no_of_posts" placeholder="Number of Posts" value="1" min="1" required/>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="clearfix"></div>
        </form>
      </div>
      <div class="modal-footer">
        <div class="col-md-12">
          <button type="button" class="btn btn-success estimation_form_btn" aria-label="Close">Ok</button>
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

  $(document).on('click', '.cost-btn', function(event) {
    $('input[name="til_draft_id"]').val(0);
    var til_draft_id = $(this).data('til_draft_id');
    $('input[name="til_draft_id"]').val(til_draft_id);
    $('#estimation_form').trigger('reset');
    $('#cost-estimation-modal').modal({backdrop: 'static', keyboard: false});
  });

  $(document).on('click', '.estimation_form_btn', function(event) {
    if($('#estimation_form input').valid()) {
      $('#estimation_form').submit();
      $('#cost-estimation-modal').modal('hide');
    }
  });

  $('#estimation_form').validate({
    ignore: ':hidden,input[type=hidden],.select2-search__field',
    errorElement: 'span',
    errorPlacement: function(error, element) {
      error.appendTo(element.parent());
    },
    rules: {
      no_of_posts: { required: true, digits: true},
    }
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
</script>
@endsection