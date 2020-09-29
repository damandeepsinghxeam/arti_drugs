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
input.slider_input {
    width: auto;
    display: inline-block;
}
.range-container {
    display: flex;
    align-items: center;
    margin-bottom: 5px;
}
span.display_span {
    background-color: #3c8dbc;
    padding: 6px 3px;
    color: white;
    margin-left: 10px;
    border-radius: 27px;
    text-align: center;
    width: 31px;
}
.input-group-addon, .input-group-btn {
    vertical-align: top;
}

/** code by webdevtrick ( https://webdevtrick.com ) **/
.main {
margin-left: 40%;
margin-top: 15%;
}
.rating-star {
    direction: rtl;
    font-size: 40px;
    unicode-bidi: bidi-override;
  /*  display: inline-block;*/
}
.rating-star input {
    opacity: 0;
    position: relative;
    left: -30px;
    z-index: 2;
    cursor: pointer;
}

.rating-star span.star:before {
    color: #777777;
}

.rating-star span.star {
    display: inline-block;
    font-family: FontAwesome;
    font-style: normal;
    font-weight: normal;
    position: relative;
    z-index: 1;
    font-size: 25px;
    margin-left: -26px;
}

.rating-star span {
    margin-left: -30px;
}
.rating-star span.star:before {
    color: #777777;
    content:"\f006";
}
.rating-star input:hover + span.star:before, .rating-star input:hover + span.star ~ span.star:before, .rating-star input:checked + span.star:before, .rating-star input:checked + span.star ~ span.star:before {
    color: #ffd100;
    content:"\f005";
}
 
