<div>
    @switch($order->status)
        @case('failed')
            <p><small>{{session('message')}}</small></p>
            <p><small>{{trans('payment.messages.failed')}}</small></p>
            <form action="{{route('user.order.resend', $order->user_id)}}" method="post">
                @csrf
                <input type="hidden" name="order_id" value="{{$order->id}}">
                <button type="submit" class="btn btn-block btn-sm btn-success">{{trans('payment.retry')}}</button>
            </form>
        @break
        @case('pending_pay')
            <p><small>{{trans('payment.messages.pending')}}</small></p>
            <form action="{{route('user.order.status', $order->user_id)}}" method="post">
                @csrf
                <input type="hidden" name="order_id" value="{{$order->id}}">
                <button type="submit" class="btn btn-block btn-sm btn-dark">{{trans('payment.verify')}}</button>
            </form>
            <p><small>{{trans('payment.messages.retry_again')}}</small></p>
                <a class="btn btn-success btn-sm btn-block" href="{{$order->payment->process_url}}">{{trans('payment.retry')}}</a>
                <form action="{{route('user.order.reverse', $order->user_id)}}" method="post">
                    @csrf
                    <input type="hidden" name="order_id" value="{{$order->id}}">
                    <button type="submit" class="btn btn-block btn-sm btn-danger my-4">{{trans('payment.cancel')}}</button>
                </form>
        @break
        @case('pending_shipment')
            <p><small>{{trans('payment.messages.preparing')}}</small></p>
                <h3>{{trans('payer.data')}}</h3>
                <div class="row row-cols-2">
                    <div class="col-sm-6 text-muted text-left">
                        {{trans('users.full_name')}}
                    </div>
                    <div class="col-sm-6 text-muted text-left">
                        {{$order->payment->payer->getFullName()}}
                    </div>
                </div>
                <div class="row row-cols-2">
                    <div class="col-sm-6 text-muted text-left">
                        {{trans('payer.document')}}
                    </div>
                    <div class="col-sm-6 text-muted text-left">
                        {{$order->payment->payer->document_type}} : {{$order->payment->payer->document}}
                    </div>
                </div>
                <div class="row row-cols-2">
                    <div class="col-sm-6 text-muted text-left">
                        {{trans('users.email')}}
                    </div>
                    <div class="col-sm-6 text-muted text-left">
                        {{$order->payment->payer->email}}
                    </div>
                </div>
                <div class="row row-cols-2">
                    <div class="col-sm-6 text-muted text-left">
                        {{trans('users.phone')}}
                    </div>
                    <div class="col-sm-6 text-muted text-left">
                        {{$order->payment->payer->phone}}
                    </div>
                </div>
                <div class="row row-cols-2">
                    <div class="col-sm-6 text-muted text-left">
                        {{trans('payment.method')}}
                    </div>
                    <div class="col-sm-6 text-muted text-left">
                        {{$order->payment->method}}
                    </div>
                </div>
                <div class="row row-cols-2">
                    <div class="col-sm-6 text-muted text-left">
                        {{trans('products.reference')}}
                    </div>
                    <div class="col-sm-6 text-muted text-left">
                        {{$order->payment->reference}}
                    </div>
                </div>
                <div class="row row-cols-2">
                    <div class="col-sm-6 text-muted text-left">
                        {{trans('payment.last_digit')}}
                    </div>
                    <div class="col-sm-6 text-muted text-left">
                        {{$order->payment->last_digit}}
                    </div>
                </div>
                <hr>
            <form action="{{route('user.order.reverse', $order->user_id)}}" method="post">
                @csrf
                <input type="hidden" name="order_id" value="{{$order->id}}">
                <button type="submit" class="btn btn-block btn-sm btn-danger">{{trans('payment.cancel')}}</button>
            </form>
        @break
        @case('sent')
            <p><small>{{trans('payment.messages.shipped')}}</small></p>
        @break
        @case('rejected')
            <p><small>{{trans('payment.messages.rejected')}}</small></p>
            <form action="{{route('user.order.resend', $order->user_id)}}" method="post">
                @csrf
                <input type="hidden" name="order_id" value="{{$order->id}}">
                <button type="submit" class="btn btn-block btn-sm btn-success">{{trans('payment.retry')}}</button>
            </form>
        @break
        @case('completed')
            <p><small>{{trans('orders.statuses.completed')}}</small></p>
        @break
        @case('canceled')
            <p><small>{{trans('orders.statuses.canceled')}}</small></p>
            @if($order->payment->payer)
                <div class="row row-cols-2">
                    <div class="col-sm-6 text-muted text-left">
                        {{trans('payment.messages.back')}}
                    </div>
                    <div class="col-sm-6 text-muted text-left">
                        {{$order->amount}}
                    </div>
                </div>
            <div class="row row-cols-2">
                <div class="col-sm-6 text-muted text-left">
                    {{trans('payment.method')}}
                </div>
                <div class="col-sm-6 text-muted text-left">
                    {{$order->payment->method}}
                </div>
            </div>
            <div class="row row-cols-2">
                <div class="col-sm-6 text-muted text-left">
                    {{trans('products.reference')}}
                </div>
                <div class="col-sm-6 text-muted text-left">
                    {{$order->payment->reference}}
                </div>
            </div>
            <div class="row row-cols-2">
                <div class="col-sm-6 text-muted text-left">
                    {{trans('payment.last_digit')}}
                </div>
                <div class="col-sm-6 text-muted text-left">
                    {{$order->payment->last_digit}}
                </div>
            </div>
            @endif
        @break
    @endswitch
</div>
