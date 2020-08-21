@extends('admin.home')

@section('content')
    <div class="container py-4">
        <h3>{{__('Shopping cart')}}</h3>
        @if($cart->stocks->count() === 0)
            <empty-cart-component></empty-cart-component>
        @endif
        <div class="row py-4">
            <div class="col-sm-8 order-first font-mini">
                <div class="list-group" id="list-cart">
                    @foreach($cart->stocks as $stock)
                        <div class="list-group-item my-2">
                            <div class="row align-items-center">
                                <div class="col-sm-2">
                                    <img class="img-fluid" src="/storage/photos/{{$stock->product->photos[0]->name}}">
                                </div>
                                <div class="col-sm-6">
                                    <p class="font-weight-bold">{{$stock->product->name}}</p>
                                    <p class="">{{$stock->product->description}}</p>
                                    <div class="row">
                                        <div class="col">
                                            <p class="font-weight-bold d-inline-block">{{__('Color')}}</p>
                                            <span class="badge bg-{{strtolower($stock->color->name)}}">
                                                {{strtolower(__($stock->color->name))}}
                                            </span>
                                        </div>
                                        <div class="col">
                                            <p class="font-weight-bold d-inline-block">{{__('Size')}}</p>
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
                                                    {{__('Remove product')}}
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
                                            <label class="col font-weight-bold" for="select-quantity">{{__('Stock')}}:</label>
                                            <select name="quantity" class="form-control form-control-sm col"
                                                    onchange="updateItemCart({{$stock->id}})">
                                                @for($i = 1; $i <= $stock->quantity; $i++)
                                                    <option value="{{$i}}" @if($i == $stock->pivot->quantity) selected @endif>{{$i}}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </form>
                                    <div class="row">
                                        <label class="col-7 font-weight-bold mt-2">{{__('P/ unidad')}}: </label>
                                        <input id="inputunit" class="form-control-plaintext col-5" value="{{$stock->product->getPrice()}}">
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <label class="col-7 font-weight-bold mt-2">{{__('Subtotal')}}: </label>
                                        <input id="inputunit" class="form-control-plaintext col-5"
                                               value="{{$cart->getSubTotalFromProduct($stock)}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @if($cart->stocks->count() > 0)
            <div class="col-sm-4 order-sm-first my-2">
                <div class="card text-center">
                    <div class="card-header">
                        {{__('Order summary')}}
                    </div>
                    <div class="card-body">
                        <table class="table table-sm table-borderless">
                            <thead>
                            <tr class="text-right">
                                <th scope="col">{{__('Product')}}</th>
                                <th scope="col">{{__('Stock')}}</th>
                                <th scope="col">{{__('Price')}}</th>
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
                            <div class="col-6 text-right">{{__('Total')}}</div>
                            <div class="col-6 text-right">{{$cart->cartPrice()}}</div>
                        </div>
                    </div>
                    <div class="card-footer text-muted">
                        <div class="btn-group-vertical btn-block" role="group">
                            <button type="button" class="btn btn-success">{{__('Proceed to payment')}}</button>
                            <a href="{{route('home')}}" type="button" class="btn btn-secondary">{{__('Continue shopping')}}</a>
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
