@extends('admins.layouts.app')

@section('style')
    <style>
        #document_form_3_table tr th,
        #document_form_3_table tr td { vertical-align: middle;}
    </style>

    <style type="text/css">
        /* Disables the selection */
.disableselect {
  -webkit-touch-callout: none; /* iOS Safari */
  -webkit-user-select: none;   /* Chrome/Safari/Opera */
  -khtml-user-select: none;    /* Konqueror */
  -moz-user-select: none;      /* Firefox */
  -ms-user-select: none;       /* Internet Explorer/Edge*/
   user-select: none;          /* Non-prefixed version, currently 
                                  not supported by any browser */
}

/* Disables the drag event 
(mostly used for images) */
.disabledrag{
   -webkit-user-drag: none;
  -khtml-user-drag: none;
  -moz-user-drag: none;
  -o-user-drag: none;
   user-drag: none;
}

    </style>
@endsection

@section('content')


    <!-- Content Wrapper Starts here -->
    <div class="content-wrapper">

        <!-- Content Header Starts here -->
        <section class="content-header">
            <h1>View Document</h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">View Document</li>
            </ol>
        </section>
        <!-- Content Header Eemailnds here -->

        <!-- Main content Starts here -->
        <section class="content">
            <div class="row">
                <p class oncopy="return false;" oncut="return false;" oncontextmenu="window.alert('Nice try! Even Ctrl+C or Ctrl+X will not work!');return false;"><iframe src='{{ url("public/uploads/document/".$document) }}' width="500" height="375"></i></p>


            </div>
        </section>
        <!-- Main content Ends Here-->
    </div>
    <!-- Content Wrapper Ends here -->
@endsection

<script type="text/javascript">

// To disable right click
document.addEventListener('contextmenu', event => event.preventDefault());

// To disable F12 options
document.onkeypress = function (event) {
    event = (event || window.event);
    if (event.keyCode == 123) {
        return false;
    }
}
document.onmousedown = function (event) {
    event = (event || window.event);
    if (event.keyCode == 123) {
        return false;
    }
}
document.onkeydown = function (event) {
    event = (event || window.event);
        if (event.keyCode == 123) {
    return false;
    }
}

// To Disable ctrl+c, ctrl+u

jQuery(document).ready(function(){
    alert("sssss");
    console.log("dddd");
    $(document).keydown(function(event) {
            console.log("dddd");

        var pressedKey = String.fromCharCode(event.keyCode).toLowerCase();

        if (event.ctrlKey && (pressedKey == "c" || pressedKey == "u")) {
        alert('Sorry, This Functionality Has Been Disabled!');
        //disable key press porcessing
        return false;
        }
    });
});


    </script>

@section('script')

@endsection

