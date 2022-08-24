
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
    </div>
@include('layouts.notifications')
<div class="row" style="margin-top:20px">
	<div class="col-md-12">
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption font-blue ">
					<i class="icon-settings font-blue "></i>
					<span class="caption-subject bold uppercase">Update Commission Hair Stylist Group</span>
				</div>
			</div>
			<div class="portlet-body form">
				<form role="form" class="form-horizontal" action="{{url('recruitment/hair-stylist/group/commission/update')}}" method="POST" enctype="multipart/form-data">
					{{ csrf_field() }}
					<div class="form-body">
						<input type="hidden" name="id_hairstylist_group" value="{{$result['id_hairstylist_group']}}">
                        <div class="form-group">
                            <label for="example-search-input" class="control-label col-md-4">Group</label>
                            <div class="col-md-5">
                                <input class="form-control" disabled type="text"value="{{$result['hair_stylist_group_name']}}" placeholder="Enter Commission"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="example-search-input" class="control-label col-md-4">Product</label>
                            <div class="col-md-5">
                                <input class="form-control" disabled type="text" id="id_product" name="id_product" value="{{$result['product_name']}}" placeholder="Enter Commission"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="example-search-input" class="control-label col-md-4">Percent</label>
                            <div class="col-md-5">
                                <input type="checkbox" class="make-switch brand_visibility" onchange="myFunction()"  data-size="small" data-on-color="info" data-on-text="Percent" data-off-color="default" name='percent' data-off-text="Nominal" {{$result['percent']?'checked':''}}>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="example-search-input" class="control-label col-md-4">Type</label>
                            <div class="col-md-5">
                                <select required name="type" id="type" class="select2" onchange="changeType(this.value)" >
                                    <option value=""></option>
                                    <option value="Static" @if ($result['dynamic']==0) selected @endif>Static</option>
                                    <option value="Dynamic" @if ($result['dynamic']==1) selected @endif>Dynamic</option>
                                </select>
                            </div>
                        </div>
                        <div id='id_commission' @if ($result['dynamic']==1) hidden @endif>
                            <div class="form-group">
                                <label for="example-search-input" class="control-label col-md-4">Commission<span class="required" aria-required="true">*</span></label>
                                <div class="col-md-5">
                                    <input class="form-control" @if($result['dynamic']==0) required @else disabled @endif type="number" id="commission_percent" value="{{$result['commission_percent']??0}}" name="commission_percent" placeholder="Enter Commission" @if($result['percent']==1) min="1" max="100" @endif/>
                                </div>
                            </div>
                        </div>
                        <div id="dynamic_commission" @if ($result['dynamic']==0) hidden @endif>
                            <div class="form-group">
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <table id="dynamic-rule" class="table text-center">
                                        <thead>
                                            <tr>
                                                <th>Operator</th>
                                                <th>Quantity</th>
                                                <th>Commission</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (isset($result['dynamic_rule']) && !empty($result['dynamic_rule']))
                                                @foreach($result['dynamic_rule'] ?? [] as $key => $dynamic)
                                                    <tr data-id="{{$key}}">
                                                        <td>
                                                            <select class="select2 form-control operator" name="dynamic_rule[{{$key}}][operator]" required>
                                                                <option value="=" @if($dynamic['operator'] == '=') selected @endif>=</option>
                                                                <option value="<" @if($dynamic['operator'] == '<') selected @endif><</option>
                                                                <option value="<=" @if($dynamic['operator'] == '<=') selected @endif><=</option>
                                                                <option value=">" @if($dynamic['operator'] == '>') selected @endif>></option>
                                                                <option value=">=" @if($dynamic['operator'] == '>=') selected @endif>>=</option>
                                                                <option value="!=" @if($dynamic['operator'] == '!=') selected @endif>!=</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="number" class="form-control qty" name="dynamic_rule[{{$key}}][qty]" value="{{$dynamic['qty']}}" required>
                                                        </td>
                                                        <td>
                                                            <input type="number" class="form-control value" name="dynamic_rule[{{$key}}][value]" value="{{$dynamic['value']}}" required>
                                                        </td>
                                                        <td>
                                                            <button type="button" onclick="deleteRule({{$key}})" data-toggle="confirmation" class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i></button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr data-id="0">
                                                    <td>
                                                        <select class="select2 form-control operator" name="dynamic_rule[0][operator]" @if($result['dynamic']==0) disabled @else required @endif>
                                                            <option value="" selected disabled></option>
                                                            <option value="=">=</option>
                                                            <option value="<"><</option>
                                                            <option value="<="><=</option>
                                                            <option value=">">></option>
                                                            <option value=">=">>=</option>
                                                            <option value="!=">!=</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control qty" name="dynamic_rule[0][qty]" @if($result['dynamic']==0) disabled @else required @endif>
                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control value" name="dynamic_rule[0][value]" @if($result['dynamic']==0) disabled @else required @endif>
                                                    </td>
                                                    <td>
                                                        <button type="button" onclick="deleteRule(0)" data-toggle="confirmation" class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i></button>
                                                    </td>
                                                </tr>
                                                @endif
                                        </tbody>
                                    </table>
                                    <div>
                                        <button class="btn green" type="button" onclick="addRule()">Add Rule</button>
                                    </div>
                                </div>
                                <div class="col-md-4"></div>
                            </div>
                        </div>
						<input type="hidden" name="id_product" value="{{$result['id_product']}}">
						<input type="hidden" name="id_hairstylist_group_commission" value="{{$result['id_hairstylist_group_commission']}}">
					</div>
                                        
					<div class="form-actions" style="text-align:center;">
						{{ csrf_field() }}
						<button type="submit" class="btn blue" id="checkBtn">Update</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script type="text/javascript">

        @if(!is_array($result['dynamic_rule']) || count($result['dynamic_rule']) <= 0)
            var noRule = 1;
                    @else
            var noRule = {{count($result['dynamic_rule'])}};
        @endif    
        
        var dynamic = {{ $result['dynamic'] }};
        
        function addRule(){
            var id_percent =  $("input[name='percent']:checked").val();
            var percent = ``;
            if(id_percent == 'on'){
                percent = `max="100" min="1"`;
            }
            const template = `
                <tr data-id="${noRule}">
                    <td>
                        <select class="select2 form-control operator" name="dynamic_rule[${noRule}][operator]" required>
                            <option value="" selected disabled></option>
                            <option value="=">=</option>
                            <option value="<"><</option>
                            <option value="<="><=</option>
                            <option value=">">></option>
                            <option value=">=">>=</option>
                            <option value="!=">!=</option>
                        </select>
                    </td>
                    <td>
                        <input type="number" class="form-control qty" name="dynamic_rule[${noRule}][qty]" required>
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

        function changeType(val) {
            var id_percent =  $("input[name='percent']:checked").val();

            if(val == 'Dynamic'){
                $('#id_commission').hide();
                $('#dynamic_commission').show();
                $('#commission_percent').prop('required',false);
                $('#commission_percent').prop('disabled',true);

                if(id_percent == 'on'){
                    for (let i = 0; i < noRule; i++) {
                        $(`tr[data-id=${i}] select.operator`).prop('required',true);
                        $(`tr[data-id=${i}] select.operator`).prop('disabled',false);
                        $(`tr[data-id=${i}] input.qty`).prop('required',true);
                        $(`tr[data-id=${i}] input.qty`).prop('disabled',false);
                        $(`tr[data-id=${i}] input.value`).prop('required',true);
                        $(`tr[data-id=${i}] input.value`).prop('disabled',false);
                        $(`tr[data-id=${i}] input.value`).attr({"max":100,"min":1})
                    }
                }else{
                    for (let i = 0; i < noRule; i++) {
                        $(`tr[data-id=${i}] select.operator`).prop('required',true);
                        $(`tr[data-id=${i}] select.operator`).prop('disabled',false);
                        $(`tr[data-id=${i}] input.qty`).prop('required',true);
                        $(`tr[data-id=${i}] input.qty`).prop('disabled',false);
                        $(`tr[data-id=${i}] input.value`).prop('required',true);
                        $(`tr[data-id=${i}] input.value`).prop('disabled',false);
                        $(`tr[data-id=${i}] input.value`).removeAttr("max");
                        $(`tr[data-id=${i}] input.value`).removeAttr("min");
                    }
                }
            }else{
                $('#commission_percent').prop('required',true);
                $('#commission_percent').prop('disabled',false);
                $('#id_commission').show();
                $('#dynamic_commission').hide();

                if(id_percent == 'on'){
                    $('#commission').attr({"max":100,"min":1})
                }else{
                    $('#commission').removeAttr("max");
                    $('#commission').removeAttr("min");
                }

                for (let i = 0; i < noRule; i++) {
                    $(`tr[data-id=${i}] select.operator`).prop('required',false);
                    $(`tr[data-id=${i}] select.operator`).prop('disabled',true);
                    $(`tr[data-id=${i}] input.qty`).prop('required',false);
                    $(`tr[data-id=${i}] input.qty`).prop('disabled',true);
                    $(`tr[data-id=${i}] input.value`).prop('required',false);
                    $(`tr[data-id=${i}] input.value`).prop('disabled',true);
                }
            }
        }

        function deleteRule(id) {
            $(`#dynamic-rule tr[data-id=${id}]`).remove();
        }

        function myFunction() {
            var id_percent =  $("input[name='percent']:checked").val();
            var type = $('select[name=type] option:selected').val()

            if(type == 'Dynamic'){
                if(id_percent == 'on'){
                    for (let i = 0; i < noRule; i++) {
                        $(`tr[data-id=${i}] input.value`).attr({"max":100,"min":1})
                    }
                }else{
                    for (let i = 0; i < noRule; i++) {
                        $(`tr[data-id=${i}] input.value`).removeAttr("max");
                        $(`tr[data-id=${i}] input.value`).removeAttr("min");
                    }
                }
            }else{
                if(id_percent == 'on'){
                var html='<div class="form-group"><label for="example-search-input" class="control-label col-md-4">Commission<span class="required" aria-required="true">*</span>\
                        </label>\
                        <div class="col-md-5">\
                        <input class="form-control" required type="number" id="commission_percent" name="commission_percent" min="1" max="99" placeholder="Enter Commission Percent"/></div></div>';
                }else{
                    var html='<div class="form-group"><label for="example-search-input" class="control-label col-md-4">Commission<span class="required" aria-required="true">*</span>\
                            </label>\
                            <div class="col-md-5">\
                            <input class="form-control" required type="number" id="commission_percent" name="commission_percent"  placeholder="Enter Commission Nominal"/>\
                            </div></div>'; 
                }
            }

            
          $('#id_commission').html(html);
        }

        $(document).ready(function () {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
            });
        </script>
@endsection 
