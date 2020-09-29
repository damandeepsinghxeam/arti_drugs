@extends('admins.layouts.app')
@section('content')
<link rel="stylesheet" href="{{asset('public/admin_assets/plugins/dataTables/jquery.dataTables.min.css')}}">
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
    <h1>Third Level Approval</h1>
    <ol class="breadcrumb">
      <li><a href="{{ url('employees/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
    </ol>
   </section>

   <!-- Main content -->
   <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
       <div class="box">
          <div class="box-header"></div>
            <div class="box-body">
             <table id="listHolidays" class="table table-bordered table-striped">
                <thead class="table-heading-style">
                 <tr>
                    <th>S.No.</th>
                    <th>jrf No</th>
                    <th>Project Type</th>  
                    <th>Candidate name</th>
                    <th>Interview Conducted By</th>
                    <th>Candidate Status</th>
                    <th>Created Date</th>
                    <th>Status</th>
                 </tr>
                </thead>

                @foreach($datas as $data)
                  <tbody>
                    <tr> 
                      <td>{{@$loop->iteration}}</td>
                      <td>{{@$data->jrf_no}}</td>

                      <td>{{@$data->prj_name}}</td>
                       <td>{{@$data->name}}</td>
                      <td>{{@$data->fullname}}</td>
                      <td>{{@$data->final_result}}</td>
                      <td>{{@$data->created_at}}</td>
                      <td>
                           <div class="dropdown">
                        @if($data->jrf_id == '1')
                        <button class="btn btn-warning dropdown-toggle" type="button" data-toggle="dropdown">{{"None"}} 
                        @endif
                        <span class="caret"></span></button>

                        @if($data->jrf_id == '1' )
                        
                        <ul class="dropdown-menu">
                          <li><a href='javascript:void(0)' class="approval_fnl_Status" data-user_id="{{@$data->user_id}}" data-jrf_id="{{@$data->jrf_id}}" data-jrf_level_one_screening_id="{{@$data->jrf_level_one_screening_id}}" data-statusname="Approved" data-final_status="1">Approve</a></li>
                          
                          <li><a href='javascript:void(0)' class="approval_fnl_Status" data-user_id="{{@$value->supervisor_id}}" data-jrf_id="{{@$value->jrf_id}}" data-statusname="Rejected" data-final_status="2">Reject</a></li>
                        </ul>
                        @endif
                        </div>
                      </td>


                    </tr>
                  </tbody>
                @endforeach

                <tfoot class="table-heading-style">
                   <tr>
                      <th>S.No.</th>
                      <th>jrf No</th>
                      <th>Project Type</th>  
                      <th>Candidate name</th>
                      <th>Interview Conducted By</th>
                      <th>Candidate Status</th>
                      <th>Created Date</th>
                   </tr>
                </tfoot>
               </table>
            </div><!-- /.box-body -->
          </div><!-- /.box -->
        </div><!-- /.row -->
    <!-- Main row -->
   </section>
   <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
 

 <!-- for Rejection -->
     <div class="modal fade" id="jrfsStatusModal">
        <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title">Candidate Approval Form</h4>
               </div>
               <div class="modal-body">
                  <form id="jrfStatusForm" action="{{url('jrf/save-jrf-approval') }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="box-body">
                      <div class="form-group">
                        <label for="statusName" class="docType">Selected Status</label>
                        <input type="text" class="form-control" id="statusName" name="statusName" value="" readonly>
                      </div>
                      <input type="text" name="jrf_id" id="jrf_id">
                      <input type="text" name="userId" id="userId">
                      <input type="text" name="final_status" id="final_status">
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
           $(".approval_fnl_Status").on('click', function() {
               var jrf_id = $(this).data("jrf_id");
               var userId = $(this).data("user_id");
               var final_status = $(this).data("final_status");
               var statusname = $(this).data("statusname");
               var jrf_level_one_screening_id = $(this).data(jrf_level_one_screening_id);
               $("#jrf_id").val(jrf_id);
               $("#userId").val(userId);
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