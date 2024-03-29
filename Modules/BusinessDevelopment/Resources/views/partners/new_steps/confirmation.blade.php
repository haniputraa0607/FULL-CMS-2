<?php 
    $confir = false;
    $this_location = [];

    if($result['partner_new_step'])
    {
        $id_this_location = null;
        foreach($result['partner_new_step'] as $key => $new_steps){
            if($new_steps['follow_up'] == 'Confirmation Letter' && $new_steps['index'] == $index_step){
                $confir = true;
                $follow_up = $new_steps['follow_up'];
                $note = $new_steps['note'];
                $file = $new_steps['attachment'];
                $id_this_location = $new_steps['id_location'];
            }elseif($new_steps['index'] == $index_step){
                $id_this_location = $new_steps['id_location'];
            }
        }
        if($result['partner_locations']){
            foreach($result['partner_locations'] as $key => $loc){
                if($loc['id_location'] == $id_this_location){
                    $this_location = $loc;
                }
            }
            foreach($confirmation['location'] as $key => $con){
                if($con['id_location'] == $id_this_location){
                    $this_confir = $con;
                }
            }
            foreach($result['partner_confirmation'] as $key => $let){
                if($let['id_location'] == $id_this_location){
                    $this_letter = $let;
                }
            }
        }
    }
?>

