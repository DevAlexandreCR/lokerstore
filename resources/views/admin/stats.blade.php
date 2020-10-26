@extends('admin.home')

@section('main')
<div class="content py-4">
    <div class="row">
        <div class="col">
            <div class="card shadow-sm bg-aqua mb-3">
                <div class="card-header">Ventas</div>
                <div class="card-body">
                    <orders-metric :metrics="{{ $metricsGeneral->toJson() }}"></orders-metric>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card bg-secondary mb-3">
                <div class="card-header">Vendedores</div>
                <div class="card-body">
                    <sellers-metric :metrics="{{ $metricsSeller->toJson() }}"></sellers-metric>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card text-white bg-success mb-3">
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
            <div class="card text-white bg-secondary mb-3">
                <div class="card-header">Usuarios</div>
                <div class="card-body">
                  <h5 class="card-title">Usuarios inhabilitados</h5>
                  <p class="card-text">33</p>
                </div>
              </div>
        </div>
        <div class="col">
            <div class="card bg-info mb-3">
                <div class="card-header">Productos</div>
                <div class="card-body">
                  <h5 class="card-title">Productos mas vendido</h5>
                  <p class="card-text">COD:3456</p>
                </div>
              </div>
        </div>
        <div class="col">
            <div class="card text-white bg-danger mb-3">
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
    <script>
        import SellersMetric from "../../js/components/charts/SellersMetric";
        export default {
            components: {SellersMetric}
        }
    </script>
