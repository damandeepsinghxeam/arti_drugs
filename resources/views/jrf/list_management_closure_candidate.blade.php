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
      <h1>JRF CLOSURE</h1>
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

                  <form id="filterForm">
                     <div class="row">
                        <div class="col-md-2 attendance-column1">
                           <label for="jrf_no">JRF No</label>
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
                           <th>S.No.</th>
                           <th>JRF No</th>
                           <th>JRF Creater</th>
                           <th>Project</th>
                           <th>No. of Position Hirings</th>
                           <th>Hired Candidates</th>
                           <th>Designation</th>
                           <th>Department</th>
                           <th>Closure Timeline</th>
                           <th>Final Status</th>
                           <th>JRF Close/OnHold</th>
                        </tr>
                     </thead>
                     <tbody>
                  
                        @php $counter = 1; @endphp 
                        @foreach($jrfs_approval as $key =>$jrf)
                        <tr> 
                           <td>{{@$counter++}}</td>
                           <td><a href='{{url("jrf/view-jrf/$jrf->id")}}' target="_blank">{{@$jrf->jrf_no}}</a></td>
                           <td>{{@$jrf->fullname}}</td> 
                           <td>{{@$jrf->proj_name}}</td>
                           <td>{{@$jrf->number_of_positions}}</td>
                           <td><a href='{{url("jrf/final-jrf-closed/$jrf->id")}}' target="_blank">{{@$jrf->hired_candidate}}</a></td>
                           <td>{{@$jrf->designation}}</td>
                           <td>{{@$jrf->department}}</td>
                           <td><span class="label label-danger">{{@$jrf->jrf_closure_timeline}}</span></td>

                           <td>
                            @if($jrf->closure_type == 'hold')
                              <span class="label label-warning">JRF ON HOLD</span>
                            @elseif($jrf->closure_type == 'closed')
                              <span class="label label-danger">JRF CLOSED</span>
                            @else
                              <span class="label label-primary">OPEN</span>
                            @endif
                          </td>
                         

                          <td>
                            <div class="dropdown">
                              <button class="btn btn-warning dropdown-toggle" type="button" data-toggle="dropdown">{{"None"}} 
                              </button>                            
                              @if($jrf->closure_type == 'open' || $jrf->closure_type == 'hold')
                              <ul class="dropdown-menu">  
                                
                                @if($jrf->closure_type == 'hold')
                                <li id="accountFormSubmitAB"><a href='javascript:void(0)' class="statusEmp" data-employee="{{$jrf->user_id}}" data-jrf_id="{{@$jrf->id}}" data-status="2" data-value="open">Reopen</a></li>
                                @else
                                  <li id="accountFormSubmitAB"><a href='javascript:void(0)' class="statusEmp" data-employee="{{$jrf->user_id}}" data-jrf_id="{{@$jrf->id}}" data-status="0" data-value="hold">HOLD JRF</a></li>
                                @endif

                                <li id="accountFormSubmitAB"><a href='javascript:void(0)' class="statusEmp" data-employee="{{$jrf->user_id}}" data-jrf_id="{{@$jrf->id}}" data-status="1" data-value="closed"> JRF Closure</a></li>
                              </ul>
                              @endif
                            </div>
                          </td>
                          
                        </tr>
                        @endforeach
                     </tbody>
                     <tfoot class="table-heading-style">
                        <tr>
                           <th>S.No.</th>
                           <th>JRF No</th>
                           <th>JRF Creater</th>
                           <th>Project</th>
                           <th>No. of Position Hirings</th>
                           <th>Hired Candidates</th>
                           <th>Designation</th>
                           <th>Department</th>
                           <th>Closure Timeline</th>
                           <th>Final Status</th>
                           <th>JRF Close/OnHold</th>
                           
                        </tr>
                     </tfoot>
                  </table>

               </div>

            </div>
         </div>
      </div>
       
      <div class="modal fade" id="statusModal">
         <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title">JRF CLOSER</h4>
               </div>
               <div class="modal-body">
                  <form id="statusForm" action="{{url('jrf/closoed-jrf-status')}}" method="POST">
                     {{ csrf_field() }}
                     <div class="box-body">
                        <div class="form-group">
                           <label for="description">JRF Status</label>
                           <input type="text" class="form-control" id="description" name="description" value="Status" readonly="readonly">
                        </div>
                         <div class="form-group">
                           <label for="description">JRF Closed / On Hold Date / ReOpen</label>
                           <input type="date" class="form-control" id="closure_dt" name="closure_dt">
                        </div>
                        <input type="hidden" name="action" id="modalAction">
                        <input type="hidden" name="user_id" id="modalUserId">
                        <input type="hidden" name="jrf_id" id="modaljrfId">
                        <input type="hidden" name="jrf_type" id="modaljrfType">
                        <input type="hidden" name="status" id="status">
                        
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

    <!-- Main row -->
   </section>
   <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <script src="{{asset('public/admin_assets/plugins/dataTables/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('public/admin_assets/plugins/validations/jquery.validate.js')}}"></script>
<script src="{{asset('public/admin_assets/plugins/validations/additional-methods.js')}}"></script>

  <script type="text/javascript">
  $(document).ready(function() {
     $('#listHolidays').DataTable({
       scrollX: true,
       responsive: true
     });

    $('.statusEmp').on('click',function(){

      var employee = $(this).data("employee");
      var jrf_id = $(this).data("jrf_id");
      var status = $(this).data("status");
      var status_val = $(this).data("value");
      $("#modalUserId").val(employee);
      $("#modaljrfId").val(jrf_id);
      $("#status").val(status);

 
      if(status == 0){
 
        $("#modalAction").val("deactivate");
        var modalTitle = "JRF ON HOLD";
        var actionDate = "Reject";
      }else if(status == 1){
        $("#modalAction").val("deactivate");
        var modalTitle = "JRF CLOSED";
        var actionDate = "Reject";
      }else{
        $("#modalAction").val("deactivate");
        var modalTitle = "Open JRF";
        var actionDate = "Reject";
      }

      $('.modal-title').text(modalTitle);
      $('.actionDate').text(actionDate);
      $('#statusModal').modal('show');
 
    });
  });


  $("#statusForm").validate({
      rules: {
        "closure_dt" : {
          required: true
        }
      },
      messages: {
          "closure_dt" : {
            required: 'Fill Closure Date'
          }
          
        }
  });

  </script>

@endsection