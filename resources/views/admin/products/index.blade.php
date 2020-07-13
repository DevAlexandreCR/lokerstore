@extends('admin.home')

@section('main')

    <div class="container-fluid my-2 p-4 shadow-sm bg-secondary round">
        <div class="row">
            <div class="col-sm-3">
            <div class="btn-group btn-group-sm" role="group">
                <a class="btn btn-link" data-toggle="modal" data-target="#sortModal" role="button"><ion-icon name="options-outline"></ion-icon></a>
                <a class="btn btn-link text-decoration-none" data-toggle="modal" data-target="#sortModal">{{__('Filter and sort')}}</a>
            </div>
            </div>
            <div class="col"></div>
            <div class="col-4">
                <form class="form-inline my-2 my-lg-0 float-right" method="GET" action="{{ route('products.index') }}">
                    <input class="form-control form-control-sm mr-sm-2" name="search" type="search" placeholder="{{__('Search')}}" aria-label="Search">
                    <button class="btn btn-outline-primary btn-sm my-2 my-sm-0" type="submit">{{__('Search')}}</button>
                </form>
            </div>
        </div>
    </div>
    <div class="container-fluid bg-secondary shadow-sm my-2">
        <div class="row">
            <table class="table table-sm table-striped table-condensed table-hover table-secondary">
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
                    @foreach ($products as $product)
                        <tr class="@if(!$product->is_active) text-muted @endif">
                            <td scope="row">{{ $product->id }}</td>
                            <td>{{ $product->created_at->format('d-m-yy') }}</td>
                            <td>{{ $product->category->name }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->description }}</td>
                            <td>{{ $product->stock }}</td>
                            <td>{{ $product->price }}</td>
                            <td>
                                <div class="btn-group">
                                    <a class="btn btn-link btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="badge badge-success">{{$product->tags[0]->name}}</span>
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
                                <a type="button" class="btn btn-link" 
                                data-toggle="tooltip" 
                                data-placement="top" 
                                title="{{__('View')}}"
                                href="{{route('users.show', ['user' => $product])}}">
                                <ion-icon name="eye"></ion-icon>
                                </a>
                                <a type="button" class="btn btn-link" 
                                data-toggle="tooltip" 
                                data-placement="top" 
                                title="@if($product->is_active) {{__('Disable')}} @else{{__('Enable')}} @endif"
                                href="{{ route('users.edit', ['user' => $product, 'input_name' => 'is_active'])}}">
                                <ion-icon name="power"></ion-icon>
                                </a>
                                <a type="button" class="btn btn-link" 
                                data-toggle="tooltip" 
                                data-placement="top" 
                                title="{{__('Remove')}}"
                                href="{{route('users.edit', ['user' => $product, 'input_name' => 'delete'])}}">
                                <ion-icon name="trash"></ion-icon>
                                </a>
                            </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @if ($products->count() == 0)
            <div class="container-fluid" role="alert">
            <strong>{{ __('No results found') }}</strong> <a class="btn btn-sm btn-link" href="{{route('products.index')}}">{{__('See all')}}</a>
            </div>
            @endif
            <div class="container-fluid">
                <div class="row">
                    <div class="col-8">{{ $products->links() }}</div>
                    <div class="col-4">
                    <div class="row" style="float: right">
                        <div class="col"><strong>{{__('Users')}}</strong></div>
                        <div class="col">{{ \App\Models\Product::count()}}</div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal to add sort --}}
    <div class="modal fade" tabindex="-1" role="dialog" id="sortModal">
        <div class="modal-dialog modal-dialog-centered modal-lg">
          <div class="modal-content">
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
                        <p class="text-bold">{{__('Sort at')}}</p>
                        </div>
                        <div class="col">
                            <select id="inputState" class="form-control" name="orderBy">
                                <option selected>{{__('Sort at')}}</option>
                                <option>{{__('Most recent')}}</option>
                                <option>{{__('Less recent')}}</option>
                              </select>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="container">
                            <div class="row">
                                <div class="col">
                                <p class="text-bold">{{__('Category')}}</p>
                                </div>
                                <div class="col">
                                        <select class="form-control" id="exampleFormControlSelect2">
                                            @foreach (\App\Models\Category::all() as $category)
                                            <option>{{$category->name}}</option>
                                            @endforeach
                                      </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="container">
                            <div class="row">
                                <div class="col">
                                <p class="text-bold">{{__('Tags')}}</p>
                                </div>
                                <div class="col">
                                        <select class="form-control" id="exampleFormControlSelect2">
                                            @foreach (\App\Models\Tag::all() as $tag)
                                            <option>{{$tag->name}}</option>
                                            @endforeach
                                      </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary">Save changes</button>
            </div>
          </div>
        </div>
      </div>
@endsection