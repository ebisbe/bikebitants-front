@extends('layouts.shop')

@section('content')
@include('partials.breadcrumb')

        <!-- ==========================
    	ESHOP - START
    =========================== -->
<section class="content eshop">
    <div class="container">
        <div class="default-style faq">
            <h2>Resolvemos tus dudas</h2>

            <div class="tabs vertical-tabs">
                <div class="row">
                    <div class="col-sm-3">
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active">
                                <a href="#faq-1" role="tab" data-toggle="tab"
                                   aria-controls="faq-1" aria-expanded="false">
                                    Pedidos y compras
                                </a>
                            </li>
                            <li role="presentation" class="">
                                <a href="#faq-2" role="tab" data-toggle="tab"
                                   aria-controls="faq-2" aria-expanded="false">
                                    Envios y entregas
                                </a>
                            </li>
                            <li role="presentation" class="">
                                <a href="#faq-3" role="tab" data-toggle="tab"
                                   aria-controls="faq-3" aria-expanded="false">
                                    Devoluciones, anulaciones y cambios
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-sm-9">
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active in" id="faq-1">

                                <div class="panel-group" id="faq-1-accordion" role="tablist"
                                     aria-multiselectable="true">

                                    <!-- QUESTION - START -->
                                    <div class="panel panel-primary">
                                        <div class="panel-heading" role="tab">
                                            <h4 class="panel-title">
                                                <a role="button" data-toggle="collapse"
                                                   data-parent="#faq-1-accordion" href="#faq-1-q-1"
                                                   aria-expanded="true" aria-controls="faq-1-q-1">
                                                    ¿Por que comprar en Bikebitants.com?
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="faq-1-q-1" class="panel-collapse collapse in" role="tabpanel">
                                            <div class="panel-body">
                                                <p>Somos una empresa joven que se preocupa por la movilidad sostenible y
                                                    por la seguridad y comodidad de todos los ciclistas urbanos.</p>
                                                <p>Lo hacemos todo pensando en el cliente, por lo que te vamos a
                                                    escuchar como pocas empresas lo hacen.</p>
                                                <p>Además, tenemos el compromiso de donar un 1% de nuestros beneficios a
                                                    proyectos que fomenten la movilidad sostenible.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- QUESTION - END -->

                                    <!-- QUESTION - START -->
                                    <div class="panel panel-primary">
                                        <div class="panel-heading" role="tab">
                                            <h4 class="panel-title">
                                                <a role="button" data-toggle="collapse"
                                                   data-parent="#faq-1-accordion" href="#faq-1-q-2"
                                                   aria-expanded="true" aria-controls="faq-1-q-2">
                                                    ¿Es seguro comprar en Bikebitants.com?
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="faq-1-q-2" class="panel-collapse collapse" role="tabpanel">
                                            <div class="panel-body">
                                                <p>Por supuesto. Todas las compras en Bikebitants.com son <strong>100%
                                                        seguras</strong>. Los protocolos de seguridad y encriptación
                                                    que se utilizan para las transacciones bancarias son seguros
                                                    100%.</p>
                                                <p><strong>Tus datos bancarios están protegidos y
                                                        encriptados</strong> por la tecnología más avanzada. Tus
                                                    datos bancarios se remitirán a nuestro servidor de forma cifrada
                                                    a través del <strong>protocolo SSL</strong> (Secure Socket
                                                    Layer) y se transmitirán en un entorno totalmente seguro a
                                                    nuestro banco. En ningún momento tus datos son almacenados en
                                                    nuestros servidores.</p>

                                            </div>
                                        </div>
                                    </div>
                                    <!-- QUESTION - END -->

                                    <!-- QUESTION - START -->
                                    <div class="panel panel-primary">
                                        <div class="panel-heading" role="tab">
                                            <h4 class="panel-title">
                                                <a role="button" data-toggle="collapse"
                                                   data-parent="#faq-1-accordion" href="#faq-1-q-3"
                                                   aria-expanded="true" aria-controls="faq-1-q-3">
                                                    ¿Cuáles son los métodos de pago?
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="faq-1-q-3" class="panel-collapse collapse" role="tabpanel">
                                            <div class="panel-body">
                                                <p>En la web de Bikebitants.com puedes pagar con :</p>
                                                <ul>
                                                    <li><strong>Tarjeta de débito/crédito</strong>.<br/>
                                                        Es el método más rápido, más seguro y que no tiene ningún
                                                        tipo de comisión para ti. Bikebitants tiene un acuerdo con
                                                        Banc Sabadell para garantizar la máxima seguridad en los
                                                        pagos online y proporcionar una pasarela de pago intuitiva y
                                                        fácil de usar.
                                                    </li>
                                                    <li><strong>Paypal<br/>
                                                        </strong>Si tienes cuenta de Paypal, pero tambien si no la
                                                        tienes puedes utilizar Paypal para pagar tu pedido.
                                                    </li>
                                                    <li><strong>Transferencia bancaria<br/>
                                                        </strong>Puedes pagarnos directamente a nuestra cuenta
                                                        bancaria. El pedido no será tramitado hasta que el importe
                                                        del pedido esté ingresado en nuestra cuenta.
                                                    </li>
                                                    <li><strong>Contra rembolso<br/>
                                                        </strong>Puedes pagar en efectivo al recibir tu pedido.
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- QUESTION - END -->
                                </div>

                            </div>

                            <div role="tabpanel" class="tab-pane " id="faq-2">

                                <div class="panel-group" id="faq-2-accordion" role="tablist"
                                     aria-multiselectable="true">

                                    <!-- QUESTION - START -->
                                    <div class="panel panel-primary">
                                        <div class="panel-heading" role="tab">
                                            <h4 class="panel-title">
                                                <a role="button" data-toggle="collapse"
                                                   data-parent="#faq-2-accordion" href="#faq-2-q-1"
                                                   aria-expanded="true" aria-controls="faq-2-q-1">
                                                    ¿Por que comprar en Bikebitants.com?
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="faq-2-q-1" class="panel-collapse collapse in" role="tabpanel">
                                            <div class="panel-body">
                                                <p><strong>Los gastos de envío son gratuitos</strong> para todos los pedidos y para toda la península <strong>para pedidos a partir de 30€</strong>.</p>
                                                <p>Para pedidos inferiores a 30€, el coste del envío sera de 4€.</p>
                                                <p>El resto de España (Baleares, Canarias, Ceuta y Melilla) quedan excluidas de esta tarifa gratuita:</p>
                                                <p>Baleares: 10 €</p>
                                                <p>Canarias: 25€</p>
                                                <p>Ceuta y Melilla: 25€</p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- QUESTION - END -->

                                    <!-- QUESTION - START -->
                                    <div class="panel panel-primary">
                                        <div class="panel-heading" role="tab">
                                            <h4 class="panel-title">
                                                <a role="button" data-toggle="collapse"
                                                   data-parent="#faq-2-accordion" href="#faq-2-q-2"
                                                   aria-expanded="true" aria-controls="faq-2-q-2">
                                                    ¿Es seguro comprar en Bikebitants.com?
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="faq-2-q-2" class="panel-collapse collapse" role="tabpanel">
                                            <div class="panel-body">
                                                <p>En Bikebitants trabajamos para que tu pedido llegue en el menor tiempo posible. En condiciones normales, el plazo de entrega para los productos de la tienda será de 1 a 2 días. En todos los casos, en la ficha de producto se indica de los plazos de entrega para cada pedido.</p>
                                                <p>Así, por norma general:</p>
                                                <p>En día laborable:</p>
                                                <p>Para pedidos antes de las 13:30h, entrega el siguiente día laborable.</p>
                                                <p>En fin de semana:<br />
                                                    Para pedidos antes del viernes a las 13:30h, entrega el lunes.<br />
                                                    Para pedidos después del viernes a las 13:30h, entrega el martes.</p>
                                                <p>Para pedidos desde Baleares y Canarias, el tiempo de entrega es de 3 a 4 días..</p>
                                                <p>Nuestro operador realiza el <strong>tracking del envío</strong> para que en todo momento sepas en que situación se encuentra tu pedido.</p>

                                            </div>
                                        </div>
                                    </div>
                                    <!-- QUESTION - END -->

                                </div>

                            </div>

                            <div role="tabpanel" class="tab-pane  " id="faq-3">

                                <div class="panel-group" id="faq-3-accordion" role="tablist"
                                     aria-multiselectable="true">

                                    <!-- QUESTION - START -->
                                    <div class="panel panel-primary">
                                        <div class="panel-heading" role="tab">
                                            <h4 class="panel-title">
                                                <a role="button" data-toggle="collapse"
                                                   data-parent="#faq-3-accordion" href="#faq-3-q-1"
                                                   aria-expanded="true" aria-controls="faq-1-q-1">
                                                    ¿Puedo devolver un artículo después de recibirlo?
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="faq-3-q-1" class="panel-collapse collapse in" role="tabpanel">
                                            <div class="panel-body">
                                                <p><strong>Aceptamos tanto la devolución tanto por material defectuoso como por decisión voluntaria</strong>, hasta 30 días después de la entrega.</p>
                                                <p>En ambos casos te pediremos que lo prepares con el embalaje original para pasarlo a recoger.</p>
                                                <p>Puedes ver todo el procedimiento en <a href="http://bikebitants.com/condiciones-generales/#devoluciones">Condiciones Generales</a></p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- QUESTION - END -->

                                    <!-- QUESTION - START -->
                                    <div class="panel panel-primary">
                                        <div class="panel-heading" role="tab">
                                            <h4 class="panel-title">
                                                <a role="button" data-toggle="collapse"
                                                   data-parent="#faq-3-accordion" href="#faq-3-q-2"
                                                   aria-expanded="true" aria-controls="faq-3-q-2">
                                                    ¿Cuándo recibo el reembolso de mi devolución?
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="faq-3-q-2" class="panel-collapse collapse" role="tabpanel">
                                            <div class="panel-body">
                                                <p>Una vez devuelto el producto, cuando llegue a Bikebitants, examinaremos que cumple las condiciones de devolución arriba detalladas y si todo es correcto procederemos a abonarte en tu tarjeta de crédito el importe de la compra, exceptuando el coste del operador logístico para venir a recogerte el producto.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- QUESTION - END -->

                                    <!-- QUESTION - START -->
                                    <div class="panel panel-primary">
                                        <div class="panel-heading" role="tab">
                                            <h4 class="panel-title">
                                                <a role="button" data-toggle="collapse"
                                                   data-parent="#faq-3-accordion" href="#faq-3-q-3"
                                                   aria-expanded="true" aria-controls="faq-3-q-3">
                                                    ¿Puedo cambiar mi pedido por otra talla?
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="faq-3-q-3" class="panel-collapse collapse" role="tabpanel">
                                            <div class="panel-body">
                                                <p>Por supuesto. El cambio de talla es gratuito.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- QUESTION - END -->

                                    <!-- QUESTION - START -->
                                    <div class="panel panel-primary">
                                        <div class="panel-heading" role="tab">
                                            <h4 class="panel-title">
                                                <a role="button" data-toggle="collapse"
                                                   data-parent="#faq-3-accordion" href="#faq-3-q-4"
                                                   aria-expanded="true" aria-controls="faq-3-q-4">
                                                    ¿Puedo cancelar mi pedido?
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="faq-3-q-4" class="panel-collapse collapse" role="tabpanel">
                                            <div class="panel-body">
                                                <p>Solo aceptaremos la anulación del pedido si el producto aún no se encuentra en la fase de logística y por motivos operativos no es posible detener el proceso de entrega.</p>

                                            </div>
                                        </div>
                                    </div>
                                    <!-- QUESTION - END -->
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
<!-- ==========================
    ESHOP - END
=========================== -->
@endsection