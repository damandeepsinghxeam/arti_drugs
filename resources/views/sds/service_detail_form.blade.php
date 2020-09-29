@extends('admins.layouts.app')

@section('content')
<style type="text/css">
	.col-md-12.sdAddressDetailsInfo{
    display: none;
  }
  .col-sm-6.onBoarding{
    display: none;
  }
  .box-body {
    padding-left: 0px;
}
.col-md-12.nameOfProjects {
    padding-left: 0px;
}
div#sdAddressDetailsInfo {
    padding-left: 0px;
}
  label.col-md-4 {
    margin-top: 8px;
    padding-left: 0px;
}
select#sdNameOfProject {
    height: 34px;
    margin-bottom: 15px;
}
input#sdPlotStreet {
    height: 34px;
    margin-bottom: 15px;
}
input#sdCity {
    height: 34px;
    margin-bottom: 15px;
}
input#sdState {
    height: 34px;
    margin-bottom: 15px;
}
input#sdPin {
    height: 34px;
    margin-bottom: 15px;
}
span.select2-selection.select2-selection--multiple {
    margin-bottom: 15px;
}
input#totalManpowerRequired {
    height: 34px;
    margin-bottom: 15px;
}
input#sdRecruitment {
    height: 34px;
    margin-bottom: 15px;
}
input#sdTransfer {
    height: 34px;
    margin-bottom: 15px;
}
input#dateOfOnBoarding {
    height: 34px;
    margin-bottom: 15px;
}
select#sdVendorSupport {
    height: 34px;
    margin-bottom: 15px;
}
select#sdSocialMediaPosting {
    height: 34px;
    margin-bottom: 15px;
}
input.col-md-4.noOfLikeOnPost {
    height: 34px;
}
input.col-md-5.noOfLikeOnPost {
    height: 34px;
    margin-bottom: 15px;
}
select#sdRecruitmentPortal {
    height: 34px;
    margin-bottom: 15px;
}
input.col-md-5.noOfPostedRecruitment {
    height: 34px;
    margin-bottom: 15px;
}
select#sdNewPaperAdv {
    height: 34px;
    margin-bottom: 15px;
}
input#noOfNewPaperAdv {
    height: 34px;
    margin-bottom: 15px;
}
input#sdOtherMedia {
    height: 34px;
    margin-bottom: 15px;
}
input#noOfOtherMedia {
    height: 34px;
    margin-bottom: 15px;
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
}
.sdApplicationFee {
    /* margin: 100px; */
    border: solid #999;
    border-width: 0 2px 2px;
    padding-top: 1px;
    position: relative;
    float: right;
}
input#sdFee {
    margin-top: 15px;
    margin-bottom: 15px;
    height: 34px;
}
input#sdGst {
    margin-bottom: 15px;
    height: 34px;
}
input#sdTotalFee {
    margin-bottom: 15px;
    height: 34px;
}
label.col-md-2.applicationFee {
    margin-top: 22px;
}
label.col-md-2.applicationGst {
    margin-top: 7px;
}
label.col-md-2.applicationTotal {
    margin-top: 7px;
}
input#sdFee::-webkit-inner-spin-button, 
input#sdFee::-webkit-outer-spin-button { 
  -webkit-appearance: none; 
  margin: 0; 
}
input#sdGst::-webkit-inner-spin-button, 
input#sdGst::-webkit-outer-spin-button { 
  -webkit-appearance: none; 
  margin: 0; 
}
</style>
<!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>
        Service Details
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

            <form id="serviceDetailsForm" action="{{ url('leads/create-lead') }}" method="POST">
              {{ csrf_field() }}
              
              <div class="box-body">
              	<div class="col-sm-12">
              		<div class="col-sm-6 sdProject">
                    <div class="col-md-12 nameOfProjects">
                      <label for="sdNameOfProject" class="col-md-4">Name Of Project :</label>
                      <select class="col-md-8 sdNameOfProject" name="sdNameOfProject" id="sdNameOfProject">
                        <option value="" selected disabled>Please Select Project.</option>
                        <option value="XEAM HO">XEAM HO</option>
                        <option value="UNDP">UNDP</option> 
                      </select>
                    </div>
                    <div class="col-md-12 sdAddressDetailsInfo" id="sdAddressDetailsInfo">
                      <label for="sdPlotStreet" class="col-md-4">Plot no. & Street :</label>
                      <input type="text" name="sdPlotStreet" id="sdPlotStreet" class="col-md-8 sdPlotStreet" disabled>
                      <label for="sdCity" class="col-md-4">City :</label>
                      <input type="text" name="sdCity" id="sdCity" class="col-md-8 sdCity" disabled>
                      <label for="sdState" class="col-md-4">State :</label>
                      <input type="text" name="sdState" id="sdState" class="col-md-8 sdState" disabled>
                      <label for="sdPin" class="col-md-4">Pin :</label>
                      <input type="text" name="sdPin" id="sdPin" class="col-md-8 sdPin" disabled>
                      <label for="sdProjectLocation" class="col-md-4">Project Locations :</label>
                      <select class="col-md-8 select2 sdProjectLocation" name="sdProjectLocation" id="sdProjectLocation" multiple="multiple" style="width: 66.66666667%">
                        <option value="XEAM HO">XEAM HO</option>
                        <option value="UNDP">UNDP</option> 
                      </select>
                      <label for="totalManpowerRequired" class="col-md-4">Total Manpower Rwquired :</label>
                      <input type="number" name="totalManpowerRequired" id="totalManpowerRequired" class="col-md-8 totalManpowerRequired" min="0" placeholder="Please enter Total Manpower required">
                      <label for="sdRecruitment" class="col-md-4">Total Manpower Rwquired :</label>
                      <input type="number" name="sdRecruitment" id="sdRecruitment" class="col-md-8 sdRecruitment" min="0" placeholder="Please enter no of Recruitment">
                      <label for="sdTransfer" class="col-md-4">Transfer :</label>
                      <input type="number" name="sdTransfer" id="sdTransfer" class="col-md-8 sdTransfer" min="0" placeholder="Please enter no of Transfer.">
                    </div>
                      
              		</div>
                  <div class="col-sm-6 onBoarding" id="onBoarding">
                    <label for="dateOfOnBoarding" class="col-md-4">Date of On Boarding</label>
                    <input type="text" name="dateOfOnBoarding" id="dateOfOnBoarding" class="col-md-8 dateOfOnBoarding" placeholder="Please Select Date">
                    <label for="sdVendorSupport" class="col-md-4">Vendor Support :</label>
                    <select class="col-md-8 sdVendorSupport" name="sdVendorSupport" id="sdVendorSupport">
                        <option value="" selected disabled>Please Select Vendor Support.</option>
                        <option value="XEAM HO">Yes</option>
                        <option value="UNDP">No</option> 
                    </select>
                    <label for="sdSocialMediaPosting" class="col-md-4">Social Media Posting :</label>
                    <select class="col-md-3 sdSocialMediaPosting" name="sdSocialMediaPosting" id="sdSocialMediaPosting">
                        <option value="" selected disabled>Select Y/N</option>
                        <option value="XEAM HO">Yes</option>
                        <option value="UNDP">No</option> 
                    </select>
                    <input type="number" name="noOfLikeOnPost" min="0" class="col-md-5 noOfLikeOnPost" placeholder="Enter Numeric value">

                    <label for="sdRecruitmentPortal" class="col-md-4">Recruitment Portal :</label>
                    <select class="col-md-3 sdRecruitmentPortal" name="sdRecruitmentPortal" id="sdRecruitmentPortal">
                        <option value="" selected disabled>Select Y/N</option>
                        <option value="XEAM HO">Yes</option>
                        <option value="UNDP">No</option> 
                    </select>
                    <input type="number" name="noOfPostedRecruitment" min="0" class="col-md-5 noOfPostedRecruitment" placeholder="Enter Numeric value">

                    <label for="sdNewPaperAdv" class="col-md-4">New Paper Avd. :</label>
                    <select class="col-md-3 sdNewPaperAdv" name="sdNewPaperAdv" id="sdNewPaperAdv">
                        <option value="" selected disabled>Select Y/N</option>
                        <option value="XEAM HO">Yes</option>
                        <option value="UNDP">No</option> 
                    </select>
                    <input type="number" name="noOfNewPaperAdv" min="0" class="col-md-5 noOfNewPaperAdv" id="noOfNewPaperAdv" placeholder="Enter Numeric value">

                    <label for="sdOtherMedia" class="col-md-4">Other Media :</label>
                    <input type="text" name="sdOtherMedia" id="sdOtherMedia" class="col-md-5  sdOtherMedia" placeholder="Other Media">
                    <input type="number" name="noOfOtherMedia" min="0" class="col-md-3 noOfOtherMedia" id="noOfOtherMedia" placeholder="Enter Numeric value">
                    <div class="col-sm-12 sdApplicationFee">
                      <div class="titlebox"><span><b>ApplicationFee</b></span></div>
                      <label for="sdFee" class="col-md-2 applicationFee">Fee :</label>
                      <input type="number" name="sdFee" class="col-md-10 sdFee" id="sdFee" onkeyup="sum();" placeholder="Enter Fee"min="0" >
                      <label for="sdGst" class="col-md-2 applicationGst">GST :</label>
                      <input type="number" name="sdGst" class="col-md-10 sdGst" id="sdGst" onkeyup="sum();" placeholder="Enter GST" min="0">
                      <label for="sdTotalFee" class="col-md-2 applicationTotal">Total :</label>
                      <input type="number" name="sdTotalFee" class="col-md-10 sdTotalFee" id="sdTotalFee" disabled>
                    </div>
                  </div>
              	</div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </form>
              <!-- Main row -->
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>

  <!-- /.content-wrapper -->

  <script src="{{asset('public/admin_assets/plugins/validations/jquery.validate.js')}}"></script>
  <script src="{{asset('public/admin_assets/plugins/validations/additional-methods.js')}}"></script>
  
  <script type="text/javascript">
    $("#serviceDetailsForm").validate({
      rules :{
        "sdNameOfProject" : {
           required : true
        }
      },
      errorPlacement: function(error, element) {
        if (element.hasClass('select2')) {
          error.insertAfter(element.next('span.select2'));
        } else {
          error.insertAfter(element);
        }
      },
      messages : {
        "sdNameOfProject" : {
          required : 'Please select project name.'
        }
      }
    });
  </script>
  <script type="text/javascript">
    $(function() {
    $('#sdAddressDetailsInfo').hide();
    $('#onBoarding').hide();  
    $('select#sdNameOfProject').change(function(){
        if($('select#sdNameOfProject').val() == 'XEAM HO'||'UNDP') {
            $('#sdAddressDetailsInfo').show(); 
            $('#onBoarding').show(); 
        } else {
            $('#sdAddressDetailsInfo').hide(); 
            $('#onBoarding').hide(); 
        } 
      });
    });

    function sum() {
            var txtFirstNumberValue = document.getElementById('sdFee').value;
            var txtSecondNumberValue = document.getElementById('sdGst').value;
            var result = parseFloat(txtFirstNumberValue) + parseFloat(txtSecondNumberValue);
            if (!isNaN(result)) {
                document.getElementById('sdTotalFee').value = result;
            }
        }
  </script>
  <script type="text/javascript">
    $( function() {
    $( "#dateOfOnBoarding" ).datepicker();
  } );
  </script>

  @endsection