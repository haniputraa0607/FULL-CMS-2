<?php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');

 ?>
<form class="form-horizontal" id="formWithPrice" role="form" action="{{ url()->current() }}" method="post" enctype="multipart/form-data">
    @foreach ($product as $syu)
    <div class="form-body">
        <div class="form-group">
            <label for="multiple" class="control-label col-md-3">Home Service Status <span class="required" aria-required="true"> * </span>
                <i class="fa fa-question-circle tooltips" data-original-title="Jika dicentang maka service ini akan muncul pada list home service saja dan tidak muncul pada outlet service" data-container="body"></i>
            </label>
            <div class="col-md-8" style="margin-top: 0.7%">
                <div class="icheck-list">
                    <label><input type="checkbox" class="icheck" id="checkbox-variant" name="available_home_service" @if($syu['available_home_service'] == 1) checked @endif> </label>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-3 control-label">Name <span class="required" aria-required="true"> * </span>
                <i class="fa fa-question-circle tooltips" data-original-title="Nama Produk" data-container="body"></i>
            </label>
            <div class="col-md-8">
                <div class="input-icon right">
                    <input type="text" class="form-control" name="product_name" value="{{ $syu['product_name'] }}" required>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Code
                <i class="fa fa-question-circle tooltips" data-original-title="Kode Produk Bersifat Unik" data-container="body"></i>
            </label>
            <div class="col-md-8">
                <div class="input-icon right">
                    <input type="text" class="form-control" name="product_code" value="{{ $syu['product_code'] }}" required>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Global Price <span class="required" aria-required="true"> * </span>
                <i class="fa fa-question-circle tooltips" data-original-title="Global Price Product" data-container="body"></i>
            </label>
            <div class="col-md-8">
                <div class="input-icon right">
                    <input type="text" class="form-control price" name="product_global_price" value="@if(isset($syu['global_price'][0]['product_global_price'])) {{number_format($syu['global_price'][0]['product_global_price'])}} @endif"  @if($product[0]['product_variant_status'] == 1) disabled @endif required>
                    <input type="hidden" id="old_global_price" value="@if(isset($syu['global_price'][0]['product_global_price'])) {{number_format($syu['global_price'][0]['product_global_price'])}} @endif">
                </div>
            </div>
        </div>

{{--        <div class="form-group">--}}
{{--            <div class="input-icon right">--}}
{{--                <label class="col-md-3 control-label">--}}
{{--                Brand--}}
{{--                <span class="required" aria-required="true"> * </span>--}}
{{--                <i class="fa fa-question-circle tooltips" data-original-title="Masukkan brand yang tersedia dalam outlet ini" data-container="body"></i>--}}
{{--                </label>--}}
{{--            </div>--}}
{{--            <div class="col-md-8">--}}
{{--                <select class="select2 form-control" name="product_brands[]" style="width: 100%">--}}
{{--                    @foreach($brands as $brand)--}}
{{--                    <option value="{{$brand['id_brand']}}" @if(in_array($brand['id_brand'],old('product_brands',array_column($syu['brands'],'id_brand')))) selected="selected" @endif>{{$brand['name_brand']}}</option>--}}
{{--                    @endforeach--}}
{{--                </select>--}}
{{--            </div>--}}
{{--        </div>--}}

        <div class="form-group" id="div_processing_time">
            <label class="col-md-3 control-label">Processing Time
                <i class="fa fa-question-circle tooltips" data-original-title="Waktu pengerjaan untuk setiap service" data-container="body"></i>
            </label>
            <div class="col-md-4">
                <div class="input-group">
                    <input type="text" class="form-control price" maxlength="3" id="processing_time" name="processing_time_service" value="{{ $syu['processing_time_service'] }}" required>
                    <span class="input-group-addon">Minutes</span>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-3 control-label">Product Visible
                <i class="fa fa-question-circle tooltips" data-original-title="Setting apakah produk akan ditampilkan di aplikasi" data-container="body"></i>
            </label>
            <div class="input-icon right">
                <div class="col-md-2">
                    <div class="md-radio-inline">
                        <div class="md-radio">
                            <input type="radio" id="radio1" name="product_visibility" class="md-radiobtn req-type" value="Visible" required @if($syu['product_visibility'] == 'Visible') checked @endif>
                            <label for="radio1">
                                <span></span>
                                <span class="check"></span>
                                <span class="box"></span> Visible</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="md-radio-inline">
                        <div class="md-radio">
                            <input type="radio" id="radio2" name="product_visibility" class="md-radiobtn req-type" value="Hidden" required @if($syu['product_visibility'] == 'Hidden') checked @endif>
                            <label for="radio2">
                                <span></span>
                                <span class="check"></span>
                                <span class="box"></span> Hidden </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
         <div class="form-group">
            <label class="col-md-3 control-label">
                Photo <span class="required" aria-required="true">* <br>(300*300) </span>
                <i class="fa fa-question-circle tooltips" data-original-title="Gambar Produk" data-container="body"></i>
            </label>
            <div class="col-md-8">
                <div class="fileinput fileinput-new" data-provides="fileinput">
                    <div class="fileinput-new thumbnail" style="width: 200px; height: 200px;">
                     <img src="@if(isset($syu['photos'][0]['url_product_photo'])){{$syu['photos'][0]['url_product_photo']}}@endif" alt="">
                    </div>
                    <div class="fileinput-preview fileinput-exists thumbnail" id="imageproduct" style="max-width: 200px; max-height: 200px;"></div>
                    <div>
                        <span class="btn default btn-file">
                        <span class="fileinput-new"> Select image </span>
                        <span class="fileinput-exists"> Change </span>
                        <input type="file" class="file" id="fieldphoto" accept="image/*" name="photo">
                        </span>

                        <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group">
           <label for="multiple" class="control-label col-md-3">Description
               <i class="fa fa-question-circle tooltips" data-original-title="Deskripsi Produk" data-container="body"></i>
           </label>
           <div class="col-md-8">
               <div class="input-icon right">
                   <textarea name="product_description" id="pro_text" class="form-control">{{ $syu['product_description'] }}</textarea>
               </div>
           </div>
        </div>
    </div>
    <input type="hidden" name="id_product" value="{{ $syu['id_product'] }}">
    @endforeach

    @if(MyHelper::hasAccess([365], $grantedFeature))
        <div class="form-actions">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-md-offset-3 col-md-8">
                    <button type="submit" id="submit" class="btn green">Update</button>
                </div>
            </div>
        </div>
    @endif
</form>