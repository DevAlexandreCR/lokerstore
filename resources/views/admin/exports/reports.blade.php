<table class="table">
    <thead>
    <tr></tr>
    <tr></tr>
    <tr></tr>
    <tr></tr>
    <tr>
        <th>{{trans('Date')}}</th>
        <th>{{'% ' . trans('Man')}}</th>
        <th>{{trans('Clothing\'s man')}}</th>
        <th>{{'% ' . trans('Woman')}}</th>
        <th>{{trans('Clothing\'s woman')}}</th>
        <th>{{trans('Status')}}</th>
        <th>{{trans('Total sold')}}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($monthly as $key => $metric)
        <tr>
            <td>{{ $key}}</td>
            <td>{{ $metric->amountPercent }}</td>
            <td>{{ $metric->amount }}</td>
            <td>{{ $metric->totalFPercent }}</td>
            <td>{{ $metric->totalF }}</td>
            <td>{{ \App\Constants\Orders::getTranslatedStatus($metric->status) }}</td>
            <td>{{ $metric->amount +  $metric->totalF}}</td>
        </tr>
    @endforeach
    <tr>
        <td>{{trans('Totals')}}</td>
        <td>{{$totalManPercent}}</td>
        <td>{{$totalMan}}</td>
        <td>{{$totalWomanPercent}}</td>
        <td>{{$totalWoman}}</td>
        <td></td>
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

<table class="table">
    <thead>
    <tr></tr>
    <tr></tr>
    <tr>
        <th>{{trans('Date')}}</th>
        <th>{{trans('Status')}}</th>
        <th>{{trans('Total')}}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($uncompleted as $key => $metric)
        <tr>
            <td>{{ $metric->date }}</td>
            <td>{{ \App\Constants\Orders::getTranslatedStatus($metric->status) }}</td>
            <td>{{ $metric->amount }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
