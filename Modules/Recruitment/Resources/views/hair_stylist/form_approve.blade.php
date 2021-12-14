<div style="margin-top: -4%">
	<form class="form-horizontal" id="form_approve" role="form" action="{{url($url_back.'/update/'.$detail['id_user_hair_stylist'])}}" method="post" enctype="multipart/form-data">
		<div class="form-body">
			<div style="text-align: center"><h3>Approve Action</h3></div>
			<hr style="border-top: 2px dashed;">
			<div class="form-group">
				<label class="col-md-4 control-label">Nickname <span class="required" aria-required="true"> * </span>
				</label>
				<div class="col-md-6">
					<div class="input-icon right">
						<input type="text" placeholder="Nickname" class="form-control" name="nickname" required>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4 control-label">Level <span class="required" aria-required="true"> * </span>
				</label>
				<div class="col-md-6">
					<div class="input-icon right">
						<select  class="form-control select2" name="level" data-placeholder="Select level" required>
							<option></option>
							<option value="Supervisor">Supervisor</option>
							<option value="Hairstylist">Hairstylist</option>
						</select>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label  class="control-label col-md-4">Auto Generate Password <span class="required" aria-required="true">*</span>
					<i class="fa fa-question-circle tooltips" data-original-title="Jika di centang maka password akan di generate otomatis oleh sistem" data-container="body"></i>
				</label>
				<div class="col-md-6">
					<label class="mt-checkbox mt-checkbox-outline">
						<input type="checkbox" name="auto_generate_pin" id="auto_generate_pin" class="same checkbox-product-price" onclick="changeAutoGeneratePin()"/>
						<span></span>
					</label>
				</div>
			</div>
			<div id="div_password">
				<div class="form-group">
					<label for="example-search-input" class="control-label col-md-4">Password <span class="required" aria-required="true">*</span>
						<i class="fa fa-question-circle tooltips" data-original-title="Masukkan password yang akan digunakan untuk login" data-container="body"></i>
					</label>
					<div class="col-md-6">
						<input class="form-control" maxlength="6" type="password" name="pin" id="pin1" placeholder="Enter password" required/>
					</div>
				</div>
				<div class="form-group">
					<label for="example-search-input" class="control-label col-md-4">Re-type Password <span class="required" aria-required="true">*</span>
						<i class="fa fa-question-circle tooltips" data-original-title="Ketik ulang password yang akan digunakan untuk login" data-container="body"></i>
					</label>
					<div class="col-md-6">
						<input class="form-control" maxlength="6" type="password" name="pin2" id="pin2" placeholder="Re-type password" required/>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4 control-label">Assign Outlet <span class="required" aria-required="true"> * </span>
					<i class="fa fa-question-circle tooltips" data-original-title="Penempatan outlet untuk hair stylist" data-container="body"></i>
				</label>
				<div class="col-md-6">
					<div class="input-icon right">
						<select  class="form-control select2" name="id_outlet" data-placeholder="Select outlet" required>
							<option></option>
							@foreach($outlets as $outlet)
								<option value="{{$outlet['id_outlet']}}">{{$outlet['outlet_code']}} - {{$outlet['outlet_name']}}</option>
							@endforeach
						</select>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4 control-label">Group<span class="required" aria-required="true"> * </span>
					<i class="fa fa-question-circle tooltips" data-original-title="Group hair stylist" data-container="body"></i>
				</label>
				<div class="col-md-6">
					<div class="input-icon right">
						<select  class="form-control select2" required name="id_hairstylist_group" data-placeholder="Select Group" required>
							<option></option>
							@foreach($groups as $group)
								<option value="{{$group['id_hairstylist_group']}}">{{$group['hair_stylist_group_code']}} - {{$group['hair_stylist_group_name']}}</option>
							@endforeach
						</select>
					</div>
				</div>
			</div>
		</div>
		<input type="hidden" name="action_type" id="action_type_approve" value="approve">
		<div class="row" style="text-align: center">
			{{ csrf_field() }}
			<a class="btn red save" data-name="{{ $detail['fullname'] }}" data-status="Rejected" data-form="approve">Reject</a>
			<button class="btn green-jungle">Approve</button>
		</div>
	</form>
</div>