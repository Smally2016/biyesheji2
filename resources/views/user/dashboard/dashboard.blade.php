@extends('layout_mobile.mobile_layout')
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
                <button class="btn btn-lg btn-info center-block punch_card" type="submit">我要{{ $this_time_in_out }}</button>
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
        map.centerAndZoom(point, 15);
        var my_point = {};
        var site_point = {};

        var geolocation = new BMap.Geolocation();
        geolocation.getCurrentPosition(function (r) {
            if (this.getStatus() == BMAP_STATUS_SUCCESS) {
                var mk = new BMap.Marker(r.point);
                map.addOverlay(mk);
                map.panTo(r.point);
                my_point = r.point;
                var marker = new BMap.Marker(r.point);  // 创建标注
                map.addOverlay(marker);
//                alert('wode'+my_point.lat);
                var distance = getDistance(my_point.lat, my_point.lng, site_point.lat, site_point.lng);
                console.log(distance)
//                alert(distance)
                if(distance>=500){
                    console.log('不在打卡区域内')
                    $(".punch_card").attr('disabled','disabled');
                    $(".punch_card").text('不在打卡区域内');
                    var circle = new BMap.Circle(point, 200, {strokeColor: "blue", strokeWeight: 2, strokeOpacity: 0.5}); //创建圆
                    map.addOverlay(circle);
                }
                var label = new BMap.Label("我的位置",{offset:new BMap.Size(20,-10)});
                label.setStyle({
                    color:'grey',
                    fontSize : "12px",
                    borderColor:'white',
                    height : "20px",
                    lineHeight : "20px",
                    backgroundColor:"white",
                    maxWidth:'100px',
                    fontFamily:"微软雅黑"
                });
                marker.setLabel(label);
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
                map.centerAndZoom(point, 15);
                map.addOverlay(new BMap.Marker(point));
//                alert(point.lng + ',' + point.lat)
                site_point = point;
                console.log(my_point);
//                alert('map'+site_point.lat);

            } else {
                alert("您选择地址没有解析到结果!");
            }

            //添加标注
            var marker = new BMap.Marker(point);  // 创建标注
            map.addOverlay(marker);
            var label = new BMap.Label("工作地点",{offset:new BMap.Size(20,-10)});
            label.setStyle({
                color:'grey',
                fontSize : "12px",
                borderColor:'white',
                height : "20px",
                lineHeight : "20px",
                backgroundColor:"white",
                maxWidth:'100px',
                fontFamily:"微软雅黑"
            });
            marker.setLabel(label);
        }, "北京市");


        map.enableScrollWheelZoom();   //启用滚轮放大缩小，默认禁用
        map.enableContinuousZoom();    //启用地图惯性拖拽，默认禁用


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
    </script>

@endsection