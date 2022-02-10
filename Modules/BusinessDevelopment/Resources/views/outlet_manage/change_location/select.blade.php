<?php 
    $select = false;
    $selects = false;
    $this_location = [];
    if($result['status']!='Process'){
        $selects = true;
    }
    if($result['steps'])
    {
        $id_this_location = null;
        foreach($result['steps'] as $key => $new_steps){
            if($new_steps['follow_up'] == 'Select Location' ){
                $select = true;
                $follow_up = $new_steps['follow_up'];
                $note = $new_steps['note'];
                $file = $new_steps['attachment'];
                $id_this_location = $result['id_location'];
            }
        }
        if($partner['partner_locations']){
            foreach($partner['partner_locations'] as $key => $loc){
                if($loc['id_location'] == $id_this_location){
                    $this_location = $loc;
                }
            }
        }
    }
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">

    function myFunction() {
        var scema = $('#flow-select-new-location #cooperation_scheme').val();
                $("#flow-select-new-location #id_percent").show();  
                $('#flow-select-new-location #id_commission').remove();
                myFunctionPercent();
        $('.commision').inputmask("remove");
        $('.commision').inputmask({
            removeMaskOnSubmit: true, 
            placeholder: "",
            alias: "currency", 
            digits: 0, 
            rightAlign: false,
            max: '999999999999999',
            prefix : "",
        });
            
    };

    function myFunctionPercent() {
        var scema = $('#flow-select-new-location #cooperation_scheme').val();
        var id_percent = $("#flow-select-new-location input[name='sharing_percent']:checked").val();
        if(scema == 'Revenue Sharing' || scema == 'Management Fee'){
            if(id_percent == 'on'){
                var htmls='<div class="form-group">'+
                    '<label for="example-search-input" class="control-label col-md-4">Commission<span class="required" aria-required="true">*</span>'+
                    '<i class="fa fa-question-circle tooltips" data-original-title="komisi product" data-container="body"></i></label>'+
                    '<div class="col-md-5">'+
                    '<div class="input-group">'+
                    '<input class="form-control commision-percent" type="text" data-type="currency" required id="sharing_value" name="sharing_value" min="1" max="99" placeholder="Enter Commission Percent" value="@if (old('sharing_value')) {{ old('sharing_value') }} @else @if (!empty($this_location['sharing_value'])) {{ $this_location['sharing_value'] }} @endif @endif" {{$select ? 'disabled' : ''}}/>'+
                    '<span class="input-group-addon">%</span>'+
                    '</div>'+
                    '</div>'+
                    '</div>';
            }else{
                var htmls='<div class="form-group">'+
                    '<label for="example-search-input" class="control-label col-md-4">Commission<span class="required" aria-required="true">*</span>'+
                    '<i class="fa fa-question-circle tooltips" data-original-title="komisi product" data-container="body"></i></label>'+
                    '<div class="col-md-5">'+
                    '<div class="input-group">'+
                    '<span class="input-group-addon">Rp</span>'+
                    '<input class="form-control commision" type="text" data-type="currency" id="sharing_value" name="sharing_value" placeholder="Enter sharing value here" value="@if (old('sharing_value')) {{ number_format(old('sharing_value')) }} @else @if (!empty($this_location['sharing_value'])) {{ number_format($this_location['sharing_value']) }} @endif @endif" {{$select ? 'disabled' : ''}} required/>'+
                    '</div>'+
                    '</div>'+
                    '</div>'; 
            }
            $('#flow-select-new-location #id_commissions').html(htmls);
        }
         $('.commision').inputmask("remove");
        $('.commision').inputmask({
            removeMaskOnSubmit: true, 
            placeholder: "",
            alias: "currency", 
            digits: 0, 
            rightAlign: false,
            max: '999999999999999',
            prefix : "",
        });
        $('.commision-percent').inputmask("remove");
        $('.commision-percent').inputmask({
            removeMaskOnSubmit: true, 
            placeholder: "",
            alias: "currency", 
            digits: 0, 
            rightAlign: false,
            max: '100',
            prefix : "",
        });
    }

    function bundling(id){
        $.ajax({
            type : "GET",
            url : "{{ url('businessdev/partners/bundling') }}/"+id,
            success : function(result) {
                var html_product = '';
                result.forEach(function(data, index){
                    html_product += product(data,index);
                })
                console.log(html_product);
            },
            error : function(result) {
                toastr.warning("Something went wrong. Failed to get data.");
            }
        });
    }

    function product(data, i){
        var html = '<div id="div_product_use_'+i+'">'+
            '<div class="form-group">'+
            '<div class="col-md-4">'+
                    
            '</div>'+
            '</div>'+
            '</div>';
        return html;
    }



    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $("#flow-select-new-location #id_percent").hide(); 
        myFunction();
    });

