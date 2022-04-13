<?php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');
 ?>
@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-plugin')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/form-repeater.js') }}" type="text/javascript"></script>
    <script>
        var SweetAlert = function() {
            return {
                init: function() {
                    $(".sweetalert-delete").each(function() {
                        var token  	= "{{ csrf_token() }}";
                        let column 	= $(this).parents('tr');
                        let id     	= $(this).data('id');
                        let name    = $(this).data('name');
                        console.log(id);
                        $(this).click(function() {
                            swal({
                                    title: name+"\n\nAre you sure want to delete this announcement?",
                                    text: "Your will not be able to recover this data!",
                                    type: "warning",
                                    showCancelButton: true,
                                    confirmButtonClass: "btn-danger",
                                    confirmButtonText: "Yes, delete it!",
                                    closeOnConfirm: false
                                },
                                function(){
                                    $.ajax({
                                        type : "POST",
                                        url : "{{ url('employee/announcement/delete') }}/"+id,
                                        data : "_token="+token+"&id_employee_announcement="+id,
                                        success : function(result) {
                                            if (result.status == "success") {
                                                swal("Deleted!", "Announcement has been deleted.", "success")
                                                SweetAlert.init()
                                                location.href = "{{url('employee/announcement')}}";
                                            }
                                            else if(result.status == "fail"){
                                                swal("Error!", result.messages[0] ?? "Something went wrong. Failed to delete announcement.", "error")
                                            }
                                            else {
                                                swal("Error!", "Something went wrong. Failed to delete announcement.", "error")
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
            SweetAlert.init()
        });
    </script>
@endsection

@extends('layouts.main')

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

    <h1 class="page-title" style="margin-top: 0px;">
        {{$sub_title}}
    </h1>
    @include('layouts.notifications')

    <?php
    $date_start = '';
    $date_end = '';

    if(Session::has('filter-employee-announcement')){
        $search_param = Session::get('filter-employee-announcement');
        if(isset($search_param['date_start'])){
            $date_start = $search_param['date_start'];
        }

        if(isset($search_param['date_end'])){
            $date_end = $search_param['date_end'];
        }

        if(isset($search_param['rule'])){
            $rule = $search_param['rule'];
        }

        if(isset($search_param['conditions'])){
            $conditions = $search_param['conditions'];
        }
    }
    ?>

    <form role="form" class="form-horizontal" action="{{url()->current()}}?filter=1" method="POST">
        {{ csrf_field() }}
        @include('employee::announcement.filter')
    </form>

    <br>
    <div style="overflow-x: scroll; overflow-y: hidden;">
        <table class="table table-striped table-bordered table-hover">
            <thead>
            <tr>
                <th width="25%" class="text-center"> Subject </th>
                <th width="15%" class="text-center"> Date Start </th>
                <th width="15%" class="text-center"> Date End </th>
                <th width="35%" class="text-center"> Rule </th>
                <th width="10%" class="text-center"> Action </th>
            </tr>
            </thead>
            <tbody>
            @if(!empty($data))
                @foreach($data as $val)
                    <tr>
                        <td>{{ $val['content'] }}</td>
                        <td nowrap>{{date("d F Y H:i", strtotime($val['date_start']))}}</td>
                        <td nowrap>{{date("d F Y H:i", strtotime($val['date_end']))}}</td>
                        <td word-wrap>
                        	@if(isset($val['employee_announcement_rule_parents']))
								<div class="row static-info">
									<div class="col-md-4 name">Conditions</div>
									<div class="col-md-8 value">: </div>
								</div>
								@php $i=0; @endphp
								@foreach($val['employee_announcement_rule_parents'] as $ruleParent)
									<div class="portlet light bordered" style="margin-bottom:10px">
										@foreach($ruleParent['rules'] as $rule)
											<div class="row static-info">
												<div class="col-md-1 name"></div>
												<div class="col-md-10 value"><li>
												{{ $subjects[$rule['subject']] ?? ucwords(str_replace("_", " ", $rule['subject']))}} 

												@if(empty($rule['operator']) && $rule['subject'] != 'all_data') = 
												@else {{$rule['operator']}} 
												@endif

												@if($rule['subject'] == 'id_outlet')
													{{ $outlets[$rule['parameter']] }}
												@elseif($rule['subject'] == 'id_province')
													{{ $provinces[$rule['parameter']] ?? null }}
												@elseif($rule['subject'] == 'id_city')
													{{ $cities[$rule['parameter']] ?? null }}
												@elseif($rule['subject'] == 'id_role')
                                                    {{ $roles[$rule['parameter']] ?? null }}
												@else
													{{$rule['parameter']}}
												@endif
												</li></div>
											</div>
										@endforeach
										<div class="row static-info">
											<div class="col-md-11 value">
												@if($ruleParent['rule'] == 'and')
													All conditions must valid
												@else
													Atleast one condition is valid
												@endif
											</div>
										</div>
									</div>
									@if(count($val['employee_announcement_rule_parents']) > 1 && $i < count($val['employee_announcement_rule_parents']) - 1)
										<div class="row static-info" style="text-align:center">
											<div class="col-md-11 value">
												{{strtoupper($ruleParent['rule_next'])}}
											</div>
										</div>
									@endif
									@php $i++; @endphp
								@endforeach
							@endif
                        </td>
						<td nowrap>
							<a href="{{ url('employee/announcement/edit') }}/{{ $val['id_employee_announcement'] }}" class="btn btn-sm blue"><i class="fa fa-search"></i></a>
							<a class="btn btn-sm red delete" href="{{ url('employee/announcement/delete', $val['id_employee_announcement']) }}" data-toggle="confirmation" data-placement="top"><i class="fa fa-trash-o"></i></a>
						</td>
                    </tr>
                @endforeach
            @else
                <tr><td colspan="10" style="text-align: center">Data Not Available</td></tr>
            @endif
            </tbody>
        </table>
    </div>
    <br>
    @if ($dataPaginator)
        {{ $dataPaginator->links() }}
    @endif
@endsection