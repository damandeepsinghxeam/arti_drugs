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
            <h1>Edit Document</h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Edit Document</li>
            </ol>
        </section>
        <!-- Content Header Ends here -->       


        <!-- Main content Starts here -->
        <section class="content">
            <div class="row">
                <div class="col-sm-12">
                    @include('admins.validation_errors')
                    <div class="box box-primary">

                        <!-- Form Starts here -->
                        <form id="document_form_3" method="post" action="{{ route('dms.document.update', $dmsDocument->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <!-- Box Body Starts here -->
                            <div class="box-body jrf-form-body">

                                <div class="form-group">
                                    <label for="document_name">Document Name<span class="ast" style="color:red">*</span></label>
                                    <input type="text" name="document_name" class="@error('document_name') is-invalid @enderror form-control input-sm basic-detail-input-style" id="" value="{{ $dmsDocument->name }}" placeholder="Enter Document Name here">
                                    @error('document_name')
                                    <div class="alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="document_category">Category<span class="ast" style="color:red">*</span></label>

                                    <select name="document_category" class="form-control input-sm basic-detail-input-style" id="">
                                        <option value=""  disabled>Please Select Document Category</option>
                                        @foreach($dmsCategories as $dmscategory)
                                            <option value="{{ $dmscategory->id }}" {{$dmscategory->id == $dmsDocument->dms_category_id  ? 'selected' : ''}}>{{ $dmscategory->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="document_keywords">Document Keywords<span class="ast" style="color:red">*</span></label>
                                    <select name="document_keywords[]" class="form-control input-sm basic-detail-input-style select2" data-placeholder="Please Select Document Keywords" id="" multiple="multiple" required >
                                        <option value="" disabled>Please Select Document Keywords</option>
                                        @foreach($dmsKeywords as $dmsKeyword)
                                            <option value="{{ $dmsKeyword->id }}"  {{ isset($dmsDocument) && in_array($dmsKeyword->id, $dmsDocument->keywords()->pluck('id')->toArray()) ? 'selected' : '' }}>{{ $dmsKeyword->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="row"> 
                                    <div class="form-group">
                                        <div class="col-md-2">
                                            <label for="document_name">Privacy Status<span class="ast" style="color:red">*</span></label>
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
                                          <span class="label label-primary">Shared</span> Only Shared Persons  
                                        </div>

                                         <div class="col-md-3">
                                          <span class="label label-info">Private</span> Only For Approving Authority 
                                        </div>      
                                    </div>        
                                </div><br>

                                <div class="privacy" style="display: none;">
                                    <div class="callout callout-danger apply-lv-alert">
                                        <strong>Note:</strong>
                                        <em>Employees List Which Have <b>View Permission</b>.</em>
                                    </div>
                                    <div class="form-group">
                                        <label for="departments">Department</label>
                                        <select name="departments[]" id="departmentIds" class="form-control input-sm basic-detail-input-style select2" data-placeholder="No Department Selected"  multiple="multiple">
                                            <option value="" disabled>Please Select Document Departments</option>
                                            @foreach($departments as $department)
                                                <option value="{{ $department->id }}" {{ isset($dmsDocument) && in_array($department->id, $dmsDocument->departments()->pluck('department_id')->toArray()) ? 'selected' : '' }}>{{ $department->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="employees">Employees</label>
                                        <select name="employees[]"  class="departmentIds form-control input-sm basic-detail-input-style select2" data-placeholder="No Employee Selected" id="employees" multiple="multiple"   >
                                            <option value="" disabled>Please Select Document Employees</option>
                                              @foreach($employees as $employee)
                                                <option value="{{$employee->id}}" @if(in_array($employee->id,@$emp_doc)){{"selected"}} @else{{""}}@endif >{{$employee->fullname}}</option>
                                              @endforeach
                                        </select>
                                        <div class="documentCheckboxess"></div>
                                    </div></div>

                                <div class="form-group">
                                    <label for="Document">Document<span class="ast">*</span></label>
                                    <input type="file" name="document_files[]" id="" multiple>
                                </div>

                                <div class="form-group">
                                    <label for="">View Documents</label>
                                    <br/>
                                    @foreach(json_decode($dmsDocument->document) as $document)
                                        @php 

                                            $exp = explode('.',$document); 
                                            $expA = $exp[1];
                                              
                                            if($expA == 'jpeg' || $expA == 'jpg' || $expA == 'png' || $expA == 'txt')
                                                $show_icon = '<i class="fa fa-file-text-o" style="font-size: 30px;"></i>';
                                            elseif($expA == 'pdf')
                                                $show_icon = '<i class="fa fa-file-pdf-o" style="font-size: 30px;"></i>';
                                            elseif($expA == 'doc' || $expA == 'docx')
                                                $show_icon = '<i class="fa fa-file-word-o" style="font-size: 30px;"></i>';
                                            elseif($expA == 'xlsx')
                                                $show_icon = '<i class="fa fa-file-excel-o" style="font-size: 30px;"></i>';
                                            elseif($expA == 'xlsx' || $expA == 'xls')
                                                $show_icon = '<i class="fa fa-file-excel-o" style="font-size: 30px;"></i>';
                                            elseif($expA == 'pptx' || $expA == 'ppt')
                                                $show_icon = '<i class="fa fa-file-powerpoint-o" style="font-size: 30px;"></i>';
                                            elseif($expA == 'zip')
                                                $show_icon = '<i class="fa-file-archive-o" style="font-size: 30px;"></i>';                
            
                                        @endphp
                                        
                                        <a href="{{ asset("public/uploads/document/". $document) }}" target="_blank">
                                            {!! $show_icon !!}
                                        </a>
                                       <a href="{{ URL('dms-documents/'.$dmsDocument->id.'/'.$document.'/remove') }}" onclick="return confirm('Are you sure you want to delete this document?');"><i class="fa fa-trash btn-danger btn"></i></a>
                                        <br/>
                                    @endforeach
                                </div>
                            </div>


                        <div class="privacy" style="display: none;">
                            <div class="table-responsive">
                                <div class="callout callout-danger apply-lv-alert">
                                    <strong>Note:</strong>
                                    <em>Employees List Which Have <b>Downloaded Permission</b>.</em>
                                </div>
                                <table class="table table-bordered">
                                <tr>
                                    <td><b>Employee Name</b></td>
                                    <td><b>Department</b></td>
                                    <td><b>Download</b></td>
                                </tr>
                                @foreach($select_empl_chkbox as $emp_chkbox)
                                    @php  
                                        if($emp_chkbox->download_doc == '0'){
                                            $down_doc = '<span class="label label-danger">'.
                                            "No".'</span>';
                                        }else{
                                            $down_doc = '<span class="label label-success">'."Yes".'</span>';
                                        }

                                    @endphp

                                    <tr>
                                        <td>{{@$emp_chkbox->emp_name}}</td>
                                        <td>{{@$emp_chkbox->dep_name}}</td>
                                        <td>{!! $down_doc !!}</td>
                                    </tr>
                                @endforeach
                            </table>
                            </div> 
                        </div>
                            <!-- Box Body Ends here -->
                            <!-- Box Footer Starts here -->

                             <div class="box-footer text-center">
                                @if($dms_approvals[0]->jrf_status == '0')

                                <input type="submit" class="btn btn-primary submit-btn-style" id="submit2" value="Update & Approved" name="submit">

                                @elseif($dms_approvals[0]->jrf_status == '1')
                                 <input type="submit" class="btn btn-primary submit-btn-style" id="submit2" value="Update" name="submit">
                                @endif
                                <!-- @if($dms_approvals[0]->jrf_status == '0')
                                 <button type="button" class="btn btn-default accountFormSubmit" id="accountFormSubmit"><a href='javascript:void(0)' class="approvalStatus" data-user_id="{{@$dms_approvals[0]->supervisor_id}}" data-dms_document_id="{{@$dms_approvals[0]->dms_document_id}}" data-statusname="Approved" data-final_status="1" data-u_id="{{@$dms_approvals[0]->user_id}}">Approve</a></button>
                                @endif 
                                -->
                                 <button type="button" class="btn btn-default accountFormSubmit" id="accountFormSubmitA" value=""><a href='javascript:void(0)' class="approvalStatus" data-user_id="{{@$dms_approvals[0]->supervisor_id}}" data-dms_document_id="{{@$dms_approvals[0]->dms_document_id}}" data-statusname="Rejected" data-final_status="2" data-u_id="{{@$dms_approvals[0]->user_id}}">Reject</a></button>

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

     <!-- for Rejection -->
 <div class="modal fade" id="jrfsStatusModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Document Approval Form</h4>
            </div>
            <div class="modal-body">
                <form id="jrfStatusForm" action="{{url('save-approve-dms-approval') }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                    <div class="box-body">
                        <div class="form-group">
                            <label for="statusName" class="docType">Selected Status</label>
                            <input type="text" class="form-control" id="statusName" name="statusName" value="" readonly>
                        </div>

                        <input type="hidden" name="dms_document_id" id="dms_document_id">
                        <input type="hidden" name="userId" id="userId">
                        <input type="hidden" name="final_status" id="final_status">
                        <input type="hidden" name="u_id" id="u_id">
                        <div class="form-group">
                            <label for="remark">Remark</label>
                            <textarea class="form-control" rows="5" name="remark" id="remark"></textarea>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <br>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary" id="jrfStatusFormSubmit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- end of rejection -->

@endsection

@section('script')
    <!-- Script Source Files Starts here -->
    <script src="{{asset('public/admin_assets/plugins/dataTables/jquery.dataTables.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/additional-methods.js"></script>
    <!-- Script Source Files Ends here -->

    <!-- Custom Script Starts here -->
    <script>

        //Validation Starts here
        $("#document_form_3").validate({
            rules: {
                "document_name" : {
                    required: true
                },
                "document_keywords" : {
                    required: true
                },
                "document_category" : {
                    required: true
                },
                "department" : {
                    required: true
                },
                "employees" : {
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
                "document_keywords" : {
                    required: "Please select document keyword/keywords"
                },
                "document_category" : {
                    required: "Please select document category"
                },
                "department" : {
                    required: "Select Department/ Departments"
                },
                "employees" : {
                    required: "Select Employee / Employees"
                }
            }
        });
        //Validation Ends here

        $('#departmentIds').change(function() {
            var department_ids = $(this).val();
            console.log(department_ids);
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
                    $("#employees").append('<option>--Select Nation--</option>');
                    if(employees)
                    {
                        var formoption = "";
                        $.each(employees, function(v) {
                            var val = employees[v]
                            formoption += "<option value='" + val['id'] + "'  >" + val['fullname'] + "</option>";
                        });
                        $('#employees').html(formoption);
                    }
                },
                error: function (xhr) {
                    console.log(xhr.responseText);
                }
            });
        });

    </script>

    <script type="text/javascript">

    var docCheckboxesVal = JSON.parse('<?php echo json_encode($select_empl_chkbox);?>');
    var arr = $("#employees").val();
    length = arr.length; 
    var display = '';
    for(var i=0; i < length; i++){
      var langName = $("#employees option[value='"+ arr[i] + "']").text();
      var checkBoxes = '<div class="row field-changes-below"><div class="col-sm-2"><strong class="basic-lang-label">'+langName+'</strong></div><div class="col-sm-4 langright"><label class="checkbox-inline"><input type="checkbox" value="1" name="download_doc'+arr[i]+'[]"  id="download_doc['+arr[i]+']">Download Document</label></div></div>';
      display += checkBoxes;
    }
   
    $(".documentCheckboxess").html("");
    $(".documentCheckboxess").append(display);
    if(docCheckboxesVal.length > 0){
         for(var i=0; i < length; i++){

           if(docCheckboxesVal[i].view_doc == 0){
             $('#view_doc'+docCheckboxesVal[i].employee_id).prop("checked",false);
           }else{
             $('#view_doc'+docCheckboxesVal[i].employee_id).prop("checked",true);
           }
           if(docCheckboxesVal[i].download_doc == 0){
             $('#download_doc'+docCheckboxesVal[i].employee_id).prop("checked",false);
           }else{
             $('#download_doc'+docCheckboxesVal[i].employee_id).prop("checked",true);
           }
       
         }
    }


    // End of Selected values //

        //Add New Employee 

        $("#employees.select2").on('change',function(){
          var arr = $(this).val();
          length = arr.length; 
          var display = '';
          for(var i=0; i < length; i++) {
             var langName = $("#employees option[value='"+ arr[i] + "']").text();
             var checkBoxes = '<div class="row field-changes-below"><div class="col-sm-2"><strong class="basic-lang-label">'+langName+'</strong></div><div class="col-sm-4 langright"><label class="checkbox-inline"><input type="checkbox" value="1"  name="download_doc'+arr[i]+'[]" >Download Document</label><input type="hidden" value="1" name="view_doc['+arr[i]+']"></div></div>';
            display += checkBoxes;
          }
          $(".documentCheckboxess").html("");
          $(".documentCheckboxess").append(display);
        });


    </script>
    <!-- Custom Script Ends here -->

    <!-- /.content-wrapper -->


<script type="text/javascript">
    $(document).ready(function() {
        $("#listLeaveApproval").DataTable({
            scroll: true,
            responsive: true
        });

        $(".approvalStatus").on('click', function() {
           var dms_document_id = $(this).data("dms_document_id");
           var userId = $(this).data("user_id");
           var final_status = $(this).data("final_status");
           var statusname = $(this).data("statusname");
           var u_id = $(this).data("u_id");

           $("#dms_document_id").val(dms_document_id);
           $("#userId").val(userId);
           $("#final_status").val(final_status);
           $("#statusName").val(statusname);
           $("#u_id").val(u_id);
           $('#jrfsStatusModal').modal('show');
        });

        $("#jrfStatusForm").validate({
            rules: {
               "remark": {
                   required: true,
               }
            },
            messages: {
               "remark": {
                   required: 'Please enter a remark.',
               }
            }
        });
    });
</script>

<script type="text/javascript">

    var status = "{{$dmsDocument->privacy_status}}";
    $("#privacy_status").val(status);

    if(status == 'shared'){
        $(".privacy").show();
    }

    $("#privacy_status").click(function () {
      var type = $(this).val();
       if(type == 'shared'){
        $(".privacy").show();
       } else {
        $(".privacy").hide();
       }
    });
 
</script>

@endsection

