@extends('admins.layouts.app')

@section('content')
<link href="{{asset('public/admin_assets/plugins/dataTables/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{asset('public/admin_assets/plugins/jquery-toast/jquery.toast.min.css')}}" rel="stylesheet">
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>Tender Processing TIL'S</h1>
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
                    <th>Is Prebid Available</th>
                    <th>Is Field Study Available</th>
                    <th>Is Cost Estimation Available</th>
                    <th>Is Document Checklist Available</th>
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
                    ]; // tenderPrebid, tenderCostEstimation, tenderFieldStudy, tenderDocumentChecklist
                  @endphp
                  @if(!empty($listTil) && count($listTil) > 0)
                    @foreach($listTil as $key => $list)
                      <tr class="@if(in_array($list->status, [6, 7])) tr-danger @endif">
                        <td>{!! $loop->iteration !!}</td>
                        <td>{!! $list->til_code ?? '--' !!}</td>
                        <td>{!! (!empty($list->tenderPrebid))? 'Yes' : 'No' !!}</td>
                        <td>{!! (!empty($list->tenderFieldStudy))? 'Yes' : 'No' !!}</td>
                        <td>{!! (!empty($list->tenderCostEstimation)) ?'Yes' : 'No' !!}</td>
                        <td>{!! (!empty($list->tenderDocumentChecklist))? 'Yes' : 'No' !!}</td>
                        <td>
                          @if(auth()->user()->id != 13)
                            <a href="{!! route('leads-management.til-documents', $list->id) !!}" class="btn btn-primary btn-xs" title="View">
                              <i class="fa fa-file-text-o"></i>
                            </a>
                          @endif

                          @if(!empty($list->getCostEstimation))
                              @php
                                $getJsonData = json_decode($list->getCostEstimation->estimation_data);
                                $noOfPost  = count($getJsonData->project_scope->resource_name);
                              @endphp

                              <a href="{{ url('leads-management/view-cost-estimation/'.$list->id) }}" class="btn btn-warning btn-xs" target="_blank" title="View Cost Estimation">
                                <i class="fa fa-eye"></i>
                              </a>
                            @endif
                        </td>
                      </tr>
                    @endforeach
                  @endif
                </tbody>
                <tfoot class="table-heading-style">
                  <tr>
                    <th class="no-sort">S.No.</th>
                    <th>ULN</th>
                    <th>Is Prebid Available</th>
                    <th>Is Field Study Available</th>
                    <th>Is Cost Estimation Available</th>
                    <th>Is Document Checklist Available</th>
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

});
</script>
@endsection