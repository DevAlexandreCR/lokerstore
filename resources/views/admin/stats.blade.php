@extends('admin.home')

@section('main')
<div class="content">
    <a href="{{route('orders.create')}}" type="button" class="btn btn-dark fab float-left" aria-expanded="false">
        <ion-icon size="large" class="add" name="add"></ion-icon>
    </a>
    <div class="btn-group dropleft float-md-right">
        <button type="button" class="btn btn-dark dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            {{trans('reports.generate_report_sales')}}
        </button>
        <div class="dropdown-menu shadow">
            <div class="btn-group  m-2" role="group" aria-label="Basic example">
                <button class="btn btn-outline-dark " data-toggle="modal" data-target="#generateReport">{{trans('reports.generate')}}</button>
                <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#generateReport"><ion-icon  name="download"></ion-icon></button>
            </div>
            <div class="btn-group m-2" role="group" aria-label="Basic example">
                <button class="btn btn-outline-dark" data-toggle="modal" data-target="#generateMonthlyReport">{{trans('reports.monthly')}}</button>
                <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#generateMonthlyReport"><ion-icon  name="download"></ion-icon></button>
            </div>
        </div>
    </div>
    <div class="row justify-content-center py-2">
        <div class="flag flag-blue ml-md-3 shadow-sm mb-3 text-right">
            <div class="card-body d-inline-flex text-right">
                <h5 class="title text-black-50 text-right">{{trans('orders.statuses.pending_shipment')}}:  {{$pendingShipment}}
                </h5>
                <ion-icon class="ml-4 text-muted" size="large" name="file-tray-stacked"></ion-icon>
            </div>
        </div>
        <sales-percent-component :metrics="{{$percentMetrics->toJson()}}"></sales-percent-component>
        <div class="flag flag-red ml-sm-2 shadow-sm mb-3 text-right">
            <div class="card-body d-inline-flex">
                <h5 class="title text-black-50  text-left">{{trans_choice('users.user', $usersCount, ['user_count' => ''])}}:  {{$usersCount}}
                </h5>
                <ion-icon class="ml-4 text-muted" size="large" name="people-circle"></ion-icon>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-7">
            <div class="card shadow-sm bg-white mb-3">
                <div class="card-header">{{trans('reports.sales')}}</div>
                <div class="card-body bg-white">
                    <orders-metric :orders="{{ $metricsGeneral->toJson() }}"></orders-metric>
                </div>
            </div>
        </div>
        <div class="col-sm-5">
            <div class="card shadow-sm bg-white mb-3">
                <div class="card-header">{{trans('reports.trend')}}</div>
                <div class="card-body">
                    <category-metric :metrics="{{ $metricsCategory->toJson() }}"></category-metric>
                </div>
            </div>
            <div class="card shadow-sm bg-white mb-3">
                <div class="card-header">{{trans('reports.Sellers')}}</div>
                <div class="card-body">
                    <sellers-metric :metrics="{{ $metricsSeller->toJson() }}"></sellers-metric>
                </div>
            </div>
        </div>
    </div>
    <div class="row">

    </div>
</div>

@include('admin.generate-reports-modal')
@include('admin.generate-monthly_reports-modal')
@endsection
