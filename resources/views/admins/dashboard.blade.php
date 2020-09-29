@extends('admins.layouts.app')
@section('content')
<link rel="stylesheet" href="{{asset('public/admin_assets/dist/css/mobiscroll.javascript.min.css')}}">
<script src="{{asset('public/admin_assets/dist/js/mobiscroll.javascript.min.js')}}"></script>
<link rel="stylesheet" href="{{asset('public/admin_assets/bower_components/fullcalendar/dist/fullcalendar.min.css')}}">
<link rel="stylesheet" href="{{asset('public/admin_assets/bower_components/fullcalendar/dist/fullcalendar.print.min.css')}}" media="print">

<!-- Content Wrapper. Contains page content -->

<style type="text/css"> .text-muted {
     color: #000;
     font-weight: 700;
}
.profile-user-img {
    width: 130px;
    height: 130px;
    padding: 3px;
    border: 3px solid #d2d6de;
    margin: 10px auto;
}
.dashboardProfile {
    background-color: white;
    min-height: 275px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    border: 1px solid #3c8dbc;
    border-radius: 4px;
}
.datepicker .datepicker-switch:hover, .datepicker .next:hover, .datepicker .prev:hover, .datepicker tfoot tr th:hover {
    background: #3c8dbc !important;
    color: white;
    transition: all ease 0.2s;
}
 .btn-success {
     background-color: #f39c12 !important;
}
 .info-box-content.event{
     padding: 24px 4px;
}
 div#upcomingEvents {
     background: #00c0ef !important;
     color: #fff;
}
 .mbsc-padding.md-header {
     font-size: 1.25em;
     font-weight: 400;
     padding: .8em .8em .4em .8em;
}
 .md-dateslider .mbsc-padding {
     text-align: center;
     padding-bottom: 16px !important;
}
 .md-check-cont {
     padding: 8px 0 16px 0;
}
 .md-check {
     display: inline-block;
     width: 32px;
     height: 32px;
     font-size: 26px;
     padding: .2em;
     line-height: 23px;
     border-radius: 33px;
     -webkit-box-sizing: border-box;
     box-sizing: border-box;
}
 .mbsc-padding.md-header {
     font-size: 1.25em;
     font-weight: 400;
     padding: .8em .8em .4em .8em;
}
 .md-dateslider .mbsc-padding {
     text-align: center;
}
 .md-check-cont {
     padding: 8px 0 16px 0;
}
 .md-check {
     display: inline-block;
     width: 32px;
     height: 32px;
     font-size: 26px;
     padding: .2em;
     line-height: 23px;
     border-radius: 33px;
     -webkit-box-sizing: border-box;
     box-sizing: border-box;
}
 .demo-theme-mobiscroll .md-check {
     background: #4ECCC4;
     color: #f7f7f7;
}
 .demo-theme-mobiscroll-dark .md-check {
     background: #4ECCC4;
     color: #263238;
}
 .demo-theme-material .md-check {
     background: #009688;
     color: #eee;
}
 .demo-theme-material-dark .md-check {
     background: #81ccc4;
     color: #f7f7f7;
}
 .demo-theme-ios .md-check {
     background: #1272dc;
     color: #f5f5f5;
}
 .demo-theme-ios-dark .md-check {
     background: #ff8400;
     color: #1a1a1a;
}
 .demo-theme-android-holo .md-check {
     background: #31c6e7;
     color: #000;
}
 .demo-theme-android-holo-light .md-check {
     background: #31c6e7;
     color: #f5f5f5;
}
 .demo-theme-wp .md-check {
     background: #1a9fe0;
     color: #000;
}
 .demo-theme-wp-light .md-check {
     background: #1a9fe0;
     color: #fff;
}
 .mbsc-form-group-inset {
     margin: 0px;
}
 .mbsc-ios.mbsc-form {
     background: #fff;
     color: #000;
}
 .mbsc-ios.mbsc-progress {
     min-height: 0px !important;
     padding: 0px !important;
}
 .mbsc-mobiscroll.mbsc-page{
     margin-left: 10px;
}
 .col-sm-6.eventCalendar {
     padding-left: 7px;
     padding-right: 10px;
}
 .col-sm-3.attendanceCalendar {
     padding-right: 0px;
}
 .mbsc-padding.md-header.mbsc-control-w.mbsc-input {
     margin-top: 0px;
     margin-bottom: 0px;
}
 .todo-list{
     padding-bottom: 12px;
}
 .col-sm-3.dashboardProfileCol {
     background: #fff;
}
.calendar-bg {
    border: 1px solid #3c8dbc !important;
}
.box.box-solid > .box-header .btn:hover, .box.box-solid > .box-header a:hover {
    color: #3c8dbc;
    transition: ease 0.2s;
}
div#calendar_dashboard td, div#calendar_dashboard th {
    padding: 8px;
}
div#calendar_dashboard td:hover {
    background-color: rgb(210, 214, 222);
}
h2 {
    font-size: 15px;
    margin: 8px;
}
td.day.vip_day {
    border: 1px solid #3c8dbc !important;
    color: #3c8dbc;
    border-radius: 0px !important;
}
td.day.vip_day:hover {
    background-color: #3c8dbc !important;
    color: white;
    transition: all ease 0.2s;
}
.vip_day {
  position: relative;
}

