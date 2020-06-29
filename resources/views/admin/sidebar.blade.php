@extends('admin.home')

@section('sidebar')
<div class="nav flex-column bg-dark" aria-orientation="vertical" 
    style="position: fixed;
    width: 16%;
    height: 100vh;">
    <nav id="sidebar" class="nav flex-column">
        <div class="card-header" >
        <a class="flex-sm-fill text-sm-center nav-link {{ ! Route::is('admin.home') ?: 'active'}}" 
        href="{{ route('admin.home') }}"
        style="color: white"
        >{{__('Home')}}</a>
        </div>
        <br>
        <a class="flex-sm-fill text-sm-center nav-link {{ ! Route::is('admin.home') ?: 'active'}}"
         href="{{ route('users.index') }}"
         style="color: white"
         >{{__('Users')}}</a>
    </nav>
</div>    
@endSection