@extends('admin.home')

@section('main')
@if ( session('user-updated'))
    
<div class="container py-2">
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
      <span class="sr-only">Close</span>
    </button>
    <strong>{{__('Success!')}}</strong> {{ __(session('product-updated')) }}
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
                <input type="number" class="form-control  @error('stock') is-invalid @enderror" id="stock" required placeholder="0"
                name="stock" aria-describedby="lastnameHelp" value="{{ old('') }}">
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
            name="description" aria-describedby="descriptionHelp" value="{{ old('') }}"></textarea>
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
          <div class="col-4">
            <div class="form-group">
            <input type="number" class="form-control  @error('price') is-invalid @enderror" id="price" required placeholder="0"
              name="price" aria-describedby="priceHelp" value="{{ old('') }}">
              @error('price')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
          </div>
          <div class="col-2">
            <h6 class="card-title"> {{__('Category')}} </h6>
          </div>
          <div class="col">
            <select id="category" class="form-control" name="id_category">
                <option value="{{null}}">{{__('Choose category')}}</option>
                @foreach (\App\Models\Category::all() as $category)
                <option value="{{$category->id}}">{{$category->name}}</option>
                @endforeach
            </select>
            @error('lastname')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
          </div>
        </div>
        <div class="row" id="imgContainer">
          <div class="col-4 increment">
            <div class="card m-3" style="width: 18rem;" id="card-img">
              <img class="img-thumbnail">
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
              <img class="img-thumbnail">
              <div class="card-body">
                <div class="input-group mb-3" >
                  <div class="custom-file">
                    <label for="images" class="custom-file-label"></label>
                    <input type="file" name="photos[]" class="custom-file-input" id="images" accept="image/*" aria-describedby="inputGroupFileAddon03">
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
  var multiImgPreview = (input, div) => {
    if (input.files) {
        var filesAmount = input.files.length;

        for (i = 0; i < filesAmount; i++) {
            var reader = new FileReader();

            reader.onload = function(event) { 
              var img = div.getElementsByTagName('img')[0]
              img.src = event.target.result  
              }          
            reader.readAsDataURL(input.files[i]);
        }
    }
  }

  const addPhoto = () => {
    var divToClone = document.getElementById("clone").cloneNode(true)
    divToClone.classList.remove("d-none")
    document.getElementById("imgContainer").appendChild(divToClone)
    var input = divToClone.getElementsByTagName("input")[0]
    input.addEventListener('change', function() {
            multiImgPreview(input, divToClone);
        })
  }

  const removePhoto = (button) => {
    button.parentNode.parentNode.parentNode.parentNode.parentNode.remove()
  }

  document.addEventListener("DOMContentLoaded", () => {
    var input = document.getElementById("imgContainer")
            .getElementsByTagName("input")[0]
    input.addEventListener('change', () => {
      var div = document.getElementById("card-img")
      multiImgPreview(input, div)
    })
  });
</script>