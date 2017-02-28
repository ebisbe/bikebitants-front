<!DOCTYPE html>
<html>
<head>
    <!-- ==========================
        Meta Tags
    =========================== -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">

    <link rel="stylesheet" href="{{ mix('css/vendor.css') }}">
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

    <title>{{ MetaTag::get('title') }}</title>

    {!! MetaTag::tag('description') !!}
    {!! MetaTag::tag('image') !!}
    {!! MetaTag::tag('slug') !!}

    {!! MetaTag::openGraph() !!}

    {!! MetaTag::twitterCard() !!}

    {{--Set default share picture after custom section pictures--}}
    {!! MetaTag::tag('image', StaticVars::logo()) !!}

    @include('scripts.microdata')

    @include('scripts.gtm')
</head>
<body>
@include('googletagmanager::script')
<!-- ==========================
    SCROLL TOP - START
=========================== -->
<div id="scrolltop" class="hidden-xs"><i class="fa fa-angle-up"></i></div>
<!-- ==========================
    SCROLL TOP - END
=========================== -->

<div id="page-wrapper"> <!-- PAGE - START -->

    <!-- ==========================
        HEADER - START
    =========================== -->
    <div class="top-header hidden-xs">
        <div class="container">
            <div class="row">
                <div class="clo-sm-9">
                    <ul class="list-inline contacts">
                        <li><i class="fa fa-envelope"></i> <a href="mailto:{{ StaticVars::email() }}">{{ StaticVars::email() }}</a></li>
                        <li><i class="fa fa-phone"></i> <a href="tel:{{ StaticVars::telephone() }}">{{ StaticVars::telephone() }}</a> @lang('layout.telephone_schedule')</li>
                    </ul>
                </div>
                <div class="col-sm-3 text-right">
                    <ul class="list-inline links">
                        <li><a href="{{ config('APP_BLOG_URL') }}/contacto">@lang('layout.contact')</a></li>
                        {{--<li><a href="my-account.html">My account</a></li>
                        <li><a href="checkout.html">Checkout</a></li>
                        <li><a href="wishlist.html">Wishlist (5)</a></li>
                        <li><a href="compare.html">Compare (3)</a></li>
                        <li><a href="signin.html">Logout</a></li>--}}
                    </ul>
                {{--<ul class="list-inline languages hidden-sm">
                    <li><a href="#"><img src="/images/flags/es.png" alt="cs_CZ"></a></li>
                    <li><a href="#"><img src="/images/flags/us.png" alt="en_US"></a></li>
                    <li><a href="#"><img src="/images/flags/de.png" alt="de_DE"></a></li>
                </ul>--}}
            </div>
            </div>
        </div>
    </div>
    <header class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">
                <a href="{{ route('shop.home') }}" class="navbar-brand">
                    <img height="36" alt="Bikebitants Logo" src='{{ StaticVars::logo() }}' />
                </a>
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"><i
                            class="fa fa-bars"></i></button>
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
                                <a target="_blank" href="{{ StaticVars::facebook() }}">
                                    <i class="fa fa-facebook"></i>
                                </a>
                                <a target="_blank" href="{{ StaticVars::twitter() }}">
                                    <i class="fa fa-twitter"></i>
                                </a>
                                <a target="_blank" href="{{ StaticVars::instagram() }}">
                                    <i class="fa fa-instagram"></i>
                                </a>
                                <a target="_blank" href="{{ StaticVars::linkedin() }}">
                                    <i class="fa fa-linkedin"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                @include('partials.twitter')
            </div>
            <div class="footer-bottom footer-line">
                <div class="row">
                    <div class="col-sm-6">
                        <p class="copyright">&copy; Bikebitants SL 2015</p>
                    </div>
                    <div class="col-sm-6">
                        <ul class="list-inline payment-methods">
                            {{--<li><i class="fa fa-cc-amex"></i></li>--}}
                            {{--<li><i class="fa fa-cc-diners-club"></i></li>--}}
                            {{--<li><i class="fa fa-cc-discover"></i></li>
                            <li><i class="fa fa-cc-jcb"></i></li>--}}
                            <li><i class="fa fa-cc-mastercard"></i></li>
                            <li><i class="fa fa-cc-paypal"></i></li>
                            {{--<li><i class="fa fa-cc-stripe"></i></li>--}}
                            <li><i class="fa fa-cc-visa"></i></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- ==========================
        FOOTER - END
    =========================== -->

    {{--@include('partials.product_popup')--}}
    <script type="application/javascript">
        ga('send', 'pageview');
    </script>
</div> <!-- PAGE - END -->
<!-- ==========================
 JS
=========================== -->
@include('partials.js_vars')
<script src="{{ mix('js/app.js') }}" async></script>
@stack('footer.scripts')
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
<![endif]-->

</body>
</html>