@extends('admins.layouts.app')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1><i class="fa fa-list"></i> PT RATES</h1>
            <ol class="breadcrumb">
                <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">#</a></li>
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
                        <form id="ptRate" action="{{ route('payroll.pt.rate.store') }}" method="POST">
                            @csrf
                            <div class="box-body jrf-form-body">

                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label for="state_id" class="basic-detail-label">PT Group(State)<span style="color: red">*</span></label>
                                        <select class="form-control basic-detail-input-style regis-input-field" name="state_id" id="state_id">
                                            <option value="">Select State</option>
{{--                                            @if(!$data['states']->isEmpty())--}}
                                                @foreach($states as $state)
                                                    <option value="{{$state->id}}">{{$state->name}}</option>
                                                @endforeach
{{--                                            @endif--}}
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="name" class="basic-detail-label">Effective Month<span style="color: red">*</span></label>
                                        <input type="date" name="effective_month" id="" class="form-control">
                                    </div>

                                    <div class="col-md-4">
                                        <label for="name" class="basic-detail-label">S.I No.<span style="color: red">*</span></label>
                                        <input type="text" name="si_number" id="" class="form-control">
                                    </div>

                                </div>
                                <div class="form-group row">

                                    <div class="col-md-4">
                                        <label for="name" class="basic-detail-label">Certificate No</label>
                                        <input type="text" name="certificate_number" id="" class="form-control">
                                    </div>

                                    <div class="col-md-4">
                                        <label for="name" class="basic-detail-label">PTO Circle number</label>
                                        <input type="text" name="circle_no" id="" class="form-control">
                                    </div>

                                </div>

                                <br>
                                <br>

                                <fieldset >
                                    <legend> Salary Range</legend>
                                    <table class="table table-striped table-responsive table-bordered">
                                        <thead>
                                        <tr>
                                            <th>S No.</th>
                                            <th>Minimum</th>
                                            <th>Maximum</th>
                                            <th>PT Rate</th>
                                            <th>ADD</th>
                                        </tr>
                                        </thead>
                                        <tbody class="kra_tbody">
                                        <tr class="first_kra_row">
                                            <td>1</td>
                                            <td>
                                                <input type="text" name="min_salary[]" class="form-control input-sm basic-detail-input-style regis-input-field" placeholder="Enter Minimum Salary" required style="border:1px solid burlywood;border-radius:1px">
                                            </td>

                                            <td>
                                                <input type="text" name="max_salary[]" class="form-control input-sm basic-detail-input-style regis-input-field" placeholder="Enter Maximum Salary" required style="border:1px solid burlywood;border-radius:1px">

                                            </td>

                                            <td>
                                                <input type="text" name="pt_rate[]" class="form-control input-sm basic-detail-input-style regis-input-field" placeholder="Enter PT Rate" required style="border:1px solid burlywood;border-radius:1px">

                                            </td>

                                            <td class="text-center">
                                                <a href="javascript:void(0)" id="add_new_kra">
                                                    <i class="col-sm-1 fa fa-plus addOtherField"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </fieldset>
                                <!--KRA Table Ends here-->
                                <hr>
                                <div class="text-center">
                                    <input type="submit" class="btn btn-primary submit-btn-style" id="submit3" value="Submit" name="submit">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /.box -->
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

        $("#ptRate").validate({
            rules: {
                "state_id" : {
                    required: true
                },
                "si_no" : {
                    required: true
                },
                "effective_mnth" : {
                    required: true
                },
                "max_salary" : {
                    required: true
                },
                "min_salary[]" : {
                    required: true
                },
                "pt_rate[]" : {
                    required: true
                },

                "circle_no" : {
                    required: true
                }

            },
            messages: {

                "pt_group[]" : {
                    required: 'Enter PT Group'
                },
                "max_salary[]" : {
                    required: 'Enter Maximum Salary'
                },
                "min_salary[]" : {
                    required: 'Enter Minimum Salary'
                },
                "pt_rate[]" : {
                    required: 'Select PT Rate'
                },

            }
        });

        var i=1;
        $('#add_new_kra').on('click',function(){
            $(".datepicker").datepicker("destroy");

            i++;
            //alert("Add New KRA");
            $(".kra_tbody").append('<tr class="first_kra_row"><td>'+i+'</td><td><input type="text" name="min_salary[]" class="form-control input-sm basic-detail-input-style regis-input-field" placeholder="Enter Minimum Salary" required style="border:1px solid burlywood;border-radius:1px" step="0.01" min="-99.00" max="99.99"></td><td><input type="text" name="max_salary[]" class="form-control input-sm basic-detail-input-style regis-input-field" placeholder="Enter Maximum Salary" required style="border:1px solid burlywood;border-radius:1px"></td><td><input type="text" name="pt_rate[]" class="form-control input-sm basic-detail-input-style regis-input-field" placeholder="Enter PT Rate" required style="border:1px solid burlywood;border-radius:1px"></td><td class="text-center"><a href="javascript:void(0)" class="remove_current_row" id="remove_kra"><i class="col-sm-1 fa fa-trash remove_button" style="font-size24px"></i></a></td></tr>');

            $(".remove_current_row").on('click', function(){
                $(this).parents("tr").remove();
                i--;
            });
        });
    </script>
@endsection
