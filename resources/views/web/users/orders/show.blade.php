@extends('web.users.main')

@section('user-main')
    <div class="container py-4">
        @if ( session('error'))
            <div class="container py-2">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only">Close</span>
                    </button>
                    <strong>{{trans('actions.error')}}</strong> {{ trans(session('error')) }}
                </div>
            </div>
        @endif
        @if ( session('message'))
            <div class="container py-2">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only">Close</span>
                    </button>
                    <strong>{{trans('actions.success')}}</strong> {{ trans(session('message')) }}
                </div>
            </div>
        @endif
    </div>
    <div class="container py-4">
        <div class="row">
            <div class="col-lg-8">
                <div class="card card">
                    <div class="modal-header">
                        <h3>{{trans('orders.summary')}}</h3>
                        <small class="text-muted">{{$order->created_at}}</small>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless table-responsive-lg">
                            <thead>
                            <tr class="text-center">
                                <th scope="col">{{trans('users.phone')}}</th>
                                <th scope="col">{{trans_choice('products.product', 2, ['product_count' => ''])}}</th>
                                <th scope="col">{{trans('products.stock')}}</th>
                                <th scope="col">{{trans('products.color')}}</th>
                                <th scope="col">{{trans('products.size')}}</th>
                                <th scope="col">{{trans('products.price')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($order->orderDetails as $detail)
                            <tr class="text-center">
                                <th><img class="img-table-mini" src="/photos/{{$detail->stock->product->photos[0]->name}}"></th>
                                <th class="align-middle">{{$detail->stock->product->name}}</th>
                                <th class="align-middle">{{$detail->quantity}}</th>
                                <th class="align-middle"><span class="badge badge-color-{{strtolower($detail->stock->color->name)}}">.</span></th>
                                <th class="align-middle">{{$detail->stock->size->name}}</th>
                                <th class="align-middle">$ {{number_format($detail->total_price, 2, ',', '.')}}</th>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <div class="row text-right">
                            <div class="col-sm-9">
                                {{trans('orders.amount')}}:
                            </div>
                            <div class="col-sm-3 font-weight-bold">
                                $ {{number_format($order->amount, 2, ',', '.')}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card my-2 my-lg-0">
                    <div class="card-header">
                        {{\App\Constants\Orders::getTranslatedStatus($order->status)}}
                    </div>
                    <div class="card-body">
                        <x-status-payment :order="$order"/>
                    </div>
                    <div class="card-footer">
                        <a href="{{route('user.orders.index', [$order->user_id])}}" class="btn btn-block btn-sm btn-outline-dark my-2">{{trans('actions.back')}}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
