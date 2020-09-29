@extends('admins.layouts.app')

@section('content')


<!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->

    <section class="content-header">
      <h1>
        @if($data['action'] == "add")
        {{"Add Leave Authority"}}
        @endif

        <!-- <small>Control panel</small> -->

      </h1>

      <ol class="breadcrumb">
        <li><a href="{{ url('employees/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ url('mastertables/leave-authorities') }}">Leave Authorities List</a></li> 
      </ol>

    </section>


    <!-- Main content -->

    <section class="content">

      <!-- Small boxes (Stat box) -->

      <div class="row">

          <div class="col-sm-12">

           <div class="box box-primary">
                @include('admins.validation_errors')
            <div class="box-header with-border mastertables-heading">
              <h3 class="box-title">Form</h3>
            </div>

            <!-- /.box-header -->
            <!-- form start -->

            <form id="addDepartmentReportingHodForm" action="{{ url('mastertables/create-leave-authority') }}" method="POST">
              {{ csrf_field() }}

              <div class="box-body">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group add-editdepartment-form">
                        <div class="mastertbl-editdepart-lbl">
                            <label>Department</label>
                        </div>

                        <div class="mastertbl-editdepartment-input">
                            <select class="form-control checkUniqueDepartmentHodMain basic-detail-input-style" name="departmentId" id="departmentId">

                              <option value="" selected disabled>Please select a department</option>

                            @if(!$data['departments']->isEmpty())  
                              @foreach($data['departments'] as $department)  
                                <option value="{{$department->id}}">{{$department->name}}</option>
                              @endforeach
                            @endif

                            </select>
                        </div>
                      </div>

                      <div class="form-group add-editdepartment-form">
                        <div class="mastertbl-editdepart-lbl">
                            <label>Project</label>
                        </div>

                        <div class="mastertbl-editdepartment-input">
                            <select class="form-control checkUniqueDepartmentHodMain basic-detail-input-style" name="projectId" id="projectId">

                              <option value="" selected disabled>Please select a project</option>

                            @if(!$data['projects']->isEmpty())  
                              @foreach($data['projects'] as $project)  
                                <option value="{{$project->id}}">{{$project->name}}</option>
                              @endforeach
                            @endif

                            </select>
                        </div>
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="form-group add-editdepartment-form">
                        <div class="mastertbl-editdepart-lbl">
                            <label>Priority</label>
                        </div>

                        <div class="mastertbl-editdepartment-input">
                            <select class="form-control checkUniqueDepartmentHodMain basic-detail-input-style" name="priority" id="priority">  

                              <option value="" selected disabled>Please select a priority</option>
                              <option value="2">HOD</option>
                              <option value="3">HR</option>
                              <option value="4">MD</option>

                            </select>

                            <span class="mainAuthorityErrors"></span>
                        </div>
                      </div>


                      <div class="form-group add-editdepartment-form">
                        <div class="mastertbl-editdepart-lbl">
                            <label>Main Authority</label>
                        </div>

                        <div class="mastertbl-editdepartment-input">

                            <select class="form-control mainAuthority checkUniqueDepartmentHodMain basic-detail-input-style" name="mainAuthority" id="mainAuthority">  

                              <option value="" selected disabled>Please select an employee</option>

                              @if(!$data['employees']->isEmpty())  
                                @foreach($data['employees'] as $employee)  
                                  <option value="{{$employee->user_id}}">{{$employee->fullname}}</option>
                                @endforeach
                              @endif

                            </select>

                        </div>

                      </div>


                      <div class="form-group add-editdepartment-form">
                        <div class="mastertbl-editdepart-lbl">
                            <label>Sub Authorities</label>
                        </div>

                        <div class="mastertbl-editdepartment-input">

                            <select class="form-control select2 subAuthorities basic-detail-input-style" name="subAuthorities[]" id="subAuthorities" multiple="multiple" style="width:100%;">  

                              @if(!$data['employees']->isEmpty())  
                                @foreach($data['employees'] as $employee)  
                                  <option value="{{$employee->user_id}}">{{$employee->fullname}}</option>
                                @endforeach
                              @endif

                            </select>

                        </div>
                      </div>
                    </div>
                  </div>

                <input type="hidden" name="action" value="{{$data['action']}}">

              </div>

              <!-- /.box-body -->

              <div class="box-footer">
                <button type="button" class="btn btn-primary" id="addDepartmentReportingHodFormSubmit">Submit</button>
              </div>

            </form>
          </div>
      </div>

          <!-- /.box -->
      </div>

      <!-- /.row -->
      <!-- Main row -->

    </section>

    <!-- /.content -->

  </div>

  <!-- /.content-wrapper -->

  <script src="{{asset('public/admin_assets/plugins/validations/jquery.validate.js')}}"></script>
  <script src="{{asset('public/admin_assets/plugins/validations/additional-methods.js')}}"></script>

  <script>

    var allowFormSubmit = {mainAuthority: 1};

    $("#addDepartmentReportingHodForm").validate({

      rules :{

          "departmentId" : {

              required : true

          },

          "projectId" : {

              required : true

          },

          "priority" : {

              required : true

          },

          "mainAuthority" : {

              required : true

          }

      },

      messages :{

          "departmentId" : {

              required : 'Please select a department.',

          },

          "projectId" : {

              required : 'Please select a project.',

          },

          "priority" : {

              required : 'Please select a priority.',

          },

          "mainAuthority" : {

              required : 'Please select a main authority.',

          }

      }

    });

  </script>



  <script type="text/javascript">

    $(".mainAuthority").on("click",function(){

      var employeeId = $(this).val();

      var employees = $("#subAuthorities").val();



      var present = $.inArray(employeeId, employees);

      if(present == '-1'){

        console.log("no");

      }else{

        alert("Same employee should not be selected in both.");

        present = parseInt(present);

        employee = employees[present];

        $("#subAuthorities option[value='"+ employee + "']").prop('selected',false);

        $('#subAuthorities').trigger('change.select2');

      }

    });



    $(".select2").on("change",function(){

      var employees = $("#subAuthorities").val();

      var employeeId = $("#mainAuthority").val();



      var present = $.inArray(employeeId, employees);

      if(present == '-1'){

        console.log("no");

      }else{

        alert("Same employee should not be selected in both.");

        console.log("yes");

        present = parseInt(present);

        employee = employees[present];

        $("#subAuthorities option[value='"+ employee + "']").prop('selected',false);

        $('#subAuthorities').trigger('change.select2');

      }



    });



    $(".checkUniqueDepartmentHodMain").on("click",function(){

      var departmentId = $("#departmentId").val();
      var projectId = $("#projectId").val();
      var priority = $("#priority").val();
      var employeeId = $("#mainAuthority").val();

      $.ajax({
        type: 'POST',
        url: "{{ url('mastertables/check-unique-leave-authority') }}",
        data: {departmentId: departmentId,projectId: projectId,priority: priority},
        success: function (result) {

          if(result.allow_submit == "no" && result.message == '1'){
            allowFormSubmit.mainAuthority = 0;
            $(".mainAuthorityErrors").text("Main authority already exists for the selected options.").css("color","#f00");
            $(".mainAuthorityErrors").show();

          }else if(result.allow_submit == "no" && result.message == '2'){
            allowFormSubmit.mainAuthority = 0;

            $(".mainAuthorityErrors").text("Main authority and sub-authorities already exists for the selected options.").css("color","#f00");
            $(".mainAuthorityErrors").show();

          }else{

            allowFormSubmit.mainAuthority = 1;
            $(".mainAuthorityErrors").text("");
            $(".mainAuthorityErrors").hide();

          }

        }  

      });

    });



    $("#addDepartmentReportingHodFormSubmit").on("click",function(){

      if(allowFormSubmit.mainAuthority == 1){
        $("#addDepartmentReportingHodForm").submit();

      }else{
        return false;
      }

    });

  </script>

  @endsection