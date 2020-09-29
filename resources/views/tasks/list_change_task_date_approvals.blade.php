@extends('admins.layouts.app')

@section('content')

<style>
.first-col-as {
  padding: 0 10px 0 15px;
}
.second-col-as {
  padding: 0 10px 0 0;
}
.third-col-as {
  padding: 0 0 0 15px;
}
.last-punch{
  margin-left: 1px;  
}
</style>


<link rel="stylesheet" href="{{asset('public/admin_assets/plugins/dataTables/jquery.dataTables.min.css')}}">

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Date extension approval List
        <!-- <small>Control panel</small> -->
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url('employees/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
          <div class="box">
            <!-- /.box-header -->
            @include('admins.validation_errors')

            @if(session()->has('cannot_cancel_error'))
              <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                {{ session()->get('cannot_cancel_error') }}
              </div>
            @endif
            <div class="box-body">
                <div class="dropdown">
                    <button class="btn btn-warning dropdown-toggle" type="button" data-toggle="dropdown">
                    {{ucfirst(@$selected_status)}}  
                    <span class="caret"></span></button>

                    <ul class="dropdown-menu">
                      <li><a href='{{url("tasks/change-task-date-approvals/pending")}}'>Pending</a></li>
                      <li><a href='{{url("tasks/change-task-date-approvals/approved")}}'>Approved</a></li>
                      <li><a href='{{url("tasks/change-task-date-approvals/rejected")}}'>Rejected</a></li>
                    </ul>
                </div>
              
              <table id="listRequestedChanges" class="table table-bordered table-striped">
                <thead class="table-heading-style">
                <tr>
                  <th>S.No.</th>
                  <th>Task</th>
                  <th>Requested By</th>
                  <th>Assigned Date</th>
                  <th>Required Date</th>                  
                  <th>User Remarks</th>
                  <th>Comments</th>
                  <th>Final Status</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                  
                @foreach($approvals as $key =>$value)  
                
                <tr>
                  <td>{{$loop->iteration}}</td>
                  <td><a target="_blank" href="{{url('tasks/info').'/'.$value->task_id}}">{{$value->task_name}}</a></td>
                  <td>{{$value->name}}</td>
                  <td>{{$value->assigned_date}}</td>
                  <td>{{$value->required_date}}</td>
                  <td>{{$value->remarks}}</td>                 
                  <td><a href="javascript:void(0)" class="commentsModal" data-id="{{$value->id}}"><i class="fa fa-envelope fa-2x"></i></a></td>
                  <td>
                  	@if($value->status == 0)
                  		<span class="label label-danger">Not Approved</span>
                  	@elseif($value->status == 1)
                  		<span class="label label-success">Approved</span>
                    @elseif($value->status == 2)
                      <span class="label label-danger">Rejected</span>   
                  	@endif
                  </td>
                  <td>
                    @if($value->status == '0')
                    <div class="dropdown">
                        <button class="btn btn-warning dropdown-toggle" type="button" data-toggle="dropdown">
                          {{"None"}}
                          
                      <span class="caret"></span></button>
                      <ul class="dropdown-menu">
                        <li><a href='javascript:void(0)' class="approvalStatus" data-userid="{{$value->assignee_id}}" data-status="1" data-managerid="{{$value->assignor_id}}" data-remarks="{{$value->remarks}}" data-date_require="{{$value->required_date}}" data-statusname="Approved" data-taskid="{{$value->task_id}}" data-id="{{$value->id}}">Approve</a></li>
                        
                        <li><a href='javascript:void(0)' class="approvalStatus" data-userid="{{$value->assignee_id}}" data-status="2" data-managerid="{{$value->assignor_id}}" data-remarks="{{$value->remarks}}" data-date_require="{{$value->required_date}}" data-statusname="Rejected" data-taskid="{{$value->task_id}}" data-id="{{$value->id}}">Reject</a></li>
                      </ul>
                    </div> 
                    @elseif($value->status == '1')
                      <span class="label label-success">Approved</span>
                    @elseif($value->status == '2')  
                      <span class="label label-danger">Rejected</span>
                    @endif     
                  </td>
                </tr>
                @endforeach
                </tbody>
                <tfoot class="table-heading-style">
                <tr>
                   <th>S.No.</th>
                   <th>Task</th>
                  <th>Requested By</th>
                  <th>Assigned Date</th>
                  <th>Required Date</th>                  
                  <th>User Remarks</th>
                  <th>Comments</th>
                  <th>Final Status</th>
                  <th>Action</th>
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

    <div class="modal fade" id="commentsModal">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Comments List</h4>
            </div>
            <div class="modal-body commentsModalBody">
                
            </div>
            
          </div>
          <!-- /.modal-content -->
        </div>
      <!-- /.modal-dialog -->
      </div>
        <!-- /.modal -->

    <div class="modal fade" id="taskDateStatusModal">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Task Date Status Form</h4>
            </div>
            <div class="modal-body">
              <form id="attendanceStatusForm" action="{{ url('tasks/change-task-date') }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                  <div class="box-body">
                    
                    <div class="form-group">
                      <label for="statusName" class="docType">Selected Status</label>
                      <input type="text" class="form-control" id="statusName" name="statusName" value="" readonly>
                    </div>

                    <div class="form-group" id="selected-dates">
                      
                    </div>

                    <input type="hidden" name="status" id="status">
                    <input type="hidden" name="require_date" id="require_date">
                    <input type="hidden" name="allot_date" id="allot_date">
                    <input type="hidden" name="managerId" id="managerId">
                    <input type="hidden" name="task_id" id="task_id">
                    <input type="hidden" name="id" id="id">

                     <div class="form-group">
                      <label for="comment">Required Date</label>
                       <input type="text" class="form-control" id="require_date_field" name="require_date" value="" readonly>
                    </div>

                    <div class="form-group">
                      <label for="comment">Alloted Date</label>
                       <input type="text" class="form-control datepicker" id="allot_date_field" name="allot_date" value="">
                    </div>
                    
                    <div class="form-group">
                      <label for="comment">User Remarks</label>
                       <textarea class="form-control" rows="5" name="remarks" id="remarks" readonly></textarea>
                    </div>

                    <div class="form-group">
                      <label for="comment">Your Comment</label>
                       <textarea class="form-control" rows="5" name="comment" id="comment"></textarea>
                    </div>
                                 
                  </div>
                  <!-- /.box-body -->
                  <br>

                  <div class="box-footer">
                    <button type="button" class="btn btn-primary" id="taskStatusFormSubmit">Submit</button>
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
  <!-- bootstrap time picker -->
  <script src="{{asset('public/admin_assets/plugins/timepicker/bootstrap-timepicker.min.js')}}"></script>
  <script src="{{asset('public/admin_assets/plugins/validations/jquery.validate.js')}}"></script>
  <script src="{{asset('public/admin_assets/plugins/validations/additional-methods.js')}}"></script>
  <script src="{{asset('public/admin_assets/plugins/dataTables/jquery.dataTables.min.js')}}"></script>

  <script type="text/javascript">

 $("#allot_date_field").datepicker({
        
        autoclose: true,
        orientation: "bottom",
        format: 'yyyy-mm-dd'
    }); 

    $("#attendanceStatusForm").validate({
      rules :{
          "comment" : {
              required : true
          }
      },
      messages :{
          "comment" : {
              required : 'Please enter comment.'
          }
      }
    });
  </script>

  <script type="text/javascript">
    $("#taskStatusFormSubmit").on('click',function () {
      if(confirm("Are you sure you want to proceed?")){
        $("#attendanceStatusForm").submit();
      }else{
        return false;
      }
    });
    $(".commentsModal").on('click',function(){
      var id = $(this).data("id");
        
      $.ajax({
        type: 'POST',
        url: "{{ url('tasks/list-task-change-comments') }}",
        data: {id: id},
        success: function (result) {
          $(".commentsModalBody").html(result);
          $('#commentsModal').modal('show');
        }
      });
    });
      
    $(".approvalStatus").on('click', function(){
      var status = $(this).data("status");
      var date_require = $(this).data("date_require");
      var priority = $(this).data("priority");
      var status_name = $(this).data("statusname");
      var attendance_change_approval_id = $(this).data("acaid");
      var manager_id = $(this).data("managerid");
      var remarks = $(this).data("remarks");
      var url = "{{url('attendances/view')}}";
      var user_id = $(this).data("userid");
      var taskid = $(this).data("taskid");
      var id = $(this).data("id");

      $("#selected-dates").empty();     

      $("#status").val(status);
      $("#allot_date").val(date_require);
      $("#require_date").val(date_require);

      $("#allot_date_field").val(date_require);
      $("#require_date_field").val(date_require);
      $("#task_id").val(taskid);
      $("#id").val(id);
      
      $("#managerId").val(manager_id);
      $("#acaId").val(attendance_change_approval_id);
      $("#statusName").val(status_name);
      $('#remarks').text(remarks);
      $('#taskDateStatusModal').modal('show');
    });

    $('#listRequestedChanges').DataTable({
      "scrollX": true,
      responsive: true
    });
          
  </script>

  @endsection