<?php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');
    
    
 ?>
 @extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.multidatespicker.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/icheck/skins/all.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .datepicker{
            padding: 6px 12px;
           }
        .sweet-alert .customInput{
            width: 10px;
           }
    </style>
@endsection

@section('page-plugin')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/js/bootstrap-select.js') }}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-bootstrap-select.min.js') }}"  type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/icheck/icheck.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js') }}" type="text/javascript"></script>
    <script>
        $('.select2').select2();
        function changeSelect(){
            setTimeout(function(){
                $(".select2").select2({
                    placeholder: "Select"
                });
            }, 100);
        }
        $('.datepicker').datepicker({
            'format' : 'dd MM yyyy',
            'todayHighlight' : true,
            'autoclose' : true
        });
        
    
        $(document).ready(function() {
            $('[data-switch=true]').bootstrapSwitch();
        });
    </script>

    <script type="text/javascript">

        function addConversion(unit,index){
            var new_index = index + 1;
            var select = `<option value="" selected disabled></option>`;
            @foreach ($units as $unit_select)
                if(unit != '{{ $unit_select['unit'] }}'){
                    select += `<option value="{{ $unit_select['unit'] }}" >{{ $unit_select['unit'] }}</option>`;
                }
            @endforeach
            var html = `
                <tr data-id="${unit}_${new_index}">
                    <td>
                        <input type="text" class="form-control unit" name="conversion[${unit}][${new_index}][unit]" required readonly value="${unit}">
                    </td>
                    <td>
                        <span>=</span>
                    </td>
                    <td>
                        <input type="text" class="form-control qty_conversion" name="conversion[${unit}][${new_index}][qty_conversion]" required>
                    </td>
                    <td>
                        <select class="form-control select2 unit_conversion" name="conversion[${unit}][${new_index}][unit_conversion]" required>
                        ${select}
                        </select>
                    </td>
                    <td>
                        <button type="button" onclick="deleteConversion('${unit}',${new_index})" class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i></button>
                    </td>
                </tr>
            `;

            var new_function = `addConversion(${unit},${new_index})`;
            $("#add"+unit).attr("onclick", "addConversion('"+unit+"',"+new_index+")");

            $('#unit'+unit+'-container tbody').append(html);
            $(`tr[data-id=${unit}_${new_index}] select`).select2({
                placeholder: "Select"
            });
        }

        function deleteConversion(unit,index){
            $(`#unit${unit}-container tr[data-id=${unit}_${index}]`).remove();
        }

        function addUnit(){
            swal({
                title: "Add New Unit For This Product",
                text: "Please input the new unit name to continue!",
                type: "input",
                showCancelButton: true,
                confirmButtonClass: "btn-primary",
                confirmButtonText: "OK",
                closeOnConfirm: false    
            },function(inputValue){
                if(inputValue==''){
                    swal("Error!", "You need to input the new unit name.")
                }else{
                    var data = {
                            '_token' : '{{csrf_token()}}',
                            'id_product_icount' : {{ $product['id_product_icount'] }},
                            'unit' : inputValue,
                    };
                    $.ajax({
                        type : "POST",
                        url : "{{ url()->current() }}/new-unit",
                        data : data,
                        success : function(response) {
                            if (response.status == 'success') {
                                swal("Success!", "A new unit has been created.", "success")
                                location.href = "{{ url()->current() }}";
                            }
                            else if(response.status == "fail"){
                                swal("Error!", "Failed to created new unit.")
                            }
                            else {
                                swal("Error!", "Something went wrong. Failed to created new unit .")
                            }
                        }
                    });
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
                <span class="caption-subject font-dark sbold uppercase font-blue">{{ $sub_title }}</span>
            </div>
        </div>
        <div class="portlet-body">
            <div class="row">
                <form class="form-horizontal" role="form" action="{{ url()->current() }}" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id_product_icount" value="{{ $product['id_product_icount'] }}">
                    <div class="col-md-3 col-sm-3 col-xs-3">
                        <ul class="nav nav-tabs tabs-left">
                            @if (!empty($units))
                                @foreach ($units as $key => $unit)
                                <li class="{{ $key == 0 ? 'active' : '' }}">
                                    <a href="#tab_{{ $key }}" data-toggle="tab"> {{ $unit['unit'] }} </a>
                                </li>
                                @endforeach
                            @else
                                @php $key = 0; @endphp
                                @if (isset($product['unit1']))
                                    <li class="{{ $key == 0 ? 'active' : '' }}">
                                        <a href="#tab_{{ $key }}" data-toggle="tab"> {{ $product['unit1'] }} </a>
                                    </li>
                                @php $key++; @endphp
                                @endif
                                @if (isset($product['unit2']))
                                    <li class="{{ $key == 0 ? 'active' : '' }}">
                                        <a href="#tab_{{ $key }}" data-toggle="tab"> {{ $product['unit2'] }} </a>
                                    </li>
                                @php $key++; @endphp
                                @endif
                                @if (isset($product['unit3']))
                                    <li class="{{ $key == 0 ? 'active' : '' }}">
                                        <a href="#tab_{{ $key }}" data-toggle="tab"> {{ $product['unit3'] }} </a>
                                    </li>
                                @php $key++; @endphp
                                @endif
                            @endif  
                        </ul>
                        <div class="col-md-12" style="padding-left: 2px; margin-bottom: 10px; !important">
                            <a onclick="addUnit()" class="btn btn-primary">&nbsp;<i class="fa fa-plus-circle"></i> Add Unit </a>
                        </div>
                    </div>
				    <div class="col-md-9 col-sm-9 col-xs-9">
                        <div class="tab-content">
                            @if (!empty($units))
                                @foreach ($units as $key => $unit)
                                <div class="tab-pane {{ $key == 0 ? 'active' : '' }}" id="tab_{{ $key }}">
                                    <div class="col-md-12">
                                        <table id="unit{{ $unit['unit'] }}-container" class="table">
                                            <thead>
                                                <tr>
                                                    <th>Unit</th>
                                                    <th></th>
                                                    <th>Quantity</th>
                                                    <th width="160px">Unit Conversion</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <input type="hidden" name="conversion[{{ $unit['unit'] }}][id_product_icount]" value="{{ $product['id_product_icount'] }}">
                                                @if(isset($unit['conversion']) && !empty($unit['conversion']))
                                                    @foreach ($unit['conversion'] as $index_item => $item)
                                                    <tr data-id="{{ $unit['unit'] }}_{{ $index_item }}">
                                                        <td>
                                                            <input type="text" class="form-control unit" name="conversion[{{ $unit['unit'] }}][{{ $index_item }}][unit]" required readonly value="{{  $unit['unit'] }}">
                                                        </td>
                                                        <td>
                                                            <span>=</span>
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control qty_conversion" name="conversion[{{  $unit['unit'] }}][{{ $index_item }}][qty_conversion]" required value="{{ $item['qty_conversion'] }}">
                                                        </td>
                                                        <td>
                                                            <select class="form-control select2 unit_conversion" name="conversion[{{  $unit['unit'] }}][{{ $index_item }}][unit_conversion]" required>
                                                                <option value="" selected disabled></option>
                                                                @foreach ($units as $unit_select)
                                                                    @if ($unit_select['unit'] != $unit['unit'])
                                                                    <option value="{{ $unit_select['unit'] }}" @if($item['unit_conversion'] == $unit_select['unit']) selected @endif >{{ $unit_select['unit'] }}</option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <button type="button" disabled class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i></button>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                @else
                                                @php $index_item = -1; @endphp
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-12" style="padding-left: 22px; margin-bottom: 10px; !important">
                                        <a id="add{{ $unit['unit'] }}" class="btn btn-primary" onclick="addConversion('{{ $unit['unit'] }}',{{ $index_item }})">&nbsp;<i class="fa fa-plus-circle"></i> Add Conversion </a>
                                    </div>
                                </div>
                                @endforeach
                            @else
                                @php $key = 0; @endphp
                                @if (isset($product['unit1']))
                                <div class="tab-pane {{ $key == 0 ? 'active' : '' }}" id="tab_{{ $key }}">
                                    <div class="col-md-12">
                                        <table id="unit{{ $product['unit1'] }}-container" class="table">
                                            <thead>
                                                <tr>
                                                    <th>Unit</th>
                                                    <th></th>
                                                    <th>Quantity</th>
                                                    <th>Unit Conversion</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-12" style="padding-left: 22px; margin-bottom: 10px; !important">
                                        <a id="add{{ $product['unit1'] }}" class="btn btn-primary" onclick="addConversion('{{ $product['unit1'] }}',0)">&nbsp;<i class="fa fa-plus-circle"></i> Add Conversion </a>
                                    </div>
                                </div>
                                @php $key++; @endphp
                                @endif
                                @if (isset($product['unit2']))
                                <div class="tab-pane {{ $key == 0 ? 'active' : '' }}" id="tab_{{ $key }}">
                                    <div class="col-md-12">
                                        <table id="unit{{ $product['unit2'] }}-container" class="table">
                                            <thead>
                                                <tr>
                                                    <th>Unit</th>
                                                    <th></th>
                                                    <th>Quantity</th>
                                                    <th>Unit Conversion</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-12" style="padding-left: 22px; margin-bottom: 10px; !important">
                                        <a id="add{{ $product['unit2'] }}" class="btn btn-primary" onclick="addConversion('{{ $product['unit2'] }}',0)">&nbsp;<i class="fa fa-plus-circle"></i> Add Conversion </a>
                                    </div>
                                </div>
                                @php $key++; @endphp
                                @endif
                                @if (isset($product['unit3']))
                                <div class="tab-pane {{ $key == 0 ? 'active' : '' }}" id="tab_{{ $key }}">
                                    <div class="col-md-12">
                                        <table id="unit{{ $product['unit3'] }}-container" class="table">
                                            <thead>
                                                <tr>
                                                    <th>Unit</th>
                                                    <th></th>
                                                    <th>Quantity</th>
                                                    <th>Unit Conversion</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-12" style="padding-left: 22px; margin-bottom: 10px; !important">
                                        <a id="add{{ $product['unit3'] }}" class="btn btn-primary" onclick="addConversion('{{ $product['unit3'] }}',0)">&nbsp;<i class="fa fa-plus-circle"></i> Add Conversion </a>
                                    </div>
                                </div>
                                @php $key++; @endphp
                                @endif
                            @endif  
                        </div>
                        <div class="form-actions">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="text-center">
                                    <button type="submit" class="btn blue">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    


@endsection