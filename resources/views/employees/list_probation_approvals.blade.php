@extends('admins.layouts.app')

@section('content')

<link rel="stylesheet" href="{{asset('public/admin_assets/plugins/dataTables/jquery.dataTables.min.css')}}">

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Probation Approvals List
        <!-- <small>Control panel</small> -->
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('employees/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
          <div class="box">
            <div class="box-header">
            </div>
            <!-- /.box-header -->
            
            <div class="box-body">

              <table id="probationApprovalList" class="table table-bordered table-striped">
                <thead class="table-heading-style">
                <tr>
                  <th>S.No.</th>
                  <th>Employee</th>
                  <th>Joining Date</th>
                  <th>Probation Period</th>
                  <th>Probation Status</th>
                  <th>HR Approval Status</th>
                  <th>HOD Approval Status</th>
                </tr>
                </thead>
                <tbody>
                <?php $counter = 0; ?>  
                @foreach($leave_authorities as $key2 => $value2)
                  @if(!$value2->list->isEmpty())
                    @foreach($value2->list as $key => $value)  
                <tr>
                  <td>{{++$counter}}</td>
                  <td>{{$value->user->employee->fullname}}</td>
                  <td>{{$value->user->employee->joining_date}}</td>
                  <td>{{$value->probationPeriod->name}}</td>
                  <td>
                      @if($value->probation_approval_status == '0')
                        <span class="label label-warning">Not Approved</span>
                      @else  
                        <span class="label label-success">Approved</span>
                      @endif
                  </td>
                  <td>
                    @if(@$value2->priority == '2')  
                      @if($value->probation_hr_approval == '0')
                        <span class="text-danger"><strong>Not Approved</strong></span>
                      @else  
                        <span class="text-success"><strong>Approved</strong></span>
                      @endif
                    @elseif(@$value2->priority == '3')  
                        <div class="dropdown">
                            @if($value->probation_hr_approval == '0')
                            <button class="btn btn-danger dropdown-toggle" type="button" data-toggle="dropdown">
                             {{"Not Approved"}}
                            @elseif($value->probation_hr_approval == '1')
                            <button class="btn btn-success dropdown-toggle" type="button" data-toggle="dropdown">
                             {{"Approved"}}
                            @endif
                          <span class="caret"></span></button>
                          <ul class="dropdown-menu">
                            <li>
                            @if($value->probation_hr_approval == '0')
                              <a href='{{ url("employees/probation-approval/approve/$value->user_id") }}/{{$value2->priority}}'>Approve</a> 
                            @endif
                            </li>
                            <li><a href="javascript:void(0)" class="changeProbation" data-employeeid="{{@$value->user_id}}" data-probationvalue="{{@$value->probationPeriod->name}}" data-joiningdate="{{@$value->user->employee->joining_date}}" data-days="{{@$value->probationPeriod->no_of_days}}" data-probationperiodid="{{@$value->probationPeriod->id}}">Change Probation</a></li>
                          </ul>
                        </div>
                    @endif  
                  </td>
                  <td>
                    @if(@$value2->priority == '3')  
                      @if($value->probation_hod_approval == '0')
                        <span class="text-danger"><strong>Not Approved</strong></span>
                      @else  
                        <span class="text-success"><strong>Approved</strong></span>
                      @endif
                    @elseif(@$value2->priority == '2')  
                        <div class="dropdown">
                            @if($value->probation_hod_approval == '0')
                            <button class="btn btn-danger dropdown-toggle" type="button" data-toggle="dropdown">
                             {{"Not Approved"}}
                            @elseif($value->probation_hod_approval == '1')
                            <button class="btn btn-success dropdown-toggle" type="button" data-toggle="dropdown">
                             {{"Approved"}}
                            @endif
                          <span class="caret"></span></button>
                          <ul class="dropdown-menu">
                            <li>
                              @if($value->probation_hod_approval == '0')
                                <a href='{{ url("employees/probation-approval/approve/$value->user_id/") }}/{{$value2->priority}}'>Approve</a>
                              @endif
                            </li>
                          </ul>
                        </div>
                    @endif  
                  </td>
                </tr>
                  @endforeach
                @endif
              @endforeach
                </tbody>
                <tfoot class="table-heading-style">
                <tr>
                  <th>S.No.</th>
                  <th>Employee</th>
                  <th>Joining Date</th>
                  <th>Probation Period</th>
                  <th>Probation Status</th>
                  <th>HR Approval Status</th>
                  <th>HOD Approval Status</th>
                </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
      </div>
      <!-- /.row -->
      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        
      </div>
      <!-- /.row (main row) -->

    </section>
    <!-- /.content -->

    <div class="modal fade" id="probationModal">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Change Probation Period</h4>
            </div>
            <div class="modal-body replyModalBody">
              <form id="changeProbationForm" action="{{ url('employees/change-probation-period')}}" method="POST">
                {{ csrf_field() }}
                  <div class="box-body">
                    
                    <div class="form-group">
                      <label for="currentProbation" class="previousProbation">Current Probation</label>
                      <input type="text" class="form-control" id="currentProbation" name="currentProbation" value="" readonly>
                    </div>

                    <div class="form-group">
                      <label>Probation Period</label>
                      <select class="form-control checkValidProbation" name="probationPeriodId" id="probationPeriodId">
                        <option value="" selected disabled>Please select a Probation Period</option>
                      @if(!$probation_periods->isEmpty())  
                        @foreach($probation_periods as $probation_period)  
                          <option value="{{$probation_period->id}}" data-newdays="{{$probation_period->no_of_days}}">{{$probation_period->name}}</option>
                        @endforeach
                      @endif
                      </select>
                      <span class="probationErrors"></span>
                    </div>

                    <input type="hidden" name="probationDays" id="probationDays">
                    <input type="hidden" name="joiningDate" id="joiningDate">
                    <input type="hidden" name="userId" id="userId">
                                 
                  </div>
                  <!-- /.box-body -->
                  <br>

                  <div class="box-footer">
                    <button type="submit" class="btn btn-primary" id="changeProbationFormSubmit">Submit</button>
                  </div>
              </form>
            </div>
            
          </div>
          <!-- /.modal-content -->
        </div>
      <!-- /.modal-dialog -->
    </div>
        <!-- /.modal -->

  </div>
  <!-- /.content-wrapper -->

  <script src="{{asset('public/admin_assets/plugins/dataTables/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('public/admin_assets/plugins/validations/jquery.validate.js')}}"></script>
  <script src="{{asset('public/admin_assets/plugins/validations/additional-methods.js')}}"></script>

  <script>
    $("#changeProbationForm").validate({
      rules :{
          "probationPeriodId" : {
              required : true
          },
      },
      messages :{
          "probationPeriodId" : {
              required : 'Please select a probation period.',
          }
      }
    });
  </script>

  <script type="text/javascript">
    var allowSubmit = {probation: 1};
    $(".probationErrors").hide();

      $(document).ready(function() {
        
      $(".changeProbation").on('click',function(){
        $(".probationErrors").hide();
        
        var currentProbation = $(this).data("probationvalue");
        var days = $(this).data("days");
        var joiningDate = $(this).data("joiningdate");
        var probationPeriodId = $(this).data("probationperiodid");
        var employeeId = $(this).data("employeeid");

        $("select option[value!='"+ probationPeriodId + "']").attr('disabled', false);
        $("select option[value='"+ probationPeriodId + "']").attr('disabled', true);
         
        $("#currentProbation").val(currentProbation);
        $("#probationDays").val(days);       
        $("#joiningDate").val(joiningDate);       
        $("#userId").val(employeeId); 

        $("#probationPeriodId").val("");           
        $('#probationModal').modal('show');
            
      });

      today = new Date();

      $(".checkValidProbation").on('change',function(){
        var days = $("#probationDays").val();       
        var joiningDate = $("#joiningDate").val(); 
        var empJoiningDate = new Date(joiningDate);
        var currentProbationEndDate = moment(empJoiningDate).add(days, 'days')._d;

        if(Date.parse(today) > Date.parse(currentProbationEndDate)){
          allowSubmit.probation = 0;
          $(".probationErrors").text("Probation period has already ended. You cannot change it now.").css('color','#f00');
          $(".probationErrors").show();
        
        }else{

          var newDays = $(this).find(':selected').data("newdays");
          var newProbationEndDate = moment(empJoiningDate).add(newDays, 'days')._d;

          if(Date.parse(today) >= Date.parse(newProbationEndDate)){
            allowSubmit.probation = 0;
            $(".probationErrors").text("Probation end date is less than today.").css('color','#f00');
            $(".probationErrors").show(); 
          }else{
            allowSubmit.probation = 1;
            $(".probationErrors").text("New End Date: "+newProbationEndDate).css('color','#00f');
            $(".probationErrors").show();
          }

        }
      });

      $("#changeProbationFormSubmit").on('click',function(){
        if(allowSubmit.probation == 0){
          return false;
        }else{
          $("#changeProbationForm").submit();
        }
      });

      $('#probationApprovalList').DataTable();
          
    });

      
  </script>
  
  @endsection