@extends('layouts.main')

@section('page-style')

    <link href="{{ url('assets/datemultiselect/jquery-ui.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css')}}" rel="stylesheet" type="text/css" />

    <link href="{{ url('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
    
@section('page-script')

    <!-- <script src="{{ url('assets/datemultiselect/jquery-ui.min.js') }}" type="text/javascript"></script> -->
    <script src="{{ url('assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
    <script src="{{ url('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
    <script src="{{ url('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ url('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ url('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>
    <script src="{{ url('assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}" type="text/javascript"></script>
    <script src="{{ url('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{ url('assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js')}}"></script>    
    <script src="{{ url('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    {{-- <script src="{{ url('js/prices.js')}}"></script> --}}
    
    <script>   
    $('.datepicker').datepicker({
        'format' : 'd-M-yyyy',
        'todayHighlight' : true,
        'autoclose' : true
    }); 
    $('.timepicker').timepicker(); 
        
    </script>
    
    <script type="text/javascript">
        $(document).ready(function() {
            var _URL = window.URL || window.webkitURL;

            /*$('.price').each(function() {
                var input = $(this).val();
                var input = input.replace(/[\D\s\._\-]+/g, "");
                input = input ? parseInt( input, 10 ) : 0;

                $(this).val( function() {
                    return ( input === 0 ) ? "" : input.toLocaleString( "id" );
                });
            });*/
            
            $('.summernote').summernote({
                placeholder: '',
                tabsize: 2,
                height: 120
            });

            /* TYPE VOUCHER */
            /*$('.voucherType').click(function() {
                // tampil duluk
                var nilai = $(this).val();

                // alert(nilai);

                if (nilai == "List Vouchers") {
                    $('#listVoucher').show();
                    $('.listVoucher').prop('required', true);

                    $('#generateVoucher').hide();
                    $('.generateVoucher').removeAttr('required');
                }
                else if(nilai == "Unlimited") {
                    $('.generateVoucher').val('');
                    $('.listVoucher').val('');
                    $('.listVoucher').removeAttr('required');

                    $('#listVoucher').hide();
                    $('#generateVoucher').hide();
                    $('.generateVoucher').removeAttr('required');
                }
                else {
                    $('#generateVoucher').show();
                    $('.generateVoucher').prop('required', true);

                    $('#listVoucher').hide();
                    $('.listVoucher').removeAttr('required');
                }
            });*/

            /* PRICES */
           /* $('.prices').click(function() {
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
            });*/

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

            /*$('.dealsPromoType').click(function() {
                $('.dealsPromoTypeShow').show();
                var nilai = $(this).val();

                if (nilai == "promoid") {
                    $('.dealsPromoTypeValuePromo').show();
                    $('.dealsPromoTypeValuePromo').prop('required', true);

                    $('.dealsPromoTypeValuePrice').val('');
                    $('.dealsPromoTypeValuePrice').hide();
                    $('.dealsPromoTypeValuePrice').removeAttr('required', true);
                }
                else {
                    $('.dealsPromoTypeValuePrice').show();
                    $('.dealsPromoTypeValuePrice').prop('required', true);
                    
                    $('.dealsPromoTypeValuePromo').val('');
                    $('.dealsPromoTypeValuePromo').hide();
                    $('.dealsPromoTypeValuePromo').removeAttr('required', true);
                }
            });*/

            // $("#file").change(function(e) {
                
            //     var image, file;
            //     if ((file = this.files[0])) {
            //         image = new Image();

            //         if (this.width != 300 && this.height != 300) {
            //             toastr.warning("Please check dimension of your photo.");
            //             $('#file').val("");
            //         }

            //         image.onload = function() {
            //             if (this.width != 300 && this.height != 300) {
            //                 toastr.warning("Please check dimension of your photo.");
            //                 $('#file').val("");
            //             }
            //             else {
            //                 image.src = _URL.createObjectURL(file);
            //             }
            //         };

            //     }
            //     else {
            //         $('#file').val("");
            //     }
            // });

            // $("#file").change(function(e) {
            //     var file = $(this)[0].files[0];

            //     img = new Image();

            //     var maxwidth  = 300;
            //     var maxheight = 300;


            //     img.src = _URL.createObjectURL(file);
            //     img.onload = function() {
            //         imgwidth  = this.width;
            //         imgheight = this.height;
                    
            //         if(imgwidth == maxwidth && imgheight == maxheight){
                        
            //         }else{
            //             toastr.warning("Please check dimension of your photo. Image size must be "+maxwidth+" X "+maxheight);
            //             // img.src = _URL.createObjectURL('http://www.placehold.it/500x500/EFEFEF/AAAAAA&text=no+image');
            //             $('#file').val("");
            //             $('#file').removeAttr('src');
            //         }
            //     };
            // });
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
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-red sbold uppercase ">New Item</span>
            </div>
        </div>
        <div class="portlet-body form">
            <form class="form-horizontal" role="form" action="{{ url()->current() }}" method="post" enctype="multipart/form-data" id="form">
                <div class="form-body">
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            Title  
                            <span class="required" aria-required="true"> * </span> 
                            <i class="fa fa-question-circle tooltips" data-original-title="Judul deals" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-9">
                            <div class="input-icon right">
                                <input type="text" class="form-control" name="deals_title" value="{{ old('deals_title') }}" placeholder="Title" required maxlength="30">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            Promo ID
                            <span class="required" aria-required="true"> * </span> 
                            <i class="fa fa-question-circle tooltips" data-original-title="Judul deals" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-9">
                            <div class="input-icon right">
                                <input type="text" class="form-control" name="deals_promo_id" value="{{ old('deals_promo_id') }}" placeholder="Promo ID" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            Description 
                            <i class="fa fa-question-circle tooltips" data-original-title="Deskripsi lengkap tentang deals yang dibuat" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-9">
                            <div class="input-icon right">
                                <textarea name="deals_description" class="form-control summernote">{{ old('deals_description') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            Voucher Expiry
                            <span class="required" aria-required="true"> * </span>  
                            <i class="fa fa-question-circle tooltips" data-original-title="Masa berlaku voucher, bisa diatur berdasarkan durasi deal atau tanggal expirednya" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-9">
                            <div class="input-icon right">
                                <div class="col-md-3">
                                    <div class="md-radio-inline">
                                        <div class="md-radio">
                                            <input type="radio" name="duration" id="radio9" value="dates" class="expiry md-radiobtn" required @if (old('duration') == "dates") checked @endif>
                                            <label for="radio9">
                                                <span></span>
                                                <span class="check"></span>
                                                <span class="box"></span> By Date </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="md-radio-inline">
                                        <div class="md-radio">
                                            <input type="radio" name="duration" id="radio10" value="duration" class="expiry md-radiobtn" required @if (old('duration') == "duration") checked @endif>
                                            <label for="radio10">
                                                <span></span>
                                                <span class="check"></span>
                                                <span class="box"></span> Duration </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group" id="times"  @if (old('duration')) style="display: block;" @else style="display: none;" @endif>
                        <label class="col-md-3 control-label"></label>
                        <div class="col-md-9">
                            <div class="col-md-3">
                                <label class="control-label">Expiry <span class="required" aria-required="true"> * </span> </label>
                            </div>
                            <div class="col-md-9 voucherTime" id="dates" @if (old('duration') == "dates") style="display: block;" @else style="display: none;" @endif>
                                <div class="input-group">
                                    <input type="text" class="datepicker form-control dates durationOpp" name="deals_voucher_expired" value="{{ old('deals_voucher_expired') }}">
                                    <span class="input-group-btn">
                                        <button class="btn default" type="button">
                                            <i class="fa fa-calendar"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-9 voucherTime" id="duration" @if (old('duration') == "duration") style="display: block;" @else style="display: none;" @endif>
                                <div class="input-group">
                                    <input type="number" class="form-control duration datesOpp" name="deals_voucher_duration" value="{{ old('deals_voucher_duration') }}">
                                    <span class="input-group-addon">
                                        day after claimed
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
    
                    
                </div>
                <div class="form-actions">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-offset-3 col-md-9">
                            <button type="submit" class="btn green">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection