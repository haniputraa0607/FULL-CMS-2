@php $prod = $product[0] @endphp
<table class="table datatable">
    <thead>
        <tr>
            <th>Outlet</th>
            <th>Stock Status</th>
            <th>Stock</th>
        </tr>
    </thead>
    <tbody>
        @foreach($prod['product_detail'] ?? [] as $outlet_stock)
        <tr>
            <td>{{ $outlet_stock['outlet_name'] }}</td>
            <td>{{ $outlet_stock['product_detail_stock_status'] }}</td>
            <td>{{ $outlet_stock['product_detail_stock_item'] }}</td>
        </tr>
        @endforeach
    </tbody>
</table>