@extends('admins.layouts.app')

@section('content')

<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper">

<!-- Content Header (Page header) -->

<section class="content-header">

  <h1>

    Request date extension form

    <!-- <small>Control panel</small> -->

  </h1>

  <ol class="breadcrumb">

    <li><a href="{{ url('employees/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>

  </ol>

</section>



<!-- Main content -->

<section class="content">
  
  
  <!-- Small boxes (Stat box) -->

  <div class="box box-info col-sm-6">
    <!-- <div class="box-header with-border">
        <h3 class="box-title">Horizontal Form</h3>
    </div> -->
    <!-- /.box-header -->
    <!-- form start -->
    @include('admins.validation_errors')
    
    <form id="changeTaskDateForm" class="form-horizontal" action="{{url('tasks/save-task-date-change-request')}}" method="POST">
    {{ csrf_field() }}
        <div class="box-body">
        
        <div class="form-group">
            <label class="col-sm-2 control-label">Task Title</label>

            <div class="col-sm-10">
                <div class="input-group date single-input-lbl">
                   
                    <select style="background-color:#fff" class="form-control pull-right select2" name="task_title" id="task_title" placeholder="Select Task">
                        <option value="">Please select task</option>     
                      @foreach($data['mytask'] as $task)
                        <option value="{{$task->id}}">{{$task->title}}</option>
                      @endforeach
                    </select>
                </div>
            </div>
        </div>

         <div class="form-group">
            <label for="dates" class="col-sm-2 control-label">Assigned Date</label>

            <div class="col-sm-10">
                <div class="input-group date single-input-lbl">
                    <div class="input-group-addon date-icon input-sm basic-detail-input-style">
                    <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" style="background-color:#fff" class="form-control pull-right date-input input-sm basic-detail-input-style al-date-input" name="assigned_date" id="assigned_date" placeholder="Select date" readonly>
                    <span class="dates-error"></span>
                </div>
            </div>
        </div>

         <div class="form-group">
            <label for="dates" class="col-sm-2 control-label">Required Date</label>

            <div class="col-sm-10">
                <div class="input-group date single-input-lbl">
                    <div class="input-group-addon date-icon input-sm basic-detail-input-style">
                    <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" style="background-color:#fff" class="form-control pull-right date-input input-sm basic-detail-input-style al-date-input" name="required_date" id="date" placeholder="Select date" readonly>
                    <span class="dates-error"></span>
                </div>
            </div>
        </div>

     <input type="hidden" name="creator_id" value="" id="creator">
     
     <input type="hidden" name="assignee_id" value="{{$data['assignee_id']}}" id="assignee_id">

        
        <div class="form-group">
            <label class="col-sm-2 control-label">Remarks</label>
            <div class="col-sm-10">
                <textarea class="form-control" name="remarks" rows="5" placeholder="Please enter explaination for sending task date change request."></textarea>
            </div>
        </div>
        
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            <a href="{{url('employees/dashboard')}}" class="btn btn-default">Cancel</a>
            <button type="button" class="btn btn-info pull-right" id="changeTaskDateFormSubmit">Submit</button>
        </div>
        <!-- /.box-footer -->
    </form>
    </div>

  <!-- /.row -->

  <!-- /.row (main row) -->

</section>

<!-- /.content -->

</div>

<!-- /.content-wrapper -->
<!-- bootstrap time picker -->
<script src="{{asset('public/admin_assets/plugins/timepicker/bootstrap-timepicker.min.js')}}"></script>

<script src="{{asset('public/admin_assets/plugins/validations/jquery.validate.js')}}"></script>
<script src="{{asset('public/admin_assets/plugins/validations/additional-methods.js')}}"></script>
<script>

    $("#changeTaskDateForm").validate({
      rules :{
          "assigned_date" : {
              required : true
          },
          "required_date" : {
              required : true
          },
          "remarks" : {
              required : true,
              maxlength: 100
          },
          "task_title": {
              required : true
          }
      },
      messages :{
          "assigned_date" : {
              required : 'Assigned Date is required.'
          },
          "required_date" : {
              required : 'Please select required date.'
          },
          "remarks" : {
              required : 'Please enter remarks for date esxtension.',
              maxlength : 'Maximum 100 characters are allowed.'
          },
          "task_title": {
              required : 'Please select task.'
          }
      }
    });
</script>

<script>
    var maximum_date = moment()._d;
    //var minimum_date = moment().subtract(1, 'months').startOf('month')._d;
    var minimum_date = moment().subtract(0, 'days').startOf('day')._d;

    $("#date").datepicker({
        startDate: minimum_date,
        autoclose: true,
        orientation: "bottom",
        format: 'yyyy-mm-dd'
    }); 
    

    
    
    $("#task_title").on('change', function(){
        $(".dates-error").text("");
        var task_id = $(this).val();
        
        if(task_id){

            $.ajax({
                type: "POST",
                url: "{{url('tasks/check-assigned-date')}}",
                data: {task_id: task_id},
                success: function(result){                  
                    if(result.mytask){                      
                        allow_form_submit.dates = 0;
                        $("#assigned_date").val(result.mytask.due_date);
                        $("#creator").val(result.mytask.user_id);
                    }
                }
            });
        }           
    });
    


    var allow_form_submit = {date: 1};    

    $("#changeTaskDateFormSubmit").on('click', function(){
        if(!allow_form_submit.date){
            return false;
        }else{
            $("#changeTaskDateForm").submit();
        }
    });
</script>

@endsection