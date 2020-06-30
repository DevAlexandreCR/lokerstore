<div class="container text-center">
    <h5>{{__('Featured')}}</h5>
    <div class="container" style="overflow-x: hidden; white-space: nowrap;">
    <div class="row ">
        <div class="row d-flex flex-nowrap">
            @foreach ($products as $product)
                <div class="card shadow" style="max-width: 200px; margin:10px">
                    <div class="card-header">{{$product->name}}</div>
                        <div class="card-body">
                            <blockquote class="blockquote">
                                <img src="https://cdn.pixabay.com/photo/2019/04/04/15/17/smartphone-4103051_960_720.jpg"
                                 class="rounded" 
                                 alt="img"
                                 style="max-width: 150px">
                            </blockquote>
                        </div>
                    <div class="card-footer">Precio: <strong>{{$product->price}}</strong></div>
                </div>
            @endforeach
        </div>
    </div>
</div>
</div>