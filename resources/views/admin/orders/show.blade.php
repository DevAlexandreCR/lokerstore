@extends('admin.home')

@section('main')
    <div class="container py-4">
        @if (session('success'))
            <div class="container py-2">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only">Close</span>
                    </button>
                    <strong>{{__('Success!')}}</strong> {{ session('success') }}
                </div>
            </div>
        @endif
    </div>
    <div class="container-fluid my-2">
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header"><h5>{{__('User data')}}</h5></div>
                    <div class="card-body">
                        <table class="table table-responsive">
                            <thead>
                            <tr>
                                <th>{{__('Name')}}:</th>
                                <td class="text-right">{{$order->user->name}}</td>
                            </tr>
                            <tr>
                                <th>{{__('Email Address')}}:</th>
                                <td class="text-right">{{$order->user->email}}</td>
                            </tr>
                            <tr>
                                <th>{{__('Phone')}}:</th>
                                <td class="text-right">{{$order->user->phone}}</td>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header"><h5>{{__('Order details')}}</h5></div>
                    <div class="card-body">
                        <table class="table table-hover table-sm">
                            <thead>
                            <tr class="text-left">
                                <th>{{__('Id')}}</th>
                                <th>{{__('Product')}}</th>
                                <th>{{__('Quantity')}}</th>
                                <th>{{__('Unit price')}}</th>
                                <th>{{__('Amount')}}</th>
                                <th>{{__('Actions')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($order->orderDetails as $detail)
                                <tr>
                                    <td>{{$detail->id}}</td>
                                    <td>{{$detail->stock->product->name}}</td>
                                    <td>{{$detail->quantity}}</td>
                                    <td>{{$detail->unit_price}}</td>
                                    <td>{{$detail->total_price}}</td>
                                    <td>
                                        <div class="btn-group btn-block btn-group-sm text-center">
                                            <form action="{{route('order_details.destroy', $detail->id)}}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger mx-2">
                                                    <ion-icon name="trash"></ion-icon>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <hr>
                        <div class="row justify-content-end">
                            <div class="col-md-3">
                                <strong>{{__('Amount')}}: </strong> {{$order->amount}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <h5>{{__('Order details')}}</h5>
            </div>
        </div>
    </div>
@endsection
