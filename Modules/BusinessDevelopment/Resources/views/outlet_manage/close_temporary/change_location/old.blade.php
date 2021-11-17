<?php
use App\Lib\MyHelper;
$grantedFeature     = session('granted_features');
?>
@php
    $datenow = date("Y-m-d H:i:s");
@endphp
    <form class="form-horizontal" role="form" action="" method="post" enctype="multipart/form-data">
            <div class="portlet light" style="margin-bottom: 0; padding-bottom: 0">
                <div class="portlet-title">
                    <div class="caption">
                        <span class="caption-subject sbold uppercase font-black">Old Location</span>
                    </div>
                </div>
                    <div class="form-body">                        
                        <div class="form-group">
                            <label for="example-search-input" class="control-label col-md-4">Location Name</label>
                            <div class="col-md-5">
                                <input disabled class="form-control" type="text" id="input-name-location" name="nameLocation" value="{{$result['lokasi_old']['name']}}" placeholder="Enter location name here"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="example-search-input" class="control-label col-md-4">Location Mall</label>
                            <div class="col-md-5">
                                <input disabled class="form-control" type="text" id="input-name-location" name="nameLocation" value="{{$result['lokasi_old']['mall']}}" placeholder="Enter location name here"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="example-search-input" class="control-label col-md-4">Location Address </label>
                            <div class="col-md-5">
                                <textarea disabled name="addressLocation" id="input-address-location" class="form-control" placeholder="Enter location name here">{{$result['lokasi_old']['address']}}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="example-search-input" class="control-label col-md-4">Location City</label>
                            <div class="col-md-5">
                                <select disabled class="form-control select2" name="id_cityLocation" id="id_cityLocation" required>
                                    <option value="" selected disabled>Select City</option>
                                    @foreach($cities as $city)
                                        <option value="{{$city['id_city']}}" @if($result['lokasi_old']['id_city'] == $city['id_city']) selected @endif>{{$city['city_name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="example-search-input" class="control-label col-md-4">Brand</label>
                            <div class="col-md-5">
                                <select disabled class="form-control select2" name="id_cityLocation" id="id_cityLocation" required>
                                    <option value="" selected disabled>Select City</option>
                                    @foreach($brands as $brand)
                                                <option value="{{$brand['id_brand']}}" @if($result['lokasi_old']['id_brand'] == $brand['id_brand']) selected @endif>{{$brand['name_brand']}}</option>
                                            @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="example-search-input" class="control-label col-md-4">Location Large</label>
                            <div class="col-md-5">
                                <input disabled class="form-control" type="text" id="input-latitude-location" name="latitudeLocation" value="{{$result['lokasi_old']['location_large']}}" placeholder="Enter location name here"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="example-search-input" class="control-label col-md-4">Location Latitude</label>
                            <div class="col-md-5">
                                <input disabled class="form-control" type="text" id="input-latitude-location" name="latitudeLocation" value="{{$result['lokasi_old']['latitude']}}" placeholder="Enter location name here"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="example-search-input" class="control-label col-md-4">Location Longitude</label>
                            <div class="col-md-5">
                                <input disabled class="form-control" type="text" id="input-longitude-location" name="longitudeLocation" value="{{$result['lokasi_old']['longitude']}}" placeholder="Enter location name here"/>
                            </div>
                        </div>
                        
                    </div>
            </div>
    </form>