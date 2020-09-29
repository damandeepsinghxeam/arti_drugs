<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>ERP | PORTAL</title>
  <link rel="shortcut icon" type="image/png" href="{{asset('public/admin_assets/static_assets/arti_drug.jpg')}}">
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{asset('public/admin_assets/bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('public/admin_assets/bower_components/font-awesome/css/font-awesome.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{asset('public/admin_assets/bower_components/Ionicons/css/ionicons.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('public/admin_assets/dist/css/AdminLTE.css')}}">
  <link rel="stylesheet" href="{{asset('public/admin_assets/dist/css/customStyle.css')}}">
  <!-- AdminLTE Skins. Choose a skin from the css/skins folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{asset('public/admin_assets/dist/css/skins/_all-skins.min.css')}}">
  <!-- Morris chart -->
  <!-- <link rel="stylesheet" href="{{asset('public/admin_assets/bower_components/morris.js/morris.css')}}">-->
  <!-- jvectormap -->
  <link rel="stylesheet" href="{{asset('public/admin_assets/bower_components/jvectormap/jquery-jvectormap.css')}}">
  <!-- Date Picker -->
  <link rel="stylesheet" href="{{asset('public/admin_assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{asset('public/admin_assets/bower_components/bootstrap-daterangepicker/daterangepicker.css')}}">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="{{asset('public/admin_assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')}}">
  <!-- Select2 -->
  <link rel="stylesheet" href="{{asset('public/admin_assets/bower_components/select2/dist/css/select2.min.css')}}">
  <!-- jQuery 3 -->
<script src="{{asset('public/admin_assets/bower_components/jquery/dist/jquery.min.js')}}"></script>
<script src="{{asset('public/admin_assets/bower_components/moment/min/moment.min.js')}}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{asset('public/admin_assets/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<!-- datepicker -->
<script src="{{asset('public/admin_assets/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="{{asset('public/admin_assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')}}"></script>
<script type="text/javascript">
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
</script>

<?php
  // if(Request::segment(2) != 'projects'){
  //   session(['lastInsertedProject' => 0,'lastTabName' => '']);
  // }
  $usser = Auth::user();
  $staticPic = config('constants.static.profilePic');
  $userBasic = [
    'pic' => $staticPic,
    "fullName" => ""
  ];

  $messageIds = [];
  $notificationIds = [];
  $unread = 0;
  $unread2 = 0;

  if(!empty($usser)) {
    $user = getEmployeeProfileData($usser->id);

    if(!empty($user)) {
      $userBasic['fullName'] = $user->fullname;

      if(!empty($user->profile_picture)) {
        $userBasic['pic'] = config('constants.uploadPaths.profilePic').$user->profile_picture;
      }
    }
    $profilePicPath = config('constants.uploadPaths.profilePic');
    $usser->unreadMessages = getMyLimitedMessages($staticPic,$profilePicPath,$usser->id, 10);
    $usser->unreadNotifications = getMyLimitedNotifications($staticPic,$profilePicPath,$usser->id, 10);
  }
?>
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <!-- Google Font -->
  <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic"> -->
@yield('style')

</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
  <header class="main-header">
    <!-- Logo -->
    <a href="javascript:void(0)" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>A</b>LT</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg">
{{--        <img src="{{asset('public/admin_assets/static_assets/arti_drug.jpg')}}" alt="Xeam logo" width="75">--}}
          <h4>Arti Drugs</h4>
      </span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
          <li id="messages-menu" class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-envelope-o"></i>
              <span class="label label-success unreadMessagesCount">{{count(@$usser->unreadMessages)}}</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have <span class="unreadMessagesCount"></span> new message(s)</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  @if(!$usser->unreadMessages->isEmpty())
                    @foreach($usser->unreadMessages as $key => $value)
                      @php
                        $messageIds[] = $value->id;
                        if($value->read_status == 0) {
                          ++$unread;
                        }
                      @endphp
                      <li><!-- start message -->
                        <a href="#" class="cursorDefault">
                          <div class="pull-left">
                            <img src="{{$value->profile_pic}}" class="img-circle" alt="User Image">
                          </div>
                          <h5 title="{{$value->fullname}}">
                            {{substr($value->fullname,0,10)}}...&nbsp;&nbsp;
                            <small><i class="fa fa-clock-o"></i> {{$value->created_at}}</small>
                          </h5>
                          <p title="{{$value->message}}">
                            @if(strlen($value->message) > 25)
                              {{substr($value->message,0,25)}}...
                            @else
                              {{$value->message}}
                            @endif
                          </p>
                        </a>
                      </li>
                  <!-- end message -->
                    @endforeach
                  @endif
                </ul>
              </li>
              <li class="footer"><a href="{{url('employees/messages')}}">See All Messages</a></li>
            </ul>
          </li>
          <!-- Notifications: style can be found in dropdown.less -->
          <li id="notifications-menu" class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning unreadNotificationsCount"></span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have <span class="unreadNotificationsCount"></span> new notification(s)</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  @if(!$usser->unreadNotifications->isEmpty())
                    @foreach($usser->unreadNotifications as $key => $value)
                      @php
                        $notificationIds[] = $value->id;
                        if($value->read_status == 0) {
                          ++$unread2;
                        }
                      @endphp
                      <li><!-- start message -->
                        <a href="#" class="cursorDefault">
                          <div class="pull-left">
                            <img src="{{$value->profile_pic}}" class="img-circle" alt="User Image">
                          </div>
                          <h5 title="{{$value->fullname}}">
                            {{substr($value->fullname,0,10)}}...&nbsp;&nbsp;
                            <small><i class="fa fa-clock-o"></i> {{$value->created_at}}</small>
                          </h5>
                          <p title="{{$value->message}}">
                            @if(strlen($value->message) > 25)
                              {{substr($value->message,0,25)}}...
                            @else
                              {{$value->message}}
                            @endif
                          </p>
                        </a>
                      </li>
                    <!-- end message -->
                    @endforeach
                  @endif
                </ul>
              </li>
              <li class="footer"><a href="{{url('employees/notifications')}}">View all</a></li>
            </ul>
          </li>
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="{{@$userBasic['pic']}}" class="user-image" alt="User Image">
              <span class="hidden-xs">{{@$userBasic['fullName']}}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="{{@$userBasic['pic']}}" class="img-circle" alt="User Image">
                <p>
                  {{@$userBasic['fullName']}}
                  <!-- <small>Member since Nov. 2012</small> -->
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href='{{ url("employees/my-profile") }}' class="btn btn-success btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="{{ url('employees/logout') }}" class="btn btn-danger btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <script type="text/javascript">
    var unread = "{{$unread}}";
    $(".unreadMessagesCount").text(unread);

    $("#messages-menu").on('click',function() {
      var messageIds = "<?php echo json_encode($messageIds); ?>";
      messageIds = JSON.parse(messageIds);
      if(messageIds.length > 0) {
        $.ajax({
          type: 'POST',
          url: "{{url('employees/unread-messages')}}",
          data: {message_ids: messageIds},
          success: function(result) {
            if(result.status) {
              $(".unreadMessagesCount").text("0");
            }
          }
        });
      }
    });

    var unread2 = "{{$unread2}}";
    $(".unreadNotificationsCount").text(unread2);

    $("#notifications-menu").on('click',function(){
      var notificationIds = "<?php echo json_encode($notificationIds); ?>";
      notificationIds = JSON.parse(notificationIds);
      if(notificationIds.length > 0) {
        $.ajax({
          type: 'POST',
          url: "{{url('employees/unread-notifications')}}",
          data: {notification_ids: notificationIds},
          success: function(result) {
            if(result.status) {
              $(".unreadNotificationsCount").text("0");
            }
          }
        });
      }
    });
  </script>
