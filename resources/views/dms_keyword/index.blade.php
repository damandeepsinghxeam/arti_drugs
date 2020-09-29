@extends('admins.layouts.app')

@section('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.20/css/jquery.dataTables.min.css">

    <style>
        #document_form_3_table tr th,
        #document_form_3_table tr td { vertical-align: middle;}
        .dataTables_wrapper{ padding:5px }
    </style>
@endsection

@section('content')
    <!-- Content Wrapper Starts here -->
    <div class="content-wrapper">

        <!-- Content Header Starts here -->
        <section class="content-header">
            <h1>Document Keywords</h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Dashboard</li>
            </ol>
        </section>
        <!-- Content Header Ends here -->

        <!-- Main content Starts here -->
        <section class="content">
            <div class="row">
                <div class="col-sm-12">
                    <div class="box box-primary">
                    @include('admins.validation_errors')

                        <!-- Form Starts here -->
                            <form id="document_form_3" method="post" action="{{ route('dms.keyword.store') }}">
                            @csrf
                            <!-- Box Body Starts here -->
                                <div class="box-body jrf-form-body">
                                    <div class="form-group">
                                        <label for="document_keyword">Document Keyword<span class="ast">*</span></label>
                                        <input type="text" name="document_keyword" class="@error('document_keyword') is-invalid @enderror form-control input-sm basic-detail-input-style" id="" placeholder="Enter Document Keyword here" required>
                                        @error('document_keyword')
                                        <div class="error alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <!-- Box Body Ends here -->
                                <!-- Box Footer Starts here -->
                                <div class="box-footer text-center">
                                    <input type="submit" class="btn btn-primary submit-btn-style" id="submit2" value="Add" name="submit">
                                </div>
                                <!-- Box Footer Ends here -->
                            </form>
                            <!-- Form Ends here -->

                    <!-- Table Starts here -->
                        <table id="document_form_3_table" class="table table-striped table-responsive table-bordered text-center">
                            <thead class="table-heading-style">
                            <tr>
                                <th>S No.</th>
                                <th>Name</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($dmsKeywords as $dmsKeyword)
                                <tr>
                                    <td>{{ $dmsKeyword->id }}</td>
                                    <td>{{ $dmsKeyword->name }}</td>
                                    <td>
                                            <button class="btn bg-purple" data-toggle="modal" data-target="#editKeywordModal{{ $dmsKeyword->id }}">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                    </td>
                                    <td>
                                            <form method="post" action="{{ route('dms.keyword.destroy', $dmsKeyword->id) }}" onclick="return confirm('Are you sure you want to delete this keyword?');">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                    </td>
                                </tr>

                                <!-- The Modal -->
                                <div class="modal" id="editKeywordModal{{ $dmsKeyword->id }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">

                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                                <h4 class="modal-title">Edit Document Keyword</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>

                                            <!-- Modal body -->
                                            <div class="modal-body">
                                                <!-- Form Starts here -->
                                                <form id="document_form_3" method="post" action="{{ route('dms.keyword.update', $dmsKeyword->id) }}">
                                                @csrf
                                                @method('PATCH')
                                                <!-- Box Body Starts here -->
                                                    <div class="box-body jrf-form-body">
                                                        <div class="form-group">
                                                            <label for="document_keyword">Document Keyword<span class="ast">*</span></label>
                                                            <input type="text" name="document_keyword" class="@error('document_keyword') is-invalid @enderror form-control input-sm basic-detail-input-style" id="" value="{{ $dmsKeyword->name }}" placeholder="Enter Document Keyword here" required>
                                                            @error('document_keyword')
                                                            <div class="error alert-danger">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <!-- Box Body Ends here -->
                                                    <!-- Box Footer Starts here -->
                                                    <div class="box-footer text-center">
                                                        <input type="submit" class="btn btn-primary submit-btn-style" id="submit2" value="Update" name="submit">
                                                    </div>
                                                    <!-- Box Footer Ends here -->
                                                </form>
                                                <!-- Form Ends here -->
                                            </div>

                                            <!-- Modal footer -->
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            </tbody>
                            <tfoot class="table-heading-style">
                            <tr>
                                <th>S No.</th>
                                <th>Name</th>
                                <th>Edit</th>
                                <th>Delete</th>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/additional-methods.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.20/js/jquery.dataTables.min.js"></script>
    <!-- Script Source Files Ends here -->

    <!-- Custom Script Starts here -->
    <script>
        setTimeout(function() {
            $('.error').fadeOut('fast');
        }, 1000);
        //DataTable Starts here
        $("#document_form_3_table").DataTable({
            "scrollX" : true,
            responsive: true
        });
        //DataTable Ends here

        //Validation Starts here
        $("#document_form_3").validate({
            rules: {
                "document_keyword" : {
                    required: true
                }
            },
            messages: {
                "document_keyword" : {
                    required : "Please enter document Keyword"
                }
            }
        });
        //Validation Ends here
    </script>
    <!-- Custom Script Ends here -->
@endsection
