@extends('admin.home')

@section('main')
@if ( session('success'))
    
<div class="container py-2">
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        <span class="sr-only">Close</span>
      </button>
      <strong>{{__('Success!')}}</strong> {{ __(session('success')) }}
    </div>
</div>

@endif

<div class="container py-3">
  <div class="card shadow">
    <div class="modal-header bg-light">
      <h5 class="modal-title">{{ __('Add new product') }}</h5>
      <a href="{{ route('products.index') }}" class="btn btn-link"><ion-icon name="return-up-back-outline"></ion-icon></a>
    </div>
    <form action="{{route('products.store')}}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('POST')
      <div class="card-body">
        <div class="row">
          <div class="col-2">
            <h6 class="card-title"> {{__('Name')}} </h6>
          </div>
          <div class="col-4">
            <div class="form-group">
              <input type="name" class="form-control  @error('name') is-invalid @enderror" id="name" required placeholder="{{__('Name')}}"
                name="name" aria-describedby="nameHelp" value="{{ old('name')}}">
                @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
          </div>
          <div class="col-2">
            <h6 class="card-title"> {{__('Stock')}} </h6>
          </div>
          <div class="col-4">
                <input type="number" class="form-control  @error('stock') is-invalid @enderror" id="stock" disabled placeholder="{{ __('This value will be added automatically') }}"
                name="stock" aria-describedby="lastnameHelp">
                @error('stock')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
          </div>
        </div>
        <div class="row">
          <div class="col-2">
            <h6 class="card-title"> {{__('Description')}} </h6>
          </div>
          <div class="col">
            <div class="form-group">
            <textarea type="textarea" class="form-control  @error('description') is-invalid @enderror" id="description" required placeholder="{{__('Add product description...')}}"
              name="description" aria-describedby="descriptionHelp">{{ old('description') }}</textarea>
              @error('description')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-2">
            <h6 class="card-title"> {{__('Price')}} </h6>
          </div>
          <div class="col-2">
            <div class="form-group">
            <input type="number" class="form-control  @error('price') is-invalid @enderror" id="price" required placeholder="0"
              name="price" aria-describedby="priceHelp" value="{{ old('price') }}">
              @error('price')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
          </div>
          <div class="col-2 text-center">
            <h6> {{__('Category')}} </h6>
          </div>
          <div class="col">
            <div class="row">
              <div class="col">
                  <div class="nav flex-column nav-tabs" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    @foreach ($categories as $key => $category)
                    <a class="nav-link d-none {{$key == 0 ? 'active' : '' }}" id="{{$category->id}}" data-toggle="tab" href="#{{$category->name}}"
                      role="tab" aria-controls="{{$category->name}}" aria-selected="{{$key == 0 ? 'true' : 'false' }}"></a>
                    @endforeach
                    <select class="form-control" onchange="document.getElementById(this.value).click()">
                      @foreach ($categories as $key => $category)
                      <a class="nav-link  {{$key == 0 ? 'active' : '' }}" id="{{$category->id}}" data-toggle="tab" href="#{{$category->name}}"
                        role="tab" aria-controls="{{$category->name}}" aria-selected="{{$key == 0 ? 'true' : 'false' }}"></a>
                      <option value="{{$category->id}}">
                        {{$category->name}}
                      </option>
                      @endforeach
                    </select>
                  </div>
              </div>
              <div class="col">
                <div class="tab-content" id="v-pills-tabContent">
                  @foreach ($categories as $key => $category)
                  <div class="tab-pane fade {{$key == 0 ? 'show active' : '' }}" id="{{$category->name}}" role="tabpanel" aria-labelledby="{{$category->id}}">
                    <select class="form-control" onchange="setCategory(this.value)">
                      @foreach ($category->children as $sub)
                      <option value="{{$sub->id}}">{{$sub->name}}</option>
                      @endforeach
                    </select>
                  </div>
                  @endforeach
                </div>
                <input type="number"  id="id_category" class="form-control" name="id_category" hidden >
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
            <h6>{{__('Add tags')}}</h6>
          </div>
          <div class="container">
            @error('tags') 
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>{{__('Whoops!')}}</strong> {{__('You must add at least one tag')}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
            @enderror
            <div class="row @error('tags') alert alert-danger @enderror">
              @foreach ($tags as $tag)
                <div class="card m-2">
                    <div class="custom-control custom-checkbox mr-sm-2 ml-sm-2">
                    <input type="checkbox" class="custom-control-input" value="{{$tag->id}}"  name="tags[]" id="{{$tag->name}}">
                    <label class="custom-control-label" for="{{$tag->name}}">{{$tag->name}}</label>
                    </div>
                </div>
              @endforeach
            </div>
          </div>
        </div>
        <hr>
        <div class="row" id="imgContainer">
          <div class="container text-center">
            <h6>{{__('Add images')}}</h6>
          </div>
          <div class="col-4 increment">
            <div class="card m-3" style="width: 18rem;" id="card-img">
              <img>
              <div class="card-body">
                <div class="input-group mb-3" >
                  <div class="custom-file">
                    <label for="images" class="custom-file-label"></label>
                    <input type="file" name="photos[]" class="custom-file-input" id="images" accept="image/*" aria-describedby="inputGroupFileAddon03" required>
                  </div>
                  <div class="input-group-append">
                    <button class="btn btn-primary" onclick="addPhoto()" type="button"><ion-icon class="bold" name="add-outline"></ion-icon></button>
                 </div>
                </div>
              </div>
            </div> 
          </div> 
          <div class="col-4 d-none" id="clone">
            <div class="card m-3" style="width: 18rem;">
              <img>
              <div class="card-body">
                <div class="input-group mb-3" >
                  <div class="custom-file">
                    <label for="images" class="custom-file-label"></label>
                    <input type="file" name="photos[]" class="custom-file-input" id="images" accept="image/*"
                     aria-describedby="inputGroupFileAddon03">
                  </div>
                  <div class="input-group-append">
                    <button class="btn btn-danger" onclick="removePhoto(this)" type="button"><ion-icon name="trash-outline"></ion-icon></button>
                 </div>
                </div>
              </div>
            </div> 
          </div> 
        </div>
        <hr>
        <div class="row " id="save">
          <div class="container">
             <button type="submit" class="btn btn-success btn-block btn-sm">{{__('Save product')}}</button>
             <br>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection
<script>
  /** 
  * Esta funcion agrega la imagen seleccionada a la vista previa
  * @argument input que posee la imagen
  * @argument div card donde se va a agregar la imagen
  */
  var multiImgPreview = (input, div) => {
    if (input.files) {
        var filesAmount = input.files.length;

        for (i = 0; i < filesAmount; i++) {
            var reader = new FileReader();

            reader.onload = function(event) { 
              var img = div.getElementsByTagName('img')[0]
              img.classList.add('img-thumbnail')
              img.src = event.target.result  
              }          
            reader.readAsDataURL(input.files[i]);
        }
    }
  }

  /** 
  * Esta funcion agrega el valor del option a la category_id input
  * @argument value valor del option seleccionado
  */
  var setCategory = (value) => {
        document.getElementById('id_category').value = value
    }

  /** 
  * Esta funcion agrega la vista para una nueva imagen
  */
  const addPhoto = () => {
    var divToClone = document.getElementById("clone").cloneNode(true)
    divToClone.classList.remove("d-none")
    document.getElementById("imgContainer").appendChild(divToClone)
    var input = divToClone.getElementsByTagName("input")[0]
    input.addEventListener('change', function() {
            multiImgPreview(input, divToClone);
        })
  }

  /** 
  * Esta funcion borra la vista de una nueva imagen
  */
  const removePhoto = (button) => {
    button.parentNode.parentNode.parentNode.parentNode.parentNode.remove()
  }
  /** 
  * Esta funcion agrega el listener del input de la primer imagen al iniciarse el DOM
  */
  document.addEventListener("DOMContentLoaded", () => {
    var input = document.getElementById("imgContainer")
            .getElementsByTagName("input")[0]
    input.addEventListener('change', () => {
      var div = document.getElementById("card-img")
      multiImgPreview(input, div)
    })
  });
</script>