

<!DOCTYPE html>
<html>
<head>
    <title>{{@$mail_data['subject']}}</title>
</head>
<body>
<div class="container">
    <div class="d-flex justify-content-center h-100">
        <div class="card">
            <div class="card-header">
                <p>Hi, <strong>{{@$mail_data['fullname']}}</strong></p>
                <p>
                @php    
                    echo @$mail_data['message'];
                @endphp    
                </p>
                <p>Thanks.</p>                
            </div>
            
        </div>
    </div>
</div>
</body>
</html>
