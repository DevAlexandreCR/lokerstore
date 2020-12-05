<div class="modal fade" id="modalCreateTag" tabindex="-1" role="dialog" aria-labelledby="modalCreateTag" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <form action="{{route('tags.store')}}" method="post">
            @csrf
            <div class="modal-header">
            <h5 class="modal-title" id="labelmodalCreateTag">{{trans('products.messages.add_tags')}}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="inputNameCreate">{{trans('fields.name')}}</label>
                            <input type="text" class="form-control" id="inputNameCreate" name="name" aria-describedby="namelHelp" value="{{ old('name')}}">
                            <small id="nameHelp" class="form-text text-muted text-danger">{{trans('messages.unique', ['field' => trans('fields.name')])}}</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{trans('actions.cancel')}}</button>
            <button type="submit" class="btn btn-primary">{{trans('actions.save')}}</button>
            </div>
        </form>
      </div>
    </div>
  </div>
