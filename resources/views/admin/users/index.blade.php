@extends('admin.home')

@section('main')
<div class="container py-4" style="max-width: 80%;">
  <div class="row">
    {{-- <div class="col-xs-4">
      <div class="input-group form-inline">
        <input class="form-control mr-sm-2" type="search" placeholder="{{__('Search')}}" aria-label="Search">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">{{__('Search')}}</button>
      </div>
    </div>  --}}
    @if (!empty($user_not_found))
    <div class="container" role="alert">
    <strong>{{ $user_not_found }}</strong> <a class="btn btn-sm btn-link" href="{{route('users.index')}}">{{__('See all')}}</a>
    </div>
    @elseif(!empty($user_found))
    <div class="container" role="alert">
      <strong>{{ $user_found }}</strong> <a class="btn btn-sm btn-link" href="{{route('users.index')}}">{{__('See all')}}</a>
      </div>
    @endif
  </div>
  <div class="row py-3">
    <div class="container table-responsive">
      <table class="table table-sm table-striped table-condensed">
        <thead>
          <tr>
            <th>{{__('Id')}}</th>
            <th>{{__('Name')}}</th>
            <th>{{__('Lastname')}}</th>
            <th>{{__('E-Mail Address')}}</th>
            <th>{{__('Phone')}}</th>
            <th style="text-align: center">{{__('View')}}</th>
          </tr>
          </thead>
          <tbody>
        @foreach ($users as $user)
              <tr class="">
              <td scope="row">{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->lastname }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->phone }}</td>
                <td>
                  <div class="btn-group btn-block btn-group-sm text-center" 
                  role="group"
                  style="border-left: groove">
                    <a type="button" class="btn btn" 
                    data-toggle="tooltip" 
                    data-placement="top" 
                    title="{{__('View')}}"
                    href="{{route('users.show', ['user' => $user])}}">
                    <ion-icon name="eye"></ion-icon>
                    </a>
                  </div>
                </td>
              </tr>
        @endforeach
      </tbody>
    </div>
    </table>
  </div>
  <div class="container">
    <div class="row">
      <div class="col-8">{{ $users->links() }}</div>
      <div class="col-4">
        <div class="row" style="float: right">
          <div class="col"><strong>{{__('Users')}}</strong></div>
          <div class="col">{{ \App\Models\User::count()}}</div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
