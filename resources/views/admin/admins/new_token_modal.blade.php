<div class="modal" tabindex="-1" id="tokenModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{route('admins.update_token', $admin->id)}}" method="post">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">{{ trans('actions.update') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>{{ trans('users.update_token') }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">{{ trans('actions.close') }}</button>
                    <button type="submit" class="btn btn-primary">{{ trans('actions.submit') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
