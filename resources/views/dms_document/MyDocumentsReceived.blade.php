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
            <h1>My Documents</h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
                <li class="active">Dms Documents</li>
            </ol>
        </section>
        <!-- Content Header Ends here -->

        <!-- Main content Starts here -->
        <section class="content">
            <div class="row">
                <div class="col-sm-12">
                     @include('admins.validation_errors')

                    <div class="box box-primary list-padding">

                        <!-- Table Starts here -->
                        <table id="document_form_4_table" class="table table-striped table-responsive table-bordered text-center">
                            <thead class="table-heading-style">
                            <tr>
                                <th>S No.</th>
                                <th>Document Raised By</th>
                                <th>Document Name</th>
                                <th>Category</th>
                                <!--<th>Keywords</th> -->
                                <th>View</th>
                                <th>Download</th>
                            </tr>
                            </thead>

                            @php $user_id = Auth::id(); @endphp
                            
                            <tbody>

                            @foreach($data['dmsDocuments'] as $document)
                            
                                <tr>
                                    <td>{{@$loop->iteration}}</td>
                                    <td>{{ $document->emp_name }}</td>
                                    <td>{{ $document->name }}</td>
                                    <td>{{ $document->category_name }}</td>
                                    
                                    <td>
                                        @if($document->view_doc == '1' )

                                            <div class="dropdown">
                                                <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown">
                                                <i class="fa fa-eye"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    @foreach(json_decode($document->document) as $documentAA)

                                                        <a target="_blank" href="{{ route('dms.document.view', $documentAA) }}" aria-hidden="true"><i class="fa fa-eye btn"></i>{{$documentAA}} </a>

                                                        <!--<a target="_blank" href="{{ url("public/uploads/document/".$documentAA) }}" aria-hidden="true"><i class="fa fa-eye btn"></i>{{$documentAA}} </a> -->
                                                    
                                                    @endforeach
                                                </div>
                                            </div>

                                        @elseif($document->jrf_status == '0' && $document->employee_id == $user_id)
                                        <span class="label label-warning">Request Sent</span>
                                        
                                        @elseif($document->jrf_status == '2' && $document->req_user_id == $user_id)
                                        <span class="label label-danger">Request Rejected</span>

                                        @else
                                           <a href='javascript:void(0)' class="approvalStatus" data-user_id="{{$document->employee_id}}" data-dms_document_id="{{@$document->dms_document_id}}" data-statusname="Approved" data-final_status="1"><i class="fa fa-lock" aria-hidden="true" style="font-size:32px;"></i></a>
                                        @endif


                                    </td>

                                    <td>
                                        @if($document->download_doc == '1' && $document->employee_id == $user_id )

                                            <div class="dropdown">
                                                <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown">
                                                <i class="fa fa-download"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    @foreach(json_decode($document->document) as $document)
                                                        <a target="_blank" href="{{ route('dms.document.download', $document) }}" aria-hidden="true"><i class="fa fa-download btn"></i>{{$document}} </a>
                                                    @endforeach
                                                </div>
                                            </div>

                                        @elseif($document->jrf_status == '0' && $document->employee_id == $user_id)
                                        <span class="label label-warning">Request Sent</span>
                                        
                                        @elseif($document->jrf_status == '2' && $document->req_user_id == $user_id)
                                        <span class="label label-danger">Request Rejected</span>

                                        @else
                                           <a href='javascript:void(0)' class="approvalStatus" data-user_id="{{$document->employee_id}}" data-dms_document_id="{{@$document->dms_document_id}}" data-statusname="Approved" data-final_status="1"><i class="fa fa-lock" aria-hidden="true" style="font-size:32px;"></i></a>
                                        @endif
                                    </td>  
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot class="table-heading-style">
                            <tr>
                                <th>S No.</th>
                                <th>Document Raised By</th>
                                <th>Document Name</th>
                                <th>Category</th>
                                 <!--<th>Keywords</th> -->
                                <th>View</th>
                                <th>Download</th>
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
    <!-- Content Wrapper Ends here -->



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
                                <input type="checkbox" class="doc_required" id="doc_required" name="download_doc" value="1">
                                <label class="form-check-label" for="exampleCheck1">Download Document</label>
                                <div class="doc_required_error_div"></div>
                            </div>
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

        $(".unassignBtn").on('click',function(){
            if (!confirm("Are you sure you want to Cancel  this Document?")) {
                return false; 
            }else{

            }
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


    </script>

    <script type="text/javascript">
        
        $( document ).ready(function(event) {
        // Allow: dot, backspace, delete, tab, decimal point,escape, and enter
        
        if ( event.keyCode == 190 || event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 110 || event.keyCode == 27 || event.keyCode == 13 ||
        // Allow: home, end, left, right
        
        (event.keyCode >= 35 && event.keyCode <= 39)) {
            // let it happen, don't do anything
            return;
        }else{

        // Ensure that it is a number and stop the keypress

        // do not allow 86 =>Ctrl+V ,67 => Ctrl+C,65=>Ctrl+A, 112 =>F12
        
        if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 ) && (event.keyCode == 17 || event.keyCode == 86 || event.keyCode == 67 || event.keyCode == 65 || event.keyCode == 112)) {
              event.preventDefault();
        }  
      }


    });

    </script>
    <script type="text/javascript">   
        document.addEventListener('contextmenu', event => event.preventDefault());
    </script>


  <!--  <body oncontextmenu="return false;"> -->

    <!-- Custom Script Ends here -->
@endsection

