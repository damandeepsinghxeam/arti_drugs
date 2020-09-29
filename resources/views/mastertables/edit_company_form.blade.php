@extends('admins.layouts.app')

@section('content')


<!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>

        {{"Edit Company"}}

        <!-- <small>Control panel</small> -->

      </h1>

      <ol class="breadcrumb">

        <li><a href="{{ url('employees/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>

        <li><a href="{{ url('mastertables/companies') }}">Companies List</a></li> 

      </ol>

    </section>



    <!-- Main content -->

    <section class="content">

      <!-- Small boxes (Stat box) -->

      <div class="row">

          <div class="col-sm-12">

           <div class="box box-primary">

                @include('admins.validation_errors')

            <div class="box-header with-border leave-form-title-bg">

              <h3 class="box-title">Form</h3>

            </div>

            <!-- /.box-header -->

            <!-- form start -->

            <form id="registerCompanyForm" action="{{ url('mastertables/edit-company') }}" method="POST">

              {{ csrf_field() }}

              <div class="box-body">

                <div class="row">

                <div class="col-sm-6">

                <div class="form-group">

                  <label for="companyName">Company Name</label>

                  <input type="text" class="form-control" id="companyName" name="company_name" placeholder="Company Name" value="{{@$data['company']->name}}">

                  <span class="compNameError"></span>

                </div>

                <div class="form-group">

                  <label for="companyAddress">Company Address</label>

                  <input type="text" class="form-control" id="companyAddress" name="company_address" placeholder="Company Address" value="{{@$data['company']->address}}">

                </div>

                <div class="form-group">

                  <label for="companyPhone">Company Phone Number</label>

                  <input type="text" class="form-control" id="companyPhone" name="company_phone_number" placeholder="Company Phone Number" value="{{@$data['company']->phone}}">

                  <span class="compPhoneError"></span>

                </div>

                <div class="form-group">

                  <label for="companyPhone">Company Phone Number Extension</label>

                  <input type="text" class="form-control" id="companyPhoneExtn" name="company_phone_extension" placeholder="Company Phone Number Extension" value="{{@$data['company']->phone_extension}}">

                </div>

                <div class="form-group">

                  <label for="companyPfAcc">Company PF Account Number</label>

                  <input type="text" class="form-control" id="companyPfAcc" name="pf_account_number" placeholder="PF Account Number" value="{{@$data['company']->pf_account_number}}">

                  <span class="compPfError"></span>

                </div>

                <div class="form-group">

                  <label for="extn">Extension</label>

                  <input type="text" class="form-control" id="extn" name="extension" placeholder="Extension" value="{{@$data['company']->extension}}">

                </div>

              </div>  <!-- /.col --> 

              <div class="col-sm-6">

                <div class="form-group">

                  <label for="dbfFileCode">DBF File Code</label>

                  <input type="text" class="form-control" id="dbfFileCode" name="dbf_file_code" placeholder="DBF File Code" value="{{@$data['company']->dbf_file_code}}">

                </div>

                <div class="form-group">

                  <label for="tanNo">TAN Number</label>

                  <input type="text" class="form-control" id="tanNo" name="tan_number" placeholder="TAN Number" value="{{@$data['company']->tan_number}}">

                  <span class="compTanError"></span>

                </div>

                <div class="form-group">

                  <label for="companyEmail">Company Email</label>

                  <input type="text" class="form-control" id="companyEmail" name="company_email" placeholder="Company Email" value="{{@$data['company']->email}}">

                  <span class="compEmailError"></span>

                </div>

                <div class="form-group">

                  <label for="companyWebsite">Company Website</label>

                  <input type="text" class="form-control" id="companyWebsite" name="company_website" placeholder="Company Website" value="{{@$data['company']->website}}">

                </div>

                <div class="form-group">

                  <label for="responsiblePerson">Responsible Person</label>

                  <input type="text" class="form-control" id="responsiblePerson" name="responsible_person" placeholder="Responsible Person" value="{{@$data['company']->responsible_person}}">

                </div>

                <input type="hidden" name="action" value="{{$data['action']}}">

                @if(!empty(@$data['company']))

                  <input type="hidden" name="company_id" value="{{$data['company']->id}}">

                @endif

              </div>  <!-- /.col --> 

              </div>     <!-- /.row -->  

              </div>

              <!-- /.box-body -->

              <div class="box-footer">

                <button type="button" class="btn btn-primary" id="registerCompanyFormSubmit">Submit</button>

              </div>

            </form>

          </div>

      </div>

          <!-- /.box -->

      </div>

      <!-- /.row -->

      <!-- Main row -->

    </section>

    <!-- /.content -->

  </div>

  <!-- /.content-wrapper -->

  <script src="{{asset('public/admin_assets/plugins/validations/jquery.validate.js')}}"></script>

  <script src="{{asset('public/admin_assets/plugins/validations/additional-methods.js')}}"></script>

  <script>

    $("#registerCompanyForm").validate({

      rules :{

          "company_name" : {

              required : true,

              maxlength: 40,

              alphanumericWithSpace : true

          },

           "company_phone_number" : {

              required : true,              

              minlength : 10,

              maxlength : 12,

              digitHifun : true

          },

         

          "company_Address" : {

              required : true,

          },

          

          "company_Email" : {

              required : true,

              email: true

          },

          "dbf_file_code" : {

            digitonly : true

          },

          "pf_account_number" : {

              required : true,

              PFAccount : true

          },
          "tan_number" : {

              required : true,

              alphanumeric : true

          }

      },

      messages :{

          "companyName" : {

              required : 'Please enter company name.',

              maxlength: 'Maximum 40 characters are allowed.'

          },

          "companyAddress" : {

              required : 'Please enter company address.'

          },

          "companyPhone" : {

              required : 'Please enter company phone number.',

              minlength : 'Please enter minlength 10 (only Digits)',

              maxlength : 'Please enter maxlength 12 (Digits and -)'

          },

          

          "companyEmail" : {

              required : 'Please enter company email.',

          },

          "companyWebsite" :{

            url : 'Please enter full website url with http:// or https://.'

          },

          "companyPfAcc" : {

              required : 'Please enter company pf account number.',

          },

          "tanNo" : {

              required : 'Please enter TAN number.',

              required : 'Please enter only alphanumeric value.',

          }

      }

    });



   $.validator.addMethod("digitonly", function(value, element) {

    return this.optional(element) || /^[0-9- ]+$/i.test(value);

    }, "Please enter only digits");



    $.validator.addMethod("alphanumeric", function(value, element) {

    return this.optional(element) || /^[a-zA-Z-]+[0-9-]+[a-zA-Z-]+$/i.test(value);

    }, "Please enter only alphanumeric value.");



    $.validator.addMethod("PFAccount", function(value, element) {

    return this.optional(element) || /^[a-zA-Z]+[/]+[a-zA-Z]+[/]+[0-9]+$/i.test(value);

    }, "Please enter Region/Sub-regional Office code/employer PF registration code/EPF account number.");



   $.validator.addMethod("digitHifun", function(value, element) {

    return this.optional(element) || /^[0-9- ]+$/i.test(value);

    }, "Please enter only digits and -.");



   $.validator.addMethod("alphanumericWithSpace", function(value, element) {

    return this.optional(element) || /^[A-Za-z][A-Za-z. \d]*$/i.test(value);

    }, "Please enter only alphanumeric value.");



   $.validator.addMethod("email", function(value, element) {

    return this.optional(element) || /^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$/i.test(value);

    }, "Please enter a valid email address.");



   $.validator.addMethod("lettersonly", function(value, element) {

    return this.optional(element) || /^[a-z," "]+$/i.test(value);

    }, "Please enter only alphabets and spaces.");





  </script>



  <script type="text/javascript">

    var allowFormSubmit = {company: 1, pt: 1, esi: 1};

    $(".checkCompany").on('keyup',function(){

      var companyName = $("#companyName").val();
      var companyPhone = $("#companyPhone").val();
      var companyPfAcc = $("#companyPfAcc").val();
      var tanNo = $("#tanNo").val();
      var companyEmail = $("#companyEmail").val();

      $.ajax({
        type: 'POST',
        url: "{{ url('mastertables/check-unique-company') }}",
        data: {company_name: companyName, company_phone: companyPhone, company_pf_acc: companyPfAcc, tan_no: tanNo, company_email: companyEmail},

        success: function (result) {

          console.log(result);

          if(result.company_name == 0){
            $(".compNameError").text("Company name already exists.").css("color","#f00");
          }else{
            $(".compNameError").text("");
          }

          if(result.company_phone == 0){
            $(".compPhoneError").text("Company phone number already exists.").css("color","#f00");
          }else{
            $(".compPhoneError").text("");
          }

          if(result.company_pf_acc == 0){
            $(".compPfError").text("Company pf account number already exists.").css("color","#f00");
          }else{
            $(".compPfError").text("");
          }

          if(result.tan_no == 0){
            $(".compTanError").text("Company tan number already exists.").css("color","#f00");
          }else{
            $(".compTanError").text("");
          }

          if(result.company_email == 0){
            $(".compEmailError").text("Company email already exists.").css("color","#f00");
          }else{
            $(".compEmailError").text("");
          }

          if(result.company_name == 1 && result.company_phone == 1 && result.company_pf_acc == 1 && result.tan_no == 1 && result.company_email == 1){

            allowFormSubmit.company = 1;

          }else{

            allowFormSubmit.company = 0;

          }

        }

      });

    });   

    $("#registerCompanyFormSubmit").on('click',function(){

     if(allowFormSubmit.pt == 0 || allowFormSubmit.esi == 0 || allowFormSubmit.company == 0){

        return false;

     }else{

        $("#registerCompanyForm").submit();

     } 

    });

  </script>

  @endsection