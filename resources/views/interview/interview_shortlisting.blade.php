@extends('admins.layouts.app')

@section('content')

<link rel="stylesheet" href="{{asset('public/admin_assets/plugins/dataTables/jquery.dataTables.min.css')}}">

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Interview Shortlisting
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
        <div class="col-md-12">
          <div class="box box-primary">
            <form id="interview_shortlisting">
                  <div class="row select-detail-below">
                      <div class="col-md-2 attendance-column1">
                        <label>Project</label>
                        <select class="form-control input-sm basic-detail-input-style" name="projectName">
                            <option value="" selected disabled>Please select Project</option>
                            <option value="Project 1">Project 1</option>
                            <option value="Project 2">Project 2</option>
                            <option value="Project 3">Project 3</option>
                            <option value="Project 4">Project 4</option>
                        </select>
                      </div>

                      <div class="col-md-2 attendance-column2">
                        <label>Years</label>
                        <select class="form-control input-sm basic-detail-input-style" name="experience">
                            <option value="" selected disabled>Select Experience</option>
                            <option value="Exp 1">Exp 1</option>
                            <option value="Exp 2">Exp 2</option>
                            <option value="Exp 3">Exp 3</option>
                            <option value="Exp 4">Exp 4</option>
                            <option value="Exp 5">Exp 5</option>
                        </select>
                      </div>

                      <div class="col-md-2 attendance-column3">
                        <label>Qualification</label>
                        <select class="form-control input-sm basic-detail-input-style" name="qualification">
                            <option value="" selected disabled>Select Qualification</option>
                            <option value="Qualification 1">Qualification 1</option>
                            <option value="Qualification 2">Qualification 2</option>
                            <option value="Qualification 3">Qualification 3</option>
                            <option value="Qualification 4">Qualification 4</option>
                            <option value="Qualification 5">Qualification 5</option>
                        </select>
                      </div>

                      <div class="col-md-2 attendance-column3">
                        <label>Skill</label>
                        <select class="form-control input-sm basic-detail-input-style" name="skills">
                            <option value="" selected disabled>Select Skill</option>
                            <option value="Skill 1">Skill 1</option>
                            <option value="Skill 2">Skill 2</option>
                            <option value="Skill 3">Skill 3</option>
                            <option value="Skill 4">Skill 4</option>
                            <option value="Skill 5">Skill 5</option>
                        </select>
                      </div>

                      <div class="col-md-2 attendance-column3">
                        <label>Location</label>
                        <select class="form-control input-sm basic-detail-input-style" name="location">
                            <option value="" selected disabled>Select Location</option>
                            <option value="Location 1">Location 1</option>
                            <option value="Location 2">Location 2</option>
                            <option value="Location 3">Location 3</option>
                            <option value="Location 4">Location 4</option>
                            <option value="Location 5">Location 5</option>
                        </select>
                      </div>                  

                      <div class="col-md-2 attendance-column4">
                          <div class="form-group">
                              <button type="submit" class="btn searchbtn-attendance">Search <i class="fa fa-search"></i></button>
                          </div>
                      </div>
                  </div>
                  <br>
              </form>
            <!-- <div class="box-header">
            </div> -->
            <!-- /.box-header -->

            <div class="box-body">
              <table id="interviewShortList" class="table table-bordered table-striped travel-table-inner" style="height:150px;">
                <thead class="table-heading-style">
                <tr>
                  <th>S No</th>
                  <th>Applicant Name</th>
                  <th>Mobile</th>
                  <th>Email</th>
                  <th>Profile</th>
                  <th>Profile ID</th>
                  <th>JobBoard ID</th>
                  <th>Status</th>
                  <th>Assignee</th>
                  <th>Interviewer</th>
                  <th>Review</th>
                </tr>
                </thead>
                <tbody class="text-center"> 
                <tr>
                  <td>1</td>
                  <td><a href="javascript:void(0)" class="interviewEmployeeName">Gautam Singh</a></td>
                  <td>9876756443</td>
                  <td>gautam@gmail.com</td>
                  <td>Consultant</td>
                  <td>XV19-1101</td>
                  <td>32201</td>
                  <td>Shortlisted</td>
                  <td>Rani</td>
                  <td>Harish Bhatt</td>
                  <td>Pending</td>
                </tr>
                <tr>
                  <td>2</td>
                  <td>Gautam Singh</td>
                  <td>9876756443</td>
                  <td>gautam@gmail.com</td>
                  <td>Consultant</td>
                  <td>XV19-1101</td>
                  <td>32201</td>
                  <td>Shortlisted</td>
                  <td>Rani</td>
                  <td>Harish Bhatt</td>
                  <td>Pending</td>
                </tr>
                <tr>
                  <td>3</td>
                  <td>Gautam Singh</td>
                  <td>9876756443</td>
                  <td>gautam@gmail.com</td>
                  <td>Consultant</td>
                  <td>XV19-1101</td>
                  <td>32201</td>
                  <td>Shortlisted</td>
                  <td>Rani</td>
                  <td>Harish Bhatt</td>
                  <td>Pending</td>
                </tr>
                </tbody>
                <tfoot class="table-heading-style">
                <tr>
                  <th>S No</th>
                  <th>Applicant Name</th>
                  <th>Mobile</th>
                  <th>Email</th>
                  <th>Profile</th>
                  <th>Profile ID</th>
                  <th>JobBoard ID</th>
                  <th>Status</th>
                  <th>Assignee</th>
                  <th>Interviewer</th>
                  <th>Review</th>
                </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>
      <!-- /.row -->
      <!-- Main row -->

    </section>
    <!-- /.content --> 
