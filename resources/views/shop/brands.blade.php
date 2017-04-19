@extends('layouts.shop')

@section('content')
    @include('partials.breadcrumb')

    <section class="content">
        <div class="container">

            <article class="components-content components brands">

                <ul class="list-unstyled">
                    @foreach($brands as $brand)
                        <li class="default-style">
                            <span><a href="{{ route('shop.brand', ['slug' => $brand->slug]) }}">{{ $brand->name }}</a></span>
                        </li>
                    @endforeach
                </ul>

            </article>

        </div>
    </section>
@endsection