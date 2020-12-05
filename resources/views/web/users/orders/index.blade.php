@extends('web.users.main')

@section('user-main')
    <div class="container py-4">
        <div class="modal-header"><h3>{{trans_choice('orders.orders', 2, ['orders_count' => ''])}}</h3></div>
            <div class="container justify-content-center">
                <table class="table table-borderless table-responsive-sm table-sm table-secondary">
                    <thead>
                        <tr>
                            <th>{{trans_choice('orders.orders', 1, ['orders_count' => '']) .
                            trans('fields.created_at')}}</th>
                            <th>{{trans('fields.status')}}</th>
                            <th>{{trans('orders.amount')}}</th>
                            <th class="text-center">{{trans('orders.details')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            <tr>
                                <td>{{$order->created_at}}</td>
                                <td>{{\App\Constants\Orders::getTranslatedStatus($order->status)}}</td>
                                <td>
                                    $ {{number_format($order->amount, 2, ',', '.')}}
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
