@extends('admin.home')

@section('main')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div class="container py-2">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <strong>{{__('Success!')}}</strong> {{ session('success') }}
            </div>
        </div>
    @endif
    <div class="row m-2 p-4 shadow-sm bg-secondary">
        <div class="col-md-2 col-sm-6">
            <strong class="d-none ml-2 d-sm-block text-muted navbar-brand">{{__('Orders')}}</strong>
        </div>
        <div class="col-md-10 col-sm-6 justify-content-end">
            <form class="form-inline justify-content-end my-2 my-lg-0" method="GET" action="{{route('orders.index')}}">
                <label for="status" class="mr-1">{{__('Status')}}</label>
                <select name="status" class="form-control form-control-sm mr-sm-2">
                    @foreach(\App\Constants\Orders::getClientStatus() as $key => $st)
                        <option value="{{$key}}"
                            @if($status === $key)
                                selected
                            @elseif($key === \App\Constants\Orders::STATUS_PENDING_SHIPMENT && !$status)
                                selected
                            @endif
                        >{{$st}}</option>
                    @endforeach
                </select>
                <label for="datetime" class="mr-1">{{__('Date')}}</label>
                <input class="form-control form-control-sm mr-sm-2" type="date" name="date"
                       id="datetime" placeholder="{{$date}}">
                <input class="form-control form-control-sm mr-sm-2" type="text" name="email"
                       aria-label="Search" placeholder="@if($email) {{$email}} @else {{__('Search user')}} @endif">
                <button class="btn btn-outline-primary btn-sm my-2 my-sm-0" type="submit">{{__('Search')}}</button>
            </form>
        </div>
    </div>
    <div class="container" role="alert">
        <a class="btn btn-sm btn-link" href="{{route('orders.index')}}">{{__('See all orders')}}</a>
    </div>
    <div class="container py-2">
        <table class="table table-hover table-striped table-condensed table-secondary table-sm table-responsive-md">
            <thead>
                <tr class="text-left">
                    <th>{{__('Id')}}</th>
                    <th>{{__('Created at')}}</th>
                    <th>{{__('Status')}}</th>
                    <th>{{__('Amount')}}</th>
                    <th>{{__('User')}}</th>
                    <th>{{__('Actions')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <td>{{$order->id}}</td>
                        <td>{{$order->created_at}}</td>
                        <td>{{$order->getStatus()}}</td>
                        <td>{{$order->amount}}</td>
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
        {{ $orders->links() }}<strong class="mx-2"> {{__('Orders')}}: </strong>{{ $orders->count()}}
    </div>
@endsection
