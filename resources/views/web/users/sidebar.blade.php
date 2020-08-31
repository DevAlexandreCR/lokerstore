@extends('web.users.main')

@section('sidebar')
    <div class="nav flex-column shadow" aria-orientation="vertical"
         style="position: fixed;
    width: 16%;
    background: rgb(250, 247, 237);
    height: 100vh;">
        <nav id="sidebar" class="nav flex-column">
            <div class="modal-header">
                <a class="flex-sm-fill text-sm-center navbar-brand"
                   style="color: black"
                >{{__('My Account')}}</a>
            </div>
            <br>
            <a class="flex-sm-fill text-sm-center nav-link {{ ! Route::is('user.profile') ?: 'font-weight-bolder'}}"
               href="{{ route('user.profile', auth()->id()) }}"
               style="color: black"
            >{{__('Profile')}}</a>
            <a class="flex-sm-fill text-sm-center nav-link {{ ! Route::is('cart.show') ?: 'font-weight-bolder'}}"
               href="{{ route('cart.show', auth()->id()) }}"
               style="color: black"
            >{{__('Cart')}}</a>
            <a class="flex-sm-fill text-sm-center nav-link {{ ! Route::is('user.orders.index') ?: 'font-weight-bolder'}}"
               href="{{ route('user.orders.index', auth()->id()) }}"
               style="color: black"
            >{{__('Orders')}}</a>
        </nav>
    </div>
@endSection
