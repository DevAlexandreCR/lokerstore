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
            <div class="col-sm-7">
                <div class="card card">
                    <div class="modal-header">
                        <h3>{{__('Order summary')}}</h3>
                        <small class="text-muted">{{$order->created_at}}</small>
                    </div>
                    <div class="card-body">
                        <div class="row font-weight-bold py-2">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-4">{{__('Product')}}</div>
                            <div class="col-sm-3">{{__('Stock')}}</div>
                            <div class="col-sm-3 text-right">{{__('Price')}}</div>
                        </div>
                        @foreach($order->orderDetails as $detail)
                        <div class="row">
                            <div class="col-sm-2">
                                <img class="img-fluid" src="/photos/{{$detail->product->photos[0]->name}}">
                            </div>
                            <div class="col-sm-4">{{$detail->product->name}}</div>
                            <div class="col-sm-3">{{$detail->quantity}}</div>
                            <div class="col-sm-3 text-right">
                                {{$detail->product->getPrice()}}
                            </div>
                        </div>
                        @endforeach
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
            <div class="col-sm-5">
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
