@extends('admins.layouts.app')
@section('content')


<link rel="stylesheet" href="{{asset('public/admin_assets/plugins/dataTables/jquery.dataTables.min.css')}}">

<style>

.viewtask-modal-window {

  position: absolute;

  top: 0;

  right: 0;

  z-index: 999;

  transition: all 0.3s;

}

.viewtask-modal-window:target {

  visibility: visible;  

  opacity: 1;

  pointer-events: auto;

}

.viewtask-modal-window > div {

    width: 600px;

    height: 400px;

    padding: 2em;

    background: #ffffff;

    border: 1px solid #717171;

    overflow: scroll;

    overflow-x: hidden;

}

.viewtask-modal-window header {

  font-weight: bold;

}

.viewtask-modal-window h1 {

  font-size: 150%;

  margin: 0 0 15px;

}

.vt-modal-close {

  color: #00728e;

  line-height: 10px;

  font-size: 100%;

  float: right;

  text-align: center;

  width: 20px;

  text-decoration: none;

  cursor: pointer;

}

.vt-modal-close:hover {

  color: black;

}

body {

  color: black;

}

a {

  color: inherit;

}

.vt-container {

  display: grid;

  justify-content: center;

  align-items: center;

  height: 100vh;

}


small {

  color: #aaa;

}

.btn i {

  padding-right: 0.3em;

}

.taskAssigner img {
    width: 40px;
    height: 40px;
    position: relative;
    z-index: 1;
}
.not_started {
	background-color: grey;
	color: white;
}
.Working_on_it {
	background-color: #FF4500;
	color: white;
}
.task_completed {
	background-color: green;
	color: white;
}

tbody tr td {
    vertical-align: middle !important;
}
thead tr th {
    text-align: center;
    vertical-align: middle !important;
}
td.borderForCompleted {
    padding: 2px !important;
    background-color: green;
}
td.borderForWorking {
    padding: 2px !important;
    background-color: #FF4500;
}
td.borderForNotStarted {
	padding: 2px !important;
    background-color: grey;
}
tbody tr:hover {
    box-shadow: 1px 1px 5px #dcdada;
}
.title_task {
	font-weight: 600;
    color: #00728e;
    cursor: pointer;
}
/* .taskAssigner span {
    background-color: #e2e2e2;
    padding: 3px 10px 3px 12px;
    border-radius: 4px;
    position: relative;
    left: -12px;
    top: 2px;
    font-size: 12px;
} */


/* checkbox css */
/* The t-check-container */
.t-check-container {
  display: inline-block;
  position: relative;
  padding-left: 21px;
  margin-bottom: 13px;
  cursor: pointer;
  font-size: 13px;
  font-weight: 500;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

/* Hide the browser's default checkbox */
.t-check-container input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
  height: 0;
  width: 0;
}

/* Create a custom checkbox */
.task-checkmark {
  position: absolute;
  top: 0;
  left: 0;
  height: 18px;
  width: 18px;
  background-color: #a6ddfd;
}

/* On mouse-over, add a grey background color */
.t-check-container:hover input ~ .task-checkmark {
  background-color: #7dc1e8;
}

/* When the checkbox is checked, add a blue background */
.t-check-container input:checked ~ .task-checkmark {
  background-color: #2196F3;
}

/* Create the task-checkmark/indicator (hidden when not checked) */
.task-checkmark:after {
  content: "";
  position: absolute;
  display: none;
}

/* Show the task-checkmark when checked */
.t-check-container input:checked ~ .task-checkmark:after {
  display: block;
}

/* Style the task-checkmark/indicator */
.t-check-container .task-checkmark:after {
  left: 7px;
  top: 3px;
  width: 5px;
  height: 10px;
  border: solid white;
  border-width: 0 3px 3px 0;
  -webkit-transform: rotate(45deg);
  -ms-transform: rotate(45deg);
  transform: rotate(45deg);
}
/* checkbox css */

.taskActionBar {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
}
.vt-dropdown {
  background-color: #d1ebff;
  padding: 0 6px;
  line-height: 1.1;
}
.vt-caret {
  border-top: 5px dashed;
  border-right: 6px solid transparent;
  border-left: 6px solid transparent;
  color: #2196f3;
}
.select-all-checkbox {
    margin-bottom: 0px !important;
}
.taskActionBar1, .taskActionBar2 {
    margin-right: 15px;
}

.vt-change-status {
    font-size: 13px;
    padding: 4px 6px;
}
.taskActionBar2 {
    display: flex;
    align-items: center;
    background-color: #e2e2e2;
    padding: 5px;
}
.SubmitCheckedTask {
    padding: 4px 10px 3px 10px;
    margin-left: 5px;
}
#view-task-table tbody td {
  padding: 8px 0;
}
#points-obtained, #total-points, #efficiency{
  cursor: default;
}
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



