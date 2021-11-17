<?php
use App\Lib\MyHelper;
$grantedFeature     = session('granted_features');
?>
@php
    $datenow = date("Y-m-d H:i:s");
@endphp
<div style="white-space: nowrap;">
    <div class="portlet-body form">
        <div class="tab-pane">
            <div class="row">
                <div class="col-md-3">
                    <ul class="ver-inline-menu tabbable margin-bottom-10">
                        <li class="@if($result['status_steps']=='On Follow Up' || $result['status_steps']==null || $result['status_steps']=='Finished Follow Up') active @endif">
                            <a data-toggle="tab" href="#follow"><i class="fa fa-cog"></i> Follow Up </a>
                        </li>
                        <li class="@if($result['status_steps']=='Survey Location') active @endif" @if($result['status_steps']==null || $result['status_steps']=='On Follow Up') style="opacity: 0.4 !important" @endif>
                            <a @if($result['status_steps']==null || $result['status_steps']=='On Follow Up') @else data-toggle="tab" @endif href="#survey"><i class="fa fa-cog"></i> Survey Location </a>
                        </li>
                        <li class="@if($result['status_steps']=='Calculation') active @endif" @if($result['status_steps']==null || $result['status_steps']=='On Follow Up' || $result['status_steps']=='Finished Follow Up') style="opacity: 0.4 !important" @endif>
                            <a @if($result['status_steps']==null || $result['status_steps']=='On Follow Up' || $result['status_steps']=='Finished Follow Up') @else data-toggle="tab" @endif href="#calcu"><i class="fa fa-cog"></i> Calculation </a>
                        </li>
                        <li class="@if($result['status_steps']=='Confirmation Letter') active @endif" <a @if($result['status_steps']=='Calculation' || $result['status_steps']=='Confirmation Letter' || $result['status_steps']=='Payment') @else style="opacity: 0.4 !important" @endif>
                            <a @if($result['status_steps']=='Calculation' || $result['status_steps']=='Confirmation Letter' || $result['status_steps']=='Payment') data-toggle="tab" @endif href="#confirm"><i class="fa fa-cog"></i> Confirmation Letter </a>
                        </li>
                        <li class="@if($result['status_steps']=='Payment') active @endif" @if($result['status_steps']=='Confirmation Letter' || $result['status_steps']=='Payment') @else style="opacity: 0.4 !important" @endif>
                            <a @if($result['status_steps']=='Confirmation Letter' || $result['status_steps']=='Payment') data-toggle="tab" @endif href="#payment"><i class="fa fa-cog"></i> Payment </a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-9">
                    <div class="tab-content">
                        <div class="tab-pane @if($result['status_steps']=='On Follow Up' || $result['status_steps']==null || $result['status_steps']=='Finished Follow Up') active @endif" id="follow">
                            @include('businessdevelopment::outlet_manage.close_temporary.change_location.steps.follow_up')
                        </div>
                        <div class="tab-pane @if($result['status_steps']=='Survey Location') active @endif" id="survey">
                            @include('businessdevelopment::outlet_manage.close_temporary.change_location.steps.survey_loc')
                        </div>
                        <div class="tab-pane @if($result['status_steps']=='Calculation') active @endif" id="calcu">
                            @include('businessdevelopment::outlet_manage.close_temporary.change_location.steps.calculation') 
                        </div>
                        <div class="tab-pane @if($result['status_steps']=='Confirmation Letter') active @endif" id="confirm">
                            @include('businessdevelopment::outlet_manage.close_temporary.change_location.steps.confirmation')
                        </div>
                        <div class="tab-pane @if($result['status_steps']=='Payment') active @endif" id="payment">
                            @include('businessdevelopment::outlet_manage.close_temporary.change_location.steps.payment')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-sm" id="formSurvey" tabindex="-1" role="dialog" aria-labelledby="candidatePartnerModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="candidatePartnerModalLabel">Form Survey</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form" action="{{url('businessdev/partners/outlet/close/create-follow-up')}}" method="post" enctype="multipart/form-data">
                @if (isset($formSurvey) && !empty($formSurvey))
                <div class="form-body">
                    <input type="hidden" name="id_outlet_close_temporary" value="{{$result['id_outlet_close_temporary']}}">
                    <input type="hidden" name='follow_up' id="followUpModal" value="Survey Location">
                    <input type="hidden" name='note' id="noteModal" value="">
                    <input type="hidden" name='surye_note' id="surveynoteModal" value="">
                    <input type="hidden" name='survey_potential' id="potentialModal" value="">
                    @php
                        $i = 0;
                    @endphp
                    @foreach ($formSurvey as $x => $form)
                        <div class="form-group">
                            <div class="col-md-10">
                                <label for="example-search-input"><span class="sbold uppercase font-black">{{ $form['category'] }}</span></label>
                                <input type="hidden" name="category[{{ $i }}][cat]" value="{{ $form['category'] }}">
                            </div>
                        </div>
                        @foreach ($form["question"] as $x => $q )
                        <div class="form-group">
                            <div class="col-md-10">
                                <input type="hidden" name="category[{{ $i }}][question][{{ $x }}][question]" value="{{ $q }}">
                                <label for="example-search-input">{{ $q }}</label>
                            </div>
                            <div class="col-md-2">
                                <select name="category[{{ $i }}][question][{{ $x }}][answer]" class="form-control input-sm select2" required>
                                    <option value="" selected disabled></option>
                                    <option value="a">A</option>
                                    <option value="b">B</option>
                                    <option value="c">C</option>
                                    <option value="d">D</option>
                                </select>
                            </div>
                        </div>
                        @endforeach
                    @php
                        $i++;
                    @endphp
                    @endforeach
                    <div class="form-group">
                        <div class="col-md-3">
                            <label for="example-search-input">Import Attachment
                                <i class="fa fa-question-circle tooltips" data-original-title="Masukan file" data-container="body"></i><br>
                                <span class="required" aria-required="true"> (PDF max 2 mb) </span></label>
                        </div>
                        <div class="col-md-7" style="padding-left: 12px !important">
                            <div class="fileinput fileinput-new text-left" data-provides="fileinput">
                                <div class="input-group input-large">
                                    <div class="form-control uneditable-input input-fixed input-medium" data-trigger="fileinput">
                                        <i class="fa fa-file fileinput-exists"></i>&nbsp;
                                        <span class="fileinput-filename"> </span>
                                    </div>
                                    <span class="input-group-addon btn default btn-file">
                                                <span class="fileinput-new"> Select file </span>
                                                <span class="fileinput-exists"> Change </span>
                                                <input type="file" accept=".pdf, application/pdf, application/x-pdf,application/acrobat, applications/vnd.pdf, text/pdf, text/x-pdf" class="file" name="import_file" id="attSurv">
                                            </span>
                                    <a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @else
                    <center>
                        Form Survey for this brand has not been set yet
                    </center>
                @endif
                <div class="modal-footer form-actions">
                    {{ csrf_field() }}
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    @if (isset($formSurvey) && !empty($formSurvey))
                    <button type="submit" class="btn blue">Submit</button>
                    @endif
                </div>
                </form>
            </div>
        </div>
    </div>
    </div>