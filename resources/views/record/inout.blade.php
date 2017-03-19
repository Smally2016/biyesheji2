@extends('layout')

@section('header')
    <title>WAOS | Record</title>
    @endsection

    @section('body')

            <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Record
            <small>In/Out Report</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="/attendance/weekly">Record</a></li>
            <li class="active">In/Out Report</li>
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
                            <label> Department:</label>
                            <select class="form-control" name="location_id">
                                <option value="0">All Department</option>
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

                        <div class="form-group col-sm-6">
                            <label> Site:</label>
                            <select class="form-control" name="location_id">
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

                    </div><!-- /.box-body -->

                    <div class="box-footer">
                        <button type="button" class="btn btn-primary center-block">Generate</button>

                    </div>
                </form>
            </div><!-- /.box-body -->
        </div><!-- /.box -->

        <!-- Default box -->
        <div class="box">
            <div class="box-body">
                <table class="table table-striped table-hover " id="data_table">
                    <thead>
                    <tr>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Employee ID</th>
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

        $('#data_table').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true,
            "scrollX": true
        });


        getWeeks()
        function getWeeks() {
            $("#week").empty();
            var year = $("#year").val()
            var selected_week = {{$selected_week}}
                    $.post("/api/web/get_weeks",
                    {
                        year: year
                    },
                    function (data) {
                        obj = JSON.parse(data);
                        $.each(obj, function (i, item) {
                            var sel = document.getElementById('week');
                            var opt = document.createElement('option');
                            opt.appendChild(document.createTextNode('week ' + item.week_number + ' ' + item.monday + '-' + item.sunday));
                            opt.value = item.week_number; // set value property of opt
                            if (item.week_number == selected_week) {
                                opt.setAttribute("selected", "selected")
                            }
                            sel.appendChild(opt); // add opt to end of select box (sel)
                        });


                    });
        }
        $('#tab_attendance').addClass('active');
        $('#tab_attendance_weekly').addClass('active');
    </script>
@endsection