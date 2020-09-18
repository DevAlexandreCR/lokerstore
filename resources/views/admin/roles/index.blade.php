@extends('admin.home')

@section('main')
    <div class="row py-4">
        @if (session('success'))
            <div class="alert alert-success" role="alert">
                <p>{{session('success')}}</p>
            </div>
        @endif
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
                        <a class="nav-link @if ($key === 0) 'active' @endif" id="v-ills-home-tab" data-toggle="pill"
                           href="#{{$role->name}}" role="tab" aria-controls="{{$role->name}}" aria-selected="true">
                            {{__($role->name)}}
                        </a>
                    @endforeach
                </div>
            </div>
            <div class="col-md-3">
                <h3>{{__('Permissions')}}</h3>
                <div class="tab-content" id="v-pills-tabContent">
                    @foreach($roles as $key => $role)
                        <div class="tab-pane fade show @if ($key === 0) 'active' @endif" id="{{$role->name}}" role="tabpanel" aria-labelledby="v-pills-home-tab">
                            <form action="{{route('roles.update', $role->id)}}" method="post">
                                @csrf
                                @method('PUT')
                                <ul class="list-group list-group-scroll">
                                    @foreach ($permissions as $id => $name)
                                        <li class="list-group-item-action text-right">
                                            <label for="perm{{$id}}">{{$name}}</label>
                                            <input class="nv-check-box" type="checkbox" id="perm{{$id}}" name="permissions[]" value="{{$id}}"
                                                   @if($role->hasDirectPermission($name, 'admin')) checked @endif>
                                        </li>
                                    @endforeach
                                </ul>
                                <button type="submit" class="btn btn-block btn-success">{{__('Update permissions')}}</button>
                            </form>
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
