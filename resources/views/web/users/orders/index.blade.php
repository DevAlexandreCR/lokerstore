@extends('web.users.main')

@section('user-main')
    <div class="container py-4">
        <div class="modal-header"><h3>{{__('Orders')}}</h3></div>
            <div class="container justify-content-center">
                <table class="table table-borderless table-responsive-sm table-sm table-secondary">
                    <thead>
                        <tr>
                            <th>{{__('Order created at')}}</th>
                            <th>{{__('Status')}}</th>
                            <th>{{__('Amount')}}</th>
                            <th class="text-center">{{__('Details')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            <tr>
                                <td>{{$order->created_at}}</td>
                                <td>{{$order->getStatus()}}</td>
                                <td>
                                    {{$order->amount}}
                                </td>
                                <td class="text-center">
                                    <div class="btn btn-group">
                                        <a href="{{route('user.order.show', [$order->user_id, $order->id])}}" class="btn btn-sm btn-outline-success"><ion-icon name="eye"></ion-icon></a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                                <div class="container w-50">
                                    <empty-orders-component></empty-orders-component>
                                </div>
                        @endforelse
                    </tbody>
                </table>
            </div>
    </div>

@endsection
