<div class="modal fade" tabindex="-1" id="addEmployee" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{trans('users.add_employee')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('admins.store')}}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">{{trans('users.name')}}</label>
                        <input class="form-control" type="text" name="name" id="name">
                        <label for="email">{{trans('users.email')}}</label>
                        <input class="form-control" type="email" name="email" id="email" autocomplete="nope">
                        <label for="password">{{trans('users.password')}}</label>
                        <input class="form-control" type="password" name="password" id="password">
                        <label for="status">{{trans('fields.status')}}</label>
                        <select class="form-control" type="password" name="status" id="status">
                            <option value="0" selected>{{trans('actions.disabled')}}</option>
                            <option value="1">{{trans('actions.enabled')}}</option>
                        </select>
                        <label for="role">{{trans_choice('roles.role', 2, ['role_count' => ''])}}</label>
                        <select class="form-control" type="text" name="role" id="role">
                            @foreach($roles as $id => $name)
                                <option value="{{$id}}">{{trans($name)}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">{{trans('actions.save')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>
