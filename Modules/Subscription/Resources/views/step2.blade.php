<?php
use App\Lib\MyHelper;
$configs = session('configs');
?>
@extends('layouts.main')

@section('page-style')

    <link href="{{ env('S3_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet" type="text/css" />

    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />

    <style type="text/css">
        .content-title {
            padding-bottom: 15px;
        }
        .content-detail {
            padding-bottom: 10px;
            padding-left: 40px;
        }
        .p-l-40px {
            padding-left: 40px;
        }
        .p-l-30px {
            padding-left: 30px;
        }
        a[aria-expanded=false] .fa-chevron-down {
            display: none;
        }
        a[aria-expanded=true] .fa-chevron-right {
            display: none;
        }
        .bottom-border {
            border-bottom: 1px solid #c2cad8;
        }
        .btn-grey {
            color: #337ab7;
            background-color: #eee;
            border-color: #ccc;
        }
        .text-decoration-none {
            text-decoration: none!important;
        }
    </style>
@endsection

@section('page-script')

    <!-- <script src="{{ env('S3_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.min.js') }}" type="text/javascript"></script> -->
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js')}}"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{ ('assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{ ('assets/pages/scripts/form-repeater.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('js/prices.js')}}"></script>
    <script src="{{ env('S3_URL_VIEW') }}{{('js/subscription.js') }}" type="text/javascript"></script>

    <script>
    $('.datepicker').datepicker({
        'format' : 'd-M-yyyy',
        'todayHighlight' : true,
        'autoclose' : true
    });
    $('.timepicker').timepicker();

    $(".form_datetime").datetimepicker({
        format: "d-M-yyyy hh:ii",
        autoclose: true,
        todayBtn: true,
        minuteStep:1
    });

    </script>

    <script type="text/javascript">        
        var oldOutlet=[];
        function redrawOutlets(list,selected,convertAll){
            var html="";
            if(list.length){
                html+="<option value=\"all\">All Outlets</option>";
            }
            list.forEach(function(outlet){
                html+="<option value=\""+outlet.id_outlet+"\">"+outlet.outlet_code+" - "+outlet.outlet_name+"</option>";
            });
            $('select[name="id_outlet[]"]').html(html);
            $('select[name="id_outlet[]"]').val(selected);
            if(convertAll&&$('select[name="id_outlet[]"]').val().length==list.length){
                $('select[name="id_outlet[]"]').val(['all']);
            }
            oldOutlet=list;
        }
        $(document).ready(function() {

            var _URL = window.URL || window.webkitURL;

            $('.price').each(function() {
                var input = $(this).val();
                var input = input.replace(/[\D\s\._\-]+/g, "");
                input = input ? parseInt( input, 10 ) : 0;

                $(this).val( function() {
                    return ( input === 0 ) ? "" : input.toLocaleString( "id" );
                });
            });
            token = '<?php echo csrf_token();?>';

            /* PRICES */
            $('.prices').click(function() {
                var nilai = $(this).val();

                if (nilai != "free") {
                    $('#prices').show();

                    $('.payment').hide();

                    $('#'+nilai).show();
                    $('.'+nilai).prop('required', true);
                    $('.'+nilai+'Opp').removeAttr('required');
                    $('.'+nilai+'Opp').val('');
                }
                else {
                    $('#prices').hide();
                    $('.freeOpp').removeAttr('required');
                    $('.freeOpp').val('');
                }
            });

            /* VOUCHER TYPE */
            $("input[name='voucher_type']").click(function() {
                var nilai = $(this).val();

                $('#voucher-value').show();
                $('#discount-max-form, #discount-max-value').hide();
                $("input[name='percent_max']").prop('checked', false);
                $("input[name='subscription_voucher_percent_max']").prop('required', false);

                if (nilai == "percent") {

                    $('#voucher-percent, #discount-max').show();
                    $('#voucher-cash').hide();
                    $("input[name='subscription_voucher_percent'], input[name='percent_max']").prop('required', true);
                    $("input[name='subscription_voucher_nominal']").prop('required', false);
                }
                else {
                    $('#voucher-percent, #discount-max').hide();
                    $('#voucher-cash').show();
                    $("input[name='subscription_voucher_percent'], input[name='percent_max']").prop('required', false);
                    $("input[name='subscription_voucher_nominal']").prop('required', true);

                }
            });

            /* PURCHASE LIMIT */
            $("input[name='purchase_limit']").click(function() {
                var nilai = $(this).val();

                $('#discount-max-form, #discount-max-value').hide();
                $("input[name='new_purchase_after']").prop('checked', false);
                $("input[name='subscription_voucher_percent_max']").prop('required', false);

                if (nilai == "limit") {

                    $('#new-purchase-after').show();
                    $("input[name='new_purchase_after']").prop('required', true);
                }
                else {
                    $('#new-purchase-after').hide();
                    $("input[name='new_purchase_after']").prop('required', false);

                }
            });

            /* DISCOUNT MAX */
            $("input[name='percent_max']").click(function() {
                var nilai = $(this).val();

                $('#voucher-percent').show();

                if (nilai == "true") {

                    $('#discount-max-form, #discount-max-value').show();
                    $("input[name='subscription_voucher_percent_max']").prop('required', true);
                }
                else {

                    $('#discount-max-form, #discount-max-value').hide();
                    $("input[name='subscription_voucher_percent_max']").prop('required', false);
                }
            });

            /* SUBSCRIPTION TOTAL */
            $("input[name='subscription_total_type']").click(function() {
                var nilai = $(this).val();

                if (nilai == "limited") {

                    $('#subscription-total-form, #subscription-total-value').show();
                    $("input[name='subscription_total']").prop('required', true);
                }
                else {
                    $('#subscription-total-form, #subscription-total-value').hide();
                    $("input[name='subscription_total']").prop('required', false);
                }
            });

            /* EXPIRY */
            $('.expiry').click(function() {
                var nilai = $(this).val();

                $('#times').show();

                $('.voucherTime').hide();

                $('#'+nilai).show();
                $('.'+nilai).prop('required', true);
                $('.'+nilai+'Opp').removeAttr('required');
                $('.'+nilai+'Opp').val('');
            });

            $('.subscriptionPromoType').click(function() {
                $('.subscriptionPromoTypeShow').show();
                var nilai = $(this).val();

                if (nilai == "promoid") {
                    $('.subscriptionPromoTypeValuePromo').show();
                    $('.subscriptionPromoTypeValuePromo').prop('required', true);

                    $('.subscriptionPromoTypeValuePrice').val('');
                    $('.subscriptionPromoTypeValuePrice').hide();
                    $('.subscriptionPromoTypeValuePrice').removeAttr('required', true);
                }
                else {
                    $('.subscriptionPromoTypeValuePrice').show();
                    $('.subscriptionPromoTypeValuePrice').prop('required', true);

                    $('.subscriptionPromoTypeValuePromo').val('');
                    $('.subscriptionPromoTypeValuePromo').hide();
                    $('.subscriptionPromoTypeValuePromo').removeAttr('required', true);
                }
            });

            // upload & delete image on summernote
            $('.summernote').summernote({
                placeholder: true,
                tabsize: 2,
                height: 120,
                toolbar: [
                  ['style', ['style']],
                  ['style', ['bold', 'underline', 'clear']],
                  ['color', ['color']],
                  ['para', ['ul', 'ol', 'paragraph']],
                  ['insert', ['table']],
                  ['insert', ['link', 'picture', 'video']],
                  ['misc', ['fullscreen', 'codeview', 'help']]
                ],
                callbacks: {
                    onInit: function(e) {
                      this.placeholder
                        ? e.editingArea.find(".note-placeholder").html(this.placeholder)
                        : e.editingArea.remove(".note-placeholder");
                    },
                    onImageUpload: function(files){
                        sendFile(files[0]);
                    },
                    onMediaDelete: function(target){
                        var name = target[0].src;
                        token = "{{ csrf_token() }}";
                        $.ajax({
                            type: 'post',
                            data: 'filename='+name+'&_token='+token,
                            url: "{{url('summernote/picture/delete/subscription')}}",
                            success: function(data){
                                // console.log(data);
                            }
                        });
                    }
                }
            });

            function sendFile(file){
                token = "{{ csrf_token() }}";
                var data = new FormData();
                data.append('image', file);
                data.append('_token', token);
                // document.getElementById('loadingDiv').style.display = "inline";
                $.ajax({
                    url : "{{url('summernote/picture/upload/subscription')}}",
                    data: data,
                    type: "POST",
                    processData: false,
                    contentType: false,
                    success: function(url) {
                        if (url['status'] == "success") {
                            $('#field_content_long').summernote('insertImage', url['result']['pathinfo'], url['result']['filename']);
                        }
                        // document.getElementById('loadingDiv').style.display = "none";
                    },
                    error: function(data){
                        // document.getElementById('loadingDiv').style.display = "none";
                    }
                })
            }

            $('.fileinput-preview').bind('DOMSubtreeModified', function() {
                var mentah    = $(this).find('img')
                // set image
                var cariImage = mentah.attr('src')
                var ko        = new Image()
                ko.src        = cariImage
                // load image
                ko.onload     = function(){
                    if (this.naturalHeight === 250 && this.naturalWidth === 600) {
                    } else {
                        mentah.attr('src', "https://www.placehold.it/600x250/EFEFEF/AAAAAA&text=no+image")
                        $('#file').val("");
                        toastr.warning("Please check dimension of your photo.");
                    }
                };
            });
            window.onload = function() {
                $("body").on('click', ".removeRepeater", function() {
                    var mbok = $(this).parent().parent().parent();
                    mbok.remove();
                });
            }
            $('.collapse').collapse({
              toggle: true
            })
            $('.sortable').sortable({
                handle: ".sortable-handle",
                connectWith: ".sortable",
                axis: 'y',
            });
            $('.sortable-detail-0').sortable({
                handle: '.sortable-detail-handle-0',
                connectWith: '.sortable-detail-0',
                axis: 'y'
            });
            $('.sortable-detail-1').sortable({
                handle: '.sortable-detail-handle-1',
                connectWith: '.sortable-detail-1',
                axis: 'y'
            });
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

    <div class="portlet light bordered">
        <div class="col-md-12">
            <div class="mt-element-step">
                <div class="row step-line">
                    <div class="col-md-4 mt-step-col first">
                        <a href="{{ ($subscription['id_subscription']??0) ? url('subscription/step1/'.$subscription['id_subscription']) : '' }}" class="text-decoration-none">
                            <div class="mt-step-number bg-white">1</div>
                            <div class="mt-step-title uppercase font-grey-cascade">Info</div>
                            <div class="mt-step-content font-grey-cascade">Title, Image, & Periode</div>
                        </a>
                    </div>
                    <div class="col-md-4 mt-step-col active">
                        <a href="{{ ($subscription['id_subscription']??0) ? url('subscription/step2/'.$subscription['id_subscription']) : '' }}" class="text-decoration-none">
                            <div class="mt-step-number bg-white">2</div>
                            <div class="mt-step-title uppercase font-grey-cascade">Rule</div>
                            <div class="mt-step-content font-grey-cascade">Discount, Limit, & Expired</div>
                        </a>
                    </div>
                    <div class="col-md-4 mt-step-col last">
                        <a href="{{ ($subscription['id_subscription']??0) ? url('subscription/step3/'.$subscription['id_subscription']) : '' }}" class="text-decoration-none">
                            <div class="mt-step-number bg-white">3</div>
                            <div class="mt-step-title uppercase font-grey-cascade">Content</div>
                            <div class="mt-step-content font-grey-cascade">Detail Content Subscription</div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-blue sbold uppercase ">New {{ $title }}</span>
            </div>
        </div>
        <div class="portlet-body form">

            <form class="form-horizontal" role="form" action="{{ url()->current() }}" method="post" enctype="multipart/form-data" id="form">
                <div class="form-body">
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            Subscription Price
                            <span class="required" aria-required="true"> * </span>  
                            <i class="fa fa-question-circle tooltips" data-original-title="Tipe pembayaran subscription (gratis, menggunakan point, atau menggunakan uang)" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-9">
                            <div class="input-icon right">
                                <div class="col-md-3">
                                    <div class="md-radio-inline">
                                        <div class="md-radio">
                                            <input type="radio" name="prices_by" id="radio6" value="free" class="prices md-radiobtn" required @if (old('prices_by') == "free" || (empty($subscription['subscription_price_cash']) || empty($subscription['subscription_price_point'])) ) checked @endif>
                                            <label for="radio6">
                                                <span></span>
                                                <span class="check"></span>
                                                <span class="box"></span> Free </label>
                                        </div>
                                    </div>
                                </div>
                                @if(MyHelper::hasAccess([19], $configs))
                                <div class="col-md-3">
                                        <div class="md-radio-inline">
                                            <div class="md-radio">
                                                <input type="radio" name="prices_by" id="radio7" value="point" class="prices md-radiobtn" required @if (old('prices_by') == "point" || !empty($subscription['subscription_price_point']) ) checked @endif>
                                                <label for="radio7">
                                                    <span></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span> Point </label>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="col-md-3">
                                    <div class="md-radio-inline">
                                        <div class="md-radio">
                                            <input type="radio" name="prices_by" id="radio8" value="money" class="prices md-radiobtn" required @if (old('prices_by') == "money" || !empty($subscription['subscription_price_cash']) ) checked @endif>
                                            <label for="radio8">
                                                <span></span>
                                                <span class="check"></span>
                                                <span class="box"></span> Money </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group" id="prices" @if ((empty($subscription['subscription_price_cash']) && empty($subscription['subscription_price_point'])) ) style="display: none;" @elseif (old('prices_by')!='free' || !empty($subscription['subscription_price_cash']) || !empty($subscription['subscription_price_point']) ) style="display: block;" @else style="display: none;" @endif>
                        <label class="col-md-3 control-label"></label>
                        <div class="col-md-9">
                            <div class="col-md-3">
                                <label class="control-label">Nominal <span class="required" aria-required="true"> * </span> </label>
                            </div>
                            <div class="col-md-9 payment" id="point"  @if (old('prices_by') == "point" || !empty($subscription['subscription_price_point'])) style="display: block;" @else style="display: none;" @endif>
                                <input type="text" class="form-control point moneyOpp freeOpp" name="subscription_price_point" value="{{ $subscription['subscription_price_point']??old('subscription_price_point') }}" placeholder="Input point nominal">
                            </div>
                            <div class="col-md-9 payment" id="money" @if (old('prices_by') == "money" || !empty($subscription['subscription_price_cash'])) style="display: block;" @else style="display: none;" @endif>
                                <input type="text" class="form-control money pointOpp freeOpp price" name="subscription_price_cash" value="{{ $subscription['subscription_price_cash']??old('subscription_price_cash') }}" placeholder="Input money nominal">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            Outlet Available
                            <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Pilih outlet yang memberlakukan subscription tersebut" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-9" style="padding-right: 30px">
                            <select class="form-control select2-multiple" data-placeholder="Select Outlet" name="id_outlet[]" multiple data-value="{{json_encode(old('id_outlet',[]))}}">
                                <optgroup label="Available Outlet">
                                    @if (!empty($outlets))
                                        <option></option>
                                        @if ( isset($subscription['is_all_outlet']) )
                                            <option value="all" selected>All</option>
                                            @php
                                                $gabungan = "";
                                            @endphp
                                            @foreach($outlets as $row)
                                                @php
                                                    $gabungan = $gabungan."|".$row['id_outlet'];
                                                @endphp
                                                <option value="{{ $row['id_outlet'] }}">{{ $row['outlet_code'] }} - {{ $row['outlet_name'] }}</option>
                                            @endforeach
                                            <input type="hidden" name="outlet" value="{{ $gabungan }}">
                                        @else
                                            <option value="all">All</option>
                                            @php
                                                $outletPilihan = array_pluck($subscription['outlets'], 'id_outlet');
                                                $gabungan = "";
                                            @endphp
                                            @foreach($outlets as $row)
                                                @php
                                                    $gabungan = $gabungan."|".$row['id_outlet'];
                                                @endphp
                                                <option value="{{ $row['id_outlet'] }}" @if (in_array($row['id_outlet'], $outletPilihan)) selected  @endif>{{ $row['outlet_code'] }} - {{ $row['outlet_name'] }}</option>
                                            @endforeach
                                            <input type="hidden" name="outlet" value="{{ $gabungan }}">
                                        @endif
                                    @endif
                                </optgroup>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            Subscription Total
                            <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Jumlah maksimal pengguna yang dapat membeli subscription" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-9">
                            <div class="input-icon right">
                                <div class="col-md-3">
                                    <div class="md-radio-inline">
                                        <div class="md-radio">
                                            <input type="radio" name="subscription_total_type" id="radio13" value="limited" class="md-radiobtn" required @if (old('subscription_total_type') == "limited" || !empty($subscription['subscription_total']) ) checked @endif>
                                            <label for="radio13">
                                                <span></span>
                                                <span class="check"></span>
                                                <span class="box"></span> Limited </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="md-radio-inline">
                                        <div class="md-radio">
                                            <input type="radio" name="subscription_total_type" id="radio14" value="unlimited" class="md-radiobtn" required @if (old('subscription_total_type') == "unlimited" || empty($subscription['subscription_total'])) checked @endif>
                                            <label for="radio14">
                                                <span></span>
                                                <span class="check"></span>
                                                <span class="box"></span> Unlimited </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group" id="subscription-total-form" @if( empty($subscription['subscription_total']) ) style="display: none;" @endif>
                        <label class="col-md-3 control-label"></label>
                        <div class="col-md-9">
                            <div class="col-md-3">
                                <label class="control-label">Value <span class="required" aria-required="true"> * </span> </label>
                            </div>
                            <div class="col-md-9" id="subscription-total-value">
                                <input type="text" class="form-control" name="subscription_total" value="{{ $subscription['subscription_total']??old('subscription_total') }}" placeholder="Input subscription total">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            User Limit
                            <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Batasan berapa kali pengguna dapat membeli lagi subscription yang sama, input 0 untuk unlimited" data-container="body"></i>
                            </label>
                        </div>

                        <div class="col-md-4">
                            <div class="input-icon right">
                                <input type="number" class="form-control" name="user_limit" value="{{ $subscription['user_limit']??old('user_limit') }}" placeholder="User limit" min="0">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            Voucher Start Date
                            <i class="fa fa-question-circle tooltips" data-original-title="Tanggal voucher mulai dapat digunakan, kosongkan bila voucher tidak memiliki minimal tanggal penggunaan" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <div class="input-group">
                                    <input type="text" class="form_datetime form-control" name="subscription_voucher_start" value="{{ ($start_date=old('subscription_voucher_start',$subscription['subscription_voucher_start']??0))?date('d-M-Y H:i',strtotime($start_date)):'' }}" >
                                    <span class="input-group-btn">
                                        <button class="btn default" type="button">
                                            <i class="fa fa-calendar"></i>
                                        </button>
                                        <button class="btn default" type="button">
                                            <i class="fa fa-question-circle tooltips" data-original-title="Tanggal voucher mulai dapat digunakan" data-container="body"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            Voucher Expiry
                            <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Masa berlaku voucher, bisa diatur berdasarkan durasi subscription atau tanggal expirednya" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-9">
                            <div class="input-icon right">
                                <div class="col-md-3">
                                    <div class="md-radio-inline">
                                        <div class="md-radio">
                                            <input type="radio" name="duration" id="radio17" value="dates" class="expiry md-radiobtn" required @if (!empty($subscription['subscription_voucher_expired'])) checked @endif>
                                            <label for="radio17">
                                                <span></span>
                                                <span class="check"></span>
                                                <span class="box"></span> By Date </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="md-radio-inline">
                                        <div class="md-radio">
                                            <input type="radio" name="duration" id="radio18" value="duration" class="expiry md-radiobtn" required @if (!empty($subscription['subscription_voucher_duration'])) checked @endif>
                                            <label for="radio18">
                                                <span></span>
                                                <span class="check"></span>
                                                <span class="box"></span> Duration </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group" id="times" @if (empty($subscription['subscription_voucher_expired']) && empty($subscription['subscription_voucher_duration'])) style="display: none;" @endif>
                        <label class="col-md-3 control-label"></label>
                        <div class="col-md-9">
                            <div class="col-md-3">
                                <label class="control-label">Expiry <span class="required" aria-required="true"> * </span> </label>
                            </div>
                            <div class="col-md-9 voucherTime" id="dates"  @if (empty($subscription['subscription_voucher_expired'])) style="display: none;" @endif>
                                <div class="input-group">
                                    <input type="text" class="form_datetime form-control dates durationOpp" name="subscription_voucher_expired" value="{{ !empty($subscription['subscription_voucher_expired'])??0 ? date('d-M-Y H:i', strtotime($subscription['subscription_voucher_expired'])) : old('subscription_voucher_expired') }}" >
                                    <span class="input-group-btn">
                                        <button class="btn default" type="button">
                                            <i class="fa fa-calendar"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-9 voucherTime" id="duration" @if (empty($subscription['subscription_voucher_duration'])) style="display: none;" @endif>
                                <div class="input-group">
                                    <input type="number" min="1" class="form-control duration datesOpp" name="subscription_voucher_duration" value="{{ $subscription['subscription_voucher_duration']??'' }}">
                                    <span class="input-group-addon">
                                        day after claimed
                                    </span>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            Voucher Total
                            <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Jumlah maksimal voucher yang dapat digunakan setelah membeli subscription. Minimal 1 voucher" data-container="body"></i>
                            </label>
                        </div>

                        <div class="col-md-4">
                            <div class="input-icon right">
                                <input type="number" class="form-control" name="subscription_voucher_total" value="{{ $subscription['subscription_voucher_total']??old('subscription_voucher_total') }}" placeholder="Subscription Voucher Total" min="1">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            Voucher Discount Type
                            <span class="required" aria-required="true"> * </span>  
                            <i class="fa fa-question-circle tooltips" data-original-title="Tipe potongan harga dari voucher subscription (persen atau nominal)" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-9">
                            <div class="input-icon right">
                                <div class="col-md-3">
                                    <div class="md-radio-inline">
                                        <div class="md-radio">
                                            <input type="radio" name="voucher_type" id="radio9" value="percent" class="md-radiobtn" required @if (old('voucher_type') == "percent" || !empty($subscription['subscription_voucher_percent'])) checked @endif>
                                            <label for="radio9">
                                                <span></span>
                                                <span class="check"></span>
                                                <span class="box"></span> Percent </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="md-radio-inline">
                                        <div class="md-radio">
                                            <input type="radio" name="voucher_type" id="radio10" value="cash" class="md-radiobtn" required @if (old('voucher_type') == "cash" || !empty($subscription['subscription_voucher_nominal'])) checked @endif>
                                            <label for="radio10">
                                                <span></span>
                                                <span class="check"></span>
                                                <span class="box"></span> Cash </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group" id="voucher-value" @if( empty($subscription['subscription_voucher_percent']) && empty($subscription['subscription_voucher_nominal']) ) style="display: none;" @endif>
                        <label class="col-md-3 control-label"></label>
                        <div class="col-md-9">
                            <div class="col-md-3">
                                <label class="control-label">Value <span class="required" aria-required="true"> * </span> </label>
                            </div>
                            <div class="col-md-9" id="voucher-percent" @if( empty($subscription['subscription_voucher_percent']) ) style="display: none;" @endif>
                                <input type="text" class="form-control " name="subscription_voucher_percent" value="{{ $subscription['subscription_voucher_percent']??old('subscription_voucher_percent') }}" placeholder="Input Percent value">
                            </div>
                            <div class="col-md-9" id="voucher-cash" @if( empty($subscription['subscription_voucher_nominal']) ) style="display: none;" @endif>
                                <input type="text" class="form-control " name="subscription_voucher_nominal" value="{{ $subscription['subscription_voucher_nominal']??old('subscription_voucher_nominal') }}" placeholder="Input Cash nominal">
                            </div>
                        </div>
                    </div>

                    <div class="form-group" id="discount-max" @if( empty($subscription['subscription_voucher_percent']) ) style="display: none;" @endif>
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            Discount Max
                            <span class="required" aria-required="true"> * </span>  
                            <i class="fa fa-question-circle tooltips" data-original-title="Jumlah potongan maksimal yang bisa didapatkan. Jika jumlah potongan melebihi jumlah potongan maksimal, maka jumlah potongan yang didapatkan akan mengacu pada jumlah potongan maksimal." data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-9">
                            <div class="input-icon right">
                                <div class="col-md-3">
                                    <div class="md-radio-inline">
                                        <div class="md-radio">
                                            <input type="radio" name="percent_max" id="radio11" value="true" class="md-radiobtn" required @if (old('percent_max') == "true" || !empty($subscription['subscription_voucher_percent_max']) ) checked @endif>
                                            <label for="radio11">
                                                <span></span>
                                                <span class="check"></span>
                                                <span class="box"></span> Yes </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="md-radio-inline">
                                        <div class="md-radio">
                                            <input type="radio" name="percent_max" id="radio12" value="false" class="md-radiobtn" required @if (old('percent_max') == "false" || empty($subscription['subscription_voucher_percent_max']) ) checked @endif>
                                            <label for="radio12">
                                                <span></span>
                                                <span class="check"></span>
                                                <span class="box"></span> No </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group" id="discount-max-form" @if( empty($subscription['subscription_voucher_percent_max']) ) style="display: none;" @endif>
                        <label class="col-md-3 control-label"></label>
                        <div class="col-md-9">
                            <div class="col-md-3">
                                <label class="control-label">Nominal <span class="required" aria-required="true"> * </span> </label>
                            </div>
                            <div class="col-md-9" id="discount-max-value">
                                <input type="text" class="form-control" name="subscription_voucher_percent_max" value="{{ $subscription['subscription_voucher_percent_max']??old('subscription_voucher_percent_max') }}" placeholder="Input discount max nominal">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            Minimal Transaction
                            <i class="fa fa-question-circle tooltips" data-original-title="Jumlah transaksi paling sedikit untuk bisa mendapatkan potongan dari subscription" data-container="body"></i>
                            </label>
                        </div>

                        <div class="col-md-4">
                            <div class="input-icon right">
                                <input type="number" class="form-control" name="subscription_minimal_transaction" value="{{ $subscription['subscription_minimal_transaction']??old('subscription_minimal_transaction') }}" placeholder="minimal transaction" min="0">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            Daily Usage Limit
                            <i class="fa fa-question-circle tooltips" data-original-title="Jumlah penggunaan voucher maksimal dalam satu hari" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <input type="number" class="form-control" name="daily_usage_limit" value="{{ $subscription['daily_usage_limit']??old('daily_usage_limit') }}" placeholder="Daily Usage Limit" min="0">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            New Purchase Limit
                            <span class="required" aria-required="true"> * </span>  
                            <i class="fa fa-question-circle tooltips" data-original-title="Batas kapan pengguna dapat membeli lagi subscription yang sama" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-9">
                            <div class="input-icon right">
                                <div class="col-md-3">
                                    <div class="md-radio-inline">
                                        <div class="md-radio">
                                            <input type="radio" name="purchase_limit" id="radio15" value="limit" class="md-radiobtn" required @if (old('purchase_limit') == "limit" || !empty($subscription['new_purchase_after']) ) checked @endif>
                                            <label for="radio15">
                                                <span></span>
                                                <span class="check"></span>
                                                <span class="box"></span> Limit </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="md-radio-inline">
                                        <div class="md-radio">
                                            <input type="radio" name="purchase_limit" id="radio16" value="no_limit" class="md-radiobtn" required @if (old('purchase_limit') == "no_limit" || empty($subscription['new_purchase_after'])) checked @endif>
                                            <label for="radio16">
                                                <span></span>
                                                <span class="check"></span>
                                                <span class="box"></span> No Limit </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group" id="new-purchase-after" @if( empty($subscription['new_purchase_after']) ) style="display: none;" @endif>
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            New Purchase After
                            <span class="required" aria-required="true"> * </span>  
                            <i class="fa fa-question-circle tooltips" data-original-title="Pembelian baru dapat dilakukan lagi setelah subscription yang dibeli expired atau subscription voucher yang dibeli sudah habis" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-9">
                            <div class="input-icon right">
                                <div class="col-md-3">
                                    <div class="md-radio-inline">
                                        <div class="md-radio">
                                            <input type="radio" name="new_purchase_after" id="radio19" value="empty" class="md-radiobtn" @if (old('new_purchase_after') == "Empty" || (($subscription['new_purchase_after']??'') == 'Empty') ) checked @endif>
                                            <label for="radio19">
                                                <span></span>
                                                <span class="check"></span>
                                                <span class="box"></span> Voucher Run Out </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="md-radio-inline">
                                        <div class="md-radio">
                                            <input type="radio" name="new_purchase_after" id="radio20" value="expired" class="md-radiobtn" @if (old('new_purchase_after') == "expired" || (($subscription['new_purchase_after']??'') == 'Expired')) checked @endif>
                                            <label for="radio20">
                                                <span></span>
                                                <span class="check"></span>
                                                <span class="box"></span> Voucher Expired </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="form-actions">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-offset-5 col-md-7">
                            <input type="hidden" name="id_subscription" value="{{ $subscription['id_subscription']??'' }}">
                            <button type="submit" class="btn green">Next Step</button>
                            <!-- <button type="button" class="btn default">Cancel</button> -->
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection