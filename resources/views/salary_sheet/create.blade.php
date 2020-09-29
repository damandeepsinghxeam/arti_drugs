@extends('admins.layouts.app')

@section('content')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css" integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1><i class="fa fa-list"></i> Create Salary Sheet</h1>
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
                        <form id="pf_esi" action="{{ route('payroll.salary.sheet.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="box-body jrf-form-body">
                                <fieldset>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="year">Year<span class="ast">*</span></label>
                                                <select name="year" class="filter form-control input-sm basic-detail-input-style" id="year" required>
                                                    <option value="" selected>Select Year</option>
                                                    @foreach($years as $year)
                                                        <option value="{{ $year }}">{{ $year }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="month">Month<span class="ast">*</span></label>
                                                <select name="month" class="filter form-control input-sm basic-detail-input-style" id="month" required>
                                                    <option value="" selected disabled>Please Select Month</option>
                                                    <option value="01">January</option>
                                                    <option value="02">February</option>
                                                    <option value="03">March</option>
                                                    <option value="04">April</option>
                                                    <option value="05">May</option>
                                                    <option value="06">June</option>
                                                    <option value="07">July</option>
                                                    <option value="08">August</option>
                                                    <option value="09">September</option>
                                                    <option value="10">October</option>
                                                    <option value="11">November</option>
                                                    <option value="12">December</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row ">
                                        <div class="col-md-4">
                                            <label for="project_id" class="basic-detail-label">Project<span style="color: red">*</span></label>
                                            <select id="project_id" name="project_id" class="form-control" required>
                                                <option value="" selected>Select Project</option>
                                            @foreach($projects as $project)
                                                    <option value="{{ $project->id }}">{{ $project->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="department_id" class="basic-detail-label">Department<span style="color: red">*</span></label>
                                            <select id="department_id" name="department_id" class="form-control">
                                                <option value="" selected> Select Department </option>
                                                <option value="all">All</option>
                                                @foreach($departments as $department)
                                                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <br/>
{{--                                    <div class="form-group row col-md-12">--}}
{{--                                        <div id="upload">--}}
{{--                                            <div class="col-md-4">--}}
{{--                                                <label for="name" class="basic-detail-label">Upload Employees Details</label>--}}
{{--                                                <input type="file" name="file" id="" class="form-control experiencedata regis-input-field only_numeric">--}}
{{--                                            </div>--}}
{{--                                        </div>--}}

{{--                                        <div id="single">--}}
{{--                                            <div class="col-md-3">--}}
{{--                                                <label for="name" class="basic-detail-label">Employee Code</label>--}}
{{--                                                <select type="text" name="employee_code" id="" placeholder="Employee Code" class="form-control">--}}
{{--                                                    @foreach($employeeCodes as $employeeCode)--}}
{{--                                                        <option value="{{ $employeeCode }}">{{ $employeeCode }}</option>--}}
{{--                                                    @endforeach--}}
{{--                                                </select>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}

{{--                                    </div>--}}
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

        $(document).ready(function() {
            $('#project_id').selectize({
                sortField: 'text'
            });

            $('#department_id').selectize({
                sortField: 'text'
            });

            $('#upload').hide();
            $('#single').hide();

            $('#employee_detail_type').change(function() {
                var employeeDetailType = $(this).val();
                if(employeeDetailType == 'upload'){
                    $('#upload').show();
                    $('#single').hide();
                }else if(employeeDetailType == 'single'){
                    $('#upload').hide();
                    $('#single').show();
                }
            });
        });
    </script>
@endsection
