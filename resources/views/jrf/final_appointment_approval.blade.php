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
      <h1>FINAL APPROVAL OF APPOINTMENT</h1>
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
              <form id="jrf_final_approval" method="POST" action="{{url('jrf/save-final-appointment-approval')}}" enctype="multipart/form-data">
                {{ csrf_field() }}
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
                               <th>Candidate Name</th>
                                 <td>
                                   <input type="text" name="" value="{{@$data['basic']->c_name}}" id="" class="form-control basic-detail-input-style" disabled>
                                 </td>
                             </tr>

                             <tr>
                               <th>Current Designation</th>
                                 <td>
                                   <input type="text" name="" value="{{@$data['basic']->c_designation}}" id="" class="form-control basic-detail-input-style" disabled>
                                 </td>
                             </tr>

                             <tr>
                               <th>Previous Company Annual CIH (INR Lakhs)</th>
                               <td>
                                 <input type="number" name="" value="{{@$data['basic']->current_ctc}}" id="" class="form-control basic-detail-input-style" placeholder="Entered Value Here" disabled>
                                 <input type="hidden" value="{{Auth::id()}}" name="user_id">
                                 <input type="hidden" value="{{$data['basic']->jlosid}}" name="jrf_level_one_screening_id">
                                 <input type="hidden" value="{{$data['basic']->id}}" name="jrf_id">
                                 <input type="hidden" value="{{$data['basic']->uid}}" name="uid">

                                 <input type="hidden" value="1" name="appointed_status">

                               </td>
                             </tr>
                             <tr>
                               <th>Previous Company Annual CIH (INR Lakhs)</th>
                                 <td>
                                   <input type="number" name="" value="{{@$data['basic']->current_cih}}" id="" class="form-control basic-detail-input-style" placeholder="Entered Value Here" disabled>
                                 </td>
                             </tr>
                             
                             <tr>
                              <th>Current Annual CTC (INR Lakhs)<sup class="ast">*</sup></th>
                                <td>
                                   <input type="number" name="ctc" class="form-control" id="ctc" value="">
                                </td>
                             </tr>
                             <tr>
                              <th>Current Annual CIH (INR Lakhs)<sup class="ast">*</sup></th>
                                <td>
                                   <input type="number" name="cih" class="form-control" id="cih"  value="">
                                </td>
                             </tr>
                             <tr>
                               <th>Incentives<sup class="ast">*</sup></th>
                               <td>
                                 <input type="radio" name="incentives" id="incentives_yes" value="Yes">
                                 <label for="incentives_yes">Yes</label>&nbsp;&nbsp;
                                 <input type="radio" name="incentives" id="incentives_no" value="No">
                                 <label for="incentives_no">No</label>
                               </td>
                             </tr>
                             <tr>
                               <th>OFFER LETTER<sup class="ast">*</sup></th>
                               <td>
                                 <input type="radio" name="offer_letter" id="offer_letter_yes" value="Yes">
                                 <label for="offer_letter_yes">Yes</label>&nbsp;&nbsp;
                                 <input type="radio" name="offer_letter" id="offer_letter_no" value="No">
                                 <label for="incentives_no">No</label>
                               </td>
                             </tr>
                             <tr>
                               <th>ID CARD<sup class="ast">*</sup></th>
                               <td>
                                 <input type="radio" name="id_card" id="id_card_yes" value="Yes">
                                 <label for="id_card_yes">Yes</label>&nbsp;&nbsp;
                                 <input type="radio" name="id_card" id="id_card_no" value="No">
                                 <label for="id_card_no">No</label>
                               </td>
                             </tr>
                             <tr>
                               <th>ESI / GPA (immediate)/<br>GHI (After 2 months)<sup class="ast">*</sup></th>
                               <td>
                                 <input type="radio" name="esi_gpa_ghi" id="esi" value="ESI">
                                 <label for="esi">ESI</label>&nbsp;&nbsp;
                                 <input type="radio" name="esi_gpa_ghi" id="gpa" value="GPA">
                                 <label for="gpa">GPA</label>&nbsp;&nbsp;
                                 <input type="radio" name="esi_gpa_ghi" id="ghi" value="GHI">
                                 <label for="ghi">GHI</label>&nbsp;&nbsp;
                                 <input type="radio" name="esi_gpa_ghi" id="na" value="NA">
                                 <label for="na">NA</label>
                               </td>
                             </tr>
                             <tr>
                               <th>EPF<sup class="ast">*</sup></th>
                               <td>
                                 <input type="radio" name="epf" id="epf_yes" value="Yes">
                                 <label for="epf_yes">Yes</label>&nbsp;&nbsp;
                                 <input type="radio" name="epf" id="epf_not_applicable" value="Not Applicable">
                                 <label for="epf_not_applicable">Not Applicable</label>
                               </td>
                             </tr>
                             <tr>
                               <th>ERP LOGIN<sup class="ast">*</sup></th>
                               <td>
                                 <input type="radio" name="erp_login" id="erp_login_yes" value="Yes">
                                 <label for="erp_login_yes">Yes</label>&nbsp;&nbsp;
                                 <input type="radio" name="erp_login" id="erp_login_not_applicable" value="Not Applicable">
                                 <label for="erp_login_not_applicable">Not Applicable</label>
                               </td>
                             </tr>
                             <tr>
                               <th>ADDITION IN COMPANY GROUPS<sup class="ast">*</sup></th>
                               <td>
                                 <input type="radio" name="addition_in_company_group" id="add_in_cg_yes" value="Yes">
                                 <label for="add_in_cg_yes">Yes</label>&nbsp;&nbsp;
                                 <input type="radio" name="addition_in_company_group" id="add_in_cg_not_applicable" value="Not Applicable">
                                 <label for="add_in_cg_not_applicable">Not Applicable</label>
                               </td>
                             </tr>
                             <tr>
                               <th>TRAINING PERIOD(IN MONTHS) <br>(IF HIRED AS TRAINEE)</th>
                               <td>
                                 <input type="text" name="training_period" id="" class="form-control basic-detail-input-style" placeholder="Enter Training Period here">
                               </td>
                             </tr>
                             <tr>
                               <th>PROBATION PERIOD<sup class="ast">*</sup></th>
                               <td>
                                <select name="probation_period" id="probation_period" class="form-control basic-detail-input-style select2" data-placeholder="Enter Probation Period here">
                                    @if(!$data['probation_period']->isEmpty())
                                     @foreach($data['probation_period'] as $probation)  
                                     <option value="{{$probation->no_of_days}}">{{$probation->no_of_days}}</option>
                                     @endforeach
                                   @endif  
                                 </select>

                              
                               </td>
                             </tr>
                             <tr>
                               <th>SECURITY<sup class="ast">*</sup></th>
                               <td>
                                 <input type="radio" class="security1" name="security" id="security_yes" value="Yes">
                                 <label for="security_yes">Yes</label>&nbsp;&nbsp;
                                 <input type="radio" class="security1" name="security" id="security_no" value="No">
                                 <label for="security_no">No</label>
                               </td>
                             </tr>
                             <tr class="security_amount_field">
                              <th>Security Amount<sup class="ast">*</sup></th>
                              <td>
                                 <input type="text" name="security_amount" id="" class="form-control basic-detail-input-style" placeholder="Enter Security Amount here">
                              </td>
                             </tr>
                             <tr>
                               <th>SECURITY CHEQUE<sup class="ast">*</sup></th>
                               <td>
                                 <input type="radio" class="security2" name="security_cheque" id="security_cheque_yes" value="Yes">
                                 <label for="security_cheque_yes">Yes</label>&nbsp;&nbsp;
                                 <input type="radio" class="security2" name="security_cheque" id="security_cheque_no" value="No">
                                 <label for="security_cheque_no">No</label>
                               </td>
                             </tr>
                             <tr class="security_cheque_fields">
                              <th>Security Cheque Number<sup class="ast">*</sup></th>
                              <td>
                                 <input type="number" name="security_cheque_number" id="" class="form-control basic-detail-input-style">
                              </td>
                             </tr>
                             <tr class="security_cheque_fields">
                              <th>Bank Name<sup class="ast">*</sup></th>
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
                              <th>LEAVE MODULE<sup class="ast">*</sup></th>
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
                                 <th>SIM CARD<sup class="ast">*</sup></th>
                                 <td>
                                    <input type="radio" name="sim_card" id="sim_card_yes" value="Yes">
                                    <label for="sim_card_yes">Yes</label>&nbsp;&nbsp;
                                    <input type="radio" name="sim_card" id="sim_card_not_applicable" value="Not-Applicable">
                                    <label for="sim_card_not_applicable">Not Applicable</label>
                                 </td>
                              </tr>
                              <tr>
                                 <th>LAPTOP / PC<sup class="ast">*</sup></th>
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
                                 <th>MAIL ID<sup class="ast">*</sup></th>
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
                                 <th>VISITING CARD<sup class="ast">*</sup></th>
                                 <td>
                                    <input type="radio" name="visiting_card" id="visiting_card_yes" value="Yes">
                                    <label for="visiting_card_yes">Yes</label>&nbsp;&nbsp;
                                    <input type="radio" name="visiting_card" id="visiting_card_not_applicable" value="Not-Applicable">
                                    <label for="visiting_card_not_applicable">Not Applicable</label>
                                 </td>
                              </tr>
                              <tr>
                                 <th>UNIFORM<sup class="ast">*</sup></th>
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
   
});
</script>
@endsection