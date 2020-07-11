@extends('admin.home')

@section('main')
<banner-component/>
<div class="content py-4">
    <div class="row">
        <div class="col">
            <div class="card text-white bg-primary mb-3" style="max-width: 18rem;">
                <div class="card-header">Usuarios</div>
                <div class="card-body">
                  <h5 class="card-title">Total usuarios</h5>
                  <p class="card-text">100</p>
                </div>
              </div>
        </div>
        <div class="col">
            <div class="card text-white bg-secondary mb-3" style="max-width: 18rem;">
                <div class="card-header">Productos</div>
                <div class="card-body">
                  <h5 class="card-title">Total productos</h5>
                  <p class="card-text">980</p>
                </div>
              </div>
        </div>
        <div class="col">
            <div class="card text-white bg-success mb-3" style="max-width: 18rem;">
                <div class="card-header">Ventas</div>
                <div class="card-body">
                  <h5 class="card-title">Ventas ultimo mes</h5>
                  <p class="card-text">147</p>
                </div>
        </div> 
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="card text-white bg-secondary mb-3" style="max-width: 18rem;">
                <div class="card-header">Usuarios</div>
                <div class="card-body">
                  <h5 class="card-title">Usuarios inhabilitados</h5>
                  <p class="card-text">33</p>
                </div>
              </div>
        </div>
        <div class="col">
            <div class="card text-white bg-info mb-3" style="max-width: 18rem;">
                <div class="card-header">Productos</div>
                <div class="card-body">
                  <h5 class="card-title">Productos mas vendido</h5>
                  <p class="card-text">COD:3456</p>
                </div>
              </div>
        </div>
        <div class="col">
            <div class="card text-white bg-danger mb-3" style="max-width: 18rem;">
                <div class="card-header">Ventas</div>
                <div class="card-body">
                  <h5 class="card-title">Ventas Hoy</h5>
                  <p class="card-text">3</p>
                </div>
        </div> 
        </div>
    </div>
    <hr>
@endsection 