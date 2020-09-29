@extends('admins.layouts.app') @section('content')

<div class="content-wrapper">
  <section class="content-header">
      <h1>ARF Approval List</h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('employees/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
      </ol>
   </section>

   <section class="content">
      <div class="row">
        <div class="box">
           @include('admins.validation_errors')
            <div class="box-body">
               <div class="dropdown">
                  <button class="btn btn-warning dropdown-toggle" type="button" data-toggle="dropdown">
                  {{@$selected_status}}
                  <span class="caret"></span></button>
                  <ul class="dropdown-menu">
                     <li><a href='{{url("jrf/approve-arf/pending")}}'>Pending</a></li>
                     <li><a href='{{url("jrf/approve-arf/approved")}}'>Approved</a></li>
                     <li><a href='{{url("jrf/approve-arf/rejected")}}'>Rejected</a></li>
                  </ul>
               </div>

               <table id="listLeaveApproval" class="table table-bordered table-striped" style="height:150px;">
                    <thead class="table-heading-style">
                       <tr>
                          <th>S.No.</th>
                          <th>jrf.No</th>
                          <th>Project Type</th>
                          <th>Jrf Created By</th>
                          <th>Job Role</th>
                          <th>Job Designation</th>
                          <th>No. of Position</th>
                          <th>Salary Range</th>
                          <th>Experience</th>
                          <th>JRF Status</th>
                          <th>Status</th>
                          <th>Action</th>
                       </tr>
                    </thead>
                  <tbody>
                  @if(!@$data->isEmpty())
                    @foreach($data as $key =>$value)
                    <tr>
                      <td>{{@$loop->iteration}}</td>
                      <td>{{@$value->jrf_no}}</td>
                      <td>{{@$value->prj_name}}</td>
                      <td>{{@$value->jrf_creater_name}}</td>
                      <td><a href='{{ url("jrf/view-jrf/$value->jrf_id")}}' class="additionalLeaveDetails" title="more details">{{@$value->role}}</a></td>
                      <td>{{@$value->designation}}</td>
                      <td>{{@$value->number_of_positions}}</td>
                      <td>{{@$value->salary_range}}</td>
                      <td>{{@$value->experience}}</td>
                      <td>
                        @if($value->arf_status == '0' && $value->secondary_final_status == 'Pending')
                        <span class="label label-warning">{{$value->secondary_final_status}}</span> 
                        @elseif($value->arf_status == '1' && $value->final_status == 0 && $value->secondary_final_status == 'Approved')
                        <span class="label label-success">{{$value->secondary_final_status}}</span> 
                        @elseif($value->arf_status == '2' && $value->secondary_final_status = 'Rejected')
                        <span class="label label-danger" id="status_check">                               {{$value->secondary_final_status}}</span> 
                        @elseif($value->arf_status == '1' && $value->final_status == 1 && $value->secondary_final_status = 'Closed')
                        <span class="label label-info"> 
                        {{$value->secondary_final_status}}</span> 
                        @endif
                      </td>
                      <td>
                        @if($value->job_posting_other_website == "Yes")
                        <a class="btn btn-primary" target="_blank" href='{{url("jrf/ad-requisition-form/$value->jrf_id")}}'>ARF</a>
                        @endif
                        <a class="btn btn-primary" target="_blank" href='{{ url("jrf/view-jrf/$value->jrf_id")}}'>View</a>
                      </td>
                      <td>
                        <div class="dropdown">
                        @if($value->final_status == '0' && $value->arf_status == '0')
                        <button class="btn btn-warning dropdown-toggle" type="button" data-toggle="dropdown">{{"None"}} 

                        @elseif($value->final_status == '1')</button>
                        <button class="btn btn-success dropdown-toggle" type="button" data-toggle="dropdown">
                        {{"Closed"}} 

                        @elseif($value->final_status == '0' &&  $value->arf_status == '1')</button>
                        <button class="btn btn-success dropdown-toggle" type="button" data-toggle="dropdown">
                        {{"Assigned"}} 

                        @elseif($value->final_status == '0' && $value->arf_status == '2')</button>
                        <button class="btn btn-danger dropdown-toggle" type="button" data-toggle="dropdown">
                        {{"Rejected"}} @endif
                        <span class="caret"></span></button>

                        @if($value->final_status == '0' && $value->arf_status == '0')
                        <ul class="dropdown-menu">
                          <li><a href='javascript:void(0)' class="arfApprovalStatus" data-user_id="{{@$value->supervisor_id}}" data-jrf_id="{{@$value->jrf_id}}" data-u_id="{{@$value->user_id}}" data-statusname="Approved" data-final_status="1" data-arf_id="{{@$value->arf_id}}">Approve</a></li>
                          
                          <li><a href='javascript:void(0)' class="arfApprovalStatus" data-user_id="{{@$value->supervisor_id}}" data-jrf_id="{{@$value->jrf_id}}"  data-u_id="{{@$value->user_id}}" data-statusname="Rejected" data-final_status="2" data-arf_id="{{@$value->arf_id}}">Reject</a></li> </ul>
                        @endif
                        </div>
                      </td>
                  </tr>
                @endforeach  

                @else
                  <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>No data available</td>
                    <td></td>
                    <td></td>
                    <td></td>  
                    <td></td>
                  </tr>
                @endif
              </tbody>
              <tfoot class="table-heading-style">
                 <tr>
                    <th>S.No.</th>
                    <th>jrf.No</th>
                    <th>Project Type</th>
                    <th>Jrf Created By</th>
                    <th>Job Role</th>
                    <th>Job Designation</th>
                    <th>No. of Position</th>
                    <th>Salary Range</th>
                    <th>Experience</th>
                    <th>JRF Status</th>
                    <th>Status</th>
                    <th>Action</th>
                 </tr>
              </tfoot>
           </table>
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
                  <form id="jrfStatusForm" action="{{url('jrf/save-arf-approval') }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="box-body">
                      <div class="form-group">
                        <label for="statusName" class="docType">Selected Status</label>
                        <input type="text" class="form-control" id="statusName" name="statusName" value="" readonly>
                      </div>
                      <input type="hidden" name="jrf_id" id="jrf_id">
                      <input type="hidden" name="userId" id="userId">
                      <input type="hidden" name="arf_id" id="arf_id">
                      <input type="hidden" name="final_status" id="final_status">
                      <input type="hidden" name="u_id" id="u_id">
                      <div class="form-group">
                        <label for="remark">Remark</label>
                        <textarea class="form-control" rows="5" name="remark" id="remark"></textarea>
                      </div>
                    </div>
                    <!-- /.box-body -->
                    <br><div class="box-footer">
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
    <script type="text/javascript">
        $(document).ready(function() {
           $(".arfApprovalStatus").on('click', function() {
               var jrf_id = $(this).data("jrf_id");
               var arf_id = $(this).data("arf_id");
               var userId = $(this).data("user_id");
               var u_id = $(this).data("u_id");
               var final_status = $(this).data("final_status");
               var statusname = $(this).data("statusname");
               $("#jrf_id").val(jrf_id);
               $("#userId").val(userId);
               $("#u_id").val(u_id);
               $("#arf_id").val(arf_id);
               $("#final_status").val(final_status);
               $("#statusName").val(statusname);
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
    <script src="{{asset('public/admin_assets/plugins/validations/jquery.validate.js')}}"></script>
    <script src="{{asset('public/admin_assets/plugins/validations/additional-methods.js')}}"></script>
@endsection