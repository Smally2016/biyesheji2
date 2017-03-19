@extends('layout')
@section('header')
    <title>WAOS | New Reader</title>
    @endsection
    @section('body')

            <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Reader
            <small>New</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="/admin/reader/list">Reader</a></li>
            <li class="active">New</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box">
            <div class="box-body">
                <div class="flash-message">
                    @if ($errors->has())
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                {{ $error }} <br/>
                            @endforeach
                        </div>
                    @endif
                    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                        @if(Session::has($msg))
                            <p class="alert alert-{{ $msg }}">{{ Session::get($msg) }} </p>
                        @endif
                    @endforeach
                </div> <!-- end .flash-message -->
                <form role="form-horizontal" method="post">
                    {{csrf_field()}}
                    <div class="box-body">
                        <div class="form-group col-sm-offset-2 col-sm-8">
                            <label>New Reader ID</label>
                            <input type="number" class="form-control" id="reader_id" name="reader_id"
                                   value="{{old('reader_id')}}" required>
                        </div>
                        <div class="form-group col-sm-offset-2 col-sm-8">
                            <label>New Reader Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{old('name')}}"
                                   required>
                        </div>
                        <div class="form-group col-sm-offset-2 col-sm-8">
                            <label>Attach to Site</label>
                            <select class="form-control" name="site_id">
                                @foreach(\App\Http\Models\SiteModel::orderBy('name','asc')->get() as $site)
                                    <option value="{{$site->site_id}}">{{$site->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-sm-offset-2 col-sm-8">
                            <label>Remark</label>
                            <textarea class="form-control" rows="3" name="remark">{{old('remark')}}</textarea>
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
        $('#tab_admin_reader').addClass('active');
        $('#tab_admin_reader_new').addClass('active');
    </script>
@endsection