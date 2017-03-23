@extends('layouts.shop')
@section('content')
    @include('partials.breadcrumb')

    <section class="content eshop">
        <div class="container">
            <div class="default-style privacy-policy">
                <h2>Los medios ya hablan de nosotros.</h2>
                <p>A pesar de ser una startup creada hace solamente unos meses, tenemos la suerte de contar ya con algunas menciones en prensa y televisión:</p>
                <img src="https://blog.bikebitants.com/wp-content/uploads/2016/01/Medios-color-768x173.png">
            </div>
        </div>
    </section>

    <section class="content eshop">
        <div class="container">
            <div class="default-style downloads">
                <h2>Prensa / Revistas</h2>

                <div class="row">
                    <div class="col-md-12 col-lg-12">
                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                <tr>
                                    <td><i class="fa fa-file-photo-o"></i></td>
                                    <td><h3>Ciclistes il·luminats 360 graus</h3></td>
                                    <td><p>8 Noviembre 2015 – ARA</p></td>
                                    <td>
                                        <p class="text-right">
                                            <a target="_blank"
                                               href="https://blog.bikebitants.com/wp-content/uploads/2016/01/IMG-20151108-WA0005.jpg">
                                                @lang('layout.see') <i class="fa fa-arrow-circle-o-down"></i></a>
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td><i class="fa fa-file-photo-o"></i></td>
                                    <td><h3>Tecnología para convertir en una startup un negocio tradicional</h3></td>
                                    <td><p>21 Diciembre 2015 – EXPANSION</p></td>
                                    <td><p class="text-right">
                                            <a target="_blank"
                                               href="https://blog.bikebitants.com/wp-content/uploads/2016/01/Expansion_21_12_2015.png">
                                                @lang('layout.see') <i class="fa fa-arrow-circle-o-down"></i></a></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td><i class="fa fa-file-photo-o"></i></td>
                                    <td><h3>Tu bicicleta siempre visible</h3></td>
                                    <td><p>23 Marzo 2016 – COMPUTER HOY</p></td>
                                    <td><p class="text-right">
                                            <a target="_blank"
                                               href="https://blog.bikebitants.com/wp-content/uploads/2016/04/computer-hoy.png">
                                                @lang('layout.see') <i class="fa fa-arrow-circle-o-down"></i></a></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td><i class="fa fa-external-link "></i></td>
                                    <td><h3>Bikebitants té la bici de l’inspector Gadget</h3></td>
                                    <td><p>19 Mayo 2016 – VIA EMPRESA</p></td>
                                    <td><p class="text-right">
                                            <a target="_blank" rel="nofollow"
                                               href="http://www.viaempresa.cat/ca/notices/2016/05/bikebitants-te-la-bici-de-l-inspector-gadget-19273.php">
                                                @lang('layout.see') <i class="fa fa-arrow-circle-o-down"></i></a></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td><i class="fa fa-external-link "></i></td>
                                    <td><h3>Bikebitants, nuevo e-commerce de gadgets ‘futuristas’ para el ciclista
                                            urbano</h3></td>
                                    <td><p>26 Mayo 2016 – CMD Sport</p></td>
                                    <td><p class="text-right">
                                            <a target="_blank" rel="nofollow"
                                               href="http://www.cmdsport.com/esencial/cmd-ciclismo/bikebitants-nuevo-e-commerce-gadgets-futuristas-ciclista-urbano/">
                                                @lang('layout.see') <i class="fa fa-arrow-circle-o-down"></i></a>
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td><i class="fa fa-file-video-o"></i></td>
                                    <td><h3>Bikebitants: todos los gadgets para la bicicleta están aquí</h3></td>
                                    <td><p>13 Septiembre 2016 – CICLOSFERA</p></td>
                                    <td><p class="text-right">
                                            <a target="_blank" href="http://www.ciclosfera.com/bikebitants/">
                                                @lang('layout.see') <i class="fa fa-arrow-circle-o-down"></i></a>
                                        </p>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <section class="content eshop">
        <div class="container">
            <div class="default-style downloads">
                <h2>Televisión / Radio</h2>

                <div class="row">
                    <div class="col-md-12 col-lg-12">
                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                <tr>
                                    <td><i class="fa fa-file-video-o"></i></td>
                                    <td><h3>Revolights Eclipse y Bikebitants (minuto 20:16)</h3></td>
                                    <td><p>3 Enero 2016 – ENERGY TV – Juego de gadgets</p></td>
                                    <td>
                                        <p class="text-right">
                                            <a target="_blank"
                                               href="http://www.mitele.es/programas-tv/juego-de-gadgets/2016/programa-51/">
                                                @lang('layout.see') <i class="fa fa-arrow-circle-o-down"></i></a>
                                        </p>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection