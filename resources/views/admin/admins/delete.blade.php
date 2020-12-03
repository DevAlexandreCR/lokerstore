<div class="modal fade" tabindex="-1" id="removeEmployee" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{trans('actions.remove')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form name="formRemove" id="formRemove" method="post">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <div class="form-group">
                        <div class="alert alert-danger" role="alert">
                            <strong>{{trans('users.messages.remove')}} <p>{{$admin->name}}</p>
                                <ion-icon name="skull-outline"></ion-icon>
                                <ion-icon name="alert-circle-outline"></ion-icon>
                                <ion-icon name="hand-left-outline"></ion-icon></strong>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">{{trans('actions.remove')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>
