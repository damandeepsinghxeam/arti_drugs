@extends('admins.layouts.app')
@section('content')
<style>
.recruitment-box {
    border: 1px solid #3c8dbc;
    border-radius: 8px;
    position: relative;
    margin: 20px 0 20px;
}
.recruitment-heading {
    position: absolute;
    left: 50%;
    background-color: #fff;
    top: 0;
    transform: translate(-50%, -50%);
    padding: 10px;
    border: 1px solid #3c8dbc;
    border-radius: 10px;
    color: #3c8dbc;
}
.recruitment-heading h2 {
    font-size: 16px;
    margin: 0px;
    font-weight: 700;
}
.recruitment-box .table {
    margin: 20px 0;
}
.plus-style {
    color: #3c8dbc;
}
.radio_btn_container {
    display: flex;
    justify-content: center;
}
.radio_btn_container span {
    margin: 10px;
}
.recruitment-box h3 {
    font-size: 14px;
    margin-top: 35px;
    text-decoration: underline;
}
.submit-btn-style {
    margin-bottom: 20px;
}

.close_jrf {
    float: right;
    margin-right: 20px;
    margin-top: 3px;
}
/*#status_check {
  background-color: #3c8dbc !important;
}*/
.schedule {
    border-top-style: hidden;
    border-right-style: hidden;
    border-left-style: hidden;
    background-color: #eee;
    align-content: center;
    width: 100%;
}
#customers {
  font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

#customers td, #customers th {
  border: 1px solid #ddd;
  padding: 8px;
}

#customers tr:nth-child(even){background-color: #f2f2f2;}

#customers tr:hover {background-color: #ddd;}

#customers th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #4CAF50;
  color: white;
}
.label.label-info.last_date_recruitment {
  float: right;
  margin: inherit;
}
</style>

