@extends('layouts.admin')

@section('content')

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
            <form>
                <div class="col-md-6">
                    <fieldset>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('name', 'Name', ['class' => 'control-label text-semibold']) !!}
                                    {!! Form::input('text', 'name', $coupon->name, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('type', 'Value', ['class' => 'control-label text-semibold']) !!}
                                    {!! Form::input('text', 'value', $coupon->value, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('expired_at', 'Expiry Date', ['class' => 'control-label text-semibold']) !!}
                            <div class="input-group">
                                <span class="input-group-addon"><i class="icon-calendar22"></i></span>
                                {!! Form::input('date', 'expired_at', null, ['class' => 'form-control daterange-single', 'readonly' => 'readonly']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="display-block text-semibold">Single use</label>
                            <label class="checkbox-inline">
                                <div class="checker">
                            <span class="checked">
                                {!! Form::checkbox('single_use', $coupon->single_use, $coupon->single_use ? true : false, ['class' => 'form-control', 'disabled' => 'disabled']) !!}
                            </span>
                                </div>
                                Featured
                            </label>

                        </div>
                        <div class="form-group">
                            {!! Form::label('emails', 'Emails', ['class' => 'control-label text-semibold']) !!}
                            {!! Form::input('text', 'emails', $coupon->emails_list, ['class' => 'form-control tokenfield', 'readonly' => 'readonly']) !!}
                        </div>
                    </fieldset>
                </div>
                <div class="col-md-6">
                    <fieldset>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('magnitude', 'Magnitude', ['class' => 'control-label text-semibold']) !!}
                                    {!! Form::input('text', 'magnitude', $coupon->magnitude, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('type', 'Type', ['class' => 'control-label text-semibold']) !!}
                                    {!! Form::input('text', 'type', $coupon->type, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('minimum_cart', 'Minimum Cart', ['class' => 'control-label text-semibold']) !!}
                                    {!! Form::input('number', 'minimum_cart', $coupon->minimum_cart, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('maximum_cart', 'Maximum Cart', ['class' => 'control-label text-semibold']) !!}
                                    {!! Form::input('number', 'maximum_cart', $coupon->maximum_cart, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('limit_usage_by_coupon', 'Limit Usage By Coupon', ['class' => 'control-label text-semibold']) !!}
                                    {!! Form::input('number', 'limit_usage_by_coupon', $coupon->limit_usage_by_coupon, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('limit_usage_by_user', 'Limit Usage By User', ['class' => 'control-label text-semibold']) !!}
                                    {!! Form::input('number', 'limit_usage_by_user', $coupon->limit_usage_by_user, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </form>
        </div>
    </div>

@endsection