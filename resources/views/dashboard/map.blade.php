@extends('layout')

@section('body')

        <!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Dashboard
        <small>Map</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="/dashboard">Dashboard</a></li>
        <li class="active">Map</li>
    </ol>
</section>


<!-- Main content -->
<section class="content">

    <!-- Default box -->
    <div class="box">

            <div class="contentpanel">


                <div class="panel panel-default">
                    <div class="panel-body">

                        <div id="map" style="with:100%;height: 900px"></div>


                    </div><!-- panel-body -->
                </div><!-- panel -->

                <p id="updateP">Click <a id="updateLink" onclick="update()">here</a> to update.</p>


            </div><!-- contentpanel -->

        </div><!-- mainpanel -->

    </div><!-- /.box -->

</section><!-- /.content -->

@endsection
@section('js')
    <script src="{{asset('//maps.googleapis.com/maps/api/js?sensor=false')}}"></script>

    <script src="{{asset('/js/map/jquery-jvectormap-1.2.2.min.js')}}"></script>
    <script src="{{asset('/js/map/jquery-jvectormap-world-mill-en.js')}}"></script>
    <script src="{{asset('/js/map/jquery-jvectormap-us-aea-en.js')}}"></script>
    <script src="{{asset('/js/map/gmaps.js')}}"></script>
    <script>
        var map;
        $(document).ready(function () {
            map = new GMaps({
                div: '#map',
                lat: 1.3146632,
                lng: 103.8454093,
                zoom: 11
            });
            @foreach($sites as $site)
            map.addMarker({
                lat: "{{$site -> lat}}",
                lng: "{{$site -> lng}}",
                title: '{{$site -> name}}',
                icon: '/image/flag/red.png',
                infoWindow: {
                    content: '<h2>{{$site -> name}}</h2>' +
                    '<p>{{$site -> remark}}</p>'
                }
            });

            @endforeach

        });
        $('#tab_dashboard').addClass('active');
        $('#tab_dashboard_map').addClass('active');

        function update() {
            $('#updateP').html('Updating...');

            $.get("/dashboard/updateGeo",
                    function (data) {
                        obj = JSON.parse(data);
                        $("#updateP").html(obj['msg']);
                        if (obj['valid'] == 1) {
                            sleep(1000);
                            window.location.reload();
                        }
                    });
        }
    </script>

@stop