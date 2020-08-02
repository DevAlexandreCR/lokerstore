@extends('admin.home')

@section('main')

@if ( session('success'))
    
<div class="container py-2">
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        <span class="sr-only">Close</span>
      </button>
      <strong>{{__('Success!')}}</strong> {{ __(session('success')) }}
    </div>
</div>

@endif
    <div class="container my-4">
        <form action="{{route('stocks.store')}}" method="POST">
            @csrf
            <div class="card shadow-sm">
                <div class="card-header">
                    <h3>{{__('Add stock for ')}}{{$product->name}}</h3>
                </div>
                <div class="card-body">
                    <div class="container form-inline increment">
                        <div class="form-group mb-2">
                            <label for="selectColor"><span class="badge"><ion-icon size="small" name="color-fill-outline"></ion-icon></span></label>
                            <select name="color_id"  class="custom-select ml-2 text-lowercase" id="selectColor">
                                <option selected>{{__('Choose color')}}</option>
                                @foreach ($colors as $color)
                                    <option value="{{$color->id}}">{{__($color->name)}}</option>
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
                                    <option  selected>{{__('Choose category')}}</option>
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
                                    <select class="form-control" required onchange="setSize(this.value)">
                                        <option value="null" selected>{{__('Choose size')}}</option>
                                        @foreach ($type->sizes as $size)
                                            <option value="{{$size->id}}">{{$size->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @endforeach
                            </div>
                            <div class="form-group mx-sm-3">
                                <label for="inputquantity" class="sr-only">{{__('Stock')}}</label>
                                <input type="number" class="form-control" name="quantity" id="inputquantity" placeholder="{{__('Stock')}}">
                                <input type="number" class="form-control" name="product_id" hidden value="{{$product->id}}">
                                <input type="number"  id="size" class="form-control" name="size_id" hidden >
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mb-2">{{__('Add stock')}}</button>
                    </div> 
                </div>
            </div>
        </form>
    </div>
@endsection

<script>
    /** 
    * Esta funcion agrega el valor del option a la size_id input
    * @argument value valor del option seleccionado
    */
    var setSize = (value) => {
        document.getElementById('size').value = value
    }
</script>