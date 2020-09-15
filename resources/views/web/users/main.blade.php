@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-2 p-0" style="z-index: 1">
                @yield('sidebar',View::make('web.users.sidebar'))
            </div>
            <div class="col">
                @yield('user-main')
            </div>
        </div>
    </div>
@endsection
