@extends('layout')
@section('header')
    <title></title>
    @endsection
    @section('body')
            <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Reader
            <small>Edit</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="/admin/leave/type/list">Reader</a></li>
            <li class="active">Edit</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-body">
                <form role="form-horizontal" method="post">
                    {{csrf_field()}}
                    <div class="box-body">
                        <div class="form-group col-sm-offset-2 col-sm-8">
                            <label>Reader ID</label>
                            <input type="text" class="form-control" id="name" name="reader_id" value="{{$reader->reader_id}}" readonly>
                        </div>

                        <div class="form-group col-sm-offset-2 col-sm-8">
                            <label>Reader Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{$reader->name}}"
                                   required>
                        </div>

                        <div class="form-group col-sm-offset-2 col-sm-8">
                            <label>Attach to Site</label>
                            <select class="form-control" name="site_id">
                                @foreach(\App\Http\Models\SiteModel::orderBy('name','asc')->get() as $site)
                                    <option value="{{$site->site_id}}" {{$site->site_id == $reader->site_id?'selected':''}}>{{$site->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-sm-offset-2 col-sm-8">
                            <label>Remark</label>
                            <textarea class="form-control" rows="3" name="remark">{{$reader->remark}}</textarea>
                        </div>
                    </div><!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary center-block">Update</button>
                    </div>
                </form>
            </div><!-- /.box-body -->
        </div><!-- /.box -->


    </section><!-- /.content -->

@endsection


@section('js')
    <script>
        $('#tab_admin_reader').addClass('active');
        $('#tab_admin_reader_list').addClass('active');
    </script>
@endsection