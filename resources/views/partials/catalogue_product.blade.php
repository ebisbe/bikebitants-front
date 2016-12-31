<div class="col-xs-4 col-sm-4 col-md-4 col-lg-3">
    <article class="product-item">
        <div class="row">
            <div class="col-sm-3">
                <div class="product-overlay">
                    <div class="product-mask">
                        {!! Form::img($product->front_image_hover->filename, StaticVars::productRelated(), $product->front_image_hover->alt, StaticVars::imgWrapper()) !!}
                    </div>
                    <a href="{{ route('shop.slug', ['slug' => $product->slug]) }}"
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
                    <h1>
                        <a href="{{ route('shop.slug', ['slug' => $product->slug]) }}">
                            {{ str_limit($product->name, 29) }}
                        </a>
                    </h1>
                    @include('partials.labels')
                    @include('partials.rating', ['rating' => $product->rating])
                    @include('partials.price', ['class' => 'blocked'])
                    <div class="p">{!! $product->introduction !!}</div>
                    <div class="buttons">
                        {{--<a href="" class="btn btn-primary btn-sm"><i class="fa fa-exchange"></i></a>--}}
                        @if($product->stock == 0)
                            <a href="{{ route('shop.slug', ['slug' => $product->slug]) }}"
                               class="btn btn-transparent btn-sm add-to-cart">
                                @lang('catalogue.read_more')
                            </a>
                        @elseif($product->variations->count() > 1)
                            <a href="{{ route('shop.slug', ['slug' => $product->slug]) }}"
                               class="btn btn-transparent btn-sm add-to-cart">
                                @lang('catalogue.choose_options')
                            </a>
                        @else
                            <cart-add :quantity="1"
                                      product_id="{{ $product->_id }}"
                                      text="catalogue.add"
                                      :show_icon="true"
                                      button_class="btn btn-transparent btn-sm">
                            </cart-add>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </article>
</div>