@extends('layouts.shop')

@section('content')

@include('partials.breadcrumb')
        <!-- ==========================
PRODUCTS - START
=========================== -->
<section class="content products">
    <div class="container">
        <h2 class="hidden">Products</h2>
        <form action="" method="GET" id="js-catalogue">
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
                                        {{-- */$x=0;/* --}}
                                        @foreach($categories as $category)
                                            {{-- */$x++;/* --}}
                                            <li class="panel">
                                                <a class="{{ $category->_id == $selectedCat ? '' : 'collapsed' }}"
                                                   {{--role="button"
                                                   data-toggle="collapse"
                                                   data-parent="#categories"
                                                   href="#parent-{{ $x }}"
                                                   aria-expanded="true"
                                                   aria-controls="parent-{{ $x }}"--}}
                                                   href="{{ route('shop.category', ['category' => $category->slug]) }}">{{ $category->name }}
                                                    <span>[{{ $category->products }}]</span>
                                                </a>
                                                <ul id="parent-{{ $x }}"
                                                    class="list-unstyled panel-collapse collapse {{ $category->_id == $selectedCat ? 'in' : '' }}"
                                                    role="menu">
                                                    @foreach($category->children as $subcategory)
                                                        <li>
                                                            <a href="{{ route('shop.subcategory', ['category' => $category->slug, 'subcategory' => $subcategory->slug]) }}">{{ $subcategory->name }}</a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </li>
                                        @endforeach
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
                                               data-value="{{ $filters->get('min_price') }}" readonly>
                                        <input type="hidden" class="max" name="max_price"
                                               data-max="{{ StaticVars::filterMaximumValue() }}"
                                               data-value="{{ $filters->get('max_price') }}" readonly>
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
                        {{--<button type="submit" class="btn btn-primary add-to-cart js-add-button">
                            Update search
                        </button>--}}
                    </aside>
                </div>
                <div class="col-sm-9">
                    <div class="products-header">
                        <div class="row">
                            <div class="col-xs-6 col-sm-4">

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
                                        <select class="form-control js-change" name="sort">
                                            @foreach(StaticVars::filterSortingType() as $isSelected => $option)
                                                <option value="{{ $option }}" {!! $filters->get('sort') == $option ? 'selected="selected"' : '' !!}>{{ trans('filters.sorting.'.$option) }}</option>
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
                                                <div class="product-mask">
                                                    {!! Form::img($product->front_image_hover->filename, StaticVars::productRelated(), $product->front_image_hover->alt, StaticVars::imgWrapper()) !!}
                                                </div>
                                                <a href="{{ route('shop.product', ['slug' => $product->slug]) }}"
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
                                                <h3>{{ str_limit($product->name, 29) }}</h3>
                                                @include('partials.labels')
                                                @if(isset($product->rating))
                                                    <div class="product-rating">
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star-o"></i>
                                                        <i class="fa fa-star-o"></i>
                                                    </div>
                                                @endif
                                                @include('partials.price')
                                                <p>{{ $product->description }}</p>
                                                <div class="buttons">
                                                    {{--<a href="" class="btn btn-primary btn-sm"><i class="fa fa-exchange"></i></a>--}}
                                                    @if($product->stock == 0)
                                                        <a href="{{ route('shop.product', ['slug' => $product->slug]) }}"
                                                           class="btn btn-transparent btn-sm add-to-cart">
                                                            <i class="fa fa-plus"></i>Read more
                                                        </a>
                                                    @elseif($product->variations->count() > 1)
                                                        <a href="{{ route('shop.product', ['slug' => $product->slug]) }}"
                                                           class="btn btn-transparent btn-sm add-to-cart">
                                                            <i class="fa fa-plus"></i>Choose options
                                                        </a>
                                                    @else
                                                        <button class="btn btn-transparent btn-sm js-shop-add-button"
                                                                data-quantity="1"
                                                                data-product_id="{{ $product->_id }}"
                                                                data-product_name="{{ $product->name }}"
                                                                data-action="{{ route('cart.store') }}"
                                                                data-token="{{ csrf_token() }}">
                                                            <i class="fa fa-shopping-cart"></i>&nbsp;Add
                                                        </button>
                                                        <button class="btn btn-transparent btn-sm js-shop-add-button"
                                                                data-quantity="1"
                                                                data-product_id="{{ $product->_id }}"
                                                                data-product_name="{{ $product->name }}"
                                                                data-action="{{ route('cart.store') }}"
                                                                data-token="{{ csrf_token() }}">
                                                            <i class=""></i>&nbsp;Add & Buy
                                                        </button>
                                                    @endif
                                                    {{--<button type="submit" class="btn btn-primary add-to-cart js-add-button">--}}
                                                    {{--<i class="fa fa-shopping-cart"></i>--}}
                                                    {{--Add to cart--}}
                                                    {{--</button>--}}
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
                    {{--@if($filters->get('show') != 'all' && $products->count() >= $products->perPage())
                        <div class="pagination-wrapper">
                            {{ $products->appends($filters->all())->links() }}
                        </div>
                    @endif--}}

                </div>
            </div>

        </form>
    </div>
</section>
<!-- ==========================
    PRODUCTS - END
=========================== -->

@endsection