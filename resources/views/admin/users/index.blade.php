@extends('admin.home')

@section('main')
      <div class="row m-2 p-4 shadow-sm bg-secondary">
          <div class="col justify-content-end">
              <form class="form-inline justify-content-end my-2 my-lg-0" method="GET" action="{{route('users.index')}}">
                  <input class="form-control form-control-sm mr-sm-2" type="search" name="search" placeholder="{{trans('actions.search')}}" aria-label="Search" required>
                  <button class="btn btn-outline-primary btn-sm my-2 my-sm-0" type="submit">{{trans('actions.search')}}</button>
              </form>
          </div>
      </div>
        @if (!empty($user_not_found))
        <div class="container" role="alert">
        <strong>{{ $user_not_found }}</strong> <a class="btn btn-sm btn-link" href="{{route('users.index')}}">{{trans('actions.view_all')}}</a>
        </div>
        @elseif(!empty($user_found))
        <div class="container" role="alert">
          <strong>{{ $user_found }}</strong> <a class="btn btn-sm btn-link" href="{{route('users.index')}}">{{trans('actions.view_all')}}</a>
          </div>
        @endif
      <div class="container">
        <table id="table_id" class="table table-sm table-responsive-md table-striped table-condensed table-hover table-secondary">
          <thead>
            <tr>
              <th>{{trans('fields.id')}}</th>
              <th>{{trans('users.name')}}</th>
              <th>{{trans('users.last_name')}}</th>
              <th>{{trans('users.email')}}</th>
              <th>{{trans('users.phone')}}</th>
              <th>{{trans('fields.status')}}</th>
              <th style="text-align: center">{{trans('fields.actions')}}</th>
            </tr>
          </thead>
            <tbody>
              @foreach ($users as $user)
                    <tr class="@if(!$user->is_active) text-muted @endif">
                    <td scope="row">{{ $user->id }}</td>
                      <td>{{ $user->name }}</td>
                      <td>{{ $user->lastname }}</td>
                      <td>{{ $user->email }}</td>
                      <td>{{ $user->phone }}</td>
                      @if ($user->is_active)
                      <td>
                        <span class="badge badge-info"> {{ trans('actions.enabled') }}</span>
                      </td>
                      @else
                      <td class="text-muted">
                        <span class="badge badge-danger"> {{ trans('actions.disabled') }}</span>
                      </td>
                      @endif
                      <td>
                        <div class="btn-group btn-block btn-group-sm text-center"
                        role="group"
                        style="border-left: groove">
                          <a type="button" class="btn btn-link"
                          data-toggle="tooltip"
                          data-placement="top"
                          title="{{trans('actions.view')}}"
                          href="{{route('users.show', ['user' => $user])}}">
                          <ion-icon name="eye"></ion-icon>
                          </a>
                          <a type="button" class="btn btn-link"
                          data-toggle="tooltip"
                          data-placement="top"
                          title="@if($user->is_active) {{trans('actions.disable')}} @else{{trans('actions.enable')}} @endif"
                          href="{{ route('users.edit', ['user' => $user, 'input_name' => 'is_active'])}}">
                          <ion-icon name="power"></ion-icon>
                          </a>
                          <a type="button" class="btn btn-link"
                          data-toggle="tooltip"
                          data-placement="top"
                          title="{{trans('actions.remove')}}"
                          href="{{route('users.edit', ['user' => $user, 'input_name' => 'delete'])}}">
                          <ion-icon name="trash"></ion-icon>
                          </a>
                        </div>
                      </td>
                    </tr>
              @endforeach
            </tbody>
        </table>
      </div>
      <div class="container text-center">
          {{ $users->links() }}<strong> {{trans_choice('users.user', $users->count(), ['user_count' => $users->count()])}} </strong>
      </div>
@endsection