<link rel="stylesheet" href="{{asset('public/admin_assets/plugins/timepicker/bootstrap-timepicker.min.css')}}">
<script src="{{asset('public/admin_assets/plugins/timepicker/bootstrap-timepicker.min.js')}}"></script>
<script src="{{asset('public/admin_assets/plugins/validations/jquery.validate.js')}}"></script>
<script src="{{asset('public/admin_assets/plugins/validations/additional-methods.js')}}"></script>
<script src="{{url('public/js/sweetalert.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css" />
<link rel="stylesheet" href="{{asset('public/admin_assets/plugins/dataTables/jquery.dataTables.min.css')}}">
<script src="{{asset('public/admin_assets/plugins/dataTables/jquery.dataTables.min.js')}}"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css"/>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>Job Requisition Form (JRF)</h1>
        <span class="label label-success" >Created on  {{date("Y-m-d",strtotime(@$data['detail']->created_at))}}</span>

          @if(@$data['detail']->final_status == 0 && @$data['approval_status']->jrf_status == '0')
          <span class="label label-success">In-Progress</span>

          @elseif(@$data['detail']->final_status == 1 && @$data['approval_status']->jrf_status == '3')
          <span class="label label-info">Closed {{date("Y-m-d",strtotime(@$data['detail']->close_jrf_date))}}</span>

          @elseif(@$data['detail']->final_status == 0  && @$data['approval_status']->jrf_status == '2')
          <span class="label label-danger">Rejected</span>
          @if(!empty(@$data['detail']->final_status == 2))
          <div class="">{{@$data['detail']->rejection_reason}}</div>
          @endif

          @elseif(@$data['detail']->final_status == 0 && @$data['approval_status']->jrf_status == '0' && @$data['detail']->isactive == '0')
          <span class="label label-warning">Cancelled</span>

          @elseif(@$data['detail']->final_status == 0 && @$data['approval_status']->jrf_status == '1')
          <span class="label label-warning">Assigned</span>
          @endif

          <ol class="breadcrumb">
          <li><a href="{{url('employees/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
          <li><a href="{{url('jrf/approve-jrf')}}">Approve List</a></li> 
          </ol>
        </section>

        @php $auth_id = Auth::id(); @endphp
        <!-- Main content -->
        <section class="content">
        <!-- Small boxes (Stat box) -->
          <div class="row">
            <div class="col-sm-12">
              <div class="box box-primary success">
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

              
              @if(session()->has('jrfError'))
                <div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  {{ session()->get('jrfError') }}
                </div>
              @endif


            <!-- form start -->
            @can('create-recruitment-task')
            <div class="callout callout-success" style="margin-bottom: 5px!important;">
              <h4><i class="fa fa-info"></i> Note:</h4>Please Add at least one recruiter before submit the form.
            <button><a href="{{url('/jrf/view-jrf/'.$data['detail']->id)}}">View</a></button></div>
            @endcan

            <form id="jrfRequisitionForm" action="{{ url('jrf/update-jrf') }}" method="POST" enctype="multipart/form-data">
              {{ csrf_field() }}
                <div class="box-body jrf-form-body fieldset" id="jrf_editable">
                  <div class="row">
                    <div class="col-md-6">


                   <!-- for Project JRF -->
                      <div class="form-group">
                        <div class="row">
                            <div class="col-md-4 label-left-sec">
                              <label for="type">Project Type<sup class="ast">*</sup></label>
                            </div>
                            <div class="col-md-8">
                              <select name="type" class="form-control experiencedata regis-input-field jrf_type_class" id="type" readonly>
                              <option value="Xeam">Internal-Hiring</option> 
                              <option value="Project">Project-Hiring</option>
                              </select>
                            </div>
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="row">
                          <div class="col-md-4 label-left-sec">
                             <label for="project_id">Project<sup class="ast">*</sup></label>
                          </div>
                          <div class="col-md-8">
                             <select class="form-control select2 input-sm basic-detail-input-style" name="project_id" style="width: 100%;" id="project_id" data-placeholder="Select Project" disabled>
                                <option value="">Please Select</option> 
                                  @foreach($data['project'] as $proj)  
                                    <option value="{{$proj->id}}" @if(in_array($proj->id,@$data['saved_project'])){{"selected"}} @else{{""}}@endif
                                    >{{$proj->name}}</option>
                                  @endforeach
                             </select>
                          </div>
                        </div>
                      </div>

                      <div class="project_jrf" style="display: none;">
                        <div class="form-group">
                           <div class="row">
                              <div class="col-md-4 label-left-sec">
                                 <label for="certification">Certification</label>
                              </div>
                              <div class="col-md-8">
                                 <input type="text" name="certification" class="form-control experiencedata regis-input-field" id="certification" value="{{@$data['detail']->certification}}" placeholder="Enter Certification"> 
                              </div>
                           </div>
                        </div>

                        <div class="form-group">
                           <div class="row">
                              <div class="col-md-4 label-left-sec">
                                 <label for="benefits_perks">Benefits Perks</label>
                              </div>
                              <div class="col-md-8">
                                <select class="form-control select2 input-sm basic-detail-input-style" name="benefits_perks[]" multiple="multiple" style="width: 100%;" id="benefits_perks" data-placeholder="Select Benefits Perks">
                                  @if(!$data['benifit_perk']->isEmpty())
                                    @foreach($data['benifit_perk'] as $benifits)  
                                      <option value="{{$benifits->id}}" @if(in_array($benifits->id,@$data['saved_benifit_perk'])){{"selected"}} @else{{""}}@endif
                                        >{{$benifits->name}}</option>
                                    @endforeach
                                  @endif  
                                </select>
                              </div> 
                           </div>
                        </div> 

                        <div class="form-group">
                           <div class="row">
                              <div class="col-md-4 label-left-sec">
                                 <label for="temp_or_perm">Model<sup class="ast">*</sup></label>
                              </div>
                              <div class="col-md-8">
                                <div class="radio">
                                  <label>
                                  <input type="radio" name="temp_or_perm" id="temp" value="temp" checked="">&nbsp;Temporary</label>&nbsp;&nbsp;&nbsp;
                                  <label>
                                  <input type="radio" name="temp_or_perm" id="perm" value="perm">&nbsp;Permanent
                                  </label>
                                </div>
                              </div>
                           </div>
                        </div>

                        <div class="form-group">
                           <div class="row">
                              <div class="col-md-4 label-left-sec">
                                 <label for="service_charges_fee">Service Charges Fee<sup class="ast">*</sup></label>
                              </div>
                              <div class="col-md-8">
                                  <input type="text" name="service_charges_fee" class="form-control experiencedata regis-input-field" id="service_charges_fee" placeholder="Enter Service Charges Fee" value="{{@$data['detail']->service_charges_fee}}"> 
                              </div>
                           </div>
                        </div>
                    </div>

                      <div class="form-group">
                        <div class="row">
                          <div class="col-md-4 label-left-sec">
                            <label for="jrf_department">Interviewer's Department<sup class="ast">*</sup></label>
                          </div>
                          <div class="col-md-8">
                            <select class="form-control basic-detail-input-style regis-input-field" name="department_id" id="jrf_department" disabled>
                            @if(!$data['departments']->isEmpty())
                            @foreach($data['departments'] as $department)
                            <option value="{{$department->id}}">{{$department->name}}</option>
                            @endforeach
                            @endif
                            </select>
                            @php $user_id = Auth::id(); @endphp
                            <input type="hidden" name="jrf_id" value="{{@$data['detail']->id}}">
                          </div>
                        </div>

                        <br>

                        <div class="row">
                          <div class="col-md-4 label-left-sec">
                             <label for="jrf_department">Interviewer's Name<sup class="ast">*</sup></label>
                          </div>
                          <div class="col-md-8">
                            <input type="text" name="approver_id" id="approver_id" class="form-control" value="{{@$data['get_static_interviewr_name']->fullname}}" disabled>
                          </div>
                       </div>

                        <!--<div class="row">
                          <div class="col-md-4 label-left-sec">
                             <label for="jrf_department">Interviewer's Name<sup class="ast">*</sup></label>
                          </div>
                          <div class="col-md-8">
                            <select class="form-control basic-detail-input-style input-sm" name="approver_id" id="approver_id"></select>
                          </div>
                       </div> -->
                      </div>

                      <div class="form-group">
                        <div class="row">
                          <div class="col-md-4 label-left-sec">
                            <label for="role_id">Candidate's Job Role<sup class="ast">*</sup></label>
                          </div>
                          <div class="col-md-8">
                            <select class="form-control select2 input-sm basic-detail-input-style" name="role_id" style="width: 100%;" id="role_id" disabled>
                              @if(!$data['roles']->isEmpty())
                                @foreach($data['roles'] as $role)  
                                  <option value="{{$role->id}}" @if(in_array($role->id,@$data['saved_role'])){{"selected"}} @else{{""}}@endif
                                    >{{$role->name}}</option>
                                @endforeach
                              @endif  
                            </select>
                          </div>
                        </div>   
                      </div>

                      <div class="form-group">
                        <div class="row">
                            <div class="col-md-4 label-left-sec">
                              <label for="designation_id">Candidate's Designation<sup class="ast">*</sup></label>
                            </div>
                            <div class="col-md-8">

                              <select class="form-control select2 input-sm basic-detail-input-style" name="designation_id" style="width: 100%;" id="designation_id_ra">
                              @if(!$data['designation']->isEmpty())
                                @foreach($data['designation'] as $desig)  
                                  <option value="{{$desig->id}}" @if(in_array($desig->id,@$data['saved_designation'])){{"selected"}} @else{{""}}@endif
                                    >{{$desig->name}}</option>
                                @endforeach
                              @endif  
                            </select>
                            </div>
                        </div>   
                      </div>

                      <div class="form-group">
                        <div class="row">
                          <div class="col-md-4 label-left-sec">
                            <label for="number_of_positions">Number of Positions<sup class="ast">*</sup>
                            </label>
                          </div>
                          <div class="col-md-8">
                            <input type="text" name="number_of_positions" id="number_of_positions" placeholder="Number of positions" class="form-control experiencedata regis-input-field only_numeric" value="{{@$data['detail']->number_of_positions}}">
                          </div>
                        </div>   
                      </div>

                      <div class="form-group">
                        <div class="row">
                          <div class="col-md-4 label-left-sec">
                            <label for="">Age Group( in years )</label>
                          </div>
                          <div class="col-md-8">
                              <div class="row">
                                <div class="col-xs-6">
                                  <input type="text" name="age_group_from" id="age_group_from" placeholder="Min" class="form-control experiencedata regis-input-field only_numeric">
                                </div>
                                <div class="col-xs-6">
                                  <input type="text" name="age_group_to" id="age_group_to" placeholder="Max" class="form-control experiencedata regis-input-field only_numeric">
                                </div>
                              </div>
                          </div> 
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="row">
                            <div class="col-md-4 label-left-sec">
                              <label for="gender">Gender<sup class="ast">*</sup></label>
                            </div>
                            <div class="col-md-8">
                              <div class="radio">
                                <label><input type="radio" name="gender" id="male" value="Male" checked="">Male</label>
                                <label><input type="radio" name="gender" id="female" value="Female">Female</label>
                                <label>
                                <input type="radio" name="gender" id="any_of_them" class="radio-s-label" value="Any Of Them"> Any Of Them
                                </label> 
                                
                                
                              </div>
                            </div>
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="row">
                          <div class="col-md-4 label-left-sec">
                            <label for="job_location">Job Location<sup class="ast">*</sup></label>
                          </div>
                          <div class="col-md-8">
                            <select class="form-control select2 input-sm basic-detail-input-style" name="city_id[]" multiple="multiple" style="width: 100%;" id="city_id" data-placeholder="Select Location">
                              @if(!$data['cities']->isEmpty())
                                @foreach($data['cities'] as $citi)  
                                  <option value="{{$citi->id}}" @if(in_array($citi->id,@$data['saved_location'])){{"selected"}} @else{{""}}@endif
                                    >{{$citi->name}}</option>
                                @endforeach
                              @endif  
                            </select>
                          </div>
                        </div>    
                      </div>

                      <div class="form-group">
                        <div class="row">
                          <div class="col-md-4 label-left-sec">
                            <label for="">Shift Timing</label>
                          </div>

                          <div class="col-md-8">
                            <div class="row">
                                <div class="col-xs-6">
                                    <input type="text" name="shift_timing_from" id="shift_timing_from" placeholder="From" class="form-control" value="{{ @$data['detail']->shift_timing_from }}">
                                </div>
                                <div class="col-xs-6">
                                    <input type="text" name="shift_timing_to" id="shift_timing_to" placeholder="To" class="form-control" value="{{ @$data['detail']->shift_timing_to }}">
                                </div>
                            </div>
                          </div>
                        </div>
                      </div>

                  </div>

                 <div class="col-md-6">


                      <div class="form-group">
                        <div class="row">
                          <div class="col-md-4 label-left-sec">
                              <label for="Job_description">Job Description<sup class="ast">*</sup></label>
                          </div>
                          <div class="col-md-8">
                              <textarea rows="4" cols="50" class="form-control" id="Job_description" name="job_description" placeholder="Brief Description of Duties">{{ @$data['detail']->description}}</textarea>
                          </div>
                        </div>
                      </div>

                    <div class="form-group">
                      <div class="row">
                          <div class="col-md-4 label-left-sec">
                              <label for="qualification_id">Qualifications<sup class="ast">*</sup></label>
                          </div>
                          <div class="col-md-8">
                            <select class="form-control select2 input-sm basic-detail-input-style" name="qualification_id[]" multiple="multiple" style="width: 100%;" id="qualification_id" data-placeholder="Select Qualifications">
                              @if(!$data['qualifications']->isEmpty())
                                @foreach($data['qualifications'] as $quali)  
                                  <option value="{{$quali->id}}" @if(in_array($quali->id,@$data['saved_qualification'])){{"selected"}} @else{{""}} @endif>{{$quali->name}}</option>
                                @endforeach
                              @endif  
                            </select>
                          </div> 
                      </div>
                    </div>

                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-4 label-left-sec">
                          <label for="skill_id">Skills<sup class="ast">*</sup></label>
                      </div>
                      <div class="col-md-8">
                        <select class="form-control select2 input-sm basic-detail-input-style" name="skill_id[]" multiple="multiple" style="width: 100%;" id="skill_id" data-placeholder="Select Skills">
                          @if(!$data['skills']->isEmpty())
                            @foreach($data['skills'] as $skill)  
                              <option value="{{$skill->id}}" @if(in_array($skill->id,@$data['saved_skills'])){{"selected"}} @else{{""}}@endif
                                >{{$skill->name}}</option>
                            @endforeach
                          @endif  
                        </select>
                      </div> 
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-4 label-left-sec">
                          <label for="jrf_additional_requirement">Additional Requirement</label>
                      </div>
                      <div class="col-md-8">
                        <input type="text" name="additional_requirement" id="jrf_additional_requirement" placeholder="Please enter Qualifications" class="form-control experiencedata regis-input-field" value="{{ @$data['detail']->additional_requirement }}">
                      </div> 
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-4 label-left-sec">
                          <label for="salary_range">Salary Range(Annual)<sup class="ast">*</sup></label>
                      </div>
                      <div class="col-md-8">
                        <div class="row">
                          <div class="col-xs-6">
                            <input type="text" name="salary_range_from" id="salary_range_from" placeholder="Min" class="form-control experiencedata regis-input-field salary_range_class only_numeric">
                          </div>
                          <div class="col-xs-6">
                            <input type="text" name="salary_range_to" id="salary_range_to" placeholder="Max" class="form-control experiencedata regis-input-field salary_range_class only_numeric">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-4 label-left-sec">
                          <label for="salary_range">Relevant Experience( in years )</label>
                      </div>
                      <div class="col-md-8">
                        <div class="row">
                          <div class="col-xs-6">
                            <input type="text" name="year_experience_from" id="year_experience_from" placeholder="Min" class="form-control experiencedata regis-input-field year_experience_class only_numeric">
                          </div>
                          <div class="col-xs-6">
                            <input type="text" name="year_experience_to" id="year_experience_to" placeholder="Max" class="form-control experiencedata regis-input-field year_experience_class only_numeric">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="row">
                        <div class="col-md-4 label-left-sec">
                          <label for="jrf_industry_type">Name of Industry<sup class="ast">*</sup></label>
                        </div>
                        <div class="col-md-8">
                          <input type="text" class="form-control experiencedata regis-input-field" name="industry_type" id="jrf_industry_type" value="{{@$data['detail']->industry_type}}">
                        </div> 
                    </div>
                  </div>

                  <div class="form-group">
                      <div class="row">
                          <div class="col-md-4 label-left-sec">
                            <label for="jrf_industry_type">Job Posting Required<sup class="ast">*</sup></label>
                          </div>
                          <div class="col-md-8">
                            <div class="radio">
                              <label><input type="radio" name="job_posting_other_website" id="optionsRadios3" value="Yes" checked="" class="job_posting" disabled>&nbsp;Yes</label>&nbsp;&nbsp;&nbsp;
                              <label><input type="radio" name="job_posting_other_website" id="optionsRadios4" value="No" class="job_posting" disabled>&nbsp;No
                              </label>
                            </div>
                          </div>
                      </div>
                  </div>


                  <div class="form-group">
                       <div class="row">
                          <div class="col-md-4 label-left-sec">
                             <label for="number_of_positions">JRF Closure Timeline<sup class="ast">*</sup></label>
                          </div>
                          <div class="col-md-8">
                             <input type="text" name="closure_timeline" id="closure_timeline" class="form-control" value="{{@$data['detail']->jrf_closure_timeline}}" readonly="readonly">
                          </div>
                       </div>
                    </div>

                    <!-- end of Project JRF -->
                </div>
            </div>
            @if($data['app'][0]->jrf_status == '0')
            <div class="text-center">
              <input type="submit" class="btn btn-info submit-btn-style" id="submit"  value="Edit & Update" name="submit">
            </div>
            @endif
          </div>
        </form>


        @if($data['app'][0]->jrf_status == '1' && $data['app'][1]->supervisor_id == $user->id)

          <!-- for recruiter -->
          @can('create-recruitment-task')
          <form id="recruitment_task_form_id" action="{{ url('jrf/save-recruitment-tasks') }}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="box-body jrf-form-body">
              <!--Recruitment Task Assigned Starts here-->
              <div class="recruitment-box">
                <div class="recruitment-heading">
                   <h2 class="text-center">Recruitment Task Assigned to</h2>
                </div>
                <h3 class="text-center"><b>Latest Recruitment Task Assigned List:</b></h3>
                <table class="table table-striped table-responsive table-bordered data_table">
                  <thead>
                   <tr>
                     <th>S No.</th>
                     <th>Department</th>
                     <th>Recruiter Name</th>
                     <th>Unassigned Recruiter</th>
 
                   </tr>
                  </thead>

                  @php $counter = 1; @endphp
                  <tbody>
                    @if(!(@$data['recruitment_task'])->isEmpty())
                      @foreach($data['recruitment_task'] as $task)
                       <tr>
                           <td>{{$counter++}}</td>
                           <td>{{@$task->name}}</td>
                           <td>{{@$task->fullname}}</td>

                           <td>
                            @if($task->is_assigned == '0')
                            <a class="btn btn-xs bg-blue unassignBtn" href='{{ url("jrf/edit-jrf/unassigned/")."/".$task->id}}' title="approve"><i class="fa fa-check" aria-hidden="true"></i></a>
                            @else
                            <span class="label label-success">{{"Unassigned"}} </span>
                            @endif
                          </td>
                       </tr>
                      @endforeach
                    @endif
                  </tbody>
                 </table>
                <hr>
               <h3 class="text-center"><b>Add New Assignee for this Task:</b></h3>
                  <table class="table table-striped table-responsive fieldset">
                      <thead>
                      <tr>
                          <th class="text-center">Department</th>
                          <th class="text-center">Recruiter Name</th>
                      </tr>
                      </thead>
                      <tbody class="customfield">
                      <tr>
                          <td>
                            <select class="form-control basic-detail-input-style regis-input-field" name="recruitment_department" id="recruitment_department_id">
                              <option value="{{ $data['tt']->id}}">{{ $data['tt']->name}}</option>
                            </select>
                          </td>
                          <td>
                          <select class="form-control basic-detail-input-style regis-input-field" name="recruitment_interviewer_employee" id="recruitment_interviewer_employee_id"></select>
                          </td>
                                                   
                            <input type="hidden" name="jrf_hidden_id" value="{{@$data['detail']->id}}">
                            <input type="hidden" name="assigned_by" value="{{@$auth_id}}">
                            <input type="hidden" name="arf_id" value="{{@$data['arf']->id}}">
                             
                        </tr>
                      </tbody>
                      </table>
                        <!--Recruitment Task Assigned Ends hered-->
                      <div class="text-center">
                        <input type="submit" class="btn btn-info submit-btn-style" id="submit3" value="Submit & Assign" name="submit">
                      </div>
                  </div>
                </div>
              </form>
              @endcan

              @endif
            <!--  end of recruiter -->
          </div>
        </div><!-- /.box-body -->
      </div>
  </section>
