@extends('layout')

@section('header')
    <title>WAOS | Reader List</title>
@endsection

@section('body')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Reader
        <small>List</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="/admin/reader/list">Reader</a></li>
        <li class="active">List</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

    <!-- Default box -->
    <div class="box">
        <div class="box-body">
            <table id="data_table" class="table table-strip table-hover">
                <thead>
                <tr>
                    <th>Reader ID</th>
                    <th>Name</th>
                    <th>Remarks</th>
                    <th>Assigned to Site</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
                </thead>
                <tbody>
                @foreach($readers as $reader)
                <tr>
                    <td>{{$reader->reader_id}}</td>
                    <td>{{$reader->name}}</td>
                    <td>{{$reader->remark}}</td>
                    <td>{{$reader->site->name}}</td>
                    <td>
                        <a href="/admin/reader/edit/{{$reader->reader_id}}" class="btn btn-xs btn-warning" target="_blank">Edit</a>
                    </td>
                    <td>
                        <a href="/admin/reader/delete/{{$reader->reader_id}}" class="btn btn-xs btn-danger delete_button" onclick="">Delete</a>
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
            $('#data_table').DataTable({

                aLengthMenu: [
                    [25, 50, 100, 200, -1],
                    [25, 50, 100, 200, "All"]
                ],
                iDisplayLength: -1
            });
        });
        $('.delete_button').on('click', function () {
            return confirm('Confirm Delete Reader?');
        });

        $('#tab_admin_reader').addClass('active');
        $('#tab_admin_reader_list').addClass('active');
    </script>
@endsection