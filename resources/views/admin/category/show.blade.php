@extends('admin.admin')

@section('content')

    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title">Category</h5>
            <div class="heading-elements">
                <ul class="icons-list">
                    <li><a data-action="collapse" class=""></a></li>
                </ul>
            </div>
        </div>
        <div class="panel-body">
            <form>
                <div class="col-md-6">
                    <fieldsed>
                        <div class="form-group">
                            {!! Form::label('name', 'Name', ['class' => 'col-sm-3 control-label']) !!}
                            {!! Form::input('text', 'name', $category->name, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('slug', 'Slug', ['class' => 'col-sm-3 control-label']) !!}
                            {!! Form::input('text', 'slug', $category->slug, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('products', 'Total products', ['class' => 'col-sm-3 control-label']) !!}
                            {!! Form::input('number', 'products', $category->products, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                        </div>
                    </fieldsed>
                </div>
                <div class="col-md-6">
                    <fieldsed>
                        <div class="form-group">
                            {!! Form::label('filename', 'Image') !!}
                            <div>
                                <img src="/img/300/{{ $category->filename }}" alt="{{ $category->name }}">
                            </div>
                        </div>
                    </fieldsed>
                </div>

            </form>
        </div>
    </div>
    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title">Meta information</h5>
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
                        {!! Form::input('text', 'meta_title', $category->meta_title, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('meta_description', 'Meta Description', ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-6">
                        {!! Form::textarea('meta_description', $category->meta_description, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('meta_slug', 'Meta Keywords', ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-6">
                        {!! Form::input('text', 'meta_slug', $category->meta_slug, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                    </div>
                </div>

            </form>
        </div>
    </div>

@endsection