@extends('layout_mobile.mobile_layout')

{{--@section('bg_img',"background-image:url('/images/welcome_bg.jpeg')")--}}

@section('body')

    <div id="welcome">
        <div class="page_list dashboard" style="background-image: url('/images/welcome_bg.jpeg')">
            <div class="row">
                <div class="col-xs-6 col-xs-offset-3">
                    <a href="/m/dashboard">
                        <div class="page_intro center-block">
                            <img src="/images/dashboard.png" alt="">
                            <p>去打卡</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="page_list dashboard" style="background-image: url('/images/welcome2.jpg')">
            <div class="row">
                <div class="col-xs-6 col-xs-offset-3">
                    <a href="/m/attendances">
                        <div class="page_intro center-block">
                            <img src="/images/welcome_list.png" alt="">
                            <p>查看考勤记录</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="page_list dashboard" style="background-image: url('/images/welcome3.jpg')">
            <div class="row">
                <div class="col-xs-6 col-xs-offset-3">
                    <a href="/m/reports">
                        <div class="page_intro cneter-block">
                            <img src="/images/welcome_report.png" alt="">
                            <p>我的周报</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="page_list dashboard" style="background-image: url('/images/welcome4.jpg')">
            <div class="row">
                <div class="col-xs-6 col-xs-offset-3">
                    <a href="/m/rosters">
                        <div class="page_intro cneter-block">
                            <img src="/images/welcome_roster.png" alt="">
                            <p>查看排班</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="page_list dashboard" style="background-image: url('/images/welcome5.jpg')">
            <div class="row">
                <div class="col-xs-6 col-xs-offset-3">
                    <a href="/m/profile">
                        <div class="page_intro cneter-block">
                            <img src="/images/welcome_my.png" alt="">
                            <p>个人信息</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>


    </div>

@endsection

