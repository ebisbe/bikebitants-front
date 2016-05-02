@extends('layouts.shop')

@section('main')

        <!-- ==========================
BREADCRUMB - START
=========================== -->
<section class="breadcrumb-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-xs-6">
                <h2>Women</h2>
                <p>{{ $product->name }}</p>
            </div>
            <div class="col-xs-6">
                <ol class="breadcrumb">
                    <li><a href="index.html">Home</a></li>
                    <li><a href="products.html">Women</a></li>
                    <li><a href="products.html">Dresses</a></li>
                    <li class="active">Fusce Aliquam</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<!-- ==========================
    BREADCRUMB - END
=========================== -->

<!-- ==========================
PRODUCTS - START
=========================== -->
<section class="content products">
    <div class="container">
        <article class="product-item product-single">
            <div class="row">
                <div class="col-xs-4">
                    <div class="product-carousel-wrapper">
                        <div id="product-carousel">
                            <div class="item">
                                <img src="/images/products/product-1.jpg" class="img-responsive" alt="">
                            </div>
                            <div class="item">
                                <img src="/images/products/product-2.jpg" class="img-responsive"
                                                   alt="">
                            </div>
                            <div class="item">
                                <img src="/images/products/product-3.jpg" class="img-responsive"
                                                   alt="">
                            </div>
                            <div class="item"><img src="/images/products/product-4.jpg" class="img-responsive"
                                                   alt=""></div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-8">
                    <div class="product-body">
                        <h3>{{ $product->name }}</h3>
                        <div class="product-labels">
                            @foreach($product->labels as $label)
                                <span class="label label-{{ $label->css }}">{{ $label->name }}</span>
                            @endforeach
                        </div>
                        <div class="product-rating">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star-o"></i>
                            <i class="fa fa-star-o"></i>
                        </div>
                            <span class="price">
                                <del><span class="amount">{{ $product->price }} &euro;</span></del>
                                <ins><span class="amount">{{ $product->price }} &euro;</span></ins>
                            </span>
                        <ul class="list-unstyled product-info">
                            <li><span>ID</span>{{ $product->_id }}</li>
                            <li><span>Availability</span>In Stock</li>
                            <li><span>Brand</span>Esprit</li>
                            <li><span>Tags</span>{{ $product->getTagsArray() }}</li>
                        </ul>
                        <p>{{ $product->introduction }}</p>
                        <div class="product-form clearfix">
                            <div class="row row-no-padding">

                                <div class="col-md-3 col-sm-4">
                                    <div class="product-quantity clearfix">
                                        <a class="btn btn-default" id="qty-minus">-</a>
                                        <input type="text" class="form-control" id="qty" value="1">
                                        <a class="btn btn-default" id="qty-plus">+</a>
                                    </div>
                                </div>

                                <div class="col-md-3 col-sm-4">
                                    <div class="product-size">
                                        <div class="form-inline">
                                            <div class="form-group">
                                                <label>Size:</label>
                                            </div>
                                            <div class="form-group">
                                                <select class="form-control">
                                                    @foreach($product->sizes as $size)
                                                        <option>{{ $size->name }} ({{ $size->complementary_text }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-4">
                                    <div class="product-color">
                                        <div class="form-inline">
                                            <div class="form-group">
                                                <label>Color:</label>
                                            </div>
                                            <div class="form-group">
                                                <select class="form-control">
                                                    @foreach($product->colors as $color)
                                                        <option>{{ $color->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-2 col-sm-12">
                                    <a href="" class="btn btn-primary add-to-cart"><i
                                                class="fa fa-shopping-cart"></i>Add
                                        to cart</a>
                                </div>

                            </div>
                        </div>
                        <ul class="list-inline product-links">
                            <li><a href="#"><i class="fa fa-heart"></i>Add to wishlist</a></li>
                            <li><a href="#"><i class="fa fa-exchange"></i>Compare</a></li>
                            <li><a href="#"><i class="fa fa-envelope"></i>Email to friend</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </article>

        <div class="tabs product-tabs">
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class=""><a href="#description" role="tab" data-toggle="tab"
                                                    aria-controls="description" aria-expanded="false">Description</a>
                </li>
                <li role="presentation" class="active"><a href="#reviews" role="tab" data-toggle="tab"
                                                          aria-controls="reviews" aria-expanded="true">Reviews
                        ({!! count($product->reviews) !!})</a>
                </li>
                <li role="presentation" class=""><a href="#video" role="tab" data-toggle="tab" aria-controls="video"
                                                    aria-expanded="false">Responsive Video</a></li>
            </ul>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane" id="description">
                    {{ $product->description }}
                </div>
                <div role="tabpanel" class="tab-pane active in" id="reviews">

                    <div class="comments">

                        @foreach($product->reviews as $review)
                            @include('partials.review', ['review' => $review, 'reply' => true])
                        @endforeach

                    </div>

                    <a class="btn btn-primary btn-lg" data-toggle="modal" data-target="#add-review">Add Review</a>

                </div>
                <div role="tabpanel" class="tab-pane" id="video">
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe allowfullscreen=""
                                src="{{ $product->video }}"></iframe>
                    </div>
                </div>
            </div>
        </div>

        <div class="releated-products">
            <h2>Related Products</h2>
            <div class="row grid" id="products">

                <!-- PRODUCT - START -->
                <div class="col-sm-3 col-xs-6">
                    <article class="product-item">
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="product-overlay">
                                    <div class="product-mask"></div>
                                    <a href="single-product.html" class="product-permalink"></a>
                                    <img src="/images/products/product-1.jpg" class="img-responsive" alt="">
                                    <div class="product-quickview">
                                        <a class="btn btn-quickview" data-toggle="modal"
                                           data-target="#product-quickview">Quick View</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-9">
                                <div class="product-body">
                                    <h3>Lorem ipsum dolor sit amet consectetur</h3>
                                        <span class="price">
                                            <del><span class="amount">$36.00</span></del>
                                            <ins><span class="amount">$30.00</span></ins>
                                        </span>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut feugiat mauris eget
                                        magna egestas porta. Curabitur sagittis sagittis neque rutrum congue. Donec
                                        lobortis dui sagittis, ultrices nunc ornare, ultricies elit. Curabitur tristique
                                        felis pulvinar nibh porta. </p>
                                    <div class="buttons buttons-simple">
                                        <a href=""><i class="fa fa-exchange"></i></a>
                                        <a href=""><i class="fa fa-shopping-cart"></i></a>
                                        <a href=""><i class="fa fa-heart"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>
                <!-- PRODUCT - END -->

                <!-- PRODUCT - START -->
                <div class="col-sm-3 col-xs-6">
                    <article class="product-item">
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="product-overlay">
                                    <div class="product-mask"></div>
                                    <a href="single-product.html" class="product-permalink"></a>
                                    <img src="/images/products/product-2.jpg" class="img-responsive" alt="">
                                    <div class="product-quickview">
                                        <a class="btn btn-quickview" data-toggle="modal"
                                           data-target="#product-quickview">Quick View</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-9">
                                <div class="product-body">
                                    <h3>Lorem ipsum dolor sit amet consectetur</h3>
                                        <span class="price">
                                            <del><span class="amount">$36.00</span></del>
                                            <ins><span class="amount">$30.00</span></ins>
                                        </span>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut feugiat mauris eget
                                        magna egestas porta. Curabitur sagittis sagittis neque rutrum congue. Donec
                                        lobortis dui sagittis, ultrices nunc ornare, ultricies elit. Curabitur tristique
                                        felis pulvinar nibh porta. </p>
                                    <div class="buttons buttons-simple">
                                        <a href=""><i class="fa fa-exchange"></i></a>
                                        <a href=""><i class="fa fa-shopping-cart"></i></a>
                                        <a href=""><i class="fa fa-heart"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>
                <!-- PRODUCT - END -->

                <!-- PRODUCT - START -->
                <div class="col-sm-3 col-xs-6">
                    <article class="product-item">
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="product-overlay">
                                    <div class="product-mask"></div>
                                    <a href="single-product.html" class="product-permalink"></a>
                                    <img src="/images/products/product-3.jpg" class="img-responsive" alt="">
                                    <div class="product-quickview">
                                        <a class="btn btn-quickview" data-toggle="modal"
                                           data-target="#product-quickview">Quick View</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-9">
                                <div class="product-body">
                                    <h3>Lorem ipsum dolor sit amet consectetur</h3>
                                        <span class="price">
                                            <del><span class="amount">$36.00</span></del>
                                            <ins><span class="amount">$30.00</span></ins>
                                        </span>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut feugiat mauris eget
                                        magna egestas porta. Curabitur sagittis sagittis neque rutrum congue. Donec
                                        lobortis dui sagittis, ultrices nunc ornare, ultricies elit. Curabitur tristique
                                        felis pulvinar nibh porta. </p>
                                    <div class="buttons buttons-simple">
                                        <a href=""><i class="fa fa-exchange"></i></a>
                                        <a href=""><i class="fa fa-shopping-cart"></i></a>
                                        <a href=""><i class="fa fa-heart"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>
                <!-- PRODUCT - END -->

                <!-- PRODUCT - START -->
                <div class="col-sm-3 col-xs-6">
                    <article class="product-item">
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="product-overlay">
                                    <div class="product-mask"></div>
                                    <a href="single-product.html" class="product-permalink"></a>
                                    <img src="/images/products/product-4.jpg" class="img-responsive" alt="">
                                    <div class="product-quickview">
                                        <a class="btn btn-quickview" data-toggle="modal"
                                           data-target="#product-quickview">Quick View</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-9">
                                <div class="product-body">
                                    <h3>Lorem ipsum dolor sit amet consectetur</h3>
                                        <span class="price">
                                            <del><span class="amount">$36.00</span></del>
                                            <ins><span class="amount">$30.00</span></ins>
                                        </span>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut feugiat mauris eget
                                        magna egestas porta. Curabitur sagittis sagittis neque rutrum congue. Donec
                                        lobortis dui sagittis, ultrices nunc ornare, ultricies elit. Curabitur tristique
                                        felis pulvinar nibh porta. </p>
                                    <div class="buttons buttons-simple">
                                        <a href=""><i class="fa fa-exchange"></i></a>
                                        <a href=""><i class="fa fa-shopping-cart"></i></a>
                                        <a href=""><i class="fa fa-heart"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>
                <!-- PRODUCT - END -->

            </div>
        </div>

    </div>
</section>
<!-- ==========================
    PRODUCTS - END
=========================== -->
@endsection
