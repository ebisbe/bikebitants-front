<article class="product-item product-single">
    <div class="row">
        <div class="col-{{ $col_size }}-4">
            <div class="product-carousel-wrapper {{ !empty($hidden) ? 'hidden' : '' }}">
                <div id="product-carousel" class="product-carousel">
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
                            <del><span class="amount">{{ $product->price }} &euro;</span></del>
                            <ins><span class="amount">{{ $product->price }} &euro;</span></ins>
                        </span>
                <ul class="list-unstyled product-info">
                    <li><span>ID</span>{{ $product->_id }}</li>
                    <li><span>Availability</span>In Stock</li>
                    <li><span>Brand</span>{{ $product->brand->name }}</li>
                    <li><span>Tags</span>{{ $product->getTagsArray() }}</li>
                </ul>
                <p>{{ $product->introduction }}</p>
                <div class="product-form clearfix">
                    <form action="/cart" class="js-add-to-cart" method="POST">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="product_id" value="{{ $product->_id }}">

                        <div class="row row-no-padding">

                            <div class="col-md-3 col-sm-4">
                                <div class="product-quantity clearfix">
                                    <a class="btn btn-default" id="qty-minus">-</a>
                                    <input type="text" class="form-control" id="qty" name="quantity" value="1">
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
                                            <select name="size" class="form-control">
                                                @foreach($product->sizes as $size)
                                                    <option value="{{ $size->_id }}">{{ $size->name }}
                                                        ({{ $size->complementary_text }})
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
                                            <select name="color" class="form-control">
                                                @foreach($product->colors as $color)
                                                    <option value="{{ $color->_id }}">{{ $color->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-2 col-sm-12">
                                <button type="submit" class="btn btn-primary add-to-cart js-add-button">
                                    <i class="fa fa-shopping-cart"></i>
                                    Add to cart
                                </button>
                            </div>

                        </div>
                    </form>
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