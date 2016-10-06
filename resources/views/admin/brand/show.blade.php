@extends('admin.admin')

@section('content')

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
            <form>
                <div class="col-md-6">
                    <fieldset>
                        <div class="form-group">
                            {!! Form::label('name', 'Name') !!}
                            {!! Form::input('text', 'name', $brand->name, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('slug', 'Slug') !!}
                            {!! Form::input('text', 'slug', $brand->slug, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('description', 'Description') !!}
                            {!! Form::textarea('description', $brand->description, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                        </div>
                    </fieldset>
                </div>
                <div class="col-md-6">
                    <fieldset>
                        <div class="form-group">
                            <label class="display-block text-semibold">Status</label>
                            <label class="checkbox-inline">
                                <div class="checker">
                                    <span class="checked">
                                        {!! Form::checkbox('is_featured', $brand->is_featured, $brand->is_featured ? true : false, ['class' => 'form-control', 'disabled' => 'disabled']) !!}
                                    </span>
                                </div>
                                Featured
                            </label>

                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    {!! Form::label('filename', 'Image') !!}
                                    <div>
                                        <img src="/img/300/{{ $brand->filename }}" alt="{{ $brand->name }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </fieldset>
                </div>

            </form>
        </div>
    </div>

    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title">Meta Information</h5>
            <div class="heading-elements">
                <ul class="icons-list">
                    <li><a data-action="collapse" class=""></a></li>
                </ul>
            </div>
        </div>
        <div class="panel-body">
            <form class="form-horizontal">

                <div class="form-group">
                    {!! Form::label('meta_title', 'Meta Title', ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-6">
                        {!! Form::input('text', 'meta_title', $brand->meta_title, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('meta_description', 'Meta Description', ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-6">
                        {!! Form::textarea('meta_description', $brand->meta_description, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('meta_slug', 'Meta Keywords', ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-6">
                        {!! Form::input('text', 'meta_slug', $brand->meta_slug, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                    </div>
                </div>

            </form>
        </div>
    </div>

@endsection