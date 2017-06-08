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
<strong>Dirección de envío</strong><br>
Nombre: {{ $to_address['full_name']}}<br>
Nº Teléfono: {{ $to_address['phone'] }}<br>
Dirección: {{ $to_address['address'] }}<br>
Ciudad: {{ $to_address['city'] }}<br>
Código postal: {{ $to_address['postcode'] }}<br>
@endcomponent

Agradecería confirmación sobre el envío.<br>
Gracias!<br>
{{ config('app.name') }}

Miguel | Bikebitants.com <br>
: (+34) 696603741
@endcomponent