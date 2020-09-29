@extends('admins.layouts.app')

@section('content')
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">
<link rel="stylesheet" href="{!! asset('public/admin_assets/plugins/jquery-toast/jquery.toast.min.css') !!}">
<!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1> Create New Lead </h1>
      <ol class="breadcrumb">
        <li>
          <a href="{{ url('employees/dashboard') }}">
            <i class="fa fa-dashboard"></i> Home
          </a>
        </li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-sm-12">
           <div class="box box-primary">
             
             <!-- form start -->
              <form id="create-lead-form" class="form-vertical" action="{{ route('leads-management.store') }}" method="POST" enctype="multipart/form-data">
                @include('admins.validation_errors')

                {{ csrf_field() }}

                <div class="box-body">
                  
                  <div class="row">
                    <div class="col-md-12">
                      <div class="col-sm-6 form-group">
                        <div id="drop_file_zone">
                          <!-- ondrop="upload_file(event)" ondragover="return false" -->
                          <div id="drag_upload_file">
                            <p>
                              <input type="file" id="selectfile" name="file_name" class="file_or_fields" accept="image/*,.doc,.docx,application/pdf,application/vnd.ms-excel,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document">
                            </p>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-6 form-group">

                        <div class="row row m-b-xxs">
                          <div class="col-md-6">
                            <label class="businessType">
                              <input type="radio" id="business_type_govt" class="business_type_input" name="business_type" value="1" @if(empty(old('business_type')) || old('business_type') == 1) checked @endif> Government Business
                            </label>
                          </div>
                          <div class="col-md-6">
                            <label class="businessType">
                              <input type="radio" id="business_type_non_govt" class="business_type_input" name="business_type" value="2" @if(old('business_type') == 2) checked @endif> Corporate Business
                            </label>
                          </div>
                          <div class="business_type_error_div col-md-12"></div>
                        </div>
                        <!-- <label class="businessType">
                          <input type="radio" id="business_type_intetnation" class="business_type_input" name="business_type" value="3" @ if(old('business_type') == 3) checked @ endif> International Business
                        </label> -->
                        <div class="row">
                          <div class="col-md-12 form-group">
                            <label class="control-label text-left">Sources: <small class="text-danger">*</small></label>

                            <select class="form-control sources" name="sources">
                              @foreach($leadSourceOptions as $srcKey => $srcVal)
                                @php
                                  $srcSelected = null;
                                  if(old('sources') == $srcKey) {
                                    $srcSelected = 'selected';
                                  }
                                @endphp
                                <option value="{{ $srcKey }}" {!! $srcSelected !!}>{{ $srcVal }}</option>
                              @endforeach
                            </select>
                          </div>
                        </div>

                        <div class="row source_div hide">
                          <div class="col-md-12 form-group">
                            <textarea name="other_sources" id="other_sources" class="form-control" cols="30" rows="2" placeholder="Please enter the other sources.">{!! old('other_sources') !!}</textarea>
                          </div>
                        </div>

                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-12">
                      <div class="col-md-6 form-group"><!-- nameOfProspect -->
                        <label class="control-label text-left">Name of Prospect:</label>

                        <input type="text" class="name_of_prospect form-control file_or_fields" name="name_of_prospect" placeholder="Name Of Prospect" value="{!! old('name_of_prospect') !!}">
                      </div>
                      <div class="col-md-6 form-group"><!-- addressLocation -->
                        <label class="control-label text-left">Address Location:</label>

                        <input type="text" class="address_location form-control file_or_fields" name="address_location" placeholder="Address Location" value="{!! old('address_location') !!}">
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-sm-12">
                      <div class="col-md-6 form-group"><!-- contactPersonName -->
                        <label class="control-label text-left">Contact Person Name:</label>

                        <input type="text" class="lead_contact_person_name form-control file_or_fields" name="contact_person_name" placeholder="Contact Person Name" value="{!! old('contact_person_name') !!}">
                      </div>
                      <div class="col-md-6 form-group"><!-- contactPersonEmail -->
                        <label class="control-label text-left">Contact Person Email:</label>

                        <input type="text" class="lead_contact_person_email form-control file_or_fields" name="contact_person_email" placeholder="Contact Person Email" value="{!! old('contact_person_email') !!}">
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-sm-12">
                      <div class="col-md-6 form-group"><!-- contactPersonMobile -->
                        <label class="control-label text-left">Contact Person Mobile Number:</label>

                        <input type="text" class="lead_contact_person_mobile form-control file_or_fields" name="contact_person_mobile" placeholder="Contact Person Mobile Number" value="{!! old('contact_person_mobile') !!}">
                      </div>
                      <div class="col-md-6 form-group"><!-- contactPersonAlternateMobile -->
                        <label class="control-label text-left">Contact Person Alternate Mobile Number:</label>

                        <input type="text" class="lead_contact_person_alternate form-control file_or_fields" name="contact_person_alternate" value="{!! old('contact_person_alternate') !!}" placeholder="Contact Person Alternate Mobile Number">
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-sm-12">
                      <div class="form-group col-md-6"><!-- .industryLead -->
                        <label class="control-label text-left">Industries:</label>
                        <select class="form-control industry file_or_fields select2" name="industry_id">
                          @foreach($leadIndustryOptions as $indKey => $indVal)
                            @php
                              $indSelected = null;
                              if(old('industry_id') == $indKey) {
                                $indSelected = 'selected';
                              }
                            @endphp
                            
                            <option value="{{ $indKey }}" {!! $indSelected !!} >{{ $indVal }}</option>
                          @endforeach
                        </select>
                      </div>

                      <div class="form-group col-md-6"> <!-- .servicesRequired -->
                        <label class="control-label text-left">Services Required :</label>
                        <div class="">
                          @php
                            $leadServices = old('service_required');
                          @endphp
                          <input type="text" name="service_required" id="service_required" class="service_required form-control" placeholder="Please enter services required" value="{!! $leadServices !!}">
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-sm-12">
                      <div class="col-md-6">
                        <div class="other_industries_div @if(old('industry_id') != 33) hide @endif">
                          <div class="form-group">
                            <label class="control-label text-left">Other Industries:</label>
                            <input type="text" name="other_industry" id="other_industry" class="other_industry form-control" placeholder="Please enter other industry" value="{!! old('other_industry') !!}">
                          </div>
                        </div>

                        <div class="due_date_div">
                          <div class="form-group">
                            <label class="control-label text-left">
                              Due Date: <small>(for meeting, pre-bid, tender,...etc.)</small>
                            </label>
                            @php
                              $dueDate = old('due_date');

                              if(!empty($dueDate) && $dueDate != '0000-00-00 00:00:00') {
                                $dueDate = date('m/d/Y h:i A', strtotime($dueDate));
                              } else {
                                $dueDate = null;
                              }
                            @endphp
                            <input type="text" name="due_date" id="due_date" class="due_date form-control future_date_time" placeholder="Please select due date" value="{!! $dueDate !!}">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="control-label text-left">Service Description: <small class="text-danger">*</small></label>

                          <textarea name="service_description" id="service_description" class="form-control" cols="30" rows="6" placeholder="Please enter the description about services like service out sourced, current vendor etc.">{!! old('service_description') !!}</textarea>
                        </div>
                      </div>
                    </div>
                  </div>
  
                  <!-- <div class="row">
                    <div class="col-sm-12">
                      <div class="form-group"> .leadOutsource
                        <label>Already Outsourced ? </label>
                        <label><input type="Radio" class="leadAlreadyOutsourced" name="leadAlreadyOutsourced" value="1" checked><span class="fontNormalWeight">No</span></label>
                        <label><input type="Radio" class="leadAlreadyOutsourced" name="leadAlreadyOutsourced"><span class="fontNormalWeight">Yes</span></label>
                      </div>
                    </div>
                  </div> -->

                 <!--  <div class="col-sm-12">
                   <div class="leadCruurentVendor">
                     <div class="col-md-6 vendorLead">
                       <label class="col-sm-3 vendor" for="currentVendor">Current Vendor : </label>
                       <input type="text" name="currentVendor" class="col-sm-9 currentVendor" placeholder="Please Enter Vendor Name">
                     </div>
                     <div class="col-md-6 serviceCharge">
                       <label for="currentServiceCharge" class="col-sm-4 service">Current Service Charge : </label>
                       <select class="col-sm-8 currentServiceCharge" name="currentServiceCharge">
                         <option value="">Please Select Service Charge.</option>
                         <option value="0">5%</option> 
                         <option value="0">10%</option>    
                        </select>
                     </div>
                   </div>
                 </div> -->

                 <!--  <div class="col-sm-12">
                   <div class="col-md-6 leadOutsource">
                     <label for="currentStrength" class="col-sm-3 strength">Current Strength : </label>
                     <input type="text" name="currentStrength" class="col-sm-9 currentStrength" placeholder="Please Enter Current Strength">
                   </div>
                   <div class="col-md-6 leadOutsourceAttached">
                     <label for="leadFileAttachment">Attachments : </label>
                     <input type="file" name="leadFileAttachment" class="leadFileAttachment">
                   </div>
                 </div> -->
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                  <div class="col-md-12">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a href="{!! route('leads-management.index') !!}" class="btn btn-default m-l-10">Back</a>
                  </div>
                </div>
              </form>
              <!-- Main row -->
           </div>
         </div>
      </div>
    </section>

  </div>
