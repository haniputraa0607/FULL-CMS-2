<?php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');

 ?>
<form class="form-horizontal" id="formWithPrice" role="form" action="{{ url()->current() }}" method="post" enctype="multipart/form-data">
    @foreach ($product as $syu)
    <div class="form-body">
        <div class="form-group hidden">
            <label for="multiple" class="control-label col-md-3">Product Variant Status <span class="required" aria-required="true"> * </span>
                <i class="fa fa-question-circle tooltips" data-original-title="Jika produk memiliki variant silahkan centang checkbox ini" data-container="body"></i>
            </label>
            <div class="col-md-8">
                <div class="icheck-list">
                    <label><input type="checkbox" class="icheck" id="checkbox-variant" name="product_variant_status" @if($product[0]['product_variant_status'] == 1) checked @endif> </label>
                </div>
            </div>
        </div>
        <div class="form-group hidden">
            <label for="multiple" class="control-label col-md-3">Category <span class="required" aria-required="true"> * </span>
                <i class="fa fa-question-circle tooltips" data-original-title="Pilih Kategori Produk" data-container="body"></i>
            </label>
            <div class="col-md-8">
                <div class="input-icon right">
                    <select id="multiple" class="form-control select2-multiple" name="id_product_category" data-placeholder="select category" required>
                    <optgroup label="Category List">
                        <option value="0">Uncategorize</option>
                        @if (!empty($parent))
                            @foreach($parent as $suw)
                                <option value="{{ $suw['id_product_category'] }}" @if (($syu['category'][0]['id_product_category']??false) == $suw['id_product_category']) selected @endif>{{ $suw['product_category_name'] }}</option>
                                @if (!empty($suw['child']))
                                    @foreach ($suw['child'] as $child)
                                        <option value="{{ $child['id_product_category'] }}" @if ($syu['id_product_category'] == $child['id_product_category']) selected @endif data-ampas="{{ $child['product_category_name'] }}">&nbsp;&nbsp;&nbsp;{{ $child['product_category_name'] }}</option>
                                    @endforeach
                                @endif
                            @endforeach
                        @endif
                    </optgroup>
                </select>
                </div>
            </div>
        </div>
        <div class="form-group hidden">
            <label class="col-md-3 text-right control-label">Promo Category <i class="fa fa-question-circle tooltips" data-original-title="Pilih Kategori Promo Produk" data-container="body"></i></label>
            <div class="col-md-8">
                <select name="id_product_promo_category[]" class="select2 form-control" data-placeholder="Select category" multiple>
                    <option value=""></option>
                    @foreach($promo_categories as $category)
                    <option value="{{$category['id_product_promo_category']}}" @if(in_array($category['id_product_promo_category'],$product[0]['product_promo_categories'])) selected @endif>{{$category['product_promo_category_name']}}</option>
                    @endforeach
                </select>
            </div>
        </div>
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
            <label class="col-md-3 control-label">Type
                <i class="fa fa-question-circle tooltips" data-original-title="Jenis dari produk" data-container="body"></i>
            </label>
            <div class="col-md-8">
                <select class="select2 form-control" name="product_type">
                    <option value="product" @if($syu['product_type'] == 'product') selected="selected" @endif>Product</option>
                    <option value="service" @if($syu['product_type'] == 'service') selected="selected" @endif>Service</option>
                    <option value="academy" @if($syu['product_type'] == 'academy') selected="selected" @endif>Academy</option>
                </select>
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
        <div class="form-group hidden">
            <label class="col-md-3 control-label">POS Name
                <i class="fa fa-question-circle tooltips" data-original-title="Nama Default Dari POS" data-container="body"></i>
            </label>
            <div class="col-md-8">
                <div class="input-icon right">
                    <input type="text" class="form-control" name="product_name_pos" value="{{ $syu['product_name_pos'] }}" readonly>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="input-icon right">
                <label class="col-md-3 control-label">
                Brand
                <span class="required" aria-required="true"> * </span>
                <i class="fa fa-question-circle tooltips" data-original-title="Masukkan brand yang tersedia dalam outlet ini" data-container="body"></i>
                </label>
            </div>
            <div class="col-md-8">
                <select class="select2 form-control" name="product_brands[]">
                    @foreach($brands as $brand)
                    <option value="{{$brand['id_brand']}}" @if(in_array($brand['id_brand'],old('product_brands',array_column($syu['brands'],'id_brand')))) selected="selected" @endif>{{$brand['name_brand']}}</option>
                    @endforeach
                </select>
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
                        <input type="file" class="file" id="fieldphoto" accept="image/*" name="photo" @if(empty($syu['photos'][0]['url_product_photo'])) required @endif>
                        </span>

                        <a href="javascript:;" id="remove_fieldphoto" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                    </div>
                </div>
            </div>
        </div>
         <div class="form-group hidden">
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
                        <input type="file" class="filePhotoDetail" id="fieldphotodetail" accept="image/*" name="product_photo_detail">
                        </span>

                        <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                    </div>
                </div>
            </div>
        </div>


        <!--<div class="form-group">-->
        <!--    <label class="col-md-3 control-label">Video-->
        <!--        <br>-->
        <!--        <span class="required" aria-required="true"> (from youtube) </span> -->
        <!--        <i class="fa fa-question-circle tooltips" data-original-title="Video Tentang Produk" data-container="body"></i>-->
        <!--    </label>-->
        <!--    <div class="col-md-8">-->
        <!--        <div class="input-icon right">-->
        <!--            <input type="url" placeholder="Example: https://www.youtube.com/watch?v=u9_2wWSOQ" class="form-control" name="product_video" value="{{ $syu['product_video'] }}">-->
        <!--        </div>-->
        <!--    </div>-->
        <!--</div>-->
        <!--<div class="form-group">-->
        <!--    <label class="col-md-3 control-label">Weight-->
        <!--        <br>-->
        <!--        <span class="required" aria-required="true"> (gram) </span> -->
        <!--        <i class="fa fa-question-circle tooltips" data-original-title="Berat Produk" data-container="body"></i>-->
        <!--    </label>-->
        <!--    <div class="col-md-8">-->
        <!--        <div class="input-icon right">-->
        <!--            <input type="number" class="form-control" name="product_weight" value="{{ $syu['product_weight'] }}" required>-->
        <!--        </div>-->
        <!--    </div>-->
        <!--</div>-->

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

        <div class="form-group">
            <label class="col-md-3 control-label">Product IMA
                <i class="fa fa-question-circle tooltips" data-original-title="Jenis product icount dari IMA yang akan digunakan dalam produc" data-container="body"></i>
            </label>
            <div class="col-md-5">
                <select class="select2 form-control" id="product_use_code_ima_0" name="product_icount_ima[0][id_product_icount]" onchange="changeUnit(0,this.value,'ima')">
                    <option></option>
                    @foreach($product_uses_ima as $product_use_ima)
                        <option value="{{$product_use_ima['id_product_icount']}}" data-units="{{$product_use_ima['units']}}" @if (isset($product_icount_use_ima[0])) @if($product_use_ima['id_product_icount'] == $product_icount_use_ima[0]['id_product_icount']) selected @endif @endif>{{$product_use_ima['code']}} - {{$product_use_ima['name']}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-control select2" id="product_use_unit_ima_0" name="product_icount_ima[0][unit]" placeholder="Select unit" style="width: 100%">
                    <option></option>
                    @if (isset($product_icount_use_ima[0]))
                    @foreach($product_uses_ima as $use)
                        @if ($use['id_product_icount'] == $product_icount_use_ima[0]['id_product_icount'])
                            @foreach ($use['unit_icount'] as $unit_icount)
                            @if($unit_icount['unit']) <option value="{{ $unit_icount['unit'] }}" @if($unit_icount['unit'] == $product_icount_use_ima[0]['unit']) selected @endif>{{ $unit_icount['unit'] }}</option> @endif
                            @endforeach
                        @endif
                    @endforeach
                    @else
                    <option value="PCS">PCS</option>
                    @endif
                </select>
            </div>
            <input type="hidden" class="form-control price" id="product_use_qty_ima_0" name="product_icount_ima[0][qty]" @if(isset($product_icount_use_ima[0])) value="{{ $product_icount_use_ima[0]['qty'] }}" @endif>
        </div>

        <div class="form-group">
            <label class="col-md-3 control-label">Product IMS
                <i class="fa fa-question-circle tooltips" data-original-title="Jenis product icount dari IMS yang akan digunakan dalam produc" data-container="body"></i>
            </label>
            <div class="col-md-5">
                <select class="select2 form-control" id="product_use_code_ims_0" name="product_icount_ims[0][id_product_icount]" onchange="changeUnit(0,this.value,'ims')">
                    <option></option>
                    @foreach($product_uses_ims as $product_use_ims)
                        <option value="{{$product_use_ims['id_product_icount']}}" data-units="{{$product_use_ims['units']}}" @if (isset($product_icount_use_ims[0])) @if($product_use_ims['id_product_icount'] == $product_icount_use_ims[0]['id_product_icount']) selected @endif @endif  >{{$product_use_ims['code']}} - {{$product_use_ims['name']}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-control select2" id="product_use_unit_ims_0" name="product_icount_ims[0][unit]" placeholder="Select unit" style="width: 100%">
                    <option></option>
                    @if (isset($product_icount_use_ims[0]))
                    @foreach($product_uses_ims as $use)
                        @if ($use['id_product_icount'] == $product_icount_use_ims[0]['id_product_icount'])
                            @foreach ($use['unit_icount'] as $unit_icount)
                            @if($unit_icount['unit']) <option value="{{ $unit_icount['unit'] }}" @if($unit_icount['unit'] == $product_icount_use_ims[0]['unit']) selected @endif>{{ $unit_icount['unit'] }}</option> @endif
                            @endforeach
                        @endif
                    @endforeach
                    @else
                    <option value="PCS">PCS</option>
                    @endif
                </select>
            </div>
            <input type="hidden" class="form-control price" id="product_use_qty_ims_0" name="product_icount_ims[0][qty]" @if(isset($product_icount_use_ima[0])) value="{{ $product_icount_use_ima[0]['qty'] }}" @endif>
        </div>

          <!-- {{--<div class="form-group">
            <label for="multiple" class="control-label col-md-3">Tag
                {{-- <i class="fa fa-question-circle tooltips" data-original-title="Deskripsi Produk" data-container="body"></i> --}}
            </label>
            <div class="col-md-8">
                <select name="id_tag[]" class="bs-select form-control" id="select_tag" multiple data-live-search="true" title="Select Tag">
                    <option id="option_new_tag" value="+" data-content="<span class='btn btn-info'><i class='fa fa-plus' style='color:#fff'></i> Add New Category</span>">
                        New Tag
                    </option>
                    @php
                        if (!empty($syu['product_tags'])) {
                            $selectedTag = array_pluck($syu['product_tags'], 'id_tag');
                        }
                        else {
                            $selectedTag = [];
                        }
                        @endphp
                        @if (!empty($tags))
                            @foreach($tags as $tag)
                                <option value="{{ $tag['id_tag'] }}" @if(in_array($tag['id_tag'], $selectedTag)) selected @endif>{{ $tag['tag_name'] }}</option>
                            @endforeach
                        @endif
                </select>
            </div>
        </div> --}} -->
    </div>
    <input type="hidden" name="id_product" value="{{ $syu['id_product'] }}">
    @endforeach

    @if(MyHelper::hasAccess([51], $grantedFeature))
        <div class="form-actions">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-md-offset-3 col-md-8">
                    <button type="submit" id="submit" class="btn green">Update</button>
                @if($next_id)
                    <a href="{{url('product/detail'.$next_id)}}" type="button" class="btn default">Next</a>
                @endif
                </div>
            </div>
        </div>
    @endif
</form>
 <!--begin::Modal-->
 <div class="modal fade" id="m_modal_5" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    New Tag
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">
                        &times;
                    </span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="recipient-name" class="form-control-label">
                            Tag Name:
                        </label>
                        <input type="text" class="form-control" id="tag_name">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-secondary" data-dismiss="modal" id="close_modal">
                    Cancel
                </button>
                <button type="button" class="btn btn-primary" id="new_tag">
                    Save
                </button>
            </div>
        </div>
    </div>
</div>
<!--end::Modal-->