<?php
use App\Lib\MyHelper;
$grantedFeature     = session('granted_features');
$step_approve = $step_approve??0;
$allTotalScore = 0;
$allMinScore = 0;
$totalTheories = 0;
?>
@extends('layouts.main-closed')


@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet" type="text/css" />

@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/js/bootstrap-select.js') }}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-bootstrap-select.min.js') }}"  type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/form-repeater.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>
    <script>
function myFunction() {
  var start = document.getElementById("start_date").value;
  var end = document.getElementById("end_date").value;
  if(start < end){
     $("#submit").removeAttr('disabled');
  }
}
</script>
        <script>
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
        function npwp(id){
            $(id).inputmask("remove");
            $(id).inputmask({
                mask: "99.999.999.9-999.999",
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
        function banks(id){
            $(id).inputmask("remove");
            $(id).inputmask({
                mask: "9999999999999999999999999",
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
        $('.date_picker').datepicker({
            'format' : 'yyyy-mm-d',
            'todayHighlight' : true,
            'autoclose' : true
        });

		$(".form_datetime").datetimepicker({
			format: "d-M-yyyy hh:ii",
			autoclose: true,
			todayBtn: true,
			minuteStep:1
		});

        var SweetAlert = function() {
            return {
                init: function() {
                    $(".save").each(function() {
                        var token  	= "{{ csrf_token() }}";
                        let column 	= $(this).parents('tr');
                        let name    = $(this).data('name');
						let status    = $(this).data('status');
						let form    = $(this).data('form');
                        $(this).click(function() {
                            swal({
                                    title: name+"\n\nAre you sure want change to status "+status.toLowerCase()+" ?",
                                    text: "Your will not be able to recover this data!",
                                    type: "warning",
                                    showCancelButton: true,
                                    confirmButtonClass: "btn-info",
                                    confirmButtonText: "Yes, save it!",
                                    closeOnConfirm: false
                                },
                                function(){
                                   $.ajax({
                                        type : "POST",
                                        url : "{{url('employee/recruitment/reject/'.$detail['id_employee'])}}",
                                        data : {
                                            '_token' : '{{csrf_token()}}'
                                        },
                                        success : function(response) {
                                            if (response.status == 'success') {
                                                swal("Deleted!", "Employee has been rejected.", "success")
                                                SweetAlert.init()
                                                location.href = "{{url('employee/recruitment/update/'.$detail['id_employee'])}}"
                                            }
                                            else if(response.status == "fail"){
                                                swal("Error!", "Failed to reject employee.", "error")
                                            }
                                            else {
                                                swal("Error!", "Something went wrong. Failed to reject employee.", "error")
                                            }
                                        }
                                    });
                                });
                        })
                    })
                }
            }
        }();

        jQuery(document).ready(function() {
            npwp('#npwp');
            banks('#banks');
            number('#phone_emergency_contact');
            SweetAlert.init()
            @if($detail['status_employee']=='Permanent')
               $("#show_end").hide();
               $('#end_date').prop('required', false);
            @endif
        });
        
        $(".filePhoto").change(function(e) {
                var widthImg  = 300;
                var heightImg = 300;

                var _URL = window.URL || window.webkitURL;
                var image, file;

                if ((file = this.files[0])) {
                        image = new Image();

                        image.onload = function() {
                                if (this.width != widthImg && this.height != heightImg) {
                                        toastr.warning("Please check dimension of your photo.");
                                        $('#image').children('img').attr('src', 'https://www.placehold.it/720x360/EFEFEF/AAAAAA&amp;text=no+image');
                                        $('#filePhoto').val("");
                                        $("#removeImage").trigger( "click" );
                                }
                        };

                        image.src = _URL.createObjectURL(file);
                }

        });

        $('.numeric').on('input', function (event) {
                this.value = this.value.replace(/[^0-9]/g, '');
        });

        function changeAutoGeneratePin() {
                if(document.getElementById('auto_generate_pin').checked){
                        $("#div_password").hide();
                        $('#pin1').prop('required', false);
                        $('#pin2').prop('required', false);
                }else{
                        $("#div_password").show();
                        $('#pin1').prop('required', true);
                        $('#pin2').prop('required', true);
                }
        }
        
        function changeAutoGeneratePinApprove() {
                if(document.getElementById('auto_generate_pin').checked){
                        $("#div_password").hide();
                        $('#pinapp1').prop('required', false);
                        $('#pinapp2').prop('required', false);
                }else{
                        $("#div_password").show();
                        $('#pinapp1').prop('required', true);
                        $('#pinapp2').prop('required', true);
                }
        }
        function submitScore() {
                $("#list_data_training").hide();
                $("#form_data_training").show();
        }

        function backToListTraining() {
                $("#list_data_training").show();
                $("#form_data_training").hide();
        }
        function changeAutoGeneratePin() {
                if(document.getElementById('auto_generate_pin').checked){
                        $("#div_password").hide();
                        $('#pin1').prop('required', false);
                        $('#pin2').prop('required', false);
                }else{
                        $("#div_password").show();
                        $('#pin1').prop('required', true);
                        $('#pin2').prop('required', true);
                }
        }
        
        function changeAutoGeneratePinApprove() {
                if(document.getElementById('auto_generate_pin').checked){
                        $("#div_password").hide();
                        $('#pinapp1').prop('required', false);
                        $('#pinapp2').prop('required', false);
                }else{
                        $("#div_password").show();
                        $('#pinapp1').prop('required', true);
                        $('#pinapp2').prop('required', true);
                }
        }
        function changeStatusEmployee(val) {
                if(val == 'Permanent'){
                        $("#show_end").hide();
                        $('#end_date').prop('required', false);
                        $("#required_manager").hide();
                        $('#id_manager').prop('required', false);
                }else{
                        $("#show_start").show();
                        $("#show_end").show();
                        $('#start_date').prop('required', true);
                        $('#end_date').prop('required', true);
                        if(val == 'Contract'){
                                $("#required_manager").hide();
                                $('#id_manager').prop('required', false);
                        }else{
                                $("#required_manager").show();
                                $('#id_manager').prop('required', true);
                        }
                }
        }
        function submitScore() {
                $("#list_data_training").hide();
                $("#form_data_training").show();
        }

        var prev_id_theory = '';
        function changeCategoryTheory(value) {
                $("#cat_"+value).show();
                if(prev_id_theory !== ''){
                        $("#cat_"+prev_id_theory).hide();
                }
                prev_id_theory = value;
                conclusionScore(value);
                validationConclusion(value);
        }
        
        function nextStepFromTrainingResult(id) {
                var token  	= "{{ csrf_token() }}";
                swal({
                        title: 'Are you sure want to next step "Approve"?',
                        text: "Your will not be able to recover this data!",
                        type: "info",
                        showCancelButton: true,
                        confirmButtonClass: "btn-info",
                        confirmButtonText: "Yes, to next step!",
                        closeOnConfirm: false
                },
                function(){
                        $.ajax({
                                type : "POST",
                                url : "{{ url('recruitment/hair-stylist/update-status') }}",
                                data : "_token="+token+"&id_employee="+id+"&status=Training Completed",
                                success : function(result) {
                                        if (result.status == "success") {
                                                swal({
                                                        title: 'Updated!',
                                                        text: "Success updated status.",
                                                        type: "success",
                                                        showCancelButton: false,
                                                        showConfirmButton: false
                                                });
                                                SweetAlert.init()
                                                location.href = "{{url('recruitment/hair-stylist/candidate/detail')}}"+"/"+id+"?step_approve=1";
                                        }
                                        else {
                                                toastr.warning(result.messages);
                                        }
                                }
                        });
                });
        }
        
        function conclusionScore(id) {
                var total = 0;
                var j = 0;
                var disable_status = 0;
                $('#conclusion_score_'+id).val('');
                $('.score_theory_'+id).each(function(i, obj) {
                        j++;
                        var score_id = obj.id;
                        var value = $('#'+score_id).val();
                        var split = score_id.split('_');
                        var id_theory = split[1];
                        var minimum = $('#minimum_score_'+id_theory).val();
                        $('#error_text_'+id_theory).hide();

                        if(parseInt(value) < parseInt(minimum)){
                                $('#passed_status_'+id_theory).val('Not Passed').trigger("change");
                        }else{
                                $('#passed_status_'+id_theory).val('Passed').trigger("change");
                        }

                        if(value > 100){
                                disable_status = 1;
                                $('#error_text_'+id_theory).show();
                        }
                        if(value){
                                total = total + parseInt(value);
                        }
                });

                var average = parseInt(total/j);
                $('#conclusion_score_'+id).val(average);

                var total_minimum_score = $('#conclusion_minimum_score_'+id).val();
                if(average < total_minimum_score){
                        $('#conclusion_status_'+id).val('Not Passed').trigger("change");
                }else{
                        $('#conclusion_status_'+id).val('Passed').trigger("change");
                }

                if(disable_status == 1){
                        $("#btn_submit_traning").attr("disabled", true);
                }else{
                        $("#btn_submit_traning").attr("disabled", false);
                }

                validationConclusion(id, 1);
        }

        $('#start_date').on('change',function(){
            var status_employee = $('#status_employee').val();
            if(status_employee == 'Probation'){
                var probation = {{ $detail['duration_probation'] }};
                var start_date = $('#start_date').val();
                var end_date = new Date(start_date);
                end_date.setMonth(end_date.getMonth() + parseInt(probation));
                end_date = end_date.toLocaleDateString();
                end_date = end_date.split("/");
                if(end_date[0]<10){
                    end_date[0] = '0'+end_date[0];
                }
                if(end_date[1]<10){
                    end_date[1] = '0'+end_date[1];
                }
                $('#end_date').val(end_date[2]+'-'+end_date[0]+'-'+end_date[1]);
            }
        });

        
        function validationConclusion(id, not_check = 0) {
                var score = $('#conclusion_score_'+id).val();
                if(score > 100){
                        $('#conclusion_error_text_'+id).show();
                        $("#btn_submit_traning").attr("disabled", true);
                }else{
                        $('#conclusion_error_text_'+id).hide();
                        $("#btn_submit_traning").attr("disabled", false);
                }

                if(not_check == 0){
                        var total_minimum_score = $('#conclusion_minimum_score_'+id).val();
                        if(parseInt(score) < parseInt(total_minimum_score)){
                                $('#conclusion_status_'+id).val('Not Passed').trigger("change");
                        }else{
                                $('#conclusion_status_'+id).val('Passed').trigger("change");
                        }
                }
        }
        
        function manager() {
              var office = $('#id_outlet').val();
              var role = $('#id_role').val();
              if(office != "" && role != ""){
                  var data = {
                        "id_outlet": office,
                        "id_role": role,
                        "_token":"{{csrf_token()}}"
                    };
                    
                  $.ajax({
                    url: "{{url('employee/recruitment/manager')}}",
                    type: 'post',
                    data: data,
                    dataType: 'json',
                    success: function(data) {
                        $('select[name="id_manager"]').empty();
                        $.each(data,function(key, value){
                            $('select[name="id_manager"]').append('<option value="'+value.id+'">'+ value.name +'</option>');
                        });
                    }
                })
              }else{
                 $('select[name="id_manager"]').empty();
              }
        }
        function matchPassword(form_type) {
                if(form_type == 'detail'){
                        var pin_1 = $('#pin1').val();
                        var pin_2 = $('#pin2').val();
                }else{
                        var pin_1 = $('#pinapp1').val();
                        var pin_2 = $('#pinapp2').val();
                }

                if(pin_1 != pin_2){
                        $("#btn_submit_"+form_type).attr("disabled", true);
                        $("#alert_password_"+form_type).show();
                }else{
                        $("#btn_submit_"+form_type).attr("disabled", false);
                        $("#alert_password_"+form_type).hide();
                }
        }
        function showBusinessUpdate() {
                $('#update-business-form').removeClass('hidden');
                $('#view-business-partner-id').addClass('hidden');
        }
        function hideBusinessUpdate() {
                $('#update-business-form').addClass('hidden');
                $('#view-business-partner-id').removeClass('hidden');
        }
        function createBusinessPartner(){
                const button = $('#view-business-partner-id button');
                const id_employee = <?php echo $detail['id_employee'] ?>;
                const thisButton = $('#create-business-show-btn').html('<i class="fa fa-spinner fa-spin"></i>')
                
                button.prop('disabled', true);
                $.ajax({
                        method: "POST",
                        url: "{{url('employee/recruitment/create-business-partner')}}",
                        data: {
                                _token: "{{csrf_token()}}",
                                id_employee: id_employee,
                        },
                        success: response => {
                                console.log(response);
                                if (response.status == 'success') {
                                        thisButton.html('Create');
                                        button.prop('disabled', false);
                                        button.addClass('hidden');
                                        $('#view-business-partner-id span').html(response.id_business_partner);
                                        toastr.info('Success to create Business Partner ID');
                                } else {
                                        thisButton.html('Create');
                                        button.prop('disabled', false);
                                        toastr.error(response?.messages);
                                }
                        },
                        error: errors => {
                                thisButton.html('Create');
                                button.prop('disabled', false);
                                toastr.error('Failed to create Business Partner ID');
                        }
                })
        }
        function submitBusinessUpdate(){
                const id_business_partner = $('#update-business-form :input[name=businees_partner_id]').val();
                const id_employee = <?php echo $detail['id_employee'] ?>;
                const button = $('#update-business-form button');
                

                if(id_business_partner=="" || id_business_partner==undefined){
                        toastr.error('Please input Business Partner ID');
                }else{
                        const okButton = $('#update-business-form #update-business-ok-btn').html('<i class="fa fa-spinner fa-spin"></i>');
                        button.prop('disabled', true);

                        $.ajax({
                        method: "POST",
                        url: "{{url('employee/recruitment/create-business-partner')}}",
                        data: {
                                _token: "{{csrf_token()}}",
                                id_employee: id_employee,
                                id_business_partner: id_business_partner,
                        },
                        success: response => {
                                console.log(response);
                                okButton.html('<i class="fa fa-check"></i>');
                                button.prop('disabled', false);
                                if (response.status == 'success') {
                                        hideBusinessUpdate();
                                        $('#view-business-partner-id button').addClass('hidden');
                                        $('#view-business-partner-id span').html(response.id_business_partner);
                                        toastr.info('Success to create Business Partner ID');
                                } else {
                                        toastr.error(response?.messages);
                                }

                        },
                        error: errors => {
                                console.log(errors);
                                okButton.html('<i class="fa fa-check"></i>');
                                button.prop('disabled', false);

                        }
                })
                }
                
        }
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
                <span class="caption-subject sbold uppercase font-blue">{{$sub_title}}</span>
            </div>
        </div>

        <div class="tabbable-line boxless tabbable-reversed">
        	<ul class="nav nav-tabs">
                <li @if($detail['status'] != 'candidate')) class="active" @endif>
                    <a href="#hs-info" data-toggle="tab"> Info </a>
                </li>
                <li @if($detail['status'] == 'candidate') class="active" @endif>
                    <a href="#candidate-status" data-toggle="tab"> Status Employee </a>
                </li>
                <li >
                    <a href="#contact" data-toggle="tab"> Emergency Contact </a>
                </li>
                <li >
                    <a href="#family" data-toggle="tab"> Family </a>
                </li>
                <li >
                    <a href="#education" data-toggle="tab"> Education </a>
                </li>
                <li >
                    <a href="#job-experience" data-toggle="tab"> Job Experience</a>
                </li>
                <li >
                    <a href="#question" data-toggle="tab"> Question</a>
                </li>
                <li >
                    <a href="#custom-link" data-toggle="tab"> Custom Link</a>
                </li>
            </ul>
        </div>

		<div class="tab-content">
                    <div class="tab-pane @if($detail['status'] != 'candidate') active @endif form" id="hs-info">
                            <form class="form-horizontal" id="form-submit" role="form" action="{{url('employee/recruitment/complement/'.$detail['id_employee'])}}" method="post" enctype="multipart/form-data">
                                    <div class="form-body">
                                            <div class="form-group">
                                                    <label class="col-md-4 control-label">Status</label>
                                                    <div class="col-md-6">
                                                            @if($detail['status_approved'] == 'submitted')
                                                                    <span class="sbold badge badge-pill" style="font-size: 14px!important;height: 25px!important;background-color: #9b9e9c;padding: 5px 12px;color: #fff;">Candidate</span>
                                                            @elseif($detail['status'] == 'active')
                                                                    <span class="sbold badge badge-pill" style="font-size: 14px!important;height: 25px!important;background-color: #26C281;padding: 5px 12px;color: #fff;">Active</span>
                                                            @elseif($detail['status'] == 'rejected')
                                                                    <span class="sbold badge badge-pill" style="font-size: 14px!important;height: 25px!important;background-color: #E7505A;padding: 5px 12px;color: #fff;">Rejected</span>
                                                            @elseif($detail['status'] == 'inactive')
                                                                    <span class="sbold badge badge-pill" style="font-size: 14px!important;height: 25px!important;background-color: #E7505A;padding: 5px 12px;color: #fff;">Inactive</span>
                                                            @else
                                                                    <span class="sbold badge badge-pill" style="font-size: 14px!important;height: 25px!important;background-color: #faf21e;padding: 5px 12px;color: #fff;">{{ $detail['status_approved'] ?? 'Not Set' }}</span>
                                                            @endif
                                                    </div>
                                            </div>
                                            <div class="form-group">
							<label class="col-md-4 control-label">Status Contract</label>
							<div class="col-md-6" style="margin-top: 0.7%">
								@if($detail['status_employee']=='Permanent')
									Permanent Employees
								@elseif($detail['status_employee']=='Contract')
									Contract Employees
                                                                @elseif($detail['status_employee']=='Probation')
									Probation Employees
                                                                @else
                                                                        Not Set
								@endif
							</div>
						</div>
                                            <div class="form-group">
							<label class="col-md-4 control-label">Type</label>
							<div class="col-md-6" style="margin-top: 0.7%">
								@if(empty($detail['type']==0))
                                                                    NIK
								@elseif(empty($detail['type']==1))
                                                                    NPWP
                                                                @else
                                                                    Others
								@endif
							</div>
						</div>
                                            @if($detail['status_employee']=='Permanent')
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Start Working</label>
                                                <div class="col-md-6" style="margin-top: 0.7%">
                                                        {{date('d M Y ', strtotime($detail['start_date']))}}
                                                </div>
                                            </div>
                                            @elseif($detail['status_employee']=='Contract')
                                            <div class="form-group">
							<label class="col-md-4 control-label">Start Contract</label>
							<div class="col-md-6" style="margin-top: 0.7%">
								{{date('d M Y', strtotime($detail['start_date']))}}
							</div>
						</div>
                                            <div class="form-group">
							<label class="col-md-4 control-label">End Contract</label>
							<div class="col-md-6" style="margin-top: 0.7%">
								{{date('d M Y', strtotime($detail['end_date']))}}
							</div>
						</div>
                                            @elseif($detail['status_employee']=='Probation')
                                            <div class="form-group">
							<label class="col-md-4 control-label">Start Probation</label>
							<div class="col-md-6" style="margin-top: 0.7%">
								{{date('d M Y', strtotime($detail['start_date']))}}
							</div>
						</div>
                                            <div class="form-group">
							<label class="col-md-4 control-label">End Probation</label>
							<div class="col-md-6" style="margin-top: 0.7%">
								{{date('d M Y', strtotime($detail['end_date']))}}
							</div>
						</div>
                                            @endif
                                            <div class="form-group">
                                                    <label class="col-md-4 control-label">File Contract</label>
                                                    <div class="col-md-6" style="margin-top: 0.7%">
                                                            @if(empty($detail['surat_perjanjian']))
                                                                    -
                                                            @else
                                                                    <a href="{{url('recruitment/hair-stylist/detail/download-file-contract', $detail['id_employee'])}}">{{$detail['code']}}.docx</a>
                                                            @endif
                                                    </div>
                                            </div>
                                            <div class="form-group">
                                                    <label class="col-md-4 control-label">Business Partner ID</label>
                                                    <div class="col-md-6" >
                                                        <div class="row">
                                                                <div class="hidden col-md-6" id="update-business-form">
                                                                    <div class="input-group">
                                                                        <input type="text" name="businees_partner_id" class="form-control" placeholder="Input Business Partner ID" value="{{$detail['id_business_partner']}}">
                                                                        <div class="input-group-btn">
                                                                            <button type="button" class="btn btn-primary" id="update-business-ok-btn" onclick="submitBusinessUpdate()"><i class="fa fa-check"></i></button>
                                                                            <button type="button" class="btn btn-danger" id="update-business-cancel-btn" onclick="hideBusinessUpdate()"><i class="fa fa-times"></i></button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                        </div>
                                                        <div class=" control-label"  id="view-business-partner-id" style="text-align: left;">
                                                                <span>
                                                                        @if(empty($detail['id_business_partner']))
                                                                                <em class="text-muted">Not Set</em>
                                                                        @else
                                                                                {{ $detail['id_business_partner'] }}
                                                                        @endif
                                                                </span>
                                                                @if(empty($detail['id_business_partner']))
                                                                        <button type="button" style="margin-left: 10px;" type="button" class="btn btn-primary btn-xs" id="update-business-show-btn" onclick="showBusinessUpdate()">Update</button>
                                                                        <button type="button" type="button" class="btn btn-success btn-xs" id="create-business-show-btn" onclick="createBusinessPartner()">Create</button>
                                                                @endif
                                                        </div>
                                                    </div>
                                            </div>
                                            <div class="form-group">
                                                    <label class="col-md-4 control-label">Name <span class="required" aria-required="true"> * </span>
                                                    </label>
                                                    <div class="col-md-6">
                                                            <div class="input-icon right">
                                                                    <input type="text" placeholder="Full Name" class="form-control" name="name" value="{{ $detail['name']??''}}" required >
                                                            </div>
                                                    </div>
                                            </div>
                                            <div class="form-group">
                                                    <label class="col-md-4 control-label">Nickname <span class="required" aria-required="true"> * </span>
                                                    </label>
                                                    <div class="col-md-6">
                                                            <div class="input-icon right">
                                                                    <input type="text" placeholder="Nickname" class="form-control" name="nickname" value="{{ $detail['nickname']??''}}" required>
                                                            </div>
                                                    </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                    <label class="col-md-4 control-label">Email <span class="required" aria-required="true"> * </span>
                                                    </label>
                                                    <div class="col-md-6">
                                                            <div class="input-icon right">
                                                                    <input type="text" placeholder="Email" class="form-control" name="email" value="{{ $detail['email']??''}}" disabled >
                                                            </div>
                                                    </div>
                                            </div>
                                            <div class="form-group">
                                                    <label class="col-md-4 control-label">Address <span class="required" aria-required="true"> * </span>
                                                    </label>
                                                    <div class="col-md-6">
                                                            <div class="input-icon right">
                                                                    <input type="text" placeholder="address" class="form-control" name="address" value="{{ $detail['address']??''}}" required >
                                                            </div>
                                                    </div>
                                            </div>
                                            <div class="form-group">
                                                    <label class="col-md-4 control-label">Phone <span class="required" aria-required="true"> * </span>
                                                    </label>
                                                    <div class="col-md-6">
                                                            <div class="input-icon right">
                                                                    <input type="text" placeholder="Phone" class="form-control" name="phone" value="{{ $detail['phone']??''}}" disabled >
                                                            </div>
                                                    </div>
                                            </div>
                                            <div class="form-group">
                                                    <label class="col-md-4 control-label">Gender <span class="required" aria-required="true"> * </span>
                                                    </label>
                                                    <div class="col-md-6">
                                                            <div class="input-icon right">
                                                                    <select  class="form-control select2" name="gender" data-placeholder="Select gender" required>
                                                                            <option></option>
                                                                            <option value="Male" @if($detail['gender'] == 'Male') selected @endif>Male</option>
                                                                            <option value="Female" @if($detail['gender'] == 'Female') selected @endif>Female</option>
                                                                    </select>
                                                            </div>
                                                    </div>
                                            </div>
                                            <div class="form-group">
                                                    <label class="col-md-4 control-label">Country <span class="required" aria-required="true"> * </span>
                                                    </label>
                                                    <div class="col-md-6">
                                                            <div class="input-icon right">
                                                                    <input type="text" placeholder="country" class="form-control" name="country" value="{{ $detail['country']??''}}" required >
                                                            </div>
                                                    </div>
                                            </div>
                                            <div class="form-group">
                                                    <label class="col-md-4 control-label">Birthplace <span class="required" aria-required="true"> * </span>
                                                    </label>
                                                    <div class="col-md-6">
                                                            <div class="input-icon right">
                                                                    <input type="text" placeholder="birthplace" class="form-control" name="birthplace" value="{{ $detail['birthplace']??''}}" required >
                                                            </div>
                                                    </div>
                                            </div>
                                            <div class="form-group">
                                                    <div class="input-icon right">
                                                            <label class="col-md-4 control-label">
                                                                    Birthday
                                                                    <span class="required" aria-required="true"> * </span>
                                                            </label>
                                                    </div>
                                                    <div class="col-md-6">
                                                            <div class="input-group">
                                                                    <input type="text" class="form-control date-picker" name="birthday" value="{{date('d-M-Y', strtotime($detail['birthday']))}}" required autocomplete="off" >
                                                                    <span class="input-group-btn">
                                                <button class="btn default" type="button">
                                                    <i class="fa fa-calendar"></i>
                                                </button>
                                            </span>
                                                            </div>
                                                    </div>
                                            </div>
                                            <div class="form-group">
                                                    <label  class="control-label col-md-4">Office
                                                        <span class="required" aria-required="true"> * </span>
                                                    </label>
                                                    <div class="col-md-6">
                                                        <select name="id_outlet" class="form-control input-sm select2" data-placeholder="Search Outlet" required>
                                                                    <option></option>
                                                                    @foreach($outlets as $key => $val)
                                                                    <option value="{{ $val['id_outlet'] }}" @if($detail['id_outlet']==$val['id_outlet']) selected @endif>{{ $val['outlet_code'] }} - {{ $val['outlet_name'] }}</option>
                                                                    @endforeach
                                                                </select>
                                                    </div>
                                            </div>
                                            <div class="form-group">
                                                    <label  class="control-label col-md-4">Role
                                                        <span class="required" aria-required="true"> * </span>
                                                    </label>
                                                    <div class="col-md-6">
                                                            <select name="id_role" class="form-control input-sm select2" data-placeholder="Search Role" required>
                                                                <option></option>
                                                                @foreach($roles as $key => $val)
                                                                    <option value="{{ $val['id_role'] }}" @if($detail['id_role']==$val['id_role']) selected @endif>{{ $val['role_name'] }}</option>
                                                                @endforeach
                                                            </select>
                                                    </div>
                                            </div>
                                            <div class="form-group">
                                                    <label class="col-md-4 control-label">Religion <span class="required" aria-required="true"> * </span>
                                                    </label>
                                                    <div class="col-md-6">
                                                            <div class="input-icon right">
                                                                    <input type="text" placeholder="Religion" class="form-control" name="religion" value="{{ $detail['religion']??''}}" required >
                                                            </div>
                                                    </div>
                                            </div>
                                            <div class="form-group">
                                                    <label class="col-md-4 control-label">Height
                                                    </label>
                                                    <div class="col-md-6">
                                                            <div class="input-icon right">
                                                                    <input type="text" placeholder="Height" class="form-control" name="height" value="{{ (int)$detail['height']??''}}" >
                                                            </div>
                                                    </div>
                                            </div>
                                            <div class="form-group">
                                                    <label class="col-md-4 control-label">Weight
                                                    </label>
                                                    <div class="col-md-6">
                                                            <div class="input-icon right">
                                                                    <input type="text" placeholder="Weight" class="form-control" name="weight" value="{{ (int)$detail['weight']??''}}" >
                                                            </div>
                                                    </div>
                                            </div>
                                            <div class="form-group">
                                                    <label class="col-md-4 control-label">Place of Origin
                                                    </label>
                                                    <div class="col-md-6">
                                                            <div class="input-icon right">
                                                                    <input type="text" placeholder="Place of Origin" class="form-control" name="place_of_origin" value="{{$detail['place_of_origin']??''}}" >
                                                            </div>
                                                    </div>
                                            </div>
                                            <div class="form-group">
                                                    <label class="col-md-4 control-label">Card Number
                                                    </label>
                                                    <div class="col-md-6">
                                                            <div class="input-icon right">
                                                                    <input type="text" placeholder="Card Number" class="form-control" name="card_number" value="{{$detail['card_number']??''}}" >
                                                            </div>
                                                    </div>
                                            </div>
                                            <div class="form-group">
                                                    <label  class="control-label col-md-4">City Card Number
                                                        <span class="required" aria-required="true"> * </span>
                                                    </label>
                                                    <div class="col-md-6">
                                                            <select name="id_city_ktp" class="form-control input-sm select2" data-placeholder="Search City Card Number" required>
                                                                <option></option>
                                                                @foreach($cities as $key => $val)
                                                                    <option value="{{ $val['id_city'] }}" @if($detail['id_city_ktp']==$val['id_city']) selected @endif>{{ $val['city_name'] }}</option>
                                                                @endforeach
                                                            </select>
                                                    </div>
                                            </div>
                                            <div class="form-group">
                                                    <label  class="control-label col-md-4">Address Card Number
                                                        <span class="required" aria-required="true"> * </span>
                                                    </label>
                                                    <div class="col-md-6">
                                                            <input type="text" placeholder="Address Card Number" class="form-control" name="address_ktp" value="{{ $detail['address_ktp']??''}}" required >
                                                    </div>
                                            </div>
                                            <div class="form-group">
                                                    <label  class="control-label col-md-4">Postcode Card Number
                                                        <span class="required" aria-required="true"> * </span></i>
                                                    </label>
                                                    <div class="col-md-6">
                                                            <input type="text" placeholder="Postcode Card Number" class="form-control" name="postcode_ktp" value="{{ $detail['postcode_ktp']??''}}" required >
                                                    </div>
                                            </div>
                                            <div class="form-group">
                                                    <label  class="control-label col-md-4">City Domicile
                                                        <span class="required" aria-required="true"> * </span>
                                                    </label>
                                                    <div class="col-md-6">
                                                            <select name="id_city_ktp" class="form-control input-sm select2" data-placeholder="Search City Domicile" required>
                                                                <option></option>
                                                                @foreach($cities as $key => $val)
                                                                    <option value="{{ $val['id_city'] }}" @if($detail['id_city_domicile']==$val['id_city']) selected @endif>{{ $val['city_name'] }}</option>
                                                                @endforeach
                                                            </select>
                                                    </div>
                                            </div>
                                            <div class="form-group">
                                                    <label  class="control-label col-md-4">Address Domicile
                                                        <span class="required" aria-required="true"> * </span>
                                                    </label>
                                                    <div class="col-md-6">
                                                            <input type="text" placeholder="Address Domicile" class="form-control" name="address_domicile" value="{{ $detail['address_domicile']??''}}" required >
                                                    </div>
                                            </div>
                                            <div class="form-group">
                                                    <label  class="control-label col-md-4">Postcode Domicile
                                                        <span class="required" aria-required="true"> * </span></i>
                                                    </label>
                                                    <div class="col-md-6">
                                                            <input type="text" placeholder="Postcode Domicile" class="form-control" name="postcode_domicile" value="{{ $detail['postcode_domicile']??''}}" required >
                                                    </div>
                                            </div>
                                            <div class="form-group">
                                                    <label  class="control-label col-md-4">Phone Number
                                                        <span class="required" aria-required="true"> * </span></i>
                                                    </label>
                                                    <div class="col-md-6">
                                                            <input type="text" placeholder="Phone Number" class="form-control" name="phone_number" value="{{ $detail['phone_number']??''}}" required >
                                                    </div>
                                            </div>
                                            <div class="form-group">
                                                    <label  class="control-label col-md-4">Status Domicile
                                                        <span class="required" aria-required="true"> * </span></i>
                                                    </label>
                                                    <div class="col-md-6">
                                                            <input type="text" placeholder="Status Domicile" class="form-control" name="status_address_domicile" value="{{ $detail['status_address_domicile']??''}}" required >
                                                    </div>
                                            </div>
                                            <div class="form-group">
                                                    <label class="col-md-4 control-label">Blood Type <span class="required" aria-required="true"> * </span>
                                                    </label>
                                                    <div class="col-md-6">
                                                            <div class="input-icon right">
                                                                    <select  class="form-control select2" name="blood_type" data-placeholder="Select blood type" required>
                                                                            <option></option>
                                                                            <option value="A" @if($detail['blood_type'] == 'A') selected @endif>A</option>
                                                                            <option value="B" @if($detail['blood_type'] == 'B') selected @endif>B</option>
                                                                            <option value="AB" @if($detail['blood_type'] == 'AB') selected @endif>AB</option>
                                                                            <option value="O" @if($detail['blood_type'] == 'O') selected @endif>O</option>
                                                                    </select>
                                                            </div>
                                                    </div>
                                            </div>
                                            <div class="form-group">
                                                    <label class="col-md-4 control-label">Marital Status <span class="required" aria-required="true"> * </span>
                                                    </label>
                                                    <div class="col-md-6">
                                                            <div class="input-icon right">
                                                                    <select  class="form-control select2" name="marital_status" data-placeholder="Select marital status" required>
                                                                            <option></option>
                                                                            <option value="Lajang" @if($detail['marital_status'] == 'Lajang') selected @endif>Lajang</option>
                                                                            <option value="Married" @if($detail['marital_status'] == 'Menikah') selected @endif>Menikah</option>
                                                                            <option value="Widowed" @if($detail['marital_status'] == 'Janda') selected @endif>Janda</option>
                                                                            <option value="Divorced" @if($detail['marital_status'] == 'Duda') selected @endif>Duda</option>
                                                                    </select>
                                                            </div>
                                                    </div>
                                            </div>

                    @if(!empty($detail['experiences']))
                    <div class="form-group">
                                                    <label class="col-md-7 control-label" style="font-size: 18px; font-weight: bold; !important;">Work Experience</label>
                                            </div>
                        @foreach ($detail['experiences'] as $e => $experience)
                        @if ($e!=0)
                        <div class="row" style="margin-bottom: 15px">
                            <div class="col-md-2">
                            </div>
                            <div class="col-md-8">
                                <hr style="border-top: 1px dashed;">
                            </div>
                        </div>
                        @endif
                        <div class="form-group">
                            <label class="col-md-4 control-label">Barber / Salon Name
                            </label>
                            <div class="col-md-6">
                                <div class="input-icon right">
                                    <input type="text" placeholder="Barber / Salon Name" class="form-control" value="{{ $experience['salon_name']}}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Position
                            </label>
                            <div class="col-md-6">
                                <div class="input-icon right">
                                    <input type="text" placeholder="Position" class="form-control" value="{{ $experience['position']}}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Work Period
                            </label>
                            <div class="col-md-6">
                                <div class="input-icon right">
                                    <input type="text" placeholder="Period" class="form-control" value="{{ $experience['period']}}" readonly>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @endif
                                    </div>
                                    @if(!empty($detail['employee']['documents']))
                                            <br>
                                            <div style="text-align: center"><h4>Document Employee</h4></div>
                                            <div class="form-group">
                                                    <div class="col-md-12">
                                                            <table class="table table-striped table-bordered table-hover">
                                                                    <thead>
                                                                    <tr>
                                                                            <th scope="col" width="10%"> Action </th>
                                                                            <th scope="col" width="10%"> Process Type </th>
                                                                            <th scope="col" width="10%"> Process Date </th>
                                                                            <th scope="col" width="10%"> Name </th>
                                                                            <th scope="col" width="10%"> Notes </th>
                                                                            <th scope="col" width="10%"> Save Date </th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>

                                                                    @foreach($detail['employee']['documents'] as $doc)
                                                                            <?php
                                                                                            $dataDoc[$doc['document_type']] = $doc;
                                                                            ?>


                                                                            <tr>
                                                                                    <td>
                                                                                            @if(!empty($doc['attachment']))
                                                                                                    <a class="btn blue btn-sm" href="{{ $doc['attachment']}}">Attachment</a>
                                                                                            @endif
                                                                                            @if($doc['document_type'] == 'Training Completed' && !empty($detailTheories))
                                                                                                    <a data-toggle="modal" href="#detail_{{$doc['id_employee_document']}}" class="btn green-jungle btn-sm">Score</a>
                                                                                                    <div id="detail_{{$doc['id_employee_document']}}" class="modal fade bs-modal-lg" tabindex="-1" aria-hidden="true">
                                                                                                            <div class="modal-dialog modal-lg">
                                                                                                                    <div class="modal-content">
                                                                                                                            <div class="modal-header">
                                                                                                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                                                                                                    <h4 class="modal-title">Detail Score</h4>
                                                                                                                            </div>
                                                                                                                            <div class="modal-body" style="margin-top: -4%">
                                                                                                                                    <?php
                                                                                                                                    $totalScore = 0;
                                                                                                                                    $minScore = 0;
                                                                                                                                    $detailTotalTheory = 0;
                                                                                                                                    ?>
                                                                                                                                    @foreach($detailTheories as $keyT=>$t)
                                                                                                                                            <div class="row">
                                                                                                                                                    <div class="col-md-12">
                                                                                                                                                            <p><b>{{$keyT}}</b></p>
                                                                                                                                                    </div>
                                                                                                                                            </div>
                                                                                                                                            @foreach($t as $data)
                                                                                                                                                    <?php
                                                                                                                                                            $totalScore = $totalScore + $data['score'];
                                                                                                                                                            $minScore = $minScore + $data['minimum_score'];
                                                                                                                                                            $detailTotalTheory++;
                                                                                                                                                    ?>
                                                                                                                                                    <div class="row">
                                                                                                                                                            <div class="col-md-7" style="margin-top: -2%;">
                                                                                                                                                                    <p>{{$data['theory_title']}}</p>
                                                                                                                                                            </div>
                                                                                                                                                            <div class="col-md-3">
                                                                                                                                                                    <div class="input-group">
                                                                                                                                                                            <input type="text" class="form-control" value="{{$data['score']}}" disabled>
                                                                                                                                                                            <span class="input-group-addon">minimal {{$data['minimum_score']}}</span>
                                                                                                                                                                    </div>
                                                                                                                                                            </div>
                                                                                                                                                            <div class="col-md-2">
                                                                                                                                                                    <input type="text" class="form-control" value="{{$data['passed_status']}}" disabled>
                                                                                                                                                            </div>
                                                                                                                                                    </div>
                                                                                                                                            @endforeach
                                                                                                                                    @endforeach
                                                                                                                                    <br>
                                                                                                                                    <hr style="border-top: 1px solid black;">
                                                                                                                                    <div class="row">
                                                                                                                                            <div class="col-md-7" style="margin-top: 0.7%"><b>Conclusion Score</b></div>
                                                                                                                                            <div class="col-md-3">
                                                                                                                                                    <div class="input-group">
                                                                                                                                                            <input type="text" class="form-control" value="{{(int)($totalScore/$detailTotalTheory)}}" disabled>
                                                                                                                                                            <span class="input-group-addon">minimal {{(int)($minScore/$detailTotalTheory)}}</span>
                                                                                                                                                    </div>
                                                                                                                                            </div>
                                                                                                                                            <div class="col-md-2">
                                                                                                                                                    <input type="text" class="form-control" value="{{$doc['conclusion_status']}}" disabled>
                                                                                                                                            </div>
                                                                                                                                    </div>
                                                                                                                            </div>
                                                                                                                    </div>
                                                                                                            </div>
                                                                                                    </div>
                                                                                            @endif
                                                                                    </td>
                                                                                    <td>{{$doc['document_type']}}</td>
                                                                                    <td>{{(!empty($doc['process_date']) ? date('d F Y H:i', strtotime($doc['process_date'])): '')}}</td>
                                                                                    <td>{{$doc['process_name_by']}}</td>
                                                                                    <td>{{$doc['process_notes']}}</td>
                                                                                    <td>{{date('d F Y H:i', strtotime($doc['created_at']))}}</td>
                                                                            </tr>
                                                                    @endforeach
                                                                    </tbody>
                                                            </table>
                                                    </div>
                                            </div>
                                    @endif

                                    @if(MyHelper::hasAccess([349], $grantedFeature) && $detail['status'] != 'rejected')
                                            {{ csrf_field() }}
                                            <div class="row" style="text-align: center">
                                                    @if(in_array($detail['status'], ['candidate','active']))
                                                            <button type="submit" id="btn_submit_detail" class="btn blue">Update</button>
                                                    @endif
                                            </div>
                                    @endif
                            </form>
                    </div>
                    <div class="tab-pane @if($detail['status'] == 'candidate') active @endif" id="candidate-status">
                            <br>
                            <br>
                            <div class="row">
                                    <div class="col-md-3">
                                            <ul class="ver-inline-menu tabbable margin-bottom-10">
                                                    <li @if($detail['status_approved'] == 'Submitted') class="active" @endif>
                                                            <a @if(in_array($detail['status_approved'], ['Submitted', 'Interview Invitation','Interview Result','Psikotest','HRGA','Contract','Approved','Success'])) data-toggle="tab" href="#interview" @else style="opacity: 0.4 !important;pointer-events: none;" @endif><i class="fa fa-cog"></i> Interview Invitation </a>
                                                    </li>
                                                    <li @if($detail['status_approved'] == 'Interview Invitation') class="active" @endif>
                                                            <a @if(in_array($detail['status_approved'], ['Interview Invitation','Interview Result','Psikotest','HRGA','Contract','Approved','Success'])) data-toggle="tab" href="#interview-result" @else style="opacity: 0.4 !important;pointer-events: none;" @endif><i class="fa fa-cog"></i> Interview Result </a>
                                                    </li>
                                                    <li @if($detail['status_approved'] == 'Interview Result') class="active" @endif>
                                                            <a  @if(in_array($detail['status_approved'], ['Interview Result','Psikotest','HRGA','Contract','Approved','Success'])) data-toggle="tab" href="#psychological_test" @else style="opacity: 0.4 !important;pointer-events: none;" @endif><i class="fa fa-cog"></i> Psychological Test </a>
                                                    </li>
                                                    <li @if($detail['status_approved'] == 'Psikotest') class="active" @endif>
                                                            <a  @if(in_array($detail['status_approved'], ['Psikotest','HRGA','Contract','Approved','Success'])) data-toggle="tab" href="#hrga" @else style="opacity: 0.4 !important;pointer-events: none;" @endif><i class="fa fa-cog"></i> Approval HRGA </a>
                                                    </li>
                                                    <li @if($detail['status_approved'] == 'HRGA') class="active" @endif>
                                                            <a  @if(in_array($detail['status_approved'], ['HRGA','Contract','Approved','Success'])) data-toggle="tab" href="#contract" @else style="opacity: 0.4 !important;pointer-events: none;" @endif><i class="fa fa-cog"></i> Contract</a>
                                                    </li>
                                                    <li @if($detail['status_approved'] == 'Contract') class="active" @endif>
                                                            <a  @if(in_array($detail['status_approved'], ['Contract','Approved','Success'])) data-toggle="tab" href="#approved" @else style="opacity: 0.4 !important;pointer-events: none;" @endif><i class="fa fa-cog"></i> Approve</a>
                                                    </li>
                                                    @if ($detail['status_employee'] == 'Probation')
                                                    <li @if($detail['status_approved'] == 'Approved') class="active" @endif>
                                                        <a  @if(in_array($detail['status_approved'], ['Approved','Success'])) data-toggle="tab" href="#probation-value" @else style="opacity: 0.4 !important;pointer-events: none;" @endif><i class="fa fa-cog"></i> Probation Value</a>
                                                    </li>
                                                    <li @if($detail['status_approved'] == 'Probation Value' || $detail['status_approved'] == 'Success' ) class="active" @endif>
                                                        <a  @if(in_array($detail['status_approved'], ['Probation Value','Success'])) data-toggle="tab" href="#bank" @else style="opacity: 0.4 !important;pointer-events: none;" @endif><i class="fa fa-cog"></i> Data Complement</a>
                                                    </li>
                                                    @else        
                                                    <li @if($detail['status_approved'] == 'Approved' ||$detail['status_approved'] == 'Success' ) class="active" @endif>
                                                            <a  @if(in_array($detail['status_approved'], ['Approved','Success'])) data-toggle="tab" href="#bank" @else style="opacity: 0.4 !important;pointer-events: none;" @endif><i class="fa fa-cog"></i> Data Complement</a>
                                                    </li>
                                                    @endif

                                            </ul>
                                    </div>
                                    <div class="col-md-9">
                                            <div class="tab-content">
                                                    <div class="tab-pane @if($detail['status_approved'] == 'Submitted') active @endif" id="interview">
                                                            @include('employee::employee.form_document_interview')
                                                    </div>
                                                <div class="tab-pane @if($detail['status_approved'] == 'Interview Invitation') active @endif" id="interview-result">
                                                            @include('employee::employee.form_document_interview_result')
                                                    </div>
                                                    <div class="tab-pane @if($detail['status_approved'] == 'Interview Result') active @endif" id="psychological_test">
                                                            @include('employee::employee.form_document_psychological')
                                                    </div>
                                                    <div class="tab-pane @if($detail['status_approved'] == 'Psikotest') active @endif" id="hrga">
                                                            @include('employee::employee.form_document_hrga')
                                                    </div>
                                                    <div class="tab-pane @if($detail['status_approved'] == 'HRGA') active @endif" id="contract">
                                                            @include('employee::employee.form_document_contract')
                                                    </div>
                                                    <div class="tab-pane @if($detail['status_approved'] == 'Contract') active @endif" id="approved">
                                                            @include('employee::employee.form_approve')
                                                    </div>
                                                    @if ($detail['status_employee'] == 'Probation')
                                                    <div class="tab-pane @if($detail['status_approved'] == 'Approved') active @endif" id="probation-value">
                                                        @include('employee::employee.form_probation_value')
                                                    </div>
                                                    <div class="tab-pane @if($detail['status_approved'] == 'Probation Value'||$detail['status_approved'] == 'Success') active @endif" id="bank">
                                                        @include('employee::employee.form_document_bank')
                                                    </div>
                                                    @else
                                                    <div class="tab-pane @if($detail['status_approved'] == 'Approved'||$detail['status_approved'] == 'Success') active @endif" id="bank">
                                                            @include('employee::employee.form_document_bank')
                                                    </div>
                                                    @endif

                                            </div>
                                    </div>
                            </div>
                    </div>
                    <div class="tab-pane" id="family">
			@if(!empty($detail['employee_family']))
                                <div style="text-align: center"><h4>Family Employee</h4></div>
                                <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                        <tr>
                                                <th scope="col" width="10%">Family Member</th>
                                                <th scope="col" width="10%">Family Name</th>
                                                <th scope="col" width="10%">Gender</th>
                                                <th scope="col" width="10%">Birthplace</th>
                                                <th scope="col" width="10%">Birthday</th>
                                                <th scope="col" width="10%">Education</th>
                                                <th scope="col" width="10%">Job</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($detail['employee_family'] as $doc)
                                        <tr>
                                            <td>{{$doc['family_members']??''}}</td>
                                            <td>{{$doc['name_family']??''}}</td>
                                            <td>{{$doc['gender_family']??''}}</td>
                                            <td>{{$doc['birthplace_family']??''}}</td>
                                            <td>{{$doc['birthday_family']??''}}</td>
                                            <td>{{$doc['education_family']??''}}</td>
                                            <td>{{$doc['job_family']??''}}</td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                </table>
                        @endif
                        @if(!empty($detail['employee_main_family']))
                                <br>
                                <div style="text-align: center"><h4>Main Family Employee</h4></div>
                                <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                        <tr>
                                                <th scope="col" width="10%">Family Member</th>
                                                <th scope="col" width="10%">Family Name</th>
                                                <th scope="col" width="10%">Gender</th>
                                                <th scope="col" width="10%">Birthplace</th>
                                                <th scope="col" width="10%">Birthday</th>
                                                <th scope="col" width="10%">Education</th>
                                                <th scope="col" width="10%">Job</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($detail['employee_main_family'] as $doc)
                                        <tr>
                                            <td>{{$doc['family_members']??''}}</td>
                                            <td>{{$doc['name_family']??''}}</td>
                                            <td>{{$doc['gender_family']??''}}</td>
                                            <td>{{$doc['birthplace_family']??''}}</td>
                                            <td>{{$doc['birthday_family']??''}}</td>
                                            <td>{{$doc['education_family']??''}}</td>
                                            <td>{{$doc['job_family']??''}}</td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                </table>
                        @endif
                    </div>
                    <div class="tab-pane" id="education">
			@if(!empty($detail['employee_education']))
                                <div style="text-align: center"><h4>Education</h4></div>
                                <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                        <tr>
                                                <th scope="col" width="10%">Level</th>
                                                <th scope="col" width="10%">Name </th>
                                                <th scope="col" width="10%">City</th>
                                                <th scope="col" width="10%">Program Study/Faculty</th>
                                                <th scope="col" width="10%">Year</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($detail['employee_education'] as $doc)
                                        <tr>
                                            <td>{{$doc['educational_level']??''}}</td>
                                            <td>{{$doc['name_school']??''}}</td>
                                            <td>{{$doc['city']['city_name']??''}}</td>
                                            <td>{{$doc['study_program']??''}}</td>
                                            <td>{{$doc['year_education']??''}}</td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                </table>
                        @endif
                        <br>
                        @if(!empty($detail['employee_education_non_formal']))
                                <div style="text-align: center"><h4>Education Non Formal</h4></div>
                                <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                        <tr>
                                                <th scope="col" width="10%">Course Type</th>
                                                <th scope="col" width="10%">Year</th>
                                                <th scope="col" width="10%">Long Term</th>
                                                <th scope="col" width="10%">Certificate</th>
                                                <th scope="col" width="10%">Financed by</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($detail['employee_education_non_formal'] as $doc)
                                        <tr>
                                            <td>{{$doc['course_type']??''}}</td>
                                            <td>{{$doc['year_education_non_formal']??''}}</td>
                                            <td>{{$doc['long_term']??''}}</td>
                                            <td>@if($doc['certificate']==1) Ada @else Tidak @endif</td>
                                            <td>{{$doc['financed_by']??''}}</td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                </table>
                        @endif
                    </div>
                    <div class="tab-pane" id="job-experience">
			@if(!empty($detail['employee_job_experience']))
                                <div style="text-align: center"><h4>Job Experience</h4></div>
                                <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                        <tr>
                                                <th scope="col" width="10%">Company Name</th>
                                                <th scope="col" width="10%">Address</th>
                                                <th scope="col" width="10%">Position</th>
                                                <th scope="col" width="10%">Industry Type</th>
                                                <th scope="col" width="10%">Periode</th>
                                                <th scope="col" width="10%">Employment Contract</th>
                                                <th scope="col" width="10%">Income</th>
                                                <th scope="col" width="10%">Scope</th>
                                                <th scope="col" width="10%">Achievement</th>
                                                <th scope="col" width="10%">Reason Resign</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($detail['employee_job_experience'] as $doc)
                                        <tr>
                                            <td>{{$doc['company_name']??''}}</td>
                                            <td>{{$doc['company_address']??''}}</td>
                                            <td>{{$doc['company_position']??''}}</td>
                                            <td>{{$doc['industry_type']??''}}</td>
                                            <td>{{$doc['working_period']??''}}</td>
                                            <td>{{$doc['employment_contract']??''}}</td>
                                            <td>{{$doc['total_income']??''}}</td>
                                            <td>{{$doc['scope_work']??''}}</td>
                                            <td>{{$doc['achievement']??''}}</td>
                                            <td>{{$doc['reason_resign']??''}}</td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                </table>
                        @endif
                        
                    </div>
                    <div class="tab-pane" id="question">
			            @include('employee::employee.question')
                    </div>
                    <div class="tab-pane" id="contact">
			            @include('employee::employee.contact')
                    </div>
                    <div class="tab-pane" id="custom-link">
			            @include('employee::employee.customlink')
                    </div>
		</div>
    </div>

@endsection