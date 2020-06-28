@extends('admin.home')

@section('main')
@if ( session('updated'))
    
<div class="container">
  <div class="alert alert-success" role="alert">
    <strong>{{ session('updated') }}</strong>
  </div>
</div>

@endif
<div class="container py-3" style="max-width: 50rem">
  <div class="card shadow">
    <div class="modal-header bg-light">
      <h5 class="card-title">{{ __('User info') }}</h5>
      <button type="button" class="close" aria-label="Close">
      <a href="{{ url()->previous() }}"><span aria-hidden="true">&times;</span></a>
      </button>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col">
          <h6 class="card-title"> {{__('Name and lastname')}} </h6>
        </div>
        <div class="col">
        <p class="card-text">{{ $user->name }}</p>
        </div>
      </div>
      <div class="row">
        <div class="col">
          <h6 class="card-title"> {{__('E-Mail Address')}} </h6>
        </div>
        <div class="col">
        <p class="card-text">{{ $user->email }}</p>
        </div>
      </div>
      <div class="row">
        <div class="col">
          <h6 class="card-title"> {{__('Phone')}} </h6>
        </div>
        <div class="col">
        <p class="card-text">{{ $user->phone }}</p>
        </div>
      </div>
      <div class="row">
        <div class="col">
          <h6 class="card-title"> {{__('Address')}} </h6>
        </div>
        <div class="col">
        <p class="card-text">{{ $user->address }}</p>
        </div>
      </div>
      <div class="row">
        <div class="col">
          <h6 class="card-title"> {{__('Registration date')}} </h6>
        </div>
        <div class="col">
        <p class="card-text">{{ $user->created_at->format('d-m-Y') }}</p>
        </div>
      </div>
      <div class="row">
        <div class="col">
          <h6 class="card-title"> {{__('Status')}} </h6>
        </div>
        <div class="col">
          @if ($user->is_active)
          <p class="card-text">{{__('Active')}}</p>
          @else
          <p class="card-text">{{__('Inactive')}}</p>
          @endif
        </div>
      </div>
      <div class="row">
        <div class="col">
          <h6 class="card-title"> {{__('User verified')}} </h6>
        </div>
        <div class="col">
          @if ($user->email_verified_at === null)
          <p class="card-text">{{__('No')}}</p>
          @else
          <p class="card-text">{{__('Yes')}}</p>
          @endif
        </div>
      </div>
      <div class="row">
        <div class="col"></div>
        <div class="col">
          <div class="btn-group  btn-group-sm " 
           role="group" 
           style="float: right; margin-bottom: -50%;"
           aria-label="Basic example">
            <a class="btn btn-danger rounded-circle shadow" 
            href="{{route('users.edit', ['user' => $user])}}">
              <ion-icon name="pencil-sharp" style="width: 30px; height: 30px;"></ion-icon>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection