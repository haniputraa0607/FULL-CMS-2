@extends('layouts.main')

@section('page-style')
@endsection
    
@section('page-script')
    <script>
        function addReplace(param){
		    var textvalue = $('#package-detail').val();
            var textvaluebaru = textvalue+" "+param;
            $('#package-detail').val(textvaluebaru);
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

    <div class="portlet light form-fit bordered">
        <div class="portlet-title">
            <div class="caption">
                <i class=" icon-layers font-green"></i>
                <span class="caption-subject font-green bold uppercase">Package Detail Delivery</span>
            </div>
        </div>
        <div class="portlet-body form">
            <form class="form-horizontal" action="{{ url('transaction/setting/package-detail-delivery') }}" method="post" id="form">
            {{ csrf_field() }}
            <div class="form-body">
                <div class="form-group">
                    <div class="input-icon right">
                        <label class="col-md-3 control-label">
                            Package name
                        <span class="required" aria-required="true"> * </span>  
                            <i class="fa fa-question-circle tooltips" data-original-title="Informasi yang akan dikirimkan ke pihak delivery digunakan untuk go-send dan we help you" data-container="body"></i>
                        </label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" placeholder="Package name" class="form-control" name="package_name" id="package-detail" value="@if(isset($result['package_name'])){{$result['package_name']}}@endif">
                        <br>
                        You can use this variables to display order ID:
                        <br><br>
                        <div class="row">
                            <div class="col-md-3" style="margin-bottom:5px;">
                                <span class="btn dark btn-xs btn-block btn-outline var" data-toggle="tooltip" title="Text will be replace '%order_id%' with transaction's order ID" onClick="addReplace('%order_id%');">Order ID</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-icon right">
                        <label class="col-md-3 control-label">
                            Package description
                            <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Informasi deskripsi yang akan dikirimkan ke pihak delivery digunakan untuk go-send dan we help you" data-container="body"></i>
                        </label>
                    </div>
                    <div class="col-md-8">
                        <textarea type="text" placeholder="Package description" class="form-control" name="package_description">{{$result['package_description']??""}}</textarea>
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-icon right">
                        <label class="col-md-3 control-label">
                            Length
                            <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Masukkan panjang rata-rata produk, satuan dalam cm. Digunakan untuk kebutuhan we help you." data-container="body"></i>
                        </label>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group">
                            <input type="text" class="form-control" name="length" value="{{ $result['length']??0 }}" placeholder="Length" required>
                            <span class="input-group-addon"> cm </span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-icon right">
                        <label class="col-md-3 control-label">
                            Width
                            <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Masukkan lebar rata-rata produk, satuan dalam cm. Digunakan untuk kebutuhan we help you." data-container="body"></i>
                        </label>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group">
                            <input type="text" class="form-control" name="width" value="{{ $result['width']??0 }}" placeholder="Width" required>
                            <span class="input-group-addon"> cm </span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-icon right">
                        <label class="col-md-3 control-label">
                            Height
                            <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Masukkan tinggi rata-rata produk, satuan dalam cm. Digunakan untuk kebutuhan we help you." data-container="body"></i>
                        </label>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group">
                            <input type="text" class="form-control" name="height" value="{{ $result['height']??0 }}" placeholder="Height" required>
                            <span class="input-group-addon"> cm </span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-icon right">
                        <label class="col-md-3 control-label">
                            Weight
                            <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Masukkan bobot rata-rata produk, satuan dalam kg. Digunakan untuk kebutuhan we help you." data-container="body"></i>
                        </label>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group">
                            <input type="text" class="form-control" name="weight" value="{{ $result['weight']??0 }}" placeholder="Weight" required>
                            <span class="input-group-addon"> kg </span>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-offset-3 col-md-10">
                            <button type="submit" class="btn green">
                                <i class="fa fa-check"></i> Save</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
