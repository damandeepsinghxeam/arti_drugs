@extends('admins.layouts.app')

@section('content')
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">
<link rel="stylesheet" href="{!! asset('public/admin_assets/plugins/jquery-toast/jquery.toast.min.css') !!}">
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1> Edit Lead </h1>
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
            <form id="create-lead-form" class="form-vertical" action="{{ route('leads-management.update', $lead->id) }}" method="POST" enctype="multipart/form-data">
              @include('admins.validation_errors')

              @method('PATCH')
              @csrf()

              <div class="box-body">
              @php
                $fileAbsolutePath = \Config::get('constants.uploadPaths.leadDocuments');
                $filePath = asset('public') . \Config::get('constants.uploadPaths.leadDocumentPath');
                
                $leadCommentsDir = \Config::get('constants.uploadPaths.leadComments');
                $commentsZFilePath = \Config::get('constants.uploadPaths.leadCommentPath');
              @endphp
                <div class="row">
                  <div class="col-md-12">
                    <div class="col-sm-6 form-group">
                      <div id="drop_file_zone">
                        @if(!empty($lead->file_name) && file_exists($fileAbsolutePath . $lead->file_name))
                          <label class="control-label p-10-percent">
                            <a href="{!! $filePath . $lead->file_name !!}" class="btn btn-info btn-xs" target="_blank">
                              <i class="fa fa-download"></i>
                            </a>
                            <a href="{!! $filePath . $lead->file_name !!}" class="a-font-inherit" target="_blank">
                              {!! $lead->file_name !!}
                            </a>
                          </label>
                          <input type="hidden" name="file_name" value="{!! $lead->file_name !!}">
                          <input type="hidden" name="skip_file_name" value="1">
                        @else
                            <div id="drag_upload_file">
                              <p>
                                <input type="file" id="selectfile" name="file_name" class="file_or_fields" accept="image/*,.doc,.docx,application/pdf,application/vnd.ms-excel,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document">
                              </p>
                            </div>
                        @endif
                      </div>
                    </div>

                    <div class="col-sm-6 form-group">
                      <div class="row m-b-xxs">
                        <div class="col-md-6">
                          <label class="businessType">
                            <input type="radio" id="business_type_govt" class="business_type_input" name="business_type" value="1" @if(old('business_type') == 1 || $lead->business_type == 1) checked @endif> Government Business
                          </label>
                        </div>
                        <div class="col-md-6">
                          <label class="businessType">
                            <input type="radio" id="business_type_non_govt" class="business_type_input" name="business_type" value="2" @if(old('business_type') == 2 || $lead->business_type == 2) checked @endif> Corporate Business
                          </label>
                        </div>
                        <div class="business_type_error_div col-md-12"></div>
                      </div>

                      <div class="row">
                        <div class="col-md-12 form-group">
                          <label class="control-label text-left">Sources: <small class="text-danger">*</small></label>

                          <select class="form-control sources" name="sources">
                            @foreach($leadSourceOptions as $srcKey => $srcVal)
                              @php
                                $sourceSelected = null;
                                if(old('sources') == $srcKey) {
                                  $sourceSelected = 'selected';
                                } else if(empty(old('sources')) && $lead->source_id == $srcKey) {
                                  $sourceSelected = 'selected';
                                }
                              @endphp
                              <option value="{{ $srcKey }}" {!! $sourceSelected !!}>{{ $srcVal }}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>

                      <div class="row source_div @if($lead->source_id != 4) hide @endif">
                        <div class="col-md-12 form-group">
                          <textarea name="other_sources" id="other_sources" class="form-control" cols="30" rows="2" placeholder="Please enter the other sources.">{!! $lead->other_sources !!}</textarea>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-12">
                    <div class="col-md-6 form-group">
                      <label class="control-label text-left">Name of Prospect:</label>

                      @php 
                        $nameOfProspect = old('name_of_prospect') ?? $lead->name_of_prospect; 
                      @endphp
                      <input type="text" class="name_of_prospect form-control file_or_fields" name="name_of_prospect" placeholder="Name Of Prospect" value="{!! $nameOfProspect !!}">
                    </div>
                    <div class="col-md-6 form-group">
                      <label class="control-label text-left">Address Location:</label>
                      @php 
                        $addressLocation = old('address_location') ?? $lead->address_location; 
                      @endphp
                      <input type="text" class="address_location form-control file_or_fields" name="address_location" placeholder="Address Location" value="{!! $addressLocation !!}">
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-sm-12">
                    <div class="col-md-6 form-group">
                      <label class="control-label text-left">Contact Person Name:</label>

                      @php 
                        $contactPersonName = old('contact_person_name') ?? $lead->contact_person_name; 
                      @endphp
                      <input type="text" class="lead_contact_person_name form-control file_or_fields" name="contact_person_name" placeholder="Contact Person Name" value="{!! $contactPersonName !!}">
                    </div>
                    <div class="col-md-6 form-group">
                      <label class="control-label text-left">Contact Person Email:</label>

                      @php 
                        $contactPersonEmail = old('contact_person_email') ?? $lead->email; 
                      @endphp
                      <input type="text" class="lead_contact_person_email form-control file_or_fields" name="contact_person_email" placeholder="Contact Person Email" value="{!! $contactPersonEmail !!}">
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-sm-12">
                    <div class="col-md-6 form-group">
                      <label class="control-label text-left">Contact Person Mobile Number:</label>

                      @php 
                        $contactPersonMobile = old('contact_person_mobile') ?? $lead->contact_person_no; 
                      @endphp
                      <input type="text" class="lead_contact_person_mobile form-control file_or_fields" name="contact_person_mobile" placeholder="Contact Person Mobile Number" value="{!! $contactPersonMobile !!}">
                    </div>
                    <div class="col-md-6 form-group">
                      <label class="control-label text-left">Contact Person Alternate Mobile Number:</label>

                      @php 
                        $alternateContactNo = old('contact_person_alternate') ?? $lead->alternate_contact_no; 
                      @endphp
                      <input type="text" class="lead_contact_person_alternate form-control file_or_fields" name="contact_person_alternate" value="{!! $alternateContactNo !!}" placeholder="Contact Person Alternate Mobile Number">
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-sm-12">
                    <div class="col-md-6 form-group">
                      <label class="control-label text-left">Industries:</label>

                      <select class="form-control industry file_or_fields select2" name="industry_id">
                        @foreach($leadIndustryOptions as $indKey => $indVal)
                          @php
                            $indSelected = null;
                            if(old('industry_id') == $indKey) {
                              $indSelected = 'selected';
                            } else if(empty(old('industry_id')) && $lead->industry_id == $indKey) {
                              $indSelected = 'selected';
                            }
                          @endphp
                          <option value="{{ $indKey }}" {!! $indSelected !!}>{{ $indVal }}</option>
                        @endforeach
                      </select>
                    </div>

                    <div class="form-group col-md-6">
                      <label class="control-label text-left">Services Required :</label>
                      <div class="">
                        @php
                          $leadServices = $lead->service_required;
                          if(!empty(old('service_required'))) {
                            $leadServices = old('service_required');
                          }
                        @endphp

                        <input type="text" name="service_required" id="service_required" class="service_required form-control" placeholder="Please enter services required" value="{!! $leadServices !!}">

                        <input type="hidden" name="is_completed" value="0">
                      </div>
                    </div>

                  </div>
                </div>

                <div class="row">
                  <div class="col-md-12">
                    @php
                      $industryId = old('industry_id') ?? $lead->industry_id;
                    @endphp
                    <div class="col-md-6">
                      <div class="other_industries_div @if($industryId != 33) hide @endif">
                        <div class="form-group">
                          <label class="control-label text-left">Other Industries:</label>
                          <input type="text" name="other_industry" id="other_industry" class="other_industry form-control" placeholder="Please enter other industry" value="{!! $lead->other_industry !!}">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label text-left">
                          Due Date: <small>(for meeting, pre-bid, tender,...etc.)</small>
                        </label>
                        @php
                          $dueDate = old('due_date') ?? $lead->due_date;

                          if(!empty($dueDate) && $dueDate != '0000-00-00 00:00:00') {
                            $dueDate = date('m/d/Y h:i A', strtotime($dueDate));
                          } else {
                            $dueDate = null;
                          }
                        @endphp
                        <input type="text" name="due_date" id="due_date" class="due_date form-control future_date_time" placeholder="Please select due date" value="{!! $dueDate !!}" required>
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="form-group priority_div">
                        <label class="control-label text-left">Priority: <small class="text-danger">*</small></label>
                        <select class="form-control priority" name="priority">
                          <option value="">-Select Priority</option>
                          <option value="0" @if($lead->priority == 0) selected @endif>Low</option>
                          <option value="1" @if($lead->priority == 1) selected @endif>Normal</option>
                          <option value="2" @if($lead->priority == 2) selected @endif>Critical</option>
                        </select>
                      </div>
                    </div>

                  </div>
                </div>

                <div class="row">
                  <div class="col-sm-12">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="control-label text-left">Service Description: <small class="text-danger">*</small></label>

                        @php 
                          $serviceDescription = old('service_description') ?? $lead->service_description; 
                        @endphp
                        <textarea name="service_description" id="service_description" class="form-control" cols="30" rows="2" placeholder="Please enter the description about services like service out sourced, current vendor etc.">{!! $serviceDescription !!}</textarea>
                      </div>
                    </div>                    
                  </div>
                </div>
                
                <div class="row">
                  <div class="col-md-12">
                    <div class="col-md-12">

                      <fieldset>
                        <legend>&nbsp;</legend>
                        <div class="col-md-12 table-responsive no-padding">
                          <table id="input-form-table" class="table table-bordered table-striped travel-table-inner" style="height:150px;">

                            <tbody id="input-form-table-body">
                              <tr>
                                <td>
                                  <div class="form-group">
                                    <label for="comments" class="control-label">Comments:</label>
                                    <div class="three-icon-box display-inline-block">
                                      @if(!$lead->comments->isEmpty() && $lead->comments->count() > 0)
                                        <div class="info-tooltip cursor-pointer get-comments" data-lead_id="{!! $lead->id !!}">
                                          <a href="javascript:void(0)">
                                            <small>
                                              View ({{ $lead->comments->count() }}) Comments
                                            </small>
                                          </a>
                                          <span class="info-tooltiptext">Click here to see previous comments.</span>
                                        </div>
                                      @else
                                        <small>No Previous Comments Found.</small>
                                      @endif
                                    </div>

                                    <div class="">
                                      <textarea name="comments" id="comments" cols="30" rows="4" class="form-control"></textarea>
                                    </div>
                                  </div>
                                </td>
                              </tr>

                              <tr>
                                <td>
                                  <div class="form-group">
                                    <label for="comments" class="control-label">Attachment:</label>
                                    
                                    <div class="">
                                      <input type="file" id="attachment" name="attachment" class="attachment" accept="image/*,.doc,.docx,application/pdf,application/vnd.ms-excel,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document">
                                    </div>
                                  </div>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </fieldset>                      
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <div class="col-md-12">
                  <button type="submit" class="btn btn-primary form-submit-btn">Save as draft</button>                
                  <button type="submit" class="btn btn-success m-l-10 complete-btn">Complete</button>
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
<script src="{!!asset('public/admin_assets/plugins/sweetalert/sweetalert.min.js')!!}"></script>
<script src="{!!asset('public/admin_assets/plugins/validations/jquery.validate.js')!!}"></script>
<script src="{!!asset('public/admin_assets/plugins/validations/additional-methods.js')!!}"></script>
<script src="{!!asset('public/admin_assets/plugins/jquery-toast/jquery.toast.min.js')!!}"></script>

