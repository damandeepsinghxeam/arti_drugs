@extends('admins.layouts.app')



@section('content')



<link rel="stylesheet" href="{{asset('public/admin_assets/plugins/dataTables/jquery.dataTables.min.css')}}">



<!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>

        Applied Leaves List

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

              <div class="row">

                  <div class="col-md-12 all-progress">

                      <h5 class="all-progress-heading">Progress Bar Status: </h5>

                      <img src="{{asset('public/admin_assets/static_assets/circle_mustard.png')}}" alt="circle-error" class="all-circle-error">

                      <span class="all-span-leave">In Progress</span>

                      <img src="{{asset('public/admin_assets/static_assets/circle_ green.png')}}" alt="circle-error" class="all-circle-error">

                      <span class="all-span-leave">Approved</span>

                      <img src="{{asset('public/admin_assets/static_assets/circle_red.png')}}" alt="circle-error" class="all-circle-error">

                      <span>Rejected</span>

                  </div>

              </div>

              <table id="listAppliedLeaves" class="table table-bordered table-striped">

                <thead class="table-heading-style">

                <tr>

                  <th>S.No.</th>

                  <th>Leave Type</th>

                  <th>Applied At</th>

                  <th>My Replacement</th>

                  <th>From Date</th>

                  <th>To Date</th>

                  <th>No Of Days</th>

                  <th>Final Status</th>

                  <th>Progress</th>

                  <th>Remarks</th>

                  <th>Action</th>

                </tr>

                </thead>

                <tbody>

                  

                @foreach($data as $key =>$value)  

                <tr>

                  <td>{{$loop->iteration}}</td>

                  <td><a href="javascript:void(0)" class="additionalLeaveDetails" data-applyleaveid="{{$value->id}}" title="more details">{{$value->leave_type_name}}</a></td>

                  <td>{{date("d/m/Y h:i A",strtotime($value->created_at))}}</td>

                  <td>{{$value->replacement}}</td>

                  <td>{{date("d/m/Y",strtotime($value->from_date))}}</td>

                  <td>{{date("d/m/Y",strtotime($value->to_date))}}</td>

                  <td>{{$value->number_of_days}}</td>

                  <td>
                  	@if($value->final_status == '0' && $value->isactive == 1 && $value->secondary_final_status == 'Rejected')
                  		<span class="label label-danger">{{$value->secondary_final_status}}</span>
                    @elseif($value->final_status == '0' && $value->isactive == 1 && $value->secondary_final_status == 'In-Progress')
                  		<span class="label label-warning">{{$value->secondary_final_status}}</span>  
                  	@elseif($value->final_status == '1' && $value->isactive == 1)
                  		<span class="label label-success">{{$value->secondary_final_status}}</span>
                    @elseif($value->isactive == 0)
                      <span class="label" style="background-color: #001f3f;">Cancelled</span>  
                  	@endif
                  </td>

                  <td class="progress-td">

                    @foreach($value->priority_wise_status as $key2 => $value2)

                        <div class="progress-manager">

                          <hr class="progress-line">

                          <span class="@if($value2->leave_status == '0'){{'none-dot'}}@elseif($value2->leave_status == '1'){{'approved-dot'}}@elseif($value2->leave_status == '2'){{'rejected-dot'}}@endif"></span>

                          <h6 class="progress-line-type">@if($value2->priority == '1'){{'Manager'}}@elseif($value2->priority == '2'){{'HOD'}}@elseif($value2->priority == '3'){{'HR'}}@elseif($value2->priority == '4'){{'MD'}}@endif</h6>

                        </div>

                    @endforeach

                  </td>

                  <td><a href="javascript:void(0)" class="chatModal" data-applyleaveid="{{$value->id}}"><i class="fa fa-envelope fa-2x"></i></a></td>

                  <td>

                    @if($value->can_cancel_leave && $value->isactive == 1)

                      <a href='{{url("leaves/cancel-applied-leave/$value->id")}}'><span class="label label-danger bg-maroon cancelAppliedLeave">Cancel</span></a>

                    @else

                      <span class="label label-default">None</span>

                    @endif  

                  </td>

                </tr>

                @endforeach

                </tbody>

                <tfoot class="table-heading-style">

                <tr>

                  <th>S.No.</th>

                  <th>Leave Type</th>

                  <th>Applied At</th>

                  <th>My Replacement</th>

                  <th>From Date</th>

                  <th>To Date</th>

                  <th>No Of Days</th>

                  <th>Final Status</th>

                  <th>Progress</th>

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



          $(".cancelAppliedLeave").on('click', function(){

            if (!confirm("Are you sure you want to cancel this applied leave?")) {

              return false; 

            }

          });



          $('#listAppliedLeaves').DataTable({

          	"scrollX": true,

            responsive: true

          });

          

      });



      

  </script>



  @endsection