@extends('admins.layouts.app')

@section('content')

<link rel="stylesheet" href="{{asset('public/admin_assets/plugins/dataTables/jquery.dataTables.min.css')}}">

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Task Report List
        <!-- <small>Control panel</small> -->
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('employees/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ url('tasks/report') }}">Back</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Due-date between {{date("d M Y",strtotime($report_data['from_date']))}} - {{date("d M Y",strtotime($report_data['to_date']))}}</h3>
              <!-- <button class="btn btn-info pull-right filterReport"><i class="fa fa-filter" aria-hidden="true"></i> Filter</button> -->
            </div>
            <!-- /.box-header -->

            <!-- task report total starts here -->
            <div class="task-report-total">
    		      <div class="row leave-type1"> 
    		        <div class="col-sm-4 col-xs-4 leaves1">
    		          <div class="panel panel-danger leave-type-sectn-report">
    		            <div class="panel-heading leave-heading">Total Days:
    		              <span class="label label-danger">{{$report_data['no_days']}}</span>
    		            </div>
    		            <!-- <div class="panel-body task-content"> -->
    		              
    		            <!-- </div> -->
    		          </div>
    		        </div>
    		        <div class="col-sm-4 col-xs-4 leaves2">
    		          <div class="panel panel-success leave-type-sectn-report">
    		            <div class="panel-heading leave-heading">Weekends:
    		              <span class="label label-success">{{$report_data['weekends']}}</span>
    		            </div>
    		            <!-- <div class="panel-body task-content"> -->
    		              
    		            <!-- </div> -->
    		          </div>
    		        </div>
    		        <div class="col-sm-4 col-xs-4 leaves3">
    		          <div class="panel panel-warning leave-type-sectn-report">
    		            <div class="panel-heading leave-heading">Holidays:
    		              <span class="label label-warning">{{$report_data['holidays']}}</span>
    		            </div>
    		            <!-- <div class="panel-body task-content">
    		              
    		            </div> -->
    		          </div>
    		        </div>
    		      </div>


              <!-- <div class="row task-type1"> 
                <div class="col-sm-4 col-xs-4 tasks1">
                  <div class="panel panel-danger task-type-sectn">
                    <div class="panel-heading task-heading">Total Paid tasks:
                      <span class="label label-danger totalPaidtasks">0</span>
                    </div>
                    
                  </div>
                </div>
                <div class="col-sm-4 col-xs-4 tasks2">
                  <div class="panel panel-success task-type-sectn">
                    <div class="panel-heading task-heading">Total Unpaid tasks:
                      <span class="label label-success totalUnpaidtasks">0</span>
                    </div>
                    
                  </div>
                </div>
                <div class="col-sm-4 col-xs-4 tasks3">
                  <div class="panel panel-warning task-type-sectn">
                    <div class="panel-heading task-heading">Total Compensatory tasks:
                      <span class="label label-warning totalCompensatorytasks">0</span>
                    </div>
                    
                  </div>
                </div>
              </div> -->

              @include('admins.validation_errors')
            
              <div class="callout callout-danger apply-lv-alert" style="margin: 10px 0;background-color: #bd1d0a !important;">
                <strong>Note: </strong> <em>Please do not refresh this page. You can go back and submit the form again.</em>
              </div>


            </div>
            <!-- task report total ends here -->
            
            <div class="box-body">
              <table id="listTaskReport" class="table table-bordered table-striped" style="height:150px;">
                <thead class="table-heading-style">
                <tr>
                  <th style="width:5%;">S.No.</th>
                  <th style="width:10%;">Xeam Code</th>
                  <th style="width:15%;">Employee Name</th>
                  <th style="width:10%;">No. Of Tasks</th>
                  <th style="width:10%;">Tasks Points</th>
                  <th style="width:10%;">Points Obtained</th>
                  <th style="width:10%;">Efficiency</th>
                </tr>
                </thead>
                <tbody>
                  
                @foreach($data as $key =>$value) 

                  @php
                    if($value->efficiency == ""){
                      $value->efficiency = 0;  
                    }else{
                      $value->efficiency = round($value->efficiency, 2);
                    }
                  @endphp 
                <tr>
                  <td>{{$loop->iteration}}</td>
                  <td>{{$value->employee_code}}</td>
                  <td><img src="{{$value->profile_picture}}" class="user-image img-circle" width="30px" height="30px" alt="User Image"><a target="_blank" title="More Information" href="{{ url('tasks/additional-task-report-info') }}{{'?from_date='.$report_data['from_date'].'&to_date='.$report_data['to_date'].'&id='.$value->user_id}}"><em> {{$value->fullname}}</em></a></td>
                  <td>
                    {{$value->task_count}}  
                  </td>
                  <td>
                    {{$value->task_points}}
                  </td>
                  <td>
                    {{$value->points_obtained}}
                  </td>
                  <td>{{$value->efficiency}} %</td>
                </tr>
                @endforeach
                </tbody>
                <tfoot class="table-heading-style">
                <tr>
                  <th style="width:5%;">S.No.</th>
                  <th style="width:10%;">Xeam Code</th>
                  <th style="width:15%;">Employee Name</th>
                  <th style="width:10%;">No. Of Tasks</th>
                  <th style="width:10%;">Tasks Points</th>
                  <th style="width:10%;">Points Obtained</th>
                  <th style="width:10%;">Efficiency</th>
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

      $('#listTaskReport').DataTable({
        "scrollX": true,
        responsive: true
      });
          

      
  </script>

  @endsection