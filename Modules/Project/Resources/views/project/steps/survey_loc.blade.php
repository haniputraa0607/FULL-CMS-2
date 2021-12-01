<?php 
    $surv = false;
    $prog = false;
    $surveyor = null;
    $attachment_surv = null;
    $location_length = 0.01;
    $location_width = 0.01;
    $location_large = 0.01;
    $survey_date = null;
    $note = null;
    $next = false;
    $status = "Process";
    if($result['progres']=='Survey Location'){
        $surv = true;
    }
    if ($result['project_survey']!=null){
        $status = $result['project_survey']['status'];
        $surveyor = $result['project_survey']['surveyor'];
        $location_length = $result['project_survey']['location_length'];
        $location_width = $result['project_survey']['location_width'];
        $location_large = $result['project_survey']['location_large'];
        $survey_date = $result['project_survey']['survey_date'];
        $note = $result['project_survey']['note'];
        $attachment_surv = env('STORAGE_URL_API').$result['project_survey']['attachment'];
        if($result['project_survey']['status']=='Process'){
           $next = true;
        }
        
    }
?>

<script>
        $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        });
    })
    
    var SweetAlertSubmitSurvey = function() {
            return {
               init: function() {
                    $(".sweetalert-survey-submit").each(function() {
                        var token  	= "{{ csrf_token() }}";
                        var pathname = window.location.pathname; 
                        let column 	= $(this).parents('tr');
                        let id     	= $(this).data('id');
                        let name    = $(this).data('name');
                      
                        $(this).click(function() {
                            swal({
                                    title: "Submit data?",
                                    text: "Check your data before submit!",
                                    type: "warning",
                                    showCancelButton: true,
                                    confirmButtonClass: "btn-success",
                                    confirmButtonText: "Yes, submit it!",
                                    closeOnConfirm: false
                                },
                                function(){
                                    $('#survey_form').submit();
                                });
                        })
                    })
                }
            }
        }();
        jQuery(document).ready(function() {
            SweetAlertSubmitSurvey.init()
        });
    </script>