.vip_day .tooltiptext {
    visibility: hidden;
    width: 120px;
    background-color: black;
    color: #fff;
    text-align: center;
    border-radius: 6px;
    padding: 10px 5px;
    position: absolute;
    z-index: 1;
    top: 125%;
    height: auto;
    line-height: 1;
    left: 50%;
    margin-left: -60px;
}

.vip_day .tooltiptext::after {
  content: "";
  position: absolute;
  bottom: 100%;
  left: 50%;
  margin-left: -5px;
  border-width: 5px;
  border-style: solid;
  border-color: transparent transparent black transparent;
}

.vip_day:hover .tooltiptext {
  visibility: visible;
}

.leave-detail-sec {
    padding: 15px 15px;
    border: 1px solid #3c8dbc;
    margin: 0 15px;
    border-radius: 8px;
    background-color: white;
}
.leave-detail-sec h3 {
    margin-top: 0px;
    font-size: 20px;
}
.card-header {
    display: flex;
    padding: 10px;
    margin: 0 10px;
    align-items: center;
    border-bottom: 1px solid #3c8dbc;
}
.card-header i {
    font-size: 30px;
    display: flex;
    justify-content: center;
    align-items: center;
    margin-right: 12px;
    color: #3c8dbc;
}
.card-header-content h3, .card-header-content p {
    margin: 0;
}
.card-header-content h3 {
  font-size: 16px;
}
.card-body {
    padding-bottom: 10px;
}
.card-body ul {
    list-style: none;
    padding-left: 0px;
}
.card-body ul li {
    margin: 15px 10px;
}
.image-box {
    display: flex;
}
.card-body ul li img {
    width: 30px;
    height: 30px;
    border: 1px solid #b2b1b0;
    border-radius: 100%;
    padding: 2px;
    margin-right: 5px;
}
.img-content h4 {
    margin: 0;
    font-size: 13px;
    font-weight: 700;
    color: #3c8dbc;
}
.img-content p {
  margin: 0;
}
.card-header img {
    margin-right: 15px;
    width: 50px;
    height: 50px;
}
.card-body.birthday_card_body ul li:not(:last-child) { border-bottom: 1px solid #3c8dbc; padding-bottom: 10px;}

.border-info { border: 1px solid #00c0ef;}
.border-danger { border: 1px solid #dd4b39;}
.border-success { border: 1px solid #00a65a;}
.border-warning { border: 1px solid #f39c12;}

.border-info, .border-danger, .border-success, .border-warning  { min-height: 92px; }

span.label{
  font-size: 0.9em;
  color: black;
}
.label-h5{
  background-color: red;
}
.label-h4{
  background-color: orange;
}
.label-h3{
  background-color: aqua;
}
.label-h2{
  background-color: yellow;
}
.label-h1{
  background-color: #fffdd0;
}
.todo-list > li .text {
  display: inline;
}

@media (min-width: 768px) {
  .modal-dialog {
      width: 400px;
  }
}
 </style>



  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      @if(session()->has('error'))
        <div class="alert alert-danger alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          {{ session()->get('error') }}
        </div>
      @endif
      @if(session()->has('message'))
        <p class="alert {{ Session::get('alert-class', 'alert-info')}}">{{ Session::get('message') }}</p>
      @endif
      <h1>
        Dashboard
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>
  @php


    if($user->employee->profile_picture){

      $profile_picture = config('constants.uploadPaths.profilePic').$user->employee->profile_picture;

    }else{

      $profile_picture = config('constants.static.profilePic');

    }



  @endphp


<!-- Main content -->
<section class="content">

 @can('edit-employee')
  <div class="row date-container">
    <form target="_blank" id="missed_punch_Form" action="{{ url('employees/get_missed_punch_data') }}" method="get" enctype="multipart/form-data">
    <div class="col-md-1" >
      <div class="form-group">Date: </div>
    </div>
    <div class="col-md-3" >
      <div class="form-group">

       {{ csrf_field() }}
        @php
        $current_date = date("Y-m-d");
        @endphp
         <input type="text" name="miss_punch_date" class="form-control datepick" value="{{ $current_date}}" required>
      </div>
    </div>
    <div class="col-md-2" >
      <div class="form-group">
          <input type="submit" class="btn btn-info submit-btn-style" id="submit3" value="View" name="submit_date">
      </div>
    </div>
    <div class="col-md-3" >
      <div class="form-group">
         <a  target="_blank" href="{{ url('employees/get_missed_punch_today') }}">{{$missed_punch_count}} Missed Punches Today</a>
      </div>
    </div>
    </form>

      <div class="col-md-1" >
        <div class="form-group">
        <a class="btn btn-info submit-btn-style" href="{{ url('attendances/store_attendance_punch/'.$user->employee_code.'/Check-In') }}"> Check In</a>      
        </div>
      </div>

      <div class="col-md-2" >
        <div class="form-group">
        <a class="btn btn-info submit-btn-style" href="{{ url('attendances/store_attendance_punch/'.$user->employee_code.'/Check-Out') }}"> Check Out</a> 
        </div>
      </div>
  </div>
  @endcan

  <div class="row">
    <div class="col-sm-12">
      <div class="row">
        <!-- col-3 starts here -->
        <div class="col-sm-3">
           <div class="dashboardProfile">
            <img class="profile-user-img img-responsive img-circle" src="{{@$profile_picture}}" alt="User profile picture">
            <h2 class="text-muted text-center">{{@$user->designation[0]->name}}</h2>
            <p class="text-center text-primary" style="font-size: 15px; margin-top: 3px;">Role: {{@$user->roles[0]->name}}</p>
            <p class="text-center text-primary" style="font-size: 14px; margin-top: 2px;">Employee code: {{$user->employee_code}}</p>
            <p class="text-center">Department: {{$user->employeeProfile->department->name}}</p>
          </div>
        </div>
        <!-- col-3 ends here -->

        <!-- col-9 starts here -->
        <div class="col-sm-9">
          <div class="box box-primary">


              <?php
                  $monthNames = Array("January", "February", "March", "April", "May", "June", "July",
          "August", "September", "October", "November", "December");

                  if (!isset($_REQUEST["month"])) $_REQUEST["month"] = date("n");
                  if (!isset($_REQUEST["year"])) $_REQUEST["year"] = date("Y");

                  $cMonth = $_REQUEST["month"];
                  $cYear = $_REQUEST["year"];

                  $prev_year = $cYear;
                  $next_year = $cYear;
                  $prev_month = $cMonth-1;
                  $next_month = $cMonth+1;

                  if ($prev_month == 0 ) {
                      $prev_month = 12;
                      $prev_year = $cYear - 1;
                  }
                  if ($next_month == 13 ) {
                      $next_month = 1;
                      $next_year = $cYear + 1;
                  }

              ?>




<!-- Calender starts here -->

    <div class="box-body no-padding">
        <!-- THE CALENDAR -->
        <div id="calendar_dash" class="fc fc-unthemed fc-ltr">
            <div class="fc-toolbar fc-header-toolbar cal_toolbar">
                <div class="fc-left">
                    <div class="fc-button-group nav_class">
                        <a href="<?php echo url()->current() . "?month=". $prev_month . "&year=" . $prev_year; ?>"><button type="button" class="fc-prev-button fc-button fc-state-default fc-corner-left" aria-label="prev"><span class="fc-icon fc-icon-left-single-arrow"></span></button></a>
                        <a href="<?php echo url()->current() . "?month=". $next_month . "&year=" . $next_year; ?>"><button type="button" class="fc-next-button fc-button fc-state-default fc-corner-right" aria-label="next"><span class="fc-icon fc-icon-right-single-arrow"></span></button></a>
                    </div>
                    <!-- <button type="button" class="fc-today-button fc-button fc-state-default fc-corner-left fc-corner-right fc-state-disabled" disabled="">today</button> -->
                </div>
                <div class="fc-center">
                    <h2><?php echo $monthNames[$cMonth-1]." ".$cYear; ?></h2></div>
                <div class="fc-clear"></div>
            </div>


<div class="fc-view-container" style="">
    <div class="fc-view fc-month-view fc-basic-view" style="">
        <table class="cal_leave_boxes">
            <thead class="fc-head">
                <tr>
                    <td class="fc-head-container fc-widget-header">
                        <div class="fc-row fc-widget-header">
                            <table class="">
                                <thead>
                                    <tr>
                                        <th class="fc-day-header fc-widget-header fc-sun"><span>Sun</span></th>
                                        <th class="fc-day-header fc-widget-header fc-mon"><span>Mon</span></th>
                                        <th class="fc-day-header fc-widget-header fc-tue"><span>Tue</span></th>
                                        <th class="fc-day-header fc-widget-header fc-wed"><span>Wed</span></th>
                                        <th class="fc-day-header fc-widget-header fc-thu"><span>Thu</span></th>
                                        <th class="fc-day-header fc-widget-header fc-fri"><span>Fri</span></th>
                                        <th class="fc-day-header fc-widget-header fc-sat"><span>Sat</span></th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </td>
                </tr>
            </thead>
            <tbody class="fc-body">
                <tr>
                    <td class="fc-widget-content">
                        <div class="fc-scroller fc-day-grid-container" style="min-height: 190px;">
                            <div class="fc-day-grid fc-unselectable">
                                <div class="fc-row fc-week fc-widget-content" style="height: 96px;">

                                    <div class="fc-bg cal_table_bg">
                                        <table>
                                            <thead>

    <?php
      $timestamp = mktime(0,0,0,$cMonth,1,$cYear);
      $maxday = date("t",$timestamp);
      $thismonth = getdate ($timestamp);
      $startday = $thismonth['wday'];

      for ($i=0; $i<($maxday+$startday); $i++) {
        $day = $i - $startday + 1;
        $cDayTime = $cYear.'-'.$cMonth.'-'.$day;

        //if(strtotime(date("Y-m-d")) >= mktime(0,0,0,$cMonth,$day,$cYear)){
        $attendanceArray = getAttendanceInfo($cDayTime, $user->id);

        //}

        $status = $attendanceArray['status'];

        if(($i % 7) == 0 ){
          // if(empty($status)){
          //   $status = "Week-Off";
          // }else{
            $status = "Week-Off";
          //}
          $attendanceArray['secondary_leave_type'] = "";
    ?>
      <tr>

    <?php }if($i < $startday) { ?>
      <td class="fc-day-top fc-sun fc-other-month fc-past" data-date=""></td>

    <?php }else{ ?>
      <td class="fc-day-top fc-sun fc-future attendance-tds" data-date="2019-09-01">
      <span class="fc-day-number"><?php echo $day ?></span>
      <div class="three-icon-box">

            @if(!empty($attendanceArray['description']))
            <div class="info-tooltip tooltip_class">
              <i class="fa fa-info-circle a-icon1"></i>
              <span class="info-tooltiptext">{{$attendanceArray['description']}}</span>
            </div>
            @endif


          <?php if($status) { ?>
          <div class="leave-type-onnly leave_class">
          <a class="fc-day-grid-event fc-h-event fc-event fc-start fc-end fc-draggable cal_leave_custom @if($status == 'Present'){{'calender-day-present'}}@elseif($status == 'Holiday'){{'calender-day-holiday'}}@elseif($status == 'Absent' || $status == 'Week-Off'){{'calender-day-absent'}}@endif">
             <span><?php echo  $status; ?></span>
          </a>

          </div>

          <?php } ?>

      </div>



  </td>

<?php
  } if(($i % 7) == 6 ){

?>

</tr>

 <?php
  }

}
?>



                                                </thead>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>




                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>


<!-- Calender ends here -->
<!--script for calender starts here-->
<script src="{{asset('public/admin_assets/plugins/validations/jquery.validate.js')}}"></script>
<script src="{{asset('public/admin_assets/plugins/validations/additional-methods.js')}}"></script>

<script type="text/javascript">
$(document).ready(function(){
  $("#employee_Attendance").validate({
    rules :{
          "year" : {
              required : true,
          },
          "month" : {
              required : true,
          }
      },
      messages :{
          "year" : {
              required : 'Please select Year.'
          },
          "month" : {
              required : 'Please select Month.'
          }
      }
  });


});
</script>


<!--script for calender ends here..-->
                </div>
            </div>
                <!-- /.box-body -->
          </div>
                <!-- Calender starts here -->
        </div>
      </div>
    </div>


<div class="modal fade" id="birthday_modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close attendance-close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title text-center">List of Employee Birthday's&nbsp;&nbsp;<span class="user-remarks"></span></h4>
      </div>
      <div class="modal-body">
        <div class="card-body birthday_card_body">
          <ul>
            @foreach($birthdays as $birthday)
              @php

              if($birthday->profile_picture){

                $profile_pic =config('constants.uploadPaths.profilePic').$birthday->profile_picture;

              }else{

                $profile_pic = config('constants.static.profilePic');

              }
              @endphp
            <li>
              <div class="image-box">
                <img src="{{@$profile_pic}}" alt="">
                <div class="img-content">
                  <h4>{{$birthday->fullname}}</h4>
                  <p><small><label class="label label-danger">{{date("d-M. ", strtotime($birthday->birth_date))}}</label></small></p>
                </div>
              </div>
            </li>
           @endforeach

          </ul>
        </div>
      </div>
    </div>
        <!-- col-9 ends here -->
      </div>
    </div>
  </div>
</section>

<section class="leave-detail-sec">
  <!-- Leave detail starts here -->
  <div class="row">
    <h3 class="text-center">Leave Details</h3>
    <div class="col-md-12">
      <div class="outer-border">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box border-info">
            <span class="info-box-icon bg-aqua"><i class="fa fa-list"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Total Leaves</span>
              <span class="info-box-number">{{$probation_data->total_leaves}}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box border-danger">
            <span class="info-box-icon bg-red"><i class="fa fa-list"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Balance Leave</span>
              <span class="info-box-number">{{$probation_data->leaves_left}}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>

        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box border-success">
            <span class="info-box-icon bg-green"><i class="fa fa-list"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Paid Leaves</span>
              <span class="info-box-number">{{@$probation_data->paid_count}}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box border-warning">
            <span class="info-box-icon bg-yellow"><i class="fa fa-list"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Unpaid Leaves</span>
              <span class="info-box-number">{{@$probation_data->unpaid_count}}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
      </div>
    </div>
  </div>
  <!-- Leave detail ends here -->
</section>

{{--<section class="content">--}}
{{--  <div class="row">--}}
{{--    <div class="col-sm-12">--}}
{{--        <div class="row">--}}
{{--      <div class="col-sm-5">--}}
{{--        <div class="box box-primary">--}}
{{--          <div class="box-header ui-sortable-handle" style="cursor: move;">--}}
{{--            <i class="ion ion-clipboard"></i>--}}
{{--            <h3 class="box-title">Tasks</h3>--}}
{{--          </div>--}}
{{--          <!-- /.box-header -->--}}
{{--          <div class="box-body">--}}
{{--            <!-- See dist/js/pages/dashboard.js to activate the todoList plugin -->--}}
{{--              <ul class="todo-list ui-sortable">--}}
{{--                  @php --}}
{{--                  --}}
{{--                  if($tasks->isEmpty()){--}}
{{--                   echo "There is no Records to show.";--}}
{{--                  }else{--}}

{{--                  @endphp    --}}
{{--                @foreach($tasks as $task)--}}
{{--                  @php --}}

{{--                  $tt=$task->task->due_date;       --}}
{{--                                               --}}
{{--                  @endphp--}}
{{--                <li class="">--}}
{{--                  <!-- drag handle -->--}}
{{--                    <span class="handle ui-sortable-handle">--}}
{{--                        <i class="fa fa-ellipsis-v"></i>--}}
{{--                        <i class="fa fa-ellipsis-v"></i>--}}
{{--                      </span>--}}
{{--                    <!-- checkbox -->--}}
{{--                    --}}
{{--                    <!-- todo text -->--}}
{{--                    <span class="text">{{$task->task->title}}</span><br>--}}
{{--                    <!-- Emphasis label -->--}}
{{--                                         --}}
{{--                      @if($task->task->priority == 'H5')--}}
{{--                        <span class="label label-h5">H5</span>--}}
{{--                        @elseif($task->task->priority == 'H4')--}}
{{--                          <span class="label label-h4">H4</span>--}}
{{--                        @elseif($task->task->priority == 'H3')--}}
{{--                          <span class="label label-h3">H3</span>--}}
{{--                        @elseif($task->task->priority == 'H2')--}}
{{--                          <span class="label label-h2">H2</span>--}}
{{--                        @elseif($task->task->priority == 'H1')--}}
{{--                          <span class="label label-h1">H1</span>--}}
{{--                      @endif    --}}
{{--                    --}}
{{--                    <small class="label label-info"><i class="fa fa-clock-o"></i> {{timeleft($tt)}}</small>--}}
{{--                </li>--}}
{{--               @endforeach--}}
{{--               @php } @endphp--}}
{{--              </ul>--}}
{{--          <div class="box-tools pull-right">--}}
{{--              {{ $tasks->links() }}--}}
{{--              <!-- <ul class="pagination pagination-sm inline">--}}
{{--                  <li><a href="#">«</a></li>--}}
{{--                  <li><a href="#">1</a></li>--}}
{{--                  <li><a href="#">2</a></li>--}}
{{--                  <li><a href="#">3</a></li>--}}
{{--                  <li><a href="#">»</a></li>--}}
{{--              </ul> -->--}}
{{--            </div>--}}
{{--          </div>--}}
{{--          <!-- /.box-body -->--}}
{{--        </div>--}}
{{--      </div>--}}
{{--      <div class="col-sm-4">--}}
{{--        <div class="box box-primary">--}}
{{--          <div class="card">--}}
{{--            <div class="card-header">--}}
{{--              <img src="{{asset('public/uploads/dashboard/birthday_gif_1.gif')}}" alt="birthday Image">--}}
{{--              <div class="card-header-content">--}}
{{--                <h3>Happy Birthday</h3>--}}
{{--                <p>List of employees whose birthdays are in the next <b>30</b> Days</p>--}}
{{--              </div>--}}
{{--            </div>--}}
{{--            <div class="card-body">--}}
{{--              <ul>--}}
{{--                <li>--}}
{{--                  <div class="row">--}}
{{--                  @php--}}
{{--                  $count=0;--}}
{{--                  @endphp--}}
{{--                  @foreach($birthdays as $birthday)--}}
{{--                @php--}}
{{--                if($birthday->profile_picture){--}}

{{--                  $prof_pic =config('constants.uploadPaths.profilePic').$birthday->profile_picture;--}}

{{--                }else{--}}

{{--                  $prof_pic = config('constants.static.profilePic');--}}

{{--                }--}}
{{--                if($count<4){ @endphp--}}

{{--                    <div class="col-sm-6">--}}
{{--                      <div class="image-box">  --}}
{{--                        <img src="{{@$prof_pic}}" alt="{{$birthday->fullname}}">--}}
{{--                        <div class="img-content">--}}
{{--                          <h4>{{$birthday->fullname}}</h4>--}}
{{--                          <p><label class="label label-danger">{{date("d-M. ", strtotime($birthday->birth_date))}}</label></p>--}}
{{--                        </div>--}}
{{--                      </div>--}}
{{--                    </div>--}}
{{--                    @php--}}
{{--              }--}}
{{--                $count++;--}}

{{--                if($count%2==0 && $count<=4){ @endphp--}}
{{--                  </div>--}}
{{--                </li><li><div class="row">--}}

{{--                @php--}}
{{--                }--}}
{{--                @endphp--}}

{{--                @endforeach--}}
{{--                   --}}
{{--                  </div>--}}
{{--                </li>--}}
{{--                --}}
{{--              </ul>--}}
{{--              <div class="text-center">  --}}
{{--                <a href="#" class="btn btn-info btn-sm" data-toggle="modal" data-target="#birthday_modal">Show All</a>--}}
{{--              </div>--}}
{{--            </div>--}}
{{--          </div>--}}
{{--        </div>--}}
{{--      </div>--}}
{{--      <div class="col-sm-3">--}}
{{--        <div class="box box-primary">--}}
{{--          <div class="card">--}}
{{--            <div class="card-header">--}}
{{--              <img src="{{asset('public/uploads/dashboard/holiday1.gif')}}" alt="birthday Image">--}}
{{--              <div class="card-header-content">--}}
{{--                <h3>Event Holidays</h3>--}}
{{--                <p>Check out Holiday List</p>--}}
{{--              </div>--}}
{{--            </div>--}}
{{--            <div class="card-body">--}}
{{--              <ul>--}}
{{--               --}}
{{--               @foreach($holidays as $holiday)--}}
{{--                <li>--}}
{{--                  <div> --}}
{{--                      <div class="img-content" style="display: flex; justify-content: space-between;">--}}
{{--                        <h4>--}}
{{--                          <i class="fa fa-calendar-check-o" style="display: inline-block"></i>&nbsp;{{$holiday->name}}</h4>--}}
{{--                        <label class="label label-info">{{date("d-M.",strtotime($holiday->holiday_from))}}</label>--}}
{{--                      </div>--}}
{{--                    </div>--}}
{{--                </li>--}}
{{--                @endforeach--}}
{{--              </ul>--}}
{{--              <div class="text-center">  --}}
{{--                <a href="{{url('leaves/holidays')}}" class="btn btn-info btn-sm">All Holidays</a>--}}
{{--              </div>--}}
{{--            </div>--}}
{{--          </div>--}}
{{--        </div>--}}
{{--      </div>--}}
{{--      </div>--}}
{{--    </div>--}}
{{--  </div>--}}
{{--</section>--}}



    <!-- /.content -->



  </div>

<script type="text/javascript">

  var dayNames = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],

    monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],

    d = new Date(),

    diff = d.getDate() - d.getDay(),

    nextSunday = new Date(d.setDate(diff)),

    slider = document.getElementById('slider'),

    nextWeek = {};



function setText(d) {

    document.querySelector('.md-date').innerHTML = monthNames[d.getMonth()] + " " + d.getDate();

}



slider

    .addEventListener('change', function (ev) {

        setText(nextWeek[Math.round(this.value)]);

    });





mobiscroll.form('#demo', {

    theme: 'ios'

});



mobiscroll.slider('#slider', {

    theme: 'ios',

    onInit: function (event, inst) {

        var labels = slider.parentNode.querySelectorAll('.mbsc-progress-step-label');



        for (var i = 0; i < labels.length; ++i) {

            nextWeek[Math.round(labels[i].innerHTML)] = new Date(nextSunday.getFullYear(), nextSunday.getMonth(), nextSunday.getDate() + i); // generate nextWeek object

            labels[i].innerHTML = dayNames[i];

        }

        setText(nextSunday);

    }

});


</script>

  <!-- /.content-wrapper -->

  @endsection
  @section('extra_foot')
  <script type="text/javascript">
  $(function () {
          $('.datepick').datepicker({
             autoclose: true,
            orientation: "bottom",
            format: 'yyyy-mm-dd'
          });
      });
  </script>
  @endsection
