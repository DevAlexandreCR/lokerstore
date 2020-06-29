@extends('layouts.app')

@section('content')
@if ( session('verify_email'))
<div class="container py-2">
    <div class="alert alert-dismissible alert-warning fade show" role="alert">
        <strong>{{ session('verify_email') }}</strong>
        <form class="d-inline" method="GET" action="{{ route('verification.notice') }}">
          @csrf
          <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
      </form>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        <span class="sr-only">Close</span>
      </button>
    </div>
</div>    
@endif
<div class="container">
    <div class="row justify-content-center">
        <div class="row">
            @foreach ($products as $product)
            <div class="card shadow" style="max-width: 200px; margin:10px">
                <div class="card-header">{{$product->name}}</div>
              <div class="card-body">
                <blockquote class="blockquote">
                  <p>{{$product->description}}</p>
                  <footer class="card-blockquote">Precio: <strong>{{$product->price}}</strong></footer>
                </blockquote>
              </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
