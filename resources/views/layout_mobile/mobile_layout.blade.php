@extends('layout_mobile.master')

@section('mobile_header')
    {{--<div id="mobile_header">--}}
    {{--泰尼贸易考勤机--}}
    {{--</div>--}}
@endsection

@section('mobile_footer')
    <div id="mobile_footer">
        <a href="/m/dashboard">
            <div class="footer_list" style="@yield('dashboard_footer_style')">
                <img src="/images/dashboard.png" alt="">
                <p>打卡</p>
            </div>
        </a>
        <a href="/m/attendances">
            <div class="footer_list" style="@yield('list_footer_style')">
                <img src="/images/welcome_list.png" alt="">
                <p>考勤记录</p>
            </div>
        </a>
        <a href="/m/reports">
            <div class="footer_list" style="@yield('report_footer_style')">
                <img src="/images/welcome_report.png" alt="">
                <p>周报</p>
            </div>
        </a>
        <a href="/m/rosters">
            <div class="footer_list" style="@yield('roster_footer_style')">
                <img src="/images/welcome_roster.png" alt="">
                <p>排班</p>
            </div>
        </a>
        <a href="/m/profile">
            <div class="footer_list" style="@yield('my_footer_style')">
                <img src="/images/welcome_my.png" alt="">
                <p>个人信息</p>
            </div>
        </a>
    </div>
    </div>
@endsection