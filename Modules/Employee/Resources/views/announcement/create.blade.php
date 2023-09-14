@include('filter-v2')
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
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.css') }}" rel="stylesheet" type="text/css" />
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
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js') }}" type="text/javascript"></script>
	{{-- <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script> --}}
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-multi-select.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-date-time-pickers.min.js') }}" type="text/javascript"></script>
	{{-- <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/form-repeater.js') }}" type="text/javascript"></script> --}}
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/ui-confirmations.min.js') }}" type="text/javascript"></script>
	@yield('filter_script')
	<script type="text/javascript">
        // range date trx, receipt, order id, outlet, customer
        rules={
            all_data:{
                display:'All Data',
                operator:[],
                opsi:[]
            },
            id_province:{
                display:'Province',
                operator:[],
                opsi:{!!json_encode($provinces ?? [])!!},
                placeholder: "ex. Jakarta"
            },
            id_city:{
                display:'City',
                operator:[],
                opsi:{!!json_encode($cities ?? [])!!},
                placeholder: "ex. Bandung"
            },
            id_outlet:{
                display:'Outlet',
                operator:[],
                opsi:{!!json_encode($outlets ?? [])!!},
                placeholder: "ex. H20 Mall Puri"
            },
			id_role:{
                display:'Role',
                operator:[],
                opsi:{!!json_encode($roles ?? [])!!},
                placeholder: "ex. Staff Business Development"
            },
            
            
        };
    </script>
	<script>
	$(document).ready(function() {
	  $('.summernote').summernote({
		placeholder: 'Content',
		tabsize: 2,
		toolbar: [
				['style', ['style']],
				['style', ['bold', 'italic', 'underline', 'clear']],
				['fontsize', ['fontsize']],
				['color', ['color']],
				['para', ['ul', 'ol', 'paragraph']],
				['insert', ['table']],
				['insert', ['link', 'picture', 'video']],
				['misc', ['fullscreen', 'codeview', 'help']], ['height', ['height']]
			],
		height: 120
	  });
	});

    $('.select2').select2();
	$('#checkBtn').click(function() {
      checked = $("input[type=checkbox]:checked").length;
      if(!checked) {
        alert("You must check at least one Campaign Media.");
        return false;
      }

    });

	function addInboxSubject(param){
		var textvalue = $('#announcement_subject').val();
		var textvaluebaru = textvalue+" "+param;
		$('#announcement_subject').val(textvaluebaru);
    }

	function addInboxContent(param){
		var textvalue = $('#announcement_content').val();

		var textvaluebaru = textvalue+" "+param;
		$('#announcement_content').val(textvaluebaru);
		$('#announcement_content').summernote('editor.saveRange');
		$('#announcement_content').summernote('editor.restoreRange');
		$('#announcement_content').summernote('editor.focus');
		$('#announcement_content').summernote('editor.insertText', param);
    }
	function fetchDetail(det, type, idref=null){
		let token  = "{{ csrf_token() }}";
		if(det == 'Product'){
			$.ajax({
				type : "GET",
				url : "{{ url('product/ajax') }}",
				data : "_token="+token,
				success : function(result) {
					document.getElementById('atd_'+type).style.display = 'block';
					var operator_value = document.getElementsByName('announcement_id_reference')[0];
					for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
					operator_value.options[operator_value.options.length] = new Option("", "");
					for(x=0;x < result.length; x++){
						if(idref == result[x]['id_product']){
							operator_value.options[operator_value.options.length] = new Option(result[x]['product_name'], result[x]['id_product'], false, true);
						}else{
							operator_value.options[operator_value.options.length] = new Option(result[x]['product_name'], result[x]['id_product']);
						}
					}
				}
			});
			document.getElementById('link_'+type).style.display = 'none';
			if(type=="inbox") document.getElementById('div_inbox_content').style.display = 'none';
		}

		if(det == 'Outlet'){
			$.ajax({
				type : "GET",
				url : "{{ url('outlet/ajax') }}",
				data : "_token="+token,
				success : function(result) {
					document.getElementById('atd_'+type).style.display = 'block';
					var operator_value = document.getElementsByName('announcement_id_reference')[0];
					for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
					operator_value.options[operator_value.options.length] = new Option("", "");
					for(x=0;x < result.length; x++){
						if(idref == result[x]['id_outlet']){
							operator_value.options[operator_value.options.length] = new Option(result[x]['outlet_name'], result[x]['id_outlet'], false, true);
						}else{
							operator_value.options[operator_value.options.length] = new Option(result[x]['outlet_name'], result[x]['id_outlet']);
						}
					}
				}
			});
			document.getElementById('link_'+type).style.display = 'none';
			if(type=="inbox") document.getElementById('div_inbox_content').style.display = 'none';
		}

		if(det == 'News'){
			$.ajax({
				type : "GET",
				url : "{{ url('news/ajax') }}",
				data : "_token="+token,
				success : function(result) {
					document.getElementById('atd_'+type).style.display = 'block';
					var operator_value = document.getElementsByName('announcement_id_reference')[0];
					for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
					operator_value.options[operator_value.options.length] = new Option("", "");
					for(x=0;x < result.length; x++){
						if(idref == result[x]['id_news']){
							operator_value.options[operator_value.options.length] = new Option(result[x]['news_title'], result[x]['id_news'], false, true);
						}else{
							operator_value.options[operator_value.options.length] = new Option(result[x]['news_title'], result[x]['id_news']);
						}
					}
				}
			});
			document.getElementById('link_'+type).style.display = 'none';
			if(type=="inbox") document.getElementById('div_inbox_content').style.display = 'none';
			document.getElementById('announcement_id_reference').required = true;
		}else{
			document.getElementById('announcement_id_reference').required = false;
		}

		if(det == 'Home'){
			document.getElementById('atd_'+type).style.display = 'none';
			var operator_value = document.getElementsByName('announcement_id_reference')[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			document.getElementById('link_'+type).style.display = 'none';
			if(type=="inbox") document.getElementById('div_inbox_content').style.display = 'none';
		}

		if(det == 'Inbox'){
			document.getElementById('atd_'+type).style.display = 'none';
			var operator_value = document.getElementsByName('announcement_id_reference')[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			document.getElementById('link_'+type).style.display = 'none';
			if(type=="inbox") document.getElementById('div_inbox_content').style.display = 'none';
		}

		if(det == 'Voucher'){
			document.getElementById('atd_'+type).style.display = 'none';
			var operator_value = document.getElementsByName('announcement_id_reference')[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			document.getElementById('link_'+type).style.display = 'none';
			if(type=="inbox") document.getElementById('div_inbox_content').style.display = 'none';
		}

		if(det == 'Contact Us'){
			document.getElementById('atd_'+type).style.display = 'none';
			var operator_value = document.getElementsByName('announcement_id_reference')[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			document.getElementById('link_'+type).style.display = 'none';
			if(type=="inbox") document.getElementById('div_inbox_content').style.display = 'none';
		}

		if(det == 'Link'){
			console.log(idref)
			document.getElementById('atd_'+type).style.display = 'none';
			var operator_value = document.getElementsByName('announcement_id_reference')[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			document.getElementById('link_'+type).style.display = 'block';
			if(type=="inbox") document.getElementById('div_inbox_content').style.display = 'none';
			document.getElementById('announcement_link').required = true;
		}else{
			document.getElementById('announcement_link').required = false;
		}

		if(det == 'Logout'){
			document.getElementById('atd_'+type).style.display = 'none';
			var operator_value = document.getElementsByName('announcement_id_reference')[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			document.getElementById('link_'+type).style.display = 'none';
			if(type=="inbox") document.getElementById('div_inbox_content').style.display = 'none';
		}

		if(det == 'Content'){
			document.getElementById('atd_'+type).style.display = 'none';
			var operator_value = document.getElementsByName('announcement_id_reference')[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			document.getElementById('link_'+type).style.display = 'none';
			if(type=="inbox") document.getElementById('div_inbox_content').style.display = 'block';
		}
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
</div>
@include('layouts.notifications')

<form role="form" action="{{ url('employee/announcement/create') }}" method="POST" class="">
	<div class="row" style="margin-top:20px">
		<div class="col-md-12">
			{{ csrf_field() }}
			@if(isset($result['announcement_rule_parents']))
				<?php
					$search_param = $result['announcement_rule_parents'];
					$search_param = array_filter($search_param);
					$conditions = $search_param;
				?>
			@else
				@if(Session::has('form'))
				<?php
					$search_param = Session::get('form');
					$search_param = array_filter($search_param);
					if(isset($search_param['conditions'])){
						$conditions = $search_param['conditions'];
					} else {
						$conditions = "";
					}
				?>
				@else
				<?php
				//@if(isset($result['rules']))
				// @else
					$conditions = "";
				?>
				@endif
			@endif
			<?php $tombolsubmit = 'hidden'; ?>
			{{-- @include('filter') --}}
			@yield('filter_view')
		</div>
		<div class="col-md-12 form-horizontal">
			<div class="portlet light bordered">
				<div class="portlet-title">
					<div class="caption font-blue ">
						<i class="icon-settings font-blue "></i>
						<span class="caption-subject bold uppercase">Announcement Content</span>
					</div>
				</div>
				<div class="portlet-body form">
					<div class="form-body">
						<div class="form-group">
							<div class="input-icon right">
								<label class="col-md-2 control-label">
									Subject
									<i class="fa fa-question-circle tooltips" data-original-title="Subjek / judul pesan pengumuman" data-container="body"></i>
								</label>
							</div>
							<div class="col-md-10">
								<input type="text" placeholder="Announcement Subject" maxlength="125" class="form-control" name="announcement_subject" id="announcement_subject" autocomplete="off" required value="{{ $ann['content'] ?? null }}">
								@if (!empty($textreplaces))
									<br>
									You can use this variables to display user personalized information:
									<br><br>
									<div class="row">
										@foreach($textreplaces ?? [] as $key=>$row)
											<div class="col-md-3" style="margin-bottom:5px;">
												<span class="btn dark btn-xs btn-block btn-outline var" data-toggle="tooltip" title="Text will be replace '{{ $row['keyword'] }}' with user's {{ $row['reference'] }}" onClick="addInboxSubject('{{ $row['keyword'] }}');">{{ str_replace('_',' ',$row['keyword']) }}</span>
											</div>
										@endforeach
									</div>
								@endif
							</div>
						</div>
						<div class="form-group" style="display: none;">
							<div class="input-icon right">
								<label for="announcement_clickto" class="control-label col-md-2">
									Click Action
									<i class="fa fa-question-circle tooltips" data-original-title="action / menu yang terbuka saat user membuka inbox" data-container="body"></i>
								</label>
							</div>
							<div class="col-md-10">
								<select name="announcement_clickto" id="announcement_clickto" class="form-control select2" onChange="fetchDetail(this.value, 'inbox')">
									<option value="" selected></option>
									<option value="Home" @if(old('announcement_clickto') == 'Home') selected @endif>Home</option>
									{{-- <option value="Content" @if(old('announcement_clickto') == 'Content') selected @endif>Content</option> --}}
									<option value="News" @if(old('announcement_clickto') == 'News') selected @endif>News</option>
									<!-- <option value="Product" @if(old('announcement_clickto') == 'Product') selected @endif>Product</option> -->
									<option value="Outlet" @if(old('announcement_clickto') == 'Outlet') selected @endif>Outlet</option>
									<!-- <option value="Inbox" @if(old('announcement_clickto') == 'Inbox') selected @endif>Inbox</option> -->
									<option value="Voucher" @if(old('announcement_clickto') == 'Voucher') selected @endif>Voucher</option>
									<option value="Contact Us" @if(old('announcement_clickto') == 'Contact Us') selected @endif>Contact Us</option>
									<option value="Link" @if(old('announcement_clickto') == 'Link') selected @endif>Link</option>
									<option value="Logout" @if(old('announcement_clickto') == 'Logout') selected @endif>Logout</option>
								</select>
							</div>
						</div>
						<div class="form-group" id="atd_inbox" style="display:none;">
							<div class="input-icon right">
								<label for="autocrm_push_clickto" class="control-label col-md-2" style="padding-right: 0;">
									Action to Detail
									<i class="fa fa-question-circle tooltips" data-original-title="detail action / menu yang akan terbuka saat user membuka inbox" data-container="body"></i>
								</label>
							</div>
							<div class="col-md-10">
								<select name="announcement_id_reference" id="announcement_id_reference" class="form-control select2">
								</select>
							</div>
						</div>
						<div class="form-group" id="link_inbox" style="display:none;">
							<div class="input-icon right">
								<label for="announcement_clickto" class="control-label col-md-2">
									Link
									<i class="fa fa-question-circle tooltips" data-original-title="jika action berupa link, masukkan alamat link nya disini" data-container="body"></i>
								</label>
							</div>
							<div class="col-md-10">
								<input type="text" placeholder="https://" class="form-control" id="announcement_link" name="announcement_link" value="@if(old('announcement_link')){{old('announcement_link')}}@endif">
							</div>
						</div>
						<div class="form-group" id="div_inbox_content" style="display:none">
							<div class="input-icon right">
								<label for="multiple" class="control-label col-md-2" >
									Content
									<i class="fa fa-question-circle tooltips" data-original-title="konten pesan, tambahkan text replacer bila perlu" data-container="body"></i>
								</label>
							</div>
							<div class="col-md-10">
								<textarea name="announcement_content" id="announcement_content" class="form-control summernote">@if(old('announcement_content')) <?php echo old('announcement_content'); ?> @endif</textarea>
								You can use this variables to display user personalized information:
								<br><br>
								<div class="row">
									@foreach($textreplaces ?? [] as $key=>$row)
										<div class="col-md-3" style="margin-bottom:5px;">
											<span class="btn dark btn-xs btn-block btn-outline var" data-toggle="tooltip" title="Text will be replace '{{ $row['keyword'] }}' with user's {{ $row['reference'] }}" onClick="addInboxContent('{{ $row['keyword'] }}');">{{ str_replace('_',' ',$row['keyword']) }}</span>
										</div>
									@endforeach
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="input-icon right">
								<label class="col-md-2 control-label" >
									Published
									<i class="fa fa-question-circle tooltips" data-original-title="Tanggal mulai pengumuman ditampilkan ke user" data-container="body"></i>
								</label>
							</div>
							<div class="col-md-4" >
								<div class="input-group date form_datetime form_datetime bs-datetime">
									<input type="text" size="16" class="form-control" name="announcement_date_start" placeholder="Date to Start Displaying" required 
									value="{{ !empty($ann['date_start']) ? date('d F Y - H:i', strtotime($ann['date_start'])) : null }}" autocomplete="off">
									<span class="input-group-addon">
										<button class="btn default date-set" type="button">
											<i class="fa fa-calendar"></i>
										</button>
									</span>
								</div>
							</div>
							<div class="input-icon right">
								<label class="col-md-2 control-label" >
									Expired
									<i class="fa fa-question-circle tooltips" data-original-title="Tanggal berakhirnya pengumuman ditampilkan ke user" data-container="body"></i>
								</label>
							</div>
							<div class="col-md-4" >
								<div class="input-group date form_datetime form_datetime bs-datetime">
									<input type="text" size="16" class="form-control" name="announcement_date_end" placeholder="Date to Stop Displaying" required 
									value="{{ !empty($ann['date_end']) ? date('d F Y - H:i', strtotime($ann['date_end'])) : null }}" autocomplete="off">
									<span class="input-group-addon">
										<button class="btn default date-set" type="button">
											<i class="fa fa-calendar"></i>
										</button>
									</span>
								</div>
							</div>
						</div>
                                            <div class="form-group">
							<div class="input-icon right">
								<label class="col-md-2 control-label">
									Description
									<i class="fa fa-question-circle tooltips" data-original-title="Deskripsi dari pengumuman" data-container="body"></i>
								</label>
							</div>
							<div class="col-md-10">
								<textarea placeholder="Announcement Description" class="form-control" name="description" id="description" autocomplete="off" required>{{ $ann['description'] ?? null }}</textarea>
							</div>
						</div>
					</div>
					<div class="form-actions">
						{{ csrf_field() }}
						<div class="row">
							<div class="col-md-offset-2 col-md-10">
								<input type="hidden" name="id_employee_announcement" value="{{ $ann['id_employee_announcement'] ?? null }}">
								<button type="submit" class="btn yellow" id="checkBtn">Submit</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>
@endsection