@extends('layout')

@section('header')
    <title>部门</title>
@endsection

@section('body')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{$department->name}}
            <small>Manage</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="/admin/department">Department</a></li>
            <li class="active">List</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Link A User</h3>
            </div>
            <div class="box-body">
                <form role="form" method="post">
                    {{csrf_field()}}
                    <input type="hidden" name="department_id" value="{{$department->department_id}}">
                    <div class="form-group col-xs-9">
                        <select class="form-control" name="user_id">
                            @foreach($users as $user)
                                <option value="{{$user->user_id}}">{{$user->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-xs-3">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
            <!-- /.box-body -->
        </div>

        <!-- Default box -->
        <div class="box">
            <div class="box-header">
                <h4>User</h4>
            </div>
            <div class="box-body">

                <table class="table table-bordered table-hover data_table">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Remove</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($department->users as $user)
                        <tr>
                            <td>{{$user->name}}</td>
                            <td>
                                <a href="/admin/department/{{$department->department_id}}/user/{{$user->user_id}}/delete/"
                                   class="btn btn-xs btn-danger delete_button">Remove</a>
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
    <script>
        $(function () {
            $('.data_table').DataTable({
                aLengthMenu: [
                    [25, 50, 100, 200, -1],
                    [25, 50, 100, 200, "All"]
                ],
                iDisplayLength: -1
            });
        });


        $('.delete_button').click(function () {
            return confirm("Are you sure to Remove?");
        });


        $('#tab_admin_department').addClass('active');
        $('#tab_admin_department_list').addClass('active');
    </script>
@endsection