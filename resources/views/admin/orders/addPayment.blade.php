<div class="card">
    <div class="card-header">{{trans('Add payment')}}</div>
    <div class="card-body">
        <form>
        <div class="row">
            <div class="col-sm-4">
                    <div class="form-group form-row">
                        <label class="col-sm-6" for="selectMethod">{{ trans('Method') }}</label>
                        <select class="form-control col-sm-6 form-control-sm" id="selectMethod">
                            @foreach(\App\Constants\Payments::getMethods() as $method)
                                <option value="{{$method}}">{{trans($method)}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group form-row">
                        <label class="col-sm-6" for="selectType">{{ trans('Document type') }}</label>
                        <select class="form-control col-sm-6 form-control-sm" id="selectType">
                            @foreach(\App\Constants\Payers::toArray() as $type)
                                <option value="{{$type}}">{{trans($type)}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group form-row">
                        <label class="col-sm-6" for="document">{{ trans('Document') }}</label>
                        <input type="number" class="form-control col-sm-6 form-control-sm" id="document" placeholder="1.000.000">
                    </div>
            </div>
            <div class="col-sm-8">
                <div class="form-group form-row">
                    <label class="col-sm-2" for="namePayer">{{ trans('Name') }}</label>
                    <input type="text" class="form-control col-sm-4 form-control-sm" id="namePayer" placeholder="Pepito">
                    <label class="col-sm-2" for="lastNamePayer">{{ trans('Last name') }}</label>
                    <input type="text" class="form-control col-sm-4 form-control-sm" id="lastNamePayer" placeholder="Perez">
                </div>
                <div class="form-group form-row">
                    <label class="col-sm-1" for="emailPayer">{{ trans('Email') }}</label>
                    <input type="email" class="form-control col-sm-5 form-control-sm" id="emailPayer" placeholder="client@example.com">
                    <label class="col-sm-2" for="phonePayer">{{ trans('Phone') }}</label>
                    <input type="text" class="form-control col-sm-4 form-control-sm" id="phonePayer" placeholder="3103100000">
                </div>
                <div class="form-group form-row">
                    <label class="col-sm-3" for="amountOrder">{{ trans('Amount') }}</label>
                    <input type="number" class="form-control col-sm-9 form-control-sm text-center" disabled id="amountOrder" value="{{ $order->amount }}">
                </div>
            </div>
            <div class="btn-group btn-block mx-xl-5">
                <button type="submit" class="btn btn-success btn-sm">{{trans('Save')}}</button>
            </div>
        </div>
        </form>
    </div>
</div>
