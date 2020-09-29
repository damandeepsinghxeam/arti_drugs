@extends('admins.layouts.app') @section('content')

<link rel="stylesheet" href="{{asset('public/admin_assets/plugins/dataTables/jquery.dataTables.min.css')}}">

<style>
table tr th, table tr td { vertical-align: middle !important; }
.table-wrapper {overflow-x: auto}
</style>

<div class="content-wrapper">
  <section class="content-header">
      <h1><i class="fa fa-list"></i> JRF Approval work List</h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('employees/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
      </ol>
   </section>

   <section class="content">
      <div class="row">
      	<div class="col-sm-12">
      		<div class="box box-primary">
      			<div class="box-body">
					@include('admins.validation_errors')

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

	                <div class="dropdown m-b-sm">
						<button class="btn btn-warning dropdown-toggle" type="button" data-toggle="dropdown">
							{{@$selected_status}}
							<span class="caret"></span>
						</button>
						<ul class="dropdown-menu">
							<li><a href='{{url("jrf/approve-jrf/pending")}}'>Pending</a></li>
							<li><a href='{{url("jrf/approve-jrf/assigned")}}'>Approved</a></li>
							<li><a href='{{url("jrf/approve-jrf/closed")}}'>Send Back</a></li>
							<li><a href='{{url("jrf/approve-jrf/rejected")}}'>Rejected</a></li>
						</ul>
					</div>
					@php $auth_id = Auth::id(); @endphp

					
					<div class="table-wrapper">
						<table id="listLeaveApproval" class="table table-bordered table-striped table-reposnive text-center" style="height:150px;">
	                  		<thead class="table-heading-style">
	                    		<tr>
									<th>S.No.</th>
									<th>JRF No</th>
									<th>JRF Raised Date</th>
									<th>JRF Closure Timeline</th>
									<th>Project</th>
									<!-- <th>JRF Created By</th>-->
									<th>Job Role</th>
									<th>Request From Department</th>
									<th>Job Designation</th>
									<th>No. of Position</th>
									<!--<th>Salary Range</th>-->
									<th>JRF Progress</th>
									<!--  <th>JRF Status</th>-->
									<th>View Details</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
		                  		@if(!@$data->isEmpty())
		                    	@foreach($data as $key =>$value)
		                    	<tr>
									<td>{{@$loop->iteration}}</td>
									<td>{{@$value->jrf_no}}</td>
                  					<td>{!! date('yy-m-d', strtotime($value->created_at)) !!} </td>
									<td>{{@$value->jrf_closure_timeline}}</td>
									<td>{{@$value->prj_name}}</td>
									<!--<td>{{@$value->jrf_creater_name}}</td>-->
									<td><a href='{{ url("jrf/view-jrf/$value->jrf_id")}}' class="additionalLeaveDetails" title="more details">{{@$value->role}}</a></td>
									<td>{{@$value->department_name}}</td>
									<td>{{@$value->designation}}</td>
									<td>{{@$value->number_of_positions}}</td>
									<!-- <td>{{@$value->salary_range}}</td>-->

									<td class="progress-td">
										@foreach($value->priority_wise_status as $key2 => $value2)
										<div class="progress-manager">
											<hr class="progress-line">
											<span class="@if($value2->jrf_status == '0'){{'none-dot'}}@elseif($value2->jrf_status == '1'){{'approved-dot'}}@elseif($value2->jrf_status == '2'){{'rejected-dot'}}@endif"></span>
											<h6 class="progress-line-type">@if($value2->priority == '3'){{'Manager'}}@elseif($value2->priority == '2'){{'RM'}}@elseif($value2->priority == '4'){{'MD'}}@endif</h6>
										</div>
										@endforeach
									</td>

									<!-- <td>
									@if($value->jrf_status == '0' && $value->secondary_final_status == 'In-Progress')
									<span class="label label-success">{{$value->secondary_final_status}}</span> 
									@elseif($value->jrf_status == '1' && $value->final_status == 0 && $value->secondary_final_status == 'assigned')
									<span class="label label-warning">{{$value->secondary_final_status}}</span> 
									@elseif($value->jrf_status == '2' && $value->secondary_final_status = 'Rejected')
									<span class="label label-danger" id="status_check">                               {{$value->secondary_final_status}}</span> 
									@elseif($value->jrf_status == '3' && $value->final_status == 1 && $value->secondary_final_status = 'closed')
									<span class="label label-info"> 
									{{$value->secondary_final_status}}</span> 
									@endif
									</td> -->

		                      		<td style="width: 100px">
				                        @if($value->jrf_approval_status == '0')
				                        
				                          @if($value->job_posting_other_website == "Yes")
				                           <a class="btn btn-primary btn-xs" target="_blank" href='{{url("jrf/ad-requisition-form/$value->jrf_id")}}'>ARF</a>
				                          @endif

				                        @endif

				                        @if($value->jrf_approval_status == 0)
				                          <a class="btn bg-purple btn-xs" target="_blank" href='{{ url("jrf/edit-jrf/$value->jrf_id")}}'>
				                          	<i class="fa fa-edit"></i>
				                          </a>&nbsp;
				                        @endif
				                       <a class="btn bg-info btn-xs" target="_blank" href='{{ url("jrf/view-jrf/$value->jrf_id")}}'>
				                        	<i class="fa fa-eye"></i>
				                        </a>&nbsp;
				                        @if($value->jrf_status == '1')
				                        	<a class="btn bg-purple btn-xs" target="_blank" href='{{ url("jrf/edit-jrf/$value->jrf_id")}}'>
				                          	Reassigned Recruiter<i class="fas fa-exchange-alt"></i>
				                            </a>
				                        @endif
		                      		</td>
		                      		<td>
				                        <div class="dropdown">
					                        @if($value->final_status == '0' && $value->jrf_status == '0')
					                        <button class="btn btn-warning dropdown-toggle" type="button" data-toggle="dropdown">{{"None"}} 

					                        @elseif($value->final_status == '0' &&  $value->jrf_status == '3')</button>
					                        <button class="btn btn-success dropdown-toggle" type="button" data-toggle="dropdown">
					                        {{"Send Back"}} 

					                        @elseif($value->final_status == '0' &&  $value->jrf_status == '1')</button>
					                        <button class="btn btn-success dropdown-toggle" type="button" data-toggle="dropdown">
					                        {{"Approved"}} 

					                        @elseif($value->final_status == '0' && $value->jrf_status == '2')</button>
					                        <button class="btn btn-danger dropdown-toggle" type="button" data-toggle="dropdown">
					                        {{"Rejected"}} @endif
					                        <span class="caret"></span></button>

				                        	@if($value->final_status == '0' && $value->jrf_status == '0')
		                        
					                        <ul class="dropdown-menu">
					                          @if($value->supervisor_id == '35'|| $value->supervisor_id == '22' || $value->supervisor_id == '33' || $value->supervisor_id == '106'|| $value->supervisor_id == '24' || $value->supervisor_id == '14' || $value->supervisor_id == '25' ||
					                          $value->supervisor_id == '38' || $value->supervisor_id == '59' || $value->supervisor_id == '60' || $value->supervisor_id == '65' || $value->supervisor_id == '166' )
					                          <li><a href='{{url("jrf/edit-jrf/$value->jrf_id")}}' class="">Approve</a></li> 
					                          @else
					                          <li id="accountFormSubmitA"><a href='javascript:void(0)' class="approvalStatus" data-user_id="{{@$value->supervisor_id}}" data-jrf_id="{{@$value->jrf_id}}" data-statusname="Approved" data-final_status="1" data-u_id="{{@$value->user_id}}">Approve</a></li>
					                          @endif

					                          @if($value->supervisor_id == '13')
					                          <li id="accountFormSubmitAB"><a href='javascript:void(0)' class="approvalStatus" data-user_id="{{@$value->supervisor_id}}" data-jrf_id="{{@$value->jrf_id}}" data-statusname="Rejected" data-final_status="2" data-u_id="{{@$value->user_id}}">Reject</a></li>

					                          <li id="accountFormSubmitAB"><a href='javascript:void(0)' class="approvalStatus" data-user_id="{{@$value->supervisor_id}}" data-u_id="{{@$value->user_id}}" data-jrf_id="{{@$value->jrf_id}}" data-statusname="SendBack" data-final_status="3" data-u_id="{{@$value->user_id}}">Send Back</a></li>
					                          @endif

					                        </ul>
					                        @endif
			                        	</div>
		                      		</td>
		                  		</tr>

		                		@endforeach  

		                		@else
								<tr>
									<td colspan="12">No data available</td>
								</tr>
		                		@endif
	              			</tbody>
							<tfoot class="table-heading-style">
								<tr>
									<th>S.No.</th>
									<th>JRF No</th>
									<th>JRF Raised Date</th>
									<th>JRF Closure Timeline</th>
									<th>Project</th>
									<!-- <th>JRF Created By</th>-->
									<th>Job Role</th>
									<th>Request From Department</th>
									<th>Job Designation</th>
									<th>No. of Position</th>
									<!--<th>Salary Range</th>-->
									<th>JRF Progress</th>
									<!--  <th>JRF Status</th>-->
									<th>View Details</th>
									<th>Action</th>
								</tr>
							</tfoot>
						</table>
					</div>
      			</div>
      		</div>
      	</div>
      </div>
   </section>
</div>

 <!-- for Rejection -->
 <div class="modal fade" id="jrfsStatusModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">JRF Status Form</h4>
            </div>
           	<div class="modal-body">
				<form id="jrfStatusForm" action="{{url('jrf/save-jrf-approval') }}" method="POST" enctype="multipart/form-data">
				{{ csrf_field() }}
					<div class="box-body">
						<div class="form-group">
							<label for="statusName" class="docType">Selected Status</label>
							<input type="text" class="form-control" id="statusName" name="statusName" value="" readonly>
						</div>

						<div class="form-group" id="rec_head">
							<label for="statusName" class="docType">Recruitment Head</label>
							<select class="form-control select2 input-sm basic-detail-input-style" name="rec_head" style="width: 100%;" id="rec_head" data-placeholder="Select Recruitment Head">
								<option value="">Please Select</option> 
								@if(!$reporting_manager->isEmpty())
								@foreach($reporting_manager as $rep_mang) 
								<option value="{{$rep_mang->user_id}}">{{$rep_mang->fullname}}</option>
								@endforeach
								@endif  
							</select>
						</div>

						<div class="row" id="int_dep"> 
	                        <div class="form-group">
	                           	<div class="col-md-6">
	                              <label for="statusName" class="docType">Appointment Department</label>
	                              <select class="form-control select2 input-sm basic-detail-input-style" name="interviewer_department" style="width: 100%;" id="interviewer_department" data-placeholder="Select Recruitment Head">
	                                 <option value="">Please Select</option> 
	                                 @if(!$department->isEmpty())
	                                 @foreach($department as $department) 
	                                 <option value="{{$department->id}}">{{$department->name}}</option>
	                                 @endforeach
	                                 @endif  
	                              </select>
	                           	</div>
	                        
	                        	<div class="col-md-6">
		                           <label for="statusName" class="docType">Appointment Head</label>
		                           <select class="form-control basic-detail-input-style regis-input-field" name="interviewer_employee" id="interviewer_employee"></select>

	                        	</div>
	                     	</div>
                     	</div> 

						<input type="hidden" name="jrf_id" id="jrf_id">
						<input type="hidden" name="userId" id="userId">
						<input type="hidden" name="final_status" id="final_status">
						<input type="hidden" name="u_id" id="u_id">
						<div class="form-group">
							<label for="remark">Remark</label>
							<textarea class="form-control" rows="5" name="remark" id="remark"></textarea>
						</div>
					</div>
					<!-- /.box-body -->
					<br>
					<div class="box-footer">
						<button type="submit" class="btn btn-primary" id="jrfStatusFormSubmit">Submit</button>
					</div>
				</form>
            </div>
        </div>
    </div>
</div>
<!-- end of rejection -->

<!-- /.content-wrapper -->
<script src="{{asset('public/admin_assets/plugins/dataTables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('public/admin_assets/plugins/validations/jquery.validate.js')}}"></script>
<script src="{{asset('public/admin_assets/plugins/validations/additional-methods.js')}}"></script>

<script type="text/javascript">
    $(document).ready(function() {
    	$("#listLeaveApproval").DataTable({
    		scroll: true,
    		responsive: true
    	});

       	$(".approvalStatus").on('click', function() {
           var jrf_id = $(this).data("jrf_id");
           var userId = $(this).data("user_id");
           var final_status = $(this).data("final_status");
           var statusname = $(this).data("statusname");
           var u_id = $(this).data("u_id");

           $("#jrf_id").val(jrf_id);
           $("#userId").val(userId);
           $("#final_status").val(final_status);
           $("#statusName").val(statusname);
           $("#u_id").val(u_id);
           $('#jrfsStatusModal').modal('show');
        });

        $("#jrfStatusForm").validate({
           rules: {
               "remark": {
                   required: true,
               },
               "rec_head":{
                  required: true,
               },
               "interviewer_department":{
               	  required: true,
               }
           },
           messages: {
               "remark": {
                   required: 'Please enter a remark.',
               },
               "rec_head": {
                   required: 'Please Select Recruitment Head',
               },
               "interviewer_department": {
                   required: 'Please Select Appointment Department',
               }
           }
        });
    });
</script>

  <script type="text/javascript">
      // for interviewer
    $('#interviewer_department').on('change', function(){
      var inter_department = $(this).val();
      var displayString = "";
      $("#interviewer_employee").empty();
      var inter_departments = [];
      inter_departments.push(inter_department);
      $.ajax({
        type: "POST",
        url: "{{url('employees/departments-wise-employees')}}",
        data: {department_ids: inter_departments},
        success: function(result){
          if(result.length == 0 || (result.length == 1 && result[0].user_id == userId)){
            displayString += '<option value="" disabled>None</option>';
          }else{
            result.forEach(function(employee){
              if(employee.user_id != 1){
                displayString += '<option value="'+employee.user_id+'">'+employee.fullname+'</option>';
              }
            });
          }
          $('#interviewer_employee').append(displayString);
        }
      });
    }).change();
    // end
</script>

<script type="text/javascript">

   $(function() {
      $('#accountFormSubmitA').on('click', function() {
         $("#rec_head").show();
         $("#int_dep").show();
      });

       $('#accountFormSubmitAB').on('click', function() {
         $("#rec_head").hide();
         $("#int_dep").hide();
      });
   });

</script>	

@endsection