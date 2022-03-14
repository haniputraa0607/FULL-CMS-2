<?php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');
 ?>
@extends('layouts.main')

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
        var table;
        {{--  table = $('#kt_datatable').DataTable({searching: false, "paging":   false, ordering: false});  --}}

        var SweetAlert = function() {
            return {
                init: function() {
                    $(".sweetalert-delete").each(function() {
                        var token  	= "{{ csrf_token() }}";
                        let column 	= $(this).parents('tr');
                        let id     	= $(this).data('id');
                        let name    = $(this).data('name');
                        $(this).click(function() {
                            swal({
                                    title: name+"\n\nAre you sure want to delete this product catalog?",
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
                                        url : "{{url('product/catalog/delete')}}/"+id,
                                        data : {
                                            '_token' : '{{csrf_token()}}'
                                        },
                                        success : function(response) {
                                            if (response.status == 'success') {
                                                swal("Deleted!", "Product Catalog has been deleted.", "success")
                                                SweetAlert.init()
                                                location.href = "{{url('product/catalog')}}";
                                            }
                                            else if(response.status == "fail"){
                                                swal("Error!", "Failed to delete product catalog.", "error")
                                            }
                                            else {
                                                swal("Error!", "Something went wrong. Failed to delete product catalog.", "error")
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
    <br>
    @include('layouts.notifications')
  
    <?php
        $date_start = '';
        $date_end = '';

        if(Session::has('filter-list-product-catalog')){
            $search_param = Session::get('filter-list-product-catalog');
            if(isset($search_param['rule'])){
                $rule = $search_param['rule'];
            }

            if(isset($search_param['conditions'])){
                $conditions = $search_param['conditions'];
            }
        }
    ?>

    <form id="form-sorting" action="{{url()->current()}}?filter=1" method="POST">
        @include('product::catalog.filter')
    </form>
    <br>

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-blue sbold uppercase">{{ $sub_title }}</span>
            </div>
        </div>
        <div class="portlet-body form">
            <div class="row">
                <form id="form-sorting" action="{{url()->current()}}?sorting=1" method="POST">
                    {{ csrf_field() }}
                    <div class="col-md-3">
                        <select name="order" class="form-control select2" style="width: 100%">
                            <option value="created_at" @if(isset($order) && $order == 'created_at') selected @endif>Date</option>
                            <option value="name" @if(isset($order) && $order == 'name') selected @endif>Catalog Name</option>
                            <option value="company_type" @if(isset($order) && $order == 'company_type') selected @endif>Company Type</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="order_type" class="form-control select2">
                            <option value="desc" @if(isset($order_type) && $order_type == 'desc') selected @endif>Descending</option>
                            <option value="asc" @if(isset($order_type) && $order_type == 'asc') selected @endif>Ascending</option>
                        </select>
                    </div>
                    <div class="col-md-1">
                        <button type="submit" class="btn yellow">Show</button>
                    </div>
                </form>
            </div>
            <br>
            <br>
            <div style="white-space: nowrap;">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover text-center" id="kt_datatable">
                        <thead>
                        <tr>
                            <th class="text-nowrap text-center">Created At</th>
                            <th class="text-nowrap text-center">Catalog Name</th>
                            <th class="text-nowrap text-center">Company Type</th>
                            <th class="text-nowrap text-center">Status</th>
                            @if(MyHelper::hasAccess([343,344,345], $grantedFeature))
                            <th class="text-nowrap text-center">Action</th>
                            @endif
                        </tr>
                        </thead>
                        <tbody>
                            @if(!empty($data))
                                @foreach($data as $catalog)
                                    <tr data-id="{{ $catalog['id_product_catalog'] }}">
                                        <td>{{date('d F Y H:i', strtotime($catalog['created_at']))}}</td>
                                        <td>{{$catalog['name']}}</td>
                                        <td>@if($catalog['company_type'] == 'ima') PT IMA @else PT IMS @endif</td>
                                        <td>
                                            @if($catalog['status'] == 1)
                                                <span class="badge" style="background-color: #1512db; color: #ffffff">Active</span>
                                            @else
                                                <span class="badge" style="background-color: #db1912; color: #ffffff">Unactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if(MyHelper::hasAccess([418], $grantedFeature))
                                            <a href="{{ url('product/catalog/detail/'.$catalog['id_product_catalog']) }}" class="btn btn-sm blue text-nowrap"><i class="fa fa-pencil"></i> Edit</a>
                                            @endif
                                            @if(MyHelper::hasAccess([420], $grantedFeature))
                                                <a class="btn btn-sm red sweetalert-delete btn-primary" data-id="{{ $catalog['id_product_catalog'] }}" data-name="{{ $catalog['name'] }}"><i class="fa fa-trash-o"></i> Delete</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="10" style="text-align: center">Data Not Available</td>
                                </tr>
                            @endif
                            </tbody>
                    </table>
                </div>
          </div>
        </div>
    </div>
    </form>
    <br>
    @if ($data_paginator)
        {{ $data_paginator->links() }}
    @endif  
@endsection