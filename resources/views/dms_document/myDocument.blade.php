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
            <h1>Send Documents For Approval</h1>
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
                                <th>Document Name</th>
                                <th>Category</th>
                                <th>Privacy Status</th>
                                <!--<th>Keywords</th>-->
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($dmsDocuments as $document)


                                @php 
                                    if($document->privacy_status == 'public')
                                        $status = '<span class="label label-warning">'.$document->privacy_status.'<span>';
                                    else if($document->privacy_status == 'private')
                                        $status = '<span class="label label-primary" >'.$document->privacy_status.'<span>';
                                    else
                                        $status = '<span class="label label-info">'.$document->privacy_status.'<span>';
                                @endphp 

                                <tr>
                                    <td>{{@$loop->iteration}}</td>
                                    <td>{{ $document->name }}</td>
                                    <td>{{ $document->dms_category }}</td>
                                    <td>{!! $status !!}</td>
                
                                    <td>
                                        @if($document->document != '' && $document->jrf_status == '1' && $document->isactive == '1')
                                            <span class="label label-success">Document Approved</span>
                                        @elseif($document->jrf_status == '2')
                                            <span class="label label-danger">Document Rejected</span>
                                        @elseif($document->approve_status == '0' && $document->isactive == '1')
                                            <a class="btn btn-xs bg-blue unassignBtn" href='{{ url("document-cancel")."/".$document->id}}' title="Cancel"><i class="fa fa-check" aria-hidden="true"></i>Cancel</a>
                                        @else
                                            <span class="label label-warning">Document Cancel</span>                        
                                        @endif 
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot class="table-heading-style">
                            <tr>
                                <th>S No.</th>
                                <th>Document Name</th>
                                <th>Category</th>
                                <th>Privacy Status</th>
                                <!--<th>Keywords</th>-->
                                <th>Status</th>
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
            if (!confirm("Are you sure you want to Cancel  this Document?")) {
                return false; 
            }else{

            }
        });

    </script>

    <!-- Custom Script Ends here -->
@endsection

