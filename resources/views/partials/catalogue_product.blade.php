<div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
    <article class="product-item">
        <div class="row">
            <div class="col-sm-3">
                <div class="product-overlay">
                    <div class="product-mask">
                        {!! Form::img($product->front_image_hover->filename, StaticVars::productRelated(), $product->front_image_hover->alt, StaticVars::imgWrapper()) !!}
                    </div>
                    <a href="{{ route('shop.slug', ['slug' => $product->slug]) }}"
                       onclick="onProduct{{ $iteration }}Click(); return !ga.loaded;"
                       class="product-permalink"></a>
                    {!! Form::img($product->front_image->filename, StaticVars::productRelated(), $product->front_image->alt, StaticVars::imgWrapper()) !!}
                    {{--<div class="product-quickview">
                        <a class="btn btn-quickview"
                           data-toggle="modal"
                           data-target="#product-quickview"
                           data-product="{{ Form::product($product) }}"
                        >Quick View</a>
                    </div>--}}
                </div>
            </div>
            <div class="col-sm-9">
                <div class="product-body">
                    @include('partials.labels')
                    <h3>
                        <a href="{{ route('shop.slug', ['slug' => $product->slug]) }}"
                           onclick="onProduct{{ $iteration }}Click(); return !ga.loaded;">
                            {{ str_limit($product->name, 29) }}
                        </a>
                    </h3>
                    @include('partials.product_rating', ['rating' => $product->rating, 'total_reviews' => count($product->reviews)])
                    @include('partials.price', ['class' => 'blocked'])
                    <div class="p">{!! $product->introduction !!}</div>
                    <div class="buttons">
                        @include('partials.buy_buttons')
                    </div>
                </div>
            </div>
        </div>
    </article>
</div>