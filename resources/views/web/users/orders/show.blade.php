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
    </div>
    <div class="container py-4">
        <div class="row">
            <div class="col-sm-7">
                <div class="card card">
                    <div class="card-header">
                        <h3>{{__('Order summary')}}</h3>
                    </div>
                    <div class="card-body">
                        <div class="row font-weight-bold py-2">
                            <div class="col-sm-4">{{__('Product')}}</div>
                            <div class="col-sm-4">{{__('Stock')}}</div>
                            <div class="col-sm-4 text-right">{{__('Price')}}</div>
                        </div>
                        @foreach($order->orderDetails as $detail)
                        <div class="row">
                            <div class="col-sm-4">{{$detail->product->name}}</div>
                            <div class="col-sm-4">{{$detail->quantity}}</div>
                            <div class="col-sm-4 text-right">
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

            </div>
        </div>

    </div>
@endsection
