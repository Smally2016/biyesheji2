@extends('layout')

@section('header')
    <title>WAOS | Dashboard</title>
    @endsection

    @section('body')

            <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            打卡记录面板
            <small>签到 & 签退</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> 首页</a></li>
            <li><a href="/dashboard/inout">打卡记录面板</a></li>
            <li class="active">签到 & 签退</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-body">
                <table class="table table-striped table-hover " id="data_table">
                    <thead>
                    <tr>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Employee ID</th>
                        <th>NRIC</th>
                        <th>Name</th>
                        <th>Department</th>
                        <th>Site</th>
                        <th>In / Out</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div><!-- /.box-body -->
        </div><!-- /.box -->

    </section><!-- /.content -->

@endsection


@section('js')
    <script>
        var table = $('#data_table').DataTable({
            "paging": false,
            "ordering": false,
            "info": false,
            "bFilter": false,
            "ajax": "/dashboard/inout/api"
        });
        setInterval( function () {
            table.ajax.reload();
        }, 5000 );
        $('#tab_dashboard').addClass('active');
        $('#tab_dashboard_inout').addClass('active');
    </script>
@endsection