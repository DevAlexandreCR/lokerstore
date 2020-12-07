@extends('admin.home')

@section('main')
    <div class="row py-2">
        <div class="container shadow-sm py-4 bg-secondary">
            <button type="button" data-toggle="modal" data-target="#addRole"class="btn btn-dark">{{trans('roles.add')}}</button>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 card py-2"><h3>{{trans('roles.remove')}}</h3>
                <table class="table">
                    <thead>
                        @foreach($roles as $key => $role)
                            <tr class="align-middle">
                                <th>{{trans($role->name)}}</th>
                                <td>
                                    <form class="flex-column" action="{{route('roles.destroy', $role->id)}}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger"
                                                @if($role->name === 'Administrator') disabled="disabled"@endif><ion-icon name="trash"></ion-icon></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </thead>
                </table>
            </div>
            <div class="col-md-4">
                <h3>{{trans_choice('roles.role', 2, ['role_count' => ''])}}</h3>
                <div class="nav nav-pills card py-2" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    @foreach($roles as $key => $role)
                        <a class="nav-link btn-block @if ($key === 0) 'active' @endif" id="v-ills-home-tab" data-toggle="pill"
                           href="#{{$role->name}}" role="tab" aria-controls="{{$role->name}}" aria-selected="true">
                            {{trans('roles.view_permissions') }} {{trans($role->name)}}
                        </a>
                    @endforeach
                </div>
            </div>
            <div class="col-md-5">
                <h3>{{trans_choice('roles.permission', 2, ['permission_count' => ''])}}</h3>
                <div class="tab-content card" id="v-pills-tabContent">
                    @foreach($roles as $key => $role)
                        <div class="tab-pane fade  @if ($key === 0) 'show active' @endif" id="{{$role->name}}" role="tabpanel" aria-labelledby="v-pills-home-tab">
                            @if($role->name === 'Administrator')
                                <div class="jumbotron">
                                    <h1>{{trans('roles.admin')}}</h1>
                                    <p class="lead">{{trans('roles.messages.all')}}</p>
                                </div>
                            @else
                            <form action="{{route('roles.update', $role->id)}}" method="post">
                                @csrf
                                @method('PUT')
                                <ul class="list-group list-group-scroll">
                                    @foreach ($permissions as $id => $name)
                                        <li class="list-group-item-action text-right">
                                            <label for="perm{{$id}}">{{trans($name)}}</label>
                                            <input class="custom-checkbox ml-4 mr-2" type="checkbox" id="perm{{$id}}" name="permissions[]" value="{{$id}}"
                                                   @if($role->hasDirectPermission($name)) checked @endif>
                                        </li>
                                    @endforeach
                                </ul>
                                <button type="submit" class="btn btn-block btn-success">{{trans('roles.update')}}</button>
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
                    <h5 class="modal-title">{{trans('roles.add')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('roles.store')}}" method="post">
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="name">{{trans('fields.name')}}</label>
                            <input class="form-control" type="text" name="name" id="name">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">{{trans('actions.save')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
