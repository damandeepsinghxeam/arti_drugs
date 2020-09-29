@extends('admins.layouts.app')

@section('content')


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1><i class="fa fa-list"></i> Update LWF</h1>
            <ol class="breadcrumb">
                <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">LWF</a></li>
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
                        <form id="pf_esi" action="{{ route('payroll.lwf.update', $lwf->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <div class="box-body jrf-form-body">
                                <fieldset>

                                    <div class="row">
                                        <div class="col-md-1"></div>
                                        <div class="col-md-10">
                                            <div class="row ">
                                                <div class="col-md-6">
                                                    <label for="state_id" class="basic-detail-label">State<span style="color: red">*</span></label>
                                                    <select id="state_id" class="form-control" name="state_id" required>
                                                        <option disabled selected>-- Select State --</option>
                                                        @foreach($states as $state)
                                                            <option value="{{ $state->id }}" {{ $state->id == $lwf->state_id  ? 'selected' : '' }}>{{ $state->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="tenure" class="basic-detail-label">Tenure<span style="color: red">*</span></label>
                                                    <select id="tenure" class="form-control" name="tenure" required>
                                                        <option disabled selected>-- Select Tenure --</option>
                                                        <option value="yearly" {{ 'yearly' == $lwf->tenure  ? 'selected' : '' }}>Yearly</option>
                                                        <option value="half-yearly" {{ 'half-yearly' == $lwf->tenure  ? 'selected' : '' }}>Half Yearly</option>
                                                        <option value="monthly" {{ 'monthly' == $lwf->tenure  ? 'selected' : '' }}>Monthly</option>
                                                        <option value="quaterly" {{ 'quaterly' == $lwf->tenure  ? 'selected' : '' }}>Quaterly</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <br/>
                                            <div class="row ">
                                                <div class="col-md-6">
                                                    <label for="min_salary" class="basic-detail-label">Min Salary<span style="color: red">*</span></label>
                                                    <input type="number" name="min_salary" class="form-control input-sm basic-detail-input-style regis-input-field" placeholder="Enter Minimum Salary" value="{{ $lwf->min_salary }}" required style="border:1px solid burlywood;border-radius:1px">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="max_salary" class="basic-detail-label">Max Salary (Leave empty if not any max salary fix)<span style="color: red">*</span></label>
                                                    <input type="number" name="max_salary" class="form-control input-sm basic-detail-input-style regis-input-field" placeholder="Enter Maximum Salary" value="{{ $lwf->max_salary }}" style="border:1px solid burlywood;border-radius:1px">
                                                </div>
                                            </div>
                                            <br/>
                                            <div class="row ">
                                                <div class="col-md-6">
                                                    <label for="employee_share" class="basic-detail-label">Employee Share<span style="color: red">*</span></label>
                                                    <input type="number" name="employee_share" class="form-control input-sm basic-detail-input-style regis-input-field" placeholder="Enter Employee Share" value="{{ $lwf->employee_share }}" required style="border:1px solid burlywood;border-radius:1px">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="employer_share" class="basic-detail-label">Employer Share<span style="color: red">*</span></label>
                                                    <input type="number" name="employer_share" class="form-control input-sm basic-detail-input-style regis-input-field" placeholder="Enter Employeer Share" value="{{ $lwf->employer_share }}" required style="border:1px solid burlywood;border-radius:1px">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                                <hr>
                                <div class="text-center">
                                    <input type="submit" class="btn btn-primary submit-btn-style" id="submit3" value="Update" name="submit">
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
