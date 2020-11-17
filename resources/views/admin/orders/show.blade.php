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
            @if($order->user)
                <div class="col-xl-3">
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
            @endif
            <div class="@if($order->user) col-xl-6 @else col-xl-9 @endif">
                @if($order->status === 'pending_shipment' || $order->status === 'sent' || optional($order->payment)->payer)
                    <div class="card">
                        <div class="card-header"><h5>{{__('Payment')}}</h5></div>
                        <div class="card-body">
                            <div class="row">
                                <div class="container">
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
                                                {{$order->payment->payer->document_type}}
                                                : {{$order->payment->payer->document}}
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
                            </div>
                        </div>
                    </div>
                @else
                    @include('admin.orders.addPayment')
                @endif
            </div>
            <div class="col-xl-3">
                <div class="card">
                    <div class="card-header"><h5>{{__('Update order')}}</h5></div>
                    <form action="{{route('orders.update', $order->id)}}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            @if($order->status === \App\Constants\Orders::STATUS_PENDING_PAY || $order->status === \App\Constants\Orders::STATUS_REJECTED)
                                <div class="form-group">
                                    <label for="amount">{{__('Price')}}</label>
                                    <input class="form-control" type="number" id="amount" name="amount"
                                           value="{{$order->amount}}">
                                </div>
                            @endif
                            <label for="status">{{__('Status')}}</label>
                            <select name="status" class="form-control mb-2">
                                @foreach($order->getAllStatus() as $key => $value)
                                    <option value="{{$key}}"
                                            @if($order->status === $key) selected @endif>{{$value}}</option>
                                @endforeach
                            </select>
                            @if($order->status === 'pending_pay' && $order->payment && $order->payment->requesId)
                                <a href="{{route('orders.verify', $order->id)}}"
                                   class="btn btn-block btn-sm btn-dark">{{__('Verify payment')}}</a>
                            @endif
                        </div>
                        <div class="card-footer text-center">
                            <button type="submit" class="btn btn-primary btn-sm">{{__('Save')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="row py-4">
            <div class="container">
                <div class="card">
                    <div class="card-header">{{trans('Order details')}}</div>
                    <div class="card-body">
                        <table class="table table-condensed table-sm table-responsive-sm" id="selectedProducts">
                            <thead>
                            <tr>
                                <th>{{trans('Product')}}</th>
                                <th>{{trans('Name')}}</th>
                                <th>{{trans('Size')}}</th>
                                <th>{{trans('Color')}}</th>
                                <th>{{trans('Quantity')}}</th>
                                <th>{{trans('Price')}}</th>
                                <th>{{trans('Total')}}</th>
                                <th>{{trans('Remove')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($order->orderDetails as $key => $detail)
                                <tr>
                                    <td>{{ $detail->stock->product->reference }}</td>
                                    <td>{{ $detail->stock->product->name }}</td>
                                    <td>{{ $detail->stock->size->name }}</td>
                                    <td class="text-lowercase">{{ $detail->stock->color->name }}</td>
                                    <td>{{ $detail->quantity }}</td>
                                    <td>{{ $detail->unit_price }}</td>
                                    <td>{{ $detail->total_price}}</td>
                                    <td>
                                        <div class="btn-group btn-block btn-group-sm text-center">
                                            <form action="{{route('order_details.destroy', $detail->id)}}"
                                                  method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button
                                                    @if($order->status !== \App\Constants\Orders::STATUS_PENDING_PAY)
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
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="text-price float-left">{{trans('SubTotal')}}</td>
                                <td>{{ $order->amount - $order->amount / 1.19 }}</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="text-price float-left">{{trans('Tax')}}</td>
                                <td>{{ $order->amount / 1.19 }}</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="text-price float-left">{{trans('Amount')}}</td>
                                <td class="">{{ $order->amount }}</td>
                                <td></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

