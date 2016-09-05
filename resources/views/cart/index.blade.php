@extends('layouts.checkout')

@section('content')

@include('partials.breadcrumb')

        <!-- ==========================
MY ACCOUNT - START
=========================== -->
<section class="content account">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <article class="account-content">
                    <div class="products-order shopping-cart">
                        <div class="table-responsive">
                            <table class="table table-products">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>Product</th>
                                    <th>Unit Price</th>
                                    <th>Quantity</th>
                                    <th>Subtotal</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($cartCollect as $item)
                                    @php
                                    $product = $item->attributes->product;
                                    @endphp
                                    <tr>
                                        <td class="col-xs-1">
                                            <img src="/img/70/{{ $product->front_image->filename }}"
                                                 alt="{{ $product->front_image->alt }}"
                                                 class="img-responsive">
                                        </td>
                                        <td class="col-xs-4 col-md-5">
                                            <h4>
                                                <a href="{!! url('product', ['slug' => $product->slug]) !!}"> {{ $product->name }}</a>
                                                <small> {{ $product->brand->name }}
                                                    @foreach($item->attributes->attributes as $attribute)
                                                        , {{ $attribute }}
                                                    @endforeach
                                                </small>
                                            </h4>
                                        </td>
                                        <td class="col-xs-2 text-center">
                                            <span>{{ $item->price }}&euro;</span></td>
                                        <td class="col-xs-2 col-md-1">
                                            <div class="form-group">
                                                <input type="text" class="form-control"
                                                       name="{{ $product->_id }}"
                                                       value="{{ $item->quantity }}">
                                            </div>
                                        </td>
                                        <td class="col-xs-2 text-center">
                                            <span><b>{{ $item->getPriceSum() }}{{ $product->currency }}</b></span>
                                        </td>
                                        <td class="col-xs-1 text-center">
                                            <form method="POST" action="/cart/{{ $item->id }}">
                                                <input type="hidden" name="_method" value="DELETE"/>
                                                {{ csrf_field() }}
                                                <button class="btn btn-transparent js-remove-item" type="submit">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <a href="{{ route('shop.catalogue') }}" class="btn btn-inverse">Continue Shopping</a>
                        <a href="" class="btn btn-inverse update-cart">Update Shopping Cart</a>
                    </div>

                    <div class="box">
                        <div class="row">
                            <div class="col-sm-6">
                                <h5>Enter your coupon code if you have one.</h5>
                                {{ Form::open([
                                    'method' => 'POST',
                                    'url' => route('coupon.store')
                                ]) }}
                                {{ csrf_field() }}
                                <div class="input-group {{ $errors->has('coupon') ? 'has-error' : ''}}">
                                    {{ Form::text('coupon', null, [ 'class' => 'form-control', 'placeholder' => 'Discount code'] ) }}
                                    <span class="input-group-btn">
                                            <button class="btn btn-primary" type="submit">Apply Coupon</button>
                                        </span>
                                </div>
                                <div class="input-group {{ $errors->has('coupon') ? 'has-error' : ''}}">
                                    {!! $errors->first('coupon', '<p class="help-block">:message</p>') !!}
                                </div>
                                {{ Form::close() }}
                            </div>
                            <div class="col-sm-4 col-sm-offset-2">
                                <ul class="list-unstyled order-total">
                                    <li>Total products<span>{{ Cart::getSubTotal() }} &euro;</span></li>
                                    @foreach(Cart::getConditions() as $condition)
                                        <li>{{ $condition->getName() }}<span>{{ $condition->getValue() }}</span></li>
                                    @endforeach
                                    <li>Total<span class="total">{{ Cart::getTotal() }}&euro;</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix">
                        <a href="{{ route('checkout.index') }}" class="btn btn-primary btn-lg pull-right ">Checkout</a>
                    </div>


                </article>
            </div>
        </div>
    </div>
</section>
<!-- ==========================
    MY ACCOUNT - END
=========================== -->

@endsection