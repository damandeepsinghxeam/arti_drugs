@extends('admins.layouts.app')

@section('content')

<!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>

        Add Task

        <!-- <small>Control panel</small> -->

      </h1>

      <ol class="breadcrumb">

        <li><a href="{{ url('employees/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>

      </ol>

    </section>



    <!-- Main content -->

    <section class="content">

      <!-- Small boxes (Stat box) -->

      <div class="row">

        <div class="col-md-12">

        <div class="no-print">
          <div class="callout callout-success" style="margin-bottom: 5px!important;">
            <h4><i class="fa fa-info"></i> Note:</h4>
            Create task project & task carefully. You can edit some fields of the task later, only if the user's task status is Not-Started.
          </div>
        </div>

          <div class="box box-primary">
          @include('admins.validation_errors')

            <div class="box-body">

            <form id="addTaskForm" method="POST" action="{{url('tasks')}}" enctype="multipart/form-data">
              {{ csrf_field() }}
              <div class="row task-rows">
                <div class="col-md-3 task-columns">

                <label for="task_project">Task Project</label>

                  <select class="form-control input-sm basic-detail-input-style select2 task-select2-only" name="task_project">
                    <option value="" selected disabled>Please select task project</option>
                    @if(!$data['task_projects']->isEmpty())
                      @foreach($data['task_projects'] as $project)
                        <option value="{{$project->id}}">{{$project->name}}</option>
                      @endforeach
                    @endif

                  </select>
                </div>  
                <div class="col-md-1 task-columns add-tp">   
                  <a href="javascript:void(0)" class="add-task-project">Add <i class="fa fa-plus-square" aria-hidden="true"></i></a>
                </div>
              </div> 
             

             <div class="row task-rows">

               <div class="col-md-3 task-columns">

                 <label for="department">Department</label>

                  <select class="form-control input-sm basic-detail-input-style select2 task-select2-only" name="department[]" id="department" data-placeholder="Please select Department(s)" multiple>

                    @if(!$data['departments']->isEmpty())
                      @foreach($data['departments'] as $department)
                        <option value="{{$department->id}}">{{$department->name}}</option>
                      @endforeach
                    @endif

                  </select>

               </div>

               <div class="col-md-3 task-columns">

                 <label for="assigned_to">Assigned To</label>

                  <select class="form-control input-sm basic-detail-input-style select2 task-select2-only checkLimit" name="assigned_to[]" id="assigned_to" data-placeholder="Please select Employee(s)" multiple>

                  </select>

               </div>

             </div>

              <div class="row task-rows">

                <div class="col-md-7 task-columns">

                  <label for="title">Task Title</label>

                  <input type="text" name="title" id="title" class="form-control input-sm basic-detail-input-style" placeholder="Enter task title">

                  <span class="taskLimitError" style="display: none"></span>

                </div>

                <div class="col-md-2 task-columns">
                  <label for="priority">Priority</label>

                  <select class="form-control input-sm basic-detail-input-style checkLimit" name="priority" id="priority">
                    <option value="" selected disabled>Select</option>
                    <option value="H5">H5</option>
                    <option value="H4">H4</option>
                    <option value="H3">H3</option>
                    <option value="H2">H2</option>
                    <option value="H1">H1</option>
                  </select>
                </div>

                <div class="col-md-2 task-columns">
                  <label for="due_date">Due Date</label>
                  <input autocomplete="off" type="text" class="form-control selectDate input-sm basic-detail-input-style" name="due_date" placeholder="MM/DD/YYYY" value="" id="task_due_date">
                </div>
              </div>



              <!-- Repeat section starts here -->

              <div class="repeatChoose-section">

                <div class="row task-rows">

                  <!-- <div class="col-md-1 task-columns">

                    <span><i class="fa fa-repeat"></i> Repeat</span>&nbsp;

                  </div> -->

                  <div class="col-md-7 task-columns">
                    <label>Task Files</label>
                    <input type="file" name="task_files[]" id="task_files" multiple>

                  </div>

                </div>

              </div>

              



              <!-- Second row starts here -->

              <div class="remind-section">

                <div class="col-md-1 task-columns">

                  <input type="checkbox" name="reminder" id="add_task_reminder">

                  <span class="task-checkbox-label">Reminder</span>

                </div>

                <div class="col-md-3 task-columns">
                  <select class="form-control input-sm basic-detail-input-style" name="time_period" id="time_period" disabled>
                    <option value="0" selected disabled>Select days from creation date</option>
                    <option value="0.5">Twice per day</option>
                    <option value="1">Once everyday</option>
                    <option value="2">Once every 2 days</option>
                    <option value="5">Once every 5 days</option>
                    <option value="10">Once every 10 days</option>
                    <option value="25">Once every month</option>
                  </select>
                </div>

                <div class="col-md-2 task-columns">

                  <input type="checkbox" name="reminder_notification" id="reminder_notification" class="checkTaskNotification" disabled>

                  <span class="task-checkbox-label">Notification</span>

                  <input type="checkbox" name="reminder_mail" id="reminder_mail" class="checkTaskMail" disabled>

                  <span class="task-checkbox-label">Mail</span>

                </div>

              </div>

             <!-- Fourth row starts here -->

             <div class="row task-description-row">

               <div class="col-md-9">

                 <label for="description">Description</label>

                  <textarea name="description" id="description" cols="30" rows="5" placeholder="Add Description" class="add-task-description"></textarea>

                  <span class="descriptionErrors"></span>

               </div>

             </div>



             <button type="button" class="btn btn-primary" id="addTaskFormSubmit">Save</button>
             <a href="{{ url('employees/dashboard') }}" class="btn btn-default">Close</a>

            </form>

            </div>

            <!-- /.box-body -->

          </div>

          <!-- /.box -->

        </div>

      </div>

      <!-- /.row -->

    </section>

    <!-- /.content --> 

    <div class="modal fade" id="taskProjectModal">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Add Task Project Form</h4>
            </div>
            <div class="modal-body">
              <form id="taskProjectForm" action="{{ url('tasks/save-task-project') }}" method="POST">
                {{ csrf_field() }}
                  <div class="box-body">
                    
                    <div class="form-group">
                      <label for="name">Name</label>
                      <input type="text" class="form-control" id="name" name="name">
                    </div>

                    <div class="form-group">
                      <label for="description">Description</label>
                       <textarea class="form-control" rows="7" name="description" id="project_description" >Enter task project description</textarea>
                       <!-- <span class="descriptionErrors"></span> -->
                    </div>
                                 
                  </div>
                  <!-- /.box-body -->
                  <br>

                  <div class="box-footer">
                    <button type="submit" class="btn btn-primary" id="taskProjectFormSubmit">Submit</button>
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

