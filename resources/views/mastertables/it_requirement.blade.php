@extends('admins.layouts.app')

@section('content')

<style>
.radio { margin: 6px 0 0 0; }
.radio label input { position: relative; top: -2px; }

/* checkbox css */
/* The t-check-container */
.t-check-container {
  display: inline-block;
  position: relative;
  padding-left: 21px;
  margin-bottom: 13px;
  cursor: pointer;
  font-size: 13px;
  font-weight: 500;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

/* Hide the browser's default checkbox */
.t-check-container input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
  height: 0;
  width: 0;
}

/* Create a custom checkbox */
.task-checkmark {
  position: absolute;
  top: 0;
  left: 0;
  height: 18px;
  width: 18px;
  background-color: #a6ddfd;
}

/* On mouse-over, add a grey background color */
.t-check-container:hover input ~ .task-checkmark {
  background-color: #7dc1e8;
}

/* When the checkbox is checked, add a blue background */
.t-check-container input:checked ~ .task-checkmark {
  background-color: #2196F3;
}

/* Create the task-checkmark/indicator (hidden when not checked) */
.task-checkmark:after {
  content: "";
  position: absolute;
  display: none;
}

/* Show the task-checkmark when checked */
.t-check-container input:checked ~ .task-checkmark:after {
  display: block;
}

/* Style the task-checkmark/indicator */
.t-check-container .task-checkmark:after {
  left: 7px;
  top: 3px;
  width: 5px;
  height: 10px;
  border: solid white;
  border-width: 0 3px 3px 0;
  -webkit-transform: rotate(45deg);
  -ms-transform: rotate(45deg);
  transform: rotate(45deg);
}
/* checkbox css */
</style>

