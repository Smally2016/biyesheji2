@extends('layout')

@section('header')
    <title>WAOS | Shift List</title>
@endsection

@section('body')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Shift
        <small>List</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="/shift/list">Shift</a></li>
        <li class="active">List</li>
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
                    <th>Department</th>
                    <th>Site</th>
                    <th>Start Time</th>
                    <th>Duration Hour</th>
                    <th>Duration Minute</th>
                    <th>End Time</th>
                    <th>Edit</th>
                    <th>Delete</th>
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
                            <a href="/shift/edit/{{$shift->shift_id}}" class="btn btn-xs btn-warning" target="_blank">Edit</a>
                        </td>
                        <td>
                            <a href="" class="btn btn-xs btn-danger">Delete</a>
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