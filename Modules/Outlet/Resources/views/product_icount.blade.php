@php $out = $outlet[0]; @endphp
<table class="table datatable">
    <thead>
        <tr>
            <th @if(MyHelper::hasAccess([447], $grantedFeature)) width="300px" @endif>Product Icount</th>
            <th class="text-center">Unit</th>
            <th class="text-center">Stock</th>
            <th class="text-center">Report</th>
            @if(MyHelper::hasAccess([447], $grantedFeature))
            <th class="text-center">Conversion</th>
            @endif
        </tr>
    </thead>
    <tbody>
        @foreach($out['product_icount_outlet_stocks'] ?? [] as $outlet_stock)
        <tr data-id="{{ $outlet_stock['id_product_icount'] }}_{{ $outlet_stock['unit'] }}">
            <td>{{ $outlet_stock['product_icount']['name'] }}</td>
            <td class="text-center unit">{{ $outlet_stock['unit'] }}</td>
            <td class="text-center qty">{{ $outlet_stock['stock'] }}</td>
            <td class="text-center"><a href="{{ url()->current() }}/report/{{ $outlet_stock['id_product_icount'] }}/{{ $outlet_stock['unit'] }}" class="btn btn-sm green">Report Stock</a></td>
            @if(MyHelper::hasAccess([447], $grantedFeature))
            <td class="text-center"><a href="javascript:conversion({{ $outlet_stock['id_product_icount'] }},'{{ $outlet_stock['product_icount']['name'] }}','{{ $outlet_stock['id_product_icount'] }}_{{ $outlet_stock['unit'] }}')" data-conv="{{ $outlet_stock['conversion'] }}" data-info="{{ $outlet_stock['info_conversion'] }}" class="btn btn-sm blue link">Convert</a></td>
            @endif
        </tr>
        @endforeach
    </tbody>
</table>