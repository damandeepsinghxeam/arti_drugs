@extends('admins.layouts.app')
@section('content')
<link rel="stylesheet" href="{{asset('public/admin_assets/plugins/dataTables/jquery.dataTables.min.css')}}">
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
    <h1>Interview List</h1>
    <ol class="breadcrumb">
      <li><a href="{{ url('employees/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
    </ol>
   </section>

   <!-- Main content -->
   <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
       <div class="box">
          <div class="box-header"></div>
          <!-- /.box-header -->
            <div class="box-body">
             <table id="listHolidays" class="table table-bordered table-striped">
                <thead class="table-heading-style">
                 <tr>
                    <th>S.No.</th>
                    <th>Designation</th>
                    <th>Role</th>
                    <th>Candidate name</th>
                    <th>Interview Type</th>
                    <th>Interview Time</th>
                    <th>Interview Date</th>
                    <th>Description</th>
                 </tr>
                </thead>
                
                @foreach($datas as $data)
                  <tbody>
                    <tr> 
                      <td>{{@$loop->iteration}}</td>
                      <td>{{$data->designation}}</td> 
                      <td>{{$data->role}}</td>
                      <td>{{$data->candidate_name}}</td> 
                      <td>{{$data->interview_type}}</td> 
                      <td>{{$data->interview_time}}</td>
                      <td>{{$data->interview_date}}</td> 
                      <td title="{{@$data->description}}">@if(strlen($data->description) <= 60)
                          {{@$data->description}}
                            @else
                          {{substr($data->description, 0, 60)}}...
                          @endif
                      </td> 
                    </tr>
                  </tbody>
                @endforeach

                <tfoot class="table-heading-style">
                   <tr>
                     <th>S.No.</th>
                      <th>Designation</th>
                      <th>Role</th>
                      <th>Candidate name</th>
                      <th>Interview Type</th>
                      <th>Interview Time</th>
                      <th>Interview Date</th>
                      <th>Description</th>
                   </tr>
                </tfoot>
               </table>
            </div><!-- /.box-body -->
          </div><!-- /.box -->
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