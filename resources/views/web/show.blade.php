@extends('admin.home')

@section('content')
    <div class="container py-4">
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
                    <div class="card-body">
                        <p>{{$product->description}}</p>
                        <p class="text-monospace">{{$product->getPrice()}}</p>
                        <hr>
                        <select class="form-control" name="size">
                            <option>{{__('Choose size')}}</option>
                        </select>
                        <hr>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="color" id="color">
                            <label class="form-check-label" for="exampleRadios1">
                                Rojo ejemplo
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="color" id="exampleRadios2" value="option2">
                            <label class="form-check-label" for="exampleRadios2">
                                otro color de ejemplo
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary btn-block">Agregar al carrito</button>
                        <button class="btn btn-light btn-block" type="button" onclick="goBack()">volver</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


<script>
    function goBack() {
        window.history.back();
    }

    function changeImg(img) {
        document.getElementById('imgZoom').src = img.src
    }
</script>