<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>

<script type="text/javascript">
$(document).ready(function() {
  var leadCreateDate = '{!! $lead->created_at->format('m/d/Y') !!}';

  $(document).on('click', '.get-comments', function(event) {
    event.preventDefault();  event.stopPropagation();
    getComments($(this));
  });

  $(document).on('click', '.form-submit-btn', function(event) {
    
    $("form").validate().settings.ignore = "*";

    $('textarea#comments').removeAttr('required');
  });

  $(document).on('click', '.complete-btn', function(event) {
    event.preventDefault();  event.stopPropagation();

    $("form").validate().settings.ignore = ":hidden";

    $('textarea#comments').attr('required', true);

    if($('#create-lead-form').valid()) {
      swal({
        closeOnClickOutside: false,
        closeOnEsc: false,
        title: "Are you sure?",
        text: "You are about to complete this lead. You will not be able to edit this once you marked it complete.",
        icon: "warning",
        buttons: {
          'cancel': {
            text: "Cancel",
            value: null,
            visible: true,
            className: "btn btn-danger",
            closeModal: true,
          },
          'confirm': {
            text: "Confirm",
            value: true,
            visible: true,
            className: "btn btn-success",
            closeModal: true
          }
        },
      }).then(function(isConfirm) {
        if (isConfirm) {
          $('input[name="is_completed"]').val(1);
          $('#create-lead-form').submit();
        }
      });
    }
  });

  $('#create-lead-form').validate({
    ignore: ':hidden, input[type=hidden], .select2-search__field', //  [type="search"]
    errorElement: 'span',
    // debug: true,
    // the errorPlacement has to take the table layout into account
    errorPlacement: function(error, element) {
      if (element.is(":radio"))
        error.appendTo(element.parents().eq(2).find('.business_type_error_div'));        
      else if (element.is(":checkbox"))
        error.appendTo(element.next());
      else if ($(element).attr('name') == 'file_name')
        error.appendTo(element.parent().parent().parent().parent());
      else
        error.appendTo(element.parent());
    },
    @if(!empty($lead->file_name) && file_exists($fileAbsolutePath . $lead->file_name))
      rules: {
        sources: {required: true},
        other_sources: {
          required: function(element) {
            return $('select.sources').val() == 4;
          }
        },
        contact_person_email: { email:true },
        contact_person_mobile: { number: true, minlength: 10, maxlength:10},
        contact_person_alternate: { number: true, minlength: 10, maxlength:10},
        service_required: { required: true },
        service_description: { required: true },
        due_date:{ date: true },
        priority:{ required: true },

        attachment: {
          accept: "image/*,.doc,.docx,application/pdf,application/vnd.ms-excel,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document",
          maxsize: 5242880,
        },
      },
      messages: {
        contact_person_email: {
          email : 'Please enter a valid email address like abc@example.com.'
        },
        attachment: {
          accept: "File Type must be in image,doc,pdf etc.",
          maxsize: "File size must not exceed "+ bytesToSize(5242880) +"."
        },
      }
    @else
      rules: {
        file_name: {
          require_from_group: [1, ".file_or_fields"],
          accept: "image/*,.doc,.docx,application/pdf,application/vnd.ms-excel,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document",
          maxsize: 5242880,
        },
        sources: { required: true, },
        other_sources: {
          required: function(element) {
            return $('select.sources').val() == 4;
          }
        },
        name_of_prospect:{require_from_group:[1, ".file_or_fields"],required: isFileNamePresent},
        address_location:{require_from_group:[1, ".file_or_fields"],required: isFileNamePresent},
        industry_id:{require_from_group: [1, ".file_or_fields"],required: isFileNamePresent},
        unit_id:{require_from_group: [1, ".file_or_fields"],required: isFileNamePresent},
        contact_person_name:{require_from_group: [1, ".file_or_fields"],required: isFileNamePresent},
        contact_person_email: {
          require_from_group:[1, ".file_or_fields"], required: isFileNamePresent, email:true 
        },
        contact_person_mobile: {
          require_from_group: [1, ".file_or_fields"], required: isFileNamePresent, number: true, minlength: 10
        },
        contact_person_alternate: {
          require_from_group: [1, ".file_or_fields"], required: isFileNamePresent, number: true, minlength: 10
        },
        service_required: { required: true },
        service_description: { required: true },
        due_date:{ date: true },
        priority:{ required: true },

        attachment: {
          accept: "image/*,.doc,.docx,application/pdf,application/vnd.ms-excel,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document",
          maxsize: 5242880,
        },
      },
      messages: {
        file_name: {
          accept: "File Type must be in image,doc,pdf etc.",
          maxsize: "File size must not exceed "+ bytesToSize(5242880) +"."
        },
        contact_person_email: {
          email : 'Please enter a valid email address like abc@example.com.'
        },
        attachment: {
          accept: "File Type must be in image,doc,pdf etc.",
          maxsize: "File size must not exceed "+ bytesToSize(5242880) +"."
        },
      }
    @endif
  });

  $('input.business_type_input').each(function(k, v) {
    $(this).rules('add', {
      // required: true
      require_from_group: [1, '.business_type_input'],
      messages: {
        require_from_group: "Please fill at least 1 of these fields i.e. Government & Corporate Business."
      }
    });
  });

  $(document).on('change', 'select[name="sources"]', function(event) {
    var sources_val = $(this).val();
    if(sources_val == 4) {
      $('.source_div').removeClass('hide');
    } else {
      $('.source_div').addClass('hide');
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
    minDate : new Date(leadCreateDate),
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
  if($('input[name="file_name"]').length && $('input[name="file_name"]').val().length > 0) {
    return_val = false;
  }
  return return_val;
}

function nl2br(str, is_xhtml) {
    var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br/>' : '<br>';    
    return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1'+ breakTag +'$2');
}

function getComments(obj) 
{
  var lead_id = $(obj).data('lead_id');
  var _token  = '{!! csrf_token() !!}';
  var objdata = {'_token': _token, 'id': lead_id};

  $.ajax({
    url: "{!! route('leads-management.get-comments') !!}",
    type: "GET",
    data: objdata,
    dataType: 'json',
    success: function (res) {
      if(res.status == 1) {
        // swal("Done!", res.msg, "success");
        if(typeof res != 'undefined' && res != '') {
          var commentsHtml = '';
          var leadCommentDir = res.dir_path;

          if(typeof res.data != 'undefined' && res.data != '') {
            $(res.data).each(function(k, v) {
              commentsHtml += '<li>'+
                                '<i class="fa fa-envelope bg-blue"></i>'+
                                '<div class="timeline-item">'+
                                  '<h5 class="timeline-header">'+
                                    '<span class="leaveMessageList">'+
                                      '<strong class="text-success">Send by:</strong> '+ v.user_employee.fullname +
                                    '</span>'+
                                    '<span class="leaveMessageList pull-right">'+
                                      '<strong class="text-success">Created at:</strong> '+ moment(v.created_at).format('D/M/Y h:mm a') +
                                    '</span>'+
                                  '</h5>'+
                                  '<div class="timeline-body">'+ 
                                    '<div class="row">'+
                                      '<div class="col-md-10">'+
                                        '<p>'+ nl2br(v.comments) +'</p>'+
                                      '</div>'+
                                      '<div class="col-md-2">';
                                        if(v.attachment) {
              commentsHtml +=             '<a href="'+ leadCommentDir + v.attachment +'" target="_blank" class="btn btn-success btn-xs">'+
                                            '<i class="fa fa-paperclip"></i>'+
                                          '</a>';
                                        } else {
              commentsHtml +=             '--';
                                        }
              commentsHtml +=          '</div>'+
                                    '</div>'+
                                  '</div>'+
                                '</div>'+
                              '</li>';
            });
            commentsHtml += '<li>'+
                              '<i class="fa fa-clock-o bg-gray"></i>'+
                            '</li>';

            $('.commentshtml').html(commentsHtml);
            setTimeout(function() {
              $('.comments-modal').modal('show');
            }, 300);
          } else {
            $.toast({
              heading: 'Error',
              text: 'No prevoius comments were found.',
              showHideTransition: 'plain',
              icon: 'error',
              hideAfter: 3000,
              position: 'top-right', 
              stack: 3, 
              loader: true,
              loaderBg: '#b50505',
            });
            return false;
          }
          
        }
      } else {
        $.toast({
          heading: 'Error',
          text: res.msg,
          showHideTransition: 'plain',
          icon: 'error',
          hideAfter: 3000,
          position: 'top-right', 
          stack: 3, 
          loader: true,
          loaderBg: '#b50505',
        });
        return false;
      }
    },
    error: function (xhr, ajaxOptions, thrownError) {
      swal("Error Code:", 'Internal server error.', "error");
    }
  });
}
</script>
@endsection