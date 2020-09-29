<style type="text/css">

.form-gap {

    padding-top: 70px;

}



label.error{

    color: #f00;

}

</style>



<link rel="stylesheet" href="{{asset('public/admin_assets/bower_components/bootstrap/dist/css/bootstrap.min.css')}}">



<script src="{{asset('public/admin_assets/bower_components/jquery/dist/jquery.min.js')}}"></script>

<script src="{{asset('public/admin_assets/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>





<script src="{{asset('public/admin_assets/plugins/validations/jquery.validate.js')}}"></script>

<script src="{{asset('public/admin_assets/plugins/validations/additional-methods.js')}}"></script>

<!------ Include the above in your HEAD tag ---------->



 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">



<!DOCTYPE html>

<html>

<head>

    <title></title>

</head>

<body>

    <div class="form-gap">

        @if ($errors->any())

            <div class="alert alert-danger alert-dismissible">

              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

                <ul>

                    @foreach ($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        @endif



        @if(session()->has('password_error'))

          <div class="alert alert-danger alert-dismissible col-sm-9 col-sm-offset-2 text-center">

            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>

            {{ session()->get('password_error') }}

          </div>

        @endif

          

        @if(@$data['expire_status'] == "yes")

          <div class="alert alert-danger alert-dismissible col-sm-9 col-sm-offset-2 text-center">

            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>

            {{"Your reset password link has expired. Please send the email again."}}

          </div>

        @endif



    </div>

<div class="container">

    <div class="row">

        <div class="col-md-4 col-md-offset-4">

            <div class="panel panel-default">

              <div class="panel-body">

                <div>

                  <div class="text-center">

                    <h3><i class="fa fa-lock fa-4x"></i></h3>

                    <h2 class="text-center">Forgot Password?</h2>

                  </div>  

                  <div class="panel-body">

                  @if(@$data['expire_status'] == "no")

                    <form id="resetPasswordForm" action="{{ url('reset-password') }}" role="form" autocomplete="off" class="form" method="POST">

                    {{ csrf_field() }}

                    <div class="form-group">

                      <label for="newPassword">New Password</label>

                      <input type="password" class="form-control" id="newPassword" name="new_password" placeholder="New Password">

                    </div>



                    <div class="form-group">

                      <label for="confirmPassword">Confirm New Password</label>

                      <input type="password" class="form-control" id="confirmPassword" name="confirm_password" placeholder="Confirm Password">

                    </div>



                    <input type="hidden" name="forgot_token" id="forgotToken" value="{{@$data['token']}}">



                    <div class="form-group">

                        <input name="submit" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="submit">

                    </div>

                       

                    </form>

                  @endif

                  </div>

               </div>  

              </div>

            </div>

          </div>

    </div>

</div>

</body>

</html> 

 



<script>

    $("#resetPasswordForm").validate({

      rules :{

          "new_password" : {

              required : true,

              minlength : 6,

              maxlength: 20

          },

          "confirm_password" : {

              required : true,

              minlength : 6,

              maxlength: 20,

              equalTo: "#newPassword"

          }

      },

      messages :{

          "new_password" : {

              required : 'Please enter your new password.',

              maxlength: 'Maximum 20 characters are allowed.',

              minlength: 'Minimum 6 characters are allowed.'

          },

          "confirm_password" : {

              required : 'Please confirm your new password.',

              maxlength: 'Maximum 20 characters are allowed.',

              minlength: 'Minimum 6 characters are allowed.',

              equalTo: 'Confirmed password does not match the New password.'

          }

      }

    });

  </script>



<script type="text/javascript">

  $("div.alert-dismissible").fadeOut(7000);

  var expire_status = "{{$data['expire_status']}}";

  if(expire_status == "yes"){

    var url = "{{$data['url']}}";

    window.setTimeout(function() {

        window.location.href = url;

    }, 7000);

  }

</script>