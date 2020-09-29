@extends('admins.layouts.app')

@section('content')

<!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Generate Leave Report 
        
      </h1>
      <ol class="breadcrumb breadcrumb-leave-change">
        <li><a href="{{ url('employees/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
          <div class="col-sm-12">
           <div class="box box-primary">
                @include('admins.validation_errors')

                @if(session()->has('uniqueError'))
                  <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    {{ session()->get('uniqueError') }}
                  </div>
                @endif
                
            <div class="box-header with-border leave-form-title-bg">
              <h3 class="box-title">Leave Report Form</h3>
              
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            
            <form id="leaveReportForm" action="{{ url('leaves/create-leave-report') }}" method="POST">
              {{ csrf_field() }}
              <div class="box-body form-sidechange form-decor">

                <div class="row showDates">

                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4 col-sm-3 col-xs-3 leave-label-box">
                                    <label for="inputEmail3" class="control-label holiday-label">From Date</label>
                                </div>
                                <div class="col-md-8 col-sm-9 col-xs-9 leave-input-box-right">
                                    <div class="input-group basic-detail-input-style">
                                      <input type="text" class="form-control selectDate apply-leave-input" id="fromDate" name="fromDate" placeholder="Select a date" readonly>

                                      <div class="input-group-addon time-icon">
                                        <i class="fa fa-calendar"></i>
                                      </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4 col-sm-3 col-xs-3 leave-label-box">
                                    <label for="inputEmail3" class="control-label holiday-label">To Date</label>
                                </div>
                                <div class="col-md-8 col-sm-9 col-xs-9">
                                    <div class="input-group basic-detail-input-style">
                                      <input type="text" class="form-control selectDate apply-leave-input" id="toDate" name="toDate" placeholder="Select a date" readonly>

                                      <div class="input-group-addon time-icon">
                                        <i class="fa fa-calendar"></i>
                                      </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <span class="dateErrors"></span>
                <span class="noDayErrors"></span>

                <div class="form-group">
                  <div class="row">
                      <div class="col-md-2 col-sm-3 col-xs-3 leave-label-box">
                          <label class="apply-leave-label">Project</label>
                      </div>
                      <div class="col-md-10 col-sm-9 col-xs-9 leave-input-box">
                          <select class="form-control basic-detail-input-style apply-leave-input" name="project" id="project">
                            <option value="0">All</option>
                            @if(!$data['projects']->isEmpty())
                              @foreach($data['projects'] as $project)  
                                <option value="{{$project->id}}">{{$project->name}}</option>
                              @endforeach
                            @endif
                          </select>
                      </div>
                  </div>
                </div>

                 
                <div class="form-group">
                  <div class="row">
                      <div class="col-md-2 col-sm-3 col-xs-3 leave-label-box">
                          <label class="apply-leave-label">Department</label>
                      </div>
                      <div class="col-md-10 col-sm-9 col-xs-9 leave-input-box">
                          <select class="form-control basic-detail-input-style apply-leave-input" name="department" id="department"> 
                          <option value="0">All</option> 
                            @if(!$data['departments']->isEmpty())
                              @foreach($data['departments'] as $department)  
                                <option value="{{$department->id}}">{{$department->name}}</option>
                              @endforeach
                            @endif
                          </select>
                      </div>
                  </div>
                </div> 

                <input type="hidden" name="noDays" id="noDays" value="1">
                <input type="hidden" name="weekends" id="weekends" value="0">
                <input type="hidden" name="holidays" id="holidays" value="0">


                  
              </div>
              <!-- /.box-body -->

              <div class="box-footer form-sidechange add-compensatory-btn">
                <button type="button" class="btn btn-primary" id="leaveReportFormSubmit">Submit</button>
              </div>
            </form>
            
          </div>
      </div>
          <!-- /.box -->
      </div>
      <!-- /.row -->
      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        
      </div>
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
    var allowFormSubmit = { date: 1};

    //Date picker
    $("#fromDate").datepicker({
      autoclose: true,
      orientation: "bottom"
      
    });

    $("#toDate").datepicker({
      autoclose: true,
      orientation: "bottom"
      
    });

    $("#leaveReportForm").validate({
      rules :{
          "toDate" : {
              required : true
          },
          "fromDate" : {
              required : true
          },
          "project":{
              required: true
          },
          "department":{
              required: true
          }
      },
      messages :{
          "toDate" : {
              required : 'Please select a date.'
          },
          "fromDate" : {
              required : 'Please select a date.'
          },
          "project":{
              required: 'Please select a project.'
          },
          "department":{
              required: 'Please select a department.'
          }

      }
    });

  </script>

  <script type="text/javascript">

    $(".dateErrors").hide();
    $(".noDayErrors").hide();

    function enumerateDaysBetweenDates(startDate, endDate) {
        startDate = moment(startDate);
        endDate = moment(endDate);
        var now = startDate.clone(); 
        var dates = [];

        while (now.isSameOrBefore(endDate)) {
            dates.push(now.format('YYYY-MM-DD'));
            now.add(1, 'days');
        }
        return dates;
    };

    $(".selectDate").on("change",function(){

      var fromDate = $("#fromDate").val();
      var toDate = $("#toDate").val();

         if(Date.parse(fromDate) > Date.parse(toDate)){
            allowFormSubmit.date = 0;
            $(".dateErrors").text("Please select valid dates.");
            $(".dateErrors").show();
         }else{
            allowFormSubmit.date = 1;

            var oneDay = 24*60*60*1000; // hours*minutes*seconds*milliseconds
            var diffDays = Math.round(Math.abs((Date.parse(toDate) - Date.parse(fromDate))/(oneDay)));

            if(isNaN(diffDays)){
              
              $("#noDays").val("0");
              
              allowFormSubmit.date = 0;
              $(".dateErrors").text("Please select valid dates.");
              $(".dateErrors").show();

            }else{
              
              diffDays = diffDays + 1;
              console.log("diff1: "+diffDays);

              $("#noDays").val(diffDays);

              //Calculate the sundays between dates
              var result = [];
              if(fromDate != toDate){
                var startSundayCheck = moment(fromDate); 
                var endSundayCheck   = moment(toDate); 
                var sunday   = 0;                    // Sunday
                
                var current = startSundayCheck.clone();
                var checkStart = startSundayCheck.format('dddd');
                
                if(checkStart == 'Sunday'){
                  result.push(current.clone()._d);
                }

                while (current.day(7 + sunday).isSameOrBefore(endSundayCheck)) {
                  result.push(current.clone()._d);
                }
                //console.log(result.map(m => m._d));
              }
              else if(fromDate == toDate){
                var startSundayCheck = moment(fromDate);
                var sunday = startSundayCheck.format('dddd');

                if(sunday == 'Sunday'){
                  result = [startSundayCheck._d];
                }
              }  
                
              $("#weekends").val(result.length);
              //End Calculation of sundays between dates
              
              //Calculate holidays that are not Sundays
              var allDatesArray = enumerateDaysBetweenDates(fromDate, toDate);

              $.each(result, function(key, value){
                result[key] = moment(value).format("YYYY-MM-DD");
              });

              $.ajax({
                type : 'POST',
                url : "{{ url('leaves/between-leave-holidays') }}",
                data: {all_dates_array: allDatesArray},
                success: function (res) {
                  
                  resLength = Number(res.length);
                  $("#holidays").val(resLength);

                } 
              });
              //End Calculate holidays that are not Sundays
              

            }

            $(".dateErrors").text("");
            $(".dateErrors").hide();
         }
      
  
    });

  </script>

  <script type="text/javascript">
    
      $("#leaveReportFormSubmit").click(function(){

        console.log(allowFormSubmit);

        if(allowFormSubmit.date == 0){
          return false;
        }
        
        if(allowFormSubmit.date == 1){
          $("#leaveReportForm").submit();
        }
        

      });
  </script>

  @endsection