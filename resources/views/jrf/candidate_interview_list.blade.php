@extends('admins.layouts.app')
@section('content')
<link rel="stylesheet" href="{{asset('public/admin_assets/plugins/dataTables/jquery.dataTables.min.css')}}">

<style type="text/css">
table tr th, table tr td { vertical-align: middle !important; }
.flex-td { display: flex; justify-content: center; align-items: center; }

</style>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
    <h1><i class="fa fa-user"></i> Level 2 Screening(Interviewer)</h1>
    <ol class="breadcrumb">
      <li><a href="{{ url('employees/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
    </ol>
   </section>
   <!-- Main content -->
   <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-sm-12">
        <div class="box box-primary">
          <!-- /.box-header -->
            <div class="box-body">
              <table id="listHolidays" class="table table-bordered table-striped text-center">
                <thead class="table-heading-style">
                  <tr>
                    <th>S.No.</th>
                    <th>JRF No</th>
                    <th>Candidate name</th>
                    <th>Current Designation</th>
                    <th>Interview Date</th>
                    <th>Interview Time</th>
                    <th>Reason For Job Change</th>
                    <th>Scheduled By</th>
                    <th>Action</th>
                  </tr>
                </thead>

                @foreach($datas as $data)
                <tbody>
                  <tr> 
                    <td>{{@$loop->iteration}}</td>
                    <td>{{@$data->jrf_no}}</td>
                    <td><a href='{{url("jrf/candidate-level-one-screening-detail/$data->jrf_level_one_screening_id")}}' target="_blank">{{@$data->name}}</a></td> 
                    <td>{{@$data->current_designation}}</td>
                    <td>{{@$data->interview_date}}</td>
                    <td>{{@$data->interview_time}}</td>
                    <td title="{{@$data->reason_for_job_change}}">
                    @if(strlen(@$data->reason_for_job_change) <= 60)
                      {{@$data->reason_for_job_change}}
                        @else
                      {{substr(@$data->reason_for_job_change, 0, 60)}}...
                      @endif
                    </td> 
                    <td>{{@$data->fullname}}</td>
                    <td>
                      <div class="flex-td">
                        @if($data->closure_type == 'open')
                        <a href='{{url("jrf/level-two-screening/$data->jrf_level_one_screening_id")}}' class="btn btn-primary btn-xs rec_tasks" target="_blank">L2 Screening</a>&nbsp;
                        <a class="btn bg-purple btn-xs rec_tasks" target="_blank" href='{{url("jrf/view-jrf/$data->jrf_id")}}'><i class="fa fa-eye"></i></a>
                        @elseif($data->closure_type == 'hold')
                        <a class="btn bg-purple btn-xs rec_tasks" target="_blank" href='{{url("jrf/view-jrf/$data->jrf_id")}}'><i class="fa fa-eye"></i></a>
                        <span class="label label-warning">JRF ON HOLD</span>
                        @else
                        <a class="btn bg-purple btn-xs rec_tasks" target="_blank" href='{{url("jrf/view-jrf/$data->jrf_id")}}'><i class="fa fa-eye"></i></a>
                        <span class="label label-danger">JRF CLOSED</span> 
                        @endif 
                      </div>
                    </td>

                   <!-- <td>
                    @if($data->lvl_sec_id == '0')
                      &nbsp;<a href='{{url("jrf/level-two-screening/$data->jrf_level_one_screening_id")}}' class="btn btn-primary rec_tasks" target="_blank">Level Two Screening</a>
                      &nbsp;<a class="btn btn-primary rec_tasks" target="_blank" href='{{url("jrf/view-jrf/$data->jrf_id")}}'>View</a>
                    @else
                      <button class="btn btn-primary" disabled="disabled">LEVEL 2 FINISH</button>
                      &nbsp;<a class="btn btn-primary rec_tasks" target="_blank" href='{{url("jrf/view-jrf/$data->jrf_id")}}'>View</a>
                    @endif
                    </td> -->
                  </tr>
                </tbody>
                @endforeach

                <tfoot class="table-heading-style">
                   <tr>
                     <th>S.No.</th>
                      <th>JRF No</th>
                      <th>Candidate name</th>
                      <th>Current Designation</th>
                      <th>Interview Date</th>
                      <th>Interview Time</th>
                      <th>Reason For Job Change</th>
                      <th>Scheduled By</th>
                      <th>Action</th>
                   </tr>
                </tfoot>
              </table>
            </div><!-- /.box-body -->
          </div><!-- /.box -->
        </div>
      </div><!-- /.row -->
    <!-- Main row -->
   </section>
   <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <script src="{{asset('public/admin_assets/plugins/dataTables/jquery.dataTables.min.js')}}"></script>
  <script type="text/javascript">
  $(document).ready(function() {
     $('#listHolidays').DataTable({
       scrollX: true,
       responsive: true
     });
  });
  </script>
@endsection