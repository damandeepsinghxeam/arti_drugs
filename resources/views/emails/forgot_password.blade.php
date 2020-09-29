

<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
</head>
<body>
<div class="container">
    <div class="d-flex justify-content-center h-100">
        <div class="card">
            <div class="card-header">

                <p>Thank you for using the product <strong>{{@$user_data->fullname}}</strong>.</p>
                <p>It seems like you have forgot your password. Please ignore this email if you have not opted for password reset.</p>
                <p>Please click on this <a href="{{$user_data->url}}">link</a> to reset your password.</p>
                
            </div>
            
        </div>
    </div>
</div>
</body>
</html>
