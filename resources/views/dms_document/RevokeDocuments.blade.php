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
            <h1>Revoke Requests Documents(Approved Documents)</h1>
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
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($dmsDocuments as $document)

                                @php 
                                    if($document->download_doc == 1){
                                        $doc_down = '<span class="label label-success">'."YES".'<span>';
                                    }else{
                                        $doc_down = '<span class="label label-danger">'."NO".'<span>';
                                    }

                                    if($document->view_doc == 1){
                                        $doc_view = '<span class="label label-success">'."YES".'<span>';
                                    }else{
                                        $doc_view = '<span class="label label-danger">'."NO".'<span>';
                                    }

                                @endphp


                                <tr>
                                    <td>{{@$loop->iteration}}</td>
                                    <td>{{ $document->emp_name }}</td>
                                    <td>{{ $document->doc_name }}</td>
                                    <td>{{ $document->category_name }}</td>
                                    
                                    <td>{!! $doc_view !!}</td>
                                    <td>{!! $doc_down !!}</td>
                                   
                                    <td>
                                        <a class="btn btn-xs bg-blue unassignBtn" href='{{ url("document-revoke")."/".$document->dms_document_id."/".$document->user_id}}' title="Revoke"><i class="fa fa-check" aria-hidden="true"></i>Revoke Document</a>
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
                                <th>Action</th>
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
@endsection

@section('script')
    <!-- Script Source Files Starts here -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.20/js/jquery.dataTables.min.js"></script>
    <!-- Script Source Files Ends here -->

    <!-- Custom Script Starts here -->
    <script>
        //DataTable Starts here
        $("#document_form_4_table").DataTable({
            "scrollX" : true,
            responsive: true
        });

        $(".unassignBtn").on('click',function(){
            if (!confirm("Are you sure you want to Revoke  this Document?")) {
                return false; 
            }else{

            }
        });

    </script>

    <!-- Custom Script Ends here -->
@endsection

