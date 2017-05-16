@extends('layout.mobile_layout')

@section('header')
    <style type="text/css">
        body, html {
            width: 100%;
            height: 100%;
            margin: 0;
            font-family: "微软雅黑";
        }

        #allmap {
            height: 500px;
            width: 100%;
        }

        #r-result {
            width: 100%;
        }
    </style>
@endsection

@section('body')
    <!-- Main content -->
    <section class="content">

        <form action="" method="post">
            {{ csrf_field() }}
            <input type="hidden" name="mode" value="{{ $mode }}">
            <button class="btn btn-lg btn-info center-block" type="submit">我要{{ $this_time_in_out }}</button>
        </form>

        <div id="allmap"></div>

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
    <script type="text/javascript"
            src="http://api.map.baidu.com/api?v=2.0&ak=iREuauGcXGvMKv1lq9ZLtzvd0afQF2Ob	"></script>
    <script type="text/javascript">
        // 百度地图API功能
        var map = new BMap.Map("allmap");
        var point = new BMap.Point(116.404, 39.915);
        map.centerAndZoom(point, 15);

        // 百度地图API功能
        var map = new BMap.Map("allmap");

        // 创建地址解析器实例
        var myGeo = new BMap.Geocoder();
        // 将地址解析结果显示在地图上,并调整地图视野
        myGeo.getPoint("鲁东大学(北区)", function(point){
            if (point) {
                map.centerAndZoom(point, 16);
                map.addOverlay(new BMap.Marker(point));
            }else{
                alert("您选择地址没有解析到结果!");
            }
        }, "北京市");
//
//
//        var marker = new BMap.Marker(new BMap.Point(116.404, 39.915)); // 创建点
//        var polyline = new BMap.Polyline([
//            new BMap.Point(116.399, 39.910),
//            new BMap.Point(116.405, 39.920),
//            new BMap.Point(116.425, 39.900)
//        ], {strokeColor: "blue", strokeWeight: 2, strokeOpacity: 0.5});   //创建折线
//
//        var circle = new BMap.Circle(point, 500, {strokeColor: "blue", strokeWeight: 2, strokeOpacity: 0.5}); //创建圆
//
//        var polygon = new BMap.Polygon([
//            new BMap.Point(116.387112, 39.920977),
//            new BMap.Point(116.385243, 39.913063),
//            new BMap.Point(116.394226, 39.917988),
//            new BMap.Point(116.401772, 39.921364),
//            new BMap.Point(116.41248, 39.927893)
//        ], {strokeColor: "blue", strokeWeight: 2, strokeOpacity: 0.5});  //创建多边形
//
//        var pStart = new BMap.Point(116.392214, 39.918985);
//        var pEnd = new BMap.Point(116.41478, 39.911901);
//        var rectangle = new BMap.Polygon([
//            new BMap.Point(pStart.lng, pStart.lat),
//            new BMap.Point(pEnd.lng, pStart.lat),
//            new BMap.Point(pEnd.lng, pEnd.lat),
//            new BMap.Point(pStart.lng, pEnd.lat)
//        ], {strokeColor: "blue", strokeWeight: 2, strokeOpacity: 0.5});  //创建矩形
//
//        map.addOverlay(circle);            //增加圆

    </script>

@endsection