<div class="containerSuitable"></div>
  <!-- /.content-wrapper -->

<div class="modal fade" id="employeefollowUp">
  <div class="modal-dialog follow-modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close attendance-close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">FollowUp Status</h4>
      </div>
      <div class="modal-body">
        <div class="container-fluid">

          <!-- Followup section 1 starts here -->
          <div class="row">
            <div class="col-md-3 follow-up-columns">
              <span>Employee Name</span>
              <div class="border-1px">
                <span class="border">Gautam Singh</span>
              </div>
            </div>
            <div class="col-md-3 follow-up-columns">
              <span>Mobile No.</span>
              <div class="border-1px">
                <span class="border">9876543210</span>
              </div>
            </div>
            <div class="col-md-3 follow-up-columns">
              <span>Email ID</span>
              <div class="border-1px">
                <span class="border">xyz@gmail.com</span>
              </div>
            </div>
            <div class="col-md-3 follow-up-columns">
              <span>JobBoard ID</span>
              <div class="border-1px">
                <span class="border">12345</span>
              </div>
            </div>
          </div>

          <!-- Followup section 2 starts here -->
          <div class="row">
            <p class="follow-para1">Status</p>

            <div class="col-md-3 follow-up-columns1">
                <div class="input-group basic-detail-input-style">
                   <input autocomplete="off" type="text" class="form-control followupDate selectDate input-sm basic-detail-input-style" name="date" placeholder="MM/DD/YYYY" value="" readonly>

                    <div class="input-group-addon time-icon">
                      <i class="fa fa-calendar"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3 follow-up-columns2">
              <select name="" id="" class="form-control input-sm basic-detail-input-style">
                <option value="Main Status 1">Followup</option>
                <option value="Main Status 2">Shortly</option>
                <option value="Main Status 3">Interview Schedule</option>
              </select>
            </div>
            <div class="col-md-3 follow-up-columns3">
              <select name="" id="" class="form-control input-sm basic-detail-input-style">
                <option value="" selected disabled>Main Status</option>
                <option value="Main Status 1">Main Status 1</option>
                <option value="Main Status 2">Main Status 2</option>
                <option value="Main Status 3">Main Status 3</option>
                <option value="Main Status 4">Main Status 4</option>
                <option value="Main Status 5">Main Status 5</option>
              </select>
            </div>
            <div class="col-md-3 follow-up-columns4">
              <select name="" id="" class="form-control input-sm basic-detail-input-style">
                <option value="" selected disabled>Sub Status</option>
                <option value="Sub Status 1">Sub Status 1</option>
                <option value="Sub Status 2">Sub Status 2</option>
                <option value="Sub Status 3">Sub Status 3</option>
                <option value="Sub Status 4">Sub Status 4</option>
                <option value="Sub Status 5">Sub Status 5</option>
              </select>
            </div>

            <div class="col-md-12 follow-up-columns5">
              <input type="text" name="" id="" placeholder="Add Remarks" class="form-control input-sm basic-detail-input-style">
            </div>
          </div>

          <!-- Followup section 3 starts here -->
          <div class="row">
            <p class="follow-para1">Interview Schedule</p>
            <div class="col-md-3 follow-up-columns1">
                <div class="input-group basic-detail-input-style">
                   <input autocomplete="off" type="text" class="form-control selectDate followupDate input-sm basic-detail-input-style" name="date" placeholder="MM/DD/YYYY" value="" readonly>

                    <div class="input-group-addon time-icon">
                      <i class="fa fa-calendar"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3 follow-up-columns3">
              <select name="" id="" class="form-control input-sm basic-detail-input-style">
                <option value="" selected disabled>Main Status</option>
                <option value="Selected">Selected</option>
                <option value="Not Selected">Not Selected</option>
                <option value="Backout">Backout</option>
                <option value="On Board">On Board</option>
                <option value="On Hold">On Hold</option>
              </select>
            </div>
            <div class="col-md-6 follow-up-columns4">
              <select name="" id="" class="form-control input-sm basic-detail-input-style">
                <option value="" selected disabled>Sub Status</option>
                <option value="Sub Status 1">Sub Status 1</option>
                <option value="Sub Status 2">Sub Status 2</option>
                <option value="Sub Status 3">Sub Status 3</option>
                <option value="Sub Status 4">Sub Status 4</option>
                <option value="Sub Status 5">Sub Status 5</option>
              </select>
            </div>
            <div class="col-md-12 follow-up-columns5">
              <input type="text" name="" id="" placeholder="Add Remarks" class="form-control input-sm basic-detail-input-style">
            </div>
          </div>

          <!-- Followup section 4 starts here -->
          <div class="row">
            <p class="follow-para1">History</p>
            <div class="col-md-3 follow-up-columns1">
                <div class="input-group basic-detail-input-style">
                   <input autocomplete="off" type="text" class="form-control followupDate selectDate input-sm basic-detail-input-style" name="date" placeholder="MM/DD/YYYY" value="" readonly>

                    <div class="input-group-addon time-icon">
                      <i class="fa fa-calendar"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3 follow-up-columns3">
              <select name="" id="" class="form-control input-sm basic-detail-input-style">
                <option value="" selected disabled>Main Status</option>
                <option value="Selected">Selected</option>
                <option value="Not Selected">Not Selected</option>
                <option value="Backout">Backout</option>
                <option value="On Board">On Board</option>
                <option value="On Hold">On Hold</option>
              </select>
            </div>
            <div class="col-md-5 follow-up-columns4">
              <select name="" id="" class="form-control input-sm basic-detail-input-style">
                <option value="" selected disabled>Sub Status</option>
                <option value="Sub Status 1">Sub Status 1</option>
                <option value="Sub Status 2">Sub Status 2</option>
                <option value="Sub Status 3">Sub Status 3</option>
                <option value="Sub Status 4">Sub Status 4</option>
                <option value="Sub Status 5">Sub Status 5</option>
              </select>
            </div>
            <div class="col-md-1 follow-up-columns6">
              <div class="view-employee-history-box">
                <i class="fa fa-eye view-employee-history"></i>
                <span class="history-tooltiptext">Your Remarks Here</span>
              </div>
            </div>
          </div>

        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary">Save</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


  <script src="{{asset('public/admin_assets/plugins/dataTables/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('public/admin_assets/plugins/validations/jquery.validate.js')}}"></script>
  <script src="{{asset('public/admin_assets/plugins/validations/additional-methods.js')}}"></script>

<script type="text/javascript">
//Date picker
    $(".followupDate").datepicker({
      //startDate: minimumDate,
      /*endDate: maximumDate,*/
      autoclose: true,
      orientation: "bottom"
    });

    $('#interviewShortList').DataTable({
      "scrollX": true,
      responsive: true
    });
</script>

<script type="text/javascript">
$(document).ready(function(){
  $(".interviewEmployeeName").on('click', function(){
    $("#employeefollowUp").modal('show');
  });
});
</script>

  @endsection