<!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>

        Created Tasks List

        <!-- <small>Control panel</small> -->

      </h1>

      <ol class="breadcrumb">

        <li><a href="{{ url('employees/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>

      </ol>

    </section>



    <!-- Main content -->

    <section class="content viewTaskContent">

      <!-- Small boxes (Stat box) -->

      <div class="row">

        <div class="col-md-12">

          <div class="box box-primary">

            <form id="viewTasksList" method="GET">

              <div class="row select-detail-below">

                  <div class="col-md-2 attendance-column1">
                    
                    <label>Task Types</label>

                    <select class="form-control input-sm basic-detail-input-style" name="task_type" id="task_type">

                        <option value="" selected disabled>Please select task type</option>
                        <option value="all">All Tasks</option>
                        <option value="today">Today's Tasks</option>
                        <option value="delayed">Delayed Tasks</option>
                        <option value="upcoming">Upcoming Tasks</option>
                        <option value="this-week">This Week's Tasks</option>
                        <option value="this-month">This Month's Tasks</option>

                    </select>

                  </div>                 

                  <div class="col-md-2 attendance-column2">
                    
                    <label>Task Status</label>

                    <select class="form-control input-sm basic-detail-input-style" name="task_status" id="task_status">

                        <option value="" selected disabled>Please select task status</option>
                        <option value="None">All</option>
                        <option value="Completed">Completed</option>
                        <option value="Unassigned">Unassigned</option>
                        <option value="Inprogress">Inprogress</option>
                        <option value="Open">Open</option>
                        <option value="Reopened">Reopened</option>
                        <!-- <option value="Archived">Archived</option>
                        <option value="Suspended">Suspended</option> -->

                    </select>

                  </div>

                  <div class="col-md-2 attendance-column2">
                    
                    <label>User Status</label>

                    <select class="form-control input-sm basic-detail-input-style" name="user_status" id="user_status">

                        <option value="" selected disabled>Please select user status</option>
                        <option value="None">All</option>
                        <option value="Not-Started">Not-Started</option>
                        <option value="Unassigned">Unassigned</option>
                        <option value="Inprogress">Inprogress</option>
                        <option value="Done">Done</option>

                    </select>

                  </div>

                  <div class="col-md-2 attendance-column3">

                      <div class="form-group">

                          <button type="submit" class="btn searchbtn-attendance">Search <i class="fa fa-search"></i></button>

                      </div>

                  </div>

              </div>

              <br>

            </form>

          



      <!-- /.box-header -->

    <div class="box-body">

	<!-- <form action=""> -->
      <div class="taskActionBar">
        <!-- <div class="taskActionBar1">
          <label class="t-check-container select-all-checkbox">Select All
            <input type="checkbox" class="selectAllCheckBoxes">
            <span class="task-checkmark"></span>
          </label>
        </div> -->
        <div class="taskActionBar2">
      		<select name="" id="change-task-status" class="form-control input-sm basic-detail-input-style">
      			<option value="" disabled>Change Status</option>
      			<option value="Completed">Mark as Completed</option>
      			<option value="Reopened">Mark as Reopened</option>
      			<!-- <option value="Suspended">Mark as Suspended</option> -->
      			<option value="Unassigned">Mark as Unassigned</option>
      			<!-- <option value="Archived">Mark as Archived</option> -->
      		</select>
      		<button type="button" class="btn btn-primary SubmitCheckedTask">Submit</button>
        </div>

        <!-- <div style="margin-left: 4%">
          <a href="javascript:void(0)" id="total-points" class="btn btn-info"></a>  <a href="javascript:void(0)" id="points-obtained" class="btn btn-success"></a> 
          <a href="javascript:void(0)" id="efficiency" class="btn btn-warning"></a>  
        </div> -->
      </div>
    <!-- </form> -->
        
        
			<table class="table table-bordered table-responsive" id="view-task-table">
				<thead class="table-heading-style">
				<tr>
					<th>
            <label class="t-check-container select-all-checkbox">All
              <input type="checkbox" class="selectAllCheckBoxes">
              <span class="task-checkmark"></span>
            </label>
          </th>
					<th>S.No.</th>
          <th>Task Project</th>
					<th>Task Title</th>
					<th>Assigned To</th>
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
				<tbody class="text-center tbodyWithCheckbox">
          @php
            $total_points = 0;
            $points_obtained = 0;
          @endphp
          @foreach($tasks as $task)
            @php
              $profile_pic = config('constants.static.profilePic');

              if($task->taskUser->user->employee->profile_picture){
                $profile_pic = config('constants.uploadPaths.profilePic').$task->taskUser->user->employee->profile_picture;
              }

              $total_points += $task->points;
              $points_obtained += $task->points_obtained;
            @endphp
					<tr class="taskHiddenValue">  
						<td>
							<label class="t-check-container">
                <input type="checkbox" class="selectSingleCheckbox" data-taskid="{{$task->id}}">
                <span class="task-checkmark"></span>
              </label>
						</td>
            
						<td>{{$loop->iteration}}</td>
						<td>{{$task->taskProject->name}}</td>
						<td class="title_task viewTaskTitleBox" data-taskid="{{$task->id}}"><a target="_blank" href="{{url('tasks/info').'/'.$task->id}}">{{$task->title}}</a></td>
						<td class="taskAssigner">
							<!-- <img class="img-circle img-bordered-sm" src="{{$profile_pic}}" alt="User Image"> -->
							<span>{{$task->taskUser->user->employee->fullname}}</span>
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
              <td class="Working_on_it"><span>Inprogress</span>@if($task->task_updates_count)
              <br><span><i class="fa fa-check-circle" aria-hidden="true"></i></span>
              @endif</td>
            @elseif($task->taskUser->status == 'Not-Started')
              <td class="not_started"><span>Not started</span></td>  
            @elseif($task->taskUser->status == 'Unassigned')
              <td class="unassigned"><span>Unassigned</span></td>  
            @endif
					</tr>
          @endforeach  
					
				</tbody>
			</table>


			<br><br><br><br><br><br>

            </div>

            <!-- /.box-body -->

          </div>

          <!-- /.box -->

        </div>

      </div>

      <!-- /.row -->

      <!-- Main row -->

    </section>

    <!-- /.content --> 
    <div class="modal fade" id="addCommentModal">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Add Comment Form</h4>
            </div>
            <div class="modal-body">
              <form id="addCommentForm" action="{{ url('tasks/change-task-status') }}" method="POST">
                {{ csrf_field() }}
                  <div class="box-body">
                    
                    <div class="form-group">
                      <label for="selected_status">Selected Status</label>
                      <input type="text" class="form-control" id="selected_status" name="selected_status" readonly>
                    </div>

                    <input type="hidden" name="task_ids" id="task_ids">

                    <div class="form-group">
                      <label for="comment">Comment</label>
                       <textarea class="form-control" rows="7" name="comment" id="comment"></textarea>
                    </div>
                                 
                  </div>
                  <!-- /.box-body -->
                  <br>

                  <div class="box-footer">
                    <button type="submit" class="btn btn-primary" id="addCommentFormSubmit">Submit</button>
                  </div>
            </form>
            </div>
            
          </div>
          <!-- /.modal-content -->
        </div>
      <!-- /.modal-dialog -->
    </div>
        <!-- /.modal -->

