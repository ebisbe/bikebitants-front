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
    {!! MetaTag::tag('keywords') !!}

    {!! MetaTag::openGraph() !!}

    {!! MetaTag::twitterCard() !!}

    {{--Set default share picture after custom section pictures--}}
    {!! MetaTag::tag('image', assetCDN('logo.png')) !!}

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
    <div class="top-header hidden-xs {{ StaticVars::layoutTopHeader(!empty($layoutTopHeader) ? $layoutTopHeader : '') }}">
        <div class="container">
            <div class="row">
                <div class="col-sm-5">
                    <ul class="list-inline contacts">
                        <li><i class="fa fa-envelope"></i> {{ StaticVars::email() }}</li>
                        <li><i class="fa fa-phone"></i> {{ StaticVars::telephone() }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <header class="navbar {{ StaticVars::layoutHeader(!empty($layoutHeader) ? $layoutHeader : '') }}">
        <div class="container">
            <div class="navbar-header">
                <a href="{{ route('shop.home') }}" class="navbar-brand">
                    <img src="{{ assetCDN('logo.png')  }}" height="36">
                </a>
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"><i
                            class="fa fa-bars"></i></button>
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
            <div class="footer-bottom">
                <div class="row">
                    <div class="col-sm-6">
                        <p class="copyright">© Umarket 2015 All right reserved.</p>
                        <p class="copyright">Designed by <a href="http://www.pixelized.cz/" target="_blank">Pixelized
                                Studio.</a></p>
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
</div> <!-- PAGE - END -->

<!-- ==========================
 JS
=========================== -->
@include('partials.js_vars')
<script src="{{ elixir('js/app.js') }}"></script>
@stack('footer.scripts')
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
<![endif]-->
</body>
</html>