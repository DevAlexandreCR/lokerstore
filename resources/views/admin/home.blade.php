@extends('layouts.app')

@section('content')
<div class="container-fluid h-100">
    <div class="row">
        <div class="col-12 col-md-2 p-0">
            <div class="list-group">
            <a class="btn btn-primary" href="{{ route('users.index') }}">{{__('Users')}}</a>
            </div>
        </div>
        <div class="col">
            @yield('main') 
        </div>
    </div> 
</div>
@endsection