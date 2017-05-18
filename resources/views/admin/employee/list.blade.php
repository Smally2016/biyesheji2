@extends('layout')

@section('header')
    <title>员工职位列表</title>
    @endsection

    @section('body')

            <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            员工职位
            <small>列表</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> 首页</a></li>
            <li><a href="/admin/employee/title/list">员工职位</a></li>
            <li class="active">列表</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-body">

                <table id="user_table" class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>员工职位</th>
                        <th>备注</th>
                        <th>编辑</th>
                        <th>删除</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($titles as $title)
                        <tr>
                            <th>{{$title->name}}</th>
                            <th>{{$title->remark}}</th>
                            <th>
                                <a href="/admin/employee/title/edit/{{$title->title_id}}" class="btn btn-xs btn-warning">编辑</a>
                            </th>
                            <th>
                                <a href="/admin/employee/title/delete/{{$title->title_id}}" class="btn btn-xs btn-danger delete">删除</a>
                            </th>
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
            $('#user_table').DataTable({

            });
        });

        $('.delete').click(function () {
            return confirm("确定删除?");
        });

        $('#tab_admin_employee_title').addClass('active');
        $('#tab_admin_employee_title_list').addClass('active');
    </script>
@endsection