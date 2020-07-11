@extends('admin.home')

@section('main')
@if ( session('user-updated'))
    
<div class="container py-2">
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
      <span class="sr-only">Close</span>
    </button>
    <strong>{{__('Success!')}}</strong> {{ __(session('user-updated')) }}
  </div>
</div>

@endif

<div class="container py-3" style="max-width: 80%">
  <edit-user-component :user='@json($user)'></edit-user-component>
</div>
@endsection