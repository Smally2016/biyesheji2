@extends('layout')
@section('header')
    <title>WAOS | New Employee</title>
    <link rel="stylesheet" href="{{asset('css/select2.min.css')}}">

    @endsection
    @section('body')


            <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            员工
            <small>新增</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> 首页</a></li>
            <li><a href="/employee/list">员工</a></li>
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
                            <label for="name">姓名 <span class="text-red">*</span></label>
                            <input type="text" class="form-control" id="name" required name="name"
                                   value="{{old('name')}}">
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="nric">身份证号 <span class="text-red">*</span></label>
                            <input type="text" class="form-control" id="nric" required name="nric"
                                   value="{{old('nric')}}">
                        </div>
                        <div class="form-group col-sm-2">
                            <label>生日 <span class="text-red">*</span></label>
                            <select class="form-control" name="day" required>
                                @for($i = 1; $i <= 31; $i++)
                                    <option value="{{$i}}">{{$i}}</option>
                                @endfor
                            </select>
                        </div>

                        <div class="form-group col-sm-2">
                            <label style="color: white">M</label>
                            <select class="form-control" name="month" required>
                                @for($i = 1; $i <= 12; $i++)
                                    <option value="{{$i}}">{{$i}}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="form-group col-sm-2">
                            <label style="color: white">Y</label>
                            <select class="form-control" name="year" required>
                                @for($i = date('Y')-16; $i >= date('Y')-86; $i--)
                                    <option value="{{$i}}">{{$i}}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="form-group col-sm-6">
                            <label>性别 <span class="text-red">*</span></label>
                            <select class="form-control" name="gender" required>
                                <option value="Male">男</option>
                                <option value="Female">女</option>
                            </select>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="id">员工ID</label>
                            <input type="text" class="form-control" id="id" required name="id">
                        </div>
                        <div class="form-group col-sm-6">
                            <label>国籍 <span class="text-red">*</span></label>
                            <select class="form-control select2" name="nationality" required>
                                @foreach(\App\Helpers\NationalHelper::$nationals as $nation)
                                    <option value="{{$nation}}">{{$nation}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-sm-6">
                            <label>城市 <span class="text-red">*</span></label>
                            <select class="form-control" name="citizenship" required>
                                @foreach(\App\Helpers\NationalHelper::$citizenships as $citi)
                                    <option value="{{$citi}}">{{$citi}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-sm-6">
                            <label>部门 <span class="text-red">*</span></label>
                            <select class="form-control" name="department_id" required>
                                @foreach($departments as $department)
                                    <option value="{{$department->department_id}}">{{$department->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-sm-6">
                            <label>职位 <span class="text-red">*</span></label>
                            <select class="form-control" name="title_id" required>
                                @foreach($titles as $title)
                                    <option value="{{$title->title_id}}">{{$title->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group  col-sm-6">
                            <label for="email">邮箱</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{old('email')}}">
                        </div>
                        <div class="form-group  col-sm-6">
                            <label for="phone">手机号</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="{{old('phone')}}">
                        </div>

                        <div class="form-group  col-sm-12">
                            <label for="address">地址</label>
                            <input type="text" class="form-control" id="address" name="address"
                                   value="{{old('address')}}">
                        </div>
                        <div class="form-group  col-sm-6">
                            <label for="address_postal">邮编</label>
                            <input type="text" class="form-control" id="address_postal" name="address_postal"
                                   value="{{old('address_postal')}}">
                        </div>

                        {{--<div class="form-group  col-sm-6" style="clear: left">--}}
                            {{--<label for="nok">Next of Kin's Name</label>--}}
                            {{--<input type="text" class="form-control" id="nok" name="nok" value="{{old('nok')}}">--}}
                        {{--</div>--}}

                        {{--<div class="form-group  col-sm-6">--}}
                            {{--<label for="nok_phone">Next of Kin's Contact</label>--}}
                            {{--<input type="text" class="form-control" id="nok_phone" name="nok_phone"--}}
                                   {{--value="{{old('nok_phone')}}">--}}
                        {{--</div>--}}

                        <div class="form-group col-sm-12">
                            <label>备注</label>
                            <textarea class="form-control" rows="3" name="remark">{{old('remark')}}</textarea>
                        </div>

                        <div class="form-group col-sm-6">
                            <label>开户银行</label>
                            <select class="form-control" name="bank" required>
                                @foreach(\App\Http\Models\EmployeeModel::$banks as $bank)
                                    <option value="{{$bank}}">{{$bank}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-sm-6">
                            <label>银行账号</label>
                            <input type="text" class="form-control" id="account" name="account">
                        </div>

                    </div><!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary center-block">Create</button>
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


        $('#tab_employee').addClass('active');
        $('#tab_employee_new').addClass('active');
    </script>
@endsection