@php $prod = $product[0] @endphp
<table class="table datatable">
    <thead>
        <tr>
            <th>Outlet</th>
            <th>{{ $prod['unit1'] }}</th>
            {!! $prod['unit2'] ? '<th>' . $prod['unit2'] . '</th>' : '' !!}
            {!! $prod['unit3'] ? '<th>' . $prod['unit3'] . '</th>' : '' !!}
        </tr>
    </thead>
    <tbody>
        @foreach($prod['product_icount_outlet_stocks'] as $stock)
        <tr>
            <td>{{$stock[$prod['unit1']]['outlet']['outlet_name']}}</td>
            <td>{{$stock[$prod['unit1']]['stock']}}</td>
            <td>{!! $prod['unit2'] ? $stock[$prod['unit2']]['stock'] : '' !!}</td>
            <td>{!! $prod['unit2'] ? $stock[$prod['unit2']]['stock'] : '' !!}</td>
        </tr>
        @endforeach
    </tbody>
</table>