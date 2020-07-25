<div class="modal fade" id="modalDelete{{$category->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <form action="{{route('category.destroy', ['category' => $category])}}" method="POST">
            @csrf
            @method('DELETE')
            <div class="modal-header">
            <h5 class="modal-title" id="ModalLabel">{{$category->name}}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <strong><p>{{__('This action will remove the category and its products')}}</p></strong>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-success" data-dismiss="modal">{{__('Discard')}}</button>
              <button type="submit" class="btn btn-danger">{{__('Remove')}}</button>
            </div>
        </form>
      </div>
    </div>
  </div>