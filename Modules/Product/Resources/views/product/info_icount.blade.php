<?php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');

 ?>
<form class="form-horizontal" id="formWithPrice" role="form" action="{{ url()->current() }}" method="post" enctype="multipart/form-data">
    @foreach ($product as $syu)
    <div class="form-body">
        <div class="form-group">
            <label class="col-md-3 control-label">Name <span class="required" aria-required="true"> * </span>
                <i class="fa fa-question-circle tooltips" data-original-title="Nama produk" data-container="body"></i>
            </label>
            <div class="col-md-8">
                <div class="input-icon right">
                    <input type="text" class="form-control" name="name" value="{{ $syu['name'] }}" required readonly>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Code <span class="required" aria-required="true"> * </span>
                <i class="fa fa-question-circle tooltips" data-original-title="Kode produk bersifat unik" data-container="body"></i>
            </label>
            <div class="col-md-8">
                <div class="input-icon right">
                    <input type="text" class="form-control" name="code" value="{{ $syu['code'] }}" required readonly>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Product Type
                <i class="fa fa-question-circle tooltips" data-original-title="Tipe Jenis dari produk" data-container="body"></i>
            </label>
            <div class="col-md-8">
                <div class="input-icon right">
                    <input type="text" class="form-control" name="code" value="{{ $syu['item_group'] }}" required readonly>
                </div>
            </div>
        </div>
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th class="text-center" width="20%"> Unit </th>
                    <th class="text-center" width="20%"> Ration </th>
                    <th class="text-center" width="30%"> Buy Price </th>
                    <th class="text-center" width="30%"> Unit Price </th>
                </tr>
            </thead>
            <tbody>
                @if (!empty($syu['unit1']))
                    <tr class="text-center">
                        <td>{{ $syu['unit1'] }}</td>
                        <td>1</td>
                        <td>{{ $syu['buy_price_1'] }}</td>
                        <td>{{ $syu['unit_price_1'] }}</td>
                    </tr>
                @endif
                @if (!empty($syu['unit2']))
                    <tr class="text-center">
                        <td>{{ $syu['unit2'] }}</td>
                        <td>{{ $syu['ratio2'] }}</td>
                        <td>{{ $syu['buy_price_2'] }}</td>
                        <td>{{ $syu['unit_price_2'] }}</td>
                    </tr>
                @endif
                @if (!empty($syu['unit3']))
                    <tr class="text-center">
                        <td>{{ $syu['unit3'] }}</td>
                        <td>{{ $syu['ratio3'] }}</td>
                        <td>{{ $syu['buy_price_3'] }}</td>
                        <td>{{ $syu['unit_price_3'] }}</td>
                    </tr>
                @endif
            </tbody>
        </table>
        <div class="form-group">
            <label class="col-md-3 control-label">Note
                <i class="fa fa-question-circle tooltips" data-original-title="Catatan terkait produk" data-container="body"></i>
            </label>
            <div class="col-md-8">
                <div class="input-icon right">
                    <textarea name="notes" class="form-control" readonly>{{$syu['notes']}}</textarea>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Product Image
                <i class="fa fa-question-circle tooltips" data-original-title="Gambar dari produk" data-container="body"></i>
            </label>
            <div class="col-md-8">
                <div class="input-icon right">
                    <img class="zoom-in" src="{{ env('STORAGE_URL_API') }}{{ $syu['image_item'] }}" height="200px"/>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" name="id_product_icount" value="{{ $syu['id_product_icount'] }}">
    @endforeach
</form>