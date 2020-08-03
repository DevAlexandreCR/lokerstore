@extends('layouts.app')

@section('content')

<div class="container">
    <div class="card">
        <div class="card-header">
            {{__('Usuario inhabilitado')}}
        </div>
        <div class="card-body">
            <h4 class="card-title">{{__('Comunicate con nosotros')}}</h4>
            <p class="card-text">{{__('Lamentamos informarte que tu usuario ha sido bloqueado 
            para más información escríbemos a support@lokerstore.com')}}</p>
        </div>
        <div class="card-footer text-muted">
            {{__('support@lokerstore.com')}}
        </div>
    </div>
</div>
@endsection