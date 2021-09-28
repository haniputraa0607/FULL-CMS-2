<?php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');
    $configs    		= session('configs');
 ?>
<form class="form-horizontal" role="form" action="{{ url()->current() }}" method="post" enctype="multipart/form-data">
    @foreach ($outlet as $key => $val)
    <div class="form-body">
        <h4>Info</h4>

        <div class="form-group">
            <div class="input-icon right">
                <label class="col-md-3 control-label">
                QR Code
                </label>
            </div>
            <div class="col-md-9">
                <div class="fileinput-new thumbnail" style="width: 150px; height: 150px;">
                    <img src="{{$val['qrcode']}}">
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="input-icon right">
                <label class="col-md-3 control-label">
                    Status Mitra
                    <i class="fa fa-question-circle tooltips" data-original-title="Keterangan outlet ini adalah franchise atau bukan franchise" data-container="body"></i>
                </label>
            </div>
            <div class="col-md-9">
                <select class="select2 form-control" name="status_franchise">
                    <option value="1" @if($val['status_franchise'] == 1) selected @endif>Mitra</option>
                    <option value="0" @if($val['status_franchise'] == 0) selected @endif>Pusat</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <div class="input-icon right">
                <label class="col-md-3 control-label">
                Code
                <i class="fa fa-question-circle tooltips" data-original-title="Kode outlet bersifat unik" data-container="body"></i>
                </label>
            </div>
            <div class="col-md-9">
                <input type="text" class="form-control" name="outlet_code" value="{{ $val['outlet_code'] }}" required placeholder="Outlet Code" @if(Session::get('level') != "Super Admin") readonly @endif>
            </div>
        </div>

        <div class="form-group">
            <div class="input-icon right">
                <label class="col-md-3 control-label">
                Name
                <span class="required" aria-required="true"> * </span>
                <i class="fa fa-question-circle tooltips" data-original-title="Masukkan nama outlet" data-container="body"></i>
                </label>
            </div>
            <div class="col-md-9">
                <input type="text" class="form-control" name="outlet_name" value="{{ $val['outlet_name'] }}" required placeholder="Outlet Name">
            </div>
        </div>

        <div class="form-group">
            <div class="input-icon right">
                <label class="col-md-3 control-label">
                    Description
                    <i class="fa fa-question-circle tooltips" data-original-title="Deskripsi seputar outlet" data-container="body"></i>
                </label>
            </div>
            <div class="col-md-9">
                <textarea name="outlet_description" class="form-control" placeholder="Outlet Description">{{ $val['outlet_description'] }}</textarea>
            </div>
        </div>

        @if(MyHelper::hasAccess([95], $configs))
        <div class="form-group">
            <div class="input-icon right">
                <label class="col-md-3 control-label">
                Brand
                <span class="required" aria-required="true"> * </span>
                <i class="fa fa-question-circle tooltips" data-original-title="Masukkan brand yang tersedia dalam outlet ini" data-container="body"></i>
                </label>
            </div>
            <div class="col-md-9">
                <select class="select2 form-control" multiple="multiple" name="outlet_brands[]">
                    <option value="*">All Brands</option>
                    @foreach($brands as $brand)
                    <option value="{{$brand['id_brand']}}" @if(in_array($brand['id_brand'],array_column($val['brands'],'id_brand'))) selected="selected" @endif>{{$brand['name_brand']}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        @endif
        <div class="form-group">
            <label class="col-md-3 control-label">Status
                <span class="required" aria-required="true"> * </span>
                <i class="fa fa-question-circle tooltips" data-original-title="Status outlet. Outlet tidak akan ditampilkan di aplikasi ketika status Inactive" data-container="body"></i>
            </label>
            <div class="col-md-9">
                    <div class="md-radio-inline">
                    <div class="md-radio">
                        <input type="radio" id="radio14" name="outlet_status" class="md-radiobtn" value="Active" required @if($val['outlet_status'] == 'Active') checked @endif>
                        <label for="radio14">
                            <span></span>
                            <span class="check"></span>
                            <span class="box"></span> Active </label>
                    </div>
                    <div class="md-radio">
                        <input type="radio" id="radio16" name="outlet_status" class="md-radiobtn" value="Inactive" required @if($val['outlet_status'] == 'Inactive') checked @endif>
                        <label for="radio16">
                            <span></span>
                            <span class="check"></span>
                            <span class="box"></span> Inactive </label>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="input-icon right">
                <label class="col-md-3 control-label">
                Province
                <span class="required" aria-required="true"> * </span>
                <i class="fa fa-question-circle tooltips" data-original-title="Pilih provinsi letak outlet" data-container="body"></i>
                </label>
            </div>
            <div class="col-md-9">
                <select id="province" class="form-control select2-multiple" data-placeholder="Select Province" required>
                    <optgroup label="Province List">
                        <option value="">Select Province</option>
                        @if (!empty($province))
                            @foreach($province as $suw)
                                <option value="{{ $suw['id_province'] }}" @if ($suw['id_province'] == $val['city']['id_province']) selected @endif ) >{{ $suw['province_name'] }}</option>
                            @endforeach
                        @endif
                    </optgroup>
                </select>
            </div>
        </div>

        <div class="form-group">
            <div class="input-icon right">
                <label class="col-md-3 control-label">
                City
                <span class="required" aria-required="true"> * </span>
                <i class="fa fa-question-circle tooltips" data-original-title="Pilih kota letak outlet" data-container="body"></i>
                </label>
            </div>
            <div class="col-md-9">
                <select id="city" class="form-control select2-multiple" data-placeholder="Select City" disabled required>
                    <optgroup label="Province List">
                        <option value="{{ $val['city']['city_name'] }}">{{ $val['city']['city_name'] }}</option>
                    </optgroup>
                </select>
            </div>
        </div>

        <div class="form-group">
            <div class="input-icon right">
                <label class="col-md-3 control-label">
                Address
                <i class="fa fa-question-circle tooltips" data-original-title="Alamat lengkap outlet" data-container="body"></i>
                </label>
            </div>
            <div class="col-md-9">
                <textarea name="outlet_address" class="form-control" placeholder="Outlet Address">{{ $val['outlet_address'] }}</textarea>
            </div>
        </div>

        <div class="form-group">
            <div class="input-icon right">
                <label class="col-md-3 control-label">
                Phone
                <i class="fa fa-question-circle tooltips" data-original-title="Nomor telepon outlet" data-container="body"></i>
                </label>
            </div>
            <div class="col-md-9">
                <input type="text" class="form-control" name="outlet_phone" value="{{ $val['outlet_phone'] }}" placeholder="Outlet Phone">
            </div>
        </div>

        <div class="form-group">
            <div class="input-icon right">
                <label class="col-md-3 control-label">
                Email
                <i class="fa fa-question-circle tooltips" data-original-title="Alamat email outlet" data-container="body"></i>
                </label>
            </div>
            <div class="col-md-9">
                <input type="text" class="form-control" name="outlet_email" value="{{ $val['outlet_email'] }}" placeholder="Outlet Email">
            </div>
        </div>
        {{--
        <div class="form-group">
            <div class="input-icon right">
                <label class="col-md-3 control-label">
                Time Zone
                <span class="required" aria-required="true"> * </span>
                <i class="fa fa-question-circle tooltips" data-original-title="Zona waktu outlet" data-container="body"></i>
                </label>
            </div>
            <div class="col-md-9">
                <select class="form-control" name="time_zone_utc" required>
                    <option value="" disabled @if ( old('time_zone_utc')== "" ) selected @endif>Select Time Zone</option>
                    <option value="7" 
                        @if ( $val['time_zone_utc'] == '7' ) 
                            selected 
                        @endif>WIB - Asia/Jakarta (UTC +07:00)</option>
                    <option value="8" 
                        @if ( $val['time_zone_utc'] == '8' ) 
                            selected 
                        @endif>WITA - Asia/Makassar (UTC +08:00)</option>
                    <option value="9" 
                        @if ( $val['time_zone_utc'] == '9' ) 
                            selected 
                        @endif>WIT - Asia/Jayapura (UTC +09:00)</option>
                </select>
            </div>
        </div>
        --}}
        <!--<div class="form-group">
            <div class="input-icon right">
                <label class="col-md-3 control-label">
                Deep Link Gojek
                <i class="fa fa-question-circle tooltips" data-original-title="Deep link gojek" data-container="body"></i>
                </label>
            </div>
            <div class="col-md-9">
                <input type="text" class="form-control" name="deep_link_gojek" value="{{ $val['deep_link_gojek'] }}" placeholder="Deep link gojek">
            </div>
        </div>

        <div class="form-group">
            <div class="input-icon right">
                <label class="col-md-3 control-label">
                Deep Link Grab
                <i class="fa fa-question-circle tooltips" data-original-title="Deep link grab" data-container="body"></i>
                </label>
            </div>
            <div class="col-md-9">
                <input type="text" class="form-control" name="deep_link_grab" value="{{ $val['deep_link_grab'] }}" placeholder="Deep link grab">
            </div>
        </div>-->

        @if(MyHelper::hasAccess([96], $configs))
        <div class="form-group">
            <div class="input-icon right">
                <label class="col-md-3 control-label">
                Delivery Order
                <i class="fa fa-question-circle tooltips" data-original-title="Jika diaktifkan, maka halaman detail outlet di aplikasi akan menampilkan ketersediaan delivery order untuk outlet" data-container="body"></i>
                </label>
            </div>
            <div class="col-md-9">
                <input type="checkbox" name="delivery_order" @if(old('delivery_order',$val['delivery_order']) == '1') checked @endif  class="make-switch switch-change" data-size="small" data-on-text="Active" data-off-text="Inactive" value="1">
            </div>
        </div>
        @endif

        <div class="form-group">
            <div class="input-icon right">
                <label class="col-md-3 control-label">
                    Plastic Status
                    <i class="fa fa-question-circle tooltips" data-original-title="Jika diaktifkan, maka halaman checkout pada aplikasi akan menampilkan informasi harga plastik" data-container="body"></i>
                </label>
            </div>
            <div class="col-md-9">
                <input type="checkbox" name="plastic_used_status" @if(old('plastic_used_status',$val['plastic_used_status']) == 'Active') checked @endif  class="make-switch switch-change" data-size="small" data-on-text="Active" data-off-text="Inactive" value="Active">
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-3 control-label">
                Photo Detail<span class="required" aria-required="true">* <br>(720*360) </span>
                <i class="fa fa-question-circle tooltips" data-original-title="Gambar Outlet Detail" data-container="body"></i>
            </label>
            <div class="col-md-8">
                <div class="fileinput fileinput-new" data-provides="fileinput">
                    <div class="fileinput-new thumbnail" style="width: 200px; height: 100px;">
                        <img src="@if(isset($val['outlet_image'])){{$val['outlet_image']}}@endif" alt="">
                    </div>
                    <div class="fileinput-preview fileinput-exists thumbnail" id="outletImageDetail" style="max-width: 200px; max-height: 100px;"></div>
                    <div>
                        <span class="btn default btn-file">
                        <span class="fileinput-new"> Select image </span>
                        <span class="fileinput-exists"> Change </span>
                        <input type="file" class="filePhotoDetail" id="fieldphoto" accept="image/*" name="outlet_image" @if(empty($val['outlet_image'])) required @endif>
                        </span>

                        <a href="javascript:;" id="removeImage" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                    </div>
                </div>
            </div>
        </div>

        @foreach($delivery as $dev)
            <div class="form-group">
                <div class="input-icon right">
                    <label class="col-md-3 control-label">
                        {{$dev['delivery_name']}}
                    </label>
                </div>
                <div class="col-md-2">
                    <?php
                    $key = array_search($dev['code'], array_column($val['delivery_outlet'],'code'));
                    $checked = '';
                    if($key === false){
                        $checked = 'checked';
                    }else if($val['delivery_outlet'][$key]['show_status'] == 1){
                        $checked = 'checked';
                    }
                    ?>
                    <input type="hidden" name="delivery_outlet[{{$dev['code']}}][show_status]" value="0">
                    <input type="checkbox" name="delivery_outlet[{{$dev['code']}}][show_status]" class="make-switch brand_visibility" data-size="small" data-on-color="info" data-on-text="Show" data-off-color="default" data-off-text="Hide" value="1" {{$checked}}>
                </div>
                <div class="col-md-3">
                    <?php
                        $key = array_search($dev['code'], array_column($val['delivery_outlet'],'code'));
                        $checked = '';
                        if($key === false){
                            $checked = 'checked';
                        }else if($val['delivery_outlet'][$key]['available_status'] == 1){
                            $checked = 'checked';
                        }
                    ?>
                    <input type="hidden" name="delivery_outlet[{{$dev['code']}}][available_status]" value="0">
                    <input type="checkbox" name="delivery_outlet[{{$dev['code']}}][available_status]" class="make-switch brand_visibility" data-size="small" data-on-color="info" data-on-text="Enable" data-off-color="default" data-off-text="Disable" value="1" {{$checked}}>
                </div>
            </div>
        @endforeach

        <hr>
        <h4>Maps</h4>

        <div class="form-group">
            <label class="col-md-3 control-label">Latitude</label>
            <div class="col-md-9">
                <input type="text" class="form-control latlong" name="outlet_latitude" value="{{ $val['outlet_latitude'] }}" id="lat">
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-3 control-label">Longitude</label>
            <div class="col-md-9">
                <input type="text" class="form-control latlong" name="outlet_longitude" value="{{ $val['outlet_longitude'] }}" id="lng">
            </div>
        </div>

        <div class="form-group">
            <label for="multiple" class="control-label col-md-3"></label>
            <div class="col-md-9">
                <input id="pac-input" class="controls" type="text" placeholder="Enter a location" style="padding:10px;width:70%" onkeydown="if (event.keyCode == 13) return false;">
                <div id="map-canvas" style="width:900;height:380px;"></div>
            </div>
        </div>

    </div>
    <div class="form-actions">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-md-offset-3 col-md-9">
                @if(MyHelper::hasAccess([27], $grantedFeature))
                    <button type="submit" class="btn green">Submit</button>
                @endif
                <input type="hidden" name="id_city" id="id_city" value="{{ $val['city']['id_city'] }}">
                <input type="hidden" name="id_outlet" value="{{ $val['id_outlet'] }}">
                <!-- <button type="button" class="btn default">Cancel</button> -->
            </div>
        </div>
    </div>
    @endforeach
</form>