@extends('admin.home')

@section('main')
<div class="container py-4" style="max-width: 80%">
  @if ( session('product-deleted'))
        
  <div class="container py-2">
      <div class="alert alert-success alert-dismissible fade show" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
          <span class="sr-only">Close</span>
          </button>
          <strong>{{__('Success!')}}</strong> {{ session('product-deleted') }}
      </div>
  </div>

@endif
@if ( session('product-updated'))
  
  <div class="container py-2">
      <div class="alert alert-success alert-dismissible fade show" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
          <span class="sr-only">Close</span>
          </button>
          <strong>{{__('Success!')}}</strong> {{ session('product-updated') }}
      </div>
  </div>

@endif
    <div class="card shadow">
      <div class="modal-header bg-light">
        <h5 class="modal-title">{{ __('Edit product') }}</h5>
        <a href="{{ route('products.index' , ['product' => $product]) }}" class="btn btn-link"><ion-icon name="return-up-back-outline"></ion-icon></a>
      </div>
      <div class="card-body">
          @switch($input_name)
              @case('is_active')
              <form action="{{route('products.set_active', ['product' => $product])}}" method="POST">
                @csrf
                @method('PUT')
              @if ($product->is_active)
              <div class="alert alert-danger" role="alert">
                <strong>{{__('This action will disable the product')}}</strong>
              <a href="{{ url()->previous() }}" type="button" class="btn btn-secondary btn-sm" style="float: right">{{__('Back')}}</a>
              </div>
              @endif
                  <div class="row">
                    <div class="col">
                      <h6 class="card-title"> {{__('Status')}} </h6>
                    </div>
                    @if ($product->is_active)
                    <div class="col">
                      <p class="card-text">{{__('Enabled')}}</p>
                    </div>
                      <div class="col-sm-2">
                        <input type="hidden" name="is_active" value="0">
                        <button type="submit" class="btn btn-danger btn-sm">{{__('Disable')}}</button>
                        </div>
                      @else
                      <div class="col">
                      <p class="card-text">{{__('Disabled')}}</p>
                    </div>
                      <div class="col-sm-2">
                      <input type="hidden" name="is_active" value="1">
                        <button type="submit" class="btn btn-primary btn-sm">{{__('Enable')}}</button>
                        </div>
                      @endif
                  </div>
                  @break
              @case('delete')
              <form action="{{route('products.destroy', ['product' => $product])}}" method="POST">
                @csrf
                @method('DELETE')
                <div class="alert alert-danger" role="alert">
                  <strong>{{__('This action will delete the product')}} 
                    <ion-icon name="skull-outline"></ion-icon>
                    <ion-icon name="alert-circle-outline"></ion-icon>
                    <ion-icon name="hand-left-outline"></ion-icon></strong>
                <a href="{{ url()->previous() }}" type="button" class="btn btn-secondary btn-sm" style="float: right">{{__('Back')}}</a>
                </div>
                <div class="row">
                <div class="col">
                </div>
                <div class="col-sm-2">
                  <input type="hidden" name="is_active" value="1">
                  <button type="submit" class="btn btn-danger btn-block btn-sm">{{__('Remove')}}</button>
                </div>
                </div>
              </form>
                  @break
              @default   
                  <div class="form-group">
                    <div class="alert alert-info" role="alert">
                      <strong>{{__('Oops! You\'re lost?')}}</strong>
                        <?php $input_name = 'lost' ?>;
                    </div>
                  </div>  
          @endswitch
          @if ($input_name === 'lost')
                <a href="{{route('products.index')}}" class="btn btn-primary">{{__('Back')}}</a>
          @elseif ($input_name === 'is_active' || $input_name === 'delete')
                <br>
          @else
                <button type="submit" class="btn btn-primary">{{__('Save')}}</button>
          @endif
        </form>
      </div>
    </div>
</div>
@endsection