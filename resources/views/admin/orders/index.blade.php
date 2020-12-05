@extends('admin.home')

@section('main')
    <div class="row m-2 p-4 shadow-sm bg-secondary">
        <div class="col-md-2 col-sm-6 d-inline">
            <div class="form-inline">
                <strong class="d-none ml-2 d-sm-block text-muted navbar-brand">{{trans_choice('orders.orders', 2, ['orders_count' => ''])}}</strong>
                <a href="{{route('orders.create')}}" type="button" class="btn btn-dark d-inline float-left" aria-expanded="false">
                    +
                </a>
            </div>
        </div>
        <div class="col-md-10 col-sm-6 justify-content-end">
            <form class="form-inline justify-content-end my-2 my-lg-0" method="GET" action="{{route('orders.index')}}">
                <label for="status" class="mr-1">{{trans('fields.status')}}</label>
                <select name="status" class="form-control form-control-sm mr-sm-2">
                    <option value="">{{ trans('api.choose_option') }}</option>
                    @foreach(\App\Constants\Orders::getClientStatus() as $key => $st)
                        <option value="{{$key}}"
                            @if($status === $key)
                                selected
                            @endif
                        >{{$st}}</option>
                    @endforeach
                </select>
                <label for="dateFrom" class="mr-1">{{trans('reports.from')}}</label>
                <input class="form-control form-control-sm mr-sm-2" type="date" name="from"
                       id="dateFrom" value="{{$from}}">
                <label for="dateUnitl" class="mr-1">{{trans('reports.until')}}</label>
                <input class="form-control form-control-sm mr-sm-2" type="date" name="until"
                       id="dateUntil" value="{{$until}}">
                <input class="form-control form-control-sm mr-sm-2" type="text" name="email"
                       aria-label="Search" placeholder="@if($email) {{$email}} @else {{trans('orders.search_user')}} @endif">
                <button class="btn btn-outline-primary btn-sm my-2 my-sm-0" type="submit">{{trans('orders.search')}}</button>
            </form>
        </div>
    </div>
    <div class="container" role="alert">
        <a class="btn btn-sm btn-link" href="{{route('orders.index')}}">{{trans('orders.see')}}</a>
    </div>
    <div class="container py-2">
        <table class="table table-hover table-striped table-condensed table-secondary table-sm table-responsive-md">
            <thead>
                <tr class="text-left">
                    <th>{{trans('fields.id')}}</th>
                    <th>{{trans('fields.created_at')}}</th>
                    <th>{{trans('fields.status')}}</th>
                    <th>{{trans('fields.amount')}}</th>
                    <th>{{trans_choice('users.user',1 , ['user_count' => ''])}}</th>
                    <th>{{trans('fields.actions')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <td>{{$order->id}}</td>
                        <td>{{$order->created_at}}</td>
                        <td>{{$order->getStatus()}}</td>
                        <td>$ {{number_format($order->amount, 2, ',', '.')}}</td>
                        <td>{{$order->user->email ?? '--'}}</td>
                        <td>
                            <div class="btn-group btn-block btn-group-sm text-center">
                                <form action="{{route('orders.destroy', $order->id)}}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger mx-2">
                                        <ion-icon name="trash"></ion-icon>
                                    </button>
                                </form>
                                <form action="{{route('orders.show', $order->id)}}" method="get">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-blue">
                                        <ion-icon name="create"></ion-icon>
                                    </button>
                                </form>
                            </div>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="container form-inline justify-content-center">
        {{ $orders->withQueryString()->links() }}<strong class="mx-2"> {{trans_choice('orders.orders', $orders->count(), ['orders_count' => $orders->count()])}} </strong>
    </div>
@endsection
