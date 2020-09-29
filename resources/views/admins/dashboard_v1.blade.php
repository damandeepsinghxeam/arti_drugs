@extends('admins.layouts.app')



@section('content')

<link rel="stylesheet" href="{{asset('public/admin_assets/dist/css/mobiscroll.javascript.min.css')}}">

<script src="{{asset('public/admin_assets/dist/js/mobiscroll.javascript.min.js')}}"></script>

<!-- Content Wrapper. Contains page content -->

<style type="text/css">

	.text-muted {

    color: #000;

    font-weight: 700;

}

.profile-user-img {

    margin: 0 auto;

    width: 153px;

    padding: 3px;

    border: 3px solid #d2d6de;

    margin-bottom: 10px;

    margin-top: 45px;

}

.box.box-solid.bg-green-gradient {

    background: #00c0ef !important;

}

.datepicker .datepicker-switch:hover, .datepicker .next:hover, .datepicker .prev:hover, .datepicker tfoot tr th:hover {

    background: #f39c12 !important;

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

    height: 274px;

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



      <h1>



        Dashboard



        <small>Control panel</small>



      </h1>



      <ol class="breadcrumb">



        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>



        <li class="active">Dashboard</li>



      </ol>



    </section>







    <!-- Main content -->



    <section class="content">

    	<div class="row">

    		<div class="col-sm-12">

    			<div class="row">

    				<div class="col-sm-3 dashboardProfileCol">

    					<div class="dashboardProfile">

						<img class="profile-user-img img-responsive img-circle" src="{{asset('public/uploads/profile-pics/1567061400.png')}}" alt="User profile picture"> 

    						<p class="text-muted text-center">Main Administrator</p>

    					</div>

    					

    				</div>

    				<div class="col-sm-6">

    					<div class="box box-primary">

            				<div class="box-header ui-sortable-handle" style="cursor: move;">

              					<i class="ion ion-clipboard"></i>

              					<h3 class="box-title">To Do List</h3>

              					<div class="box-tools pull-right">

                					<ul class="pagination pagination-sm inline">

                  						<li><a href="#">«</a></li>

                  						<li><a href="#">1</a></li>

                  						<li><a href="#">2</a></li>

                  						<li><a href="#">3</a></li>

                  						<li><a href="#">»</a></li>

                					</ul>

              					</div>

            				</div>

            				<!-- /.box-header -->

            				<div class="box-body">

              				<!-- See dist/js/pages/dashboard.js to activate the todoList plugin -->

              					<ul class="todo-list ui-sortable">

                					<li class="">

                  					<!-- drag handle -->

                  						<span class="handle ui-sortable-handle">

                        					<i class="fa fa-ellipsis-v"></i>

                        					<i class="fa fa-ellipsis-v"></i>

                      					</span>

                  						<!-- checkbox -->

                  						<input type="checkbox" value="">

                  						<!-- todo text -->

                  						<span class="text">Design a nice theme</span>

                  						<!-- Emphasis label -->

                  						<small class="label label-danger"><i></i>Critical</small>

                  						<small class="label label-info"><i class="fa fa-clock-o"></i> 2 mint</small>

                					</li>

                					<li>

                    					<span class="handle ui-sortable-handle">

                        					<i class="fa fa-ellipsis-v"></i>

                        					<i class="fa fa-ellipsis-v"></i>

                    					</span>

                  						<input type="checkbox" value="">

                  						<span class="text">Make the theme responsive</span>

                  						<small class="label label-info"><i></i> Low</small>

                  						<small class="label label-info"><i class="fa fa-clock-o"></i> 2 mint</small>

                					</li>

                					<li>

                      					<span class="handle ui-sortable-handle">

                        					<i class="fa fa-ellipsis-v"></i>

                        					<i class="fa fa-ellipsis-v"></i>

                      					</span>

                  						<input type="checkbox" value="">

                  						<span class="text">Let theme shine like a star</span>

                  						<small class="label label-warning"><i></i> High</small>

                  						<small class="label label-info"><i class="fa fa-clock-o"></i> 2 mint</small>

                					</li>

                					<li>

                      					<span class="handle ui-sortable-handle">

                        					<i class="fa fa-ellipsis-v"></i>

                        					<i class="fa fa-ellipsis-v"></i>

                      					</span>

                  						<input type="checkbox" value="">

                  						<span class="text">Let theme shine like a star</span>

                  						<small class="label label-success"><i></i>Medium</small>

                  						<small class="label label-info"><i class="fa fa-clock-o"></i> 2 mint</small>

                					</li>

                					<li>

                      					<span class="handle ui-sortable-handle">

                        					<i class="fa fa-ellipsis-v"></i>

                        					<i class="fa fa-ellipsis-v"></i>

                      					</span>

                  						<input type="checkbox" value="">

                  						<span class="text">Let theme shine like a star</span>

                  						<small class="label label-warning"><i></i> High</small>

                  						<small class="label label-info"><i class="fa fa-clock-o"></i> 2 mint</small>

                					</li>

              					</ul>

            				</div>

            				<!-- /.box-body -->

          				</div>

    				</div>

            <div class="col-sm-3">

              <div class="small-box bg-yellow">

                    <div class="inner">

                        <h3>5</h3>

                        <p>Balance Leave</p>

                    </div>

                    <div class="icon">

                        <i class="fa fa-plane"></i>

                    </div>

                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>

                  </div>

            </div>

    				<div class="col-sm-3">

    					@can('approve-leave')

    					<div class="small-box bg-aqua">

            				<div class="inner">

              					<h3>0</h3>

              					<p>Pending Leave Approvals</p>

            				</div>

            				<div class="icon">

              					<i class="fa fa-plane"></i>

            				</div>

            				<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>

          				</div>

    				</div>

    				@endcan

    			</div>

   			</div>

   			<div class="col-sm-12">

		      <div class="col-sm-3">

		          <!-- Info Boxes Style 2 -->

		          <div class="box box-primary">

		            <div class="box-header with-border" id="upcomingEvents">

		              <h3 class="box-title">Upcoming Events / Alerts</h3>

		            </div>

		            <!-- /.box-header -->

		            <div class="box-body" style="">

		              <ul class="products-list product-list-in-box">

		                <li class="item">

		                  <div class="product-img">

		                    <img src="{{asset('public/uploads/dashboard/birthday.png')}}" alt="birthday Image">

		                  </div>

		                  <div class="product-info">

		                    <a href="javascript:void(0)" class="product-title">Happy Birthday</a>

		                    <span class="product-description">

		                          Pankaj Rawat

		                        </span>

		                  </div>

		                </li>

		                <!-- /.item -->

		                <li class="item">

		                  <div class="product-img">

		                    <img src="{{asset('public/uploads/dashboard/event.png')}}" alt="event Image">

		                  </div>

		                  <div class="product-info">

		                    <a href="javascript:void(0)" class="product-title">independence day celebration</a>

		                    <span class="product-description">

		                          Happy Independence day

		                        </span>

		                  </div>

		                </li>

		                <!-- /.item -->

		                <li class="item">

		                  <div class="product-img">

		                    <img src="{{asset('public/uploads/dashboard/holiday.png')}}" alt="holiday Image">

		                  </div>

		                  <div class="product-info">

		                    <a href="javascript:void(0)" class="product-title">Upcoming Holiday</a>

		                    <span class="product-description">

		                          2 oct. Gandhi Jayanti

		                        </span>

		                  </div>

		                </li>

		                <!-- /.item -->

		              </ul>

		            </div>

		            <!-- /.box-body -->

		            <!-- <div class="box-footer text-center" style="">

		              <a href="javascript:void(0)" class="uppercase">View All Events / Alerts</a>

		            </div> -->

		            <!-- /.box-footer -->

		          </div>

		      </div>

		      <div class="col-sm-6 eventCalendar">

   				<div class="box box-solid bg-green-gradient" style="position: relative;left: 0px;top: 0px;">

		            <div class="box-header ui-sortable-handle" style="cursor: move;">

		              <i class="fa fa-calendar"></i>



		              <h3 class="box-title">Calendar</h3>

		              <!-- tools box -->

		              <div class="pull-right box-tools">

		                <!-- button with a dropdown -->

		                <div class="btn-group">

		                  <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">

		                    <i class="fa fa-bars"></i></button>

		                  <ul class="dropdown-menu pull-right" role="menu">

		                    <li><a href="#">Add new Task</a></li>

		                    <li class="divider"></li>

		                    <li><a href="#">View calendar</a></li>

		                  </ul>

		                </div>

		              </div>

		              <!-- /. tools -->

		            </div>

		            <!-- /.box-header -->

		            <div class="box-body no-padding">

		              <!--The calendar -->

		              <div id="calendar" style="width: 100%"><div class="datepicker datepicker-inline"><div class="datepicker-days" style=""></div><div class="datepicker-months" style="display: none;"><table class="table-condensed"><thead><tr><th colspan="7" class="datepicker-title" style="display: none;"></th></tr><tr><th class="prev">«</th><th colspan="5" class="datepicker-switch">2019</th><th class="next">»</th></tr></thead><tbody><tr><td colspan="7"><span class="month">Jan</span><span class="month">Feb</span><span class="month">Mar</span><span class="month">Apr</span><span class="month">May</span><span class="month">Jun</span><span class="month">Jul</span><span class="month focused active">Aug</span><span class="month">Sep</span><span class="month">Oct</span><span class="month">Nov</span><span class="month">Dec</span></td></tr></tbody><tfoot><tr><th colspan="7" class="today" style="display: none;">Today</th></tr><tr><th colspan="7" class="clear" style="display: none;">Clear</th></tr></tfoot></table></div><div class="datepicker-years" style="display: none;"><table class="table-condensed"><thead><tr><th colspan="7" class="datepicker-title" style="display: none;"></th></tr><tr><th class="prev">«</th><th colspan="5" class="datepicker-switch">2010-2019</th><th class="next">»</th></tr></thead><tbody><tr><td colspan="7"><span class="year old">2009</span><span class="year">2010</span><span class="year">2011</span><span class="year">2012</span><span class="year">2013</span><span class="year">2014</span><span class="year">2015</span><span class="year">2016</span><span class="year">2017</span><span class="year">2018</span><span class="year active focused">2019</span><span class="year new">2020</span></td></tr></tbody><tfoot><tr><th colspan="7" class="today" style="display: none;">Today</th></tr><tr><th colspan="7" class="clear" style="display: none;">Clear</th></tr></tfoot></table></div><div class="datepicker-decades" style="display: none;"><table class="table-condensed"><thead><tr><th colspan="7" class="datepicker-title" style="display: none;"></th></tr><tr><th class="prev">«</th><th colspan="5" class="datepicker-switch">2000-2090</th><th class="next">»</th></tr></thead><tbody><tr><td colspan="7"><span class="decade old">1990</span><span class="decade">2000</span><span class="decade active focused">2010</span><span class="decade">2020</span><span class="decade">2030</span><span class="decade">2040</span><span class="decade">2050</span><span class="decade">2060</span><span class="decade">2070</span><span class="decade">2080</span><span class="decade">2090</span><span class="decade new">2100</span></td></tr></tbody><tfoot><tr><th colspan="7" class="today" style="display: none;">Today</th></tr><tr><th colspan="7" class="clear" style="display: none;">Clear</th></tr></tfoot></table></div><div class="datepicker-centuries" style="display: none;"><table class="table-condensed"><thead><tr><th colspan="7" class="datepicker-title" style="display: none;"></th></tr><tr><th class="prev">«</th><th colspan="5" class="datepicker-switch">2000-2900</th><th class="next">»</th></tr></thead><tbody><tr><td colspan="7"><span class="century old">1900</span><span class="century active focused">2000</span><span class="century">2100</span><span class="century">2200</span><span class="century">2300</span><span class="century">2400</span><span class="century">2500</span><span class="century">2600</span><span class="century">2700</span><span class="century">2800</span><span class="century">2900</span><span class="century new">3000</span></td></tr></tbody><tfoot><tr><th colspan="7" class="today" style="display: none;">Today</th></tr><tr><th colspan="7" class="clear" style="display: none;">Clear</th></tr></tfoot></table></div></div></div>

		            </div>

		            <!-- /.box-body -->

	            

	          </div>

   		</div>

      <div class="col-sm-3 attendanceCalendar">

      	<div mbsc-page class="demo-date-slider">

    <div id="demo" class="md-dateslider">

        <!-- <h4 style="text-align: center;">Check Your Atendance</h4> -->

        <!-- <h3 class="box-title">Check Your Atendance</h3> -->

        <div class="box-header with-border" id="upcomingEvents">

		              <h3 class="box-title">Check Your Atendance</h3>

		            </div>

        <div class="mbsc-padding md-header">

            <input type="text" name="checkIn" id="checkIn" class="checkIn"  style="border: 1px solid black;padding-left: 10px;border-radius: 5px; background-color:#eee;    height: 30px;margin-top: 4px;" readonly>

            <button style="font-size: 10px;width: 149px;">Check In</button>

        </div>

        <div class="mbsc-form-group-inset">

            <label>    

                <input id="slider" type="range" value="0" mobiscroll-slider="sliderSettings" data-step-labels="[0, 16.66, 33.32, 50, 66.64, 83.3, 100]" step="16.66" data-highlight="false" />

            </label>

        </div>

            <!-- <input type="text" name="checkIn" id="checkIn" class="checkIn">

            <input type="text" name="checkOut" id="checkOut" class="checkOut">

            <button>Check In</button> -->

        <div class="mbsc-padding">

            <div class="md-check-cont"><span class="md-check mbsc-ic mbsc-ic-material-check"></span></div>

            Your Attendance Status on

            <div><a href="" class="md-date">Feb 1</a> Absent</div>

        </div>

    

    </div>

</div>

      </div>

   	</div>

 		</div>

        

      	

    </section>



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