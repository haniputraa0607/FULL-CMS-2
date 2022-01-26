<div class="portlet-body form">
    <form class="form-horizontal" role="form" action="{{url('businessdev/partners/outlet/change_location/create')}}" method="post" enctype="multipart/form-data">
        <div class="form-body">
            <input class="form-control" type="hidden" id="id_partner" name="id_partner" value="{{$id_partner}}"/>
            <div class="form-group">
                <label for="example-search-input" class="control-label col-md-4">Outlet<span class="required" aria-required="true">*</span>
                    <i class="fa fa-question-circle tooltips" data-original-title="Pilih outlet yang akan berpindah lokasi. Outlet akan ditutup dan akan dibuat outlet baru" data-container="body"></i></label>
                <div class="col-md-5">
                      <select name="id_outlet" id="id_outlet" class="form-control input-sm select2" placeholder="Search Outlet" data-placeholder="Pilih Outlet">
                                    <option value="">Select Outlet</option>
                                    @if(isset($listoutlet))
                                            @foreach($listoutlet as $row)
                                                    <option value="{{$row['id_outlet']}}">{{$row['outlet_name']}} ({{$row['outlet_code']}}) </option>
                                            @endforeach
                                    @endif
                            </select>
                </div>
            </div>
            <div class="form-group">
                <label for="example-search-input" class="control-label col-md-4">Outlet Close Date<span class="required" aria-required="true">*</span>
                    <i class="fa fa-question-circle tooltips" data-original-title="Tanggal outlet tutup. Outlet akan tutup ketika proses perubahan lokasi sudah selesai." data-container="body"></i></label>
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