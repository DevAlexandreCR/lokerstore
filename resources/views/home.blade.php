@extends('layouts.app')

@section('content')
@auth()
    @if ( !auth()->user()->hasVerifiedEmail() )
        <div class="container py-2">
            @if (session('resent'))
                <div class="alert alert-success" role="alert">
                    {{ __('A fresh verification link has been sent to your email address.') }}
                </div>
            @endif
            <div class="alert alert-dismissible alert-warning fade show" role="alert">
                <strong>{{ __('Before proceeding, please check your email for a verification link.') }}</strong>
                <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                    @csrf
                    <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('Verify Email Address') }}</button>.
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
    <transition name="slide">
      <router-view></router-view>
    </transition>
</div>
@endsection
