@extends('admins.layouts.app')

@section('content')


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1><i class="fa fa-list"></i> Update Salary Sheet</h1>
            <ol class="breadcrumb">
                <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">Salary Sheet</a></li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="box box-primary">
                    @include('admins.validation_errors')

                    <!-- form start -->
                        <form id="pf_esi" action="{{ route('payroll.salary.sheet.update', $salarySheet->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <div class="box-body jrf-form-body">
                                <fieldset>
                                    <div class="form-group row col-md-12">
                                        <div class="col-md-4">
                                            <label for="name" class="basic-detail-label">Salary Of<span style="color: red">*</span></label>
                                            <input type="date" name="salary_of" value="{{ $salarySheet->date }}" id="" class="form-control">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="name" class="basic-detail-label">Employee Code</label>
                                            <input type="text" name="employee_code" id="" value="{{ $salarySheet->employee_code }}" placeholder="Employee Code" class="form-control" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row col-md-12">
                                        <div class="col-md-4">
                                            <label for="name" class="basic-detail-label">Total Month Days</label>
                                            <input type="number" name="total_month_days" id="" value="{{ $salarySheet->total_month_days }}" placeholder="UnPaid Days" class="form-control experiencedata regis-input-field only_numeric">
                                        </div>

                                        <div class="col-md-4">
                                            <label for="name" class="basic-detail-label">Paid Days</label>
                                            <input type="number" name="paid_days" id="" placeholder="Paid Days" value="{{ $salarySheet->paid_days }}" class="form-control experiencedata regis-input-field only_numeric">
                                        </div>

                                        <div class="col-md-4">
                                            <label for="name" class="basic-detail-label">UnPaid Days</label>
                                            <input type="number" name="unpaid_days" id="" placeholder="UnPaid Days" value="{{ $salarySheet->unpaid_days }}" class="form-control experiencedata regis-input-field only_numeric">
                                        </div>
                                    </div>
                                </fieldset>
                                <hr>
                                <div class="text-center">
                                    <input type="submit" class="btn btn-primary submit-btn-style" id="submit3" value="Submit" name="submit">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /.box -->
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <script src="{{asset('public/admin_assets/plugins/validations/jquery.validate.js')}}"></script>

    <script src="{{asset('public/admin_assets/plugins/validations/additional-methods.js')}}"></script>
    <script>
        $(function () {
            //Date picker
            $('.datepicker').datepicker({
                autoclose: true,
                orientation: "bottom",
                format: 'yyyy-mm-dd'
            });
        });
    </script>
@endsection
