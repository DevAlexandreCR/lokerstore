@component('mail::message')
# Hola {{$name}}

@if(count($failures) === 0)
{{trans('reports.products_imported)}}
@else
{{trans('reports.imported_errors')}}<br>
{{trans('fields.errors')}}: {{count($failures)}}
@endif

@component('mail::button', ['url' => route('products.index')])
{{trans('actions.view')}} {{trans_choice('products.product', 2, ['product_count' => ''])}}
@endcomponent

@if(count($failures) > 0)
<table class="table">
        <thead>
        <tr>
            <th>{{trans('actions.import')}}</th>
            <th>{{trans('fields.row')}}</th>
            <th>{{trans('fields.field')}}</th>
            <th>{{trans('fields.errors')}}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($failures as $failure)
            <tr>
                <td>{{trans($failure->import)}}</td>
                <td>{{$failure->row}}</td>
                <td>{{trans($failure->attribute)}}</td>
                <td>{{$failure->errors}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endif


{{ config('app.name') }}
@endcomponent
