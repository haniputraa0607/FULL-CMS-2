<form class="form-horizontal" role="form" action="{{ url('outlet/shift-time/save') }}" method="post">
	<?php
		$arrShift = [];
		if(!empty($outlet[0]['outlet_time_shift'])){
			foreach ($outlet[0]['outlet_time_shift'] as $shift){
				$arrShift[$shift['shift']] = [
					'start' => date('H:i', strtotime($shift['shift_time_start'])),
					'end' => date('H:i', strtotime($shift['shift_time_end']))
				];
			}
		}
	?>
  <div class="form-body">
	  <div class="form-group">
		  <div class="col-md-1"></div>
		  <div class="col-md-2">
			  <b>Shift</b>
		  </div>
		  <div class="col-md-3">
			  <b>Time Start</b>
		  </div>
		  <div class="col-md-3">
			  <b>Time End</b>
		  </div>
	  </div>
	  <div class="form-group">
		  <div class="col-md-1"></div>
		  <div class="col-md-2">
			  Morning
			  <input type="hidden" name="shift_data[0][shift]" value="Morning">
		  </div>
		  <div class="col-md-3">
			  <input type="text" data-placeholder="select time start" class="form-control mt-repeater-input-inline kelas-open timepicker timepicker-no-seconds" name="shift_data[0][shift_time_start]" value="{{(!empty($arrShift['Morning']['start']) ? $arrShift['Morning']['start'] : '09::00')}}" data-show-meridian="false" required>
		  </div>
		  <div class="col-md-3">
			  <input type="text" data-placeholder="select time end" class="form-control mt-repeater-input-inline kelas-close timepicker timepicker-no-seconds" name="shift_data[0][shift_time_end]" value="{{(!empty($arrShift['Morning']['end']) ? $arrShift['Morning']['end'] : '15:00')}}" data-show-meridian="false" required>
		  </div>
	  </div>
	  <div class="form-group">
		  <div class="col-md-1"></div>
		  <div class="col-md-2">
			  Evening
			  <input type="hidden" name="shift_data[1][shift]" value="Evening">
		  </div>
		  <div class="col-md-3">
			  <input type="text" data-placeholder="select time start" class="form-control mt-repeater-input-inline kelas-open timepicker timepicker-no-seconds" name="shift_data[1][shift_time_start]" value="{{(!empty($arrShift['Evening']['start']) ? $arrShift['Evening']['start'] : '15:00')}}" data-show-meridian="false" required>
		  </div>
		  <div class="col-md-3">
			  <input type="text" data-placeholder="select time end" class="form-control mt-repeater-input-inline kelas-close timepicker timepicker-no-seconds" name="shift_data[1][shift_time_end]" value="{{(!empty($arrShift['Evening']['end']) ? $arrShift['Evening']['end'] : '21:00')}}" data-show-meridian="false" required>
		  </div>
	  </div>
  </div>
  <div class="form-actions">
      {{ csrf_field() }}
      <div class="row" style="text-align: center;margin-top: 5%">
		  <input type="hidden" name="id_outlet" value="{{ $outlet[0]['id_outlet'] }}">
		  <input type="hidden" name="outlet_code" value="{{ $outlet[0]['outlet_code'] }}">
		  <button type="submit" class="btn green">Submit</button>
      </div>
  </div>
</form>