@extends('admins.layouts.app')

@section('content')
<style>
  /* css for kra tab */
.recruitment-box {
    border: 1px solid #3c8dbc;
    border-radius: 8px;
    position: relative;
    margin: 20px 0 20px;
}
.recruitment-heading {
    position: absolute;
    left: 50%;
    background-color: #fff;
    top: 0;
    transform: translate(-50%, -50%);
    padding: 10px;
    border: 1px solid #3c8dbc;
    border-radius: 10px;
    color: #3c8dbc;
}
.recruitment-heading h2 {
    font-size: 16px;
    margin: 0px;
    font-weight: 700;
}
.recruitment-box .table {
    margin: 30px 0 20px 0;
}
.plus-style {
    color: #3c8dbc;
}
.radio_btn_container {
    display: flex;
    justify-content: center;
}
.radio_btn_container span {
    margin: 10px;
}
.recruitment-box h3 {
    font-size: 14px;
    margin-top: 35px;
    text-decoration: underline;
}
.submit-btn-style {
    margin-bottom: 20px;
}


.add-kra-box {
    border: 1px solid #3c8dbc;
    border-radius: 8px;
    padding: 16px;
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
/* checkbox css */
/* The t-check-container */
.t-check-container {
  display: inline-block;
  position: relative;
  padding-left: 21px;
  cursor: pointer;
  font-size: 14px;
  font-weight: 700;
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
.label-h5, .label-h4, .label-h3, .label-h2, .label-h1 {
    color: black;
    font-size: 11px;
    border-radius: 50%;
    padding: 5px;
}
.label-h5{
  background-color: red;
}
.label-h4{
  background-color: orange;
}
.label-h3{
  background-color: aqua;
}
.label-h2{
  background-color: yellow;
}
.label-h1{
  background-color: #fffdd0;
}
.ak_f_c {
  display: -webkit-flex;
  display: -moz-flex;
  display: -ms-flex;
  display: -o-flex;
  display: flex;
  justify-content: space-around;
  padding: 20px 0;
  margin: 20px 0;
}
@media screen and (max-width: 850px) {
  .ak_f_c {
    flex-direction: column;
    text-align: center;
  }
  .ak_f_c_item {
    margin: 10px 0;
  }
}
</style>

<link rel="stylesheet" href="{{asset('public/admin_assets/plugins/dataTables/jquery.dataTables.min.css')}}">

<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <i class="fa fa-edit"></i>
      Edit Key Responsibility Area
      <!-- <small>Control panel</small> -->
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ url('employees/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="{{ url('mastertables/kra') }}">KRA Template List </a></li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Content here -->
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary">
          <div class="nav-tabs-custom">
            @if(session()->has('profileSuccess'))
              <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                {{ session()->get('profileSuccess') }}
              </div>
            @endif

            <!-- form start -->
            <form id="kraFormList" action="{{ url('mastertables/edit-kra-details') }}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
                  
              <div class="box-body jrf-form-body">
                <div class="row">
                  <div class="col-md-4 col-md-offset-4 label-left-sec">
    							  <div class="add-kra-box">

                      <div class="form-group">
      								  <label for="department_name">Department Name<sup class="ast">*</sup></label>
      									<select class="form-control input-sm basic-detail-input-style rem-input department" name="department" id="department_name">  
      										<option value="0" selected disabled>Select Department</option>
      										@foreach($departments as $deartment)
      										<option value="{{$deartment->id}}" @if(@$kra_indicators[0]->dep_id == @$deartment->id){{'selected'}}@endif >{{$deartment->name}}</option>  
      										@endforeach															
      											  
      									</select>
                      </div>

                      <div class="form-group">
                        <label for="kra_template_name">KRA Template Name: </label>
      									<input type="hidden" name="kra_id[]" value="{{$kra_indicators[0]->id}}" />
      									<input type="text" class="form-control input-sm basic-detail-input-style rem-input department" name="kra_name[]" value="{{$kra_indicators[0]->name}}" id="kra_template_name" />
                      </div>

    								</div>
                  </div>
                </div>

                <!--KRA priority definition Starts here-->
                <div class="row">
                  <div class="col-md-10 col-md-offset-1">
                    <div class="add-kra-box ak_f_c">
                      <div class="ak_f_c_item">
                        <span class="label-h5">H5</span>
                        <span>- 100 Points</span>
                      </div>
                      <div class="ak_f_c_item">
                        <span class="label-h4">H4</span>
                        <span>- 80 Points</span>
                      </div>
                      <div class="ak_f_c_item">
                        <span class="label-h3">H3</span>
                        <span>- 60 Points</span>
                      </div>
                      <div class="ak_f_c_item">
                        <span class="label-h2">H2</span>
                        <span>- 50 Points</span>
                      </div>
                      <div class="ak_f_c_item">
                        <span class="label-h1">H1</span>
                        <span>- 40 Points</span>
                      </div>
                    </div>
                  </div>
                </div>
                <!--KRA priority definition ends here-->

                <div class="recruitment-box">
                  <div class="recruitment-heading">
                    <h2 class="text-center">Key Responsibilities</h2>
                  </div>
                  <table class="table table-striped table-responsive table-bordered">
                    <thead>
                      <tr>
						<th></th>
                        <th>KRA Indicator Name</th>
                        <th>Frequency</th>
                        <th>Activation Date</th>
                        <th>Deadline</th>
                        <th>Priority</th>
                    </tr>
                    </thead>
                      <tbody class="kra_tbody">
                      @php
						$frequencies = array("Daily", "Weekly", "Monthly", "Fortnight", "Quarterly", "Biannually", "Annually");
						$priorities = array("H5", "H4", "H3", "H2", "H1");
					@endphp

                      @foreach($kra_indicators as $kra_indicator)                           
                        @foreach($kra_indicator->kraTemplates as $indicator)
                          <tr class="first_kra_row">
							
						  <td class="text-center"> 
						  <input type="hidden" name="indicator_id[]" value="{{$indicator->id}}" />	
						  <a href="javascript:void(0)" id="{{$indicator->id}}" class="remove_kra_row"><i class="fa fa-minus a_r_style a_r_style_red"></i></a></td>
                           
                            <td>
    			                    <input type="text" name="kra_indicator_name[]" class="form-control input-sm basic-detail-input-style regis-input-field" placeholder="Enter Name" value="{{$indicator->name}}" required>
                            </td>
                            <td>
                              <select name="kra_frequency[]" class="form-control input-sm basic-detail-input-style regis-input-field task_frequncy" required>
                                <option value="" selected disabled>Select frequency</option>

                                @foreach($frequencies as $frequency)
                                  <option value="{{$frequency}}" @if($frequency==$indicator->frequency){{"selected"}}@endif>{{ ucfirst($frequency)}} </option> 
                                @endforeach

                              </select>
                            </td>
                            <td>
    				                 <input type="text" name="kra_activation_date[]" id="activation_id" class="form-control input-sm basic-detail-input-style regis-input-field datepicker" value="{{$indicator->activation_date}}" placeholder="2020-02-20" required>
                            </td>
                            <td>
    				                  <input type="text" name="kra_deadline_date[]" class="form-control input-sm basic-detail-input-style regis-input-field datepicker" value="{{$indicator->deadline_date}}"  placeholder="2020-02-20" required>
                            </td>
                            <td>
    			              <select name="kra_priority[]" class="form-control input-sm basic-detail-input-style regis-input-field" required>
								<option value="" selected="" disabled="">Select priority</option>

                                 @foreach($priorities as $priority)
    	                           <option value="{{$priority}}" @if($priority==$indicator->priority){{"selected"}}@endif> {{ucfirst($priority)}} </option>
                                 @endforeach

                              </select>                                 
                            </td>
							
                          </tr>
                        @endforeach
                      @endforeach
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
                  <input type="submit" class="btn btn-primary submit-btn-style" id="submit3" value="Submit" name="submit">
                </div>
              
              </div>
            </form>
          </div>
        </div>
      <!-- /.box -->
      </div>
      <!-- /.row -->
      <!-- Content here -->
    </div>
    <!-- kra tab ends--> 
    <!-- Main row -->
  </section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->


<script src="{{asset('public/admin_assets/plugins/dataTables/jquery.dataTables.min.js')}}"></script>
  <script src="{!!asset('public/admin_assets/plugins/sweetalert/sweetalert.min.js')!!}"></script>
  <script src="{{asset('public/admin_assets/plugins/validations/jquery.validate.js')}}"></script>
  <script src="{{asset('public/admin_assets/plugins/validations/additional-methods.js')}}"></script>

<script type="text/javascript">
$(document).ready(function(){
	
  var i=0; 
  $('#add_new_kra').click(function(){ 
 
  $(".datepicker").datepicker("destroy");  
  i++;  
  <?php
   $frequencies = array("Daily", "Weekly", "Monthly", "Fortnight", "Quarterly", "Biannually", "Annually");
   $priorities = array("H5", "H4", "h3", "H2", "H1");
  ?>
  $('.kra_tbody').append('<tr class="kra_row_id'+i+'"><td class="text-center"> <a href="javascript:void(0)" id="'+i+'" class="remove_kra_row_id"><i class="fa fa-minus a_r_style a_r_style_red"></i></a></td><td><input type="text" name="added_name[]" class="form-control" placeholder="Enter Name" value="" required></td><td><select name="added_frequency[]" class="form-control" required><option value="" selected disabled>Select frequency</option> @foreach($frequencies as $frequency) <option value="{{$frequency}}"> {{ucfirst($frequency)}} </option> @endforeach</select></td><td><input type="text" name="added_activation_date[]" class="form-control datepicker" value="" required></td><td><input type="text" name="added_deadline[]" class="form-control datepicker" value="" required></td><td><select name="added_priority[]" class="form-control" required><option value="" selected="" disabled="">Select priority</option> @foreach($priorities as $priority)<option value="{{$priority}}"> {{ucfirst($priority)}}</option> @endforeach</select></td></tr>');

  $(".datepicker").datepicker({autoclose: true, orientation: "bottom", format: 'yyyy-mm-dd' });
  });   
  });
  
$(document).on('click', '.remove_kra_row_id', function(){    

	var remove_id = $(this).attr("id"); 
	$('.kra_row_id'+remove_id+'').detach();   

});  

$(document).on('click', '.remove_kra_row', function(){

  var postURL = "<?php echo url('mastertables/edit-kra-details'); ?>";  
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



  $(function () {
    //Date picker
    $('.datepicker').datepicker({
      autoclose: true,
      orientation: "bottom",
      format: 'yyyy-mm-dd'
    });
  });     

  $(document).ready(function() {
    $('#listPtRegistrations').DataTable({
      scrollX: true,
      responsive: true
    });
  });
</script>

@endsection