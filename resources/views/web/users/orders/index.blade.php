@extends('web.users.main')

@section('user-main')
    <ul class="list-group">
        @foreach($orders as $order)
            <li class="list-group-item">{{$order}}</li>
        @endforeach
    </ul>
@endsection
