@extends('layout_mobile.mobile_layout')

@section('mobile_title','我的周报')

@section('report_footer_style','background:rgba(0,0,0,.1)')

@section('header')
    <title xmlns="http://www.w3.org/1999/html">Attendance Weekly Report | ADP Center WAOS&trade;</title>
    <link rel="stylesheet" href="{{asset('css/select2.min.css')}}">
@endsection

@section('body')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            周报
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> 主页</a></li>
            <li><a href="/attendance/weekly">考勤记录</a></li>
            <li class="active">周报</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-body">
                <form role="form" method="post">
                    {{csrf_field()}}
                    <div class="box-body">
                        <div class="form-group col-lg-6">
                            <label> 年份:</label>
                            <select class="form-control "
                                    name="year" id="year" onchange="getWeeks()">
                                @for($i = date('Y')-5; $i <= date('Y'); $i++)
                                    @if($i == $selected_year)
                                        <option value="{{$i}}"
                                                selected>{{$i}}
                                        </option>
                                    @else
                                        <option value="{{$i}}">{{$i}}
                                        </option>
                                    @endif
                                @endfor
                            </select>

                        </div>
                        <div class="form-group col-lg-6">
                            <label> 自然周:</label>
                            <select class="form-control" name="week" id="week">
                                <option value="0">Loading</option>
                            </select>
                        </div>
                        <div class="form-group col-lg-6">
                            <label> 部门:</label>
                            <select class="form-control" name="department_id" id="department" onchange="getSite()">
                                <option value="0">全部部门</option>
                                @foreach($departments as $department)
                                    @if($selected_department == $department -> department_id)
                                        <option value="{{$department->department_id}}"
                                                selected>{{$department->name}}</option>
                                    @else
                                        <option value="{{$department->department_id}}">{{$department->name}}</option>
                                    @endif

                                @endforeach
                            </select>

                        </div>

                        <div class="form-group col-lg-6">
                            <label> 地点:</label>
                            <select class="form-control" name="site_id" id="site">
                                <option value="0">Loading</option>
                            </select>

                        </div>

                    </div><!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary center-block">生成</button>

                    </div>
                </form>
            </div><!-- /.box-body -->
        </div><!-- /.box -->



        <div class="panel panel-default">
            <div class="panel-heading">
                排班表
            </div>
            <div class="table-responsive">
                <table class="table table-striped b-t b-light">
                    <thead>
                    <tr>
                        <th>姓名</th>
                        <?php $start_date = \Carbon\Carbon::parse(date('Y-m-d', strtotime($selected_year . "-W" . $selected_week . "-" . 1)))->addDay(-1) ?>
                        @for($i = 0; $i < 7; $i++)
                            <th>{{$start_date->addDay(1)->format('d/m')}} <span
                                        style="text-align: center">{{$start_date->format('D')}}</span></th>
                        @endfor
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($employees as $employee)
                        <tr>
                            <td>
                                {{$employee->name}}<br><br>
                                {{$employee->nric}}<br>
                                {{$employee->title->name}}<br>
                                电话: {{$employee->phone}}<br>
                            </td>
                            <?php $start_date = \Carbon\Carbon::parse(date('Y-m-d', strtotime($selected_year . "-W" . $selected_week . "-" . 1)))->addDay(-1) ?>
                            <?php $end_date = \Carbon\Carbon::parse(date('Y-m-d', strtotime($selected_year . "-W" . $selected_week . "-" . 7))) ?>
                            @for($i = 0; $i < 7; $i++)
                                <?php $start_date->addDay(1)?>
                                <td style="padding: 0">

                                    <?php $duty_date = $start_date->format('Y-m-d H:i:s')?>
                                    {{--roster--}}
                                    <?php $rosters = \App\Http\Models\RosterModel::where('employee_id', $employee->employee_id)
                                        ->where('date', $start_date->format('Y-m-d'))
                                        ->where('status', '>', 0)
                                        ->get()
                                    ?>
                                    <?php $leave = \App\Http\Models\LeaveModel::where('employee_id', $employee->employee_id)
                                        ->where('date', $start_date->format('Y-m-d'))
                                        ->where('status', '>', 0)
                                        ->first()
                                    ?>


                                    @if($rosters->count()>0)
                                        @foreach($rosters as $roster)
                                            <div class="bg-info">
                                                <b>排班:</b></br>
                                                {{$roster->shift->site->name}}<br>
                                                开始: {{\Carbon\Carbon::parse($roster->shift->start_time)->format('H:i')}}
                                                <br>
                                                结束: {{$roster->shift->getEndTime()->format('H:i')}}<br>
                                                时长: {{$roster->shift->hour.' 小时'.($roster->shift->mintue == 0?'':$roster->shift->mintue.' 分')}}
                                            </div>
                                        @endforeach
                                    @endif
                                    @if($leave)

                                        <div class="bg-danger">
                                            <b>假期:</b></br>
                                            {{$leave->leaveType->name}}
                                            ({{\App\Http\Models\LeaveModel::$types[$leave->type_id]}})
                                        </div>
                                    @endif

                                    @if($rosters->count()==0 and !$leave)
                                        <div class="bg-info text-center">
                                            无数据
                                        </div>
                                    @endif

                                    <?php $sites = $employee->getAllSite($duty_date) ?>
                                    @if(count($sites) > 0)
                                        @foreach($sites as $site)
                                            @foreach($employee->getAllShift($site->site_id,$duty_date) as $shift)

                                                {{--attendance--}}
                                                @foreach($employee->getAttendance($site->site_id, $shift->shift_id, $duty_date) as $attendance)
                                                    <?php $shift = $attendance['in'] ? $attendance['in']->shift : $attendance['out']->shift ?>
                                                    <div>
                                                        <b>打卡记录:</b></br>
                                                        {{$shift->site->name}}<br>
                                                        {{--开始: {{\Carbon\Carbon::parse($shift->start_time)->format('H:i')}}--}}
                                                        {{--<br>--}}
                                                        {{--结束: {{$shift->getEndTime()->format('H:i')}}<br>--}}
                                                        {{--S.D: {{$shift->hour.' h'.($shift->mintue == 0?'':$shift->mintue.' m')}}--}}
                                                        {{--<br>--}}

                                                        <?php $in = $attendance['in'] ? \Carbon\Carbon::parse($attendance['in']->date_time) : ''?>
                                                        <?php $out = $attendance['out'] ? \Carbon\Carbon::parse($attendance['out']->date_time) : ''?>
                                                        开始:
                                                        @if($attendance['in'])
                                                            <?php $shift_date_time = \Carbon\Carbon::parse($in->format('Y-m-d') . ' ' . $shift->start_time) ?>
                                                            <?php $different = $shift_date_time->diffInMinutes($in) ?>
                                                            @if($shift_date_time >= $in)
                                                                {{$in->format('H:i')}}
                                                                [提早:{{$different}}分]
                                                            @else
                                                                <span class="text-red"
                                                                      style="text-decoration: underline">{{$in->format('H:i')}}
                                                                    [迟到:{{$different}}分]
                                                            </span>
                                                            @endif

                                                        @else
                                                            <b class="text-primary">无数据</b>
                                                        @endif
                                                        <br>
                                                        结束:

                                                        @if($attendance['out'])
                                                            <?php $out_date = \Carbon\Carbon::parse($out->format('Y-m-d')) ?>
                                                            <?php $shift_date_time = \Carbon\Carbon::parse($out->format('Y-m-d') . ' ' . $shift->getEndTime()->format('H:i:s')) ?>
                                                            <?php $different = $shift_date_time->diffInMinutes($out) ?>
                                                            @if($shift_date_time > $out)
                                                                <span class="text-red"
                                                                      style="text-decoration: underline">{{$out->format('H:i')}}
                                                                    [提早:{{$different}}分]
                                                            </span>
                                                            @else
                                                                {{$out->format('H:i')}}
                                                                [迟到:{{$different}}分]
                                                            @endif
                                                            {{$out_date>$start_date?'[N]':''}}
                                                        @else
                                                            <b class="text-primary">无数据</b>
                                                        @endif

                                                        <br>
                                                        时长:
                                                        @if($attendance['out'] and $attendance['in'])
                                                            <?php
                                                            $diff_hour = $in->diffInHours($out);
                                                            $diff_minute = $in->diffInMinutes($out) % 60;
                                                            ?>
                                                            @if($diff_hour >= $shift->hour or ($diff_hour == $shift->hour and $diff_minute >= $shift->mintue))
                                                                <?php $color = '';$style = '' ?>

                                                            @else
                                                                <?php $color = 'text-danger';$style = 'text-decoration: underline;background:yellow' ?>
                                                            @endif
                                                            <span class="{{$color}}" style="{{$style}}">
                                                                 {{$diff_hour.' '.$diff_minute.' 分'}}
                                                            </span>
                                                        @endif

                                                        {{--<br>--}}
                                                        {{--in: {{$in}}--}}
                                                        {{--<br>--}}
                                                        {{--out: {{$out}}--}}

                                                    </div>
                                                @endforeach
                                            @endforeach
                                        @endforeach
                                    @else

                                    @endif
                                </td>
                            @endfor
                        </tr>

                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>

    </section><!-- /.content -->

