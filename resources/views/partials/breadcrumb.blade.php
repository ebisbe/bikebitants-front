<!-- ==========================
    	BREADCRUMB - START
    =========================== -->
<section class="breadcrumb-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-xs-6">
                <h2>{{ $title }}</h2>
                <h1>{{ $subtitle }}</h1>
            </div>
            <div class="col-xs-6">
                {!! Breadcrumbs::render() !!}
            </div>
        </div>
    </div>
</section>
<!-- ==========================
    BREADCRUMB - END
=========================== -->