@extends('admins.layouts.app')

@section('content')

<link rel="stylesheet" href="{{asset('public/admin_assets/plugins/dataTables/jquery.dataTables.min.css')}}">

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Travel Module
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
        <div class="col-md-12">
          <div class="box box-primary">
            <h2 class="travel-expense-title2">Expense Summary Details</h2>
            <div class="row travel-box-border">
              <div class="col-md-8">
                <h3 class="travel-expense-title3">Basic Details</h3>
                <div class="col-md-6 remove-travel-left6">
                  <div class="row">
                    <div class="col-md-5 col-sm-5 col-xs-5">
                      <label for="">Name</label>
                    </div>
                    <div class="col-md-7 col-sm-7 col-xs-7">
                      <label>Xyz</label>
                    </div>
                  </div>
                  
                  <div class="row">
                    <div class="col-md-5 col-sm-5 col-xs-5">
                      <label for="">Employee Code</label>
                    </div>
                    <div class="col-md-7 col-sm-7 col-xs-7">
                      <label>123456</label>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-5 col-sm-5 col-xs-5">
                      <label for="">Designation</label>
                    </div>
                    <div class="col-md-7 col-sm-7 col-xs-7">
                      <label>Designation here</label>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-5 col-sm-5 col-xs-5">
                      <label for="">Bank Name</label>
                    </div>
                    <div class="col-md-7 col-sm-7 col-xs-7">
                      <label>State Bank of India</label>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-5 col-sm-5 col-xs-5">
                      <label for="">Account No</label>
                    </div>
                    <div class="col-md-7 col-sm-7 col-xs-7">
                      <label>123456797634</label>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-5 col-sm-5 col-xs-5">
                      <label for="">IFSC CODE</label>
                    </div>
                    <div class="col-md-7 col-sm-7 col-xs-7">
                      <label>SBI8654723422</label>
                    </div>
                  </div>
                </div>

                <div class="col-md-6 remove-travel-left6">
                  <div class="row">
                    <div class="col-md-5 col-sm-5 col-xs-5">
                      <label for="">Project</label>
                    </div>
                    <div class="col-md-7 col-sm-7 col-xs-7">
                      <label>Xeam HO</label>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-5 col-sm-5 col-xs-5">
                      <label for="">Approved By</label>
                    </div>
                    <div class="col-md-7 col-sm-7 col-xs-7">
                      <label>Approved Person Name</label>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-5 col-sm-5 col-xs-5">
                      <label for="">Payment Status</label>
                    </div>
                    <div class="col-md-7 col-sm-7 col-xs-7">
                      <label>Payment Status here</label>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-5 col-sm-5 col-xs-5">
                      <label for="">UTR No.</label>
                    </div>
                    <div class="col-md-7 col-sm-7 col-xs-7">
                      <label>UTR NO Here</label>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                  <h3 class="travel-expense-title3">Amount Details</h3>
                  <div class="row">
                    <div class="col-md-5 col-sm-5 col-xs-5">
                      <label for="">Eligible Amount</label>
                    </div>
                    <div class="col-md-7 col-sm-7 col-xs-7">
                      <label>3453535</label>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-5 col-sm-5 col-xs-5">
                      <label for="">Approved Amount</label>
                    </div>
                    <div class="col-md-7 col-sm-7 col-xs-7">
                      <label>456447</label>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-5 col-sm-5 col-xs-5">
                      <label for="">Claimed Amount</label>
                    </div>
                    <div class="col-md-7 col-sm-7 col-xs-7">
                      <label>4645</label>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-5 col-sm-5 col-xs-5">
                      <label for="">Imprest taken</label>
                    </div>
                    <div class="col-md-7 col-sm-7 col-xs-7">
                      <label>Value</label>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-5 col-sm-5 col-xs-5">
                      <label for="">Balance Amount</label>
                    </div>
                    <div class="col-md-7 col-sm-7 col-xs-7">
                      <label>Value</label>
                    </div>
                  </div>
              </div>
              </div>
            <!-- <div class="box-header">
            </div> -->
            <!-- /.box-header -->

            <div class="box-body">
              <table id="travelExpenseTable" class="table table-bordered table-striped travel-table-inner" style="height:150px;">
                <thead class="table-heading-style">
                <tr>
                  <th>Date</th>
                  <th>From</th>
                  <th>To</th>
                  <th>Expense Type</th>
                  <th>Description</th>
                  <th>Km</th>
                  <th>Rate</th>
                  <th>Amount</th>
                  <th>Add/Rem</th>
                </tr>
                </thead>
                <tbody> 
                <tr>
                  <td>
                       <input autocomplete="off" type="text" class="form-control selectDate travel-table-input-style travel-only-inputss travel-input2" id="travelDate" name="Date" placeholder="MM/DD/YYYY" value="" readonly>
                  </td>
                  <td>
                    <input type="text" name="fromName" class="form-control travel-input2 travel-table-input-style travel-only-inputss">
                    <!-- form-control travel-table-input-style travel-only-inputss -->
                  </td>
                  <td>
                    <input type="text" name="toName" class="form-control travel-input2 travel-table-input-style travel-only-inputss">
                  </td>
                  <td>
                    <select class="form-control travel-input6 travel-table-input-style travel-only-inputss" name="expresssType">
                      <option value="value 1">Value 1</option>
                      <option value="value 2">value 2</option>
                      <option value="value 3">value 3</option>
                      <option value="value 4">value 4</option>
                    </select>
                  </td>
                  <td>
                    <input type="text" name="description" class="form-control travel-input3 travel-table-input-style travel-only-inputss">
                  </td>
                  <td>
                    <input type="text" name="kilometers" class="form-control travel-input4 travel-table-input-style travel-only-inputss" placeholder="30">
                  </td>
                  <td>
                    <input type="text" name="rate" class="form-control travel-input5 travel-table-input-style travel-only-inputss"placeholder="132">
                  </td>
                  <td>
                    <input type="text" name="amount" class="form-control travel-input5 travel-table-input-style travel-only-inputss" placeholder="330">
                  </td>
                  <td class="text-center">
                    <a href="javascript:void(0);" class="addtravel"><i class="fa fa-plus addtravel-row"></i></a>
                  </td>
                </tr>
                </tbody>
                <tfoot class="table-heading-style">
                <tr>
                  <th>Date</th>
                  <th>From</th>
                  <th>To</th>
                  <th>Expense Type</th>
                  <th>Description</th>
                  <th>Km</th>
                  <th>Rate</th>
                  <th>Amount</th>
                  <th>Add/Rem</th>
                </tr>
                </tfoot>
              </table>

              <br>




              <h2 class="travel-expense-title2" style="padding-left: 0px;">Upload Supporting Documents</h2>
              <table id="travelAttachmentTable" class="table table-bordered table-striped travel-table-inner" style="height:150px;">
                <thead class="table-heading-style">
                <tr>
                  <th>Type of Attachment</th>
                  <th>File Name</th>
                  <th>Choose Attachment</th>
                  <th>Add/Remove</th>
                </tr>
                </thead>
                <tbody> 
                <tr>
                  <td>
                      <select class="form-control travel-table-input-style travel-only-inputss" name="expresssType">
                        <option value="Attachment Type 1">Attachment Type 1</option>
                        <option value="Attachment Type 2">Attachment Type 2</option>
                        <option value="Attachment Type 3">Attachment Type 3</option>
                        <option value="Attachment Type 4">Attachment Type 4</option>
                      </select>
                  </td>
                  <td>
                    <input type="text" name="fileName" class="form-control travel-table-input-style travel-only-inputss">
                    <!-- form-control travel-table-input-style travel-only-inputss -->
                  </td>
                  <td>
                    <input type="file" name="chooseAttachment" class="chooseAttachment-travel">
                  </td>
                  <td class="text-center">
                     <a href="javascript:void(0);" class="add-attachment"><i class="fa fa-plus addtravel-row"></i></a>
                  </td>
                </tr>
                </tbody>
                <tfoot class="table-heading-style">
                <tr>
                  <th>Type of Attachment</th>
                  <th>File Name</th>
                  <th>Choose Attachment</th>
                  <th>Add/Remove</th>
                </tr>
                </tfoot>
              </table>

            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>
      <!-- /.row -->
      <!-- Main row -->

    </section>
    <!-- /.content --> 
