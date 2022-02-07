@extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('js/global.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $("#multiple").change(function() {
            var id = $(this).val();
            var url = '{{ url("academy/transaction/outlet/course") }}/'+id;
            window.location = url;
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
                <span class="caption-subject sbold uppercase font-blue">Outlet Course</span>
            </div>
            <div class="actions">
                <div class="btn-group" style="width: 300px">
                   <select id="multiple" class="form-control select2-multiple" name="id_outlet" data-placeholder="select outlet">
				        <optgroup label="Outlet List">
				            @if (!empty($outlet))
				                @foreach($outlet as $suw)
				                    <option value="{{ $suw['id_outlet'] }}" @if ($suw['id_outlet'] == $key) selected @endif>{{ $suw['outlet_name'] }}</option>
				                @endforeach
				            @endif
				        </optgroup>
				    </select>
                </div>
            </div>
        </div>
        <div class="portlet-body form">
            <br>
            <br>
            <table class="table table-striped table-bordered table-hover" width="100%">
                <thead>
                    <tr>
                        <th>Course Code</th>
                        <th>Course Name</th>
                        <th>Total Student</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if (!empty($course))
                        @foreach ($course as $data)
                            <tr>
                                <td>{{$data['product_code']}}</td>
                                <td>{{$data['product_name']}}</td>
                                <td>{{$data['total_student']}}</td>
                                <td>
                                    <a href="{{url('academy/transaction/outlet/course/detail/'.$key.'/'.$data['id_product'])}}" class="btn btn-sm blue">List Student</a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr style="text-align: center"><td colspan="4">Data Not Available</td></tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection
