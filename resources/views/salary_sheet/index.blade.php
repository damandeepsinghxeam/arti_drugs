@extends('admins.layouts.app')

@section('content')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.20/css/jquery.dataTables.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css" integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />

    <style>
        .heading2_form { font-size: 20px; text-decoration: underline; }
        .basic-detail-label { padding-right: 0px; padding-top: 4px; }
        table tr th, table tr td {vertical-align: middle !important; }

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
                        @if(session()->has('success'))
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                {{ session()->get('success') }}
                            </div>
                        @endif
                        @if(session()->has('employee_not_having_salary_structure'))
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <h5>Employees Not Having Salary Structure</h5>
                            @foreach (session()->get('employee_not_having_salary_structure') as $error)
                                    {{ $error}},
                                @endforeach
                            </div>
                        @endif
                        @if(session()->has('employee_not_having_attendance'))
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <h5>Employees Not Having Attendance</h5>
                                @foreach (session()->get('employee_not_having_attendance') as $error)
                                    {{ $error }},
                                @endforeach
                            </div>
                        @endif
                        {{--                        @include('admins.validation_errors')--}}
                        <br/>
                        <div class="box-body jrf-form-body">
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
                                            <label for="month" class="basic-detail-label">Month <span style="color: red">*</span></label>
                                        </div>
                                        <div class="col-md-8 col-sm-8 col-xs-8 leave-input-box input-470">
                                            <select name="month" class="filter form-control input-sm basic-detail-input-style" id="month" required>
                                                <option value="" selected disabled>Please select Month</option>
                                                <option value="01" @if($month == '01') selected @elseif($month == '' AND date('m') == '01') selected @endif>January </option>
                                                <option value="02" @if($month == '02') selected @elseif($month == '' AND date('m') == '02') selected @endif>February </option>
                                                <option value="03" @if($month == '03') selected @elseif($month == '' AND date('m') == '03') selected @endif>March </option>
                                                <option value="04" @if($month == '04') selected @elseif($month == '' AND date('m') == '04') selected @endif>April </option>
                                                <option value="05" @if($month == '05') selected @elseif($month == '' AND date('m') == '05') selected @endif>May </option>
                                                <option value="06" @if($month == '06') selected @elseif($month == '' AND date('m') == '06') selected @endif>June </option>
                                                <option value="07" @if($month == '07') selected @elseif($month == '' AND date('m') == '07') selected @endif>July </option>
                                                <option value="08" @if($month == '08') selected @elseif($month == '' AND date('m') == '08') selected @endif>August </option>
                                                <option value="09" @if($month == '09') selected @elseif($month == '' AND date('m') == '09') selected @endif>September </option>
                                                <option value="10" @if($month == '10') selected @elseif($month == '' AND date('m') == '10') selected @endif>October </option>
                                                <option value="11" @if($month == '11') selected @elseif($month == '' AND date('m') == '11') selected @endif>November </option>
                                                <option value="12" @if($month == '12') selected @elseif($month == '' AND date('m') == '12') selected @endif>December </option>
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
                                        </div>                                    </div>
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
                                                @if (Auth::user()->can('for-approve-salary-sheet') AND Auth::user()->can('hold-salary-sheet'))
                                                    <option value="new">New</option>
                                                    <option value="process_salary">Process Salary</option>
                                                @endif
                                                @if (Auth::user()->can('hold-salary-sheet') AND Auth::user()->can('approve-salary-sheet') || Auth::user()->can('for-approve-salary-sheet'))
                                                    <option value="on_hold">On Hold</option>
                                                @endif
                                                @can('approve-salary-sheet')
                                                    <option value="approved">Approved</option>
                                                @endif
                                                @can('pay-salary-sheet')
                                                    <option value="paid">Paid</option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="box-footer create-footer text-center">
                                <span class="btn btn-primary" id="filter">Filter</span>
                            </div>

                            <br>
                            <h2 class="heading2_form text-center">Salary Sheet List:</h2>
                            <form method="post" action="{{ route('payroll.salary.sheet.pay') }}">
                                @csrf
                                <input type="hidden" id="status_year"   name="status_year" value="">
                                <input type="hidden" id="status_month"  name="status_month" value="">
                                <input type="hidden" id="status_project"  name="status_project" value="">
                                <input type="hidden" id="status_department"  name="status_department" value="">
                                <div class="container-1 space-15">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="item1">
                                                @can('create-salary-sheet')
                                                    <a href="{{ route('payroll.salary.sheet.create') }}">
                                                        <button type="button" class="btn btn-xs btn-primary"><i class="fa fa-plus"></i> Add New</button>
                                                    </a>
                                                @endcan
                                                <span id="change_salary_sheet_status">
                                                 </span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="item2" style="float: right;">
                                                <div id="extraIncome">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!--Salary Sheet Table Starts here-->
                                <div class="table-box">
                                    <table class="table table-striped table-responsive table-bordered text-center" id="salaryTable">

                                        <thead class="table-heading-style">
                                        <tr>
                                            <th><input type="checkbox" name="select-all" class="selectAllCheckBoxes" /></th>
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
                                        <th><input type="checkbox" name="select-all" class="selectAllCheckBoxes" /></th>
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
                                <input type="hidden" id="all_salary_sheet_id" name="all_salary_sheet_id">
                                <div id="approval_button">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /.box -->
            </div>
            <!-- /.row -->


            <!--Modal Add Arrear Starts here-->
            <div class="modal fade" id="add_arrear_modal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form id="arrear_form" method="post" action="{{ route('payroll.salary.sheet.extra.income') }}">
                            @csrf
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Add Arrear</h4>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="extra_income_type" value="arrear">
                                <input type="hidden" id="arrear_year"   name="extra_income_year" value="">
                                <input type="hidden" id="arrear_month"  name="extra_income_month" value="">
                                <input type="hidden" id="arrear_project"  name="extra_income_project" value="">
                                <input type="hidden" id="arrear_department"  name="extra_income_department" value="">

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="add_arrear_employee">Employee <span style="color: red">*</span></label>
                                            <select name="employee" id="employee" class="employee filter form-control input-sm basic-detail-input-style" required>
                                                <option value="" selected disabled>Select Employee</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="add_arrear_amount">Amount <span style="color: red">*</span></label>
                                            <input type="number" name="add_arrear_amount" id="add_arrear_amount"  placeholder="Enter Amount" name="Enter Amount" class="form-control input-sm basic-detail-input-style" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="add_arrear_reason">Reason <span style="color: red">*</span></label>
                                            <input type="text" name="add_arrear_reason" id="add_arrear_reason"  placeholder="Enter Reason" name="Enter Reason" class="form-control input-sm basic-detail-input-style" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="add_arrear_remarks">Remarks</label><br>
                                            <textarea name="add_arrear_remarks" id="add_arrear_remarks" rows="3" style="width: 100%;"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer text-center">
                                <button type="submit" id="add_arrear" class="btn btn-primary" >Submit</button>
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
            <!--Modal Add Arrear Ends here-->

            <!--Modal Add Deduct Starts here-->
            <div class="modal fade" id="add_deduct_modal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ route('payroll.salary.sheet.extra.income') }}" method="post">
                            @csrf
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Add Deduction</h4>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="extra_income_type" value="deduction">
                                <input type="hidden" id="deduct_year"   name="extra_income_year" value="">
                                <input type="hidden" id="deduct_month"  name="extra_income_month" value="">
                                <input type="hidden" id="deduct_project"  name="extra_income_project" value="">
                                <input type="hidden" id="deduct_department"  name="extra_income_department" value="">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="add_deduct_employee">Employee  <span style="color: red">*</span></label>
                                            <select name="employee" id="employee" class="employee filter form-control input-sm basic-detail-input-style" required>
                                                <option value="" selected>Select Employee</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="add_deduct_amount">Amount <span style="color: red">*</span></label>
                                            <input type="number" name="add_deduct_amount" id="" placeholder="Enter Amount" class="form-control input-sm basic-detail-input-style" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="add_deduct_reason">Reason <span style="color: red">*</span></label>
                                            <input type="text" name="add_deduct_reason" id="" placeholder="Enter Reason" class="form-control input-sm basic-detail-input-style" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="add_deduct_remarks">Remarks</label><br>
                                            <textarea name="add_deduct_remarks" id="add_deduct_remarks" rows="3" style="width: 100%;"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer text-center">
                                <input type="submit" class="btn btn-primary" value="Submit">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
            <!--Modal Add Deduct Ends here-->
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
        // $('#salaryTable').DataTable({
        //     responsive: false
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

        $('.selectAllCheckBoxes').on('change', function(){
            //event.preventDefault(); event.stopPropagation();

            if($(this).is(':checked')) {
                $('.kra_tbody input:checkbox').prop('checked', true);
            }else {
                $('.kra_tbody input:checkbox').prop('checked', false);
            }
        });
    </script>

    <script>
        $(document).ready(function() {
            var year = $("#year :selected").val();
            var month = $("#month :selected").val();
            var project = $("#project :selected").val();
            var department = $("#department :selected").val();
            var salary_sheet_status = $("#salary_sheet_status :selected").val();


            document.getElementById("status_year").value = year;
            document.getElementById("status_month").value = month;
            document.getElementById("status_project").value = project;
            document.getElementById("status_department").value = departm00e0n0t0;0
            document.getElementById("arrear_year").value = year;
            document.getElementById("arrear_month").value = month;
            document.getElementById("arrear_project").value = project;
            document.getElementById("arrear_department").value = department;
            document.getElementById("deduct_year").value = year;
            document.getElementById("deduct_month").value = month;
            document.getElementById("deduct_project").value = project;
            document.getElementById("deduct_department").value = department;

            filterAjaxRequest(year, month, project, department, salary_sheet_status);
        });

        $("#filter").click(function(){
            $('#spinner').show();

            var year = $("#year :selected").val();
            var month = $("#month :selected").val();
            var project = $("#project :selected").val();
            var department = $("#department :selected").val();
            var salary_sheet_status = $("#salary_sheet_status :selected").val();


            document.getElementById("status_year").value = year;
            document.getElementById("status_month").value = month;
            document.getElementById("status_project").value = project;
            document.getElementById("status_department").value = department;
            document.getElementById("arrear_year").value = year;
            document.getElementById("arrear_month").value = month;
            document.getElementById("arrear_project").value = project;
            document.getElementById("arrear_department").value = department;
            document.getElementById("deduct_year").value = year;
            document.getElementById("deduct_month").value = month;
            document.getElementById("deduct_project").value = project;
            document.getElementById("deduct_department").value = department;

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
                    report: ''
                },
                success: function (data) {
                    if(data.data != '') {
                        $('#spinner').hide();

                        var extraIncome = data.extra_income;
                        $('#extraIncome').html(extraIncome);

                        var salary_sheet_status = data.salary_sheet_status;
                        $('#change_salary_sheet_status').html(salary_sheet_status);

                        var all_salary_sheet_id = data.all_salary_sheet_id;
                        document.getElementById("all_salary_sheet_id").value = all_salary_sheet_id;

                        var send_for_approval = data.send_for_approval;
                        $('#approval_button').html(send_for_approval);

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
                    }else{
                        $('#spinner').hide();
                        $('#extraIncome').html('');
                        $('#change_salary_sheet_status').html('');
                        var table_data = '<tr>\n' +
                            '            <td colspan="12">\n' +
                            '                 <b>No Data Found</b>' +
                            '            </td>\n' +
                            '        </tr>'
                        $('tbody').html(table_data);
                    }

                },
                error: function (xhr) {
                    console.log('error');
                    console.log(xhr.responseText);
                },
            });
        }
    </script>

@endsection










