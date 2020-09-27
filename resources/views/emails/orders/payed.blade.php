@component('mail::message')
# Hola {{$order->user->name}}

Tu pago ha sido aceptado

@component('mail::button', ['url' => route('user.order.show', [$order->user_id, $order->id])])
Ver pedido
@endcomponent

Gracias por comprar en nuestra tienda,<br>
{{ config('app.name') }}
@endcomponent
