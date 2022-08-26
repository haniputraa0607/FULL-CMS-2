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
    <style>
        .datepicker{
            padding: 6px 12px;
           }
    </style>
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
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js')}}"></script>
	<script type="text/javascript">
        $('.datepicker').datepicker({
            'format' : 'dd MM yyyy',
            'todayHighlight' : true,
            'autoclose' : true
        });

        var noRule = 0;
        var static = false;

        function addRule(){
            var id_percent =  $("input[name='percent']:checked").val();

            var percent = ``;
            if(id_percent == 'on'){
                percent = `max="100" min="1"`;
            }
            
            if(noRule==0){
                var table = `
                    <thead>
                        <tr>
                            <th class="text-center col-md-2">Range</th>
                            <th class="text-center col-md-2">Commision</th>
                            <th class="text-center col-md-1"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (isset($result['dynamic_rule']) && !empty($result['dynamic_rule']))
                            @foreach($result['dynamic_rule'] ?? [] as $key => $dynamic)
                                <tr data-id="{{$key}}">
                                    <td>
                                        <input type="number" class="form-control qty" name="dynamic_rule[{{$key}}][qty]" value="{{$dynamic['qty']}}" min="1" required>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control value" name="dynamic_rule[{{$key}}][value]" value="{{$dynamic['value']}}" min="1" @if ($result['value']==1) max="100" @endif required>
                                    </td>
                                    <td>
                                        <button type="button" onclick="deleteRule({{$key}})" data-toggle="confirmation" class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                `;
                $('#dynamic-rule').append(table);
                noRule = {{ count($result['dynamic_rule']??[]) }}

            }

            const template = `
                <tr data-id="${noRule}">
                    <td>
                        <input type="number" class="form-control qty" name="dynamic_rule[${noRule}][qty]" min="1" required>
                    </td>
                    <td>
                        <input type="number" class="form-control value" name="dynamic_rule[${noRule}][value]" ${percent} required>
                    </td>
                    <td>
                        <button type="button" onclick="deleteRule(${noRule})" data-toggle="confirmation" class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i></button>
                    </td>
                </tr>
            `;
            $('#dynamic-rule tbody').append(template);
            $(`tr[data-id=${noRule}] select`).select2();
            noRule++;
        }

        function deleteRule(id) {
            $(`#dynamic-rule tr[data-id=${id}]`).remove();
        }

        function changeType(val){
            var id_percent =  $("input[name='percent']:checked").val();
    
            if(val == 'Dynamic'){
                $('#id_commission').hide();
                $('#dynamic_commission').show();
                $('#commission_percent').prop('required',false);
                $('#commission_percent').prop('disabled',true);
    
                if(id_percent == 'on'){
                    for (let i = 0; i < noRule; i++) {
                        $(`tr[data-id=${i}] input.qty`).prop('required',true);
                        $(`tr[data-id=${i}] input.qty`).prop('disabled',false);
                        $(`tr[data-id=${i}] input.value`).prop('required',true);
                        $(`tr[data-id=${i}] input.value`).prop('disabled',false);
                        $(`tr[data-id=${i}] input.value`).attr({"max":100,"min":1})
                    }
                }else{
                    for (let i = 0; i < noRule; i++) {
                        $(`tr[data-id=${i}] input.qty`).prop('required',true);
                        $(`tr[data-id=${i}] input.qty`).prop('disabled',false);
                        $(`tr[data-id=${i}] input.value`).prop('required',true);
                        $(`tr[data-id=${i}] input.value`).prop('disabled',false);
                        $(`tr[data-id=${i}] input.value`).removeAttr("max");
                    }
                }
    
            }else{
                $('#id_commission').show();
                $('#dynamic_commission').hide();
                $('#commission_percent').prop('required',true);
                $('#commission_percent').prop('disabled',false);

                if(id_percent == 'on'){
                    var html='<div class="form-group"><label for="example-search-input" class="control-label col-md-4">Commission<span class="required" aria-required="true">*</span>\
                            <i class="fa fa-question-circle tooltips" data-original-title="komisi product" data-container="body"></i></label>\
                            <div class="col-md-3">\
                            <input class="form-control" required type="number" id="commission_percent" name="commission"   min="1" max="100" placeholder="Enter Commission Percent"/>\
                            </div></div>';
                }else{
                    var html='<div class="form-group"><label for="example-search-input" class="control-label col-md-4">Commission<span class="required" aria-required="true">*</span>\
                            <i class="fa fa-question-circle tooltips" data-original-title="komisi product" data-container="body"></i></label>\
                            <div class="col-md-3">\
                            <input class="form-control" required type="number" id="commission_percent" name="commission"  placeholder="Enter Commission Nominal"/>\
                            </div></div>'; 
                }

                for (let i = 0; i < noRule; i++) {
                        $(`tr[data-id=${i}] input.qty`).prop('required',false);
                        $(`tr[data-id=${i}] input.qty`).prop('disabled',true);
                        $(`tr[data-id=${i}] input.value`).prop('required',false);
                        $(`tr[data-id=${i}] input.value`).prop('disabled',true);
                }
                $('#id_commission').html(html);
            }
        }
    
        function myFunction() {
            var id_percent = $("input[name='percent']:checked").val();
            var type = $('select[name=type] option:selected').val();

            if(type == 'Dynamic'){
                if(id_percent == 'on'){
                    for (let i = 0; i < noRule; i++) {
                        $(`tr[data-id=${i}] input.value`).attr({"max":100,"min":1})
                    }
                }else{ 
                    for (let i = 0; i < noRule; i++) {
                        $(`tr[data-id=${i}] input.value`).removeAttr("max");
                    }
                }
            }else{
                if(id_percent == 'on'){
                    $('#commission_percent').attr({"max":100,"min":1});
                }else{
                    $('#commission_percent').removeAttr("max");
                }
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
					<span class="caption-subject bold uppercase">This menu is used to set a global commission product</span>
				</div>
			</div>
			<div class="portlet-body form">
				<form role="form" class="form-horizontal" action="{{url('setting/setting-global-commission')}}" method="POST" enctype="multipart/form-data">
					{{ csrf_field() }}
					<div class="form-body">
                        <div class="form-group">
                            <label for="example-search-input" class="control-label col-md-4">Percent</label>
                            <div class="col-md-5">
                                <input type="checkbox" class="make-switch" data-size="small" onchange="myFunction()" data-on-color="success" data-on-text="Percent" name="percent" data-off-color="default" data-off-text="Nominal" @if($result['value']??0==1) checked @endif id="percent">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="example-search-input" class="control-label col-md-4">Type</label>
                            <div class="col-md-3">
                                <select required name="type" id="type" class="select2" onchange="changeType(this.value)">
                                    <option value="" selected disabled></option>
                                    <option value="Static" @if (isset($result['dynamic'])) @if($result['dynamic']==0) selected @endif @endif>Static</option>
                                    <option value="Dynamic" @if (isset($result['dynamic'])) @if($result['dynamic']==1) selected @endif @endif>Dynamic</option>
                                </select>
                            </div>
                        </div>
                       
                        <div id="id_commission" @if (isset($result['dynamic'])) @if($result['dynamic']==1) hidden @endif @endif>
                            <div class="form-group">
                                 <label for="example-search-input" class="control-label col-md-4">Commission<span class="required" aria-required="true">*</span>
                                     <i class="fa fa-question-circle tooltips" data-original-title="Percent minimal 1% maksimal 100%" data-container="body"></i></label>
                                 <div class="col-md-3">
                                     <input class="form-control" @if (isset($result['dynamic'])) @if($result['dynamic']==0) required @else disabled @endif @endif type="number" id="commission_percent" value="{{$result['value_text']??0}}" min="1" @if($result['value']??'' == 1) max="100" @endif name="commission" placeholder="Enter Commission"/>
                                </div>
                            </div>
                        </div>
                        <div id="dynamic_commission" @if (isset($result['dynamic'])) @if($result['dynamic']==0) hidden @endif @endif>
                            <div class="form-group">
                                <div class="col-md-4"></div>
                                <div class="col-md-5">
                                        @if (isset($result['dynamic_rule_list']) && !empty($result['dynamic_rule_list']))
                                            <table class="table table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">Range</th>
                                                        <th class="text-center">Commision</th>  
                                                        <th class="text-center">Delete</th>  
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($result['dynamic_rule_list'] ?? [] as $key => $dynamic)
                                                        <tr>
                                                            <td class="text-center">{{ $dynamic['qty'] }}</td>
                                                            <td class="text-center">{{ $dynamic['value'] }}</td>
                                                            <td class="text-center">
                                                                @if (isset($dynamic['id_global_commission_product_dynamics']))
                                                                    <a class="btn btn-sm red btn-primary" href="{{url()->current().'/delete-commission/'.$dynamic['id_global_commission_product_dynamics']}}"><i class="fa fa-trash-o"></i> Delete</a>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        @endif
                                    <div>
                                        <button class="btn green" type="button" onclick="addRule()">Add Rule</button>
                                    </div>
                                    <table id="dynamic-rule" class="table text-center">
                                    </table>
                                </div>
                                <div class="col-md-3"></div>
                            </div>
                        </div>
					</div>
                                        
					<div class="form-actions" >
						{{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-offset-4 col-md-9">
                                <button type="submit" class="btn blue" id="checkBtn">Update</button>
                                <a  @if(isset($result['status'])&&($result['status']=='start' || $result['status']=='process')) @else href="#modal_commission" data-toggle="modal" @endif class="btn btn-success" @if(isset($result['status'])&&($result['status']=='start' || $result['status']=='process')) disabled @endif>Refresh Commission @if(isset($result['status'])&&($result['status']=='start' || $result['status']=='process')) <i class="fa fa-question-circle tooltips" data-original-title="Tidak bisa melakukan proses refresh komisi karena ada proses refresh komisi yang sedang berjalan" data-container="body"></i> @endif </a>
                            </div>
                        </div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="modal fade bd-example-modal-sm" id="modal_commission" role="dialog" aria-labelledby="exportModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Refresh Commission Transaction</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="padding: 15px !important">
                <div class="m-heading-1 border-green m-bordered">
                    <p>This menu is used to refresh calculation of transactions in the selected date range.</p>
                </div>
                <form role="form" action="{{ url('setting/setting-global-commission/refresh') }}" method="post" enctype="multipart/form-data">
                    <div class="form-body">
                        <div class="row" style="margin-bottom:10px">
                            <label class="col-md-4 text-right" style="padding-top:5px">From Date</label>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <input type="text" id="start_date" class="datepicker form-control" name="start_date" required>
                                    <span class="input-group-btn">
                                        <button class="btn default" type="button">
                                            <i class="fa fa-calendar"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin-bottom:10px">
                            <label class="col-md-4 text-right" style="padding-top:5px">To Date</label>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <input type="text" id="start_date" class="datepicker form-control" name="end_date" required>
                                    <span class="input-group-btn">
                                        <button class="btn default" type="button">
                                            <i class="fa fa-calendar"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                {{ csrf_field() }}
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>

        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

@endsection

