@php $prod = $product[0] @endphp
<table class="table datatable">
    <thead>
        <tr>
            <th>Outlet</th>
            @foreach ($prod['unit_icount'] as $unit_stock)
                <th>{{ $unit_stock['unit'] }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach($prod['product_icount_outlet_stocks'] ?? [] as $outlet_stock)
        <tr>
            @php
                $this_stock = [];
                $units = explode(",",$outlet_stock['units']);
                $stock = explode(",",$outlet_stock['stock']);
                foreach($units as $key => $u){
                    $this_stock[$u] = $stock[$key]; 
                }
            @endphp
            <td>{{ $outlet_stock['outlet_name'] }}</td>
            @foreach ($prod['unit_icount'] as $unit_stock)
                <td>{{ !isset($this_stock[$unit_stock['unit']]) ? '-' : $this_stock[$unit_stock['unit']] }}</td>
            @endforeach
        </tr>
        @endforeach
    </tbody>
</table>