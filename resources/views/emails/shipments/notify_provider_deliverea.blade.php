@component('mail::message')
Buenos días,

Nos ha entrado un nuevo pedido:
@component('mail::table')
    | Articulo      | Cantidad     |
    | ------------- |:-------------:|
    @foreach($items as $item)
        | {{ $item->get('name') }} <br> {{ $item->get('attributes') }}     | {{ $item->get('quantity') }}             |
    @endforeach
@endcomponent

@component('mail::panel')
    Nuestra mensajería pasará a recoger el producto. Adjunto etiqueta para pegar en el paquete.
@endcomponent


Si hubiera algún problema, no dudes en contactarme.<br>
Gracias!<br>
{{ config('app.name') }}

Miguel | Bikebitants.com <br>
T: (+34) 696603741
@endcomponent