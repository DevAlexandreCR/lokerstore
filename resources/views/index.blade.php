@extends('layouts.app')

@section('content')
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
