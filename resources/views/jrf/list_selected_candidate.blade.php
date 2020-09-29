@extends('admins.layouts.app')
@section('content')
<link rel="stylesheet" href="{{asset('public/admin_assets/plugins/dataTables/jquery.dataTables.min.css')}}">

<style>
table tr th, table tr td { vertical-align: middle !important; }
</style>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1><i class="fa fa-user"></i> Appointed Candidate</h1>
    <ol class="breadcrumb">
      <li><a href="{{ url('employees/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
    </ol>
   </section> 
   <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-sm-12">
        <div class="box box-primary">
          <!-- <div class="box-header"></div> -->

          <div class="box-body">
            <div class="alert-dismissible">
              @if(session()->has('success'))
                <div class="alert {{(session()->get('error')) ? 'alert-danger' : 'alert-success'}}">
                  {{ session()->get('success') }}
                </div>
              @endif
            </div>

            <form id="filterForm">
            <div class="row">
              <div class="col-md-2 attendance-column1">
                <label for="jrf_no">Jrf No</label>
                <select class="form-control input-sm basic-detail-input-style" name="jrf_no" id="jrf_no">
                  <option value="" selected disabled>Select Jrf</option>
                  <option value="">None</option>
                  @foreach($jrfs as $key => $value)
                  <option value="{{$value->jrf_no}}" @if($req['jrf_no'] == $value->id){{"selected"}}@endif>{{$value->jrf_no}}</option>
                  @endforeach  
                </select>
              </div>
              <div class="col-md-3 attendance-column2">
                <label for="project_id">Project</label>
                <select class="form-control input-sm basic-detail-input-style" name="project_id" id="project_id">
                  <option value="" selected disabled>Select Project</option>
                  <option value="All" @if($req['project_id'] == 'All'){{"selected"}}@endif>All</option>  
                  @foreach($projects as $key => $value)
                  <option value="{{$value->id}}" @if($req['project_id'] == $value->id){{"selected"}}@endif>{{$value->name}}</option>
                  @endforeach  
                </select>
              </div>
              <div class="col-md-3 attendance-column3">
                <label for="designation_id">Designations</label>
                <select class="form-control input-sm basic-detail-input-style" name="designation_id" id="designation_id">
                  <option value="" selected disabled>Select Designation</option>
                  <option value="">None</option>
                  @foreach($designations as $key => $value)
                  <option value="{{$value->id}}" @if($req['designation_id'] == $value->id){{"selected"}}@endif>{{$value->name}}</option>
                  @endforeach  
                </select>
              </div>
              <div class="col-md-2 attendance-column4">
                <button type="submit" class="btn btn-primary searchbtn-attendance" id="filterFormSubmit">Submit</button>
              </div>
            </div>
            </form>

            <hr>

            <table id="listHolidays" class="table table-bordered table-striped text-center">
              <thead class="table-heading-style">
                <tr>
                  <th>S.No.</th>
                  <th>JRF No</th>
                  <th>Project Type</th>
                  <th>Candidate Name</th>
                  <th>Recruiter Name</th>
                  <th>Current CTC(Annually)</th>
                  <th>Current CIH(Annually)</th>
                  <th>Designation</th>
                  <th>Department</th>
                  <!--<th>Joining Date</th>
                  <th>Offer Letter</th>-->
                  <th>Joining</th>
                </tr>
              </thead>
              <tbody>
                @php $counter = 1; @endphp 
                @foreach($jrfs_approval as $key =>$jrf)
                <tr> 
                  <td>{{@$counter++}}</td>
                  <td><a  href='{{url("jrf/view-jrf/$value->jrf_id")}}'>{{@$jrf->jrf_no}}</a></td>
                  <td>{{@$jrf->proj_name}}</td>
                  <td><a href='{{url("jrf/candidate-level-one-screening-detail/$jrf->jrf_level_one_screening_id")}}' target="_blank">{{@$jrf->cand_name}}</a></td>
                  <td>{{@$jrf->fullname}}</td>
                  <td>{{@$jrf->ctc}}</td>
                  <td>{{@$jrf->cih}}</td>
                  <td>{{@$jrf->designation}}</td>
                  <td>{{@$jrf->department}}</td>
                  <!--<td>{{@$jrf->joining_date}}</td>
                  <td>
                  
                    <a class="btn btn-primary rec_tasks" target="_blank" href='{{url("jrf/view-and-print-offer-letter/$jrf->jrf_level_one_screening_id")}}'>Offer Letter</a>
                  </td>-->

                  <td>
                    @if(@$jrf->closure_type == 'open')
                    @if(@$jrf->joining_status == 1)        
                      <button class="btn btn-primary btn-xs" disabled="disabled">JOINED</button>
                    @else
                      <a href='javascript:void(0)'  class="approvalStatus" data-user_id="{{@$jrf->user_id}}" data-jrf_id="{{@$jrf->jrf_id}}" data-level_id="{{@$jrf->jrf_level_one_screening_id}}" data-statusname="Joined" data-final_status="1">Joining</a>                
                    @endif
                    @elseif(@$jrf->closure_type == 'hold')
                    <span class="label label-warning">JRF ON HOLD</span>
                     @else
                      <span class="label label-danger">JRF CLOSED</span>
                    @endif
                  </td>
                </tr>
                @endforeach
              </tbody>
              <tfoot class="table-heading-style">
                <tr>
                  <th>S.No.</th>
                  <th>JRF No</th>
                  <th>Project Type</th>
                  <th>Candidate Name</th>
                  <th>Recruiter Name</th>
                  <th>Current CTC(Annually)</th>
                  <th>Current CIH(Annually)</th>
                  <th>Designation</th>
                  <th>Department</th>
                  <!--<th>Offer Letter</th>-->
                  <th>Joining</th>
                </tr>
              </tfoot>
            </table>
          </div>


        </div>
      </div>
    </div>
  </section>
   <!-- /.content -->

  <div class="modal fade" id="jrfsStatusModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Final Joining Date</h4>
            </div>
            <div class="modal-body">
              <form id="jrfStatusForm" action="{{url('jrf/change-joining-status') }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="box-body">
                  <div class="form-group">
                    <label for="statusName" class="docType">Status</label>
                    <input type="text" class="form-control" id="statusName" name="statusName" value="" readonly>
                  </div>

                  <input type="hidden" name="user_id" id="user_id">
                  <input type="hidden" name="jrf_id" id="jrf_id">
                  <input type="hidden" name="level_id" id="level_id">
                  <input type="hidden" name="final_status" id="final_status">

                  <div class="form-group">
                    <label for="statusName" class="docType">Joined Date</label>
                    <input type="date" class="form-control" id="joining_date" name="joining_date">
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

               var user_id = $(this).data("user_id");
               var jrf_id = $(this).data("jrf_id"); 
               var level_id = $(this).data("level_id");
               var final_status = $(this).data("final_status");
               var statusname = $(this).data("statusname");
               
               $("#user_id").val(user_id);
               $("#jrf_id").val(jrf_id);
               $("#level_id").val(level_id);
               $("#final_status").val(final_status);
               $("#statusName").val(statusname);
               $('#jrfsStatusModal').modal('show');
            });

            $("#jrfStatusForm").validate({
               rules: {
                   "joining_date": {
                       required: true,
                   }
               },
               messages: {
                   "joining_date": {
                       required: 'Please Fill Joining Date.',
                   }
               }
            });
        });
    </script>
    <script src="{{asset('public/admin_assets/plugins/validations/jquery.validate.js')}}"></script>
    <script src="{{asset('public/admin_assets/plugins/validations/additional-methods.js')}}"></script>
@endsection