@extends('admins.layouts.app')

@section('content')

<link href="{!! asset('public/admin_assets/plugins/jquery-toast/jquery.toast.min.css') !!}" rel="stylesheet">
<!-- Content Wrapper Starts here -->
<div class="content-wrapper">
    <!-- Content Header Starts here -->
    <section class="content-header">
        <h1>Tender Processing</h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('employees/dashboard') }}">
                    <i class="fa fa-dashboard"></i> Home
                </a>
            </li>
        </ol>
    </section>
    <!-- Content Header Ends here -->
    <!-- Main content Starts here -->
    <section class="content">
        <div class="row">
            <div class="col-sm-12">
                <div class="box box-primary p-sm">
                    <!-- form start -->
                    @include('admins.validation_errors')
                    <form id="til-document-form" class="tender_single_form form-vertical" action="{{route('leads-management.assign-til-document', $tilDraft->id)}}" method="POST">
                        @csrf()
                        <div class="row">
                            <div class="col-md-4 tender_inner_boxes">
                                @php
                                    $prebid = $tilDraft->tenderPrebid;
                                    $prebidAttend = $tilDraft->tenderPrebidAttend;

                                    $prebidDisabled = (empty($prebid))? 'disabled' : null;
                                    $prebidCheck = null;
                                    if(@$prebid->functionality_type == 'pre_bid') {
                                        $prebidCheck = 'checked';
                                    }
                                    $prebidDepartmentId = @$prebid->department_id;
                                    $prebidUserId       = @$prebid->assigned_user_id;
                                    $prebidAttendDepartmentId = @$prebidAttend->department_id;
                                    $prebidAttendUserId = @$prebidAttend->assigned_user_id;
                                @endphp
                                <div class="box box-primary inner_boxes">
                                    <div class="box-header with-border leave-form-title-bg">
                                        <div class="inner_boxes_heading">
                                            <label class="t-check-container">
                                                <input type="checkbox" name="prebid[functionality_type]" class="selectSingleCheckbox" value="pre_bid" {{$prebidCheck}}>
                                                <span class="task-checkmark"></span>
                                                &nbsp;&nbsp;
                                                <span class="text">Prebid</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="box-body">
                                        <div class="row m-b-sm">
                                            <div class="col-md-6 prebid_col_6">
                                                <p>Prepare Prebid:</p>
                                                <div class="form-group">
                                                    <select name="prebid[department_id][]" id="prebid_department" class="form-control department_id input-sm basic-detail-input-style tender_dropdown" required {{$prebidDisabled}}>
                                                        <option value="">-Select-</option>
                                                        @if(!$departments->isEmpty())
                                                            @foreach($departments as $key => $department)
                                                                @php
                                                                    $prebidDept = ($prebidDepartmentId == $department->id)? 'selected' : null;
                                                                @endphp
                                                                <option value="{{$department->id}}" {{$prebidDept}}>
                                                                    {{$department->name}}
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <select name="prebid[user_id][]" id="prebid_employee" class="form-control user_id input-sm tender_dropdown basic-detail-input-style" required {{$prebidDisabled}}>
                                                        <option value="">-Select-</option>
                                                        @if(!$users->isEmpty())
                                                            @foreach($users as $key => $user)
                                                                @php
                                                                    $prebidUser = ($prebidUserId == $user->id)? 'selected' : null;
                                                                @endphp
                                                                <option value="{{$user->id}}" {{$prebidUser}}>
                                                                    {{$user->employee->fullname}}
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                                <input type="hidden" name="prebid[type][]" value="prepare" {{$prebidDisabled}}>
                                            </div>
                                            <div class="col-md-6">
                                                <p>Attend Prebid:</p>
                                                <div class="form-group">
                                                    <select name="prebid[department_id][]" id="prebid_department" class="form-control department_id input-sm basic-detail-input-style tender_dropdown" required {{$prebidDisabled}}>
                                                        <option value="">-Select-</option>
                                                        @if(!$departments->isEmpty())
                                                            @foreach($departments as $key => $department)
                                                                @php
                                                                    $prebidDept = ($prebidAttendDepartmentId == $department->id)? 'selected' : null;
                                                                @endphp
                                                                <option value="{{$department->id}}" {{$prebidDept}}>
                                                                    {{$department->name}}
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <select name="prebid[user_id][]" id="prebid_employee" class="form-control user_id input-sm tender_dropdown basic-detail-input-style" required {{$prebidDisabled}}>
                                                        <option value="">-Select-</option>
                                                        @if(!$users->isEmpty())
                                                            @foreach($users as $key => $user)
                                                                @php
                                                                    $prebidUser = ($prebidAttendUserId == $user->id)? 'selected' : null;
                                                                @endphp
                                                                <option value="{{$user->id}}" {{$prebidUser}}>
                                                                    {{$user->employee->fullname}}
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                                <input type="hidden" name="prebid[type][]" value="attend" {{$prebidDisabled}}>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <span class="til_document_div">
                                                <button type="submit" class="btn btn-primary til_document_btn">Submit</button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                @php
                                    $field = $tilDraft->tenderFieldStudy;
                                    $fieldAttend = $tilDraft->tenderFieldStudyAttend;

                                    $fieldDisabled = (empty($field))? 'disabled' : null;
                                    $fieldCheck = null;
                                    if(@$field->functionality_type == 'field_study') {
                                        $fieldCheck = 'checked';
                                    }
                                    $fieldDepartmentId = @$field->department_id;
                                    $fieldUserId       = @$field->assigned_user_id;
                                    $fieldAttendDepartmentId = @$fieldAttend->department_id;
                                    $fieldAttendUserId = @$fieldAttend->assigned_user_id;
                                @endphp
                                <div class="box box-primary inner_boxes">
                                    <div class="box-header with-border leave-form-title-bg">
                                        <div class="inner_boxes_heading">
                                            <label class="t-check-container">
                                                <input type="checkbox" name="field_study[functionality_type]" class="selectSingleCheckbox" value="field_study" {{$fieldCheck}}>
                                                <span class="task-checkmark"></span>
                                                &nbsp;&nbsp;
                                                <span class="text">Field Study</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="box-body">
                                        <div class="row m-b-sm">
                                            <div class="col-md-6 prebid_col_6">
                                                <p>Prepare Field Study:</p>
                                                <div class="form-group">
                                                    <select name="field_study[department_id][]" id="field_department" class="form-control department_id input-sm basic-detail-input-style tender_dropdown" required {{$fieldDisabled}}>
                                                        <option value="">-Select-</option>
                                                        @if(!$departments->isEmpty())
                                                            @foreach($departments as $key => $department)
                                                                @php
                                                                    $fieldDept = ($fieldDepartmentId == $department->id)? 'selected' : null;
                                                                @endphp

                                                                <option value="{{$department->id}}" {{$fieldDept}}>
                                                                    {{$department->name}}
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <select name="field_study[user_id][]" id="field_employee" class="form-control user_id input-sm tender_dropdown basic-detail-input-style" required {{$fieldDisabled}}>
                                                        <option value="">-Select-</option>
                                                        @if(!$users->isEmpty())
                                                            @foreach($users as $key => $user)
                                                                @php
                                                                    $fieldUser = ($fieldUserId == $user->id)? 'selected' : null;
                                                                @endphp
                                                                <option value="{{$user->id}}" {{$fieldUser}}>
                                                                    {{$user->employee->fullname}}
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                                <input type="hidden" name="field_study[type][]" value="prepare" {{$fieldDisabled}}>
                                            </div>
                                            <div class="col-md-6">
                                                <p>Attend Field Study:</p>
                                                <div class="form-group">
                                                    <select name="field_study[department_id][]" id="field_department" class="form-control department_id input-sm basic-detail-input-style tender_dropdown" required {{$fieldDisabled}}>
                                                        <option value="">-Select-</option>
                                                        @if(!$departments->isEmpty())
                                                            @foreach($departments as $key => $department)
                                                                @php
                                                                    $fieldDept = ($fieldAttendDepartmentId == $department->id)? 'selected' : null;
                                                                @endphp

                                                                <option value="{{$department->id}}" {{$fieldDept}}>
                                                                    {{$department->name}}
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <select name="field_study[user_id][]" id="field_employee" class="form-control user_id input-sm tender_dropdown basic-detail-input-style" required {{$fieldDisabled}}>
                                                        <option value="">-Select-</option>
                                                        @if(!$users->isEmpty())
                                                            @foreach($users as $key => $user)
                                                                @php
                                                                    $fieldUser = ($fieldAttendUserId == $user->id)? 'selected' : null;
                                                                @endphp
                                                                <option value="{{$user->id}}" {{$fieldUser}}>
                                                                    {{$user->employee->fullname}}
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                                <input type="hidden" name="field_study[type][]" value="attend" {{$fieldDisabled}}>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <span class="til_document_div">
                                                <button type="submit" class="btn btn-primary til_document_btn">Submit</button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                @php
                                    $cost = $tilDraft->tenderCostEstimation;
                                    $costDisabled = (empty($cost))? 'disabled' : null;
                                    $costCheck = null;
                                    if(@$cost->functionality_type == 'cost_estimation') {
                                        $costCheck = 'checked';
                                    }
                                    $costDepartmentId = @$cost->department_id;
                                    $costUserId = @$cost->assigned_user_id;
                                @endphp
                                <div class="box box-primary inner_boxes">
                                    <div class="box-header with-border leave-form-title-bg">
                                        <div class="inner_boxes_heading">
                                            <label class="t-check-container">
                                                <input type="checkbox" name="cost_estimation[functionality_type]" class="selectSingleCheckbox" value="cost_estimation" {{$costCheck}}>
                                                <span class="task-checkmark"></span>
                                                &nbsp;&nbsp;
                                                <span class="text">Cost Estimation</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="box-body">
                                        <p>Prepare Cost Estimation:</p>
                                        <div class="form-group">
                                            <select name="cost_estimation[department_id]" id="cost_estimation_department" class="form-control department_id input-sm basic-detail-input-style tender_dropdown" required {{$costDisabled}}>
                                              <option value="">-Select-</option>
                                              @if(!$departments->isEmpty())
                                                @foreach($departments as $key => $department)
                                                    @php
                                                        $costDept = ($costDepartmentId == $department->id)? 'selected' : null;
                                                    @endphp
                                                    <option value="{{$department->id}}" {{$costDept}}>
                                                        {{$department->name}}
                                                    </option>
                                                @endforeach
                                              @endif
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <select name="cost_estimation[user_id]" id="cost_estimation_employee" class="form-control user_id input-sm basic-detail-input-style tender_dropdown" required {{$costDisabled}}>
                                                <option value="">-Select-</option>
                                                @if(!$users->isEmpty())
                                                    @foreach($users as $key => $user)
                                                        @php
                                                            $costUser = ($costUserId == $user->id)? 'selected' : null;
                                                        @endphp
                                                        <option value="{{$user->id}}" {{$costUser}}>
                                                            {{$user->employee->fullname}}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        <div class="text-center">
                                            <span class="til_document_div">
                                                <button type="submit" class="btn btn-primary til_document_btn">Submit</button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                @php
                                    $checklist = $tilDraft->tenderDocumentChecklist;
                                    $checklistDisabled = (empty($checklist))? 'disabled' : null;
                                    $checklistCheck = null;
                                    if(@$checklist->functionality_type == 'document_checklist') {
                                        $checklistCheck = 'checked';
                                    }
                                    $checklistDepartmentId = @$checklist->department_id;
                                    $checklistUserId = @$checklist->assigned_user_id;
                                @endphp
                                <div class="box box-primary inner_boxes">
                                    <div class="box-header with-border leave-form-title-bg">
                                        <div class="inner_boxes_heading">
                                            <label class="t-check-container">
                                                <input type="checkbox" name="document[functionality_type]" class="selectSingleCheckbox" value="document_checklist" {{$checklistCheck}}>
                                                <span class="task-checkmark"></span>
                                                &nbsp;&nbsp;
                                                <span class="text">Document Checklist</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="box-body">
                                        <p>Prepare Document Checklist:</p>
                                        <div class="form-group">
                                            <select name="document[department_id]" id="document_department" class="form-control department_id input-sm basic-detail-input-style tender_dropdown" required {{$checklistDisabled}}>
                                              <option value="">-Select-</option>
                                              @if(!$departments->isEmpty())
                                                @foreach($departments as $key => $department)
                                                    @php
                                                        $checklistDept = ($checklistDepartmentId == $department->id)? 'selected' : null;
                                                    @endphp
                                                    <option value="{{$department->id}}" {{$checklistDept}}>
                                                        {{$department->name}}
                                                    </option>
                                                @endforeach
                                              @endif
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <select name="document[user_id]" id="document_employee" class="form-control user_id input-sm basic-detail-input-style tender_dropdown" required {{$checklistDisabled}}>
                                                <option value="">-Select-</option>
                                                @if(!$users->isEmpty())
                                                    @foreach($users as $key => $user)
                                                        @php
                                                            $checklistUser = ($checklistUserId == $user->id)? 'selected' : null;
                                                        @endphp
                                                        <option value="{{$user->id}}" {{$checklistUser}}>
                                                            {{$user->employee->fullname}}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        <div class="text-center">
                                            <span class="til_document_div">
                                                <button type="submit" class="btn btn-primary til_document_btn">Submit</button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer text-center">
                            <div class="col-md-12">
                                <a href="{!! route('leads-management.tender-processing') !!}" class="btn btn-default">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- Main content Ends Here-->