<!-- Content Wrapper Starts here -->
<div class="content-wrapper">

  <!-- Content Header Starts here -->
   <section class="content-header">
    <h1>IT Requirement</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Dashboard</li>
    </ol>
  </section>
  <!-- Content Header Ends here -->
  
  <!-- Main content Starts here -->
 <section class="content">
    <div class="row">
      <div class="col-sm-12">
        <div class="box box-primary">
        	 @include('admins.validation_errors')
		@php

		if(isset($data['it_req_values']) AND ($data['it_req_values']!="")){
			if(isset($data['it_req_values']['sms']) AND ($data['it_req_values']['sms']!="")){
				$sms = $data['it_req_values']['sms'];
			}else{
				$sms ="";
			}

			if(isset($data['it_req_values']['number_of_sms']) AND ($data['it_req_values']['number_of_sms']!="")){
				$number_of_sms = $data['it_req_values']['number_of_sms'];
			}else{
				$number_of_sms ="";
			}

			if(isset($data['it_req_values']['email']) AND ($data['it_req_values']['email']!="")){
				$email = $data['it_req_values']['email'];
			}else{
				$email ="";
			}

			if(isset($data['it_req_values']['number_of_email']) AND ($data['it_req_values']['number_of_email']!="")){
				$number_of_email = $data['it_req_values']['number_of_email'];
			}else{
				$number_of_email ="";
			}

			if(isset($data['it_req_values']['jrf']) AND ($data['it_req_values']['jrf']!="")){
				$jrf = $data['it_req_values']['jrf'];
			}else{
				$jrf ="";
			}

			if(isset($data['it_req_values']['takeover']) AND ($data['it_req_values']['takeover']!="")){
				$takeover = $data['it_req_values']['takeover'];
			}else{
				$takeover ="";
			}

			if(isset($data['it_req_values']['naukri_check']) AND ($data['it_req_values']['naukri_check']!="")){
				$naukri_check = $data['it_req_values']['naukri_check'];
			}else{
				$naukri_check ="";
			}

			if(isset($data['it_req_values']['naukri_quantity']) AND ($data['it_req_values']['naukri_quantity']!="")){
				$naukri_quantity = $data['it_req_values']['naukri_quantity'];
			}else{
				$naukri_quantity ="";
			}

			if(isset($data['it_req_values']['naukri_cost']) AND ($data['it_req_values']['naukri_cost']!="")){
				$naukri_cost = $data['it_req_values']['naukri_cost'];
			}else{
				$naukri_cost ="";
			}

			if(isset($data['it_req_values']['xeam_job_check']) AND ($data['it_req_values']['xeam_job_check']!="")){
				$xeam_job_check = $data['it_req_values']['xeam_job_check'];
			}else{
				$xeam_job_check ="";
			}

			if(isset($data['it_req_values']['xeam_job_quantity']) AND ($data['it_req_values']['xeam_job_quantity']!="")){
				$xeam_job_quantity = $data['it_req_values']['xeam_job_quantity'];
			}else{
				$xeam_job_quantity ="";
			}

			if(isset($data['it_req_values']['xeam_job_cost']) AND ($data['it_req_values']['xeam_job_cost']!="")){
				$xeam_job_cost = $data['it_req_values']['xeam_job_cost'];
			}else{
				$xeam_job_cost ="";
			}

			if(isset($data['it_req_values']['monster_check']) AND ($data['it_req_values']['monster_check']!="")){
				$monster_check = $data['it_req_values']['monster_check'];
			}else{
				$monster_check ="";
			}

			if(isset($data['it_req_values']['monster_quantity']) AND ($data['it_req_values']['monster_quantity']!="")){
				$monster_quantity = $data['it_req_values']['monster_quantity'];
			}else{
				$monster_quantity ="";
			}

			if(isset($data['it_req_values']['monster_cost']) AND ($data['it_req_values']['monster_cost']!="")){
				$monster_cost = $data['it_req_values']['monster_cost'];
			}else{
				$monster_cost ="";
			}

			if(isset($data['it_req_values']['content']) AND ($data['it_req_values']['content']!="")){
				$content = $data['it_req_values']['content'];
			}else{
				$content ="";
			}
		}else{
			$sms ="";
			$number_of_sms ="";
			$email ="";
			$number_of_email ="";
			$jrf ="";
			$takeover ="";
			$naukri_check ="";
			$naukri_quantity ="";
			$naukri_cost ="";
			$xeam_job_check ="";
			$xeam_job_cost ="";
			$xeam_job_quantity ="";
			$monster_check ="";
			$monster_cost ="";
			$monster_quantity ="";
			$content ="";

		}
		@endphp

          <!-- Form Starts here -->
          <form id="project_approval_handover" action="{{ url('mastertables/save-project') }}" method="POST">
          	{{ csrf_field() }}
            <div class="box-body jrf-form-body">
              <!-- Row starts here -->
              <div class="row">
                <h4 class="text-center" style="text-decoration: underline;"><b>IT Requirement</b></h4>
                <div class="col-md-3">
                  <div class="form-group">
                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
                          <label class="apply-leave-label">SMS</label>
                        </div>
                        <div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
                          <div class="radio">
                            <label>
                              <input type="radio" name="sms" class="smsOption" id="" value="Yes" @if($sms == "Yes"){{'checked'}} @endif>Yes
                            </label>&nbsp;&nbsp;
                            <label>
                              <input type="radio" name="sms" class="smsOption" id="" value="No" @if($sms == "No"){{'checked'}} @endif>No
                            </label>
                          </div>
                        </div>
                    </div>
                  </div>

                  <div class="form-group smsNumber">
                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
                          <label for="number_of_sms" class="apply-leave-label">Number of SMS</label>
                        </div>
                        <div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
                          <input type="number" class="form-control input-sm basic-detail-input-style" name="number_of_sms" id="number_of_sms" placeholder="Enter number of SMS" value="{{$number_of_sms}}">
                        </div>
                    </div>
                  </div>
                </div>

                <div class="col-md-3">
                  <div class="form-group">
                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
                          <label class="apply-leave-label">Email</label>
                        </div>
                        <div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
                          <div class="radio">
                            <label>
                              <input type="radio" name="email" class="emailOption" id="" value="Yes" @if($email == "Yes"){{'checked'}} @endif>Yes
                            </label>&nbsp;&nbsp;
                            <label>
                              <input type="radio" name="email" class="emailOption" id="" value="No" @if($email == "No"){{'checked'}} @endif>No
                            </label>
                          </div>
                        </div>
                    </div>
                  </div>

                  <div class="form-group emailNumber">
                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
                          <label for="number_of_email" class="apply-leave-label">Number of Email</label>
                        </div>
                        <div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
                          <input type="number" class="form-control input-sm basic-detail-input-style" name="number_of_email" id="number_of_email" placeholder="Enter number of Email" value="{{$number_of_email}}">
                        </div>
                    </div>
                  </div>
                </div>

                <div class="col-md-3">
                  <div class="form-group">
                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
                          <label class="apply-leave-label">JRF</label>
                        </div>
                        <div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
                          <div class="radio">
                            <label>
                              <input type="radio" name="jrf" id="" value="Yes" @if($jrf == "Yes"){{'checked'}} @endif>Yes
                            </label>&nbsp;&nbsp;
                            <label>
                              <input type="radio" name="jrf" id="" value="No" @if($jrf == "No"){{'checked'}} @endif>No
                            </label>
                          </div>
                        </div>
                    </div>
                  </div>
                </div>

                <div class="col-md-3">
                  <div class="form-group">
                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
                          <label class="apply-leave-label">Takeover</label>
                        </div>
                        <div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
                          <div class="radio">
                            <label>
                              <input type="radio" name="takeover" id="" value="Yes" @if($takeover == "Yes"){{'checked'}} @endif>Yes
                            </label>&nbsp;&nbsp;
                            <label>
                              <input type="radio" name="takeover" id="" value="No" @if($takeover == "No"){{'checked'}} @endif>No
                            </label>&nbsp;&nbsp;
                           
                          </div>
                        </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Row Ends Here -->

              <div class="row">
                <div class="col-md-6">
                  <h4 class="text-center" style="text-decoration: underline;"><b>Advertisement</b></h4>
                  <table class="table table-bordered table-striped">
                    <tr>
                      <th>Check</th>
                      <th>Through</th>
                      <th>Quantity</th>
                      <th>Costs</th>
                    </tr>
                    <tr>
                      <td>
                        <label class="t-check-container">
                          <input type="checkbox" name="naukri_check" class="singlecheckbox" value="1" @if($naukri_check == "1"){{'checked'}} @endif>
                          <span class="task-checkmark"></span>
                        </label>
                      </td>
                      <td>
                        Naukri
                      </td>
                      <td>
                        <input type="number" name="naukri_quantity" id="" class="form-control input-sm basic-detail-input-style numberInput" placeholder="Enter Quantity here" disabled value="{{$naukri_quantity}}">
                      </td>
                      <td>
                        <input type="number" name="naukri_cost" id="" class="form-control input-sm basic-detail-input-style numberInput" placeholder="Enter Costs here" disabled value="{{$naukri_cost}}">
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <label class="t-check-container">
                          <input type="checkbox" name="xeam_job_check" class="singlecheckbox" value="1" @if($xeam_job_check == "1"){{'checked'}} @endif>
                          <span class="task-checkmark"></span>
                        </label>
                      </td>
                      <td>
                        Xeam Job
                      </td>
                      <td>
                        <input type="number" name="xeam_job_quantity" id="" class="form-control input-sm basic-detail-input-style numberInput" placeholder="Enter Quantity here" disabled value="{{$xeam_job_quantity}}">
                      </td>
                      <td>
                        <input type="number" name="xeam_job_cost" id="" class="form-control input-sm basic-detail-input-style numberInput" placeholder="Enter Costs here" disabled value="{{$xeam_job_cost}}">
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <label class="t-check-container">
                          <input type="checkbox" name="monster_check" class="singlecheckbox" value="1" @if($monster_check == "1"){{'checked'}} @endif>
                          <span class="task-checkmark"></span>
                        </label>
                      </td>
                      <td>
                        Monster
                      </td>
                      <td>
                        <input type="number" name="monster_quantity" id="" class="form-control input-sm basic-detail-input-style numberInput" placeholder="Enter Quantity here" disabled value="{{$monster_quantity}}">
                      </td>
                      <td>
                        <input type="number" name="monster_cost" id="" class="form-control input-sm basic-detail-input-style numberInput" placeholder="Enter Costs here" disabled value="{{$monster_cost}}">
                      </td>
                    </tr>
                  </table>
                </div>
                <div class="col-md-6">
                  <h4 class="text-center" style="text-decoration: underline;"><b>Content</b></h4>
                  <div class="form-group" id="content_expand">
                    <div class="row main-row"> 
                      <div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470"> 
                        <label for="" class="apply-leave-label">Content 1</label>
                      </div>
                      <div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
                        
                        
                          	 @if(isset($content) AND (is_array($content)))
                          	 @php
                          	 $i=100;
                          	 @endphp
                          	 
								@foreach($content as $cont)
								<div class="row content_row_id{{$i}}">
								  <div class="col-xs-10 input-l">
	                           		<textarea name="content[]" id="" rows="2" style="width: 100%"> {{$cont}} </textarea>
	                           	</div>
	                           	<div class="col-xs-2 input-r"><a href="javascript:void(0)" id="{{$i}}" class="remove_content_row_id"><i class="fa fa-minus a_r_style a_r_style_red"></i></a>
	                           	</div>
	                           </div>
	                           	 @php
	                          	 $i++;
	                          	 @endphp
	                           	
								@endforeach

								 <div class="col-xs-2 input-l">
		                            <a href="javascript:void(0)" id="add_more_content">
		                              <i class="fa fa-plus a_r_style a_r_style_green"></i>
		                            </a>
		                          </div>
								
							@else
							<div class="row">
							 <div class="col-xs-10 input-l">
								<textarea name="content[]" id="" rows="2" style="width: 100%"></textarea>
                            </div>
                             <div class="col-xs-2 input-r">
	                            <a href="javascript:void(0)" id="add_more_content">
	                              <i class="fa fa-plus a_r_style a_r_style_green"></i>
	                            </a>
	                          </div>
	                      </div>
							@endif

							@php
	                          if(request('project_id')){
	                            $project_id = @request('project_id');
	                        }else{
	                            $project_id = "";
	                        }            
	                         
	                        @endphp                 
                         <input type="hidden" name="project_id" value="{{@$project_id}}">
                       
                      </div>
                    </div>
                  </div>
                </div>
              </div>

            

            <div class="box-footer text-center">
              <input type="submit" class="btn btn-primary" id="save" value="Submit" name="save_as_draft_it_req">
            </div>

          </form>
          <!-- Form Ends here -->


        </div>
      </div>
    </div>
  </section>
  <!-- Main content Ends Here-->