<script type="text/javascript">
var allowFormSubmit = { description: 1, taskLimit: 1};
$("#addTaskForm").validate({
  rules :{
    "task_project" : {
        required : true
    },
    "department[]" : {
        required : true
    },
    "assigned_to[]" : {
        required : true
    },
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
        
    },
    "task_files[]": {
       filesize: 1048576    //1 MB
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
    "task_project" : {
        required : 'Please select a task project.'
    },
    "department[]" : {
        required : 'Please select atleast one department.'
    },
    "assigned_to[]" : {
        required : 'Please select atleast one employee.'
    },
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

$("#taskProjectForm").validate({
  rules :{
    "name" : {
        required : true
    },
    "description" : {
        required : true,
        minlength: 10,
        maxlength: 300
    }
  },
  messages :{
    "name" : {
        required : 'Please task project name.'
    },
    "description" : {
        required : 'Please enter task project description.'
    }
  }
});

$.validator.addMethod('filesize', function(value, element, param) {
  return this.optional(element) || (element.files[0].size <= param) 
});

//Date picker
var minimumDate = new Date();
$("#task_due_date").datepicker({
  startDate: minimumDate,
  // endDate: maximumDate,
  autoclose: true,
  orientation: "bottom"
});

$(".checkLimit").on('change', function(){
  var userIds = $("#assigned_to").val();
  var priority = $("#priority").val();

  if(userIds.length > 0 && priority){
    $(".taskLimitError").empty();
    $.ajax({
      type: 'POST',
      url: "{{url('tasks/check-tasks-limit')}}",
      data: {user_ids: userIds, priority: priority},
      success: function(message){
        if(message){
          $(".taskLimitError").append(message).css({color: '#f00'});
          $(".taskLimitError").show();
          allowFormSubmit.taskLimit = 0;
        }else{
          $(".taskLimitError").append("");
          $(".taskLimitError").hide();
          allowFormSubmit.taskLimit = 1;
        }
      }
    });
  }else{
    allowFormSubmit.taskLimit = 0;
  }
});

$("#addTaskFormSubmit").on('click', function(){
  if(allowFormSubmit.description != 1 || allowFormSubmit.taskLimit != 1){
    return false;
  }else{
    $("#addTaskForm").submit();
  }
});

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


$('#add_task_reminder').on('change', function(){
  if ($("#add_task_reminder").is(':checked'))   {
    $('#time_period').prop('disabled', false);
    $('#reminder_mail').prop('disabled', false);
    $('#reminder_notification').prop('disabled', false);
  }else{
    $('#time_period').val("");
    $('#time_period').prop('disabled', true);
    $('#reminder_mail').prop('checked', false);
    $('#reminder_mail').prop('disabled', true);
    $('#reminder_notification').prop('checked', false);
    $('#reminder_notification').prop('disabled', true);
  }
});

$(".add-task-project").on('click',function(){
  $("#taskProjectModal").modal('show');
});

$("#department").on('change',function(){
  var info = "";
  var department_ids = $(this).val();

  $("#assigned_to").empty();

  $.ajax({
    type: 'POST',
    url: "{{url('employees/departments-wise-employees')}}",
    data: {department_ids: department_ids},
    success: function(result){
      if(result.length > 0){
        result.forEach(function(item){
          if(item.user_id != 1){
            let userInfo = item.fullname + "(" + item.employee_code + ")";
            info += '<option value="'+item.user_id+'">'+userInfo+'</option>';
          }  
        });
      }else{
        info += '<option value="">None</option>';
      }

      $("#assigned_to").append(info);
      
    }
  })
});

</script>

@endsection