@extends('layout.master')

@push('menu')
<li class="dropdown tasks-menu">
    <a href="/m/profile">
        <i class="fa fa-user"></i>
    </a>
</li>
@endpush

@section('aside')
    <!-- Left side column. contains the sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- /.search form -->
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu">
                <li class="header">主菜单</li>
                <li>
                    <a href="/m">
                        <i class="fa fa-star"></i>
                        <span>主页面</span>
                    </a>
                </li>
                <li>
                    <a href="/m/rosters">
                        <i class="fa fa-star"></i>
                        <span>排班表</span>
                    </a>
                </li>
                <li>
                    <a href="/m/attendances">
                        <i class="fa fa-star"></i>
                        <span>打卡记录</span>
                    </a>
                </li>
                <li>
                    <a href="/m/reports">
                        <i class="fa fa-star"></i>
                        <span>周报</span>
                    </a>
                </li>
                <li>
                    <a href="/m/profile">
                        <i class="fa fa-star"></i>
                        <span>个人资料</span>
                    </a>
                </li>
            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>

@endsection


@section('footer')

    {{--<div class="pull-right hidden-xs">--}}
        {{--<b>Version</b> 1.0.0--}}
    {{--</div>--}}
    {{--<strong>Copyright &copy; 2017 ADP Protection Services Pte Ltd</strong> All rights reserved.--}}

@endsection