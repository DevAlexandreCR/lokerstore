@extends('admin.home')

@section('main')
<div class="container">
    <div class="row justify-content-center">
        <div class="row"> edit
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