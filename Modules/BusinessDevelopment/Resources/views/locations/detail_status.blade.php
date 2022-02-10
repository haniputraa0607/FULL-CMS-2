<?php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');
    $select = false;
    $calcu = false;
    $confir = false;
    $pay = false;
    foreach($steps??[] as $step){
        if($step['follow_up'] == 'Select Location'){
            $select = true;
            $note_select = $step['note'];
        }
        if($step['follow_up'] == 'Calculation'){
            $calcu = true;
            $note_calcu = $step['note'];
        }
        if($step['follow_up'] == 'Confirmation Letter'){
            $confir = true;
            $note_confir = $step['note'];
        }
        if($step['follow_up'] == 'Payment'){
            $pay = true;
            $note_pay = $step['note'];
        }
    }
    $id_partner = $result["location_partner"]["id_partner"];
 ?>
@extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.multidatespicker.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .datepicker{
            padding: 6px 12px;
           }
        .zoom-in {
			cursor: zoom-in;
            border: 1px solid;
		}
    </style>
@endsection

@section('page-plugin')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/js/bootstrap-select.js') }}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-bootstrap-select.min.js') }}"  type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/form-repeater.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js') }}" type="text/javascript"></script>
    <script>
        
        $('.datepicker').datepicker({
            'format' : 'dd MM yyyy',
            'todayHighlight' : true,
            'autoclose' : true
        });
        
        $('.select2').select2();
        function number(id){
            $(id).inputmask("remove");
            $(id).inputmask({
                mask: "9999 9999 999999",
                removeMaskOnSubmit: true,
                placeholder:"",
                prefix: "",
                //digits: 0,
                // groupSeparator: '.',
                rightAlign: false,
                greedy: false,
                autoGroup: true,
                digitsOptional: false,
            });
        }
        function onlyNumber(id){
            $(id).on("keypress keyup blur",function (event) {    
                $(this).val($(this).val().replace(/[^\d].+/, ""));
                 if ((event.which < 48 || event.which > 57)) {
                     event.preventDefault();
                 }
            });
        }
        function isEmail(id_email) {
            email = $(id_email).val();
            var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            if(regex.test(email)) {
                $('#invalidEmail').remove();
                return true;
            }else{
                $('#col-email').append('<div class="invalid-feedback text-danger" id="invalidEmail">Invalid Format Email.</div>');
                return false;
            }
        }
        $('#submitUpdate').click(function(){
            if(isEmail("#input-email")==false){
                return false
            }
        });
        function visible() {
            $("#id_percent").hide(); 
                @if(isset($result['cooperation_scheme'])) 
                    @if($result['cooperation_scheme'] == 'Management Fee') 
                    $("#id_percent").show(); 
                @endif
            @endif
        }
        $(document).ready(function() {
            visible()
            var sharing_value = {{$result["sharing_value"]}}
            $('#sharing_value').val(sharing_value);
            number("#input-phone");
            number("#input-mobile");
            number("#mobile");
            onlyNumber("#input-beneficiary_account");
            onlyNumber("#location_large");
            isEmail("#input-email");
            $('.numberonly').inputmask("remove");
            $('.numberonly').inputmask({
                removeMaskOnSubmit: true, 
				placeholder: "",
				alias: "currency", 
				digits: 0, 
				rightAlign: false,
				max: '999999999999999',
                prefix : "",
            });
            $('[data-switch=true]').bootstrapSwitch();
            $('#btn-submit').on('click', function(event) {
                if(document.getElementById('auto_generate_pin').checked == false){
                    if($('#pin1').val() !== $('#pin2').val()) {
                        Swal.fire(
                            "Woops!",
                            'Password didn\'t match' ,
                            "error"
                        )
                        event.preventDefault();
                        event.stopPropagation();
                    }
                }


                const re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                if(!re.test($('#input-email').val())){
                    Swal.fire(
                        "Woops!",
                        'Format email is not valid' ,
                        "error"
                    )
                    event.preventDefault();
                    event.stopPropagation();
                }
            });
        });

        function changeLevel(value){
            if(value == 'User Franchise'){
                $("#select_outlet").show();
            }else{
                $("#select_outlet").hide();
            }
        }

        $('#input-username').keypress(function (e) {
            var regex = new RegExp("^[a-zA-Z0-9_-]*$");
            var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);

            if (regex.test(str) || e.which == 8) {
                return true;
            }

            e.preventDefault();
            return false;
        });
    </script>
