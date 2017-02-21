<article class="product-item product-single" >
    <div class="row">
        <div class="col-{{ $col_size }}-4">
            <div class="product-carousel-wrapper {{ !empty($hidden) ? 'hidden' : '' }}">
                <div id="product-carousel" class="product-carousel">
                    @foreach($product->images as $image)
                        <div class="item">
                            {!! Form::img($image->filename, StaticVars::productDetail(), $image->alt) !!}
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-{{ $col_size }}-8">
            <div class="product-body">
                <h1 itemprop="name">{{ $product->name }}</h1>
                @include('partials.labels')
                @include('partials.product_rating', ['rating' => $product->rating, 'total_reviews' => count($product->reviews)])
                @include('partials.price')
                <ul class="list-unstyled product-info">
                    <li><span>@lang('catalogue.brand')</span><a
                                href="{{ route('shop.brand', ['slug' => $product->brand->slug]) }}">{{ $product->brand->name }}</a>
                    </li>
                    <li><span>@lang('catalogue.tags')</span>
                        @foreach($product->tags as $tag)
                            <a href="{{ route('shop.tag', ['slug' => $tag]) }}">{{ $tag }}</a>
                        @endforeach
                    </li>
                </ul>
                <div itemprop="description">{!! $product->introduction !!}</div>
                <div class="product-form clearfix">
                    <product-form
                            product_id="{{ $product->_id }}"
                            v-bind:properties='{!! json_encode($product->properties()->sortBy('order')->all()) !!}'
                            v-bind:variations='{!! json_encode($product->variations()->all()) !!}'
                    ></product-form>
                </div>
                {{--<ul class="list-inline product-links">
                    <li><a href="#"><i class="fa fa-heart"></i>Add to wishlist</a></li>
                    <li><a href="#"><i class="fa fa-exchange"></i>Compare</a></li>
                    <li><a href="#"><i class="fa fa-envelope"></i>Email to friend</a></li>
                </ul>--}}
            </div>
        </div>
    </div>
    <meta itemprop="url" content="{{ route('shop.slug', ['slug' => $product->slug]) }}" />
    <meta itemprop="sku" content="{{ $product->_id }}" />
</article>