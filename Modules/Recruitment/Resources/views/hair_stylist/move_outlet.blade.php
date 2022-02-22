<div style="margin-top: 5%">
	<form class="form-horizontal" id="form_approve" role="form" action="{{url('recruitment/hair-stylist/move-outlet/'.$detail['id_user_hair_stylist'])}}" method="post" enctype="multipart/form-data">
		<div class="form-body">
			@if(!empty($order))
				<div class="alert alert-block alert-warning fade in">
					<p><i class="fa fa-warning"></i> Can not change outlet because <b>{{ $detail['fullname']}}</b> has transaction at this outlet.</p>
				</div>
				<br>
			@endif
			<div class="form-group">
				<label class="col-md-3 control-label">Assign Outlet <span class="required" aria-required="true"> * </span>
					<i class="fa fa-question-circle tooltips" data-original-title="Penempatan outlet untuk hair stylist" data-container="body"></i>
				</label>
				<div class="col-md-6">
					<div class="input-icon right">
						<select  class="form-control select2" name="id_outlet" data-placeholder="Select outlet" @if(!empty($order)) disabled @endif>
							<option></option>
							@foreach($outlets as $outlet)
								<option value="{{$outlet['id_outlet']}}" @if($outlet['id_outlet'] == $detail['id_outlet']) selected @endif>{{$outlet['outlet_code']}} - {{$outlet['outlet_name']}}</option>
							@endforeach
						</select>
					</div>
				</div>
			</div>
			<br>
			<br>
			<table class="table table-striped table-bordered table-hover">
			<thead>
			<tr>
				<th>Action</th>
				<th>Date</th>
				<th>Outlet</th>
				<th>Receipt Number</th>
				<th>Customer Name</th>
				<th>Customer Phone</th>
				<th>Payment Status</th>
			</tr>
			</thead>
			<tbody>
				@if(!empty($order))
					@foreach($order as $val)
						<tr>
							<td>
								<a class="btn blue btn-sm btn-outline" href="{{url('transaction/outlet-service/manage/detail')}}/{{$val['id_transaction']}}">Detail Transaction <i class="fa fa-question-circle tooltips" data-original-title="Halaman detail transaksi" data-container="body"></i></a>
							</td>
							<td>{{date('Y-m-d H:i', strtotime($val['transaction_date']))}}</td>
							<td>{{$val['outlet']['outlet_code']}} - {{$val['outlet']['outlet_name']}}</td>
							<td>{{$val['transaction_receipt_number']}}</td>
							<td>{{$val['user']['name']}}</td>
							<td>{{$val['user']['phone']}}</td>
							<td>{{$val['transaction_payment_status']}}</td>
						</tr>
					@endforeach
				@else
					<tr style="text-align: center"><td colspan="7">Data Not Available</td></tr>
			    @endif
			</tbody>
			</table>
		</div>
		<div class="row" style="text-align: center;margin-top: 4%">
			{{ csrf_field() }}
			<button class="btn blue" id="btn_submit_move_outlet" @if(!empty($order)) disabled @endif>Submit</button>
		</div>
	</form>
</div>