<div class="modal fade" id="editCategory{{$category->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <form action="{{route('category.update', ['category' => $category])}}" method="post">
            @csrf
            @method('PUT')
            <div class="modal-header">
            <h5 class="modal-title" id="ModalLabel">{{$category->name}}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    @if ($category->id_parent)
                        <div class="col-4">
                            <label for="id_parent">{{trans('products.category')}}</label>
                            <select class="form-control" name="id_parent" id="id_parent">
                                @foreach ($categories as $key => $cat)
                                    <option value="{{$cat->id}}"
                                    @if ($cat->id == $category->id_parent)
                                    selected
                                    @endif>{{$cat->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    @else
                        <input type="number" hidden name="id_parent" value="{{null}}">
                    @endif
                    <div class="col">
                        <div class="form-group">
                            <label for="inputName{{$category->id}}">{{trans('products.sub_category')}}</label>
                            <input type="text" class="form-control" id="inputName{{$category->id}}" name="name" aria-describedby="namelHelp" value="{{ $category->name }}">
                            <small id="nameHelp" class="form-text text-muted">{{trans('products.category_unique')}}</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{trans('actions.cancel')}}</button>
            <button type="submit" class="btn btn-primary">{{trans('actions.save_changes')}}</button>
            </div>
        </form>
      </div>
    </div>
  </div>
