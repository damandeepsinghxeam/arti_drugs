@extends('admins.layouts.app')

@section('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.20/css/jquery.dataTables.min.css">

    <style>
        .heading2_form {
            font-size: 20px;
            text-decoration: underline;
            text-align: center;
        }
        .basic-detail-label {
            padding-right: 0px;
            padding-top: 4px;
        }
    </style>
@endsection

@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Salary Heads</h1>
            <ol class="breadcrumb">
                <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="box box-primary">
                        <!-- form start -->
                        @include('admins.validation_errors')
                        <div class="box-body jrf-form-body">
                            @can('create-salary-head')
                                <form id="salary_heads" method="POST" method="{{ route('payroll.salary.head.store') }}" class="form-horizontal">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="row field-changes-below">
                                                <div class="col-md-4 text-right">
                                                    <label for="salary_head" class="basic-detail-label">Name<span style="color: red">*</span></label>
                                                </div>
                                                <div class="col-md-8">
                                                    <input type="text" name="salary_head" id="salary_head" class="@error('salary_head') is-invalid @enderror form-control input-sm basic-detail-input-style"placeholder="Enter Salary Head Name" required>
                                                    @error('salary_head')
                                                    <div class="error alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row field-changes-below">
                                                <div class="col-md-4 text-right">
                                                    <label for="type" class="basic-detail-label">Type<span style="color: red">*</span></label>
                                                </div>
                                                <div class="col-md-8">
                                                    <Select name="type" id="type" class="form-control input-sm basic-detail-input-style">
                                                        <option value="earning">Earning</option>
                                                        <option value="deduction">Deduction</option>
                                                    </Select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="box-footer create-footer text-center">
                                        <input type="submit" class="btn btn-primary" id="submit3" value="Submit" name="submit">
                                    </div>
                                </form>
                            @endcan

                            <h2 class="heading2_form">Salary Heads List:</h2>
                            <!--KRA Table Starts here-->
                            <table class="table table-striped table-responsive table-bordered" id="salary_heads_table">
                                <thead class="table-heading-style">
                                <tr>
                                    <th>S No.</th>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                                </thead>
                                <tbody class="kra_tbody">
                                <?php $serialNumber = 1; ?>
                                @foreach($salaryHeads as $salaryHead)
                                    <tr>
                                        <td>{{ $serialNumber }}</td>
                                        <td>
                                            <span>{{ ucfirst($salaryHead->name) }}</span>
                                        </td>
                                        <td>
                                            <span>{{ ucfirst($salaryHead->type) }}</span>
                                        </td>
                                        <td>
                                            @can('update', $salaryHead)
                                                <button class="btn btn-primary" data-toggle="modal" data-target="#editSalaryHeadModal{{ $salaryHead->id }}">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                            @endcan
                                        </td>
                                        <td>
                                            @can('delete', $salaryHead)
                                                <form method="post" action="{{ route('payroll.salary.head.destroy', $salaryHead->id) }}" onclick="return confirm('Are you sure you want to delete this keyword?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endcan
                                        </td>
                                    </tr>


                                    <!-- The Modal -->
                                    <div class="modal" id="editSalaryHeadModal{{ $salaryHead->id }}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">

                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Edit Salary Head</h4>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>

                                                <!-- Modal body -->
                                                <div class="modal-body">
                                                    <!-- Form Starts here -->
                                                    <form id="document_form_3" method="post" action="{{ route('payroll.salary.head.update', $salaryHead->id) }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <!-- Box Body Starts here -->
                                                        <div class="box-body jrf-form-body">
                                                            <div class="form-group">
                                                                <label for="salary_head">Name<span class="ast">*</span></label>
                                                                <input type="text" name="salary_head" class="@error('salary_head') is-invalid @enderror form-control input-sm basic-detail-input-style" id="" value="{{ $salaryHead->name }}" placeholder="Enter Document Keyword here" required>
                                                                @error('salary_head')
                                                                <div class="error alert-danger">{{ $message }}</div>
                                                                @enderror
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="type">Type<span class="ast">*</span></label>
                                                                <Select name="type" id="type" class="form-control input-sm basic-detail-input-style">
                                                                    <option value="earning" {{$salaryHead->type == 'earning' ? 'selected' : ''}}>Earning</option>
                                                                    <option value="deduction" {{$salaryHead->type == 'deduction' ? 'selected' : ''}}>Deduction</option>
                                                                </Select>
                                                                @error('type')
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
                                    <?php $serialNumber++; ?>
                                @endforeach
                                </tbody>
                                <tfoot class="table-heading-style">
                                <th>S No.</th>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Edit</th>
                                <th>Delete</th>
                                </tfoot>
                            </table>
                            <!--KRA Table Ends here-->
                        </div>
                    </div>
                </div>
                <!-- /.box -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/additional-methods.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.20/js/jquery.dataTables.min.js"></script>

    <script>
        setTimeout(function() {
            $('.error').fadeOut('fast');
        }, 1000);

        setTimeout(function() {
            $('.success').fadeOut('fast');
        }, 1000);

        $('#salary_heads_table').DataTable({
            "scrollX": true,
            responsive: true
        });

        $("#salary_heads").validate({
            rules: {
                "name" : {
                    required: true
                }
            },
            messages: {
                "name" : {
                    required: 'Please enter name'
                }
            }
        });


        /*Script for checkbox selection starts here*/
        $('.selectAllCheckBoxes').on('change', function(){
            //event.preventDefault(); event.stopPropagation();

            if($(this).is(':checked')) {
                $('.kra_tbody input:checkbox').prop('checked', true);
            }else {
                $('.kra_tbody input:checkbox').prop('checked', false);
            }
        });
        /*Script for checkbox selection ends here*/

    </script>

@endsection

