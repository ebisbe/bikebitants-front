<!DOCTYPE html>
<html>
<head>
    <!-- ==========================
        Meta Tags
    =========================== -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://opensource.keycdn.com/fontawesome/4.7.0/font-awesome.min.css" integrity="sha384-dNpIIXE8U05kAbPhy3G1cz+yZmTzA6CY8Vg/u2L9xRnHjJiAK76m2BIEaSEV+/aU" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ assetCDN(mix('css/app.css')) }}">

    <!-- manifest -->
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#00cc00">

    <title>{{ MetaTag::get('title') }}</title>

    {!! MetaTag::tag('description') !!}
    {!! MetaTag::tag('image') !!}
    {!! MetaTag::tag('slug') !!}

    {!! MetaTag::openGraph() !!}

    {!! MetaTag::twitterCard() !!}

    {!! MetaTag::tag('image', assetCDN(StaticVars::logo())) !!}

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
<script src="{{ assetCDN(mix('js/app.js')) }}" async></script>
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