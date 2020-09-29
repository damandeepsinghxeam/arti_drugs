@extends('admins.layouts.app')

@section('content')


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1><i class="fa fa-list"></i> CREATE Conveyance</h1>
            <ol class="breadcrumb">
                <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">Conveyance</a></li>
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
                        <form id="pf_esi" action="{{ route('conveyance.update', $conveyance->id) }}" method="POST">
                            @csrf
                            @method('PATCH')

                            <div class="box-body jrf-form-body">

                                <fieldset>
                                    <div class="form-group row col-md-12">
                                        <div class="col-md-4">
                                            <label for="name" class="basic-detail-label">Conveyance Name<span style="color: red">*</span></label>
                                            <input type="text" name="conveyance_name" id="" value="{{ $conveyance->name }}" placeholder="Enter Conveyance Name" class="form-control experiencedata regis-input-field ">
                                        </div>
                                    </div>
                                    <div class="form-group row col-md-12">
                                        <div class="col-md-2">
                                            <label for="name" class="basic-detail-label">Is_local</label>
                                            <input type="checkbox" value="1" name="is_local" placeholder="Enter Is_Local"  id="myCheck" onclick="myFunction()"  @if($conveyance->islocal == 1) checked=checked @endif>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="checkbox" value="1" name="is_attachment" id="" placeholder="Enter Is_Attachment (%)"  @if($conveyance->is_attachment == 1) checked=checked @endif>
                                            <label for="name" class="basic-detail-label">Is_Attachment(%)<span style="color: red">*</span></label>
                                        </div>
                                    </div>
                                    <div class="form-group row col-md-12">
                                        <div class="col-md-4" id="price_per_km">
                                            <label for="name" class="basic-detail-label">Price /Km</label>
                                            <input type="text" name="price_per_km" id="price_per_km" placeholder="Enter Price /Km" value="{{ $conveyance->price_per_km }}" class="form-control experiencedata regis-input-field ">
                                        </div>
                                    </div>
                                    @foreach($bands as $band)
                                        <label class="checkbox-inline">
                                            <input type="checkbox" value="{{ $band->id }}" name="bands[]" @if(in_array($band->id, $conveyanceBands)) checked=checked @endif>{{ $band->name }}
                                        </label>
                                    @endforeach
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
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <script src="{{asset('public/admin_assets/plugins/validations/jquery.validate.js')}}"></script>

    <script src="{{asset('public/admin_assets/plugins/validations/additional-methods.js')}}"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#price_per_km').hide();
            myFunction();
        });

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
        function myFunction() {
            var checkBox = document.getElementById("myCheck");
            var text = document.getElementById("price_per_km");
            if (checkBox.checked == true){
                text.style.display = "block";
            } else {
                text.style.display = "none";
            }
        }

    </script>
@endsection
