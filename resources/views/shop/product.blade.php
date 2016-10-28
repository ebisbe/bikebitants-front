@extends('layouts.shop')

@section('content')

@include('partials.breadcrumb')
        <!-- ==========================
PRODUCTS - START
=========================== -->
<section class="content products">
    <div class="container">
        @include('partials.product', ['col_size' => 'xs'])

        <div class="tabs product-tabs">
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active">
                    <a href="#description"
                       role="tab"
                       data-toggle="tab"
                       aria-controls="description"
                       aria-expanded="false">Description</a>
                </li>
                <li role="presentation">
                    <a href="#reviews"
                       role="tab"
                       data-toggle="tab"
                       aria-controls="reviews"
                       aria-expanded="true">Reviews ({!! $product->reviewsVerified->count() !!})</a>
                </li>
                <li role="presentation">
                    <a href="#video"
                       role="tab"
                       data-toggle="tab"
                       aria-controls="video"
                       aria-expanded="false">Responsive Video</a>
                </li>
                <li role="presentation">
                    <a href="#faq"
                       role="tab"
                       data-toggle="tab"
                       aria-controls="faq"
                       aria-expanded="false">FAQ</a>
                </li>
            </ul>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active in " id="description">
                    {!! $product->description !!}
                </div>
                <div role="tabpanel" class="tab-pane " id="reviews">

                    <div class="comments">

                        @foreach($product->reviewsVerified as $review)
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

                <div role="tabpanel" class="tab-pane panel-group" id="faq">
                    {{--*/$x=0/* --}}
                    @foreach($product->faqs as $faq)
                        {{--*/$x++/* --}}
                        <div class="panel panel-primary">
                            <div class="panel-heading" role="tab">
                                <h4 class="panel-title"><a class="collapsed" role="button" data-toggle="collapse"
                                                           href="#faq-{{ $x }}" aria-expanded="false"
                                                           aria-controls="faq-{{ $x }}">{{ $faq->name }}</a></h4>
                            </div>
                            <div aria-expanded="false" id="faq-{{ $x }}" class="panel-collapse collapse"
                                 role="tabpanel">
                                <div class="panel-body">{{ $faq->answer }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="releated-products">
            <h2>Related Products</h2>
            <div class="row grid" id="products">
                <!-- PRODUCT - START -->
                @foreach($relatedProducts as $relatedProduct)
                    <div class="col-sm-3 col-xs-6">
                        <article class="product-item">
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="product-overlay">
                                        <div class="product-mask"></div>
                                        <a href="{{ route('shop.product', $relatedProduct->slug) }}"
                                           class="product-permalink"></a>
                                        {!! Form::img($relatedProduct->front_image->filename, StaticVars::productRelated(), $relatedProduct->front_image->filename) !!}
                                        <div class="product-quickview">
                                            <a class="btn btn-quickview" data-toggle="modal"
                                               data-target="#product-{{ $relatedProduct->slug }}">Quick View</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-9">
                                    <div class="product-body">
                                        <h3>{{ $relatedProduct->name }}</h3>
                                        @include('partials.price', ['product' => $relatedProduct])
                                        <p></p>
                                        <div class="buttons buttons-simple">
                                            {{--<a href=""><i class="fa fa-exchange"></i></a>--}}
                                            <a href=""><i class="fa fa-shopping-cart"></i></a>
                                            {{--<a href=""><i class="fa fa-heart"></i></a>--}}
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
    PRODUCTS - END
=========================== -->

<!-- ==========================
   PRODUCT QUICKVIEW - START
=========================== -->
@foreach($relatedProducts as $relatedProduct)

    <div class="modal fade modal-quickview" id="product-{{ $relatedProduct->slug }}" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i
                                class="fa fa-times"></i></button>
                </div>
                <div class="modal-body">
                    {{--@include('partials.product', ['product' => $relatedProduct, 'col_size' => 'sm', 'hidden' => true, 'modal' => true])--}}
                </div>
            </div>
        </div>
    </div>
    <!-- ==========================
        PRODUCT QUICKVIEW - END
    =========================== -->
@endforeach


<!-- ==========================
   ADD REVIEW - START
=========================== -->
<div class="modal fade modal-add-review" id="add-review" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="fa fa-times"></i>
                </button>
                <h4 class="modal-title">Add a review</h4>
            </div>
            <div class="modal-body">
                <add-review
                        product_id="{{ $product->_id }}"
                        token="{{csrf_token()}}">
                </add-review>
            </div>
        </div>
    </div>
</div>
<!-- ==========================
    ADD REVIEW - END
=========================== -->

@endsection
