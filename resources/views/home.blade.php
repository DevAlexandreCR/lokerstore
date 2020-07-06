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
<div class="container" id="app">
  hola home
  <router-view></router-view>
</div>
@endsection
