@extends('admins.layouts.app')

@section('content')

<link rel="stylesheet" href="{{asset('public/admin_assets/plugins/dataTables/jquery.dataTables.min.css')}}">
<link rel="stylesheet" href="{{asset('public/admin_assets/plugins/jquery-toast/jquery.toast.min.css')}}">

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1> List Til </h1>
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
              <div class="col-md-12"> &nbsp; </div>
            </div>
          </div>
          <div class="row">
            <div class="table-responsive col-md-12">
              <table id="til-table" class="table table-bordered table-striped table-condensed table-responsive">
                <thead class="table-heading-style">
                  <tr>
                    <th class="no-sort"> S.No. </th>
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
                      4 => 'Sent for Remarks', 5 => 'Closed',
                      6 => 'Rejected by Hod', 7 => 'Abandoned'
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
                          <a href="{{ route('leads-management.view-til-remarks', $list->id)}}" class="btn btn-primary btn-xs" title="View">
                            <i class="fa fa-eye"></i>
                          </a>
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