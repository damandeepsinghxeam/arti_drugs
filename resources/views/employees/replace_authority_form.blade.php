@extends('admins.layouts.app')

@section('content')

<!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>

        Replace Authority

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

        <div class="col-md-12">

        <div class="no-print">
          <div class="callout callout-info" style="margin-bottom: 5px!important;">
            <h4><i class="fa fa-info"></i> Note:</h4>
            Please be very careful while replacing the authorities.
          </div>
        </div>  

          <div class="box box-primary">
          @include('admins.validation_errors')

            <div class="box-body">

            <form id="replaceForm" method="POST" action="{{url('employees/replace-authority')}}">
              {{ csrf_field() }}
              <div class="row task-rows">
                <div class="col-md-6 task-columns">

                <label for="previous_user">Select Previous User</label>

                  <select class="form-control input-sm basic-detail-input-style select2 task-select2-only" name="previous_user">
                    <option value="" selected disabled>Please select a user</option>
                    @if(!$all_users->isEmpty())
                      @foreach($all_users as $employee)
                        <option value="{{$employee->user_id}}">{{$employee->fullname.' ('.$employee->user->employee_code.')'}}</option>
                      @endforeach
                    @endif

                  </select>
                </div>  
              </div> 
             

             <div class="row task-rows">

               <div class="col-md-6 task-columns">

                 <label for="authority">Authority</label>

                  <select class="form-control input-sm basic-detail-input-style select2 task-select2-only" name="authority" id="authority">
                    <option value="" selected disabled>Please select authority to replace</option>
                    <option value="SO1">Sanction Officer 1 (Manager)</option>
                    <option value="SO2">Sanction Officer 2 (HOD)</option>
                    <option value="SO3">Sanction Officer 3 (HR)</option>
                  </select>

               </div>

             </div>

             <div class="row task-rows">
                <div class="col-md-6 task-columns">

                <label for="new_user">Select New User</label>

                  <select class="form-control input-sm basic-detail-input-style select2 task-select2-only" name="new_user">
                    <option value="" selected disabled>Please select a user</option>
                    @if(!$active_users->isEmpty())
                      @foreach($active_users as $employee)
                        <option value="{{$employee->user_id}}">{{$employee->fullname.' ('.$employee->user->employee_code.')'}}</option>
                      @endforeach
                    @endif

                  </select>
                </div>  
              </div>


             <button type="submit" class="btn btn-primary" id="replaceFormSubmit">Submit</button>

            </form>

            </div>

            <!-- /.box-body -->

          </div>

          <!-- /.box -->

        </div>

      </div>

      <!-- /.row -->

    </section>

    <!-- /.content -->  
</div>
<!-- /.content-wrapper -->

<script src="{{asset('public/admin_assets/plugins/validations/jquery.validate.js')}}"></script>
<script src="{{asset('public/admin_assets/plugins/validations/additional-methods.js')}}"></script>

<script type="text/javascript">
$("#replaceForm").validate({
  rules :{
    "previous_user" : {
        required : true
    },
    "authority" : {
        required : true
    },
    "new_user" : {
        required : true
    },
  },
  errorPlacement: function(error, element) {
    if (element.hasClass('select2')) {
      error.insertAfter(element.next('span.select2'));
    } else {
      error.insertAfter(element);
    }
  },
  messages :{
    "previous_user" : {
        required : 'Please select a previous user.'
    },
    "authority" : {
        required : 'Please select an authority.'
    },
    "new_user" : {
        required : 'Please select a new user.'
    },
  }
});

</script>

@endsection