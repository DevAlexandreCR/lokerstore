<div class="modal fade" tabindex="-1" id="addEmployee" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{__('Add employee')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('admins.store')}}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="name">{{__('Name')}}</label>
                        <input class="form-control" type="text" name="name" id="name">
                        <label for="email">{{__('Email Address')}}</label>
                        <input class="form-control" type="email" name="email" id="email" autocomplete="nope">
                        <label for="pass">{{__('Password')}}</label>
                        <input class="form-control" type="password" name="pass" id="pass">
                        <label for="status">{{__('Status')}}</label>
                        <select class="form-control" type="password" name="status" id="status">
                            <option value="0" selected>{{__('Disabled')}}</option>
                            <option value="1">{{__('Enabled')}}</option>
                        </select>
                        <label for="role">{{__('Roles')}}</label>
                        <select class="form-control" type="text" name="role" id="role">
                            @foreach($roles as $id => $name)
                                <option value="{{$id}}">{{__($name)}}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div
