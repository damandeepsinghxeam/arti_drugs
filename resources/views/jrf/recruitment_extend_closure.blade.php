@extends('admins.layouts.app')
@section('content')
<link rel="stylesheet" href="{{asset('public/admin_assets/plugins/dataTables/jquery.dataTables.min.css')}}">

<script src="{{asset('public/admin_assets/plugins/validations/jquery.validate.js')}}"></script>
<script src="{{asset('public/admin_assets/plugins/validations/additional-methods.js')}}"></script>


<style>
table tr th { vertical-align: middle !important;}
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
    <h1><i class="fa fa-calendar"></i> JRF Date Extend</h1>
    <ol class="breadcrumb">
      <li><a href="{{ url('employees/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
    </ol>
   </section>
   <!-- Main content -->
   <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-sm-12">
        <div class="box box-primary">
          <div class="box-body">

             <div class="alert-dismissible">
              @if(session()->has('success'))
                <div class="alert {{(session()->get('error')) ? 'alert-danger' : 'alert-success'}}">
                  {{ session()->get('success') }}
                </div>
              @endif
            </div>
            
            <!-- Progress showing section starts here -->
            <div class="row">
              <div class="col-md-12 all-progress">
                <div>
                  <h5 class="all-progress-heading">Progress Bar Status: </h5>
                  <img src="{{asset('public/admin_assets/static_assets/circle_mustard.png')}}" alt="circle-error" class="all-circle-error">
                  <span class="all-span-leave">In Progress</span>
                  <img src="{{asset('public/admin_assets/static_assets/circle_ green.png')}}" alt="circle-error" class="all-circle-error">
                  <span class="all-span-leave">Approved</span>
                  <img src="{{asset('public/admin_assets/static_assets/circle_red.png')}}" alt="circle-error" class="all-circle-error">
                  <span>Rejected</span>
                </div>
              </div>
            </div>
            <!-- Progress showing section Ends here -->

            <div class="dropdown m-b-sm">
              <button class="btn btn-warning dropdown-toggle" type="button" data-toggle="dropdown">
                {{@$selected_status}}
                <span class="caret"></span>
              </button>
              <ul class="dropdown-menu">
                 <li><a href='{{url("jrf/recruitment-tasks-extend-date/pending")}}'>Pending</a></li>
                 <li><a href='{{url("jrf/recruitment-tasks-extend-date/assigned")}}'>Approved</a></li>
                 <li><a href='{{url("jrf/recruitment-tasks-extend-date/rejected")}}'>Rejected</a></li>
                 <li><a href='{{url("jrf/recruitment-tasks-extend-date/discussion")}}'>Discussion</a></li>
              </ul>
            </div>

            <table id="listHolidays" class="table table-bordered table-striped text-center">
              <thead class="table-heading-style">
                <tr>
                  <th>Sr.</th>
                  <th>JRF No</th>
                  <th>Project</th>
                  <th>Department</th>
                  <th>Designation</th>
                  <th>No of position</th>                        
                  <th>Assigned date</th>
                  <th>Closure Timeline</th>
                  <th>New Date</th>
                  <th>Reason for extension</th>
                  <th>Action</th>
                 <!--  <th>Status</th> -->
                </tr>
              </thead>
              <tbody>
               @foreach($data as $dat)
                <tr> 
                  <td>{{$loop->iteration}}</td>
                  <td><a  target="_blank" href='{{ url("jrf/view-jrf/$dat->jrf_id")}}'>{{$dat->jrf_no}}</a></td>
                  <td>{{$dat->proj_name}}</td>
                  <td>{{$dat->department}}</td>
                  <td>{{$dat->designation}}</td>
                  <td>{{$dat->npos}}</td>
                  
                  <td>{{@$dat->recruitment_assigned_date}}</td>
                  <td>{{@$dat->jrf_closure_timeline}}</td>
                  <td>{{@$dat->extended_date}}</td>
                  <td>{{@$dat->date_remark}}</td>
                  <td>                       
                    <div class="dropdown">
                    @if($dat->final_status == '0' && $dat->jrf_status == '0')
                    <button class="btn btn-warning dropdown-toggle" type="button" data-toggle="dropdown">{{"None"}} 

                    @elseif($dat->final_status == '1')</button>
                    <button class="btn btn-success dropdown-toggle" type="button" data-toggle="dropdown">
                    {{"Closed"}} 

                    @elseif($dat->final_status == '0' &&  $dat->jrf_status == '1')</button>
                    <button class="btn btn-success dropdown-toggle" type="button" >
                    {{"Approved"}} 

                    @elseif($dat->final_status == '0' && $dat->jrf_status == '2')</button>
                    <button class="btn btn-danger dropdown-toggle" type="button">
                    {{"Rejected"}}

                    @elseif($dat->final_status == '0' &&  $dat->jrf_status == '3')</button>
                    <button class="btn btn-primary dropdown-toggle" type="button" >
                    {{"Discussion"}}@endif
                    <span class="caret"></span></button> 


                    <ul class="dropdown-menu">
                     
                      <li><a href='javascript:void(0)' class="approvalStatus"  data-statusname="Approved" data-final_status="1"  data-jrf_id="{{@$dat->jrf_id}}" data-supervisor_id="{{@$dat->supervisor_id}}"  data-u_id="{{@$dat->user_id}}" data-assigned_to_id="{{@$dat->j_u_id}}" data-extended_date="{{@$dat->extended_date}}" >Approve</a></li>


                      <li><a href='javascript:void(0)' class="approvalStatus"  data-statusname="Rejected" data-final_status="2"  data-jrf_id="{{@$dat->jrf_id}}" data-supervisor_id="{{@$dat->supervisor_id}}"  data-u_id="{{@$dat->user_id}}" data-assigned_to_id="{{@$dat->j_u_id}}" data-extended_date="{{@$dat->extended_date}}" >Reject</a></li>

                    @if($dat->supervisor_id == '13') 
                      <li><a href='javascript:void(0)' class="approvalStatus"  data-statusname="Discussion" data-final_status="3"  data-jrf_id="{{@$dat->jrf_id}}" data-supervisor_id="{{@$dat->supervisor_id}}"  data-u_id="{{@$dat->user_id}}" data-assigned_to_id="{{@$dat->j_u_id}}" data-extended_date="{{@$dat->extended_date}}" >Discussion</a></li>
                    @endif

                    
                     <!-- <li><a href='{{url('jrf/management-closure')}}' > Position desolved </a></li>-->
                    </ul>

                  </div>
                  </td>
                       
                </tr>
              @endforeach
              </tbody>
              <tfoot class="table-heading-style">
                 <tr>
                    <th>Sr.</th>
                    <th>JRF No</th>
                    <th>Project</th>
                    <th>Department</th>
                    <th>Designation</th>
                    <th>No of position</th>
                    <th>Assigned date</th>
                    <th>Closure Timeline</th>
                    <th>New Date</th>
                    <th>Reason for extension</th>
                    <th>Action</th>
                 </tr>
              </tfoot>
            </table>
          </div><!-- /.box-body -->
        </div><!-- /.box -->
      </div>
    </div>

