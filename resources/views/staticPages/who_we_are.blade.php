@extends('layouts.shop')

@section('content')
    @include('partials.breadcrumb')

    <section class="content eshop">
        <div class="container">
            <div class="default-style about">
                <h2>About Us</h2>
                <div class="row">
                    <div class="col-sm-7 col-md-6">
                        <p>Somos una joven startup que quiere potenciar ciudades más sanas a través del fomento de una
                            movilidad más sostenible.</p>
                        <p>
                            Creada en Barcelona por un equipo que combina juventud y experiencia, con la colaboración de
                            Barcelona Activa, la entidad para la promoción del emprendimiento del Ayuntamiento de
                            Barcelona, y siguiendo la filosofía Lean Start Up, en Bikebitants ponenos al alcance de los
                            ciclistas urbanos, a través de nuestro eCommerce, los últimos productos tecnológicos e
                            innovadores, diseñados para superar las barreras que a día de hoy siguen existiendo a la
                            hora de moverse en bici por la ciudad.
                        </p>
                        <ul class="list-unstyled">
                            <li><i class="fa fa-check"></i>Transporte y movilidad, son claves para la sostenibilidad. </li>
                            <li><i class="fa fa-check"></i>Para tener éxito, hay que pensar en las personas</li>
                        </ul>
                    </div>
                    <div class="col-sm-5 col-md-6">
                        <img src="assets/images/slide-3.jpg" class="img-responsive" alt="">
                    </div>
                </div>
                {{--<div class="icon-nav row">
                    <div class="col-xs-6 col-sm-3"><a href="stores.html"><i class="fa fa-map-marker"></i> Our Stores</a>
                    </div>
                    <div class="col-xs-6 col-sm-3"><a href="privacy-policy.html"><i class="fa fa-lock"></i> Privacy
                            Policy</a></div>
                    <div class="col-xs-6 col-sm-3"><a href="terms-conditions.html"><i class="fa fa-book"></i> Terms &
                            Conditions</a></div>
                    <div class="col-xs-6 col-sm-3"><a href="faq.html"><i class="fa fa-question-circle"></i> FAQ</a>
                    </div>
                </div>--}}

                <div class="services">
                    <h2 class="text-center">Nosotros</h2>
                    <div class="row row-no-padding">

                        <!-- SERVICE - START -->
                        <div class="col-xs-6 col-sm-4">
                            <div class="service">
                                <img class="img-responsive" alt="Placeat ipsam molestiae quia unde ullam non. Quasi esse voluptatibus et quisquam quisquam pariatur dolor veniam. Aspernatur reiciendis dolores minus molestiae harum cupiditate. Incidunt nemo quis aut odio. In repellat assumenda ipsum est consequatur recusandae ut." sizes="100w" srcset="/img/330/846b0e4da00eff74add854029be33fa7.jpg 360w,/img/450/846b0e4da00eff74add854029be33fa7.jpg 480w,/img/254/846b0e4da00eff74add854029be33fa7.jpg 568w,/img/270/846b0e4da00eff74add854029be33fa7.jpg 600w,/img/354/846b0e4da00eff74add854029be33fa7.jpg 767w,/img/213/846b0e4da00eff74add854029be33fa7.jpg 992w,/img/263/846b0e4da00eff74add854029be33fa7.jpg 1200w">
                                <h3>Miguel Belenguer</h3>
                                <p>Ingeniero que no tiene claro como se hace una raíz cuadrada y que ha dedicado los últimos 7 años a I+D en automoción (así que fíate tu de los coches ;).</p>
                            </div>
                        </div>
                        <!-- SERVICE - END -->

                        <!-- SERVICE - START -->
                        <div class="col-xs-6 col-sm-4">
                            <div class="service">
                                <h3>Oriol Huesa</h3>
                                <p>Aprendiz incansable de marketing, internet y muchas otras cosas, experto gurú de nada en concreto.</p>
                            </div>
                        </div>
                        <!-- SERVICE - END -->

                        <!-- SERVICE - START -->
                        <div class="col-xs-6 col-sm-4">
                            <div class="service">
                                <h3>En<ric Bisbe</h3>
                                <p></p>
                            </div>
                        </div>
                        <!-- SERVICE - END -->

                    </div>

                </div>

            </div>
        </div>
    </section>
@endsection