@extends('web.users.main')

@section('user-main')
    <div class="container py-4">
        <div class="modal-header"><h3>{{__('Orders')}}</h3></div>
            <div class="list-group">
                @forelse($orders as $order)
                    <div class="list-group-item my-2">
                        <div class="row font-weight-bold py-2">
                            <div class="col-sm-3">{{__('Order created at')}}</div>
                            <div class="col-sm-3">{{__('Status')}}</div>
                            <div class="col-sm-3">{{__('Amount')}}</div>
                            <div class="col-sm-3 text-center">{{__('Details')}}</div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3">{{$order->created_at}}</div>
                            <div class="col-sm-3">{{$order->getStatus()}}</div>
                            <div class="col-sm-3">
                                {{$order->amount}}
                            </div>
                            <div class="col-sm-3 text-center">
                                <div class="btn btn-group">
                                    <a href="{{route('user.order.show', [$order->user_id, $order->id])}}" class="btn btn-sm btn-outline-success"><ion-icon name="eye"></ion-icon></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="container w-50">
                        <empty-orders-component></empty-orders-component>
                    </div>
                @endforelse
            </div>
    </div>

@endsection
