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
        Change Approvals List
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
                      <li><a href='{{url("attendances/change-approvals/pending")}}'>Pending</a></li>
                      <li><a href='{{url("attendances/change-approvals/approved")}}'>Approved</a></li>
                      <li><a href='{{url("attendances/change-approvals/rejected")}}'>Rejected</a></li>
                    </ul>
                </div>
              
              <table id="listRequestedChanges" class="table table-bordered table-striped">
                <thead class="table-heading-style">
                <tr>
                  <th>S.No.</th>
                  <th>Requested By</th>
                  <th>Date</th>
                  <th>In-Time</th>
                  <th>Out-Time</th>
                  <th>User Remarks</th>
                  <th>Comments</th>
                  <th>Final Status</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                  
                @foreach($approvals as $key =>$value)  
                @php
                  $dates_array = [];
                  $first_punch_array = [];
                  $last_punch_array = [];
                  $intime_array = [];
                  $outtime_array = [];
                @endphp
                <tr>
                  <td>{{$loop->iteration}}</td>
                  <td>{{$value->user->employee->fullname}}</td>
                  <td>
                    @foreach($value->attendanceChange->attendanceChangeDates as $value2)
                      <span class="label label-info">{{date("d/m/Y",strtotime($value2->on_date))}}</span>
                      @php
                        $dates_array[] = date("d/m/Y",strtotime($value2->on_date));
                        $first_punch_array[] = $value2->first_punch; 
                        $last_punch_array[] = $value2->last_punch;
                        
                        if($value2->on_time){
                          $intime_array[] = date("h:i A",strtotime($value2->on_time));
                        }else{
                          $intime_array[] = "NA";
                        }

                        if($value2->out_time){
                          $outtime_array[] = date("h:i A",strtotime($value2->out_time));
                        }else{
                          $outtime_array[] = "NA";
                        } 
                      @endphp
                    @endforeach
                  </td>
                  <td>{{implode(",",$intime_array)}}</td>
                  <td>{{implode(",",$outtime_array)}}</td>
                  <td title="{{$value->attendanceChange->remarks}}">
                    @if(strlen($value->attendanceChange->remarks) > 30)
                      {{substr($value->attendanceChange->remarks, 0, 30)}}...
                    @else
                      {{$value->attendanceChange->remarks}}
                    @endif
                  </td>
                  <td><a href="javascript:void(0)" class="commentsModal" data-attendancechangeid="{{$value->attendanceChange->id}}"><i class="fa fa-envelope fa-2x"></i></a></td>
                  <td>
                  	@if($value->attendanceChange->final_status == 0)
                  		<span class="label label-danger">Not Approved</span>
                  	@elseif($value->attendanceChange->final_status == 1)
                  		<span class="label label-success">Approved</span>  
                  	@endif
                  </td>
                  <td>
                    @if($value->status == '0')
                    <div class="dropdown">
                        <button class="btn btn-warning dropdown-toggle" type="button" data-toggle="dropdown">
                          {{"None"}}
                          
                      <span class="caret"></span></button>
                      <ul class="dropdown-menu">
                        <li><a href='javascript:void(0)' class="approvalStatus" data-userid="{{$value->user_id}}" data-status="1" data-managerid="{{$value->manager_id}}" data-priority="{{$value->priority}}" data-remarks="{{$value->attendanceChange->remarks}}" data-datesarray="{{json_encode($dates_array)}}" data-firstpuncharray="{{json_encode($first_punch_array)}}" data-lastpuncharray="{{json_encode($last_punch_array)}}" data-intimearray="{{json_encode($intime_array)}}" data-outtimearray="{{json_encode($outtime_array)}}" data-statusname="Approved" data-acaid="{{$value->id}}">Approve</a></li>
                        
                        <li><a href='javascript:void(0)' class="approvalStatus" data-userid="{{$value->user_id}}" data-status="2" data-managerid="{{$value->manager_id}}" data-remarks="{{$value->attendanceChange->remarks}}" data-datesarray="{{json_encode($dates_array)}}" data-priority="{{$value->priority}}" data-firstpuncharray="{{json_encode($first_punch_array)}}" data-lastpuncharray="{{json_encode($last_punch_array)}}" data-intimearray="{{json_encode($intime_array)}}" data-outtimearray="{{json_encode($outtime_array)}}" data-statusname="Rejected" data-acaid="{{$value->id}}">Reject</a></li>
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
                  <th>Applied At</th>
                  <th>Date</th>
                  <th>In-Time</th>
                  <th>Out-Time</th>
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

    <div class="modal fade" id="attendanceStatusModal">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Attendance Status Form</h4>
            </div>
            <div class="modal-body">
              <form id="attendanceStatusForm" action="{{ url('attendances/change-attendance') }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                  <div class="box-body">
                    
                    <div class="form-group">
                      <label for="statusName" class="docType">Selected Status</label>
                      <input type="text" class="form-control" id="statusName" name="statusName" value="" readonly>
                    </div>

                    <div class="form-group" id="selected-dates">
                      
                    </div>

                    <input type="hidden" name="status" id="status">
                    <input type="hidden" name="managerId" id="managerId">
                    <input type="hidden" name="acaId" id="acaId">

                    
                    
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
                    <button type="button" class="btn btn-primary" id="attendanceStatusFormSubmit">Submit</button>
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
    $("#attendanceStatusFormSubmit").on('click',function () {
      if(confirm("Are you sure you want to proceed?")){
        $("#attendanceStatusForm").submit();
      }else{
        return false;
      }
    });
    $(".commentsModal").on('click',function(){
      var attendance_change_id = $(this).data("attendancechangeid");
        
      $.ajax({
        type: 'POST',
        url: "{{ url('attendances/list-comments') }}",
        data: {attendance_change_id: attendance_change_id},
        success: function (result) {
          $(".commentsModalBody").html(result);
          $('#commentsModal').modal('show');
        }
      });
    });
      
    $(".approvalStatus").on('click', function(){
      var status = $(this).data("status");
      var priority = $(this).data("priority");
      var status_name = $(this).data("statusname");
      var attendance_change_approval_id = $(this).data("acaid");
      var manager_id = $(this).data("managerid");
      var remarks = $(this).data("remarks");
      var url = "{{url('attendances/view')}}";
      var user_id = $(this).data("userid");

      $("#selected-dates").empty();

      if(priority == '1'){
        var dates_array = $(this).data('datesarray');
        var first_punch_array = $(this).data('firstpuncharray');
        var last_punch_array = $(this).data('lastpuncharray');
        var intime_array = $(this).data('intimearray');
        var outtime_array = $(this).data('outtimearray');
        var display_string = "";

        if(dates_array){
          dates_array.forEach(function(date, index){
            let dt = date.split("/");
            urlString = "?id="+user_id+"&year="+dt[2]+"&month="+parseInt(dt[1]);
      
            display_string += '<div class="row"><div class="col-md-3 first-col-as"><label>Date</label><input type="text" class="form-control selected-date" name="date['+index+']" value="'+ date +'" disabled></div><div class="col-md-3 second-col-as"><label>Current Punches</label><br><span>First Punch:</span>&nbsp;<label class="label label-success">'+first_punch_array[index]+'</label><br><span class="last-punch">Last Punch:</span>&nbsp;<label class="label label-info">'+last_punch_array[index]+'</label></div><div class="col-md-2 bootstrap-timepicker second-col-as"><label>In Time</label><input type="text" class="form-control" name="time['+index+']" value="'+intime_array[index]+'" disabled></div><div class="col-md-2 bootstrap-timepicker second-col-as"><label>Out Time</label><input type="text" class="form-control" name="out_time['+index+']" value="'+outtime_array[index]+'" disabled></div><div class="col-md-2 third-col-as"><label>View</label><br><a target="_blank" href="'+url+urlString+'"><i class="fa fa-calendar fa-2x"></i></a></div></div><br>';
          });
          $("#selected-dates").append(display_string);

        }
      }

      $("#status").val(status);
      $("#managerId").val(manager_id);
      $("#acaId").val(attendance_change_approval_id);
      $("#statusName").val(status_name);
      $('#remarks').text(remarks);
      $('#attendanceStatusModal').modal('show');
    });

    $('#listRequestedChanges').DataTable({
      "scrollX": true,
      responsive: true
    });
          
  </script>

  @endsection