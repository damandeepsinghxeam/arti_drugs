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
            <h1>Requested  Documents</h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Requested  Documents</li>
            </ol>
        </section>
        <!-- Content Header Ends here -->

        <!-- Main content Starts here -->
        <section class="content">
            <div class="row">
                <div class="col-sm-12">

                    <div class="box box-primary list-padding">

                        <!-- Table Starts here -->
                        <table id="document_form_4_table" class="table table-striped table-responsive table-bordered text-center">
                            <thead class="table-heading-style">
                            <tr>
                                <th>S No.</th>
                                <th>Document Name</th>
                                <th>Category</th>
                                <th>Status</th>


                            </tr>
                            </thead>
                            <tbody>
                            @foreach($doc as $document)
                                <tr>
                                    <td>{{@$loop->iteration}}</td>
                                    <td>{{ $document->doc_name}}</td>
                                    <td>{{ $document->category_name }}</td> 
                                   <td>
                                        @if($document->jrf_status == '1')
                                            <span class="label label-success">Request Approved</span>
                                        @elseif($document->jrf_status == '0' && $document->revoke_requests=='No')
                                            <span class="label label-warning">Approval Pending</span>
                                        @elseif($document->jrf_status == '0' && $document->revoke_requests=='Yes')
                                            <span class="label label-danger">Permission Has Been Revoked</span>     
                                        @else
                                            <span class="label label-danger">Request Rejected</span>
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
        //DataTable Ends here
    </script>
    <!-- Custom Script Ends here -->
@endsection

