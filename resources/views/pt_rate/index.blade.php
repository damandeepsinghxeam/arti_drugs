@extends('admins.layouts.app')

@section('style')
    <link rel="stylesheet" href="{{asset('public/admin_assets/plugins/dataTables/jquery.dataTables.min.css')}}">
    <style>
        #delete{
            display: inline-block;
        }
    </style>
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>PT RATES LISTING</h1>
            <ol class="breadcrumb">
                <li><a href="{{ url('employees/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="box">
                    <div class="box-header">
                        @can('create-pt-rate')
                            <div class="box-footer text-right">
                                <a href="{{ route('payroll.pt.rate.create') }}">
                                    <button class="btn btn-primary submit-btn-style" id="submit2" value="Add New">Add New</button>
                                </a>
                            </div>
                        @endcan
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="listHolidays" class="table table-bordered table-striped">
                            <thead class="table-heading-style">
                            <tr>
                                <th>S.No.</th>
                                <th>PT Group(State)</th>
                                <th>Effective Month</th>
                                <th>S.I No.</th>
                                <th>Certificate No.</th>
                                @can('update-pt-rate')
                                    <th>Actions</th>
                                @endcan
                            </tr>
                            </thead>
                            <tbody>
                            @php $counter = 1; @endphp
                            @foreach($ptRates as $key =>$ptRate)
                                <tr>
                                    <td>{{ $counter++ }}</td>
                                    <td>{{ $ptRate->state->name }}</td>
                                    <td>{{ $ptRate->effective_month }}</td>
                                    <td>{{ $ptRate->si_number }}</td>
                                    <td>{{ $ptRate->certificate_number }}</td>
                                    @can('update-pt-rate')
                                        <td>

                                            <a href="{{ route('payroll.pt.rate.edit', $ptRate->id) }}">
                                                <button class="btn bg-purple">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                            </a>

                                            @can('delete-pt-rate')
                                                <form id="delete" action="{{ route('payroll.pt.rate.destroy', $ptRate->id) }}" method="post" onclick="return confirm('Are you sure you want to delete this Pt Rate?');">
                                                    @csrf
                                                    @method('Delete')
                                                    <button class="btn btn-danger">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endcan
                                        </td>
                                    @endcan
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot class="table-heading-style">
                            <tr>
                                <th>S.No.</th>
                                <th>PT Group(State)</th>
                                <th>Effective Month</th>
                                <th>S.I No.</th>
                                <th>Certificate No.</th>
                                @can('update-pt-rate')
                                    <th>Actions</th>
                                @endcan
                            </tr>
                            </tfoot>
                        </table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.row -->
            <!-- Main row -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <script src="{{asset('public/admin_assets/plugins/dataTables/jquery.dataTables.min.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#listHolidays').DataTable({
                scrollX: true,
                responsive: true
            });
        });
    </script>
@endsection
