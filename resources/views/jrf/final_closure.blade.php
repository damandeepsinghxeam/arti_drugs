@extends('admins.layouts.app')
@section('content') 
<style>
.add-kra-box {
    border: 1px solid #3c8dbc;
    border-radius: 8px;
    padding: 16px;
}
.table-styling {
    border: 1px solid #3c8dbc;
    padding: 10px;
    border-radius: 8px;
}
.d_o_r {
   margin-bottom: 20px;
}
.submit-btn-style {
    margin-bottom: 20px;
}
.a_r_style_green {
    background-color: green;
}
.a_r_style_red {
    background-color: red;
}
.a_r_style_green, .a_r_style_red {
    padding: 6px 8px;
    border-radius: 20px;
}
.a_r_style {
    font-size: 16px;
    color: white;
    margin: 0 2px;
}
.security_amount_field, .security_cheque_fields {
   display: none;
}
input.slider_input {
    width: auto;
    display: inline-block;
}
.range-container {
    display: flex;
    align-items: center;
    margin-bottom: 5px;
}
span.display_span {
    background-color: #3c8dbc;
    padding: 6px 3px;
    color: white;
    margin-left: 10px;
    border-radius: 27px;
    text-align: center;
    width: 31px;
}
.input-group-addon, .input-group-btn {
    vertical-align: top;
}
.heading2 {
    font-size: 16px;
    margin-top: 10px;
    font-weight: 600;
    text-decoration: underline;
    text-align: center;
}
table tr th {
   width: 220px;
}
</style>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>JRF FEEDBACK FORM</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Locations List</a></li> 
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
         <div class="col-sm-12">
           <div class="box box-primary">

            @if($errors->basic->any())
                 <div class="alert alert-danger alert-dismissible">
                 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <ul>
                       @foreach ($errors->basic->all() as $error)
                       <li>{{ $error }}</li>
                       @endforeach
                    </ul>
                 </div>
              @endif

              <div class="alert-dismissible">
                  @if(session()->has('success'))
                    <div class="alert {{(session()->get('error')) ? 'alert-danger' : 'alert-success'}}">
                      {{ session()->get('success') }}
                    </div>
                  @endif
              </div>

              <!-- form start -->
              <form id="Closure_form" method="POST" action="{{url('jrf/save-closure')}}" enctype="multipart/form-data">
                {{ csrf_field() }}
                  <div class="box-body jrf-form-body">
                     <div class="row">
                        <div class="col-md-5">
                           <div class="input-group d_o_r">
                              <div class="input-group-btn">
                              <button type="button" class="btn btn-primary">Jrf No.</button>
                              </div><!-- /btn-group -->
                              <input type="text" class="form-control" value="{{@$data['basic']->jrf_no}}" disabled>
                           </div>
                        </div>

                        <div class="col-md-7">
                          <div class="table-styling">
                          <fieldset>
                            <legend style="text-align: center;">FEEDBACK</legend>
                            <table class="table table-striped table-responsive">
                             <tr>
                               <th>Interviewer Name</th>
                               <td>
                                 <input type="text" name="" value="{{@$data['recruiter']->employee->fullname}}" id="" class="form-control basic-detail-input-style" placeholder="Entered Value Here" disabled>

                                  <input type="hidden" value="{{Auth::id()}}" name="superwisor_id">
                                  <input type="hidden" value="{{$data['basic']->user_id}}" name="user_Id">
                                  <input type="hidden" value="{{$data['basic']->jrf_id}}" name="jrf_id">
                                  <input type="hidden" value="{{$data['basic']->id}}" name="level1_screen_id">
                                  <input type="hidden" value="{{$data['basic']->closed_jrf+1}}" name="closed_jrf">
                                  <input type="hidden" value="{{$data['basic']->nops}}" name="nops">
                                  <input type="hidden" value="{{$data['basic']->jrf_no}}" name="jrf_no">
                                  <input type="hidden" value="{{$data['basic']->name}}" name="cand_name">

                               </td>
                             </tr>

                              <tr>
                               <th>Recruiter Name</th>
                               <td>
                                 <input type="text" name="" value="{{@$data['basic']->fullname}}" id="" class="form-control basic-detail-input-style" placeholder="Entered Value Here" disabled>
                               </td>
                              </tr>
                             <tr>
                               <th>Hired Employee Name</th>
                                 <td>
                                   <input type="text" name="" value="{{@$data['basic']->name}}" id="" class="form-control basic-detail-input-style" placeholder="Entered Value Here" disabled>
                                 </td>
                             </tr>
                              <tr>
                               <th>Designation</th>
                                 <td>
                                   <input type="text" name="" value="{{@$data['basic']->designation}}" id="" class="form-control basic-detail-input-style" placeholder="Entered Value Here" disabled>
                                 </td>
                             </tr>
                              <tr>
                               <th>Department</th>
                                 <td>
                                   <input type="text" name="" value="{{@$data['basic']->department}}" id="" class="form-control basic-detail-input-style" placeholder="Entered Value Here" disabled>
                                 </td>
                             </tr>
                            <!-- <tr>
                              <th>Designation</th>
                                <td>
                                  <select class="form-control select2 input-sm basic-detail-input-style" name="designation_id" style="width: 100%;" id="designation_id" data-placeholder="Select Designation">
                                    @if(!$data['designation']->isEmpty())
                                    @foreach($data['designation'] as $desig)  
                                    <option value="{{$desig->id}}">{{$desig->name}}</option>
                                    @endforeach
                                    @endif  
                                  </select>
                                </td>
                             </tr> -->

                           <!--  <tr>
                              <th>Department</th>
                                <td>
                                  <select class="form-control basic-detail-input-style regis-input-field" name="department_id" id="department_id">
                                    @if(!$data['departments']->isEmpty())
                                    @foreach($data['departments'] as $department)
                                    <option value="{{$department->id}}">{{$department->name}}</option>
                                    @endforeach
                                    @endif
                                  </select>
                                
                                </td>
                             </tr> -->

                            <tr>
                              <th>Joined Date</th>
                                <td>
                                   <input type="text" name="" value="{{@$data['basic']->joining_date}}" id="" class="form-control basic-detail-input-style" placeholder="Entered Value Here" disabled>
                                </td>
                             </tr>

                             <tr>
                              <th>Attached Joined Letter</th>
                                <td>
                                   <input type="file" name="joining_letter" value="" id="joining_letter" class="form-control basic-detail-input-style">
                                </td>
                             </tr>

                           <!--  <tr>
                              <th>Location</th>
                                <td>
                                  <select class="form-control select2 input-sm basic-detail-input-style" name="city_id"  style="width: 100%;" id="city_id" data-placeholder="Select Location">
                                    @if(!$data['cities']->isEmpty())
                                    @foreach($data['cities'] as $citi)  
                                      <option value="{{$citi->id}}">{{$citi->name}}</option>
                                    @endforeach
                                    @endif  
                             </select>
                                </td>
                             </tr> 

                             <tr>
                              <th>Reporting To</th>
                                <td>
                                  <select class="form-control basic-detail-input-style input-sm" name="approver_id" id="approver_id"></select>
                                </td>
                             </tr>-->
                            
                           </table>
                         </fieldset>
                           <fieldset>
                            <legend style="text-align: center;">REPORTING MANAGER'S FEEDBACK</legend>
                           <table class="table table-striped table-responsive">
                              <tr>
                                 <th>Quick Learner:</th>
                                 <td>
                                    <input type="radio" name="quick_learner" id="quick_learner" value="excellent">
                                    <label for="Excellent">Excellent</label>&nbsp;&nbsp;
                                    <input type="radio" name="quick_learner" id="quick_learner" value="very_good">
                                    <label for="Very Good">Very Good</label>
                                    <input type="radio" name="quick_learner" id="quick_learner" value="good">
                                    <label for="Good">Good</label>
                                    <input type="radio" name="quick_learner" id="quick_learner" value="average">
                                    <label for="Average">Average</label>
                                 </td>
                              </tr>

                               <tr>
                                 <th>Confidence level:</th>
                                 <td>
                                    <input type="radio" name="confid_lvl" id="confid_lvl" value="excellent">
                                    <label for="Excellent">Excellent</label>&nbsp;&nbsp;
                                    <input type="radio" name="confid_lvl" id="confid_lvl" value="very_good">
                                    <label for="Very Good">Very Good</label>
                                    <input type="radio" name="confid_lvl" id="confid_lvl" value="good">
                                    <label for="Good">Good</label>
                                    <input type="radio" name="confid_lvl" id="confid_lvl" value="average">
                                    <label for="Average">Average</label>
                                 </td>
                              </tr>

                               <tr>
                                 <th>Attitude/ Behavior:</th>
                                 <td>
                                    <input type="radio" name="attitude" id="attitude" value="excellent">
                                    <label for="Excellent">Excellent</label>&nbsp;&nbsp;
                                    <input type="radio" name="attitude" id="attitude" value="very_good">
                                    <label for="Very Good">Very Good</label>
                                    <input type="radio" name="attitude" id="attitude" value="good">
                                    <label for="Good">Good</label>
                                    <input type="radio" name="attitude" id="attitude" value="average">
                                    <label for="Average">Average</label>
                                 </td>
                              </tr>

                              <tr>
                                 <th>Team work:</th>
                                 <td>
                                    <input type="radio" name="team_work" id="team_work" value="excellent">
                                    <label for="Excellent">Excellent</label>&nbsp;&nbsp;
                                    <input type="radio" name="team_work" id="team_work" value="very_good">
                                    <label for="Very Good">Very Good</label>
                                    <input type="radio" name="team_work" id="team_work" value="good">
                                    <label for="Good">Good</label>
                                    <input type="radio" name="team_work" id="team_work" value="average">
                                    <label for="Average">Average</label>
                                 </td>
                              </tr>

                              <tr>
                                 <th>Execution skills:</th>
                                 <td>
                                    <input type="radio" name="exec_skill" id="exec_skill" value="excellent">
                                    <label for="Excellent">Excellent</label>&nbsp;&nbsp;
                                    <input type="radio" name="exec_skill" id="exec_skill" value="very_good">
                                    <label for="Very Good">Very Good</label>
                                    <input type="radio" name="exec_skill" id="exec_skill" value="good">
                                    <label for="Good">Good</label>
                                    <input type="radio" name="exec_skill" id="exec_skill" value="average">
                                    <label for="Average">Average</label>
                                 </td>
                              </tr>

                              <tr>
                                 <th>Result orientation:</th>
                                 <td>
                                    <input type="radio" name="result_orient" id="result_orient" value="excellent">
                                    <label for="Excellent">Excellent</label>&nbsp;&nbsp;
                                    <input type="radio" name="result_orient" id="result_orient" value="very_good">
                                    <label for="Very Good">Very Good</label>
                                    <input type="radio" name="result_orient" id="result_orient" value="good">
                                    <label for="Good">Good</label>
                                    <input type="radio" name="result_orient" id="result_orient" value="average">
                                    <label for="Average">Average</label>
                                 </td>
                              </tr>
                              
                              <tr>
                                 <th>Attendance:</th>
                                 <td>
                                    <input type="radio" name="attendence" id="attendence" value="regular">
                                    <label for="Excellent">Regular</label>&nbsp;&nbsp;
                                    <input type="radio" name="attendence" id="attendence" value="not_regular">
                                    <label for="Very Good">Not Regular</label>
                                    
                                 </td>
                              </tr>

                           </table>
                         </fieldset>
                           
                        </div>
                     </div>
                  </div>
               </div>
               <!-- /.box-body -->
               <div class="box-footer text-center" style="margin-right: 6%;">
                  <input type="submit" class="btn btn-primary submit-btn-style" id="submit2" value="SUBMIT" name="submit">
               </div>
            </form>
          </div>
      </div>
          <!-- /.box -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<script src="{{asset('public/admin_assets/plugins/validations/jquery.validate.js')}}"></script>
