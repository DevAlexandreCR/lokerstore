@extends('admin.home')

@section('main')
    <div class="container-fluid my-2 p-4 shadow-sm bg-secondary">
        <form name="search" class="justify-content-end flex-wrap"  method="GET" class="bg-dark" action="{{ route('tags.index') }}">
            <div class="row">
                <div class="col-sm-8">
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
                    @error('name')
                        <div class="alert alert-primary alert-dismissible fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                <span class="sr-only">Close</span>
                            </button>
                            <strong>{{__('Error')}}</strong> {{$message}}
                        </div>
                    @enderror
                    @error('search')
                    <div class="alert alert-primary alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span>
                        </button>
                        <strong>{{__('Error')}}</strong> {{$message}}
                    </div>
                    @enderror
                </div>
                <div class="col-3 form-inline my-2 my-lg-0 align-self-right">
                    <input class="form-control form-control-sm mr-sm-2" name="search" type="search" placeholder="{{__('Search')}}" aria-label="Search">
                    <button class="btn btn-outline-primary btn-sm my-2 my-sm-0" id="search" type="submit">{{__('Search')}}</button>
                </div>
            </div>
        </form>
    </div>
    <div class="container bg-secondary shadow my-2">
        <div class="row">
            <table class="table table-sm table-striped table-condensed table-hover table-secondary">
                <thead>
                    <tr>
                        <th>{{__('Id')}}</th>
                        <th>{{__('Created at')}}</th>
                        <th>{{__('Name')}}</th>
                        <th>{{__('Products')}}</th>
                        <th class="text-center">{{__('Actions')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tags as $tag)
                        <tr>
                            <td scope="row">{{ $tag->id }}</td>
                            <td>{{ $tag->created_at->format('d-m-yy') }}</td>
                            <td>{{ $tag->name }}</td>
                            <td>{{ $tag->products->count()}}</td>
                            <td class="text-center">
                            <div class="btn-group btn-group-sm text-center">
                            <form action="{{ route('products.index') }}" class="mr-2" method="GET">
                                <input type="text" name="tags[{{$tag->name}}]" hidden value="{{$tag->name}}">
                                <button type="submit" class="btn btn-sm btn-blue" 
                                    data-placement="top" 
                                    title="{{__('View products')}}"
                                    data-target="tooltip"
                                    >
                                    <ion-icon name="eye"></ion-icon>
                                </button>
                            </form>
                            @include('admin.tags.edit', ['tag' => $tag])
                            @include('admin.tags.delete', ['tag' => $tag])
                                <button type="button" class="btn btn-success btn-sm mr-2" 
                                data-toggle="modal" 
                                data-placement="top" 
                                title="{{__('Edit')}}"
                                data-target="#modalEdit{{$tag->name}}"
                                >
                                <ion-icon name="create-outline"></ion-icon>
                                </button>
                                <button type="button" class="btn btn-danger btn-sm" 
                                data-toggle="modal" 
                                data-placement="top" 
                                data-target="#modalDelete{{$tag->id}}"
                                title="{{__('Remove')}}">
                                <ion-icon name="trash"></ion-icon>
                                </button>
                            </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @if ($tags->count() == 0)
            <div class="container-fluid" role="alert">
            <strong>{{ __('No results found') }}</strong> <a class="btn btn-sm btn-link" href="{{route('tags.index')}}">{{__('See all')}}</a>
            </div>
            @endif
            <div class="container">
                <div class="row">
                    <div class="col-8">{{ $tags->links() }}</div>
                    <div class="col-4">
                    <div class="row" style="float: right">
                        <div class="col"><strong>{{__('Tags')}}</strong></div>
                        <div class="col">{{ \App\Models\Tag::count()}}</div>
                    </div>
                    </div>
                </div>
            </div>
            <div class="container text-right">
                <button class="btn btn-primary fab" data-target="#modalCreateTag" data-toggle="modal"><ion-icon name="add" size="large" class="add"></ion-icon></button>
            </div>
        </div>
    </div>
    @include('admin.tags.create')
@endsection
 
