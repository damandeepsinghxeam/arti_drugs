@extends('admins.layouts.app')

@section('content')

<link rel="stylesheet" href="{{asset('public/admin_assets/plugins/dataTables/jquery.dataTables.min.css')}}">

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Additional Leave Report Info
        <!-- <small>Control panel</small> -->
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('employees/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ url('leaves/leave-report-form') }}">Back</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
          <div class="box">
            <div class="box-header alri-heading">
              <h3 class="box-title">{{date("d M Y",strtotime($report_data['from_date']))}} - {{date("d M Y",strtotime($report_data['to_date']))}}</h3>
            </div>
            <!-- /.box-header -->
            
              <!-- <div class="callout callout-danger" style="margin-bottom: 0;background-color: #bd1d0a !important;">
                <strong>Note: </strong> <em>Please do not refresh this page. You can go back and submit the form again.</em>
              </div> -->

            <div class="report-info-img-sec">
              @if(empty($employee_data->employee->profile_picture))
              <img src="{{config('constants.static.profilePic')}}" alt="profilepic-image-error" class="leave-info-profile-img img-responsive img-circle">
              @else
              <img src="{{config('constants.uploadPaths.profilePic')}}{{$employee_data->employee->profile_picture}}" alt="profilepic-image-error" class="leave-info-profile-img img-responsive img-circle">
              @endif
              <div class="alri-employee-detail">
                <span class="alri-employee-name">
                    {{$employee_data->employee->fullname}}
                </span>
                <span class="alri-employee-code">
                    Xeam-Code: {{$employee_data->employee_code}}
                </span>
              </div>
                
            </div>
            
            <div class="box-body">
              <table id="listLeaveReport" class="table table-bordered table-striped" style="height:150px;">
                <thead class="table-heading-style">
                <tr>
                  <th>S.No.</th>
                  <th>From Date</th>
                  <th>To Date</th>
                  <th>Applied On</th>
                  <th>Paid Leaves</th>
                  <th>Unpaid Leaves</th>
                  <th>Compensatory Leaves</th>
                </tr>
                </thead>
                <tbody>
                
                @foreach($data as $key =>$value) 
                <tr>
                  <td>{{$loop->iteration}}</td>
                  <td>{{date("d/m/Y",strtotime($value->from_date))}}</td>
                  <td>{{date("d/m/Y",strtotime($value->to_date))}}</td>
                  <td>{{date("d/m/Y H:i:s",strtotime($value->created_at))}}</td>
                  <td>
                      {{$value->paid_count}}
                  </td>
                  <td>
                      {{$value->unpaid_count}}
                  </td>
                  <td>
                      {{$value->compensatory_count}}
                  </td>
                </tr>
                @endforeach
                </tbody>
                <tfoot class="table-heading-style">
                <tr>
                  <th>S.No.</th>
                  <th>From Date</th>
                  <th>To Date</th>
                  <th>Applied At</th>
                  <th>Paid Leaves</th>
                  <th>Unpaid Leaves</th>
                  <th>Compensatory Leaves</th>
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
      <div class="row">
        <!-- Left col -->
        
      </div>
      <!-- /.row (main row) -->

    </section>
    <!-- /.content -->  

  </div>
  <!-- /.content-wrapper -->

  <script src="{{asset('public/admin_assets/plugins/dataTables/jquery.dataTables.min.js')}}"></script>
  <script type="text/javascript">

      $(function () {  
          $(document).keydown(function (e) {  
              return (e.which || e.keyCode) != 116;  
          });  
      });

      

      $('#listLeaveReport').DataTable({
        "scrollX": true,
        responsive: true
      });
          

      
  </script>

  @endsection