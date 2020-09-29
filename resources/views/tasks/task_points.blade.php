@extends('admins.layouts.app')

@section('content')

<link rel="stylesheet" href="{{asset('public/admin_assets/plugins/dataTables/jquery.dataTables.min.css')}}">

<style>
  #filterFormSubmit {
    margin-top: 2%;
  }
  .points_table_1 tr th {
    text-align: center;
    vertical-align: middle !important;
  }
  td > span.label {
    color: black;
    font-size: 0.9em;
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
</style>
<!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>

        Task Points System

        <!-- <small>Control panel</small> -->

      </h1>

      <ol class="breadcrumb">

        <li><a href="{{ url('employees/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>

      </ol>

    </section>



    <!-- Main content -->

    <section class="content">

      <!-- Small boxes (Stat box) -->

      <div class="row">

          <div class="box">

            <div class="box-header">

            </div>

            <!-- /.box-header -->

            <div class="box-body">

              <table id="employeesList" class="table table-bordered table-striped">

                <thead class="table-heading-style points_table_1">

                <tr>

                  <th>S.No.</th>

                  <th>Priority</th>

                  <th>Effective From</th>

                  <th>Max Limit</th>

                  <th>Weight</th>

                  <th>Danger Zone 1 days (after due-date)</th>

                  <th>Danger Zone 1 points (% of weight)</th>

                  <th>Danger Zone 2 days (after due-date)</th>

                  <th>Danger Zone 2 points (% of weight)</th>

                  <th>Danger Zone 3 points (% of weight)</th>

                </tr>

                </thead>

                <tbody class="text-center">

                @php
                $i=0;
                @endphp

                @foreach($data as $key=>$value) 
                @php
                $i++;
                @endphp 

                <tr>

	                  <td>{{@$loop->iteration}}</td>

	                  <td><span class="label label-h{{$i}}">{{$value->priority}}</span></td>

	                  <td>{{date("d/m/Y h:i A",strtotime($value->effective_from))}}</td>

	                  <td>{{$value->max_limit}}</td>

	                  <td>{{$value->weight}}</td>

	                  <td>{{$value->danger_zone1_days}}</td>

                    <td>{{$value->danger_zone1_points}} %</td>

	                  <td>{{$value->danger_zone2_days}}</td>

	                  <td>{{$value->danger_zone2_points}} %</td>

	                  <td>{{$value->danger_zone3_points}} %</td>

                </tr>

                @endforeach

                </tbody>

                <tfoot class="table-heading-style points_table_1">

                <tr>

                  <th>S.No.</th>

                  <th>Priority</th>

                  <th>Effective From</th>

                  <th>Max Limit</th>

                  <th>Weight</th>

                  <th>Danger Zone 1 days (after due-date)</th>

                  <th>Danger Zone 1 points (% of weight)</th>

                  <th>Danger Zone 2 days (after due-date)</th>

                  <th>Danger Zone 2 points (% of weight)</th>

                  <th>Danger Zone 3 points (% of weight)</th>

                </tr>

                </tfoot>

              </table>

            </div>

            <!-- /.box-body -->

          </div>

          <!-- /.box -->

      </div>

      <!-- /.row -->

      <!-- /.row (main row) -->



    </section>

    <!-- /.content -->

  </div>

  <!-- /.content-wrapper -->



  <script src="{{asset('public/admin_assets/plugins/dataTables/jquery.dataTables.min.js')}}"></script>

  <script type="text/javascript">

      $(document).ready(function() {

          $('.statusEmp').on('click',function(){

          	var employee = $(this).data("employee");

          	var status = $(this).data("status");

            $("#modalUserId").val(employee);

          	if(status == 0){

              $("#modalAction").val("deactivate");

          		// var redirect = "{{url('/employees/status/deactivate')}}" + '/' + employee;	

          		var modalTitle = "Deactivate Employee";

          		var actionDate = "Relieving Date";

          	}else{

              $("#modalAction").val("activate");

          		// var redirect = "{{url('/employees/status/activate')}}" + '/' + employee;

          		var modalTitle = "Activate Employee";

          		var actionDate = "Rejoining Date";

          	}

          	

          	//$('#statusForm').attr("action",redirect);

          	$('.modal-title').text(modalTitle);

          	$('.actionDate').text(actionDate);

          	$('#statusModal').modal('show');



          });

          $('#employeesList').DataTable({
            scrollX: true,
            responsive: true
          });

      });

  </script>



  <script src="{{asset('public/admin_assets/plugins/validations/jquery.validate.js')}}"></script>

  <script src="{{asset('public/admin_assets/plugins/validations/additional-methods.js')}}"></script>

  <script>

    $("#statusForm").validate({

      rules :{

          "action_date" : {

              required : true,

          },

          "description" : {

              required : true,

          }

      },

      messages :{

          "action_date" : {

              required : 'Please select a date.',

          },

          "description" : {

              required : "Please enter description.",

          }

      }

    });

  </script>

  @endsection