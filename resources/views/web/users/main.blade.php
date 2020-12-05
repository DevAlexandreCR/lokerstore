@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row min-vh-100 flex-column  flex-md-row">
            @yield('sidebar',View::make('web.users.sidebar'))
            <main class="col bg-faded py-3 flex-grow-1">
                @yield('user-main')
            </main>
        </div>
    </div>
@endsection
