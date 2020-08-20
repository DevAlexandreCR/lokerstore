@extends('admin.home')

@section('content')
    <div class="container py-4">
        @if ( session('success'))

            <div class="container py-2">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only">Close</span>
                    </button>
                    <strong>{{__('Success!')}}</strong> {{ __(session('success')) }}
                    <a href="{{route('cart.show', auth()->id())}}">{{__('Show cart')}}</a>
                </div>
            </div>

        @endif

        <div class="row">
            <div class="col-sm-2">
                <ul class="list-group">
                    @foreach($product->photos as $photo)
                        <li class="list-unstyled mb-1">
                            <img onmouseover="changeImg(this)" class="img-item-list" src="/storage/photos/{{$photo->name}}">
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="col-sm-6 img-hover-zoom">
                <img id="imgZoom"
                     src="/storage/photos/{{$product->photos[0]->name}}">
            </div>
            <div class="col-sm-4">
                <div class="card">
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
                                    <strong>{{__('Error!')}}</strong> {{ $error }}
                                </div>
                            </div>
                        @endforeach

                    @endif
                    <form action="@auth(){{ route('cart.add', Auth::user()) }} @else {{ route('cart.add', 1) }} @endauth" method="POST">
                        @csrf
                        <div class="card-body">
                            <p>{{$product->description}}</p>
                            <p class="text-monospace">{{$product->getPrice()}}</p>
                            <hr>
                            <div class="nav flex-column nav-tabs" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                <a class="nav-link d-none active" id="shownone" data-toggle="tab" href="#shownoneid"
                                   role="tab" aria-controls="shownone" aria-selected="true"></a>
                                @foreach ($sizes as $key => $size)
                                    <a class="nav-link d-none " id="show{{$size->id}}" data-toggle="tab" href="#show{{str_replace('/', '', $size->name)}}"
                                       role="tab" aria-controls="show{{$size->name}}" aria-selected="false"></a>
                                @endforeach
                                <select class="form-control" name="size_id"
                                        onchange="document.getElementById(`show${this.value.replace('/', '')}`).click()">
                                    <option value="none">{{__('Choose size')}}</option>
                                    @foreach ($sizes as $key => $size)
                                        <option value="{{$size->id}}">{{$size->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <hr>
                            <div class="tab-content" id="v-pills-tabContent">
                                <div class="tab-pane fade show active" id="shownoneid" role="tabpanel" aria-labelledby="shownone">
                                </div>
                                @foreach ($sizes as $key => $size)
                                    <div class="tab-pane fade" id="show{{str_replace('/', '', $size->name)}}" role="tabpanel" aria-labelledby="show{{$size->id}}">
                                        <label class="mr-md-5 font-weight-bold">{{__('Choose color')}}: </label>
                                            @foreach ($size->colors as $color)
                                            <div class="form-check d-inline-block">
                                                <input class="form-check-input" type="radio" name="color_id" id="color" value="{{$color->id}}">
                                                <label class="form-check-label mt-1" for="exampleRadios1">
                                                    <span class="badge bg-{{strtolower($color->name)}}">{{strtolower(__($color->name))}}</span>
                                                </label>
                                            </div>
                                            @endforeach
                                    </div>
                                @endforeach
                            </div>
                            <div id="div-quant" class="input-group">
                                <label class="mr-md-5 font-weight-bold mt-2">{{__('Stock')}}: </label>
                                <div class="input-group-prepend">
                                    <button class="btn btn-link btn-sm" onclick="less('quantity')" type="button" id="button-addon1">
                                        <ion-icon name="remove-outline"></ion-icon>
                                    </button>
                                </div>
                                <input type="number" class="form-control-plaintext col-2 text-center pl-2" placeholder="0"
                                       min="0" aria-describedby="button-addon1" id="quantity" name="quantity">
                                <div class="input-group-append">
                                    <button onclick="add('quantity')" class="btn btn-link btn-sm" type="button" id="button-addon1">
                                        <ion-icon name="add-outline"></ion-icon>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" value="{{$product->id}}" name="product_id">
                            @guest()
                                <small class="text-muted">{{__('Login to add products to cart')}}</small>
                            @endguest
                            <button type="submit" class="btn btn-primary btn-block">{{__('Add to cart')}}</button>
                            <button class="btn btn-light btn-block" type="button" onclick="goBack()">{{__('Back')}}</button>
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

    function add(id){
        let input = document.getElementById(id)
        console.log(input.value)
        let value
        if(input.value) value = parseInt(input.value)
        else value = 0
        input.value = value + 1
    }

    function less(id){
        let input = document.getElementById(id)
        console.log(input.value)
        let value
        if(input.value) value = parseInt(input.value)
        else value = 0
        if (value === 0) return
        input.value = value - 1
    }

    function changeImg(img) {
        document.getElementById('imgZoom').src = img.src
    }
</script>