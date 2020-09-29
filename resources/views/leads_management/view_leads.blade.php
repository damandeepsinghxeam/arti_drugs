@extends('admins.layouts.app')

@section('content')
  <link rel="stylesheet" href="{!! asset('public/admin_assets/plugins/jquery-toast/jquery.toast.min.css') !!}">
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>Lead: {{$lead->lead_code}}</h1>
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
          @include('admins.validation_errors')          
          <div class="box-body">            
            <div class="row">
              <div class="col-md-12">
                @php 
                  $fileAbsolutePath = \Config::get('constants.uploadPaths.leadDocuments');
                  $filePath = asset('public') . \Config::get('constants.uploadPaths.leadDocumentPath');

                  $businessTypeArr = [1 => 'Government', 2 => 'Corporate'];
                  // , 3 => 'International Business'
                @endphp
                @if(!empty($lead->file_name) && file_exists($fileAbsolutePath . $lead->file_name))
                  <div class="col-sm-4 form-group">
                    <label class="control-label col-md-12">Document Submitted:</label>
                    <div class="col-md-12">
                      <a  href="{!! $filePath . $lead->file_name !!}" class="btn btn-success btn-xs">
                        <i class="fa fa-download"></i>
                        Attachment
                      </a>
                    </div>
                  </div>
                @endif
                <div class="col-sm-4 form-group">
                  <label class="col-md-12 businessType1">Business Type:</label>
                  <div class="col-md-12">
                    {!! $businessTypeArr[$lead->business_type] ?? '--' !!}
                  </div>
                </div>

                <div class="form-group col-md-4">
                  <label class="control-label col-md-12">Source:</label>
                  <div class="col-md-12">
                    @php
                      unset($leadSourceOptions['']);
                    @endphp
                    {!! $leadSourceOptions[$lead->source_id] ?? '--' !!}
                  </div>
                  @if($lead->source_id == 4)
                    <br>
                    <div class="col-md-12">
                      {!! nl2br($lead->other_sources) !!}
                    </div>
                  @endif
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                <div class="form-group col-md-4">
                  <label class="control-label col-md-12">Name of Prospect:</label>
                  <div class="col-md-12">
                    {!! $lead->name_of_prospect ?? '--' !!}
                  </div>
                </div>
                
                <div class="col-md-4 form-group">
                  <label class="contorl-label col-md-12">Address/Location:</label>
                  <div class="col-md-12">
                    {!! $lead->address_location ?? '--' !!}
                  </div>
                </div>
                
                <div class="col-md-4 form-group">
                  <label class="control-label col-md-12">Industry:</label>
                  <div class="col-md-12">
                    @php
                      unset($leadIndustryOptions['']);
                    @endphp
                    {!! $leadIndustryOptions[$lead->industry_id] ?? '--' !!}
                  </div>
                  @if($lead->industry_id == 3)
                    <br>
                    <div class="col-md-12">
                      {!! nl2br($lead->other_industry) !!}
                    </div>
                  @endif
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">

                <div class="col-md-4 form-group">
                  <label class="control-label col-md-12">Contact Person Name:</label>
                  <div class="col-md-12">
                    {!! $lead->contact_person_name ?? '--' !!}
                  </div>
                </div>

                <div class="col-md-4 form-group">
                  <label class="control-label col-md-12">Contact Person Email:</label>
                  <div class="col-md-12">
                    {!! $lead->email ?? '--' !!}
                  </div>
                </div>

                <div class="col-md-4 form-group">
                  <label class="control-label col-md-12">Contact Person Mobile Number:</label>
                  <div class="col-md-12">
                    {!! $lead->contact_person_no ?? '--' !!}
                  </div>
                </div>

              </div>
            </div>

            <div class="row">
              <div class="col-sm-12">
                
                <div class="col-md-4 form-group">
                  <label class="control-label col-md-12">Contact Person Alternate Number:</label>
                  <div class="col-md-12">
                    {!! $lead->alternate_contact_no ?? '--' !!}
                  </div>
                </div>

                <div class="col-md-4 form-group">
                  <label class="control-label col-md-12">Services Required:</label>
                  <div class="col-md-12">
                    @if(!empty($lead->service_required))
                      {!! $lead->service_required !!}
                    @else
                      --
                    @endif
                  </div>
                </div>

                <div class="form-group col-md-4">
                  <label class="control-label col-md-12">Service Discription:</label>
                  <div class="col-md-12">
                    {!! nl2br($lead->service_description) !!}
                  </div>
                </div>
                
              </div>
            </div>

            <div class="row">
              <div class="col-sm-12">

                <div class="col-md-4 form-group">
                  <label class="control-label col-md-12">Due Date:</label>
                  <div class="col-md-12" title="date time is in (m/d/Y h:i A) format.">
                    @php
                      $dueDate = null;
                      if(!empty($lead->due_date) && $lead->due_date != '0000-00-00 00:00:00') {
                        $dueDate = date('m/d/Y h:i A', strtotime($lead->due_date));
                      }
                    @endphp
                    {!! $dueDate ?? '--' !!}
                  </div>
                </div>

                <div class="col-md-4 form-group">
                  <label class="control-label col-md-12">Priority:</label>
                  <div class="col-md-12">
                    @php
                      $priorityArr = [0=> 'Low', 1=> 'Normal', 2=> 'Critical'];
                      $priority = $priorityArr[$lead->priority];
                    @endphp

                    @if($lead->priority == 2)
                      <span class="label label-danger">{!! $priority !!}</span>
                    @elseif($lead->priority == 1)
                      <span class="label label-warning">{!! $priority !!}</span>
                    @else
                      <span class="label label-info">{!! $priority !!}</span>
                    @endif
                  </div>
                </div>
              </div>
            </div>
            @php
              //1=> New, 2=> Open, 3=> Complete, 4=> Rejected by Hod, 5=> Closed, 6=> Abandoned,
              $statusArr = [
                1 => 'New', 2 => 'Open',
                3 => 'Complete', 4 => 'Rejected by Hod',
                5 => 'Closed', 6 => 'Abandoned'
              ];
              $userId = $authUser->id;
            @endphp
            <!-- $authUser -->
            @if((auth()->user()->can('leads-management.lead-approval') && !empty($hodId) && $hodId == $userId && $lead->is_completed == 1 && $lead->status == 3))
              <form id="view-lead-form" class="form-vertical" action="{!! route('leads-management.lead-approval') !!}" method="POST">
                @csrf()
                  <div class="row">
                    <div class="col-sm-12">

                      <div class="form-group col-md-12">
                        <input type="hidden" name="lead_id" value="{!! $lead->id !!}">
                        <label class="control-label"> Comments: </label>

                        <div class="three-icon-box display-inline-block">
                          @if(!$lead->comments->isEmpty() && $lead->comments->count() > 0)
                            <div class="info-tooltip cursor-pointer get-comments" data-lead_id="{!! $lead->id !!}">
                              <a href="javascript:void(0)">
                                <small>View ({{ $lead->comments->count() }}) Comments</small>
                              </a>
                              <span class="info-tooltiptext">Click here to see previous comments.</span>
                            </div>
                          @else
                            <small>No Previous Comments Found.</small>
                          @endif
                        </div>

                        <div class="">                          
                          <textarea name="comments" id="comments" cols="30" rows="4" class="form-control" required></textarea>
                          <input type="hidden" name="status" value="0">
                          @if(!empty($hodId) && $lead->status == 3)
                            <input type="hidden" name="hod_id" value="{!! $hodId !!}">
                          @endif
                        </div><!-- /input-group -->
                      </div>
                    </div>
                  </div>
                  <!-- /.box-body -->
                  <div class="box-footer">
                    <div class="col-md-12">
                      <button type="submit" class="btn btn-danger reject-btn">Reject</button>
                      <button type="submit" class="btn btn-primary m-l-10 approve-btn">Approve</button>
                      <a href="{!! route('leads-management.index') !!}" class="btn btn-default m-l-10">Back</a>
                    </div>
                  </div>
              </form>
              @else 
              <div class="row">
                <div class="col-sm-12">
                  <div class="form-group col-md-12">
                    <div class="col-md-12">
                      <label class="control-label">Comments:</label>

                      <div class="three-icon-box display-inline-block">
                        @if(!$lead->comments->isEmpty() && $lead->comments->count() > 0)
                          <div class="info-tooltip cursor-pointer get-comments" data-lead_id="{!! $lead->id !!}">
                            <small>
                              <a href="javascript:void(0)">
                                View ({{ $lead->comments->count() }}) Comments
                              </a>
                            </small>
                            <span class="info-tooltiptext">Click here to see previous comments.</span>
                          </div>
                        @else
                          <small>No Previous Comments Found.</small>
                        @endif
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            @endif
          </div>
          <!-- /.box-body -->
          @if(!auth()->user()->can('leads-management.lead-approval') || (empty($hodId) || $hodId != $userId || $lead->is_completed != 1 || $lead->status != 3))
            <div class="box-footer">
              <div class="col-md-12">
                @if(!empty($bdMember) && $bdMember->user_id == $lead->executive_id && in_array($lead->status, [1, 2]))
                  <a href="{!! route('leads-management.edit', $lead->id) !!}" class="btn btn-success m-l-10">
                    Edit
                  </a>
                @endif
                  <a href="{!! route('leads-management.index') !!}" class="btn btn-default m-l-10">Back</a>
              </div>
            </div>
          @endif
          <!-- Main row -->
        </div>
      </div>
    </div>
  </section>
