<?php
use App\Lib\MyHelper;
$grantedFeature     = session('granted_features');
?>
@section('detail-box-style')
	<style type="text/css">
	</style>
@endsection

@section('detail-box')
	@if (isset($detail['today_shift']['id_hairstylist_schedule_date']))
		<form class="form-horizontal" role="form" action="{{url($url_back.'/update-box/'.$detail['id_user_hair_stylist'])}}" method="post" enctype="multipart/form-data">
			<div class="form-body">
				<div class="form-group">
					<label class="col-md-3 control-label">Select Box <span class="required" aria-required="true"> * </span>
					</label>
					<div class="col-md-4">
						<div class="input-icon right">
							<select  class="form-control select2" name="id_outlet_box" data-placeholder="Select Outlet Box" required @if(!in_array($detail['user_hair_stylist_status'], ['Active','Inactive'])) disabled @endif>
								<option value="0">Not using box</option>
								@foreach ($detail['shift_box'] as $b)
									@php
										$selected = ($b['id_outlet_box'] == $detail['today_shift']['id_outlet_box']) ? 'selected' : null;
										$inactive = ($b['outlet_box_status'] != 'Active') ? ' (Inactive)' : null;
										$usedBy = $b['hairstylist_schedule_dates'][0]['hairstylist_schedule']['user_hair_stylist']['fullname'] ?? null;
										$usedBy = $usedBy ? ' (' . $usedBy . ')' : null;
										$disable = ($inactive || $usedBy) ? 'disabled' : null;
									@endphp
									<option value="{{ $b['id_outlet_box'] }}" {{ $selected . ' ' . $disable }} >{{ $b['outlet_box_code'] . ' - ' . $b['outlet_box_name'] . $usedBy . $inactive}}</option>
								@endforeach
							</select>
						</div>
					</div>
				</div>
				<div class="form-group">
                    <label class="control-label col-md-3">Note <span class="required" aria-required="true">*</span></label>
                    <div class="col-md-4">
                        <textarea name="note" class="form-control" placeholder="note" required></textarea>
                    </div>
                </div>
				<div class="form-group">
					<div class="col-md-3"></div>
					@if(MyHelper::hasAccess([349], $grantedFeature) && $detail['user_hair_stylist_status'] != 'Rejected')
						{{ csrf_field() }}
						<div class="col-md-4">
							<input type="hidden" name="id_hairstylist_schedule_date" value="{{ $detail['today_shift']['id_hairstylist_schedule_date'] }}">
							<button type="submit" class="btn blue">Update</button>
						</div>
					@endif
				</div>
			</div>
		</form>
	@else
		<div class="form-horizontal">
			<div class="form-body">
				<div class="form-group">
					<label class="col-md-12 control-label" style="text-align:center">Hairstylist is not on shift</label>
				</div>
			</div>
		</div>
	@endif
@endsection


@section('detail-box-script')
	<script type="text/javascript"></script>
@endsection