</div>
<!-- /.content-wrapper -->      
 

<script src="{{asset('public/admin_assets/plugins/validations/jquery.validate.js')}}"></script>
<script src="{{asset('public/admin_assets/plugins/validations/additional-methods.js')}}"></script>

<!-- bootstrap time picker -->
<script src="{{asset('public/admin_assets/plugins/dataTables/jquery.dataTables.min.js')}}"></script>

<script type="text/javascript">
  //Date picker
  $("#addCommentForm").validate({
    rules :{
      "comment" : {
          required : true,
          minlength: 2
      },
      "selected_status" : {
          required : true
      }
    },
    messages :{
      "comment" : {
          required : 'Please enter a comment.'
      },
      "selected_status" : {
          required : 'Please select a status.'
      }
    }
  });

  $("#task_due_date").datepicker({
    autoclose: true,
    orientation: "bottom"
  });

  $("#reminder_date").datepicker({
    autoclose: true,
    orientation: "bottom"
  });

  var defTaskType = "{{@$task_type}}";
  if(defTaskType){
    $("#task_type").val(defTaskType);
  }

  var defTaskStatus = "{{@$task_status}}";
  if(defTaskStatus){
    $("#task_status").val(defTaskStatus);
  }

  var defUserStatus = "{{@$user_status}}";
  if(defUserStatus){
    $("#user_status").val(defUserStatus);
  }
</script>


<script>
$(document).ready(function(){

	$('.selectAllCheckBoxes').on('change', function(){
		//event.preventDefault(); event.stopPropagation();

		if($(this).is(':checked')) {
			$('.tbodyWithCheckbox input:checkbox').prop('checked', true);
		}else {
			$('.tbodyWithCheckbox input:checkbox').prop('checked', false);
		}
	});

  $(".SubmitCheckedTask").on('click', function(){
    let selected_status = $("#change-task-status").val();
    let selected_tasks = [];
    if($(".selectSingleCheckbox").is(':checked')){
      $(".selectSingleCheckbox").each(function(){
        if($(this).is(':checked')){
          selected_tasks.push($(this).data('taskid'));
        }
      });
      $("#selected_status").val(selected_status);
      $("#task_ids").val(selected_tasks.join(","));
      $("#addCommentModal").modal('show');
    }else{
      alert("Please select atleast one task & then click on submit!");
    }
   
  });

  // var totalPoints = "{{$total_points}}";
  // var pointsObtained = "{{$points_obtained}}";
  // var efficiency = 0;
  // if(totalPoints != 0){
  //   efficiency = ((pointsObtained*100)/totalPoints).toFixed(2);
  // }

  // $("#total-points").text("Total Task Points = "+totalPoints);
  // $("#points-obtained").text("Total Points Obtained = "+pointsObtained);
  // $("#efficiency").text("Overall Efficiency = "+efficiency+" %");

  $("#view-task-table").DataTable({
    scrollX: true,
    responsive: true
  });
});


</script>
@endsection