@extends('layout_mobile.mobile_layout')

@section('mobile_title','我的排班')

@section('roster_footer_style','background:rgba(0,0,0,.1)')

@section('body')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            排班表
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">


        <div class="panel panel-default">
            <div class="panel-heading">
                排班表
            </div>
            <div class="table-responsive">
                <table class="table table-striped b-t b-light">
                    <thead>
                    <tr>
                        <th>日期</th>
                        <th>地点</th>
                        <th>上班时间</th>
                        <th>下班时间</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($rosters as $roster)
                        <tr>
                            <td>{{ $roster->date }}</td>
                            <td>{{ $roster->shift->site->name }}</td>
                            <td>{{ $roster->shift->start_time }}</td>
                            <td>{{ $roster->shift->end_time }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <div style="text-align: center">
                    {!! $rosters->render() !!}
                </div>
            </div>
        </div>

    </section><!-- /.content -->

@endsection


@section('js')

@endsection