@extends('layouts.shop')

@section('content')
    <!-- ==========================
       JUMBOTRON - START
   =========================== -->
    <section class="content jumbotron jumbotron-full-height">
        <div id="homepage-2-carousel" class="nav-inside">

            <div class="item slide-1">
                <div class="slide-mask"></div>
                <div class="slide-body">
                    <div class="container">
                        <h1>Tu bici, <span class="color">tu ciudad</span></h1>
                        <h2>Accesorios innovadores para ciclistas urbanos</h2>
                        <a href="{{ route('shop.catalogue') }}"
                           class="btn btn-default btn-lg">Visita nuestra tienda</a>

                        <div class="content services transparent margin-top services-3x hidden-xs">
                            <div class="row row-no-padding">

                                @include('layouts.partials.warranty')

                            </div>
                        </div>

                    </div>
                </div>

            </div>


        </div>
    </section>
    <!-- ==========================
        JUMBOTRON - END
    =========================== -->

    <!-- ==========================
        SERVICES - START
    =========================== -->
    <section class="content services services-3x border-top border-bottom visible-xs">
        <div class="container">
            <div class="row row-no-padding">

                @include('layouts.partials.warranty', ['show_paragraph' => false])

            </div>

        </div>
    </section>
    <!-- ==========================
        SERVICES - END
    =========================== -->



    <!-- ==========================
        GRID PRODUCTS - START
    =========================== -->
    <section class="content grid-products border-top">
        <div class="container">
            <div class="row">
                @php
                    $loop_iteration = 1
                @endphp
                @foreach($productsLeft as $product)
                    <div class="col-xs-6 col-sm-3">
                        <article class="product-item">
                            <div class="product-overlay">
                                <a href="{{ route('shop.slug', ['slug' => $product->slug ]) }}"
                                   onclick="onProduct{{$loop_iteration}}Click(); return !ga.loaded;"
                                >
                                    <div class="product-mask">
                                        {!! Form::img($product->front_image_hover->filename, StaticVars::productRelated(), $product->front_image_hover->alt) !!}
                                    </div>
                                    {!! Form::img($product->front_image->filename, StaticVars::homeLeft(), $product->front_image->alt) !!}
                                </a>
                            </div>
                            <a href="{{ route('shop.slug', ['slug' => $product->slug ]) }}"
                               onclick="onProduct{{$loop_iteration}}Click(); return !ga.loaded;"
                            >
                                <h3>{{ $product->name }}</h3>
                            </a>
                            @include('partials.product_rating', ['rating' => $product->rating, 'total_reviews' => count($product->reviews)])
                            @include('partials.price')
                        </article>
                        @include('scripts.addImpression', ['product' => $product, 'iteration' => $loop_iteration])
                    </div>
                    @php
                        $loop_iteration++;
                    @endphp
                @endforeach
                @foreach ($productsRight->chunk(4) as $chunk)
                    <div class="col-xs-12 col-sm-3">
                        <ul class="list-unstyled small-product">
                        @foreach ($chunk as $product)
                            <!-- PRODUCT - START -->
                                <li class="clearfix">
                                    <div class="row">
                                        <div class="col-xs-4 product-overlay">
                                            <a href="{{ route('shop.slug', ['slug' => $product->slug ]) }}"
                                               onclick="onProduct{{$loop_iteration}}Click(); return !ga.loaded;"
                                            >
                                                <div class="product-mask">
                                                    {!! Form::img($product->front_image_hover->filename, StaticVars::homeLeft(), $product->front_image_hover->alt) !!}
                                                </div>
                                                {!! Form::img($product->front_image->filename, StaticVars::homeLeft(), $product->front_image->alt) !!}
                                            </a>
                                        </div>
                                        <div class="col-xs-8">
                                            <a href="{{ route('shop.slug', ['slug' => $product->slug ]) }}"
                                               onclick="onProduct{{$loop_iteration}}Click(); return !ga.loaded;"
                                            >
                                                <h3>{{ $product->name }}</h3>
                                            </a>
                                            @include('partials.product_rating', ['rating' => $product->rating, 'total_reviews' => count($product->reviews)])
                                            @include('partials.price')
                                            @include('scripts.addImpression', ['product' => $product, 'iteration' => $loop_iteration])
                                        </div>
                                    </div>
                                </li>
                                <!-- PRODUCT - END -->
                                @php
                                    $loop_iteration++
                                @endphp
                            @endforeach
                        </ul>
                    </div>
                @endforeach

            </div>
        </div>
    </section>
    <!-- ==========================
        GRID PRODUCTS - END
    =========================== -->

    <!-- ==========================
        CATEGORIES - START
    =========================== -->
    <section class="content categories">
        <div class="row row-no-padding">
            <!-- CATEGORY - START -->
            @foreach($categories as $category)
                <div class="col-xs-6 col-md-2">
                    <div class="category">
                        <a href="{{ route('shop.slug', ['slug' => $category->slug]) }}">
                            {!! Form::img($category->filename, StaticVars::homeCategories(), $category->name) !!}
                            <div class="category-mask"></div>
                            <h3 class="category-title"><span>{!!  str_replace(' ', '<br/>', $category->name) !!}</span>
                            </h3>
                        </a>
                    </div>
                </div>
        @endforeach
        <!-- CATEGORY - END -->
        </div>

    </section>
    <!-- ==========================
        CATEGORIES - END
    =========================== -->

    {{--<!-- ==========================
        NOTIFICATION - START
    =========================== -->
    <section class="content pattern notification">
        <div class="container">
            <div class="row">
                <div class="col-sm-4">
                    <span>The new amazing collection is here!</span>
                    <a href="#" class="btn btn-default btn-lg">Let's Go</a>
                </div>
                <div class="col-sm-8">
                    <h3>Summer Collection 2015</h3>
                    <p>Ut feugiat mauris eget magna egestas porta. Curabitur sagittis sagittis neque rutrum congue. Lorem
                        ipsum dolor sit amet, consectetur adipiscing elit. Ut feugiat mauris eget magna egestas porta.
                        Vestibulum tortor quam, feugiat vitae, ultricies eget.</p>
                </div>
            </div>
        </div>
    </section>
    <!-- ==========================
       NOTIFICATION - END
    =========================== -->--}}

    <!-- ==========================
    RECENT BLOG POSTS - START
