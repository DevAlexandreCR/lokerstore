@extends('admin.home')

@section('main')
    @if ( $errors->any() )

        @foreach ($errors->all() as $error)
            <div class="container align-self-start col-4 py-2">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only">Close</span>
                    </button>
                    <strong>{{__('Error!')}}</strong> {{ $error }}
                </div>
            </div>
        @endforeach

    @endif
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
                        <table class="table">
                            <thead>
                            <tr>
                                <th>{{__('Name')}}:</th>
                                <td class="text-right">{{$order->user->name}}</td>
                            </tr>
                            <tr>
                                <th>{{__('Email')}}:</th>
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
                                <th>{{__('Stock')}}</th>
                                <th>{{__('Price')}}</th>
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
                                                <button @if($order->status !== \App\Constants\Orders::STATUS_PENDING_PAY)
                                                            disabled
                                                        @endif
                                                        type="submit" class="btn btn-sm btn-danger mx-2">
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
                                <strong>{{__('Amount')}}: </strong> {{$order->getAmount()}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header"><h5>{{__('Update order')}}</h5></div>
                    <form action="{{route('orders.update', $order->id)}}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            @if($order->status === \App\Constants\Orders::STATUS_PENDING_PAY || $order->status === \App\Constants\Orders::STATUS_REJECTED)
                                <div class="form-group">
                                    <label for="amount">{{__('Price')}}</label>
                                    <input class="form-control" type="number" id="amount" name="amount" value="{{$order->amount}}">
                                </div>
                            @endif
                                <label for="status">{{__('Status')}}</label>
                                <select name="status" class="form-control mb-2">
                                    @foreach($order->getAllStatus() as $key => $value)
                                        <option value="{{$key}}" @if($order->status === $key) selected @endif>{{$value}}</option>
                                    @endforeach
                                </select>
                            @if($order->status === 'pending_pay')
                                <a href="{{route('orders.verify', $order->id)}}" class="btn btn-block btn-sm btn-dark">{{__('Verify payment')}}</a>
                            @endif
                        </div>
                        <div class="card-footer text-center">
                            <button type="submit" class="btn btn-primary btn-sm">{{__('Save')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @if($order->status === 'pending_shipment' || $order->status === 'sent' || $order->status === 'canceled')
            <div class="row my-2">
                <div class="container">
                    <div class="card">
                        <div class="card-header"><h5>{{__('Payment')}}</h5></div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h6>{{__('Payer data')}}</h6>
                                    @if($order->payment->payer)
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
                                    @endif
                                </div>
                                <div class="col">
                                    <h6>{{__('Status')}}</h6>
                                    @switch($order->payment->status)
                                        @case('FAILED')
                                        <p><small>{{session('message')}}</small></p>
                                        <p><small>{{__('Payment has failed, please retry')}}</small></p>
                                        @break
                                        @case('PENDING')
                                        <p>{{$order->getStatus()}}</p>
                                        <form action="{{route('orders.verify', $order->id)}}" method="get">
                                            @csrf
                                            <button type="submit" class="btn btn-block btn-sm btn-dark">{{__('Verify payment')}}</button>
                                        </form>
                                        @break
                                        @case('APPROVED')
                                        <br>
                                        <form action="{{route('orders.reverse', $order->id)}}" method="get">
                                            @csrf
                                            <button type="submit" class="btn btn-block btn-sm btn-danger">{{__('Cancel Purchase')}}</button>
                                        </form>
                                        @break
                                        @case('REJECTED')
                                        <p><small>{{__('Payment has been rejected')}}</small></p>
                                        @break
                                    @endswitch
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

