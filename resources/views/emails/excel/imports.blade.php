@component('mail::message')
# Hola {{$name}}

@if(count($failures) === 0)
{{trans('Products imported successfully')}}
@else
{{trans('Products imported with errors')}}<br>
{{trans('Errores')}}: {{count($failures)}}
@endif

@component('mail::button', ['url' => route('products.index')])
{{trans('View')}} {{trans('Products')}}
@endcomponent

@if(count($failures) > 0)
<table class="table">
        <thead>
        <tr>
            <th>{{trans('Import')}}</th>
            <th>{{trans('Row')}}</th>
            <th>{{trans('Field')}}</th>
            <th>{{trans('Errors')}}</th>
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
