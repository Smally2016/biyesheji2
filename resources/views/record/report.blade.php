@extends('layout')

@section('header')
    <title>Check In/Out Report | ADP Center WAOS&trade;</title>
    <link rel="stylesheet" href="{{asset('css/buttons.dataTables.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/daterangepicker-bs3.css')}}">

    @endsection

    @section('body')

            <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            打卡记录
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> 首页</a></li>
            <li><a href="/record/report">打卡 </a></li>
            <li class="active">记录</li>
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
                        <label for="date_range">日期:</label>
                        <input type="text" class="form-control" id="date_range" required name="date_range"
                               value="{{$date_range}}"
                        >
                    </div>

                    <div class="form-group col-lg-offset-4 col-lg-4">
                        <label> 部门:</label>
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
                        <label> 工作地点:</label>
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
                                <input type="checkbox" name="status_record" {{$status_record}}>
                                隐藏已删除的报告
                            </label>
                        </div>
                    </div>
                    <div class="form-group col-lg-offset-4 col-lg-4">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="mode_record" {{$mode_record}}>
                                只展示打卡记录
                            </label>
                        </div>
                    </div>
                </div><!-- /.box-body -->

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary center-block">查找</button>

                </div>
            </form>
        </div><!-- /.box -->


        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"></h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i
                                class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i
                                class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                <table id="data_table" class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th class="col-md-1">日期</th>
                        <th class="col-md-1">时间</th>
                        <th class="col-md-1">员工ID</th>
                        <th class="col-md-2">身份证号</th>
                        <th class="col-md-1">姓名</th>
                        <th class="col-md-1">部门</th>
                        <th class="col-md-1">职位</th>
                        <th class="col-md-2">工作地点</th>
                        <th class="col-md-1">签退/签到</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($records as $record)
                        <tr>
                            <td>{{\Carbon\Carbon::parse($record->date_time)->format('d/m/Y')}}</td>
                            <td>{{\Carbon\Carbon::parse($record->date_time)->format('H:i:s')}}</td>
                            <td>{{$record->employee->id}}</td>
                            <td>{{$record->employee->nric}}</td>
                            <td>{{$record->employee->name}}</td>
                            <td>{{$record->department->name}}</td>
                            <td>{{$record->employee->title->name}}</td>
                            <td>{{$record->site->name}}</td>
                            <td>{{\App\Helpers\AttendanceHelper::$modes[$record->mode].($record->getStatus()?'('.$record->getStatus().')':'')}}</td>
                        </tr>

                    @endforeach

                    </tbody>
                </table>
            </div><!-- /.box-body -->
        </div><!-- /.box -->

    </section><!-- /.content -->

@endsection


@section('js')
    <script src="{{asset('js/datatables/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('js/datatables/buttons.flash.min.js')}}"></script>
    <script src="{{asset('js/datatables/jszip.min.js')}}"></script>
    <script src="{{asset('js/datatables/pdfmake.min.js')}}"></script>
    <script src="{{asset('js/datatables/vfs_fonts.js')}}"></script>
    <script src="{{asset('js/datatables/buttons.html5.min.js')}}"></script>
    <script src="{{asset('js/datatables/buttons.print.min.js')}}"></script>

    <script src="{{asset('js/moment.min.js')}}"></script>
    <script src="{{asset('js/daterangepicker.js')}}"></script>

    <script>
        $(function () {
            $('input[name="date_range"]').daterangepicker({
                "timePicker": true,
                "timePicker24Hour": true,
                "timePickerSeconds": true,
                "timePickerIncrement": 1,
                "locale": {
                    "format": "DD/MM/YYYY HH:mm:ss",
                }
            });

            $('#data_table').DataTable({
                dom: 'T<"clear">lfrtip',
                aLengthMenu: [
                    [25, 50, 100, 200, -1],
                    [25, 50, 100, 200, "All"]
                ],
                iDisplayLength: -1,

                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv',

                    {
                        extend: 'print',
                        customize: function ( win ) {
                            $(win.document.body)
                                    .css( 'padding', '1pt' )
                                    .prepend(
                                            '<img src="/image/login.jpg" style="position:absolute; top:0; left:0;" />'
                                    );

                            $(win.document.body).find( 'table' )

                            $(win.document.body).find( 'td' )
                                    .css( 'padding', '1pt' )
                                    .css( 'font-size', '10pt' )
                            $(win.document.body).find( 'th' )
                                    .css( 'padding', '1pt' )
                                    .css( 'font-size', '10pt' )

                        }
                    }

                ],

            });
        });

        $('#tab_record').addClass('active');
        $('#tab_record_report').addClass('active');
    </script>
@endsection