@extends('admins.layouts.app') @section('content')

<link rel="stylesheet" href="{{asset('public/admin_assets/plugins/dataTables/jquery.dataTables.min.css')}}">

<style>
table tr th, table tr td { vertical-align: middle !important; }
.table-wrapper {overflow-x: auto}
</style>

<div class="content-wrapper">
  <section class="content-header">
      <h1><i class="fa fa-list"></i> Document Approval work List</h1>
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

	               <!-- 
	               <div class="dropdown m-b-sm">
						<button class="btn btn-warning dropdown-toggle" type="button" data-toggle="dropdown">
							{{@$selected_status}}
							<span class="caret"></span>
						</button>
						
						<ul class="dropdown-menu">
							<li><a href='{{url("approve-dms/pending")}}'>Pending</a></li>
							<li><a href='{{url("approve-dms/assigned")}}'>Approved</a></li>
							<li><a href='{{url("approve-dms/rejected")}}'>Rejected</a></li>
						</ul>
					</div>
					-->
					@php $auth_id = Auth::id(); @endphp

					<div class="table-wrapper">
						<table id="listLeaveApproval" class="table table-bordered table-striped table-reposnive text-center" style="height:150px;">
	                  		<thead class="table-heading-style">
	                    		<tr>
	                    			<th>S.no</th>
	                    			<th>Document Raised By</th>
									<th>Document Name</th>
									<th>Privacy Status</th>
									<th>Edit</th>
									<th>Document</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
		                  		@if(!@$data['basic']->isEmpty())
		                    	@foreach($data['basic'] as $key =>$value)

		                    		@php 
		                    			if($value->privacy_status == 'public')
		                    				$status = '<span class="label label-warning">'.$value->privacy_status.'<span>';
		                    			else if($value->privacy_status == 'private')
		                    				$status = '<span class="label label-primary" >'.$value->privacy_status.'<span>';
		                    			else
		                    				$status = '<span class="label label-info">'.$value->privacy_status.'<span>';
		                    		@endphp	
		                    		
		                    	<tr>
									<td>{{@$loop->iteration}}</td>
									<td>{{@$value->emp_name}}</td>
									<td>{{@$value->name}}</td>
									<td>{!! $status !!}</td>
									<td>
										@if(@$value->jrf_status == '0' || @$value->jrf_status == '1')
											<a href="{{ route('dms.document.edit', $value->id) }}">
	                                            <button class="btn bg-purple">
	                                                <i class="fa fa-edit"></i>
	                                            </button>
	                                        </a>
	                                    @else
	                                    	<span class="label label-danger">Rejected Document Not Editable</span>    
                                        @endif
	                                </td>
                                    
									<td>
                                        @if($value->document != '')
                                            <div class="dropdown">
                                                <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown">
                                                        <i class="fa fa-download"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    @foreach(json_decode($value->document) as $document)
                                                        <a href="{{ route('dms.document.download', $document) }}"><i class="fa fa-download btn"></i>{{$document}} </a>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    </td>
		                      		<td>
				                        <div class="dropdown">

				                        	@if($value->final_status == '0' && $value->jrf_status == '0')
					                        <button class="btn btn-warning dropdown-toggle" type="button" data-toggle="dropdown">{{"None"}} 					                        @elseif($value->final_status == '0' &&  $value->jrf_status == '1')</button>
					                        <button class="btn btn-success dropdown-toggle" type="button">
					                        {{"Approved"}} 

					                        @elseif($value->final_status == '0' && $value->jrf_status == '2')</button>
					                        <button class="btn btn-danger dropdown-toggle" type="button">
					                        {{"Rejected"}} @endif
					                        <span class="caret"></span></button>

					                        <ul class="dropdown-menu">
					                        
					                          <li id="accountFormSubmitA"><a href='javascript:void(0)' class="approvalStatus" data-user_id="{{@$value->supervisor_id}}" data-dms_document_id="{{@$value->dms_document_id}}" data-statusname="Approved" data-final_status="1" data-u_id="{{@$value->user_id}}">Approve</a></li>
					                         
					                          <li id="accountFormSubmitAB"><a href='javascript:void(0)' class="approvalStatus" data-user_id="{{@$value->supervisor_id}}" data-dms_document_id="{{@$value->dms_document_id}}" data-statusname="Rejected" data-final_status="2" data-u_id="{{@$value->user_id}}">Reject</a></li>

					                        </ul>
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
									<th>S.no</th>
									<th>Document Raised By</th>
									<th>Document Name</th>
									<th>Privacy Status</th>
									<th>Edit</th>
									<th>Document</th>
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
				<h4 class="modal-title">Document Approval Form</h4>
            </div>
           	<div class="modal-body">
				<form id="jrfStatusForm" action="{{url('save-approve-dms-approval') }}" method="POST" enctype="multipart/form-data">
				{{ csrf_field() }}
					<div class="box-body">
						<div class="form-group">
							<label for="statusName" class="docType">Selected Status</label>
							<input type="text" class="form-control" id="statusName" name="statusName" value="" readonly>
						</div>

						<input type="hidden" name="dms_document_id" id="dms_document_id">
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
           var dms_document_id = $(this).data("dms_document_id");
           var userId = $(this).data("user_id");
           var final_status = $(this).data("final_status");
           var statusname = $(this).data("statusname");
           var u_id = $(this).data("u_id");

           $("#dms_document_id").val(dms_document_id);
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
               }
            },
            messages: {
               "remark": {
                   required: 'Please enter a remark.',
               }
           	}
        });
    });
</script>


@endsection