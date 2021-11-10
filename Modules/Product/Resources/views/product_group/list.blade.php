<?php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');
 ?>
@extends('layouts.main')

@section('page-style')
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" /> 
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $('#sample_1').dataTable({
                language: {
                    aria: {
                        sortAscending: ": activate to sort column ascending",
                        sortDescending: ": activate to sort column descending"
                    },
                    emptyTable: "No data available in table",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    infoEmpty: "No entries found",
                    infoFiltered: "(filtered1 from _MAX_ total entries)",
                    lengthMenu: "_MENU_ entries",
                    search: "Search:",
                    zeroRecords: "No matching records found"
                },
                buttons: [],
                responsive: {
                    details: {
                        type: "column",
                        target: "tr"
                    }
                },
                order: [],
                lengthMenu: [
                    [5, 10, 15, 20, -1],
                    [5, 10, 15, 20, "All"]
                ],
                pageLength: 10,
                dom: "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
                "fnDrawCallback": function( oSettings ) {
            		$("#sample_1 .delete").confirmation({
					    singleton: true,
					    onConfirm: function () {
	                		let token  = "{{ csrf_token() }}";
	                		let column = $(this).parents('tr');
	                		let id     = $(this).data('id');

				            $.ajax({
				                type : "POST",
				                url : "{{ url('product/product-group/delete') }}",
				                data : "_token="+token+"&id_product_group="+id,
				                success : function(result) {
				                    if (result.status == "success") {
				                        $('#sample_1').DataTable().row(column).remove().draw();
				                        toastr.info("Product Group has been deleted.");
				                    }
				                    else if(result.status == "fail"){
				                        toastr.warning("Failed to delete product group.Product Group has been used.");
				                    }
				                    else {
				                        toastr.warning("Something went wrong. Failed to delete product group.");
				                    }
				                }
				            });
					    }
					})
                }
            });

        $('#list-form').on('click', '.update-button', function() {
        	let id = $(this).data('id') ?? null;
        	let code = $(this).data('code') ?? null;
        	let name = $(this).data('name') ?? null;
        	let photo = $(this).data('photo') ?? null;
        	let desc = $(this).data('desc') ?? null;
        	$('#update [name="id_product_group"]').val(id);
        	$('#update [name="product_group_code"]').val(code);
        	$('#update [name="product_group_name"]').val(name);
        	$('#update .imageproduct').children('img').attr('src', photo);
        	$('#update [name="photo"]').attr("src",photo);
        	$('#update [name="product_group_description"]').val(desc);
        	console.log(id, code, name, photo, desc);
        })

        $('#create, #update').on('hide.bs.modal', function () {
        	$('[name="product_group_code"], [name="product_group_name"]').prop('required', false);
        })

        $('#create, #update').on('show.bs.modal', function () {
        	$('[name="product_group_code"], [name="product_group_name"]').prop('required', true);
        })

        $(".file").change(function(e) {
            let widthImg  = 300;
            let heightImg = 300;

            let _URL = window.URL || window.webkitURL;
            let image, file;

            if ((file = this.files[0])) {
                image = new Image();

                image.onload = function() {
                    if (this.width == widthImg && this.height == heightImg) {
                        // image.src = _URL.createObjectURL(file);
                    //    $('#formimage').submit()
                    }
                    else {
                        toastr.warning("Please check dimension of your photo.");
                        $('.imageproduct').children('img').attr('src', 'https://www.placehold.it/300x300/EFEFEF/AAAAAA&amp;text=no+image');
                        $('.fieldphoto').val("");

                    }
                };

                image.src = _URL.createObjectURL(file);
            }

        });
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
                <span class="caption-subject font-blue sbold uppercase">Product Group List</span>
            </div>
            <div class="actions">
            	@if(MyHelper::hasAccess([384], $grantedFeature))
                	<a class="btn green btn-md" data-toggle="modal" href="#create"> <i class="fa fa-plus"></i> Add Product Group</a>
            	@endif
            </div>
        </div>
        <div class="portlet-body form" id="list-form">
            <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_1">
                <thead>
                    <tr>
                        <th style="width:20%;"> Code </th>
                        <th style="width:20%;"> Name </th>
                        <th style="width:20%;"> Photo </th>
                        <th style="width:20%;"> description </th>
                        <th style="width:20%;"> Action </th>
                    </tr>
                </thead>
                <tbody>
                    @if (!empty($product_group))
                        @foreach($product_group as $value)
                            <tr style="height: 45px;">
                                <td>{{ $value['product_group_code'] }}</td>
                                <td>{{ $value['product_group_name'] }}</td>
                                <td class="text-center"><img src="{{ $value['url_photo'] }}" alt="" style="max-width: 100px"></td>
                                <td>{{ $value['product_group_description'] }}</td>
                                <td style="width: 90px;" class="text-center">
    								<a class="btn green btn-sm update-button" data-toggle="modal" href="#update" 
    									data-id="{{ $value['id_product_group'] }}" 
    									data-name="{{ $value['product_group_name'] }}" 
    									data-code="{{ $value['product_group_code'] }}" 
    									data-photo="{{ $value['url_photo'] }}" 
    									data-desc="{{ $value['product_group_description'] }}"
									> <i class="fa fa-pencil"></i></a> 
                                	@if(MyHelper::hasAccess([386], $grantedFeature))
                                    	<a class="btn btn-sm blue" href="{{ url('product/product-group/detail/'.$value['id_product_group']) }}"><i class="fa fa-link"></i></a>
                                	@endif
            						@if(MyHelper::hasAccess([388], $grantedFeature))
                                    	<a class="btn btn-sm red delete" data-id="{{ $value['id_product_group'] }}"><i class="fa fa-trash-o"></i></a>
                                	@endif
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal fade" id="create" tabindex="-1" role="basic" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <form class="form-horizontal" role="form" action="{{ url('product/product-group/create') }}" method="post" enctype="multipart/form-data">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title">Add Product Group</h4>
                    </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label class="col-md-3 control-label">Code</label>
                                <div class="col-md-7">
                                    <div class="input-icon right">
                                        <input type="text" placeholder="Product Group Code" class="form-control" name="product_group_code" value="" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Name</label>
                                <div class="col-md-7">
                                    <div class="input-icon right">
                                        <input type="text" placeholder="Product Group Name" class="form-control" name="product_group_name" value="" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                            	<label class="col-md-3 control-label">
                            		Photo <span class="required" aria-required="true"><br>(300*300) </span>
                            	</label>
                            	<div class="col-md-8">
                            		<div class="fileinput fileinput-new" data-provides="fileinput">
                            			<div class="fileinput-new thumbnail" style="width: 200px; height: 200px;">
                            				<img src="" alt="">
                            			</div>
                            			<div class="fileinput-preview fileinput-exists thumbnail imageproduct" style="max-width: 200px; max-height: 200px;"></div>
                            			<div>
                            				<span class="btn default btn-file">
                            					<span class="fileinput-new"> Select image </span>
                            					<span class="fileinput-exists"> Change </span>
                            					<input type="file" class="file fieldphoto" accept="image/*" name="photo">
                            				</span>

                            				<a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                            			</div>
                            		</div>
                            	</div>
                            </div>
                            <div class="form-group">
                            	<label for="multiple" class="control-label col-md-3">Description
                            	</label>
                            	<div class="col-md-8">
                            		<div class="input-icon right">
                            			<textarea name="product_group_description" class="form-control"></textarea>
                            		</div>
                            	</div>
                            </div>
                        </div>
                    <div class="modal-footer">
                        {{ csrf_field() }}
                        <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn green">Submit</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <div class="modal fade" id="update" tabindex="-1" role="basic" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <form class="form-horizontal" role="form" action="{{ url('product/product-group/update') }}" method="post" enctype="multipart/form-data">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title">Edit Product Group</h4>
                    </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label class="col-md-3 control-label">Code</label>
                                <div class="col-md-7">
                                    <div class="input-icon right">
                                        <input type="text" placeholder="Product Group Code" class="form-control" name="product_group_code" value="" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Name</label>
                                <div class="col-md-7">
                                    <div class="input-icon right">
                                        <input type="text" placeholder="Product Group Name" class="form-control" name="product_group_name" value="" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                            	<label class="col-md-3 control-label">
                            		Photo <span class="required" aria-required="true"><br>(300*300) </span>
                            	</label>
                            	<div class="col-md-8">
                            		<div class="fileinput fileinput-new" data-provides="fileinput">
                            			<div class="fileinput-new thumbnail" style="width: 200px; height: 200px;">
                            				<img src="" alt="">
                            			</div>
                            			<div class="fileinput-preview fileinput-exists thumbnail imageproduct" style="max-width: 200px; max-height: 200px;"></div>
                            			<div>
                            				<span class="btn default btn-file">
                            					<span class="fileinput-new"> Select image </span>
                            					<span class="fileinput-exists"> Change </span>
                            					<input type="file" class="file fieldphoto" accept="image/*" name="photo">
                            				</span>

                            				<a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                            			</div>
                            		</div>
                            	</div>
                            </div>
                            <div class="form-group">
                            	<label for="multiple" class="control-label col-md-3">Description
                            	</label>
                            	<div class="col-md-8">
                            		<div class="input-icon right">
                            			<textarea name="product_group_description" class="form-control"></textarea>
                            		</div>
                            	</div>
                            </div>
                        </div>
                    <div class="modal-footer">
                        {{ csrf_field() }}
                        <input type="hidden" name="id_product_group" value="">
                        <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn green">Update</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
@endsection