=========================== -->
    <section class="content recent-blog-posts">
        <div class="container">
            <div class="section-title">
                <h2><a href="{{ config('app.blog_url') }}" target="_blank">@lang('home.blog_h2')</a></h2>
                <p>@lang('home.blog_p')</p>
            </div>
            <div class="row">
                <!-- BLOG POST - START -->
                @foreach($feed as $post)
                    <div class="col-xs-6 col-sm-3">
                        <article class="post">
                            <img data-src="{{ Form::postImage($post->get_description()) }}"
                                 class="lazyload img-responsive"
                                 alt="{{ $post->get_title() }}">
                            <h3><a href="{{ $post->get_permalink() }}">{{ $post->get_title() }}</a></h3>
                        </article>
                    </div>
            @endforeach
            <!-- BLOG POST - END -->
            </div>
        </div>
    </section>
    <!-- ==========================
       RECENT BLOG POSTS - END
    =========================== -->

    @if(!empty($brands->count()))
        <!-- ==========================
    BRANDS - START
=========================== -->
        <section class="content brands pattern border-top border-bottom">
            <div class="container">
                <div id="brands-carousel">
                    @foreach($brands as $brand)
                        <div class="item">
                            <a href="{{ route('shop.brand', ['slug' => $brand->slug]) }}">
                                {!! Form::img($brand->filename, collect(['1200w' => '300']), $brand->name) !!}
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
        <!-- ==========================
            BRANDS - END
        =========================== -->
    @endif

@endsection