.selected-rating{
    color: #ffd100;
    font-weight: bold;
    font-size: 42px;
}
</style>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>LEVEL: 02 (FUNCTION HOD INTERVIEW ROUND)</h1>
      <ol class="breadcrumb">
        <li><a href="{{url('employees/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{url('jrf/interview-list')}}">Interview List</a></li> 
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-sm-12">
          <div class="box box-primary">

              @if($errors->basic->any())
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
            <form id="jrf_function_hod_form" method="POST" action="{{url('jrf/save-level-two-screening-detail')}}" enctype="multipart/form-data">
              {{ csrf_field() }}
                <div class="box-body jrf-form-body">
                  <div class="row">
                      <div class="col-md-5">
                        <div class="input-group d_o_r">
                          <div class="input-group-btn">
                          <button type="button" class="btn btn-danger">Interview date</button>
                          </div>
                          <input type="text" class="form-control" name="interview_date" placeholder="02/03/2020" readonly="readonly" value="{{@$detail['basic']->interview_date}}">
                        </div>

                        <div class="input-group d_o_r">
                          <div class="input-group-btn">
                          <button type="button" class="btn btn-primary">Functional HOD's Name</button>
                          </div>
                          <input type="text" class="form-control" value="{{@$detail['hod']->employee->fullname}}" disabled>
                          <input type="hidden" name="level_two_id" value="{{@$detail['level_two']->id}}">
                        </div>
                        
                        <div class="input-group d_o_r">
                          <div class="input-group-btn">
                            <button type="button" class="btn btn-info">Department</button>
                          </div>
                            <input type="hidden" value="{{@$detail['hod']->employeeProfile->department->id}}" name="department_id">
                            <span class="form-control" disabled>{{@$detail['hod']->employeeProfile->department->name}}</span>
                        </div>

                        <div class="input-group d_o_r">
                          <div class="input-group-btn">
                            <button type="button" class="btn btn-warning">Designation</button>
                          </div>
                            <input type="hidden" class="form-control" value="{{@$detail['hod']->roles[0]->id}}" name="designation_id">
                            <span class="form-control" disabled>{{@$detail['hod']->roles[0]->name}}</span>
                        </div>

                        <!--<div class="input-group d_o_r">
                          <div class="input-group-btn">
                          <button type="button" class="btn btn-info">Location</button>
                        </div>
                          <input type="text" class="form-control" value="{{@$detail['hod']->employeeAddresses[0]->city->name}}" disabled>
                        </div> -->
                     </div>

                  <div class="col-md-7">
                    <div class="table-styling">
                      <table class="table table-striped table-responsive">
                          <tr>
                      <th>Candidate Name</th>
                        <td>
                          <input type="text" name="name" id="" value="{{@$detail['basic']->name}}" class="form-control basic-detail-input-style" placeholder="Candidate Name" readonly="readonly">
                          <input type="hidden" name="jrf_level_one_screening_id" value="{{@$detail['basic']->jrf_level_one_screening_id}}">
                          <input type="hidden" name="jrf_id" value="{{@$detail['basic']->jrf_id}}">
                          <input type="hidden" name="user_id" value="{{Auth::id()}}">
                          <input type="hidden" name="u_id" value="{{@$detail['basic']->user_id}}">
                        </td>
                    </tr>
                      <tr>
                        <th>Video Recording Seen<sup class="ast">*</sup></th>
                          <td>
                            <input type="radio" name="video_recording_seen" id="video_recording_yes" value="Yes">
                            <label for="video_recording_yes">Yes</label>&nbsp;&nbsp;
                            <input type="radio" name="video_recording_seen" id="video_recording_no" value="No">
                            <label for="video_recording_no">No</label>&nbsp;&nbsp;
                            
                          </td>
                      </tr>
                      <tr>
                        <th>Rating out of 10<sup class="ast">*</sup></th>
                          <td>
                              <span class="rating-star">
                              <?php for ($i=1; $i <= 10; $i++) { ?>
                              <input type="radio" name="rating" value="{{$i}}"><span class="star"></span>
                              <?php }?>
                              </span>
                          </td>
                      </tr>

                      <!-- <tr>
                        <th>Rating out of 10</th>
                        <td>
                          <div class="range-container">
                            <input class="slider_input" name="rating" type="range" value="8" min="0" max="10">
                          <span class="display_span"></span>  
                          </div>
                          <p>(Please adjust if other value)<p>
                        </td>
                      </tr> -->
                      
                        <tr>
                          <th>Interview remarks by HOD<sup class="ast">*</sup></th>
                            <td>
                              <textarea rows="4" cols="50" class="form-control" id="interview_remarks" name="interview_remarks" placeholder="Interview Remakrs here">{{@$detail['level_two']->interview_remarks}}</textarea>
                            </td>
                        </tr>
                        <tr>
                          <th>Management interaction required?<sup class="ast">*</sup></th>
                          <td>
                            <input type="radio" class="qualify_options" name="qualify" id="qualify_yes" value="Yes" onclick="hide_element();">
                            <label for="qualify_yes">Yes</label>&nbsp;&nbsp;
                            <input type="radio" class="qualify_options" name="qualify" id="qualify_no" value="No" onclick="hide_element();">
                            <label for="qualify_no" >No</label>
                          </td>
                        </tr>
                        <tr class="notice_period_field" id="next_level_id">
                          <th>Next level on phone<br>or F2F<sup class="ast">*</sup></th>
                          <td>
                            <input type="radio" name="level" id="nl_on_phone" value="On-Phone">
                            <label for="nl_on_phone">On Phone</label>&nbsp;&nbsp;
                            <input type="radio" name="level" id="nl_f2f_location" value="F2F-Location">
                            <label for="nl_f2f_location">F2F Location</label>&nbsp;&nbsp;
                            <input type="radio" name="level" id="nl_f2f_ho" value="F2F-HO">
                            <label for="nl_f2f_ho">F2F HO</label>
                          </td>
                        </tr>
                        <tr class="notice_period_field" id="interaction_date_with_mangement_id">
                          <th>Date of Interaction<br> with Management<sup class="ast">*</sup></th>
                          <td>
                            <input type="text" name="interaction_date" class="form-control datepicker" value="{{@$detail['level_two']->interaction_date}}" id="interaction_date" placeholder="12/03/2020">
                          </td>
                        </tr>
                        <tr id="test">
                          <th>Level 2 Status<sup class="ast">*</sup></th>
                          <td>
                            <input type="radio" name="final_result" id="rejected" value="Rejected">
                            <label for="rejected">Rejected</label>&nbsp;&nbsp;
                            <input type="radio" name="final_result" id="on_hold" value="On-hold">
                            <label for="on_hold">On hold</label>&nbsp;&nbsp;
                            <input type="radio" name="final_result" id="selected" value="Selected">
                            <label for="selected">Selected</label>
                          </td>
                        </tr>
                        <tr>
                          <th>Current Annual CTC (INR Lakhs)</th>
                          <td>
                            <input type="number" name="monthly_ctc" id="" value="{{@$detail['basic']->current_ctc}}" class="form-control basic-detail-input-style" readonly="readonly">
                          </td>
                        </tr>
                        <tr>
                          <th>Current Annual CIH (INR Lakhs)</th>
                            <td>
                              <input type="number" name="monthly_cih" id="" value="{{@$detail['basic']->current_cih}}" class="form-control basic-detail-input-style" readonly="readonly">
                            </td>
                        </tr>
                        <tr>
                          <th>Expected CTC (INR Lakhs)</th>
                            <td>
                              <input type="number" name="monthly_cih" id="" value="{{@$detail['basic']->exp_ctc}}" class="form-control basic-detail-input-style" readonly="readonly">
                            </td>
                        </tr>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            <!-- /.box-body -->
            <div class="box-footer text-center">
              <input type="submit" class="btn btn-primary submit-btn-style" id="submit2" value="Submit" name="submit">
            </div>
          </form>
        </div>
        </div>
          <!-- /.box -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<script src="{{asset('public/admin_assets/plugins/validations/jquery.validate.js')}}"></script>
