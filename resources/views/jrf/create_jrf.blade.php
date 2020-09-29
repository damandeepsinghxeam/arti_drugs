@extends('admins.layouts.app')
@section('content')

<link rel="stylesheet" href="{{asset('public/admin_assets/plugins/timepicker/bootstrap-timepicker.min.css')}}">
<script src="{{asset('public/admin_assets/plugins/timepicker/bootstrap-timepicker.min.js')}}"></script>
<script src="{{asset('public/admin_assets/plugins/validations/jquery.validate.js')}}"></script>
<script src="{{asset('public/admin_assets/plugins/validations/additional-methods.js')}}"></script>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>Job Requisition Form (JRF)</h1>
        <ol class="breadcrumb">
          <li><a href="{{url('/employees/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
          <li><a href="{{url('/jrf/list-jrf')}}">JRF List</a></li> 
        </ol>
      </section>

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
	        <form id="jrfRequisitionForm" action="{{ url('jrf/save-jrf') }}" method="POST" enctype="multipart/form-data">
	        {{ csrf_field() }}
	           <div class="box-body jrf-form-body">
	              <div class="row">
	                 <div class="col-md-6">
	                    <div class="form-group">
	                    <!-- for Project JRF -->
	                      	<div class="form-group">
	                           	<div class="row">
	                              	<div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
	                                	<label for="type" class="apply-leave-label">Project Type<sup class="ast">*</sup></label>
	                              	</div>
	                              	<div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
										<select name="type" class="form-control input-sm basic-detail-input-style" id="jrf_type">
											<option value="">Please select JRF Type</option>
											<option value="Xeam">Internal-Hiring</option> 
											<option value="Project">Project-Hiring</option>
										</select>
	                              </div>
	                           </div>
	                      	</div>

	                      <div class="form-group">
	                        <div class="row">
	                          <div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
	                             <label for="project_id" class="apply-leave-label">Project<sup class="ast">*</sup></label>
	                          </div>
	                          <div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
	                             <select class="form-control select2 input-sm basic-detail-input-style" name="project_id" style="width: 100%;" id="project_id" data-placeholder="Select Project">
	                                <option value="">Please Select</option> 
	                                @if(!$data['project']->isEmpty())
	                                @foreach($data['project'] as $proj) 
	                                <option value="{{$proj->id}}">{{$proj->name}}</option>
	                                @endforeach
	                                @endif  
	                             </select>
	                          </div>
	                        </div>
	                      </div>

	                      <div class="project_jrf" style="display: none;">
	                        <div class="form-group">
	                           <div class="row">
	                              <div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
	                                 <label for="certification" class="apply-leave-label">Certification</label>
	                              </div>
	                              <div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
	                                 <input type="text" name="certification" class="form-control input-sm basic-detail-input-style" id="certification" placeholder="Enter Certification"> 
	                              </div>
	                           </div>
	                        </div>

	                        <div class="form-group">
	                           <div class="row">
	                              <div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
	                                 <label for="benefits_perks" class="apply-leave-label">Benefits Perks</label>
	                              </div>

	                              <div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
	                                <select class="form-control select2 input-sm basic-detail-input-style" name="benefits_perks[]" multiple="multiple" style="width: 100%;" id="benefits_perks" data-placeholder="Select Benefits & Perks">
	                                @if(!$data['benifit_perk']->isEmpty())
	                                  @foreach($data['benifit_perk'] as $benifits)  
	                                    <option value="{{$benifits->id}}">{{$benifits->name}}</option>
	                                  @endforeach
	                                @endif  
	                                </select>
	                              </div>
	                           </div>
	                        </div>

	                        <div class="form-group">
	                           <div class="row">
	                              <div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
	                                 <label for="temp_or_perm" class="apply-leave-label">Model<sup class="ast">*</sup></label>
	                              </div>
	                              <div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
	                                <div class="radio">
	                                  <label>
	                                  <input type="radio" name="temp_or_perm" id="optionsRadios3" value="temp" checked="">&nbsp;Temporary</label>&nbsp;&nbsp;&nbsp;
	                                  <label>
	                                  <input type="radio" name="temp_or_perm" id="optionsRadios4" value="perm">&nbsp;Permanent
	                                  </label>
	                                </div>
	                              </div>
	                           </div>
	                        </div>
	                        <div class="form-group">
	                           <div class="row">
	                              <div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
	                                 <label for="service_charges_fee" class="apply-leave-label">Service Charges Fee<sup class="ast">*</sup></label>
	                              </div>
	                              <div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
	                                  <input type="text" name="service_charges_fee" class="form-control input-sm basic-detail-input-style" id="service_charges_fee" placeholder="Enter Service Charges Fee"> 
	                              </div>
	                           </div>
	                        </div>
	                    </div>
	                    <!-- end of Project JRF -->


	                      @php $user_id = Auth::id(); @endphp
	                        <input type="hidden" name="user_id" value="{{@$user_id}}">
	                        <input type="hidden" name="department_id" value="{{@$data['user_dept']->department_id}}">

	                      	<div class="row">
	                          <div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
	                             <label for="jrf_department" class="apply-leave-label">Interviewer's Name<sup class="ast">*</sup></label>
	                          </div>
	                          <div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">

	                            <select class="form-control input-sm basic-detail-input-style" name="approver_id" id="approver_id">
	                              <option value="">Select Interviewer</option>
	                                @if(!$data['dept_usr']->isEmpty())
	                                @foreach($data['dept_usr'] as $usr)
	                                <option value="{{$usr->id}}">{{$usr->fullname}}</option>
	                                @endforeach
	                                @endif
	                             </select>
	                          </div>
	                       </div>
	                    </div>

	                    <div class="form-group">
	                       <div class="row">
	                          <div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
	                             <label for="role_id" class="apply-leave-label">Candidate's Job Role <sup class="ast">*</sup></label>
	                          </div>
	                          <div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
	                             <select class="form-control select2 input-sm basic-detail-input-style" name="role_id" style="width: 100%;" id="role_id">
	                                @if(!$data['roles']->isEmpty())
	                                @foreach($data['roles'] as $role)  
	                                <option value="{{$role->id}}">{{$role->name}}</option>
	                                @endforeach
	                                @endif  
	                             </select>
	                          </div>
	                       </div>
	                    </div>
	                    <div class="form-group"> 
	                      <div class="row">
	                          <div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
	                             <label for="jrf_department" class="apply-leave-label">Candidate's Designation<sup class="ast">*</sup></label>
	                          </div>
	                          <div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
	                            <select class="form-control basic-detail-input-style input-sm" name="designation_id" id="designation_id">
	                            	
	                            </select>
	                          </div>
	                       </div>
	                    </div>
	                    <!--<div class="form-group">
	                       <div class="row">
	                          <div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
	                             <label for="designation_id" class="apply-leave-label">Job Designation<sup class="ast">*</sup></label>
	                          </div>
	                          <div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
	                             <select class="form-control select2 input-sm basic-detail-input-style" name="designation_id" style="width: 100%;" id="designation_id" data-placeholder="Select Designation">
	                                @if(!$data['designation']->isEmpty())
	                                @foreach($data['designation'] as $desig)  
	                                <option value="{{$desig->id}}">{{$desig->name}}</option>
	                                @endforeach
	                                @endif  
	                             </select>
	                          </div>
	                       </div>
	                    </div> -->
	                    <div class="form-group">
	                       <div class="row">
	                          <div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
	                             <label for="number_of_positions" class="apply-leave-label">Number of Positions<sup class="ast">*</sup></label>
	                          </div>
	                          <div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
	                             <input type="text" name="number_of_positions" id="number_of_positions" placeholder="Number of positions" class="form-control input-sm basic-detail-input-style only_numeric">
	                          </div>
	                       </div>
	                    </div>
	                    <div class="form-group">
	                       <div class="row">
	                          <div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
	                             <label for="" class="apply-leave-label">Age Group( in years )</label>
	                          </div>
	                          <div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
	                             <div class="row">
	                                <div class="col-xs-6 input-l">
	                                   <input type="text" name="age_group_from" id="age_group_from" placeholder="Min" class="form-control  input-sm basic-detail-input-style only_numeric" onblur="age_chk()">
	                                </div>
	                                <div class="col-xs-6 input-r">
	                                   <input type="text" name="age_group_to" id="age_group_to" placeholder="Max" class="form-control input-sm basic-detail-input-style only_numeric" onblur="age_chk()">
	                                </div>
	                             </div>
	                          </div>
	                       </div>
	                    </div>
	                    <div class="form-group">
	                       <div class="row">
	                          <div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
	                             <label for="gender" class="apply-leave-label">Gender<sup class="ast">*</sup></label>
	                          </div>
	                          <div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
	                           <div class="radio radio-style">
	                            <label>
	                              <input type="radio" name="gender" class="radio-s-label" value="Male" checked="">Male
	                          	</label>&nbsp;&nbsp;
	                            <label>
	                              <input type="radio" name="gender" class="radio-s-label" value="Female">Female
	                            </label>&nbsp;&nbsp;
	                            <label>
	                              <input type="radio" name="gender" class="radio-s-label" value="Any Of Them"> Any Of Them
	                            </label>
	                            
	                            
	                           </div>
	                          </div>
	                       </div>
	                    </div>
	                    <div class="form-group">
	                       <div class="row">
	                          <div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
	                             <label for="job_location" class="apply-leave-label">Job Location<sup class="ast">*</sup></label>
	                          </div>
	                          <div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
	                             <select class="form-control select2 input-sm basic-detail-input-style" name="city_id[]" multiple="multiple" style="width: 100%;" id="city_id" data-placeholder="Select Location">
	                                @if(!$data['cities']->isEmpty())
	                                @foreach($data['cities'] as $citi)  
	                                <option value="{{$citi->id}}">{{$citi->name}}</option>
	                                @endforeach
	                                @endif  
	                             </select>
	                          </div>
	                       </div>
	                    </div>
	                    <div class="form-group">
	                       <div class="row">
	                          <div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
	                             <label for="" class="apply-leave-label">Shift Timing</label>
	                          </div>
	                          <div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
	                             <div class="row">
	                                <div class="col-xs-6 input-l">
	                                   <input type="text" name="shift_timing_from" id="shift_timing_from" placeholder="From" class="form-control input-sm basic-detail-input-style">
	                                </div>
	                                <div class="col-xs-6 input-r">
	                                   <input type="text" name="shift_timing_to" id="shift_timing_to" placeholder="To" class="form-control  input-sm basic-detail-input-style">
	                                </div>
	                             </div>
	                          </div>
	                       </div>
	                    </div>
	                 </div>
	                 <div class="col-md-6">
	                    <div class="form-group">
	                    <div class="form-group">
	                       <div class="row">
	                          <div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
	                             <label for="Job_description" class="apply-leave-label">Job Description<sup class="ast">*</sup></label>
	                          </div>
	                          <div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
	                             <textarea rows="4" cols="50" class="form-control input-sm basic-detail-input-style" id="Job_description" name="job_description" placeholder="Brief Description of Duties"></textarea>
	                          </div>
	                       </div>
	                    </div>

	                       <div class="row">
	                          <div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
	                             <label for="qualification_id" class="apply-leave-label">Qualifications<sup class="ast">*</sup></label>
	                          </div>
	                          <div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
	                             <select class="form-control select2 input-sm basic-detail-input-style" name="qualification_id[]" multiple="multiple" style="width: 100%;" id="qualification_id" data-placeholder="Select Qualifications">
	                                @if(!$data['qualifications']->isEmpty())
	                                @foreach($data['qualifications'] as $quali)  
	                                <option value="{{$quali->id}}">{{$quali->name}}</option>
	                                @endforeach
	                                @endif  
	                             </select>
	                          </div>
	                       </div>
	                    </div>
	                    <div class="form-group">
	                       <div class="row">
	                          <div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
	                             <label for="skill_id" class="apply-leave-label">Skills<sup class="ast">*</sup></label>
	                          </div>
	                          <div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
	                             <select class="form-control select2 input-sm basic-detail-input-style" name="skill_id[]" multiple="multiple" style="width: 100%;" id="skill_id" data-placeholder="Select Skills">
	                                @if(!$data['skills']->isEmpty())
	                                @foreach($data['skills'] as $skill)  
	                                <option value="{{$skill->id}}">{{$skill->name}}</option>
	                                @endforeach
	                                @endif  
	                             </select>
	                          </div>
	                       </div>
	                    </div>
	                    <div class="form-group">
	                       <div class="row">
	                          <div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
	                             <label for="jrf_additional_requirement" class="apply-leave-label">Additional Requirement</label>
	                          </div>
	                          <div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
	                             <input type="text" name="additional_requirement" id="jrf_additional_requirement" placeholder="" class="form-control input-sm basic-detail-input-style">
	                          </div>
	                       </div>
	                    </div>
	                    <div class="form-group">
	                       <div class="row">
	                          <div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
	                             <label for="salary_range" class="apply-leave-label">Salary Range(Annual)<sup class="ast">*</sup></label>
	                          </div>
	                          <div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
	                             <div class="row">
	                                <div class="col-xs-6 input-l">
	                                   <input type="text" name="salary_range_from" id="salary_range_from" placeholder="Min" class="form-control input-sm basic-detail-input-style salary_range_class only_numeric">
	                                </div>
	                                <div class="col-xs-6 input-r">
	                                   <input type="text" name="salary_range_to" id="salary_range_to" placeholder="Max" class="form-control input-sm basic-detail-input-style salary_range_class only_numeric">
	                                </div>
	                             </div>
	                          </div>
	                       </div>
	                    </div>
	                    <div class="form-group">
	                       <div class="row">
	                          <div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
	                             <label for="salary_range">Relevant Experience <br>(in years)</label>
	                          </div>
	                          <div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
	                             <div class="row">
	                                <div class="col-xs-6 input-l">
	                                   <input type="text" name="year_experience_from" id="year_experience_from" placeholder="Min" class="form-control input-sm basic-detail-input-style salary_range_class only_numeric" onblur="exp_chk()">
	                                </div>
	                                <div class="col-xs-6 input-r">
	                                   <input type="text" name="year_experience_to" id="year_experience_to" placeholder="Max" class="form-control input-sm basic-detail-input-style salary_range_class only_numeric" onblur="exp_chk()">
	                                </div>
	                             </div>
	                          </div>
	                       </div>
	                    </div>
	                    <div class="form-group">
	                       <div class="row">
	                          <div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
	                             <label for="jrf_industry_type" class="apply-leave-label">Name of Industry<sup class="ast">*</sup></label>
	                          </div>
	                          <div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
	                             <input type="text" class="form-control input-sm basic-detail-input-style" name="industry_type" id="jrf_industry_type" placeholder="Enter Industry">
	                          </div>
	                       </div>
	                    </div>

	                     <div class="form-group">
	                       <div class="row">
	                          <div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
	                             <label for="jrf_industry_type" class="apply-leave-label">Document Uploaded (LOI)</label>
	                          </div>
	                          <div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
	                             <input type="file" class="input-sm" name="uploade_type" id="uploade_type" placeholder="Document Uploaded" style="padding-left: 0;">
	                          </div>
	                       </div>
	                    </div>

	                    <div class="form-group">
	                       <div class="row">
	                          <div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
	                             <label for="number_of_positions" class="apply-leave-label">JRF Closure Timeline<sup class="ast">*</sup></label>
	                          </div>
	                          <div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
	                             <input type="text" name="closure_timeline" id="closure_timeline" placeholder="Fill Closure Timeline" class="form-control datepicker input-sm basic-detail-input-style p-l-sm">
	                          </div>
	                       </div>
	                    </div>

	                    <div class="form-group">
	                       <div class="row">
	                          <div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
	                             <label for="jrf_industry_type" class="apply-leave-label">Job Posting Required<sup class="ast">*</sup></label>
	                          </div>
	                          <div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
	                            <div class="radio radio-style">
	                              <label>
	                              <input type="radio" name="job_posting_other_website" class="radio-s-label" value="Yes" checked="">Yes</label>&nbsp;&nbsp;
	                              <label>
	                              <input type="radio" name="job_posting_other_website" class="radio-s-label" value="No">No
	                              </label>
	                            </div>
	                          </div>
	                       </div>
	                    </div>

	                  </div>
	                </div>
	              <div class="text-center">
	                 <input type="submit" class="btn btn-primary submit-btn-style" id="submit"  value="Submit" name="submit">
	              </div>
	           </div>
	          </form>
	        <!-- form end -->
	        </div>
	      <!-- /.box-body -->
	    </div>
     </div>
  </section>
  </div>