<div class="containerSuitable"></div>
  <!-- /.content-wrapper -->

  <script src="{{asset('public/admin_assets/plugins/dataTables/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('public/admin_assets/plugins/validations/jquery.validate.js')}}"></script>
  <script src="{{asset('public/admin_assets/plugins/validations/additional-methods.js')}}"></script>

<script type="text/javascript">
//Date picker
    $("#travelDate").datepicker({
      //startDate: minimumDate,
      /*endDate: maximumDate,*/
      autoclose: true,
      orientation: "bottom"
    });
</script>

<script>
$(document).ready(function(){
    $(".addtravel").click(function(){
        date_id=$(".selectDate").length+1;
        $("#travelExpenseTable").append('<tr><td> <input autocomplete="off" type="text" class="form-control selectDate travel-table-input-style travel-only-inputss travel-input2" id="travelDate'+date_id+'" name="Date" placeholder="MM/DD/YYYY" value="" readonly></td><td> <input type="text" name="fromName" class="form-control travel-input2 travel-table-input-style travel-only-inputss"></td><td> <input type="text" name="toName" class="form-control travel-input2 travel-table-input-style travel-only-inputss"></td><td> <select class="form-control travel-input6 travel-table-input-style travel-only-inputss" name="expresssType"><option value="value 1">Value 1</option><option value="value 2">value 2</option><option value="value 3">value 3</option><option value="value 4">value 4</option> </select></td><td> <input type="text" name="description" class="form-control travel-input3 travel-table-input-style travel-only-inputss"></td><td> <input type="text" name="kilometers" class="form-control travel-input4 travel-table-input-style travel-only-inputss" placeholder="30"></td><td> <input type="text" name="rate" class="form-control travel-input5 travel-table-input-style travel-only-inputss"placeholder="132"></td><td> <input type="text" name="amount" class="form-control travel-input5 travel-table-input-style travel-only-inputss" placeholder="330"></td><td class="text-center"> <a href="javascript:void(0);" class="remtravel"><i class="fa fa-minus remtravel-row"></i></a></td></tr>');
        $("#travelDate"+date_id).datepicker({
          autoclose: true,
          orientation: "bottom"
        });
        $(".remtravel").on('click',function(){
            $(this).parent().parent().remove();
        });
    });
});
</script>

<script>
$(document).ready(function(){
    $(".add-attachment").click(function(){
        $("#travelAttachmentTable").append('<tr><td> <select class="form-control travel-table-input-style travel-only-inputss" name="expresssType"><option value="Attachment Type 1">Attachment Type 1</option><option value="Attachment Type 2">Attachment Type 2</option><option value="Attachment Type 3">Attachment Type 3</option><option value="Attachment Type 4">Attachment Type 4</option> </select></td><td> <input type="text" name="fileName" class="form-control travel-table-input-style travel-only-inputss"></td><td> <input type="file" name="chooseAttachment" class="chooseAttachment-travel"></td><td class="text-center"> <a href="javascript:void(0);" class="remove-attachment"><i class="fa fa-minus remtravel-row"></i></a></td></tr>');
        $(".remove-attachment").on('click',function(){
            $(this).parent().parent().remove();
        });
    });
});
</script>

  
  @endsection