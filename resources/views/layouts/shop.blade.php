@extends('layouts.skel')

@section('skel_content')

    @push('header')
    @include('layouts.partials.microdata')
    @endpush
    <!-- ==========================
        HEADER - START
    =========================== -->
    <div class="top-header hidden-xs">
        <div class="container">
            <div class="row">
                <div class="col-sm-9">
                    <ul class="list-inline contacts">
                        <li><i class="fa fa-envelope"></i> <a
                                    href="mailto:{{ StaticVars::email() }}">{{ StaticVars::email() }}</a></li>
                        <li><i class="fa fa-phone"></i> <a
                                    href="tel:{{ StaticVars::telephone() }}">{{ StaticVars::telephone() }}</a> @lang('layout.telephone_schedule')
                        </li>
                    </ul>
                </div>
                <div class="col-sm-3 text-right">
                    <ul class="list-inline links">
                        <li><a href="{{ config('app.blog_url') }}/contacto">@lang('layout.contact')</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <header class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">
                <a href="{{ route('shop.home') }}" class="navbar-brand">
                    <img height="36" alt="Bikebitants Logo" src='{{ StaticVars::logo() }}'/>
                </a>
                <button type="button" class="navbar-toggle pull-right" data-toggle="collapse"
                        data-target=".navbar-collapse">
                    <i class="fa fa-bars"></i>
                </button>
                <a href="{{ route('cart.index') }}" class="navbar-toggle pull-right">
                    <i class="fa fa-shopping-cart"></i>
                </a>
            </div>
            <div class="navbar-collapse collapse">
                <p class="navbar-text hidden-xs hidden-sm">{{ StaticVars::slogan() }}</p>
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="{{ route('shop.catalogue') }}">@lang('layout.shop')</a>
                    </li>
                    <li>
                        <a href="{{ route('shop.bargain') }}">@lang('bargain.title')</a>
                    </li>
                    <li>
                        <a href="{{ route('faq') }}">@lang('static.faq')</a>
                    </li>
                    <li class="visible-xs">
                        <a href="{{ config('app.blog_url') }}/contacto">@lang('layout.contact')</a>
                    </li>
                    <li class="visible-xs">
                        <a href="mailto:{{ StaticVars::email() }}">
                            <i class="fa fa-envelope"></i> {{ StaticVars::email() }}
                        </a>
                    </li>
                    <li class="visible-xs">
                        <a href="tel:{{ StaticVars::telephone() }}">
                            <i class="fa fa-phone"></i> {{ StaticVars::telephone() }}
                        </a>
                    </li>
                    <cart-menu
                            cart="{{ route('cart.index') }}"
                            checkout="{{ route('checkout.index') }}"
                            shop="{{ route('shop.catalogue') }}">
                    </cart-menu>
                </ul>
            </div>
        </div>
    </header>
    <!-- ==========================
        HEADER - END
    =========================== -->

    @yield('content')

    @if($view_name != 'shop_home')
    <!-- ==========================
        SERVICES - START
    =========================== -->
    <section class="content services services-3x transparent">
        <div class="container">
            <div class="row row-no-padding">

                @include('layouts.partials.warranty')

            </div>

        </div>
    </section>
    <!-- ==========================
        SERVICES - END
    =========================== -->
    @endif

    @include('layouts.partials.media')

    <!-- ==========================
            FOOTER - START
        =========================== -->
    <footer class="navbar navbar-default">
        <div class="container">
            <div class="row">
                <div class="col-sm-3 col-xs-6">
                    <div class="footer-widget footer-widget-links">
                        <h4>@lang('layout.enterprise')</h4>
                        <ul class="list-unstyled">
                            <li><a href="{{ route('who_we_are') }}">@lang('layout.whoweare')</a></li>
                            <li><a href="{{ route('social_commitment') }}">@lang('layout.commitment')</a></li>
                            <li><a href="{{ route('incentives') }}">@lang('layout.incentives')</a></li>
                            <li><a href="{{ route('press') }}">@lang('layout.press')</a></li>
                            <li><a href="">@lang('layout.contact')</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-3 col-xs-6">
                    <div class="footer-widget footer-widget-links">
                        <h4>@lang('layout.buyonus')</h4>
                        <ul class="list-unstyled">
                            <li><a href="{{ route('terms_conditions') }}">@lang('layout.general_conditions')</a></li>
                            <li><a href="{{ route('terms_conditions') }}#faq-2-q-2">@lang('layout.returns')</a></li>
                            <li><a href="{{ route('terms_conditions') }}#faq-3-q-1">@lang('layout.delivery')</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-3 col-xs-6">
                    <div class="footer-widget footer-widget-contacts">
                        <h4>@lang('layout.contacts')</h4>
                        <ul class="list-unstyled">
                            <li><i class="fa fa-envelope"></i> {{ StaticVars::email() }}</li>
                            <li><i class="fa fa-phone"></i> {{ StaticVars::telephone() }}</li>
                            {{--<li><i class="fa fa-map-marker"></i> 40°44'00.9"N 73°59'43.4"W</li>--}}
                            <li class="social">
                                <a target="_blank" rel="noopener" href="{{ StaticVars::facebook() }}">
                                    <i class="fa fa-facebook"></i>
                                </a>
                                <a target="_blank" rel="noopener" href="{{ StaticVars::twitter() }}">
                                    <i class="fa fa-twitter"></i>
                                </a>
                                <a target="_blank" rel="noopener" href="{{ StaticVars::instagram() }}">
                                    <i class="fa fa-instagram"></i>
                                </a>
                                <a target="_blank" rel="noopener" href="{{ StaticVars::linkedin() }}">
                                    <i class="fa fa-linkedin"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                @include('partials.twitter')
            </div>
            <div class="footer-bottom footer-line">
                @include('layouts.partials.footer')
            </div>
        </div>
    </footer>
    <!-- ==========================
        FOOTER - END
    =========================== -->
@endsection