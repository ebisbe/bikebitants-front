@extends('layouts.shop')
@section('content')
    @include('partials.breadcrumb')

    <section class="content eshop">
        <div class="container">
            <div class="default-style about">
                <h2>About Us</h2>
                <div class="row">
                    <div class="col-sm-7 col-md-6">
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex. Suspendisse aliquet imperdiet commodo. Aenean vel lacinia elit. Class aptent taciti sociosqu ad litora torquent per.</p>
                        <p>Sed eget pulvinar quam, vel feugiat enim. Aliquam erat volutpat. Phasellus eu porta ipsum. Suspendisse aliquet imperdiet commodo. Aenean vel lacinia elit. Class aptent taciti sociosqu ad litora torquent per. Vestibulum velmo.</p>
                        <ul class="list-unstyled">
                            <li><i class="fa fa-check"></i>Etiam sed dolor ac diam volutpat</li>
                            <li><i class="fa fa-check"></i>Erat volutpat. Phasellus eu porta ipsum suspendisse aliquet imperdiet</li>
                            <li><i class="fa fa-check"></i>Phasellus eu porta ipsum. Suspendisse aliquet imperdiet commodo</li>
                            <li><i class="fa fa-check"></i>Sed eget pulvinar quam, vel feugiat enim aliquam</li>
                        </ul>
                    </div>
                    <div class="col-sm-5 col-md-6">
                        <img src="assets/images/slide-3.jpg" class="img-responsive" alt="">
                    </div>
                </div>

                <div class="services">
                    <h2 class="text-center">Ventajas de ir al trabajo en bicis</h2>
                    <div class="row row-no-padding">

                        <!-- SERVICE - START -->
                        <div class="col-xs-6 col-sm-3">
                            <div class="service">
                                <i class="fa fa-leaf"></i>
                                <h3>Un medio de transporte sostenible</h3>
                                <p>La bicicleta es ecológica, no emite CO2 y no hace ruido.</p>
                            </div>
                        </div>
                        <!-- SERVICE - END -->

                        <!-- SERVICE - START -->
                        <div class="col-xs-6 col-sm-3">
                            <div class="service">
                                <i class="fa fa-euro"></i>
                                <h3>Supone un ahorro económico</h3>
                                <p>La bicicleta no consume combustible</p>
                            </div>
                        </div>
                        <!-- SERVICE - END -->

                        <!-- SERVICE - START -->
                        <div class="col-xs-6 col-sm-3">
                            <div class="service">
                                <i class="fa fa-clock-o"></i>
                                <h3>Evita atascos y aglomeraciones!</h3>
                                <p>Se acabó pasar horas encerrado en el coche, en el autobús o sufriendo la masificación de la hora punta.</p>
                            </div>
                        </div>
                        <!-- SERVICE - END -->

                        <!-- SERVICE - START -->
                        <div class="col-xs-6 col-sm-3">
                            <div class="service">
                                <i class="fa fa-heartbeat"></i>
                                <h3>Promueve el ejercicio físico</h3>
                                <p>Acabar con el sedentarismo que afrontan especialmente todos aquellos que trabajan en oficinas.</p>
                            </div>
                        </div>
                        <!-- SERVICE - END -->

                    </div>

                </div>
                <div class="services">
                    <h2 class="text-center">Beneficios para las empresas responsables</h2>
                    <div class="row row-no-padding">

                        <!-- SERVICE - START -->
                        <div class="col-xs-6 col-sm-3">
                            <div class="service">
                                <i class="fa fa-globe"></i>
                                <h3>Responsabilidad corporativa</h3>
                                <p>Reducción de emisiones de CO2 y de consumo de otros recursos.</p>
                            </div>
                        </div>
                        <!-- SERVICE - END -->

                        <!-- SERVICE - START -->
                        <div class="col-xs-6 col-sm-3">
                            <div class="service">
                                <i class="fa fa-comments"></i>
                                <h3>Valor social</h3>
                                <p>Las acciones de movilidad de la empresa generan valor a la empresa, a sus empleados y a toda la sociedad.</p>
                            </div>
                        </div>
                        <!-- SERVICE - END -->

                        <!-- SERVICE - START -->
                        <div class="col-xs-6 col-sm-3">
                            <div class="service">
                                <i class="fa fa-scissors"></i>
                                <h3>Descuentos exclusivos</h3>
                                <p>Descuentos y tarifas exclusivas desde la primera unidad y compra.</p>
                            </div>
                        </div>
                        <!-- SERVICE - END -->

                        <!-- SERVICE - START -->
                        <div class="col-xs-6 col-sm-3">
                            <div class="service">
                                <i class="fa fa-line-chart"></i>
                                <h3>Empleados motivados y productivos</h3>
                                <p>Reducción del absentismo laboral y aumento de la productividad.</p>
                            </div>
                        </div>
                        <!-- SERVICE - END -->

                    </div>

                </div>

            </div>
        </div>
    </section>

@endsection