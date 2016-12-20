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
                                   aria-expanded="true"
                                   aria-controls="widget-categories-collapse">@lang('catalogue.categories')</a></h3>
                            <div class="collapse in" id="widget-categories-collapse" aria-expanded="true"
                                 role="tabpanel">
                                <div class="widget-body">
                                    <ul class="list-unstyled" id="categories" role="tablist"
                                        aria-multiselectable="true">
                                        @foreach($categories as $category)
                                            <li class="panel">
                                                <a class="{{ $category->_id == $selectedCat ? '' : 'collapsed' }}"
                                                   {{--role="button"
                                                   data-toggle="collapse"
                                                   data-parent="#categories"
                                                   href="#parent-{{ $loop->iteration }}"
                                                   aria-expanded="true"
                                                   aria-controls="parent-{{ $loop->iteration }}"--}}
                                                   href="{{ route('shop.category', ['category' => $category->slug]) }}">{{ $category->name }}
                                                    <span>[{{ $category->products_count }}]</span>
                                                </a>
                                                <ul id="parent-{{ $loop->iteration }}"
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
                                   aria-controls="widget-price-collapse">@lang('catalogue.price_filter')</a>
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
                                    <div class="form-group hidden-sm">
                                        <label>@lang('catalogue.sort_by')</label>
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
                        @include('partials.catalogue_product', compact('product'))
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