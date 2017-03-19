@extends('layout')
@section('header')
    <title>WAOS | Record</title>
    <link rel="stylesheet" href="{{asset('css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/daterangepicker-bs3.css')}}">
    @endsection

    @section('body')

            <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Record
            <small>Manual Check In/Out</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="/record/">Record</a></li>
            <li class="active">Manual Check In/Out</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <form role="form" method="post" action="/record/manual/new">
                {{csrf_field()}}
                <div class="box-body">

                    <div class="form-group col-lg-offset-4 col-lg-4">
                        <label> Employee:</label>
                        <select class="form-control  select2" name="employee_id" id="employee" onchange="getSite()">
                            @foreach($employees as $employee)
                                <option value="{{$employee->employee_id}}">{{$employee->name}} ({{$employee->nric}})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-lg-offset-4 col-lg-4">
                        <label for="date_time">Check In/Out Date Time:</label>
                        <input type="text" class="form-control" id="date_time" required name="date_time">
                    </div>

                    <div class="form-group col-lg-offset-4 col-lg-4">
                        <label> Site:</label>
                        <select class="form-control" name="site_id" required id="site" onchange="getShift()">

                        </select>
                    </div>

                    <div class="form-group col-lg-offset-4 col-lg-4">
                        <label for="duty">Duty Date:</label>
                        <input type="text" class="form-control" id="duty_date" required name="duty_date">
                    </div>
                    <div class="form-group col-lg-offset-4 col-lg-4">
                        <label> Shift:</label>
                        <select class="form-control" name="shift_id" required id="shift">

                        </select>
                    </div>
                    <div class="form-group col-lg-offset-4 col-lg-4">
                        <label> Mode:</label>
                        <select class="form-control" name="mode">
                            @foreach(\App\Helpers\AttendanceHelper::$modes as $key => $mode))
                            <option value="{{$key}}">{{$mode}}</option>
                            @endforeach
                        </select>
                    </div>
                </div><!-- /.box-body -->

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary center-block">Insert</button>

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
                        <th>Employee ID</th>
                        <th>NRIC</th>
                        <th>Name</th>
                        <th>Department</th>
                        <th>Site</th>
                        <th>Duty Date</th>
                        <th>Shift</th>
                        <th>In / Out</th>
                        <th>Delete</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($records as $record)
                        <tr>
                            <td>{{\Carbon\Carbon::parse($record->date_time)->format('d/m/Y H:i:s')}}</td>
                            <td>{{$record->employee->id}}</td>
                            <td>{{$record->employee->nric}}</td>
                            <td>{{$record->employee->name}}</td>
                            <td>{{$record->department->name}}</td>
                            <td>{{$record->site->name}}</td>
                            <td>{{\Carbon\Carbon::parse($record->duty_date)->format('d/m/Y')}}</td>
                            <td>{{$record->shift->getName()}}</td>
                            <td>{{\App\Helpers\AttendanceHelper::$modes[$record->mode]}}</td>


                            <td>
                                <a href="/record/manual/delete/{{$record->attendance_id}}" class="btn btn-xs"><span
                                            class="fa fa-trash text-red delete_button"></span></a>
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
    <script src="{{asset('js/select2.min.js')}}"></script>
    <script src="{{asset('js/daterangepicker.js')}}"></script>
    <script>
        $('#date_time').daterangepicker({
            "autoApply": true,
            "singleDatePicker": true,
            "timePicker": true,
            "timePicker24Hour": true,
            "timePickerSeconds": true,
            "locale": {
                "format": "DD/MM/YYYY HH:mm:ss",
                "firstDay": 1
            },
            "linkedCalendars": false,
        });

        $('#duty_date').daterangepicker({
            singleDatePicker: true,
            "locale": {
                "format": "DD/MM/YYYY",
                firstDay: 1,
            }
        });
        getSite()
        function getSite() {
            $("#site").empty();
            $.post("/record/manual/get_site_with_employee",
                    {
                        employee_id: $("#employee").val(),
                        _token: '{{csrf_token()}}'
                    },
                    function (data) {
                        obj = JSON.parse(data);
                        if (obj.length == 0) {
                            //alert('No site able to choose for selected employee.')
                        }
                        $.each(obj, function (i, item) {
                            var sel = document.getElementById('site');
                            var opt = document.createElement('option');
                            opt.value = item.site_id; // set value property of opt
                            var text_note = item.name;
                            opt.appendChild(document.createTextNode(text_note));
                            sel.appendChild(opt); // add opt to end of select box (sel)
                        });
                        getShift()
                    });
        }

        function getShift() {
            $("#shift").empty();
            $.post("/record/manual/get_shift_with_employee",
                    {
                        site_id: $("#site").val(),
                        employee_id: $("#employee").val(),
                        _token: '{{csrf_token()}}'
                    },
                    function (data) {
                        obj = JSON.parse(data);
                        if (obj.length == 0) {
                            //alert('No shift able to choose for selected site.')
                        }
                        $.each(obj, function (i, item) {
                            var sel = document.getElementById('shift');
                            var opt = document.createElement('option');
                            opt.value = item.shift_id; // set value property of opt
                            var text_note = item.name;
                            opt.appendChild(document.createTextNode(text_note));
                            sel.appendChild(opt); // add opt to end of select box (sel)
                        });
                    });
        }
        $('.select2').select2();


        $('.delete_button').click(function () {
            return confirm("Are you sure to Delete?");
        });

        $('#tab_record').addClass('active');
        $('#tab_record_manual').addClass('active');
    </script>
@endsection