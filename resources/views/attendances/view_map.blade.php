@extends('admins.layouts.app')

@section('content')

<link rel="stylesheet" href="{{asset('public/admin_assets/bower_components/fullcalendar/dist/fullcalendar.min.css')}}">
<link rel="stylesheet" href="{{asset('public/admin_assets/bower_components/fullcalendar/dist/fullcalendar.print.min.css')}}" media="print">

<style>
.box.box-primary #map {
    position: initial !important;
    width: 100%;
    height: 500px;
    transform: translateX(0%);
}
.content-box {
	padding: 15px;
}
.table {
    border: 1px solid #00728e;
    margin: 15px 0 0 0;
}
.table tr th, .table tr td {
    text-align: center;
}
</style>

<!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

	<!-- Content Header (Page header) -->
	<section class="content-header">
      <h1><i class="fa fa-map"></i> Attendance Locations</h1>
      <ol class="breadcrumb">
        <li><a href="{{url('employees/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
      </ol>
    </section>

    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-md-12">
	          <div class="box box-primary content-box">	
			    <!--The div element for the map -->
			    <div id="map"></div>

				<h3>{{ucwords($username)}} on {{date('d/m/Y', strtotime($date))}}</h3>	
				<!-- table Starts Here -->
				<table class="table table-responsive">
					<thead class="table-heading-style">
						<tr>
							<th>S.No.</th>
							<th>Type</th>
							<th>Time</th>
							<th>Comment</th>
							<th>Picture</th>
						</tr>
					</thead>
					<tbody>
					@foreach($attendance_locations as $key => $location)
						<tr>
							<td>{{$loop->iteration}}</td>
							<td>
								<span class="label label-@if(@$attendance->attendancePunches[$key]->type == 'Check-In'){{'success'}}@else{{'danger'}}@endif">@if(@$attendance->attendancePunches[$key]->type == 'Check-In'){{'Check-In'}}@else{{'Check-Out'}}@endif</span>
							</td>
							<td>{{date("h:i A", strtotime($location->created_at))}}</td>
							<td>{{$location->comment}}</td>
							<td><a target="_blank" href="{{config('constants.uploadPaths.attendancePic').$location->filename}}"><i class="fa fa-picture-o" aria-hidden="true"></i></a></td>
						</tr>
					@endforeach	
					</tbody>
				</table>
				<!-- table Ends Here -->

			    <!--Load the API from the specified URL
			    * The async attribute allows the browser to render the page while the API loads
			    * The key parameter will contain your own API key (which is not needed for this tutorial)
			    * The callback parameter executes the initMap() function
			    -->
			    <script
			    	src="https://maps.googleapis.com/maps/api/js?key=AIzaSyABRrVCGnFHr6UT-ZvJIDNXr2N1cOR6wgQ">
			    </script>

				<script>
					// Initialize and add the map
					var coordinates = @json($attendance_locations);
					var picUrl = "{{config('constants.uploadPaths.attendancePic')}}"; 
					
					var init = new google.maps.LatLng(22.9734, 78.6569);
					var mapOptions = {
						mapTypeId: 'roadmap',
						center: init,
						zoom: 4
					};
					var map = new google.maps.Map(document.getElementById("map"), mapOptions);
					coordinates.forEach((element, index) => {
						var id = 'location' + (index+1);
						var fullUrl = picUrl + element.filename;
						var myLatlng = new google.maps.LatLng(element.latitude, element.longitude);
						var marker = new google.maps.Marker({
							position: myLatlng,
							map: map,
							// id: id,
							// zIndex: 100,
						});
						// To add the marker to the map, call setMap();
						 
						google.maps.event.addListener(marker, 'mouseover', function(event) {
							this.setIcon(fullUrl);
						});

						google.maps.event.addListener(marker, 'mouseout', function(event) {
							this.setIcon('');
						});
					});
			    </script>
	          </div>
	      </div>
	  </div>
	</section>
  </div>
<!-- /.content-wrapper -->
@endsection