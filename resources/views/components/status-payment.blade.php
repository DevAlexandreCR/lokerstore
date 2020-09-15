<div>
    @switch($order->status)
        @case('failed')
            <p><small>{{session('message')}}</small></p>
            <p><small>{{__('Payment has failed, please retry')}}</small></p>
            <form action="{{route('user.order.resend', $order->user_id)}}" method="post">
                @csrf
                <input type="hidden" name="order_id" value="{{$order->id}}">
                <button type="submit" class="btn btn-block btn-sm btn-success">{{__('Retry payment')}}</button>
            </form>
        @break
        @case('pending_pay')
            <p><small>{{__('Payments may take a few minutes to be approved, if you have already paid please check later')}}</small></p>
            <form action="{{route('user.order.status', $order->user_id)}}" method="post">
                @csrf
                <input type="hidden" name="order_id" value="{{$order->id}}">
                <button type="submit" class="btn btn-block btn-sm btn-dark">{{__('Verify payment')}}</button>
            </form>
            <p><small>{{__('Or you can retry the payment again')}}</small></p>
                <a class="btn btn-success btn-sm btn-block" href="{{$order->payment->process_url}}">{{__('Retry payment')}}</a>
                <form action="{{route('user.order.reverse', $order->user_id)}}" method="post">
                    @csrf
                    <input type="hidden" name="order_id" value="{{$order->id}}">
                    <button type="submit" class="btn btn-block btn-sm btn-danger my-4">{{__('Cancel Purchase')}}</button>
                </form>
        @break
        @case('pending_shipment')
            <p><small>{{__('We are preparing your order, usually this takes one to two working days')}}</small></p>
                <h3>{{__('Payer data')}}</h3>
                <div class="row row-cols-2">
                    <div class="col-sm-6 text-muted text-left">
                        {{__('Name')}}
                    </div>
                    <div class="col-sm-6 text-muted text-left">
                        {{$order->payment->payer->getFullName()}}
                    </div>
                </div>
                <div class="row row-cols-2">
                    <div class="col-sm-6 text-muted text-left">
                        {{__('Document')}}
                    </div>
                    <div class="col-sm-6 text-muted text-left">
                        {{$order->payment->payer->document_type}} : {{$order->payment->payer->document}}
                    </div>
                </div>
                <div class="row row-cols-2">
                    <div class="col-sm-6 text-muted text-left">
                        {{__('Email')}}
                    </div>
                    <div class="col-sm-6 text-muted text-left">
                        {{$order->payment->payer->email}}
                    </div>
                </div>
                <div class="row row-cols-2">
                    <div class="col-sm-6 text-muted text-left">
                        {{__('Phone')}}
                    </div>
                    <div class="col-sm-6 text-muted text-left">
                        {{$order->payment->payer->phone}}
                    </div>
                </div>
                <div class="row row-cols-2">
                    <div class="col-sm-6 text-muted text-left">
                        {{__('Payment method')}}
                    </div>
                    <div class="col-sm-6 text-muted text-left">
                        {{$order->payment->method}}
                    </div>
                </div>
                <div class="row row-cols-2">
                    <div class="col-sm-6 text-muted text-left">
                        {{__('Last digit')}}
                    </div>
                    <div class="col-sm-6 text-muted text-left">
                        {{$order->payment->last_digit}}
                    </div>
                </div>
                <hr>
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
            <p><small class="text-muted">{{__('Order has been canceled success')}}</small></p>
            @if($order->payment->payer)
                <div class="row row-cols-2">
                    <div class="col-sm-6 text-muted text-left">
                        {{__('We give you back')}}
                    </div>
                    <div class="col-sm-6 text-muted text-left">
                        {{$order->amount}}
                    </div>
                </div>
            <div class="row row-cols-2">
                <div class="col-sm-6 text-muted text-left">
                    {{__('Payment method')}}
                </div>
                <div class="col-sm-6 text-muted text-left">
                    {{$order->payment->method}}
                </div>
            </div>
            <div class="row row-cols-2">
                <div class="col-sm-6 text-muted text-left">
                    {{__('Last digit')}}
                </div>
                <div class="col-sm-6 text-muted text-left">
                    {{$order->payment->last_digit}}
                </div>
            </div>
            @endif
        @break
    @endswitch
</div>
