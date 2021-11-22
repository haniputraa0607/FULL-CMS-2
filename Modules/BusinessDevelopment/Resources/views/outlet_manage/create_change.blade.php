<div class="portlet-body form">
    <form class="form-horizontal" role="form" action="{{url('businessdev/partners/outlet/change/create')}}" method="post" enctype="multipart/form-data">
        <div class="form-body">
            <input class="form-control" type="hidden" id="id_partner" name="id_partner" value="{{$id_partner}}"/>
            <div class="form-group">
                <label for="example-search-input" class="control-label col-md-4">Title<span class="required" aria-required="true">*</span>
                    <i class="fa fa-question-circle tooltips" data-original-title="Title" data-container="body"></i></label>
                <div class="col-md-5">
                    <input required class="form-control" type="text" id="input-name" name="title" placeholder="Enter title here"/>
                </div>
            </div>
            <div class="form-group">
                <label for="example-search-input" class="control-label col-md-4">Outlet<span class="required" aria-required="true">*</span>
                    <i class="fa fa-question-circle tooltips" data-original-title="Outlet" data-container="body"></i></label>
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
                <label for="example-search-input" class="control-label col-md-4">Partner Tujuan<span class="required" aria-required="true">*</span>
                    <i class="fa fa-question-circle tooltips" data-original-title="Partner Tujuan" data-container="body"></i></label>
                <div class="col-md-5">
                      <select name="to_id_partner" id="to_id_partner" class="form-control input-sm select2" placeholder="Search Partner Tujuan" data-placeholder="Pilih Partner Tujuan">
                                    <option value="">Select Partner Tujuan</option>
                                    @if(isset($listpartner))
                                            @foreach($listpartner as $row)
                                                    <option value="{{$row['id_partner']}}">{{$row['name']}} ({{$row['phone']}})</option>
                                            @endforeach
                                    @endif
                            </select>
                </div>
            </div>
            <div class="form-group">
                <label for="example-search-input" class="control-label col-md-4">Tanggal <span class="required" aria-required="true">*</span>
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