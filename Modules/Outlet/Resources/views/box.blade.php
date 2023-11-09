<form class="form-horizontal" id="form-outlet-box" role="form" action="{{ url('outlet/box/save') }}" method="post">
  <div class="form-body">
  	@if(true)
	  <div class="form-group">
		  <div class="col-md-4">
			  <a class="btn btn-primary" onclick="addOutletBox()">&nbsp;<i class="fa fa-plus-circle"></i> Add Outlet Box </a>
		  </div>
	  </div>
	  @endif
	  <div class="alert alert-info">
	  	Available variable to set in box url:
	  	<ul>
	  		<li><b>%box_code%</b>: will be replaced with box code</li>
	  		<li><b>%status%</b>: will be replaced with on/off status. on=1; off=0</li>
	  	</ul>$
	  	Leave the box url empty to use the default url. default url: {{$default_box_url ?? 'Not Set'}}
	  </div>
	  <br>
	  <div class="form-group">
		  <div class="col-md-2">
			  <b>Box Code</b>
		  </div>
		  <div class="col-md-2">
			  <b>Box Name</b>
		  </div>
		  <div class="col-md-4">
			  <b>URL</b>
		  </div>
		  <div class="col-md-3">
			  <b>Box Status</b>
		  </div>
	  </div>
	  <div id="div_outlet_box_parent">
		  @if (empty($outlet[0]['outlet_box']))
			  <div id="div_outlet_box_parent_0">
				  <div class="form-group">
					  <div class="col-md-2">
						  <input class="form-control" type="text" maxlength="200" id="outlet_box_code_0" name="outlet_box_data[0][outlet_box_code]" required placeholder="Box code"/>
					  </div>
					  <div class="col-md-2">
						  <input class="form-control" type="text" maxlength="200" id="outlet_box_name_0" name="outlet_box_data[0][outlet_box_name]" required placeholder="Enter name"/>
					  </div>
					  <div class="col-md-4">
						  <input class="form-control" type="text" maxlength="255" id="outlet_box_url_0" name="outlet_box_data[0][outlet_box_url]" required placeholder="Enter box URL"/>
							<div class="row appender" data-target="#outlet_box_url_0">
								<div class="col-md-5" style="margin-bottom:5px;margin-top:5px;">
									<span class="btn dark btn-xs btn-block btn-outline var appender-btn" data-toggle="tooltip" title="Text will be replace '%box_code%' with box code" data-value="%box_code%">%box_code%</span>
								</div>
								<div class="col-md-5" style="margin-bottom:5px;margin-top:5px;">
									<span class="btn dark btn-xs btn-block btn-outline var appender-btn" data-toggle="tooltip" title="Text will be replace '%command%' with the command (on/off)" data-value="%command%">%command%</span>
								</div>
								<div class="col-md-5" style="margin-bottom:5px;margin-top:5px;">
									<span class="btn dark btn-xs btn-block btn-outline var appender-btn" data-toggle="tooltip" title="Text will be replace '%time%' with the on time" data-value="%command%">%time%</span>
								</div>
							</div>
					  </div>
					  <div class="col-md-3">
						  <input data-switch="true" type="checkbox" name="outlet_box_data[0][outlet_box_status]" data-on-text="Active" data-off-text="Inactive" checked/>
					  </div>
					  <div class="col-md-1" style="margin-left: -4%">
						  <a class="btn btn-danger btn" onclick="deleteOutletBox(0)">&nbsp;<i class="fa fa-trash"></i></a>
					  </div>
				  </div>
			  </div>
		  @else
			  @foreach($outlet[0]['outlet_box'] as $key=>$val)
				  <div id="div_outlet_box_parent_{{$key}}">
					  <div class="form-group">
						  <div class="col-md-2">
							  <input class="form-control" type="text" maxlength="200" id="outlet_box_code_{{$key}}" name="outlet_box_data[{{$key}}][outlet_box_code]" required placeholder="Box code" value="{{$val['outlet_box_code']}}"/>
						  </div>
						  <div class="col-md-2">
							  <input class="form-control" type="text" maxlength="200" id="outlet_box_name_{{$key}}" name="outlet_box_data[{{$key}}][outlet_box_name]" required placeholder="Enter name" value="{{$val['outlet_box_name']}}"/>
						  </div>
						  <div class="col-md-4">
							  <input class="form-control" type="text" maxlength="255" id="outlet_box_url_{{$key}}" name="outlet_box_data[{{$key}}][outlet_box_url]" required placeholder="Enter box URL" value="{{$val['outlet_box_url']}}"/>
								<div class="appender" data-target="#outlet_box_url_{{$key}}">
									<div class="" style="display: inline-block; margin-bottom:5px;margin-top:5px;">
										<span class="btn dark btn-xs btn-block btn-outline var appender-btn" data-toggle="tooltip" title="Text will be replace '%box_code%' with box code" data-value="%box_code%">%box_code%</span>
									</div>
									<div class="" style="display: inline-block;margin-bottom:5px;margin-top:5px;">
										<span class="btn dark btn-xs btn-block btn-outline var appender-btn" data-toggle="tooltip" title="Text will be replace '%command%' with the command (on/off)" data-value="%command%">%command%</span>
									</div>
									<div style="display: inline-block; margin-bottom:5px;margin-top:5px;">
										<span class="btn dark btn-xs btn-block btn-outline var appender-btn" data-toggle="tooltip" title="Text will be replace '%time%' with the on time" data-value="%time%">%time%</span>
									</div>
								</div>
						  </div>
						  <div class="col-md-3">
							  <input data-switch="true" type="checkbox" name="outlet_box_data[{{$key}}][outlet_box_status]" data-on-text="Active" data-off-text="Inactive" @if($val['outlet_box_status'] == 'Active') checked @endif/>
						  </div>
						  <input type="hidden" name="outlet_box_data[{{$key}}][id_outlet_box]" value="{{$val['id_outlet_box']}}">
					  </div>
				  </div>
			  @endforeach
		  @endif
	  </div>
  </div>
  <div class="form-actions">
      {{ csrf_field() }}
      <div class="row" style="text-align: center;margin-top: 5%">
		  <input type="hidden" name="id_outlet" value="{{ $outlet[0]['id_outlet'] }}">
		  <input type="hidden" name="outlet_code" value="{{ $outlet[0]['outlet_code'] }}">
		  <a onclick="outletBoxSubmit()" class="btn green">Save</a>
      </div>
  </div>
</form>