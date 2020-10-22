@extends('admin.home')

@section('main')
    <div class="container-fluid my-2 p-4 shadow-sm bg-secondary round">
        <form name="search"  method="GET" action="{{ route('products.index') }}">
            <div class="row">
                <div class="col-sm-8">
                    <div class="btn-group btn-group-sm" role="group">
                    <a class="btn btn-link" data-toggle="modal" data-target="#sortModal" onclick="modal({{json_encode($filters)}}, true)" role="button"><ion-icon name="options-outline"></ion-icon></a>
                        <a class="btn btn-link text-decoration-none" data-toggle="modal" onclick="modal({{json_encode($filters)}}, true)" data-target="#sortModal">{{__('Filter and sort')}}</a>
                    </div>
                    <a type="button" class="btn btn-blue" data-toggle="modal" data-target="#importModal">{{trans('Import')}}<ion-icon class="ml-2" name="cloud-upload"></ion-icon></a>
                    <a href="{{ route('products.export') }}" type="button" class="btn btn-primary">{{trans('Export')}}<ion-icon class="ml-2" name="download"></ion-icon></ion-icon></a>
                </div>
                <div class="col-sm-4 form-inline my-2 my-lg-0 justify-content-end">
                    <input class="form-control form-control-sm mr-sm-2" name="search" type="search" placeholder="{{__('Search')}}" aria-label="Search">
                    <button class="btn btn-outline-primary btn-sm my-2 my-sm-1" id="search" type="submit">{{__('Search')}}</button>
                </div>
            </div>
        </form>
    </div>
    @if ( session('success'))

        <div class="container py-2">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <strong>{{__('Success!')}}</strong> {{ session('success') }}
            </div>
        </div>

    @endif
    @if ( $errors->any() )

        @foreach ($errors->all() as $error)
            <div class="container align-self-start col-4 py-2">
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
    <div class="container-fluid bg-secondary shadow-sm my-2">
        <div class="row">
            <table class="table table-sm table-striped table-condensed table-hover table-secondary table-responsive-xl">
                <thead>
                <tr>
                    <th>{{__('Id')}}</th>
                    <th>{{__('Created at')}}</th>
                    <th>{{__('Category')}}</th>
                    <th>{{__('Name')}}</th>
                    <th>{{__('Description')}}</th>
                    <th>{{__('Stock')}}</th>
                    <th>{{__('Price')}}</th>
                    <th>{{__('Tags')}}</th>
                    <th>{{__('Status')}}</th>
                    <th style="text-align: center">{{__('View')}}</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($products as $key => $product)
                    <tr class="@if(!$product->is_active) text-muted @endif">
                        <td scope="row">{{ $key }}</td>
                        <td>{{ $product->created_at->format('d-m-yy') }}</td>
                        <td>{{ $product->category->name }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->getDescription()}}...</td>
                        <td>
                            <a  href="{{route('stocks.create', $product)}}"><span class="badge badge-link badge-pill"><ion-icon name="navigate-circle-outline"></ion-icon>{{ $product->stock }}</span></a>
                        </td>
                        <td>{{ $product->price }}</td>
                        <td>
                            <div class="btn-group">
                                <a class="btn btn-link btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="badge badge-success">{{optional($product->tags->first())->name}}</span>
                                </a>
                                <div class="dropdown-menu">
                                    <ul class="list-group">
                                        @foreach ($product->tags as $tag)
                                            <li class="list-group-item">{{$tag->name}}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </td>
                        @if ($product->is_active)
                            <td>
                                <span class="badge badge-info"> {{ __('Enabled') }}</span>
                            </td>
                        @else
                            <td class="text-muted">
                                <span class="badge badge-danger"> {{ __('Disabled') }}</span>
                            </td>
                        @endif
                        <td>
                            <div class="btn-group btn-block btn-group-sm text-center"
                                 role="group"
                                 style="border-left: groove">
                                @include('admin.products.detail', ['product' => $product])
                                <a type="button" class="btn btn-link btn-sm"
                                   data-placement="top"
                                   title="{{__('View')}}"
                                   data-toggle="modal"
                                   data-target="#modalDetail{{$product->id}}"
                                >
                                    <ion-icon name="eye"></ion-icon>
                                </a>
                                <a type="button" class="btn btn-link btn-sm"
                                   data-toggle="tooltip"
                                   data-placement="top"
                                   title="{{__('Edit')}}"
                                   href="{{ route('products.edit', ['product' => $product])}}">
                                    <ion-icon name="create-outline"></ion-icon>
                                </a>
                                <a type="button" class="btn btn-link btn-sm"
                                   data-toggle="tooltip"
                                   data-placement="top"
                                   title="@if($product->is_active) {{__('Disable')}} @else{{__('Enable')}} @endif"
                                   href="{{ route('products.active', ['product' => $product, 'input_name' => 'is_active'])}}">
                                    <ion-icon name="power"></ion-icon>
                                </a>
                                <a type="button" class="btn btn-link btn-sm"
                                   data-toggle="tooltip"
                                   data-placement="top"
                                   title="{{__('Remove')}}"
                                   href="{{route('products.active', ['product' => $product, 'input_name' => 'delete'])}}">
                                    <ion-icon name="trash"></ion-icon>
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            @if ($products->count() === 0)
            <div class="container-fluid" role="alert">
            <strong>{{ __('No results found') }}</strong> <a class="btn btn-sm btn-link" href="{{route('products.index')}}">{{__('See all')}}</a>
            </div>
            @endif
            <div class="container">
                <div class="row">
                    <div class="col-8">
                            {{ $products->links() }}
                    </div>
                    <div class="col-4">
                        <div class="row" style="float: right">
                            <div class="col"><strong>{{__('Products')}}</strong></div>
                            <div class="col">{{ $products->count()}}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container text-right">
                <a href="{{route('products.create')}}" class="btn btn-primary fab"><ion-icon name="add" size="large" class="add"></ion-icon></a>
            </div>
        </div>
    </div>