</div>
@endsection

@section('script')
<script src="{!! asset('public/admin_assets/plugins/sweetalert/sweetalert.min.js') !!}"></script>
<script src="{{asset('public/admin_assets/plugins/validations/jquery.validate.js')}}"></script>
<script src="{{asset('public/admin_assets/plugins/validations/additional-methods.js')}}"></script>
<script src="{!! asset('public/admin_assets/plugins/jquery-toast/jquery.toast.min.js') !!}"></script>

<script type="text/javascript">
$(document).ready(function() {

  $(document).on('click', '.get-comments', function(event) {
    event.preventDefault();  event.stopPropagation();
    getComments($(this));
  });

  $(document).on('click', '.reject-btn', function(event) {
    event.preventDefault();  event.stopPropagation();

    if($('#view-lead-form').valid()) {
      swal({
        closeOnClickOutside: false,
        closeOnEsc: false,

        title: "Are you sure?",
        text: "You want to reject this lead. You will not be able to edit this.",
        icon: "warning",
        /*buttons: [ 'Cancel', 'OK' ],*/
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
          $('input[name="status"]').val(4);              
          $('#view-lead-form').submit();
        }
      });
    }
  });

  $(document).on('click', '.approve-btn', function(event) {
    event.preventDefault();  event.stopPropagation();

    if($('#view-lead-form').valid()) {
      $('input[name="status"]').val(5);
      $('#view-lead-form').submit();
    }
  });

  $('#view-lead-form').validate({
    ignore: ':hidden, input[type=hidden], .select2-search__field', //  [type="search"]
    errorElement: 'span',
    // debug: true,
    // the errorPlacement has to take the table layout into account
    errorPlacement: function(error, element) {
      error.appendTo(element.parent()); // element.parent().next()
    },
    rules: {
      comments: { required: true, },
    },
  });  
});

function nl2br(str, is_xhtml) {
    var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br/>' : '<br>';    
    return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1'+ breakTag +'$2');
}

function getComments(obj) {

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
                                        '<strong class="text-success">Date/Time:</strong> '+ moment(v.created_at).format('D/M/Y h:mm a') +
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