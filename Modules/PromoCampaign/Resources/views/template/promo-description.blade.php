<?php
use App\Lib\MyHelper;
$grantedFeature     = session('granted_features');
?>
@section('promo-description')
	@php
		$datenow = date("Y-m-d H:i:s");
		switch ($promo_source) {
			case 'promo_campaign':
				$data_promo = $result;
				break;
			
			case 'deals':
				$data_promo = $deals;
				break;

			case 'subscription':
				$data_promo = $subscription;
				break;

			case 'deals_promotion':
				$data_promo = $deals;
				break;

			default:
				$data_promo = [];
				break;
		}
	@endphp
	<style type="text/css">
		.modal-dialog{
		    position: relative;
		    display: table; /* This is important */ 
		    overflow-y: auto;    
		    overflow-x: auto;
		    width: auto;
		    min-width: 300px;
		}
	</style>

	<div class="portlet-body form">
	    <div class="portlet light bordered">
	        <div class="portlet-title">
	            <div class="caption">
	                <span class="caption-subject font-blue sbold uppercase">Promo Description</span>
	            </div>
	        </div>
		    <div class="portlet-body form">
				<div class="row">
					<div class="col-md-6">
						<div class="profile-info">
							<div class="row static-info">
					            <div class="col-md-12 name"> Default Description :</div>
					            <div class="col-md-12">
					            	<blockquote style="font-size: 14px;margin-top: 12px"> {{ ($data_promo['description'] ?? '') }} </blockquote>
					            </div>
					        </div>
						    <div class="row static-info">
					            <div class="col-md-6 name"> Custom Description :</div>
					            <div class="col-md-6"></div>
					        </div>
							<form id="form-promo-description" class="form-horizontal" role="form" action="{{ url('promo-campaign/promo-description') }}" method="post" enctype="multipart/form-data">
								{{ csrf_field() }}
						        <div class="row static-info">
						            <div class="col-md-6 value">
						            	<div class="input-icon right">
											<textarea name="promo_description" id="field_content_long" class="form-control" placeholder="Deals Description" style="width: 490px;
				  height: 150px;">{{ old('promo_description')??$data_promo['promo_description']??'' }}</textarea>
										</div>
										<input type="hidden" value="{{ $data_promo['id_deals'] ?? null }}" name="id_deals" />
					                    <input type="hidden" value="{{ $data_promo['id_promo_campaign'] ?? null }}" name="id_promo_campaign" />
					                    <input type="hidden" value="{{ $data_promo['id_subscription'] ?? null }}" name="id_subscription" />
					                    <input type="hidden" value="{{ $data_promo['id_deals_promotion_template'] ?? null }}" name="id_deals_promotion_template" />
									</div>
								</div>
				                <button type="submit" class="btn green">update</button>
							</form>
						</div>
					</div>
					<div class="col-md-6">
						<a href="javascript:;" class="img-preview" data-src="{{ env('STORAGE_URL_VIEW') }}img/deals/promo_description_promo.jpg">
							<div style="text-align: center;">
								<img id="imageresource" class="zoom-in img-tutorial" src="{{ env('STORAGE_URL_VIEW') }}img/deals/promo_description_promo.jpg" height="550px" />
								<p style="text-align: center">(b)</p>
							</div>
						</a>
					</div>
				</div>
			</div>
        </div>
	</div>

	<div class="modal fade" id="image-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<h4 class="modal-title" id="myModalLabel">Image preview</h4>
				</div>
				<div class="modal-body">
					<img src="" id="image-preview">
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>

@endsection

@section('promo-description-script')
	{{-- <script type="text/javascript">
		$('.summernote').summernote({
			placeholder: true,
            tabsize: 2,
            height: 120,
            toolbar: [],
            callbacks: {
                onInit: function(e) {
                  this.placeholder
                    ? e.editingArea.find(".note-placeholder").html(this.placeholder)
                    : e.editingArea.remove(".note-placeholder");
                }
            }
		});
	</script> --}}
	<script type="text/javascript">
		$(".img-preview").on("click", function() {
		   $('#image-preview').attr('src', $(this).data('src')); 
		   $('#image-modal').modal('show');
		});
	</script>
@endsection