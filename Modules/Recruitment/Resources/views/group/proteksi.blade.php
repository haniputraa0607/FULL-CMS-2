<script>
    function addFormula(param,key){
		var textvalue = $('#formula'+key).val();
		var textvaluebaru = textvalue+" "+param;
		$('#formula'+key).val(textvaluebaru);
        }
</script>
<div style="white-space: nowrap;">
    <div class="tab-pane">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject font-dark sbold uppercase font-yellow">Proteksi Outlet</span>
                    <br>
                    <br>
                    <span class="caption-subject font-dark">Empty value to use the default value.</span>
                </div>
            </div>
            <form role="form" class="form-horizontal" action="{{url('recruitment/hair-stylist/group/proteksi/create')}}" method="POST" enctype="multipart/form-data">
					{{ csrf_field() }}
					<div class="form-body">
                                            <input type="hidden" value="{{$result['id_hairstylist_group']}}" name="id_hairstylist_group" placeholder="Masukkan nama grup" class="form-control" required />
                                            <div id="id_commission">
                                                     <div class="form-group">
                                                    <label for="example-search-input" class="control-label col-md-4">Range<span class="required" aria-required="true">*</span>
                                                        <i class="fa fa-question-circle tooltips" data-original-title="Maksimal umur outlet(bulan) yang dapat di proteksi" data-container="body"></i></label>
                                                    <div class="col-md-4">
                                                        <input type="number" name="range" value="{{$proteksi['range']??''}}" placeholder="{{$proteksi['range']??''}}" class="form-control" disabled />
                                                    </div>
                                                </div>
                                                     <div class="form-group">
                                                    <label for="example-search-input" class="control-label col-md-4">Nominal<span class="required" aria-required="true">*</span>
                                                        <i class="fa fa-question-circle tooltips" data-original-title="Nominal maksimal yang di dapat saat proteksi" data-container="body"></i></label>
                                                    <div class="col-md-4">
                                                        <input type="text" name="value" data-type="currency" value="{{$proteksi['value_group']??''}}" placeholder="{{$proteksi['value']??''}}" class="form-control" required />
                                                    </div>
                                                </div>
                                                </div>
					</div>
                                        
					<div class="form-actions" style="text-align:center;">
						{{ csrf_field() }}
						<button type="submit" class="btn blue" id="checkBtn">Update</button>
					</div>
				</form>
        </div>
    </div>
</div>