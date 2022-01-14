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
<script type="text/javascript">
        function myFunction() {
        
          var scema             = $('#cooperation_scheme').val();
              if(scema == 'Profit Sharing'){
                 var html   = '<input name="sharing_percent" type="hidden" value="on" /><div class="form-group"><label for="example-search-input" class="control-label col-md-4">Commission<span class="required" aria-required="true">*</span>\
                         <i class="fa fa-question-circle tooltips" data-original-title="komisi product" data-container="body"></i></label>\
                        <div class="col-md-5">\
                          <input class="form-control" required type="number" id="sharing_value" name="sharing_value" min="1" max="99" placeholder="Enter Commission Percent 1% - 99%"/>\
                        </div></div>'; 
                    $("#id_percent").hide();    
                     $('#id_commission').html(html);
                  }else if(scema == 'Management Fee'){
                  $("#id_percent").show();  
                  $('#id_commission').remove();
                  myFunctionPercent();
              }
         
           };
        function myFunctionPercent() {
            var scema             = $('#cooperation_scheme').val();
          var id_percent     	=  $("input[name='sharing_percent']:checked").val();
          if(scema == 'Management Fee'){
              if(id_percent == 'on'){
                 var htmls='<div class="form-group"><label for="example-search-input" class="control-label col-md-4">Commission<span class="required" aria-required="true">*</span>\
                        <i class="fa fa-question-circle tooltips" data-original-title="komisi product" data-container="body"></i></label>\
                        <div class="col-md-5">\
                            <input class="form-control" required type="number" id="sharing_value" name="sharing_value" min="1" max="99" placeholder="Enter Commission Percent"/>\
                        </div></div>';
              }else{
                 var htmls='<div class="form-group"><label for="example-search-input" class="control-label col-md-4">Commission<span class="required" aria-required="true">*</span>\
                         <i class="fa fa-question-circle tooltips" data-original-title="komisi product" data-container="body"></i></label>\
                        <div class="col-md-5">\
                          <input class="form-control" required type="number" id="sharing_value" name="sharing_value"  placeholder="Enter Commission Nominal"/>\
                        </div></div>'; 

              }
                $('#id_commissions').html(htmls);
            }
        }
        $(document).ready(function () {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                myFunction()
            });
        </script>
<script>
        jQuery(document).ready(function() {
            $("input[data-type='currency']").on({
                keyup: function() {
                  formatCurrency($(this));
                },
                blur: function() { 
                  formatCurrency($(this), "blur");
                }
            });
            function formatNumber(n) {
              // format number 1000000 to 1,234,567
              return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
            }
            function formatCurrency(input, blur) {
              // appends $ to value, validates decimal side
              // and puts cursor back in right position.
              // get input value
              var input_val = input.val();
              // don't validate empty input
              if (input_val === "") { return; }
              // original length
              var original_len = input_val.length;
              // initial caret position 
              var caret_pos = input.prop("selectionStart");
              // check for decimal
              if (input_val.indexOf(".") >= 0) {
                // get position of first decimal
                // this prevents multiple decimals from
                // being entered
                var decimal_pos = input_val.indexOf(".");
                // split number by decimal point
                var left_side = input_val.substring(0, decimal_pos);
                // add commas to left side of number
                left_side = formatNumber(left_side);
                // join number by .
                input_val = left_side ;
              } else {
                // no decimal entered
                // add commas to number
                // remove all non-digits
                input_val = formatNumber(input_val);
                input_val = input_val;
                // final formatting
                
              }
              // send updated string to input
              input.val(input_val);
              // put caret back in the right position
              var updated_len = input_val.length;
              caret_pos = updated_len - original_len + caret_pos;
              input[0].setSelectionRange(caret_pos, caret_pos);
            }
        });
    </script>
<div style="white-space: nowrap;">
    <div class="tab-pane">
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
                                        <input class="form-control" type="text" id="partner_code" name="partner_code" placeholder="Enter partner code here" value="{{ old('partner_code') ?? $result['code'] }}" @if ($input==true) readonly @endif required/>
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
                                    <label for="example-search-input" class="control-label col-md-4">Term of Payment <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Pilih metode pembayaran partner" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <select class="form-control select2" name="termpayment" id="termpayment" required>
                                            <option value="" selected disabled>Select Brand</option>
                                            @foreach($terms as $term)
                                                <option value="{{$term['id_term_of_payment']}}" @if(old('termpayment')) @if(old('termpayment') == $term['id_term_of_payment']) selected @endif @else @if($result['id_term_payment'] == $term['id_term_of_payment']) selected @endif @endif>{{$term['name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>     
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Ownership Status <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Stastus kepemilikan kontrak kerja sama dengan IXOBOX" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <select name="ownership_status" class="form-control input-sm select2" placeholder="Ownership Status" required>
                                            <option value="" selected disabled>Select Ownership Status</option>
                                            <option value="Central" @if(old('ownership_status')) @if(old('ownership_status')=='Central') selected @endif @else @if(isset($result['ownership_status'])) @if($result['ownership_status'] == 'Central') selected @endif @endif @endif>Central</option>
                                            <option value="Partner" @if(old('ownership_status')) @if(old('ownership_status')=='Partner') selected @endif @else @if(isset($result['ownership_status'])) @if($result['ownership_status'] == 'Partner') selected @endif @endif @endif>Partner</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Coopertaion Scheme<span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Skema Pembagian hasil partner dengan IXOBOX" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <select name="cooperation_scheme" id="cooperation_scheme" onchange="myFunction()" class="form-control input-sm select2" placeholder="Coopertaion Scheme" required>
                                            <option value="" selected disabled>Select Cooperation Scheme</option>
                                            <option value="Profit Sharing" @if(old('cooperation_scheme')) @if(old('cooperation_scheme')=='Profit Sharing') selected @endif @else @if(isset($result['cooperation_scheme'])) @if($result['cooperation_scheme'] == 'Profit Sharing') selected @endif @endif @endif>Profit Sharing</option>
                                            <option value="Management Fee" @if(old('cooperation_scheme')) @if(old('cooperation_scheme')=='Management Fee') selected @endif @else @if(isset($result['cooperation_scheme'])) @if($result['cooperation_scheme'] == 'Management Fee') selected @endif @endif @endif>Management Fee</option>
                                        </select>
                                    </div>
                                </div>
                                <div id="id_percent">
                                    <div class="form-group">
                                                <label for="example-search-input" class="control-label col-md-4">Percent</label>
                                                <div class="col-md-5">
                                                    <input type="checkbox" class="make-switch brand_visibility" onchange="myFunctionPercent()"  data-size="small" data-on-color="info" data-on-text="Percent" data-off-color="default" name='sharing_percent' data-off-text="Nominal">
                                                </div>
                                            </div>
                                </div>
                                <div id="id_commission">
                                </div>
                                <div id="id_commissions">
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