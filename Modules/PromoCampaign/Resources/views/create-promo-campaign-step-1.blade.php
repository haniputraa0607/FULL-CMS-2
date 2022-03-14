<?php
    use App\Lib\MyHelper;
    $configs  = session('configs');
 ?>
@extends('layouts.main-closed')

@section('page-style')
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
	<style type="text/css">
		.select2-results__option[aria-selected=true] {
		    display: none;
		}
		.text-decoration-none {
			text-decoration: none!important;
		}
	</style>
@endsection

@section('page-plugin')
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/jquery.inputmask.min.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-date-time-pickers.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>

	@php
		$code_type 			= null;
		$prefix_code 		= null;
		$number_last_code 	= null;
		$tag				= null;
		if (isset($result)) {
			$code_type 	= $result['code_type'];
			$tag		= $result['promo_campaign_have_tags'];
			if ($result['code_type'] == 'Multiple') {
				$prefix_code 		= $result['prefix_code'];
				$number_last_code 	= $result['number_last_code'];
			}
		} elseif (old() != "") {
			$code_type = old('code_type');
			if (old('code_type') == 'Multiple') {
			$prefix_code 		= old('prefix_code');
			$number_last_code 	= old('number_last_code');
			}
		}
	@endphp
	<script>
	function permut(total_set, each){
		total_set = parseInt(total_set);
		each = parseInt(each);
		let limit = total_set - each;
    	let permut = 1;
    	let arr = [];
    	do {
			permut = permut * total_set;
			total_set -= 1; 
		}
		while (total_set > limit);
		return permut;
    }
	function delay(callback, ms) {
		var timer = 0;
		return function() {
			var context = this, args = arguments;
			clearTimeout(timer);
			timer = setTimeout(function () {
			callback.apply(context, args);
			}, ms || 0);
		};
	}
	$(document).ready(function() {
		promo_id = {!! $result['id_promo_campaign_decrypt']??"false" !!};
		$('.digit_mask').inputmask({
			removeMaskOnSubmit: true, 
			placeholder: "",
			alias: "currency", 
			digits: 0, 
			rightAlign: false,
			min: '0',
			max: '999999999',
			prefix: ""
		});
		$('.digit_random').inputmask({
			removeMaskOnSubmit: true, 
			placeholder: "",
			alias: "currency", 
			digits: 0, 
			rightAlign: false,
			min: '1',
			max: '20',
			prefix: ""
		});
		$.ajax({
			type: "GET",
			url: "getTag",
			dataType: "json",
			success: function(data){
				if (data.status == 'fail') {
					$.ajax(this)
					return
				}
				productLoad = 1;
				$.each(data, function( key, value ) {
					$('#selectTag').append("<option id='tag"+value.id_promo_campaign_tag+"' value='"+value.tag_name+"'>"+value.tag_name+"</option>");
				});
				$('#multipleProduct').prop('required', true)
				$('#multipleProduct').prop('disabled', false)
			},
			complete: function(data){
				tag = JSON.parse('{!!json_encode($tag)!!}')
				$.each(tag, function( key, value ) {
					$("#tag"+value.promo_campaign_tag.id_promo_campaign_tag+"").attr('selected', true)
				});
			}
		});
		$("#selectTag").select2({
			placeholder: "Input tag",
			tags: true
		})
		$("#start_date").datetimepicker({
			format: "dd MM yyyy - hh:ii",
			autoclose: true,
			startDate: new Date(),
			minuteStep: 5,
			autoclose: true,
		}).on('changeDate', function (selected) {
			var minDate = new Date(selected.date.valueOf());
			$('#end_date').datetimepicker('setStartDate', minDate);
		});
		$("#end_date").datetimepicker({
			format: "dd MM yyyy - hh:ii",
			autoclose: true,
			minuteStep: 5,
		}).on('changeDate', function (selected) {
			var minDate = new Date(selected.date.valueOf());
			$('#start_date').datetimepicker('setEndDate', minDate);
		});
		$('#singleCode, #totalCoupon').hide()
		$('#multipleCode').hide()
		$('#exampleCode').hide()
		var maxChar = 15
		$('input[name=code_type]').change(function() {
			code = $('input[name=code_type]:checked').val()
			$('#exampleCode').replaceWith("<span id='exampleCode'></span>")
			$('#singleCode').hide()
			$('#multipleCode').hide()
			$('#brandingCode').hide()
			$('#singlePromoCode').prop('required', false);
			$('#multiplePrefixCode').prop('required', false);
			$('#multipleNumberLastCode').prop('required', false);
			$('#multiplePrefixCode').val('')
			if (code == 'Single') {
				$(':input[type="submit"]').prop('disabled', false);
				$('#totalCoupon, #total-tooltip-single').show();
				$('#total-tooltip-multiple').hide();
				$('#totalCoupon').removeClass( "has-error" );
				$('#alertTotalCoupon').hide();
				$('#singleCode').show().find('input').prop('required', true);
				$('#multipleCode').hide().find('input').prop('required', false);
				$('#singlePromoCode').prop('required', true);
				$('#singlePromoCode').keyup(function() {	
					$('#singlePromoCode').val(function () {
						return this.value.toUpperCase();
					})
				});
				$('#singlePromoCode').keyup(delay(function() {
					$.ajax({
						type: "GET",
						url: "check",
						data: {
							'type_code' 	: 'single',
							'search_code' 	: this.value,
							'promo_id' 		: promo_id
						},
						dataType: "json",
						success: function(msg){
							if (msg.status == 'available') {
								$(':input[type="submit"]').prop('disabled', false);
								$('#singleCode').children().removeClass( "has-error" );
								$('#alertSinglePromoCode').hide();
							} else {
								$(':input[type="submit"]').prop('disabled', true);
								$('#singleCode').children().addClass( "has-error" );
								$('#alertSinglePromoCode').show();
							}
						}
					});
				}, 1000));
			} else {
				$('#singleCode').hide().find('input').prop('required', false);
				$('#multipleCode').show().find('input').prop('required', true);
				$('#number_last_code, #totalCoupon, #total-tooltip-multiple').show()
				$('#total-tooltip-single').hide()
				$('input[name=total_coupon]').val('')
				$('#multipleNumberLastCode').prop('required', true);
				$('#multiplePrefixCode').keyup(function() {	
					$('#multiplePrefixCode').val (function () {
						return this.value.toUpperCase();
					})
				});
				$('#multiplePrefixCode').keyup(delay(function() {
					if ($(this).val()) {
						$.ajax({
							type: "GET",
							url: "check",
							data: {
								'type_code' 	: 'prefix',
								'search_code' 	: this.value,
								'promo_id' 		: promo_id
							},
							dataType: "json",
							success: function(msg){
								if (msg.status == 'available') {
									$(':input[type="submit"]').prop('disabled', false);
									$('#alertMultipleCode').removeClass( "has-error" );
									$('#alertMultiplePromoCode').hide();
								} else {
									$(':input[type="submit"]').prop('disabled', true);
									$('#alertMultipleCode').addClass( "has-error" );
									$('#alertMultiplePromoCode').show();
								}
							}
						});
						$('#exampleMultipleCode').show()
						$('#number_last_code').show()
						$('#multipleNumberLastCode').val('')
						$('#exampleCode').replaceWith("<span id='exampleCode'></span>")
						$('#multipleNumberLastCode').attr('max', maxChar - this.value.length)
						$('#digit-random-max').text(maxChar - this.value.length)
					}
					else {
						$(':input[type="submit"]').prop('disabled', false);
						$('#alertMultipleCode').removeClass( "has-error" );
						$('#alertMultiplePromoCode').hide();
						$('#multipleNumberLastCode').attr('max', maxChar - this.value.length)
					}
				}, 1000));
				$('#multipleNumberLastCode').keyup(function() {
					prefix = ($('#multiplePrefixCode').val())
					last_code = ($('#multipleNumberLastCode').val())
					max = +$(this).attr('max');
					val = +$(this).val();
					if (val > max) {
						$('#multipleNumberLastCode').val(max);
						last_code = max;
					}
					if(val < 6) {
						$(':input[type="submit"]').prop('disabled', true);
						$('#number_last_code').addClass( "has-error" );
						$('#alertDigitRandom').show();
						$('#multipleNumberLastCode').val('');
					}else{
						$(':input[type="submit"]').prop('disabled', false);
						$('#number_last_code').removeClass( "has-error" );
						$('#alertDigitRandom').hide();
					}
					var result           = '';
					var result1          = '';
					var result2          = '';
					var characters       = 'ABCDEFGHJKLMNPQRTUVWXY123456789';
					var charactersLength = characters.length;
					for ( var i = 0; i < last_code; i++ ) {
						result += characters.charAt(Math.floor(Math.random() * charactersLength));
						result2 += characters.charAt(Math.floor(Math.random() * charactersLength));
						result1 += characters.charAt(Math.floor(Math.random() * charactersLength));
					}
					$('#exampleCode').replaceWith("<span id='exampleCode'>"+prefix+result+"</span>")
					$('#exampleCode1').replaceWith("<span id='exampleCode1'>"+prefix+result1+"</span>")
					$('#exampleCode2').replaceWith("<span id='exampleCode2'>"+prefix+result2+"</span>")
				});
				$('#multipleNumberLastCode').keyup(function() {
					prefix = ($('#multiplePrefixCode').val())
					last_code = ($('#multipleNumberLastCode').val())
					max = +$(this).attr('max');
					val = +$(this).val();
					
					if (val > max) {
						$('#multipleNumberLastCode').val(max);
					}
				});
				$('input[name=total_coupon], #multipleNumberLastCode').keyup(function() {
					if (code == 'Multiple') {
						let maxCharDigit = 28;
						let hitungKemungkinan 	= permut(maxCharDigit, $('#multipleNumberLastCode').val());
						let totalCoupon 		= parseInt($('input[name=total_coupon]').inputmask('unmaskedvalue'));
						if (hitungKemungkinan >= totalCoupon && totalCoupon != 0) {
							$(':input[type="submit"]').prop('disabled', false);
							$('#totalCoupon').removeClass( "has-error" );
							$('#alertTotalCoupon').hide();
						} else {
							$(':input[type="submit"]').prop('disabled', true);
							$('#totalCoupon').addClass( "has-error" );
							$('#alertTotalCoupon').show();
						}
					}
				});
			}
		});
		var code_type = '{!!$code_type!!}'
		var prefix_code = '{!!$prefix_code!!}'
		var number_last_code = '{!!$number_last_code!!}'
		if (code_type == 'Single') {
			$('input[name=code_type]').trigger('change');
		} else if (code_type == 'Multiple') {
			$('input[name=code_type]').trigger('change');
			$('#multiplePrefixCode').val(prefix_code).trigger('keyup');
			$('#multipleNumberLastCode').val(number_last_code).trigger('keyup');
		}
		$('input[name=charged_central]').keyup(function () {
            var outlet = $('input[name=charged_outlet]').val();
            var central = $('input[name=charged_central]').val();
            var check = Number(outlet) + Number(central);
            if(check !== 100){
                document.getElementById('label_central').style.display = 'block';
                document.getElementById('label_outlet').style.display = 'block';
                $(':input[type="submit"]').prop('disabled', true);
            }else{
                document.getElementById('label_central').style.display = 'none';
                document.getElementById('label_outlet').style.display = 'none';
                $(':input[type="submit"]').prop('disabled', false);
            }
        });
        $('input[name=charged_outlet]').keyup(function (e) {
            var outlet = $('input[name=charged_outlet]').val();
            var central = $('input[name=charged_central]').val();
            var check = Number(outlet) + Number(central);
            if(check !== 100){
                document.getElementById('label_central').style.display = 'block';
                document.getElementById('label_outlet').style.display = 'block';
                $(':input[type="submit"]').prop('disabled', true);
            }else{
                document.getElementById('label_central').style.display = 'none';
                document.getElementById('label_outlet').style.display = 'none';
                $(':input[type="submit"]').prop('disabled', false);
            }
        });
        $('.fileinput-preview').bind('DOMSubtreeModified', function() {
            var mentah    = $(this).find('img')
            // set image
            var cariImage = mentah.attr('src')
            var ko        = new Image()
            ko.src        = cariImage
            // load image
            ko.onload     = function(){
                if (this.naturalHeight === 375 && this.naturalWidth === 750) {
                } else {
                    mentah.attr('src', "{{ $result['url_promo_image'] ?? 'https://www.placehold.it/750x375/EFEFEF/AAAAAA&text=no+image' }}")
                    $('#file').val("");
                    toastr.warning("Please check dimension of your photo.");
                }
            };
        })
	});
	</script>
	<style>
	input[type=number]::-webkit-inner-spin-button, 
	input[type=number]::-webkit-outer-spin-button { 
		-webkit-appearance: none; 
		margin: 0; 
	}
	</style>
	{{-- if promo campaign already used --}}
	@if( !empty($result['promo_campaign_reports']) && isset($result['step_complete']) && session('level') != 'Super Admin')
	<script type="text/javascript">
		$(document).ready(function() {
			$('.disable-form').find('input, textarea').prop('disabled', true);
			$('.disable-input').prop('disabled', true);
		});
	</script>
	@endif
