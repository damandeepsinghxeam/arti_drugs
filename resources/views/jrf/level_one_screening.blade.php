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
.notice_period_field {
   display: none;
}

img.profile-user-img.img-responsive.candidate_picture {
    margin-left: inherit;
    height: 150px;
    width: 200px;
}
</style>

<link rel="stylesheet" href="{{asset('public/admin_assets/plugins/timepicker/bootstrap-timepicker.min.css')}}">
<script src="{{asset('public/admin_assets/plugins/timepicker/bootstrap-timepicker.min.js')}}"></script>
<script src="{{asset('public/admin_assets/plugins/validations/jquery.validate.js')}}"></script>
<script src="{{asset('public/admin_assets/plugins/validations/additional-methods.js')}}"></script>

<link rel="stylesheet" href="{{asset('public/admin_assets/plugins/dataTables/jquery.dataTables.min.css')}}">
<script src="{{asset('public/admin_assets/plugins/dataTables/jquery.dataTables.min.js')}}"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css"/>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>JRF - Screening</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{url('/jrf/recruitment-tasks-assigned-jrf-list')}}">Assigned JRF List</a></li> 
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
         <div class="col-sm-12">
           <div class="box box-primary">
             @if ($errors->basic->any())
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
            <form id="jrfscreeningform" method="POST" action="{{ url('jrf/save-level-one-screening-detail') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
               <div class="box-body jrf-form-body">
                  <div class="row">

                     <div class="col-md-4">
                        <div class="input-group d_o_r">
                           <div class="input-group-btn">
                           <button type="button" class="btn btn-primary">Recruiter's Name</button>
                           </div><!-- /btn-group -->
                           <input type="text" class="form-control" value="{{@$data['basic_recruiter']->fullname}}" disabled>
                        </div>
                        <!--
                        <div class="input-group d_o_r">
                           <div class="input-group-btn">
                           <button type="button" class="btn btn-warning">Applied For</button>
                           </div>
                           <input type="text" class="form-control" value="{{@$data['basic']->role}}" disabled>
                        </div> -->
                        <div class="input-group d_o_r">
                           <div class="input-group-btn">
                           <button type="button" class="btn btn-info">Location</button>
                           </div><!-- /btn-group -->
                           <input type="text" class="form-control" value="{{@$data['location']}}" disabled>
                        </div>
                      </div>

                     <div class="col-md-8">
                        <div class="table-styling">
                          @php $auth_id = Auth::id(); @endphp
                          
                          @php 
                            $ymd = $data['last_date_recruitment'];
                            $timestamp = strtotime($ymd);  
                          @endphp 
                          
                          <div class="alert alert-danger" role="alert" style="font-size:16px">
                            <strong>Oh Snap ! </strong><b>Last Date Of Recruitment : 
                              {{ $dmy = date("d-m-Y",$timestamp ) }}</b>
                          </div>

                          <table class="table table-striped table-responsive">   
                            <tr>
                               <th><button type="button" class="btn btn-warning">Post Applied For</button></th>
                               <td>
                                 <input type="text" name="" id="" class="form-control basic-detail-input-style" value="{{@$data['basic']->role}}" disabled="disabled">
                               </td>
                             </tr>

                             <tr>
                               <th>Name<sup class="ast">*</sup></th>
                               <td>
                                 <input type="text" name="name" id="" class="form-control basic-detail-input-style" placeholder="Enter Name here">
                                 <input type="hidden" name="user_id" value="{{$auth_id}}"> 
                                 <input type="hidden" name="jrf_id" value="{{@$data['basic']->id}}">
                                 <input type="hidden" name="recruitment_task_id" value="{{@$data['recruitment_task_id']}}">
                               </td>
                             </tr>
                             <tr>
                               <th>Contact No<sup class="ast">*</sup></th>
                               <td>
                                 <input type="number" name="contact" id="" class="form-control basic-detail-input-style" placeholder="For Ex: 9876543210">
                               </td>
                             </tr>
                             <tr>
                               <th>Age</th>
                               <td>
                                 <input type="number" name="age" id="" class="form-control basic-detail-input-style" placeholder="For Ex: 24">
                               </td>
                             </tr>
                             <tr>
                               <th>Current Location</th>
                               <td>
                                 <select name="city_id" id="" class="form-control basic-detail-input-style select2">
                                    @if(!$data['cities']->isEmpty())
                                      @foreach($data['cities'] as $citi)  
                                        <option value="{{$citi->id}}">{{$citi->name}}</option>
                                      @endforeach
                                    @endif  
                                 </select>
                               </td>
                             </tr>
                             <tr>
                               <th>Native Place</th>
                               <td>
                                 <input type="text" name="native_place" id="" class="form-control basic-detail-input-style" placeholder="Enter Native place">
                               </td>
                             </tr>
                             <tr>
                               <th>Qualification<sup class="ast">*</sup></th>
                               <td>
                                 <select name="qualification_id[]" id=""class="form-control basic-detail-input-style select2" multiple="multiple" data-placeholder="Select Qualification">
                                    @if(!$data['qualifications']->isEmpty())
                                      @foreach($data['qualifications'] as $quali)  
                                        <option value="{{$quali->id}}">{{$quali->name}}</option>
                                      @endforeach
                                    @endif  
                                 </select>
                               </td>
                             </tr>
                             <tr>
                               <th>Total Experience<sup class="ast">*</sup></th>
                               <td>
                                  <input type="number" name="total_experience" id="" class="form-control basic-detail-input-style" placeholder="Enter Total Experience" maxlength="2">
                               </td>
                             </tr>
                             <tr>
                               <th>Relevant Experience</th>
                               <td>
                                  <input type="number" name="relevant_experience" id="" class="form-control basic-detail-input-style" placeholder="Enter Relevant Experience" maxlength="2">

                               </td>
                             </tr>
                             <tr>
                               <th>Key Skills</th>
                               <td>
                                 <select name="skill_id[]" id="skill_id" class="form-control basic-detail-input-style select2" multiple="multiple" data-placeholder="Select Your Skills">
                                    @if(!$data['skills']->isEmpty())
                                     @foreach($data['skills'] as $skill)  
                                       <option value="{{$skill->id}}">{{$skill->name}}</option>
                                     @endforeach
                                   @endif  
                                 </select>
                               </td>
                             </tr>
                             <tr>
                               <th>Current Designation</th>
                               <td>
                                 <input type="text" name="current_designation" id="" class="form-control basic-detail-input-style" placeholder="Enter current designation">
                               </td>
                             </tr>
                             
                             <tr>
                               <th>Current Annual CTC (INR Lakhs)<sup class="ast">*</sup></th>
                               <td>
                                 <input type="number" name="current_ctc" id="" class="form-control basic-detail-input-style" placeholder="Enter current CTC">
                               </td>
                             </tr>

                             <tr>
                               <th>Current Annual CIH (INR Lakhs)</th>
                               <td>
                                 <input type="number" name="current_cih" id="" class="form-control basic-detail-input-style" placeholder="Enter current CIH">
                               </td>
                             </tr>

                             <tr>
                               <th>Expected CTC (INR Lakhs)</th>
                               <td>
                                 <input type="number" name="exp_ctc" id="" class="form-control basic-detail-input-style" placeholder="Enter Expected CTC">
                               </td>
                             </tr>
                              
                            <tr>
                               <th>Interview date<sup class="ast">*</sup></th>
                               <td>
                                  <input type="text" class="form-control datepicker" name="interview_date" placeholder="02/03/2020" id="interview_date" autocomplete="off">
                               </td>
                             </tr>

                             <tr>
                               <th>Interview time</th>
                               <td>
                                 <input type="text" class="form-control pull-right timepicker" id="interview_time" name="interview_time" placeholder="Select Interview Date" readonly="">
                               </td>
                             </tr>

                             <tr>
                               <th>Languages</th>
                               <td>
                                 <div class="add-language-box">
                                    <div class="row">
                                       <div class="col-sm-12">
                                          <select name="languageIds[]"  id="languageIds" class="form-control basic-detail-input-style select2" multiple="multiple" style="width: 100%;" data-placeholder="Select languages">
                                          @if(!$data['languages']->isEmpty())
                                          @foreach($data['languages'] as $language) 
                                          <option value="{{$language->id}}">{{$language->name}}</option>
                                          @endforeach
                                          @endif  
                                          </select>
                                       </div>
                                       <div class="languageCheckboxess"></div>
                                    </div>
                                 </div>
                               </td>
                             </tr>
                             <tr>
                               <th>Commitment for 1 Year</th>
                               <td>
                                 <input type="text" name="contract" id="contract" class="form-control basic-detail-input-style" placeholder="Enter contract detail">
                               </td>
                             </tr>
                             <tr>
                               <th>Current Company profile</th>
                               <td>
                                 <input type="text" name="current_company_profile" id="" class="form-control basic-detail-input-style" placeholder="Enter Current Comapny Profile">
                               </td>
                             </tr>
                             <tr>
                               <th>Photograph</th>
                               <td>
                                    <input type="file" name="image" id="image" placeholder="Select photograph">
                                    <div class="box-body box-profile" accept="image/*" onchange="loadFile(event)">
                                    <img class="profile-user-img img-responsive candidate_picture" src="" alt="User profile picture" id="candidate_picture" style="display: none">
                                    </div>
                               </td>
                             </tr>

                            <tr>
                               <th>Resume<sup class="ast">*</sup></th>
                               <td>
                                    <input type="file" name="image_resume" id="image_resume" placeholder="Select Resume">
                                    <div class="box-body box-profile" accept="image/*" onchange="loadFile(event)">
                                    <img class="profile-user-img img-responsive candidate_picture" src="" alt="User profile picture" id="candidate_picture" style="display: none">
                                    </div>
                               </td>
                            </tr>

                             <tr>
                               <th>Reason for Job Change</th>
                               <td>
                                 <textarea rows="4" cols="50" class="form-control" id="reason_for_job_change" name="reason_for_job_change" placeholder="Enter your job change reason here"></textarea>
                               </td>
                             </tr>
                             <tr>
                               <th>Has personal Laptop<br>(Yes/ No)</th>
                               <td>
                                 <input type="radio" name="personal_laptop" id="personal_laptop_yes" value="Yes">
                                 <label for="personal_laptop_yes">Yes</label>&nbsp;&nbsp;
                                 <input type="radio" name="personal_laptop" id="personal_laptop_no" value="No">
                                 <label for="personal_laptop_no">No</label>
                               </td>
                             </tr>
                             <tr>
                               <th>Can Travel within the<br> region & to HO</th>
                               <td>
                                 <input type="radio" name="travel" id="can_travel_yes" value="Yes">
                                 <label for="can_travel_yes">Yes</label>&nbsp;&nbsp;
                                 <input type="radio" name="travel" id="can_travel_no" value="No">
                                 <label for="can_travel_no">No</label>
                               </td>
                             </tr>                             
                             <tr>
                               <th>Notice Period<sup class="ast">*</sup></th>
                               <td>
                                 <input type="radio" class="notice-period-only" name="notice_period" id="notice_period_yes" value="Yes">
                                 <label for="notice_period_yes">Yes</label>&nbsp;&nbsp;
                                 <input type="radio" class="notice-period-only" name="notice_period" id="notice_period_no" value="No">
                                 <label for="notice_period_no">No</label>
                                 <select name="notice_period_duration" class="form-control basic-detail-input-style notice_period_field" style="display: none">
                                    <option value="" selected disabled>Select Notice Period</option>
                                    <option value="7 Days">7 Days</option>
                                    <option value="15 Days">15 Days</option>
                                    <option value="30 Days">30 Days</option>
                                    <option value="45 Days">45 Days</option>
                                    <option value="60 Days">60 Days</option>
                                    <option value="90 Days">90 Days</option>
                                 </select>
                               </td>
                             </tr>

                             <tr>
                               <th>Interview Type</th>
                                 <td>
                                   <select class="form-control basic-detail-input-style regis-input-field" name="interview_type" id="interview_type">
                                    <option selected="" value="">Please Select interview type</option>
                                    <option value="The Face-to-Face Interview">The Face-to-Face Interview</option>
                                    <option value="The Panel Interview">The Panel Interview</option>
                                    <option value="The Telephone Interview">The Telephone Interview</option>
                                    <option value="The Group Interview">The Group Interview</option>
                                    <option value="The Sequential Interview">The Sequential Interview</option>
                                    <option value="The Skype Interview">The Skype Interview</option>
                                    <option value="The Video Interview">The Video Interview</option>
                                    <option value="The Machine test interview">The Machine test interview</option>
                                    <option value="Competency Based Interviews">Competency Based Interviews</option>
                                    <option value="Formal/Informal Interviews">Formal / Informal Interviews</option>
                                    <option value="Portfolio Based Interviews">Portfolio Based Interviews</option>
                                    <option value="Introductory Video Assessment">Introductory Video Assessment</option>
                                    
                                  </select>
                                </td>

                             <tr>
                                <th>Level 1 Status<sup class="ast">*</sup></th>
                                 <td>
                                    <input type="radio" name="final_status" id="backoff" value="Backoff" class="final_status">
                                    <label for="rejected">Backed off</label>&nbsp;&nbsp;
                                    <input type="radio" name="final_status" id="rejected" value="Rejected" class="final_status">
                                    <label for="rejected">Not Shortlisted</label>&nbsp;&nbsp;
                                    <input type="radio" name="final_status" id="On-hold" value="On-hold" class="final_status">
                                    <label for="On-hold">On hold</label>&nbsp;&nbsp;
                                    <input type="radio" name="final_status" id="shortlisted" value="Shortlisted" class="final_status">
                                    <label for="shortlisted">Shortlisted</label>&nbsp;&nbsp;
                                    <input type="radio" name="final_status" id="level_2_interview" value="Recommended-Level-2-interview" class="final_status">
                                    <label for="level_2_interview">Level-2 interview</label>
                                 </td>
                             </tr>

                             <!-- new test -->
                              <tr class="hide_backoff" style="display: none;" >
                                <th>Backed off Reason</th>
                                  <td>
                                      <div class="form-group">
                                        <select class="form-control basic-detail-input-style regis-input-field" name="backoff_reason" id="backoff_reason">
                                        <option selected="" value="">Please Select Backoff Reason</option>
                                        <option value="6 day working">6 day working</option>
                                        <option value="Salary hike">Salary hike</option>
                                        <option value="Internal policies">Internal policies</option>
                                        <option value="other_backout_reason">Other Reason</option>
                                        </select>
                                      </div>
                                  </td>
                              </tr>

                              <tr class="hide_rejected" style="display: none;">
                                <th>Rejected Reason</th>
                                  <td>
                                    <div class="form-group">
                                      <select class="form-control basic-detail-input-style regis-input-field" name="rejected_reason" id="rejected_reason">
                                      <option selected="" value="">Please Select Rejected Reason</option>
                                      <option value="Salary hike too much">Salary hike too much</option>
                                      <option value="2 Month Notice period">2 Month Notice period</option>
                                      <option value="3 Month Notice period">3 Month Notice period</option>
                                      <option value="Bad Communication skils">Bad Communication skils</option>
                                      <option value="Technically not fit our criteria">Technically not fit our criteria</option>
                                      <option value="other_rejection_reason">Other Reason</option>
                                      </select>
                                    </div>
                                  </td>
                              </tr>
                             <!-- end test -->

                             <tr id="other_backoff_reason" style="display: none;">
                                <th>Other Backoff reason</th>
                                <td><input type="text" name="other_backoff_reason" class="form-control other_backoff_reason"  placeholder="Enter Back off reason"></td>
                             </tr>

                             <tr id="other_rejected_reason" style="display: none;">
                               <th>Other Rejected Reason</th>
                               <td>
                                 <input type="text" name="other_rejected_reason" class="form-control other_rejected_reason"  placeholder="Enter Other Reason">
                               </td>
                             </tr>

                             <!-- start interviewer detail -->

                              <tr>
                               <th>Interviewer Department</th>
                               <td>
                                 <select class="form-control basic-detail-input-style regis-input-field" name="interviewer_department" id="interviewer_department">
                                  @if(!$data['departments']->isEmpty())
                                  @foreach($data['departments'] as $department)
                                  <option value="{{$department->id}}">{{$department->name}}</option>
                                  @endforeach
                                  @endif
                                </select>
                               </td>
                             </tr>
                             <tr>
                              <th>Interviewer Name</th>
                                <td>
                                  <select class="form-control basic-detail-input-style regis-input-field" name="interviewer_employee" id="interviewer_employee"></select>
                                </td>
                             </tr>

                             <!-- end of interviewer detail -->
                           </table>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- /.box-body -->
               <div class="box-footer text-center">
               <input type="submit" class="btn btn-primary submit-btn-style" id="submit2" value="Save Candidate" name="submit">
               </div>
            </form>

            <!-- Detail of Interview scheduled -->
            <div class="recruitment-box">
              <div class="recruitment-heading">
                <h2 class="text-center">Interviewer Details</h2>
              </div>
              <h3 class="text-center"><b>Latest Interview Schedule List:</b></h3>
                <!-- NEW Table Start -->
                <table id="example" class="table table-striped table-bordered" style="width:100%">
                  <thead>
                    <tr>
                      <th>S&nbsp;No</th>
                      <th>Candidate&nbsp;Name</th>
                      <th>Current&nbsp;Designation</th>
                      <th>Interview&nbsp;Date</th>
                      <th>Interview&nbsp;Time</th>
                      <th>Interviewer&nbsp;Name</th>
                      <th>Candidate&nbsp;Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  @php $counter = 1; @endphp
                  <tbody>
                    @if(!(@$data['interviewer_details'])->isEmpty())
                      @foreach(@$data['interviewer_details'] as $inter_detail)
                        <tr>
                            <td>{{@$counter++ }}</td>
                            <td>{{@$inter_detail->name}}</td>
                            <td>{{@$inter_detail->current_designation}}</td>
                            <td>{{@$inter_detail->interview_date}}</td>
                            <td>{{@$inter_detail->interview_time}}</td>
                            <td>{{@$inter_detail->fullname}}</td>
                            <td>{{@$inter_detail->candidate_status}}</td>
                            <td>&nbsp;
                            <a class="glyphicon glyphicon-edit" target="_blank" href='{{url("jrf/edit-candidate-level-one-screening-detail/$inter_detail->id")}}'></a>
                            &nbsp;&nbsp;&nbsp;<a class="glyphicon glyphicon-eye-open" target="_blank" href='{{url("jrf/candidate-level-one-screening-detail/$inter_detail->id")}}'></a>
                            </td>
                        </tr>
                       @endforeach
                    @endif
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>S&nbsp;No</th>
                        <th>Candidate&nbsp;Name</th>
                        <th>Current&nbsp;Designation</th>
                        <th>Interview&nbsp;Date</th>
                        <th>Interview&nbsp;Time</th>
                        <th>Interviewer&nbsp;Name</th>
                        <th>Candidate&nbsp;Status</th>
                        <th>Action</th>
                    </tr>
                    </tfoot>
                </table>
                <!-- END new table -->
            </div>
            <!-- end of derail -->
          </div>
        </div><!-- /.box -->
      </div><!-- /.row -->
    </section><!-- /.content -->
  </div><!-- /.content-wrapper -->


