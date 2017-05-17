@extends('layout.mobile_layout')

@section('map_js')
    <script type="text/javascript"
            src="http://api.map.baidu.com/api?v=2.0&ak=3aWKjGfb9VaH0Kby4LQr5y93w9vnEMqq"></script>
@endsection

@section('header')
    <style type="text/css">
        body, html {
            width: 100%;
            height: 100%;
            margin: 0;
            font-family: "微软雅黑";
        }

        #allmap {
            height: 250px;
            width: 100%;
            overflow: hidden;
        }

        #r-result {
            width: 100%;
        }
    </style>
@endsection

@section('body')
    <!-- Main content -->
    <section class="content">

        <div class="row">
            <form action="" method="post">
                {{ csrf_field() }}
                <input type="hidden" name="mode" value="{{ $mode }}">
                <button class="btn btn-lg btn-info center-block" type="submit">我要{{ $this_time_in_out }}</button>
            </form>
        </div>
        <br>

        @if($site)
            <p class="text-center text-bold">需要在蓝色圈内打卡</p>
            <div id="allmap" class="m-t-md"></div>
        @else
            <p class="text-center text-bold">无排班记录， 不需要在范围内打开</p>
        @endif
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

    <script type="text/javascript">
        // 百度地图API功能
        var map = new BMap.Map("allmap");
        var point = new BMap.Point(116.404, 39.915);
        map.centerAndZoom(point, 14);
        var my_point = {};
        var site_point = {};

        var geolocation = new BMap.Geolocation();
        geolocation.getCurrentPosition(function (r) {
            if (this.getStatus() == BMAP_STATUS_SUCCESS) {
                var mk = new BMap.Marker(r.point);
                map.addOverlay(mk);
                map.panTo(r.point);
                my_point = r.point;
//                alert('您的位置：' + r.point.lng + ',' + r.point.lat);
//                console.log('wo的位置：' +my_point.lat)
            }

            else {
                alert('failed' + this.getStatus());
            }

        }, {enableHighAccuracy: true})
        // 创建地址解析器实例
        var myGeo = new BMap.Geocoder();
        // 将地址解析结果显示在地图上,并调整地图视野
        console.log("{{ $site->address }}");
        myGeo.getPoint("{{ $site->address }}", function (point) {
            if (point) {
                map.centerAndZoom(point, 14);
                map.addOverlay(new BMap.Marker(point));
//                alert(point.lng + ',' + point.lat)
                site_point = point;
                console.log(my_point);
                var distance = getDistance(my_point.lat, my_point.lng, site_point.lat, site_point.lng);
                console.log(distance)
            } else {
                alert("您选择地址没有解析到结果!");
            }
            var circle = new BMap.Circle(point, 200, {strokeColor: "blue", strokeWeight: 2, strokeOpacity: 0.5}); //创建圆
            map.addOverlay(circle);
        }, "北京市");
        map.enableScrollWheelZoom();   //启用滚轮放大缩小，默认禁用
        map.enableContinuousZoom();    //启用地图惯性拖拽，默认禁用
//        console.log('我的位置'+my_point.lat);
//        console.log('工作地点位置'+site_point.lat);


        //查看两点之间的距离
        function getDistance(lat1, lng1, lat2, lng2) {
            var dis = 0;
            var radLat1 = toRadians(lat1);
            var radLat2 = toRadians(lat2);
            var deltaLat = radLat1 - radLat2;
            var deltaLng = toRadians(lng1) - toRadians(lng2);
            var dis = 2 * Math.asin(Math.sqrt(Math.pow(Math.sin(deltaLat / 2), 2) + Math.cos(radLat1) * Math.cos(radLat2) * Math.pow(Math.sin(deltaLng / 2), 2)));
            return dis * 6378137;

            function toRadians(d) {  return d * Math.PI / 180;}
        }
        var distance = getDistance(my_point.lat, my_point.lng, site_point.lat, site_point.lng);
//        console.log(distance)
        //

//                        var marker = new BMap.Marker(new BMap.Point(116.404, 39.915)); // 创建点
//                        var polyline = new BMap.Polyline([
//                            new BMap.Point(116.399, 39.910),
//                            new BMap.Point(116.405, 39.920),
//                            new BMap.Point(116.425, 39.900)
//                        ], {strokeColor: "blue", strokeWeight: 2, strokeOpacity: 0.5});   //创建折线
//
//                        var circle = new BMap.Circle(point, 500, {strokeColor: "blue", strokeWeight: 2, strokeOpacity: 0.5}); //创建圆
//
//                        var polygon = new BMap.Polygon([
//                            new BMap.Point(116.387112, 39.920977),
//                            new BMap.Point(116.385243, 39.913063),
//                            new BMap.Point(116.394226, 39.917988),
//                            new BMap.Point(116.401772, 39.921364),
//                            new BMap.Point(116.41248, 39.927893)
//                        ], {strokeColor: "blue", strokeWeight: 2, strokeOpacity: 0.5});  //创建多边形
//
//                        var pStart = new BMap.Point(116.392214, 39.918985);
//                        var pEnd = new BMap.Point(116.41478, 39.911901);
//                        var rectangle = new BMap.Polygon([
//                            new BMap.Point(pStart.lng, pStart.lat),
//                            new BMap.Point(pEnd.lng, pStart.lat),
//                            new BMap.Point(pEnd.lng, pEnd.lat),
//                            new BMap.Point(pStart.lng, pEnd.lat)
//                        ], {strokeColor: "blue", strokeWeight: 2, strokeOpacity: 0.5});  //创建矩形
//
//                        map.addOverlay(circle);            //增加圆

    </script>

@endsection