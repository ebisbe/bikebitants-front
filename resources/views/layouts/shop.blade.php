<!DOCTYPE html>
<html>
<head>
    <!-- ==========================
    	Meta Tags
    =========================== -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">


    <link rel="stylesheet" async href="{{ elixir('css/all.css') }}">

    <title>{{ MetaTag::get('title') }}</title>

    {!! MetaTag::tag('description') !!}
    {!! MetaTag::tag('image') !!}
    {!! MetaTag::tag('slug') !!}

    {!! MetaTag::openGraph() !!}

    {!! MetaTag::twitterCard() !!}

    {{--Set default share picture after custom section pictures--}}
    {!! MetaTag::tag('image', asset('images/default-logo.png')) !!}
</head>
<body>

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
    <div class="top-header hidden-xs {{ StaticVars::layoutTopHeader(!empty($layoutTopHeader) ? $layoutTopHeader : '') }}">
        <div class="container">
            <div class="row">
                <div class="col-sm-5">
                    <ul class="list-inline contacts">
                        <li><i class="fa fa-envelope"></i> {{ StaticVars::email() }}</li>
                        <li><i class="fa fa-phone"></i> {{ StaticVars::telephone() }}</li>
                    </ul>
                </div>
                {{--<div class="col-sm-7 text-right">
                    <ul class="list-inline links">
                        <li><a href="my-account.html">My account</a></li>
                        <li><a href="checkout.html">Checkout</a></li>
                        <li><a href="wishlist.html">Wishlist (5)</a></li>
                        <li><a href="compare.html">Compare (3)</a></li>
                        <li><a href="signin.html">Logout</a></li>
                    </ul>--}}
                {{--<ul class="list-inline languages hidden-sm">
                    <li><a href="#"><img src="/images/flags/es.png" alt="cs_CZ"></a></li>
                    <li><a href="#"><img src="/images/flags/us.png" alt="en_US"></a></li>
                    <li><a href="#"><img src="/images/flags/de.png" alt="de_DE"></a></li>
                </ul>
            </div>--}}
            </div>
        </div>
    </div>
    <header class="navbar {{ StaticVars::layoutHeader(!empty($layoutHeader) ? $layoutHeader : '') }}">
        <div class="container">
            <div class="navbar-header">
                <a href="{{ route('shop.home') }}" class="navbar-brand"><span>Bike</span>Bitants</a>
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"><i
                            class="fa fa-bars"></i></button>
            </div>
            <div class="navbar-collapse collapse">
                <p class="navbar-text hidden-xs hidden-sm">{{ StaticVars::slogan() }}</p>
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="{{ route('shop.home') }}">@lang('layout.home')</a>
                    </li>
                    <li class="dropdown">
                        <a href="{{ route('shop.catalogue') }}">@lang('layout.shop')</a>
                    </li>
                    {{--<li class="dropdown megamenu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="300" data-close-others="true">Eshop</a>
                        <ul class="dropdown-menu">
                            <li class="col-sm-4 col-md-3">
                                <ul class="list-unstyled">
                                    <li class="title">Men <span class="label label-danger pull-right">HOT</span></li>
                                    <li><a href="products.html">Sweatshirts & Jackets</a></li>
                                    <li><a href="products.html">Caps and Hats</a></li>
                                    <li><a href="products.html">Ties</a></li>
                                    <li><a href="products.html">Scarves</a></li>
                                    <li><a href="products.html">Shirts</a></li>
                                    <li><a href="products.html">Jeans</a></li>
                                </ul>
                            </li>
                            <li class="col-sm-4 col-md-3">
                                <ul class="list-unstyled">
                                    <li class="title">Women <span class="label label-info pull-right">30% OFF SALE</span></li>
                                    <li><a href="products.html">Jackets & Coats</a></li>
                                    <li><a href="products.html">Jumpers & cardigans</a></li>
                                    <li><a href="products.html">Jeans</a></li>
                                    <li><a href="products.html">Trousers</a></li>
                                    <li><a href="products.html">Dresses</a></li>
                                    <li><a href="products.html">Long Sleeve Tops</a></li>
                                </ul>
                            </li>
                            <li class="col-sm-4 col-md-3">
                                <ul class="list-unstyled">
                                    <li class="title">Accessories</li>
                                    <li><a href="products.html">Sunglasses</a></li>
                                    <li><a href="products.html">Watches</a></li>
                                    <li><a href="products.html">Umbrellas</a></li>
                                    <li><a href="products.html">Bags & Wallets</a></li>
                                    <li><a href="products.html">Fashion Jewellery</a></li>
                                    <li><a href="products.html">Belts</a></li>
                                </ul>
                            </li>
                            <li class="hidden-xs hidden-sm col-md-3">
                                <img src="/images/megamenu.png" class="img-responsive center-block" alt="">
                            </li>
                        </ul>
                    </li>--}}

                    <menu-cart
                            cart="{{ route('cart.index') }}"
                            checkout="{{ route('checkout.index') }}"
                            shop="{{ route('shop.catalogue') }}">
                    </menu-cart>
                    {{--<li class="dropdown navbar-search hidden-xs">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-search"></i></a>
                        <ul class="dropdown-menu">
                            <li>
                                <form>
                                    <div class="input-group input-group-lg">
                                        <input type="text" class="form-control" placeholder="Search ...">
                                        <span class="input-group-btn">
                                            <button class="btn btn-primary" type="button">Search</button>
                                        </span>
                                    </div>
                                </form>
                            </li>
                        </ul>
                    </li>--}}
                </ul>
            </div>
        </div>
    </header>
    <!-- ==========================
    	HEADER - END
    =========================== -->

    @yield('content')

            <!-- ==========================
    	NEWSLETTER - START
    =========================== -->
    <section class="separator separator-newsletter">
        <div class="container">
            <div class="newsletter-left">
                <div class="newsletter-badge">
                    <span>Subsribe & Get </span>
                    <span class="price">$15</span>
                    <span>discount</span>
                </div>
            </div>
            <div class="newsletter-right">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="newsletter-body">
                            <h3>Newsletter</h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                incididunt ut labore et dolore magna aliqua.</p>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <form>
                            <div class="input-group input-group-lg">
                                <input type="email" class="form-control" placeholder="Enter email address">
                                <span class="input-group-btn">
                                    <button class="btn btn-primary" type="button">Sign Up</button>
                                </span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ==========================
    	NEWSLETTER - END
    =========================== -->

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
                        <p class="copyright">Bikebitants SL All right reserved.</p>
                        <p class="copyright">
                            Designed by <a href="http://www.pixelized.cz/" target="_blank">Pixelized Studio.</a>
                        </p>
                    </div>
                    <div class="col-sm-6">
                        <ul class="list-inline payment-methods">
                            <li><i class="fa fa-cc-amex"></i></li>
                            <li><i class="fa fa-cc-diners-club"></i></li>
                            <li><i class="fa fa-cc-discover"></i></li>
                            <li><i class="fa fa-cc-jcb"></i></li>
                            <li><i class="fa fa-cc-mastercard"></i></li>
                            <li><i class="fa fa-cc-paypal"></i></li>
                            <li><i class="fa fa-cc-stripe"></i></li>
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

    @include('partials.discount_popup')
    @include('partials.product_popup')
    {{--@include('cookieConsent::index')--}}
</div> <!-- PAGE - END -->
<script>
    window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
            'language' => config('app.locale')
    ]) !!}
</script>
<!-- ==========================
 JS
=========================== -->
<script src="{{ elixir('js/app.js') }}"></script>
@stack('footer.scripts')
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
<![endif]-->

@include('partials.flash_message')
</body>
</html>