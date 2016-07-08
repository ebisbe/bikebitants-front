@extends('layouts.shop')

@section('content')

        <!-- ==========================
    	BREADCRUMB - START
    =========================== -->
<section class="breadcrumb-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-xs-6">
                <h2>Women</h2>
                <p>Dresses</p>
            </div>
            <div class="col-xs-6">
                <ol class="breadcrumb">
                    <li><a href="index.html">Home</a></li>
                    <li><a href="products.html">Women</a></li>
                    <li class="active">Dresses</li>
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
        <h2 class="hidden">Products</h2>
        <form action="/tienda" method="GET">
            <div class="row">
                <div class="col-sm-3">
                    <aside class="sidebar">

                        <!-- WIDGET:CATEGORIES - START -->
                        <div class="widget widget-categories">
                            <h3><a role="button" data-toggle="collapse" href="#widget-categories-collapse"
                                   aria-expanded="true" aria-controls="widget-categories-collapse">Categories</a></h3>
                            <div class="collapse in" id="widget-categories-collapse" aria-expanded="true"
                                 role="tabpanel">
                                <div class="widget-body">
                                    <ul class="list-unstyled" id="categories" role="tablist"
                                        aria-multiselectable="true">
                                        <li class="panel"><a class="collapsed" role="button" data-toggle="collapse"
                                                             data-parent="#categories" href="#parent-1"
                                                             aria-expanded="false"
                                                             aria-controls="parent-1">Men<span>[12]</span></a>
                                            <ul id="parent-1" class="list-unstyled panel-collapse collapse" role="menu">
                                                <li><a href="#">Accessories</a></li>
                                                <li><a href="#">Jackets</a></li>
                                                <li><a href="#">Jumpers</a></li>
                                                <li><a href="#">Jeans</a></li>
                                                <li><a href="#">Shoes</a></li>
                                                <li><a href="#">T-Shirt & Polo Shirts</a></li>
                                                <li><a href="#">Blazers</a></li>
                                            </ul>
                                        </li>
                                        <li class="panel"><a role="button" data-toggle="collapse"
                                                             data-parent="#categories"
                                                             href="#parent-2" aria-expanded="true"
                                                             aria-controls="parent-2">Women<span>[34]</span></a>
                                            <ul id="parent-2" class="list-unstyled panel-collapse collapse in"
                                                role="menu">
                                                <li><a href="#">Accessories</a></li>
                                                <li><a href="#">Swimwear</a></li>
                                                <li><a href="#">Basics</a></li>
                                                <li class="active"><a href="#">Dresses</a></li>
                                                <li><a href="#">Jeans</a></li>
                                                <li><a href="#">Skirts</a></li>
                                                <li><a href="#">Leggings</a></li>
                                            </ul>
                                        </li>
                                        <li class="panel"><a class="collapsed" role="button" data-toggle="collapse"
                                                             data-parent="#categories" href="#parent-3"
                                                             aria-expanded="false"
                                                             aria-controls="parent-3">Accessories<span>[8]</span></a>
                                            <ul id="parent-3" class="list-unstyled panel-collapse collapse" role="menu">
                                                <li><a href="#">Basics</a></li>
                                                <li><a href="#">Shirts</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- WIDGET:CATEGORIES - END -->

                        <!-- WIDGET:PRICE - START -->
                        <div class="widget widget-price">
                            <h3><a role="button"
                                   data-toggle="collapse"
                                   href="#widget-price-collapse"
                                   aria-expanded="true"
                                   aria-controls="widget-price-collapse">Filter by price</a>
                            </h3>
                            <div class="collapse in" id="widget-price-collapse" aria-expanded="true" role="tabpanel">
                                <div class="widget-body">
                                    <div class="price-slider">
                                        <input type="hidden" class="min" name="min_price"
                                               data-min="{{ StaticVars::filterMinimumValue() }}"
                                               data-value="{{ $filters['min_price'] }}" readonly>
                                        <input type="hidden" class="max" name="max_price"
                                               data-max="{{ StaticVars::filterMaximumValue() }}"
                                               data-value="{{ $filters['max_price'] }}" readonly>
                                        <span class="fake-input pull-left">
                                            <span class="min"></span>&euro;
                                        </span>
                                        <span class="fake-input pull-right text-right">
                                            <span class="max"></span>&euro;
                                        </span>
                                        <div id="slider-range"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- WIDGET:PRICE - END -->

                    </aside>
                </div>
                <div class="col-sm-9">
                    <div class="products-header">
                        <div class="row">
                            <div class="col-xs-6 col-sm-4">
                                <div class="form-inline products-per-page">
                                    <div class="form-group">
                                        <label>Show:</label>
                                    </div>
                                    <div class="form-group">
                                        <select class="form-control" name="show">
                                            @foreach(StaticVars::filterShow() as $option)
                                                <option value="{{ $option }}" {!! $filters['show'] == $option ? 'selected="selected"' : '' !!}>{{ $option }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-6 col-sm-8">
                                <div class="btn-group toggle-list-grid hidden-xs" role="group">
                                    <button type="button" class="btn btn-default active" id="toggle-grid">
                                        <i class="fa fa-th"></i>
                                    </button>
                                    <button type="button" class="btn btn-default" id="toggle-list">
                                        <i class="fa fa-list"></i>
                                    </button>
                                </div>
                                <div class="form-inline order-by">
                                    <div class="form-group">
                                        <label>Sort by:</label>
                                    </div>
                                    <div class="form-group">
                                        <select class="form-control" name="sort">
                                            @foreach(StaticVars::filterSortingType() as $isSelected => $option)
                                                <option value="{{ $option }}" {!! $filters['sort'] == $option ? 'selected="selected"' : '' !!}>{{ trans('filters.sorting.'.$option) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="row grid" id="products">

                        <!-- PRODUCT - START -->
                        @foreach($products as $product)
                            <div class="col-sm-3 col-xs-4">
                                <article class="product-item">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="product-overlay">
                                                <div class="product-mask"></div>
                                                <a href="{{ route('shop.product', ['slug' => $product->slug]) }}"
                                                   class="product-permalink"></a>
                                                    {!! Form::img($product->images()->first()->path, StaticVars::productRelated(), $product->images()->first()->alt, StaticVars::imgWrapper()) !!}
                                                <div class="product-quickview">
                                                    <a class="btn btn-quickview"
                                                        data-toggle="modal"
                                                        data-target="#product-quickview"
                                                        data-product="{{ Form::product($product) }}"
                                                    >Quick View</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-9">
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
                                                    <span class="amount">{{ $product->range_price }}</span>
                                                </span>
                                                <p>{{ $product->description }}</p>
                                                <div class="buttons">
                                                    {{--<a href="" class="btn btn-primary btn-sm"><i class="fa fa-exchange"></i></a>--}}
                                                    <a href="" class="btn btn-primary btn-sm add-to-cart"><i
                                                                class="fa fa-shopping-cart"></i>Add to cart</a>
                                                    {{--<a href="" class="btn btn-primary btn-sm"><i--}}
                                                    {{--class="fa fa-heart"></i></a>--}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                            </div>
                            @endforeach
                                    <!-- PRODUCT - END -->

                    </div>
                    @if($filters['show'] != 'all')
                        <div class="pagination-wrapper">
                            {{ $products->appends($filters)->links() }}
                        </div>
                    @endif

                </div>
                <button type="submit" class="btn btn-primary add-to-cart js-add-button">
                    <i class="fa fa-shopping-cart"></i>
                    Add to cart
                </button>
            </div>

        </form>
    </div>
</section>
<!-- ==========================
    PRODUCTS - END
=========================== -->

@endsection