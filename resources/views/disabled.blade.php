@extends('layouts.app')

@section('content')

<div class="container">
    <div class="card">
        <div class="card-header">
            {{trans('users.messages.disabled')}}
        </div>
        <div class="card-body">
            <h4 class="card-title">{{trans('users.messages.contact_us')}}</h4>
            <p class="card-text">{{trans('users.messages.contact') . config('app.support')}}</p>
        </div>
        <div class="card-footer text-muted">
            {{config('app.support')}}
        </div>
    </div>
</div>
@endsection
