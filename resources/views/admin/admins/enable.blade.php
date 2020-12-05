<div class="modal fade" tabindex="-1" id="enableEmployee" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                    <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="">
                    <form name="formEnable" id="formEnable" action="{{route('admins.update', $admin->id)}}" method="post">
                        @csrf
                        @method('PUT')
                        <div id="alertDisable" class="alert alert-danger" role="alert">
                            <strong>{{trans('users.messages.disable')}}</strong>
                        </div>
                        <div class="row">
                            <div class="col">
                                <h6 class="card-title">{{trans('fields.status')}}</h6>
                            </div>
                            <div class="col">
                                <p class="card-text"></p>
                            </div>
                            <div class="col-sm-4">
                                <input id="inputEnable" type="hidden" name="is_active">
                                <button type="submit" class="btn btn-primary btn-sm"></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

