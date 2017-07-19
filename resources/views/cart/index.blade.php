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
                                        <th>@lang('cart.product')</th>
                                        <th>@lang('cart.unity_price')</th>
                                        <th>@lang('cart.quantity')</th>
                                        <th>@lang('cart.subtotal')</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($cartCollect as $item)
                                        <tr>
                                            <td class="col-xs-1">
                                                <img src="/img/70/{{ $item->attributes->filename }}"
                                                     alt="{{ $item->attributes['image_alt'] }}"
                                                     class="img-responsive">
                                            </td>
                                            <td class="col-xs-4 col-md-5">
                                                <h4>
                                                    <a href="{{ route('shop.slug', ['slug' => $item->attributes['slug']]) }}"> {{ $item->name }}</a>
                                                    <small> {{ $item->attributes['brand'] }}
                                                        @foreach($item->attributes->properties as $property)
                                                            , {{ $property }}
                                                        @endforeach
                                                    </small>
                                                </h4>
                                            </td>
                                            <td class="col-xs-2 text-center">
                                                <span>{{ $item->getPriceWithConditions() }}&euro;</span></td>
                                            <td class="col-xs-2 col-md-1">
                                                <div class="form-group">
                                                    <input type="text" class="form-control"
                                                           name="{{ $item->attributes['_id'] }}"
                                                           value="{{ $item->quantity }}">
                                                </div>
                                            </td>
                                            <td class="col-xs-2 text-center">
                                                <span><b>{{ $item->getPriceSumWithConditions() }}{{ $item->attributes['currency'] }}</b></span>
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

                            {{--<a href="" class="btn btn-inverse update-cart">Update Shopping Cart</a>--}}
                        </div>

                        <div class="box">
                            <div class="row">
                                <div class="col-sm-6">
                                    <h5>@lang('cart.enter_coupon_code')</h5>
                                    {{ Form::open([
                                        'method' => 'POST',
                                        'url' => route('coupon.store')
                                    ]) }}
                                    {{ csrf_field() }}
                                    <div class="input-group {{ $errors->has('coupon') ? 'has-error' : ''}}">
                                        {{ Form::text('coupon', null, [ 'class' => 'form-control', 'placeholder' => trans('cart.discount_code')] ) }}
                                        <span class="input-group-btn">
                                            <button class="btn btn-transparent"
                                                    type="submit">@lang('cart.apply_coupon')</button>
                                        </span>
                                    </div>
                                    <div class="input-group {{ $errors->has('coupon') ? 'has-error' : ''}}">
                                        {!! $errors->first('coupon', '<p class="help-block">:message</p>') !!}
                                    </div>
                                    {{ Form::close() }}
                                </div>
                                <div class="col-sm-4 col-sm-offset-2">
                                    <ul class="list-unstyled order-total">
                                        @foreach(Cart::getConditions() as $condition)
                                            <li>{!! $condition->getName()  !!}<span>{!! $condition->getValue() !!}</span></li>
                                        @endforeach
                                        <li>Total<span>{{ Cart::getTotal() }}&euro;</span></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix">
                            @if($missingToFreeShipping > 0 )
                            <div class="alert alert-info" role="alert">@lang('cart.missing_to_free_shipping', ['missing' => $missingToFreeShipping])</div>
                            @endif
                            <a href="{{ route('shop.catalogue') }}"
                               class="btn btn-inverse">@lang('cart.continue_shopping')</a>

                            <a href="{{ route('checkout.index') }}"
                               class="btn btn-primary btn-lg pull-right ">@lang('cart.checkout')</a>
                        </div>


                    </article>
                </div>
            </div>

            <div class="releated-products">
                <h2>@lang('cart.cross_sell_products')</h2>
                <div class="row grid" id="products">
                    <!-- PRODUCT - START -->
                    @foreach($crossSellShop as $relatedProduct)
                        <div class="col-sm-3 col-xs-6">
                            @include('scripts.addImpression', ['product' => $relatedProduct, 'iteration' => $loop->iteration])
                            <article class="product-item">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="product-overlay">
                                            <div class="product-mask">
                                                {!! Form::img($relatedProduct->front_image_hover->filename, StaticVars::productRelated(), $relatedProduct->front_image_hover->filename) !!}
                                            </div>
                                            <a href="{{ route('shop.slug', ['slug' => $relatedProduct->slug]) }}"
                                               onclick="onProduct{{$loop->iteration}}Click(); return !ga.loaded;"
                                               class="product-permalink"></a>
                                            {!! Form::img($relatedProduct->front_image->filename, StaticVars::productRelated(), $relatedProduct->front_image->filename) !!}
                                            {{--<div class="product-quickview">
                                                <a class="btn btn-quickview" data-toggle="modal"
                                                   data-target="#product-{{ $relatedProduct->slug }}">Quick View</a>
                                            </div>--}}
                                        </div>
                                    </div>
                                    <div class="col-sm-9">
                                        <div class="product-body">
                                            <h3>
                                                <a href="{{ route('shop.slug', $relatedProduct->slug) }}"
                                                   onclick="onProduct{{$loop->iteration}}Click(); return !ga.loaded;"
                                                >
                                                    {{ $relatedProduct->name }}
                                                </a>
                                            </h3>
                                            @include('partials.price', ['product' => $relatedProduct])
                                            <p></p>
                                            <div class="buttons buttons-simple">
                                                @include('partials.buy_buttons', ['product' => $relatedProduct, 'iteration' => $loop->iteration])
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        </div>
                @endforeach
                <!-- PRODUCT - END -->
                </div>
            </div>
        </div>
    </section>
    <!-- ==========================
        MY ACCOUNT - END
    =========================== -->



@endsection