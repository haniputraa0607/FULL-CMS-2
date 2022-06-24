<?php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');

 ?>
<form class="form-horizontal" id="formWithPrice" role="form" action="{{ url()->current() }}" method="post" enctype="multipart/form-data">
    @foreach ($product as $syu)
    <div class="form-body">
        <div class="form-group">
            <label class="col-md-3 control-label">Code
                <i class="fa fa-question-circle tooltips" data-original-title="Kode Produk Bersifat Unik" data-container="body"></i>
            </label>
            <div class="col-md-8">
                <div class="input-icon right">
                    <input type="text" class="form-control" name="product_code" value="{{ $syu['product_code'] }}" readonly>
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

        <div class="form-group">
            <label class="col-md-3 control-label">Visible
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
                        <input type="file" class="file" id="fieldphoto" accept="image/*" name="photo" @if(empty($syu['photos'][0]['url_product_photo'])) required @endif>
                        </span>

                        <a href="javascript:;" id="remove_fieldphoto" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-3 control-label">
                Photo Detail<span class="required" aria-required="true">* <br>(720*360) </span>
                <i class="fa fa-question-circle tooltips" data-original-title="Gambar Produk Detail" data-container="body"></i>
            </label>
            <div class="col-md-8">
                <div class="fileinput fileinput-new" data-provides="fileinput">
                    <div class="fileinput-new thumbnail" style="width: 200px; height: 100px;">
                        <img src="@if(isset($syu['product_photo_detail'])){{ env('STORAGE_URL_API') }}{{$syu['product_photo_detail']}}@endif" alt="">
                    </div>
                    <div class="fileinput-preview fileinput-exists thumbnail" id="imageproductDetail" style="max-width: 200px; max-height: 100px;"></div>
                    <div>
                        <span class="btn default btn-file">
                        <span class="fileinput-new"> Select image </span>
                        <span class="fileinput-exists"> Change </span>
                        <input type="file" class="filePhotoDetail" id="fieldphotodetail" accept="image/*" name="product_photo_detail" @if(empty($syu['product_photo_detail'])) required @endif>
                        </span>

                        <a href="javascript:;" id="remove_fieldphotodetail" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group">
           <label for="multiple" class="control-label col-md-3">Duration <span class="required" aria-required="true"> * </span>
               <i class="fa fa-question-circle tooltips" data-original-title="Lama waktu pelaksanaan" data-container="body"></i>
           </label>
           <div class="col-md-3">
               <div class="input-group">
                   <input name="product_academy_duration" maxlength="255" class="form-control" value="{{ $syu['product_academy_duration'] }}" required>
                   <span class="input-group-addon">
                        Month
                    </span>
               </div>
           </div>
        </div>

        <div class="form-group">
            <label for="multiple" class="control-label col-md-3">Total Meeting <span class="required" aria-required="true"> * </span>
                <i class="fa fa-question-circle tooltips" data-original-title="Total jumlah pertemuan" data-container="body"></i>
            </label>
            <div class="col-md-3">
                <div class="input-group">
                    <input name="product_academy_total_meeting" maxlength="255" class="form-control" value="{{ $syu['product_academy_total_meeting'] }}" required>
                    <span class="input-group-addon">
                        X
                    </span>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="multiple" class="control-label col-md-3">Total Hours Meeting <span class="required" aria-required="true"> * </span>
                <i class="fa fa-question-circle tooltips" data-original-title="Total jam dalam 1 pertemuan" data-container="body"></i>
            </label>
            <div class="col-md-3">
                <div class="input-group">
                    <input name="product_academy_hours_meeting" maxlength="2" class="form-control" value="{{ $syu['product_academy_hours_meeting'] }}" required>
                    <span class="input-group-addon">
                        Hours
                    </span>
                </div>
            </div>
        </div>

{{--        <div class="form-group">--}}
{{--            <label for="multiple" class="control-label col-md-3">Maximum Step Installment <span class="required" aria-required="true"> * </span>--}}
{{--                <i class="fa fa-question-circle tooltips" data-original-title="Maksimal jumlah step untuk cicilan" data-container="body"></i>--}}
{{--            </label>--}}
{{--            <div class="col-md-3">--}}
{{--                <div class="input-group">--}}
{{--                    <input name="product_academy_maximum_installment" maxlength="2" class="form-control" value="{{ $syu['product_academy_maximum_installment'] }}">--}}
{{--                    <span class="input-group-addon">--}}
{{--                        Step--}}
{{--                    </span>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}

        <div class="form-group">
            <label for="multiple" class="control-label col-md-3">Short Description <span class="required" aria-required="true"> * </span>
                <i class="fa fa-question-circle tooltips" data-original-title="Deskripsi Produk" data-container="body"></i>
            </label>
            <div class="col-md-8">
                <div class="input-icon right">
                    <textarea name="product_short_description" class="form-control" required>{{ $syu['product_short_description'] }}</textarea>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="multiple" class="control-label col-md-3">Long Description
                <i class="fa fa-question-circle tooltips" data-original-title="Deskripsi Produk" data-container="body"></i>
            </label>
            <div class="col-md-8">
                <div class="input-icon right">
                    <textarea name="product_description" class="form-control summernote">{{ $syu['product_description'] }}</textarea>
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