</div>
<!-- Content Wrapper Ends here -->
<!-- Script Source Files Starts here -->
<script src="{{asset('public/admin_assets/plugins/sweetalert/sweetalert.min.js')}}"></script>
<script src="{{asset('public/admin_assets/plugins/jquery-toast/jquery.toast.min.js')}}"></script>
<script src="{{asset('public/admin_assets/plugins/validations/jquery.validate.js')}}"></script>
<script src="{{asset('public/admin_assets/plugins/validations/additional-methods.js')}}"></script>
<!-- Script Source Files Ends here -->
<!-- Custom Script Starts here -->
<script>
    $(document).ready(function () {

        var userId = "{!! $tilDraft->user_id !!}";

        $(document).on('change', '.department_id', function() {
            var thisVal = $(this).val();
            var $this = $(this);

            var userOtions = '<option value="">-Select-</option>';

            if(thisVal != '') {
              var displayString = "";
              var departments = [];
              departments.push(thisVal);

              $.ajax({
                type: "POST",
                url: "{{url('leads-management/get-employees')}}",
                data: {department_ids: departments},
                beforeSend: function() {
                  // setting a timeout
                  $('div.loading').removeClass('hide');
                },
                success: function(result) {

                  if(result.length > 0) {
                    $(result).each(function(k, user) {
                      var employee = user.employee;

                      if(employee.user_id != userId && employee.user_id != 1) {
                        userOtions += '<option value="'+employee.user_id+'">' + employee.fullname + '</option>';
                      }
                    });
                  }

                  $($this).parents().eq(1).find('select.user_id').html(userOtions);
                  $('div.loading').addClass('hide');
                },
                error: function (xhr, ajaxOptions, thrownError) {
                  $('div.loading').addClass('hide');
                }
              });
            }
        });

        $('#til-document-form').validate({
            ignore: ':hidden, [readonly=readonly], :disabled, input[type=hidden], .select2-search__field', //[type="search"]
            errorElement: 'span',
            // debug: true,
            // the errorPlacement has to take the table layout into account
            errorPlacement: function(error, element) {
              error.appendTo(element.parent()); // element.parent().next()
            },
            rules: {
              cost_estimation_department_id: {required: true},
              cost_estimation_user_id: {required: true},
              prebid_department_id: {required: true},
              prebid_user_id: {required: true},
              prebid_field_department_id: {required: true},
              prebid_field_user_id: {required: true},
            },
        });

        //Enable single form by checkbox
        $(document).on('click', '.selectSingleCheckbox', function() {
            if($(this).is(':checked')) {
                $(this).parents('.inner_boxes').find('select').removeAttr('disabled');
                $(this).parents('.inner_boxes').find('input[type="hidden"]').removeAttr('disabled');
            } else {
                $(this).parents('.inner_boxes').find('select').prop('disabled', true).val('');
                $(this).parents('.inner_boxes').find('input[type="hidden"]').prop('disabled', true);
            }
        });

        $(document).on('click', '.til_document_btn', function(event) {
            event.preventDefault();  event.stopPropagation();

            if($('.selectSingleCheckbox:checked').length >= 1) {
                if($('#til-document-form').valid()) {
                    $('#til-document-form').submit();
                }
            } else {
                var _message = 'PLease check one of the PreBid, Field Study, Cost Estimation, Document Checklist checkbox before submit the form.';
                toastMessage(_message);
            }
        });
    });

    function toastMessage(_message, _heading = 'Error', _icon = 'error', _hideAfter = 10000)
    {
        $.toast({
          heading: _heading,
          text: _message,
          showHideTransition: 'plain',
          icon: _icon,
          hideAfter: _hideAfter,
          position: 'top-right',
          stack: 3,
          loader: true,
          loaderBg: '#b50505',
        });
        return false;
    }
</script>
<!-- Custom Script Ends here -->
@endsection