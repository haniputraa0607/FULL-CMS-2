<?php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');

 ?>
<form class="form-horizontal" id="formWithPrice" role="form" action="{{ url()->current() }}" method="post" enctype="multipart/form-data">
    @foreach ($product as $syu)
    <div class="form-body">
        <div class="form-group">
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
                                <option value="{{ $suw['id_product_category'] }}" @if ($syu['id_product_category'] == $suw['id_product_category']) selected @endif>{{ $suw['product_category_name'] }}</option>
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
            <label class="col-md-3 control-label">Video
                <br>
                <span class="required" aria-required="true"> (from youtube) </span> 
                <i class="fa fa-question-circle tooltips" data-original-title="Video Tentang Produk" data-container="body"></i>
            </label>
            <div class="col-md-8">
                <div class="input-icon right">
                    <input type="url" placeholder="Example: https://www.youtube.com/watch?v=u9_2wWSOQ" class="form-control" name="product_video" value="{{ $syu['product_video'] }}">
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Weight
                <br>
                <span class="required" aria-required="true"> (gram) </span> 
                <i class="fa fa-question-circle tooltips" data-original-title="Berat Produk" data-container="body"></i>
            </label>
            <div class="col-md-8">
                <div class="input-icon right">
                    <input type="number" class="form-control" name="product_weight" value="{{ $syu['product_weight'] }}" required>
                </div>
            </div>
        </div>
        
        <div class="form-group">
            <label for="multiple" class="control-label col-md-3">Description
                <i class="fa fa-question-circle tooltips" data-original-title="Deskripsi Produk" data-container="body"></i>
            </label>
            <div class="col-md-8">
                <div class="input-icon right">
                    <textarea name="product_description" id="pro_text" class="form-control summernote">{{ $syu['product_description'] }}</textarea>
                </div>
            </div>
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