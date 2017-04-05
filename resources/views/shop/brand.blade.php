@extends('layouts.shop')

@section('content')

    <!-- ==========================
    	LOOKBOOK - START
    =========================== -->
    <section class="content lookbook">
        <div class="container">
            <div class="row">
                <div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
                    {!! Form::img($brand->filename, StaticVars::brandMain(), $brand->filename, '{img}', 'img-responsive center-block') !!}
                </div>
            </div>
            <h2>{{ ucfirst($brand->name) }}</h2>
            <p>{{ $brand->description }}</p>
        </div>
    </section>
    <!-- ==========================
        LOOKBOOK - END
    =========================== -->

    <!-- ==========================
        LOOKBOOK SERVICES - START
    =========================== -->
    @foreach($brand->services as $service)
        <section class="content lookbook-services image-{{ $service->position }} border-bottom border-top">
            <div class="container">
                <div class="row">
                    @if($service->position == 'left')
                        <div class="col-xs-6">
                            <img src="/images/lookbook-1.png" class="img-responsive center-block" alt="">
                        </div>
                    @endif
                    <div class="col-xs-6">
                        <h3>{{ $service->title }}</h3>
                        <p>{{ $service->description }}</p>
                    </div>
                    @if($service->position == 'right')
                        <div class="col-xs-6">
                            <img src="/images/lookbook-1.png" class="img-responsive center-block" alt="">
                        </div>
                    @endif

                </div>
            </div>
        </section>
    @endforeach
    <!-- ==========================
    LOOKBOOK SERVICES - END
=========================== -->


    <section class="content products">
        <div class="container">
            <h2 class="hidden">Products</h2>
            <div class="row">
                <div class="col-sm-12">
                    <h3>{{ trans('layout.brand_related_products') }}</h3>
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
@endsection
