@extends('layout')
@section('header')
    <title>WAOS | Record</title>
    <link rel="stylesheet" href="{{asset('css/daterangepicker-bs3.css')}}">

    @endsection

    @section('body')

            <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Record
            <small>Edit</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="/record/">Record</a></li>
            <li class="active">Edit</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <form role="form" method="post">
                {{csrf_field()}}
                <div class="box-body">

                    <div class="form-group col-lg-offset-4 col-lg-4">
                        <label for="date_range">Calendar Date:</label>
                        <input type="text" class="form-control" id="date_range" required name="date_range"
                               value="{{$date_range}}">
                    </div>

                    <div class="form-group col-lg-offset-4 col-lg-4">
                        <label> Department:</label>
                        <select class="form-control" name="department_id">
                            <option value="0">All Department</option>
                            @foreach($departments as $department)
                                @if($selected_department == $department->department_id)
                                    <option value="{{$department->department_id}}"
                                            selected>{{$department->name}}</option>
                                @else
                                    <option value="{{$department->department_id}}">{{$department->name}}</option>
                                @endif

                            @endforeach
                        </select>

                    </div>

                    <div class="form-group col-lg-offset-4 col-lg-4">
                        <label> Site:</label>
                        <select class="form-control" name="site_id">
                            <option value="0">All Site</option>
                            @foreach($sites as $site)
                                @if($selected_site == $site->site_id)
                                    <option value="{{$site->site_id}}"
                                            selected>{{$site->name}}</option>
                                @else
                                    <option value="{{$site->site_id}}">{{$site->name}}</option>
                                @endif

                            @endforeach
                        </select>

                    </div>

                    <div class="form-group col-lg-offset-4 col-lg-4">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="deleted_record" {{$deleted_record}}>
                                Hide Deleted Records
                            </label>
                        </div>
                    </div>

                </div><!-- /.box-body -->

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary center-block">Generate</button>

                </div>
            </form>
        </div><!-- /.box -->

        <!-- Default box -->
        <div class="box">
            <div class="box-body">
                <table class="table table-striped table-hover ">
                    <thead>
                    <tr>
                        <th>Date Time</th>
                        <th>NRIC</th>
                        <th>Name</th>
                        <th>Department</th>
                        <th>Site</th>
                        <th>In / Out</th>
                        <th>Duty Date</th>
                        <th>Shift</th>
                        <th>Delete</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($records as $record)
                        <tr id="record_{{$record->attendance_id}}">
                            <td>{{\Carbon\Carbon::parse($record->date_time)->format('d/m/Y H:i:s')}}</td>
                            <td>{{$record->employee->nric}}</td>
                            <td>{{$record->employee->name}}</td>
                            <td>{{$record->department->name}}</td>
                            <td>{{$record->site->name}}</td>
                            <td>
                                <select class="form-control input-sm shift" id="mode_{{$record->attendance_id}}"
                                        onchange="changeMode('{{$record->attendance_id}}')">
                                    @foreach(\App\Helpers\AttendanceHelper::$modes as $key => $mode)
                                        <option value="{{$key}}" {{$record->mode == $key?'selected':''}}>{{$mode}}{{$record->mode == $key?$record->getStatus()!=''?' ('.$record->getStatus().')':'':''}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select class="form-control input-sm" id="duty_date_{{$record->attendance_id}}"
                                        onchange="changeDutyDate('{{$record->attendance_id}}')">
                                    @if($record->duty_date == '0000-00-00')
                                        <option>Select</option>
                                    @endif
                                    {!! $last = \Carbon\Carbon::parse($record->date_time)->addDay(-1) !!}
                                    {!! $current = \Carbon\Carbon::parse($record->date_time) !!}
                                    {!! $next = \Carbon\Carbon::parse($record->date_time)->addDay(1) !!}
                                    <option value="{{$last->format('Y-m-d')}}" {{$record->duty_date == $last->format('Y-m-d')?'selected':''}}>{{ $last->format('d/m')}}
                                        P
                                    </option>
                                    <option value="{{$current->format('Y-m-d')}}" {{$record->duty_date == $current->format('Y-m-d')?'selected':''}}>{{\Carbon\Carbon::parse($record->date_time)->format('d/m')}}
                                        S
                                    </option>
                                    <option value="{{$next->format('Y-m-d')}}" {{$record->duty_date == $next->format('Y-m-d')?'selected':''}}>{{\Carbon\Carbon::parse($record->date_time)->addDay(1)->format('d/m')}}
                                        N
                                    </option>
                                </select>
                            </td>
                            <td>
                                <select class="form-control input-sm shift" id="shift_{{$record->attendance_id}}"
                                        onchange="changeShift('{{$record->attendance_id}}')">
                                    @if($record->shift_id == 0)
                                        <option>Select</option>
                                    @endif
                                    @foreach($record->getShift() as $shift)
                                        <option value="{{$shift->shift_id}}" {{$shift->shift_id == $record->shift_id?'selected':''}}>{{$shift->getName()}}</option>
                                    @endforeach
                                </select>
                            </td>

                            <td class="text-center">
                                <button class="btn btn-xs" onclick="deleteRow('{{$record->attendance_id}}')"><span
                                            class="fa fa-trash text-red"></span></button>
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
    <script src="{{asset('js/moment.min.js')}}"></script>
    <script src="{{asset('js/daterangepicker.js')}}"></script>

    <script>
        $(function () {
            $('input[name="date_range"]').daterangepicker({
                singleDatePicker: true,
                "locale": {
                    "format": "DD/MM/YYYY",
                    firstDay: 1,
                }
            });
        });

        function changeDutyDate(attendance_id) {
            var duty_date = $('#duty_date_' + attendance_id);
            $.ajax({
                url: "/record/edit/duty_date",
                data: {
                    attendance_id: attendance_id,
                    duty_date: duty_date.val(),
                    _token: '{{csrf_token()}}'
                },
                type: 'post',
                success: function (data, status) {
                    if (data == '1') {
                        duty_date.css('color', 'green');
                    } else {
                        duty_date.css('color', 'red');
                    }
                }
            });
        }

        function changeShift(attendance_id, shift_id) {
            var shift_id = $('#shift_' + attendance_id);
            $.ajax({
                url: "/record/edit/shift",
                data: {
                    attendance_id: attendance_id,
                    shift_id: shift_id.val(),
                    _token: '{{csrf_token()}}'
                },
                type: 'post',
                success: function (data, status) {
                    if (data == '1') {
                        shift_id.css('color', 'green');
                    } else {
                        shift_id.css('color', 'red');
                    }
                }
            });
        }

        function changeMode(attendance_id) {
            var mode = $('#mode_' + attendance_id);
            $.ajax({
                url: "/record/edit/mode",
                data: {
                    attendance_id: attendance_id,
                    mode: mode.val(),
                    _token: '{{csrf_token()}}'
                },
                type: 'post',
                success: function (data, status) {
                    if (data == '1') {
                        mode.css('color', 'green');
                    } else {
                        mode.css('color', 'red');
                    }
                }
            });
        }

        function deleteRow(attendance_id) {
            if (window.confirm('Confirm Delete this record?')) {
                $.ajax({
                    url: "/record/edit/delete",
                    data: {
                        attendance_id: attendance_id,
                        _token: '{{csrf_token()}}'
                    },
                    type: 'post',
                    success: function (data, status) {
                        if (data == '1') {
                            $('#record_' + attendance_id).hide();
                        } else {
                            alert('delete failed');
                        }
                    }
                });
            }
        }

        $('#tab_record').addClass('active');
        $('#tab_record_edit').addClass('active');
    </script>
@endsection