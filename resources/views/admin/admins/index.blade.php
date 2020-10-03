@extends('admin.home')

@section('main')
    <div class="container">
        @if (session('success'))
            <div class="container py-2">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only">Close</span>
                    </button>
                    <strong>{{__('Success!')}}</strong> {{ session('success') }}
                </div>
            </div>
        @endif
        @if ( $errors->any() )

            @foreach ($errors->all() as $error)
                <div class="container align-self-start col-4 py-2">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span>
                        </button>
                        <strong>{{__('Error!')}}</strong> {{ $error }}
                    </div>
                </div>
            @endforeach

        @endif
        <div class="row p-5">
            <button type="button" data-toggle="modal" data-target="#addEmployee" class="btn btn-primary">{{__('Add employee')}}</button>
        </div>
        <div class="row">
            <table id="table_id" class="table table-sm table-responsive-sm table-striped table-condensed table-hover table-secondary">
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
                        <td>{{ optional($admin->getRoleNames())[0] }}</td>
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
                                   data-toggle="modal"
                                   data-target="#enableEmployee"
                                   data-placement="top"
                                   data-admin="{{ $admin }}"
                                   title="@if($admin->is_active) {{__('Disable')}} @else{{__('Enable')}} @endif"
                                   >
                                    <ion-icon name="power"></ion-icon>
                                </a>
                                <a type="button" class="btn btn-link"
                                   data-toggle="modal"
                                   data-target="#removeEmployee"
                                   data-admin="{{ $admin }}"
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
    @include('admin.admins.enable')
    @include('admin.admins.delete')
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        $('#enableEmployee').on('show.bs.modal', function (event) {
            let button = $(event.relatedTarget) // Button that triggered the modal
            let admin = button.data('admin')
            let modal = $(this)
            let value
            if (admin.is_active) {
                value = 0
                modal.find('.modal-title').text('Inhabilitar usuario ' + admin.email)
                modal.find('.modal-body p').text('Habilitado')
                modal.find('.modal-body button').text('Inhabilitar')
                $('#alertDisable').show()
            } else {
                $('#alertDisable').hide()
                value = 1
                modal.find('.modal-title').text('Habilitar usuario ' + admin.email)
                modal.find('.modal-body p').text('Inhabilitado')
                modal.find('.modal-body button').text('Habilitar')
            }
            let url = `${document.documentURI}/${admin.id}`
            $('#inputEnable').val(value)
            $('#formEnable').attr('action', url)
        })
        $('#removeEmployee').on('show.bs.modal', function (event) {
            let button = $(event.relatedTarget) // Button that triggered the modal
            let admin = button.data('admin')
            console.log(admin)
            let modal = $(this)
            modal.find('.modal-title').text('Eliminar usuario ' + admin.email)
            modal.find('.modal-body p').text(admin.name)
            let url = `${document.documentURI}/${admin.id}`
            $('#formRemove').attr('action', url)
        })
    });

</script>
