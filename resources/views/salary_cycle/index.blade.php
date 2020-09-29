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
    </style>
    <link rel="stylesheet" href="{{asset('public/admin_assets/plugins/dataTables/jquery.dataTables.min.css')}}">
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Salary Cycle</h1>
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

                        <div class="box-body jrf-form-body">
                            @can('create-salary-cycle')
                                <form id="salary_cycle" method="POST" action="{{ route('payroll.salary.cycle.store') }}" autocomplete="off">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row field-changes-below">
                                                <div class="col-md-4 text-right">
                                                    <label for="name" class="basic-detail-label">Project<span style="color: red">*</span></label>
                                                </div>
                                                <div class="col-md-4">
                                                    <select name="project_id" id="" class="form-control" required>
                                                        <option value="">Select Project</option>
                                                        @foreach($projects as $p)
                                                            <option value="{{$p->id}}">{{$p->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row field-changes-below">
                                                <div class="col-md-4 text-right">
                                                    <label for="salary_cycle_name" class="basic-detail-label">Name<span style="color: red">*</span></label>
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="text" name="salary_cycle_name" id="salary_cycle_name" class="form-control input-sm basic-detail-input-style"placeholder="Enter Salary Cycle Name" required>
                                                </div>
                                            </div>
                                            <div class="row field-changes-below">
                                                <div class="col-md-4 text-right">
                                                    <label for="from" class="basic-detail-label">Day From<span style="color: red">*</span></label>
                                                </div>
                                                <div class="col-md-4">
                                                    <select type="date" name="salary_from" required  id="from" class="form-control input-sm basic-detail-input-style">
                                                        <option selected disabled>Select Start Date</option>
                                                        @foreach($dates as $date)
                                                            <option>{{ $date }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row field-changes-below">
                                                <div class="col-md-4 text-right">
                                                    <label for="salary_to" class="basic-detail-label">Day To<span style="color: red">*</span></label>
                                                </div>
                                                <div class="col-md-4">
                                                    <select type="date" name="salary_to" id="to" required class="form-control input-sm basic-detail-input-style">
                                                        <option selected disabled>Select Start Date</option>
                                                        @foreach($dates as $date)
                                                            <option>{{ $date }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6"></div>
                                    </div>
                                    <div class="box-footer create-footer text-center">
                                        <input type="submit" class="btn btn-primary" id="submit3" value="Add" name="submit">
                                    </div>
                                </form>
                            @endcan
                            <h2 class="heading2_form">Salary Cycle List</h2>
                            <!--KRA Table Starts here-->
                            <table class="table table-striped table-responsive table-bordered" id="salary_heads_table">
                                <thead class="table-heading-style">
                                <tr>
                                    <th>S No.</th>
                                    <th>Name</th>
                                    <th>Project</th>
                                    @can('update-salary-cycle')
                                        <th>Edit</th>
                                    @endcan
                                    {{--                                    <th>Structure</th>--}}
                                    @can('delete-salary-cycle')
                                        <th>Delete</th>
                                    @endcan
                                </tr>
                                </thead>
                                <tbody class="kra_tbody">
                                @foreach($salaryCycles as $salaryCycle)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>
                                            <span>{{$salaryCycle->name}}</span>
                                        </td>
                                        <td>
                                            <span>
                                                @if($salaryCycle->project_id)
                                                    {{ $salaryCycle->project->name }}
                                                @else NA @endif
                                            </span>
                                        </td>
                                        <td>
                                            @can('update', $salaryCycle)
                                                <button class="btn bg-purple" data-toggle="modal" data-target="#editSalaryCycleModal{{ $salaryCycle->id }}">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                            @endcan
                                        </td>
                                        {{--                                        <td class="text-center">--}}
                                        {{--                                            <a class="btn btn-danger" href="salary-structure/{{$salaryCycle->id}}">--}}
                                        {{--                                                <i class="fa fa-calculator"></i>--}}
                                        {{--                                            </a>--}}
                                        {{--                                        </td>--}}
                                        <td>
                                            @can('delete', $salaryCycle)
                                                <form method="post" action="{{ route('payroll.salary.cycle.destroy', $salaryCycle->id) }}" onclick="return confirm('Are you sure you want to delete this keyword?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endcan
                                        </td>
                                    </tr>


                                    <!-- The Modal -->
                                    <div class="modal" id="editSalaryCycleModal{{ $salaryCycle->id }}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">

                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Edit Salary Cycle</h4>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>

                                                <!-- Modal body -->
                                                <div class="modal-body">
                                                    <form id="salary_cycle_name" method="POST" action="{{ route('payroll.salary.cycle.update', $salaryCycle->id) }}" autocomplete="off">
                                                    @csrf
                                                    @method('PATCH')
                                                    <!-- Box Body Starts here -->
                                                        <div class="box-body jrf-form-body">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="row field-changes-below">
                                                                        <div class="col-md-4 text-right">
                                                                            <label for="name" class="basic-detail-label">Project<span style="color: red">*</span></label>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <select name="project_id" id="" class="form-control ">
                                                                                <option value="">Select Project</option>
                                                                                @foreach($projects as $project)
                                                                                    <option value="{{$project->id}}" {{ $project->id == $salaryCycle->project_id  ? 'selected' : '' }}>{{$project->name}}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row field-changes-below">
                                                                        <div class="col-md-4 text-right">
                                                                            <label for="salary_cycle_name" class="basic-detail-label">Name<span style="color: red">*</span></label>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <input type="text" name="salary_cycle_name" id="salary_cycle_name" class="form-control input-sm basic-detail-input-style"placeholder="Enter Salary Cycle Name" required="" value="{{$salaryCycle->name}}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="row field-changes-below">
                                                                        <div class="col-md-4 text-right">
                                                                            <label for="from" class="basic-detail-label">Day From<span style="color: red">*</span></label>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <input type="date" name="salary_from" required=""  id="from" class="form-control input-sm basic-detail-input-style" value="{{$salaryCycle->salary_from}}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="row field-changes-below">
                                                                        <div class="col-md-4 text-right">
                                                                            <label for="salary_to" class="basic-detail-label">Day To<span style="color: red">*</span></label>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <input type="date" name="salary_to" id="to" required="" class="form-control input-sm basic-detail-input-style" value="{{$salaryCycle->salary_to}}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6"></div>
                                                            </div>
                                                        </div>
                                                        <!-- Box Body Ends here -->
                                                        <!-- Box Footer Starts here -->
                                                        <div class="box-footer text-center">
                                                            <input type="submit" class="btn btn-primary submit-btn-style" id="submit2" value="Update" name="submit">
                                                        </div>
                                                        <!-- Box Footer Ends here -->
                                                    </form>
                                                    <!-- Form Ends here -->
                                                </div>

                                                <!-- Modal footer -->
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                @endforeach
                                </tbody>
                                <tfoot class="table-heading-style">
                                <th>S No.</th>
                                <th>Name</th>
                                <th>Project</th>
                                @can('update-salary-cycle')
                                    <th>Edit</th>
                                @endcan
                                {{--                                <th>Structure</th>--}}
                                @can('delete-salary-cycle')
                                    <th>Delete</th>
                                @endcan
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

    <script src="{{asset('public/admin_assets/plugins/dataTables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('public/admin_assets/validations/additional-methods.js')}}"></script>
    <script type="text/javascript">
        $('#salary_heads_table').DataTable({
            "scrollX": true,
            responsive: true
        });
    </script>
@endsection



