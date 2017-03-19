@extends('layout')

@section('header')
    <title>WAOS | Site List</title>
@endsection

@section('body')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Site
        <small>List</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="/admin/site/list">Site</a></li>
        <li class="active">List</li>
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
                    <th>Site Name</th>
                    <th>Address</th>
                    <th>Postal Code</th>
                    <th>Remarks</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
                </thead>
                <tbody>
                @foreach($sites as $site)
                <tr>
                    <td>{{$site->name}}</td>
                    <td>{{$site->address}}</td>
                    <td>{{$site->postal}}</td>
                    <td>{{$site->remark}}</td>
                    <td>
                        <a href="/admin/site/edit/{{$site->site_id}}" class="btn btn-xs btn-warning" target="_blank">Edit</a>
                    </td>
                    <td>
                        <a href="/admin/site/delete/{{$site->site_id}}" class="btn btn-xs btn-danger delete_button" onclick="">Delete</a>
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

        $('.delete_button').on('click', function () {
            return confirm('Confirm Delete Site?');
        });
        $('#tab_admin_site').addClass('active');
        $('#tab_admin_site_list').addClass('active');
    </script>
@endsection