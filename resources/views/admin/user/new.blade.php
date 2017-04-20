@extends('layout')
@section('header')
    <title>WAOS | User Create</title>
    @endsection
    @section('body')


            <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            管理员
            <small>新增</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> 首页</a></li>
            <li><a href="/admin/user/list">管理员</a></li>
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
                            <label for="username">登录账号</label>
                            <input type="text" class="form-control" id="username" required name="username"
                                   value="{{old('username')}}" minlength="3">
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="name">姓名</label>
                            <input type="text" class="form-control" id="name" required name="name"
                                   value="{{old('name')}}">
                        </div>
                        <div class="form-group  col-sm-6">
                            <label for="email">邮箱</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{old('email')}}">
                        </div>
                        <div class="form-group  col-sm-6">
                            <label for="mobile">手机号</label>
                            <input type="text" class="form-control" id="mobile" name="phone" value="{{old('phone')}}">
                        </div>
                        <div class="form-group  col-sm-6">
                            <label for="password">密码</label>
                            <input type="password" class="form-control" id="password" required name="password"
                                   value="{{old('password')}}" minlength="6">
                        </div>
                        <div class="form-group  col-sm-6">
                            <label for="confirm_password">确认密码</label>
                            <input type="password" class="form-control" id="confirm_password" required
                                   name="confirm_password" value="{{old('confirm_password')}}" minlength="6">
                        </div>
                        <div class="form-group col-sm-12">
                            <label>备注</label>
                            <textarea class="form-control" rows="3" name="remark">{{old('remark')}}</textarea>
                        </div>
                        <div class="form-group col-sm-2">
                            <label>角色</label>
                            <select class="form-control" name="is_admin" required>
                                @foreach(\App\Http\Models\UserModel::$roles as $key=>$value)
                                    <option value="{{$key}}">{{$value}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div><!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary center-block">新建</button>
                    </div>
                </form>
            </div><!-- /.box-body -->
        </div><!-- /.box -->

    </section><!-- /.content -->

@endsection


@section('js')
    <script>
        $('#tab_admin_user').addClass('active');
        $('#tab_admin_user_new').addClass('active');
    </script>
@endsection