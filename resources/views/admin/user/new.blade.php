@extends('layout')
@section('header')
    <title>WAOS | User Create</title>
    @endsection
    @section('body')


            <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            User
            <small>New</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="/admin/user/list">User</a></li>
            <li class="active">New</li>
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
                            <label for="username">Username</label>
                            <input type="text" class="form-control" id="username" required name="username"
                                   value="{{old('username')}}" minlength="3">
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" required name="name"
                                   value="{{old('name')}}">
                        </div>
                        <div class="form-group  col-sm-6">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{old('email')}}">
                        </div>
                        <div class="form-group  col-sm-6">
                            <label for="mobile">Mobile</label>
                            <input type="text" class="form-control" id="mobile" name="phone" value="{{old('phone')}}">
                        </div>
                        <div class="form-group  col-sm-6">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" required name="password"
                                   value="{{old('password')}}" minlength="6">
                        </div>
                        <div class="form-group  col-sm-6">
                            <label for="confirm_password">Confirm Password</label>
                            <input type="password" class="form-control" id="confirm_password" required
                                   name="confirm_password" value="{{old('confirm_password')}}" minlength="6">
                        </div>
                        <div class="form-group col-sm-12">
                            <label>Remark</label>
                            <textarea class="form-control" rows="3" name="remark">{{old('remark')}}</textarea>
                        </div>
                        <div class="form-group col-sm-2">
                            <label>Role</label>
                            <select class="form-control" name="is_admin" required>
                                @foreach(\App\Http\Models\UserModel::$roles as $key=>$value)
                                    <option value="{{$key}}">{{$value}}</option>
                                @endforeach
                            </select>
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
    <script>
        $('#tab_admin_user').addClass('active');
        $('#tab_admin_user_new').addClass('active');
    </script>
@endsection