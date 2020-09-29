@extends('admins.layouts.app')

@section('content')

<link rel="stylesheet" href="{{asset('public/admin_assets/bower_components/fullcalendar/dist/fullcalendar.min.css')}}">
<link rel="stylesheet" href="{{asset('public/admin_assets/bower_components/fullcalendar/dist/fullcalendar.print.min.css')}}" media="print">

<!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

      <h1><i class="fa fa-tasks"></i> Attendance</h1>

      <ol class="breadcrumb">

        <li><a href="{{url('employees/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>

      </ol>

    </section>


    <!-- Main content -->

    <section class="content">

      <!-- Small boxes (Stat box) -->

      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary"> 
              <form id="employee_Attendance" method="GET">
                  <div class="row select-detail-below">
                      
                      <input type="hidden" name="id" value="{{$user->id}}">

                      <div class="col-md-2 attendance-column1">
                        <label>Year<sup class="ast">*</sup></label>
                        <select class="form-control input-sm basic-detail-input-style" id="year" name="year">
                            <option value="" selected disabled>Please select Year</option>
                            <option value="2020">2020</option>
                            <option value="2019">2019</option>
                            <option value="2018">2018</option>
                            <option value="2017">2017</option>
                            <option value="2016">2016</option>
                        </select>
                      </div>

                      <div class="col-md-2 attendance-column2">
                        <label>Month<sup class="ast">*</sup></label>
                        <select class="form-control input-sm basic-detail-input-style" id="month" name="month">
                            <option value="" selected disabled>Please select Month</option>
                            <option value="1">January</option>
                            <option value="2">February</option>
                            <option value="3">March</option>
                            <option value="4">April</option>
                            <option value="5">May</option>
                            <option value="6">June</option>
                            <option value="7">July</option>
                            <option value="8">August</option>
                            <option value="9">September</option>
                            <option value="10">October</option>
                            <option value="11">November</option>
                            <option value="12">December</option>
                        </select>
                      </div>                  

                      <div class="col-md-2 attendance-column4">
                          <div class="form-group">
                              <button type="submit" class="btn searchbtn-attendance">Search <i class="fa fa-search"></i></button>
                          </div>
                      </div>
                  </div>
                  <br>
              </form>

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
                  $verifyAttendanceButton = config('constants.restriction.verifyAttendanceButton');
                  $secondDayOfNextMonth = date($verifyAttendanceButton, strtotime('+1 months', strtotime($cYear.'-'.$cMonth.'-'.'03')));

              ?>
              <hr class="attendance-hr">
              <!-- Attendance guide section starts here -->
              <div class="emp-name-and-color">
                <div class="attendance-guide">
                  <ul>
                    <li class="attendance-rectangle holiday-only">Holiday</li>
                    <li class="attendance-rectangle present-only">Present</li>
                    <li class="attendance-rectangle absent-only">Absent</li>
                    <li class="attendance-rectangle check-in-only">Check-In</li>
                    <li class="attendance-rectangle check-out-only">Check-Out</li>
                  </ul>
                </div>
                <div class="a-last-absent">
                  <h3 class="a-employe-name">{{$user->employee->fullname}}</h3>
                  <!-- <span class="a-last-absent-span1">bsenLast At:</span> -->
                  <!-- <span class="a-last-absent-span2">25 Days Ago</span> -->
                </div>
              </div>
              <!-- Attendance guide section ends here -->



<!-- Calender starts here -->
<div class="box">
    <div class="box-body no-padding">
        <!-- THE CALENDAR -->
        <div id="calendar" class="fc fc-unthemed fc-ltr">
            <div class="fc-toolbar fc-header-toolbar">
                <div class="fc-left">
                    <div class="fc-button-group">
                        <a href="<?php echo url()->current() . "?month=". $prev_month . "&year=" . $prev_year. "&id=". $user->id; ?>"><button type="button" class="fc-prev-button fc-button fc-state-default fc-corner-left" aria-label="prev"><span class="fc-icon fc-icon-left-single-arrow"></span></button></a>
                        <a href="<?php echo url()->current() . "?month=". $next_month . "&year=" . $next_year. "&id=". $user->id; ?>"><button type="button" class="fc-next-button fc-button fc-state-default fc-corner-right" aria-label="next"><span class="fc-icon fc-icon-right-single-arrow"></span></button></a>
                    </div>
                    <!-- <button type="button" class="fc-today-button fc-button fc-state-default fc-corner-left fc-corner-right fc-state-disabled" disabled="">today</button> -->
                </div>
                <div class="fc-center">
                    <h2><?php echo $monthNames[$cMonth-1]." ".$cYear; ?></h2>
                </div>
                
                @if(strtotime($cYear.'-'.$cMonth.'-'.'01') >= strtotime("2019-09-01") && $verify['isverified'] == 0 && $verify['verifier'] != 0 && strtotime(date("Y-m-d h:i:s")) > strtotime($secondDayOfNextMonth))    
                  <button type="button" class="btn btn-primary verify-btn-calender verifyMonthAttendance" data-userid="{{$user->id}}" data-managerid="{{$verify['verifier']}}" data-ondate="{{$cYear.'-'.$cMonth.'-'.'1'}}">Verify Attendance</button>
                  
                @elseif(strtotime($cYear.'-'.$cMonth.'-'.'01') >= strtotime("2019-09-01") && $verify['isverified'] == 1)  
                  <span class="verify-btn-calender attendance-verified label-success">Verified</span>
                @elseif(strtotime($cYear.'-'.$cMonth.'-'.'01') >= strtotime("2019-09-01") && $verify['isverified'] == 0)  
                  <span class="verify-btn-calender attendance-verified label-danger">Unverified</span>
                @endif
                <div class="fc-clear"></div>
            </div>


