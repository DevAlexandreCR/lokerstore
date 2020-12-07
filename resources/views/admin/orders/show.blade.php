@extends('admin.home')

@section('main')
    <div class="container-fluid py-2">
        <div class="row">
            @if($order->user)
                <div class="col-xl-4">
                    <div class="card">
                        <div class="card-header"><h5>{{trans('users.data')}}</h5></div>
                        <div class="card-body">
                            <table class="table table-responsive">
                                <thead>
                                <tr>
                                    <th>{{trans('users.name')}}:</th>
                                    <td class="text-right">{{$order->user->name}}</td>
                                </tr>
                                <tr>
                                    <th>{{trans('users.email')}}:</th>
                                    <td class="text-right">{{$order->user->email}}</td>
                                </tr>
                                <tr>
                                    <th>{{trans('users.phone')}}:</th>
                                    <td class="text-right">{{$order->user->phone}}</td>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
            <div class="@if($order->user) col-xl-5 @else col-xl-9 @endif">
                @if(in_array($order->status, \App\Constants\Orders::statusesPaid(), true))
                    <div class="card">
                        <div class="card-header"><h5>{{trans('payment.payment')}}</h5></div>
                        <div class="card-body">
                            <div class="row">
                                <div class="container">
                                    <h6>{{trans('payer.data')}}</h6>
                                    <div class="row row-cols-2">
                                        <div class="col-sm-6 text-price text-left">
                                            {{trans('payment.method')}}
                                        </div>
                                        <div class="col-sm-6 text-muted text-left">
                                            {{$order->payment->method}}
                                        </div>
                                    </div>
                                    @if($order->payment->payer)
                                        <div class="row row-cols-2">
                                            <div class="col-sm-6 text-price text-left">
                                                {{trans('users.name')}}
                                            </div>
                                            <div class="col-sm-6 text-muted text-left">
                                                {{$order->payment->payer->getFullName()}}
                                            </div>
                                        </div>
                                        <div class="row row-cols-2">
                                            <div class="col-sm-6 text-price text-left">
                                                {{trans('payer.document')}}
                                            </div>
                                            <div class="col-sm-6 text-muted text-left">
                                                {{$order->payment->payer->document_type}}
                                                : {{$order->payment->payer->document}}
                                            </div>
                                        </div>
                                        <div class="row row-cols-2">
                                            <div class="col-sm-6 text-price text-left">
                                                {{trans('users.email')}}
                                            </div>
                                            <div class="col-sm-6 text-muted text-left">
                                                {{$order->payment->payer->email}}
                                            </div>
                                        </div>
                                        <div class="row row-cols-2">
                                            <div class="col-sm-6 text-price text-left">
                                                {{trans('users.phone')}}
                                            </div>
                                            <div class="col-sm-6 text-muted text-left">
                                                {{$order->payment->payer->phone}}
                                            </div>
                                        </div>
                                        <div class="row row-cols-2">
                                            <div class="col-sm-6 text-price text-left">
                                                {{trans('payment.last_digit')}}
                                            </div>
                                            <div class="col-sm-6 text-muted text-left">
                                                {{$order->payment->last_digit ?? '****'}}
                                            </div>
                                        </div>
                                        <hr>
                                    @else
                                        <h4>{{ trans('payer.no_data') }}</h4>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <add-payment-component :payers="{{ $payers }}" :amount="{{ $order->amount }}"
                                           :order-id="{{ $order->id }}"></add-payment-component>
                @endif
            </div>
            <div class="col-xl-3">
                <div class="card">
                    <div class="card-header"><h5>{{trans('orders.update')}}</h5></div>
                    <form action="{{route('orders.update', $order->id)}}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="card-body text-center">
                            @if($order->status === \App\Constants\Orders::STATUS_PENDING_PAY || $order->status === \App\Constants\Orders::STATUS_REJECTED)
                                <div class="form-group text-center">
                                    <label for="amountOrder">{{trans('products.price')}}</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">$</span>
                                        </div>
                                        <input class="form-control" type="number" min="0" id="amountOrder" name="amount"
                                               value="{{ $order->amount }}">
                                    </div>
                                </div>
                            @endif
                            <label for="status">{{trans('fields.status')}}</label>
                            <select name="status" class="form-control mb-2">
                                @foreach($order->getAllStatus() as $key => $value)
                                    <option value="{{$key}}"
                                            @if($order->status === $key) selected @endif>{{$value}}</option>
                                @endforeach
                            </select>
                            @if($order->status === \App\Constants\Orders::STATUS_PENDING_PAY && $order->payment && $order->payment->requesId)
                                <a href="{{route('orders.verify', $order->id)}}"
                                   class="btn btn-block btn-sm btn-dark">{{trans('payment.verify')}}</a>
                            @endif
                        </div>
                        <div class="card-footer text-center">
                            <button type="submit" class="btn btn-primary btn-sm">{{trans('actions.save')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <hr>
        <div class="row py-4">
            <div class="container">
                <div class="card">
                    <div class="card-header">{{trans('orders.details')}}</div>
                    <div class="card-body">
                        <table class="table table-condensed table-sm table-responsive-md" id="selectedProducts">
                            <thead>
                            <tr>
                                <th>{{trans_choice('products.product', 1, ['product_count' => ''])}}</th>
                                <th>{{trans('products.name')}}</th>
                                <th>{{trans('products.size')}}</th>
                                <th>{{trans('products.color')}}</th>
                                <th>{{trans('products.quantity')}}</th>
                                <th>{{trans('products.price')}}</th>
                                <th>{{trans('orders.total')}}</th>
                                <th>{{trans('actions.remove')}}</th>
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
                                    <td>$ {{ number_format($detail->unit_price, 2, ',', '.') }}</td>
                                    <td>$ {{ number_format($detail->total_price, 2, ',', '.')}}</td>
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
                                <td class="text-price float-left">{{trans('orders.subtotal')}}</td>
                                <td>$ {{ number_format($order->amount / 1.19, 2, ',', '.') }}</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="text-price float-left">{{trans('orders.tax')}}</td>
                                <td>$ {{ number_format($order->amount - $order->amount / 1.19, 2, ',', '.') }}</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="text-price float-left">{{trans('orders.amount')}}</td>
                                <td class="">$ {{ number_format($order->amount, 2, ',', '.') }}</td>
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

