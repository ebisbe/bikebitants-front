@extends('admin.admin')

@section('content')

    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title">Product</h5>
            <div class="heading-elements">
                <ul class="icons-list">
                    <li><a data-action="collapse" class=""></a></li>
                </ul>
            </div>
        </div>
        <div class="panel-body">
            <form class="form-horizontal">

                
            <div class="form-group">
                {!! Form::label('name', trans('product.name'), ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::input('text', 'name', $product->name, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('slug', trans('product.slug'), ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::input('text', 'slug', $product->slug, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('status', trans('product.status'), ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::input('number', 'status', $product->status, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('introduction', trans('product.introduction'), ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::input('textarea', 'introduction', $product->introduction, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('description', trans('product.description'), ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::input('textarea', 'description', $product->description, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('meta_title', trans('product.meta_title'), ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::input('text', 'meta_title', $product->meta_title, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('meta_description', trans('product.meta_description'), ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::input('text', 'meta_description', $product->meta_description, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('meta_slug', trans('product.meta_slug'), ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::input('text', 'meta_slug', $product->meta_slug, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                </div>
            </div>

            </form>
        </div>
    </div>

@endsection