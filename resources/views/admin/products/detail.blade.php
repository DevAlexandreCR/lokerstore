<div class="modal fade" id="modalDetail{{$product->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">{{$product->name}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm">
                        <h5 >{{trans('products.reference')}}: {{$product->reference}}</h5>
                        <div id="carousel{{$product->id}}" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner">
                                @foreach ($product->photos as $key => $photo)
                                    <div class="carousel-item {{$key == 0 ? 'active' : '' }}" data-interval="3000">
                                        <img src="/photos/{{$photo->name}}" class="img-detail-admin" alt="{{$photo->name}}">
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
                    </div>
                    <div class="col-sm">
                        <div class="row ">
                            <p><strong>{{trans('products.description')}}</strong></p>
                            <div class="container">
                                <p>{{$product->description}}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <p><strong>{{trans('products.cost')}}</strong></p>
                                <p>$ {{number_format($product->cost, 2, ',', '.')}}</p>
                            </div>
                            <div class="col">
                                <p><strong>{{trans('products.price')}}</strong></p>
                                <p>$ {{number_format($product->price, 2, ',', '.')}}</p>
                            </div>
                            <div class="col">
                                <p><strong>{{trans('fields.status')}}</strong></p>
                                <p>{{$product->getStatus()}}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col">
                                <p><strong>{{trans('fields.status')}}</strong></p>
                                <p>{{$product->getStatus()}}</p>
                            </div>
                            <div class="col">
                                <p><strong>{{trans('products.category')}}</strong></p>
                                <p>{{$product->category->getFullCategory()}}</p>
                            </div>
                            <div class="col">
                                <p><strong>{{trans('fields.tags')}}</strong></p>
                                <p>@foreach ($product->tags as $tag)
                                    {{$tag->name}}
                                @endforeach</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a type="button" class="btn btn-primary"
                data-toggle="tooltip"
                data-placement="top"
                title="{{trans('actions.update')}}"
                href="{{ route('products.edit', ['product' => $product])}}">
                <ion-icon name="create-outline"></ion-icon>
                </a>
                <a type="button" class="btn btn-warning"
                data-toggle="tooltip"
                data-placement="top"
                title="@if($product->is_active) {{trans('actions.disable')}} @else{{trans('actions.enable')}} @endif"
                href="{{ route('products.active', ['product' => $product, 'input_name' => 'is_active'])}}">
                <ion-icon name="power"></ion-icon>
                </a>
                <a type="button" class="btn btn-danger"
                data-toggle="tooltip"
                data-placement="top"
                title="{{trans('actions.remove')}}"
                href="{{route('products.active', ['product' => $product, 'input_name' => 'delete'])}}">
                <ion-icon name="trash"></ion-icon>
                </a>
            </div>
        </div>
    </div>
</div>
