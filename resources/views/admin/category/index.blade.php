@extends('admin.home')

@section('main')

<div class="row">
    <div class="container-fluid my-2 p-4 mr-2 shadow-sm bg-secondary round">
        <div class="row">
            <div class="col-sm-3">
                <button class="btn btn-link">{{__('Add primary category')}}</button>
            </div>
            <div class="col"></div>
            <div class="col-4">

            </div>
        </div>
      </div>
</div>

<div class="row">
    @foreach ($categories as $category)
        <div class="col-sm-3">
            @include('admin.category.category', ['category' => $category])
        </div>
    @endforeach
</div>
    
@endsection

