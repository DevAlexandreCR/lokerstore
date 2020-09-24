@extends('admin.home')

@section('main')
    <div class="container py-4">
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
    </div>

    <div class="container">
        <table class="table table-hover table-sm">
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
                        <td>{{$order->status}}</td>
                        <td>{{$order->amount}}</td>
                        <td>{{$order->user->email}}</td>
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
@endsection
