@extends('layouts.shop')

@section('content')
    @include('partials.breadcrumb')

    <!-- ==========================
PRODUCTS - START
=========================== -->
    <section class="content products">
        <div class="container">
            <h2 class="hidden">Products</h2>
            <div class="row">
                <div class="col-sm-12">
                    <h3>{{ trans('bargain.description') }}</h3>
                    <div class="row grid" id="products">

                        <!-- PRODUCT - START -->
                    @foreach($products as $product)
                        @include('scripts.addImpression', ['product' => $product, 'iteration' => $loop->iteration])
                        @include('partials.catalogue_product', ['product' => $product, 'iteration' => $loop->iteration])
                    @endforeach
                    <!-- PRODUCT - END -->

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ==========================
        PRODUCTS - END
    =========================== -->
@endsection