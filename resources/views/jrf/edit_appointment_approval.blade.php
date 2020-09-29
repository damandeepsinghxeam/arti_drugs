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
.security_amount_field, .security_cheque_fields {
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
.heading2 {
    font-size: 16px;
    margin-top: 10px;
    font-weight: 600;
    text-decoration: underline;
    text-align: center;
}
table tr th {
   width: 220px;
}
</style>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>UPDATE FINAL APPROVAL OF APPOINTMENT</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Locations List</a></li> 
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
              <form id="jrf_final_approval" method="POST" action="{{url('jrf/update-appointment-approval')}}" enctype="multipart/form-data">
                {{ csrf_field() }}
                  
                  <input type="hidden" id="h_id" name="h_id" value="{{@$data['detail']->id}}">
                  <input type="hidden" value="{{Auth::id()}}" name="user_id">
                  <input type="hidden" value="{{$data['detail']->jrf_id}}" name="jrf_id">
                  <input type="hidden" value="{{$data['detail']->department_id}}" name="department_id_new">
                  <input type="hidden" value="{{$data['detail']->designation_id}}" name="designation_id_new">
                  <input type="hidden" value="{{$data['detail']->jrf_level_one_screening_id}}" name="jrf_level_one_screening_id">
                  
                  <div class="box-body jrf-form-body">
                     <div class="row">
                        <div class="col-md-5">
                           <div class="input-group d_o_r">
                              <div class="input-group-btn">
                              <button type="button" class="btn btn-primary">Name</button>
                              </div><!-- /btn-group -->
                              <input type="text" class="form-control" value="{{@$data['recruiter']->employee->fullname}}" disabled>
                           </div>
                           <div class="input-group d_o_r">
                              <div class="input-group-btn">
                                <button type="button" class="btn btn-warning">Designation</button>
                              </div><!-- /btn-group -->
                              <input type="hidden" class="form-control" value="{{@$data['recruiter']->roles[0]->id}}" name="designation_id">
                              <input type="text" class="form-control" value="{{@$data['recruiter']->roles[0]->name}}" disabled>
                           </div>
                           <div class="input-group d_o_r">
                              <div class="input-group-btn">
                              <button type="button" class="btn btn-info">Department</button>
                              </div><!-- /btn-group -->
                              <input type="hidden" value="{{@$data['recruiter']->employeeProfile->department->id}}" name="department_id">
                              <input type="text" class="form-control" value="{{@$data['recruiter']->employeeProfile->department->name}}" disabled>
                           </div>
                        </div>

                        <div class="col-md-7">
                          <div class="table-styling">
                            <h2 class="heading2">HUMAN RESOURCE</h2>
                            <table class="table table-striped table-responsive">
                            <tr>
                               <th>Candidate Name:</th>
                                 <td>
                                   <input type="text" name="" value="{{@$data['basic']->name}}" id="" class="form-control basic-detail-input-style"  disabled>
                                 </td>
                             </tr>
                            <tr>
                               <th>Current Designation:</th>
                                 <td>
                                   <input type="text" name="" value="{{@$data['basic']->current_designation}}" id="" class="form-control basic-detail-input-style" disabled>
                                 </td>
                             </tr>  
                            <tr>
                               <th>Previous Company CTC (Monthly):</th>
                               <td>
                                 <input type="number" name="" value="{{@$data['basic']->current_ctc}}" id="" class="form-control basic-detail-input-style" disabled>
                               </td>
                             </tr>
                             <tr>
                               <th>Previous Company CIH (Monthly):</th>
                                 <td>
                                   <input type="number" name="" value="{{@$data['basic']->current_cih}}" id="" class="form-control basic-detail-input-style" disabled>
                                 </td>
                             </tr>  
                             <tr>
                              <th>Date of Joining:</th>
                                <td>
                                   <input type="text" name="" class="form-control" id="" placeholder="12-03-2020" value="{{@$data['basic']->joining_date}}" disabled>
                                </td>
                             </tr>
                             <tr>
                              <th>CTC:</th>
                                <td>
                                   <input type="number" name="ctc" class="form-control" id="ctc" value="{{@$data['detail']->ctc}}">
                                </td>
                             </tr>
                             <tr>
                              <th>CIH:</th>
                                <td>
                                   <input type="number" name="cih" class="form-control" id="cih"  value="{{@$data['detail']->cih}}" >
                                </td>
                             </tr>
                            <tr>
                               <th>Incentives:</th>
                               <td>
                                 <input type="radio" name="incentives" id="incentives_yes" value="Yes" > 
                                 <label for="incentives_yes">Yes</label>&nbsp;&nbsp;
                                 <input type="radio" name="incentives" id="incentives_no" value="No" >
                                 <label for="incentives_no">No</label>
                               </td>
                             </tr>
                             <tr>
                               <th>OFFER LETTER:</th>
                               <td>
                                 <input type="radio" name="offer_letter" id="offer_letter_yes" value="Yes">
                                 <label for="offer_letter_yes">Yes</label>&nbsp;&nbsp;
                                 <input type="radio" name="offer_letter" id="offer_letter_no" value="No">
                                 <label for="offer_letter_no">No</label>
                               </td>
                             </tr>
                             <tr>
                               <th>ID CARD:</th>
                               <td>
                                 <input type="radio" name="id_card" id="id_card_yes" value="Yes">
                                 <label for="id_card_yes">Yes</label>&nbsp;&nbsp;
                                 <input type="radio" name="id_card" id="id_card_no" value="No">
                                 <label for="id_card_no">No</label>
                               </td>
                             </tr>
                             <tr>
                               <th>ESI / GPA (immediate)/<br>GHI (After 2 months):</th>
                               <td>
                                 <input type="radio" name="esi_gpa_ghi" id="esi" value="ESI">
                                 <label for="esi">ESI</label>&nbsp;&nbsp;
                                 <input type="radio" name="esi_gpa_ghi" id="gpa" value="GPA">
                                 <label for="gpa">GPA</label>&nbsp;&nbsp;
                                 <input type="radio" name="esi_gpa_ghi" id="ghi" value="GHI">
                                 <label for="ghi">GHI</label>
                                   <input type="radio" name="esi_gpa_ghi" id="na" value="NA">
                                 <label for="na">NA</label>
                               </td>
                             </tr>
                             <tr>
                               <th>EPF:</th>
                               <td>
                                 <input type="radio" name="epf" id="epf_yes" value="Yes">
                                 <label for="epf_yes">Yes</label>&nbsp;&nbsp;
                                 <input type="radio" name="epf" id="epf_not_applicable" value="Not Applicable">
                                 <label for="epf_not_applicable">Not Applicable</label>
                               </td>
                             </tr>
                             <tr>
                               <th>ERP LOGIN:</th>
                               <td>
                                 <input type="radio" name="erp_login" id="erp_login_yes" value="Yes">
                                 <label for="erp_login_yes">Yes</label>&nbsp;&nbsp;
                                 <input type="radio" name="erp_login" id="erp_login_not_applicable" value="Not Applicable">
                                 <label for="erp_login_not_applicable">Not Applicable</label>
                               </td>
                             </tr>
                             <tr>
                               <th>ADDITION IN COMPANY GROUPS:</th>
                               <td>
                                 <input type="radio" name="addition_in_company_group" id="add_in_cg_yes" value="Yes">
                                 <label for="add_in_cg_yes">Yes</label>&nbsp;&nbsp;
                                 <input type="radio" name="addition_in_company_group" id="add_in_cg_not_applicable" value="Not Applicable">
                                 <label for="add_in_cg_not_applicable">Not Applicable</label>
                               </td>
                             </tr>
                             <tr>
                               <th>TRAINING PERIOD(IN MONTHS)<br>(IF HIRED AS TRAINEE):</th>
                               <td>
                                 <input type="text" name="training_period" id="" class="form-control basic-detail-input-style" placeholder="Enter Training Period here" value="{{ @$data['detail']->training_period }}">
                               </td>
                             </tr>
                             <tr>
                               <th>PROBATION PERIOD:</th>
                               <td>
                                 <select class="form-control basic-detail-input-style regis-input-field" name="probation_period" id="probation_period">
                                    @if(!$data['probation_period']->isEmpty())
                                @foreach($data['probation_period'] as $probation)  
                                  <option value="{{$probation->no_of_days}}" @if(in_array($probation->no_of_days,@$data['save_probation_period'])){{"selected"}} @else{{""}}@endif
                                    >{{$probation->no_of_days}}</option>
                                @endforeach
                              @endif  
                                  </select>
                               </td>
                             </tr>
                             <tr>
                               <th>SECURITY:</th>
                               <td>
                                 <input type="radio" class="security1" name="security" id="security_yes" value="Yes">
                                 <label for="security_yes">Yes</label>&nbsp;&nbsp;
                                 <input type="radio" class="security1" name="security" id="security_no" value="No">
                                 <label for="security_no">No</label>
                               </td>
                             </tr>

                             <tr class="security_amount_field">
                              <th>Security Amount</th>
                              <td>
                                 <input type="text" name="security_amount" id="" class="form-control basic-detail-input-style" placeholder="Enter Security Amount here" value="{{ @$data['detail']->security_amount  }}">
                              </td>
                             </tr>
                             <tr>
                               <th>SECURITY CHEQUE:</th>
                               <td>
                                 <input type="radio" class="security2" name="security_cheque" id="security_cheque_yes" value="Yes">
                                 <label for="security_cheque_yes">Yes</label>&nbsp;&nbsp;
                                 <input type="radio" class="security2" name="security_cheque" id="security_cheque_no" value="No">
                                 <label for="security_cheque_no">No</label>
                               </td>
                             </tr>
                             <tr class="security_cheque_fields">
                              <th>Security Cheque Number:</th>
                              <td>
                                 <input type="number" name="security_cheque_number" id="" class="form-control basic-detail-input-style" value="{{ @$data['detail']->security_cheque_number }}">
                              </td>
                             </tr>
                             <tr class="security_cheque_fields">
                              <th>Bank Name:</th>
                              <td>
                                 <select name="bank_name" id="" class="form-control basic-detail-input-style">
                                    <option value="" selected disabled>Select Bank Name</option>
                                    <option value="Bank Name 1">Bank Name 1</option>
                                    <option value="Bank Name 2">Bank Name 2</option>
                                    <option value="Bank Name 3">Bank Name 3</option>
                                 </select>
                              </td>
                             </tr>
                             <tr>
                              <th>LEAVE MODULE:</th>
                              <td>
                                 <select name="leave_module" id="" class="form-control basic-detail-input-style">
                                    <option value="" selected disabled>Select Leave Module</option>
                                    <option value="Leave Module 1">Leave Module 1</option>
                                    <option value="Leave Module 2">Leave Module 2</option>
                                    <option value="Leave Module 3">Leave Module 3</option>
                                 </select>
                              </td>
                             </tr>
                           </table>
                           <h2 class="heading2">IT</h2>
                           <table class="table table-striped table-responsive">
                              <tr>
                                 <th>SIM CARD:</th>
                                 <td>
                                    <input type="radio" name="sim_card" id="sim_card_yes" value="Yes">
                                    <label for="sim_card_yes">Yes</label>&nbsp;&nbsp;
                                    <input type="radio" name="sim_card" id="sim_card_not_applicable" value="Not-Applicable">
                                    <label for="sim_card_not_applicable">Not Applicable</label>
                                 </td>
                              </tr>
                              <tr>
                                 <th>LAPTOP / PC:</th>
                                 <td>
                                    <input type="radio" name="laptop_or_pc" id="laptop" value="Laptop">
                                    <label for="laptop">Laptop</label>&nbsp;&nbsp;
                                    <input type="radio" name="laptop_or_pc" id="pc" value="PC">
                                    <label for="pc">PC</label>&nbsp;&nbsp;
                                    <input type="radio" name="laptop_or_pc" id="lapto_pc_not_applicable" value="Not-Applicable">
                                    <label for="lapto_pc_not_applicable">Not Applicable</label>
                                 </td>
                              </tr>
                              <tr>
                                 <th>MAIL ID:</th>
                                 <td>
                                    <input type="radio" name="mail_id" id="xeam" value="XEAM">
                                    <label for="xeam">Xeam</label>&nbsp;&nbsp;
                                    <input type="radio" name="mail_id" id="gmail" value="GMAIL">
                                    <label for="gmail">GMAIL</label>&nbsp;&nbsp;
                                    <input type="radio" name="mail_id" id="mail_id_not_applicable" value="Not-Applicable">
                                    <label for="mail_id_not_applicable">Not Applicable</label>
                                 </td>
                              </tr>
                           </table>
                           <h2 class="heading2">ADMIN</h2>
                           <table class="table table-striped table-responsive">
                              <tr>
                                 <th>VISITING CARD:</th>
                                 <td>
                                    <input type="radio" name="visiting_card" id="visiting_card_yes" value="Yes">
                                    <label for="visiting_card_yes">Yes</label>&nbsp;&nbsp;
                                    <input type="radio" name="visiting_card" id="visiting_card_not_applicable" value="Not-Applicable">
                                    <label for="visiting_card_not_applicable">Not Applicable</label>
                                 </td>
                              </tr>
                              <tr>
                                 <th>UNIFORM:</th>
                                 <td>
                                    <input type="radio" name="uniform" id="uniform_yes" value="Yes">
                                    <label for="uniform_yes">Yes</label>&nbsp;&nbsp;
                                    <input type="radio" name="uniform" id="uniform_not_applicable" value="Not-Applicable">
                                    <label for="uniform_not_applicable">Not Applicable</label>
                                 </td>
                              </tr>
                           </table>
                           <p><b>Note:</b> <i>No Leave allowed during probation / training period.</i></p>
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
$("#jrf_final_approval").validate({
  rules: {
   "incentives" : {
     required: true
   },
    "ctc" : {
     required: true
   },
    "cih" : {
     required: true
   },
   "offer_letter" : {
     required: true
   },
   "id_card" : {
     required: true
   },
   "esi_gpa_ghi" : {
     required: true
   },
   "epf" : {
     required: true
   },
   "erp_login" : {
     required: true
   },
   "addition_in_company_group" : {
     required: true
   },
   "probation_period" : {
      required : true
   },
   "security" : {
      required : true
   },
   "security_amount" : {
      required : true
   },
   "security_cheque" : {
      required : true
   },
   "security_cheque_number" : {
      required : true
   },
   "bank_name" : {
      required : true
   },
   "leave_module" : {
      required : true
   },
   "sim_card" : {
      required : true
   },
   "laptop_or_pc" : {
      required : true
   },
   "mail_id" : {
      required : true
   },
   "visiting_card" : {
      required : true
   },
   "uniform" : {
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
   "incentives" : {
     required: 'Please select any option'
   },
   "ctc" : {
     required: 'Field is required'
   },
   "cih" : {
     required: 'Field is required'
   },
   "offer_letter" : {
     required: 'Please select any option'
   },
   "id_card" : {
     required: 'Please select any option'
   },
   "esi_gpa_ghi" : {
     required: 'Please select any option'
   },
   "epf" : {
     required: 'Please select any option'
   },
   "erp_login" : {
     required: 'Please select any option'
   },
   "addition_in_company_group" : {
     required: 'Please select any option'
   },
   "probation_period" : {
      required : 'Enter Probation Period'
   },
   "security" : {
      required : 'Please select any option'
   },
   "security_amount" : {
      required : 'Please enter security amount'
   },
   "security_cheque" : {
      required : 'Please select any option'
   },
   "security_cheque_number" : {
      required : 'Please enter security cheque number'
   },
   "bank_name" : {
      required : 'Select any bank'
   },
   "leave_module" : {
      required : 'Select any option'
   },
   "sim_card" : {
      required : 'Please select any option'
   },
   "laptop_or_pc" : {
      required : 'Please select any option'
   },
   "mail_id" : {
      required : 'Please select any option'
   },
   "visiting_card" : {
      required : 'Please select any option'
   },
   "uniform" : {
      required : 'Please select any option'
   }
  }
});
</script>

<script>
$(document).ready(function(){

   /*To Show security amount text field starts here*/
   $(".security1").on('click',function(){
      var np_value = $(this).val();
      if(np_value == "Yes") {
         $(".security_amount_field").show();
      }
      else {
         $(".security_amount_field").hide();
      }
   });
   /*To Show security amount text field ends here*/

   /*To Show security cheque Number and bank name text field starts here*/
   $(".security2").on('click',function(){
      var np_value = $(this).val();
      if(np_value == "Yes") {
         $(".security_cheque_fields").show();
      }
      else {
         $(".security_cheque_fields").hide();
      }
   });
   /*To Show security cheque Number and bank name text field ends here*/
   



    
    var incentives = "{{@$data['detail']->incentives}}"
    if(incentives == "Yes"){
      $("#incentives_yes").prop("checked", true);
    } else{
      $("#incentives_no").prop("checked", true);
    }

    var offer_letter = "{{@$data['detail']->offer_letter}}"
    if(offer_letter == "Yes"){
      $("#offer_letter_yes").prop("checked", true);
    } else{
      $("#offer_letter_no").prop("checked", true);
    }

    var id_card = "{{@$data['detail']->id_card}}"
    if(id_card == "Yes"){
      $("#id_card_yes").prop("checked", true);
    } else{
      $("#id_card_no").prop("checked", true);
    }

   var esi_gpa_ghi = "{{@$data['detail']->esi_gpa_ghi}}"
    if(esi_gpa_ghi == "ESI"){
      $("#esi").prop("checked", true);
    } else if(esi_gpa_ghi == 'GPA'){
      $("#gpa").prop("checked", true);
    }else if(esi_gpa_ghi == 'GHI'){
      $("#ghi").prop("checked", true);      
    }else{
      $("#na").prop("checked", true);      
    }
  
  var epf = "{{@$data['detail']->epf}}"
    if(epf == "Yes"){
      $("#epf_yes").prop("checked", true);
    } else{
      $("#epf_not_applicable").prop("checked", true);
    }

    var erp_login = "{{@$data['detail']->erp_login}}"
    if(erp_login == "Yes"){
      $("#erp_login_yes").prop("checked", true);
    } else{
      $("#erp_login_not_applicable").prop("checked", true);
    }

    var addition_in_company_group = "{{@$data['detail']->addition_in_company_group}}"
    if(addition_in_company_group == "Yes"){
      $("#add_in_cg_yes").prop("checked", true);
    } else{
      $("#add_in_cg_not_applicable").prop("checked", true);
    } 

    var security = "{{@$data['detail']->security}}"
    if(security == "Yes"){
      $("#security_yes").prop("checked", true);
      $(".security_amount_field").show();
    } else{
      $("#security_no").prop("checked", true);
    } 

    var security_cheque = "{{@$data['detail']->security_cheque}}"
    if(security_cheque == "Yes"){
      $("#security_cheque_yes").prop("checked", true); 
      $(".security_cheque_fields").show();
    } else{
      $("#security_cheque_no").prop("checked", true);
    }

    var sim_card = "{{@$data['detail']->addition_in_company_group}}"
    if(sim_card == "Yes"){
      $("#sim_card_yes").prop("checked", true);
    } else{
      $("#sim_card_not_applicable").prop("checked", true);
    } 

    var laptop_or_pc = "{{@$data['detail']->laptop_or_pc}}"
    if(laptop_or_pc == "Laptop"){
      $("#laptop").prop("checked", true);
    } else if(laptop_or_pc == 'PC'){
      $("#pc").prop("checked", true);
    }else{
      $("#lapto_pc_not_applicable").prop("checked", true);      
    }


    var mail_id  = "{{@$data['detail']->mail_id }}"
    if(mail_id  == "XEAM"){
      $("#xeam").prop("checked", true);
    } else if(esi_gpa_ghi == 'GMAIL'){
      $("#gmail").prop("checked", true);
    }else{
      $("#mail_id_not_applicable").prop("checked", true);      
    }

    var visiting_card = "{{@$data['detail']->visiting_card}}"
    if(visiting_card == "Yes"){
      $("#visiting_card_yes").prop("checked", true);
    } else{
      $("#visiting_card_not_applicable").prop("checked", true);
    }

    var uniform = "{{@$data['detail']->uniform}}"
    if(uniform == "Yes"){
      $("#uniform_yes").prop("checked", true);
    } else{
      $("#uniform_not_applicable").prop("checked", true);
    }

});
</script>
@endsection