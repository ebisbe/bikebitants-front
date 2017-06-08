@component('mail::message')
Buenos días,

Nos ha entrado un nuevo pedido:
@component('mail::table')
| Articulo      | Cantidad     |
| ------------- |:-------------:|
@foreach($items as $item)
| {{ $item['name'] }} <br> {{ $item['attributes'] }} | {{ $item['quantity'] }} |

@endforeach
@endcomponent

@component('mail::panel')
Al ser un envío contrareembolso nuestra mensajería pasará a recoger el producto. Adjunto etiqueta para pegar en el paquete.
@endcomponent


Si hubiera algún problema, no dudes en contactarme.<br>
Gracias!<br>
{{ config('app.name') }}

Miguel | Bikebitants.com <br>
T: (+34) 696603741
@endcomponent