@endsection

@section('content')
<div class="page-bar">
	<ul class="page-breadcrumb">
		<li>
			<a href="{{url('/')}}">Home</a>
		</li>
	</ul>
</div>
@include('layouts.notifications')

<div class="row" style="margin-top:20px">
	<div class="col-md-12">
		<div class="mt-element-step">
			<div class="row step-line">
				<div class="col-md-6 mt-step-col first active">
					<div class="mt-step-number bg-white">1</div>
					<div class="mt-step-title uppercase font-grey-cascade">Campaign Info</div>
					<div class="mt-step-content font-grey-cascade">Campaign Name, Title, Type & Total</div>
				</div>
				<div class="col-md-6 mt-step-col last">
					<a href="{{ ($result['id_promo_campaign'] ?? false) ? url('promo-campaign/step2/'.$result['id_promo_campaign']) : '' }}" class="text-decoration-none">
						<div class="mt-step-number bg-white">2</div>
						<div class="mt-step-title uppercase font-grey-cascade">Campaign Detail</div>
						<div class="mt-step-content font-grey-cascade">Detail Campaign Information</div>
					</a>
				</div>
			</div>
		</div>
	</div>
	<form role="form" action="" method="POST" enctype="multipart/form-data">
		<div class="col-md-1"></div>
		
		{{-- info --}}
		<div class="col-md-5">
			<div class="portlet light bordered">
				<div class="portlet-title">
					<div class="caption font-blue ">
						<i class="icon-settings font-blue "></i>
						<span class="caption-subject bold uppercase">Campaign Info</span>
					</div>
				</div>
				@if( !empty($result['promo_campaign_reports']) && isset($result['step_complete']))
				<input type="hidden" name="used_code_update" value="1">
				@endif
				<div class="portlet-body">
					<div class="form-group">
						<label class="control-label">Name</label>
						<span class="required" aria-required="true"> * </span>
						<i class="fa fa-question-circle tooltips" data-original-title="Nama Campaign" data-container="body"></i>
						<div class="input-group col-md-12">
							<input required type="text" class="form-control" name="campaign_name" placeholder="Campaign Name" @if(isset($result['campaign_name']) && $result['campaign_name'] != "") value="{{$result['campaign_name']}}" @elseif(old('campaign_name') != "") value="{{old('campaign_name')}}" @endif autocomplete="off">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label">Title</label>
						<span class="required" aria-required="true"> * </span>
                        <i class="fa fa-question-circle tooltips" data-original-title="Judul Promo" data-container="body"></i>
						<div class="input-group col-md-12">
							<input required type="text" class="form-control" name="promo_title" placeholder="Promo Title" @if(isset($result['promo_title']) && $result['promo_title'] != "") value="{{$result['promo_title']}}" @elseif(old('promo_title') != "") value="{{old('promo_title')}}" @endif autocomplete="off">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label">Description</label>
						<span class="required" aria-required="true"> * </span>
						<i class="fa fa-question-circle tooltips" data-original-title="Deskripsi Promo" data-container="body"></i>
						<div class="input-group col-md-12">
							<textarea required type="text" class="form-control" name="promo_campaign_description" placeholder="Promo Description">{{$result['promo_campaign_description']??old('promo_campaign_description')}}</textarea>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label">Image</label>
						<span class="required" aria-required="true"> * </span>
                        <i class="fa fa-question-circle tooltips" data-original-title="Gambar Promo" data-container="body"></i>
                        <br>
            			<span class="required" aria-required="true"> (750*375) </span>
						<div class="input-group col-md-12 text-center">
							<div class="fileinput fileinput-new" data-provides="fileinput">
			                    <div class="fileinput-new thumbnail" style="width: 350px; height: 175px;">
			                      <img src="{{ $result['url_promo_image'] ?? 'https://www.placehold.it/750x375/EFEFEF/AAAAAA&amp;text=no+image' }}" alt="Image Deals">
			                    </div>
			                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 350px; max-height: 175px;"></div>
			                    <div class="text-left">
			                        <span class="btn default btn-file">
			                        <span class="fileinput-new"> Select image </span>
			                        <span class="fileinput-exists"> Change </span>
			                        <input type="file" accept="image/*"  {{ empty($result['url_promo_image']) ? 'required' : '' }} name="promo_image" id="file">

			                        </span>

			                        <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
			                    </div>
			                </div>
						</div>
					</div>
					<div class="form-group">
						<label for="selectTag" class="control-label">Tag</label>
						<i class="fa fa-question-circle tooltips" data-original-title="Kode tag digunakan untuk mengkategorikan kode promo" data-container="body"></i>
						<select id="selectTag" name="promo_tag[]" class="form-control select2-multiple select2-hidden-accessible" multiple="multiple" tabindex="-1" aria-hidden="true"></select>
					</div>

					<div class="form-group">
						<label class="control-label">Charged Central</label>
						<span class="required" aria-required="true"> * </span>
						<i class="fa fa-question-circle tooltips" data-original-title="Percent fee yang akan dibebankan ke pihak pusat" data-container="body"></i>
						<div class="input-group col-md-12">
							<div class="input-group">
								<input required type="text" class="form-control disable-input" name="charged_central" placeholder="Charged Central" @if(isset($result['charged_central']) && $result['charged_central'] != "") value="{{$result['charged_central']}}" @elseif(old('charged_central') != "") value="{{old('charged_central')}}" @endif>
								<span class="input-group-addon">%</span>
							</div>
							<p style="color: red;display: none" id="label_central">Invalid value, charged central + charged outlet total must be 100</p>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label">Charged Outlet</label>
						<span class="required" aria-required="true"> * </span>
						<i class="fa fa-question-circle tooltips" data-original-title="Percent fee yang akan dibebankan ke pihak outlet" data-container="body"></i>
						<div class="input-group col-md-12">
							<div class="input-group">
								<input required type="text" class="form-control disable-input" name="charged_outlet" placeholder="Charged Outlet" @if(isset($result['charged_outlet']) && $result['charged_outlet'] != "") value="{{$result['charged_outlet']}}" @elseif(old('charged_outlet') != "") value="{{old('charged_outlet')}}" @endif>
								<span class="input-group-addon">%</span>
							</div>
							<p style="color: red;display: none" id="label_outlet">Invalid value, charged central + charged outlet total must be 100</p>
						</div>
					</div>
					<div class="form-group">
                        <div class="input-icon right">
                            <label class="control-label">
                            Brand
                            <span class="required" aria-required="true"> * </span>  
                            <i class="fa fa-question-circle tooltips" data-original-title="Pilih brand untuk promo campaign ini" data-container="body"></i>
                            </label>
                        </div>
                        <div class="">
                            <div class="input-icon right">
                                <select class="form-control select2-multiple disable-input" data-placeholder="Select Brand" name="id_brand[]" multiple required>
                                    <option></option>
                                @php
									$selected_brand = [];
									if (old('id_brand')) {
										$selected_brand = old('id_brand');
									}
									elseif (!empty($result['promo_campaign_brands'])) {
										$selected_brand = array_column($result['promo_campaign_brands'], 'id_brand');
									}
								@endphp
                                @if (!empty($brands))
                                    @foreach($brands as $brand)
                                        <option value="{{ $brand['id_brand'] }}" 
                                        	@if ($selected_brand) 
                                        		@if(in_array($brand['id_brand'], $selected_brand)) selected 
                                        		@endif 
                                        	@endif
                                        >{{ $brand['name_brand'] }}</option>
                                    @endforeach
                                @endif
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- <div class="form-group" style="height: 90px;">
						<label class="control-label">Brand Rule</label>
						<span class="required" aria-required="true"> * </span>
						<i class="fa fa-question-circle tooltips" data-original-title="Pilih rule yang akan digunakan untuk memilih outlet" data-container="body"></i>
						<div class="mt-radio-list">
							<label class="mt-radio mt-radio-outline"> All selected brands
								<input type="radio" value="and" name="brand_rule" @if(isset($result['brand_rule']) && $result['brand_rule'] == "and") checked @elseif(old('brand_rule') == "and") checked @endif required/>
								<i class="fa fa-question-circle tooltips" data-original-title="Promo akan berlaku untuk outlet yang memiliki semua brand yang dipilih" data-container="body"></i>
								<span></span>
							</label>
							<label class="mt-radio mt-radio-outline"> One of the selected brands
								<input type="radio" value="or" name="brand_rule" @if(isset($result['brand_rule']) && $result['brand_rule'] == "or") checked  @elseif(old('brand_rule') == "or") checked @endif required/>
								<i class="fa fa-question-circle tooltips" data-original-title="Promo akan berlaku untuk outlet yang memiliki setidaknya salah satu brand yang dipilih" data-container="body"></i>
								<span></span>
							</label>
						</div>
					</div> --}}
                    <input type="hidden" value="or" name="brand_rule"/>

					{{-- <div class="form-group" style="height: 125px;">
						<label class="control-label">Product Type</label>
						<span class="required" aria-required="true"> * </span>
						<i class="fa fa-question-circle tooltips" data-original-title="Pilih tipe produk yang akan dikenakan promo jika promo yang dipilih menggunakan syarat produk" data-container="body"></i>
						<div class="mt-radio-list">
							<label class="mt-radio mt-radio-outline"> Product only
								<input type="radio" value="single" name="product_type" @if(isset($result['product_type']) && $result['product_type'] == "single") checked @elseif(old('product_type') == "single") checked @endif required/>
								<i class="fa fa-question-circle tooltips" data-original-title="Syarat produk yang dapat dipilih hanya produk saja tanpa variant" data-container="body"></i>
								<span></span>
							</label>
							<label class="mt-radio mt-radio-outline"> Product variant only
								<input type="radio" value="variant" name="product_type" @if(isset($result['product_type']) && $result['product_type'] == "variant") checked  @elseif(old('product_type') == "variant") checked @endif required/>
								<i class="fa fa-question-circle tooltips" data-original-title="Syarat product yang dapat dipilih adalah product dengan variant" data-container="body"></i>
								<span></span>
							</label>
							<label class="mt-radio mt-radio-outline"> Product + Product variant
								<input type="radio" value="single + variant" name="product_type" @if(isset($result['product_type']) && $result['product_type'] == "single + variant") checked  @elseif(old('product_type') == "single + variant") checked @endif required/>
								<i class="fa fa-question-circle tooltips" data-original-title="Syarat product yang dapat dipilih adalah product dan product dengan variant" data-container="body"></i>
								<span></span>
							</label>
						</div>
					</div> --}}

                    <input type="hidden" value="single + variant" name="product_type"/>


                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="control-label">
                            Service
                            <span class="required" aria-required="true"> * </span>  
                            <i class="fa fa-question-circle tooltips" data-original-title="Pilih jenis servis yang dapat menggunakan promo campaign ini" data-container="body"></i>
                            </label>
                        </div>
                        <div class="">
                            <div class="input-icon right">
                                <select class="form-control select2-multiple disable-input" data-placeholder="Select Service" name="service[]" multiple required>
                                    <option></option>
                                @php
									$selected_service = [];
									if (old('service')) {
										$selected_service = old('service');
									}
									elseif (!empty($result['promo_campaign_services'])) {
										$selected_service = array_column($result['promo_campaign_services'], 'service');
									}
								@endphp
                                <option value="Outlet Service" @if ($selected_service) @if(in_array('Outlet Service', $selected_service)) selected @endif @endif>Outlet Service</option>
                                <option value="Home Service" @if ($selected_service) @if(in_array('Home Service', $selected_service)) selected @endif @endif>Home Service</option>
                                <option value="Online Shop" @if ($selected_service) @if(in_array('Online Shop', $selected_service)) selected @endif @endif>Online Shop</option>
                                <option value="Academy" @if ($selected_service) @if(in_array('Academy', $selected_service)) selected @endif @endif>Academy</option>
                                </select>
                            </div>
                        </div>
                    </div>

					<div class="form-group">
						<label class="control-label">Start Date</label>
						<span class="required" aria-required="true"> * </span>
                        <i class="fa fa-question-circle tooltips" data-original-title="Waktu dimulai berlakunya promo" data-container="body"></i>
						<div class="input-group date bs-datetime">
							<input required autocomplete="off" id="start_date" type="text" class="form-control disable-input" name="date_start" placeholder="Start Date" @if(isset($result['date_start']) && $result['date_start'] != "") value="{{date('d F Y - H:i', strtotime($result['date_start']))}}" @elseif(old('date_start') != "") value="{{old('date_start')}}" @endif>
							<span class="input-group-addon">
								<button class="btn default date-set" type="button">
									<i class="fa fa-calendar"></i>
								</button>
							</span>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label">End Date</label>
						<span class="required" aria-required="true"> * </span>
                        <i class="fa fa-question-circle tooltips" data-original-title="Waktu selesai berlakunya promo" data-container="body"></i>
						<div class="input-group date bs-datetime">
							<input required autocomplete="off" id="end_date" type="text" class="form-control" name="date_end" placeholder="End Date" @if(isset($result['date_end']) && $result['date_end'] != "") value="{{date('d F Y - H:i', strtotime($result['date_end']))}}" @elseif(old('date_end') != "") value="{{old('date_end')}}" @endif>
							<span class="input-group-addon">
								<button class="btn default date-set" type="button">
									<i class="fa fa-calendar"></i>
								</button>
							</span>
						</div>
					</div>
				</div>
			</div>
		</div>

		{{-- Code --}}
		@if ( !empty($result['promo_campaign_reports']) )
			@include('promocampaign::step1-code')
			@yield('code-info')
		@else	
			<div class="col-md-5">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption font-blue ">
							<i class="icon-settings font-blue "></i>
							<span class="caption-subject bold uppercase">Generate Code</span>
						</div>
					</div>
					<div class="portlet-body">
						<div class="form-group" style="height: 90px;">
							<label class="control-label">Code Type</label>
							<span class="required" aria-required="true"> * </span>
							<i class="fa fa-question-circle tooltips" data-original-title="Tipe kode promo yang dibuat" data-container="body"></i>
							<div class="mt-radio-list">
								<label class="mt-radio mt-radio-outline"> Single
									<input type="radio" value="Single" name="code_type" @if(isset($result['code_type']) && $result['code_type'] == "Single") checked @elseif(old('code_type') == "Single") checked @endif required/>
									<span></span>
								</label>
								<label class="mt-radio mt-radio-outline"> Multiple
									<input type="radio" value="Multiple" name="code_type" @if(isset($result['code_type']) && $result['code_type'] == "Multiple") checked  @elseif(old('code_type') == "Multiple") checked @endif required/>
									<span></span>
								</label>
							</div>
						</div>
						<div id="singleCode">
							<div class="form-group">
								<label class="control-label">Promo Code (Max 15 characters)</label>
								<span class="required" aria-required="true"> * </span>
								<i class="fa fa-question-circle tooltips" data-original-title="Kode promo yang dibuat" data-container="body"></i>
								<div class="input-group col-md-12">
									<input id="singlePromoCode" maxlength="15" type="text" class="form-control" name="promo_code" onkeyup="this.value=this.value.replace(/[^abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789]/g,'');" placeholder="Promo Code"  value="{{ old('promo_code')??$result['promo_campaign_promo_codes'][0]['promo_code']??null }}" autocomplete="off">
									<p id="alertSinglePromoCode" style="display: none;" class="help-block">Kode sudah pernah dibuat!</p>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label">Limit Usage (Penggunaan Per User)</label>
								<span class="required" aria-required="true"> * </span>
								<i class="fa fa-question-circle tooltips" data-original-title="Limit penggunaan kode promo untuk tiap user. Tulis 0 jika tidak ada limit." data-container="body"></i>
								<div class="input-group col-md-12">
									<input required type="text" class="form-control digit_mask" name="limitation_usage" placeholder="Limit Usage" value="{{ old('limitation_usage') ?? $result['limitation_usage'] ?? null }}" autocomplete="off">
								</div>
							</div>
						</div>
						<div id="multipleCode">
							<div class="form-group" id="alertMultipleCode">
								<label class="control-label">Prefix Code</label>
								<span class="required" aria-required="true"> * </span>
								<i class="fa fa-question-circle tooltips" data-original-title="Kode prefix untuk judul kode. Maksimal 9 karakter. Prefix Code + Digit Random tidak boleh lebih dari 15 karakter" data-container="body"></i>
								<div class="input-group col-md-12">
									<input id="multiplePrefixCode" maxlength="9" type="text" class="form-control" name="prefix_code" onkeyup="this.value=this.value.replace(/[^abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789]/g,'');" placeholder="Prefix Code" @if(isset($result['prefix_code']) && $result['prefix_code'] != "") value="{{$result['prefix_code']}}" @elseif(old('prefix_code') != "") value="{{old('prefix_code')}}" @endif autocomplete="off">
									<p id="alertMultiplePromoCode" style="display: none;" class="help-block">Kode prefix sudah pernah dibuat, lebih disarankan untuk membuat kode baru!</p>
								</div>
							</div>
							<div class="form-group" id="number_last_code">
								<label class="control-label">Digit Random</label>
								<span class="required" aria-required="true"> * </span>
								<i class="fa fa-question-circle tooltips" data-original-title="Jumlah digit yang digenerate secara otomatis untuk akhiran kode. Prefix Code + Digit Random tidak boleh lebih dari 15 karakter" data-container="body"></i>
								<div class="input-group col-md-12">
									<input id="multipleNumberLastCode" type="number" class="form-control" name="number_last_code" placeholder="Total Digit Random Last Code" @if(isset($result['number_last_code']) && $result['number_last_code'] != "") value="{{$result['number_last_code']}}" @elseif(old('number_last_code') != "") value="{{old('number_last_code')}}" @endif autocomplete="off" min="6" max="15">
								</div>
								<span class="help-block" id="subscription-false"> Min : <span id="digit-random-min" class="font-weight-bold" style="padding-right: 12px">6</span> Max : <span id="digit-random-max" class="font-weight-bold">15</span></span>
							</div>
							<div class="form-group">
								<label class="control-label">Example Code 
								<i class="fa fa-question-circle tooltips" data-original-title="Contoh Kode yang digenerate secara otomatis" data-container="body"></i></label>
								<div class="input-group col-md-12">
									<span id="exampleCode"></span>
								</div>
								<div class="input-group col-md-12">
									<span id="exampleCode1"></span>
								</div>
								<div class="input-group col-md-12">
									<span id="exampleCode2"></span>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label">User Limit (Penggunaan Per User)</label>
								<i class="fa fa-question-circle tooltips" data-original-title="Limit berapa kali satu user dapat menggunakan kode promo yang berbeda. Tulis 0 jika tidak ada limit." data-container="body"></i>
								<div class="input-group col-md-12">
									<input required type="text" class="form-control digit_mask" name="user_limit" placeholder="User Limit" value="{{ old('user_limit') ?? $result['user_limit'] ?? null }}" autocomplete="off">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label">Code Limit (Penggunaan Per Code)</label>
								<i class="fa fa-question-circle tooltips" data-original-title="Limit berapa kali satu kode promo dapat digunakan. Tulis 0 jika tidak ada limit." data-container="body"></i>
								<div class="input-group col-md-12">
									<input required type="text" class="form-control digit_mask" name="code_limit" placeholder="Code Limit" value="{{ old('code_limit') ?? $result['code_limit'] ?? null }}" autocomplete="off">
								</div>
							</div>
						</div>
						<div class="form-group" id="totalCoupon">
							<label class="control-label">Total Coupon (Jumlah Total Voucher)</label>
							<span class="required" aria-required="true"> * </span>
							<i class="fa fa-question-circle tooltips" data-original-title="Total kode kupon yang dibuat." data-container="body" id="total-tooltip-multiple" style="display: none"></i>
							<i class="fa fa-question-circle tooltips" data-original-title="Total kode kupon yang dibuat. Tulis 0 jika tidak ada limit." data-container="body" id="total-tooltip-single" style="display: none"></i>
							<div class="input-group col-md-12">
								<input required type="text" class="form-control digit_mask" name="total_coupon" placeholder="Total Coupon" value="{{ old('total_coupon') ?? $result['total_coupon'] ?? null }}" autocomplete="off">
								<p id="alertTotalCoupon" style="display: none;" class="help-block">Generate Random Total Coupon sangat tidak memungkinkan!</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		@endif
		
		<div class="col-md-1"></div>
		<div class="col-md-12" style="text-align:center;">
			<div class="form-actions">
				{{ csrf_field() }}
				<button type="submit" class="btn blue">Next Step ></button>
			</div>
		</div>
	</form>
</div>
@endsection