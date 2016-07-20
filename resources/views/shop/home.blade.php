@extends('layouts.shop')

@section('content')
        <!-- ==========================
       JUMBOTRON - START
   =========================== -->
<section class="content jumbotron ">
    <div id="homepage-2-carousel" class="nav-inside">

        <div class="item slide-1">
            <div class="slide-mask"></div>
            <div class="slide-body">
                <div class="container">
                    <h1>Welcome to <span class="color">uMarket</span></h1>
                    <h2>Beautiful E-Commerce Website Theme with 30+ HTML Pages</h2>
                    <a href="https://wrapbootstrap.com/theme/umarket-modern-responsive-ecommerce-WB054TF88?ref=themejumbo"
                       class="btn btn-default btn-lg">Show More</a>
                    <a href="https://wrapbootstrap.com/theme/umarket-modern-responsive-ecommerce-WB054TF88?ref=themejumbo"
                       class="btn btn-inverse btn-lg">Purchase Now</a>
                </div>
            </div>
        </div>
        <div class="item slide-2">
            <div class="slide-mask"></div>
            <div class="slide-body">
                <div class="container">
                    <h1 class="grey-background">Awesome Theme Features</h1>
                    <div><h2 class="color-background">Version 1.1</h2></div>
                    <ul class="list-unstyled">
                        <li><i class="fa fa-check"></i>Free Shipping On All Orders</li>
                        <li><i class="fa fa-check"></i>Amazing Customer Service</li>
                        <li><i class="fa fa-check"></i>No Customs Or Duty Fees!</li>
                    </ul>
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
<section class="content services services-3x border-top border-bottom">
    <div class="container">
        <div class="row row-no-padding">

            <!-- SERVICE - START -->
            <div class="col-xs-12 col-sm-4">
                <div class="service">
                    <i class="fa fa-star"></i>
                    <h3>FREE SHIPPING ON ALL ORDRES</h3>
                    <p>Ut feugiat mauris eget magna egestas porta. Curabitur sagittis sagittis neque rutrum congue.</p>
                </div>
            </div>
            <!-- SERVICE - END -->

            <!-- SERVICE - START -->
            <div class="col-xs-6 col-sm-4">
                <div class="service">
                    <i class="fa fa-heart"></i>
                    <h3>AMAZING CUSTOMER SERVICE</h3>
                    <p>Ut feugiat mauris eget magna egestas porta. Curabitur sagittis sagittis neque rutrum congue.</p>
                </div>
            </div>
            <!-- SERVICE - END -->

            <!-- SERVICE - START -->
            <div class="col-xs-6 col-sm-4">
                <div class="service">
                    <i class="fa fa-rocket"></i>
                    <h3>NO CUSTOMS OR DUTY FEES!</h3>
                    <p>Ut feugiat mauris eget magna egestas porta. Curabitur sagittis sagittis neque rutrum congue.</p>
                </div>
            </div>
            <!-- SERVICE - END -->

        </div>

    </div>
</section>
<!-- ==========================
    SERVICES - END
=========================== -->

<!-- ==========================
    CATEGORIES - START
=========================== -->
<section class="content categories">
    <div class="row row-no-padding">
        <!-- CATEGORY - START -->
        @foreach($categories as $category)
            <div class="col-xs-4">
                <div class="category">
                    <a href="{{ route('shop.category', ['slugCategory' => $category->slug]) }}">
                        {!! Form::img($category->filename, StaticVars::homeCategories(), $category->name) !!}
                        <div class="category-mask"></div>
                        <h3 class="category-title">{{ $category->name }}</h3>
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

<!-- ==========================
    GRID PRODUCTS - START
