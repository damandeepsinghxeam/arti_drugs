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
        <secion class="content-header">
            <h1>Salary Structures</h1>
            <ol class="breadcrumb">
                <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
            </ol>
        </secion>

        <!-- Main content -->
        <section class="content">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="box box-primary">
                        <!-- form start -->
                        @include('admins.validation_errors')
                        <div class="box-body jrf-form-body">
                            <h2 class="heading2_form">Salary Structures List:</h2>

                            @can('create-salary-structure')
                                <div class="box-footer text-right">
                                    <a href="{{ route('payroll.salary.structure.create') }}">
                                        <button class="btn btn-primary submit-btn-style" id="submit2" value="Add New">Add New</button>
                                    </a>
                                </div>
                        @endcan
                        <!--KRA Table Starts here-->
                            <table class="table table-striped table-responsive table-bordered" id="salary_heads_table">
                                <thead class="table-heading-style">
                                <tr>
                                    <th>S No.</th>
                                    <th>Project</th>
                                    <th>Salary Cycle</th>
                                    <th>Earning Heads</th>
                                    <th>Deduction Heads</th>
                                    <th>PT Rate Applicable</th>
                                    @can('update-salary-structure')
                                        <th>Edit</th>
                                    @endcan
                                    {{--                                    <th>Delete</th>--}}
                                </tr>
                                </thead>
                                <tbody class="kra_tbody">
                                <?php $serialNumber = 1; ?>
                                @foreach($salaryStructures as $salaryStructure)
                                    <tr>
                                        <td>{{ $serialNumber }}</td>
                                        <td>
                                            <span>{{ ucfirst($salaryStructure->project->name ) }}</span>
                                        </td>
                                        <td>
                                            <span>{{ ucfirst($salaryStructure->salaryCycle->name) }}</span>

                                        <td>
                                            <span>
                                                <?php $earningHeads = \App\SalaryStructure::where('project_id', $salaryStructure->project_id)->where('salary_cycle_id', $salaryStructure->salary_cycle_id)->where('calculation_type', 'earning')->get()->pluck('salary_head_id') ?>
                                                @foreach($earningHeads as $earningHead)
                                                    {{ ucwords(\App\SalaryHead::where('id', $earningHead)->first()->name) }},
                                                @endforeach
                                            </span>
                                        </td>
                                        <td>
                                            <span>
                                                <?php $deductionHeads = \App\SalaryStructure::where('project_id', $salaryStructure->project_id)->where('salary_cycle_id', $salaryStructure->salary_cycle_id)->where('calculation_type', 'deduction')->get()->pluck('salary_head_id') ?>
                                                @foreach($deductionHeads as $deductionHead)
                                                    {{ ucwords(\App\SalaryHead::where('id',$deductionHead)->first()->name) }},
                                                @endforeach
                                            </span>
                                        </td>
                                        <td>
                                            @if($salaryStructure->pt_rate_applicable == 1)
                                                <span>Applicable</span>
                                            @elseif($salaryStructure->pt_rate_applicable == 0)
                                                <span>Not Applicable</span>
                                            @endif
                                        </td>
                                        @can('update-salary-structure')
                                            <td>
                                                <a href="{{ route('payroll.salary.structure.edit', $salaryStructure->id) }}">
                                                    <button class="btn btn-primary">
                                                        <i class="fa fa-edit"></i>
                                                    </button>
                                                </a>
                                            </td>
                                        @endcan
                                        {{--                                        <td>--}}
                                        {{--                                            <form method="post" action="{{ route('payroll.salary.head.destroy', $salaryStructure->id) }}" onclick="return confirm('Are you sure you want to delete this keyword?');">--}}
                                        {{--                                                @csrf--}}
                                        {{--                                                @method('DELETE')--}}
                                        {{--                                                <button class="btn btn-danger">--}}
                                        {{--                                                    <i class="fa fa-trash"></i>--}}
                                        {{--                                                </button>--}}
                                        {{--                                            </form>--}}
                                        {{--                                        </td>--}}
                                    </tr>
                                    <?php $serialNumber++ ?>
                                @endforeach
                                </tbody>
                                <tfoot class="table-heading-style">
                                <th>S No.</th>
                                <th>Project</th>
                                <th>Salary Cycle</th>
                                <th>Earning Heads</th>
                                <th>Deduction Heads</th>
                                <th>PT Rate Applicable</th>
                                @can('update-salary-structure')
                                    <th>Edit</th>
                                @endcan
                                {{--                                <th>Delete</th>--}}
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
            7            messages: {
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

