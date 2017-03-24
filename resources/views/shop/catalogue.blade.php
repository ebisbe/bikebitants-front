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
                                            @foreach($categories as $cat)
                                                <li class="panel">
                                                    <a href="{{ route('shop.slug', ['slug' => $cat->slug]) }}"
                                                       class="{{ $selectedCat == $cat->_id ? '' : 'collapsed' }}">{{ $cat->name }}
                                                        <span>[{{ $cat->products_count }}]</span>
                                                    </a>
                                                    <ul class="list-unstyled">
                                                        @foreach($cat->children as $subcategory)
                                                            <li class="{{ isset($selectedSubCat) && $selectedSubCat == $subcategory->_id ? 'active' : '' }}">
                                                                <a href="{{ route('shop.subslug', ['slug' => $cat->slug, 'subslug' => $subcategory->slug]) }}">{{ $subcategory->name }}</a>
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
                                <div class="collapse in" id="widget-price-collapse" aria-expanded="true"
                                     role="tabpanel">
                                    <div class="widget-body">
                                        <div class="price-slider">
                                            <input type="hidden" class="min" name="min_price"
                                                   data-min="{{ $productsResult->minPrice() }}"
                                                   data-value="{{ $productsResult->filters('min_price') }}" readonly>
                                            <input type="hidden" class="max" name="max_price"
                                                   data-max="{{ $productsResult->maxPrice() }}"
                                                   data-value="{{ $productsResult->filters('max_price') }}" readonly>
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
                                <div class="col-xs-2 col-sm-2">

                                </div>

                                <div class="col-xs-10 col-sm-10">
                                    <div class="btn-group toggle-list-grid hidden-xs" role="group">
                                        <button type="button" class="btn btn-default active" id="toggle-grid">
                                            <i class="fa fa-th"></i>
                                        </button>
                                        <button type="button" class="btn btn-default" id="toggle-list">
                                            <i class="fa fa-list"></i>
                                        </button>
                                    </div>
                                    <div class="form-inline order-by">
                                        <div class="form-group hidden-sm hidden-xs">
                                            <label>@lang('catalogue.sort_by')</label>
                                        </div>
                                        <div class="form-group">
                                            <select class="form-control js-change" name="sort">
                                                @foreach($productsResult->sortingTypes() as $isSelected => $option)
                                                    <option value="{{ $option }}" {!! $productsResult->filters('sort') == $option ? 'selected="selected"' : '' !!}>{{ trans('filters.sorting.'.$option) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="row grid" id="products">

                            <!-- PRODUCT - START -->
                        @foreach($productsResult->products() as $product)
                            @include('partials.catalogue_product', ['product' => $product, 'iteration' => $loop->iteration])
                            @include('scripts.addImpression', ['product' => $product, 'iteration' => $loop->iteration])

                        @endforeach
                        <!-- PRODUCT - END -->

                        </div>

                        {{--@if($filters->get('show') != 'all' && $products->count() >= $products->perPage())
                            <div class="pagination-wrapper">
                                {{ $products->appends($filters->all())->links() }}
                            </div>
                        @endif--}}

                        @if(isset($category) && !empty($category->description))
                            <h3>@lang('catalogue.title', ['name' => $category->name])</h3>
                            {!! $category->description !!}
                        @endif
                    </div>
                </div>

            </form>
        </div>
    </section>
    <!-- ==========================
        PRODUCTS - END
    =========================== -->

@endsection