<script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>


<script>
$("#jrfscreeningform").validate({
  rules: {
   "interview_date" : {
     required: true
   },
    "name" : {
      required: true
    },
    "contact" : {
      required: true
    },
   
    "city_id" : {
      required: true
    },
    
    "qualification_id[]" : {
      required: true
    },
    "total_experience" : {
      required: true
    },
   
    "current_ctc" : {
      required: true
    },
    "notice_period" : {
      required : true
    },
    "final_status" : {
      required : true
    },
   
    "image_resume" :{
      required : true
    },
    
    "languageIds[]" : {
      required : true
    }
  },
  messages: {
   "interview_date" : {
     required: 'Please select Interview Date'
   },
    "name" : {
      required: 'Please Enter your name'
    },
    "contact" : {
      required: 'Please Enter your contact number'
   },
    
    "city_id" : {
      required: 'Enter your Current Location'
    },
   
    "qualification_id[]" : {
      required: 'Enter Qualification'
    },
    "total_experience" : {
      required: 'Enter Year Experience'
    },
    
    "current_ctc" : {
      required: 'Enter your CTC'
    },
    
    "notice_period" : {
      required : 'Select Yes or No'
    },
    "final_status" : {
      required : 'Select final Status'
    },
    
    "image_resume" :{
      required : 'Select Resume'
    },

    "languageIds[]" : {
      required : 'Please select Language'
    }

  }
});
</script>

