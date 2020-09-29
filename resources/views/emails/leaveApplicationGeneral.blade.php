

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
                <p>Hi, <strong>{{@$mailData['approverName']}}</strong></p>
                <p> 
                    @php    
                        echo @$mailData['message'];
                    @endphp
                </p>
                <p>Please respond within next 48 hours or else leave application will move to next level for approval.</p>
                
            </div>
            
        </div>
    </div>
</div>
</body>
</html>
