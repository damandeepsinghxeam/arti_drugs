@extends('admins.layouts.app')

@section('content')

<!-- Bootstrap time Picker -->
<link rel="stylesheet" href="{{asset('public/admin_assets/plugins/timepicker/bootstrap-timepicker.min.css')}}">

<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper">

<!-- Content Header (Page header) -->

<section class="content-header">

  <h1>

    Request Change Form

    <!-- <small>Control panel</small> -->

  </h1>

  <ol class="breadcrumb">

    <li><a href="{{ url('employees/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>

  </ol>

</section>



<!-- Main content -->

<section class="content">
  
  <div class="no-print">
      <div class="callout callout-success" style="margin-bottom: 5px!important;">
        <h4><i class="fa fa-info"></i> Note:</h4>
        Be careful, You can send request for attendance change within 2 days of particular date only.
      </div>
    </div>

  <!-- Small boxes (Stat box) -->

  <div class="box box-info col-sm-6">
    <!-- <div class="box-header with-border">
        <h3 class="box-title">Horizontal Form</h3>
    </div> -->
    <!-- /.box-header -->
    <!-- form start -->
    @include('admins.validation_errors')
    
    <form id="changeAttendanceForm" class="form-horizontal" action="{{url('attendances/save-change-request')}}" method="POST">
    {{ csrf_field() }}
        <div class="box-body">
        
        <div class="form-group">
            <label for="dates" class="col-sm-2 control-label">Date</label>

            <div class="col-sm-10">
                <div class="input-group date single-input-lbl">
                    <div class="input-group-addon date-icon input-sm basic-detail-input-style">
                    <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" style="background-color:#fff" class="form-control pull-right date-input input-sm basic-detail-input-style al-date-input" name="dates" id="dates" placeholder="Select date" readonly>
                    <span class="dates-error"></span>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label">Select Change parameters</label>

            <div class="col-sm-10">
                <select class="form-control" name="select_option" id="select_option">
                    <option value="" selected disabled>Please select a parameter</option>
                    <option value="intime">In-Time</option>
                    <option value="outtime">Out-Time</option>
                    <option value="both">Both</option>
                </select>
            </div>
            
        </div>

        <div class="row" style="margin-left: 8.5%;">
            <div class="form-group col-sm-6 intime" style="display:none;">
                <label for="intime" class="col-sm-2 control-label">In-Time</label>

                <div class="col-sm-10">
                    <div class="input-group date single-input-lbl">
                        <div class="input-group-addon input-sm">
                        <i class="fa fa-clock-o"></i>
                        </div>
                        <input type="text" style="background-color:#fff" class="form-control pull-right date-input input-sm basic-detail-input-style al-date-input selectTime" name="intime" id="intime"  readonly>
                    </div>
                </div>
            </div>

            <div class="form-group col-sm-6 outtime" style="display:none;">
                <label for="outtime" class="col-sm-2 control-label">Out-Time</label>

                <div class="col-sm-10">
                    <div class="input-group date single-input-lbl">
                        <div class="input-group-addon date-icon input-sm">
                        <i class="fa fa-clock-o"></i>
                        </div>
                        <input type="text" style="background-color:#fff" class="form-control pull-right date-input input-sm basic-detail-input-style al-date-input selectTime" name="outtime" id="outtime" readonly>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Remarks</label>
            <div class="col-sm-10">
                <textarea class="form-control" name="remarks" rows="5" placeholder="Please enter your in-time and out-time with dates and explaination."></textarea>
            </div>
        </div>
        
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            <a href="{{url('employees/dashboard')}}" class="btn btn-default">Cancel</a>
            <button type="button" class="btn btn-info pull-right" id="changeAttendanceFormSubmit">Submit</button>
        </div>
        <!-- /.box-footer -->
    </form>
    </div>

  <!-- /.row -->

  <!-- /.row (main row) -->

</section>

<!-- /.content -->

</div>

<!-- /.content-wrapper -->
<!-- bootstrap time picker -->
<script src="{{asset('public/admin_assets/plugins/timepicker/bootstrap-timepicker.min.js')}}"></script>

<script src="{{asset('public/admin_assets/plugins/validations/jquery.validate.js')}}"></script>
<script src="{{asset('public/admin_assets/plugins/validations/additional-methods.js')}}"></script>
<script>

    $("#changeAttendanceForm").validate({
      rules :{
          "dates" : {
              required : true
          },
          "remarks" : {
              required : true
          },
          "select_option": {
              required : true
          },
          "intime": {
              required : true
          },
          "outtime": {
              required : true
          }
      },
      messages :{
          "dates" : {
              required : 'Please select atleast one date.'
          },
          "remarks" : {
              required : 'Please enter remarks.'
          },
          "select_option": {
              required : 'Please select a parameter.'
          },
          "intime": {
              required : 'Please select in-time.'
          },
          "outtime": {
              required : 'Please select out-time.'
          }
      }
    });
</script>

<script>
    var maximum_date = moment()._d;
    var minimum_date = moment().subtract(1, 'months').startOf('month')._d;
    //var minimum_date = moment().subtract(2, 'days').startOf('day')._d;

    $("#dates").datepicker({
        autoclose: true,
        startDate: minimum_date,
        endDate: maximum_date,
        orientation: "bottom",
        multidate: 1,
        multidateSeparator: "," 
    });

    $(".selectTime").timepicker({
        showInputs: true,
        minuteStep: 1  
    });

    $("#select_option").on("change", function(){
        let val = $(this).val();

        if(val == 'intime'){
            $(".intime").css("display","block");
            $("#outtime").val("");
            $(".outtime").css("display","none");
        }else if(val == 'outtime'){
            $("#intime").val("");
            $(".intime").css("display","none");
            $(".outtime").css("display","block");
        }else if(val == 'both'){
            $(".intime").css("display","block");
            $(".outtime").css("display","block");
        }
    });

    var allow_form_submit = {dates: 1};

    $("#dates").on('change', function(){
        $(".dates-error").text("");
        var dates = $(this).val();
        
        if(dates){
            dates = dates.split(',');

            dates = dates.map(function(date){
                        var dt = new Date(date);
                        return moment(dt).format('DD-MM-YYYY');
                    });

            $.ajax({
                type: "POST",
                url: "{{url('attendances/check-date-status')}}",
                data: {dates: dates},
                success: function(result){
                    if(result.error){
                        allow_form_submit.dates = 0;
                        $(".dates-error").append(result.error).css("color","#f00");
                    }else{
                        allow_form_submit.dates = 1;
                        $(".dates-error").text("");
                    }
                }
            });
        }           
    });

    $("#changeAttendanceFormSubmit").on('click', function(){
        if(!allow_form_submit.dates){
            return false;
        }else{
            $("#changeAttendanceForm").submit();
        }
    });
</script>

@endsection