<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Log in</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('css/AdminLTE.min.css')}}">
    <!-- iCheck -->
    <link rel="stylesheet" href="../../plugins/iCheck/square/blue.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body class="hold-transition login-page"
      style="background-image: url('/image/waos_main_background_3.jpg');background-position: center center;background-repeat: no-repeat;background-attachment: fixed;background-size: cover;">
<div class="login-box" style="margin-bottom: 0">
    <div class="login-logo">
        <b style="text-shadow: 1px 1px white;font-size: 45px">泰尼贸易</b><br>
    </div><!-- /.login-logo -->

</div>
<h3 style="text-shadow: 1px 1px white;white-space: nowrap;text-align: center">行走的考勤打卡机</h3>
<div class="login-box" style="margin-top: 10px">
    <div class="login-box-body">

        <p class="login-box-msg">{{ session('message') }}</p>
        <form method="post">
            {{csrf_field()}}
            <div class="form-group has-feedback">
                <input type="text" class="form-control" placeholder="Username" required name="username">
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" class="form-control" placeholder="Password" required name="password">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-offset-4 col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">登录</button>
                </div><!-- /.col -->
            </div>
        </form>
    </div><!-- /.login-box-body -->
    <div class="login-box-msg" style="padding-top: 30px">
        <p style="text-shadow: 1px 1px white;">©2017 All Rights Reserved</p>
        <p style="text-shadow: 1px 1px white;">Tiny Traditional</p>
    </div>

</div><!-- /.login-box -->
<p style="right: 0;bottom: 0;position: absolute;">Version 1.0.0</p>

<!-- jQuery 2.1.4 -->
<script src="{{asset('js/jQuery-2.1.4.min.js')}}"></script>
<!-- Bootstrap 3.3.5 -->
<script src="{{asset('js/bootstrap.min.js')}}"></script>

</body>
</html>
