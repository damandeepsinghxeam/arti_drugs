@extends('admins.layouts.app')

@section('content')
<!-- Content Wrapper. Contains page content -->
<link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/redmond/jquery-ui.css">
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.js"></script>

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Edit Employee Forms
        <!-- <small>Control panel</small> -->
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('employees.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('employees.list') }}">Employees List</a></li>
      </ol>
    </section>

    <?php $lastInsertedEmployeee = $data['employeeId'];
        
    ?>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-md-12">
          <!-- Custom Tabs -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">

              <li id="basicDetailsTab" class=""><a href="#tab_basicDetailsTab" data-toggle="tab">Basic Details</a></li>
              <li id="profileDetailsTab" class=""><a href="#tab_profileDetailsTab" data-toggle="tab">Profile Details</a></li>
              <li id="documentDetailsTab" class=""><a href="#tab_documentDetailsTab" data-toggle="tab">Document Upload</a></li>
              <li id="accountDetailsTab" class=""><a href="#tab_accountDetailsTab" data-toggle="tab">HR Details</a></li>
              <li id="addressDetailsTab" class=""><a href="#tab_addressDetailsTab" data-toggle="tab">Contact Details</a></li>
              <li id="historyDetailsTab" class=""><a href="#tab_historyDetailsTab" data-toggle="tab">Employment History</a></li>
              <li id="referenceDetailsTab" class=""><a href="#tab_referenceDetailsTab" data-toggle="tab">Reference Details</a></li>
              <li id="securityDetailsTab" class=""><a href="#tab_securityDetailsTab" data-toggle="tab">Security Details</a></li>
              
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_basicDetailsTab">
                @if(session()->has('basicSuccess'))
                  <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    {{ session()->get('basicSuccess') }}
                  </div>
                @endif

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

                 @if(session()->has('profileError'))
                  <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    {{ session()->get('profileError') }}
                  </div>
                @endif

            <button class="btn btn-primary">UID {{$data['employeeId']}}</button>
                    <!-- form start -->
            <form id="basicDetailsForm" class="form-horizontal" action="{{ route('employees.editBasicDetails') }}" method="POST" enctype="multipart/form-data">
              {{ csrf_field() }}
              <div class="box-body">
                <div class="form-group">

                  <label for="employeeName" class="col-sm-2 control-label">Employee Name</label>

                  <div class="col-sm-8">
                    <input type="text" class="form-control input-sm" name="employeeName" id="employeeName" placeholder="Employee name" value="{{@$data['profileData']['basic']->full_name}}">
                  </div>

                  <div class="col-sm-2">
                    <select class="form-control salutation input-sm" name="salutation">
                      <option value="Mr.">Mr.</option>  
                      <option value="Ms.">Ms.</option>  
                      <option value="Mrs.">Mrs.</option>  
                    </select>
                  </div>

                </div>

                <input type="hidden" name="employeeId" value="{{$data['employeeId']}}">

                <div class="form-group">

                  <label for="fatherName" class="col-sm-2 control-label">Father's Name</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control input-sm" name="fatherName" id="fatherName" placeholder="Father's Name" value="{{@$data['profileData']['basic']->father_name}}">
                  </div>
                </div>

                <div class="form-group">

                  <label for="motherName" class="col-sm-2 control-label">Mother's Name</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control input-sm" name="motherName" id="motherName" placeholder="Mother's Name" value="{{@$data['profileData']['basic']->mother_name}}">
                  </div>
                </div>

                <div class="form-group">
                  <label for="employeeXeamCode" class="col-sm-2 control-label">Employee Xeam Code</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control input-sm" name="employeeXeamCode" id="employeeXeamCode" placeholder="Employee Xeam Code" value="{{@$data['profileData']['basic']->emp_xeam_code}}" readonly>
                  </div>
                </div>

                <div class="form-group">
                  <label for="email" class="col-sm-2 control-label">Email</label>

                  <div class="col-sm-10">
                    <input type="email" class="form-control checkAjax input-sm" id="email" name="email" placeholder="Email" value="{{@$data['profileData']['basic']->email}}" readonly>
                    <span class="checkEmail"></span>
                  </div>
                </div>

                <div class="form-group">
                  <label for="mobile" class="col-sm-2 control-label">Mobile</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control checkAjax input-sm" id="mobile" name="mobile" placeholder="Mobile number" value="{{@$data['profileData']['basic']->mobile}}" readonly>
                    <span class="checkMobile"></span>
                  </div>
                </div>

                <div class="form-group">
                  <label for="altMobile" class="col-sm-2 control-label">Alternative Mobile Number</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control input-sm" id="altMobile" name="altMobile" placeholder="Alternative Mobile number" value="{{@$data['profileData']['basic']->alt_mobile}}">
                  </div>
                </div>

                <div class="form-group">
                  <label for="referral_code" class="col-sm-2 control-label">Referral Code</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control checkAjax input-sm" id="referralCode" name="referralCode" placeholder="Referral Code" value="{{@$data['profileData']['basic']->referral_code}}" readonly>
                    <span class="checkReferral"></span>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-2 control-label">Department</label>
                  <div class="col-sm-10">
                    <select class="form-control input-sm" name="departmentId">
                      <option value="" selected disabled>Please Select Employee's Department</option>
                    @if(!$data['departments']->isEmpty())
                      @foreach($data['departments'] as $department)  
                        <option value="{{$department->department_id}}" @if($department->department_id == @$data['profileData']['basic']->department_id){{"selected"}}@endif>{{$department->department_name}}</option>
                      @endforeach
                    @endif  
                    </select>
                  </div>  
                </div>

                <div class="form-group">
                  <label class="col-sm-2 control-label">Designation</label>
                  <div class="col-sm-10">
                    <select class="form-control input-sm" name="roleId">
                      <option value="" selected disabled>Please Select Employee's Designation.</option>
                    @if(!$data['roles']->isEmpty())  
                      @foreach($data['roles'] as $role)  
                        <option value="{{$role->id}}" @if($role->id == @$data['profileData']['basic']->role_id){{"selected"}}@endif>{{$role->name}}</option>
                      @endforeach
                    @endif
                    </select>
                  </div>  
                </div>

                <div class="form-group">
                  <label class="col-sm-2 control-label">Permissions</label>
                  <div class="col-sm-10">
                    <select class="form-control select2 input-sm" name="permissionIds[]" multiple="multiple" style="width: 100%">
                    @if(!$data['permissions']->isEmpty())
                      @foreach($data['permissions'] as $permission)  
                        <option value="{{$permission->id}}" @if(in_array($permission->id,@$data['profileData']['selectedPermissions'])){{"selected"}} @else{{""}}@endif>{{$permission->name}}</option>
                      @endforeach
                    @endif  
                    </select>
                  </div>  
                </div>
                
                <div class="form-group">
                  <label class="col-sm-2 control-label">Marital Status</label>
                  <div class="col-sm-10">
                    <select class="form-control maritalStatus input-sm" name="maritalStatus">
                      <option value="Married">Married</option>
                      <option value="Unmarried">Unmarried</option>
                      <option value="Widowed">Widowed</option>
                    </select>
                  </div>  
                </div>

                <div class="form-group spouseName">
                  <label for="spouseName" class="col-sm-2 control-label">Spouse Name</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control input-sm" id="spouseName" name="spouseName" placeholder="Spouse Name" value="@if(@$data['profileData']['basic']->marital_status != 'Unmarried'){{@$data['profileData']['basic']->spouse_name}}@endif">
                  </div>
                </div>

                <div class="form-group spouseName">
                  <label for="marriageDate" class="col-sm-2 control-label">Marriage Date</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control input-sm" id="marriageDate" name="marriageDate" placeholder="Select date" value="@if(@$data['profileData']['basic']->marital_status != 'Unmarried'){{@$data['profileData']['basic']->marriage_date}}@endif">
                    <span class="marriageDateErrors"></span>
                  </div>
                </div>

                <div class="form-group">
                  <label for="birthDate" class="col-sm-2 control-label">Date Of Birth</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control input-sm" id="birthDate" name="birthDate" placeholder="Select date" value="{{@$data['profileData']['basic']->birth_date}}">
                    <span class="birthDateErrors"></span>
                  </div>  
                </div>

                <div class="form-group">
                  <label for="joiningDate" class="col-sm-2 control-label">Date Of Joining</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control input-sm" id="joiningDate" name="joiningDate" placeholder="Select date" value="{{@$data['profileData']['basic']->joining_date}}">
                  </div>  
                </div>

                <div class="form-group">
                  <span class="col-sm-2 control-label radio"><strong>Gender</strong></span>
                  <div class="col-sm-10">
                    <label>
                      <input type="radio" name="gender" id="optionsRadios1" value="Male" @if(@$data['profileData']['basic']->gender == "Male"){{"checked"}}@endif>
                      Male
                    </label>
                    <label>  
                      <input type="radio" name="gender" id="optionsRadios2" value="Female" @if(@$data['profileData']['basic']->gender == "Female"){{"checked"}}@endif>
                      Female
                    </label>
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <!-- <button type="submit" class="btn btn-default">Cancel</button> -->
                <button type="submit" class="btn btn-info" id="basicFormSubmit">Submit</button>
              </div>
              <!-- /.box-footer -->
            </form>
        </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_profileDetailsTab">
                @if(session()->has('profileSuccess'))
                  <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    {{ session()->get('profileSuccess') }}
                  </div>
                @endif

                @if ($errors->profile->any())
                    <div class="alert alert-danger alert-dismissible">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <ul>
                            @foreach ($errors->profile->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                  <div id="noEmployeeProfile" class="alert alert-danger alert-dismissible">
                    <!-- <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> -->
                    {{"Please fill the basic details form for a new employee, or you can edit the profile of an existing user later."}}
                  </div>

                    <!-- form start -->
                  <form id="profileDetailsForm" class="form-horizontal" action="{{ route('employees.editProfileDetails') }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="box-body">
                      <div class="form-group">
                        <label for="phone" class="col-sm-2 control-label">Phone Number</label>

                        <div class="col-sm-10">
                          <input type="text" class="form-control input-sm" name="phone" id="phone" placeholder="Phone Number" value="{{@$data['profileData']['basic']->phone}}">
                        </div>
                      </div>

                      <input type="hidden" name="employeeId" value="{{$data['employeeId']}}">

                    <!-- <div class="col-md-10">  --> 

                      <div class="form-group">
                        <label class="col-sm-2 control-label">Location</label>
                        <div class="col-sm-10">
                          <select class="form-control input-sm" name="locationId">
                             <option value="" selected disabled>Please Select Employee's Location.</option>
                          @if(!$data['locations']->isEmpty())
                            @foreach($data['locations'] as $location)  
                              <option value="{{$location->location_id}}" @if($location->location_id == @$data['profileData']['basic']->location_id){{"selected"}}@endif>{{$location->location_name}}</option>
                            @endforeach
                          @endif  
                          </select>
                        </div>  
                      </div>

                      <div class="form-group">
                        <label class="col-sm-2 control-label">Project</label>
                        <div class="col-sm-10">
                          <select class="form-control input-sm" name="projectId">
                            <option value="" selected disabled>Please Select Employee's Project.</option>
                          @if(!$data['projects']->isEmpty())
                            @foreach($data['projects'] as $project)  
                              <option value="{{$project->project_id}}" @if($project->project_id == @$data['profileData']['basic']->project_id){{"selected"}}@endif>{{$project->project_name}}</option>
                            @endforeach
                          @endif  
                          </select>
                        </div>  
                      </div>

                      <div class="form-group">
                        <label class="col-sm-2 control-label">Reporting Manager</label>
                        <div class="col-sm-10">
                          <select class="form-control input-sm" name="employeeIds[]" style="width: 100%;">
                            <option value="" selected disabled>Please select employees's Reporting Manager</option>
                          @if(!$data['projectForm']['employees']->isEmpty())  
                            @foreach($data['projectForm']['employees'] as $employee)  
                              <option value="{{$employee->employee_id}}" @if($employee->employee_id == $lastInsertedEmployeee){{"disabled"}}@endif @if(in_array($employee->employee_id,@$data['profileData']['reportingManagers'])){{"selected"}} @else{{""}}@endif>{{$employee->full_name}}</option>
                            @endforeach
                          @endif
                          </select>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="col-sm-2 control-label">Shift Timing</label>
                        <div class="col-sm-10">
                          <select class="form-control input-sm" name="shiftTimingId">
                            <option value="" selected disabled>Please Select Employee's Shift Timing.</option>
                          @if(!$data['shiftTimings']->isEmpty())
                            @foreach($data['shiftTimings'] as $timing)  
                              <option value="{{$timing->shift_timing_id}}" @if($timing->shift_timing_id == @$data['profileData']['basic']->shift_timing_id){{"selected"}}@endif>{{$timing->shift_name}}</option>
                            @endforeach
                          @endif  
                          </select>
                        </div>  
                      </div>

                      <div class="form-group">
                        <label class="col-sm-2 control-label">Perks</label>
                        <div class="col-sm-10">
                          <select class="form-control select2 input-sm" name="perkIds[]" multiple="multiple" style="width: 100%;">
                          @if(!$data['perks']->isEmpty())
                            @foreach($data['perks'] as $perk)  
                              <option value="{{$perk->perk_id}}" @if(in_array($perk->perk_id,@$data['profileData']['selectedPerks'])){{"selected"}} @else{{""}}@endif>{{$perk->perk_name}}</option>
                            @endforeach
                          @endif  
                          </select>
                        </div>  
                      </div>

                      <div class="form-group">
                        <label class="col-sm-2 control-label">Skills</label>
                        <div class="col-sm-10">
                          <select class="form-control select2 input-sm" name="skillIds[]" multiple="multiple" style="width: 100%;">
                          @if(!$data['skills']->isEmpty())
                            @foreach($data['skills'] as $skill)  
                              <option value="{{$skill->skill_id}}" @if(in_array($skill->skill_id,@$data['profileData']['selectedSkills'])){{"selected"}} @else{{""}}@endif>{{$skill->skill_name}}</option>
                            @endforeach
                          @endif  
                          </select>
                        </div>  
                      </div>

                      <div class="form-group">
                        <label class="col-sm-2 control-label">Languages</label>
                        <div class="col-sm-10">
                          <select class="form-control select2 input-sm" name="languageIds[]" multiple="multiple" style="width: 100%;">
                          @if(!$data['languages']->isEmpty())
                            @foreach($data['languages'] as $language)  
                              <option value="{{$language->language_id}}" @if(in_array($language->language_id,@$data['profileData']['selectedLanguages'])){{"selected"}} @else{{""}}@endif>{{$language->language_name}}</option>
                            @endforeach
                          @endif  
                          </select>
                        </div>  
                      </div>
                    <!-- </div>   -->

                      <div class="form-group">
                        <label class="col-sm-2 control-label">Probation Period</label>
                        <div class="col-sm-10">
                          <select class="form-control input-sm" name="probationPeriodId">
                            <option value="" selected disabled>Please Select Employee's Probation Period.</option>
                          @if(!$data['probationPeriods']->isEmpty())
                            @foreach($data['probationPeriods'] as $probation)  
                              <option value="{{$probation->probation_period_id}}" @if($probation->probation_period_id == @$data['profileData']['basic']->probation_period_id){{"selected"}}@endif>{{$probation->probation_period_value}}</option>
                            @endforeach
                          @endif  
                          </select>
                        </div>  
                      </div>

                      <!--div class="form-group">
                        <label class="col-sm-2 control-label">Session</label>
                        <div class="col-sm-10">
                          <select class="form-control input-sm" name="sessionId">
                            <option value="" selected disabled>Please Select Employee's Session.</option>
                          @if(!$data['sessions']->isEmpty())
                            @foreach($data['sessions'] as $session)  
                              <option value="{{$session->session_id}}" @if($session->session_id == @$data['profileData']['basic']->session_id){{"selected"}}@endif>{{$session->session_name}}</option>
                            @endforeach
                          @endif  
                          </select>
                        </div>  
                      </div-->
                      
                      <div class="form-group">
                        <label class="col-sm-2 control-label">Experience Years</label>
                        <div class="col-sm-10">
                          <select class="form-control expYears input-sm" name="expYrs">
                            <option value="" selected disabled>Please Select Employee's Experience Years.</option>
                            <option value="0">0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                          </select>
                        </div>  
                      </div>

                      <div class="form-group">
                        <label class="col-sm-2 control-label">Experience Months</label>
                        <div class="col-sm-10">
                          <select class="form-control expMonths input-sm" name="expMns">
                            <option value="" selected disabled>Please Select Employee's Experience Months.</option>
                            <option value="0">0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                          </select>
                        </div>  
                      </div>

                      <div class="form-group">
                        <span class="col-sm-2 control-label"><strong>Background Verification</strong></span>
                        <div class="col-sm-10">
                          <label class="checkbox-inline">
                            <input type="checkbox" name="employmentVerification" id="employmentVerification" value="1">Previous Employment
                          </label>
                          <label class="checkbox-inline">
                            <input type="checkbox" name="addressVerification" id="addressVerification" value="1">House Address
                          </label>
                          <label class="checkbox-inline">
                            <input type="checkbox" name="policeVerification" id="policeVerification" value="1">Police verification
                          </label>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="col-sm-2 control-label" for="remarks">Remarks</label>
                        <div class="col-sm-10">
                         <textarea class="form-control input-sm" rows="5" name="remarks" id="remarks">{{@$data['profileData']['basic']->remarks}}</textarea>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="nominee" class="col-sm-2 control-label">Nominee Name</label>

                        <div class="col-sm-10">
                          <input type="text" class="form-control input-sm" name="nominee" id="nominee" placeholder="Nominee Name" value="{{@$data['profileData']['basic']->nominee_name}}">
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="relation" class="col-sm-2 control-label">Relation</label>

                        <div class="col-sm-10">
                          <input type="text" class="form-control input-sm" name="relation" id="relation" placeholder="Relation" value="{{@$data['profileData']['basic']->relation}}">
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="profilePic" class="col-sm-2 control-label">Profile Picture</label>
                        <div class="col-sm-10">
                          <input type="file" id="profilePic" name="profilePic" class="input-sm">  
                        </div>
                      </div>

                      <div class="form-group">
                        <span class="col-sm-2 control-label radio"><strong>Contract Signed</strong></span>
                        <div class="col-sm-10">
                          <label>
                            <input type="radio" name="contractSigned" id="optionsRadios3" value="1" @if(@$data['profileData']['basic']->contract_signed == "1"){{"checked"}}@endif>
                            Yes
                          </label>
                          <label>  
                            <input type="radio" name="contractSigned" id="optionsRadios4" value="0" @if(@$data['profileData']['basic']->contract_signed == "0"){{"checked"}}@endif>
                            No
                          </label>
                        </div>
                      </div>

                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                      <button type="submit" class="btn btn-info" id="profileFormSubmit">Submit</button>
                    </div>
                    <!-- /.box-footer -->
                  </form>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_documentDetailsTab">
                @if(session()->has('documentSuccess'))
                  <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    {{ session()->get('documentSuccess') }}
                  </div>
                @endif

                @if ($errors->document->any())
                    <div class="alert alert-danger alert-dismissible">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <ul>
                            @foreach ($errors->document->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                  <div id="noEmployeeDocument" class="alert alert-danger alert-dismissible">
                    <!-- <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> -->
                    {{"Please fill the basic details form for a new employee, or you can edit the profile of an existing user later."}}
                  </div>
                                
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Documents List</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <table class="table table-striped">
                <tr>
                  <th style="width: 10%">#</th>
                  <th style="width: 30%">Type</th>
                  <th style="width: 30%">Uploaded</th>
                  <th style="width: 20%">File</th>
                  <th style="width: 10%">Upload File</th>
                </tr>
                <?php $counter = 0;?> 
                @foreach($data['profileData']['documents'] as $document)
                <tr>
                  <td>{{++$counter}}</td>
                  <td>{{$document->document_type_name}}</td>
                  <td>
                    @if(empty($document->file_name))
                      <span class="badge bg-red">No</span>
                    @else
                      <span class="badge bg-green">Yes</span>
                    @endif
                  </td>
                  <td>
                    @if(!empty($document->file_name))
                      <span><a target="_blank" href="{{config('constants.uploadPaths.document').$document->file_name}}"><i class="fa fa-file-text-o" aria-hidden="true"></i></a></span>
                    @endif
                  </td>
                  <td>
                    <button class="btn btn-info uploadFile" href="javascript:void(0)" data-doctypename="{{$document->document_type_name}}" data-doctypeid="{{$document->document_type_id}}">Upload</button>
                  </td>
                </tr>
                @endforeach
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->  
                
                
              </div>
              <!-- /.tab-pane -->

              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_accountDetailsTab">
                @if(session()->has('accountSuccess'))
                  <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    {{ session()->get('accountSuccess') }}
                  </div>
                @endif

                @if ($errors->account->any())
                    <div class="alert alert-danger alert-dismissible">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <ul>
                            @foreach ($errors->account->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                  <div id="noEmployeeAccount" class="alert alert-danger alert-dismissible">
                    <!-- <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> -->
                    {{"Please fill the basic details form for a new employee, or you can edit the profile of an existing user later."}}
                  </div>
                <!-- form start -->
                  <form id="accountDetailsForm" class="form-horizontal" action="{{ route('employees.editAccountDetails') }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="box-body">
                      
                      <div class="form-group">
                        <label for="adhaar" class="col-sm-2 control-label">Adhaar Number</label>

                        <div class="col-sm-10">
                          <input type="text" class="form-control input-sm" name="adhaar" id="adhaar" placeholder="Adhaar Number" value="{{@$data['profileData']['accountInfo']->adhaar}}">
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="panNo" class="col-sm-2 control-label">PAN Number</label>

                        <div class="col-sm-10">
                          <input type="text" class="form-control input-sm" name="panNo" id="panNo" placeholder="PAN Number" value="{{@$data['profileData']['accountInfo']->pan_no}}">
                        </div>
                      </div>

                      <hr>

                      <div class="form-group">
                        <label for="empEsiNo" class="col-sm-2 control-label">Employee ESI Number</label>

                        <div class="col-sm-10">
                          <input type="text" class="form-control input-sm" name="empEsiNo" id="empEsiNo" placeholder="Employee ESI Number" value="{{@$data['profileData']['accountInfo']->emp_esi_no}}">
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="prevEmpEsiNo" class="col-sm-2 control-label">Employee Previous ESI Number</label>

                        <div class="col-sm-10">
                          <input type="text" class="form-control input-sm" name="prevEmpEsiNo" id="prevEmpEsiNo" placeholder="Employee Previous ESI Number" value="{{@$data['profileData']['accountInfo']->emp_prev_esi_no}}">
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="empDispensary" class="col-sm-2 control-label">Employee Dispensary</label>

                        <div class="col-sm-10">
                          <input type="text" class="form-control input-sm" name="empDispensary" id="empDispensary" placeholder="Employee Dispensary" value="{{@$data['profileData']['accountInfo']->emp_dispensary}}">
                        </div>
                      </div>
                      
                      <div class="form-group">
                        <label for="pfNoDepartment" class="col-sm-2 control-label">PF Number for Department File</label>

                        <div class="col-sm-10">
                          <input type="text" class="form-control input-sm" name="pfNoDepartment" id="pfNoDepartment" placeholder="PF Number for Department File" value="{{@$data['profileData']['accountInfo']->pf_no_department}}">
                        </div>
                      </div>


                      <div class="form-group">
                        <label for="uanNo" class="col-sm-2 control-label">UAN Number</label>

                        <div class="col-sm-10">
                          <input type="text" class="form-control input-sm" name="uanNo" id="uanNo" placeholder="UAN Number" value="{{@$data['profileData']['accountInfo']->uan_no}}">
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="prevUanNo" class="col-sm-2 control-label">Previous UAN Number</label>

                        <div class="col-sm-10">
                          <input type="text" class="form-control input-sm" name="prevUanNo" id="prevUanNo" placeholder="UAN Number" value="{{@$data['profileData']['accountInfo']->prev_uan_no}}">
                        </div>
                      </div>

                      <hr>

                      <div class="form-group">
                        <label class="col-sm-2 control-label">Bank Name</label>
                        <div class="col-sm-10">
                          <select class="form-control input-sm" name="financialInstitutionId">
                          @if(!$data['financialInstitutions']->isEmpty())
                            @foreach($data['financialInstitutions'] as $financialInstitution)  
                              <option value="{{$financialInstitution->financial_institution_id}}" @if($financialInstitution->financial_institution_id == @$data['profileData']['accountInfo']->financial_institution_id){{"selected"}}@endif>{{$financialInstitution->financial_institution_name}}</option>
                            @endforeach
                          @endif  
                          </select>
                        </div>  
                      </div>

                      <div class="form-group">
                        <label for="accHolderName" class="col-sm-2 control-label">Account Holder Name</label>

                        <div class="col-sm-10">
                          <input type="text" class="form-control input-sm" name="accHolderName" id="accHolderName" placeholder="Account Holder Name" value="{{@$data['profileData']['accountInfo']->acc_holder_name}}">
                        </div>
                      </div>

                      <input type="hidden" name="employeeId" value="{{$data['employeeId']}}">

                      <div class="form-group">
                        <label for="bankAccNo" class="col-sm-2 control-label">Bank Account Number</label>

                        <div class="col-sm-10">
                          <input type="text" class="form-control input-sm" name="bankAccNo" id="bankAccNo" placeholder="Bank Account Number" value="{{@$data['profileData']['accountInfo']->bank_acc_no}}">
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="ifsc" class="col-sm-2 control-label">IFSC Code</label>

                        <div class="col-sm-10">
                          <input type="text" class="form-control input-sm" name="ifsc" id="ifsc" placeholder="IFSC Code" value="{{@$data['profileData']['accountInfo']->ifsc}}">
                        </div>
                      </div>

                      <hr>

                      <div class="form-group">
                        <label class="col-sm-2 control-label">Company</label>
                        <div class="col-sm-10">
                          <select class="form-control company input-sm" name="companyId">
                             <option value="" selected disabled>Please Select Employee's Company</option>
                          @if(!$data['projectForm']['companies']->isEmpty())  
                            @foreach($data['projectForm']['companies'] as $company)  
                              <option value="{{$company->company_id}}" @if($company->company_id == @$data['profileData']['accountInfo']->company_id){{"selected"}}@endif>{{$company->company_name}}</option>
                            @endforeach
                          @endif
                          </select>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="pfNo" class="col-sm-2 control-label">PF Number</label>

                        <div class="col-sm-10">
                          <input type="text" class="form-control input-sm" name="pfNo" id="pfNo" value="@if(@$data['profileData']['accountInfo']->company_pf_id){{$data['profileData']['accountInfo']->comp_pf_acc_number}}@else{{'None'}}@endif" readonly>
                        </div>
                      </div>

                      <div class="form-group" id="tanNoBox">
                        <label for="tanNo" class="col-sm-2 control-label">TAN Number</label>

                        <div class="col-sm-10">
                          <input type="text" class="form-control input-sm" name="tanNo" id="tanNo" value="@if(@$data['profileData']['accountInfo']->company_tds_id){{$data['profileData']['accountInfo']->tan_no}}@else{{'None'}}@endif" readonly>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="col-sm-2 control-label">PT State</label>
                        <div class="col-sm-10">
                          <select class="form-control ptState input-sm" name="stateId">
                               <option value="" selected disabled>Please Select Employee's Company PT State</option>
                              <option value="{{'0'}}">None</option>
                          @if(!$data['projectForm']['states']->isEmpty()) 
                            @foreach($data['projectForm']['states'] as $state)  
                              <option value="{{$state->state_id}}" @if($state->state_id == @$data['profileData']['accountInfo']->state_id){{"selected"}}@endif>{{$state->state_name}}</option>
                            @endforeach
                          @endif
                          </select>
                        </div>
                      </div>

                      <div class="form-group" id="certificateBox">
                        <label for="certificateNo" class="col-sm-2 control-label">Certificate Number</label>

                        <div class="col-sm-10">
                          <input type="text" class="form-control input-sm" name="certificateNo" id="certificateNo" value="@if(@$data['profileData']['accountInfo']->company_pt_id){{$data['profileData']['accountInfo']->certificate_no}}@else{{'None'}}@endif" readonly>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="col-sm-2 control-label">ESI Location</label>
                        <div class="col-sm-10">
                          <select class="form-control esiLocation input-sm" name="locationId">
                              <option value="" selected disabled>Please Select Employee's Location</option>
                              <option value="{{'0'}}">None</option>
                          @if(!$data['projectForm']['locations']->isEmpty())  
                            @foreach($data['projectForm']['locations'] as $location)  
                              <option value="{{$location->location_id}}" @if($location->location_id == @$data['profileData']['accountInfo']->location_id){{"selected"}}@endif>{{$location->location_name}}</option>
                            @endforeach
                          @endif
                          </select>
                        </div>  
                      </div>

                      <div class="form-group" id="esiNoBox">
                        <label for="esiNo" class="col-sm-2 control-label">ESI Subcode</label>

                        <div class="col-sm-10">
                          <input type="text" class="form-control input-sm" name="esiNo" id="esiNo" value="@if(@$data['profileData']['accountInfo']->company_esi_id){{$data['profileData']['accountInfo']->esi_number}}@else{{'None'}}@endif" readonly>
                        </div>
                      </div>


                      <div class="form-group">
                        <label class="col-sm-2 control-label">Salary Structure</label>
                        <div class="col-sm-10">
                          <select class="form-control input-sm" name="salaryHeadId">
                          @if(!$data['salaryHeads']->isEmpty())
                            @foreach($data['salaryHeads'] as $salaryHead)  
                              <option value="{{$salaryHead->salary_head_id}}" @if($salaryHead->salary_head_id == @$data['profileData']['accountInfo']->salary_head_id){{"selected"}}@endif>{{$salaryHead->salary_head_name}}</option>
                            @endforeach
                          @endif  
                          </select>
                        </div>  
                      </div>

                      <div class="form-group">
                        <label class="col-sm-2 control-label">Salary Cycle</label>
                        <div class="col-sm-10">
                          <select class="form-control input-sm" name="salaryCycleId">
                          @if(!$data['salaryCycles']->isEmpty())
                            @foreach($data['salaryCycles'] as $salaryCycle)  
                              <option value="{{$salaryCycle->salary_cycle_id}}" @if($salaryCycle->salary_cycle_id == @$data['profileData']['accountInfo']->salary_cycle_id){{"selected"}}@endif>{{$salaryCycle->salary_cycle_name}}</option>
                            @endforeach
                          @endif  
                          </select>
                        </div>  
                      </div>

                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                      <button type="submit" class="btn btn-info" id="accountFormSubmit">Submit</button>
                    </div>
                    <!-- /.box-footer -->
                  </form>
              </div>
              <!-- /.tab-pane -->

              <div class="tab-pane" id="tab_addressDetailsTab">
                @if(session()->has('addressSuccess'))
                  <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    {{ session()->get('addressSuccess') }}
                  </div>
                @endif

                @if ($errors->address->any())
                    <div class="alert alert-danger alert-dismissible">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <ul>
                            @foreach ($errors->address->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                  <div id="noEmployeeAddress" class="alert alert-danger alert-dismissible">
                    <!-- <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> -->
                    {{"Please fill the basic details form for a new employee, or you can edit the profile of an existing user later."}}
                  </div>
                <!-- form start -->
                  <form id="addressDetailsForm" class="form-horizontal" action="{{ route('employees.editAddressDetails') }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="box-body">
                      <span class="text-primary"><em>Present Address</em></span> :-
                      <hr>
                      <div class="form-group">
                        <label for="preHouseNo" class="col-sm-2 control-label">House Number</label>

                        <div class="col-sm-10">
                          <input type="text" class="form-control input-sm" name="preHouseNo" id="preHouseNo" placeholder="House Number" value="{{@$data['profileData']['presentAddress']->house_no}}">
                        </div>
                      </div>

                      <input type="hidden" name="employeeId" value="{{$data['employeeId']}}">

                      <div class="form-group">
                        <label for="preRoadStreet" class="col-sm-2 control-label">Road/Street</label>

                        <div class="col-sm-10">
                          <input type="text" class="form-control input-sm" name="preRoadStreet" id="preRoadStreet" placeholder="Road/Street Name" value="{{@$data['profileData']['presentAddress']->road_street}}">
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="preLocalityArea" class="col-sm-2 control-label">Locality/Area</label>

                        <div class="col-sm-10">
                          <input type="text" class="form-control input-sm" name="preLocalityArea" id="preLocalityArea" placeholder="Locality/Area Name" value="{{@$data['profileData']['presentAddress']->locality_area}}">
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="prePinCode" class="col-sm-2 control-label">Pincode</label>

                        <div class="col-sm-10">
                          <input type="text" class="form-control input-sm" name="prePinCode" id="prePinCode" placeholder="Pincode" value="{{@$data['profileData']['presentAddress']->pincode}}">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="col-sm-2 control-label">Country</label>
                        <div class="col-sm-10">
                            <select class="form-control preCountryId input-sm" name="preCountryId">
                            @if(!$data['countries']->isEmpty())
                              @foreach($data['countries'] as $country)  
                                <option value="{{$country->c_id}}" @if($country->c_id == @$data['profileData']['presentAddress']->country_id){{"selected"}}@endif>{{$country->c_name}}</option>
                              @endforeach
                            @endif  
                            </select>
                        </div>
                        
                      </div>

                      <div class="form-group">
                        <label class="col-sm-2 control-label">State</label>
                        <div class="col-sm-10">
                          <select class="form-control preStateId input-sm" name="preStateId">
                          @if(!$data['states']->isEmpty())
                            @foreach($data['states'] as $state)  
                              <option value="{{$state->s_id}}" @if($state->s_id == @$data['profileData']['presentAddress']->state_id){{"selected"}}@endif>{{$state->s_name}}</option>
                            @endforeach
                          @endif  
                          </select>
                        </div>  
                      </div>

                      <div class="form-group">
                        <label class="col-sm-2 control-label">City</label>
                        <div class="col-sm-10">
                          <select class="form-control preCityId input-sm" name="preCityId">
                          @if(!$data['cities']->isEmpty())
                            @foreach($data['cities'] as $city)  
                              <option value="{{$city->ct_id}}"  @if($city->ct_id == @$data['profileData']['presentAddress']->city_id){{"selected"}}@endif>{{$city->ct_name}}</option>
                            @endforeach
                          @endif  
                          </select>
                        </div>  
                      </div>

                      <hr>
                      <span class="text-primary"><em>Permanent Address</em></span> :-
                      <div class="checkbox pull-right">
                        <label>
                          <input type="checkbox" id="checkboxAbove">same as above
                        </label>
                      </div>
                      <hr>
                      <div class="form-group">
                        <label for="perHouseNo" class="col-sm-2 control-label">House Number</label>

                        <div class="col-sm-10">
                          <input type="text" class="form-control input-sm" name="perHouseNo" id="perHouseNo" placeholder="House Number" value="{{@$data['profileData']['permanentAddress']->house_no}}">
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="perRoadStreet" class="col-sm-2 control-label">Road/Street</label>

                        <div class="col-sm-10">
                          <input type="text" class="form-control input-sm" name="perRoadStreet" id="perRoadStreet" placeholder="Road/Street Name" value="{{@$data['profileData']['permanentAddress']->road_street}}">
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="perLocalityArea" class="col-sm-2 control-label">Locality/Area</label>

                        <div class="col-sm-10">
                          <input type="text" class="form-control input-sm" name="perLocalityArea" id="perLocalityArea" placeholder="Locality/Area Name" value="{{@$data['profileData']['permanentAddress']->locality_area}}">
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="perPinCode" class="col-sm-2 control-label">Pincode</label>

                        <div class="col-sm-10">
                          <input type="text" class="form-control input-sm" name="perPinCode" id="perPinCode" placeholder="Pincode" value="{{@$data['profileData']['permanentAddress']->pincode}}">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="col-sm-2 control-label">Country</label>
                        <div class="col-sm-10">
                          <select class="form-control perCountryId input-sm" name="perCountryId">
                          @if(!$data['countries']->isEmpty())
                            @foreach($data['countries'] as $country)  
                              <option value="{{$country->c_id}}" @if($country->c_id == @$data['profileData']['permanentAddress']->country_id){{"selected"}}@endif>{{$country->c_name}}</option>
                            @endforeach
                          @endif  
                          </select>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="col-sm-2 control-label">State</label>
                        <div class="col-sm-10">
                          <select class="form-control perStateId input-sm" name="perStateId">
                          @if(!$data['states']->isEmpty())
                            @foreach($data['states'] as $state)  
                              <option value="{{$state->s_id}}" @if($state->s_id == @$data['profileData']['permanentAddress']->state_id){{"selected"}}@endif>{{$state->s_name}}</option>
                            @endforeach
                          @endif  
                          </select>
                        </div>  
                      </div>

                      <div class="form-group">
                        <label class="col-sm-2 control-label">City</label>
                        <div class="col-sm-10">
                          <select class="form-control perCityId input-sm" name="perCityId">
                          @if(!$data['cities']->isEmpty())
                            @foreach($data['cities'] as $city)  
                              <option value="{{$city->ct_id}}" @if($city->ct_id == @$data['profileData']['permanentAddress']->city_id){{"selected"}}@endif>{{$city->ct_name}}</option>
                            @endforeach
                          @endif  
                          </select>
                        </div>  
                      </div>

                    </div>
                    <!-- /.box-body -->
                    
                    <div class="box-footer">
                      <button type="submit" class="btn btn-info" id="addressFormSubmit">Submit</button>
                    </div>
                    <!-- /.box-footer -->
                  </form>
              </div>
              <!-- /.tab-pane -->

              <div class="tab-pane" id="tab_historyDetailsTab">
                @if(session()->has('historySuccess'))
                  <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    {{ session()->get('historySuccess') }}
                  </div>
                @endif

                @if ($errors->history->any())
                    <div class="alert alert-danger alert-dismissible">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <ul>
                            @foreach ($errors->history->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                  <div id="noEmployeeHistory" class="alert alert-danger alert-dismissible">
                    <!-- <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> -->
                    {{"Please fill the basic details form for a new employee, or you can edit the profile of an existing user later."}}
                  </div>
                <!-- form start -->
                  <form id="historyDetailsForm" class="form-horizontal" action="{{ route('employees.editHistoryDetails') }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="box-body">
                      <span class="text-primary"><em>Please list your most recent employer first</em></span> :-
                      <hr>
                      <div class="form-group">
                        <label for="fromDate" class="col-sm-2 control-label">From Date</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control input-sm datepicker" id="fromDate" name="fromDate" placeholder="Select date" value="">
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="toDate" class="col-sm-2 control-label">To Date</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control input-sm datepicker" id="toDate" name="toDate" placeholder="Select date" value="">
                        </div>
                      </div>

                      <input type="hidden" name="employeeId" value="{{$data['employeeId']}}">

                      <div class="form-group">
                        <label for="orgName" class="col-sm-2 control-label">Organization Name</label>

                        <div class="col-sm-10">
                          <input type="text" class="form-control input-sm" name="orgName" id="orgName" placeholder="Organization Name">
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="orgPhone" class="col-sm-2 control-label">Organization Phone</label>

                        <div class="col-sm-10">
                          <input type="text" class="form-control input-sm" name="orgPhone" id="orgPhone" placeholder="Organization Phone">
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="orgEmail" class="col-sm-2 control-label">Organization Email</label>

                        <div class="col-sm-10">
                          <input type="text" class="form-control input-sm" name="orgEmail" id="orgEmail" placeholder="Organization Email">
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="responsibilities" class="col-sm-2 control-label">Responsibilities</label>

                        <div class="col-sm-10">
                          <input type="text" class="form-control input-sm" name="responsibilities" id="responsibilities" placeholder="Responsibilities">
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="reportTo" class="col-sm-2 control-label">Report To(Position)</label>

                        <div class="col-sm-10">
                          <input type="text" class="form-control input-sm" name="reportTo" id="reportTo" placeholder="Report To">
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="salaryPerMonth" class="col-sm-2 control-label">Salary Per Month</label>

                        <div class="col-sm-10">
                          <input type="text" class="form-control input-sm" name="salaryPerMonth" id="salaryPerMonth" placeholder="Salary Per Month">
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="perks" class="col-sm-2 control-label">Perks</label>

                        <div class="col-sm-10">
                          <input type="text" class="form-control input-sm" name="perks" id="perks" placeholder="Perks">
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="leavingReason" class="col-sm-2 control-label">Reason For Leaving</label>

                        <div class="col-sm-10">
                          <input type="text" class="form-control input-sm" name="leavingReason" id="leavingReason" placeholder="Reason For Leaving">
                        </div>
                      </div>
                    </div>
                    <!-- /.box-body -->
                    
                    <div class="box-footer">
                      <button type="submit" class="btn btn-info" id="historyFormSubmit">Submit</button>
                    </div>
                    <!-- /.box-footer -->
                  </form>

                  <br>
                  <hr>
                  <div class="box">
                      <div class="box-header">
                        <h3 class="box-title">Employment List</h3>
                      </div>
                      <!-- /.box-header -->
                      <div class="box-body no-padding">
                        <table class="table table-striped table-bordered">
                          <tr>
                            <th style="width: 10%">From Date</th>
                            <th style="width: 10%">To Date</th>
                            <th style="width: 10%">Organization Name</th>
                            <th style="width: 10%">Organization Phone</th>
                            <th style="width: 10%">Organization Email</th>
                            <th style="width: 10%">Responsibilities</th>
                            <th style="width: 10%">Report To</th>
                            <th style="width: 10%">Salary</th>
                            <th style="width: 10%">Perks</th>
                            <th style="width: 10%">Reason For Leaving</th>
                          </tr>
                          @if(!$data['employmentHistories']->isEmpty())
                          @foreach($data['employmentHistories'] as $key => $history)
                          <tr>
                            <td>{{date("m/d/Y",strtotime($history->employment_from_date))}}</td>
                            <td>{{date("m/d/Y",strtotime($history->employment_to_date))}}</td>
                            <td>{{$history->organization_name}}</td>
                            <td>{{$history->organization_phone}}</td>
                            <td>{{$history->organization_email}}</td>
                            <td>{{$history->responsibilities}}</td>
                            <td>{{$history->report_to_position}}</td>
                            <td>{{$history->salary_per_month}}</td>
                            <td>{{$history->perks}}</td>
                            <td>{{$history->reason_for_leaving}}</td>
                          </tr>
                          @endforeach
                          @endif
                          
                        </table>
                      </div>
                      <!-- /.box-body -->
                    </div>
                    <!-- /.box -->  
              </div>
              <!-- /.tab-pane -->

                <div class="tab-pane" id="tab_referenceDetailsTab">
                @if(session()->has('referenceSuccess'))
                  <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    {{ session()->get('referenceSuccess') }}
                  </div>
                @endif

                @if ($errors->reference->any())
                    <div class="alert alert-danger alert-dismissible">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <ul>
                            @foreach ($errors->reference->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                  <div id="noEmployeeReference" class="alert alert-danger alert-dismissible">
                    <!-- <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> -->
                    {{"Please fill the basic details form for a new employee, or you can edit the profile of an existing user later."}}
                  </div>
                <!-- form start -->
                  <form id="referenceDetailsForm" class="form-horizontal" action="{{ route('employees.editReferenceDetails') }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="box-body">
                      <span class="text-primary"><em>Reference 1</em></span> :-
                      <hr>
                      <div class="form-group">
                        <label for="ref1Name" class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control input-sm" id="ref1Name" name="ref1Name" placeholder="Enter name" value="{{@$data['profileData']['reference1']->reference_name}}">
                        </div>
                      </div>

                      <input type="hidden" name="employeeId" value="{{$data['employeeId']}}">

                      <div class="form-group">
                        <label for="ref1Address" class="col-sm-2 control-label">Address</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control input-sm" id="ref1Address" name="ref1Address" placeholder="Enter address" value="{{@$data['profileData']['reference1']->reference_address}}">
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="ref1Phone" class="col-sm-2 control-label">Phone Number</label>

                        <div class="col-sm-10">
                          <input type="text" class="form-control input-sm" name="ref1Phone" id="ref1Phone" placeholder="Enter phone number"  value="{{@$data['profileData']['reference1']->reference_phone}}">
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="ref1Email" class="col-sm-2 control-label">Email</label>

                        <div class="col-sm-10">
                          <input type="text" class="form-control input-sm" name="ref1Email" id="ref1Email" placeholder="Enter email" value="{{@$data['profileData']['reference1']->reference_email}}">
                        </div>
                      </div>

                      <hr>
                      <span class="text-primary"><em>Reference 2</em></span> :-
                      <hr>
                      <div class="form-group">
                        <label for="ref2Name" class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control input-sm" id="ref2Name" name="ref2Name" placeholder="Enter name" value="{{@$data['profileData']['reference2']->reference_name}}">
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="ref2Address" class="col-sm-2 control-label">Address</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control input-sm" id="ref2Address" name="ref2Address" placeholder="Enter address" value="{{@$data['profileData']['reference2']->reference_address}}">
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="ref2Phone" class="col-sm-2 control-label">Phone Number</label>

                        <div class="col-sm-10">
                          <input type="text" class="form-control input-sm" name="ref2Phone" id="ref2Phone" placeholder="Enter phone number" value="{{@$data['profileData']['reference2']->reference_phone}}">
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="ref2Email" class="col-sm-2 control-label">Email</label>

                        <div class="col-sm-10">
                          <input type="text" class="form-control input-sm" name="ref2Email" id="ref2Email" placeholder="Enter email" value="{{@$data['profileData']['reference2']->reference_email}}">
                        </div>
                      </div>
                      

                      
                    </div>
                    <!-- /.box-body -->
                    
                    <div class="box-footer">
                      <button type="submit" class="btn btn-info" id="referenceFormSubmit">Submit</button>
                    </div>
                    <!-- /.box-footer -->
                  </form>
 
              </div>
              <!-- /.tab-pane -->

              <div class="tab-pane" id="tab_securityDetailsTab">
                @if(session()->has('securitySuccess'))
                  <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    {{ session()->get('securitySuccess') }}
                  </div>
                @endif

                @if ($errors->security->any())
                    <div class="alert alert-danger alert-dismissible">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <ul>
                            @foreach ($errors->security->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                  <div id="noEmployeeSecurity" class="alert alert-danger alert-dismissible">
                    <!-- <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> -->
                    {{"Please fill the basic details form for a new employee, or you can edit the profile of an existing user later."}}
                  </div>
                <!-- form start -->
                  <form id="securityDetailsForm" class="form-horizontal" action="{{ route('employees.editSecurityDetails') }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="box-body">
                      <span class="text-primary"><em>Please enter employee security details(if any)</em></span> :-
                      <hr>
                      <div class="form-group">
                        <label for="ddDate" class="col-sm-2 control-label">DD Date</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control input-sm datepicker" id="ddDate" name="ddDate" placeholder="Select date" value="{{date('m/d/Y',strtotime(@$data['profileData']['securityInfo']->security_dd_date))}}">
                        </div>
                      </div>

                      <input type="hidden" name="employeeId" value="{{$data['employeeId']}}">

                      <div class="form-group">
                        <label for="ddNo" class="col-sm-2 control-label">DD Number</label>

                        <div class="col-sm-10">
                          <input type="text" class="form-control input-sm" name="ddNo" id="ddNo" placeholder="DD Number" value="{{@$data['profileData']['securityInfo']->security_dd_no}}">
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="bankName" class="col-sm-2 control-label">Bank Name</label>

                        <div class="col-sm-10">
                          <input type="text" class="form-control input-sm" name="bankName" id="bankName" placeholder="Bank Name" value="{{@$data['profileData']['securityInfo']->security_bank_name}}">
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="accNo" class="col-sm-2 control-label">Account Number</label>

                        <div class="col-sm-10">
                          <input type="text" class="form-control input-sm" name="accNo" id="accNo" placeholder="Account Number" value="{{@$data['profileData']['securityInfo']->security_account_no}}">
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="receiptNo" class="col-sm-2 control-label">Receipt Number</label>

                        <div class="col-sm-10">
                          <input type="text" class="form-control input-sm" name="receiptNo" id="receiptNo" placeholder="Receipt Number" value="{{@$data['profileData']['securityInfo']->security_receipt_no}}">
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="amount" class="col-sm-2 control-label">Amount</label>

                        <div class="col-sm-10">
                          <input type="text" class="form-control input-sm" name="amount" id="amount" placeholder="Amount" value="{{@$data['profileData']['securityInfo']->security_amount}}">
                        </div>
                      </div>
                      
                    </div>
                    <!-- /.box-body -->
                    
                    <div class="box-footer">
                      <button type="submit" class="btn btn-info" id="securityFormSubmit">Submit</button>
                    </div>
                    <!-- /.box-footer -->
                  </form>
                   
              </div>
              <!-- /.tab-pane -->

            </div>
            <!-- /.tab-content -->
          </div>
          <!-- nav-tabs-custom -->
        </div>
        <!-- /.col -->
          
      </div>
      <!-- /.row -->
      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        
      </div>
      <!-- /.row (main row) -->

    </section>
    <!-- /.content -->

    <div class="modal fade" id="uploadModal">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Document Upload Form</h4>
            </div>
            <div class="modal-body">
              <form id="documentDetailsForm" action="{{ route('employees.editDocumentDetails') }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                  <div class="box-body">
                    
                    <div class="form-group">
                      <label for="docTypeName" class="docType">Document Type</label>
                      <input type="text" class="form-control" id="docTypeName" name="docTypeName" value="" readonly>
                    </div>

                    <input type="hidden" name="docTypeId" id="docTypeId">
                    <input type="hidden" name="employeeId" value="{{$data['employeeId']}}">

                    <div class="docId2">
                      <input type="file" id="docs2" name="docs2[]" multiple>  
                    </div>
                                 
                  </div>
                  <!-- /.box-body -->
                  <br>

                  <div class="box-footer">
                    <button type="submit" class="btn btn-primary" id="documentFormSubmit">Submit</button>
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
  <script src="{{asset('public/admin_assets/plugins/validations/jquery.validate.js')}}"></script>
  <script src="{{asset('public/admin_assets/plugins/validations/additional-methods.js')}}"></script>

  <script type="text/javascript">

    $('.uploadFile').click(function(){
      var docTypeId = $(this).data("doctypeid");
      var docTypeName = $(this).data("doctypename");

      $("#docTypeId").val(docTypeId);
      $("#docTypeName").val(docTypeName);
      
      $('#uploadModal').modal('show');

    });

    var defSalutation = "{{$data['profileData']['basic']->salutation}}";
    $(".salutation").val(defSalutation);

    var defMarital = "{{$data['profileData']['basic']->marital_status}}";
    $(".maritalStatus").val(defMarital);

    if(defMarital == "Unmarried"){
      $(".spouseName").hide();
    }

    var experience = "{{$data['profileData']['basic']->experience_ym}}";
    experience = experience.split("-");

    $(".expYears").val(experience[0]);
    $(".expMonths").val(experience[1]);

    var empVerify = "{{@$data['profileData']['basic']->employment_verification}}";
    var polVerify = "{{@$data['profileData']['basic']->police_verification}}";
    var addVerify = "{{@$data['profileData']['basic']->address_verification}}";

    if(empVerify == '1'){
      $("#employmentVerification").prop('checked', true);
    }

    if(polVerify == '1'){
      $("#policeVerification").prop('checked', true);
    }

    if(addVerify == '1'){
      $("#addressVerification").prop('checked', true);
    }

    $("#noEmployeeProfile").hide();
    $("#noEmployeeDocument").hide();
    $("#noEmployeeAddress").hide();
    $("#noEmployeeAccount").hide();
    $("#noEmployeeHistory").hide();
    $("#noEmployeeReference").hide();
    $("#noEmployeeSecurity").hide();

    var allowFormSubmit = {referralCode: 1, email: 1, mobile: 1, marriageDate: 1, birthDate: 1};

    $("div.alert-dismissible").fadeOut(6000);

    $("#basicDetailsForm").validate({
      rules :{
          "employeeName" : {
              required : true,
              maxlength: 20,
              minlength: 3,
              spacespecial: true,
              lettersonly: true
          },
          "employeeXeamCode" : {
              required : true,
              maxlength: 20,
              minlength: 6,
              spacespecial: true
          },
          "fatherName" : {
              required : true,
              maxlength: 20,
              minlength: 3,
              spacespecial: true,
              lettersonly: true
          },
          "motherName" : {
              required : true,
              maxlength: 20,
              minlength: 3,
              spacespecial: true,
              lettersonly: true
          },
          "email" : {
              required : true,
              email: true,
          },
          "password" : {
              required : true,
              nowhitespace: true,
              maxlength: 20,
              minlength: 6
          },
          "permissionIds[]" : {
              required : true,
          },
          "mobile" : {
              required : true,
              digits: true,
              exactlength : 10
          },
          "altMobile" : {
              digits: true,
              exactlength : 10
          },
          "birthDate" : {
              required : true,
          },
          "joiningDate" : {
              required : true,
          },
          "marriageDate" : {
              required : true,
          },
          "spouseName" : {
              required : true,
              maxlength: 20,
              minlength: 3,
              spacespecial: true,
              lettersonly: true
          },
          "roleId" : {
             required : true
          },
          "departmentId" : {
             required : true
          }

      },
      messages :{
          "employeeName" : {
              required : 'Please enter employee name.',
              maxlength: 'Maximum 20 characters are allowed.',
              minlength: 'Minimum 3 characters are allowed.'
          },
          "employeeXeamCode" : {
              required : 'Please enter employee xeam code.',
              maxlength: 'Maximum 20 characters are allowed.',
              minlength: 'Minimum 6 characters are allowed.'
          },
          "fatherName" : {
              required : "Please enter father's name.",
              maxlength: 'Maximum 20 characters are allowed.',
              minlength: 'Minimum 3 characters are allowed.'
          },
          "motherName" : {
              required : "Please enter mother's name.",
              maxlength: 'Maximum 20 characters are allowed.',
              minlength: 'Minimum 3 characters are allowed.'
          },
          "spouseName" : {
              required : "Please enter spouse's name.",
              maxlength: 'Maximum 20 characters are allowed.',
              minlength: 'Minimum 3 characters are allowed.'
          },
          "email" : {
              required : 'Please enter email.',
          },
          "password" : {
              required : 'Please enter password.',
              maxlength: 'Maximum 20 characters are allowed.',
              minlength: 'Minimum 6 characters are allowed.'
          },
          "permissionIds[]" : {
              required : 'Please select a permission.',
          },
          "mobile" : {
              required : 'Please enter mobile number.', 
          },
          "birthDate" : {
              required : 'Please select date of birth.',
          },
           "joiningDate" : {
              required : 'Please select date of joining.',
          },
          "marriageDate" : {
              required : 'Please select date of marriage.',
          },
          "roleId" : {
             required : 'Please select a designation.'
          },
          "departmentId" : {
             required : 'Please select a department.'
          }
      }
    }); 

    $("#securityDetailsForm").validate({
        rules :{
          "ddDate" : {
              required : true,
          },
          "ddNo" : {
              required : true,
          },
          "bankName" : {
              required : true,
          },
          "accNo" : {
              required : true,
          },
          "receiptNo" : {
              required : true,
          },
          "amount" : {
              required : true,
          }

      },
      messages :{
         "ddDate" : {
              required : 'Please select a date.',
          },
          "ddNo" : {
              required : 'Please enter DD number.',
          },
          "bankName" : {
              required : 'Please enter bank name.',
          },
          "accNo" : {
              required : 'Please enter account number.',
          },
          "receiptNo" : {
              required : 'Please enter receipt number.',
          },
          "amount" : {
              required : 'Please enter amount.',
          }
      }
    });

    $("#profileDetailsForm").validate({
        rules :{
          "phone" : {
              required : true,
              digits: true,
              exactlength : 10
          },
          "profilePic" : {
              accept: "image/*",
          },
          "skillIds[]" : {
              required : true,
          },
          "languageIds[]" : {
              required : true,
          },
          "employeeIds[]" : {
              required : true,
          },
          "nominee" : {
              required : true,
              maxlength: 20,
              minlength: 3,
              spacespecial: true,
              lettersonly: true
          },
          "relation" : {
              required : true,
          },
          "locationId" : {
             required : true
          },
          "projectId" : {
             required : true
          },
          "shiftTimingId" : {
             required : true
          },
          "probationPeriodId" : {
             required : true
          },
          "expYrs" : {
             required : true
          },
          "expMns" : {
             required : true
          }

      },
      messages :{
          "phone" : {
              required : 'Please enter phone number.',
          },
          "profilePic" : {
              accept : 'Please select a valid image format.',
          },
          "skillIds[]" : {
              required : 'Please select a skill.',
          },
          "languageIds[]" : {
              required : 'Please select a language.',
          },
          "employeeIds[]" : {
              required : 'Please select a reporting manager.'
          },
          "nominee" : {
              required : 'Please enter nominee name.',
              maxlength: 'Maximum 20 characters are allowed.',
              minlength: 'Minimum 3 characters are allowed.'
          },
          "relation" : {
              required : 'Please enter relation with nominee.',
          },
          "locationId" : {
             required : 'Please select a location.'
          },
          "projectId" : {
             required : 'Please select a project.'
          },
          "shiftTimingId" : {
             required : 'Please select a shift timing.'
          },
          "probationPeriodId" : {
             required : 'Please select a probation period.'
          },
          "expYrs" : {
             required : 'Please select a experience year.'
          },
          "expMns" : {
             required : 'Please select a experience month.'
          }
      }
    });

    $("#accountDetailsForm").validate({
        rules :{
          "adhaar" : {
              required : true,
              digits: true,
              exactlength : 12
          },
          "panNo" : {
              required : true,
              exactlength : 10,
              checkpanno : true
          },
          "empEsiNo":{
            digits: true,
            exactlength : 10 
          },
          "prevEmpEsiNo":{
            digits: true,
            exactlength : 10
          },
          "uanNo" : {
              required : true,
              digits: true,
              exactlength : 12
          },
          "prevUanNo":{
              digits: true,
              exactlength : 12
          },
          "accHolderName" : {
              required : true,
              maxlength: 20,
              minlength: 3,
              spacespecial: true,
              lettersonly: true
          },
          "bankAccNo" : {
              required : true,
              digits : true
          },
          "ifsc" : {
              required : true,
              checkpanno: true,
              exactlength : 11
          },
          "pfNoDepartment" : {
              required : true,
              digits: true
          },
          "empDispensary":{
            alphanumeric: true
          },
          "companyId":{
            required: true
          }

      },
      messages :{
          "adhaar" : {
              required : 'Please enter adhaar number.',
          },
          "panNo" : {
              required : 'Please enter pan number.',
          },
          "uanNo" : {
              required : 'Please enter uan number.',
          },
          "accHolderName" : {
              required : 'Please enter account holder name.',
              maxlength: 'Maximum 20 characters are allowed.',
              minlength: 'Minimum 3 characters are allowed.'
          },
          "bankAccNo" : {
              required : 'Please enter bank account number.',
          },
          "ifsc" : {
              required : 'Please enter ifsc code.',
          },
          "pfNoDepartment" : {
              required : 'Please enter pf number for department file.',
          },
          "companyId" : {
              required : 'Please select employee company.',
          }
      }
    });

    $("#addressDetailsForm").validate({
        rules :{
          "preHouseNo" : {
              required : true,
          },
          "preRoadStreet" : {
              required : true,
              alphanumeric : true
          },
          "preLocalityArea" : {
              required : true,
              alphanumeric : true
          },
          "perHouseNo" : {
              required : true,
          },
          "perRoadStreet" : {
              required : true,
              alphanumeric : true
          },
          "perLocalityArea" : {
              required : true,
              alphanumeric : true
          },
          "perPinCode" : {
              required : true,
              digits : true
          },
          "prePinCode" : {
              required : true,
              digits : true
          }

      },
      messages :{
          "preHouseNo" : {
              required : 'Please enter house number.',
          },
          "preRoadStreet" : {
              required : 'Please enter road/street name.',
          },
          "preLocalityArea" : {
              required :'Please enter locality/area name.',
          },
          "perHouseNo" : {
              required : 'Please enter house number.',
          },
          "perRoadStreet" : {
              required : 'Please enter road/street name.',
          },
          "perLocalityArea" : {
              required : 'Please enter locality/area name.',
          },
          "perPinCode" : {
              required : 'Please enter pincode.',
          },
          "prePinCode" : {
              required : 'Please enter pincode.',
          }
      }
    });

    $("#documentDetailsForm").validate({
        rules :{
          "docs2[]" : {
              required: true,
              extension: "jpeg|jpg|png|pdf|doc"
          }
      },
      messages :{
          "docs2[]" : {
              required: 'Please select a file',
              extension : 'Please select a file in jpg, jpeg, png, pdf or doc format only.'
          },
      }
    });

    $("#historyDetailsForm").validate({
        rules :{
          "fromDate" : {
              required : true,
          },
          "toDate" : {
              required : true,
          },
          "orgName" : {
              required : true,
              spacespecial : true
          },
          "orgPhone" : {
              required : true,
              digits : true,
              exactlength : 10
          },
          "orgEmail" : {
              required : true,
              email : true
          },
          "responsibilities" : {
              required : true,
          },
          "reportTo" : {
              required : true,
          },
          "salaryPerMonth" : {
              required : true,
              digits : true
          },
          "perks" : {
              required : true,
          },
          "leavingReason" : {
              required : true,
              spacespecial : true
          }

      },
      messages :{
          "fromDate" : {
              required : 'Please select from date.',
          },
          "toDate" : {
              required : 'Please select to date.',
          },
          "orgName" : {
              required : 'Please enter organization name.',
          },
          "orgPhone" : {
              required : 'Please enter organization phone number.',
          },
          "orgEmail" : {
              required : 'Please enter organization email.',
          },
          "responsibilities" : {
              required : 'Please enter responsibilities.',
          },
          "reportTo" : {
              required : "Please enter the person's name you reported to.",
          },
          "salaryPerMonth" : {
              required : "Please enter the salary per month.",
          },
          "perks" : {
              required : "Please enter the perks.",
          },
          "leavingReason" : {
              required : "Please enter the reason for leaving.",
          }

      }
    });

    $("#referenceDetailsForm").validate({
        rules :{
          "ref1Name" : {
              required : true,
          },
          "ref1Address" : {
              required : true,
          },
          "ref1Email" : {
              required : true,
              email : true 
          },
          "ref1Phone" : {
              required : true,
              digits : true
          },
          "ref2Email" : {
              required : true,
              email : true
          },
          "ref2Name" : {
              required : true,
          },
          "ref2Address" : {
              required : true,
          },
          "ref2Phone" : {
              required : true,
              digits : true
          }

      },
      messages :{
          "ref1Name" : {
              required : 'Please enter name.',
          },
          "ref1Phone" : {
              required : 'Please enter phone number.',
          },
          "ref1Email" : {
              required : 'Please enter email.',
          },
          "ref1Address" : {
              required : 'Please enter address.',
          },
          "ref2Name" : {
              required : 'Please enter name.',
          },
          "ref2Phone" : {
              required : 'Please enter phone number.',
          },
          "ref2Email" : {
              required : 'Please enter email.',
          },
          "ref2Address" : {
              required : 'Please enter address.',
          }

      }
    });

    $.validator.addMethod("checkpanno", function(value, element) {
    return this.optional(element) || /^[A-Za-z][A-Za-z\d]*$/i.test(value);
    }, "Please enter only characters and digits.");

    $.validator.addMethod("email", function(value, element) {
    return this.optional(element) || /^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$/i.test(value);
    }, "Please enter a valid email address.");

    $.validator.addMethod("spacespecial", function(value, element) {
      return this.optional(element) || /^[a-zA-Z0-9-,]+(\s{0,1}[a-zA-Z0-9-, ])*$/i.test(value); 
    },"Please do not start with space or include special characters.");

    $.validator.addMethod( "nowhitespace", function( value, element ) {
      return this.optional( element ) || /^\S+$/i.test( value );
    }, "No white space please." );

    $.validator.addMethod("lettersonly", function(value, element) {
    return this.optional(element) || /^[a-z," "]+$/i.test(value);
    }, "Please enter only letters and spaces");

    jQuery.validator.addMethod("exactlength", function(value, element, param) {
       return this.optional(element) || value.length == param;
    }, $.validator.format("Please enter exactly {0} characters."));
      
  </script>

  <script type="text/javascript">
    var tabName = "{{@$data['tabName']}}";
    var lastInsertedEmployeee = "{{$lastInsertedEmployeee}}";
    console.log(lastInsertedEmployeee);
    
    $(document).ready(function(){

      $('.nav-tabs a[href="#tab_'+tabName+'"]').tab('show');

      var defaultCompanyId = $('.company').val();
      var companyPfId = "{{@$data['profileData']['accountInfo']->company_pf_id}}";

      //console.log("pf: "+companyPfId);

      if(companyPfId){

      }else{
          $.ajax({
            type: 'POST',
            url: "{{ url('/employees/getCompanyTanPf') }}",
            data: {companyId: defaultCompanyId},
            success: function (result) {
              if(result.pfNo != ""){
                $("#pfNo").val(result.pfNo);
              }else{
                $("#pfNo").val("None");
              }

              if(result.tanNo != ""){
                $("#tanNo").val(result.tanNo);
              }else{
                $("#tanNo").val("None");
              }

              $("#certificateNo").val("None");

              $("#esiNo").val("None");
            }
          });
      }

      $('.company').on("change",function(){
        var companyId = $(this).val();

        $.ajax({
        type: 'POST',
        url: "{{ url('/employees/getCompanyTanPf') }}",
        data: {companyId: companyId},
        success: function (result) {
          if(result.pfNo != ""){
            $("#pfNo").val(result.pfNo);
          }else{
            $("#pfNo").val("None");
          }

          if(result.tanNo != ""){
            $("#tanNo").val(result.tanNo);
          }else{
            $("#tanNo").val("None");
          }

          $("#certificateNo").val("None");
          $('.ptState').val("0");

          $("#esiNo").val("None");
          $('.esiLocation').val("0");
        }
      });
      });


      $('.maritalStatus').click(function(){
        var marStatus = $(this).val();
        if(marStatus == "Unmarried"){
          $(".spouseName").hide();
        }else{
          $(".spouseName").show();
        }
      });

      $('.ptState').click(function(){
        var ptStateId = $(this).val();
        var companyId = $('.company').val();

        if(ptStateId != '0'){
          $.ajax({
            type: 'POST',
            url: "{{ url('/employees/getPtCertificateNo') }}",
            data: {companyId: companyId,stateId: ptStateId},
            success: function (result) {
              if(result.certificateNo != ""){
                $("#certificateNo").val(result.certificateNo);
              }else{
                $("#certificateNo").val("None");
              }
            }
          });
        }else{
          $("#certificateNo").val("None");
        }
      });

      $('.esiLocation').click(function(){
        var esiLocationId = $(this).val();
        var companyId = $('.company').val();

        if(esiLocationId != '0'){
          $.ajax({
            type: 'POST',
            url: "{{ url('/employees/getEsiNo') }}",
            data: {companyId: companyId,locationId: esiLocationId},
            success: function (result) {
              if(result.esiNo != ""){
                $("#esiNo").val(result.esiNo);
              }else{
                $("#esiNo").val("None");
              }
            }
          });
        }else{
          $("#esiNo").val("None");
        }
      });

      $(".checkAjax").on("change",function(event){
          var referralCode = $("#referralCode").val();
          var email = $("#email").val();
          var mobile = $("#mobile").val();
          console.log(email);
          console.log(mobile);
          console.log(referralCode);
              
              $.ajax({
                type: 'POST',
                url: "{{ url('/employees/checkUnique') }}",
                data: {referralCode: referralCode,email: email,mobile: mobile},
                success: function (result) {
                  console.log(result);

                  if(result.referralMatch == "yes"){
                    $(".checkReferral").removeClass("text-warning");
                    $(".checkReferral").addClass("text-success").text("Referral code matched successfully.");
                    allowFormSubmit.referralCode = 1;  

                  }else if(result.referralMatch == "no"){
                    $(".checkReferral").removeClass("text-success");
                    $(".checkReferral").addClass("text-warning").text("Referral code does not matches.");
                    allowFormSubmit.referralCode = 0;

                  }else if(result.referralMatch == "blank"){
                    $(".checkReferral").text("");
                    allowFormSubmit.referralCode = 1;
                  }

                  if(result.emailUnique == "no"){
                    $(".checkEmail").addClass("text-warning").text("Email already exists.");
                    allowFormSubmit.email = 0;

                  }else if(result.emailUnique == "yes"){
                    $(".checkEmail").text("");
                    allowFormSubmit.email = 1;

                  }else if(result.emailUnique == "blank"){
                    $(".checkEmail").text("");
                    allowFormSubmit.email = 0;
                  }

                  if(result.mobileUnique == "no"){
                    $(".checkMobile").addClass("text-warning").text("Mobile already exists.");
                    allowFormSubmit.mobile = 0;

                  }else if(result.mobileUnique == "yes"){
                    $(".checkMobile").text("");
                    allowFormSubmit.mobile = 1;

                  }else if(result.mobileUnique == "blank"){
                    $(".checkMobile").text("");
                    allowFormSubmit.mobile = 0;
                  }
                }
              });
      });

      $("#basicFormSubmit").click(function(){
        console.log(allowFormSubmit);

          if(allowFormSubmit.mobile == 1 && allowFormSubmit.email == 1 && allowFormSubmit.referralCode == 1 && allowFormSubmit.marriageDate == 1 && allowFormSubmit.birthDate == 1){
            $("#basicDetailsForm").submit();
          }else{
            return false;
          }
      });

      $("#profileFormSubmit").click(function(){
          if(lastInsertedEmployeee != "0"){
            $("#noEmployeeProfile").hide();
            $("#profileDetailsForm").submit();
          }else{
            $("#noEmployeeProfile").show();
            $("#noEmployeeProfile").fadeOut(6000);
            return false;
          }
      });

      $("#documentFormSubmit").click(function(){
          if(lastInsertedEmployeee != "0"){
            $("#noEmployeeDocument").hide();
            $("#documentDetailsForm").submit();
          }else{
            $('#uploadModal').modal('hide');
            $("#noEmployeeDocument").show();
            $("#noEmployeeDocument").fadeOut(6000);
            return false;
          }
      });

      $("#addressFormSubmit").click(function(){
          if(lastInsertedEmployeee != "0"){
            $("#noEmployeeAddress").hide();
            $("#addressDetailsForm").submit();
          }else{
            $("#noEmployeeAddress").show();
            $("#noEmployeeAddress").fadeOut(6000);
            return false;
          }
      });

      $("#accountFormSubmit").click(function(){
          if(lastInsertedEmployeee != "0"){
            $("#noEmployeeAccount").hide();
            $("#accountDetailsForm").submit();
          }else{
            $("#noEmployeeAccount").show();
            $("#noEmployeeAccount").fadeOut(6000);
            return false;
          }
      });

      $("#historyFormSubmit").click(function(){
          if(lastInsertedEmployeee != "0"){
            $("#noEmployeeHistory").hide();
            $("#historyDetailsForm").submit();
          }else{
            $("#noEmployeeHistory").show();
            $("#noEmployeeHistory").fadeOut(6000);
            return false;
          }
      });

      $("#referenceFormSubmit").click(function(){
          if(lastInsertedEmployeee != "0"){
            $("#noEmployeeReference").hide();
            $("#referenceDetailsForm").submit();
          }else{
            $("#noEmployeeReference").show();
            $("#noEmployeeReference").fadeOut(6000);
            return false;
          }
      });

      $("#securityFormSubmit").click(function(){
          if(lastInsertedEmployeee != "0"){
            $("#noEmployeeSecurity").hide();
            $("#securityDetailsForm").submit();
          }else{
            $("#noEmployeeSecurity").show();
            $("#noEmployeeSecurity").fadeOut(6000);
            return false;
          }
      });

      $('#checkboxAbove').change(function() {
          if($(this).is(":checked")) {
            $("#perHouseNo").val($("#preHouseNo").val());
            //$("#perHouseName").val($("#preHouseName").val());
            $("#perRoadStreet").val($("#preRoadStreet").val());
            $("#perLocalityArea").val($("#preLocalityArea").val());
            $("#perPinCode").val($("#prePinCode").val());

            $(".perCountryId").val($('.preCountryId').val());
            $(".perStateId").val($('.preStateId').val());
            $(".perCityId").val($('.preCityId').val());
          }else{
            $("#perHouseNo").val("");
            //$("#perHouseName").val("");
            $("#perRoadStreet").val("");
            $("#perLocalityArea").val("");
            $("#perPinCode").val("");

            $(".perCountryId").val($('.preCountryId').val());
            $(".perStateId").val($('.preStateId').val());
            $(".perCityId").val($('.preCityId').val());
          }
                
      });

         

    });

  </script>

  <script type="text/javascript">
   var today = new Date();
   var yesterday = moment().subtract(1, 'days')._d;
   
   //Date picker
    $("#birthDate").datepicker({
      maxDate: yesterday,
      autoclose: true,
      orientation: "bottom"
    });

    $("#marriageDate").datepicker({
      maxDate: yesterday,
      autoclose: true,
      orientation: "bottom"
    });

    $("#joiningDate").datepicker({
      autoclose: true,
      orientation: "bottom"
    });

    $("#birthDate").on('keyup',function(){
      var date = $(this).val();
      if(Date.parse(date) > Date.parse(yesterday)){
        allowFormSubmit.birthDate = 0;
        $(".birthDateErrors").text("Please select a valid date.")
        $(".birthDateErrors").show();
      }else{
        allowFormSubmit.birthDate = 1;
        $(".birthDateErrors").text("");
        $(".birthDateErrors").hide("");
      }
    });

    $("#marriageDate").on('keyup',function(){
      var date = $(this).val();
      if(Date.parse(date) > Date.parse(yesterday)){
        allowFormSubmit.marriageDate = 0;
        $(".marriageDateErrors").text("Please select a valid date.")
        $(".marriageDateErrors").show();
      }else{
        allowFormSubmit.marriageDate = 1;
        $(".marriageDateErrors").text("");
        $(".marriageDateErrors").hide("");
      }
    });
      
    
  </script>

  @endsection