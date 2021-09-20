@section('social-media')
	<div class="tab-pane" id="social_media">
	    <div class="row" style="margin-top:20px">
	        <div class="col-md-12">
	            <div class="portlet light bordered">
	                <div class="portlet-title">
	                    <div class="caption font-blue ">
	                        <i class="icon-settings font-blue ">
	                        </i>
	                        <span class="caption-subject bold uppercase">
	                            Social Media Setting
	                        </span>
	                    </div>
	                </div>
	                <div class="portlet-body">
	                    <form action="{{url('setting/social_media')}}" class="form-horizontal" enctype="multipart/form-data" method="POST" role="form">
	                        <div class="form-body">
	                            <div class="form-group row">
	                                <label class="text-right col-md-3">
	                                    Facebook Url
	                                </label>
	                                <div class="col-md-6">
	                                    <input class="form-control" name="facebook_url" type="text" value="{{ $social_media['facebook'] }}" autocomplete="off">
	                                </div>
	                            </div>

	                            <div class="form-group row">
	                                <label class="text-right col-md-3">
	                                    Instagram Url
	                                </label>
	                                <div class="col-md-6">
	                                    <input class="form-control" name="instagram_url" type="text" value="{{ $social_media['instagram'] }}" autocomplete="off">
	                                </div>
	                            </div>
								<div class="form-actions" style="text-align:center">
									{{ csrf_field() }}
									<button type="submit" class="btn blue" id="checkBtn">Save</button>
								</div>
	                        </div>
	                    </form>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>
@endsection