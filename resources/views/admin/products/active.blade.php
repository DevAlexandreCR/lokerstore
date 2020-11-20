@extends('admin.home')

@section('main')
<div class="container py-4" style="max-width: 80%">
    <div class="card shadow">
      <div class="modal-header bg-light">
        <h5 class="modal-title">{{ trans('products.update') }}</h5>
        <a href="{{ route('products.index') }}" class="btn btn-link"><ion-icon name="return-up-back-outline"></ion-icon></a>
      </div>
      <div class="card-body">
          @switch($input_name)
              @case('is_active')
              <form action="{{route('products.set_active', ['product' => $product])}}" method="POST">
                @csrf
                @method('PUT')
              @if ($product->is_active)
              <div class="alert alert-danger" role="alert">
                <strong>{{trans('products.messages.disable')}}</strong>
              <a href="{{ route('products.index') }}" type="button" class="btn btn-secondary btn-sm" style="float: right">{{trans('actions.back')}}</a>
              </div>
              @endif
                  <div class="row">
                    <div class="col">
                      <h6 class="card-title"> {{trans('fields.status')}} </h6>
                    </div>
                    @if ($product->is_active)
                    <div class="col">
                      <p class="card-text">{{trans('actions.enabled')}}</p>
                    </div>
                      <div class="col-sm-2">
                        <input type="hidden" name="is_active" value="0">
                        <button type="submit" class="btn btn-danger btn-sm">{{trans('actions.disable')}}</button>
                        </div>
                      @else
                      <div class="col">
                      <p class="card-text">{{trans('actions.disabled')}}</p>
                    </div>
                      <div class="col-sm-2">
                      <input type="hidden" name="is_active" value="1">
                        <button type="submit" class="btn btn-primary btn-sm">{{trans('actions.enable')}}</button>
                        </div>
                      @endif
                  </div>
                  @break
              @case('delete')
              <form action="{{route('products.destroy', ['product' => $product])}}" method="POST">
                @csrf
                @method('DELETE')
                <div class="alert alert-danger" role="alert">
                  <strong>{{trans('products.messages.remove')}}
                    <ion-icon name="skull-outline"></ion-icon>
                    <ion-icon name="alert-circle-outline"></ion-icon>
                    <ion-icon name="hand-left-outline"></ion-icon></strong>
                <a href="{{ url()->previous() }}" type="button" class="btn btn-secondary btn-sm" style="float: right">{{trans('actions.back')}}</a>
                </div>
                <div class="row">
                <div class="col">
                </div>
                <div class="col-sm-2">
                  <button type="submit" class="btn btn-danger btn-block btn-sm">{{trans('actions.remove')}}</button>
                </div>
                </div>
              </form>
                  @break
              @default
                  <div class="form-group">
                    <div class="alert alert-info" role="alert">
                      <strong>{{trans('messages.lost')}}</strong>
                        <?php $input_name = 'lost' ?>;
                    </div>
                  </div>
          @endswitch
          @if ($input_name === 'lost')
                <a href="{{route('products.index')}}" class="btn btn-primary">{{trans('actions.back')}}</a>
          @elseif ($input_name === 'is_active' || $input_name === 'delete')
                <br>
          @else
                <button type="submit" class="btn btn-primary">{{trans('actions.save_changes')}}</button>
          @endif
        </form>
      </div>
    </div>
</div>
@endsection
