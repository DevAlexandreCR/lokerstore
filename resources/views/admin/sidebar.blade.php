@extends('admin.home')

@section('sidebar')
<div class="nav flex-column shadow" aria-orientation="vertical" 
    style="position: fixed;
    width: 16%;
    background: rgb(250, 247, 237);
    height: 100vh;">
    <nav id="sidebar" class="nav flex-column">
        <div class="card-header" >
        <a class="flex-sm-fill text-sm-center nav-link {{ ! Route::is('admin.home') ?: 'active'}}" 
        href="{{ route('admin.home') }}"
        style="color: black"
        >{{__('Home')}}</a>
        </div>
        <br>
        <a class="flex-sm-fill text-sm-center nav-link {{ ! Route::is('admin.home') ?: 'active'}}"
         href="{{ route('users.index') }}"
         style="color: black"
         >{{__('Users')}}</a>
    </nav>
</div>    
@endSection