{{-- Modal to add sort --}}
<div class="modal fade" tabindex="-1" role="dialog" id="sortModal">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
        <form action="{{ route('products.index') }}" method="GET" name="modalForm">
            <div class="modal-header">
            <h5 class="modal-title">{{__('Filter and sort')}}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col">
                        <p class="text-bold">{{__('Order by')}}</p>
                        </div>
                        <div class="col">
                            <select id="orderBy" class="form-control" name="orderBy">
                                <option>{{__('Most recent')}}</option>
                                @if ($filters['orderBy'] === 'asc')
                                <option selected>{{__('Less recent')}}</option>
                                @else
                                <option>{{__('Less recent')}}</option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-3">
                        <p class="text-bold">{{__('Category')}}</p>
                        </div>
                        <div class="col">
                            <select id="category" class="form-control" id="exampleFormControlSelect2" name="category">
                                <option>{{__('Choose category')}}</option>
                                @if ($filters['category'])
                                <option selected>{{$filters['category']}}</option>
                                @endif
                                @foreach ($categories as $category)
                                <option>{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-2">
                        <p class="text-bold">{{__('Tags')}}</p>
                        </div>
                        <div class="col">
                            <div class="row">
                                @foreach ($tags as $tag)
                                    <div class="card m-2">
                                        <div class="custom-control custom-checkbox mr-sm-2 ml-sm-2">
                                        <input type="checkbox" class="custom-control-input"
                                               name="tags[{{$tag->name}}]" id="{{$tag->name}}" value="{{$tag->name}}">
                                        <label class="custom-control-label" for="{{$tag->name}}">{{$tag->name}}</label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <hr>
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" onclick="clearFilters({{json_encode($filters)}})" class="btn btn-info" data-dismiss="modal">{{__('Clear filters')}}</button>
            <button type="submit" class="btn btn-primary">{{__('Apply')}}</button>
            </div>
        </form>
        </div>
    </div>
</div>

    @include('admin.products.importModal')

@endsection

<script>
    /** esta funcion hace check en los tags devueltos por el servidor
    *@argument filter Json
    *@argument checked Boolean
    */
    const modal = (filter, checked) => {
        console.log(filter);
        if (filter.tags) {
            for (const key in filter.tags) {
                if (filter.tags.hasOwnProperty(key)) {
                    document.getElementById(key).checked = checked
                }
            }
        }
    }
    /** esta funcion limpia todos los filtros y hace submit para traer todos los productos
    *@argument filter Json
    */
    const clearFilters = (filter) => {
        modal(filter, false)
        document.getElementById('orderBy').selectedIndex  = 0
        if (filter.category) {
            document.getElementById('category').selectedIndex  = 0
        }
        document.modalForm.submit()
    }
    /** esta funcion elimina el filtro seleccionado de la busqueda
    *@argument id id del tsg a eliminar
    */
    const removeFilter = (id) => {
        document.getElementById(id + 'tag').remove()
        document.search.submit()
    }
</script>
