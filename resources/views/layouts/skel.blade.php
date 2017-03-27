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

    <!-- manifest -->
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#00cc00">

    <title>{{ MetaTag::get('title') }}</title>

    {!! MetaTag::tag('description') !!}
    {!! MetaTag::tag('image') !!}
    {!! MetaTag::tag('slug') !!}

    {!! MetaTag::openGraph() !!}

    {!! MetaTag::twitterCard() !!}

    {!! MetaTag::tag('image', StaticVars::logo()) !!}

    @include('layouts.partials.gtm')

    @stack('header')
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

    @yield('skel_content')

</div> <!-- PAGE - END -->
<!-- ==========================
 JS
=========================== -->
@include('layouts.partials.js_vars')
<script src="{{ mix('js/app.js') }}" async></script>
@stack('footer.scripts')
<script type="application/javascript">
    ga('send', 'pageview');
</script>
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
<![endif]-->

</body>
</html>