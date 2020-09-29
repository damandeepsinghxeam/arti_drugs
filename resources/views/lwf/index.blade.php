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
            <h1>All LWF </h1>
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
{{--                        <div class="row">--}}
{{--                            <div class="col-md-4"></div>--}}
{{--                            <div class="col-md-4">--}}
{{--                                <div class="form-group">--}}
{{--                                    <label for="year">Year<span class="ast">*</span></label>--}}
{{--                                    <select name="year" class="filter form-control input-sm basic-detail-input-style" id="year">--}}
{{--                                        <option value="" selected>Select Year</option>--}}
{{--                                    </select>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="col-md-4"></div>--}}
{{--                        </div>--}}

                        <div class="box-body jrf-form-body">
                            <h2 class="heading2_form">All LWF List:</h2>

                            <div class="box-footer text-right">
                                <a href="{{ route('payroll.lwf.create') }}">
                                    <button class="btn btn-primary submit-btn-style" id="submit2" value="Add New">Add New</button>
                                </a>
                            </div>
                            <!--KRA Table Starts here-->
                            <table class="table table-striped table-responsive table-bordered"  id="tablexportData">
                                <thead class="table-heading-style">
                                <tr>
                                    <th>S No.</th>
                                    <th>State</th>
                                    <th>Tenure</th>
                                    <th>Min Salary</th>
                                    <th>Max Salary</th>
                                    <th>Employee Share</th>
                                    <th>Employer Share</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                                </thead>
                                <tbody class="kra_tbody">
                                @foreach($lwfs as $lwf)
                                    <tr>
                                        <td>{{ $lwf->id }}</td>
                                        <td>{{ $lwf->state->name }}</td>
                                        <td>{{ $lwf->tenure }}</td>
                                        <td>{{ $lwf->min_salary }}</td>
                                        <td>
                                            @if($lwf->max_salary == '')
                                                Infinity
                                                <i class="fas fa-infinity"></i>
                                            @else
                                                {{ $lwf->max_salary }}
                                            @endif</td>
                                        <td>{{ $lwf->employee_share }}</td>
                                        <td>{{ $lwf->employer_share }}</td>
                                        <td>
                                            <a href="{{ route('payroll.lwf.edit', $lwf->id) }}">
                                                <button class="btn bg-purple">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                            </a>
                                        </td>
                                        <td>
                                            <form method="post" action="{{ route('payroll.lwf.destroy', $lwf->id) }}" onclick="return confirm('Are you sure you want to delete this Lwf?');">
                                                @csrf
                                                <button class="btn btn-danger">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot class="table-heading-style">
                                <th>S No.</th>
                                <th>State</th>
                                <th>Tenure</th>
                                <th>Min Salary</th>
                                <th>Max Salary</th>
                                <th>Employee Share</th>
                                <th>Employer Share</th>
                                <th>Edit</th>
                                <th>Delete</th>
                                </tfoot>
                            </table>
                            <!--KRA Table Ends here-->
{{--                            <button onclick="Export()" class="btn btn-success">Export Salary Sheet Data To Excel File</button>                        </div>--}}
                        {{--                        <input type="button" id="btnExport" value="Export" onclick="Export()" />--}}
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

    <script src="https://rawgit.com/unconditional/jquery-table2excel/master/src/jquery.table2excel.js"></script>
    <script type="text/javascript">
        // function Export() {
        //     $("#tablexportData").table2excel({
        //         filename: "SalarySheet.xls"
        //     });
        // }
    </script>

    <script>
        setTimeout(function() {
            $('.error').fadeOut('fast');
        }, 1000);

        setTimeout(function() {
            $('.success').fadeOut('fast');
        }, 1000);

        $('.filter').change(function() {
            var year = $("#year :selected").val();
            console.log(year);

            $.ajax({
                type: 'POST',
                url: '{{ URL('payroll/lwfs/filter') }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    year: year,
                },
                success: function (data) {
                    console.log('success');
                    var lwf = data.data;
                    console.log(lwf);
                    $("#lwfData").val(lwf);
                    console.log(lwf);
                    $('tbody').html(data.table_data);
                },
                error: function (xhr) {
                    console.log('error');
                    console.log(xhr.responseText);
                }
            });
        });

        console.log(lwf);
    </script>

@endsection

