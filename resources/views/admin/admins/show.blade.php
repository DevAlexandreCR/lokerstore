@extends('admin.home')

@section('main')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <form action="{{route('admins.store')}}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="name">{{__('Name')}}</label>
                        <input class="form-control" type="text" name="name" id="name" value="{{$admin->name}}">
                        <label for="email">{{__('Email Address')}}</label>
                        <input class="form-control" type="email" name="email" value="{{$admin->email}}" id="email" autocomplete="nope">
                        <label for="status">{{__('Status')}}</label>
                        <select class="form-control" type="password" name="status" id="status">
                            <option value="0" selected>{{__('Disabled')}}</option>
                            <option value="1">{{__('Enabled')}}</option>
                        </select>
                        <label for="role">{{__('Roles')}}</label>
                        <select class="form-control" type="text" name="role" id="role">
                            @foreach($roles as $id => $name)
                                <option value="{{$id}}">{{__($name)}}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>
            <div class="col-md-6"></div>
        </div>
    </div>
@endsection