<div class="modal fade" id="statusModal">
         <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title">Extend Date</h4>
               </div>
               <div class="modal-body">
                  <form id="statusForm" action="{{url('jrf/save-ext-date-approval')}}" method="POST">
                     {{ csrf_field() }}
                     <div class="box-body">
                        <div class="form-group">
                          <label for="statusName" class="docType">Selected Status</label>
                          <input type="text" class="form-control" id="statusname" name="statusName" value="" readonly>
                        </div>

                        <div class="form-group">
                          <label for="statusName" class="docType">Remarks</label>
                          <input type="text" class="form-control" id="remarks" name="remarks" value="">
                        </div>

                        <!--<div class="form-group">
                          <label for="statusName" class="docType">Extended Date</label>
                          <input type="date" class="form-control" id="ext_dt" name="ext_dt" value="{{@$dat->extended_date}}">
                        </div> -->

                        <input type="hidden" name="u_id" id="modalUserId">
                        <input type="hidden" name="jrf_id" id="modaljrfId">
                        <input type="hidden" name="assigned_to_id" id="modalassignedId">
                        <input type="hidden" name="final_status" id="modalfnlsts">
                        <input type="hidden" name="extended_date" id="modalextended_date">
                        <input type="hidden" name="supervisor_id" id="modalsupervisorId">

                                              

                      </div>
                     <!-- /.box-body -->
                     <div class="box-footer">
                        <button type="submit" class="btn btn-primary statusFormSubmit">Submit</button>
                     </div>
                  </form>
               </div>
            </div>
            <!-- /.modal-content -->
         </div>
         <!-- /.modal-dialog -->
      </div>

  </section>
 <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script src="{{asset('public/admin_assets/plugins/dataTables/jquery.dataTables.min.js')}}"></script>
  <script type="text/javascript">
      $(document).ready(function() {
         $('#listHolidays').DataTable({
           //scrollX: true,
           //responsive: true
         });
      });

    $('.approvalStatus').on('click',function(){
 
      var employee = $(this).data("u_id");
      var jrf_id = $(this).data("jrf_id");
      var assigned_id = $(this).data("assigned_to_id");
      var statusname = $(this).data("statusname");
      var final_status = $(this).data("final_status");
      var extended_date = $(this).data("extended_date");
      var supervisor_id = $(this).data("supervisor_id");

      
      var status = $(this).data("status");
      
      $("#modalUserId").val(employee);
      $("#modaljrfId").val(jrf_id);
      $("#modalassignedId").val(assigned_id);
      $("#statusname").val(statusname);
      $("#modalfnlsts").val(final_status);
      $("#modalextended_date").val(extended_date);
      $("#modalsupervisorId").val(supervisor_id);

      if(status == 0){
 
        $("#modalAction").val("deactivate");
        var modalTitle = "REQUEST FOR DATE EXTENDS";
        var actionDate = "Reject";
      }

      $('.modal-title').text(modalTitle);
      $('.actionDate').text(actionDate);
      $('#statusModal').modal('show');
 
    });

     $("#statusForm").validate({
      rules: {
        "remarks" : {
          required: true
        }
        
      },
      messages: {
          "remarks" : {
            required: 'Fill Remarks'
          },
          
        }
  });


    $(".future_mgmt_dt").datetimepicker({
      minDate : new Date(),
      format: 'MM/DD/Y hh:mm A',
    });

  </script>
@endsection