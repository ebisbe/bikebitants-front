@extends('layouts.checkout')

@section('content')
    <!-- ==========================
        BREADCRUMB - START
    =========================== -->
    <section class="breadcrumb-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-xs-6">
                    <h2>@lang('checkout.checkout')</h2>
                    <h1>@lang('checkout.review')</h1>
                </div>
                <div class="col-xs-6">
                    <ol class="breadcrumb">
                        <li><a href="{{ route('shop.home') }}">@lang('layout.home')</a></li>
                        <li><a>@lang('checkout.checkout')</a></li>
                        <li class="active">@lang('checkout.review')</li>
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
                                    <div class="title">@lang('checkout.step1')</div>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-4">
                                <div class="checkout-step active">
                                    <div class="number">2</div>
                                    <div class="title">@lang('checkout.step2')</div>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-4">
                                <div class="checkout-step active">
                                    <div class="number">3</div>
                                    <div class="title">@lang('checkout.step3')</div>
                                </div>
                            </div>
                        </div>

                        <div class="progress checkout-progress hidden-xs">
                            <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0"
                                 aria-valuemax="100" style="width:100%;"></div>
                        </div>

                        <h3>@lang('checkout.cart') #{{ $order->external_id }}</h3>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="box">
                                    <h4>@lang('checkout.billing_information')</h4>
                                    <ul class="list-unstyled">
                                        <li><b>{{ $order->billing->first_name }} {{ $order->billing->last_name }}</b>
                                        </li>
                                        <li>{{ $order->billing->address_1 }}</li>
                                        <li>{{ $order->billing->postcode }} {{ $order->billing->city }}</li>
                                        <li>{{ $order->billing->country->name }} ({{ $order->billing->states()->name }})
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="box">
                                    <h4>@lang('checkout.shipping_information')</h4>
                                    <ul class="list-unstyled">
                                        <li><b>{{ $order->shipping->first_name }} {{ $order->shipping->last_name }}
                                                ({{ $order->shipping->email }})</b></li>
                                        <li>{{ $order->shipping->address_1 }}</li>
                                        <li>{{ $order->shipping->postcode }} {{ $order->shipping->city }}</li>
                                        <li>{{ $order->shipping->country->name }}
                                            ({{ $order->shipping->states()->name }})
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="box">
                                    <h4>@lang('checkout.order_details')</h4>
                                    <ul class="list-unstyled">
                                        <li><b>@lang('checkout.email_address')
                                                    : </b>{{ $order->shipping->email ?? $order->billing->email }}</li>
                                        <li><b>@lang('checkout.phone')
                                                    : </b>{{ $order->shipping->phone ?? $order->billing->phone }}</li>
                                    </ul>
                                    {{--<h5>Addition information:</h5>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut feugiat mauris eget magna egestas porta. Curabitur sagittis sagittis neque rutrum congue.</p>--}}
                                </div>
                                <div class="box">
                                    <h4>@lang('checkout.shipping_method')</h4>
                                    <ul class="list-unstyled">
                                        {{--TODO review why conditions is not a model and is an array--}}
                                        <li>{{ collect($order->conditions)->filter(function($condition){return $condition['type'] == 'shipping'; })->first()['name'] }}</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="box">
                                    <h4>@lang('checkout.payment_method')</h4>
                                    <ul class="list-unstyled">
                                        <li><strong>{{ $order->payment_method->name }}</strong></li>
                                        <li>{!! $order->payment_method->description !!}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="products-order checkout shopping-cart">
                            <div class="table-responsive">
                                <table class="table table-products">
                                    <thead>
                                    <tr>
                                        <th></th>
                                        <th>@lang('cart.product')</th>
                                        <th>@lang('cart.unity_price')</th>
                                        <th>@lang('cart.quantity')</th>
                                        <th>@lang('cart.subtotal')</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($items as $item)
                                        <tr>
                                            <td class="col-xs-1">
                                                <img src="/img/70/{{ $item->product->front_image->filename }}"
                                                     alt="{{ $item->product->front_image->alt }}"
                                                     class="img-responsive">
                                            </td>
                                            <td class="col-xs-4 col-md-5">
                                                <h4>
                                                    <a href="{!! url('product', ['slug' => $item->product->slug]) !!}"> {{ $item->product->name }}</a>
                                                    <small> {{ $item->product->brand->name }} {{ collect($item->attributes)->implode(', ') }}</small>
                                                </h4>
                                            </td>
                                            <td class="col-xs-2 text-center">
                                                <span>{{ $item->price }}&euro;</span></td>
                                            <td class="col-xs-2 col-md-1 text-center">
                                                <span><b>{{ $item->quantity }} {{ str_plural(trans('cart.item'), (int)$item->quantity) }}</b></span>
                                            </td>
                                            <td class="col-xs-2 text-center">
                                                <span><b>{{ $item->total }}&euro;</b></span>
                                                @if($order->print_analytics)
                                                    <script type="application/javascript">
                                                        ga('ec:addProduct', {
                                                            'id': '{{ $item['id'] }}',
                                                            'name': '{{ $item->product->name }}',
                                                            'brand': '{{ $item->product->brand->name }}',
                                                            'variant': '{{ collect($item->attributes)->implode(', ') }}',
                                                            'price': '{{ $item->price }}',
                                                            'quantity': '{{ $item->quantity }}'
                                                        });
                                                    </script>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <ul class="list-unstyled order-total">
                                <li>@lang('cart.subtotal')<span>{{ $order->subtotal }} &euro;</span></li>
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
    @if($order->print_analytics)
        <script type="text/javascript">
            ga('ec:setAction', 'purchase', {
                'id': '{{ $order->external_id }}',
                'revenue': '{{ $order->total }}',
                'tax': '{{ $order->total - $order->subtotal }}'
            });
        </script>
        <!-- Google Code for Venta Conversion Page -->
        <script type="text/javascript">
            /* <![CDATA[ */
            var google_conversion_id = 946537783;
            var google_conversion_order_id = {{ $order->external_id }};
            var google_conversion_language = "en";
            var google_conversion_format = "3";
            var google_conversion_color = "ffffff";
            var google_conversion_label = "LYoZCOCioGAQt4qswwM";
            var google_conversion_value = 1.00;
            var google_conversion_currency = "EUR";
            var google_remarketing_only = false;
            /* ]]> */
        </script>
        <script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
        </script>
        <noscript>
            <div style="display:inline;">
                <img height="1" width="1" style="border-style:none;" alt=""
                     src="//www.googleadservices.com/pagead/conversion/946537783/?value=1.00&amp;currency_code=EUR&amp;label=LYoZCOCioGAQt4qswwM&amp;guid=ON&amp;script=0"/>
            </div>
        </noscript>
    @endif
@endsection