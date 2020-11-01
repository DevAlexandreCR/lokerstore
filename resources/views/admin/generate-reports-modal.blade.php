<div class="modal fade" id="generateReport" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{route('admin.reports')}}" method="post">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">{{trans('Generate report sales')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="input-group">
                        <label for="datetime" class="mr-1 btn-block">{{__('From')}}</label>
                        <input class="form-control d-block mr-sm-2" type="date" name="from"
                               id="datetime">
                        <label for="datetime2" class="mr-1 btn-block">{{__('Until')}}</label>
                        <input class="form-control d-block mr-sm-2" type="date" name="to"
                               id="datetime2">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{trans('Close')}}</button>
                    <button type="submit" class="btn btn-primary">{{trans('Submit')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>
