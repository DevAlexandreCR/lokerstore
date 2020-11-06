<table class="table">
    <thead>
    <tr></tr>
    <tr></tr>
    <tr></tr>
    <tr></tr>
    <tr>
        <th>{{trans('Date')}}</th>
        <th>{{trans('Clothing\'s man')}}</th>
        <th>{{trans('Clothing\'s woman')}}</th>
        <th>{{trans('Total sold')}}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($monthly as $key => $metric)
        <tr>
            <td>{{ $key}}</td>
            <td>{{ $metric->amount }}</td>
            <td>{{ $metric->totalF }}</td>
            <td>{{ $metric->amount +  $metric->totalF}}</td>
        </tr>
    @endforeach
    <tr>
        <td>{{trans('Totals')}}</td>
        <td>{{$totalMan}}</td>
        <td>{{$totalWoman}}</td>
        <td>{{$totalSold}}</td>
    </tr>
    </tbody>
</table>

<table class="table">
    <thead>
    <tr></tr>
    <tr></tr>
    <tr>
        <th>{{trans('Date')}}</th>
        <th>{{trans('Category')}}</th>
        <th>{{trans('Monthly sale')}}</th>
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
