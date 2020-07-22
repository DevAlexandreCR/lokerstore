<div class="card">
    <div class="card-header">
        {{$category->name}}
    </div>
    <img class="card-img-top" src="holder.js/100x180/" alt="">
    <div class="card-body">
        <table class="table table-sm table-hover">
            <thead>
                <th>{{__('id')}}</th>
                <th>{{__('Name')}}</th>
                <th>{{__('Products')}}</th>
                <th class="text-center">{{__('View')}}</th>
            </thead>
            <tbody>
                @foreach ($category->children as $sub_category)
                    <tr>
                        <td scope="row">{{$sub_category->id}}</td>
                        <td>{{$sub_category->name}}</td>
                        <td>{{$sub_category->products->count()}}</td>
                        <td class="text-center">  
                            <form action="{{ route('products.index') }}" method="GET">
                                <input type="text" name="category" hidden value="{{$sub_category->name}}">
                                <button type="submit" class="btn btn-sm btn-success" 
                                data-placement="top" 
                                title="{{__('View products')}}"
                                data-target="tooltip"
                                >
                                <ion-icon name="eye"></ion-icon>
                            </button>
                            </form>                              
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>  