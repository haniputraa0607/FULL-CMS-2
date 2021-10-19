@if($detail['user_hair_stylist_status'] == 'Candidate')
<br>
<div style="text-align: center"><h3>Data Interview</h3></div>
<hr style="border-top: 2px dashed;">
<div class="form-group">
	<label class="col-md-4 control-label">Interview Date <span class="required" aria-required="true"> * </span>
	</label>
	<div class="col-md-4">
		<div class="input-icon right">
			<div class="input-group">
				<input type="text" class="form_datetime form-control" name="data_document[0][process_date]" required autocomplete="off" placeholder="Interview Date">
				<span class="input-group-btn">
					<button class="btn default" type="button">
						<i class="fa fa-calendar"></i>
					</button>
					<button class="btn default" type="button">
						<i class="fa fa-question-circle tooltips" data-original-title="Tanggal dan waktu interview" data-container="body"></i>
					</button>
				</span>
			</div>
		</div>
	</div>
</div>
<div class="form-group">
	<label class="col-md-4 control-label">Interview By <span class="required" aria-required="true"> * </span>
	</label>
	<div class="col-md-4">
		<input class="form-control" maxlength="200" type="text" name="data_document[0][process_name_by]" placeholder="Interview by" required/>
	</div>
</div>
<div class="form-group">
	<label class="col-md-4 control-label">Notes <span class="required" aria-required="true"> * </span>
	</label>
	<div class="col-md-6">
		<textarea class="form-control" name="data_document[0][process_notes]" placeholder="Notes"></textarea>
	</div>
</div>
<div class="form-group">
	<label class="col-md-4 control-label">Attachment <span class="required" aria-required="true"> * </span></label>
	<div class="col-md-6">
		<div class="fileinput fileinput-new" data-provides="fileinput">
			<div class="input-group input-large">
				<div class="form-control uneditable-input input-fixed input-medium" data-trigger="fileinput">
					<i class="fa fa-file fileinput-exists"></i>&nbsp;
					<span class="fileinput-filename"> </span>
				</div>
				<span class="input-group-addon btn default btn-file">
				<span class="fileinput-new"> Select file </span>
				<span class="fileinput-exists"> Change </span>
				<input type="file" name="data_document[0][attachment]" required> </span>
				<a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
			</div>
		</div>
	</div>
</div>
<input type="hidden" name="data_document[0][document_type]" value="Interviewed">
@endif

@if($detail['user_hair_stylist_status'] == 'Interviewed')
<br>
<div style="text-align: center"><h3>Data Technical Test</h3></div>
<hr style="border-top: 2px dashed;">
<div class="form-group">
	<label class="col-md-4 control-label">Test Date <span class="required" aria-required="true"> * </span>
	</label>
	<div class="col-md-4">
		<div class="input-icon right">
			<div class="input-group">
				<input type="text" class="form_datetime form-control" name="data_document[1][process_date]" required autocomplete="off" placeholder="Test Date">
				<span class="input-group-btn">
					<button class="btn default" type="button">
						<i class="fa fa-calendar"></i>
					</button>
					<button class="btn default" type="button">
						<i class="fa fa-question-circle tooltips" data-original-title="Tanggal dan waktu tes teknis" data-container="body"></i>
					</button>
				</span>
			</div>
		</div>
	</div>
</div>
<div class="form-group">
	<label class="col-md-4 control-label">Test By <span class="required" aria-required="true"> * </span>
	</label>
	<div class="col-md-4">
		<input class="form-control" maxlength="200" type="text" name="data_document[1][process_name_by]" placeholder="Test By" required/>
	</div>
</div>
<div class="form-group">
	<label class="col-md-4 control-label">Notes <span class="required" aria-required="true"> * </span>
	</label>
	<div class="col-md-6">
		<textarea class="form-control" name="data_document[1][process_notes]" placeholder="Notes"></textarea>
	</div>
</div>
<div class="form-group">
	<label class="col-md-4 control-label">Attachment <span class="required" aria-required="true"> * </span></label>
	<div class="col-md-6">
		<div class="fileinput fileinput-new" data-provides="fileinput">
			<div class="input-group input-large">
				<div class="form-control uneditable-input input-fixed input-medium" data-trigger="fileinput">
					<i class="fa fa-file fileinput-exists"></i>&nbsp;
					<span class="fileinput-filename"> </span>
				</div>
				<span class="input-group-addon btn default btn-file">
				<span class="fileinput-new"> Select file </span>
				<span class="fileinput-exists"> Change </span>
				<input type="file" name="data_document[1][attachment]" required> </span>
				<a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
			</div>
		</div>
	</div>
</div>
<input type="hidden" name="data_document[1][document_type]" value="Technical Tested">
@endif

@if($detail['user_hair_stylist_status'] == 'Technical Tested')
	<br>
	<div style="text-align: center"><h3>Training Result</h3></div>
	<hr style="border-top: 2px dashed;">
	<div class="form-group">
		<label class="col-md-4 control-label">PIC Name <span class="required" aria-required="true"> * </span>
		</label>
		<div class="col-md-4">
			<input class="form-control" maxlength="200" type="text" name="data_document[2][process_name_by]" placeholder="PIC Name" required/>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-4 control-label">Notes <span class="required" aria-required="true"> * </span>
		</label>
		<div class="col-md-6">
			<textarea class="form-control" name="data_document[2][process_notes]" placeholder="Notes"></textarea>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-4 control-label">Attachment <span class="required" aria-required="true"> * </span></label>
		<div class="col-md-6">
			<div class="fileinput fileinput-new" data-provides="fileinput">
				<div class="input-group input-large">
					<div class="form-control uneditable-input input-fixed input-medium" data-trigger="fileinput">
						<i class="fa fa-file fileinput-exists"></i>&nbsp;
						<span class="fileinput-filename"> </span>
					</div>
					<span class="input-group-addon btn default btn-file">
				<span class="fileinput-new"> Select file </span>
				<span class="fileinput-exists"> Change </span>
				<input type="file" name="data_document[2][attachment]" required> </span>
					<a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
				</div>
			</div>
		</div>
	</div>
	<input type="hidden" name="data_document[2][document_type]" value="Training Completed">
@endif