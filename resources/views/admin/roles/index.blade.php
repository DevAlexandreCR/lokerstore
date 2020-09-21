@extends('admin.home')

@section('main')
    @if (session('success'))
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
    <div class="row py-4">
        <div class="container">
            <button type="button" data-toggle="modal" data-target="#addRole"class="btn btn-dark">{{__('Add role')}}</button>
            <button type="button" data-toggle="modal" data-target="#addPermission"class="btn btn-dark">{{__('Add permission')}}</button>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h3>{{__('Roles')}}</h3>
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    @foreach($roles as $key => $role)
                        <div class="row">
                            <div class="col-10">
                                <a class="nav-link @if ($key === 0) 'active' @endif" id="v-ills-home-tab" data-toggle="pill"
                                   href="#{{$role->name}}" role="tab" aria-controls="{{$role->name}}" aria-selected="true">
                                    {{__($role->name)}}
                                </a>
                            </div>
                            <div class="col-2">
                                <form action="{{route('roles.destroy', $role->id)}}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger"
                                    @if($role->name === 'Administrator') disabled="disabled"@endif><ion-icon name="trash"></ion-icon></button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-md-6">
                <h3>{{__('Permissions')}}</h3>
                <div class="tab-content" id="v-pills-tabContent">
                    @foreach($roles as $key => $role)
                        <div class="tab-pane fade show @if ($key === 0) 'active' @endif" id="{{$role->name}}" role="tabpanel" aria-labelledby="v-pills-home-tab">
                            @if($role->name === 'Administrator')
                                <div class="jumbotron">
                                    <h1>{{__('Administrator')}}</h1>
                                    <p class="lead">{{__('The user have all permissions')}}</p>
                                </div>
                            @else
                            <form action="{{route('roles.update', $role->id)}}" method="post">
                                @csrf
                                @method('PUT')
                                <ul class="list-group list-group-scroll">
                                    @foreach ($permissions as $id => $name)
                                        <li class="list-group-item-action text-right">
                                            <label for="perm{{$id}}">{{$name}}</label>
                                            <input class="custom-checkbox ml-4 mr-2" type="checkbox" id="perm{{$id}}" name="permissions[]" value="{{$id}}"
                                                   @if($role->hasDirectPermission($name, 'admin')) checked @endif>
                                        </li>
                                    @endforeach
                                </ul>
                                <button type="submit" class="btn btn-block btn-success">{{__('Update permissions')}}</button>
                            </form>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" id="addRole" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{__('Add role')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('roles.store')}}" method="post">
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="name">{{__('Name')}}</label>
                            <input class="form-control" type="text" name="name" id="name">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">{{__('Save')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="addPermission" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{__('Add Permission')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('permissions.store')}}" method="post">
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="name">{{__('Name')}}</label>
                            <input class="form-control" type="text" name="name" id="name">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">{{__('Save')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
