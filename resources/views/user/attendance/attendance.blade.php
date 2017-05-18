@extends('layout_mobile.mobile_layout')

@section('mobile_title','我的考勤记录')

@section('list_footer_style','background:rgba(0,0,0,.1)')

@section('body')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            打卡记录
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="panel panel-default">
            <div class="panel-heading">
                打卡记录
            </div>
            <div class="table-responsive">
                <table class="table table-striped b-t b-light">
                    <thead>
                    <tr>
                        <th>时间</th>
                        <th>部门</th>
                        <th>办公地点</th>
                        <th>打卡状态</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($attendances as $attendance)
                        <tr>
                            <td>{{ $attendance->date_time }}</td>
                            <td>{{ $attendance->department->name }}</td>
                            <td>{{ $attendance->site->name }}</td>
                            <td>{{ $attendance->mode_text }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <div style="text-align: center">
                    {!! $attendances->render() !!}
                </div>
            </div>
        </div>

    </section><!-- /.content -->

@endsection


@section('js')

@endsection