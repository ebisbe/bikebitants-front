@extends('layouts.admin')

@section('content')

    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title">Faq</h5>
            <div class="heading-elements">
                <ul class="icons-list">
                    <li><a data-action="collapse" class=""></a></li>
                </ul>
            </div>
        </div>
        <div class="panel-body">
            <form class="form-horizontal">

                
            <div class="form-group">
                {!! Form::label('name', 'Name', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::input('text', 'name', $faq->name, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('answer', 'Answer', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::input('textarea', 'answer', $faq->answer, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                </div>
            </div>

            </form>
        </div>
    </div>

@endsection