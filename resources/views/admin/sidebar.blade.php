@extends('admin.home')

@section('sidebar')
    <aside class="col-12 col-md-2 p-0 bg-light card-product flex-shrink-1">
        <nav class="navbar navbar-expand navbar-light  card-product flex-md-column flex-row align-items-center py-2">
            <div class="collapse navbar-collapse w-100 p-0">
                <ul class="flex-md-column flex-row navbar-nav w-100 justify-content-between ml-md-4 mt-md-4">
                    <li class="nav-item">
                        <a class="list-group-item-action p-md-4 {{ ! Route::is('admin.home') ?: 'font-weight-bolder'}}"
                           href="{{ route('admin.home') }}"
                        >
                            <ion-icon class="mr-2" name="home-outline"></ion-icon>
                            <span class="font-weight-bold">{{trans('fields.home')}}</span></a>
                    </li>
                    @can('viewAny', \App\Models\Order::class)
                        <li class="nav-item mt-md-4 p-md-2">
                            <a class="list-group-item-action pl-0 text-lg-left {{ ! Route::is('orders.index') ?: 'font-weight-bolder'}}"
                               href="{{ route('orders.index') }}"
                            >
                                <ion-icon class="mr-2" class="mr-2" name="bookmarks-outline"></ion-icon>
                                <span
                                    class="d-none d-md-inline">{{trans_choice('orders.orders', 2, ['orders_count' => ''])}}</span></a>
                        </li>
                    @endcan
                    @can('viewAny', \App\Models\Admin\Admin::class)
                        <li class="nav-item p-md-2">
                            <a class="list-group-item-action text-lg-left {{ ! Route::is('admins.index') ?: 'font-weight-bolder'}}"
                               href="{{ route('admins.index') }}"
                            >
                                <ion-icon class="mr-2" name="people-circle-outline"></ion-icon>
                                <span class="d-none d-md-inline">{{trans('fields.staff')}}</span></a>
                        </li>
                    @endcan
                    @can('viewAny', \App\Models\User::class)
                        <li class="nav-item p-md-2">
                            <a class="list-group-item-action pl-0 text-lg-left {{ ! Route::is('users.index') ?: 'font-weight-bolder'}}"
                               href="{{ route('users.index') }}"
                            >
                                <ion-icon class="mr-2" name="people-outline"></ion-icon>
                                <span
                                    class="d-none d-md-inline">{{trans_choice('users.user', 2, ['user_count' => ''])}}</span></a>
                        </li>
                    @endcan
                    @can('viewAny', \App\Models\Product::class)
                        <li class="nav-item p-md-2">
                            <a class="list-group-item-action pl-0 text-lg-left {{ ! Route::is('products.index') ?: 'font-weight-bolder'}}"
                               href="{{ route('products.index') }}"
                            >
                                <ion-icon class="mr-2" name="list-circle-outline"></ion-icon>
                                <span
                                    class="d-none d-md-inline">{{trans_choice('products.product', 2, ['product_count' => ''])}}</span></a>
                        </li>
                    @endcan
                    @can('viewAny', \App\Models\Category::class)
                        <li class="nav-item p-md-2">
                            <a class="list-group-item-action pl-0 text-lg-left {{ ! Route::is('category.index') ?: 'font-weight-bolder'}}"
                               href="{{ route('category.index') }}"
                            >
                                <ion-icon class="mr-2" name="copy-outline"></ion-icon>
                                <span class="d-none d-md-inline">{{trans('products.category')}}</span></a>
                        </li>
                    @endcan
                    @can('viewAny', \App\Models\Tag::class)
                        <li class="nav-item p-md-2">
                            <a class="list-group-item-action pl-0 text-lg-left {{ ! Route::is('tags.index') ?: 'font-weight-bolder'}}"
                               href="{{ route('tags.index') }}"
                            >
                                <ion-icon class="mr-2" name="pricetags-outline"></ion-icon>
                                <span class="d-none d-md-inline">{{trans('fields.tags')}}</span></a>
                        </li>
                    @endcan
                    @can('viewAny', \App\Models\Roles::class)
                        <li class="nav-item p-md-2">
                            <a class="list-group-item-action pl-0 text-lg-left {{ ! Route::is('roles.index') ?: 'font-weight-bolder'}}"
                               href="{{ route('roles.index') }}"
                            >
                                <ion-icon class="mr-2" class="mr-2" name="lock-open-outline"></ion-icon>
                                <span
                                    class="d-none d-md-inline">{{trans_choice('roles.role', 2, ['role_count' => ''])}}</span></a>
                        </li>
                    @endcan
                </ul>
            </div>
        </nav>
    </aside>
@endSection