<!-- /.row -->

<script>
    $("#jrfRequisitionForm").validate({
      rules: {
        "department_id" : {
          required: true
        },
        
         "approver_id" : {
          required: true
        },

        "project_id" :{
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
        },
        "closure_timeline" : {
          required: true
        }
      },
      errorPlacement: function(error, element) {
	    if (element.hasClass('select2')) {
	      error.insertAfter(element.next('span.select2'));
	    } else {
	      error.insertAfter(element);
	    }
	  },
      messages: {
          "department_id" : {
            required: 'Select department name'
          },
          "approver_id" : {
            required: 'Select Interviewer name'
          },
          
          "project_id" : {
            required: 'Enter Project Name'
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
            required: 'Select Location'
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
          "closure_timeline" : {
            required: 'Select Closure Date'
          }
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

   /* $("div.alert-dismissible").fadeOut(3000);
    $("#shift_timing_to").timepicker({
      showInputs: false
    });  */


    $("#jrf_type").click(function () {
       var type = $(this).val();
       if(type == 'Project'){
        $(".project_jrf").show();
       } else {
        $(".project_jrf").hide();
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
              displayString += '<option value="">select</option>';
            result.forEach(function(employee){
              if(employee.user_id != 1){
                displayString += '<option value="'+employee.user_id+'">'+employee.fullname+'</option>';
              }
            });
          }
          $('#approver_id').append(displayString);
        }
      });
    }).change();

     // end

       // for Approval request person //
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


    function exp_chk(){                                                                                                    
      var year_experience_from  =  $('#year_experience_from').val();
      var year_experience_to    =  $('#year_experience_to').val();
      
        if(parseFloat(year_experience_from) > parseFloat(year_experience_to)){
          document.getElementById('year_experience_to').value = '';
          document.getElementById('year_experience_from').value = '';
          alert('Max must be greater than min');
        }

    }

    function age_chk(){                                                                                                    
      var age_group_from  =  $('#age_group_from').val();
      var age_group_to    =  $('#age_group_to').val();
      
        if(parseFloat(age_group_from) > parseFloat(age_group_to)){
          document.getElementById('age_group_from').value = '';
          document.getElementById('age_group_to').value = '';
          alert('Max must be greater than min');
        }

    }

  /*  $('.datepicker').datepicker({ //Date picker
      autoclose: true,
      orientation: "bottom",
      format: 'yyyy-mm-dd',
    });  */

     var dateToday = new Date();
      var last_date = "{{@$data['last_date']}}";
        $('.datepicker').datepicker({ //Date picker
          autoclose: true,
          orientation: "bottom",
          format: 'yyyy-mm-dd',
          startDate : dateToday,
          endDate : last_date
        });

</script>
@endsection