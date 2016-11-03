@extends('layouts.shop')

@section('content')
@include('partials.breadcrumb')

        <!-- ==========================
    	ESHOP - START
    =========================== -->
<section class="content eshop">
    <div class="container">
        <div class="default-style faq">
            <h2>Terminos y condicines</h2>

            <div class="tabs vertical-tabs">
                <div class="row">
                    <div class="col-sm-3">
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#faq-1" role="tab" data-toggle="tab"
                                                                      aria-controls="faq-1" aria-expanded="true">Condiciones
                                    Legales</a></li>
                            <li role="presentation" class=""><a href="#faq-2" role="tab" data-toggle="tab"
                                                                aria-controls="faq-2" aria-expanded="false">Condiciones
                                    de entrega</a></li>
                            <li role="presentation" class=""><a href="#faq-3" role="tab" data-toggle="tab"
                                                                aria-controls="faq-3" aria-expanded="false">Devoluciones,
                                    anulacines y cambios</a></li>
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
                                                    Objeto y Generalidades
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="faq-1-q-1" class="panel-collapse collapse in" role="tabpanel">
                                            <div class="panel-body">
                                                Las presentes Condiciones Generales de Uso y Contratación tienen como
                                                objeto regular el uso y las transacciones comerciales entre
                                                bikebitants.com y el usuario de dicho dominio. El dominio
                                                bikebitants.com es titularidad de Bikebitants, SL, con domicilio en C/
                                                Doctor Trueta 112, bajos 17 (Barcelona) , inscrita con fecha 01/10/2015
                                                en el Registro Mercantil de Barcelona, en el tomo 4504, folio 7, hoja
                                                núm. B-473958, inscripción 1ª, con número de CIF B66615394.
                                            </div>
                                        </div>
                                    </div>
                                    <!-- QUESTION - END -->

                                    <!-- QUESTION - START -->
                                    <div class="panel panel-primary">
                                        <div class="panel-heading" role="tab">
                                            <h4 class="panel-title">
                                                <a class="collapsed" role="button" data-toggle="collapse"
                                                   data-parent="#faq-1-accordion" href="#faq-1-q-2"
                                                   aria-expanded="false" aria-controls="faq-1-q-2">
                                                    Legislación aplicable
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="faq-1-q-2" class="panel-collapse collapse" role="tabpanel">
                                            <div class="panel-body">
                                                Las presentes Condiciones Generales, están sujetas a lo dispuesto a la
                                                Ley 7/1998, de 13 de abril, sobre Condiciones Generales de Contratación,
                                                a la Ley 26/1984, de 19 de julio, General para la Defensa de
                                                Consumidores y Usuarios, al Real Decreto 1906/1999, de 17 de diciembre
                                                de 1999, por el que se regula la Contratación Telefónica o Electrónica
                                                con condiciones generales, la Ley Orgánica 15/1999, de 13 de diciembre,
                                                de Protección de Datos de Carácter Personal, la Ley 7/1996, de 15 de
                                                enero de Ordenación del Comercio Minorista, y a la Ley 34/2002 de 11 de
                                                julio, de Servicios de la Sociedad de la Información y de Comercio
                                                Electrónico y a el Real Decreto Legislativo 1/2007, de 16 de noviembre,
                                                por el que se aprueba el texto refundido de la Ley General para la
                                                Defensa de los Consumidores y Usuarios.
                                            </div>
                                        </div>
                                    </div>
                                    <!-- QUESTION - END -->

                                    <!-- QUESTION - START -->
                                    <div class="panel panel-primary">
                                        <div class="panel-heading" role="tab">
                                            <h4 class="panel-title">
                                                <a class="collapsed" role="button"
                                                   data-toggle="collapse"
                                                   data-parent="#faq-1-accordion" href="#faq-1-q-3"
                                                   aria-expanded="false" aria-controls="faq-1-q-3">
                                                    Ley aplicable y jurisdicción competente
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="faq-1-q-3" class="panel-collapse collapse" role="tabpanel">
                                            <div class="panel-body">
                                                Las compraventas realizadas en bikebitants.com se someten a la
                                                legislación española. En el supuesto de que surja cualquier conflicto o
                                                discrepancia en la interpretación o aplicación de las presentes
                                                condiciones contractuales, las partes se someten a la jurisdicción de
                                                los tribunales de la ciudad de Barcelona, salvo que la ley imponga otra
                                                jurisdicción.
                                            </div>
                                        </div>
                                    </div>
                                    <!-- QUESTION - END --><!-- QUESTION - START -->
                                    <div class="panel panel-primary">
                                        <div class="panel-heading" role="tab">
                                            <h4 class="panel-title">
                                                <a class="collapsed" role="button"
                                                   data-toggle="collapse"
                                                   data-parent="#faq-1-accordion" href="#faq-1-q-4"
                                                   aria-expanded="false" aria-controls="faq-1-q-4">
                                                    Información de la página web
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="faq-1-q-4" class="panel-collapse collapse" role="tabpanel">
                                            <div class="panel-body">
                                                Las descripciones de los productos expuestos en bikebitants.com se
                                                realizan en base a la información proporcionada por los proveedores y al
                                                equipo editorial de Bikebitants. Bikebitants se compromete a poner los
                                                medios necesarios para que los contenidos sean exactos y estén
                                                actualizados. No obstante, la información dada sobre cada producto, así
                                                como las fotografías o vídeos relativos a los mismos y los nombres
                                                comerciales, marcas o signos distintivos de cualquier clase contenidos
                                                en la página web de Bikebitants, son expuestos en bikebitants.com a modo
                                                orientativo.
                                                <br/>
                                                <br/>
                                                Bikebitants se reserva el derecho de modificar la oferta comercial
                                                (productos, precios, promociones y otras condiciones comerciales y de
                                                servicio) presentada en www.bikebitants.com en cualquier momento. De
                                                existir un error tipográfico en alguno de los precios mostrados y algún
                                                cliente hubiera tomado una decisión de compra basada en dicho error, le
                                                comunicaremos dicho error y el cliente tendrá derecho a rescindir su
                                                compra sin ningún coste por su parte.
                                            </div>
                                        </div>
                                    </div>
                                    <!-- QUESTION - END --><!-- QUESTION - START -->
                                    <div class="panel panel-primary">
                                        <div class="panel-heading" role="tab">
                                            <h4 class="panel-title">
                                                <a class="collapsed" role="button"
                                                   data-toggle="collapse"
                                                   data-parent="#faq-1-accordion" href="#faq-1-q-5"
                                                   aria-expanded="false" aria-controls="faq-1-q-5">
                                                    Seguridad
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="faq-1-q-5" class="panel-collapse collapse" role="tabpanel">
                                            <div class="panel-body">
                                                Bikebitants cuenta con los últimos avances en materia de seguridad
                                                comercialmente disponibles en el sector. Además, el proceso de pago
                                                funciona sobre un servidor seguro utilizando el protocolo SSL (Secure
                                                Socket Layer). El servidor seguro establece una conexión de modo que la
                                                información se transmite cifrada mediante algoritmos de 128 bits, que
                                                aseguran que sólo sea inteligible para el ordenador del Socio y el de
                                                bikebitants.com. La política de seguridad de Bikebitants cumple con las
                                                normas previstas en el Real Decreto 1720/2007, de 21 de diciembre, por
                                                el que se aprueba el Reglamento de desarrollo de la Ley Orgánica
                                                15/1999, de 13 de diciembre, de protección de datos de carácter
                                                personal.
                                                <br/><br/>
                                                De esta forma, al utilizar el protocolo SSL se garantiza:
                                                <br/><br/>
                                                Que el Socio está comunicando sus datos al centro servidor de
                                                Bikebitants y no a cualquier otro que intentara hacerse pasar por éste.
                                                Que entre el Socio y el centro servidor de Bikebitants los datos se
                                                transmiten cifrados, evitando su posible lectura o manipulación por
                                                terceros.
                                                Asimismo, Bikebitants manifiesta que no tiene acceso a datos
                                                confidenciales relativos al medio de pago utilizado, y por tanto tampoco
                                                los almacena. Únicamente “Banc Sabadell” y PayPal tienen acceso a estos
                                                datos a modo de gestión de los pagos y cobros y que son inaccesibles a
                                                otros terceros.
                                                <br/><br/>
                                                Bikebitants no será responsable en ningún caso de las incidencias que
                                                puedan surgir entorno a los datos personales cuando se deriven bien de
                                                un ataque o acceso no autorizado a los sistemas de manera tal que sea
                                                imposible de detectar por las medidas de seguridad implantadas o bien
                                                cuando se deba a una falta de diligencia del cliente en relación a la
                                                guardia y custodia de sus claves de acceso o de sus propios datos
                                                personales. En cualquier caso el cliente deberá informar inmediatamente
                                                a Bikebitants en el caso que conozca que sus claves de acceso han sido
                                                conocidas por terceros.

                                            </div>
                                        </div>
                                    </div>
                                    <!-- QUESTION - END --><!-- QUESTION - START -->
                                    <div class="panel panel-primary">
                                        <div class="panel-heading" role="tab">
                                            <h4 class="panel-title">
                                                <a class="collapsed" role="button"
                                                   data-toggle="collapse"
                                                   data-parent="#faq-1-accordion" href="#faq-1-q-6"
                                                   aria-expanded="false" aria-controls="faq-1-q-6">
                                                    Propiedad intelectual e industrial
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="faq-1-q-6" class="panel-collapse collapse" role="tabpanel">
                                            <div class="panel-body">
                                                Todos los contenidos publicados en la tienda y especialmente los
                                                diseños, textos, gráficos, logos, iconos, botones, así como el software,
                                                los nombres comerciales, las marcas o dibujos industriales y
                                                cualesquiera otros signos susceptibles de utilización industrial y
                                                comercial están sujetos a derechos de propiedad intelectual e industrial
                                                de Bikebitants o de terceros titulares de los mismos que han autorizado
                                                debidamente su inclusión en el website. En ningún caso se entenderá que
                                                se concede licencia alguna o se efectúa renuncia, transmisión, cesión
                                                total o parcial de dichos derechos ni se confiere ningún derecho ni
                                                expectativa de derecho, y en especial, de alteración, explotación,
                                                reproducción, distribución o comunicación pública sobre dichos
                                                contenidos sin la previa autorización expresa de Bikebitants o de los
                                                titulares correspondientes.
                                                <br/><br/>
                                                Queda expresamente prohibida la reproducción total o parcial de esta
                                                web, ni siquiera mediante un hiperenlace, ni de cualquiera de sus
                                                contenidos, sin el permiso expreso y por escrito de Bikebitants .

                                            </div>
                                        </div>
                                    </div>
                                    <!-- QUESTION - END --><!-- QUESTION - START -->
                                    <div class="panel panel-primary">
                                        <div class="panel-heading" role="tab">
                                            <h4 class="panel-title">
                                                <a class="collapsed" role="button"
                                                   data-toggle="collapse"
                                                   data-parent="#faq-1-accordion" href="#faq-1-q-7"
                                                   aria-expanded="false" aria-controls="faq-1-q-7">
                                                    Responsabilidades de Bikebitants
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="faq-1-q-7" class="panel-collapse collapse" role="tabpanel">
                                            <div class="panel-body">
                                                Los productos presentados en el website son conformes a la legislación
                                                española. El usuario asume toda la responsabilidad derivada del uso de
                                                nuestro website, siendo el único responsable de todo efecto directo o
                                                indirecto que sobre el website se derive, incluyendo, de forma
                                                enunciativa y no limitativa, todo resultado económico, técnico y/o
                                                jurídico adverso, así como la defraudación de las expectativas generadas
                                                por nuestro website, obligándose el usuario a mantener indemne a
                                                Bikebitants por cualesquiera reclamaciones derivadas, directa o
                                                indirectamente de tales hechos.
                                                <br/><br/>
                                                Bikebitants no se hace responsable de los perjuicios que se pudieran
                                                derivar de interferencias, omisiones, interrupciones, virus
                                                informáticos, averías y/o desconexiones en el funcionamiento operativo
                                                de este sistema electrónico o en los aparatos y equipos informáticos de
                                                los usuarios, motivadas por causas ajenas a Bikebitants , que impidan o
                                                retrasen la prestación de los servicios o la navegación por la tienda,
                                                ni de lo retrasos o bloqueos en el uso causados por deficiencias o
                                                sobrecargas de Internet o en otros sistemas electrónicos, ni de la
                                                imposibilidad de dar el servicio o permitir el acceso por causas no
                                                imputables a Bikebitants , debidas al usuario, a terceros, o a supuestos
                                                de fuerza mayor. Bikebitants no controla, con carácter general, la
                                                utilización que los usuarios hacen del website. En particular
                                                Bikebitants no garantiza bajo ningún extremo que los usuarios utilicen
                                                el website de conformidad con la ley, las presentes Condiciones
                                                Generales, la moral y buenas costumbres generalmente aceptadas y el
                                                orden público, ni tampoco que lo hagan de forma diligente y prudente.
                                            </div>
                                        </div>
                                    </div>
                                    <!-- QUESTION - END --><!-- QUESTION - START -->
                                    <div class="panel panel-primary">
                                        <div class="panel-heading" role="tab">
                                            <h4 class="panel-title">
                                                <a class="collapsed" role="button"
                                                   data-toggle="collapse"
                                                   data-parent="#faq-1-accordion" href="#faq-1-q-8"
                                                   aria-expanded="false" aria-controls="faq-1-q-8">
                                                    Responsabilidades de los clientes y usuarios
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="faq-1-q-8" class="panel-collapse collapse" role="tabpanel">
                                            <div class="panel-body">
                                                Con carácter general el usuario se obliga al cumplimiento de las
                                                presentes condiciones generales, así como a cumplir las especiales
                                                advertencias o instrucciones de uso contenidas en las mismas o en el
                                                website y obrar siempre conforme a la ley, a las buenas costumbres y a
                                                las exigencias de la buena fe, empleando la diligencia debida, y
                                                absteniéndose de utilizar el website de cualquier forma que pueda
                                                impedir, dañar o deteriorar el normal funcionamiento del mismo, los
                                                bienes o derechos de Bikebitants, sus proveedores, el resto de usuarios
                                                o en general de cualquier tercero. Queda prohibido el acceso y uso del
                                                portal a los menores de edad sin el consentimiento expreso de sus
                                                padres, Bikebitants no se responsabiliza de la veracidad y exactitud de
                                                los datos rellenados por el usuario y por tanto no puede constatar la
                                                edad de los mismos.
                                                <br/><br/>
                                                Concretamente, y sin que ello implique restricción alguna al apartado
                                                anterior durante la utilización del website www.bikebitants.com el
                                                usuario se obliga a:<br/>
                                                a) Facilitar información veraz sobre los datos solicitados en el
                                                formulario de registro de usuario o de realización del pedido, y a
                                                mantenerlos actualizados.<br/>
                                                b) No introducir, almacenar o difundir en o desde el website, cualquier
                                                información o material que fuera difamatorio, injurioso, obsceno,
                                                amenazador, xenófobo, incite a la violencia a la discriminación por
                                                razón de raza, sexo, ideología, religión o que de cualquier forma atente
                                                contra la moral, el orden público, los derechos fundamentales, las
                                                libertades públicas, el honor, la intimidad o la imagen de terceros y en
                                                general la normativa vigente.<br/>
                                                c) No introducir, almacenar o difundir mediante la tienda ningún
                                                programa, datos, virus, código, o cualquier otro dispositivo electrónico
                                                o físico que sea susceptible de causar daños en el website, en
                                                cualquiera de los servicios, o en cualquiera de los equipos, sistemas o
                                                redes de www.bikebitants.com, de cualquier otro usuario, de los
                                                proveedores de www.bikebitants.com o en general de cualquier
                                                tercero.<br/>
                                                d) Guardar diligentemente el “nombre de usuario” y la “contraseña” que
                                                le sea facilitada por www.bikebitants.com, asumiendo la responsabilidad
                                                por los daños y perjuicios que pudieran derivarse de un uso indebido de
                                                los mismos.<br/>
                                                e) No realizar actividades publicitarias o de explotación comercial a
                                                través del website, y a no utilizar los contenidos y la información del
                                                mismo para remitir publicidad, o enviar mensajes con cualquier otro fin
                                                comercial, ni para recoger o almacenar datos personales de
                                                terceros.<br/>
                                                f) No utilizar identidades falsas, ni suplantar la identidad de otros en
                                                la utilización del website o en la utilización de cualquiera de los
                                                servicios del mismo, incluyendo la utilización en su caso de contraseñas
                                                o claves de acceso de terceros o de cualquier otra forma<br/>
                                                g) No destruir, alterar, utilizar para su uso, inutilizar o dañar los
                                                datos, informaciones, programas o documentos electrónicos de
                                                Bikebitants, sus proveedores o terceros.<br/>
                                                h) No introducir, almacenar o difundir mediante la tienda cualquier
                                                contenido que infrinja derechos de propiedad intelectual, industrial o
                                                secretos empresariales de terceros, ni en general ningún contenido del
                                                cual no ostentara, de conformidad con la ley, el derecho a ponerlo a
                                                disposición de tercero.
                                                <br/><br/>
                                                El cliente se compromete a posibilitar la entrega del pedido solicitado
                                                facilitando una dirección de entrega en la que pueda ser entregado el
                                                pedido solicitado dentro del horario habitual de entrega de mercancías.
                                                En caso incumplimiento por parte del cliente de esta obligación
                                                Bikebitants no tendrá ninguna responsabilidad sobre el retraso o
                                                imposibilidad de entrega del pedido solicitado por el cliente.
                                            </div>
                                        </div>
                                    </div>
                                    <!-- QUESTION - END -->
                                    <!-- QUESTION - START -->
                                    <div class="panel panel-primary">
                                        <div class="panel-heading" role="tab">
                                            <h4 class="panel-title">
                                                <a class="collapsed" role="button"
                                                   data-toggle="collapse"
                                                   data-parent="#faq-1-accordion" href="#faq-1-q-9"
                                                   aria-expanded="false" aria-controls="faq-1-q-9">
                                                    Garantía de los productos adquiridos
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="faq-1-q-9" class="panel-collapse collapse" role="tabpanel">
                                            <div class="panel-body">
                                                El plazo de garantía es el que establecen los fabricantes o los
                                                distribuidores de las marcas comercializadas por Bikebitants, si bien en
                                                la misma no se incluyen deficiencias ocasionadas por negligencias,
                                                golpes, uso incorrecto o manipulaciones indebidas, instalaciones
                                                incorrectas, etc., ni materiales que estén desgastados por el uso.
                                                <br/><br/>
                                                Una vez que el Cliente haya recibido el producto tendrá un folleto
                                                informativo de la marca, las instrucciones suficientes para el correcto
                                                uso e instalación del producto y toda la información sobre la garantía.
                                                Ningún Cliente podrá solicitar una garantía más amplia de la que ahí se
                                                indica.
                                                <br/><br/>
                                                Bikebitants no estará obligada a recoger el producto averiado y el
                                                Cliente deberá dirigirse al Servicio Posventa del Proveedor. En este
                                                sentido, Bikebitants realizará las acciones encaminadas a proporcionar a
                                                los Clientes que así lo soliciten los datos de contacto de dicho
                                                servicio y facilitará a estos información suficiente para la
                                                presentación de las reclamaciones pertinentes.
                                                <br/><br/>
                                                La garantía perderá su vigencia en caso de defectos o deterioros
                                                causados por factores externos, accidentes, en especial, accidentes
                                                eléctricos, desgaste, instalación y utilización no conforme a las
                                                instrucciones del Proveedor.
                                                <br/><br/>
                                                Quedan excluidos de la garantía los productos modificados o reparados
                                                por el Cliente o cualquier otra persona no autorizada por el proveedor.
                                                La garantía no será aplicable a los vicios aparentes y los defectos de
                                                conformidad del producto, para los que cualquier reclamación deberá ser
                                                formulada por el Cliente en cuestión en los 7 días siguientes a la
                                                entrega de los productos. La garantía no cubrirá los productos dañados
                                                por un uso inadecuado.
                                            </div>
                                        </div>
                                    </div>
                                    <!-- QUESTION - END -->
                                    <!-- QUESTION - START -->
                                    <div class="panel panel-primary">
                                        <div class="panel-heading" role="tab">
                                            <h4 class="panel-title">
                                                <a class="collapsed" role="button"
                                                   data-toggle="collapse"
                                                   data-parent="#faq-1-accordion" href="#faq-1-q-10"
                                                   aria-expanded="false" aria-controls="faq-1-q-10">
                                                    Modificación de las condiciones generales
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="faq-1-q-10" class="panel-collapse collapse" role="tabpanel">
                                            <div class="panel-body">
                                                Bikebitants se reserva el derecho de modificar, en cualquier momento, la
                                                presentación y configuración de www.bikebitants.com, así como las
                                                presentes Condiciones Generales. Por ello, Bikebitants recomienda al
                                                Cliente leerlas atentamente cada vez que acceda al www.bikebitants.com.
                                                Dichas condiciones generales se encontrarán en todo momento en un sitio
                                                visible, libremente accesible para cuantas consultas quiera realizar. En
                                                cualquier caso, la aceptación de las condiciones generales será un paso
                                                previo e indispensable a la adquisición de cualquier producto disponible
                                                a través de www.bikebitants.com.
                                            </div>
                                        </div>
                                    </div>
                                    <!-- QUESTION - END -->
                                    <!-- QUESTION - START -->
                                    <div class="panel panel-primary">
                                        <div class="panel-heading" role="tab">
                                            <h4 class="panel-title">
                                                <a class="collapsed" role="button"
                                                   data-toggle="collapse"
                                                   data-parent="#faq-1-accordion" href="#faq-1-q-11"
                                                   aria-expanded="false" aria-controls="faq-1-q-11">
                                                    Política de privacidad y protección de datos
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="faq-1-q-11" class="panel-collapse collapse" role="tabpanel">
                                            <div class="panel-body">
                                                De acuerdo a lo establecido en la Ley Orgánica 15/1999, de 13 de
                                                diciembre, de Protección de Datos de Carácter Personal (LOPD), le
                                                informamos de que los datos personales que nos facilite a través de
                                                nuestro Sitio Web o mediante envíos de correos electrónicos, serán
                                                incorporados a un fichero automatizado titularidad de Bikebitants, S.L.,
                                                con domicilio social en c/ Doctor Trueta 112, Bajos 17 08005 Barcelona,
                                                con la finalidad de comunicarse con el usuario, para la facturación
                                                gestión del envío y para enviarle información publicitaria y/o
                                                promocional de los productos y servicios ofrecidos por Bikebitants o por
                                                terceros relacionados con la compraventa de bienes de consumo que pueda
                                                resultar de su interés, consintiendo el Socio expresamente en el envío
                                                de dicha información por cualquier medio, incluidos los electrónicos,
                                                entre otros el correo electrónico.
                                                El usuario que introduzca sus datos personales en los diferentes
                                                formularios de alta, tendrá pleno derecho a ejercitar sus derechos de
                                                acceso, rectificación y cancelación en cualquier momento solicitándolo a
                                                hola@bikebitants.com o por correo ordinario a Bikebitants, S.L. , c/
                                                Primer de Maig 7 , 2º2ª, 08242 Manresa (Barcelona) incluyendo en ambos
                                                casos copia del DNI u otro documento identificativo, del titular de los
                                                datos. Bikebitants reitera que se compromete al respeto y
                                                confidencialidad absoluta en la recogida y tratamiento de los datos
                                                personales de sus usuarios y clientes registrados, declarando su
                                                compromiso a la no cesión a terceros en ningún caso, sin contar con el
                                                previo consentimiento de sus titulares.
                                                El ordenador donde está alojada la web utiliza cookies para mejorar el
                                                servicio prestado por Bikebitants. Estas cookies se instalan
                                                automáticamente en el ordenador empleado por los Socios y Usuarios pero
                                                no almacenan ningún tipo de información relativa a éstos.
                                                <br/><br/>
                                                Todos los navegadores actuales permiten cambiar la configuración de
                                                Cookies. A continuación una pequeña ayuda sobre como actuar en los
                                                navegadores más utilizados.
                                                <br/><br/>
                                                <ul>
                                                    <li>
                                                        Internet Explorer: Herramientas -> Opciones de Internet ->
                                                        Privacidad ->
                                                        Configuración.
                                                        <br/><br/>
                                                        Para más información, puedes consultar el <a
                                                                href="http://windows.microsoft.com/es-ES/windows/support">soporte
                                                            de Microsoft</a> o
                                                        la
                                                        Ayuda del navegador.
                                                    </li>
                                                    <li>
                                                        Firefox: Herramientas -> Opciones -> Privacidad -> Historial ->
                                                        Configuración Personalizada.
                                                        <br/><br/>
                                                        Para más información, puedes consultar el <a
                                                                href="http://support.mozilla.org/es/home">soporte de
                                                            Mozilla</a> o
                                                        la
                                                        Ayuda
                                                        del navegador.
                                                    </li>
                                                    <li>
                                                        Chrome: Configuración -> Mostrar opciones avanzadas ->
                                                        Privacidad ->
                                                        Configuración de contenido.
                                                        <br/><br/>
                                                        Para más información, puedes consultar el <a
                                                                href="http://support.google.com/chrome/?hl=es">soporte
                                                            de Google</a> o la
                                                        Ayuda
                                                        del navegador.
                                                    </li>
                                                    <li>
                                                        Safari: Preferencias -> Seguridad.
                                                        <br/><br/>
                                                        Para más información, puedes consultar el <a
                                                                href="http://www.apple.com/es/support/safari/">soporte
                                                            de Apple</a> o la
                                                        Ayuda
                                                        del navegador.
                                                    </li>
                                                </ul>
                                                Bikebitants se compromete a guardar la máxima reserva y
                                                confidencialidad sobre la información que le sea facilitada y a
                                                utilizarla únicamente para los fines indicados.
                                                <br/><br/>
                                                Bikebitants presume que los datos han sido introducidos por su
                                                titular
                                                o por persona autorizada por éste, así como que son correctos y
                                                exactos.

                                            </div>
                                        </div>
                                    </div>
                                    <!-- QUESTION - END -->

                                </div>

                            </div>
                            <div role="tabpanel" class="tab-pane" id="faq-2">

                                <div class="panel-group" id="faq-2-accordion" role="tablist"
                                     aria-multiselectable="true">

                                    <!-- QUESTION - START -->
                                    <div class="panel panel-primary">
                                        <div class="panel-heading" role="tab">
                                            <h4 class="panel-title">
                                                <a role="button" data-toggle="collapse"
                                                   data-parent="#faq-2-accordion" href="#faq-2-q-1"
                                                   aria-expanded="true" aria-controls="faq-2-q-1">
                                                    Entrega del producto
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="faq-2-q-1" class="panel-collapse collapse in" role="tabpanel">
                                            <div class="panel-body">
                                                Bikebitants se compromete a entregar el producto en perfecto estado en
                                                la dirección que el Cliente señale en el pedido, y que en todo caso
                                                deberá estar comprendida dentro del área de reparto de Bikebitants
                                                especificado en la página web. Con el fin de optimizar la entrega,
                                                agradecemos al Cliente que indique una dirección en la cual el pedido
                                                pueda ser entregado dentro del horario laboral habitual de los servicios
                                                de mensajería.
                                                <br/><br/>
                                                Bikebitants no será responsable por los errores causados en la entrega
                                                cuando la dirección de entrega introducida por el Cliente en el
                                                formulario de pedido no se ajuste a la realidad o hayan sido omitidos.
                                                Los gastos de envío y/o gestión no están comprendidos en el precio y te
                                                serán mostrados antes de finalizar tu compra, en función de la dirección
                                                de envío de cada pedido.
                                                <br/><br/>
                                                Debido a que Bikebitants trabaja con diferentes plataformas logísticas,
                                                hay la posibilidad que un mismo pedido se divida en varias entregas. En
                                                los casos extraordinarios que se de esta circunstancia, Bikebitants ,
                                                mantendrá puntualmente informado al cliente. Una vez el pedido esté
                                                listo ya para su envío, Bikebitants notificará mediante email al cliente
                                                que su pedido está listo para el envío. El cliente podrá ponerse en
                                                contacto con nuestro proveedor de reparto logístico para la gestión de
                                                cualquier incidencia que se derivara del envío. Estos datos, les serán
                                                facilitados en el email que se le enviará cuando el pedido esté listo
                                                para la entrega.
                                            </div>
                                        </div>
                                    </div>
                                    <!-- QUESTION - END -->

                                    <!-- QUESTION - START -->
                                    <div class="panel panel-primary">
                                        <div class="panel-heading" role="tab">
                                            <h4 class="panel-title">
                                                <a class="collapsed" role="button"
                                                   data-toggle="collapse"
                                                   data-parent="#faq-2-accordion" href="#faq-2-q-2"
                                                   aria-expanded="false" aria-controls="faq-2-q-2">
                                                    Plazo de Entrega</a></h4>
                                        </div>
                                        <div id="faq-2-q-2" class="panel-collapse collapse" role="tabpanel">
                                            <div class="panel-body">
                                                En Bikebitants trabajamos para que tu pedido llegue en el menor tiempo
                                                posible. En condiciones normales, el plazo de entrega para los productos
                                                de la tienda será de 1 a 2 días. En todos los casos, en la ficha de
                                                producto se indica de los plazos de entrega para cada pedido.
                                                <br/><br/>
                                                Así, por norma general:
                                                <br/><br/>
                                                En día laborable:
                                                <br/><br/>
                                                Para pedidos antes de las 13:30h, entrega el siguiente día laborable.
                                                <br/><br/>
                                                En fin de semana:
                                                Para pedidos antes del viernes a las 13:30h, entrega el lunes.
                                                Para pedidos después del viernes a las 13:30h, entrega el martes.
                                                <br/><br/>
                                                Para pedidos desde Baleares y Canarias, el tiempo de entrega es de 3 a 4
                                                días
                                            </div>
                                        </div>
                                    </div>
                                    <!-- QUESTION - END -->

                                    <!-- QUESTION - START -->
                                    <div class="panel panel-primary">
                                        <div class="panel-heading" role="tab">
                                            <h4 class="panel-title">
                                                <a class="collapsed" role="button"
                                                   data-toggle="collapse"
                                                   data-parent="#faq-2-accordion" href="#faq-2-q-3"
                                                   aria-expanded="false" aria-controls="faq-2-q-3">
                                                    Datos de Entrega, Entregas no realizadas y Extravío
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="faq-2-q-3" class="panel-collapse collapse" role="tabpanel">
                                            <div class="panel-body">
                                                En el mismo email en el que se informa al Cliente que el producto ha
                                                salido de los almacenes de Bikebitants, se proporciona el número de
                                                envío y el número de atención al cliente de la compañía de transportes
                                                responsable de la entrega, de forma que, en caso que surja cualquier
                                                incidencia en la entrega, el Cliente pueda contactar para resolverla.
                                                <br/><br/>
                                                Bikebitants no se hace responsable de los posibles retrasos ocasionados
                                                por la introducción de datos erróneos en la dirección de entrega por
                                                parte del cliente en el momento de realizar la compra.
                                                <br/><br/>
                                                Si en el momento de la entrega el Cliente se encuentra ausente, el
                                                transportista dejará un comprobante indicando cómo proceder para
                                                concertar una nueva entrega. El cliente se pondrá en contacto con el
                                                servicio de mensajería.
                                                <br/><br/>
                                                Si pasados 7 días hábiles tras la salida a reparto del pedido no se ha
                                                concertado la entrega, el Cliente deberá ponerse en contacto con
                                                Bikebitants. En caso de que el Cliente no proceda así, pasados 10 días
                                                hábiles desde la salida a reparto del pedido éste será devuelto a
                                                nuestros almacenes y el Cliente deberá hacerse cargo de los gastos de
                                                envío y de retorno a origen de la mercancía, así como de los posibles
                                                gastos de gestión asociados.
                                                <br/><br/>
                                                Si el motivo por el que no se ha podido realizar la entrega es el
                                                extravío del paquete, nuestro transportista iniciará una investigación.
                                                En estos casos, los plazos de respuesta de nuestros transportistas
                                                suelen oscilar entre una y tres semanas.
                                            </div>
                                        </div>
                                    </div>
                                    <!-- QUESTION - END -->

                                    <!-- QUESTION - START -->
                                    <div class="panel panel-primary">
                                        <div class="panel-heading" role="tab">
                                            <h4 class="panel-title">
                                                <a class="collapsed" role="button"
                                                   data-toggle="collapse"
                                                   data-parent="#faq-2-accordion" href="#faq-2-q-4"
                                                   aria-expanded="false" aria-controls="faq-2-q-4">
                                                    Diligencia en la entrega
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="faq-2-q-4" class="panel-collapse collapse" role="tabpanel">
                                            <div class="panel-body">
                                                El Cliente deberá comprobar el buen estado del paquete ante el
                                                transportista que, por cuenta de Bikebitants, realice la entrega del
                                                producto solicitado, indicando en el albarán de entrega cualquier
                                                anomalía que pudiera detectar en el embalaje. Si, posteriormente, una
                                                vez revisado el producto, el Cliente detectase cualquier incidencia como
                                                golpe, rotura, indicios de haber sido abierto o cualquier desperfecto
                                                causado en éste por el envío, éste se compromete a comunicarlo a
                                                Bikebitants vía email en el menor plazo de tiempo posible y en un máximo
                                                de 7 hábiles desde la entrega. Se entiende por entrega el momento en que
                                                Bikebitants entrega al cliente el producto comprado.

                                            </div>
                                        </div>
                                    </div>
                                    <!-- QUESTION - END -->

                                </div>

                            </div>
                            <div role="tabpanel" class="tab-pane" id="faq-3">

                                <div class="panel-group" id="faq-3-accordion" role="tablist"
                                     aria-multiselectable="true">

                                    <!-- QUESTION - START -->
                                    <div class="panel panel-primary">
                                        <div class="panel-heading" role="tab">
                                            <h4 class="panel-title">
                                                <a role="button" data-toggle="collapse"
                                                   data-parent="#faq-3-accordion" href="#faq-3-q-1"
                                                   aria-expanded="true" aria-controls="faq-3-q-1">
                                                    Devolución por producto defectuoso
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="faq-3-q-1" class="panel-collapse collapse in" role="tabpanel">
                                            <div class="panel-body">
                                                Una devolución por producto defectuoso es aquella que se produce porque
                                                el producto está en mal estado y tiene un defecto de fabricación. En
                                                ningún caso se aceptará una devolución de productos usados o que estén
                                                en un mal estado como consecuencia de su uso.
                                                <br/><br/>
                                                La devolución solo será aceptada en los 30 días posteriores a la entrega
                                                del producto.
                                                <br/><br/>
                                                El protocolo de actuación para devolver un producto defectuoso es el
                                                siguiente:
                                                1) En la medida de lo posible debes de enviarlo con el embalaje original
                                                que te llegó el producto. Una vez cumplidas estas condiciones tienes que
                                                enviar un email a hola@bikebitants.com indicando número de albarán,
                                                motivos de devolución y producto a devolver.<br/>
                                                2) Debe incluirse una copia del albarán de entrega dentro del paquete,
                                                donde además se indiquen los productos devueltos y el motivo de la
                                                devolución.<br/>
                                                <br/>
                                                Desde Bikebitants, nos pondremos en contacto contigo para que acuerdes
                                                una hora con nuestro distribuidor logístico para venir a recoger el
                                                producto a devolver.
                                                <br/><br/>
                                                Una vez devuelto el producto, cuando llegue a Bikebitants, examinaremos
                                                que cumple las condiciones de devolución arriba detalladas y si todo es
                                                correcto procederemos a abonarte en tu tarjeta de crédito o cuenta
                                                paypal el importe de la compra. En este caso, el coste de transporte
                                                correrá a cargo del coste del operador logístico que te vino a recoger
                                                el artículo.<br/><br/>
                                                Cuando nos devuelvas el producto, no olvides de incluir el producto con
                                                todo su embalaje original y el albarán de compra.

                                            </div>
                                        </div>
                                    </div>
                                    <!-- QUESTION - END -->

                                    <!-- QUESTION - START -->
                                    <div class="panel panel-primary">
                                        <div class="panel-heading" role="tab">
                                            <h4 class="panel-title"><a class="collapsed" role="button"
                                                                       data-toggle="collapse"
                                                                       data-parent="#faq-3-accordion" href="#faq-3-q-2"
                                                                       aria-expanded="false" aria-controls="faq-3-q-2">Devolución
                                                    voluntaria</a></h4>
                                        </div>
                                        <div id="faq-3-q-2" class="panel-collapse collapse" role="tabpanel">
                                            <div class="panel-body">
                                                Una devolución voluntaria es aquella en que simplemente el producto no
                                                te gusta o no te convence y quieres devolverlo. Las condiciones para
                                                devolver un producto son las siguientes:
                                                <br/><br/>
                                                1) La devolución solo será aceptada en los 30 días posteriores a la
                                                entrega del producto.<br/>
                                                2) El producto debe estar en el mismo estado en que se entregó y deberá
                                                conservar, en la medida de lo posible, su embalaje y etiquetado
                                                original. En ningún caso aceptaremos un producto que haya sido usado por
                                                el cliente.<br/>
                                                3) El envío debe hacerse usando la misma caja o sobre que te hemos
                                                enviado, o en su defecto en algún formato similar que garantice la
                                                devolución en perfecto estado.<br/>
                                                4) Debe incluirse una copia del albarán de entrega dentro del paquete,
                                                en donde se indiquen los productos devueltos y el motivo de la
                                                devolución.<br/>
                                                <br/><br/>
                                                Una vez cumplidas estas condiciones tienes que enviar un email a
                                                hola@bikebitants.com indicando, número de albarán, motivos de devolución
                                                y producto de devolución.<br/>
                                                Desde Bikebitants, nos pondremos en contacto contigo para que acuerdes
                                                una hora con nuestro distribuidor logístico para que venga a recogerte
                                                el producto a devolver.<br/>
                                                Una vez devuelto el producto, cuando llegue a Bikebitants, examinaremos
                                                que cumple las condiciones de devolución arriba detalladas y si todo es
                                                correcto procederemos a abonarte en tu tarjeta de crédito o cuenta
                                                paypal el importe de la compra, exceptuando el coste del operador
                                                logístico para venir a recogerte el producto que es de 10€.

                                            </div>
                                        </div>
                                    </div>
                                    <!-- QUESTION - END -->

                                    <!-- QUESTION - START -->
                                    <div class="panel panel-primary">
                                        <div class="panel-heading" role="tab">
                                            <h4 class="panel-title"><a class="collapsed" role="button"
                                                                       data-toggle="collapse"
                                                                       data-parent="#faq-3-accordion" href="#faq-3-q-3"
                                                                       aria-expanded="false" aria-controls="faq-3-q-3">Anulación de pedidos</a></h4>
                                        </div>
                                        <div id="faq-3-q-3" class="panel-collapse collapse" role="tabpanel">
                                            <div class="panel-body">
                                                Bikebitants no aceptará anulaciones si el producto ya se encuentra en la fase de logística y por motivos operativos no es posible detener el proceso de entrega.
                                            </div>
                                        </div>
                                    </div>
                                    <!-- QUESTION - END -->

                                    <!-- QUESTION - START -->
                                    <div class="panel panel-primary">
                                        <div class="panel-heading" role="tab">
                                            <h4 class="panel-title"><a class="collapsed" role="button"
                                                                       data-toggle="collapse"
                                                                       data-parent="#faq-3-accordion" href="#faq-3-q-4"
                                                                       aria-expanded="false" aria-controls="faq-3-q-4">Cambios</a></h4>
                                        </div>
                                        <div id="faq-3-q-4" class="panel-collapse collapse" role="tabpanel">
                                            <div class="panel-body">
                                                Una cambio es aquel en que simplemente el producto recibido no te gusta o no te convence y necesitas cambiarlo por otro de mismo importe pero diferente talla, color o otra característica. Las condiciones para cambiar un producto son las siguientes:
                                                <br /><br />
                                                1) El cambio solo será aceptado en los 30 días posteriores a la entrega del producto.<br />
                                                2) El producto debe estar en el mismo estado en que se entregó y deberá conservar, en la medida de lo posible, su embalaje y etiquetado original. En ningún caso aceptaremos un producto que haya sido usado por el cliente.<br />
                                                3) El envío debe hacerse usando la misma caja o sobre que te hemos enviado, o en su defecto en algún formato similar que garantice la devolución en perfecto estado.<br />
                                                4) Debe incluirse una copia del albarán de entrega dentro del paquete, en donde se indiquen los productos devueltos y el motivo de la devolución.<br />
                                                <br /><br />
                                                Una vez cumplidas estas condiciones tienes que enviar un email a hola@bikebitants.com indicando, número de albarán, motivos del cambio y producto a cambiar.<br />
                                                Desde Bikebitants, nos pondremos en contacto contigo para que acuerdes una hora con nuestro distribuidor logístico para que venga a recogerte el producto a cambiar.<br />
                                                Una vez devuelto el producto, cuando llegue a Bikebitants, examinaremos que cumple las condiciones de devolución arriba detalladas y si todo es correcto procederemos a tramitar el nuevo pedido con el producto solicitado para el cambio.

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