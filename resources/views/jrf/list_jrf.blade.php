@extends('admins.layouts.app')
@section('content')
<link rel="stylesheet" href="{{asset('public/admin_assets/plugins/dataTables/jquery.dataTables.min.css')}}">

<style>
table tr th { vertical-align: middle !important;}
</style>

<!-- Content Wrapper Starts here -->
<div class="content-wrapper">
  <!-- Content Header Starts here -->
  <section class="content-header">
    <h1><i class="fa fa-list"></i> JRF List</h1>
    <ol class="breadcrumb">
      <li><a href="{{ url('employees/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
    </ol>
  </section>
  <!-- Content Header Ends here -->

  <!-- Main content Starts here -->
  <section class="content">
    <!-- Row Starts -->
    <div class="row">
      <div class="col-sm-12">
        <div class="box box-primary">
          <!-- <div class="box-header"></div> -->
          <form id="filterForm">
            <div class="row select-detail-below">
              <div class="col-sm-3 attendance-column1">
                <label for="project">Project</label>
                <select class="form-control input-sm basic-detail-input-style" name="project_id" id="project">
                  <option value="" selected disabled>Select Project</option>
                  <option value="All" @if($req['project_id'] == 'All'){{"selected"}}@endif>All</option>  
                  @foreach($projects as $key => $value)
                  <option value="{{$value->id}}" @if($req['project_id'] == $value->id){{"selected"}}@endif>{{$value->name}}</option>
                  @endforeach  
                </select>
              </div>
              <div class="col-sm-2 attendance-column2">
                <label for="designation">Designations</label>
                <select class="form-control input-sm basic-detail-input-style" name="designation_id" id="designation">
                  <option value="" selected disabled>Select Designation</option>
                  <option value="">None</option>
                  @foreach($designations as $key => $value)
                  <option value="{{$value->id}}" @if($req['designation_id'] == $value->id){{"selected"}}@endif>{{$value->name}}</option>
                  @endforeach  
                </select>
              </div>
              <div class="col-sm-2 attendance-column4">
                <div class="form-group">
                  <button type="submit" class="btn btn-primary searchbtn-attendance" id="filterFormSubmit">
                    Search <i class="fa fa-search"></i>
                  </button>
                </div>
              </div>
            </div>
          </form>
          <hr>

          <div class="box-body">
            <table id="listHolidays" class="table table-bordered table-striped text-center">
              <thead class="table-heading-style">
               <tr>
                  <th>S.No.</th>
                  <th>JRF No</th>
                  <th>Project Name</th>
                  <th>Hiring Department</th>
                  <th>Raised Date</th>
                  <th>Closure Date</th>
                  <th>Job Role</th>
                  <th>Position Amendments</th>
                  <th>Status</th>
                  <th>JRF Progres Level</th>
                  <th>Actions</th>
               </tr>
              </thead>
              <tbody>

                @foreach($jrfs as $key =>$jrf)

                <tr> 
                  <td>{{$loop->iteration}}</td>
                  <td>{{@$jrf->jrf_no}}</td>
                  <td>{{@$jrf->name}}</td>
                  <td>{{@$jrf->department}}</td>
                  <td>{!! date('yy-m-d', strtotime($jrf->created_at)) !!} </td>
                  <td>{{@$jrf->jrf_closure_timeline}}</td>
                  <td>{{@$jrf->designation}}</td>
                  <td>{{@$jrf->number_of_positions}}</td>
                  <td>
                    @if($jrf->final_status == '0' && $jrf->isactive == 1 && $jrf->secondary_final_status == 'Rejected')
                    <span class="label label-danger">{{$jrf->secondary_final_status}}</span>
                    @elseif($jrf->final_status == '0' && $jrf->isactive == 1 && $jrf->secondary_final_status == 'In-Progress')
                    <span class="label label-warning">{{$jrf->secondary_final_status}}</span>  
                    @elseif($jrf->final_status == '1' && $jrf->isactive == 1)
                    <span class="label label-success">{{$jrf->secondary_final_status}}</span>
                    @elseif($jrf->isactive == 0)
                    <span class="label" style="background-color: #001f3f;">Cancelled</span>  
                    @endif
                  </td>

                  <td>
                
                    @if(!empty($jrf->jrf_approval_status[0]->supervisor_id) && $jrf->isactive == 1  && @$jrf->jrf_approval_status[0]->supervisor_id == '13')
                    <span class="label label-success">Created</span> @endif                    
                    @if(!empty($jrf->jrf_approval_status[0]->supervisor_id) && $jrf->isactive == 1 && $jrf->jrf_approval_status[0]->supervisor_id == '13' && $jrf->jrf_approval_status[0]->jrf_status == '0')
                    <span class="label label-warning">Approval Pending From Approving Authority</span>


                    @elseif(!empty($jrf->jrf_approval_status[0]->jrf_status) && $jrf->jrf_approval_status[0]->jrf_status == '1' && $jrf->isactive == 1 && $jrf->jrf_approval_status[0]->supervisor_id == '13')
                    <span class="label label-success">Approved From Approving Authority</span>
                    @elseif(!empty($jrf->jrf_approval_status[0]->jrf_status) && $jrf->jrf_approval_status[0]->jrf_status == '3' && $jrf->isactive == 1 && $jrf->jrf_approval_status[0]->supervisor_id == '13')
                    <span class="label label-primary">JRF Send Back By Approving Authority</span>
                    @else(!empty($jrf->jrf_approval_status[0]->jrf_status) && $jrf->jrf_approval_status[0]->jrf_status == '2' && $jrf->isactive == 1 && $jrf->jrf_approval_status[0]->supervisor_id == '13')
                    <span class="label label-danger">JRF Rejected By Approving Authority</span>
                    @endif

                    @if(!empty($jrf->jrf_approval_status[0]->assigned_by) && $jrf->jrf_approval_status[0]->assigned_by == '33')
                      <span class="label label-success">JRF Assigned To Recruiter Head</span>
                      <span class="label label-success">Assigned To Recruiter</span>
                      @else
                      <span class="label label-warning">JRF Assigned To Recruiter Head</span>
                    @endif
                  </td>

                  <td>
                    @if($jrf->closure_type =='open')
                    @if($jrf->isactive != 0)
                    @if($jrf->job_posting_other_website == "Yes")
                    <a class="btn btn-primary btn-xs" target="_blank" href='{{url("jrf/ad-requisition-form/$jrf->id")}}'>ARF</a>
                    @endif
                    &nbsp;<a class="btn btn-info btn-xs" target="_blank" href='{{url("jrf/edit-jrf/$jrf->id")}}'>
                      <i class="fa fa-edit"></i>
                    </a>
                    @endif
                    &nbsp;<a class="btn bg-purple btn-xs" target="_blank" href='{{url("jrf/view-jrf/$jrf->id")}}'>
                      <i class="fa fa-eye"></i>
                    </a>
                    @else
                    <a class="btn bg-purple btn-xs" target="_blank" href='{{url("jrf/view-jrf/$jrf->id")}}'>
                      <i class="fa fa-eye"></i>
                    </a>
                    @endif

                    @if($jrf->can_cancel_jrf && $jrf->isactive == 1)
                    <a href='{{url("jrf/cancel-jrf/$jrf->id")}}'><span class="label label-danger bg-maroon cancelAppliedLeave" Onclick="return confirm('Are you sure you want to Cancel this JRF request?')">Cancel</span></a>
                    @endif

                  </td>
              
                </tr>
                @endforeach
              </tbody>
              <tfoot class="table-heading-style">
                <tr>
                  <th>S.No.</th>
                  <th>JRF No</th>
                  <th>Project Name</th>
                  <th>Hiring Department</th>
                  <th>Raised Date</th>
                  <th>Closure Date</th>
                  <th>Job Role</th>
                  <th>Position Amendments</th>
                  <th>Status</th>
                  <th>JRF Progres Level</th>
                  <th>Actions</th>
                </tr>
              </tfoot>
            </table>
          </div><!-- /.box-body -->
        </div><!-- /.box -->
        
      </div>
    </div>
    <!-- Row Ends -->
  </section>
  <!-- Main content Ends here -->
</div>
<!-- Content Wrapper Ends here -->

  <!-- Modal -->
      
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

                      <div class="form-group">
                        <label for="statusName" class="docType">Selected Status</label>
                        <input type="text" class="form-control" id="statusName" name="statusName" value="" readonly>
                      </div>



                      <input type="text" name="jrf_id" id="jrf_id">
                      <input type="text" name="userId" id="userId">
                      <input type="text" name="final_status" id="final_status">
                      <input type="text" name="u_id" id="u_id">
                      <div class="form-group">
                        <label for="remark">Remark</label>
                       
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

  <!-- /.content-wrapper -->
  <script src="{{asset('public/admin_assets/plugins/dataTables/jquery.dataTables.min.js')}}"></script>
  <script type="text/javascript">
      $(document).ready(function() {
         $('#listHolidays').DataTable({
           scrollX: true,
           responsive: true
         });
      });
  </script>

      <script type="text/javascript">
        $(document).ready(function() {
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

        });
    </script>


@endsection