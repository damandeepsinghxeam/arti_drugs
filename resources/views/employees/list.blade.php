@extends('admins.layouts.app')



@section('content')



<link rel="stylesheet" href="{{asset('public/admin_assets/plugins/dataTables/jquery.dataTables.min.css')}}">

<style>
  #filterFormSubmit {
    margin-top: 2%;
  }
</style>

<!-- Content Wrapper. Contains page content -->



  <div class="content-wrapper">



    <!-- Content Header (Page header) -->



    <section class="content-header">



      <h1>



        Employees List



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



              <h3 class="box-title">@can('create-employee')<a class="btn btn-info" href='{{ url("employees/create")}}'>Add</a>@endcan</h3>



            </div>



            <!-- /.box-header -->



            <div class="box-body">

            @if(auth()->user()->hasRole('MD') || auth()->user()->hasRole('AGM') || auth()->user()->id == 1)
            <form id="filterForm">
                <div class="form-group col-sm-3">
                  <label>Project</label>
                  <select class="form-control" name="project_id">
                    <option value="" selected disabled>Select Project</option>
                    <option value="All" @if($req['project_id'] == 'All'){{"selected"}}@endif>All</option>  
                  @foreach($projects as $key => $value)
                    <option value="{{$value->id}}" @if($req['project_id'] == $value->id){{"selected"}}@endif>{{$value->name}}</option>
                  @endforeach  
                  </select>
                </div>

                <div class="form-group col-sm-3">
                  <label>Department</label>
                  <select class="form-control" name="department_id">
                    <option value="" selected disabled>Select Department</option>
                    <option value="">None</option>
                  @foreach($departments as $key => $value)
                    <option value="{{$value->id}}" @if($req['department_id'] == $value->id){{"selected"}}@endif>{{$value->name}}</option>
                  @endforeach  
                  </select>
                </div>

              <button type="submit" class="btn btn-info" id="filterFormSubmit">Submit</button>
            </form>
            @endif

              <table id="employeesList" class="table table-bordered table-striped">



                <thead class="table-heading-style">



                <tr>



                  <th>S.No.</th>



                  <th>Xeam Code</th>



                  <th>Name</th>



                  <th>Mobile</th>



                  <th>Email</th>



                  <th>Approval Status</th>



                @can('edit-employee')



                  <th>Actions</th>



                  <th>Status</th>



                @endcan



                </tr>



                </thead>



                <tbody>



                @foreach($data as $key=>$employee)  



                <tr>



	                  <td>{{@$loop->iteration}}</td>



	                  <td>{{$employee->employee_code}}</td>



	                  <td>{{$employee->fullname}}</td>



	                  <td>{{$employee->mobile_number}}</td>



	                  <td>{{$employee->email}}</td>



                    <td>@if($employee->approval_status == '0')



                        <span class="label label-danger">Not Approved</span>



                        @else



                        <span class="label label-success">Approved</span>



                        @endif



                    </td>



                  @can('edit-employee')



	                  <td><a class="btn btn-success" target="_blank" href='{{ url("employees/edit/$employee->user_id")}}'>Edit</a> &nbsp;<a class="btn btn-primary" target="_blank" href='{{ url("employees/profile/$employee->user_id")}}'>View</a></td>



	                  <td>



	                        <div class="dropdown">



	                            @if($employee->isactive)



	                            <button class="btn btn-warning dropdown-toggle" type="button" data-toggle="dropdown">



	                             {{"Active"}}



	                            @else



	                            <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown">



	                             {{"Inactive"}}



	                            @endif



	                          <span class="caret"></span></button>



	                          <ul class="dropdown-menu">



	                            <li>



	                                @if($employee->isactive)



	                                  <a href='javascript:void(0)' class="statusEmp" data-employee="{{$employee->user_id}}" data-status="0">De-activate</a>



	                                @else



	                                   <a href='javascript:void(0)' class="statusEmp" data-employee="{{$employee->user_id}}" data-status="1">Activate</a>



	                                @endif



	                            </li>



	                            



	                          </ul>



	                        </div>



	                  </td>



	                @endcan



                </tr>



                @endforeach



                </tbody>



                <tfoot class="table-heading-style">



                <tr>



                  <th>S.No.</th>



                  <th>Xeam Code</th>



                  <th>Name</th>



                  <th>Mobile</th>



                  <th>Email</th>



                  <th>Approval Status</th>



                @can('edit-employee')



                  <th>Actions</th>



                  <th>Status</th>



                @endcan



                </tr>



                </tfoot>



              </table>



            </div>



            <!-- /.box-body -->



          </div>



          <!-- /.box -->



      </div>



      <!-- /.row -->



      <div class="modal fade" id="statusModal">



	      <div class="modal-dialog">



	        <div class="modal-content">



	          <div class="modal-header">



	            <button type="button" class="close" data-dismiss="modal" aria-label="Close">



	              <span aria-hidden="true">&times;</span></button>



	            <h4 class="modal-title">Default Modal</h4>



	          </div>



	          <div class="modal-body">



	            <form id="statusForm" action="{{url('employees/change-status')}}" method="POST">



		            {{ csrf_field() }}



		              <div class="box-body">



		                <div class="form-group">



		                  <label for="actionDate" class="actionDate"></label>



		                  <input type="date" class="form-control" id="actionDate" name="action_date">



		                </div>



		                <div class="form-group">



		                  <label for="description">Description</label>



		                  <input type="text" class="form-control" id="description" name="description">



		                </div>



                    <input type="hidden" name="action" id="modalAction">

                    <input type="hidden" name="user_id" id="modalUserId">

		                             

		              </div>



		              <!-- /.box-body -->



		              <div class="box-footer">



		                <button type="submit" class="btn btn-primary statusFormSubmit">Submit</button>



		              </div>



		        </form>



	          </div>



	          



	        </div>



	        <!-- /.modal-content -->



	      </div>



      <!-- /.modal-dialog -->



    	</div>



        <!-- /.modal -->



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