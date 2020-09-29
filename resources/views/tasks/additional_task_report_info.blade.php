@extends('admins.layouts.app')

@section('content')

<style>
    td > span.label{
        font-size: 0.9em;
        color: black;
    }
    .label-h5{
        background-color: red;
    }
    .label-h4{
        background-color: orange;
    }
    .label-h3{
        background-color: aqua;
    }
    .label-h2{
        background-color: yellow;
    }
    .label-h1{
        background-color: #fffdd0;
    }
</style>

<link rel="stylesheet" href="{{asset('public/admin_assets/plugins/dataTables/jquery.dataTables.min.css')}}">

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Additional Task Report Info
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
            <div class="box-header alri-heading">
              <h3 class="box-title">Due-date between {{date("d M Y",strtotime($report_data['from_date']))}} - {{date("d M Y",strtotime($report_data['to_date']))}}</h3>
            </div>
            <!-- /.box-header -->

            <div class="report-info-img-sec">
              @if(empty($employee_data->employee->profile_picture))
              <img src="{{config('constants.static.profilePic')}}" alt="profilepic-image-error" class="task-info-profile-img img-responsive img-circle" style="width: 56px;">
              @else
              <img src="{{config('constants.uploadPaths.profilePic')}}{{$employee_data->employee->profile_picture}}" alt="profilepic-image-error" class="task-info-profile-img img-responsive img-circle" style="width: 56px;">
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
                <div style="margin: 10px auto;">
                    <a href="javascript:void(0)" id="total-points" class="btn btn-info"></a>  <a href="javascript:void(0)" id="points-obtained" class="btn btn-success"></a>  <a href="javascript:void(0)" id="efficiency" class="btn btn-warning"></a> 
                </div>
              <table id="listTaskReport" class="table table-bordered table-striped" style="height:150px;">
                <thead class="table-heading-style">
                <tr>
                    <th>S.No</th>
                    <th>Task Project</th>
					<th>Task Title</th>
					<th>Assigned By</th>
					<th>Assigned On</th>
                    <th>Task Points</th>
                    <th>Points Obtained</th>
					<th>Priority</th>
					<th>Due Date</th>
                    <th>Overdue</th>
                    <th>Task Status</th>
					<th>User Status</th>
                </tr>
                </thead>
                <tbody>
                
                @php
                    $total_points = 0;
                    $points_obtained = 0;
                @endphp
                @foreach($tasks as $task)
                    @php
                        $profile_pic = config('constants.static.profilePic');

                        if($task->user->employee->profile_picture){
                            $profile_pic = config('constants.uploadPaths.profilePic').$task->user->employee->profile_picture;
                        }
                        $total_points += $task->points;
                        $points_obtained += $task->points_obtained;
                    @endphp
                        <tr class="taskHiddenValue">  
                            <td>{{$loop->iteration}}</td>
                            <td>{{$task->taskProject->name}}</td>
                            <td class="title_task viewTaskTitleBox" data-taskid="{{$task->id}}"><a target="_blank" href="{{url('tasks/info').'/'.$task->id}}">{{$task->title}}</a></td>
                            <td class="taskAssigner">
                                <!-- <img class="img-circle img-bordered-sm" src="{{$profile_pic}}" alt="User Image"> -->
                                <span>{{$task->user->employee->fullname}}</span>
                            </td>
                            <td>
                                <span>{{date("d/m/Y",strtotime($task->created_at))}}</span>
                            </td>
                            <td>{{$task->points}}</td>
                            <td>{{$task->points_obtained}}</td>
                            <td>	
                                @if($task->priority == 'H5')
                                    <span class="label label-h5">H5</span>
                                @elseif($task->priority == 'H4')
                                    <span class="label label-h4">H4</span>
                                @elseif($task->priority == 'H3')
                                    <span class="label label-h3">H3</span>
                                @elseif($task->priority == 'H2')
                                    <span class="label label-h2">H2</span>
                                @elseif($task->priority == 'H1')
                                    <span class="label label-h1">H1</span>  
                                @endif
                            </td>
                            <td>
                                <span>{{date("d/m/Y",strtotime($task->due_date))}}</span>
                            </td>
                        @if($task->taskUser->is_delayed == 1 || ( strtotime(date("Y-m-d")) > strtotime($task->due_date) && $task->taskUser->status != 'Done' ))
                            <td><span class="label label-danger">Yes</span></td>
                        @else  
                            <td><span class="label label-success">No</span></td>
                        @endif
                            <td><em><strong>{{$task->status}}</strong></em></td>
                        @if($task->taskUser->status == 'Done')
                            <td class="task_completed"><span>Done</span></td>
                        @elseif($task->taskUser->status == 'Inprogress')
                            <td class="Working_on_it" style="padding: 0px;"><span>Inprogress</span></td>
                        @elseif($task->taskUser->status == 'Not-Started')
                            <td class="not_started"><span>Not started</span></td>  
                        @elseif($task->taskUser->status == 'Unassigned')
                            <td class="unassigned"><span>Unassigned</span></td>  
                        @endif
					</tr>
					@endforeach
                </tbody>
                <tfoot class="table-heading-style">
                <tr>
                    <th>S.No</th>
                    <th>Task Project</th>
					<th>Task Title</th>
					<th>Assigned By</th>
					<th>Assigned On</th>
                    <th>Task Points</th>
                    <th>Points Obtained</th>
					<th>Priority</th>
					<th>Due Date</th>
                    <th>Overdue</th>
                    <th>Task Status</th>
					<th>User Status</th>
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

        var totalPoints = "{{$total_points}}";
        var pointsObtained = "{{$points_obtained}}";
        var efficiency = 0;
        if(totalPoints != 0){
            efficiency = ((pointsObtained*100)/totalPoints).toFixed(2);
        }

        $("#total-points").text("Total Task Points = "+totalPoints);
        $("#points-obtained").text("Total Points Obtained = "+pointsObtained);
        $("#efficiency").text("Efficiency = "+efficiency+" %");

        $('#listTaskReport').DataTable({
            "scrollX": true,
            responsive: true
        });
      
  </script>

  @endsection