@extends('web.users.main')

@section('sidebar')
    <aside class="col-12 col-md-2 p-0 bg-light flex-shrink-1">
        <nav class="navbar navbar-expand navbar-light bg-light flex-md-column flex-row align-items-center py-2">
            <div class="collapse navbar-collapse w-100 p-0">
                <ul class="flex-md-column flex-row navbar-nav w-100 justify-content-between">
                    <li class="nav-item">
                        <a class="nav-link pl-0 py-md-4"
                        ><ion-icon class="mr-2" name="home-outline"></ion-icon><span class="font-weight-bold">{{trans('users.account')}}</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pl-0 {{ ! Route::is('user.profile') ?: 'font-weight-bolder'}}"
                           href="{{ route('user.profile', auth()->id()) }}"
                        ><ion-icon class="mr-2" name="person-circle-outline"></ion-icon><span class="d-none d-md-inline">{{trans('users.profile')}}</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pl-0 {{ ! Route::is('cart.show') ?: 'font-weight-bolder'}}"
                           href="{{ route('cart.show', auth()->id()) }}"
                        ><ion-icon  class="mr-2" name="cart-outline"></ion-icon><span class="d-none d-md-inline">{{trans('users.cart')}}</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pl-0 {{ ! Route::is('user.orders.index') ?: 'font-weight-bolder'}}"
                           href="{{ route('user.orders.index', auth()->id()) }}"
                        ><ion-icon class="mr-2" name="pricetags-outline"></ion-icon><span class="d-none d-md-inline">{{trans_choice('orders.orders', 2, ['orders_count' => ''])}}</span></a>
                    </li>
                </ul>
            </div>
        </nav>
    </aside>
@endSection
