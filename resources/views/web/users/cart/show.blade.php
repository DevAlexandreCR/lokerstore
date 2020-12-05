@extends('web.users.main')

@section('user-main')
    <div class="container py-4">
        <h3>{{trans('users.cart')}}</h3>
        @if($cart->stocks->count() === 0)
            <empty-cart-component></empty-cart-component>
        @endif
        <div class="row py-4">
            <div class="col-lg-8 order-first font-mini">
                <div class="list-group" id="list-cart">
                    @foreach($cart->stocks as $stock)
                        <div class="list-group-item my-2">
                            <div class="row align-items-center">
                                <div class="col-sm-2">
                                    <img class="img-fluid" src="/storage/photos/{{$stock->product->photos->first()->name}}">
                                </div>
                                <div class="col-sm-6">
                                    <p class="font-weight-bold">{{$stock->product->name}}</p>
                                    <p class="">{{$stock->product->description}}</p>
                                    <div class="row">
                                        <div class="col">
                                            <p class="font-weight-bold d-inline-block">{{trans('products.color')}}</p>
                                            <span class="badge bg-{{strtolower($stock->color->name)}}">
                                                {{strtolower(trans($stock->color->name))}}
                                            </span>
                                        </div>
                                        <div class="col">
                                            <p class="font-weight-bold d-inline-block">{{trans('products.size')}}</p>
                                            <span class="badge">{{$stock->size->name}}</span>
                                        </div>
                                    </div>
                                    <div class="justify-content-md-around">
                                        <form class="" action="{{route('cart.remove', [Auth::user(), $stock])}}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                <button type="submit" class="btn  btn-sm btn-outline-danger">
                                                    <ion-icon name="trash-outline"></ion-icon>
                                                    {{trans('actions.remove')}}
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <form method="post" id="update-cart-{{$stock->id}}" action="{{route('cart.update', Auth::user())}}">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group row pr-2">
                                            <input name="stock_id" value="{{$stock->id}}" type="number" hidden>
                                            <label class="col font-weight-bold" for="select-quantity">{{trans('products.stock')}}:</label>
                                            <select name="quantity" class="form-control form-control-sm col"
                                                    onchange="updateItemCart({{$stock->id}})">
                                                @for($i = 1; $i <= $stock->quantity; $i++)
                                                    <option value="{{$i}}" @if($i == $stock->pivot->quantity) selected @endif>{{$i}}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </form>
                                    <div class="row">
                                        <label class="col-7 font-weight-bold mt-2">{{trans('products.price')}}: </label>
                                        <input id="inputunit" class="form-control-plaintext col-5" value="{{$stock->product->getPrice()}}">
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <label class="col-6 font-weight-bold mt-2">{{trans('orders.subtotal')}}: </label>
                                        <input id="inputunit" class="form-control-plaintext text-price col-6"
                                               value="{{$cart->getSubTotalFromProduct($stock)}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @if($cart->stocks->count() > 0)
            <div class="col-lg-4 order-sm-first my-2">
                <div class="card text-center">
                    <div class="card-header">
                        {{trans('orders.summary')}}
                    </div>
                    <div class="card-body">
                        <table class="table table-sm table-borderless">
                            <thead>
                            <tr class="text-right">
                                <th scope="col">{{trans_choice('products.product', 1, ['product_count' => ''])}}</th>
                                <th scope="col">{{trans('products.stock')}}</th>
                                <th scope="col">{{trans('products.price')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($cart->stocks as $stock)
                                <tr class="text-right font-mini">
                                    <td>{{$stock->product->name}}</td>
                                    <td>{{$stock->pivot->quantity}}</td>
                                    <td>{{$cart->getSubTotalFromProduct($stock)}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <hr>
                        <div class="row font-weight-bold">
                            <div class="col-6 text-right">{{trans('orders.total')}}</div>
                            <div class="col-6 text-right">{{$cart->cartPrice()}}</div>
                        </div>
                    </div>
                    <div class="card-footer text-muted">
                        <div class="btn-group-vertical btn-block" role="group">
                            <form class="btn-block" action="{{route('user.order.store', [ 'user' => auth()->user()])}}" method="post">
                                @csrf
                                <input type="hidden" name="user_id" value="{{$cart->user_id}}">
                                <button type="submit" class="btn btn-success btn-block">{{trans('payment.pay')}}</button>
                            </form>
                            <a href="{{route('home')}}" type="button" class="btn btn-secondary">{{trans('payment.continue')}}</a>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
@endsection
<script>
    function updateItemCart(idForm) {
        let id = `update-cart-${idForm}`
        document.getElementById(id).submit()
    }
</script>
