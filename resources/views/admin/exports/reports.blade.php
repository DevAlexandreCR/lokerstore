<table class="table">
    <thead>
    <tr>
        <th>{{trans('Month')}}</th>
        <th>{{trans('Total man')}}</th>
        <th>{{trans('Total woman')}}</th>
        <th>{{trans('Total monthly sold')}}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($monthly as $key => $metric)
        <tr>
            <td>{{ $key}}</td>
            <td>{{ $metric->amount }}</td>
            <td>{{ $metric->totalF }}</td>
            <td>{{ $metric->total }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

<table class="table">
    <thead>
    <tr>
        <th>{{trans('Month')}}</th>
        <th>{{trans('Category')}}</th>
        <th>{{trans('Amount')}}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($categories as $key => $metric)
        <tr>
            <td>{{ $key}}</td>
            <td>{{ $metric->category_name }}</td>
            <td>{{ $metric->amount }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
