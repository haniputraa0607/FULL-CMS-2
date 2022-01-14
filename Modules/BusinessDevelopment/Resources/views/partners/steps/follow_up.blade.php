<?php 
  $step_follow_up = 1;
  if(!empty($result['partner_step'])){
    foreach($result['partner_step'] as $i => $step){
      $step_follow_up = $i + 2; 
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
                 var htmls='<div class="form-group"><label for="example-search-input" class="control-label col-md-4">Commission<span class="required" aria-required="true">*</span><i class="fa fa-question-circle tooltips" data-original-title="komisi product" data-container="body"></i></label><div class="col-md-5"><input class="form-control" required type="number" id="sharing_value" name="sharing_value" min="1" max="99" placeholder="Enter Commission Percent"/></div></div>';
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
        var SweetAlertNextSteps = function() {
            return {
                init: function() {
                    $(".sweetalert-next-steps").each(function() {
                        var token  	= "{{ csrf_token() }}";
                        var pathname = window.location.pathname; 
                        let column 	= $(this).parents('tr');
                        let id     	= $(this).data('id');
                        let name    = $(this).data('name');
                        var data = {
                            '_token' : '{{csrf_token()}}',
                            'id_partner':id
                                        };
                        $(this).click(function() {
                            swal({
                                    title: "Approved?",
                                    text: "You will be directed to the next step!",
                                    type: "warning",
                                    showCancelButton: true,
                                    confirmButtonClass: "btn-success",
                                    confirmButtonText: "Yes, Next Step!",
                                    closeOnConfirm: false
                                },
                                function(){
                                    $.ajax({
                                        type : "POST",
                                        url : "{{url('businessdev/partners/approved-follow-up')}}",
                                        data : data,
                                        success : function(response) {
                                            if (response.status == 'success') {
                                                swal("Success!", "Next Step", "success")
                                                SweetAlert.init()
                                                 window.location.reload();
                                            }
                                            else if(response.status == "fail"){
                                                swal("Error!", "Failed to delete.", "error")
                                            }
                                            else {
                                                swal("Error!", "Something went wrong. Failed to delete .", "error")
                                            }
                                        }
                                    });
                                });
                        })
                    })
                }
            }
        }();
        jQuery(document).ready(function() {
            SweetAlertNextSteps.init();
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
                    <span class="caption-subject font-dark sbold uppercase font-yellow">Follow Up Data</span>
                </div>
                @if($result['status']=='Candidate'&&$result['status_steps']=='On Follow Up' || empty($result['status_steps']))
                    <a href="#form" class="btn btn-sm yellow" type="button" style="float:right" data-toggle="tab" id="input-follow-up">
                        Follow Up
                    </a>
                    <a href="#table" class="btn btn-sm yellow" type="button" style="float:right" data-toggle="tab" id="back-follow-up">
                        Back
                    </a>
                    @if($step_follow_up>1)
                    <a class="btn btn-sm green sweetalert-next-steps btn-primary" data-id="{{$result['id_partner']}}" type="button" style="float:right" data-toggle="tab" id="next-follow-up">
                        Approved
                    </a>
                    @endif
                @endif
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
                                <a href="#form" class="btn btn-sm yellow" type="button" style="float:center" data-toggle="tab" id="input-follow-up">
                                    Follow Up
                                </a>
                                <a href="#table" class="btn btn-sm yellow" type="button" style="float:right" data-toggle="tab" id="back-follow-up">
                                    Back
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane active" id="table">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="kt_datatable">
                                <thead>
                                <tr>
                                    <th class="text-nowrap text-center">Created At</th>
                                    <th class="text-nowrap text-center">Step</th>
                                    <th class="text-nowrap text-center">Note</th>
                                    <th class="text-nowrap text-center">Attachment</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @if(!empty($result['partner_step']))
                                        @foreach($result['partner_step'] as $i => $step)
                                            @if ($step['follow_up']=='Follow Up')
                                                @php $i++; @endphp
                                                <tr data-id="{{ $step['id_steps_log'] }}">
                                                    <td>{{date('d F Y H:i', strtotime($step['created_at']))}}</td>
                                                    <td>{{$step['follow_up']}} {{$i}} </td>
                                                    <td>{{$step['note']}}</td>
                                                    <td>
                                                        @if(isset($step['attachment']))
                                                        <a href="{{ $step['attachment'] }}">Link Download Attachment</a>
                                                        @else
                                                        No Attachment
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="10" style="text-align: center">No Follow Up Yet</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane" id="form">
                        <form class="form-horizontal" role="form" action="{{url('businessdev/partners/create-follow-up')}}" method="post" enctype="multipart/form-data">
                            <div class="form-body">
                                <input type="hidden" name="id_partner" value="{{$result['id_partner']}}">
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Step <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Step yang sedang dilakukan" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <input class="form-control" type="text" id="follow_up" name="follow_up" value="@if($step_follow_up<2)Follow Up {{ $step_follow_up }} @else Follow Up @endif" readonly required/>
                                    </div>
                                </div>
                                {{--  @if ($step_follow_up==1)
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Partner Title <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Badan usaha perusahaan partner (PT/CV/Persero/dll)" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <input class="form-control" type="text" id="title" name="title" placeholder="Enter partner title here" value="{{ old('title') }}" required/>
                                    </div>
                                </div>   
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Partner Code <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Kode yang akan digunakan partner kedepannya" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <input class="form-control" type="text" id="partner_code" name="partner_code" placeholder="Enter partner code here" value="{{ old('partner_code') }}" required/>
                                    </div>
                                </div>   
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Mobile 
                                        <i class="fa fa-question-circle tooltips" data-original-title="Nomor telepon partner yang terintegrasi ke whats app, jika tidak diisi default nomor telepon yang terdaftar sebelumnya" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <input class="form-control" type="text" id="mobile" name="mobile" placeholder="Enter mobile here" value="{{ old('mobile') }}" />
                                    </div>
                                </div>   
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">NPWP <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Nomor NPWP partner" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <input class="form-control" type="text" id="npwp" name="npwp" placeholder="Enter npwp here" value="{{ old('npwp') }}" required/>
                                    </div>
                                </div>   
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">NPWP Name <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Nama NPWP partner" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <input class="form-control" type="text" id="npwp_name" name="npwp_name" placeholder="Enter npwp name here" value="{{ old('npwp_name') }}" required/>
                                    </div>
                                </div>   
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">NPWP Address <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Alamat NPWP Partner" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <textarea name="npwp_address" id="npwp_address" class="form-control" placeholder="Enter npwp address here" required>{{ old('npwp_address') }}</textarea>
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
                                    <label for="example-search-input" class="control-label col-md-4">Cooperation Scheme<span class="required" aria-required="true">*</span>
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
                                    <label for="example-search-input" class="control-label col-md-4">Partner Note <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Catatan tentang perusahaan/instansi partner" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <textarea name="partner_note" id="partner_note" class="form-control" placeholder="Enter partner note here" required>{{ old('partner_note') }}</textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Start Date <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Tanggal mulai menjadi partner atau tanggal kerja sama dimulai" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                            <input type="text" id="start_date" class="datepicker form-control" name="start_date" value="{{ (!empty($result['start_date']) ? date('d F Y', strtotime($result['start_date'])) : '')}}" required>
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
                                            <input type="text" id="end_date" class="datepicker form-control" name="end_date" value="{{ (!empty($result['end_date']) ? date('d F Y', strtotime($result['end_date'])) : '')}}" required>
                                            <span class="input-group-btn">
                                                <button class="btn default" type="button">
                                                    <i class="fa fa-calendar"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="id_location" value="{{$result['partner_locations'][0]['id_location']??''}}">
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Location Name <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Nama calon lokasi yang diajukan oleh perusahaan/instansi" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <input class="form-control" type="text" id="follow-name-location" name="nameLocation" value="{{ old('nameLocation') ?? $result['partner_locations'][0]['name']??''}}" placeholder="Enter location name here" required/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Location Code <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Kode yang akan digunakan lokasi milik partner kedepannya" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <input class="form-control" type="text" id="location_code" name="location_code" placeholder="Enter location code here" value="{{ old('location_code') }}" required/>
                                    </div>
                                </div>   
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Location Address <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Alamat lengkap calon lokasi yang diajukan" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <textarea name="addressLocation" id="follow-address-location" class="form-control" placeholder="Enter location name here" required>{{ old('addressLocation') ?? $result['partner_locations'][0]['address']??''}}</textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Location Short Addres <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Alamat singakt calon lokasi yang diajukan" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <input class="form-control" type="text" id="follow-mall" name="mall" value="{{ old('mall') ?? $result['partner_locations'][0]['mall']??''}}" placeholder="Enter location mall here" required/>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Location City <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Kota/Kabupaten dari calon lokasi" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <select class="form-control select2" name="id_cityLocation" id="follow-id_cityLocation" required>
                                            <option value="" selected disabled>Select City</option>
                                            @foreach($cities as $city)
                                                <option value="{{$city['id_city']}}" @if(old('id_cityLocation')) @if(old('id_cityLocation') == $city['id_city']) selected @endif @else @if($result['partner_locations'][0]['id_city']??'' == $city['id_city']) selected @endif @endif>{{$city['city_name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Location Brand <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Brand yang akan digunakan oleh calon lokasi" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <select class="form-control select2" name="id_brand" id="follow-id_brand" required>
                                            <option value="" selected disabled>Select Brand</option>
                                            @foreach($brands as $brand)
                                                <option value="{{$brand['id_brand']}}" @if(old('id_brand')) @if(old('id_brand') == $brand['id_brand']) selected @endif @else @if($result['partner_locations'][0]['id_brand']??'' == $brand['id_brand']) selected @endif @endif>{{$brand['name_brand']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Location Tax <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Apakah lokasi akan menggunakan PPN" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <input type="checkbox" class="make-switch" data-size="small" data-on-color="info" data-on-text="Use Tax" name="is_tax" data-off-color="default" data-off-text="Not Using Tax">
                                    </div>
                                </div>    
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Location Large <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Luas dari lokasi yang diajukan" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                            <input class="form-control" type="text" id="location_large" name="location_large" placeholder="Enter location large here" value="{{ old('location_large') }}" required/>
                                            <span class="input-group-addon">m<sup>2</sup></span>
                                        </div>
                                    </div>
                                </div>    
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Rental Price <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Harga sewa dari lokasi per tahun" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                            <span class="input-group-addon">Rp</span>
                                            <input class="form-control" type="text" data-type="currency" id="rental_price" name="rental_price" placeholder="Enter rental price here" value="{{ old('rental_price') }}" required/>
                                        </div>
                                    </div>
                                </div>    
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Service Charge <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Perkiraan biaya servis untuk lokasi yang diajukan" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                            <span class="input-group-addon">Rp</span>
                                            <input class="form-control" type="text" data-type="currency" id="service_charge" name="service_charge" placeholder="Enter service charge here" value="{{ old('service_charge') }}" required/>
                                        </div>
                                    </div>
                                </div>    
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Promotion Levy <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Promosi yang nantinya akan dipakai" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                            <span class="input-group-addon">Rp</span>
                                            <input class="form-control" type="text" data-type="currency" id="promotion_levy" name="promotion_levy" placeholder="Enter promotion levy here"  value="{{ old('promotion_levy') }}" required/>
                                        </div>
                                    </div>
                                </div>    
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Contractor Price <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Biaya kontraktor untuk membangun lokasi" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                            <span class="input-group-addon">Rp</span>
                                            <input class="form-control" type="text" data-type="currency" id="renovation_cost" name="renovation_cost" placeholder="Enter renovation cost here" value="{{ old('renovation_cost') }}" required/>
                                        </div>
                                    </div>
                                </div>    
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Partnership Fee <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Biaya kerja sama yang akan dibayarkan partner ke IXOBOX" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                            <span class="input-group-addon">Rp</span>
                                            <input class="form-control" type="text" data-type="currency" id="partnership_fee" name="partnership_fee" placeholder="Enter partnership fee here" value="{{ old('partnership_fee') }}" required/>
                                        </div>
                                    </div>
                                </div>    
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Income <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Perkiraan permasukan per bulan" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                            <span class="input-group-addon">Rp</span>
                                            <input class="form-control" type="text" data-type="currency" id="income" name="income" placeholder="Enter income here" value="{{ old('income') }}" required/>
                                        </div>
                                    </div>
                                </div>    
                                @endif  --}}
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Note <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Catatan untuk step ini" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <textarea name="note" id="note" class="form-control" placeholder="Enter note here" required>{{ old('note') }}</textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Import Attachment
                                        <i class="fa fa-question-circle tooltips" data-original-title="Unggah file jika ada lampiran yang diperlukan" data-container="body"></i><br>
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
                                                            <input type="file" accept=".pdf, application/pdf, application/x-pdf,application/acrobat, applications/vnd.pdf, text/pdf, text/x-pdf" class="file" name="import_file">
                                                        </span>
                                                <a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-actions">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-md-offset-4 col-md-8">
                                            <button type="submit" class="btn blue">Submit</button>
                                            @if($result['status']=='Candidate') <a class="btn red sweetalert-reject" data-id="{{ $result['id_partner'] }}" data-name="{{ $result['name'] }}">Reject</a> @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>