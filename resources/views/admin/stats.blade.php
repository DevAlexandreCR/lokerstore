@extends('admin.home')

@section('main')
<div class="content py-4">
    <div class="row justify-content-center">
        <div class="flag flag-blue ml-md-3 shadow-sm mb-3 text-right">
            <div class="card-body d-inline-flex text-right">
                <h5 class="title text-black-50 text-right">{{trans('Pending shipment')}}:  {{$pendingShipment}}
                </h5>
                <ion-icon class="ml-4 text-muted" size="large" name="file-tray-stacked"></ion-icon>
            </div>
        </div>
        <sales-percent-component :metrics="{{$metricsGeneral->toJson()}}"></sales-percent-component>
        <div class="flag flag-red ml-sm-2 shadow-sm mb-3 text-right">
            <div class="card-body d-inline-flex">
                <h5 class="title text-black-50  text-left">{{trans('Users')}}:  {{$usersCount}}
                </h5>
                <ion-icon class="ml-4 text-muted" size="large" name="people-circle"></ion-icon>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-7">
            <div class="card shadow-sm bg-white mb-3">
                <div class="card-header">{{trans('Sales')}}</div>
                <div class="card-body bg-white">
                    <orders-metric :metrics="{{ $metricsGeneral->toJson() }}"></orders-metric>
                </div>
            </div>
        </div>
        <div class="col-sm-5">
            <div class="card shadow-sm bg-white mb-3">
                <div class="card-header">{{trans('Trend products')}}</div>
                <div class="card-body">
                    <category-metric :metrics="{{ $metricsCategory->toJson() }}"></category-metric>
                </div>
            </div>
            <div class="card shadow-sm bg-white mb-3">
                <div class="card-header">{{trans('Sellers')}}</div>
                <div class="card-body">
                    <sellers-metric :metrics="{{ $metricsSeller->toJson() }}"></sellers-metric>
                </div>
            </div>
        </div>
    </div>
    <div class="row">

    </div>
</div>
@endsection