@endsection

@section('content')
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="/">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>{{ $title }}</span>
                @if (!empty($sub_title))
                    <i class="fa fa-circle"></i>
                @endif
            </li>
            @if (!empty($sub_title))
            <li>
                <span>{{ $sub_title }}</span>
            </li>
            @endif
        </ul>
    </div><br>

    @include('layouts.notifications')
    <a href="{{url('businessdev/partners/detail')}}/{{ $id_partner }}#locations" class="btn green" style="margin-bottom: 2%;"><i class="fa fa-arrow-left"></i> Back</a>
    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject sbold uppercase font-blue">Detail Status Location Partner</span>
            </div>
        </div>
        <div class="tabbable-line tabbable-full-width">
            <div style="white-space: nowrap;">
                <div class="portlet-body form">
                    <div class="tab-pane">
                        <div class="row">
                            <div class="col-md-3">
                                <ul class="ver-inline-menu tabbable margin-bottom-10">
                                    <li class="active">
                                        <a data-toggle="tab" href="#locselect"><i class="fa fa-cog"></i> Select Location </a>
                                    </li>
                                    <li @if(!$calcu) style="opacity: 0.4 !important" @endif>
                                        <a @if($calcu) data-toggle="tab" @endif href="#loccalcu"><i class="fa fa-cog"></i> Calculation </a>
                                    </li>
                                    <li @if(!$confir) style="opacity: 0.4 !important" @endif>
                                        <a @if($confir) data-toggle="tab" @endif href="#locsurvey"><i class="fa fa-cog"></i> Confirmation Letter </a>
                                    </li>
                                    <li @if(!$pay) style="opacity: 0.4 !important" @endif>
                                        <a @if($pay) data-toggle="tab" @endif href="#locpayment"><i class="fa fa-cog"></i> Payment </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-9">
                                <div class="tab-content">

                                    <div class="tab-pane active" id="locselect">
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
                                                            <div class="tab-pane active" id="form_calcu">
                                                                <form class="form-horizontal" role="form" action="{{url('businessdev/partners/new-follow-up')}}" method="post" enctype="multipart/form-data">
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
                                                                                <input class="form-control" type="text" name="location_name" value="{{$result['name'] ?? ''}}" readonly required/>
                                                                            </div>
                                                                        </div>    
                                                                        <div class="form-group">
                                                                            <label for="example-search-input" class="control-label col-md-4">Select Outlet Starter <span class="required" aria-required="true">*</span>
                                                                                <i class="fa fa-question-circle tooltips" data-original-title="Pilih paket persiapan yang akan digunakan untuk persiapan outlet" data-container="body"></i></label>
                                                                            <div class="col-md-5">
                                                                                <select class="form-control select2" name="id_outlet_starter_bundling" id="id_outlet_starter_bundling" {{ $select ? 'disabled' : ''}} required>
                                                                                    <option value="" selected disabled>Select Starter</option>
                                                                                    @foreach($list_starters as $list_starter)
                                                                                        <option value="{{$list_starter['id_outlet_starter_bundling']}}" @if(old('id_outlet_starter_bundling')) @if(old('id_outlet_starter_bundling') == $list_starter['id_outlet_starter_bundling']) selected @endif @else @if ($result) @if($result['id_outlet_starter_bundling'] == $list_starter['id_outlet_starter_bundling']) selected @endif @endif @endif>{{$list_starter['name']}}</option>
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
                                                                                        <option value="{{$brand['id_brand']}}" @if(old('id_brand')) @if(old('id_brand') == $brand['id_brand']) selected @endif @else @if ($result) @if($result['id_brand'] == $brand['id_brand']) selected @endif @endif @endif>{{$brand['name_brand']}}</option>
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
                                                                                        <option value="{{$term['id_term_of_payment']}}" @if(old('id_term_of_payment')) @if(old('id_term_of_payment') == $term['id_term_of_payment']) selected @endif @else @if ($result) @if($result['id_term_of_payment'] == $term['id_term_of_payment']) selected @endif @endif @endif>{{$term['name']}}</option>
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
                                                                                    <option value="Central" @if(old('ownership_status')) @if(old('ownership_status')=='Central') selected @endif @else @if(isset($result['ownership_status'])) @if($result['ownership_status'] == 'Central') selected @endif @endif @endif>Central</option>
                                                                                    <option value="Partner" @if(old('ownership_status')) @if(old('ownership_status')=='Partner') selected @endif @else @if(isset($result['ownership_status'])) @if($result['ownership_status'] == 'Partner') selected @endif @endif @endif>Partner</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="example-search-input" class="control-label col-md-4">Coopertaion Scheme<span class="required" aria-required="true">*</span>
                                                                                <i class="fa fa-question-circle tooltips" data-original-title="Skema Pembagian hasil partner dengan IXOBOX" data-container="body"></i></label>
                                                                            <div class="col-md-5">
                                                                                <select name="cooperation_scheme" id="cooperation_scheme" onchange="coopertationNew()" class="form-control input-sm select2" placeholder="Coopertaion Scheme" required {{ $select ? 'disabled' : ''}}>
                                                                                    <option value="" selected disabled>Select Cooperation Scheme</option>
                                                                                    <option value="Revenue Sharing" @if(old('cooperation_scheme')) @if(old('cooperation_scheme')=='Revenue Sharing') selected @endif @else @if(isset($result['cooperation_scheme'])) @if($result['cooperation_scheme'] == 'Revenue Sharing') selected @endif @endif @endif>Revenue Sharing</option>
                                                                                    <option value="Management Fee" @if(old('cooperation_scheme')) @if(old('cooperation_scheme')=='Management Fee') selected @endif @else @if(isset($result['cooperation_scheme'])) @if($result['cooperation_scheme'] == 'Management Fee') selected @endif @endif @endif>Management Fee</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div id="id_percent">
                                                                            <div class="form-group">
                                                                                <label for="example-search-input" class="control-label col-md-4">Percent</label>
                                                                                <div class="col-md-5">
                                                                                    <input type="checkbox" class="make-switch brand_visibility" onchange="cooperationPercentNew()"  data-size="small" data-on-color="info" data-on-text="Percent" data-off-color="default" name='sharing_percent' data-off-text="Nominal" @if (old('sharing_percent')) checked @else @if (isset($result['sharing_percent'])) @if ($result['sharing_percent'] == 1) checked @endif @endif @endif{{ $select ? 'disabled' : ''}}>
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
                                                                                    <option value="PT IMA" @if(old('company_type')) @if(old('company_type')=='PT IMA') selected @endif @else @if(isset($result['company_type'])) @if($result['company_type'] == 'PT IMA') selected @endif @endif @endif>PT IMA</option>
                                                                                    <option value="PT IMS" @if(old('company_type')) @if(old('company_type')=='PT IMS') selected @endif @else @if(isset($result['company_type'])) @if($result['company_type'] == 'PT IMS') selected @endif @endif @endif>PT IMS</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="example-search-input" class="control-label col-md-4">Contractor Price <span class="required" aria-required="true">*</span>
                                                                                <i class="fa fa-question-circle tooltips" data-original-title="Biaya kontraktor untuk membangun lokasi" data-container="body"></i></label>
                                                                            <div class="col-md-5">
                                                                                <div class="input-group">
                                                                                    <span class="input-group-addon">Rp</span>
                                                                                    <input class="form-control numberonly" type="text" data-type="currency" id="renovation_cost" name="renovation_cost" placeholder="Enter renovation cost here" value="@if (old('renovation_cost')) {{ number_format(old('renovation_cost')) }} @else @if (!empty($result['renovation_cost'])) {{ number_format($result['renovation_cost']) }} @endif @endif" {{$select ? 'disabled' : ''}} required/>
                                                                                </div>
                                                                            </div>
                                                                        </div>  
                                                                        <div class="form-group">
                                                                            <label for="example-search-input" class="control-label col-md-4">Partnership Fee <span class="required" aria-required="true">*</span>
                                                                                <i class="fa fa-question-circle tooltips" data-original-title="Biaya kerja sama yang akan dibayarkan partner ke IXOBOX" data-container="body"></i></label>
                                                                            <div class="col-md-5">
                                                                                <div class="input-group">
                                                                                    <span class="input-group-addon">Rp</span>
                                                                                    <input class="form-control numberonly" type="text" data-type="currency" id="partnership_fee" name="partnership_fee" placeholder="Enter partnership fee here" value="@if (old('partnership_fee')) {{ number_format(old('partnership_fee')) }} @else @if (!empty($result['partnership_fee'])) {{ number_format($result['partnership_fee']) }} @endif @endif" {{$select ? 'disabled' : ''}} required/>
                                                                                </div>
                                                                            </div>
                                                                        </div>    
                                                                        <div class="form-group">
                                                                            <label for="example-search-input" class="control-label col-md-4">Income <span class="required" aria-required="true">*</span>
                                                                                <i class="fa fa-question-circle tooltips" data-original-title="Perkiraan permasukan per bulan" data-container="body"></i></label>
                                                                            <div class="col-md-5">
                                                                                <div class="input-group">
                                                                                    <span class="input-group-addon">Rp</span>
                                                                                    <input class="form-control numberonly" type="text" data-type="currency" id="income" name="income" placeholder="Enter income here" value="@if (old('income')) {{ number_format(old('income')) }} @else @if (!empty($result['income'])) {{ number_format($result['income']) }} @endif @endif" {{$select ? 'disabled' : ''}} required/>
                                                                                </div>
                                                                            </div>
                                                                        </div>   
                                                                        <div class="form-group">
                                                                            <label for="example-search-input" class="control-label col-md-4">Total Box <span class="required" aria-required="true">*</span>
                                                                                <i class="fa fa-question-circle tooltips" data-original-title="Jumlah box yang dibutuhkan untuk pembuatan outlet" data-container="body"></i></label>
                                                                            <div class="col-md-5">
                                                                                <div class="input-group">
                                                                                    <input class="form-control numberonly" type="text" data-type="currency" id="total_box" name="total_box" placeholder="Enter total box here" value="@if (old('total_box')) {{ number_format(old('total_box')) }} @else @if (!empty($result['total_box'])) {{ number_format($result['total_box']) }} @endif @endif" {{$select ? 'disabled' : ''}} required/>
                                                                                    <span class="input-group-addon">Box</span>
                                                                                </div>
                                                                            </div>
                                                                        </div>    
                                                                        <div class="form-group">
                                                                            <label for="example-search-input" class="control-label col-md-4">Start Date 
                                                                                <i class="fa fa-question-circle tooltips" data-original-title="Tanggal mulai lokasi mulai dikontrak oleh partner, bisa dikosongkan dan akan diisi tanggal mulai menjadi partner" data-container="body"></i></label>
                                                                            <div class="col-md-5">
                                                                                <div class="input-group">
                                                                                    <input type="text" id="start_date" class="datepicker form-control" name="start_date" value="{{ (!empty($result['start_date']) ? date('d F Y', strtotime($result['start_date'])) : '')}}" {{$select ? 'disabled' : ''}}>
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
                                                                                <i class="fa fa-question-circle tooltips" data-original-title="Tanggal berakhirnya kontrak lokasi dengan partner, bisa dikosongkan dan akan diisi tanggal berakhir partner" data-container="body"></i><br><span class="required" aria-required="true">( must be more than 3 years )</span></label>
                                                                            <div class="col-md-5">
                                                                                <div class="input-group">
                                                                                    <input type="text" id="end_date" class="datepicker form-control" name="end_date" value="{{ (!empty($result['end_date']) ? date('d F Y', strtotime($result['end_date'])) : '')}}" {{$select ? 'disabled' : ''}}>
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
                                                                                    <input type="text" id="handover_date" class="datepicker form-control" name="handover_date" value="{{ (!empty($result['handover_date']) ? date('d F Y', strtotime($result['handover_date'])) : '')}}" {{$select ? 'disabled' : ''}} required>
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
                                                                                <textarea name="note" id="note" class="form-control" placeholder="Enter note here" @if ($select==true) readonly @endif >@if ($select==true) {{ $note_select }} @endif</textarea>
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
                                    </div>

                                    <div class="tab-pane" id="loccalcu">
                                        <div style="white-space: nowrap;">
                                            <div class="tab-pane">
                                                <div class="portlet light bordered">
                                                    <div class="portlet-title">
                                                        <div class="caption">
                                                            <span class="caption-subject font-dark sbold uppercase font-yellow">Calculation</span>
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
                                                                        @if ($calcu==false)
                                                                        <a href="#form_pay" class="btn btn-sm yellow" type="button" style="float:center" data-toggle="tab" id="input-pay">
                                                                            Calculation
                                                                        </a>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="tab-pane active" id="form_pay">
                                                                @php $total_payment = 0 @endphp
                                                                <table class="table">
                                                                    <tbody>
                                                                        <tr>
                                                                            <th colspan="3">Fees</th>
                                                                        </tr>
                                                                        @if (isset($result['renovation_cost']))
                                                                        <tr>
                                                                            <td>Contractor Price</td>
                                                                            <td></td>
                                                                            <td>{{number_format($result['renovation_cost'], 0, ',', '.')}}</td>
                                                                            @php $total_payment += $result['renovation_cost'] @endphp
                                                                        </tr>
                                                                        @endif
                                                                        @if (isset($result['partnership_fee']))
                                                                        <tr>
                                                                            <td>Partnership Fee</td>
                                                                            <td></td>
                                                                            <td>{{number_format($result['partnership_fee'], 0, ',', '.')}}</td>
                                                                            @php $total_payment += $result['partnership_fee'] @endphp
                                                                        </tr>
                                                                        @endif
                                                                        <tr>
                                                                            <th colspan="3">Rent</th>
                                                                        </tr>
                                                                        @if (isset($result['location_large']))
                                                                        <tr>
                                                                            <td>Location Large</td>
                                                                            <td></td>
                                                                            <td>{{number_format($result['location_large'], 0, ',', '.')}}</td>
                                                                        </tr>
                                                                        @endif
                                                                        @if (isset($result['rental_price']))
                                                                        <tr>
                                                                            <td>Rental Price</td>
                                                                            <td></td>
                                                                            <td>{{number_format($result['rental_price'], 0, ',', '.')}}</td>
                                                                            @php $total_payment += $result['rental_price'] @endphp
                                                                        </tr>
                                                                        @endif
                                                                        @if (isset($result['service_charge']))
                                                                        <tr>
                                                                            <td>Service Charge</td>
                                                                            <td></td>
                                                                            <td>{{number_format($result['service_charge'], 0, ',', '.')}}</td>
                                                                        </tr>
                                                                        @endif
                                                                        @if (isset($result['promotion_levy']))
                                                                        <tr>
                                                                            <td>Promotion Levy</td>
                                                                            <td></td>
                                                                            <td>{{number_format($result['promotion_levy'], 0, ',', '.')}}</td>
                                                                        </tr>
                                                                        @endif
                                                                        <tr>
                                                                            <th colspan="3">Sale</th>
                                                                        </tr>
                                                                        @if (isset($result['income']))
                                                                        <tr>
                                                                            <td>Income</td>
                                                                            <td></td>
                                                                            <td>{{number_format($result['income'], 0, ',', '.')}}</td>
                                                                        </tr>
                                                                        @endif
                                                                    </tbody>
                                                                </table>
                                                                <form class="form-horizontal" role="form" action="{{url('businessdev/partners/new-follow-up')}}" method="post" enctype="multipart/form-data">
                                                                    <div class="form-body">
                                                                        <input type="hidden" name="id_partner" value="{{$result['id_partner']}}">
                                                                        <div class="form-group">
                                                                            <label for="example-search-input" class="control-label col-md-4">Step <span class="required" aria-required="true">*</span>
                                                                                <i class="fa fa-question-circle tooltips" data-original-title="Step yang sedang dilakukan" data-container="body"></i></label>
                                                                            <div class="col-md-5">
                                                                                <input class="form-control" type="text" id="follow_up" name="follow_up" value="Calculation" readonly required/>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="example-search-input" class="control-label col-md-4">Total Payment <span class="required" aria-required="true">*</span>
                                                                                <i class="fa fa-question-circle tooltips" data-original-title="Jumlah yang harus dibayarkan partner untuk menenuhi product persiapan outlet" data-container="body"></i></label>
                                                                            <div class="col-md-5">
                                                                                <div class="input-group">
                                                                                    <span class="input-group-addon">Rp</span>
                                                                                    <input class="form-control numberonly" type="text" data-type="currency" id="total_payment" name="total_payment" placeholder="Enter total payment here" value="@if(isset($result['total_payment'])) {{ number_format($result['total_payment']) }} @else {{ number_format($total_payment) }} @endif" required {{$calcu ? 'disabled' : ''}}/>
                                                                                </div>
                                                                            </div>
                                                                        </div>    
                                                                        <div class="form-group">
                                                                            <label for="example-search-input" class="control-label col-md-4">Note <span class="required" aria-required="true">*</span>
                                                                                <i class="fa fa-question-circle tooltips" data-original-title="Catatan untuk step in" data-container="body"></i></label>
                                                                            <div class="col-md-5">
                                                                                <textarea name="note" id="note" class="form-control" placeholder="Enter note here" @if ($calcu==true) readonly @endif >@if ($calcu==true) {{ $note_calcu }} @endif</textarea>
                                                                            </div>
                                                                        </div>
                                                                        <input type="hidden" name="id_location" value="{{$result['id_location']??''}}">
                                                                        <div class="form-group">
                                                                            @if ($calcu==false) 
                                                                            <label for="example-search-input" class="control-label col-md-4">Import Attachment 
                                                                                <i class="fa fa-question-circle tooltips" data-original-title="Unggah file jika ada lampiran yang diperlukan" data-container="body"></i><br>
                                                                                <span class="required" aria-required="true"> (PDF max 2 mb) </span></label>
                                                                                @else
                                                                            <label for="example-search-input" class="control-label col-md-4">Download Attachment 
                                                                                <i class="fa fa-question-circle tooltips" data-original-title="Download file yang dilampirkan pada step ini" data-container="body"></i><br></label>
                                                                                @endif
                                                                            <div class="col-md-5">
                                                                                @if ($calcu==false) 
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
                                                                        @if ($calcu==false) 
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
                                    </div>

                                    <div class="tab-pane" id="locsurvey">
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
                                                                                <input class="form-control" type="text" @if(isset($confirmation['lokasi'])) value="{{ $confirmation['lokasi'] }}" @endif placeholder="- " readonly />
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="example-search-input" class="control-label col-md-4">Outlet Address <span class="required" aria-required="true">*</span>
                                                                                <i class="fa fa-question-circle tooltips" data-original-title="Alamat lengkap dari lokasi outlet yang diajukan" data-container="body"></i></label>
                                                                            <div class="col-md-5">
                                                                                <textarea style="height: 80px" class="form-control" placeholder="- " readonly >@if(isset($confirmation['lokasi'])) {{ $confirmation['address'] }} @endif</textarea>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="example-search-input" class="control-label col-md-4">Outlet Large <span class="required" aria-required="true">*</span>
                                                                                <i class="fa fa-question-circle tooltips" data-original-title="Luas lokasi outlet yang diakukan" data-container="body"></i></label>
                                                                            <div class="col-md-5">
                                                                                <input class="form-control" type="text" @if(isset($confirmation['large'])) value="{{ $confirmation['large'] }}" @endif placeholder="- " readonly />
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
                                                                                <i class="fa fa-question-circle tooltips" data-original-title="Biaya kerja sama yang akan dibayarkan partner ke IXOBOX" data-container="body"></i></label>
                                                                            <div class="col-md-5">
                                                                                <input class="form-control" type="text" @if(isset($confirmation['partnership_fee'])) value="{{ $confirmation['partnership_fee'] }}" @endif placeholder="- " readonly />
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="example-search-input" class="control-label col-md-4">Booking Fee <span class="required" aria-required="true">*</span>
                                                                                <i class="fa fa-question-circle tooltips" data-original-title="Biaya booking fee adalah 20% dari Partnership Fee" data-container="body"></i></label>
                                                                            <div class="col-md-5">
                                                                                <input class="form-control" type="text" @if(isset($confirmation['dp'])) value="{{ $confirmation['dp'] }}" @endif placeholder="- " readonly />
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="example-search-input" class="control-label col-md-4">Down Payment 1 <span class="required" aria-required="true">*</span>
                                                                                <i class="fa fa-question-circle tooltips" data-original-title="Biaya booking fee adalah 30% dari Partnership Fee" data-container="body"></i></label>
                                                                            <div class="col-md-5">
                                                                                <input class="form-control" type="text" @if(isset($confirmation['dp2'])) value="{{ $confirmation['dp2'] }}" @endif placeholder="- " readonly />
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="example-search-input" class="control-label col-md-4">Final Payment <span class="required" aria-required="true">*</span>
                                                                                <i class="fa fa-question-circle tooltips" data-original-title="Pembayaran terakhir oleh partner ke IXOBOX" data-container="body"></i></label>
                                                                            <div class="col-md-5">
                                                                                <input class="form-control" type="text" @if(isset($confirmation['final'])) value="{{ $confirmation['final'] }}" @endif placeholder="- " readonly />
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="example-search-input" class="control-label col-md-4">Reference Number <span class="required" aria-required="true">*</span>
                                                                                <i class="fa fa-question-circle tooltips" data-original-title="Nomor surat yang akan dicantumkan di confirmation letter" data-container="body"></i></label>
                                                                            <div class="col-md-5">
                                                                                <input class="form-control" type="text" id="no_letter" name="no_letter" placeholder="Enter reference number here" required @if ($confir==true) readonly value="{{$location_confirmation['no_letter']??''}}" @endif/>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="example-search-input" class="control-label col-md-4">Location Letter <span class="required" aria-required="true">*</span>
                                                                                <i class="fa fa-question-circle tooltips" data-original-title="Lokasi confirmation letter dibuat" data-container="body"></i></label>
                                                                            <div class="col-md-5">
                                                                                <input class="form-control" type="text" id="location_letter" name="location_letter" placeholder="Enter location letter here" required @if ($confir==true) readonly value="{{$location_confirmation['location']??''}}" @endif/>
                                                                            </div>
                                                                        </div>
                                                                        <input type="hidden" name="id_location" value="{{$result['id_location']??''}}">
                                                                        <div class="form-group">
                                                                            <label for="example-search-input" class="control-label col-md-4">Payment Note 
                                                                                <i class="fa fa-question-circle tooltips" data-original-title="Catatan pembayaran berisikan pilihan untuk pengansuran final payment, jika tidak diisi berarti final payment tanpa angsuran" data-container="body"></i></label>
                                                                            <div class="col-md-5">
                                                                                <textarea style="height: 200px" name="payment_note" id="payment_note" class="form-control" placeholder="Final Payment akan diangsur ..." @if ($confir==true) readonly @endif>{{ $result['notes']??'' }}</textarea>
                                                                            </div>
                                                                        </div> 
                                                                        <div class="form-group">
                                                                            <label for="example-search-input" class="control-label col-md-4">Note <span class="required" aria-required="true">*</span>
                                                                                <i class="fa fa-question-circle tooltips" data-original-title="Catatan untuk step in" data-container="body"></i></label>
                                                                            <div class="col-md-5">
                                                                                <textarea name="note" id="note" class="form-control" placeholder="Enter note here" @if ($confir==true) readonly @endif >@if ($confir==true) {{ $note_confir }} @endif</textarea>
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
                                                                                    <a href="{{ $location_confirmation['attachment']??'' }}">Download Confirmation Letter</a>
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
                                    </div>

                                    <div class="tab-pane" id="locpayment">
                                        <div style="white-space: nowrap;">
                                            <div class="tab-pane" id="step-follow-up">
                                                <div class="portlet light bordered">
                                                    <div class="portlet-title">
                                                        <div class="caption">
                                                            <span class="caption-subject font-dark sbold uppercase font-yellow">Payment</span>
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
                                                                        @if ($pay==false)
                                                                        <a href="#form_pay" class="btn btn-sm yellow" type="button" style="float:center" data-toggle="tab" id="input-pay">
                                                                            Payment
                                                                        </a>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="tab-pane active" id="form_pay">
                                                                <form class="form-horizontal" role="form" action="{{url('businessdev/partners/new-follow-up')}}" method="post" enctype="multipart/form-data">
                                                                    <div class="form-body">
                                                                        <input type="hidden" name="id_partner" value="{{$result['id_partner']}}">
                                                                        <div class="form-group">
                                                                            <label for="example-search-input" class="control-label col-md-4">Step <span class="required" aria-required="true">*</span>
                                                                                <i class="fa fa-question-circle tooltips" data-original-title="Step yang sedang dilakukan" data-container="body"></i></label>
                                                                            <div class="col-md-5">
                                                                                <input class="form-control" type="text" id="follow_up" name="follow_up" value="Payment" readonly required/>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="example-search-input" class="control-label col-md-4">No SPK <span class="required" aria-required="true">*</span>
                                                                                <i class="fa fa-question-circle tooltips" data-original-title="Nomor Surat Perintah Kerja calon lokasi" data-container="body"></i></label>
                                                                            <div class="col-md-5">
                                                                                <input class="form-control" type="text" id="no_spk" name="no_spk" placeholder="Enter total box here" value="@if (old('no_spk')) {{ old('no_spk') }} @else @if (!empty($result['no_spk'])) {{ $result['no_spk'] }} @endif @endif" required {{$pay ? 'disabled' : ''}}/>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="example-search-input" class="control-label col-md-4">SPK Date <span class="required" aria-required="true">*</span>
                                                                                <i class="fa fa-question-circle tooltips" data-original-title="Tanggal Surat Perintah Kerja  disetujui oleh kedua pihak" data-container="body"></i></label>
                                                                            <div class="col-md-5">
                                                                                <div class="input-group">
                                                                                    <input type="text" id="date_spk" class="datepicker form-control" name="date_spk" value="{{ (!empty($result['date_spk']) ? date('d F Y', strtotime($result['date_spk'])) : '')}}" required {{$pay ? 'disabled' : ''}}>
                                                                                    <span class="input-group-btn">
                                                                                        <button class="btn default" type="button">
                                                                                            <i class="fa fa-calendar"></i>
                                                                                        </button>
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="example-search-input" class="control-label col-md-4">Due Date <span class="required" aria-required="true">*</span>
                                                                                <i class="fa fa-question-circle tooltips" data-original-title="Tanggal jatuh tempo atau tanggal terakhir pembayaran partnershi fee" data-container="body"></i></label>
                                                                            <div class="col-md-5">
                                                                                <div class="input-group">
                                                                                    <input type="text" id="due_date" class="datepicker form-control" name="due_date" value="{{ (!empty($result['due_date']) ? date('d F Y', strtotime($result['due_date'])) : '')}}" required {{$pay ? 'disabled' : ''}}>
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
                                                                                <textarea name="note" id="note" class="form-control" placeholder="Enter note here" @if ($pay==true) readonly @endif >@if ($pay==true) {{ $note_pay
                                                                                 }} @endif</textarea>
                                                                            </div>
                                                                        </div>
                                                                        <input type="hidden" name="id_location" value="{{$result['id_location']??''}}">
                                                                        <div class="form-group">
                                                                            @if ($pay==false) 
                                                                            <label for="example-search-input" class="control-label col-md-4">Import Attachment 
                                                                                <i class="fa fa-question-circle tooltips" data-original-title="Unggah file jika ada lampiran yang diperlukan" data-container="body"></i><br>
                                                                                <span class="required" aria-required="true"> (PDF max 2 mb) </span></label>
                                                                                @else
                                                                            <label for="example-search-input" class="control-label col-md-4">Download Attachment 
                                                                                <i class="fa fa-question-circle tooltips" data-original-title="Download file yang dilampirkan pada step ini" data-container="body"></i><br></label>
                                                                                @endif
                                                                            <div class="col-md-5">
                                                                                @if ($pay==false) 
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
                                                                        @if ($pay==false) 
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
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection