@extends('admins.layouts.app')

@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1><i class="fa fa-list"></i> Calculate ESIC</h1>
            <ol class="breadcrumb">
                <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">Calculate ESIC</a></li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="box box-primary">
                    @include('admins.validation_errors')
                        <div id="message"></div>

                    <!-- form start -->
                        <form id="esi" action="" method="POST">
                            @csrf
                            <div class="box-body jrf-form-body">
                                <fieldset>
                                    <legend>Calculate ESIC</legend>


                                   <div class="form-group row col-md-12">
                                        <div class="col-md-3">
                                            <label for="name" class="basic-detail-label">Employee(%)<span style="color: red">*</span></label>
                                            <input type="text" name="employee_percent" id="employee_percent" class="form-control experiencedata regis-input-field only_numeric" placeholder="Percentage share of employee (%)">
                                        </div>

                                        <div class="col-md-3">
                                            <label for="name" class="basic-detail-label">Employer(%)<span style="color: red">*</span></label>
                                            <input type="text" name="employer_percent" id="employer_percent" class="form-control experiencedata regis-input-field only_numeric" placeholder="Percentage share of employer (%)">
                                        </div>

                                        <div class="col-md-3">
                                            <label for="salary" class="basic-detail-label">Salary</label>
                                            <input type="text" name="salary" id="salary" class="form-control experiencedata regis-input-field only_numeric" placeholder="Salary of the employee">
                                        </div>

                                        <div class="col-md-3">
                                            <label for="result" class="basic-detail-label">Total Esi</label>
                                            <input type="text" name="result" id="result" class="form-control experiencedata regis-input-field only_numeric" placeholder="Total ESI">
                                        </div>
                                    </div>

                                </fieldset>
                                <hr>
                                <div class="text-center">
                                    <input type="button" class="btn btn-primary submit-btn-style" id="submit" value="Calculate" name="submit">
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

    <script>
        $("#submit").click(function(e){
            var salary = $('#salary').val();
            console.log(salary);

            var employeePercent = $('#employee_percent').val();
            console.log(employeePercent);

            var employerPercent = $('#employer_percent').val();
            console.log(employerPercent);

            $.ajax({
                type: 'POST',
                url: '{{ URL('payroll/esi/calculate-esi') }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    salary: salary,
                    employee_percent: employeePercent,
                    employer_percent: employerPercent
                },
                success: function (data) {
                    console.log(data);
                    $("#result").val(data.result);
                    $('#message').html('<div class="error alert alert-success">Successfully ESI Calculated</div>')

                },
                error: function (xhr) {
                    console.log("error");
                    console.log(xhr.responseText);
                },
                complete: function () {
                    setTimeout(function() {
                        $('#message').fadeOut('fast');
                    }, 1000);
                }
            });
        });
    </script>
@endsection
