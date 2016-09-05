@extends('layouts.checkout')

@section('content')
<!-- ==========================
    	BREADCRUMB - START
    =========================== -->
<section class="breadcrumb-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-xs-6">
                <h2>Checkout</h2>
                <p>Review</p>
            </div>
            <div class="col-xs-6">
                <ol class="breadcrumb">
                    <li><a href="index.html">Home</a></li>
                    <li><a href="checkout.html">Checkout</a></li>
                    <li class="active">Review</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<!-- ==========================
    BREADCRUMB - END
=========================== -->

<!-- ==========================
    MY ACCOUNT - START
=========================== -->
<section class="content account">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <article class="account-content checkout-steps">

                    <div class="row row-no-padding">
                        <div class="col-xs-6 col-sm-4">
                            <div class="checkout-step active">
                                <div class="number">1</div>
                                <div class="title">Billing & Shipping Address</div>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-4">
                            <div class="checkout-step active">
                                <div class="number">2</div>
                                <div class="title">Payment</div>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-4">
                            <div class="checkout-step active<">
                                <div class="number">3</div>
                                <div class="title">Confirmation</div>
                            </div>
                        </div>
                    </div>

                    <div class="progress checkout-progress hidden-xs"><div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%;"></div></div>

                        <h3>You Order {{ $order->_id }}</h3>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="box">
                                    <h4>Billing Address</h4>
                                    <ul class="list-unstyled">
                                        <li><b>{{ $order->billing->first_name }} {{ $order->billing->last_name }}</b></li>
                                        <li>{{ $order->billing->address }}</li>
                                        <li>{{ $order->billing->postal_code }} {{ $order->billing->city }}</li>
                                        <li>{{ $order->billing->country }} ({{ $order->billing->province }})</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="box">
                                    <h4>Shipping Address</h4>
                                    <ul class="list-unstyled">
                                        <li><b>{{ $order->shipping->first_name }} {{ $order->shipping->last_name }}</b></li>
                                        <li>{{ $order->shipping->address }}</li>
                                        <li>{{ $order->shipping->postal_code }} {{ $order->shipping->city }}</li>
                                        <li>{{ $order->shipping->country }} ({{ $order->shipping->province }})</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="box">
                                    <h4>Payment Method</h4>
                                    <ul class="list-unstyled">
                                        <li>{{ $order->payment_method }}</li>
                                    </ul>
                                </div>
                                <div class="box">
                                    <h4>Shipping Method</h4>
                                    <ul class="list-unstyled">
                                        <li>Post Air Mail</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="box">
                                    <h4>Order Details</h4>
                                    <ul class="list-unstyled">
                                        <li><b>Email: </b>{{ $order->billing->email }}</li>
                                        <li><b>Phone: </b>{{ $order->billing->phone }}</li>
                                    </ul>
                                    <h5>Addition information:</h5>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut feugiat mauris eget magna egestas porta. Curabitur sagittis sagittis neque rutrum congue.</p>
                                </div>
                            </div>
                        </div>

                        <div class="products-order checkout shopping-cart">
                            <div class="table-responsive">
                                <table class="table table-products">
                                    <thead>
                                    <tr>
                                        <th></th>
                                        <th>Product</th>
                                        <th>Unit Price</th>
                                        <th>Quantity</th>
                                        <th>Subtotal</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($items as $item)
                                        <tr>
                                            <td class="col-xs-1">
                                                <img src="/img/70/{{ $item->product->front_image->filename }}" alt="{{ $item->product->front_image->alt }}" class="img-responsive">
                                            </td>
                                            <td class="col-xs-4 col-md-5">
                                                <h4>
                                                    <a href="{!! url('product', ['slug' => $item->product->slug]) !!}"> {{ $item->product->name }}</a>
                                                    <small> {{ $item->product->brand->name }}
                                                        @foreach($item->attributes as $attribute)
                                                            , {{ $attribute }}
                                                        @endforeach
                                                    </small>
                                                </h4>
                                            </td>
                                            <td class="col-xs-2 text-center">
                                                <span>{{ $item->price }}&euro;</span></td>
                                            <td class="col-xs-2 col-md-1 text-center">
                                                <span><b>{{ $item->quantity }} {{ str_plural('item', (int)$item->quantity) }}</b></span>
                                            </td>
                                            <td class="col-xs-2 text-center">
                                                <span><b>{{ $item->total }}&euro;</b></span>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <ul class="list-unstyled order-total">
                                <li>Subtotal products<span>{{ $order->subtotal }} &euro;</span></li>
                                @foreach($order->conditions as $condition)
                                    <li>{{ $condition['name'] }}<span>{{ round($condition['value'], 2) }}</span></li>
                                @endforeach
                                <li>Total<span class="total">{{ $order->total }} &euro;</span></li>
                            </ul>
                        </div>
                </article>
            </div>
        </div>
    </div>
</section>
@endsection