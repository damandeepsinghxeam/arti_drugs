@extends('admins.layouts.app')
@section('content')
<link rel="stylesheet" href="{{asset('public/admin_assets/plugins/dataTables/jquery.dataTables.min.css')}}">
<script src="{{asset('public/admin_assets/plugins/validations/jquery.validate.js')}}"></script>
<script src="{{asset('public/admin_assets/plugins/validations/additional-methods.js')}}"></script>

<style>
table tr th, table tr td { vertical-align: middle !important;}
</style>

<!-- Content Wrapper Starts here -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
    <h1><i class="fa fa-list"></i> Candidate Appointment</h1>
    <ol class="breadcrumb">
      <li><a href="{{ url('employees/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
    </ol>
   </section>
   
   <!-- Main content Starts here-->
   <section class="content">
    <!-- Main Row Starts here -->
    <div class="row">
      <div class="col-sm-12">
        <!-- Box Primary Starts here -->
        <div class="box box-primary">
          <div class="alert-dismissible">
            @if(session()->has('success'))
              <div class="alert {{(session()->get('error')) ? 'alert-danger' : 'alert-success'}}">
                {{ session()->get('success') }}
              </div>
            @endif
          </div>

          <!-- Box Body starts here -->
          <div class="box-body">
            <table id="listHolidays" class="table table-bordered table-striped text-center">
              <thead class="table-heading-style">
                <tr>
                  <th>S.No.</th>
                  <th>JRF No</th>
                  <th>Interviewer Name</th>
                  <th>Candidate Name</th>
                  <th>Created Date</th>
                  <th>Appointment</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @php $counter = 1; @endphp 
                @foreach($jrfs_approval as $key =>$jrf)

                <tr> 
                  <td>{{@$counter++}}</td>
                  <td><a  href='{{url("jrf/view-jrf/$jrf->jrf_id")}}'>{{@$jrf->jrf_no}}</a></td>
                  <td>{{@$jrf->fullname}}</td>
                  <td>{{@$jrf->name}}</td>
                  <td>{!! date('yy-m-d', strtotime($jrf->created_at)) !!}</td>
                  
                  <td>
                    @if($jrf->closure_type == 'open')
                    @if( $jrf->status_before_appoint=='1' )        
                      &nbsp;<a class="btn btn-danger rec_tasks" target="_blank">CANDIDATE REJECTED</a>

                      @elseif($jrf->appoint_id == '0')
                       &nbsp;<a class="btn btn-primary rec_tasks" target="_blank" href='{{url("jrf/final-appointment-approval/$jrf->jrf_level_one_screening_id")}}'>CANDIDATE APPOINTMENT</a>
                     
                    @else
                      <button class="btn btn-primary" disabled="disabled">APPOINTED</button>
                    @endif
                    @elseif($jrf->closure_type == 'hold')
                      <span class="label label-warning">JRF ON HOLD</span>
                    @else
                      <span class="label label-danger">JRF CLOSED</span>
                    @endif

                     
                  </td>
                  <td>
                    <div class="dropdown">
                        @if($jrf->status == 0)
                        <button class="btn btn-warning dropdown-toggle" type="button" data-toggle="dropdown">
                        {{"Action"}}
                        @else
                        <button class="btn btn-danger dropdown-toggle" type="button" data-toggle="">
                        {{"Rejected"}}
                        @endif
                        <span class="caret"></span></button>
                        @if($jrf->appoint_id == 0)
                        <ul class="dropdown-menu">
                          <li>
                            <a href='javascript:void(0)' class="statusEmp" data-employee="{{$jrf->user_id}}" data-lvl_one_id="{{@$jrf->jrf_level_one_screening_id}}" data-jrf_id="{{@$jrf->jrf_id}}" data-status="0">Reject</a>
                          </li>
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
                  <th>Interviewer Name</th>
                  <th>Candidate Name</th>
                  <th>Created Date</th>
                  <th>Appointment</th>
                  <th>Action</th>
                </tr>
              </tfoot>
            </table>
          </div>
          <!-- Box Body Ends here -->
        </div>
        <!-- Box Primary Ends here -->
      </div>
    </div>
    <!-- Main Row Starts here -->

    <!-- Modal Starts here -->
    <div class="modal fade" id="statusModal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Default Modal</h4>
          </div>
          <div class="modal-body">
            <form id="statusForm" action="{{url('jrf/change-status')}}" method="POST">
              {{ csrf_field() }}
              <div class="box-body">
                <div class="form-group">
                  <label for="description">Reason For Rejection</label>
                  <input type="text" class="form-control" id="description" name="description">
                </div>
                <input type="hidden" name="action" id="modalAction">
                <input type="hidden" name="user_id" id="modalUserId">
                <input type="hidden" name="level_one_id" id="modallvlId">
                <input type="hidden" name="jrf_id" id="modaljrfId">
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
    </div>
    <!-- Modal Ends here -->

  </section>
  <!-- Main content Ends here-->

</div>
<!-- Content Wrapper Ends here -->


<script src="{{asset('public/admin_assets/plugins/dataTables/jquery.dataTables.min.js')}}"></script>

<script type="text/javascript">
  $(document).ready(function() {
    $('#listHolidays').DataTable({
      scrollX: true,
      responsive: true
    });

    $('.statusEmp').on('click',function(){
 
      var employee = $(this).data("employee");
      var lvl_one_id = $(this).data("lvl_one_id");
      var jrf_id = $(this).data("jrf_id");
      var status = $(this).data("status");
      $("#modalUserId").val(employee);
      $("#modallvlId").val(lvl_one_id);
      $("#modaljrfId").val(jrf_id);
 
      if(status == 0){
 
        $("#modalAction").val("deactivate");
        var modalTitle = "REJECT CANDIDATE";
        var actionDate = "Reject";
      }

      $('.modal-title').text(modalTitle);
      $('.actionDate').text(actionDate);
      $('#statusModal').modal('show');
 
    });
  });


  $("#statusForm").validate({
      rules: {
        "description" : {
          required: true
        }
      },
      messages: {
          "description" : {
            required: 'Fill Description'
          }
        }
  });

  </script>

@endsection