<div style="white-space: nowrap;">
    <div class="tab-pane">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject font-dark sbold uppercase font-yellow">Confirmation Letter</span>
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
                                @if ($confir==false)
                                <a href="#form_confir" class="btn btn-sm yellow" type="button" style="float:center" data-toggle="tab" id="input-confir">
                                    Confirmation Letter
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane active" id="form_confir">
                        <form class="form-horizontal" role="form" action="{{url('businessdev/partners/new-follow-up')}}" method="post" enctype="multipart/form-data">
                            <div class="form-body">
                                <input type="hidden" name="id_partner" value="{{$result['id_partner']}}">
                                <input type="hidden" name="index" value="{{$index_step}}">
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Step <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Pilih step" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <input class="form-control" type="text" id="follow_up" name="follow_up" value="Confirmation Letter" readonly required/>
                                    </div>
                                </div>
                                @if($confir==false)
                                <div class="row" style="margin-top: 2%;">
                                    <div class="col-md-6">
                                        <center>
                                            <img class="zoom-in" src="{{ env('STORAGE_URL_VIEW') }}images/confirmation/template_confirmation_1.png" height="200px" onclick="window.open(this.src)"/>
                                        </center>
                                        <p style="text-align: center">(a)</p>
                                    </div>
                                    <div class="col-md-6">
                                        <center>
                                            <img class="zoom-in" src="{{ env('STORAGE_URL_VIEW') }}images/confirmation/template_confirmation_2.png" height="200px" onclick="window.open(this.src)"/>
                                        </center>
                                        <p style="text-align: center">(b)</p>
                                    </div>
                                </div> 
                                <div class="row" style="margin-top: 2%;">
                                    <div class="col-md-12">
                                        <center>
                                            <img class="zoom-in" src="{{ env('STORAGE_URL_VIEW') }}images/confirmation/template_confirmation_3.png" height="200px" onclick="window.open(this.src)"/>
                                        </center>
                                        <p style="text-align: center">(c)</p>
                                    </div>
                                </div> 
                                @endif
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Recipient <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Nama contact person perusahaan yang akan menjalin kontrak kerja sama" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <input class="form-control" type="text" @if(isset($confirmation['pihak_dua'])) value="{{ $confirmation['pihak_dua'] }}" @endif placeholder="- " readonly/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Location <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Lokasi outlet yang diajukan partner" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <input class="form-control" type="text" @if(isset($this_confir['lokasi'])) value="{{ $this_confir['lokasi'] }}" @endif placeholder="- " readonly />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Outlet Address <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Alamat lengkap dari lokasi outlet yang diajukan" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <textarea style="height: 80px" class="form-control" placeholder="- " readonly >@if(isset($this_confir['lokasi'])) {{ $this_confir['address'] }} @endif</textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Outlet Large <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Luas lokasi outlet yang diakukan" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <input class="form-control" type="text" @if(isset($this_confir['large'])) value="{{ $this_confir['large'] }}" @endif placeholder="- " readonly />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Partnership Time <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Masa kerja sama partner dengan IXOBOX" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <input class="form-control" type="text" @if(isset($confirmation['waktu'])) value="{{ $confirmation['waktu'] }}" @endif placeholder="- " readonly />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Total Payment <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Biaya kerja sama yang akan dibayarkan partner ke IXOBOX @if(isset($this_location['value_detail_decode']['Inisiasi Partner']['netto'])) sudah  @else belum @endif termasuk PPN 10%" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <input class="form-control" type="text" @if(isset($this_confir['partnership_fee'])) value="{{ $this_confir['partnership_fee'] }}" @endif placeholder="- " readonly />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Booking Fee <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Biaya booking fee adalah 20% dari Partnership Fee" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <input class="form-control" type="text" @if(isset($this_confir['dp'])) value="{{ $this_confir['dp'] }}" @endif placeholder="- " readonly />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Down Payment 1 <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Biaya booking fee adalah 30% dari Partnership Fee" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <input class="form-control" type="text" @if(isset($this_confir['dp2'])) value="{{ $this_confir['dp2'] }}" @endif placeholder="- " readonly />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Final Payment <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Pembayaran terakhir oleh partner ke IXOBOX" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <input class="form-control" type="text" @if(isset($this_confir['final'])) value="{{ $this_confir['final'] }}" @endif placeholder="- " readonly />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Reference Number <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Nomor surat yang akan dicantumkan di confirmation letter" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <input class="form-control" type="text" id="no_letter" name="no_letter" placeholder="Enter reference number here" required readonly value="{{$this_letter['no_letter']??''}}"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Location Letter <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Lokasi confirmation letter dibuat" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <input class="form-control" type="text" id="location_letter" name="location_letter" placeholder="Enter location letter here" required @if ($confir==true) readonly value="{{$this_letter['location']??''}}" @endif/>
                                    </div>
                                </div>
                                <input type="hidden" name="id_location" value="{{$this_location['id_location']??''}}">
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Payment Note 
                                        <i class="fa fa-question-circle tooltips" data-original-title="Catatan pembayaran berisikan pilihan untuk pengansuran final payment, jika tidak diisi berarti final payment tanpa angsuran" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <textarea style="height: 200px" name="payment_note" id="payment_note" class="form-control" placeholder="Final Payment akan diangsur ..." @if ($confir==true) readonly @endif>{{ $this_location['notes']??'' }}</textarea>
                                    </div>
                                </div> 
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Note
                                        <i class="fa fa-question-circle tooltips" data-original-title="Catatan untuk step in" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <textarea name="note" id="note" class="form-control" placeholder="Enter note here" @if ($confir==true) readonly @endif >@if ($confir==true) {{ $note }} @endif</textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    @if ($confir==false) 
                                    <label for="example-search-input" class="control-label col-md-4">Import Attachment 
                                        <i class="fa fa-question-circle tooltips" data-original-title="Unggah file jika ada lampiran yang diperlukan" data-container="body"></i><br>
                                        <span class="required" aria-required="true"> (PDF max 2 mb) </span></label>
                                    @else
                                    <label for="example-search-input" class="control-label col-md-4">Download Attachment 
                                        <i class="fa fa-question-circle tooltips" data-original-title="Download file yang dilampirkan pada step ini" data-container="body"></i><br></label>
                                    @endif
                                    <div class="col-md-5">
                                        @if ($confir==false) 
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
                                @if ($confir==true)
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Confirmation Letter
                                        <i class="fa fa-question-circle tooltips" data-original-title="Download file confirmation letter" data-container="body"></i><br></label>
                                    <div class="col-md-5">
                                        <label for="example-search-input" class="control-label col-md-4">
                                            <a href="{{ $this_letter['attachment']??'' }}">Download Confirmation Letter</a>
                                        <label>
                                    </div>
                                </div>    
                                @endif
                                @if ($confir==false)
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
                </div> 
            </div>
        </div>
    </div>
</div>