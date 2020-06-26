@extends('layouts.app')

@section('content')
@if ( session('updated'))
    
<div class="container">
  <div class="alert alert-success" role="alert">
    <strong>{{ session('updated') }}</strong>
  </div>
</div>

@endif
<div class="container">
    <div class="row justify-content-center">
        <div class="row">
            <div class="card shadow" style="max-width: 200px; margin:10px">
                <div class="card-header">{{$user->name}}</div>
              <div class="card-body">
                <blockquote class="blockquote">
                  <p>{{$user->email}}</p>
                  <footer class="card-blockquote">Precio: <strong>{{$user->is_active}}</strong></footer>
                </blockquote>
              </div>
            </div>
        </div>
    </div>
</div>
@endsection