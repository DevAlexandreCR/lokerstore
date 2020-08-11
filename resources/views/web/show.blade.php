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
                    <form >
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
                                            @foreach ($size->colors as $color)
                                            <div class="form-check d-inline-block">
                                                <input class="form-check-input" type="radio" name="color_id" id="color">
                                                <label class="form-check-label mt-1" for="exampleRadios1">
                                                    <span class="badge bg-{{strtolower($color->name)}}">{{strtolower(__($color->name))}}</span>
                                                </label>
                                            </div>
                                            @endforeach
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="modal-footer">
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

    function changeImg(img) {
        document.getElementById('imgZoom').src = img.src
    }
</script>
