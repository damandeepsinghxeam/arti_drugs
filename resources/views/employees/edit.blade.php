@extends('admins.layouts.app')

@section('content')

    <style>
        .es-first-col {
            padding: 0;
        }
        .es-second-col {
            padding: 0 5px;
        }
        .es-third-col {
            padding: 0;
        }
        .es-fourth-col {
            padding: 0 0px 0 10px;
        }
        .es-third-col button, .es-fourth-col button {
            padding: 4px 10px;
        }
        .appended-shiftss {
            margin-top: 10px;
        }
        .a_r_style {
            font-size: 16px;
            color: white;
            margin: 0 2px;
        }
        .a_r_style_green, .a_r_style_red {
            padding: 6px 8px;
            border-radius: 20px;
        }
        .a_r_style_green {
            background-color: green;
        }
        .a_r_style_red {
            background-color: red;
        }

        .currency {
            padding-left:12px;
        }

        .currency-symbol {
            position:absolute;
            padding: 2px 5px;
            margin-top: 3px;
        }
    </style>

    <!-- Content Wrapper. Contains page content -->



    <div class="content-wrapper">

        <!-- Content Header (Page header) -->

        <section class="content-header">

            <h1>

                Edit Employee Forms

                @can('approve-employee')

                    @if(!empty($data['approve_url']))

                        <small style="padding-left: 30px;" id="approveEmployeeLink"><a href='javascript:void(0)' class="btn btn-info approveTheEmployee">Approve Employee</a></small>

                    @endif

                @endcan



                <small style="padding-left: 30px;" class="empCreator">Created By: <span class="label label-success" id="empCreator">{{@$data['user']->employee->creator->employee->fullname}}</span></small>

                <small style="padding-left: 30px;" class="empApprover">Approved By: <span class="label label-success" id="empApprover">{{@$data['approver_name']}}</span></small>



            </h1>

            <ol class="breadcrumb">

                <li><a href="{{ url('employees/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>

                <li><a href="{{ url('employees/list') }}">Employees List</a></li>

            </ol>

        </section>

    @php

        $last_inserted_employee = $data['user']->id;

    @endphp



    <!-- Main content -->

        <section class="content">

            <!-- Small boxes (Stat box) -->

            <div class="row">

                <div class="col-md-12">

                    <!-- Custom Tabs -->

                    <div class="nav-tabs-custom">

                        <ul class="nav nav-tabs edit-nav-styling">

                            <li id="basicDetailsTab" class=""><a href="#tab_basicDetailsTab" data-toggle="tab">Basic Details</a></li>

                            <li id="projectDetailsTab" class=""><a href="#tab_projectDetailsTab" data-toggle="tab">Project Details</a></li>

                            <li id="documentDetailsTab" class=""><a href="#tab_documentDetailsTab" data-toggle="tab">Document Upload</a></li>

                            <li id="accountDetailsTab" class=""><a href="#tab_accountDetailsTab" data-toggle="tab">HR Details</a></li>

                            <li id="addressDetailsTab" class=""><a href="#tab_addressDetailsTab" data-toggle="tab">Contact Details</a></li>

                            <li id="historyDetailsTab" class=""><a href="#tab_historyDetailsTab" data-toggle="tab">Employment History</a></li>

                            <li id="referenceDetailsTab" class=""><a href="#tab_referenceDetailsTab" data-toggle="tab">Reference Details</a></li>

                            <li id="securityDetailsTab" class=""><a href="#tab_securityDetailsTab" data-toggle="tab">Security Details</a></li>

                            <li id="kraDetailsTab" class=""><a href="#tab_kraDetailsTab" data-toggle="tab">KRA</a></li>

                            <li id="salaryStructureTab" class=""><a href="#tab_salaryStructureTab" data-toggle="tab">Salary Structure</a></li>



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



                                <button class="btn btn-primary">UID {{$data['user']->id}}</button>

                                <!-- form start -->

                                <form id="basicDetailsForm" class="form-horizontal" action="{{ url('employees/edit-basic-details') }}" method="POST" enctype="multipart/form-data">

                                    {{ csrf_field() }}

                                    <div class="box-body">





                                        <div class="form-group">

                                            <label for="employeeName" class="col-md-2 control-label basic-detail-label">Employee Name<span style="color:red">*</span></label>

                                            <div class="col-md-1 salu-change">

                                                <select class="form-control input-sm basic-detail-input-style salutation" name="salutation">

                                                    <option value="Mr.">Mr.</option>

                                                    <option value="Ms.">Ms.</option>

                                                    <option value="Mrs.">Mrs.</option>

                                                </select>

                                            </div>



                                            <div class="names123">

                                                <div class="col-md-3 col-sm-4 first-name-basic">

                                                    <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style text-capitalize" name="employeeName" id="employeeName" placeholder="Please Enter Alphabets In First Name" value="{{@$data['user']->employee->first_name}}">

                                                </div>



                                                <div class="col-md-3 col-sm-4 middle-name-basic">

                                                    <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style text-capitalize" name="employeeMiddleName" id="employeeMiddleName" placeholder="Please Enter Alphabets In Middle Name" value="{{@$data['user']->employee->middle_name}}">

                                                </div>



                                                <div class="col-md-3 col-sm-4 last-name-basic">

                                                    <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style text-capitalize" name="employeeLastName" id="employeeLastName" placeholder="Please Enter Alphabets In Last Name" value="{{@$data['user']->employee->last_name}}">

                                                </div>

                                            </div>

                                        </div>



                                        <input type="hidden" name="employeeId" value="{{$data['user']->id}}">





                                        <div class="form-group form-sidechange">

                                            <div class="row">

                                                <div class="col-md-6 basic-detail-left">

                                                    <div class="row field-changes-below">

                                                        <label for="fatherName" class="col-md-4 control-label basic-detail-label">Father's Name<span style="color:red">*</span></label>



                                                        <div class="col-md-8 basic-input-left">

                                                            <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style text-capitalize" name="fatherName" id="fatherName" placeholder="Please Enter Alphabets In Father's Name." value="{{@$data['user']->employee->father_name}}">

                                                        </div>

                                                    </div>



                                                    <div class="row field-changes-below">

                                                        <label for="motherName" class="col-md-4 control-label basic-detail-label">Mother's Name<span style="color:red">*</span></label>



                                                        <div class="col-md-8 basic-input-left">

                                                            <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style text-capitalize" name="motherName" id="motherName" placeholder="Please Enter Alphabets In Mother's Name." value="{{@$data['user']->employee->mother_name}}">

                                                        </div>

                                                    </div>



                                                    <div class="row field-changes-below">

                                                        <label for="oldXeamCode" class="col-md-4 control-label basic-detail-label">Punch ID</label>



                                                        <div class="col-md-8 basic-input-left">

                                                            <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="oldXeamCode" id="oldXeamCode" placeholder="Please Enter Employee's ID." value="{{@$data['user']->employee->employee_id}}" readonly>

                                                        </div>

                                                    </div>



                                                    <div class="row field-changes-below">

                                                        <label for="employeeXeamCode" class="col-md-4 control-label basic-detail-label">Employee Code</label>



                                                        <div class="col-md-8 basic-input-left">

                                                            <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="employeeXeamCode" id="employeeXeamCode" placeholder="Please Enter Employee's Code." value="{{@$data['user']->employee_code}}" readonly>

                                                        </div>

                                                    </div>



                                                    <div class="row field-changes-below">

                                                        <label for="email" class="col-md-4 control-label basic-detail-label">Official Email</label>



                                                        <div class="col-md-8 basic-input-left">

                                                            <input autocomplete="off" type="email" class="form-control checkAjax input-sm basic-detail-input-style" id="email" name="email" placeholder="Please Enter Valid Email Id." value="{{@$data['user']->email}}" readonly>

                                                            <span class="checkEmail"></span>

                                                        </div>

                                                    </div>



                                                    <div class="row field-changes-below">

                                                        <label for="email" class="col-md-4 control-label basic-detail-label">Personal Email<span style="color:red">*</span></label>



                                                        <div class="col-md-8 basic-input-left">

                                                            <input autocomplete="off" type="email" class="form-control input-sm basic-detail-input-style" id="personalEmail" name="personalEmail" placeholder="Please Enter Valid Email Id." value="{{@$data['user']->employee->personal_email}}">

                                                        </div>

                                                    </div>



                                                    <div class="row field-changes-below">

                                                        <label for="mobile" class="col-md-4 control-label basic-detail-label">Mobile Number</label>



                                                        <div class="col-md-8 basic-input-left">

                                                            <div class="row">

                                                                <div class="col-md-4 basic-detail-mob-left">

                                                                    <select class="form-control input-sm basic-detail-input-style" name="mobileStdId" disabled>

                                                                        @if(!$data['countries']->isEmpty())

                                                                            @foreach($data['countries'] as $country)

                                                                                <option value="{{$country->id}}" @if(@$country->id == @$data['user']->employee->country_id){{'selected'}}@endif>(+{{@$country->phone_code}}) {{@$country->iso3}}</option>

                                                                            @endforeach

                                                                        @endif

                                                                    </select>

                                                                </div>



                                                                <div class="col-md-8 basic-detail-mob-right">

                                                                    <input autocomplete="off" type="text" class="form-control checkAjax input-sm basic-detail-input-style" id="mobile" name="mobile" placeholder="Please Enter 10 Digits Numeric Value In Mobile Number." value="{{@$data['user']->employee->mobile_number}}" readonly>

                                                                    <span class="checkMobile"></span>

                                                                </div>

                                                            </div>

                                                        </div>

                                                    </div>



                                                    <div class="row field-changes-below">

                                                        <label for="altMobile" class="col-md-4 control-label basic-detail-label">Alternative Mobile Number</label>



                                                        <div class="col-md-8 basic-input-left">

                                                            <div class="row">

                                                                <div class="col-md-4 basic-detail-mob-left">

                                                                    <select class="form-control input-sm basic-detail-input-style" name="altMobileStdId">

                                                                        @if(!$data['countries']->isEmpty())

                                                                            @foreach($data['countries'] as $country)

                                                                                <option value="{{$country->id}}" @if(@$country->id == @$data['user']->employee->alt_country_id){{'selected'}}@endif>(+{{@$country->phone_code}}) {{@$country->iso3}}</option>

                                                                            @endforeach

                                                                        @endif

                                                                    </select>

                                                                </div>



                                                                <div class="col-md-8 basic-detail-mob-right">

                                                                    <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" id="altMobile" name="altMobile" placeholder="Please Enter 10 Digits Numberic Value In Alternative Mobile Number." value="{{@$data['user']->employee->alternative_mobile_number}}">

                                                                </div>

                                                            </div>

                                                        </div>

                                                    </div>



                                                    <div class="row field-changes-below">

                                                        <label for="referral_code" class="col-md-4 control-label basic-detail-label">Referral Code</label>



                                                        <div class="col-md-8 basic-input-left">

                                                            <input autocomplete="off" type="text" class="form-control checkAjax input-sm basic-detail-input-style" id="referralCode" name="referralCode" placeholder="Please Enter Employee's Referral Code." value="{{@$data['user']->employee->referral_code}}" readonly>

                                                            <span class="checkReferral"></span>

                                                        </div>

                                                    </div>

                                                    <div class="row field-changes-below">
                                                        <label for="altMobile" class="col-md-4 control-label basic-detail-label">Attendance Type<span style="color: red">*</span></label>

                                                        <div class="col-md-8 basic-input-left">
                                                            <select class="form-control input-sm basic-detail-input-style" name="attendanceType" id="attendanceType">
                                                                <option value="" selected disabled>Please Select Attendance Type.</option>
                                                                <option value="Biometric">Biometric</option>
                                                                <option value="ESS">ESS</option>
                                                            </select>
                                                        </div>
                                                    </div>



                                                    <div class="row field-changes-below">

                                                        <label class="col-md-4 control-label basic-detail-label">Qualifications<span style="color:red">*</span></label>

                                                        <div class="col-md-8 basic-input-left">

                                                            <select class="form-control select2 input-sm basic-detail-input-style" name="qualificationIds[]" multiple="multiple" style="width: 100%;">

                                                                @if(!$data['qualifications']->isEmpty())

                                                                    @foreach($data['qualifications'] as $qualification)

                                                                        <option value="{{$qualification->id}}" @if(@$data['user']->qualifications->contains('id',$qualification->id)){{"selected"}}@endif>{{$qualification->name}}</option>

                                                                    @endforeach

                                                                @endif

                                                            </select>

                                                        </div>

                                                    </div>



                                                    <div class="row field-changes-below">

                                                        <label class="col-md-4 control-label basic-detail-label">Skills<span style="color:red">*</span></label>

                                                        <div class="col-md-8 basic-input-left">

                                                            <select class="form-control select2 input-sm basic-detail-input-style" name="skillIds[]" multiple="multiple" style="width: 100%;">

                                                                @if(!$data['skills']->isEmpty())

                                                                    @foreach($data['skills'] as $skill)

                                                                        <option value="{{$skill->id}}" @if(@$data['user']->skills->contains('id',$skill->id)){{"selected"}}@endif>{{$skill->name}}</option>

                                                                    @endforeach

                                                                @endif

                                                            </select>

                                                        </div>

                                                    </div>



                                                    <div class="row field-changes-below">

                                                        <label class="col-md-4 control-label basic-detail-label">Languages<span style="color:red">*</span></label>

                                                        <div class="col-md-8 basic-input-left">

                                                            <select class="form-control select2 input-sm basic-detail-input-style" id="languageIds" name="languageIds[]" multiple="multiple" style="width: 100%;">

                                                                @if(!$data['languages']->isEmpty())

                                                                    @foreach($data['languages'] as $language)

                                                                        <option value="{{$language->id}}" @if(@$data['user']->languages->contains('id',$language->id)){{"selected"}}@endif>{{$language->name}}</option>

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

                                                        <label class="col-md-4 control-label basic-detail-label">Previous Experience Years<span style="color:red">*</span></label>

                                                        <div class="col-md-8 basic-input-left">

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

                                                                <option value="13">13</option>

                                                                <option value="14">14</option>

                                                                <option value="15">15</option>

                                                                <option value="15+">15+</option>

                                                            </select>

                                                        </div>

                                                    </div>



                                                    <div class="row field-changes-below">

                                                        <label class="col-md-4 control-label basic-detail-label">Previous Experience Months<span style="color:red">*</span></label>

                                                        <div class="col-md-8 basic-input-left">

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

                                                        <label for="birthDate" class="col-md-4 control-label basic-detail-label">Date Of Birth<span style="color:red">*</span></label>

                                                        <div class="col-md-8 basic-input-left">

                                                            <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" id="birthDate" name="birthDate" placeholder="MM/DD/YYYY" value="{{date('m/d/Y',strtotime($data['user']->employee->birth_date))}}" readonly>

                                                            <span class="birthDateErrors"></span>

                                                        </div>

                                                    </div>



                                                    <div class="row field-changes-below">

                                                        <span class="col-md-4 control-label radio basic-detail-label basic-radio-label"><strong>Gender</strong></span>

                                                        <div class="col-md-8 basic-input-left">

                                                            <label class="basicradio1">

                                                                <input autocomplete="off" type="radio" name="gender" class="radio-style-basic" id="optionsRadios1" value="Male" @if($data['user']->employee->gender == "Male"){{"checked"}}@endif>

                                                                Male

                                                            </label>

                                                            <label class="basicradio2-gender">

                                                                <input autocomplete="off" type="radio" name="gender" class="radio-style-basic2" id="optionsRadios2" value="Female" @if($data['user']->employee->gender == "Female"){{"checked"}}@endif>

                                                                Female

                                                            </label>

                                                        </div>

                                                    </div>



                                                    <div class="row field-changes-below">

                                                        <label class="col-md-4 control-label basic-detail-label">Marital Status</label>

                                                        <div class="col-md-8 basic-input-left">

                                                            <select class="form-control maritalStatus input-sm basic-detail-input-style" name="maritalStatus">

                                                                <option value="Married">Married</option>

                                                                <option value="Unmarried">Unmarried</option>

                                                                <option value="Widowed">Widowed</option>

                                                                <option value="Divorced">Divorced</option>

                                                            </select>

                                                        </div>

                                                    </div>



                                                    <div class="row field-changes-below spouseName">

                                                        <label for="spouseName" class="col-md-4 control-label basic-detail-label">Spouse Name<span style="color:red">*</span></label>

                                                        <div class="col-md-8 basic-input-left">

                                                            <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style text-capitalize" id="spouseName" name="spouseName" placeholder="Please Enter Alphabets In Spouse's Name." value="@if(@$data['user']->employee->marital_status != 'Unmarried'){{@$data['user']->employee->spouse_name}}@endif">

                                                        </div>

                                                    </div>



                                                    <div class="row field-changes-below spouseName" id="spouseWorkingStatus">

                                                        <span class="col-md-4 control-label radio basic-detail-label"><strong>Spouse Working Status</strong></span>

                                                        <div class="col-md-8 basic-input-left">

                                                            <label class="basicradio">

                                                                <input autocomplete="off" type="radio" name="spouseWorkingStatus" class="radio-style-basic spouseWorkingStatus" id="spouseWorkingStatus1" value="No" @if(@$data['user']->employee->spouse_working_status == "No"){{"checked"}}@endif>

                                                                Non-working

                                                            </label>

                                                            <label class="basicradio2">

                                                                <input autocomplete="off" type="radio" name="spouseWorkingStatus" class="radio-style-basic2 spouseWorkingStatus" id="spouseWorkingStatus2" value="Yes" @if(@$data['user']->employee->spouse_working_status == "Yes"){{"checked"}}@endif>

                                                                Working

                                                            </label>

                                                        </div>

                                                    </div>



                                                    <div class="row field-changes-below spouseWorking">

                                                        <label for="spouseCompanyName" class="col-md-4 control-label basic-detail-label">Spouse Company Name<span style="color:red">*</span></label>



                                                        <div class="col-md-8 basic-input-left">

                                                            <input autocomplete="off" type="text" class="form-control input-sm" name="spouseCompanyName" id="spouseCompanyName" placeholder="Please Enter Alphabets In Spouse Company Name." value="{{@$data['user']->employee->spouse_company_name}}">

                                                        </div>

                                                    </div>



                                                    <div class="row field-changes-below spouseWorking">

                                                        <label class="col-md-4 control-label basic-detail-label">Spouse Designation<span style="color:red">*</span></label>

                                                        <div class="col-md-8 basic-input-left">

                                                            <select class="form-control input-sm basic-detail-input-style" name="spouseDesignation" id="spouseDesignation">

                                                                <option value="" selected disabled>Please Select Spouse's Designation.</option>

                                                                @if(!$data['roles']->isEmpty())

                                                                    @foreach($data['roles'] as $role)

                                                                        <option value="{{$role->id}}" @if($role->id == @$data['user']->employee->spouse_designation){{"selected"}}@endif>{{$role->name}}</option>

                                                                    @endforeach

                                                                @endif

                                                            </select>

                                                        </div>

                                                    </div>



                                                    <div class="row field-changes-below spouseWorking">

                                                        <label for="spouseContactNumber" class="col-md-4 control-label basic-detail-label">Spouse Contact Number<span style="color:red">*</span></label>



                                                        <div class="col-md-8 basic-input-left">

                                                            <input autocomplete="off" type="text" class="form-control input-sm" name="spouseContactNumber" id="spouseContactNumber" placeholder="Please Enter Alphabets In Spouse Contact Number." value="{{@$data['user']->employee->spouse_contact_number}}">

                                                        </div>

                                                    </div>



                                                    <div class="row field-changes-below spouseName">

                                                        <label for="marriageDate" class="col-md-4 control-label basic-detail-label">Marriage Date<span style="color:red">*</span></label>

                                                        <div class="col-md-8 basic-input-left">

                                                            <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" id="marriageDate" name="marriageDate" placeholder="MM/DD/YYYY" value="@if(@$data['user']->employee->marital_status != 'Unmarried' && @$data['user']->employee->marriage_date){{date('m/d/Y',strtotime($data['user']->employee->marriage_date))}}@endif" readonly>

                                                            <span class="marriageDateErrors"></span>

                                                        </div>

                                                    </div>



                                                    <div class="row field-changes-below">

                                                        <label for="profilePic" class="col-md-4 control-label basic-detail-label">Profile Picture</label>

                                                        <div class="col-md-8 basic-input-left">

                                                            <input autocomplete="off" type="file" id="profilePic" name="profilePic" class="input-sm">

                                                        </div>

                                                    </div>



                                                    <div class="row field-changes-below">

                                                        <span class="col-md-4 control-label radio basic-detail-label"><strong>Nominee Type</strong></span>

                                                        <div class="col-md-8 basic-input-left">

                                                            <label class="basicradio">

                                                                <input autocomplete="off" type="radio" name="nomineeType" class="radio-style-basic nomineeType" id="nomineeType1" value="PF" @if(@$data['user']->employee->nominee_type == "PF"){{"checked"}}@endif>

                                                                PF

                                                            </label>

                                                            <label class="basicradio2">

                                                                <input autocomplete="off" type="radio" name="nomineeType" class="radio-style-basic2 nomineeType" id="nomineeType2" value="Insurance" @if(@$data['user']->employee->nominee_type == "Insurance"){{"checked"}}@endif>

                                                                Insurance

                                                            </label>

                                                            <label class="basicradio3">

                                                                <input autocomplete="off" type="radio" name="nomineeType" class="radio-style-basic3 nomineeType" id="nomineeType3" value="NA" @if(@$data['user']->employee->nominee_type == "NA"){{"checked"}}@endif>

                                                                NA

                                                            </label>

                                                        </div>

                                                    </div>



                                                    <div class="row field-changes-below nomineeInsurance">

                                                        <label for="insuranceCompanyName" class="col-md-4 control-label basic-detail-label">Insurance Company Name<span style="color:red">*</span></label>



                                                        <div class="col-md-8 basic-input-left">

                                                            <input autocomplete="off" type="text" class="form-control input-sm" name="insuranceCompanyName" id="insuranceCompanyName" placeholder="Please Enter Alphabets In Insurance Company Name." value="{{@$data['user']->employee->insurance_company_name}}">

                                                        </div>

                                                    </div>



                                                    <div class="row field-changes-below nomineeInsurance">

                                                        <label for="coverAmount" class="col-md-4 control-label basic-detail-label">Premium & Cover Amount<span style="color:red">*</span></label>



                                                        <div class="col-md-8 basic-input-left">

                                                            <input autocomplete="off" type="text" class="form-control input-sm" name="coverAmount" id="coverAmount" placeholder="Please Enter Digits In Amount." value="{{@$data['user']->employee->cover_amount}}">

                                                        </div>

                                                    </div>



                                                    <div class="row field-changes-below nomineeInsurance">

                                                        <label for="typeOfInsurance" class="col-md-4 control-label basic-detail-label">Type Of Insurance<span style="color:red">*</span></label>



                                                        <div class="col-md-8 basic-input-left">

                                                            <input autocomplete="off" type="text" class="form-control input-sm" name="typeOfInsurance" id="typeOfInsurance" placeholder="Please Enter Alphabets In Type of Insurance." value="{{@$data['user']->employee->type_of_insurance}}">

                                                        </div>

                                                    </div>



                                                    <div class="row field-changes-below nomineeInsurance">

                                                        <label for="insuranceExpiryDate" class="col-md-4 control-label basic-detail-label">Insurance Expiry Date<span style="color:red">*</span></label>

                                                        <div class="col-md-8 basic-input-left">

                                                            <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" id="insuranceExpiryDate" name="insuranceExpiryDate" placeholder="MM/DD/YYYY" value="@if(@$data['user']->employee->insurance_expiry_date){{date('m/d/Y',strtotime($data['user']->employee->insurance_expiry_date))}}@endif" readonly>

                                                            <span class="insuranceExpiryDateErrors"></span>

                                                        </div>

                                                    </div>



                                                    <div class="row field-changes-below noNomineeType">

                                                        <label for="nominee" class="col-md-4 control-label basic-detail-label">Nominee Name<span style="color:red">*</span></label>



                                                        <div class="col-md-8 basic-input-left">

                                                            <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="nominee" id="nominee" placeholder="Please Enter Alphabets In Nominee's Name." value="{{@$data['user']->employee->nominee_name}}">

                                                        </div>

                                                    </div>



                                                    <div class="row field-changes-below noNomineeType">

                                                        <label for="relation" class="col-md-4 control-label basic-detail-label">Relation<span style="color:red">*</span></label>



                                                        <div class="col-md-8 basic-input-left">

                                                            <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="relation" id="relation" placeholder="Please Enter Alphabets In Relation." value="{{@$data['user']->employee->relation}}">

                                                        </div>

                                                    </div>



                                                    <div class="row field-changes-below">

                                                        <label for="registrationFees" class="col-md-4 control-label basic-detail-label">Registration Fees</label>

                                                        <div class="col-md-8 basic-input-left">

                                                            <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="registrationFees" id="registrationFees" placeholder="Please Enter Digits in Registration Fees." value="{{@$data['user']->employee->registration_fees}}">

                                                        </div>

                                                    </div>



                                                    <div class="row field-changes-below">

                                                        <label for="applicationNumber" class="col-md-4 control-label basic-detail-label">Application Number</label>

                                                        <div class="col-md-8 basic-input-left">

                                                            <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="applicationNumber" id="applicationNumber" placeholder="Please Enter Alphabets In Application Number." value="{{@$data['user']->employee->application_number}}">

                                                        </div>

                                                    </div>

                                                    <div class="row field-changes-below">

                                                        <label for="joiningDate" class="col-md-4 control-label basic-detail-label">Date Of Joining<span style="color:red">*</span></label>

                                                        <div class="col-md-8 basic-input-left">

                                                            <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" id="joiningDate" name="joiningDate" placeholder="MM/DD/YYYY" value="@if(@$data['user']->employee->joining_date){{date('m/d/Y',strtotime($data['user']->employee->joining_date))}}@endif" readonly>

                                                        </div>

                                                    </div>



                                                    <input type="hidden" name="formSubmitButton" class="basicFormSubmitButton">







                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                    <!-- /.box-body -->

                                    <div class="box-footer">

                                        <button type="button" class="btn btn-info basicFormSubmit" id="basicFormSubmit" name="formSubmitButton" value="sc">Save & Continue</button>

                                        <button type="button" class="btn btn-default basicFormSubmit" name="formSubmitButton" value="se">Save & Exit</button>

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

                                <form id="profileDetailsForm" class="form-horizontal" action="{{ url('employees/edit-profile-details') }}" method="POST" enctype="multipart/form-data">

                                    {{ csrf_field() }}

                                    <div class="box-body">

                                        <hr>

                                        <div class="form-group form-sidechange">

                                            <div class="row">

                                                <div class="col-md-6">



                                                    <div class="row field-changes-below">

                                                        <label class="col-md-4 control-label basic-detail-label">Project<span style="color:red">*</span></label>

                                                        <div class="col-md-8 basic-input-left">

                                                            <select class="form-control input-sm basic-detail-input-style" name="projectId" id="projectId">

                                                                <option value="" selected disabled>Please Select Employee's Project.</option>

                                                                @if(!$data['projects']->isEmpty())

                                                                    @foreach($data['projects'] as $project)

                                                                        <option value="{{$project->id}}" @if(@$data['user']->projects->contains('id',$project->id)){{'selected'}}@endif>{{$project->name}}</option>

                                                                    @endforeach

                                                                @endif

                                                            </select>

                                                        </div>

                                                    </div>



                                                    <div class="row field-changes-below">

                                                        <label for="companyId" class="col-md-4 control-label basic-detail-label">Company</label>



                                                        <div class="col-md-8 basic-input-left">

                                                            <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="companyId" id="companyId" value="None" readonly>

                                                        </div>

                                                    </div>



                                                    <div class="row field-changes-below">

                                                        <label for="pfNo" class="col-md-4 control-label basic-detail-label">PF Number</label>



                                                        <div class="col-md-8 basic-input-left">

                                                            <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="pfNo" id="pfNo" value="None" readonly>

                                                        </div>

                                                    </div>



                                                    <div class="row field-changes-below" id="tanNoBox">

                                                        <label for="tanNo" class="col-md-4 control-label basic-detail-label">TAN Number</label>



                                                        <div class="col-md-8 basic-input-left">

                                                            <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="tanNo" id="tanNo" value="None" readonly>

                                                        </div>

                                                    </div>



                                                    <div class="row field-changes-below">

                                                        <label for="ptStateId" class="col-md-4 control-label basic-detail-label">Project States</label>



                                                        <div class="col-md-8 basic-input-left">

                                                            <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="ptStateId" id="ptStateId" value="None" readonly>

                                                        </div>

                                                    </div>



                                                    <div class="row field-changes-below">

                                                        <label for="esiLocationId" class="col-md-4 control-label basic-detail-label">ESI Locations</label>



                                                        <div class="col-md-8 basic-input-left">

                                                            <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="esiLocationId" id="esiLocationId" value="None" readonly>

                                                        </div>

                                                    </div>



                                                    <div class="row field-changes-below">

                                                        <label for="salaryHeadId" class="col-md-4 control-label basic-detail-label">Salary Structure</label>



                                                        <div class="col-md-8 basic-input-left">

                                                            <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="salaryHeadId" id="salaryHeadId" value="None" readonly>

                                                        </div>

                                                    </div>



                                                    <div class="row field-changes-below">

                                                        <label for="salaryCycleId" class="col-md-4 control-label basic-detail-label">Salary Cycle</label>



                                                        <div class="col-md-8 basic-input-left">

                                                            <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="salaryCycleId" id="salaryCycleId" value="None" readonly>

                                                        </div>

                                                    </div>



                                                    <div class="row field-changes-below">

                                                        <label class="col-md-4 control-label basic-detail-label">State<span style="color: red">*</span></label>

                                                        <div class="col-md-8 basic-input-right">

                                                            <select class="form-control input-sm basic-detail-input-style" name="stateId">

                                                                <option value="" selected disabled>Please Select Employee's State.</option>

                                                                @if(!$data['states']->isEmpty())

                                                                    @foreach($data['states'] as $state)

                                                                        <option value="{{$state->id}}" @if($state->id == @$data['user']->employeeProfile->state_id){{'selected'}}@endif>{{$state->name}}</option>

                                                                    @endforeach

                                                                @endif

                                                            </select>

                                                        </div>

                                                    </div>



                                                    <div class="row field-changes-below">

                                                        <label class="col-md-4 control-label basic-detail-label">ESI Location<span style="color: red">*</span></label>

                                                        <div class="col-md-8 basic-input-right">

                                                            <select class="form-control input-sm basic-detail-input-style" name="locationId">

                                                                <option value="" selected disabled>Please Select Employee's Location.</option>

                                                                @if(!$data['locations']->isEmpty())

                                                                    @foreach($data['locations'] as $location)

                                                                        <option value="{{$location->id}}" @if(@$data['user']->locations->contains('id',$location->id)){{'selected'}}@endif>{{$location->name}}</option>

                                                                    @endforeach

                                                                @endif

                                                            </select>

                                                        </div>

                                                    </div>



                                                    <div class="row field-changes-below">

                                                        <label class="col-md-4 control-label basic-detail-label">Department<span style="color: red">*</span></label>



                                                        <div class="col-md-8 basic-input-right">

                                                            <select class="form-control input-sm basic-detail-input-style" name="departmentId" id="departmentId">

                                                                <option value="" selected disabled>Please Select Employee's Department</option>

                                                                @if(!$data['departments']->isEmpty())

                                                                    @foreach($data['departments'] as $department)

                                                                        <option value="{{$department->id}}" @if($department->id == @$data['user']->employeeProfile->department_id){{'selected'}}@endif>{{$department->name}}</option>

                                                                    @endforeach

                                                                @endif

                                                            </select>

                                                        </div>

                                                    </div>



                                                </div>



                                                <div class="col-md-6">



                                                    <div class="row field-changes-below">

                                                        <label class="col-md-4 control-label basic-detail-label">Sanction Officer's Departments<span style="color: red">*</span></label>

                                                        <div class="col-md-8 basic-input-right">

                                                            <select class="form-control input-sm basic-detail-input-style select2" name="managerDepartmentIds[]" style="width: 100%;" id="managerDepartmentIds" multiple>

                                                                @if(!$data['departments']->isEmpty())

                                                                    @foreach($data['departments'] as $department)

                                                                        <option value="{{$department->id}}" @if(in_array($department->id,$data['so_departments'])){{'selected'}}@endif>{{$department->name}}</option>

                                                                    @endforeach

                                                                @endif

                                                            </select>

                                                        </div>

                                                    </div>



                                                    <div class="row field-changes-below">

                                                        <label class="col-md-4 control-label basic-detail-label">SO-1 (Manager)<span style="color: red">*</span></label>

                                                        <div class="col-md-8 basic-input-right">

                                                            <select class="form-control input-sm basic-detail-input-style select2" name="employeeIds" style="width: 100%;" id="employeeIds">

                                                                <option value="" selected disabled>Please Select Sanction Officer</option>

                                                            </select>

                                                        </div>

                                                    </div>



                                                    <div class="row field-changes-below">

                                                        <label class="col-md-4 control-label basic-detail-label">SO-2 (HOD)</label>

                                                        <div class="col-md-8 basic-input-right">

                                                            <select class="form-control input-sm basic-detail-input-style select2" name="hodId" style="width: 100%;" id="hodId">

                                                                <option value="" selected disabled>Please Select Sanction Officer</option>

                                                            </select>

                                                        </div>

                                                    </div>



                                                    <div class="row field-changes-below">

                                                        <label class="col-md-4 control-label basic-detail-label">SO-3 (HR)</label>

                                                        <div class="col-md-8 basic-input-right">

                                                            <select class="form-control input-sm basic-detail-input-style select2" name="hrId" style="width: 100%;" id="hrId">

                                                                <option value="" selected disabled>Please Select Sanction Officer</option>

                                                            </select>

                                                        </div>

                                                    </div>



                                                    <div class="row field-changes-below">

                                                        <label class="col-md-4 control-label basic-detail-label">SO-4 (MD)</label>

                                                        <div class="col-md-8 basic-input-right">

                                                            <select class="form-control input-sm basic-detail-input-style select2" name="mdId" style="width: 100%;" id="mdId">

                                                                <option value="" selected disabled>Please Select Sanction Officer</option>

                                                            </select>

                                                        </div>

                                                    </div>


                                                    <div class="row field-changes-below">

                                                        <label class="col-md-4 control-label basic-detail-label">Shift Timing<span style="color:red">*</span></label>

                                                        <div class="col-md-8 basic-input-left">

                                                            <select class="form-control input-sm basic-detail-input-style" name="shiftTimingId">

                                                                <option value="" selected disabled>Please Select Employee's Shift Timing.</option>

                                                                @if(!$data['shifts']->isEmpty())

                                                                    @foreach($data['shifts'] as $shift)

                                                                        <option value="{{$shift->id}}" @if($shift->id == @$data['user']->employeeProfile->shift_id){{"selected"}}@endif>{{$shift->name}}</option>

                                                                    @endforeach

                                                                @endif

                                                            </select>

                                                        </div>

                                                    </div>

                                                    <div class="row field-changes-below" id="dynamic_field">

                                                        <label class="col-md-4 control-label basic-detail-label">Shift Timing exceptions</label>
                                                        @php
                                                            $data['days']=array("Sunday", "Monday", "Tuesday", "Wednesday", "Thrusday", "Friday", "Saturday");
                                                        @endphp

                                                        @if(!$data['shift_exception_details']->isEmpty())

                                                            @foreach($data['shift_exception_details'] as $shift_exception_detail)

                                                                <div class="col-md-8 basic-input-right">
                                                                    <div id="row{{@$shift_exception_detail->id}}">
                                                                        <div class="col-md-5 es-first-col">
                                                                            <select class="form-control input-sm basic-detail-input-style" name="exceptionshiftTimingId[]">
                                                                                <option value="" selected disabled>Select Shift</option>
                                                                                @foreach($data['shifts'] as $shift)
                                                                                    <option value="{{$shift->id}}"@if($shift->id == @$shift_exception_detail->shift_id){{"selected"}}@endif>{{$shift->name}}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>

                                                                        <div class="col-md-4 es-second-col">
                                                                            <input type="hidden" name="shiftexcept[]" value="{{@$shift_exception_detail->id}}" />
                                                                            <select class="form-control input-sm basic-detail-input-style" name="exceptionshiftday[]">
                                                                                <option value="" selected disabled>Select day </option>
                                                                                @foreach($data['days'] as $key=>$day)
                                                                                    <option value="{{$key}}"@if($key == @$shift_exception_detail->week_day){{"selected"}}@endif>{{$day}}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-md-1 es-third-col">
                                                                            <button type="button" name="remove" id="{{@$shift_exception_detail->id}}" class="btn btn-danger btn_remove">
                                                                                <i class="fa fa-minus"></i>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2 es-fourth-col">
                                                                        <button type="button" name="add" id="add" class="btn btn-success basic-input-right">
                                                                            <i class="fa fa-plus"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            @endforeach

                                                        @else
                                                            <div class="col-md-8 basic-input-right">
                                                                <div class="col-md-5 es-first-col">
                                                                    <select class="form-control input-sm basic-detail-input-style" name="exceptionshiftTimingId_new[]">
                                                                        <option value="" selected disabled>Select Shift</option>
                                                                        @foreach($data['shifts'] as $shift)
                                                                            <option value="{{$shift->id}}">{{$shift->name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-4 es-second-col">
                                                                    <select class="form-control input-sm basic-detail-input-style" name="exceptionshiftday_new[]">
                                                                        <option value="" selected disabled>Select day</option>
                                                                        @foreach($data['days'] as $key=>$day)
                                                                            <option value="{{$key}}">{{$day}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-1 es-third-col">
                                                                    <button type="button" name="add" id="add" class="btn btn-success basic-input-right">
                                                                        <i class="fa fa-plus"></i>
                                                                    </button>
                                                                </div>
                                                            </div>

                                                        @endif
                                                    </div>



                                                    <div class="row field-changes-below">

                                                        <label class="col-md-4 control-label basic-detail-label">Perks<span style="color:red">*</span></label>

                                                        <div class="col-md-8 basic-input-left">

                                                            <select class="form-control select2 input-sm basic-detail-input-style" name="perkIds[]" multiple="multiple" style="width: 100%;">

                                                                @if(!$data['perks']->isEmpty())

                                                                    @foreach($data['perks'] as $perk)

                                                                        <option value="{{$perk->id}}" @if(@$data['user']->perks->contains('id',$perk->id)){{'selected'}}@endif>{{$perk->name}}</option>

                                                                    @endforeach

                                                                @endif

                                                            </select>

                                                        </div>

                                                    </div>



                                                    <div class="row field-changes-below">

                                                        <label class="col-md-4 control-label basic-detail-label">Probation Period</label>

                                                        <div class="col-md-8 basic-input-left">

                                                            <select class="form-control input-sm basic-detail-input-style" name="probationPeriodId" @if(@$data['user']->employeeProfile->probation_period_id){{"disabled"}}@endif>

                                                                <option value="" selected disabled>Please Select Employee's Probation Period.</option>

                                                                @if(!$data['probation_periods']->isEmpty())

                                                                    @foreach($data['probation_periods'] as $probation)

                                                                        <option value="{{$probation->id}}" @if($probation->id == @$data['user']->employeeProfile->probation_period_id){{"selected"}}@endif>{{$probation->name}}</option>

                                                                    @endforeach

                                                                @endif

                                                            </select>

                                                        </div>

                                                    </div>





                                                    <div class="row field-changes-below">

                                                        <label class="col-md-4 control-label basic-detail-label">Role<span style="color:red">*</span></label>

                                                        <div class="col-md-8 basic-input-left">

                                                            <select class="form-control input-sm basic-detail-input-style" name="roleId">

                                                                <option value="" selected disabled>Please Select Employee's Role.</option>

                                                                @if(!$data['roles']->isEmpty())

                                                                    @foreach($data['roles'] as $role)

                                                                        <option value="{{$role->id}}" @if(@$data['user']->roles->contains('id',$role->id)){{'selected'}}@endif>{{$role->name}}</option>

                                                                    @endforeach

                                                                @endif

                                                            </select>

                                                        </div>

                                                    </div>



                                                    <div class="row field-changes-below">

                                                        <label class="col-md-4 control-label basic-detail-label">Designation<span style="color: red">*</span></label>



                                                        <div class="col-md-8 basic-input-right">

                                                            <select class="form-control input-sm basic-detail-input-style" name="designation">

                                                                <option value="" selected disabled>Please Select Employee's Designation.</option>

                                                                @if(!$data['designations']->isEmpty())

                                                                    @foreach($data['designations'] as $designation)

                                                                        <option value="{{$designation->id}}" @if(@$data['user']->designation->contains('id',$designation->id)){{'selected'}}@endif>{{$designation->name}}</option>

                                                                    @endforeach

                                                                @endif

                                                            </select>

                                                        </div>

                                                    </div>



                                                    <div class="row field-changes-below">

                                                        <label class="col-md-4 control-label basic-detail-label">Permissions<span style="color:red">*</span></label>

                                                        <div class="col-md-8 basic-input-left">

                                                            <select class="form-control select2 input-sm basic-detail-input-style" name="permissionIds[]" multiple="multiple" style="width: 100%">

                                                                @if(!$data['permissions']->isEmpty())

                                                                    @foreach($data['permissions'] as $permission)

                                                                        <option value="{{$permission->id}}" @if(@$data['user']->permissions->contains('id',$permission->id)){{'selected'}}@endif>{{$permission->name}}</option>

                                                                    @endforeach

                                                                @endif

                                                            </select>

                                                        </div>

                                                    </div>



                                                    <input type="hidden" name="employeeId" value="{{$data['user']->id}}">

                                                    <input type="hidden" name="formSubmitButton" class="profileFormSubmitButton">



                                                    <!-- </div>   -->



                                                </div>



                                            </div>

                                        </div>

                                    </div>

                                    <!-- /.box-body -->

                                    <div class="box-footer">

                                        <button type="button" class="btn btn-info profileFormSubmit" id="profileFormSubmit" name="formSubmitButton" value="sc">Save & Continue</button>

                                        <button type="button" class="btn btn-default profileFormSubmit" name="formSubmitButton" value="se">Save & Exit</button>

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



                                @if(!$data['qualification_documents']->isEmpty())

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

                                                @foreach($data['qualification_documents'] as $document)

                                                    <tr>

                                                        <td>{{++$counter}}</td>

                                                        <td>{{$document->name}}</td>

                                                        <td>

                                                            @if(empty($document->filename))

                                                                <span class="badge bg-red"><i class="fa fa-times" aria-hidden="true"></i></span>

                                                            @else

                                                                <span class="badge bg-green"><i class="fa fa-check" aria-hidden="true"></i></span>

                                                            @endif

                                                        </td>

                                                        <td>

                                                            @if(!empty($document->filename))

                                                                <span><a target="_blank" href="{{config('constants.uploadPaths.qualificationDocument').$document->filename}}"><i class="fa fa-file-text-o" aria-hidden="true"></i></a></span>

                                                            @endif

                                                        </td>

                                                        <td>

                                                            <button class="btn btn-info uploadQualificationFile" href="javascript:void(0)" data-docname="{{$document->name}}" data-empqualificationid="{{$document->id}}">Upload</button>

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

                                        <h3 class="box-title">Documents List <span style="font-size: 12px; text-align: right;color: red; padding-left: 20px;">(Allowed File Formats : jpg, jpeg,png, pdf, doc, docx. File Size Must Be Less Then 2MB.)</span></h3>

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

                                            @foreach($data['documents'] as $document)

                                                <tr>

                                                    <td>{{++$counter}}</td>

                                                    <td>{{$document->name}}</td>

                                                    <td>

                                                        @if(empty($document->filenames))

                                                            <span class="badge bg-red"><i class="fa fa-times" aria-hidden="true"></i></span>

                                                        @else

                                                            <span class="badge bg-green"><i class="fa fa-check" aria-hidden="true"></i></span>

                                                        @endif

                                                    </td>

                                                    <td>

                                                        @if(!empty($document->filenames))

                                                            @foreach($document->filenames as $filename)

                                                                <span><a target="_blank" href="{{config('constants.uploadPaths.document').$filename}}"><i class="fa fa-file-text-o" aria-hidden="true"></i></a></span>&nbsp;&nbsp;

                                                            @endforeach

                                                        @endif

                                                    </td>

                                                    <td>

                                                        <button class="btn btn-info uploadFile" href="javascript:void(0)" data-doctypename="{{$document->name}}" data-doctypeid="{{$document->id}}">Upload</button>

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

                                <form id="accountDetailsForm" class="form-horizontal" action="{{ url('employees/edit-account-details') }}" method="POST" enctype="multipart/form-data">

                                    {{ csrf_field() }}

                                    <div class="box-body">

                                        <hr>

                                        <div class="form-group form-sidechange">

                                            <div class="row field-changes-below">

                                                <div class="col-md-6">

                                                    <div class="row field-changes-below">

                                                        <label for="adhaar" class="col-md-4 control-label basic-detail-label">Adhaar Number<span style="color:red">*</span></label>



                                                        <div class="col-md-8 basic-input-left">

                                                            <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="adhaar" id="adhaar" placeholder="Please Enter Only Numeric  Value In Adhaar Number." value="{{@$data['user']->employeeAccount->adhaar}}">

                                                        </div>

                                                    </div>



                                                    <div class="row field-changes-below">

                                                        <label for="panNo" class="col-md-4 control-label basic-detail-label">PAN Number<span style="color:red">*</span></label>



                                                        <div class="col-md-8 basic-input-left">

                                                            <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="panNo" id="panNo" placeholder="Please Enter Alphabets And Digits Value In Pan Number." value="{{@$data['user']->employeeAccount->pan_number}}">

                                                        </div>

                                                    </div>



                                                    <div class="row field-changes-below">

                                                        <label for="empEsiNo" class="col-md-4 control-label basic-detail-label">Employee ESI Number</label>



                                                        <div class="col-md-8 basic-input-left">

                                                            <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="empEsiNo" id="empEsiNo" placeholder="Please Enter Numeric  Value In Employee ESI Number." value="{{@$data['user']->employeeAccount->esi_number}}">

                                                        </div>

                                                    </div>



                                                    <div class="row field-changes-below">

                                                        <label for="empDispensary" class="col-md-4 control-label basic-detail-label">Employee Dispensary</label>



                                                        <div class="col-md-8 basic-input-left">

                                                            <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="empDispensary" id="empDispensary" placeholder="Please Enter Employee's Dispensary" value="{{@$data['user']->employeeAccount->dispensary}}">

                                                        </div>

                                                    </div>



                                                    <div class="row field-changes-below">

                                                        <label for="pfNoDepartment" class="col-md-4 control-label basic-detail-label">PF Number for Department File</label>



                                                        <div class="col-md-8 basic-input-left">

                                                            <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="pfNoDepartment" id="pfNoDepartment" placeholder="Please Enter Numeric  Value In PF Number for Department File." value="{{@$data['user']->employeeAccount->pf_number_department}}">

                                                        </div>

                                                    </div>





                                                    <div class="row field-changes-below">

                                                        <label for="uanNo" class="col-md-4 control-label basic-detail-label">UAN Number</label>



                                                        <div class="col-md-8 basic-input-left">

                                                            <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="uanNo" id="uanNo" placeholder="Please Enter 12 Digits Numeric  Value In UAN Number." value="{{@$data['user']->employeeAccount->uan_number}}">

                                                        </div>

                                                    </div>



                                                    <div class="row field-changes-below">

                                                        <label class="col-md-4 control-label basic-detail-label">Bank Name</label>

                                                        <div class="col-md-8 basic-input-left">

                                                            <select class="form-control input-sm basic-detail-input-style" name="financialInstitutionId">

                                                                @if(!$data['financial_institutions']->isEmpty())

                                                                    @foreach($data['financial_institutions'] as $financial_institution)

                                                                        <option value="{{$financial_institution->id}}" @if($financial_institution->id == @$data['user']->employeeAccount->bank_id){{"selected"}}@endif>{{$financial_institution->name}}</option>

                                                                    @endforeach

                                                                @endif

                                                            </select>

                                                        </div>

                                                    </div>



                                                    <div class="row field-changes-below">

                                                        <label for="accHolderName" class="col-md-4 control-label basic-detail-label">Account Holder Name<span style="color:red">*</span></label>



                                                        <div class="col-md-8 basic-input-left">

                                                            <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="accHolderName" id="accHolderName" placeholder="Please Enter Aplhabets In Account Holder Name." value="{{@$data['user']->employeeAccount->account_holder_name}}">

                                                        </div>

                                                    </div>



                                                    <input type="hidden" name="employeeId" value="{{$data['user']->id}}">



                                                    <div class="row field-changes-below">

                                                        <label for="bankAccNo" class="col-md-4 control-label basic-detail-label">Bank Account Number<span style="color:red">*</span></label>



                                                        <div class="col-md-8 basic-input-left">

                                                            <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="bankAccNo" id="bankAccNo" placeholder="Please Enter Numeric  Value In Bank Account Number." value="{{@$data['user']->employeeAccount->bank_account_number}}">

                                                        </div>

                                                    </div>



                                                    <div class="row field-changes-below">

                                                        <label for="ifsc" class="col-md-4 control-label basic-detail-label">IFSC Code<span style="color:red">*</span></label>



                                                        <div class="col-md-8 basic-input-left">

                                                            <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="ifsc" id="ifsc" placeholder="Please enter Alphanumeric  Value In IFSC Code." value="{{@$data['user']->employeeAccount->ifsc_code}}">

                                                        </div>

                                                    </div>

                                                </div>



                                                <div class="col-md-6">



                                                    <div class="row field-changes-below">

                                                        <span class="col-md-4 control-label basic-detail-label"><strong>Background Verification</strong></span>

                                                        <div class="col-md-8 basic-input-left">

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

                                                        <div class="col-md-8 basic-input-left">

                                                            <textarea class="form-control input-sm basic-detail-input-style" rows="5" name="remarks" id="remarks">{{@$data['user']->employeeAccount->remarks}}</textarea>

                                                        </div>

                                                    </div>



                                                    <div class="row field-changes-below">

                                                        <span class="col-md-4 control-label radio basic-detail-label hr-details-contract"><strong>Contract Signed</strong></span>

                                                        <div class="col-md-8 basic-input-left">

                                                            <label>

                                                                <input autocomplete="off" type="radio" name="contractSigned" class="contractSigned" id="optionsRadios3" value="1" @if(@$data['user']->employeeAccount->contract_signed == "1"){{"checked"}}@endif>

                                                                Yes

                                                            </label>

                                                            <label>

                                                                <input autocomplete="off" type="radio" name="contractSigned" class="contractSigned" id="optionsRadios4" value="0" @if(@$data['user']->employeeAccount->contract_signed == "0"){{"checked"}}@endif>

                                                                No

                                                            </label>

                                                        </div>

                                                    </div>



                                                    <div class="row contractSignedDateDiv field-changes-below">

                                                        <label for="contractSignedDate" class="col-md-4 control-label basic-detail-label">Contract Signed Date</label>

                                                        <div class="col-md-8 basic-input-left">

                                                            <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" id="contractSignedDate" name="contractSignedDate" placeholder="MM/DD/YYYY" value="@if(@$data['user']->employeeAccount->contract_signed_date){{date('m/d/Y',strtotime(@$data['user']->employeeAccount->contract_signed_date))}}@endif">

                                                            <span class="contractSignedDateErrors" readonly></span>

                                                        </div>

                                                    </div>



                                                    <input type="hidden" name="formSubmitButton" class="accountFormSubmitButton">



                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                    <!-- /.box-body -->

                                    <div class="box-footer">

                                        <button type="button" class="btn btn-info accountFormSubmit" id="accountFormSubmit" name="formSubmitButton" value="sc">Save & Continue</button>

                                        <button type="button" class="btn btn-default accountFormSubmit" name="formSubmitButton" value="se">Save & Exit</button>

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

                                <form id="addressDetailsForm" class="form-horizontal" action="{{ url('employees/edit-address-details') }}" method="POST" enctype="multipart/form-data">

                                    {{ csrf_field() }}

                                    <div class="box-body">

                                        <div class="form-group form-sidechange">

                                            <div class="row">

                                                <div class="col-md-6">

                                                    <span class="text-primary"><em>Permanent Address</em></span> :-

                                                    <hr>

                                                    <div class="row field-changes-below">

                                                        <label for="perHouseNo" class="col-md-4 control-label basic-detail-label">House Number<span style="color:red">*</span></label>



                                                        <div class="col-md-8 basic-input-left">

                                                            <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="perHouseNo" id="perHouseNo" placeholder="Please Enter Employee's House Number." value="{{@$data['user']->employeeAddresses[1]->house_number}}">

                                                        </div>

                                                    </div>



                                                    <div class="row field-changes-below">

                                                        <label for="perRoadStreet" class="col-md-4 control-label basic-detail-label">Road/Street<span style="color:red">*</span></label>



                                                        <div class="col-md-8 basic-input-left">

                                                            <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="perRoadStreet" id="perRoadStreet" placeholder="Pease Enter Employee's Road/Street Name." value="{{@$data['user']->employeeAddresses[1]->road_street}}">

                                                        </div>

                                                    </div>



                                                    <div class="row field-changes-below">

                                                        <label for="perLocalityArea" class="col-md-4 control-label basic-detail-label">Locality/Area<span style="color:red">*</span></label>



                                                        <div class="col-md-8 basic-input-left">

                                                            <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="perLocalityArea" id="perLocalityArea" placeholder="Please Enter Employee's Locality/Area Name." value="{{@$data['user']->employeeAddresses[1]->locality_area}}">

                                                        </div>

                                                    </div>



                                                    <div class="row field-changes-below">

                                                        <label for="perPinCode" class="col-md-4 control-label basic-detail-label">Pincode<span style="color:red">*</span></label>



                                                        <div class="col-md-8 basic-input-left">

                                                            <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="perPinCode" id="perPinCode" placeholder="Please Enter Numeric  Value In PinCode." value="{{@$data['user']->employeeAddresses[1]->pincode}}">

                                                        </div>

                                                    </div>





                                                    <div class="row field-changes-below">

                                                        <label for="perEmergencyNumber" class="col-md-4 control-label basic-detail-label">Emergency Number</label>



                                                        <div class="col-md-8 basic-input-left">

                                                            <div class="row">

                                                                <div class="col-md-4 basic-detail-mob-left">

                                                                    <select class="form-control input-sm basic-detail-input-style perEmergencyNumberStdId" name="perEmergencyNumberStdId">

                                                                        @if(!$data['countries']->isEmpty())

                                                                            @foreach($data['countries'] as $country)

                                                                                <option value="{{$country->id}}" @if(@$country->id == @$data['user']->employeeAddresses[1]->emergency_number_country_id){{'selected'}}@endif>(+{{@$country->phone_code}}) {{@$country->iso3}}</option>

                                                                            @endforeach

                                                                        @endif

                                                                    </select>

                                                                </div>



                                                                <div class="col-md-8 basic-detail-mob-right">

                                                                    <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="perEmergencyNumber" id="perEmergencyNumber" placeholder="Please Enter Emergency Contact Number." value="{{@$data['user']->employeeAddresses[1]->emergency_number}}">

                                                                </div>

                                                            </div>

                                                        </div>





                                                    </div>



                                                    <div class="row field-changes-below">

                                                        <label class="col-md-4 control-label basic-detail-label">Country</label>

                                                        <div class="col-md-8 basic-input-left">

                                                            <select class="form-control perCountryId input-sm basic-detail-input-style" name="perCountryId">

                                                                @if(!$data['countries']->isEmpty())

                                                                    @foreach($data['countries'] as $country)

                                                                        <option value="{{$country->id}}" @if($country->id == @$data['user']->employeeAddresses[1]->country_id){{"selected"}}@endif>{{$country->name}}</option>

                                                                    @endforeach

                                                                @endif

                                                            </select>

                                                        </div>

                                                    </div>



                                                    <div class="row field-changes-below">

                                                        <label class="col-md-4 control-label basic-detail-label">State</label>

                                                        <div class="col-md-8 basic-input-left">

                                                            <select class="form-control perStateId input-sm basic-detail-input-style" name="perStateId" id="perStateId">

                                                                @if(!$data['states']->isEmpty())

                                                                    @foreach($data['states'] as $state)

                                                                        <option value="{{$state->id}}" @if($state->id == @$data['user']->employeeAddresses[1]->state_id){{"selected"}}@endif>{{$state->name}}</option>

                                                                    @endforeach

                                                                @endif

                                                            </select>

                                                        </div>

                                                    </div>

                                                    <div class="row field-changes-below">

                                                        <label class="col-md-4 control-label basic-detail-label">City</label>

                                                        <div class="col-md-8 basic-input-left">

                                                            <select class="form-control perCityId input-sm basic-detail-input-style" name="perCityId" id="perCityId">



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

                                                        <label for="preHouseNo" class="col-md-4 control-label basic-detail-label">House Number<span style="color:red">*</span></label>



                                                        <div class="col-md-8 basic-input-left">

                                                            <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="preHouseNo" id="preHouseNo" placeholder="Please Enter Employee's House Number." value="{{@$data['user']->employeeAddresses[0]->house_number}}">

                                                        </div>

                                                    </div>



                                                    <input autocomplete="off" type="hidden" name="employeeId" value="{{$data['user']->id}}">



                                                    <div class="row field-changes-below">

                                                        <label for="preRoadStreet" class="col-md-4 control-label basic-detail-label">Road/Street<span style="color:red">*</span></label>



                                                        <div class="col-md-8 basic-input-left">

                                                            <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="preRoadStreet" id="preRoadStreet" placeholder="Pease Enter Employee's Road/Street Name." value="{{@$data['user']->employeeAddresses[0]->road_street}}">

                                                        </div>

                                                    </div>



                                                    <div class="row field-changes-below">

                                                        <label for="preLocalityArea" class="col-md-4 control-label basic-detail-label">Locality/Area<span style="color:red">*</span></label>



                                                        <div class="col-md-8 basic-input-left">

                                                            <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="preLocalityArea" id="preLocalityArea" placeholder="Please Enter Employee's Locality/Area Name." value="{{@$data['user']->employeeAddresses[0]->locality_area}}">

                                                        </div>

                                                    </div>



                                                    <div class="row field-changes-below">

                                                        <label for="prePinCode" class="col-md-4 control-label basic-detail-label">Pincode<span style="color:red">*</span></label>



                                                        <div class="col-md-8 basic-input-left">

                                                            <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="prePinCode" id="prePinCode" placeholder="Please Enter Numeric  Value In Pin Code." value="{{@$data['user']->employeeAddresses[0]->pincode}}">

                                                        </div>

                                                    </div>



                                                    <div class="row field-changes-below">

                                                        <label for="preEmergencyNumber" class="col-md-4 control-label basic-detail-label">Emergency Number</label>



                                                        <div class="col-md-8 basic-input-left">

                                                            <div class="row">

                                                                <div class="col-md-4 basic-detail-mob-left">

                                                                    <select class="form-control input-sm basic-detail-input-style preEmergencyNumberStdId" name="preEmergencyNumberStdId">

                                                                        @if(!$data['countries']->isEmpty())

                                                                            @foreach($data['countries'] as $country)

                                                                                <option value="{{$country->id}}" @if(@$country->id == @$data['user']->employeeAddresses[0]->emergency_number_country_id){{'selected'}}@endif>(+{{@$country->phone_code}}) {{@$country->iso3}}</option>

                                                                            @endforeach

                                                                        @endif

                                                                    </select>

                                                                </div>



                                                                <div class="col-md-8 basic-detail-mob-right">

                                                                    <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="preEmergencyNumber" id="preEmergencyNumber" placeholder="Please Enter Emergency Contact Number." value="{{@$data['user']->employeeAddresses[0]->emergency_number}}">

                                                                </div>

                                                            </div>

                                                        </div>





                                                    </div>



                                                    <div class="row field-changes-below">

                                                        <label class="col-md-4 control-label basic-detail-label">Country</label>

                                                        <div class="col-md-8 basic-input-left">

                                                            <select class="form-control preCountryId input-sm basic-detail-input-style" name="preCountryId">

                                                                @if(!$data['countries']->isEmpty())

                                                                    @foreach($data['countries'] as $country)

                                                                        <option value="{{$country->id}}" @if($country->id == @$data['user']->employeeAddresses[0]->country_id){{"selected"}}@endif>{{$country->name}}</option>

                                                                    @endforeach

                                                                @endif

                                                            </select>

                                                        </div>



                                                    </div>



                                                    <div class="row field-changes-below">

                                                        <label class="col-md-4 control-label basic-detail-label">State</label>

                                                        <div class="col-md-8 basic-input-left">

                                                            <select class="form-control preStateId input-sm basic-detail-input-style" name="preStateId" id="preStateId">

                                                                @if(!$data['states']->isEmpty())

                                                                    @foreach($data['states'] as $state)

                                                                        <option value="{{$state->id}}" @if($state->id == @$data['user']->employeeAddresses[0]->state_id){{"selected"}}@endif>{{$state->name}}</option>

                                                                    @endforeach

                                                                @endif

                                                            </select>

                                                        </div>

                                                    </div>



                                                    <div class="row field-changes-below">

                                                        <label class="col-md-4 control-label basic-detail-label">City</label>

                                                        <div class="col-md-8 basic-input-left">

                                                            <select class="form-control preCityId input-sm basic-detail-input-style" name="preCityId" id="preCityId">



                                                            </select>

                                                        </div>

                                                    </div>



                                                    <input type="hidden" name="formSubmitButton" class="addressFormSubmitButton">

                                                </div>

                                            </div>

                                        </div>

                                    </div>



                                    <!-- /.box-body -->



                                    <div class="box-footer">

                                        <button type="button" class="btn btn-info addressFormSubmit" id="addressFormSubmit" name="formSubmitButton" value="sc">Save & Continue</button>

                                        <button type="button" class="btn btn-default addressFormSubmit" name="formSubmitButton" value="se">Save & Exit</button>

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

                                <form id="historyDetailsForm" class="form-horizontal" action="{{ url('employees/edit-history-details') }}" method="POST" enctype="multipart/form-data">

                                    {{ csrf_field() }}

                                    <div class="box-body">

                                        <span class="text-primary"><em>Please list your most recent employer first</em></span> :-

                                        <hr>

                                        <div class="form-group form-sidechange">

                                            <div class="row">

                                                <div class="col-md-6">

                                                    <div class="row field-changes-below">

                                                        <label for="fromDate" class="col-md-4 control-label basic-detail-label">From Date<span style="color:red">*</span></label>

                                                        <div class="col-md-8 basic-input-left">

                                                            <input autocomplete="off" type="text" class="form-control input-sm" id="fromDate" name="fromDate" placeholder="MM/DD/YYYY" value="" readonly>

                                                            <span class="fromDateErrors"></span>

                                                        </div>

                                                    </div>



                                                    <div class="row field-changes-below">

                                                        <label for="toDate" class="col-md-4 control-label basic-detail-label">To Date<span style="color:red">*</span></label>

                                                        <div class="col-md-8 basic-input-left">

                                                            <input autocomplete="off" type="text" class="form-control input-sm" id="toDate" name="toDate" placeholder="MM/DD/YYYY" value="" readonly>

                                                            <span class="toDateErrors"></span>

                                                        </div>

                                                    </div>



                                                    <input type="hidden" name="employeeId" value="{{$data['user']->id}}">



                                                    <div class="row field-changes-below">

                                                        <label for="orgName" class="col-md-4 control-label basic-detail-label">Organization Name<span style="color:red">*</span></label>



                                                        <div class="col-md-8 basic-input-left">

                                                            <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="orgName" id="orgName" placeholder="Please Enter Previous Organization Name">

                                                        </div>

                                                    </div>



                                                    <div class="row field-changes-below">

                                                        <label for="orgPhone" class="col-md-4 control-label basic-detail-label">Organization Phone<span style="color:red">*</span></label>



                                                        <div class="col-md-8 basic-input-left">

                                                            <div class="row">

                                                                <div class="col-md-4">

                                                                    <select class="form-control input-sm basic-detail-input-style" name="orgPhoneStdId">

                                                                        @if(!$data['countries']->isEmpty())

                                                                            @foreach($data['countries'] as $country)

                                                                                <option value="{{$country->id}}" @if(@$country->phone_code == '91' ){{'selected'}}@endif>(+{{@$country->phone_code}}) {{@$country->iso3}}</option>

                                                                            @endforeach

                                                                        @endif

                                                                    </select>

                                                                </div>



                                                                <div class="col-md-3 edit-std-space">

                                                                    <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="orgPhoneStdCode" id="orgPhoneStdCode" placeholder="Std Code">

                                                                </div>



                                                                <div class="col-md-5">

                                                                    <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="orgPhone" id="orgPhone" placeholder="Please Enter Numeric  Value In Previous Organization Phone Number.">

                                                                </div>

                                                            </div>

                                                        </div>



                                                    </div>



                                                    <div class="row field-changes-below">

                                                        <label for="orgEmail" class="col-md-4 control-label basic-detail-label">Organization Email<span style="color:red">*</span></label>



                                                        <div class="col-md-8 basic-input-left">

                                                            <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="orgEmail" id="orgEmail" placeholder="Please Enter Valid Email Id In Previous Organization Email Id.">

                                                        </div>

                                                    </div>



                                                    <div class="row field-changes-below">

                                                        <label for="orgWebsite" class="col-md-4 control-label basic-detail-label">Organisation Website</label>



                                                        <div class="col-md-8 basic-input-left">

                                                            <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="orgWebsite" id="orgWebsite" placeholder="Please enter full website url with http or https.">

                                                        </div>

                                                    </div>

                                                </div>



                                                <div class="col-md-6">

                                                    <div class="row field-changes-below">

                                                        <label for="responsibilities" class="col-md-4 control-label basic-detail-label">Responsibilities<span style="color:red">*</span></label>



                                                        <div class="col-md-8 basic-input-left">

                                                            <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="responsibilities" id="responsibilities" placeholder="Please Enter Employee's Previous employment Responsibilities.">

                                                        </div>

                                                    </div>



                                                    <div class="row field-changes-below">

                                                        <label for="reportTo" class="col-md-4 control-label basic-detail-label">Report To(Position)<span style="color:red">*</span></label>



                                                        <div class="col-md-8 basic-input-left">

                                                            <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="reportTo" id="reportTo" placeholder="Please Enter Employee's Report to (Position).">

                                                        </div>

                                                    </div>



                                                    <div class="row field-changes-below">

                                                        <label for="salaryPerMonth" class="col-md-4 control-label basic-detail-label">Salary Per Month<span style="color:red">*</span></label>



                                                        <div class="col-md-8 basic-input-left">

                                                            <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="salaryPerMonth" id="salaryPerMonth" placeholder="Please Enter Decimal Value Employee's Salary Per Month.">

                                                        </div>

                                                    </div>



                                                    <div class="row field-changes-below">

                                                        <label for="perks" class="col-md-4 control-label basic-detail-label">Perks<span style="color:red">*</span></label>



                                                        <div class="col-md-8 basic-input-left">

                                                            <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="perks" id="perks" placeholder="Please Enter Employee's Previous Perks.">

                                                        </div>

                                                    </div>



                                                    <div class="row field-changes-below">

                                                        <label for="leavingReason" class="col-md-4 control-label basic-detail-label">Reason For Leaving<span style="color:red">*</span></label>



                                                        <div class="col-md-8 basic-input-left">

                                                            <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="leavingReason" id="leavingReason" placeholder="Please Enter Reason For Leaving Previous Company.">

                                                        </div>

                                                    </div>



                                                    <input type="hidden" name="formSubmitButton" class="historyFormSubmitButton">

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                    <!-- /.box-body -->



                                    <div class="box-footer">

                                        <button type="button" class="btn btn-info historyFormSubmit" id="historyFormSubmit" name="formSubmitButton" value="s">Save</button>

                                        <button type="button" class="btn btn-default historyFormSubmit" name="formSubmitButton" value="se">Save & Exit</button>

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

                                            @if(!$data['employment_histories']->isEmpty())

                                                @foreach($data['employment_histories'] as $key => $history)

                                                    <tr>

                                                        <td>{{date("d/m/Y",strtotime($history->employment_from))}}</td>

                                                        <td>{{date("d/m/Y",strtotime($history->employment_to))}}</td>

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

                                <form id="referenceDetailsForm" class="form-horizontal" action="{{ url('employees/edit-reference-details') }}" method="POST" enctype="multipart/form-data">

                                    {{ csrf_field() }}

                                    <div class="box-body">



                                        <div class="form-group form-sidechange">

                                            <div class="row">

                                                <div class="col-md-6">

                                                    <span class="text-primary"><em>Reference 1</em></span> :-

                                                    <hr>

                                                    <div class="row field-changes-below">

                                                        <label for="ref1Name" class="col-md-4 control-label basic-detail-label">Name<span style="color:red">*</span></label>

                                                        <div class="col-md-8 basic-input-left">

                                                            <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" id="ref1Name" name="ref1Name" placeholder="Please Enter Alphabets In Reference 1 Name." value="{{@$data['user']->employeeReferences[0]->name}}">

                                                        </div>

                                                    </div>



                                                    <input type="hidden" name="employeeId" value="{{$data['user']->id}}">



                                                    <div class="row field-changes-below">

                                                        <label for="ref1Address" class="col-md-4 control-label basic-detail-label">Address<span style="color:red">*</span></label>

                                                        <div class="col-md-8 basic-input-left">

                                                            <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" id="ref1Address" name="ref1Address" placeholder="Please Enter Reference 1 Address." value="{{@$data['user']->employeeReferences[0]->address}}">

                                                        </div>

                                                    </div>



                                                    <div class="row field-changes-below">

                                                        <label for="ref1Phone" class="col-md-4 control-label basic-detail-label">Mobile Number<span style="color:red">*</span></label>



                                                        <div class="col-md-8 basic-input-left">

                                                            <div class="row">

                                                                <div class="col-md-4 basic-detail-mob-left">

                                                                    <select class="form-control input-sm basic-detail-input-style" name="ref1PhoneStdId">

                                                                        @if(!$data['countries']->isEmpty())

                                                                            @foreach($data['countries'] as $country)

                                                                                <option value="{{$country->id}}" @if(@$country->id == @$data['user']->employeeReferences[0]->country_id){{'selected'}}@endif>(+{{@$country->phone_code}}) {{@$country->iso3}}</option>

                                                                            @endforeach

                                                                        @endif

                                                                    </select>

                                                                </div>



                                                                <div class="col-md-8 basic-detail-mob-right">

                                                                    <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="ref1Phone" id="ref1Phone" placeholder="Please Enter Numeric  Value In Reference 1 Phone Number."  value="{{@$data['user']->employeeReferences[0]->phone}}">

                                                                </div>

                                                            </div>

                                                        </div>





                                                    </div>



                                                    <div class="row field-changes-below">

                                                        <label for="ref1Email" class="col-md-4 control-label basic-detail-label">Email<span style="color:red">*</span></label>



                                                        <div class="col-md-8 basic-input-left">

                                                            <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="ref1Email" id="ref1Email" placeholder="Please Enter Valid Email Id In Reference 1 Email Id." value="{{@$data['user']->employeeReferences[0]->email}}">

                                                        </div>

                                                    </div>

                                                </div>



                                                <div class="col-md-6">

                                                    <span class="text-primary"><em>Reference 2</em></span> :-

                                                    <hr>

                                                    <div class="row field-changes-below">

                                                        <label for="ref2Name" class="col-md-4 control-label basic-detail-label">Name<span style="color:red">*</span></label>

                                                        <div class="col-md-8 basic-input-left">

                                                            <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" id="ref2Name" name="ref2Name" placeholder="Please Enter Alphabets In Reference 2 Name." value="{{@$data['user']->employeeReferences[1]->name}}">

                                                        </div>

                                                    </div>



                                                    <div class="row field-changes-below">

                                                        <label for="ref2Address" class="col-md-4 control-label basic-detail-label">Address<span style="color:red">*</span></label>

                                                        <div class="col-md-8 basic-input-left">

                                                            <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" id="ref2Address" name="ref2Address" placeholder="Please Enter Reference 2 Address." value="{{@$data['user']->employeeReferences[1]->address}}">

                                                        </div>

                                                    </div>



                                                    <div class="row field-changes-below">

                                                        <label for="ref2Phone" class="col-md-4 control-label basic-detail-label">Mobile Number<span style="color:red">*</span></label>



                                                        <div class="col-md-8 basic-input-left">

                                                            <div class="row">

                                                                <div class="col-md-4 basic-detail-mob-left">

                                                                    <select class="form-control input-sm basic-detail-input-style" name="ref2PhoneStdId">

                                                                        @if(!$data['countries']->isEmpty())

                                                                            @foreach($data['countries'] as $country)

                                                                                <option value="{{$country->id}}" @if(@$country->id == @$data['user']->employeeReferences[1]->country_id){{'selected'}}@endif>(+{{@$country->phone_code}}) {{@$country->iso3}}</option>

                                                                            @endforeach

                                                                        @endif

                                                                    </select>

                                                                </div>



                                                                <div class="col-md-8 basic-detail-mob-right">

                                                                    <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="ref2Phone" id="ref2Phone" placeholder="Please Enter Numeric  Value In Reference 2 Phone Number." value="{{@$data['user']->employeeReferences[1]->phone}}">

                                                                </div>

                                                            </div>

                                                        </div>





                                                    </div>



                                                    <div class="row field-changes-below">

                                                        <label for="ref2Email" class="col-md-4 control-label basic-detail-label">Email<span style="color:red">*</span></label>



                                                        <div class="col-md-8 basic-input-left">

                                                            <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="ref2Email" id="ref2Email" placeholder="Please Enter Valid Email Id In Reference 2 Email Id." value="{{@$data['user']->employeeReferences[1]->email}}">

                                                        </div>

                                                    </div>



                                                    <input type="hidden" name="formSubmitButton" class="referenceFormSubmitButton">

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                    <!-- /.box-body -->



                                    <div class="box-footer">

                                        <button type="button" class="btn btn-info referenceFormSubmit" id="referenceFormSubmit" name="formSubmitButton" value="sc">Save & Continue</button>

                                        <button type="button" class="btn btn-default referenceFormSubmit" name="formSubmitButton" value="se">Save & Exit</button>

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

                                <form id="securityDetailsForm" class="form-horizontal" action="{{ url('employees/edit-security-details') }}" method="POST" enctype="multipart/form-data">

                                    {{ csrf_field() }}

                                    <div class="box-body">

                                        <span class="text-primary"><em>Please enter employee security details(if any)</em></span> :-

                                        <hr>

                                        <div class="form-group form-sidechange">

                                            <div class="row">

                                                <div class="col-md-6">

                                                    <div class="row field-changes-below">

                                                        <label for="ddDate" class="col-md-4 control-label basic-detail-label">DD Date<span style="color:red">*</span></label>

                                                        <div class="col-md-8 basic-input-left">

                                                            <input autocomplete="off" type="text" class="form-control input-sm" id="ddDate" name="ddDate" placeholder="MM/DD/YYYY" value="@if(@$data['user']->employeeSecurity->dd_date){{date('m/d/Y',strtotime(@$data['user']->employeeSecurity->dd_date))}}@endif" readonly>

                                                        </div>

                                                    </div>



                                                    <input type="hidden" name="employeeId" value="{{$data['user']->id}}">



                                                    <div class="row field-changes-below">

                                                        <label for="ddNo" class="col-md-4 control-label basic-detail-label">DD Number<span style="color:red">*</span></label>



                                                        <div class="col-md-8 basic-input-left">

                                                            <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="ddNo" id="ddNo" placeholder="Please Enter Numeric  Value In DD Number." value="{{@$data['user']->employeeSecurity->dd_number}}">

                                                        </div>

                                                    </div>



                                                    <div class="row field-changes-below">

                                                        <label for="bankName" class="col-md-4 control-label basic-detail-label">Bank Name<span style="color:red">*</span></label>



                                                        <div class="col-md-8 basic-input-left">

                                                            <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="bankName" id="bankName" placeholder="Please Enter Alphabets In Bank Name." value="{{@$data['user']->employeeSecurity->bank_name}}">

                                                        </div>

                                                    </div>

                                                </div>



                                                <div class="col-md-6">

                                                    <div class="row field-changes-below">

                                                        <label for="accNo" class="col-md-4 control-label basic-detail-label">Account Number<span style="color:red">*</span></label>



                                                        <div class="col-md-8 basic-input-left">

                                                            <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="accNo" id="accNo" placeholder="Please Enter Numeric  Value In Account Number." value="{{@$data['user']->employeeSecurity->account_number}}">

                                                        </div>

                                                    </div>



                                                    <div class="row field-changes-below">

                                                        <label for="receiptNo" class="col-md-4 control-label basic-detail-label">Receipt Number<span style="color:red">*</span></label>



                                                        <div class="col-md-8 basic-input-left">

                                                            <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="receiptNo" id="receiptNo" placeholder="Please Enter Numeric  Value In Receipt Number." value="{{@$data['user']->employeeSecurity->receipt_number}}">

                                                        </div>

                                                    </div>



                                                    <div class="row field-changes-below">

                                                        <label for="amount" class="col-md-4 control-label basic-detail-label">Amount<span style="color:red">*</span></label>



                                                        <div class="col-md-8 basic-input-left">

                                                            <input autocomplete="off" type="text" class="form-control input-sm basic-detail-input-style" name="amount" id="amount" placeholder="Please Enter Decimal Value In Security Amount." value="{{@$data['user']->employeeSecurity->amount}}">

                                                        </div>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                    <!-- /.box-body -->



                                    <div class="box-footer">

                                        <button type="button" class="btn btn-info" id="securityFormSubmit">Save</button>

                                    </div>

                                    <!-- /.box-footer -->

                                </form>



                            </div>

                            <!-- /.tab-pane -->

                            <!-- Security detail ends here -->
                            <!--kra details tab starts-->
                            <div class="tab-pane" id="tab_kraDetailsTab">

                                <div class="row">
                                    <div class="col-sm-12">
                                        @if(session()->has('profileSuccess'))

                                            <div class="alert alert-success alert-dismissible">

                                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

                                                {{ session()->get('profileSuccess') }}

                                            </div>

                                    @endif

                                    <!-- form start -->

                                        <form id="kraFormList" class="form-horizontal" action="{{ url('employees/edit-emp-kra-details/'.$data['emp_id']) }}" method="POST" enctype="multipart/form-data">
                                            {{ csrf_field() }}

                                            <div class="box-body jrf-form-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-md-4 col-md-offset-4 label-left-sec">
                                                                    <div class="add-kra-box">
                                                                        <label for="kra_name">KRA Template Name<sup class="ast">*</sup></label>

                                                                        <select name="kra_name" id="kra_name" class="form-control basic-detail-input-style regis-input-field">
                                                                            <option value="" selected disabled>Select KRA Template</option>
                                                                            @php
                                                                                if($data['emp_temp']){
                                          $empid = $data['emp_temp']->id;
                                                                            @endphp
                                                                            @foreach($data['all_kra_temp'] as $temp_name)
                                                                                <option value="{{$temp_name->id}}" @if($temp_name->id==$empid){{"selected"}}@endif @if($temp_name->id!=$empid){{"disabled"}}@endif>{{$temp_name->name}}</option>
                                                                            @endforeach
                                                                            @php
                                                                                }else{
                                          $empid = "";
                                                                            @endphp
                                                                            @foreach($data['all_kra_temp'] as $temp_name)
                                                                                <option value="{{$temp_name->id}}" >{{$temp_name->name}}</option>
                                                                            @endforeach
                                                                            @php
                                                                                }
                                                                            @endphp

                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="recruitment-box">
                                                    <div class="recruitment-heading">
                                                        <h2 class="text-center">KRA LIST</h2>
                                                    </div>
                                                    <table class="table table-striped table-responsive table-bordered">
                                                        <thead>
                                                        <tr>
                                                            <th class="text-center">

                                                            </th>
                                                            <th>KRA Indicator Name</th>
                                                            <th>Frequency</th>
                                                            <th>Activation Date</th>
                                                            <th>Deadline</th>
                                                            <th>Priority</th>
                                                            <th>Reminder</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody class="kra_tbody">

                                                        @php

                                                            if(sizeof($data['employee_kra_details'])>0){
                              $frequencies = array("Daily", "Weekly", "Monthly", "Fortnight", "Quarterly", "Biannually", "Annually");
                              $priorities = array("H5", "H4", "H3", "H2", "H1");
                              $counter=0;

                                                        @endphp
                                                        @foreach($data['employee_kra_details'] as $emp_kra)
                                                            @php
                                                                $counter++;
                                                            @endphp
                                                            <tr class="kra_row{{$emp_kra->id}}">
                                                                <td class="text-center"> <a href="javascript:void(0)" id="{{$emp_kra->id}}" class="remove_kra_row"><i class="fa fa-minus a_r_style a_r_style_red"></i></a></td>
                                                                <td>
                                                                    <input type="hidden" name="emp_kra_id[]" value="{{$emp_kra->id}}" />
                                                                    <input type="hidden" name="user_id[]" value="{{$emp_kra->user_id}}" />
                                                                    <input type="text" name="name[]" class="form-control" placeholder="Enter Name" value="{{$emp_kra->name}}" required>
                                                                </td>
                                                                <td>

                                                                    <select name="frequency[]" class="form-control task_frequncy" required>
                                                                        <option value="" selected disabled>Select frequency</option>
                                                                        <?php foreach($frequencies as $frequency){ ?>
                                                                        <option value="<?php echo $frequency; ?>" @if($frequency==$emp_kra->frequency){{"selected"}}@endif> <?php echo ucfirst($frequency); ?> </option> <?php } ?></select>
                                                                </td>
                                                                <td>
                                                                    <div class="select_activation">
                                                                        <input type="text" name="activation_date[]" id="activation_id" class="form-control datepicker" value="{{$emp_kra->activation_date}}"  required>
                                                                    </div>

                                                                </td>
                                                                <td>
                                                                    <input type="text" name="deadline_date[]" class="form-control datepicker" value="{{$emp_kra->deadline_date}}" required>
                                                                </td>
                                                                <td>
                                                                    <select name="priority[]" class="form-control" required>
                                                                        <option value="" selected="" disabled="">Select priority</option>
                                                                        <?php foreach($priorities as $priority){ ?><option value="<?php echo $priority; ?>" @if($priority==$emp_kra->priority){{"selected"}}@endif> <?php echo ucfirst($priority); ?> </option> <?php } ?></select>
                                                                </td>
                                                                <td>
                                                                    <div class="text-center">
                                                                        <a href="#" class="btn btn-info btn-sm" data-toggle="modal" data-target="#reminder_modal{{$emp_kra->id}}">Show</a>
                                                                    </div>
                                                                    <div class="modal fade" id="reminder_modal{{$emp_kra->id}}">
                                                                        <div class="modal-dialog">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <button type="button" class="close attendance-close" data-dismiss="modal" aria-label="Close">
                                                                                        <span aria-hidden="true">&times;</span></button>
                                                                                    <h4 class="modal-title text-center">Add Reminder&nbsp;&nbsp;<span class="user-remarks"></span></h4>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    <div class="remind-section">
                                                                                        @php
                                                                                            $reminder_time = array("0.5"=>"Twice per day", "1"=>"Once everyday", "2"=>"Once every 2 days", "5"=>"Once every 5 days", "10"=>"Once every 10 days", "25"=>"Once every month");
                          if($emp_kra->reminder_status == 1){
                            $rem_status = "checked";

                          }else{
                            $rem_status = "";
                          }

                          if($emp_kra->reminder_notification == 1){
                            $notification_status = "checked";

                          }else{
                            $notification_status = "";
                          }

                          if($emp_kra->reminder_email == 1){
                            $mail_status = "checked";

                          }else{
                            $mail_status = "";
                          }

                          if(!$rem_status){
                            $disable = "disabled";

                          }else{
                            $disable = "";
                          }
                                                                                        @endphp


                                                                                        <div class="col-md-2 task-columns">
                                                                                            <input type="checkbox" onclick="reminderEnable($(this))" name ="rem_data[{{$emp_kra->id}}][reminder][]" class="add_task_reminder" {{$rem_status}}>
                                                                                            <span class="task-checkbox-label">Reminder</span>
                                                                                        </div>

                                                                                        <div class="col-md-5 task-columns">
                                                                                            <select class="form-control input-sm basic-detail-input-style rem-input time_period" name="rem_data[{{$emp_kra->id}}][time_period][]" {{$disable}} >
                                                                                                <option value="0" selected>Select days from creation date</option>
                                                                                                @foreach($reminder_time as $time_number=>$time_statement)
                                                                                                    <option value="{{$time_number}}" @if(@$time_number == @$emp_kra->reminder_days){{'selected'}}@endif>{{$time_statement}}</option>
                                                                                                @endforeach

                                                                                            </select>
                                                                                        </div>
                                                                                        <div class="col-md-3 task-columns">
                                                                                            <input type="checkbox" name="rem_data[{{$emp_kra->id}}][reminder_notification][]" class="checkTaskNotification reminder_notification rem-input" {{$notification_status}} {{$disable}} >
                                                                                            <span class="task-checkbox-label">Notification</span>
                                                                                            <input type="checkbox" name="rem_data[{{$emp_kra->id}}][reminder_mail][]" class="checkTaskMail reminder_mail rem-input" {{$mail_status}} {{$disable}} >
                                                                                            <span class="task-checkbox-label">Mail</span>
                                                                                        </div>
                                                                                        <button type="button" class="set_close attendance-close btn btn-primary" data-dismiss="modal" aria-label="Close">set</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endforeach

                                                        @php
                                                            }else{ @endphp


                                                        @php
                                                            }
                                                        @endphp
                                                        </tbody>
                                                    </table>
                                                    <div class="text-center a_r_kra_lists">
                                                        <a href="javascript:void(0)" id="add_new_kra">
                                                            <i class="fa fa-plus a_r_style a_r_style_green"></i>
                                                        </a>

                                                    </div>
                                                </div>
                                                <!--KRA Table Ends here-->

                                                <hr>
                                                <div class="text-center">
                                                    <input type="submit" class="btn btn-info submit-btn-style" id="submit3" value="Submit" name="submit">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- /.box -->
                                </div>
                                <!-- /.row -->
                                <!-- Content here -->

                            </div>
                            <!-- kra tab ends-->

                            <div class="tab-pane" id="tab_salaryStructureTab">
                                <!-- Form Starts here -->
                                <form id="project_approval_handover" method="POST" action="{{ url('employees/update-salary-structure') }}" >
                                    {{ csrf_field() }}
                                    <input type="hidden" name="employeeId" value="{{$data['user']->id}}">

                                    <div class="row">
                                        <div class="col-md-6">
                                            @if($data['salary_cycle_name'] != '')
                                                <span>Current Salary Cycle of Employee Is <b>{{ $data['salary_cycle_name'] }}</b></span>
                                            @endif
                                            <div class="row field-changes-below">
                                                <div class="col-md-4 text-right">
                                                    @if($data['salary_cycle_name'] != '')
                                                    <label for="salary_cycle" class="basic-detail-label">To Change Salary Cycle<span style="color: red">*</span></label>
                                                @else
                                                        <label for="salary_cycle" class="basic-detail-label">Salary Cycle<span style="color: red">*</span></label>

                                                    @endif
                                                </div>
                                                <div class="col-md-8">
                                                    <input type="hidden" name="salary_cycle" value="{{ $data['salary_cycle_id'] }}">
                                                    <Select name="salary_cycle" id="salary_cycle" class="form-control input-sm basic-detail-input-style" >
                                                        <option selected disabled>--Select Salary Cycle--</option>
                                                    </Select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                        </div>
                                    </div>

                                    <div id="allSalaryHead">

                                        <div class="box-body jrf-form-body" id="salaryHead">
                                            <h4 class="text-center" style="text-decoration: underline;"><b>EARNINGS</b></h4>
                                            <!-- Row starts here -->

                                            <div class="row">
                                                <!-- Left column starts here -->
                                                <div id="earningHeads">
                                                    @foreach($data['earning_heads'] as $earningSalaryHead)
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <div class="col-md-5 col-sm-5 col-xs-5 label-470">
                                                                        <label for="ss_basic" class="apply-leave-label">
                                                                            {{ ucWords(\App\SalaryHead::where('id', $earningSalaryHead->salary_head_id)->first()->name) }}</label>
                                                                    </div>
                                                                    <input type="hidden" value="{{$earningSalaryHead->salary_head_id}}" name="earning_heads[]">

                                                                    <div class="col-md-7 col-sm-7 col-xs-7 leave-input-box input-470 ss-small-input">
                                                                        <span></span>
                                                                        <input type="number" name="earning_heads_val[]" id="ss_basic" class="currency form-control input-sm basic-detail-input-style numberInput" placeholder="Enter Basic amount" value="{{ $earningSalaryHead->value }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endforeach
                                                </div>
                                                <!-- Left column Ends here -->
                                            </div>
                                            <!-- Row Ends here -->

                                            <h4 class="text-center" style="text-decoration: underline;"><b>DEDUCTIONS</b></h4>
                                            <div class="row">
                                                <!-- Left column starts here -->
                                                <div id="deductionHeads">
                                                    @foreach($data['deduction_heads'] as $deductionSalaryHead)
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <div class="col-md-5 col-sm-5 col-xs-5 label-470">
                                                                        <label for="ss_basic" class="apply-leave-label">{{ ucWords(\App\SalaryHead::where('id', $deductionSalaryHead->salary_head_id)->first()->name) }}</label>
                                                                    </div>
                                                                    <input type="hidden" value="{{$deductionSalaryHead->salary_head_id}}" name="deduction_heads[]">

                                                                    <div class="col-md-7 col-sm-7 col-xs-7 leave-input-box input-470 ss-small-input">
                                                                        <span></span>
                                                                        <input type="number" name="deduction_heads_val[]" id="ss_basic" class="currency form-control input-sm basic-detail-input-style numberInput" placeholder="Enter Basic amount" value="{{ $deductionSalaryHead->value }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <!-- Left column Ends here -->
                                            </div>
                                        </div>
                                    </div>



                                    <div class="ml-5">
                                        <h3>PF Setting</h3><hr/>
                                        <input type="checkbox" value="1" class="singlecheckbox" name="restrict_pf" @if($data['restrict_pf'] == 1) checked @endif value="{{ $data['restrict_pf'] }}">
                                        Restrict PF
                                        <br/>
{{--                                            <input type="checkbox" value="1" class="singlecheckbox" name="restrict_employer_share" @if($data['restrict_employer_share'] == 1) checked @endif value="{{ $data['restrict_employer_share'] }}">--}}
{{--                                            Restrict Employer Share--}}

                                        <h3>PT-Rate Setting</h3><hr/>
                                        <input type="checkbox" value="1" class="singlecheckbox" name="pt_rate_applied" @if($data['pt_rate_applied'] == 1) checked @endif value="{{ $data['pt_rate_applied'] }}">

                                        PT-Rate Applied

                                        <h3>LWF Setting</h3><hr/>
                                            <input type="checkbox" value="1" class="singlecheckbox" name="lwf_applied" @if($data['lwf_applied'] == 1) checked @endif value="{{ $data['lwf_applied'] }}">
                                            LWF Applied
                                    </div>




                                    <hr>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-info" id="basicFormSubmit" value="sc">Save & Continue </button>
                                        <button type="button" class="btn btn-default basicFormSubmit" value="se">Save & Exit</button>
                                    </div>
                                </form>
                                <!-- Form Ends here -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.tab-content -->
            </div>
        </section>
        <!-- nav-tabs-custom -->
    </div>
    <!-- /.content -->



    <div class="modal fade" id="uploadModal">

        <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header">

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                        <span aria-hidden="true">&times;</span></button>

                    <h4 class="modal-title">Other Documents Upload Form</h4>

                </div>

                <div class="modal-body">

                    <form id="documentDetailsForm" action="{{ url('employees/edit-document-details') }}" method="POST" enctype="multipart/form-data">

                        {{ csrf_field() }}

                        <div class="box-body">



                            <div class="form-group">

                                <label for="docTypeName" class="docType">Document Type</label>

                                <input type="text" class="form-control" id="docTypeName" name="docTypeName" value="" readonly>

                            </div>



                            <input type="hidden" name="docTypeId" id="docTypeId">

                            <input type="hidden" name="employeeId" value="{{$data['user']->id}}">



                            <div class="docId2">

                                <input type="file" id="docs2" name="docs2[]" multiple>

                            </div>



                        </div>

                        <!-- /.box-body -->

                        <br>



                        <div class="box-footer">

                            <button type="button" class="btn btn-primary" id="documentFormSubmit">Submit</button>

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

                    <form id="qualificationDocumentDetailsForm" action="{{ url('employees/edit-qualification-document-details') }}" method="POST" enctype="multipart/form-data">

                        {{ csrf_field() }}

                        <div class="box-body">



                            <div class="form-group">

                                <label for="docName" class="docType">Document Type</label>

                                <input type="text" class="form-control" id="docName" name="docName" value="" readonly>

                            </div>



                            <input type="hidden" name="empQualificationId" id="empQualificationId">

                            <input type="hidden" name="employeeId" value="{{$data['user']->id}}">



                            <div class="docId2">

                                <input type="file" id="qualificationDocs" name="qualificationDocs[]">

                            </div>



                        </div>

                        <!-- /.box-body -->

                        <br>



                        <div class="box-footer">

                            <button type="button" class="btn btn-primary" id="qualificationDocumentFormSubmit">Submit</button>

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
    <script src="{!!asset('public/admin_assets/plugins/sweetalert/sweetalert.min.js')!!}"></script>

    <script src="{{asset('public/admin_assets/plugins/validations/jquery.validate.js')}}"></script>

    <script src="{{asset('public/admin_assets/plugins/validations/additional-methods.js')}}"></script>



    <script type="text/javascript">



        $("select").on("select2:close", function (e) {

            $(this).valid();

        });



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

                $(".noNomineeType").show();

            }else if(value == 'PF'){

                $(".nomineeInsurance").hide();

                $(".noNomineeType").show();

            }else{

                $(".nomineeInsurance").hide();

                $(".noNomineeType").hide();

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



        var defNomineetype = "{{@$data['user']->employee->nominee_type}}";

        if(defNomineetype == 'PF'){

            $(".nomineeInsurance").hide();

        }else if(defNomineetype == 'NA'){

            $(".nomineeInsurance").hide();

            $(".noNomineeType").hide();

        }

        var defAttendanceType = "{{@$data['user']->employee->attendance_type}}";
        $("#attendanceType").val(defAttendanceType);

        var defSalutation = "{{@$data['user']->employee->salutation}}";

        $(".salutation").val(defSalutation);



        var defMarital = "{{@$data['user']->employee->marital_status}}";

        var defSpouseWorkingStatus = "{{@$data['user']->employee->spouse_working_status}}";

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



        var defContractSigned = "{{@$data['user']->employeeAccount->contract_signed}}";

        if(defContractSigned == 0){

            $(".contractSignedDateDiv").hide();

        }



        var experience = "{{@$data['user']->employee->experience_year_month}}";

        experience = experience.split("-");



        $(".expYears").val(experience[0]);

        $(".expMonths").val(experience[1]);



        var empVerify = "{{@$data['user']->employeeAccount->employment_verification}}";

        var polVerify = "{{@$data['user']->employeeAccount->police_verification}}";

        var addVerify = "{{@$data['user']->employeeAccount->address_verification}}";



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



        var allowFormSubmit = {referralCode: 1, email: 1, mobile: 1, employeeXeamCode: 1, oldXeamCode: 1, marriageDate: 1, birthDate: 1};

        var employeeHistorySubmit = {fromDate: 1, toDate: 1};

        var allowProfileFormSubmit = {contractDate: 1};



        $("div.alert-dismissible").fadeOut(6000);



        $("#basicDetailsForm").validate({

            rules :{
                "attendanceType" : {
                    required : true
                },
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

                    maxlength: 25,

                    lettersonlyforxeamcode : true

                },

                "oldXeamCode" : {

                    required : true,

                    maxlength: 20,

                    digits : true

                },

                "fatherName" : {

                    required : true,

                    maxlength: 40,

                    minlength: 3,

                    spacespecial: true,

                    lettersonly: true

                },

                "motherName" : {

                    required : true,

                    maxlength: 40,

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

                "mobile" : {

                    required : true,

                    digits: true,

                    exactlengthdigits : 10

                },

                "altMobile" : {

                    digits: true,

                    exactlengthdigits : 10

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

                "expYrs" : {

                    required : true

                },

                "expMns" : {

                    required : true

                },

                "skillIds[]" : {

                    required : true,

                },

                "languageIds[]" : {

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

                "spouseContactNumber" : {

                    required : true,

                    digits: true,

                    exactlengthdigits : 10

                },

                "coverAmount" : {

                    required : true,

                    digitscoveramount: true

                },

                "typeOfInsurance" : {

                    required : true,

                    lettersonly : true

                },

                "registrationFees" : {

                    digitscoveramount: true

                },

                "applicationNumber" : {

                    digits: true

                }



            },

            messages :{
                "attendanceType" : {
                    required : 'Please select an attendance type.'
                },
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

                    maxlength: 'Maximum 20 characters are allowed.'

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

                    required : 'Please select a role.'

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

                    digitscoveramount: true

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

                    digits: true

                },

                "prevEmpEsiNo":{

                    digits: true,

                    exactlength : 10

                },

                "empDispensary":{

                    alphanumeric: true

                },

                "uanNo" : {

                    digits: true,

                    exactlength : 12

                },

                "prevUanNo":{

                    digits: true,

                    exactlength : 12

                },

                "accHolderName" : {

                    required : true,

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

                    exactlength : 11

                },

                "pfNoDepartment" : {

                    PFAccount: true

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

                // "uanNo" : {

                //     required : 'Please enter uan number.',

                // },

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

                    required : true

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

                    required : true

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

                    digits : true,

                    maxlength :6

                },

                "prePinCode" : {

                    required : true,

                    digits : true,

                    maxlength :6

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

                    digitscoveramount: true

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

            return this.optional(element) || /^[a-zA-Z]+[0-9]+[a-zA-Z]+$/i.test(value);

        }, "Please enter only alphanumeric value.");



        $.validator.addMethod("alphanumericWithSpace", function(value, element) {

            return this.optional(element) || /^[A-Za-z][A-Za-z. \d]*$/i.test(value);

        }, "Please enter only alphanumeric value.");



        $.validator.addMethod("digitHifun", function(value, element) {

            return this.optional(element) || /^[0-9- ]+$/i.test(value);

        }, "Please enter only digits and -.");



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



        jQuery.validator.addMethod("exactlengthpan", function(value, element, param) {

            return this.optional(element) || value.length == param;

        }, $.validator.format("Please enter exactly {0} Alphanumeric value."));



        jQuery.validator.addMethod("exactlengthdigits", function(value, element, param) {

            return this.optional(element) || value.length == param;

        }, $.validator.format("Please enter exactly {0} digits."));



        $.validator.addMethod("digitscoveramount", function(value, element) {

            return this.optional(element) || /^[0-9, .]+$/i.test(value);

        }, "Please enter only digits");

        $.validator.addMethod("PFAccount", function(value, element) {

            return this.optional(element) || /^[a-zA-Z]+[/]+[a-zA-Z]+[/]+[0-9]+$/i.test(value);

        }, "Please enter Region/Sub-regional Office code/EPF account number.");

        $.validator.addMethod("lettersonlyforcode", function(value, element) {

            return this.optional(element) || /^[a-z,-]+[0-9]+$/i.test(value);

        }, "Please enter valid pattern. (Eg. [XEAM-1234] OR [XEAM-TR-1234])");

        $.validator.addMethod("lettersonlyforxeamcode", function(value, element) {

            return this.optional(element) || /[0-9A-Za-z-]+$/i.test(value);

        }, "Please enter valid pattern. (Eg. [1234] OR [TR-1234])");



    </script>



    <script type="text/javascript">

        var languageCheckboxesVal = JSON.parse('<?php echo json_encode($data["language_check_boxes"]);?>');



        //On load

        var arr = $("#languageIds").val();

        length = arr.length;



        var display = '';



        for(var i=0; i < length; i++){

            var langName = $("#languageIds option[value='"+ arr[i] + "']").text();

            var checkBoxes = '<div class="row field-changes-below"><div class="col-sm-4"><strong class="basic-lang-label">'+langName+'</strong></div><div class="col-sm-8 langright"><label class="checkbox-inline"><input type="checkbox" value="1" id="readLang'+arr[i]+'" name="lang'+arr[i]+'[]">Read</label><label class="checkbox-inline"><input type="checkbox" value="2" id="writeLang'+arr[i]+'" name="lang'+arr[i]+'[]">Write</label><label class="checkbox-inline"><input type="checkbox" value="3" id="speakLang'+arr[i]+'" name="lang'+arr[i]+'[]">Speak</label></div></div>';



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

                var checkBoxes = '<div class="row field-changes-below"><div class="col-sm-4"><strong class="basic-lang-label">'+langName+'</strong></div><div class="col-sm-8 langright"><label class="checkbox-inline"><input type="checkbox" value="1" name="lang'+arr[i]+'[]">Read</label><label class="checkbox-inline"><input type="checkbox" value="2" name="lang'+arr[i]+'[]">Write</label><label class="checkbox-inline"><input type="checkbox" value="3" name="lang'+arr[i]+'[]">Speak</label></div></div>';



                display += checkBoxes;

            }



            $(".languageCheckboxes").html("");

            $(".languageCheckboxes").append(display);

        });

    </script>



    <script type="text/javascript">

        var tabName = "{{@$data['tabname']}}";

        var last_inserted_employee = "{{$last_inserted_employee}}";



        $(document).ready(function(){



            $('.nav-tabs a[href="#tab_'+tabName+'"]').tab('show');



            var defaultProjectId = $('#projectId').val();



            if(defaultProjectId){

                $.ajax({

                    type: 'POST',

                    url: "{{ url('employees/project-information') }}",

                    data: {project_id: defaultProjectId},

                    success: function (result) {

                        $("#companyId").val(result.project.company.name);

                        $("#pfNo").val(result.project.company.pf_account_number);

                        $("#tanNo").val(result.project.company.tan_number);

                        //$("#certificateNo").val(result.certificateNo);

                        $("#ptStateId").val(result.states);

                        $("#esiLocationId").val(result.locations);

                        //$("#esiNo").val(result.esiNo);

                        $("#salaryHeadId").val(result.project.salary_structure.name);

                        $("#salaryCycleId").val(result.project.salary_cycle.name);

                    }

                });

            }



            $('#projectId').on('change',function(){

                var projectId = $(this).val();



                $.ajax({

                    type: 'POST',

                    url: "{{ url('employees/project-information') }}",

                    data: {project_id: projectId},

                    success: function (result) {

                        $("#companyId").val(result.project.company.name);

                        $("#pfNo").val(result.project.company.pf_account_number);

                        $("#tanNo").val(result.project.company.tan_number);

                        //$("#certificateNo").val(result.certificateNo);

                        $("#ptStateId").val(result.states);

                        $("#esiLocationId").val(result.locations);

                        //$("#esiNo").val(result.esiNo);

                        $("#salaryHeadId").val(result.project.salary_structure.name);

                        $("#salaryCycleId").val(result.project.salary_cycle.name);

                    }

                });

            });



            $(".approveTheEmployee").on('click',function(){

                var approveUrl = "{{@$data['approve_url']}}";

                var userId = "{{@$data['user']->id}}";

                if(approveUrl != ""){

                    if (!confirm("Are you sure you want to approve the employee?")) {

                        return false;

                    }else{

                        $.ajax({

                            type: 'POST',

                            url: approveUrl,

                            data: {user_id: userId},

                            success: function (result) {

                                if(result.approved == 1){

                                    $('#approveEmployeeLink').hide();

                                    $("#empApprover").text(result.approver_name);

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



            var departmentId = $("#departmentId").val();



            //var reportingManagersArray = "<?php //echo json_encode($data['profileData']['reportingManagers']); ?>";

            //reportingManagersArray = [];//reportingManagersArray.slice(1, -1);

            // var lastInsertedEmployeee = "{{$last_inserted_employee}}";

            // var mdDataName = "";

            // var mdDataId = "";



            // var mdFlag = 0;



            // if(departmentId){

            //   $.ajax({

            //     type: 'POST',

            //     url: "{{ url('/employees/departmentWiseEmployees')}} ",

            //     data: {departmentId: departmentId},

            //     success: function (result) {

            //       $("#employeeIds").empty();



            //       if(result.length != 0){



            //         $("#employeeIds").append("<option value='' selected disabled>Please Select Employee's Reporting Manager</option>");



            //         $.each(result,function(key,value){



            //           if(value == mdDataId){

            //             mdFlag = 1;

            //           }



            //           if(value == reportingManagersArray){



            //             $("#employeeIds").append('<option value="'+value+'" selected>'+key+'</option>');



            //           }else if(value == lastInsertedEmployeee){



            //             $("#employeeIds").append('<option value="'+value+'" disabled>'+key+'</option>');



            //           }else{



            //             $("#employeeIds").append('<option value="'+value+'">'+key+'</option>');

            //           }



            //         });



            //         if(mdFlag == 0){

            //           if(mdDataName){

            //             if(mdDataId == reportingManagersArray){

            //               $("#employeeIds").append('<option value="'+mdDataId+'" selected>'+mdDataName+'</option>');

            //             }else{

            //               $("#employeeIds").append('<option value="'+mdDataId+'">'+mdDataName+'</option>');

            //             }

            //           }

            //         }



            //         if(departmentId == 12){

            //           if(reportingManagersArray == 37){

            //             $("#employeeIds").append('<option value="37" selected>'+"Amit Setia"+'</option>');

            //           }else{

            //             $("#employeeIds").append('<option value="37">'+"Amit Setia"+'</option>');

            //           }

            //         }

            //       }else{



            //         $("#employeeIds").append("<option value='' selected disabled>None</option>");

            //         if(mdFlag == 0){

            //           if(mdDataName){

            //             $("#employeeIds").append('<option value="'+mdDataId+'">'+mdDataName+'</option>');

            //           }

            //         }

            //       }

            //     }

            //   });

            // }



            // $("#departmentId").on('change', function(){

            //   var departmentId = $(this).val();

            //   var mdFlag = 0;



            //   if(departmentId){

            //     $.ajax({

            //       type: 'POST',

            //       url: "{{ url('/employees/departmentWiseEmployees')}} ",

            //       data: {departmentId: departmentId},

            //       success: function (result) {

            //         $("#employeeIds").empty();



            //         if(result.length != 0){

            //           $("#employeeIds").append("<option value='' selected disabled>Please Select Employee's Reporting Manager</option>");



            //           $.each(result,function(key,value){

            //             if(value == mdDataId){

            //               mdFlag = 1;

            //             }



            //             // if(value == reportingManagersArray){



            //             //   $("#employeeIds").append('<option value="'+value+'" selected>'+key+'</option>');



            //             // }else



            //             if(value == lastInsertedEmployeee){



            //               $("#employeeIds").append('<option value="'+value+'" disabled>'+key+'</option>');



            //             }else{



            //               $("#employeeIds").append('<option value="'+value+'">'+key+'</option>');

            //             }

            //           });



            //           if(mdFlag == 0){

            //             if(mdDataName){

            //               $("#employeeIds").append('<option value="'+mdDataId+'">'+mdDataName+'</option>');

            //             }

            //           }



            //           if(departmentId == 12){

            //             $("#employeeIds").append('<option value="37">'+"Amit Setia"+'</option>');

            //           }

            //         }else{

            //           $("#employeeIds").append("<option value='' selected disabled>None</option>");



            //           if(mdFlag == 0){

            //             if(mdDataName){

            //               $("#employeeIds").append('<option value="'+mdDataId+'" selected>'+mdDataName+'</option>');

            //             }

            //           }

            //         }

            //       }

            //     });

            //   }

            // });



            $('#perStateId').on('change', function(){

                var stateId = $(this).val();

                var stateIds = [];

                stateIds.push(stateId);



                $('#perCityId').empty();

                var displayString = "";



                $.ajax({

                    type: 'POST',

                    url: "{{ url('employees/states-wise-cities') }} ",

                    data: {stateIds: stateIds},

                    success: function(result){

                        if(result.length != 0){

                            result.forEach(function(city){

                                displayString += '<option value="'+city.id+'">'+city.name+'</option>';

                            });

                        }else{

                            displayString += '<option value="" selected disabled>None</option>';

                        }



                        $('#perCityId').append(displayString);

                    }

                });



            }).change();



            $('#preStateId').on('change', function(){

                var stateId = $(this).val();

                var stateIds = [];

                stateIds.push(stateId);



                $('#preCityId').empty();

                var displayString = "";



                $.ajax({

                    type: 'POST',

                    url: "{{ url('employees/states-wise-cities') }} ",

                    data: {stateIds: stateIds},

                    success: function(result){

                        if(result.length != 0){

                            result.forEach(function(city){

                                displayString += '<option value="'+city.id+'">'+city.name+'</option>';

                            });

                        }else{

                            displayString += '<option value="" selected disabled>None</option>';

                        }



                        $('#preCityId').append(displayString);

                    }

                });



            }).change();



            /////////////////////On load////////////////////////

            var managerDepartmentIds = $("#managerDepartmentIds").val();

            var leaveAuthorities = "{{json_encode($data['leave_authorities'])}}";

            leaveAuthorities = JSON.parse(leaveAuthorities);



            $('#employeeIds').empty();

            $('#hodId').empty();

            $('#hrId').empty();

            $('#mdId').empty();

            var displayString1 = "";

            var displayString2 = "";

            var displayString3 = "";

            var displayString4 = "";



            if(managerDepartmentIds.length != 0){

                $.ajax({

                    type: 'POST',

                    url: "{{ url('employees/departments-wise-employees') }}",

                    data: {department_ids: managerDepartmentIds},

                    success: function(result){



                        if(result.length != 0){

                            result.forEach(function(employee){

                                if(employee.user_id == leaveAuthorities[0]){

                                    displayString1 += '<option value="'+employee.user_id+'" selected>'+employee.fullname+'('+employee.employee_code+')</option>';

                                }else{

                                    displayString1 += '<option value="'+employee.user_id+'">'+employee.fullname+'('+employee.employee_code+')</option>';

                                }



                            });

                        }else{

                            displayString1 += '<option value="" selected disabled>None</option>';

                        }



                        if(result.length != 0){

                            result.forEach(function(employee){

                                if(employee.user_id == leaveAuthorities[1]){

                                    displayString2 += '<option value="'+employee.user_id+'" selected>'+employee.fullname+'('+employee.employee_code+')</option>';

                                }else{

                                    displayString2 += '<option value="'+employee.user_id+'">'+employee.fullname+'('+employee.employee_code+')</option>';

                                }



                            });

                        }else{

                            displayString2 += '<option value="" selected disabled>None</option>';

                        }



                        if(result.length != 0){

                            result.forEach(function(employee){

                                if(employee.user_id == leaveAuthorities[2]){

                                    displayString3 += '<option value="'+employee.user_id+'" selected>'+employee.fullname+'('+employee.employee_code+')</option>';

                                }else{

                                    displayString3 += '<option value="'+employee.user_id+'">'+employee.fullname+'('+employee.employee_code+')</option>';

                                }



                            });

                        }else{

                            displayString3 += '<option value="" selected disabled>None</option>';

                        }



                        if(result.length != 0){

                            result.forEach(function(employee){

                                if(employee.user_id == leaveAuthorities[3]){

                                    displayString4 += '<option value="'+employee.user_id+'" selected>'+employee.fullname+'('+employee.employee_code+')</option>';

                                }else{

                                    displayString4 += '<option value="'+employee.user_id+'">'+employee.fullname+'('+employee.employee_code+')</option>';

                                }



                            });

                        }else{

                            displayString4 += '<option value="" selected disabled>None</option>';

                        }



                        $('#employeeIds').append(displayString1);

                        $('#hodId').append(displayString2);

                        $('#hrId').append(displayString3);

                        $('#mdId').append(displayString4);

                    }

                });

            }else{

                var displayString = '';
                displayString += '<option value="" selected disabled>None</option>';

                $('#employeeIds').append(displayString);

                $('#hodId').append(displayString);

                $('#hrId').append(displayString);

                $('#mdId').append(displayString);

            }



            ///////////////////////////////////////////////////////////



            $('#managerDepartmentIds').on('change', function(){

                var managerDepartmentIds = $(this).val();



                $('#employeeIds').empty();

                $('#hodId').empty();

                $('#hrId').empty();

                $('#mdId').empty();

                var displayString = "";


                if(managerDepartmentIds.length != 0){

                    $.ajax({

                        type: 'POST',

                        url: "{{ url('employees/departments-wise-employees') }}",

                        data: {department_ids: managerDepartmentIds},

                        success: function(result){



                            if(result.length != 0){

                                result.forEach(function(employee){

                                    displayString += '<option value="'+employee.user_id+'">'+employee.fullname+'('+employee.employee_code+')</option>';

                                });

                            }else{

                                displayString += '<option value="" selected disabled>None</option>';

                            }



                            $('#employeeIds').append(displayString);

                            $('#hodId').append(displayString);

                            $('#hrId').append(displayString);

                            $('#mdId').append(displayString);

                        }

                    });

                }
                else{

                    displayString += '<option value="" selected disabled>None</option>';

                    $('#employeeIds').append(displayString);

                    $('#hodId').append(displayString);

                    $('#hrId').append(displayString);

                    $('#mdId').append(displayString);

                }

            });



            $(".checkAjax").on("keyup",function(event){

                var referralCode = $("#referralCode").val();

                var email = $("#email").val();

                var mobile = $("#mobile").val();

                var employeeXeamCode = $("#employeeXeamCode").val();

                var oldXeamCode = $("#oldXeamCode").val();



                $.ajax({

                    type: 'POST',

                    url: "{{ url('employees/check-unique-employee') }}",

                    data: {referralCode: referralCode,email: email,mobile: mobile, employeeXeamCode: employeeXeamCode, oldXeamCode: oldXeamCode},

                    success: function (result) {

                        console.log(result);



                        // if(result.referralMatch == "yes"){

                        //   $(".checkReferral").removeClass("text-warning");

                        //   $(".checkReferral").addClass("text-success").text("Referral code matched successfully.");

                        //   allowFormSubmit.referralCode = 1;



                        // }else if(result.referralMatch == "no"){

                        //   $(".checkReferral").removeClass("text-success");

                        //   $(".checkReferral").addClass("text-warning").text("Referral code does not matches.");

                        //   allowFormSubmit.referralCode = 0;



                        // }else if(result.referralMatch == "blank"){

                        //   $(".checkReferral").text("");

                        //   allowFormSubmit.referralCode = 1;

                        // }



                        // if(result.emailUnique == "no"){

                        //   $(".checkEmail").addClass("text-warning").text("Email already exists.");

                        //   allowFormSubmit.email = 0;



                        // }else if(result.emailUnique == "yes"){

                        //   $(".checkEmail").text("");

                        //   allowFormSubmit.email = 1;



                        // }else if(result.emailUnique == "blank"){

                        //   $(".checkEmail").text("");

                        //   allowFormSubmit.email = 0;

                        // }



                        // if(result.employeeXeamCodeUnique == "no"){

                        //   $(".checkEmployeeXeamCode").addClass("text-warning").text("Xeam Code already exists.");

                        //   allowFormSubmit.employeeXeamCode = 0;



                        // }else if(result.employeeXeamCodeUnique == "yes"){

                        //   $(".checkEmployeeXeamCode").text("");

                        //   allowFormSubmit.employeeXeamCode = 1;



                        // }else if(result.employeeXeamCodeUnique == "blank"){

                        //   $(".checkEmployeeXeamCode").text("");

                        //   allowFormSubmit.employeeXeamCode = 0;

                        // }



                        // if(result.oldXeamCodeUnique == "no"){

                        //   $(".checkOldXeamCode").addClass("text-warning").text("Punch ID already exists.");

                        //   allowFormSubmit.oldXeamCode = 0;



                        // }else if(result.oldXeamCodeUnique == "yes"){

                        //   $(".checkOldXeamCode").text("");

                        //   allowFormSubmit.oldXeamCode = 1;



                        // }else if(result.oldXeamCodeUnique == "blank"){

                        //   $(".checkOldXeamCode").text("");

                        //   allowFormSubmit.oldXeamCode = 0;

                        // }



                        // if(result.mobileUnique == "no"){

                        //   $(".checkMobile").addClass("text-warning").text("Mobile already exists.");

                        //   allowFormSubmit.mobile = 0;



                        // }else if(result.mobileUnique == "yes"){

                        //   $(".checkMobile").text("");

                        //   allowFormSubmit.mobile = 1;



                        // }else if(result.mobileUnique == "blank"){

                        //   $(".checkMobile").text("");

                        //   allowFormSubmit.mobile = 0;

                        // }

                    }

                });

            });



            $(".basicFormSubmit").click(function(){

                var value = $(this).val();

                $(".basicFormSubmitButton").val(value);



                if(allowFormSubmit.mobile == 1 && allowFormSubmit.email == 1 && allowFormSubmit.referralCode == 1 && allowFormSubmit.employeeXeamCode == 1 && allowFormSubmit.oldXeamCode == 1 && allowFormSubmit.marriageDate == 1 && allowFormSubmit.birthDate == 1){

                    $("#basicDetailsForm").submit();

                }else{

                    return false;

                }

            });



            $(".profileFormSubmit").click(function(){

                var value = $(this).val();

                $(".profileFormSubmitButton").val(value);



                if(last_inserted_employee != "0"){

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

                if(last_inserted_employee != "0"){

                    $("#noEmployeeDocument").hide();

                    $("#documentDetailsForm").submit();

                }else{

                    $('#uploadModal').modal('hide');

                    $("#noEmployeeDocument").show();

                    $("#noEmployeeDocument").fadeOut(6000);

                    return false;

                }

            });



            $("#qualificationDocumentFormSubmit").click(function(){

                if(last_inserted_employee != "0"){

                    $("#noEmployeeDocument").hide();

                    $("#qualificationDocumentDetailsForm").submit();

                }else{

                    $('#uploadQualificationModal').modal('hide');

                    $("#noEmployeeDocument").show();

                    $("#noEmployeeDocument").fadeOut(6000);

                    return false;

                }

            });



            $(".addressFormSubmit").click(function(){

                var value = $(this).val();

                $(".addressFormSubmitButton").val(value);



                if(last_inserted_employee != "0"){

                    $("#noEmployeeAddress").hide();

                    $("#addressDetailsForm").submit();

                }else{

                    $("#noEmployeeAddress").show();

                    $("#noEmployeeAddress").fadeOut(6000);

                    return false;

                }

            });



            $(".accountFormSubmit").click(function(){

                var value = $(this).val();

                $(".accountFormSubmitButton").val(value);



                if(last_inserted_employee != "0"){

                    $("#noEmployeeAccount").hide();

                    $("#accountDetailsForm").submit();

                }else{

                    $("#noEmployeeAccount").show();

                    $("#noEmployeeAccount").fadeOut(6000);

                    return false;

                }

            });



            $(".historyFormSubmit").click(function(){

                var value = $(this).val();

                $(".historyFormSubmitButton").val(value);



                if(last_inserted_employee != "0"){

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

                var value = $(this).val();

                $(".referenceFormSubmitButton").val(value);



                if(last_inserted_employee != "0"){

                    $("#noEmployeeReference").hide();

                    $("#referenceDetailsForm").submit();

                }else{

                    $("#noEmployeeReference").show();

                    $("#noEmployeeReference").fadeOut(6000);

                    return false;

                }

            });



            $("#securityFormSubmit").click(function(){

                if(last_inserted_employee != "0"){

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

                    $("#preStateId").val($('#perStateId').val()).trigger('change');

                    setTimeout(() => {
                        $("#preCityId").val($('#perCityId').val());
                    }, 1000);

                }else{

                    $("#preHouseNo").val("");

                    //$("#perHouseName").val("");

                    $("#preRoadStreet").val("");

                    $("#preLocalityArea").val("");

                    $("#prePinCode").val("");



                    $(".preEmergencyNumberStdId").val($(".perEmergencyNumberStdId").val());

                    $("#preEmergencyNumber").val("");



                    $(".preCountryId").val($('.perCountryId').val());

                    $("#preStateId").val($('#perStateId').val()).trigger('change');

                    setTimeout(() => {
                        $("#preCityId").val($('#perCityId').val());
                    }, 1000);

                }
            });
        });



    </script>



    <script type="text/javascript">

        var today = new Date();

        var yesterday = moment().subtract(1, 'days')._d;



        //Date picker

        $("#birthDate").datepicker({

            //format: 'dd/mm/yyyy',

            endDate: yesterday,

            autoclose: true,

            orientation: "bottom"

        });



        $("#marriageDate").datepicker({

            //format: 'dd/mm/yyyy',

            endDate: yesterday,

            autoclose: true,

            orientation: "bottom"

        });



        $("#insuranceExpiryDate").datepicker({

            //format: 'dd/mm/yyyy',

            startDate: today,

            autoclose: true,

            orientation: "bottom"

        });



        $("#fromDate").datepicker({

            //format: 'dd/mm/yyyy',

            endDate: yesterday,

            autoclose: true,

            orientation: "bottom"

        });



        $("#toDate").datepicker({

            //format: 'dd/mm/yyyy',

            endDate: yesterday,

            autoclose: true,

            orientation: "bottom"

        });



        $("#joiningDate").datepicker({

            autoclose: true,

            orientation: "bottom",

            //format: 'dd/mm/yyyy'

        });



        $("#contractSignedDate").datepicker({

            //format: 'dd/mm/yyyy',

            endDate: today,

            autoclose: true,

            orientation: "bottom"

        });



        $("#ddDate").datepicker({

            autoclose: true,

            orientation: "bottom",

            //format: 'dd/mm/yyyy'

        });



        // $("#contractSignedDate").on('change',function(){

        //   var date = $(this).val();



        //   if(Date.parse(date) > Date.parse(today)){

        //     allowProfileFormSubmit.contractDate = 0;

        //     $(".contractSignedDateErrors").text("Please select a valid date.").css("color","#f00");

        //       $(".contractSignedDateErrors").show();

        //       return false;

        //   }else{

        //     allowProfileFormSubmit.contractDate = 1;

        //     $(".contractSignedDateErrors").text("");

        //       $(".contractSignedDateErrors").hide();

        //   }

        // });



        $("#birthDate").on('change',function(){

            var date = $(this).val();

            var marriageDate = $('#marriageDate').val();



            // if(Date.parse(date) > Date.parse(yesterday)){

            //   allowFormSubmit.birthDate = 0;

            //   $(".birthDateErrors").text("Please select a valid date.")

            //   $(".birthDateErrors").show();

            //   return false;

            // }



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



            // if(Date.parse(date) > Date.parse(yesterday)){

            //   employeeHistorySubmit.fromDate = 0;

            //   $(".fromDateErrors").text("Please select a valid date.").css('color','#f00');

            //   $(".fromDateErrors").show();



            //   return false;

            // }



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



            // if(Date.parse(date) > Date.parse(yesterday)){

            //   employeeHistorySubmit.toDate = 0;

            //   $(".toDateErrors").text("Please select a valid date.").css('color','#f00');

            //   $(".toDateErrors").show();



            //   return false;

            // }



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



            // if(Date.parse(date) > Date.parse(yesterday)){

            //   allowFormSubmit.marriageDate = 0;

            //   $(".marriageDateErrors").text("Please select a valid date.")

            //   $(".marriageDateErrors").show();

            //   return false;



            // }



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

        // kra management functionalities starts here
        function reminder_mail(obj){
            if(obj.prop('checked')){
                obj.parents('.remind-section').find('.reminderMail').val('on');
            }else{
                obj.parents('.remind-section').find('.reminderMail').val('off');
            }

        }

        function set_close(obj){
            var time = obj.parents('.remind-section').find('.time_period option:selected').val();
            //alert(time);

            obj.parents('.remind-section').find('.reminderTime').val(time);

        }
        function reminder_notification(obj){
            if(obj.prop('checked')){
                obj.parents('.remind-section').find('.reminderNotification').val('on');
            }else{
                obj.parents('.remind-section').find('.reminderNotification').val('off');
            }
        }
        function reminderEnable(obj){
            console.log(obj.val());

            if(obj.prop('checked')){

                obj.parents('.remind-section').find('.reminder_check').val('on');
                obj.parents('.remind-section').find('.time_period').prop('disabled', false);
                obj.parents('.remind-section').find('.reminder_notification').prop('disabled', false);
                obj.parents('.remind-section').find('.reminder_mail').prop('disabled', false);
            }else{
                obj.parents('.remind-section').find('.reminderNotification').val('off');
                obj.parents('.remind-section').find('.reminderMail').val('off');
                obj.parents('.remind-section').find('.reminder_check').val('off');
                obj.parents('.remind-section').find('.time_period').val("0");
                obj.parents('.remind-section').find('.time_period').prop('disabled', true);
                obj.parents('.remind-section').find('.reminder_notification').prop('checked', false);
                obj.parents('.remind-section').find('.reminder_notification').prop('disabled', true);
                obj.parents('.remind-section').find('.reminder_mail').prop('checked', false);
                obj.parents('.remind-section').find('.reminder_mail').prop('disabled', true);
            }
        }


        $(function () {
            //Date picker
            $('.datepicker').datepicker({
                autoclose: true,
                orientation: "bottom",
                format: 'yyyy-mm-dd'
            });
        });

        $('#kra_name').on('change', function(){

            var id = $(this).val();

            var postURL = "<?php echo url('employees/edit-profile-details'); ?>";
            $.ajax({
                url: postURL,
                method: 'POST',
                type: 'json',
                data: {kra_id : id},
                success:function(data){

                    var content = '';
                    var data = $.parseJSON(data);

                    $.each(data, function(i, kra) {

                        $.each(kra['kra_templates'], function(i, kraTemp) {

                            content += '<tr class="kra_row"><td class="text-center"><label class="t-check-container"><input type="checkbox" name="kra_name_id[]" class="selectSingleCheckbox" value="'+kraTemp.id+'"><span class="task-checkmark"></span></label></td><td>'+kraTemp.name+'</td><td>'+kraTemp.frequency+'</td><td>'+kraTemp.activation_date+'</td><td>'+kraTemp.deadline_date+'</td><td>'+kraTemp.priority+'</td><td><div class="text-center"> <a href="#" class="btn btn-info btn-sm" data-toggle="modal" data-target="#reminder_modal'+kraTemp.id+'">Show</a> </div> <div class="modal fade" id="reminder_modal'+kraTemp.id+'"> <div class="modal-dialog">      <div class="modal-content">         <div class="modal-header">            <button type="button" class="close attendance-close" data-dismiss="modal" aria-label="Close">             <span aria-hidden="true">&times;</span></button>            <h4 class="modal-title text-center">Add Reminder&nbsp;&nbsp;<span class="user-remarks"></span></h4>   </div>   <div class="modal-body">           <div class="remind-section">                <div class="col-md-2 task-columns">                  <input type="checkbox" onclick="reminderEnable($(this))" name="rem_data['+kraTemp.id+'][reminder][]" class="add_task_reminder">                  <span class="task-checkbox-label">Reminder</span> </div>                <div class="col-md-5 task-columns">                  <select class="form-control input-sm basic-detail-input-style rem-input time_period" name="rem_data['+kraTemp.id+'][time_period][]" disabled>   <option value="0" selected>Select frequency of reminder</option>  <option value="0.5">Twice per day</option>                    <option value="1">Once everyday</option>                    <option value="2">Once every 2 days</option>     <option value="5">Once every 5 days</option>    <option value="10">Once every 10 days</option>                    <option value="25">Once every month</option>                  </select>                </div>                <div class="col-md-3 task-columns">                  <input type="checkbox" name="rem_data['+kraTemp.id+'][reminder_notification][]" class="checkTaskNotification reminder_notification rem-input" disabled>                  <span class="task-checkbox-label">Notification</span>    <input type="checkbox" name="rem_data['+kraTemp.id+'][reminder_mail][]" class="checkTaskMail reminder_mail rem-input" disabled>  <span class="task-checkbox-label">Mail</span> </div> <button type="button" class="set_close attendance-close btn btn-primary" data-dismiss="modal" aria-label="Close">set</button>  </div>   </div>      </div> </div> </div></td></tr>';


                        });
                    });

                    $(".kra_tbody").html(content);
                },

                error: function(errorThrown){
                    alert('error');
                    console.log(errorThrown);
                }
            });
        });


        $(document).ready(function(){
            var i=1;
            $('#add').click(function(){

                i++;
                <?php
                $data['days']=array("Sunday", "Monday", "Tuesday", "Wednesday", "Thrusday", "Friday", "Saturday");
                ?>
                $('#dynamic_field').append('<div id="row'+i+'"><div class="col-md-4"></div><div class="col-md-8 basic-input-right appended-shiftss"><div class="col-md-5 es-first-col"><select class="form-control input-sm basic-detail-input-style" name="exceptionshiftTimingId_new[]"><option value="" selected disabled>Please Select Shift</option>  <?php foreach($data['shifts'] as $shift){ ?> <option value="<?php echo $shift->id; ?> "> <?php echo $shift->name; ?> </option> <?php } ?></select> </div> <div class="col-md-4 es-second-col"><select class="form-control input-sm basic-detail-input-style" name="exceptionshiftday_new[]"><option value="" selected disabled>Please Select Day.</option><?php   foreach($data['days'] as $key=>$day){  ?><option value="<?php echo $key; ?>"><?php echo $day; ?></option> <?php } ?> </select></div><div class="col-md-1 es-third-col"><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove"><i class="fa fa-minus"></i></button></div></div></div> ');
            });
        });

        $(document).on('click', '.btn_remove', function(){

            var postURL = "<?php echo url('employees/edit-profile-details'); ?>";
            var button_id = $(this).attr("id");
            $.ajax({
                url: postURL,
                method: 'POST',
                type: 'JSON',
                data: {delete_id : button_id},
                success: function(data) {
                    if(data.status==1){
                        swal( data.msg, 'You clicked the delete button!', 'success')

                    }else{
                        swal( data.msg, 'You clicked the delete button!', 'error')
                    }


                }
            });
            $('#row'+button_id+'').fadeOut("fast");
        });

        $(document).ready(function(){
                <?php
                $current_month = date('m');
                $current_year =  date('Y');
                ?>
            var i=0;
            $('#add_new_kra').click(function(){

                $(".datepicker").datepicker("destroy");

                <?php
                $frequencies = array("Daily", "Weekly", "Monthly", "Fortnight", "Quarterly", "Biannually", "Annually");
                $priorities = array("H5", "H4", "H3", "H2", "H1");
                ?>
                $('.kra_tbody').append('<tr class="added_kra_row_'+i+'"><td class="text-center"> <a href="javascript:void(0)" id="'+i+'" class="added_remove_kra_row"><i class="fa fa-minus a_r_style a_r_style_red"></i></a></td><td><input type="text" name="added_name[]" class="form-control" placeholder="Enter Name" value="" required></td><td><select name="added_frequency[]" class="form-control task_frequncy'+i+'" required><option value="" selected disabled>Select frequency</option><?php foreach($frequencies as $frequency){ ?><option value="<?php echo $frequency; ?>"> <?php echo ucfirst($frequency); ?> </option> <?php } ?></select></td><td><div class="select_activation"> <input type="text" name="added_activation_date[]" id="activation_id" class="form-control datepicker"placeholder="2020-02-20" required> </div></td><td><input type="text" name="added_deadline[]" class="form-control datepicker" value="" required></td><td><select name="added_priority[]" class="form-control" required><option value="" selected="" disabled="">Select priority</option><?php foreach($priorities as $priority){ ?><option value="<?php echo $priority; ?> "> <?php echo ucfirst($priority); ?> </option> <?php } ?></select></td><td><div class="text-center"> <a href="#" class="btn btn-info btn-sm" data-toggle="modal" data-target="#added_reminder_modal'+i+'">Show</a> </div> <div class="modal fade" id="added_reminder_modal'+i+'"> <div class="modal-dialog">  <div class="modal-content">  <div class="modal-header">  <button type="button" class="close attendance-close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span></button>            <h4 class="modal-title text-center">Add Reminder&nbsp;&nbsp;<span class="user-remarks"></span></h4>         </div>          <div class="modal-body">  <div class="remind-section">   <div class="col-md-2 task-columns"> <input type="hidden" class="reminder_check" name="reminder_check[]" value=""> <input type="checkbox" onclick="reminderEnable($(this))" name="reminder[{{@$loop->iteration}}]" class="add_task_reminder" >                  <span class="task-checkbox-label">Reminder</span>                </div>                <div class="col-md-5 task-columns">  <input type="hidden" class="reminderTime" name="reminderTime[]" value=""> <select class="form-control input-sm basic-detail-input-style rem-input time_period" name="time_period[]"  onclick="reminderTime($(this))" disabled>                    <option value="0" selected>Select frequency of reminder</option>                    <option value="0.5">Twice per day</option>                    <option value="1">Once everyday</option>                    <option value="2">Once every 2 days</option>                    <option value="5">Once every 5 days</option>                    <option value="10">Once every 10 days</option>                    <option value="25">Once every month</option>                  </select>                </div>                <div class="col-md-3 task-columns">            <input type="hidden" class="reminderNotification" name="reminderNotification[]" value="">      <input type="checkbox" onclick="reminder_notification($(this))" name="reminder_notification[]" class="checkTaskNotification reminder_notification" disabled>                  <span class="task-checkbox-label">Notification</span>  <input type="hidden" class="reminderMail" name="reminderMail[]" value="">   <input type="checkbox" onclick="reminder_mail($(this))" name="reminder_mail[]" class="checkTaskMail reminder_mail" disabled>                  <span class="task-checkbox-label">Mail</span>                </div>  <button type="button" class="set_close attendance-close btn btn-primary" data-dismiss="modal" aria-label="Close" onclick="set_close($(this))">set</button>            </div>       </div>      </div>      </div>  </div></td></tr>');



                $(".task_frequncy"+i).on('change', function(){
                    var activation_class = $(this).closest('tr').find('td div.select_activation');
                    var freq_value = $(this).val();
                    //alert(freq_value);

                    if (freq_value == "Weekly") {
                        //alert("here");
                        activation_class.html('<select name="added_activation_date[]" id="select_activation_id" class="form-control" placeholder="2020-02-02" required><option value=" ">Activation Date</option> <option value="<?php echo $current_year; ?>-<?php echo $current_month; ?>-01"><?php echo $current_year; ?>-<?php echo $current_month; ?>-01</option>  <option value="<?php echo $current_year; ?>-<?php echo $current_month; ?>-07"><?php echo $current_year; ?>-<?php echo $current_month; ?>-07</option> <option value="<?php echo $current_year; ?>-<?php echo $current_month; ?>-14"><?php echo $current_year; ?>-<?php echo $current_month; ?>-14</option>   <option value="<?php echo $current_year; ?>-<?php echo $current_month; ?>-21"><?php echo $current_year; ?>-<?php echo $current_month; ?>-21</option> </select>');
                    }

                    if(freq_value=="Biannually"){

                        activation_class.html('<select name="added_activation_date[]" id="select_activation_id" class="form-control" placeholder="2020-02-02" required> <option value=" ">Activation Date</option> <option value="<?php echo $current_year; ?>-04-01"><?php echo $current_year; ?>-04-01</option> <option value="<?php echo $current_year; ?>-10-01"><?php echo $current_year;?>-10-01</option> </select>');
                    }
                    if(freq_value=="Fortnight"){

                        activation_class.html('<select name="added_activation_date[]" id="select_activation_id" class="form-control" placeholder="2020-02-02" required> <option value=" ">Activation Date</option> <option value="<?php echo $current_year; ?>-<?php echo $current_month; ?>-01"><?php echo $current_year; ?>-<?php echo $current_month; ?>-01</option> <option value="<?php echo $current_year; ?>-<?php echo $current_month; ?>-15"><?php echo $current_year;?>-<?php echo $current_month; ?>-01</option> </select>');
                    }
                    if(freq_value=="Quarterly"){

                        activation_class.html('<select name="added_activation_date[]" id="select_activation_id" class="form-control" placeholder="2020-02-02" required> <option value=" ">Activation Date</option> <option value="<?php echo $current_year; ?>-04-01"><?php echo $current_year; ?>-04-01</option> <option value="<?php echo $current_year; ?>-07-01"><?php echo $current_year;?>-07-01</option> <option value="<?php echo $current_year; ?>-10-01"><?php echo $current_year;?>-10-01</option> <option value="<?php echo $current_year; ?>-01-01"><?php echo $current_year;?>-10-01</option> </select>');
                    }
                    if(freq_value=="Annually"){

                        activation_class.html('<input type="text" name="added_activation_date[]" id="activation_id" class="form-control datepicker" placeholder="2020-02-20" required>');
                    }
                    if(freq_value=="Daily"){

                        activation_class.html('<input type="text" name="added_activation_date[]" id="activation_id" class="form-control datepicker" placeholder="2020-02-20" required>');
                    }
                    if(freq_value=="Monthly"){

                        activation_class.html('<input type="text" name="added_activation_date[]" id="activation_id" class="form-control datepicker" placeholder="2020-02-20" required>');
                    }
                    $('.datepicker').datepicker({ autoclose: true, orientation: "bottom", format: 'yyyy-mm-dd'
                    });
                })
                i++;



            });
        });

        $(document).on('click', '.remove_kra_row', function(){

            var postURL = "<?php echo url('employees/edit-profile-details'); ?>";
            var button_indicator_id = $(this).attr("id");
            $.ajax({
                url: postURL,
                method: 'POST',
                type: 'JSON',
                data: {delete_indicator_id : button_indicator_id},
                success: function(data) {
                    if(data.status==1){
                        swal( data.msg, 'You clicked the delete button!', 'success')

                    }else{
                        swal( data.msg, 'You clicked the delete button!', 'error')
                    }
                    location.reload();
                }
            });
            $('.kra_row'+button_indicator_id+'').fadeOut("fast");
        });

        $(document).on('click', '.added_remove_kra_row', function(){

            var remove_id = $(this).attr("id");
            //$('.added_kra_row_'+remove_id+'').fadeOut("fast");
            $('.added_kra_row_'+remove_id+'').detach();

        });


        //activation date filter base on frequency selection starts here

        <?php
        $current_month = date('m');
        $current_year =  date('Y');
        ?>

        //$('.task_frequncy').change(function(){
        $( ".task_frequncy" ).on( "change", function() {
            $(".datepicker").datepicker("destroy");
            var freq_value = $(this).val();
            var activation_class = $(this).closest('tr').find('td div.select_activation');
            //alert(freq_value);
            if (freq_value == "Weekly") {


                activation_class.html('<select name="activation_date[]" id="select_activation_id" class="form-control" placeholder="2020-02-02"><option value=" ">Activation Date</option> <option value="<?php echo $current_year; ?>-<?php echo $current_month; ?>-01"><?php echo $current_year; ?>-<?php echo $current_month; ?>-01</option>  <option value="<?php echo $current_year; ?>-<?php echo $current_month; ?>-07"><?php echo $current_year; ?>-<?php echo $current_month; ?>-07</option> <option value="<?php echo $current_year; ?>-<?php echo $current_month; ?>-14"><?php echo $current_year; ?>-<?php echo $current_month; ?>-14</option>   <option value="<?php echo $current_year; ?>-<?php echo $current_month; ?>-21"><?php echo $current_year; ?>-<?php echo $current_month; ?>-21</option> </select>');
            }

            if(freq_value=="Biannually"){
                activation_class.html('<select name="activation_date[]" id="select_activation_id" class="form-control"placeholder="2020-02-02"> <option value=" ">Activation Date</option> <option value="<?php echo $current_year; ?>-04-01"><?php echo $current_year; ?>-04-01</option> <option value="<?php echo $current_year; ?>-10-01"><?php echo $current_year;?>-10-01</option> </select>');
            }
            if(freq_value=="Fortnight"){
                activation_class.html('<select name="activation_date[]" id="select_activation_id" class="form-control"placeholder="2020-02-02"> <option value=" ">Activation Date</option> <option value="<?php echo $current_year; ?>-<?php echo $current_month; ?>-01"><?php echo $current_year; ?>-<?php echo $current_month; ?>-01</option> <option value="<?php echo $current_year; ?>-<?php echo $current_month; ?>-15"><?php echo $current_year;?>-<?php echo $current_month; ?>-01</option> </select>');
            }
            if(freq_value=="Quarterly"){
                activation_class.html('<select name="activation_date[]" id="select_activation_id" class="form-control"placeholder="2020-02-02"> <option value=" ">Activation Date</option> <option value="<?php echo $current_year; ?>-04-01"><?php echo $current_year; ?>-04-01</option> <option value="<?php echo $current_year; ?>-07-01"><?php echo $current_year;?>-07-01</option> <option value="<?php echo $current_year; ?>-10-01"><?php echo $current_year;?>-10-01</option> <option value="<?php echo $current_year; ?>-01-01"><?php echo $current_year;?>-10-01</option> </select>');
            }
            if(freq_value=="Annually"){
                activation_class.html('<input type="text" name="activation_date[]" id="activation_id" class="form-control datepicker"placeholder="2020-02-20">');
            }
            if(freq_value=="Daily"){
                activation_class.html('<input type="text" name="activation_date[]" id="activation_id" class="form-control datepicker"placeholder="2020-02-20">');
            }
            if(freq_value=="Monthly"){
                activation_class.html('<input type="text" name="activation_date[]" id="activation_id" class="form-control datepicker"placeholder="2020-02-20">');
            }

            $(".datepicker").datepicker({autoclose: true, orientation: "bottom", format: 'yyyy-mm-dd' });
        });

        $('#projectId').change(function() {
            var projectId = $(this).val();
            console.log(projectId);
            $.ajax({
                type: 'POST',
                url: '{{ URL('payroll/salary-structures/project-cycles') }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    project_id: projectId
                },
                success: function (data) {
                    var salaryCycles = data.data;
                    if(salaryCycles.length > 0)
                    {
                        var formoption = "<option selected disabled>--Select Salary Cycle--</option>";
                        $.each(salaryCycles, function(v) {
                            var val = salaryCycles[v]
                            formoption += "<option value='" + val['id'] + "'>" + val['name'] + "</option>";
                        });
                        $('#salary_cycle').html(formoption);
                    }else{
                        var formoption = '<option selected disabled>--Not Any Salary Cycle--</option>';
                        $('#salary_cycle').html(formoption);
                    }
                },
                error: function (xhr) {
                    console.log(xhr.responseText);
                }
            });
        });

        //Salary Cycle
        $('#salary_cycle').change(function() {
            var projectId = $('#projectId').val();
            var salaryCycleId = $('#salary_cycle').val();
            var employeeEarningSalaryHeads = {!! json_encode($data['earning_heads']) !!};
            console.log(employeeEarningSalaryHeads);
            console.log(typeof employeeEarningSalaryHeads);
            var employeeDeductionSalaryHeads = {!! json_encode($data['deduction_heads']) !!};
            console.log(employeeDeductionSalaryHeads);
            console.log(typeof employeeDeductionSalaryHeads);
            var earningSalaryHeadValue = '';

            $.ajax({
                type: 'POST',
                url: '{{ URL('payroll/salary-structures/salary-heads') }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    project_id: projectId,
                    salary_cycle_id: salaryCycleId
                },
                success: function (data) {

                    var salaryHeads = data.data;
                    console.log(salaryHeads);
                    console.log(salaryHeads['earning_heads'].length );
                    console.log(salaryHeads['deduction_heads'].length );
                    if(salaryHeads['earning_heads'].length != 0 && salaryHeads['deduction_heads'].length != 0)
                    {
                        var earningHeads = salaryHeads['earning_heads'];
                        if(earningHeads.length > 0) {
                            var earningHeadOption = "";
                            $.each(earningHeads, function (v) {
                                var val = earningHeads[v]
                                earningHeadOption += "" +
                                    "<div class=\"col-md-4\">" +
                                    "<div class=\"form-group\">" +
                                    "<div class=\"row\">"+
                                    "<div class=\"col-md-5 col-sm-5 col-xs-5 label-470\">" +
                                    "<label for=\"ss_basic\" class=\"apply-leave-label\">"
                                    +val['name'].toUpperCase() +
                                    "</label>" +
                                    "</div>" +
                                    "<input type='hidden' name='earning_heads[]' value="+ val['id']+">"+
                                    "<div class=\"col-md-7 col-sm-7 col-xs-7 leave-input-box input-470 ss-small-input\">" +
                                    " <input type=\"number\" name=\"earning_heads_val[]\" id=\"ss_basic\" class=\"currency form-control input-sm basic-detail-input-style numberInput\" placeholder=\"Enter Amount\">" +
                                "</div>" +
                                "</div>" +
                                "</div>" +
                                "</div>"
                            });
                            $('#earningHeads').html(earningHeadOption);
                        }else{
                            var earningHeadOption = '<div>-- Not Any Earning Salary Head--</div>';
                            $('#earningHeads').html(earningHeadOption);
                        }

                        var deductionHeads = salaryHeads['deduction_heads'];
                        if(deductionHeads.length > 0) {
                            var deductionHeadOption = "";
                            $.each(deductionHeads, function (v) {
                                var val = deductionHeads[v]
                                deductionHeadOption +=
                                    "<div class=\"col-md-4\">" +
                                    "<div class=\"form-group\">" +
                                    "<div class=\"row\">"+
                                    "<div class=\"col-md-5 col-sm-5 col-xs-5 label-470\">" +
                                    "<label for=\"ss_basic\" class=\"apply-leave-label\">"
                                    + val['name'].toUpperCase() +
                                    "</label>" +
                                    "</div>" +
                                    "<input type='hidden' name='deduction_heads[]' value="+ val['id']+">"+
                                    "<div class=\"col-md-7 col-sm-7 col-xs-7 leave-input-box input-470 ss-small-input\">" +
                                    " <input type=\"number\" n\ame=\"deduction_heads_val[]\" id=\"ss_basic\" class=\"currency form-control input-sm basic-detail-input-style numberInput\" placeholder=\"Enter Amount\">\n" +
                                    "</div>" +
                                    "</div>" +
                                    "</div>" +
                                    "</div>"
                            });
                            $('#deductionHeads').html(deductionHeadOption);
                        }else{
                            var deductionHeadOption = '<div>-- Not Any Deduction Salary Head--</div>';
                            $('#deductionHeads').html(deductionHeadOption);
                        }
                    }
                    else{
                        var deductionHeadOption = '<div class="alert alert-danger error">Not Any Salary Head Added Yet</div>';
                        $('#allSalaryHead').html(deductionHeadOption);
                    }
                    $('input.currency').currencyInput();
                },
                error: function (xhr) {
                    console.log(xhr.responseText);
                },
                complete: function() {

                }
            });
        });

        $(document).ready(function() {
            var projectId = $('#projectId').val();
            $.ajax({
                type: 'POST',
                url: '{{ URL('payroll/salary-structures/project-cycles') }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    project_id: projectId
                },
                success: function (data) {
                    var salaryCycles = data.data;
                    if(salaryCycles.length > 0)
                    {
                        var formoption = "<option selected disabled>--Select Salary Cycle--</option>";
                        $.each(salaryCycles, function(v) {
                            var val = salaryCycles[v]
                            formoption += "<option value='" + val['id'] + "'>" + val['name'] + "</option>";
                        });
                        $('#salary_cycle').html(formoption);
                    }else{
                        var formoption = '<option selected disabled>--Not Any Salary Cycle--</option>';
                        $('#salary_cycle').html(formoption);
                    }
                },
                error: function (xhr) {
                    console.log(xhr.responseText);
                }
            });

        });

        (function($) {
            $.fn.currencyInput = function() {
                this.each(function() {
                    var wrapper = $("<div class='currency-input' />");
                    $(this).wrap(wrapper);
                    $(this).before("<span class='currency-symbol'>₹</span>");
                    $(this).change(function() {
                        var min = parseFloat($(this).attr("min"));
                        var max = parseFloat($(this).attr("max"));
                        var value = this.valueAsNumber;
                        if(value < min)
                            value = min;
                        else if(value > max)
                            value = max;
                        $(this).val(value.toFixed(2));
                    });
                });
            };
        })(jQuery);

        $(document).ready(function() {
            $('input.currency').currencyInput();
        })

    </script>



@endsection
