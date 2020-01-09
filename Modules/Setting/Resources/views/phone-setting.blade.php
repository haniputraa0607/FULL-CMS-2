<?php
use App\Lib\MyHelper;
$grantedFeature     = session('granted_features');
$configs     		= session('configs');
?>
@extends('layouts.main')

@section('page-script')
	<script>
		$('#code_number').keypress(function (e) {
			var regex = new RegExp("^[0-9\-]+$");
			var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);

			var check_browser = navigator.userAgent.search("Firefox");

			if(check_browser == -1){
				if (regex.test(str) || e.which == 8) {
					return true;
				}
			}else{
				if (regex.test(str) || e.which == 8 ||  e.keyCode === 46 || (e.keyCode >= 37 && e.keyCode <= 40)) {
					return true;
				}
			}

			e.preventDefault();
			return false;
		});

		$('#min_num').keypress(function (e) {
			var regex = new RegExp("^[0-9]+$");
			var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);

			var check_browser = navigator.userAgent.search("Firefox");

			if(check_browser == -1){
				if (regex.test(str) || e.which == 8) {
					return true;
				}
			}else{
				if (regex.test(str) || e.which == 8 ||  e.keyCode === 46 || (e.keyCode >= 37 && e.keyCode <= 40)) {
					return true;
				}
			}

			e.preventDefault();
			return false;
		});

		$('#max_num').keypress(function (e) {
			var regex = new RegExp("^[0-9]+$");
			var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);

			var check_browser = navigator.userAgent.search("Firefox");

			if(check_browser == -1){
				if (regex.test(str) || e.which == 8) {
					return true;
				}
			}else{
				if (regex.test(str) || e.which == 8 ||  e.keyCode === 46 || (e.keyCode >= 37 && e.keyCode <= 40)) {
					return true;
				}
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
				<a href="{{url('/')}}">Home</a>
				<i class="fa fa-circle"></i>
			</li>
			<li>
				{{$title}}
			</li>
		</ul>
	</div>
	<br>

	<h1 class="page-title">
		<div class="row">
			<div class="col-md-6">
				Validation {{$title}}
			</div>
		</div>
	</h1>

	@include('layouts.notifications')
	<br>
	<div class="m-heading-1 border-green m-bordered">
		<p>Menu ini digunakan untuk mengatur proses validasi nomor telepon pengguna.</p><br>
		<ul>
			<li>mengatur minimum dan maximal panjang nomor telepon</li>
			<li>perhitungan panjang nomor akan dihitung mulai dari kode telepon <br> contoh : <br> nomor telepon = 62811133344 <br> panjang nomor = 11</li>
			<li>mengatur pesan yang akan ditampilkan kepengguna jika format nomor telepon tidak sesuai</li>
		</ul>
	</div>
	<br>
	<form role="form" class="form-horizontal" action="{{url('setting/phone/update')}}" method="POST">
		<div class="form-body">
			<div class="form-group">
				<div class="input-icon right">
					<label class="col-md-4 control-label" style="text-align: left;">
						Phone Code
						<span class="required" aria-required="true"> * </span>
						<i class="fa fa-question-circle tooltips" data-original-title="Kode nomor telepon negara" data-container="body"></i>
					</label>
				</div>
				<div class="col-md-4">
					<input class="form-control" type="text" id="code_number" name="code_number" value="{{$result[0]['code_number']}}" maxlength="5" required>
				</div>
			</div>
			<div class="form-group">
				<div class="input-icon right">
					<label class="col-md-4 control-label" style="text-align: left;">
						Minimum number length
						<span class="required" aria-required="true"> * </span>
						<i class="fa fa-question-circle tooltips" data-original-title="minimal panjang nomor telepon yang diijinkan" data-container="body"></i>
					</label>
				</div>
				<div class="col-md-4">
					<input class="form-control" type="text" id="min_num" name="min_length_number" maxlength="11" value="{{$result[0]['min_length_number']}}" required>
				</div>
			</div>
			<div class="form-group">
				<div class="input-icon right">
					<label class="col-md-4 control-label" style="text-align: left;">
						Maximum number length
						<span class="required" aria-required="true"> * </span>
						<i class="fa fa-question-circle tooltips" data-original-title="maximal panjang nomor telepon yang diijinkan" data-container="body"></i>
					</label>
				</div>
				<div class="col-md-4">
					<input class="form-control" type="text" id="max_num" name="max_length_number" maxlength="11" value="{{$result[0]['max_length_number']}}" required>
				</div>
			</div>
			<div class="form-group">
				<div class="input-icon right">
					<label class="col-md-4 control-label" style="text-align: left;">
						Message Failed
						<span class="required" aria-required="true"> * </span>
						<i class="fa fa-question-circle tooltips" data-original-title="pesan yang akan muncul ketika user memasukkan format nomor telepon yang salah" data-container="body"></i>
					</label>
				</div>
				<div class="col-md-4">
					<textarea class="form-control" type="text" name="message_failed" required>{{$result[0]['message_failed']}}</textarea>
				</div>
			</div>
			<div class="form-group">
				<div class="input-icon right">
					<label class="col-md-4 control-label" style="text-align: left;">
						Message Success
						<span class="required" aria-required="true"> * </span>
						<i class="fa fa-question-circle tooltips" data-original-title="pesan yang akan muncul ketika user memasukkan format nomor telepon yang benar" data-container="body"></i>
					</label>
				</div>
				<div class="col-md-4">
					<textarea class="form-control" type="text" name="message_success" required>{{$result[0]['message_success']}}</textarea>
				</div>
			</div>
		</div>

		<div class="form-actions">
			{{ csrf_field() }}
			<div class="row col-md-12" style="text-align: center;margin-top: 3%;">
				<button type="submit" class="btn green">Submit</button>
			</div>
		</div>
	</form>
@endsection