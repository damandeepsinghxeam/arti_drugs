@extends('admins.layouts.app')

@section('content')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.20/css/jquery.dataTables.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css" integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />

    <style>
        .heading2_form { font-size: 20px; text-decoration: underline; }
        .basic-detail-label { padding-right: 0px; padding-top: 4px; }
        table tr th, table tr td {vertical-align: middle !important; }
        .status_checkbox{ display: none}
        .status{
            border-radius: 20px;
            padding: 5px;
        }
        .loader {
            border: 16px solid #f3f3f3;
            border-radius: 50%;
            border-top: 16px solid #3498db;
            width: 50px;
            height: 50px;
            animation: spin 2s linear infinite;
            margin:auto;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Salary Sheets</h1>
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
                        <br/>
                        <div class="box-body jrf-form-body">
                            <form action="{{ route('payroll.salary.sheet.export') }}" method="post">
                                @csrf
                                <div class="row" id="all_filter_input">
                                    <div class="col-md-6">
                                        <div class="row field-changes-below">
                                            <div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
                                                <label for="year" class="basic-detail-label">Year<span style="color: red">*</span></label>
                                            </div>
                                            <div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
                                                <select name="year" class="filter form-control input-sm basic-detail-input-style" id="year" required>
                                                    <option value="" selected disabled>Select Year {{ date('Y') }}
                                                    </option>
                                                    @foreach($years as $yearList)
                                                        <option value="{{ $yearList }}" @if($year == $yearList) selected @elseif(date('Y') == $yearList) selected @endif>{{ $yearList }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row field-changes-below">
                                            <div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
                                                <label for="month" class="basic-detail-label">Month {{ $month }}<span style="color: red">*</span></label>
                                            </div>
                                            <div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
                                                <select name="month" class="filter form-control input-sm basic-detail-input-style" id="month" required>
                                                    <option value="" selected disabled>Please select Month</option>
                                                    <option value="01" @if($month == '01') selected @elseif($month == '' AND date('m') == '01') selected @endif>January {{ $month }}</option>
                                                    <option value="02" @if($month == '02') selected @elseif($month == '' AND date('m') == '02') selected @endif>February {{ $month }}</option>
                                                    <option value="03" @if($month == '03') selected @elseif($month == '' AND date('m') == '03') selected @endif>March {{ $month }}</option>
                                                    <option value="04" @if($month == '04') selected @elseif($month == '' AND date('m') == '04') selected @endif>April {{ $month }}</option>
                                                    <option value="05" @if($month == '05') selected @elseif($month == '' AND date('m') == '05') selected @endif>May {{ $month }}</option>
                                                    <option value="06" @if($month == '06') selected @elseif($month == '' AND date('m') == '06') selected @endif>June {{ $month }}</option>
                                                    <option value="07" @if($month == '07') selected @elseif($month == '' AND date('m') == '07') selected @endif>July {{ $month }}</option>
                                                    <option value="08" @if($month == '08') selected @elseif($month == '' AND date('m') == '08') selected @endif>August {{ $month }}</option>
                                                    <option value="09" @if($month == '09') selected @elseif($month == '' AND date('m') == '09') selected @endif>September {{ $month }}</option>
                                                    <option value="10" @if($month == '10') selected @elseif($month == '' AND date('m') == '10') selected @endif>October {{ $month }}</option>
                                                    <option value="11" @if($month == '11') selected @elseif($month == '' AND date('m') == '11') selected @endif>November {{ $month }}</option>
                                                    <option value="12" @if($month == '12') selected @elseif($month == '' AND date('m') == '12') selected @endif>December {{ $month }}</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row field-changes-below">
                                            <div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
                                                <label for="project" class="basic-detail-label">Project<span style="color: red">*</span></label>
                                            </div>
                                            <div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
                                                <select name="project" id="project" class="filter form-control input-sm basic-detail-input-style" id="month" required>
                                                    <option value="" selected>Select Project</option>
                                                    @foreach($projects as $projectList)
                                                        <option value="{{ $projectList->name }}" @if($project == $projectList->name) selected @endif>{{ $projectList->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="row field-changes-below">
                                            <div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
                                                <label for="department" class="basic-detail-label">Department</label>
                                            </div>
                                            <div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
                                                <select name="department" id="department" class="filter form-control input-sm basic-detail-input-style" id="department">
                                                    <option value="all" selected>All</option>
                                                    @foreach($departments as $departmentList)
                                                        <option value="{{ $departmentList->name }}" @if($department == $departmentList->name) selected @endif>{{ $departmentList->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row field-changes-below">
                                            <div class="col-md-4 col-sm-4 col-xs-4 leave-label-box label-470">
                                                <label for="paid_or_not_paid" class="basic-detail-label">Salary Status</label>
                                            </div>
                                            <div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
                                                <select name="salary_sheet_status" id="salary_sheet_status" class="filter form-control input-sm basic-detail-input-style" id="month">
                                                    <option value="all" selected>All</option>
                                                    <option value="new">New</option>
                                                    <option value="process_salary">Process Salary</option>
                                                    <option value="on_hold">On Hold</option>
                                                    <option value="approved">Approved</option>
                                                    <option value="paid">Paid</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="box-footer create-footer text-center">
                                    <span class="btn btn-primary" id="filter">Filter</span>
                                    <button type="submit" class="btn btn-success">Export Salary sheet data to excel file</button>
                                </div>
                            </form>

                            <br>
                            <h2 class="heading2_form text-center">Salary Sheet List:</h2>
                            <!--Salary Sheet Table Starts here-->
                            <div class="table-box">
                                <label type="#" class="p-2 btn-warning status">Process Salary</label>
                                <label type="#" class="p-2 btn-danger status">Hold Salary</label>
                                <label type="#" class="p-2 btn-success status">Approve Salary</label>
                                <label type="#" class="p-2 btn-primary status">Pay Salary</label>


                                <table class="table table-striped table-responsive table-bordered text-center" id="salary_sheet_table">

                                    <thead class="table-heading-style">
                                    <tr>
{{--                                        <th><input type="checkbox" name="select-all" class="select-all" /></th>--}}
                                        <th>S No.</th>
                                        <th>Employee</th>
                                        <th>Project</th>
                                        <th>Department</th>
                                        <th>Month Days</th>
                                        <th>Paid Days</th>
                                        <th>Monthly Salary (₹)</th>
                                        <th>Total Earning (₹)</th>
                                        <th>Total Deduction (₹)</th>
                                        <th>Net Amount (₹)</th>
                                        <th>Salary Breakdown</th>
                                    </tr>
                                    </thead>
                                    <tbody class="kra_tbody">
                                    <tr id="spinner">
                                        <td colspan="12">
                                            <div class="loader"></div>
                                        </td>
                                    </tr>
                                    </tbody>
                                    <tfoot class="table-heading-style">
{{--                                    <th><input type="checkbox" name="select-all" class="select-all" /></th>--}}
                                    <th>S No.</th>
                                    <th>Employee</th>
                                    <th>Project</th>
                                    <th>Department</th>
                                    <th>Month Days</th>
                                    <th>Paid Days</th>
                                    <th>Monthly Salary</th>
                                    <th>Total Earning</th>
                                    <th>Total Deduction</th>
                                    <th>Net Amount</th>
                                    <th>Salary Breakdown</th>
                                    </tfoot>
                                </table>
                            </div>
                            <!--Salary Sheet Table Ends here-->
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
@endSection
@section('script')
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.10.0/jquery.validate.min.js"></script>
    <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.10.0/additional-methods.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.20/js/jquery.dataTables.min.js"></script>

    <script type="text/javascript">
        // $('#salary_sheet_table').DataTable({
        //     responsive: true
        // });
        $(document).ready(function () {
            $('#project').selectize({
                sortField: 'text'
            });
            $('#department').selectize({
                sortField: 'text'
            });
            $('#spinner').hide();
        });


    </script>

    <script>
        $(document).ready(function() {
            var year = $("#year :selected").val();
            var month = $("#month :selected").val();
            var project = $("#project :selected").val();
            var department = $("#department :selected").val();
            var salary_sheet_status = $("#salary_sheet_status :selected").val();
            filterAjaxRequest(year, month, project, department, salary_sheet_status);
        });

        $("#filter").click(function(){
            $('#spinner').show();
            var year = $("#year :selected").val();

            var month = $("#month :selected").val();

            var project = $("#project :selected").val();

            var department = $("#department :selected").val();

            var salary_sheet_status = $("#salary_sheet_status :selected").val();


            filterAjaxRequest(year, month, project, department, salary_sheet_status);
        });

        function  filterAjaxRequest(year, month, project, department, salary_sheet_status) {
            $.ajax({
                type: 'POST',
                url: '{{ URL('payroll/salary-sheets/filter') }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    year: year,
                    month: month,
                    project: project,
                    department: department,
                    salary_sheet_status: salary_sheet_status,
                    report: "report"
                },
                success: function (data) {
                    if(data.data != '') {
                        $('#spinner').hide();
                        var extraIncome = data.extra_income;
                        $('#extraIncome').html(extraIncome);

                        var salary_sheet_status = data.salary_sheet_status;
                        $('#change_salary_sheet_status').html(salary_sheet_status);
                    }
                    console.log(data.employees);
                    var employees = data.employees;
                    if(employees.length > 0)
                    {
                        var formoption = "";
                        $.each(employees, function(v) {
                            var val = employees[v]
                            formoption += "<option value='" + val['user_id'] + "'>" + val['fullname'] + "</option>";
                        });
                        $('.employee').html(formoption);
                        $('.employee').selectize({
                            sortField: 'text'
                        });
                    }else{
                        var formoption = '<option selected disabled>--No Employee--</option>';
                        $('.employee').html(formoption);
                        $('.employee').selectize({
                            sortField: 'text'
                        });
                    }

                    var salarySheet = data.data;
                    $("#salarySheetData").val(salarySheet);
                    $('tbody').html(data.table_data);
                    document.getElementById("salary_sheet_year").innerHTML = year
                    document.getElementById("salary_sheet_month").innerHTML = moment(month, 'MM').format('MMMM')+','
                },
                error: function (xhr) {
                    console.log('error');
                    console.log(xhr.responseText);
                }
            });
        }
    </script>

@endsection











