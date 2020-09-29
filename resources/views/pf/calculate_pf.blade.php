@extends('admins.layouts.app')

@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1><i class="fa fa-list"></i> Calculate PF</h1>
            <ol class="breadcrumb">
                <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">Calculate PF</a></li>
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
                        <form id="pf_esi" action="" method="POST">
                            @csrf
                            <div class="box-body jrf-form-body">
                                <fieldset>
                                    <legend>Calculate Provident Fund</legend>

                                    <div class="form-group row col-md-12">

                                        <div class="col-md-4">
                                            <label for="epf_percent" class="basic-detail-label">EPF(%)<span style="color: red">*</span></label>
                                            <input type="number" name="epf_percent" id="epf_percent" class="form-control experiencedata regis-input-field only_numeric" placeholder="Total EPF percentage (%)">
                                        </div>

                                        <div class="col-md-4">
                                            <label for="salary" class="basic-detail-label">Salary<span style="color: red">*</span></label>
                                            <input type="number" name="salary" id="salary" class="form-control experiencedata regis-input-field only_numeric" placeholder="Salary of the employee">
                                        </div>

                                        <div class="col-md-1" style="top:30px">
                                            <span style="margin-left: 15px">=</span>
                                        </div>

                                        <div class="col-md-3">
                                            <label for="name" class="basic-detail-label">Result.<span style="color: red">*</span></label>
                                            <input type="number" name="result" id="result" class="form-control experiencedata regis-input-field only_numeric" placeholder="Total ESI">
                                        </div>
                                    </div>

                                </fieldset>
                                <hr>
                                <div class="text-center">
                                    <input type="" class="btn btn-primary submit-btn-style" id="submit" value="Submit" name="submit">
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

            var pfInterest = $('#epf_percent').val();
            console.log(pfInterest);

            $.ajax({
                type: 'POST',
                url: '{{ URL('payroll/pfs/calculate-pf') }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    salary: salary,
                    epf_percent: pfInterest
                },
                success: function (data) {
                    console.log(data.result)
                    $("#result").val(data.result);
                    $('#message').html('<div class="error alert alert-success">Successfully PF Calculated</div>')
                },
                error: function (xhr) {
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
