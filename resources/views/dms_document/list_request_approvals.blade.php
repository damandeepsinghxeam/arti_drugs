@extends('admins.layouts.app') @section('content')

<link rel="stylesheet" href="{{asset('public/admin_assets/plugins/dataTables/jquery.dataTables.min.css')}}">

<style>
table tr th, table tr td { vertical-align: middle !important; }
.table-wrapper {overflow-x: auto}
</style>

<div class="content-wrapper">
  <section class="content-header">
      <h1><i class="fa fa-list"></i> Document Requests List</h1>
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

	                <div class="dropdown m-b-sm">
						<button class="btn btn-warning dropdown-toggle" type="button" data-toggle="dropdown">
							{{@$selected_status}}
							<span class="caret"></span>
						</button>
						<ul class="dropdown-menu">
							<li><a href='{{url("document-requests/pending")}}'>Pending</a></li>
							<li><a href='{{url("document-requests/assigned")}}'>Approved</a></li>
							<li><a href='{{url("document-requests/rejected")}}'>Rejected</a></li>
						</ul>
					</div>
					@php $auth_id = Auth::id(); @endphp

					<div class="table-wrapper">
						<table id="listLeaveApproval" class="table table-bordered table-striped table-reposnive text-center" style="height:150px;">
	                  		<thead class="table-heading-style">
	                    		<tr>
	                    			<th>S.no</th>
	                    			<th>Request Sent By</th>
	                    			<th>Document Shared  with</th>
	                    			<!--<th>Document Raised By</th> -->
									<th>Document Name</th>
									<th>Category</th>
									<th>Request Remarks</th>
									<th>Document View</th>
									<th>Document Download</th>
									<!--<th>Download</th>-->
									<th>Action</th>
								</tr>
							</thead>

							<tbody>
		                  		@if(!@$data['basic']->isEmpty())
		                    	@foreach($data['basic'] as $key =>$value)

		                    		@php 
										if($value->download_doc == 1){
											$doc_down = '<span class="label label-success">'."YES".'<span>';
										}else{
											$doc_down = '<span class="label label-danger">'."NO".'<span>';
										}

										if($value->view_doc == 1){
											$doc_view = '<span class="label label-success">'."YES".'<span>';
										}else{
											$doc_view = '<span class="label label-danger">'."NO".'<span>';
										}

									@endphp

		                    	<tr>
									<td>{{@$loop->iteration}}</td>
									<td>{{@$value->req_emp_name}}</td>
									<!--<td>{{@$value->emp_name}}</td>-->
									<td>
										@foreach($data['doc_employee'] as $valueA)
			                    			<span>{{@$valueA->fullname}}</span>
			                    		@endforeach
									</td>
									<td>{{@$value->name}}</td>
									<td>{{@$value->dms_category}}</td>
									<td>{{@$value->remarks}}</td>
									<td>{!! $doc_view !!}</td>
									<td>{!! $doc_down !!}</td>
									<!--<td>
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
                                    </td>-->
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
					                        
					                          <li id="accountFormSubmitA"><a href='javascript:void(0)' class="approvalStatus" data-user_id="{{@$value->supervisor_id}}" data-dms_document_id="{{@$value->dms_document_id}}" data-statusname="Approved" data-final_status="1" data-u_id="{{@$value->user_id}}" data-priority="{{@$value->priority}}" data-view_doc="{{@$value->view_doc}}" data-downl_doc="{{@$value->download_doc}}" >Approve</a></li>
					                         
					                          <li id="accountFormSubmitAB"><a href='javascript:void(0)' class="approvalStatus" data-user_id="{{@$value->supervisor_id}}" data-dms_document_id="{{@$value->dms_document_id}}" data-statusname="Rejected" data-final_status="2" data-u_id="{{@$value->user_id}}" data-priority="{{@$value->priority}}">Reject</a></li>

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
	                    			<th>Request Sent By</th>
	                    			<th>Document Shared  with</th>
	                    			<!--<th>Document Raised By</th>-->
									<th>Document Name</th>
									<th>Category</th>
									<th>Request Remarks</th>
									<th>Document View</th>
									<th>Document Download</th>
									<!--<th>Download</th>-->
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
				<h4 class="modal-title">REQUEST FORM</h4>
            </div>
           	<div class="modal-body">
				<form id="jrfStatusForm" action="{{url('save-dms-request-approval') }}" method="POST" enctype="multipart/form-data">
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
						<input type="hidden" name="priority" id="priority">
						<input type="hidden" name="view_doc" id="view_doc">
						<input type="hidden" name="downl_doc" id="downl_doc">
						
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
           var priority = $(this).data("priority");
           var view_doc = $(this).data("view_doc");
           var downl_doc = $(this).data("downl_doc");


           $("#dms_document_id").val(dms_document_id);
           $("#userId").val(userId);
           $("#final_status").val(final_status);
           $("#statusName").val(statusname);
           $("#u_id").val(u_id);
           $("#priority").val(priority);
           $("#view_doc").val(view_doc);
           $("#downl_doc").val(downl_doc);

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