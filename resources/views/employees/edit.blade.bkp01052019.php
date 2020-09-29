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
        @can('approve-employee')
          @if(!empty($data['empApproveUrl']))
          <small style="padding-left: 30px;" id="approveEmployeeLink"><a href='javascript:void(0)' class="btn btn-info approveTheEmployee">Approve Employee</a></small>
          @endif    
        @endcan  

        <small style="padding-left: 30px;" class="empCreator">Created By: <span class="label label-success" id="empCreator">{{@$data['creatorName']}}</span></small>
        <small style="padding-left: 30px;" class="empApprover">Approved By: <span class="label label-success" id="empApprover">{{@$data['approverName']}}</span></small>
      
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
              <li id="projectDetailsTab" class=""><a href="#tab_projectDetailsTab" data-toggle="tab">Project Details</a></li>
              <li id="documentDetailsTab" class=""><a href="#tab_documentDetailsTab" data-toggle="tab">Document Upload</a></li>
              <li id="accountDetailsTab" class=""><a href="#tab_accountDetailsTab" data-toggle="tab">HR Details</a></li>
              <li id="addressDetailsTab" class=""><a href="#tab_addressDetailsTab" data-toggle="tab">Contact Details</a></li>
              <li id="historyDetailsTab" class=""><a href="#tab_historyDetailsTab" data-toggle="tab">Employment History</a></li>
              <li id="referenceDetailsTab" class=""><a href="#tab_referenceDetailsTab" data-toggle="tab">Reference Details</a></li>
              <li id="securityDetailsTab" class=""><a href="#tab_securityDetailsTab" data-toggle="tab">Security Details</a></li>
              
            </ul>
                                                    <!-- Tab content starts here -->
            <div class="tab-content">
                                                   <!-- Basic Details starts here -->
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
                    <label for="employeeName" class="col-md-2 control-label basic-detail-label">Employee Name</label>
                    <div class="col-md-1 salu-change">
                      <select class="form-control input-sm basic-detail-input-style" name="salutation">
                        <option value="Mr.">Mr.</option>  
                        <option value="Ms.">Ms.</option>  
                        <option value="Mrs.">Mrs.</option>  
                      </select>
                    </div>

                  <div class="names123">
                    <div class="col-md-3 col-sm-4 first-name-basic">
                      <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style text-capitalize" name="employeeName" id="employeeName" placeholder="Please Enter Alphabets In First Name" value="{{@$data['profileData']['basic']->first_name}}">
                    </div>

                    <div class="col-md-3 col-sm-4 middle-name-basic">
                      <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style text-capitalize" name="employeeMiddleName" id="employeeMiddleName" placeholder="Please Enter Alphabets In Middle Name" value="{{@$data['profileData']['basic']->middle_name}}">
                    </div>

                    <div class="col-md-3 col-sm-4 last-name-basic">
                      <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style text-capitalize" name="employeeLastName" id="employeeLastName" placeholder="Please Enter Alphabets In Last Name" value="{{@$data['profileData']['basic']->last_name}}">
                    </div>
                  </div>
                </div>
               
                <input type="hidden" name="employeeId" value="{{$data['employeeId']}}">


                <div class="form-group form-sidechange">
                    <div class="row">
                        <div class="col-md-6 basic-detail-left">
                          <div class="row field-changes-below">
                            <label for="fatherName" class="col-md-4 control-label basic-detail-label">Father's Name</label>

                            <div class="col-md-8">
                              <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style text-capitalize" name="fatherName" id="fatherName" placeholder="Please Enter Alphabets In Father's Name." value="{{@$data['profileData']['basic']->father_name}}">
                            </div>
                          </div>

                          <div class="row field-changes-below">
                            <label for="motherName" class="col-md-4 control-label basic-detail-label">Mother's Name</label>

                            <div class="col-md-8">
                              <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style text-capitalize" name="motherName" id="motherName" placeholder="Please Enter Alphabets In Mother's Name." value="{{@$data['profileData']['basic']->mother_name}}">
                            </div>
                          </div>

                          <div class="row field-changes-below">
                            <label for="oldXeamCode" class="col-md-4 control-label basic-detail-label">Employee ID</label>

                            <div class="col-md-8">
                              <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="oldXeamCode" id="oldXeamCode" placeholder="Please Enter Employee's ID." value="{{@$data['profileData']['basic']->old_xeam_code}}" readonly>
                            </div>
                          </div>

                          <div class="row field-changes-below">
                            <label for="employeeXeamCode" class="col-md-4 control-label basic-detail-label">Employee Code</label>

                            <div class="col-md-8">
                              <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="employeeXeamCode" id="employeeXeamCode" placeholder="Please Enter Employee's Code." value="{{@$data['profileData']['basic']->emp_xeam_code}}" readonly>
                            </div>
                          </div>

                          <div class="row field-changes-below">
                            <label for="email" class="col-md-4 control-label basic-detail-label">Official Email</label>

                            <div class="col-md-8">
                              <input autocomplete="off" type="email" class="form-control checkAjax input-sm basic-detail-input-style" id="email" name="email" placeholder="Please Enter Valid Email Id." value="{{@$data['profileData']['basic']->email}}" readonly>
                              <span class="checkEmail"></span>
                            </div>
                          </div>

                          <div class="row field-changes-below">
                            <label for="email" class="col-md-4 control-label basic-detail-label">Personal Email</label>

                            <div class="col-md-8">
                              <input autocomplete="off" type="email" class="form-control input-sm basic-detail-input-style" id="personalEmail" name="personalEmail" placeholder="Please Enter Valid Email Id." value="{{@$data['profileData']['basic']->personal_email}}">                              
                            </div>
                          </div>

                          <div class="row field-changes-below">
                            <label for="mobile" class="col-md-4 control-label basic-detail-label">Mobile Number</label>

                            <div class="col-md-3 salu-change">
                                <select class="form-control input-sm basic-detail-input-style" name="mobileStdId" disabled>
                                    @if(!$data['countries']->isEmpty())
                                  @foreach($data['countries'] as $country)  
                                      <option value="{{$country->c_id}}" @if(@$country->c_id == @$data['profileData']['basic']->mobile_std_id){{'selected'}}@endif>(+{{@$country->c_ph_code}}) {{@$country->c_iso3}}</option>
                                  @endforeach
                                  @endif  
                                </select>
                            </div>

                            <div class="col-md-5">
                              <input autocomplete="off" type="text" class="form-control checkAjax input-sm basic-detail-input-style" id="mobile" name="mobile" placeholder="Please Enter 10 Digits Numeric Value In Mobile Number." value="{{@$data['profileData']['basic']->mobile}}" readonly>
                              <span class="checkMobile"></span>
                            </div>
                          </div>

                          <div class="row field-changes-below">
                            <label for="altMobile" class="col-md-4 control-label basic-detail-label">Alternative Mobile Number</label>

                            <div class="col-md-3 salu-change">
                                <select class="form-control input-sm basic-detail-input-style" name="altMobileStdId">
                                    @if(!$data['countries']->isEmpty())
                                  @foreach($data['countries'] as $country)  
                                      <option value="{{$country->c_id}}" @if(@$country->c_id == @$data['profileData']['basic']->alt_mobile_std_id){{'selected'}}@endif>(+{{@$country->c_ph_code}}) {{@$country->c_iso3}}</option>
                                  @endforeach
                                  @endif  
                                </select>
                            </div>

                            <div class="col-md-5">
                              <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" id="altMobile" name="altMobile" placeholder="Please Enter 10 Digits Numberic Value In Alternative Mobile Number." value="{{@$data['profileData']['basic']->alt_mobile}}">
                            </div>
                          </div>

                          <div class="row field-changes-below">
                            <label for="referral_code" class="col-md-4 control-label basic-detail-label">Referral Code</label>

                            <div class="col-md-8">
                              <input autocomplete="off" type="text" class="form-control checkAjax input-sm basic-detail-input-style" id="referralCode" name="referralCode" placeholder="Please Enter Employee's Referral Code." value="{{@$data['profileData']['basic']->referral_code}}" readonly>
                              <span class="checkReferral"></span>
                            </div>
                          </div>

                              <div class="row field-changes-below">
                                <label class="col-md-4 control-label basic-detail-label">Qualifications</label>
                                <div class="col-md-8">
                                  <select class="form-control select2 input-sm basic-detail-input-style" name="qualificationIds[]" multiple="multiple" style="width: 100%;">
                                  @if(!$data['qualifications']->isEmpty())
                                    @foreach($data['qualifications'] as $qualification)  
                                      <option value="{{$qualification->q_id}}" @if(in_array($qualification->q_id,@$data['profileData']['selectedQualifications'])){{"selected"}}@endif>{{$qualification->qualification_name}}</option>
                                    @endforeach
                                  @endif  
                                  </select>
                                </div>  
                              </div>
                              
                              <div class="row field-changes-below">
                                <label class="col-md-4 control-label basic-detail-label">Skills</label>
                                <div class="col-md-8">
                                  <select class="form-control select2 input-sm basic-detail-input-style" name="skillIds[]" multiple="multiple" style="width: 100%;">
                                  @if(!$data['skills']->isEmpty())
                                    @foreach($data['skills'] as $skill)  
                                      <option value="{{$skill->skill_id}}" @if(in_array($skill->skill_id,@$data['profileData']['selectedSkills'])){{"selected"}} @else{{""}}@endif>{{$skill->skill_name}}</option>
                                    @endforeach
                                  @endif  
                                  </select>
                                </div>  
                              </div>

                              <div class="row field-changes-below">
                                <label class="col-md-4 control-label basic-detail-label">Languages</label>
                                <div class="col-md-8">
                                  <select class="form-control select2 input-sm basic-detail-input-style" id="languageIds" name="languageIds[]" multiple="multiple" style="width: 100%;">
                                  @if(!$data['languages']->isEmpty())
                                    @foreach($data['languages'] as $language)  
                                      <option value="{{$language->language_id}}" @if(in_array($language->language_id,@$data['profileData']['selectedLanguages'])){{"selected"}} @else{{""}}@endif>{{$language->language_name}}</option>
                                    @endforeach
                                  @endif  
                                  </select>
                                </div>
                                <div class="languageCheckboxes">
                                  
                                </div>  
                              </div>

                        </div>

                        <div class="col-md-6 basic-detail-right">
                          
                          <div class="row field-changes-below">
                            <label class="col-md-4 control-label basic-detail-label">Marital Status</label>
                            <div class="col-md-8">
                              <select class="form-control maritalStatus input-sm basic-detail-input-style" name="maritalStatus">
                                <option value="Married">Married</option>
                                <option value="Unmarried">Unmarried</option>
                                <option value="Widowed">Widowed</option>
                                <option value="Divorced">Divorced</option>
                              </select>
                            </div>  
                          </div>

                          <div class="row field-changes-below spouseName">
                            <label for="spouseName" class="col-md-4 control-label basic-detail-label">Spouse Name</label>
                            <div class="col-md-8">
                              <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style text-capitalize" id="spouseName" name="spouseName" placeholder="Please Enter Alphabets In Spouse's Name." value="@if(@$data['profileData']['basic']->marital_status != 'Unmarried'){{@$data['profileData']['basic']->spouse_name}}@endif">
                            </div>
                          </div>

                          <div class="row field-changes-below spouseName" id="spouseWorkingStatus">
                            <span class="col-md-4 control-label radio basic-detail-label"><strong>Spouse Working Status</strong></span>
                            <div class="col-md-8">
                              <label class="basicradio">
                                <input autocomplete="off" type="radio" name="spouseWorkingStatus" class="radio-style-basic spouseWorkingStatus" id="spouseWorkingStatus1" value="No" @if(@$data['profileData']['basic']->spouse_working_status == "No"){{"checked"}}@endif>
                                Non-working
                              </label>
                              <label class="basicradio2">  
                                <input autocomplete="off" type="radio" name="spouseWorkingStatus" class="radio-style-basic2 spouseWorkingStatus" id="spouseWorkingStatus2" value="Yes" @if(@$data['profileData']['basic']->spouse_working_status == "Yes"){{"checked"}}@endif>
                                Working
                              </label>
                            </div>
                          </div>

                          <div class="row field-changes-below spouseWorking">
                            <label for="spouseCompanyName" class="col-md-4 control-label basic-detail-label">Spouse Company Name</label>

                            <div class="col-md-8">
                              <input autocomplete="off" type="text" class="form-control input-sm" name="spouseCompanyName" id="spouseCompanyName" placeholder="Please Enter Alphabets In Spouse Company Name." value="{{@$data['profileData']['basic']->spouse_company_name}}">
                            </div>
                          </div>

                          <div class="row field-changes-below spouseWorking">
                            <label class="col-md-4 control-label basic-detail-label">Spouse Designation</label>
                            <div class="col-md-8">
                              <select class="form-control input-sm basic-detail-input-style" name="spouseDesignation" id="spouseDesignation">
                                <option value="" selected disabled>Please Select Spouse's Designation.</option>
                              @if(!$data['roles']->isEmpty())  
                                @foreach($data['roles'] as $role)  
                                  <option value="{{$role->id}}" @if($role->id == @$data['profileData']['basic']->spouse_designation){{"selected"}}@endif>{{$role->name}}</option>
                                @endforeach
                              @endif
                              </select>
                            </div>  
                          </div>

                          <div class="row field-changes-below spouseWorking">
                            <label for="spouseContactNumber" class="col-md-4 control-label basic-detail-label">Spouse Contact Number</label>

                            <div class="col-md-8">
                              <input autocomplete="off" type="text" class="form-control input-sm" name="spouseContactNumber" id="spouseContactNumber" placeholder="Please Enter Alphabets In Spouse Contact Number." value="{{@$data['profileData']['basic']->spouse_contact_number}}">
                            </div>
                          </div>

                          <div class="row field-changes-below spouseName">
                            <label for="marriageDate" class="col-md-4 control-label basic-detail-label">Marriage Date</label>
                            <div class="col-md-8">
                              <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" id="marriageDate" name="marriageDate" placeholder="Please Select Employee's Marriage Date." value="@if(@$data['profileData']['basic']->marital_status != 'Unmarried'){{@$data['profileData']['basic']->marriage_date}}@endif">
                              <span class="marriageDateErrors"></span>
                            </div>
                          </div>

                          <div class="row field-changes-below">
                            <label for="birthDate" class="col-md-4 control-label basic-detail-label">Date Of Birth</label>
                            <div class="col-md-8">
                              <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" id="birthDate" name="birthDate" placeholder="Please Select Employee's Date Of Birth." value="{{@$data['profileData']['basic']->birth_date}}">
                              <span class="birthDateErrors"></span>
                            </div>  
                          </div>

                          <div class="row field-changes-below">
                            <label for="joiningDate" class="col-md-4 control-label basic-detail-label">Date Of Joining</label>
                            <div class="col-md-8">
                              <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" id="joiningDate" name="joiningDate" placeholder="Please Select Employee's Date Of Joining." value="{{@$data['profileData']['basic']->joining_date}}">
                            </div>  
                          </div>

                          <div class="row field-changes-below">
                            <span class="col-md-4 control-label radio basic-detail-label"><strong>Gender</strong></span>
                            <div class="col-md-8">
                              <label class="basicradio">
                                <input autocomplete="off" type="radio" name="gender" class="radio-style-basic" id="optionsRadios1" value="Male" @if(@$data['profileData']['basic']->gender == "Male"){{"checked"}}@endif>
                                Male
                              </label>
                              <label class="basicradio2">  
                                <input autocomplete="off" type="radio" name="gender" class="radio-style-basic2" id="optionsRadios2" value="Female" @if(@$data['profileData']['basic']->gender == "Female"){{"checked"}}@endif>
                                Female
                              </label>
                            </div>
                          </div>

                          <div class="row field-changes-below">
                                <label class="col-md-4 control-label basic-detail-label">Previous Experience Years</label>
                                <div class="col-md-8">
                                  <select class="form-control expYears input-sm basic-detail-input-style" name="expYrs">
                                    <option value="" selected disabled>Please Select Experience Year On Joining.</option>
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

                              <div class="row field-changes-below">
                                <label class="col-md-4 control-label basic-detail-label">Previous Experience Months</label>
                                <div class="col-md-8">
                                  <select class="form-control expMonths input-sm basic-detail-input-style" name="expMns">
                                    <option value="" selected disabled>Please Select Experience Month On Joining.</option>
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
                                  </select>
                                </div>  
                              </div>

                              <div class="row field-changes-below">
                                <label for="profilePic" class="col-md-4 control-label basic-detail-label">Profile Picture</label>
                                <div class="col-md-8">
                                  <input autocomplete="off" type="file" id="profilePic" name="profilePic" class="input-sm">  
                                </div>
                              </div>

                              <div class="row field-changes-below">
                                <span class="col-md-4 control-label radio basic-detail-label"><strong>Nominee Type</strong></span>
                                <div class="col-md-8">
                                  <label class="basicradio">
                                    <input autocomplete="off" type="radio" name="nomineeType" class="radio-style-basic nomineeType" id="nomineeType1" value="PF" @if(@$data['profileData']['basic']->nominee_type == "PF"){{"checked"}}@endif>
                                    PF
                                  </label>
                                  <label class="basicradio2">  
                                    <input autocomplete="off" type="radio" name="nomineeType" class="radio-style-basic2 nomineeType" id="nomineeType2" value="Insurance" @if(@$data['profileData']['basic']->nominee_type != "PF"){{"checked"}}@endif>
                                    Insurance
                                  </label>
                                </div>
                              </div>

                              <div class="row field-changes-below nomineeInsurance">
                                <label for="insuranceCompanyName" class="col-md-4 control-label basic-detail-label">Insurance Company Name</label>

                                <div class="col-md-8">
                                  <input autocomplete="off" type="text" class="form-control input-sm" name="insuranceCompanyName" id="insuranceCompanyName" placeholder="Please Enter Alphabets In Insurance Company Name." value="{{@$data['profileData']['basic']->insurance_company_name}}">
                                </div>
                              </div>

                              <div class="row field-changes-below nomineeInsurance">
                                <label for="coverAmount" class="col-md-4 control-label basic-detail-label">Premium & Cover Amount</label>

                                <div class="col-md-8">
                                  <input autocomplete="off" type="text" class="form-control input-sm" name="coverAmount" id="coverAmount" placeholder="Please Enter Digits In Amount." value="{{@$data['profileData']['basic']->cover_amount}}">
                                </div>
                              </div>

                              <div class="row field-changes-below nomineeInsurance">
                                <label for="typeOfInsurance" class="col-md-4 control-label basic-detail-label">Type Of Insurance</label>

                                <div class="col-md-8">
                                  <input autocomplete="off" type="text" class="form-control input-sm" name="typeOfInsurance" id="typeOfInsurance" placeholder="Please Enter Alphabets In Type of Insurance." value="{{@$data['profileData']['basic']->type_of_insurance}}">
                                </div>
                              </div>

                              <div class="row field-changes-below nomineeInsurance">
                                <label for="insuranceExpiryDate" class="col-md-4 control-label basic-detail-label">Insurance Expiry Date</label>
                                <div class="col-md-8">
                                  <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" id="insuranceExpiryDate" name="insuranceExpiryDate" placeholder="Please Select Insurance Expiry Date." value="{{@$data['profileData']['basic']->insurance_expiry_date}}">
                                  <span class="insuranceExpiryDateErrors"></span>
                                </div>
                              </div>

                              <div class="row field-changes-below">
                                <label for="nominee" class="col-md-4 control-label basic-detail-label">Nominee Name</label>

                                <div class="col-md-8">
                                  <input autocomplete="off" type="text" class="form-control input-sm" name="nominee" id="nominee" placeholder="Please Enter Alphabets In Nominee's Name." value="{{@$data['profileData']['basic']->nominee_name}}">
                                </div>
                              </div>

                              <div class="row field-changes-below">
                                <label for="relation" class="col-md-4 control-label basic-detail-label">Relation</label>

                                <div class="col-md-8">
                                  <input autocomplete="off" type="text" class="form-control input-sm" name="relation" id="relation" placeholder="Please Enter Alphabets In Relation." value="{{@$data['profileData']['basic']->relation}}">
                                </div>
                              </div>

                              <div class="row field-changes-below">
                                <label for="registrationFees" class="col-md-4 control-label">Registration Fees</label>
                                <div class="col-md-8">
                                  <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="registrationFees" id="registrationFees" placeholder="Please Enter Digits in Registration Fees." value="{{@$data['profileData']['basic']->registration_fees}}">
                                </div>
                              </div>

                              <div class="row field-changes-below">
                                <label for="applicationNumber" class="col-md-4 control-label">Application Number</label>
                                <div class="col-md-8">
                                  <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="applicationNumber" id="applicationNumber" placeholder="Please Enter Alphabets In Application Number." value="{{@$data['profileData']['basic']->application_number}}">
                                </div>
                              </div>

                              

                        </div>
                  </div>
              </div>
          </div>
          <!-- /.box-body -->
          <div class="box-footer">
                <button type="submit" class="btn btn-info basicFormSubmit" id="basicFormSubmit" name="formSubmitButton" value="sc">Save & Continue</button>
                <button type="submit" class="btn btn-default basicFormSubmit" name="formSubmitButton" value="se">Save & Exit</button>
              </div>
              <!-- /.box-footer -->
            </form>
        </div>
              <!-- /.tab-pane -->

                                                   <!-- Basic Details ends here -->


                                                   <!-- Project detail starts here -->
              <div class="tab-pane" id="tab_projectDetailsTab">
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
                      <hr>
                      <div class="form-group form-sidechange">
                        <div class="row">
                          <div class="col-md-6">

                              <div class="row field-changes-below">
                                <label class="col-md-4 control-label basic-detail-label">Project</label>
                                <div class="col-md-8">
                                  <select class="form-control input-sm basic-detail-input-style" name="projectId" id="projectId">
                                    <option value="" selected disabled>Please Select Employee's Project.</option>
                                  @if(!$data['projects']->isEmpty())
                                    @foreach($data['projects'] as $project)  
                                      <option value="{{$project->project_id}}" @if($project->project_id == @$data['profileData']['basic']->project_id){{"selected"}}@endif>{{$project->project_name}}</option>
                                    @endforeach
                                  @endif  
                                  </select>
                                </div>  
                              </div>

                              <div class="row field-changes-below">
                                <label for="companyId" class="col-md-4 control-label">Company</label>

                                <div class="col-md-8">
                                  <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="companyId" id="companyId" value="None" readonly>
                                </div>
                              </div>

                              <div class="row field-changes-below">
                                <label for="pfNo" class="col-md-4 control-label">PF Number</label>

                                <div class="col-md-8">
                                  <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="pfNo" id="pfNo" value="None" readonly>
                                </div>
                              </div>

                              <div class="row field-changes-below" id="tanNoBox">
                                <label for="tanNo" class="col-md-4 control-label">TAN Number</label>

                                <div class="col-md-8">
                                  <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="tanNo" id="tanNo" value="None" readonly>
                                </div>
                              </div>

                              <div class="row field-changes-below">
                                <label for="ptStateId" class="col-md-4 control-label">State</label>

                                <div class="col-md-8">
                                  <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="ptStateId" id="ptStateId" value="None" readonly>
                                </div>
                              </div>

                              <div class="row field-changes-below" id="certificateBox">
                                <label for="certificateNo" class="col-md-4 control-label">Certificate Number</label>

                                <div class="col-md-8">
                                  <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="certificateNo" id="certificateNo" value="None" readonly>
                                </div>
                              </div>

                              <div class="row field-changes-below">
                                <label for="esiLocationId" class="col-md-4 control-label">Location</label>

                                <div class="col-md-8">
                                  <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="esiLocationId" id="esiLocationId" value="None" readonly>
                                </div>
                              </div>

                              <div class="row field-changes-below" id="esiNoBox">
                                <label for="esiNo" class="col-md-4 control-label">ESI Subcode</label>

                                <div class="col-md-8">
                                  <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="esiNo" id="esiNo" value="None" readonly>
                                </div>
                              </div>

                              <div class="row field-changes-below">
                                <label for="salaryHeadId" class="col-md-4 control-label">Salary Structure</label>

                                <div class="col-md-8">
                                  <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="salaryHeadId" id="salaryHeadId" value="None" readonly>
                                </div>
                              </div>

                              <div class="row field-changes-below">
                                <label for="salaryCycleId" class="col-md-4 control-label">Salary Cycle</label>

                                <div class="col-md-8">
                                  <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="salaryCycleId" id="salaryCycleId" value="None" readonly>
                                </div>
                              </div>

                          </div>

                          <div class="col-md-6">

                          <div class="row field-changes-below">
                            <label class="col-md-4 control-label basic-detail-label">Department</label>
                            <div class="col-md-8">
                              <select class="form-control input-sm basic-detail-input-style" name="departmentId">
                                <option value="" selected disabled>Please Select Employee's Department.</option>
                              @if(!$data['departments']->isEmpty())
                                @foreach($data['departments'] as $department)  
                                  <option value="{{$department->department_id}}" @if($department->department_id == @$data['profileData']['basic']->department_id){{"selected"}}@endif>{{$department->department_name}}</option>
                                @endforeach
                              @endif  
                              </select>
                            </div>  
                          </div>

                          <div class="row field-changes-below">
                            <label class="col-md-4 control-label basic-detail-label">Designation</label>
                            <div class="col-md-8">
                              <select class="form-control input-sm basic-detail-input-style" name="roleId">
                                <option value="" selected disabled>Please Select Employee's Designation.</option>
                              @if(!$data['roles']->isEmpty())  
                                @foreach($data['roles'] as $role)  
                                  <option value="{{$role->id}}" @if($role->id == @$data['profileData']['basic']->role_id){{"selected"}}@endif>{{$role->name}}</option>
                                @endforeach
                              @endif
                              </select>
                            </div>  
                          </div>

                          <div class="row field-changes-below">
                            <label class="col-md-4 control-label basic-detail-label">Permissions</label>
                            <div class="col-md-8">
                              <select class="form-control select2 input-sm basic-detail-input-style" name="permissionIds[]" multiple="multiple" style="width: 100%">
                              @if(!$data['permissions']->isEmpty())
                                @foreach($data['permissions'] as $permission)  
                                  <option value="{{$permission->id}}" @if(in_array($permission->id,@$data['profileData']['selectedPermissions'])){{"selected"}} @else{{""}}@endif>{{$permission->name}}</option>
                                @endforeach
                              @endif  
                              </select>
                            </div>  
                          </div>

                          <input type="hidden" name="employeeId" value="{{$data['employeeId']}}">

                            <!-- <div class="col-md-10">  --> 

                              <div class="row field-changes-below">
                                <label class="col-md-4 control-label basic-detail-label">Location</label>
                                <div class="col-md-8">
                                  <select class="form-control input-sm basic-detail-input-style" name="locationId">
                                     <option value="" selected disabled>Please Select Employee's Location.</option>
                                  @if(!$data['locations']->isEmpty())
                                    @foreach($data['locations'] as $location)  
                                      <option value="{{$location->location_id}}" @if($location->location_id == @$data['profileData']['basic']->location_id){{"selected"}}@endif>{{$location->location_name}}</option>
                                    @endforeach
                                  @endif  
                                  </select>
                                </div>  
                              </div>

                              <div class="row field-changes-below">
                                <label class="col-md-4 control-label basic-detail-label">Reporting Manager</label>
                                <div class="col-md-8">
                                  <select class="form-control input-sm basic-detail-input-style" name="employeeIds[]" style="width: 100%;">
                                    <option value="" selected disabled>Please Select Employees's Reporting Manager.</option>
                                  @if(!$data['projectForm']['employees']->isEmpty())  
                                    @foreach($data['projectForm']['employees'] as $employee)  
                                      <option value="{{$employee->employee_id}}" @if($employee->employee_id == $lastInsertedEmployeee){{"disabled"}}@endif @if(in_array($employee->employee_id,@$data['profileData']['reportingManagers'])){{"selected"}} @else{{""}}@endif>{{$employee->full_name}}</option>
                                    @endforeach
                                  @endif
                                  </select>
                                </div>
                              </div>

                              <div class="row field-changes-below">
                                <label class="col-md-4 control-label basic-detail-label">Shift Timing</label>
                                <div class="col-md-8">
                                  <select class="form-control input-sm basic-detail-input-style" name="shiftTimingId">
                                    <option value="" selected disabled>Please Select Employee's Shift Timing.</option>
                                  @if(!$data['shiftTimings']->isEmpty())
                                    @foreach($data['shiftTimings'] as $timing)  
                                      <option value="{{$timing->shift_timing_id}}" @if($timing->shift_timing_id == @$data['profileData']['basic']->shift_timing_id){{"selected"}}@endif>{{$timing->shift_name}}</option>
                                    @endforeach
                                  @endif  
                                  </select>
                                </div>  
                              </div>

                              <div class="row field-changes-below">
                                <label class="col-md-4 control-label basic-detail-label">Perks</label>
                                <div class="col-md-8">
                                  <select class="form-control select2 input-sm basic-detail-input-style" name="perkIds[]" multiple="multiple" style="width: 100%;">
                                  @if(!$data['perks']->isEmpty())
                                    @foreach($data['perks'] as $perk)  
                                      <option value="{{$perk->perk_id}}" @if(in_array($perk->perk_id,@$data['profileData']['selectedPerks'])){{"selected"}} @else{{""}}@endif>{{$perk->perk_name}}</option>
                                    @endforeach
                                  @endif  
                                  </select>
                                </div>  
                              </div>

                              
                            <!-- </div>   -->

                              <div class="row field-changes-below">
                                <label class="col-md-4 control-label basic-detail-label">Probation Period</label>
                                <div class="col-md-8">
                                  <select class="form-control input-sm basic-detail-input-style" name="probationPeriodId" @if(@$data['profileData']['basic']->probation_period_id != 0){{"disabled"}}@endif>
                                    <option value="" selected disabled>Please Select Employee's Probation Period.</option>
                                  @if(!$data['probationPeriods']->isEmpty())
                                    @foreach($data['probationPeriods'] as $probation)  
                                      <option value="{{$probation->probation_period_id}}" @if($probation->probation_period_id == @$data['profileData']['basic']->probation_period_id){{"selected"}}@endif>{{$probation->probation_period_value}}</option>
                                    @endforeach
                                  @endif  
                                  </select>
                                </div>  
                              </div>

                          </div>

                        </div>
                      </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                      <button type="submit" class="btn btn-info profileFormSubmit" id="profileFormSubmit" name="formSubmitButton" value="sc">Save & Continue</button>
                <button type="submit" class="btn btn-default profileFormSubmit" name="formSubmitButton" value="se">Save & Exit</button>
                    </div>
                    <!-- /.box-footer -->
                  </form>
              </div>
              <!-- /.tab-pane -->

                                                   <!-- profile detail ends here -->


                                                   <!-- document upload starts here -->


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

          @if(!$data['profileData']['qualificationDocuments']->isEmpty())
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Qualification Documents List  <span style="font-size: 12px; text-align: right;color: red; padding-left: 20px;">(Allowed File Formats : jpg, jpeg,png, pdf, doc, docx. File Size Must Be Less Then 2MB.)</span></h3>
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
                @foreach($data['profileData']['qualificationDocuments'] as $document)
                <tr>
                  <td>{{++$counter}}</td>
                  <td>{{$document->qualification_name}}</td>
                  <td>
                    @if(empty($document->document_name))
                      <span class="badge bg-red"><i class="fa fa-times" aria-hidden="true"></i></span>
                    @else
                      <span class="badge bg-green"><i class="fa fa-check" aria-hidden="true"></i></span>
                    @endif
                  </td>
                  <td>
                    @if(!empty($document->document_name))
                      <span><a target="_blank" href="{{config('constants.uploadPaths.qualificationDocument').$document->document_name}}"><i class="fa fa-file-text-o" aria-hidden="true"></i></a></span>
                    @endif
                  </td>
                  <td>
                    <button class="btn btn-info uploadQualificationFile" href="javascript:void(0)" data-docname="{{$document->qualification_name}}" data-empqualificationid="{{$document->id}}">Upload</button>
                  </td>
                </tr>
                @endforeach
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
          <div>
            <br>
          </div> 
          @endif        
                                
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Other Documents List  <span style="font-size: 12px; text-align: right;color: red; padding-left: 20px;">(Allowed File Formats : jpg, jpeg,png, pdf, doc, docx. File Size Must Be Less Then 2MB.)</span></h3>
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
                      <span class="badge bg-red"><i class="fa fa-times" aria-hidden="true"></i></span>
                    @else
                      <span class="badge bg-green"><i class="fa fa-check" aria-hidden="true"></i></span>
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

                                              <!-- document upload ends here -->



                                              <!-- HR Details starts here -->
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
                      <hr>
                      <div class="form-group form-sidechange">
                          <div class="row field-changes-below">
                              <div class="col-md-6">
                                <div class="row field-changes-below">
                                  <label for="adhaar" class="col-md-4 control-label basic-detail-label">Adhaar Number</label>

                                  <div class="col-md-8">
                                    <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="adhaar" id="adhaar" placeholder="Please Enter Only Numeric  Value In Adhaar Number." value="{{@$data['profileData']['accountInfo']->adhaar}}">
                                  </div>
                                </div>

                                <div class="row field-changes-below">
                                  <label for="panNo" class="col-md-4 control-label basic-detail-label">PAN Number</label>

                                  <div class="col-md-8">
                                    <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="panNo" id="panNo" placeholder="Please Enter Alphabets And Digits Value In Pan Number." value="{{@$data['profileData']['accountInfo']->pan_no}}">
                                  </div>
                                </div>

                                <div class="row field-changes-below">
                                  <label for="empEsiNo" class="col-md-4 control-label basic-detail-label">Employee ESI Number</label>

                                  <div class="col-md-8">
                                    <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="empEsiNo" id="empEsiNo" placeholder="Please Enter 10 Digits Numeric  Value In Employee ESI Number." value="{{@$data['profileData']['accountInfo']->emp_esi_no}}">
                                  </div>
                                </div>

                                <div class="row field-changes-below">
                                  <label for="empDispensary" class="col-md-4 control-label basic-detail-label">Employee Dispensary</label>

                                  <div class="col-md-8">
                                    <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="empDispensary" id="empDispensary" placeholder="Please Enter Employee's Dispensary" value="{{@$data['profileData']['accountInfo']->emp_dispensary}}">
                                  </div>
                                </div>
                                
                                <div class="row field-changes-below">
                                  <label for="pfNoDepartment" class="col-md-4 control-label basic-detail-label">PF Number for Department File</label>

                                  <div class="col-md-8">
                                    <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="pfNoDepartment" id="pfNoDepartment" placeholder="Please Enter Numeric  Value In PF Number for Department File." value="{{@$data['profileData']['accountInfo']->pf_no_department}}">
                                  </div>
                                </div>


                                <div class="row field-changes-below">
                                  <label for="uanNo" class="col-md-4 control-label basic-detail-label">UAN Number</label>

                                  <div class="col-md-8">
                                    <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="uanNo" id="uanNo" placeholder="Please Enter 12 Digits Numeric  Value In UAN Number." value="{{@$data['profileData']['accountInfo']->uan_no}}">
                                  </div>
                                </div>

                                <div class="row field-changes-below">
                                  <label class="col-md-4 control-label basic-detail-label">Bank Name</label>
                                  <div class="col-md-8">
                                    <select class="form-control input-sm basic-detail-input-style" name="financialInstitutionId">
                                    @if(!$data['financialInstitutions']->isEmpty())
                                      @foreach($data['financialInstitutions'] as $financialInstitution)  
                                        <option value="{{$financialInstitution->financial_institution_id}}" @if($financialInstitution->financial_institution_id == @$data['profileData']['accountInfo']->financial_institution_id){{"selected"}}@endif>{{$financialInstitution->financial_institution_name}}</option>
                                      @endforeach
                                    @endif  
                                    </select>
                                  </div>  
                                </div>

                                <div class="row field-changes-below">
                                  <label for="accHolderName" class="col-md-4 control-label basic-detail-label">Account Holder Name</label>

                                  <div class="col-md-8">
                                    <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="accHolderName" id="accHolderName" placeholder="Please Enter Aplhabets In Account Holder Name." value="{{@$data['profileData']['accountInfo']->acc_holder_name}}">
                                  </div>
                                </div>

                                <input type="hidden" name="employeeId" value="{{$data['employeeId']}}">

                                <div class="row field-changes-below">
                                  <label for="bankAccNo" class="col-md-4 control-label basic-detail-label">Bank Account Number</label>

                                  <div class="col-md-8">
                                    <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="bankAccNo" id="bankAccNo" placeholder="Please Enter Numeric  Value In Bank Account Number." value="{{@$data['profileData']['accountInfo']->bank_acc_no}}">
                                  </div>
                                </div>

                                <div class="row field-changes-below">
                                  <label for="ifsc" class="col-md-4 control-label basic-detail-label">IFSC Code</label>

                                  <div class="col-md-8">
                                    <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="ifsc" id="ifsc" placeholder="Please enter Alphanumeric  Value In IFSC Code." value="{{@$data['profileData']['accountInfo']->ifsc}}">
                                  </div>
                                </div>
                              </div>

                            <div class="col-md-6">

                              <div class="row field-changes-below">
                                <span class="col-md-4 control-label basic-detail-label"><strong>Background Verification</strong></span>
                                <div class="col-md-8">
                                  <label class="checkbox-inline">
                                    <input autocomplete="off" type="checkbox" name="employmentVerification" id="employmentVerification" value="1">Previous Employment
                                  </label>
                                  <label class="checkbox-inline">
                                    <input autocomplete="off" type="checkbox" name="addressVerification" id="addressVerification" value="1">House Address
                                  </label>
                                  <label class="checkbox-inline check-align-3rd">
                                    <input autocomplete="off" type="checkbox" name="policeVerification" id="policeVerification" value="1">Police verification
                                  </label>
                                </div>
                              </div>

                              <div class="row field-changes-below">
                                <label class="col-md-4 control-label basic-detail-label" for="remarks">Remarks</label>
                                <div class="col-md-8">
                                 <textarea class="form-control input-sm basic-detail-input-style" rows="5" name="remarks" id="remarks">{{@$data['profileData']['basic']->remarks}}</textarea>
                                </div>
                              </div>

                              <div class="row field-changes-below">
                                <span class="col-md-4 control-label radio basic-detail-label"><strong>Contract Signed</strong></span>
                                <div class="col-md-8">
                                  <label>
                                    <input autocomplete="off" type="radio" name="contractSigned" class="contractSigned" id="optionsRadios3" value="1" @if(@$data['profileData']['basic']->contract_signed == "1"){{"checked"}}@endif>
                                    Yes
                                  </label>
                                  <label>  
                                    <input autocomplete="off" type="radio" name="contractSigned" class="contractSigned" id="optionsRadios4" value="0" @if(@$data['profileData']['basic']->contract_signed == "0"){{"checked"}}@endif>
                                    No
                                  </label>
                                </div>
                              </div>

                              <div class="row contractSignedDateDiv field-changes-below">
                                <label for="contractSignedDate" class="col-md-4 control-label basic-detail-label">Contract Signed Date</label>
                                  <div class="col-md-8 basic-input-right">
                                    <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" id="contractSignedDate" name="contractSignedDate" placeholder="Please Select Employee's Contract Signed Date" value="{{date('m/d/Y',strtotime(@$data['profileData']['basic']->contract_signed_date))}}">
                                    <span class="contractSignedDateErrors"></span>
                                  </div>
                              </div>


                                
                              </div>
                          </div>
                      </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                      <button type="submit" class="btn btn-info accountFormSubmit" id="accountFormSubmit" name="formSubmitButton" value="sc">Save & Continue</button>
                <button type="submit" class="btn btn-default accountFormSubmit" name="formSubmitButton" value="se">Save & Exit</button>
                    </div>
                    <!-- /.box-footer -->
                  </form>
              </div>
              <!-- /.tab-pane -->

                                                    <!-- HR Details ends here -->



                                                    <!-- contact detail starts here -->
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
                        <div class="form-group form-sidechange">
                            <div class="row">
                                <div class="col-md-6">
                                      <span class="text-primary"><em>Permanent Address</em></span> :-
                                      <hr>
                                      <div class="row field-changes-below">
                                        <label for="perHouseNo" class="col-md-4 control-label basic-detail-label">House Number</label>

                                        <div class="col-md-8">
                                          <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="perHouseNo" id="perHouseNo" placeholder="Please Enter Employee's House Number." value="{{@$data['profileData']['permanentAddress']->house_no}}">
                                        </div>
                                      </div>

                                      <div class="row field-changes-below">
                                        <label for="perRoadStreet" class="col-md-4 control-label basic-detail-label">Road/Street</label>

                                        <div class="col-md-8">
                                          <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="perRoadStreet" id="perRoadStreet" placeholder="Pease Enter Employee's Road/Street Name." value="{{@$data['profileData']['permanentAddress']->road_street}}">
                                        </div>
                                      </div>

                                      <div class="row field-changes-below">
                                        <label for="perLocalityArea" class="col-md-4 control-label basic-detail-label">Locality/Area</label>

                                        <div class="col-md-8">
                                          <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="perLocalityArea" id="perLocalityArea" placeholder="Please Enter Employee's Locality/Area Name." value="{{@$data['profileData']['permanentAddress']->locality_area}}">
                                        </div>
                                      </div>

                                      <div class="row field-changes-below">
                                        <label for="perPinCode" class="col-md-4 control-label basic-detail-label">Pincode</label>

                                        <div class="col-md-8">
                                          <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="perPinCode" id="perPinCode" placeholder="Please Enter Numeric  Value In PinCode." value="{{@$data['profileData']['permanentAddress']->pincode}}">
                                        </div>
                                      </div>

                                      <div class="row field-changes-below">
                                        <label for="perEmergencyNumber" class="col-md-4 control-label">Emergency Number</label>

                                          <div class="col-md-3 salu-change">
                                              <select class="form-control input-sm basic-detail-input-style perEmergencyNumberStdId" name="perEmergencyNumberStdId">
                                                @if(!$data['countries']->isEmpty())
                                                @foreach($data['countries'] as $country)  
                                                    <option value="{{$country->c_id}}" @if(@$country->c_id == @$data['profileData']['permanentAddress']->emergency_number_std_id){{'selected'}}@endif>(+{{@$country->c_ph_code}}) {{@$country->c_iso3}}</option>
                                                @endforeach
                                                @endif  
                                              </select>
                                          </div>
                                        
                                        <div class="col-md-5">
                                          <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="perEmergencyNumber" id="perEmergencyNumber" placeholder="Please Enter Emergency Contact Number." value="{{@$data['profileData']['permanentAddress']->emergency_number}}">
                                        </div>
                                      </div>

                                      <div class="row field-changes-below">
                                        <label class="col-md-4 control-label basic-detail-label">Country</label>
                                        <div class="col-md-8">
                                          <select class="form-control perCountryId input-sm basic-detail-input-style" name="perCountryId">
                                          @if(!$data['countries']->isEmpty())
                                            @foreach($data['countries'] as $country)  
                                              <option value="{{$country->c_id}}" @if($country->c_id == @$data['profileData']['permanentAddress']->country_id){{"selected"}}@endif>{{$country->c_name}}</option>
                                            @endforeach
                                          @endif  
                                          </select>
                                        </div>
                                      </div>

                                      <div class="row field-changes-below">
                                        <label class="col-md-4 control-label basic-detail-label">State</label>
                                        <div class="col-md-8">
                                          <select class="form-control perStateId input-sm basic-detail-input-style" name="perStateId">
                                          @if(!$data['states']->isEmpty())
                                            @foreach($data['states'] as $state)  
                                              <option value="{{$state->s_id}}" @if($state->s_id == @$data['profileData']['permanentAddress']->state_id){{"selected"}}@endif>{{$state->s_name}}</option>
                                            @endforeach
                                          @endif  
                                          </select>
                                        </div>  
                                      </div>
                                        <div class="row field-changes-below">
                                        <label class="col-md-4 control-label basic-detail-label">City</label>
                                        <div class="col-md-8">
                                          <select class="form-control perCityId input-sm basic-detail-input-style" name="perCityId">
                                          @if(!$data['cities']->isEmpty())
                                            @foreach($data['cities'] as $city)  
                                              <option value="{{$city->ct_id}}" @if($city->ct_id == @$data['profileData']['permanentAddress']->city_id){{"selected"}}@endif>{{$city->ct_name}}</option>
                                            @endforeach
                                          @endif  
                                          </select>
                                        </div>  
                                      </div>
                                  </div>


                                  <div class="col-md-6">
                                        <span class="text-primary"><em>Residential Address</em></span> :-
                                        <div class="checkbox pull-right">
                                        <label>
                                          <input autocomplete="off" type="checkbox" id="checkboxAbove">same as permanent address
                                        </label>
                                      </div>                      
                                      <hr>
                                      <div class="row field-changes-below">
                                        <label for="preHouseNo" class="col-md-4 control-label basic-detail-label">House Number</label>

                                        <div class="col-md-8">
                                          <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="preHouseNo" id="preHouseNo" placeholder="Please Enter Employee's House Number." value="{{@$data['profileData']['presentAddress']->house_no}}">
                                        </div>
                                      </div>

                                      <input autocomplete="off" type="hidden" name="employeeId" value="{{$data['employeeId']}}">

                                      <div class="row field-changes-below">
                                        <label for="preRoadStreet" class="col-md-4 control-label basic-detail-label">Road/Street</label>

                                        <div class="col-md-8">
                                          <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="preRoadStreet" id="preRoadStreet" placeholder="Pease Enter Employee's Road/Street Name." value="{{@$data['profileData']['presentAddress']->road_street}}">
                                        </div>
                                      </div>

                                      <div class="row field-changes-below">
                                        <label for="preLocalityArea" class="col-md-4 control-label basic-detail-label">Locality/Area</label>

                                        <div class="col-md-8">
                                          <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="preLocalityArea" id="preLocalityArea" placeholder="Please Enter Employee's Locality/Area Name." value="{{@$data['profileData']['presentAddress']->locality_area}}">
                                        </div>
                                      </div>

                                      <div class="row field-changes-below">
                                        <label for="prePinCode" class="col-md-4 control-label basic-detail-label">Pincode</label>

                                        <div class="col-md-8">
                                          <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="prePinCode" id="prePinCode" placeholder="Please Enter Numeric  Value In Pin Code." value="{{@$data['profileData']['presentAddress']->pincode}}">
                                        </div>
                                      </div>

                                      <div class="row field-changes-below">
                                        <label for="preEmergencyNumber" class="col-md-4 control-label">Emergency Number</label>

                                        <div class="col-md-3 salu-change">
                                              <select class="form-control input-sm basic-detail-input-style preEmergencyNumberStdId" name="preEmergencyNumberStdId">
                                                  @if(!$data['countries']->isEmpty())
                                                @foreach($data['countries'] as $country)  
                                                    <option value="{{$country->c_id}}" @if(@$country->c_id == @$data['profileData']['presentAddress']->emergency_number_std_id){{'selected'}}@endif>(+{{@$country->c_ph_code}}) {{@$country->c_iso3}}</option>
                                                @endforeach
                                                @endif  
                                              </select>
                                          </div>
                                        
                                        <div class="col-md-5">
                                          <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="preEmergencyNumber" id="preEmergencyNumber" placeholder="Please Enter Emergency Contact Number." value="{{@$data['profileData']['presentAddress']->emergency_number}}">
                                        </div>
                                      </div>

                                      <div class="row field-changes-below">
                                        <label class="col-md-4 control-label basic-detail-label">Country</label>
                                        <div class="col-md-8">
                                            <select class="form-control preCountryId input-sm basic-detail-input-style" name="preCountryId">
                                            @if(!$data['countries']->isEmpty())
                                              @foreach($data['countries'] as $country)  
                                                <option value="{{$country->c_id}}" @if($country->c_id == @$data['profileData']['presentAddress']->country_id){{"selected"}}@endif>{{$country->c_name}}</option>
                                              @endforeach
                                            @endif  
                                            </select>
                                        </div>
                                        
                                      </div>

                                      <div class="row field-changes-below">
                                        <label class="col-md-4 control-label basic-detail-label">State</label>
                                        <div class="col-md-8">
                                          <select class="form-control preStateId input-sm basic-detail-input-style" name="preStateId">
                                          @if(!$data['states']->isEmpty())
                                            @foreach($data['states'] as $state)  
                                              <option value="{{$state->s_id}}" @if($state->s_id == @$data['profileData']['presentAddress']->state_id){{"selected"}}@endif>{{$state->s_name}}</option>
                                            @endforeach
                                          @endif  
                                          </select>
                                        </div>  
                                      </div>

                                      <div class="row field-changes-below">
                                        <label class="col-md-4 control-label basic-detail-label">City</label>
                                        <div class="col-md-8">
                                          <select class="form-control preCityId input-sm basic-detail-input-style" name="preCityId">
                                          @if(!$data['cities']->isEmpty())
                                            @foreach($data['cities'] as $city)  
                                              <option value="{{$city->ct_id}}"  @if($city->ct_id == @$data['profileData']['presentAddress']->city_id){{"selected"}}@endif>{{$city->ct_name}}</option>
                                            @endforeach
                                          @endif  
                                          </select>
                                        </div>  
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                    
                    <!-- /.box-body -->
                    
                    <div class="box-footer">
                      <button type="submit" class="btn btn-info addressFormSubmit" id="addressFormSubmit" name="formSubmitButton" value="sc">Save & Continue</button>
                <button type="submit" class="btn btn-default addressFormSubmit" name="formSubmitButton" value="se">Save & Exit</button>
                    </div>
                    <!-- /.box-footer -->
                  </form>
              </div>
              <!-- /.tab-pane -->

                                                <!-- contact detail ends here -->


                                                
                                              <!-- Employment history starts here -->


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
                      <div class="form-group form-sidechange">
                          <div class="row">
                              <div class="col-md-6">
                                  <div class="row field-changes-below">
                                    <label for="fromDate" class="col-md-4 control-label basic-detail-label">From Date</label>
                                    <div class="col-md-8">
                                      <input autocomplete="off" type="text" class="form-control input-sm datepicker" id="fromDate" name="fromDate" placeholder="Please Select Previous Employer Joining Date." value="">
                                      <span class="fromDateErrors"></span>
                                    </div>
                                  </div>

                                  <div class="row field-changes-below">
                                    <label for="toDate" class="col-md-4 control-label basic-detail-label">To Date</label>
                                    <div class="col-md-8">
                                      <input autocomplete="off" type="text" class="form-control input-sm datepicker" id="toDate" name="toDate" placeholder="Please Select Previous Employer Relieving Date." value="">
                                      <span class="toDateErrors"></span>
                                    </div>
                                  </div>

                                  <input type="hidden" name="employeeId" value="{{$data['employeeId']}}">

                                  <div class="row field-changes-below">
                                    <label for="orgName" class="col-md-4 control-label basic-detail-label">Organization Name</label>

                                    <div class="col-md-8">
                                      <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="orgName" id="orgName" placeholder="Please Enter Previous Organization Name">
                                    </div>
                                  </div>

                                  <div class="row field-changes-below">
                                    <label for="orgPhone" class="col-md-4 control-label basic-detail-label">Organization Phone</label>

                                    <div class="col-md-3 salu-change">
                                        <select class="form-control input-sm basic-detail-input-style" name="orgPhoneStdId">
                                          @if(!$data['countries']->isEmpty())
                                          @foreach($data['countries'] as $country)  
                                              <option value="{{$country->c_id}}" @if(@$country->c_ph_code == '91' ){{'selected'}}@endif>(+{{@$country->c_ph_code}}) {{@$country->c_iso3}}</option>
                                          @endforeach
                                          @endif  
                                        </select>
                                    </div>

                                    <div class="col-md-2">
                                      <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="orgPhoneStdCode" id="orgPhoneStdCode" placeholder="Std Code">
                                    </div>
                                    
                                    <div class="col-md-3">
                                      <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="orgPhone" id="orgPhone" placeholder="Please Enter Numeric  Value In Previous Organization Phone Number.">
                                    </div>
                                  </div>

                                  <div class="row field-changes-below">
                                    <label for="orgEmail" class="col-md-4 control-label basic-detail-label">Organization Email</label>

                                    <div class="col-md-8">
                                      <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="orgEmail" id="orgEmail" placeholder="Please Enter Valid Email Id In Previous Organization Email Id.">
                                    </div>
                                  </div>

                                  <div class="row field-changes-below">
                                    <label for="orgWebsite" class="col-md-4 control-label">Organisation Website</label>

                                    <div class="col-md-8">
                                      <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="orgWebsite" id="orgWebsite" placeholder="Please enter full website url with http or https.">
                                    </div>
                                  </div>
                              </div>

                              <div class="col-md-6">
                                  <div class="row field-changes-below">
                                    <label for="responsibilities" class="col-md-4 control-label basic-detail-label">Responsibilities</label>

                                    <div class="col-md-8">
                                      <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="responsibilities" id="responsibilities" placeholder="Please Enter Employee's Previous employment Responsibilities.">
                                    </div>
                                  </div>

                                  <div class="row field-changes-below">
                                    <label for="reportTo" class="col-md-4 control-label basic-detail-label">Report To(Position)</label>

                                    <div class="col-md-8">
                                      <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="reportTo" id="reportTo" placeholder="Please Enter Employee's Report to (Position).">
                                    </div>
                                  </div>

                                  <div class="row field-changes-below">
                                    <label for="salaryPerMonth" class="col-md-4 control-label basic-detail-label">Salary Per Month</label>

                                    <div class="col-md-8">
                                      <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="salaryPerMonth" id="salaryPerMonth" placeholder="Please Enter Decimal Value Employee's Salary Per Month.">
                                    </div>
                                  </div>

                                  <div class="row field-changes-below">
                                    <label for="perks" class="col-md-4 control-label basic-detail-label">Perks</label>

                                    <div class="col-md-8">
                                      <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="perks" id="perks" placeholder="Please Enter Employee's Previous Perks.">
                                    </div>
                                  </div>

                                  <div class="row field-changes-below">
                                    <label for="leavingReason" class="col-md-4 control-label basic-detail-label">Reason For Leaving</label>

                                    <div class="col-md-8">
                                      <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="leavingReason" id="leavingReason" placeholder="Please Enter Reason For Leaving Previous Company.">
                                    </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                    </div>
                    <!-- /.box-body -->
                    
                    <div class="box-footer">
                      <button type="submit" class="btn btn-info historyFormSubmit" id="historyFormSubmit" name="formSubmitButton" value="s">Save</button>
                <button type="submit" class="btn btn-default historyFormSubmit" name="formSubmitButton" value="se">Save & Exit</button>
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
                            <th style="width: 10%">Organization Website</th>
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
                            <td title="{{@$history->organization_website}}">{{substr(@$history->organization_website,0,10)}}...</td>
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

                                                 <!-- Employment history ends here -->


                                                 <!-- Reference detail starts here -->

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
                      
                        <div class="form-group form-sidechange">
                            <div class="row">
                                <div class="col-md-6">
                                  <span class="text-primary"><em>Reference 1</em></span> :-
                                  <hr>
                                    <div class="row field-changes-below">
                                      <label for="ref1Name" class="col-md-4 control-label basic-detail-label">Name</label>
                                      <div class="col-md-8">
                                        <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" id="ref1Name" name="ref1Name" placeholder="Please Enter Alphabets In Reference 1 Name." value="{{@$data['profileData']['reference1']->reference_name}}">
                                      </div>
                                    </div>

                                    <input type="hidden" name="employeeId" value="{{$data['employeeId']}}">

                                    <div class="row field-changes-below">
                                      <label for="ref1Address" class="col-md-4 control-label basic-detail-label">Address</label>
                                      <div class="col-md-8">
                                        <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" id="ref1Address" name="ref1Address" placeholder="Please Enter Reference 1 Address." value="{{@$data['profileData']['reference1']->reference_address}}">
                                      </div>
                                    </div>

                                    <div class="row field-changes-below">
                                      <label for="ref1Phone" class="col-md-4 control-label basic-detail-label">Mobile Number</label>

                                      <div class="col-md-3 salu-change">
                                        <select class="form-control input-sm basic-detail-input-style" name="ref1PhoneStdId">
                                          @if(!$data['countries']->isEmpty())
                                          @foreach($data['countries'] as $country)  
                                              <option value="{{$country->c_id}}" @if(@$country->c_id == @$data['profileData']['reference1']->reference_phone_std_id){{'selected'}}@endif>(+{{@$country->c_ph_code}}) {{@$country->c_iso3}}</option>
                                          @endforeach
                                          @endif  
                                        </select>
                                      </div>

                                      <div class="col-md-5">
                                        <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="ref1Phone" id="ref1Phone" placeholder="Please Enter Numeric  Value In Reference 1 Phone Number."  value="{{@$data['profileData']['reference1']->reference_phone}}">
                                      </div>
                                    </div>

                                    <div class="row field-changes-below">
                                      <label for="ref1Email" class="col-md-4 control-label basic-detail-label">Email</label>

                                      <div class="col-md-8">
                                        <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="ref1Email" id="ref1Email" placeholder="Please Enter Valid Email Id In Reference 1 Email Id." value="{{@$data['profileData']['reference1']->reference_email}}">
                                      </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <span class="text-primary"><em>Reference 2</em></span> :-
                                    <hr>
                                    <div class="row field-changes-below">
                                      <label for="ref2Name" class="col-md-4 control-label basic-detail-label">Name</label>
                                      <div class="col-md-8">
                                        <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" id="ref2Name" name="ref2Name" placeholder="Please Enter Alphabets In Reference 2 Name." value="{{@$data['profileData']['reference2']->reference_name}}">
                                      </div>
                                    </div>

                                    <div class="row field-changes-below">
                                      <label for="ref2Address" class="col-md-4 control-label basic-detail-label">Address</label>
                                      <div class="col-md-8">
                                        <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" id="ref2Address" name="ref2Address" placeholder="Please Enter Reference 2 Address." value="{{@$data['profileData']['reference2']->reference_address}}">
                                      </div>
                                    </div>

                                    <div class="row field-changes-below">
                                      <label for="ref2Phone" class="col-md-4 control-label basic-detail-label">Mobile Number</label>

                                      <div class="col-md-3 salu-change">
                                        <select class="form-control input-sm basic-detail-input-style" name="ref2PhoneStdId">
                                          @if(!$data['countries']->isEmpty())
                                          @foreach($data['countries'] as $country)  
                                              <option value="{{$country->c_id}}" @if(@$country->c_id == @$data['profileData']['reference2']->reference_phone_std_id){{'selected'}}@endif>(+{{@$country->c_ph_code}}) {{@$country->c_iso3}}</option>
                                          @endforeach
                                          @endif  
                                        </select>
                                      </div>
                                      
                                      <div class="col-md-5">
                                        <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="ref2Phone" id="ref2Phone" placeholder="Please Enter Numeric  Value In Reference 2 Phone Number." value="{{@$data['profileData']['reference2']->reference_phone}}">
                                      </div>
                                    </div>

                                    <div class="row field-changes-below">
                                      <label for="ref2Email" class="col-md-4 control-label basic-detail-label">Email</label>

                                      <div class="col-md-8">
                                        <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="ref2Email" id="ref2Email" placeholder="Please Enter Valid Email Id In Reference 2 Email Id." value="{{@$data['profileData']['reference2']->reference_email}}">
                                      </div>
                                    </div>
                                </div>
                            </div>
                        </div>   
                    </div>
                    <!-- /.box-body -->
                    
                    <div class="box-footer">
                      <button type="submit" class="btn btn-info referenceFormSubmit" id="referenceFormSubmit" name="formSubmitButton" value="sc">Save & Continue</button>
                <button type="submit" class="btn btn-default referenceFormSubmit" name="formSubmitButton" value="se">Save & Exit</button>
                    </div>
                    <!-- /.box-footer -->
                  </form>
 
              </div>
              <!-- /.tab-pane -->

                                                   <!-- Reference detail ends here -->


                                                   <!-- Security detail start here -->

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
                        <div class="form-group form-sidechange">
                            <div class="row">
                                <div class="col-md-6"> 
                                    <div class="row field-changes-below">
                                      <label for="ddDate" class="col-md-4 control-label basic-detail-label">DD Date</label>
                                      <div class="col-md-8">
                                        <input autocomplete="off" type="text" class="form-control input-sm datepicker" id="ddDate" name="ddDate" placeholder="Please Select DD Date." value="{{date('m/d/Y',strtotime(@$data['profileData']['securityInfo']->security_dd_date))}}">
                                      </div>
                                    </div>

                                    <input type="hidden" name="employeeId" value="{{$data['employeeId']}}">

                                    <div class="row field-changes-below">
                                      <label for="ddNo" class="col-md-4 control-label basic-detail-label">DD Number</label>

                                      <div class="col-md-8">
                                        <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="ddNo" id="ddNo" placeholder="Please Enter Numeric  Value In DD Number." value="{{@$data['profileData']['securityInfo']->security_dd_no}}">
                                      </div>
                                    </div>

                                    <div class="row field-changes-below">
                                      <label for="bankName" class="col-md-4 control-label basic-detail-label">Bank Name</label>

                                      <div class="col-md-8">
                                        <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="bankName" id="bankName" placeholder="Please Enter Alphabets In Bank Name." value="{{@$data['profileData']['securityInfo']->security_bank_name}}">
                                      </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="row field-changes-below">
                                      <label for="accNo" class="col-md-4 control-label basic-detail-label">Account Number</label>

                                      <div class="col-md-8">
                                        <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="accNo" id="accNo" placeholder="Please Enter Numeric  Value In Account Number." value="{{@$data['profileData']['securityInfo']->security_account_no}}">
                                      </div>
                                    </div>

                                    <div class="row field-changes-below">
                                      <label for="receiptNo" class="col-md-4 control-label basic-detail-label">Receipt Number</label>

                                      <div class="col-md-8">
                                        <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="receiptNo" id="receiptNo" placeholder="Please Enter Numeric  Value In Receipt Number." value="{{@$data['profileData']['securityInfo']->security_receipt_no}}">
                                      </div>
                                    </div>

                                    <div class="row field-changes-below">
                                      <label for="amount" class="col-md-4 control-label basic-detail-label">Amount</label>

                                      <div class="col-md-8">
                                        <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="amount" id="amount" placeholder="Please Enter Decimal Value In Security Amount." value="{{@$data['profileData']['securityInfo']->security_amount}}">
                                      </div>
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </div>
                    <!-- /.box-body -->
                    
                    <div class="box-footer">
                      <button type="submit" class="btn btn-info" id="securityFormSubmit">Save</button>
                    </div>
                    <!-- /.box-footer -->
                  </form>
                   
              </div>
              <!-- /.tab-pane -->

                                                    <!-- Security detail ends here -->

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

      <div class="modal fade" id="uploadQualificationModal">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Qualification Document Upload Form</h4>
            </div>
            <div class="modal-body">
              <form id="qualificationDocumentDetailsForm" action="{{ route('employees.editQualificationDocumentDetails') }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                  <div class="box-body">
                    
                    <div class="form-group">
                      <label for="docName" class="docType">Document Type</label>
                      <input type="text" class="form-control" id="docName" name="docName" value="" readonly>
                    </div>

                    <input type="hidden" name="empQualificationId" id="empQualificationId">
                    <input type="hidden" name="employeeId" value="{{$data['employeeId']}}">

                    <div class="docId2">
                      <input type="file" id="qualificationDocs" name="qualificationDocs[]" multiple>  
                    </div>
                                 
                  </div>
                  <!-- /.box-body -->
                  <br>

                  <div class="box-footer">
                    <button type="submit" class="btn btn-primary" id="qualificationDocumentFormSubmit">Submit</button>
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

    $(".contractSigned").on('click',function(){
      var value = $(this).val();

      if(value == 0){
        $(".contractSignedDateDiv").hide();
      }else{
        $(".contractSignedDateDiv").show();
      }
    });

    $(".nomineeType").on('click',function(){
       var value = $(this).val();

       if(value == 'Insurance'){
        $(".nomineeInsurance").show();
       }else{
        $(".nomineeInsurance").hide();
       }
    });

    $('.uploadFile').on('click',function(){
      var docTypeId = $(this).data("doctypeid");
      var docTypeName = $(this).data("doctypename");

      $("#docTypeId").val(docTypeId);
      $("#docTypeName").val(docTypeName);
      
      $('#uploadModal').modal('show');

    });

    $('.uploadQualificationFile').on('click',function(){
      var empQualificationId = $(this).data("empqualificationid");
      var docName = $(this).data("docname");

      $("#empQualificationId").val(empQualificationId);
      $("#docName").val(docName);
      
      $('#uploadQualificationModal').modal('show');

    });

    var defNomineetype = "{{$data['profileData']['basic']->nominee_type}}";
    if(defNomineetype == 'PF'){
      $(".nomineeInsurance").hide();
    }

    var defSalutation = "{{$data['profileData']['basic']->salutation}}";
    $(".salutation").val(defSalutation);

    var defMarital = "{{$data['profileData']['basic']->marital_status}}";
    var defSpouseWorkingStatus = "{{$data['profileData']['basic']->spouse_working_status}}";
    $(".maritalStatus").val(defMarital);

    if(defMarital == "Unmarried"){
      $(".spouseName").hide();
      $(".spouseWorking").hide();
    }else if(defMarital == "Married"){
      $("#spouseWorkingStatus").show();
      if(defSpouseWorkingStatus == "Yes"){
        $(".spouseWorking").show();
      }else{
        $(".spouseWorking").hide();
      }
    }else{
      $("#spouseWorkingStatus").hide();
      $(".spouseWorking").hide();
    }

    var defContractSigned = "{{$data['profileData']['basic']->contract_signed}}";
    if(defContractSigned == 0){
      $(".contractSignedDateDiv").hide();
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
    var employeeHistorySubmit = {fromDate: 1, toDate: 1};
    var allowProfileFormSubmit = {contractDate: 1};

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
          "employeeMiddleName" : {             
              maxlength: 20,
              minlength: 3,
              spacespecial: true,
              lettersonly: true
          },
          "employeeLastName" : {
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
          "personalEmail" : {
              required : true,
              email: true,
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
          "spouseCompanyName" : {
              required : true,
              maxlength: 30,
              minlength: 3,              
              alphanumericWithSpaceDot : true
          },
          "spouseContactNumber" : {
              required : true,
              maxlength: 10,
              digits : true
          },
          "insuranceCompanyName" : {
              required : true,
              maxlength: 30,
              minlength: 3,
              spacespecial: true,
              alphanumericWithSpace : true
          },
          "coverAmount" : {
              required : true,
              maxlength: 10,
              digitswdot : true
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
              maxlength: 20,
              minlength: 3,
              spacespecial: true,
              lettersonly: true
          },
          "registrationFees" : {
              required : true,
              maxlength: 10,
              digitswdot : true
          },
		      "applicationNumber" : {
              required : true,
              maxlength: 20,
              digits : true
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
              required : 'Please enter employee first name.',
              maxlength: 'Maximum 20 characters are allowed.',
              minlength: 'Minimum 3 characters are allowed.'
          },
          "employeeMiddleName" : {
              required : 'Please enter employee middle name.',
              maxlength: 'Maximum 20 characters are allowed.',
              minlength: 'Minimum 3 characters are allowed.'
          },
          "employeeLastName" : {
              required : 'Please enter employee last name.',
              maxlength: 'Maximum 20 characters are allowed.',
              minlength: 'Minimum 3 characters are allowed.'
          },
          "employeeXeamCode" : {
              required : 'Please enter employee code.',
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
          "spouseCompanyName" : {
              required : "Please enter spouse's company name.",
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
          "personalEmail" : {
              required : 'Please enter personal email.',
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
              digits : true
          },
          "bankName" : {
              required : true,
              lettersonly : true,
              spacespecial : true
          },
          "accNo" : {
              required : true,
              digits : true
          },
          "receiptNo" : {
              required : true,
              digits : true
          },
          "amount" : {
              required : true,
              digits : true
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
              minlength : 10,
              maxlength : 12,
              digitHifun : true
          },
          "profilePic" : {
              accept: "image/*",
              filesize: 1048576   //1 MB
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
              spacespecial: true,
              lettersonly: true
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
              maxlength: 'Maximum 12 digits are allowed.',
              minlength: 'Minimum 10 digits are allowed.'
          },
          "profilePic" : {
              accept : 'Please select a valid image format.',
              filesize: 'Filesize should be less than 1 MB.'  
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
          "empDispensary":{
            alphanumeric: true
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
              alphanumeric: true,
              checkpanno: true,
              exactlength : 11
          },
          "pfNoDepartment" : {
              required : true,
              digits: true
          },
          "companyId" : {
              required : true              
          },

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
              alphanumeric : true
          },
          "preRoadStreet" : {
              required : true,
              locality : true
          },
          "preLocalityArea" : {
              required : true,
              locality : true
          },
          "perHouseNo" : {
              required : true,
              alphanumeric : true
          },
          "perRoadStreet" : {
              required : true,
              locality : true
          },
          "perLocalityArea" : {
              required : true,
              locality : true
          },
          "perPinCode" : {
              required : true,
              digits : true
          },
          "prePinCode" : {
              required : true,
              digits : true
          },
          "perEmergencyNumber": {
             digits : true,
             exactlengthdigits : 10
          },
          "preEmergencyNumber": {
             digits : true,
             exactlengthdigits : 10
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
              extension: "jpeg|jpg|png|pdf|doc",
              filesize: 2097152  //2 MB
          }
      },
      messages :{
          "docs2[]" : {
              required: 'Please select a file',
              extension : 'Please select a file in jpg, jpeg, png, pdf or doc format only.',
              filesize: 'Filesize should be less than 2 MB.'
          },
      }
    });

    $("#qualificationDocumentDetailsForm").validate({
        rules :{
          "qualificationDocs[]" : {
              required: true,
              extension: "jpeg|jpg|png|pdf|doc",
              filesize: 2097152  //2 MB
          }
      },
      messages :{
          "qualificationDocs[]" : {
              required: 'Please select a file',
              extension : 'Please select a file in jpg, jpeg, png, pdf or doc format only.',
              filesize: 'Filesize should be less than 2 MB.'
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
              alphanumericWithSpace : true
          },
          "orgPhone" : {
              required : true,
              minlength : 10,
              maxlength : 12,
              digitHifun : true
          },
          "orgEmail" : {
              required : true,
              email : true
          },
          "orgWebsite" : {
              url : true
          },
          "responsibilities" : {
              required : true,
          },
          "reportTo" : {
              required : true,
          },
          "salaryPerMonth" : {
              required : true,
              digits : true,
              maxlength:7
          },
          "perks" : {
              required : true,
          },
          "leavingReason" : {
              required : true,
              spacespecial : true,
              lettersonly : true
          },
          "orgPhoneStdCode" : {
            required : true,
            digits : true
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
              minlength : 'Phone number should be of minimum 10 digits.',
              maxlength : 'Phone number should be of maximum 12 digits.'
          },
          "orgPhoneStdCode" : {
            required : 'Please enter STD code.',
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
              maxlength : 'Salary per month should be of maximum 7 digits.'
          },
          "perks" : {
              required : "Please enter the perks.",
          },
          "leavingReason" : {
              required : "Please enter the reason for leaving.",
          },
          "orgWebsite" : {
              url : 'Please enter full website url with http or https.'
          }

      }
    });

    $("#referenceDetailsForm").validate({
        rules :{
          "ref1Name" : {
              required : true,
              lettersonly : true,
              spacespecial : true
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
              digits : true,
              exactlength : 10
          },
          "ref2Email" : {
              required : true,
              email : true
          },
          "ref2Name" : {
              required : true,
              lettersonly : true,
              spacespecial : true
          },
          "ref2Address" : {
              required : true,
          },
          "ref2Phone" : {
              required : true,
              digits : true,
              exactlength : 10
          }

      },
      messages :{
          "ref1Name" : {
              required : 'Please enter name.',
          },
          "ref1Phone" : {
              required : 'Please enter mobile number.',
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
              required : 'Please enter mobile number.',
          },
          "ref2Email" : {
              required : 'Please enter email.',
          },
          "ref2Address" : {
              required : 'Please enter address.',
          }

      }
    });

    $.validator.addMethod('filesize', function(value, element, param) {
      return this.optional(element) || (element.files[0].size <= param) 
    });

    $.validator.addMethod("checkpanno", function(value, element) {
    return this.optional(element) || /^[A-Za-z][A-Za-z\d]*$/i.test(value);
    }, "Please enter only alphanumeric value.");

    $.validator.addMethod("alphanumericWithSpace", function(value, element) {
    return this.optional(element) || /^[A-Za-z][A-Za-z. \d]*$/i.test(value);
    }, "Please enter only alphanumeric value.");

    $.validator.addMethod("alphanumericWithSpaceDot", function(value, element) {
    return this.optional(element) || /[^A-Za-z. \d]*$/i.test(value);
    }, "Please enter only alphabets and dot(.) ");

    $.validator.addMethod("digitHifun", function(value, element) {
    return this.optional(element) || /^[0-9-]+$/i.test(value);
    }, "Please enter only digits and -.");

    $.validator.addMethod("digitswdot", function(value, element) {
    return this.optional(element) || /^[0-9 . ,]+$/i.test(value);
    }, "Please enter only digits and , .");

    $.validator.addMethod("locality", function(value, element) {
    return this.optional(element) || /^[A-Za-z][A-Za-z.\ \d]*$/i.test(value);
    }, "Please enter only alphanumeric value.");

    $.validator.addMethod("email", function(value, element) {
    return this.optional(element) || /^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$/i.test(value);
    }, "Please enter a valid email address.");

    $.validator.addMethod("spacespecial", function(value, element) {
      return this.optional(element) || /^[a-zA-Z0-9-,]+(\s{0,1}[a-zA-Z0-9-, ])*$/i.test(value); 
    },"Please do not start with space or special characters.");

    $.validator.addMethod("lettersonly", function(value, element) {
    return this.optional(element) || /^[a-z," "]+$/i.test(value);
    }, "Please enter only alphabets and spaces.");

    $.validator.addMethod( "nowhitespace", function( value, element ) {
      return this.optional( element ) || /^\S+$/i.test( value );
    }, "Please do not enter white space." );

    jQuery.validator.addMethod("exactlength", function(value, element, param) {
       return this.optional(element) || value.length == param;
    }, $.validator.format("Please enter exactly {0} characters."));

    jQuery.validator.addMethod("exactlengthdigits", function(value, element, param) {
       return this.optional(element) || value.length == param;
    }, $.validator.format("Please enter exactly {0} digits."));
      
  </script>

  <script type="text/javascript">
    var languageCheckboxesVal = JSON.parse('<?php echo json_encode($data["profileData"]["languageCheckboxes"]);?>');

    //On load
    var arr = $("#languageIds").val();
    length = arr.length; 

    var display = '';
    
    for(var i=0; i < length; i++){
      var langName = $("#languageIds option[value='"+ arr[i] + "']").text();
      var checkBoxes = '<div class="row field-changes-below"><strong>'+langName+'</strong><label class="checkbox-inline"><input type="checkbox" value="1" id="readLang'+arr[i]+'" name="lang'+arr[i]+'[]">Read</label><label class="checkbox-inline"><input type="checkbox" value="2" id="writeLang'+arr[i]+'" name="lang'+arr[i]+'[]">Write</label><label class="checkbox-inline"><input type="checkbox" value="3" id="speakLang'+arr[i]+'" name="lang'+arr[i]+'[]">Speak</label></div>';

      display += checkBoxes;
    }

    $(".languageCheckboxes").html("");
    $(".languageCheckboxes").append(display);

    if(languageCheckboxesVal.length > 0){
      for(var i=0; i < length; i++){
        if(languageCheckboxesVal[i].read_language == 0){
          $('#readLang'+languageCheckboxesVal[i].language_id).prop("checked",false);
        }else{
          $('#readLang'+languageCheckboxesVal[i].language_id).prop("checked",true);
        }

        if(languageCheckboxesVal[i].write_language == 0){
          $('#writeLang'+languageCheckboxesVal[i].language_id).prop("checked",false);
        }else{
          $('#writeLang'+languageCheckboxesVal[i].language_id).prop("checked",true);
        }

        if(languageCheckboxesVal[i].speak_language == 0){
          $('#speakLang'+languageCheckboxesVal[i].language_id).prop("checked",false);
        }else{
          $('#speakLang'+languageCheckboxesVal[i].language_id).prop("checked",true);
        }
      }
    }

    //On change
    $("#languageIds.select2").on('change',function(){
      var arr = $(this).val();
      length = arr.length; 

      var display = '';
      
      for(var i=0; i < length; i++){
        var langName = $("#languageIds option[value='"+ arr[i] + "']").text();
        var checkBoxes = '<div class="row field-changes-below"><strong>'+langName+'</strong><label class="checkbox-inline"><input type="checkbox" value="1" name="lang'+arr[i]+'[]">Read</label><label class="checkbox-inline"><input type="checkbox" value="2" name="lang'+arr[i]+'[]">Write</label><label class="checkbox-inline"><input type="checkbox" value="3" name="lang'+arr[i]+'[]">Speak</label></div>';

        display += checkBoxes;
      }

      $(".languageCheckboxes").html("");
      $(".languageCheckboxes").append(display);
    });
  </script>

  <script type="text/javascript">
    var tabName = "{{@$data['tabName']}}";
    var lastInsertedEmployeee = "{{$lastInsertedEmployeee}}";
    console.log(lastInsertedEmployeee);
    
    $(document).ready(function(){

      $('.nav-tabs a[href="#tab_'+tabName+'"]').tab('show');

      var defaultProjectId = $('#projectId').val();
      
      if(defaultProjectId){
        $.ajax({
          type: 'POST',
          url: "{{ url('/employees/getProjectCompany') }}",
          data: {projectId: defaultProjectId},
          success: function (result) {
            $("#companyId").val(result.companyName);
            $("#pfNo").val(result.pfNo);
            $("#tanNo").val(result.tanNo);
            $("#certificateNo").val(result.certificateNo);
            $("#ptStateId").val(result.stateName);
            $("#esiLocationId").val(result.locationName);
            $("#esiNo").val(result.esiNo);
            $("#salaryHeadId").val(result.salaryHeadName);
            $("#salaryCycleId").val(result.salaryCycleName);
          }
        });
      }

      $('#projectId').on('change',function(){
        var projectId = $(this).val();

        $.ajax({
          type: 'POST',
          url: "{{ url('/employees/getProjectCompany') }}",
          data: {projectId: projectId},
          success: function (result) {
            $("#companyId").val(result.companyName);
            $("#pfNo").val(result.pfNo);
            $("#tanNo").val(result.tanNo);
            $("#certificateNo").val(result.certificateNo);
            $("#ptStateId").val(result.stateName);
            $("#esiLocationId").val(result.locationName);
            $("#esiNo").val(result.esiNo);
            $("#salaryHeadId").val(result.salaryHeadName);
            $("#salaryCycleId").val(result.salaryCycleName);
          }
        });
      });

      $(".approveTheEmployee").on('click',function(){
        var approveUrl = "{{@$data['empApproveUrl']}}"; 
        var employeeId = "{{@$data['employeeId']}}";  
        if(approveUrl != ""){
          if (!confirm("Are you sure you want to approve the employee?")) {
              return false; 
          }else{
              $.ajax({
                 type: 'POST',
                 url: approveUrl,
                 data: {employeeId: employeeId},
                 success: function (result) {
                    if(result.approved == 1){
                      $('#approveEmployeeLink').hide();
                      $("#empApprover").text(result.approverName);
                    }
                 }   
              });
          }
          
        }
        
      });

      $('.maritalStatus').on('click',function(){
        var marStatus = $(this).val();
        if(marStatus == "Unmarried"){
          $(".spouseName").hide();
          $(".spouseWorking").hide();
        }else if(marStatus == "Married"){
          $(".spouseName").show();
          $("#spouseWorkingStatus").show();
          $("#spouseWorkingStatus1").prop("checked", true);
          $(".spouseWorking").hide();
        }else{
          $(".spouseName").show();
          $(".spouseWorking").hide();
          $("#spouseWorkingStatus").hide();
        }
      });

      $('.spouseWorkingStatus').on('click',function(){

        var marStatus = $(".maritalStatus").val();
        var workingStatus = $('input[name=spouseWorkingStatus]:checked').val();
        
        if(marStatus == "Married" && workingStatus == "Yes"){
          $(".spouseWorking").show();
        }else{
          $(".spouseWorking").hide();
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

      $(".basicFormSubmit").click(function(){
        console.log(allowFormSubmit);

          if(allowFormSubmit.mobile == 1 && allowFormSubmit.email == 1 && allowFormSubmit.referralCode == 1 && allowFormSubmit.marriageDate == 1 && allowFormSubmit.birthDate == 1){
            $("#basicDetailsForm").submit();
          }else{
            return false;
          }
      });

      $(".profileFormSubmit").click(function(){
          if(lastInsertedEmployeee != "0"){
            if(allowProfileFormSubmit.contractDate == 1){
              $("#noEmployeeProfile").hide();
              $("#profileDetailsForm").submit();  
            }else{
              return false;
            }
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

      $(".addressFormSubmit").click(function(){
          if(lastInsertedEmployeee != "0"){
            $("#noEmployeeAddress").hide();
            $("#addressDetailsForm").submit();
          }else{
            $("#noEmployeeAddress").show();
            $("#noEmployeeAddress").fadeOut(6000);
            return false;
          }
      });

      $(".accountFormSubmit").click(function(){
          if(lastInsertedEmployeee != "0"){
            $("#noEmployeeAccount").hide();
            $("#accountDetailsForm").submit();
          }else{
            $("#noEmployeeAccount").show();
            $("#noEmployeeAccount").fadeOut(6000);
            return false;
          }
      });

      $(".historyFormSubmit").click(function(){
          if(lastInsertedEmployeee != "0"){
            if(employeeHistorySubmit.fromDate == 1 && employeeHistorySubmit.toDate == 1){
              $("#noEmployeeHistory").hide();
              $("#historyDetailsForm").submit();
            }else{
              return false;
            }

          }else{
            $("#noEmployeeHistory").show();
            $("#noEmployeeHistory").fadeOut(6000);
            return false;
          }
      });

      $(".referenceFormSubmit").click(function(){
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
            $("#preHouseNo").val($("#perHouseNo").val());
            //$("#perHouseName").val($("#preHouseName").val());
            $("#preRoadStreet").val($("#perRoadStreet").val());
            $("#preLocalityArea").val($("#perLocalityArea").val());
            $("#prePinCode").val($("#perPinCode").val());

            $(".preEmergencyNumberStdId").val($(".perEmergencyNumberStdId").val());
            $("#preEmergencyNumber").val($("#perEmergencyNumber").val());

            $(".preCountryId").val($('.perCountryId').val());
            $(".preStateId").val($('.perStateId').val());
            $(".preCityId").val($('.perCityId').val());
          }else{
            $("#preHouseNo").val("");
            //$("#perHouseName").val("");
            $("#preRoadStreet").val("");
            $("#preLocalityArea").val("");
            $("#prePinCode").val("");

            $(".preEmergencyNumberStdId").val($(".perEmergencyNumberStdId").val());
            $("#preEmergencyNumber").val("");

            $(".preCountryId").val($('.perCountryId').val());
            $(".preStateId").val($('.perStateId').val());
            $(".preCityId").val($('.perCityId').val());
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

    $("#insuranceExpiryDate").datepicker({
      minDate: today,
      autoclose: true,
      orientation: "bottom"
    });

    $("#fromDate").datepicker({
      maxDate: yesterday,
      autoclose: true,
      orientation: "bottom"
    });

    $("#toDate").datepicker({
      maxDate: yesterday,
      autoclose: true,
      orientation: "bottom"
    });

    $("#joiningDate").datepicker({
      autoclose: true,
      orientation: "bottom"
    });

    $("#contractSignedDate").datepicker({
      maxDate: today, 
      autoclose: true,
      orientation: "bottom"
    });

    $("#contractSignedDate").on('change',function(){
      var date = $(this).val();

      if(Date.parse(date) > Date.parse(today)){
        allowProfileFormSubmit.contractDate = 0;
        $(".contractSignedDateErrors").text("Please select a valid date.").css("color","#f00");
          $(".contractSignedDateErrors").show();
          return false;
      }else{
        allowProfileFormSubmit.contractDate = 1;
        $(".contractSignedDateErrors").text("");
          $(".contractSignedDateErrors").hide();
      }
    });

    $("#birthDate").on('change',function(){
      var date = $(this).val();
      var marriageDate = $('#marriageDate').val();

      if(Date.parse(date) > Date.parse(yesterday)){
        allowFormSubmit.birthDate = 0;
        $(".birthDateErrors").text("Please select a valid date.")
        $(".birthDateErrors").show();
        return false;
      }

      if(Date.parse(date) >= Date.parse(marriageDate)){
        allowFormSubmit.birthDate = 0;
        $(".birthDateErrors").text("Birth date should be less than marriage date.")
        $(".birthDateErrors").show();
      }else{
        allowFormSubmit.birthDate = 1;
        $(".birthDateErrors").text("");
        $(".birthDateErrors").hide("");
      }
    });

    $("#fromDate").on('change',function(){
      var date = $(this).val();
      var toDate = $('#toDate').val();

      if(Date.parse(date) > Date.parse(yesterday)){
        employeeHistorySubmit.fromDate = 0;
        $(".fromDateErrors").text("Please select a valid date.").css('color','#f00');
        $(".fromDateErrors").show();

        return false;
      }

      if(Date.parse(date) >= Date.parse(toDate)){
        employeeHistorySubmit.fromDate = 0;
        $(".fromDateErrors").text("From date should be less than To date.").css('color','#f00');
        $(".fromDateErrors").show();
      }else{
        employeeHistorySubmit.fromDate = 1;
        $(".fromDateErrors").text("");
        $(".fromDateErrors").hide("");
      }
    });

    $("#toDate").on('change',function(){
      var date = $(this).val();
      var fromDate = $('#fromDate').val();

      if(Date.parse(date) > Date.parse(yesterday)){
        employeeHistorySubmit.toDate = 0;
        $(".toDateErrors").text("Please select a valid date.").css('color','#f00');
        $(".toDateErrors").show();

        return false; 
      }

      if(Date.parse(date) <= Date.parse(fromDate)){
        employeeHistorySubmit.toDate = 0;
        $(".toDateErrors").text("To date should be greater than From date.").css('color','#f00');
        $(".toDateErrors").show();
      }else{
        employeeHistorySubmit.toDate = 1;
        $(".toDateErrors").text("");
        $(".toDateErrors").hide("");
      }
    });


    $("#marriageDate").on('change',function(){
      var date = $(this).val();
      var birthDate = $('#birthDate').val();
      
      if(Date.parse(date) > Date.parse(yesterday)){
        allowFormSubmit.marriageDate = 0;
        $(".marriageDateErrors").text("Please select a valid date.")
        $(".marriageDateErrors").show();
        return false;

      }

      if(Date.parse(date) <= Date.parse(birthDate)){
        allowFormSubmit.marriageDate = 0;
        $(".marriageDateErrors").text("Marriage date should be greater than birth date.")
        $(".marriageDateErrors").show();

      }else{
        allowFormSubmit.marriageDate = 1;
        $(".marriageDateErrors").text("");
        $(".marriageDateErrors").hide("");
      }
    });
      
    
  </script>

  @endsection