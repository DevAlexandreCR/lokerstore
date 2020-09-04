<div>
    @switch($order->status)
        @case('pending_pay')
            <p><small>{{__('Payments may take a few minutes to be approved, if you have already paid please check later')}}</small></p>
            <form action="{{route('user.order.status', $order->user_id)}}" method="post">
                @csrf
                <input type="hidden" name="order_id" value="{{$order->id}}">
                <button type="submit" class="btn btn-block btn-sm btn-dark">{{__('Verify payment')}}</button>
            </form>
            <p><small>{{__('Or you can retry the payment again')}}</small></p>
            <a class="btn btn-success btn-sm btn-block" href="{{$order->payment->process_url}}">{{__('Retry payment')}}</a>
        @break
        @case('pending_shipment')
            <p><small>{{__('We are preparing your order, usually this takes one to two working days')}}</small></p>
            <form action="{{route('user.order.reverse', $order->user_id)}}" method="post">
                @csrf
                <input type="hidden" name="order_id" value="{{$order->id}}">
                <button type="submit" class="btn btn-block btn-sm btn-danger">{{__('Cancel Purchase')}}</button>
            </form>
        @break
        @case('sent')
        <p><small>{{__('Your order has been shipped')}}</small></p>
        @break
        @case('rejected')
            <p><small>{{__('Your transaction  has been declined, you can try another payment method')}}</small></p>
            <form action="{{route('user.order.resend', $order->user_id)}}" method="post">
                @csrf
                <input type="hidden" name="order_id" value="{{$order->id}}">
                <button type="submit" class="btn btn-block btn-sm btn-success">{{__('Retry payment')}}</button>
            </form>
        @break
        @case('complete')
        <p><small>{{__('Buy completed')}}</small></p>
        <form action="{{route('user.order.status', $order->user_id)}}" method="post">d
            @csrf
            <input type="hidden" name="order_id" value="{{$order->id}}">
            <button type="submit" class="btn btn-block btn-sm btn-success">{{__('Buy again')}}</button>
        </form>
        @break
        @case('canceled')
        <p><small>{{__('Buy canceled')}}</small></p>
        <p><small class="text-muted">{{__('Your order has been canceled')}}</small></p>
        @break
    @endswitch
</div>
