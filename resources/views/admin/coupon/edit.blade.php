@extends('layouts.admin')

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
            <h5 class="panel-title">Coupon</h5>
            <div class="heading-elements">
                <ul class="icons-list">
                    <li><a data-action="collapse" class=""></a></li>
                </ul>
            </div>
        </div>
        <div class="panel-body">
            {!! Form::model($coupon, [
                'method' => 'PATCH',
                'url' => ['coupon', $coupon->_id],
            ]) !!}

            <div class="col-md-12">
                <fieldset>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                                {!! Form::label('name', 'Name', ['class' => 'control-label text-semibold']) !!}
                                {!! Form::input('text', 'name', null, ['class' => 'form-control']) !!}
                                {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group {{ $errors->has('type') ? 'has-error' : ''}}">
                                {!! Form::label('type', 'Value', ['class' => 'control-label text-semibold']) !!}
                                {!! Form::input('text', 'value', null, ['class' => 'form-control', 'readonly' => 'readonly', 'id' => 'value']) !!}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group {{ $errors->has('magnitude') ? 'has-error' : ''}}">
                                {!! Form::label('magnitude', 'Magnitude', ['class' => 'control-label text-semibold']) !!}
                                {!! Form::input('text', 'magnitude', null, ['class' => 'form-control touchspin', 'data-min-value' => -100000]) !!}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group {{ $errors->has('type') ? 'has-error' : ''}}">
                                {!! Form::label('type', 'Type', ['class' => 'control-label text-semibold']) !!}
                                {!! Form::select('type', $coupon->type_options, $coupon->type, ['class' => 'form-control', 'id' => 'type']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-grou {{ $errors->has('minimum_cart') ? 'has-error' : ''}}">
                                {!! Form::label('minimum_cart', 'Minimum Cart', ['class' => 'control-label text-semibold']) !!}
                                {!! Form::input('number', 'minimum_cart', null, ['class' => 'form-control touchspin']) !!}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group {{ $errors->has('maximum_cart') ? 'has-error' : ''}}">
                                {!! Form::label('maximum_cart', 'Maximum Cart', ['class' => 'control-label text-semibold']) !!}
                                {!! Form::input('number', 'maximum_cart', null, ['class' => 'form-control touchspin']) !!}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group {{ $errors->has('limit_usage_by_coupon') ? 'has-error' : ''}}">
                                {!! Form::label('limit_usage_by_coupon', 'Limit Usage By Coupon', ['class' => 'control-label text-semibold']) !!}
                                {!! Form::input('number', 'limit_usage_by_coupon', null, ['class' => 'form-control touchspin']) !!}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group {{ $errors->has('limit_usage_by_user') ? 'has-error' : ''}}">
                                {!! Form::label('limit_usage_by_user', 'Limit Usage By User', ['class' => 'control-label text-semibold']) !!}
                                {!! Form::input('number', 'limit_usage_by_user', null, ['class' => 'form-control touchspin']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group {{ $errors->has('expired_at') ? 'has-error' : ''}}">
                                {!! Form::label('expired_at', 'Expiry Date', ['class' => 'control-label text-semibold']) !!}
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="icon-calendar22"></i></span>
                                    {!! Form::input('date', 'expired_at', null, ['class' => 'form-control daterange-single']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group {{ $errors->has('single_use') ? 'has-error' : ''}}">
                                {!! Form::label('single_use', 'Single use', ['class' => 'control-label text-semibold display-block']) !!}
                                <label class="radio-inline">
                                    {!! Form::radio('single_use', '1', null, ['class' => 'styled']) !!}
                                    Yes
                                </label>

                                <label class="radio-inline">
                                    {!! Form::radio('single_use', '0', true, ['class' => 'styled']) !!}
                                    No
                                </label>
                                {!! $errors->first('single_use', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group {{ $errors->has('emails') ? 'has-error' : ''}}">
                                {!! Form::label('emails', 'Emails', ['class' => 'control-label text-semibold']) !!}
                                {!! Form::input('text', 'emails', $coupon->emails_list, ['class' => 'form-control tokenfield-email']) !!}
                                {!! $errors->first('emails', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-3">
                        {!! Form::submit('Update', ['class' => 'btn btn-primary form-control']) !!}
                    </div>
                </div>
            </div>
            {!! Form::close() !!}

        </div>
    </div>
    @stack('footer.scripts')
    <script type="text/javascript">
        $('document').ready(function(){
            var $magnitude = $('#magnitude');
            var $type = $('#type');

            var valueUpdate = function() {
                var magnitude = $magnitude.val();
                var type = $type.val();

                $('#value').val(magnitude + type);
            };

            $magnitude.change(valueUpdate);
            $type.change(valueUpdate);
        });
    </script>
    @endstack
@endsection