<?php
$id_product = $product[0]['id_product'];
?>
@if(empty($outlet))
	<h5><b>Data outlet academy not found</b></h5>
@else
<form class="form-horizontal" role="form" action="{{ url()->current() }}" method="post" enctype="multipart/form-data" id="formWithPrice2">
  <div class="form-body">

  	<div class="form-group" style="padding-left:20px">
		<label class="bold" style="width:30%">Outlet</label>
		<label class="bold" style="width:25%">Visible</label>
	</div>
		@foreach($outlet as $key => $ou)
		<?php $marker = 0; ?>
        <div class="form-group" style="padding-left:20px">
            <label class=""  style="width:30%">{{$ou['outlet_name']}}</label>
			@foreach($ou['product_detail'] as $keyDetail => $detail)
				@if($detail['id_product'] == $id_product)
					<?php $marker = 1;?>
					<div style="width:25%; display:inline-block">
						<select class="form-control product-visibility" name="product_detail_visibility[]">
							<option @if(empty($detail['product_detail_visibility'])) selected @endif>Default Visibilty Product</option>
							<option value="Visible" @if($detail['product_detail_visibility'] == 'Visible') selected @endif>Visible</option>
							<option value="Hidden" @if($detail['product_detail_visibility'] == 'Hidden') selected @endif>Hidden</option>
						</select>
						<input type="hidden" value="{{$detail['product_detail_visibility']}}" class="product-visibility-value">
						<input type="hidden" name="id_outlet[]" value="{{ $ou['id_outlet'] }}">
						<input type="hidden" name="id_product_detail[]" value="{{ $detail['id_product_detail'] }}">
					</div>
					<input type="hidden" name="product_detail_stock_status[]" value="Available" class="product-stock-value">
				@endif
			@endforeach
			@if($marker == 0)
				<div style="width:25%; display:inline-block">
					<select class="form-control product-visibility" name="product_detail_visibility[]">
						<option>Default Visibilty Product</option>
						<option value="Visible">Visible</option>
						<option value="Hidden">Hidden</option>
					</select>
					<input type="hidden" name="id_outlet[]" value="{{ $ou['id_outlet'] }}">
					<input type="hidden" name="id_product_detail[]" value="0">
					<input type="hidden" value="Hidden" class="product-visibility-value">
					<input type="hidden" name="product_detail_stock_status[]" value="Available" class="product-stock-value">
				</div>
			@endif
			<div style="margin-left:3%;width:15%; display:inline-block; vertical-align: text-top;">
				<label class="mt-checkbox mt-checkbox-outline"> Same for all
					<input type="checkbox" name="sameall[]" class="same checkbox-outlet" data-check="ampas"/>
					<span></span>
				</label>
			</div>
        </div>
		@endforeach
	</div>
  <div class="form-actions">
      {{ csrf_field() }}
      <div class="row">
          <div class="col-md-offset-3 col-md-9">
            <input type="hidden" name="id_product" value="{{ $id_product }}">
            <button type="submit" class="btn green" id="submit">Submit</button>
          </div>
      </div>
  </div>
  <input type="hidden" name="page" value="{{$page}}">
	<input type="hidden" name="type" value="product_detail">
</form>
@if ($outletPaginator)
	{{ $outletPaginator->fragment('outletsetting')->appends(['type' => 'product_detail'])->links() }}
@endif
@endif