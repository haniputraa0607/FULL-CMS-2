<?php 
    $select = false;
    if(!empty($result['partner_step'])){
        foreach($result['partner_step'] as $i => $step){
            if($step['follow_up']=='Select Location'){
                $select = true;
                $follow_up = $step['follow_up'];
                $note = $step['note'];
                $file = $step['attachment'];
                $result['partner_locations'][0]['total_payment'] = number_format($result['partner_locations'][0]['total_payment']??0 ,0, '.' , '.' );
            }
        }
    }
?>

<script>
    $(document).ready(function () {
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
    })
</script>

<div style="white-space: nowrap;">
    <div class="tab-pane">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject font-dark sbold uppercase font-yellow">Select Location</span>
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
                                @if ($select==false)
                                <a href="#form_calcu" class="btn btn-sm yellow" type="button" style="float:center" data-toggle="tab" id="input-calcu">
                                    Select Location
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane @if($result['status']=='Candidate' || $select == true) active @endif" id="form_calcu">
                        <form class="form-horizontal" role="form" action="{{url('businessdev/partners/create-follow-up')}}" method="post" enctype="multipart/form-data">
                            <div class="form-body">
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
                                        <select class="form-control select2" name="id_location" id="id_location" required>
                                            <option value="" selected disabled>Select Location</option>
                                            @foreach($list_locations as $list_location)
                                                <option value="{{$list_location['id_location']}}" @if(old('id_location')) @if(old('id_location') == $list_location['id_location']) selected @endif @else @if ($result['partner_locations']) @if($result['partner_locations'][0]['id_location'] == $list_location['id_location']) selected @endif @endif @endif>{{$list_location['name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>    
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Select Outlet Starter <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Pilih paket persiapan yang akan digunakan untuk persiapan outlet" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <select class="form-control select2" name="id_outlet_starter_bundling" id="id_outlet_starter_bundling" required>
                                            <option value="" selected disabled>Select Starter</option>
                                            @foreach($list_starters as $list_starter)
                                                <option value="{{$list_starter['id_outlet_starter_bundling']}}" @if(old('id_outlet_starter_bundling')) @if(old('id_outlet_starter_bundling') == $list_starter['id_outlet_starter_bundling']) selected @endif @else @if ($result['partner_locations']) @if($result['partner_locations'][0]['id_outlet_starter_bundling'] == $list_starter['id_outlet_starter_bundling']) selected @endif @endif @endif>{{$list_starter['name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>    
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Location Brand <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Brand yang akan digunakan oleh lokasi partner" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <select class="form-control select2" name="id_brand" id="follow-id_brand" required>
                                            <option value="" selected disabled>Select Brand</option>
                                            @foreach($brands as $brand)
                                                <option value="{{$brand['id_brand']}}" @if(old('id_brand')) @if(old('id_brand') == $brand['id_brand']) selected @endif @else @if ($result['partner_locations']) @if($result['partner_locations'][0]['id_brand'] == $brand['id_brand']) selected @endif @endif @endif>{{$brand['name_brand']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Contractor Price <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Biaya kontraktor untuk membangun lokasi" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                            <span class="input-group-addon">Rp</span>
                                            <input class="form-control" type="text" data-type="currency" id="renovation_cost" name="renovation_cost" placeholder="Enter renovation cost here" value="@if (old('renovation_cost')) {{ old('renovation_cost') }} @else @if (!empty($result['partner_locations'][0]['renovation_cost'])) {{ $result['partner_locations'][0]['renovation_cost'] }} @endif @endif" required/>
                                        </div>
                                    </div>
                                </div>  
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Partnership Fee <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Biaya kerja sama yang akan dibayarkan partner ke IXOBOX" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                            <span class="input-group-addon">Rp</span>
                                            <input class="form-control" type="text" data-type="currency" id="partnership_fee" name="partnership_fee" placeholder="Enter partnership fee here" value="@if (old('partnership_fee')) {{ old('partnership_fee') }} @else @if (!empty($result['partner_locations'][0]['partnership_fee'])) {{ $result['partner_locations'][0]['partnership_fee'] }} @endif @endif" required/>
                                        </div>
                                    </div>
                                </div>    
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Income <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Perkiraan permasukan per bulan" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                            <span class="input-group-addon">Rp</span>
                                            <input class="form-control" type="text" data-type="currency" id="income" name="income" placeholder="Enter income here" value="@if (old('income')) {{ old('income') }} @else @if (!empty($result['partner_locations'][0]['income'])) {{ $result['partner_locations'][0]['income'] }} @endif @endif" required/>
                                        </div>
                                    </div>
                                </div>   
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Total Box <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Jumlah box yang dibutuhkan untuk pembuatan outlet" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                            <input class="form-control" type="text" id="total_box" name="total_box" placeholder="Enter total box here" value="@if (old('total_box')) {{ old('total_box') }} @else @if (!empty($result['partner_locations'][0]['total_box'])) {{ $result['partner_locations'][0]['total_box'] }} @endif @endif" required/>
                                            <span class="input-group-addon">Box</span>
                                        </div>
                                    </div>
                                </div>    
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Start Date 
                                        <i class="fa fa-question-circle tooltips" data-original-title="Tanggal mulai menjadi partner atau tanggal kerja sama dimulai, bisa dikosongkan dan akan diisi tanggal mulai menjadi partner" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                            <input type="text" id="start_date" class="datepicker form-control" name="start_date" value="{{ (!empty($result['partner_locations'][0]['start_date']) ? date('d F Y', strtotime($result['partner_locations'][0]['start_date'])) : '')}}">
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
                                            <input type="text" id="end_date" class="datepicker form-control" name="end_date" value="{{ (!empty($result['partner_locations'][0]['end_date']) ? date('d F Y', strtotime($result['partner_locations'][0]['end_date'])) : '')}}">
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
                                            <input type="text" id="start_date" class="datepicker form-control" name="handover_date" value="{{ (!empty($result['partner_locations'][0]['handover_date']) ? date('d F Y', strtotime($result['partner_locations'][0]['handover_date'])) : '')}}" required>
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
                                @if ($select==false) 
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