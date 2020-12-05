<div class="card shadow-sm">
    <div class="card-header">
        <h3>{{ trans('products.add_stock') }} {{$product->name}}</h3>
    </div>
    <div class="card-body">
        <div class="container form-inline increment">
            <div class="form-group mb-2">
                <label for="selectColor"><span id="color_badge" class="badge"><ion-icon size="small" name="color-fill-outline"></ion-icon></span></label>
                <select name="color_id"  class="custom-select ml-2 text-lowercase" id="selectColor">
                    <option value="{{null}}" selected>{{trans('products.choose_color')}}</option>
                    @foreach ($colors as $color)
                        <option value="{{$color->id}}">{{trans($color->name)}}</option>
                    @endforeach
                  </select>
            </div>
            <div class="form-group mx-sm-3 mb-2">
                <div class="nav flex-column nav-tabs" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    @foreach ($type_sizes as $key => $type)
                    <a class="nav-link d-none {{$key == 0 ? ' active' : '' }}" id="{{$type->id}}" data-toggle="tab" href="#{{$type->name}}"
                      role="tab" aria-controls="{{$type->name}}" aria-selected="{{$key == 0 ? 'true' : 'false' }}"></a>
                    @endforeach
                    <select class="form-control" onchange="document.getElementById(this.value).click()">
                        <option  selected>{{trans('actions.choose_category')}}</option>
                      @foreach ($type_sizes as $key => $type)
                      <a class="nav-link {{$key == 0 ? ' active' : '' }}" id="{{$type->id}}" data-toggle="tab" href="#{{$type->name}}"
                        role="tab" aria-controls="{{$type->name}}" aria-selected="{{$key == 0 ? 'true' : 'false' }}"></a>
                        <option value="{{$type->id}}"
                         >{{$type->name}}</option>
                      @endforeach
                    </select>
                </div>
                <div class="tab-content ml-3">
                    @foreach ($type_sizes as $key => $type)
                    <div class="tab-pane fade {{$key == 0 ? 'show active' : ''}}" id="{{$type->name}}" role="tabpanel" aria-labelledby="{{$type->id}}">
                        <select class="form-control" required onchange="setSize(this.value, 'size')">
                            <option value="null" selected>{{trans('products.choose_size')}}</option>
                            @foreach ($type->sizes as $size)
                                <option value="{{$size->id}}">{{$size->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    @endforeach
                </div>
                <div class="form-group mx-sm-3">
                    <label for="inputquantityadd" class="sr-only">{{trans('products.quantity')}}</label>
                    <input type="number" class="form-control" name="quantity" id="inputquantityadd" min="1"
                           placeholder="{{trans('products.quantity')}}" required>
                    <input type="number" class="form-control" name="product_id" hidden value="{{$product->id}}">
                    <input type="number"  id="size" class="form-control" name="size_id" hidden >
                </div>
            </div>
            <button type="submit" class="btn btn-primary mb-2">{{trans('actions.save')}}</button>
        </div>
    </div>
</div>
