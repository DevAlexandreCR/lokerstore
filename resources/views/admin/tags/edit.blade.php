<div class="modal fade" id="modalEdit{{$tag->name}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <form action="{{route('tags.update', ['tag' => $tag])}}" method="post">
            @csrf
            @method('PUT')
            <div class="modal-header">
            <h5 class="modal-title" id="ModalLabel">{{$tag->name}}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="inputName{{$tag->id}}">{{__('Name tag')}}</label>
                            <input type="text" class="form-control" id="inputName{{$tag->id}}" name="name" aria-describedby="namelHelp" value="{{ $tag->name }}">
                            <small id="nameHelp" class="form-text text-muted">{{__('The name must be unique')}}</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Discard')}}</button>
            <button type="submit" class="btn btn-primary">{{__('Save')}}</button>
            </div>
        </form>
      </div>
    </div>
  </div>