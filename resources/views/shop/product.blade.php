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
                       aria-expanded="false">@lang('catalogue.description')</a>
                </li>
                <li role="presentation">
                    <a href="#reviews"
                       role="tab"
                       data-toggle="tab"
                       aria-controls="reviews"
                       aria-expanded="true">@lang('catalogue.reviews', ['total' => $product->reviewsVerified->count()])</a>
                </li>
                @if(!empty($product->video))
                    <li role="presentation">
                        <a href="#video"
                           role="tab"
                           data-toggle="tab"
                           aria-controls="video"
                           aria-expanded="false">@lang('catalogue.video')</a>
                    </li>
                @endif
                @if($product->faqs->count() > 0)
                    <li role="presentation">
                        <a href="#faq"
                           role="tab"
                           data-toggle="tab"
                           aria-controls="faq"
                           aria-expanded="false">@lang('catalogue.faq')</a>
                    </li>
                @endif
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

                    @if($product->reviews_allowed)
                        <a class="btn btn-primary btn-lg" data-toggle="modal"
                           data-target="#add-review">@lang('catalogue.add_review')</a>
                    @endif
                </div>
                @if(!empty($product->video))
                    <div role="tabpanel" class="tab-pane" id="video">
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe allowfullscreen="" src="{{ $product->video }}"></iframe>
                        </div>
                    </div>
                @endif
                @if($product->faqs->count() > 0)
                    <div role="tabpanel" class="tab-pane panel-group" id="faq">
                        @foreach($product->faqs as $faq)
                            <div class="panel panel-primary">
                                <div class="panel-heading" role="tab">
                                    <h4 class="panel-title"><a class="collapsed" role="button" data-toggle="collapse"
                                                               href="#faq-{{ $loop->iteration }}" aria-expanded="false"
                                                               aria-controls="faq-{{ $loop->iteration }}">{{ $faq->name }}</a>
                                    </h4>
                                </div>
                                <div aria-expanded="false" id="faq-{{ $loop->iteration }}"
                                     class="panel-collapse collapse"
                                     role="tabpanel">
                                    <div class="panel-body">{{ $faq->answer }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        @if($relatedProducts->count() > 0)
            <div class="releated-products">
                <h2>@lang('catalogue.related_products')</h2>
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
                                            <h3>
                                                <a href="{{ route('shop.product', $relatedProduct->slug) }}">
                                                    {{ $relatedProduct->name }}
                                                </a>
                                            </h3>
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
        @endif
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
                    @include('partials.product', ['product' => $relatedProduct, 'col_size' => 'sm', 'hidden' => true, 'modal' => true])
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
                    <h4 class="modal-title">@lang('catalogue.add_review')</h4>
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
