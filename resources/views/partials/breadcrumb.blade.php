<!-- ==========================
    	BREADCRUMB - START
    =========================== -->
<section class="breadcrumb-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-xs-6">
                <h2>{{ $title }}</h2>
                <p>{{ $subtitle }}</p>
            </div>
            <div class="col-xs-6">
                {!! BreadCrumbLinks::render('breadcrumb', 'ol') !!}
            </div>
        </div>
    </div>
</section>
<!-- ==========================
    BREADCRUMB - END
=========================== -->