=========================== -->
<section class="content grid-products border-top">
    <div class="container">
        <div class="row">
            @foreach($productsLeft as $product)
                <div class="col-xs-6 col-sm-3">
                    <article class="product-item">
                        <div class="product-overlay">
                            <a href="{{ route('shop.product', ['slug' => $product->slug ]) }}">
                                <div class="product-mask">
                                    {!! Form::img($product->images()->last()->filename, StaticVars::productRelated(), $product->images()->last()->alt) !!}
                                </div>
                                {!! Form::img($product->images->first()->filename, StaticVars::homeLeft(), $product->images->first()->alt) !!}
                            </a>
                        </div>
                        <a href="{{ route('shop.product', ['slug' => $product->slug ]) }}">
                            <h3>{{ $product->name }}</h3>
                        </a>
                        {{--<div class="product-rating">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                        </div>--}}
                        <span class="price">
                                <del><span class="amount"></span></del>
                            	<ins><span class="amount">{{ $product->range_price }}</span></ins>

                            </span>

                    </article>
                </div>
            @endforeach
            @foreach ($productsRight->chunk(4) as $chunk)
                <div class="col-xs-12 col-sm-3">
                    <ul class="list-unstyled small-product">
                        @foreach ($chunk as $product)
                                <!-- PRODUCT - START -->
                        <li class="clearfix">

                            <div class="product-overlay">
                                <a href="{{ route('shop.product', ['slug' => $product->slug ]) }}">
                                    <div class="product-mask">
                                        {!! Form::img($product->images()->last()->filename, StaticVars::productRelated(), $product->images()->last()->alt) !!}
                                    </div>
                                    {!! Form::img($product->images->first()->filename, StaticVars::homeLeft(), $product->images->first()->alt) !!}
                                </a>
                            </div>
                            <a href="{{ route('shop.product', ['slug' => $product->slug ]) }}">
                                <h3>{{ $product->name }}</h3>
                            </a>
                            {{--<div class="product-rating">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </div>--}}
                            <span class="price">
                                <del><span class="amount"></span></del>
                            	<ins><span class="amount">{{ $product->range_price }}</span></ins>

                            </span>
                        </li>
                        <!-- PRODUCT - END -->
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
=========================== -->

<!-- ==========================
    RECENT BLOG POSTS - START
=========================== -->
<section class="content recent-blog-posts">
    <div class="container">
        <div class="section-title">
            <h2>Latest from blog</h2>
            <p>Ut feugiat mauris eget magna egestas porta. Curabitur sagittis sagittis neque rutrum congue.</p>
        </div>
        <div class="row">

            <!-- BLOG POST - START -->
            <div class="col-xs-6 col-sm-3">
                <article class="post">
                    <img src="/images/blog/blog-1.jpg" class="img-responsive" alt="">
                    <h3><a href="single-post.html">How to pickup shoes</a></h3>
                    <span class="date">01/12/2015</span>
                </article>
            </div>
            <!-- BLOG POST - END -->

            <!-- BLOG POST - START -->
            <div class="col-xs-6 col-sm-3">
                <article class="post">
                    <img src="/images/blog/blog-2.jpg" class="img-responsive" alt="">
                    <h3><a href="single-post.html">Fine mens gloves</a></h3>
                    <span class="date">24/11/2015</span>
                </article>
            </div>
            <!-- BLOG POST - END -->

            <!-- BLOG POST - START -->
            <div class="col-xs-6 col-sm-3">
                <article class="post">
                    <img src="/images/blog/blog-3.jpg" class="img-responsive" alt="">
                    <h3><a href="single-post.html">Sunglasses for a beach</a></h3>
                    <span class="date">10/11/2015</span>
                </article>
            </div>
            <!-- BLOG POST - END -->

            <!-- BLOG POST - START -->
            <div class="col-xs-6 col-sm-3">
                <article class="post">
                    <img src="/images/blog/blog-4.jpg" class="img-responsive" alt="">
                    <h3><a href="single-post.html">Pyjamas for a good night</a></h3>
                    <span class="date">19/10/2015</span>
                </article>
            </div>
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