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
        @foreach($prod['product_icount_outlet_stocks'] as $outlet_stock)
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
            <td>{{ !isset($prod['unit1']) ? '-' : !isset($this_stock[$prod['unit1']]) ? '-' : $this_stock[$prod['unit1']] }}</td>
            <td>{{ !isset($prod['unit2']) ? '-' : !isset($this_stock[$prod['unit2']]) ? '-' : $this_stock[$prod['unit2']] }}</td>
            <td>{{ !isset($prod['unit3']) ? '-' : !isset($this_stock[$prod['unit3']]) ? '-' : $this_stock[$prod['unit3']] }}</td>
        </tr>
        @endforeach
    </tbody>
</table>