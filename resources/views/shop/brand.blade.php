@extends('layouts.shop')

@section('content')

    <!-- ==========================
    	LOOKBOOK - START
    =========================== -->
    <section class="content lookbook">
        <div class="container">
            <div class="row">
                <div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
                    {!! Form::img($brand->filename, StaticVars::brandMain(), $brand->filename, '{img}', 'img-responsive center-block') !!}
                </div>
            </div>
            <h2>{{ ucfirst($brand->name) }}</h2>
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

            <h2>{{ trans('layout.brand_related_products') }}</h2>
            <div class="row">

                <!-- PRODUCT - START -->
                @foreach($products as $product)
                    <div class="col-xs-6 col-sm-3">
                        <article class="product-item">
                            <div class="product-overlay">
                                <a href="{!! route('shop.slug', ['slug' => $product->slug]) !!}">
                                    <div class="product-mask">
                                        {!! Form::img($product->front_image_hover->filename, StaticVars::productRelated(), $product->front_image_hover->alt) !!}
                                    </div>
                                    {!! Form::img($product->front_image->filename, StaticVars::homeLeft(), $product->front_image->alt) !!}
                                </a>
                            </div>
                            <h3>
                                <a
                                        href="{!! route('shop.slug', ['slug' => $product->slug]) !!}"
                                        onclick="onProduct{{ $loop->iteration }}Click(); return !ga.loaded;"
                                >{{ str_limit($product->name, 30) }}</a>
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
                            @include('partials.price')
                        </article>
                    </div>
                @include('scripts.addImpression', ['product' => $product, 'iteration' => $loop->iteration])
            @endforeach
            <!-- PRODUCT - END -->
            </div>

        </div>
    </section>
    <!-- ==========================
        FEATURED PRODUCTS - END
    =========================== -->
@endsection
