@extends('admin.home')

@section('main')
    <div class="container">
        <div class="row p-5">
            <button type="button" data-toggle="modal" data-target="#addEmployee" class="btn btn-primary">{{__('Add employee')}}</button>
        </div>
        <div class="row">
            <table id="table_id" class="table table-sm table-striped table-condensed table-hover table-secondary">
                <thead>
                <tr>
                    <th>{{__('Id')}}</th>
                    <th>{{__('Name')}}</th>
                    <th>{{__('E-Mail Address')}}</th>
                    <th>{{__('Status')}}</th>
                    <th>{{__('Role')}}</th>
                    <th>{{__('View')}}</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($admins as $admin)
                    <tr class="@if(!$admin->is_active) text-muted @endif">
                        <td scope="row">{{ $admin->id }}</td>
                        <td>{{ $admin->name }}</td>
                        <td>{{ $admin->email }}</td>
                        @if ($admin->is_active)
                            <td>
                                <span class="badge badge-info"> {{ __('Enabled') }}</span>
                            </td>
                        @else
                            <td class="text-muted">
                                <span class="badge badge-danger"> {{ __('Disabled') }}</span>
                            </td>
                        @endif
                        <td>{{ $admin->getRoleNames()[0] }}</td>
                        <td>
                            <div class="btn-group btn-block btn-group-sm text-center"
                                 role="group"
                                 style="border-left: groove">
                                <a type="button" class="btn btn-link"
                                   data-toggle="tooltip"
                                   data-placement="top"
                                   title="{{__('View')}}"
                                    href="{{ route('admins.show', $admin->id)}}">
                                    <ion-icon name="eye"></ion-icon>
                                </a>
                                <a type="button" class="btn btn-link"
                                   data-toggle="tooltip"
                                   data-placement="top"
                                   title="@if($admin->is_active) {{__('Disable')}} @else{{__('Enable')}} @endif"
                                   >
                                    <ion-icon name="power"></ion-icon>
                                </a>
                                <a type="button" class="btn btn-link"
                                   data-toggle="tooltip"
                                   data-placement="top"
                                   title="{{__('Remove')}}"
                                   >
                                    <ion-icon name="trash"></ion-icon>
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @include('admin.admins.create')
@endsection
