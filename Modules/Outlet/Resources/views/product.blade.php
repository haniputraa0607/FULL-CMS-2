@php $out = $outlet[0]; @endphp
<div style="padding:10px 0" class="text-right">
    <a href="{{ url()->current() }}/refresh-product" class="btn btn-success">Refresh Product</a>
</div>
<table class="table datatable">
    <thead>
        <tr>
            <th>Product</th>
            <th>Stock Status</th>
            <th>Stock</th>
        </tr>
    </thead>
    <tbody>
        @foreach($out['product_detail'] ?? [] as $product)
        <tr>
            <td>{{ $product['product']['product_name'] }}</td>
            <td>{{ $product['product_detail_stock_status'] }}</td>
            <td>{{ $product['product_detail_stock_item'] }}</td>
        </tr>
        @endforeach
    </tbody>
</table>