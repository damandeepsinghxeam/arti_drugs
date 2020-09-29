

<!DOCTYPE html>
<html>
<head>
    <title>{{@$mailData['subject']}}</title>
</head>
<body>
<div class="container">
    <div class="d-flex justify-content-center h-100">
        <div class="card">
            <div class="card-header">
                <p>Hi, <strong>{{@$mailData['fullName']}}</strong></p>
                <p>
                    @php    
                        echo @$mailData['message'];
                    @endphp
                </p>
                <p>Please approve it as soon as possible.</p>
                
            </div>
            
        </div>
    </div>
</div>
</body>
</html>
