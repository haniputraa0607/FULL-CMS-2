<?php
$idCategoryUse = [];
?>
<div style="margin-top: -4%">
	<div style="text-align: center"><h3>Training Result</h3></div>
	<hr style="border-top: 2px dashed;">
	<div id="list_data_training">
		<div class="row">
			<div class="col-md-6"></div>
			<div class="col-md-6" style="text-align: right; white-space:nowrap;">
				@if(!empty($dataDoc['Training Completed']) && $detail['user_hair_stylist_status'] == 'Technical Tested')
					<a class="btn blue" onclick="nextStepFromTrainingResult({{$detail['id_user_hair_stylist']}})">Next</a>
				@endif
				@if($detail['user_hair_stylist_status'] == 'Technical Tested' && count($dataDoc['Training Completed']??[]) < count($category_theories))
				<a onclick="submitScore()" class="btn yellow">Submit Score</a>
				@endif
			</div>
		</div>
		<br>
		<table class="table table-striped table-bordered table-hover">
			<thead>
			<tr>
				<th scope="col"> PIC Name </th>
				<th scope="col"> Notes </th>
				<th scope="col"> Attachment </th>
				<th scope="col"> Scores </th>
			</tr>
			</thead>
			<tbody>
			@if(!empty($dataDoc['Training Completed']))
				@foreach($dataDoc['Training Completed'] as $dataTraining)
					<tr>
						<td>{{$dataTraining['process_name_by']}}</td>
						<td>{{$dataTraining['process_notes']}}</td>
						<td>
							@if(!empty($dataTraining['attachment']))
								<a class="btn blue btn-xs" href="{{url('recruitment/hair-stylist/detail/download-file', $dataTraining['id_user_hair_stylist_document'])}}"><i class="fa fa-download"></i></a>
							@endif
						</td>
						<td>
							<a data-toggle="modal" href="#{{$dataTraining['id_user_hair_stylist_document']}}" class="btn btn-primary">Detail</a>
							<?php
								$theories = [];
								$idCategoryUse[] = $dataTraining['id_theory_category'];
								$minScore = 0;
								$totalTheory = 0;
								foreach ($dataTraining['theories'] as $theory){
									$theories[$theory['category_title']][] = $theory;
									$minScore = $minScore + $theory['minimum_score'];
									$totalTheory++;
								}
							?>
							@if(!empty($theories))
							<div id="{{$dataTraining['id_user_hair_stylist_document']}}" class="modal fade bs-modal-lg" tabindex="-1" aria-hidden="true">
								<div class="modal-dialog modal-lg">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
											<h4 class="modal-title">Detail Score</h4>
										</div>
										<div class="modal-body" style="margin-top: -4%">
											<br>
											@foreach($theories as $keyT=>$t)
												<div class="row">
													<div class="col-md-12">
														<p><b>{{$keyT}}</b></p>
													</div>
												</div>
												@foreach($t as $data)
													<div class="row">
														<div class="col-md-7" style="margin-top: -2%;">
															<p>{{$data['theory_title']}}</p>
														</div>
														<div class="col-md-3">
															<div class="input-group">
																<input type="text" class="form-control" value="{{$data['score']}}" disabled>
																<span class="input-group-addon">minimal {{$data['minimum_score']}}</span>
															</div>
														</div>
														<div class="col-md-2">
															<input type="text" class="form-control" value="{{$data['passed_status']}}" disabled>
														</div>
													</div>
												@endforeach
											@endforeach
											<br>
											<hr style="border-top: 1px solid black;">
											<div class="row">
												<div class="col-md-7" style="margin-top: 0.7%"><b>Conclusion Score</b></div>
												<div class="col-md-3">
													<div class="input-group">
														<input type="text" class="form-control" value="{{$dataTraining['conclusion_score']}}" disabled>
														<span class="input-group-addon">minimal {{(int)($minScore/$totalTheory)}}</span>
													</div>
												</div>
												<div class="col-md-2">
													<input type="text" class="form-control" value="{{$dataTraining['conclusion_status']}}" disabled>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							@endif
						</td>
					</tr>
				@endforeach
			@else
				<tr><td colspan="4" style="text-align: center">Data Not Available</td></tr>
			@endif
			</tbody>
		</table>
	</div>
	<div id="form_data_training" style="display: none">
		<div class="row">
			<div class="col-md-6"></div>
			<div class="col-md-6" style="text-align: right;">
				<a onclick="backToListTraining()" class="btn yellow">Back</a>
			</div>
		</div>
		<form class="form-horizontal" id="form_training" role="form" action="{{url($url_back.'/update/'.$detail['id_user_hair_stylist'])}}" method="post" enctype="multipart/form-data">
			<div class="form-body">
				<div class="form-group">
					<label class="col-md-2 control-label" style="text-align: left">PIC Name <span class="required" aria-required="true"> * </span>
					</label>
					<div class="col-md-4">
						<input class="form-control" maxlength="200" type="text" name="data_document[process_name_by]" placeholder="PIC Name" required/>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label" style="text-align: left">Notes <span class="required" aria-required="true"> * </span>
					</label>
					<div class="col-md-6">
						<textarea class="form-control" name="data_document[process_notes]" placeholder="Notes">@if(isset($dataDoc['Training Completed']['process_notes'])) {{$dataDoc['Training Completed']['process_notes']}} disabled @endif</textarea>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label" style="text-align: left">Attachment</label>
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
								<input type="file" name="data_document[attachment]" @if($detail['user_hair_stylist_status'] != 'Candidate') disabled @endif> </span>
								<a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
							</div>
						</div>
					</div>
				</div>
				<?php
					$htmlSelect = '';
					$htmlTheory = '';
					foreach($category_theories as $ct){
						if(!in_array($ct['id_theory_category'], $idCategoryUse)){

							if(empty($ct['child'])){
								$totalMinimumScore = 0;
								$j = 0;
								$htmlTheory .= '<div id="cat_'.$ct['id_theory_category'].'" style="display: none">';
								foreach ($ct['theory'] as $noTheo=>$theory){
									$htmlTheory .= '<div class="form-group">';
									$htmlTheory .= '<div class="col-md-6" style="margin-top: -2%">';
									$htmlTheory .= '<p>'.$theory['theory_title'].'</p>';
									$htmlTheory .= '</div>';
									$htmlTheory .= '<div class="col-md-3">';
									$htmlTheory .= '<div class="input-group">';
									$htmlTheory .= '<input type="text" class="numeric form-control score_theory_'.$ct['id_theory_category'].'" id="score_'.$theory['id_theory'].'" name="data_document[theory]['.$theory['id_theory'].$noTheo.'][score]" placeholder="Score" onkeyup="conclusionScore('.$ct['id_theory_category'].')">';
									$htmlTheory .= '<span class="input-group-addon">minimal '.$theory['minimum_score'].'</span>';
									$htmlTheory .= '<input type="hidden" id="minimum_score_'.$theory['id_theory'].'" value="'.$theory['minimum_score'].'">';
									$htmlTheory .= '</div>';
									$htmlTheory .= '<p style="color: red;margin-top: -1%;display: none" id="error_text_'.$theory['id_theory'].'">Maximal score is 100</p>';
									$htmlTheory .= '</div>';
                                    $htmlTheory .= '<div class="col-md-3">';
                                    $htmlTheory .= '<select class="form-control select2" id="passed_status_'.$theory['id_theory'].'" name="data_document[theory]['.$theory['id_theory'].$no.'][passed_status]">';
                                    $htmlTheory .= '<option value="Passed">Passed<option>';
                                    $htmlTheory .= '<option value="Not Passed">Not Passed<option>';
                                    $htmlTheory .= '</select>';
                                    $htmlTheory .= '</div>';
									$htmlTheory .= '</div>';
									$htmlTheory .= '<input type="hidden" name="data_document[theory]['.$theory['id_theory'].$noTheo.'][id_theory_category]" value="'.$ct['id_theory_category'].'">';
									$htmlTheory .= '<input type="hidden" name="data_document[theory]['.$theory['id_theory'].$noTheo.'][id_theory]" value="'.$theory['id_theory'].'">';
									$htmlTheory .= '<input type="hidden" name="data_document[theory]['.$theory['id_theory'].$noTheo.'][category_title]" value="'.$ct['theory_category_name'].'">';
									$htmlTheory .= '<input type="hidden" name="data_document[theory]['.$theory['id_theory'].$noTheo.'][theory_title]" value="'.$theory['theory_title'].'">';
									$htmlTheory .= '<input type="hidden" name="data_document[theory]['.$theory['id_theory'].$noTheo.'][minimum_score]" value="'.$theory['minimum_score'].'">';

									$totalMinimumScore = $totalMinimumScore + $theory['minimum_score'];
									$j++;
								}

								if(!empty($j)){
									$htmlSelect .= '<option value="'.$ct['id_theory_category'].'">'.$ct['theory_category_name'].'</option>';
									$totalMinimumScore = (int)($totalMinimumScore/$j);
									$htmlTheory .= '<br><hr style="border-top: 1px solid black;">';

									$htmlTheory .= '<div class="form-group">';
									$htmlTheory .= '<div class="col-md-6" style="margin-top: -2%">';
									$htmlTheory .= '<p><b>Conclusion</b></p>';
									$htmlTheory .= '</div>';
									$htmlTheory .= '<div class="col-md-3">';
									$htmlTheory .= '<div class="input-group">';
									$htmlTheory .= '<input type="text" class="numeric form-control" id="conclusion_score_'.$ct['id_theory_category'].'" name="conclusion_score['.$ct['id_theory_category'].']" placeholder="Score" onkeyup="validationConclusion('.$ct['id_theory_category'].')">';
									$htmlTheory .= '<input type="hidden" id="conclusion_minimum_score_'.$ct['id_theory_category'].'" value="'.$totalMinimumScore.'">';
									$htmlTheory .= '<span class="input-group-addon">minimal '.$totalMinimumScore.'</span>';
									$htmlTheory .= '</div>';
									$htmlTheory .= '<p style="color: red;margin-top: -1%;display: none" id="conclusion_error_text_'.$ct['id_theory_category'].'">Maximal score is 100</p>';
									$htmlTheory .= '</div>';
									$htmlTheory .= '<div class="col-md-3">';
									$htmlTheory .= '<select class="form-control select2" id="conclusion_status_'.$ct['id_theory_category'].'" name="conclusion_status['.$ct['id_theory_category'].']">';
									$htmlTheory .= '<option value="Passed">Passed<option>';
									$htmlTheory .= '<option value="Not Passed">Not Passed<option>';
									$htmlTheory .= '</select>';
									$htmlTheory .= '</div>';
									$htmlTheory .= '</div>';
								}
								$htmlTheory .= '</div>';
							}else{
								$htmlTheory .= '<div id="cat_'.$ct['id_theory_category'].'" style="display: none">';
								$totalMinimumScore = 0;
								$j = 0;
								foreach ($ct['child'] as $child){
									if(!empty($child['theory'])){
										$htmlTheory .= '<div class="form-group">';
										$htmlTheory .= '<div class="col-md-8"><b>'.$child['theory_category_name'].'</b></div>';
										$htmlTheory .= '</div>';
									}

									foreach ($child['theory'] as $no=>$theory){
										$htmlTheory .= '<div class="form-group">';
										$htmlTheory .= '<div class="col-md-6" style="margin-top: -2%">';
										$htmlTheory .= '<p>'.$theory['theory_title'].'</p>';
										$htmlTheory .= '</div>';
										$htmlTheory .= '<div class="col-md-3">';
										$htmlTheory .= '<div class="input-group">';
										$htmlTheory .= '<input type="text" class="numeric form-control score_theory_'.$ct['id_theory_category'].'" id="score_'.$theory['id_theory'].'" name="data_document[theory]['.$theory['id_theory'].$no.'][score]" placeholder="Score" onkeyup="conclusionScore('.$ct['id_theory_category'].')">';
										$htmlTheory .= '<span class="input-group-addon">minimal '.$theory['minimum_score'].'</span>';
										$htmlTheory .= '<input type="hidden" id="minimum_score_'.$theory['id_theory'].'" value="'.$theory['minimum_score'].'">';
										$htmlTheory .= '</div>';
										$htmlTheory .= '<p style="color: red;margin-top: -1%;display: none" id="error_text_'.$theory['id_theory'].'">Maximal score is 100</p>';
										$htmlTheory .= '</div>';
                                        $htmlTheory .= '<div class="col-md-3">';
                                        $htmlTheory .= '<select class="form-control select2" id="passed_status_'.$theory['id_theory'].'" name="data_document[theory]['.$theory['id_theory'].$no.'][passed_status]">';
                                        $htmlTheory .= '<option value="Passed">Passed<option>';
                                        $htmlTheory .= '<option value="Not Passed">Not Passed<option>';
                                        $htmlTheory .= '</select>';
                                        $htmlTheory .= '</div>';
										$htmlTheory .= '</div>';
										$htmlTheory .= '<input type="hidden" name="data_document[theory]['.$theory['id_theory'].$no.'][id_theory_category]" value="'.$ct['id_theory_category'].'">';
										$htmlTheory .= '<input type="hidden" name="data_document[theory]['.$theory['id_theory'].$no.'][id_theory]" value="'.$theory['id_theory'].'">';
										$htmlTheory .= '<input type="hidden" name="data_document[theory]['.$theory['id_theory'].$no.'][category_title]" value="'.$child['theory_category_name'].'">';
										$htmlTheory .= '<input type="hidden" name="data_document[theory]['.$theory['id_theory'].$no.'][theory_title]" value="'.$theory['theory_title'].'">';
										$htmlTheory .= '<input type="hidden" name="data_document[theory]['.$theory['id_theory'].$no.'][minimum_score]" value="'.$theory['minimum_score'].'">';

										$totalMinimumScore = $totalMinimumScore + $theory['minimum_score'];
										$j++;
									}
								}

								if(!empty($j)){
									$htmlSelect .= '<option value="'.$ct['id_theory_category'].'">'.$ct['theory_category_name'].'</option>';
									$totalMinimumScore = (int)($totalMinimumScore/$j);
									$htmlTheory .= '<br><hr style="border-top: 1px solid black;">';

									$htmlTheory .= '<div class="form-group">';
									$htmlTheory .= '<div class="col-md-6" style="margin-top: -2%">';
									$htmlTheory .= '<p><b>Conclusion</b></p>';
									$htmlTheory .= '</div>';
									$htmlTheory .= '<div class="col-md-3">';
									$htmlTheory .= '<div class="input-group">';
									$htmlTheory .= '<input type="text" class="numeric form-control" id="conclusion_score_'.$ct['id_theory_category'].'" name="conclusion_score['.$ct['id_theory_category'].']" placeholder="Score" onkeyup="validationConclusion('.$ct['id_theory_category'].')">';
									$htmlTheory .= '<input type="hidden" id="conclusion_minimum_score_'.$ct['id_theory_category'].'" value="'.$totalMinimumScore.'">';
									$htmlTheory .= '<span class="input-group-addon">minimal '.$totalMinimumScore.'</span>';
									$htmlTheory .= '</div>';
									$htmlTheory .= '<p style="color: red;margin-top: -1%;display: none" id="conclusion_error_text_'.$ct['id_theory_category'].'">Maximal score is 100</p>';
									$htmlTheory .= '</div>';
									$htmlTheory .= '<div class="col-md-3">';
									$htmlTheory .= '<select class="form-control select2" id="conclusion_status_'.$ct['id_theory_category'].'" name="conclusion_status['.$ct['id_theory_category'].']">';
									$htmlTheory .= '<option value="Passed">Passed<option>';
									$htmlTheory .= '<option value="Not Passed">Not Passed<option>';
									$htmlTheory .= '</select>';
									$htmlTheory .= '</div>';
									$htmlTheory .= '</div>';
								}
								$htmlTheory .= '</div>';
							}
						}
					}
				?>
				<div class="form-group">
					<label class="col-md-2 control-label" style="text-align: left">Theory <span class="required" aria-required="true"> * </span>
					</label>
					<div class="col-md-6">
						<select  class="form-control select2" name="data_document[id_theory_category]" onchange="changeCategoryTheory(this.value)" data-placeholder="Select Category Theory" required>
							<option></option>
							<?php echo $htmlSelect;?>
						</select>
					</div>
				</div>
				<br>
				<div id="form_theory">
					<?php echo $htmlTheory;?>
				</div>
				<input type="hidden" name="data_document[document_type]" value="Training Completed">
			</div>
			<input type="hidden" name="action_type" id="action_type_training" value="Training Completed">
			@if($detail['user_hair_stylist_status'] != 'Rejected')
			<div class="row" style="text-align: center">
				{{ csrf_field() }}
				<a class="btn red save" data-name="{{ $detail['fullname'] }}" data-status="Rejected" data-form="training">Reject</a>
				<button class="btn blue" id="btn_submit_traning">Submit</button>
			</div>
			@endif
		</form>
	</div>
</div>