<script src="{{asset('public/admin_assets/plugins/validations/additional-methods.js')}}"></script>
<script>
$("#jrf_function_hod_form").validate({
  rules: {
    "candidate_name" : {
      required: true
    },
    "rating" : {
      required: true
    },
    "video_recording_seen" : {
      required: true
    },
    "interview_remarks" : {
      required: true
    },
    "qualify" : {
      required : true
    },
    "level" : {
      required : true
    },
    "interaction_date" : {
      required : true
    },
    "final_result" : {
      required : true
    },
    "monthly_ctc" : {
      required: true
    },
    "monthly_cih" : {
      required: true
    },
    "date_of_joining" : {
      required : true
    }
  },
  errorPlacement: function(error, element) {
      if ( element.is(":radio") ) {
          error.css("display","block");
          error.appendTo( element.parent());
      }
      else { // This is the default behavior of the script
          error.insertAfter( element );
      }
  },
  messages: {
    "candidate_name" : {
      required: 'Please Enter Candidate name'
    },
    "rating" : {
      required: 'Please select rating'
    },
    "video_recording_seen" : {
      required: 'Please select any option'
    },
    "interview_remarks" : {
      required: 'Enter Interview Remarks'
    },
    "qualify" : {
      required : 'Select Yes or No'
    },
    "level" : {
      required : 'Please select any Option'
    },
    "interaction_date" : {
      required : 'Please select Date'
    },
    "final_result" : {
      required : 'Please select final status'
    },
    "monthly_ctc" : {
      required: 'Enter monthly CTC'
    },
    "monthly_cih" : {
      required: 'Enter monthly CIH'
    },
    "date_of_joining" : {
      required : 'Please Select Date'
    }
  }
});
</script>

<script>
  $(document).ready(function(){

    /*To Show notice period text field starts here*/
    $(".qualify_options").on('click',function(){
      var np_value = $(this).val();
      if(np_value == "Yes") {
        $(".notice_period_field").show();
      }
      else {
        $(".notice_period_field").hide();
      }
    });
    /*To Show notice period text field ends here*/

    /*for Range Picker Starts here*/
      var rangeSlider = function() {
        var range = $(".slider_input"),
            value = $(".display_span");

            value.each(function() {
              var value = $(this).prev().attr("value");
              $(this).html(value);
            });

            range.on("input", function() {
              $(this)
                .next(value).html(this.value);
            });
      };
      rangeSlider();/*for Range Picker Ends here*/  
  });

  var video_recording_seen = "{{@$detail['level_two']->video_recording_seen}}";

  if(video_recording_seen == "Yes"){
    $("#video_recording_yes").prop("checked",true);
  }else if(video_recording_seen == "No"){
    $("#video_recording_yes").prop("checked",true);
  }else if(video_recording_seen == "N/A"){
    $("#video_recording_na").prop("checked",true);
  }


  var qualify = "{{@$detail['level_two']->qualify}}";
  var next_level = "{{@$detail['level_two']->level}}";

  if(qualify == "Yes"){

    $("#qualify_yes").prop("checked",true);

    if(next_level == "On-Phone"){
      $("#nl_on_phone").prop("checked",true);
      $("#next_level_id").show();
      $("#interaction_date_with_mangement_id").show();
    }else if(next_level == "F2F-Location"){
      $("#nl_f2f_location").prop("checked",true);
      $("#next_level_id").show();
      $("#interaction_date_with_mangement_id").show();
    }else if(next_level == "F2F-HO"){
      $("#next_level_id").show();
      $("#nl_f2f_ho").prop("checked",true);
      $("#interaction_date_with_mangement_id").show();
    }

  }else if(qualify == "No"){
    $("#qualify_no").prop("checked",true);
  }

  var final_result = "{{@$detail['level_two']->final_result}}";
  if(final_result == "Rejected"){
    $("#rejected").prop("checked",true);
  }else if(final_result == "On-hold"){
    $("#on_hold").prop("checked",true);
  }else if(final_result == "Selected"){
    $("#selected").prop("checked",true);
  }

  function hide_element(){

    var qualify_yes =  $("input[name='qualify']:checked").val();

    if(qualify_yes == 'Yes'){

      $("#on_hold").hide();
      $("#rejected").hide();

    }else{

      $("#on_hold").show();
      $("#rejected").show();

    }

  }

</script>
@endsection