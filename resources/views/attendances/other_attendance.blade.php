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
              <form id="employee_Attendance">
                  <div class="row select-detail-below">
                      <div class="col-md-2 attendance-column1">
                        <label>Year<sup class="ast">*</sup></label>
                        <select class="form-control input-sm basic-detail-input-style" name="yearName">
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
                        <select class="form-control input-sm basic-detail-input-style" name="monthName">
                            <option value="" selected disabled>Please select Month</option>
                            <option value="Jan">Jan</option>
                            <option value="Feb">Feb</option>
                            <option value="Mar">Mar</option>
                            <option value="April">April</option>
                        </select>
                      </div>

                     <!--  <div class="col-md-2 attendance-column3">
                         <div class="form-group">
                             <label>Employee Name<sup class="ast">*</sup></label>
                             <input type="text" class="form-control input-sm basic-detail-input-style" name="employeeName" placeholder="Employee Name">
                         </div>
                     </div>
                     
                     <div class="col-md-2 attendance-column3">
                         <div class="form-group basic-detail-label">
                             <label>Department<sup class="ast">*</sup></label>
                             <select class="form-control input-sm basic-detail-input-style" name="departmentName">
                                 <option value="" selected disabled>Select department</option>
                                 <option value="Department 1">Department 1</option>
                                 <option value="Department 2">Department 2</option>
                                 <option value="Department 3">Department 3</option>
                                 <option value="Department 4">Department 4</option>
                             </select>
                         </div>
                     </div> -->

                      <!-- <div class="col-md-2 attendance-column3">
                          <label>Location<sup class="ast">*</sup></label>
                          <select class="form-control input-sm basic-detail-input-style">
                              <option value="Location 1">Location 1</option>
                              <option value="Location 2">Location 2</option>
                              <option value="Location 3">Location 3</option>
                              <option value="Location 4">Location 4</option>
                          </select>
                      </div> -->

                      

                      <div class="col-md-2 attendance-column4">
                          <div class="form-group">
                              <button type="submit" class="btn searchbtn-attendance">Search <i class="fa fa-search"></i></button>
                          </div>
                      </div>
                  </div>
              </form>
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
                  <span class="a-last-absent-span1">Last Absent:</span>
                  <span class="a-last-absent-span2">25 Days Ago</span>
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
                        <button type="button" class="fc-prev-button fc-button fc-state-default fc-corner-left" aria-label="prev"><span class="fc-icon fc-icon-left-single-arrow"></span></button>
                        <button type="button" class="fc-next-button fc-button fc-state-default fc-corner-right" aria-label="next"><span class="fc-icon fc-icon-right-single-arrow"></span></button>
                    </div>
                    <!-- <button type="button" class="fc-today-button fc-button fc-state-default fc-corner-left fc-corner-right fc-state-disabled" disabled="">today</button> -->
                </div>
                <div class="fc-center">
                    <h2>August 2019</h2></div>
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
                                    <div class="fc-scroller fc-day-grid-container" style="overflow: hidden; height: 576px;">
                                        <div class="fc-day-grid fc-unselectable">
                                            <div class="fc-row fc-week fc-widget-content" style="height: 96px;">
                                                <div class="fc-bg">
                                                    <table class="">
                                                        <tbody>
                                                            <tr>
                                                                <td class="fc-day fc-widget-content fc-sun fc-other-month fc-past" data-date="2019-07-28"></td>
                                                                <td class="fc-day fc-widget-content fc-mon fc-other-month fc-past" data-date="2019-07-29"></td>
                                                                <td class="fc-day fc-widget-content fc-tue fc-other-month fc-past" data-date="2019-07-30"></td>
                                                                <td class="fc-day fc-widget-content fc-wed fc-other-month fc-past" data-date="2019-07-31"></td>
                                                                <td class="fc-day fc-widget-content fc-thu fc-past" data-date="2019-08-01"></td>
                                                                <td class="fc-day fc-widget-content fc-fri fc-past" data-date="2019-08-02"></td>
                                                                <td class="fc-day fc-widget-content fc-sat fc-past" data-date="2019-08-03"></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="fc-content-skeleton">
                                                    <table>
                                                        <thead>
                                                            <tr>
                                                                <td class="fc-day-top fc-sun fc-other-month fc-past" data-date="2019-07-28">
                                                                  <span class="fc-day-number">28</span>
                                                                  <div class="three-icon-box">
	                                                                  <div class="info-tooltip">
	                                                                  	<i class="fa fa-info-circle a-icon1"></i>
																	   <span class="info-tooltiptext">Info about Day</span>
																	  </div>
																	  <div class="eye-tooltip">
	                                                                  	<i class="fa fa-eye a-icon2"></i>
																	   <span class="eye-tooltiptext">View In-Outs</span>
																	  </div>
																	  <div class="edit-tooltip">
	                                                                  	<i class="fa fa-edit a-icon3"></i>
																	   <span class="edit-tooltiptext">View Remarks</span>
																	  </div>
																	</div>
                                                                </td>
                                                                <td class="fc-day-top fc-mon fc-other-month fc-past" data-date="2019-07-29">
                                                                  <span class="fc-day-number">29</span>
                                                                  <div class="three-icon-box">
	                                                                  <div class="info-tooltip">
	                                                                  	<i class="fa fa-info-circle a-icon1"></i>
																	   <span class="info-tooltiptext">Info about Day</span>
																	  </div>
																	  <div class="eye-tooltip">
	                                                                  	<i class="fa fa-eye a-icon2"></i>
																	   <span class="eye-tooltiptext">View In-Outs</span>
																	  </div>
																	  <div class="edit-tooltip">
	                                                                  	<i class="fa fa-edit a-icon3"></i>
																	   <span class="edit-tooltiptext">View Remarks</span>
																	  </div>
																	</div>
                                                                </td>
                                                                <td class="fc-day-top fc-tue fc-other-month fc-past" data-date="2019-07-30">
                                                                  <span class="fc-day-number">30</span>
                                                                  <div class="three-icon-box">
	                                                                  <div class="info-tooltip">
	                                                                  	<i class="fa fa-info-circle a-icon1"></i>
																	   <span class="info-tooltiptext">Info about Day</span>
																	  </div>
																	  <div class="eye-tooltip">
	                                                                  	<i class="fa fa-eye a-icon2"></i>
																	   <span class="eye-tooltiptext">View In-Outs</span>
																	  </div>
																	  <div class="edit-tooltip">
	                                                                  	<i class="fa fa-edit a-icon3"></i>
																	   <span class="edit-tooltiptext">View Remarks</span>
																	  </div>
																	</div>
                                                                </td>
                                                                <td class="fc-day-top fc-wed fc-other-month fc-past" data-date="2019-07-31">
                                                                  <span class="fc-day-number">31</span>
                                                                  <div class="three-icon-box">
	                                                                  <div class="info-tooltip">
	                                                                  	<i class="fa fa-info-circle a-icon1"></i>
																	   <span class="info-tooltiptext">Info about Day</span>
																	  </div>
																	  <div class="eye-tooltip">
	                                                                  	<i class="fa fa-eye a-icon2"></i>
																	   <span class="eye-tooltiptext">View In-Outs</span>
																	  </div>
																	  <div class="edit-tooltip">
	                                                                  	<i class="fa fa-edit a-icon3"></i>
																	   <span class="edit-tooltiptext">View Remarks</span>
																	  </div>
																	</div>
                                                                </td>
                                                                <td class="fc-day-top fc-thu fc-past" data-date="2019-08-01">
                                                                  <span class="fc-day-number">1</span>
                                                                    <div class="three-icon-box">
	                                                                  <div class="info-tooltip">
	                                                                  	<i class="fa fa-info-circle a-icon1"></i>
																	   <span class="info-tooltiptext">Info about Day</span>
																	  </div>
																	  <div class="eye-tooltip">
	                                                                  	<i class="fa fa-eye a-icon2"></i>
																	   <span class="eye-tooltiptext">View In-Outs</span>
																	  </div>
																	  <div class="edit-tooltip">
	                                                                  	<i class="fa fa-edit a-icon3"></i>
																	   <span class="edit-tooltiptext">View Remarks</span>
																	  </div>
																	</div>
                                                                </td>
                                                                <td class="fc-day-top fc-fri fc-past" data-date="2019-08-02">
                                                                  <span class="fc-day-number">2</span>
                                                                  <div class="three-icon-box">
	                                                                  <div class="info-tooltip">
	                                                                  	<i class="fa fa-info-circle a-icon1"></i>
																	   <span class="info-tooltiptext">Info about Day</span>
																	  </div>
																	  <div class="eye-tooltip">
	                                                                  	<i class="fa fa-eye a-icon2"></i>
																	   <span class="eye-tooltiptext">View In-Outs</span>
																	  </div>
																	  <div class="edit-tooltip">
	                                                                  	<i class="fa fa-edit a-icon3"></i>
																	   <span class="edit-tooltiptext">View Remarks</span>
																	  </div>
																	</div>
                                                                </td>
                                                                <td class="fc-day-top fc-sat fc-past" data-date="2019-08-03">
                                                                  <span class="fc-day-number">3</span>
                                                                  <div class="three-icon-box">
	                                                                  <div class="info-tooltip">
	                                                                  	<i class="fa fa-info-circle a-icon1"></i>
																	   <span class="info-tooltiptext">Info about Day</span>
																	  </div>
																	  <div class="eye-tooltip">
	                                                                  	<i class="fa fa-eye a-icon2"></i>
																	   <span class="eye-tooltiptext">View In-Outs</span>
																	  </div>
																	  <div class="edit-tooltip">
	                                                                  	<i class="fa fa-edit a-icon3"></i>
																	   <span class="edit-tooltiptext">View Remarks</span>
																	  </div>
																	</div>
                                                                </td>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td class="fc-event-container">
                                                                    <a class="fc-day-grid-event fc-h-event fc-event fc-start fc-end fc-draggable calender-day-holiday">
                                                                        <div class="fc-content"><span class="fc-title">Holiday</span></div>
                                                                    </a>
                                                                </td>
                                                                <td class="fc-event-container">
                                                                    <a class="fc-day-grid-event fc-h-event fc-event fc-start fc-end fc-draggable calender-day-present">
                                                                        <div class="fc-content"><span class="fc-title">Present</span></div>
                                                                    </a>
                                                                    <a class="fc-day-grid-event fc-h-event fc-event fc-start fc-end fc-draggable calender-day-check-in">
                                                                        <div class="fc-content">
                                                                          <span class="fc-title">9:30am</span>
                                                                        </div>
                                                                    </a>
                                                                    <a class="fc-day-grid-event fc-h-event fc-event fc-start fc-end fc-draggable calender-day-check-out">
                                                                        <div class="fc-content">
                                                                          <span class="fc-title">6:30pm</span>
                                                                        </div>
                                                                    </a>
                                                                </td>
                                                                <td class="fc-event-container">
                                                                    <a class="fc-day-grid-event fc-h-event fc-event fc-start fc-end fc-draggable calender-day-absent">
                                                                        <div class="fc-content"><span class="fc-title">Absent</span></div>
                                                                    </a>
                                                                </td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="fc-row fc-week fc-widget-content" style="height: 96px;">
                                                <div class="fc-bg">
                                                    <table class="">
                                                        <tbody>
                                                            <tr>
                                                                <td class="fc-day fc-widget-content fc-sun fc-past" data-date="2019-08-04"></td>
                                                                <td class="fc-day fc-widget-content fc-mon fc-past" data-date="2019-08-05"></td>
                                                                <td class="fc-day fc-widget-content fc-tue fc-past" data-date="2019-08-06"></td>
                                                                <td class="fc-day fc-widget-content fc-wed fc-past" data-date="2019-08-07"></td>
                                                                <td class="fc-day fc-widget-content fc-thu fc-today " data-date="2019-08-08"></td>
                                                                <td class="fc-day fc-widget-content fc-fri fc-future" data-date="2019-08-09"></td>
                                                                <td class="fc-day fc-widget-content fc-sat fc-future" data-date="2019-08-10"></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="fc-content-skeleton">
                                                    <table>
                                                        <thead>
                                                            <tr>
                                                                <td class="fc-day-top fc-sun fc-past" data-date="2019-08-04">
                                                                  <span class="fc-day-number">4</span>
                                                                  <div class="three-icon-box">
	                                                                  <div class="info-tooltip">
	                                                                  	<i class="fa fa-info-circle a-icon1"></i>
																	   <span class="info-tooltiptext">Info about Day</span>
																	  </div>
																	  <div class="eye-tooltip">
	                                                                  	<i class="fa fa-eye a-icon2"></i>
																	   <span class="eye-tooltiptext">View In-Outs</span>
																	  </div>
																	  <div class="edit-tooltip">
	                                                                  	<i class="fa fa-edit a-icon3"></i>
																	   <span class="edit-tooltiptext">View Remarks</span>
																	  </div>
																	</div>
                                                                </td>
                                                                <td class="fc-day-top fc-mon fc-past" data-date="2019-08-05">
                                                                  <span class="fc-day-number">5</span>
                                                                  <div class="three-icon-box">
	                                                                  <div class="info-tooltip">
	                                                                  	<i class="fa fa-info-circle a-icon1"></i>
																	   <span class="info-tooltiptext">Info about Day</span>
																	  </div>
																	  <div class="eye-tooltip">
	                                                                  	<i class="fa fa-eye a-icon2"></i>
																	   <span class="eye-tooltiptext">View In-Outs</span>
																	  </div>
																	  <div class="edit-tooltip">
	                                                                  	<i class="fa fa-edit a-icon3"></i>
																	   <span class="edit-tooltiptext">View Remarks</span>
																	  </div>
																	</div>
                                                                </td>
                                                                <td class="fc-day-top fc-tue fc-past" data-date="2019-08-06">
                                                                  <span class="fc-day-number">6</span>
                                                                  <div class="three-icon-box">
	                                                                  <div class="info-tooltip">
	                                                                  	<i class="fa fa-info-circle a-icon1"></i>
																	   <span class="info-tooltiptext">Info about Day</span>
																	  </div>
																	  <div class="eye-tooltip">
	                                                                  	<i class="fa fa-eye a-icon2"></i>
																	   <span class="eye-tooltiptext">View In-Outs</span>
																	  </div>
																	  <div class="edit-tooltip">
	                                                                  	<i class="fa fa-edit a-icon3"></i>
																	   <span class="edit-tooltiptext">View Remarks</span>
																	  </div>
																	</div>
                                                                </td>
                                                                <td class="fc-day-top fc-wed fc-past" data-date="2019-08-07">
                                                                  <span class="fc-day-number">7</span>
                                                                  <div class="three-icon-box">
	                                                                  <div class="info-tooltip">
	                                                                  	<i class="fa fa-info-circle a-icon1"></i>
																	   <span class="info-tooltiptext">Info about Day</span>
																	  </div>
																	  <div class="eye-tooltip">
	                                                                  	<i class="fa fa-eye a-icon2"></i>
																	   <span class="eye-tooltiptext">View In-Outs</span>
																	  </div>
																	  <div class="edit-tooltip">
	                                                                  	<i class="fa fa-edit a-icon3"></i>
																	   <span class="edit-tooltiptext">View Remarks</span>
																	  </div>
																	</div>
                                                                </td>
                                                                <td class="fc-day-top fc-thu fc-today " data-date="2019-08-08">
                                                                  <span class="fc-day-number">8</span>
                                                                  <div class="three-icon-box">
	                                                                  <div class="info-tooltip">
	                                                                  	<i class="fa fa-info-circle a-icon1"></i>
																	   <span class="info-tooltiptext">Info about Day</span>
																	  </div>
																	  <div class="eye-tooltip">
	                                                                  	<i class="fa fa-eye a-icon2"></i>
																	   <span class="eye-tooltiptext">View In-Outs</span>
																	  </div>
																	  <div class="edit-tooltip">
	                                                                  	<i class="fa fa-edit a-icon3"></i>
																	   <span class="edit-tooltiptext">View Remarks</span>
																	  </div>
																	</div>
                                                                </td>
                                                                <td class="fc-day-top fc-fri fc-future" data-date="2019-08-09">
                                                                  <span class="fc-day-number">9</span>
                                                                  <div class="three-icon-box">
	                                                                  <div class="info-tooltip">
	                                                                  	<i class="fa fa-info-circle a-icon1"></i>
																	   <span class="info-tooltiptext">Info about Day</span>
																	  </div>
																	  <div class="eye-tooltip">
	                                                                  	<i class="fa fa-eye a-icon2"></i>
																	   <span class="eye-tooltiptext">View In-Outs</span>
																	  </div>
																	  <div class="edit-tooltip">
	                                                                  	<i class="fa fa-edit a-icon3"></i>
																	   <span class="edit-tooltiptext">View Remarks</span>
																	  </div>
																	</div>
                                                                </td>
                                                                <td class="fc-day-top fc-sat fc-future" data-date="2019-08-10">
                                                                  <span class="fc-day-number">10</span>
                                                                  <div class="three-icon-box">
	                                                                  <div class="info-tooltip">
	                                                                  	<i class="fa fa-info-circle a-icon1"></i>
																	   <span class="info-tooltiptext">Info about Day</span>
																	  </div>
																	  <div class="eye-tooltip">
	                                                                  	<i class="fa fa-eye a-icon2"></i>
																	   <span class="eye-tooltiptext">View In-Outs</span>
																	  </div>
																	  <div class="edit-tooltip">
	                                                                  	<i class="fa fa-edit a-icon3"></i>
																	   <span class="edit-tooltiptext">View Remarks</span>
																	  </div>
																	</div>
                                                                </td>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td class="fc-event-container">
                                                                    <a class="fc-day-grid-event fc-h-event fc-event fc-start fc-end fc-draggable calender-day-present">
                                                                        <div class="fc-content"><span class="fc-title">Present</span></div>
                                                                    </a>
                                                                    <a class="fc-day-grid-event fc-h-event fc-event fc-start fc-end fc-draggable calender-day-check-in">
                                                                        <div class="fc-content"><span class="fc-title">9:30am</span></div>
                                                                    </a>
                                                                    <a class="fc-day-grid-event fc-h-event fc-event fc-start fc-end fc-draggable calender-day-check-out">
                                                                        <div class="fc-content"><span class="fc-title">6:30pm</span></div>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="fc-row fc-week fc-widget-content" style="height: 96px;">
                                                <div class="fc-bg">
                                                    <table class="">
                                                        <tbody>
                                                            <tr>
                                                                <td class="fc-day fc-widget-content fc-sun fc-future" data-date="2019-08-11"></td>
                                                                <td class="fc-day fc-widget-content fc-mon fc-future" data-date="2019-08-12"></td>
                                                                <td class="fc-day fc-widget-content fc-tue fc-future" data-date="2019-08-13"></td>
                                                                <td class="fc-day fc-widget-content fc-wed fc-future" data-date="2019-08-14"></td>
                                                                <td class="fc-day fc-widget-content fc-thu fc-future" data-date="2019-08-15"></td>
                                                                <td class="fc-day fc-widget-content fc-fri fc-future" data-date="2019-08-16"></td>
                                                                <td class="fc-day fc-widget-content fc-sat fc-future" data-date="2019-08-17"></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="fc-content-skeleton">
                                                    <table>
                                                        <thead>
                                                            <tr>
                                                                <td class="fc-day-top fc-sun fc-future" data-date="2019-08-11">
                                                                  <span class="fc-day-number">11</span>
                                                                  <div class="three-icon-box">
	                                                                  <div class="info-tooltip">
	                                                                  	<i class="fa fa-info-circle a-icon1"></i>
																	   <span class="info-tooltiptext">Info about Day</span>
																	  </div>
																	  <div class="eye-tooltip">
	                                                                  	<i class="fa fa-eye a-icon2"></i>
																	   <span class="eye-tooltiptext">View In-Outs</span>
																	  </div>
																	  <div class="edit-tooltip">
	                                                                  	<i class="fa fa-edit a-icon3"></i>
																	   <span class="edit-tooltiptext">View Remarks</span>
																	  </div>
																	</div>
                                                                </td>
                                                                <td class="fc-day-top fc-mon fc-future" data-date="2019-08-12">
                                                                  <span class="fc-day-number">12</span>
                                                                  <div class="three-icon-box">
	                                                                  <div class="info-tooltip">
	                                                                  	<i class="fa fa-info-circle a-icon1"></i>
																	   <span class="info-tooltiptext">Info about Day</span>
																	  </div>
																	  <div class="eye-tooltip">
	                                                                  	<i class="fa fa-eye a-icon2"></i>
																	   <span class="eye-tooltiptext">View In-Outs</span>
																	  </div>
																	  <div class="edit-tooltip">
	                                                                  	<i class="fa fa-edit a-icon3"></i>
																	   <span class="edit-tooltiptext">View Remarks</span>
																	  </div>
																	</div>
                                                                </td>
                                                                <td class="fc-day-top fc-tue fc-future" data-date="2019-08-13">
                                                                  <span class="fc-day-number">13</span>
                                                                  <div class="three-icon-box">
	                                                                  <div class="info-tooltip">
	                                                                  	<i class="fa fa-info-circle a-icon1"></i>
																	   <span class="info-tooltiptext">Info about Day</span>
																	  </div>
																	  <div class="eye-tooltip">
	                                                                  	<i class="fa fa-eye a-icon2"></i>
																	   <span class="eye-tooltiptext">View In-Outs</span>
																	  </div>
																	  <div class="edit-tooltip">
	                                                                  	<i class="fa fa-edit a-icon3"></i>
																	   <span class="edit-tooltiptext">View Remarks</span>
																	  </div>
																	</div>
                                                                </td>
                                                                <td class="fc-day-top fc-wed fc-future" data-date="2019-08-14">
                                                                  <span class="fc-day-number">14</span>
                                                                  <div class="three-icon-box">
	                                                                  <div class="info-tooltip">
	                                                                  	<i class="fa fa-info-circle a-icon1"></i>
																	   <span class="info-tooltiptext">Info about Day</span>
																	  </div>
																	  <div class="eye-tooltip">
	                                                                  	<i class="fa fa-eye a-icon2"></i>
																	   <span class="eye-tooltiptext">View In-Outs</span>
																	  </div>
																	  <div class="edit-tooltip">
	                                                                  	<i class="fa fa-edit a-icon3"></i>
																	   <span class="edit-tooltiptext">View Remarks</span>
																	  </div>
																	</div>
                                                                </td>
                                                                <td class="fc-day-top fc-thu fc-future" data-date="2019-08-15">
                                                                  <span class="fc-day-number">15</span>
                                                                  <div class="three-icon-box">
	                                                                  <div class="info-tooltip">
	                                                                  	<i class="fa fa-info-circle a-icon1"></i>
																	   <span class="info-tooltiptext">Info about Day</span>
																	  </div>
																	  <div class="eye-tooltip">
	                                                                  	<i class="fa fa-eye a-icon2"></i>
																	   <span class="eye-tooltiptext">View In-Outs</span>
																	  </div>
																	  <div class="edit-tooltip">
	                                                                  	<i class="fa fa-edit a-icon3"></i>
																	   <span class="edit-tooltiptext">View Remarks</span>
																	  </div>
																	</div>
                                                                </td>
                                                                <td class="fc-day-top fc-fri fc-future" data-date="2019-08-16">
                                                                  <span class="fc-day-number">16</span>
                                                                  <div class="three-icon-box">
	                                                                  <div class="info-tooltip">
	                                                                  	<i class="fa fa-info-circle a-icon1"></i>
																	   <span class="info-tooltiptext">Info about Day</span>
																	  </div>
																	  <div class="eye-tooltip">
	                                                                  	<i class="fa fa-eye a-icon2"></i>
																	   <span class="eye-tooltiptext">View In-Outs</span>
																	  </div>
																	  <div class="edit-tooltip">
	                                                                  	<i class="fa fa-edit a-icon3"></i>
																	   <span class="edit-tooltiptext">View Remarks</span>
																	  </div>
																	</div>
                                                                </td>
                                                                <td class="fc-day-top fc-sat fc-future" data-date="2019-08-17">
                                                                  <span class="fc-day-number">17</span>
                                                                  <div class="three-icon-box">
	                                                                  <div class="info-tooltip">
	                                                                  	<i class="fa fa-info-circle a-icon1"></i>
																	   <span class="info-tooltiptext">Info about Day</span>
																	  </div>
																	  <div class="eye-tooltip">
	                                                                  	<i class="fa fa-eye a-icon2"></i>
																	   <span class="eye-tooltiptext">View In-Outs</span>
																	  </div>
																	  <div class="edit-tooltip">
	                                                                  	<i class="fa fa-edit a-icon3"></i>
																	   <span class="edit-tooltiptext">View Remarks</span>
																	  </div>
																	</div>
                                                                </td>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="fc-row fc-week fc-widget-content" style="height: 96px;">
                                                <div class="fc-bg">
                                                    <table class="">
                                                        <tbody>
                                                            <tr>
                                                                <td class="fc-day fc-widget-content fc-sun fc-future" data-date="2019-08-18"></td>
                                                                <td class="fc-day fc-widget-content fc-mon fc-future" data-date="2019-08-19"></td>
                                                                <td class="fc-day fc-widget-content fc-tue fc-future" data-date="2019-08-20"></td>
                                                                <td class="fc-day fc-widget-content fc-wed fc-future" data-date="2019-08-21"></td>
                                                                <td class="fc-day fc-widget-content fc-thu fc-future" data-date="2019-08-22"></td>
                                                                <td class="fc-day fc-widget-content fc-fri fc-future" data-date="2019-08-23"></td>
                                                                <td class="fc-day fc-widget-content fc-sat fc-future" data-date="2019-08-24"></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="fc-content-skeleton">
                                                    <table>
                                                        <thead>
                                                            <tr>
                                                                <td class="fc-day-top fc-sun fc-future" data-date="2019-08-18">
                                                                  <span class="fc-day-number">18</span>
                                                                  <div class="three-icon-box">
	                                                                  <div class="info-tooltip">
	                                                                  	<i class="fa fa-info-circle a-icon1"></i>
																	   <span class="info-tooltiptext">Info about Day</span>
																	  </div>
																	  <div class="eye-tooltip">
	                                                                  	<i class="fa fa-eye a-icon2"></i>
																	   <span class="eye-tooltiptext">View In-Outs</span>
																	  </div>
																	  <div class="edit-tooltip">
	                                                                  	<i class="fa fa-edit a-icon3"></i>
																	   <span class="edit-tooltiptext">View Remarks</span>
																	  </div>
																	</div>
                                                                </td>
                                                                <td class="fc-day-top fc-mon fc-future" data-date="2019-08-19">
                                                                  <span class="fc-day-number">19</span>
                                                                  <div class="three-icon-box">
	                                                                  <div class="info-tooltip">
	                                                                  	<i class="fa fa-info-circle a-icon1"></i>
																	   <span class="info-tooltiptext">Info about Day</span>
																	  </div>
																	  <div class="eye-tooltip">
	                                                                  	<i class="fa fa-eye a-icon2"></i>
																	   <span class="eye-tooltiptext">View In-Outs</span>
																	  </div>
																	  <div class="edit-tooltip">
	                                                                  	<i class="fa fa-edit a-icon3"></i>
																	   <span class="edit-tooltiptext">View Remarks</span>
																	  </div>
																	</div>
                                                                </td>
                                                                <td class="fc-day-top fc-tue fc-future" data-date="2019-08-20">
                                                                  <span class="fc-day-number">20</span>
                                                                  <div class="three-icon-box">
	                                                                  <div class="info-tooltip">
	                                                                  	<i class="fa fa-info-circle a-icon1"></i>
																	   <span class="info-tooltiptext">Info about Day</span>
																	  </div>
																	  <div class="eye-tooltip">
	                                                                  	<i class="fa fa-eye a-icon2"></i>
																	   <span class="eye-tooltiptext">View In-Outs</span>
																	  </div>
																	  <div class="edit-tooltip">
	                                                                  	<i class="fa fa-edit a-icon3"></i>
																	   <span class="edit-tooltiptext">View Remarks</span>
																	  </div>
																	</div>
                                                                </td>
                                                                <td class="fc-day-top fc-wed fc-future" data-date="2019-08-21">
                                                                  <span class="fc-day-number">21</span>
                                                                  <div class="three-icon-box">
	                                                                  <div class="info-tooltip">
	                                                                  	<i class="fa fa-info-circle a-icon1"></i>
																	   <span class="info-tooltiptext">Info about Day</span>
																	  </div>
																	  <div class="eye-tooltip">
	                                                                  	<i class="fa fa-eye a-icon2"></i>
																	   <span class="eye-tooltiptext">View In-Outs</span>
																	  </div>
																	  <div class="edit-tooltip">
	                                                                  	<i class="fa fa-edit a-icon3"></i>
																	   <span class="edit-tooltiptext">View Remarks</span>
																	  </div>
																	</div>
                                                                </td>
                                                                <td class="fc-day-top fc-thu fc-future" data-date="2019-08-22">
                                                                  <span class="fc-day-number">22</span>
                                                                  <div class="three-icon-box">
	                                                                  <div class="info-tooltip">
	                                                                  	<i class="fa fa-info-circle a-icon1"></i>
																	   <span class="info-tooltiptext">Info about Day</span>
																	  </div>
																	  <div class="eye-tooltip">
	                                                                  	<i class="fa fa-eye a-icon2"></i>
																	   <span class="eye-tooltiptext">View In-Outs</span>
																	  </div>
																	  <div class="edit-tooltip">
	                                                                  	<i class="fa fa-edit a-icon3"></i>
																	   <span class="edit-tooltiptext">View Remarks</span>
																	  </div>
																	</div>
                                                                </td>
                                                                <td class="fc-day-top fc-fri fc-future" data-date="2019-08-23">
                                                                  <span class="fc-day-number">23</span>
                                                                  <div class="three-icon-box">
	                                                                  <div class="info-tooltip">
	                                                                  	<i class="fa fa-info-circle a-icon1"></i>
																	   <span class="info-tooltiptext">Info about Day</span>
																	  </div>
																	  <div class="eye-tooltip">
	                                                                  	<i class="fa fa-eye a-icon2"></i>
																	   <span class="eye-tooltiptext">View In-Outs</span>
																	  </div>
																	  <div class="edit-tooltip">
	                                                                  	<i class="fa fa-edit a-icon3"></i>
																	   <span class="edit-tooltiptext">View Remarks</span>
																	  </div>
																	</div>
                                                                </td>
                                                                <td class="fc-day-top fc-sat fc-future" data-date="2019-08-24">
                                                                  <span class="fc-day-number">24</span>
                                                                  <div class="three-icon-box">
	                                                                  <div class="info-tooltip">
	                                                                  	<i class="fa fa-info-circle a-icon1"></i>
																	   <span class="info-tooltiptext">Info about Day</span>
																	  </div>
																	  <div class="eye-tooltip">
	                                                                  	<i class="fa fa-eye a-icon2"></i>
																	   <span class="eye-tooltiptext">View In-Outs</span>
																	  </div>
																	  <div class="edit-tooltip">
	                                                                  	<i class="fa fa-edit a-icon3"></i>
																	   <span class="edit-tooltiptext">View Remarks</span>
																	  </div>
																	</div>
                                                                </td>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="fc-row fc-week fc-widget-content" style="height: 96px;">
                                                <div class="fc-bg">
                                                    <table class="">
                                                        <tbody>
                                                            <tr>
                                                                <td class="fc-day fc-widget-content fc-sun fc-future" data-date="2019-08-25"></td>
                                                                <td class="fc-day fc-widget-content fc-mon fc-future" data-date="2019-08-26"></td>
                                                                <td class="fc-day fc-widget-content fc-tue fc-future" data-date="2019-08-27"></td>
                                                                <td class="fc-day fc-widget-content fc-wed fc-future" data-date="2019-08-28"></td>
                                                                <td class="fc-day fc-widget-content fc-thu fc-future" data-date="2019-08-29"></td>
                                                                <td class="fc-day fc-widget-content fc-fri fc-future" data-date="2019-08-30"></td>
                                                                <td class="fc-day fc-widget-content fc-sat fc-future" data-date="2019-08-31"></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="fc-content-skeleton">
                                                    <table>
                                                        <thead>
                                                            <tr>
                                                                <td class="fc-day-top fc-sun fc-future" data-date="2019-08-25">
                                                                  <span class="fc-day-number">25</span>
                                                                  <div class="three-icon-box">
	                                                                  <div class="info-tooltip">
	                                                                  	<i class="fa fa-info-circle a-icon1"></i>
																	   <span class="info-tooltiptext">Info about Day</span>
																	  </div>
																	  <div class="eye-tooltip">
	                                                                  	<i class="fa fa-eye a-icon2"></i>
																	   <span class="eye-tooltiptext">View In-Outs</span>
																	  </div>
																	  <div class="edit-tooltip">
	                                                                  	<i class="fa fa-edit a-icon3"></i>
																	   <span class="edit-tooltiptext">View Remarks</span>
																	  </div>
																	</div>
                                                                </td>
                                                                <td class="fc-day-top fc-mon fc-future" data-date="2019-08-26">
                                                                  <span class="fc-day-number">26</span>
                                                                  <div class="three-icon-box">
	                                                                  <div class="info-tooltip">
	                                                                  	<i class="fa fa-info-circle a-icon1"></i>
																	   <span class="info-tooltiptext">Info about Day</span>
																	  </div>
																	  <div class="eye-tooltip">
	                                                                  	<i class="fa fa-eye a-icon2"></i>
																	   <span class="eye-tooltiptext">View In-Outs</span>
																	  </div>
																	  <div class="edit-tooltip">
	                                                                  	<i class="fa fa-edit a-icon3"></i>
																	   <span class="edit-tooltiptext">View Remarks</span>
																	  </div>
																	</div>
                                                                </td>
                                                                <td class="fc-day-top fc-tue fc-future" data-date="2019-08-27">
                                                                  <span class="fc-day-number">27</span>
                                                                  <div class="three-icon-box">
	                                                                  <div class="info-tooltip">
	                                                                  	<i class="fa fa-info-circle a-icon1"></i>
																	   <span class="info-tooltiptext">Info about Day</span>
																	  </div>
																	  <div class="eye-tooltip">
	                                                                  	<i class="fa fa-eye a-icon2"></i>
																	   <span class="eye-tooltiptext">View In-Outs</span>
																	  </div>
																	  <div class="edit-tooltip">
	                                                                  	<i class="fa fa-edit a-icon3"></i>
																	   <span class="edit-tooltiptext">View Remarks</span>
																	  </div>
																	</div>
                                                                </td>
                                                                <td class="fc-day-top fc-wed fc-future" data-date="2019-08-28">
                                                                  <span class="fc-day-number">28</span>
                                                                  <div class="three-icon-box">
	                                                                  <div class="info-tooltip">
	                                                                  	<i class="fa fa-info-circle a-icon1"></i>
																	   <span class="info-tooltiptext">Info about Day</span>
																	  </div>
																	  <div class="eye-tooltip">
	                                                                  	<i class="fa fa-eye a-icon2"></i>
																	   <span class="eye-tooltiptext">View In-Outs</span>
																	  </div>
																	  <div class="edit-tooltip">
	                                                                  	<i class="fa fa-edit a-icon3"></i>
																	   <span class="edit-tooltiptext">View Remarks</span>
																	  </div>
																	</div>
                                                                </td>
                                                                <td class="fc-day-top fc-thu fc-future" data-date="2019-08-29">
                                                                  <span class="fc-day-number">29</span>
                                                                  <div class="three-icon-box">
	                                                                  <div class="info-tooltip">
	                                                                  	<i class="fa fa-info-circle a-icon1"></i>
																	   <span class="info-tooltiptext">Info about Day</span>
																	  </div>
																	  <div class="eye-tooltip">
	                                                                  	<i class="fa fa-eye a-icon2"></i>
																	   <span class="eye-tooltiptext">View In-Outs</span>
																	  </div>
																	  <div class="edit-tooltip">
	                                                                  	<i class="fa fa-edit a-icon3"></i>
																	   <span class="edit-tooltiptext">View Remarks</span>
																	  </div>
																	</div>
                                                                </td>
                                                                <td class="fc-day-top fc-fri fc-future" data-date="2019-08-30">
                                                                  <span class="fc-day-number">30</span>
                                                                  <div class="three-icon-box">
	                                                                  <div class="info-tooltip">
	                                                                  	<i class="fa fa-info-circle a-icon1"></i>
																	   <span class="info-tooltiptext">Info about Day</span>
																	  </div>
																	  <div class="eye-tooltip">
	                                                                  	<i class="fa fa-eye a-icon2"></i>
																	   <span class="eye-tooltiptext">View In-Outs</span>
																	  </div>
																	  <div class="edit-tooltip">
	                                                                  	<i class="fa fa-edit a-icon3"></i>
																	   <span class="edit-tooltiptext">View Remarks</span>
																	  </div>
																	</div>
                                                                </td>
                                                                <td class="fc-day-top fc-sat fc-future" data-date="2019-08-31">
                                                                  <span class="fc-day-number">31</span>
                                                                  <div class="three-icon-box">
	                                                                  <div class="info-tooltip">
	                                                                  	<i class="fa fa-info-circle a-icon1"></i>
																	   <span class="info-tooltiptext">Info about Day</span>
																	  </div>
																	  <div class="eye-tooltip">
	                                                                  	<i class="fa fa-eye a-icon2"></i>
																	   <span class="eye-tooltiptext">View In-Outs</span>
																	  </div>
																	  <div class="edit-tooltip">
	                                                                  	<i class="fa fa-edit a-icon3"></i>
																	   <span class="edit-tooltiptext">View Remarks</span>
																	  </div>
																	</div>
                                                                </td>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="fc-row fc-week fc-widget-content" style="height: 96px;">
                                                <div class="fc-bg">
                                                    <table class="">
                                                        <tbody>
                                                            <tr>
                                                                <td class="fc-day fc-widget-content fc-sun fc-other-month fc-future" data-date="2019-09-01"></td>
                                                                <td class="fc-day fc-widget-content fc-mon fc-other-month fc-future" data-date="2019-09-02"></td>
                                                                <td class="fc-day fc-widget-content fc-tue fc-other-month fc-future" data-date="2019-09-03"></td>
                                                                <td class="fc-day fc-widget-content fc-wed fc-other-month fc-future" data-date="2019-09-04"></td>
                                                                <td class="fc-day fc-widget-content fc-thu fc-other-month fc-future" data-date="2019-09-05"></td>
                                                                <td class="fc-day fc-widget-content fc-fri fc-other-month fc-future" data-date="2019-09-06"></td>
                                                                <td class="fc-day fc-widget-content fc-sat fc-other-month fc-future" data-date="2019-09-07"></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="fc-content-skeleton">
                                                    <table>
                                                        <thead>
                                                            <tr>
                                                                <td class="fc-day-top fc-sun fc-other-month fc-future" data-date="2019-09-01">
                                                                  <span class="fc-day-number">1</span>
                                                                  <div class="three-icon-box">
	                                                                  <div class="info-tooltip">
	                                                                  	<i class="fa fa-info-circle a-icon1"></i>
																	   <span class="info-tooltiptext">Info about Day</span>
																	  </div>
																	  <div class="eye-tooltip">
	                                                                  	<i class="fa fa-eye a-icon2"></i>
																	   <span class="eye-tooltiptext">View In-Outs</span>
																	  </div>
																	  <div class="edit-tooltip">
	                                                                  	<i class="fa fa-edit a-icon3"></i>
																	   <span class="edit-tooltiptext">View Remarks</span>
																	  </div>
																	</div>
                                                                </td>
                                                                <td class="fc-day-top fc-mon fc-other-month fc-future" data-date="2019-09-02">
                                                                  <span class="fc-day-number">2</span>
                                                                  <div class="three-icon-box">
	                                                                  <div class="info-tooltip">
	                                                                  	<i class="fa fa-info-circle a-icon1"></i>
																	   <span class="info-tooltiptext">Info about Day</span>
																	  </div>
																	  <div class="eye-tooltip">
	                                                                  	<i class="fa fa-eye a-icon2"></i>
																	   <span class="eye-tooltiptext">View In-Outs</span>
																	  </div>
																	  <div class="edit-tooltip">
	                                                                  	<i class="fa fa-edit a-icon3"></i>
																	   <span class="edit-tooltiptext">View Remarks</span>
																	  </div>
																	</div>
                                                                </td>
                                                                <td class="fc-day-top fc-tue fc-other-month fc-future" data-date="2019-09-03">
                                                                  <span class="fc-day-number">3</span>
                                                                  <div class="three-icon-box">
	                                                                  <div class="info-tooltip">
	                                                                  	<i class="fa fa-info-circle a-icon1"></i>
																	   <span class="info-tooltiptext">Info about Day</span>
																	  </div>
																	  <div class="eye-tooltip">
	                                                                  	<i class="fa fa-eye a-icon2"></i>
																	   <span class="eye-tooltiptext">View In-Outs</span>
																	  </div>
																	  <div class="edit-tooltip">
	                                                                  	<i class="fa fa-edit a-icon3"></i>
																	   <span class="edit-tooltiptext">View Remarks</span>
																	  </div>
																	</div>
                                                                </td>
                                                                <td class="fc-day-top fc-wed fc-other-month fc-future" data-date="2019-09-04">
                                                                  <span class="fc-day-number">4</span>
                                                                  <div class="three-icon-box">
	                                                                  <div class="info-tooltip">
	                                                                  	<i class="fa fa-info-circle a-icon1"></i>
																	   <span class="info-tooltiptext">Info about Day</span>
																	  </div>
																	  <div class="eye-tooltip">
	                                                                  	<i class="fa fa-eye a-icon2"></i>
																	   <span class="eye-tooltiptext">View In-Outs</span>
																	  </div>
																	  <div class="edit-tooltip">
	                                                                  	<i class="fa fa-edit a-icon3"></i>
																	   <span class="edit-tooltiptext">View Remarks</span>
																	  </div>
																	</div>
                                                                </td>
                                                                <td class="fc-day-top fc-thu fc-other-month fc-future" data-date="2019-09-05">
                                                                  <span class="fc-day-number">5</span>
                                                                  <div class="three-icon-box">
	                                                                  <div class="info-tooltip">
	                                                                  	<i class="fa fa-info-circle a-icon1"></i>
																	   <span class="info-tooltiptext">Info about Day</span>
																	  </div>
																	  <div class="eye-tooltip">
	                                                                  	<i class="fa fa-eye a-icon2"></i>
																	   <span class="eye-tooltiptext">View In-Outs</span>
																	  </div>
																	  <div class="edit-tooltip">
	                                                                  	<i class="fa fa-edit a-icon3"></i>
																	   <span class="edit-tooltiptext">View Remarks</span>
																	  </div>
																	</div>
                                                                </td>
                                                                <td class="fc-day-top fc-fri fc-other-month fc-future" data-date="2019-09-06">
                                                                  <span class="fc-day-number">6</span>
                                                                  <div class="three-icon-box">
	                                                                  <div class="info-tooltip">
	                                                                  	<i class="fa fa-info-circle a-icon1"></i>
																	   <span class="info-tooltiptext">Info about Day</span>
																	  </div>
																	  <div class="eye-tooltip">
	                                                                  	<i class="fa fa-eye a-icon2"></i>
																	   <span class="eye-tooltiptext">View In-Outs</span>
																	  </div>
																	  <div class="edit-tooltip">
	                                                                  	<i class="fa fa-edit a-icon3"></i>
																	   <span class="edit-tooltiptext">View Remarks</span>
																	  </div>
																	</div>
                                                                </td>
                                                                <td class="fc-day-top fc-sat fc-other-month fc-future" data-date="2019-09-07">
                                                                  <span class="fc-day-number">7</span>
                                                                  <div class="three-icon-box">
	                                                                  <div class="info-tooltip">
	                                                                  	<i class="fa fa-info-circle a-icon1"></i>
																	   <span class="info-tooltiptext">Info about Day</span>
																	  </div>
																	  <div class="eye-tooltip">
	                                                                  	<i class="fa fa-eye a-icon2"></i>
																	   <span class="eye-tooltiptext">View In-Outs</span>
																	  </div>
																	  <div class="edit-tooltip">
	                                                                  	<i class="fa fa-edit a-icon3"></i>
																	   <span class="edit-tooltiptext">View Remarks</span>
																	  </div>
																	</div>
                                                                </td>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
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
        <h4 class="modal-title text-center">Multiple In-Outs</h4>
      </div>
      <div class="modal-body attendance-present-modal">
        <p>Check from top to bottom order</p>
        <button type="button" class="btn modal-check-in">9:30am (In)</button>
        <button type="button" class="btn modal-check-out">1:30pm (Out)</button>
        <button type="button" class="btn modal-check-in">3:30pm (In)</button>
        <button type="button" class="btn modal-check-out">6:30pm (Out)</button>
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
        <h4 class="modal-title text-center">User's Remarks</h4>
      </div>
      <div class="modal-body">
        <p>Add Remark:</p>
        <textarea rows="2" cols="4" placeholder="Your remarks" class="add-remark-textarea"></textarea>
      </div>
      <div class="modal-footer in-out-footer">
        <input type="submit" name="saveRemarks" value="Save">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
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
          "yearName" : {
              required : true,
          },
          "monthName" : {
              required : true,
          },
          "employeeName":{
              required : true,
          },
          "departmentName":{
              required : true,
          }
      },
      messages :{
          "yearName" : {
              required : 'Please select Year.'
          },
          "monthName" : {
              required : 'Please select Month.'
          },
          "employeeName":{
              required : 'Please enter Employee Name.'
          },
          "departmentName":{
              required : 'Please enter Department Name.'
          }
      }
  });
});
</script>

<script type="text/javascript">
  $(".eye-tooltip").on('click',function(){
    $("#modal-in-outs").modal('show');
  });
  $(".edit-tooltip").on('click',function(){
    $("#modal-remarks").modal('show');
  });
</script>
<!-- <script src="{{asset('public/admin_assets/bower_components/fullcalendar/dist/fullcalendar.min.js')}}"></script>

  @endsection