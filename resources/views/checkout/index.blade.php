@extends('layouts.shop')

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
                                    <div class="title">Billing & Shipping Address</div>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-4">
                                <div class="checkout-step">
                                    <div class="number">2</div>
                                    <div class="title">Payment</div>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-4">
                                <div class="checkout-step">
                                    <div class="number">3</div>
                                    <div class="title">Confirmation</div>
                                </div>
                            </div>
                        </div>

                        <div class="progress checkout-progress hidden-xs">
                            <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0"
                                 aria-valuemax="100" style="width:0;"></div>
                        </div>

                        <div class="row">
                            <div class="col-sm-8">
                                <h3>Billing Information</h3>
                                <div class="products-order checkout billing-information">
                                    <button class="btn btn-primary addresses-toggle" type="button"
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
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-sm-6 {{ $errors->has('billing.first_name') ? 'has-error' : ''}}">
                                            {{ Form::label('billing[first_name]', 'First name <span class="required">*</span>', [], false) }}
                                            {{ Form::text('billing[first_name]', null, ['class' => 'form-control']) }}
                                            {!! $errors->first('billing.first_name', '<p class="help-block">:message</p>') !!}
                                        </div>
                                        <div class="form-group col-sm-6 {{ $errors->has('billing.last_name') ? 'has-error' : ''}}">
                                            {{ Form::label('billing[last_name]', 'Last name <span class="required">*</span>', [], false) }}
                                            {{ Form::text('billing[last_name]', null, ['class' => 'form-control']) }}
                                            {!! $errors->first('billing.last_name', '<p class="help-block">:message</p>') !!}
                                        </div>
                                        <div class="form-group col-sm-6 {{ $errors->has('billing.email') ? 'has-error' : ''}}">
                                            {{ Form::label('billing[email]', 'Email address <span class="required">*</span>', [], false) }}
                                            {{ Form::text('billing[email]', null, ['class' => 'form-control']) }}
                                            {!! $errors->first('billing.email', '<p class="help-block">:message</p>') !!}
                                        </div>
                                        <div class="form-group col-sm-6 {{ $errors->has('billing.company') ? 'has-error' : ''}}">
                                            {{ Form::label('billing[company]', 'Company', []) }}
                                            {{ Form::text('billing[company]', null, ['class' => 'form-control']) }}
                                            {!! $errors->first('billing.company', '<p class="help-block">:message</p>') !!}
                                        </div>
                                        <div class="form-group col-sm-12 {{ $errors->has('billing.address') ? 'has-error' : ''}}">
                                            {{ Form::label('billing[address]', 'Address <span class="required">*</span>', [], false) }}
                                            {{ Form::text('billing[address]', null, ['class' => 'form-control']) }}
                                        </div>
                                        <div class="form-group col-sm-12 {{ $errors->has('billing.address') ? 'has-error' : ''}}">
                                            {{ Form::text('billing[address_2]', null, ['class' => 'form-control']) }}
                                            {!! $errors->first('billing.address', '<p class="help-block">:message</p>') !!}
                                        </div>
                                        <div class="form-group col-sm-6 {{ $errors->has('billing.city') ? 'has-error' : ''}}">
                                            {{ Form::label('billing[city]', 'City <span class="required">*</span>', [], false) }}
                                            {{ Form::text('billing[city]', null, ['class' => 'form-control']) }}
                                            {!! $errors->first('billing.city', '<p class="help-block">:message</p>') !!}
                                        </div>
                                        <div class="form-group col-sm-6 {{ $errors->has('billing.postal_code') ? 'has-error' : ''}}">
                                            {{ Form::label('billing[postal_code]', 'ZIP / Postal Code <span class="required">*</span>', [], false) }}
                                            {{ Form::text('billing[postal_code]', null, ['class' => 'form-control']) }}
                                            {!! $errors->first('billing.postal_code', '<p class="help-block">:message</p>') !!}
                                        </div>
                                        <div class="form-group col-sm-6 {{ $errors->has('billing.country') ? 'has-error' : ''}}">
                                            {{ Form::label('billing[country]', 'Country <span class="required">*</span>', [], false) }}
                                            {{ Form::select('billing[country]', $countries, 'ES', ['class' => 'form-control']) }}
                                            {!! $errors->first('billing.country', '<p class="help-block">:message</p>') !!}
                                        </div>
                                        <div class="form-group col-sm-6 {{ $errors->has('billing.phone') ? 'has-error' : ''}}">
                                            {{ Form::label('billing[phone]', 'Phone <span class="required">*</span>', [], false) }}
                                            {{ Form::text('billing[phone]', null, ['class' => 'form-control']) }}
                                            {!! $errors->first('billing.phone', '<p class="help-block">:message</p>') !!}
                                        </div>
                                    </div>
                                </div>

                                <h3>Shipping Information</h3>
                                <div class="products-order checkout shipping-information">
                                    <div class="checkbox">
                                        {!! Form::checkbox('check_shipping', 'true', true, ['id' => 'check_shipping']) !!}
                                        {{ Form::label('check_shipping', 'My delivery and billing addresses are the same.', [
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

                                        <button class="btn btn-primary addresses-toggle" type="button"
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
                                        </div>

                                        <div class="row">
                                            <div class="form-group col-sm-6 {{ $errors->has('shipping.first_name') ? 'has-error' : ''}}">
                                                {{ Form::label('shipping[first_name]', 'First name <span class="required">*</span>', [], false) }}
                                                {{ Form::text('shipping[first_name]', null, ['class' => 'form-control']) }}
                                                {!! $errors->first('shipping.first_name', '<p class="help-block">:message</p>') !!}
                                            </div>
                                            <div class="form-group col-sm-6 {{ $errors->has('shipping.last_name') ? 'has-error' : ''}}">
                                                {{ Form::label('shipping[last_name]', 'Last name <span class="required">*</span>', [], false) }}
                                                {{ Form::text('shipping[last_name]', null, ['class' => 'form-control']) }}
                                                {!! $errors->first('shipping.last_name', '<p class="help-block">:message</p>') !!}
                                            </div>
                                            <div class="form-group col-sm-6 {{ $errors->has('shipping.email') ? 'has-error' : ''}}">
                                                {{ Form::label('shipping[email]', 'Email address <span class="required">*</span>', [], false) }}
                                                {{ Form::text('shipping[email]', null, ['class' => 'form-control']) }}
                                                {!! $errors->first('shipping.email', '<p class="help-block">:message</p>') !!}
                                            </div>
                                            <div class="form-group col-sm-6 {{ $errors->has('shipping.company') ? 'has-error' : ''}}">
                                                {{ Form::label('shipping[company]', 'Company', []) }}
                                                {{ Form::text('shipping[company]', null, ['class' => 'form-control']) }}
                                                {!! $errors->first('shipping.company', '<p class="help-block">:message</p>') !!}
                                            </div>
                                            <div class="form-group col-sm-12 {{ $errors->has('shipping.address') ? 'has-error' : ''}}">
                                                {{ Form::label('shipping[address]', 'Address <span class="required">*</span>', [], false) }}
                                                {{ Form::text('shipping[address]', null, ['class' => 'form-control']) }}
                                            </div>
                                            <div class="form-group col-sm-12 {{ $errors->has('shipping.address') ? 'has-error' : ''}}">
                                                {{ Form::text('shipping[address_2]', null, ['class' => 'form-control']) }}
                                                {!! $errors->first('shipping.address', '<p class="help-block">:message</p>') !!}
                                            </div>
                                            <div class="form-group col-sm-6 {{ $errors->has('shipping.city') ? 'has-error' : ''}}">
                                                {{ Form::label('shipping[city]', 'City <span class="required">*</span>', [], false) }}
                                                {{ Form::text('shipping[city]', null, ['class' => 'form-control']) }}
                                                {!! $errors->first('shipping.city', '<p class="help-block">:message</p>') !!}
                                            </div>
                                            <div class="form-group col-sm-6 {{ $errors->has('shipping.postal_code') ? 'has-error' : ''}}">
                                                {{ Form::label('shipping[postal_code]', 'ZIP / Postal Code <span class="required">*</span>', [], false) }}
                                                {{ Form::text('shipping[postal_code]', null, ['class' => 'form-control']) }}
                                                {!! $errors->first('shipping.postal_code', '<p class="help-block">:message</p>') !!}
                                            </div>
                                            <div class="form-group col-sm-6 {{ $errors->has('shipping.country') ? 'has-error' : ''}}">
                                                {{ Form::label('shipping[country]', 'Country <span class="required">*</span>', [], false) }}
                                                {{ Form::select('shipping[country]', $countries, 'ES', ['class' => 'form-control']) }}
                                                {!! $errors->first('shipping.country', '<p class="help-block">:message</p>') !!}
                                            </div>
                                            <div class="form-group col-sm-6 {{ $errors->has('shipping.phone') ? 'has-error' : ''}}">
                                                {{ Form::label('shipping[phone]', 'Phone <span class="required">*</span>', [], false) }}
                                                {{ Form::text('shipping[phone]', null, ['class' => 'form-control']) }}
                                                {!! $errors->first('shipping.phone', '<p class="help-block">:message</p>') !!}
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-sm-6">
                                                <label>Phone <span class="required">*</span></label>
                                                <input type="text" class="form-control">
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label>Fax</label>
                                                <input type="text" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="col-sm-4">
                                <h3>Tu pedido</h3>
                                <div class="products-order shopping-cart ">
                                    <div class="table-responsive">
                                        <table class="table table-products">
                                            <thead>
                                            <tr>
                                                <th>Product</th>
                                                <th>Subtotal</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($cart as $product)
                                                <tr>
                                                    <td class="col-xs-4 col-md-5">
                                                        <h4>{{ $product->product->name }}
                                                            <small> {{ $product->product->brand->name }}
                                                                @foreach($product->product->attributes as $attribute)
                                                                    , {{ $product->{$attribute->name} }}
                                                                @endforeach
                                                            </small>
                                                        </h4>
                                                    </td>
                                                    <td class="col-xs-2 text-center">
                                                        <small>{{ $product->quantity }}
                                                            x {{ $product->price }}{{ $product->product->currency }}</small>
                                                        <span>
                                                            <b>{{ $product->subtotal }}{{ $product->product->currency }}</b>
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <h3>Payment Method</h3>
                                <div class="products-order checkout payment-method">
                                    <div id="payment-methods" role="tablist" aria-multiselectable="true">
                                        <div class="panel radio">
                                            <input type="radio" name="optionsRadios" id="radio-payment-1"
                                                   checked>
                                            <label for="radio-payment-1" data-toggle="collapse"
                                                   data-target="#parent-1" data-parent="#payment-methods"
                                                   aria-controls="parent-1">Cash On
                                                Delivery<span>($5)</span></label>
                                            <div id="parent-1" class="panel-collapse collapse in"
                                                 role="tabpanel"></div>
                                        </div>
                                        <div class="panel radio">
                                            <input type="radio" name="optionsRadios" id="radio-payment-2">
                                            <label for="radio-payment-2" class="collapsed"
                                                   data-toggle="collapse"
                                                   data-target="#parent-2" data-parent="#payment-methods"
                                                   aria-controls="parent-2">Payment by Bank Transfer<span>IBAN: CZ00 0000 0000 0000 0000 0000</span></label>
                                            <div id="parent-2" class="panel-collapse collapse"
                                                 role="tabpanel"></div>
                                        </div>
                                        <div class="panel radio">
                                            <input type="radio" name="optionsRadios" id="radio-payment-3">
                                            <label for="radio-payment-3" class="collapsed"
                                                   data-toggle="collapse"
                                                   data-target="#parent-3" data-parent="#payment-methods"
                                                   aria-controls="parent-3">PayPal</label>
                                            <div id="parent-3" class="panel-collapse collapse"
                                                 role="tabpanel"></div>
                                        </div>
                                        <div class="panel radio">
                                            <input type="radio" name="optionsRadios" id="radio-payment-4">
                                            <label for="radio-payment-4" class="collapsed"
                                                   data-toggle="collapse"
                                                   data-target="#parent-4" data-parent="#payment-methods"
                                                   aria-controls="parent-4">Pay via Credit Card</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix">
                                    <button type="submit" class="btn btn-primary btn-lg pull-right">Continue</button>
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