@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="row">
            <div class="col-sm-6 col-md-2">
                <div class="list-group-scroll">
                    <ul class="list-group">
                        @foreach($product->photos as $photo)
                            <li class="list-unstyled mb-1">
                                <img onmouseover="changeImg(this)" class="img-item-list" src="/photos/{{$photo->name}}">
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-sm-6 d-none d-md-block img-hover-zoom">
                <img id="imgZoom"
                     src="/photos/{{$product->photos[0]->name}}">
            </div>
            <div class="col-sm-6 col-md-4">
                <div class="card card-product">
                    <div class="card-header">
                        <h3 class="card-title">{{$product->name}}</h3>
                    </div>
                    @if ( $errors->any() )

                        @foreach ($errors->all() as $error)
                            <div class="container align-self-start py-2">
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        <span class="sr-only">Close</span>
                                    </button>
                                    <strong>{{trans('actions.error')}}</strong> {{ $error }}
                                </div>
                            </div>
                        @endforeach

                    @endif
                    <form
                        action="@auth(){{ route('cart.add', Auth::user()) }} @else {{ route('cart.add', 1) }} @endauth"
                        method="POST">
                        @csrf
                        <div class="card-body">
                            <p>{{$product->description}}</p>
                            <p class="text-monospace">{{$product->getPrice()}}</p>
                            <hr>
                            <div class="nav flex-column nav-tabs" id="v-pills-tab" role="tablist"
                                 aria-orientation="vertical">
                                <a class="nav-link d-none active" id="shownone" data-toggle="tab" href="#shownoneid"
                                   role="tab" aria-controls="shownone" aria-selected="true"></a>
                                @foreach ($sizes as $key => $size)
                                    <a class="nav-link d-none " id="show{{$size->id}}" data-toggle="tab"
                                       href="#show{{str_replace('/', '', $size->name)}}"
                                       role="tab" aria-controls="show{{$size->name}}" aria-selected="false"></a>
                                @endforeach
                                <select class="form-control" name="size_id"
                                        onchange="document.getElementById(`show${this.value.replace('/', '')}`).click()">
                                    <option value="none">{{trans('products.choose_size')}}</option>
                                    @foreach ($sizes as $key => $size)
                                        <option value="{{$size->id}}">{{$size->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <hr>
                            <div class="tab-content" id="v-pills-tabContent">
                                <div class="tab-pane fade show active" id="shownoneid" role="tabpanel"
                                     aria-labelledby="shownone">
                                </div>
                                @foreach ($sizes as $key => $size)
                                    <div class="tab-pane fade" id="show{{str_replace('/', '', $size->name)}}"
                                         role="tabpanel" aria-labelledby="show{{$size->id}}">
                                        <label class="mr-md-5 font-weight-bold">{{trans('products.choose_color')}}: </label>
                                        @foreach ($size->colors as $color)
                                            <div class="form-check d-inline-block">
                                                <input class="form-check-input" type="radio" name="color_id"
                                                       id="color{{$color->name}}" value="{{$color->id}}"
                                                       onchange="setMaxQuantityToInput({{$color->pivot->quantity}})">
                                                <label class="form-check-label mt-1" for="exampleRadios1">
                                                    <span
                                                        class="badge bg-{{strtolower($color->name)}}">{{strtolower(trans($color->name))}}</span>
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                            <small class="text-small text-danger" id="quantitySmall"></small>
                            <div id="div-quant" class="input-group">
                                <label class="mr-md-5 font-weight-bold mt-2">{{trans('products.stock')}}: </label>
                                <div class="input-group-prepend">
                                    <button class="btn btn-link btn-sm" onclick="less('quantityInput')" type="button"
                                            id="button-addon1">
                                        <ion-icon name="remove-outline"></ion-icon>
                                    </button>
                                </div>
                                <input type="number" class="form-control-plaintext col-2 text-center pl-2"
                                       placeholder="0"
                                       min="0" aria-describedby="button-addon1" id="quantityInput" name="quantity">
                                <div class="input-group-append">
                                    <button onclick="add('quantityInput')" class="btn btn-link btn-sm" type="button"
                                            id="button-addon1">
                                        <ion-icon name="add-outline"></ion-icon>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" value="{{$product->id}}" name="product_id">
                            @guest()
                                <small class="text-muted">{{trans('users.messages.cart_no_login')}}</small>
                            @endguest
                            @if($product->stocks->count() === 0)
                                <small class="text-muted text-danger">{{trans('users.messages.no_product')}}</small>
                                <button type="button" disabled
                                        class="btn btn-primary btn-block">{{trans('users.add_to_cart')}}</button>
                            @else
                                <button type="submit" class="btn btn-primary btn-block">{{trans('users.add_to_cart')}}</button>
                            @endif
                            <button class="btn btn-light btn-block" type="button"
                                    onclick="goBack()">{{trans('actions.back')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection


<script>
    function goBack() {
        window.history.back();
    }

    function setMaxQuantityToInput(quantity) {
        document.getElementById('quantityInput').max = quantity
        if (quantity < 5) {
            document.getElementById('quantitySmall').innerText = 'Solo quedan ' + quantity + ' artículos en stock'
        }
    }

    function add(id) {
        let input = document.getElementById(id)
        let value
        let max = document.getElementById('quantityInput').max
        if (input.value) value = parseInt(input.value)
        else value = 0
        if (value < max) {
            input.value = value + 1
        }
    }

    function less(id) {
        let input = document.getElementById(id)
        let value
        if (input.value) value = parseInt(input.value)
        else value = 0
        if (value === 0) return
        input.value = value - 1
    }

    function changeImg(img) {
        document.getElementById('imgZoom').src = img.src
    }
</script>
