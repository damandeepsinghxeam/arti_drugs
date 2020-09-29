@extends('admins.layouts.app')



@section('content')



<link rel="stylesheet" href="{{asset('public/admin_assets/plugins/dataTables/jquery.dataTables.min.css')}}">



<!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>

        Leave Approval List

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

          <div class="box">

            <!-- <div class="box-header">

            </div> -->

            <!-- /.box-header -->

            @include('admins.validation_errors')



            <div class="box-body">
              <div class="dropdown">
                <button class="btn btn-warning dropdown-toggle" type="button" data-toggle="dropdown">
                {{@$selected_status}} 
                <span class="caret"></span></button>

                <ul class="dropdown-menu">
                <li><a href='{{url("leaves/approve-leaves/pending")}}'>Pending</a></li>
                <li><a href='{{url("leaves/approve-leaves/approved")}}'>Approved</a></li>
                <li><a href='{{url("leaves/approve-leaves/rejected")}}'>Rejected</a></li>
                </ul>
              </div>

              <table id="listLeaveApproval" class="table table-bordered table-striped" style="height:150px;">

                <thead class="table-heading-style">

                <tr>

                  <th>S.No.</th>

                  <th>Applied By</th>

                  <th>Applied At</th>

                  <th>Leave Type</th>

                  <th>My Replacement</th>

                  <th>From Date</th>

                  <th>To Date</th>

                  <th>No Of Days</th>

                  <th>Final Status</th>

                  <th>Remarks</th>

                  <th>Action</th>

                </tr>

                </thead>

                <tbody>

                @foreach($data as $key =>$value)  

                <tr>

                  <td>{{$loop->iteration}}</td>

                  <td>{{$value->applier_name}}</td>

                  <td>{{date("d/m/Y h:i A",strtotime($value->created_at))}}</td>

                  <td><a href="javascript:void(0)" class="additionalLeaveDetails" data-applyleaveid="{{$value->applied_leave_id}}" title="more details">{{$value->leave_type_name}}</a></td>

                  <td>{{$value->replacement_name}}</td>

                  <td>{{date("d/m/Y",strtotime($value->from_date))}}</td>

                  <td>{{date("d/m/Y",strtotime($value->to_date))}}</td>

                  <td>{{$value->number_of_days}}</td>

                  <td>

                    @if($value->final_status == '0' && $value->secondary_final_status == 'Rejected')
                      <span class="label label-danger">{{$value->secondary_final_status}}</span>
                    @elseif($value->final_status == '0' && $value->secondary_final_status == 'In-Progress')
                      <span class="label label-warning">{{$value->secondary_final_status}}</span>  
                    @elseif($value->final_status == '1')
                      <span class="label label-success">Approved</span>
                    @endif

                  </td>

                  <td><span class="chatModal" data-applyleaveid="{{$value->applied_leave_id}}"><i class="fa fa-envelope fa-2x"></i></span></td>

                  <td>

                        <div class="dropdown">

                            @if($value->leave_status == '0')

                            <button class="btn btn-warning dropdown-toggle" type="button" data-toggle="dropdown">

                             {{"None"}}

                            @elseif($value->leave_status == '1')

                            <button class="btn btn-success dropdown-toggle" type="button" data-toggle="dropdown">

                             {{"Approved"}}

                            @elseif($value->leave_status == '2')

                            <button class="btn btn-danger dropdown-toggle" type="button" data-toggle="dropdown">

                             {{"Rejected"}}  

                            @endif  

                          <span class="caret"></span></button>

                          <ul class="dropdown-menu">

                            <li><a href='javascript:void(0)' class="approvalStatus" data-leavestatus="1" data-employeeid="{{$value->user_id}}" data-priority="{{$value->priority}}" data-statusname="Approved" data-alaid="{{$value->id}}">Approve</a></li>

                            

                            <li><a href='javascript:void(0)' class="approvalStatus" data-leavestatus="2" data-employeeid="{{$value->user_id}}" data-statusname="Rejected" data-alaid="{{$value->id}}">Reject</a></li>

                          </ul>

                        </div>

                  </td>

                </tr>

                @endforeach

                </tbody>

                <tfoot class="table-heading-style">

                <tr>

                  <th>S.No.</th>

                  <th>Applied By</th>

                  <th>Applied At</th>

                  <th>Leave Type</th>

                  <th>My Replacement</th>

                  <th>From Date</th>

                  <th>To Date</th>

                  <th>No Of Days</th>

                  <th>Final Status</th>

                  <th>Remarks</th>

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



    <div class="modal fade" id="chatModal">

        <div class="modal-dialog">

          <div class="modal-content">

            <div class="modal-header">

              <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                <span aria-hidden="true">&times;</span></button>

              <h4 class="modal-title">Messages List</h4>

            </div>

            <div class="modal-body chatModalBody">

                

            </div>

            

          </div>

          <!-- /.modal-content -->

        </div>

      <!-- /.modal-dialog -->

      </div>

        <!-- /.modal -->



      <div class="modal fade" id="privateChatModal">

        <div class="modal-dialog">

          <div class="modal-content">

            <div class="modal-header">

              <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                <span aria-hidden="true">&times;</span></button>



              <h4 class="modal-title"><i class="fa fa-comments-o"></i> Chat List</h4>

            </div>

            <div class="modal-body privateChatModalBody">



          

                

            </div>

            

          </div>

          <!-- /.modal-content -->

        </div>

      <!-- /.modal-dialog -->

      </div>

      <!-- /.modal -->  



    <div class="modal fade" id="leaveStatusModal">

        <div class="modal-dialog">

          <div class="modal-content">

            <div class="modal-header">

              <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                <span aria-hidden="true">&times;</span></button>

              <h4 class="modal-title">Leave Status Form</h4>

            </div>

            <div class="modal-body">

              <form id="leaveStatusForm" action="{{ url('leaves/save-leave-approval') }}" method="POST" enctype="multipart/form-data">

                {{ csrf_field() }}

                  <div class="box-body">

                    

                    <div class="form-group">

                      <label for="statusName" class="docType">Selected Status</label>

                      <input type="text" class="form-control" id="statusName" name="statusName" value="" readonly>

                    </div>



                    <input type="hidden" name="leaveStatus" id="leaveStatus">

                    <input type="hidden" name="userId" id="userId">

                    <input type="hidden" name="alaId" id="alaId">



                    <div class="form-group">

                      <label for="remark">Remark</label>

                       <textarea class="form-control" rows="5" name="remark" id="remark"></textarea>

                    </div>

                                 

                  </div>

                  <!-- /.box-body -->

                  <br>



                  <div class="box-footer">

                    <button type="submit" class="btn btn-primary" id="leaveStatusFormSubmit">Submit</button>

                  </div>

            </form>

            </div>

            

          </div>

          <!-- /.modal-content -->

        </div>

      <!-- /.modal-dialog -->

      </div>

        <!-- /.modal -->



      <div class="modal fade" id="additionalLeaveDetails">

        <div class="modal-dialog">

          <div class="modal-content">

            <div class="modal-header">

              <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                <span aria-hidden="true">&times;</span></button>

              <h4 class="modal-title">Additional Details</h4>

            </div>

            <div class="modal-body additionalLeaveDetailsBody">

                

            </div>

            

          </div>

          <!-- /.modal-content -->

        </div>

      <!-- /.modal-dialog -->

      </div>

        <!-- /.modal -->  

  </div>

  <!-- /.content-wrapper -->



  <script src="{{asset('public/admin_assets/plugins/dataTables/jquery.dataTables.min.js')}}"></script>

  <script type="text/javascript">

      $(document).ready(function() {



          $(".approvalStatus").on('click',function(){

            var leaveStatus = $(this).data("leavestatus");

            var userId = $(this).data("employeeid");

            var statusName = $(this).data("statusname");

            var leaveApprovalId = $(this).data("alaid");

            var priority = $(this).data("priority");



            if(leaveStatus == 1 && priority == 1){

              alert("Please ensure that replacement is available and work will not hamper during this period.");

            }



            $("#leaveStatus").val(leaveStatus);

            $("#userId").val(userId);

            $("#alaId").val(leaveApprovalId);

            $("#statusName").val(statusName);

            

            $('#leaveStatusModal').modal('show');

          });



          $(".chatModal").on('click',function(){

            var applyLeaveId = $(this).data("applyleaveid");

             

            $.ajax({

              type: 'POST',

              url: "{{ url('leaves/messages') }}",

              data: {applied_leave_id: applyLeaveId},

              success: function (result) {

                $(".chatModalBody").html(result);

                $('#chatModal').modal('show');

              }

            });

          });



          // $(".privateChatModal").on('click',function(){

          //   var leaveApprovalStatusId = $(this).data("lasid");

             

          //   $.ajax({

          //     type: 'POST',

          //     url: "{{ url('/employees/leaves/getLeavePrivateChat') }}",

          //     data: {leaveApprovalStatusId: leaveApprovalStatusId},

          //     success: function (result) {

          //       $(".privateChatModalBody").html(result);

          //       $('#privateChatModal').modal('show');

          //     }

          //   });

          // });



          $(".additionalLeaveDetails").on('click',function(){

            var applyLeaveId = $(this).data("applyleaveid");



            $.ajax({

              type: 'POST',

              url: "{{ url('leaves/applied-leave-info') }}",

              data: {applied_leave_id: applyLeaveId},

              success: function (result) {

                $(".additionalLeaveDetailsBody").html(result);

                $('#additionalLeaveDetails').modal('show');

              }

            });

          });



          $('#listLeaveApproval').DataTable({

            "scrollX": true,

            responsive: true

          });

          

      });



      

  </script>



  <script src="{{asset('public/admin_assets/plugins/validations/jquery.validate.js')}}"></script>

  <script src="{{asset('public/admin_assets/plugins/validations/additional-methods.js')}}"></script>

  <script>

    $("#leaveStatusForm").validate({

      rules :{

          "remark" : {

              required : true,

          }

      },

      messages :{

          "remark" : {

              required : 'Please enter a remark.',

          }

      }

    });



    // $("#mainApproverLeaveReplyForm").validate({

    //   rules :{

    //       "replyMessage" : {

    //           required : true,

    //       }

    //   },

    //   messages :{

    //       "replyMessage" : {

    //           required : 'Please enter a message.',

    //       }

    //   }

    // });

  </script>

  @endsection