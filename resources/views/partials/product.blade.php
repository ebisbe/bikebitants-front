<article class="product-item product-single">
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
                <h3>{{ $product->name }}</h3>
                <div class="product-labels">
                    @foreach($product->labels as $label)
                        <span class="label label-{{ $label->css }}">{{ $label->name }}</span>
                    @endforeach
                </div>
                @if(isset($product->rating))
                    <div class="product-rating">
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star-o"></i>
                        <i class="fa fa-star-o"></i>
                    </div>
                @endif
                <span class="price">
                    @if($product->is_discounted)
                        <del><span class="amount">{{ $product->range_real_price }} &euro;</span></del>
                    @endif
                    <ins><span class="amount">{{ $product->range_price }} &euro;</span></ins>
                </span>
                <ul class="list-unstyled product-info">
                    <li><span>ID</span>{{ $product->_id }}</li>
                    <li><span>Availability</span>In Stock</li>
                    <li><span>Brand</span><a
                                href="{{ route('shop.brand', ['slug' => $product->brand->slug]) }}">{{ $product->brand->name }}</a>
                    </li>
                    <li><span>Tags</span>{{ $product->tags_list }}</li>
                </ul>
                <p>{{ $product->introduction }}</p>
                <div class="product-form clearfix">
                    <form action="/cart" class="js-add-to-cart" method="POST">
                        {{ csrf_field() }}
                        <input type="hidden" name="product_id" value="{{ $product->_id }}">

                        <div class="row row-no-padding">

                            <div class="col-md-3 col-sm-4">
                                <div class="product-quantity clearfix">
                                    <a class="btn btn-default" id="qty-minus">-</a>
                                    <input type="text" class="form-control" id="qty" name="quantity" value="1">
                                    <a class="btn btn-default" id="qty-plus">+</a>
                                </div>
                            </div>

                            @foreach($product->attributes()->all() as $attribute)
                                <div class="col-md-3 col-sm-4">
                                    <div class="product-size">
                                        <div class="form-inline">
                                            <div class="form-group">
                                                <label>{{ $attribute->uc_name }}:</label>
                                            </div>
                                            <div class="form-group">
                                                <select name="attributes[{{ $attribute->name }}]" class="form-control">
                                                    @foreach($attribute->attribute_values()->all() as $value)
                                                        <option value="{{ $value->_id }}">
                                                            {{ $value->name }}
                                                            {!! !empty($value->complementary_text) ? '('.$value->complementary_text.')' : '' !!}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            <div class="col-md-2 col-sm-12">
                                <button type="submit" class="btn btn-primary add-to-cart js-add-button">
                                    <i class="fa fa-shopping-cart"></i>
                                    Add to cart
                                </button>
                            </div>

                        </div>
                    </form>
                </div>
                {{--<ul class="list-inline product-links">
                    <li><a href="#"><i class="fa fa-heart"></i>Add to wishlist</a></li>
                    <li><a href="#"><i class="fa fa-exchange"></i>Compare</a></li>
                    <li><a href="#"><i class="fa fa-envelope"></i>Email to friend</a></li>
                </ul>--}}
            </div>
        </div>
    </div>
</article>