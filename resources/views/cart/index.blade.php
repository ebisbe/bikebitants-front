@extends('layouts.checkout')

@section('content')
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
                                @foreach($products as $product)
                                    <tr>
                                        <td class="col-xs-1">
                                            <img src="/img/70/{{ $product->product->images()->first()->filename }}" alt="{{ $product->product->images()->first()->alt }}" class="img-responsive">
                                        </td>
                                        <td class="col-xs-4 col-md-5">
                                            <h4>
                                                <a href="{!! url('product', ['slug' => $product->product->slug]) !!}"> {{ $product->product->name }}</a>
                                                <small> {{ $product->product->brand->name }}
                                                    @foreach($product->product->attributes as $attribute)
                                                        , {{ $product->{$attribute->name} }}
                                                    @endforeach
                                                </small>
                                            </h4>
                                        </td>
                                        <td class="col-xs-2 text-center">
                                            <span>{{ $product->price }}&euro;</span></td>
                                        <td class="col-xs-2 col-md-1">
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="{{ $product->_id }}" value="{{ $product->quantity }}">
                                            </div>
                                        </td>
                                        <td class="col-xs-2 text-center">
                                            <span><b>{{ $product->subtotal }}&euro;</b></span>
                                        </td>
                                        <td class="col-xs-1 text-center">
                                            <form method="POST" action="/cart/{{ $product->_id }}">
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
                                <div class="input-group">
                                    <input type="email" class="form-control" placeholder="Discount code">
                                            <span class="input-group-btn">
                                                <button class="btn btn-primary" type="button">Apply Coupon</button>
                                            </span>
                                </div>
                            </div>
                            <div class="col-sm-4 col-sm-offset-2">
                                <ul class="list-unstyled order-total">
                                    <li>Total products<span>{{ $products->sum('subtotal') }} &euro;</span></li>
                                    @if($discount != 0)
                                    <li>Discount<span>- {{ $discount }}&euro;</span></li>
                                    @endif
                                    <li>Subtotal<span class="total">{{ $products->sum('subtotal') - $discount }}&euro;</span></li>
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