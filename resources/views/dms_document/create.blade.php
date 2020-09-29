@extends('admins.layouts.app')

@section('style')
    <style>
        #document_form_3_table tr th,
        #document_form_3_table tr td { vertical-align: middle;}
    </style>
@endsection

@section('content')

    <!-- Content Wrapper Starts here -->
    <div class="content-wrapper">

        <!-- Content Header Starts here -->
        <section class="content-header">
            <h1>Add Document</h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Add Document</li>
            </ol>
        </section>
        <!-- Content Header Ends here -->

        <!-- Main content Starts here -->
        <section class="content">
            <div class="row">
                <div class="col-sm-12">
                    <div class="box box-primary">

                        <!-- Form Starts here -->
                        <form id="document_form_3" method="post" action="{{ route('dms.document.store') }}" enctype="multipart/form-data">
                        @csrf
                        <!-- Box Body Starts here -->
                            <div class="box-body jrf-form-body">

                                <div class="form-group">
                                    <label for="document_name">Document Name<span class="ast" style="color:red">*</span></label>
                                    <input type="text" name="document_name" class="@error('document_name') is-invalid @enderror form-control input-sm basic-detail-input-style" id="" placeholder="Enter Document Name here">
                                    @error('document_name')
                                    <div class="alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="document_category">Document Category<span class="ast" style="color:red">*</span></label>
                                    <select name="document_category" class="form-control input-sm basic-detail-input-style" id="">
                                        <option value="" selected disabled>Please Select Document Category</option>
                                        @foreach($dmsCategories as $dmscategory)
                                            <option value="{{ $dmscategory->id }}">{{ $dmscategory->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="document_keywords">Document Keywords<span class="ast" style="color:red">*</span></label>
                                    <select name="document_keywords[]" class="form-control input-sm basic-detail-input-style select2" data-placeholder="Please Select Document Keywords" id="" multiple="multiple" required>
                                        <option value="" disabled>Please Select Document Keywords</option>
                                        @foreach($dmsKeywords as $dmsKeyword)
                                            <option value="{{ $dmsKeyword->id }}">{{ $dmsKeyword->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="row"> 
                                    <div class="form-group">
                                        <div class="col-md-2">
                                            <label for="employees">Privacy Status<span class="ast" style="color:red">*</span></label>
                                            <select name="privacy_status"  class="form-control input-sm basic-detail-input-style"  id="privacy_status"  required>
                                                <option value="">Select Privacy Type</option>
                                                <option value="public">Public</option>
                                                <option value="shared">Shared</option>
                                                <option value="private">Private</option>
                                                <!--<option value="protected">Protected</option>-->

                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                          <span class="label label-warning">Public</span> Open For All 
                                        </div>
                                         <div class="col-md-3">
                                          <span class="label label-primary">Shared</span> Shared With Selected People  
                                        </div>

                                         <div class="col-md-3">
                                          <span class="label label-info">Private</span>  Only For Approving Authority 
                                        </div>
                                    </div>
                                </div><br>
                                <div class="privacy" style="display: none;">
                                    <div class="callout callout-danger apply-lv-alert">
                                        <strong>Note:</strong>
                                        <em>Shared Documents By Default <b>View Permission</b>.</em>
                                    </div>
                                    <div class="form-group">
                                        <label for="department">Department (optional)</label>
                                        <select name="departments[]" id="departmentIds" class="form-control input-sm basic-detail-input-style select2" data-placeholder="Select Department"  multiple="multiple">
                                            <option value=""  disabled>Please Select Document Departments</option>
                                            @foreach($departments as $department)
                                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        
                                        <label for="employees">Employees</label>
                                        <select name="employees[]"  class="departmentIds form-control input-sm basic-detail-input-style select2" data-placeholder="Select Employee" id="employees" multiple="multiple" >
                                            <option value=""  disabled>Please Select Document Employees</option>
                                        </select>
                                        <div class="languageCheckboxess"></div>
                                    </div>

                                    
                                    
                                </div><br>
                                <div class="form-group">
                                    <label for="Document">Document<span class="ast" style="color:red">*</span></label>
                                    <input type="file" name="document_files[]" id="" multiple required="required">
                                </div>

                                <!--<div class="languageCheckboxessAAAAA"></div> -->
                            </div>
                            <!-- Box Body Ends here -->
                            <!-- Box Footer Starts here -->
                            <div class="box-footer text-center">
                                <input type="submit" class="btn btn-primary submit-btn-style" id="submit2" value="Save" name="submit">
                            </div>
                            <!-- Box Footer Ends here -->
                        </form>
                        <!-- Form Ends here -->
                    </div>
                </div>
            </div>
        </section>
        <!-- Main content Ends Here-->
    </div>
    <!-- Content Wrapper Ends here -->
@endsection

@section('script')

    <!-- Script Source Files Starts here -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/additional-methods.js"></script>
    <!-- Script Source Files Ends here -->

    <!-- Custom Script Starts here -->
    <script>
        $(document).ready(function(){
            //Validation Starts here
            $("#document_form_3").validate({
                rules: {
                    "document_name" : {
                        required: true
                    },
                    "privacy_status" :{
                        required:true
                    },
                    "document_keywords" : {
                        required: true
                    },
                    "document_category" : {
                        required: true
                    },
                    "document_file" : {
                        required: true
                    }
                },
                errorPlacement: function(error, element) {
                    if (element.hasClass('select2')) {
                        error.insertAfter(element.next('span.select2'));
                    } else {
                        error.insertAfter(element);
                    }
                },
                messages: {
                    "document_name" : {
                        required: "Please enter document name"
                    },
                    "privacy_status":{
                        required: "Please enter Privacy Status"
                    },
                    "document_keywords" : {
                        required: "Please select document keyword/keywords"
                    },
                    "document_category" : {
                        required: "Please select document category"
                    },
                    "document_file" : {
                        required: "Choose file"
                    },
                   
                }
            });
            //Validation Ends here

            $('#departmentIds').change(function() {
                var department_ids = $(this).val();
                $.ajax({
                    type: 'POST',
                    url: '{{ URL('dms-documents/department/employee') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        department_ids: department_ids
                    },
                    success: function (data) {
                        var employees = data.data;
                        // $('#employees').empty();
                        if(employees)
                        {
                            var formoption = "";
                            $.each(employees, function(v) {
                                var val = employees[v]
                                formoption += "<option value='" + val['id'] + "'>" + val['fullname'] + "</option>";
                            });
                            $('#employees').html(formoption);
                        }
                    },
                    error: function (xhr) {
                        console.log(xhr.responseText);
                    }
                });
            });
        });
    </script>

    <script type="text/javascript">

        $("#privacy_status").click(function () {
          var type = $(this).val();
           if(type == 'shared'){
            $(".privacy").show();
           } else {
            $(".privacy").hide();
           }
        });

        $("#employees.select2").on('change',function(){
          var arr = $(this).val();
          length = arr.length; 
          var display = '';
          for(var i=0; i < length; i++) {
             var langName = $("#employees option[value='"+ arr[i] + "']").text();
             var checkBoxes = '<div class="row field-changes-below" id="YourbuttonId"><div class="col-sm-2"><strong class="basic-lang-label">'+langName+'</strong></div><div class="col-sm-4 langright"><label class="checkbox-inline"><input type="checkbox" value="1" name="download_doc['+arr[i]+']">Download Document</label><input type="hidden" value="1" name="view_doc['+arr[i]+']" ></div></div>';
            display += checkBoxes;
          }
          $(".languageCheckboxess").html("");
          $(".languageCheckboxess").append(display);
        });

    </script>


    <script type="text/javascript">
        
        $("#departmentIds.select2").on('change',function(){
          var arr = $(this).val();
          length = arr.length; 
          var display = '';
          for(var i=0; i < length; i++) {
             var langName = "All Employees Of  "+$("#departmentIds option[value='"+ arr[i] + "']").text()+" Department";

             var checkBoxes = '<div class="row field-changes-below" id="YourbuttonId"><div class="col-sm-2"><strong class="basic-lang-label">'+langName+'</strong></div><div class="col-sm-4 langright"><label class="checkbox-inline"><input type="checkbox" value="1" name="chk_doc['+arr[i]+']" id="chk_doc" class="checkboxddd" ></label><label class="checkbox-inline"><input type="checkbox" value="1" name="chk_doc_downl['+arr[i]+']">Download Document</label><input type="hidden" value="1" name="view_doc['+arr[i]+']" ></div></div>';
            display += checkBoxes;
          }
          $(".languageCheckboxessAAAAA").html("");
          $(".languageCheckboxessAAAAA").append(display);
        });


    </script>

    <!-- <script type="text/javascript">
        
    $("#YourbuttonId").click(function(){
        alert("ss");
        if($('#YourTableId').find('input[type=checkbox]:checked').length == 0)
        {
            alert('Please select atleast one checkbox');
        }
    });

    </script> -->
    <!-- Custom Script Ends here -->
@endsection

