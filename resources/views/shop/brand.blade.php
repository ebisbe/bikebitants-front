@extends('layouts.shop')

@section('content')

        <!-- ==========================
    	LOOKBOOK - START
    =========================== -->
<section class="content lookbook">
    <div class="container">
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
                <img src="/images/clients/7.png" class="img-responsive center-block" alt="">
            </div>
        </div>
        <h2>{{ $brand->name }}</h2>
        <p>{{ $brand->description }}</p>
    </div>
</section>
<!-- ==========================
    LOOKBOOK - END
=========================== -->

<!-- ==========================
    LOOKBOOK SERVICES - START
=========================== -->
@foreach($brand->services as $service)
    <section class="content lookbook-services image-{{ $service->position }} border-bottom border-top">
        <div class="container">
            <div class="row">
                @if($service->position == 'left')
                    <div class="col-xs-6">
                        <img src="/images/lookbook-1.png" class="img-responsive center-block" alt="">
                    </div>
                @endif
                <div class="col-xs-6">
                    <h3>{{ $service->title }}</h3>
                    <p>{{ $service->description }}</p>
                </div>
                @if($service->position == 'right')
                    <div class="col-xs-6">
                        <img src="/images/lookbook-1.png" class="img-responsive center-block" alt="">
                    </div>
                @endif

            </div>
        </div>
    </section>
    @endforeach
            <!-- ==========================
    LOOKBOOK SERVICES - END
=========================== -->


    <!-- ==========================
        FEATURED PRODUCTS - START
    =========================== -->
    <section class="content featured-products">
        <div class="container">

            <h2>Featured Products with this Brand</h2>
            <div class="row">

                <!-- PRODUCT - START -->
                @foreach($brand->products->take(4) as $product)
                    <div class="col-xs-6 col-sm-3">
                        <article class="product-item">
                            <a href="{!! route('shop.product', ['slug' => $product->slug]) !!}">
                                <img src="/images/products/product-3.jpg" class="img-responsive" alt="">
                            </a>
                            <h3>
                                <a href="{!! route('shop.product', ['slug' => $product->slug]) !!}">{{ $product->name }}</a>
                            </h3>
                            @if(isset($product->rating))
                                <div class="product-rating">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                </div>
                            @endif
                            <span class="price">
                            <ins><span class="amount">{{ $product->price }} &euro;</span></ins>
                        </span>
                        </article>
                    </div>
                    @endforeach
                            <!-- PRODUCT - END -->
            </div>

        </div>
    </section>
    <!-- ==========================
        FEATURED PRODUCTS - END
    =========================== -->
    @endsection
