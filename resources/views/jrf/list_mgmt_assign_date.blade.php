@extends('admins.layouts.app')
@section('content')

<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">
<link rel="stylesheet" href="{!! asset('public/admin_assets/plugins/jquery-toast/jquery.toast.min.css') !!}">
<link rel="stylesheet" href="{{asset('public/admin_assets/plugins/dataTables/jquery.dataTables.min.css')}}">

<style>
table tr th, table tr td { vertical-align: middle !important;}
</style>

<!-- Content Wrapper end here -->
<div class="content-wrapper">
  <!-- Content Header Starts here -->
  <section class="content-header">
    <h1><i class="fa fa-calendar"></i> Candidates Date Assigned</h1>
    <ol class="breadcrumb">
      <li><a href="{{ url('employees/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
    </ol>
  </section> 
  <!-- Content Header Ends here -->

  <!-- Main Content Starts here -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-sm-12">

        <div class="box box-primary">
          <div class="alert-dismissible">
            @if(session()->has('success'))
               <div class="alert {{(session()->get('error')) ? 'alert-danger' : 'alert-success'}}">
                {{ session()->get('success') }}
              </div>
            @endif
          </div>
          
          <div class="box-body">
            <table id="listHolidays" class="table table-bordered table-striped text-center">
              <thead class="table-heading-style">
                <tr>
                  <th>S.No</th>
                  <th>JRF No</th>
                  <th>Recruiter Name</th>
                  <th>Candidate Name</th>
                  <th>Total Experience</th>
                  <th>Previous Company Annual CTC (INR Lakhs)</th>
                  <th>Previous Company Annual CIH (INR Lakhs)</th>
                  <th>Assigned Update Date</th>
                  <th>Assigne Date</th>
                </tr>
              </thead>
              <tbody>
                @php $counter = 1; @endphp 
                @foreach($jrfs_approval as $key =>$jrf)
                <tr> 
                  <td>{{@$counter++}}</td>
                  <td>{{@$jrf->jrf_no}}</td>
                  <td>{{@$jrf->fullname}}</td>
                  <td>{{@$jrf->cand_name}}</td>
                  <td>{{@$jrf->total_experience}}</td>
                  <td>{{@$jrf->current_ctc}}</td>
                  <td>{{@$jrf->current_cih}}</td>
                  <td>{{@$jrf->mgmt_date}}</td>
                  <td>   
                    <button class="btn btn-info btn-xs" ><a href='javascript:void(0)' style="color:#fff" class="statusEmp" data-employee="{{$jrf->user_id}}" data-jrf_id="{{@$jrf->jrf_id}}" data-lvl_id="{{@$jrf->jrf_level_one_screening_id}}" data-status="0"><span class="label">Assigned Date</span></a></button>        
                  </td>
                </tr>
                @endforeach
              </tbody>
              <tfoot class="table-heading-style">
                <tr>
                  <th>S.No</th>
                  <th>JRF No</th>
                  <th>Recruiter Name</th>
                  <th>Candidate Name</th>
                  <th>Total Experience</th>
                  <th>Previous Company Ctc</th>
                  <th>Previous Company Cih</th>
                  <th>Assigned Update Date</th>
                  <th>Assigne Date</th> 
                </tr>
              </tfoot>
            </table>
          </div><!-- /.box-body -->
        </div>
      </div>
    </div>
  </section>
  <!-- Main Content Ends here --> 
</div>
<!-- Content Wrapper end here -->

<div class="modal fade" id="statusModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Default Modal</h4>
      </div>
      <div class="modal-body">
        <form id="statusForm" action="{{url('jrf/mgmt-assigned-status')}}" method="POST">
          {{ csrf_field() }}
          <div class="box-body">
            <div class="form-group">
              <label for="description">Status</label>
              <input type="text" class="form-control" id="description" name="description" value="Assigned" readonly="readonly">
            </div>
            <div class="form-group">
              <label for="description">Assigned Date</label>

              <input type="text" name="mgmt_dt" id="mgmt_dt" class="mgmt_dt form-control future_mgmt_dt" placeholder="Please select date">
            </div>
            <input type="hidden" name="action" id="modalAction">
            <input type="hidden" name="user_id" id="modalUserId">
            <input type="hidden" name="jrf_id" id="modaljrfId">
            <input type="hidden" name="lvl_id" id="modallvlId">
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


<script src="{{asset('public/admin_assets/plugins/validations/jquery.validate.js')}}"></script>
<script src="{{asset('public/admin_assets/plugins/validations/additional-methods.js')}}"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
<script src="{{asset('public/admin_assets/plugins/dataTables/jquery.dataTables.min.js')}}"></script>

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
      var lvl_id = $(this).data("lvl_id");
      
      $("#modalUserId").val(employee);
      $("#modaljrfId").val(jrf_id);
      $("#modallvlId").val(lvl_id);
 
      if(status == 0){
 
        $("#modalAction").val("deactivate");
        var modalTitle = "ASSIGNED DATE TO CANDIDATE";
        var actionDate = "Reject";
      }

      $('.modal-title').text(modalTitle);
      $('.actionDate').text(actionDate);
      $('#statusModal').modal('show');
 
    });

  
  });


  $("#statusForm").validate({
      rules: {
        "mgmt_dt" : {
          required: true
        }
      },
      messages: {
          "mgmt_dt" : {
            required: 'Fill Assigned Date'
          }
          
        }
  });


    $(".future_mgmt_dt").datetimepicker({
      minDate : new Date(),
      format: 'MM/DD/Y hh:mm A',
    });

  </script>

@endsection