@extends('admin.home')

@section('main')
    <div class="container-fluid">
        <create-order :products="{{$products}}"></create-order>
    </div>
@endsection
