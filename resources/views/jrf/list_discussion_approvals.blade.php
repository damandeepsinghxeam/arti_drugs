@extends('admins.layouts.app') 

@section('content')

<link rel="stylesheet" href="{{asset('public/admin_assets/plugins/dataTables/jquery.dataTables.min.css')}}">

<div class="content-wrapper">
  <section class="content-header">
      <h1><i class="fa fa-list"></i> Discussion For JRF Extension Date</h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('employees/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
      </ol>
   </section>

   <section class="content">
      <div class="row">
        <div class="col-sm-12">
          <div class="box box-primary">
             @include('admins.validation_errors')
              <div class="box-body">
                 <div class="dropdown m-b-sm">
                    <button class="btn btn-warning dropdown-toggle" type="button" data-toggle="dropdown">
                    {{@$selected_status}}
                    <span class="caret"></span></button>
                    <ul class="dropdown-menu">
                       
                    </ul>
                 </div>
                 @php $auth_id = Auth::id(); @endphp
                 <table id="listLeaveApproval" class="table table-bordered table-striped" style="height:150px;">
                    <thead class="table-heading-style">
                      <tr>
                       <th>S.No.</th>
                      <th>JRF No</th>
                      <th>Discussion Remark</th>
                      <th>Extension Date</th>
                      <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                    @if(!@$data->isEmpty())
                      @foreach($data as $key =>$value)
                      <tr>
                        <td>{{@$loop->iteration}}</td>
                        <td><a  target="_blank" href='{{ url("jrf/view-jrf/$value->jrf_id")}}'>{{@$value->jrf_no}}</a></td>
                        <td>{{@$value->discussion_remarks}}</td>
                        <td>{{@$value->extended_date}}</td>

                       
                         <td>
                          <div class="dropdown">
                          @if($value->jrf_status == '3')
                          <button class="btn btn-warning dropdown-toggle" type="button" data-toggle="dropdown">{{"None"}} 

                          @elseif($value->jrf_status == '1')</button>
                          <button class="btn btn-success dropdown-toggle" type="button" data-toggle="dropdown">
                          {{"Approved"}} 

                          @endif
                          <span class="caret"></span></button>

                          @if($value->jrf_status == '3')
                          
                          <ul class="dropdown-menu">
                          

                            <li><a href='javascript:void(0)' class="approvalStatus" data-user_id="{{@$value->supervisor_id}}" data-u_id="{{@$value->user_id}}" data-jrf_id="{{@$value->jrf_id}}" data-statusname="Discussion" data-final_status="1">Approve Date</a></li>

                          </ul>
                          @endif
                          </div>
                        </td>

                    </tr>

                  @endforeach  

                  @else
                    <tr>
                      <td colspan="5" class="text-center">No data available</td>
                    </tr>
                  @endif
                </tbody>
                <tfoot class="table-heading-style">
                   <tr>
                      <th>S.No.</th>
                      <th>JRF No</th>
                      <th>Discussion Remark</th>
                      <th>Extension Date</th>
                      <th>Action</th>
                   </tr>
                </tfoot>
             </table>
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
                  <h4 class="modal-title">Discussion Form</h4>
               </div>
               <div class="modal-body">
                  <form id="jrfStatusForm" action="{{url('jrf/save-discussion-approval') }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="box-body">
                      <div class="form-group">
                        <label for="statusName" class="docType">Selected Status</label>
                        <input type="text" class="form-control" id="statusName" name="statusName" value="" readonly>
                      </div>
                      <div class="form-group">
                        <label for="statusName" class="docType">New JRF Closure Date ( IF Required )</label>
                        <input type="date" class="form-control" id="extended_date" name="extended_date" >
                      </div>
                      <div class="form-group">
                        <label for="remark">Remark</label>
                        <textarea class="form-control" rows="5" name="remark" id="remark"></textarea>
                      </div>
                    </div>

                    <input type="hidden" name="jrf_id" id="jrf_id">
                    <input type="hidden" name="userId" id="userId">
                    <input type="hidden" name="final_status" id="final_status">
                    <input type="hidden" name="u_id" id="u_id">

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
               var extended_date = $(this).data("extended_date");
               

               $("#jrf_id").val(jrf_id);
               $("#userId").val(userId);
               $("#final_status").val(final_status);
               $("#statusName").val(statusname);
               $("#u_id").val(u_id);
               $("#extended_date").val(extended_date);
               $('#jrfsStatusModal').modal('show');
            });

            $("#jrfStatusForm").validate({
               rules: {
                   "remark": {
                       required: true,
                   },
                   "rec_head":{
                      required: true,
                   }
               },
               messages: {
                   "remark": {
                       required: 'Please enter a remark.',
                   },
                   "rec_head": {
                       required: 'Please Select Recruitment Head',
                   }
               }
            });
        });
    </script>
    <script src="{{asset('public/admin_assets/plugins/validations/jquery.validate.js')}}"></script>
    <script src="{{asset('public/admin_assets/plugins/validations/additional-methods.js')}}"></script>
@endsection