<script src="{{asset('public/admin_assets/plugins/validations/additional-methods.js')}}"></script>

<script>
$("#Closure_form").validate({
  rules: {
   "closour_date" : {
     required: true
   },

   "quick_learner" : {
     required: true
   },

   "confid_lvl" : {
     required: true
   },

   "attitude" : {
     required: true
   },

   "team_work" : {
     required: true
   },

   "exec_skill" : {
     required: true
   },

   "result_orient" : {
     required: true
   },

   "attendence" : {
     required: true
   },

   "joining_letter" :{
      required: true
   }
  },
   errorPlacement: function(error, element) {
       if ( element.is(":radio") ) {
           error.css("display","block");
           error.appendTo( element.parent());
       }
       else { // This is the default behavior of the script
           error.insertAfter( element );
       }
   },

  messages: {
   
   "closour_date" : {
     required: 'Please select any option'
   },

    "quick_learner" : {
     required: 'Please select any option'
   },

   "confid_lvl" : {
     required: 'Please select any option'
   },

   "attitude" : {
     required: 'Please select any option'
   },

   "team_work" : {
     required: 'Please select any option'
   },

   "exec_skill" : {
     required: 'Please select any option'
   },

   "result_orient" : {
     required: 'Please select any option'
   },

   "attendence" : {
     required: 'Please select any option'
   },

   "joining_letter" :{
      required: 'Please Attached joining Letter'
   }
  }
});


// for Approval request person //
    var userId = "{{@$user_id}}";
    $('#department_id').on('change', function(){
    var department = $(this).val();
    var displayString = "";
    $("#approver_id").empty();
    var departments = [];
    departments.push(department);
        $.ajax({
          type: "POST",
          url: "{{url('employees/departments-wise-employees')}}",
          data: {department_ids: departments},
          success: function(result){
            if(result.length == 0 || (result.length == 1 && result[0].user_id == userId)){
                displayString += '<option value="" disabled>None</option>';
            }else{
            result.forEach(function(employee){
              if(employee.user_id != userId && employee.user_id != 1){
                displayString += '<option value="'+employee.user_id+'">'+employee.fullname+'</option>';
              }
            });
          }
          $('#approver_id').append(displayString);
        }
      });
    }).change();


</script>

@endsection