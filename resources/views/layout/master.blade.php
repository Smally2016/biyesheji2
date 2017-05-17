<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('css/AdminLTE.min.css')}}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{asset('css/skin-blue-light.min.css')}}">

    <link rel="stylesheet" href="{{asset('css/jquery.dataTables.css')}}">
    <link rel="stylesheet" href="{{asset('css/dataTables.tableTools.css')}}">
    <link rel="stylesheet" href="{{asset('css/dataTables.bootstrap.css')}}">
    <link rel="stylesheet" href="{{asset('css/buttons.dataTables.min.css')}}">

@yield('header')

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    @yield('map_js')
</head>
<body class="hold-transition skin-blue-light sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">

    <header class="main-header">
        <!-- Logo -->
        <a href="/" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b style="font-size: 13px">泰尼贸易考勤管理系统</b></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>泰尼贸易考勤管理系统&trade;</b></span>
        </a>

        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <!-- Messages: style can be found in dropdown.less-->
                    <!-- User Account: style can be found in dropdown.less -->
                    <li>
                        <a>
                            <span class="hidden-xs">
                                {{\Illuminate\Support\Facades\Auth::user()->name}}
                                @if(\App\Http\Models\UserModel::find(\Illuminate\Support\Facades\Auth::user()->user_id)->department)
                                    <?php
                                    $list = [];
                                    foreach (\App\Http\Models\UserModel::find(\Illuminate\Support\Facades\Auth::user()->user_id)->department as $department) {
                                        $list[] = $department->name;
                                    }
                                    ?>
                                    (
                                    {{implode(', ',$list)}}
                                    )
                                @endif
                            </span>
                        </a>
                    </li>
                    @stack('menu')
                    <li class="dropdown tasks-menu">
                        <a href="/logout">
                            <i class="fa fa-sign-out"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

    </header>

@yield('aside')


<!-- =============================================== -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        @yield('body')
    </div><!-- /.content-wrapper -->

    {{--<footer class="main-footer">--}}
        {{--@yield('footer')--}}
    {{--</footer>--}}

</div><!-- ./wrapper -->

<!-- jQuery 2.1.4 -->
<script src="{{asset('js/jQuery-2.1.4.min.js')}}"></script>
<!-- Bootstrap 3.3.5 -->
<script src="{{asset('js/bootstrap.min.js')}}"></script>
<!-- SlimScroll -->
<script src="{{asset('js/jquery.slimscroll.min.js')}}"></script>
<!-- FastClick -->
<script src="{{asset('js/fastclick.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('js/app.min.js')}}"></script>
<script src="{{asset('js/datatables/jquery.dataTables.js')}}"></script>
<script src="{{asset('js/datatables/dataTables.tableTools.js')}}"></script>
<script src="{{asset('js/datatables/dataTables.bootstrap.min.js')}}"></script>
<script src="{{asset('js/datatables/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('js/datatables/buttons.print.min.js')}}"></script>
@yield('js')
</body>
</html>
