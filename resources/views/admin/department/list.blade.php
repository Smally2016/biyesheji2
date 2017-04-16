@extends('layout')

@section('header')
    <title>WAOS | Department List</title>
@endsection

@section('body')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            部门管理
            <small>列表</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> 首页</a></li>
            <li><a href="/admin/department">部门</a></li>
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
                        <th>部门名称</th>
                        <th>备注</th>
                        <th>员工</th>
                        <th>用户</th>
                        <th>所在地点</th>
                        <th>编辑</th>
                        <th>删除</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($departments as $department)
                        <tr>
                            <td>{{$department->name}}</td>
                            <td>{{$department->remark}}</td>
                            <td>{{$department->departmentEmployee()->count()}} </td>
                            <td>
                                <a href="/admin/department/manage_user/{{$department->department_id}}"
                                   style="text-decoration: underline">
                                    {{$department->departmentUser()->count()}}
                                </a>
                            </td>
                            <td>
                                <a href="/admin/department/manage_site/{{$department->department_id}}"
                                   style="text-decoration: underline">
                                    {{$department->departmentSite()->count()}}
                                </a>
                            </td>
                            <td>
                                <a href="/admin/department/edit/{{$department->department_id}}"
                                   class="btn btn-xs btn-warning" target="_blank">Edit</a>
                            </td>
                            <td>
                                <a href="/admin/department/delete/{{$department->department_id}}"
                                   class="btn btn-xs btn-danger delete">Delete</a>
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
            $('#user_table').DataTable({
                aLengthMenu: [
                    [25, 50, 100, 200, -1],
                    [25, 50, 100, 200, "All"]
                ],
                iDisplayLength: -1
            });
        });


        $('.delete').click(function () {
            return confirm("Are you sure to Delete?");
        });


        $('#tab_admin_department').addClass('active');
        $('#tab_admin_department_list').addClass('active');
    </script>
@endsection