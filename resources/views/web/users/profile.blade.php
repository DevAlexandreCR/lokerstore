@extends('web.users.main')

@section('user-main')
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
        <div class="container">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold">{{ __('User info') }}</h5>
                <a href="{{ route('users.index') }}" class="btn btn-link"><ion-icon name="return-up-back-outline"></ion-icon></a>
            </div>
            <form action="{{route('users.update', ['user' => $user])}}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="row">
                        <div class="col-3">
                            <h6 class="card-title text-right"> {{__('Name and lastname')}} </h6>
                        </div>
                        <div class="col">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <input type="name" disabled class="form-control unborder @error('name') is-invalid @enderror" id="name" required placeholder="{{$user->name}}"
                                           name="name" aria-describedby="nameHelp" value="{{ $user->name }}">
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <input type="name" disabled class="form-control unborder @error('lastname') is-invalid @enderror" id="lastname" required placeholder="{{$user->lastname}}"
                                           name="lastname" aria-describedby="lastnameHelp" value="{{ $user->lastname }}">
                                    @error('lastname')
                                    <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3">
                            <h6 class="card-title text-right"> {{__('E-Mail Address')}} </h6>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <input type="email" disabled class="form-control unborder @error('email') is-invalid @enderror" id="email" required placeholder="{{$user->email}}"
                                       name="email" aria-describedby="emailHelp" value="{{ $user->email }}">
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3">
                            <h6 class="card-title text-right"> {{__('Phone')}} </h6>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <input type="number" disabled class="form-control unborder @error('phone') is-invalid @enderror" id="phone" required placeholder="{{$user->phone}}"
                                       name="phone" aria-describedby="phoneHelp" value="{{ $user->phone }}">
                                @error('phone')
                                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3">
                            <h6 class="card-title text-right"> {{__('Address')}} </h6>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <input type="text"  disabled class="form-control unborder @error('address') is-invalid @enderror" id="address" required placeholder="{{$user->address}}"
                                       name="address" aria-describedby="phoneHelp" value="{{ $user->address }}">
                                @error('address')
                                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3">
                            <h6 class="card-title text-right"> {{__('Registration date')}} </h6>
                        </div>
                        <div class="col">
                            <p class="card-text">{{ $user->created_at->format('d-m-Y') }}</p>
                        </div>
                        <div class="col-sm-2">
                            <a href=""><ion-icon name="lock-closed-outline"></ion-icon></a>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-3 text-right">
                            <h6 class="card-title text-right"> {{__('Status')}} </h6>
                        </div>
                        <div class="col">
                            @if ($user->is_active)
                                <p class="card-text">{{__('Enabled')}}</p>
                            @else
                                <p class="card-text">{{__('Disabled')}}</p>
                            @endif
                        </div>
                        <div class="col-sm-2">
                            <a>
                                <ion-icon name="chevron-forward-outline"></ion-icon>
                            </a>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-3">
                            <h6 class="card-title text-right"> {{__('User verified')}} </h6>
                        </div>
                        <div class="col">
                            @if ($user->email_verified_at === null)
                                <p class="card-text">{{__('No')}}</p>
                            @else
                                <p class="card-text">{{__('Yes')}}</p>
                            @endif
                        </div>
                        <div class="col-sm-2">
                            <a href=""><ion-icon name="lock-closed-outline"></ion-icon></a>
                        </div>
                    </div>
                    <hr>
                    <div class="row d-none" id="save">
                        <div class="container">
                            <button type="submit" class="btn btn-primary btn-block btn-sm">{{__('Save Changes')}}</button>
                            <a href="" class="btn btn-danger btn-block btn-sm">{{__('Cancel')}}</a>
                            <br>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

<script>
    /**
     * agregamos listener a los inputs para que cada vez que se preciona una tecla en ellos
     * el boton guardar cambios aparezca
     */
    document.addEventListener("DOMContentLoaded", function(event) {
        var htmlCollection = document.getElementsByClassName('hover-edit')
        var length = htmlCollection.length
        for(var i = 0; i < length; i++){
            htmlCollection.item(i).addEventListener('keydown', () => {
                document.getElementById('save').classList.add('d-block')
            }, false)
        }
    })
</script>