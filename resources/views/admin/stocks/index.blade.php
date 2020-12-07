@extends('admin.home')

@section('main')
    <div class="container my-4">
        <form action="{{route('stocks.store')}}" method="POST">
            @csrf
            @include('admin.stocks.add_form',[
                'product'    => $product,
                'colors'     => $colors,
                'type_sizes' => $type_sizes
            ])
        </form>
    </div>
    <div class="container my-2">
        <div class="card">
            <div class="modal-header">
                <h5>{{trans('products.inventory')}}</h5>
                <a href="{{ route('products.index') }}" class="btn btn-link"><ion-icon
                        name="return-up-back-outline"></ion-icon></a>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>{{trans('products.color')}}</th>
                            <th>{{trans('products.category')}}</th>
                            <th>{{trans('products.size')}}</th>
                            <th>{{trans('products.stock')}}</th>
                            <th>{{trans('fields.actions')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($product->stocks as $key => $stock)
                        <tr>
                            <td scope="row">{{$key}}</td>
                            <td class="text-lowercase"><span class="badge bg-{{$stock->color->name}}">{{trans($stock->color->name)}}</span></td>
                            <td>{{$stock->size->type->name}}</td>
                            <td>{{$stock->size->name}}</td>
                            <td>{{$stock->quantity}}</td>
                            <td>
                                <div class="btn-group  btn-group-sm text-center">
                                    <button type="button" class="btn btn-sm btn-blue"
                                        data-placement="top"
                                        title="{{trans('actions.update')}}"
                                        data-toggle="modal"
                                        data-target="#stockEdit{{$stock->id}}"
                                        >
                                        <ion-icon name="create"></ion-icon>
                                    </button>
                                    @include('admin.stocks.edit_form', [
                                        'stock' => $stock
                                        ])
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer modal-footer">
                <label for="total">{{trans('products.all_inventory')}}</label><h6 id="total">{{$product->stock}}</h6>
            </div>
        </div>
    </div>
@endsection

<script>
    /**
    * Esta funcion agrega el valor del option a la size_id input
    * @argument value valor del option seleccionado
    */
    let setSize = (value, id) => {
        document.getElementById(id).value = value
    }

</script>
