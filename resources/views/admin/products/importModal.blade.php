<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{route('products.import')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="importModal">{{trans('actions.import')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="custom-file mb-3">
                        <label class="btn btn-link">
                            <input class="file-input" type="file" name="file" accept=".xls,.xlsx">
                        </label>
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