<div class="fc-view-container" style="">
    <div class="fc-view fc-month-view fc-basic-view" style="">
        <table class="">
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
                        <div class="fc-scroller fc-day-grid-container" style="overflow: hidden; height: 666px;">
                            <div class="fc-day-grid fc-unselectable">
                                <div class="fc-row fc-week fc-widget-content" style="height: 96px;">
                                    
                                    <div class="fc-bg">
                                        <table>
                                            <thead>

    <?php
      $timestamp = mktime(0,0,0,$cMonth,1,$cYear);    
      $maxday = date("t",$timestamp);
      $thismonth = getdate ($timestamp);
      $startday = $thismonth['wday'];

      $allowAttendanceVerification = 1;

      for ($i=0; $i<($maxday+$startday); $i++) {
        $day = $i - $startday + 1;
        $cDayTime = $cYear.'-'.$cMonth.'-'.$day;

        //if(strtotime(date("Y-m-d")) >= mktime(0,0,0,$cMonth,$day,$cYear)){
          $attendanceArray = getAttendanceInfo($cDayTime, $user->id);

        //} 

        $status = $attendanceArray['status'];

        $mapUrl = url('attendances/view-map').'?id='.$user->id.'&date='.$cDayTime;

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

    <?php }else{ 

        if(empty($status)){
          $allowAttendanceVerification = 0;  //one of the dates do not have status
        }

    ?>
      <td class="fc-day-top fc-sun fc-future attendance-tds" data-date="2019-09-01">
      <span class="fc-day-number"><?php echo $day ?></span>
      <div class="three-icon-box">
          
            @if(!empty($attendanceArray['description']))
            <div class="info-tooltip">
              <i class="fa fa-info-circle a-icon1"></i>
              <span class="info-tooltiptext">{{$attendanceArray['description']}}</span>
            </div>  
            @endif  
            
          
            @if(!empty($attendanceArray['first_punch']))
            <div class="eye-tooltip" data-date="{{$cDayTime}}" data-userid="{{$user->id}}">
              <i class="fa fa-eye a-icon2"></i>
              <span class="eye-tooltiptext">View In-Outs</span>
            </div>
            @endif  
          
          <div class="edit-tooltip" data-date="{{$cDayTime}}" data-remarks="{{$attendanceArray['remarks']}}" data-userid="{{$user->id}}">
              <i class="fa @if(!empty($attendanceArray['remarks'])){{'fa-edit a-icon4'}}@endif"></i>
              <span class="edit-tooltiptext">@if(!empty($attendanceArray['remarks'])){{'View Remarks'}}@endif</span>
          </div>

          @if((empty($status) || in_array($status,['Present','Absent'])) && ($verify['isverified'] == 0 && $verify['verifier'] != 0))
            <!-- <div class="status-tooltip" data-date="{{date('d-m-Y',strtotime($cDayTime))}}" data-userid="{{$user->id}}" data-status="{{$status}}">
              <i class="fa fa-clock-o a-icon5"></i>
              <span class="status-tooltiptext">Change Status</span>
            </div> -->
          @endif
      </div>

          <?php if($status) { ?>
          <div class="leave-type-onnly">
          <a class="fc-day-grid-event fc-h-event fc-event fc-start fc-end fc-draggable @if($status == 'Present'){{'calender-day-present'}}@elseif($status == 'Holiday'){{'calender-day-holiday'}}@elseif($status == 'Absent' || $status == 'Week-Off'){{'calender-day-absent'}}@endif">
             <span><?php echo  $status; ?></span>
          </a>
            <div>
            <a><span class="label label-warning full-short-half"><?php echo  $attendanceArray['secondary_leave_type']; ?></span></a>
            </div>
          </div>

          <?php } 
            if(!empty($attendanceArray['first_punch'])){
          ?>
          <div>  
          <a class="fc-day-grid-event fc-h-event fc-event fc-start fc-end fc-draggable calender-day-check-in @if(@$attendanceArray['late']){{'late'}}@endif">
             <span class="fc-title"><?php echo  $attendanceArray['first_punch']; ?></span>
          </a>
            @if(@$attendanceArray['first_punch_type'] != 'NA')
              <a href="{{$mapUrl}}"><span><i class="fa fa-map-marker" aria-hidden="true"></i></span></a>
            @endif
          </div>
          <?php } 
            if(!empty($attendanceArray['last_punch'])){
          ?>
          <div>
          <a class="fc-day-grid-event fc-h-event fc-event fc-start fc-end fc-draggable calender-day-check-out">
             <span class="fc-title"><?php echo  $attendanceArray['last_punch']; ?></span>
          </a>
            @if(@$attendanceArray['last_punch_type'] != 'NA')
              <a href="{{$mapUrl}}"><span><i class="fa fa-map-marker" aria-hidden="true"></i></span></a>
            @endif
          </div>
          <?php } ?>
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
</div>

<!-- Calender ends here -->









        </div>
    </div>
    <!-- /.box-body -->
</div>
<!-- Calender starts here -->
          </div>
        </div>
      </div>

      <!-- /.row -->
<div class="modal fade" id="modal-in-outs">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close attendance-close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title text-center">Multiple In-Outs &nbsp;&nbsp;<span class="multiple-in-outs"></span></h4>
      </div>
      <div class="modal-body attendance-present-modal append-punches">
        
      </div>
      <div class="modal-footer in-out-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade" id="modal-remarks">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close attendance-close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title text-center">User's Remarks &nbsp;&nbsp;<span class="user-remarks"></span></h4>
      </div>

      <form id="attendanceRemarkForm" method="POST" action="{{url('attendances/save-remarks')}}">
        {{ csrf_field() }}
      <div class="modal-body">
        
        <p>Remark:</p>
        <textarea rows="2" cols="4" placeholder="Your remarks" id="remarks" name="remarks" class="add-remark-textarea" disabled></textarea>

        <input type="hidden" name="user_id" value="{{$user->id}}">
        <input type="hidden" id="on_date" name="on_date" value="">
        <input type="hidden" id="url" name="url" value="">
        
      </div>
      <div class="modal-footer in-out-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


<div class="modal fade" id="modal-changeStatus">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close attendance-close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title text-center">Change Status</h4>
      </div>

      <form id="changeStatusForm" method="POST" action="{{url('attendances/change-status')}}">
        {{ csrf_field() }}
      <div class="modal-body">
          <div class="row">
            <div class="col-md-4 attendance-column1">
              <div class="form-group">
                <label>Status</label>
                <select name="attendanceStatus" id="attendanceStatus" class="form-control input-sm basic-detail-input-style">
                  <option value="Present">Present</option>
                  <option value="Absent">Absent</option>
                </select>
              </div>
            </div>
            <div class="col-md-4 attendance-column2">
              <div class="form-group">
                <label>On-Date</label>
                <input type="text" class="form-control input-sm basic-detail-input-style" name="on_date" id="change_on_date" readonly>
              </div>
            </div>
            <div class="col-md-4 attendance-column4">
              <div class="form-group">
                <div class="change_on_time">
                  <label>On-Time</label>
                  <input type="text" class="form-control input-sm basic-detail-input-style" name="on_time" id="change_on_time" placeholder="09:30 AM or 01:00 PM">
                </div>
              </div>
              <input type="hidden" name="user_id" value="{{$user->id}}">
              <input type="hidden" id="change_url" name="url" value="">
            </div>
          </div>
        
      </div>
      <div class="modal-footer in-out-footer">
        <button type="submit" id="saveStatus" class="btn btn-primary" name="saveStatus" value="Save">Save</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

      <!-- Main row -->
      <!-- /.row (main row) -->
    </section>

    <!-- /.content -->

  </div>
  <!-- /.content-wrapper -->
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

  $("#attendanceRemarkForm").validate({
    rules :{
          "remarks" : {
              required : true,
          }
      },
      messages :{
          "remarks" : {
              required : 'Please select remarks.'
          }
      }
  });

  $("#changeStatusForm").validate({
    rules :{
          "attendanceStatus" : {
              required : true,
          },
          "on_date" : {
              required : true,
          },
          "on_time" : {
              required : true,
          }
      },
      messages :{
          "attendanceStatus" : {
              required : 'Please select status.'
          },
          "on_date" : {
              required : 'Please enter date.'
          },
          "on_time" : {
              required : 'Please enter time.'
          }
      }
  });

});
</script>

