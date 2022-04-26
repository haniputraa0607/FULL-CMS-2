<div style="margin-top: -4%">
	<form class="form-horizontal" id="form_psychological" role="form" action="{{url($url_back.'/update/'.$detail['id_user_hair_stylist'])}}" method="post" enctype="multipart/form-data">
		<div class="form-body">
			<div style="text-align: center"><h3>Data Complementary </h3></div>
			<hr style="border-top: 2px dashed;">
                        <div class="form-group">
				<label class="col-md-4 control-label">Name Document<span class="required" aria-required="true"> * </span>
				</label>
				<div class="col-md-4">
					<input class="form-control" maxlength="200" type="text" name="data_document[process_name_by]" placeholder="Name Document" required/>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4 control-label">Notes<span class="required" aria-required="true"> * </span>
                                    
				</label>
				<div class="col-md-6">
					<textarea class="form-control" required  name="data_document[process_notes]" placeholder="Notes"></textarea>
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
                                                                <input type="file" required name="data_document[attachment]"> </span>
								<a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
							</div>
						</div>
				</div>
			</div>
			<input type="hidden" name="data_document[document_type]" value="Complementary Document">
			<input type="hidden" name="update_type" value="Active">
		</div>
		<input type="hidden" name="action_type" id="action_type_psychological" value="Complementary Document">
		<div class="row" style="text-align: center">
			{{ csrf_field() }}
			<button class="btn blue">Submit</button>
		</div>
</form>
</div>