<div class="portlet-body form">
    <form class="form-horizontal" role="form" action="{{url('businessdev/partners/outlet/close/createActive')}}" method="post" enctype="multipart/form-data">
        <div class="form-body">
            <input class="form-control" type="hidden" id="id_outlet" name="id_outlet" value="{{$outlet['id_outlet']}}"/>
            <input class="form-control" type="hidden" id="id_partner" name="id_partner" value="{{$outlet['id_partner']}}"/>
            <div class="form-group">
                <label for="example-search-input" class="control-label col-md-4">Title<span class="required" aria-required="true">*</span>
                    <i class="fa fa-question-circle tooltips" data-original-title="Title" data-container="body"></i></label>
                <div class="col-md-5">
                    <input required class="form-control" type="text" id="input-name" name="title" placeholder="Enter title close temporary here"/>
                </div>
            </div>
            <div class="form-group">
                <label for="example-search-input" class="control-label col-md-4">Lokasi<span class="required" aria-required="true">*</span>
                    <i class="fa fa-question-circle tooltips" data-original-title="Lokasi" data-container="body"></i></label>
                <div class="col-md-5">
                      <select name="jenis_active" id="jenis_active" class="form-control input-sm select2" data-placeholder="Pilih Lokasi">
                                    <option value="">Select</option>
                                    <option value="Change Location">Pindah Lokasi</option>
                                    <option value="No Change Location">Tidak Pindah Lokasi</option>
                            </select>
                </div>
            </div>
            <div class="form-group">
                <label for="example-search-input" class="control-label col-md-4">Tanggal Aktif<span class="required" aria-required="true">*</span>
                    <i class="fa fa-question-circle tooltips" data-original-title="Tanggal" data-container="body"></i></label>
                <div class="col-md-5">
                    <div class="input-group">
                        <input type="text" id="date"  class="datepicker form-control" name="date" >
                        <span class="input-group-btn">
                            <button class="btn default" type="button">
                                <i class="fa fa-calendar"></i>
                            </button>
                        </span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="example-search-input" class="control-label col-md-4">Note
                    <i class="fa fa-question-circle tooltips" data-original-title="Note" data-container="body"></i></label>
                <div class="col-md-5">
                    <input class="form-control" type="text" id="input-phone" name="note" placeholder="Enter note"/>
                </div>
            </div>
        <div class="form-actions">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-md-offset-4 col-md-8">
                    <button type="submit" class="btn blue">Submit</button>
                </div>
            </div>
        </div>
        </div>
    </form>
</div>