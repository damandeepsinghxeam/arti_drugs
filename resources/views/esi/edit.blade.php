@extends('admins.layouts.app')

@section('content')


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1><i class="fa fa-list"></i> UPDATE ESI</h1>
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
                        <form id="pf_esi" action="{{ route('payroll.esi.update',$esi->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="box-body jrf-form-body">
                                <fieldset>
                                    <legend>Employee State Insurance</legend>
                                    <div class="form-group row col-md-12">

                                        <div class="col-md-4">
                                            <label for="name" class="basic-detail-label">Employee(%)<span style="color: red">*</span></label>
                                            <input type="text" name="employee_percent" id="" class="form-control experiencedata regis-input-field only_numeric"  step="0.01" min="-99.00" max="99.99" value="{{ $esi->employee_percent }}">
                                        </div>

                                        <div class="col-md-4">
                                            <label for="name" class="basic-detail-label">Employer(%)<span style="color: red">*</span></label>
                                            <input type="text" name="employer_percent" id="" class="form-control experiencedata regis-input-field only_numeric" step="0.01" min="-99.00" max="99.99"  value="{{ $esi->employer_percent }}">
                                        </div>

                                        <div class="col-md-4">
                                            <label for="name" class="basic-detail-label">Cut Off</label>
                                            <input type="text" name="cutoff" id="" class="form-control experiencedata regis-input-field only_numeric" value="{{ $esi->cutoff }}">
                                        </div>

                                    </div>
                                    <div class="form-group row col-md-12">
                                        <div class="col-md-3">
                                            <label for="name" class="basic-detail-label">Effective From Date<span style="color: red">*</span></label>
                                            <input type="date" name="effective_esi_dt" id="" class="form-control" value="{{ $esi->effective_esi_dt }}">
                                        </div>
                                    </div>

                                    <input type="hidden" name="pf_esi_val" id="" class="form-control"  value="{{ $esi->id }}">

                                </fieldset>
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

        $("#pf_esi").validate({
            rules: {
                "epf_percent" : {
                    required: true
                },
                "epf_cutoff" : {
                    required: true
                }

            },

        });


        $('.only_numeric').bind('keyup paste', function(){

            // this.value = this.value.replace(/[^0-9-]/g, '');

        });

    </script>
@endsection
