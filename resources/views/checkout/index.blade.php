@extends('layouts.checkout')

@section('content')
    <section class="content account">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <article class="account-content checkout-steps">
                        {!! Form::open() !!}

                        <div class="row row-no-padding">
                            <div class="col-xs-6 col-sm-4">
                                <div class="checkout-step active">
                                    <div class="number">1</div>
                                    <div class="title">@lang('checkout.step1')</div>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-4">
                                <div class="checkout-step">
                                    <div class="number">2</div>
                                    <div class="title">@lang('checkout.step2')</div>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-4">
                                <div class="checkout-step">
                                    <div class="number">3</div>
                                    <div class="title">@lang('checkout.step3')</div>
                                </div>
                            </div>
                        </div>

                        <div class="progress checkout-progress hidden-xs">
                            <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0"
                                 aria-valuemax="100" style="width:0;"></div>
                        </div>

                        <div class="row">
                            <div id="js-shipping" class="col-sm-8 ">
                                <h3>@lang('checkout.billing_information')</h3>
                                <div class="products-order checkout billing-information">
                                    {{--<button class="btn btn-primary addresses-toggle" type="button"
                                            data-toggle="collapse"
                                            data-target="#my-addresses-billing" aria-expanded="false"
                                            aria-controls="my-addresses-billing">My Saved Addresses
                                    </button>
                                    <div id="my-addresses-billing" class="collapse">
                                        <div class="table-responsive border">
                                            <table class="table table-bordered">
                                                <tr>
                                                    <th>Company</th>
                                                    <th>Name</th>
                                                    <th>Address</th>
                                                    <th>Country</th>
                                                    <th>Phone</th>
                                                    <th></th>
                                                </tr>
                                                <tr>
                                                    <td>Apple Inc.</td>
                                                    <td>John Doe</td>
                                                    <td>16, Main street 2nd floor 75002 Paris</td>
                                                    <td>France</td>
                                                    <td>+420 123 456 789</td>
                                                    <td><a class="btn btn-primary btn-sm">Select</a></td>
                                                </tr>
                                                <tr>
                                                    <td>Microsoft Corporation</td>
                                                    <td>John Doe</td>
                                                    <td>16, Main street 2nd floor 33133 Miami</td>
                                                    <td>United States</td>
                                                    <td>+420 123 456 789</td>
                                                    <td><a class="btn btn-primary btn-sm">Select</a></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>--}}

                                    <div class="row">
                                        <div class="form-group col-sm-6 {{ $errors->has('billing.first_name') ? 'has-error' : ''}}">
                                            {{ Form::label('billing[first_name]', trans('checkout.first_name').' <span class="required">*</span>', [], false) }}
                                            {{ Form::text('billing[first_name]', null, ['class' => 'form-control']) }}
                                            {!! $errors->first('billing.first_name', '<p class="help-block">:message</p>') !!}
                                        </div>
                                        <div class="form-group col-sm-6 {{ $errors->has('billing.last_name') ? 'has-error' : ''}}">
                                            {{ Form::label('billing[last_name]', trans('checkout.last_name').' <span class="required">*</span>', [], false) }}
                                            {{ Form::text('billing[last_name]', null, ['class' => 'form-control']) }}
                                            {!! $errors->first('billing.last_name', '<p class="help-block">:message</p>') !!}
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="form-group col-sm-6 {{ $errors->has('billing.email') ? 'has-error' : ''}}">
                                            {{ Form::label('billing[email]', trans('checkout.email_address').' <span class="required">*</span>', [], false) }}
                                            {{ Form::text('billing[email]', null, ['class' => 'form-control']) }}
                                            {!! $errors->first('billing.email', '<p class="help-block">:message</p>') !!}
                                        </div>
                                        <div class="form-group col-sm-6 {{ $errors->has('billing.phone') ? 'has-error' : ''}}">
                                            {{ Form::label('billing[phone]', trans('checkout.phone').' <span class="required">*</span>', [], false) }}
                                            {{ Form::text('billing[phone]', null, ['class' => 'form-control']) }}
                                            {!! $errors->first('billing.phone', '<p class="help-block">:message</p>') !!}
                                        </div>
                                        <div class="form-group col-sm-12 {{ $errors->has('billing.address_1') ? 'has-error' : ''}}">
                                            {{ Form::label('billing[address_1]', trans('checkout.address_1').' <span class="required">*</span>', [], false) }}
                                            {{ Form::text('billing[address_1]', null, ['class' => 'form-control']) }}
                                        </div>
                                        <div class="form-group col-sm-12 {{ $errors->has('billing.address_1') ? 'has-error' : ''}}">
                                            {{ Form::text('billing[address_2]', null, ['class' => 'form-control']) }}
                                            {!! $errors->first('billing.address_1', '<p class="help-block">:message</p>') !!}
                                        </div>
                                        <div class="form-group col-sm-6 {{ $errors->has('billing.city') ? 'has-error' : ''}}">
                                            {{ Form::label('billing[city]', trans('checkout.city').' <span class="required">*</span>', [], false) }}
                                            {{ Form::text('billing[city]', null, ['class' => 'form-control']) }}
                                            {!! $errors->first('billing.city', '<p class="help-block">:message</p>') !!}
                                        </div>
                                        <div class="form-group col-sm-6 {{ $errors->has('billing.postcode') ? 'has-error' : ''}}">
                                            {{ Form::label('billing[postcode]', trans('checkout.postcode').' <span class="required">*</span>', [], false) }}
                                            {{ Form::text('billing[postcode]', null, ['class' => 'form-control']) }}
                                            {!! $errors->first('billing.postcode', '<p class="help-block">:message</p>') !!}
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="form-group col-sm-6 {{ $errors->has('billing.country') ? 'has-error' : ''}}">
                                            {{ Form::label('billing[country]', trans('checkout.country').' <span class="required">*</span>', [], false) }}
                                            {{ Form::select('billing[country]', $countries, 'ES', ['class' => 'form-control js-country']) }}
                                            {!! $errors->first('billing.country', '<p class="help-block">:message</p>') !!}
                                        </div>
                                        <div class="form-group col-sm-6  {{ $errors->has('billing.state') ? 'has-error' : ''}}">
                                            {{ Form::label('billing[state]', trans('checkout.state').' <span class="required">*</span>', [], false) }}
                                            {{ Form::select('billing[state]', $states, 'B', ['class' => 'form-control js-change']) }}
                                            {!! $errors->first('billing.state', '<p class="help-block">:message</p>') !!}
                                        </div>
                                    </div>
                                </div>

                                <h3>@lang('checkout.shipping_information')</h3>
                                <div class="products-order checkout shipping-information">
                                    <div class="checkbox">
                                        {!! Form::checkbox('check_shipping', 'true', true, ['id' => 'check_shipping']) !!}
                                        {{ Form::label('check_shipping', trans('checkout.same_billing_address'), [
                                            'data-target' => "#shipping-address-collapse",
                                            'aria-controls' => "shipping-address-collapse",
                                            'aria-expanded' => "false",
                                            'data-toggle' => "collapse",
                                        ], false) }}
                                    </div>
                                    @push('footer.scripts')
                                    <script type="text/javascript">
                                        $(document).ready(function () {
                                            if ($('#check_shipping:checked').length == '0') {
                                                $('#shipping-address-collapse').addClass('in');
                                            }
                                        });
                                    </script>
                                    @endpush
                                    <div id="shipping-address-collapse" class="collapse">

                                        {{--<button class="btn btn-primary addresses-toggle" type="button"
                                                data-toggle="collapse" data-target="#my-addresses-shipping"
                                                aria-expanded="false" aria-controls="my-addresses-shipping">My Saved
                                            Addresses
                                        </button>
                                        <div id="my-addresses-shipping" class="collapse">
                                            <div class="table-responsive border">
                                                <table class="table table-bordered">
                                                    <tr>
                                                        <th>Company</th>
                                                        <th>Name</th>
                                                        <th>Address</th>
                                                        <th>Country</th>
                                                        <th>Phone</th>
                                                        <th></th>
                                                    </tr>
                                                    <tr>
                                                        <td>Apple Inc.</td>
                                                        <td>John Doe</td>
                                                        <td>16, Main street 2nd floor 75002 Paris</td>
                                                        <td>France</td>
                                                        <td>+420 123 456 789</td>
                                                        <td><a class="btn btn-primary btn-sm">Select</a></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Microsoft Corporation</td>
                                                        <td>John Doe</td>
                                                        <td>16, Main street 2nd floor 33133 Miami</td>
                                                        <td>United States</td>
                                                        <td>+420 123 456 789</td>
                                                        <td><a class="btn btn-primary btn-sm">Select</a></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>--}}

                                        <div class="row">
                                            <div class="form-group col-sm-6 {{ $errors->has('shipping.first_name') ? 'has-error' : ''}}">
                                                {{ Form::label('shipping[first_name]', trans('checkout.first_name').' <span class="required">*</span>', [], false) }}
                                                {{ Form::text('shipping[first_name]', null, ['class' => 'form-control']) }}
                                                {!! $errors->first('shipping.first_name', '<p class="help-block">:message</p>') !!}
                                            </div>
                                            <div class="form-group col-sm-6 {{ $errors->has('shipping.last_name') ? 'has-error' : ''}}">
                                                {{ Form::label('shipping[last_name]', trans('checkout.last_name').' <span class="required">*</span>', [], false) }}
                                                {{ Form::text('shipping[last_name]', null, ['class' => 'form-control']) }}
                                                {!! $errors->first('shipping.last_name', '<p class="help-block">:message</p>') !!}
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="form-group col-sm-6 {{ $errors->has('shipping.email') ? 'has-error' : ''}}">
                                                {{ Form::label('shipping[email]', trans('checkout.email_address').' <span class="required">*</span>', [], false) }}
                                                {{ Form::text('shipping[email]', null, ['class' => 'form-control']) }}
                                                {!! $errors->first('shipping.email', '<p class="help-block">:message</p>') !!}
                                            </div>
                                            <div class="form-group col-sm-6 {{ $errors->has('shipping.company') ? 'has-error' : ''}}">
                                                {{ Form::label('shipping[company]', trans('checkout.company'), []) }}
                                                {{ Form::text('shipping[company]', null, ['class' => 'form-control']) }}
                                                {!! $errors->first('shipping.company', '<p class="help-block">:message</p>') !!}
                                            </div>
                                            <div class="form-group col-sm-12 {{ $errors->has('shipping.address_1') ? 'has-error' : ''}}">
                                                {{ Form::label('shipping[address_1]', trans('checkout.address_1').' <span class="required">*</span>', [], false) }}
                                                {{ Form::text('shipping[address_1]', null, ['class' => 'form-control']) }}
                                            </div>
                                            <div class="form-group col-sm-12 {{ $errors->has('shipping.address_1') ? 'has-error' : ''}}">
                                                {{ Form::text('shipping[address_2]', null, ['class' => 'form-control']) }}
                                                {!! $errors->first('shipping.address_1', '<p class="help-block">:message</p>') !!}
                                            </div>
                                            <div class="form-group col-sm-6 {{ $errors->has('shipping.city') ? 'has-error' : ''}}">
                                                {{ Form::label('shipping[city]', trans('checkout.city').' <span class="required">*</span>', [], false) }}
                                                {{ Form::text('shipping[city]', null, ['class' => 'form-control']) }}
                                                {!! $errors->first('shipping.city', '<p class="help-block">:message</p>') !!}
                                            </div>
                                            <div class="form-group col-sm-6 {{ $errors->has('shipping.postcode') ? 'has-error' : ''}}">
                                                {{ Form::label('shipping[postcode]', trans('checkout.postcode').' <span class="required">*</span>', [], false) }}
                                                {{ Form::text('shipping[postcode]', null, ['class' => 'form-control']) }}
                                                {!! $errors->first('shipping.postcode', '<p class="help-block">:message</p>') !!}
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="form-group col-sm-6 {{ $errors->has('shipping.phone') ? 'has-error' : ''}}">
                                                {{ Form::label('shipping[phone]', trans('checkout.phone').' <span class="required">*</span>', [], false) }}
                                                {{ Form::text('shipping[phone]', null, ['class' => 'form-control']) }}
                                                {!! $errors->first('shipping.phone', '<p class="help-block">:message</p>') !!}
                                            </div>
                                            <div class="form-group col-sm-6 {{ $errors->has('shipping.fax') ? 'has-error' : ''}}">
                                                {{ Form::label('shipping[fax]', trans('checkout.fax'), [], false) }}
                                                {{ Form::text('shipping[fax]', null, ['class' => 'form-control']) }}
                                                {!! $errors->first('shipping.fax', '<p class="help-block">:message</p>') !!}
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="form-group col-sm-6 {{ $errors->has('shipping.country') ? 'has-error' : ''}}">
                                                {{ Form::label('shipping[country]', trans('checkout.country').' <span class="required">*</span>', [], false) }}
                                                {{ Form::select('shipping[country]', $countries, 'ES', ['class' => 'form-control']) }}
                                                {!! $errors->first('shipping.country', '<p class="help-block">:message</p>') !!}
                                            </div>
                                            <div class="form-group col-sm-6 {{ $errors->has('shipping.state') ? 'has-error' : ''}}">
                                                {{ Form::label('shipping[state]', trans('checkout.state').' <span class="required">*</span>', [], false) }}
                                                {{ Form::select('shipping[state]', $states, 'B', ['class' => 'form-control']) }}
                                                {!! $errors->first('shipping.state', '<p class="help-block">:message</p>') !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="col-sm-4">
                                <h3>@lang('checkout.cart')</h3>
                                <div class="products-order shopping-cart ">
                                    <div class="table-responsive">
                                        <table class="table table-products">
                                            <thead>
                                            <tr>
                                                <th>@lang('cart.product')</th>
                                                <th>@lang('cart.subtotal')</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($items as $item)
                                                <tr>
                                                    <td class="col-xs-4 col-md-5">
                                                        <h4>{{ $item['name'] }}
                                                            <small> {{ $item['attributes']['brand'] }}
                                                                @foreach($item->attributes->properties as $attribute)
                                                                    , {{ $attribute }}
                                                                @endforeach
                                                            </small>
                                                        </h4>
                                                    </td>
                                                    <td class="col-xs-2 text-center">
                                                        <small>
                                                            {{ $item->getPriceWithConditions() }}{{ $item['attributes']['currency'] }}
                                                            x {{ $item->quantity }}</small>
                                                        <span>
                                                            <b>{{ $item->getPriceSumWithConditions() }}{{ $item['attributes']['currency'] }}</b>
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                        <total-checkout
                                                country="ES"
                                                state="B"
                                        ></total-checkout>
                                    </div>
                                </div>

                                <h3>@lang('cart.discount_code')</h3>
                                <div class="products-order checkout payment-method">
                                    <div class="payment-methods {{ $errors->has('coupon') ? 'has-error' : ''}}">
                                        {{ Form::label('coupon', trans('cart.enter_coupon_code'), [], false) }}
                                        {{ Form::text('coupon', null, ['class' => 'form-control']) }}
                                        {!! $errors->first('coupon', '<p class="help-block">:message</p>') !!}
                                    </div>
                                </div>

                                <h3>@lang('checkout.payment_methods')</h3>
                                <div class="products-order checkout payment-method">
                                    <div id="payment-methods" class="{{ $errors->has('payment') ? 'has-error' : ''}}">
                                        @foreach($paymentMethods as $payment)
                                            <div class="panel radio">
                                                {{ Form::radio('payment', $payment->slug, null, ['id' => $payment->slug]) }}
                                                {{ Form::label($payment->slug, $payment->name) }}
                                            </div>
                                        @endforeach
                                        {!! $errors->first('payment', '<p class="help-block">:message</p>') !!}

                                    </div>
                                </div>
                                <div class="clearfix">
                                    <div class="checkbox pull-left {{ $errors->has('checkout-terms-conditions') ? 'has-error' : ''}}">
                                        {{ Form::checkbox('checkout-terms-conditions', null, false, ['id' => 'checkout-terms-conditions']) }}
                                        {{ Form::label('checkout-terms-conditions', trans('checkout.read_and_aggree_terms', ['route' => route('terms_conditions')]), [], false) }}
                                        {!! $errors->first('checkout-terms-conditions', '<p class="help-block">:message</p>') !!}
                                    </div>
                                    <button type="submit"
                                            class="btn btn-primary btn-lg pull-right">@lang('checkout.confirm_order')</button>
                                </div>
                            </div>
                        </div>
                        {!! Form::close() !!}

                    </article>
                </div>
            </div>
        </div>
    </section>

@endsection