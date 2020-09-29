@extends('admins.layouts.app')
@section('content')

<link rel="stylesheet" href="{{asset('public/admin_assets/plugins/dataTables/jquery.dataTables.min.css')}}">


<!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Leave Authorities List
      </h1>

      <ol class="breadcrumb">
        <li><a href="{{ url('employees/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
      </ol>

    </section>



    <!-- Main content -->

    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
          <div class="box">

            <!-- /.box-header -->

            <div class="box-body">
              <div class="dropdown">
                <button class="btn btn-warning dropdown-toggle" type="button" data-toggle="dropdown">
                  @if(empty($department))
                    {{"Departments"}}
                  @else  
                    {{$department->name}}
                  @endif  
                  <span class="caret"></span>

                </button>

                <ul class="dropdown-menu">
                  @foreach($departments as $key => $value)
                  <li><a href='{{url("mastertables/leave-authorities/$value->id")}}'>{{$value->name}}</a></li>
                  @endforeach
                </ul>

                &nbsp;&nbsp;

                <span class="box-title"><a class="btn btn-info" href='{{url("mastertables/leave-authorities/add/0")}}'>Add</a></span>
              </div>

              <br>
              <br>

              <table id="listDepartmentReportingHods" class="table table-bordered table-striped">
                <thead class="table-heading-style">
                <tr>

                  <th>S.No.</th>
                  <th>Department Name</th>
                  <th>Project Name</th>
                  <th>Employee Name</th>
                  <th>Priority</th>
                  <th>Sub Level</th>
                  <th>Actions</th>

                </tr>

                </thead>

                <tbody>


                @foreach($data as $leave_authority)  

                <tr>
                  <td>{{@$loop->iteration}}</td>
                  <td>{{$leave_authority->department->name}}</td>
                  <td>{{$leave_authority->project->name}}</td>
                  <td>{{$leave_authority->user->employee->fullname}}</td>
                  <td>

                   @if(!empty($leave_authority->priority)) 
                    @if($leave_authority->priority == '2')
                      <span class="label label-danger">{{"HOD"}}</span>
                    @elseif($leave_authority->priority == '3')
                      <span class="label label-warning">{{"HR"}}</span>
                    @elseif($leave_authority->priority == '4')
                      <span class="label label-success">{{"MD"}}</span>
                    @endif
                   @endif 

                  </td>

                  <td>
                   @if(!empty($leave_authority->sub_level)) 
                    @if($leave_authority->sub_level == '1')
                      <span class="text-primary"><strong>{{"Main"}}</strong></span>
                    @elseif($leave_authority->sub_level == '2')
                      <span>{{"Other"}}</span>
                    @endif
                   @endif 
                  </td>

                  <td><a class="btn bg-purple" href='{{ url("mastertables/leave-authorities/edit/$leave_authority->id")}}' title="edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td>

                </tr>

                @endforeach

                </tbody>

                <tfoot class="table-heading-style">

                <tr>
                  <th>S.No.</th>
                  <th>Department Name</th>
                  <th>Project Name</th>
                  <th>Employee Name</th>
                  <th>Priority</th>
                  <th>Sub Level</th>
                  <th>Actions</th>
                </tr>

                </tfoot>

              </table>
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

  <script src="{{asset('public/admin_assets/plugins/dataTables/jquery.dataTables.min.js')}}"></script>

  <script type="text/javascript">

      $(document).ready(function() {
          $('#listDepartmentReportingHods').DataTable({
            scrollX : true,
            responsive: true
          });
      });
     
  </script>

  @endsection