@endsection

@section('script')
<script src="{{asset('public/admin_assets/plugins/validations/jquery.validate.js')}}"></script>
<script src="{{asset('public/admin_assets/plugins/validations/additional-methods.js')}}"></script>
<script src="{!!asset('public/admin_assets/plugins/jquery-toast/jquery.toast.min.js')!!}"></script>

<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>

<script type="text/javascript">
$(document).ready(function() {

  $('#create-lead-form').validate({
    ignore: ':hidden, input[type=hidden], .select2-search__field', //  [type="search"]
    errorElement: 'span',
    errorPlacement: function(error, element) {
      if (element.is(":radio"))
        error.appendTo(element.parents().eq(2).find('.business_type_error_div'));
      else if (element.is(":checkbox"))
        error.appendTo(element.next());
      else if ($(element).attr('name') == 'file_name')
        error.appendTo(element.parent().parent().parent().parent());
      else
        error.appendTo(element.parent()); // element.parent().next()
    },
    rules: {
      file_name: {
        accept: "image/*,.doc,.docx,application/pdf,application/vnd.ms-excel,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document",
        maxsize: 5242880,
      },
      sources: { required: true },
      other_sources: {
        required: function(element) {
          return $('select.sources').val() == 4;
        }
      },
      contact_person_email: { email:true },
      contact_person_mobile: { number: true, minlength: 10, maxlength:10},
      contact_person_alternate: { number: true, minlength: 10, maxlength:10},
      service_description: { required: true },
    },
    messages: {
      file_name: {
        accept: "File Type must be in image,doc,pdf etc.",
        maxsize: "File size must not exceed "+ bytesToSize(5242880) +"."
      },
      contact_person_email: {
        email : 'Please enter a valid email address like abc@example.com.'
      }
    }
  });

  $('input.business_type_input').each(function(k, v) {
    $(this).rules('add', {
      // required: true
      require_from_group: [1, '.business_type_input'],
      messages: {
        require_from_group: "Please fill at least 1 of these fields i.e. Government & Corporate Business"
      }
    });
  });

  $(document).on('change', 'select[name="sources"]', function(event) {
    var sources_val = $(this).val();
    if(sources_val == 4) {
      $('.source_div').removeClass('hide');
    } else {
      $('.source_div').addClass('hide');
      $('#other_sources').val('');
    }
  });

  $(document).on('change', 'select[name="industry_id"]', function(event) {
    var industry_val = $(this).val();
    if(industry_val == 33) {
      $('.other_industries_div').removeClass('hide');
      $('#other_industry').attr('required', true);
    } else {
      $('.other_industries_div').addClass('hide');
      $('#other_industry').val('');
      $('#other_industry').removeAttr('required');
    }
  });

  $(".future_date_time").datetimepicker({
    minDate : new Date(),
    format: 'MM/DD/Y hh:mm A',
  });
});

function bytesToSize(bytes) {
   var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
   if (bytes == 0) return '0 Byte';
   var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
   return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
}

function isFileNamePresent() {
  var return_val = true;
  if($('input[name="file_name"]').val().length > 0) {
    return_val = false;
  }
  return return_val;
}
</script>
@endsection