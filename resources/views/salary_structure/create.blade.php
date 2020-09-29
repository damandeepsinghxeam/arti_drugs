@extends('admins.layouts.app')

@section('content')
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
        .small-input-box{ width: 70px; }
        .extra-small{ width: 30px; }

        /* checkbox css */
        /* The t-check-container */
        .t-check-container {
            display: inline-block;
            position: relative;
            padding-left: 21px;
            margin-bottom: 13px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 500;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        /* Hide the browser's default checkbox */
        .t-check-container input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
            height: 0;
            width: 0;
        }

        /* Create a custom checkbox */
        .task-checkmark {
            position: absolute;
            top: 0;
            left: 0;
            height: 18px;
            width: 18px;
            background-color: #a6ddfd;
        }

        /* On mouse-over, add a grey background color */
        .t-check-container:hover input ~ .task-checkmark {
            background-color: #7dc1e8;
        }

        /* When the checkbox is checked, add a blue background */
        .t-check-container input:checked ~ .task-checkmark {
            background-color: #2196F3;
        }

        /* Create the task-checkmark/indicator (hidden when not checked) */
        .task-checkmark:after {
            content: "";
            position: absolute;
            display: none;
        }

        /* Show the task-checkmark when checked */
        .t-check-container input:checked ~ .task-checkmark:after {
            display: block;
        }

        /* Style the task-checkmark/indicator */
        .t-check-container .task-checkmark:after {
            left: 7px;
            top: 3px;
            width: 5px;
            height: 10px;
            border: solid white;
            border-width: 0 3px 3px 0;
            -webkit-transform: rotate(45deg);
            -ms-transform: rotate(45deg);
            transform: rotate(45deg);
        }
        /* checkbox css */
    </style>

    <link rel="stylesheet" href="{{asset('public/admin_assets/plugins/dataTables/jquery.dataTables.min.css')}}">
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">

            <ol class="breadcrumb">
                <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Small boxes (Stat box) -->
            <div class="row" id="app">
                <div class="col-sm-12">
                    <div class="box box-primary">
                        <!-- form start -->
                    @include('admins.validation_errors')

                    <!-- tab-pane -->
                        <div class="tab-pane" id="tab_salaryStructureTab">
                            <!-- Form Starts here -->
                            <form id="project_approval_handover" method="POST" action="{{ route('payroll.salary.structure.store') }}" >
                                {{ csrf_field() }}
                                <div class="box-body jrf-form-body">

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="row field-changes-below">
                                                <div class="col-md-4 text-right">
                                                    <label for="project_id" class="basic-detail-label">Project<span style="color: red">*</span></label>
                                                </div>
                                                <div class="col-md-8">
                                                    <select name="project_id" id="project_id" class="form-control " required>
                                                        <option value="">Select Project</option>
                                                        @foreach($projects as $p)
                                                            <option value="{{$p->id}}">{{$p->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="row field-changes-below">
                                                <div class="col-md-4 text-right">
                                                    <label for="salary_cycle" class="basic-detail-label">Salary Cycle<span style="color: red">*</span></label>
                                                </div>
                                                <div class="col-md-8">
                                                    <Select name="salary_cycle" id="salary_cycle" class="form-control input-sm basic-detail-input-style" required>
                                                        <option selected disabled>--Select Salary Cycle--</option>
                                                    </Select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="row field-changes-below">
                                                <div class="col-md-4 text-right">
                                                    <label for="pt_rate_applicable" class="basic-detail-label">PT-Rate Apply/Not Apply<span style="color: red">*</span></label>
                                                </div>
                                                <div class="col-md-8">
                                                    <Select name="pt_rate_applicable" id="pt_rate_applicable" class="form-control input-sm basic-detail-input-style" required>
                                                        <option selected value="1">Applied</option>
                                                        <option value="0">Not Applied</option>
                                                    </Select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <br/>
                                    <h4 class="text-center " style="text-decoration: underline;"><b>EARNINGS</b></h4>

                                    <!-- Row starts here -->
                                    <table class="table table-borderless">
                                        <thead>
                                        <tr>
                                            <th>Salary Head Name</th>
                                            <th>
                                                <label class="t-check-container">

                                                    <input type="checkbox" class="singlecheckbox" id="earningCheckbox">
                                                    <span class="task-checkmark"></span>
                                                </label> Is Active </th>
                                            <th>
                                                <label class="t-check-container">
                                                    <input type="checkbox" class="singlecheckbox" id="earningPfApplicableCheckbox">
                                                    <span class="task-checkmark"></span>
                                                </label> PF Applicable
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        <!-- Left column starts here -->
                                        @foreach($earningSalaryHeads as $p)
                                            <tr>
                                                <td><span class="text-bold">{{ ucfirst($p->name) }}</span></td>
                                                <td>
                                                    <label class="t-check-container">
                                                        <input type="checkbox" class="singlecheckbox earningHead" value="{{ $p->id }}" name="earning_heads[]">
                                                        <span class="task-checkmark"></span>
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="t-check-container">
                                                        <input type="checkbox" class="singlecheckbox earningPfApplicable" value="1" name="earning_head_pf_applicables[]">
                                                        <span class="task-checkmark"></span>
                                                    </label>
                                                </td>
                                            </tr>
                                        @endforeach
                                        <!-- Left column Ends here -->
                                        </tbody>
                                    </table>
                                    <!-- Table Ends here -->

                                    <br/>
                                    <h4 class="text-center mt-5" style="text-decoration: underline;"><b>DEDUCTIONS</b></h4>
                                    <table class="table table-borderless">
                                        <thead>
                                        <tr>
                                            <th>Salary Head Name</th>
                                            <th>
                                                <label class="t-check-container">
                                                    <input type="checkbox" class="singlecheckbox" id="deductionCheckbox">
                                                    <span class="task-checkmark"></span>
                                                </label> Is Active </th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        <!-- Left column starts here -->
                                        @foreach($deductionSalaryHeads as $p)
                                            <tr>
                                                <td><span class="text-bold">{{ ucfirst($p->name) }}</span></td>
                                                <td>
                                                    <label class="t-check-container">
                                                        <input type="checkbox" value="{{ $p->id }}" class="singlecheckbox deductionHead" name="deduction_heads[]">
                                                        <span class="task-checkmark"></span>
                                                    </label>
                                                </td>
                                            </tr>
                                        @endforeach
                                        <!-- Left column Ends here -->
                                        </tbody>
                                    </table>
                                </div>
                                <hr>
                                <div class="text-center">
                                    <input type="submit" class="btn btn-success" id="save" value="Save" name="save">
                                </div>
                            </form>
                            <!-- Form Ends here -->
                        </div>
                        <!-- /.tab-pane -->

                    </div>
                </div>
                <!-- /.box -->
            </div>
            <!-- /.row -->
        </section>4
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <script type="text/javascript">

        $('#earningCheckbox').click(function(event) {
            if(this.checked) {
                // Iterate each checkbox
                $('.earningHead').each(function() {
                    this.checked = true;
                });
            } else {
                $('.earningHead').each(function() {
                    this.checked = false;
                });
            }
        });

        $('#earningPfApplicableCheckbox').click(function(event) {
            if(this.checked) {
                // Iterate each checkbox
                $('.earningPfApplicable').each(function() {
                    this.checked = true;
                });
            } else {
                $('.earningPfApplicable').each(function() {
                    this.checked = false;
                });
            }
        });

        $('#deductionCheckbox').click(function(event) {
            if(this.checked) {
                // Iterate each checkbox
                $('.deductionHead').each(function() {
                    this.checked = true;
                });
            } else {
                $('.deductionHead').each(function() {
                    this.checked = false;
                });
            }
        });

        $('#deductionPfApplicableCheckbox').click(function(event) {
            if(this.checked) {
                // Iterate each checkbox
                $('.deductionPfApplicable').each(function() {
                    this.checked = true;
                });
            } else {
                $('.deductionPfApplicable').each(function() {
                    this.checked = false;
                });
            }
        });

        //Checkbox functionality starts here
        $('.singlecheckbox').change(function(){
            var correspondingInput = $(this).closest('.row').find('.numberInput');
            if ( $(this).is(':checked') ) {
                correspondingInput.attr('disabled', false);
                correspondingInput.prop('required',true);
            } else {
                correspondingInput.attr('disabled', true).val('');
            }
        });
        //Checkbox functionality ends here

        $('#project_id').change(function() {
            var projectId = $(this).val();
            $.ajax({
                type: 'POST',
                url: '{{ URL('payroll/salary-structures/project-cycles') }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    project_id: projectId
                },
                success: function (data) {
                    var salaryCycles = data.data;
                    if(salaryCycles.length > 0)
                    {
                        var formoption = "";
                        $.each(salaryCycles, function(v) {
                            var val = salaryCycles[v]
                            formoption += "<option value='" + val['id'] + "'>" + val['name'] + "</option>";
                        });
                        $('#salary_cycle').html(formoption);
                    }else{
                        var formoption = '<option selected disabled>--Not Any Salary Cycle--</option>';
                        $('#salary_cycle').html(formoption);
                    }
                },
                error: function (xhr) {
                    console.log(xhr.responseText);
                }
            });
        });
    </script>


@endsection



