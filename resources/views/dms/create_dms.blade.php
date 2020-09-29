@extends('admins.layouts.app')

@section('content')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="{{asset('public/js/bootstrap-tagsinput.js')}}"></script>
  <link rel="stylesheet" href="{{asset('public/css/bootstrap-tagsinput.css')}}">
<style type="text/css">
	form#createDmsForm {
    margin-top: 15px;
}
select.col-sm-8.dmsDepartment {
    height: 34px;
}
select.col-sm-8.dmsProject {
    height: 34px;
}
select.col-sm-8.dmsMainCategory {
    height: 34px;
}
select.col-sm-8.dmsSubCategory {
    height: 34px;
}
label.col-md-4 {
    margin-top: 9px;
}
input#dmsCreatedDate {
    height: 34px;
}
select.col-md-6.dmsSharedPermision {
    height: 34px;
    width: 48%;
    margin-left: 5px;
}
select#dmsShareDepartment {
    height: 34px;
    width: 48%;
    margin-right: 10px;
    margin-bottom: 26px;
}
.col-md-12.shareDepartment {
    padding-right: 0px;
    margin-top: 10px;
}
input#dmsDepartmentWise {
    zoom: 1.5;
    margin-top: -1px;
    vertical-align: middle;
}
label.col-md-4.sharelabel {
    margin-top: 20px;
}
textarea.col-sm-12.completeClause {
    margin-bottom: 20px;
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
.col-sm-6.SecurityBorder {
    /* margin: 100px; */
    border: solid #999;
    border-width: 0 2px 2px;
    padding-top: 1px;
    position: relative;
    float: right;
}
label.securityRadioField {
    margin-top: 20px;
    font-weight: 100;
}
input.col-sm-12.completeClause {
    height: 118px;
    margin-bottom: 25px;
}
.bootstrap-tagsinput {
    background-color: #fff;
    border: 1px solid #ccc;
    box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
    display: block;
    padding: 4px 6px;
    color: #555;
    vertical-align: middle;
    border-radius: 4px;
    max-width: 100%;
    line-height: 22px;
    cursor: text;
    height: 118px;
    margin-bottom: 25px;
}
.bootstrap-tagsinput input {
    border: none;
    box-shadow: none;
    outline: none;
    background-color: transparent;
    padding: 0 6px;
    margin: 0;
    width: auto;
    max-width: inherit;
}
</style>
<!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>
        DMS Upload
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

            <form id="createDmsForm" action="{{ url('dms/create-dms') }}" method="POST">
              <div class="form-group">
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="col-sm-6">
                        <label for="dmsDepartment" class="col-md-4">Department :</label>
                        <select class="col-sm-8 dmsDepartment" name="dmsDepartment" id="dmsDepartment">
                          <option value="" selected disabled>Please Select Department.</option>
                          <option value="IT">IT</option>
                          <option value="HR">HR</option>
                          <option value="BD">BD</option>
                        </select> 
                      </div>
                      <div class="col-sm-6">
                        <label for="dmsProject" class="col-md-4">Project :</label>
                        <select class="col-sm-8 dmsProject" name="dmsProject" id="dmsProject">
                          <option value="" selected disabled>Please Select Project.</option>
                          <option value="XEAMHO">XEAMHO</option>
                        </select> 
                      </div>
                    </div>
                  </div>
              </div>
              <div class="form-group">
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="col-sm-6">
                        <label for="dmsMainCategory" class="col-md-4">Main Category :</label>
                        <select class="col-sm-8 dmsMainCategory" name="dmsMainCategory">
                          <option value="" selected disabled>Please Select Main Category.</option>
                          <option value="IT">IT</option>
                          <option value="HR">HR</option>
                          <option value="BD">BD</option>
                        </select> 
                      </div>
                      <div class="col-sm-6">
                        <label for="dmsSubCategory" class="col-md-4">Sub Category :</label>
                        <select class="col-sm-8 dmsSubCategory" name="dmsSubCategory">
                          <option value="" selected disabled>Please Select Sub Category.</option>
                          <option value="XEAMHO">XEAMHO</option>
                        </select> 
                      </div>
                    </div>
                  </div>
              </div>
              <div class="form-group">
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="col-sm-6">
                        <label for="dmsUploadFile" class="col-md-4">Upload File :</label>
                        <input type="File" name="dmsUploadFile" id="dmsUploadFile" class="col-sm-8 dmsUploadFile">
                      </div>
                      <div class="col-sm-6">
                        <label for="dmsCreatedDate" class="col-md-4">Date :</label>
                        <input type="text" name="dmsCreatedDate" id="dmsCreatedDate" class="col-sm-8 dmsCreatedDate" placeholder="MM/DD/YYYY">
                      </div>
                    </div>
                  </div>
              </div>
              <div class="form-group">
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="col-sm-6">
                        <input type="text" class="col-sm-12 completeClause" name="completeClause" placeholder="Comma separated Keywords" data-role="tagsinput">
                      </div>
                      <div class="col-sm-6 SecurityBorder">
                        <div class="titlebox"><span><b>Security</b></span></div>
                        <label class="col-md-4 sharelabel">Share With :</label>
                        <label for="dmsDepartmentWise" class="securityRadioField"><input type="radio" name="dmsDepartmentWise" id="dmsDepartmentWise" class="dmsDepartmentWise" checked>Department Wise (view Only)</label>
                        <label for="dmsDepartmentWise" class="securityRadioField"><input type="radio" name="dmsDepartmentWise" id="dmsDepartmentWise" class="dmsDepartmentWise">Employee Wise</label>
                        <div class="col-md-12 shareDepartment">
                          <select class="col-md-6 dmsShareDepartment" name="dmsShareDepartment" id="dmsShareDepartment">
                          <option value="" selected disabled>Please Select Department</option>
                          <option value="XEAMHO">XEAMHO</option>
                        </select> 
                        <select class="col-md-6 dmsSharedPermision" name="dmsSharedPermision">
                          <option value="" selected disabled>Please Select Permision.</option>
                          <option value="XEAMHO">View Only</option>
                          <option value="XEAMHO">Edit / View</option>
                        </select> 
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
    $("#createDmsForm").validate({
      rules : {
        "dmsProject" : {
          required : true
        }
      },
    messages : {
      "dmsProject" : {
        required : 'Please select Department Name.'
      }
    }
    });
  </script>
  <script type="text/javascript">
    $( function() {
    $( "#dmsCreatedDate" ).datepicker();
  } );
  </script>
  @endsection