@component('mail::message')
# {{trans('messages.hello')}} {{$order->user->name}}

{{trans('payment.messages.pay_accepted')}}

@component('mail::button', ['url' => route('user.order.show', [$order->user_id, $order->id])])
{{trans('orders.view')}}
@endcomponent

{{trans('messages.thanks')}}<br>
{{ config('app.name') }}
@endcomponent
