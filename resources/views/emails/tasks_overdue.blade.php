<h4>Here is a list of tasks that are overdue from your end :</h4>
<ol>
    @foreach($messages as $message)
        <li>{{$message}}</li>
    @endforeach
</ol>

            