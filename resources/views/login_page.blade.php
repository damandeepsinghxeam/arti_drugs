<style type="text/css">
    @import url('https://fonts.googleapis.com/css?family=Numans');

    html,body {
        background-image: url("{{config('constants.static.loginBg')}}");
        background-size: cover;
        background-repeat: no-repeat;
        height: 100%;
        font-family: 'Numans', sans-serif;
    }

    .container {
        height: 100%;
        align-content: center;
    }

    .card {
        height: 370px;
        margin-top: auto;
        margin-bottom: auto;
        width: 400px;
        background-color: rgba(0,0,0,0.5) !important;
    }

    .social_icon span {
        font-size: 60px;
        margin-left: 10px;
        color: #FFC312;
    }

    .social_icon span:hover {
        color: white;
        cursor: pointer;
    }

    .card-header h3 {
        color: white;
    }

    .social_icon {
        position: absolute;
        right: 20px;
        top: -45px;
    }

    .input-group-prepend span {
        width: 50px;
        background-color: #FFC312;
        color: black;
        border:0 !important;
    }

    input:focus {
        outline: 0 0 0 0  !important;
        box-shadow: 0 0 0 0 !important;
    }

    .remember {
        color: white;
    }

    .remember input {
        width: 20px;
        height: 20px;
        margin-left: 15px;
        margin-right: 5px;
    }

    .login_btn {
        color: black;
        background-color: #FFC312;
        width: 100px;
    }

    .login_btn:hover {
        color: black;
        background-color: white;
    }

    .links {
        color: white;
    }

    .links a {
        margin-left: 4px;
    }

    .blackstrp {
        background-color: black;
        position: fixed;
        bottom: 0px;
        right: 0;
        left: 0;
    }

    .blackstrp h4 {
        color: #169bba !important;
        text-transform: capitalize;
        text-align: center;
        letter-spacing: 5px;
        font-size: 18px;
        margin-bottom: 0px;
    }

    .blackstrp h3 {
        color: white;
        text-align: center;
        font-size: 20px;
        letter-spacing: 3px;
    }

    img.xeamlogo-img {
        width: 120px;
        position: absolute;
        left: 45%;
        top: 47px;
    }

    .xeam-version {
        position: absolute;
        top: 111px;
    }
</style>
<link href="{{asset('public/login_page/bootstrap.min.css')}}" rel="stylesheet" id="bootstrap-css">
<script src="{{asset('public/login_page/jquery.min.js')}}"></script>
<script src="{{asset('public/login_page/bootstrap.min.js')}}"></script>

<!------ Include the above in your HEAD tag ---------->
<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>
    <link rel="shortcut icon" type="image/png" href="{{asset('public/admin_assets/static_assets/arti_drug.jpg')}}">
   <!--Made with love by Mutiullah Samim -->
   <!--Bootsrap 4 CDN-->
   <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous"> -->
   <!--Fontawesome CDN-->
   <link rel="stylesheet" href="{{asset('public/login_page/all.css')}}">
</head>
<body style="background: url('data:image/jpeg;base64,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'); background-repeat: no-repeat; background-size: cover">
    <div class="container">
        <div class="d-flex justify-content-center h-100">
{{--            <img src="{{config('constants.static.xeamLogo')}}" class="xeamlogo-img">--}}
{{--            <span class="xeam-version">Arti Drugs Pvt Ltd.</span>--}}
            <div class="card">
                <div class="card-header">
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @elseif(session()->has('error_attempt'))
                        <div class="alert alert-info alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            {{ session()->get('error_attempt') }}
                        </div>
                    @endif
                    <h3>Sign In</h3>
                </div>

                <div class="card-body">
                    <form id="login_form" method="POST" action="{{ url('employees/login') }}">
                        {{ csrf_field() }}
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                            </div>
                            <input type="text" name="employee_code" id="employeeCode" class="form-control" placeholder="Employee Code">
                        </div>
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                            </div>
                            <input type="password" name="password" id="password" class="form-control" placeholder="password">
                        </div>

                        <div class="row align-items-center remember">
                            <input type="checkbox" name="remember_me">Remember Me
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Login" class="btn float-right login_btn">
                        </div>
                    </form>
                </div>

                <div class="card-footer">
                    <div class="d-flex justify-content-center">
                        <a href='{{url("forgot-password")}}'>Forgot your password?</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer>
        <div class="blackstrp">
            <h4>for more information please visit us at:</h4>
            <h3>www.xeamventures.com</h3>
        </div>
    </footer>
</body>
</html>
<script>
    $(".alert-dismissible").fadeOut(5000);
</script>
