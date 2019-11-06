@extends('layouts.main')

@section('page-style')
    <link href="{{ env('S3_URL_VIEW') }}{{ ('assets/pages/css/invoice-2.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('content')
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="{{ url('admin/home') }}">Home</a>
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
<div class="row">
	<div class="col-md-12">
		<div class="portlet light bordered" style="padding-bottom:45px">
			<div class="portlet-title">
				<div class="caption font-blue">
					<i class="icon-settings font-blue"></i>
                    <span class="caption-subject bold uppercase">List QRCode Outlet</span>
				</div>
                <div class="actions">
                    <div class="btn-group">
                        <a class="btn btn-sm green" href="{{url('outlet/qrcode/print')}}" target="_blank"><i class="fa fa-print"></i> Print </a>
                    </div>
                </div>
			</div>
			<div class="portlet-body">
                @foreach ($outlet as $item)
                    <div class="invoice-content-2 bordered" style="margin-bottom:10px; padding:30px 40px 0 40px">
                        <a href="{{url('outlet/detail')}}/{{$item['outlet_code']}}" style="color:#333">
                        <div class="row invoice-head">
                            <div class="col-md-12">
                                <center>
                                    <h3><b>{{$item['outlet_name']}}</b></h3>
                                    <!-- <h3><b>{{$item['outlet_code']}}</b></h3> -->
                                    <br>
                                    <img src="{{$item['qrcode']}}" class="img-responsive" style="width:200px">
                                </center>
                            </div>
                        </div>
                        </a>
                    </div>
                @endforeach
            </div>
            <div>
                Showing {{$from}} to {{$to}} of {{$total}} entries
            </div>
            <div class="pagination pull-right" style="margin-top:-28px;margin-bottom: 20px;">
                @if ($paginator)
                {{ $paginator->links() }}
                @endif
            </div>
		</div>
    </div>
</div>
@endsection
