@extends('layouts.skel')

@section('skel_content')
    <!-- ==========================
        HEADER - START
    =========================== -->
    <div class="top-header hidden-xs">
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
    <header class="navbar navbar-default navbar-static-top">
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

    @if(stripos($view_name, 'checkout') === false)
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

    @include('layouts.partials.media')

    @endif
    <!-- ==========================
        FOOTER - START
    =========================== -->
    <footer class="navbar navbar-default">
        <div class="container">
            <div class="footer-bottom">
                @include('layouts.partials.footer')
            </div>
        </div>
    </footer>
    <!-- ==========================
        FOOTER - END
    =========================== -->
@endsection