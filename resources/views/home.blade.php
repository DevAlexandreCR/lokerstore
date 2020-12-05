@extends('layouts.app')

@section('content')
@auth()
    @if ( !auth()->user()->hasVerifiedEmail() )
        <div class="container py-2">
            @if (session('resent'))
                <div class="alert alert-success" role="alert">
                    {{ trans('passwords.email_resend') }}
                </div>
            @endif
            <div class="alert alert-dismissible alert-warning fade show" role="alert">
                <strong>{{ trans('passwords.link_verify') }}</strong>
                <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                    @csrf
                    <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ trans('passwords.email_verify') }}</button>.
                </form>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
            </div>
        </div>
    @endif
@endauth
<div>
    <transition appear>
      <router-view></router-view>
    </transition>
</div>
@endsection