</div>

<!-- /.content-wrapper -->
<script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>

<script type="text/javascript">
  $("#type").click(function () {
     var type = $(this).val();
     if(type == 'Project'){
      $(".project_jrf").show();
     } else {
       $(".project_jrf").hide();
     }
  });
</script>

<script type="text/javascript">
  var jrf_type_status = "{{$data['detail']->type}}";
  $("#type").val(jrf_type_status);
  
  if(jrf_type_status == "Xeam"){
    $(".project_jrf").hide();
  }else if(jrf_type_status == "Project"){
    $(".project_jrf").show();
  }
  var perks = "{{$data['detail']->benefits_perks}}";
  $("#benefits_perks").val(perks);
</script>

    <script>
      $(function () {
          var dateToday = new Date();
          var last_date = "{{@$data['last_date']}}";
          $('.datepicker').datepicker({ //Date picker
            autoclose: true,
            orientation: "bottom",
            format: 'dd/mm/yyyy',
            startDate : dateToday
          });

          $('#interview_date').datepicker({ //Date picker
            autoclose: true,
            orientation: "bottom",
            format: 'dd/mm/yyyy',
            startDate : dateToday,
            endDate   : last_date
          });
      });


      var job_posting = "{{@$data['detail']->job_posting_other_website}}";
      if(job_posting == 'Yes'){
        $("#optionsRadios3").prop("checked", true);
      }else{
        $("#optionsRadios4").prop("checked", true);
      }


      $("#jrfRequisitionForm").validate({
      rules: {
        "jrf_department" : {
          required: true
        },
        "role_id" : {
          required: true
        },
        "number_of_positions" : {
          required: true
        },
       
        "gender" : {
          required: true
        },
        "city_id[]" : {
          required: true
        },
        "gender" : {
          required: true
        },
        
        "job_description" : {
          required: true
        },
        "qualification_id[]" : {
          required: true
        },
        "skill_id[]" : {
          required: true
        },
        "salary_range_from" : {
          required: true
        },
        "salary_range_to" : {
          required: true,
           greaterThan: '#salary_range_from'
        },
       
        "type" : {
          required: true
        },

        "temp_or_perm" : {
          required: true
        },
      
        "service_charges_fee" : {
          required: true,
          noSpace: true
        },
        "industry_type" : {
          required: true
        }
      },
      messages: {
          "jrf_department" : {
            required: 'Select department name'
          },
          "role_id" : {
            required: 'Select Role'
          },
          "number_of_positions" : {
            required: 'Enter number of Positions'
          },
         
          "gender" : {
            required: 'Select Gender'
          },
          "city_id[]" : {
            required: 'Select Job Location'
          },
          
          "job_description" : {
            required: 'Job Description'
          },
          "qualification_id[]" : {
            required: 'Select Qualification'
          },
          "skill_id[]" : {
            required: 'Select Skill'
          },
          "salary_range_from" : {
            required: 'Salary Range From'
          },
          "salary_range_to" : {
            required: 'Salary Range To'
          },
          
          "type" : {
            required: 'Select JRF Type'
          },
       
          "temp_or_perm" : {
            required: 'Enter Temp or Perm'
          },
          "service_charges_fee" : {
            required: 'Enter Service Charges Fee'
          },
          "industry_type" : {
            required: 'Enter Industry Type'
          },
        }
      });

      $.validator.addMethod("greaterThan",function (value, element, param) {
        var $min = $(param);
        if (this.settings.onfocusout) {
          $min.off(".validate-greaterThan").on("blur.validate-greaterThan", function () {
            $(element).valid();
          });
        }
        return parseInt(value) >= parseInt($min.val());
      }, "Max must be greater than min");

      // No space Method

      jQuery.validator.addMethod("noSpace", function(value, element) { 
        return value == '' || value.trim().length != 0;  
      }, "No space please and don't leave it empty");


      $('.only_numeric').bind('keyup paste', function(){
          this.value = this.value.replace(/[^0-9-]/g, '');
      });
      
      age_group = "{{@$data['detail']->age_group}}";
      var age = age_group.split("-");
        $("#age_group_from").val(age[0]);
        $("#age_group_to").val(age[1]);

      salary_range = "{{@$data['detail']->salary_range}}";
      var salary = salary_range.split("-");
        $("#salary_range_from").val(salary[0]);
        $("#salary_range_to").val(salary[1]);

      experience = "{{@$data['detail']->experience}}";
      var experience = experience.split("-");
        $("#year_experience_from").val(experience[0]);
        $("#year_experience_to").val(experience[1]);

      var department = "{{@$data['detail']->department_id}}"
        $("#jrf_department").val(department);

      var designationA = "{{@$data['detail']->designation_id}}"
        $("#designation_id_ra").val(designationA);  

      var gender = "{{@$data['detail']->gender}}"
      if(gender == 'Male') {
        $("#male").prop("checked", true);
      } else if (gender == 'Female') {
        $("#female").prop("checked", true);
      }else if (gender == 'Any of Them') {
        $("#any_of_them").prop("checked", true);
      }


      var temp_or_perm = "{{@$data['detail']->temp_or_perm}}"
      if(temp_or_perm == 'temp') {
        $("#temp").prop("checked", true);
      } else{
        $("#perm").prop("checked", true);
      }
      
 
      /*Reason dropdown scripts starts here*/
      $('.myradiobtn').on('click',function(){
        var recruitment_result = $(this).val();
          if(recruitment_result == "Backoff"){
            $(".hide_backoff").show();
            $(".hide_rejected").hide();
            $("#other_rejected_reason").hide();
            $("#backoff_reason").on('change', function(){
              if ($(this).val() == "other_backout_reason") {
                $("#other_backoff_reason").show();
              }else{
                $("#other_backoff_reason").hide();
              }
            });
          } else if(recruitment_result == "Selected"){
            $(".hide_backoff").hide();
            $(".hide_rejected").hide();
            $("#other_backoff_reason").hide();
            $("#other_rejected_reason").hide();
          } else if(recruitment_result == "Rejected"){
            $(".hide_rejected").show();
            $(".hide_backoff").hide();
            $("#other_backoff_reason").hide();
            $("#rejected_reason").on('change', function(){
              if ($(this).val() == "other_rejection_reason") {
                $("#other_rejected_reason").show();
              }else{
                $("#other_rejected_reason").hide();
              }
            });
          }
      });

      // start dependent department wise employees
      var userId = "{{@$user_id}}";
      $('#recruitment_department_id').on('change', function(){
      var department = $(this).val();
      var displayString = "";
      $("#recruitment_interviewer_employee_id").empty();
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
                  if(employee.user_id != 1){
                    displayString += '<option value="'+employee.user_id+'">'+employee.fullname+'</option>';
                  }
                });
              }
              $('#recruitment_interviewer_employee_id').append(displayString);
          }
        });
      }).change();
    // end 

    // Project Wise Designation

    var userId = "{{@$user_id}}";
    $('#project_id').on('change', function(){
    var project = $(this).val();
    var displayString = "";
    $("#designation_id").empty();
    var projects = [];
    projects.push(project);
        $.ajax({
          type: "POST",
          url: "{{url('jrf/project-wise-designation')}}",
          data: {project_ids: projects},
          success: function(result){
           
            if(result.length == 0 || (result.length == 1 && result[0].id == userId)){
                displayString += '<option value="" disabled>None</option>';
            }else{
            result.forEach(function(designation){
              if(designation.id != userId && designation.id != 1){
                displayString += '<option value="'+designation.id+'">'+designation.name+'</option>';
              }
            });
          }
          $('#designation_id').append(displayString);
        }
      });
    }).change();

 

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
              if(employee.user_id != userId && employee.user_id != 1){
                displayString += '<option value="'+employee.user_id+'">'+employee.fullname+'</option>';
              }
            });
          }
          $('#interviewer_employee').append(displayString);
        }
      });
    }).change();
    // end

   // for recruitment
    $("#recruitment_task_form_id").validate({
      rules: {
        "recruitment_department_id" : {
          required: true
        },
        "recruitment_interviewer_employee_id" : {
          required: true
        },
        "recruitment_last_date" : {
          required: true
        }
      },
      messages: {
          "recruitment_department_id" : {
            required: 'Select department name'
          },
          "recruitment_interviewer_employee_id" : {
            required: 'Select recruiter name'
          },
          "recruitment_last_date" : {
            required: 'Select last date'
          }
        }
    });
    // end 

    // for interviewer detail
    $("#interviewer_details_form_id").validate({
      rules: {
        "interviewer_department" : {
          required: true
        },
        "interviewer_employee" : {
          required: true
        },
        "candidate_name" : {
          required: true
        },
        "interview_date" : {
          required: true
        }
      },
      messages: {
          "interviewer_department" : {
            required: 'Select department name'
          },
          "interviewer_employee" : {
            required: 'Select recruiter name'
          },
          "candidate_name" : {
            required: 'Enter name of candidate'
          },
          "interview_date" : {
            required: 'Select date of interview'
          }
        }
    });
  // end

    // interview status
    $("#interviewer_status_form").validate({
        rules: {
            "backoff_reason" : {
              required: true
            },

            "rejected_reason" : {
              required: true
            }, 

            "other_backoff_reason" : {
              required: true
            },
            "other_rejected_reason" : {
              required: true
            }
        },
        messages: {
            "backoff_reason" : {
              required: 'Please enter back off reason.'
            },
            "rejected_reason" : {
              required: 'Please enter rejection reason.'
            },
            "other_backoff_reason" : {
              required: 'Please enter other back off reason.'
            },
            "other_rejected_reason" : {
              required: 'Please enter other rejection reason.'
            }
        }
    });
   // end

    //$('.interview_status').required = true;
    $(document).ready(function(){
      $(".interviewer_status").on('click',function(){
        var id = $(this).data("id");
        var assigned_by_modal = $(this).data("assigned_by");
        var fullname = $(this).data("fullname");
        var candidate_name = $(this).data("candidate_name");
        var interview_status = $(this).data("interview_status");
        var interview_type = $(this).data("interview_type");
        var other_rejected_reason = $(this).data("other_rejected_reason");
        var other_backoff_reason = $(this).data("other_backoff_reason");
        var final_status = $(this).data("final_status");

        $("#interview_detail_id").val(id);
        $("#interview_assigned_by_id").val(assigned_by_modal);
        $("#interview_status_modal").val(interview_status);
        $("#hidden_candidate_name").val(candidate_name);
        $("#hidden_fullname").val(fullname);

        if (interview_status == 'rejected') {
            $("#rejected_id").prop("checked", true);
          if(final_status == "other_rejection_reason"){
              $(".hide_rejected").show();
              $("#rejected_reason").val(final_status).attr("selected","selected");
              $("#other_rejected_reason").show();
          } else{
              $(".hide_rejected").show();
              $("#rejected_reason").val(final_status).attr("selected","selected");
              $(document.body).on('change',"#rejected_reason",function (e) {
                var onchange_other_rreason= $("#rejected_reason option:selected").val();
                if(onchange_other_rreason == "other_rejection_reason"){
                  $("#other_rejected_reason").show();
                }else {
                  $("#other_rejected_reason").hide();
                }
              });
            }
        } else if (interview_status == 'selected') {
            $("#selected_id").prop("checked", true);
        } else if (interview_status == 'backoff') {
            $("#backoff_id").prop("checked", true);
            if(final_status == "other_backout_reason"){
              $(".hide_backoff").show();
              $("#backoff_reason").val(final_status).attr("selected","selected");
              $("#other_backoff_reason").show();
            } else{
              $(".hide_backoff").show();
              $("#backoff_reason").val(final_status).attr("selected","selected");
              $(document.body).on('change',"#backoff_reason",function (e) {
                var onchange_backoff_reason = $("#backoff_reason option:selected").val();
                if(onchange_backoff_reason  == "other_backout_reason"){
                  $("#other_backoff_reason").show();
                }else {
                  $("#other_backoff_reason").hide();
                }
              });
          }
        }
        $("#interview_type_modal").val(interview_type);
        $(".other_rejected_reason").val(other_rejected_reason);
        $(".other_backoff_reason").val(other_backoff_reason);
        $("#other_backoff_reason_model").val(other_backoff_reason);
        $("#final_status_model").val(final_status);
       });
    });

    //for pop-up data 
    /*$(".interviewer_status_detail").on('click',function(){
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
*/
    // for close jrf status //
    $(document).on('click', '#close_jrf', function close_jrf(){
      var confirmation = confirm("Are you sure you want to close this JRF?");
        if (confirmation) {
          var id = $(this).attr("data-id");
          var employeeId = $(this).attr("data-employeeId");
          var gif = "{{url('public/loading.webp')}}";
          $.ajax({
            type: 'POST',
            url: "{{ url('/jrf/close-jrf-permanently') }}",
            data: {
                id: id, employeeId:employeeId
            },
            beforeSend: function(){
              window.swal({
                  title: "Closing...",
                  text: "Please wait",
                  imageUrl: gif,
                  showConfirmButton: false,
                  allowOutsideClick: false
                });
            },
            success: function(data) {
                swal("Closed!","It was successfully close.","success");
            } 
          });
            setTimeout(function(){// wait for 5 secs(2)
              location.reload(); // then reload the page.(3)
            }, 5000); 
        } else {
          return false;
        }
      });

      var close_jrf_status = "{{@$data['detail']->final_status}}";
      if(close_jrf_status == 1){
        $("#submit3").attr("disabled", true);
        $('.fieldset').find('input, textarea, button, select').attr('disabled','disabled');
        $("#close_jrf").attr("disabled", true);
        $('#interviewer_details_form_id').find('input, textarea, button, select').attr('disabled','disabled');
      }

      var check_rejected = "{{ @$data['detail']->final_status == 0  && @$data['approval_status']->jrf_status == '2' }}"   
      if(check_rejected){
        $('#jrfRequisitionForm').find('input, textarea, button, select').attr('disabled','disabled');
        $('#recruitment_task_form_id').find('input, textarea, button, select').attr('disabled','disabled');
      }

      $(document).ready(function() {
        $('.data_table').DataTable({
             dom: 'lBfrtip',
              buttons: [{
              extend: 'pdf',
              title: 'JRF Report',
              filename: 'jrf_pdf_file_name'
            }, {
              extend: 'excel',
              title: 'JRF Report',
              filename: 'jrf_excel_file_name'
            },{
              extend: 'print',
              title: 'JRF Report',
              filename: 'jrf_print_file_name'
            },{
              extend: 'copy',
              title: 'JRF Report',
              filename: 'jrf_copy_file_name'
            }, {
              extend: 'csv',
              title: 'JRF Report',
              filename: 'jrf_csv_file_name'
            }]
        });
      });
</script>
<script type="text/javascript">

  $(".unassignBtn").on('click',function(){
        if (!confirm("Are you sure you want to Unassigned this Recruiter?")) {
            return false; 
        }else{

        }
      });
  </script>
@endsection