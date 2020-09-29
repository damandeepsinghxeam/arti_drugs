 @if ($errors->any())

    <br>

    <div class="alert alert-danger alert-dismissible">

      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

        <ul>

            @foreach ($errors->all() as $error)

                <li>{{ $error }}</li>

            @endforeach

        </ul>

    </div>

@endif

@if(session()->has('error'))
    <div class="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    {{ session()->get('error') }}
    </div>

@elseif(session()->has('success'))
    <div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    {{ session()->get('success') }}
    </div>
@endif
