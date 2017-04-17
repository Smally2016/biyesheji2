@extends('layout')

@section('header')
    <title>WAOS | Roster</title>
    <link rel="stylesheet" href="{{asset('css/select2.min.css')}}">
@endsection

@section('body')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Roster
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Roster</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-body">
                <form role="form" method="get">
                    {{csrf_field()}}
                    <div class="box-body">
                        <div class="form-group col-sm-6">
                            <label> Year:</label>
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
                        <div class="form-group col-sm-6">
                            <label> Week:</label>
                            <select class="form-control" name="week" id="week">

                            </select>
                        </div>
                        <div class="form-group col-sm-6">
                            <label> Site:</label>
                            <select class="form-control" name="site_id">
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

                    </div><!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary center-block">Generate</button>

                    </div>
                </form>
            </div><!-- /.box-body -->
        </div><!-- /.box -->

    @foreach($shifts as $shift)
        <!-- Default box -->
            <div class="box">
                <div class="box-header">
                    Shift: <b>{{$shift->getName()}}</b> Department: <b>{{$shift->department->name}}</b> Site:
                    <b>{{$shift->site->name}}</b>

                </div>
                <div class="box-body">
                    <table class="table table-striped table-hover table-responsive">
                        <thead>
                        <tr>
                            <th>S/NO</th>
                            <th>NRIC</th>
                            <th>Name</th>
                            <th>Title</th>
                            <?php $start_date = \Carbon\Carbon::parse(date('Y-m-d', strtotime($selected_year . "-W" . $selected_week . "-" . 1)))->addDay(-1) ?>
                            @for($i = 0; $i < 7; $i++)
                                <th>{{$start_date->addDay(1)->format('d/m')}}({{$start_date->format('D')}})</th>
                            @endfor
                        </tr>
                        </thead>
                        <tbody>
                        <?php $count = 0 ?>
                        @foreach($shift->employees as $employee)
                            <tr>
                                <td>{{$count += 1}}</td>
                                <td>{{$employee->employee->nric}}</td>
                                <td>{{$employee->employee->name}}</td>
                                <td>{{$employee->employee->title->name}}</td>
                                <?php $start_date = \Carbon\Carbon::parse(date('Y-m-d', strtotime($selected_year . "-W" . $selected_week . "-" . 1)))->addDay(-1) ?>
                                @for($i = 0; $i < 7; $i++)
                                    <?php $start_date->addDay(1) ?>

                                    <td class="roster"
                                        data-shift="{{$shift->shift_id}}"
                                        data-employee="{{$employee->employee_id}}"
                                        data-name="{{$employee->employee->name}}"
                                        data-date="{{$start_date->format('Y-m-d')}}">

                                        @foreach($employee->rosters as $roster)
                                            @if($roster->date == $start_date->format('Y-m-d'))
                                                <h4 style="margin: 0"><span
                                                            id="work_{{$shift->shift_id}}_{{$employee->employee_id}}_{{$start_date->format('Y-m-d')}}"
                                                            class="label label-success work text-center center-block">
                                                Work
                                            </span></h4>
                                            @endif
                                        @endforeach

                                        @foreach($employee->leaves as $leave)
                                            @if($leave->date == $start_date->format('Y-m-d'))
                                                <h4 style="margin: 0" data-toggle="tooltip" data-placement="top"
                                                    title="{{$leave->remark}}"><span
                                                            id="leave_{{$shift->shift_id}}_{{$employee->employee_id}}_{{$start_date->format('Y-m-d')}}"
                                                            class="label label-danger leave text-center center-block">
                                                {{$leave->leaveType->name}}
                                                        ({{\App\Http\Models\LeaveModel::$types[$leave->type_id]}})
                                            </span>
                                                </h4>
                                            @endif
                                        @endforeach
                                    </td>
                                @endfor
                            </tr>

                        @endforeach
                        </tbody>
                    </table>
                </div><!-- /.box-body -->
                <div class="box-footer">
                    <form method="post" action="/roster/roster/add">
                        {{csrf_field()}}
                        <input type="hidden" name="shift_id" value="{{$shift->shift_id}}">
                        <input type="hidden" name="year" value="{{$selected_year}}">
                        <input type="hidden" name="week" value="{{$selected_week}}">
                        <div class="col-sm-3">
                            <select class="form-control select2" name="employee_id">
                                @foreach($shift->department->getCurrentEmployees as $employee)
                                    <option value="{{$employee->employee_id}}">{{$employee->name}} {{$employee->nric}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-1">
                            <button type="submit" class="btn btn-primary">Add</button>
                        </div>
                    </form>
                </div>
            </div><!-- /.box -->
        @endforeach
    </section><!-- /.content -->

    <!-- Modal -->
    <div id="addModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <form action="/roster/roster/add/workOrLeave" method="post">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Add work/leave</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="radio">
                                <label>
                                    <input type="radio" name="type" id="optionsRadios1" value="leave" checked
                                           onchange="$('#work_form').hide();$('#leave_form').show()">
                                    Leave
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="type" id="optionsRadios2" value="work"
                                           onchange="$('#work_form').show();$('#leave_form').hide()">
                                    Work
                                </label>
                            </div>
                            {{csrf_field()}}
                            <input type="hidden" id="employee_id" name="employee_id">
                            <input type="hidden" id="shift_id" name="shift_id">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" readonly>
                            </div>
                            <div class="form-group">
                                <label for="date">Date</label>
                                <input type="text" class="form-control" id="date" name="date" readonly>
                            </div>
                            <div id="work_form" hidden>
                            </div>
                            <div id="leave_form">

                                <div class="form-group">
                                    <label> Leave Period:</label>
                                    <select class="form-control" name="type_id">
                                        @foreach(\App\Http\Models\LeaveModel::$types_full as $key=>$name)
                                            <option value="{{$key}}">{{$name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label> Leave Type:</label>
                                    <select class="form-control" name="leave_type_id">
                                        @foreach($leave_types as $leave)
                                            <option value="{{$leave->leave_type_id}}">{{$leave->name}} {{$leave->remark==''?'':'('.$leave->remark.')'}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Remark</label>
                                    <textarea class="form-control" rows="3" id="remark" name="remark"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary center-block">Apply</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
@endsection


@section('js')
    <script src="{{asset('js/select2.min.js')}}"></script>
    <script>
        getWeeks()
        function getWeeks() {
            $("#week").empty();
            var year = $("#year").val()
            var selected_week = '{{$selected_week}}'
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
        var shift_id = '';
        var employee_id = '';
        var date = '';
        var name = '';

        $(".work").hover(
                function () {
                    $(this).append('<a class="btn btn-xs btn-danger" onclick="cancelWork()"><span class="fa fa-times"></span></a>');
                }, function () {
                    $(this).find("a:last").remove();
                }
        );
        $(".leave").hover(
                function () {
                    $(this).append('<a class="btn btn-xs btn-warning" onclick="cancelLeave()"><span class="fa fa-times"></span></a>');
                }, function () {
                    $(this).find("a:last").remove();
                }
        );
        $(".roster").hover(
                function () {
                    shift_id = $(this).data('shift')
                    employee_id = $(this).data('employee')
                    date = $(this).data('date')
                    name = $(this).data('name')
                    $(this).append($("<span class='add'><br><button class='btn btn-xs btn-primary center-block'  data-toggle='modal' data-target='#addModal' onclick='addWork()'> Add </button></span>"));
                }, function () {
                    $('.add').remove();
                }
        );

        function cancelWork() {
            $.ajax({
                url: "/roster/roster/delete/work",
                data: {
                    shift_id: shift_id,
                    employee_id: employee_id,
                    date: date,
                    _token: '{{csrf_token()}}'
                },
                type: 'post',
                success: function (data, status) {
                    if (data == '1') {
                        $('#work_' + shift_id + '_' + employee_id + '_' + date).remove();
                    } else {
                        alert('Delete Failed.')
                    }
                }
            });
        }

        function cancelLeave() {
            $.ajax({
                url: "/roster/roster/delete/leave",
                data: {
                    shift_id: shift_id,
                    employee_id: employee_id,
                    date: date,
                    _token: '{{csrf_token()}}'
                },
                type: 'post',
                success: function (data, status) {
                    if (data == '1') {
                        $('#leave_' + shift_id + '_' + employee_id + '_' + date).remove();
                    } else {
                        alert('Delete Failed.')
                    }
                }
            });
        }

        function addWork() {
            $('#name').val(name);
            $('#shift_id').val(shift_id);
            $('#employee_id').val(employee_id);
            $('#date').val(date);
            $('#remark').val('');
        }

        $('.select2').select2();
        $('#tab_roster').addClass('active');
        $('#tab_roster_roster').addClass('active');
    </script>
@endsection