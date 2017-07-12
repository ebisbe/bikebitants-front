<article class="product-item product-single" >
    <div class="row">
        <div class="col-{{ $col_size }}-4">
            <div class="product-carousel-wrapper {{ !empty($hidden) ? 'hidden' : '' }}">
                <owl-carrousel :images='{!! json_encode($product->images->toArray()) !!}'></owl-carrousel>
            </div>
        </div>
        <div class="col-{{ $col_size }}-8">
            <div class="product-body">
                <h1 itemprop="name">{{ $product->name }}</h1>
                @include('partials.labels')
                @include('partials.product_rating', ['rating' => $product->rating, 'total_reviews' => count($product->reviews)])
                @include('partials.price')
                <ul class="list-unstyled product-info">
                    @if(isset($product->brand))
                    <li><span>@lang('catalogue.brand')</span><a
                                href="{{ route('shop.brand', ['slug' => $product->brand->slug]) }}">{{ $product->brand->name }}</a>
                    </li>
                    @endif
                    <li class="tags"><span>@lang('catalogue.tags')</span>
                        @foreach($product->tag as $tag)
                            <span class="label">
                                <i class="fa fa-tag"></i>
                                <a href="{{ route('shop.tag', ['slug' => $tag->slug]) }}">{{ $tag->name }}</a>
                            </span>
                        @endforeach
                    </li>
                </ul>
                <div itemprop="description">{!! $product->introduction !!}</div>
                <div class="product-form clearfix">
                    <script type="text/javascript"
                            src="https://cdn.pagamastarde.com/pmt-js-client-sdk/3/js/client-sdk.min.js">
                    </script>
                    <script>
                        (function(){
                            pmtClient.setPublicKey('pk_f3482c65406299a37f3aab53');
                            pmtClient.simulator.init();
                        })();
                    </script>
                    <product-form
                            product_id="{{ $product->_id }}"
                            :properties='{!! json_encode($product->properties()->sortBy('order')->values()->all()) !!}'
                            :variations='{!! json_encode($product->variations()->all()) !!}'
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