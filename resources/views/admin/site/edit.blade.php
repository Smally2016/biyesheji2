@extends('layout')
@section('header')
    <title>WAOS | Edit Site</title>
    <style type="text/css">
        body, html {
            width: 100%;
            height: 100%;
            margin: 0;
            font-family: "微软雅黑";
            font-size: 14px;
        }

        #l-map {
            height: 300px;
            width: 100%;
        }

        #r-result {
            width: 100%;
        }
    </style>
@endsection
@section('body')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            工作地点
            <small>编辑</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> 首页</a></li>
            <li><a href="/admin/site/list">工作地点</a></li>
            <li class="active">编辑</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div id="l-map"></div>

        <!-- Default box -->
        <div class="box">
            <div class="box-body">
                <form role="form-horizontal" method="post">
                    {{csrf_field()}}
                    <input type="hidden" value="{{$site->site_id}}" name="site_id">
                    <div class="box-body">
                        <div class="form-group col-sm-offset-2 col-sm-8">
                            <label>工作地点名称</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{$site->name}}"
                                   required>
                        </div>
                        <div class="form-group col-sm-offset-2 col-sm-8">
                            <label>地址</label>
                            <input type="text" class="form-control"  value="{{$site->address}}" disabled="disabled">
                        </div>
                        <div class="form-group col-sm-offset-2 col-sm-8">
                            <label>新地址</label>
                            <div id="r-result"><input type="text" id="suggestId" size="20" value="{{$site->address}}"
                                                      name="address" class="form-control"/></div>
                            <div id="searchResultPanel"
                                 style="border:1px solid #C0C0C0;width:150px;height:auto; display:none;"></div>
                        </div>
                        <div class="form-group col-sm-offset-2 col-sm-8">
                            <label>邮编</label>
                            <input type="text" class="form-control" id="postal" name="postal" placeholder="{{$site->postal}}">
                        </div>
                        <div class="form-group col-sm-offset-2 col-sm-8">
                            <label>备注</label>
                            <textarea class="form-control" rows="3" name="remark">{{$site->remark}}</textarea>
                        </div>
                    </div><!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary center-block">保存</button>
                    </div>
                </form>
            </div><!-- /.box-body -->
        </div><!-- /.box -->

    </section><!-- /.content -->

@endsection


@section('js')
    <script type="text/javascript"
            src="http://api.map.baidu.com/api?v=2.0&ak=iREuauGcXGvMKv1lq9ZLtzvd0afQF2Ob"></script>
    <script>
        $('#tab_admin_site').addClass('active');
        $('#tab_admin_site_list').addClass('active');
    </script>
    <script type="text/javascript">
        // 百度地图API功能
        function G(id) {
            return document.getElementById(id);
        }

        var map = new BMap.Map("l-map");
        map.centerAndZoom("烟台", 12);                   // 初始化地图,设置城市和地图级别。

        var ac = new BMap.Autocomplete(    //建立一个自动完成的对象
            {
                "input": "suggestId"
                , "location": map
            });

        ac.addEventListener("onhighlight", function (e) {  //鼠标放在下拉列表上的事件
            var str = "";
            var _value = e.fromitem.value;
            var value = "";
            if (e.fromitem.index > -1) {
                value = _value.province + _value.city + _value.district + _value.street + _value.business;
            }
            str = "FromItem<br />index = " + e.fromitem.index + "<br />value = " + value;

            value = "";
            if (e.toitem.index > -1) {
                _value = e.toitem.value;
                value = _value.province + _value.city + _value.district + _value.street + _value.business;
            }
            str += "<br />ToItem<br />index = " + e.toitem.index + "<br />value = " + value;
            G("searchResultPanel").innerHTML = str;
        });

        var myValue = "{{$site->address}}"
        setPlace()
        ac.addEventListener("onconfirm", function (e) {    //鼠标点击下拉列表后的事件
            var _value = e.item.value;
            myValue = _value.province + _value.city + _value.district + _value.street + _value.business;
            G("searchResultPanel").innerHTML = "onconfirm<br />index = " + e.item.index + "<br />myValue = " + myValue;

            setPlace();
        });

        function setPlace() {
            map.clearOverlays();    //清除地图上所有覆盖物
            function myFun() {
                var pp = local.getResults().getPoi(0).point;    //获取第一个智能搜索的结果
                map.centerAndZoom(pp, 18);
                map.addOverlay(new BMap.Marker(pp));    //添加标注
            }

            var local = new BMap.LocalSearch(map, { //智能搜索
                onSearchComplete: myFun
            });
            local.search(myValue);
        }


    </script>
@endsection