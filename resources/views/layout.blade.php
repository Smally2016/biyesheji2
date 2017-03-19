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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
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
</head>
<body class="hold-transition skin-blue-light sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">

    <header class="main-header">
        <!-- Logo -->
        <a href="/" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b style="font-size: 13px">WAOS&trade;</b></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>WAOS&trade;</b></span>
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
                    <li>
                        <a href="/logout">
                            <span class="hidden-xs"><span class="fa fa-sign-out"></span></span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

    </header>

    <!-- Left side column. contains the sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">

            <!-- /.search form -->
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu">
                <li class="header">MAIN MENU</li>
                <li class="treeview" id="tab_dashboard">
                    <a href="#">
                        <i class="fa  fa-dashboard"></i>
                        <span>Dashboard</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li id="tab_dashboard_inout"><a href="/dashboard/inout"><i class="fa fa-chevron-right "></i>Check
                                In/Out</a></li>
                    </ul>
                    <ul class="treeview-menu">
                        <li id="tab_dashboard_map"><a href="/dashboard/map"><i class="fa fa-chevron-right "></i>
                                Map</a></li>
                    </ul>
                </li>
                <li class="treeview" id="tab_employee">
                    <a href="#">
                        <i class="fa fa-male"></i>
                        <span>Employee</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li id="tab_employee_list"><a href="/employee/list/current"><i class="fa fa-chevron-right "></i>View
                                All</a></li>
                        <li id="tab_employee_new"><a href="/employee/new"><i class="fa fa-chevron-right "></i>Add
                                New</a></li>
                        <li id="tab_employee_card"><a href="/employee/card"><i class="fa fa-chevron-right "></i>Card
                            </a></li>
                        {{--
                                                <li id="tab_employee_qr"><a href="/employee/qr"><i class="fa fa-chevron-right "></i>QR Code</a></li>
                        --}}
                    </ul>
                </li>

                <li class="treeview" id="tab_roster">
                    <a href="#">
                        <i class="fa fa-calendar"></i>
                        <span>Roster</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="/roster/roster" id="tab_roster_roster"><i
                                        class="fa fa-chevron-right "></i>Manage</a></li>
                    </ul>
                </li>

                <li class="treeview" id="tab_shift">
                    <a href="#">
                        <i class="fa fa-clock-o"></i>
                        <span>Shifts</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li id="tab_shift_list"><a href="/shift/list"><i class="fa fa-chevron-right "></i>View All</a>
                        </li>
                        <li id="tab_shift_list"><a href="/shift/new"><i class="fa fa-chevron-right "></i>Add Shift</a>
                        </li>
                    </ul>
                </li>

                <li class="treeview" id="tab_record">
                    <a href="#">
                        <i class="fa fa-pencil-square"></i>
                        <span>Check In/Out</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li id="tab_record_manual"><a href="/record/manual"><i class="fa fa-chevron-right "></i>Manual
                                In/Out</a></li>
                        <li id="tab_record_edit"><a href="/record/edit"><i class="fa fa-chevron-right "></i>Edit Record</a>
                        </li>
                        <li id="tab_record_report"><a href="/record/report"><i class="fa fa-chevron-right "></i>In/Out
                                Report</a></li>
                    </ul>
                </li>
                <li class="treeview" id="tab_attendance">
                    <a href="#">
                        <i class="fa fa-area-chart"></i>
                        <span>Attendance</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li id="tab_attendance_weekly"><a href="/attendance/weekly"><i class="fa fa-chevron-right "></i>Weekly
                                Report</a></li>
                    </ul>
                </li>

                @if(\Illuminate\Support\Facades\Auth::user()->is_admin >= 1)
                    <li class="header">ADMINISTRATION</li>
                    <li class="treeview" id="tab_admin_user">
                        <a href="#">
                            <i class="fa  fa-group"></i>
                            <span>Users</span>
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li id="tab_admin_user_list"><a href="/admin/user/list" id="tab_admin_user_all"><i
                                            class="fa fa-chevron-right "></i>View All</a></li>
                            <li id="tab_admin_user_new"><a href="/admin/user/new" id="tab_admin_user_new"><i
                                            class="fa fa-chevron-right "></i>Add New</a></li>
                        </ul>
                    </li>
                    <li class="treeview" id="tab_admin_department">
                        <a href="#">
                            <i class="fa fa-building"></i>
                            <span>Departments</span>
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li id="tab_admin_department_list"><a href="/admin/department/list"><i
                                            class="fa fa-chevron-right "></i>View All</a></li>
                            <li id="tab_admin_department_new"><a href="/admin/department/new"><i
                                            class="fa fa-chevron-right "></i>Add New</a></li>
                        </ul>
                    </li>
                    <li class="treeview" id="tab_admin_site">
                        <a href="#">
                            <i class="fa fa-sitemap"></i>
                            <span>Sites</span>
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li id="tab_admin_site_list"><a href="/admin/site/list"><i class="fa fa-chevron-right "></i>View
                                    All</a></li>
                            <li id="tab_admin_site_new"><a href="/admin/site/new"><i class="fa fa-chevron-right "></i>Add
                                    New</a></li>
                        </ul>
                    </li>

                    <li class="treeview" id="tab_admin_reader">
                        <a href="#">
                            <i class="fa fa-desktop"></i>
                            <span>Readers</span>
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li id="tab_admin_reader_list"><a href="/admin/reader/list"><i
                                            class="fa fa-chevron-right "></i>View All</a></li>
                            <li id="tab_admin_reader_new"><a href="/admin/reader/new"><i
                                            class="fa fa-chevron-right "></i>Add New</a></li>
                        </ul>
                    </li>

                    <li class="treeview" id="tab_admin_employee_title">
                        <a href="#">
                            <i class="fa fa-shirtsinbulk"></i>
                            <span>Employee Titles</span>
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li id="tab_admin_employee_title_list"><a href="/admin/employee/title/list"><i
                                            class="fa fa-chevron-right "></i>View All</a></li>
                            <li id="tab_admin_employee_title_new"><a href="/admin/employee/title/new"><i
                                            class="fa fa-chevron-right "></i>Add New</a></li>
                        </ul>
                    </li>

                    <li class="treeview" id="tab_admin_leave_type">
                        <a href="#">
                            <i class="fa fa-fighter-jet"></i>
                            <span>Leave Types</span>
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li id="tab_admin_leave_type_list"><a href="/admin/leave/type/list"><i
                                            class="fa fa-chevron-right "></i>View All</a></li>
                            <li id="tab_admin_leave_type_new"><a href="/admin/leave/type/new"><i
                                            class="fa fa-chevron-right "></i>Add New</a></li>
                        </ul>
                    </li>
                @endif

            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- =============================================== -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        @yield('body')
    </div><!-- /.content-wrapper -->

    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Version</b> 1.0.0
        </div>
        <strong>Copyright &copy; 2014-2015 ADP Protection Services Pte Ltd</strong> All rights reserved.
    </footer>

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
