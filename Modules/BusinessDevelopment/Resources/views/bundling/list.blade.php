<?php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');
 ?>
@extends('layouts.main')

@section('page-style')
@endsection

@section('page-plugin')
<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
<script type="text/javascript">
    function deleteBundling(id) {
        alert(id);
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
    </div>
    <br>
    @include('layouts.notifications')  

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-blue sbold uppercase">Outlet Starter Bundling</span>
            </div>
        </div>
        <div class="portlet-body form">
            <br>
            <div style="white-space: nowrap;">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="kt_datatable">
                        <thead>
                        <tr>
                            <th class="text-nowrap text-center">Name</th>
                            <th class="text-nowrap text-center">Code</th>
                            <th class="text-nowrap text-center">Description</th>
                            <th class="text-nowrap text-center">Status</th>
                            <th class="text-nowrap text-center">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(!empty($result['data']))
                            @foreach($result['data'] as $dt)
                                <tr>
                                    <td>{{$dt['name']}}</td>
                                    <td>{{$dt['code']}}</td>
                                    <td>{{$dt['description']}}</td>
                                    <td>{{$dt['status'] ? 'Active' : 'Inactive'}}</td>
                                    <td>
                                        <a href="{{ url('outlet-starter-bundling/detail/'.$dt['code']) }}" class="btn btn-sm blue text-nowrap"><i class="fa fa-pencil"></i> Edit</a>
                                        <form style="display:inline;" action="{{ url('outlet-starter-bundling/delete') }}" method="post">
                                            @csrf
                                            <input type="hidden" name="id_outlet_starter_bundling" value="{{ $dt['id_outlet_starter_bundling'] }}">
                                            <button type="submit" class="btn btn-sm red sweetalert-delete btn-primary" data-toggle="confirmation"><i class="fa fa-trash-o"></i> Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" style="text-align: center">Data Not Available</td>
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
@endsection