<script type="text/javascript">
  var defYear = "{{$req['year']}}";
  var defMonth = "{{$req['month']}}";

  if(defYear != '0'){
    $('#year').val(defYear);
  }

  if(defMonth != '0'){
    $('#month').val(defMonth);
  }
    
  $(".eye-tooltip").on('click',function(){
    var date = $(this).data('date');
    var user_id = $(this).data('userid');

    $(".append-punches").empty("");
    var info = "";

    var params = '?id='+user_id+'&date='+date;
    var mapUrl = "{{url('attendances/view-map')}}" + params;

    $.ajax({
      type: 'POST',
      url: '{{url("/attendances/multiple-punches")}}',
      data: {date: date, user_id: user_id},
      success: function(result){
        result.forEach(function(item, index){
          if(index % 2 == 0){
            info += '<div><button type="button" class="btn modal-check-in">'+item.on_time;
          }else{
            info += '<div><button type="button" class="btn modal-check-out">'+item.on_time;
          }

          if(item.punched_by == 0){
            info += ' (Biometric)</button>';
          }else if(item.punched_by == user_id){
            info += ' (App)</button>';
          }else if(item.punched_by != user_id){
            info += ' (Verifier)</button>';
          }

          if(item.type == 'Check-In'){
            info += '<a href="'+mapUrl+'" target="_blank"><span class="label label-warning"> Check-In  &nbsp;<i class="fa fa-map-marker" aria-hidden="true"></i></span></a></div>';
          }else if(item.type == 'Check-Out'){
            info += '<a href="'+mapUrl+'" target="_blank"><span class="label label-danger"> Check-Out  &nbsp;<i class="fa fa-map-marker" aria-hidden="true"></i></span></a></div>';
          }else{
            info += '</div>';
          }
        });

        date = new Date(date);
        date = moment(date).format('DD-MM-YYYY');
        $(".multiple-in-outs").text(date);
        $(".append-punches").append(info);
      }
    });

    $("#modal-in-outs").modal('show');
  });


  $(".edit-tooltip").on('click',function(){
    var date = $(this).data('date');
    var user_id = $(this).data('userid');
    var remarks = $(this).data('remarks');

    $('#on_date').val(date);
    $('#remarks').val(remarks);
    var url = window.location.href;
    $("#url").val(url);

    date = new Date(date);
    date = moment(date).format('DD-MM-YYYY');
    $(".user-remarks").text(date);

    $("#modal-remarks").modal('show');
  });

  // $(".status-tooltip").on('click',function(){
  //   var date = $(this).data('date');
  //   var user_id = $(this).data('userid');
  //   var status = $(this).data('status');

  //   $("#change_on_date").val(date);
    
  //   if(status){
  //     if(status == 'Absent'){
  //       $(".change_on_time").hide();
  //     }else if(status == 'Present'){
  //       $(".change_on_time").show();
  //     }

  //     $("#attendanceStatus").val(status);
  //   }

  //   var url = window.location.href;
  //   $("#change_url").val(url);

  //   $("#modal-changeStatus").modal('show');
  // });

  $("#attendanceStatus").on('change',function(){
    if($(this).val() == 'Absent'){
        $(".change_on_time").hide();
    }else if($(this).val() == 'Present'){
      $(".change_on_time").show();
    }
  });

  $(".verifyMonthAttendance").on('click',function(){

    var allowAttendanceVerification = "{{$allowAttendanceVerification}}";
    var user_id = $(this).data('userid');
    var manager_id = $(this).data('managerid');
    var on_date = $(this).data('ondate');

    if(allowAttendanceVerification == '0'){
      alert("One or more date(s) of the selected month do not have a status. Please check and add status first.");
      return false;
    }else{
          if(!confirm("Are you sure you want to verify the attendance of the selected month? Once it is verified you cannot change the attendance status.")){
            return false;
          }else{
            $.ajax({
              type: 'POST',
              url: "{{ url('attendances/verify-month-attendance') }}",
              data: {user_id: user_id, manager_id: manager_id, on_date: on_date},
              success: function(result){
                if(result.error){
                  alert(result.error);
                }else{
                  location.reload(true);
                }
              }
            });
          }        
    }
  });

  
</script>

@endsection