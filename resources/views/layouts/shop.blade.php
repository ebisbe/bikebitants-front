<!DOCTYPE html>
<html>
<head>
    <!-- ==========================
    	Meta Tags
    =========================== -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">


    <link rel="stylesheet" async href="{{ elixir('css/all.css') }}">

    <title>{{ MetaTag::get('title') }}</title>

    {!! MetaTag::tag('description') !!}
    {!! MetaTag::tag('image') !!}
    {!! MetaTag::tag('keywords') !!}

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
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"><i class="fa fa-bars"></i></button>
            </div>
            <div class="navbar-collapse collapse">
                <p class="navbar-text hidden-xs hidden-sm">{{ StaticVars::slogan() }}</p>
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="{{ route('shop.home') }}">Home</a>
                    </li>
                    <li class="dropdown">
                        <a href="{{ route('shop.catalogue') }}">Shop</a>
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

                    @include('partials.menu_cart')
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
    	ADD REVIEW - START
    =========================== -->
    <div class="modal fade modal-add-review" id="add-review" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></button>
                    <h4 class="modal-title">Add a review</h4>
                </div>
                <div class="modal-body">
                    <form class="comment-form">
                        <p class="comment-notes"><span id="email-notes">Your email address will not be published.</span> Required fields are marked<span class="required">*</span></p>
                        <div class="row">
                            <div class="form-group comment-form-author col-sm-6">
                                <label for="author">Name<span class="required">*</span></label>
                                <input class="form-control" id="author" name="author" type="text" required value="" placeholder="Enter your name">
                            </div>
                            <div class="form-group comment-form-email col-sm-6">
                                <label for="email">Email<span class="required">*</span></label>
                                <input class="form-control" id="email" name="email" type="email" required value="" placeholder="Enter your email">
                            </div>
                        </div>
                        <div class="form-group comment-form-comment">
                            <label for="comment">Comment<span class="required">*</span></label>
                            <textarea class="form-control" id="comment" name="comment" required placeholder="Enter your message"></textarea>
                        </div>
                        <button class="btn btn-primary" type="submit"><i class="fa fa-check"></i>Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- ==========================
    	ADD REVIEW - END
    =========================== -->

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
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
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
                    <div class="footer-widget footer-widget-contacts">
                        <h4>Contacts</h4>
                        <ul class="list-unstyled">
                            <li><i class="fa fa-envelope"></i> {{ StaticVars::email() }}</li>
                            <li><i class="fa fa-phone"></i> {{ StaticVars::telephone() }}</li>
                            {{--<li><i class="fa fa-map-marker"></i> 40°44'00.9"N 73°59'43.4"W</li>--}}
                            <li class="social">
                                <a target="_blank" href="{{ StaticVars::facebook() }}"><i class="fa fa-facebook"></i></a>
                                <a target="_blank" href="{{ StaticVars::twitter() }}"><i class="fa fa-twitter"></i></a>
                                <a target="_blank" href="{{ StaticVars::instagram() }}"><i class="fa fa-instagram"></i></a>
                                <a target="_blank" href="{{ StaticVars::linkedin() }}"><i class="fa fa-linkedin"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-3 col-xs-6">
                    <div class="footer-widget footer-widget-links">
                        <h4>Information</h4>
                        <ul class="list-unstyled">
                            <li><a href="about-shop.html">About Shop</a></li>
                            <li><a href="stores.html">Our Stores</a></li>
                            <li><a href="terms-conditions.html">Terms & Conditions</a></li>
                            <li><a href="privacy-policy.html">Privacy Policy</a></li>
                            <li><a href="faq.html">FAQ</a></li>
                            <li><a href="my-account.html">My account</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-3 col-xs-6">
                    <div class="footer-widget footer-widget-twitter">
                        <h4>Recent tweets</h4>
                        <div id="twitter-wrapper"></div>
                    </div>
                </div>
                <div class="col-sm-3 col-xs-6">
                    <div class="footer-widget footer-widget-facebook">
                        <h4>Facebook Page</h4>
                        <ul class="list-unstyled row row-no-padding">
                            <li class="col-xs-3"><a href="#"><img src="/images/avatar/avatar_01.jpg" class="img-responsive" alt=""></a></li>
                            <li class="col-xs-3"><a href="#"><img src="/images/avatar/avatar_02.jpg" class="img-responsive" alt=""></a></li>
                            <li class="col-xs-3"><a href="#"><img src="/images/avatar/avatar_03.jpg" class="img-responsive" alt=""></a></li>
                            <li class="col-xs-3"><a href="#"><img src="/images/avatar/avatar_04.jpg" class="img-responsive" alt=""></a></li>
                            <li class="col-xs-3"><a href="#"><img src="/images/avatar/avatar_01.jpg" class="img-responsive" alt=""></a></li>
                            <li class="col-xs-3"><a href="#"><img src="/images/avatar/avatar_02.jpg" class="img-responsive" alt=""></a></li>
                            <li class="col-xs-3"><a href="#"><img src="/images/avatar/avatar_03.jpg" class="img-responsive" alt=""></a></li>
                            <li class="col-xs-3"><a href="#"><img src="/images/avatar/avatar_04.jpg" class="img-responsive" alt=""></a></li>
                        </ul>
                        <p>45,500 Likes  <a href="#" class="btn btn-default btn-sm"><i class="fa fa-thumbs-up"></i>Like</a></p>
                    </div>
                </div>
            </div>
            <div class="footer-bottom footer-line">
                <div class="row">
                    <div class="col-sm-6">
                        <p class="copyright">© Umarket 2015 All right reserved.</p>
                        <p class="copyright">Designed by <a href="http://www.pixelized.cz/" target="_blank">Pixelized Studio.</a></p>
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

    <!-- ==========================
    	MODAL ADVERTISING  - START
    =========================== -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modalAdvertising">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-8">
                            <h3>Dicount 10%</h3>
                            <p>Enter your email address and get 10% discount for your first purchase.</p>
                            <form method="POST" action="/lead/" id="js-popup">
                                <div class="input-group">
                                    {{ csrf_field() }}
                                    <input type="email" name="email" class="form-control" placeholder="Email Address">
                                    <input type="hidden" name="type" value="popup">
                                    <span class="input-group-btn">
                                        <button class="btn btn-primary js-popup-send" type="submit"><i></i>Submit</button>
                                    </span>
                                </div>
                                <span class="js-popup-message"></span>
                            </form>
                            <div class="checkbox">
                                <input id="modal-hide" type="checkbox" value="hidden">
                                <label for="modal-hide">Don't show this popup again</label>
                            </div>
                        </div>
                        <div class="col-sm-4 hidden-xs">
                            <img src="/images/lookbook-1.png" class="img-responsive" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ==========================
        MODAL ADVERTISING - END
    =========================== -->
    @include('partials.product_popup')
    @include('cookieConsent::index')
</div> <!-- PAGE - END -->

<!-- ==========================
 JS
=========================== -->
<script src="{{ elixir('js/all.js') }}"></script>
@stack('footer.scripts')
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
<![endif]-->

@include('partials.flash_message')
</body>
</html>