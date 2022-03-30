<?php
$submitCheck = true;
?>
@extends('layouts.main-closed')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/icheck/skins/all.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/icheck/icheck.min.js') }}" type="text/javascript"></script>
    <script>
        function changeColor(value) {
            if(value == 'Attend'){
                $('#status').css('color', 'green');
            }else if(value == 'Absent'){
                $('#status').css('color', 'red');
            }else if(value == 'Not Started'){
                $('#status').css('color', 'grey');
            }
        }

        $('.icheck').on('ifChecked', function(){
            var id = $(this).val();
            var cat = $(this).data('cat');
            $('#score_'+id).show();
            validationScore(cat);
            validationConclusion(cat);
        });

        $('.icheck').on('ifUnchecked', function(){
            var id = $(this).val();
            var cat = $(this).data('cat');
            $('#score_'+id).hide();
            $('#input_score_'+id).val('');
            validationScore(cat);
            validationConclusion(cat);
        });
        
        function validationScore(id) {
            var disable_status = 0;
            $('.score_theory_'+id).each(function(i, obj) {;
                var score_id = obj.id;
                var value = $('#'+score_id).val();
                var split = score_id.split('_');
                var id_theory = split[2];

                $('#error_text_'+id_theory).hide();
                if(value > 100){
                    disable_status = 1;
                    $('#error_text_'+id_theory).show();
                }
            });

            if(disable_status == 1){
                $("#btn_submit_attendance").attr("disabled", true);
            }else{
                $("#btn_submit_attendance").attr("disabled", false);
            }
        }

        function validationConclusion(id) {
            var score = $('#conclusion_score_'+id).val();
            if(score > 100){
                $('#conclusion_error_text_'+id).show();
                $("#btn_submit_attendance").attr("disabled", true);
            }else{
                $('#conclusion_error_text_'+id).hide();
                $("#btn_submit_attendance").attr("disabled", false);
            }

            $('.conclusion').each(function() {
                if($(this).val() === ""){
                    $("#btn_submit_attendance").attr("disabled", true);
                }
            });
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
                <span class="caption-subject sbold uppercase font-blue">Info</span>
            </div>
        </div>
        <div class="portlet-body form">
            <div class="row" style="margin-bottom: 1%">
                <div class="col-md-3"><b>User Name</b></div>
                <div class="col-md-6">: {{$user['name']}}</div>
            </div>
            <div class="row" style="margin-bottom: 1%">
                <div class="col-md-3"><b>User Phone</b></div>
                <div class="col-md-6">: {{$user['phone']}}</div>
            </div>
            <div class="row" style="margin-bottom: 1%">
                <div class="col-md-3"><b>Outlet Name</b></div>
                <div class="col-md-6">: {{$outlet['outlet_code']}} - {{$outlet['outlet_name']}}</div>
            </div>
            <div class="row" style="margin-bottom: 1%">
                <div class="col-md-3"><b>Course Name</b></div>
                <div class="col-md-6">: {{$course['product_name']}}</div>
            </div>
            <div class="row" style="margin-bottom: 1%">
                <div class="col-md-3"><b>Duration</b></div>
                <div class="col-md-6">: {{$course['product_academy_duration']}} Month</div>
            </div>
            <div class="row" style="margin-bottom: 1%">
                <div class="col-md-3"><b>Total Meeting</b></div>
                <div class="col-md-6">: {{$course['product_academy_total_meeting']}} x @ {{$course['product_academy_hours_meeting']}} Hours</div>
            </div>
        </div>
    </div>

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject sbold uppercase font-blue">Attendance</span>
            </div>
        </div>
        <div class="portlet-body form">
            @if($detail['last_meeting'] == $detail['meeting'])
                <div class="alert alert-warning deteksi-trigger">
                    <p> Don't forget to input conclusion score. Can not save attendance when score conslusion is empty.</p>
                </div>
            @endif
            <form class="form-horizontal" role="form" action="{{url('academy/transaction/outlet/course/detail/attendace', $detail['id_transaction_academy_schedule'])}}" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label">
                            <b>Date</b>
                        </label>
                        <div class="col-md-4">
                            <input class="form-control" disabled value="{{date('d F Y H:i', strtotime($detail['schedule_date']))}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">
                            Attendance <span class="required" aria-required="true">*</span>
                        </label>
                        <div class="col-md-4">
                            <select class="form-control select2" id="status" name="transaction_academy_schedule_status" style="color: grey;" onchange="changeColor(this.value);" required>
                                <option value="Not Started" style="color: grey">Not Started</option>
                                <option value="Attend" style="color: green">Attend</option>
                                <option value="Absent" style="color: red">Absent</option>
                            </select>
                        </div>
                    </div>
                    <input type="hidden" name="id_transaction_academy" value="{{$detail['id_transaction_academy']}}">
                    <input type="hidden" name="id_product" value="{{$course['id_product']}}">
                    <input type="hidden" name="id_outlet" value="{{$outlet['id_outlet']}}">
                    <br>
                    <br>
                    <div class="row">
                        <div class="col-md-3">
                            <ul class="ver-inline-menu tabbable margin-bottom-10">
                                @foreach($theory_category as $index=>$tc)
                                    <li @if($index == 0) class="active" @endif>
                                        <a data-toggle="tab" href="#theory_category_{{$tc['id_theory_category']}}"><i class="fa fa-cog"></i> @if(strlen($tc['theory_category_name']) > 16) {{substr($tc['theory_category_name'],0, 20)}} ... @else {{$tc['theory_category_name']}} @endif </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="col-md-9">
                            <div class="tab-content">
                            @foreach($theory_category as $index=>$ct)
                                <div class="tab-pane @if($index == 0) active @endif" id="theory_category_{{$ct['id_theory_category']}}">
                                    <div style="text-align: center"><h3>{{$ct['theory_category_name']}}</h3></div>
                                    <hr style="border-top: 2px dashed;">
                                    <?php
                                        $htmlTheory = '';

                                        if(empty($ct['child'])){
                                            $htmlTheory .= '<div id="cat_'.$ct['id_theory_category'].'">';
                                            foreach ($ct['theory'] as $noTheo=>$theory){
                                                $htmlTheory .= '<div class="form-group">';
                                                $htmlTheory .= '<div class="col-md-1" style="margin-left: 2%;">';
                                                if($theory['checked'] == 1){
                                                    $htmlTheory .= '<i class="fa fa-check"></i>';
                                                }else{
                                                    $htmlTheory .= '<div class="icheck-list">';
                                                    $htmlTheory .= '<label><input type="checkbox" class="icheck" name="id_theory[]" value="'.$theory["id_theory"].'" </label>';
                                                    $htmlTheory .= '</div>';
                                                }
                                                $htmlTheory .= '</div>';
                                                $htmlTheory .= '<div class="col-md-8">';
                                                $htmlTheory .= '<p>'.$theory['theory_title'].'</p>';
                                                $htmlTheory .= '</div>';
                                                $htmlTheory .= '<div class="col-md-2" id="score_'.$theory["id_theory"].'" style="display: none;>';
                                                $htmlTheory .= '<input type="text" class="form-control score_theory_'.$ct['id_theory_category'].'" id="input_score_'.$theory['id_theory'].'" placeholder="Score" '.($theory['checked'] == 1 ? 'disabled':'').')" onkeyup="validationScore('.$ct['id_theory_category'].')">';
                                                $htmlTheory .= '<p style="color: red;margin-top: -1%;display: none" id="error_text_'.$theory['id_theory'].'">Maximal score is 100</p>';
                                                $htmlTheory .= '</div>';
                                                $htmlTheory .= '</div>';
                                                $htmlTheory .= '<input type="hidden" value="'.$theory['id_theory'].'">';
                                            }

                                            $htmlTheory .= '<br><hr style="border-top: 1px solid black;">';

                                            $htmlTheory .= '<div class="form-group">';
                                            $htmlTheory .= '<div class="col-md-9">';
                                            $htmlTheory .= '<p><b>Conclusion</b></p>';
                                            $htmlTheory .= '</div>';
                                            $htmlTheory .= '<div class="col-md-2">';
                                            $htmlTheory .= '<input type="text" class="form-control conclusion" id="conclusion_score_'.$ct['id_theory_category'].'" placeholder="Score" onkeyup="validationConclusion('.$ct['id_theory_category'].')" value="'.($ct['conclusion_score']??'').'">';
                                            $htmlTheory .= '<p style="color: red;margin-top: -1%;display: none" id="conclusion_error_text_'.$ct['id_theory_category'].'">Maximal score is 100</p>';
                                            $htmlTheory .= '</div>';
                                            $htmlTheory .= '</div>';

                                            $htmlTheory .= '</div>';

                                            if($detail['last_meeting'] == $detail['meeting'] && empty($ct['conclusion_score'])){
                                                $submitCheck = false;
                                            }
                                        }else{
                                            $htmlTheory .= '<div id="cat_'.$ct['id_theory_category'].'">';
                                            $totalMinimumScore = 0;
                                            $j = 0;
                                            foreach ($ct['child'] as $child){
                                                if(!empty($child['theory'])){
                                                    $htmlTheory .= '<div class="form-group">';
                                                    $htmlTheory .= '<div class="col-md-12"><b>'.$child['theory_category_name'].'</b></div>';
                                                    $htmlTheory .= '</div><br>';
                                                }

                                                foreach ($child['theory'] as $no=>$theory){
                                                    $htmlTheory .= '<div class="form-group">';
                                                    $htmlTheory .= '<div class="col-md-1" style="margin-left: 2%;">';
                                                    if($theory['checked'] == 1){
                                                        $htmlTheory .= '<i class="fa fa-check"></i>';
                                                    }else{
                                                        $htmlTheory .= '<div class="icheck-list">';
                                                        $htmlTheory .= '<label><input type="checkbox" class="icheck" data-cat="'.$ct['id_theory_category'].'" name="theory['.$theory['id_theory'].'][id_theory]" value="'.$theory["id_theory"].'" </label>';
                                                        $htmlTheory .= '</div>';
                                                    }
                                                    $htmlTheory .= '</div>';
                                                    $htmlTheory .= '<div class="col-md-8">';
                                                    $htmlTheory .= '<p>'.$theory['theory_title'].'</p>';
                                                    $htmlTheory .= '</div>';
                                                    $htmlTheory .= '<div class="col-md-2" id="score_'.$theory["id_theory"].'" '.($theory['checked'] == 0 ? 'style="display: none;"':'').'>';
                                                    $htmlTheory .= '<input type="text" class="form-control score_theory_'.$ct['id_theory_category'].'" name="theory['.$theory['id_theory'].'][score]" id="input_score_'.$theory['id_theory'].'" placeholder="Score" '.($theory['checked'] == 1 ? 'disabled value="'.$theory['score'].'"':'').' onkeyup="validationScore('.$ct['id_theory_category'].')">';
                                                    $htmlTheory .= '<p style="color: red;margin-top: -1%;display: none" id="error_text_'.$theory['id_theory'].'">Maximal score is 100</p>';
                                                    $htmlTheory .= '</div>';
                                                    $htmlTheory .= '</div>';
                                                    $htmlTheory .= '<input type="hidden" name="theory['.$theory['id_theory'].'][title]" value="'.$theory['theory_title'].'">';
                                                    $htmlTheory .= '<input type="hidden" name="theory['.$theory['id_theory'].'][parent_category]" value="'.$ct['id_theory_category'].'">';
                                                }
                                            }

                                            $htmlTheory .= '<br><hr style="border-top: 1px solid black;">';

                                            $htmlTheory .= '<div class="form-group">';
                                            $htmlTheory .= '<div class="col-md-9">';
                                            $htmlTheory .= '<p><b>Conclusion</b></p>';
                                            $htmlTheory .= '</div>';
                                            $htmlTheory .= '<div class="col-md-2" style="margin-left: 2%">';
                                            $htmlTheory .= '<input type="text" class="form-control conclusion" id="conclusion_score_'.$ct['id_theory_category'].'" onkeyup="validationConclusion('.$ct['id_theory_category'].')" name="conclusion_score['.$ct['id_theory_category'].']" value="'.($ct['conclusion_score']??'').'" placeholder="Score">';
                                            $htmlTheory .= '<p style="color: red;margin-top: -1%;display: none" id="conclusion_error_text_'.$ct['id_theory_category'].'">Maximal score is 100</p>';
                                            $htmlTheory .= '</div>';
                                            $htmlTheory .= '</div>';

                                            $htmlTheory .= '</div>';

                                            if($detail['last_meeting'] == $detail['meeting'] && empty($ct['conclusion_score'])){
                                                $submitCheck = false;
                                            }
                                        }

                                        echo $htmlTheory;
                                    ?>
                                </div>
                            @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="text-align: center">
                    {{ csrf_field() }}
                    <button type="submit" id="btn_submit_attendance" class="btn green" @if(!$submitCheck) disabled @endif>Save</button>
                </div>
            </form>
        </div>
    </div>
@endsection
