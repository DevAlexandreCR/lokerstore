@extends('admin.home')

@section('main')

<div class="row">
    <div class="container-fluid my-2 p-4 m-2 shadow-sm bg-secondary round">
        <div class="row">
            <div class="col">
                <button class="btn btn-blue" type="button" data-toggle="modal" data-target="#addCategory">{{trans('products.add_category')}}</button>
            </div>
        </div>
      </div>
</div>
<div class="row justify-content-around pb-4">
    @foreach ($categories as $key => $category)

        <div class="col-12 col-md-4 mt-4 @if($key > 0) align-top @endif d-felx flex-wrap">
            @include('admin.category.category', ['category' => $category])
        </div>
        @include('admin.category.sub_category_modal',
            [
                'category' => $category,
                'categories' => $categories
            ])
    @endforeach
</div>
@include('admin.category.category_modal')
@endsection

