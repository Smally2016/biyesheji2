@extends('layout.master')


@section('aside')
    <!-- Left side column. contains the sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">

            <!-- /.search form -->
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu">
                <li class="header">主菜单</li>
                <li class="treeview" id="tab_dashboard">
                    <a href="#">
                        <i class="fa  fa-dashboard"></i>
                        <span>面板</span>
                        <i class="fa fa-chevron-right pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li id="tab_dashboard_inout"><a href="/dashboard/inout">打卡记录</a></li>
                    </ul>
                    {{--<ul class="treeview-menu">--}}
                        {{--<li id="tab_dashboard_map"><a href="/dashboard/map">地图</a></li>--}}
                    {{--</ul>--}}
                </li>
                <li class="treeview" id="tab_employee">
                    <a href="#">
                        <i class="fa fa-male"></i>
                        <span>员工</span>
                        <i class="fa fa-chevron-right pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li id="tab_employee_list"><a href="/employee/list/current">查看所有</a></li>
                        <li id="tab_employee_new"><a href="/employee/new">增加</a></li>
                        <li id="tab_employee_card"><a href="/employee/card">员工卡</a></li>
                        {{--
                                                <li id="tab_employee_qr"><a href="/employee/qr"><i class="fa fa-chevron-right "></i>QR Code</a></li>
                        --}}
                    </ul>
                </li>

                <li class="treeview" id="tab_roster">
                    <a href="#">
                        <i class="fa fa-calendar"></i>
                        <span>排班</span>
                        <i class="fa fa-chevron-right pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="/roster/roster" id="tab_roster_roster">管理</a></li>
                    </ul>
                </li>

                <li class="treeview" id="tab_shift">
                    <a href="#">
                        <i class="fa fa-clock-o"></i>
                        <span>时间段</span>
                        <i class="fa fa-chevron-right pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li id="tab_shift_list"><a href="/shift/list">查看所有</a>
                        </li>
                        <li id="tab_shift_list"><a href="/shift/new">新增时间段</a>
                        </li>
                    </ul>
                </li>

                <li class="treeview" id="tab_record">
                    <a href="#">
                        <i class="fa fa-pencil-square"></i>
                        <span>打卡</span>
                        <i class="fa fa-chevron-right pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li id="tab_record_manual"><a href="/record/manual">手动打卡</a></li>
                        <li id="tab_record_edit"><a href="/record/edit">编辑记录</a>
                        </li>
                        <li id="tab_record_report"><a href="/record/report">打卡记录</a></li>
                    </ul>
                </li>
                <li class="treeview" id="tab_attendance">
                    <a href="#">
                        <i class="fa fa-area-chart"></i>
                        <span>请假</span>
                        <i class="fa fa-chevron-right pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li id="tab_attendance_weekly"><a href="/attendance/weekly">周报</a></li>
                    </ul>
                </li>

                @if(\Illuminate\Support\Facades\Auth::user()->is_admin >= 1)
                    <li class="header">管理员</li>
                    <li class="treeview" id="tab_admin_user">
                        <a href="#">
                            <i class="fa  fa-group"></i>
                            <span>用户</span>
                            <i class="fa fa-chevron-right pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li id="tab_admin_user_list"><a href="/admin/user/list" id="tab_admin_user_all">查看所有</a>
                            </li>
                            <li id="tab_admin_user_new"><a href="/admin/user/new" id="tab_admin_user_new">增加新用户</a></li>
                        </ul>
                    </li>
                    <li class="treeview" id="tab_admin_department">
                        <a href="#">
                            <i class="fa fa-building"></i>
                            <span>部门</span>
                            <i class="fa fa-chevron-right pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li id="tab_admin_department_list"><a href="/admin/department/list">查看所有</a></li>
                            <li id="tab_admin_department_new"><a href="/admin/department/new">增加新部门</a></li>
                        </ul>
                    </li>
                    <li class="treeview" id="tab_admin_site">
                        <a href="#">
                            <i class="fa fa-sitemap"></i>
                            <span>工作地点</span>
                            <i class="fa fa-chevron-right pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li id="tab_admin_site_list"><a href="/admin/site/list">查看所有</a></li>
                            <li id="tab_admin_site_new"><a href="/admin/site/new"></a></li>
                        </ul>
                    </li>

                    <li class="treeview" id="tab_admin_reader">
                        <a href="#">
                            <i class="fa fa-desktop"></i>
                            <span>Readers</span>
                            <i class="fa fa-chevron-right pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li id="tab_admin_reader_list"><a href="/admin/reader/list">View All</a></li>
                            <li id="tab_admin_reader_new"><a href="/admin/reader/new">Add New</a></li>
                        </ul>
                    </li>

                    <li class="treeview" id="tab_admin_employee_title">
                        <a href="#">
                            <i class="fa fa-shirtsinbulk"></i>
                            <span>员工职位</span>
                            <i class="fa fa-chevron-right pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li id="tab_admin_employee_title_list"><a href="/admin/employee/title/list">查看所有</a></li>
                            <li id="tab_admin_employee_title_new"><a href="/admin/employee/title/new">新增员工职位</a></li>
                        </ul>
                    </li>

                    <li class="treeview" id="tab_admin_leave_type">
                        <a href="#">
                            <i class="fa fa-fighter-jet"></i>
                            <span>请假类型</span>
                            <i class="fa fa-chevron-right pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li id="tab_admin_leave_type_list"><a href="/admin/leave/type/list">查看所有</a></li>
                            <li id="tab_admin_leave_type_new"><a href="/admin/leave/type/new">新增请假类型</a></li>
                        </ul>
                    </li>
                @endif

            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>

@endsection


@section('footer')

    <div class="pull-right hidden-xs">
        <b>Version</b> 1.0.0
    </div>
    <strong>Copyright &copy; 2014-2015 ADP Protection Services Pte Ltd</strong> All rights reserved.

@endsection