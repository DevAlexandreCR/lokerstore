<div class="modal fade" id="importImages" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{route('products.import_images')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">{{trans('products.messages.import_images')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="input-group">
                        <label for="images" class="mr-1 btn-block">{{trans('products.choose_images')}}</label>
                        <input class="form-control d-block mr-sm-2" type="file" name="images[]" multiple
                               id="images" accept="image/x-png, image/gif, image/jpeg">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{trans('actions.close')}}</button>
                    <button type="submit" class="btn btn-primary">{{trans('actions.submit')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>
