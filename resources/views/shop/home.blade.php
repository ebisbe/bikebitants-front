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
                    <h1>Tu bici, <span class="color">tu ciudad</span></h1>
                    <h2>Accesorios innovadores para ciclistas urbanos</h2>
                    <a href="{{ route('shop.catalogue') }}"
                       class="btn btn-default btn-lg">Visita nuestra tienda</a>

                    <div class="content services services-3x">
                        <div class="row row-no-padding">

                            <!-- SERVICE - START -->
                            <div class="col-xs-4 col-sm-4">
                                <div class="service">
                                    <i class="@lang('home.first_box_i')"></i>
                                    <h3>@lang('home.first_box_h3')</h3>
                                    <p>@lang('home.first_box_p')</p>
                                </div>
                            </div>
                            <!-- SERVICE - END -->

                            <!-- SERVICE - START -->
                            <div class="col-xs-4 col-sm-4">
                                <div class="service">
                                    <i class="@lang('home.second_box_i')"></i>
                                    <h3>@lang('home.second_box_h3')</h3>
                                    <p>@lang('home.second_box_p')</p>
                                </div>
                            </div>
                            <!-- SERVICE - END -->

                            <!-- SERVICE - START -->
                            <div class="col-xs-4 col-sm-4">
                                <div class="service">
                                    <i class="@lang('home.third_box_i')"></i>
                                    <h3>@lang('home.third_box_h3')</h3>
                                    <p>@lang('home.third_box_p')</p>
                                </div>
                            </div>
                            <!-- SERVICE - END -->

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
    GRID PRODUCTS - START
=========================== -->
<section class="content grid-products border-top">
    <div class="container">
        <div class="row">
            @foreach($productsLeft as $product)
                <div class="col-xs-6 col-sm-3">
                    <article class="product-item">
                        <div class="product-overlay">
                            <a href="{{ route('shop.slug', ['slug' => $product->slug ]) }}">
                                <div class="product-mask">
                                    {!! Form::img($product->front_image_hover->filename, StaticVars::productRelated(), $product->front_image_hover->alt) !!}
                                </div>
                                {!! Form::img($product->front_image->filename, StaticVars::homeLeft(), $product->front_image->alt) !!}
                            </a>
                        </div>
                        <a href="{{ route('shop.slug', ['slug' => $product->slug ]) }}">
                            <h3>{{ $product->name }}</h3>
                        </a>
                        @include('partials.rating', ['rating' => $product->rating])
                        @include('partials.price')
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
                                <a href="{{ route('shop.slug', ['slug' => $product->slug ]) }}">
                                    <div class="product-mask">
                                        {!! Form::img($product->front_image_hover->filename, StaticVars::homeLeft(), $product->front_image_hover->alt) !!}
                                    </div>
                                    {!! Form::img($product->front_image->filename, StaticVars::homeLeft(), $product->front_image->alt) !!}
                                </a>
                            </div>
                            <a href="{{ route('shop.slug', ['slug' => $product->slug ]) }}">
                                <h3>{{ $product->name }}</h3>
                            </a>
                            @include('partials.rating', ['rating' => $product->rating])
                            @include('partials.price')
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
    CATEGORIES - START
=========================== -->
<section class="content categories">
    <div class="row row-no-padding">
        <!-- CATEGORY - START -->
        @foreach($categories as $category)
            <div class="col-xs-4 col-md-2">
                <div class="category">
                    <a href="{{ route('shop.slug', ['slug' => $category->slug]) }}">
                        {!! Form::img($category->filename, StaticVars::homeCategories(), $category->name) !!}
                        <div class="category-mask"></div>
                        <h3 class="category-title"><span>{!!  str_replace(' ', '<br/>', $category->name) !!}</span></h3>
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
            <h2>@lang('home.blog_h2')</h2>
            <p>@lang('home.blog_p')</p>
        </div>
        <div class="row">
            <!-- BLOG POST - START -->
            @foreach($feed as $post)
                <div class="col-xs-6 col-sm-3">
                    <article class="post">
                        <img data-src="{{ Form::postImage($post->get_description()) }}" class="lazyload img-responsive"
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