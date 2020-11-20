@extends('admin.home')

@section('main')
    <div class="container">
        @if (session('success'))
            <div class="container py-2">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only">Close</span>
                    </button>
                    <strong>{{trans('actions.success')}}</strong> {{ session('success') }}
                </div>
            </div>
        @endif
        <div class="row my-4">
            <div class="col-lg-6">
                <h4>{{trans('users.data')}}</h4>
                <form action="{{route('admins.update', $admin->id)}}" method="post">
                    @csrf
                    @method('PUT')
                    <table class="table table-responsive-sm">
                        <thead>
                        <tr>
                            <th class="align-middle">{{trans('users.name')}}:</th>
                            <td><input class="form-control" type="text" name="name" id="name" value="{{$admin->name}}"></td>
                        </tr>
                        <tr>
                            <th class="align-middle">{{trans('users.email')}}:</th>
                            <td>
                                <input class="form-control" type="email" name="email" value="{{$admin->email}}" id="email" autocomplete="nope">
                            </td>
                        </tr>
                        <tr>
                            <th class="align-middle">{{trans('fields.status')}}:</th>
                            <td>
                                <select class="form-control" type="text" name="is_active" id="is_active">
                                    <option value="0" @if (!$admin->is_active) selected @endif>{{trans('actions.disabled')}}</option>
                                    <option value="1" @if ($admin->is_active) selected @endif>{{trans('actions.enabled')}}</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th class="align-top">{{trans('Roles')}}:</th>
                            <td>
                                <ul>
                                    @foreach($roles as $key => $role)
                                        <li class="text-right">
                                            <label class="mr-2" for="perm{{$key}}">{{__($role->name)}}</label>
                                            <input class="custom-checkbox text-right" type="checkbox" id="perm{{$key}}" name="roles[]" value="{{$role->id}}"
                                                   @if($admin->hasRole($role->name)) checked @endif>
                                        </li>
                                    @endforeach
                                </ul>
                            </td>
                        </tr>
                        </thead>
                    </table>
                        <button type="submit" class="btn btn-success btn-block my-3">{{trans('users.update')}}</button>
                </form>
            </div>
            <div class="col-lg-6">
                <h3>{{trans_choice('roles.permission', 2, ['permission_count' => ''])}}</h3>
                <div class="tab-content" id="v-pills-tabContent">
                    @if($admin->hasRole('Administrator'))
                        <div class="jumbotron">
                            <h1 >{{trans('roles.admin')}}</h1>
                            <p class="lead">{{trans('roles.messages.all')}}</p>
                        </div>
                    @else
                        <form action="{{route('update-permissions', $admin->id)}}" method="post">
                            @csrf
                            @method('PUT')
                            <ul class="list-group list-group-scroll">
                                @foreach ($permissions as $id => $name)
                                    <li class="list-group-item-action text-right">
                                        @foreach($admin->roles as $role)
                                            @if($role->hasPermissionTo($name)) {{trans('roles.messages.permission_form_rol')}}:  @endif
                                        @endforeach
                                        <label for="perm{{$id}}">{{trans($name)}}</label>
                                        <input class="nv-check-box" type="checkbox" id="perm{{$id}}" name="permissions[]" value="{{$id}}"
                                               @if($admin->hasPermissionTo($name)) checked @endif
                                                @foreach($admin->roles as $role)
                                                    @if($role->hasPermissionTo($name, 'admin')) disabled @endif
                                                @endforeach
                                               >
                                    </li>
                                @endforeach
                            </ul>
                            <button type="submit" class="btn btn-block btn-success">{{trans('roles.update')}}</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
