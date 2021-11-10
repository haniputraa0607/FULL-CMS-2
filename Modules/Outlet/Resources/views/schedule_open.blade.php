<form class="form-horizontal" role="form" action="{{ url('outlet/schedule/save') }}" method="post" enctype="multipart/form-data">
  <div class="form-body">
  		<div class="form-group" id="parent">
  			@if (empty($outlet[0]['outlet_schedules']))
  				@php
  					$sch = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
  				@endphp

  				@foreach ($sch as $i => $val)
  					<div class="row">
		            	<div class="col-md-2">
							<label style="margin-top: 5px;margin-left: 15px;"><b>{{ $val }}  : </b></label>
		                    <input type="hidden" name="day[]" value="{{ $val }}">
		                </div>
		                <div class="col-md-3">
		                    <input type="text" data-placeholder="select time start" class="form-control mt-repeater-input-inline kelas-open timepicker timepicker-no-seconds" name="open[]" @if (old('open') != '') value="{{ old('open') }}" @else value="07:00" @endif data-show-meridian="false" readonly>
		                </div>
		                <div class="col-md-3" style="padding-bottom: 5px">
		                    <input type="text" data-placeholder="select time end" class="form-control mt-repeater-input-inline kelas-close timepicker timepicker-no-seconds" name="close[]" @if (old('close') != '') value="{{ old('close') }}" @else value="22:00" @endif data-show-meridian="false" readonly>
		                </div>
						<div class="col-md-2" style="padding-bottom: 5px;margin-top: 5px;">
		                    <label class="mt-checkbox mt-checkbox-outline"> Same All
                                <input type="checkbox" name="ampas[]" class="same" data-check="ampas" data-id="{{$i}}"/>
                                <span></span>
                            </label>
		                </div>
		                <div class="col-md-2" style="padding-bottom: 5px;margin-top: 5px;">
		                    <label class="mt-checkbox mt-checkbox-outline"> Closed
                                <input type="checkbox" class="is_closed" data-id="is_closed{{$i}}"/>
                                <input type="hidden" name="is_closed[]" id="is_closed{{$i}}" value="0"/>
                                <span></span>
                            </label>
		                </div>
		            </div>
					<?php
					$shiftTitle = [
						'Morning' => 'Pagi',
						'Middle' => 'Tengah',
						'Evening' => 'Sore'
					];
					$j = 0;
					?>
					@foreach($shiftTitle as $key=>$shift)
						<?php
						$html = '';
						$html .= '<div class="row">';
						$html .= '<div class="col-md-2" style="text-align: right">';
						$html .= '<label style="margin-top: 5px;margin-left: 15px;">Shift '.$shift;
						$html .= '<i class="fa fa-question-circle tooltips" data-original-title="Jika tidak ingin digunakan silahkan isi dengan 0:00" data-container="body"></i>';
						$html .= '</label>';
						$html .= '</div>';
						$html .= '<div class="col-md-3">';
						$html .= '<input type="text" data-placeholder="select time start" name="data_shift['.$i.']['.$j.'][start]" id="shift_start_'.strtolower($key).'_'.$i.'" class="form-control mt-repeater-input-inline shift-start-'.strtolower($key).' timepicker timepicker-no-seconds" data-show-meridian="false" value="0:00" readonly>';
						$html .= '</div>';
						$html .= '<div class="col-md-3" style="padding-bottom: 5px">';
						$html .= '<input type="text" data-placeholder="select time end" name="data_shift['.$i.']['.$j.'][end]" id="shift_end_'.strtolower($key).'_'.$i.'" class="form-control mt-repeater-input-inline shift-end-'.strtolower($key).' timepicker timepicker-no-seconds" data-show-meridian="false" value="0:00" readonly>';
						$html .= '</div>';
						$html .= '<input type="hidden" name="data_shift['.$i.']['.$j.'][shift]" value="'.$key.'">';
						$html .= '</div>';
						$j++;
						echo $html;
						?>
					@endforeach
					<div class="col-md-12" style="border-bottom: 1px solid #eee;margin-bottom: 5px;margin-left: 15px;width: 95%"></div>
  				@endforeach
  			@else
  				@foreach ($outlet[0]['outlet_schedules'] as $i => $val)
  					<div class="row">
		            	<div class="col-md-2">
							<label style="margin-top: 5px;margin-left: 15px;"><b>{{ $val['day'] }}  : </b></label>
		                    <input type="hidden" name="day[]" value="{{ $val['day'] }}">
		                </div>
		                <div class="col-md-3">
		                    <input type="text" data-placeholder="select time start" class="form-control mt-repeater-input-inline kelas-open timepicker timepicker-no-seconds" name="open[]" @if(isset($val['open'])) value="{{ date('H:i', strtotime($val['open'])) }}" @endif data-show-meridian="false" readonly>
		                </div>
		                <div class="col-md-3" style="padding-bottom: 5px">
		                    <input type="text" data-placeholder="select time end" class="form-control mt-repeater-input-inline kelas-close timepicker timepicker-no-seconds" name="close[]" @if(isset($val['open'])) value="{{ date('H:i', strtotime($val['close'])) }}" @endif data-show-meridian="false" readonly>
		                </div>
		                <div class="col-md-2" style="padding-bottom: 5px;margin-top: 5px;">
		                    <label class="mt-checkbox mt-checkbox-outline"> Same All
                                <input type="checkbox" name="ampas[]" class="same" data-check="ampas" data-id="{{$i}}"/>
                                <span></span>
                            </label>
		                </div>
		                <div class="col-md-2" style="padding-bottom: 5px;margin-top: 5px;">
		                    <label class="mt-checkbox mt-checkbox-outline"> Closed
                                <input type="checkbox" class="is_closed" data-id="is_closed{{$i}}" @if(isset($val['is_closed']) && $val['is_closed'] == '1') checked @endif/>
                                <input type="hidden" name="is_closed[]" id="is_closed{{$i}}" value="@if(isset($val['is_closed'])) {{$val['is_closed']}} @else 0 @endif"/>
                                <span></span>
                            </label>
							<i class="fa fa-question-circle tooltips" data-original-title="Aktifkan checkbox jika outlet tutup. Outlet yang tutup tidak akan ditampilkan pada aplikasi" data-container="body"></i>
		                </div>
		            </div>

                    <?php
					$shiftTitle = [
						'Morning' => 'Pagi',
						'Middle' => 'Tengah',
						'Evening' => 'Sore'
					];
                    $j = 0;
                    ?>
                    @foreach($shiftTitle as $key=>$shift)
                        <?php
                        $html = '';
                        $check = array_search($key, array_column($val['time_shift'], 'shift'));
                        $html .= '<div class="row">';
                        $html .= '<div class="col-md-2" style="text-align: right">';
                        $html .= '<label style="margin-top: 5px;margin-left: 15px;">Shift '.$shift;
						$html .= ' <i class="fa fa-question-circle tooltips" data-original-title="Jika tidak ingin digunakan silahkan isi dengan 0:00" data-container="body"></i>';
						$html .='</label>';
                        $html .= '</div>';
                        $html .= '<div class="col-md-3">';
                        $html .= '<input type="text" data-placeholder="select time start" name="data_shift['.$i.']['.$j.'][start]" id="shift_start_'.strtolower($key).'_'.$i.'" class="form-control mt-repeater-input-inline shift-start-'.strtolower($key).' timepicker timepicker-no-seconds" data-show-meridian="false" value="'.($check !== false ? date('H:i', strtotime($val['time_shift'][$check]['shift_time_start'])) : '0:00').'" readonly>';
                        $html .= '</div>';
                        $html .= '<div class="col-md-3" style="padding-bottom: 5px">';
                        $html .= '<input type="text" data-placeholder="select time end" name="data_shift['.$i.']['.$j.'][end]" id="shift_end_'.strtolower($key).'_'.$i.'" class="form-control mt-repeater-input-inline shift-end-'.strtolower($key).' timepicker timepicker-no-seconds" data-show-meridian="false" value="'.($check !== false ? date('H:i', strtotime($val['time_shift'][$check]['shift_time_end'])) : '0:00').'" readonly>';
                        $html .= '</div>';
                        $html .= '<input type="hidden" name="data_shift['.$i.']['.$j.'][shift]" value="'.$key.'">';
                        $html .= '<input type="hidden" name="data_shift['.$i.']['.$j.'][id_outlet_schedule]" value="'.$val['id_outlet_schedule'].'">';
                        $html .= '</div>';
                        $j++;
                        echo $html;
                        ?>
                    @endforeach
                    <div class="col-md-12" style="border-bottom: 1px solid #eee;margin-bottom: 5px;margin-left: 15px;width: 95%"></div>
  				@endforeach
  			@endif
        </div>
  </div>
  <div class="form-actions">
      {{ csrf_field() }}
      <div class="row">
          <div class="col-md-offset-3 col-md-9">
            <input type="hidden" name="id_outlet" value="{{ $outlet[0]['id_outlet'] }}">
            <button type="submit" class="btn green">Submit</button>
          </div>
      </div>
  </div>
</form>