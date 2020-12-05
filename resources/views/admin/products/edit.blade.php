@extends('admin.home')

@section('main')
    <div class="container py-3">
        <div class="card shadow">
            <div class="modal-header bg-light">
                <h5 class="modal-title">{{ trans('products.update') }}</h5>
                <a href="{{ route('products.index') }}" class="btn btn-link">
                    <ion-icon name="return-up-back-outline"></ion-icon>
                </a>
            </div>
            <form action="{{route('products.update', ['product' => $product])}}" method="POST"
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-2">
                            <h6 class="card-title"> {{trans('products.name')}} </h6>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <input type="name" class="form-control  @error('name') is-invalid @enderror" id="name"
                                       required placeholder="{{trans('products.name')}}"
                                       name="name" aria-describedby="nameHelp" value="{{ $product->name}}">
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <h6 class="card-title"> {{trans('products.reference')}} </h6>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <input type="name" class="form-control  @error('reference') is-invalid @enderror"
                                       id="name"
                                       required placeholder="0000"
                                       name="reference" aria-describedby="nameHelp" value="{{ $product->reference}}">
                                @error('reference')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <h6 class="card-title"> {{trans('products.stock')}} </h6>
                        </div>
                        <div class="col-sm-2">
                            <input type="number" class="form-control  @error('stock') is-invalid @enderror" id="stock"
                                   disabled placeholder="0"
                                   name="stock" aria-describedby="lastnameHelp" value="{{ $product->stock }}">
                            @error('stock')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-2">
                            <h6 class="card-title"> {{trans('products.description')}} </h6>
                        </div>
                        <div class="col">
                            <div class="form-group">
                <textarea type="textarea"
                          class="form-control user-select-all  @error('description') is-invalid @enderror"
                          id="description" required placeholder="{{trans('products.messages.add_description')}}"
                          name="description" aria-describedby="descriptionHelp">{{ $product->description }}</textarea>
                                @error('description')
                                <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-2 ml-2">
                            <div class="form-group">
                                <label for="cost">{{trans('products.cost')}}</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">$</span>
                                    </div>
                                    <input type="number" class="form-control  @error('cost') is-invalid @enderror"
                                           id="cost" required placeholder="{{trans('products.cost')}}"
                                           name="cost" aria-describedby="priceHelp" value="{{ $product->cost }}">
                                </div>
                                @error('cost')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="price">{{trans('products.price')}}</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">$</span>
                                    </div>
                                    <input type="number" class="form-control  @error('price') is-invalid @enderror"
                                           id="price" required placeholder="{{trans('products.price')}}"
                                           name="price" aria-describedby="priceHelp" value="{{ $product->price }}">
                                </div>
                                @error('price')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <h6 class="card-title"> {{trans('products.category')}} </h6>
                        </div>
                        <div class="col">
                            <div class="col">
                                <div class="row">
                                    <div class="col">
                                        <div class="nav flex-column nav-tabs" id="v-pills-tab" role="tablist"
                                             aria-orientation="vertical">
                                            @foreach ($categories as $key => $category)
                                                <a class="nav-link d-none {{$key == 0 ? 'active' : '' }}"
                                                   id="{{$category->id}}" data-toggle="tab" href="#{{$category->name}}"
                                                   role="tab" aria-controls="{{$category->name}}"
                                                   aria-selected="{{$key == 0 ? 'true' : 'false' }}"></a>
                                            @endforeach
                                            <select class="form-control"
                                                    onchange="document.getElementById(this.value).click()">
                                                @foreach ($categories as $key => $category)
                                                    <option value="{{$category->id}}"
                                                            @if ($category->id == $product->category->id_parent)
                                                            selected
                                                        @endif>{{$category->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="tab-content" id="v-pills-tabContent">
                                            @foreach ($categories as $key => $category)
                                                <div
                                                    class="tab-pane fade {{$category->id == $product->category->id_parent ? 'show active' : '' }}"
                                                    id="{{$category->name}}" role="tabpanel"
                                                    aria-labelledby="{{$category->id}}">
                                                    <select class="form-control"
                                                            onchange="setCategory(this.value, 'edit_id_category')">
                                                        @foreach ($category->children as $sub)
                                                            <option value="{{$sub->id}}"
                                                                    @if ($sub->id == $product->id_category)
                                                                    selected
                                                                @endif>{{$sub->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            @endforeach
                                        </div>
                                        <input type="number" id="edit_id_category" class="form-control"
                                               name="id_category" hidden value="{{$product->id_category}}">
                                    </div>
                                </div>
                            </div>
                            @error('category')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="container text-center">
                            <h6>{{trans('products.messages.add_tags')}}</h6>
                        </div>
                        <div class="container">
                            @error('tags')
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>{{trans('products.messages.ups')}}</strong> {{trans('products.messages.no_tags_added')}}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            @enderror
                            <div class="row @error('tags') alert alert-danger @enderror">
                                @foreach ($tags as $tag)
                                    <div class="card m-2">
                                        <div class="custom-control custom-checkbox mr-sm-2 ml-sm-2">
                                            <input type="checkbox" class="custom-control-input" value="{{$tag->id}}"
                                                   name="tags[]" id="{{$tag->name}}">
                                            <label class="custom-control-label"
                                                   for="{{$tag->name}}">{{$tag->name}}</label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row" id="imgContainer">
                        <div class="container text-center">
                            <h6>{{trans('products.messages.add_images')}}</h6>
                        </div>
                        <div class="col increment">
                            <div class="card m-3" style="width: 18rem;" id="card-img">
                                <img>
                                <div class="card-body">
                                    <div class="input-group mb-3">
                                        <div class="custom-file">
                                            <label for="images" class="custom-file-label"></label>
                                            <input type="file" name="photos[]" class="custom-file-input" id="images"
                                                   accept="image/*" aria-describedby="inputGroupFileAddon03">
                                        </div>
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" onclick="addPhoto()" type="button">
                                                <ion-icon class="bold" name="add-outline"></ion-icon>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col d-none" id="clone">
                            <div class="card m-3" style="width: 18rem;">
                                <img>
                                <div class="card-body">
                                    <div class="input-group mb-3">
                                        <div class="custom-file">
                                            <label for="images" class="custom-file-label"></label>
                                            <input type="file" name="photos[]" class="custom-file-input" id="images"
                                                   accept="image/*" aria-describedby="inputGroupFileAddon03">
                                        </div>
                                        <div class="input-group-append">
                                            <button class="btn btn-danger" onclick="removePhoto(this)" type="button">
                                                <ion-icon name="trash-outline"></ion-icon>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row " id="save">
                        <div class="container">
                            <button type="submit"
                                    class="btn btn-success btn-block btn-sm">{{trans('actions.save_changes')}}</button>
                            <br>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
<script>
    /** esta funcion hace check en los tags devueltos por el servidor
     *@argument tags array
     */
    const selectedTags = (tags) => {
        tags.forEach(tag => {
            document.getElementById(tag.name).checked = true
        });
    }
    /**
     * Esta funcion agrega la imagen seleccionada a la vista previa
     * @argument input que posee la imagen
     * @argument div card donde se va a agregar la imagen
     */
    const multiImgPreview = (input, div) => {
        if (input.files) {
            let filesAmount = input.files.length;

            for (let i = 0; i < filesAmount; i++) {
                const reader = new FileReader();

                reader.onload = function (event) {
                    const img = div.getElementsByTagName('img')[0];
                    img.classList.add('img-thumbnail')
                    img.src = event.target.result
                }
                reader.readAsDataURL(input.files[i]);
            }
        }
    };

    /**
     * Esta funcion agrega el valor del option a la category_id input
     * @argument value valor del option seleccionado
     */
    const setCategory = (value, id) => {
        document.getElementById(id).value = value
    };

    /**
     * Esta funcion agrega la vista para una nueva imagen
     */
    const addPhoto = (photo = null) => {
        let divToClone = document.getElementById("clone").cloneNode(true);
        divToClone.classList.remove("d-none")
        document.getElementById("imgContainer").appendChild(divToClone)
        let input = divToClone.getElementsByTagName("input")[0];
        if (photo) {
            let img = divToClone.getElementsByTagName('img')[0]
            img.classList.add('img-thumbnail')
            img.src = '/photos/' + photo.name
            img.id = photo.id
        }
        input.addEventListener('change', function () {
            multiImgPreview(input, divToClone);
        })
    }

    /**
     * Esta funcion borra la vista de una nueva imagen
     */
    const removePhoto = (button) => {
        let div = button.parentNode.parentNode.parentNode.parentNode.parentNode;
        let img = div.getElementsByTagName('img')[0];
        let photo_id = img.id
        if (photo_id) {
            let input = document.createElement('input');
            input.name = 'delete_photos[]'
            input.type = 'number'
            input.value = photo_id
            input.hidden = true
            document.getElementById('imgContainer').appendChild(input)
        }
        div.remove()
    }
    /**
     * Esta funcion agrega el listener del input de la primer imagen al iniciarse el DOM
     */
    document.addEventListener("DOMContentLoaded", () => {
        let input = document.getElementById("imgContainer")
            .getElementsByTagName("input")[0];
        let div = document.getElementById("card-img");
        input.addEventListener('change', () => {
            multiImgPreview(input, div)
            let photos = getPhotos();
            console.log(photos[0].id)
            let inputdelete = document.createElement('input');
            inputdelete.name = 'delete_photos[]'
            inputdelete.type = 'number'
            inputdelete.value = photos[0].id
            inputdelete.hidden = true
            document.getElementById('imgContainer').appendChild(inputdelete)
        })
        let tags = getTags();
        selectedTags(tags)

        let photos = getPhotos();
        let img = div.getElementsByTagName('img')[0];
        img.classList.add('img-thumbnail')
        img.src = '/photos/' + photos[0].name
        img.id = photos[0].id

        if (photos.length > 1) {
            photos.shift()
            photos.forEach(photo => {
                addPhoto(photo)
            })
        }
    })

    const getTags = () => {
        return <?php echo json_encode($product->tags, JSON_THROW_ON_ERROR) ?>;
    }

    const getPhotos = () => {
        return <?php echo json_encode($product->photos, JSON_THROW_ON_ERROR) ?>;
    }
</script>
