@extends('layout')
@section('header')
    <title>系统管理员编辑</title>
@endsection
@section('body')


    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            管理员
            <small>编辑</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> 首页</a></li>
            <li><a href="/admin/user/list">管理员</a></li>
            <li class="active">编辑</li>
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
                                   value="{{$user->username}}" minlength="3">
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="name">姓名</label>
                            <input type="text" class="form-control" id="name" required name="name"
                                   value="{{$user->name}}">
                        </div>
                        <div class="form-group  col-sm-6">
                            <label for="email">邮箱</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{$user->email}}">
                        </div>
                        <div class="form-group  col-sm-6">
                            <label for="mobile">手机号</label>
                            <input type="text" class="form-control" id="mobile" name="phone" value="{{$user->phone}}">
                        </div>
                        <div class="form-group col-sm-12">
                            <label>备注</label>
                            <textarea class="form-control" rows="3" name="remark">{{$user->remark}}</textarea>
                        </div>
                        <div class="form-group col-sm-2">
                            <label>角色</label>
                            <select class="form-control" name="is_admin" required>
                                @foreach(\App\Http\Models\UserModel::$roles as $key=>$value)
                                    <option value="{{$key}}" {{$user->is_admin == $key?'selected':''}}>{{$value}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group  col-sm-6" style="clear: both">
                            <label for="password">新密码</label>
                            <input type="password" class="form-control" id="password" name="password" value="" readonly onfocus="this.removeAttribute('readonly');">
                        </div>

                    </div><!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary center-block">保存</button>
                    </div>
                </form>
            </div><!-- /.box-body -->
        </div><!-- /.box -->

    </section><!-- /.content -->


    <!-- Modal -->
    <div id="passwordModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Change Password</h4>
                </div>
                <form role="form" method="post">
                    <div class="modal-body">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="password" class="col-sm-3 control-label">New Password</label>
                            <div class="col-sm-9">
                                <input type="password" class="form-control" id="password" name="password">
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary center-block" data-dismiss="modal">Apply</button>

                    </div>
                </form>
            </div>

        </div>
    </div>
@endsection


@section('js')
    <script>
        $('#tab_admin_user').addClass('active');
        $('#tab_admin_user_list').addClass('active');
    </script>
@endsection