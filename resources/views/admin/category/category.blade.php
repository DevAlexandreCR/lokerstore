<div class="card shadow-sm border-primary flex-fill">
    <div class="card-header">
        <div class="row">
            <div class="col">
                {{$category->name}}
            </div>
            <div class="col-3 align-self-end">
                <button type="button" class="btn btn-sm btn-success"
                        data-placement="top"
                        title="{{trans('actions.update')}}"
                        data-toggle="modal"
                        data-target="#editCategory{{$category->id}}"
                >
                    <ion-icon name="create"></ion-icon>
                </button>
                <button type="button" class="btn btn-sm btn-danger"
                        data-placement="top"
                        title="{{trans('actions.remove')}}"
                        data-toggle="modal"
                        data-target="#modalDelete{{$category->id}}"
                >
                    <ion-icon name="trash"></ion-icon>
                </button>
                @include('admin.category.delete', ['category' => $category])
                @include('admin.category.edit', [
                    'category' => $category,
                    'categories' => $categories
                    ])
            </div>
        </div>

    </div>
    <img class="card-img-top" src="holder.js/100x180/" alt="">
    <div class="card-body">
        <table class="table table-sm table-hover">
            <thead>
            <th>{{trans('fields.id')}}</th>
            <th>{{trans('fields.name')}}</th>
            <th>{{trans_choice('products.product', 2, ['product_count' => ''])}}</th>
            <th class="text-center">{{trans('fields.actions')}}</th>
            </thead>
            <tbody>
            @foreach ($category->children as $sub_category)
                <tr>
                    <td scope="row">{{$sub_category->id}}</td>
                    <td>{{$sub_category->name}}</td>
                    <td>{{$sub_category->products->count()}}</td>
                    <td class="text-center flex-fill">
                        <form action="{{ route('products.index') }}" method="GET">
                            <input type="text" name="category" hidden value="{{$sub_category->name}}">
                            <button type="submit" class="btn btn-sm btn-blue"
                                    data-placement="top"
                                    title="{{trans('actions.view')}}"
                                    data-target="tooltip"
                            >
                                <ion-icon name="eye"></ion-icon>
                            </button>
                            <button type="button" class="btn btn-sm btn-success"
                                    data-placement="top"
                                    title="{{trans('actions.update')}}"
                                    data-toggle="modal"
                                    data-target="#editCategory{{$sub_category->id}}"
                            >
                                <ion-icon name="create"></ion-icon>
                            </button>
                            <button type="button" class="btn btn-sm btn-danger"
                                    data-placement="top"
                                    title="{{trans('actions.remove')}}"
                                    data-toggle="modal"
                                    data-target="#modalDelete{{$sub_category->id}}"
                            >
                                <ion-icon name="trash"></ion-icon>
                            </button>
                        </form>
                        @include('admin.category.delete', ['category' => $sub_category])
                        @include('admin.category.edit', [
                            'category' => $sub_category,
                            'categories' => $categories
                            ])
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="container text-right">
        <button class="btn btn-success fab" data-target="#addSubCategory{{$category->id}}" data-toggle="modal">
            <ion-icon name="add" size="large" class="add"></ion-icon>
        </button>
    </div>
</div>
