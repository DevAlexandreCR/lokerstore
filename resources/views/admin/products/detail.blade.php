<div class="modal fade" id="modalDetail{{$product->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">{{$product->name}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="carousel{{$product->id}}" class="carousel slide" data-ride="carousel"> 
                    <div class="carousel-inner">
                        @foreach ($product->photos as $key => $photo)
                            <div class="carousel-item {{$key == 0 ? 'active' : '' }}" data-interval="3000">
                                <img src="../../../public/storage/photos/{{$photo->name}}" class="d-block w-100" alt="{{$photo->name}}">
                            </div>
                        @endforeach
                    </div>
                    <a class="carousel-control-prev" href="#carousel{{$product->id}}" role="button" data-slide="prev">
                      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                      <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carousel{{$product->id}}" role="button" data-slide="next">
                      <span class="carousel-control-next-icon" aria-hidden="true"></span>
                      <span class="sr-only">Next</span>
                    </a>
                </div>
                <div class="row">
                    <div class="container">
                        <p>{{$product->description}}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <p><strong>{{__('Price')}}</strong></p>
                        <p>{{$product->getPrice()}}</p>
                    </div>
                    <div class="col">
                        <p><strong>{{__('Stock')}}</strong></p>
                        <p>{{$product->stock}}</p>
                    </div>
                    <div class="col">
                        <p><strong>{{__('Status')}}</strong></p>
                        <p>{{$product->getStatus()}}</p>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col">
                        <p><strong>{{__('Category')}}</strong></p>
                        <p>{{$product->category->name}}</p>
                    </div>
                    <div class="col">
                        <p><strong>{{__('Tags')}}</strong></p>
                        <p>@foreach ($product->tags as $tag)
                            {{$tag->name}}
                        @endforeach</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">{{$product->photos->count()}}</button>
            </div>
        </div>
    </div>
</div>