@extends('admins.layouts.app')

@section('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.20/css/jquery.dataTables.min.css">

    <style>
        #document_form_3_table tr th,
        #document_form_3_table tr td { vertical-align: middle;}

        .list-padding { padding: 10px;}
    </style>
@endsection

@section('content')

    <!-- Content Wrapper Starts here -->
    <div class="content-wrapper">

        <!-- Content Header Starts here -->
        <section class="content-header">
            <h1>All Documents</h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">All Documents</li>
            </ol>
        </section>
        <!-- Content Header Ends here -->

        <!-- Main content Starts here -->
        <section class="content">
            <div class="row">
                <div class="col-sm-12">
                    @include('admins.validation_errors')

                   <!--  <form id="document_form_3" method="post" action="{{ route('dms.document.filter') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                           <div class="col-md-4">
                                <div class="form-group">
                                    <label for="document_department">Document Department<span class="ast">*</span></label>
                                    <select name="document_department" class="filter form-control input-sm basic-detail-input-style" id="document_department">
                                        <option value="" selected>Select Department</option>
                                        @foreach($departments as $department)
                                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> 
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="document_category">Document Category<span class="ast">*</span></label>
                                    <select name="document_category" class="filter form-control input-sm basic-detail-input-style" id="document_category">
                                        <option value="" selected>Please Select Document Category</option>
                                        @foreach($dmsCategories as $dmsCategory)
                                            <option value="{{ $dmsCategory->id }}">{{ $dmsCategory->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="document_keyword">Document Keyword<span class="ast">*</span></label>
                                    <select name="document_keyword" class="filter form-control input-sm basic-detail-input-style" id="document_keyword">
                                        <option value="" selected>Select Document Keyword</option>
                                        @foreach($dmsKeywords as $dmsKeyword)
                                            <option value="{{ $dmsKeyword->id }}">{{ $dmsKeyword->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>-->
                    
                        <div class="box-footer text-right">
                            <a href="{{ route('dms.document.create') }}">
                                <button class="btn btn-primary submit-btn-style" id="submit2" value="Add New">Add New</button>
                            </a>
                        </div>

                    <div class="box box-primary list-padding">

                        <!-- Table Starts here -->
                        <table id="document_form_4_table" class="table table-striped table-responsive table-bordered text-center">
                            <thead class="table-heading-style">
                            <tr>
                                <th>S No.</th>
                                <!--<th>Document Raised By</th>
                                <th>Privacy Status</th>
                                <th>Departments</th>
                                <th>Employees</th>-->
                                <th>Document Name</th>
                                <th>Category</th>
                                <th>Keywords</th>
                               <!-- <th>Edit</th>-->
                               <!-- <th>Delete</th> -->
                                <th>Document View</th>
                                <th>Document download</th>
                            </tr>
                            </thead>

                            @php $user_id = Auth::id(); @endphp

                            <tbody>

                            @foreach($dmsDocuments as $document)  

                                @php

                                    if(!empty($document['dmsRequestUser']->user_id)){
                                        $req_user_id = $document['dmsRequestUser']->user_id;
                                    }else{
                                        $req_user_id = "";
                                    } 

                                @endphp

                                <tr>
                                    <td>{{@$loop->iteration}}</td>
                                    <td>{{ $document['name'] }}</td>
                                    <td>{{ $document['category']->name }}</td>
                                    <td>
                                        @foreach($document['keywords'] as $keyword)
                                            <span>{{ $keyword->name }},</span>
                                        @endforeach
                                    </td>

                                    <!-- View Doc Status => Public -->
                                    <td>
                                       <!-- @dump($document->dmsemployee) -->

                                        @if($document['privacy_status'] == 'public')
                                            @if($document['document'] != '' &&  $document['privacy_status'] == 'public' && $document['user_id'] != $user_id)
                                                <div class="dropdown" >
                                                    <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown">
                                                        <i class="fa fa-eye"></i>
                                                    </button>
                                                    <div class="dropdown-menu">   
                                                        @foreach(json_decode($document['document']) as $documentAA)
                                                            <a href="{{ $documentAA }}"><i class="fa fa-eye btn" ></i>{{$documentAA}} </a>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @elseif($document['user_id'] == $user_id)
                                                <span class="label label-info">Self Created Document</span> 
                                            @endif
                                        @endif

                                        <!-- View Doc Status => Private -->

                                        @if($document['privacy_status'] == 'private')
                                            @if($document['user_id'] != $user_id)
                                                <span class="label label-info">Private</span>
                                            @elseif($document['user_id'] == $user_id)
                                                <span class="label label-info">Self Created Document</span>
                                            @endif
                                        @endif

                                        <!-- View Doc Status => Shared -->

                                        @if($document['privacy_status'] == 'shared')

                                            
                                            @if(!empty($document->dmsAuthEmployee) && $document->dmsAuthEmployee->employee_id == $user_id)
                                                <div class="dropdown" >
                                                    <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown">
                                                        <i class="fa fa-eye"></i>
                                                    </button>
                                                    <div class="dropdown-menu">   
                                                        @foreach(json_decode($document['document']) as $documentAA)
                                                        <a target="_blank" href="{{ route('dms.document.view', $documentAA) }}" aria-hidden="true"><i class="fa fa-eye btn"></i>{{$documentAA}} </a>
                                                        @endforeach
                                                    </div>
                                                </div>

                                            @elseif(!empty($document->dmsAuthEmployee) && $document->dmsAuthEmployee->employee_id == $user_id || !empty($document['dmsRequestUser']) && $document['dmsRequestUser']->jrf_status =='0' && ($document['dmsRequestUser']->view_doc =='1' || $document['dmsRequestUser']->download_doc =='1'))
                                                <span class="label label-warning">Request Sent</span>

                                            @elseif(!empty($document->dmsAuthEmployee) && $document->dmsAuthEmployee->employee_id == $user_id || $document['dmsRequestUser'] !="" && $document['dmsRequestUser']->jrf_status =='2' )    
                                                <span class="label label-danger">Request Rejected</span>

                                            @elseif($document['user_id'] == $user_id)
                                                <span class="label label-info">Self Created Document</span>
                                            @else
                                                <!-- if(empty($document->dmsAuthEmployee) || empty($document->dmsRequestUser)) -->
                                                <a href='javascript:void(0)' class="approvalStatus" data-user_id="{{$document['user_id']}}" data-req_user_id="{{$req_user_id}}"data-dms_document_id="{{@$document['id']}}" data-statusname="Approved" data-final_status="1">
                                                    <i class="fa fa-lock" aria-hidden="true" style="font-size:32px;"></i>
                                                </a>

                                            @endif
                                        @endif

                                    </td>


                                    <!-- Download Doc Status => Public -->
                                  <td>
                                        @if($document['privacy_status'] == 'public')
                                            @if($document['document'] != '' &&  $document['privacy_status'] == 'public' && $document['user_id'] != $user_id)
                                                <div class="dropdown" >
                                                    <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown">
                                                        <i class="fa fa-download"></i>
                                                    </button>
                                                    <div class="dropdown-menu">   
                                                        @foreach(json_decode($document['document']) as $documentABC)
                                                            <a href="{{ route('dms.document.download', $documentABC) }}"><i class="fa fa-download btn"></i>{{$documentABC}} </a>
                                                        @endforeach

                                                    </div>
                                                </div>
                                            @elseif($document['user_id'] == $user_id)
                                                <span class="label label-info">Self Created Document</span> 
                                            @endif
                                        @endif


                                        @if($document['privacy_status'] == 'private')
                                            @if($document['user_id'] != $user_id)
                                                <span class="label label-info">Private</span>
                                            @elseif($document['user_id'] == $user_id)
                                                <span class="label label-info">Self Created Document</span>
                                            @endif
                                        @endif


                                        @if($document['privacy_status'] == 'shared')

                                            @if(!empty($document->dmsAuthEmployee) && $document->dmsAuthEmployee->employee_id == $user_id && $document->dmsAuthEmployee->download_doc == '1')
                                                <div class="dropdown" >
                                                    <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown">
                                                        <i class="fa fa-download"></i>
                                                    </button>
                                                    <div class="dropdown-menu">   
                                                        @foreach(json_decode($document['document']) as $documentABC)
                                                            <a href="{{ route('dms.document.download', $documentABC) }}"><i class="fa fa-download btn"></i>{{$documentABC}} </a>
                                                        @endforeach
                                                    </div>
                                                </div>

                                            @elseif(!empty($document->dmsAuthEmployee) && $document->dmsAuthEmployee->employee_id == $user_id && $document['dmsRequestUser'] !="" && $document['dmsRequestUser']->jrf_status =='2' )    
                                                <span class="label label-danger">Request Rejected</span>

                                            @elseif(!empty($document->dmsAuthEmployee) && $document->dmsAuthEmployee->employee_id == $user_id && !empty($document['dmsRequestUser']) && $document['dmsRequestUser']->jrf_status =='0' && ($document['dmsRequestUser']->view_doc =='1' || $document['dmsRequestUser']->download_doc =='1') )
                                                <span class="label label-warning">Request Sent</span>    

                                            @elseif($document['user_id'] == $user_id)
                                                <span class="label label-info">Self Created Document</span>

                                            @else
                                                  <!--if(empty($document->dmsAuthEmployee) || empty($document->dmsRequestUser))-->
                                                <a href='javascript:void(0)' class="approvalStatus" data-user_id="{{$document['user_id']}}" data-req_user_id="{{$req_user_id}}"data-dms_document_id="{{@$document['id']}}" data-statusname="Approved" data-final_status="1">
                                                    <i class="fa fa-lock" aria-hidden="true" style="font-size:32px;"></i>
                                                </a>                                           

                                            @endif
                                        @endif 

                                    </td> 
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot class="table-heading-style">
                            <tr>
                                <th>S No.</th>
                                <!--<th>Document Raised By</th>
                                <th>Privacy Status</th>
                                <th>Departments</th>
                                <th>Employees</th>-->
                                <th>Document Name</th>
                                <th>Category</th>
                                <th>Keywords</th>
                               <!-- <th>Edit</th>-->
                               <!-- <th>Delete</th> -->
                                <th>Document View</th>
                                <th>Document download</th>
                            </tr>
                            </tfoot>
                        </table>
                        <!-- Table Ends here -->

                    </div>
                </div>
            </div>
        </section>
        <!-- Main content Ends Here-->

    </div>


 <!-- for Rejection -->
 <div class="modal fade" id="jrfsStatusModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Request Form</h4>
            </div>
            <div class="modal-body">
                <form id="jrfStatusForm" action="{{url('save-dms-request') }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                    <div class="box-body">
                        <!--<div class="form-group">
                            <label for="statusName" class="docType">Selected Status</label>
                            <input type="text" class="form-control" id="statusName" name="statusName" value="" readonly>
                        </div>-->
                        <div class="row">
                            <div class="form-group col-md-6">
                                <input type="checkbox" class="doc_required" id="doc_required" name="view_doc" value="1" >
                                <label class="form-check-label" for="exampleCheck1">View Document</label>
                                <div class="doc_required_error_div"></div>
                            </div>    

                            <div class="form-group col-md-6">
                                <input type="checkbox" class="doc_required" id="doc_required" name="download_doc" value="1">
                                <label class="form-check-label" for="exampleCheck1">Download Document</label>
                                <div class="doc_required_error_div"></div>
                            </div>
                        </div>

                        <input type="hidden" name="dms_document_id" id="dms_document_id">
                        <input type="hidden" name="userId" id="userId">
                        <input type="hidden" name="final_status" id="final_status">
                        <input type="hidden" name="req_user_id" id="req_user_id">
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

    <!-- Content Wrapper Ends here -->
@endsection



@section('script')
    <!-- Script Source Files Starts here -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.20/js/jquery.dataTables.min.js"></script>

    <script src="{{asset('public/admin_assets/plugins/dataTables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('public/admin_assets/plugins/validations/jquery.validate.js')}}"></script>
    <script src="{{asset('public/admin_assets/plugins/validations/additional-methods.js')}}"></script>

    <!-- Script Source Files Ends here -->

    <!-- Custom Script Starts here -->
    <script>
        //DataTable Starts here
        $("#document_form_4_table").DataTable({
            "scrollX" : true,
            responsive: true
        });
        //DataTable Ends here

        $(".approvalStatus").on('click', function() {
           var dms_document_id = $(this).data("dms_document_id");
           var userId = $(this).data("user_id");
           var final_status = $(this).data("final_status");
           var statusname = $(this).data("statusname");
           var u_id = $(this).data("req_user_id");

           $("#dms_document_id").val(dms_document_id);
           $("#userId").val(userId);
           $("#final_status").val(final_status);
           $("#statusName").val(statusname);
           $("#req_user_id").val(u_id);
           $('#jrfsStatusModal').modal('show');
        });

        $("#jrfStatusForm").validate({
            ignore: ':hidden',
            errorElement: 'span',
            errorPlacement: function(error, element) {
              if (element.is(":checkbox"))
                error.appendTo(element.parent('div').find('.doc_required_error_div'));
              else
                error.appendTo(element.parent());
            },
            rules: {
               "remark": {
                   required: true,
               },
               "view_doc":{
                require_from_group: [1, '.doc_required'],
               },
               "download_doc":{
                require_from_group: [1, '.doc_required'],
               }
            },
            messages: {
                "remark": {
                   required: 'Please enter a remark.',
                },
                "doc_required": {
                    require_from_group: "Please fill at least 1 of these fields."
                },
                "download_doc": {
                    require_from_group: "Please fill at least 1 of these fields."
                }
            }
        });

       


        $('.filter').change(function() {
            var document_department = $("#document_department :selected").val();
            console.log(document_department);
            var document_category = $("#document_category :selected").val();
            console.log(document_category);
            var document_keyword = $("#document_keyword :selected").val();
            console.log(document_keyword);
            $.ajax({
                type: 'POST',
                url: '{{ URL('dms-documents/department/filter') }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    document_department: document_department,
                    document_category: document_category,
                    document_keyword: document_keyword
                },
                success: function (data) {
                    console.log('success');
                    console.log(data);
                    $('tbody').html(data);
                },
                error: function (xhr) {
                    console.log('error');
                    console.log(xhr.responseText);
                }
            });
        });
    </script>

  
    <script> 
        function getIframeContent(frameID) { 
            alert("+++++++++++");
            var frameObj =  
                document.getElementById(frameID); 
            var frameContent = frameObj 
                .contentWindow.document.body.innerHTML; 
  
            alert("frame content : " + frameContent); 
        } 
    </script> 

    <!-- Custom Script Ends here -->
@endsection

