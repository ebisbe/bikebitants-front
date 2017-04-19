@extends('layouts.shop')

@section('content')
    @include('partials.breadcrumb')

    <section class="content eshop">
        <div class="container">
            <div class="default-style about">
                <h2>Sobre nosotros</h2>
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
                        <img src="{{ assetCDN('/images/EquipoBikebitants.jpg') }}" class="img-responsive" alt="Equipo Bikebitants">
                    </div>
                </div>
                <div class="services">
                    <h2 class="text-center">Nosotros</h2>
                    <div class="row row-no-padding">

                        <!-- SERVICE - START -->
                        <div class="col-xs-6 col-sm-4">
                            <div class="service">
                                <h3>Miguel Belenguer</h3>
                                <p>Tras 8 años desarrollando motores para automoción, Miguel ha cambiado los malos humos por la sostenible tracción humana a dos ruedas :-)</p>
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
                                <h3>Enric Bisbe Gil</h3>
                                <p>Vive escondido, como ermitaño, entre grandes montañas de códigos y del Pirineo.</p>
                            </div>
                        </div>
                        <!-- SERVICE - END -->

                    </div>

                </div>

            </div>
        </div>
    </section>
@endsection