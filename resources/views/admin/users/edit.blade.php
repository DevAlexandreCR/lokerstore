@extends('admin.home')

@section('main')
<div class="container py-4" style="max-width: 80%">
    <div class="card shadow">
      <div class="modal-header bg-light">
        <h5 class="modal-title">{{ trans('users.update') }}</h5>
        <a href="{{ route('users.show' , ['user' => $user]) }}" class="btn btn-link"><ion-icon name="return-up-back-outline"></ion-icon></a>
      </div>
      <div class="card-body">
        <form action="{{route('users.update', ['user' => $user])}}" method="POST">
          @csrf
          @method('PUT')
          @switch($input_name)
              @case('name')
                  <div class="form-group">
                    <label for="name">{{ trans('user.name') }}</label>
                  <input type="name" class="form-control @error('name') is-invalid @enderror" id="name" required placeholder="{{$user->name}}"
                    name="name" aria-describedby="nameHelp" value="{{ old('name') }}">
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="lastname">{{trans('users.last_name')}}</label>
                    <input type="name" class="form-control @error('lastname') is-invalid @enderror" id="lastname" required placeholder="{{$user->lastname}}"
                    name="lastname" aria-describedby="lastnameHelp" value="{{ old('lastname') }}">
                    @error('lastname')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                  </div>
                  @break
              @case('email')
                  <div class="form-group">
                    <label for="email">{{trans('users.email')}}</label>
                  <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" required placeholder="{{$user->email}}"
                    name="email" aria-describedby="emailHelp" value="{{ old('email') }}">
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                  </div>
                  @break
              @case('phone')
                  <div class="form-group">
                    <label for="phone">{{trans('users.phone')}}</label>
                  <input type="number" class="form-control @error('phone') is-invalid @enderror" id="phone" required placeholder="{{$user->phone}}"
                    name="phone" aria-describedby="phoneHelp" value="{{ old('phone') }}">
                    @error('phone')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                  </div>
                  @break
              @case('address')
                  <div class="form-group">
                    <label for="address">{{trans('users.address')}}</label>
                  <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" required placeholder="{{$user->address}}"
                    name="address" aria-describedby="phoneHelp" value="{{ old('address') }}">
                    @error('address')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                  </div>
                  @break
              @case('is_active')
              @if ($user->is_active)
              <div class="alert alert-danger" role="alert">
                <strong>{{trans('users.messages.disable')}}</strong>
              <a href="{{ route('users.show' , ['user' => $user]) }}" type="button" class="btn btn-secondary btn-sm" style="float: right">{{trans('actions.back')}}</a>
              </div>
              @endif
                  <div class="row">
                    <div class="col">
                      <h6 class="card-title"> {{trans('fields.status')}} </h6>
                    </div>
                    @if ($user->is_active)
                    <div class="col">
                      <p class="card-text">{{trans('actions.enabled')}}</p>
                    </div>
                      <div class="col-sm-2">
                        <input type="hidden" name="is_active" value="0">
                        <button type="submit" class="btn btn-danger btn-sm">{{trans('actions.disable')}}</button>
                        </div>
                      @else
                      <div class="col">
                      <p class="card-text">{{trans('actions.disabled')}}</p>
                    </div>
                      <div class="col-sm-2">
                      <input type="hidden" name="is_active" value="1">
                        <button type="submit" class="btn btn-primary btn-sm">{{trans('actions.enable')}}</button>
                        </div>
                      @endif
                  </div>
                  @break
              @case('delete')
              <form action="{{route('users.destroy', ['user' => $user])}}" method="POST">
                @csrf
                @method('DELETE')
                <div class="alert alert-danger" role="alert">
                  <strong>{{trans('users.messages.remove')}}
                    <ion-icon name="skull-outline"></ion-icon>
                    <ion-icon name="alert-circle-outline"></ion-icon>
                    <ion-icon name="hand-left-outline"></ion-icon></strong>
                <a href="{{ route('users.show' , ['user' => $user]) }}" type="button" class="btn btn-secondary btn-sm" style="float: right">{{trans('actions.back')}}</a>
                </div>
                <div class="row">
                <div class="col">
                </div>
                <div class="col-sm-2">
                  <input type="hidden" name="is_active" value="1">
                  <button type="submit" class="btn btn-danger btn-block btn-sm">{{trans('actions.remove')}}</button>
                </div>
                </div>
              </form>
                  @break
              @default
                  <div class="form-group">
                    <div class="alert alert-info" role="alert">
                      <strong>{{trans('messages.lost')}}</strong>
                        <?php $input_name = 'lost' ?>;
                    </div>
                  </div>
          @endswitch
          @if ($input_name === 'lost')
                <a href="{{route('users.index')}}" class="btn btn-primary">{{trans('actions.back')}}</a>
          @elseif ($input_name === 'is_active' || $input_name === 'delete')
                <br>
          @else
                <button type="submit" class="btn btn-primary">{{trans('actions.save_changes')}}</button>
          @endif
        </form>
      </div>
    </div>
</div>
@endsection