</div>
<!-- Content Wrapper Ends here -->

<!-- Script Source Files Starts here -->
<script src="{{asset('public/admin_assets/plugins/validations/jquery.validate.js')}}"></script>
<script src="{{asset('public/admin_assets/plugins/validations/additional-methods.js')}}"></script>
<!-- Script Source Files Ends here -->

<!-- Custom Script Starts here -->
<script>

  //Validation Starts here
  $("#project_approval_handover").validate({
    rules: {
      "sms" : {
        required: true
      },
      
      "email" : {
        required: true
      },
      
      "jrf" : {
        required: true
      },
      "takeover" : {
        required: true
      },
      
      "content[]" : {
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
      "sms" : {
        required: 'Select sms'
      },

     

      "email" : {
        required: 'Select email'
      },

     

      "jrf" : {
        required: 'Select jrf'
      },

      "takeover" : {
        required: 'Select takeover'
      },

      "content[]" : {
        required: 'Enter content'
      }
     
     
    }
  });
  //Validation Ends here

  //SMS Functionality Starts here
  $('.smsNumber').hide();
  $(".smsOption").on('click', function(){
  	var smsValue = $(this).val();
  	if (smsValue == 'Yes') {
  		$('.smsNumber').fadeIn();
  	} else {
  		$('.smsNumber').fadeOut();
  		$('.smsNumber input').val('');
  	}
  });
  //SMS Functionality Ends here

  //  Email Functionality starts here
  $('.emailNumber').hide();
  $('.emailOption').on('click', function(){
  	var emailValue = $(this).val();
  	if (emailValue == 'Yes') {
  		$('.emailNumber').fadeIn();
  	} else {
  		$('.emailNumber').fadeOut();
  		$('.emailNumber input').val('');
  	}
  });
  //  Email Functionality ends here

  // Checkbox Functionality Starts here
  $('.singlecheckbox').on('click',function(){
    var tdAllInputs = $(this).closest('tr').find(':input.numberInput');
    if( $(this).is(':checked') ) {
      tdAllInputs.attr('disabled', false);
      tdAllInputs.prop('required', true);
    } else {
      tdAllInputs.attr('disabled', true).val('');
    }
  });  
  // Checkbox Functionality Starts here

 /*Content area Starts here*/ 
 $(document).ready(function(){

	  var i=0; 
	 $("#add_more_content").on('click', function(){
	 
	  $("#content_expand").append('<div class="row content_row_id'+i+'" main-row" style="margin-top: 10px;"><div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470"><label for="" class="apply-leave-label">Content 1</label></div><div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470"><div class="row"><div class="col-xs-10 input-l"><textarea name="content['+i+']" id="" rows="2" style="width: 100%" required></textarea></div><div class="col-xs-2 input-r"><a href="javascript:void(0)" id="'+i+'" class="remove_content_row_id"><i class="fa fa-minus a_r_style a_r_style_red"></i></a></div></div></div>');

  i++;  	
 	});
 });
 /*Content area Ends here*/ 

$(document).on('click', '.remove_content_row_id', function(){    

	var remove_id = $(this).attr("id"); 
	alert(remove_id);
	$('.content_row_id'+remove_id).detach();   

});



$(document).ready(function() {
  var id = 0;

  // Add button functionality
  $("table.dynatable button.add").click(function() {
    id++;
    var master = $(this).parents("table.dynatable");

    // Get a new row based on the prototype row
    var prot = master.find(".prototype").clone();
    prot.attr("class", id + " item")
    prot.find(".id").attr("value", id);

    master.find("tbody").append(prot);
    prot.append('<td><button class="remove">Remove</button></td>');
  });

  // Remove button functionality
  $("table.dynatable button.remove").live("click", function() {
    $(this).parents("tr").remove();
    recalcId();
    id--;
  });
});

function recalcId() {
  $.each($("table tr.item"), function(i, el) {
    $(this).find("td:first input").val(i + 1); // Simply couse the first "prototype" is not counted in the list
  })
}




</script>
<!-- Custom Script Ends here -->

@endsection
  
