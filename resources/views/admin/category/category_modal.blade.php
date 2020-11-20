<div class="modal fade" id="addCategory" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <form action="{{route('category.store')}}" method="post">
            @csrf
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">{{trans('products.add_category')}}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <input type="number" hidden name="id_parent" value="{{null}}">
                    <label for="exampleInputEmail1">{{trans('users.name')}}</label>
                    <input type="text" class="form-control" id="inputName" name="name" aria-describedby="namelHelp" value="{{ old('name') }}">
                    <small id="nameHelp" class="form-text text-muted">{{trans('products.category_unique')}}</small>
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
