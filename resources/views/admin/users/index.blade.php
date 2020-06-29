@extends('admin.home')

@section('main')
<div class="container py-4" style="max-width: 80%;">
  <div class="row">
    <div class="col">
      
    </div>
    {{-- <div class="col-xs-4">
      <div class="input-group form-inline">
        <input class="form-control mr-sm-2" type="search" placeholder="{{__('Search')}}" aria-label="Search">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">{{__('Search')}}</button>
      </div>
    </div> --}}
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
            <th>{{__('View')}}</th>
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
                  <div class="btn-group btn-block btn-group-sm" role="group" aria-label="Basic example">
                    <a type="button" class="btn btn" data-toggle="tooltip" data-placement="top" title="{{__('View')}}"
                    href="{{route('users.show', ['user' => $user])}}">
                      <ion-icon name="eye" style="width: 20px; height:20px;"></ion-icon>
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
    {{ $users->links() }}
  </div>
</div>
@endsection
