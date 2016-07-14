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
                       aria-expanded="true">Reviews ({!! count($product->reviews) !!})</a>
                </li>
                <li role="presentation">
                    <a href="#video"
                       role="tab"
                       data-toggle="tab"
                       aria-controls="video"
                       aria-expanded="false">Responsive Video</a>
                </li>
            </ul>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active in " id="description">
                    {{ $product->description }}
                </div>
                <div role="tabpanel" class="tab-pane " id="reviews">

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

                @foreach($relatedProducts as $relatedProduct)
                    <div class="col-sm-3 col-xs-6">
                        <article class="product-item">
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="product-overlay">
                                        <div class="product-mask"></div>
                                        <a href="{{ route('shop.product', $relatedProduct->slug) }}" class="product-permalink"></a>
                                        {!! Form::img($relatedProduct->images->first()->filename, StaticVars::productRelated(), $relatedProduct->images->first()->filename) !!}
                                        <div class="product-quickview">
                                            <a class="btn btn-quickview" data-toggle="modal"
                                               data-target="#product-{{ $relatedProduct->slug }}">Quick View</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-9">
                                    <div class="product-body">
                                        <h3>{{ $relatedProduct->name }}</h3>
                                        <span class="price">
                                            <del><span class="amount">{{ $relatedProduct->price }} &euro;</span></del>
                                            <ins><span class="amount">{{ $relatedProduct->price }} &euro;</span></ins>
                                        </span>
                                        <p></p>
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
                    @include('partials.product', ['product' => $relatedProduct, 'col_size' => 'sm', 'hidden' => true, 'modal' => true])
                </div>
            </div>
        </div>
    </div>
<!-- ==========================
    PRODUCT QUICKVIEW - END
=========================== -->
@endforeach

@endsection