@endsection


@section('js')
    <script src="{{asset('js/select2.min.js')}}"></script>
    <script>
        $('#data_table').DataTable({
            dom: 'T<"clear">lfrtip<"clear spacer">T',
            tableTools: {
                "sSwfPath": "/swf/copy_csv_xls_pdf.swf"
            },
            tableTools: {
                "aButtons": ["copy", "csv", "print"]
            },
            "bPaginate": false,
            "bLengthChange": false
        });

        getWeeks()

        function getWeeks() {
            $("#week").empty();
            var year = $("#year").val()
            var selected_week = '{{$selected_week}}';
            var current_week = '{{$current_week}}';
            $.post("/api/web/get_weeks",
                {
                    year: year
                },
                function (data) {
                    obj = JSON.parse(data);
                    $.each(obj, function (i, item) {
                        var sel = document.getElementById('week');
                        var opt = document.createElement('option');
                        opt.value = item.week_number; // set value property of opt
                        var text_note = 'Week ' + item.week_number + ' ' + item.monday + '-' + item.sunday;
                        if (item.week_number == selected_week) {
                            opt.setAttribute("selected", "selected")
                        }
                        if (item.week_number == current_week) {
                            text_note = text_note + ' C';
                        }
                        opt.appendChild(document.createTextNode(text_note));

                        sel.appendChild(opt); // add opt to end of select box (sel)
                    });


                });
        }

        getSite()
        function getSite() {
            $("#site").empty();
            $.post("/attendance/weekly/getSiteAPI",
                {
                    department_id: $("#department").val(),
                    _token: '{{csrf_token()}}'
                },
                function (data) {
                    obj = JSON.parse(data);
                    if (obj.length == 0) {
                        alert('No site for selected department.')
                    }
                    $.each(obj, function (i, item) {
                        var sel = document.getElementById('site');
                        var opt = document.createElement('option');
                        opt.value = item.site_id; // set value property of opt
                        var text_note = item.name;
                        if (item.site_id == '{{$selected_site}}') {
                            opt.setAttribute("selected", "selected")
                        }
                        opt.appendChild(document.createTextNode(text_note));
                        sel.appendChild(opt); // add opt to end of select box (sel)
                    });
                });
        }
        $('.select2').select2({
            placeholder: "Select Employees",
        });
        function changeLeave(attendance_id) {
            $('#leave_' + attendance_id).show();
        }
        $('#tab_attendance').addClass('active');
        $('#tab_attendance_weekly').addClass('active');
    </script>
@endsection