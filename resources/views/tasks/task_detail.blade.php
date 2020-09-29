@extends('admins.layouts.app')
@section('content')

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

.viewtask-modal-window>div {
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

.taskAssigner span {
	background-color: #e2e2e2;
	padding: 3px 10px 3px 12px;
	border-radius: 4px;
	position: relative;
	left: -12px;
	top: 2px;
	font-size: 12px;
}


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
	background-color: #eee;
}


/* On mouse-over, add a grey background color */

.t-check-container:hover input~.task-checkmark {
	background-color: #ccc;
}


/* When the checkbox is checked, add a blue background */

.t-check-container input:checked~.task-checkmark {
	background-color: #2196F3;
}


/* Create the task-checkmark/indicator (hidden when not checked) */

.task-checkmark:after {
	content: "";
	position: absolute;
	display: none;
}


/* Show the task-checkmark when checked */

.t-check-container input:checked~.task-checkmark:after {
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

.taskActionBar1,
.taskActionBar2 {
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

.singleTaskDetails {
	padding: 0 15px;
}

.h2-headings {
	font-size: 20px;
    text-align: center;
    margin-top: 0px;
}

.row-margin {
	margin-left: 0px !important;
	margin-right: 15px !important;
}

.commentbox-sec {
	padding-right: 15px;
}
.load-comments {
    text-align: center;
    background-color: #f7f7f7;
}
.load-comments p {
    margin-bottom: 0px;
    cursor: pointer;
    padding-bottom: 5px;
    padding-top: 5px;
    background-color: #b2b1b0;
    color: white;
}
.load-comments-box {
    box-shadow: none;
    margin-bottom: 0px;
}
.load-comment-body {
    background-color: #f7f7f7;
    padding: 0px;
}
.box-comments {
    background: #f7f7f7;
    max-height: 300px;
    overflow-y: auto;
}
.comment-button {
    background-color: #3c8dbc;
    color: white;
    border: none;
    border-radius: 4px;
    padding: 5px 10px;
    float: right;
}
.panel {
    margin-bottom: 5px;
}
/*.image-upload > input
{
    display: none;
}*/

.image-upload img
{
    width: 80px;
    cursor: pointer;
}
.upload-comment-box {
    /*display: flex;*/
    justify-content: space-between;
}
label.filebutton {
    width:120px;
    height:40px;
    overflow:hidden;
    position:relative;
    display: inline;
    background-color: #f7f7f7;
    padding: 4px;
}

label span input {
    z-index: 999;
    line-height: 0;
    font-size: 50px;
    position: absolute;
    top: -2px;
    left: -700px;
    opacity: 0;
    filter: alpha(opacity = 0);
    -ms-filter: "alpha(opacity=0)";
    cursor: pointer;
    _cursor: hand;
    margin: 0;
    padding:0;
}
.timeline > li > .timeline-item > .timeline-header {
    font-size: 11px;
    padding: 5px 10px;
}
.timeline > li > .timeline-item > .time {
    color: #fff;
    padding: 2px 7px;
}
.timeline > li > .timeline-item {
    border: 1px solid #0073b7;
}
.timeline > li > .timeline-item > .timeline-body {
    padding: 0 10px;
}
.timeline > li > .timeline-item > .timeline-body p {
    margin-bottom: 0px;
    font-size: 11px;
}
.timeline > li > .fa {
    font-size: 12px;
}
</style>



<!-- Content Wrapper Starts here -->

<div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>

        Task Detail

        <small>Task Points: <span class="text-red">{{$task->points}} </span> | Points Obtained: <span class="text-success">{{$task->points_obtained}}</span></small> 

      </h1>

      <ol class="breadcrumb">

        <li><a href="{{ url('employees/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>

      </ol>

    </section>

    <!-- Main content -->

    <section class="content viewTaskContent">

      <div class="row">

        <div class="col-md-12">

          <div class="box box-primary">
          @include('admins.validation_errors')
            <!--Task Detail starts here-->
              <div class="row">
               <!--left sction starts here-->   
                <div class="col-md-7">

                 <div class="singleTaskDetails">
                  @if(@$task->user_id == Auth::id())
                    <form id="update-task-form" action="{{url('tasks/update-task')}}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="task_id" value="{{$task->id}}">
                  @endif
                    <div class="row task-rows">

                        <div class="col-md-7 task-columns">

                            <label for="">Task Title</label>

                            <input type="text" name="title" class="form-control input-sm basic-detail-input-style" placeholder="Enter task title" value="{{@$task->title}}" @if(@$task->user_id != Auth::id()){{'disabled'}}@endif>

                        </div>

                        <div class="col-md-3 task-columns">

                            <label for="">Priority</label>

                            <select class="form-control input-sm basic-detail-input-style" name="priority" id="priority" @if(@$task->user_id != Auth::id()){{'disabled'}}@endif>

                                <option value="" selected disabled>Select</option>

                                <option value="H5">H5</option>

                                <option value="H4">H4</option>

                                <option value="H3">H3</option>

                                <option value="H2">H2</option>

                                <option value="H1">H1</option>

                            </select>

                        </div>

                        <div class="col-md-2 task-columns2">

                            <label for="">Due Date</label>

                            <input autocomplete="off" type="text" class="form-control taskdueDate selectDate input-sm basic-detail-input-style" name="due_date" id="task_due_date" placeholder="MM/DD/YYYY" value="{{date('m/d/Y',strtotime($task->due_date))}}" @if(@$task->user_id != Auth::id()){{'disabled'}}@endif>

                        </div>

                    </div>


                    <!-- Second row starts here -->

                    <div class="remind-section">

                        <div class="col-md-2 task-columns">

                            <input type="checkbox" name="" id="task_remind_me" class="taskRemindMe" disabled>

                            <span class="task-checkbox-label">Reminder</span>

                        </div>

                        <div class="col-md-5 task-columns">

                            <select class="form-control input-sm basic-detail-input-style" name="" id="reminder_days" disabled>
                              <option value="0">None</option>
                              <option value="0.5">Twice per day</option>
                              <option value="1">Once everyday</option>
                              <option value="2">Once every 2 days</option>
                              <option value="5">Once every 5 days</option>
                              <option value="10">Once every 10 days</option>
                            </select>

                        </div>
                        

                        <div class="col-md-4 task-columns">

                            <input type="checkbox" name="" id="reminder_notification" class="checkTaskNotification" disabled>

                            <span class="task-checkbox-label">Notification</span>

                            <input type="checkbox" name="" id="reminder_email" class="checkTaskMail" disabled>

                            <span class="task-checkbox-label">Mail</span>

                        </div>

                    </div>

                    <div class="row task-rows">

                        <div class="col-md-6 task-columns">

                            <label for="">Assigned To</label>

                            <input type="text" name="" id="assigned_to" value="{{@$task->taskUser->user->employee->fullname.' ('.@$task->taskUser->user->employee_code.')'}}" class="form-control" disabled>

                        </div>

                        <div class="col-md-6 task-columns2">

                            <label for="">Project Name</label>

                            <input type="text" name="" value="{{@$task->taskProject->name}}" id="project_name" class="form-control" disabled>

                        </div>

                    </div>

                    <!-- Selected Files sec starts here  -->

                    <div class="row task-rows">
                    <label for="">Task Files</label><br>
                    @if(!$task->taskFiles->isEmpty())
                      @foreach($task->taskFiles as $file)
                    <span>File {{$loop->iteration}}:</span><a href="{{config('constants.uploadPaths.taskDocument').$file->filename}}" target="_blank"><i class="fa fa-file-o"></i></a>&nbsp;&nbsp;
                      @endforeach
                    @else
                    <span>None</span>  
                    @endif
                    </div> 

                    <!-- Selected Files sec ends here  -->



                    <!-- Fourth row starts here -->

                    <div class="row task-description-row">

                        <div class="col-md-12">

                            <label for="">Description</label>

                            <textarea name="description" id="description" cols="30" rows="5" placeholder="Add Description" class="add-task-description" @if(@$task->user_id != Auth::id()){{'disabled'}}@endif>{{@$task->description}}</textarea>

                            <span class="descriptionErrors"></span>

                        </div>

                    </div>

                    @if(@$task->user_id == Auth::id())
                      <button type="button" class="btn btn-primary" id="addTaskFormSubmit">Save Changes</button>
                    </form>
                    @endif 

                
                


                <!--History Section starts here Comments-->
                </div>
                <hr style="margin-bottom: 0px;">
                <div class="row task-rows">

                    <div class="col-md-12 task-columns">

                        <h2 class="h2-headings">Task History:</h2>
                        @if(!$task_history->isEmpty())
                        <!--History timeline Starts here-->
                        <ul class="timeline">
                            <!-- timeline item -->
                            @foreach($task_history as $message)
                            <li>
                              <i class="fa fa-envelope bg-blue"></i>

                              <div class="timeline-item">
                                <span class="time"><i class="fa fa-clock-o"></i>{{date("d/m/Y h:i A",strtotime($message->created_at))}}</span>

                                <h4 class="timeline-header bg-blue"><b>Send By</b> {{$message->sender->employee->fullname}}</h4>

                                <div class="timeline-body">
                                  <p><b>{{$message->label}}</b> {{$message->message}}</p>
                                </div>
                              </div>
                            </li>
                            @endforeach
                            <li>
                              <i class="fa fa-clock-o bg-gray"></i>
                            </li>
                            <!-- END timeline item -->
                        </ul>
                        @endif
                        <!--History timeline ends here-->



                </div>
                </div>
            </div>
               <!--left sction ends here-->
               
               <!--right sction starts here-->
               <div class="col-md-5">
                    
                        <div class="">
                            <div class="box-header ui-sortable-handle" style="cursor: move;text-align: center;">
                              <i class="fa fa-file-text-o"></i>
                              <h3 class="box-title">Task Updates</h3>
                            </div>

                            <div>
                            <div class="box-body chat" id="chat-box" style="overflow-y: auto; width: auto; height: 150px; border-bottom: 1px solid darkgrey;">
                              
                              @if(!$task_updates->isEmpty())
                              @foreach($task_updates as $update)
                              <!-- chat item -->
                              <div class="item">
                                <img src="@if($update->user->employee->profile_picture){{config('constants.uploadPaths.profilePic').$update->user->employee->profile_picture}}@else{{config('constants.static.profilePic')}}@endif" alt="user image" class="offline">

                                <p class="message">
                                  <a href="javascript:void(0)" class="name">
                                    <small class="text-muted pull-right"><i class="fa fa-clock-o"></i> {{date("d/m/Y h:i A",strtotime($update->created_at))}}</small>
                                    {{$update->user->employee->fullname}}
                                  </a>
                                  {!!nl2br($update->comment)!!}
                                </p>
                              </div>
                              <!-- /.item -->
                              @endforeach
                              @endif

                              
                            </div>
                            <div class="slimScrollRail" style="width: 7px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(51, 51, 51); opacity: 0.2; z-index: 90; right: 1px;"></div></div>
                        <!--  End  Task Update  -->



                        <!-- Comment -->
                        <div class="post clearfix commentbox-sec" style="margin-top: 20px;">
                            
                            <h2 class="h2-headings">Comments:</h2>

                            <div class="box-footer box-comments">
                            
                            <!--Load more comment section starts here-->
                            
                            <div class="box collapsed-box box-solid load-comments-box" id="loadMoreComment">
                                <div class="with-border load-comments">
                                  <p class="box-title collapsable-text" data-widget="collapse">Load more comments</p>
                                  <!-- /.box-tools -->
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body load-comment-body">
                                  
                                  @if(!$more_chats->isEmpty())
                                  @foreach($more_chats as $message)
                                  <div class="box-comment">
                                    <!-- User image -->
                                    <img class="img-circle img-sm" src="@if(@$message->sender->employee->profile_picture){{config('constants.uploadPaths.profilePic').$message->sender->employee->profile_picture}}@else{{config('constants.static.profilePic')}}@endif" alt="User Image">

                                    <div class="comment-text">
                                          <span class="username">
                                          {{@$message->sender->employee->fullname}}
                                            <span class="text-muted pull-right"><i class="fa fa-clock-o"></i>{{date("d/m/Y h:i A",strtotime($message->created_at))}}</span>
                                          </span><!-- /.username -->
                                          {!!nl2br(@$message->message)!!}

                                          <br>
                                          <!-- Attached file section-->
                                          @if(!$message->messageAttachments->isEmpty())
                                            @foreach($message->messageAttachments as $file)
                                            <a target="_blank" href="{{config('constants.uploadPaths.messageAttachment').$file->filename}}"><i class="fa fa-file-o"></i></a>&nbsp;&nbsp;
                                            @endforeach
                                          @endif
                                          <!-- Attached file section ends-->
                                    </div>
                                    <!-- /.comment-text -->
                                  </div>
                                  <!-- /.box-comment -->
                                  @endforeach
                                  @endif
                                  
                                </div>
                                <!-- /.box-body -->
                              </div>
                              <!-- /.box -->
                              
                            
                            <!--Showed Comments starts here-->
                              @if(!$latest_chats->isEmpty())
                              @foreach($latest_chats as $message)
                             <div class="box-comment">
                                <!-- User image -->
                                <img class="img-circle img-sm" src="@if(@$message->sender->employee->profile_picture){{config('constants.uploadPaths.profilePic').$message->sender->employee->profile_picture}}@else{{config('constants.static.profilePic')}}@endif" alt="User Image">

                                <div class="comment-text">
                                      <span class="username">
                                        {{@$message->sender->employee->fullname}}
                                        <span class="text-muted pull-right"><i class="fa fa-clock-o"></i>{{date("d/m/Y h:i A",strtotime($message->created_at))}}</span>
                                      </span><!-- /.username -->
                                      {!!nl2br(@$message->message)!!}
                                      <br>

                                      <!-- Attached file section-->
                                      @if(!$message->messageAttachments->isEmpty())
                                        @foreach($message->messageAttachments as $file)
                                        <a target="_blank" href="{{config('constants.uploadPaths.messageAttachment').$file->filename}}"><i class="fa fa-file-o"></i></a>&nbsp;&nbsp;
                                        @endforeach
                                      @endif
                                      <!-- Attached file section ends-->
                                </div>
                                <!-- /.comment-text -->
                              </div>
                              <!-- /.box-comment -->
                              @endforeach
                              @endif
                              
                            </div>
                            <!--Showed Comments ends here-->
                               

                            <div class="box-footer">
                              <form action="{{url('tasks/save-chat')}}" method="POST" id="addCommentForm" enctype="multipart/form-data">
                              {{ csrf_field() }}
                                <input type="hidden" name="task_id" value="{{@$task->id}}">
                                <img class="img-responsive img-circle img-sm" src="@if(@$user->employee->profile_picture){{config('constants.uploadPaths.profilePic').$user->employee->profile_picture}}@else{{config('constants.static.profilePic')}}@endif" alt="Alt Text">
                                <!-- .img-push is used to add margin to elements next to floating images -->
                                <div class="img-push">    
                                  <!--<input type="text" class="form-control input-sm" placeholder="Press enter to post comment">-->
                                    <textarea name="comment_text" rows="3" style="resize: none; width: 100%;"></textarea>
                                    <p>Upload an file (Optional)</p>
                                    <input type="file" name="comment_file">
                                    <input type="submit" value="Comment" class="comment-button">
                                </div>
                              </form>
                            </div>
                            
                            

                        </div>

                        <!-- /.Comment -->
                </div>
               <!--right sction ends here-->
              </div>
            <!--Task Detail ends here-->


            <!-- /.box-body -->

          </div>

          <!-- /.box -->

        </div>

      </div>

      <!-- Main row -->

    </section>

  

</div>
<!-- /.content-wrapper ends here-->      
 

  <script src="{{asset('public/admin_assets/plugins/validations/jquery.validate.js')}}"></script>

  <script src="{{asset('public/admin_assets/plugins/validations/additional-methods.js')}}"></script>

<script>
var allowFormSubmit = { description: 1};

$("#update-task-form").validate({
  rules :{
    "title" : {
        required : true,
        minlength: 10
    },
    "priority" : {
        required : true
    },
    "due_date" : {
        required : true
    },
    "description" : {
        required : true,
        minlength: 10,
        maxlength: 300
    }
  },
  errorPlacement: function(error, element) {
    if (element.hasClass('select2')) {
      error.insertAfter(element.next('span.select2'));
    } else {
      error.insertAfter(element);
    }
  },
  messages :{
    "title" : {
        required : 'Please enter task title.'
    },
    "priority" : {
        required : 'Please select priority.'
    },
    "due_date" : {
        required : 'Please select a due date.'
    },
    "description" : {
        required : 'Please enter task description.'
    }
  }
});

  $("#addCommentForm").validate({
    rules :{
      "comment_text" : {
          required : true,
      },
      "comment_file" : {
          extension: "xls|xlsx|jpeg|jpg|png|pdf|doc",
          filesize: 2097152  //2 MB
      }
    },
    messages :{
      "comment_text" : {
          required : 'Please enter a Comment',
      },
      "comment_file" : {
          extension : 'Please select a file in xls, xlsx, jpg, jpeg, png, pdf or doc format only.',
          filesize: 'Filesize should be less than 2 MB.'
      }
    }
  });
  
  $.validator.addMethod('filesize', function(value, element, param) {
	    return this.optional(element) || (element.files[0].size <= param) 
	});

  var today = "{{date('Y-m-d')}}";
  var minimumDate = new Date(today);
  $("#task_due_date").datepicker({
    startDate: minimumDate,
    autoclose: true,
    orientation: "bottom"
  });

  // $("#reminder_date").datepicker({
  //   autoclose: true,
  //   orientation: "bottom"
  // });

  var defReminder = "{{@$task->reminder_status}}";
  if(parseInt(defReminder)){
    $("#task_remind_me").prop("checked",true);
  }

  var defReminderNotification = "{{@$task->reminder_notification}}";
  if(parseInt(defReminderNotification)){
    $("#reminder_notification").prop("checked",true);
  }

  var defReminderEmail = "{{@$task->reminder_email}}";
  if(parseInt(defReminderEmail)){
    $("#reminder_email").prop("checked",true);
  }

  var defReminderDays = "{{@$task->reminder_days}}";
  if(defReminderDays){
    $("#reminder_days").val(defReminderDays);
  }

  var defPriority = "{{@$task->priority}}";
  if(defPriority){
    $("#priority").val(defPriority);
  }

  $('#description').wysihtml5({
    "events": {
        "blur": function() { 
          var value = $('#description').val();
          var striped = $(value).text();
          striped = striped.trim();
          
          if(striped.length <= 0){
            allowFormSubmit.description = 0;
            $(".descriptionErrors").text("Please enter the description.").css("color","#f00");
            $(".descriptionErrors").show();
          }else{
            allowFormSubmit.description = 1;
            $(".descriptionErrors").text("");
            $(".descriptionErrors").hide();
          }
        },
        "change": function() { 
          var value = $('#description').val();
          var striped = $(value).text();
          striped = striped.trim();
          
          if(striped.length <= 0){
            allowFormSubmit.description = 0;
            $(".descriptionErrors").text("Please enter the description.").css("color","#f00");
            $(".descriptionErrors").show();
          }else{
            allowFormSubmit.description = 1;
            $(".descriptionErrors").text("");
            $(".descriptionErrors").hide();
          }
        }
      }
  });

  $("#addTaskFormSubmit").on('click', function(){
    if(allowFormSubmit.description != 1){
      return false;
    }else{
      $("#update-task-form").submit();
    }
  });
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
});


</script>
@endsection