<div style="white-space: nowrap;">
    <div class="tab-pane">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject font-dark sbold uppercase font-yellow">Survey Location</span>
                </div>
            </div>
            <div class="portlet-body form">
                <div class="tab-content">
                    <div id="form_survey">
                        <form class="form-horizontal" id="survey_form" role="form" action="{{url('project/create/survey_location')}}" method="post" enctype="multipart/form-data">
                            <div class="form-body">
                                <input type="hidden" name="id_project" value="{{$result['id_project']}}">
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Surveyor<span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Surveyor" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <input class="form-control" @if($result['status']!='Process' ) disabled  @elseif($result['progres']!='Survey Location') disabled @endif type="text" id="surveyor" name="surveyor" value="{{$surveyor}}" placeholder="Surveyor" required/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Nama PIC<span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Nama PIC Mall" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <input class="form-control" @if($result['status']!='Process' ) disabled  @elseif($result['progres']!='Survey Location') disabled @endif type="text" id="nama_pic_mall" name="nama_pic_mall" value="{{$result['project_survey']['nama_pic_mall']??''}}" placeholder="Nama PIC" required/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Kontak PIC<span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Kontak PIC Mall" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <input class="form-control" @if($result['status']!='Process' ) disabled  @elseif($result['progres']!='Survey Location') disabled @endif type="text" id="cp_pic_mall" name="cp_pic_mall" value="{{$result['project_survey']['cp_pic_mall']??''}}" placeholder="Kontak PIC" required/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Nama Kontraktor<span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Nama Kontraktor" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <input class="form-control" @if($result['status']!='Process' ) disabled  @elseif($result['progres']!='Survey Location') disabled @endif type="text" id="nama_kontraktor" name="nama_kontraktor" value="{{$result['project_survey']['nama_kontraktor']??''}}" placeholder="Nama PIC" required/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Kontak Kontraktor<span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Kontak Kontraktor" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <input class="form-control" @if($result['status']!='Process' ) disabled  @elseif($result['progres']!='Survey Location') disabled @endif type="text" id="cp_kontraktor" name="cp_kontraktor" value="{{$result['project_survey']['cp_kontraktor']??''}}" placeholder="Kontak PIC" required/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Panjang Lokasi (m)<span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Panjang Lokasi (m)" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <input class="form-control" @if($result['status']!='Process' ) disabled @elseif($result['progres']!='Survey Location') disabled @endif type='number' step='0.01'  id="location_length" name="location_length" value="{{$location_length}}" placeholder="Panjang Lokasi (m)" required/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Lebar Lokasi (m)<span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Lebar Lokasi (m)" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <input class="form-control" @if($result['status']!='Process' ) disabled @elseif($result['progres']!='Survey Location') disabled @endif type='number' step='0.01' id="location_width" name="location_width" value="{{$location_width}}" placeholder="Lebar Lokasi (m)" required/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Luas Lokasi (m)<span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Luas Lokasi (m)" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <input class="form-control" @if($result['status']!='Process' ) disabled @elseif($result['progres']!='Survey Location') disabled @endif type='number' step='0.01' id="location_large" value="{{$location_large}}" name="location_large" placeholder="Luas Lokasi (m)" required/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Tanggal Survey<span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Tanggal Survey" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                            <input type="text" id="survey_date" @if($result['status']!='Process' ) disabled @elseif($result['progres']!='Survey Location') disabled @endif class="datepicker form-control" name="survey_date" value="{{ (!empty($survey_date) ? date('d F Y', strtotime($survey_date)) : '')}}" >
                                            <span class="input-group-btn">
                                                <button class="btn default" type="button">
                                                    <i class="fa fa-calendar"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Tanggal Mulai Pekerjaan<span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Tanggal Mulai Pekerjaan" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                            <input type="text" id="tanggal_mulai_pekerjaan" @if($result['status']!='Process' ) disabled @elseif($result['progres']!='Survey Location') disabled @endif class="datepicker form-control" name="tanggal_mulai_pekerjaan" value="{{ (!empty($result['project_survey']['tanggal_mulai_pekerjaan']) ? date('d F Y', strtotime($result['project_survey']['tanggal_mulai_pekerjaan'])) : '')}}" >
                                            <span class="input-group-btn">
                                                <button class="btn default" type="button">
                                                    <i class="fa fa-calendar"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Tanggal Selesai Pekerjaan<span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Tanggal Selesai Pekerjaan" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                            <input type="text" id="tanggal_selesai_pekerjaan" @if($result['status']!='Process' ) disabled @elseif($result['progres']!='Survey Location') disabled @endif class="datepicker form-control" name="tanggal_selesai_pekerjaan" value="{{ (!empty($result['project_survey']['tanggal_selesai_pekerjaan']) ? date('d F Y', strtotime($result['project_survey']['tanggal_selesai_pekerjaan'])) : '')}}" >
                                            <span class="input-group-btn">
                                                <button class="btn default" type="button">
                                                    <i class="fa fa-calendar"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Tanggal Loading Barang<span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Tanggal Loading Barang" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                            <input type="text" id="tanggal_loading_barang" @if($result['status']!='Process' ) disabled @elseif($result['progres']!='Survey Location') disabled @endif class="datepicker form-control" name="tanggal_loading_barang" value="{{ (!empty($result['project_survey']['tanggal_loading_barang']) ? date('d F Y', strtotime($result['project_survey']['tanggal_loading_barang'])) : '')}}" >
                                            <span class="input-group-btn">
                                                <button class="btn default" type="button">
                                                    <i class="fa fa-calendar"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Tanggal Pengiriman Barang<span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Tanggal Pengiriman Barang" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                            <input type="text" id="tanggal_pengiriman_barang" @if($result['status']!='Process' ) disabled @elseif($result['progres']!='Survey Location') disabled @endif class="datepicker form-control" name="tanggal_pengiriman_barang" value="{{ (!empty($result['project_survey']['tanggal_pengiriman_barang']) ? date('d F Y', strtotime($result['project_survey']['tanggal_pengiriman_barang'])) : '')}}" >
                                            <span class="input-group-btn">
                                                <button class="btn default" type="button">
                                                    <i class="fa fa-calendar"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Estimasi Tiba Barang<span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Estimasi Tiba Barang" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                            <input type="text" id="estimasi_tiba" @if($result['status']!='Process' ) disabled @elseif($result['progres']!='Survey Location') disabled @endif class="datepicker form-control" name="estimasi_tiba" value="{{ (!empty($result['project_survey']['estimasi_tiba']) ? date('d F Y', strtotime($result['project_survey']['estimasi_tiba'])) : '')}}" >
                                            <span class="input-group-btn">
                                                <button class="btn default" type="button">
                                                    <i class="fa fa-calendar"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Kondisi<span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Kondisi Lokasi" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <select @if($result['status']!='Process' ) disabled @elseif($result['progres']!='Survey Location') disabled @endif  name="kondisi" class="form-control input-sm select2" placeholder="Status">
                                        <option value="" >Select Kondisi</option>
                                        <option value="Bare" @if(isset($result['project_survey']['kondisi'])) @if($result['project_survey']['kondisi'] == 'Bare') selected @endif @endif>Bare</option>
                                        <option value="Tidak" @if(isset($result['project_survey']['kondisi'])) @if($result['project_survey']['kondisi'] == 'Tidak') selected @endif @endif>Tidak</option>
                                        <option value="Lainnya" @if(isset($result['project_survey']['kondisi'])) @if($result['project_survey']['kondisi'] == 'Lainnya') selected @endif @endif>Lainnya</option>
                                    </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                     <label for="example-search-input" class="control-label col-md-4">Keterangan Kondisi<span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Keterangan Kondisi Lokasi" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <textarea maxlength="255" name="keterangan_kondisi" id="keterangan_kondisi" class="form-control" @if($result['status']!='Process' ) disabled @elseif($result['progres']!='Survey Location') disabled @endif placeholder="Enter Keterangan Kondisi">{{$result['project_survey']['keterangan_kondisi']??''}}</textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Listrik<span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Listrik Lokasi" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <select @if($result['status']!='Process' ) disabled @elseif($result['progres']!='Survey Location') disabled @endif  name="listrik" class="form-control input-sm select2" placeholder="Status">
                                        <option value="" >Select Listrik</option>
                                        <option value="Ada" @if(isset($result['project_survey']['listrik'])) @if($result['project_survey']['listrik'] == 'Ada') selected @endif @endif>Ada</option>
                                        <option value="Tidak" @if(isset($result['project_survey']['listrik'])) @if($result['project_survey']['listrik'] == 'Tidak') selected @endif @endif>Tidak</option>
                                    </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                     <label for="example-search-input" class="control-label col-md-4">Keterangan Listrik<span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Keterangan Listrik Lokasi" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <input name="keterangan_listrik" type="number" id="keterangan_listrik" value="{{$result['project_survey']['keterangan_listrik']??''}}" class="form-control" @if($result['status']!='Process' ) disabled @elseif($result['progres']!='Survey Location') disabled @endif placeholder="Jumlah Watt">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">AC<span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="AC Lokasi" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <select @if($result['status']!='Process' ) disabled @elseif($result['progres']!='Survey Location') disabled @endif  name="ac" class="form-control input-sm select2" placeholder="Status">
                                        <option value="" >Select AC</option>
                                        <option value="Ada" @if(isset($result['project_survey']['ac'])) @if($result['project_survey']['ac'] == 'Ada') selected @endif @endif>Ada</option>
                                        <option value="Tidak" @if(isset($result['project_survey']['ac'])) @if($result['project_survey']['ac'] == 'Tidak') selected @endif @endif>Tidak</option>
                                    </select>
                                    </div>
                                </div>
                                 <div class="form-group">
                                     <label for="example-search-input" class="control-label col-md-4">Keterangan AC<span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Keterangan AC Lokasi" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <textarea maxlength="255" name="keterangan_ac" id="keterangan_ac" class="form-control" @if($result['status']!='Process' ) disabled @elseif($result['progres']!='Survey Location') disabled @endif placeholder="Enter Keterangan AC">{{$result['project_survey']['keterangan_ac']??''}}</textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Air<span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Air Lokasi" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <select @if($result['status']!='Process' ) disabled @elseif($result['progres']!='Survey Location') disabled @endif  name="air" class="form-control input-sm select2" placeholder="Status">
                                        <option value="" >Select Air</option>
                                        <option value="Ada" @if(isset($result['project_survey']['air'])) @if($result['project_survey']['air'] == 'Ada') selected @endif @endif>Ada</option>
                                        <option value="Tidak" @if(isset($result['project_survey']['air'])) @if($result['project_survey']['air'] == 'Tidak') selected @endif @endif>Tidak</option>
                                    </select>
                                    </div>
                                </div>
                                 <div class="form-group">
                                     <label for="example-search-input" class="control-label col-md-4">Keterangan Air<span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Keterangan Air Lokasi" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <textarea maxlength="255" name="keterangan_air" id="keterangan_air" class="form-control" @if($result['status']!='Process' ) disabled @elseif($result['progres']!='Survey Location') disabled @endif placeholder="Enter Keterangan Air">{{$result['project_survey']['keterangan_air']??''}}</textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Internet<span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Internet Lokasi" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <select @if($result['status']!='Process' ) disabled @elseif($result['progres']!='Survey Location') disabled @endif name="internet" class="form-control input-sm select2" placeholder="Status">
                                        <option value="" >Select Air</option>
                                        <option value="Ada" @if(isset($result['project_survey']['internet'])) @if($result['project_survey']['internet'] == 'Ada') selected @endif @endif>Ada</option>
                                        <option value="Tidak" @if(isset($result['project_survey']['internet'])) @if($result['project_survey']['internet'] == 'Tidak') selected @endif @endif>Tidak</option>
                                    </select>
                                    </div>
                                </div>
                                 <div class="form-group">
                                     <label for="example-search-input" class="control-label col-md-4">Keterangan Internet<span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Keterangan Internet Lokasi" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <textarea maxlength="255" name="keterangan_internet" id="keterangan_internet" class="form-control" @if($result['status']!='Process' ) disabled @elseif($result['progres']!='Survey Location') disabled @endif placeholder="Enter Keterangan Air">{{$result['project_survey']['keterangan_internet']??''}}</textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Line Telepon<span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Line Telepon" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <select @if($result['status']!='Process' ) disabled @elseif($result['progres']!='Survey Location') disabled @endif  name="line_telepon" class="form-control input-sm select2" placeholder="Status">
                                        <option value="" >Select Air</option>
                                        <option value="Ada" @if(isset($result['project_survey']['line_telepon'])) @if($result['project_survey']['line_telepon'] == 'Ada') selected @endif @endif>Ada</option>
                                        <option value="Tidak" @if(isset($result['project_survey']['line_telepon'])) @if($result['project_survey']['line_telepon'] == 'Tidak') selected @endif @endif>Tidak</option>
                                    </select>
                                    </div>
                                </div>
                                 <div class="form-group">
                                     <label for="example-search-input" class="control-label col-md-4">Keterangan Line Telepon<span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Keterangan Line Telepon" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <textarea maxlength="255" name="keterangan_line_telepon" id="keterangan_line_telepon" class="form-control" @if($result['status']!='Process' ) disabled @elseif($result['progres']!='Survey Location') disabled @endif placeholder="Enter Keterangan Line Telepon">{{$result['project_survey']['keterangan_line_telepon']??''}}</textarea>
                                    </div>
                                </div>
                                 <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Area Lokasi<span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Area Lokasi" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <select @if($result['status']!='Process' ) disabled @elseif($result['progres']!='Survey Location') disabled @endif  name="area_lokasi" class="form-control input-sm select2" placeholder="Status">
                                        <option value="" >Select Air</option>
                                        <option value="Jabodetabek" @if(isset($result['project_survey']['area_lokasi'])) @if($result['project_survey']['area_lokasi'] == 'Jabodetabek') selected @endif @endif>Jabodetabek</option>
                                        <option value="Non Jabodetabek" @if(isset($result['project_survey']['area_lokasi'])) @if($result['project_survey']['area_lokasi'] == 'Non Jabodetabek') selected @endif @endif>Non Jabodetabek</option>
                                    </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Note</label>
                                    <div class="col-md-5">
                                        <textarea name="note" id="note" class="form-control" @if($result['status']!='Process' ) disabled @elseif($result['progres']!='Survey Location') disabled @endif placeholder="Enter note">{{$note}}</textarea>
                                    </div>
                                </div>
                                @if($result['status']=='Process'&&$status=="Process")
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Import Attachment<br>
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
                                                            <input type="file" accept=".pdf, application/pdf, application/x-pdf,application/acrobat, applications/vnd.pdf, text/pdf, text/x-pdf" class="file" id="import_file" name="import_file">
                                                        </span>
                                                <a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @if(@$attachment_surv!=null)
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Link Download file<span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Download file" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <br>
                                        <a target="_blank" target='blank' href="{{ $attachment_surv }}"><i class="fa fa-download" style="font-size:48px"></i></a>
                                    </div>
                                </div>
                                @endif
                                @if ($surv==true&&$result['status']=='Process') 
                                <div class="form-actions">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-md-offset-4 col-md-8">
                                            <a class="btn blue sweetalert-survey-submit">Submit</a>
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