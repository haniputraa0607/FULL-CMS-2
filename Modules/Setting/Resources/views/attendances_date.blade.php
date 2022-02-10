<?php
use App\Lib\MyHelper;
$grantedFeature     = session('granted_features');
$configs     		= session('configs');
?>
@extends('layouts.main')


@section('page-style')
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-multi-select/css/multi-select.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/clockface/css/clockface.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/css/profile-2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-plugin')
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/clockface/js/clockface.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-multi-select.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-date-time-pickers.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/ui-confirmations.min.js') }}" type="text/javascript"></script>
        <script>
        document.getElementById("start").onchange = function () {
                var inputs1 = document.getElementById("hidden");
                inputs1.setAttribute("value", this.value-1);
                var inputs = document.getElementById("end");
                inputs.setAttribute("value", this.value-1);
            }
        </script>
@endsection

@section('content')
	<div class="page-bar">
		<ul class="page-breadcrumb">
			<li>
				<a href="{{url('/')}}">Home</a>
				<i class="fa fa-circle"></i>
			</li>
			<li>
				{{$title}}
			</li>
		</ul>
	</div>
	<br>

	@include('layouts.notifications')
	<br>
        <div class="row" style="margin-top:20px">
	<div class="col-md-12">
		<div class="portlet light bordered">
                    <div class="portlet-title">
                                <div class="caption font-blue ">
                                        <i class="icon-settings font-blue "></i>
                                        <span class="caption-subject bold uppercase">This menu setting cut off </span>
                                </div>
                        </div>
                    <form role="form" class="form-horizontal" action="{{url('setting/setting-attendances-date')}}" method="POST" enctype="multipart/form-data">
                       
                        <div class="portlet light">
                            <div class="portlet-title">
                                    <div class="caption">
                                            <span class="caption-subject bold">Date Middle Cut Off</span>
                                    </div>
                            </div>
                            <div class="portlet-body form">
                                <div class="form-body"> 
                                        <div class="form-group">
                                            <label for="example-search-input" class="control-label col-md-4">Date<span class="required" aria-required="true">*</span>
                                                <i class="fa fa-question-circle tooltips" data-original-title="tanggal pertengahan perhitungan absensi" data-container="body"></i></label>
                                            <div class="col-md-5">
                                                <input value="{{$result['mid_date']??''}}" required type="number" min="1" max="28" name="mid_date" id="mid_date" class="form-control" placeholder="Enter date">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="example-search-input" class="control-label col-md-4">Delivery date<span class="required" aria-required="true">*</span>
                                                <i class="fa fa-question-circle tooltips" data-original-title="Tanggal pengiriman pendapatan tengah bulan" data-container="body"></i></label>
                                            <div class="col-md-5">
                                                <input value="{{$result['delivery_mid_date']??''}}" required type="number" min="1" max="28" name="delivery_mid_date" id="delivery_mid_date" class="form-control" placeholder="Enter date">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="example-search-input" class="control-label col-md-4">Product Commission
                                                <i class="fa fa-question-circle tooltips" data-original-title="Pada pembayaran tengah bulan komisi produk bisa di pilih maupun tidak" data-container="body"></i></label>
                                            <div class="col-md-6">
                                                <div class="mt-checkbox-inline">
                                                    <input type="checkbox" name="hs_income_calculation_mid[]"  @if(array_search("product_commission",$result['calculation_mid']) !== false) checked @endif  value="product_commission"> Product Commission
                                                </div>
                                            </div>
                                        </div>
                                        @if(isset($insentif))
                                        @php $insen = count($insentif); @endphp
                                        <div class="form-group">
                                            <label for="example-search-input" class="control-label col-md-4">Incentive
                                                <i class="fa fa-question-circle tooltips" data-original-title="Pada pembayaran tengah bulan dapat memilih insentif yang akan dihitung" data-container="body"></i></label>
                                            <div class="col-md-6">
                                                <div class="mt-checkbox-inline">
                                                    @foreach($insentif as $key => $row)
                                                        @php $key++; @endphp
                                                       <input type="checkbox" name="hs_income_calculation_mid[]" @if(array_search('incentive_'.$row['code'],$result['calculation_mid'])  !== false) checked @endif  value="incentive_{{$row['code']}}"> {{$row['name']}} ( {{$row['code']}} )
                                                       @if($key < $insen)
                                                       <br>
                                                       @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        @if(isset($cuts_salary))
                                         @php $potong = count($cuts_salary); @endphp
                                        <div class="form-group">
                                            <label for="example-search-input" class="control-label col-md-4">Cuts Salary
                                                <i class="fa fa-question-circle tooltips" data-original-title="Pada pembayaran tengah dapat memilih potongan yang akan dihitung" data-container="body"></i></label>
                                            <div class="col-md-6">
                                                <div class="mt-checkbox-inline">
                                                    @foreach($cuts_salary as $keys => $rows)
                                                        @php $keys++; @endphp
                                                       <input type="checkbox" name="hs_income_calculation_mid[]"  @if(array_search('salary_cut_'.$rows['code'],$result['calculation_mid'])  !== false) checked @endif value="salary_cut_{{$rows['code']}}"> {{$rows['name']}} ( {{$rows['code']}} )
                                                       @if($keys < $potong)
                                                       <br>
                                                       @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                </div>
                            </div>
                        </div>
                        <div class="portlet light">
                            <div class="portlet-title">
                                    <div class="caption ">
                                            <span class="caption-subject bold ">Date End Cut Off</span>
                                    </div>
                            </div>
                            <div class="portlet-body form">
                                <div class="form-body">
                                        <div class="form-group">
                                            <label for="example-search-input" class="control-label col-md-4">Date<span class="required" aria-required="true">*</span>
                                                <i class="fa fa-question-circle tooltips" data-original-title="Tanggal perhitungan akhir absensi" data-container="body"></i></label>
                                            <div class="col-md-5">
                                                <input value="{{$result['end_date']??''}}" requiredrequired type="number" min="2" max="28" name="end_date" id="end_date" class="form-control" placeholder="Enter start date">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="example-search-input" class="control-label col-md-4">Delivery date<span class="required" aria-required="true">*</span>
                                                <i class="fa fa-question-circle tooltips" data-original-title="Tanggal pengiriman pendapatan akhir bulan" data-container="body"></i></label>
                                            <div class="col-md-5">
                                                <input value="{{$result['delivery_end_date']??''}}" required type="number" min="1" max="28" name="delivery_end_date" id="delivery_end_date" class="form-control" placeholder="Enter date">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="example-search-input" class="control-label col-md-4">Product Commission
                                                <i class="fa fa-question-circle tooltips" data-original-title="Pada pembayaran tengah bulan komisi produk bisa di pilih maupun tidak" data-container="body"></i></label>
                                            <div class="col-md-6">
                                                <div class="mt-checkbox-inline">
                                                        <input type="checkbox" name="hs_income_calculation_end[]"  @if(array_search("product_commission",$result['calculation_end'])  !== false) checked @endif  value="product_commission"> Product Commission
                                                </div>
                                            </div>
                                        </div>
                                        @if(isset($insentif))
                                        @php $insen = count($insentif); @endphp
                                        <div class="form-group">
                                            <label for="example-search-input" class="control-label col-md-4">Incentive
                                                <i class="fa fa-question-circle tooltips" data-original-title="Pada pembayaran tengah bulan dapat memilih insentif yang akan dihitung" data-container="body"></i></label>
                                            <div class="col-md-6">
                                                <div class="mt-checkbox-inline">
                                                    @foreach($insentif as $key => $row)
                                                        @php $key++; @endphp
                                                       <input type="checkbox" name="hs_income_calculation_end[]"  @if(array_search('incentive_'.$row['code'],$result['calculation_end'])  !== false) checked @endif  value="incentive_{{$row['code']}}"> {{$row['name']}} ( {{$row['code']}} )
                                                       @if($key < $insen)
                                                       <br>
                                                       @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        @if(isset($cuts_salary))
                                         @php $potong = count($cuts_salary); @endphp
                                        <div class="form-group">
                                            <label for="example-search-input" class="control-label col-md-4">Cuts Salary
                                                <i class="fa fa-question-circle tooltips" data-original-title="Pada pembayaran tengah dapat memilih potongan yang akan dihitung" data-container="body"></i></label>
                                            <div class="col-md-6">
                                                <div class="mt-checkbox-inline">
                                                    @foreach($cuts_salary as $keys => $rows)
                                                        @php $keys++; @endphp
                                                       <input type="checkbox" name="hs_income_calculation_end[]" @if(array_search('salary_cut_'.$rows['code'],$result['calculation_end'])  !== false) checked @endif  value="salary_cut_{{$rows['code']}}"> {{$rows['name']}} ( {{$rows['code']}} )
                                                       @if($keys < $potong)
                                                       <br>
                                                       @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-actions" style="text-align:center;">
                                        {{ csrf_field() }}
                                        <button type="submit" class="btn blue" id="checkBtn">Submit</button>
                                    </div>
                    </form>    
                </div>
	</div>
</div>
@endsection