<div style="margin-top: -4%">
	<form class="form-horizontal" id="form_approve" role="form" action="{{url($url_back.'/update/'.$detail['id_user_hair_stylist'])}}" method="post" enctype="multipart/form-data">
		<div class="form-body">
			<div style="text-align: center"><h3>Approve Action</h3></div>
			<hr style="border-top: 2px dashed;">
			<div class="row">
				<div class="col-md-8"></div>
				<div class="col-md-4" style="text-align: center;">
					<?php
						$avg = 0;
						$avgMin = 0;
						if(!empty($allTotalScore) && !empty($totalTheories) && !empty($allMinScore)){
							$avg = (int)($allTotalScore/$totalTheories);
							$avgMin = (int)($allMinScore/$totalTheories);
						}
					?>
					@if($avg < $avgMin)
						<div style="border: solid 1px red;background-color: red">
							<h4><b style="color: white">Total Score : {{$avg}}/{{$avgMin}}</b></h4>
						</div>
					@else
						<div style="border: solid 1px #26C281;background-color: #26C281">
							<h4><b style="color: white">Total Score : {{$avg}}/{{$avgMin}}</b></h4>
						</div>
					@endif
				</div>
			</div>
			<br>
			<br>
			<div class="form-group">
				<label class="col-md-4 control-label">
					Passed Status & Score<span class="required" aria-required="true"> * </span>
				</label>
				<div class="col-md-3">
					<select class="form-control select2" name="user_hair_stylist_passed_status">
						<option value="Passed" @if($avg >= $avgMin) selected @endif>Passed</option>
						<option value="Not Passed" @if($avg < $avgMin) selected @endif>Not Passed</option>
					</select>
				</div>
				<div class="col-md-3">
					<div class="input-group">
						<input type="text" class="numeric form-control" name="user_hair_stylist_score" value="{{$avg}}">
						<span class="input-group-addon">minimum {{$avgMin}}</span>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4 control-label">ID Card Number <span class="required" aria-required="true"> * </span>
				</label>
				<div class="col-md-6">
					<div class="input-icon right">
						<input type="text" placeholder="ID Card Number" class="form-control" name="id_card_number" required>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4 control-label">Nickname <span class="required" aria-required="true"> * </span>
				</label>
				<div class="col-md-6">
					<div class="input-icon right">
						<input type="text" placeholder="Nickname" class="form-control" name="nickname" autocomplete="new-nickname" required>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4 control-label">Category <span class="required" aria-required="true"> * </span>
				</label>
				<div class="col-md-6">
					<div class="input-icon right">
						<select  class="form-control select2" name="id_hairstylist_category" data-placeholder="Select Category" required>
							<option></option>
							@foreach($hairstylist_category??[] as $category)
								<option value="{{$category['id_hairstylist_category']}}">{{$category['hairstylist_category_name']}}</option>
							@endforeach
						</select>
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
				<label class="col-md-4 control-label">
					Photo<span class="required" aria-required="true"> <br>(300*300) </span>
				</label>
				<div class="col-md-8">
					<div class="fileinput fileinput-new" data-provides="fileinput">
						<div class="fileinput-preview fileinput-exists thumbnail" id="image" style="max-width: 200px; max-height: 200px;"></div>
						<div>
							<span class="btn default btn-file">
							<span class="fileinput-new"> Select image </span>
							<span class="fileinput-exists"> Change </span>
							<input type="file" class="filePhoto" id="fieldphoto" accept="image/*" name="user_hair_stylist_photo">
							</span>
							<a href="javascript:;" id="removeImage" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
						</div>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label  class="control-label col-md-4">Auto Generate PIN <span class="required" aria-required="true">*</span>
					<i class="fa fa-question-circle tooltips" data-original-title="Jika di centang maka pin akan di generate otomatis oleh sistem" data-container="body"></i>
				</label>
				<div class="col-md-6">
					<label class="mt-checkbox mt-checkbox-outline">
						<input type="checkbox" name="auto_generate_pin" id="auto_generate_pin" class="same checkbox-product-price" onclick="changeAutoGeneratePinApprove()"/>
						<span></span>
					</label>
				</div>
			</div>
			<div id="div_password">
				<div class="form-group">
					<label for="example-search-input" class="control-label col-md-4">PIN <span class="required" aria-required="true">*</span>
						<i class="fa fa-question-circle tooltips" data-original-title="Masukkan pin yang akan digunakan untuk login" data-container="body"></i>
					</label>
					<div class="col-md-6">
						<input class="form-control" maxlength="6" type="password" onkeyup="matchPassword('app')" name="pin" id="pinapp1" placeholder="Enter PIN" required autocomplete="new-password"/>
					</div>
				</div>
				<div class="form-group">
					<label for="example-search-input" class="control-label col-md-4">Re-type PIN <span class="required" aria-required="true">*</span>
						<i class="fa fa-question-circle tooltips" data-original-title="Ketik ulang pin yang akan digunakan untuk login" data-container="body"></i>
					</label>
					<div class="col-md-6">
						<input class="form-control" maxlength="6" onkeyup="matchPassword('app')" type="password" name="pin2" id="pinapp2" placeholder="Re-type PIN" required autocomplete="new-password"/>
						<b style="color: red;font-size: 12px;display: none" id="alert_password_app">Password des not match</b>
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
		@if($detail['user_hair_stylist_status'] != 'Rejected')
		<div class="row" style="text-align: center">
			{{ csrf_field() }}
			<a class="btn red save" data-name="{{ $detail['fullname'] }}" data-status="Rejected" data-form="approve">Reject</a>
			<button class="btn green-jungle" id="btn_submit_app">Approve</button>
		</div>
		@endif
	</form>
</div>