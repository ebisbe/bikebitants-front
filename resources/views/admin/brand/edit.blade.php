@extends('admin.admin')

@section('content')

    @if ($errors->any())
        <ul class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title">Brand</h5>
            <div class="heading-elements">
                <ul class="icons-list">
                    <li><a data-action="collapse" class=""></a></li>
                </ul>
            </div>
        </div>
        <div class="panel-body">
            {!! Form::model($brand, [
                'method' => 'PATCH',
                'url' => ['brand', $brand->_id],
                'class' => 'form-horizontal',
                'files' => true
            ]) !!}

            <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                {!! Form::label('name', 'Name', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required']) !!}
                    {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="form-group {{ $errors->has('slug') ? 'has-error' : ''}}">
                {!! Form::label('slug', 'Slug', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::text('slug', null, ['class' => 'form-control']) !!}
                    {!! $errors->first('slug', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
                {!! Form::label('description', 'Description', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::textarea('description', null, ['class' => 'form-control', 'required' => 'required']) !!}
                    {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="form-group {{ $errors->has('filename') ? 'has-error' : ''}}">
                {!! Form::label('filename', 'Brand Image', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-lg-6">
                    <div class="media no-margin-top">
                        <div class="media-left">
                            <a href="#">
                                <img src="/img/58/{{ $brand->filename }}"
                                     style="width: 58px; height: 58px;"
                                     class="img-rounded" alt="">
                            </a>
                        </div>

                        <div class="media-body">
                            <div class="uploader bg-warning">
                                {!! Form::file('filename', ['class' => 'form-control file-styled', 'required' => 'required']) !!}
                            </div>
                            <span class="help-block">Accepted formats: gif, png, jpg. Max file size 2Mb</span>
                            {!! $errors->first('filename', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group {{ $errors->has('is_featured') ? 'has-error' : ''}}">
                {!! Form::label('is_featured', 'Featured', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-lg-6">
                    <label class="radio-inline">
                        {!! Form::radio('is_featured', '1', null, ['class' => 'styled']) !!}
                        Yes
                    </label>

                    <label class="radio-inline">
                        {!! Form::radio('is_featured', '0', true, ['class' => 'styled']) !!}
                        No
                    </label>
                </div>
                {!! $errors->first('is_featured', '<p class="help-block">:message</p>') !!}
            </div>
            <div class="form-group {{ $errors->has('meta_title') ? 'has-error' : ''}}">
                {!! Form::label('meta_title', 'Meta Title', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::text('meta_title', null, ['class' => 'form-control', 'required' => 'required']) !!}
                    {!! $errors->first('meta_title', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="form-group {{ $errors->has('meta_description') ? 'has-error' : ''}}">
                {!! Form::label('meta_description', 'Meta Description', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::textarea('meta_description', null, ['class' => 'form-control', 'required' => 'required']) !!}
                    {!! $errors->first('meta_description', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="form-group {{ $errors->has('meta_slug') ? 'has-error' : ''}}">
                {!! Form::label('meta_slug', 'Meta Keywords', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::text('meta_slug', null, ['class' => 'form-control', 'required' => 'required']) !!}
                    {!! $errors->first('meta_slug', '<p class="help-block">:message</p>') !!}
                </div>
            </div>


            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-3">
                    {!! Form::submit('Update', ['class' => 'btn btn-primary form-control']) !!}
                </div>
            </div>
            {!! Form::close() !!}

        </div>
    </div>

@endsection