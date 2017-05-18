@extends('layout')
@section('header')
    <title>新增工作时间段</title>
    <link rel="stylesheet" href="{{asset('css/select2.min.css')}}">

    @endsection
@section('body')


<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        工作时间段
        <small>新增</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> 首页</a></li>
        <li><a href="/shift/list">工作时间段</a></li>
        <li class="active">新增</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

    <!-- Default box -->
    <div class="box">
        <div class="box-body">
            @if ($errors->has())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        {{ $error }} <br/>
                    @endforeach
                </div>
            @endif
            <div class="flash-message">
                @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                    @if(Session::has($msg))
                        <p class="alert alert-{{ $msg }}">{{ Session::get($msg) }} </p>
                    @endif
                @endforeach
            </div> <!-- end .flash-message -->
            <form role="form" method="post">
                {{csrf_field()}}
                <div class="box-body">
                    <div class="form-group col-sm-6">
                        <label>部门</label>
                        <select class="form-control" name="department_id" required id="department" onclick="getSite()">
                            @foreach($departments as $department)
                                <option value="{{$department->department_id}}">{{$department->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-sm-6">
                        <label>工作地点</label>
                        <select class="form-control" name="site_id" required id="site">

                        </select>
                    </div>
                    <div class="form-group  col-sm-6">
                        <label for="start_time">开始时间</label>
                        <input type="time" class="form-control" id="start_time" name="start_time" value="{{old('start_time')}}" required>
                    </div>

                    <div class="form-group  col-sm-3">
                        <label for="hour">工作时间(小时)</label>
                        <input type="number" class="form-control" id="hour" name="hour" value="{{old('hour')}}" min="0" max=24 required>
                    </div>
                    <div class="form-group  col-sm-3">
                        <label for="minute">工作时间(分钟)</label>
                        <input type="number" class="form-control" id="minute" name="minute" value="{{old('minute')}}" min=0 max=59>
                    </div>

                    <div class="form-group col-sm-12">
                        <label>备注</label>
                        <textarea class="form-control" rows="3" name="remark">{{old('remark')}}</textarea>
                    </div>
                </div><!-- /.box-body -->

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary center-block">创建</button>
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
        $(document).ready(function($){
            $(".date_input").inputmask("99/99/9999",{placeholder:"dd/mm/yyyy"});
        });

        $('.select2').select2();

        getSite()
        function getSite() {
            $("#site").empty();
            $.post("/record/manual/get_site",
                    {
                        department_id: $("#department").val(),
                        _token: '{{csrf_token()}}'
                    },
                    function (data) {
                        obj = JSON.parse(data);
                        if (obj.length == 0) {
                            alert('No site able to choose for selected employee.')
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

        $('#tab_shift').addClass('active');
        $('#tab_shift_new').addClass('active');
    </script>
@endsection