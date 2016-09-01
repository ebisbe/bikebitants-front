<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ env('APP_ENV_STRING') }} Bikebitants</title>

    <!-- Global stylesheets -->
    {!! Html::style('https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900') !!}
    {!! Html::style('/assets/css/icons/icomoon/styles.css') !!}
    {!! Html::style('/assets/css/icons/fontawesome/styles.min.css') !!}
    {!! Html::style('/assets/css/bootstrap.css') !!}
    {!! Html::style('/assets/css/core.css') !!}
    {!! Html::style('/assets/css/components.css') !!}
    {!! Html::style('/assets/css/colors.css') !!}
            <!-- /global stylesheets -->
    <!-- View header custom styles -->
    @stack('header.styles')
            <!-- /View header custom styles -->

    <!-- Core JS files -->

    {!! Html::script('/assets/js/core/libraries/jquery.min.js') !!}
    {!! Html::script('/assets/js/core/libraries/bootstrap.min.js') !!}
    {!! Html::script('/assets/js/plugins/loaders/pace.min.js') !!}
    {!! Html::script('/assets/js/plugins/loaders/blockui.min.js') !!}
    {!! Html::script('/assets/js/plugins/forms/styling/uniform.min.js') !!}
    {!! Html::script('/assets/js/plugins/forms/tags/tokenfield.min.js') !!}
    {!! Html::script('/assets/js/plugins/ui/moment/moment.min.js') !!}
    {!! Html::script('/assets/js/plugins/pickers/daterangepicker.js') !!}
    {!! Html::script('/assets/js/plugins/forms/inputs/touchspin.min.js') !!}
    {!! Html::script('/assets/js/plugins/forms/selects/select2.min.js') !!}
    {!! Html::script('/assets/js/core/app.js') !!}

            <!-- /core JS files -->
    <!-- Header custom scripts -->
    @stack('header.scripts')
            <!-- /Header custom scripts -->

</head>

<body>

<!-- Main navbar -->
<div class="navbar navbar-inverse">
    <div class="navbar-header">
        <a class="navbar-brand" href="/"><img src="/assets/images/logo_light.png" alt=""></a>

        <ul class="nav navbar-nav pull-right visible-xs-block">
            <li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
            <li><a class="sidebar-mobile-main-toggle"><i class="icon-paragraph-justify3"></i></a></li>
        </ul>
    </div>

    <div class="navbar-collapse collapse" id="navbar-mobile">
        <ul class="nav navbar-nav">
            <li><a class="sidebar-control sidebar-main-toggle hidden-xs"><i class="icon-paragraph-justify3"></i></a>
            </li>
        </ul>

        <ul class="nav navbar-nav navbar-right">

            <li class="dropdown dropdown-user">
                <a class="dropdown-toggle" data-toggle="dropdown">
                    <img src="/assets/images/placeholder.jpg" alt="">
                    <span>{{ Auth::user()->name }}</span>
                    <i class="caret"></i>
                </a>

                <ul class="dropdown-menu dropdown-menu-right">
                    <li><a href=""><i class="icon-user-plus"></i> My profile</a></li>
                    <li><a href=""><i class="icon-cash3"></i> billing</a></li>
                    <li class="divider"></li>
                    <li><a href=""><i class="icon-footprint"></i>Account set up</a></li>
                    <li><a href=""><i class="icon-git-branch"></i>Tags information</a></li>
                    <li class="divider"></li>
                    <li><a href="{{ url('/logout') }}"><i class="icon-switch2"></i> Logout</a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>
<!-- /main navbar -->


<!-- Page container -->
<div class="page-container">

    <!-- Page content -->
    <div class="page-content">

        <!-- Main sidebar -->
        <div class="sidebar sidebar-main">
            <div class="sidebar-content">

                <!-- User menu -->
                <div class="sidebar-user">
                    <div class="category-content">
                        <div class="media">
                            {{--<a href="#" class="media-left"><img src="/assets/images/placeholder.jpg"--}}
                            {{--class="img-circle img-sm" alt=""></a>--}}
                            <div class="media-body">
                                <span class="media-heading text-semibold">{{ Auth::user()->name }}</span>
                                {{--<div class="text-size-mini text-muted">--}}
                                {{--<i class="icon-pin text-size-small"></i> &nbsp;Santa Ana, CA--}}
                                {{--</div>--}}
                            </div>

                            <div class="media-right media-middle">
                                <ul class="icons-list">
                                    <li>
                                        <a href="#"><i class="icon-cog3"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /user menu -->


                @include('partials.menu')

            </div>
        </div>
        <!-- /main sidebar -->


        <!-- Main content -->
        <div class="content-wrapper">

            <!-- Page header -->
            <div class="page-header">
                <div class="page-header-content">
                    <div class="page-title">
                        <h4>
                            {!! Title::render() !!}
                        </h4>
                    </div>
                </div>

                <div class="breadcrumb-line">

                    {!! Breadcrumbs::render() !!}

                    {!! BreadCrumbLinks::render() !!}

                </div>

            </div>
            <!-- /page header -->


            <!-- Content area -->
            <div class="content">
                @if (session('flash_message'))
                    <div class="alert alert-success">
                        {{ session('flash_message') }}
                    </div>
                    @endif
                    @yield('content')


                            <!-- Footer -->
                    <div class="footer text-muted">
                        &copy; 2016. <a href="http://www.adinton.com">Bikebitants</a> All rights reserved.
                    </div>
                    <!-- /footer -->

            </div>
            <!-- /content area -->

        </div>
        <!-- /main content -->

    </div>
    <!-- /page content -->

</div>
<!-- /page container -->
{{--{!! Html::script('/js/underscore.js') !!}--}}
<script type="text/javascript">
    /*_.templateSettings = {
     interpolate: /\{\{(.+?)\}\}/g
     };*/

    $('.select').select2({
        minimumResultsForSearch: Infinity
    });

    $(".styled").uniform({radioClass: 'choice'});

    // File input
    $(".file-styled").uniform({
        fileButtonHtml: '<i class="icon-googleplus5"></i>',
        wrapperClass: 'bg-warning'
    });

    $('.tokenfield').tokenfield();
    $('.tokenfield-email')
            .on('tokenfield:createdtoken', function (e) {
                var re = {{ StaticVars::emailValidation() }}
                var valid = re.test(e.attrs.value)
                if (!valid) {
                    $(e.relatedTarget).addClass('invalid')
                }
            })
            .tokenfield({
                'inputType': 'email'
            });

    // Single picker
    $('.daterange-single').daterangepicker({
        singleDatePicker: true,
        locale: {
            format: 'YYYY-MM-DD'
        }
    });

    $.each($('.touchspin'), function () {
        var minValue = $(this).data('min-value');
        var maxValue = $(this).data('max-value');
        $(this).TouchSpin({
            min: minValue ? minValue : 0,
            max: maxValue ? maxValue : 1000000,
            step: 1,
            decimals: 2
        });
    });
</script>
@stack('footer.scripts')
</body>
</html>