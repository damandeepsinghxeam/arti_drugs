@extends('admins.layouts.app')

@section('content')

<!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>
        Change Password 
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
          <div class="col-sm-10">
           <div class="box box-primary">

                @include('admins.validation_errors')

                @if(session()->has('password_success'))
                <br>
                  <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    {{ session()->get('password_success') }}
                  </div>
                @endif


                @if(session()->has('password_error'))
                <br>
                  <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    {{ session()->get('password_error') }}
                  </div>
                @endif

            <div class="box-header with-border">
              <h3 class="box-title">Form</h3>
            </div>

            <!-- /.box-header -->

            <!-- form start -->

            <form id="changePasswordForm" action="{{ url('employees/change-password') }}" method="POST">
              {{ csrf_field() }}
              
              <div class="box-body">

                <div class="form-group">
                  <label for="oldPassword">Old Password</label>
                  <input type="password" class="form-control" id="oldPassword" name="oldPassword" placeholder="Old Password">
                </div>

                <div class="form-group">
                  <label for="newPassword">New Password</label>
                  <input type="password" class="form-control" id="newPassword" name="newPassword" placeholder="New Password">
                </div>

                <div class="form-group">
                  <label for="confirmPassword">Confirm New Password</label>
                  <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password">
                </div>

              </div>

              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
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
    $("#changePasswordForm").validate({
      rules :{
          "oldPassword" : {
              required : true,
              minlength : 6,
              maxlength: 20
          },

          "newPassword" : {
              required : true,
              minlength : 6,
              maxlength: 20
          },

          "confirmPassword" : {
              required : true,
              minlength : 6,
              maxlength: 20,
              equalTo: "#newPassword"
          }
      },

      messages :{
          "oldPassword" : {
              required : 'Please enter your old password.',
              maxlength: 'Maximum 20 characters are allowed.',
              minlength: 'Minimum 6 characters are allowed.'
          },
          "newPassword" : {
              required : 'Please enter your new password.',
              maxlength: 'Maximum 20 characters are allowed.',
              minlength: 'Minimum 6 characters are allowed.'
          },
          "confirmPassword" : {
              required : 'Please confirm your new password.',
              maxlength: 'Maximum 20 characters are allowed.',
              minlength: 'Minimum 6 characters are allowed.',
              equalTo: 'Confirmed password does not match the New password.'
          }
      }
    });

  </script>

  @endsection