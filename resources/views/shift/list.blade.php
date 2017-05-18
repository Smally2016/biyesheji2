@extends('layout')

@section('header')
    <title>工作时间段列表</title>
@endsection

@section('body')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        工作时间段
        <small>工作时间段列表</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> 首页</a></li>
        <li><a href="/shift/list">工作时间段</a></li>
        <li class="active">工作时间段列表</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

    <!-- Default box -->
    <div class="box">
        <div class="box-body">
            <table id="table" class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>部门</th>
                    <th>工作地点</th>
                    <th>开始时间</th>
                    <th>工作时间(小时)</th>
                    <th>工作时间(分钟)</th>
                    <th>结束时间</th>
                    <th>编辑</th>
                    <th>删除</th>
                </tr>
                </thead>
                <tbody>
                @foreach($shifts as $shift)
                    <tr>
                        <td>{{$shift->department->name}}</td>
                        <td>{{$shift->site->name}}</td>
                        <td>{{$shift->start_time}}</td>
                        <td>{{$shift->hour}}</td>
                        <td>{{$shift->minute}}</td>
                        <td>{{$shift->getEndTime()->format('H:i:s')}}</td>
{{--
                        <td>{{\Carbon\Carbon::parse($shift->minute)->addHour($shift->hour)->addMinute($shift->minute)->toTimeString()}}</td>
--}}
                        <td>
                            <a href="/shift/edit/{{$shift->shift_id}}" class="btn btn-xs btn-warning" target="_blank">编辑</a>
                        </td>
                        <td>
                            <a href="" onclick="confirm('确认删除该条信息？')" class="btn btn-xs btn-danger">删除</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div><!-- /.box-body -->
    </div><!-- /.box -->

</section><!-- /.content -->

@endsection


@section('js')
    <script>
        $(function () {
            $('#table').DataTable({
                aLengthMenu: [
                    [25, 50, 100, 200, -1],
                    [25, 50, 100, 200, "All"]
                ],
                iDisplayLength: -1
            });
        });

        $('#tab_shift').addClass('active');
        $('#tab_shift_list').addClass('active');
    </script>
@endsection