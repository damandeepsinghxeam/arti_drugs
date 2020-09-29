@extends('admins.layouts.app')

@section('content')


<style>
.priority-box {
  border: 1px solid #3c8dbc;
  border-radius: 4px;
  margin: 19px 100px 34px 100px;
  padding: 20px 2px 36px 2px;
  text-align: center;
}

.Priority_points{
  background-color: beige;
}
.priority_container{
  margin-left: 20px;
  float:left;
}
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


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1><i class="fa fa-list"></i> Key Responsibility Area</h1>
    <ol class="breadcrumb">
      <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="#">Locations List</a></li> 
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-sm-12">
        <div class="box box-primary">

        <!-- form start -->
        <form id="addKraForm" action="{{ url('mastertables/create-kra') }}" method="POST">
          {{ csrf_field() }}
          <div class="box-body jrf-form-body">
            <div class="row">
              <div class="col-md-4 col-md-offset-4 label-left-sec">
                <div class="add-kra-box">
                  <div class="form-group">
                    <label for="department_name">Department Name<sup class="ast">*</sup></label>
                    <select class="form-control input-sm basic-detail-input-style rem-input department" name="department" id="department_name">  
                      <option value="0" selected disabled>Select Department</option>
                      @foreach($data['departments'] as $deartment)
                      <option value="{{$deartment->id}}" >{{$deartment->name}}</option>  
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="kra_template_name">KRA Template name<sup class="ast">*</sup></label>
                    <input type="text" name="kra_name" id="kra_type" class="form-control input-sm basic-detail-input-style regis-input-field" id="kra_template_name" placeholder="Enter KRA Name">
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
            <!--
            <div class="priority-box">
              @foreach($data['tasks'] as $task)
              <div class="priority_container">
                <span class="label label-{{$task->priority}}">{{$task->priority}}</span>
                <span class="Priority_points label">{{$task->weight}} Points</span>
              </div>
              @endforeach
            </div>
            -->
            <!--KRA priority definition ends here-->

          
            <!--KRA Table Starts here-->
            <div class="recruitment-box">
              <div class="recruitment-heading">
                <h2 class="text-center">Key Responsibilities</h2>
              </div>

              <table class="table table-striped table-responsive table-bordered">
                <thead>
                  <tr>
                    <th>S No.</th>
                    <th>KRA Indicators</th>
                    <th>Frequency</th>
                    <th>Activation Date</th>
                    <th>Deadline</th>
                    <th>Priority</th>
                    <th>Add/ Remove</th>
                  </tr>
                </thead>
                <tbody class="kra_tbody">
                  <tr class="first_kra_row">
                    <td>1</td>
                    <td>
                      <input type="text" name="Full_name[]" class="form-control input-sm basic-detail-input-style regis-input-field" placeholder="Enter Name" required>
                    </td>
                    <td>
                      @php
                      $frequencies = array("Daily", "Weekly", "Monthly", "Fortnight", "Quarterly", "Biannually", "Annually");
                      $current_month = date('m');
                      $current_year =  date('Y');  
                      @endphp

                      <select name="frequency[]" class="form-control task_frequncy input-sm basic-detail-input-style regis-input-field">
                        <option value="" selected disabled>Frequency</option>
                        @foreach($frequencies as $frequency){
                        <option value="{{$frequency}}">{{ucfirst($frequency)}}</option>
                        @endforeach
                      </select>
                    </td>
                    <td>
                      <div class="select_activation">
                        <input type="text" name="activation_date[]" id="activation_id" class="form-control datepicker input-sm  basic-detail-input-style regis-input-field"placeholder="2020-02-20" required>
                      </div>
                    </td>
                    <td>
                      <input type="text" name="deadline[]" class="form-control datepicker input-sm basic-detail-input-style regis-input-field" placeholder="2020-02-20">
                    </td>
                    <td>
                      @php
                      $priorities = array("H5", "H4", "H3", "H2", "H1");
                      @endphp
                      <select name="priority[]" class="form-control input-sm basic-detail-input-style regis-input-field">
                        <option value="" selected disabled>Priority</option>

                        @foreach($priorities as $priority){
                        <option value="{{$priority}}">{{$priority}}</option>
                        @endforeach

                      </select>
                    </td>
                    <td class="text-center">
                      <a href="javascript:void(0)" id="add_new_kra">
                        <i class="fa fa-plus a_r_style a_r_style_green"></i>
                      </a>
                    </td>
                  </tr>
                </tbody>
              </table>
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
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script src="{{asset('public/admin_assets/plugins/validations/jquery.validate.js')}}"></script>

<script src="{{asset('public/admin_assets/plugins/validations/additional-methods.js')}}"></script>

<script>
$(function () {
    //Date picker
    $('.datepicker').datepicker({
      autoclose: true,
      orientation: "bottom",
      format: 'yyyy-mm-dd'
    });
});     
    
$("#addKraForm").validate({
  rules: {
    "department" : {
      required: true
    },
    "kra_name" : {
      required: true
    },
    "Full_name[]" : {
      required: true
    },
    "frequency[]" : {
      required: true
    },
    "activation_date[]" : {
      required: true
    },
    "deadline[]" : {
      required: true
    },
    "priority[]" : {
      required: true
    }
  },  
  messages: {
    "department" : {
      required: 'Select Department'
    },
    "kra_name" : {
      required: 'Enter KRA name'
    },
    "full_name[]" : {
      required: 'Enter Name'
    },
    "frequency[]" : {
      required: 'Select Frequency'
    },
    "activation_date[]" : {
      required: 'Select Activation Date'
    },
    "deadline[]" : {
      required: 'Select Deadline Date'
    },
    "priority[]" : {
      required: 'Select Priority'
    },
  }
}); 

 var i=1; 
$('#add_new_kra').on('click',function(){
   $(".datepicker").datepicker("destroy");
 
   i++;  
   //alert("Add New KRA");
    $(".kra_tbody").append('<tr class="first_kra_row"><td>'+i+'</td><td><input type="text" name="Full_name['+i+']" class="form-control input-sm basic-detail-input-style regis-input-field" placeholder="Enter Name" required></td><td><select name="frequency['+i+']" class="form-control input-sm basic-detail-input-style regis-input-field task_frequncy'+i+' " required><option value="" selected disabled>Frequency</option><option value="Daily">Daily</option> <option value="Weekly">Weekly</option><option value="Monthly">Monthly</option> <option value="Fortnight">Fornight</option><option value="Quarterly">Quarterly</option><option value="Biannually">Biannually</option><option value="Annually">Annually</option></select></td><td><div class="select_activation "> <input type="text" name="activation_date['+i+']" id="" class="form-control input-sm basic-detail-input-style regis-input-field datepicker"placeholder="2020-02-20" required> </div></td><td><input type="text" name="deadline['+i+']" class="form-control input-sm basic-detail-input-style regis-input-field datepicker" placeholder="2020-02-20" required></td><td><select name="priority['+i+']" class="form-control input-sm basic-detail-input-style regis-input-field" required><option value="" selected disabled>Priority</option><option value="H4">H4</option><option value="H3">H3</option><option value="H2">H2</option><option value="H1">H1</option></select></td><td class="text-center"><a href="javascript:void(0)" class="remove_current_row" id="remove_kra"><i class="fa fa-minus a_r_style a_r_style_red"></i></a></td></tr>');

     $(".remove_current_row").on('click', function(){
      $(this).parents("tr").remove();
      i--;
     });

     //activation date filter base on frequency selection starts here

     $(".task_frequncy"+i).on('change', function(){

      var freq_value = $(this).val();
      var activation_class = $(this).closest('tr').find('td div.select_activation');

      if (freq_value == "Weekly") {

        
        activation_class.html('<select name="activation_date[]" id="select_activation_id" class="form-control"placeholder="2020-02-02"><option value=" ">Activation Date</option> <option value="<?php echo $current_year; ?>-<?php echo $current_month; ?>-01"><?php echo $current_year; ?>-<?php echo $current_month; ?>-01</option>  <option value="<?php echo $current_year; ?>-<?php echo $current_month; ?>-07"><?php echo $current_year; ?>-<?php echo $current_month; ?>-07</option> <option value="<?php echo $current_year; ?>-<?php echo $current_month; ?>-14"><?php echo $current_year; ?>-<?php echo $current_month; ?>-14</option>   <option value="<?php echo $current_year; ?>-<?php echo $current_month; ?>-21"><?php echo $current_year; ?>-<?php echo $current_month; ?>-21</option> </select>');
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
           
          activation_class.html('<input type="text" name="activation_date[]" id="activation_id" class="form-control datepicker"placeholder="20-02-2020">');
        }
        if(freq_value=="Daily"){
          
          activation_class.html('<input type="text" name="activation_date[]" id="activation_id" class="form-control datepicker"placeholder="20-02-2020">');
        }
        if(freq_value=="Monthly"){
          
          activation_class.html('<input type="text" name="activation_date[]" id="activation_id" class="form-control datepicker"placeholder="20-02-2020">');
        }
         $(".datepicker").datepicker({autoclose: true, orientation: "bottom", format: 'yyyy-mm-dd' });
      })

     
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

      
      activation_class.html('<select name="activation_date[]" id="select_activation_id" class="form-control"placeholder="2020-02-02"><option value=" ">Activation Date</option> <option value="<?php echo $current_year; ?>-<?php echo $current_month; ?>-01"><?php echo $current_year; ?>-<?php echo $current_month; ?>-01</option>  <option value="<?php echo $current_year; ?>-<?php echo $current_month; ?>-07"><?php echo $current_year; ?>-<?php echo $current_month; ?>-07</option> <option value="<?php echo $current_year; ?>-<?php echo $current_month; ?>-14"><?php echo $current_year; ?>-<?php echo $current_month; ?>-14</option>   <option value="<?php echo $current_year; ?>-<?php echo $current_month; ?>-21"><?php echo $current_year; ?>-<?php echo $current_month; ?>-21</option> </select>');
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
       activation_class.html('<input type="text" name="activation_date[]" id="activation_id" class="form-control datepicker"placeholder="20-02-2020">');
    }
    if(freq_value=="Daily"){
      activation_class.html('<input type="text" name="activation_date[]" id="activation_id" class="form-control datepicker"placeholder="20-02-2020">');
    }
    if(freq_value=="Monthly"){
      activation_class.html('<input type="text" name="activation_date[]" id="activation_id" class="form-control datepicker"placeholder="20-02-2020">');
    }
     
    $(".datepicker").datepicker({autoclose: true, orientation: "bottom", format: 'yyyy-mm-dd' });
});
</script>
 @endsection