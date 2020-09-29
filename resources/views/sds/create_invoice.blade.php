@extends('admins.layouts.app')

@section('content')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="{{asset('public/js/bootstrap-tagsinput.js')}}"></script>
  <link rel="stylesheet" href="{{asset('public/css/bootstrap-tagsinput.css')}}">
<style type="text/css">
form#createInvoiceForm {
    margin-top: 15px;
}
input#sdsMobleNumber::-webkit-inner-spin-button, 
input#sdsMobleNumber::-webkit-outer-spin-button { 
  -webkit-appearance: none; 
  margin: 0; 
}
input#sdsContactPersonName {
    height: 34px;
}
select#sdsContactProjectName {
    height: 34px;
}
input#sdsStreetAddress {
    height: 34px;
}
input#sdsCityName {
    height: 34px;
    margin-right: 5px;
}
input#sdsStateName {
    height: 34px;
    width: 48%;
    float: right;
    margin-bottom: 15px;
}
input#sdsPinCode {
    height: 34px;
}
input#sdsMobleNumber {
    height: 34px;
}
select#sdsDocumentType {
    height: 34px;
}
button#sdsLinkToPrint {
    height: 34px;
    width: 14%;
    margin-left: 40px;
}
button#sdsViewFile {
    height: 34px;
    width: 10%;
    margin-left: 40px;
}
button#sdsRemoveFile {
    height: 34px;
    width: 10%;
    margin-left: 40px;
}
button#sdsDisplayLinkFile {
    height: 34px;
    float: right;
}
input#sdsDateOfSalary {
    height: 34px;
    margin-right: 15px;
}
input#sdsSalaryAmount {
    height: 34px;
    margin-right: 10px;
    margin-bottom: 15px;
}
span.sdsSalarySheet {
    vertical-align: -webkit-baseline-middle;
}
select#sdsServiceChargesMonth {
    height: 34px;
}
input#sdsServiceChargesAmount {
    height: 34px;
    margin-right: 10px;
    width: 48%;
    margin-bottom: 15px;
}
input#sdsSubTotal {
    height: 34px;
    margin-bottom: 15px;
}
label.col-md-3.subTotalLabel {
    margin-top: 8px;
}
.titlebox{
  position:absolute;
  top:-.6em;
  left:0;
  padding:.6em 0 .6em;
  width: 100%;
  height:2px;
  overflow:hidden;
  font-size:100%; /* any size */
  line-height:1.2; /* corresponds to the padding and margins used */
}
.titlebox span{
  float:left;
  border:solid #999;
  border-width:0 99em 0 30px;
  height:2px;
}
.titlebox b{
  position:relative;
  display:block;
  margin:-1.2em 0 -.6em;
  padding:.6em 5px 0;
  font-weight:600;
  width: 121px;
}
.col-sm-6.sdsInvoice {
    margin-top: 18px;
}
.col-sm-6.sdsServiceMonth {
    margin-top: 18px;
}
.performaInvoice {
    border: solid #999;
    border-width: 0 2px 2px;
    padding-top: 1px;
    position: relative;
    width: 94%;
    margin-left: 31px;
}
.col-sm-12.sdsInvoice {
    margin-top: 18px;
}
input#sdsSalarySameAsExcel {
    height: 34px;
    width: 37%;
    margin-bottom: 15px;
}
a#addOtherField {
    font-size: 24px;
    margin-top: 5px;
}
a#deleteOtherField {
    font-size: 25px;
    margin-top: 4px;
}
input.col-sm-3.sdsDateOfSalaryAdd {
    height: 34px;
    margin-bottom: 15px;
    margin-right: 15px;
}
input.col-sm-3.sdsSalaryAmountAdd {
    height: 34px;
    margin-bottom: 15px;
    margin-right: 10px;
}
input.col-sm-4.sdsSalarySameAsExcelAdd {
    height: 34px;
    width: 30%;
    margin-bottom: 15px;
}
.col-sm-6.amountCalculation {
    padding-left: 0px;
}
label.col-md-1.sdssub {
    padding: 0px;
    margin-top: 7px;
}
input#sdsSubTotalAmount {
    height: 34px;
    margin-bottom: 15px;
    width: 80%;
}
input#sdsSubTotalAmount::-webkit-inner-spin-button, 
input#sdsSubTotalAmount::-webkit-outer-spin-button { 
  -webkit-appearance: none; 
  margin: 0; 
}
select#sdsServiceChargeType {
    height: 34px;
    margin-bottom: 15px;
    width: 35%;
    margin-left: 31px;
}
input#amountOfGstCharges {
    height: 34px;
    margin-left: 14px;
    width: 37%;
    margin-bottom: 15px;
}
input#amountOfGstCharges::-webkit-inner-spin-button, 
input#amountOfGstCharges::-webkit-outer-spin-button { 
  -webkit-appearance: none; 
  margin: 0; 
}
.col-sm-12.amountCalculationTotal {
    padding-left: 0px;
}
input#sdsTotalAmountCalculation {
    height: 34px;
    margin-bottom: 15px;
}
input#sdsTotalAmountCalculation::-webkit-inner-spin-button, 
input#sdsTotalAmountCalculation::-webkit-outer-spin-button { 
  -webkit-appearance: none; 
  margin: 0; 
}
label.col-md-2.sdsTotalAmountCal {
    margin-top: 7px;
    padding: 0px;
    width: 101px;
    /* margin-right: -58px; */
}
input#totalAmountCalculation {
    height: 34px;
    margin-left: 13px;
    width: 54%;
}
a#addTaxSlab {
    font-size: 24px;
    margin-top: 5px;
}
.col-sm-6.chargesSds {
    padding-left: 0px;
}
label.col-md-2.sdssub {
    padding: 0px;
    margin-top: 7px;
}
</style>
<!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>
        Create Invoice
        <!-- <small>Control panel</small> -->
      </h1>

      <ol class="breadcrumb">
        <li><a href="{{ url('employees/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
      </ol>

    </section>



    <!-- Main content -->

    <section class="content">
      <!-- Small boxes (Stat box) -->

      <div class="row">
        <div class="col-sm-12">
          <div class="box box-primary">

            <!-- form start -->

            <form id="createInvoiceForm" action="{{ url('sds/create-invoice') }}" method="POST">
              <div class="form-group">
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="col-sm-6">
                        <input type="text" name="sdsContactPersonName" id="sdsContactPersonName" class="col-md-12 sdsContactPersonName" placeholder="Name Of Contact Person.">
                      </div>
                      <div class="col-sm-6">
                        <select class="col-md-12 sdsContactProjectName" name="sdsContactProjectName" id="sdsContactProjectName">
                          <option value="" selected disabled>Please Select Project Name.</option>
                          <option value="XEAM HO">XEAM HO</option>
                          <option value="UNDP">UNDP</option>
                          <option value="LEHRI">LEHRI</option>
                        </select> 
                      </div>
                    </div>
                  </div>
              </div>
              <div class="form-group">
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="col-sm-6">
                        <input type="text" name="sdsStreetAddress" id="sdsStreetAddress" class="col-md-12 sdsStreetAddress" placeholder="Please Enter Street Address">
                      </div>
                      <div class="col-sm-6">
                        <input type="text" name="sdsCityName" id="sdsCityName" class="col-md-6 sdsCityName" placeholder="City Name">
                        <input type="text" name="sdsStateName" id="sdsStateName" class="col-md-6 sdsStateName" placeholder="State Name">
                       <!--  <input type="text" name="sdsPinCode" id="sdsPinCode" class="col-md-4 sdsPinCode" placeholder="Pin Code">
                      </div> -->
                    </div>
                  </div>
              </div>
              <div class="form-group">
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="col-sm-6">
                        <input type="text" name="sdsPinCode" id="sdsPinCode" class="col-md-12 sdsPinCode" placeholder="Pin Code">
                      </div>
                      <div class="col-sm-6">
                        <input type="number" name="sdsMobleNumber" id="sdsMobleNumber" class="col-md-12 sdsMobleNumber" placeholder="Mobile / Phone Number">
                      </div>
                    </div>
                  </div>
              </div>
              <div class="form-group">
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="col-sm-12">
                        <select class="col-md-4 sdsDocumentType" name="sdsDocumentType" id="sdsDocumentType">
                          <option value="" selected disabled>Please Select Document Type.</option>
                          <option value="XEAM HO">XEAM HO</option>
                          <option value="UNDP">UNDP</option>
                          <option value="LEHRI">LEHRI</option>
                        </select> 
                        <button class="col-md-2 sdsLinkToPrint" id="sdsLinkToPrint" name="sdsLinkToPrint">Link to Print</button>
                        <button class="col-md-2 sdsViewFile" id="sdsViewFile" name="sdsViewFile">View</button>
                        <button class="col-md-2 sdsRemoveFile" id="sdsRemoveFile" class="sdsRemoveFile">Remove</button>
                        <button class="col-md-2 sdsDisplayLinkFile" id="sdsDisplayLinkFile" name="sdsDisplayLinkFile">Display Linked File</button>
                      </div>
                    </div>
                  </div>
              </div>
              <div class="form-group">
                  <div class="row">
                    <div class="col-sm-12 performaInvoice">
                      <div class="titlebox"><span><b>Performa Invoice</b></span></div>
                      <div class="col-sm-12 sdsInvoice">
                        <div class="sdsSalaryDetals" id="sdsSalaryDetals">
                            <input type="text" name="sdsDateOfSalary[]" id="sdsDateOfSalary" class="col-md-3 sdsDateOfSalary" placeholder="Select Month of Salary">
                             <input type="text" name="sdsSalaryAmount[]" class="col-md-3 sdsSalaryAmount" id="sdsSalaryAmount" placeholder="Enter Amount">
                             <input type="text" name="sdsSalarySameAsExcel[]" id="sdsSalarySameAsExcel" class="col-sm-4 sdsSalarySameAsExcel" placeholder="Same as Excel Sheet.">
                            <a href="javascript:void(0);" class="col-sm-1 fa fa-plus addOtherField" id="addOtherField" onclick="add_fields();"></a>            
                        </div>
                        <div class="col-sm-6 amountCalculation">
                            	<label for="sdsSubTotalAmount" class="col-md-2 sdssub">Sub Total :</label> 
                            	<input type="number" name="sdsSubTotalAmount" class="col-md-4 sdsSubTotalAmount" id="sdsSubTotalAmount" placeholder="Sub Total">
                            	 
                        		<!-- <button class="col-md-1 addTaxSlab" id="addTaxSlab" name="addTaxSlab">Add Tax Slab</button> -->
                        </div>
                        <div class="col-sm-6 chargesSds">
                            <select class="col-md-2 sdsServiceChargeType" name="sdsServiceChargeType[]" id="sdsServiceChargeType">
                          		<option value="" selected disabled>Select Charges.</option>
                          		<option value="GST 18%">GST 18%</option>
                          		<option value="CGST">CGST</option>
                          		<option value="SGST">SGST</option>
                        	</select>
                        	<input type="number" name="amountOfGstCharges[]" id="amountOfGstCharges" class="col-md-3 amountOfGstCharges" placeholder="Charges Amount">
                        	<a href="javascript:void(0);" class="col-sm-1 fa fa-plus addTaxSlab" id="addTaxSlab"></a> 
                        </div>
                        <div class="col-sm-12 amountCalculationTotal">
                            <label for="sdsSubTotalAmount" class="col-md-2 sdsTotalAmountCal">Total Amount :</label> 
                            <input type="number" name="sdsTotalAmountCalculation" class="col-md-3 sdsTotalAmountCalculation" id="sdsTotalAmountCalculation" placeholder="Total Amount">
                        	<input type="text" name="totalAmountCalculation" id="totalAmountCalculation" class="col-md-7 totalAmountCalculation" placeholder="Total Amount in Word.">
                        </div>
                      </div>
                    </div>
                  </div>
              </div>

              <div class="box-footer">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            </form>
          </div>              <!-- /.box-body -->
            
              <!-- Main row -->
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>

  <!-- /.content-wrapper -->
  
  <script src="{{asset('public/admin_assets/plugins/validations/jquery.validate.js')}}"></script>
  <script src="{{asset('public/admin_assets/plugins/validations/additional-methods.js')}}"></script>
  <script type="text/javascript">
    $("#createInvoiceForm").validate({
      rules : {
        "sdsProjectName" : {
          required : true
        },
        "sdsSericeCharges" : {
           required : true,
           maxlength:2,
           digit:true
        },
        "sdsSalaryAmount" : {
           required : true
        }
      },
    messages : {
      "sdsProjectName" : {
        required : 'Please select Project Name.'
      },
      "sdsSericeCharges" :{
        required : 'Please Enter Service Charge.',
        digit : 'Please Enter Only Numeric Value',
        maxlength : 'Please Enter Max 2 Number'
      },
      "sdsSalaryAmount" : {
           required : 'Please Enter Salary.'
        }
    }
    });
  </script>
  <script type="text/javascript">
  $(document).ready(function(){
    var maxField = 5; //Input fields increment limitation
    var addButton = $('.addOtherField'); //Add button selector
    var wrapper = $('.sdsSalaryDetals'); //Input field wrapper
    var fieldHTML = '<div><input type="text" name="sdsDateOfSalary[]" id="sdsDateOfSalary" class="col-md-3 sdsDateOfSalary"><input type="text" name="sdsSalaryAmount[]" class="col-md-3 sdsSalaryAmount" id="sdsSalaryAmount"><input type="text" name="sdsSalarySameAsExcel[]" id="sdsSalarySameAsExcel" class="col-sm-4 sdsSalarySameAsExcel"><a href="javascript:void(0);" class="col-sm-1 fa fa-trash remove_button" id="deleteOtherField"></a></div>'; //New input field html 
    var x = 1; //Initial field counter is 1
    
    //Once add button is clicked
    $(addButton).click(function(){
        //Check maximum number of input fields
        if(x < maxField){ 
            x++; //Increment field counter
            $(wrapper).append(fieldHTML); //Add field html
        }
    });
    
    //Once remove button is clicked
    $(wrapper).on('click', '.remove_button', function(e){
        e.preventDefault();
        $(this).parent('div').remove(); //Remove field html
        x--; //Decrement field counter
    });
	});
  $( "#sdsBillingDateFrom" ).datepicker();
  $( "#sdsBillingDateTo" ).datepicker();

  $(document).ready(function(){
    var maxField = 5; //Input fields increment limitation
    var addButton = $('.addTaxSlab'); //Add button selector
    var wrapper = $('.chargesSds'); //Input field wrapper
    var fieldHTML = '<div><select class="col-md-2 sdsServiceChargeType" name="sdsServiceChargeType[]" id="sdsServiceChargeType"><option value="" selected disabled>Select Charges.</option><option value="GST 18%">GST 18%</option><option value="CGST">CGST</option><option value="SGST">SGST</option></select><input type="number" name="amountOfGstCharges[]" id="amountOfGstCharges" class="col-md-3 amountOfGstCharges" placeholder="Charges Amount"><a href="javascript:void(0);" class="col-sm-1 fa fa-trash remove_buttonone" id="deleteOtherField"></a></div>'; //New input field html 
    var x = 1; //Initial field counter is 1
    
    //Once add button is clicked
    $(addButton).click(function(){
        //Check maximum number of input fields
        if(x < maxField){ 
            x++; //Increment field counter
            $(wrapper).append(fieldHTML); //Add field html
        }
    });
    
    //Once remove button is clicked
    $(wrapper).on('click', '.remove_buttonone', function(e){
        e.preventDefault();
        $(this).parent('div').remove(); //Remove field html
        x--; //Decrement field counter
    });
	});

  </script>
  
  @endsection