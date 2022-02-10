@php $out = $outlet[0]; @endphp
<table class="table datatable">
    <thead>
        <tr>
            <th>Product Icount</th>
            <th>Unit</th>
            <th>Stock</th>
        </tr>
    </thead>
    <tbody>
        @foreach($out['product_icount_outlet_stocks'] ?? [] as $outlet_stock)
        <tr>
            <td>{{ $outlet_stock['product_icount']['name'] }}</td>
            <td>{{ $outlet_stock['unit'] }}</td>
            <td>{{ $outlet_stock['stock'] }}</td>
        </tr>
        @endforeach
    </tbody>
</table>