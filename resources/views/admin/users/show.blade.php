@extends('admin.home')

@section('main')
@if ( session('updated'))
    
<div class="container py-2">
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
      <span class="sr-only">Close</span>
    </button>
    <strong>{{__('Update success!')}}</strong> {{ session('updated') }}
  </div>
</div>

@endif
<div class="container py-3" style="max-width: 80%">
  <div class="card shadow">
    <div class="modal-header bg-light">
      <h5 class="modal-title">{{ __('User info') }}</h5>
      <button class="btn" type="button">
        <a href="{{ route('users.index') }}"><ion-icon name="return-up-back-outline"></ion-icon></a>
      </button>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col">
          <h6 class="card-title"> {{__('Name and lastname')}} </h6>
        </div>
        <div class="col">
        <p class="card-text">{{ $user->name }} {{$user->lastname}}</p>
        </div>
        <div class="col-sm-1">
        <a href="{{ route('users.edit', ['user' => $user, 'p' => 'name'])}}"><ion-icon name="chevron-forward-outline"></ion-icon></a>
        </div>
      </div>
      <hr>
      <div class="row">
        <div class="col">
          <h6 class="card-title"> {{__('E-Mail Address')}} </h6>
        </div>
        <div class="col">
        <p class="card-text">{{ $user->email }}</p>
        </div>
        <div class="col-sm-1">
          <a href="{{ route('users.edit', ['user' => $user, 'p' => 'email'])}}"><ion-icon name="chevron-forward-outline"></ion-icon></a>
          </div>
      </div>
      <hr>
      <div class="row">
        <div class="col">
          <h6 class="card-title"> {{__('Phone')}} </h6>
        </div>
        <div class="col">
        <p class="card-text">{{ $user->phone }}</p>
        </div>
        <div class="col-sm-1">
          <a href="{{ route('users.edit', ['user' => $user, 'p' => 'phone'])}}"><ion-icon name="chevron-forward-outline"></ion-icon></a>
          </div>
      </div>
      <hr>
      <div class="row">
        <div class="col">
          <h6 class="card-title"> {{__('Address')}} </h6>
        </div>
        <div class="col">
        <p class="card-text">{{ $user->address }}</p>
        </div>
        <div class="col-sm-1">
          <a href="{{ route('users.edit', ['user' => $user, 'p' => 'address'])}}"><ion-icon name="chevron-forward-outline"></ion-icon></a>
        </div>
      </div>
      <hr>
      <div class="row">
        <div class="col">
          <h6 class="card-title"> {{__('Registration date')}} </h6>
        </div>
        <div class="col">
        <p class="card-text">{{ $user->created_at->format('d-m-Y') }}</p>
        </div>
        <div class="col-sm-1">
          <a href=""><ion-icon name="lock-closed-outline"></ion-icon></a>
        </div>
      </div>
      <hr>
      <div class="row">
        <div class="col">
          <h6 class="card-title"> {{__('Status')}} </h6>
        </div>
        <div class="col">
          @if ($user->is_active)
          <p class="card-text">{{__('Enabled')}}</p>
          @else
          <p class="card-text">{{__('Disabled')}}</p>
          @endif
        </div>
        <div class="col-sm-1">
          <a href="{{ route('users.edit', ['user' => $user, 'p' => 'is_active'])}}"><ion-icon name="chevron-forward-outline"></ion-icon></a>
        </div>
      </div>
      <hr>
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
        <div class="col-sm-1">
          <a href=""><ion-icon name="lock-closed-outline"></ion-icon></a>
        </div>
      </div>
      <div class="row">
        <div class="col"></div>
        <div class="col">
          <div class="btn-group  btn-group-sm " 
           role="group" 
           style="float: right; margin-bottom: -50%;">
            <a class="btn btn-danger rounded-circle shadow" 
            href="{{route('users.edit', ['user' => $user, 'p' => 'delete'])}}">
              <ion-icon name="trash" style="width: 30px; height: 30px;"></ion-icon>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection