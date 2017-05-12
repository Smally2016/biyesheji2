@extends('layout.mobile_layout')

@section('body')
    <!-- Main content -->
    <section class="content">

        <form action="" method="post">
            {{ csrf_field() }}
            <input type="hidden" name="mode" value="{{ $mode }}">
            <button class="btn btn-lg btn-info center-block" type="submit">我要{{ $this_time_in_out }}</button>
        </form>

        <div class="row" style="padding-top: 30px">
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-aqua"><i class="fa fa-list-ol"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">排班提醒</span>
                        @foreach($rosters as $roster)
                            <span class="info-box-number">{{ $roster->date }} {{ $roster->shift->start_time }}</span>
                        @endforeach
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-red"><i class="fa fa-clock-o"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">上次打卡时间</span>
                        <span class="info-box-number">{{ $current_check }}</span>
                        <span class="info-box-number">{{ $in_out }}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->

            <!-- fix for small devices only -->
            <div class="clearfix visible-sm-block"></div>

            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-green"><i class="fa fa-clock-o"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">下次打卡时间</span>
                        <span class="info-box-number">{{ $next_check_in }}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-yellow"><i class="fa fa-hourglass-start"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">已工作时间</span>
                        <span class="info-box-number">{{ $working_time }}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
        </div>
    </section><!-- /.content -->

@endsection


@section('js')

@endsection