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
                    <strong>{{__('Error!')}}</strong> {{ __(session('error')) }}
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
                    <strong>{{__('Success!')}}</strong> {{ __(session('message')) }}
                </div>
            </div>
        @endif
    </div>
    <div class="container py-4">
        <div class="row">
            <div class="col-sm-8">
                <div class="card card">
                    <div class="modal-header">
                        <h3>{{__('Order summary')}}</h3>
                        <small class="text-muted">{{$order->created_at}}</small>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless">
                            <thead>
                            <tr class="text-center">
                                <th scope="col">{{__('Photo')}}</th>
                                <th scope="col">{{__('Product')}}</th>
                                <th scope="col">{{__('Stock')}}</th>
                                <th scope="col">{{__('Color')}}</th>
                                <th scope="col">{{__('Size')}}</th>
                                <th scope="col">{{__('Price')}}</th>
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
                                <th class="align-middle">{{$detail->total_price}}</th>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <div class="row text-right">
                            <div class="col-sm-9">
                                {{__('Order amount')}}:
                            </div>
                            <div class="col-sm-3 font-weight-bold">
                                {{$order->amount}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-header">
                        {{$order->getStatus()}}
                    </div>
                    <div class="card-body">
                        <x-statusPayment :order="$order"></x-statusPayment>
                    </div>
                    <div class="card-footer">
                        <a href="{{route('user.orders.index', [$order->user_id])}}" class="btn btn-block btn-sm btn-outline-dark my-2">{{__('Back')}}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
