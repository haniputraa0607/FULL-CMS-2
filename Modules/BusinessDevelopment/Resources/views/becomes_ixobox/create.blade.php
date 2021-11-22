<div class="portlet-body form">
    <form class="form-horizontal" role="form" action="{{url('businessdev/partners/becomes-ixobox/lampiran/create')}}" method="post" enctype="multipart/form-data">
        <div class="form-body">
            <input class="form-control" type="hidden" id="id_partners_becomes_ixobox" name="id_partners_becomes_ixobox" value="{{$result['id_partners_becomes_ixobox']}}"/>
            <div class="form-group">
                <label for="example-search-input" class="control-label col-md-4">Title<span class="required" aria-required="true">*</span>
                    <i class="fa fa-question-circle tooltips" data-original-title="Judul dokumen untuj pengajuan" data-container="body"></i></label>
                <div class="col-md-5">
                    <input required class="form-control" type="text" id="input-name" name="title" placeholder="Enter name here"/>
                </div>
            </div>
            <div class="form-group">
                <label for="example-search-input" class="control-label col-md-4">Note
                    <i class="fa fa-question-circle tooltips" data-original-title="Catatan untuk dokumen yang diunggah" data-container="body"></i></label>
                <div class="col-md-5">
                    <input class="form-control" type="text" id="input-phone" name="note" placeholder="Enter note"/>
                </div>
            </div>
            <div class="form-group">
                <label for="example-search-input" class="control-label col-md-4">Import Attachment<span class="required" aria-required="true">*</span>
                    <i class="fa fa-question-circle tooltips" data-original-title="Unggah file dokumen untuk melanjutkan proses pengajuan selanjutnya" data-container="body"></i><br>
                    <span class="required" aria-required="true"> (PDF max 2 mb) </span></label>
                <div class="col-md-5">
                    <div class="fileinput fileinput-new text-left" data-provides="fileinput">
                        <div class="input-group input-large">
                            <div class="form-control uneditable-input input-fixed input-medium" data-trigger="fileinput">
                                <i class="fa fa-file fileinput-exists"></i>&nbsp;
                                <span class="fileinput-filename"> </span>
                            </div>
                            <span class="input-group-addon btn default btn-file">
                                        <span class="fileinput-new"> Select file </span>
                                        <span class="fileinput-exists"> Change </span>
                                        <input required type="file" accept=".pdf, application/pdf, application/x-pdf,application/acrobat, applications/vnd.pdf, text/pdf, text/x-pdf" class="file" name="import_file">
                                    </span>
                            <a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                        </div>
                    </div>
            </div>
        </div>
        @if($result['status']=="Process")
        <div class="form-actions">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-md-offset-4 col-md-8">
                    <button type="submit" class="btn blue">Submit</button>
                </div>
            </div>
        </div>
        @endif
        </div>
    </form>
</div>