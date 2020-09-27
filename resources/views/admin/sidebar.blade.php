@extends('admin.home')

@section('sidebar')
<div class="nav flex-column shadow" aria-orientation="vertical"
    style="position: fixed;
    width: 16%;
    background: rgb(250, 247, 237);
    height: 100vh;">
    <nav id="sidebar" class="nav flex-column">
        <div class="card-header" >
        <a class="flex-sm-fill text-sm-center nav-link  {{ ! Route::is('admin.home') ?: 'font-weight-bolder'}}"
        href="{{ route('admin.home') }}"
        style="color: black"
        >{{__('Home')}}</a>
        </div>
        <br>
        <a class="flex-sm-fill text-sm-center nav-link {{ ! Route::is('admins.index') ?: 'font-weight-bolder'}}"
           href="{{ route('admins.index') }}"
           style="color: black"
        >{{__('Staff')}}</a>
        <a class="flex-sm-fill text-sm-center nav-link {{ ! Route::is('users.index') ?: 'font-weight-bolder'}}"
         href="{{ route('users.index') }}"
         style="color: black"
         >{{__('Users')}}</a>
         <a class="flex-sm-fill text-sm-center nav-link {{ ! Route::is('products.index') ?: 'font-weight-bolder'}}"
         href="{{ route('products.index') }}"
         style="color: black"
         >{{__('Products')}}</a>
         <a class="flex-sm-fill text-sm-center nav-link {{ ! Route::is('category.index') ?: 'font-weight-bolder'}}"
         href="{{ route('category.index') }}"
         style="color: black"
         >{{__('Categories')}}</a>
         <a class="flex-sm-fill text-sm-center nav-link {{ ! Route::is('tags.index') ?: 'font-weight-bolder'}}"
         href="{{ route('tags.index') }}"
         style="color: black"
         >{{__('Tags')}}</a>
        <a class="flex-sm-fill text-sm-center nav-link {{ ! Route::is('roles.index') ?: 'font-weight-bolder'}}"
           href="{{ route('roles.index') }}"
           style="color: black"
        >{{__('Roles')}}</a>
        <a class="flex-sm-fill text-sm-center nav-link {{ ! Route::is('orders.index') ?: 'font-weight-bolder'}}"
           href="{{ route('orders.index') }}"
           style="color: black"
        >{{__('Orders')}}</a>
    </nav>
</div>
@endSection