</script>

<div style="white-space: nowrap;">
    <div class="tab-pane" id="flow-select-new-location">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject font-dark sbold uppercase font-yellow">Select Location</span>
                </div>
            </div>
            <div class="portlet-body form">
                <div class="tab-content">
                    <div class="tab-pane @if($result['status']=='Reject') active @endif">
                        <div class="portlet box red">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="fa fa-gear"></i>Change Location Rejected</div>
                                <div class="tools">
                                    <a href="javascript:;" class="collapse"> </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane active" id="form_calcu">
                        <form class="form-horizontal" role="form" action="{{url('businessdev/partners/outlet/change_location/create-follow-up')}}" method="post" enctype="multipart/form-data">
                            <div class="form-body">
                                <input type="hidden" name="id_outlet_change_location" value="{{$id_outlet_change_location}}">
                                <input type="hidden" name="id_partner" value="{{$result['id_partner']}}">
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Step <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Step yang sedang dilakukan" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <input class="form-control" type="text" id="follow_up" name="follow_up" value="Select Location" readonly required/>
                                    </div>
                                </div> 
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Select Location <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Pilih lokasi yang akan didirikan oleh partner" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        @if($select)
                                        <input class="form-control" type="text" name="location_name" value="{{$this_location['name'] ?? ''}}" readonly required/>
                                        @else
                                        <select class="form-control select2" name="to_id_location" id="to_id_location" required>
                                            <option value="" selected disabled>Select Location</option>
                                            @foreach($list_locations as $list_location)
                                                <option value="{{$list_location['id_location']}}" @if(old('id_location')) @if(old('id_location') == $list_location['to_id_location']) selected @endif @else @if ($this_location) @if($this_location['id_location'] == $list_location['id_location']) selected @endif @endif @endif>{{$list_location['name']}}</option>
                                            @endforeach
                                        </select>
                                        @endif
                                    </div>
                                </div>    
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Select Outlet Starter <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Pilih paket persiapan yang akan digunakan untuk persiapan outlet" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <select class="form-control select2" name="id_outlet_starter_bundling" id="id_outlet_starter_bundling" {{ $select ? 'disabled' : ''}} required>
                                            <option value="" selected disabled>Select Starter</option>
                                            @foreach($list_starters as $list_starter)
                                                <option value="{{$list_starter['id_outlet_starter_bundling']}}" @if(old('id_outlet_starter_bundling')) @if(old('id_outlet_starter_bundling') == $list_starter['id_outlet_starter_bundling']) selected @endif @else @if ($this_location) @if($this_location['id_outlet_starter_bundling'] == $list_starter['id_outlet_starter_bundling']) selected @endif @endif @endif>{{$list_starter['name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>    
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Location Brand <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Brand yang akan digunakan oleh lokasi partner" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <select class="form-control select2" name="id_brand" id="follow-id_brand" {{ $select ? 'disabled' : ''}} required>
                                            <option value="" selected disabled>Select Brand</option>
                                            @foreach($brands as $brand)
                                                <option value="{{$brand['id_brand']}}" @if(old('id_brand')) @if(old('id_brand') == $brand['id_brand']) selected @endif @else @if ($this_location) @if($this_location['id_brand'] == $brand['id_brand']) selected @endif @endif @endif>{{$brand['name_brand']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Term of Payment <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Pilih metode pembayaran partner" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <select class="form-control select2" name="termpayment" id="termpayment" required {{ $select ? 'disabled' : ''}}>
                                            <option value="" selected disabled>Select Brand</option>
                                            @foreach($terms as $term)
                                                <option value="{{$term['id_term_of_payment']}}" @if(old('id_term_of_payment')) @if(old('id_term_of_payment') == $term['id_term_of_payment']) selected @endif @else @if ($this_location) @if($this_location['id_term_of_payment'] == $term['id_term_of_payment']) selected @endif @endif @endif>{{$term['name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>     
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Ownership Status <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Stastus kepemilikan kontrak kerja sama dengan IXOBOX" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <select name="ownership_status" class="form-control input-sm select2" placeholder="Ownership Status" required {{ $select ? 'disabled' : ''}}>
                                            <option value="" selected disabled>Select Ownership Status</option>
                                            <option value="Central" @if(old('ownership_status')) @if(old('ownership_status')=='Central') selected @endif @else @if(isset($this_location['ownership_status'])) @if($this_location['ownership_status'] == 'Central') selected @endif @endif @endif>Central</option>
                                            <option value="Partner" @if(old('ownership_status')) @if(old('ownership_status')=='Partner') selected @endif @else @if(isset($this_location['ownership_status'])) @if($this_location['ownership_status'] == 'Partner') selected @endif @endif @endif>Partner</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Coopertaion Scheme<span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Skema Pembagian hasil partner dengan IXOBOX" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <select name="cooperation_scheme" id="cooperation_scheme" onchange="myFunction()" class="form-control input-sm select2" placeholder="Coopertaion Scheme" required {{ $select ? 'disabled' : ''}}>
                                            <option value="" selected disabled>Select Cooperation Scheme</option>
                                            <option value="Revenue Sharing" @if(old('cooperation_scheme')) @if(old('cooperation_scheme')=='Revenue Sharing') selected @endif @else @if(isset($this_location['cooperation_scheme'])) @if($this_location['cooperation_scheme'] == 'Revenue Sharing') selected @endif @endif @endif>Revenue Sharing</option>
                                            <option value="Management Fee" @if(old('cooperation_scheme')) @if(old('cooperation_scheme')=='Management Fee') selected @endif @else @if(isset($this_location['cooperation_scheme'])) @if($this_location['cooperation_scheme'] == 'Management Fee') selected @endif @endif @endif>Management Fee</option>
                                        </select>
                                    </div>
                                </div>
                                <div id="id_percent">
                                    <div class="form-group">
                                        <label for="example-search-input" class="control-label col-md-4">Percent</label>
                                        <div class="col-md-5">
                                            <input type="checkbox" class="make-switch brand_visibility" onchange="myFunctionPercent()"  data-size="small" data-on-color="info" data-on-text="Percent" data-off-color="default" name='sharing_percent' data-off-text="Nominal" @if (old('sharing_percent')) checked @else @if (isset($this_location['sharing_percent'])) @if ($this_location['sharing_percent'] == 1) checked @endif @endif @endif{{ $select ? 'disabled' : ''}}>
                                        </div>
                                    </div>
                                </div>
                                <div id="id_commission">
                                </div>
                                <div id="id_commissions">
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Company Type <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Lokasi akan akan bernaung dibawah perusahaan IXOBOX jenis yang mana" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <select name="company_type" class="form-control input-sm select2" placeholder="Company Type" required {{ $select ? 'disabled' : ''}}>
                                            <option value="" selected disabled>Select Ownership Status</option>
                                            <option value="PT IMA" @if(old('company_type')) @if(old('company_type')=='PT IMA') selected @endif @else @if(isset($this_location['company_type'])) @if($this_location['company_type'] == 'PT IMA') selected @endif @endif @endif>PT IMA</option>
                                            <option value="PT IMS" @if(old('company_type')) @if(old('company_type')=='PT IMS') selected @endif @else @if(isset($this_location['company_type'])) @if($this_location['company_type'] == 'PT IMS') selected @endif @endif @endif>PT IMS</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Contractor Price <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Biaya kontraktor untuk membangun lokasi" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                            <span class="input-group-addon">Rp</span>
                                            <input class="form-control" type="text" data-type="currency" id="renovation_cost" name="renovation_cost" placeholder="Enter renovation cost here" value="@if (old('renovation_cost')) {{ number_format(old('renovation_cost')) }} @else @if (!empty($this_location['renovation_cost'])) {{ number_format($this_location['renovation_cost']) }} @endif @endif" {{$select ? 'disabled' : ''}} required/>
                                        </div>
                                    </div>
                                </div>  
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Partnership Fee <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Biaya kerja sama yang akan dibayarkan partner ke IXOBOX" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                            <span class="input-group-addon">Rp</span>
                                            <input class="form-control" type="text" data-type="currency" id="partnership_fee" name="partnership_fee" placeholder="Enter partnership fee here" value="@if (old('partnership_fee')) {{ number_format(old('partnership_fee')) }} @else @if (!empty($this_location['partnership_fee'])) {{ number_format($this_location['partnership_fee']) }} @endif @endif" {{$select ? 'disabled' : ''}} required/>
                                        </div>
                                    </div>
                                </div>    
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Income <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Perkiraan permasukan per bulan" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                            <span class="input-group-addon">Rp</span>
                                            <input class="form-control" type="text" data-type="currency" id="income" name="income" placeholder="Enter income here" value="@if (old('income')) {{ number_format(old('income')) }} @else @if (!empty($this_location['income'])) {{ number_format($this_location['income']) }} @endif @endif" {{$select ? 'disabled' : ''}} required/>
                                        </div>
                                    </div>
                                </div>   
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Total Box <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Jumlah box yang dibutuhkan untuk pembuatan outlet" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                            <input class="form-control" type="text" data-type="currency" id="total_box" name="total_box" placeholder="Enter total box here" value="@if (old('total_box')) {{ number_format(old('total_box')) }} @else @if (!empty($this_location['total_box'])) {{ number_format($this_location['total_box']) }} @endif @endif" {{$select ? 'disabled' : ''}} required/>
                                            <span class="input-group-addon">Box</span>
                                        </div>
                                    </div>
                                </div>    
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Start Date 
                                        <i class="fa fa-question-circle tooltips" data-original-title="Tanggal mulai menjadi partner atau tanggal kerja sama dimulai, bisa dikosongkan dan akan diisi tanggal mulai menjadi partner" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                            <input type="text" id="start_date" class="datepicker form-control" name="start_date" value="{{ (!empty($this_location['start_date']) ? date('d F Y', strtotime($this_location['start_date'])) : '')}}" {{$select ? 'disabled' : ''}}>
                                            <span class="input-group-btn">
                                                <button class="btn default" type="button">
                                                    <i class="fa fa-calendar"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">End Date 
                                        <i class="fa fa-question-circle tooltips" data-original-title="Tanggal berakhir menjadi partner atau tanggal kerja sama selesai, bisa dikosongkan dan akan diisi tanggal berakhir partner" data-container="body"></i><br><span class="required" aria-required="true">( must be more than 3 years )</span></label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                            <input type="text" id="end_date" class="datepicker form-control" name="end_date" value="{{ (!empty($this_location['end_date']) ? date('d F Y', strtotime($this_location['end_date'])) : '')}}" {{$select ? 'disabled' : ''}}>
                                            <span class="input-group-btn">
                                                <button class="btn default" type="button">
                                                    <i class="fa fa-calendar"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Handover Date <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Tanggal serah terima outlet/lokasi ke pihak partner" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                            <input type="text" id="handover_date" class="datepicker form-control" name="handover_date" value="{{ (!empty($this_location['handover_date']) ? date('d F Y', strtotime($this_location['handover_date'])) : '')}}" {{$select ? 'disabled' : ''}} required>
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
                                        <textarea name="note" id="note" class="form-control" placeholder="Enter note here" @if ($select==true) readonly @endif >@if ($select==true) {{ $note }} @endif</textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    @if ($select==false) 
                                    <label for="example-search-input" class="control-label col-md-4">Import Attachment 
                                        <i class="fa fa-question-circle tooltips" data-original-title="Unggah file jika ada lampiran yang diperlukan" data-container="body"></i><br>
                                        <span class="required" aria-required="true"> (PDF max 2 mb) </span></label>
                                        @else
                                    <label for="example-search-input" class="control-label col-md-4">Download Attachment 
                                        <i class="fa fa-question-circle tooltips" data-original-title="Download file yang dilampirkan pada step ini" data-container="body"></i><br></label>
                                        @endif
                                    <div class="col-md-5">
                                        @if ($select==false) 
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
                                @if ($selects==false) 
                                <div class="form-actions">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-md-offset-4 col-md-8">
                                            <button type="submit" class="btn blue">Submit</button>
                                             <a class="btn red sweetalert-reject" data-id="{{ $result['id_outlet_change_location'] }}">Reject</a>
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