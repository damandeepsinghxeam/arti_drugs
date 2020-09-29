@extends('admins.layouts.app')
@section('content')
<link rel="stylesheet" href="{{asset('public/admin_assets/plugins/dataTables/jquery.dataTables.min.css')}}">

<script src="{{asset('public/admin_assets/plugins/validations/jquery.validate.js')}}"></script>
<script src="{{asset('public/admin_assets/plugins/validations/additional-methods.js')}}"></script>

<style type="text/css">
a.btn.btn-primary.rec_tasks { font-size: x-small; }
table tr th, table tr td { vertical-align: middle !important; }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
    <h1><i class="fa fa-user"></i> Level 1 Screening (Recruiter)</h1>
    <ol class="breadcrumb">
      <li><a href="{{ url('employees/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
    </ol>
   </section>


   <!-- Main content -->
   <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
    	<div class="col-md-12">
       		<div class="box box-primary">
            <!-- /.box-header -->
              	<div class="box-body">

                   <div class="alert-dismissible">
                      @if(session()->has('success'))
                        <div class="alert {{(session()->get('error')) ? 'alert-danger' : 'alert-success'}}">
                          {{ session()->get('success') }}
                        </div>
                      @endif
                    </div>

	                <table id="listHolidays" class="table table-bordered table-striped text-center">
	                  	<thead class="table-heading-style">
	                     <tr>
	                        <th>Sr.</th>
	                        <th>JRF No</th>
	                        <th>Project Type</th>
	                        <th>Department</th>
	                        <th>Designation</th>
	                        <th>No of position</th>
	                        <th>Role</th>
	                        <th>Assigned date</th>
	                        <th>Closure Timeline</th>
	                        <th>Action</th>
	                        <!--<th>Status</th>
	                         <th>Status</th> -->
	                     </tr>
	                  	</thead>

	                  	<tbody>
	                   @foreach($data as $dat)

                     {{ $rr =  date('Y-m-d', strtotime('-3 days', strtotime($dat->jrf_closure_timeline)))}}

	                    <tr>
	                      <td>{{$loop->iteration}}</td>
	                      <td><a  href='{{url("jrf/view-jrf/$dat->jrf_id")}}'>{{$dat->jrf_no}}</a></td>
	                      <td>{{$dat->proj_name}}</td>
	                      <td>{{$dat->department}}</td>
	                      <td>{{$dat->designation}}</td>
	                      <td>{{$dat->npos}}</td>
	                      <td>{{$dat->role}}</td>         
	                      <td>{{@$dat->recruitment_assigned_date}}</td>
	                      <td>{{@$dat->jrf_closure_timeline}}</td>

	                      <td>
                          @if($dat->is_assigned == '1' && $dat->user_id)
                          <span class="label label-danger">Unassigned By HOD</span>
                          @else

	                        @if($dat->closure_type == 'closed' )
                            
                            <span class="label label-danger">JRF CLOSED</span>    
	                          <a class="btn btn-primary rec_tasks" target="_blank" href='{{url("jrf/view-jrf/$dat->jrf_id")}}'>View</a>
                          
                          @elseif( $dat->closure_type == 'hold' ) 
                            
                            <span class="label label-warning">JRF ON HOLD</span>    
                            <a class="btn btn-primary rec_tasks" target="_blank" href='{{url("jrf/view-jrf/$dat->jrf_id")}}'>View</a>

	                        @elseif( $rr >= date('yy-m-d') )       
	                          &nbsp;<a href='{{url("jrf/level-one-screening/$dat->jrf_id")}}' class="btn btn-primary rec_tasks" target="_blank" >L1 Screening</a>
	                          &nbsp;<a class="btn btn-primary rec_tasks" target="_blank" href='{{url("jrf/view-jrf/$dat->jrf_id")}}'>View</a>
	                          @else

	                          @if($dat->extended_date_status  == '0' || $dat->jrf_closure_timeline >= date('yy-m-d'))
                            @if($dat->extended_date_status  == '0')
	                          <button class="btn btn-success" style="padding: 0; font-size: 12px; line-height: 1.5; border-radius: 3px;"><a href='javascript:void(0)' style="color:#fff; padding: 0; font-size: 12px; line-height: 1.5; border-radius: 3px;" class="statusEmp" data-employee="{{$dat->user_id}}" data-jrf_id="{{@$dat->jrf_id}}" data-assigned_id="{{@$dat->assigned_to_id}}"  data-jrf_creater="{{@$dat->jrf_creater}}" data-status="0"><span class="label label-success">Extend Date</span></a></button>
                            
                             @else  <span class="label label-info">Date Ext. Request Sent</span>@endif
                            @if( $dat->jrf_closure_timeline >= date('yy-m-d') ) 
                            &nbsp;<a href='{{url("jrf/level-one-screening/$dat->jrf_id")}}' class="btn btn-primary rec_tasks" target="_blank" >L1 Screening</a>
                            @endif
                            @elseif($dat->extended_date_rejected  == '2')
                              <span class="label label-danger">Rejected</span>
	                          @else
	                            <span class="label label-info">Date Ext. Request Sent</span>
                              <!--&nbsp;<a href='{{url("jrf/level-one-screening/$dat->jrf_id")}}' class="btn btn-primary rec_tasks" target="_blank" >L1 Screening</a>-->
	                          @endif 
	                        @endif
                          
                          @endif
	                      </td>
	                     <!-- <td>
	                        @if($dat->jrf_status == '0' && $dat->secondary_final_status == 'In-Progress')
	                        <span class="label label-warning">{{$dat->secondary_final_status}}</span> 
	                        @elseif($dat->jrf_status == '1' && $dat->final_status == 0 && $dat->secondary_final_status == 'Approved')
	                        <span class="label label-success">{{$dat->secondary_final_status}}</span> 
	                        @elseif($dat->jrf_status == '2' && $dat->secondary_final_status = 'Rejected')
	                        <span class="label label-danger" id="status_check">{{$dat->secondary_final_status}}</span> 
	                        @elseif($dat->jrf_status == '3' && $dat->final_status == 1 && $dat->secondary_final_status = 'Closed')
	                        <span class="label label-info"> 
	                        {{$dat->secondary_final_status}}</span> 
	                        @endif
	                      </td> -->           
	                    </tr>
	                  	@endforeach
	                  	</tbody>
	                    <tfoot class="table-heading-style">
	                       <tr>
	                          <th>Sr.</th>
	                          <th>JRF No</th>
	                          <th>Project Type</th>
	                          <th>Department</th>
	                          <th>Designation</th>
	                          <th>No of position</th>
	                          <th>Role</th>
	                          <th>Assigned date</th>
	                          <th>Closure Timeline</th>
	                          <th>Action</th>
	                         <!-- <th>Status</th>-->
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
                  <h4 class="modal-title">Default Modal</h4>
               </div>
               <div class="modal-body">
                  <form id="statusForm" action="{{url('jrf/mgmt-requuest-date')}}" method="POST">
                     {{ csrf_field() }}
                     <div class="box-body">
                       
                        <div class="form-group">
                           <label for="description">Extended Date</label>
                           <input type="date" name="ext_dt" id="ext_dt" class="mgmt_remark form-control future_mgmt_dt" placeholder="Please Fill Date">
                        </div>

                        <div class="form-group">
                           <label for="description">Request Remark</label>
                           <textarea name="mgmt_remark" id="mgmt_remark" class="mgmt_remark form-control future_mgmt_dt" placeholder="Please Fill Remark"></textarea>
                        </div>

                        <input type="hidden" name="action" id="modalAction">
                        <input type="hidden" name="user_id" id="modalUserId">
                        <input type="hidden" name="jrf_id" id="modaljrfId">
                        <input type="hidden" name="assigned_id" id="modalassignedId">
                        <input type="hidden" name="jrf_creater" id="modalajrfcreater">


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

    $('.statusEmp').on('click',function(){
 
      var employee = $(this).data("employee");
      var jrf_id = $(this).data("jrf_id");
      var assigned_id = $(this).data("assigned_id");
      var status = $(this).data("status");
      var jrf_creater = $(this).data("jrf_creater");
      
      
      $("#modalUserId").val(employee);
      $("#modaljrfId").val(jrf_id);
      $("#modalassignedId").val(assigned_id);
      $("#modalajrfcreater").val(jrf_creater);
 
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
        "mgmt_remark" : {
          required: true
        },
        "ext_dt" : {
          required: true
        }
        
      },
      messages: {
          "mgmt_remark" : {
            required: 'Fill Remarks'
          },
           "ext_dt" : {
            required: 'Fill Date'
          }
          
        }
  });


    $(".future_mgmt_dt").datetimepicker({
      minDate : new Date(),
      format: 'MM/DD/Y hh:mm A',
    });

  </script>
@endsection