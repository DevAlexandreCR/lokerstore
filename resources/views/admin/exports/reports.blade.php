<table class="table">
    <thead>
    <tr></tr>
    <tr></tr>
    <tr></tr>
    <tr></tr>
    <tr>
        <th>{{trans('orders.date')}}</th>
        <th>{{'% ' . trans('fields.man')}}</th>
        <th>{{trans('reports.clothing_man')}}</th>
        <th>{{'% ' . trans('fields.woman')}}</th>
        <th>{{trans('reports.clothing_woman')}}</th>
        <th>{{trans('fields.status')}}</th>
        <th>{{trans('reports.total_sold')}}</th>
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
        <td>{{trans('orders.total')}}</td>
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
    <tr>
        <th>{{ trans('reports.category_most_sold') }}</th>
    </tr>
    <tr></tr>
    <tr>
        <th>{{trans('orders.date')}}</th>
        <th>{{trans('products.category')}}</th>
        <th>{{trans('reports.monthly_sale')}}</th>
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
    <tr>
        <th>{{ trans('reports.uncompleted') }}</th>
    </tr>
    <tr></tr>
    <tr>
        <th>{{trans('orders.date')}}</th>
        <th>{{trans('fields.status')}}</th>
        <th>{{trans('orders.total')}}</th>
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

<table class="table">
    <thead>
    <tr>
        <th>{{ trans('reports.stock') }}</th>
    </tr>
    <tr></tr>
    <tr>
        <th>{{trans('products.category')}}</th>
        <th>{{trans('products.cost')}}</th>
        <th>{{trans('products.price')}}</th>
        <th>{{trans('fields.dif')}}</th>
        <th>{{trans('fields.quantity')}}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($stocks as $stock)
        <tr>
            <td>{{ $stock->name }}</td>
            <td>{{ $stock->cost }}</td>
            <td>{{ $stock->amount }}</td>
            <td>{{ $stock->dif }}</td>
            <td>{{ $stock->quantity }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