<script>
$(document).ready(function(){
   /*To Show notice period text field starts here*/
   $(".notice-period-only").on('click',function(){
      var np_value = $(this).val();
      if(np_value == "Yes") {
         $(".notice_period_field").show();
      }
      else {
         $(".notice_period_field").hide();
      }
   });
   /*To Show notice period text field ends here*/
});
</script>

<script type="text/javascript">
   //On change
    $("#languageIds.select2").on('change',function(){
      var arr = $(this).val();
      length = arr.length; 
      var display = '';
      for(var i=0; i < length; i++){
         var langName = $("#languageIds option[value='"+ arr[i] + "']").text();
         var checkBoxes = '<div class="row field-changes-below"><div class="col-sm-4"><strong class="basic-lang-label">'+langName+'</strong></div><div class="col-sm-8 langright"><label class="checkbox-inline"><input type="checkbox" value="1" name="lang'+arr[i]+'[]">Read</label><label class="checkbox-inline"><input type="checkbox" value="2" name="lang'+arr[i]+'[]">Write</label><label class="checkbox-inline"><input type="checkbox" value="3" name="lang'+arr[i]+'[]">Speak</label></div></div>';
        display += checkBoxes;
      }
      $(".languageCheckboxess").html("");
      $(".languageCheckboxess").append(display);
    });

     /*Reason dropdown scripts starts here*/
      $('.final_status').on('click',function(){
        var final_status = $(this).val();

          if(final_status == "Backoff"){
            $(".hide_backoff").show();
            $(".hide_rejected").hide();
            $("#backoff_reason").on('change', function(){
              if($(this).val() == "other_backout_reason") {
                  $("#other_backoff_reason").show();
                  $(".other_rejected_reason").show();
                }else{
                  $("#other_backoff_reason").hide();
              }    
            });
          }else if(final_status == "Rejected"){
            $(".hide_backoff").hide();
            $(".hide_rejected").show();
              $("#rejected_reason").on('change', function(){
                if ($(this).val() == "other_rejection_reason") {
                  $("#other_rejected_reason").show();
                }else{
                  $("#other_rejected_reason").hide();
                }
              });
          }else if(final_status == "Rejected" || final_status == "On-hold" || final_status == "Recommended-Level-2-interview" || final_status == "Shortlisted"){
            $(".hide_backoff").hide();
            $(".hide_rejected").hide();
            $("#other_backoff_reason").hide();
            $("#other_rejected_reason").hide();
          }
      });

    $("#interview_time").timepicker({
      showInputs: false
    });


    //View More detail of candidate //
    $(".interviewer_status_detail").on('click',function(){
      var id = $(this).data("id");
      $.ajax({
        type: 'POST',
        url: "{{ url('jrf/interview-status-info') }}",
        data: {id: id},
          success: function (result) {
            $(".interviewer_status_detail_body").html(result);
            $('#interviewer_status_detail').modal('show');
          }
      });
    });

    // start dependent department wise employees
      var userId = "{{@$auth_id}}";
      // $('#recruitment_department_id').on('change', function(){
      // var department = $(this).val();
      // var displayString = "";
      // $("#recruitment_interviewer_employee_id").empty();
      // var departments = [];
      // departments.push(department);
      //   $.ajax({
      //     type: "POST",
      //     url: "{{url('employees/departments-wise-employees')}}",
      //     data: {department_ids: departments},
      //     success: function(result){
      //         if(result.length == 0 || (result.length == 1 && result[0].user_id == userId)){
      //           displayString += '<option value="" disabled>None</option>';
      //         }else{
      //           result.forEach(function(employee){
      //             if(employee.user_id != userId && employee.user_id != 1){
      //               displayString += '<option value="'+employee.user_id+'">'+employee.fullname+'</option>';
      //             }
      //           });
      //         }
      //         $('#recruitment_interviewer_employee_id').append(displayString);
      //     }
      //   });
      // }).change();
    // end 

    // for interviewer
    $('#interviewer_department').on('change', function(){
      var inter_department = $(this).val();
      var displayString = "";
      $("#interviewer_employee").empty();
      var inter_departments = [];
      inter_departments.push(inter_department);
      $.ajax({
        type: "POST",
        url: "{{url('employees/departments-wise-employees')}}",
        data: {department_ids: inter_departments},
        success: function(result){
          if(result.length == 0 || (result.length == 1 && result[0].user_id == userId)){
            displayString += '<option value="" disabled>None</option>';
          }else{
            result.forEach(function(employee){
              if(employee.user_id != 1){
                displayString += '<option value="'+employee.user_id+'">'+employee.fullname+'</option>';
              }
            });
          }
          $('#interviewer_employee').append(displayString);
        }
      });
    }).change();
    // end

    function loadFile(input) {
       if (input.files && input.files[0]) {
         var reader = new FileReader();
         reader.onload = function(e) {
           $('#candidate_picture').attr('src', e.target.result);
         }
         reader.readAsDataURL(input.files[0]);
       }
    }
    $("#image").change(function() {
       loadFile(this);
       $("#candidate_picture").show();
    });

    $(document).ready(function() {
      $('#example').DataTable( {
          dom: 'Bfrtip',
          buttons: [
              'copy', 'csv', 'excel', 'pdf', 'print'
          ]
      } );

     /* var dateToday = new Date();
      var last_date = "{{@$data['last_date']}}";
        $('.datepicker').datepicker({ //Date picker
          autoclose: true,
          orientation: "bottom",
          format: 'dd/mm/yyyy',
          startDate : dateToday,
          endDate : last_date
        }); 

        */
    });
  </script>
@endsection