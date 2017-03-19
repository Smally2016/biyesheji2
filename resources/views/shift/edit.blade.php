@extends('layout')
@section('header')
    <title>WAOS | Shift</title>
    <link rel="stylesheet" href="{{asset('css/select2.min.css')}}">

    @endsection
    @section('body')


            <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Shift
            <small>Edit</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="/shift/list">Shift</a></li>
            <li class="active">Edit</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-body">
            </div> <!-- end .flash-message -->
            <form role="form" method="post">
                {{csrf_field()}}
                <input type="hidden" name="shift_id" value="{{$shift->shift_id}}">
                <div class="box-body">
                    <div class="form-group col-sm-6">
                        <label>Department</label>
                        <select class="form-control" name="department_id" required>
                            @foreach($departments as $department)
                                <option value="{{$department->department_id}}" {{$department->department_id==$shift->department_id?'selected':''}}>{{$department->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-sm-6">
                        <label>Site</label>
                        <select class="form-control" name="site_id" required>
                            @foreach($sites as $site)
                                <option value="{{$site->site_id}}" {{$site->site_id==$shift->site_id?'selected':''}}>{{$site->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group  col-sm-6">
                        <label for="start_time">Start Time</label>
                        <input type="time" class="form-control" id="start_time" name="start_time"
                               value="{{$shift->start_time}}" required>
                    </div>

                    <div class="form-group  col-sm-3">
                        <label for="hour">Duration Hour</label>
                        <input type="number" class="form-control" id="hour" name="hour" value="{{$shift->hour}}" min="0"
                               max=24 required>
                    </div>
                    <div class="form-group  col-sm-3">
                        <label for="minute">Duration Minute</label>
                        <input type="number" class="form-control" id="minute" name="minute" value="{{$shift->minute}}"
                               min=0 max=59>
                    </div>

                    <div class="form-group col-sm-12">
                        <label>Remark</label>
                        <textarea class="form-control" rows="3" name="remark">{{$shift->remark}}</textarea>
                    </div>
                </div><!-- /.box-body -->

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary center-block">Update</button>
                </div>
            </form>
        </div><!-- /.box-body -->

        </div><!-- /.box -->

    </section><!-- /.content -->

@endsection


@section('js')
    <script src="{{asset('js/inputmask.js')}}"></script>
    <script src="{{asset('js/jquery.inputmask.js')}}"></script>
    <script src="{{asset('js/select2.min.js')}}"></script>

    <script>
        $(document).ready(function ($) {
            $(".date_input").inputmask("99/99/9999", {placeholder: "dd/mm/yyyy"});
        });

        $('.select2').select2();


        $('#tab_shift').addClass('active');
        $('#tab_shift_new').addClass('active');
    </script>
@endsection