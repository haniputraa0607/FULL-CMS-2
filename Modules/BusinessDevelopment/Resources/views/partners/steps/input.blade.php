<?php 
    $input = false;
    if(!empty($result['partner_step'])){
        foreach($result['partner_step'] as $i => $step){
            if($step['follow_up']=='Input Data Partner'){
                $input = true;
                $follow_up = $step['follow_up'];
                $note = $step['note'];
                $file = $step['attachment'];
            }
        }
    }
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<div style="white-space: nowrap;">
    <div class="tab-pane" id="input-data-partner">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject font-dark sbold uppercase font-yellow">Input Data Partner</span>
                </div>
            </div>
            <div class="portlet-body form">
                <div class="tab-content">
                    <div class="tab-pane @if($result['status']=='Rejected') active @endif">
                        <div class="portlet box red">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="fa fa-gear"></i>Warning</div>
                                <div class="tools">
                                    <a href="javascript:;" class="collapse"> </a>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <p>Candidate Partner Rejected </p>
                                @if ($input==false)
                                <a href="#form_input" class="btn btn-sm yellow" type="button" style="float:center" data-toggle="tab" id="input-data">
                                    Input Data Partner
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane @if($result['status']=='Candidate' || $input == true) active @endif" id="form_input">
                        <form class="form-horizontal" role="form" action="{{url('businessdev/partners/create-follow-up')}}" method="post" enctype="multipart/form-data">
                            <div class="form-body">
                                <input type="hidden" name="id_partner" value="{{$result['id_partner']}}">
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Step <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Step yang sedang dilakukan" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <input class="form-control" type="text" id="follow_up" name="follow_up" value="Input Data Partner" readonly required/>
                                    </div>
                                </div>
                                {{--  <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Partner Title <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Badan usaha perusahaan partner (PT/CV/Persero/dll)" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <input class="form-control" type="text" id="title" name="title" placeholder="Enter partner title here" value="{{ old('title') ?? $result['title'] }}" @if ($input==true) readonly @endif required/>
                                    </div>
                                </div>     --}}
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Partner Code <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Kode yang akan digunakan partner kedepannya" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <input class="form-control" type="text" id="partner_code" name="partner_code" placeholder="Enter partner code here" value="{{ old('partner_code') ?? $result['code'] }}" readonly required/>
                                    </div>
                                </div>   
                                {{--  <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Mobile 
                                        <i class="fa fa-question-circle tooltips" data-original-title="Nomor telepon partner yang terintegrasi ke whats app, jika tidak diisi default nomor telepon yang terdaftar sebelumnya" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <input class="form-control" type="text" id="mobile" name="mobile" placeholder="Enter mobile here" value="{{ old('mobile') }}" />
                                    </div>
                                </div>     --}}
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">NPWP <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Nomor NPWP partner" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <input class="form-control" type="text" id="npwp" name="npwp" placeholder="Enter npwp here" value="{{ old('npwp') ?? $result['npwp'] }}" @if ($input==true) readonly @endif required/>
                                    </div>
                                </div>   
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">NPWP Name <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Nama NPWP partner" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <input class="form-control" type="text" id="npwp_name" name="npwp_name" placeholder="Enter npwp name here" value="{{ old('npwp_name') ?? $result['npwp_name'] }}" @if ($input==true) readonly @endif required/>
                                    </div>
                                </div>   
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">NPWP Address <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Alamat NPWP Partner" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <textarea name="npwp_address" id="npwp_address" class="form-control" placeholder="Enter npwp address here" required @if ($input==true) readonly @endif>{{ old('npwp_address') ?? $result['npwp_address'] }}</textarea>
                                    </div>
                                </div>   
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Start Date <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Tanggal mulai menjadi partner atau tanggal kerja sama dimulai" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                            <input type="text" id="start_date" class="datepicker form-control" name="start_date" value="{{ (!empty($result['start_date']) ? date('d F Y', strtotime($result['start_date'])) : '')}}" @if ($input==true) readonly @endif required>
                                            <span class="input-group-btn">
                                                <button class="btn default" type="button">
                                                    <i class="fa fa-calendar"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">End Date <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Tanggal berakhir menjadi partner atau tanggal kerja sama selesai" data-container="body"></i><br><span class="required" aria-required="true">( must be more than 3 years )</span></label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                            <input type="text" id="end_date" class="datepicker form-control" name="end_date" value="{{ (!empty($result['end_date']) ? date('d F Y', strtotime($result['end_date'])) : '')}}" @if ($input==true) readonly @endif required>
                                            <span class="input-group-btn">
                                                <button class="btn default" type="button">
                                                    <i class="fa fa-calendar"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Note <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Catatan untuk step in" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <textarea name="note" id="note" class="form-control" placeholder="Enter note here" @if ($input==true) readonly @endif >@if ($input==true) {{ $note }} @endif</textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    @if ($input==false) 
                                    <label for="example-search-input" class="control-label col-md-4">Import Attachment 
                                        <i class="fa fa-question-circle tooltips" data-original-title="Unggah file jika ada lampiran yang diperlukan" data-container="body"></i><br>
                                        <span class="required" aria-required="true"> (PDF max 2 mb) </span></label>
                                        @else
                                    <label for="example-search-input" class="control-label col-md-4">Download Attachment 
                                        <i class="fa fa-question-circle tooltips" data-original-title="Download file yang dilampirkan pada step ini" data-container="body"></i><br></label>
                                        @endif
                                    <div class="col-md-5">
                                        @if ($input==false) 
                                        <div class="fileinput fileinput-new text-left" data-provides="fileinput">
                                            <div class="input-group input-large">
                                                <div class="form-control uneditable-input input-fixed input-medium" data-trigger="fileinput">
                                                    <i class="fa fa-file fileinput-exists"></i>&nbsp;
                                                    <span class="fileinput-filename"> </span>
                                                </div>
                                                <span class="input-group-addon btn default btn-file">
                                                            <span class="fileinput-new"> Select file </span>
                                                            <span class="fileinput-exists"> Change </span>
                                                            <input type="file" accept=".pdf, application/pdf, application/x-pdf,application/acrobat, applications/vnd.pdf, text/pdf, text/x-pdf" class="file" name="import_file">
                                                        </span>
                                                <a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                            </div>
                                        </div>
                                        @else
                                        <label for="example-search-input" class="control-label col-md-4">
                                            @if(isset($file))
                                            <a href="{{ $file }}">Link Download Attachment</a>
                                            @else
                                            No Attachment
                                            @endif
                                        <label>
                                        @endif
                                    </div>
                                </div>
                                @if ($input==false) 
                                <div class="form-actions">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-md-offset-4 col-md-8">
                                            <button type="submit" class="btn blue">Submit</button>
                                            <a class="btn red sweetalert-reject" data-id="{{ $result['id_partner'] }}" data-name="{{ $result['name'] }}">Reject</a>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </form>
                    </div>
                </div> 
            </div>
        </div>
    </div>
</div>