<!-- Modal -->
<div class="modal fade container-fluid" id="stockEdit{{$stock->id}}" tabindex="-1" role="dialog"
     aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3>{{trans('products.edit_stock')}}</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('stocks.update', $stock)}}" method="post">
                    @method('PUT')
                    @csrf
                    <div class="container form-inline increment">
                        <div class="form-group mb-2">
                            <label for="selectColor"><span class="badge bg-{{$stock->color->name}}"><ion-icon
                                        size="small" name="color-fill-outline"></ion-icon></span></label>
                            <select name="color_id" class="custom-select ml-2 text-lowercase" disabled>
                                @foreach ($colors as $color)
                                    <option @if ($stock->color->id == $color->id)
                                            selected
                                            @endif value="{{$color->id}}">{{trans($color->name)}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mx-sm-3 mb-2">
                            <div class="nav flex-column nav-tabs" id="v-pills-tab" role="tablist"
                                 aria-orientation="vertical">
                                @foreach ($type_sizes as $key => $type)
                                    <a class="nav-link d-none {{$stock->size->type_sizes_id == $type->id ? ' active' : '' }}"
                                       id="edit{{$type->id}}" data-toggle="tab" href="#edit{{$type->name}}"
                                       role="tab" aria-controls="{{$type->name}}"
                                       aria-selected="{{$key == 0? 'true' : 'false' }}"></a>
                                @endforeach
                                <select class="form-control"
                                        onchange="document.getElementById(`edit${this.value}`).click()" disabled>
                                    @foreach ($type_sizes as $key => $type)
                                        <option @if ($stock->size->type_sizes_id == $type->id)
                                                selected
                                                @endif value="{{$type->id}}">{{$type->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="tab-content ml-3">
                                @foreach ($type_sizes as $key => $type)
                                    <div
                                        class="tab-pane fade {{$stock->size->type_sizes_id == $type->id ? 'show active' : ''}}"
                                        id="edit{{$type->name}}" role="tabpanel" aria-labelledby="edit{{$type->id}}">
                                        <select class="form-control" required disabled
                                                onchange="setSize(this.value, 'size_edit')">
                                            @foreach ($type->sizes as $size)
                                                <option @if ($stock->size->id == $size->id)
                                                        selected
                                                        @endif value="{{$size->id}}">{{$size->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endforeach
                            </div>
                            <div class="form-group ml-2">
                                <label for="inputquantity" class="sr-only">{{trans('products.quantity')}}</label>
                                <input type="number" class="form-control" name="quantity" id="inputquantity" min="0"
                                       placeholder="{{trans('products.quantity')}}" value="{{$stock->quantity}}" required>
                                <input type="number" id="size_edit" class="form-control" name="size_id" hidden
                                       value="{{$stock->size->id}}">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mb-2">{{trans('actions.save')}}</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-blue" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
