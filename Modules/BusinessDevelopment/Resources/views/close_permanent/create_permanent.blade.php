@if($action == true)
<div class="portlet-body form">
    <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject sbold uppercase font-blue">{{$title_permanent}}</span>
            </div>
        </div>
     @if($url == false)
                    <form class="form-horizontal" role="form" action="{{url('businessdev/partners/close-permanent/create')}}" method="post" enctype="multipart/form-data">
                @else
                    <form class="form-horizontal" role="form" action="{{url('businessdev/partners/close-permanent/createActive')}}" method="post" enctype="multipart/form-data">
                @endif
                <input class="form-control" type="hidden" id="input-name" name="id_partner" value='{{$partner['id_partner']}}'  placeholder="Enter name here"/>
                        <div class="form-body">
                            <div class="form-group">
                                <label for="example-search-input" class="control-label col-md-4">Title<span class="required" aria-required="true">*</span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Judul pengajuan" data-container="body"></i></label>
                                <div class="col-md-5">
                                    <input class="form-control" type="text" id="input-name" name="title"  placeholder="Enter name here"/>
                                </div>
                            </div>
                            <div class="form-group">
                                @if($url == false)
                                <label for="example-search-input" class="control-label col-md-4">Submitted Date<span class="required" aria-required="true">*</span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Pengajuan tanggal partner berhenti bekerja sama" data-container="body"></i></label>
                                <div class="col-md-5">
                                    <div class="input-group">
                                        <input type="text" id="close_date"  class="datepicker form-control" name="close_date" >
                                        <span class="input-group-btn">
                                            <button class="btn default" type="button">
                                                <i class="fa fa-calendar"></i>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                                @else
                                <label for="example-search-input" class="control-label col-md-4">Start Date<span class="required" aria-required="true">*</span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="TPengajuan tanggal partner beralih ke IXOBOX" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                            <input type="text" id="close_date" class="datepicker form-control" name="start_date"  >
                                            <span class="input-group-btn">
                                                <button class="btn default" type="button">
                                                    <i class="fa fa-calendar"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="example-search-input" class="control-label col-md-4">Note
                                    <i class="fa fa-question-circle tooltips" data-original-title="Catatan untuk pengajuan ini" data-container="body"></i></label>
                                <div class="col-md-5">
                                    <input class="form-control" type="text" id="input-phone" name="note"  placeholder="Enter note" />
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
                    </form>
</div>
@else
Terdapat Pengajuan yang sedang berjalan
@endif