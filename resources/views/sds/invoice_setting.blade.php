@extends('admins.layouts.app')

@section('content')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="{{asset('public/js/bootstrap-tagsinput.js')}}"></script>
  <link rel="stylesheet" href="{{asset('public/css/bootstrap-tagsinput.css')}}">
<style type="text/css">
	form#invoiceSettingForm {
    margin-top: 15px;
}
select#sdsProjectName {
    height: 34px;
}
label.col-md-4 {
    margin-top: 7px;
}
select#sdsBillingCycle {
    height: 34px;
}
input#sdsBillingDateTo {
    float: right;
    width: 33%;
    height: 34px;
}
input#sdsBillingDateFrom {
    height: 34px;
    width: 33%;
}
input#sdsSericeCharges {
    height: 34px;
}
label.col-md-1.percentage {
    margin-top: 7px;
}
select#sdsApplicableTax {
    height: 34px;
    margin-right: 5px;
}
input#sdsTaxInput {
    height: 34px;
    margin-right: -7px;
}
label.col-md-1.taxPercentage {
    margin-top: 7px;
} 
input#sdsCurrentTemplate {
    height: 34px;
}
select#sdsCurrentTemplate {
    height: 34px;
}
</style>
<!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>
        Invoice Setting
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

            <form id="invoiceSettingForm" action="{{ url('sds/invoice-setting') }}" method="POST">
              <div class="form-group">
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="col-sm-6">
                        <label for="sdsProjectName" class="col-md-4">Project Name :</label>
                        <select class="col-sm-8 sdsProjectName" name="sdsProjectName" id="sdsProjectName">
                          <option value="" selected disabled>Please Select Project Name.</option>
                          <option value="XEAM HO">XEAM HO</option>
                          <option value="UNDP">UNDP</option>
                          <option value="LEHRI">LEHRI</option>
                        </select> 
                      </div>
                      <div class="col-sm-6">
                        <label for="sdsBillingCycle" class="col-md-4">Billing Cycle :</label>
                        <select class="col-sm-8 sdsBillingCycle" name="sdsBillingCycle" id="sdsBillingCycle">
                          <option value="" selected disabled>Please Select Billing Cycle.</option>
                          <option value="Monthly">Monthly</option>
                          <option value="Quarterly">Quarterly</option>
                          <option value="Half Yearly">Half Yearly</option>
                          <option value="Half Yearly">Yearly</option>
                        </select> 
                      </div>
                    </div>
                  </div>
              </div>
              <div class="form-group">
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="col-sm-6">
                        <label for="sdsBillingDate" class="col-md-4">Billing Date :</label>
                        <input type="text" name="sdsBillingDate" id="sdsBillingDateFrom" class="col-md-3 sdsBillingDateFrom" placeholder="From">
                        <input type="text" name="sdsBillingDate" id="sdsBillingDateTo" class="col-md-3 sdsBillingDateTo" placeholder="To">
                      </div>
                      <div class="col-sm-6">
                        <label for="sdsSericeCharges" class="col-md-4">Service Charge :</label>
                        <input type="text" name="sdsSericeCharges" id="sdsSericeCharges" class="col-md-7 sdsSericeCharges" placeholder="Please Enter Service Charge">
                        <label for="sdsSericeCharges" class="col-md-1 percentage">%</label>
                      </div>
                    </div>
                  </div>
              </div>
              <div class="form-group">
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="col-sm-6">
                        <label for="sdsApplicableTax" class="col-md-4">Applicable Tax :</label>
                        <select class="col-sm-5 sdsApplicableTax" name="sdsApplicableTax" id="sdsApplicableTax">
                          <option value="" selected disabled>Please Select Tax Type.</option>
                          <option value="Direct Tax">Direct Tax</option>
                          <option value="Indirect Tax">Indirect Tax</option>
                          <option value="Goods and Services Tax">Goods and Services Tax (GST)</option>
                        </select> 
                        <input type="text" name="sdsTaxInput" id="sdsTaxInput" class="col-md-2 sdsTaxInput">
                        <label for="sdsTaxInput" class="col-md-1 taxPercentage">%</label>
                      </div>
                      <div class="col-sm-6">
                        <label for="sdsCurrentTemplate" class="col-md-4">Invoice Template :</label>
                        <select class="col-sm-4 sdsCurrentTemplate" name="sdsCurrentTemplate" id="sdsCurrentTemplate" onchange="setImage(this);">
                          <option value="" selected disabled>Please Select Template Type.</option>
                          <option value="{{asset('public/uploads/invoices/invoice.jpg')}}">1</option>
                          <option value="{{asset('public/uploads/invoices/invoice2.jpg')}}">2</option>
                          <option value="{{asset('public/uploads/invoices/invoice3.jpg')}}">3</option>
                        </select>
                        <img src="" name="image-swap" class="col-md-4" />
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
    $("#invoiceSettingForm").validate({
      rules : {
        "sdsProjectName" : {
          required : true
        },
        "sdsSericeCharges" : {
           required : true,
           maxlength:2,
           digits:true
        }
      },
    messages : {
      "sdsProjectName" : {
        required : 'Please select Project Name.'
      },
      "sdsSericeCharges" :{
        required : 'Please Enter Service Charge.',
        digits : 'Please Enter Only Numeric Value',
        maxlength : 'Please Enter Max 2 Number'
      }
    }
    });
  </script>
  <script type="text/javascript">
    $( function() {
    $( "#sdsBillingDateFrom" ).datepicker();
    });
    $( function() {
    $( "#sdsBillingDateTo" ).datepicker();
  });
    function setImage(select){
    var image = document.getElementsByName("image-swap")[0];
    image.src = select.options[select.selectedIndex].value;
}
  </script>
  @endsection