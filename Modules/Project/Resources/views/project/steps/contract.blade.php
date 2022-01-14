<?php 
    $nominal = number_format($result['project_locations']['renovation_cost']??0,0,'.',',');
    $contract = false;
    $prog = false;
    $first_party = null;
    $second_party = null;
    $note = null;
    $nomor_loi = $nomor_loi;
    $date_spk = date('Y-m-d');
    $tanggal_loi = date('Y-m-d');
    $tanggal_buka_loi = date('Y-m-d');
    $nama_pic = $result['project_survey']['nama_pic_mall']??'';
    $kontak_pic = $result['project_survey']['cp_pic_mall']??'';
    $lokasi_pic = null;
    $attachment = null;
    $next_contract = false;
    if($result['progres']=='Contract'){
        $contract = true;
    }
    if ($result['project_contract']!=null){
        $spk = url('project/excel/contract').'/'.$result['id_project'];
        $id_projects_contract = $result['project_contract']['id_projects_contract'];
        $first_party = $result['project_contract']['first_party'];
        $second_party = $result['project_contract']['second_party'];
        $note = $result['project_contract']['note'];
        $nomor_loi = $result['project_contract']['nomor_loi'];
        $tanggal_loi = $result['project_contract']['tanggal_loi'];
        $tanggal_buka_loi = $result['project_contract']['tanggal_buka_loi'];
        $nama_pic = $result['project_contract']['nama_pic'];
        $kontak_pic = $result['project_contract']['kontak_pic'];
        $lokasi_pic = $result['project_contract']['lokasi_pic'];
        $attachment = $result['project_contract']['attachment'];
        $created_at = $result['project_contract']['updated_at'];
        $date_spk = $result['project_contract']['tanggal_spk'];
        $nominal = number_format($result['project_contract']['renovation_cost']??0,0,'.',',');
//        if($result['project_contract']['status']=='Process'){
//           $next_contract = true;
//        }
        
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
            var decimal_pos = input_val.indexOf(",");

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



    var SweetAlertSubmitContract = function() {
            return {
                init: function() {
                    $(".sweetalert-contract-submit").each(function() {
                        var token  	= "{{ csrf_token() }}";
                        var pathname = window.location.pathname; 
                        let column 	= $(this).parents('tr');
                        let id     	= $(this).data('id');
                        let name    = $(this).data('name');
                        var data = {
                                    '_token' : '{{csrf_token()}}',
                                    'id_project':{{$result['id_project']}}
                                        };
                        $(this).click(function() { swal({
                                    title: "Submit data?",
                                    text: "Check your data before submit!",
                                    type: "warning",
                                    showCancelButton: true,
                                    confirmButtonClass: "btn-success",
                                    confirmButtonText: "Yes, submit it!",
                                    closeOnConfirm: false
                                },
                                function(){
                                    $('#conract_form').submit();
                                });
                        })
                    })
                }
            }
        }();
         function number(id){
            $(id).inputmask("remove");
            $(id).inputmask({
                mask: "0999 9999 999999",
                removeMaskOnSubmit: true,
                placeholder:"",
                prefix: "",
                digits: 0,
                // groupSeparator: '.',
                rightAlign: false,
                greedy: false,
                autoGroup: true,
                digitsOptional: false,
            });
        }
        jQuery(document).ready(function() {
             number("#kontak_pic");
             number("#cp_kontraktor");
            SweetAlertSubmitContract.init()
        });
    </script>
<div style="white-space: nowrap;">
    <div class="tab-pane">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject font-dark sbold uppercase font-yellow">Contract</span>
                </div>
            </div>
            <div class="tabbable-line tabbable-full-width">
             @if($result['progres']!='Contract' )
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#overview_contract" data-toggle="tab">Overview </a>
                </li>
                    <li>
                        <a href="#invoice" data-toggle="tab">Invoice SPK </a>
                    </li>
                    <li>
                        <a href="#purchase" data-toggle="tab">Purchase SPK </a>
                    </li>
            </ul>
             @endif
                <div class="tab-content">
                    <div class="tab-pane active" id="overview_contract">
                        <div class="portlet-body form">
                            <form class="form-horizontal" id="conract_form" role="form" action="{{url('project/create/contract')}}" method="post" enctype="multipart/form-data">
                            <div class="form-body">
                                <input type="hidden" name="id_project" value="{{$result['id_project']}}">
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">First Party<span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Pihak 1" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <input class="form-control" @if($result['status']!='Process' ) disabled @elseif($result['progres']!='Contract') disabled @endif type="text" id="first_party" name="first_party" value="{{$first_party}}" placeholder="Enter Pihak 1" required/>
                                    </div>
                                </div>
                               <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Second Party<span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Pihak 2" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <input class="form-control" type="text" @if($result['status']!='Process' ) disabled @elseif($result['progres']!='Contract') disabled @endif id="second_party" name="second_party" value="{{$second_party}}" placeholder="Enter Pihak 2" required/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Contractor Name<span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Nama Kontraktor" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <input class="form-control" @if($result['status']!='Process' ) disabled  @elseif($result['progres']!='Contract') disabled @endif type="text" id="nama_kontraktor" name="nama_kontraktor" value="{{$result['project_contract']['nama_kontraktor']??''}}" placeholder="Nama Kontraktor" required/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">CP Contractor<span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Kontak Kontraktor" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <input class="form-control" @if($result['status']!='Process' ) disabled  @elseif($result['progres']!='Contract') disabled @endif type="text" id="cp_kontraktor" name="cp_kontraktor" value="{{$result['project_contract']['cp_kontraktor']??''}}" placeholder="Kontak Kontraktor (0xxx xxxx xxxxx)" required/>
                                    </div>
                                </div>
                               <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">No SPK<span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Nomor SPK" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <input class="form-control" type="text" @if($result['status']!='Process' ) disabled @elseif($result['progres']!='Contract') disabled @endif id="nomor_spk" name="nomor_spk" value="{{$result['project_contract']['nomor_spk']??$nomor_spk}}" placeholder="Enter Nomor SPK" required/>
                                    </div>
                                </div>
                               <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Date SPK<span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Tanggal SPK" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                            <input placeholder="Tanggal SPK" type="text" id="tanggal_spk" @if($result['status']!='Process' ) disabled @elseif($result['progres']!='Contract') disabled @endif class="datepicker form-control" name="tanggal_spk" value="{{ (!empty($date_spk) ? date('d F Y', strtotime($date_spk)) : '')}}" >
                                            <span class="input-group-btn">
                                                <button class="btn default" type="button">
                                                    <i class="fa fa-calendar"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Attachment SPK<span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Lampiran SPK" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <input class="form-control" placeholder="Lampiran (2 Lembar)" type="text" @if($result['status']!='Process' ) disabled @elseif($result['progres']!='Contract') disabled @endif id="lampiran" name="lampiran" value="{{$result['project_contract']['lampiran']??'2 Lembar'}}" required/>
                                    </div>
                                </div>
                               <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">No LOI<span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Nomor Letter Of Intens" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <input placeholder="Enter Nomor LOI" class="form-control" type="text" @if($result['status']!='Process' ) disabled @elseif($result['progres']!='Contract') disabled @endif id="nomor_loi" name="nomor_loi" value="{{$nomor_loi}}" required/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Date LOI<span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Tanggal LOI" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                            <input placeholder="Enter Tanggal LOI" type="text" id="tanggal_loi" @if($result['status']!='Process' ) disabled @elseif($result['progres']!='Contract') disabled @endif class="datepicker form-control" name="tanggal_loi" value="{{ (!empty($tanggal_loi) ? date('d F Y', strtotime($tanggal_loi)) : '')}}" >
                                            <span class="input-group-btn">
                                                <button class="btn default" type="button">
                                                    <i class="fa fa-calendar"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Open Date by LOI<span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Tanggal buka menurut LOI" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                            <input placeholder="Tanggal Buka Menurut LOI" type="text" id="tanggal_buka_loi" @if($result['status']!='Process' ) disabled @elseif($result['progres']!='Contract') disabled @endif class="datepicker form-control" name="tanggal_buka_loi" value="{{ (!empty($tanggal_buka_loi) ? date('d F Y', strtotime($tanggal_buka_loi)) : '')}}" >
                                            <span class="input-group-btn">
                                                <button class="btn default" type="button">
                                                    <i class="fa fa-calendar"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                               <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">PIC Name<span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Nama Person in Charge" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <input class="form-control" type="text" @if($result['status']!='Process' ) disabled @elseif($result['progres']!='Contract') disabled @endif id="nama_pic" name="nama_pic" value="{{$nama_pic}}" placeholder="Nama PIC" required/>
                                    </div>
                                </div>
                               <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">CP PIC<span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Kontak Person in Charge" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <input  class="form-control" type="text" @if($result['status']!='Process' ) disabled @elseif($result['progres']!='Contract') disabled @endif id="kontak_pic" name="kontak_pic" value="{{$kontak_pic}}" placeholder="Kontak PIC" required/>
                                    </div>
                                </div>
                               <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Location PIC<span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Lokasi Person in Charge" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <input  class="form-control" type="text" @if($result['status']!='Process' ) disabled @elseif($result['progres']!='Contract') disabled @endif id="lokasi_pic" name="lokasi_pic" value="{{$lokasi_pic}}" placeholder="Lokasi PIC" required/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Renovation Cost<span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Biaya renovasi lokasi" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <input class="form-control" @if($result['status']!='Process' ) disabled @elseif($result['progres']!='Contract') disabled @endif  placeholder="Rp 1,000,000.00" data-type="currency"  type="text" id="renovation_cost" name="renovation_cost"  value="{{$nominal}}"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Note</label>
                                    <div class="col-md-5">
                                        <textarea name="note" id="note" @if($result['status']!='Process' ) disabled @elseif($result['progres']!='Contract') disabled @endif class="form-control" placeholder="Enter note here">{{$note}}</textarea>
                                    </div>
                                </div>
                                @if($result['status']=='Process' && $result['progres']=='Contract')
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
                                                            <input type="file" accept=".pdf, application/pdf, application/x-pdf,application/acrobat, applications/vnd.pdf, text/pdf, text/x-pdf" class="file" name="import_file">
                                                        </span>
                                                <a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @if(@$attachment!=null)
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Link Download file<span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Download file" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <br>
                                        <a target="_blank" target='blank' href="{{ env('STORAGE_URL_API').$attachment }}"><i class="fa fa-download" style="font-size:48px"></i></a>
                                    </div>
                                </div>
                                @endif
                                @if ($contract==true&&$result['status']=='Process') 
                                <div class="form-actions">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-md-offset-4 col-md-8">
                                            <a class="btn blue sweetalert-contract-submit">Submit</a>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </form>
                        </div>
                    </div>
                    {{-- tab step --}}
                    <div class="tab-pane" id="invoice">
                        <div class="portlet-body form">
                            <form class="form-horizontal" id="conract_form" role="form"  method="post" enctype="multipart/form-data">
                            <div class="form-body">
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">ID Sales Invoice</label>
                                    <div class="col-md-5">
                                        <input class="form-control" disabled  type="text" id="first_party" name="first_party" value="{{$result['invoice_spk']['id_sales_invoice']??''}}"required/>
                                    </div>
                                </div>
                            
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Amount</label>
                                    <div class="col-md-5">
                                        <input class="form-control" disabled  type="text" id="first_party" name="first_party" value="Rp {{number_format($result['invoice_spk']['amount']??0,2,',','.')}}"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">DPP</label>
                                    <div class="col-md-5">
                                        <input class="form-control" disabled  type="text" id="first_party" name="first_party" value="Rp {{number_format($result['invoice_spk']['dpp']??0,2,',','.')}}"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">DPP Tax</label>
                                    <div class="col-md-5">
                                        <input class="form-control" disabled  type="text" id="first_party" name="first_party" value="Rp {{number_format($result['invoice_spk']['dpp_tax']??0,2,',','.')}}"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Tax</label>
                                    <div class="col-md-5">
                                        <input class="form-control" disabled  type="text" id="first_party" name="first_party" value="{{$result['invoice_spk']['tax']??0}}"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Tax Value</label>
                                    <div class="col-md-5">
                                        <input class="form-control" disabled  type="text" id="first_party" name="first_party" value="Rp {{number_format($result['invoice_spk']['tax_value']??0,2,',','.')}}"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Netto</label>
                                    <div class="col-md-5">
                                        <input class="form-control" disabled  type="text" id="first_party" name="first_party" value="Rp {{number_format($result['invoice_spk']['netto']??0,2,',','.')}}"/>
                                    </div>
                                </div>
                            <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Tax Date</label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                            <input disabled type="text" id="grand_opening" class="form_datetime form-control" name="grand_opening" value="{{ (!empty( $result['invoice_spk']['tax_date']) ? date('d M Y H:i', strtotime( $result['invoice_spk']['tax_date'])) : '')}}" >
                                            <span class="input-group-btn">
                                                <button class="btn default" type="button">
                                                    <i class="fa fa-calendar"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                @if(!empty($result['invoice_spk']['value_detail']))
                                        @foreach(json_decode($result['invoice_spk']['value_detail'],true) as $st)
                                             <div class="form-group">
                                                <label for="example-search-input" class="control-label col-md-4">Sales Invoice Detail ID</label>
                                                <div class="col-md-5">
                                                    <input class="form-control" disabled  type="text" id="first_party" name="first_party" value="{{$st['SalesInvoiceDetailID']??0}}"/>
                                                </div>
                                            </div> 
                                             <div class="form-group">
                                                <label for="example-search-input" class="control-label col-md-4">ID Item</label>
                                                <div class="col-md-5">
                                                    <input class="form-control" disabled  type="text" id="first_party" name="first_party" value="{{$st['ItemID']??0}}"/>
                                                </div>
                                            </div> 
                                             <div class="form-group">
                                                <label for="example-search-input" class="control-label col-md-4">Quantity</label>
                                                <div class="col-md-5">
                                                    <input class="form-control" disabled  type="text" id="first_party" name="first_party" value="{{$st['Qty']??0}}"/>
                                                </div>
                                            </div> 
                                        @endforeach
                                    @endif
                             </div>
                        </form>
                        </div>
                    </div>
                    
                    <div class="tab-pane" id="purchase">
                        <div class="portlet-body form">
                            <form class="form-horizontal" id="conract_form" role="form"  method="post" enctype="multipart/form-data">
                            <div class="form-body">
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">ID Request Purchase</label>
                                    <div class="col-md-5">
                                        <input class="form-control" disabled  type="text" id="first_party" name="first_party" value="{{$result['purchase_spk']['id_request_purchase']??''}}"required/>
                                    </div>
                                </div>
                            
                                </div>
                        </form>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="kt_datatable">
                                <thead>
                                <tr>
                                    <th class="text-nowrap text-center">Detail ID</th>
                                    <th class="text-nowrap text-center">ID Purchase</th>
                                    <th class="text-nowrap text-center">Item ID</th>
                                    <th class="text-nowrap text-center">Qty</th>
                                    <th class="text-nowrap text-center">Unit</th>
                                    <th class="text-nowrap text-center">Code</th>
                                    <th class="text-nowrap text-center">Ratio</th>
                                    <th class="text-nowrap text-center">UnitRatio</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @if(!empty($result['purchase_spk']['value_detail']))
                                        @foreach(json_decode($result['purchase_spk']['value_detail'],true) as $step)
                                                <tr>
                                                <td> {{$step['PurchaseRequestDetailID']}}</td>
                                                <td> {{$step['PurchaseRequestID']}}</td>
                                                <td> {{$step['ItemID']}}</td>
                                                <td> {{$step['Qty']}}</td>
                                                <td> {{$step['Unit']}}</td>
                                                <td> {{$step['BudgetCode']}}</td>
                                                <td> {{$step['Ratio']}}</td>
                                                <td> {{$step['UnitRatio']}}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="10" style="text-align: center">No Data Purchase SPK</td>
                                        </tr>
                                    @endif
                                </tbody>
                                
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>